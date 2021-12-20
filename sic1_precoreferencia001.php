<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_precoreferencia_classe.php");
include("classes/db_itemprecoreferencia_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_condataconf_classe.php");
include("classes/db_liccomissaocgm_classe.php");
require("libs/db_utils.php");
db_postmemory($HTTP_POST_VARS);
$oPost = db_utils::postMemory($_POST);

$clprecoreferencia     = new cl_precoreferencia;
$clitemprecoreferencia = new cl_itemprecoreferencia;
$clcondataconf = new cl_condataconf;
$clliccomissaocgm      = new cl_liccomissaocgm();

$db_opcao = 1;
$db_botao = true;
$respCotacaocodigoV = $respCotacaocodigo;
$respOrcacodigoV = $respOrcacodigo;

$respCotacaonomeV = $respCotacaonome;
$respOrcanomeV = $respOrcanome;

if (isset($incluir)) {
    db_inicio_transacao();
    $clprecoreferencia->si01_tipoCotacao  = 3;
    $clprecoreferencia->si01_tipoOrcamento  = 4;
    $clprecoreferencia->si01_numcgmCotacao = $respCotacaocodigo;
    $clprecoreferencia->si01_numcgmOrcamento = $respOrcacodigo;
    $datesistema = date("d/m/Y", db_getsession('DB_datausu'));
    if ($si01_datacotacao > $datesistema) {
        $msg = "Data da Cotação maior que data do Sistema";
        unset($incluir);
        db_msgbox($msg);
    } else {
        $processoValidado = true;
        $sqlProc = $clprecoreferencia->sql_query("", 'si01_processocompra', null, "si01_processocompra='" . $si01_processocompra . "'");
        $procReferencia = db_query($sqlProc);
        $procReferencia = db_utils::fieldsMemory($procReferencia, 0);

        if ($procReferencia->si01_processocompra != '') {
            echo "<script>alert('Já existe preço referência para esse processo de compra');</script>";
            $processoValidado = false;
        }  

        if($processoValidado==true){
            if ($oPost->si01_cotacaoitem == 0) {
                echo "<script>alert('Selecione o tipo de cotação por item!');</script>";
                $processoValidado = false;
            } 
    
        }
        
        if(!empty($si01_datacotacao)){
            $anousu = db_getsession('DB_anousu');
            $instituicao = db_getsession('DB_instit');
            $datacotacao = strtotime(implode("-",(array_reverse(explode("/",$si01_datacotacao)))));
            $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu,$instituicao,"c99_datapat",null,null));
            $c99_datapat = strtotime(db_utils::fieldsMemory($result, 0)->c99_datapat);
            if ($datacotacao <= $c99_datapat) {
                echo "<script>alert('O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.');</script>";
                $processoValidado  = false;
            }
        }

        if ($processoValidado) {
            $clprecoreferencia->incluir(null);
        }
    }

    if ($clprecoreferencia->erro_status != 0 && $processoValidado) {

        if ($si01_tipoprecoreferencia == '1') {
            $sFuncao = "avg";
        } else if ($si01_tipoprecoreferencia == '2') {
            $sFuncao = "max";
        } else {
            $sFuncao = "min";
        }

        

        $sSql = "select pc23_orcamitem,count(pc23_vlrun) as valor
                      from pcproc
                      join pcprocitem on pc80_codproc = pc81_codproc
                      join pcorcamitemproc on pc81_codprocitem = pc31_pcprocitem
                      join pcorcamitem on pc31_orcamitem = pc22_orcamitem
                      join pcorcamval on pc22_orcamitem = pc23_orcamitem
                      where pc80_codproc = $si01_processocompra and pc23_vlrun != 0 group by pc23_orcamitem";

        $rsResult = db_query($sSql);
        
        
        $arrayValores = array(); $cont = 0;
       
        for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

            $oItemOrc = db_utils::fieldsMemory($rsResult, $iCont);

            if($oPost->si01_cotacaoitem==1){
                if($oItemOrc->valor>=1){
                    
                    $arrayValores[$cont] = $oItemOrc->pc23_orcamitem;
                    $cont++;
                }

            }else if($oPost->si01_cotacaoitem==2){
                if($oItemOrc->valor>=2){
                    
                    $arrayValores[$cont] = $oItemOrc->pc23_orcamitem;
                    $cont++;
                }
                
            }else if($oPost->si01_cotacaoitem==3){
                if($oItemOrc->valor>=3){
                    
                    $arrayValores[$cont] = $oItemOrc->pc23_orcamitem;
                    $cont++;
                }
                
            }         
            
        }


        for ($iCont = 0; $iCont < $cont; $iCont++) {
            $valor = $arrayValores[$iCont];
            $sSql = "select pc23_orcamitem,round($sFuncao(pc23_vlrun),4) as valor,
                    round($sFuncao(pc23_perctaxadesctabela),2) as percreferencia1,
                    round($sFuncao(pc23_percentualdesconto),2) as percreferencia2
                      from pcproc
                      join pcprocitem on pc80_codproc = pc81_codproc
                      join pcorcamitemproc on pc81_codprocitem = pc31_pcprocitem
                      join pcorcamitem on pc31_orcamitem = pc22_orcamitem
                      join pcorcamval on pc22_orcamitem = pc23_orcamitem
                      where pc80_codproc = $si01_processocompra and pc23_orcamitem = $valor group by pc23_orcamitem";

                      $rsResultee = db_query($sSql);

                      $oItemOrc = db_utils::fieldsMemory($rsResultee, 0);

            $clitemprecoreferencia->si02_vlprecoreferencia = $oItemOrc->valor;
            $clitemprecoreferencia->si02_itemproccompra    = $oItemOrc->pc23_orcamitem;
            $clitemprecoreferencia->si02_precoreferencia = $clprecoreferencia->si01_sequencial;
            if ($oItemOrc->percreferencia1 == 0 && $oItemOrc->percreferencia2 == 0) {
                $clitemprecoreferencia->si02_vlpercreferencia = 0;
            } else if ($oItemOrc->percreferencia1 > 0 && $oItemOrc->percreferencia2 == 0) {
                $clitemprecoreferencia->si02_vlpercreferencia = $oItemOrc->percreferencia1;
            } else {
                $clitemprecoreferencia->si02_vlpercreferencia = $oItemOrc->percreferencia2;
            }
            $clitemprecoreferencia->incluir(null);
        }

        if ($clitemprecoreferencia->erro_status == 0) {

            $sqlerro = true;
            $clprecoreferencia->erro_msg    = $clitemprecoreferencia->erro_msg;
            $clprecoreferencia->erro_status = "0";
        }

        if (pg_num_rows($rsResult) == 0) {

            $clprecoreferencia->erro_msg = "Não existe orçamentos cadastrados.";
            $sqlerro = true;
            $clprecoreferencia->erro_status = "0";
        }
    }

    db_fim_transacao($sqlerro);
    if ($clprecoreferencia->erro_status != 0) {
        echo "<script>
      jan = window.open('sic1_precoreferencia004.php?impjust=$impjustificativa&codigo_preco='+{$clprecoreferencia->si01_processocompra}+
      '&tipoprecoreferencia='+$si01_tipoprecoreferencia+'&quant_casas='+$quant_casas,
                    '',
                      'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
      jan.moveTo(0,0);
      </script>";
    }
    if ($clprecoreferencia->erro_status != 0) {
        db_redireciona("sic1_precoreferencia002.php?chavepesquisa=".$clprecoreferencia->si01_sequencial);
    }
}
?>
    <html>

    <head>
        <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="Expires" CONTENT="0">
        <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
        <link href="estilos.css" rel="stylesheet" type="text/css">
    </head>

    <body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
    <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
        <tr>
            <td width="360" height="18">&nbsp;</td>
            <td width="263">&nbsp;</td>
            <td width="25">&nbsp;</td>
            <td width="140">&nbsp;</td>
        </tr>
    </table>
    <table width="790" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
                <center>
                    <?php
                    include("forms/db_frmprecoreferencia.php");
                    ?>
                </center>
            </td>
        </tr>
    </table>
    <?
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
    </body>

    </html>
    <script>
        js_tabulacaoforms("form1", "si01_processocompra", true, 1, "si01_processocompra", true);
    </script>
<?
if (isset($incluir)) {
    if ($clprecoreferencia->erro_status == "0") {
        $clprecoreferencia->erro(true, false);
        $db_botao = true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if ($clprecoreferencia->erro_campo != "") {
            echo "<script> document.form1." . $clprecoreferencia->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1." . $clprecoreferencia->erro_campo . ".focus();</script>";
            echo "<script> document.getElementById('respCotacaocodigo').value=$respCotacaocodigoV;</script>  ";
            echo "<script> 
            document.getElementById('respOrcacodigo').value=$respOrcacodigoV;
            </script>  ";
            echo "<script> document.getElementById('respCotacaonome').value='$respCotacaonomeV';</script>  ";
            echo "<script> document.getElementById('respOrcanome').value='$respOrcanomeV';</script>  ";
        
        }
    } else {
        $clprecoreferencia->erro(true,true);
        echo "<script> document.getElementById('respCotacaocodigo').value=$respCotacaocodigoV;</script>  ";
        echo "<script> 
        document.getElementById('respOrcacodigo').value=$respOrcacodigoV;
        </script>  ";
        echo "<script> document.getElementById('respCotacaonome').value='$respCotacaonomeV';</script>  ";
        echo "<script> document.getElementById('respOrcanome').value='$respOrcanomeV';</script>  ";
    }
}
?>