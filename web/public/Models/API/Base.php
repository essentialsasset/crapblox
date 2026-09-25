<?php
namespace Crapblox\Models;

class ModelBase extends \Crapblox\Configurator {
    public $Connection;
    public $Configuration;
    public $Validator;
    public $Twig;
    public $RCCServiceSOAP;

    function __construct() {
        parent::__construct();
        $this->MakeConnection();
    }

    function MakeConnection() {
        try
        {
            $this->Connection = new \PDO("mysql:host=" . $this->Configuration->Database->DatabaseHost . ";dbname=" . $this->Configuration->Database->DatabaseName . ";charset=utf8mb4",
                $this->Configuration->Database->DatabaseUsername,
                $this->Configuration->Database->DatabasePassword,
                [
                    \PDO::ATTR_EMULATE_PREPARES => false,
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ]
            );
        }
        catch(\PDOException $e)
        {
            die("An error occured connecting to the database: " . $e->getMessage());
        }
    }
}