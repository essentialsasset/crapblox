<?php
namespace Crapblox\Models;

class Launcher extends ModelBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function Info() {
        header('Content-Type: text/plain; charset=utf-8');
        $ClientLocation = $_SERVER['DOCUMENT_ROOT'] . "/binaries/CrapbloxLauncher.exe";
        $ClientHash = "a0172d8a316a008fc3b735410a39d6e520c74018c386d95222a0a443af9d5d62";

        echo $ClientHash . ";";
        echo "https://www.crapblox.com/binaries/client.zip" . ";";
        echo "v1.0.6" . ";";
    }

    public function HashCheck() {
        echo "a0172d8a316a008fc3b735410a39d6e520c74018c386d95222a0a443af9d5d62";
    }

    public function InfoData() {
        header("content-type:text/plain");

        $CurrentVersion = "v1.1.1";
        $CurrentHash    = "a0172d8a316a008fc3b735410a39d6e520c74018c386d95222a0a443af9d5d62";
        $launcherExe    = "https://www.crapblox.com/binaries/CrapbloxLauncher.exe";
        $clientZip      = "https://www.crapblox.com/binaries/client.zip";
        $studioZip      = "https://www.crapblox.com/binaries/studio.zip";

        echo $CurrentVersion . ";";
        echo $CurrentHash . ";";
        echo $launcherExe . ";";
        echo $clientZip . ";";
        echo $studioZip;
    }

    public function VersionCheck() {
        echo "launcherVersion11";
    }

    public function GetAllowedMD5Hashes() {
        echo json_encode((object) [
            "data" => [
                "829efd9f7c4cc6e291652df83cdef124", // RELEASE
                // "fcbedad9a5d8313ca7649d53b014f17c"  // TESTING
            ]
        ]);
    }

    //{"data":["0.0.0pcplayer]}

    public function GetAllowedSecurityVersions() {
        echo json_encode((object) [
            "data" => [
                "0.0.0.1pcplayer"
            ]
        ]);
    }
}