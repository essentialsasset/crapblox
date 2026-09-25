<?php
namespace Crapblox\Models;

class Admin extends ModelBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function CensorIP($IP) {
        // https://stackoverflow.com/questions/8191221/replace-last-two-octets-of-an-ip-with-php
        $myIP = $IP;
        $ipOctets = explode('.', $myIP);
        return $ipOctets[0] . '.' . $ipOctets[1] . '.' . preg_replace('/./', '*', $ipOctets[4]) . '.' . preg_replace('/./', '*', $ipOctets[3]);
    }

    public function BanUser() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        $EndUser = new \Crapblox\Models\Auth\User();
        $EndUser = $EndUser->GetUserByUsername($_POST['username']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y") && ($EndUser['roblox_admin'] != "y") && ($EndUser['roblox_admin'] != "c")) {
            $BanSearch = $this->Connection->prepare("SELECT * FROM bans WHERE ban_user = :user LIMIT 1");
            $BanSearch->bindParam(":user", $_POST['username']);
            $BanSearch->execute();
            $Ban = $BanSearch->fetch();

            if($_POST["ipban"]) {
                // Oh jesus spare me for i have sinned
                $IPs = explode(",", $EndUser['roblox_ip']);

                foreach ($IPs as $IP) {
                    if (trim($IP) != "") {
                        $Logger = new \Crapblox\Models\Log();
                        $Logger->Log("**" . $_SESSION['Roblox'] . "** banned IP from " . $EndUser['roblox_username'] . " (" . $this->CensorIP($IP) . ") for reason: " . $_POST['reason']);

                        $stmt = $this->Connection->prepare(
                            "INSERT INTO bans 
                                (ban_user, ban_reason, ban_til, ban_issuer) 
                            VALUES 
                                (?, ?, ?, ?)"
                        );
                        $stmt->execute([
                            $IP,
                            $_POST['reason'],
                            $_POST['date'],
                            $_SESSION['Roblox'],
                        ]);
                    }
                }

                if($_POST['poisonban']) {
                    foreach($IPs as $IP) {
                        if(trim($IP) != "") {
                            $Search = "%" . $IP . "%";
                            $UserSearch = $this->Connection->prepare("SELECT id, roblox_admin, roblox_username, roblox_lastlogin, roblox_ip FROM users WHERE roblox_ip LIKE lower(:search)ORDER BY roblox_lastlogin DESC LIMIT 24");
                            $UserSearch->bindParam(':search', $Search, \PDO::PARAM_STR);
                            $UserSearch->execute();

                            while ($IPUser = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                                if ($IPUser['roblox_admin'] != "m" || $IPUser['roblox_admin'] != "y" || $IPUser['roblox_admin'] != "c") {
                                    // lord forgive me for i have sinned
                                    // this probably is horrible to run

                                    $PoisonBanIPs = explode(",", $IPUser['roblox_ip']);
                                    foreach($PoisonBanIPs as $PoisonBanIP) {
                                        if(trim($PoisonBanIP) != "") {
                                            $stmt = $this->Connection->prepare(
                                                "INSERT INTO bans 
                                                    (ban_user, ban_reason, ban_til, ban_issuer) 
                                                VALUES 
                                                    (?, ?, ?, ?)"
                                            );
                                            $stmt->execute([
                                                $PoisonBanIP,
                                                $_POST['reason'],
                                                $_POST['date'],
                                                $_SESSION['Roblox'],
                                            ]);

                                            $Logger = new \Crapblox\Models\Log();
                                            $Logger->Log("**" . $_SESSION['Roblox'] . "** banned IP from " . $IPUser['roblox_username'] . " (" . $this->CensorIP($PoisonBanIP) . ") for reason: " . $_POST['reason']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            //if(isset($Ban['id'])) {
            //    $_SESSION['Errors'] = ['This user is already banned.'];
            //    header("Location: /Admin/User/Ban");
            //    die();
            //}

            if($_POST["poisonban"]) {
                // Oh jesus spare me for i have sinned
                $IPs = explode(",", $EndUser['roblox_ip']);

                foreach($IPs as $IP) {
                    if(trim($IP) != "") {
                        $Search = "%" . $IP . "%";
                        $UserSearch = $this->Connection->prepare("SELECT id, roblox_admin, roblox_username, roblox_lastlogin, roblox_ip FROM users WHERE roblox_ip LIKE lower(:search)ORDER BY roblox_lastlogin DESC LIMIT 24");
                        $UserSearch->bindParam(':search', $Search, \PDO::PARAM_STR);
                        $UserSearch->execute();

                        while ($IPUser = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                            if ($IPUser['roblox_admin'] != "m" || $IPUser['roblox_admin'] != "y" || $IPUser['roblox_admin'] != "c") {
                                $stmt = $this->Connection->prepare(
                                    "INSERT INTO bans 
                                        (ban_user, ban_reason, ban_til, ban_issuer) 
                                    VALUES 
                                        (?, ?, ?, ?)"
                                );
                                $stmt->execute([
                                    $IPUser['roblox_username'],
                                    $_POST['reason'],
                                    $_POST['date'],
                                    $_SESSION['Roblox'],
                                ]);

                                $Logger = new \Crapblox\Models\Log();
                                $Logger->Log("**" . $_SESSION['Roblox'] . "** banned user " . $IPUser['roblox_username'] . " for reason: " . $_POST['reason'] . " (POISONBAN)");
                            } else {
                                $Logger = new \Crapblox\Models\Log();
                                $Logger->Log("**" . $_SESSION['Roblox'] . "** tried banning admin " . $IPUser['roblox_username'] . " for reason: " . $_POST['reason'] . " (POISONBAN)");
                            }
                        }
                    }
                }
            } else {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO bans 
                    (ban_user, ban_reason, ban_til, ban_issuer) 
                VALUES 
                    (?, ?, ?, ?)"
                );
                $stmt->execute([
                    $_POST['username'],
                    $_POST['reason'],
                    $_POST['date'],
                    $_SESSION['Roblox'],
                ]);

                $Logger = new \Crapblox\Models\Log();
                $Logger->Log("**" . $_SESSION['Roblox'] . "** banned user " . $_POST['username'] . " for reason: " . $_POST['reason']);
            }


            header("Location: /Admin/User/Ban");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function UnbanUser() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        $EndUser = new \Crapblox\Models\Auth\User();
        $EndUser = $EndUser->GetUserByUsername($_POST['username']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y") && ($EndUser['roblox_admin'] != "y") && ($EndUser['roblox_admin'] != "c")) {
            $BanSearch = $this->Connection->prepare("SELECT * FROM bans WHERE ban_user = :user LIMIT 1");
            $BanSearch->bindParam(":user", $_POST['username']);
            $BanSearch->execute();
            $Ban = $BanSearch->fetch();

            if(!isset($Ban['id'])) {
                $_SESSION['Errors'] = ['This user is not banned.'];
                header("Location: /Admin/User/Unban");
                die();
            }

            $stmt = $this->Connection->prepare("DELETE FROM bans WHERE ban_user = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** unbanned user " . $_POST['username'] . " for reason: " . $_POST['reason']);

            header("Location: /Admin/User/Unban");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function NewNews() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        $EndUser = new \Crapblox\Models\Auth\User();
        $EndUser = $EndUser->GetUserByUsername($_POST['username']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y") && ($EndUser['roblox_admin'] != "y") && ($EndUser['roblox_admin'] != "c")) {
            $stmt = $this->Connection->prepare(
                "INSERT INTO news 
                    (news_title, news_author, news_text) 
                VALUES 
                    (?, ?, ?)"
            );
            $stmt->execute([
                $_POST['title'],
                $_SESSION['Roblox'],
                $_POST['comment'],
            ]);

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** created news article " . $_POST['title']);

            header("Location: /Admin/News/Create");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function GiveAsset() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner LIMIT 1");
            $OwnSearch->bindParam(":owner", $_POST['username']);
            $OwnSearch->bindParam(":id", $_POST['assetid']);
            $OwnSearch->execute();
            $Own = $OwnSearch->fetch();

            if(isset($Own['id'])) {
                $_SESSION['Errors'] = ['This user already has that asset.'];
                header("Location: /Admin/User/Item");
                die();
            }

            $stmt = $this->Connection->prepare(
                "INSERT INTO ownerships 
                    (asset_id, asset_owner) 
                 VALUES 
                    (?, ?)"
            );
            $stmt->execute([
                $_POST['assetid'],
                $_POST['username'],
            ]);

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** gave user " . $_POST['username'] . " asset " . $_POST['assetid']);

            header("Location: /Admin/User/Item");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function CloseGame() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            @file_get_contents("http://51.79.82.198:2757/game/stop/" . $_POST['gameid'] . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");
            header("Location: /Admin/Game/Close");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function RedactDescription() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($_POST['username']);

            $stmt = $this->Connection->prepare("UPDATE users SET roblox_description = '[ Content Deleted ]' WHERE id = ?");
            $stmt->execute([
                $User['id'],
            ]);
            $stmt = null;

            header("Location: /Admin/Redact/Description");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function RedactCSS() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($_POST['username']);

            $stmt = $this->Connection->prepare("UPDATE users SET roblox_css = '[ Content Deleted ]' WHERE id = ?");
            $stmt->execute([
                $User['id'],
            ]);
            $stmt = null;

            header("Location: /Admin/Redact/CSS");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function FeatureGame() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            $Game = new \Crapblox\Models\Games();
            $Game = $Game->GetGameByID($_POST['gameid']);

            if($Game['server_featured'] == "y") {
                $stmt = $this->Connection->prepare("UPDATE servers SET server_featured = 'n' WHERE id = ?");
                $stmt->execute([
                    $Game['id'],
                ]);
                $stmt = null;
            } else {
                $stmt = $this->Connection->prepare("UPDATE servers SET server_featured = 'y' WHERE id = ?");
                $stmt->execute([
                    $Game['id'],
                ]);
                $stmt = null;
            }

            header("Location: /Admin/Game/Feature");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function GiveMoolah() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets, roblox_username FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $_POST['username']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();

            if(!isset($User['id'])) {
                $_SESSION['Errors'] = ['Stock does not exist'];
                header("Location: /Admin/User/Compensate");
                die();
            }

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** giving " . $_POST["username"] . " " . $_POST['money'] . " zuos");

            //take
            $stmt = $this->Connection->prepare("UPDATE users SET roblox_tickets = ? WHERE roblox_username = ?");
            $stmt->execute([
                $User['roblox_tickets'] + (int)$_POST['money'],
                $User['roblox_username'],
            ]);

            header("Location: /Admin/User/Compensate");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }
    
    public function DenyAsset() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y") && isset($_GET['id'])) {
            $stmt = $this->Connection->prepare("UPDATE catalog SET item_approved = 'd' WHERE id = ?");
            $stmt->execute([
                $_GET['id']
            ]);

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** denied assetid " . $_GET['id']);

            header("Location: /Admin/Catalog/Approvals");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function ApproveAsset() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y") && isset($_GET['id'])) {
            $stmt = $this->Connection->prepare("UPDATE catalog SET item_approved = 'y' WHERE id = ?");
            $stmt->execute([
                $_GET['id']
            ]);

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** approved assetid " . $_GET['id']);

            header("Location: /Admin/Catalog/Approvals");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function ChangeName() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        $EndUser = new \Crapblox\Models\Auth\User();
        $EndUser = $EndUser->GetUserByUsername($_POST['username']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            $Auth = new \Crapblox\Models\Auth\User();
            $User = $Auth->GetUserByUsername($_POST['username']);

            $stmt = $this->Connection->prepare("UPDATE bans SET ban_user = ? WHERE ban_user = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE ads SET ad_author = ? WHERE ad_author = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE catalog SET item_author = ? WHERE item_author = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE comment SET comment_author = ? WHERE comment_author = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE comment_group SET comment_author = ? WHERE comment_author = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE comment_item SET comment_author = ? WHERE comment_author = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE comment_news SET comment_author = ? WHERE comment_author = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE comment_user SET comment_author = ? WHERE comment_author = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE favorites SET favorite_to = ? WHERE favorite_to = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE feed SET comment_author = ? WHERE comment_author = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE forum_replies SET thread_author = ? WHERE thread_author = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE forum_threads SET thread_author = ? WHERE thread_author = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE friends SET friend_to = ? WHERE friend_to = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `groups` SET group_owner = ? WHERE group_owner = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `group_membership` SET group_sent = ? WHERE group_sent = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `logs` SET log_recipient = ? WHERE log_recipient = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `logs` SET log_sender = ? WHERE log_sender = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `ownerships` SET asset_owner = ? WHERE asset_owner = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `ratings` SET rating_by = ? WHERE rating_by = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `referrals` SET key_from = ? WHERE key_from = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `resell` SET item_owned = ? WHERE item_owned = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `servers` SET server_owner = ? WHERE server_owner = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `trades` SET trade_sent = ? WHERE trade_sent = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `transactions` SET sale_by = ? WHERE sale_by = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `users` SET roblox_username = ? WHERE roblox_username = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $stmt = $this->Connection->prepare("UPDATE `visits` SET visit_by = ? WHERE visit_by = ?");
            $stmt->execute([
                $_POST['new_username'],
                $_POST['username'],
            ]);

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** moved user " . $_POST['username'] . " to " . $_POST['new_username']);

            header("Location: /Admin/User/Name");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function DeleteUser() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        $EndUser = new \Crapblox\Models\Auth\User();
        $EndUser = $EndUser->GetUserByUsername($_POST['username']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y") && ($EndUser['roblox_admin'] != "y") && ($EndUser['roblox_admin'] != "c")) {
            $Auth = new \Crapblox\Models\Auth\User();
            $User = $Auth->GetUserByUsername($_POST['username']);

            $stmt = $this->Connection->prepare("DELETE FROM ads WHERE ad_author = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM bans WHERE ban_user = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM catalog WHERE item_author = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM comment WHERE comment_author = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM comment_group WHERE comment_author = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM comment_item WHERE comment_author = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM comment_news WHERE comment_author = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM comment_user WHERE comment_author = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM favorites WHERE favorite_to = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM feed WHERE comment_author = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM forum_replies WHERE thread_author = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM forum_threads WHERE thread_author = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM friends WHERE friend_to = ?");
            $stmt->execute([
                $User['id'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM friends WHERE friend_by = ?");
            $stmt->execute([
                $User['id'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM `groups` WHERE group_owner = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM group_membership WHERE group_sent = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM logs WHERE log_recipient = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM logs WHERE log_sender = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM ownerships WHERE asset_owner = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM ratings WHERE rating_by = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM referrals WHERE key_from = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM resell WHERE item_owned = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM servers WHERE server_owner = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM trades WHERE trade_sent = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM trades WHERE trade_receiving = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM transactions WHERE sale_by = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM users WHERE roblox_username = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM visits WHERE visit_by = ?");
            $stmt->execute([
                $_POST['username'],
            ]);
            $stmt = null;

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** permanently removed " . $_POST['username'] . " from the database");

            header("Location: /Admin/User/Delete");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function DenyGame() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y") && isset($_GET['id'])) {
            $stmt = $this->Connection->prepare("UPDATE servers SET server_thumbnail_approve = 'd' WHERE id = ?");
            $stmt->execute([
                $_GET['id']
            ]);

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** disapproved game thumb " . $_GET['id']);

            header("Location: /Admin/Catalog/Approvals");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function ApproveGame() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y") && isset($_GET['id'])) {
            $stmt = $this->Connection->prepare("UPDATE servers SET server_thumbnail_approve = 'y' WHERE id = ?");
            $stmt->execute([
                $_GET['id']
            ]);

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** disapproved game thumb " . $_GET['id']);

            header("Location: /Admin/Catalog/Approvals");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function DenyGroup() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y") && isset($_GET['id'])) {
            $stmt = $this->Connection->prepare("UPDATE `groups` SET group_thumbnail_moderated = 'd' WHERE id = ?");
            $stmt->execute([
                $_GET['id']
            ]);

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** disapproved group photo " . $_GET['id']);

            header("Location: /Admin/Catalog/Approvals");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function ApproveGroup() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y") && isset($_GET['id'])) {
            $stmt = $this->Connection->prepare("UPDATE `groups` SET group_thumbnail_moderated = 'y' WHERE id = ?");
            $stmt->execute([
                $_GET['id']
            ]);

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** approved group photo " . $_GET['id']);

            header("Location: /Admin/Catalog/Approvals");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function DenyAd() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y") && isset($_GET['id'])) {
            $stmt = $this->Connection->prepare("UPDATE ads SET ad_status = '-' WHERE id = ?");
            $stmt->execute([
                $_GET['id']
            ]);

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** denied ad " . $_GET['id']);

            header("Location: /Admin/Catalog/Approvals");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function ApproveAd() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y") && isset($_GET['id'])) {
            $stmt = $this->Connection->prepare("UPDATE ads SET ad_status = 'a' WHERE id = ?");
            $stmt->execute([
                $_GET['id']
            ]);

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** approved ad " . $_GET['id']);

            header("Location: /Admin/Catalog/Approvals");
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Homepage",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}