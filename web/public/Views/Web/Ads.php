<?php
namespace Crapblox\Views;

class Ads extends ViewBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function View() {
        $UserSearch = $this->Connection->prepare("SELECT roblox_admin FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $_SESSION['Roblox']);
        $UserSearch->execute();
        $IsAdmin = $UserSearch->fetch();

        $AdSearch = $this->Connection->prepare("SELECT * FROM ads WHERE ad_author = :owner ORDER BY id DESC");
        $AdSearch->bindParam(":owner", $_SESSION['Roblox']);
        $AdSearch->execute();

        while($Ad = $AdSearch->fetch(\PDO::FETCH_ASSOC)) {
            $Ads[] = $Ad;
        }

        $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
        $AdSearch->execute();
        $AdRandom = $AdSearch->fetch();

        echo $this->Twig->render('Ads.twig', array(
            "IsAdmin" => ($IsAdmin['roblox_admin'] == 'y') ? true : false,
            "Ads"     => @$Ads,
            "Ad"     => @$AdRandom,
            "PageSettings" => $this->PageSettings(),
        ));
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Ads",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}