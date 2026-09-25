<?php
namespace Crapblox\Models;

class Friends extends ModelBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function AreFriends() {
        $requester = $_GET['userId'];

        $data = [
            'requesting' => false,
            'friends' => false,
            'best_friends' => false
        ];

        $response = "X";

        // https://stackoverflow.com/questions/353379/how-to-get-multiple-parameters-with-same-name-from-a-url-in-php
        $query  = explode('&', $_SERVER['QUERY_STRING']);
        $params = array();

        foreach( $query as $param )
        {
            // prevent notice on explode() if $param has no '='
            if (strpos($param, '=') === false) $param += '=';

            list($name, $value) = explode('=', $param, 2);
            $params[urldecode($name)][] = urldecode($value);
        }

        foreach($params["otherUserIds"] as $id) {
            $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_to = :user");
            $FriendSearch->bindParam(":user", $requester);
            $FriendSearch->execute();
            while($Friend = $FriendSearch->fetch(\PDO::FETCH_ASSOC)) {
                if ($Friend['friend_to'] == $requester && $Friend['friend_status'] == "a") {
                    if($requester != $Friend['friend_by']) {
                        $response .= $Friend['friend_by'] . ",";
                    }
                }
            }

            $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_by = :user");
            $FriendSearch->bindParam(":user", $requester);
            $FriendSearch->execute();
            while($Friend = $FriendSearch->fetch(\PDO::FETCH_ASSOC)) {
                if ($Friend['friend_by'] == $requester && $Friend['friend_status'] == "a") {
                    if($requester != $Friend['friend_to']) {
                        $response .= $Friend['friend_to'] . ",";
                    }
                }
            }
        }

        die($response);
    }

    public function CreateFriend() {
        $firstUserId = $_GET['firstUserId'];
        $secondUserId = $_GET['secondUserId'];

        $UserSearch = $this->Connection->prepare("SELECT id FROM users WHERE id = :user LIMIT 1");
        $UserSearch->bindParam(":user", $firstUserId);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $RecievingSearch = $this->Connection->prepare("SELECT id FROM users WHERE id = :user LIMIT 1");
        $RecievingSearch->bindParam(":user", $secondUserId);
        $RecievingSearch->execute();
        $Reciever = $RecievingSearch->fetch();

        $FriendSearch = $this->Connection->prepare("SELECT friend_to, friend_by, id FROM friends WHERE friend_by = :user AND friend_to = :to_user LIMIT 1");
        $FriendSearch->bindParam(":user", $User['id']);
        $FriendSearch->bindParam(":to_user", $Reciever['id']);
        $FriendSearch->execute();
        $Relationship = $FriendSearch->fetch();

        if(!isset($Relationship['id'])) {
            $stmt = $this->Connection->prepare(
                "INSERT INTO friends 
                (friend_to, friend_by) 
             VALUES 
                (?, ?)"
            );
            $stmt->execute([
                $Reciever['id'],
                $User['id'],
            ]);
            $stmt = null;
        }
    }

    public function New($Username) {
        $UserSearch = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :user LIMIT 1");
        $UserSearch->bindParam(":user", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $RecievingSearch = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :user LIMIT 1");
        $RecievingSearch->bindParam(":user", $Username);
        $RecievingSearch->execute();
        $Reciever = $RecievingSearch->fetch();

        $FriendSearch = $this->Connection->prepare("SELECT friend_to, friend_by, id FROM friends WHERE friend_by = :user AND friend_to = :to_user LIMIT 1");
        $FriendSearch->bindParam(":user", $User['id']);
        $FriendSearch->bindParam(":to_user", $Reciever['id']);
        $FriendSearch->execute();
        $Relationship = $FriendSearch->fetch();

        if(!isset($Relationship['id'])) {
            $stmt = $this->Connection->prepare(
                "INSERT INTO friends 
                (friend_to, friend_by) 
             VALUES 
                (?, ?)"
            );
            $stmt->execute([
                $Reciever['id'],
                $User['id'],
            ]);
            $stmt = null;
        }
        header("Location: /User/" . $Username);
    }

    public function Accept($Username) {
        $UserSearch = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE id = :id LIMIT 1");
        $FriendSearch->bindParam(":id", $Username);
        $FriendSearch->execute();
        $Friend = $FriendSearch->fetch();
        if(!isset($Friend['id'])) {
            die(true);
        }

        if($Friend['friend_to'] != $User['id']) {
            if($Friend['friend_by'] != $User['id']) {
                die();
            }
        }

        $stmt = $this->Connection->prepare("UPDATE friends SET friend_status = 'a' WHERE id = ? AND friend_to = ? AND friend_by = ?");
        $stmt->execute([
            $Friend['id'],
            $Friend['friend_to'],
            $Friend['friend_by'],
        ]);
        $stmt = null;
        $_SESSION['Success'] = ['Successfully accepted friend request.'];
        header("Location: /Friends");
        die();
    }

    public function Decline($Username) {
        $UserSearch = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE id = :id LIMIT 1");
        $FriendSearch->bindParam(":id", $Username);
        $FriendSearch->execute();
        $Friend = $FriendSearch->fetch();
        if(!isset($Friend['id'])) {
            die(true);
        }

        if($Friend['friend_to'] != $User['id']) {
            if($Friend['friend_by'] != $User['id']) {
                die();
            }
        }

        if($User['id'] == $Friend['friend_to'] || $User['id'] == $Friend['friend_to']) {
            $stmt = $this->Connection->prepare("UPDATE friends SET friend_status = 'u' WHERE id = ? AND friend_to = ? AND friend_by = ?");
            $stmt->execute([
                $Friend['id'],
                $Friend['friend_to'],
                $Friend['friend_by'],
            ]);
            $stmt = null;
            header("Location: /Friends");
        }
    }

    public function Revoke($Username) {
        $UserSearch = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE id = :id LIMIT 1");
        $FriendSearch->bindParam(":id", $Username);
        $FriendSearch->execute();
        $Friend = $FriendSearch->fetch();
        if(!isset($Friend['id'])) {
            die(true);
        }

        if($Friend['friend_to'] != $User['id']) {
            if($Friend['friend_by'] != $User['id']) {
                die();
            }
        }

        if($User['id'] == $Friend['friend_to'] || $User['id'] == $Friend['friend_to']) {
            $stmt = $this->Connection->prepare("DELETE FROM friends WHERE id = ? AND friend_to = ? AND friend_by = ?");
            $stmt->execute([
                $Friend['id'],
                $Friend['friend_to'],
                $Friend['friend_by'],
            ]);
            $stmt = null;
            header("Location: /Friends");
        }
    }

    public function IsFriendsWith() {
        /*
        $_GET['playerid'] = (int)$_GET['playerid'];
        $_GET['userid']   = (int)$_GET['userid'];
        $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_by = :user AND friend_to = :to_user LIMIT 1");
        $FriendSearch->bindParam(":user", $_GET['playerid']);
        $FriendSearch->bindParam(":to_user", $_GET['userid']);
        $FriendSearch->execute();
        $RelationshipOutgoing = $FriendSearch->fetch();

        $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_by = :to_user AND friend_to = :user LIMIT 1");
        $FriendSearch->bindParam(":user", $_GET['playerid']);
        $FriendSearch->bindParam(":to_user", $_GET['userid']);
        $FriendSearch->execute();
        $RelationshipIncoming = $FriendSearch->fetch();

        if($RelationshipOutgoing['friend_status'] == "a" || $RelationshipIncoming['friend_status'] == "a") {
            die('<value type="boolean">true</value>');
        } else {
            die('<value type="boolean">false</value>');
        }
        */
        die('<value type="integer">255</value>');
    }
}