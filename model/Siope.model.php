<?php

require_once("classes/db_orcorgao_classe.php");
require_once("libs/db_liborcamento.php");
require_once("libs/db_libcontabilidade.php");
require_once("model/SiopeCsv.model.php");


class Siope {

    //@var integer
    public $iInstit;
    //@var integer
    public $iAnoUsu;
    //@var integer
    public $iBimestre;
    //@var string
    public $filtros;
    //@var string
    public $dtIni;
    //@var string
    public $dtFim;
    //var array
    public $despesas = array();

    public function setAno($iAnoUsu) {
        $this->iAnoUsu = $iAnoUsu;
    }

    public function setInstit($iInstit) {
        $this->iInstit = $iInstit;
    }

    public function setBimestre($iBimestre) {
        $this->iBimestre = $iBimestre;
    }

    public function setFiltros() {

        $clorcorgao       = new cl_orcorgao;
        $result           = db_query($clorcorgao->sql_query_file('', '', 'o40_orgao', 'o40_orgao asc', 'o40_instit = '.$this->iInstit.' and o40_anousu = '.$this->iAnoUsu));
        $this->filtros    = "instit_{$this->iInstit}-funcao_12-";

        if (pg_num_rows($result) > 1) {
            for ($i = 0; $i < pg_numrows($result); $i++) {
                $this->filtros .= "orgao_".db_utils::fieldsMemory($result, $i)->o40_orgao."-";
            }
        } else {
            $this->filtros = 'geral';
        }

    }

    public function setPeriodo() {

        $iBimestre  = $this->iBimestre;
        $dtData     = new \DateTime("{$this->iAnoUsu}-01-01");
        $dtIni      = new \DateTime("{$this->iAnoUsu}-01-01");


        if($iBimestre == 1) {
            $dtData->modify('last day of next month');
        } elseif($iBimestre == 2) {
            $dtData->modify('last day of April');
        } elseif($iBimestre == 3) {
            $dtData->modify('last day of June');
        } elseif($iBimestre == 4) {
            $dtData->modify('last day of August');
        } elseif($iBimestre == 5) {
            $dtData->modify('last day of October');
        } elseif($iBimestre == 6) {
            $dtData->modify('last day of December');
        }

        $this->dtIni = $dtIni->format('Y-m-d');
        $this->dtFim = $dtData->format('Y-m-d');

    }

    public function setDespesas() {

        $clselorcdotacao = new cl_selorcdotacao();
        $clselorcdotacao->setDados($this->filtros);

        $sele_work  = $clselorcdotacao->getDados(false, true) . " and o58_instit in ($this->iInstit) and  o58_anousu=$this->iAnoUsu  ";

        $sqlprinc   = db_dotacaosaldo(8, 1, 4, true, $sele_work, $this->iAnoUsu, $this->dtIni, $this->dtFim, 8, 0, true);
        $result     = db_query($sqlprinc) or die(pg_last_error());

        if (pg_num_rows($result) == 0) {
            throw new Exception ("Nenhum registro encontrado.");
        }

        $xorgao     = 0;
        $xunidade   = 0;
        $xfuncao    = 0;
        $xsubfuncao = 0;
        $xprograma  = 0;
        $xprojativ  = 0;

        for ($i = 0; $i < pg_numrows($result); $i++) {

            $oDespesa = db_utils::fieldsMemory($result, $i);

            if ($oDespesa->o58_orgao != $xorgao && $oDespesa->o58_orgao != 0) {
                $xorgao = $oDespesa->o58_orgao;
            }
            if ($oDespesa->o58_orgao . $oDespesa->o58_unidade != $xunidade && $oDespesa->o58_unidade != 0) {
                $xunidade = $oDespesa->o58_orgao . $oDespesa->o58_unidade;
            }
            if ($oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao != $xfuncao && $oDespesa->o58_funcao != 0) {
                $xfuncao = $oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao;
            }
            if ($oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao . $oDespesa->o58_subfuncao != $xsubfuncao && $oDespesa->o58_subfuncao != 0) {
                $xsubfuncao = $oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao . $oDespesa->o58_subfuncao;
            }
            if ($oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao . $oDespesa->o58_subfuncao . $oDespesa->o58_programa != $xprograma && $oDespesa->o58_programa != 0) {
                $xprograma = $oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao . $oDespesa->o58_subfuncao . $oDespesa->o58_programa;
            }
            if ($oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao . $oDespesa->o58_subfuncao . $oDespesa->o58_programa . $oDespesa->o58_projativ != $xprojativ && $oDespesa->o58_projativ != 0) {
                $xprojativ = $oDespesa->o58_orgao . $oDespesa->o58_unidade . $oDespesa->o58_funcao . $oDespesa->o58_subfuncao . $oDespesa->o58_programa . $oDespesa->o58_projativ;
            }

            if ($oDespesa->o58_codigo > 0) {

                if ($oDespesa->o58_elemento != "") {

                    $sele_work2 = " 1=1 and o58_orgao in ({$oDespesa->o58_orgao}) and ( ( o58_orgao = {$oDespesa->o58_orgao} and o58_unidade = {$oDespesa->o58_unidade} ) ) and o58_funcao in ({$oDespesa->o58_funcao}) and o58_subfuncao in ({$oDespesa->o58_subfuncao}) and o58_programa in ({$oDespesa->o58_programa}) and o58_projativ in ({$oDespesa->o58_projativ}) and (o56_elemento like '" . substr($oDespesa->o58_elemento, 0, 7) . "%') and o58_codigo in ({$oDespesa->o58_codigo}) and o58_instit in ({$this->iInstit}) and o58_anousu={$this->iAnoUsu} ";

                    $cldesdobramento = new cl_desdobramento();
                    $resDepsMes = db_query($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})")) or die($cldesdobramento->sql($sele_work2, $this->dtIni, $this->dtFim, "({$this->iInstit})") . pg_last_error());
                    $aDadosAgrupados = array();

                    $sHashDesp = $oDespesa->o58_elemento;

                    if (!isset($aDadosAgrupados[$sHashDesp])) {
                        $oDesp = array();
                        $oDesp['o58_codigo']        = $oDespesa->o58_codigo;
                        $oDesp['o58_elemento']      = $oDespesa->o58_elemento;
                        $oDesp['o58_subfuncao']     = $oDespesa->o58_subfuncao;
                        $oDesp['o55_tipopasta']     = $oDespesa->o55_tipopasta;
                        $oDesp['o55_tipoensino']    = $oDespesa->o55_tipoensino;
                        $oDesp['dot_atualizada']    = ($oDespesa->dot_ini + $oDespesa->suplementado_acumulado - $oDespesa->reduzido_acumulado);

                        $aDadosAgrupados[$sHashDesp] = $oDesp;
                    }

                    for ($contDesp = 0; $contDesp < pg_num_rows($resDepsMes); $contDesp++) {
                        $oDadosMes = db_utils::fieldsMemory($resDepsMes, $contDesp);

                        $sHashDespDesd = $oDadosMes->o56_elemento;
                        if (isset($aDadosAgrupados[$sHashDesp])) {

                            $aDadosAgrupados[$sHashDesp][$sHashDesp][$sHashDespDesd]['o56_elemento']        = $oDadosMes->o56_elemento;
                            $aDadosAgrupados[$sHashDesp][$sHashDesp][$sHashDespDesd]['o56_descr']           = $oDadosMes->o56_descr;
                            $aDadosAgrupados[$sHashDesp][$sHashDesp][$sHashDespDesd]['empenhado']           = ($oDadosMes->empenhado - $oDadosMes->empenhado_estornado);
                            $aDadosAgrupados[$sHashDesp][$sHashDesp][$sHashDespDesd]['liquidado']           = ($oDadosMes->liquidado - $oDadosMes->liquidado_estornado);
                            $aDadosAgrupados[$sHashDesp][$sHashDesp][$sHashDespDesd]['pagamento']           = ($oDadosMes->pagamento - $oDadosMes->pagamento_estornado);
                            $aDadosAgrupados[$sHashDesp][$sHashDesp][$sHashDespDesd]['o58_elemento']        = $oDespesa->o58_elemento;
                            $aDadosAgrupados[$sHashDesp][$sHashDesp][$sHashDespDesd]['o58_codigo']          = $oDespesa->o58_codigo;
                            $aDadosAgrupados[$sHashDesp][$sHashDesp][$sHashDespDesd]['o58_subfuncao']       = $oDespesa->o58_subfuncao;
                            $aDadosAgrupados[$sHashDesp][$sHashDesp][$sHashDespDesd]['o55_tipopasta']       = $oDespesa->o55_tipopasta;
                            $aDadosAgrupados[$sHashDesp][$sHashDesp][$sHashDespDesd]['o55_tipoensino']      = $oDespesa->o55_tipoensino;

                        } else {
                            $oDespDesd = array();

                            $oDespDesd['o56_elemento']      = $oDadosMes->o56_elemento;
                            $oDespDesd['o56_descr']         = $oDadosMes->o56_descr;
                            $oDespDesd['empenhado']         = ($oDadosMes->empenhado - $oDadosMes->empenhado_estornado);
                            $oDespDesd['liquidado']         = ($oDadosMes->liquidado - $oDadosMes->liquidado_estornado);
                            $oDespDesd['pagamento']         = ($oDadosMes->pagamento - $oDadosMes->pagamento_estornado);
                            $oDespDesd['o58_elemento']      = $oDespesa->o56_elemento;
                            $oDespDesd['o58_codigo']        = $oDespesa->o58_codigo;
                            $oDespDesd['o58_subfuncao']     = $oDespesa->o58_subfuncao;
                            $oDespDesd['o55_tipopasta']     = $oDespesa->o55_tipopasta;
                            $oDespDesd['o55_tipoensino']    = $oDespesa->o55_tipoensino;

                            $aDadosAgrupados[$sHashDesp][$sHashDesp][$sHashDespDesd] = $oDespDesd;
                        }

                    }

                    if(!empty($aDadosAgrupados)) {
                        array_push($this->despesas, $aDadosAgrupados);
                    }

                }
            }
        }
    }

    public function getDespesas() {
        return $this->despesas;
    }

    public function montaTabela() {

        ini_set('display_errors', 'On');
        error_reporting(E_ALL);

        echo '<table border="1">';
        echo '  <tr>';
        echo '      <td>Tipo</td>';
        echo '      <td>Cod Inst</td>';
        echo '      <td>Recurso</td>';
        echo '      <td>Sub Função</td>';
        echo '      <td>Elem Desp</td>';
        echo '      <td>Elem Desp Desd</td>';
        echo '      <td>Descrição</td>';
        echo '      <td>Dot Atu</td>';
        echo '      <td>Desp Emp</td>';
        echo '      <td>Desp Liq</td>';
        echo '      <td>Desp Pag</td>';
        echo '      <td>Desp Orç</td>';
        echo '      <td>Dot Atualizada</td>';
        echo '      <td>Tipo Pasta</td>';
        echo '      <td>Tipo Ensino</td>';
        echo '  </tr>';

        foreach($this->despesas as $despesa) {

            foreach($despesa as $linhaDespesa) {

                $sChaveElem = $linhaDespesa['o58_elemento'];

                echo '<tr>';
                echo '  <td>V</td>';
                echo '  <td>1</td>';
                echo '  <td>'.$linhaDespesa['o58_codigo'].'</td>';
                echo '  <td>'.$linhaDespesa['o58_subfuncao'].'</td>';
                echo '  <td>'.$linhaDespesa['o58_elemento'].'</td>';
                echo '  <td></td>';
                echo '  <td></td>';
                echo '  <td></td>';
                echo '  <td></td>';
                echo '  <td></td>';
                echo '  <td></td>';
                echo '  <td></td>';
                echo '  <td>'.db_formatar($linhaDespesa['dot_atualizada'], 'f').'</td>';
                echo '  <td>'.$linhaDespesa['o55_tipopasta'].'</td>';
                echo '  <td>'.$linhaDespesa['o55_tipoensino'].'</td>';
                echo '</tr>';

                if(isset($linhaDespesa[$sChaveElem])) {

                    foreach ($linhaDespesa[$sChaveElem] as $linhaDespDesd) {

                        echo '<tr>';
                        echo '  <td>V</td>';
                        echo '  <td>1</td>';
                        echo '  <td>'.$linhaDespDesd['o58_codigo'].'</td>';
                        echo '  <td>'.$linhaDespDesd['o58_subfuncao'].'</td>';
                        echo '  <td>'.$linhaDespDesd['o58_elemento'].'</td>';
                        echo '  <td>'.$linhaDespDesd['o56_elemento'].'</td>';
                        echo '  <td></td>';
                        echo '  <td></td>';
                        echo '  <td>'.db_formatar($linhaDespDesd['empenhado'], 'f').'</td>';
                        echo '  <td>'.db_formatar($linhaDespDesd['liquidado'], 'f').'</td>';
                        echo '  <td>'.db_formatar($linhaDespDesd['pagamento'], 'f').'</td>';
                        echo '  <td></td>';
                        echo '  <td></td>';
                        echo '  <td>'.$linhaDespDesd['o55_tipopasta'].'</td>';
                        echo '  <td>'.$linhaDespDesd['o55_tipoensino'].'</td>';
                        echo '</tr>';

                    }

                }

            }

        }
        echo '</table>';

    }

}