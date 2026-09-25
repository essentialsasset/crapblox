<?php
namespace Crapblox\Models;

class TwentySixteen extends ModelBase {
    public function Balance() {
        die(json_encode((object) [
            "robux" => 69,
            "tickets" => 420,
        ]));
    }

    public function EcoStatus() {
        die(json_encode((object) [
            "robux" => 69,
            "tickets" => 420,
            "isMarketplaceEnabled" => true,
            "isDeveloperProductPurchaseEnabled" => true,
            "areInAppPurchasesEnabled" => true,
        ]));
    }

    public function RenderTest() {
        $Thumbnail = @file_get_contents("http://192.168.1.15/API/Update/3DRender/1");
        $MTL = @file_get_contents("http://192.168.1.15/API/Update/3DRender/1?mtl=true");

        echo $this->Twig->render('3D.twig', array(
            "Thumbnail" => $Thumbnail,
            "MTL" => $MTL,
        ));
    }

    public function IfOwner($UserID, $PlaceID) {
        $Logger = new \Crapblox\Models\Log();
        $Logger->Log("userid" . $UserID . " placeid " . $PlaceID . " (canmanage)");

        $Game = new \Crapblox\Models\Games();
        $Game = $Game->GetGameByID($PlaceID);

        $User = new \Crapblox\Models\Auth\User(); 
        $User = $User->GetUserByUserID($UserID);

        $Response = (object)[
            "Success" => true,
            "CanManage" => false,
        ];

        if($User['roblox_username'] == $Game['server_owner']) {
            $Response->CanManage = true;
            die(json_encode($Response));
        } else {
            $Response->CanManage = false;
            die(json_encode($Response));
        }
    }

    function ValidateMachine()
    {
        die(json_encode((object) [
            "success" => true,
            "message" => "",
        ]));
    }

    function get_signature($script, $key)
    {
        $signature = "";
        openssl_sign($script, $signature, @file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/Models/" . $key), OPENSSL_ALGO_SHA1);
        return base64_encode($signature);
    }

    public function JoinTest() {
        header("Content-Type: text/plain");
        $id = rand(1, 5000);
        $user = 'Player' . $id;
        $ip = '127.0.0.1';
        $port = '25564';
        $capp = 'https://crapblox.com/v1.1/avatar-fetch/' . $id;
        $mship = '0';
        $pid = '1818';

        if(preg_match("/[a-z]/i", $mship)){
            $mship = 0;
        }
        if ($mship == null) {
            $mship = 0;
        }
        if ($mship > 3) {
            $mship = 0;
        }
        if(preg_match("/[a-z]/i", $id)){
            $id = "1";
        }
        if(preg_match("/[a-z]/i", $port)){
            $port = "53640";
        }

        // $ip = "192.168.1.15";
        //$ip = "192.168.1.9";
        $ip = "147.185.221.211";
        $port = 64210;

        // Construct joinscript
        $joinscript = [
            "ClientPort" => 0,
            "MachineAddress" => $ip,
            "ServerPort" => $port,
            "PingUrl" => "",
            "PingInterval" => 20,
            "UserName" => $user,
            "SeleniumTestMode" => false,
            "UserId" => $id,
            "SuperSafeChat" => false,
            "CharacterAppearance" => $capp,
            "ClientTicket" => "",
            "GameId" => 1818,
            "PlaceId" => $pid,
            "MeasurementUrl" => "", // No telemetry here :)
            "WaitingForCharacterGuid" => "26eb3e21-aa80-475b-a777-b43c3ea5f7d2",
            "BaseUrl" => "https://crapblox.com/",
            "ChatStyle" => "BubbleAndClassic",
            "VendorId" => "0",
            "ScreenShotInfo" => "",
            "VideoInfo" => "",
            "CreatorId" => 1,
            "CreatorTypeEnum" => "User",
            "MembershipType" => "None",
            "AccountAge" => "3000000",
            "CookieStoreFirstTimePlayKey" => "rbx_evt_ftp",
            "CookieStoreFiveMinutePlayKey" => "rbx_evt_fmp",
            "CookieStoreEnabled" => true,
            "IsRobloxPlace" => true,
            "GenerateTeleportJoin" => false,
            "IsUnknownOrUnder13" => false,
            "SessionId" => "39412c34-2f9b-436f-b19d-b8db90c2e186|00000000-0000-0000-0000-000000000000|0|$ip|8|2021-03-03T17:04:47+01:00|0|null|null",
            "DataCenterId" => 0,
            "UniverseId" => 3,
            "BrowserTrackerId" => 0,
            "UsePortraitMode" => false,
            "FollowUserId" => 0,
            "characterAppearanceId" => 1
        ];

        // Encode it!
        $data = json_encode($joinscript, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

        // Sign joinscript
        $signature = $this->get_signature("\r\n" . $data, "/PrivateKey.pem");

        // exit
        exit("--rbxsig%". $signature . "%\r\n" . $data);
    }

    public function JoinServer() {
        header("Content-Type: text/plain");

        $Auth = new Auth\User();
        $Game = new \Crapblox\Models\Games();

        $Game = $Game->GetGameByID($_GET['PlaceId']);
        $User = $Auth->GetUserByToken($_GET['Token']);
        $Owner = $Auth->GetUserByUsername($Game['server_owner']);

        $user = ($User['roblox_username']) ?? 'Player';
        $port = ($Game['server_port']) ?? '53640';
        $id = ($User['id']) ?? rand(1, 5000);
        $capp = 'https://crapblox.com/v1.1/avatar-fetch/' . $id;
        $mship = ($_GET["mship"]) ?? '0';
        $pid = ($Game['id']) ?? '';

        $BanSearch = $this->Connection->prepare("SELECT id FROM bans WHERE ban_user = :user LIMIT 1");
        $BanSearch->bindParam(":user", $User['roblox_username']);
        $BanSearch->execute();
        $BannedUser = $BanSearch->fetch();
        if (isset($BannedUser['id'])) {
            die("");
        }

        // Throw off people trying to join private games
        if ($Game['server_allowed'] == 'Private' && $Game['server_owner'] != $id)
            $port = rand(40000,50000);

        if(preg_match("/[a-z]/i", $mship)){
            $mship = 0;
        }
        if ($mship == null) {
            $mship = 0;
        }
        if ($mship > 3) {
            $mship = 0;
        }
        if(preg_match("/[a-z]/i", $id)){
            $id = "1";
        }
        if(preg_match("/[a-z]/i", $port)){
            $port = "53640";
        }

        $ip = "51.79.82.198";

        /*
         * Create first pre-signed signature
         * userid
         * newline
         * username
         * newline
         * charapp url
         * newline
         * jobid
         * newline
        */

        /*
         * Create second pre-signed signature
         * userid
         * newline
         * jobid
         * newline
        */

        // THanks Itteh
        $Timestamp = strval(time());
        $PreSig1 = $id . "\n" . $User['roblox_username'] . "\n" . "https://crapblox.com/v1.1/avatar-fetch/" . $id . "\n" . $Game['id'] . "\n" . $Timestamp;
        $PreSig2 = $id . "\n" . $Game['id'] . "\n" . $Timestamp;

        $tosign = $id . "\n" . $User['roblox_username'] . "\n" . "https://crapblox.com/v1.1/avatar-fetch/" . $id . "\n" . $Game['id'] . "\n" . $Timestamp;
        $tosign2 = $id . "\n" . $Game['id'] . "\n" . $Timestamp;
        openssl_sign($tosign, $sig, @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Models/PrivateKey.pem"), OPENSSL_ALGO_SHA1);
        openssl_sign($tosign2, $sig2, @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Models/PrivateKey.pem"), OPENSSL_ALGO_SHA1);
        $ticket = $Timestamp . ';' . base64_encode($sig) . ';' . base64_encode($sig2);

        $Logger = new \Crapblox\Models\Log();
        $Logger->Log("**" . $User['roblox_username'] . " / uid " . $id . "** joined game " . $Game["id"]);

        // Construct joinscript
        $joinscript = [
            "ClientPort" => 0,
            "MachineAddress" => $ip,
            "ServerPort" => $port,
            "PingUrl" => "",
            "PingInterval" => 20,
            "UserName" => $user,
            "SeleniumTestMode" => false,
            "UserId" => $id,
            "SuperSafeChat" => false,
            "CharacterAppearance" => $capp,
            "ClientTicket" => $ticket,
            "GameId" => 3,
            "PlaceId" => $pid,
            "MeasurementUrl" => "", // No telemetry here :)
            "WaitingForCharacterGuid" => "26eb3e21-aa80-475b-a777-b43c3ea5f7d2",
            "BaseUrl" => "https://crapblox.com/",
            "ChatStyle" => $Game['server_chatstyle'],
            "VendorId" => "0",
            "ScreenShotInfo" => "",
            "VideoInfo" => "",
            "CreatorId" => $Owner['id'],
            "CreatorTypeEnum" => "User",
            "MembershipType" => "None",
            "AccountAge" => "3000000",
            "CookieStoreFirstTimePlayKey" => "rbx_evt_ftp",
            "CookieStoreFiveMinutePlayKey" => "rbx_evt_fmp",
            "CookieStoreEnabled" => true,
            "IsRobloxPlace" => true,
            "GenerateTeleportJoin" => false,
            "IsUnknownOrUnder13" => false,
            "SessionId" => "39412c34-2f9b-436f-b19d-b8db90c2e186|00000000-0000-0000-0000-000000000000|0|$ip|8|2021-03-03T17:04:47+01:00|0|null|null",
            "DataCenterId" => 0,
            "UniverseId" => 3,
            "BrowserTrackerId" => 0,
            "UsePortraitMode" => false,
            "FollowUserId" => 0,
            "characterAppearanceId" => 1
        ];

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

        // Encode it!
        $data = json_encode($joinscript, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

        // Sign joinscript
        $signature = $this->get_signature("\r\n" . $data, "/PrivateKey.pem");

        // exit
        exit("--rbxsig%". $signature . "%\r\n" . $data);
    }

    public function ChatFilter() {
        die(json_encode((object) [
            "ChatFilter" => "whitelist",
        ]));
    }

    public function LoadPlaceInfo() {
        if($_GET['PlaceId']) {
            header("Content-type: text-plain");

            $Game = new \Crapblox\Models\Games();
            $Game = $Game->GetGameByID($_GET['PlaceId']);

            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($Game['server_owner']);

            $Game['server_owner_id'] = $User['id'];

            ob_start();
            echo $this->Twig->render('Game/PlaceInfo.twig', array(
                "Game"        => $Game,
            ));

            $data = ob_get_clean();
            $Signer = new \Crapblox\Models\Games();
            echo $Signer->SignScript($data);
        }
    }

    public function replaceWithCase($source, $replacement, $string, $pos = 0) {

        while (($pos = strpos(strtolower($string), strtolower($source), $pos))!== false) {
            $substr = mb_substr($string, $pos, strlen($source));
            $remaining = mb_substr($string, $pos + strlen($source));

            if (ctype_upper($substr)) {
                $string = substr_replace($string,strtoupper($replacement),$pos,strlen($source));
                continue;
            }

            $substrParts = preg_split('//u', $substr, null, PREG_SPLIT_NO_EMPTY);
            $replaceParts = preg_split('//u', $replacement, null, PREG_SPLIT_NO_EMPTY);
            $newWord = '';

            foreach ($replaceParts as $k => $rp) {
                if (array_key_exists($k,$substrParts))
                    $newWord .= ctype_upper($substrParts[$k]) ? mb_strtoupper($rp) : mb_strtolower($rp);
                else
                    $newWord .= $rp;
            }
            $string = substr_replace($string,$newWord,$pos,strlen($source));
            $pos = $pos + strlen($source);
        }

        return $string;
    }

    public function FilterText() {
        $Text = @$_POST['text'];
        // Horrid but works

        $Text = $this->replaceWithCase("nigga", "gentleman", $Text);
        $Text = $this->replaceWithCase("nigger", "gentlemon", $Text);
        $Text = $this->replaceWithCase("faggot", "I am an LGBTQ+ ally", $Text);
        $Text = $this->replaceWithCase("fag", "I am an LGBTQ+ ally", $Text);
        $Text = $this->replaceWithCase("furfag", "<3 furries", $Text);
        $Text = $this->replaceWithCase("trannie", "I am an LGBTQ+ ally", $Text);
        $Text = $this->replaceWithCase("tranny", "I am an LGBTQ+ ally", $Text);
        $Text = $this->replaceWithCase("troon", "I am an LGBTQ+ ally", $Text);
        $Text = $this->replaceWithCase("beaner", "mexican", $Text);
        $Text = $this->replaceWithCase("chink", "chinese", $Text);

        die(json_encode((object) [
            "data" => [
                "white" => @$Text,
                "black" => @$Text
            ]
        ]));
    }

    public function ValidateJoin() {
        header("Content-Type: text/plain");
        die("true");
    }

    public function HasAsset() {
        header("Content-Type: text/plain");
        die("false");
    }
}