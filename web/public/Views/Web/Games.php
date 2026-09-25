<?php
namespace Crapblox\Views;
use \Crapblox\Models\Auth;

class Games extends \Crapblox\Views\ViewBase {
    // https://stackoverflow.com/questions/14600639/replace-spaces-with-a-dash-in-a-url
    function formatUrl($str, $sep='-')
    {
        $res = $str;
        $res = preg_replace('/[^[:alnum:]]/', ' ', $res);
        $res = preg_replace('/[[:space:]]+/', $sep, $res);
        return trim($res, $sep);
    }

    public function EditThumbnails($GameID) {
        $Check = new \Crapblox\Models\Games();
        $Game = $Check->GetGameByID($GameID);
        if(isset($_SESSION['Roblox']) && $Check->GameExists($GameID) && $Game['server_owner'] == $_SESSION['Roblox']) {
            $Auth = new Auth\User();
            $Categories = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];
            $ChatEnum = ["Classic", "Bubble", "ClassicAndBubble"];
            $AccessLevel = ["Everyone", "Friends Only", "Private", "Unlisted"];

            echo $this->Twig->render('EditThumbnails.twig', array(
                "PageSettings" => $this->PageSettings(),
                "Author"       => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Categories"   => $Categories,
                "ChatEnum"     => $ChatEnum,
                "AccessLevel"  => $AccessLevel,
                "Game"         => $Game,
            ));
        } else {
            header("Location: /");
        }
    }

    public function View() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $Categories = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];

            $ItemsPerPage = 20;

            /*
            if(isset($_GET['page'])) {
                $Offset = ((int)$_GET['page'] * $ItemsPerPage) - $ItemsPerPage;
                $GameSearch = $this->Connection->prepare("SELECT * FROM servers WHERE server_allowed != 'Unlisted' ORDER BY server_ping DESC LIMIT " . $Offset . ",20");
            } else {
            }*/

            $GameSearch = $this->Connection->prepare("SELECT * FROM servers WHERE server_allowed != 'Unlisted' ORDER BY server_ping DESC");
            $GameSearch->execute();

            $GameSearchCount = $this->Connection->prepare("SELECT id FROM servers WHERE server_allowed != 'Unlisted'");
            $GameSearchCount->execute();

            $Catalog['rows'] = $GameSearchCount->rowCount();
            $Pages = ceil($Catalog['rows'] / $ItemsPerPage);

            while($Game = $GameSearch->fetch(\PDO::FETCH_ASSOC)) {
                $LastActive = strtotime($Game['server_ping']);
                $Now = strtotime("-10 minutes");
                if($Now > $LastActive) {
                    $Game['active'] = false;
                } else {
                    $Game['active'] = true;
                }

                /*
                $User = new \Crapblox\Models\Auth\User();
                $User = $User->GetIDByUsername($Game['server_owner']);
                $Game['profile_picture'] = $User['id'];

                if($Game['server_group'] != 0) {
                    $Group = new \Crapblox\Models\Group();
                    $Group = $Group->GetGroupByID($Game['server_group']);

                    if(isset($Group['id'])) {
                        $Game['group_title'] = $Group['group_title'];
                        $Game['group_id'] = $Group['id'];
                        $Game['group_created'] = $Group['group_created'];
                    } else {
                        $Game['server_group'] = 0;
                    }
                }*/

                $Game['server_url']     = "/" . $this->formatUrl($Game['server_title']) . "-place?id=" . $Game['id'];
                $Games[] = $Game;
            }

            $Games['rows'] = $GameSearch->rowCount();

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            echo $this->Twig->render('GamesFrontpage.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Games"        => @$Games,
                "Categories"   => $Categories,
                "Ad" => $Ad,
                "url" => "/Games/?page=",
                "total" => $Pages,
                "current" => $_GET['page'] ?? 1,
                "nearbyPagesLimit" => 4,
            ));
        } else {
            header("Location: /");
        }
    }

    public function CreateView() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $Categories = ["Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];
            $ChatEnum = ["Classic", "Bubble", "ClassicAndBubble"];
            $AccessLevel = ["Everyone", "Friends Only", "Private", "Unlisted"];

            echo $this->Twig->render('CreateGame.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Categories"   => $Categories,
                "AccessLevel"   => $AccessLevel,
                "ChatEnum"     => $ChatEnum,
            ));
        } else {
            header("Location: /");
        }
    }

    public function ViewCategory($Category) {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $Categories = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];

            if($Category != "All") {
                $GameSearch = $this->Connection->prepare("SELECT * FROM servers WHERE server_category = :category AND server_allowed != 'Unlisted' ORDER BY server_ping DESC LIMIT 30");
                $GameSearch->bindParam(":category", $Category);
                $GameSearch->execute();
            } else {
                $GameSearch = $this->Connection->prepare("SELECT * FROM servers WHERE server_allowed != 'Unlisted' ORDER BY id DESC LIMIT 30");
                $GameSearch->execute();
            }

            while($Game = $GameSearch->fetch(\PDO::FETCH_ASSOC)) {
                $Game['server_url']     = "/" . $this->formatUrl($Game['server_title']) . "-place?id=" . $Game['id'];
                $Games[] = $Game;
            }

            $Games['rows'] = $GameSearch->rowCount();

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            echo $this->Twig->render('Games.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Games" => $Games,
                "Categories" => $Categories,
                "Category" => $Category,
                "Ad" => $Ad,
            ));
        } else {
            header("Location: /");
        }
    }

    public function Search() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $Categories = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];

            if(isset($_GET['Search'])) {
                $search = "%" . $_GET['Search'] . "%";
            } elseif(isset($_GET['search'])) {
                $search = "%" . $_GET['search'] . "%";
            }
            $GameSearch = $this->Connection->prepare("SELECT * FROM servers WHERE concat(server_title, server_description, server_owner) LIKE lower(:search) AND server_allowed != 'Unlisted' ORDER BY RAND() LIMIT 50");
            $GameSearch->bindParam(':search', $search, \PDO::PARAM_STR);
            $GameSearch->execute();

            while($Game = $GameSearch->fetch(\PDO::FETCH_ASSOC)) {
                $LastActive = strtotime($Game['server_ping']);
                $Now = strtotime("-5 minutes");
                if($Now > $LastActive) {
                    $Game['active'] = false;
                } else {
                    $Game['active'] = true;
                }

                $Game['server_url']     = "/" . $this->formatUrl($Game['server_title']) . "-place?id=" . $Game['id'];
                $Games[] = $Game;
            }

            $Games['rows'] = $GameSearch->rowCount();

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            echo $this->Twig->render('Games.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Categories" => $Categories,
                "Category" => "Searching for \"" . $_GET['Search'] . "\"",
                "Ad" => $Ad,
                "Games" => $Games,
            ));
        } else {
            header("Location: /");
        }
    }

    public function Screenshot() {
        echo $this->Twig->render('Game/Screenshot.twig', array(

        ));
    }

    public function EditView($GameID) {
        $Check = new \Crapblox\Models\Games();
        $Game = $Check->GetGameByID($GameID);
        if(isset($_SESSION['Roblox']) && $Check->GameExists($GameID) && $Game['server_owner'] == $_SESSION['Roblox']) {
            $Auth = new Auth\User();
            $Categories = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];
            $ChatEnum = ["Classic", "Bubble", "ClassicAndBubble"];
            $AccessLevel = ["Everyone", "Friends Only", "Private", "Unlisted"];

            echo $this->Twig->render('EditGame.twig', array(
                "PageSettings" => $this->PageSettings(),
                "Author"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Categories"   => $Categories,
                "ChatEnum"     => $ChatEnum,
                "AccessLevel"     => $AccessLevel,
                "Game"         => $Game,
            ));
        } else {
            header("Location: /");
        }
    }

    public function DownloadGame($GameID) {
        $Game = new \Crapblox\Models\Games();
        $Game = $Game->GetGameByID($GameID);

        header("Content-type: text/plain");

        if(isset($_SESSION['Roblox']) && $_SESSION['Roblox'] == $Game['server_owner']) {
            header("Content-Description: File Transfer");
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"". $Game['id'] .".rbxl\"");
            die(@file_get_contents("/var/www/volumes/PlaceFiles/" . $Game['id'] . ".rbxl"));
        } else {
            die("Insufficient permissions.");
        }
    }

    public function LogoutAspx() {
        echo "Logout.aspx";
    }

    public function ViewPlace($GameID) {
        // die(gettype($GameID) . $GameID);

        if(!is_int($GameID)) { // Assume we're working with game title
            $Game      = new \Crapblox\Models\Games();
            $GameTitle = $GameID;
            $GameID    = (int)$_GET['id'];
            $Game      = $Game->GetGameByID($GameID);

            if(!isset($Game['id']))
                header("Location: /Games/");

            $URL       = "/" . $this->formatUrl($Game['server_title']) . "-place?id=" . $GameID;

            $Game['server_token'] = "";

            /*
            if(
                $this->formatUrl($Game['server_title']) !=
                str_replace(
                    "-place",
                    "",
                    $GameTitle
                )
            ) {
                header("Location: " . $URL);
            }*/

            $GameVal = new \Crapblox\Models\Games();
            $Auth = new Auth\User();
            $Categories = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];
            $Game = $GameVal->GetGameByID($GameID);
            $Author = $Auth->GetUserByUsername($Game['server_owner']);

            $RatingSearch = $this->Connection->prepare("SELECT id FROM ratings WHERE rating_type = 'l' AND rating_to = :rating_to");
            $RatingSearch->bindParam(":rating_to", $Game['id']);
            $RatingSearch->execute();
            $Game['rating_likes'] = $RatingSearch->RowCount();

            $RatingSearch = $this->Connection->prepare("SELECT id FROM ratings WHERE rating_type = 'd' AND rating_to = :rating_to");
            $RatingSearch->bindParam(":rating_to", $Game['id']);
            $RatingSearch->execute();
            $Game['rating_dislikes'] = $RatingSearch->RowCount();

            // Rating handling
            if($Game['rating_likes'] == 0 && $Game['rating_dislikes'] == 0) {
                $Game['rating_likes_width'] = 50;
                $Game['rating_dislikes_width'] = 50;
            } else {
                $Game['rating_likes_width'] = $Game['rating_likes'] / ($Game['rating_likes'] + $Game['rating_dislikes']) * 100;
                $Game['rating_dislikes_width'] = 100 - $Game['rating_likes_width'];
            }

            $RatingSearch = $this->Connection->prepare("SELECT * FROM ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'l' LIMIT 1");
            $RatingSearch->bindParam(":rating_to", $Game['id']);
            $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
            $RatingSearch->execute();
            $Rating = $RatingSearch->fetch();

            if(!isset($Rating['id'])) {
                $RatingSearch = $this->Connection->prepare("SELECT * FROM ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'd' LIMIT 1");
                $RatingSearch->bindParam(":rating_to", $Game['id']);
                $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
                $RatingSearch->execute();
                $Rating = $RatingSearch->fetch();
                if(!isset($Rating['id'])) {
                    $Game['rating_liked'] = false;
                    $Game['rating_disliked'] = false;
                } else {
                    $Game['rating_liked'] = false;
                    $Game['rating_disliked'] = true;
                }
            } else {
                $Game['rating_liked'] = true;
                $Game['rating_disliked'] = false;
            }

            $CommentSearch = $this->Connection->prepare("SELECT * FROM comment WHERE comment_target = :target ORDER BY id DESC LIMIT 30");
            $CommentSearch->bindParam(":target", $GameID);
            $CommentSearch->execute();

            while($Comment = $CommentSearch->fetch(\PDO::FETCH_ASSOC)) {
                $UserSearch = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :user LIMIT 1");
                $UserSearch->bindParam(":user", $Comment['comment_author']);
                $UserSearch->execute();
                $CommentUser = $UserSearch->fetch();
                if(isset($CommentUser['id'])) {
                    $Comment['author_id'] = $CommentUser['id'];
                    $Comments[] = $Comment;
                }
            }

            $FavoriteSearch = $this->Connection->prepare("SELECT * FROM favorites WHERE favorite_to = :favorite_to AND favorite_by = :favorite_by LIMIT 1");
            $FavoriteSearch->bindParam(":favorite_to", $GameID);
            $FavoriteSearch->bindParam(":favorite_by", $_SESSION['Roblox']);
            $FavoriteSearch->execute();
            $Favorite = $FavoriteSearch->fetch();

            $Game['server_player_list'] = explode(",", $Game['server_player_list']);
            foreach($Game['server_player_list'] as $Key => $Player) {
                $UserSearch = $this->Connection->prepare("SELECT roblox_username, id FROM users WHERE roblox_username = :user LIMIT 1");
                $UserSearch->bindParam(":user", $Player);
                $UserSearch->execute();
                $User = $UserSearch->fetch();
                if(isset($User['id'])) {
                    $Buffer[] = $User;
                }
            }

            if(isset($Buffer)) {
                $Game['server_player_list'] = $Buffer;
                $Game['server_player_list']['rows'] = count($Buffer);
            } else {
                $Game['server_player_list']['rows'] = 0;
            }

            $LastActive = strtotime($Game['server_ping']);
            $Now = strtotime("-10 minutes");
            if($Now > $LastActive) {
                $Game['active'] = false;
            } else {
                $Game['active'] = true;
            }

            if($Game['server_group'] != 0) {
                $Group = new \Crapblox\Models\Group();
                $Group = $Group->GetGroupByID($Game['server_group']);

                $Game['group_title'] = $Group['group_title'];
                $Game['group_id']    = $Group['id'];
                $Game['group_created']    = $Group['group_created'];
            }

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $GameSearch = $this->Connection->prepare("SELECT * FROM servers ORDER BY rand() DESC LIMIT 5");
            $GameSearch->execute();

            while($ReccGame = $GameSearch->fetch(\PDO::FETCH_ASSOC)) {
                $LastActive = strtotime($ReccGame['server_ping']);
                $Now = strtotime("-10 minutes");
                if($Now > $LastActive) {
                    $ReccGame['active'] = false;
                } else {
                    $ReccGame['active'] = true;
                }

                $Games[] = $ReccGame;
            }

            $Games['rows'] = $GameSearch->rowCount();

            $FavoriteSearch = $this->Connection->prepare("SELECT * FROM favorites WHERE favorite_to = :by ORDER BY id DESC LIMIT 5");
            $FavoriteSearch->bindParam(":by", $Game['id']);
            $FavoriteSearch->execute();
            $Favoriteds = $FavoriteSearch->rowCount();

            $RecentlySearch = $this->Connection->prepare("SELECT * FROM visits WHERE visit_game = :by AND visit_by != :crater");
            $RecentlySearch->bindParam(":by", $Game['id']);
            $RecentlySearch->bindParam(":crater", $Author['roblox_username']);
            $RecentlySearch->execute();
            $Visits = $RecentlySearch->rowCount();

            $User = $Auth->GetUserByUsername($_SESSION['Roblox']);

            $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_to = :id AND friend_by = :by LIMIT 1");
            $FriendSearch->bindParam(":id", $Author['id']);
            $FriendSearch->bindParam(":by", $User['id']);
            $FriendSearch->execute();
            $Friend = $FriendSearch->fetch();

            $Friended = false;

            if(!isset($Friend['id'])) {
                $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_to = :id AND friend_by = :by LIMIT 1");
                $FriendSearch->bindParam(":by", $Author['id']);
                $FriendSearch->bindParam(":id", $User['id']);
                $FriendSearch->execute();
                $Friend = $FriendSearch->fetch();
                if(isset($Friend['id'])) {
                    $Friended = true;
                }
            } else {
                $Friended = true;
            }

            if($Author['id'] == 358)
                $Visits = 0;

            // first = primary (.png)
            // second = secondary (_2.png)
            // third = thirdary (_3.png)
            // fourth = fourthary (_4.png)

            // I'm suprised PHP has support for stuff like this
            $AvailableThumbs = [
                file_exists($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Games/" . $Game['id'] . ".png"),
                file_exists($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Games/" . $Game['id'] . "_2.png"),
                file_exists($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Games/" . $Game['id'] . "_3.png"),
                file_exists($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Games/" . $Game['id'] . "_4.png"),
            ];

            echo $this->Twig->render('Game.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $User,
                "Categories"   => $Categories,
                "Game"         => $Game,
                "Games"        => $Games,
                "Thumbs"         => $AvailableThumbs,
                "Comments"     => @$Comments,
                "Favorites"    => $Favoriteds,
                "Visits"       => $Visits,
                "Author"       => $Author,
                "Favorite"     => $Favorite,
                "Ad"           => $Ad,
                "Friended"     => $Friended,
                "Token"        => base64_encode($Game['id'] . "." . $_SESSION['Token']),
                "HostToken"    => base64_encode($Game['id'] . "." . $Game['server_token']),
            ));
        }
    }

    public function ViewGame($GameID) {
        $GameVal = new \Crapblox\Models\Games();
        // This code is horrible and I should go kill myself
        if(isset($_SESSION['Roblox']) && $GameVal->GameExists($GameID)) {
            $Auth = new Auth\User();
            $Categories = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];
            $Game = $GameVal->GetGameByID($GameID);
            $Author = $Auth->GetUserByUsername($Game['server_owner']);

            $RatingSearch = $this->Connection->prepare("SELECT id FROM ratings WHERE rating_type = 'l' AND rating_to = :rating_to");
            $RatingSearch->bindParam(":rating_to", $Game['id']);
            $RatingSearch->execute();
            $Game['rating_likes'] = $RatingSearch->RowCount();

            $RatingSearch = $this->Connection->prepare("SELECT id FROM ratings WHERE rating_type = 'd' AND rating_to = :rating_to");
            $RatingSearch->bindParam(":rating_to", $Game['id']);
            $RatingSearch->execute();
            $Game['rating_dislikes'] = $RatingSearch->RowCount();

            // Rating handling
            if($Game['rating_likes'] == 0 && $Game['rating_dislikes'] == 0) {
                $Game['rating_likes_width'] = 50;
                $Game['rating_dislikes_width'] = 50;
            } else {
                $Game['rating_likes_width'] = $Game['rating_likes'] / ($Game['rating_likes'] + $Game['rating_dislikes']) * 100;
                $Game['rating_dislikes_width'] = 100 - $Game['rating_likes_width'];
            }

            $RatingSearch = $this->Connection->prepare("SELECT * FROM ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'l' LIMIT 1");
            $RatingSearch->bindParam(":rating_to", $Game['id']);
            $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
            $RatingSearch->execute();
            $Rating = $RatingSearch->fetch();

            if(!isset($Rating['id'])) {
                $RatingSearch = $this->Connection->prepare("SELECT * FROM ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'd' LIMIT 1");
                $RatingSearch->bindParam(":rating_to", $Game['id']);
                $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
                $RatingSearch->execute();
                $Rating = $RatingSearch->fetch();
                if(!isset($Rating['id'])) {
                    $Game['rating_liked'] = false;
                    $Game['rating_disliked'] = false;
                } else {
                    $Game['rating_liked'] = false;
                    $Game['rating_disliked'] = true;
                }
            } else {
                $Game['rating_liked'] = true;
                $Game['rating_disliked'] = false;
            }

            $CommentSearch = $this->Connection->prepare("SELECT * FROM comment WHERE comment_target = :target ORDER BY id DESC LIMIT 30");
            $CommentSearch->bindParam(":target", $GameID);
            $CommentSearch->execute();

            while($Comment = $CommentSearch->fetch(\PDO::FETCH_ASSOC)) {
                $UserSearch = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :user LIMIT 1");
                $UserSearch->bindParam(":user", $Comment['comment_author']);
                $UserSearch->execute();
                $CommentUser = $UserSearch->fetch();
                if(isset($CommentUser['id'])) {
                    $Comment['author_id'] = $CommentUser['id'];
                    $Comments[] = $Comment;
                }
            }

            $FavoriteSearch = $this->Connection->prepare("SELECT * FROM favorites WHERE favorite_to = :favorite_to AND favorite_by = :favorite_by LIMIT 1");
            $FavoriteSearch->bindParam(":favorite_to", $GameID);
            $FavoriteSearch->bindParam(":favorite_by", $_SESSION['Roblox']);
            $FavoriteSearch->execute();
            $Favorite = $FavoriteSearch->fetch();

            $Game['server_player_list'] = explode(",", $Game['server_player_list']);
            foreach($Game['server_player_list'] as $Key => $Player) {
                $UserSearch = $this->Connection->prepare("SELECT roblox_username, id FROM users WHERE roblox_username = :user LIMIT 1");
                $UserSearch->bindParam(":user", $Player);
                $UserSearch->execute();
                $User = $UserSearch->fetch();
                if(isset($User['id'])) {
                    $Buffer[] = $User;
                }
            }

            if(isset($Buffer)) {
                $Game['server_player_list'] = $Buffer;
                $Game['server_player_list']['rows'] = count($Buffer);
            } else {
                $Game['server_player_list']['rows'] = 0;
            }

            $LastActive = strtotime($Game['server_ping']);
            $Now = strtotime("-10 minutes");
            if($Now > $LastActive) {
                $Game['active'] = false;
            } else {
                $Game['active'] = true;
            }

            if($Game['server_group'] != 0) {
                $Group = new \Crapblox\Models\Group();
                $Group = $Group->GetGroupByID($Game['server_group']);

                $Game['group_title'] = $Group['group_title'];
                $Game['group_id']    = $Group['id'];
                $Game['group_created']    = $Group['group_created'];
            }

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $GameSearch = $this->Connection->prepare("SELECT * FROM servers ORDER BY rand() DESC LIMIT 5");
            $GameSearch->execute();

            while($ReccGame = $GameSearch->fetch(\PDO::FETCH_ASSOC)) {
                $LastActive = strtotime($ReccGame['server_ping']);
                $Now = strtotime("-10 minutes");
                if($Now > $LastActive) {
                    $ReccGame['active'] = false;
                } else {
                    $ReccGame['active'] = true;
                }
                $Games[] = $ReccGame;
            }

            $Games['rows'] = $GameSearch->rowCount();

            $FavoriteSearch = $this->Connection->prepare("SELECT * FROM favorites WHERE favorite_to = :by ORDER BY id DESC LIMIT 5");
            $FavoriteSearch->bindParam(":by", $Game['id']);
            $FavoriteSearch->execute();
            $Favoriteds = $FavoriteSearch->rowCount();

            $RecentlySearch = $this->Connection->prepare("SELECT * FROM visits WHERE visit_game = :by");
            $RecentlySearch->bindParam(":by", $Game['id']);
            $RecentlySearch->execute();
            $Visits = $RecentlySearch->rowCount();

            $User = $Auth->GetUserByUsername($_SESSION['Roblox']);

            $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_to = :id AND friend_by = :by LIMIT 1");
            $FriendSearch->bindParam(":id", $Author['id']);
            $FriendSearch->bindParam(":by", $User['id']);
            $FriendSearch->execute();
            $Friend = $FriendSearch->fetch();

            $Friended = false;

            if(!isset($Friend['id'])) {
                $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_to = :id AND friend_by = :by LIMIT 1");
                $FriendSearch->bindParam(":by", $Author['id']);
                $FriendSearch->bindParam(":id", $User['id']);
                $FriendSearch->execute();
                $Friend = $FriendSearch->fetch();
                if(isset($Friend['id'])) {
                    $Friended = true;
                }
            } else {
                $Friended = true;
            }

            // first = primary (.png)
            // second = secondary (_2.png)
            // third = thirdary (_3.png)
            // fourth = fourthary (_4.png)

            // I'm suprised PHP has support for stuff like this
            $AvailableThumbs = [
                file_exists($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Games/" . $Game['id'] . ".png"),
                file_exists($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Games/" . $Game['id'] . "_2.png"),
                file_exists($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Games/" . $Game['id'] . "_3.png"),
                file_exists($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Games/" . $Game['id'] . "_4.png"),
            ];

            $Auth = new \Crapblox\Models\Auth\User();
            $Auth = $Auth->GetUserByUsername($_SESSION['Roblox']);

            echo $this->Twig->render('Game.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $User,
                "LoggedInUser" => $Auth,
                "Categories"   => $Categories,
                "Game"         => $Game,
                "Thumbs"         => $AvailableThumbs,
                "Games"        => $Games,
                "Comments"     => @$Comments,
                "Favorites"    => $Favoriteds,
                "Visits"       => $Visits,
                "Author"       => $Author,
                "Favorite"     => $Favorite,
                "Ad"           => $Ad,
                "Friended"     => $Friended,
                "Token"        => base64_encode($Game['id'] . "." . $_SESSION['Token']),
                "HostToken"    => base64_encode($Game['id'] . "." . $Game['server_token']),
            ));
        } else {
            header("Location: /");
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Games",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}