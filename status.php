<?
require ("libs/db_stdlib.php");
require ("libs/db_conecta.php");
require_once("libs/db_app.utils.php");

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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<style type="text/css">
<!--
.tab  {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 12px;
  color: #000000;
}

#status {
  margin-top: -20px;
  font-weight: bold;
}

#tag {
    padding: 5px;
    color: white;
    border-radius: 15%;
    display: inline-block;
}
-->
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script>
semanas = new Array('Dom','Seg','Ter','Qua','Qui','Sex','Sáb');
meses = new Array('jan','fev','mar','abr','mai','jun','jul','ago','set','out','nov','dez');

function js_adiciona_mensagem(mensagem,erro,modulo,acesso){
  alert(mensagens);
  //mensagens[1] = "Modulo: "+modulo+" Acesso: "+acesso+" Erro: "+erro+" Mensagem: "+mensagem;
}

function js_data() {
  data = new Date();
  var segundos = new String(data.getSeconds());
  if(segundos.length == 1)
    segundos = '0' + segundos;
  var minutos = new String(data.getMinutes());
  if(minutos.length == 1)
    minutos = '0' + minutos;
  
//  document.getElementById('dthr').innerHTML = semanas[data.getDay()] + ', ' +  data.getDate() + '/' + meses[data.getMonth()] + '/' + data.getFullYear() + '-' + data.getHours() + ':' + minutos ;
}

function js_mostra_log(tipo){
  if(tipo==true)
    alert(document.getElementById('logtext').innerHTML);

}

</script>
<?php db_app::load("scripts.js, strings.js, prototype.js, estilos.css"); 

vz

?>
</head>

<body bgcolor=#CCCCCC bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="setInterval('js_data()',1000)">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="533" align="left" valign="middle" class="tab" id="st" ></td>
    <!--<td width="10" align="left" valign="middle" class="tab" id="log" onmouseover="js_mostra_log(true)" onmouseout="js_mostra_log(false)" ><strong>Logs</strong></td>-->
    <td class="tab" width="30" valign="middle" align="left">
          <span id="status">Status </span>
          <span id="tag"></span>
    </td>
    <td width="30"  align="left" valign="middle" class="tab" ><strong>Data:&nbsp</strong></td>
    <td width="80"  align="center" valign="middle" class="tab" id="dtatual" style="color:red; font-weight: bold; "></td>
    <td width="60"  align="left" valign="middle" class="tab" ><strong>Exercício:&nbsp</strong></td>
    <td width="60"  align="center" valign="middle" class="tab" id="dtanousu" style="color:red; font-weight: bold; "></td>
  </tr>
</table>
<div name='logtext' id='logtext' style='visibility:hidden'></div>
</body>
</html>
<?php 

  $sql = "select m.descricao
                  from db_permissao p
                       inner join db_itensmenu m on m.id_item = p .id_item
                  where p.anousu = ".date('Y')." and p.id_item = 3896 and id_usuario = $DB_id_usuario";

  $res = pg_query($sql);

  $x=0;

  if (pg_numrows($res) > 0) {
    $x = 1;
  }

  if($DB_id_usuario == 1 || $DB_administrador == 1){
    $x = 1;
  }

  if ($x==1) {
?>

<script>  

  $("dtatual").observe("click", function() {

     js_OpenJanelaIframe( "top.corpo", 
                          "iframe_retornadatasistema", 
                          "con4_trocadata.php?lParametroExibeMenu=false", 
                          "Retorna Data do Sistema", 
                          true,'20','1','400','400' );

     top.corpo.document.getElementById('Janiframe_retornadatasistema').style.zIndex = 100;
     top.corpo.document.getElementById('Janiframe_retornadatasistema').style.width = 400;
     top.corpo.document.getElementById('Janiframe_retornadatasistema').style.height = 400;
     top.corpo.document.getElementById('Janiframe_retornadatasistema').style.margin = "50px 10px 20px 400px";

  });

</script>

<?php 
  }
?>