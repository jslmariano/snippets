<?php

/**
 * This is useefull when you just wanted to see the raw sql queries with the
 * bindings being made by your migration scripts before you actually run the
 * migrations.
 *
 * Commands to run
 *
 * ``` php artisan migrate --pretend ```
 *
 *
 * The method is ecisting in this file
 *
 * FILE:
 * vendor\laravel\framework\src\Illuminate\Database\Migrations\Migrator.php
 */




/**
 * Pretend to run the migrations.
 *
 * @param  object  $migration
 * @param  string  $method
 * @return void
 */
protected function pretendToRun($migration, $method)
{
    foreach ($this->getQueries($migration, $method) as $query) {
        $name = get_class($migration);

        /**
         * QUERY MODIFY
         */
        foreach ($query['bindings'] as $key => $value) {
            $query['bindings'][$key] = "'" . $value . "'";
        }

        $sql_with_bindings = str_replace_array('?',
            $query['bindings'], $query['query']
        );
        /**
         * QUERY MODIFY
         */

        /**
         * Also change the loop variable from [$query['query']] to [$sql_with_bindings]
         *
         *                                    ||
         *                                    \/
         */
        $this->note("<info>{$name}:</info> {$sql_with_bindings}");
    }
}