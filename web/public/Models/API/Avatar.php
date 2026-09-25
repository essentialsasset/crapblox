<?php
namespace Crapblox\Models;

class Avatar extends ModelBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function Fetch2013() {
        $assets = [
            "http://dungblx.cf/asset/bodycolors.ashx?id=" . $_GET['id'],
        ];

        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUserID($_GET['id']);

        $wearing = explode(";", $User['roblox_wear']);
        foreach($wearing as $asset) {
            if((int)$asset != 0) {
                $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
                $ItemSearch->bindParam(":id", $asset);
                $ItemSearch->execute();
                $Item = $ItemSearch->fetch();
                if(isset($Item['id'])) {
                    $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner LIMIT 1");
                    $OwnSearch->bindParam(":owner", $User['roblox_username']);
                    $OwnSearch->bindParam(":id", $Item['id']);
                    $OwnSearch->execute();
                    $Own = $OwnSearch->fetch();

                    if(isset($Own['id'])) {
                        if(@$Item['item_approved'] == "y") {
                            if (@$Item['item_type'] == "Hat" || @$Item['item_type'] == "Package" || @$Item['item_type'] == "Heads" || @$Item['item_type'] == "Gear") {
                                array_push($assets, "http://dungblx.cf/Asset/?id=" . (int)$asset);
                            } else {
                                array_push($assets, "http://dungblx.cf/Asset/?id=" . (int)$asset - 1);
                            }
                        }
                    }
                }
            }
        }

        echo implode(";", $assets);
    }

    public function Fetch($UserID) {
        // john doe
        /*
        if(isset($_GET["nojohndoe"]) && $_GET["nojohndoe"] == "true")
        {
            // dont 
        }
        else            
            $UserID = 462;
        */

        $assets = [
            "http://crapblox.com/asset/bodycolors.ashx?id=" . $UserID,
        ];

        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUserID($UserID);

        $wearing = explode(";", $User['roblox_wear']);
        foreach($wearing as $asset) {
            if((int)$asset != 0) {
                $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
                $ItemSearch->bindParam(":id", $asset);
                $ItemSearch->execute();
                $Item = $ItemSearch->fetch();
                if(isset($Item['id'])) {
                    $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner LIMIT 1");
                    $OwnSearch->bindParam(":owner", $User['roblox_username']);
                    $OwnSearch->bindParam(":id", $Item['id']);
                    $OwnSearch->execute();
                    $Own = $OwnSearch->fetch();

                    if(isset($Own['id'])) {
                        if(@$Item['item_approved'] == "y") {
                            if (@$Item['item_type'] == "Hat" || @$Item['item_type'] == "Package" || @$Item['item_type'] == "Heads" || @$Item['item_type'] == "Gear") {
                                array_push($assets, "http://crapblox.com/Asset/?id=" . (int)$asset);
                            } else {
                                array_push($assets, "http://crapblox.com/Asset/?id=" . (int)$asset - 1);
                            }
                        }
                    }
                }
            }
        }

        echo implode(";", $assets);
    }

    public function BodyColors() {
        header("Content-type: text/plain");

        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUserID($_GET['id']);
        $User['roblox_colors'] = json_decode($User['roblox_colors']);
        echo $this->Twig->render('Game/BodyColors.twig', array(
            "PageSettings" => $this->PageSettings(),
            "User"         => $User,
        ));
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Homepage",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}