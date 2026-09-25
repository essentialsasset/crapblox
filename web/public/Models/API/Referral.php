<?php
namespace Crapblox\Models;

function GenerateRefID() {
    $bytes = random_bytes(20);
    $base64 = base64_encode($bytes);
    return rtrim(strtr($base64, '+/', '_'), '=');
}

class Referral extends ModelBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function Create() {
        $Logger = new \Crapblox\Models\Log();
        $UserSearch = $this->Connection->prepare("SELECT roblox_admin, roblox_cooldown FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_keycooldown >= NOW() - INTERVAL 12 HOUR");
        $stmt->bindParam(":username", $_SESSION['Roblox']);
        $stmt->execute();
        if($stmt->rowCount() === 1 && $User['roblox_admin'] != "y") {
            $_SESSION['Errors'] = ['Wait half a day to create a key.'];
            header("Location: /Referral");
            die();
        }

        /*
        if($User['roblox_admin'] != "y") {
            $_SESSION['Errors'] = ['Admins can only create keys.'];
            header("Location: /Referral");
            die();
        }
        */

        $stmt = $this->Connection->prepare("UPDATE users SET roblox_keycooldown = NOW() WHERE roblox_username = ?");
        $res = $stmt->execute([$_SESSION['Roblox']]);
        $th = "crapblox_" . GenerateRefID();

        $stmt = $this->Connection->prepare(
            "INSERT INTO referrals 
        (key_from, key_code) 
     VALUES 
        (?, ?)"
        );
        $stmt->execute([
            $_SESSION['Roblox'],
            $th,
        ]);
        $stmt = null;

        $Logger->Log("Key created by " . $_SESSION["Roblox"]);
        header("Location: /Referral");
    }

    public function GetReferralsFrom($Username) {
        $stmt = $this->Connection->prepare("SELECT * FROM referrals WHERE key_from = :username");
        $stmt->bindParam(":username", $Username);
        $stmt->execute();
        $Referrals = [];
        while($Referral = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $Referrals[] = $Referral;
        }
        return $Referrals;
    }

    public function GetReferralFor($Username) {
        $stmt = $this->Connection->prepare("SELECT * FROM referrals WHERE key_usedby = :username");
        $stmt->bindParam(":username", $Username);
        $stmt->execute();
        return $stmt->fetch();
    }
}