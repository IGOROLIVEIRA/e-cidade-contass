<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");
require_once ("classes/db_rhpessoalmov_classe.php");
require_once ("classes/db_cgm_classe.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */

class GerarPESSOA extends GerarAM {

	/**
	 *
	 * Mes de referência
	 * @var Integer
	 */
	public $iMes;

	public function gerarDados() {

		$this->sArquivo = "PESSOA";
		$this->abreArquivo();

		// $sSql          = "select * from pessoaflpgo102019 where si193_mes = ". $this->iMes." and si193_inst = ".db_getsession("DB_instit");
    $sSql = "SELECT DISTINCT cgm.*
      FROM rhpessoalmov
      INNER JOIN rhpessoal ON rhpessoal.rh01_regist = rhpessoalmov.rh02_regist
      INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
      LEFT JOIN pessoaflpgo102019 on si193_nome = z01_nome
      LEFT JOIN rhpesrescisao ON rhpessoalmov.rh02_seqpes = rhpesrescisao.rh05_seqpes
      WHERE extract(YEAR from rh01_admiss) = '".db_getsession('DB_anousu')."' AND extract(MONTH from rh01_admiss) = $this->iMes";
    $rsPESSOA10    = db_query($sSql);


		if (pg_num_rows($rsPESSOA10) == 0) {

      /* Busca pessoas admitidas conforme o mês selecionado */
      $oClasse = new cl_rhpessoalmov();

      $sqlAdmitidos = $oClasse->sql_query_instituidor(null,"DISTINCT(cgm.*)",null,
        "extract(YEAR from rh01_admiss)='".db_getsession("DB_anousu")."' AND extract(MONTH from rh01_admiss) = '".$this->iMes."'");

      $rsAdmitidos = $oClasse->sql_record($sqlAdmitidos);
      $admitidos = db_utils::getCollectionByRecord($rsAdmitidos);
      foreach ($admitidos as $adm) {
        unset($aPESSOA10['si193_sequencial']);
        unset($aPESSOA10['si193_mes']);
        unset($aPESSOA10['si193_inst']);

        $aCSVPESSOA10['si193_tiporegistro']             =  str_pad('10', 2, "0", STR_PAD_LEFT);
        $aCSVPESSOA10['si193_tipodocumento']            =  str_pad('1', 1, "0", STR_PAD_LEFT);
        $aCSVPESSOA10['si193_nrodocumento']             =  substr($adm->z01_cgccpf, 0,14);
        $aCSVPESSOA10['si193_nome']                     =  substr($adm->z01_nome, 0,120);
        if(!empty($adm->z01_sexo)){
          $aCSVPESSOA10['si193_indsexo']                =  str_pad($adm->z01_sexo, 1, "0", STR_PAD_LEFT);
        }else{
          $aCSVPESSOA10['si193_indsexo']                =  ' ';
        }
        $aCSVPESSOA10['si193_datanascimento']           =  implode("", array_reverse(explode("-", $adm->z01_nasc)));
        $aCSVPESSOA10['si193_tipocadastro']             =  str_pad('1', 1, "0", STR_PAD_LEFT);
        $aCSVPESSOA10['si193_justalteracao']            =  substr($aPESSOA10['si193_justalteracao'], 0,100);
        $this->sLinha = $aCSVPESSOA10;
        $this->adicionaLinha();
      }

      if(!$instituidor && !$admitidos){
        $aCSV['tiporegistro']       =   '99';
        $this->sLinha = $aCSV;
        $this->adicionaLinha();
      }
    } else {

        for ($iCont = 0;$iCont < pg_num_rows($rsPESSOA10); $iCont++) {

    				$aPESSOA10  = pg_fetch_array($rsPESSOA10,$iCont, PGSQL_ASSOC);

    				unset($aPESSOA10['si193_sequencial']);
    				unset($aPESSOA10['si193_mes']);
    				unset($aPESSOA10['si193_inst']);

    				$aCSVPESSOA10['si193_tiporegistro']             =  str_pad('10', 2, "0", STR_PAD_LEFT);
    				$aCSVPESSOA10['si193_tipodocumento']            =  str_pad('1', 1, "0", STR_PAD_LEFT);
    				$aCSVPESSOA10['si193_nrodocumento']             =  substr($aPESSOA10['z01_cgccpf'], 0,14);
    				$aCSVPESSOA10['si193_nome']                     =  substr($aPESSOA10['z01_nome'], 0,120);
    				if(!empty($aPESSOA10['z01_sexo'])){
    					$aCSVPESSOA10['si193_indsexo']                  =  str_pad($aPESSOA10['z01_sexo'], 1, "0", STR_PAD_LEFT);
    				}else{
    					$aCSVPESSOA10['si193_indsexo']                  =  ' ';
    				}
    				$aCSVPESSOA10['si193_datanascimento']           =  implode("", array_reverse(explode("-", $aPESSOA10['z01_nasc'])));
    				$aCSVPESSOA10['si193_tipocadastro']             =  str_pad('1', 1, "0", STR_PAD_LEFT);
    				$aCSVPESSOA10['si193_justalteracao']            =  substr($aPESSOA10['si193_justalteracao'], 0,100);

            $this->sLinha = $aCSVPESSOA10;

    				$this->adicionaLinha();
        }

        $primeiroLancamento = array();
        $oClasse = new cl_rhpessoalmov();
        $sqlAdmitido = $oClasse->sql_query_instituidor(null,"DISTINCT(rh02_cgminstituidor)",null,
        "rh02_anousu='".db_getsession("DB_anousu")."' AND rh02_mesusu='".$this->iMes."' AND rh02_cgminstituidor IS NOT NULL");

        $rsAdmitido = $oClasse->sql_record($sqlAdmitido);

        for($i=0;$i<pg_num_rows($rsAdmitido);$i++){
          $cgminstituidor = db_utils::fieldsMemory($rsAdmitido,$i);
          array_push($primeiroLancamento, $cgminstituidor->rh02_cgminstituidor);

        }

        foreach ($primeiroLancamento as $index=>$servInst) {
          $instituidor = db_utils::fieldsMemory($rsAdmitido,$index);
          for($i=(int)$this->iMes;$i>1;$i--){
            $sqlAux = $oClasse->sql_query_instituidor(null,"DISTINCT(rh02_cgminstituidor)",null,
              "rh02_anousu='".db_getsession("DB_anousu")."' AND rh02_mesusu='".($i-1)."' AND rh02_cgminstituidor = ".$instituidor->rh02_cgminstituidor);
            $rsAux = $oClasse->sql_record($sqlAux);
            $cgmAux = db_utils::fieldsMemory($rsAux,0);

            if(pg_num_rows($rsAux) > 0){
                // echo 'Normal: '.implode(",",$primeiroLancamento);
                $primeiroLancamento = array_diff($primeiroLancamento, array("$cgmAux->rh02_cgminstituidor"));
                // echo 'DIFF: '.implode(",",$primeiroLancamento);
            }
          }
        }
    }

        /* Busca pessoas instituidoras, que possuem movimentação no determinado mês */

        $sqlConsulta = $oClasse->sql_query_instituidor(null,"distinct(rh02_cgminstituidor)",null,
            "rh02_anousu=".db_getsession('DB_anousu')." and rh02_mesusu = '".$this->iMes."'
             and rh02_cgminstituidor in (".implode(',',$primeiroLancamento).")");
        $rsConsulta = $oClasse->sql_record($sqlConsulta);
        $instituidor = db_utils::getCollectionByRecord($rsConsulta);

        if(pg_num_rows($rsConsulta) > 0){
          foreach ($instituidor as $inst) {
            $instit = db_query("select * from cgm where z01_numcgm in (".$inst->rh02_cgminstituidor.")");
            $inst = db_utils::fieldsMemory($instit,0);
            unset($aPESSOA10['si193_sequencial']);
            unset($aPESSOA10['si193_mes']);
            unset($aPESSOA10['si193_inst']);

            $aCSVPESSOA10['si193_tiporegistro']             =  str_pad('10', 2, "0", STR_PAD_LEFT);
            $aCSVPESSOA10['si193_tipodocumento']            =  str_pad('1', 1, "0", STR_PAD_LEFT);
            $aCSVPESSOA10['si193_nrodocumento']             =  substr($inst->z01_cgccpf, 0,14);
            $aCSVPESSOA10['si193_nome']                     =  substr($inst->z01_nome, 0,120);
            if(!empty($inst->z01_sexo)){
              $aCSVPESSOA10['si193_indsexo']                =  str_pad($inst->z01_sexo, 1, "0", STR_PAD_LEFT);
            }else{
              $aCSVPESSOA10['si193_indsexo']                =  ' ';
            }
              $aCSVPESSOA10['si193_datanascimento']           =  implode("", array_reverse(explode("-", $inst->z01_nasc)));
              $aCSVPESSOA10['si193_tipocadastro']             =  str_pad('1', 1, "0", STR_PAD_LEFT);
              $aCSVPESSOA10['si193_justalteracao']            =  substr($aPESSOA10['si193_justalteracao'], 0,100);
              $this->sLinha = $aCSVPESSOA10;
              $this->adicionaLinha();
          }
        }
      $this->fechaArquivo();
  }

}
