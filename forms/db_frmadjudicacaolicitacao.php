<?php
//MODULO: licitacao
include("dbforms/db_classesgenericas.php");
$clhomologacaoadjudica->rotulo->label();

$cliframe_seleciona = new cl_iframe_seleciona;
$clpcprocitem       = new cl_pcprocitem;
$clrotulo           = new rotulocampo;

$clrotulo->label("l20_codigo");
?>
<form name="form1" method="post" action="">
    <table border="0">
        <tr>
            <td nowrap title="<?=@$Tl202_licitacao?>">
                <?
                db_ancora(@$Ll202_licitacao,"js_pesquisal202_licitacao(true);",$db_opcao);
                ?>
            </td>
            <td>
                <?
                db_input('l202_licitacao',10,$Il202_licitacao,true,'text',$db_opcao," onchange='js_pesquisal202_licitacao(false);'")
                ?>
                <?
                $pc50_descr = $pc50_descr ." ".$l20_numero;
                db_input('pc50_descr',40,$Ipc50_descr,true,'text',3,'')
                ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="<?=@$Tl202_dataadjudicacao?>">
                <?=@$Ll202_dataadjudicacao?>
            </td>
            <td>
                <?
                db_inputdata('l202_dataadjudicacao',@$l202_dataadjudicacao_dia,@$l202_dataadjudicacao_mes,@$l202_dataadjudicacao_ano,true,'text',$db_opcao,"")
                ?>
            </td>
        </tr>
    </table>
</form>
<script>
    <?php
    /**
     * ValidaFornecedor:
     * Quando for passado por URL o parametro validafornecedor, só irá retornar licitações que possuem fornecedores habilitados.
     * @see ocorrência 2278
     */
    ?>
    function js_pesquisal202_licitacao(mostra){
        let opcao = "<?= $db_opcao?>";

        if(mostra==true){
            js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_lichomologa.php?situacao='+(opcao == '1' ? '1' : '10')+
                '&funcao_js=parent.js_mostraliclicita1|l20_codigo|pc50_descr|l20_numero&validafornecedor=1','Pesquisa',true);
        }else{
            if(document.form1.l202_licitacao.value != ''){
                js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_lichomologa.php?situacao='+(opcao == '1' ? '1' : '10')+
                    '&pesquisa_chave='+document.form1.l202_licitacao.value+'&funcao_js=parent.js_mostraliclicita&validafornecedor=1','Pesquisa',false);
            }else{
                document.form1.l202_licitacao.value = '';
                document.form1.pc50_descr.value = '';
                if(document.getElementById('processar')){
                    document.getElementById('processar').disabled = true;
                }else{
                    document.getElementById('db_opcao').disabled = true;
                }
            }
        }
    }
    function js_mostraliclicita(chave,erro){

        document.form1.pc50_descr.value = chave;
        if(erro==true){
            iLicitacao = '';
            document.form1.l202_licitacao.focus();
            document.form1.l202_licitacao.value = '';
        }else{
            iLicitacao = document.form1.l202_licitacao.value;
            if(document.getElementById('processar')){
                document.getElementById('processar').disabled = false;
            }else{
                document.getElementById('db_opcao').disabled = false;
            }
        }
    }
    /**
     * Função alterada para receber o parametro da numeração da modalidade.
     * Acrescentado o parametro chave3 que recebe o l20_numero vindo da linha 263.
     * Solicitado por danilo@contass e deborah@contass
     */
    function js_mostraliclicita1(chave1,chave2,chave3){
        iLicitacao = chave1;

        document.form1.l202_licitacao.value = chave1;
        document.form1.pc50_descr.value = chave2+' '+chave3;
        if(document.getElementById('processar')){
            document.getElementById('processar').disabled = false;
        }else{
            document.getElementById('db_opcao').disabled = false;
        }
        db_iframe_liclicita.hide();
    }
    function js_pesquisa(homologacao=false){
        if(!homologacao){
            js_OpenJanelaIframe('top.corpo','db_iframe_homologacaoadjudica','func_homologacaoadjudica.php?validadispensa=true&situacao=1&funcao_js=parent.js_preenchepesquisa|l202_sequencial','Pesquisa',true);
        }else{
            js_OpenJanelaIframe('top.corpo','db_iframe_homologacaoadjudica','func_homologacaoadjudica.php?validadispensa=true&situacao=10&funcao_js=parent.js_preenchepesquisa|l202_sequencial','Pesquisa',true);
        }
    }
    function js_preenchepesquisa(chave){
        db_iframe_homologacaoadjudica.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }
</script>
