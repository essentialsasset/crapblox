<?php
namespace Crapblox\Views;

class News extends ViewBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function View($Username) {
        $OwnSearch = $this->Connection->prepare("SELECT * FROM news WHERE id = :id LIMIT 1");
        $OwnSearch->bindParam(":id", $_GET['id']);
        $OwnSearch->execute();
        $Group = $OwnSearch->fetch();

        if(isset($Group['id'])) {
            $Format = new \Crapblox\Views\Games();
            $URL       = "/" . $Format->formatUrl($Group['news_title']) . "-blog?id=" . $Group['id'];

            /*
            if(
                $Format->formatUrl($Group['news_title']) !=
                str_replace(
                    "-blog",
                    "",
                    $Group['news_title']
                )
            ) {
                die(str_replace(
                    "-blog",
                    "",
                    $Group['news_title']
                ));
                header("Location: " . $URL);
            }
            */

            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($Group['news_author']);
            $Group['profile_picture'] = $User['id'];

            $CommentSearch = $this->Connection->prepare("SELECT * FROM comment_news WHERE comment_target = :target ORDER BY id DESC LIMIT 30");
            $CommentSearch->bindParam(":target", $Group['id']);
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

            echo $this->Twig->render('News.twig', array(
                "PageSettings" => $this->PageSettings(),
                "Article"         => $Group,
                "Author"       => $User,
                "Comments"       => @$Comments,
            ));
        } else {
            header("Location: /");
        }
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "News",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }
}