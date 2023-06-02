<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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

require_once('libs/db_stdlib.php');
require_once('libs/db_conecta.php');
require_once('libs/db_sessoes.php');
require_once('libs/db_usuariosonline.php');
require_once('dbforms/db_funcoes.php');
require_once("libs/db_app.utils.php");
require_once("libs/db_utils.php");

db_postmemory($HTTP_POST_VARS);

$oDaotfd_agendamentoprestadora = db_utils::getdao('tfd_agendamentoprestadora');
$oDaotfd_agendamentoprestadora->rotulo->label();

$oRotulo = new rotulocampo;
$oDaoTfdPedidoTfd = new cl_tfd_pedidotfd();
$oDaoTfdTipoTratamento = new cl_tfd_tipotratamento();
$oDaoTfdPedidoTfd->rotulo->label();
$oRotulo->label('tf10_i_prestadora');
$oRotulo->label('rh70_estrutural');
$oRotulo->label('tf23_i_procedimento');
$oRotulo->label('tf12_faturabpa');
$oRotulo->label('o41_unidade');
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<?
db_app::load("scripts.js,
              strings.js,
              prototype.js,
              widgets/DBLancador.widget.js,
              widgets/DBToogle.widget.js,
              estilos.css,
            ");
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">

<br><br><br>
<center>
  <form name="form1" method="post" action="">
    <table width="70%">
     
     <tr>
      <td><b>Período:</b>
        
        <?
          db_inputdata('dataini', @$dataini_dia, @$dataini_mes, @$dataini_ano, true, 'text', 1, '');
        ?>
        <b>a</b>
        <?
          db_inputdata('datafim', @$datafim_dia, @$datafim_mes, @$datafim_ano, true, 'text', 1, '');
        ?>
        </td>
      </tr>
      
      <tr>
       <td colspan="2">
         <div id='ctnLancadorFornecedor'></div>
       <td>
      </tr>
     
     <tr>
		  <td colspan="2">
		    <?
			  db_ancora("Unidade","js_pesquisaUnidade(true)",$db_opcao);		    
		    
		      db_input('o41_orgao',10,"",true,'hidden',3,'');
		      
		      db_input('o41_unidade' ,10,$Io41_unidade,true,'text',$db_opcao," onchange='js_pesquisaUnidade(false)'");
		      db_input('o41_descr',40,"",true,'text',3,'');
		    ?>
		  </td>
	    </tr>
     
     <tr>
       <td align="center">
         <br>
         <input name="gerar" id="gerar" type="button" value="Gerar Relatório" onclick="js_gerarRelatorio();">
       </td>
     </tr>
     </table>

  </form>
</center>
<?
db_menu(db_getsession('DB_id_usuario'), db_getsession('DB_modulo'), 
        db_getsession('DB_anousu'), db_getsession('DB_instit')
       );
?>

<script>

function js_validaEnvio() {

  aIni = document.form1.dataini.value.split('/');
  aFim = document.form1.datafim.value.split('/');
  dIni = new Date(aIni[2], aIni[1], aIni[0]);
  dFim = new Date(aFim[2], aFim[1], aFim[0]);

  if (dFim < dIni) {
  			
    alert('Data final não pode ser menor que a data inicial.');
    document.form1.datafim.value = '';
    document.form1.datafim.focus();
    return false;
  
  } 
  if ((document.form1.dataini.value == '' && document.form1.datafim.value != '') 
		          || (document.form1.dataini.value != '' && document.form1.datafim.value == '')) {
	  alert('Para definir um período é necessário selecionar data inicial e final.');
	  return false;
  }

  return true;						

}

function js_gerarRelatorio() {
 
  if (js_validaEnvio()) {

	  var aFornecedores  = getForncedores();
    var sGet = 'dIni='+$F('dataini')+'&dFim='+$F('datafim');
    sGet += '&aFornecedor=' + aFornecedores;
    sGet += '&iUnidade=' + document.form1.o41_unidade.value;
    sGet += '&iOrgao=' + document.form1.o41_orgao.value;
    
    oJan = window.open('emp2_demdesdobramento002.php?'+sGet, '',
                       'width='+(screen.availWidth - 5)+',height='+(screen.availHeight - 40)+
                       ',scrollbars=1,location=0 '
                      );
    oJan.moveTo(0, 0);

  }

}

//ctnLancadorFornecedor
var oLancadorFornecedor = new DBLancador('LancadorFornecedor');
    oLancadorFornecedor.setLabelAncora("Fornecedor:");
    oLancadorFornecedor.setTextoFieldset("Fornecedores");
    oLancadorFornecedor.setTituloJanela("Pesquisar Fornecedores");
    oLancadorFornecedor.setNomeInstancia("oLancadorFornecedor");
    oLancadorFornecedor.setParametrosPesquisa("func_nome.php", ["z01_numcgm", "z01_nome"]);
    oLancadorFornecedor.setGridHeight(150);
    oLancadorFornecedor.show($("ctnLancadorFornecedor"));

function getForncedores() {

  var aFornecedore  = [];
  var aSelecionados = oLancadorFornecedor.getRegistros();
  
  aSelecionados.each( function( oDados, iIndice){
    aFornecedore.push( oDados.sCodigo );
  });
  
  return aFornecedore;
}

function js_pesquisaUnidade(mostra){
	  if(mostra==true){
	    js_OpenJanelaIframe('','db_iframe_orcunidade','func_orcunidade.php?funcao_js=parent.js_mostraorcunidade1|o41_unidade|o41_descr|o41_orgao','Pesquisa',true);
	  }else{
	    js_OpenJanelaIframe('','db_iframe_orcunidade','func_orcunidade.php?pesquisa_chave='+document.form1.o41_unidade.value+'&funcao_js=parent.js_mostraorcunidade','Pesquisa',false);
	  }
	}
	function js_mostraorcunidade(chave,erro,chave2,chave3,chave4){
	  document.form1.o41_descr.value = chave; 
	  document.form1.o41_orgao.value = chave4;
	  if(erro==true){ 
	    document.form1.o41_unidade.focus(); 
	    document.form1.o41_unidade.value = ''; 
	  }
	}
	function js_mostraorcunidade1(chave1,chave2,chave3){
	  document.form1.o41_unidade.value = chave1;
	  document.form1.o41_descr.value = chave2;
	  document.form1.o41_orgao.value = chave3;
	  db_iframe_orcunidade.hide();
	}

</script>
</body>
</html>