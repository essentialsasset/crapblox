<?php
namespace Crapblox\Views;
use \Crapblox\Models\Auth;

class Groups extends \Crapblox\Views\ViewBase {
    public function View() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $ItemsPerPage = 7;

            if(isset($_GET['page'])) {
                $Offset = ((int)$_GET['page'] * $ItemsPerPage) - $ItemsPerPage;
                $GroupSearch = $this->Connection->prepare("SELECT * FROM `groups` ORDER BY group_created DESC LIMIT " . $Offset . ",7");
            } else {
                $GroupSearch = $this->Connection->prepare("SELECT * FROM `groups` ORDER BY group_created DESC LIMIT 7;");
            }

            $GroupSearch->execute();

            while($Group = $GroupSearch->fetch(\PDO::FETCH_ASSOC)) {
                $UserSearch = $this->Connection->prepare("SELECT id FROM `group_membership` WHERE group_to = :sent ORDER BY id DESC;");
                $UserSearch->bindParam(":sent", $Group['id']);
                $UserSearch->execute();
                $Group['members'] = $UserSearch->rowCount();
                $Groups[] = $Group;
            }

            $Groups['rows'] = $GroupSearch->rowCount();

            $GroupSearch = $this->Connection->prepare("SELECT id FROM `groups`");
            $GroupSearch->execute();

            $Catalog['rows'] = $GroupSearch->rowCount();
            $Pages = round($Catalog['rows'] / $ItemsPerPage);
            if($Pages == 0) { $Pages = 1; }

            $GroupSearch = $this->Connection->prepare("SELECT * FROM `group_membership` WHERE group_sent = :sent ORDER BY id DESC LIMIT 20;");
            $GroupSearch->bindParam(":sent", $_SESSION['Roblox']);
            $GroupSearch->execute();

            while($AGroup = $GroupSearch->fetch(\PDO::FETCH_ASSOC)) {
                $IndividGroupSearch = $this->Connection->prepare("SELECT * FROM `groups` WHERE id = :id LIMIT 1;");
                $IndividGroupSearch->bindParam(":id", $AGroup['group_to']);
                $IndividGroupSearch->execute();
                $IGroup = $IndividGroupSearch->fetch();
                if(isset($IGroup['id'])) {
                    $GroupsIn[] = $IGroup;
                }
            }

            $GroupsIn['rows'] = $GroupSearch->rowCount();

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            echo $this->Twig->render('Groups.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Groups"       => @$Groups,
                "GroupsIn"     => @$GroupsIn,
                "Ad" => $Ad,
                "url" => "/Groups/?page=",
                "total" => $Pages + 1,
                "current" => $_GET['page'] ?? 1,
                "nearbyPagesLimit" => 4,
            ));
        } else {
            header("Location: /");
        }
    }

    public function CreateView() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();

            echo $this->Twig->render('CreateGroup.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
            ));
        } else {
            header("Location: /");
        }
    }

    public function Search() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $Categories = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];

            $search = "%" . $_GET['Search'] . "%";
            $GroupSearch = $this->Connection->prepare("SELECT * FROM `groups` WHERE concat(group_title, group_description, group_owner) LIKE lower(:search) ORDER BY RAND() LIMIT 50");
            $GroupSearch->bindParam(':search', $search, \PDO::PARAM_STR);
            $GroupSearch->execute();

            while($Group = $GroupSearch->fetch(\PDO::FETCH_ASSOC)) {
                $UserSearch = $this->Connection->prepare("SELECT * FROM `group_membership` WHERE group_to = :sent ORDER BY id DESC LIMIT 5;");
                $UserSearch->bindParam(":sent", $Group['id']);
                $UserSearch->execute();
                $Group['members'] = $UserSearch->rowCount();
                $Groups[] = $Group;
            }

            $Groups['rows'] = $GroupSearch->rowCount();

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $GroupSearch = $this->Connection->prepare("SELECT * FROM `group_membership` WHERE group_sent = :sent ORDER BY id DESC LIMIT 20;");
            $GroupSearch->bindParam(":sent", $_SESSION['Roblox']);
            $GroupSearch->execute();

            while($AGroup = $GroupSearch->fetch(\PDO::FETCH_ASSOC)) {
                $IndividGroupSearch = $this->Connection->prepare("SELECT * FROM `groups` WHERE id = :id LIMIT 1;");
                $IndividGroupSearch->bindParam(":id", $AGroup['group_to']);
                $IndividGroupSearch->execute();
                $IGroup = $IndividGroupSearch->fetch();
                if(isset($IGroup['id'])) {
                    $GroupsIn[] = $IGroup;
                }
            }

            $GroupsIn['rows'] = $GroupSearch->rowCount();

            echo $this->Twig->render('Groups.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Categories" => $Categories,
                "Category" => "Searching for \"" . $_GET['Search'] . "\"",
                "Ad" => $Ad,
                "Groups"       => @$Groups,
                "GroupsIn"     => @$GroupsIn,
            ));
        } else {
            header("Location: /");
        }
    }

    public function EditView($GroupID) {
        $Group = $this->GetGroupByID($GroupID);
        if(isset($_SESSION['Roblox']) && $this->GroupExists($GroupID) && $Group['group_owner'] == $_SESSION['Roblox']) {
            $Auth = new Auth\User();
            $CommentSearch = $this->Connection->prepare("SELECT * FROM comment_group WHERE comment_target = :target ORDER BY id DESC LIMIT 30");
            $CommentSearch->bindParam(":target", $GroupID);
            $CommentSearch->execute();

            while($Comment = $CommentSearch->fetch(\PDO::FETCH_ASSOC)) {
                $UserSearch = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :user LIMIT 1");
                $UserSearch->bindParam(":user", $Comment['comment_author']);
                $UserSearch->execute();
                $CommentUser = $UserSearch->fetch();
                if(isset($CommentUser['id'])) {
                    $Comment['author_id'] = $CommentUser['id'];
                    $Comments[] = $Comment;
                }
            }

            $Comments['rows'] = $CommentSearch->rowCount();

            $GroupSearch = $this->Connection->prepare("SELECT * FROM `group_membership` WHERE group_sent = :sent ORDER BY id DESC LIMIT 20;");
            $GroupSearch->bindParam(":sent", $_SESSION['Roblox']);
            $GroupSearch->execute();

            while($AGroup = $GroupSearch->fetch(\PDO::FETCH_ASSOC)) {
                $IndividGroupSearch = $this->Connection->prepare("SELECT * FROM `groups` WHERE id = :id LIMIT 1;");
                $IndividGroupSearch->bindParam(":id", $AGroup['group_to']);
                $IndividGroupSearch->execute();
                $IGroup = $IndividGroupSearch->fetch();
                if(isset($IGroup['id'])) {
                    $GroupsIn[] = $IGroup;
                }
            }

            $GroupsIn['rows'] = $GroupSearch->rowCount();

            $FavoriteSearch = $this->Connection->prepare("SELECT * FROM group_membership WHERE group_to = :favorite_to AND group_sent = :favorite_by LIMIT 1");
            $FavoriteSearch->bindParam(":favorite_to", $GroupID);
            $FavoriteSearch->bindParam(":favorite_by", $_SESSION['Roblox']);
            $FavoriteSearch->execute();
            $Favorite = $FavoriteSearch->fetch();

            $UserSearch = $this->Connection->prepare("SELECT * FROM group_membership WHERE group_to = :sent");
            $UserSearch->bindParam(":sent", $GroupID);
            $UserSearch->execute();
            while($Comment = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                $IndividUserSearch = $this->Connection->prepare("SELECT roblox_username, id FROM users WHERE roblox_username = :user");
                $IndividUserSearch->bindParam(":user", $Comment['group_sent']);
                $IndividUserSearch->execute();
                $User = $IndividUserSearch->fetch();
                if(isset($User['id'])) {
                    $Members[] = $User;
                }
            }
            $Group['members'] = $UserSearch->rowCount();

            echo $this->Twig->render('EditGroup.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Group"         => $Group,
                "GroupsIn"     => $GroupsIn,
                "Favorite"     => $Favorite,
                "Members"      => @$Members,
                "Comments"     => @$Comments,
            ));
        } else {
            header("Location: /");
        }
    }

    public function ViewGroup($GameID) {
        $Group = new \Crapblox\Models\Group();

        if(isset($_SESSION['Roblox']) && $Group->GroupExists($GameID)) {
            $Auth = new Auth\User();
            $Categories = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];
            $Group = $Group->GetGroupByID($GameID);

            $Author = $Auth->GetUserByUsername($Group['group_owner']);

            $CommentSearch = $this->Connection->prepare("SELECT * FROM comment_group WHERE comment_target = :target ORDER BY id DESC LIMIT 30");
            $CommentSearch->bindParam(":target", $GameID);
            $CommentSearch->execute();

            while($Comment = $CommentSearch->fetch(\PDO::FETCH_ASSOC)) {
                $UserSearch = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :user LIMIT 1");
                $UserSearch->bindParam(":user", $Comment['comment_author']);
                $UserSearch->execute();
                $CommentUser = $UserSearch->fetch();
                if(isset($CommentUser['id'])) {
                    $Comment['author_id'] = $CommentUser['id'];
                    $Comments[] = $Comment;
                }
            }

            $Comments['rows'] = $CommentSearch->rowCount();

            $GroupSearch = $this->Connection->prepare("SELECT * FROM `group_membership` WHERE group_sent = :sent ORDER BY id DESC LIMIT 20;");
            $GroupSearch->bindParam(":sent", $_SESSION['Roblox']);
            $GroupSearch->execute();

            while($AGroup = $GroupSearch->fetch(\PDO::FETCH_ASSOC)) {
                $IndividGroupSearch = $this->Connection->prepare("SELECT * FROM `groups` WHERE id = :id LIMIT 1;");
                $IndividGroupSearch->bindParam(":id", $AGroup['group_to']);
                $IndividGroupSearch->execute();
                $IGroup = $IndividGroupSearch->fetch();
                if(isset($IGroup['id'])) {
                    $GroupsIn[] = $IGroup;
                }
            }

            $GroupsIn['rows'] = $GroupSearch->rowCount();

            $FavoriteSearch = $this->Connection->prepare("SELECT * FROM group_membership WHERE group_to = :favorite_to AND group_sent = :favorite_by LIMIT 1");
            $FavoriteSearch->bindParam(":favorite_to", $GameID);
            $FavoriteSearch->bindParam(":favorite_by", $_SESSION['Roblox']);
            $FavoriteSearch->execute();
            $Favorite = $FavoriteSearch->fetch();

            $UserSearch = $this->Connection->prepare("SELECT * FROM group_membership WHERE group_to = :sent");
            $UserSearch->bindParam(":sent", $GameID);
            $UserSearch->execute();
            while($Comment = $UserSearch->fetch(\PDO::FETCH_ASSOC)) {
                $IndividUserSearch = $this->Connection->prepare("SELECT roblox_username, id FROM users WHERE roblox_username = :user");
                $IndividUserSearch->bindParam(":user", $Comment['group_sent']);
                $IndividUserSearch->execute();
                $User = $IndividUserSearch->fetch();
                if(isset($User['id'])) {
                    $Members[] = $User;
                }
            }
            $Group['members'] = $UserSearch->rowCount();

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $UserFetch = new \Crapblox\Models\Auth\User();
            $PinnedComment = $this->GetLastOwnerComment($Group['group_owner'], $Group['id']);
            if(isset($PinnedComment['id']))
                $PinnedComment['author_id'] = $UserFetch->GetUserByUsername($PinnedComment['comment_author'])['id'];

            $ServerSearch = $this->Connection->prepare("SELECT * FROM servers WHERE server_group = :id ORDER BY id DESC LIMIT 3");
            $ServerSearch->bindParam(":id", $Group['id']);
            $ServerSearch->execute();
            while($Game = $ServerSearch->fetch(\PDO::FETCH_ASSOC)) {
                $GroupGames[] = $Game;
            }

            $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_visibile = 'y' AND item_group = :id ORDER BY id DESC LIMIT 15");
            $CatalogSearch->bindParam(":id", $Group['id']);
            $CatalogSearch->execute();

            while($Item = $CatalogSearch->fetch(\PDO::FETCH_ASSOC)) {
                $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id");
                $OwnSearch->bindParam(":id", $Item['id']);
                $OwnSearch->execute();
                $Item['bought'] = $OwnSearch->rowCount();

                if($Item['item_quantity'] != -1) {
                    $OwnSearch = $this->Connection->prepare("SELECT item_price FROM resell WHERE item_selling = :id ORDER BY item_price");
                    $OwnSearch->bindParam(":id", $Item['id']);
                    $OwnSearch->execute();
                    $Deal = $OwnSearch->fetch();
                    $Item['lowest_bid'] = @$Deal['item_price'];
                }

                $Catalog[] = $Item;
            }
            
            // why jackd why
            $ModelGroup = new \Crapblox\Models\Group();
            $Group["share_price"] = $ModelGroup->GetSharePrice($GameID);

            echo $this->Twig->render('Group.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Categories"   => $Categories,
                "Group"         => $Group,
                "GroupsIn"     => $GroupsIn,
                "Favorite"     => $Favorite,
                "Members"      => @$Members,
                "GroupGames"   => @$GroupGames,
                "GroupItems"   => @$Catalog,
                "PinnedComment"=> @$PinnedComment,
                "Comments"     => @$Comments,
                "Author"       => $Author,
                "Ad"           => $Ad,
            ));
        } else {
            header("Location: /");
        }
    }

    public function Stocks($GroupID) {
        $Group = new \Crapblox\Models\Group();
        if(isset($_SESSION['Roblox']) && $Group->GroupExists($GroupID)) {
            $Auth = new Auth\User();
            $User = $Auth->GetUserByUsername($_SESSION['Roblox']);
            $Group = $Group->GetGroupByID($GroupID);
            $ModelGroup = new \Crapblox\Models\Group();
            $Group["share_price"] = $ModelGroup->GetSharePrice($GroupID);
            $Group["rebuy_price"] = $ModelGroup->GroupRebuyPrice($GroupID);
            $stmt = $this->Connection->prepare("SELECT id, roblox_username, roblox_stocks FROM users");
            $stmt->execute([]);
            $ShareholdersSearch = $stmt->fetchAll();
            $Shareholders = [];
            foreach($ShareholdersSearch as $Shareholder)
            {
                $Json = json_decode($Shareholder["roblox_stocks"], true);
                try {
                    if(isset($Json[$GroupID-1]) && $Json[$GroupID-1] != 0)
                    {
                        $Shareholder["stocks_owned"] = $Json[$GroupID-1];
                        $Shareholders[] = $Shareholder;
                    }
                } catch(Exception $exception) {
                    echo $exception;
                }
            }
            $GroupStocks = 0;
            if(isset(json_decode($User["roblox_stocks"], true)[$GroupID - 1]))
                $GroupStocks = json_decode($User["roblox_stocks"], true)[$GroupID - 1];
            echo $this->Twig->render('GroupShares.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $User,
                "Group"        => $Group,
                "StocksOwned"  => $GroupStocks,
                "Shareholders" => $Shareholders
            ));
        } else {
            header("Location: /");
        }
    }

    public function GetLastOwnerComment($Owner, $GroupID) {
        $stmt = $this->Connection->prepare("SELECT * FROM `comment_group` WHERE comment_author = :find AND comment_target = :target ORDER BY id DESC");
        $stmt->bindParam(":find", $Owner);
        $stmt->bindParam(":target", $GroupID);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function GetGroupByID($GroupID) {
        $stmt = $this->Connection->prepare("SELECT * FROM `groups` WHERE id = :find");
        $stmt->bindParam(":find", $GroupID);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function GroupExists($GroupID) {
        $stmt = $this->Connection->prepare("SELECT id FROM `groups` WHERE id = :username");
        $stmt->bindParam(":username", $GroupID);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Groups",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}