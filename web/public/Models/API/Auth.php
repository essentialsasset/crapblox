<?php
namespace Crapblox\Models;

class Auth extends \Crapblox\Models\ModelBase {
    public function HashToken($Token, $Id)
    {
        return md5($Token . "|" . $Id);
    }

    public function CreateCookie($Token) {
        $User = new \Crapblox\Models\Auth\User();
        $User = $User->GetUserByToken($Token);

        /* CRAPBLOX COOKIE SPEC */
        return "CRAPBLOXSECURITY\r\n------------------------\r\n" . $User['roblox_username'] . "|" . $this->HashToken($User["roblox_token"],$User["id"]) . "\r\n------------------------\r\nDO NOT SHARE WITH ANYBODY";
    }

    public function GetCookieOwner($Cookie) {
        $KeyStrings = preg_split("/\r\n|\n|\r/", $Cookie);
        $Username = explode("|", $KeyStrings[2])[0];

        return $Username;
    }

    public function GetCookieToken($Cookie) {
        $KeyStrings = preg_split("/\r\n|\n|\r/", $Cookie);
        $Token = explode("|", $KeyStrings[2])[1];

        return $Token;
    }
}