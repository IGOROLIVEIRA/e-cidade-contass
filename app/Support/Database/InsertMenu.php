<?php

namespace App\Support\Database;

trait InsertMenu
{
    public function getItemIdByDescr($descricao, $helper = null): array
    {
        $sql = "SELECT id_item FROM db_itensmenu WHERE descricao = '$descricao'";
        if ($helper != null){
            $sql .= " AND help = '$helper'";
        }
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

    public function getNextSeqMenuId($idPrincipalMenu): ?string
    {
        $sql = "SELECT max(menusequencia) + 1 AS codmenu FROM db_menu WHERE id_item = {$idPrincipalMenu}";
        $result = $this->fetchRow($sql);

        if ($result && isset($result['codmenu'])) {
            return (string) $result['codmenu'];
        }
        return 0;
    }

    public function insertItemMenu($descricao, $link, $titulo, $status = 't')
    {
        $id = intval(implode(" ", $this->getLastInsertedId()));

        $sql = "INSERT INTO db_itensmenu VALUES ($id, '$descricao', '$titulo', '$link', 1, 1, '$titulo', '$status')";
        $this->executeQuery($sql);
    }

    public function insertMenu($descricaoItemPai, $menusequencia = null, $idModulo = 1, $helperItemPai = null)
    {
        $idItemPai = intval(implode(" ", $this->getItemIdByDescr($descricaoItemPai,$helperItemPai)));
        $idItemFilho = intval(implode(" ", $this->getMaxMenuId()));

        if ($menusequencia == null){
            $menusequencia = $this->getNextSeqMenuId($idItemPai);
        }

        $sql = "INSERT INTO db_menu VALUES ($idItemPai, $idItemFilho, $menusequencia, $idModulo)";
        $this->executeQuery($sql);
    }

    public function executeQuery($sql)
    {
        $this->execute($sql);
    }
}