<?php

use App\Support\Database\InsertMenu;
use Phinx\Migration\AbstractMigration;

class Oc21709 extends AbstractMigration
{
    use InsertMenu;

    public function up()
    {
        $descrMenuPrincipal = 'Manutenção de dados';
        $descricao = 'Ajuste Contas - Inclusão Exercício (Contabilidade)';

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
        $descrMenu = 'Ajusta Plano Orçamentário';
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

    public function getNextSeqMenuId($idPrincipalMenu): ?string
    {
        $sql = "SELECT max(menusequencia) + 1 AS codmenu FROM db_menu WHERE id_item = {$idPrincipalMenu}";
        $result = $this->fetchRow($sql);

        if ($result && isset($result['codmenu'])) {
            return (string) $result['codmenu'];
        }
        return null;
    }

}
