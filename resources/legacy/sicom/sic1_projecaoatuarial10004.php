<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_projecaoatuarial10_classe.php");
include("classes/db_projecaoatuarial20_classe.php");
$clprojecaoatuarial10 = new cl_projecaoatuarial10;

db_postmemory($HTTP_POST_VARS);
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
    $sqlerro=false;
    db_inicio_transacao();
    $result10 = $clprojecaoatuarial10->sql_record($clprojecaoatuarial10->sql_query(null,"*",null,"si168_exercicio = {$si168_exercicio} and si168_tipoplano = {$si168_tipoplano} and si168_instit = ".db_getsession('DB_instit').""));
    $oResult10 = db_utils::fieldsMemory($result10, 0);

    if($oResult10->si168_sequencial != NULL){
        $erro_msg = "ja existe Saldo Financeiro para este ano e este tipo de plano Codigo:{$oResult10->si168_sequencial}";
        $sqlerro=true;
    }else{
        $clprojecaoatuarial10->incluir($si168_sequencial);
        $erro_msg = $clprojecaoatuarial10->erro_msg;
        if($clprojecaoatuarial10->erro_status==0){
            $sqlerro=true;
        }
    }

    db_fim_transacao($sqlerro);
    $si168_sequencial= $clprojecaoatuarial10->si168_sequencial;
    $si168_tipoplano = $clprojecaoatuarial10->si168_tipoplano;
    $si168_exercicio = $clprojecaoatuarial10->si168_exercicio;
    $db_opcao = 1;
    $db_botao = true;
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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<center>
    <fieldset   style="margin-left:40px; margin-top: 20px;">
        <legend><b>Saldo Financeiro</legend>
        <?
        include("forms/db_frmprojecaoatuarial10.php");
        ?>
    </fieldset>
</center>
</body>
</html>
<?
if(isset($incluir)){
    if($sqlerro==true){
        db_msgbox($erro_msg);
        if($clprojecaoatuarial10->erro_campo!=""){
            echo "<script> document.form1.".$clprojecaoatuarial10->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clprojecaoatuarial10->erro_campo.".focus();</script>";
            echo "<script> CurrentWindow.corpo.iframe_projecaoatuarial20.location.href='sic1_projecaoatuarial10001.php'</script>";
        };
    }else{
        db_msgbox($erro_msg);
//          db_redireciona("sic1_projecaoatuarial20001.php?codigo=$si168_sequencial&tipoplano=$si168_tipoplano&liberaaba=true");
        echo
            "<script>
            parent.document.formaba.projecaoatuarial20.disabled=false;
            parent.mo_camada('projecaoatuarial20');
            CurrentWindow.corpo.iframe_projecaoatuarial20.location.href='sic1_projecaoatuarial20001.php?codigo=".$si168_sequencial."&tipoplano=".$si168_tipoplano."&exercicio=".$si168_exercicio."';
            </script>";
    }
}
?>
