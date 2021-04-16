<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
require_once ("dbforms/db_classesgenericas.php");
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');

$clrotulo->label('r08_descr');
db_postmemory($HTTP_POST_VARS);
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
  qry = 'base1='+document.form1.base01.value+
	'&base2='+document.form1.base02.value+
	'&base3='+document.form1.base03.value+
	'&perc='+document.form1.perc.value+
	'&tipo_margem='+document.form1.tipo_margem.value+
	'&ordem='+document.form1.ordem.value+
	'&ano='+document.form1.DBtxt23.value+
	'&mes='+document.form1.DBtxt25.value+
  '&aMatriculas=' + js_campo_recebe_valores();
  jan = window.open('pes2_margemconsignavel002.php?'+qry,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
}

function js_emitecsv(){
  qry = 'base1='+document.form1.base01.value+
  '&base2='+document.form1.base02.value+
  '&base3='+document.form1.base03.value+
  '&perc='+document.form1.perc.value+
  '&tipo_margem='+document.form1.tipo_margem.value+
  '&ordem='+document.form1.ordem.value+
  '&ano='+document.form1.DBtxt23.value+
  '&mes='+document.form1.DBtxt25.value+
  '&aMatriculas=' + js_campo_recebe_valores();
  jan = window.open('pes2_margemconsignavelcsv002.php?'+qry,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
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
<center>
<form name="form1" method="post" action="" >

<fieldset style="width: 30%"><legend><b>Margem Consignável</b></legend>
  <table  align="center">
      <tr>
      </tr>
      <tr >
        <td align="left" nowrap title="Digite o Ano / Mes de competência" >
        <strong>Ano / Mês :&nbsp;&nbsp;</strong>
        </td>
        <td>
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
          <tr>
            <td nowrap align="left" title="" width="30%"><b>
              <?
               db_ancora('Remuneração',"js_pesquisabase01(true)",@$db_opcao);
              ?>
	      </b>&nbsp;&nbsp;
            </td>
            <td nowrap> 
              <?
               db_input('base01',4,@$base01,true,'text',@$db_opcao,"onchange='js_pesquisabase01(false)'");
               db_input("r08_descr",30,@$Ir08_descr,true,"text",3,"","descr_base01");
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap align="left" title="" width="30%"><b>
              <?
               db_ancora('Desc. Obrigatórios',"js_pesquisabase02(true)",@$db_opcao);
              ?>
	      </b>&nbsp;&nbsp;
            </td>
            <td nowrap> 
              <?
               db_input('base02',4,@$base02,true,'text',@$db_opcao,"onchange='js_pesquisabase02(false)'");
               db_input("r08_descr",30,@$Ir08_descr,true,"text",3,"","descr_base02");
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap align="left" title="" width="30%"><b>
              <?
               db_ancora('Comprometido',"js_pesquisabase03(true)",@$db_opcao);
              ?>
	      </b>&nbsp;&nbsp;
            </td>
            <td nowrap> 
              <?
               db_input('base03',4,@$base03,true,'text',@$db_opcao,"onchange='js_pesquisabase03(false)'");
               db_input("r08_descr",30,@$Ir08_descr,true,"text",3,"","descr_base03");
              ?>
            </td>
          </tr>
      <tr>
        <td align="left" nowrap title="Percentual da margem consignável" >
        <strong>Perc. Consignável :&nbsp;&nbsp;</strong>
        </td>
        <td>
          <?
	         @$perc=0;
           db_input('perc',3,$perc,true,'text',2,'')
          ?>
	</td>
      </tr>
      <tr>
	      <td align="left" nowrap><strong>Apresentar Servidores :</strong>&nbsp;&nbsp;
        </td>
        <td>
         <?
           $xx = array("t"=>"Todos","s"=>"Sem Margem","c"=>"Com Margem");
           db_select('tipo_margem',$xx,true,4,"");
         ?>
	      </td>
      </tr>
      <tr>
        <td align="left" nowrap><strong>Ordem :</strong>&nbsp;&nbsp;</td>
        <td>
         <?
           $xy = array("a"=>"Nome","n"=>"Matricula");
           db_select('ordem',$xy,true,4,"");
         ?>
        </td>
      </tr>
       <tr>
            <td colspan="2">
              <table style="width: 100%">
                <tr>
                  <td align="right">
                    <?php 
                      
                      $aux                                  = new cl_arquivo_auxiliar;
                      $aux->cabecalho                       = "<strong>MATRÍCULAS SELECIONADAS</strong>";
                      $aux->codigo                          = "rh01_regist";
                      $aux->descr                           = "z01_nome";
                      $aux->nomeobjeto                      = 'matriculas_selecionadas';
                      $aux->obrigarselecao                  = false;
                      $aux->funcao_js                       = 'js_mostra';
                      $aux->funcao_js_hide                  = 'js_mostra1';
                      $aux->func_arquivo                    = "func_rhpessoal.php";
                      $aux->nomeiframe                      = "db_iframe_rhpessoal";
                      $aux->executa_script_apos_incluir     = "document.form1.rh01_regist.focus();";
                      $aux->mostrar_botao_lancar            = true;
                      $aux->executa_script_lost_focus_campo = "js_insSelectmatriculas_selecionadas()";
                      $aux->executa_script_change_focus     = "document.form1.rh01_regist.focus();";
                      $aux->passar_query_string_para_func   = "&instit=" . db_getsession("DB_instit");
                      $aux->localjan                        = "";
                      $aux->db_opcao                        = 2;
                      $aux->tipo                            = 2;
                      $aux->top                             = 20;
                      $aux->linhas                          = 10;
                      $aux->vwidth                          = "360";
                      $aux->funcao_gera_formulario();
                      
                    ?>
                  </td>
                </tr> 
              </table>
            </td>
          </tr>
</table>
</fieldset>
	<table>
    <tr>
      <td colspan="2"align = "center"> 
        <input  name="emite1" id="emite1" type="button" value="Processar" onclick="js_emite();" >
        <input  name="emite2" id="emite2" type="button" value="Imprimir CSV" onclick="js_emitecsv();" >
      </td>
    </tr>
  </table>
</form>
</center>

<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>

function js_pesquisabase01(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_bases','func_bases.php?funcao_js=parent.js_mostrabase011|r08_codigo|r08_descr','Pesquisa',true);
  }else{
    if(document.form1.base01.value != ''){ 
      js_OpenJanelaIframe('top.corpo','db_iframe_base01','func_bases.php?pesquisa_chave='+document.form1.base01.value+'&funcao_js=parent.js_mostrabase01','Pesquisa',false);
    }else{
      document.form1.descr_base01.value = ''; 
    }
  }
}
function js_mostrabase01(chave,erro){
  document.form1.descr_base01.value = chave; 
  if(erro==true){ 
    document.form1.base01.focus(); 
    document.form1.base01.value = ''; 
  }
}
function js_mostrabase011(chave1,chave2){
  document.form1.base01.value = chave1;
  document.form1.descr_base01.value = chave2;
  db_iframe_bases.hide();
}



function js_pesquisabase02(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_bases','func_bases.php?funcao_js=parent.js_mostrabase021|r08_codigo|r08_descr','Pesquisa',true);
  }else{
    if(document.form1.base02.value != ''){ 
      js_OpenJanelaIframe('top.corpo','db_iframe_base02','func_bases.php?pesquisa_chave='+document.form1.base02.value+'&funcao_js=parent.js_mostrabase02','Pesquisa',false);
    }else{
      document.form1.descr_base02.value = ''; 
    }
  }
}
function js_mostrabase02(chave,erro){
  document.form1.descr_base02.value = chave; 
  if(erro==true){ 
    document.form1.base02.focus(); 
    document.form1.base02.value = ''; 
  }
}
function js_mostrabase021(chave1,chave2){
  document.form1.base02.value = chave1;
  document.form1.descr_base02.value = chave2;
  db_iframe_bases.hide();
}


function js_pesquisabase03(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_bases','func_bases.php?funcao_js=parent.js_mostrabase031|r08_codigo|r08_descr','Pesquisa',true);
  }else{
    if(document.form1.base03.value != ''){ 
      js_OpenJanelaIframe('top.corpo','db_iframe_base03','func_bases.php?pesquisa_chave='+document.form1.base03.value+'&funcao_js=parent.js_mostrabase03','Pesquisa',false);
    }else{
      document.form1.descr_base03.value = ''; 
    }
  }
}
function js_mostrabase03(chave,erro){
  document.form1.descr_base03.value = chave; 
  if(erro==true){ 
    document.form1.base03.focus(); 
    document.form1.base03.value = ''; 
  }
}
function js_mostrabase031(chave1,chave2){
  document.form1.base03.value = chave1;
  document.form1.descr_base03.value = chave2;
  db_iframe_bases.hide();
}

function js_insere_matri () {
    
    var valor = document.getElementById('matriculas_selecionadas_text').value.trim();
    
    if ( valor == '' ) {
      
      if ( st ) {
        
        clearTimeout(st);
      }
        
      return false;
    }
      
    var array = valor.split(",");
    
    for ( var i = 0; i < array.length; i++ ) {
      
      document.getElementById('rh01_regist').value = array[i];
      js_BuscaDadosArquivomatriculas_selecionadas(false);
      
      document.getElementById('matriculas_selecionadas_text').value = 
        ( array.slice( i + 1, array.length ).implode(',') ).trim();
      
      var st = setTimeout(js_insere_matri, 500);
      
      break;
    }
    
  }













</script>
