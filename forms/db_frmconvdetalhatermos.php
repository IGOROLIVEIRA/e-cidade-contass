<?
//MODULO: contabilidade
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clconvdetalhatermos->rotulo->label();
if(isset($db_opcaoal)){
   $db_opcao=33;
    $db_botao=false;
}else if(isset($opcao) && $opcao=="alterar"){
    $db_botao=true;
    $db_opcao = 2;
}else if(isset($opcao) && $opcao=="excluir"){
    $db_opcao = 3;
    $db_botao=true;
}else{  
    $db_opcao = 1;
    $db_botao=true;
    if(isset($novo) || isset($alterar) ||   isset($excluir) || (isset($incluir) && $sqlerro==false ) ){
     $c208_nroseqtermo = "";
     $c208_dscalteracao = "";
     $c208_dataassinaturatermoaditivo = "";
     $c208_datafinalvigencia = "";
     $c208_valoratualizadoconvenio = "";
     $c208_valoratualizadocontrapartida = "";
     $c208_sequencial = "";
   }
} 
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc208_sequencial?>">
       <?=@$Lc208_sequencial?>
    </td>
    <td> 
<?
db_input('c208_sequencial',12,$Ic208_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="Número Aditivo">
       <strong> Número Aditivo: <strong>
    </td>
    <td> 
<?
db_input('c208_nroseqtermo',2,$Ic208_nroseqtermo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
    <tr>
        <td nowrap title="<?=@$Tc208_datacadastro?>">
            <?=@$Lc208_datacadastro?>
        </td>
        <td>
            <?
            db_inputdata('c208_datacadastro',@$c208_datacadastro_dia,@$c208_datacadastro_mes,@$c208_datacadastro_ano,true,'text',$db_opcao,"")
            ?>
        </td>
    </tr>
  <tr>
    <td nowrap title="<?=@$Tc208_dscalteracao?>">
       <?=@$Lc208_dscalteracao?>
    </td>
    <td> 
<?
db_textarea('c208_dscalteracao', 6, 50,'',true,"text",$db_opcao,"","","",500);
?>
    </td>
  </tr>
    <tr>
        <td nowrap title="<?=@$Tc208_tipotermoaditivo?>">
            <?=@$Lc208_tipotermoaditivo?>
        </td>
        <td>
            <?
            $aTpTermoAtivo = array(
                    '' => 'Selecione',
                    '01' => '01 - Acréscimo',
                    '02' => '02 - Supressão',
                    '03' => '03 - Alteração da Vigência',
                    '04' => '04 - Ampliação do Objeto',
                    '05' => '05 - Indicação de Crédito',
                    '06' => '06 - Alteração de Responsável do Concedente',
                    '07' => '07 - Exclusão de Dados Orçamentários',
                    '08' => '08 - Inclusão de Dados Orçamentários',
                    '09' => '09 - Alteração de Executor',
                    '99' => '99 - Outros'
            );
            db_select("c208_tipotermoaditivo", $aTpTermoAtivo, true, $db_opcao, 'onchange="js_changeTipo(this.value)"');
            ?>
        </td>
    </tr>
    <tr id="dsctipotermoaditivo" <?= $c208_tipotermoaditivo == 99 ? '' : 'style="display: none;"' ?>>
        <td nowrap title="<?=@$Tc208_dsctipotermoaditivo?>">
            <?=@$Lc208_dsctipotermoaditivo?>
        </td>
        <td>
            <?
            db_textarea('c208_dsctipotermoaditivo', 6, 50,'',true,"text",$db_opcao,"","","",250);
            ?>
        </td>
    </tr>
  <tr>
    <td nowrap title="<?=@$Tc208_dataassinaturatermoaditivo?>">
       <?=@$Lc208_dataassinaturatermoaditivo?>
    </td>
    <td> 
<?
db_inputdata('c208_dataassinaturatermoaditivo',@$c208_dataassinaturatermoaditivo_dia,@$c208_dataassinaturatermoaditivo_mes,@$c208_dataassinaturatermoaditivo_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc208_datafinalvigencia?>">
       <?=@$Lc208_datafinalvigencia?>
    </td>
    <td> 
<?
db_inputdata('c208_datafinalvigencia',@$c208_datafinalvigencia_dia,@$c208_datafinalvigencia_mes,@$c208_datafinalvigencia_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc208_valoratualizadoconvenio?>">
       <?=@$Lc208_valoratualizadoconvenio?>
    </td>
    <td> 
<?
db_input('c208_valoratualizadoconvenio',14,$Ic208_valoratualizadoconvenio,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc208_valoratualizadocontrapartida?>">
       <?=@$Lc208_valoratualizadocontrapartida?>
    </td>
    <td> 
<?
db_input('c208_valoratualizadocontrapartida',14,$Ic208_valoratualizadocontrapartida,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
<?
db_input('c208_codconvenio',12,$Ic208_codconvenio,true,'hidden',$db_opcao,"")
?>
  </tr>
    <td colspan="2" align="center">
 <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>  >
 <input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" <?=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> >
    </td>
  </tr>
  </table>
 <table>
  <tr>
    <td valign="top"  align="center">  
    <?
	 $chavepri= array("c208_sequencial"=>@$c208_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $clconvdetalhatermos->sql_query_file(null,"*",null,"c208_codconvenio = $c208_codconvenio");
	 $cliframe_alterar_excluir->campos  ="c208_sequencial,c208_nroseqtermo,c208_dscalteracao,c208_dataassinaturatermoaditivo,c208_datafinalvigencia,c208_valoratualizadoconvenio,c208_valoratualizadocontrapartida,c208_codconvenio";
	 $cliframe_alterar_excluir->legenda="ITENS LANÇADOS";
	 $cliframe_alterar_excluir->iframe_height ="160";
	 $cliframe_alterar_excluir->iframe_width ="700";
	 $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);
    ?>
    </td>
   </tr>
 </table>
  </center>
</form>
<script>
function js_cancelar(){
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","novo");
  opcao.setAttribute("value","true");
  document.form1.appendChild(opcao);
  document.form1.submit();
}

function js_changeTipo(c208_tipotermoaditivo) {
    var dsctipotermoaditivo = document.getElementById('dsctipotermoaditivo');
    if (c208_tipotermoaditivo == 99) {
        dsctipotermoaditivo.style.display = "table-row";
    } else {
        dsctipotermoaditivo.style.display = "none";
        c208_dsctipotermoaditivo.value = '';
    }
}
</script>
