<?php
namespace Crapblox\Views;

class NotFound extends ViewBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function View() {
        echo $this->Twig->render('NotFound.twig', array(
            "PageSettings" => $this->PageSettings(),
        ));
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Not Found",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}