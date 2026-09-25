<?php
namespace Crapblox\Models;

class Color extends ModelBase {
    /* Variables passed by ViewBase... */
    /* $this->Connection => Database connection (PDO) */
    /* $this->Twig       => Templating engine         */

    public function color_getIdFromName($name, $BodyColor) {
        foreach ($BodyColor as $colorStruct) {
            if ($colorStruct["name"] == $name) return $colorStruct["brickColorId"];
        }
        return -1;
    }

    public function color_getNameFromID($id) {
        return $colorStruct[$id]["name"] ?? "Undefined color";
    }

    public function recursive_array_search($needle, $haystack, $currentKey = '') {
        foreach($haystack as $key=>$value) {
            if (is_array($value)) {
                $nextKey = recursive_array_search($needle,$value, $currentKey . '[' . $key . ']');
                if ($nextKey) {
                    return $nextKey;
                }
            }
            else if($value==$needle) {
                return is_numeric($key) ? $currentKey . '[' .$key . ']' : $currentKey . '["' .$key . '"]';
            }
        }
        return false;
    }

    public function recursiveFind(array $haystack, $needle)
    {
        $iterator  = new RecursiveArrayIterator($haystack);
        $recursive = new RecursiveIteratorIterator(
            $iterator,
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($recursive as $key => $value) {
            if ($key === $needle) {
                return $value;
            }
        }
    }
}