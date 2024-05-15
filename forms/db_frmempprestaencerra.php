<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

//MODULO: empenho
$clrotulo = new rotulocampo;
$clrotulo->label("e45_acerta");
$clrotulo->label("e60_codemp");
$clrotulo->label("e45_codmov");

if(isset($tranca)){
  $db_opcao = 33;
  $db_botao= false;
}
if($db_opcao==1){
  $nome ="Encerrar";
}else{
  $nome ="Atualizar";
}
require_once("libs/db_app.utils.php");
db_app::load("scripts.js");
db_app::load("prototype.js");
db_app::load("strings.js");
?>
<form name="form1" method="post" onsubmit="return js_verifica();" action="">
  <center>
    <fieldset style="width: 400px">
      <legend><b>Desconto da prestação de contas</b></legend>
      <table width="400px" style="background:#ccddcc;" cellspacing="0">
        <tr style="text-align: center; font-size: 10; color: darkblue; background-color: #aacccc; border: 1px solid #cccccc;">
          <th style="text-align: center; font-size: 10; color: darkblue; background-color: #aacccc; border: 1px solid #cccccc;">Nota fiscal</th>
          <th style="text-align: center; font-size: 10; color: darkblue; background-color: #aacccc; border: 1px solid #cccccc;">Valor</th>
          <th style="text-align: center; font-size: 10; color: darkblue; background-color: #aacccc; border: 1px solid #cccccc;">Desconto</th>
          <th style="text-align: center; font-size: 10; color: darkblue; background-color: #aacccc; border: 1px solid #cccccc;">Valor total</th>
        </tr>
        <?php $total=0; ?>
        <?php $i=0; ?>
        <?php

        foreach ($dadosItensNota as $itens): ?>
          <tr style="text-align:center;">
            <td style="border:1px solid #AACCCC; font-size: 9; color: black; background-color: #ccddcc;"> <?php echo $itens->e46_nota; ?></td>
            <td id="valorItem<?php echo $i; ?>" style="border:1px solid #AACCCC; font-size: 9; color: black; background-color: #ccddcc;"> <?php echo $itens->valor; ?></td>

            <td style="border:1px solid #AACCCC; font-size: 9; color: black; background-color: #ccddcc;">
              <input type="text" name="desconto<?php echo $i; ?>"
              id="desconto<?php echo $i; ?>"
              value="<?php echo (float)$itens->e999_desconto ?>"
              onkeypress="js_ValidaCampos(this,4,'','','',event);calculaDesconto(<?php echo $i.','.$itens->valor;?>)"
              onkeydown="js_ValidaCampos(this,4,'','','',event);calculaDesconto(<?php echo $i.','.$itens->valor;?>)"
              oninput="js_ValidaCampos(this,4,'','','',event);calculaDesconto(<?php echo $i.','.$itens->valor;?>)"
              >


            </td>
            <td style="border:1px solid #AACCCC; font-size: 9; color: black; background-color: #ccddcc;"id="total<?php echo $i; ?>"><?php echo $itens->valor - $itens->e999_desconto; ?></td>

          </tr>
          <?php $total+=$itens->valor-$itens->e999_desconto; ?>
          <?php $i++; ?>
        <?php endforeach; ?>
          <input type="hidden" name="totalempenho" id="totalempenho" value="<?php echo $nTotalEmp; ?>">
        <input type="hidden" name="nItens" value="<?php echo $i; ?>" id="nItens">
        <tr>
          <td><br></td>
          <td><br></td>
        </tr>
        <tr>
          <th align="right" colspan="3">Total da Prestação de Contas</th>
          <th id="totalfinal"><?php echo db_formatar($total,'f'); ?></th>
        </tr>
      </table>
    </fieldset>


    <fieldset style="width: 400px">
      <legend><b>Encerramento</b></legend>

      <table border="0">
        <tr>
          <td nowrap title="<?=@$Te60_codemp?>">
           <?=@$Le60_codemp?>
         </td>
         <td>
          <?php
          db_input('e60_codemp',10,$Ie60_codemp,true,'text',3);
          db_input('e60_numemp',10,0,true,'hidden',3);
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?php echo $Te45_codmov; ?>">
          <?php echo $Le45_codmov; ?>
        </td>
        <td>
          <?php db_input('e45_codmov', 10, $Ie45_codmov, true); ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Te45_acerta?>">
         <?=@$Le45_acerta?>
       </td>
       <td>
        <?
        if(  empty($e45_acerta_dia)  ){
//$e45_acerta_ano =  date("Y",db_getsession("DB_datausu"));
//$e45_acerta_mes =  date("m",db_getsession("DB_datausu"));
//$e45_acerta_dia =  date("d",db_getsession("DB_datausu"));
        }
        db_inputdata('e45_acerta',@$e45_acerta_dia,@$e45_acerta_mes,@$e45_acerta_ano,true,'text',$db_opcao);
        ?>
      </td>
    </tr>

  </table>
</center>
</fieldset>
<br>
<input name="atualizar" type="submit" id="db_opcao" value="<?=$nome?>" <?=($db_botao==false?"disabled":"")?> >
</form>
<script>
  // Pega o código da movimentacao do campo na primeira aba
  document.form1.e45_codmov.value = CurrentWindow.corpo.iframe_emppresta.document.form1.e45_codmov.value;
  function calculaDesconto(val1,val2){

    total = document.getElementById("total"+val1);
    valorCalculado = parseFloat(val2) - parseFloat(document.getElementById("desconto"+val1).value);

    if(document.getElementById("desconto"+val1).value == ""){
      valorCalculado = parseFloat(val2);
    }


    if(isNaN(valorCalculado)==false){
      if(valorCalculado < 0){
        alert("Desconto maior que o valor da nota.");
        valorCalculado=0;
        document.getElementById("total"+val1).innerText=js_formatar(valorCalculado, 'f');

      }
      document.getElementById("total"+val1).innerText=js_formatar(valorCalculado, 'f');
      ttf=0;
      for (var i = 0; i < document.form1.nItens.value; i++) {
        ttf += parseFloat(document.getElementById("total"+i).innerText.replace(',','.'));
      }

      document.getElementById("totalfinal").innerText = js_formatar(ttf, 'f');
    }
  }
  function js_verifica(){
    var dtDataEncerramento = $F("e45_acerta");
    var valoraux = document.getElementById("totalfinal").innerText.replace(".","");
    var total = parseFloat(valoraux.replace(',','.'));
    var totalempenho = parseFloat(document.form1.totalempenho.value);

    if (dtDataEncerramento == "") {

      alert("Selecione a data de encerramento.");
      return false;

    }

    if (total > totalempenho) {
      alert("Valor da prestação de contas é maior que o empenho.");
      return false;
    }

  }


</script>
