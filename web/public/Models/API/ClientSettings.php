<?php
namespace Crapblox\Models;

class ClientSettings extends ModelBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function ClientSettings() {
        header("Content-type: text/plain");
        echo @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Models/FFlags/Client");
    }

    public function ClientSettings2017() {
        header("Content-type: text/plain");
        echo @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Models/FFlags/Client2017");
    }

    public function RCCSettings() {
        header("Content-type: text/plain");
        echo @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Models/FFlags/Client2017");
    }

    public function ThirteenClientSettings() {
        header("Content-type: text/plain");
        echo @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Models/FFlags/2013Client");
    }

    public function ClientSharedSettings() {
        header("Content-type: text/plain");
        echo @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Models/FFlags/ClientShared");
    }
}