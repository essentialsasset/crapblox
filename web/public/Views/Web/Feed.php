<?php
namespace Crapblox\Views;
use \Crapblox\Models\Auth;

class Feed extends \Crapblox\Views\ViewBase {
    public function View() {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new Auth\User();

            $CommentSearch = $this->Connection->prepare("SELECT * FROM feed ORDER BY id DESC LIMIT 30");
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

            $RecentlySearch = $this->Connection->prepare("SELECT * FROM visits WHERE visit_by = :by ORDER BY id DESC LIMIT 5");
            $RecentlySearch->bindParam(":by", $_SESSION['Roblox']);
            $RecentlySearch->execute();

            while($Game = $RecentlySearch->fetch(\PDO::FETCH_ASSOC)) {
                $ServerSearch = $this->Connection->prepare("SELECT * FROM servers WHERE id = :id LIMIT 1");
                $ServerSearch->bindParam(":id", $Game['visit_game']);
                $ServerSearch->execute();
                $Game = $ServerSearch->fetch();
                if(isset($Game['id'])) {
                    $Games[] = $Game;
                }
            }

            $RecentlySearch = $this->Connection->prepare("SELECT * FROM favorites WHERE favorite_by = :by ORDER BY id DESC LIMIT 4");
            $RecentlySearch->bindParam(":by", $_SESSION['Roblox']);
            $RecentlySearch->execute();

            while($Game = $RecentlySearch->fetch(\PDO::FETCH_ASSOC)) {
                $ServerSearch = $this->Connection->prepare("SELECT * FROM servers WHERE id = :id LIMIT 1");
                $ServerSearch->bindParam(":id", $Game['favorite_to']);
                $ServerSearch->execute();
                $Game = $ServerSearch->fetch();
                if(isset($Game['id'])) {
                    $Favorites[] = $Game;
                }
            }

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

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

                if(isset($Game['id'])) {
                    $Friend['profile_picture'] = $Game['id'];
                    $Friend['roblox_lastlogin'] = $Game['roblox_lastlogin'];
                    $Friend['roblox_username'] = $Game['roblox_username'];

                    $LastActive = strtotime($Game['roblox_lastlogin']);
                    $Now = strtotime("-10 minutes");
                    if($Now > $LastActive) {
                        $Friend['active'] = false;
                    } else {
                        $Friend['active'] = true;
                    }

                    $RelationshipOutgoing[] = $Friend;
                }
            }

            $RelationshipOutgoing['rows'] = $FriendSearch->rowCount();

            $ServerSearch = $this->Connection->prepare("SELECT * FROM feed WHERE comment_author = :id ORDER BY id DESC LIMIT 1");
            $ServerSearch->bindParam(":id", $_SESSION['Roblox']);
            $ServerSearch->execute();
            @$LastFeed = $ServerSearch->fetch();
            @$Blurb = @$LastFeed['comment_text'];

            $GameSearch = $this->Connection->prepare("SELECT * FROM servers WHERE server_allowed != 'Unlisted' ORDER BY server_ping DESC LIMIT 10");
            $GameSearch->execute();

            while($Game = $GameSearch->fetch(\PDO::FETCH_ASSOC)) {
                $LastActive = strtotime($Game['server_ping']);
                $Now = strtotime("-10 minutes");
                if($Now > $LastActive) {
                    $Game['active'] = false;
                } else {
                    $Game['active'] = true;
                }

                $User = new \Crapblox\Models\Auth\User();
                $User = $User->GetIDByUsername($Game['server_owner']);
                $Game['profile_picture'] = $User['id'];

                if($Game['server_group'] != 0) {
                    $Group = new \Crapblox\Models\Group();
                    $Group = $Group->GetGroupByID($Game['server_group']);

                    if(isset($Group['id'])) {
                        $Game['group_title'] = $Group['group_title'];
                        $Game['group_id'] = $Group['id'];
                        $Game['group_created'] = $Group['group_created'];
                    } else {
                        $Game['server_group'] = 0;
                    }
                }

                $Format = new \Crapblox\Views\Games();
                $Game['server_url']     = "/" . $Format->formatUrl($Game['server_title']) . "-place?id=" . $Game['id'];
                $RecommendedGames[] = $Game;
            }

            $NewsSearch = $this->Connection->prepare("SELECT * FROM news ORDER BY id DESC LIMIT 10");
            $NewsSearch->execute();

            while($Article = $NewsSearch->fetch(\PDO::FETCH_ASSOC)) {
                $LastActive = strtotime($Article['news_created']);
                $Now = strtotime("-1 day");
                if($Now > $LastActive) {
                    $Article['active'] = false;
                } else {
                    $Article['active'] = true;
                }

                $User = new \Crapblox\Models\Auth\User();
                $User = $User->GetIDByUsername($Article['news_author']);
                $Article['profile_picture'] = $User['id'];

                $Format = new \Crapblox\Views\Games();
                $Article['url']     = "/" . $Format->formatUrl($Article['news_title']) . "-blog?id=" . $Article['id'];
                $Articles[] = $Article;
            }

            echo $this->Twig->render('Feed.twig', array(
                "PageSettings" => $this->PageSettings(),
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Comments"     => @$Comments,
                "Games"        => @$Games,
                "Recommended"  => @$RecommendedGames,
                "News"         => @$Articles,
                "Favorites"    => @$Favorites,
                "Ad"           => $Ad,
                "Blurb"        => $Blurb,
                "Relationship" => @$RelationshipOutgoing,
            ));
        } else {
            header("Location: /");
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Feed",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}