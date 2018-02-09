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
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {  // to keep the @ operator working
            throw new ErrorException($message, 0, $level, $file, $line);
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
    	$exception = [
    		'class' => get_class($exception),
    		'message' => $exception->getMessage(),
    		'trace' => explode('#',$exception->getTraceAsString()),
    		'throw' => $exception->getFile(),
    		'line' => $exception->getLine()
    	];

    	if (isset($exception)) {
    		extract($exception);
    		include 'Resource/error-render-page.php';	
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
    	$log = dirname(__DIR__) . '/../../../../logs/' . date('Y-m-d') . '.txt';

    	ini_set('error_log', $log);

    	$message = "Uncaught exception: '" . get_class($exception) . "'";
    	$message .= " with message '" . $exception->getMessage() . "'";
    	$message .= "\nStack trace: " . $exception->getTraceAsString();
    	$message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

    	error_log($message);
    }
}