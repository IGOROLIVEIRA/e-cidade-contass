<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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
include("classes/db_db_usuarios_classe.php");
include("classes/db_db_depart_classe.php");
include("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);
$cldb_usuarios = new cl_db_usuarios;
$cldb_depart = new cl_db_depart;
$clrotulo = new rotulocampo;
$cldb_usuarios->rotulo->label();
$clrotulo->label("nomeinst");
$clrotulo->label("anousu");
$clrotulo->label("codigo");
$clrotulo->label("login");
$clrotulo->label("id_item");
$clrotulo->label("nome_modulo");
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
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
      <form name="form1" method="post" action="">
      <center>
      <table border="0">
	<tr>
	  <td colspan="4">
	    <table>
	    <?
	    $aux = new cl_arquivo_auxiliar;
	    $aux->cabecalho  = "<strong>USUÁRIOS SELECIONADOS-</strong>";
	    $aux->codigo     = "id_usuario";
	    $aux->descr      = "nome";
	    $aux->nomeobjeto = "usuariossel";
	    $aux->funcao_js  = 'js_mostradb_usuarios';
	    $aux->funcao_js_hide = 'js_mostradb_usuarios1';
	    $aux->func_arquivo = "func_db_usuariosalt.php";
	    $aux->nomeiframe = "db_iframe_db_usuarios";
	    $aux->executa_script_apos_incluir = "document.form1.id_usuario.focus();";
	    $aux->executa_script_lost_focus_campo = "js_insSelectusuariossel();";
	    $aux->executa_script_change_focus = "document.form1.id_usuario.focus();";
	    $aux->mostrar_botao_lancar = false;
	    $aux->db_opcao = 2;
	    $aux->tipo = 2;
	    $aux->top = 20;
	    $aux->linhas = 5;
	    $aux->vwidth = "420";
	    $aux->tamanho_campo_descricao = 40;
	    $aux->ordenar_itens = true;
	    $aux->funcao_gera_formulario();
	    ?>
	    </table>
	  </td>
	</tr>
	<!--
	<tr>
	  <td colspan="4">
	    <table>
	    <?
	    $aux = new cl_arquivo_auxiliar;
	    $aux->cabecalho  = "<strong>DEPARTAMENTOS SELECIONADOS</strong>";
	    $aux->codigo     = "coddepto";
	    $aux->descr      = "descrdepto";
	    $aux->nomeobjeto = "departamentossel";
	    $aux->funcao_js  = 'js_mostradb_depart';
	    $aux->funcao_js_hide = 'js_mostradb_depart1';
	    $aux->func_arquivo = "func_db_depart.php";
	    $aux->nomeiframe = "db_iframe_db_depart";
	    $aux->executa_script_apos_incluir = "document.form1.coddepto.focus();";
	    $aux->executa_script_lost_focus_campo = "js_insSelectdepartamentossel();";
	    $aux->executa_script_change_focus = "document.form1.coddepto.focus();";
	    $aux->mostrar_botao_lancar = false;
	    $aux->db_opcao = 2;
	    $aux->tipo = 2;
	    $aux->top = 20;
	    $aux->linhas = 5;
	    $aux->vwidth = "420";
	    $aux->tamanho_campo_descricao = 46;
	    $aux->funcao_gera_formulario();
	    ?>
	    </table>
	  </td>
	</tr>
	-->
  <tr>
    <td nowrap align="right"><b>Situação dos Usuários:</b></td>
    <td>
      <?
         if (trim(@$tipo_usuario) == ""){
              $tipo_usuario = "1";
         }
         $x = array(
            "T" => "TODOS",
            "0" => "INATIVOS",
            "1" => "ATIVOS",
            "2" => "BLOQUEADOS",
            "3" => "AGUARDANDO ATIVAÇÃO" );
         db_select("tipo_usuario",$x,true,1);
      ?>
    </td>
  </tr>
	<tr>
	  <td nowrap title="<?=@$Tnome_modulo?>" align="right">
	    <?
	    db_ancora($Lnome_modulo,'js_pesquisamodulo(true)',"");
	    ?>
	  </td>
	  <td colspan="3">
	    <?
	    db_input('id_item',5,$Iid_item,true,'text',1,"onchange='js_pesquisamodulo(false);'")
	    ?>
	    <?
	    db_input('nome_modulo',40,$Inome_modulo,true,'text',3,"")
	    ?>
	  </td>
	</tr>
	<tr>
	  <td nowrap title="<?=@$Tnomeinst?>" align="right">
	    <?
	    db_ancora($Lnomeinst,'js_pesquisainstit(true)',"");
	    ?>
	  </td>
	  <td colspan="3">
	    <?
	    db_sel_instit(); // Carrega dados da instituição do usuário
	    db_input('codigo',5,$Icodigo,true,'text',1,"onchange='js_pesquisainstit(false);'")
	    ?>
	    <?
	    db_input('nomeinst',40,$Inomeinst,true,'text',3,"");
	    ?>
	  </td>
	</tr>
	<tr>
	  <td nowrap title="<?=@$Tanousu?>" align="right">
	     <?=@$Lanousu?>
	  </td>
	  <td>
	    <?
	    $arr_anousu = Array();
            $anousu = db_getsession("DB_anousu");
	    for($i=($anousu + 1); $i>($anousu - 10); $i--){
	      $arr_anousu[$i] = $i;
	    }
            db_select("anousu", $arr_anousu, true, 1);
	    ?>
	  </td>
	</tr>
	<tr>
	  <td align="right">
	    <strong>Inserir quebra:</strong>
	  </td>
	  <td>
	    <?
	    $insquebra = "t";
	    $arr_insquebra = Array("t"=>"Sim","f"=>"Não");
            db_select("insquebra", $arr_insquebra, true, 1);
	    ?>
	  <td>
	</tr>

  <tr>
    <td nowrap align="right"><b>Tipo:</b></td>
    <td>
      <?
         if (trim(@$tipo_principal) == ""){
              $tipo_principal = "0";
         }
         $x = array("0"=>"TODOS","1"=>"SOMENTE USUARIOS INTERNOS","2"=>"SOMENTE USUARIOS EXTERNOS","3"=>"SOMENTE PERFIS","4"=>"USUARIOS INTERNOS + PERFIS");
         db_select("tipo_principal",$x,true,1);
      ?>
    </td>
  </tr>
  <!--OC3117-->
  <tr>
    <td nowrap align="right">&nbsp;</td>
    <td>
      <?
         if (trim(@$tipo_principal) == ""){
              $tipo_principal = "0";
         }
         $x = array("a"=>"ANALÍTICO","s"=>"SINTÉTICO");
         db_select("tipoAS",$x,true,1);
      ?>
    </td>
  </tr>
  <!--OC3117-->
	</table>
  <!--OC3161-->
  <fieldset style="width: 37%;">
    <table>
    <legend>PERFIS SELECIONADOS-</legend>
    <tr>
      <td nowrap>
        <b> <? db_ancora("Código do Perfil:","js_cgmlogin(true)",""); ?></b>
      </td>
      <td>
        <? db_input('id_usuarioperfil',8,'',true,'text',""," onchange='js_cgmlogin(false)';"); ?>
      </td>
      <td>
        <? db_input('nomeperfil',40,0,true,'text',3,"") ?>
      </td>
    </tr>
    <tr>
      <td colspan="4">
        <select name="numperfil[]" id="numperfil" style="width: 465px;" size="5" multiple>
        </select>
      </td>
    </tr>
    <tr>
      <td align="center" colspan="4">
        <strong>Dois Cliques sobre o item o exclui.</strong>
      </td>
    </tr>
    </table>
  </fieldset><br><br>
  <!--OC3161-->
        <input name="relatorio" type="button" value="Relatório" onClick="js_relatorio();">
      </center>
      </form>
    </td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
function js_cgmlogin(mostra){
  if (mostra == true){
       js_OpenJanelaIframe('','db_iframe2','func_db_usuariosalt.php?usuext=2&funcao_js=parent.js_mostracgm|id_usuario|nome','Pesquisa',true);
  }
  else {
      js_OpenJanelaIframe('','db_iframe2','func_db_usuariosalt.php?usuext=2&pesquisa_chave='+document.form1.id_usuarioperfil.value+'&funcao_js=parent.js_mostradb_usuarios2','Pesquisa',false);

  }
}


function js_mostradb_usuarios2(chave,chave1){
  document.form1.nomeperfil.value = chave;
  if(chave1){
    document.form1.id_usuarioperfil.value = '';
    document.form1.id_usuarioperfil.focus();
  }else{
    js_insSelectusuariossel1();
  }
  db_iframe2.hide();
}

function js_insSelectusuariossel1(){

  var texto=document.form1.nomeperfil.value;
  var valor=document.form1.id_usuarioperfil.value;
  if(texto != "" && valor != ""){
    var F = document.getElementById("numperfil");
    var valor_default_novo_option = F.length;
    var testa = false;
    for(var x = 0; x < F.length; x++){
      if(F.options[x].value == valor){
        testa = true;
        break;
      }
    }
    if(testa == false){
      if(F.length > 0){;
        for(valor_default_novo_option=0;valor_default_novo_option<F.length;valor_default_novo_option++){
          testavalor1 = new Number(valor);          testavalor2 = new Number(F.options[valor_default_novo_option].value);          if(testavalor1 < testavalor2){
            break;
          }
        }
        F.options[F.length] = new Option(F.options[F.length-1].text,F.options[F.length-1].value);
        for(y=F.length-1;valor_default_novo_option<y;y--){
          F.options[y] = new Option(F.options[y-1].text,F.options[y-1].value);
        }
      }
      F.options[valor_default_novo_option] = new Option(texto,valor);
      for(i=0;i<F.length;i++){
        F.options[i].selected = false;
      }
      F.options[valor_default_novo_option].selected = true;
      js_trocacordeselect();
    }
  }
  texto=document.form1.nomeperfil.value="";
  valor=document.form1.id_usuarioperfil.value="";
  document.form1.id_usuarioperfil.focus();;
}

var optionsperfil = document.getElementById("numperfil");

function js_mostracgm(id_usuario,nome){

  document.form1.id_usuarioperfil.value = id_usuario;
  document.form1.nomeperfil.value       = nome;


  if (!id_usuario || !nome) {
    alert("Perfil inválido!");
    limparPerfil();
    return;
  }

  var jaTem = Array.prototype.filter.call(optionsperfil.children, function(o) {
    return o.value == id_usuario;
  });

  if (jaTem.length > 0) {
    alert("Perfil já inserido.");
    limparPerfil();
    return;
  }

  var option = document.createElement('option');
  option.value = id_usuario;
  option.innerHTML = nome.toUpperCase();
  optionsperfil.appendChild(option);

  limparPerfil();
  db_iframe2.hide();
}
function limparPerfil() {
  document.form1.id_usuarioperfil.value = '';
  document.form1.nomeperfil.value       = '';
}
optionsperfil.addEventListener('dblclick', function excluirPerfil(e) {
  optionsperfil.removeChild(e.target);
});

function js_pesquisainstit(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_config','func_db_config.php?funcao_js=parent.js_mostrainstit1|codigo|nomeinst','Pesquisa',true,'20');
  }else{
     if(document.form1.codigo.value != ''){
       js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_config','func_db_config.php?pesquisa_chave='+document.form1.codigo.value+'&funcao_js=parent.js_mostrainstit','Pesquisa',false);
     }else{
       document.form1.codigo.value = '';
       document.form1.nomeinst.value = "";
     }
  }
}
function js_mostrainstit(chave,erro){
  document.form1.nomeinst.value = chave;
  if(erro==true){
    document.form1.codigo.focus();
    document.form1.codigo.value = '';
  }
}
function js_mostrainstit1(chave1,chave2){
  document.form1.codigo.value = chave1;
  document.form1.nomeinst.value = chave2;
  db_iframe_db_config.hide();
}
function js_pesquisamodulo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe','func_db_modulos.php?funcao_js=parent.js_mostramodulo1|id_item|nome_modulo','Pesquisa',true,'20');
  }else{
     if(document.form1.id_item.value != ''){
       js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe','func_db_modulos.php?pesquisa_chave='+document.form1.id_item.value+'&funcao_js=parent.js_mostramodulo','Pesquisa',false);
     }else{
       document.form1.id_item.value = '';
       document.form1.nome_modulo.value = "";
     }
  }
}
function js_mostramodulo(chave,erro){
  document.form1.nome_modulo.value = chave;
  if(erro==true){
    document.form1.id_item.focus();
    document.form1.id_item.value = '';
  }
}
function js_mostramodulo1(chave1,chave2){
  document.form1.id_item.value = chave1;
  document.form1.nome_modulo.value = chave2;
  db_iframe.hide();
}
function js_relatorio(){
  form = document.form1;

  js_seleciona_combo(form.usuariossel);
  js_seleciona_combo(form.numperfil);

  /*
  js_seleciona_combo(form.departamentossel);
  */

  imprimir = true;
  if(form.usuariossel.length == 0 && form.id_item.value == "" ){
    if(!confirm("Este procedimento poderá ser demorado, deseja continuar?")){
      imprimir = false;
    }
  }

  if(imprimir == true){
    jan = window.open("","db_usuarios_imprime","width="+(screen.availWidth-5)+",height="+(screen.availHeight-40)+",scrollbars=0,location=0 ");
    document.form1.action = "con2_relatoriopermusu002.php";
    document.form1.target = "db_usuarios_imprime";
    setTimeout("document.form1.submit()",1000);
  }

}
</script>
