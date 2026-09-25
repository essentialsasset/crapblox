<?php
namespace Crapblox\Models\Comment;

class User extends \Crapblox\Models\ModelBase {
    public function New($Username) {
        $Validation = $this->Validator->make($_POST, [
            'comment'                   => 'required|min:4|max:500',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /User/" . $Username);
            die();
        } else {
            $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_cooldown >= NOW() - INTERVAL 1 MINUTE");
            $stmt->bindParam(":username", $_SESSION['Roblox']);
            $stmt->execute();
            if ($stmt->rowCount() === 1) {
                $_SESSION['Errors'] = ['You have posted a comment too fast.'];
                header("Location: /User/" . $Username);
                die();
            }

            if (!isset($_SESSION['Roblox'])) {
                $_SESSION['Errors'] = ['You are not logged in.'];
                header("Location: /");
                die();
            }

            $Logger = new \Crapblox\Models\Log();
            $Logger->Notify("**" . $_SESSION['Roblox'] . "** commented on your profile.\n\n```" . $_POST['comment'] . "```", $Username, $_SESSION['Roblox'], "Profile Comment");

            $stmt = $this->Connection->prepare(
                "INSERT INTO comment_user 
                    (comment_text, comment_author, comment_target) 
                 VALUES 
                    (?, ? ,?)"
            );
            $stmt->execute([
                $_POST['comment'],
                $_SESSION['Roblox'],
                $Username,
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("UPDATE users SET roblox_cooldown = NOW() WHERE roblox_username = ?");
            $res = $stmt->execute([$_SESSION['Roblox']]);

            header("Location: /User/" . $Username);
        }
    }
}

class Game extends \Crapblox\Models\ModelBase {
    public function New($GameID) {
        $Validation = $this->Validator->make($_POST, [
            'comment'                   => 'required|min:4|max:500',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /Game/" . $GameID);
            die();
        } else {
            $Check = new \Crapblox\Models\Games();
            if($Check->GameExists($GameID)) {
                $Game = $Check->GetGameByID($GameID);
                $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_cooldown >= NOW() - INTERVAL 1 MINUTE");
                $stmt->bindParam(":username", $_SESSION['Roblox']);
                $stmt->execute();
                if ($stmt->rowCount() === 1) {
                    $_SESSION['Errors'] = ['You have posted a comment too fast.'];
                    header("Location: /Game/" . $GameID);
                    die();
                }

                if (!isset($_SESSION['Roblox'])) {
                    $_SESSION['Errors'] = ['You are not logged in.'];
                    header("Location: /");
                    die();
                }

                $Logger = new \Crapblox\Models\Log();
                $Logger->Notify("**" . $_SESSION['Roblox'] . "** commented on your game \"" . $Game['server_title'] .  "\".\n\n```" . $_POST['comment'] . "```", $Game['server_owner'], $_SESSION['Roblox'], "Game Comment");

                $stmt = $this->Connection->prepare(
                    "INSERT INTO comment 
                        (comment_text, comment_author, comment_target) 
                     VALUES 
                        (?, ? ,?)"
                );
                $stmt->execute([
                    $_POST['comment'],
                    $_SESSION['Roblox'],
                    $GameID,
                ]);
                $stmt = null;

                $stmt = $this->Connection->prepare("UPDATE users SET roblox_cooldown = NOW() WHERE roblox_username = ?");
                $res = $stmt->execute([$_SESSION['Roblox']]);

                header("Location: /Game/" . $GameID);
            }
        }
    }
}

class News extends \Crapblox\Models\ModelBase {
    public function New($GameID) {
        $Validation = $this->Validator->make($_POST, [
            'comment'                   => 'required|min:4|max:500',
        ]);

        $Validation->validate();

        $OwnSearch = $this->Connection->prepare("SELECT * FROM news WHERE id = :id LIMIT 1");
        $OwnSearch->bindParam(":id", $GameID);
        $OwnSearch->execute();
        $Group = $OwnSearch->fetch();

        $Format = new \Crapblox\Views\Games();
        $URL       = "/" . $Format->formatUrl($Group['news_title']) . "-blog?id=" . $Group['id'];

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: " . $URL);
            die();
        } else {
            if(isset($Group['id'])) {
                $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_cooldown >= NOW() - INTERVAL 1 MINUTE");
                $stmt->bindParam(":username", $_SESSION['Roblox']);
                $stmt->execute();
                if ($stmt->rowCount() === 1) {
                    $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
                    header("Location: " . $URL);
                    die();
                }

                if (!isset($_SESSION['Roblox'])) {
                    $_SESSION['Errors'] = ['You are not logged in.'];
                    header("Location: /");
                    die();
                }

                $stmt = $this->Connection->prepare(
                    "INSERT INTO comment_news
                        (comment_text, comment_author, comment_target) 
                     VALUES 
                        (?, ? ,?)"
                );
                $stmt->execute([
                    $_POST['comment'],
                    $_SESSION['Roblox'],
                    $GameID,
                ]);
                $stmt = null;

                $stmt = $this->Connection->prepare("UPDATE users SET roblox_cooldown = NOW() WHERE roblox_username = ?");
                $res = $stmt->execute([$_SESSION['Roblox']]);

                header("Location: " . $URL);
            }
        }
    }
}

class Item extends \Crapblox\Models\ModelBase {
    public function New($ItemID) {
        $Validation = $this->Validator->make($_POST, [
            'comment'                   => 'required|min:4|max:500',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /Item/" . $ItemID);
            die();
        } else {
            $Check = new \Crapblox\Models\Asset();
            if($Check->AssetExists($ItemID)) {
                $Item = $Check->GetAssetByID($ItemID);

                $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_cooldown >= NOW() - INTERVAL 1 MINUTE");
                $stmt->bindParam(":username", $_SESSION['Roblox']);
                $stmt->execute();
                if ($stmt->rowCount() === 1) {
                    $_SESSION['Errors'] = ['You have posted a comment too fast.'];
                    header("Location: /Item/" . $ItemID);
                    die();
                }

                if (!isset($_SESSION['Roblox'])) {
                    $_SESSION['Errors'] = ['You are not logged in.'];
                    header("Location: /");
                    die();
                }

                $Logger = new \Crapblox\Models\Log();
                $Logger->Notify("**" . $_SESSION['Roblox'] . "** commented on your item \"" . $Item['item_title'] .  "\".\n\n```" . $_POST['comment'] . "```", $Item['item_author'], $_SESSION['Roblox'], "Item Comment");

                $stmt = $this->Connection->prepare(
                    "INSERT INTO comment_item 
                        (comment_text, comment_author, comment_target) 
                     VALUES 
                        (?, ? ,?)"
                );
                $stmt->execute([
                    $_POST['comment'],
                    $_SESSION['Roblox'],
                    $ItemID,
                ]);
                $stmt = null;

                $stmt = $this->Connection->prepare("UPDATE users SET roblox_cooldown = NOW() WHERE roblox_username = ?");
                $res = $stmt->execute([$_SESSION['Roblox']]);

                header("Location: /Item/" . $ItemID);
            }
        }
    }
}

class Group extends \Crapblox\Models\ModelBase {
    public function New($GroupID) {
        $Validation = $this->Validator->make($_POST, [
            'comment'                   => 'required|min:4|max:500',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /Groups/" . $GroupID);
            die();
        } else {
            $Check = new \Crapblox\Models\Group();
            if($Check->GroupExists($GroupID)) {
                $Group = $Check->GetGroupByID($GroupID);
                $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_cooldown >= NOW() - INTERVAL 1 MINUTE");
                $stmt->bindParam(":username", $_SESSION['Roblox']);
                $stmt->execute();
                if ($stmt->rowCount() === 1) {
                    $_SESSION['Errors'] = ['You have posted a comment too fast.'];
                    header("Location: /Groups/" . $GroupID);
                    die();
                }

                if (!isset($_SESSION['Roblox'])) {
                    $_SESSION['Errors'] = ['You are not logged in.'];
                    header("Location: /");
                    die();
                }

                $UserSearch = $this->Connection->prepare("SELECT * FROM group_membership WHERE group_to = :sent");
                $UserSearch->bindParam(":sent", $GroupID);
                $UserSearch->execute();
                while($Comment = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                    $IndividUserSearch = $this->Connection->prepare("SELECT roblox_username, id FROM users WHERE roblox_username = :user");
                    $IndividUserSearch->bindParam(":user", $Comment['group_sent']);
                    $IndividUserSearch->execute();
                    $User = $IndividUserSearch->fetch();
                    if(isset($User['id'])) {
                        $Logger = new \Crapblox\Models\Log();
                        $Logger->Notify("**" . $_SESSION['Roblox'] . "** commented on a group (\"" . $Group['group_title'] .  "\") you're in:\n\n```" . $_POST['comment'] . "```", $User['roblox_username'], $_SESSION['Roblox'], "Group Comment");
                    }
                }

                $stmt = $this->Connection->prepare(
                    "INSERT INTO comment_group 
                        (comment_text, comment_author, comment_target) 
                     VALUES 
                        (?, ? ,?)"
                );
                $stmt->execute([
                    $_POST['comment'],
                    $_SESSION['Roblox'],
                    $GroupID,
                ]);
                $stmt = null;

                $stmt = $this->Connection->prepare("UPDATE users SET roblox_cooldown = NOW() WHERE roblox_username = ?");
                $res = $stmt->execute([$_SESSION['Roblox']]);

                header("Location: /Groups/" . $GroupID);
            }
        }
    }
}