<?php
// LEGACY JOB TESTING CODE --- DO NOT USE!

$Item = [];
$Item['id'] = $argv[1];
$Item['item_type'] = $argv[2];
$AssetID = $Item['id'];

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
echo $Arbiter->OpenJob("", "Execute", "RenderAsset", "RenderAsset-" . time(), $scriptText, 5);