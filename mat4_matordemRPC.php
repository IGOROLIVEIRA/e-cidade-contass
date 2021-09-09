<?php
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
 *                                licenca/licenca_pt.txt //
 */
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("model/ordemCompra.model.php");
require_once("model/compras/ConfiguracaoDesdobramentoPatrimonio.model.php");
require_once("model/contabilidade/GrupoContaOrcamento.model.php");
require_once("libs/exceptions/BusinessException.php");
require_once("model/empenho/EmpenhoFinanceiroItem.model.php");
require_once("model/empenho/EmpenhoFinanceiro.model.php");
require_once("model/configuracao/DBDepartamento.model.php");
require_once("model/configuracao/Instituicao.model.php");
require_once("model/Dotacao.model.php");
require_once("model/CgmFactory.model.php");
require_once("model/MaterialCompras.model.php");
require_once("model/estoque/MaterialGrupo.model.php");
require_once("model/contabilidade/lancamento/LancamentoAuxiliarBase.model.php");
require_once("model/contabilidade/planoconta/ContaPlano.model.php");
require_once("classes/requisicaoMaterial.model.php");
require_once("classes/materialestoque.model.php");
require_once("classes/db_atendrequi_classe.php");
require_once("classes/db_atendrequiitem_classe.php");
require_once("classes/db_atendrequiitemmei_classe.php");
require_once("classes/db_matrequi_classe.php");
require_once("classes/db_matrequiitem_classe.php");
require_once("classes/db_matestoque_classe.php");
require_once("classes/db_matestoqueini_classe.php");
require_once("classes/db_matestoqueinimei_classe.php");
require_once("classes/db_matestoqueinimeimdi_classe.php");
require_once("classes/db_matestoqueitem_classe.php");
require_once("classes/db_matestoquedev_classe.php");
require_once("classes/db_matestoquedevitem_classe.php");
require_once("classes/db_matestoquedevitemmei_classe.php");


db_app::import('contabilidade.*');
db_app::import('contabilidade.lancamento.*');
db_app::import("financeiro.*");
db_app::import("contabilidade.*");
db_app::import("contabilidade.lancamento.*");
db_app::import("contabilidade.planoconta.*");
db_app::import("contabilidade.contacorrente.*");
db_app::import("configuracao.DBRegistry");


$post         = db_utils::postmemory($_POST);
$json         = new services_json();
$objJson      = $json->decode(str_replace("\\", "", $_POST["json"]));
$oORdemCompra = new ordemCompra($objJson->m51_codordem);
$method       = $objJson->method;
$oORdemCompra->setEncodeOn();

if ($method == "getDados") {

  echo $oORdemCompra->ordem2Json($objJson->e69_codnota);
} else if ($method == "anularEntradaOrdem") {


  try {
    $sqlerro = false;
    db_inicio_transacao();
    $aItens = array();

    /*CANCELA CONSUMO IMEDIATO E DEVOLVE MATERIAIS*/

    $atendimento = db_query("SELECT m43_codatendrequi
      FROM atendrequiitem
      JOIN matrequiitem ON m41_codigo=m43_codmatrequiitem
      JOIN matrequi ON m41_codmatrequi=m40_codigo
      WHERE substring(m41_obs, 36) like '{$objJson->m51_codordem}' order by m43_codatendrequi desc limit 1");
    if (pg_num_rows($atendimento) > 0) {


      $oatendimento = db_utils::fieldsMemory($atendimento, 0);
      $clatendrequi = db_utils::getDao('atendrequi');
      $clatendrequiitem = db_utils::getDao('atendrequiitem');
      $clmatestoquedev = db_utils::getDao('matestoquedev');
      $clmatestoqueini = db_utils::getDao('matestoqueini');
      $clmatestoquedevitemmei = db_utils::getDao('matestoquedevitemmei');
      $clatendrequiitemmei = db_utils::getDao('atendrequiitemmei');
      $clmatrequi = db_utils::getDao('matrequi');
      $clmatrequiitem = db_utils::getDao('matrequiitem');
      $clmatestoque = db_utils::getDao('matestoque');
      $clmatestoqueinimei =  db_utils::getDao('matestoqueinimei');
      $clmatestoqueinimeimdi =  db_utils::getDao('matestoqueinimeimdi');
      $clmatestoqueitem = db_utils::getDao('matestoqueitem');
      $clmatestoquedevitem = db_utils::getDao('matestoquedevitem');
      $oDaoMatestoqueInimeiPm = db_utils::getDao('matestoqueinimeipm');


      $m42_codigo = $oatendimento->m43_codatendrequi;

      /*
        * busca data do registro de atendimento no banco
        */
      $result_data_registro = $clatendrequi->sql_record($clatendrequi->sql_query_file("", "m42_data, m42_hora", "", "m42_codigo=$m42_codigo"));
      if ($clatendrequi->numrows > 0) {
        db_fieldsmemory($result_data_registro, 0);
        $clatendrequi->m42_data = $m42_data;
        $clatendrequi->m42_hora = $m42_hora;
      }


      /*
        * compara se a data do sistema é menor ou igual(se for igual testa hora) a data do registro,
        * se for menor cencela a devolução, gerar erro e mensagem
        */

      if (date("Y-m-d", db_getsession("DB_datausu")) < $clatendrequi->m42_data) {

        $erro_msg = 'Data atual é anterior a data do atendimento, Devolução abortada!';
        $sqlerro  = true;
        // echo "entrei no if";
        // die;
        throw new Exception($erro_msg);
      } else {

        if (date("Y-m-d", db_getsession("DB_datausu")) == $clatendrequi->m42_data) {

          if (db_hora() <=  $clatendrequi->m42_hora) {

            $erro_msg = 'Hora atual dever ser posterior a hora e data do antendimento, Devolução abortada!';
            $sqlerro  = true;
            throw new Exception($erro_msg);
          }
        }
      }
      if ($sqlerro == false) {
        $result_m40_codigo = $clatendrequiitem->sql_record($clatendrequiitem->sql_query(
          null,
          "m40_codigo",
          null,
          "m43_codatendrequi=$m42_codigo"
        ));
        if ($clatendrequiitem->numrows != 0) {
          db_fieldsmemory($result_m40_codigo, 0);
        }
        $clmatestoquedev->m45_depto = db_getsession("DB_coddepto");
        $clmatestoquedev->m45_login = db_getsession("DB_id_usuario");
        $clmatestoquedev->m45_hora = db_hora();
        $clmatestoquedev->m45_data = date('Y-m-d', db_getsession("DB_datausu"));
        $clmatestoquedev->m45_obs = $m45_obs;
        $clmatestoquedev->m45_codmatrequi = $m40_codigo;
        $clmatestoquedev->m45_codatendrequi = $m42_codigo;

        $clmatestoquedev->incluir();
        $erro_msg = $clmatestoquedev->erro_msg;


        if ($clmatestoquedev->erro_status == 0) {
          $sqlerro = true;
          throw new Exception($erro_msg);
        }
        $codigo = $clmatestoquedev->m45_codigo;
        if ($sqlerro == false) {

          $clmatestoqueini->m80_login          = db_getsession("DB_id_usuario");
          $clmatestoqueini->m80_data           = date("Y-m-d", db_getsession("DB_datausu"));
          $clmatestoqueini->m80_hora           = date('H:i:s');
          $clmatestoqueini->m80_obs            = 'Anulação da ordem de compra:' . $objJson->m51_codordem;
          $clmatestoqueini->m80_codtipo        = "18";
          $clmatestoqueini->m80_coddepto       = db_getsession("DB_coddepto");

          $clmatestoqueini->incluir();


          if ($clmatestoqueini->erro_status == 0) {
            $sqlerro = true;
            $erro_msg = $clmatestoqueini->erro_msg;
            throw new Exception($erro_msg);
          }


          $m82_matestoqueini = $clmatestoqueini->m80_codigo;


          $oatendimento = $clatendrequiitem->sql_record($clatendrequiitem->sql_query_inimei(null, "*", "", "m43_codatendrequi=$m42_codigo"));
          $oatendimento = db_utils::getColectionByRecord($oatendimento);

          $i = 0;
          foreach ($oatendimento as $dadosAtendimento) {
            $atendrequiitem     = $dadosAtendimento->m43_codigo;
            $codmatmater        = $dadosAtendimento->m41_codmatmater;
            $matrequiitem       = $dadosAtendimento->m43_codmatrequiitem;
            $iCodigoIniMei      = $dadosAtendimento->m49_codmatestoqueinimei;
            $iCodMatEstoqueItem = $dadosAtendimento->m82_matestoqueitem;
            $quant_devolvida    = $dadosAtendimento->m82_quant;

            $oItem                     = new stdClass;
            $oItem->iCodigoMaterial    = $codmatmater;
            $oItem->nQuantidade        = $quant_devolvida;
            $oItem->iCodigoAtendimento = $m82_matestoqueini;
            $aItens[]                  = $oItem;
            $result_atend = $clatendrequiitem->sql_record($clatendrequiitem->sql_query_file($atendrequiitem));
            if ($clatendrequiitem->numrows != 0) {
              db_fieldsmemory($result_atend, 0);
            }


            /**
             * Consultamos se existe uma apropriacao de custo para esse atendimento;
             * caso exista, verificamos se é necessário atualizar os valores dessa apropriação
             */
            $oDaoCustoAproria   = db_utils::getDao("custoapropria");
            $sSqlCustoAproriado = $oDaoCustoAproria->sql_query_file(
              null,
              "*",
              null,
              "cc12_matestoqueinimei = {$iCodigoIniMei}"
            );

            $rsCustoApropriado = $oDaoCustoAproria->sql_record($sSqlCustoAproriado);
            if ($oDaoCustoAproria->numrows > 0) {

              $aCustosApropriados = db_utils::getCollectionByRecord($rsCustoApropriado);
              foreach ($aCustosApropriados as $oCustoApropriado) {

                $nNovaQuantidade = $oCustoApropriado->cc12_qtd - $quant_devolvida;
                $nNovoValor      = round((($nNovaQuantidade * $oCustoApropriado->cc12_valor) / $oCustoApropriado->cc12_qtd), 2);
                if ($nNovaQuantidade > 0) {

                  $oDaoCustoAproria->cc12_sequencial = $oCustoApropriado->cc12_sequencial;
                  $oDaoCustoAproria->cc12_qtd        = $nNovaQuantidade;
                  $oDaoCustoAproria->cc12_valor      = $nNovoValor;
                  $oDaoCustoAproria->alterar($oCustoApropriado->cc12_sequencial);
                } else {
                  $oDaoCustoAproria->excluir(null, "cc12_matestoqueinimei = {$iCodigoIniMei}");
                }
                if ($oDaoCustoAproria->erro_status == 0) {

                  $sqlerro  = true;
                  $erro_msg = $oDaoCustoAproria->erro_msg;
                  throw new Exception($erro_msg);
                }
              }
            }
            if (!$sqlerro) {

              $clmatestoquedevitem->m46_codmatestoquedev  = $codigo;
              $clmatestoquedevitem->m46_codmatrequiitem   = $matrequiitem;
              $clmatestoquedevitem->m46_codatendrequiitem = $atendrequiitem;
              $clmatestoquedevitem->m46_codmatmater       = $codmatmater;
              $clmatestoquedevitem->m46_quantdev          = $quant_devolvida;
              $clmatestoquedevitem->m46_quantexistia      = $m43_quantatend;
              $clmatestoquedevitem->incluir(null);

              if ($clmatestoquedevitem->erro_status == 0) {

                $sqlerro = true;
                $erro_msg = $clmatestoquedevitem->erro_msg;
                throw new Exception($erro_msg);
              }
            }

            $codigodevitem = $clmatestoquedevitem->m46_codigo;
            if ($sqlerro == false) {
              if ($m43_quantatend == $quant_devolvida) {
                $quantatend_alt = $quant_devolvida;
              } else {
                $quantatend_alt = $m43_quantatend - $quant_devolvida;
              }

              //          db_msgbox("Dev. Item ".$quantatend_alt);

              $clatendrequiitem->m43_quantatend = "$quantatend_alt";
              $clatendrequiitem->m43_codigo     = $m43_codigo;
              $clatendrequiitem->alterar($m43_codigo);
              if ($clatendrequiitem->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clatendrequiitem->erro_msg;
                throw new Exception($erro_msg);
              }
            }
            if ($sqlerro == false) {

              $acaba = false;
              $result_mei = $clatendrequiitemmei->sql_record($clatendrequiitemmei->sql_query_file(null, "*", null, "m44_codatendreqitem=$m43_codigo and m44_codmatestoqueitem = $iCodMatEstoqueItem"));
              $numrowsmei = $clatendrequiitemmei->numrows;
              for ($w = 0; $w < $numrowsmei; $w++) {
                db_fieldsmemory($result_mei, $w);

                if ($sqlerro == false) {
                  $result_matestoqueitem = $clmatestoqueitem->sql_record($clmatestoqueitem->sql_query($m44_codmatestoqueitem));
                  db_fieldsmemory($result_matestoqueitem, 0);

                  if ($quant_devolvida >= $m44_quant) {
                    if ($quant_devolvida == $m44_quant) {
                      $quant_altera = abs($quant_devolvida - $m71_quantatend);
                      $devolver     = $quant_devolvida;
                    } else {
                      $quant_altera    = $m71_quantatend - $m44_quant; // 0
                      $devolver        = $m44_quant; // 20
                      $quant_devolvida = $quant_devolvida - $m44_quant; // 20
                    }
                    $clmatestoqueitem->m71_quantatend = "$quant_altera";
                  } else {
                    $quant_altera = $m71_quantatend - $quant_devolvida; // 10

                    $clmatestoqueitem->m71_quantatend = "$quant_altera";
                    $devolver = $quant_devolvida; // 20
                    $acaba    = true;
                  }

                  //                db_msgbox("Matestoqueitem ".$quant_altera." => ".$quant_devolvida." ==> ".$m44_quant);

                  $valor_uni = $m71_valor / $m71_quant;
                  $valordev  = $valor_uni * $devolver;

                  $clmatestoqueitem->m71_codlanc = $m71_codlanc;
                  $clmatestoqueitem->alterar($m71_codlanc);
                  if ($clmatestoqueitem->erro_status == 0) {
                    $sqlerro  = true;
                    $erro_msg = $clmatestoqueitem->erro_msg;
                    throw new Exception($erro_msg);
                  }
                }

                if ($sqlerro == false) {
                  $clatendrequiitemmei->m44_quant  = "$quant_altera";
                  $clatendrequiitemmei->m44_codigo = $m44_codigo;
                  $clatendrequiitemmei->alterar($m44_codigo);
                  if ($clatendrequiitemmei->erro_status == 0) {
                    $sqlerro = true;
                    $erro_msg = $clatendrequiitemmei->erro_msg;
                    throw new Exception($erro_msg);
                  }
                }

                if ($sqlerro == false) {
                  $clmatestoquedevitemmei->m47_quantdev = $devolver;
                  $clmatestoquedevitemmei->m47_codmatestoqueitem = $m71_codlanc;
                  $clmatestoquedevitemmei->m47_codmatestoquedevitem = $codigodevitem;
                  $clmatestoquedevitemmei->incluir(null);
                  if ($clmatestoquedevitemmei->erro_status == 0) {
                    $sqlerro = true;
                    $erro_msg = $clmatestoquedevitemmei->erro_msg;
                    throw new Exception($erro_msg);
                  }
                }
                if ($sqlerro == false) {
                  $clmatestoqueinimei->m82_matestoqueitem = $m71_codlanc;
                  $clmatestoqueinimei->m82_matestoqueini  = $m82_matestoqueini;
                  $clmatestoqueinimei->m82_quant          = $devolver;
                  $clmatestoqueinimei->incluir(@$m82_codigo);
                  if ($clmatestoqueinimei->erro_status == 0) {
                    $erro_msg = $clmatestoqueinimei->erro_msg;
                    throw new Exception($erro_msg);
                    $sqlerro = true;
                    break;
                  }
                  $codigo_inimei = $clmatestoqueinimei->m82_codigo;
                }
                if ($sqlerro == false) {
                  $clmatestoqueinimeimdi->m50_codmatestoquedevitem = $codigodevitem;
                  $clmatestoqueinimeimdi->m50_codmatestoqueinimei = $codigo_inimei;
                  $clmatestoqueinimeimdi->incluir(null);
                  if ($clmatestoqueinimeimdi->erro_status == 0) {
                    $erro_msg = $clmatestoqueinimeimdi->erro_msg;
                    throw new Exception($erro_msg);
                    $sqlerro = true;
                    break;
                  }
                }

                //              db_msgbox($devolver);

                if ($sqlerro == false) {

                  $v = $valordev + $m70_valor;
                  $q = $devolver + $m70_quant;

                  //                db_msgbox("Estoque ".$q);

                  $clmatestoque->m70_quant = "$q";
                  $clmatestoque->m70_valor = "$v";
                  $clmatestoque->m70_codigo = $m70_codigo;
                  $clmatestoque->alterar($m70_codigo);
                  if ($clmatestoque->erro_status == 0) {
                    $sqlerro = true;
                    $erro_msg = $clmatestoque->erro_msg;
                    throw new Exception($erro_msg);
                  }
                }

                $oDataImplantacao         = new DBDate(date("Y-m-d", db_getsession('DB_datausu')));
                $oInstituicao             = new Instituicao(db_getsession('DB_instit'));
                $lIntegracaoContabilidade = ParametroIntegracaoPatrimonial::possuiIntegracaoMaterial($oDataImplantacao, $oInstituicao);

                if (USE_PCASP && $lIntegracaoContabilidade) {

                  if (!$sqlerro) {

                    try {

                      $oMaterial        = new MaterialEstoque($oItem->iCodigoMaterial);
                      $nValorLancamento = round($oMaterial->getPrecoMedio() * $devolver, 2);
                      $sWhereValor      = "m89_matestoqueinimei = {$codigo_inimei}";
                      $sSqlValorItem    = $oDaoMatestoqueInimeiPm->sql_query_file(
                        null,
                        "m89_valorfinanceiro",
                        null,
                        $sWhereValor
                      );

                      $rsValorPrecoMovimento = $oDaoMatestoqueInimeiPm->sql_record($sSqlValorItem);
                      if ($rsValorPrecoMovimento) {
                        $nValorLancamento = db_utils::fieldsMemory($rsValorPrecoMovimento, 0)->m89_valorfinanceiro;
                      }
                      $oRequisicao = new RequisicaoMaterial($m40_codigo);
                      $oRequisicao->estornarLancamento($oMaterial, $codigo_inimei, $nValorLancamento);
                    } catch (BusinessException $eException) {

                      $erro_msg = str_replace("\n", "\\n", $eException->getMessage());
                      $sqlerro  = true;
                    } catch (Exception $eException) {

                      $erro_msg = str_replace("\n", "\\n", $eException->getMessage());
                      $sqlerro  = true;
                    }
                  }
                }


                if ($acaba == true || $devolver == 0) {
                  break;
                }
              }
            }
          }
        }
      }

      /**
       * escrituramos a saida dos materiais
       */
    }
    $oORdemCompra->anularEntradaNota($objJson->e69_codnota);
    $status   = 1;
    $mensagem = "Entrada de Ordem de Compra anulada com Sucesso.";
    $load     = 1;
  } catch (BusinessException $oErro) {

    $status   = 2;
    $mensagem = $oErro->getMessage();
    $load     = 2;
  } catch (Exception $eErro) {

    $status   = 2;
    $mensagem = $eErro->getMessage();
    $load     = 2;
  }

  db_fim_transacao($sqlerro);
  echo $json->encode(array("mensagem" => urlencode($mensagem), "status" => $status, "load" => $load));
} else if ($method == "getOrdem") {

  $oORdemCompra->setEncodeOn();
  $oORdemCompra->getDados();
  if ($oORdemCompra->getItensSaldo()) {
    echo $json->encode($oORdemCompra->dadosOrdem);
  }
} else if ($method == "anularOrdem") {

  $oORdemCompra->anularOrdem($objJson->itensAnulados, db_stdclass::normalizeStringJsonEscapeString($objJson->sMotivo), $objJson->empanula);
  $mensagem = '';
  $status   = 1;
  if ($oORdemCompra->lSqlErro) {

    $mensagem = urlencode($oORdemCompra->sErroMsg);
    $status   = 2;
  }
  echo $json->encode(array("mensagem" => $mensagem, "status" => $status));
} else if ($method == "getInfoEntrada") {

  try {

    $oORdemCompra->destroySession();
    $oORdemCompra->getInfoEntrada();
    $oORdemCompra->dadosOrdem->status  = 1;
    $oORdemCompra->dadosOrdem->itens   = $oORdemCompra->getDadosEntrada();
    echo $json->encode($oORdemCompra->dadosOrdem);
  } catch (Exception $eErro) {

    echo $json->encode(
      array(
        "mensagem" => urlencode($eErro->getMessage()),
        "status"   => 2
      )
    );
  }
} else if ($method == "getInfoItem") {
  echo $json->encode($oORdemCompra->getInfoItem($objJson->iCodLanc, $objJson->iIndice));
} else if ($method == "saveMaterial") {

  try {

    $oORdemCompra->saveMaterial($objJson->iCodLanc, $objJson->oMaterial);
    echo $json->encode(array(
      "mensagem"  => "ok",
      "status"    => 1,
      "lFraciona" => $objJson->oMaterial->fraciona,
      "iCodLanc"  => $objJson->iCodLanc
    ));
  } catch (Exception $eErro) {

    echo $json->encode(
      array(
        "mensagem" => urlEncode($eErro->getMessage()),
        "status"   => 2,
        "lfraciona" => false,
      )
    );
  }
} else if ($method == "getDadosEntrada") {

  $aRetorno = array("aItens" => $oORdemCompra->getDadosEntrada(), "marcar" => $objJson->marcar);
  echo $json->encode($aRetorno);
} else if ($method == "cancelarFracionamento") {

  if ($oORdemCompra->cancelarFracionamento($objJson->iCodLanc, $objJson->iIndice)) {

    echo $json->encode($oORdemCompra->getDadosEntrada());
  }
} else if ($method == "desmarcarItem") {

  $_SESSION["matordem{$objJson->m51_codordem}"][$objJson->iCodLanc][$objJson->iIndice]->checked = "";
} else if ($method == "confirmarEntrada") {
  try {

    db_inicio_transacao();

    $aDadosConsumoImediato = array(
      'dpto' => $objJson->m51_depto,
      'itens' => $_SESSION["matordem{$objJson->m51_codordem}"],
    );
    //verifica se existe materiais com consumo imediato preenchido ou se pelo menos um ? material

    $haConsumo = false;
    foreach ($aDadosConsumoImediato['itens'] as $iCodLanc => $oItem) {
      foreach ($oItem as $iIndice => $oItemFilho) {
        if ((int)$aDadosConsumoImediato['itens'][$iCodLanc][$iIndice]->consumoImediato > 0 && $aDadosConsumoImediato['itens'][$iCodLanc][$iIndice]->pc01_servico == 'f') {
          $haConsumo = true;
        }
      }
    }

    $clmatrequi     = db_utils::getDao('matrequi');
    $clmatrequiitem = db_utils::getDao('matrequiitem');

    /**
        validação realizada pela retaguarda, para verificar se algum item esta sem vinculo com grupo e subgrupo.
     */

    $sComprasSemMaterial = '';

    foreach ($_SESSION["matordem{$objJson->m51_codordem}"] as $iCodLanc => $oItem) {

      foreach ($oItem as $iIndice => $oItemFilho) {

        if ($_SESSION["matordem{$objJson->m51_codordem}"][$iCodLanc][$iIndice]->m63_codmatmater == '') {
          $sComprasSemMaterial .= "\n" . $_SESSION["matordem{$objJson->m51_codordem}"][$iCodLanc][$iIndice]->pc01_codmater . ' - ' .
            $_SESSION["matordem{$objJson->m51_codordem}"][$iCodLanc][$iIndice]->pc01_descrmater;
        }
      }
    }


    if (!empty($sComprasSemMaterial)) {
      throw new Exception("Itens sem vínculo com Material de Entrada:\n" . urldecode($sComprasSemMaterial) . "\n ");
    }

    $sObservacao     = addslashes(db_stdClass::normalizeStringJsonEscapeString($objJson->sObs));
    $sNota           = addslashes(db_stdClass::normalizeStringJsonEscapeString($objJson->sNumero));
    $sNumeroProcesso = addslashes(db_stdClass::normalizeStringJsonEscapeString($objJson->e04_numeroprocesso));

    $oORdemCompra->confirmaEntrada(
      $sNota,
      $objJson->dtDataNota,
      $objJson->dtRecebeNota,
      $objJson->nValorNota,
      $objJson->aItens,
      $objJson->oInfoNota,
      $sObservacao,
      $sNumeroProcesso,
      $objJson->sNotaFiscalEletronica,
      $objJson->sChaveAcesso,
      $objJson->sNumeroSerie,
      FALSE
    );
    //echo '<pre>'; ini_set("display_errors",true);
    //consumoImediato
    if ($haConsumo) {

      $clmatrequi->m40_auto  = 'false';
      $clmatrequi->m40_almox = $objJson->m51_depto;
      if (empty($objJson->codDeptoConsumo)) {
        $clmatrequi->m40_depto = $objJson->m51_depto;
      } else {
        $clmatrequi->m40_depto = $objJson->codDeptoConsumo;
      }
      $clmatrequi->m40_hora  = db_hora();
      $clmatrequi->m40_data  = date('Y-m-d', db_getsession("DB_datausu"));
      $clmatrequi->m40_login = db_getsession("DB_id_usuario");
      $clmatrequi->incluir(null);

      if ($clmatrequi->erro_status == '0') {
        throw new Exception($clmatrequi->erro_msg . "aq");
      }

      $codigo = $clmatrequi->m40_codigo;
      foreach ($aDadosConsumoImediato['itens'] as $iCodLanc => $oItem) {

        foreach ($oItem as $iIndice => $oItemFilho) {
          if ((int)$aDadosConsumoImediato['itens'][$iCodLanc][$iIndice]->consumoImediato > 0 && $aDadosConsumoImediato['itens'][$iCodLanc][$iIndice]->pc01_servico == 'f') {
            $clmatrequiitem->m41_codmatrequi = $codigo;
            $clmatrequiitem->m41_codmatmater = $aDadosConsumoImediato['itens'][$iCodLanc][$iIndice]->m63_codmatmater;
            $clmatrequiitem->m41_codunid = 1;
            $clmatrequiitem->m41_quant = $aDadosConsumoImediato['itens'][$iCodLanc][$iIndice]->consumoImediato;
            $clmatrequiitem->m41_obs = 'Consumo Imediato - Ordem de compra:' . $objJson->m51_codordem;

            $clmatrequiitem->incluir(null);
            if ($clmatrequiitem->erro_status == '0') {
              throw new Exception($clmatrequiitem->erro_msg);
            }
          }
        }
      }
      $itens = db_query("select m41_codigo as iCodItemReq, m41_codmatmater as iCodMater, m41_quant as nQtde  from matrequiitem where m41_codmatrequi = {$codigo}");
      $oItens = db_utils::getColectionByRecord($itens);
      $aItens = array();

      foreach ($oItens as $Item) {
        $oItem = new StdClass();
        $oItem->iCodItemReq = $Item->icoditemreq;
        $oItem->nQtde = $Item->nqtde;
        $oItem->iCodMater = $Item->icodmater;
        $oItem->iCentroDeCusto = NULL;
        array_push($aItens, $oItem);
      }


      $oRequisicao  = new requisicaoMaterial($codigo);
      $atendido = $oRequisicao->atenderRequisicao(17, $aItens, $aDadosConsumoImediato->dpto);
      if ($atendido == false) {
        throw new Exception("Saída de material não atendida.");
      }
    }

    if (isset($objJson->verificaChave) && $objJson->verificaChave == 1 && $objJson->sNotaFiscalEletronica != 2 && $objJson->sNotaFiscalEletronica != 3) {
      $ufs = array(

        11 => "RO", 12 => "AC", 13 => "AM", 14 => "RR", 15 => "PA", 16 => "AP", 17 => "TO", 21 => "MA", 22 => "PI",
        23 => "CE", 24 => "RN", 25 => "PB", 26 => "PE", 27 => "AL", 28 => "SE", 29 => "BA", 31 => "MG", 32 => "ES",
        33 => "RJ", 35 => "SP", 41 => "PR", 42 => "SC", 43 => "RS", 50 => "MS", 51 => "MT", 52 => "GO", 53 => "DF"

      );

      $ufKey   = substr($objJson->sChaveAcesso, 0, 2);
      $dataKey = substr($objJson->sChaveAcesso, 2, 4);
      $cnpjKey = substr($objJson->sChaveAcesso, 6, 14);
      $nfKey   = substr($objJson->sChaveAcesso, 25, 9);

      $oDaoCgm   = db_utils::getDao("cgm");
      $sSqlCgm   = $oDaoCgm->sql_query_file($objJson->m51_numcgm);
      $rsCgm     = $oDaoCgm->sql_record($sSqlCgm);
      $oDadosCgm = db_utils::fieldsMemory($rsCgm, 0);


      $key  = (array_key_exists($ufKey, $ufs)) ? $ufKey : 0;
      $data = substr(implode("", array_reverse(explode("/", $objJson->dtDataNota))), 2, 4);

      if ($ufs[$key] != $oDadosCgm->z01_uf) {
        throw new Exception("Chave de acesso inválida!\nVerifique a Cidade e o Estado do Fornecedor!");
      } else if (strcmp($data, $dataKey)) {
        throw new Exception("Chave de acesso inválida!\nVerifique a data da Nota Fiscal!");
      } else if (strcmp(str_pad($objJson->sNumero, 9, "0", STR_PAD_LEFT), $nfKey)) {
        throw new Exception("Chave de acesso inválida!\nVerifique o Número da Nota!");
      } else if ($objJson->sNotaFiscalEletronica == 1) {
        if (strcmp($oDadosCgm->z01_cgccpf, $cnpjKey)) {
          throw new Exception("Chave de acesso inválida!\nVerifique o CNPJ do Fornecedor!");
        }
      }
    }

    //OC5819
    $oORdemCompra->destroySession();
    db_fim_transacao(false);
    echo $json->encode(array("mensagem" => "Entrada da ordem de compra efetuada com sucesso.", "status" => 1));
  } catch (Exception $eError) {

    db_fim_transacao(true);
    echo $json->encode(array("mensagem" => urlencode($eError->getMessage()), "status" => 2));
  }
} else if ($method == "marcarItensSession") {

  if ($objJson->lMarcar) {
    $sChecked = "checked";
  } else {
    $sChecked = "";
  }
  foreach ($_SESSION["matordem{$objJson->m51_codordem}"] as $iCodLanc => $oItem) {

    foreach ($oItem as $iIndice => $oItemFilho) {
      echo $_SESSION["matordem{$objJson->m51_codordem}"][$iCodLanc][$iIndice]->checked . "\n";
      $_SESSION["matordem{$objJson->m51_codordem}"][$iCodLanc][$iIndice]->checked = $sChecked;
    }
  }
} else if ($method == "verificaBensBaixado") {

  $aDocumentos = array(
    200 => 7,
    201 => 7,
    208 => 9,
    209 => 9,
    210 => 8,
    211 => 8
  );
  $status           = 1;
  $aGrupos          = array();
  $iCodigoNota      = $objJson->iCodigoNota;
  $iInstituicao     = db_getsession('DB_instit');
  $iGrupoEmpenho    = 0;
  $oDaoConLanCamEmp = db_utils::getDao("conlancamemp");

  $sCamposConLanCamEmp  = " c71_coddoc, ";
  $sCamposConLanCamEmp .= " e60_numemp  ";
  $sWhereConLanCamEmp   = "     conlancamnota.c66_codnota = {$iCodigoNota}                ";
  $sWhereConLanCamEmp  .= " and conlancamdoc.c71_coddoc in (200, 201, 208, 209, 210, 211) ";
  $sSqlConLanCamEmp     = $oDaoConLanCamEmp->sql_query_verificaBensBaixados(null, $sCamposConLanCamEmp, null, $sWhereConLanCamEmp);
  $rsConLanCamEmp       = $oDaoConLanCamEmp->sql_record($sSqlConLanCamEmp);

  if ($oDaoConLanCamEmp->numrows > 0) {

    $iDocumento         = db_utils::fieldsMemory($rsConLanCamEmp, 0)->c71_coddoc;
    $oDadosConLanCamEmp = db_utils::fieldsMemory($rsConLanCamEmp, 0);
    $oEmpenhoFinanceiro = new EmpenhoFinanceiro($oDadosConLanCamEmp->e60_numemp);
    $oContaOrcamento    = new ContaOrcamento(
      $oEmpenhoFinanceiro->getDesdobramentoEmpenho(),
      $oEmpenhoFinanceiro->getAnoUso(),
      null,
      $oEmpenhoFinanceiro->getInstituicao()
    );

    if ($oContaOrcamento->getGruposContas() !== false) {

      $aGrupos       = $oContaOrcamento->getGruposContas();
      $iGrupoEmpenho = $aGrupos[0]->c20_sequencial;
    }

    $iGrupoDeveEstar    = $aDocumentos[$iDocumento];
    if (($iGrupoDeveEstar != $iGrupoEmpenho)  && ($iGrupoEmpenho != 9)) {

      $oDaoConGrupo = db_utils::getDao("congrupo");
      $sSQLConGrupo = $oDaoConGrupo->sql_query_file($iGrupoDeveEstar);
      $rsConGrupo   = $oDaoConGrupo->sql_record($sSQLConGrupo);
      $oConGrupo    = db_utils::fieldsMemory($rsConGrupo, 0);


      $sMensagemErro  = "A operação não poderão ser realizada porque esta ordem de compra pertence ao empenho " . $oEmpenhoFinanceiro->getCodigo() . "/" . $oEmpenhoFinanceiro->getAnoUso();
      $sMensagemErro .= " e sua conta de despesa n?o esta configurada no grupo de contas do plano orçamentário de origem, ";
      $sMensagemErro .= "o que compromete o fechamento contábil. Solicite ao responsável pela ";
      $sMensagemErro .= "Contabilidade a inclusão da conta " .  $oContaOrcamento->getCodigoConta() . " - " . $oContaOrcamento->getDescricao();
      $sMensagemErro .= " no grupo de contas {$oConGrupo->c20_sequencial} - {$oConGrupo->c20_descr} ";

      $status   = '3';
      echo $json->encode(array("status" => $status, "sMensagem" => urlencode($sMensagemErro)));
      return false;
    }
  }


  if ($oORdemCompra->getBensAtivoNota($objJson->iCodigoNota) != false) {
    $status   = 2;
  }

  if ($oORdemCompra->houveDispensaTombamentoNoPatrimonio($objJson->iCodigoNota)) {
    $status   = 4;
  }

  echo $json->encode(array("status" => $status, "iCodigoNota" => $iCodigoNota));
} else if ($method == "verificaNota") {

  $status = 0;
  $sEmpenho = "";
  $sNota = addslashes(db_stdClass::normalizeStringJson($objJson->sNota));
  $iCgmFornecedor = $objJson->iCgmFornecedor;
  $oDaoEmpNota = db_utils::getDao("empnota");

  $iInstituicao = db_getsession('DB_instit');
  $sWhereEmpNota = "e69_numero ilike '{$sNota}' and e60_instit = {$iInstituicao} and e60_numcgm = {$iCgmFornecedor}";
  $sSqlEmpNota = $oDaoEmpNota->sql_query(
    null,
    "distinct e60_codemp, e69_anousu",
    "e60_codemp, e69_anousu",
    $sWhereEmpNota
  );
  $rsEmpNota = $oDaoEmpNota->sql_record($sSqlEmpNota);

  if ($oDaoEmpNota->numrows > 0) {

    $status = 1;

    $aEmpenhos = array();

    foreach (db_utils::getCollectionByRecord($rsEmpNota) as $oEmpNota) {

      $aEmpenhos[] = "\n" . $oEmpNota->e60_codemp . '/' . $oEmpNota->e69_anousu;
    }

    //$iAnoEmpenho = $oEmpenho->getAnoUso();

    $sEmpenho = implode(", ", $aEmpenhos);
  }
  echo $json->encode(array("status" => $status, "sEmpenho" => $sEmpenho));
}
