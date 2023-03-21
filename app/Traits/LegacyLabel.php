<?php

namespace App\Traits;

trait LegacyLabel
{
    public \rotulo $legacyLabel;

    public function __construct()
    {
        $this->legacyLabel = new \rotulo($this->parseTableName());
    }

    protected function parseTableName(): string
    {
        $tableNameParts = explode('.', $this->table);
        if (count($tableNameParts) === 1) {
            return $tableNameParts[0];
        }
        return $tableNameParts[1];
    }
}
