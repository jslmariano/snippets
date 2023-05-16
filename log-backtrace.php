<?php

function logStackTrace() {
    $backtrace = debug_backtrace();
    foreach ($backtrace as $trace) {
        $file = isset($trace['file']) ? $trace['file'] : 'unknown file';
        $line = isset($trace['line']) ? $trace['line'] : 'unknown line';
        $function = isset($trace['function']) ? $trace['function'] : 'unknown function';
        $caller = "$file:$line - $function";
        error_log($caller);
    }
}

?>
