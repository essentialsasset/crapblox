<?php
namespace Crapblox;

class Base extends Configurator {
    public $Connection;
    public $Configuration;
    public $Twig;
    public $RCCServiceSoap;
    public $RobloxColors;
    public $FullColors;

    function __construct() {
        parent::__construct();
        $this->MakeConnection();
    }

    function MakeConnection() {
        try
        {
            $this->Connection = new \PDO("mysql:host=" . $this->Configuration->Database->DatabaseHost . ";dbname=" . $this->Configuration->Database->DatabaseName . ";charset=utf8mb4",
                $this->Configuration->Database->DatabaseUsername,
                $this->Configuration->Database->DatabasePassword,
                [
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ]
            );
        }
        catch(\PDOException $e)
        {
            die("An error occured connecting to the database: " . $e->getMessage());
        }

        if(isset($_COOKIE["CRAPBLOZZSECURITY"]))
        {
            $Auth = new \Crapblox\Models\Auth();
            $User = new \Crapblox\Models\Auth\User();
            $OwnerTokenHash = $Auth->GetCookieToken($_COOKIE['CRAPBLOZZSECURITY']);
            $OwnerTokenUser = $Auth->GetCookieOwner($_COOKIE['CRAPBLOZZSECURITY']);
            $LoginUser = $User->GetUserByUsername($OwnerTokenUser);
            if($LoginUser)
            {
                if($OwnerTokenHash === $Auth->HashToken($LoginUser["roblox_token"], $LoginUser["id"]))
                {
                    $_SESSION["Roblox"] = $LoginUser["roblox_username"];
                    $_SESSION["Token"] = $LoginUser["roblox_token"];    
                    if($LoginUser["roblox_admin"] == "y" || $LoginUser["roblox_admin"] == "c")
                        $_SESSION['Admin']  = $LoginUser['roblox_admin'];
                }
            }       
        }

        // Non-CF IP header
        if(isset($_SERVER['REMOTE_ADDR'])) {
            $SessionIP = $_SERVER['REMOTE_ADDR'];
        }

        // CF IP header
        if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $SessionIP = $_SERVER['HTTP_CF_CONNECTING_IP'];
        }

        if(!isset($SessionIP)) {
            $SessionIP = "0.0.0.0";
        }

        $BanSearch = $this->Connection->prepare("SELECT id FROM bans WHERE ban_user = :user LIMIT 1");
        $BanSearch->bindParam(":user", $SessionIP);
        $BanSearch->execute();
        $BannedUser = $BanSearch->fetch();
        if (isset($BannedUser['id'])) {
            // Show nothing to TROLL!!!!
            die("");
        }

        if(isset($_SESSION['Roblox'])) {
            $UserSearch = $this->Connection->prepare("SELECT id, roblox_admin, roblox_ip FROM users WHERE roblox_username = :user LIMIT 1");
            $UserSearch->bindParam(":user", $_SESSION['Roblox']);
            $UserSearch->execute();
            $LoggedInUser = $UserSearch->fetch();
            if (!isset($LoggedInUser['id'])) {
                header("Location: /API/Auth/Logout");
            }

            if($LoggedInUser["roblox_admin"] == "y" || $LoggedInUser["roblox_admin"] == "c")
                $_SESSION["Admin"] = $LoggedInUser["roblox_admin"];
            else
                unset($_SESSION["Admin"]);

            $BanSearch = $this->Connection->prepare("SELECT id FROM bans WHERE ban_user = :user LIMIT 1");
            $BanSearch->bindParam(":user", $_SESSION['Roblox']);
            $BanSearch->execute();
            $BannedUser = $BanSearch->fetch();
            if (isset($BannedUser['id']) && $_SERVER["REQUEST_URI"] != "/Banned" && $_SERVER["REQUEST_URI"] != "/Banned/Appeal") {
                header("Location: /Banned");
            }

            $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_dailyincome >= NOW() - INTERVAL 1 DAY");
            $stmt->bindParam(":username", $_SESSION['Roblox']);
            $stmt->execute();
            if ($stmt->rowCount() != 1) {
                $stmt = $this->Connection->prepare("UPDATE users SET roblox_dailyincome = NOW() WHERE roblox_username = ?");
                $res = $stmt->execute([$_SESSION['Roblox']]);

                $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets FROM users WHERE roblox_username = :id LIMIT 1");
                $UserSearch->bindParam(":id", $_SESSION['Roblox']);
                $UserSearch->execute();
                $DailyUser = $UserSearch->fetch();

                $stmt = $this->Connection->prepare("UPDATE users SET roblox_robux = ?, roblox_tickets = ? WHERE roblox_username = ?");
                $stmt->execute([
                    $DailyUser['roblox_robux'] + 25,
                    $DailyUser['roblox_tickets'] + 25,
                    $_SESSION['Roblox'],
                ]);
                $stmt = null;
            }

            $stmt = $this->Connection->prepare("UPDATE users SET roblox_lastlogin = NOW() WHERE roblox_username = ?");
            $stmt->execute([
                $_SESSION['Roblox'],
            ]);

            $IPs = $LoggedInUser['roblox_ip'];
            $IPs = explode(",", $IPs);
            array_push($IPs, $SessionIP);
            $IPs = array_unique($IPs);
            $IPs = implode(",", $IPs);

            $stmt = $this->Connection->prepare("UPDATE users SET roblox_ip = ? WHERE roblox_username = ?");
            $stmt->execute([
                $IPs,
                $_SESSION['Roblox'],
            ]);
        }
    }
}