<?php
namespace Crapblox\Views;

class Referral extends ViewBase {
    public function View() {
        $ReferralSearch = $this->Connection->prepare("SELECT * FROM referrals WHERE key_from = :key_from ORDER BY id DESC LIMIT 100");
        $ReferralSearch->bindParam(':key_from',  $_SESSION['Roblox'], \PDO::PARAM_STR);
        $ReferralSearch->execute();
        while($Referral = $ReferralSearch->fetch(\PDO::FETCH_ASSOC)) {
            $Referrals[] = $Referral;
        }

        $Referrals['rows'] = $ReferralSearch->rowCount();

        $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
        $AdSearch->execute();
        $Ad = $AdSearch->fetch();

        $Auth = new \Crapblox\Models\Auth\User();

        echo $this->Twig->render('Referral.twig', array(
            "PageSettings" => $this->PageSettings(),
            "User"      => $Auth->GetUserByUsername($_SESSION['Roblox']),
            "Referrals" => $Referrals,
            "Ad"        => $Ad,
        ));
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Referrals",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}