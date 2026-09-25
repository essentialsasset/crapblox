<?php
namespace Crapblox\Views;

class Studio extends ViewBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function View() {
        echo $this->Twig->render('/Studio/Landing.twig', array(
            "PageSettings" => $this->PageSettings(),
        ));
    }

    public function Toolbox() {
        $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_type = 'Model' AND item_visibile = 'y' ORDER BY id DESC");
        $CatalogSearch->execute();

        while($Item = $CatalogSearch->fetch(\PDO::FETCH_ASSOC)) {
            $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id");
            $OwnSearch->bindParam(":id", $Item['id']);
            $OwnSearch->execute();
            $Item['bought'] = $OwnSearch->rowCount();
            $Catalog[] = $Item;
        }

        echo $this->Twig->render('/Game/Toolbox.twig', array(
            "PageSettings" => $this->PageSettings(),
            "Catalog"      => @$Catalog,
        ));
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Settings",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}