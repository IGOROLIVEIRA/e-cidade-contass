<?php
//apos a solicitacao da ocorrencia 4864, foi criado esse formulario com o objetivo de sintetizar o cadatro da manutencao
//em uma mesma tela
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
//MODULO: veiculos
include("dbforms/db_classesgenericas.php");

$clveicmanut->rotulo->label();
$clveicmanutitem->rotulo->label();

$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;

$clrotulo = new rotulocampo;

$clrotulo->label("ve28_descr");
$clrotulo->label("ve01_placa");
$clrotulo->label("ve65_veicretirada");
$clrotulo->label("ve60_codigo");
$clrotulo->label("z01_nome");
$clrotulo->label("ve66_veiccadoficinas");
$clrotulo->label("ve07_sigla");
$clrotulo->label("e60_codemp");
$clrotulo->label("ve62_codigo");
$clrotulo->label("pc01_descrmater");
$clrotulo->label("ve64_pcmater");
if ($db_opcao == 1) {
    $db_action = "vei1_veicmanut004.php";
} else if ($db_opcao == 2 || $db_opcao == 22) {
    $db_action = "vei1_veicmanut005.php";
} else if ($db_opcao == 3 || $db_opcao == 33) {
    $db_action = "vei1_veicmanut006.php";
}

$sHora = db_hora();

db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js,dbautocomplete.widget.js");
db_app::load("dbmessageBoard.widget.js, prototype.js, dbtextField.widget.js, dbcomboBox.widget.js, widgets/DBHint.widget.js");
db_app::load("estilos.css, grid.style.css");

?>
<center>
    <form name="form1" method="post" action="<?= $db_action ?>">

        <table border="0">
            <tr>
                <td>
                    <fieldset>
                        <legend><b>Dados da Manutenção</b></legend>
                        <table>
                            <tr style="<?php if($db_opcao == 1)echo "display:none;"; ?>">
                                <td nowrap title="<?= @$Tve62_codigo ?>">
                                    <?= @$Lve62_codigo ?>
                                </td>
                                <td>
                                    <?
                                    db_input('ve62_codigo', 10, $Ive62_codigo, true, 'text', 3, "")
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap title="<?= @$Tve62_veiculos ?>">
                                    <?
                                    db_ancora(@$Lve62_veiculos, "js_pesquisave62_veiculos(true);", $db_opcao);
                                    ?>
                                </td>
                                <td>
                                    <?
                                    db_input('ve62_veiculos', 10, $Ive62_veiculos, true, 'text', $db_opcao,
                                        " onchange='js_pesquisave62_veiculos(false);'");
                                    db_input('ve01_placa', 10, $Ive01_placa, true, 'text', 3, '')
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="<?= @$Tve65_veicretirada ?>">
                                    <?
                                    db_ancora(@$Lve65_veicretirada, "js_pesquisave65_veicretirada(true);", $db_opcao);
                                    ?>
                                </td>
                                <td>
                                    <?
                                    db_input('ve65_veicretirada', 10, $Ive65_veicretirada, true, 'text', 3,
                                        " onchange='js_pesquisave65_veicretirada(false);'");
                                    db_input('ve60_codigo', 10, $Ive60_codigo, true, 'hidden', 3, '')
                                    ?>
                                </td>
                            </tr>
                            <?php
                            /**
                             * Ocorrência 1193
                             * Campo incluído conforme solicitado em planilha anexa à ocorrencia.
                             */
                            ?>

                            <tr>
                                <td nowrap title="<?= @$Tve62_dtmanut ?>">
                                    <?= @$Lve62_dtmanut ?>
                                </td>
                                <td>
                                    <?
                                    db_inputdata('ve62_dtmanut', @$ve62_dtmanut_dia, @$ve62_dtmanut_mes, @$ve62_dtmanut_ano,
                                        true, 'text', $db_opcao,
                                        "onchange='js_pesquisa_medida();'", "", "", "none", "", "", "js_pesquisa_medida();")
                                    ?>
                                    <strong>Hora:</strong>
                                    <?php db_input('ve62_hora', 5, $Ive62_hora, true, 'text', $db_opcao); ?>
                                </td>
                                
                            </tr>


                            
                            <tr style="display:none;">
                                <td nowrap title="<?=@$Tve62_descr?>">
                                    <?=@$Lve62_descr?>
                                </td>
                                <td>
                                    <?
                                    //db_input('ve62_descr',60,$Ive62_descr,true,'text',$db_opcao,"")
                                    ?>
                                    <input type="text" id="ve62_descr" value="Manutenção" name="ve62_descr">
                                </td>
                            </tr>                        </tr>
                            <tr id="nota">
                                <td nowrap title="<?= @$Tve62_notafisc ?>">
                                    <?= @$Lve62_notafisc ?>
                                </td>
                                <td>
                                    <?
                                    db_input('ve62_notafisc', 10, $Ive62_notafisc, true, 'text', $db_opcao, "")
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="Última Medida"><b>Última Medida:</b></td>
                                <td>
                                    <?
                                    $ultimamedida = 0;
                                    if (isset($ve62_veiculos) && $ve62_veiculos != "") {

                                        $dData = substr(@$ve62_dtmanut, 6, 4) . '-' . substr(@$ve62_dtmanut, 3, 2) . '-' . substr(@$ve62_dtmanut, 0, 2);
                                        $oVeiculo = new Veiculo($ve62_veiculos);
                                        $ultimamedida = $oVeiculo->getUltimaMedidaUso($dData);
                                    }
                                    db_input("ultimamedida", 20, 0, true, "text", 3);
                                    if (isset($ve07_sigla) && trim($ve07_sigla) != "") {
                                        echo " " . db_input("ve07_sigla", 3, 0, true, "text", 3);
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="<?= @$Tve62_medida ?>">
                                    <?= @$Lve62_medida ?>
                                </td>
                                <td>
                                    <?
                                    db_input('ve62_medida', 20, $Ive62_medida, true, 'text', $db_opcao, "");
                                    db_input("ve07_sigla", 3, 0, true, "text", 3);
                                    ?>
                                </td>
                            </tr>

                            <?php
                            /**
                             * Ocorrência 1193
                             * Campo incluído conforme solicitado em planilha anexa à ocorrencia.
                             */
                            ?>
                            <tr>
                                <td nowrap title="<?= @$Tve62_tipogasto ?>">
                                    <?//= @$Lve62_tipogasto ?>
                                    <strong>Tipo de gasto:</strong>
                                </td>
                                <td>
                                    <?
                                    $x = array("0"=> "Selecione","6" => "Óleo lubrificante", "7" => "Graxa (Quilograma)", "8" => "Peças", "9" => "Serviços");
                                    db_select('ve62_tipogasto', $x, true, $db_opcao, "");
                                    ?>

                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="<?= @$Tve62_origemgasto ?>">
                                    <?//= @$Lve62_origemgasto ?>
                                    <strong>Origem de gasto:</strong>
                                </td>
                                <td>
                                    <?
                                    $x = array("2" => "Consumo imediato","1" => "Estoque");
                                    db_select('ve62_origemgasto', $x, true, $db_opcao, "onchange='js_mostraEmpenho()'");
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap title="Itens do empenho" id="itensEmp1">
                                    <strong>Itens do empenho:</strong>
                                </td>
                                <td>
                                    <?
                                    $x = array("0"=>"Selecione","1" => "Sim", "2" => "Não");
                                    db_select('ve62_itensempenho', $x, true, $db_opcao,"onClick='mostrarCadastro();'"); 
                                    ?>
                                </td>
                            </tr>

                            <tr>
                              <td align="left" id="emp1" nowrap title="<?= $Te60_codemp ?>">
                                  <? 
                                   db_ancora("Número do Empenho:", "js_pesquisae60_codemp(true,1);", 1);
                                  ?>
                                </td> 
                                <td id="emp2">
                                  <? //db_ancora("Seq. Empenho", "js_pesquisae60_codemp(true);", 1); ?>

                                  <?php db_input('si05_numemp', 10, $Isi05_numemp, true, 'hidden', 1); ?> 
                                  <?php db_input('e60_codemp', 10, $Ie60_codemp, true, 'text', 1); ?>
                                  <input type ="hidden" id="numcgm_oficina" name="numcgm_oficina">
                                  <input type = "hidden" id="controle1">
                                  <input type = "hidden" id="controle2">
                                </td>

                              </tr>

                            

                            <tr id='tr_proximamedida' style="display:none">
                                <td nowrap title="Próxima Medida"><b>Próxima Medida:</b></td>
                                <td>
                                    <?
                                    $Queryproximamedida = $clveiculos->sql_record($clveiculos->sql_query_proximamedida(@$ve62_veiculos, @$dData, $sHora));
                                    if ($clveiculos->numrows > 0) {
                                        db_fieldsmemory($Queryproximamedida, 0);
                                    } else {
                                        $proximamedida = 0;
                                    }
                                    db_input("proximamedida", 15, 0, true, "text", 3);
                                    if (isset($ve07_sigla) && trim($ve07_sigla) != "") {
                                        echo " " . db_input("ve07_sigla", 3, 0, true, "text", 3);
                                    }
                                    ?>
                                </td>
                            </tr>
                            

                            <?php
                            /**
                             * Ocorrência 1193
                             * Campo incluído conforme solicitado em planilha anexa à ocorrencia.
                             */
                            ?>
                            
                            <tr id="" style="display: none;">
                                <td nowrap title="<?= $Tve62_numemp ?>">
                                    <? db_ancora("Seq. Empenhooo", "js_pesquisae60_codemp(true);", 1); ?>

                                </td>

                                <td title="<?= $Te60_codemp ?>">
                                    <?php db_input('ve62_numemp', 10, $Ive62_numemp, true, 'text', 3); ?>
                                    <?= @$Le60_codemp ?>
                                    <!--<input type="text" autocomplete="off" style="background-color:#DEB887;text-transform:uppercase;" readonly="" maxlength="15" size="10" value="<?php echo "$e60_codemp/$e60_anousu"; ?>" id="e60_codemp" name="e60_codemp" title="Número do Empenho - não é o sequencial Campo:e60_codemp">-->
                                </td>

                            </tr> 
                                 
                            
                            <tr>
                                <td nowrap title="<?= @$Tve66_veiccadoficinas ?>">
                                <div id="ancoOfcina01" style="display:none;">
                                    <?
                                    db_ancora(@$Lve66_veiccadoficinas, "js_pesquisave66_veiccadoficinas(true);", $db_opcao);
                                    ?>
                                </div>
                                <div id="ancoOfcina02">    
                                    <strong>Oficina</strong>
                                </div>    
                                </td>
                                <td>
                                    <?
                                    db_input('ve66_veiccadoficinas', 10, $Ive66_veiccadoficinas, true, 'text', 3,
                                        "onchange='js_pesquisave66_veiccadoficinas(false);'");
                                    db_input('z01_nome', 40, $Iz01_nome, true, 'text', 3, '')
                                    ?>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="<?= @$Tve62_veiccadtiposervico ?>">
                                    <?
                                    db_ancora(@$Lve62_veiccadtiposervico, "js_pesquisave62_veiccadtiposervico(true);", $db_opcao);
                                    ?>
                                </td>
                                <td>
                                    <?
                                    db_input('ve62_veiccadtiposervico', 10, $Ive62_veiccadtiposervico, true, 'text', $db_opcao,
                                        " onchange='js_pesquisave62_veiccadtiposervico(false);'");
                                    db_input('ve28_descr', 40, $Ive28_descr, true, 'text', 3, '');
                                    ?>
                                </td>
                            </tr> 
                            
                            <tr>
                                <td nowrap title="<?= @$Tve62_atestado ?>">
                                    <?//= @$Lve62_atestado ?>
                                    <strong>Atestado de controle interno:</strong>
                                </td>
                                <td>
                                    <?
                                    $x = array("1" => "Sim", "2" => "Não");
                                    db_select('ve62_atestado', $x, true, $db_opcao, "");
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap="nowrap" title="<?= @$Tve62_observacao ?>" colspan="2">

                <fieldset style="display:none;" id="itensCadastro">

                        <legend style="display:block;">Cadastro de itens de manutenção</legend>
                        <table style="display:block;">
                            <tr>
                                <td nowrap title="<?=@$Tve63_descr?>">
                                    <?=@$Lve63_descr?>
                                </td>
                                <td>
                                    <?
                                    db_input('ve63_descr',51,$Ive63_descr,true,'text',$db_opcao,"")
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="<?=@$Tve63_quant?>">
                                    <?=@$Lve63_quant?>
                                </td>
                                <td>
                                    <?
                                    db_input('ve63_quant',8,$Ive63_quant,true,'text',$db_opcao,"onBlur='calcularValor();'")
                                    ?>
                                    <strong>Valor Unitário:<strong>
                                    <?
                                    db_input('ve63_vlruni',8,$Ive63_vlruni,true,'text',$db_opcao,"onBlur='calcularValor();'")
                                    ?>
                                    <strong>Valor Total:<strong>
                                    <?
                                    db_input('valorTotal',8,"",true,'text',3,"")
                                    ?>
                                </td>
                            </tr>
                           <!--         
                            <tr>
                                <td nowrap title="<?=@$Tve63_vlruni?>">
                                    <?=@$Lve63_vlruni?>
                                </td>
                                <td>
                                    <?
                                    db_input('ve63_vlruni',15,$Ive63_vlruni,true,'text',$db_opcao,"")
                                    ?>
                                </td>
                            </tr> -->
                            <tr style="display:none;">
                                <td nowrap title="<?=@$Tve64_pcmater?>">
                                    <?
                                    db_ancora(@$Lve64_pcmater,"js_pesquisave64_pcmater(true);",$db_opcao);
                                    ?>
                                </td>
                                <td>
                                    <?
                                    db_input('ve64_pcmater',10,$Ive64_pcmater,true,'text',$db_opcao," onchange='js_pesquisave64_pcmater(false);'")
                                    ?>
                                    <?
                                    db_input('pc01_descrmater',40,$Ipc01_descrmater,true,'text',3,'')
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <span style="cursor:pointer; height: 17px !important;background-color: #d9d5d5; border-radius: 2px;font-family: Arial, Helvetica, sans-serif, verdana; font-size: 12px; height: 17px; border: 1px solid #999999;padding: 1px 8px; color: #2d2d54;"> <a onclick="incluir_item(event);">Incluir item</a>
                                    </span>
                                    
                        </table>

                        </fieldset>      
                                <fieldset style="display:none;" id="itensLancados"><legend >Itens lançados</legend>
                        <table width="100%" height="100%"  cellspacing="2px" cellpadding="1px" border="0" bgcolor="#cccccc">
                            <tbody >
                            <tr>
                                <td valign="top" align="center">
                                    <table style="" width="100%" id="itens_lancados" cellspacing="0px" border="1px" bgcolor="#cccccc">

                                        <tr class="cabec">
                                            <td class="cabec" ><strong>Código Seq.</strong></td>

                                            <td class="cabec" ><strong>Descrição do Item</strong></td>
                                            <td class="cabec" ><strong>Quantidade</strong></td>
                                            <td class="cabec" ><strong>Valor Unitário</strong></td>
                                            <td class="cabec" ><strong>Valor Total</strong></td>
                                            <!--<td class="cabec" id="material"><strong>Material</strong></td>
                                            <td class="cabec" style="display:none;" id="descri"><strong>Descrição do Material</strong></td>-->
                                            <td class="cabec" ><b>Opções</b></td>
                                        </tr>


                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="<?= @$Tve62_valor ?>" style="text-align:right;">
                                    <br>
                                    <b> Valor total: </b>
                                    <?
                                    db_input('ve62_valor', 10, $Ive62_valor, true, 'text', 3, "readonly")
                                    ?>
                                </td>
                    

                            </tr>
                            </tbody>
                        </table>
                    </fieldset>

                                    <fieldset>
                                        <legend><?= $Lve62_observacao ?></legend>
                                        <?php db_textarea('ve62_observacao', 4, 69, $Ive62_observacao, true, 'text', $db_opcao); ?>
                                        <!--textarea name="ve62_observacao" id="ve62_observacao" style="background-color:#E6E4F1" onkeyup=" js_ValidaCampos(this,0,'Observação','t','f',event); " onblur=" js_ValidaMaiusculo(this,'f',event);" cols="68" rows="4" title="Observação sobre a manutenção efetuada Campo:ve62_observacao"><?=$ve62_observacao ?></textarea-->
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                    <?php if($db_opcao!=3): ?>
            <tr>
                <td style="display:block;">

                
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        </fieldset>
        </td>
        </tr>
        <input type="hidden" name="itens" value="<?php if(isset($itens))echo str_replace("\\","",utf8_decode($itens)); ?>" id="sItens">
        <tr>
            <td colspan="2" style='text-align:center;'>
                <input
                        name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>"
                        type="submit" id="db_opcao"
                        value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>"
                    <?= ($db_botao == false ? "disabled" : "") ?> onclick="return js_valida();">
                <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
            </td>
        </tr>
        </table>
    </form>
</center>
<div id='frmDadosAutorizacao' style='display: none'>
    <form name='form2'>
        <center>
        <table style='width: 100%' border='0'>
            <tr>
                <td width="100%">
                    <table width="100%">
                        <tr>
                            <td colspan='3'>
                                <fieldset>
                                    <div id='ctnGridItens'>
                                    </div>
                                </fieldset>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: center">
                </td>
            </tr>
        </table>
    </fieldset>
    <input type='button' id="salvarV" value='Salvar' onclick="js_enviarvalores();" style="margin-top: 10px;">
        </center>
    </form>
</div>

<script type="text/javascript">
        var el = document.getElementById("e60_codemp");
        el.onblur = function(){
            
            console.log("blur", "saiu do input" , this);
            
            var valor_e60Codemp = $F("e60_codemp");
            var valor_ve70Dtabast = $F("ve62_dtmanut");
            if(valor_e60Codemp!="" && valor_ve70Dtabast!=""){
                js_pesquisae60_codemp(true,0);
            }
            if(valor_ve70Dtabast==""){
                alert("Preencher Data da Manutenção");
            }else if(valor_e60Codemp==""){
                alert("Preencher Número do Empenho");
                document.getElementById("ve66_veiccadoficinas").value = " " ;
                document.getElementById("z01_nome").value = " " ;
                
            }
            
            /// ; utilizando desta forma o this aqui dentro sera o input
        }
    //esconder itens
    //document.getElementById('nota').style.display = "none";
    var num_row = 0;
    var itens = [];
    var cell7 = 0;
    <?php
    foreach ($rSqlItens as $item) {
        if($item->ve62_veiculos!=""){
            echo "incluir_item_php('".$item->ve62_veiculos."',";
            echo "'".$item->ve63_descr."',";
            echo "'".$item->ve63_quant."',";
            echo "'".$item->ve63_vlruni."',";
            echo "'".$item->ve64_pcmater."',";
            echo "'".$item->pc01_descrmater."'); ";
        }
        
    }
    ?>
    <?php
    if(isset($itens)){
        
        foreach (json_decode(str_replace("\\","",utf8_encode($itens))) as $item) {

            $what = array("Â°", chr(13), chr(10), 'Ã¤', 'Ã£', 'Ã ', 'Ã¡', 'Ã¢', 'Ãª', 'Ã«', 'Ã¨', 'Ã©', 'Ã¯', 'Ã¬', 'Ã­', 'Ã¶', 'Ãµ', 'Ã²', 'Ã³', 'Ã´', 'Ã¼', 'Ã¹', 'Ãº', 'Ã»', 'Ã€', 'Ã', 'Ãƒ', 'Ã‰', 'Ã', 'Ã“', 'Ãš', 'Ã±', 'Ã‘', 'Ã§', 'Ã‡', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'Âª', 'Âº');
            $by = array('', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');
            $valor = str_replace($what, $by, $item->ve63_descr);
            $valorDescr = $valor; 
            if($item->ve62_veiculos!=""){
                echo "incluir_item_php('".$item->ve62_veiculos."',";
                echo "'".$valorDescr."',";
                echo "'".$item->ve63_quant."',";
                echo "'".$item->ve63_vlruni."',";
                echo "'".$item->ve64_pcmater."',";
                echo "'".$item->pc01_descrmater."'); ";
            }
            
            
        }
    }
    ?>

    function mostrarCadastro(){
        var valItem = document.getElementById("ve62_itensempenho").value;
        if(valItem==2){
            document.getElementById("itensCadastro").style.display = "block";  
        }
        if(valItem==1){
            document.getElementById("itensCadastro").style.display = "none";  
        }

    }

    function calcularValor(){
        var quant = document.getElementById("ve63_quant").value;
        var val = document.getElementById("ve63_vlruni").value;
        if(quant!=""&&val!=""){
            resullt = parseFloat(quant) * parseFloat(val);
            document.getElementById("valorTotal").value = resullt.toFixed(2);
        }
        
        
    }
    var op = 0;
    function js_apaga_linha(e, num,controle){
        
        item = [];
        document.form1.ve62_valor.value = parseFloat(document.form1.ve62_valor.value - (itens[num].ve63_vlruni * itens[num].ve63_quant)).toFixed(2);
        if(num_row==1){
            
            cell7 = (itens[num].ve63_vlruni * itens[num].ve63_quant).toFixed(2) - (itens[num].ve63_vlruni * itens[num].ve63_quant).toFixed(2);
        }else{
            
            cell7-= (itens[num].ve63_vlruni * itens[num].ve63_quant).toFixed(2);
        }
        
        e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
        for(i = 0; i < itens.length; i++){
            if(i!=num){
                item[i]=itens[i];
            }
        }
        itens = item;
        //console.log(itens);
        document.form1.itens.value = JSON.stringify( itens );

        

        if(controle==1){
            num_row--;
            if(num_row==0){
                document.getElementById("itensLancados").style.display = "none";
            }
        }else{
                op++;
                vNum_row = 0;
                for(i = 0; i<num_row; i++){
                    vNum_row = vNum_row + 1;
                }

                if(op==vNum_row){
                    document.getElementById("itensLancados").style.display = "none";
                }
        }
        
        
        

    }
    var valorLExcluido = 0;
    function js_apaga_linha_toda(){
        
        for(j=valorLExcluido;j<=linhasLancadas;j++){
          
                item = [];
                document.form1.ve62_valor.value = parseFloat(document.form1.ve62_valor.value - (itens[j].ve63_vlruni * itens[j].ve63_quant)).toFixed(2);
                cell7-= (itens[j].ve63_vlruni * itens[j].ve63_quant).toFixed(2);

                var val = document.getElementById('linha_'+j);
                val.parentNode.removeChild(val);

                for(i = 0; i < itens.length; i++){
                    if(i!=j){
                        
                        item[i]=itens[i];
                    }
                }
                itens = item;
                //console.log(itens);
                document.form1.itens.value = JSON.stringify( itens );
                
                
        }
        valorLExcluido = linhasLancadas+1;
        return false;

    }
    var numGlobal = -1;
    function js_editar_linha(e, num,controle){
        numGlobal = num;
        
        for(i=0;i<num_row;i++){
            if(i!=num){
                
                var te = document.getElementById("edi_"+i);
                if(te!=null){
                    document.getElementById("edi_"+i).style.display = "none";
                    document.getElementById("exc_"+i).style.display = "none";
                }
                
            }
        }
        document.form1.ve62_veiculos.value = itens[num].ve62_veiculos;
        document.form1.ve63_descr.value = itens[num].ve63_descr;
        document.form1.ve63_quant.value = itens[num].ve63_quant;
        document.form1.ve63_vlruni.value = itens[num].ve63_vlruni;
        document.form1.ve64_pcmater.value = itens[num].ve64_pcmater;
        document.form1.pc01_descrmater.value = itens[num].pc01_descrmater;
        js_apaga_linha(e, num,controle);

    }
    
    function incluir_item_php(ve62_veiculos, ve63_descr, ve63_quant, ve63_vlruni, ve64_pcmater, pc01_descrmater){
        var cell1 = ve62_veiculos;
        var cell2 = ve63_descr;
        var cell3 = ve63_quant;
        var cell4 = ve63_vlruni;
        var cell5 = ve64_pcmater;
        var cell6 = pc01_descrmater;
       
        cell7 += parseFloat(cell3) * parseFloat(cell4);
        var it = $F("ve62_itensempenho");
       
        if(it==2){
            document.getElementById("itensCadastro").style.display = "block"; 
        }

        if(it==1){
            var content = '<tr id="linha_'+num_row+'"><td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell1+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell2+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell3+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell4+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+(ve63_quant*ve63_vlruni).toFixed(2)+'</td>  <td align="center"class="corpo" nowrap=""><a title="EXCLUIR CONTEÚDO DA LINHA" <?php if($db_opcao!=3): ?>href="#" onclick="js_apaga_linha(this,'+num_row+',1);return false;"<?php endif; ?>>E</a> </td> </tr>';
        }else{
            var content = '<tr id="linha_'+num_row+'"><td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell1+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell2+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell3+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell4+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+(ve63_quant*ve63_vlruni).toFixed(2)+'</td>  <td align="center"class="corpo" nowrap=""><a id="edi_'+num_row+'" title="EDITAR" <?php if($db_opcao!=3): ?>href="#" onclick="js_editar_linha(this,'+num_row+',2);return false;"<?php endif; ?>>A</a> <a id="exc_'+num_row+'" title="EXCLUIR CONTEÚDO DA LINHA" <?php if($db_opcao!=3): ?>href="#" onclick="js_apaga_linha(this,'+num_row+',1);return false;"<?php endif; ?>>E</a> </td> </tr>';
        }

        
        valores = {
            "ve62_veiculos" : cell1,
            "ve63_descr" : cell2,
            "ve63_quant" : cell3,
            "ve63_vlruni" : cell4,
            //"ve64_pcmater" : cell5,
            //"pc01_descrmater" : cell6,
        }
        itens[num_row] = valores;
        num_row++;
        document.form1.itens.value = JSON.stringify( itens );
        document.form1.ve62_valor.value = cell7.toFixed(2);
        document.getElementById('itens_lancados').innerHTML += content;


        //console.log(itens);

    }
    var linhasLancadas;
    function incluir_item(event){
        var cell1 = document.form1.ve62_veiculos.value;
        var cell2 = document.form1.ve63_descr.value;
        var cell3 = document.form1.ve63_quant.value;
        var cell4 = document.form1.ve63_vlruni.value;
        var cell5 = document.form1.ve64_pcmater.value;
        var cell6 = document.form1.pc01_descrmater.value;
        var result = document.form1.ve63_vlruni.value * document.form1.ve63_quant.value;
        
        var regex = /^[0-9.]+$/;
        if( !regex.test(result) ) {
            alert('Usuário: Verificar os valores');
            return false;
        }
        if(result==0){
            alert('Usuário: Verificar os valores');
            return false;
        }
        if(cell1 == ''){
            alert('Preencha o campo Veículos');
            return false;
        }
        if(cell2 == ''){
            alert('Preencha o campo Descrição da Peça');
            return false;
        }
        if(cell3 == ''){
            alert('Preencha o campo Quantidade');
            return false;
        }
        if(cell4 == ''){
            alert('Preencha o campo Valor Unitário');
            return false;
        }
        if(cell5 == ''){
            //alert('Preencha o campo Material');
            //return false;
            cell5 = 0;
        }
        if(cell6 == ''){
            //alert('Preencha o campo Material');
            //return false;
            cell6 = cell2;
        }
        var guardaNum = num_row;
        if(numGlobal!=-1){
            
            for(i=0;i<num_row;i++){
                if(i!=numGlobal){
                    var te = document.getElementById("edi__"+i);
                        if(te!=null){
                            document.getElementById("edi_"+i).style.display = "inline";
                            document.getElementById("exc_"+i).style.display = "inline";
                        }
                }
            }
            num_row = numGlobal;
        }
        
        /*
        for(i=0;i < itens.length; i++){
            if(itens[i]!=undefined && itens[i].ve64_pcmater == cell5){
                alert("Ítem já inserido");
                document.form1.itens.value = JSON.stringify( itens );


                document.form1.ve63_descr.value = "";
                document.form1.ve63_quant.value = "";
                document.form1.ve63_vlruni.value = "";
                document.form1.ve64_pcmater.value = "";
                document.form1.pc01_descrmater.value = "";
                //console.log(itens);
                return false;
            }

        }*/
        //alert(cell7);
        cell7 += parseFloat(document.form1.ve63_vlruni.value) * parseFloat(document.form1.ve63_quant.value);
        
        var it = $F("ve62_itensempenho");
       
        if(it==2){
            document.getElementById("itensCadastro").style.display = "block"; 
        }

        if(it==1){
            var content = '<tr id="linha_'+num_row+'"><td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell1+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell2+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell3+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell4+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+(parseFloat(document.form1.ve63_vlruni.value) * parseFloat(document.form1.ve63_quant.value)).toFixed(2)+'</td> <td align="center"class="corpo" nowrap=""><a title="EXCLUIR CONTEÚDO DA LINHA" href="#" onclick="js_apaga_linha(this,'+num_row+',1);return false;">E</a> </td> </tr>';
        }else{
            var content = '<tr id="linha_'+num_row+'"><td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell1+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell2+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell3+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+cell4+'</td> <td style="border:1px solid #AACCCC;" class="corpo" align="center">'+(parseFloat(document.form1.ve63_vlruni.value) * parseFloat(document.form1.ve63_quant.value)).toFixed(2)+'</td> <td align="center"class="corpo" nowrap=""><a id="edi_'+num_row+'" title="EDITAR" href="#" onclick="js_editar_linha(this,'+num_row+',2);return false;">A</a> <a id="exc_'+num_row+'"title="EXCLUIR CONTEÚDO DA LINHA" href="#" onclick="js_apaga_linha(this,'+num_row+',1);return false;">E</a> </td> </tr>';
        }
    
        
        valores = {
            "ve62_veiculos" : cell1,
            "ve63_descr" : cell2,
            "ve63_quant" : cell3,
            "ve63_vlruni" : cell4,
            //"ve64_pcmater" : cell5,
            //"pc01_descrmater" : cell6,
        }
        itens[num_row] = valores;
        if(numGlobal==-1){
            linhasLancadas = num_row;
            num_row++;
        }else{
            num_row = guardaNum;
        }
        
        document.form1.itens.value = JSON.stringify( itens );

        document.getElementById("itensLancados").style.display = "block";

        document.form1.ve63_descr.value = "";
        document.form1.ve63_quant.value = "";
        document.form1.ve63_vlruni.value = "";
        document.form1.ve64_pcmater.value = "";
        document.form1.pc01_descrmater.value = ""; 
        document.form1.valorTotal.value = "";
        document.form1.ve62_valor.value = cell7.toFixed(2);
        document.getElementById('itens_lancados').innerHTML += content;

        //console.log(itens);
        numGlobal = -1;
        op = 0;

    }
    function js_pesquisave64_pcmater(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo.iframe_veicmanut','db_iframe_pcmater','func_pcmater.php?funcao_js=parent.js_mostrapcmater1|pc01_codmater|pc01_descrmater','Pesquisa',true,'0');
        }else{
            if(document.form1.ve64_pcmater.value != ''){
                js_OpenJanelaIframe('top.corpo.iframe_veicmanut','db_iframe_pcmater','func_pcmater.php?pesquisa_chave='+document.form1.ve64_pcmater.value+'&funcao_js=parent.js_mostrapcmater','Pesquisa',false);
            }else{
                document.form1.pc01_descrmater.value = '';
            }
        }
    }
    function js_mostrapcmater(chave,erro){
        document.form1.pc01_descrmater.value = chave;
        if(erro==true){
            document.form1.ve64_pcmater.focus();
            document.form1.ve64_pcmater.value = '';
        }
    }
    function js_mostrapcmater1(chave1,chave2){
        document.form1.ve64_pcmater.value = chave1;
        document.form1.pc01_descrmater.value = chave2;
        db_iframe_pcmater.hide();
    }
    //Para filtrar apenas empenhos com o elemento 333903037000000, usar o parametro filtromanut=1
    function js_pesquisae60_codemp(mostra) {
        var itememp = $F("ve62_itensempenho");
        
        if(itememp==1){
        
            var ve62_dtmanut = $F("ve62_dtmanut");
            var e60_codemp = $F("e60_codemp");
            if (mostra == true) {
                //js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_empempenho', 'func_empempenho.php?funcao_js=parent.js_mostraempempenho2|e60_numemp|e60_codemp|e60_anousu|DB_e60_emiss&filtromanut=1&ve62_dtmanut='+ve62_dtmanut+'', 'Pesquisa', true);
                
                if(e60_codemp!=""){
                    js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_empempenho', 'func_empempenho.php?filtromanut=1&ve62_dtmanut='+ve62_dtmanut+'&chave_e60_codemp='+e60_codemp+'&funcao_js=parent.js_mostraempempenho2|e60_numemp|e60_codemp|e60_anousu|e60_numcgm|', 'Pesquisa', true);
                }else{
                    if(ve62_dtmanut!=""){
                        js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_empempenho', 'func_empempenho.php?funcao_js=parent.js_mostraempempenho2|e60_numemp|e60_codemp|e60_anousu|e60_numcgm&filtromanut=1&ve62_dtmanut='+ve62_dtmanut+'', 'Pesquisa', true);
                    }else{
                        alert("Data não informada");
                    }
                    
                }
            } else {
                js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_empempenho', 'func_empempenho.php?pesquisa_chave=' + document.form1.ve62_numemp.value + '&funcao_js=parent.js_mostraempempenho&lNovoDetalhe=1&filtromanut=1&ve62_dtmanut='+ve62_dtmanut+'', 'Pesquisa', false);
            }
        }else if(itememp==2){
            
            document.getElementById("controle1").value = 1;
            var ve62_dtmanut = $F("ve62_dtmanut");
            var e60_codemp = $F("e60_codemp");
            
                if(e60_codemp!=""){
                    js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_empempenho', 'func_empempenho.php?filtromanut=1&ve62_dtmanut='+ve62_dtmanut+'&chave_e60_codemp='+e60_codemp+'&funcao_js=parent.js_mostraempempenho2|e60_numemp|e60_codemp|e60_anousu|e60_numcgm|', 'Pesquisa', true);
                }else{
                    if(ve62_dtmanut!=""){
                        js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_empempenho', 'func_empempenho.php?funcao_js=parent.js_mostraempempenho2|e60_numemp|e60_codemp|e60_anousu|e60_numcgm&filtromanut=1&ve62_dtmanut='+ve62_dtmanut+'', 'Pesquisa', true);
                    }else{
                        alert("Data não informada");
                    }
                    
                }
            
            //alert("Selecione uma opção Itens do Empenho");
        }
        
    }

    function js_mostraempempenho2(chave1, chave2, chave3,chave4) {
        var contro = $F("controle1");
        var contro2 = $F("controle2");
        document.form1.ve62_numemp.value = chave1;
        document.form1.e60_codemp.value = chave2 + '/' + chave3;
        document.getElementById("e60_codemp").value = chave2 + '/' + chave3;
        document.form1.numcgm_oficina.value = chave4;
        db_iframe_empempenho.hide();
        if(contro==1){
            if(contro2==1){
                document.getElementById("controle1").value = 0;
                document.getElementById("numcgm_oficina").value = "";
            }else{
                js_pesquisave66_veiccadoficinas(true);
                document.getElementById("controle1").value = 0;
            }
            
        }else{
            if(contro2==1){
                js_buscarInformacoesAutorizacao();
                document.getElementById("numcgm_oficina").value = "";
            }else{
                js_buscarInformacoesAutorizacao();
                js_pesquisave66_veiccadoficinas(true);
            }
            
        }
        
    }

    function js_mostraempempenho(chave1) {
        document.form1.e60_codemp.value = chave1;
        db_iframe_empempenho.hide();
    }
    var sUrlRpc1 = 'con4_empenhoitensManu.RPC.php';
    function js_buscarInformacoesAutorizacao() {

        var oParam           = new Object();
        oParam.exec          = 'buscarItens';
        oParam.numemp        = $F("ve62_numemp");

        var oAjax  = new Ajax.Request(sUrlRpc1,
            {method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete: js_retornoBuscarInformacoesAutorizacao
            });

    }
    function js_retornoBuscarInformacoesAutorizacao(oAjax) {
        
        /*
            var aItens = oGridItens.getSelection("object");
            if (aItens.length == 0) {

                alert('Nenhum item Selecionado');
                return false;

            }*/
            //var oRetorno = JSON.parse(oAjax.responseText);
            //var sMensagem = oRetorno.message;
            var oRetorno = eval('('+oAjax.responseText+")");

            if ( oRetorno.status > 1 ) {
                
                alert(sMensagem);
                return false;
            }
            /*
            $('e54_resumo').value = oRetorno.sResumoAcordo.urlDecode();
            $('e54_numerl').value = oRetorno.iProcesso;
            $('e54_codcom').value = oRetorno.sTipo;
            $('e54_codcomdescr').value = oRetorno.sTipo;
            $('e54_nummodalidade').value = oRetorno.iNumModalidade;
            $('iSequenciaCaracteristica').value = '000';
            $('sDescricaoCaracteristica').value = 'NÃO SE APLICA'; */

            setInformacoesAutorizacao();
            /*
            if(oRetorno.sTipoorigem == '2'){
                $('e54_numerl').setAttribute('readOnly',true);
                $('e54_numerl').setAttribute('disabled',true);
                $('e54_numerl').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
                $('e54_nummodalidade').setAttribute('readOnly',true);
                $('e54_nummodalidade').setAttribute('disabled',true);
                $('e54_nummodalidade').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
            }*/

    }
    var controleTela = 1;
    function setInformacoesAutorizacao() {
            
           // if ($('wndDadosAutorizacoes')) {
               
                //windowDadosAutorizacao.show();
               // js_main();
            //} else {
                
                var iWidth  = 720;
                var iHeight = js_round( screen.availHeight/1.8, 0);
                
                windowDadosAutorizacao = new windowAux('wndDadosAutorizacoes',
                    'Dados da(s) Autorização(ões) de Empenho',
                    iWidth,
                    iHeight
                );
                windowDadosAutorizacao.setObjectForContent($('frmDadosAutorizacao'));
                if(controleTela==1){
                        oMessageBoardDadosAut = new DBMessageBoard('msgboardDados',
                        'Itens do empenho ',
                        'Selecione e informe as quantidades',
                        $('frmDadosAutorizacao')
                        );
                }
                controleTela++;
                //windowDadosAutorizacao.setChildOf(windowAutorizacaoItem);
                windowDadosAutorizacao.show();
                
                // windowDadosAutorizacao.toFront();
                windowDadosAutorizacao.setShutDownFunction(function() {
                    windowDadosAutorizacao.hide();
                });
                js_main();
            //}
    }

    function js_main() {

            oGridItens = new DBGrid('oGridItens');
            oGridItens.nameInstance = "oGridItens";
            //oGridItens.hasTotalValue = true;
            oGridItens.setCheckbox(0);
            //oGridItens.allowSelectColumns(true);
            oGridItens.setCellWidth(new Array('10%','15%',"30%", "15%","15%", "15%", "15%","15%"));
            oGridItens.setHeader(new Array("Ordem", "Item", "Descrição Item", "Unidade",
                "Quantidade", "Qtde Utilizada", "Preço Unitário", "Preço Total", "iSeq"));
            // oGridItens.aHeaders[4].lDisplayed = false;
            oGridItens.aHeaders[9].lDisplayed = false;
            //oGridItens.aHeaders[8].lDisplayed = false;
            oGridItens.setHeight(160);
            oGridItens.show($('ctnGridItens'));
            //$('btnPesquisarPosicoes').onclick = js_pesquisarPosicoesContrato;
            //iTipoAcordo = 0;
            js_pesquisarPosicoesContrato();
    }
    function js_pesquisarPosicoesContrato() {
     
      js_divCarregando('Aguarde, pesquisando dados do acordo', 'msgbox');
      oGridItens.clearAll(true);
      var oParam                 = new Object();
      oParam.exec                = 'buscarItens';
      oParam.numemp              = $F("ve62_numemp"); 
      var oAjax      = new Ajax.Request(sUrlRpc1,
          {method:'post',
              parameters:'json='+Object.toJSON(oParam),
              onComplete: js_retornoGetItensPosicao
          }
      )
  }
   
  function js_retornoGetItensPosicao(oAjax){
            js_removeObj("msgbox");
            var oRetorno = eval('('+oAjax.responseText+")");
         
            if(oRetorno.status == 2){
              alert("ok");
            }else{
              oGridItens.clearAll(true);
              var aEventsIn  = ["onmouseover"];
              var aEventsOut = ["onmouseout"];
              aDadosHintGrid = new Array();

              oRetorno.itens.forEach(function (oItem, iSeq) {
                     
                      aLinha    = new Array();
                      //aLinha[0].addStyle("text-align","center");
                      aLinha[0] = oItem.ordem;
                      
                      // Descrição
                      aLinha[1] = oItem.item;

                      // Quantidade
                      aLinha[2] = oItem.descr.urlDecode();

                      // Valor unitário
                      aLinha[3] = "Unidade";

                      aLinha[4] = "<input type='text' value='"+oItem.quant+"' id='quant"+iSeq+"' style='width:80px; border:0px solid; text-align: center; background:#ffffff;' disabled>"; 

                      aLinha[5] = "<input type='text' id='qtUtilizada"+iSeq+"' style='width:80px;' onkeypress= 'return onlynumber();' onBlur='caluclarPreco("+iSeq+");''>";

                      var valor = oItem.vlrun*1;
                      valor = js_formatar(valor.toFixed(2), "f",2);

                      aLinha[6] = "<input type='text' id='vrl"+iSeq+"' value='"+valor+"' style='width:80px; border:0px solid; text-align: center; background:#ffffff;' disabled>";

                      aLinha[7] = "<input type='text' id='result"+iSeq+"' style='width:80px; border:0px solid; text-align: center; background:#ffffff;' disabled>";

                      aLinha[8] = "teste";

                      
                     

                      var oDadosHint           = new Object();
                      oDadosHint.idLinha   = `oGridItensrowoGridItens${iSeq}`;
                      oDadosHint.sText     = "";
                      aDadosHintGrid.push(oDadosHint);
                      oGridItens.addRow(aLinha, null, false);
              });     
                  oGridItens.renderRows();

                  js_changeTotal();

                  aDadosHintGrid.each(function(oHint, id) {
                      var oDBHint    = eval("oDBHint_"+id+" = new DBHint('oDBHint_"+id+"')");
                      oDBHint.setText(oHint.sText);
                      oDBHint.setShowEvents(aEventsIn);
                      oDBHint.setHideEvents(aEventsOut);
                      oDBHint.setPosition('B', 'L');
                      oDBHint.setUseMouse(true);
                      oDBHint.make($(oHint.idLinha), 2);
                  });

                  aItensPosicao.each(function (oItem, iLinha){
                      js_salvarInfoDotacoes(iLinha, false);
                  });
              
            }
            

    }
var opSalvar = 0;
var opSalva1 = 0;
    function caluclarPreco(valor){
      var quantItem = document.getElementById("quant"+valor).value; 
      //var quant = parseInt(document.getElementById("qtUtilizada"+valor).value);
      var valUti = document.getElementById("qtUtilizada"+valor).value;
      
      if(valUti!=""){
        var quant = parseInt(valUti);
      }
       
      if(quant>quantItem){
          alert("Quantidade utilizada maior que a quantidade do item no empenho");
          
      }else if(valUti==""){
         document.getElementById("result"+valor).value = "";
      }else{
            var vlr =   document.getElementById("vrl"+valor).value;
            const myArr = vlr.split(",");
            vlr = myArr[0]+"."+myArr[1];
            var resul = (quant*vlr);
            resul = js_formatar(resul.toFixed(2), "f",2);;
            document.getElementById("result"+valor).value = resul;
            opSalvar = 1;
      }
      
    }


    function js_pesquisaItem_emp(mostra) {
      if (mostra == true) {
          var si05_numemp = $F("ve62_numemp");
          
        js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_empempitem', 'func_empempitemManu.php?chave_e62_numemp='+si05_numemp+'&funcao_js=parent.js_mostraitem_emp2|e62_vlrun|e62_quant', 'Pesquisa', true);
      }
    }
    var quantItens = 0;
    function js_enviarvalores(){
      var aItens = oGridItens.getSelection("object");
      var retorno;
      var iCodigoVeiculo = $F('ve62_veiculos');
      var op = 0;
      var op1 = 0
      
        if (aItens.length == 0) {

            alert('Nenhum item Selecionado');

        }else if(opSalvar == 0){

            alert('Usuário: Insira a quantidade do item selecionado');

        }else{
            quantItens = aItens.length;
            for(var i=0;i<aItens.length;i++){
                with (aItens[i]) {
                    var oItem        = new Object();        
                    oItem.item       = aCells[2].getValue();
                    oItem.descr      = aCells[3].getValue(); 
                    oItem.quant      = aCells[5].getValue();       
                    oItem.quantUti   = aCells[6].getValue();
                    oItem.valor      = aCells[7].getValue();
                    retorno          = oItem.valor.split(",");  
                    oItem.valor      = retorno[0]+"."+retorno[1];
                    oItem.precoTo    = aCells[8].getValue();
                    
                    if(oItem.quantUti==""){
                        op = 1; 
                    }
                    if(oItem.quantUti==0){
                        op1 = 1;
                    }
                }
            }
           
            if(op==0 && op1==0){
                for(var i=0;i<aItens.length;i++){
                    with (aItens[i]) {
                        var oItem        = new Object();        
                        oItem.item       = aCells[2].getValue();
                        oItem.descr      = aCells[3].getValue(); 
                        oItem.quant      = aCells[5].getValue();       
                        oItem.quantUti   = aCells[6].getValue();
                        oItem.valor      = aCells[7].getValue();
                        retorno          = oItem.valor.split(",");  
                        oItem.valor      = retorno[0]+"."+retorno[1];
                        oItem.precoTo    = aCells[8].getValue();

                        document.getElementById("ve63_descr").value = oItem.descr;
                        document.getElementById("ve63_quant").value = oItem.quantUti;
                        document.getElementById("ve63_vlruni").value = oItem.valor;
                        document.getElementById("ve64_pcmater").value = oItem.item ;
                        document.getElementById("pc01_descrmater").value = oItem.descr;
                        
                        retorno = incluir_item(iCodigoVeiculo, oItem.descr, oItem.quantUti, oItem.valor, oItem.item, oItem.descr);
                    }
                 }
                 if(retorno!=false){
                         alert("Itens incluídos com sucesso!");
                 }
                    document.getElementById("itensLancados").style.display = "block";
                    windowDadosAutorizacao.hide();
            }else{
                alert("Usuário: Insira a quantidade do item selecionado");
            }
            
            
        }
    }

    function js_mostraEmpenho(){
        
        if (document.getElementById('ve62_origemgasto').value == 2) {
            document.getElementById('ancoOfcina01').style.display = "none";
            document.getElementById('ancoOfcina02').style.display = "block";
            document.getElementById('emp1').removeAttribute("style");
            document.getElementById('emp2').removeAttribute("style");
            //document.getElementById('empenho').removeAttribute("style");
            document.getElementById('ve62_itensempenho').style.display = "block";
            document.getElementById('itensEmp1').style.display = "block";
            //document.getElementById('nota').removeAttribute("style");
            //document.getElementById('ve62_numemp').setAttribute("required","required");
            //document.getElementById('nota').setAttribute("required","required");
        } else {
            document.getElementById('ancoOfcina01').style.display = "block";
            document.getElementById('ancoOfcina02').style.display = "none"; 
            document.getElementById('emp1').style.display = "none";
            document.getElementById('emp2').style.display = "none";  
            document.getElementById('ve62_itensempenho').value = 2;
            document.getElementById('ve62_itensempenho').style.display = "none"; 
            document.getElementById('itensEmp1').style.display = "none"; 
            document.getElementById('itensCadastro').removeAttribute("style");
            document.getElementById('controle2').value = 1;
            document.getElementById('empenho').style.display = "none";
            document.getElementById('ve62_numemp').removeAttribute("required");
            document.getElementById('nota').removeAttribute("required");

        }
    }


    /**
     * Formata e validar campo com hora
     *
     * @param Object elemento
     * @return void
     */
    (function js_formatarHora(elemento) {

        var self = this;

        this.change = function () {

            if (this.value == '') {
                return;
            }

            while (this.value.length < 5) {

                if (this.value.substr(0, 2).length == 1 || this.value.substr(0, this.value.indexOf(':')).length == 1) {
                    this.value = '0' + this.value;
                }

                if (this.value.length == 2) {
                    this.value += ':';
                }

                if (this.value.length < 5) {
                    this.value += '0';
                }
            }

            self.validar();
        }

        this.keyPres = function (event) {

            /**
             * 8  - backspace
             * 58 - :
             * 46 - del
             */
            var key = event.keyCode ? event.keyCode : event.charCode;

            if (key != 8 && key != 46) {

                if (key == 58 && this.value.length != 2) {
                    return false;
                }

                if (key != 58 && this.value.length == 2) {
                    this.value += ':';
                }
            }

            return js_mask(event, "0-9|:|0-9");
        }

        this.validar = function () {

            var iHoras = new Number(elemento.value.substr(0, 2));
            var iMinutos = new Number(elemento.value.substr(3, 5));

            try {

                if (elemento.value.indexOf(':') != 2) {
                    throw 'Hora inválida.';
                }

                if (iHoras > 24) {
                    throw 'Hora inválida.';
                }

                if (iHoras == 24 && iMinutos > 0) {
                    throw 'Hora inválida.';
                }

                if (iMinutos >= 60) {
                    throw 'Hora inválida.';
                }

            } catch (erro) {

                elemento.value = '';
                alert(erro);
            }
        }

        elemento.onkeypress = this.keyPres;
        elemento.onchange = this.change;

    })(document.getElementById('ve62_hora'));

    function js_pesquisave65_veicretirada(mostra) {

        var iCodigoVeiculo = $F('ve62_veiculos');

        if (iCodigoVeiculo == '') {

            document.form1.ve60_codigo.value = '';
            document.form1.ve65_veicretirada.value = '';
            alert('Selecione um Veículo.');
            return;
        }

        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_veicretirada', 'func_veicretirada.php?codigoveiculo=' + iCodigoVeiculo + '&funcao_js=parent.js_mostraveicretirada1|ve60_codigo|ve60_codigo', 'Pesquisa', true);
        } else {
            if (document.form1.ve65_veicretirada.value != '') {
                js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_veicretirada', 'func_veicretirada.php?codigoveiculo=' + iCodigoVeiculo + '&pesquisa_chave=' + document.form1.ve65_veicretirada.value + '&funcao_js=parent.js_mostraveicretirada', 'Pesquisa', false);
            } else {
                document.form1.ve60_codigo.value = '';
            }
        }
    }
    function js_mostraveicretirada(chave, erro) {
        document.form1.ve60_codigo.value = chave;
        if (erro == true) {
            document.form1.ve65_veicretirada.focus();
            document.form1.ve65_veicretirada.value = '';
        }
    }
    function js_mostraveicretirada1(chave1, chave2) {
        document.form1.ve65_veicretirada.value = chave1;
        document.form1.ve60_codigo.value = chave2;
        db_iframe_veicretirada.hide();
    }
    function js_pesquisave66_veiccadoficinas(mostra) {
        var num_cgm = $F("numcgm_oficina");
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_veiccadoficinas', 'func_veiccadoficinasalt.php?chave_numcgm='+num_cgm+'&funcao_js=parent.js_mostraveiccadoficinas1|ve27_codigo|z01_nome', 'Pesquisa', true);
        } else {
            if (document.form1.ve66_veiccadoficinas.value != '') {
                js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_veiccadoficinas', 'func_veiccadoficinasalt.php?pesquisa_chave=' + document.form1.ve66_veiccadoficinas.value + '&funcao_js=parent.js_mostraveiccadoficinas', 'Pesquisa', false);
            } else {
                document.form1.z01_nome.value = '';
            }
        }
    }
    function js_mostraveiccadoficinas(chave, erro) {
        document.form1.z01_nome.value = chave;
        if (erro == true) {
            document.form1.ve66_veiccadoficinas.focus();
            document.form1.ve66_veiccadoficinas.value = '';
        }
    }
    function js_mostraveiccadoficinas1(chave1, chave2) {
        document.form1.ve66_veiccadoficinas.value = chave1;
        document.form1.z01_nome.value = chave2;
        db_iframe_veiccadoficinas.hide();
    }
    function js_pesquisave62_veiccadtiposervico(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_veiccadtiposervico', 'func_veiccadtiposervico.php?funcao_js=parent.js_mostraveiccadtiposervico1|ve28_codigo|ve28_descr', 'Pesquisa', true, '0');
        } else {
            if (document.form1.ve62_veiccadtiposervico.value != '') {
                js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_veiccadtiposervico', 'func_veiccadtiposervico.php?pesquisa_chave=' + document.form1.ve62_veiccadtiposervico.value + '&funcao_js=parent.js_mostraveiccadtiposervico', 'Pesquisa', false, '0', '1', '775', '390');
            } else {
                document.form1.ve28_descr.value = '';
            }
        }
    }
    function js_mostraveiccadtiposervico(chave, erro) {
        document.form1.ve28_descr.value = chave;
        if (erro == true) {
            document.form1.ve62_veiccadtiposervico.focus();
            document.form1.ve62_veiccadtiposervico.value = '';
        }
    }
    function js_mostraveiccadtiposervico1(chave1, chave2) {
        document.form1.ve62_veiccadtiposervico.value = chave1;
        document.form1.ve28_descr.value = chave2;
        db_iframe_veiccadtiposervico.hide();
    }
    function js_pesquisave62_veiculos(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_veiculos', 'func_veiculosalt.php?funcao_js=parent.js_mostraveiculos1|ve01_codigo|ve01_placa', 'Pesquisa', true, '0');
        } else {
            if (document.form1.ve62_veiculos.value != '') {
                js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_veiculos', 'func_veiculosalt.php?pesquisa_chave=' + document.form1.ve62_veiculos.value + '&funcao_js=parent.js_mostraveiculos', 'Pesquisa', false, '0');
            } else {
                document.form1.ve01_placa.value = '';
                document.form1.ve60_codigo.value = '';
                document.form1.ve65_veicretirada.value = '';
            }
        }
    }
    function js_mostraveictipoabast(chave, erro) {
        document.form1.ve07_sigla.value = chave;
        if (erro == true) {
            document.form1.ve07_sigla.value = '';
        }
    }
    function js_mostraveiculos(chave, erro) {

        document.form1.ve60_codigo.value = '';
        document.form1.ve65_veicretirada.value = '';
        document.form1.ve01_placa.value = chave;
        if (erro == true) {
            document.form1.ve62_veiculos.focus();
            document.form1.ve62_veiculos.value = '';
        } else {
            js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_veiculos', 'func_veiculos.php?sigla=true&pesquisa_chave=' + document.form1.ve62_veiculos.value + '&funcao_js=parent.js_mostraveictipoabast', 'Pesquisa', false);
        }
    }
    function js_mostraveiculos1(chave1, chave2) {

        document.form1.ve60_codigo.value = '';
        document.form1.ve65_veicretirada.value = '';
        document.form1.ve62_veiculos.value = chave1;
        document.form1.ve01_placa.value = chave2;
        js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_veiculos', 'func_veiculos.php?sigla=true&pesquisa_chave=' + document.form1.ve62_veiculos.value + '&funcao_js=parent.js_mostraveictipoabast', 'Pesquisa', false, '0');
        db_iframe_veiculos.hide();
    }
    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_veicmanut', 'func_veicmanut.php?funcao_js=parent.js_preenchepesquisa|ve62_codigo', 'Pesquisa', true, '0');
    }

    function js_preenchepesquisa(chave) {
        db_iframe_veicmanut.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }

    function js_valida() {

        <? if ($db_opcao !=3 ) { ?>
        
        if(document.form1.sItens.value == "" || document.form1.sItens.value == "[]"){
            alert("É necessário inserir itens para incluir a manutenção");
            return false;
        }
        /**
         * Ocorrência 1193
         */

        if(document.getElementById('ve62_origemgasto').value == 2 && document.getElementById('ve62_numemp').value == ""){
            alert("Quando a origem do gasto for de consumo imediato, é obrigatório informar o empenho.");
            return false;
        }

        if(document.getElementById('ve62_descr').value.length < 5){
            alert("O campo Serviço Executado deve ter de 5 a 50 caracteres.");
            return false;
        }

        <? } ?>

        return true;
    }

    function js_pesquisa_medida() {
        var databanco = document.form1.ve62_dtmanut_ano.value + '-' +
            document.form1.ve62_dtmanut_mes.value + '-' +
            document.form1.ve62_dtmanut_dia.value;
        var manutencao = document.form1.ve62_codigo.value;
        js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_ultimamedida',
            'func_veiculos_medida.php?metodo=ultimamedida&veiculo=' + document.form1.ve62_veiculos.value +
            '&data=' + databanco +
            '&manutencao=' + manutencao +
            '&funcao_js=parent.js_mostraultimamedida', 'Pesquisa Ultima Medida', false);

        js_OpenJanelaIframe('top.corpo.iframe_veicmanut', 'db_iframe_proximamedida',
            'func_veiculos_medida.php?metodo=proximamedida&veiculo=' + document.form1.ve62_veiculos.value +
            '&data=' + databanco +
            '&manutencao=' + manutencao +
            '&funcao_js=parent.js_mostraproximamedida', 'Pesquisa Proxima Medida', false);
        return true;
    }

    function js_mostraultimamedida(ultimamedida, outro) {
        document.form1.ultimamedida.value = ultimamedida;
        return true;
    }

    function js_mostraproximamedida(proximamedida, outro) {
        document.form1.proximamedida.value = proximamedida;

        if (proximamedida != '0') {
            document.getElementById('tr_proximamedida').style.display = '';
        } else {
            document.getElementById('tr_proximamedida').style.display = 'none';
        }

        return true;
    }
    //inicio itens
    function js_cancelar(){
        var opcao = document.createElement("input");
        opcao.setAttribute("type","hidden");
        opcao.setAttribute("name","novo");
        opcao.setAttribute("value","true");
        document.form1.appendChild(opcao);
        document.form1.submit();
    }
    function js_pesquisave63_veicmanut(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo.iframe_veicmanutitem','db_iframe_veicmanut','func_veicmanut.php?funcao_js=parent.js_mostraveicmanut1|ve62_codigo|ve62_codigo','Pesquisa',true,'0','1','775','390');
        }else{
            if(document.form1.ve63_veicmanut.value != ''){
                js_OpenJanelaIframe('top.corpo.iframe_veicmanutitem','db_iframe_veicmanut','func_veicmanut.php?pesquisa_chave='+document.form1.ve63_veicmanut.value+'&funcao_js=parent.js_mostraveicmanut','Pesquisa',false);
            }else{
                document.form1.ve62_codigo.value = '';
            }
        }
    }
    function js_mostraveicmanut(chave,erro){
        document.form1.ve62_codigo.value = chave;
        if(erro==true){
            document.form1.ve63_veicmanut.focus();
            document.form1.ve63_veicmanut.value = '';
        }
    }
    function js_mostraveicmanut1(chave1,chave2){
        document.form1.ve63_veicmanut.value = chave1;
        document.form1.ve62_codigo.value = chave2;
        db_iframe_veicmanut.hide();
    }

    function onlynumber(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( key );
        //var regex = /^[0-9.,]+$/;
        var regex = /^[0-9.]+$/;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }

    function onlynumber(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( key );
        //var regex = /^[0-9.,]+$/;
        var regex = /^[0-9.]+$/;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }

</script>
