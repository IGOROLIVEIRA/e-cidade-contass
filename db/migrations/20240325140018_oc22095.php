<?php

use App\Support\Database\InsertMenu;
use Phinx\Migration\AbstractMigration;

class Oc22095 extends AbstractMigration
{
    use InsertMenu;

    public function up()
    {
        $descrMenuPai = 'Relatórios de Acompanhamento';
        $idModuloPai = 209; //Contabilidade
        $descrNovoMenu = 'Despesa Ensino (Anexo III)';
        $helperNovoMenu = 'Anexo 3 do relatorio de despesa de ensino';
        $arquivoMenu = 'con2_anexo2despesaensino001_novo.php';

        $this->atualizaMenuAntigo();
        $this->criaMenuNovo($descrMenuPai, $idModuloPai, $descrNovoMenu, $arquivoMenu, $helperNovoMenu);
    }

    public function atualizaMenuAntigo()
    {
        $sql = "UPDATE
                db_itensmenu
                SET descricao = 'Despesa Ensino (Anexo III)(2022)',
                help = 'Anexo 3 do relatorio de despesa de ensino (2022)'
                WHERE descricao = 'Despesa Ensino (Anexo III)';";

        $this->execute($sql);
    }

    public function criaMenuNovo($descrMenuPai, $idModuloPai, $descrMenu, $arquivoMenu, $helperMenu){
        $this->insertItemMenu($descrMenu, $arquivoMenu, $helperMenu);

        $this->insertMenu($descrMenuPai, null, $idModuloPai);

    }
}
