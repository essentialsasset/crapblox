<?php
namespace Crapblox\Models;

class Theme extends ModelBase {
    public function Set()
    {
        if (isset($_SESSION['Roblox'])) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($_SESSION['Roblox']);

            $stmt = $this->Connection->prepare("UPDATE users SET roblox_theme = ? WHERE roblox_username = ?");
            $stmt->execute([
                $_POST['category'],
                $_SESSION['Roblox'],
            ]);

            header("Location: /Settings");
        }
    }
}