<?php 

namespace PHPO2\Exception;

use Exception;
use ErrorException;

/**
* 
* Stop Exception.
*
* This Exception is thrown when the application needs to abort
* processing and return control flow to the outer PHP script.
*
*/
class PHPO2Exception extends Exception
{
	/**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param int $level  Error level
     * @param string $message  Error message
     * @param string $file  Filename the error was raised in
     * @param int $line  Line number in the file
     *
     * @return void
     */
    public static function errorHandler()
    {
        if (error_reporting() !== 0) {

            ini_set('display_errors', 'Off');

            $error = debug_backtrace();

            unset($error[0]['args'][0]);
            
            self::responseCode(200);

            self::renderException(
                'fatal', 
                $error[0]['file'], 
                $error[0]['args'][1], 
                array_filter($error[0]['args']), 
                'ErrorException', $error[0]['line'], 
                null
            );
        }
    }

    /**
     * Exception handler.
     *
     * @param Exception $exception  The exception
     *
     * @return object
     */
    public static function exceptionHandler($exception)
    {
        self::responseCode($exception->getCode());

        self::renderException(
            null,
            get_class($exception), 
            $exception->getMessage(), 
            explode('#',$exception->getTraceAsString()), 
            $exception->getFile(), 
            $exception->getLine(), 
            $exception->getCode()
        );
    }

    /**
     *
     * Register and render all exception and error handler.
     *
     * @param Exception string $type
     * @param Exception string $class
     * @param Exception string $message
     * @param Exception array $trace
     * @param Exception string $throw
     * @param Exception integer $line
     * @param Exception integer $code
     * @return void
     */
    public static function renderException($type = null, $class, $message, $trace, $throw, $line, $code)
    {
        $exception = [
            'type'    => $type,
            'class'   => $class,
            'message' => $message,
            'trace'   => $trace,
            'throw'   => $throw,
            'line'    => $line,
            'code'    => $code
        ];

        self::render($exception);
    }

    /**
     * Exception debugger render.
     *
     * @param Exception $exception  The exception
     *
     * @return void
     */
    public static function render($exception)
    {
        if (isset($exception)) {
            extract($exception);
            require_once 'Resource/error-render-page.php';   
        }
    }

    /**
     * Exception logs.
     *
     * @param Exception $exception  The exception
     *
     * @return void
     */
    public static function log($exception)
    {
    	$log = dirname(__DIR__) . './../logs/' . date('Y-m-d') . '.txt';

    	ini_set('error_log', $log);

    	$message = "Uncaught exception: '" . get_class($exception) . "'";
    	$message .= " with message '" . $exception->getMessage() . "'";
    	$message .= "\nStack trace: " . $exception->getTraceAsString();
    	$message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

    	error_log($message);
    }

    /**
     *
     * Response HTTP status code.
     *
     * @param integer $code
     * @return void
     */
    public static function responseCode($code)
    {
        http_response_code($code);
    }
   
}