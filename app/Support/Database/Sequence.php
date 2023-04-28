<?php

namespace App\Support\Database;

trait Sequence
{
    public function createSequence(string $sequenceName, string $schema = 'public'): void
    {
        $sqlSequence = "CREATE SEQUENCE {$schema}.{$sequenceName}
                        START WITH 1
                        INCREMENT BY 1
                        MINVALUE 0
                        NO MAXVALUE
                        CACHE 1";

        $this->execute($sqlSequence);
    }

    public function setAsAutoIncrement(string $tableName, string $columnName, string $sequenceName): void
    {
        $sql = "
        ALTER TABLE {$tableName}
        ALTER COLUMN {$columnName}
        SET DEFAULT nextval(('{$sequenceName}'::text)::regclass)
        ";

        $this->execute($sql);
    }

    public function dropSequence(string $sequenceName, string $schema = 'public'): void
    {
        $this->execute("drop sequence {$schema}.{$sequenceName}");
    }
}
