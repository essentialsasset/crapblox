<?php
namespace Crapblox\Views;

class Stocks extends ViewBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function View() {
        $UserSearch = $this->Connection->prepare("SELECT roblox_admin FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $_SESSION['Roblox']);
        $UserSearch->execute();
        $IsAdmin = $UserSearch->fetch();

        $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
        $AdSearch->execute();
        $Ad = $AdSearch->fetch();

        $MarketsSearch = $this->Connection->prepare("SELECT * FROM stock_markets ORDER BY id DESC");
        $MarketsSearch->execute();

        while($Market = $MarketsSearch->fetch(\PDO::FETCH_ASSOC)) {
            $StockMarket[] = $Market;
        }

        $MarketShareSearch = $this->Connection->prepare("SELECT roblox_tickets, roblox_username FROM users ORDER BY id DESC");
        $MarketShareSearch->execute();

        while($Share = $MarketShareSearch->fetch(\PDO::FETCH_ASSOC)) {
            $MarketShare[] = $Share;
        }

        $OwnedStocks = $this->Connection->prepare("SELECT * FROM stock_owned WHERE stock_owned = :owner ORDER BY id DESC");
        $OwnedStocks->bindParam(":owner", $_SESSION['Roblox']);
        $OwnedStocks->execute();

        while($Stocks = $OwnedStocks->fetch(\PDO::FETCH_ASSOC)) {
            $StocksOwned[] = $Stocks;
        }

        $StocksOwned['rows'] = $OwnedStocks->rowCount();

        echo $this->Twig->render('Stocks.twig', array(
            "PageSettings" => $this->PageSettings(),
            "StockMarket"           => @$StockMarket,
            "MarketShare"    => $MarketShare,
            "StocksOwned"    => @$StocksOwned,
        ));
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Stocks",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}