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
              <? db_input("m51_codordem",6,$Im51_codordem,true,"text",3,"onchange='js_pesquisa_matordem(false);'");
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
    <!--      <tr>
          <td nowrap="nowrap" align='left'>
           <B>Situação</B>
         </td>
         <td nowrap="nowrap">
          <select name="situacao" id="situacao">
            <option>Todos</option>
            <option value='1'>Recebido</option>
            <option value='0'>Pendente</option>
          </select>
        </td>

      </tr>
      <tr>
        <td nowrap="nowrap" align='left'>
         <B>Agrupar por</B>
       </td>
       <td nowrap="nowrap">
        <select name="agrupar" id="agrupar">
          <option>Selecione</option>
          <option value='1'>Fornecedor</option>
          <option value='2'>Empenho</option>
          <option value='3'>Situação</option>
        </select>
      </td>

    </tr> -->
  </table>
</fieldset>
<fieldset style="width: 30%" ><legend><b>Selecionar Materiais</b></legend>
  <table align="center" >


<!--   <tr>
         <td colspan=2  align="left">
          <strong>Opções:</strong>
          <select name="ver">
            <option name="condicao2" value="true">Com os materiais selecionados</option>
            <option name="condicao2" value="false">Sem os materiais selecionados</option>
          </select>
        </td>
      </tr>
    -->

    <tr>
      <td nowrap width="30%">
       <?
                 // $aux = new cl_arquivo_auxiliar;
       $aux->cabecalho = "<strong>Material</strong>";
                 $aux->codigo = "pc01_codmater"; //chave de retorno da func
                 $aux->descr  = "pc01_descrmater";   //chave de retorno
                 $aux->nomeobjeto = 'material';
                 $aux->funcao_js = 'js_mostra2';
                 $aux->funcao_js_hide = 'js_mostra3';
                 $aux->sql_exec  = "";
                 $aux->func_arquivo = "func_pcmater.php";  //func a executar
                 $aux->nomeiframe = "db_iframe_pcmater";
                 $aux->localjan = "";
                 $aux->tamanho_campo_descricao = 29;
                 $aux->onclick = "";
                 $aux->db_opcao = 2;
                 $aux->tipo = 2;
                 $aux->top = 0;
                 $aux->linhas = 5;
                 $aux->vwidth = 400;
                 $aux->funcao_gera_formulario();
                 ?>
               </td>
             </tr>



           </table>

         </fieldset>
         <fieldset style="width: 30%;" id="dpto" >
          <legend><b>Selecionar Departamentos</b></legend>
          <table align="center">
<!--             <tr>
              <td nowrap="nowrap" align="left">
                <strong>Opções:</strong>
              </td>
              <td>
                <select name="ver">
                  <option name="condicao1" value="true">Com os departamentos selecionados</option>
                  <option name="condicao1" value="false">Sem os departamentos selecionados</option>
                </select>
              </td>
            </tr> -->
            <tr>
              <td nowrap="nowrap" colspan=2 >
                <?
            // $aux = new cl_arquivo_auxiliar;
                $aux2->cabecalho      = "<strong>Departamentos</strong>";
              $aux2->codigo         = "coddepto"; //chave de retorno da func
              $aux2->descr          = "descrdepto";   //chave de retorno
              $aux2->nomeobjeto     = 'departamentos';
              $aux2->funcao_js      = 'js_mostra';
              $aux2->funcao_js_hide = 'js_mostra1';
              $aux2->sql_exec       = "";
              $aux2->nome_botao     = "lanca_dpto";
              $aux2->func_arquivo   = "func_db_depart.php";  //func a executar
              $aux2->nomeiframe     = "db_iframe_db_depart";
              $aux2->localjan       = "";
              $aux2->onclick        = "";
              $aux2->db_opcao       = 2;
              $aux2->tamanho_campo_descricao = 33;
              $aux2->tipo           = 2;
              $aux2->top            = 0;
              $aux2->linhas         = 5;
              $aux2->vwidth = 400;
              $aux2->funcao_gera_formulario();
              ?>
            </td>
          </tr>

        </table>
      </fieldset>
<!--       <fieldset style="width: 50%" ><legend><b>Selecionar Instituições</b></legend>
        <table align="center">

          <tr>
            <td>
              <?
            //  db_selinstit('',400,150);
              ?>
            </td>
          </tr>

        </table>
      </fieldset> -->
      <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_mandadados();" >
    </form>
  </center>
  <? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
</body>
</html>
<script>
  function js_desabilitaDpto(){
    if(document.form1.data1.value != "" || document.form1.data2.value != ""){
      document.getElementById('dpto').style.display="none";
    }else{
      document.getElementById('dpto').style.display="normal";
    }
  }
  function js_pesquisae60_codemp(mostra){
    var departamentos = [];
    for(i=0;i<document.form1.departamentos.length;i++){
      departamentos.push(document.form1.departamentos[i].value);
    }
    departamentos = departamentos.join(",");
    if(mostra==true){
      js_OpenJanelaIframe('top.corpo','db_iframe_empempenho','func_empempenho.php?relordemcompra=true&departamentos='+departamentos+'&fornecedor='+document.form1.m51_numcgm.value+'&periodoini='+document.form1.data1.value+'&periodofim='+document.form1.data2.value+'&funcao_js=parent.js_mostraempempenho2|e60_codemp|e60_anousu|z01_nome|z01_numcgm','Pesquisa',true);
    }else{
   // js_OpenJanelaIframe('top.corpo','db_iframe_empempenho02','func_empempenho.php?pesquisa_chave='+document.form1.e60_numemp.value+'&funcao_js=parent.js_mostraempempenho','Pesquisa',false);
 }
}
function js_mostraempempenho2(chave1, chave2, chave3, chave4){

  document.form1.e60_codemp.value = chave1 + '/' + chave2;
  document.form1.z01_nome.value = chave3;
  document.form1.m51_numcgm.value = chave4;
  document.form1.m51_numcgm.disabled=true;
  if(document.form1.data1.value == "" || document.form1.data2.value == ""){
    // document.getElementById('ancorafornecedor').onclick="";
    // document.getElementById('ancorafornecedor').style.color="black;";
    document.getElementById('periodos').style.display="none";
    document.getElementById('dpto').style.display="none";
  }else{
    // document.getElementById('ancorafornecedor').onclick="js_pesquisae60_numcgm(true);";
    // document.getElementById('ancorafornecedor').style.color="blue;";
    document.getElementById('periodos').style.display="normal";
    document.getElementById('dpto').style.display="normal";
  }
  db_iframe_empempenho.hide();
}

function js_pesquisa_cgm(mostra){
  if(mostra==true){

    js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_cgm_empenho.php?funcao_js=parent.js_mostracgm1|e60_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.m51_numcgm.value != ''){
        js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_cgm_empenho.php?pesquisa_chave='+document.form1.m51_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
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
  // if(document.form1.data1.value == "" || document.form1.data2.value == ""){
  //   alert("Preencha o período");
  //   return false;
  // }
  var departamentos = [], material = [];

  for(i=0;i<document.form1.departamentos.length;i++){
    departamentos.push(document.form1.departamentos[i].value);
  }
  for(i=0;i<document.form1.material.length;i++){
    material.push(document.form1.material[i].value);
  }

  departamentos = departamentos.join(",");
  material = material.join(",");
  empenho = document.form1.e60_codemp.value;
  fornecedor = document.form1.m51_numcgm.value;
  codordem = document.form1.m51_codordem.value;
  // situacao = document.form1.situacao.value;
  // agrupar = document.form1.agrupar.value;

  Filtros = "departamentos="+departamentos;
  Filtros += "&materiais="+material;
  Filtros += "&empenho="+empenho;
  Filtros += "&fornecedor="+fornecedor;
  Filtros += "&codordem="+codordem;
  /*Filtros += "&situacao="+situacao;
  Filtros += "&agrupar="+agrupar;*/
  Filtros += "&data_ini="+document.form1.data1.value;
  Filtros += "&data_fim="+document.form1.data2.value;

  var oJanela = window.open('com2_conordemcom002.php?'+Filtros,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  oJanela.moveTo(0,0);
}

function js_pesquisa_matordem(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_matordem','func_matordemanulada.php?periodoini='+document.form1.data1.value+'&periodofim='+document.form1.data2.value+'&empenho='+(document.form1.e60_codemp.value).replace('/','.')+'&fornecedor='+document.form1.m51_numcgm.value+'&funcao_js=parent.js_mostramatordem1|m51_codordem|m51_numcgm|z01_nome','Pesquisa',true);
  }else{
   if(document.form1.m51_codordem.value != ''){
    js_OpenJanelaIframe('top.corpo','db_iframe_matordem','func_matordemanulada.php?periodoini='+document.form1.data1.value+'&periodofim='+document.form1.data2.value+'&empenho='+(document.form1.e60_codemp.value).replace('/','.')+'&fornecedor='+document.form1.m51_numcgm.value+'&pesquisa_chave='+document.form1.m51_codordem.value+'&funcao_js=parent.js_mostramatordem','Pesquisa',false);
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
