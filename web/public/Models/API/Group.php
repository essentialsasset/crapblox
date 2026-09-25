<?php
namespace Crapblox\Models;

class Group extends \Crapblox\Models\ModelBase {
    public function RandomToken(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    public function Create() {
        $Validation = $this->Validator->make($_POST, [
            'title'                     => 'required|min:4|max:30',
            'description'               => 'required|min:3|max:400',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /Create/Group");
            die();
        } else {
            $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_groupcooldown >= NOW() - INTERVAL 10 MINUTE");
            $stmt->bindParam(":username", $_SESSION['Roblox']);
            $stmt->execute();
            if ($stmt->rowCount() === 1) {
                $_SESSION['Errors'] = ['You have created a group too fast.'];
                header("Location: /Create/Group/");
                die();
            }

            if(!isset($_SESSION['Roblox'])) {
                $_SESSION['Errors'] = ['You are not logged in.'];
                header("Location: /Create/Game");
                die();
            }

            if(isset($_FILES['asset']) && $_FILES['asset']['name'] != "") {
                /*$mime_type = mime_content_type($_FILES['asset']['tmp_name']);
                $allowed_file_types = ['image/png', 'image/jpeg'];

                $ff = ["png"];
                $f = pathinfo($_FILES['asset']["name"], PATHINFO_EXTENSION);

                if (!in_array($mime_type, $allowed_file_types)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Create/Group");
                    die();
                }

                if(!in_array($f, $ff)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Create/Group");
                    die();
                }

                if(!exif_imagetype($_FILES['asset']["tmp_name"])) {
                    $_SESSION['Errors'] = ['Thumbnails invalid'];
                    header("Location: /Create/Group");
                    die();
                }

                if ($_FILES["asset"]["size"] > 50000000) {
                    $_SESSION['Errors'] = ['Thumbnails too big bro'];
                    header("Location: /Create/Group");
                    die();
                }*/
            } else {
                $_SESSION['Errors'] = ['Please supply a group thumbnail.'];
                header("Location: /Create/Group");
                die();
            }

            $mime_type = mime_content_type($_FILES['asset']['tmp_name']);
            $allowed_file_types = ['image/png'];

            $ff = ["png"];
            $f = pathinfo($_FILES['asset']["name"], PATHINFO_EXTENSION);

            if (!in_array($mime_type, $allowed_file_types)) {
                $_SESSION['Errors'] = ['Group icons can only use .png'];
                header("Location: /Create/Group");
                die();
            }

            $stmt = $this->Connection->prepare("UPDATE users SET roblox_groupcooldown = NOW() WHERE roblox_username = ?");
            $res = $stmt->execute([ $_SESSION['Roblox'] ]);
            $Token = $this->RandomToken();

            $stmt = $this->Connection->prepare(
                "INSERT INTO `groups` 
                (group_title, group_description, group_owner) 
             VALUES 
                (?, ?, ?)"
            );
            $stmt->execute([
                $_POST['title'],
                $_POST['description'],
                $_SESSION['Roblox'],
            ]);
            $stmt = null;

            $Group = $this->GetGroupByTitle($_POST['title']);
            move_uploaded_file($_FILES['asset']["tmp_name"], "/var/www/volumes/Groups/" . $Group['id'] . "." . $f);

            $stmt = $this->Connection->prepare(
                "INSERT INTO `group_membership` 
                (group_to, group_sent) 
             VALUES 
                (?, ?)"
            );
            $stmt->execute([
                $Group['id'],
                $_SESSION['Roblox'],
            ]);
            $stmt = null;

            header("Location: /Groups/");
        }
    }

    public function DeleteGroup($GroupID) {
        $CatalogSearch = $this->Connection->prepare("SELECT * FROM `groups` WHERE id = :id LIMIT 1");
        $CatalogSearch->bindParam(":id", $GroupID);
        $CatalogSearch->execute();
        $Item = $CatalogSearch->fetch();

        if(!isset($Item['id'])) {
            $_SESSION['Errors'] = ['Your group does not exist.'];
            header("Location: /Groups/");
            die();
        }

        if(@$_SESSION['Roblox'] != $Item['group_owner']) {
            $_SESSION['Errors'] = ['You do not own this group.'];
            header("Location: /Groups/");
            die();
        }

        $stmt = $this->Connection->prepare("DELETE FROM `groups` WHERE id = ? AND group_owner = ?");
        $stmt->execute(
            [
                $GroupID,
                $_SESSION['Roblox'],
            ]
        );

        $_SESSION['Success'] = ['Successfully deleted group.'];
        header("Location: /Groups/");
        die();
    }

    public function Kick($GroupID, $Username) {
        $CatalogSearch = $this->Connection->prepare("SELECT * FROM `groups` WHERE id = :id LIMIT 1");
        $CatalogSearch->bindParam(":id", $GroupID);
        $CatalogSearch->execute();
        $Item = $CatalogSearch->fetch();

        if(!isset($Item['id'])) {
            $_SESSION['Errors'] = ['Your group does not exist.'];
            header("Location: /Groups/");
            die();
        }

        if(@$_SESSION['Roblox'] != $Item['group_owner']) {
            $_SESSION['Errors'] = ['You do not own this group.'];
            header("Location: /Groups/");
            die();
        }

        $stmt = $this->Connection->prepare("DELETE FROM `group_membership` WHERE group_to = ? AND group_sent = ?");
        $stmt->execute(
            [
                $GroupID,
                $Username,
            ]
        );

        $_SESSION['Success'] = ['Successfully kicked user.'];
        header("Location: /Groups/" . $GroupID);
        die();
    }

    public function EditGroup($GroupID) {
        $Group = $this->GetGroupByID($GroupID);
        if($this->GroupExists($GroupID) && $Group['group_owner'] == $_SESSION['Roblox']) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($_SESSION['Roblox']);

            if(isset($_FILES['asset']) && $_FILES['asset']['name'] != "") {
                $mime_type = mime_content_type($_FILES['asset']['tmp_name']);
                $allowed_file_types = ['image/png', 'image/jpeg'];

                $ff = ["png"];
                $f = pathinfo($_FILES['asset']["name"], PATHINFO_EXTENSION);

                if (!in_array($mime_type, $allowed_file_types)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Edit/Group/" . $Group['id']);
                    die();
                }

                if(!in_array($f, $ff)) {
                    $_SESSION['Errors'] = ['Thumbnails can only use .png'];
                    header("Location: /Edit/Group/" . $Group['id']);
                    die();
                }

                if(!exif_imagetype($_FILES['asset']["tmp_name"])) {
                    $_SESSION['Errors'] = ['Thumbnails invalid'];
                    header("Location: /Edit/Group/" . $Group['id']);
                    die();
                }

                if ($_FILES["asset"]["size"] > 50000000) {
                    $_SESSION['Errors'] = ['Thumbnails too big bro'];
                    header("Location: /Edit/Group/" . $Group['id']);
                    die();
                }
            }

            if(strlen(trim($_POST['description'])) > 500) {
                $_SESSION['Errors'] = ['Your description is too long.'];
                header("Location: /Edit/Group/" . $Group['id']);
                die();
            }

            if(!isset($_POST['description']) || empty(trim($_POST['description']))) {
                $_SESSION['Errors'] = ['Your description is empty.'];
                header("Location: /Edit/Group/" . $Group['id']);
                die();
            }

            if(isset($_FILES['asset']) && $_FILES['asset']['name'] != "") {
                move_uploaded_file($_FILES['asset']["tmp_name"], "/var/www/volumes/Groups/" . $Group['id'] . "." . $f);
            }

            $stmt = $this->Connection->prepare("UPDATE `groups` SET group_thumbnail_moderated = 'n' WHERE id = ?");
            $stmt->execute([
                $Group['id']
            ]);

            $stmt = $this->Connection->prepare("UPDATE `groups` SET group_title = ?, group_description = ? WHERE id = ?");
            $stmt->execute([
                $_POST['title'],
                $_POST['description'],
                $Group['id'],
            ]);
            $_SESSION['Success'] = ['Successfully updated group.'];
            header("Location: /Groups/" . $Group['id']);
            die();
        }
    }

    public function JoinGroup($GroupID) {
        if($this->GroupExists($GroupID)) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($_SESSION['Roblox']);

            $FavoriteSearch = $this->Connection->prepare("SELECT * FROM group_membership WHERE group_to = :to AND group_sent = :by LIMIT 1");
            $FavoriteSearch->bindParam(":to", $GroupID);
            $FavoriteSearch->bindParam(":by", $_SESSION['Roblox']);
            $FavoriteSearch->execute();
            $Favorite = $FavoriteSearch->fetch();

            $FavoriteSearch = $this->Connection->prepare("SELECT * FROM `groups` WHERE id = :to");
            $FavoriteSearch->bindParam(":to", $GroupID);
            $FavoriteSearch->execute();
            $Group = $FavoriteSearch->fetch();

            if (!isset($Favorite['id'])) {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO group_membership
                        (group_to, group_sent) 
                    VALUES 
                        (?, ?)"
                );
                $stmt->execute([
                    $GroupID,
                    $_SESSION['Roblox'],
                ]);
            } else {
                if($_SESSION['Roblox'] != $Group['group_owner']) {
                    $stmt = $this->Connection->prepare("DELETE FROM group_membership WHERE group_to = ? AND group_sent = ?");
                    $stmt->execute(
                        [
                            $GroupID,
                            $_SESSION['Roblox'],
                        ]
                    );
                } else {
                    $_SESSION['Errors'] = ['You cannot leave your own group.'];
                    header("Location: /Groups/" . $Group['id']);
                    die();
                }
            }
        }

        header("Location: /Groups/" . $GroupID);
    }

    public function GetSharePrice($GroupID)
    {
        if($this->GroupExists($GroupID)) {
            $Group = $this->GetGroupByID($GroupID);
            if($Group["group_stocks"] == 0)
                return 0;
            $Price = $Group["group_funds"] / $Group["group_stocks"]; 
            return ceil($Price);
        }
        return 0.0;
    }

    public function UserBuyShares($GroupID)
    {
        if(getenv("STOCKS") === "OFF")
        {
            header("Location: /");
            die();
        }

        if($this->GroupExists($GroupID)) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($_SESSION['Roblox']);

            $Group = $this->GetGroupByID($GroupID); 
            $SharePrice = $this->GetSharePrice($GroupID);            
            $Shares = intval($_POST["shares"]);
            if(!is_integer($Shares))
            {
                $_SESSION["Errors"] = array("Not an integer value");
                header("Location: /Stocks/Group/" . $GroupID);
                die();
            }
            if($Shares < 0)
            {
                $_SESSION["Errors"] = array("Stocks below 0");
                header("Location: /Stocks/Group/" . $GroupID);
                die();
            }
    
            $Price = $SharePrice * $Shares;
            if($User['roblox_tickets'] < $Price)
            {
                $_SESSION["Errors"] = array("You do not have enough money to buy that amount of stock (you need " . $Price . " zuo)");
                header("Location: /Stocks/Group/" . $GroupID);
                die();
            }    
            if($Group["group_stocks_available"] < $Shares)
            {
                $_SESSION["Errors"] = array("The group does not have enough shares available for you");
                header("Location: /Stocks/Group/" . $GroupID);
                die();
            }
            if($Group["group_stocks_forsale"] > $Group["group_stocks_available"] - $Shares)
            {
                $_SESSION["Errors"] = array("The group does not have enough shares for sale for you");
                header("Location: /Stocks/Group/" . $GroupID);
                die();
            }
            $stmt = $this->Connection->prepare("UPDATE `groups` SET group_stocks_available = ?, group_funds = ? WHERE id = ?");
            $stmt->execute([
                $Group["group_stocks_available"] - $Shares,
                $Group["group_funds"] + $Price,
                $GroupID,
            ]);
            
            $StockInfo = json_decode($User["roblox_stocks"], true);
            if(!isset($StockInfo[$GroupID-1]))
                $StockInfo[$GroupID-1] = 0;
            $StockInfo[$GroupID-1] += $Shares;
            
            $stmt = $this->Connection->prepare("UPDATE users SET roblox_stocks = ?, roblox_tickets = ? WHERE id = ?");
            $stmt->execute([
                json_encode($StockInfo),
                $User["roblox_tickets"] - $Price,
                $User["id"]
            ]);    
            
            $this->PostGroupRSS($GroupID, json_encode([
                "event_type" => "CRAPSTOCKEVENT_GROUP_USER_BUY_SHARES",
                "event_value" => array($User["id"], $Shares, $SharePrice),
            ]));

            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }
    }

    public function UserSellShares($GroupID)
    {
        if(getenv("STOCKS") === "OFF")
        {
            header("Location: /");
            die();
        }

        if($this->GroupExists($GroupID)) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($_SESSION['Roblox']);
            $UserStockData = json_decode($User["roblox_stocks"], true);

            if(!isset($UserStockData[$GroupID-1]))
            {
                $_SESSION["Errors"] = array("You do not own any stock in this group");
                die();
            }

            $Shares = intval($_POST["shares"]);
            if(!is_integer($Shares))
            {
                $_SESSION["Errors"] = array("Not an integer value");
                header("Location: /Stocks/Group/" . $GroupID);
                die();
            }
            if($Shares < 0)
            {
                $_SESSION["Errors"] = array("Stocks below 0");
                header("Location: /Stocks/Group/" . $GroupID);
                die();
            }
            if($Shares > $UserStockData[$GroupID-1])
            {
                $_SESSION["Errors"] = array("You dont have that much stock");
                header("Location: /Stocks/Group/" . $GroupID);
                die();
            }

            $Group = $this->GetGroupByID($GroupID);
            $SharePrice = $this->GetSharePrice($GroupID);   
            $Price = $this->GetSharePrice($GroupID) * $Shares;

            if($Group["group_funds"] < $Price)
            {
                $_SESSION["Errors"] = array("The group cant pay you back for the stock you own");
                header("Location: /Stocks/Group/" . $GroupID);
                die();
            }

            $stmt = $this->Connection->prepare("UPDATE `groups` SET group_stocks_available = ?, group_funds = ? WHERE id = ?");
            $stmt->execute([
                $Group["group_stocks_available"] + $Shares,
                $Group["group_funds"] - $Price,
                $GroupID,
            ]);
            
            $UserStockData[$GroupID-1] -= $Shares;
            
            $stmt = $this->Connection->prepare("UPDATE users SET roblox_stocks = ?, roblox_tickets = ? WHERE id = ?");
            $stmt->execute([
                json_encode($UserStockData),
                $User["roblox_tickets"] + ($Price - ($Price * 0.2)),
                $User["id"]
            ]); 

            $this->PostGroupRSS($GroupID, json_encode([
                "event_type" => "CRAPSTOCKEVENT_GROUP_USER_SELL_SHARES",
                "event_value" => array("user_id" => $User["roblox_username"], "shares" => $Shares, "price" => $Price),
            ]));

            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }
    }

    public function PostGroupRSS($GroupID, $RSSData)
    {
        $stmt = $this->Connection->prepare(
            "INSERT INTO group_rss 
                    (group_rss_data, group_id, group_rss_time) 
                VALUES 
                    (?, ?, ?)"
        );
        $stmt->execute([
            $RSSData,
            $GroupID,
            date('Y-m-d H:i:s')
        ]);
        $stmt = null;
    }

    public function GroupRSS($GroupID)
    {
        $stmt = $this->Connection->prepare("SELECT * FROM `group_rss` WHERE group_id = :find ORDER BY group_rss_time DESC");
        $stmt->bindParam(":find", $GroupID);
        $stmt->execute();
        if($stmt->rowCount() === 0)
        {
            echo json_encode(array("message" => "Absolutely no feed data on this group"));
            return;
        }
        $stmt = $stmt->fetchAll();
        $Logs = array();
        foreach($stmt as $Log)
        {
            if(isset($_GET["since"]))
                if(strtotime($Log["group_rss_time"]) < $_GET["since"])
                    continue;
            if(isset($_GET["limit"]))
                if(sizeof($Logs) >= $_GET["limit"])
                    break;
            $Logs[] = [
                "event_time" => strtotime($Log["group_rss_time"]),
                "event_group" => $Log["group_id"],
                "event_data" => json_decode($Log["group_rss_data"]),
            ];
        }
        if(sizeof($Logs) == 0)
        {
            echo json_encode(array(array("message" => "There was data here but it was all filtered")));
            return;
        }
        echo json_encode($Logs);
    }

    public function GroupRebuyPrice($GroupID)
    {
        $Group = $this->GetGroupByID($GroupID);
        $Price = $this->GetSharePrice($GroupID) * ($Group["group_stocks"] - $Group["group_stocks_available"]) * 1.2;
        return ceil($Price);
    }

    public function GroupRebuyStocks($GroupID)
    {
        if(getenv("STOCKS") === "OFF")
        {
            header("Location: /");
            die();
        }

        $User = new \Crapblox\Models\Auth\User();
        $LoginUser = $User->GetUserByUsername($_SESSION['Roblox']);
        $Group = $this->GetGroupByID($GroupID);
        if($LoginUser["roblox_username"] !== $Group["group_owner"] && $LoginUser["roblox_admin"] !== "y")
        {
            $_SESSION["Errors"] = array("You do not own this group");
            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }
        $SharePrice = $this->GetSharePrice($GroupID);
        $Shares = $Group["group_stocks"] - $Group["group_stocks_available"];
        $Price = $this->GroupRebuyPrice($GroupID);

        if($LoginUser['roblox_tickets'] < $Price)
        {
            $_SESSION["Errors"] = array("You do not have enough money to repay all of your shareholders");
            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }

        $stmt = $this->Connection->prepare("UPDATE users SET roblox_tickets = ? WHERE roblox_username = ?");
        $stmt->execute([
            $LoginUser['roblox_tickets'] - $Price,
            $LoginUser['roblox_username'],
        ]);

        $_POST["shares"] = 0;
        $stmt = $this->Connection->prepare("UPDATE `groups` SET group_stocks = ?, group_stocks_available = ?, group_funds = ? WHERE id = ?");
        $stmt->execute([
            0, 0, 0,
            $GroupID,
        ]);

        $_SESSION["Successes"] = array("Rebought " . $Shares . " stocks for " . $Price . " zuos");
        $this->PostGroupRSS($GroupID, json_encode([
            "event_type" => "CRAPSTOCKEVENT_GROUP_USER_REBUY_SHARES",
            "event_value" => array("username" => $LoginUser["roblox_username"], "shares" => $Shares, "price" => $Price),
        ]));            
        $Logger = new \Crapblox\Models\Log();
        $Logger->Log("**" . $_SESSION['Roblox'] . "** rebought " . $Shares . " shares in " . $Group["group_title"] . " for " . $Price . " zuos");

        $stmt = $this->Connection->prepare("SELECT id, roblox_stocks, roblox_tickets, roblox_username FROM users");
        $stmt->execute([]);
        $Shareholders = $stmt->fetchAll();
        foreach($Shareholders as $Shareholder)
        {
            $Stocks = json_decode($Shareholder["roblox_stocks"], true);
            if(isset($Stocks[$GroupID-1]) && $Stocks[$GroupID-1] != 0)
            {
                $Money = ceil($Stocks[$GroupID-1] * $SharePrice);
                $Stocks[$GroupID - 1] = 0;
                $Logger->Notify(sprintf("%s bought back %d of your stocks for %d zuos.", $_SESSION["Roblox"], $Stocks[$GroupID-1], $Money), $Shareholder["roblox_username"], $_SESSION['Roblox'], "Stock Update");
                $stmt = $this->Connection->prepare("UPDATE users SET roblox_stocks = ?, roblox_tickets = ? WHERE id = ?");
                $stmt->execute([
                    json_encode($Stocks),
                    $Shareholder["roblox_tickets"] + $Money,
                    $Shareholder["id"]
                ]);                    
            }
        }

        header("Location: /Groups/" . $GroupID);
    }

    public function GroupSetSharesForSale($GroupID)
    {
        $Shares = intval($_POST["shares"]);        
        $User = new \Crapblox\Models\Auth\User();
        $LoginUser = $User->GetUserByUsername($_SESSION['Roblox']);
        $Group = $this->GetGroupByID($GroupID);
        if($LoginUser["roblox_username"] !== $Group["group_owner"] && $LoginUser["roblox_admin"] !== "y")
        {
            $_SESSION["Errors"] = array("You do not own this group");
            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }
        if(!is_integer($Shares))
        {
            $_SESSION["Errors"] = array("Not an integer value");
            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }
        if($Shares < 0)
        {
            $_SESSION["Errors"] = array("Stocks below 0");
            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }
        if($Shares > $Group["group_stocks"])
        {
            $_SESSION["Errors"] = array("Stocks above amount of stocks available");
            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }
        $stmt = $this->Connection->prepare("UPDATE `groups` SET group_stocks_forsale = ? WHERE id = ?");
        $stmt->execute([
            $Shares,
            $GroupID,
        ]);
        $this->PostGroupRSS($GroupID, json_encode([
            "event_type" => "CRAPSTOCKEVENT_GROUP_SET_FORSALE",
            "event_value" => array("shares" => $Shares),
        ]));
        header("Location: /Stocks/Group/" . $GroupID);
    }

    public function GroupSetShares($GroupID)
    {
        $Shares = intval($_POST["shares"]);
        if(!is_integer($Shares))
        {
            $_SESSION["Errors"] = array("Not an integer value");
            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }
        if($Shares < 0)
        {
            $_SESSION["Errors"] = array("Stocks below 0");
            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }
        if($Shares > 1000)
        {
            $_SESSION["Errors"] = array("Stocks above 1000");
            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }        
        $User = new \Crapblox\Models\Auth\User();
        $LoginUser = $User->GetUserByUsername($_SESSION['Roblox']);
        $Group = $this->GetGroupByID($GroupID);
        if($LoginUser["roblox_username"] !== $Group["group_owner"] && $LoginUser["roblox_admin"] !== "y")
        {
            $_SESSION["Errors"] = array("You do not own this group");
            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }
        if($LoginUser["roblox_tickets"] < $Shares)
        {
            $_SESSION["Errors"] = array("You do not have enough money for a deposit");
            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }
        if($Group["group_stocks"] != $Group["group_stocks_available"])
        {
            $_SESSION["Errors"] = array("You do not own every stock in this group");
            header("Location: /Stocks/Group/" . $GroupID);
            die();
        }
        $stmt = $this->Connection->prepare("UPDATE `groups` SET group_stocks = ?, group_stocks_available = ?, group_funds = ? WHERE id = ?");
        $stmt->execute([
            $Shares,
            $Shares,
            $Group["group_funds"] + $Shares,
            $GroupID,
        ]);
        $stmt = $this->Connection->prepare("UPDATE `users` SET roblox_tickets = ? WHERE id = ?");
        $stmt->execute([
            $LoginUser["roblox_tickets"] - $Shares,
            $LoginUser["id"],
        ]);
        $this->PostGroupRSS($GroupID, json_encode([
            "event_type" => "CRAPSTOCKEVENT_GROUP_SET_SHARES",
            "event_value" => array("shares" => $Shares, "share_price" => $this->GetSharePrice($GroupID)),
        ]));
        $Logger = new \Crapblox\Models\Log();
        $Logger->Log("**" . $_SESSION['Roblox'] . "** set group shares to " . $Shares . " on group " . $Group["group_title"]);
        header("Location: /Groups/" . $GroupID);
    }

    public function GetGroupByTitle($GameID) {
        $stmt = $this->Connection->prepare("SELECT * FROM `groups` WHERE group_title = :find");
        $stmt->bindParam(":find", $GameID);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function GetGroupByID($GameID) {
        $stmt = $this->Connection->prepare("SELECT * FROM `groups` WHERE id = :find");
        $stmt->bindParam(":find", $GameID);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function GroupExists($GameID) {
        $stmt = $this->Connection->prepare("SELECT id FROM `groups` WHERE id = :username");
        $stmt->bindParam(":username", $GameID);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }
}