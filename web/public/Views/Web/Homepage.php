<?php
namespace Crapblox\Views;

class Homepage extends ViewBase {
    public function View() {
        if(!isset($_SESSION['Roblox'])) {
            echo $this->Twig->render('Homepage.twig', array(
                "PageSettings" => $this->PageSettings(),
            ));
        } else {
            header("Location: /Feed");
        }
    }

    public function SignUp() {
        if(!isset($_SESSION['Roblox'])) {
            echo $this->Twig->render('SignUp.twig', array(
                "PageSettings" => $this->PageSettings(),
                "PublicKey" => getenv("RECAPTCHA_PUBLIC"),
            ));
        } else {
                header("Location: /Feed");
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Homepage",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }

    public function ViewScriptIcon() {
        echo @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Thumbs/Script.png");
    }
}