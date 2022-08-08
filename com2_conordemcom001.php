<?

require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("libs/db_app.utils.php");
require_once ("libs/db_liborcamento.php");
require_once ("classes/db_cgm_classe.php");
require_once ("dbforms/db_funcoes.php");
require_once ("dbforms/db_classesgenericas.php");
require_once("classes/db_empempenho_classe.php");
$clempempenho = new cl_empempenho;
$clcgm    = new cl_cgm;
$clrotulo = new rotulocampo;
$clempempenho->rotulo->label();
$clcgm->rotulo->label();
$clrotulo->label("z01_nome");
include("classes/db_matordem_classe.php");
$clmatordem = new cl_matordem;
$clmatordem->rotulo->label();
db_postmemory($HTTP_POST_VARS);

$aux = new cl_arquivo_auxiliar;
$aux2 = new cl_arquivo_auxiliar;
?>

<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?php
  db_app::load('scripts.js, prototype.js, strings.js');
  db_app::load('estilos.css');
  ?>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <div style="margin-top: 25px;"></div>
  <center>
    <form name="form1" method="post" action="">

      <fieldset style="width: 30%" >
        <legend><b>Filtros</b></legend>
        <table align="center" >
          <tr>
            <td  align="left" nowrap title="<?=$Tm51_codordem?>"><?db_ancora(@$Lm51_codordem,"js_pesquisa_matordem(true);",1);?></td>
            <td align="left" nowrap>
              <? db_input("m51_codordem",10,$Im51_codordem,true,"text",3,"onchange='js_pesquisa_matordem(false);'");
              ?></td>
            </tr>
            <tr>
              <td  align="left" nowrap title="<?=$Te60_codemp?>">
                <? db_ancora(@$Le60_codemp,"js_pesquisae60_codemp(true);",1);  ?>
              </td>
              <td  nowrap="nowrap" title='<?=$Te60_codemp?>' >
                <?php db_input('e60_codemp',10,$Ie60_codemp, true, "text", 3); ?>

              </td>
            </tr>
            <tr id="periodos">
              <td nowrap="nowrap" align='left'>
                <b>Período:</b>
              </td>
              <td nowrap="nowrap">
                <?
                db_inputdata('data1','','','',true,'text',1,"onchange='js_desabilitaDpto();'", "", "", "none", "js_desabilitaDpto();", "js_desabilitaDpto();", "js_desabilitaDpto();");
                echo "<b> á</b> ";
                db_inputdata('data2','','','',true,'text',1,"onchange='js_desabilitaDpto();'", "", "", "none", "js_desabilitaDpto();", "js_desabilitaDpto();", "js_desabilitaDpto();"); ?>
                &nbsp;
              </td>
            </tr>
            <tr>
              <td  align="left" nowrap title="<?=$Tz01_numcgm?>">
                <?db_ancora("Fornecedor","js_pesquisa_cgm(true);",1);?>
              </td>
              <td align="left" nowrap>
                <?
                db_input("m51_numcgm",10,$Iz01_numcgm,true,"text",4,"onchange='js_pesquisa_cgm(false);'");
                db_input("z01_nome",38,"",true,"text",3);
                ?>

              </td>
            </tr>
            <tr>
              <td  align="left" nowrap title="<?=$Tz01_numcgm?>">
                <b>Filtros:</b>
              </td>
              <td align="left" nowrap>
                <select id="filtro" name="filtro">
                  <option>Selecione</option>
                  <option value="1">Com saldo não utilizado</option>
                  <option value="2">Com valor a lançar</option>
                  <option value="3">Com valor a liquidar</option>
                  <option value="4">Exceto finalizadas</option>
                </select>
              </td>
            </tr>

            <tr>
              <td  align="left" nowrap title="<?=$Tz01_numcgm?>">
                <b>Ordenar:</b>
              </td>
              <td align="left" nowrap>
                <select id="ordenar" name="ordenar">
                  <option>Selecione</option>
                  <option value="1">Empenho</option>
                </select>
              </td>
            </tr>

  </table>
</fieldset> <br>
      <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_mandadados();" >
      <input   type="button" value="Limpar" onclick="document.location.reload();" >
    </form>
  </center>
  <? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
</body>
</html>
<script>

  function js_pesquisae60_codemp(mostra){

    if(mostra==true){
      js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?relordemcompra=true&fornecedor='+document.form1.m51_numcgm.value+'&periodoini='+document.form1.data1.value+'&periodofim='+document.form1.data2.value+'&funcao_js=parent.js_mostraempempenho2|e60_codemp|e60_anousu|z01_nome|z01_numcgm','Pesquisa',true);
    }else{
   // js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho02','func_empempenho.php?pesquisa_chave='+document.form1.e60_numemp.value+'&funcao_js=parent.js_mostraempempenho','Pesquisa',false);
 }
}
function js_mostraempempenho2(chave1, chave2, chave3, chave4){

  document.form1.e60_codemp.value = chave1 + '/' + chave2;
  document.form1.z01_nome.value = chave3;
  document.form1.m51_numcgm.value = chave4;
  document.form1.m51_numcgm.disabled=true;
  if(document.form1.data1.value == "" || document.form1.data2.value == ""){

    document.getElementById('periodos').style.display="none";

  }else{

    document.getElementById('periodos').style.display="normal";

  }
  db_iframe_empempenho.hide();
}

function js_pesquisa_cgm(mostra){
  if(mostra==true){

    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_cgm_empenho.php?funcao_js=parent.js_mostracgm1|e60_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.m51_numcgm.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_cgm_empenho.php?pesquisa_chave='+document.form1.m51_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostracgm(chave,erro){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.z01_nome.value = '';
    document.form1.m51_numcgm.focus();
  }
}
function js_mostracgm1(chave1,chave2){
   document.form1.m51_numcgm.value = chave1;
   document.form1.z01_nome.value = chave2;
   db_iframe_cgm.hide();
}
function js_mandadados(){

  empenho = document.form1.e60_codemp.value;
  fornecedor = document.form1.m51_numcgm.value;
  codordem = document.form1.m51_codordem.value;
  filtro = document.form1.filtro.value;
  ordenar = document.form1.ordenar.value;
  Filtros = "";
  Filtros += "empenho="+empenho;
  Filtros += "&fornecedor="+fornecedor;
  Filtros += "&codordem="+codordem;
  Filtros += "&filtro="+filtro;
  Filtros += "&ordenar="+ordenar;
  Filtros += "&data_ini="+document.form1.data1.value;
  Filtros += "&data_fim="+document.form1.data2.value;

  var oJanela = window.open('com2_conordemcom002.php?'+Filtros,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  oJanela.moveTo(0,0);
}

function js_pesquisa_matordem(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_matordem','func_matordemanulada.php?periodoini='+document.form1.data1.value+'&periodofim='+document.form1.data2.value+'&empenho='+(document.form1.e60_codemp.value).replace('/','.')+'&fornecedor='+document.form1.m51_numcgm.value+'&funcao_js=parent.js_mostramatordem1|m51_codordem|m51_numcgm|z01_nome','Pesquisa',true);
  }else{
   if(document.form1.m51_codordem.value != ''){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_matordem','func_matordemanulada.php?periodoini='+document.form1.data1.value+'&periodofim='+document.form1.data2.value+'&empenho='+(document.form1.e60_codemp.value).replace('/','.')+'&fornecedor='+document.form1.m51_numcgm.value+'&pesquisa_chave='+document.form1.m51_codordem.value+'&funcao_js=parent.js_mostramatordem','Pesquisa',false);
  }else{
   document.form1.m51_codordem.value = '';
 }
}
}
function js_mostramatordem(chave,erro){
  document.form1.m51_codordem.value = chave1;

  if(erro==true){
    document.form1.m51_codordem.value = '';
    document.form1.m51_codordem.focus();
  }
}
function js_mostramatordem1(chave1,chave2,chave3){
  document.form1.m51_codordem.value = chave1;
  document.form1.m51_numcgm.value = chave2;
  document.form1.z01_nome.value = chave3;
  document.form1.m51_numcgm.disabled=true;
  db_iframe_matordem.hide();
}

</script>
