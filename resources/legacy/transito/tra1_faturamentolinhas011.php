<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_linhafrequencia_classe.php");
include("dbforms/db_funcoes.php");
require_once("dbforms/db_classesgenericas.php");

require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");

db_postmemory($HTTP_POST_VARS);
$cllinhafrequencia = new cl_linhafrequencia;
$db_opcao = 1;
$db_botao = true;

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
<form name="form1" id="form1" method="POST">
        <center>
            <fieldset style="margin:25px auto 0 auto; width: 500px;">
                <legend><b>Faturamentos de Linhas</b></legend>
                <table>
                    <tr>
                        <td>
                            <fieldset style="margin:0 auto 0 auto; width: 500px;">
                                <legend><b>Filtros</b></legend>
                                <table>
                                    <tr>
                                        <td>
                                            <?php
                                            $aPeriodoDatas = explode('-', date('Y-m-d', db_getsession('DB_datausu')));
                                            list($iAnoInicial, $iMesInicial, $iDiaInicial) = $aPeriodoDatas;
                                            ?>
                                            <table>
                                                <td nowrap title="<?=$TDBtxt21?>">
                                                    <b>Data Inicial:</b>
                                                </td>
                                            <td>
                                            <?php
                                            db_inputdata("dtDataInicial", $iDiaInicial, $iMesInicial, $iAnoInicial, true, 'text', 1);
                                            ?>
                                            </td>
                                                <td nowrap align="right" title="<?=$TDBtxt22?>">
                                                    <b>Data Final:</b>
                                                </td>
                                            <td>
                                            <?php
                                            db_inputdata("dtDataFinal", $iDiaInicial, $iMesInicial, $iAnoInicial, true, 'text', 1);
                                            ?>
                                            </td>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td><b>Filtro:</b></td>
                                        <td>
                                            <?php
                                            $aFiltro = array(1 => "Faturamento",2 => "Frequência");
                                            db_select("sFiltro", $aFiltro, true, 1);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td><b>Quebra por credor:</b></td>
                                        <td>
                                            <?php
                                            $aQuebra = array(1 => "Não",2 => "Sim");
                                            db_select("sQuebra", $aQuebra , true, 1);
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br />
            <center>
                <input type="button" id="btnEmitir" value="Emitir Relatório" />
            </center>
        </center>
    </form>
  <div>  
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
<script>
 
$('btnEmitir').observe('click', function() {
 
    var sDataInicialBanco = js_formatar($F('dtDataInicial'), 'd');
    var sDataFinalBanco   = js_formatar($F('dtDataFinal'), 'd');


    if (sDataInicialBanco > sDataFinalBanco) {
        alert("A data inicial é maior que a data final. Verifique!");
        return false;
    }

    if (!sDataInicialBanco) {
        alert("A data inicial não pode ser vazia. Verifique!");
        return false;
    }

    if (!sDataFinalBanco) {
        alert("A data final não pode ser vazia. Verifique!");
        return false;
    }

    function OpenWithPost(dados, name){

        var mapForm = document.createElement("form");
        mapForm.target = name;
        mapForm.method = "POST";
        
        mapForm.action = "tra1_faturamentolinhas02.php";
        
        document.body.appendChild(mapForm);

        for(var key in dados){
            var input   = document.createElement("input");
            input.type  = 'hidden';
            input.name  = key;
            input.value = dados[key];
            mapForm.appendChild(input);
        }

        windowfeature = 'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0';
        var map = window.open("", name, windowfeature);
        if (map) {
            mapForm.submit();
        }
} 

var dados = [];
dados['dtDataInicial']               = $F('dtDataInicial');
dados['dtDataFinal']                 = $F('dtDataFinal');
dados['sFiltro']                     = $F('sFiltro');
dados['sQuebra']                     = $F('sQuebra');
 
    
var name = new Date().getTime();
OpenWithPost(dados, name);

});
$('sQuebra').style.width ='108px';
$('sFiltro').style.width ='108px';

</script>
</html>
