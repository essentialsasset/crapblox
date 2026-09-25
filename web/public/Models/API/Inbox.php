<?php
namespace Crapblox\Models;

class Inbox extends ModelBase {
    public function Compose() {
        $Validation = $this->Validator->make($_POST, [
            'title'                     => 'required|min:4|max:50',
            'recipient'                 => 'required',
            'description'               => 'required|min:1|max:4096',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /Inbox/Compose/" . @$_POST['recipient']);
            die();
        } else {
            $Auth = new \Crapblox\Models\Auth\User();
            if ($Auth->UserExists($_POST['recipient'])) {
                $User = new \Crapblox\Models\Auth\User();
                $User = $User->GetUserByUsername($_POST['recipient']);

                $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_cooldown >= NOW() - INTERVAL 1 MINUTE");
                $stmt->bindParam(":username", $_SESSION['Roblox']);
                $stmt->execute();
                if ($stmt->rowCount() === 1) {
                    $_SESSION['Errors'] = ['You have sent messages too fast.'];
                    header("Location: /Inbox/Compose/" . @$_POST['recipient']);
                    die();
                }

                $stmt = $this->Connection->prepare("UPDATE users SET roblox_cooldown = NOW() WHERE roblox_username = ?");
                $res = $stmt->execute([$_SESSION['Roblox']]);

                $Logger = new \Crapblox\Models\Log();
                $Logger->Notify($_POST['description'], $_POST['recipient'], $_SESSION['Roblox'], $_POST['title']);
                header("Location: /Inbox/");
            } else {
                $_SESSION['Error'] = ['This user does not exist.'];
                header("Location: /Inbox/Compose/" . @$_POST['recipient']);
                die();
            }
        }
    }

    public function DeleteThread($ID) {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        $Reply = $this->GetThreadByID($ID);

        if($User['roblox_admin'] == "y" || $User['roblox_admin'] == "m") {
            $stmt = $this->Connection->prepare("UPDATE forum_threads SET thread_visible = 'n' WHERE id = ?");
            $stmt->execute([
                $ID
            ]);
            $stmt = null;
            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** deleted threadid " . $ID . " (" . $Reply['thread_text'] . ")");

            $_SESSION['Success'] = ['Successfully deleted thread.'];
            header("Location: /Forum/" . $Reply['thread_target']);
            die();
        } elseif($User['roblox_username'] == $Reply['thread_author']) {
            $stmt = $this->Connection->prepare("UPDATE forum_threads SET thread_visible = 'n' WHERE id = ?");
            $stmt->execute([
                $ID
            ]);
            $stmt = null;
            $_SESSION['Success'] = ['Successfully deleted your thread.'];
            header("Location: /Forum/" . $Reply['thread_target']);
            die();
        }

        $_SESSION['Error'] = ['You have not created this thread.'];
        header("Location: /Forum/Thread/" . $Reply['id']);
        die();
    }

    public function DeleteReply($ID) {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        $Reply = $this->GetReplyByID($ID);

        if($User['roblox_admin'] == "y" || $User['roblox_admin'] == "m") {
            $stmt = $this->Connection->prepare("UPDATE forum_replies SET thread_visible = 'n' WHERE id = ?");
            $stmt->execute([
                $ID
            ]);
            $stmt = null;
            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** deleted replyid " . $ID . " (" . $Reply['thread_text'] . ")");

            $_SESSION['Success'] = ['Successfully deleted your reply.'];
            header("Location: /Forum/Thread/" . $Reply['thread_target']);
            die();
        } elseif($User['roblox_username'] == $Reply['thread_author']) {
            $stmt = $this->Connection->prepare("UPDATE forum_replies SET thread_visible = 'n' WHERE id = ?");
            $stmt->execute([
                $ID
            ]);
            $stmt = null;
            $_SESSION['Success'] = ['Successfully deleted your reply.'];
            header("Location: /Forum/Thread/" . $Reply['thread_target']);
            die();
        }

        $_SESSION['Error'] = ['You have not created this reply.'];
        header("Location: /Forum/Thread/" . $Reply['thread_target']);
        die();
    }

    public function Reply($Thread) {
        $Validation = $this->Validator->make($_POST, [
            'description'               => 'required|min:3|max:1000',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /Forum/Thread/" . $Thread);
            die();
        } else {
            if($this->ThreadExists($Thread)) {
                $Thread = $this->GetThreadByID($Thread);
                $Category = $this->GetCategoryByID($Thread['thread_target']);

                if (!isset($_SESSION['Roblox'])) {
                    $_SESSION['Errors'] = ['You are not logged in.'];
                    header("Location: /Forum/Thread/" . $Thread['id']);
                    die();
                }

                $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_cooldown >= NOW() - INTERVAL 1 MINUTE");
                $stmt->bindParam(":username", $_SESSION['Roblox']);
                $stmt->execute();
                if ($stmt->rowCount() === 1) {
                    $_SESSION['Errors'] = ['You have posted too fast.'];
                    header("Location: /Forum/Thread/" . $Thread['id']);
                    die();
                }

                $stmt = $this->Connection->prepare("UPDATE users SET roblox_cooldown = NOW() WHERE roblox_username = ?");
                $res = $stmt->execute([$_SESSION['Roblox']]);

                $stmt = $this->Connection->prepare("UPDATE forum_categories SET forum_last_posted = NOW() WHERE id = ?");
                $stmt->execute([
                    $Category['id'],
                ]);

                $stmt = $this->Connection->prepare("UPDATE forum_threads SET thread_last_updated = NOW() WHERE id = ?");
                $stmt->execute([
                    $Thread['id'],
                ]);

                $stmt = $this->Connection->prepare(
                    "INSERT INTO forum_replies 
                (thread_target, thread_text, thread_author) 
             VALUES 
                (?, ?, ?)"
                );
                $stmt->execute([
                    $Thread['id'],
                    $_POST['description'],
                    $_SESSION['Roblox'],
                ]);
                $stmt = null;
                header("Location: /Forum/Thread/" . $Thread['id']);
            } else {
                $_SESSION['Errors'] = ['thread dont exist'];
                header("Location: /Forum/Thread/" . $Thread['id']);
                die();
            }
        }
    }

    public function GetThreadByID($ID) {
        $stmt = $this->Connection->prepare("SELECT * FROM forum_threads WHERE id = :find");
        $stmt->bindParam(":find", $ID);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function GetReplyByID($ID) {
        $stmt = $this->Connection->prepare("SELECT * FROM forum_replies WHERE id = :find");
        $stmt->bindParam(":find", $ID);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function GetCategoryByID($ID) {
        $stmt = $this->Connection->prepare("SELECT * FROM forum_categories WHERE id = :find");
        $stmt->bindParam(":find", $ID);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function ThreadExists($ID) {
        $stmt = $this->Connection->prepare("SELECT id FROM forum_threads WHERE id = :username");
        $stmt->bindParam(":username", $ID);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    public function CategoryExists($ID) {
        $stmt = $this->Connection->prepare("SELECT id FROM forum_categories WHERE id = :username");
        $stmt->bindParam(":username", $ID);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }
}