<?php

namespace Tamm\Core;

class Log {
    public static function info($message) {
        self::write("INFO", $message);
    }

    public static function error($message) {
        self::write("ERROR", $message);
    }

    private static function write($level, $message) {
        $logEntry = sprintf("[%s] %s: %s\n", date("Y-m-d H:i:s"), $level, $message);
        file_put_contents("log.txt", $logEntry, FILE_APPEND);
        // echo "Log file";
    }
}