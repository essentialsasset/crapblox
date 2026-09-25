<?php
namespace Crapblox\Models;

class Games extends \Crapblox\Models\ModelBase {
    public function RandomToken(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    public function Create() {
        $Validation = $this->Validator->make($_POST, [
            'chatstyle'                 => 'required',
            'title'                     => 'required|min:4|max:30',
            'description'               => 'required|min:3|max:400',
            'category'                  => 'required',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /Create/Game");
            die();
        } else {
            $Categories = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];
            $ChatEnum = ["Classic", "Bubble", "ClassicAndBubble"];
            $AccessLevel = ["Everyone", "Friends Only", "Private", "Unlisted"];

            if($_POST['maxplayers'] > 1000 || $_POST['maxplayers'] <= 0) {
                $_SESSION['Errors'] = ['Invalid player count. Please try again.'];
                header("Location: /Create/Game");
                die();
            }

            if(!isset($_SESSION['Roblox'])) {
                $_SESSION['Errors'] = ['You are not logged in.'];
                header("Location: /Create/Game");
                die();
            }

            $_POST['ip'] = "127.0.0.1";
            $_POST['port'] = "53640";

            if (!filter_var($_POST['ip'], FILTER_VALIDATE_IP)) {
                if (!str_contains($_POST['ip'], "playit.gg")) {
                    $_SESSION['Errors'] = ['Your IP is invalid.'];
                    header("Location: /Create/Game");
                    die();
                }
            }

            if(isset($_POST['groupid'])) {
                $Group = new \Crapblox\Models\Group();
                $Group = $Group->GetGroupByID((int)$_POST['groupid']);

                if($Group['group_owner'] != $_SESSION['Roblox']) {
                    $_SESSION['Errors'] = ['You don\'t own this group.'];
                    header("Location: /Create/Game?GroupID=" . $_POST['groupid']);
                    die();
                }
            }

            if(isset($_SESSION["Admin"]) && $_SESSION["Admin"] == "y")
            {
                // no cooldown for you
            }
            else
            {
                $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_servercooldown >= NOW() - INTERVAL 1 HOUR");
                $stmt->bindParam(":username", $_SESSION['Roblox']);
                $stmt->execute();
                if($stmt->rowCount() === 1) {
                    $_SESSION['Errors'] = ['Wait an hour to create another game.'];
                    header("Location: /Create/Game");
                    die();
                }
            }

            if(isset($_FILES['place']) && $_FILES['place']['name'] != "") {
                $mime_type = mime_content_type($_FILES['place']['tmp_name']);

                $ff = ["rbxl"];
                $f = pathinfo($_FILES['place']["name"], PATHINFO_EXTENSION);

                $XML = new \Crapblox\Models\Asset();

                //if (!$XML->isXMLFileValid($_FILES['place']["tmp_name"])) {
                //    $_SESSION['Errors'] = ['Places can only be an rbxl.'];
                //    header("Location: /Create/Game");
                //    die();
                //}

                if(!in_array($f, $ff)) {
                    $_SESSION['Errors'] = ['Place can only be .rbxl'];
                    header("Location: /Create/Game");
                    die();
                }

                if ($_FILES["place"]["size"] > 50000000) {
                    $_SESSION['Errors'] = ['Place too big bro'];
                    header("Location: /Create/Game");
                    die();
                }
            }

            if(!in_array($_POST['category'], $Categories)) {
                $_SESSION['Errors'] = ['Your category does not exist.'];
                header("Location: /Create/Game");
                die();
            }

            if(!in_array($_POST['chatstyle'], $ChatEnum)) {
                $_SESSION['Errors'] = ['Your chat Enum does not exist.'];
                header("Location: /Create/Game");
                die();
            }

            if(!in_array($_POST['accesslevel'], $AccessLevel)) {
                $_SESSION['Errors'] = ['Your access Enum does not exist.'];
                header("Location: /Create/Game");
                die();
            }

            $stmt = $this->Connection->prepare("UPDATE users SET roblox_servercooldown = NOW() WHERE roblox_username = ?");
            $res = $stmt->execute([ $_SESSION['Roblox'] ]);
            $Token = $this->RandomToken();

            if(!isset($_POST['groupid'])) {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO servers 
                    (server_allowed, server_max_players, server_title, server_description, server_owner, server_category, server_token, server_ip, server_chatstyle, server_port) 
                 VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->execute([
                    $_POST['accesslevel'],
                    $_POST['maxplayers'],
                    $_POST['title'],
                    $_POST['description'],
                    $_SESSION['Roblox'],
                    $_POST['category'],
                    $Token,
                    $_POST['ip'],
                    $_POST['chatstyle'],
                    $_POST['port'],
                ]);
            } else {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO servers 
                    (server_title, server_description, server_owner, server_category, server_token, server_ip, server_chatstyle, server_port, server_group) 
                 VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->execute([
                    $_POST['title'],
                    $_POST['description'],
                    $_SESSION['Roblox'],
                    $_POST['category'],
                    $Token,
                    $_POST['ip'],
                    $_POST['chatstyle'],
                    $_POST['port'],
                    $_POST['groupid'],
                ]);
            }

            $Game = new \Crapblox\Models\Games();
            $Game = $Game->GetGameByToken($Token);

            if(isset($_FILES['place']) && $_FILES['place']['name'] != "") {
                $f = "rbxl";
                move_uploaded_file($_FILES['place']["tmp_name"], "/var/www/volumes/PlaceFiles/" . $Game['id'] . "." . strtolower($f));
            }

            header("Location: /Games/");
        }
    }

    function SignScript($Script) {
        // Init vars
        $Sig; $Prefix = "";

        // Makes a new line for new room
        $Script = "\r\n" . $Script;

        // Newer sig format uses rbxsig to make it more readable
        $Prefix = "--rbxsig";

        // Sign the script and put the result in a var
        openssl_sign($Script, $Sig, @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Models/PrivateKey.pem"));

        // Format the signature accordingly with the prefix and script
        $Prefix .= "%".base64_encode($Sig)."%";
        $Script = $Prefix . $Script;

        // Now we can return the script
        return $Script;
    }

    public function GameInfo($GameID) {
        $Game = $this->GetGameByID($GameID);
        if(isset(
            $_GET['t']) &&
            $_GET['t'] == "uB5u3llM3zmVBsoSwOuhvcAUvqXpcUNrs5BSt7ZD" &&
            ($_SERVER['HTTP_CF_CONNECTING_IP'] == "51.79.82.198" ||
            $_SERVER['HTTP_CF_CONNECTING_IP'] == "71.58.85.190" ||
            $_SERVER['HTTP_CF_CONNECTING_IP'] == "fe80::d250:99ff:fed4:f49f"
            )
        ) {
            $Owner = new \Crapblox\Models\Auth\User();
            $Owner = $Owner->GetUserByUsername($Game['server_owner']);

            $Game['server_owner_id'] = $Owner['id'];

            header("Content-type: application/json");
            die(json_encode($Game));
        } else {
            die($_SERVER['HTTP_CF_CONNECTING_IP']);
        }
    }

    function LikeGame($GameID) {
        $gameID = $GameID;

        echo "a";

        $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_cooldown >= NOW() - INTERVAL 1 MINUTE");
        $stmt->bindParam(":username", $_SESSION['Roblox']);
        $stmt->execute();
        if($stmt->rowCount() === 1) {
            $_SESSION['Errors'] = ['Wait a minute to like this game again.'];
            header("Location: /Game/" . $GameID);
            exit;
        }
        /* Create a form handler class... This is extremely ugly */

        $GameSearch = $this->Connection->prepare("SELECT * FROM servers WHERE id = :id LIMIT 1");
        $GameSearch->bindParam(":id", $gameID);
        $GameSearch->execute();
        $Game = $GameSearch->fetch();
        if(!isset($Game['id'])) {
            header("Location: /Games");
        }

        $UserSearch = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :user LIMIT 1");
        $UserSearch->bindParam(":user", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $RatingSearch = $this->Connection->prepare("SELECT * FROM ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'l' LIMIT 1");
        $RatingSearch->bindParam(":rating_to", $gameID);
        $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
        $RatingSearch->execute();
        $Rating = $RatingSearch->fetch();

        if(!isset($Rating['id'])) {
            $RatingSearch = $this->Connection->prepare("SELECT * FROM ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'd' LIMIT 1");
            $RatingSearch->bindParam(":rating_to", $gameID);
            $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
            $RatingSearch->execute();
            $Rating = $RatingSearch->fetch();
            if(!isset($Rating['id'])) {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO ratings 
                (rating_to, rating_by, rating_type) 
             VALUES 
                (?, ?, 'l')"
                );
                $stmt->execute([
                    $gameID,
                    $_SESSION['Roblox'],
                ]);
            } else {
                $stmt = $this->Connection->prepare("DELETE FROM ratings WHERE rating_to = ? AND rating_by = ? AND rating_type = 'd'");
                $stmt->execute(
                    [
                        $gameID,
                        $_SESSION['Roblox'],
                    ]
                );
            }
        } else {
            $stmt = $this->Connection->prepare("DELETE FROM ratings WHERE rating_to = ? AND rating_by = ? AND rating_type = 'l'");
            $stmt->execute(
                [
                    $gameID,
                    $_SESSION['Roblox'],
                ]
            );
        }

        header("Location: /Game/" . $gameID);
    }

    function DislikeGame($GameID) {
        $gameID = $GameID;

        $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_cooldown >= NOW() - INTERVAL 1 MINUTE");
        $stmt->bindParam(":username", $_SESSION['roblox']);
        $stmt->execute();
        if($stmt->rowCount() === 1) {
            $_SESSION['Errors'] = ['Wait a minute to dislike this game again.'];
            header("Location: /Game/" . $GameID);
            exit;
        }
        /* Create a form handler class... This is extremely ugly */

        $GameSearch = $this->Connection->prepare("SELECT * FROM servers WHERE id = :id LIMIT 1");
        $GameSearch->bindParam(":id", $gameID);
        $GameSearch->execute();
        $Game = $GameSearch->fetch();
        if(!isset($Game['id'])) {
            header("Location: /Games");
        }

        $UserSearch = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :user LIMIT 1");
        $UserSearch->bindParam(":user", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $RatingSearch = $this->Connection->prepare("SELECT * FROM ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'l' LIMIT 1");
        $RatingSearch->bindParam(":rating_to", $gameID);
        $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
        $RatingSearch->execute();
        $Rating = $RatingSearch->fetch();

        if(!isset($Rating['id'])) {
            $RatingSearch = $this->Connection->prepare("SELECT * FROM ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'd' LIMIT 1");
            $RatingSearch->bindParam(":rating_to", $gameID);
            $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
            $RatingSearch->execute();
            $Rating = $RatingSearch->fetch();
            if(!isset($Rating['id'])) {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO ratings 
                (rating_to, rating_by, rating_type) 
             VALUES 
                (?, ?, 'd')"
                );
                $stmt->execute([
                    $gameID,
                    $_SESSION['Roblox'],
                ]);
            } else {
                $stmt = $this->Connection->prepare("DELETE FROM ratings WHERE rating_to = ? AND rating_by = ? AND rating_type = 'd'");
                $stmt->execute(
                    [
                        $gameID,
                        $_SESSION['Roblox'],
                    ]
                );
            }
        } else {
            $stmt = $this->Connection->prepare("DELETE FROM ratings WHERE rating_to = ? AND rating_by = ? AND rating_type = 'l'");
            $stmt->execute(
                [
                    $gameID,
                    $_SESSION['Roblox'],
                ]
            );
        }

        header("Location: /Game/" . $gameID);
    }

    function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    function StartGame($PlaceID) {
        if(isset($_SESSION['Roblox'])) {
            $SOAP = new \Crapblox\Models\Arbiter();

            $Game = new \Crapblox\Models\Games();
            $Game = $Game->GetGameByID($PlaceID);

            $Author = new \Crapblox\Models\Auth\User();
            $Author = $Author->GetUserByUsername($Game['server_owner']);

            $port = rand(50000, 60000);

            // echo $SOAP->GetExpiration($PlaceID, "Game-" . $PlaceID);

            $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_placelaunchercooldown >= NOW() - INTERVAL 1 SECOND");
            $stmt->bindParam(":username", $_SESSION['Roblox']);
            $stmt->execute();
            if ($stmt->rowCount() === 1) {
                die("false");
            }

            $GameStarted = @file_get_contents("http://51.79.82.198:2757/game/running/" . $Game['id'] . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");
            //$JobRunning = @file_get_contents("http://51.79.82.198:2757/game/exists/" . $Game['server_token']);

            $stmt = $this->Connection->prepare("UPDATE users SET roblox_placelaunchercooldown = NOW() WHERE roblox_username = ?");
            $res = $stmt->execute([$_SESSION['Roblox']]);

            if ($GameStarted == "false") {
                $stmt = $this->Connection->prepare("SELECT * FROM servers WHERE id = :username AND server_started >= NOW() - INTERVAL 20 SECOND");
                $stmt->bindParam(":username", $PlaceID);
                $stmt->execute();
                if ($stmt->rowCount() === 1) {
                    die("false");
                }

                $stmt = $this->Connection->prepare("UPDATE servers SET server_started = NOW() WHERE id = ?");
                $stmt->execute([
                    $PlaceID,
                ]);

                $stmt = $this->Connection->prepare("UPDATE servers SET server_port = ? WHERE id = ?");
                $stmt->execute([
                    $port,
                    $PlaceID,
                ]);
                $stmt = null;

                @file_get_contents("http://51.79.82.198:2757/game/start/" . (int)$PlaceID . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");
                echo "false";
            } else {
                if($GameStarted == "true") { //&& $JobRunning == "true") {
                    @file_get_contents("http://51.79.82.198:2757/game/renew/" . $Game['id'] . "/360?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");
                    echo "true";
                } else {
                    echo "false";
                }
            }
        }
    }

    function ShutdownGame($PlaceID) {
        if(isset($_SESSION['Roblox'])) {
            $SOAP = new \Crapblox\Models\Arbiter();

            $Game = new \Crapblox\Models\Games();
            $Game = $Game->GetGameByID($PlaceID);

            $Author = new \Crapblox\Models\Auth\User();
            $Author = $Author->GetUserByUsername($Game['server_owner']);

            if($Author['roblox_username'] == $_SESSION['Roblox']) {
                @file_get_contents("http://51.79.82.198:2757/game/stop/" . $PlaceID . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");
                $_SESSION['Success'] = ['Successfully shut down game.'];
                header("Location: /Game/" . $Game['id']);
            } else {
                die("Insufficient permissions.");
            }
        }
    }

    public function DeleteGame($GameID) {
        $CatalogSearch = $this->Connection->prepare("SELECT * FROM servers WHERE id = :id LIMIT 1");
        $CatalogSearch->bindParam(":id", $GameID);
        $CatalogSearch->execute();
        $Item = $CatalogSearch->fetch();

        if(!isset($Item['id'])) {
            $_SESSION['Errors'] = ['Your game does not exist.'];
            header("Location: /Games/");
            die();
        }

        if(@$_SESSION['Roblox'] != $Item['server_owner'] && $_SESSION["Admin"] != "y") {
            $_SESSION['Errors'] = ['You do not own this game.'];
            header("Location: /Games/");
            die();
        }

        $Logger = new \Crapblox\Models\Log();
        $Logger->Log("**" . $_SESSION['Roblox'] . "** deleted gameid " . $GameID . " (" . $Item['server_title'] . ")");

        $stmt = $this->Connection->prepare("DELETE FROM servers WHERE id = ?");
        $stmt->execute(
            [$GameID]
        );

        $_SESSION['Success'] = ['Successfully deleted game.'];
        header("Location: /Games/");
        die();
    }

    public function KeepAlive() {
        if(!$this->isJson(@file_get_contents('php://input'))) {
            die("Malformed jSON Request. Try again.");
        } else {
            $PingerInfo = json_decode(@file_get_contents('php://input'));
        }

        $request = (object) [
            "server_ip"      => $PingerInfo->ServerIP,
            "place_id"       => @$PingerInfo->PlaceID,
            "player_list"   => $PingerInfo->PlayerList,
            "player_count"   => $PingerInfo->PlayerCount,
            "error"          => (object) [
                "message"    => "",
                "type"       => 0,
            ],
        ];

        $GameSearch = $this->Connection->prepare("SELECT * FROM servers WHERE server_token = :id LIMIT 1");
        $GameSearch->bindParam(":id", $request->server_ip);
        $GameSearch->execute();
        $Game = $GameSearch->fetch();
        /* Create a form handler class... This is extremely ugly */

        if($request->error->message == "") {
            $stmt = $this->Connection->prepare("UPDATE servers SET server_player_list = ?, server_players = ?, server_ping = NOW() WHERE id = ?");
            $stmt->execute([
                $request->player_list,
                $request->player_count,
                $request->server_ip,
            ]);
            $stmt = null;
        } else {
            die($request->error->message);
        }
    }

    public function Visit() {
        header("Content-type: text-plain");
        ob_start();
        echo $this->Twig->render('Game/PlaySolo.twig', array(

        ));
        $data = ob_get_clean();
        echo $this->SignScript($data);
    }

    public function Host() {
        header("Content-type: text-plain");

        $Auth = new Auth\User();
        $Game = $this->GetGameByToken($_GET['Token']);
        $User = $Auth->GetUserByUsername($Game['server_owner']);

        ob_start();
        echo $this->Twig->render('Game/Hostscript.twig', array(
            "User"        => $User,
            "Game"        => $Game,
        ));

        $data = ob_get_clean();
        echo $this->SignScript($data);
    }

    public function GetAuthorInfo() {
        $Game = $this->GetGameByID($_GET['GameID']);
        die($Game['server_owner']);
    }

    public function ProductInfo() {
        $Auth = new Auth\User();


        $Game = $this->GetGameByID($_GET['assetId']);
        $User = $Auth->GetUserByUsername($Game['server_owner']);
/*
        $stmt = $this->Connection->prepare(
            "INSERT INTO visits
                (visit_game, visit_by)
             VALUES
                (?, ?)"
        );
        $stmt->execute([
            $Game['id'],
            $User['roblox_username'],
        ]);
*/

        $result = json_encode(
            array(
                "TargetId" => $Game['id'],
                "ProductType" => "Game",
                "AssetId" => $Game['id'],
                "ProductId" => null,
                "Name" => $Game['server_title'],
                "Description" => $Game['server_description'],
                "AssetTypeId" => 2,
                "Creator" => array(
                    "Id" => $User['id'],
                    "Name" => $User['roblox_username'],
                    "CreatorType" => "User",
                    "CreatorTargetId" => $User['id'],
                ),
                "IconImageAssetId" => $Game['id'],
                "Created" => $Game['server_created'],
                "Updated" => $Game['server_ping'],
                "PriceInRobux" => 0,
                "PriceInTickets" => null,
                "IsNew" => false,
                "IsForSale" => true,
                "IsPublicDomain" => false,
                "IsLimited" => false,
                "IsLimitedUnique" => false,
                "Remaining" => null,
                "MinimumMembershipLevel" => 0
            )
        );

        die($result);
    }

    public function GetName() {
        $Game = $this->GetGameByID($_GET['GameID']);
        die($Game['server_title']);
    }

    public function Join() {
        header("Content-type: text-plain");

        $Auth = new Auth\User();
        $Game = $this->GetGameByID($_GET['PlaceId']);
        $User = $Auth->GetUserByToken($_GET['Token']);

        $stmt = $this->Connection->prepare(
            "INSERT INTO visits 
            (visit_game, visit_by) 
         VALUES 
            (?, ?)"
        );
        $stmt->execute([
            $Game['id'],
            $User['roblox_username'],
        ]);

        ob_start();
        echo $this->Twig->render('Game/Joinscript.twig', array(
            "User"        => $User,
            "Game"        => $Game,
        ));

        $data = ob_get_clean();
        echo $this->SignScript($data);
    }

    public function Studio() {
        $stmt = $this->Connection->prepare(
            "INSERT INTO visits 
                (visit_game, visit_by) 
             VALUES 
                (?, ?)"
        );

        header("Content-type: text-plain");
        ob_start();
        echo $this->Twig->render('Game/StudioAshx.twig', array());

        $data = ob_get_clean();
        echo $this->SignScript($data);
    }

    public function GameServer() {
        header("Content-type: text-plain");
        ob_start();
        echo $this->Twig->render('Game/GameServer.twig', array());

        $data = ob_get_clean();
        echo $this->SignScript($data);
    }

    public function TestJoin() {
        header("Content-type: text-plain");
        ob_start();
        echo $this->Twig->render('Game/2013Join.twig', array());

        $data = ob_get_clean();
        echo $this->SignScript($data);
    }

    public function FavoriteGame($GameID) {
        if($this->GameExists($GameID)) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($_SESSION['Roblox']);

            $FavoriteSearch = $this->Connection->prepare("SELECT * FROM favorites WHERE favorite_to = :to AND favorite_by = :by LIMIT 1");
            $FavoriteSearch->bindParam(":to", $GameID);
            $FavoriteSearch->bindParam(":by", $_SESSION['Roblox']);
            $FavoriteSearch->execute();
            $Favorite = $FavoriteSearch->fetch();

            if (!isset($Favorite['id'])) {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO favorites
                        (favorite_to, favorite_by) 
                    VALUES 
                        (?, ?)"
                );
                $stmt->execute([
                    $GameID,
                    $_SESSION['Roblox'],
                ]);
            } else {
                $stmt = $this->Connection->prepare("DELETE FROM favorites WHERE favorite_to = ? AND favorite_by = ?");
                $stmt->execute(
                    [
                        $GameID,
                        $_SESSION['Roblox'],
                    ]
                );
            }
        }

        header("Location: /Game/" . $GameID);
    }

    public function EditThumbnail($GameID) {
        $Game = $this->GetGameByID($GameID);
        if($this->GameExists($GameID) && $Game['server_owner'] == $_SESSION['Roblox']) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($_SESSION['Roblox']);

            if(isset($_FILES['thumbnail_1']) && $_FILES['thumbnail_1']['name'] != "") {
                $mime_type = mime_content_type($_FILES['thumbnail_1']['tmp_name']);
                $allowed_file_types = ['image/png', 'image/jpeg'];

                $ff = ["png"];
                $f = pathinfo($_FILES['thumbnail_1']["name"], PATHINFO_EXTENSION);

                if (!in_array($mime_type, $allowed_file_types)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if(!in_array($f, $ff)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if(!exif_imagetype($_FILES['thumbnail_1']["tmp_name"])) {
                    $_SESSION['Errors'] = ['Thumbnails invalid'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if ($_FILES["thumbnail_1"]["size"] > 50000000) {
                    $_SESSION['Errors'] = ['Thumbnails too big bro'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                $stmt = $this->Connection->prepare("UPDATE servers SET use_thumbnail = 'y' WHERE id = ?");
                $stmt->execute([
                    $Game['id'],
                ]);
                move_uploaded_file($_FILES['thumbnail_1']["tmp_name"], "/var/www/volumes/Games/" . $Game['id'] . "." . strtolower($f));
            }

            if(isset($_FILES['thumbnail_2']) && $_FILES['thumbnail_2']['name'] != "") {
                $mime_type = mime_content_type($_FILES['thumbnail_2']['tmp_name']);
                $allowed_file_types = ['image/png', 'image/jpeg'];

                $ff = ["png"];
                $f = pathinfo($_FILES['thumbnail_2']["name"], PATHINFO_EXTENSION);

                if (!in_array($mime_type, $allowed_file_types)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if(!in_array($f, $ff)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if(!exif_imagetype($_FILES['thumbnail_2']["tmp_name"])) {
                    $_SESSION['Errors'] = ['Thumbnails invalid'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if ($_FILES["thumbnail_2"]["size"] > 50000000) {
                    $_SESSION['Errors'] = ['Thumbnails too big bro'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                $stmt = $this->Connection->prepare("UPDATE servers SET use_thumbnail = 'y' WHERE id = ?");
                $stmt->execute([
                    $Game['id'],
                ]);
                move_uploaded_file($_FILES['thumbnail_2']["tmp_name"], "/var/www/volumes/Games/" . $Game['id'] . "_2." . strtolower($f));
            }

            if(isset($_FILES['thumbnail_3']) && $_FILES['thumbnail_3']['name'] != "") {
                $mime_type = mime_content_type($_FILES['thumbnail_3']['tmp_name']);
                $allowed_file_types = ['image/png', 'image/jpeg'];

                $ff = ["png"];
                $f = pathinfo($_FILES['thumbnail_3']["name"], PATHINFO_EXTENSION);

                if (!in_array($mime_type, $allowed_file_types)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if(!in_array($f, $ff)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if(!exif_imagetype($_FILES['thumbnail_3']["tmp_name"])) {
                    $_SESSION['Errors'] = ['Thumbnails invalid'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if ($_FILES["thumbnail_3"]["size"] > 50000000) {
                    $_SESSION['Errors'] = ['Thumbnails too big bro'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                $stmt = $this->Connection->prepare("UPDATE servers SET use_thumbnail = 'y' WHERE id = ?");
                $stmt->execute([
                    $Game['id'],
                ]);
                move_uploaded_file($_FILES['thumbnail_3']["tmp_name"], "/var/www/volumes/Games/" . $Game['id'] . "_3." . strtolower($f));
            }

            if(isset($_FILES['thumbnail_4']) && $_FILES['thumbnail_4']['name'] != "") {
                $mime_type = mime_content_type($_FILES['thumbnail_4']['tmp_name']);
                $allowed_file_types = ['image/png', 'image/jpeg'];

                $ff = ["png"];
                $f = pathinfo($_FILES['thumbnail_4']["name"], PATHINFO_EXTENSION);

                if (!in_array($mime_type, $allowed_file_types)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if(!in_array($f, $ff)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if(!exif_imagetype($_FILES['thumbnail_4']["tmp_name"])) {
                    $_SESSION['Errors'] = ['Thumbnails invalid'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if ($_FILES["thumbnail_4"]["size"] > 50000000) {
                    $_SESSION['Errors'] = ['Thumbnails too big bro'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                $stmt = $this->Connection->prepare("UPDATE servers SET use_thumbnail = 'y' WHERE id = ?");
                $stmt->execute([
                    $Game['id'],
                ]);
                move_uploaded_file($_FILES['thumbnail_4']["tmp_name"], "/var/www/volumes/Games/" . $Game['id'] . "_4." . strtolower($f));
            }

            $stmt = $this->Connection->prepare("UPDATE servers   SET server_thumbnail_approve = 'n' WHERE id = ?");
            $stmt->execute([
                $Game['id']
            ]);

            $_SESSION['Success'] = ['Successfully updated game.'];
            header("Location: /Game/" . $Game['id']);
            die();
        }
    }

    public function EditGame($GameID) {
        $Game = $this->GetGameByID($GameID);
        if($this->GameExists($GameID) && $Game['server_owner'] == $_SESSION['Roblox']) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($_SESSION['Roblox']);

            $Categories = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];
            $ChatEnum = ["Classic", "Bubble", "ClassicAndBubble"];
            $AccessLevel = ["Everyone", "Friends Only", "Private", "Unlisted"];

            if(isset($_FILES['asset']) && $_FILES['asset']['name'] != "") {
                $mime_type = mime_content_type($_FILES['asset']['tmp_name']);
                $allowed_file_types = ['image/png', 'image/jpeg'];

                $ff = ["png"];
                $f = pathinfo($_FILES['asset']["name"], PATHINFO_EXTENSION);

                if (!in_array($mime_type, $allowed_file_types)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if(!in_array($f, $ff)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if(!exif_imagetype($_FILES['asset']["tmp_name"])) {
                    $_SESSION['Errors'] = ['Thumbnails invalid'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if ($_FILES["asset"]["size"] > 50000000) {
                    $_SESSION['Errors'] = ['Thumbnails too big bro'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }
            }

            if(isset($_FILES['place']) && $_FILES['place']['name'] != "") {
                $mime_type = mime_content_type($_FILES['place']['tmp_name']);

                $ff = ["rbxl"];
                $f = pathinfo($_FILES['place']["name"], PATHINFO_EXTENSION);

                //$XML = new \Crapblox\Models\Asset();

                //if (!$XML->isXMLFileValid($_FILES['place']["tmp_name"])) {
                //    $_SESSION['Errors'] = ['Places can only be an rbxl.'];
                //    header("Location: /Edit/Game/" . $Game['id']);
                //    die();
                //}

                if(!in_array($f, $ff)) {
                    $_SESSION['Errors'] = ['Place can only be .rbxl'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }

                if ($_FILES["place"]["size"] > 50000000) {
                    $_SESSION['Errors'] = ['Place too big bro'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }
            }

            if($_POST['maxplayers'] > 1000 || $_POST['maxplayers'] <= 0) {
                $_SESSION['Errors'] = ['Invalid player count. Please try again.'];
                header("Location: /Create/Game");
                die();
            }

            if(strlen(trim($_POST['description'])) > 500) {
                $_SESSION['Errors'] = ['Your description is too long.'];
                header("Location: /Edit/Game/" . $Game['id']);
                die();
            }

            if(!isset($_POST['description']) || empty(trim($_POST['description']))) {
                $_SESSION['Errors'] = ['Your description is empty.'];
                header("Location: /Edit/Game/" . $Game['id']);
                die();
            }

            $_POST['ip'] = "127.0.0.1";
            $_POST['port'] = "53640";

            if (!filter_var($_POST['ip'], FILTER_VALIDATE_IP)) {
                if (!str_contains($_POST['ip'], "playit.gg")) {
                    $_SESSION['Errors'] = ['Invalid hostname/IP address.'];
                    header("Location: /Edit/Game/" . $Game['id']);
                    die();
                }
            }

            if(!in_array($_POST['category'], $Categories)) {
                $_SESSION['Errors'] = ['Your category doesn\'t exist.'];
                header("Location: /Edit/Game/" . $Game['id']);
                die();
            }

            if(!in_array($_POST['chatstyle'], $ChatEnum)) {
                $_SESSION['Errors'] = ['Your chat enum doesn\'t exist.'];
                header("Location: /Edit/Game/" . $Game['id']);
                die();
            }

            if(!in_array($_POST['accesslevel'], $AccessLevel)) {
                $_SESSION['Errors'] = ['Your access enum doesn\'t exist.'];
                header("Location: /Edit/Game/" . $Game['id']);
                die();
            }

            if(isset($_FILES['asset']) && $_FILES['asset']['name'] != "") {
                $stmt = $this->Connection->prepare("UPDATE servers SET use_thumbnail = 'y' WHERE id = ?");
                $stmt->execute([
                    $Game['id'],
                ]);
                move_uploaded_file($_FILES['asset']["tmp_name"], "/var/www/volumes/Games/" . $Game['id'] . "." . strtolower($f));
            }

            if(isset($_FILES['place']) && $_FILES['place']['name'] != "") {
                move_uploaded_file($_FILES['place']["tmp_name"], "/var/www/volumes/PlaceFiles/" . $Game['id'] . "." . strtolower($f));
            }

            $stmt = $this->Connection->prepare("UPDATE servers SET server_max_players = ?, server_chatstyle = ?, server_allowed = ?, server_title = ?, server_description = ?, server_category = ?, server_ip = ?, server_port = ? WHERE id = ?");
            $stmt->execute([
                $_POST['maxplayers'],
                $_POST['chatstyle'],
                $_POST['accesslevel'],
                $_POST['title'],
                $_POST['description'],
                $_POST['category'],
                $_POST['ip'],
                $_POST['port'],
                $Game['id'],
            ]);
            $_SESSION['Success'] = ['Successfully updated game.'];
            header("Location: /Game/" . $Game['id']);
            die();
        }
    }

    public function GetGameByID($GameID) {
        $stmt = $this->Connection->prepare("SELECT * FROM servers WHERE id = :find");
        $stmt->bindParam(":find", $GameID);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function GetGameByTitle($ServerTitle) {
        $stmt = $this->Connection->prepare("SELECT * FROM servers WHERE server_title = :find");
        $stmt->bindParam(":find", $ServerTitle);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function GetGameByToken($Token) {
        $stmt = $this->Connection->prepare("SELECT * FROM servers WHERE server_token = :find");
        $stmt->bindParam(":find", $Token);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function GameExists($GameID) {
        $stmt = $this->Connection->prepare("SELECT id FROM servers WHERE id = :username");
        $stmt->bindParam(":username", $GameID);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }
}