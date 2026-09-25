<?php
namespace Crapblox\Views;
use \Crapblox\Models\Auth;

class Catalog extends \Crapblox\Views\ViewBase {
    public function View() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $Categories = ["Hat", "Package", "Heads", "Shirt", "T-Shirt", "Pants", "Face", "Gear", "Audio", "Decal", "Model", "Mesh"];
            $ItemsPerPage = 18;

            if(isset($_GET['page'])) {
                $Offset = ((int)$_GET['page'] - 1) * $ItemsPerPage;
                $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_type = 'Hat' AND item_visibile = 'y' AND item_approved = 'y' ORDER BY id DESC LIMIT " . $Offset . "," . $ItemsPerPage);
            } else {
                $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_type = 'Hat' AND item_visibile = 'y' AND item_approved = 'y' ORDER BY id DESC LIMIT " . $ItemsPerPage);
            }

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

            $CatalogSearch = $this->Connection->prepare("SELECT id FROM catalog WHERE item_type = 'Hat' AND item_approved = 'y' AND item_visibile = 'y'");
            $CatalogSearch->execute();

            $Catalog['rows'] = $CatalogSearch->rowCount();
            $Pages = ceil($Catalog['rows'] / $ItemsPerPage);
            if($Pages == 0) { $Pages = 1; }

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            echo $this->Twig->render('Catalog.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Catalog"      => @$Catalog,
                "Categories"   => $Categories,
                "url" => "/Catalog/?page=",
                "total" => $Pages,
                "current" => $_GET['page'] ?? 1,
                "nearbyPagesLimit" => 4,
                "Ad"        => $Ad,
            ));
        } else {
            header("Location: /");
        }
    }

    public function Search() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $Categories = ["Hat", "Package", "Heads", "Shirt", "T-Shirt", "Pants", "Face", "Gear", "Audio", "Decal", "Model", "Mesh"];

            if(isset($_GET['Search'])) {
                $search = "%" . $_GET['Search'] . "%";
            } elseif(isset($_GET['search'])) {
                $search = "%" . $_GET['search'] . "%";
            }

            $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE concat(item_title, item_author) LIKE lower(:search) ORDER BY RAND() LIMIT 100");
            $CatalogSearch->bindParam(':search', $search, \PDO::PARAM_STR);
            $CatalogSearch->execute();

            while($Item = $CatalogSearch->fetch(\PDO::FETCH_ASSOC)) {
                $Items[] = $Item;
            }

            $Games['rows'] = $CatalogSearch->rowCount();

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            echo $this->Twig->render('Catalog.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Categories" => $Categories,
                "Category" => "Searching for \"" . $_GET['search'] . "\"",
                "Ad" => $Ad,
                "Catalog" => @$Items,
            ));
        } else {
            header("Location: /");
        }
    }

    public function EditView($AssetID) {
        $Check = new \Crapblox\Models\Asset();
        $Asset = $Check->GetAssetByID($AssetID);
        if(isset($_SESSION['Roblox']) && $Check->AssetExists($AssetID) && $Asset['item_author'] == $_SESSION['Roblox']) {
            $Auth = new Auth\User();
            $Categories = ["Hat", "Package", "Heads", "Shirt", "T-Shirt", "Pants", "Face", "Gear", "Audio", "Decal", "Model", "Mesh"];

            $UserSearch = $this->Connection->prepare("SELECT roblox_admin FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $_SESSION['Roblox']);
            $UserSearch->execute();
            $IsAdmin = $UserSearch->fetch();

            echo $this->Twig->render('EditItem.twig', array(
                "PageSettings" => $this->PageSettings(),
                "IsAdmin" => ($IsAdmin['roblox_admin'] == 'y') ? true : false,
                "IsCatalogManager" => ($IsAdmin['roblox_admin'] == 'c') ? true : false,
                "Author"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Categories"   => $Categories,
                "Asset"        => $Asset,
                "Item"        => $Asset,
            ));
        } else {
            header("Location: /");
        }
    }

    public function ViewCategory($Category) {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $Categories = ["Hat", "Package", "Heads", "Shirt", "T-Shirt", "Pants", "Face", "Gear", "Audio", "Decal", "Model", "Mesh"];

            $ItemsPerPage = 18;

            if(isset($_GET['page'])) {
                $Offset = ((int)$_GET['page'] - 1) * $ItemsPerPage;
                $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_type = :category AND item_visibile = 'y' AND item_approved = 'y' ORDER BY id DESC LIMIT " . $Offset . "," . $ItemsPerPage);
            } else {
                $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_type = :category AND item_visibile = 'y' AND item_approved = 'y' ORDER BY id DESC LIMIT " . $ItemsPerPage);
            }
            $CatalogSearch->bindParam(":category", $Category);
            $CatalogSearch->execute();

            while($Item = $CatalogSearch->fetch(\PDO::FETCH_ASSOC)) {
                $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id");
                $OwnSearch->bindParam(":id", $Item['id']);
                $OwnSearch->execute();
                $Item['bought'] = $OwnSearch->rowCount();
                $Catalog[] = $Item;
            }

            $CatalogSearch = $this->Connection->prepare("SELECT id FROM catalog WHERE item_type = :category AND item_approved = 'y' AND item_visibile = 'y'");
            $CatalogSearch->bindParam(":category", $Category);
            $CatalogSearch->execute();

            $Catalog['rows'] = $CatalogSearch->rowCount();
            $Pages = ceil($Catalog['rows'] / $ItemsPerPage);
            if($Pages == 0) { $Pages = 1; }

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            echo $this->Twig->render('Catalog.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Catalog"      => @$Catalog,
                "Categories"   => $Categories,
                "url" => "/Catalog/" . $Category . "?page=",
                "total" => $Pages,
                "current" => $_GET['page'] ?? 1,
                "nearbyPagesLimit" => 4,
                "Ad"        => $Ad,
            ));
        } else {
            header("Location: /");
        }
    }

    public function CreateView() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $Categories = ["Hat", "Package", "Heads", "Shirt", "T-Shirt", "Pants", "Face", "Gear", "Audio", "Decal", "Model", "Mesh"];

            $UserSearch = $this->Connection->prepare("SELECT roblox_admin FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $_SESSION['Roblox']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();
            if($User['roblox_admin'] == 'y' || $User['roblox_admin'] == 'c') {
                $IsAdmin = true;
            } else {
                $IsAdmin = false;
            }

            echo $this->Twig->render('CreateAsset.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Categories"   => $Categories,
                "IsAdmin"      => $IsAdmin,
            ));
        } else {
            header("Location: /");
        }
    }

    public function ViewItem($AssetID) {
        $ItemVal = new \Crapblox\Models\Asset();

        if(isset($_SESSION['Roblox']) && $ItemVal->AssetExists($AssetID)) {
            $Auth = new Auth\User();
            $Categories = ["Hat", "Package", "Heads", "Shirt", "T-Shirt", "Pants", "Face", "Gear", "Audio", "Decal", "Model", "Mesh"];
            $Item = $ItemVal->GetAssetByID($AssetID);
            $Author = $Auth->GetUserByUsername($Item['item_author']);

            $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id");
            $OwnSearch->bindParam(":id", $Item['id']);
            $OwnSearch->execute();
            $Item['bought'] = $OwnSearch->rowCount();

            $CommentSearch = $this->Connection->prepare("SELECT * FROM comment_item WHERE comment_target = :target ORDER BY id DESC LIMIT 20");
            $CommentSearch->bindParam(":target", $AssetID);
            $CommentSearch->execute();

            while($Comment = $CommentSearch->fetch(\PDO::FETCH_ASSOC)) {
                $UserSearch = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :user LIMIT 1");
                $UserSearch->bindParam(":user", $Comment['comment_author']);
                $UserSearch->execute();
                $User = $UserSearch->fetch();
                if(isset($User['id'])) {
                    $Comment['author_id'] = $User['id'];
                    $Comments[] = $Comment;
                }
            }

            $Comments['rows'] = $CommentSearch->rowCount();

            $RatingSearch = $this->Connection->prepare("SELECT id FROM item_ratings WHERE rating_type = 'l' AND rating_to = :rating_to");
            $RatingSearch->bindParam(":rating_to", $Item['id']);
            $RatingSearch->execute();
            $Item['rating_likes'] = $RatingSearch->RowCount();

            $RatingSearch = $this->Connection->prepare("SELECT id FROM item_ratings WHERE rating_type = 'd' AND rating_to = :rating_to");
            $RatingSearch->bindParam(":rating_to", $Item['id']);
            $RatingSearch->execute();
            $Item['rating_dislikes'] = $RatingSearch->RowCount();

            // Rating handling
            if($Item['rating_likes'] == 0 && $Item['rating_dislikes'] == 0) {
                $Item['rating_likes_width'] = 50;
                $Item['rating_dislikes_width'] = 50;
            } else {
                $Item['rating_likes_width'] = $Item['rating_likes'] / ($Item['rating_likes'] + $Item['rating_dislikes']) * 100;
                $Item['rating_dislikes_width'] = 100 - $Item['rating_likes_width'];
            }

            $RatingSearch = $this->Connection->prepare("SELECT * FROM item_ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'l' LIMIT 1");
            $RatingSearch->bindParam(":rating_to", $Item['id']);
            $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
            $RatingSearch->execute();
            $Rating = $RatingSearch->fetch();

            if(!isset($Rating['id'])) {
                $RatingSearch = $this->Connection->prepare("SELECT * FROM item_ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'd' LIMIT 1");
                $RatingSearch->bindParam(":rating_to", $Item['id']);
                $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
                $RatingSearch->execute();
                $Rating = $RatingSearch->fetch();
                if(!isset($Rating['id'])) {
                    $Item['rating_liked'] = false;
                    $Item['rating_dis$Cliked'] = false;
                } else {
                    $Item['rating_liked'] = false;
                    $Item['rating_disliked'] = true;
                }
            } else {
                $Item['rating_liked'] = true;
                $Item['rating_disliked'] = false;
            }

            $FavoriteSearch = $this->Connection->prepare("SELECT * FROM item_favorites WHERE favorite_to = :favorite_to AND favorite_by = :favorite_by LIMIT 1");
            $FavoriteSearch->bindParam(":favorite_to", $AssetID);
            $FavoriteSearch->bindParam(":favorite_by", $_SESSION['Roblox']);
            $FavoriteSearch->execute();
            $Favorite = $FavoriteSearch->fetch();

            $UserSearch = $this->Connection->prepare("SELECT roblox_admin FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $_SESSION['Roblox']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();
            if($User['roblox_admin'] == 'y' || $User['roblox_admin'] == 'c') {
                $IsAdmin = true;
            } else {
                $IsAdmin = false;
            }

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $Author = $Auth->GetUserByUsername($Item['item_author']);

            $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_type = :category AND item_visibile = 'y' AND item_approved = 'y' ORDER BY rand() DESC LIMIT 6");
            $CatalogSearch->bindParam(":category", $Item['item_type']);
            $CatalogSearch->execute();

            while($Rec = $CatalogSearch->fetch(\PDO::FETCH_ASSOC)) {
                $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id");
                $OwnSearch->bindParam(":id", $Rec['id']);
                $OwnSearch->execute();
                $Rec['bought'] = $OwnSearch->rowCount();
                $Catalog[] = $Rec;
            }

            $UserSearch = $this->Connection->prepare("SELECT * FROM ownerships WHERE asset_id = :id");
            $UserSearch->bindParam(":id", $Item['id']);
            $UserSearch->execute();
            $Ownership = $UserSearch->fetch();
            if(isset($Ownership['id'])) {
                //echo $Ownership['asset_owner'];
                // $Resell['serial'] = $Ownership['roblox_username'];
            }

            $CatalogSearch = $this->Connection->prepare("SELECT * FROM resell WHERE item_selling = :id ORDER BY item_price");
            $CatalogSearch->bindParam(":id", $Item['id']);
            $CatalogSearch->execute();

            while($Resell = $CatalogSearch->fetch(\PDO::FETCH_ASSOC)) {
                $UserSearch = $this->Connection->prepare("SELECT id, roblox_username FROM users WHERE roblox_username = :user LIMIT 1");
                $UserSearch->bindParam(":user", $Resell['item_owned']);
                $UserSearch->execute();
                $User = $UserSearch->fetch();
                if(isset($User['id'])) {
                    $Resell['reseller'] = $User['roblox_username'];
                    $Resell['user_id'] = $User['id'];
                }

                $Resellers[] = $Resell;
            }

            if($Item['item_group'] != 0) {
                $Group = new \Crapblox\Models\Group();
                $Group = $Group->GetGroupByID($Item['item_group']);

                $Item['group_title'] = $Group['group_title'];
                $Item['group_id']    = $Group['id'];
                $Item['group_created']    = $Group['group_created'];
            }

            echo $this->Twig->render('Item.twig', array(
                "Item" => $Item,
                "Author"   => $Author,
                "Comments" => $Comments,
                "Favorite" => $Favorite,
                "IsAdmin"  => $IsAdmin,
                "Catalog"  => @$Catalog,
                "Resellers"=> @$Resellers,
                "Ad"       => $Ad,
                "PageSettings" => $this->PageSettings(),
            ));
        } else {
            header("Location: /");
        }
    }

    public function Resell($AssetID) {
        $ItemVal = new \Crapblox\Models\Asset();

        if(isset($_SESSION['Roblox']) && $ItemVal->AssetExists($AssetID)) {
            $Auth = new Auth\User();
            $Categories = ["Hat", "Package", "Heads", "Shirt", "T-Shirt", "Pants", "Face", "Gear", "Audio", "Decal", "Model", "Mesh"];
            $Item = $ItemVal->GetAssetByID($AssetID);
            $Author = $Auth->GetUserByUsername($Item['item_author']);

            $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id");
            $OwnSearch->bindParam(":id", $Item['id']);
            $OwnSearch->execute();
            $Item['bought'] = $OwnSearch->rowCount();

            $CommentSearch = $this->Connection->prepare("SELECT * FROM comment_item WHERE comment_target = :target ORDER BY id DESC LIMIT 20");
            $CommentSearch->bindParam(":target", $AssetID);
            $CommentSearch->execute();

            while($Comment = $CommentSearch->fetch(\PDO::FETCH_ASSOC)) {
                $UserSearch = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :user LIMIT 1");
                $UserSearch->bindParam(":user", $Comment['comment_author']);
                $UserSearch->execute();
                $User = $UserSearch->fetch();
                if(isset($User['id'])) {
                    $Comment['author_id'] = $User['id'];
                    $Comments[] = $Comment;
                }
            }

            $Comments['rows'] = $CommentSearch->rowCount();

            $RatingSearch = $this->Connection->prepare("SELECT id FROM item_ratings WHERE rating_type = 'l' AND rating_to = :rating_to");
            $RatingSearch->bindParam(":rating_to", $Item['id']);
            $RatingSearch->execute();
            $Item['rating_likes'] = $RatingSearch->RowCount();

            $RatingSearch = $this->Connection->prepare("SELECT id FROM item_ratings WHERE rating_type = 'd' AND rating_to = :rating_to");
            $RatingSearch->bindParam(":rating_to", $Item['id']);
            $RatingSearch->execute();
            $Item['rating_dislikes'] = $RatingSearch->RowCount();

            // Rating handling
            if($Item['rating_likes'] == 0 && $Item['rating_dislikes'] == 0) {
                $Item['rating_likes_width'] = 50;
                $Item['rating_dislikes_width'] = 50;
            } else {
                $Item['rating_likes_width'] = $Item['rating_likes'] / ($Item['rating_likes'] + $Item['rating_dislikes']) * 100;
                $Item['rating_dislikes_width'] = 100 - $Item['rating_likes_width'];
            }

            $RatingSearch = $this->Connection->prepare("SELECT * FROM item_ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'l' LIMIT 1");
            $RatingSearch->bindParam(":rating_to", $Item['id']);
            $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
            $RatingSearch->execute();
            $Rating = $RatingSearch->fetch();

            if(!isset($Rating['id'])) {
                $RatingSearch = $this->Connection->prepare("SELECT * FROM item_ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'd' LIMIT 1");
                $RatingSearch->bindParam(":rating_to", $Item['id']);
                $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
                $RatingSearch->execute();
                $Rating = $RatingSearch->fetch();
                if(!isset($Rating['id'])) {
                    $Item['rating_liked'] = false;
                    $Item['rating_dis$Cliked'] = false;
                } else {
                    $Item['rating_liked'] = false;
                    $Item['rating_disliked'] = true;
                }
            } else {
                $Item['rating_liked'] = true;
                $Item['rating_disliked'] = false;
            }

            $FavoriteSearch = $this->Connection->prepare("SELECT * FROM item_favorites WHERE favorite_to = :favorite_to AND favorite_by = :favorite_by LIMIT 1");
            $FavoriteSearch->bindParam(":favorite_to", $AssetID);
            $FavoriteSearch->bindParam(":favorite_by", $_SESSION['Roblox']);
            $FavoriteSearch->execute();
            $Favorite = $FavoriteSearch->fetch();

            $UserSearch = $this->Connection->prepare("SELECT roblox_admin FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $_SESSION['Roblox']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();
            if($User['roblox_admin'] == 'y' || $User['roblox_admin'] == 'c') {
                $IsAdmin = true;
            } else {
                $IsAdmin = false;
            }

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $Author = $Auth->GetUserByUsername($Item['item_author']);

            $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_type = :category AND item_visibile = 'y' ORDER BY rand() DESC LIMIT 6");
            $CatalogSearch->bindParam(":category", $Item['item_type']);
            $CatalogSearch->execute();

            while($Rec = $CatalogSearch->fetch(\PDO::FETCH_ASSOC)) {
                $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id");
                $OwnSearch->bindParam(":id", $Rec['id']);
                $OwnSearch->execute();
                $Rec['bought'] = $OwnSearch->rowCount();
                $Catalog[] = $Rec;
            }

            $CatalogSearch = $this->Connection->prepare("SELECT * FROM resell WHERE item_selling = :id ORDER BY id DESC LIMIT 6");
            $CatalogSearch->bindParam(":id", $Item['id']);
            $CatalogSearch->execute();

            while($Resell = $CatalogSearch->fetch(\PDO::FETCH_ASSOC)) {
                $UserSearch = $this->Connection->prepare("SELECT id, roblox_username FROM users WHERE roblox_username = :user LIMIT 1");
                $UserSearch->bindParam(":user", $Resell['item_owned']);
                $UserSearch->execute();
                $User = $UserSearch->fetch();
                if(isset($User['id'])) {
                    $Resell['reseller'] = $User['roblox_username'];
                    $Resell['user_id'] = $User['id'];
                }
                $Resellers[] = $Resell;
            }

            echo $this->Twig->render('Resell.twig', array(
                "Item" => $Item,
                "Author"   => $Author,
                "Comments" => $Comments,
                "Favorite" => $Favorite,
                "IsAdmin"  => $IsAdmin,
                "Catalog"  => $Catalog,
                "Ad"       => $Ad,
            ));
        } else {
            header("Location: /");
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Catalog",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}