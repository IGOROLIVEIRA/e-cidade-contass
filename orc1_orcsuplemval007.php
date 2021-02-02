<?
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


require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_liborcamento.php");
require_once("dbforms/db_funcoes.php");
require_once("dbforms/db_classesgenericas.php");
require_once("classes/db_orcsuplem_classe.php");
require_once("classes/db_orcprojeto_classe.php");
require_once("classes/db_orcsuplemval_classe.php");
require_once("classes/db_orcdotacao_classe.php");   // instancia da classe dotação
require_once("classes/db_orcreceita_classe.php"); // receita
require_once("classes/db_orcorgao_classe.php"); // receita
require_once("classes/db_orcparametro_classe.php");

db_app::import("orcamento.suplementacao.*");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clorcsuplemval = new cl_orcsuplemval;
$clorcdotacao   = new cl_orcdotacao;  // instancia da classe dotação
$clorcsuplem    = new cl_orcsuplem;
$clorcorgao     = new cl_orcorgao;
$clorcprojeto   = new cl_orcprojeto;
$clorcparametro           = new cl_orcparametro();

$clorcsuplem->rotulo->label();
$clorcsuplemval->rotulo->label();
$clorcorgao->rotulo->label();
$clorcdotacao->rotulo->label();

$op =1 ;
$db_opcao = 1;
$db_botao = true;
$anousu = db_getsession("DB_anousu");
$o39_codproj = (isset($o39_codproj)&&!empty($o39_codproj))?$o39_codproj:'null';

/*OC10197*/
$result=$clorcparametro->sql_record($clorcparametro->sql_query_file($anousu,"o50_controlafote1017,o50_controlafote10011006"));
if ($clorcparametro->numrows > 0 ){
    db_fieldsmemory($result,0);
}

/**
 * verifica o tipo da Suplementacao
 */
$sSqlDadosProjeto = $clorcprojeto->sql_query_projeto($o39_codproj, "o138_sequencial,o39_usalimite");
$rsDadosProjeto   = $clorcprojeto->sql_record($sSqlDadosProjeto);
$oDadosProjeto    = db_utils::fieldsMemory($rsDadosProjeto, 0);
//------------------------------------------
if (isset($pesquisa_dot) && $o47_coddot!=""){

    // foi clicado no botão "pesquisa" da tela
    $res = $clorcdotacao->sql_record($clorcdotacao->sql_query(db_getsession("DB_anousu"),$o47_coddot));
    if ($clorcdotacao->numrows > 0 ){

        db_fieldsmemory($res,0); // deve existir 1 registro

        $resdot= db_dotacaosaldo(8,2,2,"true","o58_coddot=$o47_coddot",db_getsession("DB_anousu"),$anousu.'-01-01',$anousu.'-12-31');
        db_fieldsmemory($resdot,0);
        // $atual_menos_reservado
    }
}
//------------------------------------------
$limpa_dados = false;

if (isset($incluir)) {

    $sSqlValorTotalOrcamento  = "select sum(o58_valor) as valororcamento ";
    $sSqlValorTotalOrcamento .= "  from orcdotacao ";
    $sSqlValorTotalOrcamento .= " where o58_anousu = ".db_getsession("DB_anousu");
    $rsValorOrcamento        = db_query($sSqlValorTotalOrcamento);
    $nValorOrcamento         = 0;
    if (pg_num_rows($rsValorOrcamento) > 0) {
        $nValorOrcamento = db_utils::fieldsMemory($rsValorOrcamento, 0)->valororcamento;
    }
    /**
     * Verificamos se existe parametro para o orcamento no ano
     */
    $sqlerro        = false;
    $limpa_dados    = true;
    $nPercentualLoa = 0;
    $aParametro = db_stdClass::getParametro("orcsuplementacaoparametro", array(db_getsession("DB_anousu")));
    if (count($aParametro) > 0) {
        $nPercentualLoa = $aParametro[0]->o134_percentuallimiteloa;
    } else {

        db_msgbox("Parametros das suplementações não configurados.");
        $sqlerro     = true;
    }
    $limiteloa            = ($nPercentualLoa*$nValorOrcamento)/100;
    $sSqlSuplementacoes   = $clorcsuplem->sql_query(null,"*","o46_codsup","orcprojeto.o39_codproj= $o39_codproj");
    $rsSuplementacoes     = $clorcsuplem->sql_record($sSqlSuplementacoes);
    $aSuplementacao       = db_utils::getCollectionByRecord($rsSuplementacoes);
    $valorutilizado       = 0;
    if ($oDadosProjeto->o39_usalimite == 't') {

        foreach ($aSuplementacao as $oSuplem) {

            $oSuplementacao = new Suplementacao($oSuplem->o46_codsup);
            $valorutilizado += $oSuplementacao->getvalorSuplementacao();
        }
        if ($valorutilizado + $o47_valor > $limiteloa) {

            $sMsgLimite  = "Limite de {$nPercentualLoa} do LOA foi ultrapassado.\\nNão poderá ser realizado a suplementação.\\n";
            $sMsgLimite .= "Valor Orçamento: ".trim((db_formatar($nValorOrcamento, "f")))."\\n";
            $sMsgLimite .= "Valor Limite: ".trim((db_formatar($limiteloa, "f")))."\\n";
            $sMsgLimite .= "Valor Utilizado: ".trim((db_formatar($valorutilizado, "f")))."\\n";
            db_msgbox($sMsgLimite);
            $sqlerro     = true;
            $limpa_dados = false;
        }
    }

    if ( ($tiposup == 1003 || $tiposup == 1008) && substr($o58_codigo, 0, 1) != 2 ) {
    
        db_msgbox("Usuário, inclusão abortada. Dotação incompatível com o tipo de suplementação utilizada");
        $sqlerro = true;
        $limpa_dados = false;
        
    }

    if ( $tiposup == 1004 || $tiposup == 1009 ) {
    
        $sSqlFonte  = $clorcsuplemval->sql_query($o46_codsup,db_getsession("DB_anousu"),null, "o58_codigo");
        $rsFonte    = db_query($sSqlFonte);

        if (pg_num_rows($rsFonte) > 0) {
        
            if ( $o58_codigo != db_utils::fieldsMemory($rsFonte, 0)->o58_codigo ) {

                db_msgbox("Não é possível incluir dotações com fontes diferentes neste lançamento de suplementação. Finalize o lançamento anterior e em seguida lance uma nova suplementação");
                $sqlerro = true;
                $limpa_dados = false;

            }
        
        }

    }

    // pressionado botao incluir na tela
    db_inicio_transacao();
    if ((isset($o47_coddot)  && $o47_coddot != "") && !$sqlerro) {
        $clorcsuplemval->o47_valor          = $o47_valor;
        $clorcsuplemval->o47_anousu         = db_getsession("DB_anousu");
        $clorcsuplemval->o47_concarpeculiar = "{$o58_concarpeculiar}";
        /*OC2785*/
        $motivo  = db_query("
    select o50_motivosuplementacao from orcparametro where o50_anousu = ".db_getsession("DB_anousu"));
        $aMotivo = db_utils::getCollectionByRecord($motivo);
        if ($aMotivo[0]->o50_motivosuplementacao == 't') {
            $clorcsuplemval->o47_motivo = "{$o47_motivo}";
        }
        /*OC5813*/
        //valida se a dotação já foi usada numa operacao contrária

        $sSuplementacao = $clorcsuplemval->sql_record("select * from orcsuplemval join orcsuplem on o47_codsup=o46_codsup where o46_codlei = {$o39_codproj} and o47_coddot = {$o47_coddot} ");
        if(pg_num_rows($sSuplementacao)>0){
            $aSuple = db_utils::getCollectionByRecord($sSuplementacao);
            foreach($aSuple as $oSupl){
                //existe uma reducao que agora está sendo suplementada
                if($oSupl->o47_valor < 0){
                    $sqlerro = true;
                    db_msgbox('Usuário, inclusão abortada. Esta dotação já foi inserida em outra suplementação neste mesmo projeto!');
                    $limpa_dados = false;
                    break;
                }else{
                    $sqlerro = false;
                }
            }
        }else{
            $sqlerro = false;
        }
        /*FIM OC5813*/
        /*OC5815*/

        /*todo estrutural anterior à fonte de recurso deve ser idêntico para a dotação que suplementa e para a dotação que reduz*/

        if($tiposup=='1017'){
            $sSqlEstruturalDotacaoEnviada = "SELECT fc_estruturaldotacao(".db_getsession('DB_anousu').",o58_coddot) AS dl_estrutural
FROM orcdotacao d
INNER JOIN orcprojativ p ON p.o55_anousu = ".db_getsession('DB_anousu')."
AND p.o55_projativ = d.o58_projativ
INNER JOIN orcelemento e ON e.o56_codele = d.o58_codele
AND o56_anousu = o58_anousu
WHERE o58_anousu=".db_getsession('DB_anousu')."
  AND o58_coddot = {$o47_coddot}";

            $oEstruturalDotacaoEnviada = db_utils::fieldsMemory(db_query($sSqlEstruturalDotacaoEnviada));

            $sSqlestrututural = "SELECT fc_estruturaldotacao(".db_getsession('DB_anousu').",o58_coddot) AS dl_estrutural,
  o56_elemento,
  o55_descr::text,
  o56_descr,
  o58_coddot,
  o58_instit,
  o46_codlei,
  o46_codsup,
  o46_tiposup
  FROM orcsuplemval
  JOIN orcdotacao ON o47_anousu=o58_anousu
  AND o47_coddot=o58_coddot
  JOIN orcsuplem ON o47_codsup=o46_codsup
  INNER JOIN orcprojativ ON o55_anousu = ".db_getsession('DB_anousu')."
  AND o55_projativ = o58_projativ
  INNER JOIN orcelemento e ON o56_codele = o58_codele
  AND o56_anousu = o58_anousu
  WHERE o46_codlei = {$o39_codproj}
  AND o46_codsup = {$o46_codsup}
  AND o46_tiposup = {$tiposup}
  AND o58_anousu = ".db_getsession('DB_anousu')."
  ";

            if(pg_num_rows(db_query($sSqlestrututural))>0){
                $oEstruturalSupl = db_query($sSqlestrututural);
                $oEstruturalSupl = db_utils::fieldsMemory($oEstruturalSupl);
                if(!(substr($oEstruturalDotacaoEnviada->dl_estrutural, 0,36) ==  substr($oEstruturalSupl->dl_estrutural, 0,36) && substr($oEstruturalDotacaoEnviada->dl_estrutural, 37,4) !=  substr($oEstruturalSupl->dl_estrutural, 37,4))){
                    $sqlerro = true;
                    db_msgbox("Usuário, inclusão abortada. Dotação incompatível com o tipo de suplementação utilizada");
                    $limpa_dados = false;

                }
            }
            if($o50_controlafote1017 == 't') {
                /*valida fonte (100,101,102,118,119) OC 9112 */
                $dotacoes = array(100,101,102,118,119);
                if(!in_array(substr($oEstruturalDotacaoEnviada->dl_estrutural, 38),$dotacoes) ){
                    $sqlerro = true;
                    db_msgbox("Usuário, inclusão abortada. Dotação incompatível com o tipo de suplementação utilizada");
                    $limpa_dados = false;
                }
            }
        }
        /*verifica se ja existe alguma dotacao cadastrada OC 9039*/
        $tipossupvalida = array(1001,1006,1011,1012,1013,1014,1015,1016,1017,1020,1021,1022,1023);
        if (in_array($tiposup , $tipossupvalida)) {
            $sql = "select * from orcsuplemval where o47_codsup = {$o46_codsup}";
            if (pg_num_rows(db_query($sql)) >= 1) {
                db_msgbox("Usuário: Não é possível inserir mais de uma dotação a ser suplementada para o mesmo código de suplementação.");
                $sqlerro = true;
                $limpa_dados = false;
                echo "<script>
                        parent.mo_camada('reducao');
                    </script>";
            }
        }
        if(pg_num_rows($sSuplementacao) == 0 || $sqlerro == false){
            $clorcsuplemval->incluir($o46_codsup,db_getsession("DB_anousu"),$o47_coddot);
            if ($clorcsuplemval->erro_status == 0){
                $sqlerro = true;
                db_msgbox($clorcsuplemval->erro_msg);
                $limpa_dados = false;
            }
            echo "<script>
                        parent.mo_camada('reducao');
                    </script>";
        }
    } else if (isset($o07_sequencial) && $o07_sequencial != ""  && !$sqlerro) {

        /**
         * incluimos a projecao para criarmos a suplementação
         */
        $oDaoDespesaPPA = db_utils::getDao("orcsuplemdespesappa");
        $oDaoDespesaPPA->o136_orcsuplem            = $o46_codsup;
        $oDaoDespesaPPA->o136_ppaestimativadespesa = $o07_sequencial;
        $oDaoDespesaPPA->o136_valor                = abs($o47_valor);
        $oDaoDespesaPPA->o136_concarpeculiar       = $o58_concarpeculiar;
        $oDaoDespesaPPA->incluir(null);
        if ($oDaoDespesaPPA->erro_status == 0) {

            $sqlerro = true;
            db_msgbox($oDaoDespesaPPA->erro_msg);
            $limpa_dados = false;
        }
    }
    db_fim_transacao($sqlerro);

} elseif(isset($opcao) && $opcao=="excluir" ){



    $limpa_dados = true;
    // clicou no exlcuir, já exlcui direto, nem confirma nada
    db_inicio_transacao();
    $sqlerro  = false;
    if ($tipo == 1) {

        $clorcsuplemval->excluir($o46_codsup,$anousu,$o47_coddot);
        if ($clorcsuplemval->erro_status == 0){
            $sqlerro = true;
            $limpa_dados = false;
        }
        db_msgbox($clorcsuplemval->erro_msg);
    } else {

        $oDaoDespesaPPA = db_utils::getDao("orcsuplemdespesappa");
        $oDaoDespesaPPA->excluir($o47_coddot);
        if ($oDaoDespesaPPA->erro_status == 0) {

            $sqlerro     = true;
            $limpa_dados = false;
        }
        db_msgbox($oDaoDespesaPPA->erro_msg);
    }
    db_fim_transacao($sqlerro);

}
if ($limpa_dados ==true) {

    $o47_coddot         = "";
    $o58_orgao          = "";
    $o58_concarpeculiar = "";
    $o40_descr          = "";
    $o56_elemento       = "";
    $o56_descr          = "";
    $o58_codigo         = "";
    $o15_descr          = "";
    $o47_valor          = "";
    /*OC2785*/
    $motivo  = db_query("
  select o50_motivosuplementacao from orcparametro where o50_anousu = ".db_getsession("DB_anousu"));
    $aMotivo = db_utils::getCollectionByRecord($motivo);
    if ($aMotivo[0]->o50_motivosuplementacao == 't') {
        $o47_motivo      = "";
    }

    $o07_sequencial     = "";
    $c58_descr          = "";
    $atual_menos_reservado = "";
}

// --------------------------------------
// calcula total das reduções
$oSuplementacao = new Suplementacao($o46_codsup);
$soma_suplem    = $oSuplementacao->getvalorSuplementacao();
// --------------------------------------


?>
    <html>
    <head>
        <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="Expires" CONTENT="0">
        <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
        <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
        <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
        <link href="estilos.css" rel="stylesheet" type="text/css">
    </head>
    <body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
    <table width="480" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
                <center>
                    <?
                    include("forms/db_frmorcsuplemval.php");
                    ?>
                </center>
            </td>
        </tr>
    </table>
    </body>
    </html>
<?

if(isset($incluir) || isset($alterar) || isset($excluir)){
    if($clorcsuplemval->erro_status=="0"){
        $clorcsuplemval->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clorcsuplemval->erro_campo!=""){
            echo "<script> document.form1.".$clorcsuplemval->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clorcsuplemval->erro_campo.".focus();</script>";
        };
    }else{
        $clorcsuplemval->erro(true,false);
    };
};

?>