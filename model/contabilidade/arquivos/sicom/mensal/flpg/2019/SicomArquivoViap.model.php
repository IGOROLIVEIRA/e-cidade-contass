<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_viap102019_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2019/flpg/GerarVIAP.model.php");

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

/**
 * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoViap extends SicomArquivoBase implements iPadArquivoBaseCSV {

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 147;

    /**
     *
     * NOme do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'VIAP';

    /**
     *
     * Contrutor da classe
     */
    public function __construct() {

    }

    /**
     * Retorna o codigo do layout
     *
     * @return Integer
     */
    public function getCodigoLayout(){
        return $this->iCodigoLayout;
    }

    /**
     *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
     */
    public function getCampos(){

        $aElementos  = array(

        );
        return $aElementos;
    }

    /**
     * selecionar os dados de indentificacao da remessa pra gerar o arquivo
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados(){

        /**
         * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
         */
        $clviap = new cl_viap102019();

        /**
         * inserir informacoes no banco de dados
         */
        db_inicio_transacao();
        $result = $clviap->sql_record($clviap->sql_query(NULL,"*",NULL,"si198_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si198_inst = ".db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clviap->excluir(NULL,"si198_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si198_inst = ".db_getsession("DB_instit"));
            if ($clviap->erro_status == 0) {
                throw new Exception($clviap->erro_msg);
            }
        }

        if ($this->sDataFinal['5'].$this->sDataFinal['6'] != 01) {

            $sSql = "select z01_cgccpf,
		       rh01_regist,
			   z01_numcgm
		      from cgm
		      inner join rhpessoal on rh01_numcgm = z01_numcgm
		      inner join rhpessoalmov on rh01_regist = rh02_regist
		      LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes 
		      where (z01_cgccpf != '00000000000' and z01_cgccpf != '00000000000000')
		      AND rh02_anousu = " . db_getsession("DB_anousu") . " AND rh02_mesusu = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
		      AND rh01_regist NOT IN
                        (SELECT si198_codvinculopessoa
                         FROM viap102019 where si198_mes < " . ($this->sDataFinal['5'] . $this->sDataFinal['6']) . " )
              AND rh01_instit =  " . db_getsession("DB_instit") . "
              AND (
                    rh05_seqpes is null 
                    or  
                    (date_part('MONTH',rh05_recis) = 01
                     and date_part('YEAR',rh05_recis) = 2019 
                    )
                    or
                    (date_part('MONTH',rh05_recis) = 12
                     and date_part('YEAR',rh05_recis) = 2017 
                    )
                  )
              AND   rh01_sicom = 1    
			  ";
        }else{

            $sSql = "select z01_cgccpf,
		       rh01_regist,
			   z01_numcgm
		      from cgm
		      inner join rhpessoal on rh01_numcgm = z01_numcgm
		      inner join rhpessoalmov on rh01_regist = rh02_regist
		      LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
		      where (z01_cgccpf != '00000000000' and z01_cgccpf != '00000000000000')
		      AND rh02_anousu = " . db_getsession("DB_anousu") . " AND rh02_mesusu = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
		      AND rh01_instit =  " . db_getsession("DB_instit") . "
		      AND (
                    rh05_seqpes is null 
                    or 
                    (date_part('MONTH',rh05_recis) = 01
                     and date_part('YEAR',rh05_recis) = 2019 
                    )
                    or
                    (date_part('MONTH',rh05_recis) = 12
                     and date_part('YEAR',rh05_recis) = 2017 
                    )
                  )
              AND   rh01_sicom = 1    
			  ";

        }


        $rsResult  = db_query($sSql);//echo $sSql;db_criatabela($rsResult);exit;


        for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

            $clviap = new cl_viap102019();
            $oDadosViap = db_utils::fieldsMemory($rsResult, $iCont);

            $clviap->si198_tiporegistro         = 10;
            $clviap->si198_nrocpfagentepublico  = $oDadosViap->z01_cgccpf;
            $clviap->si198_codmatriculapessoa	= $oDadosViap->z01_numcgm;
            $clviap->si198_codvinculopessoa     = $oDadosViap->rh01_regist;
            $clviap->si198_mes                  = $this->sDataFinal['5'].$this->sDataFinal['6'];
            $clviap->si198_inst               = db_getsession("DB_instit");


            $clviap->incluir(null);
            if ($clviap->erro_status == 0) {
                throw new Exception($clviap->erro_msg);
            }

        }

        db_fim_transacao();

        $oGerarViap = new GerarVIAP();
        $oGerarViap->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarViap->gerarDados();

    }

}
