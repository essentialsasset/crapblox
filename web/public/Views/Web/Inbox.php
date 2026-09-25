<?php
namespace Crapblox\Views;
use \Crapblox\Models\Auth;

class Inbox extends \Crapblox\Views\ViewBase {
    public function View() {
        $Auth = new \Crapblox\Models\Auth\User();

        if(isset($_SESSION['Roblox'])) {
            $User = new Auth\User();
            $User = $Auth->GetUserByUsername($_SESSION['Roblox']);

            $ItemsPerPage = 24;

            $stmt = $this->Connection->prepare("UPDATE logs SET log_status = 'r' WHERE log_recipient = ?");
            $stmt->execute([
                $_SESSION['Roblox'],
            ]);
            $stmt = null;

            if(isset($_GET['page'])) {
                $Offset = ((int)$_GET['page'] * $ItemsPerPage) - $ItemsPerPage;
                $MessgesSearch = $this->Connection->prepare("SELECT * FROM logs WHERE log_recipient = :user ORDER BY id DESC LIMIT " . $Offset . ",24");
                $MessgesSearch->bindParam(":user", $_SESSION['Roblox']);
            } else {
                $MessgesSearch = $this->Connection->prepare("SELECT * FROM logs WHERE log_recipient = :user ORDER BY id DESC LIMIT 24");
                $MessgesSearch->bindParam(":user", $_SESSION['Roblox']);
            }

            if(strpos($_SERVER['REQUEST_URI'], "Sent") !== false) {
                if(isset($_GET['page'])) {
                    $Offset = ((int)$_GET['page'] * $ItemsPerPage) - $ItemsPerPage;
                    $MessgesSearch = $this->Connection->prepare("SELECT * FROM logs WHERE log_sender = :user ORDER BY id DESC LIMIT " . $Offset . ",24");
                    $MessgesSearch->bindParam(":user", $_SESSION['Roblox']);
                } else {
                    $MessgesSearch = $this->Connection->prepare("SELECT * FROM logs WHERE log_sender = :user ORDER BY id DESC LIMIT 24");
                    $MessgesSearch->bindParam(":user", $_SESSION['Roblox']);
                }
            }

            $MessgesSearch->execute();

            $UserLengthSearch = $this->Connection->prepare("SELECT id FROM users");
            $UserLengthSearch->execute();

            $Messages['rows'] = $UserLengthSearch->rowCount();
            $Pages = round($Messages['rows'] / $ItemsPerPage);

            while($Message = $MessgesSearch->fetch(\PDO::FETCH_ASSOC)) {
                $User = new \Crapblox\Models\Auth\User();
                $User = $User->GetIDByUsername($Message['log_sender']);
                $Message['profile_picture'] = @$User['id'];
                $Messages[] = $Message;
            }

            $Messages['rows'] = $UserLengthSearch->rowCount();

            echo $this->Twig->render('Inbox/Index.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $User,
                "Messages"         => $Messages,
                "url" => "/Inbox/?page=",
                "total" => $Pages,
                "current" => $_GET['page'] ?? 1,
                "nearbyPagesLimit" => 4,
            ));
        } else {
            header("Location: /");
        }
    }

    public function Compose($Username = "") {
        $Auth = new \Crapblox\Models\Auth\User();

        if(isset($_SESSION['Roblox'])) {
            if($Username != "" && !$Auth->UserExists($Username)) {
                header("Location: /");
            }

            $User = new Auth\User();
            $User = $Auth->GetUserByUsername($_SESSION['Roblox']);

            echo $this->Twig->render('Inbox/Compose.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $User,
                "Recipient"    => @$Username,
            ));
        } else {
            header("Location: /");
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Inbox",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}