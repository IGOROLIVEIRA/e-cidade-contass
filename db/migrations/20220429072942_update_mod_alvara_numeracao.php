<?php

use Phinx\Migration\AbstractMigration;

class UpdateModAlvaraNumeracao extends AbstractMigration
{
    const PMGRAOMOGOL = '20716627000150';
    const PMBURITIZEIRO = '18279067000172';
    const PMLAGOADOSPATOS = '16901381000110';
    const PMSERRANOPOLISDEMINAS = '01612501000191';
    const modeloAlvaraNumeracao = 99;
    const modeloAlvaraDefault = 2;

    public function up()
    {
        $this->updateModeloAlvara(self::modeloAlvaraNumeracao, self::modeloAlvaraDefault);
    }

    public function down()
    {
        $this->updateModeloAlvara(self::modeloAlvaraDefault, self::modeloAlvaraNumeracao);
    }

    /**
     * @param int $modeloNovo
     * @param int $modeloAntigo
     * @return void
     */
    private function updateModeloAlvara($modeloNovo, $modeloAntigo)
    {
        $clients  = $this->getClients();

        foreach ($clients as $client) {
            $instit = $this->getInstituicaoByCnpj($client);
            if(empty($instit) === false) {
                $this->execute("update parissqn set q60_modalvara = ".$modeloNovo." where q60_modalvara = ".$modeloAntigo);
            }
        }
    }

    /**
     * Verifica se existe uma instituicao para o codcli
     * @param string $cnpj
     * @return Array
     */
    public function getInstituicaoByCnpj($cnpj = NULL)
    {
        $arr = array();
        if($cnpj){
            $sSql = "select codigo from db_config where cgc = '{$cnpj}'";
            $arr = $this->fetchAll($sSql);
        }
        return $arr;
    }

    private function getClients()
    {
        return array(
            self::PMGRAOMOGOL,
            self::PMBURITIZEIRO,
            self::PMLAGOADOSPATOS,
            self::PMSERRANOPOLISDEMINAS,
        );
    }
}
