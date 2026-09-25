<?php
namespace Crapblox\Models;

class Datastore extends ModelBase {
    public function GetV2() {
        // getV2
        if (isset($_GET['placeId']) and isset($_GET['type']) and isset($_GET['scope'])) {
            if ($_GET['type'] == "standard") {
                $DSSearch = $this->Connection->prepare("SELECT data FROM datastores WHERE placeid = :id LIMIT 1");
                $DSSearch->bindParam(":id", $_GET['placeId']);
                $DSSearch->execute();
                $jsondata = $DSSearch->fetch();
                if (isset($jsondata['data'])) {
                    if (mb_parse_str(str_replace("qkeys[0]", "", @file_get_contents("php://input")), $_POST) == 1) {
                        $datajson = (array)json_decode($jsondata['data'], true);
                        $value = $datajson["ds"][$_POST['_key']]["scopes"][$_POST['_scope']][$_POST['_target']] ?? null;
                        $final = array();
                        $final["data"][] = array("Value" => $value);
                        die(json_encode($final));
                    }
                }
            }
        }
        die('{"data":[]}');
    }

    public function Set() {
        // set
        if (isset($_GET['placeId']) and isset($_GET['type']) and isset($_GET['scope']) and isset($_GET['target'])) {
            if ($_GET['type'] == "standard") {
                $DSSearch = $this->Connection->prepare("SELECT data FROM datastores WHERE placeid = :id LIMIT 1");
                $DSSearch->bindParam(":id", $_GET['placeId']);
                $DSSearch->execute();
                $jsondata = $DSSearch->fetch();
                if (isset($jsondata['data'])) {
                    $datajson = (array)json_decode($jsondata['data'], true);
                    $datajson["ds"][$_GET['key']]["scopes"][$_GET['scope']][$_GET['target']] = $_POST['value'];
                    $datajson = json_encode($datajson);
                    $stmt = $this->Connection->prepare("UPDATE datastores SET data = ? WHERE placeid = ?");
                    $stmt->execute([
                        $datajson,
                        $_GET['placeId'],
                    ]);
                    $stmt = null;
                } else {
                    $newjson = json_encode(array("ds" => array($_GET['key'] => array("scopes" => array($_GET['scope'] => array($_GET['target'] => $_POST['value']))))));
                    $stmt = $this->Connection->prepare(
                        "INSERT INTO datastores 
                            (placeid, data) 
                         VALUES 
                            (?, ?)"
                    );
                    $stmt->execute([
                        $_GET['placeId'],
                        $newjson,
                    ]);
                }
                die('{"data":' . $_POST['value'] . '}');
            }
        }
    }
}