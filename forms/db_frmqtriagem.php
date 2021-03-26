<?
//MODULO: farmacia
$clqtriagem->rotulo->label();
?>
<form name="form1" method="post" action="" onsubmit="return valida(this);">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tqt_codigo?>">
       <?=@$Lqt_codigo?>
    </td>
    <td>
<?
db_input('qt_codigo',10,$Iqt_codigo,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
          <td class="bold" nowrap='nowrap' title="<?=$Iqt_codigo?>">
            <?
            db_ancora('Paciente', "js_pesquisafa04_i_cgsund(true);", '', '', 'ancora_cgs');
            ?>
          </td>
          <td nowrap='nowrap'>
            <?php

              db_input('qt_paciente', 10, $Iqt_paciente, true, 'text', "", "onchange='js_pesquisafa04_i_cgsund(false); js_init();'");

              if(!empty($qt_paciente)){
                $result = $clcgsund->sql_record($clcgsund->sql_query($qt_paciente));
                db_fieldsmemory($result,0);
              }

              db_input('z01_v_nome', 45, @$Iz01_v_nome, true, 'text', 1,
                       "onchange=\"if(document.form1.z01_v_nome.value=='') document.form1.fa04_i_cgsund.value='';\"");
              //db_criatabela($result);
            ?>
          </td>
  </tr>

  <?
  if(!empty($qt_paciente)){
    $date = new DateTime( $z01_d_nasc ); // data de nascimento
    $interval = $date->diff( new DateTime( date("Y-m-d") ) ); // data definida
    //echo $interval->format( '%Y Anos, %m Meses e %d Dias' );
    $idade = $interval->format('%Y');
    if($idade >= 0 && $idade <= 9){
      $tpIdadePaciente = 1;
    }elseif($idade >= 10 && $idade <= 14){
      $tpIdadePaciente = 2;
    }elseif($idade >= 15 && $idade <= 19){
      $tpIdadePaciente = 3;
    }elseif($idade >= 20 && $idade <= 59){
      $tpIdadePaciente = 4;
    }elseif($idade >= 60){
      $tpIdadePaciente = 5;
    }elseif($idade >= 80){
      $tpIdadePaciente = 6;
    }
  }
  ?>

  <tr>
    <td nowrap title="<?=@$Tqt_stgravida?>">
       <?=@$Lqt_stgravida?>
    </td>
    <td>
<?
db_input('tpIdadePaciente', 10, $tpIdadePaciente, true, 'hidden');
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_stgravida',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_sthipertenso?>">
       <?=@$Lqt_sthipertenso?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_sthipertenso',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_stdiabetico?>">
       <?=@$Lqt_stdiabetico?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_stdiabetico',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_sttuberculose?>">
       <?=@$Lqt_sttuberculose?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_sttuberculose',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_sthanseniase?>">
       <?=@$Lqt_sthanseniase?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_sthanseniase',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_stfuma?>">
       <?=@$Lqt_stfuma?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_stfuma',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <?
  if($tpIdadePaciente == 1){
  ?>
  <tr>
    <td nowrap title="<?=@$Tqt_tpinstrucaoresponsavel?>">
       <?=@$Lqt_tpinstrucaoresponsavel?>
    </td>
    <td>
<?
$x = array("0"=>"","1"=>"Analfabeto","2"=>"Não Analfabeto","3"=>"Ensino fundamental, 1o grau(incompleto)","4"=>"Ensino fundamental, 1o grau(completo)"
  ,"5"=>"Ensino médio, 2o grau (incompleto)","6"=>"Ensino médio, 2o grau (completo)","7"=>"Superior (incompleto)","8"=>"Superior (completo)"
  ,"9"=>"Pós-graduação");
db_select('qt_tpinstrucaoresponsavel',$x,true,$db_opcao,"");
//db_input('qt_tpinstrucaoresponsavel',5,$Iqt_tpinstrucaoresponsavel,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <?
  }if($tpIdadePaciente == 1){
  ?>
  <tr>
    <td nowrap title="<?=@$Tqt_vlpeso?>">
       <?=@$Lqt_vlpeso?>
    </td>
    <td>
<?
db_input('qt_vlpeso',10,$Iqt_vlpeso,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_vlaltura?>">
       <?=@$Lqt_vlaltura?>
    </td>
    <td>
<?
db_input('qt_vlaltura',10,$Iqt_vlaltura,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
   <?
  }

  if($tpIdadePaciente == 2 || $tpIdadePaciente == 3){
  ?>
  <tr>
    <td nowrap title="<?=@$Tqt_stpossuifilhos?>">
       <?=@$Lqt_stpossuifilhos?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_stpossuifilhos',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_stutilizabebida?>">
       <?=@$Lqt_stutilizabebida?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_stutilizabebida',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <?
  }

  if($tpIdadePaciente == 5 || $tpIdadePaciente == 6) {
  ?>
  <tr>
    <td nowrap title="<?=@$Tqt_stsofreuqueda?>">
       <?=@$Lqt_stsofreuqueda?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_stsofreuqueda',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_stconseguelocomover?>">
       <?=@$Lqt_stconseguelocomover?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_stconseguelocomover',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <?
  }
  ?>
  <tr>
    <td nowrap title="Idade inferior a 17 ou superior a 35">
       <?=@$Lqt_stdoencagravidez?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_stdoencagravidez',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_stcolesterolalto?>">
       <?=@$Lqt_stcolesterolalto?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_stcolesterolalto',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_stdoencacoracaofamilia?>">
       <?=@$Lqt_stdoencacoracaofamilia?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_stdoencacoracaofamilia',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_tpdiabetes?>">
       <?=@$Lqt_tpdiabetes?>
    </td>
    <td>
<?
$x = array("1"=>"Tipo I","2"=>"Tipo II");
db_select('qt_tpdiabetes',$x,true,$db_opcao,"");
//db_input('qt_tpdiabetes',5,$Iqt_tpdiabetes,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_sttratamentotuberculose?>">
       <?=@$Lqt_sttratamentotuberculose?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_sttratamentotuberculose',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_stterminotratamento?>">
       <?=@$Lqt_stterminotratamento?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_stterminotratamento',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_sttratamentohanseniase?>">
       <?=@$Lqt_sttratamentohanseniase?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_sttratamentohanseniase',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tqt_stsintomashanseniase?>">
       <?=@$Lqt_stsintomashanseniase?>
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('qt_stsintomashanseniase',$x,true,$db_opcao,"");
?>
    </td>
  </tr>

<?
db_inputdata('qt_dataenviosigaf',@$qt_dataenviosigaf_dia,@$qt_dataenviosigaf_mes,@$qt_dataenviosigaf_ano,true,'hidden',$db_opcao,"");

db_input('db_opcao', 10, $db_opcao, true, 'hidden');
?>

  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_qtriagem','func_qtriagem.php?funcao_js=parent.js_preenchepesquisa|qt_codigo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_qtriagem.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_pesquisafa04_i_cgsund(mostra) {

  if (mostra == true) {
    js_OpenJanelaIframe('',
                        'db_iframe_cgs_und',
                        'func_cgs_novo.php?funcao_js=parent.js_mostracgs_und1|z01_i_cgsund|z01_v_nome',
                        'Pesquisa',
                        true);
  } else {

     if (document.form1.fa04_i_cgsund.value != '') {

        js_OpenJanelaIframe('',
                            'db_iframe_cgs_und',
                            'func_cgs_novo.php?pesquisa_chave='+document.form1.fa04_i_cgsund.value+
                            '&funcao_js=parent.js_mostracgs_und',
                            'Pesquisa',
                            false);

     }

  }
}
function js_mostracgs_und(chave,erro) {
  document.form1.z01_v_nome.value = chave;
  if (erro == true) {

    document.form1.qt_paciente.focus();
    document.form1.qt_paciente.value = '';

  }
}
function js_mostracgs_und1(chave1,chave2) {

  document.form1.qt_paciente.value = chave1;
  document.form1.z01_v_nome.value    = chave2;
  //js_init();
  db_iframe_cgs_und.hide();

  if(document.getElementById('db_opcao').value == 1){
    var paciente = document.getElementById('qt_paciente').value;
    location.href='far1_qtriagem001.php?qt_paciente='+paciente;
  }
  if(document.getElementById('db_opcao').value == 2 || document.getElementById('db_opcao').value == 22 ){
    var paciente = document.getElementById('qt_paciente').value;
    location.href='far1_qtriagem001.php?qt_paciente='+paciente;
  }

}

function valida()
{
  if(document.getElementById('tpIdadePaciente').value == 1){

    if(document.getElementById('qt_tpinstrucaoresponsavel').value == 0){
      alert('Qual seu grau de instrução é um campo obrigatório');
      document.getElementById('qt_tpinstrucaoresponsavel').focus();
      return false;
    }
    if(document.getElementById('qt_vlpeso').value == 0){
      alert('Peso da criança é um campo obrigatório');
      document.getElementById('qt_vlpeso').focus();
      return false;
    }

  }

}
</script>
