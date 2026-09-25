<?php
namespace Crapblox\Models;

class Asset extends ModelBase {
    public function InsertAsset() {
        // Drop in replacement -- https://sets.pizzaboxer.xyz/
        // Pass GET arguments to https://sets.pizzaboxer.xyz/Game/Tools/InsertAsset.ashx & get response.

//turns out this is XML format

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Expires: -1");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s T") . " GMT");
        header('content-type: text/xml');

        $nsets = @$_GET['nsets'];
        $type = @$_GET['type'];
        $userid = @$_GET['userid'];
        $sid = @$_GET['sid'];

//idk this entire thing will probably just be used for pbs
        if ($nsets == 20 && $type == "user") //should be for pbs
        {
            echo '
   <List>
   <Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Basic Building</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>56455869</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Advanced Building</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>56455649</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>House Kit</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>3</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>3</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>56455420</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>House Interior Kit</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value>: )</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>56455139</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Landscape</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>5</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>5</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>56455006</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Castle Kit</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>56454815</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Castle Interior Kit</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>56454396</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Space Kit</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>56454184</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Fun Machines</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>9</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>9</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>56453969</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Deadly Machines</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>10</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>10</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>56453811</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Holiday</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>11</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>11</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>63933257</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Configurable Parts</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>12</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>12</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>63588504</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
    <Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Wiring</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>13</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>13</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>60793478</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
    <Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Experimental</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>14</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>14</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>65821324</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
    <Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>High Scalability</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>15</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>15</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>63590456</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
    <Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Vehicles</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>16</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>16</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>59188178</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
    <Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Gear</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>17</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>17</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>59188142</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
    <Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Gameplay</Value>
			</Entry>
			<Entry>
				<Key>CategoryId</Key>
				<Value>18</Value>
			</Entry>
			<Entry>
				<Key>Description</Key>
				<Value></Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>18</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>ImageAssetId</Key>
				<Value>59188080</Value>
			</Entry>
			<Entry>
				<Key>SetType</Key>
				<Value>user</Value>
			</Entry>
		</Table>
	</Value>
   </List>';
        } elseif ($sid) {
            if ($sid == 1) {
                echo '
        <List>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Brick</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56450668</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138021372</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Sand</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324966</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138021709</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Slate</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324945</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138021799</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Granite</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324946</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138021914</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Maple</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324957</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138021993</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Mahogany</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324954</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138022028</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Ice - Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451599</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138023443</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Ice - Long Wedge</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451638</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138023520</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Ice - Wedge</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451658</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138023576</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Ice - Block</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451715</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138023698</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Mud - Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451745</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138023763</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Mud - Long Wedge</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451777</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138023833</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Mud - Wedge</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451808</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138023897</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Mud - Block</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451835</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138023958</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Stone - Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451873</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138024059</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Stone - Long Wedge</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451909</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138024120</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Stone - Wedge</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451936</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138024173</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Stone - Block</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451953</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138024211</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Grass - Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56451992</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138024274</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Grass - Long Wedge</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452031</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138024331</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Grass - Wedge</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452072</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138024407</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Grass - Block</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452103</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138024462</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Wood - Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452119</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138024511</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Wood - Long Wedge</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452145</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138024574</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Wood - Wedge</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452182</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138024674</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Wood - Block</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452191</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138024705</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - Pink</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452267</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837753</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Pink</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452293</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837709</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - Magenta</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452312</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837659</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Magenta</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452342</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837614</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - Purple</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452381</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837468</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Purple</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452411</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837425</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - Cyan</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452438</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837571</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Cyan</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452470</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837526</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - Blue</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452507</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837862</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Blue</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452539</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837808</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - Dark Green</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452573</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837975</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Dark Green</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452610</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837924</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - Green</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452628</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838051</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Green</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452651</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838008</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - Yellow</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452687</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838136</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Yellow</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452718</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838096</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - Orange</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452752</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838246</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Orange</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452768</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838210</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - Red</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452798</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838317</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Red</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452821</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838286</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - White</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452849</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838406</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - White</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452868</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838363</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - Gray</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56452995</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838478</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Gray</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56453012</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838439</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corner Block - Black</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56453030</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837348</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Block - Black</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56453053</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>1</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144837285</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
</List>
        ';
            } else if ($sid == 2) {
                echo '
        <List>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Steps - Turn Left</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56450261</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138020529</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Steps - Turn Right</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56450290</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138020609</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Steps - Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56450320</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138020678</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Steps</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56450340</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138020722</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Ladder</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56450238</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144863277</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Trapdoor - Ice</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324919</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138011451</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Trapdoor - Slate</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324907</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138011504</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Trapdoor - Grass</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324912</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138011544</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corroded Truss - Horizontal</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>59617538</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144839684</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corroded Truss - Centered Vertical</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>59617344</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144839254</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Corroded Truss - Corner Vertical</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>59617845</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144840347</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Metal Truss - Horizontal</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>59617492</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144839585</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Metal Truss - Centered Vertical</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>59617205</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144838964</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Metal Truss - Corner Vertical</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>59617391</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>2</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>144839382</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
</List>
        ';
            } else if ($sid == 3) {
                echo '
        <List>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Chimney</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449996</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>3</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019902</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Roof - Peak</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56450017</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>3</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019961</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Roof - Inner Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56450038</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>3</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138020004</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Roof</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56450063</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>3</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138020052</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Window - Small</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56450092</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>3</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138020114</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Window - Tall Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56450197</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>3</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138020372</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Window - Tall</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56450222</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>3</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138020435</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
</List>
        ';
            } else if ($sid == 4) {
                echo '
        <List>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Cabinets - Top Small</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449305</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018482</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Cabinets - Top</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449332</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018536</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Oven</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449359</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018585</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Dishwasher</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449386</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018640</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Kitchen Sink</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449402</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018686</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Kitchen Counters</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449449</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018773</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Dining Chair</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449487</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018860</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Dining Table</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449509</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018911</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Bathroom Mirror</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449539</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018987</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Bathroom Sink</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449580</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019069</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Bathtub &amp; Shower</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449624</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019183</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>End Table</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449649</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019223</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Dresser - Tall</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449729</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019384</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Dresser - Wide</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449753</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019425</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Bed</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449778</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019483</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Bookshelf</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449804</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019533</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Coffee Table</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449842</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019606</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Standing Lamp</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449883</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019671</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Fireplace</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449926</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019770</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Couch</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449951</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138019820</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Toilet</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449594</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>157983940</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Flatscreen TV</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449913</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>157984052</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Refrigerator</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>65894286</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>4</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>157983991</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
</List>
        ';
            } else if ($sid == 5) {
                echo '
        <List>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Wood Bridge</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448952</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>5</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138017728</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Flowers</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448980</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>5</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138017788</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Mailbox</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449011</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>5</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138017843</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Streetlight</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449028</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>5</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>142449877</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Fence</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449052</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>5</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138017929</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Autumn Tree - Large</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449099</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>5</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018028</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Tree - Small</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449132</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>5</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018107</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Tree - Medium</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449156</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>5</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018154</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Tree - Large</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56449188</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>5</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138018219</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
</List>
        ';
            } else if ($sid == 6) {
                echo '
        <List>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Weathervane</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447956</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138015595</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Roof - Red</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448088</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138015843</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Roof - Blue</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448168</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138016003</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Arch with railing</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448208</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138016078</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Arch</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448235</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138016130</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Rampart Support - Diagonal</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448307</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138016290</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Rampart - Diagonal</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448331</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138016352</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Rampart Support - Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448408</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138016535</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Rampart - Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448439</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138016588</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Rampart Support</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448479</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138016669</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Rampart</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448503</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138016724</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Window - Tall Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448529</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138016788</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Window - Tall</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448556</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138016844</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Window - Cross Design</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448609</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138016944</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Window - Small</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448660</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138017036</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Castle Door</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448697</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138017113</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Drawbridge</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448720</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138017182</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Castle Wall - Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448738</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138017229</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Castle Wall</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448754</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138017266</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Fobe Flag</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448011</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>168423501</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Steeple - Red</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448055</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>168423669</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Steeple - Blue</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56448122</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>6</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>168423571</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
</List>
        ';
            } else if ($sid == 7) {
                echo '
        <List>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Flag - Red</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446867</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138013204</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Medieval Desk Chair - Red</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446930</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138013360</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Throne - Red</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446956</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138013409</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Carpet - Red</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446995</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138013482</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Coat of Arms - Blue</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447027</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138013563</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Flag - Blue</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447040</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138013606</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Medieval Desk Chair - Blue</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447106</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138013737</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Throne - Blue</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447149</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138013830</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Aged Crusader Painting</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447217</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138013973</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Battle at the Castle Painting</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447250</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138014035</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Knighted Painting</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447288</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138014099</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Lady &amp; Knight Painting</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447356</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138014246</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Jousting Tapestry</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447444</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138014432</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Unicorn Tapestry</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447479</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138014524</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Royal Red Tapestry</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447703</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138015025</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Writing Desk</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447744</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138015120</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Castle Dining Chair</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447776</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138015187</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Castle Dining Table</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447803</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138015243</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Well</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447829</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138015312</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Stables</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447853</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138015361</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Coat of Arms - Red</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446833</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>158670760</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Lord&#39;s Entrance Painting</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447318</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>158670874</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Torch</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56447717</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>157984552</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>ROBLOX</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Castle Carpet - Blue</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>65894507</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>7</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>157984473</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
</List>
        ';
            } else if ($sid == 8) {
                echo '
        <List>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Space Bed</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446151</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138011735</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Control Panel - Wall</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446186</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138011812</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Control Panel - Floor</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446217</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138011880</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Chair - Short</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446234</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138011924</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Chair - Tall</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446276</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012000</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Captain&#39;s Chair</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446320</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012083</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Railing</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446358</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012168</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Exterior Column</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446391</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012233</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Catwalk</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446415</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012291</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Space Window - Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446452</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012375</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Space Window</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446481</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012434</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Interior Hall Panel</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446512</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012505</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Space Hallway Floor</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446557</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012580</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Space Hatch</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446583</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>147509468</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Space Steps - Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446608</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012706</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Space Steps</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446629</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012758</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Space Wall - Corner</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446648</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012804</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Space Wall</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56446665</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>8</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138012845</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
</List>
        ';
            } else if ($sid == 9) {
                echo '
        <List>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Float Pad - Sideways</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56445964</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>9</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138011329</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Float Pad</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>56445997</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>9</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138011397</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Elevator - 8 x 8 x 32</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324885</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>9</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138064397</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Elevator - 8 x 8 x 16</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324881</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>9</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138064342</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Friend Only Door 2.0</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41694124</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>9</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>138011692</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
</List>
        ';
            } else if ($sid == 10) {
                echo '
        <List>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Spikes - Moving</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324904</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>10</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>137995138</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Spikes</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324903</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>10</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>137995181</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Fire Pit</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>41324902</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>10</Value>
			</Entry>
			<Entry>
				<Key>AssetVersionId</Key>
				<Value>137995228</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
	<Value>
		<Table>
			<Entry>
				<Key>Name</Key>
				<Value>Friend Only Door - Hostile</Value>
			</Entry>
			<Entry>
				<Key>AssetId</Key>
				<Value>1605</Value>
			</Entry>
			<Entry>
				<Key>AssetSetId</Key>
				<Value>10</Value>
			</Entry>
			<Entry>
				<Key>CreatorName</Key>
				<Value>Finobe</Value>
			</Entry>
			<Entry>
				<Key>IsTrusted</Key>
				<Value>True</Value>
			</Entry>
		</Table>
	</Value>
</List>
        ';
            } else if ($sid == 11) {
                echo '
        <List>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Present</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67187816</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>11</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>160879612</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Christmas Tree</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67187806</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>11</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>160879591</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Snowman</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67187780</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>11</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>160879543</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Wreath</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67187797</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>11</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>160879573</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Menorah</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67187771</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>11</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>160879529</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
    </List>
        ';
            } else if ($sid == 12) {
                echo '
        <List>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Castle Door</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>56448697</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>12</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>138017113</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Space Hatch</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>56446583</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>12</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>147509468</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>boombox</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>63132395</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>12</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161852161</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Wiring Lever</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>63132445</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>12</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>155921932</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Portrait</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67572390</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>12</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161727326</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Place Picture</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67572378</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>12</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161727301</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
    </List>
        ';
            } else if ($sid == 13) {
                echo '
        <List>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Moving Spike</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>60793117</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>153094337</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Button (Wiring Only)</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>58970275</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>147355705</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Flame Thrower (Wiring Only)</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>58970146</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>153094491</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Invisible Trigger</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>63132409</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>152003176</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Wiring Lever</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>63132445</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>155921932</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Wiring Door</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>63132465</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161727181</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Incinerator</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65819725</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>157818814</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Lamp</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65819756</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>157818876</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>AND Gate</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65819780</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>157818927</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>OR Gate</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65819804</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>157818966</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Inverter</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65819911</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>157819180</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Repeater</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65819925</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>157819225</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Delay</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65819947</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>157819272</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Conveyer Belt</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65819976</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161843087</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Energy Core</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65820011</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>157819411</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Float Pad</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65820060</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161843167</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Sideways Float Pad</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65820095</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161843140</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Magic Ball</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65820129</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>157819643</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Energy Button</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65820169</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>157819713</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Appearing Platform</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67572059</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161726541</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Iris Door</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67572213</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161726910</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Lazer Trigger</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67572224</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>165626002</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Light Switch</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67572237</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161726974</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Airlock Door</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67572258</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161727016</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Wired Trap</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67572320</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161727154</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Timer</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67572398</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161727342</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Speaker</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>69281057</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>165623061</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Click Button</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>69281032</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>165625890</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Drawbridge</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>69276460</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>165612353</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Boombox</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>69281292</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>13</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>165623674</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
    </List>
        ';
            } else if ($sid == 14) {
                echo '
        <List>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>C4 Explosive</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65819994</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>14</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161726840</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Tesla Coil</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67625690</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>14</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>165690977</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
    </List>
        ';
            } else if ($sid == 15) {
                echo '
        <List>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>MegaSand</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>63590698</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>152955828</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>MegaGrass</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>63590695</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>152955824</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>MegaBrick</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>65962665</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>158139521</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Stone Block</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994803</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679585</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Plastic (red)</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994798</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679576</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Plastic (blue)</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994786</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679555</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Plank</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994775</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679533</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Log</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994759</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679504</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Iron</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994750</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679489</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Gravel</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994743</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679474</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Granite</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994740</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679467</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Gold</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994731</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679444</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Cinder Block</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994724</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679428</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Cement</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994719</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679422</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Asphalt</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994712</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679411</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Aluminum</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>67994706</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>162679401</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Water</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>82717697</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>15</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>195589381</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
    </List>
        ';
            } else if ($sid == 16) {
                echo '
        <List>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Bus</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>59524699</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>16</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>144837133</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Racecar</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>59524640</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>16</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>144837042</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Truck</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>59524606</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>16</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>144836955</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Car</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>59524676</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>16</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>144837102</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Jeep</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>59524622</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>16</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>146134623</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>UFO</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>59524729</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>16</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>154615236</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Police Car</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>59524656</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>16</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>161973480</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
    </List>
        ';
            } else if ($sid == 17) {
                echo '
        <List>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Trowel Dispenser</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>1461</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>17</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Superball Dispenser</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>1459</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>17</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Slingshot Dispenser</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>1457</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>17</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Rocket Launcher Dispenser</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>1447</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>17</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Timebomb Dispenser</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>59524006</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>17</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>171986652</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Sword Dispenser</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>1137</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>17</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
    </List>
        ';
            } else if ($sid == 18) {
                echo '
        <List>
        <Value>
            <Table>
                <Entry>
                    <Key>Name</Key>
                    <Value>Small Neutral Spawn</Value>
                </Entry>
                <Entry>
                    <Key>AssetId</Key>
                    <Value>59524197</Value>
                </Entry>
                <Entry>
                    <Key>AssetSetId</Key>
                    <Value>18</Value>
                </Entry>
                <Entry>
                    <Key>AssetVersionId</Key>
                    <Value>144864324</Value>
                </Entry>
                <Entry>
                    <Key>CreatorName</Key>
                    <Value>ROBLOX</Value>
                </Entry>
                <Entry>
                    <Key>IsTrusted</Key>
                    <Value>True</Value>
                </Entry>
            </Table>
        </Value>
    </List>
        ';
            } else {
                $URL = "https://sets.pizzaboxer.xyz/Game/Tools/InsertAsset.ashx?" . urldecode($_SERVER['QUERY_STRING']);

                // echo $URL;

                //die(@file_get_contents("https://sets.pizzaboxer.xyz/Game/Tools/InsertAsset.ashx?nsets=20&type=user&userid=1"));
                die(@file_get_contents($URL));
            }
        }
    }

    public function ThumbnailAsset() {
        if(isset($_GET["assetversionid"])) {
            $id = (int)$_GET["assetversionid"];
        }
        if(isset($_GET["wd"])) {
            $wd = (int)$_GET["wd"];
        }
        if(isset($_GET["ht"])) {
            $ht = (int)$_GET["ht"];
        }
        if(isset($_GET["fmt"])) {
            $fmt = $_GET["fmt"];
        }
        if(isset($_GET['assetversionid'])) {
            $aid = $_GET['assetversionid'];
        }
        if(isset($_GET['aid'])) {
            $aid = $_GET['aid'];
        }

        $ROBLOSECURITY = ".ROBLOSECURITY=_|WARNING:-DO-NOT-SHARE-THIS.--Sharing-this-will-allow-someone-to-log-in-as-you-and-to-steal-your-ROBUX-and-items.|_E7CC31F9CE410DC2C54F9FFDF675DCCFD457FE24BD37B5A261F6B4004B1CBB85FC9B6E2DD57624344A1A845DE74BA03663F8E85B51BDD485DA179F5A4CDA74C280E7C5D169B6F9BF052800534E9DD0B9C6027932F985173C8ECF0C913C7C7556632D63459C0E91F093ACEA40B31798C2BD93829333C8FD94F3C1F4E1846C2952EF5497CB1B2B2D11DCBFA131CC8ED1168871B136C3FC49082FC9C3ED1BFB65D76F68857136B8C0B0353C911E3B5542030E8C048D3CCBD2D64DE84594B318C1168C4DD8B88124C6DC960842D7643B6E9B58DBD9F2F8F4C10A3C7AA3556A84206D524B0764B901915B0F1E37B8957E23B860AF418169E0AA8E0656C4AC79331A9C30A21BD956CB1C9521232F154C9A0EDBB97D22A18E551A3005BE1B67BF6C45DB90CF5254F5195322CF875456CA1115BC7A84CA38A0F68A5CC626B70F841E4733A0F631F47719A7D03DC5D57AADE7B88484CF3BDD4669834C8BA1FB045DC1F5F82420A85891511C65058592E94BAFA82CE5E4806F";
        header('Content-Type: text/plain');
            $url = 'https://thumbnails.roblox.com/v1/assets/?assetIds=' . (int)$aid . '&size=420x420&format=Png';
        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: " . $ROBLOSECURITY));
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0");
        curl_setopt($ch, CURLOPT_REFERER, 'https://www.roblox.com/');
        $output = curl_exec ($ch);
        $res = json_decode($output);
        curl_close($ch);
        $Thumbnail = $res->data[0]->imageUrl;
        header('Content-Type: image/png');
        die(@file_get_contents($Thumbnail));
    }

    public function isXMLFileValid($xmlFilename, $version = '1.0', $encoding = 'utf-8')
    {
        $xmlContent = @file_get_contents($xmlFilename);
        return $this->isXMLContentValid($xmlContent, $version, $encoding);
    }

    public function isXMLContentValid($xmlContent, $version = '1.0', $encoding = 'utf-8')
    {
        if (trim($xmlContent) == '') {
            return false;
        }

        libxml_use_internal_errors(true);

        $doc = new \DOMDocument($version, $encoding);
        $doc->loadXML($xmlContent);

        $errors = libxml_get_errors();
        libxml_clear_errors();

        return empty($errors);
    }

    public function BuyAsset($AssetID) {
        if(is_numeric($AssetID)) {
            $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
            $ItemSearch->bindParam(":id", $AssetID);
            $ItemSearch->execute();
            $Item = $ItemSearch->fetch();

            $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $_SESSION['Roblox']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();

            $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner LIMIT 1");
            $OwnSearch->bindParam(":owner", $_SESSION['Roblox']);
            $OwnSearch->bindParam(":id", $Item['id']);
            $OwnSearch->execute();
            $Own = $OwnSearch->fetch();

            if(!isset($Item['id'])) {
                $_SESSION['Errors'] = ['Item dont exist'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if($Item['item_onsale'] == "n") {
                $_SESSION['Errors'] = ['Item offsale'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if(!isset($User['id'])) {
                $_SESSION['Errors'] = ['UJser dont exist'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if($Item['item_onsale'] == "n") {
                $_SESSION['Errors'] = ['item offsale.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if(isset($Own['id'])) {
                $_SESSION['Errors'] = ['You already own this item.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            /* Create a form handler class... This is extremely ugly */

            if(!isset($_SESSION['Roblox'])) {
                $_SESSION['Errors'] = ['You are not logged in'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if($Item['item_tix'] != 0 && $User['roblox_tickets'] - $Item['item_tix'] <= -1) {
                $_SESSION['Errors'] = ['You do not have enough currency to buy this asset.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if($Item['item_quantity'] == 0) {
                $_SESSION['Errors'] = ['There is no more stock in this item.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            $stmt = $this->Connection->prepare(
                "INSERT INTO ownerships 
                    (asset_id, asset_owner) 
                 VALUES 
                    (?, ?)"
            );
            $stmt->execute([
                $Item['id'],
                $_SESSION['Roblox'],
            ]);

            $stmt = $this->Connection->prepare(
                "INSERT INTO transactions 
                    (sale_item, sale_by) 
                 VALUES 
                    (?, ?)"
            );
            $stmt->execute([
                $Item['id'],
                $_SESSION['Roblox'],
            ]);

            //take
            $stmt = $this->Connection->prepare("UPDATE users SET roblox_robux = ?, roblox_tickets = ? WHERE roblox_username = ?");
            $stmt->execute([
                $User['roblox_robux'] - $Item['item_bux'],
                $User['roblox_tickets'] - $Item['item_tix'],
                $_SESSION['Roblox'],
            ]);
            $stmt = null;

            $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $Item['item_author']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();

            //give
            if($Item['item_group'] == 0) {
                $stmt = $this->Connection->prepare("UPDATE users SET roblox_robux = ?, roblox_tickets = ? WHERE roblox_username = ?");
                $stmt->execute([
                    $User['roblox_robux'] + $Item['item_bux'],
                    $User['roblox_tickets'] + $Item['item_tix'],
                    $Item['item_author'],
                ]);
                $stmt = null;
            } else {
                $Group = new \Crapblox\Models\Group();
                $Group = $Group->GetGroupByID($Item['item_group']);

                $stmt = $this->Connection->prepare("UPDATE `groups` SET group_funds = ? WHERE id = ?");
                $stmt->execute([
                    $Group['group_funds'] + $Item['item_tix'],
                    $Group['id'],
                ]);
                $stmt = null;
            }

            // if limited
            if($Item['item_quantity'] > 0 ) {
                $stmt = $this->Connection->prepare("UPDATE catalog SET item_quantity = ? WHERE id = ?");
                $stmt->execute([
                    $Item['item_quantity'] - 1,
                    $Item['id'],
                ]);
                $stmt = null;
            }

            $_SESSION['Success'] = ['You have successfully bought this asset.'];
            header("Location: /Item/" . $Item['id']);
            die();
        }
    }

    public function RemoveDeal($DealID) {
        if(is_numeric($DealID)) {
            $ItemSearch = $this->Connection->prepare("SELECT * FROM resell WHERE id = :id LIMIT 1");
            $ItemSearch->bindParam(":id", $DealID);
            $ItemSearch->execute();
            $Deal = $ItemSearch->fetch();

            $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $_SESSION['Roblox']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();

            $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner LIMIT 1");
            $OwnSearch->bindParam(":owner", $_SESSION['Roblox']);
            $OwnSearch->bindParam(":id", $Deal['item_selling']);
            $OwnSearch->execute();
            $Own = $OwnSearch->fetch();

            $OwnSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
            $OwnSearch->bindParam(":id", $Deal['item_selling']);
            $OwnSearch->execute();
            $Item = $OwnSearch->fetch();

            if(!isset($Item['id'])) {
                $_SESSION['Errors'] = ['Item dont exist'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if(!isset($Deal['id'])) {
                $_SESSION['Errors'] = ['Deal dont exist'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if($Deal['item_owned'] != $_SESSION['Roblox']) {
                $_SESSION['Errors'] = ['You cannot remove this deal.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            $stmt = $this->Connection->prepare("DELETE FROM resell WHERE id = ?");
            $stmt->execute(
                [
                    $DealID,
                ]
            );

            $_SESSION['Success'] = ['You have successfully removed your deal.'];
            header("Location: /Item/" . $Item['id']);
            die();
        }
    }


    public function BuyDeal($DealID) {
        if(is_numeric($DealID)) {
            $ItemSearch = $this->Connection->prepare("SELECT * FROM resell WHERE id = :id LIMIT 1");
            $ItemSearch->bindParam(":id", $DealID);
            $ItemSearch->execute();
            $Deal = $ItemSearch->fetch();

            $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $_SESSION['Roblox']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();

            $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner LIMIT 1");
            $OwnSearch->bindParam(":owner", $_SESSION['Roblox']);
            $OwnSearch->bindParam(":id", $Deal['item_selling']);
            $OwnSearch->execute();
            $Own = $OwnSearch->fetch();

            $OwnSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
            $OwnSearch->bindParam(":id", $Deal['item_selling']);
            $OwnSearch->execute();
            $Item = $OwnSearch->fetch();

            if(!isset($Item['id'])) {
                $_SESSION['Errors'] = ['Item dont exist'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if(!isset($Deal['id'])) {
                $_SESSION['Errors'] = ['Deal dont exist'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if($Deal['item_owned'] == $_SESSION['Roblox']) {
                $_SESSION['Errors'] = ['You cannot buy your own resell.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if($Item['item_onsale'] == "n") {
                $_SESSION['Errors'] = ['Item offsale'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if(!isset($User['id'])) {
                $_SESSION['Errors'] = ['UJser dont exist'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if($Item['item_onsale'] == "n") {
                $_SESSION['Errors'] = ['item offsale.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            /*
            if(isset($Own['id'])) {
                $_SESSION['Errors'] = ['You already own this item.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }
            */

            /* Create a form handler class... This is extremely ugly */

            if(!isset($_SESSION['Roblox'])) {
                $_SESSION['Errors'] = ['You are not logged in'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if($Deal['item_price'] != 0 && $User['roblox_tickets'] - $Deal['item_price'] <= -1) {
                $_SESSION['Errors'] = ['You do not have enough currency to complete this deal.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner LIMIT 1");
            $OwnSearch->bindParam(":owner", $Deal['item_owned']);
            $OwnSearch->bindParam(":id", $Deal['item_selling']);
            $OwnSearch->execute();
            $OriginalOwnership = $OwnSearch->fetch();

            $stmt = $this->Connection->prepare("DELETE FROM ownerships WHERE id = ?");
            $stmt->execute(
                [
                    $OriginalOwnership['id'],
                ]
            );

            $stmt = $this->Connection->prepare(
                "INSERT INTO ownerships 
                    (id, asset_id, asset_owner) 
                 VALUES 
                    (?, ?, ?)"
            );
            $stmt->execute([
                $OriginalOwnership['id'],
                $Item['id'],
                $_SESSION['Roblox'],
            ]);

            //take
            $stmt = $this->Connection->prepare("UPDATE users SET roblox_robux = ?, roblox_tickets = ? WHERE roblox_username = ?");
            $stmt->execute([
                $User['roblox_robux'] - $Deal['item_price'],
                $User['roblox_tickets'] - $Deal['item_price'],
                $_SESSION['Roblox'],
            ]);
            $stmt = null;

            $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $Deal['item_owned']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();

            //give
            $stmt = $this->Connection->prepare("UPDATE users SET roblox_robux = ?, roblox_tickets = ? WHERE roblox_username = ?");
            $stmt->execute([
                $User['roblox_robux'] + $Deal['item_price'],
                $User['roblox_tickets'] + $Deal['item_price'],
                $Deal['item_owned'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("DELETE FROM resell WHERE id = ?");
            $stmt->execute(
                [
                    $DealID,
                ]
            );

            $_SESSION['Success'] = ['You have successfully bought this deal.'];
            header("Location: /Item/" . $Item['id']);
            die();
        }
    }

    public function SellAsset($AssetID) {
        if(is_numeric($AssetID)) {
            $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
            $ItemSearch->bindParam(":id", $AssetID);
            $ItemSearch->execute();
            $Item = $ItemSearch->fetch();

            $UserSearch = $this->Connection->prepare("SELECT id, roblox_robux, roblox_tickets FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $_SESSION['Roblox']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();

            $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner LIMIT 1");
            $OwnSearch->bindParam(":owner", $_SESSION['Roblox']);
            $OwnSearch->bindParam(":id", $Item['id']);
            $OwnSearch->execute();
            $Own = $OwnSearch->fetch();

            $OwnSearch = $this->Connection->prepare("SELECT id FROM resell WHERE item_selling = :id AND item_owned = :owner LIMIT 1");
            $OwnSearch->bindParam(":owner", $_SESSION['Roblox']);
            $OwnSearch->bindParam(":id", $Item['id']);
            $OwnSearch->execute();
            $Reselling = $OwnSearch->fetch();

            if(isset($_POST['resell_price']) && $_POST['resell_price'] < 0) {
                $_SESSION['Errors'] = ['Your resell price is too small.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if(!isset($Item['id'])) {
                $_SESSION['Errors'] = ['Item dont exist'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if(isset($Reselling['id'])) {
                $_SESSION['Errors'] = ['You are already reselling this asset.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if($Item['item_onsale'] == "n") {
                $_SESSION['Errors'] = ['Item offsale'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if(!isset($User['id'])) {
                $_SESSION['Errors'] = ['User dont exist'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if($Item['item_onsale'] == "n") {
                $_SESSION['Errors'] = ['item offsale.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if(!isset($Own['id'])) {
                $_SESSION['Errors'] = ['You don\'t own this item.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            /* Create a form handler class... This is extremely ugly */

            if(!isset($_SESSION['Roblox'])) {
                $_SESSION['Errors'] = ['You are not logged in'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            if($Item['item_quantity'] == -1) {
                $_SESSION['Errors'] = ['This item is not a limited.'];
                header("Location: /Item/" . $Item['id']);
                die();
            }

            $stmt = $this->Connection->prepare(
                "INSERT INTO resell 
                    (item_selling, item_owned, item_price) 
                 VALUES 
                    (?, ?, ?)"
            );
            $stmt->execute([
                $Item['id'],
                $_SESSION['Roblox'],
                $_POST['resell_price']
            ]);

            // delete item from original owner when bought

            $_SESSION['Success'] = ['You have successfully put this item up for sale.'];
            header("Location: /Item/" . $Item['id']);
            die();
        }
    }

    public function DeleteAsset($AssetID) {
        $CatalogSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
        $CatalogSearch->bindParam(":id", $AssetID);
        $CatalogSearch->execute();
        $Item = $CatalogSearch->fetch();

        if(!isset($Item['id'])) {
            $_SESSION['Errors'] = ['Your asset does not exist.'];
            header("Location: /Catalog/");
            die();
        }

        if(@$_SESSION['Roblox'] != $Item['item_author'] && !$_SESSION["Admin"]) {
            $_SESSION['Errors'] = ['You do not own this asset.'];
            header("Location: /Catalog/");
            die();
        }

        $Logger = new \Crapblox\Models\Log();
        $Logger->Log("**" . $_SESSION['Roblox'] . "** deleted assetid " . $AssetID . " (" . $Item['item_title'] . ")");

        $stmt = $this->Connection->prepare("DELETE FROM catalog WHERE id = ? AND item_author = ?");
        $stmt->execute(
            [
                $AssetID,
                $Item['item_author'],
            ]
        );

        unlink("/var/www/volumes/AssetFiles/" . $AssetID);

        $_SESSION['Success'] = ['Successfully deleted asset.'];
        header("Location: /Catalog/");
        die();
    }

    public function ReturnAvatar() {
        die("fart");
    }

    function LikeItem($ItemID) {
        $gameID = $ItemID;

        $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_cooldown >= NOW() - INTERVAL 1 MINUTE");
        $stmt->bindParam(":username", $_SESSION['Roblox']);
        $stmt->execute();
        if($stmt->rowCount() === 1) {
            $_SESSION['Errors'] = ['Wait a minute to like this game again.'];
            header("Location: /Game/" . $ItemID);
            exit;
        }
        /* Create a form handler class... This is extremely ugly */

        $GameSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
        $GameSearch->bindParam(":id", $gameID);
        $GameSearch->execute();
        $Game = $GameSearch->fetch();
        if(!isset($Game['id'])) {
            header("Location: /Catalog");
        }

        $UserSearch = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :user LIMIT 1");
        $UserSearch->bindParam(":user", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $RatingSearch = $this->Connection->prepare("SELECT * FROM item_ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'l' LIMIT 1");
        $RatingSearch->bindParam(":rating_to", $gameID);
        $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
        $RatingSearch->execute();
        $Rating = $RatingSearch->fetch();

        if(!isset($Rating['id'])) {
            $RatingSearch = $this->Connection->prepare("SELECT * FROM item_ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'd' LIMIT 1");
            $RatingSearch->bindParam(":rating_to", $gameID);
            $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
            $RatingSearch->execute();
            $Rating = $RatingSearch->fetch();
            if(!isset($Rating['id'])) {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO item_ratings 
                (rating_to, rating_by, rating_type) 
             VALUES 
                (?, ?, 'l')"
                );
                $stmt->execute([
                    $gameID,
                    $_SESSION['Roblox'],
                ]);
            } else {
                $stmt = $this->Connection->prepare("DELETE FROM item_ratings WHERE rating_to = ? AND rating_by = ? AND rating_type = 'd'");
                $stmt->execute(
                    [
                        $gameID,
                        $_SESSION['Roblox'],
                    ]
                );
            }
        } else {
            $stmt = $this->Connection->prepare("DELETE FROM item_ratings WHERE rating_to = ? AND rating_by = ? AND rating_type = 'l'");
            $stmt->execute(
                [
                    $gameID,
                    $_SESSION['Roblox'],
                ]
            );
        }

        header("Location: /Item/" . $gameID);
    }

    function DislikeItem($ItemID) {
        $gameID = $ItemID;

        $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_cooldown >= NOW() - INTERVAL 1 MINUTE");
        $stmt->bindParam(":username", $_SESSION['roblox']);
        $stmt->execute();
        if($stmt->rowCount() === 1) {
            $_SESSION['Errors'] = ['Wait a minute to dislike this game again.'];
            header("Location: /Item/" . $ItemID);
            exit;
        }
        /* Create a form handler class... This is extremely ugly */

        $GameSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
        $GameSearch->bindParam(":id", $gameID);
        $GameSearch->execute();
        $Game = $GameSearch->fetch();
        if(!isset($Game['id'])) {
            header("Location: /Catalog");
        }

        $UserSearch = $this->Connection->prepare("SELECT id FROM users WHERE roblox_username = :user LIMIT 1");
        $UserSearch->bindParam(":user", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $RatingSearch = $this->Connection->prepare("SELECT * FROM item_ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'l' LIMIT 1");
        $RatingSearch->bindParam(":rating_to", $gameID);
        $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
        $RatingSearch->execute();
        $Rating = $RatingSearch->fetch();

        if(!isset($Rating['id'])) {
            $RatingSearch = $this->Connection->prepare("SELECT * FROM item_ratings WHERE rating_to = :rating_to AND rating_by = :rating_by AND rating_type = 'd' LIMIT 1");
            $RatingSearch->bindParam(":rating_to", $gameID);
            $RatingSearch->bindParam(":rating_by", $_SESSION['Roblox']);
            $RatingSearch->execute();
            $Rating = $RatingSearch->fetch();
            if(!isset($Rating['id'])) {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO item_ratings 
                (rating_to, rating_by, rating_type) 
             VALUES 
                (?, ?, 'd')"
                );
                $stmt->execute([
                    $gameID,
                    $_SESSION['Roblox'],
                ]);
            } else {
                $stmt = $this->Connection->prepare("DELETE FROM item_ratings WHERE rating_to = ? AND rating_by = ? AND rating_type = 'd'");
                $stmt->execute(
                    [
                        $gameID,
                        $_SESSION['Roblox'],
                    ]
                );
            }
        } else {
            $stmt = $this->Connection->prepare("DELETE FROM item_ratings WHERE rating_to = ? AND rating_by = ? AND rating_type = 'l'");
            $stmt->execute(
                [
                    $gameID,
                    $_SESSION['Roblox'],
                ]
            );
        }

        header("Location: /Item/" . $gameID);
    }

    public function WearAsset($AssetID) {
        $UserSearch = $this->Connection->prepare("SELECT id, roblox_wear FROM users WHERE roblox_username = :id LIMIT 1");
        $UserSearch->bindParam(":id", $_SESSION['Roblox']);
        $UserSearch->execute();
        $User = $UserSearch->fetch();

        $ItemSearch = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :id LIMIT 1");
        $ItemSearch->bindParam(":id", $AssetID);
        $ItemSearch->execute();
        $Item = $ItemSearch->fetch();

        $OwnSearch = $this->Connection->prepare("SELECT id FROM ownerships WHERE asset_id = :id AND asset_owner = :owner LIMIT 1");
        $OwnSearch->bindParam(":owner", $_SESSION['Roblox']);
        $OwnSearch->bindParam(":id", $Item['id']);
        $OwnSearch->execute();
        $Own = $OwnSearch->fetch();

        if(!isset($User['id'])) {
            $_SESSION['Errors'] = ['User doesnt exist'];
            header("Location: /Avatar");
            die();
        }

        if(!isset($Own['id'])) {
            $_SESSION['Errors'] = ['You do not own this item.'];
            header("Location: /Avatar");
            die();
        }

        if(!isset($Item['id'])) {
            $_SESSION['Errors'] = ['Item doesnt exist'];
            header("Location: /Avatar");
            die();
        }

        if($Item['item_type'] == "Model" || $Item['item_type'] == "Mesh" || $Item['item_type'] == "Audio") {
            $_SESSION['Errors'] = ['Go kill yourself'];
            header("Location: /Avatar");
            die();
        }

        $wearing = explode(";", $User['roblox_wear']);
        if(in_array($AssetID, $wearing)) {
            $index = array_search($AssetID, $wearing);
            if($index !== FALSE){
                unset($wearing[$index]);
            }
            $wearing = implode(";", $wearing);
            $stmt = $this->Connection->prepare("UPDATE users SET roblox_wear = ? WHERE roblox_username = ?");
            $stmt->execute([
                $wearing,
                $_SESSION['Roblox'],
            ]);
            $stmt = null;

            $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_rendercooldown >= NOW() - INTERVAL 20 SECOND");
            $stmt->bindParam(":username", $_SESSION['Roblox']);
            $stmt->execute();
            // Horrible fix but fastcgi_finish_request makes redirect not work

            $Render = new \Crapblox\Models\Thumbnail\RenderServer();
            $Render->RenderUser($User["id"]);
        } else {
            if(!isset($_SESSION['Roblox'])) {
                $_SESSION['Errors'] = ['You are not logged in'];
                header("Location: /Avatar");
                die();
            }

            array_push($wearing, $AssetID);
            $wearing = implode(";", $wearing);
            $stmt = $this->Connection->prepare("UPDATE users SET roblox_wear = ? WHERE roblox_username = ?");
            $stmt->execute([
                $wearing,
                $_SESSION['Roblox'],
            ]);

            $stmt = $this->Connection->prepare("SELECT * FROM users WHERE roblox_username = :username AND roblox_rendercooldown >= NOW() - INTERVAL 20 SECOND");
            $stmt->bindParam(":username", $_SESSION['Roblox']);
            $stmt->execute();

            $Render = new \Crapblox\Models\Thumbnail\RenderServer();
            $Render->RenderUser($User["id"]);

            //$RawThumbnail = @file_get_contents("http://192.168.1.15/Thumbs/Avatar/Generate/" . $User['id']);
            //$Thumbnail = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $RawThumbnail));
            //file_put_contents("/var/www/volumes/Avatars/" . $User['id'] . ".png", $Thumbnail);
            //$stmt = null;
        }

        $_SESSION['Success'] = ['Successfully wore asset.'];
        //header("Location: /Avatar");
        // 'data:image/' . $type . ';base64,' . base64_encode($data);
        $RawThumbnail = file_get_contents("/var/www/volumes/Avatars/" . $User['id'] . ".png");
        $RawThumbnail = base64_encode($RawThumbnail);
        die(@$RawThumbnail);
    }

    public function Create() {
        $Validation = $this->Validator->make($_POST + $_FILES, [
            'title'                     => 'required|min:4|max:35',
            'description'               => 'required|min:4|max:250',
            'price'                     => 'required|numeric',
            'category'                  => 'required',
        ]);

        $Validation->validate();

        if ($Validation->fails()) {
            $_SESSION['Errors'] = $Validation->errors()->firstOfAll();
            header("Location: /Create/Asset");
            die();
        } else {
            $Categories = ["Hat", "Package", "Heads", "Games", "Shirt", "T-Shirt", "Pants", "Face", "Gear", "Audio", "Decal", "Model", "Mesh"];
			$AdminCategories = ["Hat", "Heads", "Package", "Gear", "Audio", "Mesh"];

			$Logger = new \Crapblox\Models\Log();
			$Logger->Log("**" . $_SESSION['Roblox'] . "** uploading " . $_POST['title'] . " " . $_POST["category"] . ",  desc " . $_POST['description'] . ", price " . $_POST["price"] . " zuos, ");

            if(isset($_POST['groupid'])) {
                $Group = new \Crapblox\Models\Group();
                $Group = $Group->GetGroupByID((int)$_POST['groupid']);
				$Logger->Log("**" . $_SESSION['Roblox'] . "** trying to upload " . $_POST['title'] . " under group " . $Group['group_title']);

                if($Group['group_owner'] != $_SESSION['Roblox']) {
                    $_SESSION['Errors'] = ['You don\'t own this group.'];
                    header("Location: /Create/Asset?GroupID=" . $_POST['groupid']);
                    die();
                }
            }

            if(!in_array($_POST['category'], $Categories)) {
                $_SESSION['Errors'] = ['Invalid Category'];
                header("Location: /");
                die();
            }

            if (!isset($_SESSION['Roblox'])) {
                $_SESSION['Errors'] = ['You are not logged in.'];
                header("Location: /");
                die();
            }

            if ($_POST['price'] <= -1) {
                $_SESSION['Errors'] = ['Invalid price'];
                header("Location: /Create/Asset");
                die();
            }

            if($_POST['category'] == "Hat" || $_POST['category'] == "Package" || $_POST['category'] == "Head" || $_POST['category'] == "Gear" || $_POST['category'] == "Mesh" || $_POST['category'] == "Audio") {
                $ff = ["xml", "rbxm", "ogg", "mp3", "mesh"];
            } else if($_POST['category'] == "Model") {
                $ff = ["rbxm", "xml"];
            } else {
                $ff = ["jpg", "png", "jpeg"];
            }
            $f = pathinfo($_FILES['asset']["name"], PATHINFO_EXTENSION);

            if (isset($_FILES['asset']) && $_FILES['asset']['name'] != "" && $_POST['category'] != "Gear" && $_POST['category'] != "Mesh" && $_POST['category'] != "Hat" && $_POST['category'] != "Heads" && $_POST['category'] != "Package" && $_POST['category'] != "Audio" && $_POST['category'] != "Model") {
                $mime_type = mime_content_type($_FILES['asset']['tmp_name']);
                $allowed_file_types = ['image/png', 'image/jpeg'];

                if (!in_array($mime_type, $allowed_file_types)) {
                    $_SESSION['Errors'] = ['Error 1'];
                    header("Location: /Create/Asset");
                    die();
                }
            }

            if($_POST['category'] != "Gear" && $_POST['category'] != "Mesh" && $_POST['category'] != "Hat"  && $_POST['category'] != "Heads" && $_POST['category'] != "Package" && $_POST['category'] != "Audio" && $_POST['category'] != "Model" && !exif_imagetype($_FILES['asset']["tmp_name"])) {
                $_SESSION['Errors'] = ['Invalid asset.'];
                header("Location: /Create/Asset");
                die();
            }

            if($_POST['category'] == "Model" && !$this->isXMLFileValid($_FILES['asset']["tmp_name"])) {
                $_SESSION['Errors'] = ['XML Malformed'];
                header("Location: /Create/Asset");
                die();
            }

            $UserSearch = $this->Connection->prepare("SELECT roblox_admin, roblox_cooldown FROM users WHERE roblox_username = :id LIMIT 1");
            $UserSearch->bindParam(":id", $_SESSION['Roblox']);
            $UserSearch->execute();
            $User = $UserSearch->fetch();

			if(in_array($_POST["category"],$AdminCategories))
			{
				if($User["roblox_admin"] == "y" || $User["roblox_admin"] == "c") {
					// admin
				} else {
					$_SESSION['Errors'] = ['Asset category privileged'];
					header("Location: /Create/Asset");
					die();
				}
			}
			
            $nextId = $this->Connection->query("SHOW TABLE STATUS LIKE 'catalog'")->fetch(\PDO::FETCH_ASSOC)['Auto_increment'] + 1;
            move_uploaded_file($_FILES['asset']["tmp_name"], "/var/www/volumes/AssetFiles/" . $nextId);
            if($_POST['category'] != "Gear" && $_POST['category'] != "Mesh" && $_POST['category'] != "Hat" && $_POST['category'] != "Model" && $_POST['category'] != "Audio" && $_POST['category'] != "Model") {
                copy("/var/www/volumes/AssetFiles/" . $nextId, "/var/www/volumes/Assets/" . $nextId . "." . $f);
            }

            // TODO: PLEASE REWRITE..... MY EYES ARE MELTING
            if($_POST['category'] == "Hat" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO ownerships 
                        (asset_id, asset_owner) 
                     VALUES
                        (?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_SESSION['Roblox'],
                ]);
                $stmt = $this->Connection->prepare(
                    "INSERT INTO catalog 
                    (id, item_title, item_description, item_author, item_thumb, item_type, item_tix) 
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_POST['title'],
                    $_POST['description'],
                    $_SESSION['Roblox'],
                    $nextId . ".png",
                    $_POST['category'],
                    $_POST['price'],
                ]);
                $stmt = null;

                if(isset($_POST['limited']) && $_POST['limited'] == "limited" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_quantity = :quantity WHERE id = :id");
                    $stmt->bindParam(":quantity", $_POST['quantity']);
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if($User['roblox_admin'] == "c" || $User['roblox_admin'] == "y" || $User['roblox_admin'] == "m") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_approved = 'y' WHERE id = :id");
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if(isset($_POST['visibility']) && $_POST['visibility'] == "visible") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['onsale']) && $_POST['onsale'] == "true") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['groupid'])) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_group = ? WHERE id = ?");
                    $stmt->execute([
                        $_POST['groupid'],
                        $nextId,
                    ]);
                }

                $Thumbnail = @file_get_contents("http://51.79.82.198:2757/render/asset/" . $nextId . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");
                $Thumbnail = base64_decode($Thumbnail);
                $thumbnail = $Thumbnail;
                file_put_contents("/var/www/volumes/Assets/" . $nextId . ".png", $thumbnail);
                header("Location: /Item/" . $nextId);
            } else if($_POST['category'] == "Gear" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO ownerships 
                    (asset_id, asset_owner) 
                 VALUES 
                    (?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_SESSION['Roblox'],
                ]);
                $stmt = $this->Connection->prepare(
                    "INSERT INTO catalog 
                    (id, item_title, item_description, item_author, item_thumb, item_type, item_tix) 
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_POST['title'],
                    $_POST['description'],
                    $_SESSION['Roblox'],
                    $nextId . ".png",
                    $_POST['category'],
                    $_POST['price'],
                ]);
                $stmt = null;
                if(isset($_POST['limited']) && $_POST['limited'] == "limited" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_quantity = :quantity WHERE id = :id");
                    $stmt->bindParam(":quantity", $_POST['quantity']);
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if($User['roblox_admin'] == "c" || $User['roblox_admin'] == "y" || $User['roblox_admin'] == "m") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_approved = 'y' WHERE id = :id");
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if(isset($_POST['visibility']) && $_POST['visibility'] == "visible") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['onsale']) && $_POST['onsale'] == "true") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }
                $Thumbnail = @file_get_contents("http://51.79.82.198:2757/render/asset/" . $nextId . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");

                $Thumbnail = base64_decode($Thumbnail);
                $thumbnail = $Thumbnail;
                file_put_contents("/var/www/volumes/Assets/" . $nextId . ".png", $thumbnail);
                header("Location: /Item/" . $nextId);
            } else if($_POST['category'] == "Heads" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO ownerships 
                    (asset_id, asset_owner) 
                 VALUES 
                    (?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_SESSION['Roblox'],
                ]);
                $stmt = $this->Connection->prepare(
                    "INSERT INTO catalog 
                    (id, item_title, item_description, item_author, item_thumb, item_type, item_tix) 
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_POST['title'],
                    $_POST['description'],
                    $_SESSION['Roblox'],
                    $nextId . ".png",
                    $_POST['category'],
                    $_POST['price'],
                ]);
                $stmt = null;
                if(isset($_POST['limited']) && $_POST['limited'] == "limited" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_quantity = :quantity WHERE id = :id");
                    $stmt->bindParam(":quantity", $_POST['quantity']);
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if($User['roblox_admin'] == "c" || $User['roblox_admin'] == "y" || $User['roblox_admin'] == "m") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_approved = 'y' WHERE id = :id");
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if(isset($_POST['visibility']) && $_POST['visibility'] == "visible") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['onsale']) && $_POST['onsale'] == "true") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }
                $Thumbnail = @file_get_contents("http://51.79.82.198:2757/render/asset/" . $nextId . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");

                $Thumbnail = base64_decode($Thumbnail);
                $thumbnail = $Thumbnail;
                file_put_contents("/var/www/volumes/Assets/" . $nextId . ".png", $thumbnail);
                header("Location: /Item/" . $nextId);
            }  else if($_POST['category'] == "Package" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO ownerships 
                    (asset_id, asset_owner) 
                 VALUES 
                    (?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_SESSION['Roblox'],
                ]);
                $stmt = $this->Connection->prepare(
                    "INSERT INTO catalog 
                    (id, item_title, item_description, item_author, item_thumb, item_type, item_tix) 
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_POST['title'],
                    $_POST['description'],
                    $_SESSION['Roblox'],
                    $nextId . ".png",
                    $_POST['category'],
                    $_POST['price'],
                ]);
                $stmt = null;
                if(isset($_POST['limited']) && $_POST['limited'] == "limited" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_quantity = :quantity WHERE id = :id");
                    $stmt->bindParam(":quantity", $_POST['quantity']);
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if($User['roblox_admin'] == "c" || $User['roblox_admin'] == "y" || $User['roblox_admin'] == "m") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_approved = 'y' WHERE id = :id");
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if(isset($_POST['visibility']) && $_POST['visibility'] == "visible") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['onsale']) && $_POST['onsale'] == "true") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }
                $Thumbnail = @file_get_contents("http://51.79.82.198:2757/render/asset/" . $nextId . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");

                $Thumbnail = base64_decode($Thumbnail);
                $thumbnail = $Thumbnail;
                file_put_contents("/var/www/volumes/Assets/" . $nextId . ".png", $thumbnail);
                header("Location: /Item/" . $nextId);
            } else if($_POST['category'] == "Model") {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO ownerships 
                    (asset_id, asset_owner) 
                 VALUES 
                    (?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_SESSION['Roblox'],
                ]);
                $stmt = $this->Connection->prepare(
                    "INSERT INTO catalog 
                    (id, item_title, item_description, item_author, item_thumb, item_type, item_tix) 
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_POST['title'],
                    $_POST['description'],
                    $_SESSION['Roblox'],
                    $nextId . ".png",
                    $_POST['category'],
                    $_POST['price'],
                ]);
                $stmt = null;
                if(isset($_POST['limited']) && $_POST['limited'] == "limited" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_quantity = :quantity WHERE id = :id");
                    $stmt->bindParam(":quantity", $_POST['quantity']);
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if($User['roblox_admin'] == "c" || $User['roblox_admin'] == "y" || $User['roblox_admin'] == "m") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_approved = 'y' WHERE id = :id");
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if(isset($_POST['visibility']) && $_POST['visibility'] == "visible") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['onsale']) && $_POST['onsale'] == "true") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['groupid'])) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_group = ? WHERE id = ?");
                    $stmt->execute([
                        $_POST['groupid'],
                        $nextId,
                    ]);
                }

                $Thumbnail = @file_get_contents("http://51.79.82.198:2757/render/asset/" . $nextId . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");

                $Thumbnail = base64_decode($Thumbnail);
                $thumbnail = $Thumbnail;
                file_put_contents("/var/www/volumes/Assets/" . $nextId . ".png", $thumbnail);
                header("Location: /Item/" . $nextId);
            } else if($_POST['category'] == "T-Shirt") {
                $xml =
                    '<roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.roblox.com/roblox.xsd" version="4">
                <External>null</External>
                <External>nil</External>
                <Item class="ShirtGraphic" referent="RBX0">
                <Properties>
                    <Content name="Graphic">
                    <url>http://www.roblox.com/Asset/?id=' . $nextId . '</url>
                    </Content>
                    <string name="Name">Shirt Graphic</string>
                    <bool name="archivable">true</bool>
                </Properties>
                </Item>
            </roblox>';
                file_put_contents("/var/www/volumes/AssetFiles/" . $nextId - 1, $xml);
            } else if($_POST['category'] == "Shirt") {
                $xml =
                    '<roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.roblox.com/roblox.xsd" version="4">
            <External>null</External>
            <External>nil</External>
            <Item class="Shirt" referent="RBX0">
                <Properties>
                    <Content name="ShirtTemplate">
                        <url>http://www.roblox.com/Asset/?id=' . $nextId . '</url>
                    </Content>
                    <string name="Name">Shirt</string>
                    <bool name="archivable">true</bool>
                </Properties>
            </Item>
            </roblox>';
                file_put_contents("/var/www/volumes/AssetFiles/" . $nextId - 1, $xml);
            } else if($_POST['category'] == "Face" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                $xml =
                    '<roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.roblox.com/roblox.xsd" version="4">
                <External>null</External>
                <External>nil</External>
                <Item class="Decal" referent="RBX0">
                    <Properties>
                        <token name="Face">5</token>
                        <string name="Name">face</string>
                        <float name="Shiny">20</float>
                        <float name="Specular">0</float>
                        <Content name="Texture"><url>http://www.roblox.com/Asset/?id=' . $nextId . '</url></Content>
                        <bool name="archivable">true</bool>
                    </Properties>
                </Item>
            </roblox>';
                file_put_contents("/var/www/volumes/AssetFiles/" . $nextId - 1, $xml);
            } else if($_POST['category'] == "Pants") {
                $xml =
                    '<roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.roblox.com/roblox.xsd" version="4">
            <External>null</External>
            <External>nil</External>
            <Item class="Pants" referent="RBX0">
                <Properties>
                    <Content name="PantsTemplate">
                        <url>http://www.roblox.com/Asset/?id=' . $nextId . '</url>
                    </Content>
                    <string name="Name">Pants</string>
                    <bool name="archivable">true</bool>
                </Properties>
            </Item>
            </roblox>';
                file_put_contents("/var/www/volumes/AssetFiles/" . $nextId - 1, $xml);
            } else if($_POST['category'] == "Mesh") {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO ownerships 
                    (asset_id, asset_owner) 
                 VALUES 
                    (?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_SESSION['Roblox'],
                ]);
                $stmt = $this->Connection->prepare(
                    "INSERT INTO catalog 
                    (id, item_title, item_description, item_author, item_thumb, item_type, item_tix) 
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_POST['title'],
                    $_POST['description'],
                    $_SESSION['Roblox'],
                    $nextId . ".png",
                    $_POST['category'],
                    $_POST['price'],
                ]);
                $stmt = null;
                if(isset($_POST['limited']) && $_POST['limited'] == "limited" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_quantity = :quantity WHERE id = :id");
                    $stmt->bindParam(":quantity", $_POST['quantity']);
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if($User['roblox_admin'] == "c" || $User['roblox_admin'] == "y" || $User['roblox_admin'] == "m") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_approved = 'y' WHERE id = :id");
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if(isset($_POST['visibility']) && $_POST['visibility'] == "visible") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['onsale']) && $_POST['onsale'] == "true") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['groupid'])) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_group = ? WHERE id = ?");
                    $stmt->execute([
                        $_POST['groupid'],
                        $nextId,
                    ]);
                }

                $Thumbnail = @file_get_contents("http://51.79.82.198:2757/render/asset/" . $nextId . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");

                $Thumbnail = base64_decode($Thumbnail);
                $thumbnail = $Thumbnail;
                file_put_contents("/var/www/volumes/Assets/" . $nextId . ".png", $thumbnail);
                header("Location: /Item/" . $nextId);
            } else if($_POST['category'] == "Decal") {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO ownerships 
                    (asset_id, asset_owner) 
                 VALUES 
                    (?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_SESSION['Roblox'],
                ]);
                $stmt = $this->Connection->prepare(
                    "INSERT INTO catalog 
                    (id, item_title, item_description, item_author, item_thumb, item_type, item_tix) 
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_POST['title'],
                    $_POST['description'],
                    $_SESSION['Roblox'],
                    $nextId . ".png",
                    $_POST['category'],
                    $_POST['price'],
                ]);
                $stmt = null;
                if(isset($_POST['limited']) && $_POST['limited'] == "limited" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_quantity = :quantity WHERE id = :id");
                    $stmt->bindParam(":quantity", $_POST['quantity']);
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if($User['roblox_admin'] == "c" || $User['roblox_admin'] == "y" || $User['roblox_admin'] == "m") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_approved = 'y' WHERE id = :id");
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if(isset($_POST['visibility']) && $_POST['visibility'] == "visible") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['onsale']) && $_POST['onsale'] == "true") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['groupid'])) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_group = ? WHERE id = ?");
                    $stmt->execute([
                        $_POST['groupid'],
                        $nextId,
                    ]);
                }

                //$thumbnail = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', @file_get_contents("http://51.79.82.198:2757/render/asset/" . $nextId)));
                // file_put_contents("Thumbs/Assets/" . $nextId . ".png", $thumbnail);

                header("Location: /Item/" . $nextId);
            } else if($_POST['category'] == "Audio") {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO ownerships 
                    (asset_id, asset_owner) 
                 VALUES 
                    (?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_SESSION['Roblox'],
                ]);
                $stmt = $this->Connection->prepare(
                    "INSERT INTO catalog 
                    (id, item_title, item_description, item_author, item_type, item_tix) 
                VALUES 
                    (?, ?, ?, ?, ?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_POST['title'],
                    $_POST['description'],
                    $_SESSION['Roblox'],
                    $_POST['category'],
                    $_POST['price'],
                ]);
                $stmt = null;
                if(isset($_POST['limited']) && $_POST['limited'] == "limited" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_quantity = :quantity WHERE id = :id");
                    $stmt->bindParam(":quantity", $_POST['quantity']);
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if($User['roblox_admin'] == "c" || $User['roblox_admin'] == "y" || $User['roblox_admin'] == "m") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_approved = 'y' WHERE id = :id");
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if(isset($_POST['visibility']) && $_POST['visibility'] == "visible") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['onsale']) && $_POST['onsale'] == "true") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['groupid'])) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_group = ? WHERE id = ?");
                    $stmt->execute([
                        $_POST['groupid'],
                        $nextId,
                    ]);
                }

                $thumbnail = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', @file_get_contents("http://192.168.1.15:80/Thumbs/Decal/Generate/84")));
                file_put_contents("/var/www/volumes/Assets/" . $nextId . ".png", $thumbnail);
                header("Location: /Item/" . $nextId);
            }

            if($_POST['category'] != "Mesh" && $_POST['category'] != "Package" && $_POST['category'] != "Heads" && $_POST['category'] != "Gear" && $_POST['category'] != "Hat" && $_POST['category'] != "Audio" && $_POST['category'] != "Decal" && $_POST['category'] != "Model") {
                $stmt = $this->Connection->prepare(
                    "INSERT INTO ownerships 
                    (asset_id, asset_owner) 
                 VALUES 
                    (?, ?)"
                );
                $stmt->execute([
                    $nextId,
                    $_SESSION['Roblox'],
                ]);

                $stmt = $this->Connection->prepare(
                    "INSERT INTO catalog 
                    (id, item_title, item_description, item_author, item_thumb, item_type, item_tix) 
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?)"
                );
                $final_file = $nextId . "." . $f;
                $stmt->execute([
                    $nextId,
                    $_POST['title'],
                    $_POST['description'],
                    $_SESSION['Roblox'],
                    $final_file,
                    $_POST['category'],
                    $_POST['price'],
                ]);
                $stmt = null;
                if(isset($_POST['limited']) && $_POST['limited'] == "limited" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_quantity = :quantity WHERE id = :id");
                    $stmt->bindParam(":quantity", $_POST['quantity']);
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if($User['roblox_admin'] == "c" || $User['roblox_admin'] == "y" || $User['roblox_admin'] == "m") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_approved = 'y' WHERE id = :id");
                    $stmt->bindParam(":id", $nextId);
                    $stmt->execute();
                }

                if(isset($_POST['visibility']) && $_POST['visibility'] == "visible") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['onsale']) && $_POST['onsale'] == "true") {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'y' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                } else {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'n' WHERE id = ?");
                    $stmt->execute([
                        $nextId,
                    ]);
                }

                if(isset($_POST['groupid'])) {
                    $stmt = $this->Connection->prepare("UPDATE catalog SET item_group = ? WHERE id = ?");
                    $stmt->execute([
                        $_POST['groupid'],
                        $nextId,
                    ]);
                }

                $Thumbnail = @file_get_contents("http://51.79.82.198:2757/render/asset/" . $nextId . "?key=8e57dd1a797fec1e5872a9944f296d0e36b03c3bb6d1");

                $Thumbnail = base64_decode($Thumbnail);
                $thumbnail = $Thumbnail;
                file_put_contents("/var/www/volumes/Assets/" . $nextId . ".png", $thumbnail);
                $stmt = $this->Connection->prepare("UPDATE catalog SET item_thumb = :item_thumb WHERE id = :id");
                $thumb = $nextId . ".png";
                $stmt->bindParam(":item_thumb", $thumb);
                $stmt->bindParam(":id", $nextId);
                $stmt->execute();
                header("Location: /Item/" . $nextId);
            }

            header("Location: /Item/" . $nextId);
        }
    }

    public function FetchRender($AssetID) {
        $Item = $this->GetAssetByID($AssetID);

        if($Item['item_type'] == "Shirt" || $Item['item_type'] == "Pants" || $Item['item_type'] == "T-Shirt" || $Item['item_type'] == "Face") { $Item['id'] = $Item['id'] - 1; }
        $assets = [
            "https://crapblox.com/Game/BodyColors.ashx?id=1",
            "https://crapblox.com/Asset/?id=" . (int)$Item['id'],
        ];

        echo implode(";", $assets);
    }

    public function SignScript($data) {
        $PrivKey = @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Required/PrivateKey.pem");
        openssl_sign($data, $signature, $PrivKey, OPENSSL_ALGO_SHA1);
        echo sprintf("--rbxsig%%%s%%%s", base64_encode($signature), $data);
    }

    public function Fetch() {
        // consider suicide

        if(isset($_GET['versionid'])) {
            $ROBLOSECURITY = ".ROBLOSECURITY=_|WARNING:-DO-NOT-SHARE-THIS.--Sharing-this-will-allow-someone-to-log-in-as-you-and-to-steal-your-ROBUX-and-items.|_E7CC31F9CE410DC2C54F9FFDF675DCCFD457FE24BD37B5A261F6B4004B1CBB85FC9B6E2DD57624344A1A845DE74BA03663F8E85B51BDD485DA179F5A4CDA74C280E7C5D169B6F9BF052800534E9DD0B9C6027932F985173C8ECF0C913C7C7556632D63459C0E91F093ACEA40B31798C2BD93829333C8FD94F3C1F4E1846C2952EF5497CB1B2B2D11DCBFA131CC8ED1168871B136C3FC49082FC9C3ED1BFB65D76F68857136B8C0B0353C911E3B5542030E8C048D3CCBD2D64DE84594B318C1168C4DD8B88124C6DC960842D7643B6E9B58DBD9F2F8F4C10A3C7AA3556A84206D524B0764B901915B0F1E37B8957E23B860AF418169E0AA8E0656C4AC79331A9C30A21BD956CB1C9521232F154C9A0EDBB97D22A18E551A3005BE1B67BF6C45DB90CF5254F5195322CF875456CA1115BC7A84CA38A0F68A5CC626B70F841E4733A0F631F47719A7D03DC5D57AADE7B88484CF3BDD4669834C8BA1FB045DC1F5F82420A85891511C65058592E94BAFA82CE5E4806F";
            header('Content-Type: text/plain');
            $url = 'https://assetdelivery.roblox.com/v1/asset/?assetversionid=' . (int)$_GET['versionid'];
            $ch = curl_init ($url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: " . $ROBLOSECURITY));
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0");
            curl_setopt($ch, CURLOPT_REFERER, 'https://www.roblox.com/');
            $output = curl_exec ($ch);
            echo $output;
            curl_close($ch);
            die();
        }

        if(isset($_GET['assetversionid'])) {
            $ROBLOSECURITY = ".ROBLOSECURITY=_|WARNING:-DO-NOT-SHARE-THIS.--Sharing-this-will-allow-someone-to-log-in-as-you-and-to-steal-your-ROBUX-and-items.|_E7CC31F9CE410DC2C54F9FFDF675DCCFD457FE24BD37B5A261F6B4004B1CBB85FC9B6E2DD57624344A1A845DE74BA03663F8E85B51BDD485DA179F5A4CDA74C280E7C5D169B6F9BF052800534E9DD0B9C6027932F985173C8ECF0C913C7C7556632D63459C0E91F093ACEA40B31798C2BD93829333C8FD94F3C1F4E1846C2952EF5497CB1B2B2D11DCBFA131CC8ED1168871B136C3FC49082FC9C3ED1BFB65D76F68857136B8C0B0353C911E3B5542030E8C048D3CCBD2D64DE84594B318C1168C4DD8B88124C6DC960842D7643B6E9B58DBD9F2F8F4C10A3C7AA3556A84206D524B0764B901915B0F1E37B8957E23B860AF418169E0AA8E0656C4AC79331A9C30A21BD956CB1C9521232F154C9A0EDBB97D22A18E551A3005BE1B67BF6C45DB90CF5254F5195322CF875456CA1115BC7A84CA38A0F68A5CC626B70F841E4733A0F631F47719A7D03DC5D57AADE7B88484CF3BDD4669834C8BA1FB045DC1F5F82420A85891511C65058592E94BAFA82CE5E4806F";
            header('Content-Type: text/plain');
            $url = 'https://assetdelivery.roblox.com/v1/asset/?assetversionid=' . (int)$_GET['assetversionid'];
            $ch = curl_init ($url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: " . $ROBLOSECURITY));
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0");
            curl_setopt($ch, CURLOPT_REFERER, 'https://www.roblox.com/');
            $output = curl_exec ($ch);
            echo $output;
            curl_close($ch);
            die();
        }

        if(isset($_GET['id'])) {
            $id = (int)$_GET["id"];
            $file = "/var/www/volumes/AssetFiles/" . $id;
            if ($id > 79) {
                if (!file_exists($file)) {
                    $file = "https://assetdelivery.roblox.com/v1/asset/?id=" . $id;
                    header("location:" . $file);
                } else {
                    header("content-type:text/plain");
                    readfile($file);
                }
            } else {
                if (!file_exists($file)) {
                    header('https://assetdelivery.roblox.com/v1/asset/?id=' . $id);
                } else {
                    header("Content-type: text/plain");
                    ob_start();
                    echo @file_get_contents($file);
                    $data = ob_get_clean();
                    $signature = "";
                    $key = @file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Models/PrivateKey.pem");
                    openssl_sign($data, $signature, $key, OPENSSL_ALGO_SHA1);
                    echo "--rbxsig" . sprintf("%%%s%%%s", base64_encode($signature), $data);
                }
            }
        }
    }

    public function EditItem($AssetID) {
        $Asset = $this->GetAssetByID($AssetID);
        if($this->AssetExists($AssetID) && $Asset['item_author'] == $_SESSION['Roblox']) {
            $User = new \Crapblox\Models\Auth\User();
            $User = $User->GetUserByUsername($_SESSION['Roblox']);
            $Categories = ["Hat", "Package", "Heads", "Shirt", "T-Shirt", "Pants", "Face", "Gear", "Audio", "Decal", "Model", "Mesh"];

            if(isset($_FILES['asset']) && $_FILES['asset']['name'] != "" && ($User['roblox_admin'] == 'y' || $User['roblox_admin'] == 'c')) {
                $mime_type = mime_content_type($_FILES['asset']['tmp_name']);

                $ff = ["xml", "rbxm", "rbxmx"];
                $f = pathinfo($_FILES['asset']["name"], PATHINFO_EXTENSION);

                if(!in_array($f, $ff)) {
                    $_SESSION['Errors'] = ['Assets can only use XML, RBXM, or RBXMX.'];
                    header("Location: /Edit/Asset/" . $Asset['id']);
                    die();
                }

                if ($_FILES["asset"]["size"] > 50000000) {
                    $_SESSION['Errors'] = ['Thumbnails too big bro'];
                    header("Location: /Edit/Asset/" . $Asset['id']);
                    die();
                }
            }

            if(strlen(trim($_POST['description'])) > 500) {
                $_SESSION['Errors'] = ['Your description is too long.'];
                header("Location: /Edit/Asset/" . $Asset['id']);
                die();
            }

            if(!isset($_POST['description']) || empty(trim($_POST['description']))) {
                $_SESSION['Errors'] = ['Your description is empty.'];
                header("Location: /Edit/Asset/" . $Asset['id']);
                die();
            }

            if ($_POST['price'] <= -1) {
                $_SESSION['Errors'] = ['Invalid price'];
                header("Location: /Create/Asset");
                die();
            }

            if(isset($_POST['limited']) && $_POST['limited'] == "limited" && ($User['roblox_admin'] == "y" || $User['roblox_admin'] == "c")) {
                $stmt = $this->Connection->prepare("UPDATE catalog SET item_quantity = :quantity WHERE id = :id");
                $stmt->bindParam(":quantity", $_POST['quantity']);
                $stmt->bindParam(":id", $Asset['id']);
                $stmt->execute();
            }

            if(isset($_POST['visibility']) && $_POST['visibility'] == "visible") {
                $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'y' WHERE id = ?");
                $stmt->execute([
                    $Asset['id'],
                ]);
            } else {
                $stmt = $this->Connection->prepare("UPDATE catalog SET item_visibile = 'n' WHERE id = ?");
                $stmt->execute([
                    $Asset['id'],
                ]);
            }

            if(isset($_POST['onsale']) && $_POST['onsale'] == "true") {
                $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'y' WHERE id = ?");
                $stmt->execute([
                    $Asset['id'],
                ]);
            } else {
                $stmt = $this->Connection->prepare("UPDATE catalog SET item_onsale = 'n' WHERE id = ?");
                $stmt->execute([
                    $Asset['id'],
                ]);
            }

            if(isset($_FILES['asset']) && $_FILES['asset']['name'] != "") {
                if($Asset['item_type'] == "Gear") {
                    move_uploaded_file($_FILES['asset']["tmp_name"], "/var/www/volumes/AssetFiles/" . $Asset['id'] - 1);
                } else {
                    move_uploaded_file($_FILES['asset']["tmp_name"], "/var/www/volumes/AssetFiles/" . $Asset['id']);
                }

                $thumbnail = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', @file_get_contents("http://192.168.1.15:80/Thumbs/Asset/Generate/" . $Asset['id'])));
                file_put_contents("/var/www/volumes/Assets/" . $Asset['id'] . ".png", $thumbnail);
            }

            $stmt = $this->Connection->prepare("UPDATE catalog SET item_title = ?, item_description = ?, item_tix = ? WHERE id = ?");
            $stmt->execute([
                $_POST['title'],
                $_POST['description'],
                $_POST['price'],
                $Asset['id'],
            ]);
            $_SESSION['Success'] = ['Successfully updated asset.'];
            header("Location: /Item/" . $Asset['id']);
            die();
        }
    }

    public function GetAssetByID($GameID) {
        $stmt = $this->Connection->prepare("SELECT * FROM catalog WHERE id = :find");
        $stmt->bindParam(":find", $GameID);
        $stmt->execute();

        return ($stmt->rowCount() === 0 ? 0 : $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function AssetExists($ID) {
        $stmt = $this->Connection->prepare("SELECT id FROM catalog WHERE id = :id");
        $stmt->bindParam(":id", $ID);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }
}