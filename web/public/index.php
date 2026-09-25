<?php
session_start();
ini_set('default_socket_timeout', 60); // I shouldn't have to be doing this
error_reporting(E_ALL ^ E_WARNING);

if(null === getenv("CRAPBLOX"))
    putenv("CRAPBLOX", "development");

if(getenv("CRAPBLOX") === "Fool")
    die("An error occured connecting to the database: SQLSTATE[HY000] [2002] php_network_getaddresses_crapblox_is_shuttingdown_forever: getaddrinfo for mysql failed: Temporary failure in name resolution");


require($_SERVER['DOCUMENT_ROOT'] . "/Lib/Configuration.php");
require($_SERVER['DOCUMENT_ROOT'] . "/Lib/Base.php");
require($_SERVER['DOCUMENT_ROOT'] . "/Views/Include.php");
require($_SERVER['DOCUMENT_ROOT'] . "/Models/Include.php");
require('../app/vendor/autoload.php');

$Configurator   = new Crapblox\Configurator();
$Base           = new Crapblox\Base();
$Router         = new \Bramus\Router\Router();

/*
 * GUIDELINE: Tag categories of endpoints with these following tags:
 *
 * [RCC]:      RCC related endpoint
 * [STUDIO]:   Studio related endpoint
 * [CLIENT]:   Client related endpoint
 * [AUTH]:     Authentication required endpoint
 * [API]:      POST requests, anything falling under /API/
 * [WEB]:      Stuff like trades, games pages, etc.
 * [MISC]:     Anything that doesn't fall under these categories
 * [OBSOLETE]: Obsolete. Remove soon.
 */

// [MISC] Initial pages
$Router->All('/', "\Crapblox\Views\Homepage@View");
$Router->All('/SignUp', "\Crapblox\Views\Homepage@SignUp");

if(getenv("CRAPBLOX") == "development")
{
    // [OBSOLETE] Testing endpoints -- TODO: OBSOLETE, get rid of these ASAP
    $Router->All('/3dRenderTest', "\Crapblox\Models\TwentySixteen@RenderTest");
}

$Router->All('/Game/JoinServerTest',                                  "\Crapblox\Models\TwentySixteen@JoinTest");

// [CLIENT] Client endpoints -- Endpoints used by client.
$Router->All('/Game/JoinServer',                                  "\Crapblox\Models\TwentySixteen@JoinServer");
// $Router->All('/GetAllowedMD5Hashes',                                  "\Crapblox\Models\TwentySixteen@AllowedMd5Hashes");
$Router->All('/game/load-place-info/',                                  "\Crapblox\Models\TwentySeventeen@LoadPlaceInfo"); // [2017]
$Router->All('/game/PlaceLauncher',                                  "\Crapblox\Models\TwentySeventeen@PlaceLauncher"); // [2017]
$Router->All('/game/join.ashx',                       "\Crapblox\Models\TwentySeventeen@JoinTest"); // [2017]


// [STUDIO] Studio endpoints -- Pages viewed in Studio.
$Router->All('/My/Places.aspx', "\Crapblox\Views\Studio@View");
$Router->All('/IDE/ClientToolbox.aspx', "\Crapblox\Views\Studio@Toolbox");
$Router->All('/ide/welcome',                                  "\Crapblox\Views\Studio@View");
$Router->All('/ide/welcome',                                  "\Crapblox\Views\Studio@View");
$Router->All('/game/visit.ashx',                        "\Crapblox\Models\Games@Visit");

// [CDN] Get asset
$Router->Get('/get-asset/{Type}/{Filename}',                                  "\Crapblox\Views\Incompetence@GetFile");

// [RCC] RCC endpoints    -- Endpoints used by RCC.
// Datastores
$Router->Post('/persistence/getV2',                                "\Crapblox\Models\Datastore@GetV2");
$Router->Post('/persistence/set',                                "\Crapblox\Models\Datastore@Set");
// AntiCheat
$Router->Get('/sys/',                                "\Crapblox\Models\TwentySeventeen@RemoteStats");

// [RCC] (most) endpoints below are required by RCC
$Router->All('/thumbs/staticimage', "\Crapblox\Models\Arbiter@FetchGameByID"); // secret rbxl endpoint
$Router->All('/moderation/filtertext', "\Crapblox\Models\TwentySixteen@FilterText");
$Router->All('/Universes/validate-place-join', "\Crapblox\Models\TwentySixteen@ValidateJoin");
$Router->All('/users/{UserID}/canmanage/{PlaceID}', "\Crapblox\Models\TwentySixteen@IfOwner");
$Router->All('/asset/bodycolors.ashx', "\Crapblox\Models\Avatar@BodyColors");
$Router->All('/Game/BodyColors.ashx', "\Crapblox\Models\Avatar@BodyColors");
$Router->All('/Game/validate-machine', "\Crapblox\Models\TwentySixteen@ValidateMachine");
$Router->All('/currency/balance', "\Crapblox\Models\TwentySixteen@Balance");
$Router->All('/my/economy-status', "\Crapblox\Models\TwentySixteen@EcoStatus");
$Router->All('/ownership/hasasset/{AssetID}/{UserID}', "\Crapblox\Models\TwentySixteen@HasAsset");
$Router->All('/Game/Tools/InsertAsset.ashx', "\Crapblox\Models\Asset@InsertAsset");
$Router->All('/Game/LoadPlaceInfo.ashx', "\Crapblox\Models\TwentySixteen@LoadPlaceInfo");
$Router->All('/marketplace/productinfo',                   "\Crapblox\Models\Games@ProductInfo");
$Router->All('/game/players/{UserID}',                                  "\Crapblox\Models\TwentySixteen@ChatFilter");

// If the user isn't logged in, none of these endpoints will be accessible.
// Do not put endpoints meant to be accessed by the Client in here,
// as they will not be accessible.

if(isset($_SESSION['Roblox'])) {
    $Router->All('/API/Friend/Revoke/{Username}',                      "\Crapblox\Models\Friends@Revoke");


    $Router->Get('/Trades/Create/{Username}', "\Crapblox\Views\Trading@Create");
    $Router->Post('/Trades/Create/{ID}', "\Crapblox\Models\Trading@Create");

    $Router->All('/Banned/Appeal', "\Crapblox\Views\User@Appeal");
    $Router->Get('/Banned', "\Crapblox\Views\User@Banned");
    $Router->All('/Feed', "\Crapblox\Views\Feed@View");

    // [WEB] Trading pages
    $Router->All('/Trades/Outgoing', "\Crapblox\Views\Trading@Outgoing");
    $Router->All('/Trades/Incoming', "\Crapblox\Views\Trading@Incoming");
    $Router->All('/Trades/Remove/{ID}', "\Crapblox\Models\Trading@Remove");
    $Router->All('/Trades/Decline/{ID}', "\Crapblox\Models\Trading@Decline");
    $Router->All('/Trades/Accept/{ID}', "\Crapblox\Models\Trading@Accept");
    $Router->All('/Transactions', "\Crapblox\Views\Transactions@View");

    // [WEB] Forum pages
    $Router->All('/Forum', "\Crapblox\Views\Forums@View");
    $Router->All('/Forum/Action/Delete/Reply/{ID}', "\Crapblox\Models\Forums@DeleteReply");
    $Router->All('/Forum/Action/Delete/Thread/{ID}', "\Crapblox\Models\Forums@DeleteThread");
    $Router->All('/Forum/Thread/{Thread}', "\Crapblox\Views\Forums@ViewThread");
    $Router->All('/Forum/{Category}', "\Crapblox\Views\Forums@ViewCategory");

    $Router->All('/Avatar', "\Crapblox\Views\Avatar@View");
    $Router->All('/Settings', "\Crapblox\Views\Settings@View");

    // [WEB] Admin pages
    // Keep these organized

    $Router->All('/Admin/', "\Crapblox\Views\Admin@View");

    $Router->Get('/Admin/User/Ban', "\Crapblox\Views\Admin@BanUser");
    $Router->Get('/Admin/User/Unban', "\Crapblox\Views\Admin@UnbanUser");
    $Router->Get('/Admin/User/Item', "\Crapblox\Views\Admin@GiveAsset");
    $Router->Get('/Admin/User/Compensate', "\Crapblox\Views\Admin@GiveMoolah");
    $Router->Get('/Admin/User/Alts', "\Crapblox\Views\Admin@PossibleAlts");

    $Router->Get('/Admin/Redact/Description', "\Crapblox\Views\Admin@RedactDescription");
    $Router->Post('/Admin/Redact/Description', "\Crapblox\Models\Admin@RedactDescription");

    $Router->Get('/Admin/Redact/CSS', "\Crapblox\Views\Admin@RedactCSS");
    $Router->Post('/Admin/Redact/CSS', "\Crapblox\Models\Admin@RedactCSS");

    $Router->Post('/Admin/User/Ban', "\Crapblox\Models\Admin@BanUser");
    $Router->Post('/Admin/User/Unban', "\Crapblox\Models\Admin@UnbanUser");
    $Router->Post('/Admin/User/Item', "\Crapblox\Models\Admin@GiveAsset");
    $Router->Post('/Admin/User/Compensate', "\Crapblox\Models\Admin@GiveMoolah");

    $Router->Get('/Admin/Game/Close', "\Crapblox\Views\Admin@CloseGame");
    $Router->Get('/Admin/Game/Feature', "\Crapblox\Views\Admin@FeatureGame");
    $Router->Post('/Admin/Game/Close', "\Crapblox\Models\Admin@CloseGame");
    $Router->Post('/Admin/Game/Feature', "\Crapblox\Models\Admin@FeatureGame");

    $Router->Get('/Admin/Catalog/Approvals', "\Crapblox\Views\Admin@Approval");
    $Router->Get('/Admin/Catalog/Deny', "\Crapblox\Models\Admin@DenyAsset");
    $Router->Get('/Admin/Catalog/Approve', "\Crapblox\Models\Admin@ApproveAsset");

    $Router->Get('/Admin/Ads/Deny', "\Crapblox\Models\Admin@DenyAd");
    $Router->Get('/Admin/Ads/Approve', "\Crapblox\Models\Admin@ApproveAd");

    $Router->Get('/Admin/Ads/Deny', "\Crapblox\Models\Admin@DenyAd");
    $Router->Get('/Admin/Ads/Approve', "\Crapblox\Models\Admin@ApproveAd");

    $Router->Get('/Admin/Games/Deny', "\Crapblox\Models\Admin@DenyGame");
    $Router->Get('/Admin/Games/Approve', "\Crapblox\Models\Admin@ApproveGame");

    $Router->Get('/Admin/Groups/Deny', "\Crapblox\Models\Admin@DenyGroup");
    $Router->Get('/Admin/Groups/Approve', "\Crapblox\Models\Admin@ApproveGroup");

    $Router->Get('/Admin/Games/Deny', "\Crapblox\Models\Admin@DenyGame");
    $Router->Get('/Admin/Games/Approve', "\Crapblox\Models\Admin@ApproveGame");

    $Router->Get('/Admin/User/Name', "\Crapblox\Views\Admin@ChangeName");
    $Router->Post('/Admin/User/Name', "\Crapblox\Models\Admin@ChangeName");

    $Router->Get('/Admin/User/Delete', "\Crapblox\Views\Admin@DeleteUser");
    $Router->Post('/Admin/User/Delete', "\Crapblox\Models\Admin@DeleteUser");

    $Router->Get('/Admin/News/Create', "\Crapblox\Views\Admin@NewNews");
    $Router->Post('/Admin/News/Create', "\Crapblox\Models\Admin@NewNews");

    // [WEB] Edit <x> pages
    // Used for pages that are intended to let the user edit something 
    $Router->All('/Edit/Game/{GameID}/Thumbnails', "\Crapblox\Views\Games@EditThumbnails");
    $Router->All('/Edit/Game/{GameID}/Badges', "\Crapblox\Views\Incompetence@FeatureIncomplete");
    $Router->All('/Edit/Game/{GameID}', "\Crapblox\Views\Games@EditView");

    $Router->All('/Edit/Group/{GroupID}', "\Crapblox\Views\Groups@EditView");
    $Router->All('/Edit/Asset/{GameID}', "\Crapblox\Views\Catalog@EditView");

    // [WEB] Game pages
    // Game related endpoints
    $Router->Get('/Game/Download/{GameID}', "\Crapblox\Views\Games@DownloadGame");
    $Router->All('/Games', "\Crapblox\Views\Games@View");
    $Router->Get('/{GameID}-place', "\Crapblox\Views\Games@ViewPlace");
    $Router->Get('/{GameID}-blog', "\Crapblox\Views\News@View");
    $Router->All('/Game/{GameID}', "\Crapblox\Views\Games@ViewGame");
    $Router->All('/Games/Search/', "\Crapblox\Views\Games@Search");
    $Router->All('/Games/{Category}', "\Crapblox\Views\Games@ViewCategory");

    // [WEB] Inbox pages -- /Inbox/*
    $Router->All('/Inbox/', "\Crapblox\Views\Inbox@View");
    $Router->All('/Inbox/Compose/{Username}', "\Crapblox\Views\Inbox@Compose");
    $Router->All('/Inbox/Compose/', "\Crapblox\Views\Inbox@Compose");
    $Router->All('/Inbox/Sent/', "\Crapblox\Views\Inbox@View");
    $Router->All('/Inbox/Notifications', "\Crapblox\Views\Incompetence@FeatureIncomplete");
    $Router->All('/Inbox/Invites', "\Crapblox\Views\Incompetence@FeatureIncomplete");
    $Router->Post('/API/Inbox/Send',                                "\Crapblox\Models\Inbox@Compose");


    // [WEB] Catalog pages
    $Router->All('/Item/Resell/{AssetID}', "\Crapblox\Views\Catalog@Resell");
    $Router->All('/Item/{AssetID}', "\Crapblox\Views\Catalog@ViewItem");
    $Router->All('/Catalog', "\Crapblox\Views\Catalog@View");
    $Router->All('/Develop', "\Crapblox\Views\Develop@View");
    $Router->All('/Develop/{Category}', "\Crapblox\Views\Develop@ViewCategory");
    $Router->All('/Friends', "\Crapblox\Views\Friends@View");
    $Router->All('/Referral', "\Crapblox\Views\Referral@View");
    $Router->All('/Stocks', "\Crapblox\Views\Stocks@View");
    if(getenv("STOCKS") !== "OFF")
    {
        $Router->All('/Stocks/Group/{GroupID}', "\Crapblox\Views\Groups@Stocks");
    }
    $Router->All('/Catalog/Search/', "\Crapblox\Views\Catalog@Search");
    $Router->All('/Catalog/{Category}', "\Crapblox\Views\Catalog@ViewCategory");

    // [WEB] Develop pages
    $Router->All('/Develop', "\Crapblox\Views\Develop@View");
    $Router->All('/Develop/{Category}', "\Crapblox\Views\Develop@ViewCategory");

    // [MISC] Single pages
    $Router->All('/Friends', "\Crapblox\Views\Friends@View");
    $Router->All('/Referral', "\Crapblox\Views\Referral@View");
    $Router->All('/Stocks', "\Crapblox\Views\Stocks@View");
    $Router->All('/Ads', "\Crapblox\Views\Ads@View");

    // [WEB] Group pages
    $Router->All('/Groups/', "\Crapblox\Views\Groups@View");
    $Router->All('/Groups/Search/', "\Crapblox\Views\Groups@Search");
    $Router->All('/Groups/{GameID}', "\Crapblox\Views\Groups@ViewGroup");

    // [WEB] Create pages
    $Router->All('/Create/Game', "\Crapblox\Views\Games@CreateView");
    $Router->All('/Create/Asset', "\Crapblox\Views\Catalog@CreateView");
    $Router->All('/Create/Group', "\Crapblox\Views\Groups@CreateView");
    $Router->All('/Create/Thread/{Category}', "\Crapblox\Views\Forums@CreateView");

    // [WEB] User pages
    $Router->All('/User/{Username}', "\Crapblox\Views\User@View");
    $Router->All('/Users/Search', "\Crapblox\Views\User@Search");
    $Router->All('/Users', "\Crapblox\Views\User@List");

    // [API] This is horrible and none of these routes should be allowing ALL.
    // Check Admin endpoints for what you should base new endpoints off of.

    // TODO: Please refactor soon. These should be considered obsolete

    $Router->All('/API/Job/RenewLease/{PlaceID}',                                "\Crapblox\Models\Games@StartGame");
    $Router->All('/API/Create/Referral',                                "\Crapblox\Models\Referral@Create");
    $Router->All('/API/Create/Ad',                                "\Crapblox\Models\Ads@Create");
    $Router->All('/API/Create/Game',                                "\Crapblox\Models\Games@Create");
    $Router->All('/API/Create/Group',                                "\Crapblox\Models\Group@Create");
    $Router->All('/API/Create/Thread/{Category}',                                "\Crapblox\Models\Forums@Create");
    $Router->All('/API/Create/Reply/{Thread}',                                "\Crapblox\Models\Forums@Reply");
    $Router->All('/API/Async/Test',                                "\Crapblox\Models\Thumbnail\RenderServer@Test");
    $Router->Get('/API/Responsive/Catalog',                                "\Crapblox\Models\Responsive@Catalog");
    $Router->Get('/API/Responsive/Avatar',                                "\Crapblox\Models\Responsive@Avatar");
    $Router->Get('/API/Responsive/Users',                                "\Crapblox\Models\Responsive@Users");

    $Router->Get('/API/Game/Favorite/{GameID}',                     "\Crapblox\Models\Games@FavoriteGame");
    $Router->Get('/API/Game/Like/{GameID}',                     "\Crapblox\Models\Games@LikeGame");
    $Router->Get('/API/Game/Dislike/{GameID}',                     "\Crapblox\Models\Games@DislikeGame");
    $Router->Get('/API/Game/Delete/{GameID}',                     "\Crapblox\Models\Games@DeleteGame");
    $Router->Get('/API/Game/Shutdown/{GameID}',                     "\Crapblox\Models\Games@ShutdownGame");
} else {
    $Router->All('/Feed', "\Crapblox\Views\Feed@View");
}

/*
    CRAPBLOX Routes (Api)
    (eg. https://crapblox.com/API/*)
*/

$Router->Post('/API/Create/Asset',                                "\Crapblox\Models\Asset@Create");
$Router->All('/GmodServer',                                "\Crapblox\Views\Gmod@View");
$Router->All('/Error/Grid.ashx',                                "\Crapblox\Views\Gmod@View");
$Router->All('/API/Game/{GameID}',                                "\Crapblox\Models\Games@GameInfo");
$Router->All('/persistence/getV2',                                "\Crapblox\Models\Persistence@GetAsync");
$Router->All('/persistence/set',                                "\Crapblox\Models\Persistence@SetAsync");
$Router->All('/API/Theme/Set',                                "\Crapblox\Models\Theme@Set");
$Router->All('/API/Auth/Register',                              "\Crapblox\Models\Auth\User@CreateUser");
$Router->All('/API/Auth/Signin',                                "\Crapblox\Models\Auth\User@SigninUser");
$Router->All('/API/Auth/Logout',                                "\Crapblox\Models\Auth\User@Logout");
$Router->All('/API/Feed/New',                                   "\Crapblox\Models\Feed@New");
$Router->All('/API/Stock/Buy',                                   "\Crapblox\Models\Stocks@Buy");
$Router->All('/API/Stock/Sell/{StockID}',                                   "\Crapblox\Models\Stocks@Sell");
$Router->All('/API/Friend/Add/{Username}',                      "\Crapblox\Models\Friends@New");
$Router->All('/API/Friend/Accept/{Username}',                      "\Crapblox\Models\Friends@Accept");
$Router->All('/API/Friend/Decline/{Username}',                      "\Crapblox\Models\Friends@Decline");
$Router->All('/API/Comment/Profile/{Username}',                 "\Crapblox\Models\Comment\User@New");
$Router->All('/API/Comment/Game/{GameID}',                      "\Crapblox\Models\Comment\Game@New");
$Router->All('/API/Comment/Item/{ItemID}',                      "\Crapblox\Models\Comment\Item@New");
$Router->All('/API/Comment/Group/{GroupID}',                      "\Crapblox\Models\Comment\Group@New");
$Router->All('/API/Comment/News/{GroupID}',                      "\Crapblox\Models\Comment\News@New");
$Router->All('/API/Group/Join/{GroupID}',                     "\Crapblox\Models\Group@JoinGroup");
$Router->All('/API/Group/Kick/{GroupID}/{Username}',                     "\Crapblox\Models\Group@Kick");
$Router->All('/API/Item/Like/{ItemID}',                     "\Crapblox\Models\Asset@LikeItem");
$Router->All('/API/Item/Dislike/{ItemID}',                     "\Crapblox\Models\Asset@DislikeItem");
$Router->All('/API/Asset/Delete/{AssetID}',                     "\Crapblox\Models\Asset@DeleteAsset");
$Router->All('/API/Group/Delete/{GroupID}',                     "\Crapblox\Models\Group@DeleteGroup");
$Router->All('/API/Group/ShareCount/{GroupID}',                     "\Crapblox\Models\Group@GroupSetShares");
$Router->All('/API/Group/RebuyStocks/{GroupID}',                     "\Crapblox\Models\Group@GroupRebuyStocks");
$Router->All('/API/Group/ShareForSale/{GroupID}',                     "\Crapblox\Models\Group@GroupSetSharesForSale");
$Router->All('/API/Group/BuyShares/{GroupID}',                     "\Crapblox\Models\Group@UserBuyShares");
$Router->All('/API/Group/SellShares/{GroupID}',                     "\Crapblox\Models\Group@UserSellShares");
$Router->All('/API/Group/Feed/{GroupID}',                     "\Crapblox\Models\Group@GroupRSS");
$Router->All('/API/Group/Feed',                     "\Crapblox\Models\Group@GroupRSSAll");
$Router->Post('/API/Edit/Game/Thumbnail/{GameID}',                  "\Crapblox\Models\Games@EditThumbnail");
$Router->All('/API/Edit/Game/{GameID}',                         "\Crapblox\Models\Games@EditGame");
$Router->All('/API/Edit/Asset/{AssetID}',                       "\Crapblox\Models\Asset@EditItem");
$Router->All('/API/Edit/Group/{GroupID}',                       "\Crapblox\Models\Group@EditGroup");
$Router->All('/API/Buy/Asset/{AssetID}',                        "\Crapblox\Models\Asset@BuyAsset");
$Router->All('/API/BuyLimited/Deal/{DealID}',                        "\Crapblox\Models\Asset@BuyDeal");
$Router->All('/API/BuyLimited/Remove/{DealID}',                        "\Crapblox\Models\Asset@RemoveDeal");
$Router->All('/API/Sell/Asset/{AssetID}',                        "\Crapblox\Models\Asset@SellAsset");
$Router->All('/API/Wear/Asset/{AssetID}',                       "\Crapblox\Models\Asset@WearAsset");
$Router->Post('/API/Update/Profile/Description/{Username}',      "\Crapblox\Models\Auth\User@UpdateDescription");
$Router->Post('/API/Update/Profile/CSS/{Username}',      "\Crapblox\Models\Auth\User@UpdateCSS");
$Router->All('/API/Update/BodyColors',                          "\Crapblox\Models\Auth\User@UpdateBodyColors");
$Router->All('/API/Update/UserThumb',                          "\Crapblox\Models\Thumbnail\RenderServer@RedrawAvatar");
$Router->All('/API/Update/UserThumb/{User}',                          "\Crapblox\Models\Thumbnail\RenderServer@RedrawAvatarForce");
$Router->All('/API/Update/DecalRender/{User}',                          "\Crapblox\Models\Thumbnail\RenderServer@RedrawDecalForce");
$Router->All('/API/Update/AssetRender/{User}',                          "\Crapblox\Models\Thumbnail\RenderServer@RedrawAssetForce");
$Router->All('/API/Update/3DRender/{User}',                          "\Crapblox\Models\Thumbnail\RenderServer@Redraw3DForce");

// New
$Router->Get('/get/user-info/id/{UserID}',                          "\Crapblox\Models\Auth\User@GetUserInfo");
$Router->Get('/get/user-info/user/{Username}',                          "\Crapblox\Models\Auth\User@GetUserInfoUser");

/*
    CRAPBLOX Unbypassed (APIs)
    (eg. https://crapblox.com/*)
*/
$Router->All('/Game/LuaWebService/HandleSocialRequest.ashx',        "\Crapblox\Models\Friends@IsFriendsWith");
$Router->All('/Friend/AreFriends',        "\Crapblox\Models\Friends@AreFriends");
$Router->All('/Friend/CreateFriend',        "\Crapblox\Models\Friends@CreateFriend");
$Router->All('/API/KeepAlive',                                "\Crapblox\Models\Games@KeepAlive");
$Router->All('/UploadMedia/PostImage.aspx', "\Crapblox\Views\Games@Screenshot");
$Router->All('/Join/Game',                              "\Crapblox\Models\Games@Join");
$Router->All('/Host/Game',                              "\Crapblox\Models\Games@Host");
$Router->All('/API/GetGameInfo/Author',                 "\Crapblox\Models\Games@GetAuthorInfo");
$Router->All('/API/GetGameInfo/Name',                   "\Crapblox\Models\Games@GetName");
$Router->All('/game/studio.ashx',                       "\Crapblox\Models\Games@Studio");
$Router->All('/game/gameserver.ashx',                       "\Crapblox\Models\Games@GameServer");
$Router->All('/v1.1/avatar-fetch/{UserID}',             "\Crapblox\Models\Avatar@Fetch");
$Router->All('/Tools/FetchCharacterAppearance.aspx',             "\Crapblox\Models\Avatar@Fetch2013");

$Router->All('/Setting/QuietGet/ClientAppSettings',     "\Crapblox\Models\ClientSettings@ThirteenClientSettings");
$Router->All('/Setting/QuietGet/CometAppSettings',     "\Crapblox\Models\ClientSettings@ClientSettings");
$Router->All('/Setting/QuietGet/ClientSharedSettings',  "\Crapblox\Models\ClientSettings@ThirteenClientSettings");
$Router->All('/Setting/QuietGet/AfghanSharedSettings',  "\Crapblox\Models\ClientSettings@ClientSettings2017");
$Router->All('/Setting/QuietGet/RCCService',  "\Crapblox\Models\ClientSettings@RCCSettings");
// For 2017

// DEPRECATED LAUNCHER ROUTES
// WHY? BECAUSE DIMP'S LAUNCHER SUCKS

// $Router->All('/game/GetCurrentHash',                    "\Crapblox\Models\Launcher@HashCheck");
// $Router->All('/game/infoData',                    "\Crapblox\Models\Launcher@InfoData");
// $Router->All('/game/GetCurrentVersion',                 "\Crapblox\Models\Launcher@VersionCheck");

$Router->All('/Launcher/Info',                    "\Crapblox\Models\Launcher@Info");

$Router->All('/Asset/',                                  "\Crapblox\Models\Asset@Fetch");
$Router->All('/asset/',                                  "\Crapblox\Models\Asset@Fetch");
$Router->All('/Game/Tools/ThumbnailAsset.ashx',                                  "\Crapblox\Models\Asset@ThumbnailAsset");
$Router->All('/v1.1/avatar-fetch/{UserID}',             "\Crapblox\Models\Avatar@Fetch");
$Router->All('/v1.1/asset-render/{AssetID}',            "\Crapblox\Models\Asset@FetchRender");
$Router->All('/Thumbs/Asset/Generate/{AssetID}',        "\Crapblox\Models\Thumbnail\RenderServer@RenderAsset");
$Router->All('/Thumbs/Model/Generate/{AssetID}',        "\Crapblox\Models\Thumbnail\RenderServer@RenderModel");
$Router->All('/Thumbs/Mesh/Generate/{AssetID}',        "\Crapblox\Models\Thumbnail\RenderServer@RenderMesh");
$Router->All('/Thumbs/Decal/Generate/{AssetID}',        "\Crapblox\Models\Thumbnail\RenderServer@RenderDecal");
$Router->All('/Thumbs/Avatar/Generate/{UserID}',        "\Crapblox\Models\Thumbnail\RenderServer@RenderUser");
$Router->All('/Thumbs/Asset.ashx',        "\Crapblox\Models\Thumbnail\RenderServer@GetGameThumbnail");
$Router->All('/thumbs/avatar.ashx',        "\Crapblox\Models\Thumbnail\RenderServer@GetAvatarThumbnail");
// $Router->All('/get-asset/Avatars/{Filename}',            "\Crapblox\Models\Asset@ReturnAvatar");
$Router->All('/thumbnail/avatar/bodyshot/{UserID}',            "\Crapblox\Models\Asset@ReturnAvatar");
$Router->All('/GetAllowedMD5Hashes',            "\Crapblox\Models\Launcher@GetAllowedMD5Hashes");
//$Router->All('/GetAllowedSecurityVersions',            "\Crapblox\Models\Launcher@GetAllowedSecurityVersions");
$Router->All('/arbiter/{ID}/serverrunning',            "\Crapblox\Models\Arbiter@IsGameserverRunning");
$Router->All('/arbiter/identify',            "\Crapblox\Models\Arbiter@Identify");
$Router->All('/arbiter/{UUID}/status',            "\Crapblox\Models\Arbiter@Status");
$Router->All('/arbiter/{UUID}/resources',            "\Crapblox\Models\Arbiter@Resources");
$Router->All('/arbiter/{UUID}/log',            "\Crapblox\Models\Arbiter@Log");
$Router->All('/arbiter/{UUID}/resources',            "\Crapblox\Models\Arbiter@Resources");
$Router->All('/arbiter/{UUID}/test/job',            "\Crapblox\Models\Arbiter@TestJob");
$Router->All('/arbiter/{UUID}/test/job2',            "\Crapblox\Models\Arbiter@TestJobNew");
$Router->All('/arbiter/{UUID}/render/user/{ID}',            "\Crapblox\Models\Arbiter@RenderUser");
$Router->All('/arbiter/{Token}/kill',            "\Crapblox\Models\Arbiter@Kill");
$Router->All('/arbiter/{JobID}/killjob',            "\Crapblox\Models\Arbiter@KillJob");
$Router->All('/arbiter/{Token}/renew',            "\Crapblox\Models\Arbiter@ExtendJob");

if(getenv("MMMMOH_ENABLE") != false)
{
    #$Router->All('/API/mmmmoh/add/{User}/{Amount}',                          "\Crapblox\Models\Stocks@AddMoney");
    #$Router->All('/API/mmmmoh/remove/{User}/{Amount}',                          "\Crapblox\Models\Stocks@RemoveMoney");
    #$Router->All('/API/mmmmoh/set/{User}/{Amount}',                          "\Crapblox\Models\Stocks@SetMoney");
    #$Router->All('/API/mmmmoh/get/{User}',                          "\Crapblox\Models\Stocks@GetMoney");
    $Router->All('/API/event/award/{User}/{Item}/{Key}',                          "\Crapblox\Models\Stocks@AwardItem");
}

$Router->Set404(function() {
    header("HTTP/1.0 404 Not Found");

    if(isset($_SESSION['Roblox'])) {
        $Currency = new \Crapblox\Models\Auth\User();
        $Currency = $Currency->GetUserByUsername($_SESSION['Roblox']);
        $_GET["Currency"] = $Currency['roblox_tickets'];
    }

    $Error = new Crapblox\Models\NotFound;
    $Error->View();
});

$Router->run();

if(!str_contains($_SERVER['REQUEST_URI'], "API/")) {
    unset($_SESSION['Errors']);
    unset($_SESSION['Success']);
}