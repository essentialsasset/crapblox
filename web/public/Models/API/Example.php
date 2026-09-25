<?php
namespace Crapblox\Models;

class Example extends ModelBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function View() {
        echo $this->Twig->render('Homepage.twig', array(
            "PageSettings" => $this->PageSettings(),
        ));
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Homepage",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}