<?php

/* Class name: Logger 
 * Author: Rational.Li
 * Create Date: 2013-07-12
 * Function: This class is only for log record.
 */
class Logger {
 /*
     * This function is only for ajax to record the logic.
     *
     * @param string $filePath
     * @param string $functionName
     * @param array $_REQUEST
     * @param string $response
     */
    static function logic_logging($value) {
    	
    	$file = 'c:\\pisserver_logic_log.txt';

		$NOW_TIME = date("Y-m-d H:i:s");
		$efp = fopen ($file, "a");
		fwrite($efp, "[$NOW_TIME] [logic] Response: $value \n");
		fclose($efp);
	}
}
?>