<?php
namespace Crapblox\Views;

class Friends extends ViewBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function View() {
        $UserSearch = $this->Connection->prepare("SELECT id, roblox_wear, roblox_colors FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_to = :to_user AND friend_status = 'u'");
        $FriendSearch->bindParam(":to_user", $User['id']);
        $FriendSearch->execute();
        while($Friend = $FriendSearch->fetch(\PDO::FETCH_ASSOC)) {
            $UserSearch = $this->Connection->prepare("SELECT roblox_username, id FROM users WHERE id = :user LIMIT 1");
            $UserSearch->bindParam(":user", $Friend['friend_by']);
            $UserSearch->execute();
            $User2 = $UserSearch->fetch();
            if(isset($User['id'])) {
                $Friend['roblox_username'] = $User2['roblox_username'];
                $FriendIncomingPending[] = $Friend;
            }
        }

        $FriendIncomingPending['rows'] = $FriendSearch->rowCount();

        $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_by = :to_user AND friend_status = 'u'");
        $FriendSearch->bindParam(":to_user", $User['id']);
        $FriendSearch->execute();
        while($Friend = $FriendSearch->fetch(\PDO::FETCH_ASSOC)) {
            $UserSearch = $this->Connection->prepare("SELECT roblox_username, id FROM users WHERE id = :user LIMIT 1");
            $UserSearch->bindParam(":user", $Friend['friend_by']);
            $UserSearch->execute();
            $User3 = $UserSearch->fetch();
            if(isset($User['id'])) {
                $Friend['roblox_username'] = $User3['roblox_username'];
                $FriendOutgoingPending[] = $Friend;
            }
        }

        $FriendSearch = $this->Connection->prepare("SELECT * FROM friends WHERE friend_status = 'a' AND friend_by = :user OR friend_to = :user2 ");
        $FriendSearch->bindParam(":user", $_SESSION['UserID']);
        $FriendSearch->bindParam(":user2", $_SESSION['UserID']);
        $FriendSearch->execute();
        while($Friend = $FriendSearch->fetch(\PDO::FETCH_ASSOC)) {
            if($Friend['friend_to'] == $_SESSION['UserID'] && $Friend['friend_status'] == "a") {
                $ServerSearch = $this->Connection->prepare("SELECT roblox_username, id, roblox_lastlogin FROM users WHERE id = :id LIMIT 1");
                $ServerSearch->bindParam(":id", $Friend['friend_by']);
                $ServerSearch->execute();
                $Game = $ServerSearch->fetch();
            } else if($Friend['friend_by'] == $_SESSION['UserID'] && $Friend['friend_status'] == "a") {
                $ServerSearch = $this->Connection->prepare("SELECT roblox_username, id, roblox_lastlogin FROM users WHERE id = :id LIMIT 1");
                $ServerSearch->bindParam(":id", $Friend['friend_to']);
                $ServerSearch->execute();
                $Game = $ServerSearch->fetch();
            }

            if(isset($User['id'])) {
                @$Friend['profile_picture'] = @$Game['id'];
                @$Friend['roblox_username'] = @$Game['roblox_username'];
                $Friends[] = @$Friend;
            }
        }

        $Friends['rows'] = $FriendSearch->rowCount();

        echo $this->Twig->render('Friends.twig', array(
            "PageSettings" => $this->PageSettings(),
            "FriendOutgoing" => @$FriendOutgoingPending,
            "FriendIncoming" => @$FriendIncomingPending,
            "Friends"        => @$Friends,
            "User"  => $User,
        ));
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Friends",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}