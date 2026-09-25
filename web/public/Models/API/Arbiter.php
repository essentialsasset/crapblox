<?php
namespace Crapblox\Models;

class Arbiter extends ModelBase {
    public function GUID() : string {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /*
    public function Identify() {
        echo json_encode((object) [
            "uuid"  => $this->GUID(), // kinda serves no purpose for now
            "port"  => 14863,
            "sysip" => "192.168.1.15",
            //"service_port" => 25565,
            //"base_rcc_soap_port" => 64989,
            //"base_rcc_soap_ip" => "127.0.0.1",
            //"maximum_place_jobs" => 6,
            //"maximum_thumbnail_jobs" => 6,
        ]);
    }
    */

    public function Identify() {
        echo json_encode((object) [
            "uuid"  => $this->GUID(), // kinda serves no purpose for now
            "service_port" => 25565,
            "base_rcc_soap_port" => 64989,
            "base_rcc_soap_ip" => "127.0.0.1",
            "maximum_place_jobs" => 6,
            "maximum_thumbnail_jobs" => 6,
        ]);
    }

    /*

    public function SendPacket($Packet) : string {
        // Send packet to Arbiter TCP server with JSON
        // https://www.pangodream.es/php-send-data-to-host-over-tcp-ip

        $socket = \socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $resp = "";
        if(!is_resource($socket)) {
            try {
                socket_connect($socket, "192.168.1.15", 14863);
                socket_write($socket, $Packet);
                $resp = socket_read($socket, 1024);
            } catch(\Exception $e) {
                return "";
            }
            socket_close($socket);
        } else {
            return "";
        }

        return $resp;
    }

    public function NewOpenJob($UUID, $Method, $ScriptName, $ID, $ScriptContents, $JobLengthInSeconds = 20) : void {
        // Construct packet JSON to send to Arbiter TCP server

        $Packet = (object) [
            "UUID"               => $UUID,
            "Method"             => $Method,
            "ScriptName"         => $ScriptName,
            "ID"                 => $ID,
            "ScriptContents"     => $ScriptContents,
            "JobLengthInSeconds" => $JobLengthInSeconds,
            "ServicePort"        => rand(48000, 50000),
        ];

        $this->SendPacket(json_encode($Packet));
    }

    public function TestJobNew() {
        $this->NewOpenJob($this->GUID(), "Execute", "NewOpenJob", "NewOpenJob-" . time(), "return 'hello'");
    }
    */

    public function Status() {
        header("Content-type: json/application");

        echo json_encode((object) []);
    }

    public function OpenJob($UUID, $Method, $ScriptName, $ID, $ScriptContents, $JobLengthInSeconds) {
        $Request = (object) [
            "Method" => $Method,
            "ScriptName" => $ScriptName,
            "Id" => $ID,
            "ScriptContents" => $ScriptContents,
            "JobLengthInSeconds" => $JobLengthInSeconds,
            "ServicePort"        => rand(48000, 50000),
        ];

        $url = "http://51.79.82.198:2757/Arbit";
        //$url = "http://192.168.1.14:2757/Arbit";
        // 51.79.82.198
        $content = json_encode($Request);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20); //timeout in seconds
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $response = json_decode($json_response, true);

        set_time_limit(20);

        return $json_response;
    }

    public function Execute($UUID, $Method, $ScriptName, $ID, $ScriptContents) {
        $Request = (object) [
            "Method" => $Method,
            "ScriptName" => $ScriptName,
            "Id" => $ID,
            "ScriptContents" => $ScriptContents,
            "ServicePort"        => rand(48000, 50000),
        ];

        $url = "http://51.79.82.198:2757/Execute";
        //$url = "http://192.168.1.14:2757/Arbit";
        // 51.79.82.198
        $content = json_encode($Request);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20); //timeout in seconds
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $response = json_decode($json_response, true);

        set_time_limit(20);

        return $json_response;
    }

    public function RenewLease($UUID, $ID, $JobLengthInSeconds) {
        $Request = (object) [
            "Id" => $ID,
            "JobLengthInSeconds" => $JobLengthInSeconds,
        ];

        $url = "http://51.79.82.198:2757/Renew";
        //$url = "http://192.168.1.14:2757/Renew";
        $content = json_encode($Request);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20); //timeout in seconds
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $response = json_decode($json_response, true);

        set_time_limit(20);

        return $json_response;
    }

    public function GetExpiration($UUID, $ID) {
        $Request = (object) [
            "Id" => $ID,
        ];

        $url = "http://51.79.82.198:2757/GetExpiration";
        //$url = "http://192.168.1.14:2757/GetExpiration";
        $content = json_encode($Request);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20); //timeout in seconds
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $response = json_decode($json_response, true);

        set_time_limit(20);

        $json_response = explode(",", $json_response);

        return $json_response[0];
    }

    public function JobExists($UUID, $ID) {
        $Request = (object) [
            "Id" => $ID,
        ];

        $url = "http://51.79.82.198:2757/GetExpiration";
        //$url = "http://192.168.1.14:2757/GetExpiration";
        $content = json_encode($Request);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20); //timeout in seconds
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $response = json_decode($json_response, true);

        set_time_limit(20);

        $json_response = explode(",", $json_response);

        return $json_response[0];
    }

    public function CloseJob($UUID, $ID) {
        $Request = (object) [
            "Id" => $ID,
        ];

        $url = "http://51.79.82.198:2757/CloseJob";
        //$url = "http://192.168.1.14:2757/CloseJob";
        $content = json_encode($Request);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20); //timeout in seconds
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $response = json_decode($json_response, true);

        set_time_limit(20);

        return $json_response;
    }

    public function TestJob($UUID) {
        // echo $this->RenewLease($UUID, "Game-49", 500);
        // echo $this->GetExpiration($UUID, "Game-49");
        // echo $this->JobExists($UUID, "Game-49");
        // echo $this->CloseJob($UUID, "Game-49");
    }

    public function ExtendJob($Token) {
        $Game = new \Crapblox\Models\Games();
        $Game = $Game->GetGameByToken($Token);

        if(isset($Game['id']) && isset($_GET['s'])) {
            @file_get_contents("http://51.79.82.198:2757/game/renew/" . $Game['id'] . "/" . $_GET['s'] . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");
            // $this->RenewLease($Token, "Game-" . $Game['id'], $_GET['s']);
        } else {
            die("Smd");
        }
    }

    public function Kill($Token) {
        $Game = new \Crapblox\Models\Games();
        $Game = $Game->GetGameByToken($Token);

        if(isset($Game['id'])) {
            @file_get_contents("http://51.79.82.198:2757/game/stop/" . $Game['server_token'] . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");
            // $this->CloseJob($Token, "Game-" . $Game['id']);
        } else {
            die("Smd");
        }
    }

    public function KillJob($JobID) {
        $this->CloseJob($JobID, $JobID);
    }

    public function RenderUser($UUID, $ID) {
        $UserSearch = $this->Connection->prepare("SELECT roblox_colors FROM users WHERE id = :id LIMIT 1");
        $UserSearch->bindParam(":id", $ID);
        $UserSearch->execute();
        $User = $UserSearch->fetch();
        $User['roblox_colors'] = json_decode($User['roblox_colors']);

        $scriptText = 'print(("[%s] Started RenderJob for type \'%s\' with assetId %d ..."):format(game.JobId, "User", ' . $ID . '))
        game:GetService("ContentProvider"):SetBaseUrl("http://crapblox.com")
        game:GetService("ScriptContext").ScriptsDisabled = true
        local plr = game.Players:CreateLocalPlayer(0)
        plr.CharacterAppearance = "https://crapblox.com/v1.1/avatar-fetch/' . (int)$ID . '"
        plr:LoadCharacter(false)
        local chr = plr.Character
        chr.Torso.BrickColor = BrickColor.new(' . $User['roblox_colors']->TorsoColor . ')
        chr.Head.BrickColor = BrickColor.new(' . $User['roblox_colors']->HeadColor . ')
        chr["Left Leg"].BrickColor = BrickColor.new(' . $User['roblox_colors']->LeftLegColor . ')
        chr["Right Leg"].BrickColor = BrickColor.new(' . $User['roblox_colors']->RightLegColor . ')
        chr["Left Arm"].BrickColor = BrickColor.new(' . $User['roblox_colors']->LeftArmColor . ')
        chr["Right Arm"].BrickColor = BrickColor.new(' . $User['roblox_colors']->RightArmColor . ')
        for i,v in pairs(plr.Character:GetChildren()) do
        print(v)
        if v:IsA("Tool") then
            plr.Character.Torso["Right Shoulder"].CurrentAngle = math.pi / 2
        end
        end
        return(game:GetService("ThumbnailGenerator"):Click("PNG", 420, 420, true))
        ';

        $Time = time();
        echo $this->OpenJob($UUID, "Execute", "GenerateAvatar", "GenerateAvatar-" . $Time, $scriptText, 20);
        $this->CloseJob($UUID, "GenerateAvatar-" . $Time);
    }

    public function IsGameserverRunning($ID) {
        // Function for checking if Gameserver is actually running;
        // Process: If returns 0 / nothing, keep retrying until it's not 0

        //$Script = "print('[JOINEVENT] - Checking if server is up');return math.floor(workspace.DistributedGameTime)";

       // $Arbiter = new \Crapblox\Models\Arbiter();
        //$Check = $Arbiter->Execute("", "Execute", "GameCheck", "Game-" . $ID, $Script);

        //die($Check);
        if(isset($_SESSION['Roblox'])) {
            $Game = new \Crapblox\Models\Games();
            $Game = $Game->GetGameByID($ID);

            //$JobRunning = @file_get_contents("http://51.79.82.198:2757/game/exists/" . $Game['server_token']);
            $GameRunning = @file_get_contents("http://51.79.82.198:2757/game/running/" . $Game['id'] . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");

            $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_placelaunchercooldown >= NOW() - INTERVAL 1 SECOND");
            $stmt->bindParam(":username", $_SESSION['Roblox']);
            $stmt->execute();
            if ($stmt->rowCount() === 1) {
                die("false");
            }

            $stmt = $this->Connection->prepare("UPDATE users SET roblox_placelaunchercooldown = NOW() WHERE roblox_username = ?");
            $res = $stmt->execute([$_SESSION['Roblox']]);

            if($GameRunning == "true") {
                die("true");
            } else {
                die("false");
            }
        }
    }

    public function FetchGameByID() {
        if(!isset($_GET['r'])) {
            header("Location: /");
        } else {
            if($_SERVER['HTTP_CF_CONNECTING_IP'] == "51.79.82.198" || $_SERVER['HTTP_CF_CONNECTING_IP'] == "fe80::d250:99ff:fed4:f49f" ||
                $_SERVER['HTTP_CF_CONNECTING_IP'] == "71.58.85.190") {
                $Game = new \Crapblox\Models\Games();
                $Game = $Game->GetGameByToken($_GET['r']);

                if ($_GET['r'] == $Game['server_token']) {
                    echo @file_get_contents("/var/www/volumes/PlaceFiles/" . $Game['id'] . ".rbxl");
                } else {
                    header("Location: /");
                }
            }

            echo "Poo";
        }
    }
}