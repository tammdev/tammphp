<?php

namespace Tamm\Framework\Debug;

use Tamm\Framework\Skeleton\Debug\IDebug;

class Debug implements IDebug
{
    public static function show()
    {
        
    }
    static protected $reporting = E_ALL;
	static public    function reporting( $reporting = null ) {
		if ( ! func_num_args() )
			return self::$reporting;
		self::$reporting = $reporting;
	}
	static public    function log () {
    $args = func_get_args();
		self::$reporting && 
			print( 
				self::style() . PHP_EOL . '<pre class="debug log">'
				. implode( 
					'</pre>' . PHP_EOL . '<pre class="log">' 
					, array_map( 'Debug::var_export', $args )
				)
				. '</pre>'
			);
	}
	public static function dump() {
    $args = func_get_args();
		self::$reporting && 
			die( call_user_func_array( 'Debug::log', $args ) );
	}
	static private   $time;
	static private   $chrono;
	static public    function chrono ( $print = null, $scope = '' ) {
		if ( ! self::$reporting )
			return;
		if ( ! isset( self::$time[ $scope ] ) )
			$chrono [] = '<b class="init">' . $scope . ' chrono init</b>';
		elseif ( is_string( $print ) ) {
			$chrono[] = sprintf('<span class="time">%s -> %s: %fs</span>'
				, $scope
				, $print
				, round( self::$chrono[ $scope ][ $print ] = microtime( true ) - self::$time[ $scope ], 6 )
			);
		} elseif ( $print && isset( self::$chrono[ $scope ] ) ) {
			asort( self::$chrono[ $scope ] );
			$base = reset ( self::$chrono[ $scope ] ); // shortest duration
			foreach( self::$chrono[ $scope ] as $event => $duration )
				$table[] = sprintf( '%5u - %-38.38s <i>%7fs</i>'
					, round( $duration / $base, 2 )
					, $event
					, round( $duration, 3 )
				);
			$chrono[] = '<div class="table"><b>' . $scope . ' chrono table</b>' . PHP_EOL .
				sprintf( '%\'-61s %-46s<i>duration</i>%1$s%1$\'-61s'
					, PHP_EOL
					, 'unit - action'
				) . 
				implode( PHP_EOL, $table ) . PHP_EOL . 
				'</div>';
		}
		echo self::style(), PHP_EOL, '<pre class="debug chrono">', implode( PHP_EOL, $chrono ), '</pre>';
		return self::$time[ $scope ] = microtime( true );
	}
	static private   $registered;
	static public    function register ( $init = true ) {
		if ( $init) {
			if ( ! self::$registered )
				self::$registered = array(
					'display_errors'    => ini_get( 'display_errors' )
          , 'error_reporting' => error_reporting()
					, 'shutdown'        => register_shutdown_function( 'Debug::shutdown' )
				);
			self::$registered[ 'shutdown' ] = true;
			error_reporting( E_ALL );
			set_error_handler( 'Debug::handler', E_ALL );
			set_exception_handler( 'Debug::exception' );
			ini_set( 'display_errors', 0 );
		} elseif ( self::$registered ) {
			self::$registered[ 'shutdown' ] = false;
			error_reporting( self::$registered[ 'error_reporting' ] );
			restore_error_handler();
			restore_exception_handler();
			ini_set( 'display_errors', self::$registered[ 'display_errors' ] );
		}
	}


	static protected $error     = array(
		-1                    => 'Exception'
		, E_ERROR             => 'Fatal'
		, E_RECOVERABLE_ERROR => 'Recoverable'
		, E_WARNING           => 'Warning'
		, E_PARSE             => 'Parse'
		, E_NOTICE            => 'Notice'
		, E_STRICT            => 'Strict'
		, E_DEPRECATED        => 'Deprecated'
		, E_CORE_ERROR        => 'Fatal'
		, E_CORE_WARNING      => 'Warning'
		, E_COMPILE_ERROR     => 'Compile Fatal'
		, E_COMPILE_WARNING   => 'Compile Warning'
		, E_USER_ERROR        => 'Fatal'
		, E_USER_WARNING      => 'Warning'
		, E_USER_NOTICE       => 'Notice'
		, E_USER_DEPRECATED   => 'Deprecated'
	);
	static public    function handler ( $type, $message, $file, $line, $scope, $stack = null ) {
		global $php_errormsg; // set global error message regardless track errors settings
		$php_errormsg = preg_replace( '~^.*</a>\]: +(?:\([^\)]+\): +)?~', array(), $message ); // clean useless infos
		if ( ! self::$reporting ) // de-activate
			return false;
		$stack = $stack ? $stack : array_slice( debug_backtrace( false ),  $type & E_USER_ERROR | E_USER_WARNING | E_USER_NOTICE ?  2 : 1 ); // clean stack depending if error is user triggered or not
		self::overload( $stack, $file, $line  ); // switch line & file if overloaded method triggered the error
		echo self::style(), PHP_EOL, '<pre class="debug error ', strtolower( self::$error[ $type ] ), '">', PHP_EOL, 
			sprintf( '<b>%s</b>: %s in <b>%s</b> on line <b>%s</b>'  // print error
				, self::$error[ $type ] ? self::$error[ $type ] : 'Error'
				, $php_errormsg
				, $file
				, $line
			);
		if ( $type & self::$reporting ) // print context
			echo self::context( $stack, $scope );
		echo '</pre>';
		if ( $type & E_USER_ERROR ) // fatal
			exit;
	}
	static public    function shutdown () {
		if ( self::$registered[ 'shutdown' ] && ( $error = error_get_last() ) && ( $error[ 'type' ] & ( E_ERROR |  E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR ) ) )
			self::handler( $error[ 'type' ], $error[ 'message' ], $error[ 'file' ], $error[ 'line' ], null );
	}
	static public    function exception ( \Exception $exception ) {
		$msg = sprintf( '"%s" with message "%s"', get_class( $exception ), $exception->getMessage() );
		self::handler( -1, $msg, $exception->getFile(), $exception->getLine(), null, $exception->getTrace() );
	}
	static public    $style     = array(
		'debug'         => 'font-size:1em;padding:.5em;border-radius:5px'
		, 'error'       => 'background:#eee'
		, 'exception'   => 'color:#825'
		, 'parse'       => 'color:#F07'
		, 'compile'     => 'color:#F70'
		, 'fatal'       => 'color:#F00'
		, 'recoverable' => 'color:#F22'
		, 'warning'     => 'color:#E44'
		, 'notice'      => 'color:#E66'
		, 'deprecated'  => 'color:#F88'
		, 'strict'      => 'color:#FAA'
		, 'stack'       => 'padding:.2em .8em;color:#444'
		, 'trace'       => 'border-left:1px solid #ccc;padding-left:1em'
		, 'scope'       => 'padding:.2em .8em;color:#666'
		, 'var'         => 'border-bottom:1px dashed #aaa;margin-top:-.5em;padding-bottom:.9em'
    , 'log'         => 'background:#f7f7f7;color:#33e'
		, 'chrono'      => 'border-left:2px solid #ccc'
		, 'init'        => 'color:#4A6'
		, 'time'        => 'color:#284'
		, 'table'       => 'color:#042'
	);
	static protected function style () {
		static $style;
		if ( $style )
			return;
		foreach ( self::$style as $class => $css )
			$style .= sprintf( '.%s{%s}', $class, $css );
		return PHP_EOL . '<style type="text/css">' . $style . '</style>';
	}
	static protected $overload  = array(
		'__callStatic'   => 2
		, '__call'       => 2
		, '__get'        => 1
		, '__set'        => 1
		, '__clone'      => 1
		, 'offsetGet'    => 1
		, 'offsetSet'    => 1
		, 'offsetUnset'  => 1
		, 'offsetExists' => 1
	);
	static protected function overload ( &$stack, &$file, &$line ) {
		if ( isset( $stack[ 0 ][ 'class' ], self::$overload[ $stack[ 0 ][ 'function' ] ] ) && $offset = self::$overload[ $stack[ 0 ][ 'function' ] ] )
			for ( $i = 0; $i < $offset; $i++ )
				extract( array_shift( $stack ) ); // clean stack and overwrite file & line
	}
	static protected function context ( $stack, $scope ) {
		if ( ! $stack )
				return;
		$context[] = PHP_EOL . '<div class="stack"><i>Stack trace</i> :';
		foreach ( $stack as $index => $call )
			$context[] = sprintf( '  <span class="trace">#%s %s: <b>%s%s%s</b>(%s)</span>'
				, $index
				, isset( $call[ 'file' ] )  ? $call[ 'file' ] . ' (' . $call[ 'line' ] . ')' : '[internal function]'
				, isset( $call[ 'class' ] ) ? $call[ 'class' ]                              : ''
				, isset( $call[ 'type' ] )  ? $call[ 'type' ]                               : ''
				, $call[ 'function' ]
				, isset( $call[ 'args' ] )  ? self::args_export( $call[ 'args' ] )          : ''
			);
		$context[] = '  <span class="trace">#' . ( $index + 1 ) . ' {main}</span>'; 
		$context[] = '</div><div class="scope"><i>Scope</i> :';
    $vars = '';
		if ( isset( $scope['GLOBALS'] ) )
			$vars = '  GLOBAL';
		elseif ( ! $scope )
			$vars = '  NONE';
		else
			foreach ( (array) $scope as $name => $value )
				$vars .= '  <div class="var">$' . $name .' = ' . self::var_export( $value ) . ';' . PHP_EOL . '</div>';
		$context[] = $vars . '</div>';
		return implode( PHP_EOL, $context );
	}
	static protected function var_export ( $var ) 
    {
    ob_start();
    var_dump( $var );
    $export = ob_get_clean();
    $export = preg_replace( '/\s*\bNULL\b/m', ' null', $export ); // Cleanup NULL
    $export = preg_replace( '/\s*\bbool\((true|false)\)/m', ' $1', $export ); // Cleanup booleans
    $export = preg_replace( '/\s*\bint\((\d+)\)/m', ' $1', $export ); // Cleanup integers
    $export = preg_replace( '/\s*\bfloat\(([\d.e-]+)\)/mi', ' $1', $export ); // Cleanup floats
    $export = preg_replace( '/\s*\bstring\(\d+\) /m', '', $export ); // Cleanup strings
    $export = preg_replace( '/object\((\w+)\)(#\d+) \(\d+\)/m', '$1$2', $export ); // Cleanup objects definition
    //@todo array cleaning
    $export = preg_replace( '/=>\s*/m', '=> ', $export ); // No new line between array/object keys and properties
    $export = preg_replace( '/\[([\w": ]+)\]/', ', $1 ', $export ); // remove square brackets in array/object keys
    $export = preg_replace( '/([{(]\s+), /', '$1  ', $export ); // remove first coma in array/object properties listing
    $export = preg_replace( '/\{\s+\}/m', '{}', $export );
    $export = preg_replace( '/\s+$/m', '', $export ); // Trim end spaces/new line
    return $export;
	}
	static protected function simple_export ( $var ) {
    $export = self::var_export( $var );
		if ( is_array( $var ) ) {
      $export  = preg_replace( '/\s+\d+ => /m', ', ', $export );
      $export  = preg_replace( '/\s+(["\w]+ => )/m', ', $1', $export );
      $pattern = '#array\(\d+\) \{[\s,]*([^{}]+|(?R))*?\s+\}#m';
      while ( preg_match( $pattern, $export ) )
        $export  = preg_replace( $pattern, 'array($1)', $export );
      return $export;
    }
		if ( is_object( $var ) )
			return substr( $export, 0, strpos( $export, '#' ) ); // strstr( $export, '#', true );
		return $export;
	}
	static protected function args_export ( $args ) {
		return implode(', ', array_map( 
			'Debug::simple_export', 
			(array) $args
		) );
	}
}
/*
Debug::register();
if ( ! function_exists( 'l' ) ) {
  function l () {
    $args = func_get_args();
    call_user_func_array( 'Debug::log', $args );
  }
}
if ( ! function_exists( 'd' ) ) {
  function d () {
    $args = func_get_args();
  	call_user_func_array( 'Debug::dump', $args );
  }
}
if ( ! function_exists( 'c' ) ) {
  function c () {
    $args = func_get_args();
  	call_user_func_array( 'Debug::chrono', $args );
  }
}
*/
class DebugX //implements IDebug
{

    /**
     * Render and display the structured information
     *
     * @param mixed $variable The variable to be displayed
     */
    public static function show($variable) {
        echo '<style>
            .debug-wrapper {
                background-color: #f5f5f5;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-family: monospace;
                cursor: pointer;
            }
            
            .debug-title {
                font-weight: bold;
                margin-bottom: 10px;
            }
            
            .debug-content {
                margin-left: 15px;
                display: none;
            }
        </style>';

        echo '<div class="debug-wrapper" onclick="toggledebug(this)">';
        echo '<div class="debug-title">debug Output</div>';
        echo '<div class="debug-content">';
        
        // Custom logic to format and display the variable
        $output = self::formatVariable($variable);
        echo $output;
        
        echo '</div>';
        echo '</div>';
        
        echo '<script>
            function toggledebug(element) {
                var content = element.querySelector(".debug-content");
                content.style.display = content.style.display === "none" ? "block" : "none";
            }
        </script>';
    }

    /**
     * Format the variable for display
     *
     * @param mixed $variable The variable to be formatted
     * @return string The formatted variable
     */
    protected static function formatVariable($variable) {
        if (is_array($variable) || is_object($variable)) {
            $output = '<ul>';
            foreach ($variable as $key => $value) {
                $output .= '<li><strong>' . $key . '</strong>: ' . self::formatVariable($value) . '</li>';
            }
            $output .= '</ul>';
        } else {
            $output = '<span>' . $variable . '</span>';
        }
        return $output;
    }

    // public static function show($variable)
    // {
    //     echo '<pre style="background-color: #f5f5f5; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-family: monospace;">';
    //     echo '<span style="color: #333; font-weight: bold;">' . gettype($variable) . '</span> ';
    //     echo '<span style="color: #777;">(' . count($variable) . ' elements)</span><br>';
    //     echo '<code>' . htmlentities(print_r($variable, true)) . '</code>';
    //     echo '</pre>';
    // }
    
    /*
    public static function showX($variable) {
        echo '<style>';
        echo '
            .debug-wrapper {
                position: relative;
                margin: 5px 0;
            }
            
            .debug-toggler {
                position: absolute;
                top: 0;
                left: 0;
                width: 20px;
                height: 20px;
                background-color: #ccc;
                cursor: pointer;
                transition: background-color 0.3s ease-in-out;
            }
            
            .debug-toggler::before {
                content: "+";
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: #fff;
                font-size: 14px;
            }
            
            .debug-toggler.debug-open {
                background-color: #888;
            }
            
            .debug-content {
                margin-left: 25px;
                background-color: #f5f5f5;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-family: monospace;
                transition: max-height 0.3s ease-in-out;
                max-height: 50vh;
                overflow: auto;
            }
            
            .debug-collapsed .debug-content {
                max-height: 0;
                padding: 0;
                border: none;
            }
            
            .debug-type {
                color: #333;
                font-weight: bold;
            }
            
            .debug-count {
                color: #777;
            }


            .debug-wrapper {
                background-color: #333;
                padding: 20px;
                border-radius: 5px;
                font-family: Arial, sans-serif;
            }
            
            .debug-title {
                font-weight: bold;
                color: white;
                margin-bottom: 10px;
            }
            
            .debug-content {
                margin-left: 15px;
            }
            
            .debug-file-line {
                color: #999;
                font-size: 12px;
                margin-top: 20px;
            }
        ';
        echo '</style>';


        echo '<div class="debug-wrapper">';
        echo '<div class="debug-toggler"></div>';
        echo '<pre class="debug-content">';
        echo '<span class="debug-type">' . gettype($variable) . '</span> ';
        echo '<span class="debug-count">' . self::getCount($variable) . '</span><br>';
        echo '<code>' . htmlentities(print_r($variable, true)) . '</code>';
        echo '</pre>';

        echo '<div class="debug-title">Backtrace</div>';
        echo '<div class="debug-content">';
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        foreach ($backtrace as $index => $trace) {
            if ($index === 0) {
                continue;
            }
            echo 'File: ' . $trace['file'] . ', Line: ' . $trace['line'] . '<br>';
            if (isset($trace['class'])) {
                echo 'Class: ' . $trace['class'] . '<br>';
            }
            echo 'Function: ' . $trace['function'] . '<br><br>';
        }
        echo '</div>';

        echo '<div class="debug-title">Included Files</div>';
        echo '<div class="debug-content">';
        $includedFiles = get_included_files();
        foreach ($includedFiles as $file) {
            echo $file . '<br>';
        }
        echo '</div>';

        echo '</div>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                var togglers = document.querySelectorAll(".debug-toggler");
                togglers.forEach(function(toggler) {
                    toggler.addEventListener("click", function() {
                        this.parentNode.classList.toggle("debug-collapsed");
                        this.classList.toggle("debug-open");
                    });
                });
            });

            function getCount(variable) {
                if (Array.isArray(variable)) {
                    return "(" + variable.length + " elements)";
                } else if (variable instanceof Object && variable.hasOwnProperty("count") && typeof variable.count === "function") {
                    return "(" + variable.count() + " elements)";
                } else {
                    return "";
                }
            }
        </script>';
    }

    private static function getCount($variable){
        if (is_array($variable)) {
            return '(' . count($variable) . ' elements)';
        } elseif (is_object($variable) && $variable instanceof \Countable) {
            return '(' . count($variable) . ' elements)';
        } else {
            return '';
        }
    }

    public static function showXX($variable) {
        echo '<style>
            .debug-wrapper {
                background-color: #f5f5f5;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-family: monospace;
                cursor: pointer;
            }
            
            .debug-title {
                font-weight: bold;
                margin-bottom: 10px;
            }
            
            .debug-content {
                margin-left: 15px;
                display: none;
            }
        </style>';

    echo '<div class="debug-wrapper" onclick="toggleDebug(this)">';

    echo '<pre class="debug-content">';
        echo '<span class="debug-type">' . gettype($variable) . '</span> ';
        echo '<span class="debug-count">' . self::getCount($variable) . '</span><br>';
        echo '<code>' . htmlentities(print_r($variable, true)) . '</code>';
        echo '</pre>';



    echo '<div class="debug-title">Debug Output</div>';
    echo '<div class="debug-content">';
    
    // Custom logic to format and display the variable
    $output = self::formatVariable($variable);
    echo $output;


    echo '<div class="debug-title">Included Files</div>';
        echo '<div class="debug-content">';
        $includedFiles = get_included_files();
        foreach ($includedFiles as $file) {
            echo $file . '<br>';
        }
        echo '</div>';
    
    echo '</div>';
    echo '</div>';
    
    echo '<script>
            function toggleDebug(element) {
                var content = element.querySelector(".debug-content");
                content.style.display = content.style.display === "none" ? "block" : "none";
            }
        </script><br><br>';
    }
    
    private static function formatVariable($variable) {
        if (is_array($variable) || is_object($variable)) {
            $output = '<ul>';
            foreach ($variable as $key => $value) {
                $output .= '<li><strong>' . $key . '</strong>: ' . self::formatVariable($value) . '</li>';
            }
            $output .= '</ul>';
        } else {
            $output = '<span>' . $variable . '</span>';
        }
        return $output;
    }
    */
}