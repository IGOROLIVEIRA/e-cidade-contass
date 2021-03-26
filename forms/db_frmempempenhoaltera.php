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
$clempempenho->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("nome");
$clrotulo->label("e60_codemp");
$clrotulo->label("pc50_descr");
$clrotulo->label("e60_codcom");
$clrotulo->label("e63_codhist");
$clrotulo->label("e44_tipo");
$clrotulo->label("c58_descr");
$clrotulo->label("e60_convenio");
$clrotulo->label("e60_numconvenio");
$clrotulo->label("e60_dataconvenio");
$clrotulo->label("e60_datasentenca");

?>
<form name="form1" method="post" action="">
    <center>
        <table border="0">
            <tr>
                <td nowrap title="<?=@$Te60_codemp?>">
                    <?=@$Le60_codemp?>
                </td>
                <td>
                    <?
                    db_input('e60_numemp',10,'',true,'hidden',3);
                    db_input('e60_codemp',10,$Ie60_codemp,true,'text',3);
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Te60_numcgm?>">
                    <?=$Le60_numcgm?>
                </td>
                <td>
                    <?
                    db_input('e60_numcgm',10,$Ie60_numcgm,true,'text',3);
                    db_input('z01_nome',40,$Iz01_nome,true,'text',3,'');
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Te60_codcom?>">
                    <?=$Le60_codcom?>
                </td>
                <td>
                    <?
                    db_input('e60_codcom',10,$Ie60_codcom,true,'text',3);
                    db_input('pc50_descr',40,$Ipc50_descr,true,'text',3,'');

                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Te60_tipol?>">
                    <?=@$Le60_tipol?>
                </td>
                <td>
                    <?
                    if(isset($e60_codcom)){
                        $result=$clcflicita->sql_record($clcflicita->sql_query_file(null,"l03_tipo,l03_descr",'',"l03_codcom=$e60_codcom"));
                        if($clcflicita->numrows>0){
                            db_selectrecord("e60_tipol",$result,true,1,"","","");
                            $dop=$db_opcao;
                        }else{
                            $e60_tipol='';
                            $e60_numerol='';
                            db_input('e60_tipol',10,$Ie60_tipol,true,'text',3);
                            $dop='3';
                        }
                        ?>
                        <?=@$Le60_numerol?>
                        <?
                        db_input('e60_numerol',10,$Ie60_numerol,true,'text',$dop);
                        ?>
                        <strong>Modalidade:</strong>
                        <?
                        db_input('e54_nummodalidade', 8, $e54_nummodalidade, true, 'text', 3, "");

                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Te60_codtipo?>">
                    <?=$Le60_codtipo?>
                </td>
                <td>
                    <?
                    $result=$clemptipo->sql_record($clemptipo->sql_query_file(null,"e41_codtipo,e41_descr"));
                    db_selectrecord("e60_codtipo",$result,true,$db_opcao);

                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Te63_codhist?>">
                    <?=$Le63_codhist?>
                </td>
                <td>
                    <?

                    $result=$clemphist->sql_record($clemphist->sql_query_file(null,"e40_codhist,e40_descr"));
                    db_selectrecord("e63_codhist",$result,true,1,"","","","Nenhum");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Te44_tipo?>">
                    <?=$Le44_tipo?>
                </td>
                <td>
                    <?
                    $result=$clempprestatip->sql_record($clempprestatip->sql_query_file(null,"e44_tipo as tipo,e44_descr,e44_obriga","e44_obriga "));
                    $numrows =  $clempprestatip->numrows;
                    $arr = array();
                    for($i=0; $i<$numrows; $i++){
                        db_fieldsmemory($result,$i);
                        if($e44_obriga == 0 && empty($e44_tipo)){
                            $e44_tipo = $tipo;
                        }
                        $arr[$tipo] = $e44_descr;
                    }
                    db_select("e44_tipo",$arr,true,3);

                    ?>
                </td>
            </tr>

            <?
            if (isset($e60_numemp)) {

                $sql = "select pagordem.* from pagordem inner join pagordemdesconto on e34_codord = e50_codord
	  													where e50_numemp = $e60_numemp";
                //die($sql);
                $result = $clpagordem->sql_record($sql);
                $ldesconto = false;
                if ($clpagordem->numrows > 0) {
                    $ldesconto = true;
                }
            }
            if(isset($e60_vlrliq) && $e60_vlrliq == 0 && !$ldesconto && $e60_anousu >= db_getsession("DB_anousu")){
                ?>
                <tr>
                    <td nowrap title="Desdobramentos">
                        <b><?="Desdobramento:"?></b>
                    </td>
                    <td>
                        <?
                        $result = $clempempaut->sql_record($clempempaut->sql_query(null,"e61_autori","","e61_numemp = $e60_numemp"));
                        if($clempempaut->numrows > 0){
                            $oResult = db_utils::fieldsMemory($result,0);
                            $e54_autori = $oResult->e61_autori;
                            $anoUsu = db_getsession("DB_anousu");
                            $sWhere = "e56_autori = ".$e54_autori." and e56_anousu = ".$anoUsu;
                            $result = $clempautidot->sql_record($clempautidot->sql_query_dotacao(null,"e56_coddot",null,$sWhere));

                            if($clempautidot->numrows > 0){
                                $oResult = db_utils::fieldsMemory($result,0);
                                $result = $clorcdotacao->sql_record($clorcdotacao->sql_query( $anoUsu,$oResult->e56_coddot,"o56_elemento,o56_codele"));
                                if ($clorcdotacao->numrows > 0) {

                                    $oResult = db_utils::fieldsMemory($result,0);
                                    $oResult->estrutural = criaContaMae($oResult->o56_elemento."00");
                                    $sWhere = "o56_elemento like '$oResult->estrutural%' and o56_codele <> $oResult->o56_codele and o56_anousu = $anoUsu";
                                    $sSql = "select distinct o56_codele,o56_elemento,o56_descr
											  from empempitem
											        inner join pcmater on pcmater.pc01_codmater    = empempitem.e62_item
											        inner join pcmaterele on pcmater.pc01_codmater = pcmaterele.pc07_codmater
											        left join orcelemento on orcelemento.o56_codele = pcmaterele.pc07_codele
											                              and orcelemento.o56_anousu = $anoUsu
											    where o56_elemento like '$oResult->estrutural%'
											    and e62_numemp = $e60_numemp and o56_anousu = $anoUsu";
                                    $result = $clorcelemento->sql_record($sSql);

                                    $oResult = db_utils::getCollectionByRecord($result);

                                    $numrows =  $clorcelemento->numrows;
                                    $aEle = array();

                                    foreach ($oResult as $oRow){
                                        $aEle[$oRow->o56_codele] = $oRow->o56_descr;
                                    }
                                    //die($clempautitem->sql_query_autoriza (null,null,"e55_codele",null,"e55_autori = $e54_autori"));
                                    $result = $clempelemento->sql_record($clempelemento->sql_query_file($e60_numemp,null,"e64_codele"));
                                    if($clempelemento->numrows > 0){
                                        $oResult = db_utils::fieldsMemory($result,0);
                                    }
                                    if(!isset($e56_codele)){
                                        $e56_codele = $oResult->e64_codele;
                                    }
                                    $e64_codele = $e56_codele;
                                    db_input('e64_codele',10,0,true,'hidden',3);
                                    db_select("e56_codele",$aEle,true,1);
                                }
                            }
                        }else{
                            $aEle = array();
                            $e56_codele = "";
                            db_select("e56_codele",$aEle,true,1);
                        }
                        ?>
                    </td>
                </tr>
                <?
            }else{
                if(isset($e60_vlrliq) && $e60_vlrliq != 0){
                    $mensagem = "Você não pode alterar o desdobramento deste empenho porque este já possui valor liquidado. Se realmente for necessária a alteração, anule todas as liquidações";
                }else if(isset($ldesconto) && $ldesconto){
                    $mensagem = "Este empenho teve uma operação de desconto e isto inviabiliza a substituição do desdobramento.";
                }

            }
            ?>
            <tr>
                <td nowrap title="Tipos de despesa">
                    <strong>Tipos de despesa :</strong>
                </td>
                <td>
                    <?
                    $arr  = array('0'=>'Não se aplica','1'=>'Executivo','2'=>'Legislativo');
                    db_select("e60_tipodespesa", $arr, true, 1);
                    ?>
                </td>
            </tr>
            <tr id="trFinalidadeFundeb" style="display: none;">
                <td><b>Finalidade:</b></td>
                <td>
                    <?php
                    $oDaoFinalidadeFundeb = db_utils::getDao('finalidadepagamentofundeb');
                    $sSqlFinalidadeFundeb = $oDaoFinalidadeFundeb->sql_query_file(null, "e151_codigo, e151_descricao", "e151_codigo");
                    $rsBuscaFinalidadeFundeb = $oDaoFinalidadeFundeb->sql_record($sSqlFinalidadeFundeb);
                    db_selectrecord('e151_codigo', $rsBuscaFinalidadeFundeb, true, 1);
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Te60_destin?>">
                    <?=@$Le60_destin?>
                </td>
                <td>
                    <?
                    db_input('e60_destin',40,$Ie60_destin,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>


            <tr>
                <td nowrap title="Gestor do Empenho">
                    <?php
                    db_ancora('Gestor do Empenho:', "js_pesquisae54_gestaut(true);", $db_opcao);
                    ?>
                </td>
                <td>
                    <?php
                    db_input("e54_gestaut", 10, $Ie54_gestaut, true, "text", 3);
                    db_input("e54_autori", 10, $Ie54_autori, true, "hidden", 3);
                    db_input("e54_nomedodepartamento", 50, 0, true, "text", 3);

                    $iCodDepartamentoAtual = empty($e54_gestaut) ? db_getsession('DB_coddepto') : $e54_gestaut;
                    $sNomDepartamentoAtual = db_utils::fieldsMemory(db_query(" SELECT descrdepto FROM db_depart WHERE coddepto = {$iCodDepartamentoAtual} "), 0)->descrdepto;
                    ?>
                </td>
            </tr>


            <tr>
                <td nowrap title="<?=@$Te60_resumo?>" colspan="2">
                    <fieldset>
                        <legend><b><?=@$Le60_resumo?></b></legend>
                        <?
                        db_textarea('e60_resumo',8,90,$Ie60_resumo,true,'text',$db_opcao,"")
                        ?>
                    </fieldset>
                </td>
            </tr>
            <?
            $anousu = db_getsession("DB_anousu");

            if ($anousu > 2007){
                ?>
                <tr>
                    <td nowrap title="<?=@$Te60_concarpeculiar?>"><?
                        db_ancora(@$Le60_concarpeculiar,"js_pesquisae60_concarpeculiar(true);",$db_opcao);
                        ?></td>
                    <td>
                        <?
                        db_input("e60_concarpeculiar",10,$Ie60_concarpeculiar,true,"text",$db_opcao,"onChange='js_pesquisae60_concarpeculiar(false);'");
                        db_input("c58_descr",50,0,true,"text",3);
                        ?>
                    </td>
                </tr>
                <?
            } else {
                $e60_concarpeculiar = 0;
                db_input("e60_concarpeculiar",10,0,true,"hidden",3,"");

            }
            if (isset($e60_numemp) && isset($e30_notaliquidacao) && $e30_notaliquidacao != '') {
                $rsNotaLiquidacao  = $oDaoEmpenhoNl->sql_record(
                    $oDaoEmpenhoNl->sql_query_file(null,"e68_numemp","","e68_numemp = {$e60_numemp}"));
                if ($oDaoEmpenhoNl->numrows == 0) {
                    ?>
                    <tr>
                        <td nowrap title="Nota de liquidação">
                            <b>Nota de liquidação:</b>
                        </td>
                        <td>
                            <?
                            $aNota = array("s"=>"Sim","n" => "NÃO");
                            db_select("e68_numemp",$aNota,true,1);
                            ?>
                        </td>
                    </tr>
                    <?
                }
            }
            ?>
            <!--
            <tr>
                <td nowrap title="<?//=@$Te60_convenio?>">
                    <?//=@$Le60_convenio?>
                </td>
                <td>
                    <?
            //$aConvenio = array('2' => 'Não','1' => 'Sim');
            //db_select('e60_convenio', $aConvenio, true, $db_opcao,"");
            ?>
                </td>
            </tr>
            -->
            <tr>
                <td nowrap title="Código c206_sequencial">
                    <? db_ancora("Convênio","js_pesquisae60_numconvenio(true);",$db_opcao); ?>
                </td>
                <td>
                    <?
                    db_input('e60_numconvenio',11,$Ie60_numconvenio,true,'text',$db_opcao,"onChange='js_pesquisae60_numconvenio(false);'");
                    db_input("c206_objetoconvenio",50,0,true,"text",3);
                    ?>
                </td>
            </tr>
            <!--
            <tr>
                <td nowrap title="<?//=@$Te60_dataconvenio?>">
                    <?//=@$Le60_dataconvenio?>
                </td>
                <td>
                    <?
            //db_inputData('e60_dataconvenio',@$e60_dataconvenio_dia, @$e60_dataconvenio_mes,@$e60_dataconvenio_ano, true, 'text', $db_opcao);
            ?>
                </td>
            </tr>-->
            <tr>
                <td nowrap title="<?=@$Te60_datasentenca?>">
                    <?=@$Le60_datasentenca?>
                </td>
                <td>
                    <?
                    db_inputData('e60_datasentenca',@$e60_datasentenca_dia, @$e60_datasentenca_mes,@$e60_datasentenca_ano, true, 'text', $db_opcao);
                    ?>
                </td>
            </tr>

        </table>
    </center>
    <input name="alterar" type="submit" id="db_opcao" value="Alterar" <?=($db_botao==false?"disabled":"")?> >

    <input type="button" id="btnLancarCotasMensais" value="Manutenção de Cotas Mensais" onclick="manutencaoCotasMensais()" />

    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar empenhos" onclick="js_pesquisa();" >
</form>

<style>
    #e60_tipodespesa{ width: 140px; }#e60_codtipodescr{width: 342px}#e63_codhistdescr{width: 342px}#pc50_descr{width: 333px}#e44_tipo{width: 228px;}#e57_codhistdescr{width: 158px;}#e54_codtipodescr{width: 158px;}#e54_codtipo{width: 67px;}#e54_tipol{width: 67px;}#e54_tipoldescr{width: 158px;}#e54_codcom{width: 67px;}#z01_nome{width: 333px;}#e54_destin{width: 424px;}#e54_gestaut{width: 67px;}#e54_nomedodepartamento{width: 354px;}#ac16_resumoobjeto{width: 364px;}#e60_numconvenio{width: 83px;}#e54_resumo{width: 588px;}#e50_obs{width: 588px;}#e56_codele{width: 140px}
</style>


<script>

    /*===========================================
    =            pesquisa 54_gestaut            =
    ===========================================*/

    function js_pesquisae54_gestaut() {
        js_OpenJanelaIframe(
            '',
            'db_iframe_db_depart',
            'func_db_depart.php?funcao_js=parent.js_preenchepesquisae54_gestaut|coddepto|descrdepto',
            'Pesquisa',
            true,
            '0',
            '1'
        );
    }

    function js_preenchepesquisae54_gestaut(codigo, descricao) {

        if (codigo == '' || descricao == '') {
            document.form1.e54_gestaut.value = '';
            document.form1.e54_gestaut.value.focus();
            return;
        }

        document.form1.e54_gestaut.value = codigo;
        document.form1.e54_nomedodepartamento.value = descricao;

        db_iframe_db_depart.hide();

    }

    // executar a primeira vez
    document.form1.e54_gestaut.value = '<?= $iCodDepartamentoAtual ?>';
    document.form1.e54_nomedodepartamento.value = '<?= $sNomDepartamentoAtual ?>';

    /*=====  End of pesquisa 54_gestaut  ======*/


    function manutencaoCotasMensais () {

        oViewCotasMensais = new ViewCotasMensais('oViewCotasMensais', $F('e60_numemp'));
        oViewCotasMensais.setReadOnly(false);
        oViewCotasMensais.abrirJanela();
    }


    function js_pesquisae60_concarpeculiar(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('','db_iframe_concarpeculiar','func_concarpeculiar.php?funcao_js=parent.js_mostraconcarpeculiar1|c58_sequencial|c58_descr','Pesquisa',true,'0');
        }else{
            if(document.form1.e60_concarpeculiar.value != ''){
                js_OpenJanelaIframe('','db_iframe_concarpeculiar','func_concarpeculiar.php?pesquisa_chave='+document.form1.e60_concarpeculiar.value+'&funcao_js=parent.js_mostraconcarpeculiar','Pesquisa',false,'0');
            }else{
                document.form1.c58_descr.value = '';
            }
        }
    }
    function js_mostraconcarpeculiar(chave,erro){
        document.form1.c58_descr.value = chave;
        if(erro==true){
            document.form1.e60_concarpeculiar.focus();
            document.form1.e60_concarpeculiar.value = '';
        }
    }
    function js_mostraconcarpeculiar1(chave1,chave2){
        document.form1.e60_concarpeculiar.value = chave1;
        document.form1.c58_descr.value          = chave2;
        db_iframe_concarpeculiar.hide();
    }
    function js_pesquisa(){
        js_OpenJanelaIframe('','db_iframe_empempenho','func_empempenho.php?funcao_js=parent.js_preenchepesquisa|e60_numemp|e60_codemp|e60_anousu','Pesquisa',true,'0');
    }
    function js_preenchepesquisa(chave, chave2, ano){
        db_iframe_empempenho.hide();
        <?
        echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        ?>

        parent.document.formaba.alteracaoop.disabled=false;
        empenho = chave2+'/'+ano;
        CurrentWindow.corpo.iframe_alteracaoop.location.href='emp1_aba2ordempagamento002.php?pesquisa=1&empenho='+empenho;
    }

    /**
     * Ajustes no layout
     */
    $("e60_codtipo").style.width      = "15%";
    $("e63_codhist").style.width      = "15%";
    $("e60_codtipodescr").style.width = "84%";
    $("e63_codhistdescr").style.width = "84%";
    $("e44_tipo").style.width         = "100%";
    if ($("e56_codele")) {
        $("e56_codele").style.width       = "100%";
    }
    $("e60_destin").style.width       = "100%";
    $("e60_resumo").style.width       = "100%";



    function js_verificaFinalidadeEmpenho() {

        js_divCarregando("Aguarde, verificando recurso da dotação...", "msgBox");
        var oParam                = new Object();
        oParam.exec               = "getFinalidadePagamentoFundebEmpenho";
        oParam.iSequencialEmpenho = $F('e60_numemp');

        new Ajax.Request('emp4_empenhofinanceiro004.RPC.php',
            {method: 'post',
                parameters: 'json='+Object.toJSON(oParam),
                onComplete: function (oAjax) {

                    js_removeObj("msgBox");
                    var oRetorno = eval("("+oAjax.responseText+")");

                    if (!oRetorno.lPossuiFinalidadePagamentoFundeb) {

                        $('trFinalidadeFundeb').style.display = 'none';

                    } else {

                        $('trFinalidadeFundeb').style.display = '';
                        $("e151_codigo").style.width      = "15%";
                        $("e151_codigodescr").style.width = "84%";

                        if (oRetorno.oFinalidadePagamentoFundeb) {

                            $('e151_codigo').value = oRetorno.oFinalidadePagamentoFundeb.e151_codigo;
                            js_ProcCod_e151_codigo('e151_codigo','e151_codigodescr');
                        }
                    }

                }
            });
    }

    js_verificaFinalidadeEmpenho();

    function js_pesquisae60_numconvenio(mostra) {
        if(mostra==true){
            js_OpenJanelaIframe('','db_iframe_convconvenios','func_convconvenios.php?funcao_js=parent.js_mostrae60_numconvenio1|c206_sequencial|c206_objetoconvenio','Pesquisa',true,'0');
        } else {
            if(document.form1.e60_numconvenio.value != ''){
                js_OpenJanelaIframe('','db_iframe_convconvenios','func_convconvenios.php?pesquisa_chave='+document.form1.e60_numconvenio.value+'&funcao_js=parent.js_mostrae60_numconvenio','Pesquisa',false,'0');
            }else{
                document.form1.c206_objetoconvenio.value = '';
            }
        }
    }

    function js_mostrae60_numconvenio(chave,erro){
        document.form1.c206_objetoconvenio.value = chave;
        if(erro==true){
            document.form1.e60_numconvenio.focus();
            document.form1.e60_numconvenio.value = '';
        }
    }

    function js_mostrae60_numconvenio1(chave1,chave2){
        document.form1.e60_numconvenio.value     = chave1;
        document.form1.c206_objetoconvenio.value = chave2;
        db_iframe_convconvenios.hide();
    }

</script>
