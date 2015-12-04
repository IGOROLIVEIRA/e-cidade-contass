<?
//MODULO: biblioteca
$clbaixa->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("bi23_codigo");
$clrotulo->label("bi06_titulo");
if(empty($bi08_inclusao_dia)){
 $bi08_inclusao_dia = date("d",db_getsession("DB_datausu"));
 $bi08_inclusao_mes = date("m",db_getsession("DB_datausu"));
 $bi08_inclusao_ano = date("Y",db_getsession("DB_datausu"));
}
$result = $clexemplar->sql_record($clexemplar->sql_query("","*",""," bi23_codigo = $bi23_codigo"));
if($clexemplar->numrows==0){
 ?>
 <br><br><br>
 <center>
  Nenhum Exemplar encontrado com esta informação.<br><br>
  <input name="voltar" type="button" id="voltar" value="Voltar" onclick="location='bib1_baixa001.php'">
 </center>
 <?
}else{
 db_fieldsmemory($result,0);
 $bi08_exemplar = $bi23_codigo;
 ?>
 <form name="form1" method="post" action="">
 <center>
 <table border="0">
  <tr>
   <td nowrap title="<?=@$Tbi23_codigo?>">
   <?=@$Lbi23_codigo?>
   </td>
   <td>
    <?db_input('bi08_exemplar',10,@$Ibi08_exemplar,true,'text',3,"")?>
    <?db_input('bi06_titulo',60,@$Ibi06_titulo,true,'text',3,'')?>
   </td>
  </tr>
  <tr>
   <td nowrap title="<?=@$Tbi08_descr?>">
    <?=@$Lbi08_descr?>
   </td>
   <td>
    <?db_textarea('bi08_descr',5,50,$Ibi08_descr,true,'text',$db_opcao,"")?>
   </td>
  </tr>
  <tr>
   <td nowrap title="<?=@$Tbi08_inclusao?>">
    <?=@$Lbi08_inclusao?>
   </td>
   <td>
    <?db_inputdata('bi08_inclusao',@$bi08_inclusao_dia,@$bi08_inclusao_mes,@$bi08_inclusao_ano,true,'text',3,"")?>
   </td>
  </tr>
 </table>
 </center>
 <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
 <input name="voltar" type="button" id="voltar" value="Voltar" onclick="location='bib1_baixa001.php'">
 </form>
<?}?>
