<?php
namespace Crapblox\Models;

class Responsive extends ModelBase {
    public function Catalog() {
        if($_GET['limiteds'] == "true") {
            // means only display limiteds
            $Limiteds = "n";
        } else {
            $Limiteds = "y";
        }

        $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_tix > :min AND item_tix < :max" . ($_GET['offsale'] == "false" ? " AND item_visibile = 'y'" : "") . " ORDER BY id DESC");
        $CatalogSearch->bindParam(":min", $_GET['min']);
        $CatalogSearch->bindParam(":max", $_GET['max']);
        $CatalogSearch->execute();

        while($Item = $CatalogSearch->fetch(\PDO::FETCH_ASSOC)) {
            $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id");
            $OwnSearch->bindParam(":id", $Item['id']);
            $OwnSearch->execute();
            $Item['bought'] = $OwnSearch->rowCount();

            if($Item['item_quantity'] != -1) {
                $OwnSearch = $this->Connection->prepare("SELECT item_price FROM resell WHERE item_selling = :id ORDER BY item_price");
                $OwnSearch->bindParam(":id", $Item['id']);
                $OwnSearch->execute();
                $Deal = $OwnSearch->fetch();
                $Item['lowest_bid'] = @$Deal['item_price'];
            }

            if($Limiteds == "y") {
                if($Item['item_quantity'] > 0) {
                    $Catalog[] = $Item;
                }
            }

            $Catalog[] = $Item;
        }

        echo $this->Twig->render('Responsive/Catalog.twig', array(
            "Catalog"      => @$Catalog,
        ));
    }

    public function Avatar() {
        $search = "%" . $_GET['Search'] . "%";
        $GameSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE concat(item_title, item_description, item_author) LIKE lower(:search) ORDER BY RAND() LIMIT 50");
        $GameSearch->bindParam(':search', $search, \PDO::PARAM_STR);
        $GameSearch->execute();

        while($Game = $GameSearch->fetch(\PDO::FETCH_ASSOC)) {
            $UserSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner");
            $UserSearch->bindParam(":id", $Game['id']);
            $UserSearch->bindParam(":owner", $_SESSION['Roblox']);
            $UserSearch->execute();
            $Ownership = $UserSearch->fetch();

            if(isset($Ownership['id'])) {
                $Games[] = $Game;
            }
        }

        echo $this->Twig->render('Responsive/Avatar.twig', array(
            "Items"      => @$Games,
        ));
    }

    public function Users() {
        $search = "%" . $_GET['Search'] . "%";
        $GameSearch = $this->Connection->prepare("SELECT * FROM users WHERE concat(roblox_username, roblox_description) LIKE lower(:search) ORDER BY roblox_lastlogin DESC LIMIT 50");
        $GameSearch->bindParam(':search', $search, \PDO::PARAM_STR);
        $GameSearch->execute();

        while($Game = $GameSearch->fetch(\PDO::FETCH_ASSOC)) {
            $LastActive = strtotime($Game['roblox_lastlogin']);
            $Now = strtotime("-5 minutes");
            if($Now > $LastActive) {
                $Game['active'] = false;
            } else {
                $Game['active'] = true;
            }
            $Games[] = $Game;
        }

        $Games['rows'] = $GameSearch->rowCount();

        echo $this->Twig->render('Responsive/Users.twig', array(
            "Users"      => @$Games,
        ));
    }
}