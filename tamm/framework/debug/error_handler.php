<?php

namespace Tamm\Framework\Debug;

use Tamm\Application;

class ErrorHandler {

    public function __construct()
    {
        ini_set('display_errors', 1);
        $container = Application::getContainer();
        if((Application::getConfigurationValue("debug") !== null) && (Application::getConfigurationValue("debug") == true)){
            register_shutdown_function([__CLASS__, 'handelFatalError']);
            set_error_handler([__CLASS__, 'renderError']);
        }
    }

    public static function handelFatalError(){
        $last_error = error_get_last();
        if ($last_error && $last_error['type'] === E_ERROR) {
            $errorStr = substr($last_error['message'], 0, strpos($last_error['message'], " in ") ? strpos($last_error['message'], " in ") : null);
            // fatal error
            self::renderError(E_ERROR, $errorStr, $last_error['file'], $last_error['line']);
        }
    }

    public static function renderError($errno, $errstr, $errfile, $errline) {
        // This is our shutdown function, in 
        // here we can do any last operations
        // before the script is complete.
        echo "
            <br>
            <table style='border: .1rem solid #181818;' cellpadding='5' border='1' >
                <thead style='background-color:". ($errno === 1 ? "red" : "gold") . "; color: " . ($errno === 1 ? "#eee" : "#181818") . ";'>
                    <tr>
                        <th colspan='4'>
                            $errstr
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>number</th>
                        <th>string</th>
                        <th>file</th>
                        <th>line</th>
                    </tr>
                    <tr>
                        <td>$errno</td>
                        <td>$errstr</td>
                        <td>$errfile</td>
                        <td>$errline</td>
                    </tr>
                </tbody>
            </table> <br>
        ";
    }
}