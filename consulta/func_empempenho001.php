<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_empempenho_classe.php");
include("classes/db_orcdotacao_classe.php");
include("classes/db_empempaut_classe.php");
include("classes/db_empemphist_classe.php");
include("classes/db_emphist_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clempempenho = new cl_empempenho;
$clorcdotacao = new cl_orcdotacao;
$clempempaut  = new cl_empempaut;
$clempemphist = new cl_empemphist;
$clemphist    = new cl_emphist;

$clempempenho->rotulo->label();
$clempempaut->rotulo->label();
$clempemphist->rotulo->label();
$clemphist->rotulo->label();

if (isset($e60_numemp) and $e60_numemp !=""){
    $res = $clempempenho->sql_record($clempempenho->sql_query($e60_numemp));
    if ($clempempenho->numrows > 0 ) {
         db_fieldsmemory($res,0,true);
         //-----
         $ra=$clempempaut->sql_record($clempempaut->sql_query_file($e60_numemp));
         if ($clempempaut->numrows > 0){
                db_fieldsmemory($ra,0,true);
         }
         //------
         $rhist=$clempemphist->sql_record($clempemphist->sql_query($e60_numemp));
         if ($clempemphist->numrows > 0){
                db_fieldsmemory($rhist,0,true);
         }
    }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script>
 function js_abre_pagordem(){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pagordem','func_pagordem002.php?e60_numemp='+"<?=$e60_numemp ?>",'Pesquisa',true);
 }
 function js_abre_empnota(){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empnota','func_empnota001.php?e60_numemp='+"<?=$e60_numemp ?>",'Pesquisa',true);
 }

 function js_abre_lancamentos(){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conlancam002','func_conlancam002.php?chavepesquisa='+"<?=$e60_numemp  ?>",'Pesquisa',true);
 }
 function js_abre_empempitem(){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempitem','emp1_empempitem005.php?e60_numemp='+"<?=$e60_numemp?>"+'&e55_autori='+"<?=@$e61_autori?>",'Pesquisa',true);
 }
 function pesquisa_cgm(){
   js_JanelaAutomatica('cgm','<?=@$e60_numcgm ?>');
 }
 function pesquisa_dot(){
   js_JanelaAutomatica('orcdotacao','<?=@$e60_coddot ?>','<?=@$e60_anousu ?>');
 }
 function pesquisa_autori(){
   js_JanelaAutomatica('empautoriza','<?=@$e61_autori ?>');
 }
 function js_gerar_relatorio(){
   jan = window.open('emp2_consultas.php?e60_numemp=<?=@$e60_numemp?>','','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
 }

</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!---
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td  align="center" valign="top">
 --->
    <table width="80%" border="0" align="center" cellspacing="0">

     <tr>
       <td  width="25%" align="right" nowrap title="<?=$Te60_numemp?>"><?=$Le60_numemp?></td>
       <td  width="15%" align="left" nowrap><? db_input("e60_numemp",15,"",true,"text",3); ?> </td>
       <td  width="*%" align="left" nowrap title="<?=$Te60_codemp ?>"><?=$Le60_codemp ?>
       <?
        db_input("e60_codemp",15,"",true,"text",3);
       if($e60_anousu!=db_getsession("DB_anousu"))
	 echo "<font color='red'><b>RESTOS À PAGAR</b></font>";
        ?> </td>
     </tr>
     <tr>
       <td  align="right" nowrap title="<?=$Te61_autori?>">
             <?     db_ancora($Le61_autori,"pesquisa_autori();",1);    ?></td>
       <td  align="left" nowrap><? db_input("e61_autori",15,"",true,"text",3); ?> </td>
       <td  align="left" nowrap title="<?=$Te60_destin ?>"><?=$Le60_destin ?><? db_input("e60_destin",40,"",true,"text",3); ?></td>
     </tr>
    <tr>
       <td   align="right" nowrap title="<?=$Te60_emiss?>"><?=$Le60_emiss?></td>
       <td   align="left" nowrap>
             <?  if(isset($e60_emiss) and ($e60_emiss != "")){
	            list($e60_emiss_dia,$e60_emiss_mes,$e60_emiss_ano)= split('[/.-]',$e60_emiss);
                 }
		 db_inputdata('e60_emiss',@$e60_emiss_dia,@$e60_emiss_mes,@$e60_emiss_ano,true,'text',3,"");
	       ?> </td>
       <td  align="left" nowrap title="<?=$Te60_vencim ?>">
             <?=$Le60_vencim ?>
             <? if (isset($e60_vencim) and ($e60_vencim != "")) {
		    list($e60_vencim_dia,$e60_vencim_mes,$e60_vencim_ano) = split('[/.-]',$e60_vencim);
	        }
		db_inputdata('e60_vencim',@$e60_vencim_dia,@$e60_vencim_mes,@$e60_vencim_ano,true,'text',3,"");
    	       ?></td>
     </tr>
     <tr>
       <td  align="right" nowrap title="<?=$Te60_numcgm ?>"><b><? db_ancora($Le60_numcgm,"pesquisa_cgm();",1);?></b></td>
       <td  colspan=2   align="left" nowrap title="<?=$Te60_numcgm ?>">
       <? db_input("e60_numcgm",8,"",true,"text",3);
          db_input("z01_nome",40,"",true,"text",3);   ?>
      </td>
     </tr>
     <?  //-----------  dotacão
       if (isset($e60_coddot) and ($e60_coddot !="")) {
           $sql= $clorcdotacao->sql_query($e60_anousu,$e60_coddot,"o56_elemento,o56_descr,fc_estruturaldotacao(o58_anousu,o58_coddot) as o58_estrutdespesa");
           $res = $clorcdotacao->sql_record($sql);
           if ($clorcdotacao->numrows >0 ){
               db_fieldsmemory($res,0,true);
           }
       }
       ?>
      <tr>
         <td  align="right" nowrap title="<?=$Te60_coddot ?>">
	  <?  db_ancora($Le60_coddot,"pesquisa_dot();",1); ?></td>
         <td  colspan=2   align="left" >
             <? db_input("e60_coddot",8,"",true,"text",3);
	        db_input("o58_estrutdespesa",50,"",true,"text",3);   ?> </td>
     </tr>
     <tr>
          <td  align="right" > &nbsp; </td>
          <td  colspan=2   align="left" nowrap >
              <? db_input("o56_elemento",20,"",true,"text",3);
	         db_input("o56_descr",50,"",true,"text",3);   ?> </td>
     </tr>
     <tr> <!--- valor --->
       <td   align="right" nowrap title="<?=$Te60_vlremp ?>"><?=$Le60_vlremp ?></td>
       <td   align="left" nowrap title="<?=$Te60_vlremp ?>"><? db_input("e60_vlremp",8,"",true,"text",3);?></td>
       <td   align="left" nowrap title="<?=$Te60_codtipo ?>">
          <?=$Le60_codtipo ?>
	  <?  db_input("e60_codtipo",6,"",true,"text",3);
	      db_input("e41_descr",20,"",true,"text",3);   ?>
      </td>
     </tr>

     <tr> <!--- vlrliq --->
       <td   align="right" nowrap title="<?=$Te60_vlrliq ?>"><?=$Le60_vlrliq ?></td>
       <td   align="left" nowrap title="<?=$Te60_vlremp ?>"><? db_input("e60_vlrliq",8,"",true,"text",3);?></td>
       <td   align="left" nowrap >
       <?=@$Le63_codhist ?>
       <?   db_input("e63_codhist",6,"",true,"text",3);
	    db_input("e40_descr",40,"",true,"text",3);  ?></td>
     </tr>
     <tr> <!--- vlrpag --->
        <td align="right" nowrap title="<?=$Te60_vlrpag ?>"><?=$Le60_vlrpag ?></td>
        <td align="left" nowrap title="<?=$Te60_vlrpag ?>"><? db_input("e60_vlrpag",8,"",true,"text",3);?></td>
        <td align="left" nowrap title="<?=$Te60_resumo ?>"><?=$Le60_resumo ?>  </td>

     </tr>
     <tr> <!--- vlranulo --->
        <td align="right" nowrap title="<?=$Te60_vlranu ?>"><?=$Le60_vlranu ?></td>
        <td align="left" nowrap title="<?=$Te60_vlranu ?>"><? db_input("e60_vlranu",8,"",true,"text",3);?></td>
        <td rowspan=2 align="left" ><?  db_textarea("e60_resumo",2,60,""); ?> </td>
     </tr>
      <tr> <!--- vlranulo --->
        <td align="right" nowrap title="Valor a Pagar"><strong>A pagar:</strong></td>
        <td align="left" nowrap title="<?=$Te60_vlranu ?>">
	<?
	$e60_apagar = $e60_vlremp-$e60_vlranu-$e60_vlrpag;
	 db_input("e60_apagar",8,"",true,"text",3);
	?></td>
     </tr>
     <tr>
       <td colspan='3' align='center'>
        <fieldset><legend><b><small>ELEMENTOS</small></b></legend>
         <iframe name="elementos" id="elementos"  marginwidth="0" marginheight="0" frameborder="0" src="func_empempenho002.php?e60_numemp=<?=$e60_numemp?>" width="620" height="100">
         </iframe>
	</fieldset>
       </td>
     </tr>
     <tr>
        <td colspan=3>
           <table border=0 align="center" width="100%">
	   <tr>
             <td>
	          <input type=button value="Consulta Ítens"  onClick="js_abre_empempitem();">
	     </td>
	     <td>
  	          <input type=button value="Consulta Lançamentos" onClick="js_abre_lancamentos();">
	     </td>
             <td>
  	          <input type=button value="Consulta Notas" onClick="js_abre_empnota();">
	     </td>
             <td>
  	          <input type=button value="Consulta Ordens" onClick="js_abre_pagordem();">
	     </td>
             <td>
  	          <input type=button value="Gerar Relatório" onClick="js_gerar_relatorio();">
	     </td>
	   </tr>
	  </table>
	</td>
     </tr>
    </table>
 <!---
    </td>
 </tr>
</table>
--->
</body>
</html>

