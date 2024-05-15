<?
//MODULO: saude
$clagendamentos->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("sd02_c_nome");
$clrotulo->label("sd03_c_nome");
$clrotulo->label("sd05_c_descr");
$clrotulo->label("nome");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
   <td nowrap title="<?=@$Tsd23_i_unidade?>"><?=$Lsd23_i_unidade?></td>
   <td><?=$sd25_i_unidade." - ".$sd02_c_nome?></td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsd23_i_medico?>">
       <?
       db_ancora(@$Lsd23_i_medico,"js_pesquisasd23_i_medico(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('sd23_i_medico',10,$Isd23_i_medico,true,'text',3," onchange='js_pesquisasd23_i_medico(false);'")
?>
       <?
db_input('sd03_c_nome',50,$Isd03_c_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsd23_i_especialidade?>">
       Especialidade
       <?//db_ancora(@$Lsd23_i_especialidade,"js_pesquisasd23_i_especialidade(true);",3);?>
    </td>
    <td>
<?
db_input('sd23_i_especialidade',10,$Isd23_i_especialidade,true,'text',3," onchange='js_pesquisasd23_i_especialidade(false);'")
?>
       <?
db_input('sd05_c_descr',50,$Isd05_c_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
   <td colspan="2"><input type="button" value="Processar" onclick="js_valida()"></td>
  </tr>
  </table>
   Clique em Médico para buscar
  </center>
</form>
<script>

function js_valida(){
 if(document.form1.sd23_i_medico.value==""){
  alert("Escolha o Médico");
  document.form1.sd23_i_medico.focus();
  return false;
 }
 if(document.form1.sd23_i_especialidade.value==""){
  if(confirm("Especialidade está em branco\n\nA especialidade será 0 - NÃO OBRIGATÓRIO\n\nDeseja continuar?")){
   parent.document.formaba.a2.disabled=false;
   CurrentWindow.corpo.iframe_a2.location.href='sau1_agendamentos002.php?unidade=<?=$sd25_i_unidade?>&medico='+document.form1.sd23_i_medico.value+'&especialidade=0';
   parent.mo_camada('a2');
  }
 }else{
  parent.document.formaba.a2.disabled=false;
  CurrentWindow.corpo.iframe_a2.location.href='sau1_agendamentos002.php?unidade=<?=$sd25_i_unidade?>&medico='+document.form1.sd23_i_medico.value+'&especialidade='+document.form1.sd23_i_especialidade.value;
  parent.mo_camada('a2');
 }
}

function js_pesquisasd23_i_medico(){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_a1','db_iframe_medicos','func_unidademedicos.php?unidade=<?=$sd25_i_unidade?>&funcao_js=parent.js_mostramedicos1|sd03_i_codigo|sd03_c_nome|sd27_i_especialidade|sd05_c_descr','Pesquisa',true);
}

function js_mostramedicos1(chave1,chave2,chave3,chave4){
  document.form1.sd23_i_medico.value = chave1;
  document.form1.sd03_c_nome.value = chave2;
  document.form1.sd23_i_especialidade.value = chave3;
  document.form1.sd05_c_descr.value = chave4;
  db_iframe_medicos.hide();
}
</script>
