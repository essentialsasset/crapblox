<?php
namespace Crapblox\Models;

class Feed extends ModelBase {
    public function New() {
        $Validation = $this->Validator->make($_POST, [
            'comment'                   => 'required|min:4|max:500',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /Feed");
            die();
        } else {
            $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_cooldown >= NOW() - INTERVAL 1 MINUTE");
            $stmt->bindParam(":username", $_SESSION['Roblox']);
            $stmt->execute();
            if ($stmt->rowCount() === 1) {
                $_SESSION['Errors'] = ['You have posted a comment too fast.'];
                header("Location: /Feed");
                die();
            }

            if (!isset($_SESSION['Roblox'])) {
                $_SESSION['Errors'] = ['You are not logged in.'];
                header("Location: /");
                die();
            }

            $stmt = $this->Connection->prepare(
                "INSERT INTO feed 
                    (comment_text, comment_author) 
                 VALUES 
                    (?, ?)"
            );
            $stmt->execute([
                $_POST['comment'],
                $_SESSION['Roblox'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("UPDATE users SET roblox_cooldown = NOW() WHERE roblox_username = ?");
            $res = $stmt->execute([$_SESSION['Roblox']]);

            header("Location: /Feed");
        }
    }
}