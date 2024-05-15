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
 *                                licenca/licenca_pt.txt
 */

$clrotulo = new rotulocampo;
$clrotulo->label("pc10_numero");
$clrotulo->label("pc10_data");
$clrotulo->label("pc10_resumo");
$clrotulo->label("pc80_resumo");
$clrotulo->label("pc80_codproc");
$clrotulo->label("pc80_tipoprocesso");
$clrotulo->label("descrdepto");

$val = false;

?>
<style>
    #pc80_dadoscomplementares,
    #pc10_resumo {
        width: 750px;
        height: 63px;
        background-color: #e6e4f1;
    }

    #pc80_numdispensa,
    #pc80_dispvalor,
    #l20_categoriaprocesso {
        width: 112px;
    }
    #pc80_modalidadecontratacao {
        width: 170px;
    }
</style>
<form name="form1" method="post" action="">
    <fieldset style="width:775px;">
        <legend>Dados do Processo de Compras</legend>
        <table border="0" width="50%">

            <table border="0" width="50%">
                <tr>
                    <td align="left" nowrap title="<?= @$Tpc10_numero ?>">
                        <strong>Solicitação: </strong>
                    </td>
                    <td align="left">
                        <?
                        $desabilita = false;
                        $arr_numero = array();
                        $arr_index  = array();

                        $where_liberado = "";
                        $selecionalibera = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "pc30_liberado"));
                        if ($clpcparam->numrows > 0) {
                            db_fieldsmemory($selecionalibera, 0);
                            if ($pc30_liberado == 'f') {
                                $where_liberado = " and pc11_liberado='t' ";
                            }
                        }
                        $sWhereSolicitaAnulada = " not exists (select 1 from solicitaanulada where pc67_solicita = pc10_numero) ";
                        $datausu = date("Y-m-d", db_getsession('DB_datausu'));
                        $sql_solicita = $clsolicitem->sql_record($clsolicitem->sql_query_pcmater(null, "distinct pc10_numero,pc10_data,pc10_resumo,descrdepto", "pc10_numero desc", "pc81_solicitem is null $where_liberado and pc10_correto='t' and {$sWhereSolicitaAnulada} and pc10_solicitacaotipo in(1,2) and pc10_data <= '$datausu'"));
                        for ($i = 0; $i < $clsolicitem->numrows; $i++) {

                            db_fieldsmemory($sql_solicita, $i, true);
                            $arr_numero[$pc10_numero] = $pc10_numero;
                            $arr_index[$pc10_numero]  = $i;
                            $arr_data = explode("/", $pc10_data);

                            if ($i == 0) {
                                $pc10_data_dia = $arr_data[0];
                                $pc10_data_mes = $arr_data[1];
                                $pc10_data_ano = $arr_data[2];
                            }
                        }
                        if ($clsolicitem->numrows > 0) {
                            db_fieldsmemory($sql_solicita, 0, true);
                        } else {
                            $desabilita = true;
                        }
                        if (isset($cod) && $cod != "" && isset($arr_index[$cod])) {

                            $pc10_numero = $cod;
                            $val = true;
                        }
                        db_select('pc10_numero', $arr_numero, true, 1, "onchange='js_mudasolicita();'");
                        if ($val == true) {
                            echo "<script>
                        var_obj = document.getElementById('pc10_numero').length;
                  for(i=0;i<var_obj;i++){
                    if(document.getElementById('pc10_numero').options[i].value==$cod){
                      document.getElementById('pc10_numero').options[i].selected = true;
                    }
                  }
                </script>";
                            db_fieldsmemory($sql_solicita, $arr_index[$cod]);
                            $arr_data = explode("-", $pc10_data);

                            $pc10_data_dia = $arr_data[2];
                            $pc10_data_mes = $arr_data[1];
                            $pc10_data_ano = $arr_data[0];
                        }
                        $result_pcproc = $clpcproc->sql_record('select last_value+1 as pc80_codproc from pcproc_pc80_codproc_seq');
                        ?>
                    </td>
                    <td align="left" nowrap title="<?= @$Tpc80_codproc ?>">
                        <strong>Processo de Compra: </strong>
                    </td>
                    <td align="left" nowrap>
                        <?
                        db_input('pc80_codproc', 8, $Ipc80_codproc, true, 'text', 3);
                        ?>

                        <b>Data: </b>
                        <?php

                        $iDia = date("d", db_getsession("DB_datausu"));
                        $iMes = date("m", db_getsession("DB_datausu"));
                        $iAno = date("Y", db_getsession("DB_datausu"));

                        db_inputdata('pc80_data', $iDia, $iMes, $iAno, true, 'text', 1, "");

                        ?>

                    </td>
                </tr>
                <tr>
                    <td align="left" nowrap title="<?php echo $Tpc10_data; ?>">
                        <label class="bold" for="pc10_data" id="lbl_pc10_data">Data da Solicitação:</label>
                    </td>
                    <td align="left" nowrap>
                        <?
                        db_inputdata('pc10_data', @$pc10_data_dia, @$pc10_data_mes, @$pc10_data_ano, true, 'text', 3);
                        ?>
                    </td>
                    <td align="left" nowrap title="<?= @$Tdescrdepto ?>">
                        <strong>Departamento: </strong>
                    </td>
                    <td align="left" nowrap>
                        <?
                        db_input('descrdepto', 40, $Idescrdepto, true, 'text', 3);
                        ?>
                    </td>
                </tr>
                <tr>
                <td align="left" style="display: none;">
                    <strong>Situação: </strong>
                </td>
                    <td>
                        <?php

                        $aOpcoesSituacao = array(
                            2 => 'Autorizado'
                        );
                        db_select('pc80_situacao', $aOpcoesSituacao, true, '','style="display: none;"');
                        ?>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td align="left">
                        <label class="bold" for="pc80_tipoprocesso" id="lbl_pc80_tipoprocesso"><?php echo $Spc80_tipoprocesso; ?>:</label>
                    </td>
                    <td>
                        <?php

                        $aTipos = array(
                            1 => 'Item',
                            2 => 'Lote'
                        );

                        db_select('pc80_tipoprocesso', $aTipos, true, '', 'style="width:50%"');
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <label class="bold">Critério de Adjudicação:</label>
                    </td>
                    <td>
                        <?php

                        $aCriterios = array(
                            '' => 'Selecione',
                            3 => 'Outros',
                            1 => 'Desconto sobre tabela',
                            2 => 'Menor taxa ou percentual'
                        );

                        db_select('pc80_criterioadjudicacao', $aCriterios, true, '', 'style="width:50%"');
                        ?>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td>
                        <label class="bold">Contratação Direta:</label>
                    </td>
                    <td>
                        <?php
                        $aDispensa = array(
                            '' => 'Selecione',
                            't' => 'Sim',
                            'f' => 'Não',
                        );

                        db_select('pc80_dispvalor', $aDispensa, true, '', 'onChange=js_verificadispensa();');
                        ?>
                    </td>
                </tr>
                <tr id="dispensaporvalor1" style="display:none">
                    <td>
                        <label class="bold">Nº da Dispensa:</label>
                    </td>
                    <td>
                        <?php
                        $resultUltimaDispensa = $clpcproc->sql_record($clpcproc->sql_query(null, "max(pc80_numdispensa) + 1  AS pc80_numdispensa", null, "instit = " . db_getsession('DB_instit')));
                        db_fieldsmemory($resultUltimaDispensa, 0);

                        db_input('pc80_numdispensa', 40, $Ipc80_numdispensa, true, 'text', $db_opcao);
                        ?>
                    </td>
                </tr>
                <tr id="dispensaporvalor2" style="display:none">
                    <td>
                        <label class="bold">Orc. Sigiloso:</label>
                    </td>
                    <td>
                        <?php
                        $aOrc = array(
                            '' => 'Selecione',
                            't' => 'Sim',
                            'f' => 'Não',
                        );

                        db_select('pc80_orcsigiloso', $aOrc, true, '', 'style="width:50%"');
                        ?>
                    </td>
                </tr>
                <tr id="dispensaporvalor4" style="display:none">
                    <td>
                        <label class="bold">Subcontratação:</label>
                    </td>
                    <td>
                        <?php
                        $aSub = array(
                            '' => 'Selecione',
                            't' => 'Sim',
                            'f' => 'Não',
                        );

                        db_select('pc80_subcontratacao', $aSub, true, '', 'style="width:50%"');
                        ?>
                    </td>
                </tr>
                <tr id="categoriaprocesso" style="display:none">
                    <td>
                        <strong>Categoria do Processo:</strong>
                    </td>
                    <td>
                        <?
                        $apc80_categoriaprocesso = array(
                            "0" => "Selecione",
                            "1" => "1- Cessão",
                            "2" => "2- Compras",
                            "3" => "3- Informática (TIC)",
                            "4" => "4- Internacional",
                            "5" => "5- Locação Imóveis",
                            "6" => "6- Mão de Obra",
                            "7" => "7- Obras",
                            "8" => "8- Serviços",
                            "9" => "9- Serviços de Engenharia",
                            "10" => "10- Serviços de Saúde"
                        );
                        db_select("pc80_categoriaprocesso", $apc80_categoriaprocesso, true, $db_opcao, '');
                        ?>
                    </td>
                </tr>

                <tr id="dispensaporvalor5" style="display:none">
                    <td style="width: 158px">
                        <label class="bold">Modalidade de Contratação:</label>
                    </td>
                    <td>
                        <?php
                        $aModalidade = array(
                            '0' => 'Selecione',
                            '8' => 'Dispensa sem Disputa',
                            '9' => 'Inexigibilidade',
                        );

                        db_select('pc80_modalidadecontratacao', $aModalidade, true, 1,"onchange='js_consultaamparolegal(this.value);'");
                        ?>
                    </td>
                </tr>

                <tr id="dispensaporvalor3" style="display:none">
                    <td>
                        <label class="bold">Amparo Legal:</label>
                    </td>
                    <td>
                        <?php
                        $tipo[0] = 'Selecione';
                        db_select('pc80_amparolegal', $tipo, true, '', 'style="width:100%"');
                        ?>
                    </td>
                </tr>
                <tr id="dispensaporvalor6" style="display:none">
                    <td>
                        <label class="bold">Critério de Julgamento:</label>
                    </td>
                    <td>
                        <?php
                        $aCriteriojulgamento = array(
                            '0' => 'Selecione',
                            '1' => 'Menor preço',
                            '2' => 'Maior desconto',
                            '5' => 'Maior lance',
                            '7' => 'Não se aplica'
                        );
                        db_select('pc80_criteriojulgamento', $aCriteriojulgamento, true, '', 'style="width:100%"');
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <fieldset>
                            <legend>Dados Complementares:</legend>
                            <?php
                            db_textarea('pc80_dadoscomplementares', 5, 70, $Ipc80_dadoscomplementares, true, 'text', 1, "", "", "", 735);
                            ?>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td title="<?= @$Tpc10_resumo ?>" colspan="4">
                        <fieldset>
                            <legend>Resumo do Processo de Compras:</legend>
                            <?
                            db_textarea('pc10_resumo', 5, 70, $Ipc10_resumo, true, 'text', 1, "", "", "", 735);
                            ?>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </table>
    </fieldset>

    <table border="0" align="center" width="800">
        <tr align="center">
            <td nowrap colspan="10">
                <fieldset>
                    <legend><strong>Itens da Solicitação</strong></legend>
                    <iframe name="iframe_solicitem" id="solicitem" marginwidth="0" marginheight="0" frameborder="0" src="com1_gerasolicitem.php" width="100%"></iframe>
                </fieldset>
            </td>
        </tr>
    </table>

    <?php
    db_input('valores', 50, 0, true, 'hidden', 3);
    db_input('importa', 50, 0, true, 'hidden', 3);
    ?>

    <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>

    <?php

    /**
     * Buscamos o parâmetro pc30_liberado
     * Caso este parâmetro esteja TRUE, o usuário pode cadastrar pendências para uma solicitação de compras, do contrários
     * o botão que permite o cadastro não irá aparecer.
     */
    $sSqlLiberadoPcParam = $clpcparam->sql_query_file(db_getsession('DB_instit'), "pc30_liberado");
    $rsPcParam           = $clpcparam->sql_record($sSqlLiberadoPcParam);
    $lDadoLiberado       = false;
    if ($clpcparam->numrows > 0) {
        $lDadoLiberado = db_utils::fieldsMemory($rsPcParam, 0)->pc30_liberado == "f" ? true : false;
    }

    if ($lDadoLiberado) {
        echo "<input type='button' name='btnPendenciaSolicitacao' id='btnPendenciaSolicitacao' value='Pendência' onclick='js_openWindowPendencia();'>";
    }


    $result_pcproc = $clpcproc->sql_record($clpcproc->sql_query_file(null, "pc80_codproc"));
    $enviadados = false;
    if ($clpcproc->numrows > 0) {
        $enviadados = true;
        echo '<input name="juntaropcao" type="button" id="juntaropcao" value="Juntar" ' . ($db_botao == false ? "disabled" : "") . ' onclick="js_juntaropcao();">&nbsp;&nbsp;&nbsp;&nbsp;';
        echo "<script>
              function js_juntaropcao(){
    	    numele = iframe_solicitem.document.form1.length;
    	    cont = 0;
    	    imp  = 0;
    	    for(i=0;i<numele;i++){
    	      if(iframe_solicitem.document.form1.elements[i].type=='checkbox'){
    		  if(iframe_solicitem.document.form1.elements[i].checked==true){
    		      elemento = iframe_solicitem.document.form1.elements[i].name;
    		      arr_chk  = elemento.split('_');
    		      if (arr_chk.length == 3){
    		           cont++;
    		      } else {
    			   imp++;
    		      }
    		  }
    	      }
    	    }
    	    if (cont == 0 && imp == 0){
    	         alert('Usuário:\\n\\nSelecione um item para prosseguir.\\n\\nAdministrador:');
    	    } else {
     	         if(cont != numele || imp != numele){
    	             if (cont > 0){
    	                  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcproc','func_pcproc.php?funcao_js=parent.js_preenchepesquisa|pc80_codproc','Pesquisa',true,'20');
                         }
    	             if (imp > 0){
    	                  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcproc','func_pcproc.php?funcao_js=parent.js_preenchepesquisa|pc80_codproc&imp=true','Pesquisa',true,'20');
    	             }
    	         }
    	    }
    	  }
    	  function js_preenchepesquisa(chave){
    	    var opcao = document.createElement('input');
    	    opcao.setAttribute('type','hidden');
    	    opcao.setAttribute('name','juntar');
    	    opcao.setAttribute('value','true');
    	    document.form1.appendChild(opcao);
    	    document.form1.juntar.value=chave;
    	    db_iframe_pcproc.hide();
                document.form1.submit();
    	  }
            </script>
    	";
    }
    ?>
</form>
<script>
    /* Inclusão dos campos referente a solicitação caso a tela
     seja carregada apartir da rotina de solicitação de compras
    */
    numero = <?php echo $pc10_numero; ?>;
    data = ' <?php echo $data; ?> ';
    descrdepto = ' <?php echo $descrdepto; ?> ';

    const select = document.querySelector('#pc10_numero');
    select.options[select.options.length] = new Option(numero, numero);
    if (data.trim.length > 0) {
        document.getElementById('pc10_data').value = data;
    }
    document.getElementById('descrdepto').value = descrdepto;


    function js_mudasolicita() {
        location.href = 'com1_pcproc001.php?cod=' + document.form1.pc10_numero.value;

    }
    if (document.form1.pc10_numero.value != "") {
        CurrentWindow.corpo.iframe_solicitem.location.href = 'com1_gerasolicitem.php?solicita=' + document.form1.pc10_numero.value + '&pc10_numero=' + document.form1.pc10_numero.value;
    }
    <?
    if ($desabilita == true) {
        echo "
      numele = CurrentWindow.corpo.document.form1.length;
      cont = 0;
      for(i=0;i<numele;i++){
        if(CurrentWindow.corpo.document.form1.elements[i].type=='submit' || CurrentWindow.corpo.document.form1.elements[i].type=='button'){
          CurrentWindow.corpo.document.form1.elements[i].disabled=true;
        }
      }
      ";
    } else {
        echo "
      numele = CurrentWindow.corpo.document.form1.length;
      cont = 0;
      for(i=0;i<numele;i++){
        if(CurrentWindow.corpo.document.form1.elements[i].type=='submit' || CurrentWindow.corpo.document.form1.elements[i].type=='button'){
          CurrentWindow.corpo.document.form1.elements[i].disabled=false;
        }
      }
      ";
    }
    ?>

    document.getElementById('pc10_numero').style.width = '50%';
    document.getElementById('pc10_data').style.width = '50%';

    /**
     * Função que abre a janela para cadastro de pendência para uma solicitação de compras.
     */
    function js_openWindowPendencia() {

        var iCodigoSolicitacao = $F('pc10_numero');
        // a flag 'cadastroprocessodecompras' foi adiciona para indicar ao programa que essa é a origem da opreração
        var sUrlPendencia = "com4_cadpendencias002.php?pc10_numero=" + iCodigoSolicitacao + "&cadastroprocessodecompras=true";
        var sTituloJanelaIframe = "Cadastro de Pendência da Solicitação: " + iCodigoSolicitacao;
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_cadpendencia', sUrlPendencia, sTituloJanelaIframe, true);
    }

    function js_verificadispensa() {
        if ($F('pc80_dispvalor') === "t") {
            $('dispensaporvalor1').style.display = '';
            $('dispensaporvalor2').style.display = '';
            $('dispensaporvalor3').style.display = '';
            $('dispensaporvalor4').style.display = '';
            $('dispensaporvalor5').style.display = '';
            $('dispensaporvalor6').style.display = '';
            $('categoriaprocesso').style.display = '';
        } else {
            $('dispensaporvalor1').style.display = 'none';
            $('dispensaporvalor2').style.display = 'none';
            $('dispensaporvalor3').style.display = 'none';
            $('dispensaporvalor4').style.display = 'none';
            $('dispensaporvalor5').style.display = 'none';
            $('dispensaporvalor6').style.display = 'none';
            $('categoriaprocesso').style.display = 'none';
        }
    }

    function js_consultaamparolegal(param){

        let modalidade = 0;

        if(param === '8'){
           $('pc80_criteriojulgamento').value = 0;
           modalidade = 101;
        }else{
           $('pc80_criteriojulgamento').value = 7;
           modalidade = 100;
        }

        const oParam = {};
        oParam.exec       = 'buscarAparolegal';
        oParam.modalidade = modalidade;

        const oAjax = new Ajax.Request(
            'com1_processocomprasutils.RPC.php',
            {
                parameters: 'json=' + Object.toJSON(oParam),
                asynchronous: false,
                method: 'post',
                onComplete: js_retornoAmparolegal
            });
    }

    function js_retornoAmparolegal(oAjax){
        const oRetorno = eval('(' + oAjax.responseText + ")");

        let listaamparolegal = document.getElementById('pc80_amparolegal').options;

        for (let x = listaamparolegal.length; x > 0; x --) {

            listaamparolegal.remove(x);
        }

        oRetorno.amparolegal.forEach(function (amparo, iseq){
            listaamparolegal.add(new Option(amparo.l212_lei.urlDecode(), amparo.l212_codigo));
        });
    }
</script>
