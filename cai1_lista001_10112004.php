<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_lista_classe.php");
include("classes/db_listadeb_classe.php");
include("classes/db_listatipos_classe.php");
include("classes/db_arretipo_classe.php");
$clarretipo = new cl_arretipo;
$clarretipo->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label('k60_codigo');
$clrotulo->label('k60_descr');
$clrotulo->label('k00_tipo');
$clrotulo->label('k00_descr');
$clrotulo->label('DBtxt10');
$clrotulo->label('DBtxt11');
db_postmemory($HTTP_POST_VARS);
//db_postmemory($HTTP_SERVER_VARS);
$cllista      = new cl_lista;
$cllistadeb   = new cl_listadeb;
$cllistatipos = new cl_listatipos;
$db_opcao = 1;
$db_botao = true;
if((isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"])=="Incluir"){
    db_inicio_transacao();
    $erro1 = false;
    $data1 = $data1_ano.'-'.$data1_mes.'-'.$data1_dia;
    $data  = $data_ano.'-'.$data_mes.'-'.$data_dia;
    $innerdebitos = "";
    if(isset($dtini_ano) && $dtini_ano != ""){
      $dtini =  $dtini_ano."-".$dtini_mes."-".$dtini_dia;
      $dtfim =  $dtfim_ano."-".$dtfim_mes."-".$dtfim_dia;
      if(isset($dtini_dia) && $dtini_dia != "" && $dtfim_dia == ""){
	$dt = " devedores.dtoper >= '$dtini' and";
      }elseif(isset($dtini_dia) && $dtini_dia != "" && isset($dtfim_dia) && $dtfim_dia != ""){
	$dt = " devedores.dtoper >= '$dtini' and devedores.dtoper <= '$dtfim' and";
      }
      $wheredebitos = " $dt ";
    }
    
    
    if(isset($vencini_ano) && $vencini_ano != ""){
      $vencini =  $vencini_ano."-".$vencini_mes."-".$vencini_dia;
      $vencfim =  $vencfim_ano."-".$vencfim_mes."-".$vencfim_dia;
      if(isset($vencini_dia) && $vencini_dia != "" && $vencfim_dia == ""){
	$dt = " and  devedoresparc.vcto >= '$vencini'";
      }elseif(isset($vencini_dia) && $vencini_dia != "" && isset($vencfim_dia) && $vencfim_dia != ""){
	$dt = " and devedoresparc.vcto >= '$vencini' and devedoresparc.vcto <= '$vencfim'";
      }
      $wherevenc = " $dt ";
    }
    
    $cllista->k60_datadeb = $data;
    $cllista->incluir('');
    if($cllista->erro_status !="0"){
//              echo 'parou na lista';
       $erro1 = true;
    }else{
      $cllista->erro(true,false);       
    }
    $tipos = '';
    if(isset($campos)){
       $tipos = ' and tipo in (';
       $virgula = '';
//       echo $cllista->k60_codigo;exit;
       for ($i=0;$i < sizeof($campos);$i++){
           $cllistatipos->k62_lista = $cllista->k60_codigo;
	   $cllistatipos->k62_tipodeb = $campos[$i];
           $cllistatipos->incluir($cllista->k60_codigo,$campos[$i]);
	   
           if($cllistatipos->erro_status !="0"){
  //            echo 'parou na listatipo';
              $erro1 = true;
           }else{
              $cllistatipos->erro(true,false);       
	   }   
           $tipos .= $virgula.$campos[$i];
           $virgula = ', ';
       }
       $tipos .= ')';
    }
    $limite = '';
    if ($numerolista2 != ''){
      $limite = " limit ".$numerolista2;
    }
    $xmassa = "";
    if ($k60_tipo == 'M'){
       if ($massa == 'f'){
          $xmassa = " and matric not in (select j59_matric from massamat) ";
       }else{
          $xmassa = "";
       }
       $xtipo = 'matric ';
       $matinsc = " matric is not null and matric not in (select k55_matric from notificacao inner join notimatric on k50_notifica = k55_notifica and k50_dtemite > '".$data1."') ";
    }elseif ($k60_tipo == 'I'){
       $xtipo = 'inscr ';
       $matinsc = ' inscr is not null';
       $matinsc = " inscr is not null and inscr not in (select k56_inscr from notificacao inner join notiinscrc on k50_notifica = k56_notifica and k50_dtemite > '".$data1."') ";
    }else{
       $xtipo = 'numcgm ';
       $matinsc = " numcgm not in (select k57_numcgm from notificacao inner join notinumcgm on k50_notifica = k57_notifica and k50_dtemite > '".$data1."') ";
    }
    $sql = "select * from (
            select * from (select $xtipo, devedores.numpre, sum($valores) as total 
	                             from devedores 
 	                             where 
				     ".@$wheredebitos."
				       $matinsc 
				       $xmassa
				       $tipos
	                             group by $xtipo, devedores.numpre) as x
	         where total between $DBtxt10 and $DBtxt11 and total > 0) as y
		 inner join devedoresparc on devedoresparc.numpre = y.numpre and devedoresparc.data = '$data' ".@$wherevenc."
	         $limite
	    ";
    
	   echo $sql;exit;

    $resultlistadeb = pg_exec($sql);
    if (pg_numrows($resultlistadeb) == 0)
       echo "<script>alert('Não existem devedores para as opções escolhidas')</script>";
    for ($ii = 0;$ii < pg_numrows($resultlistadeb);$ii++){
       db_fieldsmemory($resultlistadeb,$ii);
       $cllistadeb->k61_codigo = $cllista->k60_codigo;
       $cllistadeb->k61_numpre = $numpre;
       $cllistadeb->k61_numpar = $numpar;
       $cllistadeb->incluir($cllista->k60_codigo,$numpre,$numpar);
       if($cllistadeb->erro_status !="0" && $erro1 == true){
//              echo 'parou na listadeb';
          $erro1 = true;
       }else{
          $cllistadeb->erro(true,false);       
       }
    }

    if ($erro1 == true){
       db_msgbox('Processamento Concluído Com Sucesso!');
       db_fim_transacao();
    }
}

?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script>


function js_sobe() {
  var F = document.getElementById("campos");
  if(F.selectedIndex != -1 && F.selectedIndex > 0) {
    var SI = F.selectedIndex - 1;
    var auxText = F.options[SI].text;
	var auxValue = F.options[SI].value;
	F.options[SI] = new Option(F.options[SI + 1].text,F.options[SI + 1].value);
	F.options[SI + 1] = new Option(auxText,auxValue);
	js_trocacordeselect();	
	F.options[SI].selected = true;
  }
}
function js_desce() {
  var F = document.getElementById("campos");
  if(F.selectedIndex != -1 && F.selectedIndex < (F.length - 1)) {
    var SI = F.selectedIndex + 1;
    var auxText = F.options[SI].text;
	var auxValue = F.options[SI].value;
	F.options[SI] = new Option(F.options[SI - 1].text,F.options[SI - 1].value);
	F.options[SI - 1] = new Option(auxText,auxValue);
	js_trocacordeselect();
	F.options[SI].selected = true;	
  }
}
function js_excluir() {
  var F = document.getElementById("campos");
  var SI = F.selectedIndex;
  if(F.selectedIndex != -1 && F.length > 0) {
    F.options[SI] = null;
	js_trocacordeselect();
    if(SI <= (F.length - 1)) 
      F.options[SI].selected = true;  
  }
}
function js_insSelect() {
  var texto=document.form1.k00_descr.value;
  var valor=document.form1.k00_tipo.value;
  if(texto != "" && valor != ""){
    var F = document.getElementById("campos");
    var testa = false;
    
    for(var x = 0; x < F.length; x++){

      if(F.options[x].value == valor || F.options[x].text == texto){
        testa = true;
	break;
      }  
    } 
    if(testa == false){
      F.options[F.length] = new Option(texto,valor);
      js_trocacordeselect();
    } 
 }  
   texto=document.form1.k00_descr.value="";
   valor=document.form1.k00_tipo.value="";
 document.form1.lanca.onclick = '';
}

function js_valor(){

  if (document.form1.quebrar.value == 'f'){
    document.getElementById('lordem3').style.visibility='visible';
  }else{
    document.getElementById('lordem3').style.visibility='hidden';
  }
  
}
function js_verifica(){
  var val1 = new Number(document.form1.DBtxt10.value);
  var val2 = new Number(document.form1.DBtxt11.value);
  if(val1.valueOf() >= val2.valueOf()){
    alert('Valor máximo menor que o valor mínimo.');
    return false;
  } 
  var F = document.getElementById("campos").options;
  for(var i = 0;i < F.length;i++) {
    F[i].selected = true;
  }
  return true;
}
function js_emite(){
  itemselecionado = 0;
  numElems = document.form1.grupo.length;
  for (i=0;i<numElems;i++) {
      if (document.form1.grupo[i].checked) itemselecionado = i;
  }
  grupo = document.form1.grupo[itemselecionado].value;


  itemselecionado = 0;
  numElems = document.form1.ordemtipo.length;
  for (i=0;i<numElems;i++) {
      if (document.form1.ordemtipo[i].checked) itemselecionado = i;
  }
  ordemtipo = document.form1.ordemtipo[itemselecionado].value;


  itemselecionado = 0;
  numElems = document.form1.ordem.length;
  for (i=0;i<numElems;i++) {
      if (document.form1.ordem[i].checked) itemselecionado = i;
  }
  ordem = document.form1.ordem[itemselecionado].value;
  
  
  var H = document.getElementById("campos").options;
  if(H.length > 0){
     campo = 'campo=';
     virgula = '';
     for(var i = 0;i < H.length;i++) {
       campo += virgula+H[i].value;
       virgula = '-';
     }
  }else{
     campo = '';
  }
  
  jan = window.open('cai2_devedores_002.php?'+campo+'&massa='+document.form1.massa.value+'&ordemtipo='+ordemtipo+'&data1='+document.form1.data1_ano.value+'-'+document.form1.data1_mes.value+'-'+document.form1.data1_dia.value+'&data='+document.form1.data_ano.value+'-'+document.form1.data_mes.value+'-'+document.form1.data_dia.value+'&quebrar='+document.form1.quebrar.value+'&grupo='+grupo+'&ordem='+ordem+'&numerolista='+document.form1.numerolista2.value+'&valormaximo='+document.form1.DBtxt11.value+'&valorminimo='+document.form1.DBtxt10.value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
}

</script>

<?
if(isset($ordem)){
  if(isset($campos)){
    $xcampo = ''; 
    $tamanho=sizeof($campos);
    $virgula = ''; 
    for($i=0; $i < $tamanho; $i++){
      $xcampo .= $virgula.$campos[$i];
      $virgula = "-";
    }
  }
?>
<script>

function js_emite1(){
  jan = window.open('cai2_devedores_002.php?<?=(isset($xcampo)?'campo='.$xcampo.'&':'')?>ordemtipo=<?=$ordemtipo?>&data=<?=$data_ano.'-'.$data_mes.'-'.$data_dia?>&quebrar='+document.form1.quebrar.value+'&grupo=<?=$grupo?>&ordem=<?=$ordem?>&numerolista=<?=$numerolista2?>&valormaximo=<?=$DBtxt11?>&valorminimo=<?=$DBtxt10?>','','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
}
</script>  
<?
}
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="0">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
     <tr>
       <td colspan="2" >&nbsp;</td>
     </tr>
  <table  border="1" align="center">
    <form name="form1" method="post" action="" onsubmit="return js_verifica();">
     <tr>
        <td nowrap title="<?=@$Tk60_codigo?>">
          <input name="oid" type="hidden" value="<?=@$oid?>">
	  <?=@$Lk60_codigo?>
	   <?
	    if ($db_opcao == 1){
	     $xopcao = 3;
	    }else{
	     $xopcao = $db_opcao;
	    }
	    db_input('k60_codigo',6,$Ik60_codigo,true,'text',$xopcao,"");
            ?>
        </td>
        <td nowrap title="<?=@$Tk60_descr?>">
            <?=@$Lk60_descr?>
           <?
 	    db_input('k60_descr',40,$Ik60_descr,true,'text',$db_opcao,"")
           ?>
        </td>
      </tr>
      <tr>
        <td title="Data da Geração do Cálculo"><strong>Data do Cálculo:</strong>&nbsp;&nbsp;
         <?
	  $sql = "select data from devedores order by data desc limit 1";
	  $result = pg_exec($sql);
	  if (pg_numrows($result) > 0 ){
	     db_fieldsmemory($result,0);
	     $data_ano = substr($data,0,4);
	     $data_mes = substr($data,5,2);
	     $data_dia = substr($data,8,2);
	  }else{
	     $data_ano = '';
	     $data_mes = '';
	     $data_dia = '';
	  }
	  db_inputdata('data',$data_dia,$data_mes,$data_ano,true,'text',4)
	 ?>
        </td>
        <td title="Quantidade de contribuintes a ser listado, ou zero para todos"><strong>Quantidade a Listar:</strong>&nbsp;&nbsp; 
         
          <input name="numerolista2" type="text" id="numerolista22" size="12">
        </td>
        
      </tr>
      <tr> 
        <td title="Intervalo de valores a serem listados"><strong>Valores de:</strong>&nbsp;&nbsp;
          <?
	    db_input('DBtxt10',15,$IDBtxt10,true,'text',$db_opcao);
	  ?>
        &nbsp;&nbsp;
        Até 
          <?
	    db_input('DBtxt11',15,$IDBtxt11,true,'text',$db_opcao);
	  ?>
        
        </td>
        <td ><strong>Tipo de Lista:</strong>&nbsp;&nbsp;
          <input type="radio" name="k60_tipo" value="N" checked >Nome</font>
          <input type="radio" name="k60_tipo" value="I">Inscrição&nbsp;&nbsp;
          <input type="radio" name="k60_tipo" value="M">Matrícula&nbsp;&nbsp;
        </td>
      </tr>
      <tr>
        <td title="Gera lista somente para os contribuintes não notificados após ...">
	  <strong>Somente para não notificados após :</strong>&nbsp;&nbsp;
         <?
	     $data1_ano = substr(date('Y'),0,4);
	     $data1_mes = '01';
	     $data1_dia = '01';
	  db_inputdata('data1',$data1_dia,$data1_mes,$data1_ano,true,'text',4)
	 ?>
        </td>
	<td><strong>Lista Massa Falida :</strong>&nbsp;&nbsp;
         <?
           $x = array("f"=>"NÃO","t"=>"SIM");
           db_select('massa',$x,true,4,"");
         ?>
	<strong>Lista Valores:</strong>&nbsp;&nbsp;
         <?
           $x = array("valor_tudo"=>"Todos valores","valor_vencidos"=>"Valores vencidos");
           db_select('valores',$x,true,4,"");
         ?>
	</td>
     </tr>
<tr>
<td colspan="2">
<table align="center" >
   <tr>
    <td nowrap title="Escolha os tipos de débitos a serem listados ou deixe em branco para listar todos" > 
      <fieldset><Legend>Selecione os Tipos</legend>
      <table border="0">
         <tr>
           <td nowrap title="<?=@$Tk00_tipo?>" colspan="2">
            <?
              db_ancora(@$Lk00_tipo,"js_pesquisadb02_idparag(true);",$db_opcao);
            ?>
            <?
              db_input('k00_tipo',8,$Ik00_tipo,true,'text',$db_opcao," onchange='js_pesquisadb02_idparag(false);'")
            ?>
            <?
              db_input('k00_descr',25,$Ik00_descr,true,'text',3,'')
            ?>
	    <input name="lanca" type="button" value="Lançar" >
           </td>
	 </tr>  
         <tr>   
	   <td align="right" colspan="" width="80%">
         
              <select name="campos[]" id="campos" size="7" style="width:250px" multiple>
              <?
              if(isset($chavepesquisa)){
	         
	 $resulta = $clarretipo->sql_record($clarretipo->sql_query($chavepesquisa,"","k00_tipo,k00_descr",""));   
                  
		 if($clarretipo->numrows!=0){
                      $numrows = $clarretipo->numrows;
		    for($i = 0;$i < $numrows;$i++) {
		      db_fieldsmemory($resulta,$i);
                      echo "<option value=\"$k00_tipo \">$k00_descr</option>";
                   }										    
		   
		 }  

		 
              }
              ?>  
	      
             </select> 
	   </td>
            <td align="left" valign="middle" width="20%"> 
 	    <img style="cursor:hand" onClick="js_sobe();return false" src="imagens/seta_up.gif" width="20" height="20" border="0">
              <br>
              <br>
              <img style="cursor:hand" onClick="js_desce()" src="imagens/seta_down.gif" width="20" height="20" border="0">
              <br>
              <br>
	      <img style="cursor:hand" onClick="js_excluir()" src="imagens/bt_excluir.gif" width="20" height="20" border="0"> 
	   </td>
         </tr>
      </table>
      </fieldset>
    </td>
  </tr>
</table>
</td>
</tr>	
         <tr>
	   <td align="center" colspan="2"><b>Data de operação:<b/>
	   <?
db_inputdata('dtini',@$dtini_dia,@$dtini_mes,@$dtini_ano,true,'text',$db_opcao,"");
	   ?>
	   <b>&nbsp;À&nbsp;</b>
	   <?
db_inputdata('dtfim',@$dtfim_dia,@$dtfim_mes,@$dtfim_ano,true,'text',$db_opcao,"");
	   ?>
	   </td>
	 </tr>
         <tr>
	   <td align="center" colspan="2"><b>Data de vencimento:<b/>
	   <?
db_inputdata('vencini',@$vencini_dia,@$vencini_mes,@$vencini_ano,true,'text',$db_opcao,"");
	   ?>
	   <b>&nbsp;À&nbsp;</b>
	   <?
db_inputdata('vencfim',@$vencfim_dia,@$vencfim_mes,@$vencfim_ano,true,'text',$db_opcao,"");
	   ?>
	   </td>
	 </tr>
      <tr height="40">
         <td align="center" colspan="2">
  	   <input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
	 </td>
      </tr>
  </form>
    </table>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>

<script>
function js_pesquisadb02_idparag(mostra){
  document.form1.lanca.onclick = "";
  parent.bstatus.document.getElementById('st').innerHTML = '<font size="2" color="darkblue"><b>Processando<blink>...</blink></b></font>' ;
  if(mostra==true){
    db_iframe.jan.location.href = 'func_arretipo.php?funcao_js=parent.js_mostradb_paragrafo1|k00_tipo|k00_descr';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }else{
    db_iframe.jan.location.href = 'func_arretipo.php?pesquisa_chave='+document.form1.k00_tipo.value+'&funcao_js=parent.js_mostradb_paragrafo';
  }
}
function js_mostradb_paragrafo(chave,erro){
  document.form1.k00_descr.value = chave; 
  if(erro==true){ 
    document.form1.k00_tipo.focus(); 
    document.form1.k00_tipo.value = ''; 
  }else{
    document.form1.lanca.onclick = js_insSelect;
  }  
    parent.bstatus.document.getElementById('st').innerHTML = "Configuração -> Documentos" ;
  
}
function js_mostradb_paragrafo1(chave1,chave2){
  document.form1.k00_tipo.value = chave1;
  document.form1.k00_descr.value = chave2;
  db_iframe.hide();
  document.form1.lanca.onclick = js_insSelect;
}
function js_pesquisa(){
  db_iframe.mostraMsg();
  db_iframe.show();
  db_iframe.focus();
}
function js_preenchepesquisa(chave){
  db_iframe.hide();
  location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>'+"?chavepesquisa="+chave;
}

</script>
<?
$func_iframe = new janela('db_iframe','');
$func_iframe->posX=1;
$func_iframe->posY=20;
$func_iframe->largura=780;
$func_iframe->altura=430;
$func_iframe->titulo='Pesquisa';
$func_iframe->iniciarVisivel = false;
$func_iframe->mostrar();

if(isset($ordem)){
  echo "<script>
       js_emite();
       </script>";  
}
?>
