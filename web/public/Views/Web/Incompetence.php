<?php
namespace Crapblox\Views;

use \finfo;

class Incompetence extends ViewBase {
    public function View() {
        echo $this->Twig->render('Incompetence.twig', array(
            "PageSettings" => $this->PageSettings(),
        ));
    }

    public function FeatureIncomplete() {
        echo $this->Twig->render('FeatureIncomplete.twig', array(
            "PageSettings" => $this->PageSettings(),
        ));
    }

    public function Bypass() {
        $_SESSION['Incompetence'] = true;
        header("Location: /");
    }

    public function PageSettings() {
        return (object) [
            "PageTitle"       => "Homepage",
            "PageDescription" => "Welcome to 2016 Roblox Revival",
        ];
    }

    function getFileInternal($Type, $Filename) {
        $file_info = new finfo(FILEINFO_MIME_TYPE);

        $filename = "/var/www/volumes/" . $Type . "/" . stripslashes($Filename);
        if(file_exists($filename)) {
            $file = file_get_contents($filename);
            $mime_type = $file_info->buffer($file);
            header("Content-type: " . $mime_type);
            return $file;
        } else {
            header("HTTP/1.0 404 Not Found");
            return "";
        }
    }

    public function GetFile($Type, $Filename) {
        switch($Type) {
            case "Assets":
            case "Avatars":
            case "Groups":
            case "AssetFiles":
            case "Headshots":
            case "Ads":
            case "Games":
                echo $this->getFileInternal($Type, $Filename);
                break;
            case "PlaceFiles":
                // Proper authority?
                if($_SERVER['HTTP_CF_CONNECTING_IP'] == "51.79.82.198" || $_SERVER['HTTP_CF_CONNECTING_IP'] == "fe80::d250:99ff:fed4:f49f" ||
                    $_SERVER['HTTP_CF_CONNECTING_IP'] == "71.58.85.190") {
                    echo $this->getFileInternal($Type, $Filename);
                }
                break;
            default:
                die("Invalid type");
                break;
        }
    }
}