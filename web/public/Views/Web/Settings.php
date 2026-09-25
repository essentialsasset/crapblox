<?php
namespace Crapblox\Views;

class Settings extends ViewBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function View() {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
        $AdSearch->execute();
        $Ad = $AdSearch->fetch();

        $TwoFactorImage = $this->TwoFactorAuth->getQRCodeImageAsDataUri('Crapblox', $this->TwoFactorAuthSecret);
        $TwoFactorCode = $this->TwoFactorAuth->getCode($this->TwoFactorAuthSecret);

        if ($this->TwoFactorAuth->verifyCode($this->TwoFactorAuthSecret, $TwoFactorCode) === true) {
            $TwoFactorStatus = true;
        } else {
            $TwoFactorStatus = false;
        }

        echo $this->Twig->render('Settings.twig', array(
            "PageSettings" => $this->PageSettings(),
            "User"         => $User,
            "TwoFactorImage"         => $TwoFactorImage,
            "TwoFactorCode"         => chunk_split($this->TwoFactorAuthSecret, 4, ' '),
            "TwoFactorStatus"         => $TwoFactorStatus,
            "Ad"         => $Ad,
        ));
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Settings",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}