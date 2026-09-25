<?php
namespace Crapblox\Models;

class Trading extends ModelBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function Remove($ID) {
        $Trade = $this->GetTradeByID($ID);

        if($Trade['trade_sent'] == $_SESSION['Roblox']) {
            $stmt = $this->Connection->prepare("DELETE FROM `trades` WHERE id = ? AND trade_sent = ?");
            $stmt->execute(
                [
                    $ID,
                    $_SESSION['Roblox'],
                ]
            );

            header("Location: /Trades/Outgoing");
        } else {
            $_SESSION['Errors'] = ['this is not ur trade bitch'];
            header("Location: /Trades/Outgoing");
            die();
        }
    }

    public function Decline($ID) {
        $Trade = $this->GetTradeByID($ID);

        if($Trade['trade_receiving'] == $_SESSION['Roblox']) {
            $stmt = $this->Connection->prepare("UPDATE trades SET trade_status = 'd' WHERE id = ?");
            $stmt->execute([
                $ID,
            ]);
            $stmt = null;

            header("Location: /Trades/Incoming");
        } else {
            $_SESSION['Errors'] = ['this is not ur trade bitch'];
            header("Location: /Trades/Incoming");
            die();
        }
    }

    public function Accept($ID) {
        $Trade = $this->GetTradeByID($ID);

        if($Trade['trade_receiving'] == $_SESSION['Roblox'] && $Trade['trade_status'] == "") {
            $Trade['trade_receiving_items'] = explode(",", $Trade['trade_receiving_items']);
            $Trade['trade_giving_items'] = explode(",", $Trade['trade_giving_items']);

            // you get these items (eg: from
            foreach($Trade['trade_giving_items'] as $Key => $ItemID) {
                if(is_numeric($ItemID)) {
                    $UserSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner");
                    $UserSearch->bindParam(":id", $ItemID);
                    $UserSearch->bindParam(":owner", $Trade['trade_sent']);
                    $UserSearch->execute();
                    $Ownership = $UserSearch->fetch();

                    if(isset($Ownership['id'])) {
                        /*
                        echo "fart";*/

                        $stmt = $this->Connection->prepare("DELETE FROM ownerships WHERE id = ?");
                        $stmt->execute(
                            [
                                $Ownership['id'],
                            ]
                        );

                        $stmt = $this->Connection->prepare(
                            "INSERT INTO ownerships 
                            (id, asset_id, asset_owner) 
                         VALUES 
                            (?, ?, ?)"
                        );
                        $stmt->execute([
                            $Ownership['id'],
                            $ItemID,
                            $Trade['trade_receiving'],
                        ]);

                        /*
                        $UserSearch = $this->Connection->prepare("SELECT id, asset_owner FROM ownerships WHERE asset_id = :id");
                        $UserSearch->bindParam(":id", $ItemID);
                        $UserSearch->execute();

                        $Item['serial'] = 0;

                        while($Serial = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                            if($Serial['asset_owner'] == $Trade['trade_sent']) {
                                break;
                            }

                            $Item['serial']++;
                        }
                        */

                        echo "getting item " . $ItemID . " from " . $Trade['trade_sent'] . "<br>";
                    }
                }
            }

            // you give these items to other guy
            foreach($Trade['trade_receiving_items'] as $Key => $ItemID) {
                if(is_numeric($ItemID)) {
                    $UserSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner");
                    $UserSearch->bindParam(":id", $ItemID);
                    $UserSearch->bindParam(":owner", $Trade['trade_receiving']);
                    $UserSearch->execute();
                    $Ownership = $UserSearch->fetch();

                    if(isset($Ownership['id'])) {
                        $stmt = $this->Connection->prepare("DELETE FROM ownerships WHERE id = ?");
                        $stmt->execute(
                            [
                                $Ownership['id'],
                            ]
                        );

                        $stmt = $this->Connection->prepare(
                            "INSERT INTO ownerships
                            (id, asset_id, asset_owner)
                         VALUES
                            (?, ?, ?)"
                        );
                        $stmt->execute([
                            $Ownership['id'],
                            $ItemID,
                            $Trade['trade_sent'],
                        ]);

                        /*
                        $UserSearch = $this->Connection->prepare("SELECT id, asset_owner FROM ownerships WHERE asset_id = :id");
                        $UserSearch->bindParam(":id", $ItemID);
                        $UserSearch->execute();

                        $Item['serial'] = 0;

                        while($Serial = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                            if($Serial['asset_owner'] == $Trade['trade_receiving']) {
                                break;
                            }

                            $Item['serial']++;
                        }

                        */

                        echo "giving item " . $ItemID . " to " . $Trade['trade_receiving'] . "<br>"; // " with serial " . $Item['serial'] . "<br>";
                    }
                }
            }

            // die();

            // update trade status
            $stmt = $this->Connection->prepare("UPDATE trades SET trade_status = 'a' WHERE id = ?");
            $stmt->execute([
                $ID,
            ]);
            $stmt = null;

            header("Location: /Trades/Incoming");
        } else {
            $_SESSION['Errors'] = ['this is not ur trade bitch'];
            header("Location: /Trades/Incoming");
            die();
        }
    }

    public function Create($ID) {

        $data = json_decode(@file_get_contents('php://input'), true);

        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByUsername($_SESSION['Roblox']);

        $OtherUser = new \Crapblox\Models\Auth\User();
        $OtherUser = $OtherUser->GetUserByUserID($ID);

        /*
        $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_tradingcooldown >= NOW() - INTERVAL 1 MINUTE");
        $stmt->bindParam(":username", $_SESSION['Roblox']);
        $stmt->execute();
        if($stmt->rowCount() === 1) {
            die("Please 1 minute before sending another trade request.");
        }*/

        $stmt = $this->Connection->prepare("UPDATE users SET roblox_tradingcooldown = NOW() WHERE roblox_username = ?");
        $res = $stmt->execute([ $_SESSION['Roblox'] ]);

        if($ID == $User['id']) {
            die("You cannot send a trade to yourself.");
        }

        if(count($data[0]) == 0 && count($data[1]) == 0) {
            die("You cannot take no items and give no items.");
        }

        //giveBuffer
        foreach($data[0] as $Key => $Item) {
            try {
                $BufferItem = new \Crapblox\Models\Asset();
                $BufferItem = $BufferItem->GetAssetByID($Item);

                if (!isset($BufferItem['id'])) {
                    unset($data[0][$Key]);
                } else {
                    $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner LIMIT 1");
                    $OwnSearch->bindParam(":owner", $_SESSION['Roblox']);
                    $OwnSearch->bindParam(":id", $BufferItem['id']);
                    $OwnSearch->execute();
                    $Own = $OwnSearch->fetch();

                    if (!isset($Own['id'])) {
                        unset($data[0][$Key]);
                    }

                    if (!isset($BufferItem['id'])) {
                        unset($data[0][$Key]);
                    }

                    if ($BufferItem['item_quantity'] == -1) {
                        unset($data[0][$Key]);
                    }
                }
            } catch (Exception $e) {

            }
        }

        $data[0] = array_unique($data[0]);

        //takeBuffer
        foreach($data[1] as $Key => $Item) {
            try {
                $BufferItem = new \Crapblox\Models\Asset();
                $BufferItem = $BufferItem->GetAssetByID($Item);

                if (!isset($BufferItem['id'])) {
                    unset($data[1][$Key]);
                } else {
                    $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner LIMIT 1");
                    $OwnSearch->bindParam(":owner", $OtherUser['roblox_username']);
                    $OwnSearch->bindParam(":id", $BufferItem['id']);
                    $OwnSearch->execute();
                    $Own = $OwnSearch->fetch();

                    if (!isset($Own['id'])) {
                        unset($data[1][$Key]);
                    }

                    if (!isset($BufferItem['id'])) {
                        unset($data[1][$Key]);
                    }

                    if ($BufferItem['item_quantity'] == -1) {
                        unset($data[1][$Key]);
                    }
                }
            } catch (Exception $e) {

            }
        }

        $data[1] = array_unique($data[1]);

        if(count($data[0]) == 0 && count($data[1]) == 0) {
            die("You cannot take no items and give no items.");
        }

        $stmt = $this->Connection->prepare(
            "INSERT INTO trades
                        (trade_receiving_items, trade_giving_items, trade_receiving, trade_sent) 
                    VALUES 
                        (?, ?, ?, ?)"
        );
        $stmt->execute([
            implode(",", $data[1]),
            implode(",", $data[0]),
            $OtherUser['roblox_username'],
            $_SESSION['Roblox'],
        ]);

        die(json_encode((object) ["response" => 200]));
    }

    public function GetTradeByID($TradeID) {
        $stmt = $this->Connection->prepare("SELECT * FROM trades WHERE id = :find");
        $stmt->bindParam(":find", $TradeID);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }
}