<?php

/**
 * This avoids developer to forgot where they put the die dump within the entire
 * codes as it will autmatically creates an auto marker from where the die dump
 * has been executed
 *
 * PACKAGE symfony/var-dumper
 *
 * But you need to update your code in
 * - vendor\symfony\var-dumper\Resources\functions\dump.php
 *
 * and then update the DD method then include the marker
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\VarDumper\VarDumper;

if (!function_exists('dump')) {
    /**
     * @author Nicolas Grekas <p@tchwork.com>
     */
    function dump($var, ...$moreVars)
    {
        VarDumper::dump($var);

        foreach ($moreVars as $v) {
            VarDumper::dump($v);
        }

        if (1 < func_num_args()) {
            return func_get_args();
        }

        return $var;
    }
}

if (!function_exists('dd')) {
    function dd(...$vars)
    {
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Access-Control-Allow-Credentials: true");

        /**
         * AUTOMATIC MARKER
         */
        $args               = array();
        $call               = debug_backtrace();
        $call               = $call[0];
        $root               = realpath($_SERVER['DOCUMENT_ROOT']);
        $call['short_path'] = str_replace($root, "", $call['file']);
        $mark_title         = ("MARKED | " . $call['short_path'] . " :: " . $call['line']);
        $args[]             = $mark_title;
        $args = array_merge($args, $vars);
        /**
         * AUTOMATIC MARKER
         */

        /**
         * Also change the loop variable from [$vars] to [$args]
         *
         *        ||
         *        \/
         */

        try {

            foreach ($args as $v) {
                VarDumper::dump($v);
            }
        } catch (\Throwable $e) {
            var_dump($e);
        }

        exit(1);
    }
}
