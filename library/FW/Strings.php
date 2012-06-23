<?php
class FW_Strings {
    protected static $_iso = array(
        "Є"=>"YE","І"=>"I","Ѓ"=>"G","і"=>"i","№"=>"#","є"=>"ye","ѓ"=>"g",
        "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
        "Е"=>"E","Ё"=>"YO","Ж"=>"ZH",
        "З"=>"Z","И"=>"I","Й"=>"J","К"=>"K","Л"=>"L",
        "М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R",
        "С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"X",
        "Ц"=>"C","Ч"=>"CH","Ш"=>"SH","Щ"=>"SHH","Ъ"=>"'",
        "Ы"=>"Y","Ь"=>"","Э"=>"E","Ю"=>"YU","Я"=>"YA",
        "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
        "е"=>"e","ё"=>"yo","ж"=>"zh",
        "з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"x",
        "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
        "ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya","«"=>"","»"=>"","—"=>"-",
        " "=>"-","/"=>"-","\\"=>"-","*"=>"-",":"=>"-","%"=>"-","?"=>"",
    );

    public static function rusToLat($instr) {
        return strtr($instr, self::$_iso);
    }

    public static function formatPhoneArray($inarr) {
        $r = array();
        foreach ($inarr as $k => $in) {
            $r[$k] = self::formatPhone($in);
        }

        return $r;
    }

    public static function formatPhone($instr) {
        $filtered = preg_replace('/[^\+\d]/', '', $instr);

        $length = strlen($filtered);

        if (7 == $length) {
            $filtered = '057' . $filtered;
            $length += 3;
        }

        if ($length > 10 && $filtered[0] != '+') {
            $filtered = '+' . $filtered;
            $length += 1;
        }

        if ('+' == $filtered[0]) {
            $result = $filtered[0]
                    . substr($filtered, 1, $length-11)
                    . ' '
                    . '(' . substr($filtered, $length-10, 3) . ')'
                    . ' ' . substr($filtered, $length-7, 3)
                    . '-' . substr($filtered, $length-4, 2)
                    . '-' . substr($filtered, $length-2, 2);
        } else {
            if ($length > 6) {
                $result = '(' . substr($filtered, 0, $length - 7) . ')'
                        . ' ' . substr($filtered, $length-7, 3)
                        . '-' . substr($filtered, $length-4, 2)
                        . '-' . substr($filtered, $length-2, 2);
            } else {
                $result = strrev(implode('-', str_split(strrev($filtered), 2)));
            }
        }

        return str_replace(' ', '&nbsp;', $result);
    }

    public static function filterWhitespaces($str) {
        $result = trim($str, "\n \r\t");
        $result = preg_replace('/(\s+)/', ' ', $result);
        return $result;
    }

    public static function cropHighlights($input) {
        preg_match_all('|(?:(?>\pL)\S+[\s"]{0,5}){0,5}<b[^<]+?</b>(?:\s{0,5}[^\s<]+(?!\pL)){0,5}|iu', $input, $matches);
        if ($matches[0]) {
            $result = '&hellip; ' . implode(' &hellip; ', $matches[0]) . ' &hellip;';
        } else {
            $result = mb_substr($input, 0, 200, 'utf8').'&hellip;';
        }
        return $result;
    }

}