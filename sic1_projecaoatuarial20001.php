<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_projecaoatuarial20_classe.php");
include("classes/db_projecaoatuarial10_classe.php");
include("dbforms/db_funcoes.php");
require_once ("dbforms/db_classesgenericas.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clprojecaoatuarial20 = new cl_projecaoatuarial20;
$clprojecaoatuarial10 = new cl_projecaoatuarial10;
$db_opcao = 22;
$db_botao = false;

if(isset($salvar)) {

    $result10 = $clprojecaoatuarial10->sql_record($clprojecaoatuarial10->sql_query(null, "*", null, "si168_sequencial={$codigo}"));
    $oResult10 = db_utils::fieldsMemory($result10, 0);

    $projecaoaturialano = $oResult10->si168_exercicio + 74;
    $anoprojecao = $oResult10->si168_exercicio + 1;

    for ($ano = $anoprojecao; $ano <= $projecaoaturialano; $ano++) {

        $clprojecaoatuarial20->si169_exercicio = $ano;
        $clprojecaoatuarial20->si169_vlreceitaprevidenciaria = $receita[$ano];
        $clprojecaoatuarial20->si169_vldespesaprevidenciaria = $despesa[$ano];
        $clprojecaoatuarial20->si169_dtcadastro = date('Y-m-d', db_getsession('DB_datausu'));
        $clprojecaoatuarial20->si169_instit = db_getsession("DB_instit");
        $clprojecaoatuarial20->si169_projecaoatuarial10 = $oResult10->si168_sequencial;
        $clprojecaoatuarial20->si169_tipoplano = $oResult10->si168_tipoplano;

        $data = 'data_'.$ano;
        $clprojecaoatuarial20->si169_data = implode("-", array_reverse(explode("/", $$data)));

        $result20 = $clprojecaoatuarial20->sql_record($clprojecaoatuarial20->sql_query(null, "*", null, "si169_projecaoatuarial10={$oResult10->si168_sequencial} and si169_exercicio = {$ano} and si169_tipoplano = {$oResult10->si168_tipoplano}"));
        db_fieldsmemory($result20,0);

        if ($si169_sequencial == NULL) {
            $clprojecaoatuarial20->incluir(null);
            if ($clprojecaoatuarial20->erro_status == 0) {
                throw new Exception($clprojecaoatuarial20->erro_msg);
            }
        } else {
            $clprojecaoatuarial20->si169_sequencial = $si169_sequencial;
            $data = 'data_'.$ano;
            $clprojecaoatuarial20->si169_data = implode("-", array_reverse(explode("/", $$data)));
            $clprojecaoatuarial20->alterar($si169_sequencial);
            if ($clprojecaoatuarial20->erro_status == 0) {
                throw new Exception($clprojecaoatuarial20->erro_msg);
            }
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
    <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">

</head>
<body class="body-default">
<center>
    <fieldset style="width: 580px;">
        <legend><b>Projeção</legend>
        <?
        include("forms/db_frmprojecaoatuarial20.php");
        ?>
    </fieldset>
</center>
</body>
</html>
<?
if(isset($alterar) || isset($excluir) || isset($incluir)){
    db_msgbox($erro_msg);
    if($clprojecaoatuarial20->erro_campo!=""){
        echo "<script> document.form1.".$clprojecaoatuarial20->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clprojecaoatuarial20->erro_campo.".focus();</script>";
    }
}
?>
