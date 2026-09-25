<?php
namespace Crapblox\Views;
use \Crapblox\Models\Auth;

class Transactions extends \Crapblox\Views\ViewBase {
    public function View() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $User = $Auth->GetUserByUserID($_SESSION['Roblox']);

            // check all catalog items by user & push item id to array
            $CreatedItems = [];

            $ItemSearch = $this->Connection->prepare("SELECT id FROM catalog WHERE item_author = :user");
            $ItemSearch->bindParam(":user", $_SESSION['Roblox']);
            $ItemSearch->execute();
            $Item = $ItemSearch->fetch();
            if(isset($Item['id'])) {
                array_push($CreatedItems, $Item['id']);
            }

            $BoughtSearch = $this->Connection->prepare("SELECT sale_item, id FROM transactions WHERE sale_by = :target ORDER BY id DESC");
            $BoughtSearch->bindParam(":target", $_SESSION['Roblox']);
            $BoughtSearch->execute();

            while($Asset = $BoughtSearch->fetch(\PDO::FETCH_ASSOC)) {
                $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :user LIMIT 1");
                $ItemSearch->bindParam(":user", $Asset['sale_item']);
                $ItemSearch->execute();
                $Item = $ItemSearch->fetch();
                if(isset($Item['id'])) {
                    $Asset['item_title'] = $Item['item_title'];
                    $Asset['item_author'] = $Item['item_author'];
                    $Asset['item_description'] = $Item['item_description'];
                    $Asset['item_id'] = $Item['id'];
                    $Asset['item_tix'] = $Item['item_tix'];
                    $Bought[] = $Asset;
                }
            }

            foreach($CreatedItems as $ItemID) {
                $SoldSearch = $this->Connection->prepare("SELECT sale_item, sale_by, id FROM transactions WHERE sale_item = :target ORDER BY id DESC");
                $SoldSearch->bindParam(":target", $ItemID);
                $SoldSearch->execute();

                while($Asset = $SoldSearch->fetch(\PDO::FETCH_ASSOC)) {
                    $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :user LIMIT 1");
                    $ItemSearch->bindParam(":user", $Asset['sale_item']);
                    $ItemSearch->execute();
                    $Item = $ItemSearch->fetch();
                    if(isset($Item['id'])) {
                        $Asset['item_title'] = $Item['item_title'];
                        $Asset['item_author'] = $Item['item_author'];
                        $Asset['item_description'] = $Item['item_description'];
                        $Asset['item_id'] = $Item['id'];
                        $Asset['item_tix'] = $Item['item_tix'];
                        $Sold[] = $Asset;
                    }
                }
            }

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            echo $this->Twig->render('Transactions.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $User,
                "Bought"         => @$Bought,
                "Sold"         => @$Sold,
                "Ad" => $Ad,
            ));
        } else {
            header("Location: /");
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Transactions",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}