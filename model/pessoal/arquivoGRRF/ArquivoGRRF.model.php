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

require_once("model/pessoal/arquivoGRRF/Registro00.model.php");
require_once("model/pessoal/arquivoGRRF/Registro10.model.php");
require_once("model/pessoal/arquivoGRRF/Registro40.model.php");
require_once("model/pessoal/arquivoGRRF/Registro90.model.php");

/**
 * Arquivo Guia de Recolhimento Rescisório do FGTS
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class ArquivoGRRF {

   /**
    * @var String
    */
    protected $sFile = '/tmp/GRRF.RE';

   /**
    * @var String
    */
    protected $file;

    public function __construct()
    {
        
    }

    /**
     * gerar dados para o arquivo
     * @param object $oDados
     */
    public function processar($oDados) 
    {
        try {
            $oDaoDbConfig = db_utils::getDao("db_config");
            $rsDBConfig   = $oDaoDbConfig->sql_record($oDaoDbConfig->sql_query_file(db_getsession("DB_instit")));
            $oConfig = db_utils::fieldsMemory($rsDBConfig, 0);

            $this->removerArquivo();
            $this->abreArquivo();

            $oRegistro00 = new Registro00($oDados, $oConfig);
            $this->adicionaLinha($oRegistro00->gerarRegistro());

            $oRegistro10 = new Registro10($oDados, $oConfig);
            $this->adicionaLinha($oRegistro10->gerarRegistro());

            $oRegistro40 = new Registro40($oDados, $oConfig);
            $this->adicionaLinha($oRegistro40->gerarRegistro());

            $oRegistro90 = new Registro90($oDados);
            $this->adicionaLinha($oRegistro90->gerarRegistro());

            $this->fechaArquivo();
            return $this->registraGeracao($oDados->iAnoUsu, $oDados->iMesUsu);
        } catch (Exception $eException) {
            throw new Exception($eException->getMessage());
        }
    }

    protected function abreArquivo()
    {
        $this->file = fopen($this->sFile,'w');
    }

    /**
     * @param string or array $line
     */
    protected function adicionaLinha($line)
    {
        if (is_array($line)) {
            foreach ($line as $value) {
                fputs($this->file,$value."\r\n");
            }
        } else {
            fputs($this->file,$line."\r\n");
        }
    }
    
    protected function fechaArquivo()
    {
        fclose($this->file);
    }


   /**
    *@return oid
    */
   private function registraGeracao($iAnoFolha, $iMesFolha) 
   {
        db_inicio_transacao();
        $oOidBanco = $this->gerarArquivoOid();
        $oDaoRHGRRF = db_utils::getDao("rhgrrf");

        $oDaoRHGRRF->rh168_anousu     = $iAnoFolha;
        $oDaoRHGRRF->rh168_mesusu     = $iMesFolha;
        $oDaoRHGRRF->rh168_arquivo    = $oOidBanco;
        $oDaoRHGRRF->rh168_datagera   = date('Y-m-d',db_getsession('DB_datausu'));
        $oDaoRHGRRF->rh168_horagera   = db_hora();
        $oDaoRHGRRF->rh168_id_usuario = db_getsession('DB_id_usuario');
        $oDaoRHGRRF->rh168_ativa      = 'true';
        $oDaoRHGRRF->rh168_instit     = db_getsession('DB_instit');
        $oDaoRHGRRF->incluir(null);

        if ( $oDaoRHGRRF->erro_status == 0 ) {
            throw new Exception($oDaoRHGRRF->erro_msg);
            db_fim_transacao(true); 
        }         
        db_fim_transacao();
        return $oOidBanco;
   }

   private function removerArquivo()
   {
       system('rm '.$this->sFile);
   }

   /**
    *@return oid
    */
   private function gerarArquivoOid()
   {
       global $conn;
       $rArquivo      = fopen($this->sFile, "rb");
       if ($rArquivo === false) {
           throw new Exception("Erro ao abrir aquivo para leitura.");
       }
       $rDadosArquivo = fread($rArquivo, filesize($this->sFile));
       if ($rDadosArquivo === false) {
           throw new Exception("Erro ao ler aquivo.");
       }
       fclose($rArquivo);

       $oOidBanco = pg_lo_create();
       if ($oOidBanco === false) {
           throw new Exception("Erro ao criar oOid do banco.");
       }

       $oObjetoBanco = pg_lo_open($conn, $oOidBanco, "w");
       if ($oObjetoBanco === false) {
           throw new Exception("Erro ao abrir arquivo do banco.");
       }
       $erro = pg_lo_write($oObjetoBanco, $rDadosArquivo);
       if ($erro === false) {
           throw new Exception("Erro ao escrever arquivo do banco.");
       }
       pg_lo_close($oObjetoBanco);
       return $oOidBanco;
   }
}