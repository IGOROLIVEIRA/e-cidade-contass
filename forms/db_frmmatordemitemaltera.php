<?PHP
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

require_once(__DIR__ . "/../libs/db_stdlib.php");
require_once(__DIR__ . "/../libs/db_utils.php");
require_once(__DIR__ . "/../libs/db_conecta.php");
include_once(__DIR__ . "/../libs/db_sessoes.php");
require_once(__DIR__ . "/../std/label/rotulocampo.php");
require_once(__DIR__ . "/../std/label/RotuloCampoDB.php");
require_once(__DIR__ . "/../std/label/RotuloDB.php");
require_once(__DIR__ . "/../std/label/rotulo.php");
include_once(__DIR__ . "/../libs/db_usuariosonline.php");
include_once(__DIR__ . "/../classes/db_matordem_classe.php");
include_once(__DIR__ . "/../classes/db_matordemitem_classe.php");
include_once(__DIR__ . "/../classes/db_matestoqueitemoc_classe.php");
include_once(__DIR__ . "/../classes/db_empempitem_classe.php");
include_once(__DIR__ . "/../dbforms/db_funcoes.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clmatordemitem = new cl_matordemitem;
$clmatestoqueitemoc = new cl_matestoqueitemoc;
$clmatordem = new cl_matordem;
$clempempitem = new cl_empempitem;
$clrotulo = new rotulocampo;

$clmatordemitem->rotulo->label();
$clmatordem->rotulo->label();

$clrotulo->label("e62_item");
$clrotulo->label("e60_numemp");
$clrotulo->label("e60_codemp");
$clrotulo->label("pc01_descrmater");
$clrotulo->label("e62_descr");

?>

<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="../scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="../scripts/strings.js"></script>
    <link href="../estilos.css" rel="stylesheet" type="text/css">
    <link href="../estilos/grid.style.css" rel="stylesheet" type="text/css">

    <style>
        <?$cor="#999999"?>
        .bordas {
            border: 2px solid #cccccc;
            border-top-color: <?=$cor?>;
            border-right-color: <?=$cor?>;
            border-bottom-color: <?=$cor?>;
            background-color: #999999;
        }

        <?$cor="999999"?>
        .bordas_corp {
            border: 1px solid #cccccc;
            border-right-color: <?=$cor?>;
            border-bottom-color: <?=$cor?>;
        }

        .input__static{
            text-align: center;
            background: none;
            border: none;
            color: #000;
            width: 55px;
        }
    </style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" cellspacing="0" cellpadding="0" width='100%'>
    <tr>
        <td align="left" valign="top" bgcolor="#CCCCCC">
            <form name='form1'>
                <center>
                    <fieldset>
                        <legend>
                            <b>Itens</b>
                        </legend>
                        <table style='border:2px inset white' width='100%' cellspacing='0'>
							<?

							if (isset ($m51_codordem) && $m51_codordem != "") {

								$resultItem = $clmatordemitem->sql_record($clmatordemitem->sql_query(null, "*", "", "m52_codordem=$m51_codordem"));

							    $iNumEmpenho = db_utils::fieldsMemory($resultItem, 0)->m52_numemp;
								$sSql = $clempempitem->sql_query('', '', '*', '', 'e62_numemp = ' . $iNumEmpenho);
								$rsSql = $clempempitem->sql_record($sSql);
								$numrows = $clempempitem->numrows;

								if ($numrows > 0) {

									echo "   <tr class='bordas'>";
									echo "     <td class='table_header' title='Marca/desmarca todos' align='center'>";
									echo "        <input type='checkbox'  style='display:none' id='mtodos' onclick='js_marca(false)'>";
                                    echo "            <a onclick='js_marca(true)' style='cursor:pointer'><b>M</b></a>";
                                    echo "     </td>";
									echo "     <td class='table_header' align='center'><small><b>Seq.</b></small></td>";
									echo "     <td class='table_header' align='center'><small><b>N. Empenho</b></small></td>";
									echo "     <td class='table_header' align='center'><small><b>Seq. Empenho</b></small></td>";
									echo "     <td class='table_header' align='center'><small><b>Cod. Item</b></small></td>";
									echo "     <td class='table_header' align='center'><small><b>Item</b></small></td>";
									echo "     <td class='table_header' align='center'><small><b>Unid.</b></small></td>";
									echo "     <td class='table_header' align='center'><small><b>Quantidade</b></small></td>";
									echo "     <td class='table_header' align='center'><small><b>Vlr. Uni.</b></small></td>";
									echo "     <td class='table_header' align='center'><small><b>Valor Total</b></small></td>";
									echo "     <td class='table_header' align='center'><small><b>Quantidade</b></small></td>";
									echo "     <td class='table_header' align='center'><small><b>Valor</b></small></td>";
									echo "   </tr>";
									echo " <tbody id='dados' style='height:150px;width:95%;overflow:scroll;overflow-x:hidden;background-color:white'>";

								} else {

                                    echo " <tr>";
                                    echo "	<b>Nenhum registro encontrado...</b>";
									echo " </tr>";

								}

								for ($i = 0; $i < $numrows; $i++) {

								    db_fieldsmemory($rsSql, $i);

                                    $sqlItem = $clmatordemitem->sql_query_anulado('', 'm52_codordem, m52_quant, m52_valor, m53_codordem',
                                        '','m52_numemp = '. $e62_numemp .' and m52_sequen = '. $e62_sequen);
                                    $rsItem = $clmatordemitem->sql_record($sqlItem);
                                    $valorLancado = $quantLancada = 0;

									$libera_registro = false;
									$ordemPrincipal  = '';
                                    for ($count=0; $count < pg_num_rows($rsItem); $count++){
									    $oItem = db_utils::fieldsMemory($rsItem, $count);

									    $valorLancado += floatval($oItem->m52_valor);
                                        $quantLancada += floatval($oItem->m52_quant);

                                        if($oItem->m53_codordem){
											$valorLancado -= floatval($oItem->m52_valor);
											$quantLancada -= floatval($oItem->m52_quant);
                                        }

										if($oItem->m52_codordem == $m51_codordem){
                                            $libera_registro = true;
                                        }

                                    }

									$marcaLinha = $opcao == 1 ? '' : 'marcado';

									$sqlItem = $clmatordemitem->sql_query_anulado('', 'm52_codordem, m52_quant, m52_valor',
										'','m52_numemp = '. $e62_numemp .' and m52_sequen = '. $e62_sequen.
                                        ' and m52_codordem = '.$m51_codordem);
									$rsItem = $clmatordemitem->sql_record($sqlItem);
									$oItemValores = db_utils::fieldsMemory($rsItem, 0);

                                    if(($quantLancada == $e62_quant && $valorLancado == $e62_vltot) && !$libera_registro){
										$disabled = 'disabled';
										$marcaLinha = 'marcado';
										$opcao = 3;
                                    }else{
										$disabled = '';
										$marcaLinha = '';
										$opcao = 1;
                                    }

									if($pc01_servico == 't' && $e62_servicoquantidade == 'f' && floatval($oItemValores->m52_valor) == floatval($e62_vltot)){
										$disabled = '';
										$marcaLinha = '';
										$opcao = 1;
									}elseif((floatval($e62_vltot) - floatval($valorLancado)) == 0 && !$oItemValores->m52_valor){
										$disabled = 'disabled';
										$marcaLinha = 'marcado';
										$opcao = 3;
                                    }

									$sSqlEntrada = $clmatestoqueitemoc->sql_query(null, null, "*", null,
										'm52_numemp = '. $e62_numemp .' and m52_codordem = '. $m51_codordem. 'and m73_cancelado is false');

									$result2 = $clmatestoqueitemoc->sql_record($sSqlEntrada);

									$ordemAutomatica = false;
									$obsOrdem = db_utils::fieldsMemory($resultItem, 0)->m51_obs;
									$compareObs = strcmp(strtolower(trim($obsOrdem)), strtolower('ordem de compra automatica'));
                                    if(!$compareObs || pg_num_rows($result2)){
                                        $sChecked = 'checked';
                                        $disabled = 'disabled';
                                        $marcaLinha = 'marcado';
                                        $opcao = 3;
                                        $ordemAutomatica = true;
                                    }

									$sqlItem = $clmatordemitem->sql_query('', '*', '',
                                        'm52_numemp = '. $e62_numemp .' and m52_sequen = '. $e62_sequen .
                                        ' and m52_codordem = '.$m51_codordem);
									$rsItem = $clmatordemitem->sql_record($sqlItem);

                                    $oItemOrdem = db_utils::fieldsMemory($rsItem, 0);

                                    if ($clmatestoqueitemoc->numrows == 0) {

										echo "<tr id='tr_$e62_sequencial' class='$marcaLinha'>
                                                    <td class='linhagrid' title='Inverte a marcação' align='center'>
                                                        <input type='checkbox' {$sChecked} {$disabled} id='chk{$e62_sequencial}' class='itensEmpenho'
                                                            name='itensOrdem[]' value='{$e62_sequencial}' onclick='js_marcaLinha(this, $i)'>
                                                    </td>
                                                    <td	class='linhagrid' align='center'>
                                                        <small>
                                                            <input id ='sequen_".$i."' class ='input__static' value='".$e62_sequen."' disabled></input>
                                                        </small>
                                                    </td>
													<td	class='linhagrid' align='center'>
													    <small>";
										                    db_ancora($e60_codemp, "js_pesquisaEmpenho($e60_numemp);", $opcao, '', "codemp_$i");
													    echo "</small>
                                                    </td>
													<td	class='linhagrid' align='center'>
													    <small>
													        <input id ='numemp_".$i."' class='input__static' value='".$e62_numemp."' disabled></input>
													    </small>
                                                    </td>
													<td	class='linhagrid' nowrap align='left' title='$pc01_descrmater'>
													    <small>
													        <input id ='coditem_".$i."' class ='input__static' value='".$e62_item."' disabled></input>
													    </small>
                                                    </td>
													<td	class='linhagrid' align='center'>
													    <small>$pc01_descrmater</small>
                                                    </td>

													<td	class='linhagrid' nowrap align='left' title='$m61_abrev'>
													    <small>" .(isset($m61_abrev) ? $m61_abrev : '-'). "</small>
                                                    </td>";

										/**
										 * Caso for um material
										 * Caso for um serviço e este serviço ser controlado por quantidade
										 *
										 *
										 * Alterados todos inputs dentro do for dos itens
										 * que tratam valores para db_opcao = 3, não mais permitindo alterações
										 * de valores, dendo que para altera devera ser anulado na rotina de anulação
										 * e incluidos os itens novamente.
										 *
										 */

										if ($pc01_servico == 'f' || ($pc01_servico == "t" && $e62_servicoquantidade == "t")) {

											$quantidade = "quant_" . "$i";

											$$quantidade = $e62_quant - $quantLancada + $oItemOrdem->m52_quant;

											if(!$$quantidade){
											    $$quantidade = $quantLancada;
                                            }

											if($ordemAutomatica){
												$$quantidade = $e62_quant;
											}

											$qtde = "qtde_$i";

											if($oItemOrdem->m52_quant){
											    $$qtde = $oItemOrdem->m52_quant;
                                            }else{
											    if(!($e62_quant - $quantLancada)){
											        $$qtde = $e62_quant;
                                                }else{
													$$qtde = $oItemOrdem->m52_quant;
                                                }
                                            }

											$$qtde = !$$qtde ? 0 : $$qtde;

											$valor = "valor_$i";
											$$valor = trim(db_formatar($e62_vlrun, 'f'));

											$valor_total = "vltotalemp_". "$i";
											$valor_restante = $e62_vlrun * $$quantidade;

											$$valor_total = trim(db_formatar($valor_restante, 'f'));

											$vltotal = "vltotal_". "$i";
											$$vltotal = trim(db_formatar($e62_vlrun * $$qtde, 'f'));

										   /**
                                           * Caso for um material
                                           * Caso for um serviço e este serviço ser controlado por quantidade
                                           *
                                           *
                                           * Alterados todos inputs dentro do for dos itens
                                           * que tratam valores para db_opcao = 3, não mais permitindo alterações
                                           * de valores, dendo que para altera devera ser anulado na rotina de anulação
                                           * e incluidos os itens novamente.
                                           *
                                           */

											echo " 	 <td class='linhagrid' align='center'>";
											echo "		 <small>";
											echo "          <input id='$quantidade' class='input__static' value=' ". $$quantidade . "' disabled />";
											echo "		 </small>";
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>";
											echo "		 <small>";
											                db_input("valor_$i", 10, 0, true, 'text', 3);
											echo "		 </small>";
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>";
											echo "		 <small>";
											echo "          <input id='$valor_total' class='input__static' value='".trim($$valor_total)."' disabled />";
											echo "		 </small>";
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>";
											echo "		 <small>";
											                db_input("qtde_$i", 10, 0, true, 'text', $opcao, "onchange='js_validaValor(this, \"q\");'onkeyup='js_limitaCaracteres(this)';");
											echo "		 </small>";
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>";
											echo "		 <small>";
											                db_input("vltotal_$i", 15, 0, true, 'text', 3);
											echo "		 </small>";
											echo "	 </td>";
											echo " </tr>";

										} else if ($pc01_servico == 't') {

										    $quantidade = "quant_" . "$i";

											$$quantidade = $e62_quant;

											if($ordemAutomatica){
											    $$quantidade = $e62_quant;
                                            }

											$qtde = "qtde_$i";

											$$qtde = $e62_quant;

											$valor = "valor_$i";
											$$valor = trim(db_formatar($e62_vlrun, 'f'));

											$valor_total = "vltotalemp_". "$i";

											if(!($e62_vltot - $valorLancado)){
											    $valor_restante = $oItemValores->m52_valor;
                                            }else{
												$valor_restante = $e62_vltot - $valorLancado + $oItemValores->m52_valor;
                                            }

											if(!$valor_restante){
											    $valor_restante = $e62_vltot;
                                            }

											$$valor_total = trim(db_formatar($valor_restante, 'f'));

											$vltotal = "vltotal_". "$i";
											if($oItemValores->m52_valor){
											    $$vltotal = trim(db_formatar($oItemValores->m52_valor, 'f'));
                                            }else{
											    $$vltotal = trim(db_formatar(0, 'f'));
                                            }

											echo "   <td class='linhagrid' align='center'>";
											echo "      <input id='$quantidade' class='input__static' value='".$$quantidade."' disabled />";
											echo "	 </td>";
											echo "   <td class='linhagrid' align='center'>";
											echo "		 <small>".db_input("valor_$i", 10, 0, true, 'text', 3)."</small>";
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>";
											echo "          <input id='$valor_total' class='input__static' value='".$$valor_total."' disabled />";
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>";
                                            db_input("qtde_$i", 10, 0, true, 'text', 3);
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>";
                                            db_input("vltotal_$i", 15, 0, true, 'text', $opcao, "onchange='js_validaValor(this, \"v\");'onkeyup='js_limitaCaracteres(this)';");
                                            echo "   </td>";
											echo " </tr>";
										}

									} else {
									    echo "<tr id='tr_$e62_sequencial' class='$marcaLinha'>";
									    echo "
										        <td class='linhagrid' title='Inverte a marcação' align='center'>
                                                    <input type='checkbox' {$sChecked} {$disabled} id='chk{$e62_sequencial}' class='itensEmpenho'
                                                        name='itensOrdem[]' value='{$e62_sequencial}' onclick='js_marcaLinha(this, $i)'>
                                                </td>";

										echo "    <td class='linhagrid' align='center'>
 	                                                <small>$e62_sequen</small>
                                                  </td>";
										echo " 	 <td class='linhagrid' align='center' $disabled>
 	                                                <small>";
										                db_ancora($e60_codemp, "js_pesquisaEmpenho($e60_numemp);", 1);
                                        echo"       </small>
                                                 </td>";
										echo "   <td class='linhagrid' align='center'>
                                                    <small>$e60_numemp</small>
                                                 </td>";
										echo "   <td class='linhagrid' nowrap align='left' title='$e62_item'>
                                                    <small>$e62_item</small>
                                                 </td>";
										echo "   <td class='linhagrid' align='center' title='$pc01_descrmater'>
                                                    <small>$pc01_descrmater</small>
                                                 </td>";
										echo "   <td class='linhagrid' nowrap align='left' title='$m61_abrev'>
                                                    <small>" .(isset($m61_abrev) != '' ? $m61_abrev : '-'). "&nbsp;</small>
                                                 </td>";

										/**
										 * Caso for um material
										 * Caso for um serviço e este serviço ser controlado por quantidade
										 */

                                        db_fieldsmemory($result2, 0);

										if ($pc01_servico == 'f' || ($pc01_servico == "t" && $e62_servicoquantidade == "t")) {

											$quantidade = "quant_" . "$i";

											$$quantidade = $e62_quant - $quantLancada + $oItemOrdem->m52_quant;

											if(!$$quantidade){
												$$quantidade = $quantLancada;
											}

											if($ordemAutomatica){
												$$quantidade = $e62_quant;
											}

											$qtde = "qtde_$i";

											if($oItemOrdem->m52_quant){
												$$qtde = $oItemOrdem->m52_quant;
											}else{
                                                $$qtde = $oItemOrdem->m52_quant;
											}

											$$qtde = !$$qtde ? 0 : $$qtde;
                                            $$qtde = trim(db_formatar($$qtde, 'f'));

											$valor = "valor_$i";
											$$valor = trim(db_formatar($e62_vlrun, 'f'));

											$valor_total = "vltotalemp_". "$i";
											$valor_restante = $e62_vlrun * $$quantidade;

											$$valor_total = trim(db_formatar($valor_restante, 'f'));

											$vltotal = "vltotal_". "$i";
											$$vltotal = trim(db_formatar($e62_vlrun * $$qtde, 'f'));

											echo "   <td class='linhagrid' align='center'>";
											echo "		 <small>";
                                            echo "          <input id='$quantidade' class='input__static' value=' ". $$quantidade . "' disabled />";
											echo "		 </small>";
											echo "	 </td>";
											echo "   <td class='linhagrid' align='center'>";
											echo "		 <small>";
                                                            db_input("valor_$i", 10, 0, true, 'text', 3);
											echo "		 </small>";
											echo "	 <td class='linhagrid' align='center'>";
											echo "		 <small>";
											echo "          <input id='$valor_total' class='input__static' value='". $$valor_total ."' disabled />";
                                            echo "		 </small>";
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>";
											echo "		 <small>";
											                db_input("qtde_$i", 10, 0, true, 'text', $opcao, "onchange='js_validaValor(this, \"q\");'onkeyup='js_limitaCaracteres(this)';");
											echo "		 </small>";
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>";
											echo "		 <small>";
											                db_input("vltotal_$i", 15, 0, true, 'text', 3);
											echo "		 </small>";
											echo "   </td>";
											echo " </tr>";

										} else if ($pc01_servico == 't') {

											$quantidade = "quant_" . "$i";

											$$quantidade = $e62_quant - $quantLancada + $oItemOrdem->m52_quant;

											if(!$$quantidade){
												$$quantidade = $quantLancada;
											}

											if($ordemAutomatica){
												$$quantidade = $e62_quant;
											}

											$qtde = "qtde_$i";
											$$qtde = !$$quantidade ? 0 : $$quantidade;
                                            $$qtde = trim(db_formatar($$qtde, 'f'));

											$valor = "valor_$i";
											$$valor = trim(db_formatar($e62_vlrun, 'f'));

											$valor_total = "vltotalemp_". "$i";

											if(!($e62_vltot - $valorLancado)){
												$valor_restante = $oItemValores->m52_valor;
											}else{
												$valor_restante = $e62_vltot - $valorLancado + $oItemValores->m52_valor;
											}

											if(!$valor_restante){
												$valor_restante = $e62_vltot;
											}

											if(!$valor_restante){
											    $valor_restante = db_formatar(0, 'f');
                                            }

											$$valor_total = trim(db_formatar($valor_restante, 'f'));

											$vltotal = "vltotal_". "$i";
											if($oItemValores->m52_valor){
												$$vltotal = trim(db_formatar($oItemValores->m52_valor, 'f'));
											}else{
												$$vltotal = trim(db_formatar(0, 'f'));
											}

											echo "	 <td class='linhagrid' align='center'>";
											echo "		 <small>";
											echo "          <input id='$quantidade' class='input__static' value=' ". $$quantidade . "' disabled />";
											echo "		 </small>";
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>
														<small>";
											                db_input("valor_$i", 10, 0, true, 'text', 3);
											echo "		</small>";
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>";
											echo "		 <small>";
											echo "          <input id='$valor_total' class='input__static' value='". $$valor_total ."' disabled />";
											echo "		 </small>";
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>";
											echo "		 <small>";
											                db_input("qtde_$i", 10, 0, true, 'text', 3);
											echo "		 </small>";
											echo "	 </td>";
											echo "	 <td class='linhagrid' align='center'>";
											echo "		 <small>";
											                db_input("vltotal_$i", 15, 0, true, 'text', $opcao, "onchange='js_validaValor(this, \"v\");'onkeyup='js_limitaCaracteres(this)';");
											echo "		 </small>";
											echo "   </td>";
											echo " </tr>";
										}
									}
								}
							}
							?>

                            <? if($numrows > 0):?>

                            <tr>
                                <td colspan="12">
                                    <div style="display: block;height: auto; background-color:#EEEFF2; border-top:1px solid #444444; padding: 6px 42px 19px 10px;+">
                                        <div style="float: left; width: 50%; text-align: left">
                                            <b>Total de Registros: </b><span id="total_de_itens">0</span>
                                        </div>
                                        <div style="float: left; width: 50%; text-align: right">
                                            <b>Valor total: </b><span id="valor_total">0.00</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?endif;?>
                        </table>
                    </fieldset>
            </form>
            </center>
        </td>
    </tr>
</table>
<script>

    function js_pesquisaEmpenho(iNumEmp){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho001.php?e60_numemp='+iNumEmp,'Pesquisa',true);
    }

    function js_verifica(max, quan, nome, valoruni) {

        if (max < quan) {
            alert("Informe uma quantidade valida!!");
            eval("document.form1." + nome + ".value='';");
            eval("document.form1." + nome + ".focus();");
        } else {
            i = nome.split("_");
            pos = i[3];
            quant = new Number(quan);
            valor = new Number(valoruni);
            valortot = quant * valor;

            eval("document.form1.valor_" + pos + ".value=valortot.toFixed(2)");

        }

    }

    function js_marcaLinha(obj, sequencia) {

        let vlr_anterior = document.getElementById(`valor_${sequencia}`).value;
        let qtd_anterior = 0;

        let iQuantidade = document.getElementById(`quant_${sequencia}`).value;

        if (iQuantidade) {
            qtd_anterior = iQuantidade.replace(/\,/g, '.');
        }

        let idTr = document.getElementById(`tr_${obj.value}`);
        let valor_total = document.getElementById('valor_total');
        let total_itens = document.getElementById('total_de_itens');

        if (obj.checked) {

            if (idTr.className === 'marcado') {
                return;
            }

            total_itens.innerText = parseInt(total_itens.innerText, 10) + 1;
            idTr.className = 'marcado';

        } else {

            if (idTr.className === 'marcado') {
                idTr.className = 'normal';

                total_de_itens.innerText = parseInt(total_de_itens.innerText, 10) >= 1 ?
                    parseInt(total_de_itens.innerText, 10) - 1 : 0;

                let total_rodape = valor_total.innerText.replace(/\./g, '').replace(/\,/g, '.');
                let temp = parseFloat(total_rodape) - Number(vlr_anterior.replace(',', '.')) * parseFloat(qtd_anterior);

            }
        }
        js_somaItens();
    }

    function js_marca(val){
        obj = document.getElementById('mtodos');

        if(obj.checked) {
            obj.checked = false;
        } else {
            obj.checked = true;
        }
        itens = js_getElementbyClass(form1,'itensEmpenho');

        for (let i = 0; i < itens.length; i++){
            if (itens[i].disabled == false){
                if (obj.checked == true){
                    itens[i].checked=true;
                    js_marcaLinha(itens[i], i);
                }else{
                    itens[i].checked=false;
                    js_marcaLinha(itens[i], i);
                }
            }
        }
    }

    function js_validaValor(item, tipo='v'){

        let indexLinha = item.id.split('_')[1];

        if(Number(item.value) < 0){
            alert('Não é permitido a inserção de números negativos');
            document.getElementById(item.id).value = 0;
        }

        let message = '';
        let fieldTotal = document.getElementById(`vltotal_${indexLinha}`);
        let total_rodape = valor_total.innerText.replace(/\./g, '').replace(/\,/g, '.');

        if(tipo == 'v'){
            let valor_total = document.getElementById(`vltotalemp_${indexLinha}`).value;
            let novo_valor = 0;

            if(valor_total.includes(',') && valor_total.includes('.')){
                valor_total = valor_total.replace(/\./g, '').replace(/\,/g, '.');
            }else{
                valor_total = valor_total.replace(/\,/g, '.');
            }

            valor_total = valor_total.replace(/\s/g, '');

            if(item.value.includes(',')){
                novo_valor = item.value.replace(/\./g, '').replace(/\,/g, '.');
            }else{
                novo_valor = item.value.replace(/\,/g, '.');
            }

            novo_valor = novo_valor.replace(/\s/g, '');

            if(Number(novo_valor) > Number(valor_total)){
                message = 'Valor inserido maior que o valor do item no Empenho!';
                item.value = js_formatar(valor_total, 'f');
            }else{
                // nova_quantidade = !Number.isNaN(Number(nova_quantidade)) ? nova_quantidade : document.getElementById(`quant_${indexLinha}`).value;
                document.getElementById(`vltotal_${indexLinha}`).innerText = js_formatar(Number(novo_valor), 'f');

                let valor_unitario = document.getElementById(`valor_${indexLinha}`).value;
                fieldTotal.value = js_formatar(Number(novo_valor), 'f');
            }

        }else{
            let qtde_total = document.getElementById(`quant_${indexLinha}`).value;
            let nova_quantidade = 0;

            if(item.value.includes(',')){
                nova_quantidade = item.value.replace(/\.\s/g, '').replace(/\,/g, '.');
            }else{
                nova_quantidade = item.value.replace(/\,/g, '.');
            }

            if(parseFloat(nova_quantidade) > parseFloat(qtde_total)){
                message = 'Quantidade inserida maior que o valor do item no Empenho!';

                let valor_unitario = document.getElementById(`valor_${indexLinha}`).value;
                fieldTotal.value = js_formatar((parseFloat(qtde_total.replace(',', '.')) * parseFloat(valor_unitario.replace(',', '.'))), 'f');
                item.value = js_formatar(qtde_total, 'f');
            }else{

                let valor_unitario = Number(document.getElementById(`valor_${indexLinha}`).value.replace(/\,/g, '.'));
                fieldTotal.value = js_formatar((parseFloat(nova_quantidade) * valor_unitario), 'f');
                temp = parseFloat(total_rodape) - valor_unitario * parseFloat(nova_quantidade);

            }

        }

        if(message){
            alert(message);
        }

        js_somaItens();
    }

    function js_limitaCaracteres(obj){
        let novo_valor = 0;

        if(obj.value.includes(',')){
            let aValores = obj.value.split(',');

            if(aValores[1].length > 4){
                aValores[1] = aValores[1].slice(0, -1);
            }

            let valor_final = aValores.join(',');

            document.getElementById(obj.id).value = js_formatar(valor_final, 'f');
            return;

        }

        if(obj.value.includes(',') && obj.value.includes('.')){
            novo_valor = obj.value.replace('.', '').replace(',', '.');
        }

        let regex = /[0-9\.\,]+$/;

        if(!obj.value.match(regex)){
            novo_valor = obj.value.slice(0, -1);
            document.getElementById(obj.id).value = novo_valor;
        }

    }

    function js_somaItens(){
        let aItens = js_getElementbyClass(form1,'itensEmpenho');
        let valor_total = 0;

        for(let i = 0; i < aItens.length; i++){

            let valorLinha = document.getElementById(`vltotal_${i}`).value;
            if(valorLinha.includes(',') && valorLinha.includes('.')){
                valorLinha = valorLinha.replace('.', '').replace(',','.');
            }else if(valorLinha.includes(',')){
                valorLinha = valorLinha.replace(',','.');
            }

            if(aItens[i].checked){
                valor_total += Number(valorLinha);
            }

            document.getElementById('valor_total').innerText = js_formatar(valor_total, 'f');
        }
    }


</script>
</body>
</html>
