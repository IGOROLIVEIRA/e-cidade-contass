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

              if($i == 2 || $i == 3 || $i == 10 || $i == 11 || $i == 16 || $i == 19 || $i == 24){
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
            db_input('mtfisanexo_valorcorrente1_'.$i,14,$Imtfisanexo_valorcorrente1,true,'text',$db_opcaoaux,"onChange='js_calculavalores()'")
            ?>
          </td>
          <td class="linhagrid left">
            <?
            db_input('mtfisanexo_valorconstante1_'.$i,14,$Imtfisanexo_valorconstante1,true,'text',$db_opcaoaux,"onChange='js_calculavalores()'")
            ?>
          </td>
          <td class="linhagrid left">
            <?
            db_input('mtfisanexo_valorcorrente2_'.$i,14,$Imtfisanexo_valorcorrente2,true,'text',$db_opcaoaux,"onChange='js_calculavalores()'")
            ?>
          </td>
          <td class="linhagrid left">
            <?
            db_input('mtfisanexo_valorconstante2_'.$i,14,$Imtfisanexo_valorconstante2,true,'text',$db_opcaoaux,"onChange='js_calculavalores()'")
            ?>
          </td>
          <td class="linhagrid left">
            <?
            db_input('mtfisanexo_valorcorrente3_'.$i,14,$Imtfisanexo_valorcorrente3,true,'text',$db_opcaoaux,"onChange='js_calculavalores()'")
            ?>
          </td>
          <td class="linhagrid left">
            <?
            db_input('mtfisanexo_valorconstante3_'.$i,14,$Imtfisanexo_valorconstante3,true,'text',$db_opcaoaux,"onChange='js_calculavalores()'")
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

js_calculavalores();

function js_calculavalores()
{
  //CORRENTE
  document.form1.mtfisanexo_valorcorrente1_3.value = 0;
  document.form1.mtfisanexo_valorcorrente1_3.value = Number(document.form1.mtfisanexo_valorcorrente1_3.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_4.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_5.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_6.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_7.value);

  document.form1.mtfisanexo_valorcorrente2_3.value = 0;
  document.form1.mtfisanexo_valorcorrente2_3.value = Number(document.form1.mtfisanexo_valorcorrente2_3.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_4.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_5.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_6.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_7.value);

  document.form1.mtfisanexo_valorcorrente3_3.value = 0;
  document.form1.mtfisanexo_valorcorrente3_3.value = Number(document.form1.mtfisanexo_valorcorrente3_3.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_4.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_5.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_6.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_7.value);

  //CONSTANTE
  document.form1.mtfisanexo_valorconstante1_3.value = 0;
  document.form1.mtfisanexo_valorconstante1_3.value = Number(document.form1.mtfisanexo_valorconstante1_3.value)
    + Number(document.form1.mtfisanexo_valorconstante1_4.value)
    + Number(document.form1.mtfisanexo_valorconstante1_5.value)
    + Number(document.form1.mtfisanexo_valorconstante1_6.value)
    + Number(document.form1.mtfisanexo_valorconstante1_7.value);

  document.form1.mtfisanexo_valorconstante2_3.value = 0;
  document.form1.mtfisanexo_valorconstante2_3.value = Number(document.form1.mtfisanexo_valorconstante2_3.value)
    + Number(document.form1.mtfisanexo_valorconstante2_4.value)
    + Number(document.form1.mtfisanexo_valorconstante2_5.value)
    + Number(document.form1.mtfisanexo_valorconstante2_6.value)
    + Number(document.form1.mtfisanexo_valorconstante2_7.value);

  document.form1.mtfisanexo_valorconstante3_3.value = 0;
  document.form1.mtfisanexo_valorconstante3_3.value = Number(document.form1.mtfisanexo_valorconstante3_3.value)
    + Number(document.form1.mtfisanexo_valorconstante3_4.value)
    + Number(document.form1.mtfisanexo_valorconstante3_5.value)
    + Number(document.form1.mtfisanexo_valorconstante3_6.value)
    + Number(document.form1.mtfisanexo_valorconstante3_7.value);

  //Receitas Primárias (I)
  document.form1.mtfisanexo_valorcorrente1_2.value = 0;
  document.form1.mtfisanexo_valorcorrente1_2.value = Number(document.form1.mtfisanexo_valorcorrente1_3.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_8.value);

  document.form1.mtfisanexo_valorcorrente2_2.value = 0;
  document.form1.mtfisanexo_valorcorrente2_2.value = Number(document.form1.mtfisanexo_valorcorrente2_3.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_8.value);

  document.form1.mtfisanexo_valorcorrente3_2.value = 0;
  document.form1.mtfisanexo_valorcorrente3_2.value = Number(document.form1.mtfisanexo_valorcorrente3_3.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_8.value);

  //CONSTANTE
  document.form1.mtfisanexo_valorconstante1_2.value = 0;
  document.form1.mtfisanexo_valorconstante1_2.value = Number(document.form1.mtfisanexo_valorconstante1_3.value)
    + Number(document.form1.mtfisanexo_valorconstante1_8.value);

  document.form1.mtfisanexo_valorconstante2_2.value = 0;
  document.form1.mtfisanexo_valorconstante2_2.value = Number(document.form1.mtfisanexo_valorconstante2_3.value)
    + Number(document.form1.mtfisanexo_valorconstante2_8.value);

  document.form1.mtfisanexo_valorconstante3_2.value = 0;
  document.form1.mtfisanexo_valorconstante3_2.value = Number(document.form1.mtfisanexo_valorconstante3_3.value)
    + Number(document.form1.mtfisanexo_valorconstante3_8.value);

  //Despesas Primárias (II)
  document.form1.mtfisanexo_valorcorrente1_10.value = 0;
  document.form1.mtfisanexo_valorcorrente1_10.value = Number(document.form1.mtfisanexo_valorcorrente1_11.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_14.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_15.value);

  document.form1.mtfisanexo_valorcorrente2_10.value = 0;
  document.form1.mtfisanexo_valorcorrente2_10.value = Number(document.form1.mtfisanexo_valorcorrente2_11.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_14.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_15.value);

  document.form1.mtfisanexo_valorcorrente3_10.value = 0;
  document.form1.mtfisanexo_valorcorrente3_10.value = Number(document.form1.mtfisanexo_valorcorrente3_11.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_14.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_15.value);

  //CONSTANTE

  document.form1.mtfisanexo_valorconstante1_10.value = 0;
  document.form1.mtfisanexo_valorconstante1_10.value = Number(document.form1.mtfisanexo_valorconstante1_11.value)
    + Number(document.form1.mtfisanexo_valorconstante1_14.value)
    + Number(document.form1.mtfisanexo_valorconstante1_15.value);

  document.form1.mtfisanexo_valorconstante2_10.value = 0;
  document.form1.mtfisanexo_valorconstante2_10.value = Number(document.form1.mtfisanexo_valorconstante2_11.value)
    + Number(document.form1.mtfisanexo_valorconstante2_14.value)
    + Number(document.form1.mtfisanexo_valorconstante2_15.value);

  document.form1.mtfisanexo_valorconstante3_10.value = 0;
  document.form1.mtfisanexo_valorconstante3_10.value = Number(document.form1.mtfisanexo_valorconstante3_11.value)
    + Number(document.form1.mtfisanexo_valorconstante3_14.value)
    + Number(document.form1.mtfisanexo_valorconstante3_15.value);

  //Despesas Primárias Correntes = 12,13
  document.form1.mtfisanexo_valorcorrente1_11.value = 0;
  document.form1.mtfisanexo_valorcorrente1_11.value = Number(document.form1.mtfisanexo_valorcorrente1_12.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_13.value);

  document.form1.mtfisanexo_valorcorrente2_11.value = 0;
  document.form1.mtfisanexo_valorcorrente2_11.value = Number(document.form1.mtfisanexo_valorcorrente2_12.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_13.value);

  document.form1.mtfisanexo_valorcorrente3_11.value = 0;
  document.form1.mtfisanexo_valorcorrente3_11.value = Number(document.form1.mtfisanexo_valorcorrente3_12.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_13.value);

  //CONSTANTE

  document.form1.mtfisanexo_valorconstante1_11.value = 0;
  document.form1.mtfisanexo_valorconstante1_11.value = Number(document.form1.mtfisanexo_valorconstante1_12.value)
    + Number(document.form1.mtfisanexo_valorconstante1_13.value);

  document.form1.mtfisanexo_valorconstante2_11.value = 0;
  document.form1.mtfisanexo_valorconstante2_11.value = Number(document.form1.mtfisanexo_valorconstante2_12.value)
    + Number(document.form1.mtfisanexo_valorconstante2_13.value);

  document.form1.mtfisanexo_valorconstante3_11.value = 0;
  document.form1.mtfisanexo_valorconstante3_11.value = Number(document.form1.mtfisanexo_valorconstante3_12.value)
    + Number(document.form1.mtfisanexo_valorconstante3_13.value);


  //Resultado Primário (III) = (I - II)

  //CORRENTE
  document.form1.mtfisanexo_valorcorrente1_16.value = 0;
  document.form1.mtfisanexo_valorcorrente1_16.value = Number(document.form1.mtfisanexo_valorcorrente1_2.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_10.value);

  document.form1.mtfisanexo_valorcorrente2_16.value = 0;
  document.form1.mtfisanexo_valorcorrente2_16.value = Number(document.form1.mtfisanexo_valorcorrente2_2.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_10.value);

  document.form1.mtfisanexo_valorcorrente3_16.value = 0;
  document.form1.mtfisanexo_valorcorrente3_16.value = Number(document.form1.mtfisanexo_valorcorrente3_2.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_10.value);

  //CONSTANTE
  document.form1.mtfisanexo_valorconstante1_16.value = 0;
  document.form1.mtfisanexo_valorconstante1_16.value = Number(document.form1.mtfisanexo_valorconstante1_2.value)
    + Number(document.form1.mtfisanexo_valorconstante1_10.value);

  document.form1.mtfisanexo_valorconstante2_16.value = 0;
  document.form1.mtfisanexo_valorconstante2_16.value = Number(document.form1.mtfisanexo_valorconstante2_2.value)
    + Number(document.form1.mtfisanexo_valorconstante2_10.value);

  document.form1.mtfisanexo_valorconstante3_16.value = 0;
  document.form1.mtfisanexo_valorconstante3_16.value = Number(document.form1.mtfisanexo_valorconstante3_2.value)
    + Number(document.form1.mtfisanexo_valorconstante3_10.value);

  //Resultado Nominal (VI) = (III + (IV -V)

  //CORRENTE
  document.form1.mtfisanexo_valorcorrente1_19.value = 0;
  document.form1.mtfisanexo_valorcorrente1_19.value = Number(document.form1.mtfisanexo_valorcorrente1_16.value)
    + Number(document.form1.mtfisanexo_valorcorrente1_17.value)
    - Number(document.form1.mtfisanexo_valorcorrente1_18.value);

  document.form1.mtfisanexo_valorcorrente2_19.value = 0;
  document.form1.mtfisanexo_valorcorrente2_19.value = Number(document.form1.mtfisanexo_valorcorrente2_16.value)
    + Number(document.form1.mtfisanexo_valorcorrente2_17.value)
    - Number(document.form1.mtfisanexo_valorcorrente2_18.value);

  document.form1.mtfisanexo_valorcorrente3_19.value = 0;
  document.form1.mtfisanexo_valorcorrente3_19.value = Number(document.form1.mtfisanexo_valorcorrente3_16.value)
    + Number(document.form1.mtfisanexo_valorcorrente3_17.value)
    - Number(document.form1.mtfisanexo_valorcorrente3_18.value);

  //CONSTANTE
  document.form1.mtfisanexo_valorconstante1_19.value = 0;
  document.form1.mtfisanexo_valorconstante1_19.value = Number(document.form1.mtfisanexo_valorconstante1_16.value)
    + Number(document.form1.mtfisanexo_valorconstante1_17.value)
    - Number(document.form1.mtfisanexo_valorconstante1_18.value);

  document.form1.mtfisanexo_valorconstante2_19.value = 0;
  document.form1.mtfisanexo_valorconstante2_19.value = Number(document.form1.mtfisanexo_valorconstante2_16.value)
    + Number(document.form1.mtfisanexo_valorconstante2_17.value)
    - Number(document.form1.mtfisanexo_valorconstante2_18.value);

  document.form1.mtfisanexo_valorconstante3_19.value = 0;
  document.form1.mtfisanexo_valorconstante3_19.value = Number(document.form1.mtfisanexo_valorconstante3_16.value)
    + Number(document.form1.mtfisanexo_valorconstante3_17.value)
    - Number(document.form1.mtfisanexo_valorconstante3_18.value);

  //Impacto do saldo das PPPs (IX) = (VII - VIII)

  //CORRENTE
  document.form1.mtfisanexo_valorcorrente1_24.value = 0;
  document.form1.mtfisanexo_valorcorrente1_24.value = Number(document.form1.mtfisanexo_valorcorrente1_22.value)
    - Number(document.form1.mtfisanexo_valorcorrente1_23.value);

  document.form1.mtfisanexo_valorcorrente2_24.value = 0
  document.form1.mtfisanexo_valorcorrente2_24.value = Number(document.form1.mtfisanexo_valorcorrente2_22.value)
    - Number(document.form1.mtfisanexo_valorcorrente2_23.value);

  document.form1.mtfisanexo_valorcorrente3_24.value = 0;
  document.form1.mtfisanexo_valorcorrente3_24.value = Number(document.form1.mtfisanexo_valorcorrente3_22.value)
    - Number(document.form1.mtfisanexo_valorcorrente3_23.value);

  //CONSTANTE
  document.form1.mtfisanexo_valorconstante1_24.value = 0;
  document.form1.mtfisanexo_valorconstante1_24.value = Number(document.form1.mtfisanexo_valorconstante1_22.value)
    - Number(document.form1.mtfisanexo_valorconstante1_23.value);

  document.form1.mtfisanexo_valorconstante2_24.value = 0;
  document.form1.mtfisanexo_valorconstante2_24.value = Number(document.form1.mtfisanexo_valorconstante2_22.value)
    - Number(document.form1.mtfisanexo_valorconstante2_23.value);

  document.form1.mtfisanexo_valorconstante3_24.value = 0;
  document.form1.mtfisanexo_valorconstante3_24.value = Number(document.form1.mtfisanexo_valorconstante3_22.value)
    - Number(document.form1.mtfisanexo_valorconstante3_23.value);

}

</script>
