<?php

use App\Support\Database\InsertMenu;
use Phinx\Migration\AbstractMigration;

class Oc21709 extends AbstractMigration
{
    use InsertMenu;

    public function up()
    {
        $descrMenuPrincipal = 'Manuten��o de dados';
        $descricao = 'Ajuste Contas - Inclus�o Exerc�cio (Contabilidade)';

        $this->subMenuPrincipal($descrMenuPrincipal, $descricao);
        $this->menuContasOrc($descricao);
        $this->menuContasPcasp($descricao);
    }

    public function subMenuPrincipal($descrMenuPai, $descrMenu): void
    {
        $this->insertItemMenu($descrMenu, '', $descrMenu);
        $menuSeq = intval($this->getNextSeqMenuId(32));

        $this->insertMenu($descrMenuPai, $menuSeq);
    }

    public function menuContasOrc($descrMenuPai)
    {
        $descrMenu = 'Ajusta Plano Or�ament�rio';
        $linkMenu = 'm4_ajustacontas_inclusaoexe_planoorc.php';

        $this->insertItemMenu($descrMenu, $linkMenu, $descrMenu);
        $this->insertMenu($descrMenuPai, 1);
    }
    public function menuContasPcasp($descrMenuPai)
    {
        $descrMenu = 'Ajusta Plano PCASP';
        $linkMenu = 'm4_ajustacontas_inclusaoexe_pcasp.php';

        $this->insertItemMenu($descrMenu, $linkMenu, $descrMenu);
        $this->insertMenu($descrMenuPai, 2);
    }

    public function getNextSeqMenuId($idPrincipalMenu): string
    {
        $sql = "SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = {$idPrincipalMenu}";
        return implode(" ", $this->fetchRow($sql));
    }
}
