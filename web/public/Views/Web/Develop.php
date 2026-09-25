<?php
namespace Crapblox\Views;
use \Crapblox\Models\Auth;

class Develop extends \Crapblox\Views\ViewBase {
    public function View() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $Categories = ["Hat", "Package", "Heads", "Games", "Shirt", "T-Shirt", "Pants", "Face", "Gear", "Audio", "Decal", "Model", "Mesh"];
            $CategoriesGame = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];
            $ChatEnum = ["Classic", "Bubble", "ClassicAndBubble"];
            $ItemsPerPage = 15;

            if(isset($_GET['page'])) {
                $Offset = ((int)$_GET['page'] - 1) - $ItemsPerPage;
                $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_type = 'Hat' AND item_author = :id ORDER BY id DESC LIMIT " . $Offset . ",15");
                $CatalogSearch->bindParam(":id", $_SESSION['Roblox']);
                $CurrentCategory = "Hat";
            } else {
                $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_type = 'Hat' AND item_author = :id ORDER BY id DESC LIMIT 15");
                $CatalogSearch->bindParam(":id", $_SESSION['Roblox']);
                $CurrentCategory = "Hat";
            }

            $CatalogSearch->execute();

            while($Item = $CatalogSearch->fetch(\PDO::FETCH_ASSOC)) {
                $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id");
                $OwnSearch->bindParam(":id", $Item['id']);
                $OwnSearch->execute();
                $Item['bought'] = $OwnSearch->rowCount();
                $Catalog[] = $Item;
            }

            $CatalogSearch = $this->Connection->prepare("SELECT id FROM catalog WHERE item_type = 'Hat' AND item_author = :id");
            $CatalogSearch->bindParam(":id", $_SESSION['Roblox']);
            $CatalogSearch->execute();

            $Catalog['rows'] = $CatalogSearch->rowCount();
            $Pages = ceil($Catalog['rows'] / $ItemsPerPage);
            if($Pages == 0) { $Pages = 1; }

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $AccessLevel = ["Everyone", "Friends Only", "Private", "Unlisted"];

            echo $this->Twig->render('Develop.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Catalog"      => @$Catalog,
                "CurrentCategory" => $CurrentCategory,
                "Categories"   => $Categories,
                "url" => "/Develop/?page=",
                "total" => $Pages,
                "current" => $_GET['page'] ?? 1,
                "AccessLevel"   => $AccessLevel,
                "nearbyPagesLimit" => 4,
                "Ad"        => $Ad,
                "ChatEnum"     => $ChatEnum,
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
            $User = $Auth->GetUserByUsername($_SESSION['Roblox']);
            $Categories = ["Hat", "Package", "Heads", "Shirt", "T-Shirt", "Pants", "Face", "Gear", "Audio", "Decal", "Model", "Mesh"];

            echo $this->Twig->render('EditItem.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Categories"   => $Categories,
                "Asset"        => $Asset,
                "IsAdmin"       => ($User['roblox_admin'] == 'y') ? true : false,
            ));
        } else {
            header("Location: /");
        }
    }

    public function ViewCategory($Category) {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();
            $Categories = ["Hat", "Package", "Heads", "Games", "Shirt", "T-Shirt", "Pants", "Face", "Gear", "Audio", "Decal", "Model", "Mesh"];
            $CategoriesGame = ["All", "Town And City", "Fantasy", "SciFi", "Adventure", "Sports", "Funny", "Wild West", "War"];

            $ItemsPerPage = 15;

            $CurrentCategory = $Category;

            if($CurrentCategory != "Games") {
                if (isset($_GET['page'])) {
                    $Offset = ((int)$_GET['page'] * $ItemsPerPage) - $ItemsPerPage;
                    $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_type = :category AND item_author = :id ORDER BY id DESC LIMIT " . $Offset . ",15");
                    $CatalogSearch->bindParam(":id", $_SESSION['Roblox']);
                } else {
                    $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE item_type = :category AND item_author = :id ORDER BY id DESC LIMIT 15");
                    $CatalogSearch->bindParam(":id", $_SESSION['Roblox']);
                }

                $CatalogSearch->bindParam(":category", $Category);
            } else {
                if (isset($_GET['page'])) {
                    $Offset = ((int)$_GET['page'] * $ItemsPerPage) - $ItemsPerPage;
                    $CatalogSearch = $this->Connection->prepare("SELECT * FROM servers WHERE server_owner = :id ORDER BY id DESC LIMIT " . $Offset . ",15");
                    $CatalogSearch->bindParam(":id", $_SESSION['Roblox']);
                } else {
                    $CatalogSearch = $this->Connection->prepare("SELECT * FROM servers WHERE server_owner = :id ORDER BY id DESC LIMIT 15");
                    $CatalogSearch->bindParam(":id", $_SESSION['Roblox']);
                }
            }

            $CatalogSearch->execute();

            while($Item = $CatalogSearch->fetch(\PDO::FETCH_ASSOC)) {
                $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id");
                $OwnSearch->bindParam(":id", $Item['id']);
                $OwnSearch->execute();
                $Item['bought'] = $OwnSearch->rowCount();

                // Extremely horrible way of recasting every type into item type for games

                if($CurrentCategory == "Games") {
                    $Item['item_title'] = $Item['server_title'];
                    $Item['item_description'] = $Item['server_description'];
                    $Item['item_added'] = $Item['server_created'];
                }

                $Catalog[] = $Item;
            }

            if($CurrentCategory != "Games") {
                $CatalogSearch = $this->Connection->prepare("SELECT id FROM catalog WHERE item_type = :category AND item_author = :id");
                $CatalogSearch->bindParam(":category", $Category);
                $CatalogSearch->bindParam(":id", $_SESSION['Roblox']);
                $CatalogSearch->execute();
            } else {
                $CatalogSearch = $this->Connection->prepare("SELECT id FROM servers WHERE server_owner = :id");
                $CatalogSearch->bindParam(":id", $_SESSION['Roblox']);
                $CatalogSearch->execute();
            }

            $Catalog['rows'] = $CatalogSearch->rowCount();
            $Pages = round($Catalog['rows'] / $ItemsPerPage);
            if($Pages == 0) { $Pages = 1; }

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $ChatEnum = ["Classic", "Bubble", "ClassicAndBubble"];
            $AccessLevel = ["Everyone", "Friends Only", "Private", "Unlisted"];

            echo $this->Twig->render('Develop.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Catalog"      => @$Catalog,
                "Categories"   => $Categories,
                "CategoryGames" => $CategoriesGame,
                "CurrentCategory" => $CurrentCategory,
                "AccessLevel"   => $AccessLevel,
                "url" => "/Develop/" . $Category . "?page=",
                "total" => $Pages,
                "current" => $_GET['page'] ?? 1,
                "nearbyPagesLimit" => 4,
                "Ad"        => $Ad,
                "ChatEnum"     => $ChatEnum,
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
                    $Item['rating_disliked'] = false;
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

            echo $this->Twig->render('Item.twig', array(
                "Item" => $Item,
                "Author"   => $Author,
                "Comments" => $Comments,
                "Favorite" => $Favorite,
                "IsAdmin"  => $IsAdmin,
                "Ad"       => $Ad,
            ));
        } else {
            header("Location: /");
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Develop",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}