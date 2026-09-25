<?php
namespace Crapblox\Models\Thumbnail;

class RenderServer extends \Crapblox\Models\ModelBase {
    public function RenderUser($UserID) {
        $Thumbnail = @file_get_contents("http://51.79.82.198:2757/render/user/" . (int)$UserID . "/headshot?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");
        file_put_contents("/var/www/volumes/Headshots/" . (int)$UserID . ".png", base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$Thumbnail)));

        $Thumbnail = @file_get_contents("http://51.79.82.198:2757/render/user/" . (int)$UserID . "/bodyshot?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");
        file_put_contents("/var/www/volumes/Avatars/" . (int)$UserID . ".png", base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $Thumbnail)));
    }

    public function RedrawAvatar() {
        header("Location: /Avatar/");
    }

    public function Test() {
        $Request = new \Crapblox\Models\Auth\User();
        $Request->asyncInclude("/var/www/html/index.php");
    }

    public function RedrawAvatarForce($User) {
        $UserSearch = $this->Connection->prepare("SELECT id, roblox_wear FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $User);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $Thumbnail = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', @file_get_contents("http://51.79.82.198:2757/render/bodyshot/" . $User['id'] . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1")));
        file_put_contents("/var/www/volumes/Avatars/" . $User['id'] . ".png", $Thumbnail);
        header("Location: /Users/");
    }

    public function RedrawDecalForce($User) {
        $UserSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
        $UserSearch->bindParam(":id", $User);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $Thumbnail = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', @file_get_contents("http://192.168.1.15/Thumbs/Decal/Generate/" . $User['id'])));
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Assets/" . $User['id'] . ".png", $Thumbnail);
        header("Location: /User/" . $User['roblox_username']);
    }

    public function RedrawAssetForce($Asset) {
        $AssetSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
        $AssetSearch->bindParam(":id", $Asset);
        $AssetSearch->execute();
        $Asset = $AssetSearch->fetch();

        $Thumbnail = @file_get_contents("http://51.79.82.198:2757/render/asset/" . $Asset['id'] . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");
        $Thumbnail = base64_decode($Thumbnail);
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Assets/" . $Asset['id'] . ".png", $Thumbnail);
        header("Location: /Item/" . $Asset['id']);
    }

    public function Redraw3DForce($Asset) {
        $User = new \Crapblox\Models\Auth\User();
        $UserI = $User->GetUserByUserID($Asset);

        if($User->UserExists($UserI['roblox_username'])) {
            $Thumbnail = @file_get_contents("http://51.79.82.198:2757/render/user/" . $Asset . "/3d?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");

            if(isset($_GET['mtl'])) {
                $Thumbnail = json_decode($Thumbnail);
                $Thumbnail = ($Thumbnail->files->{'scene.mtl'}->content);
                $Thumbnail = base64_decode($Thumbnail);
                die($Thumbnail);
            } else {
                die($Thumbnail);
            }
        }
    }

    public function RenderModel($AssetID) {
        // i am sorry god for i have sinned
        $scriptText = '
        print(("[%s] Started RenderJob for type \'%s\' with assetId %d ..."):format(game.JobId, "Model", ' . $AssetID . '))
        
        assetUrl = "https://crapblox.com/Asset/?id=' . (int)$AssetID . '"
        fileExtension = "PNG"
        x = 420
        y = 420 
        baseUrl = "https://crapblox.com/"
        
        game:GetService("ContentProvider"):SetBaseUrl("http://crapblox.com")
        game:GetService("ScriptContext").ScriptsDisabled = true

        local ThumbnailGenerator = game:GetService("ThumbnailGenerator")
         
         for _, object in pairs(game:GetObjects(assetUrl)) do
            if object:IsA("Sky") then
                local resultValues = nil
                local success = pcall(function() resultValues = {ThumbnailGenerator:ClickTexture(object.SkyboxFt, fileExtension, x, y)} end)
                if success then
                    return unpack(resultValues)
                else
                    object.Parent = game:GetService("Lighting")
                    return ThumbnailGenerator:Click(fileExtension, x, y, --[[hideSky = ]] false)
                end
            elseif object:IsA("LuaSourceContainer") then
                return ThumbnailGenerator:ClickTexture(baseUrl.. "Thumbs/Script.png", fileExtension, x, y)
            elseif object:IsA("SpecialMesh") then
                local part = Instance.new("Part")
                part.Parent = workspace
                object.Parent = part
                return ThumbnailGenerator:Click(fileExtension, x, y, --[[hideSky = ]] true)
            else
                pcall(function() object.Parent = workspace end)
            end
         end
         
         return ThumbnailGenerator:Click(fileExtension, x, y, --[[hideSky = ]] true)
        ';
        $Arbiter = new \Crapblox\Models\Arbiter();
        $Time = time();
        echo $Arbiter->OpenJob("", "Execute", "RenderModel", "RenderModel-" . $Time, $scriptText, 20);
        $Arbiter->CloseJob("", "RenderModel-" . $Time);
    }

    public function RenderAsset($AssetID) {
        $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
        $ItemSearch->bindParam(":id", $AssetID);
        $ItemSearch->execute();
        $Item = $ItemSearch->fetch();

        $scriptText = '
        
        print(("[%s] Started RenderJob for type \'%s\' with assetId %d ..."):format(game.JobId, "' . $Item['item_type'] . '", ' . $AssetID . '))

        game:GetService("ContentProvider"):SetBaseUrl("http://crapblox.com")
        game:GetService("ScriptContext").ScriptsDisabled = true
        local plr = game.Players:CreateLocalPlayer(0)
        plr.CharacterAppearance = "https://crapblox.com/v1.1/asset-render/' . $AssetID . '"
        plr:LoadCharacter(false)
        for i,v in pairs(plr.Character:GetChildren()) do
        print(v)
        if v:IsA("Tool") then
            plr.Character.Torso["Right Shoulder"].CurrentAngle = math.pi / 2
        end
        end
        return(game:GetService("ThumbnailGenerator"):Click("PNG", 420, 420, true))
        ';
        
        $Arbiter = new \Crapblox\Models\Arbiter();
        $Time = time();
        echo $Arbiter->OpenJob("", "Execute", "RenderAsset", "RenderAsset-" . $Time, $scriptText, 5);
        $Arbiter->CloseJob("", "RenderAsset-" . $Time);
    }

    public function RenderMesh($AssetID) {
        // i am sorry god for i have sinned again
        $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
        $ItemSearch->bindParam(":id", $AssetID);
        $ItemSearch->execute();
        $Item = $ItemSearch->fetch();

        $scriptText = 'print(("[%s] Started RenderJob for type \'%s\' with assetId %d ..."):format(game.JobId, "Mesh", ' . $AssetID . '))
        game:GetService("ContentProvider"):SetBaseUrl("http://crapblox.com")
        game:GetService("ScriptContext").ScriptsDisabled = true
        local meshPart = Instance.new("Part", workspace)
        meshPart.Anchored = true
        meshPart.Size = Vector3.new(10, 10, 10)
        local mesh = Instance.new("SpecialMesh", meshPart)
        mesh.MeshType = "FileMesh"
        mesh.MeshId = ("http://crapblox.com/asset/?id=' . $AssetID . '")

        return(game:GetService("ThumbnailGenerator"):Click("PNG", 420, 420, true))
        ';
        $Arbiter = new \Crapblox\Models\Arbiter();
        $Time = time();
        echo $Arbiter->OpenJob("", "Execute", "RenderMesh", "RenderMesh-" . $Time, $scriptText, 5);
        $Arbiter->CloseJob("", "RenderMesh-" . $Time);
    }

    public function RenderDecal($AssetID) {
        // i am sorry god for i have sinned again
        $RCCServiceSoap = new \Roblox\Grid\Rcc\RCCServiceSoap("51.79.82.198", 64989);
        $job = new \Roblox\Grid\Rcc\Job("ThumbGen");

        $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
        $ItemSearch->bindParam(":id", $AssetID);
        $ItemSearch->execute();
        $Item = $ItemSearch->fetch();

        $scriptText = 'print(("[%s] Started RenderJob for type \'%s\' with assetId %d ..."):format(game.JobId, "Decal", ' . $AssetID . '))
        game:GetService("ContentProvider"):SetBaseUrl("http://crapblox.com")
        game:GetService("ScriptContext").ScriptsDisabled = true
        return(game:GetService("ThumbnailGenerator"):ClickTexture("rbxassetid://' . (int)$AssetID . '", "PNG", 400, 400))
        ';
        $script = new \Roblox\Grid\Rcc\ScriptExecution("ThumbGen-Script", $scriptText);
        $value = $RCCServiceSoap->BatchJob($job, $script);
        echo $value;
    }

    public function GetGameThumbnail() {
        header ('Content-Type: image/png');
        $Game = new \Crapblox\Models\Games();
        $Game = $Game->GetGameByID((int)$_GET['assetId']);
        if($Game['use_thumbnail'] == "y") {
            echo @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Games/" . (int)$_GET['assetId'] . ".png");
        } else {
            echo @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/get-asset/Games/Default.png");
        }
    }

    public function GetAvatarThumbnail() {
        header ('Content-Type: image/png');
        $Game = new \Crapblox\Models\Auth\User();
        $Game = $Game->GetUserByUserID((int)$_GET['userId']);
        echo @file_get_contents("/var/www/volumes/Avatars/" . (int)$_GET['userId'] . ".png");
    }
}