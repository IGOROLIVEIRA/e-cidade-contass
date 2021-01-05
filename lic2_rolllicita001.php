<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("dbforms/db_classesgenericas.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clrotulo = new rotulocampo;
$clrotulo->label("l20_codigo");
$clrotulo->label("l20_numero");
$clrotulo->label("l03_codigo");
$clrotulo->label("l03_descr");
$clrotulo->label("pc21_numcgm");
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script>
function js_emite(){

    query = 'l20_codigo='+document.form1.l20_codigo.value;
    query += '&l03_codigo='+document.form1.l03_codigo.value+'&l03_descr='+document.form1.l03_descr.value;
    query += '&status='+document.form1.status.value+'&exercicio='+document.form1.exercicio.value;
  
    if(document.form1.fornecedor.value == '1' && document.form1.pc21_numcgm.value){
        query += '&numcgm='+document.form1.pc21_numcgm.value;
    }

    jan = window.open('lic2_rolllicita002.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);	
}

</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<style>
#fornecedor{
  width: 69px;
}

#status{
  width: 200px;
}
</style>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>

<div style="margin: 2% 29%;">
<fieldset>
    <legend>Rol de Licitação </legend>
  <table  align="center">
    <form name="form1" method="post" action="">
      <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
      </tr>

      <tr> 
         <td  align="left" nowrap title="<?=$Tl20_codigo?>">
          <b>
          <?
            db_ancora('Licitação :',"js_pesquisa_liclicita(true);",1);
          ?>
          </b>
         </td>
         <td align="left" nowrap>
          <?
            db_input("l20_codigo", 8, $Il20_codigo, true, "text", 1, "onchange='js_pesquisa_liclicita(false);'");
            db_input("l20_objeto", 40, $Il20_objeto, true, "text", 3, "");
          ?>
         </td>
      </tr>

      <tr> 
         <td  align="left" nowrap title="<?=$Tl03_codigo?>">
          <b>
          <?
            db_ancora("Modalidade :","js_pesquisal03_codigo(true);",1);
          ?>
          </b>
         </td>
         <td  align="left" nowrap> 
          <?
            db_input("l03_codigo",8,$Il03_codigo,true,"text",1,"onchange='js_pesquisal03_codigo(false);'");
            db_input("l03_descr",40,$Il03_descr,true,"text",3);
          ?>
         </td>
      </tr>
      <tr>
        <td>
          <b>Status:</b>
        </td>
        <td>
          <?php
            $aStatus = array(0=>'Selecione', 1 =>'Em andamento', 2 =>'Julgada', 3 =>'Revogada', 4 => 'Deserta', 5 => 'Fracassada', 6 => 'Anulada',
            10 => 'Homologação', 11 => 'Em Recurso');
            db_select("status", $aStatus, true, 2, " ","","","0","");
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <b>Exercício:</b>
        </td>
        <td>
          <?php
            db_input("exercicio",8, $exercicio, true, "text", 1,'onkeyup="js_validaCaracteres(this);"');
          ?>
        </td>
      </tr>

      <tr>
        <td>
          <b>Filtrar por fornecedor:</b>
        </td>
        <td>
          <?php 
          $aFornecedor = array(0=>'Não', 1=>'Sim');
          db_select('fornecedor', $aFornecedor, true, 2, " ","","","0","");?>
        </td>
      </tr>

      <tr class='tr__cgm'>
          <td align="left"  nowrap title="<?=@$Tpc21_numcgm?>">
              <?
              db_ancora(@$Lpc21_numcgm,"js_pesquisapc21_numcgm(true);",$db_opcao);
              ?>
          </td>
          <td>
              <?
              db_input('pc21_numcgm',8,$Ipc21_numcgm,true,'text',$db_opcao," onchange='js_pesquisapc21_numcgm(false);'")
              ?>
              <?
              db_input('z01_nome',40,$Iz01_nome,true,'text',3);
              ?>
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
  </fieldset>
 </div>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>

document.getElementsByClassName('tr__cgm')[0].style.display = 'none';

function js_pesquisal20_numero(mostra){
  if(mostra==true){
    if (document.form1.l03_codigo.value != ""){
         js_OpenJanelaIframe('top.corpo','db_iframe_licnumeracao','func_liclicita.php?chave_l03_codigo='+document.form1.l03_codigo.value+'&funcao_js=parent.js_mostralicnumeracao1|l20_numero','Pesquisa',true);
    } else {
         alert("Selecione uma modalidade!");
	 document.form1.l03_codigo.focus();
	 document.form1.l03_codigo.select();
    }
  }
}
function js_mostralicnumeracao1(chave1){
   document.form1.l20_numero.value = chave1;  
   db_iframe_licnumeracao.hide();
}
function js_pesquisa_liclicita(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?lContratos=1&situacao=10&funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto','Pesquisa',true);
  }else{
     if(document.form1.l20_codigo.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?lContratos=1&situacao=10&pesquisa_chave='+document.form1.l20_codigo.value+'&funcao_js=parent.js_mostraliclicita','Pesquisa',false);
     }else{
       document.form1.l20_codigo.value = ''; 
       document.form1.l20_objeto.value = ''; 
     }
  }
}
function js_mostraliclicita(chave,erro){
  document.form1.l20_objeto.value = chave; 
  if(erro==true){ 
    document.form1.l20_codigo.value = ''; 
    document.form1.l20_objeto.value = ''; 
    document.form1.l20_codigo.focus(); 
  }
}
function js_mostraliclicita1(chave1, chave2){
   document.form1.l20_codigo.value = chave1;  
   document.form1.l20_objeto.value = chave2;  
   db_iframe_liclicita.hide();
}
function js_pesquisal03_codigo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_cflicita','func_cflicita.php?funcao_js=parent.js_mostracflicita1|l03_codigo|l03_descr','Pesquisa',true);
  }else{
     if(document.form1.l03_codigo.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_cflicita','func_cflicita.php?pesquisa_chave='+document.form1.l03_codigo.value+'&funcao_js=parent.js_mostracflicita','Pesquisa',false);
     }else{
       document.form1.l03_descr.value = ''; 
     }
  }
}
function js_mostracflicita(chave,erro){
  document.form1.l03_descr.value = chave; 
  if(erro==true){ 
    document.form1.l03_codigo.focus(); 
    document.form1.l03_codigo.value = ''; 
  }
}
function js_mostracflicita1(chave1,chave2){
  document.form1.l03_codigo.value = chave1;
  document.form1.l03_descr.value = chave2;
  db_iframe_cflicita.hide();
}

function js_pesquisapc21_numcgm(mostra){
    if(mostra==true){
        js_OpenJanelaIframe('','func_nome','func_pcforne.php?validaRepresentante=true&orderName=true&funcao_js=parent.js_mostracgm1|pc60_numcgm|z01_nome','Pesquisa',true);
    }else{
        if(document.form1.pc21_numcgm.value != ''){
            js_OpenJanelaIframe('','func_nome','func_pcforne.php?validaRepresentante=true&orderName=true&pesquisa_chave='+document.form1.pc21_numcgm.value+'&iParam=true&funcao_js=parent.js_mostracgm','Pesquisa',false);
        }else{
            document.form1.z01_nome.value = '';
        }
    }
}

function js_mostracgm(chave, chave2){
    if(chave2 == true){
        document.form1.pc21_numcgm.focus();
        document.form1.pc21_numcgm.value = '';
        document.form1.z01_nome.value = chave;
    }else{
        document.form1.z01_nome.value = chave2;
    }
}

function js_mostracgm1(chave1,chave2){
    document.form1.pc21_numcgm.value = chave1;
    document.form1.z01_nome.value = chave2;
    func_nome.hide();
}

document.getElementById('fornecedor').addEventListener('change', e => {
    let oElemento = document.getElementsByClassName('tr__cgm')[0];

    oElemento.style.display = !parseInt(e.target.value) ? 'none' : '';

});

function js_validaCaracteres(objeto){
    js_ValidaCamposText(objeto, 1);
    if(/[^0-9]/.test(objeto.value)){
        objeto.value = '';
    }
}

</script>
