<?php
namespace Crapblox\Models;

class Persistence extends ModelBase {
    // Datastores -- For 2016 client use.
    // Basic get & set functions are below.

    // GetAsync
    // POST DATA:
    // &qkeys[0].scope=global&qkeys[0].target=KEY&qkeys[0].key=DATASTORE
    // /persistence/getV2?placeId=1&type=standard&scope=global

    // SetAsync
    // POST DATA:
    // value=%22KEYVALUE%22
    // /persistence/set?placeId=1&key=DATASTORE&&type=standard&scope=global&target=KEY&valueLength=VALUELENGTH

    public function GetAsync() {
        $postData = @file_get_contents("php://input");
        $postData = array_filter(explode('&', $postData));

        $parsedData = [];
        foreach($postData as $key) {
            // horrible
            $value = substr($key, strpos($key, '.') + 1);
            $newvalue = substr($value, strpos($value, '=') + 1);
            $newkey = substr($value, 0, strpos($value, '='));

            array_push($parsedData, [$newkey, $newvalue]);
        }

        $DataStoreSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
        $DataStoreSearch->bindParam(":id", $User);
        $DataStoreSearch->execute();
        $User = $DataStoreSearch->fetch();

        print_r($parsedData);
        print_r($postData);
    }

    public function PostAsync() {
        $postData = @file_get_contents("php://input");
        $values = json_decode(urldecode(substr($postData, strpos($postData, '=') + 1)));

        $DataStoreSearch = $this->Connection->prepare("SELECT * FROM datastores WHERE datastore = :datastore AND pid = :pid LIMIT 1");
        $DataStoreSearch->bindParam(":datastore", urldecode($_GET['key']));
        $DataStoreSearch->bindParam(":pid", ($_GET['placeId']));
        $DataStoreSearch->execute();
        $DataStore = $DataStoreSearch->fetch();

        if(!isset($DataStore['id'])) {
            $stmt = $this->Connection->prepare(
                "INSERT INTO datastores 
                    (datastore, pid, item_description, item_author, item_thumb, item_type, item_tix) 
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                urldecode($_GET['key']),
                $_GET['placeId'],
                $_GET['target'],
                $nextId . ".png",
                $_POST['category'],
                $_POST['price'],
            ]);
            $stmt = null;
        }

        print($values);
    }
}