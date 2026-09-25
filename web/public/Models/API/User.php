<?php
namespace Crapblox\Models\Auth;

class User extends \Crapblox\Models\ModelBase {
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

    public function validateCaptcha($privatekey, $response) {
        $responseData = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$privatekey.'&response='.$response));
        return $responseData->success;
    }

    /**
     * Asynchronously execute/include a PHP file. Does not record the output of the file anywhere.
     *
     * @param string $filename              file to execute, relative to calling script
     * @param string $options               (optional) arguments to pass to file via the command line
     */
    function asyncInclude($filename, $options = '') {
        exec("php -f {$filename} {$options} >> /dev/null &");
    }

    public function RenderAllUsers() {
        die();

        $UserSearch = $this->Connection->prepare("SELECT id, roblox_username, roblox_description, roblox_lastlogin FROM users ORDER BY roblox_lastlogin DESC");
        $UserSearch->execute();

        while($User = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
            $Thumbnail = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', @file_get_contents("http://51.79.82.198:2757/render/bodyshot/" . $User['id'] . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1")));
            file_put_contents("/var/www/volumes/Avatars/" . $User['id'] . ".png", $Thumbnail);

            echo "Finished render for user <code>" . $User['roblox_username'] . "</code><br>";
        }
    }

    public function SetSessionValues($User) {
    }

    public function SigninUser() {
        $Validation = $this->Validator->make($_POST, [
            'username'                  => 'required|min:3|max:20',
            'password'                  => 'required|min:6',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            if($_SERVER['HTTP_USER_AGENT'] == "CrapBlox/WinInet") {
                header("Location: /My/Places.aspx");
            } else {
                header("Location: /");
            }
            die();
        } else {
            $UserExists = $this->Connection->prepare("SELECT roblox_password, roblox_token, id FROM users WHERE BINARY roblox_username = :username");
            $UserExists->bindParam(":username", $_POST['username']);
            $UserExists->execute();

            if(!$UserExists->rowCount()) {
                $_SESSION['Errors'] = ['Incorrect username or password.'];
                if($_SERVER['HTTP_USER_AGENT'] == "CrapBlox/WinInet") {
                    header("Location: /My/Places.aspx");
                } else {
                    header("Location: /");
                }
                die();
            }

            $User = $UserExists->fetch(\PDO::FETCH_ASSOC);
            if(!isset($User['roblox_password'])) {
                $_SESSION['Errors'] = ['Incorrect username or password.'];
                if($_SERVER['HTTP_USER_AGENT'] == "CrapBlox/WinInet") {
                    header("Location: /My/Places.aspx");
                } else {
                    header("Location: /");
                }
                die();
            } else {
                $ReturnedPassword = $User['roblox_password'];
            }

            if(!@password_verify($_POST['password'], $ReturnedPassword)) {
                $_SESSION['Errors'] = ['Incorrect username or password.'];
                if($_SERVER['HTTP_USER_AGENT'] == "CrapBlox/WinInet") {
                    header("Location: /My/Places.aspx");
                } else {
                    header("Location: /");
                }
                die();
            }

            $Logger = new \Crapblox\Models\Log();
            if(isset($_SESSION['_l'])) {
                $Logger->Log("**" . $_POST["username"] . "** logged into the site. (last logged in as: **" . $_SESSION['_l'] . "**)");
            } else {
                $Logger->Log("**" . $_POST["username"] . "** logged into the site.");
            }

            $Auth = new \Crapblox\Models\Auth();
            if($_POST["rememberme"])
                setcookie("CRAPBLOZZSECURITY", $Auth->CreateCookie($User["roblox_token"]), time()+(90*86400), "/", "crapblox.com", true); // 90 days
            $_SESSION['Roblox']  = $_POST["username"];
            $_SESSION['Token']   = $User['roblox_token'];
            $_SESSION['UserID']  = $User['id'];
            if($User["roblox_admin"] == "y" || $User["roblox_admin"] == "c")
                $_SESSION['Admin']  = $User['roblox_admin'];
            $_SESSION['Success'] = ['Successfully logged in as ' . $_POST['username']];

            if($_SERVER['HTTP_USER_AGENT'] == "Roblox/WinInet") {
                header("Location: /My/Places.aspx");
            } else {
                header("Location: /Feed");
            }
        }
    }

    public function CreateUser() {
        $Validation = $this->Validator->make($_POST, [
            'username'                  => 'required|min:2|max:20',
            'password'                  => 'required|min:6',
            //'referral'                  => 'required',
            'password_confirmation'     => 'required|same:password',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /");
            die();
        } else {
            $_SESSION['Errors'] = "Registration is currently disabled.";
            header("Location: /SignUp");
            die();

            if(!isset($_POST['g-recaptcha-response'])){
                $_SESSION['Errors'] = ['CAPTCHA validation failed.'];
                header("Location: /");
                die();
            }
            if(!$this->validateCaptcha(getenv('RECAPTCHA_PRIVATE'), $_POST['g-recaptcha-response'])) {
                $_SESSION['Errors'] = ['CAPTCHA validation failed.'];
                header("Location: /");
                die();
            }

            if(!preg_match('/^[\w]{3,20}+$/', $_POST['username'])){
                $_SESSION['Errors'] = ['Your username contains special characters.'];
                header("Location: /");
                die();
            }

            $UniqueCheck = $this->Connection->prepare("SELECT roblox_username FROM users WHERE roblox_username = lower(:username)");
            $UniqueCheck->bindParam(":username", $_POST['username']);
            $UniqueCheck->execute();
            if($UniqueCheck->rowCount()) {
                $_SESSION['Errors'] = ['There is already a user with the same username.'];
                header("Location: /");
                die();
            }

            /*
            $ReferralCheck = $this->Connection->prepare(
                "SELECT * FROM referrals WHERE key_code = :key_code AND key_status = 'n' LIMIT 1"
            );
            $ReferralCheck->bindParam(":key_code", $_POST['referral']);
            $ReferralCheck->execute();

            if($ReferralCheck->rowCount() != 1) {
                $_SESSION['Errors'] = ['Your key is invalid or it does not exist.'];
                header("Location: /");
                die();
            }
            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("New user " . $_POST["username"] . " is using a key from " . $ReferralCheck->fetch()["key_from"]);
            */

            $stmt = $this->Connection->prepare("INSERT INTO users (roblox_username, roblox_password, roblox_token) VALUES (:username, :password, :token)");
            $Token = $this->RandomToken();
            $Password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(":username", $_POST['username']);
            $stmt->bindParam(":password", $Password);
            $stmt->bindParam(":token",    $Token);
            $stmt->execute();

            /*
            $stmt = $this->Connection->prepare("UPDATE referrals SET key_used = NOW(), key_status = 'u', key_usedby = ? WHERE key_code = ?");
            $stmt->execute([
                $_POST['username'],
                $_POST['referral'],
            ]);
            */

            $_SESSION['Roblox']  = $_POST['username'];

            $UserSearch = $this->Connection->prepare("SELECT id, roblox_wear FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $_SESSION['Roblox']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();

            $Logger = new \Crapblox\Models\Log();
            if(isset($_SESSION['_l'])) {
                $Logger->Log("**" . $_POST["username"] . "** signed up onto the site. (last logged in as: **" . $_SESSION['_l'] . "**)");
            } else {
                $Logger->Log("**" . $_POST["username"] . "** signed up onto the site.");
            }

            $_SESSION['UserID']  = $User['id'];
            $_SESSION['Token']   = $Token;
            $_SESSION['Success'] = ['Successfully logged in as ' . $_POST['username']];
            copy("/var/www/volumes/Avatars/DefaultProfile.png", "/var/www/volumes/Avatars/" . $User['id'] . ".png");

            $Logger = new \Crapblox\Models\Log();
            $Logger->Log("**" . $_SESSION['Roblox'] . "** signed up onto the site.");

            //$Thumbnail = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', @file_get_contents("http://192.168.1.15/Thumbs/Avatar/Generate/" . $User['id'])));
            //file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Avatars/" . $User['id'] . ".png", $Thumbnail);

            header("Location: /Feed");
        }
    }

    public function GenerateNewToken() {
        
    }

    public function UpdateDescription($Username) {
        $Validation = $this->Validator->make($_POST, [
            'comment'                   => 'required|min:4|max:200',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /User/" . $Username);
            die();
        } else {
            $stmt = $this->Connection->prepare("UPDATE users SET roblox_description = ? WHERE roblox_username = ?");
            $stmt->execute([
                $_POST['comment'],
                $_SESSION['Roblox'],
            ]);

            header("Location: /User/" . $Username);
        }
    }

    public function GetUserInfo($UserID) {
        $Auth = $this->UserExistsID($UserID);

        if($Auth) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUserID($UserID);

            $User['roblox_password'] = null;
            $User['roblox_token']    = null;
            $User['roblox_ip']       = null;

            header('Content-Type: application/json; charset=utf-8');
            die(json_encode($User));
        }
    }

    public function GetUserInfoUser($UserID) {
        $Auth = $this->UserExists($UserID);

        if($Auth) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($UserID);

            $User['roblox_password'] = null;
            $User['roblox_token']    = null;
            $User['roblox_ip']       = null;

            header('Content-Type: application/json; charset=utf-8');
            die(json_encode($User));
        }
    }

    public function UpdateCSS($Username) {
        $Validation = $this->Validator->make($_POST, [
            'comment'                   => 'max:4096',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /User/" . $Username);
            die();
        } else {
            $stmt = $this->Connection->prepare("UPDATE users SET roblox_css = ? WHERE roblox_username = ?");
            $stmt->execute([
                $_POST['comment'],
                $_SESSION['Roblox'],
            ]);

            header("Location: /User/" . $Username);
        }
    }

    public function UpdateBodyColors() {
        $Color3 = new \Crapblox\Models\Color();

        $UserSearch = $this->Connection->prepare("SELECT roblox_colors, id FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();
        $User['roblox_colors'] = json_decode($User['roblox_colors']);

        foreach($_POST as $Key => $Color) {
            $User['roblox_colors']->$Key = $Color3->color_getIdFromName($Color, $this->FullColors);
        }

        $User['roblox_colors'] = json_encode($User['roblox_colors']);
        $stmt = $this->Connection->prepare("UPDATE users SET roblox_colors = ? WHERE roblox_username = ?");
        $stmt->execute([
            $User['roblox_colors'],
            $_SESSION['Roblox'],
        ]);
        $stmt = null;

        $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = ?");
        $stmt->execute([$_SESSION['Roblox']]);
        if ($stmt->rowCount() == 1) {
            $Render = new \Crapblox\Models\Thumbnail\RenderServer();
            $Render->RenderUser($User["id"]);
        }

        $_SESSION['Success'] = ['Successfully changed avatar colors.'];
        //header("Location: /Avatar");
        die(@$_SESSION['Success']);
    }

    public function GetUserByUsername($Username) {
        $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :find");
        $stmt->bindParam(":find", $Username);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function GetIDByUsername($Username) {
        $stmt = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :find");
        $stmt->bindParam(":find", $Username);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function GetUserByUserID($UserID) {
        $stmt = $this->Connection->prepare("SELECT * FROM users WHERE id = :find");
        $stmt->bindParam(":find", $UserID);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function GetUserByToken($Token) {
        $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_token = :find");
        $stmt->bindParam(":find", $Token);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function UserExists($Username) {
        $stmt = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :username");
        $stmt->bindParam(":username", $Username);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    public function UserExistsID($Username) {
        $stmt = $this->Connection->prepare("SELECT id FROM users WHERE id = :username");
        $stmt->bindParam(":username", $Username);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    public function Logout() {
        if(isset($_COOKIE["CRAPBLOZZSECURITY"]))
        {
            unset($_COOKIE['CRAPBLOZZSECURITY']); 
            setcookie("CRAPBLOZZSECURITY", null, -1, "/", "crapblox.com", true);
        }

        $Logger = new \Crapblox\Models\Log();
        $Logger->Log("**" . $_SESSION['Roblox'] . "** logged out of their account.");

        $PrevivousLogged = $_SESSION['Roblox'];
        $_SESSION = [];
        session_destroy();
        session_start();
        // _l - used for logging
        $_SESSION['_l'] = $PrevivousLogged;
        header("Location: /");
    }
}