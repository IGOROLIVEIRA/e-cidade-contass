<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
require("libs/db_app.utils.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");

db_postmemory($HTTP_POST_VARS);

$aux    = new cl_arquivo_auxiliar;
$rotulo = new rotulocampo();
$rotulo->label("m60_codmater");
$rotulo->label("m60_descr");
$rotulo->label("m81_codtipo");
$rotulo->label("m51_codordem");
$rotulo->label("e69_numero");
$rotulo->label("e69_codnota");
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
	<?
	  db_app::load("scripts.js, prototype.js, strings.js");
	  db_app::load("estilos.css");
	?>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc">
<form name="form1" method="post" action="">
  <table width="790" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	  </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	</table>
  <table align="center" border="0">
    <tr>
      <td>
			  <fieldset>
			    <legend><b>Relatório Entrada da Ordem de Compra - Filtros</b></legend>
			  <table align="center" border="0">
			    <tr>
			      <td align="right" title="<?=@$Tm60_codmater?>">
			        <?
			          db_ancora(@$Lm60_codmater,"js_pesquisam60_codmater(true);",1);
			        ?>
			      </td>
			      <td align="left">
			        <?
			          db_input('m60_codmater',6,$Im60_codmater,true,'text',1," onchange='js_pesquisam60_codmater(false);'");
			          db_input('m60_descr',35,$Im60_descr,true,'text',3,'');
			        ?>
			      </td>
			    </tr>


          <tr>
            <td  align="left" nowrap title="<?=$Te69_numero?>">
              <?db_ancora(@$Le69_numero,"js_pesquisae69_numero(true);",1);  ?>
            </td>

            <td>
              <?db_input("e69_numero",6,$Ie69_numero,true,"text",3,"onchange=''");?>
            </td>
            <td hidden="hidden">
              <?db_input("e69_codnota",30,$Ie69_codnota,true,"text",3,"onchange=''");?>
            </td>
          </tr>

          <tr>
             <td  align="left" nowrap title="<?=$Tm51_codordem?>">
               <?db_ancora("Ordem de Compra:","js_pesquisa_ordemcompra(true);",1);?>
             </td>
              <td align="left" nowrap>
                <?db_input("m51_codordem",6,$Im51_codordem,true,"text",4,"onchange=''");?>
              </td>
			    </tr>

          <tr>
            <td colspan="2">
              <?
                $aux->cabecalho = "<strong>Fornecedores</strong>";
                $aux->codigo = "pc60_numcgm"; //chave de retorno da func
                $aux->descr  = "z01_nome";   //chave de retorno
                $aux->nomeobjeto = 'fornecedor';
                $aux->funcao_js = 'js_mostra';
                $aux->funcao_js_hide = 'js_mostra1';
                $aux->sql_exec  = "";
                $aux->func_arquivo = "func_pcforne.php";  //func a executar
                $aux->nomeiframe = "db_iframe_pcforne";
                $aux->localjan = "";
                $aux->onclick = "";
                $aux->db_opcao = 2;
                $aux->tipo = 2;
                $aux->top = 0;
                $aux->linhas = 10;
                $aux->vwhidth = 400;
                $aux->funcao_gera_formulario();
              ?>
            </td>
          </tr>
          <tr>
            <td align="right" >
              <strong>Opções:</strong>
            </td>
            <td>
              <?
                $aOpcao = array("com"=>"Com os Fornecedores selecionados",
                                "sem"=>"Sem os Fornecedores selecionados");
                db_select("vertipo",$aOpcao,true,1);
              ?>
            </td>
          </tr>
          <tr>
            <td align="right">
              <strong>Agrupar por:</strong>
            </td>
            <td align="left">
              <?
                $aAgruparPor = array("agrpf"=>"Por Fornecedor",
                                     "agrpm"=>"Por Material",
                                     "agrpn"=>"Por Nota",
                                     "agrpoc"=>"Por Ordem de Compra");
                db_select("agrupar",$aAgruparPor,true,1);
              ?>
            </td>
          </tr>
          <tr>
            <td align="right">
              <strong>Ordenar:</strong>
            </td>
            <td align="left">
              <?
                $aOrdenar = array("ordfrn"=>"Fornecedor",
                                  "ordoc"=>"Ordem de compra",
                                  "ordnt"=>"Nota",
                                  "orddt"=>"Data");
                db_select("ordenar",$aOrdenar,true,1);
              ?>
            </td>
          </tr>


			    <tr>
			      <td align="right">
			        <b>Período:</b>
			      </td>
			      <td align="left">
              <?
                db_inputdata('dtInicial',null,null,null,true,'text',1,"");
                 echo "<b> a </b> ";
                db_inputdata('dtFinal',null,null,null,true,'text',1,"");
              ?>
			      </td>
			    </tr>
			  </table>
			  </fieldset>
      </td>
    </tr>
    <tr align="center">
      <td>
        <input name="emitir" id="emitir" type="button" value="Visualizar" onclick="js_mandadados();js_limpaCampos();"/>
      </td>
    </tr>
  </table>
</form>
</body>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</html>
<script>
function js_mandadados(){

  var sUrl       = "";
  var sVir       = "";
  var listaTipo  = "";
  var iTam       = $('fornecedor').length;
  var verTipo    = $F('vertipo');
  var codMater   = $F('m60_codmater');
  var agruparPor = $F('agrupar');
  var ordenarPor = $F('ordenar');
  var dtInicial  = $F('dtInicial');
  var dtFinal    = $F('dtFinal');
  var ntFiscal   = $F('e69_numero');
  var sqNtFiscal = $F('e69_codnota');
  var ordemCompra= $F('m51_codordem');


  for ( x = 0; x < iTam; x++ ) {

    listaTipo += sVir+$('fornecedor').options[x].value;
  	sVir       = ",";

  }

 	sUrl += 'codmater='+codMater;
 	sUrl += '&listatipo='+listaTipo;
 	sUrl += '&vertipo='+verTipo;
 	sUrl += '&agrupar='+agruparPor;
 	sUrl += '&ordenar='+ordenarPor;
 	sUrl += '&dtInicial='+dtInicial;
 	sUrl += '&dtFinal='+dtFinal;
  sUrl += '&ntFiscal='+ntFiscal;
  sUrl += '&sqNtFiscal='+sqNtFiscal;
  sUrl += '&ordemCompra='+ordemCompra;

 	jan = window.open('mat2_relentrada002.php?'+sUrl,'',
 	                  'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
}

function js_pesquisam60_codmater(mostra){

  var sUrl1 = 'func_matmater.php?funcao_js=parent.js_mostramatmater1|m60_codmater|m60_descr';
  var sUrl2 = 'func_matmater.php?pesquisa_chave='+$F('m60_codmater')+'&funcao_js=parent.js_mostramatmater';

  if ( mostra == true ) {
    js_OpenJanelaIframe('','db_iframe_matmater',sUrl1,'Pesquisa',true);
  } else {
     if ( $F('m60_codmater') != '' ) {
       js_OpenJanelaIframe('','db_iframe_matmater',sUrl2,'Pesquisa',false);
     } else {
       $('m60_descr').value = '';
     }
  }
}

function js_pesquisa_ordemcompra(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_matordem',
                        'func_matordement.php?funcao_js=parent.js_mostram51_codord1|m51_codordem',
                        'Pesquisa Ordem Compra',true);
  }else{
     if($F('m51_codordem') != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_matordem',
                            'func_matordement.php?pesquisa_chave='+$F('m51_codordem')+'&funcao_js=parent.js_mostram51_codord',
                            'Pesquisa Ordem Compra',false);
     }else{
       $('m51_codordem').value = '';
     }
  }
}

function js_mostram51_codord(chave,erro){
  $('m51_codordem').value = chave;
  if(erro==true){
    $('m51_codordem').focus();
    $('m51_codordem').value = '';
  }
}

function js_mostram51_codord1(chave1){
   $('m51_codordem').value = chave1;
   db_iframe_matordem.hide();
}

function js_mostramatmater(chave,erro){

  $('m60_descr').value = chave;
  if ( erro == true ) {
    $('m60_codmater').focus();
    $('m60_codmater').value = '';
  }
}

function js_mostramatmater1(chave1,chave2){
  $('m60_codmater').value = chave1;
  $('m60_descr').value    = chave2;
  db_iframe_matmater.hide();
}

function js_pesquisae69_numero(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empnota',
                        'func_empnota.php?funcao_js=parent.js_mostrae69_numero1|e69_numero|e69_codnota',
                        'Pesquisa',true);
  }else{
     if($F('e69_numero') != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm',
                            'func_cgm_empenho.php?pesquisa_chave='+$F('e69_numero')+'&funcao_js=parent.js_mostrae69_numero',
                            'Pesquisa',true);
     }else{
       $('e69_numero').value = '';
     }
  }
}
function js_mostrae69_numero(chave,erro){
  //$('e69_numero').value = chave;
  if(erro==true){
    alert("\n\nusuário:\n\n Código informado não é válido !!!\n\nAdministrador:\n\n");
    $('e69_numero').value = '';
    $('e69_numero').focus();
  }
}
function js_mostrae69_numero1(chave1,chave2){
   $('e69_numero').value = chave1;
   $('e69_codnota').value = chave2;
   db_iframe_empnota.hide();
}

function js_limpaCampos(){
  $('e69_numero').value = '';
}

</script>
