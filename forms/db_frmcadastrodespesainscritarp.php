<div class="registro_empinscritosemrp">
  <?php

  $clorctiporec = new cl_orctiporec();
  $sql = "select distinct o15_codtri from orctiporec where o15_codtri != '' and o15_codtri::int >= 100 order by o15_codtri";
  //    die($sql);
  $recursos = $clorctiporec->sql_record($sql);

  ?>
  <form name="form1" method="post" action="" style="" onsubmit="return validaForm(this);">
    <table>
      <tr>
        <td>
          <center><strong>Disponibilidade de Caixa por Fonte de Recurso</strong></center>
        </td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
    <table>
      <tr>
        <th class="table_header" style="width: 50px;">Fonte</th>
        <th class="table_header" style="width: 100px;">Dis. de Caixa Bruta</th>
        <th class="table_header" style="width: 100px;">RP Exercicios Anteriores</th>
        <th class="table_header" style="width: 100px;">Saldo da Disp. Caixa</th>
      </tr>
    </table>
    <?php
    $aRecurso = db_utils::getCollectionByRecord($recursos);
    $iTotalFontes = 0;
    $arrayEmpenhos = 0;

    foreach ($aRecurso as $oFot):

      $iFonte = ltrim($oFot->o15_codtri,"0");
      ?>

      <table class="DBGrid">

        <td class="linhagrid" style="width: 50px">
          <?= $iFonte ?>
          <input type="hidden" name="aFonte[<?= $iFonte ?>][fonte]" value="<?= $oFot->o15_codtri ?>" id="">
        </td>

        <td class="linhagrid">
          <input type="text" style="width: 100px" name="aFonte[<?= $iFonte ?>][vlr_dispCaixaBruta]" value="0" onchange="js_CalculaDisponibilidade(<?= $iFonte ?>)" id="">
        </td>

        <td class="linhagrid">
          <input type="text" style="width:  100px" name="aFonte[<?= $iFonte ?>][vlr_rpExerAnteriores]" value="0" onchange="js_CalculaDisponibilidade(<?= $iFonte ?>)" id="">
        </td>



        <td class="linhagrid">
          <input type="text" readonly="true" style="width: 100px; background: #DEB887;" name="aFonte[<?= $iFonte ?>][vlr_DispCaixa]" value="0" onchange="" id="">
        </td>

      </table>
      <?
      $iTotalFontes++;

      $arrayFontes[$iFonte] = $iFonte;

      ?>

    <?php endforeach; ?>
    <center>
      <input type="submit" value="Salvar" id="btmSalvar" name="incluir">
      <input type="button" onclick="carregarSicom()" value="Atualizar" id="btmAtualizar" name="">
    </center>
  </form>

</div>
<script>
  carregarvalores();

  /**
   * função para carregar valores na tela
   */

  function carregarvalores() {
    buscarvalores({
      exec: 'getValores',
      // fonte: fonte
    }, js_carregarValores);
  }

  function js_carregarValores(oRetorno){
    var valores = JSON.parse(oRetorno.responseText.urlDecode());
    valores.fonte.forEach(function (fonte, b) {

      document.form1['aFonte[' + fonte.c224_fonte + '][vlr_dispCaixaBruta]'].value = fonte.c224_vlrcaixabruta;
      document.form1['aFonte[' + fonte.c224_fonte + '][vlr_rpExerAnteriores]'].value = fonte.c224_rpexercicioanterior;
      // document.form1['aFonte[' + fonte.c224_fonte + '][vlr_restArecolher]'].value = fonte.c224_vlrrestoarecolher;
      // document.form1['aFonte[' + fonte.c224_fonte + '][vlr_restRegAtivoFinan]'].value = fonte.c224_vlrrestoregativofinanceiro;
      document.form1['aFonte[' + fonte.c224_fonte + '][vlr_DispCaixa]'].value = fonte.c224_vlrdisponibilidadecaixa;

    });
  }

  function buscarvalores(params, onComplete) {
    js_divCarregando('Carregando Valores', 'div_aguarde');
    var request = new Ajax.Request('cadastrodespesainscritarp.RPC.php', {
      method:'post',
      parameters:'json=' + JSON.stringify(params),
      onComplete: function(res) {
        js_removeObj('div_aguarde');
        onComplete(res);
      }
    });
  }

  /**
   * função para carregar valores do SICOM
   */

  function carregarSicom() {
    document.form1.reset();
    buscarSicom({
      exec: 'getSicom',
      // fonte: fonte
    }, Atualizar);
  }

  function Atualizar(oRetorno){
    var valoresSicom = JSON.parse(oRetorno.responseText.urlDecode());
    if(valoresSicom == 0){
      alert('Gere os os arquivos CTB, CAIXA e CUTE do mês de dezembro para atualizar a disponibilidade');
      return false;
    }

    valoresSicom.oDados.forEach(function (dadosfonte, b) {
      Object.keys(dadosfonte).forEach(function (fonte, key) {
        if(dadosfonte[fonte].vlrcaixabruta == undefined){
          document.form1['aFonte[' + fonte + '][vlr_dispCaixaBruta]'].value = 0;
        }else{
          document.form1['aFonte[' + fonte + '][vlr_dispCaixaBruta]'].value = dadosfonte[fonte].vlrcaixabruta;
        }

        if(dadosfonte[fonte].VlrroexercicioAnteriores == undefined){
          document.form1['aFonte[' + fonte + '][vlr_rpExerAnteriores]'].value = 0;
        }else{
          document.form1['aFonte[' + fonte + '][vlr_rpExerAnteriores]'].value = dadosfonte[fonte].VlrroexercicioAnteriores;
        }

        // if(dadosfonte[fonte].vlrrestorecolher == undefined){
        //   document.form1['aFonte[' + fonte + '][vlr_restArecolher]'].value = 0;
        // }else{
        //   document.form1['aFonte[' + fonte + '][vlr_restArecolher]'].value = dadosfonte[fonte].vlrrestorecolher;
        // }
        //
        // if(dadosfonte[fonte].vlrAtivoFian == undefined){
        //   document.form1['aFonte[' + fonte + '][vlr_restRegAtivoFinan]'].value = 0;
        // }else{
        //   document.form1['aFonte[' + fonte + '][vlr_restRegAtivoFinan]'].value = dadosfonte[fonte].vlrAtivoFian;
        // }

        document.form1['aFonte[' + fonte + '][vlr_DispCaixa]'].value = dadosfonte[fonte].vlrDisponibilidade;

      });
    });
  }

  function buscarSicom(params, onComplete) {
    js_divCarregando('Carregando Valores', 'div_aguarde');
    var request = new Ajax.Request('cadastrodespesainscritarp.RPC.php', {
      method:'post',
      parameters:'json=' + JSON.stringify(params),
      onComplete: function(res) {
        js_removeObj('div_aguarde');
        onComplete(res);
      }
    });
  }

  /**
   * Calculo disponibilidade de caixa quando digitar nos inputs da tela
   *
   */

  function js_CalculaDisponibilidade(fonte) {

    let vlrDisCaixaBruta       = document.form1['aFonte[' + fonte + '][vlr_dispCaixaBruta]'].value;
    let vlrRpExercicioanterior = document.form1['aFonte[' + fonte + '][vlr_rpExerAnteriores]'].value;
    // let vlrRestoRecolher       = document.form1['aFonte[' + fonte + '][vlr_restArecolher]'].value;
    // let vlrRegAtivoFian        = document.form1['aFonte[' + fonte + '][vlr_restRegAtivoFinan]'].value;
    let ResultVlrDisponibilidade = Number(vlrDisCaixaBruta) - Number(vlrRpExercicioanterior) - Number(vlrRestoRecolher) - Number(vlrRegAtivoFian);

    //document.form1['aFonte[' + fonte + '][vlr_DispCaixa]'].value = ResultVlrDisponibilidade.toFixed(2)
    document.form1['aFonte[' + fonte + '][vlr_DispCaixa]'].value = ResultVlrDisponibilidade.toFixed(2)

  }

</script>
