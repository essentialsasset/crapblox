<?php
namespace Crapblox\Models;

class TwentySeventeen extends ModelBase {
    function get_signature($script, $key)
    {
        $signature = "";
        openssl_sign($script, $signature, @file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/Models/" . $key), OPENSSL_ALGO_SHA1);
        return base64_encode($signature);
    }

    public function RemoteStats() {
        $Debug = true;

        // if(!$Debug && @$_SERVER['HTTP_CF_CONNECTING_IP'] != "51.79.82.198") {
        //    die("fart");
        //}

        $UserID = $_GET['UserID'];
        $Resolution = $_GET['Resolution'];
        $Message = $_GET['Message'];
        $Sender = $_GET['Sender'];

        switch($Message) {
            case "murdle":
                $Definition = "Cheat Engine Stable Methods";
                break;
            case "richard":
                $Definition = "Speed Hacks (CE)";
                break;
            case "suzanne":
                $Definition = "Debugged Time (?)";
                break;
            case "baseball":
                $Definition = "Player Hash Mismatch (Ticket)";
                break;
            case "WorldEdit":
                $Definition = "Unknown";
                break;
            case "Jesper":
                $Definition = "Invalid # of hashes";
                break;
            case "Nyx":
                $Definition = "hash value tampered";
                break;
            case "Zek":
                $Definition = "FuzzyToken Tamper, v3";
                break;
            case "Zot":
                $Definition = "Api Token Tamper";
                break;
            case "Zix":
                $Definition = "Api Exception";
                break;
            case "hector":
                $Definition = "MemHashError";
                break;
            case "ghector":
                $Definition = "GoldenMemHashError";
                break;
            case "Guardian":
                $Definition = "NetPmc Pending P7. (?)";
                break;
            case "misterobvious":
                $Definition = "Cheat detected on client";
                break;
            default:
                $Definition = "Unknown message";
                break;
        }

        $Logger = new \Crapblox\Models\Log();
        $Logger->Log(":rotating_light: __**remotestats called**__ \nuid " . $UserID . "\n" . "resolution " . $Resolution . "\nmessage " . $Message . " (" . $Definition . ")\nsender **" . $Sender . "**");
    }

    public function JoinTest() {
        header("Content-Type: text/plain");

        // {
        //"ClientPort":0,
        //"MachineAddress":"",
        //"ServerPort":,
        //"PingUrl":"",
        //"PingInterval":120,
        //"UserName":"",
        //"SeleniumTestMode":false,
        //"UserId":,
        //"SuperSafeChat":false,
        //"CharacterAppearance":"http://www.pengin.xyz/",
        //"ClientTicket":"",
        //"GameId":"00000000-0000-0000-0000-000000000000",
        //"PlaceId":1818,
        //"MeasurementUrl":"",
        //"WaitingForCharacterGuid":"4d8dfc8d-cd68-4ed7-8adc-efebaba40f58",
        //"BaseUrl":"http://www.pengin.xyz/",
        //"ChatStyle":"ClassicAndBubble",
        //"VendorId":0,
        //"ScreenShotInfo":"",
        //"VideoInfo":"<?xml version=\"1.0\"><entry xmlns=\"http://www.w3.org/2005/Atom\" xmlns:media=\"http://search.yahoo.com/mrss/\" xmlns:yt=\"http://gdata.youtube.com/schemas/2007\"><media:group><media:title type=\"plain\"><![CDATA[ROBLOX Place]]></media:title><media:description type=\"plain\"><![CDATA[ For more games visit http://www.roblox.com]]></media:description><media:category scheme=\"http://gdata.youtube.com/schemas/2007/categories.cat\">Games</media:category><media:keywords>ROBLOX, video, free game, online virtual world</media:keywords></media:group></entry>",
        //"CreatorId":0,
        //"CreatorTypeEnum":"User",
        //"MembershipType":"None",
        //"AccountAge":300000000,
        //"CookieStoreFirstTimePlayKey":"rbx_evt_ftp",
        //"CookieStoreFiveMinutePlayKey":"rbx_evt_fmp",
        //"CookieStoreEnabled":true,
        //"IsRobloxPlace":true,
        //"GenerateTeleportJoin":false,
        //"IsUnknownOrUnder13":false,
        //"GameChatType":"AllUsers",
        //"SessionId":"",
        //"DataCenterId":0,
        //"UniverseId":0,
        //"BrowserTrackerId":0,
        //"UsePortraitMode":false,
        //"FollowUserId":0,
        //"characterAppearanceId":0
        //}

        $user = 'Player';
        $ip = '127.0.0.1';
        $port = '25564';
        $id = rand(1, 5000);
        $capp = 'https://crapblox.com/v1.1/avatar-fetch/' . $id;
        $mship = '0';
        $pid = '1818';

        if(preg_match("/[a-z]/i", $mship)){
            $mship = 0;
        }
        if ($mship == null) {
            $mship = 0;
        }
        if ($mship > 3) {
            $mship = 0;
        }
        if(preg_match("/[a-z]/i", $id)){
            $id = "1";
        }
        if(preg_match("/[a-z]/i", $port)){
            $port = "53640";
        }

        // Construct joinscript
        $joinscript = [
            "ClientPort" => 0,
            "MachineAddress" => $ip,
            "ServerPort" => $port,
            "PingUrl" => "",
            "PingInterval" => 20,
            "UserName" => $user,
            "SeleniumTestMode" => false,
            "UserId" => $id,
            "SuperSafeChat" => false,
            "CharacterAppearance" => $capp,
            "ClientTicket" => "",
            "GameId" => 1818,
            "PlaceId" => $pid,
            "MeasurementUrl" => "", // No telemetry here :)
            "WaitingForCharacterGuid" => "26eb3e21-aa80-475b-a777-b43c3ea5f7d2",
            "BaseUrl" => "https://crapblox.com/",
            "ChatStyle" => "BubbleAndClassic",
            "VendorId" => "0",
            "ScreenShotInfo" => "",
            "VideoInfo" => "",
            "CreatorId" => 1,
            "CreatorTypeEnum" => "User",
            "MembershipType" => "None",
            "AccountAge" => "3000000",
            "CookieStoreFirstTimePlayKey" => "rbx_evt_ftp",
            "CookieStoreFiveMinutePlayKey" => "rbx_evt_fmp",
            "CookieStoreEnabled" => true,
            "IsRobloxPlace" => true,
            "GenerateTeleportJoin" => false,
            "IsUnknownOrUnder13" => false,
            "GameChatType" => "AllUsers",
            "SessionId" => "39412c34-2f9b-436f-b19d-b8db90c2e186|00000000-0000-0000-0000-000000000000|0|$ip|8|2021-03-03T17:04:47+01:00|0|null|null",
            "DataCenterId" => 0,
            "UniverseId" => 3,
            "BrowserTrackerId" => 0,
            "UsePortraitMode" => false,
            "FollowUserId" => 0,
            "characterAppearanceId" => 1
        ];

        $data = json_encode($joinscript, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        $signature = $this->get_signature("\r\n" . $data, "/PrivateKey.pem");

        // exit
        exit("--rbxsig%". $signature . "%\r\n" . $data);
    }

    public function JoinServer() {
        header("Content-Type: text/plain");

        $Auth = new Auth\User();
        $Game = new \Crapblox\Models\Games();

        $Game = $Game->GetGameByID($_GET['PlaceId']);
        $User = $Auth->GetUserByToken($_GET['Token']);
        $Owner = $Auth->GetUserByUsername($Game['server_owner']);

        $user = ($User['roblox_username']) ?? 'Player';
        $ip = ($Game['server_ip']) ?? '127.0.0.1';
        $port = ($Game['server_port']) ?? '53640';
        $id = ($User['id']) ?? rand(1, 5000);
        $capp = 'https://crapblox.com/v1.1/avatar-fetch/' . $id;
        $mship = ($_GET["mship"]) ?? '0';
        $pid = ($Game['id']) ?? '';

        if(preg_match("/[a-z]/i", $mship)){
            $mship = 0;
        }
        if ($mship == null) {
            $mship = 0;
        }
        if ($mship > 3) {
            $mship = 0;
        }
        if(preg_match("/[a-z]/i", $id)){
            $id = "1";
        }
        if(preg_match("/[a-z]/i", $port)){
            $port = "53640";
        }

        $ip = "51.79.82.198";
        //$ip = "192.168.1.9";

        // Construct joinscript
        $joinscript = [
            "ClientPort" => 0,
            "MachineAddress" => $ip,
            "ServerPort" => $port,
            "PingUrl" => "",
            "PingInterval" => 20,
            "UserName" => $user,
            "SeleniumTestMode" => false,
            "UserId" => $id,
            "SuperSafeChat" => false,
            "CharacterAppearance" => $capp,
            "ClientTicket" => "",
            "GameId" => 3,
            "PlaceId" => $pid,
            "MeasurementUrl" => "", // No telemetry here :)
            "WaitingForCharacterGuid" => "26eb3e21-aa80-475b-a777-b43c3ea5f7d2",
            "BaseUrl" => "https://crapblox.com/",
            "ChatStyle" => $Game['server_chatstyle'],
            "VendorId" => "0",
            "ScreenShotInfo" => "",
            "VideoInfo" => "",
            "CreatorId" => $Owner['id'],
            "CreatorTypeEnum" => "User",
            "MembershipType" => "None",
            "AccountAge" => "3000000",
            "CookieStoreFirstTimePlayKey" => "rbx_evt_ftp",
            "CookieStoreFiveMinutePlayKey" => "rbx_evt_fmp",
            "CookieStoreEnabled" => true,
            "IsRobloxPlace" => true,
            "GenerateTeleportJoin" => false,
            "IsUnknownOrUnder13" => false,
            "SessionId" => "39412c34-2f9b-436f-b19d-b8db90c2e186|00000000-0000-0000-0000-000000000000|0|$ip|8|2021-03-03T17:04:47+01:00|0|null|null",
            "DataCenterId" => 0,
            "UniverseId" => 3,
            "BrowserTrackerId" => 0,
            "UsePortraitMode" => false,
            "FollowUserId" => 0,
            "characterAppearanceId" => 1
        ];

        // Encode it!
        $data = json_encode($joinscript, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

        // Sign joinscript
        $signature = $this->get_signature("\r\n" . $data, "/PrivateKey.pem");

        // exit
        exit("--rbxsig%". $signature . "%\r\n" . $data);
    }

    public function ChatFilter() {
        die(json_encode((object) [
            "ChatFilter" => "whitelist",
        ]));
    }

    public function PlaceLauncher() {
        header("Content-Type: text/plain");

        $placelauncher = [
            "jobId" => "1",
            "status" => 2,
            "jobId" => "1",
            "joinScriptUrl" => "http://www.dungblx.cf/game/join.ashx?ip=127.0.0.1&port=53640&username=jackd&id=1&placeid=1818&userId=1",
            "authenticationUrl" => "http://www.dungblx.cf/Login/Negotiate.ashx",
            "authenticationTicket" => "",
            "message" => null,
        ];

        die(json_encode($placelauncher, JSON_UNESCAPED_SLASHES));
    }

    public function LoadPlaceInfo() {
        header("Content-Type: text/plain");

        $placeinfo = [
            "PlaceId" => 1818,
            "PlaceFetchUrl" => "rbxasset://place.rbxl",
            "UniverseId" => 0,
            "MatchmakingContextId" => 1,
            "CreatorId" => 21,
            "CreatorType" => "User",
            "GameId"      => "0",
            "MachineAddress" => "localhost",
            "PreferredPort" => 53640,
            "PlaceVersion"  => 1,
            "BaseUrl"       => "dungblx.cf",
            "GsmInterval"   => 10000,
            "MaxPlayers"    => 5,
            "MaxGameInstances" => 1,
            "ApiKey" => "sex",
            "PreferredPlayerCapacity" => 10,
            "PlaceVisitAccessKey" => "sex",
            "IsRobloxPlace" => false,
        ];

        die(json_encode($placeinfo, JSON_UNESCAPED_SLASHES));
    }

    public function FilterText() {
        die(json_encode((object) [
            "data" => [
                "white" => @$_POST['text'],
                "black" => "ok",
            ]
        ]));
    }

    public function ValidateJoin() {
        header("Content-Type: text/plain");
        die("true");
    }

    public function HasAsset() {
        header("Content-Type: text/plain");
        die("false");
    }
}