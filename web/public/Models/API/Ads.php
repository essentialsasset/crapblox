<?php
namespace Crapblox\Models;

class Ads extends \Crapblox\Models\ModelBase {
    public function Create() {
        $ff = ["jpg", "png", "jpeg"];
        $f = pathinfo($_FILES['ad']["name"], PATHINFO_EXTENSION);

        $Validation = $this->Validator->make($_POST, [
            'link'                        => 'required|min:4',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /Ads");
            die();
        } else {
            if (!filter_var($_POST['link'], FILTER_VALIDATE_URL)) {
                $_SESSION['Errors'] = ['Your URL is invalid.'];
                header("Location: /Ads");
                die();
            }

            if(!exif_imagetype($_FILES['ad']["tmp_name"])) {
                $_SESSION['Errors'] = ['This picture is invalid.'];
                header("Location: /Ads");
                die();
            }

            if ($_FILES["ad"]["size"] > 50000000) {
                $_SESSION['Errors'] = ['This picture is too big.'];
                header("Location: /Ads");
                die();
            }

            $stmt = $this->Connection->prepare("UPDATE users SET roblox_cooldown = NOW() WHERE roblox_username = ?");
            $res = $stmt->execute([ $_SESSION['Roblox'] ]);

            $autoIncrementCache = $this->Connection->query("SET GLOBAL information_schema_stats_expiry=0;");
            $nextId = $this->Connection->query("SHOW TABLE STATUS LIKE 'ads'")->fetch(\PDO::FETCH_ASSOC)['Auto_increment'] + 1;
            move_uploaded_file($_FILES['ad']["tmp_name"], "/var/www/volumes/Ads/" . $nextId . "." . strtolower($f));
            $stmt = $this->Connection->prepare("UPDATE users SET roblox_cooldown = NOW() WHERE roblox_username = ?");
            $res = $stmt->execute([ $_SESSION['Roblox'] ]);
            $stmt = $this->Connection->prepare(
                "INSERT INTO ads 
                (id, ad_target, ad_file, ad_author) 
            VALUES 
                (?, ?, ?, ?)"
            );
            $stmt->execute([
                $nextId,
                $_POST['link'],
                $nextId . "." . $f,
                $_SESSION['Roblox'],
            ]);
            $stmt = null;
            header("Location: /Ads/");
        }
    }
}