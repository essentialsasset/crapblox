<?php
$User = [];
$User['id'] = $argv[1];

$Thumbnail = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', @file_get_contents("http://192.168.1.15/Thumbs/Asset/Generate/" . $User['id'])));
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Assets/" . $User['id'] . ".png", $Thumbnail);