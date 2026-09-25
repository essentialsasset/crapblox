<?php
namespace Crapblox\Views;

class Admin extends ViewBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function View() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            $UserSearch = $this->Connection->prepare("SELECT id, roblox_lastlogin FROM users ORDER BY roblox_lastlogin DESC");
            $UserSearch->execute();
            $OnlineUsers = 0;
            $TotalUsers  = $UserSearch->rowCount();
            $Jobs        = json_decode(@file_get_contents("http://51.79.82.198:2757/?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1"));
            $RunningJobs = [];

            foreach($Jobs->runningGames as $Job) {
                array_push($RunningJobs, $Job);
            }

            while($User = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                $LastActive = strtotime($User['roblox_lastlogin']);
                $Now = strtotime("-10 minutes");
                if($Now < $LastActive) {
                    $OnlineUsers++;
                }
            }

            $LogsSearch = $this->Connection->prepare("SELECT * FROM logs WHERE log_recipient = '' ORDER BY id DESC LIMIT 10");
            $LogsSearch->execute();

            while($Log = $LogsSearch->fetch(\PDO::FETCH_ASSOC)) {
                $Logs[] = $Log;
            }

            echo $this->Twig->render('Admin.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
                "Logs" => $Logs,
                "OnlineUsers" => $OnlineUsers,
                "TotalUsers"  => $TotalUsers,
                "RunningJobs"  => $RunningJobs,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function BanUser() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            echo $this->Twig->render('Admin/Ban.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function UnbanUser() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            echo $this->Twig->render('Admin/Unban.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function NewNews() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            echo $this->Twig->render('Admin/CreateNews.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function PossibleAlts() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            echo $this->Twig->render('Admin/Alts.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function Approval() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_approved = 'n' ORDER BY RAND() LIMIT 50");
            $CatalogSearch->execute();

            while($Item = $CatalogSearch->fetch(\PDO::FETCH_ASSOC)) {
                @$LastActive = strtotime(@$Item['server_ping']);
                $Now = strtotime("-5 minutes");
                if($Now > $LastActive) {
                    $Item['active'] = false;
                } else {
                    $Item['active'] = true;
                }
                $Catalog[] = $Item;
            }

            $GamesSearch = $this->Connection->prepare("SELECT * FROM servers WHERE server_thumbnail_approve = 'n' ORDER BY RAND() LIMIT 50");
            $GamesSearch->execute();

            while($Game = $GamesSearch->fetch(\PDO::FETCH_ASSOC)) {
                $Games[] = $Game;
            }


            $AdsSearch = $this->Connection->prepare("SELECT * FROM ads WHERE ad_status = 'd' ORDER BY id LIMIT 50");
            $AdsSearch->execute();

            while($Ad = $AdsSearch->fetch(\PDO::FETCH_ASSOC)) {
                $Ads[] = $Ad;
            }

            $GroupSearch = $this->Connection->prepare("SELECT * FROM `groups` WHERE group_thumbnail_moderated = 'n' ORDER BY id LIMIT 50");
            $GroupSearch->execute();

            while($Group = $GroupSearch->fetch(\PDO::FETCH_ASSOC)) {
                $Groups[] = $Group;
            }

            echo $this->Twig->render('Admin/ApproveAssets.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
                "Catalog" => @$Catalog,
                "Games" => @$Games,
                "Ads" => @$Ads,
                "Groups" => @$Groups,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function GiveAsset() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            echo $this->Twig->render('Admin/GiveItem.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function DeleteUser() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            echo $this->Twig->render('Admin/DeleteUser.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function ChangeName() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            echo $this->Twig->render('Admin/RenameUser.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function GiveMoolah() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            echo $this->Twig->render('Admin/GiveMoolah.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function CloseGame() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            echo $this->Twig->render('Admin/CloseGame.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function FeatureGame() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            echo $this->Twig->render('Admin/FeatureGame.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function RedactDescription() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            echo $this->Twig->render('Admin/RedactDescription.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function RedactCSS() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        if(($User['roblox_admin'] == "m" || $User['roblox_admin'] == "y")) {
            echo $this->Twig->render('Admin/RedactCSS.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User" => $User,
            ));
        } else {
            header('HTTP/1.0 403 Forbidden');
            header("/");
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Admin Panel",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}