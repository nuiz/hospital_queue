<?php
/**
 * Created by PhpStorm.
 * User: MRG
 * Date: 11/25/14 AD
 * Time: 9:31 AM
 */
namespace Main\Helper;

class CheckLang {

    public static function isKanji($str) {
        return preg_match('/[\x{4E00}-\x{9FBF}]/u', $str) > 0;
    }

    public static function isHiragana($str) {
        return preg_match('/[\x{3040}-\x{309F}]/u', $str) > 0;
    }

    public static function isKatakana($str) {
        return preg_match('/[\x{30A0}-\x{30FF}]/u', $str) > 0;
    }

    public static function isJapanese($str) {
        return self::isKanji($str) || self::isHiragana($str) || self::isKatakana($str);
    }

}