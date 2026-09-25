<?php
namespace Crapblox\Models;

class Stocks extends ModelBase {
    public function AddMoney($User, $Amount) {
        $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets, roblox_username FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $User);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        if(!isset($User['id'])) {
            $_SESSION['Errors'] = ['Stock does not exist'];
            header("Location: /Stocks/");
            die();
        }

        //take
        $stmt = $this->Connection->prepare("UPDATE users SET roblox_tickets = ? WHERE roblox_username = ?");
        $stmt->execute([
            $User['roblox_tickets'] + (int)$Amount,
            $User['roblox_username'],
        ]);
        $stmt = null;
        die();
    }
    
    public function AwardItem($Item, $User, $Key) {
        if($Key !== getenv("MMMMOH_ENABLE"))
            die("wrong key");

        $WhitelistedIDs = [54941, 54925, 54921, 54923, 54919, 54917, 54927, 54931, 54935, 54939, 54945];
        if(!in_array((int)$Item, $WhitelistedIDs)) {
            die("not whitelisted");
        }

        $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
        $ItemSearch->bindParam(":id", $Item);
        $ItemSearch->execute();
        $Item = $ItemSearch->fetch();

        $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets, roblox_username FROM users WHERE id = :id LIMIT 1");
        $UserSearch->bindParam(":id", $User);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner LIMIT 1");
        $OwnSearch->bindParam(":owner", $User['roblox_username']);
        $OwnSearch->bindParam(":id", $Item['id']);
        $OwnSearch->execute();
        $Own = $OwnSearch->fetch();
        

        if(isset($Own['id'])) {
            die();
        }

        if($Item['item_quantity'] != -1)
        {
            if($Item['item_quantity'] == 0) {
                die();
            }    
        }

        $stmt = $this->Connection->prepare(
            "INSERT INTO ownerships 
                    (asset_id, asset_owner) 
                 VALUES 
                    (?, ?)"
        );
        $stmt->execute([
            $Item['id'],
            $User['roblox_username'],
        ]);

        $stmt = $this->Connection->prepare(
            "INSERT INTO transactions 
                    (sale_item, sale_by) 
                 VALUES 
                    (?, ?)"
        );
        $stmt->execute([
            $Item['id'],
            $User['roblox_username'],
        ]);

        // if limited
        if($Item['item_quantity'] > 0 ) {
            $stmt = $this->Connection->prepare("UPDATE catalog SET item_quantity = ? WHERE id = ?");
            $stmt->execute([
                $Item['item_quantity'] - 1,
                $Item['id'],
            ]);
            $stmt = null;
        }
    }

    public function SetMoney($User, $Amount) {
        header(500); // tell anyone who wants to use this that they can use RemoveMoney, AddMoney and GetMoney
        die();

        $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets, roblox_username FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $User);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        if(!isset($User['id'])) {
            $_SESSION['Errors'] = ['Stock does not exist'];
            header("Location: /Stocks/");
            die();
        }

        //take
        $stmt = $this->Connection->prepare("UPDATE users SET roblox_tickets = ? WHERE roblox_username = ?");
        $stmt->execute([
            (int)$Amount,
            $User['roblox_username'],
        ]);
        $stmt = null;

        die();
    }

    public function GetMoney($User) {
        $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets, roblox_username FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $User);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        die($User['roblox_tickets']);
    }

    public function RemoveMoney($User, $Amount, $Group) {
        $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets, roblox_username FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $User);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        if(!isset($User['id'])) {
            $_SESSION['Errors'] = ['Stock does not exist'];
            header("Location: /Stocks/");
            die();
        }

        //take
        $stmt = $this->Connection->prepare("UPDATE users SET roblox_tickets = ? WHERE roblox_username = ?");
        $stmt->execute([
            $User['roblox_tickets'] - (int)$Amount,
            $User['roblox_username'],
        ]);
        $stmt = null;
        die();
    }

    public function Buy() {
        $_SESSION['Errors'] = ['Stocks are currently unavailable.'];
        header("Location: /Stocks/");
        die();

        $ItemSearch = $this->Connection->prepare("SELECT * FROM stock_markets WHERE stock_alias = :id LIMIT 1");
        $ItemSearch->bindParam(":id", $_POST['stock']);
        $ItemSearch->execute();
        $Item = $ItemSearch->fetch();

        $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        if(!isset($Item['id'])) {
            $_SESSION['Errors'] = ['Stock does not exist'];
            header("Location: /Stocks/");
            die();
        }

        if (fmod($_POST['amount'],1) !== 0.0) {
            $_SESSION['Errors'] = ['Number of stocks you buy have to be whole.'];
            header("Location: /Stocks/");
            die();
        }

        if(!isset($User['id'])) {
            $_SESSION['Errors'] = ['Stock does not exist'];
            header("Location: /Stocks/");
            die();
        }

        if($Item['stock_price'] != 0 && $User['roblox_tickets'] - ($Item['stock_price'] * $_POST['amount']) <= -1) {
            $_SESSION['Errors'] = ['You do not have enough tickets.'];
            header("Location: /Stocks/");
            die();
        }

        if($_POST['amount'] <= 0) {
            $_SESSION['Errors'] = ['Invalid amount'];
            header("Location: /Stocks/");
            die();
        }

        if($_POST['amount'] > 1000) {
            $_SESSION['Errors'] = ['Too much'];
            header("Location: /Stocks/");
            die();
        }

        $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_stockcooldown >= NOW() - INTERVAL 1 SECOND");
        $stmt->bindParam(":username", $_SESSION['Roblox']);
        $stmt->execute();
        if($stmt->rowCount() === 1) {
            $_SESSION['Errors'] = ['Cooldown wait 1 sec'];
            header("Location: /Stocks/");
            die();
        }

        $stmt = $this->Connection->prepare("UPDATE users SET roblox_stockcooldown = NOW() WHERE roblox_username = ?");
        $res = $stmt->execute([ $_SESSION['Roblox'] ]);

        $stmt = $this->Connection->prepare(
            "INSERT INTO stock_owned 
        (stock_name, stock_amount, stock_owned) 
     VALUES 
        (?, ?, ?)"
        );
        $stmt->execute([
            $_POST['stock'],
            $_POST['amount'],
            $_SESSION['Roblox'],
        ]);

        //take
        $stmt = $this->Connection->prepare("UPDATE users SET roblox_tickets = ? WHERE roblox_username = ?");
        $stmt->execute([
            $User['roblox_tickets'] - ($Item['stock_price'] * $_POST['amount']),
            $_SESSION['Roblox'],
        ]);
        $stmt = null;

        $Item['stock_price'] = (double)$Item['stock_price'] * (rand(8 * 10, 12 * 10) / 100);

        $stmt = $this->Connection->prepare("UPDATE stock_markets SET stock_price = ? WHERE stock_alias = ?");
        $stmt->execute([
            $Item['stock_price'],
            $_POST['stock'],
        ]);
        $stmt = null;

        $_SESSION['Success'] = ['Successfully bought stock.'];
        header("Location: /Stocks/");
        die();
    }

    public function Sell($StockID) {
        $_SESSION['Errors'] = ['Stocks are currently unavailable.'];
        header("Location: /Stocks/");
        die();

        $ItemSearch = $this->Connection->prepare("SELECT * FROM stock_owned WHERE id = :id LIMIT 1");
        $ItemSearch->bindParam(":id", $StockID);
        $ItemSearch->execute();
        $Item = $ItemSearch->fetch();

        $StockOwned = $Item['stock_owned'];

        $ItemSearch = $this->Connection->prepare("SELECT * FROM stock_markets WHERE stock_alias = :id LIMIT 1");
        $ItemSearch->bindParam(":id", $Item['stock_name']);
        $ItemSearch->execute();
        $Item = $ItemSearch->fetch();

        $Price = $Item['stock_price'];

        if($_SESSION['Roblox'] != $StockOwned) {
            $_SESSION['Errors'] = ['ur gya'];
            header("Location: /Stocks/");
            die();
        }

        $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        if(!isset($Item['id'])) {
            $_SESSION['Errors'] = ['Stock does not exist.'];
            header("Location: /Stocks/");
            die();
        }

        /* Create a form handler class... This is extremely ugly */

        $ItemSearch = $this->Connection->prepare("SELECT * FROM stock_owned WHERE id = :id LIMIT 1");
        $ItemSearch->bindParam(":id", $StockID);
        $ItemSearch->execute();
        $Item = $ItemSearch->fetch();

        $stmt = $this->Connection->prepare("UPDATE users SET roblox_tickets = ? WHERE roblox_username = ?");
        $stmt->execute([
            $User['roblox_tickets'] + ($Item['stock_amount'] * $Price),
            $_SESSION['Roblox'],
        ]);
        $stmt = null;

        $ItemSearch = $this->Connection->prepare("SELECT * FROM stock_markets WHERE stock_alias = :id LIMIT 1");
        $ItemSearch->bindParam(":id", $Item['stock_name']);
        $ItemSearch->execute();
        $Item = $ItemSearch->fetch();

        $Item['stock_price'] = (double)$Item['stock_price'] * (rand(8 * 10, 13 * 10) / 100);

        $stmt = $this->Connection->prepare("UPDATE stock_markets SET stock_price = ? WHERE stock_alias = ?");
        $stmt->execute([
            $Item['stock_price'],
            $Item['stock_alias'],
        ]);
        $stmt = null;

        $stmt = $this->Connection->prepare("DELETE FROM stock_owned WHERE id = ? AND stock_owned = ?");
        $stmt->execute(
            [
                $StockID,
                $_SESSION['Roblox'],
            ]
        );

        $_SESSION['Success'] = ['Successfully sold stock.'];
        header("Location: /Stocks/");
        die();
    }
}