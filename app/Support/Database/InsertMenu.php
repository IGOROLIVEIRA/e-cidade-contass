<?php

namespace App\Support\Database;

trait InsertMenu
{
    public function getItemIdByDescr($descricao): array
    {
        $sql = "SELECT id_item FROM db_itensmenu WHERE descricao = '$descricao'";
        return $this->fetchRow($sql);
    }

    public function getLastInsertedId(): array
    {
        $sql = "SELECT max(id_item)+1 FROM db_itensmenu";
        return $this->fetchRow($sql);
    }

    public function getMaxMenuId(): array
    {
        $sql = "SELECT max(id_item) from db_itensmenu";
        return $this->fetchRow($sql);
    }

    public function insertItemMenu($descricao, $link, $titulo, $status = 't')
    {
        $id = intval(implode(" ", $this->getLastInsertedId()));

        $sql = "INSERT INTO db_itensmenu VALUES ($id, '$descricao', '$descricao', '$link', 1, 1, '$titulo', '$status')";
        $this->executeQuery($sql);
    }

    public function insertMenu($descricao, $menusequencia, $status = 1)
    {
        $id_item_pai = intval(implode(" ", $this->getItemIdByDescr($descricao)));
        $id_item_filho = intval(implode(" ", $this->getMaxMenuId()));

        $sql = "INSERT INTO db_menu VALUES ($id_item_pai, $id_item_filho, $menusequencia, $status)";
        $this->executeQuery($sql);
    }

    public function executeQuery($sql)
    {
        $this->execute($sql);
    }
}