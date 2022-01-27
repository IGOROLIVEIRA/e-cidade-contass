<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_rhrubricas_classe.php");
include("classes/db_relempenhospatronais_classe.php");
$clrhrubricas = new cl_rhrubricas;
$clrelempenhospatronais = new cl_relempenhospatronais;
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');
db_postmemory($HTTP_POST_VARS);

const SALARIO_FAMILIA = "salarioFamilia";
const SALARIO_MATERNIDADE = "salarioMaternidade";

$result = $clrhrubricas->sql_record($clrhrubricas->rubricasAtivasNaBase('B995', db_anofolha(), db_mesfolha(), db_getsession("DB_instit"), "rhrubricas.rh27_rubric,
            rhrubricas.rh27_descr,
            rhrubricas.rh27_presta,
            case
                when rhrubricas.rh27_pd = 1 then 'PROVENTO'
                when rhrubricas.rh27_pd = 2 then 'DESCONTO'
                else 'BASE'
            end as rh27_pd,
            rhrubricas.rh27_form,
            rhrubricas.rh27_limdat,
            case
                when trim(rh27_form)='' then 'f'
                else 't'
            end as DB_formula,
            rh27_tipo as DB_rh27_tipo,
            rh27_obs", "rh27_rubric asc" ));
$aBases = db_utils::getColectionByRecord($result);

$result = $clrelempenhospatronais->sql_record($clrelempenhospatronais->sql_query_file(null, "*", null, "rh170_tipo = '".SALARIO_FAMILIA."' AND rh170_usuario = ".db_getsession("DB_id_usuario")." AND rh170_instit = ".db_getsession("DB_instit")));
$aResultSalarioFamilia = db_utils::getColectionByRecord($result);

$bases = array();
$aSalarioFamilia = array();

foreach ($aBases as $b) {
    $bases[$b->rh27_rubric] = $b->rh27_rubric.' | ';
    $bases[$b->rh27_rubric] .= $b->rh27_descr;
    $bases[$b->rh27_rubric] .= ' | '.$b->rh27_pd;
}
foreach ($aResultSalarioFamilia as $b) {
    $aSalarioFamilia[$b->rh170_rubric] = $bases[$b->rh170_rubric];
}

$result = $clrelempenhospatronais->sql_record($clrelempenhospatronais->sql_query_file(null, "*", null, "rh170_tipo = '".SALARIO_MATERNIDADE."' AND rh170_usuario = ".db_getsession("DB_id_usuario")." AND rh170_instit = ".db_getsession("DB_instit")));
$aResultSalarioMaternidade = db_utils::getColectionByRecord($result);
$aSalarioMaternidade = array();
foreach ($aResultSalarioMaternidade as $b) {
    $aSalarioMaternidade[$b->rh170_rubric] = $bases[$b->rh170_rubric];
}
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

<script>
function js_verifica(){
    var anoi = new Number(document.form1.datai_ano.value);
    var anof = new Number(document.form1.dataf_ano.value);
    
    if(anoi.valueOf() > anof.valueOf()){
        alert('Intervalo de data invalido. Velirique !.');
        return false;
    }

    return true;
}


function js_emite(){
   
    selecionados = "";
    virgula_ssel = "";
    if(document.form1.sselecionados.length == 0 ){
        alert('Você deve selecionar pelo menos 1 item!');
        return;
    }
    if(document.form1.aSalarioFamilia.length == 0 ){
        alert('Você deve selecionar pelo menos 1 item de Salário Família!');
        return;
    }
    if(document.form1.aSalarioMaternidade.length == 0 ){
        alert('Você deve selecionar pelo menos 1 item de Salário Maternidade!');
        return;
    }
    for(var i=0; i<document.form1.sselecionados.length; i++){
        selecionados+= virgula_ssel + document.form1.sselecionados.options[i].value;
        virgula_ssel = ",";
    }
    salarioFamilia = "";
    virgula_ssel = "";
    for(var i=0; i<document.form1.aSalarioFamilia.length; i++){
        salarioFamilia+= virgula_ssel + document.form1.aSalarioFamilia.options[i].value;
        virgula_ssel = ",";
    }
    salarioMaternidade = "";
    virgula_ssel = "";
    for(var i=0; i<document.form1.aSalarioMaternidade.length; i++){
        salarioMaternidade+= virgula_ssel + document.form1.aSalarioMaternidade.options[i].value;
        virgula_ssel = ",";
    }
    qry  = "?ano="+document.form1.DBtxt23.value;
    qry += "&mes="+document.form1.DBtxt25.value;
    qry += "&perc_extra="+document.form1.perc_extra.value;
    qry += "&salario="+document.form1.salario.value;
    qry += "&selec="+ selecionados;
    qry += "&salarioFamilia="+ salarioFamilia;
    qry += "&salarioMaternidade="+ salarioMaternidade;
    jan = window.open('pes2_empenhospatronaisvinculo002.php'+qry,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);

}
</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
    <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
        <td width="360" height="18">&nbsp;</td>
        <td width="263">&nbsp;</td>
        <td width="25">&nbsp;</td>
        <td width="140">&nbsp;</td>
    </tr>
</table>

<table  align="center" >
    <form name="form1" method="post" action="" onsubmit="return js_verifica();">
        <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
        </tr>
        <tr >
        <td align="right" nowrap title="Digite o Ano / Mes de competência" >
        <strong>Ano / Mês :</strong>
        </td>
        <td align="left">
            <?
            $DBtxt23 = db_anofolha();
            db_input('DBtxt23',4,$IDBtxt23,true,'text',2,'')
            ?>
            &nbsp;/&nbsp;
            <?
            $DBtxt25 = db_mesfolha();
            db_input('DBtxt25',2,$IDBtxt25,true,'text',2,'')
            ?>
        </td>
        </tr>
        </tr>
        <tr>
        <td align="right"><b>Arquivo</b</td>
        <td >
            <?
            $xx = array("s"=>"Salário","d"=>"13o. Salário");
            db_select('salario',$xx,true,4,"");
            ?>

    </td>
        </tr>
        <tr>
        <td align="right">
            <strong>Coluna Extra (%) :</strong>
        </td>
        <td align="left" >
            <?
            db_input('perc_extra',4,null,true,'text',2,'');
            ?>
        </td>
        </tr>
        <tr >
        <td align="center" colspan="2" >
            <?
            $sql = "select distinct r33_codtab as r33_codtab,
                        case when r33_codtab = 2 then 'FGTS' else r33_nome end as r33_nome 
                    from inssirf 
                    where r33_anousu = $DBtxt23 
                    and r33_mesusu = $DBtxt25 
                    and r33_codtab > 1 
                    and r33_instit = ".db_getsession('DB_instit') ;
            $res = pg_query($sql);
        db_multiploselect("r33_codtab", "r33_nome", "nselecionados", "sselecionados", $res, array(), 5, 250);
            ?>
        </td>
        </tr>
        <tr>
        <td colspan="2" align = "center">
            <fieldset>
            <legend><b>Salário Família para dedução</b></legend>
                <table>
                <tr>
                <td width="5%" align="right"><b>Buscar:</b></td>
                <td width="60%"><input type="text" id="buscaSalarioFamilia" onkeyup="buscaMultiselect('basesSalarioFamilia');" placeholder="Digite um nome"></td>
                <td width="5%" align="right"><b>Buscar:</b></td>
                <td width="60%"><input type="text" id="buscabasesSalarioFamilia" onkeyup="buscaMultiselect('aSalarioFamilia');" placeholder="Digite um nome"></td>

                </tr>
                <tr>
                <td colspan=4>

                    <?php db_multiploselect('codigo','descricao', "basesSalarioFamilia", "aSalarioFamilia", $bases, $aSalarioFamilia,10,400,"Disponíveis","Selecionados",true,  "Verifica('basesSalarioMaternidade','aSalarioFamilia');VerificaBases('basesSalarioFamilia','basesSalarioMaternidade');", "_familia"); ?>
                </td>
                </tr>
            </table>
            </fieldset>
        </td>
        </tr>
        <tr>
        <td colspan="2" align = "center">
            <fieldset>
            <legend><b>Salário Maternidade para dedução</b></legend>
                <table>
                <tr>
                <td width="5%" align="right"><b>Buscar:</b></td>
                <td width="60%"><input type="text" id="buscaSalarioMaternidade" onkeyup="buscaMultiselect('basesSalarioMaternidade');" placeholder="Digite um nome"></td>
                <td width="5%" align="right"><b>Buscar:</b></td>
                <td width="60%"><input type="text" id="buscabasesSalarioMaternidade" onkeyup="buscaMultiselect('aSalarioMaternidade');" placeholder="Digite um nome"></td>

                </tr>
                <tr>
                <td colspan=4>

                    <?php db_multiploselect('codigo','descricao', "basesSalarioMaternidade", "aSalarioMaternidade", $bases, $aSalarioMaternidade,10,400,"Disponíveis","Selecionados",true,  "Verifica('basesSalarioFamilia','aSalarioMaternidade');VerificaBases('basesSalarioMaternidade','basesSalarioFamilia');", "_maternidade"); ?>
                </td>
                </tr>
            </table>
            </fieldset>
        </td>
        </tr>
        <tr>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        </tr>
        <tr>
        <td colspan="2" align = "center"> 
            <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();" >
        </td>
        </tr>

    </form>
</table>

<script>
    function buscaMultiselect(combobox) {

        var input, filter, bases, options, i, texto;
        if (combobox == 'basesSalarioFamilia'){

            input = document.getElementById('buscaSalarioFamilia');
            filter = input.value.toUpperCase();
            bases = document.getElementById("basesSalarioFamilia");

        } else if (combobox == 'aSalarioFamilia') {

            input = document.getElementById('buscabasesSalarioFamilia');
            filter = input.value.toUpperCase();
            bases = document.getElementById("aSalarioFamilia");

        } else if (combobox == 'basesSalarioMaternidade'){

            input = document.getElementById('buscaSalarioMaternidade');
            filter = input.value.toUpperCase();
            bases = document.getElementById("basesSalarioMaternidade");

        } else {

            input = document.getElementById('buscabasesSalarioMaternidade');
            filter = input.value.toUpperCase();
            bases = document.getElementById("aSalarioMaternidade");

        }
        options = bases.getElementsByTagName('option');
        for (i = 0; i < options.length; i++) {
            texto = options[i].innerHTML.toUpperCase();
            if (texto.indexOf(filter) > -1) {
            options[i].style.display = "";
            } else {
            options[i].style.display = "none";
            }
        }
    }

    function Verifica(bases,selecionados) {

        var arrBases = document.getElementById(bases);
        var arrSelecionados = document.getElementById(selecionados);

        for (let i = 0; i < arrSelecionados.options.length; i++) {
            for (let iCont = 0; iCont < arrBases.options.length; iCont++) {
            if (arrSelecionados.options[i].value == arrBases.options[iCont].value) {
                // console.log(arrBases.options[iCont].value);
                arrBases.options[iCont] = null;
                break;
            }
            }
        }

    }

    function VerificaBases(bases1, bases2) {

        let arrBases1 = document.getElementById(bases1);
        let arrBases2 = document.getElementById(bases2);
        for (let i = 0; i < arrBases1.options.length; i++) {
            arrBases2.options[i] = new Option(arrBases1.options[i].text,arrBases1.options[i].value)
        }

    }
    Verifica("basesSalarioFamilia","aSalarioFamilia");
    Verifica("basesSalarioMaternidade","aSalarioMaternidade");

    Verifica("basesSalarioMaternidade","aSalarioFamilia");
    Verifica("basesSalarioFamilia","aSalarioMaternidade");
</script>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>