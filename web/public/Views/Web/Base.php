<?php
namespace Crapblox\Views;

class ViewBase extends \Crapblox\Configurator {
    public $Connection;
    public $Configuration;
    public $Validator;
    public $Twig;
    public $RCCServiceSOAP;

    function __construct() {
        parent::__construct();
        $this->MakeConnection();

        if(isset($_SESSION['Roblox'])) {
            $Currency = new \Crapblox\Models\Auth\User();
            $Currency = $Currency->GetUserByUsername($_SESSION['Roblox']);
            $this->Twig->addGlobal('Currency', $Currency['roblox_tickets']);

            $UserSearch = $this->Connection->prepare("SELECT id, roblox_wear, roblox_colors, roblox_admin FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $_SESSION['Roblox']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();

            $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_to = :to_user AND friend_status = 'u'");
            $FriendSearch->bindParam(":to_user", $User['id']);
            $FriendSearch->execute();
            $Friends['rows'] = $FriendSearch->rowCount();

            $this->Twig->addGlobal('FriendRequests', $Friends['rows']);

            $TradesSearch = $this->Connection->prepare("SELECT * FROM trades WHERE trade_receiving = :to_user AND trade_status = ''");
            $TradesSearch->bindParam(":to_user", $_SESSION['Roblox']);
            $TradesSearch->execute();
            $Trades['rows'] = $TradesSearch->rowCount();

            $this->Twig->addGlobal('TradeRequests', $Trades['rows']);
            if(isset($_SERVER['HTTP_REFERER'])) {
                $this->Twig->addGlobal('RefURL', $_SERVER['HTTP_REFERER']);
            }

            $NotifSearch = $this->Connection->prepare("SELECT * FROM logs WHERE log_recipient = :to_user AND log_status = 'u'");
            $NotifSearch->bindParam(":to_user", $_SESSION['Roblox']);
            $NotifSearch->execute();
            $Notifs['rows'] = $NotifSearch->rowCount();

            $this->Twig->addGlobal('Notifications', $Notifs['rows']);

            if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
                $AdminNotifSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_approved = 'n'");
                $AdminNotifSearch->execute();
                $Approvals['rows'] = $AdminNotifSearch->rowCount();

                $this->Twig->addGlobal('ApprovalRequests', $Approvals['rows']);

                $AdminNotifSearch = $this->Connection->prepare("SELECT * FROM ads WHERE ad_status = 'd'");
                $AdminNotifSearch->execute();
                $Approvals['rows'] = $AdminNotifSearch->rowCount();

                $this->Twig->addGlobal('AdApprovalRequests', $Approvals['rows']);

                $AdminNotifSearch = $this->Connection->prepare("SELECT * FROM `groups` WHERE group_thumbnail_moderated = 'n'");
                $AdminNotifSearch->execute();
                $Approvals['rows'] = $AdminNotifSearch->rowCount();

                $this->Twig->addGlobal('GroupApprovalRequests', $Approvals['rows']);

                $AdminNotifSearch = $this->Connection->prepare("SELECT * FROM `servers` WHERE server_thumbnail_approve = 'n'");
                $AdminNotifSearch->execute();
                $Approvals['rows'] = $AdminNotifSearch->rowCount();

                $this->Twig->addGlobal('GameApprovalRequests', $Approvals['rows']);

                if(isset($_SERVER['HTTP_REFERER'])) {
                    $this->Twig->addGlobal('RefURL', $_SERVER['HTTP_REFERER']);
                }
                $Admin = true;
            } else {
                $Admin = false;
            }

            if(isset($_SESSION['Roblox'])) {
                $User = new \Crapblox\Models\Auth\User();
                $User = $User->GetUserByUsername($_SESSION['Roblox']);
                $Theme = $User['roblox_theme'];

                $this->Twig->addGlobal('Theme', $Theme);
            }

            $this->Twig->addGlobal('Admin', $Admin);
        }
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
    }
}