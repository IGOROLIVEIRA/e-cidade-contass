<?php

use App\Support\Database\InsertMenu;
use Phinx\Migration\AbstractMigration;

class Oc21943 extends AbstractMigration
{
    use InsertMenu;

    public function up()
    {
        $descrMenuPai = 'Conta Corrente';
        $helperMenuPai = 'Rotinas destinada a manutenção de conta corrente';
        $idModuloPai = 209; //Contabilidade
        $descrNovoMenu = 'Correção de Fonte C/C';
        $helperNovoMenu = 'Rotina de ajuste nas fontes de Conta Corrente';

        $this->criarMenuCorrecaoFonte($descrMenuPai, $helperMenuPai, $idModuloPai, $descrNovoMenu, $helperNovoMenu);
    }

    public function criarMenuCorrecaoFonte($descrMenuPai, $helperMenuPai, $idModuloPai, $descrMenu, $helperMenu)
    {
        $this->insertItemMenu($descrMenu, '', $helperMenu);

        $this->insertMenu($descrMenuPai, null, $idModuloPai, $helperMenuPai);

        $this->criarMenuCorrecaoFonteInclusao($descrMenu, $helperMenu, $idModuloPai);
        $this->criarMenuCorrecaoFonteAlteracao($descrMenu, $helperMenu, $idModuloPai);
        $this->criarMenuCorrecaoFonteExclusao($descrMenu, $helperMenu, $idModuloPai);
    }

    public function criarMenuCorrecaoFonteInclusao($descrMenuPai, $helperMenuPai, $idModuloPai)
    {
        $descrNovoMenu = "Inclusão";
        $linkNovoMenu = "con1_ajustafonterecurso001.php";
        $helperNovoMenu = $descrMenuPai." - Inclusão";
        
        $this->insertItemMenu($descrNovoMenu, $linkNovoMenu, $helperNovoMenu);

        $this->insertMenu($descrMenuPai, null, $idModuloPai, $helperMenuPai);
    }

    public function criarMenuCorrecaoFonteAlteracao($descrMenuPai, $helperMenuPai, $idModuloPai)
    {
        $descrNovoMenu = "Alteração";
        $linkNovoMenu = "con1_ajustafonterecurso002.php";
        $helperNovoMenu = $descrMenuPai." - Alteração";
        
        $this->insertItemMenu($descrNovoMenu, $linkNovoMenu, $helperNovoMenu);

        $this->insertMenu($descrMenuPai, null, $idModuloPai, $helperMenuPai);
    }

    public function criarMenuCorrecaoFonteExclusao($descrMenuPai, $helperMenuPai, $idModuloPai)
    {
        $descrNovoMenu = "Exclusão";
        $linkNovoMenu = "con1_ajustafonterecurso003.php";
        $helperNovoMenu = $descrMenuPai." - Exclusão";
        
        $this->insertItemMenu($descrNovoMenu, $linkNovoMenu, $helperNovoMenu);

        $this->insertMenu($descrMenuPai, null, $idModuloPai, $helperMenuPai);
    }
}
