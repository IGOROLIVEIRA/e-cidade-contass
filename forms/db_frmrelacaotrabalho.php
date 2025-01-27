<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

//MODULO: educa��o
require_once("dbforms/db_classesgenericas.php");

$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clrechumanoativ          = new cl_rechumanoativ;
$clrotulo                 = new rotulocampo;

$clrelacaotrabalho->rotulo->label();
$clrotulo->label("ed75_i_codigo");
$clrotulo->label("ed25_i_codigo");
$clrotulo->label("ed24_i_codigo");
$clrotulo->label("ed12_i_codigo");
$clrotulo->label("ed29_i_ensino");
$clrotulo->label("ed75_i_rechumano");

$db_botao1 = false;
$iEscola   = db_getsession("DB_coddepto");

define( "MENSAGEM_FRMRELACAOTRABALHO", "educacao.escola.db_frmrelacaotrabalho.");

if( isset( $opcao ) && $opcao == "alterar" ) {

  $sCamposRelacaoTrabalho = "relacaotrabalho.*, ed12_i_ensino, ed10_c_descr, ed24_c_descr, ed25_c_descr, ed232_c_descr";
  $sSqlRelacaoTrabalho    = $clrelacaotrabalho->sql_query( "", $sCamposRelacaoTrabalho, "", "ed23_i_codigo = {$ed23_i_codigo}" );
  $result2                = $clrelacaotrabalho->sql_record( $sSqlRelacaoTrabalho );

  db_fieldsmemory( $result2, 0 );
  $db_opcao  = 2;
  $db_botao1 = true;
} else if( isset( $opcao ) && $opcao == "excluir" || isset( $db_opcao ) && $db_opcao == 3 ) {

  if( !isset( $excluir ) ) {

    $sCamposRelacaoTrabalho = "relacaotrabalho.* ,ed12_i_ensino, ed10_c_descr, ed24_c_descr, ed25_c_descr,ed232_c_descr";
    $sSqlRelacaoTrabalho    = $clrelacaotrabalho->sql_query( "", $sCamposRelacaoTrabalho, "", "ed23_i_codigo = {$ed23_i_codigo}" );
    $result3                = $clrelacaotrabalho->sql_record( $sSqlRelacaoTrabalho );

    db_fieldsmemory( $result3, 0 );
  }

  $db_botao1 = true;
  $db_opcao  = 3;
} else {

  if( isset( $alterar ) ) {

    $db_opcao  = 2;
    $db_botao1 = true;
  } else {
    $db_opcao = 1;
  }
}
?>
<form name="form1" method="post" action="">
  <center>
  <table border="0">
    <tr>
      <td nowrap></td>
      <td>
       <?php
       db_input( 'ed23_i_codigo',          10, $Ied23_i_codigo,          true, 'hidden', 3 );
       db_input( 'ed23_i_rechumanoescola', 10, $Ied23_i_rechumanoescola, true, 'hidden', 3 );
       db_input( 'ed75_i_rechumano',       10, $Ied75_i_rechumano,       true, 'hidden', 3 );
       ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$ed20_i_tiposervidor == '1' ? 'Matr�cula' : 'CGM'?>">
        <label class="bold"><?=@$ed20_i_tiposervidor == '1' ? 'Matr�cula:' : 'CGM:'?></label>
      </td>
      <td>
        <?php
        db_input( 'identificacao', 15, @$identificacao, true, 'text', 3 );
        db_input( 'z01_nome',      50, @$Iz01_nome,     true, 'text', 3 );
        ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Ted23_i_regimetrabalho?>">
        <?php
        db_ancora( @$Led23_i_regimetrabalho, "js_pesquisaed23_i_regimetrabalho(true);", $db_opcao );
        ?>
      </td>
      <td>
        <?php
        $sScript = " onchange='js_pesquisaed23_i_regimetrabalho(false);'";
        db_input( 'ed23_i_regimetrabalho', 15, $Ied23_i_regimetrabalho, true, 'text', $db_opcao, $sScript );
        db_input( 'ed24_c_descr',          40, @$Ied24_c_descr,         true, 'text',         3 );
        ?>
      </td>
    </tr>
    <?php
    $db_opcao_atual = $db_opcao;
    $db_opcao       = 3;
    $cor            = "#DEB887";
    $regente        = "N";

    $aOpcoesTipoHoraTrabalho = array();

    if(    !empty( $ed23_i_rechumanoescola ) ) {

      $iRecHumanoEscola = $ed23_i_rechumanoescola;
      if( empty( $ed23_i_rechumanoescola ) ) {
        $iRecHumanoEscola = $oGet->ed23_i_rechumanoescola;
      }

      $sCamposTipoHora = "distinct ed128_codigo, ed128_descricao, ed128_tipoefetividade";
      $sWhereTipoHora  = " ed22_i_rechumanoescola = {$iRecHumanoEscola} and ed22_ativo = TRUE and ed128_ativo = TRUE";
      $sSqlTipoHora    = $clrechumanoativ->sql_query_tipohoratrabalho( "", $sCamposTipoHora, "", $sWhereTipoHora );
      $rsTipoHora      = db_query( $sSqlTipoHora );

      if ( !$rsTipoHora ) {
        db_msgbox( _M( MENSAGEM_FRMRELACAOTRABALHO . "erro_buscar_tipo_hora" ) );
      }

      $iLinhas  = pg_num_rows($rsTipoHora);
      if ( $iLinhas > 0 ) {

        for ( $iContador = 0; $iContador < $iLinhas; $iContador++ ) {

          $oDadosTipoHoraTrabalho = db_utils::fieldsMemory( $rsTipoHora, $iContador );
          $aOpcoesTipoHoraTrabalho[$iContador]->iTipoHora         = $oDadosTipoHoraTrabalho->ed128_codigo;
          $aOpcoesTipoHoraTrabalho[$iContador]->sDescricao        = $oDadosTipoHoraTrabalho->ed128_descricao;
          $aOpcoesTipoHoraTrabalho[$iContador]->iTipoEfetividade  = $oDadosTipoHoraTrabalho->ed128_tipoefetividade;
        }
      }

      $sWhereRecHumanoAtiv  = "     ed22_i_rechumanoescola = {$iRecHumanoEscola}";
      $sWhereRecHumanoAtiv .= " AND ed75_i_escola = {$iEscola}";
      $sWhereRecHumanoAtiv .= " AND ed01_c_regencia = 'S'";
      $sSqlRecHumanoAtiv    = $clrechumanoativ->sql_query( "", "ed01_c_regencia", "", $sWhereRecHumanoAtiv );
      $result               = $clrechumanoativ->sql_record( $sSqlRecHumanoAtiv );

      if( $clrechumanoativ->numrows > 0 ) {

        $db_opcao = isset( $opcao ) && $opcao == "excluir" ? 3 : 1;
        $cor      = "#E6E4F1";
        $regente  = "S";
      }
    }
    ?>
    <tr>
      <td>
        <b>Tipo de Hora:</b>
      </td>
      <td>
        <select name='ed23_tipohoratrabalho' id='ed23_tipohoratrabalho' <?= !isset ($opcao) ? "style='color:#000;'" : "style='background-color:#DEB887;' disabled" ?> onchange="js_validaTipoEfetividade();">
          <option value=''>Selecione...</option>
          <?php
          foreach ( $aOpcoesTipoHoraTrabalho as $oOpcoesTipoHoraTrabalho ) {

            if ( isset($ed23_tipohoratrabalho) && $ed23_tipohoratrabalho == $oOpcoesTipoHoraTrabalho->iTipoHora ) {
              echo "<option value= '{$oOpcoesTipoHoraTrabalho->iTipoHora}' tipo_efetividade='{$oOpcoesTipoHoraTrabalho->iTipoEfetividade}' selected='selected'> {$oOpcoesTipoHoraTrabalho->sDescricao} </option>";
            } else {
              echo "<option value= '{$oOpcoesTipoHoraTrabalho->iTipoHora}' tipo_efetividade='{$oOpcoesTipoHoraTrabalho->iTipoEfetividade}'> {$oOpcoesTipoHoraTrabalho->sDescricao} </option>";
            }
          }
          ?>
        </select>
      </td>
    </tr>
    <tr class="lEfetividade">
      <td nowrap colspan="2">
        Somente para regentes de classe:
      </td>
    </tr>
    <tr class="lEfetividade">
      <td nowrap title="<?=@$Ted29_i_ensino?>">
        <?php
        db_ancora( @$Led29_i_ensino, "js_pesquisaed23_i_ensino(true);", $db_opcao );
        ?>
      </td>
      <td>
        <?php
        $sScript = " onchange='js_pesquisaed23_i_ensino(false);' ";
        db_input( 'ed12_i_ensino', 15, @$Ied12_i_ensino, true, 'text', $db_opcao, $sScript );
        db_input( 'ed10_c_descr',  40, @$Ied10_c_descr,  true, 'text',         3 );
        ?>
      </td>
    </tr>
    <tr class="lEfetividade">
      <td nowrap title="<?=@$Ted23_i_areatrabalho?>">
        <?php
        db_ancora( @$Led23_i_areatrabalho, "js_pesquisaed23_i_areatrabalho(true);", $db_opcao );
        ?>
      </td>
      <td>
        <?php
        $sScript = " onchange='js_pesquisaed23_i_areatrabalho(false);'";
        db_input( 'ed23_i_areatrabalho', 15, $Ied23_i_areatrabalho, true, 'text', $db_opcao, $sScript );
        db_input( 'ed25_c_descr',        40, @$Ied25_c_descr,       true, 'text',         3 );
        ?>
      </td>
    </tr>
    <?php
    if( isset( $opcao ) || $regente == "N" ) {
      ?>
      <tr class="lEfetividade">
       <td nowrap title="<?=@$Ted23_i_disciplina?>">
        <?php
        db_ancora( @$Led23_i_disciplina, "js_pesquisaed23_i_disciplina(true);", $db_opcao );
        ?>
       </td>
       <td>
         <?php
         $sScript = " onchange='js_pesquisaed23_i_disciplina(false);'";
         db_input( 'ed23_i_disciplina', 15, $Ied23_i_disciplina, true, 'text', $db_opcao, $sScript );
         db_input( 'ed232_c_descr',     40, @$Ied232_c_descr,    true, 'text',         3 );
         ?>
       </td>
      </tr>
    <?php
    } else {
    ?>
      <tbody id="div_disciplina"></tbody>
    <?php
    }
    ?>
  </table>
  <?php
  $db_opcao = $db_opcao_atual;
  ?>
  <input name="ed23_i_rechumanoescola" type="hidden" value="<?=@$ed23_i_rechumanoescola?>">
  <input name="<?=( $db_opcao == 1 ? "incluir" : ( $db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir" ) )?>"
         type="submit"
         id="db_opcao"
         value="<?=( $db_opcao == 1 ? "Incluir" : ( $db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir" ) )?>"
         <?=( $db_botao == false ? "disabled" : "" )?>
         <?=$db_opcao != 3 ? "onclick=\"return js_valida('$regente');\"" : ""?>>
  <input name="cancelar" type="submit" value="Cancelar" <?=( $db_botao1 == false ? "disabled" : "" )?> >
  <input name="regente" type="hidden" value="<?=$regente?>">
  <table width="100%">
    <tr>
      <td valign="top">
      <?php
      $escola     = $iEscola;
      $chavepri   = array( "ed23_i_codigo" => @$ed23_i_codigo );
      $campossql  = "ed23_i_codigo, ed23_i_rechumanoescola, ed23_i_areatrabalho, ed25_c_descr as db_area";
      $campossql .= ", ed23_i_regimetrabalho, ed24_c_descr as db_regime, ed23_i_disciplina";
      $campossql .= ", ed232_c_descr as db_disciplina, ed12_i_ensino, ed10_c_descr as db_ensino";
      $sWhere     = "ed23_i_rechumanoescola = {$ed23_i_rechumanoescola} and ed23_ativo is true";
      $sSql       = $clrelacaotrabalho->sql_query( "", $campossql, "", $sWhere );

      $cliframe_alterar_excluir->chavepri      = $chavepri;
      $cliframe_alterar_excluir->sql           = $sSql;
      $cliframe_alterar_excluir->campos        = "ed23_i_codigo,db_regime,db_ensino,db_area,db_disciplina";
      $cliframe_alterar_excluir->legenda       = "Registros";
      $cliframe_alterar_excluir->msg_vazio     = "N�o foi encontrado nenhum registro.";
      $cliframe_alterar_excluir->textocabec    = "#DEB887";
      $cliframe_alterar_excluir->textocorpo    = "#444444";
      $cliframe_alterar_excluir->fundocabec    = "#444444";
      $cliframe_alterar_excluir->fundocorpo    = "#eaeaea";
      $cliframe_alterar_excluir->iframe_height = "140";
      $cliframe_alterar_excluir->iframe_width  = "100%";
      $cliframe_alterar_excluir->tamfontecabec = 9;
      $cliframe_alterar_excluir->tamfontecorpo = 9;
      $cliframe_alterar_excluir->formulario    = false;
      $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);
      ?>
      </td>
    </tr>
  </table>
  </center>
</form>
<script>

const MENSAGEM_FRMRELACAOTRABALHO = 'educacao.escola.db_frmrelacaotrabalho.';
js_validaTipoEfetividade();

function js_valida( regente ) {

  if( document.form1.ed23_i_regimetrabalho.value == "" ) {

    alert( _M( MENSAGEM_FRMRELACAOTRABALHO + "informe_regime_trabalho" ) );
    return false;
  }

  if( regente== "S" ) {

    var oTipoEfetividade                = $("ed23_tipohoratrabalho");
    var iTipoEfetividade                = oTipoEfetividade.options[oTipoEfetividade.selectedIndex].getAttribute('tipo_efetividade');

    if ( iTipoEfetividade != 3 ) {

      if( document.form1.ed12_i_ensino.value == "" ) {

        alert( _M( MENSAGEM_FRMRELACAOTRABALHO + "informe_nivel_ensino" ) );
        return false;
      }

      if( document.form1.ed23_i_areatrabalho.value == "" ) {

        alert( _M( MENSAGEM_FRMRELACAOTRABALHO + "informe_area_trabalho" ) );
        return false;
      }

      if( document.form1.ed23_i_codigo.value != "" ) {

        if( document.form1.ed23_i_disciplina.value == "" ) {

          alert( _M( MENSAGEM_FRMRELACAOTRABALHO + "informe_disciplina" ) );
          return false;
        }
      } else {

        tam = document.form1.coddisciplina.length;

        if( tam == undefined ) {

          if( document.form1.coddisciplina.checked == false ) {

            alert( _M( MENSAGEM_FRMRELACAOTRABALHO + "informe_disciplina" ) );
            return false;
          }
        } else {

          checado = 0;

          for( x = 0; x < tam; x++ ) {

            if( document.form1.coddisciplina[x].checked == true ) {
              checado++;
            }
          }

          if( checado == 0 ) {

            alert( _M( MENSAGEM_FRMRELACAOTRABALHO + "informe_disciplina" ) );
            return false;
          }
        }
      }
    }
  }

  if ( empty($F('ed23_tipohoratrabalho') ) ) {

    alert( _M( MENSAGEM_FRMRELACAOTRABALHO + "informe_tipo_hora" ) );
    return false;
  }

  return true;
}

function js_pesquisaed23_i_areatrabalho( mostra ) {

  if( document.form1.ed12_i_ensino.value == "" ) {

    alert( "Informe primeiro o N�vel de Ensino!" );
    document.form1.ed23_i_areatrabalho.value      = "";
    document.form1.ed12_i_ensino.style.background = "#99A9AE";
    document.form1.ed12_i_ensino.focus();
  } else {

    if( mostra == true ) {
      js_OpenJanelaIframe('','db_iframe_areatrabalho','func_areatrabalho.php?ensino='+document.form1.ed12_i_ensino.value+'&funcao_js=parent.js_mostraareatrabalho1|ed25_i_codigo|ed25_c_descr','Pesquisa de �reas de Trabalho',true);
    } else {

      if( document.form1.ed23_i_areatrabalho.value != '' ) {
        js_OpenJanelaIframe(
                             '',
                             'db_iframe_areatrabalho',
                             'func_areatrabalho.php?ensino='+document.form1.ed12_i_ensino.value
                                                 +'&pesquisa_chave='+document.form1.ed23_i_areatrabalho.value
                                                 +'&funcao_js=parent.js_mostraareatrabalho',
                             'Pesquisa',
                             false
                           );
      } else {
        document.form1.ed25_c_descr.value = '';
      }
    }
  }
}

function js_mostraareatrabalho( chave, erro ) {

  document.form1.ed25_c_descr.value = chave;

  if( erro == true ) {

    document.form1.ed23_i_areatrabalho.focus();
    document.form1.ed23_i_areatrabalho.value = '';
  }
}

function js_mostraareatrabalho1( chave1, chave2 ) {

  document.form1.ed23_i_areatrabalho.value = chave1;
  document.form1.ed25_c_descr.value        = chave2;
  db_iframe_areatrabalho.hide();
}

function js_pesquisaed23_i_regimetrabalho( mostra ) {

  if( mostra == true ) {
    js_OpenJanelaIframe(
                         '',
                         'db_iframe_regimetrabalho',
                         'func_regimetrabalho.php?funcao_js=parent.js_mostraregimetrabalho1|ed24_i_codigo|ed24_c_descr',
                         'Pesquisa de Regimes de Trabalho',
                         true
                       );
  } else {

    if( document.form1.ed23_i_regimetrabalho.value != '' ) {
      js_OpenJanelaIframe(
                           '',
                           'db_iframe_regimetrabalho',
                           'func_regimetrabalho.php?pesquisa_chave='+document.form1.ed23_i_regimetrabalho.value
                                                 +'&funcao_js=parent.js_mostraregimetrabalho',
                           'Pesquisa',
                           false
                         );
    } else {
      document.form1.ed24_c_descr.value = '';
    }
  }
}

function js_mostraregimetrabalho( chave, erro ) {

  document.form1.ed24_c_descr.value = chave;

  if( erro == true ) {

    document.form1.ed23_i_regimetrabalho.focus();
    document.form1.ed23_i_regimetrabalho.value = '';
  }
}

function js_mostraregimetrabalho1( chave1, chave2 ) {

  document.form1.ed23_i_regimetrabalho.value = chave1;
  document.form1.ed24_c_descr.value          = chave2;
  db_iframe_regimetrabalho.hide();
}

function js_pesquisaed23_i_ensino( mostra ) {

  if( mostra == true ) {
    js_OpenJanelaIframe(
                         '',
                         'db_iframe_ensino',
                         'func_ensino.php?funcao_js=parent.js_mostraensino1|ed10_i_codigo|ed10_c_descr',
                         'Pesquisa de Ensinos',
                         true
                       );
  } else {

    if( document.form1.ed12_i_ensino.value != '' ) {
      js_OpenJanelaIframe(
                           '',
                           'db_iframe_ensino',
                           'func_ensino.php?pesquisa_chave='+document.form1.ed12_i_ensino.value
                                         +'&funcao_js=parent.js_mostraensino',
                           'Pesquisa',
                           false
                         );
    } else {

      document.form1.ed10_c_descr.value        = '';
      document.form1.ed23_i_areatrabalho.value = '';
      document.form1.ed25_c_descr.value        = '';

      if( document.form1.ed23_i_codigo.value != "" ) {

        document.form1.ed23_i_disciplina.value = '';
        document.form1.ed232_c_descr.value     = '';
      } else {
        document.getElementById("div_disciplina").innerHTML = "";
      }
    }
  }
}

function js_mostraensino( chave, erro ) {

  document.form1.ed10_c_descr.value        = chave;
  document.form1.ed23_i_areatrabalho.value = '';
  document.form1.ed25_c_descr.value        = '';

  if( document.form1.ed23_i_codigo.value != "" ) {

    document.form1.ed23_i_disciplina.value = '';
    document.form1.ed232_c_descr.value     = '';
  } else {
    document.getElementById("div_disciplina").innerHTML = "";
  }

  if( erro == true ) {

    document.form1.ed12_i_ensino.focus();
    document.form1.ed12_i_ensino.value = '';
  } else {

    js_divCarregando( "Aguarde, buscando disciplinas", "msgBox" );

    var sAction = 'PesquisaDisciplina';
    var url     = 'edu1_relacaotrabalhoRPC.php';
    parametros  = 'sAction='+sAction+'&ensino='+document.form1.ed12_i_ensino.value;

    new Ajax.Request(url,{method    : 'post',
                                      parameters: parametros,
                                      onComplete: js_retornaPesquisaDisciplina
                                     });
  }
}

function js_mostraensino1( chave1, chave2 ) {

  document.form1.ed12_i_ensino.value       = chave1;
  document.form1.ed10_c_descr.value        = chave2;
  document.form1.ed23_i_areatrabalho.value = '';
  document.form1.ed25_c_descr.value        = '';

  if( document.form1.ed23_i_codigo.value != "" ) {

    document.form1.ed23_i_disciplina.value = '';
    document.form1.ed232_c_descr.value     = '';
  } else {
    document.getElementById("div_disciplina").innerHTML = "";
  }

  db_iframe_ensino.hide();
  js_divCarregando( "Aguarde, buscando disciplinas","msgBox" );

  var sAction = 'PesquisaDisciplina';
  var url     = 'edu1_relacaotrabalhoRPC.php';
  parametros  = 'sAction='+sAction+'&ensino='+document.form1.ed12_i_ensino.value+'&disciplinas=<?=$disc_cad?>';


  new Ajax.Request(url,{method    : 'post',
                        parameters: parametros,
                        onComplete: js_retornaPesquisaDisciplina
                       });
}

function js_retornaPesquisaDisciplina( oAjax ) {

  js_removeObj( "msgBox" );

  var oRetorno = eval("("+oAjax.responseText+")");

  if( oRetorno.length == 0 ) {
   todas = '';
  } else {
    todas = '<br><input type="checkbox" name="todas" id="todas" value="" onclick="js_todas();">Todas';
  }

  sHtml = '<tr><td><b>Disciplina(s):</b>' + todas + '</td>';

  if( oRetorno.length == 0 ) {

    sHtml += '<td>Nenhuma disciplina dispon�vel.</td>';
    document.form1.incluir.disabled = true;
  } else {

    sHtml += '<td>';
    sHtml += ' <table><tr>';
    cont   = 0;

    for( var i = 0;i < oRetorno.length; i++ ) {

      cont++;
      with (oRetorno[i]) {

        sHtml += '<td><input type="checkbox" name="coddisciplina[]" id="coddisciplina" value="'+ed12_i_codigo+'"> '+ed232_c_descr.urlDecode()+'</td>';
        if( cont % 3 == 0 ) {
          sHtml += ' </tr><tr>';
        }
      }
    }

    sHtml += ' </tr></table>';
    sHtml += '</td>';
    document.form1.incluir.disabled = false;
  }

  sHtml += '</tr>';
  $('div_disciplina').innerHTML = sHtml;
}

function js_pesquisaed23_i_disciplina( mostra ) {

  if( document.form1.ed12_i_ensino.value == "" ) {

    alert( "Informe primeiro o N�vel de Ensino!" );
    document.form1.ed23_i_disciplina.value             = '';
    document.form1.ed12_i_ensino.style.backgroundColor = '#99A9AE';
    document.form1.ed12_i_ensino.focus();
  } else {

    if( mostra == true ) {
      js_OpenJanelaIframe(
                           '',
                           'db_iframe_disciplina',
                           'func_disciplinarelacao.php?ensino='+document.form1.ed12_i_ensino.value
                                                    +'&disciplinas=<?=$disc_cad?>'
                                                    +'&funcao_js=parent.js_mostradisciplina1|ed12_i_codigo|ed232_c_descr',
                           'Pesquisa de Disciplinas',
                           true
                         );
    } else {

      if( document.form1.ed23_i_disciplina.value != '' ) {
        js_OpenJanelaIframe(
                             '',
                             'db_iframe_disciplina',
                             'func_disciplinarelacao.php?ensino='+document.form1.ed12_i_ensino.value
                                                      +'&disciplinas=<?=$disc_cad?>'
                                                      +'&pesquisa_chave='+document.form1.ed23_i_disciplina.value
                                                      +'&funcao_js=parent.js_mostradisciplina',
                             'Pesquisa',
                             false
                           );
      } else {
        document.form1.ed232_c_descr.value = '';
      }
    }
  }
}

function js_mostradisciplina( chave, erro ) {

  document.form1.ed232_c_descr.value = chave;

  if( erro == true ) {

    document.form1.ed23_i_disciplina.focus();
    document.form1.ed23_i_disciplina.value = '';
  }
}

function js_mostradisciplina1( chave1, chave2 ) {

  document.form1.ed23_i_disciplina.value = chave1;
  document.form1.ed232_c_descr.value     = chave2;
  db_iframe_disciplina.hide();
}

function js_todas() {

  tam = document.form1.coddisciplina.length;

  if( tam == undefined ) {

    if( document.form1.todas.checked == true ) {
      document.form1.coddisciplina.checked = true;
    } else {
      document.form1.coddisciplina.checked = false;
    }
  } else {

    for( t = 0; t < tam; t++ ) {

      if( document.form1.todas.checked == true ) {
        document.form1.coddisciplina[t].checked = true;
      } else {
        document.form1.coddisciplina[t].checked = false;
      }
    }
  }
}

/**
 * Valida o tipo de efetividade e bloqueia os campos Nivel de Ensino e Area de trabalho
 * quando a efetividade for 3 - EFETIVIDADE FUNCIONARIO
 * @return void
 */
function js_validaTipoEfetividade() {

  var oTipoEfetividade                = $("ed23_tipohoratrabalho");
  var iTipoEfetividade                = oTipoEfetividade.options[oTipoEfetividade.selectedIndex].getAttribute('tipo_efetividade');
  var sContentNivelEnsinoAreaTrabalho = document.getElementsByClassName('lEfetividade'), iContador;
  for (var iContador = 0; iContador < sContentNivelEnsinoAreaTrabalho.length; iContador ++) {

    if ( iTipoEfetividade == 3) {

      document.form1.ed12_i_ensino.value       = '';
      document.form1.ed10_c_descr.value        = '';
      document.form1.ed23_i_areatrabalho.value = '';
      document.form1.ed25_c_descr.value        = '';

      if( document.form1.ed23_i_codigo.value != "" ) {

        document.form1.ed23_i_disciplina.value = '';
        document.form1.ed232_c_descr.value     = '';
      } else {
        document.getElementById("div_disciplina").innerHTML = "";
      }

      sContentNivelEnsinoAreaTrabalho[iContador].style.display = 'none';
    } else {
      sContentNivelEnsinoAreaTrabalho[iContador].style.display = '';
    }
  }

}
</script>