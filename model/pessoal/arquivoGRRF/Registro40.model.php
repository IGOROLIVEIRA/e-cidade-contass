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

require_once("model/pessoal/arquivoGRRF/RegistroBase.model.php");

/**
 * Arquivo Guia de Recolhimento Rescisório do FGTS
 * Registro 40
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class Registro40 extends RegistroBase {

    /**
     * gerar dados para o registro
     */
	public function gerarRegistro()
	{
		$oDaoRhpesrescisao = db_utils::getDao('rhpesrescisao');
        $sCampos  = "DISTINCT rh16_pis,rh01_admiss,h13_tpcont,z01_nome,rh16_ctps_n,rh16_ctps_s,rh01_sexo,rh01_instru,rh01_nasc,rh02_hrssem,rh37_cbo,";
        $sCampos .= "rh15_data,r59_movsef,rh05_recis,r59_codsaq,rh05_taviso,rh05_aviso,z01_cgccpf";
        $sOrdem = "rh16_pis,rh01_admiss,h13_tpcont";

        $sDataCompIni = "{$this->iAnoFolha}-{$this->iMesFolha}-01";
        $lBisexto = verifica_bissexto($sDataCompIni);
        if ($lBisexto) {
            $iFev = 29;
        } else {
            $iFev = 28;
        }
        $aUltimoDia = array("01"=>"31",
        "02"=>$iFev,
        "03"=>"31",
        "04"=>"30",
        "05"=>"31",
        "06"=>"30",
        "07"=>"31",
        "08"=>"31",
        "09"=>"30",
        "10"=>"31",
        "11"=>"30",
        "12"=>"31");
        $sDataCompFim = "{$this->iAnoFolha}-{$this->iMesFolha}-".$aUltimoDia[$this->iMesFolha];
        $sWhere  = "rh05_recis between '{$sDataCompIni}' AND '{$sDataCompFim}' AND rh02_instit = ".db_getsession("DB_instit");
        if (!empty($this->sServidores)) {
            $sWhere .= " AND rh01_regist IN ({$this->sServidores})";
        }

        $rsDados = $oDaoRhpesrescisao->sql_record($oDaoRhpesrescisao->sql_dados_rescisao(null, $sCampos, $sOrdem, $sWhere));
        if ($oDaoRhpesrescisao->numrows == 0) {
            throw new Exception("Não foram encontrados servidores com rescisão em {$this->iMesFolha}/{$this->iAnoFolha}");
        }
        $aLinhas = array();
        for ($iCont=0; $iCont < $oDaoRhpesrescisao->numrows; $iCont++) { 
            $oDados = db_utils::fieldsMemory($rsDados, $iCont);
            $aLinha = array();
            $aLinha['tipoRegistro'] = "40";
            $aLinha['tipoInscricaoEmpresa'] = "1";
            $aLinha['inscricaoEmpresa'] = $this->formatarCampo($this->oConfig->cgc, 14);
            $aLinha['tipoInscricaoTomador'] = "0";
            $aLinha['inscricaoTomador'] = $this->preencherCampo("0", 14);
            $aLinha['pispasep'] = $this->formatarCampo($oDados->rh16_pis, 11);
            $aLinha['dataAdmissao'] = $this->formatarDataBanco($oDados->rh01_admiss);
            $aLinha['categoriaTrabalhador'] = $this->formatarCampo($oDados->h13_tpcont, 2);
            $aLinha['nomeTrabalhador'] = $this->formatarCampo($oDados->z01_nome, 70);
            $aLinha['numeroCTPS'] = $this->formatarCampo($oDados->rh16_ctps_n, 7);
            $aLinha['serieCTPS'] = $this->formatarCampo($oDados->rh16_ctps_s, 5);
            $aLinha['sexo'] = $this->formatarCampo($oDados->rh01_sexo, 1);
            $aLinha['grauInstrucao'] = $this->formatarCampo($oDados->rh01_instru, 2, true);
            $aLinha['dataNascimento'] = $this->formatarDataBanco($oDados->rh01_nasc);
            $aLinha['horasSemana'] = $this->formatarCampo($oDados->rh02_hrssem, 2);
            $aLinha['cbo'] = $this->formatarCampo($oDados->rh37_cbo, 6);
            $aLinha['dataOpcao'] = $this->formatarDataBanco($oDados->rh15_data);
            $aLinha['codigoMovimentacao'] = $this->formatarCampo($oDados->r59_movsef, 2);
            $aLinha['dataMovimentacao'] = $this->formatarDataBanco($oDados->rh05_recis);
            $aLinha['codigoSaque'] = $this->formatarCampo($oDados->r59_codsaq, 3);
            $aLinha['avisoPrevio'] = $this->formatarCampo($oDados->rh05_taviso, 1);
            $aLinha['dataInicioAvisoPrevio'] = $this->formatarDataBanco($oDados->rh05_aviso);
            $aLinha['reposicaoVaga'] = "N";
            $aLinha['dataHomologacaoDissidioColetivo'] = $this->preencherCampo(" ", 8);
            $aLinha['valorDissidio'] = $this->preencherCampo("0", 15);
            $aLinha['remuneracaoMesAnterior'] = $this->preencherCampo("0", 15);
            $aLinha['remuneracaoMesRescisao'] = $this->preencherCampo("0", 15);
            $aLinha['avisoPrevioIndenizado'] = $this->preencherCampo("0", 15);
            $aLinha['indicativoPensaoAlimenticia'] = "N";
            $aLinha['percentualPensaoAlimenticia'] = $this->preencherCampo("0", 5);
            $aLinha['valorPensaoAlimenticia'] = $this->preencherCampo("0", 15);
            $aLinha['cpf'] = $this->formatarCampo($oDados->z01_cgccpf, 11);
            $aLinha['bancoTrabalhador'] = $this->preencherCampo("0", 3);
            $aLinha['agenciaTrabalhador'] = $this->preencherCampo("0", 4);
            $aLinha['contaTrabalhador'] = $this->preencherCampo("0", 13);
            $aLinha['saldoFinsRescisorios'] = $this->preencherCampo("0", 15);
            $aLinha['brancos'] = $this->preencherCampo(' ', 39);
            $aLinha['finalLinha'] = "*";
            $aLinhas[] = implode("", $aLinha);
        }
        return $aLinhas;
	}
}