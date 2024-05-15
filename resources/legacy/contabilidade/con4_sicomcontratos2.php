<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_contratos_classe.php");
include("classes/db_aditivoscontratos_classe.php");
$clcontratos = new cl_contratos;
$claditivoscontratos = new cl_aditivoscontratos;
db_postmemory($HTTP_POST_VARS);

$sSql  = "SELECT * FROM db_config ";
$sSql .= "  WHERE prefeitura = 't'";

$rsInst = db_query($sSql);
$sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;

$sCnpj  = '01612477000190';

$sArquivo         = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomcontratos.xml";
echo $sArquivo;
$sArquivoCompl    = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdadoscompllicitacao.xml";
$sArquivoAditivos = "legacy_config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomaditivoscontratos.xml";
/*
 * inserir ou atualizar registro do xml
 */
$iCTRL = 0;
if (isset($_POST['btnImportar'])){

  $iCTRL = 1;

  if (!file_exists($sArquivo)) {

    echo
        "<script>alert('Não existe arquivo xml')</script>";
         db_redireciona('con4_sicomcontratos.php');

  }else{

    $sTextoXml      = file_get_contents($sArquivo);
    $sTextoComplXml = file_get_contents($sArquivoCompl);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument2 = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oDOMDocument2->loadXML($sTextoComplXml);

  }

  $oDOMDocument->formatOutput = true;
  $oDados      = $oDOMDocument->getElementsByTagName('contrato');
  $oDadosCompl = $oDOMDocument2->getElementsByTagName('dadoscompllicitacao');

  $sSql = "select * from db_departorg limit 1";
  $rsUnidade = db_query($sSql);
  $iUnidade  = db_utils::fieldsMemory($rsUnidade,0)->db01_unidade;

  /*
  * Exclui contratos e aditivos
  */

  foreach ($oDados as $oDado) {

    db_inicio_transacao();
    $nroContrato = explode("/", $oDado->getAttribute('nroContrato') );
    $result      = $clcontratos->sql_record($clcontratos->sql_query(null,'*',null,'si172_nrocontrato = '.$nroContrato[0]));
    $sequencial  = db_utils::fieldsMemory($result,0)->si172_sequencial;
    $result = $claditivoscontratos->sql_record($claditivoscontratos->sql_query(null,'*',null,'si174_nrocontrato = '.$sequencial));
    if (pg_num_rows($result) > 0) {
      $claditivoscontratos->excluir(null,'si174_nrocontrato = '.$sequencial);
    }
    $clcontratos->excluir(null,'si172_sequencial = '.$sequencial );
    db_fim_transacao();
  }

  foreach ($oDados as $oDado) {

      db_inicio_transacao();



      if (!$oDado->getAttribute('nroProcessoLicitatorio') ) {
        $iLicitacoes[$oDado->getAttribute('nroProcessoLicitatorio')] = $oDado->getAttribute('nroContrato');
        $sProcadmin = 'vazio';
        $i++;
      } else {

        $sSql = "select * from liclicita where l20_codigo = ".$oDado->getAttribute('nroProcessoLicitatorio');
        $rsProcadmin = db_query($sSql);
        $sProcadmin  =  db_utils::fieldsMemory($rsProcadmin,0)->l20_procadmin;
        if($sProcadmin == "" || $sProcadmin == null){
          $iLicitacoes[$oDado->getAttribute('nroProcessoLicitatorio')] = $oDado->getAttribute('nroContrato');
          $sProcadmin = 'vazio';
          $i++;
        }

      }

      $aCaracteres = array('\"', "\'");

      $nroContrato = explode("/", $oDado->getAttribute('nroContrato') );
      $clcontratos->si172_nrocontrato                = $nroContrato[0];
      $clcontratos->si172_exerciciocontrato          = db_getsession("DB_anousu");
      $clcontratos->si172_licitacao                  = $oDado->getAttribute('nroProcessoLicitatorio');
      $clcontratos->si172_dataassinatura             = $oDado->getAttribute('dataAssinatura');

      $sSql    = "select * from cgm inner join pcorcamforne on pc21_numcgm = z01_numcgm where z01_cgccpf = '". $oDado->getAttribute('nroDocumento') ."' ";
      $rsForn  = db_query($sSql);
      $iForn   =  db_utils::fieldsMemory($rsForn,0)->pc21_numcgm;

      $clcontratos->si172_fornecedor                 = $iForn;//$oDado->getAttribute('');

      $clcontratos->si172_contdeclicitacao           = 2;
      $clcontratos->si172_codunidadesubresp          = $iUnidade; //db_departorg limit 1
      $clcontratos->si172_nroprocesso                = $sProcadmin; //l20_procadmin
      $clcontratos->si172_exercicioprocesso          = db_getsession("DB_anousu"); //db_anousu

      foreach ($oDadosCompl as $oDadoCompl) {

        if ($oDado->getAttribute('nroProcessoLicitatorio') == $oDadoCompl->getAttribute('nroProcessoLicitatorio')) {

            if ($oDadoCompl->getAttribute('justificativa') != null || $oDadoCompl->getAttribute('justificativa') != "" ) {
              $clcontratos->si172_tipoprocesso               = $oDadoCompl->getAttribute('tipoProcesso'); //olhar na nova tela, codigo do tribunal
            } else {
              $clcontratos->si172_tipoprocesso               = 1; //olhar na nova tela, codigo do tribunal
            }

        }

      }

      $clcontratos->si172_naturezaobjeto             = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('naturezaObjeto')));
      $clcontratos->si172_objetocontrato             = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('objetoContrato')));
      $clcontratos->si172_tipoinstrumento            = $oDado->getAttribute('tipoInstrumento');
      $clcontratos->si172_datainiciovigencia         = $oDado->getAttribute('dataInicioVigencia');
      $clcontratos->si172_datafinalvigencia          = $oDado->getAttribute('dataFinalVigencia');
      $clcontratos->si172_vlcontrato                 = str_replace(",", ".",str_replace("-", "0",$oDado->getAttribute('vlContrato')));
      $clcontratos->si172_formafornecimento          = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('formaFornecimento')));
      $clcontratos->si172_formapagamento             = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('formaPagamento')));
      $clcontratos->si172_prazoexecucao              = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('prazoExecucao')));
      $clcontratos->si172_multarescisoria            = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('multaRescisoria')));
      $clcontratos->si172_multainadimplemento        = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('multaInadimplemento')));
      $clcontratos->si172_garantia                   = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('garantia')));
      $clcontratos->si172_cpfsignatariocontratante   = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('cpfsignatarioContratante')));
      $clcontratos->si172_datapublicacao             = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('dataPublicacao')));
      $clcontratos->si172_veiculodivulgacao          = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('veiculoDivulgacao')));
      $clcontratos->si172_instit                     = $oDado->getAttribute('instituicao');

      $clcontratos->incluir(null);

      db_fim_transacao();

  }

  /**
  * ADITIVOS
  */

  if (!file_exists($sArquivoAditivos)) {

    echo
        "<script>alert('Não existe arquivo xml dos aditivos')</script>";


  }else{

    $oDOMDocument3 = new DOMDocument();
    $sTextoXml     = file_get_contents($sArquivoAditivos);
    $oDOMDocument3->loadXML($sTextoXml);

    $oDOMDocument3->formatOutput = true;
    $oDados      = $oDOMDocument3->getElementsByTagName('aditivoscontrato');

    foreach ($oDados as $oDado) {

        db_inicio_transacao();
        $nroContrato = explode("/", $oDado->getAttribute('nroContrato'));

        $rsChave  =  $clcontratos->sql_record($clcontratos->sql_query(null,'*',null,'si172_nrocontrato = '.$nroContrato[0]));
        $iChave   =  db_utils::fieldsMemory($rsChave,0)->si172_sequencial;

        $claditivoscontratos->si174_codunidadesub               = $iUnidade;
        $claditivoscontratos->si174_nrocontrato                 = $iChave;
        $claditivoscontratos->si174_dataassinaturacontoriginal  = $oDado->getAttribute('dataAssinaturaContOriginal');
        $claditivoscontratos->si174_nroseqtermoaditivo          = $oDado->getAttribute('nroSeqTermoAditivo');
        $claditivoscontratos->si174_dataassinaturatermoaditivo  = $oDado->getAttribute('dataAssinaturaTermoAditivo');
        $claditivoscontratos->si174_tipoalteracaovalor          = $oDado->getAttribute('nroContrato');
        $claditivoscontratos->si174_tipotermoaditivo            = $oDado->getAttribute('tipoTermoAditivo');
        $claditivoscontratos->si174_dscalteracao                = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('dscAlteracao')));
        $claditivoscontratos->si174_novadatatermino             = $oDado->getAttribute('novaDataTermino');
        $claditivoscontratos->si174_valoraditivo                = str_replace(",", ".",str_replace("-", "0",$oDado->getAttribute('valorAditivo')));
        $claditivoscontratos->si174_datapublicacao              = $oDado->getAttribute('dataPublicacao');
        $claditivoscontratos->si174_veiculodivulgacao           = str_replace($aCaracteres, "", utf8_decode($oDado->getAttribute('veiculoDivulgacao')));
        $claditivoscontratos->si174_instit                      = $oDado->getAttribute('instituicao');

        $claditivoscontratos->incluir(null);

        db_fim_transacao($sqlerro);

    }

  }

}

?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
      ?>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="20" onLoad="a=1" >

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
  <?
  include("forms/frmsicomcontratos2.php");

  ?>

    </center>
  </td>
  </tr>
</table>
</body>
</html>

<?
if ($iCTRL == 1) {

    echo 'problema em alguns contratos | licitação -> contrato | <br>';
    print_r($iLicitacoes);
     echo
        "<script>
        alert('Importação concluida com sucesso');
        document.form1.btnImportar.disabled = true;
        </script>";

}

?>
