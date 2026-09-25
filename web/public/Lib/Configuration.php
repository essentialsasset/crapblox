<?php
namespace Crapblox;

use \Twig;
use \Twig\Extra\Markdown\MarkdownExtension;
use \Twig\Extra\Markdown\DefaultMarkdown;
use \Twig\Extra\Markdown\MarkdownRuntime;
use \Twig\RuntimeLoader\RuntimeLoaderInterface;
use \Rakit\Validation\Validator;

class Configurator {
    public $Configuration;
    public $Twig;
    public $Validator;
    public $RCCServiceSoap;
    public $RobloxColors;
    public $FullColors;
    public $TwoFactorAuth;
    public $TwoFactorAuthSecret;
    public $TwoFactorImage;
    public $TwoFactorCode;

    function __construct() {
        $this->replicateConfig();
        $this->replicate2FA();
        $this->replicateTwig();
        $this->replicateValidator();
        // $this->replicateRCCSoap();
        $this->replicateColors();
    }

    protected function replicateColors() {
        $this->RobloxColors = [
            "Dirt brown",
            "Reddish brown",
            "Brown",
            "Sand red",
            "Linen",
            "Burlap",
            "Brick yellow",
            "Medium red",
            "Dusty Rose",
            "CGA brown",
            "Dark orange",
            "Nougat",
            "Light orange",
            "Pastel brown",
            "Neon orange",
            "Bright orange",
            "Br. yellowish orange",
            "Deep orange",
            "Bright yellow",
            "Daisy orange",
            "Cool yellow",
            "Earth green",
            "Camo",
            "Dark green",
            "Bright green",
            "Shamrock",
            "Moss",
            "Br. yellowish green",
            "Navy blue",
            "Deep blue",
            "Really blue",
            "Bright blue",
            "Steel blue",
            "Light blue",
            "Bright bluish green",
            "Teal",
            "Pastel blue-green",
            "Toothpaste",
            "Cyan",
            "Pastel Blue",
            "Pastel light blue",
            "Bright violet",
            "Lavender",
            "Lilac",
            "Magenta",
            "Royal purple",
            "Alder",
            "Pastel violet",
            "Bright red",
            "Really red",
            "Hot pink",
            "Pink",
            "Carnation pink",
            "Light reddish violet",
            "Pastel orange",
            "Dark taupe",
            "Cork",
            "Olive",
            "Medium green",
            "Grime",
            "Sand green",
            "Sand blue",
            "Lime green",
            "Pastel green",
            "New Yeller",
            "Pastel yellow",
            "Really black",
            "Black",
            "Dark stone grey",
            "Medium stone grey",
            "Mid gray",
            "Light stone grey",
            "White",
            "Institutional white",
            "Dark taupe",
            "Brown",
            "Linen",
            "Nougat",
            "Light orange",
            "Dirt brown",
            "Reddish brown",
            "Cork",
            "Burlap",
            "Brick yellow",
            "Sand red",
            "Dusty Rose",
            "Medium red",
            "Pastel orange",
            "Carnation pink",
            "Sand blue",
            "Steel blue",
            "Pastel Blue",
            "Pastel violet",
            "Lilac",
            "Bright bluish green",
            "Shamrock",
            "Moss",
            "Medium green",
            "Br. yellowish orange",
            "Bright yellow",
            "Daisy orange",
            "Dark stone grey",
            "Mid gray",
            "Institutional white",
        ];

        $this->FullColors = [
            361 => [
                "brickColorId" => 361,
                "hexColor" => "#564236",
                "name" => "Dirt brown",
            ],
            192 => [
                "brickColorId" => 192,
                "hexColor" => "#694028",
                "name" => "Reddish brown",
            ],
            217 => [
                "brickColorId" => 217,
                "hexColor" => "#7C5C46",
                "name" => "Brown",
            ],
            153 => [
                "brickColorId" => 153,
                "hexColor" => "#957977",
                "name" => "Sand red",
            ],
            359 => [
                "brickColorId" => 359,
                "hexColor" => "#AF9483",
                "name" => "Linen",
            ],
            352 => [
                "brickColorId" => 352,
                "hexColor" => "#C7AC78",
                "name" => "Burlap",
            ],
            5 => [
                "brickColorId" => 5,
                "hexColor" => "#D7C59A",
                "name" => "Brick yellow",
            ],
            101 => [
                "brickColorId" => 101,
                "hexColor" => "#DA867A",
                "name" => "Medium red",
            ],
            1007 => [
                "brickColorId" => 1007,
                "hexColor" => "#A34B4B",
                "name" => "Dusty Rose",
            ],
            1014 => [
                "brickColorId" => 1014,
                "hexColor" => "#AA5500",
                "name" => "CGA brown",
            ],
            38 => [
                "brickColorId" => 38,
                "hexColor" => "#A05F35",
                "name" => "Dark orange",
            ],
            18 => [
                "brickColorId" => 18,
                "hexColor" => "#CC8E69",
                "name" => "Nougat",
            ],
            125 => [
                "brickColorId" => 125,
                "hexColor" => "#EAB892",
                "name" => "Light orange",
            ],
            1030 => [
                "brickColorId" => 1030,
                "hexColor" => "#FFCC99",
                "name" => "Pastel brown",
            ],
            133 => [
                "brickColorId" => 133,
                "hexColor" => "#D5733D",
                "name" => "Neon orange",
            ],
            106 => [
                "brickColorId" => 106,
                "hexColor" => "#DA8541",
                "name" => "Bright orange",
            ],
            105 => [
                "brickColorId" => 105,
                "hexColor" => "#E29B40",
                "name" => "Br. yellowish orange",
            ],
            1017 => [
                "brickColorId" => 1017,
                "hexColor" => "#FFAF00",
                "name" => "Deep orange",
            ],
            24 => [
                "brickColorId" => 24,
                "hexColor" => "#F5CD30",
                "name" => "Bright yellow",
            ],
            334 => [
                "brickColorId" => 334,
                "hexColor" => "#F8D96D",
                "name" => "Daisy orange",
            ],
            226 => [
                "brickColorId" => 226,
                "hexColor" => "#FDEA8D",
                "name" => "Cool yellow",
            ],
            141 => [
                "brickColorId" => 141,
                "hexColor" => "#27462D",
                "name" => "Earth green",
            ],
            1021 => [
                "brickColorId" => 1021,
                "hexColor" => "#3A7D15",
                "name" => "Camo",
            ],
            28 => [
                "brickColorId" => 28,
                "hexColor" => "#287F47",
                "name" => "Dark green",
            ],
            37 => [
                "brickColorId" => 37,
                "hexColor" => "#4B974B",
                "name" => "Bright green",
            ],
            310 => [
                "brickColorId" => 310,
                "hexColor" => "#5B9A4C",
                "name" => "Shamrock",
            ],
            317 => [
                "brickColorId" => 317,
                "hexColor" => "#7C9C6B",
                "name" => "Moss",
            ],
            119 => [
                "brickColorId" => 119,
                "hexColor" => "#A4BD47",
                "name" => "Br. yellowish green",
            ],
            1011 => [
                "brickColorId" => 1011,
                "hexColor" => "#002060",
                "name" => "Navy blue",
            ],
            1012 => [
                "brickColorId" => 1012,
                "hexColor" => "#2154B9",
                "name" => "Deep blue",
            ],
            1010 => [
                "brickColorId" => 1010,
                "hexColor" => "#0000FF",
                "name" => "Really blue",
            ],
            23 => [
                "brickColorId" => 23,
                "hexColor" => "#0D69AC",
                "name" => "Bright blue",
            ],
            305 => [
                "brickColorId" => 305,
                "hexColor" => "#527CAE",
                "name" => "Steel blue",
            ],
            102 => [
                "brickColorId" => 102,
                "hexColor" => "#6E99CA",
                "name" => "Medium blue",
            ],
            45 => [
                "brickColorId" => 45,
                "hexColor" => "#B4D2E4",
                "name" => "Light blue",
            ],
            107 => [
                "brickColorId" => 107,
                "hexColor" => "#008F9C",
                "name" => "Bright bluish green",
            ],
            1018 => [
                "brickColorId" => 1018,
                "hexColor" => "#12EED4",
                "name" => "Teal",
            ],
            1027 => [
                "brickColorId" => 1027,
                "hexColor" => "#9FF3E9",
                "name" => "Pastel blue-green",
            ],
            1019 => [
                "brickColorId" => 1019,
                "hexColor" => "#00FFFF",
                "name" => "Toothpaste",
            ],
            1013 => [
                "brickColorId" => 1013,
                "hexColor" => "#04AFEC",
                "name" => "Cyan",
            ],
            11 => [
                "brickColorId" => 11,
                "hexColor" => "#80BBDC",
                "name" => "Pastel Blue",
            ],
            1024 => [
                "brickColorId" => 1024,
                "hexColor" => "#AFDDFF",
                "name" => "Pastel light blue",
            ],
            104 => [
                "brickColorId" => 104,
                "hexColor" => "#6B327C",
                "name" => "Bright violet",
            ],
            1023 => [
                "brickColorId" => 1023,
                "hexColor" => "#8C5B9F",
                "name" => "Lavender",
            ],
            321 => [
                "brickColorId" => 321,
                "hexColor" => "#A75E9B",
                "name" => "Lilac",
            ],
            1015 => [
                "brickColorId" => 1015,
                "hexColor" => "#AA00AA",
                "name" => "Magenta",
            ],
            1031 => [
                "brickColorId" => 1031,
                "hexColor" => "#6225D1",
                "name" => "Royal purple",
            ],
            1006 => [
                "brickColorId" => 1006,
                "hexColor" => "#B480FF",
                "name" => "Alder",
            ],
            1026 => [
                "brickColorId" => 1026,
                "hexColor" => "#B1A7FF",
                "name" => "Pastel violet",
            ],
            21 => [
                "brickColorId" => 21,
                "hexColor" => "#C4281C",
                "name" => "Bright red",
            ],
            1004 => [
                "brickColorId" => 1004,
                "hexColor" => "#FF0000",
                "name" => "Really red",
            ],
            1032 => [
                "brickColorId" => 1032,
                "hexColor" => "#FF00BF",
                "name" => "Hot pink",
            ],
            1016 => [
                "brickColorId" => 1016,
                "hexColor" => "#FF66CC",
                "name" => "Pink",
            ],
            330 => [
                "brickColorId" => 330,
                "hexColor" => "#FF98DC",
                "name" => "Carnation pink",
            ],
            9 => [
                "brickColorId" => 9,
                "hexColor" => "#E8BAC8",
                "name" => "Light reddish violet",
            ],
            1025 => [
                "brickColorId" => 1025,
                "hexColor" => "#FFC9C9",
                "name" => "Pastel orange",
            ],
            364 => [
                "brickColorId" => 364,
                "hexColor" => "#5A4C42",
                "name" => "Dark taupe",
            ],
            351 => [
                "brickColorId" => 351,
                "hexColor" => "#BC9B5D",
                "name" => "Cork",
            ],
            1008 => [
                "brickColorId" => 1008,
                "hexColor" => "#C1BE42",
                "name" => "Olive",
            ],
            29 => [
                "brickColorId" => 29,
                "hexColor" => "#A1C48C",
                "name" => "Medium green",
            ],
            1022 => [
                "brickColorId" => 1022,
                "hexColor" => "#7F8E64",
                "name" => "Grime",
            ],
            151 => [
                "brickColorId" => 151,
                "hexColor" => "#789082",
                "name" => "Sand green",
            ],
            135 => [
                "brickColorId" => 135,
                "hexColor" => "#74869D",
                "name" => "Sand blue",
            ],
            1020 => [
                "brickColorId" => 1020,
                "hexColor" => "#00FF00",
                "name" => "Lime green",
            ],
            1028 => [
                "brickColorId" => 1028,
                "hexColor" => "#CCFFCC",
                "name" => "Pastel green",
            ],
            1009 => [
                "brickColorId" => 1009,
                "hexColor" => "#FFFF00",
                "name" => "New Yeller",
            ],
            1029 => [
                "brickColorId" => 1029,
                "hexColor" => "#FFFFCC",
                "name" => "Pastel yellow",
            ],
            1003 => [
                "brickColorId" => 1003,
                "hexColor" => "#111111",
                "name" => "Really black",
            ],
            26 => [
                "brickColorId" => 26,
                "hexColor" => "#1B2A35",
                "name" => "Black",
            ],
            199 => [
                "brickColorId" => 199,
                "hexColor" => "#635F62",
                "name" => "Dark stone grey",
            ],
            194 => [
                "brickColorId" => 194,
                "hexColor" => "#A3A2A5",
                "name" => "Medium stone grey",
            ],
            1002 => [
                "brickColorId" => 1002,
                "hexColor" => "#CDCDCD",
                "name" => "Mid gray",
            ],
            208 => [
                "brickColorId" => 208,
                "hexColor" => "#E5E4DF",
                "name" => "Light stone grey",
            ],
            1 => [
                "brickColorId" => 1,
                "hexColor" => "#F2F3F3",
                "name" => "White",
            ],
            1001 => [
                "brickColorId" => 1001,
                "hexColor" => "#F8F8F8",
                "name" => "Institutional white",
            ],
            364 => [
                "brickColorId" => 364,
                "hexColor" => "#5A4C42",
                "name" => "Dark taupe",
            ],
            217 => [
                "brickColorId" => 217,
                "hexColor" => "#7C5C46",
                "name" => "Brown",
            ],
            359 => [
                "brickColorId" => 359,
                "hexColor" => "#AF9483",
                "name" => "Linen",
            ],
            18 => [
                "brickColorId" => 18,
                "hexColor" => "#CC8E69",
                "name" => "Nougat",
            ],
            125 => [
                "brickColorId" => 125,
                "hexColor" => "#EAB892",
                "name" => "Light orange",
            ],
            361 => [
                "brickColorId" => 361,
                "hexColor" => "#564236",
                "name" => "Dirt brown",
            ],
            192 => [
                "brickColorId" => 192,
                "hexColor" => "#694028",
                "name" => "Reddish brown",
            ],
            351 => [
                "brickColorId" => 351,
                "hexColor" => "#BC9B5D",
                "name" => "Cork",
            ],
            352 => [
                "brickColorId" => 352,
                "hexColor" => "#C7AC78",
                "name" => "Burlap",
            ],
            5 => [
                "brickColorId" => 5,
                "hexColor" => "#D7C59A",
                "name" => "Brick yellow",
            ],
            153 => [
                "brickColorId" => 153,
                "hexColor" => "#957977",
                "name" => "Sand red",
            ],
            1007 => [
                "brickColorId" => 1007,
                "hexColor" => "#A34B4B",
                "name" => "Dusty Rose",
            ],
            101 => [
                "brickColorId" => 101,
                "hexColor" => "#DA867A",
                "name" => "Medium red",
            ],
            1025 => [
                "brickColorId" => 1025,
                "hexColor" => "#FFC9C9",
                "name" => "Pastel orange",
            ],
            330 => [
                "brickColorId" => 330,
                "hexColor" => "#FF98DC",
                "name" => "Carnation pink",
            ],
            135 => [
                "brickColorId" => 135,
                "hexColor" => "#74869D",
                "name" => "Sand blue",
            ],
            305 => [
                "brickColorId" => 305,
                "hexColor" => "#527CAE",
                "name" => "Steel blue",
            ],
            11 => [
                "brickColorId" => 11,
                "hexColor" => "#80BBDC",
                "name" => "Pastel Blue",
            ],
            1026 => [
                "brickColorId" => 1026,
                "hexColor" => "#B1A7FF",
                "name" => "Pastel violet",
            ],
            321 => [
                "brickColorId" => 321,
                "hexColor" => "#A75E9B",
                "name" => "Lilac",
            ],
            107 => [
                "brickColorId" => 107,
                "hexColor" => "#008F9C",
                "name" => "Bright bluish green",
            ],
            310 => [
                "brickColorId" => 310,
                "hexColor" => "#5B9A4C",
                "name" => "Shamrock",
            ],
            317 => [
                "brickColorId" => 317,
                "hexColor" => "#7C9C6B",
                "name" => "Moss",
            ],
            29 => [
                "brickColorId" => 29,
                "hexColor" => "#A1C48C",
                "name" => "Medium green",
            ],
            105 => [
                "brickColorId" => 105,
                "hexColor" => "#E29B40",
                "name" => "Br. yellowish orange",
            ],
            24 => [
                "brickColorId" => 24,
                "hexColor" => "#F5CD30",
                "name" => "Bright yellow",
            ],
            334 => [
                "brickColorId" => 334,
                "hexColor" => "#F8D96D",
                "name" => "Daisy orange",
            ],
            199 => [
                "brickColorId" => 199,
                "hexColor" => "#635F62",
                "name" => "Dark stone grey",
            ],
            1002 => [
                "brickColorId" => 1002,
                "hexColor" => "#CDCDCD",
                "name" => "Mid gray",
            ],
            1001 => [
                "brickColorId" => 1001,
                "hexColor" => "#F8F8F8",
                "name" => "Institutional white",
            ],
        ];
    }

    protected function replicateConfig() {
        $Configuration = (object) [
            "Database" => (object) [
                "DatabaseHost"     => "mysql",
                "DatabaseName"     => "crapblox",
                "DatabaseUsername" => "root",
                "DatabasePassword" => "root",
            ],

            "RCCService" => (object) [
                "SOAPIP"       => "51.79.82.198",
                "SOAPPort"     => 64989,
            ],
        ];

        $this->Configuration = $Configuration;
    }

    protected function replicateTwig() {
        $Loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . '/Templates/');
        $Twig = new \Twig\Environment($Loader);
        $Twig->addExtension(new MarkdownExtension());

        $Twig->addRuntimeLoader(new class implements RuntimeLoaderInterface {
            public function load($class) {
                if (MarkdownRuntime::class === $class) {
                    return new MarkdownRuntime(new DefaultMarkdown());
                }
            }
        });

        $Filter = new \Twig\TwigFilter('timeago', function ($datetime) {
            $time = time() - strtotime($datetime);
            $units = array (
                31536000 => 'year',
                2592000 => 'month',
                604800 => 'week',
                86400 => 'day',
                3600 => 'hour',
                60 => 'minute',
                1 => 'second'
            );

            foreach ($units as $unit => $val) {
                if ($time < $unit) continue;
                $numberOfUnits = floor($time / $unit);
                return ($val == 'second')? 'a few seconds ago' :
                    (($numberOfUnits>1) ? $numberOfUnits : 'a')
                    .' '.$val.(($numberOfUnits>1) ? 's' : '').' ago';
            }
        });

        $Quotes = [
            "Sounds just like the Annoying Orange!",
            "Hey Apple!",
            "CRAPS MUST BLOCK",
            "TRILLIONS MUST INTERPRET",
            "BILLIONS MUST FRY",
            "BILLIONS MUST COMPLY",
            "Invest in Epstein's Island!",
            "Cobson 💎",
            "Jokes.net bill clinton jokes",
            "Im a schizophrenia posion cell atom",

            // NEW quotes (#quotes-submission-round-2)
            "LL4W on top",
            "LL4W is the best",
            "LL4W is awesome",
            "LL4W",
            "These three stars that starred my comments were retards",
            "\\",
            "hey google call jackd",
            "Mines don't suck tho 💯",
            "^ add all of those",
            "The worms🪱 are coming",
            " .. phpinfo() .. ",

            // starboard quotes
            "DANIEL GOES SUPER SAYAN 3:21",
            "Before and after using my own cleaner 👟🧼Link in bio 🔗📌",
            "https://cdn.discordapp.com/attachments/1061138976947318826/1083923975446470806/54077.png",
            "IM NOT A FUCKING SOYJACK",
            "Boooo 🍅 Get out of the stage",
        ];

        $Quote = $Quotes[array_rand($Quotes)];

        $Twig->addFilter($Filter);

        /*
         * Causes a memory leak too apparently... That's nice :)
         * For the user to see how much time they have left until next payout... this is ugly
        */

        /*
            if(isset($_SESSION['Roblox'])) {
                $User = new \Crapblox\Models\Auth\User();
                $User = $User->GetUserByUsername($_SESSION['Roblox']);

                $Twig->addGlobal('PayoutTime',         $User['roblox_dailyincome']);
            }
        */

        $Twig->addGlobal('Session',         $_SESSION);
        $Twig->addGlobal('Args',            @$_GET);
        $Twig->addGlobal('Quote',           $Quote);
        $Twig->addGlobal('TwoFactorImage',           $this->TwoFactorImage);
        $Twig->addGlobal('TwoFactorCode',           $this->TwoFactorCode);
        $Twig->addGlobal('CrapbloxRelease',           getenv("CRAPBLOX"));
        if(getenv("CRAPBLOX") === "development")
        {
            $Twig->addGlobal('SystemMessage',           "CRAPBLOX=development, This crapblox instance is in Development mode");
            $Twig->addGlobal('SystemMessageType',       "TypeError");   
        }
        if(null != getenv("SYSTEM_MESSAGE"))
        {
            $Twig->addGlobal('SystemMessage',           getenv("SYSTEM_MESSAGE"));
            $Twig->addGlobal('SystemMessageType',       getenv("SYSTEM_MESSAGE_TYPE"));    
        }

        $this->Twig = $Twig;
    }

    protected function replicateValidator() {
        $Validator = new Validator;
        $this->Validator = $Validator;
    }

    protected function replicate2FA() {
        $tfa = new \RobThree\Auth\TwoFactorAuth('Crapblox 2FA');
        $this->TwoFactorAuth = $tfa;
        $this->TwoFactorAuthSecret = $tfa->createSecret();
    }

    protected function replicateRCCSoap() {
        $this->RCCServiceSoap = new \Roblox\Grid\Rcc\RCCServiceSoap("51.79.82.198", 64989);
    }
}