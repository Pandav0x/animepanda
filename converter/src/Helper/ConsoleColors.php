<?php

namespace App\Helper;

class ConsoleColors
{


    public const FOREGROUND = array(
        "BLACK" => "0;30",
        "DARKGREY" => "1;30",
        "RED" => "0;31",
        "LIGHTRED" => "1;31",
        "GREEN" => "0;32",
        "LIGHTGREEN" => "1;32",
        "BROWN" => "0;33",
        "YELLOW" => "1;33",
        "BLUE" => "0;34",
        "LIGHTBLUE" => "1;34",
        "MAGENTA" => "0;35",
        "LIGHTMAGENTA" => "1;35",
        "CYAN" => "0;36",
        "LIGHTCYAN" => "1;36",
        "LIGHTGREY" => "0;37",
        "WHITE" => "1;37"
    );

    public const BACKGROUND = array(
        "BLACK" => "40",
        "RED" => "41",
        "GREEN" => "42",
        "YELLOW" => "43",
        "BLUE" => "44",
        "MAGENTA" => "45",
        "CYAN" => "46",
        "LIGHTGREY" => "47"
    );

    public static function write($message, $foreground = self::FOREGROUND["WHITE"] , $background = self::BACKGROUND["BLACK"])
    {
        $start = "\e[".$foreground.";".$background."m";
        $end = "\e[0m";
        echo $start.$message.$end;
    }

}
