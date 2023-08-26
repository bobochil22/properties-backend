<?php

namespace App\Helpers;

class SoundexHelper
{
    static function dmword($string)
    {
        return soundex($string);
    }

    static function dmstring($string)
    {

        $string = preg_replace(array('#[^\w\s]|\d#i', '#\b[^\s]{1,3}\b#i', '#\s{2,}#i', '#^\s+|\s+$#i'),
            array('', '', ' '), strtoupper($string));

        if (!isset($string[0]))
            return null;

        $matches = explode(' ', $string);
        foreach($matches as $key => $match)
            $matches[$key] = self::dmword($match);
        return $matches;
    }

    static function getSound($string){
        $arr = self::dmstring($string);

        if (is_array($arr) && count($arr)){
            return implode(' ', $arr);
        }

        return '';
    }
}