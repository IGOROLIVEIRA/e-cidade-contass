<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_gerfcom_classe.php");
$aux = new cl_arquivo_auxiliar;
$clgerfcom = new cl_gerfcom;
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');
$clrotulo->label('r48_semest');
$clrotulo->label("rh56_localtrab");
$clrotulo->label("rh55_descr");
$gform = new cl_formulario_rel_pes;
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
$clrotulo = new rotulocampo;
$clrotulo->label('rh01_regist');
$clrotulo->label('z01_nome');
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script>

function js_filtra(){
  document.form1.submit();
}

function js_processa() {

	   F = document.form1;
	   if(F.filtro.value == 'M'){
		   var listaMatriculas = [];
		   var result = 0;
		   if (F.lista) {
		     for(i=0; i<=F.lista.length-1; i++){
		       F.lista.options[i].selected = true;
			   listaMatriculas[i] = F.lista.options[i].value;
		     }

		     jan = window.open('pes2_ficharegistro002.php?regist=' + listaMatriculas + '&selecao='+ F.selecao.value,
	                 '',
	                   'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	   		 jan.moveTo(0,0);

		   }
		   else if (F.cod_ini){

			   jan = window.open('pes2_ficharegistro002.php?cod_ini=' + F.cod_ini.value + '&cod_fim=' + F.cod_fim.value +'&selecao='+ F.selecao.value,
		                 '',
		                   'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
		   		 jan.moveTo(0,0);

		   }
		   else if (F.selecao) {

			     jan = window.open('pes2_ficharegistro002.php?selecao='+ F.selecao.value,
		                 '',
		                   'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
		   		 jan.moveTo(0,0);

		  }
	  }
	   if(F.filtro.value == 'L'){
		   var listaLotacoes = [];
		   var result = 0;
		   if (F.lista) {
		     for(i=0; i<=F.lista.length-1; i++){
		       F.lista.options[i].selected = true;
		       listaLotacoes[i] = F.lista.options[i].value;
		     }

		     jan = window.open('pes2_ficharegistro002.php?lotacao=' + listaLotacoes + '&selecao='+ F.selecao.value,
	                 '',
	                   'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	   		 jan.moveTo(0,0);

		   }
		   else if (F.cod_ini){

			   jan = window.open('pes2_ficharegistro002.php?cod_iniL=' + F.cod_ini.value + '&cod_fimL=' + F.cod_fim.value +'&selecao='+ F.selecao.value,
		                 '',
		                   'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
		   		 jan.moveTo(0,0);

		   }
		   else if (F.selecao) {

			     jan = window.open('pes2_ficharegistro002.php?selecao='+ F.selecao.value,
		                 '',
		                   'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
		   		 jan.moveTo(0,0);

		  }
	  }


}

</script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="" >
<form name="form1" method="post">
<fieldset style="margin-top: 50px; margin-left: 370px; width: 40%">
	<legend style="font-weight: bold;">Ficha de Registro de Funcionários</legend>
<table align="center" border="0" cellspacing="4" cellpadding="0" >
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr >
        <td align="right" nowrap title="Digite o Ano / Mes de competência" >
        <?
        $gform->selecao = true;
        $gform->desabam = false;
        $gform->manomes = false;
        $gform->gera_form(db_anofolha(),db_mesfolha());
//            echo "<br> $xano    -   $xmes ";
        ?>
        </td>
      </tr>
  <tr>
 <tr>
	  <td align="right" ><strong>Filtro:</strong></td>
	  <td>
	  <?
    if(!isset($filtro)){
      $filtro = 'M';
    }
	  $arr=array("N"=>"Nenhum","M"=>"Matrícula","L"=>"Lotação");
	  db_select("filtro",$arr,true,2,"onchange='js_filtra();'");
	  ?>
	  </td>
	</tr>
	<?
	if (isset($filtro)&&$filtro!=""&&$filtro!="N"){
	?>
	<tr>
	  <td align="right" ><strong>Filtrar por:</strong></td>
	  <td>
	  <?
    if(!isset($filtrar)){
      $filtrar = 'S';
    }
	  $arr1=array("."=>"------------","I"=>"Intervalo","S"=>"Selecionados");
	  db_select("filtrar",$arr1,true,2,"onchange='js_filtra();'");
	  ?>
	  </td>
	</tr>
	<?
	}
	?>
	<?
  if(isset($filtrar)&&isset($filtro)&&$filtro!="N"){
    if($filtro=='M'){
      $func='func_rhpessoal.php';
      $info='Matrícula';
      $cod='rh01_regist';
      $descr='z01_nome';
    }else if ($filtro=='L'){
      $func='func_rhlota.php';
      $info='Lotação';
      $cod='r70_codigo';
      $descr='r70_descr';
    }
    if($filtrar=='I'){
  ?>

        <tr>
          <td>
            <strong><?=@$info?> de</strong>
          </td>
          <td>
            <? db_input('cod_ini',8,'',true,'text',1," onchange='js_copiacampo();'","")  ?>
            <strong> à </strong>
            <? db_input('cod_fim',8,'',true,'text',1,"","")  ?>
          </td>
        </tr>

  <?
    }else if ($filtrar=='S'){
  ?>
  <tr>
    <td colspan=2 >
    <?
    $aux->cabecalho = "<strong>$info</strong>";
    $aux->codigo = "$cod"; //chave de retorno da func
    $aux->descr  = "$descr";   //chave de retorno
    $aux->nomeobjeto = 'lista';
    $aux->funcao_js = 'js_mostra';
    $aux->funcao_js_hide = 'js_mostra1';
    $aux->sql_exec  = "";
    $aux->func_arquivo = "$func";  //func a executar
    $aux->nomeiframe = "db_iframe_lista";
    $aux->localjan = "";
    $aux->onclick = "";
    $aux->db_opcao = 2;
    $aux->tipo = 2;
    $aux->top = 0;
    $aux->linhas = 5;
    $aux->vwhidth = 200;
    $aux->funcao_gera_formulario();
    ?>
    </td>
  </tr>
  <?
    }
  }
  ?>
  <tr>
    <td align="center" colspan="2">
      <input onClick="js_processa();"  type="button" value="Processar" name="processar" onBlur='js_tabulacaoforms("form1","rh01_regist",true,0,"rh01_regist",true);'>
    </td>
  </tr>
</table>
</fieldset>
</form>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>

function js_pesquisarh01_regist(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rhpessoal','func_rhpessoal.php?funcao_js=parent.js_mostrapessoal1|rh01_regist|z01_nome&instit=<?=(db_getsession("DB_instit"))?>','Pesquisa',true);
  }else{
    if(document.form1.rh01_regist.value != ''){
      js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rhpessoal','func_rhpessoal.php?pesquisa_chave='+document.form1.rh01_regist.value+'&funcao_js=parent.js_mostrapessoal&instit=<?=(db_getsession("DB_instit"))?>','Pesquisa',false);
    }else{
      document.form1.z01_nome.value = '';
    }
  }
}
function js_mostrapessoal(chave,erro){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.rh01_regist.focus();
    document.form1.rh01_regist.value = '';
  }
}
function js_mostrapessoal1(chave1,chave2){
  document.form1.rh01_regist.value = chave1;
  document.form1.z01_nome.value   = chave2;
  db_iframe_rhpessoal.hide();
}
function js_copiacampo(){
	  if(document.form1.cod_fim.value== ""){
	    document.form1.cod_fim.value = document.form1.cod_ini.value;
	  }
	  document.form1.cod_fim.focus();
}

js_tabulacaoforms("form1","rh01_regist",true,0,"rh01_regist",true);
</script>
