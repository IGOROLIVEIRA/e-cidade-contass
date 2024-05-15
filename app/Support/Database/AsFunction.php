<?php

namespace App\Support\Database;

trait AsFunction
{
    /**
     * $this->createView('public.fc_calcula', '2022-09-15');
     * @param $function
     * @param $version
     * @return void
     */
    public function createFunction($function, $version = null)
    {
        if ($version) {
            $function = "{$function}-{$version}";
        }

        $this->execute(
            file_get_contents(__DIR__ . "/../../../db/migrations/sqls/functions/{$function}.sql")
        );
    }

    public function dropFunction($function)
    {
        $this->execute(
            "DROP VIEW IF EXISTS {$function};"
        );
    }
}
