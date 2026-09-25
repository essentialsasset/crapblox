<?php
namespace Crapblox\Views;
use \Crapblox\Models\Auth;

// WHAT THE HELL DOES Automatic conversion of false to array is deprecated mean
error_reporting(E_ALL ^ E_DEPRECATED);

class Trading extends \Crapblox\Views\ViewBase {
    public function Outgoing() {
        if(isset($_SESSION['Roblox'])) {
            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $OwnSearch = $this->Connection->prepare("SELECT * FROM trades WHERE trade_sent = :user ORDER BY id DESC");
            $OwnSearch->bindParam(":user", $_SESSION['Roblox']);
            $OwnSearch->execute();

            $SerialOffsets = [];

            while($Item = $OwnSearch->fetch(\PDO::FETCH_ASSOC)) {
                $Item['trade_receiving_items'] = explode(",", $Item['trade_receiving_items']);
                $Item['trade_giving_items'] = explode(",", $Item['trade_giving_items']);

                if(count($Item['trade_receiving_items']) > 0) {
                    foreach ($Item['trade_receiving_items'] as $ItemID) {
                        $Sent = $Item['trade_sent']; // person who sent trade
                        $Receiving = $Item['trade_receiving']; // person who get trade

                        $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
                        $ItemSearch->bindParam(":id", $ItemID);
                        $ItemSearch->execute();
                        $_Item = $ItemSearch->fetch();

                        $OwnershipSearch = $this->Connection->prepare("SELECT id, asset_owner FROM ownerships WHERE asset_id = :id");
                        $OwnershipSearch->bindParam(":id", $_Item['id']);
                        $OwnershipSearch->execute();

                        $_Item['serial'] = 0;

                        while($Serial = $OwnershipSearch->fetch(\PDO::FETCH_ASSOC)) {
                            if($Serial['asset_owner'] == $_SESSION['Roblox']) {
                                $Item['serial'] += @$SerialOffsets[$Item['id']];
                                @$SerialOffsets[$Item['id']]++;
                                break;
                            }

                            $_Item['serial']++;
                        }

                        if (@$_Item['item_type'] == "Hat" || @$_Item['item_type'] == "Shirt" || @$_Item['item_type'] == "Pants" || @$_Item['item_type'] == "T-Shirt" || @$_Item['item_type'] == "Face" || @$_Item['item_type'] == "Gear" || @$_Item['item_type'] == "Package") {
                            $Trades[$Item['id']][2][] = $_Item;
                        }
                    }
                }

                $SerialOffsets = [];

                if(count($Item['trade_giving_items']) > 0) {
                    foreach (@$Item['trade_giving_items'] as $ItemID) {
                        $Sent = $Item['trade_sent']; // person who sent trade
                        $Receiving = $Item['trade_receiving']; // person who get trade

                        $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
                        $ItemSearch->bindParam(":id", $ItemID);
                        $ItemSearch->execute();
                        $_Item = $ItemSearch->fetch();

                        $OwnershipSearch = $this->Connection->prepare("SELECT id, asset_owner FROM ownerships WHERE asset_id = :id");
                        $OwnershipSearch->bindParam(":id", $_Item['id']);
                        $OwnershipSearch->execute();

                        $_Item['serial'] = 0;

                        while($Serial = $OwnershipSearch->fetch(\PDO::FETCH_ASSOC)) {
                            if($Serial['asset_owner'] == $_SESSION['Roblox']) {
                                $Item['serial'] += @$SerialOffsets[$Item['id']];
                                @$SerialOffsets[$Item['id']]++;
                                break;
                            }
                            $_Item['serial']++;
                        }

                        if (@$_Item['item_type'] == "Hat" || @$_Item['item_type'] == "Shirt" || @$_Item['item_type'] == "Pants" || @$_Item['item_type'] == "T-Shirt" || @$_Item['item_type'] == "Face" || @$_Item['item_type'] == "Gear" || @$_Item['item_type'] == "Package") {
                            $Trades[$Item['id']][1][] = $_Item;
                        }
                    }
                }

                $User = new \Crapblox\Models\Auth\User();
                $User = $User->GetUserByUsername($Item['trade_receiving']);

                $Item['trade_receiving_user_id'] = $User['id'];

                $User = new \Crapblox\Models\Auth\User();
                $User = $User->GetUserByUsername($Item['trade_sent']);

                $Item['trade_sent_user_id'] = $User['id'];

                $Trades[$Item['id']][0] = $Item;
            }

            echo $this->Twig->render('Trades.twig', array(
                "PageSettings" => $this->PageSettings(),
                "Ad" => $Ad,
                "Trades" => @$Trades,
            ));
        } else {
            header("Location: /");
        }
    }

    public function Create($Username) {
        if(isset($_SESSION['Roblox']) && $_SESSION['Roblox'] != $Username   ) {
            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($_SESSION['Roblox']);

            $OwnSearch = $this->Connection->prepare("SELECT * FROM ownerships WHERE asset_owner = :user ORDER BY id DESC");
            $OwnSearch->bindParam(":user", $_SESSION['Roblox']);
            $OwnSearch->execute();
            $wearing = explode(";", $User['roblox_wear']);
            $SerialOffsets = [];

            while($Item = $OwnSearch->fetch(\PDO::FETCH_ASSOC)) {
                $id = $Item['asset_id'];
                $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id AND item_quantity > -1 LIMIT 1");
                $ItemSearch->bindParam(":id", $Item['asset_id']);
                $ItemSearch->execute();
                $Item = $ItemSearch->fetch();

                $UserSearch = $this->Connection->prepare("SELECT id, asset_owner FROM ownerships WHERE asset_id = :id");
                $UserSearch->bindParam(":id", $id);
                $UserSearch->execute();

                $Item['serial'] = 0;

                while($Serial = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                    if($Serial['asset_owner'] == $_SESSION['Roblox']) {
                        $Item['serial'] += @$SerialOffsets[$Item['id']];
                        @$SerialOffsets[$Item['id']]++;
                        break;
                    }

                    $Item['serial']++;
                }

                if(@$Item['item_type'] == "Hat" || @$Item['item_type'] == "Shirt" || @$Item['item_type'] == "Pants" || @$Item['item_type'] == "T-Shirt" || @$Item['item_type'] == "Face" || @$Item['item_type'] == "Gear" || @$Item['item_type'] == "Package") {
                    $WornItems[] = $Item;
                }
            }

            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($Username);

            $OwnSearch = $this->Connection->prepare("SELECT * FROM ownerships WHERE asset_owner = :user ORDER BY id DESC");
            $OwnSearch->bindParam(":user", $Username);
            $OwnSearch->execute();
            $wearing = explode(";", $User['roblox_wear']);
            $SerialOffsets = [];

            while($Item = $OwnSearch->fetch(\PDO::FETCH_ASSOC)) {
                $id = $Item['asset_id'];
                $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id AND item_quantity > -1 LIMIT 1");
                $ItemSearch->bindParam(":id", $Item['asset_id']);
                $ItemSearch->execute();
                $Item = $ItemSearch->fetch();

                $UserSearch = $this->Connection->prepare("SELECT id, asset_owner FROM ownerships WHERE asset_id = :id");
                $UserSearch->bindParam(":id", $Item['id']);
                $UserSearch->execute();

                $Item['serial'] = 0;

                while($Serial = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                    if($Serial['asset_owner'] == $_SESSION['Roblox']) {
                        $Item['serial'] += @$SerialOffsets[$Item['id']];
                        @$SerialOffsets[$Item['id']]++;
                        break;
                    }

                    $Item['serial']++;
                }

                if(@$Item['item_type'] == "Hat" || @$Item['item_type'] == "Shirt" || @$Item['item_type'] == "Pants" || @$Item['item_type'] == "T-Shirt" || @$Item['item_type'] == "Face" || @$Item['item_type'] == "Gear" || @$Item['item_type'] == "Package") {
                    $OtherItems[] = $Item;
                }
            }

            echo $this->Twig->render('CreateTrade.twig', array(
                "PageSettings" => $this->PageSettings(),
                "Ad" => $Ad,
                "WornItems" => @$WornItems,
                "OtherItems" => @$OtherItems,
                "OtherGuy" => @$User,
            ));
        } else {
            header("Location: /");
        }
    }

    public function Incoming() {
        if(isset($_SESSION['Roblox'])) {
            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $OwnSearch = $this->Connection->prepare("SELECT * FROM trades WHERE trade_receiving = :user ORDER BY id DESC");
            $OwnSearch->bindParam(":user", $_SESSION['Roblox']);
            $OwnSearch->execute();
            $SerialOffsets = [];

            while($Item = $OwnSearch->fetch(\PDO::FETCH_ASSOC)) {
                $Item['trade_receiving_items'] = explode(",", $Item['trade_receiving_items']);
                $Item['trade_giving_items'] = explode(",", $Item['trade_giving_items']);

                if(count($Item['trade_receiving_items']) > 0) {
                    foreach ($Item['trade_receiving_items'] as $ItemID) {
                        $Sent = $Item['trade_sent']; // person who sent trade
                        $Receiving = $Item['trade_receiving']; // person who get trade

                        $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
                        $ItemSearch->bindParam(":id", $ItemID);
                        $ItemSearch->execute();
                        $_Item = $ItemSearch->fetch();

                        $UserSearch = $this->Connection->prepare("SELECT id, asset_owner FROM ownerships WHERE asset_id = :id");
                        $UserSearch->bindParam(":id", $_Item['id']);
                        $UserSearch->execute();

                        $_Item['serial'] = 0;

                        while($Serial = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                            if($Serial['asset_owner'] == $_SESSION['Roblox']) {
                                $_Item['serial'] += @$SerialOffsets[$_Item['id']];
                                @$SerialOffsets[$_Item['id']]++;
                                break;
                            }

                            $_Item['serial']++;
                        }

                        if (@$_Item['item_type'] == "Hat" || @$_Item['item_type'] == "Shirt" || @$_Item['item_type'] == "Pants" || @$_Item['item_type'] == "T-Shirt" || @$_Item['item_type'] == "Face" || @$_Item['item_type'] == "Gear" || @$_Item['item_type'] == "Package") {
                            $Trades[$Item['id']][2][] = $_Item;
                        }
                    }
                }
                $SerialOffsets = [];

                if(count($Item['trade_giving_items']) > 0) {
                    foreach (@$Item['trade_giving_items'] as $ItemID) {
                        $Sent = $Item['trade_sent']; // person who sent trade
                        $Receiving = $Item['trade_receiving']; // person who get trade

                        $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
                        $ItemSearch->bindParam(":id", $ItemID);
                        $ItemSearch->execute();
                        $_Item = $ItemSearch->fetch();

                        $UserSearch = $this->Connection->prepare("SELECT id, asset_owner FROM ownerships WHERE asset_id = :id");
                        $UserSearch->bindParam(":id", $_Item['id']);
                        $UserSearch->execute();

                        $_Item['serial'] = 0;

                        while($Serial = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                            if($Serial['asset_owner'] == $Sent) {
                                $_Item['serial'] += @$SerialOffsets[$_Item['id']];
                                @$SerialOffsets[$_Item['id']]++;
                                break;
                            }

                            $_Item['serial']++;
                        }

                        if (@$_Item['item_type'] == "Hat" || @$_Item['item_type'] == "Shirt" || @$_Item['item_type'] == "Pants" || @$_Item['item_type'] == "T-Shirt" || @$_Item['item_type'] == "Face" || @$_Item['item_type'] == "Gear" || @$_Item['item_type'] == "Package") {
                            $Trades[$Item['id']][1][] = $_Item;
                        }
                    }
                }

                $User = new \Crapblox\Models\Auth\User();
                $User = $User->GetUserByUsername($Item['trade_receiving']);

                $Item['trade_receiving_user_id'] = $User['id'];

                $User = new \Crapblox\Models\Auth\User();
                $User = $User->GetUserByUsername($Item['trade_sent']);

                $Item['trade_sent_user_id'] = $User['id'];

                $Trades[$Item['id']][0] = $Item;
            }

            echo $this->Twig->render('TradesIncoming.twig', array(
                "PageSettings" => $this->PageSettings(),
                "Ad" => $Ad,
                "Trades" => @$Trades,
            ));
        } else {
            header("Location: /");
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Trades",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}