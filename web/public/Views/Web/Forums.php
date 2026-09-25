<?php
namespace Crapblox\Views;

class Forums extends ViewBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function View() {
        $ForumSearch = $this->Connection->prepare("SELECT * FROM forum_categories ORDER BY id DESC LIMIT 50 ");
        $ForumSearch->execute();

        while($Category = $ForumSearch->fetch(\PDO::FETCH_ASSOC)) {
            $Categories[] = $Category;
        }

        $Categories['rows'] = $ForumSearch->rowCount();

        $ItemsPerPage = 10;

        if(isset($_GET['page'])) {
            $Offset = ((int)$_GET['page'] * $ItemsPerPage) - $ItemsPerPage;
            $ForumSearch = $this->Connection->prepare("SELECT * FROM forum_threads WHERE thread_visible = 'y' ORDER BY thread_last_updated DESC LIMIT " . $Offset . ",10");
        } else {
            $ForumSearch = $this->Connection->prepare("SELECT * FROM forum_threads WHERE thread_visible = 'y' ORDER BY thread_last_updated DESC LIMIT 10");
        }

        $ForumSearch->execute();
        
        while ($Thread = $ForumSearch->fetch(\PDO::FETCH_ASSOC)) {
            $UserSearch = $this->Connection->prepare("SELECT id, roblox_lastlogin, roblox_created FROM users WHERE roblox_username = :user LIMIT 1");
            $UserSearch->bindParam(":user", $Thread['thread_author']);
            $UserSearch->execute();
            $CommentUser = $UserSearch->fetch();
            $ThreadsCount = $this->Connection->prepare("SELECT * FROM forum_replies WHERE thread_target = :target");
            $ThreadsCount->bindParam(':target',    $Thread['id'], \PDO::PARAM_STR);
            $ThreadsCount->execute();

            $Thread['replies'] = $ThreadsCount->rowCount();
            $CategoryBuffer = new \Crapblox\Models\Forums();
            $CategoryBuffer = $CategoryBuffer->GetCategoryByID($Thread['thread_target']);

            if (isset($CommentUser['id'])) {
                $LastActive = strtotime($CommentUser['roblox_lastlogin']);
                $Now = strtotime("-10 minutes");
                if($Now > $LastActive) {
                    $CommentUser['active'] = false;
                } else {
                    $CommentUser['active'] = true;
                }

                $PostsCount = $this->Connection->prepare("SELECT * FROM forum_threads WHERE thread_author = :target AND thread_visible = 'y'");
                $PostsCount->bindParam(':target', $Thread['thread_author'], \PDO::PARAM_STR);
                $PostsCount->execute();
    
                $RepliesCount = $this->Connection->prepare("SELECT * FROM forum_replies WHERE thread_author = :target AND thread_visible = 'y'");
                $RepliesCount->bindParam(':target', $Thread['thread_author'], \PDO::PARAM_STR);
                $RepliesCount->execute();

                $Thread['active'] = $CommentUser['active'];
                $Thread['roblox_created'] = $CommentUser['roblox_created'];
                $Thread['roblox_lastlogin'] = $CommentUser['roblox_lastlogin'];
                $Thread['author_id'] = $CommentUser['id'];
                $Thread['thread_category'] = $CategoryBuffer['forum_title'];
                $Thread['post_count'] = $PostsCount->rowCount() + $RepliesCount->rowCount();
                $Threads[] = $Thread;
            }
        }

        $ForumSearch = $this->Connection->prepare("SELECT * FROM forum_threads WHERE thread_visible = 'y'");
        $ForumSearch->execute();

        $Threads['rows'] = $ForumSearch->rowCount();
        $Pages = ceil($Threads['rows'] / $ItemsPerPage);
        if($Pages == 0) { $Pages = 1; }

        $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
        $AdSearch->execute();
        $Ad = $AdSearch->fetch();

        $Name = $Category;

        echo $this->Twig->render('ForumsIndex.twig', array(
            "PageSettings" => $this->PageSettings(),
            "Threads" => $Threads,
            "Categories"   => $Categories,
            "Category" => $Category,
            "Ad" => $Ad,
            "url" => "/Forum/" . $Name . "?page=",
            "total" => $Pages,
            "current" => $_GET['page'] ?? 1,
            "nearbyPagesLimit" => 4,
        ));
    }

    public function CreateView($Category) {
        if(isset($_SESSION['Roblox'])) {
            $Auth = new \Crapblox\Models\Auth\User();
            $Validation = new \Crapblox\Models\Forums();
            $Category = $Validation->GetCategoryByID($Category);

            echo $this->Twig->render('CreateThread.twig', array(
                "PageSettings" => $this->PageSettings(),
                "Category"     => $Category,
                "User"         => $Auth->GetUserByUsername($_SESSION['Roblox']),
            ));
        } else {
            header("Location: /");
        }
    }

    public function ViewCategory($Category) {
        $Validation = new \Crapblox\Models\Forums();
        if($Validation->CategoryExists($Category)) {
            $ForumSearch = $this->Connection->prepare("SELECT * FROM forum_categories ORDER BY id DESC LIMIT 50 ");
            $ForumSearch->execute();

            $ActualCategory = $Category;

            while($Category = $ForumSearch->fetch(\PDO::FETCH_ASSOC)) {
                $Categories[] = $Category;
            }

            $ItemsPerPage = 7;

            if(isset($_GET['page'])) {
                $Offset = ((int)$_GET['page'] - 1) - $ItemsPerPage;
                $ForumSearch = $this->Connection->prepare("SELECT * FROM forum_threads WHERE thread_target = :category AND thread_visible = 'y' ORDER BY thread_last_updated DESC LIMIT " . $Offset . ",7");
                $ForumSearch->BindParam(":category", $ActualCategory);
            } else {
                $ForumSearch = $this->Connection->prepare("SELECT * FROM forum_threads WHERE thread_target = :category AND thread_visible = 'y' ORDER BY thread_last_updated DESC LIMIT 7");
                $ForumSearch->BindParam(":category", $ActualCategory);
            }

            $ForumSearch->execute();

            while ($Thread = $ForumSearch->fetch(\PDO::FETCH_ASSOC)) {
                $UserSearch = $this->Connection->prepare("SELECT id, roblox_lastlogin, roblox_created FROM users WHERE roblox_username = :user LIMIT 1");
                $UserSearch->bindParam(":user", $Thread['thread_author']);
                $UserSearch->execute();
                $CommentUser = $UserSearch->fetch();

                $ThreadsCount = $this->Connection->prepare("SELECT * FROM forum_replies WHERE thread_target = :target AND thread_visible = 'y'");
                $ThreadsCount->bindParam(':target',    $Thread['id'], \PDO::PARAM_STR);
                $ThreadsCount->execute();

                $Thread['replies'] = $ThreadsCount->rowCount();

                if (isset($CommentUser['id'])) {
                    $LastActive = strtotime($CommentUser['roblox_lastlogin']);
                    $Now = strtotime("-10 minutes");
                    if($Now > $LastActive) {
                        $CommentUser['active'] = false;
                    } else {
                        $CommentUser['active'] = true;
                    }

                    $PostsCount = $this->Connection->prepare("SELECT * FROM forum_threads WHERE thread_author = :target AND thread_visible = 'y' ");
                    $PostsCount->bindParam(':target', $Thread['thread_author'], \PDO::PARAM_STR);
                    $PostsCount->execute();
        
                    $RepliesCount = $this->Connection->prepare("SELECT * FROM forum_replies WHERE thread_author = :target AND thread_visible = 'y'");
                    $RepliesCount->bindParam(':target', $Thread['thread_author'], \PDO::PARAM_STR);
                    $RepliesCount->execute();

                    $Thread['active'] = $CommentUser['active'];
                    $Thread['roblox_created'] = $CommentUser['roblox_created'];
                    $Thread['roblox_lastlogin'] = $CommentUser['roblox_lastlogin'];
                    $Thread['post_count'] = $PostsCount->rowCount() + $RepliesCount->rowCount();
                    $Thread['author_id'] = $CommentUser['id'];
                    $Threads[] = $Thread;
                }
            }

            $ForumSearch = $this->Connection->prepare("SELECT * FROM forum_threads WHERE thread_target = :category");
            $ForumSearch->BindParam(":category", $ActualCategory);
            $ForumSearch->execute();

            $Threads['rows'] = $ForumSearch->rowCount();
            $Pages = round($Threads['rows'] / $ItemsPerPage);
            if($Pages == 0) { $Pages = 1; }

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $Name = $ActualCategory;
            $Category = $Validation->GetCategoryByID($ActualCategory);
            $Auth = new \Crapblox\Models\Auth\User();

            echo $this->Twig->render('ForumsCategory.twig', array(
                "PageSettings" => $this->PageSettings(),
                "Threads" => $Threads,
                "Category" => $Category,
                "Categories" => $Categories,
                "User" => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "url" => "/Forum/" . $Name . "?page=",
                "total" => $Pages,
                "current" => $_GET['page'] ?? 1,
                "nearbyPagesLimit" => 4,
                "Ad"        => $Ad,
            ));
        }
    }

    public function ViewThread($ThreadID) {
        $Validation = new \Crapblox\Models\Forums();
        if($Validation->ThreadExists($ThreadID)) {
            $ForumSearch = $this->Connection->prepare("SELECT * FROM forum_categories ORDER BY id DESC LIMIT 50 ");
            $ForumSearch->execute();

            while($Category = $ForumSearch->fetch(\PDO::FETCH_ASSOC)) {
                $Categories[] = $Category;
            }

            $ForumSearch = $this->Connection->prepare("SELECT * FROM forum_replies WHERE thread_target = :category AND thread_visible = 'y' LIMIT 50");
            $ForumSearch->BindParam(":category", $ThreadID);
            $ForumSearch->execute();

            while ($Thread = $ForumSearch->fetch(\PDO::FETCH_ASSOC)) {
                $UserSearch = $this->Connection->prepare("SELECT id, roblox_lastlogin, roblox_created FROM users WHERE roblox_username = :user LIMIT 1");
                $UserSearch->bindParam(":user", $Thread['thread_author']);
                $UserSearch->execute();
                $CommentUser = $UserSearch->fetch();
                if (isset($CommentUser['id'])) {
                    $LastActive = strtotime($CommentUser['roblox_lastlogin']);
                    $Now = strtotime("-10 minutes");
                    if($Now > $LastActive) {
                        $CommentUser['active'] = false;
                    } else {
                        $CommentUser['active'] = true;
                    }
                    
                    $PostsCount = $this->Connection->prepare("SELECT * FROM forum_threads WHERE thread_author = :target");
                    $PostsCount->bindParam(':target', $Thread['thread_author'], \PDO::PARAM_STR);
                    $PostsCount->execute();
        
                    $RepliesCount = $this->Connection->prepare("SELECT * FROM forum_replies WHERE thread_author = :target");
                    $RepliesCount->bindParam(':target', $Thread['thread_author'], \PDO::PARAM_STR);
                    $RepliesCount->execute();

                    $Thread['author_id'] = $CommentUser['id'];
                    $Thread['active'] = $CommentUser['active'];
                    $Thread['post_count'] = $PostsCount->rowCount() + $RepliesCount->rowCount();
                    $Thread['roblox_created'] = $CommentUser['roblox_created'];
                    $Thread['roblox_lastlogin'] = $CommentUser['roblox_lastlogin'];
                    $Threads[] = $Thread;
                }
            }

            $Threads['rows'] = $ForumSearch->rowCount();

            $AdSearch = $this->Connection->prepare("SELECT ad_target, ad_file FROM ads WHERE ad_status = 'a' ORDER BY rand() LIMIT 1");
            $AdSearch->execute();
            $Ad = $AdSearch->fetch();

            $ThreadID = $Validation->GetThreadByID($ThreadID);

            $UserSearch = $this->Connection->prepare("SELECT id, roblox_lastlogin, roblox_created FROM users WHERE roblox_username = :user LIMIT 1");
            $UserSearch->bindParam(":user", $ThreadID['thread_author']);
            $UserSearch->execute();
            $CommentUser = $UserSearch->fetch();
            if (isset($CommentUser['id'])) {
                $ThreadID['author_id'] = $CommentUser['id'];
                $LastActive = strtotime($CommentUser['roblox_lastlogin']);
                $Now = strtotime("-10 minutes");
                if($Now > $LastActive) {
                    $CommentUser['active'] = false;
                } else {
                    $CommentUser['active'] = true;
                }

                $PostsCount = $this->Connection->prepare("SELECT * FROM forum_threads WHERE thread_author = :target");
                $PostsCount->bindParam(':target', $ThreadID['thread_author'], \PDO::PARAM_STR);
                $PostsCount->execute();
    
                $RepliesCount = $this->Connection->prepare("SELECT * FROM forum_replies WHERE thread_author = :target AND thread_visible = 'y'");
                $RepliesCount->bindParam(':target', $ThreadID['thread_author'], \PDO::PARAM_STR);
                $RepliesCount->execute();

                $ThreadID['post_count'] = $PostsCount->rowCount() + $RepliesCount->rowCount();
                $ThreadID['author_id'] = $CommentUser['id'];
                $ThreadID['active'] = $CommentUser['active'];
                $ThreadID['roblox_created'] = $CommentUser['roblox_created'];
                $ThreadID['roblox_lastlogin'] = $CommentUser['roblox_lastlogin'];
            }

            $Category = $Validation->GetCategoryByID($ThreadID['thread_target']);
            $Auth = new \Crapblox\Models\Auth\User();

            echo $this->Twig->render('ForumsThread.twig', array(
                "PageSettings" => $this->PageSettings(),
                "Threads" => $Threads,
                "Thread" => $ThreadID,
                "User" => $Auth->GetUserByUsername($_SESSION['Roblox']),
                "Category" => $Category,
                "Categories" => $Categories,
                "Ad" => $Ad,
            ));
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Forums",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}