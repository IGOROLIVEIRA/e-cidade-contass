<?
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
//MODULO: sicom
$clmtfis_anexo->rotulo->label();
$clrotulo = new rotulocampo;

?>

<style type="text/css">
  .linhagrid.left {
    text-align: left;
  }
  .linhagrid input[type='text'] {
    /* width: 100%; */
  }
  .linhagrid.fornecedor input[type='text'] {
    width: 85%;
  }
  .normal:hover {
    background-color: #eee;
  }

  .registro_preco {
    width: 90%;
    max-width: 1300px;
    min-width: 1000px;
    margin: 25px auto;
  }
  .DBGrid {
    width: 100%;
    border: 1px solid #888;
    margin: 20px 0;
  }
  .align-center {
    text-align: center;
  }
  .input-inativo {
    background-color: #EEEFF2;
  }
  .th_footer {
    padding: 10px;
  }
  #div_db_anexo{
    width: 1500px;
  }
</style>

<div class="registro_preco">
  <form action="" name="form1" method="post" onsubmit="return validaForm(this);">
    <table class="DBGrid">
      <tr>
        <th class="table_header" style="width: 20px;">Especificações</th>
        <th class="table_header" style="width: 20px;">Valor Corrente <?php echo $mtfis_anoinicialldo ?></th>
        <th class="table_header" style="width: 20px;">Valor Constante <?php echo $mtfis_anoinicialldo ?></th>
        <th class="table_header" style="width: 20px;">Valor Corrente <?php echo $mtfis_anoinicialldo+1 ?></th>
        <th class="table_header" style="width: 20px;">Valor Constante <?php echo $mtfis_anoinicialldo+1 ?></th>
        <th class="table_header" style="width: 20px;">Valor Corrente <?php echo $mtfis_anoinicialldo+2 ?></th>
        <th class="table_header" style="width: 20px;">Valor Constante <?php echo $mtfis_anoinicialldo+2 ?></th>
      </tr>

        <tr class="normal ">
          <?php
          $i = 1;
          foreach ($aEspecificacoes as $aEspecificacao) {

              if($i == 1 || $i == 2 || $i == 8 || $i == 9 || $i == 14 || $i == 17 || $i == 22){
                $db_opcaoaux=3;
              }else{
                $db_opcaoaux=1;
              }

              $rsAnexo = $clmtfis_anexo->sql_record($clmtfis_anexo->sql_query(null, '*', '', "mtfisanexo_especificacao = '$aEspecificacao' and mtfisanexo_ldo = {$mtfisanexo_ldo}"));

              if(pg_num_rows($rsAnexo) > 0) {

              db_fieldsmemory($rsAnexo, 0);
              ${"mtfisanexo_valorcorrente1_$i"} = $mtfisanexo_valorcorrente1;
              ${"mtfisanexo_valorcorrente2_$i"} = $mtfisanexo_valorcorrente2;
              ${"mtfisanexo_valorcorrente3_$i"} = $mtfisanexo_valorcorrente3;

              ${"mtfisanexo_valorconstante1_$i"} = $mtfisanexo_valorconstante1;
              ${"mtfisanexo_valorconstante2_$i"} = $mtfisanexo_valorconstante2;
              ${"mtfisanexo_valorconstante3_$i"} = $mtfisanexo_valorconstante3;
              }
          ?>
          <td class="linhagrid left">
            <input title="" name="mtfisanexo_especificacao<?=$i?>" type="text" id="mtfisanexo_especificacao<?=$i?>" value="<?=$aEspecificacao?>" size="255" maxlength="" readonly="" style="background-color:#DEB887; width:319px;" autocomplete="" tabindex="0">
          </td>
          <td class="linhagrid left">
            <?
            db_input('mtfisanexo_valorcorrente1_'.$i,14,$Imtfisanexo_valorcorrente1,true,'text',$db_opcaoaux,"")
            ?>
          </td>
          <td class="linhagrid left">
            <?
            db_input('mtfisanexo_valorconstante1_'.$i,14,$Imtfisanexo_valorconstante1,true,'text',$db_opcaoaux,"")
            ?>
          </td>
          <td class="linhagrid left">
            <?
            db_input('mtfisanexo_valorcorrente2_'.$i,14,$Imtfisanexo_valorcorrente2,true,'text',$db_opcaoaux,"")
            ?>
          </td>
          <td class="linhagrid left">
            <?
            db_input('mtfisanexo_valorconstante2_'.$i,14,$Imtfisanexo_valorconstante2,true,'text',$db_opcaoaux,"")
            ?>
          </td>
          <td class="linhagrid left">
            <?
            db_input('mtfisanexo_valorcorrente3_'.$i,14,$Imtfisanexo_valorcorrente3,true,'text',$db_opcaoaux,"")
            ?>
          </td>
          <td class="linhagrid left">
            <?
            db_input('mtfisanexo_valorconstante3_'.$i,14,$Imtfisanexo_valorconstante3,true,'text',$db_opcaoaux,"")
            ?>
          </td>
          <?
          db_input('mtfisanexo_ldo',14,$Imtfisanexo_ldo,true,'hidden',$db_opcao,"")
          ?>

        </tr>
    <?php
    $i++;
    }
    ?>

    </table>

    <center>

        <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >

    </center>
  </form>
</div>

<script type="text/javascript" src="scripts/prototype.js"></script>

<script>
  //Receitas Primárias (I)
  //CORRENTE
  document.form1.mtfisanexo_valorcorrente1_2.value = Number(document.form1.mtfisanexo_valorcorrente1_3.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_4.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_5.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_6.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_7.value);

  document.form1.mtfisanexo_valorcorrente2_2.value = Number(document.form1.mtfisanexo_valorcorrente2_3.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_4.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_5.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_6.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_7.value);

  document.form1.mtfisanexo_valorcorrente3_2.value = Number(document.form1.mtfisanexo_valorcorrente3_3.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_4.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_5.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_6.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_7.value);

  //CONSTANTE

  document.form1.mtfisanexo_valorconstante1_2.value = Number(document.form1.mtfisanexo_valorconstante1_3.value)
    + Number(document.form1.mtfisanexo_valorconstante1_4.value)
    + Number(document.form1.mtfisanexo_valorconstante1_5.value)
    + Number(document.form1.mtfisanexo_valorconstante1_6.value)
    + Number(document.form1.mtfisanexo_valorconstante1_7.value);

  document.form1.mtfisanexo_valorconstante2_2.value = Number(document.form1.mtfisanexo_valorconstante2_3.value)
    + Number(document.form1.mtfisanexo_valorconstante2_4.value)
    + Number(document.form1.mtfisanexo_valorconstante2_5.value)
    + Number(document.form1.mtfisanexo_valorconstante2_6.value)
    + Number(document.form1.mtfisanexo_valorconstante2_7.value);

  document.form1.mtfisanexo_valorconstante3_2.value = Number(document.form1.mtfisanexo_valorconstante3_3.value)
    + Number(document.form1.mtfisanexo_valorconstante3_4.value)
    + Number(document.form1.mtfisanexo_valorconstante3_5.value)
    + Number(document.form1.mtfisanexo_valorconstante3_6.value)
    + Number(document.form1.mtfisanexo_valorconstante3_7.value);



  //Despesas Primárias (II)

  //CORRENTE
  document.form1.mtfisanexo_valorcorrente1_9.value = Number(document.form1.mtfisanexo_valorcorrente1_10.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_11.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_12.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_13.value);

  document.form1.mtfisanexo_valorcorrente2_9.value = Number(document.form1.mtfisanexo_valorcorrente2_10.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_11.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_12.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_13.value);

  document.form1.mtfisanexo_valorcorrente3_9.value = Number(document.form1.mtfisanexo_valorcorrente3_10.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_11.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_12.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_13.value);

  //CONSTANTE

  document.form1.mtfisanexo_valorconstante1_9.value = Number(document.form1.mtfisanexo_valorconstante1_10.value)
    + Number(document.form1.mtfisanexo_valorconstante1_11.value)
    + Number(document.form1.mtfisanexo_valorconstante1_12.value)
    + Number(document.form1.mtfisanexo_valorconstante1_13.value);

  document.form1.mtfisanexo_valorconstante2_9.value = Number(document.form1.mtfisanexo_valorconstante2_10.value)
    + Number(document.form1.mtfisanexo_valorconstante2_11.value)
    + Number(document.form1.mtfisanexo_valorconstante2_12.value)
    + Number(document.form1.mtfisanexo_valorconstante2_13.value);

  document.form1.mtfisanexo_valorconstante3_9.value = Number(document.form1.mtfisanexo_valorconstante3_10.value)
    + Number(document.form1.mtfisanexo_valorconstante3_11.value)
    + Number(document.form1.mtfisanexo_valorconstante3_12.value)
    + Number(document.form1.mtfisanexo_valorconstante3_13.value);


</script>
