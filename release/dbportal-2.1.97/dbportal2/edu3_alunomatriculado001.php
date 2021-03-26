<?
include("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_matricula_classe.php");
include("classes/db_calendario_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clmatricula = new cl_matricula;
$clcalendario = new cl_calendario;
$db_opcao = 1;
$db_botao = true;
$nomeescola = db_getsession("DB_nomedepto");
$escola = db_getsession("DB_coddepto");
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
.cabec{
 text-align: left;
 font-size: 13;
 font-weight: bold;
 color: #DEB887;
 background-color:#444444;
 border:1px solid #CCCCCC;
}
.aluno{
 font-size: 11;
}
</style>
<SCRIPT LANGUAGE="JavaScript">
 team = new Array(
 <?
 # Seleciona todos os calendários
 $sql = "SELECT ed52_i_codigo,ed52_c_descr
         FROM calendario
          inner join calendarioescola on ed38_i_calendario = ed52_i_codigo
         WHERE ed38_i_escola = $escola
         AND ed52_c_passivo = 'N'
         ORDER BY ed52_i_ano DESC";
 $sql_result = pg_query($sql);
 $num = pg_num_rows($sql_result);
 $conta = "";
 while ($row=pg_fetch_array($sql_result)){
  $conta = $conta+1;
  $cod_curso = $row["ed52_i_codigo"];
  echo "new Array(\n";
  $sub_sql = "SELECT DISTINCT ed11_i_codigo,ed11_c_descr,ed11_i_sequencia,ed11_i_ensino,ed10_c_abrev
              FROM turma
               inner join matricula on ed60_i_turma = ed57_i_codigo
               inner join serie on ed11_i_codigo = ed57_i_serie
               inner join ensino on ed10_i_codigo = ed11_i_ensino
              WHERE ed57_i_calendario = '$cod_curso'
              AND ed57_i_escola = $escola
              ORDER BY ed11_i_ensino,ed11_i_sequencia
             ";
  $sub_result = pg_query($sub_sql);
  $num_sub = pg_num_rows($sub_result);
  if ($num_sub>=1){
   # Se achar alguma base para o curso, marca a palavra Todas
   echo "new Array(\"\", ''),\n";
   echo "new Array(\"TODAS\", 0),\n";
   $conta_sub = "";
   while ($rowx=pg_fetch_array($sub_result)){
    $codigo_base=$rowx["ed11_i_codigo"];
    $base_nome=$rowx["ed11_c_descr"];
    $ens_nome=$rowx["ed10_c_abrev"];
    $conta_sub=$conta_sub+1;
    if ($conta_sub==$num_sub){
     echo "new Array(\"$base_nome - $ens_nome\", $codigo_base)\n";
     $conta_sub = "";
    }else{
     echo "new Array(\"$base_nome - $ens_nome\", $codigo_base),\n";
    }
   }
  }else{
   #Se nao achar base para o curso selecionado...
   echo "new Array(\"Calendário sem turmas cadastradas\", '')\n";
  }
  if ($num>$conta){
   echo "),\n";
  }
}
echo ")\n";
echo ");\n";
?>
//Inicio da função JS
function fillSelectFromArray(selectCtrl, itemArray, goodPrompt, badPrompt, defaultItem){
 var i, j;
 var prompt;
 // empty existing items
 for (i = selectCtrl.options.length; i >= 0; i--) {
  selectCtrl.options[i] = null;
 }
 prompt = (itemArray != null) ? goodPrompt : badPrompt;
 if (prompt == null) {
  document.form1.subgrupo.disabled = true;
  j = 0;
 }else{
  selectCtrl.options[0] = new Option(prompt);
  j = 1;
 }
 if (itemArray != null) {
  // add new items
  for (i = 0; i < itemArray.length; i++){
   selectCtrl.options[j] = new Option(itemArray[i][0]);
   if (itemArray[i][1] != null){
    selectCtrl.options[j].value = itemArray[i][1];
   }
   j++;
  }
  selectCtrl.options[0].selected = true;
  document.form1.subgrupo.disabled = false;
 }
 document.form1.procurar.disabled = true;
}
function fillSelectFromArray2(selectCtrl, itemArray, goodPrompt, badPrompt, defaultItem){
 var i, j;
 var prompt;
 // empty existing items
 for (i = selectCtrl.options.length; i >= 0; i--) {
  selectCtrl.options[i] = null;
 }
 prompt = (itemArray != null) ? goodPrompt : badPrompt;
 if (prompt == null) {
  document.form1.subgrupo.disabled = true;
  j = 0;
 }else{
  selectCtrl.options[0] = new Option(prompt);
  j = 1;
 }
 if (itemArray != null) {
  // add new items
  for (i = 0; i < itemArray.length; i++){
   selectCtrl.options[j] = new Option(itemArray[i][0]);
   if (itemArray[i][1] != null){
    selectCtrl.options[j].value = itemArray[i][1];
   }
   <?if(isset($serieescolhida)){?>
    if(<?=trim($serieescolhida)?>==itemArray[i][1]){
     indice = i;
    }
   <?}?>
   j++;
  }
  <?if(isset($serieescolhida)){?>
   selectCtrl.options[indice].selected = true;
   document.form1.procurar.disabled = false;
  <?}else{?>
   selectCtrl.options[0].selected = true;
  <?}?>
  document.form1.subgrupo.disabled = false;
 }
}
//End -->
</script>
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
 <tr>
  <td width="360" height="18">&nbsp;</td>
  <td width="263">&nbsp;</td>
  <td width="25">&nbsp;</td>
  <td width="140">&nbsp;</td>
 </tr>
</table>
<?MsgAviso(db_getsession("DB_coddepto"),"escola");?>
<a name="topo"></a>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td align="center" valign="top" bgcolor="#CCCCCC">
   <br>
   <fieldset style="width:95%"><legend><b><?=$nomeescola?> - Alunos Matriculados</b></legend>
    <table border="0">
     <tr>
      <td align="left">
       <b>Selecione o Calendário:</b><br>
       <select name="grupo" onChange="fillSelectFromArray(this.form.subgrupo, ((this.selectedIndex == -1) ? null : team[this.selectedIndex-1]));" style="font-size:9px;width:150px;height:18px;">
        <option></option>
        <?
        #Seleciona todos os grupos para setar os valores no combo
        $sql = "SELECT ed52_i_codigo,ed52_c_descr
                FROM calendario
                 inner join calendarioescola on ed38_i_calendario = ed52_i_codigo
                WHERE ed38_i_escola = $escola
                AND ed52_c_passivo = 'N'
                ORDER BY ed52_i_ano DESC";
        $sql_result = pg_query($sql);
        while($row=pg_fetch_array($sql_result)){
         $cod_curso=$row["ed52_i_codigo"];
         $desc_curso=$row["ed52_c_descr"];
         ?>
         <option value="<?=$cod_curso;?>" <?=$cod_curso==@$calendario?"selected":""?>><?=$desc_curso;?></option>
         <?
        }
        #Popula o segundo combo de acordo com a escolha no primeiro
        ?>
       </select>
      </td>
      <td>
       <b>Selecione a Série:</b><br>
       <select name="subgrupo" style="font-size:9px;width:150px;height:18px;" disabled onchange="js_botao(this.value);">
        <option value=""></option>
       </select>
      </td>
      <td>
       <b>Filtro:</b><br>
       <select name="filtro" style="font-size:9px;width:180px;height:18px;">
        <option value="1" <?=@$filtro==1?"selected":""?>>GERAL</option>
        <option value="2" <?=@$filtro==2?"selected":""?>>SOMENTE TURMAS</option>
        <option value="3" <?=@$filtro==3?"selected":""?>>SOMENTE PERCENTUAIS</option>
       </select>
      </td>
      <td valign='bottom'>
       <input type="button" name="procurar" value="Procurar" onclick="js_procurar(document.form1.grupo.value,document.form1.subgrupo.value)" disabled>
      </td>
     </tr>
    </table>
   </fieldset>
  </td>
 </tr>
 <?if(isset($calendario)){?>
 <tr>
  <td align="center">
   <script>fillSelectFromArray2(document.form1.subgrupo, ((document.form1.grupo.selectedIndex == -1) ? null : team[document.form1.grupo.selectedIndex-1]));</script>
   <table border="0" cellspacing="2px" width="98%" cellpadding="1px" bgcolor="#cccccc">
    <tr>
     <td align="center" valign="top">
      <table border='1px' width="100%" bgcolor="#cccccc" style="" cellspacing="0px">
       <?
       if($serieescolhida!=0){
        $where = " AND ed57_i_serie = $serieescolhida";
       }else{
        $where = "";
       }
       $sql = "SELECT count(ed60_i_codigo) as qtdmatr,
                      ed10_c_descr,
                      ed11_c_descr,
                      ed57_c_descr,
                      ed57_i_codigo,
                      case when (ed57_i_numvagas-ed57_i_nummatr)<0
                       then 0 else
                       ed57_i_numvagas-ed57_i_nummatr
                      end  as disponiveis,
                      ed57_i_numvagas as vagas,
                      ed15_c_nome
               FROM matricula
                inner join turma on ed57_i_codigo = ed60_i_turma
                inner join serie on ed11_i_codigo = ed57_i_serie
                inner join turno on ed15_i_codigo = ed57_i_turno
                inner join ensino on ed10_i_codigo = ed11_i_ensino
               WHERE ed57_i_calendario = $calendario
               AND ed57_i_escola = $escola
               $where
               GROUP BY ed10_c_descr,ed11_c_descr,ed10_c_abrev,ed11_i_sequencia,ed57_c_descr,ed57_i_codigo,ed57_i_numvagas,ed57_i_nummatr,ed15_c_nome
               ORDER BY ed10_c_abrev,ed11_i_sequencia,ed57_c_descr
              ";
       $result = pg_query($sql);
       //db_criatabela($result);
       $linhas = pg_num_rows($result);
       $ensino = "";
       $serie = "";
       $turma = "";
       $soma_total = 0;
       $soma_matr = 0;
       $soma_evad = 0;
       $soma_canc = 0;
       $soma_tran = 0;
       $soma_prog = 0;
       $soma_disponiveis = 0;
       $soma_vagas = 0;
       $soma_serie_total = 0;
       $soma_serie_matr = 0;
       $soma_serie_evad = 0;
       $soma_serie_canc = 0;
       $soma_serie_tran = 0;
       $soma_serie_prog = 0;
       $soma_serie_disponiveis = 0;
       $soma_serie_vagas = 0;
       $soma_ensino_total = 0;
       $soma_ensino_matr = 0;
       $soma_ensino_evad = 0;
       $soma_ensino_canc = 0;
       $soma_ensino_tran = 0;
       $soma_ensino_prog = 0;
       $soma_ensino_disponiveis = 0;
       $soma_ensino_vagas = 0;
       if($linhas>0){
        $cor1 = "#dbdbdb";
        $cor2 = "#f3f3f3";
        for($c=0;$c<$linhas;$c++){
         db_fieldsmemory($result,$c);
         if($serie!=$ed11_c_descr){
          if($c!=0){
           ?>
           <tr bgcolor="<?=$cor1?>">
            <td width='35%' align='right' >&nbsp;&nbsp;&nbsp;&nbsp;Total da série <?=$serie?></td>
            <td align="center"><b><?=$soma_serie_total?></b></td>
            <td align="center"><?=$soma_serie_matr?></td>
            <td align="center"><?=$soma_serie_evad?></td>
            <td align="center"><?=$soma_serie_canc?></td>
            <td align="center"><?=$soma_serie_tran?></td>
            <td align="center"><?=$soma_serie_prog?></td>
            <td align="center" style='font-weight:bold;color:<?=$soma_serie_disponiveis<=0?"red":"green"?>'><?=$soma_serie_disponiveis?></td>
           </tr>
           <?if($filtro==1||$filtro==3){?>
           <tr bgcolor="<?=$cor1?>">
            <td width='35%' align='right'>Percentuais:</td>
            <td align="center">&nbsp;</td>
            <td align="center"><?=number_format(($soma_serie_matr/$soma_serie_total)*100,2,",",".")?>%</td>
            <td align="center"><?=number_format(($soma_serie_evad/$soma_serie_total)*100,2,",",".")?>%</td>
            <td align="center"><?=number_format(($soma_serie_canc/$soma_serie_total)*100,2,",",".")?>%</td>
            <td align="center"><?=number_format(($soma_serie_tran/$soma_serie_total)*100,2,",",".")?>%</td>
            <td align="center"><?=number_format(($soma_serie_prog/$soma_serie_total)*100,2,",",".")?>%</td>
            <td align="center"><?=number_format(($soma_serie_disponiveis/$soma_serie_vagas)*100,2,",",".")?>%</td>
           </tr>
           <?}?>
           <?
           $soma_serie_total = 0;
           $soma_serie_matr = 0;
           $soma_serie_evad = 0;
           $soma_serie_canc = 0;
           $soma_serie_tran = 0;
           $soma_serie_prog = 0;
           $soma_serie_disponiveis = 0;
           $soma_serie_vagas = 0;
          }
          if($ensino!=$ed10_c_descr){
           if($c!=0){
            ?>
            <tr bgcolor="#BFBFBF">
             <td width='35%' align='right' >&nbsp;&nbsp;&nbsp;&nbsp;Total <?=$ensino?></td>
             <td align="center"><b><?=$soma_ensino_total?></b></td>
             <td align="center"><?=$soma_ensino_matr?></td>
             <td align="center"><?=$soma_ensino_evad?></td>
             <td align="center"><?=$soma_ensino_canc?></td>
             <td align="center"><?=$soma_ensino_tran?></td>
             <td align="center"><?=$soma_ensino_prog?></td>
             <td align="center" style='font-weight:bold;color:<?=$soma_ensino_disponiveis<=0?"red":"green"?>'><?=$soma_ensino_disponiveis?></td>
            </tr>
            <?if($filtro==1||$filtro==3){?>
            <tr bgcolor="#BFBFBF">
             <td width='35%' align='right'>Percentuais:</td>
             <td align="center">&nbsp;</td>
             <td align="center"><?=number_format(($soma_ensino_matr/$soma_ensino_total)*100,2,",",".")?>%</td>
             <td align="center"><?=number_format(($soma_ensino_evad/$soma_ensino_total)*100,2,",",".")?>%</td>
             <td align="center"><?=number_format(($soma_ensino_canc/$soma_ensino_total)*100,2,",",".")?>%</td>
             <td align="center"><?=number_format(($soma_ensino_tran/$soma_ensino_total)*100,2,",",".")?>%</td>
             <td align="center"><?=number_format(($soma_ensino_prog/$soma_ensino_total)*100,2,",",".")?>%</td>
             <td align="center"><?=number_format(($soma_ensino_disponiveis/$soma_ensino_vagas)*100,2,",",".")?>%</td>
            </tr>
            <?}?>
            <?
            $soma_ensino_total = 0;
            $soma_ensino_matr = 0;
            $soma_ensino_evad = 0;
            $soma_ensino_canc = 0;
            $soma_ensino_tran = 0;
            $soma_ensino_prog = 0;
            $soma_ensino_disponiveis = 0;
            $soma_ensino_vagas = 0;
           }
           ?>
           <tr bgcolor="#999999">
            <td colspan="8" class='cabec'><b>&nbsp;&nbsp;<?=$ed10_c_descr?></b></td>
           </tr>
           <?
           $ensino = $ed10_c_descr;
          }
          ?>
          <tr><td height='2' colspan='8' bgcolor='#444444'></td></tr>
          <tr bgcolor="<?=$cor1?>">
           <td width='35%'><b>&nbsp;&nbsp;Série: <?=$ed11_c_descr?></b></td>
           <td align="center"><b>Total</b></td>
           <td align="center"><b>Matriculados</b></td>
           <td align="center"><b>Evadidos</b></td>
           <td align="center"><b>Cancelados</b></td>
           <td align="center"><b>Transferidos</b></td>
           <td align="center"><b>Progredidos</b></td>
           <td align="center"><b>Vagas Disp.</b></td>
          </tr>
          <tr><td height='2' colspan='8' bgcolor='#444444'></td></tr>
          <?
          $serie = $ed11_c_descr;
         }
         ?>
         <?if($filtro==1||$filtro==2){?>
         <tr bgcolor="<?=$cor2?>">
         <td>
          <table width="100%" cellpading="0" cellspacing="0">
           <tr>
            <td width="65%">&nbsp;&nbsp;&nbsp;&nbsp;Turma: <a href="javascript:js_matriculas(<?=$ed57_i_codigo?>,'<?=$ed57_c_descr?>',<?=$calendario?>)" title="Veja os alunos matriculados nesta turma"><?=$ed57_c_descr?></a></td>
            <td>Turno: <?=$ed15_c_nome?></td>
           </tr>
          </table>
         </td>
         <td align="center"><b><?=$qtdmatr?></b></td>
         <?}?>
         <?
         $soma_total += $qtdmatr;
         $soma_disponiveis += $disponiveis;
         $soma_vagas += $vagas;
         $soma_serie_total += $qtdmatr;
         $soma_serie_disponiveis += $disponiveis;
         $soma_serie_vagas += $vagas;
         $soma_ensino_total += $qtdmatr;
         $soma_ensino_disponiveis += $disponiveis;
         $soma_ensino_vagas += $vagas;
         $sql1 = "SELECT count(ed60_i_codigo) as qtdsituacao,
                         ed60_c_situacao
                  FROM matricula
                  WHERE ed60_i_turma = $ed57_i_codigo
                  GROUP BY ed60_c_situacao
                 ";
         $result1 = pg_query($sql1);
         $linhas1 = pg_num_rows($result1);
         $situacoes = array("MATRICULADO","EVADIDO","CANCELADO","TRANSFERIDO","PROGREDIDO");
         $write = false;
         for($z=0;$z<5;$z++){
          for($x=0;$x<$linhas1;$x++){
           db_fieldsmemory($result1,$x);
           if(trim($ed60_c_situacao)=="TRANSFERIDO REDE" || trim($ed60_c_situacao)=="TRANSFERIDO FORA" || trim($ed60_c_situacao)=="TROCA DE TURMA"){
            $ed60_c_situacao = "TRANSFERIDO";
           }elseif(trim($ed60_c_situacao)=="AVANÇADO" || trim($ed60_c_situacao)=="CLASSIFICADO"){
            $ed60_c_situacao = "PROGREDIDO";
           }
           if(trim($ed60_c_situacao)==$situacoes[$z]){
            if($filtro==1||$filtro==2){
             echo "<td align='center'>".$qtdsituacao."</td>";
            }
            $write = true;
            if($ed60_c_situacao=="MATRICULADO") $soma_matr += $qtdsituacao;
            if($ed60_c_situacao=="MATRICULADO") $soma_serie_matr += $qtdsituacao;
            if($ed60_c_situacao=="MATRICULADO") $soma_ensino_matr += $qtdsituacao;
            if($ed60_c_situacao=="EVADIDO")     $soma_evad += $qtdsituacao;
            if($ed60_c_situacao=="EVADIDO")     $soma_serie_evad += $qtdsituacao;
            if($ed60_c_situacao=="EVADIDO")     $soma_ensino_evad += $qtdsituacao;
            if($ed60_c_situacao=="CANCELADO")   $soma_canc += $qtdsituacao;
            if($ed60_c_situacao=="CANCELADO")   $soma_serie_canc += $qtdsituacao;
            if($ed60_c_situacao=="CANCELADO")   $soma_ensino_canc += $qtdsituacao;
            if($ed60_c_situacao=="TRANSFERIDO") $soma_tran += $qtdsituacao;
            if($ed60_c_situacao=="TRANSFERIDO") $soma_serie_tran += $qtdsituacao;
            if($ed60_c_situacao=="TRANSFERIDO") $soma_ensino_tran += $qtdsituacao;
            if($ed60_c_situacao=="PROGREDIDO")    $soma_prog += $qtdsituacao;
            if($ed60_c_situacao=="PROGREDIDO")    $soma_serie_prog += $qtdsituacao;
            if($ed60_c_situacao=="PROGREDIDO")    $soma_ensino_prog += $qtdsituacao;
           }
          }
          if($write==false){
           if($filtro==1||$filtro==2){
            echo "<td align='center'>0</td>";
           }
          }
          $write=false;
         }
         if($filtro==1||$filtro==2){
          echo "<td align='center' style='font-weight:bold;color:".($disponiveis<=0?"red":"green")."'>$disponiveis</td>";
         }
         if($c+1==$linhas){
          ?>
          <tr bgcolor="<?=$cor1?>">
           <td width='35%' align="right">&nbsp;&nbsp;&nbsp;&nbsp;Total da série <?=$serie?></td>
           <td align="center"><b><?=$soma_serie_total?></b></td>
           <td align="center"><?=$soma_serie_matr?></td>
           <td align="center"><?=$soma_serie_evad?></td>
           <td align="center"><?=$soma_serie_canc?></td>
           <td align="center"><?=$soma_serie_tran?></td>
           <td align="center"><?=$soma_serie_prog?></td>
           <td align="center" style='font-weight:bold;color:<?=$soma_serie_disponiveis<=0?"red":"green"?>'><?=$soma_serie_disponiveis?></td>
          </tr>
          <?if($filtro==1||$filtro==3){?>
          <tr bgcolor="<?=$cor1?>">
           <td width='35%' align='right'>Percentuais:</td>
           <td align="center">&nbsp;</td>
           <td align="center"><?=number_format(($soma_serie_matr/$soma_serie_total)*100,2,",",".")?>%</td>
           <td align="center"><?=number_format(($soma_serie_evad/$soma_serie_total)*100,2,",",".")?>%</td>
           <td align="center"><?=number_format(($soma_serie_canc/$soma_serie_total)*100,2,",",".")?>%</td>
           <td align="center"><?=number_format(($soma_serie_tran/$soma_serie_total)*100,2,",",".")?>%</td>
           <td align="center"><?=number_format(($soma_serie_prog/$soma_serie_total)*100,2,",",".")?>%</td>
           <td align="center"><?=number_format(($soma_serie_disponiveis/$soma_serie_vagas)*100,2,",",".")?>%</td>
          </tr>
          <?}?>
          <tr bgcolor="#BFBFBF">
           <td width='35%' align='right' >&nbsp;&nbsp;&nbsp;&nbsp;Total <?=$ensino?></td>
           <td align="center"><b><?=$soma_ensino_total?></b></td>
           <td align="center"><?=$soma_ensino_matr?></td>
           <td align="center"><?=$soma_ensino_evad?></td>
           <td align="center"><?=$soma_ensino_canc?></td>
           <td align="center"><?=$soma_ensino_tran?></td>
           <td align="center"><?=$soma_ensino_prog?></td>
           <td align="center" style='font-weight:bold;color:<?=$soma_ensino_disponiveis<=0?"red":"green"?>'><?=$soma_ensino_disponiveis?></td>
          </tr>
          <?if($filtro==1||$filtro==3){?>
          <tr bgcolor="#BFBFBF">
           <td width='35%' align='right'>Percentuais:</td>
           <td align="center">&nbsp;</td>
           <td align="center"><?=number_format(($soma_ensino_matr/$soma_ensino_total)*100,2,",",".")?>%</td>
           <td align="center"><?=number_format(($soma_ensino_evad/$soma_ensino_total)*100,2,",",".")?>%</td>
           <td align="center"><?=number_format(($soma_ensino_canc/$soma_ensino_total)*100,2,",",".")?>%</td>
           <td align="center"><?=number_format(($soma_ensino_tran/$soma_ensino_total)*100,2,",",".")?>%</td>
           <td align="center"><?=number_format(($soma_ensino_prog/$soma_ensino_total)*100,2,",",".")?>%</td>
           <td align="center"><?=number_format(($soma_ensino_disponiveis/$soma_ensino_vagas)*100,2,",",".")?>%</td>
          </tr>
          <?}?>
          <?
         }
        }
        ?>
         <tr>
          <td colspan="8" class='cabec'><b>&nbsp;&nbsp;TOTAL GERAL</b></td>
         </tr>
         <tr bgcolor="#999999">
          <td width='35%'>&nbsp;</b></td>
          <td align="center"><b>Total</b></td>
          <td align="center"><b>Matriculados</b></td>
          <td align="center"><b>Evadidos</b></td>
          <td align="center"><b>Cancelados</b></td>
          <td align="center"><b>Transferidos</b></td>
          <td align="center"><b>Progredidos</b></td>
          <td align="center"><b>Vagas Disp.</b></td>
         </tr>
         <tr bgcolor="#999999">
          <td width='35%' align='right'><b>Somas:</b></td>
          <td align="center"><b><?=$soma_total?></b></td>
          <td align="center"><b><?=$soma_matr?></b></td>
          <td align="center"><b><?=$soma_evad?></b></td>
          <td align="center"><b><?=$soma_canc?></b></td>
          <td align="center"><b><?=$soma_tran?></b></td>
          <td align="center"><b><?=$soma_prog?></b></td>
          <td align="center"><b><?=$soma_disponiveis?></b></td>
         </tr>
         <tr bgcolor="#999999">
          <td width='35%' align='right'><b>Percentuais:</b></td>
          <td align="center">&nbsp;</td>
          <td align="center"><b><?=number_format(($soma_matr/$soma_total)*100,2,",",".")?>%</b></td>
          <td align="center"><b><?=number_format(($soma_evad/$soma_total)*100,2,",",".")?>%</b></td>
          <td align="center"><b><?=number_format(($soma_canc/$soma_total)*100,2,",",".")?>%</b></td>
          <td align="center"><b><?=number_format(($soma_tran/$soma_total)*100,2,",",".")?>%</b></td>
          <td align="center"><b><?=number_format(($soma_prog/$soma_total)*100,2,",",".")?>%</b></td>
          <td align="center"><b><?=number_format(($soma_disponiveis/$soma_vagas)*100,2,",",".")?>%</b></td>
         </tr>
        <?
       }else{
        ?>
        <table border='1px' width="100%" bgcolor="#cccccc" style="" cellspacing="0px">
         <tr bgcolor="#EAEAEA">
          <td class='aluno'>NENHUMA MATRÍCULA NESTE CALENDÁRIO.</td>
         </tr>
        </table>
        <?
       }
       ?>
      </table>
     </td>
    </tr>
   </table>
   <?}?>
  </td>
 </tr>
</table>
</form>
<?db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
</body>
</html>
<script>
function js_procurar(calendario,turma){
 if(calendario!="" && turma!=""){
  location.href = "edu3_alunomatriculado001.php?calendario="+calendario+"&serieescolhida="+turma+"&filtro="+document.form1.filtro.value;
 }
}
function js_matriculas(turma,descrturma,calendario){
 js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_matriculas','edu3_alunomatriculado002.php?turma='+turma,'Alunos Matriculados na Turma '+descrturma,true);
 location.href = "#topo";
}
function js_botao(valor){
 if(valor!=""){
  document.form1.procurar.disabled = false;
 }else{
  document.form1.procurar.disabled = true;
 }
}
<?if(!isset($serieescolhida) && pg_num_rows($sql_result)>0){?>
 fillSelectFromArray2(document.form1.subgrupo,team[0]);
 document.form1.grupo.options[1].selected = true;
<?}?>
</script>
