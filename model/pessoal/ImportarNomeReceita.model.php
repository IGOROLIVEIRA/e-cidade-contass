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

/**
 * Classe para importação de nomes da receita federal para atualizar o cadastro do cgm, para o esocial
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class ImportarNomeReceita
{
    /**
    * @var String
    */
    protected $sFile = '';

    public function __construct($sFile)
    {
        $this->sFile = $sFile;
    }

    public function processar()
    {
        $this->openFile();
        while (($csvData = fgetcsv($this->file, 1000, ";")) !== FALSE) {
            if (!is_numeric($csvData[0])) {
                continue;
            }
            if (empty($csvData[18])) {
                continue;
            }
            $cgm = db_utils::getDao('cgm');
            $result = db_query($cgm->sql_query(null, "z01_numcgm,z01_nome,z01_notificaemail", null, "z01_cgccpf = '{$csvData[0]}'"));
            $nomeReceita = explode("-", $csvData[18]);
            $nomeReceita = trim($nomeReceita[1]);
            if ($nomeReceita != db_utils::fieldsMemory($result, 0)->z01_nome) {
                $cgm->z01_nome = $nomeReceita;
                $cgm->alterar(db_utils::fieldsMemory($result, 0)->z01_numcgm);
                if ($cgm->erro_status == "0") {
                    throw new Exception("Erro na alteração do cgm: {$cgm->erro_msg}");
                }
            }
            
        }
        $this->closeFile();
    }

    protected function openFile()
    {
        if (file_exists("../../{$this->sFile}")) {
            throw new Exception("Arquivo não encontrado.");
        }
        $this->file = fopen($this->sFile,"r");
    }

    protected function closeFile()
    {
        fclose($this->file);
    }
}