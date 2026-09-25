<?php
namespace Crapblox\Views;

class User extends ViewBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function Banned() {
        $BanSearch = $this->Connection->prepare("SELECT * FROM bans WHERE ban_user = :user LIMIT 1");
        $BanSearch->bindParam(":user", $_SESSION['Roblox']);
        $BanSearch->execute();
        $BannedUser = $BanSearch->fetch();

        if(isset($BannedUser['id'])) {
            echo $this->Twig->render('Banned.twig', array(
                "PageSettings" => $this->PageSettings(),
                "Ban" => $BannedUser,
            ));
        } else {
            header("Location: /Feed");
        }
    }

    public function Appeal() {
        $BanSearch = $this->Connection->prepare("SELECT * FROM bans WHERE ban_user = :user AND ban_til < NOW()");
        $BanSearch->bindParam(":user", $_SESSION['Roblox']);
        $BanSearch->execute();
        $BannedUser = $BanSearch->fetch();
        if(isset($BannedUser['id'])) {
            $stmt = $this->Connection->prepare("DELETE FROM bans WHERE id = ? AND ban_user = ?");
            $stmt->execute(
                [
                    $BannedUser['id'],
                    $_SESSION['Roblox'],
                ]
            );

            header("Location: /");

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** waited their ban out.");
        } else {
            $_SESSION['Errors'] = ['There is still time left in your ban.'];
            header("Location: /Banned");
            die();
        }
    }

    public function View($Username) {
        $Auth = new \Crapblox\Models\Auth\User();

        if($Auth->UserExists($Username)) {
            $User = $Auth->GetUserByUsername($Username);

            $GameSearch = $this->Connection->prepare("SELECT * FROM servers WHERE server_owner = :author AND server_allowed = 'Everyone' ORDER BY id DESC LIMIT 30");
            $GameSearch->bindParam(":author", $Username);
            $GameSearch->execute();

            while($Game = $GameSearch->fetch(\PDO::FETCH_ASSOC)) {
                $LastActive = strtotime($Game['server_ping']);
                $Now = strtotime("-5 minutes");
                if($Now > $LastActive) {
                    $Game['active'] = false;
                } else {
                    $Game['active'] = true;
                }
                $Games[] = $Game;
            }

            $Games['rows'] = $GameSearch->rowCount();

            $CommentSearch = $this->Connection->prepare("SELECT * FROM comment_user WHERE comment_target = :target ORDER BY id DESC LIMIT 30");
            $CommentSearch->bindParam(":target", $Username);
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

            $OwnSearch = $this->Connection->prepare("SELECT * FROM ownerships WHERE asset_owner = :user ORDER BY id DESC LIMIT 500");
            $OwnSearch->bindParam(":user", $Username);
            $OwnSearch->execute();

            $Wearing = explode(";", $User['roblox_wear']);

            $Items['rows'] = 0;

            while($Item = $OwnSearch->fetch(\PDO::FETCH_ASSOC)) {
                $id = $Item['asset_id'];
                $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
                $ItemSearch->bindParam(":id", $Item['asset_id']);
                $ItemSearch->execute();
                $Item = $ItemSearch->fetch();
                if($Items['rows'] <= 3) {
                    if (in_array($id, $Wearing)) {
                        @$Item['wearing'] = true;
                        $Items['rows']++;
                    } else {
                        @$Item['wearing'] = false;
                    }
                }
                $Items[] = $Item;
            }

            $UserSearch = $this->Connection->prepare("SELECT id, roblox_admin FROM users WHERE roblox_username = :user LIMIT 1");
            $UserSearch->bindParam(":user", $_SESSION['Roblox']);
            $UserSearch->execute();
            $LoggedInUser = $UserSearch->fetch();

            $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_by = :to_user AND friend_to = :user LIMIT 1");
            $FriendSearch->bindParam(":user", $LoggedInUser['id']);
            $FriendSearch->bindParam(":to_user", $User['id']);
            $FriendSearch->execute();
            $RelationshipIncoming = $FriendSearch->fetch();

            $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_status = 'a' AND friend_by = :user OR friend_to = :user2 ");
            $FriendSearch->bindParam(":user", $User['id']);
            $FriendSearch->bindParam(":user2", $User['id']);
            $FriendSearch->execute();
            $RelationshipOutgoing['rows'] = 0;
            while($Friend = $FriendSearch->fetch(\PDO::FETCH_ASSOC)) {
                if($Friend['friend_to'] == $User['id'] && $Friend['friend_status'] == "a") {
                    $ServerSearch = $this->Connection->prepare("SELECT roblox_username, id, roblox_lastlogin FROM users WHERE id = :id LIMIT 1");
                    $ServerSearch->bindParam(":id", $Friend['friend_by']);
                    $ServerSearch->execute();
                    $Game = $ServerSearch->fetch();
                } else if($Friend['friend_by'] == $User['id'] && $Friend['friend_status'] == "a") {
                    $ServerSearch = $this->Connection->prepare("SELECT roblox_username, id, roblox_lastlogin FROM users WHERE id = :id LIMIT 1");
                    $ServerSearch->bindParam(":id", $Friend['friend_to']);
                    $ServerSearch->execute();
                    $Game = $ServerSearch->fetch();
                }

                if(isset($Game['id'])) {
                    $Friend['profile_picture'] = $Game['id'];
                    $Friend['roblox_lastlogin'] = $Game['roblox_lastlogin'];
                    $Friend['roblox_username'] = $Game['roblox_username'];

                    $LastActive = strtotime($Game['roblox_lastlogin']);
                    $Now = strtotime("-10 minutes");
                    if($Now > $LastActive) {
                        $Friend['active'] = false;
                    } else {
                        $Friend['active'] = true;
                    }

                    if($Friend['friend_status'] == "a") {
                        $RelationshipOutgoing[] = $Friend;
                        $RelationshipOutgoing['rows']++;
                    }
                }
            }

            $User = $Auth->GetUserByUsername($Username);

            if(isset($_GET['safemode'])) {
                $User['roblox_css'] = "";
            }

            $Referrals = new \Crapblox\Models\Referral();
            $UsersReferred = $Referrals->GetReferralsFrom($User["roblox_username"]);
            $UserRefferedBy = $Referrals->GetReferralFor($User["roblox_username"]);

            if($LoggedInUser["roblox_admin"] == "y" || $LoggedInUser["roblox_admin"] == "m") {
                $IPs = explode(",", $User['roblox_ip']);

                foreach($IPs as $IP) {
                    if(trim($IP) != "") {
                        $Search = "%" . $IP . "%";
                        $UserSearch = $this->Connection->prepare("SELECT id, roblox_admin, roblox_username, roblox_lastlogin, roblox_ip FROM users WHERE roblox_ip LIKE lower(:search)ORDER BY roblox_lastlogin DESC LIMIT 24");
                        $UserSearch->bindParam(':search', $Search, \PDO::PARAM_STR);
                        $UserSearch->execute();

                        while ($IPUser = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                            $Alts[] = $IPUser;
                        }
                    }
                }
            }

            $BanSearch = $this->Connection->prepare("SELECT * FROM bans WHERE ban_user = :user LIMIT 1");
            $BanSearch->bindParam(":user", $User['roblox_username']);
            $BanSearch->execute();
            $BannedUser = $BanSearch->fetch();

            echo $this->Twig->render('User.twig', array(
                "DisableTheme" => true,
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
                "Alts" => @$Alts,
                "Games" => @$Games,
                "Banned" => @$BannedUser,
                "Comments" => @$Comments,
                "Items" => @$Items,
                "Relationship" => @$RelationshipOutgoing,
                "RelationshipIncoming" => @$RelationshipIncoming,
                "UsersReferred" => $UsersReferred,
                "UserReferredBy" => $UserRefferedBy,
            ));
        } else {
            header("Location: /");
        }
    }

    public function List() {
        $ItemsPerPage = 24;

        if(isset($_GET['page'])) {
            $Offset = ((int)$_GET['page'] * $ItemsPerPage) - $ItemsPerPage;
            $UserSearch = $this->Connection->prepare("SELECT id, roblox_username, roblox_description, roblox_lastlogin FROM users ORDER BY roblox_lastlogin DESC LIMIT " . $Offset . ",24");
        } else {
            $UserSearch = $this->Connection->prepare("SELECT id, roblox_username, roblox_description, roblox_lastlogin FROM users ORDER BY roblox_lastlogin DESC LIMIT 24");
        }
        $UserSearch->execute();

        $UserLengthSearch = $this->Connection->prepare("SELECT id FROM users");
        $UserLengthSearch->execute();

        $Catalog['rows'] = $UserLengthSearch->rowCount();
        $Pages = round($Catalog['rows'] / $ItemsPerPage);

        while($User = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
            $LastActive = strtotime($User['roblox_lastlogin']);
            $Now = strtotime("-10 minutes");
            if($Now > $LastActive) {
                $User['active'] = false;
            } else {
                $User['active'] = true;
            }

            $Users[] = $User;
        }

        $Users['rows'] = $UserLengthSearch->rowCount();

        echo $this->Twig->render('UsersNew.twig', array(
            "PageSettings" => $this->PageSettings(),
            "Users" => $Users,
            "url" => "/Users/?page=",
            "total" => $Pages,
            "current" => $_GET['page'] ?? 1,
            "nearbyPagesLimit" => 4,
        ));
    }

    public function Search() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new \Crapblox\Models\Auth\User();

            $search = "%" . $_GET['search'] . "%";
            $GameSearch = $this->Connection->prepare("SELECT * FROM users WHERE concat(roblox_username, roblox_description) LIKE lower(:search) ORDER BY roblox_lastlogin DESC LIMIT 50");
            $GameSearch->bindParam(':search', $search, \PDO::PARAM_STR);
            $GameSearch->execute();

            while($Game = $GameSearch->fetch(\PDO::FETCH_ASSOC)) {
                $LastActive = strtotime($Game['roblox_lastlogin']);
                $Now = strtotime("-5 minutes");
                if($Now > $LastActive) {
                    $Game['active'] = false;
                } else {
                    $Game['active'] = true;
                }
                $Games[] = $Game;
            }

            $Games['rows'] = $GameSearch->rowCount();

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            echo $this->Twig->render('UsersNew.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Category" => "Searching for \"" . $_GET['search'] . "\"",
                "Ad" => $Ad,
                "Users" => $Games,
            ));
        } else {
            header("Location: /");
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "User",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}
