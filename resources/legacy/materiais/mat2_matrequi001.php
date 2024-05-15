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
	@require("libs/db_conecta.php");
	include("libs/db_sessoes.php");
	include("libs/db_usuariosonline.php");
	include("dbforms/db_funcoes.php");
	require("classes/db_matparam_classe.php");
	require("libs/db_utils.php");

	$clmatparam = new cl_matparam();
	$tobserva   = null;
	$clrotulo   = new rotulocampo();
	$db_opcao   = 1;
	$clrotulo->label("m40_codigo");
  $clrotulo->label("m70_coddepto");
  $clrotulo->label("m70_descr");
  $clrotulo->label("m91_codigo");
  $clrotulo->label("m40_descr");

  $clrotulo->label("");
	$tobserva = 18;
	?>
	<html>
	<head>
	<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script>
  function js_abre(){

   var obj = document.form1;

   var sReqIni  = new String(obj.m40_codigo_ini.value).trim();
   var sReqFim  = new String(obj.m40_codigo_fim.value).trim();

   var sDataIni = new String(obj.perini.value).trim();
   var sDataFim = new String(obj.perfim.value).trim();

   var departamento = String(obj.m70_coddepto.value).trim();
   var almoxarifado = String(obj.m91_codigo.value).trim();



   /*if (    sDataIni == ''
        && sDataFim == ''
        && sReqIni  == ''
        && sReqFim  == '' ) {

     alert('Favor informe algum período ou requisição!');
     return false;

   }*/

   var lMsg = false;

   if ( sReqIni  == '' || sReqFim  == '' ) {

     if (    ( sReqIni  == '' && sReqFim  != '' )
          || ( sReqIni  != '' && sReqFim  == '' )
          || ( sReqIni  == '' && sReqFim  == '' ) ) {
       lMsg = true;
     }

   } else {

     if ( sReqIni > sReqFim ) {
       alert('Número da requisição inicial deve ser menor que a final!');
       return false;
     }

     var nDiferenca = ( sReqFim - sReqIni );

     if ( nDiferenca >= 50 ) {
       lMsg = true;
     }

   }


   if ( lMsg ) {
     if ( confirm('O sistema poderá ficar lento devido ao volume de requisições, deseja realmente emitir relatório?') ) {
       if ( !confirm('Tem certeza de que deseja emitir este relatório, já que o sistema pode ficar lento?') ) {
         return false;
       }
     } else {
       return false;
     }
   }

   if(conferencia.value=="nao"){
     var query  = '';
    	   query += "&atendimento="+obj.atendimento.value;
  		   query += "&ini="+obj.m40_codigo_ini.value;
  		   query += "&fim="+obj.m40_codigo_fim.value;
  		   query += "&perini="+sDataIni;
  			 query += "&perfim="+sDataFim;
  		   query += "&tObserva="+obj.tobserva.value;
  		   query += "&departamento=<?=db_getsession("DB_coddepto")?>";

     var jan = window.open('mat2_matrequi002.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
     jan.moveTo(0,0);

     js_limpar();
   }
   else{
    /*if((departamento=='') && (almoxarifado=='')){
      alert('Favor, adicione algum filtro para o Relatório de Conferência');
      return false;
    }
    else{*/
      var query = '';
           query += "&atendimento="+obj.atendimento.value;
           query += "&ini="+obj.m40_codigo_ini.value;
           query += "&fim="+obj.m40_codigo_fim.value;
           query += "&perini="+sDataIni;
           query += "&perfim="+sDataFim;
           query += "&tObserva="+obj.tobserva.value;
           query += "&departamento=<?=db_getsession("DB_coddepto")?>";
           query += "&coddepto="+departamento;
           query += "&almox="+almoxarifado;

            var jan = window.open('mat2_matrequi003.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
     jan.moveTo(0,0);

     js_limpar();
    //}
  }
}

</script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="document.form1.m40_codigo_ini.focus();" >
 <br><br><br>
  <center>
    <form name="form1">
      <input type="hidden" id="m70_coddepto">
      <input type="hidden" id="m91_codigo">
    <fieldset style="width:420px; padding:20px;">
    <legend><strong>Requisição de Saída de Materiais</strong></legend>
      <table>
			<tr>
			  <td>
			    <b>Tipos de Atendimento:</b>
				</td>
				<td>
				  <?
            $aAtendimento = array ( "a"  => "Atendidas",
																		"pa" => "Parcialmente Atendidas",
												         	  "na" => "Não Atendidas",
													          "t"  => "Todas"
												 				  );
					  db_select("atendimento",$aAtendimento,true,1);
				 ?>
				</td>
			</tr>

      <tr>
			  <td nowrap title="<?=@$Tm40_codigo?>">
				  <b> Requisições: </b>
				</td>
				<td>
				  <?
					  db_input('m40_codigo',10,$Im40_codigo,true,'text',$db_opcao," onchange='js_copiacampo();'","m40_codigo_ini");
						echo " &nbsp;&nbsp; até &nbsp;&nbsp;&nbsp;";
					  db_input('m40_codigo',10,$Im40_codigo,true,'text',$db_opcao,"","m40_codigo_fim")
					?>
				</td>
			</tr>

      <tr>
			  <td>
          <b> Período: </b>
				</td>
				<td>
          <?
	          db_inputdata('perini','','','',true,'text',1,"");
						echo " a ";
	          db_inputdata('perfim','','','',true,'text',1,"");
          ?>
			  </td>
      </tr>

			<tr style='display:none'>
			  <td>
			    <b> Observações: </b>
				</td>
				<td>
				  <?
            $aObs = array( 18 => "Resumida", 181 => "Completa");
					  db_select("tobserva",$aObs,true,1);
				  ?>
				</td>
			</tr>


    </table>
    </fieldset>
    <br>

    <fieldset style="width:420px; padding:20px;">
      <tr nowrap title="<?=@$Tm70_coddepto?>">
        <td>
          <?
            db_ancora('Departamento Solicitante:',"js_mostraDepart(true);",1);
          ?>
        </td>
        <td>
          <?
            db_input('m70_descr', 35, $Im70_descr, true, 'text', 3,"onchange='js_mostraDepart(false);'");
          ?>
        </td>
      </tr>

      <br>
      <br>
      <tr nowrap title="<?=@$Tm91_codigo?>">
        <td align="left">
            <?
              db_ancora('Almoxarifado Origem:',"js_mostraAlmox(true);",1);
            ?>
        </td>
        <?= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?>
        <td align="right">
          <?
            db_input('descrdepto', 35, $Im91_codigo, true, 'text', 3,"onchange='js_mostraAlmox(false);'");
          ?>
        </td>
      </tr>
      <br/><br/>

      <tr>
         <td>
          <b>Relatório de Conferência:</b>
         </td>
        <td>
          <?
            $aConferencia = array ( "nao" => "NÃO",
                                    "sim"  => "SIM"
                                  );
            db_select("conferencia",$aConferencia,true,1);
         ?>
        </td>
      </tr>

    </fieldset>

    <br>
    <input name="pesquisar" align="center" type="button" value="Gerar Relatório" onclick="js_abre();">
    </form>

   </center>
    <?
      db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
    ?>
</body>
</html>

<script>
function js_copiacampo(){
  if(document.form1.m40_codigo_fim.value== ""){
    document.form1.m40_codigo_fim.value = document.form1.m40_codigo_ini.value;
  }
  document.form1.m40_codigo_fim.focus();
}

function js_mostraDepart(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_depart',
                        'func_db_depart.php?funcao_js=parent.js_mostracoddepto1|coddepto|descrdepto',
                        'Pesquisa de Departamentos',true);
  }
}

function js_mostracoddepto1(chave1,chave2) {

    document.form1.m70_coddepto.value = chave1;
    document.form1.m70_descr.value = chave2;
    db_iframe_db_depart.hide();

  }

function js_mostraAlmox(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_almox',
                        'func_db_almox.php?funcao_js=parent.js_mostraAlmox1|m91_codigo|descrdepto',
                        'Pesquisa de Almoxarifado',true);
  }
}

function js_mostraAlmox1(chave1,chave2) {
    document.form1.m91_codigo.value = chave1;
    document.form1.descrdepto.value = chave2;
    db_iframe_db_almox.hide();
  }

function js_limpar(){
  var obj = document.form1;
  obj.m70_descr.value="";
  obj.descrdepto.value="";
  obj.perini.value='';
  obj.perfim.value='';
  obj.m40_codigo_ini.value="";
  obj.m40_codigo_fim.value="";
  obj.conferencia.value="nao";
}

</script>
