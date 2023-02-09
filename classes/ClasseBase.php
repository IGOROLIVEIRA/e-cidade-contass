<?php

namespace ECidadeLegacy\Classes;

class ClasseBase
{
    protected array $fields;

    protected string $tableName;

    protected function buildInsertSql(array $data): string
    {
        $values = [];
        $sql = "insert into {$this->tableName} (";
        $sql .= implode(',', array_keys($data));
        $sql .= ') values (';
        foreach ($data as $value) {
            $value[] = $value;
        }
        $sql .= implode(',', $values);
        return $sql;
    }

    protected function buildUpdateSql(int $key, array $data): string
    {
        $sql = "UPDATE {$this->tableName} SET ";
        $updateParts = [];

        foreach ($data as $field => $value) {
            $updateParts[] = " {$field} = $value ";
        }

        $sql .= implode(',', $updateParts);
        $sql .= ')';
        return $sql;
    }

    protected function insert(array $data): bool
    {
        $sql = $this->buildInsertSql($data);
        return (bool) pg_query($sql);
    }

    protected function update(int $key, array $data): bool
    {
        $sql = $this->buildUpdateSql($key, $data);
        return (bool) pg_query($sql);
    }

    protected function delete(array $data): bool
    {
        $sql = "DELETE FROM {$this->tableName} where ";
        $where = [];

        foreach ($data as $field => $value) {
            $where[] = " {$field} = $value ";
        }
        $sql .= implode('AND', $where);
        return (bool) pg_query($sql);
    }
}
