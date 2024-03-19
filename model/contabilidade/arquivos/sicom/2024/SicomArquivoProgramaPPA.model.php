<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("model/ppadespesa.model.php");
require_once ("classes/db_orcprograma_classe.php");
require_once ("classes/db_orcdotacao_classe.php");
require_once ("classes/db_ppalei_classe.php");
require_once ("classes/db_ppaestimativadespesa_classe.php");

class SicomArquivoProgramaPPA extends SicomArquivoBase implements iPadArquivoBaseCSV
{

    protected $iCodigoLayout = 137;

    protected $sNomeArquivo = 'PRO';

    protected $iCodigoPespectiva;

    public function __construct()
    {

    }

    public function getCodigoLayout()
    {
        return $this->iCodigoLayout;
    }

    /**
     * Esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
     */
    public function getCampos(): array
    {

        return array(
            "codPrograma",
            "nomePrograma",
            "objetivo",
            "totRecursos1Ano",
            "totRecursos2Ano",
            "totRecursos3Ano",
            "totRecursos4Ano"
        );
    }

    public function gerarDados()
    {
        $cl_orcprograma = new cl_orcprograma();
        $cl_ppaLei = new cl_ppalei();
        $cl_ppaEstimativaDespesa = new cl_ppaestimativadespesa();

        $oPPADespesa = new ppaDespesa($this->getCodigoPespectiva());

        $rsPpaLei = $cl_ppaLei->sql_record($cl_ppaLei->sql_ppaleiIP($this->iCodigoPespectiva));
        $oPpaLei = db_utils::fieldsMemory($rsPpaLei, 0);

        $anoSessao = db_getsession("DB_anousu");

        $resulOrcPrograma = $this->programasOrcamento($anoSessao, $cl_orcprograma);
        $resultPpaEstimativaDesp = $this->programasPPA($oPpaLei->o01_anoinicio, $cl_ppaEstimativaDespesa);

        for ($iAnoPPA = $oPpaLei->o01_anoinicio; $iAnoPPA <= $oPpaLei->o01_anofinal; $iAnoPPA++){

            list($iCont, $rsProgramaPPA, $aDespesa) = $this->estimativasPPA($oPPADespesa, $anoSessao);

            $oDadosPRO = new stdClass();

            $aCaracteres = array("°", chr(13), chr(10), "", "");

            while ($linha = pg_fetch_assoc($resulOrcPrograma)){
                $codProg = $linha['o54_programa'];

                // Verifica se o codProg existe nos resultados da segunda consulta
                $encontrado = false;
                pg_result_seek($resultPpaEstimativaDesp, 0); // Volta para o início do conjunto de resultados
                while ($linha2 = pg_fetch_assoc($resultPpaEstimativaDesp)) {

                    if ($linha2['o08_programa'] == $codProg) {
                        // Se encontrado, utiliza os resultados da segunda consulta
                        foreach ($aDespesa as $sEstimativa) {

                            if ($sEstimativa->iCodigo == $codProg) {

                                $iNum1 = 1;
                                foreach ($sEstimativa->aEstimativas as $iAno => $nValorAno) {

                                    if ($iAno == $anoSessao) {

                                        $sqlValorProg = $this->sqlValorProgramaAnoSessao($anoSessao, $codProg);

                                        $rsValorPrograma = db_query($sqlValorProg);
                                        $nValorAno = db_utils::fieldsMemory($rsValorPrograma, 0)->valor;

                                    }

                                    if ($nValorAno == '') {
                                        $nValorAno = 0;
                                    }
                                    $sRecurso = "totRecursos" . $iNum1 . "Ano";
                                    $oDadosPRO->$sRecurso = number_format($nValorAno, 2, ",", "");
                                    $iNum1++;
                                }
                            }
                        }
                        $encontrado = true;
                        break;
                    }
                }

                // Se não encontrado, utiliza os resultados da primeira consulta
                if (!$encontrado) {

                    $aDadosProg = array();

                    for ($iAnoOrc = $oPpaLei->o01_anoinicio; $iAnoOrc <= $oPpaLei->o01_anofinal; $iAnoOrc++){

                        $iNum10 = 1;

                        $sqlValorProg = $this->sqlValorProg($iAnoOrc, $anoSessao, $codProg);
                        $rsValorPrograma = db_query($sqlValorProg);

                        $oProgramaValor = db_utils::fieldsMemory($rsValorPrograma, 0);

                        $nValorAno = $oProgramaValor->o28_valor;
                        $nValorAno = empty($nValorAno) ? 0 : $nValorAno;

                        if ($iAnoOrc == $anoSessao) {

                            $sqlValorProg = $this->sqlValorProgramaAnoSessao($anoSessao, $codProg);

                            $rsValorPrograma1 = db_query($sqlValorProg);
                            $nValorAno = db_utils::fieldsMemory($rsValorPrograma1, 0)->valor;

                            $nValorAno = empty($nValorAno) ? 0 : $nValorAno;

                            $oProgramaValor->o28_valor = $nValorAno;

                        }

                        $sRecurso = "totRecursos" . $iNum10 . "Ano";
                        $oDadosPRO->$sRecurso = number_format($nValorAno, 2, ",", "");

                        if (empty(pg_fetch_assoc($rsValorPrograma))) {

                            $oProgramaValor->o58_programa = $codProg;
                            $oProgramaValor->o28_valor = 0;
                            $oProgramaValor->o28_anoref = $iAnoOrc;

                            $sRecurso = "totRecursos" . $iNum10 . "Ano";
                            $oDadosPRO->$sRecurso = number_format(0, 2, ",", "");

                        }

                        $aDadosProg[] = $oProgramaValor;
                    }

                    $oDadosPRO->totRecursos1Ano = number_format($aDadosProg[0]->o28_valor, 2, ",", "");
                    $oDadosPRO->totRecursos2Ano = number_format($aDadosProg[1]->o28_valor, 2, ",", "");
                    $oDadosPRO->totRecursos3Ano = number_format($aDadosProg[2]->o28_valor, 2, ",", "");
                    $oDadosPRO->totRecursos4Ano = number_format($aDadosProg[3]->o28_valor, 2, ",", "");

                }

                $descrProg = $linha['o54_descr'];
                $finaliProg = $linha['o54_finali'];

                $oDadosPRO->codPrograma = str_pad($codProg, 4, "0", STR_PAD_LEFT);
                $oDadosPRO->nomePrograma = substr($descrProg, 0, 100);
                $sDescricao = str_replace($aCaracteres, "", substr($finaliProg, 0, 230));
                if (isset($finaliProg)) {
                    $oDadosPRO->objetivo = $sDescricao;
                } else {
                    $oDadosPRO->objetivo = substr($descrProg, 0, 100);
                }
                if ($oDadosPRO->totRecursos1Ano > 0 || $oDadosPRO->totRecursos2Ano > 0 || $oDadosPRO->totRecursos3Ano > 0 || $oDadosPRO->totRecursos4Ano > 0) {
                    $this->aDados[] = clone $oDadosPRO;
                }
            }
        }
    }

    public function setCodigoPespectiva($iCodigoPespectiva)
    {
        $this->iCodigoPespectiva = $iCodigoPespectiva;
    }

    public function getCodigoPespectiva()
    {
        return $this->iCodigoPespectiva;
    }

    /**
     * @param ppaDespesa $oPPADespesa
     * @param integer $anoSessao
     * @return array
     * @throws Exception
     */
    public function estimativasPPA(ppaDespesa $oPPADespesa, int $anoSessao): array
    {
        $sSqlInstit = "SELECT codigo FROM db_config ";
        $rsInstit = db_query($sSqlInstit);

        // Lista das instituições
        for ($iCont = 0; $iCont < pg_num_rows($rsInstit); $iCont++) {

            $oReceita = db_utils::fieldsMemory($rsInstit, $iCont);
            $sListaInstit[] = $oReceita->codigo;
        }

        $sListaInstit = implode(",", $sListaInstit);

        $sSqlPPA = "select * from ppaestimativadespesa where o07_anousu = {$anoSessao}";
        $rsProgramaPPA = db_query($sSqlPPA);
        /**
         * Pegar estimativas por programa
         */
        if (pg_num_rows($rsProgramaPPA) > 0) {
            $oPPADespesa->setInstituicoes($sListaInstit);
            $aDespesa = $oPPADespesa->getQuadroEstimativas(null, 5);
        }
        return array($iCont, $rsProgramaPPA, $aDespesa);
    }

    /**
     * SQL para programas do orcamento
     *
     * @param $anoSessao
     * @param cl_orcprograma $cl_orcprograma
     * @return bool|resource
     */
    public function programasOrcamento($anoSessao, cl_orcprograma $cl_orcprograma)
    {

        $camposOrcPrograma = "o54_programa, o54_codtri, o54_descr, o54_finali, to_char(round(sum(o58_valor), 2), 'L999G999G990D99') AS valor";
        $whereOrcPrograma = "o54_anousu = {$anoSessao}";
        $sqlOrcPrograma = $cl_orcprograma->sql_programaOrcamento($camposOrcPrograma, null, "1", $whereOrcPrograma, "1, 2, 3, 4");
        return $cl_orcprograma->sql_record($sqlOrcPrograma);
    }

    /**
     * SQL para programas do PPA
     *
     * @param int $iAnoPPA
     * @param cl_ppaestimativadespesa $cl_ppaEstimativaDespesa
     * @return bool|resource
     */
    public function programasPPA(int $iAnoPPA, cl_ppaestimativadespesa $cl_ppaEstimativaDespesa)
    {

        $wherePpaEstimativaDesp = "o08_ano >= {$iAnoPPA} AND o05_ppaversao = {$this->iCodigoPespectiva} AND o08_ppaversao = {$this->iCodigoPespectiva} ";
        $camposPpaEstimativaDesp = " DISTINCT o08_programa, trim(o54_descr) AS c60_estrut, o54_finali ";
        $sqlPpaEstimativaDesp = $cl_ppaEstimativaDespesa->sql_query_estimativadespesa(null, $camposPpaEstimativaDesp, "1, 2", $wherePpaEstimativaDesp);
        return $cl_ppaEstimativaDespesa->sql_record($sqlPpaEstimativaDesp);
    }

    /**
     * @param int $iAnoOrc
     * @param $codProg
     * @return string
     */
    public function sqlValorProg(int $iAnoOrc, $anoSessao, $codProg): string
    {
        return "SELECT o58_programa,
                       o28_anoref,
                       round(sum(o28_valor), 2) AS o28_valor
                FROM
                    (SELECT DISTINCT o58_programa,
                                     o28_anoref,
                                     o28_valor
                     FROM orcprojativprogramfisica
                     JOIN orcdotacao ON (o58_projativ, o58_anousu, o58_programa) = (o28_orcprojativ, {$anoSessao}, {$codProg})
                     WHERE o28_anoref = {$iAnoOrc}) AS x
                GROUP BY o58_programa, o28_anoref";
    }

    /**
     * @param $anoSessao
     * @param $codProg
     * @return string
     */
    public function sqlValorProgramaAnoSessao($anoSessao, $codProg): string
    {
        $cl_orcdotacao = new cl_orcdotacao();

        $where = "o58_anousu = {$anoSessao} AND o58_programa = {$codProg} ";
        $groupBy = "GROUP BY o58_programa ";
        $campos = " o58_programa, round(sum(o58_valor),2) AS valor ";

        return $cl_orcdotacao->sql_query_file(null, null, $campos, null, $where.$groupBy);
    }


}
