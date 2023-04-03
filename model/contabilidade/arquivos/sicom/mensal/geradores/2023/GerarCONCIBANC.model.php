<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author Elvio
 * @package Contabilidade
 */
class GerarCONCIBANC extends GerarAM
{

    /**
     *
     * Mes de referência
     * @var Integer
     */
    public $iMes;

    /**
     *
     * Mes de referência
     * @var Date
     */
    public $sDataInicial;

    /**
     *
     * Mes de referência
     * @var Date
     */
    public $sDataFinal;


    public function gerarDados()
    {



        // Arquivo será construido.
        $this->sArquivo = "CONCIBANC";
        $this->abreArquivo();



        $sqlConcibanc102023  = "	    select case when c61_codtce is not null
                                        then c61_codtce
                                        else k13_reduz
                                        end as c61_codtce,";
        $sqlConcibanc102023 .= "        si09_codorgaotce as si202_codorgao,";
	    $sqlConcibanc102023 .= "              sum(substr(fc_saltessaldo,41,13)::float8) as si202_vlsaldofinalcontabil ";
        $sqlConcibanc102023 .= "    	from (";
 	    $sqlConcibanc102023 .= "              select k13_reduz, c61_codtce, si09_codorgaotce, ";
	    $sqlConcibanc102023 .= "                     fc_saltessaldo(k13_reduz,'".$this->sDataInicial."','".$this->sDataFinal."',null," . db_getsession("DB_instit") . ") ";
	    $sqlConcibanc102023 .= "              from   saltes ";
	    $sqlConcibanc102023 .= "                     inner join conplanoexe   on k13_reduz = c62_reduz ";
		$sqlConcibanc102023 .= "                                              and c62_anousu = ".db_getsession('DB_anousu')." ";
		$sqlConcibanc102023 .= "                     inner join conplanoreduz on c61_anousu=c62_anousu and c61_reduz = c62_reduz and c61_instit = " . db_getsession("DB_instit") . " ";
	    $sqlConcibanc102023 .= "                     inner join conplano      on c60_codcon = c61_codcon and c60_anousu=c61_anousu ";
	    $sqlConcibanc102023 .= "                     left  join conplanoconta on c60_codcon = c63_codcon and c63_anousu=c60_anousu ";
	    $sqlConcibanc102023 .= "                     left  join infocomplementaresinstit on si09_instit = c61_instit";
        $sqlConcibanc102023 .= " and c60_codsis = 6 where k13_limite >=	'".$this->sDataInicial."' or k13_limite is null";
        $sqlConcibanc102023 .= "  ) as x ";
        $sqlConcibanc102023 .= "  group by 1,2 ";


        $rsConcibanc102023 = db_query($sqlConcibanc102023);
       // db_criatabela($rsConcibanc102023);

        if(pg_num_rows($rsConcibanc102023) < 0){
            $aCSV['si202_tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();
        }

        if(pg_num_rows($rsConcibanc102023) > 0){
            $aConcibanc102023 = db_utils::getCollectionByRecord($rsConcibanc102023, false, false, true);
            foreach($aConcibanc102023 as $oConcibanc102023){
                $aCSV['si202_tiporegistro']         = str_pad(10, 2, "0", STR_PAD_LEFT);
                $aCSV['si202_codorgao']             = $this->padLeftZero($oConcibanc102023->si202_codorgao, 2);
                $aCSV['si202_codctb']               = $oConcibanc102023->c61_codtce;
                $aCSV['si202_vlsaldofinalextrato']  = $this->sicomNumberReal($oConcibanc102023->si202_vlsaldofinalcontabil, 2);
                $aCSV['si202_vlsaldofinalcontabil'] = $this->sicomNumberReal($oConcibanc102023->si202_vlsaldofinalcontabil, 2);
                $this->sLinha = $aCSV;
                $this->adicionaLinha();
            }
        }

    }
}
