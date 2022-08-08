<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

require_once("classes/db_arquivoretorno_classe.php");
require_once("classes/db_arquivoretornodados_classe.php");

/**
 * Arquivo Retorno eSocial
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class ArquivoRetorno {

    /**
     * @var Array
     */
    protected $aColumns = array(0 => 'CPF',1 => 'NIS',2 => 'NOME',3 => 'DN',4 => 'COD_NIS_INV',5 => 'COD_CPF_INV',6 => 'COD_NOME_INV',7 => 'COD_DN_INV',8 => 'COD_CNIS_NIS',9 => 'COD_CNIS_DN',10 => 'COD_CNIS_OBITO',11 => 'COD_CNIS_CPF',12 => 'COD_CNIS_CPF_NAO_INF',13 => 'COD_CPF_NAO_CONSTA',14 => 'COD_CPF_NULO',15 => 'COD_CPF_CANCELADO',16 => 'COD_CPF_SUSPENSO',17 => 'COD_CPF_DN',18 => 'COD_CPF_NOME',19 => 'COD_ORIENTACAO_CPF',20 => 'COD_ORIENTACAO_NIS');

    /**
    * @var Integer
    */
    const COLUMN_COD_CPF_NOME = 18;

   /**
    * @var String
    */
    protected $sFile = '';

   /**
    * @var String
    */
    protected $file;

    /**
    * @var Object
    */
    protected $oMessages;

    public function __construct($sFile)
    {
        $this->sFile = $sFile;
        $this->oMessages = $this->getMessagesObject();
    }

    /**
     * import datas from csv file
     * 
     * @return array
     */
    public function import() 
    {
        try {
            db_inicio_transacao();

            $clarquivoretorno = new cl_arquivoretorno();
            $clarquivoretorno->rh216_arquivo = $this->sFile;
            $clarquivoretorno->rh216_dataimportacao = date('Y-m-d H:m:s');
            $clarquivoretorno->rh216_instit = db_getsession("DB_instit");
            $clarquivoretorno->incluir();
            if ($clarquivoretorno->erro_status == "0") {
                throw new Exception($clarquivoretorno->erro_msg);
            }

            $clarquivoretornodados = new cl_arquivoretornodados();
            $this->openFile();
            while (($csvData = fgetcsv($this->file, 1000, ";")) !== FALSE) {
                if (!is_numeric($csvData[0])) {
                    continue;
                }
                $aData = $this->prepareDatas($csvData, $clarquivoretorno->rh216_sequencial);
                $clarquivoretornodados->addInsertLine($aData);
                if ($clarquivoretornodados->erro_status == "0") {
                    throw new Exception($clarquivoretornodados->erro_msg);
                }
            }
            if (count($clarquivoretornodados->aSqlAddInserts) > 0) {
                $clarquivoretornodados->addInsertLine(array(), true);
            }
            $this->closeFile();
            db_fim_transacao(false);
        } catch (Exception $eException) {
            db_fim_transacao(true);
            throw new Exception($eException->getMessage());
        }
    }

    /**
     * Prepare datas to be added according to csv and possible messages
     * 
     * @param array
     * @param Integer
     * 
     * @return array
     */
    private function prepareDatas($csvData, $iCodControle)
    {
        $aData = array();
        $aData = $csvData;
        $aData[] = $iCodControle;
        $aMessages = array();

        /**
         * starting with the columns related to the errors messages
         * 4 is the first column with error code
         * 21 is the last column with the error code
         */
        for ($iCont = 4; $iCont < 21; $iCont++) {
            if ($csvData[$iCont] != 0) {
                $sColumnName = $this->aColumns[$iCont];
                if ($iCont == self::COLUMN_COD_CPF_NOME && $csvData[$iCont] != '0') {
                    $aMessageIndex = explode("-", $csvData[$iCont]);
                    $aData[$iCont] = trim($aMessageIndex[0]);
                    $aMessages[] = str_replace("CAMPO_NOME", trim($aMessageIndex[1]), utf8_decode($this->oMessages->{$sColumnName}[trim($aMessageIndex[0])]));
                    continue;
                }
                $aMessages[] = utf8_decode($this->oMessages->{$sColumnName}[$csvData[$iCont]]);
            }
        }
        if (count($aMessages) > 0) {
            $sMessages = implode('","', $aMessages);
            $aData[] = '\'{"'.$sMessages.'"}\'';
        } else {
            $aData[] = 'NULL';
        }
        return $aData;
    }

    protected function openFile()
    {
        if (file_exists(__DIR__ . "/../../tmp/{$this->sFile}")) {
            throw new Exception("Arquivo não encontrado.");
        }
        $this->file = fopen("tmp/{$this->sFile}","r");
    }

    /**
     * @param string or array $line
     */
    protected function openLine($line)
    {
        if (is_array($line)) {
            foreach ($line as $value) {
                fputs($this->file,$value."\r\n");
            }
        } else {
            fputs($this->file,$line."\r\n");
        }
    }
    
    protected function closeFile()
    {
        fclose($this->file);
    }

    public function excluir($sDataImportacao)
    {
        try {
            db_inicio_transacao();
            $clarquivoretorno = new cl_arquivoretorno();
            $clarquivoretornodados = new cl_arquivoretornodados();
            $clarquivoretornodados->excluir(null, "rh217_arquivoretorno in (select rh216_sequencial from arquivoretorno where rh216_dataimportacao = '{$sDataImportacao}')");
            if ($clarquivoretornodados->erro_status == "0") {
                throw new Exception($clarquivoretornodados->erro_msg);
            }
            $clarquivoretorno->excluir(null, "rh216_dataimportacao = '{$sDataImportacao}'");
            if ($clarquivoretorno->erro_status == "0") {
                throw new Exception($clarquivoretorno->erro_msg);
            }
            db_fim_transacao(false);
        } catch (Exception $eException) {
            db_fim_transacao(true);
            throw new Exception($eException->getMessage());
        }
    }

    /**
     * Return a Object from a json of possible messages
     * 
     * @return Object
     */
    protected function getMessagesObject()
    {
        return json_decode(utf8_encode('{
            "COD_NIS_INV": [
                "Os dados estão corretos",
                "NIS inválido"
            ],
            "COD_CPF_INV": [
                "Os dados estão corretos",
                "CPF inválido"
            ],
            "COD_NOME_INV": [
                "Os dados estão corretos",
                "NOME inválido"
            ],
            "COD_DN_INV": [
                "Os dados estão corretos",
                "DN inválido"
            ],
            "COD_CNIS_NIS": [
                "Os dados estão corretos",
                "NIS inconsistente"
            ],
            "COD_CNIS_DN": [
                "Os dados estão corretos",
                "Data de nascimento informada diverge da existente no CNIS"
            ],
            "COD_CNIS_OBITO": [
                "Os dados estão corretos",
                "NIS com óbito no CNIS"
            ],
            "COD_CNIS_CPF": [
                "Os dados estão corretos",
                "CPF informado diverge do existente no CNIS"
            ],
            "COD_CNIS_CPF_NAO_INF": [
                "Os dados estão corretos",
                "CPF não preenchido no CNIS"
            ],
            "COD_CPF_NAO_CONSTA": [
                "Os dados estão corretos",
                "CPF informado não consta no Cadastro do CPF"
            ],
            "COD_CPF_NULO": [
                "Os dados estão corretos",
                "CPF informado NULO no Cadastro do CPF"
            ],
            "COD_CPF_CANCELADO": [
                "Os dados estão corretos",
                "CPF informado CANCELADO no Cadastro do CPF"
            ],
            "COD_CPF_SUSPENSO": [
                "Os dados estão corretos",
                "CPF informado SUSPENSO no Cadastro do CPF"
            ],
            "COD_CPF_DN": [
                "Os dados estão corretos",
                "Data de nascimento informada diverge da existente no Cadastro do CPF"
            ],
            "COD_CPF_NOME": [
                "Os dados estão corretos",
                "Nome Informado diverge do existente no Cadastro do CPF - CAMPO_NOME"
            ],
            "COD_ORIENTACAO_CPF": [
                "Os dados estão corretos",
                "Procurar Conveniadas da RFB"
            ],
            "COD_ORIENTACAO_NIS": [
                "Os dados estão corretos",
                "Atualizar NIS no INSS",
                "Verifique os dados digitados. Se estiverem corretos, antes de realizar a atualização cadastral do PIS ou PASEP, é necessário verificar o vínculo empregatício atual: Se Vinculado à empresa privada, a atualização cadastral deve ser solicitada na CAIXA; se vinculado a órgão público, a atualização deve ser solicitada no Banco do Brasil"
            ]
        }'));
    }

}