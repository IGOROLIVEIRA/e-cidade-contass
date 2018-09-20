<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_pessoaflpgo102018_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2018/flpg/GerarPESSOA.model.php");


/**
 * gerar arquivo pessoal Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoPessoa extends SicomArquivoBase implements iPadArquivoBaseCSV {

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 0;

    /**
     *
     * NOme do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'PESSOA';

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

    }

    /**
     * selecionar os dados de indentificacao da remessa pra gerar o arquivo
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados(){

        /**
         * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
         */
        $clpessoa = new cl_pessoaflpgo102018();

        /**
         * excluir informacoes do mes selecionado
         */
        db_inicio_transacao();
        $result = $clpessoa->sql_record($clpessoa->sql_query(NULL,"*",NULL,"si193_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si193_inst = ".db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clpessoa->excluir(NULL,"si193_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si193_inst = ".db_getsession("DB_instit"));
            if ($clpessoa->erro_status == 0) {
                throw new Exception($clpessoa->erro_msg);
            }
        }

        if ($this->sDataFinal['5'].$this->sDataFinal['6'] != 01) {

            $sSql  = "
 (SELECT DISTINCT CASE
                      WHEN length(z01_cgccpf) < 11 THEN lpad(z01_cgccpf, 11, '0')
                      ELSE z01_cgccpf
                  END AS z01_cgccpf,
                  z01_nome,
                  z01_sexo,
                  CASE
                      WHEN z01_nasc IS NOT NULL THEN z01_nasc::varchar
                      ELSE rh01_nasc::varchar
                  END AS z01_nasc,
                  z01_ultalt,
                  z01_obs,
                  z01_cadast
  FROM cgm
  INNER JOIN rhpessoal ON rh01_numcgm = z01_numcgm
  WHERE (z01_cgccpf != '00000000000'
         AND z01_cgccpf != '00000000000000')
    AND (z01_cgccpf != ''
         AND z01_cgccpf IS NOT NULL)
    AND rh01_regist NOT IN
      (SELECT si195_codvinculopessoa
       FROM flpgo102018
       WHERE si195_mes < ".($this->sDataFinal['5'].$this->sDataFinal['6'])." AND   rh01_sicom = 1)
    AND z01_cgccpf NOT IN
      (SELECT si195_nrodocumento
       FROM flpgo102017
       inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
       inner JOIN rhpessoal ON rh01_numcgm = z01_numcgm
       WHERE rh01_admiss < '{$this->sDataInicial}' or z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
    AND z01_cgccpf NOT IN
      (SELECT si195_nrodocumento
       FROM flpgo102016
       inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
       inner JOIN rhpessoal ON rh01_numcgm = z01_numcgm
       WHERE rh01_admiss < '{$this->sDataInicial}' or z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
    AND z01_cgccpf NOT IN
      (SELECT si195_nrodocumento
       FROM flpgo102015
       inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
       inner JOIN rhpessoal ON rh01_numcgm = z01_numcgm
       WHERE rh01_admiss < '{$this->sDataInicial}' or z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
    AND z01_cgccpf NOT IN
      (SELECT si195_nrodocumento
       FROM flpgo102014
       inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
       inner JOIN rhpessoal ON rh01_numcgm = z01_numcgm
       WHERE rh01_admiss < '{$this->sDataInicial}' or z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
    AND z01_cgccpf NOT IN
      (SELECT si195_nrodocumento
       FROM flpgo102013
       inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
       inner JOIN rhpessoal ON rh01_numcgm = z01_numcgm
       WHERE rh01_admiss < '{$this->sDataInicial}' or z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
    AND z01_cgccpf NOT IN
      (SELECT si193_nrodocumento
       FROM pessoaflpgo102018
       inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
       inner JOIN rhpessoal ON rh01_numcgm = z01_numcgm
       WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
    AND z01_cgccpf NOT IN
      (SELECT si193_nrodocumento
       FROM pessoaflpgo102017
       inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
       inner JOIN rhpessoal ON rh01_numcgm = z01_numcgm
       WHERE rh01_admiss < '{$this->sDataInicial}' or z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
    AND z01_cgccpf NOT IN
      (SELECT si193_nrodocumento
       FROM pessoaflpgo102016
       inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
       inner JOIN rhpessoal ON rh01_numcgm = z01_numcgm
       WHERE rh01_admiss < '{$this->sDataInicial}' or z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
    AND z01_cgccpf NOT IN
      (SELECT si193_nrodocumento
       FROM pessoaflpgo102015
       inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
       inner JOIN rhpessoal ON rh01_numcgm = z01_numcgm
       WHERE rh01_admiss < '{$this->sDataInicial}' or z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
    AND z01_cgccpf NOT IN
      (SELECT si193_nrodocumento
       FROM pessoaflpgo102014
       inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
       inner JOIN rhpessoal ON rh01_numcgm = z01_numcgm
       WHERE rh01_admiss < '{$this->sDataInicial}' or z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
    AND z01_cgccpf NOT IN
      (SELECT si193_nrodocumento
       FROM pessoaflpgo102013
       inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
       inner JOIN rhpessoal ON rh01_numcgm = z01_numcgm
       WHERE rh01_admiss < '{$this->sDataInicial}' or z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1 )
    AND DATE_PART('YEAR',rh01_admiss) >= 2013
   AND z01_cadast <= '{$this->sDataFinal}'
   AND (rh01_admiss <= '{$this->sDataFinal}' OR z01_ultalt between '{$this->sDataInicial}' and '{$this->sDataFinal}' )

   AND rh01_instit = " . db_getsession("DB_instit") . " AND   rh01_sicom = 1)
   
UNION
SELECT DISTINCT CASE
                   WHEN length(z01_cgccpf) < 11 THEN lpad(z01_cgccpf, 11, '0')
                   ELSE z01_cgccpf
               END AS z01_cgccpf,
               z01_nome,
               z01_sexo,
               ' ' AS z01_nasc,
               z01_ultalt,
               z01_obs,
               z01_cadast
FROM cgm
INNER JOIN db_config ON db_config.numcgm = cgm.z01_numcgm
INNER JOIN rhpessoal ON rh01_numcgm = z01_numcgm
WHERE (z01_cgccpf != '00000000000'
      AND z01_cgccpf != '00000000000000')
 AND ((z01_cadast BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}')
      OR (z01_ultalt BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}'))
 AND (z01_cgccpf != ''
      AND z01_cgccpf IS NOT NULL)
 AND rh01_regist NOT IN
   (SELECT si195_codvinculopessoa
    FROM flpgo102018
    WHERE si195_mes < ".($this->sDataFinal['5'].$this->sDataFinal['6']).")
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102017
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102016
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102015
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102014
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102013
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102018
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102017
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102016
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102015
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102014
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102013
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND prefeitura = 't'
 AND z01_cadast >= '2013-01-01'
 AND z01_cadast <= '{$this->sDataFinal}'
 AND (rh01_admiss <= '{$this->sDataFinal}' OR z01_ultalt between '{$this->sDataInicial}' and '{$this->sDataFinal}')
 AND db_config.codigo = " . db_getsession("DB_instit") . "
 AND   rh01_sicom = 1
               ";

        } else {
            $sSql  = "SELECT z01_cgccpf,
      z01_nome,
      z01_sexo,
      CASE
          WHEN z01_nasc IS NOT NULL THEN z01_nasc
          ELSE rh01_nasc
      END AS z01_nasc,
      z01_ultalt,
      z01_obs,
      z01_cadast
FROM cgm
INNER JOIN rhpessoal ON rh01_numcgm = z01_numcgm
WHERE (z01_cgccpf != '00000000000'
      AND z01_cgccpf != '00000000000000')
 AND (z01_cgccpf != ''
      AND z01_cgccpf IS NOT NULL)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102017
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102016
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102015
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102014
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102013
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102018
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102017
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102016
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102015
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102014
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102013
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND DATE_PART('YEAR',rh01_admiss) >= 2013
 AND z01_cadast <= '{$this->sDataFinal}'
 AND (rh01_admiss <= '{$this->sDataFinal}' OR z01_ultalt between '{$this->sDataInicial}' and '{$this->sDataFinal}' )

 AND rh01_instit = " . db_getsession("DB_instit") . "
 AND   rh01_sicom = 1
UNION
SELECT z01_cgccpf,
      z01_nome,
      ' ' AS z01_sexo,
      z01_nasc,
      z01_ultalt,
      z01_obs,
      z01_cadast
FROM cgm
INNER JOIN db_config ON db_config.numcgm = z01_numcgm
JOIN rhpessoal ON rh01_numcgm = z01_numcgm
WHERE (z01_cgccpf != '00000000000'
      AND z01_cgccpf != '00000000000000')
 AND (z01_cgccpf != ''
      AND z01_cgccpf IS NOT NULL)
 AND prefeitura = 't'
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102017
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102016
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102015
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102014
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si195_nrodocumento
    FROM flpgo102013
    inner JOIN cgm ON si195_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102018
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102017
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102016
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102015
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1)
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102014
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}' AND   rh01_sicom = 1 )
 AND z01_cgccpf NOT IN
   (SELECT si193_nrodocumento
    FROM pessoaflpgo102013
    inner JOIN cgm ON si193_nrodocumento = z01_cgccpf
    JOIN rhpessoal ON rh01_numcgm = z01_numcgm
    WHERE z01_ultalt < '{$this->sDataInicial}')
 AND z01_cadast >= '2013-01-01'
 AND z01_cadast <= '{$this->sDataFinal}'
 AND (rh01_admiss <= '{$this->sDataFinal}' OR z01_ultalt between '{$this->sDataInicial}' and '{$this->sDataFinal}')
 AND db_config.codigo = " . db_getsession("DB_instit") .
                " 
                AND   rh01_sicom = 1";
        }

        $rsResult  = db_query($sSql);//echo $sSql;db_criatabela($rsResult);exit;
        $aPessoas    =  array();
        $aCpfPessoas = array("00000000000","00000000000000","11111111111","11111111111111","22222222222","22222222222222","33333333333","33333333333333",
            "44444444444","4n4444444444444","55555555555","55555555555555","66666666666","66666666666666","77777777777","77777777777777","88888888888","88888888888888",
            "99999999999","99999999999999");
        $what = array("'","°",chr(13),chr(10), 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','Ã','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );

        // matriz de saída
        $by   = array('','','','', 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','E','I','O','U','n','n','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ' );
        for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

            $clpessoa = new cl_pessoaflpgo102018();
            $oDados = db_utils::fieldsMemory($rsResult, $iCont);


            if (in_array($oDados->z01_cgccpf, $aCpfPessoas)) {
                continue;
            }

            if(($this->sDataFinal['5'].$this->sDataFinal['6']) != '01' && db_getsession("DB_anousu") != 2018){

                if ($oDados->z01_ultalt >= $this->sDataInicial && $oDados->z01_ultalt <= $this->sDataFinal) {

                    $sTipoCadastro = 1;
                    $sJustificativaalteracao = ' ';

                } else {

                    $sSqlAlt = "SELECT
         z01_numcgm,
         case
              when z01_nome <> z05_nome then ' nome '
              when z01_sexo <> z05_sexo then ' sexo '
              when z01_nasc <> z05_nasc then ' nasc '
              when z01_cgccpf <> z05_cgccpf then ' cpf '
              else ''
              end as justificativa
         FROM cgm
         JOIN cgmalt ON z01_numcgm = z05_numcgm
         WHERE (z01_nome <> z05_nome
                OR z01_sexo <> z05_sexo
                OR z01_nasc <> z05_nasc
                OR z01_cgccpf <> z05_cgccpf)
           AND z01_cgccpf = '$oDados->z01_cgccpf' ";

                    $rsResultAlt = db_query($sSqlAlt);
                    $sJustificativaalteracao = '';
                    if(pg_num_rows($rsResultAlt) > 0 ) {

                        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsResultAlt); $iCont2++) {

                            $oDadosAlt = db_utils::fieldsMemory($rsResultAlt, $iCont2);

                            $sTipoCadastro = 2;
                            $sJustificativaalteracao .= ' '.$oDadosAlt->justificativa;

                        }

                    } else {

                        $sTipoCadastro = 1;
                        $sJustificativaalteracao = '';

                    }

                }
            }else{
                if(($this->sDataFinal['5'].$this->sDataFinal['6']) != '01'){
                    if ($oDados->z01_ultalt >= $this->sDataInicial && $oDados->z01_ultalt <= $this->sDataFinal) {
                        $sTipoCadastro = 1;
                        $sJustificativaalteracao = ' ';
                    } else {

                        $sSqlAlt = "SELECT
           z01_numcgm,
           case
                when z01_nome <> z05_nome then ' nome '
                when z01_sexo <> z05_sexo then ' sexo '
                when z01_nasc <> z05_nasc then ' nasc '
                when z01_cgccpf <> z05_cgccpf then ' cpf '
                else ''
                end as justificativa
           FROM cgm
           JOIN cgmalt ON z01_numcgm = z05_numcgm
           WHERE (z01_nome <> z05_nome
                  OR z01_sexo <> z05_sexo
                  OR z01_nasc <> z05_nasc
                  OR z01_cgccpf <> z05_cgccpf)
             AND z01_cgccpf = '$oDados->z01_cgccpf' ";

                        $rsResultAlt = db_query($sSqlAlt);
                        $sJustificativaalteracao = '';
                        if(pg_num_rows($rsResultAlt) > 0 ) {

                            for ($iCont2 = 0; $iCont2 < pg_num_rows($rsResultAlt); $iCont2++) {

                                $oDadosAlt = db_utils::fieldsMemory($rsResultAlt, $iCont2);

                                $sTipoCadastro = 2;
                                $sJustificativaalteracao .= ' '.$oDadosAlt->justificativa;

                            }

                        }else{
                            $sTipoCadastro = 1;
                            $sJustificativaalteracao = '';
                        }
                    }
                }else{
                    $sTipoCadastro = 1;
                    $sJustificativaalteracao = ' ';
                }
            }
            $aHash = $oDados->z01_cgccpf;

            if(!isset($aPessoas[$aHash])) {

                $clpessoa->si193_tiporegistro           = 10;
                $clpessoa->si193_tipodocumento          = strlen($oDados->z01_cgccpf) <= 11 ? 1 : 2;
                $clpessoa->si193_nrodocumento           = $oDados->z01_cgccpf;
                $clpessoa->si193_nome                   = trim(preg_replace("/[^a-zA-Z0-9 ]/", "",substr(str_replace($what, $by, $oDados->z01_nome), 0, 200)));
                $clpessoa->si193_indsexo                = $oDados->z01_sexo;
                $clpessoa->si193_datanascimento         = $oDados->z01_nasc;
                $clpessoa->si193_tipocadastro           = $sTipoCadastro;
                $clpessoa->si193_justalteracao          = $sJustificativaalteracao;
                $clpessoa->si193_mes                    = $this->sDataFinal['5'].$this->sDataFinal['6'];
                $clpessoa->si193_inst                   = db_getsession("DB_instit");

                $clpessoa->incluir(null);
                if ($clpessoa->erro_status == 0) {
                    throw new Exception($clpessoa->erro_msg);
                }
                $aPessoas[$aHash] = $clpessoa;
            }


        }
        db_fim_transacao();

        $oGerarPESSOA       = new GerarPESSOA();
        $oGerarPESSOA->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarPESSOA->gerarDados();

    }

}

