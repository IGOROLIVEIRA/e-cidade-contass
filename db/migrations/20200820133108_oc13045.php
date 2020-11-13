<?php

use Classes\PostgresMigration;

class Oc13045 extends PostgresMigration
{
    CONST PMPIRAPORA = '23539463000121';
    CONST PMLUISLANDIA = '01612887000131';
    CONST TIPO_NOTA_AVULSA_PIRAPORA = 61;
    CONST TIPO_NOTA_AVULSA_LUISLANDIA = 38;

    public function up()
    {
        $this->_addColumn();
        $this->_addDicionario();
        $this->_insertDefaultData();

    }

    private function _addColumn()
    {
        $this->table('parissqn', array('schema' => 'issqn'))
            ->addColumn('q60_tipo_notaavulsa', 'integer', array('null' => true))
            ->update();
    }

    private function _addDicionario()
    {
        $this->execute("INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'q60_tipo_notaavulsa', 'int(4)', 'Tipo Déb. Nota Avulsa', '0', 'Tipo Déb. Nota Avulsa', 11, false, false, false, 4, 'text', 'Tipo Déb. Nota Avulsa')");
        $this->execute("INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (664, (select codcam from configuracoes.db_syscampo where nomecam = 'q60_tipo_notaavulsa'), (select max(seqarq)+1 from db_sysarqcamp where codarq = 664), 0)");
    }

    public function down()
    {
        $this->table('parissqn', array('schema' => 'issqn'))
            ->removeColumn('q60_tipo_notaavulsa')
            ->update();

        $this->execute("delete from configuracoes.db_sysarqcamp where codcam = (select codcam from configuracoes.db_syscampo where nomecam = 'q60_tipo_notaavulsa')");
        $this->execute("delete from configuracoes.db_syscampo where nomecam = 'q60_tipo_notaavulsa'");
    }

    private function _insertDefaultData()
    {

        $this->execute("update issqn.parissqn set q60_tipo_notaavulsa = q60_tipo");
        $arrClients = array(
            array('cnpj' => self::PMPIRAPORA, 'tipo' => self::TIPO_NOTA_AVULSA_PIRAPORA),
            array('cnpj' => self::PMLUISLANDIA, 'tipo' => self::TIPO_NOTA_AVULSA_LUISLANDIA),
        );

        foreach ($arrClients as $client) {
            $arrInstit = $this->getInstituicaoByCnpj($client['cnpj']);
            if(!empty($arrInstit)){
                $this->execute("update issqn.parissqn set q60_tipo_notaavulsa = {$client['tipo']}");
            }
        }
    }

    /**
     * Verifica se existe uma instituição para o codcli
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
}
