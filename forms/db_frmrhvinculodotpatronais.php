<?
//MODULO: pessoal
$clrhvinculodotpatronais->rotulo->label();

$aMeses = array(
  "1" => "Janeiro",
  "2" => "Fevereiro",
  "3" => "Março",
  "4" => "Abril",
  "5" => "Maio",
  "6" => "Junho",
  "7" => "Julho",
  "8" => "Agosto",
  "9" => "Setembro",
  "10" => "Outubro",
  "11" => "Novembro",
  "12" => "Dezembro",
  "13" => "13º Salário"
);

?>

<form name="form1" method="post" action="">
<center>
<fieldset style="width: 500px;">
    <legend style="font-weight: bold;">De/Para Dotações Patronais</legend>
    <table width="100%">
        <tr>
            <td colspan='4' style="text-align: center" nowrap title="<?=@$Trh171_mes?>">
                <?=@$Lrh171_mes?>
                <? db_select('rh171_mes', $aMeses, true, $db_opcao_orig) ?>
                <input name="rh171_sequencial" type="hidden" value="<?=@$rh171_sequencial?>">
            </td>
        </tr>
        <tr>
            <td colspan='2' style="text-align: center"><span><b>Dotação Original</b></span></td>
            <td colspan='2' style="text-align: center"><span><b>Nova Dotação</b></span></td>
        </tr>
        <tr>
            <td>
                <? db_ancora("Dotação: ","js_pesquisa_coddot(true, 1);", $db_opcao); ?>
            </td>
            <td>
                <? db_input("dotacao_orig",8,"",true,"text",$db_opcao, "onchange='js_pesquisa_coddot(false, 1);'"); ?>
            </td>
            <td>
                <? db_ancora("Dotação: ","js_pesquisa_coddot(true, 2);", $db_opcao); ?>
            </td>
            <td>
                <? db_input("dotacao_nov",8,"",true,"text",$db_opcao, "onchange='js_pesquisa_coddot(false, 2);'"); ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="<?=@$Trh171_orgaoorig?>">
                <?=db_ancora($Lrh171_orgaoorig, "js_pesquisaOrgaoOrig(true)", $db_opcao_orig);?>
            </td>
            <td nowrap> 
                <?
                    db_input("rh171_orgaoorig", 8, $Irh171_orgaoorig, true, 'text', $db_opcao_orig, "onchange=js_pesquisaOrgaoOrig(false);");
                    db_input('o40_descr_orig', 35, '', true, 'text', 3);
                ?>
            </td>
            <td nowrap title="<?=@$Trh171_orgaonov?>">
                <?=db_ancora($Lrh171_orgaonov, "js_pesquisaOrgaoNov(true)", 3);?>
            </td>
            <td nowrap> 
                <?
                    db_input("rh171_orgaonov", 8, $Irh171_orgaonov, true, 'text', 3, "onchange=js_pesquisaOrgaoNov(false);");
                    db_input('o40_descr_nov', 35, '', true, 'text', 3);
                ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="<?=@$Trh171_unidadeorig?>">
                <?=db_ancora($Lrh171_unidadeorig, "js_pesquisaUnidadeOrig(true)", $db_opcao_orig);?>
            </td>
            <td> 
                <? 
                    db_input('rh171_unidadeorig',8,$Irh171_unidadeorig,true,'text',$db_opcao_orig,"onchange=js_pesquisaUnidadeOrig(false);");
                    db_input('o41_descr_orig', 35, '', true, 'text', 3);
                ?>
            </td>
            <td nowrap title="<?=@$Trh171_unidadenov?>">
                <?=db_ancora($Lrh171_unidadenov, "js_pesquisaUnidadeNov(true)", 3);?>
            </td>
            <td> 
                <? 
                    db_input('rh171_unidadenov',8,$Irh171_unidadenov,true,'text',3,"onchange=js_pesquisaUnidadeNov(false);");
                    db_input('o41_descr_nov', 35, '', true, 'text', 3);    
                ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="<?=@$Trh171_projativorig?>">
                <?=db_ancora($Lrh171_projativorig, "js_pesquisaProjAtivOrig(true)", $db_opcao_orig);?>
            </td>
            <td> 
                <? 
                    db_input('rh171_projativorig',8,$Irh171_projativorig,true,'text',$db_opcao_orig,"onchange=js_pesquisaProjAtivOrig(false);");
                    db_input('o55_descr_orig', 35, '', true, 'text', 3);
                ?>
            </td>
            <td nowrap title="<?=@$Trh171_projativnov?>">
                <?=db_ancora($Lrh171_projativnov, "js_pesquisaProjAtivNov(true)", 3);?>
            </td>
            <td> 
                <? 
                    db_input('rh171_projativnov',8,$Irh171_projativnov,true,'text',3,"onchange=js_pesquisaProjAtivNov(false);");
                    db_input('o55_descr_nov', 35, '', true, 'text', 3);    
                ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="<?=@$Trh171_recursoorig?>">
                <?=db_ancora($Lrh171_recursoorig, "js_pesquisaRecursoOrig(true)", $db_opcao_orig);?>
            </td>
            <td> 
                <? 
                    db_input('rh171_recursoorig',8,$Irh171_recursoorig,true,'text',$db_opcao_orig,"onchange=js_pesquisaRecursoOrig(false);");
                    db_input('o15_descr_orig', 35, '', true, 'text', 3);
                ?>
            </td>
            <td nowrap title="<?=@$Trh171_recursonov?>">
                <?=db_ancora($Lrh171_recursonov, "js_pesquisaRecursoNov(true)", 3);?>
            </td>
            <td> 
                <? 
                    db_input('rh171_recursonov',8,$Irh171_recursonov,true,'text',3,"onchange=js_pesquisaRecursoNov(false);");
                    db_input('o15_descr_nov', 35, '', true, 'text', 3);    
                ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="<?=@$Trh171_programaorig?>">
                <?=db_ancora($Lrh171_programaorig, "js_pesquisaProgramaOrig(true)", $db_opcao_orig);?>
            </td>
            <td> 
                <? 
                    db_input('rh171_programaorig',8,$Irh171_programaorig,true,'text',$db_opcao_orig,"onchange=js_pesquisaProgramaOrig(false);");
                    db_input('o54_descr_orig', 35, '', true, 'text', 3);
                ?>
            </td>
            <td nowrap title="<?=@$Trh171_programanov?>">
                <?=db_ancora($Lrh171_programanov, "js_pesquisaProgramaNov(true)", 3);?>
            </td>
            <td> 
                <? 
                    db_input('rh171_programanov',8,$Irh171_programanov,true,'text',3,"onchange=js_pesquisaProgramaNov(false);");
                    db_input('o54_descr_nov', 35, '', true, 'text', 3);    
                ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="<?=@$Trh171_funcaoorig?>">
                <?=db_ancora($Lrh171_funcaoorig, "js_pesquisaFuncaoOrig(true)", $db_opcao_orig);?>
            </td>
            <td> 
                <? 
                    db_input('rh171_funcaoorig',8,$Irh171_funcaoorig,true,'text',$db_opcao_orig,"onchange=js_pesquisaFuncaoOrig(false);");
                    db_input('o52_descr_orig', 35, '', true, 'text', 3);
                ?>
            </td>
            <td nowrap title="<?=@$Trh171_funcaonov?>">
                <?=db_ancora($Lrh171_funcaonov, "js_pesquisaFuncaoNov(true)", 3);?>
            </td>
            <td> 
                <? 
                    db_input('rh171_funcaonov',8,$Irh171_funcaonov,true,'text',3,"onchange=js_pesquisaFuncaoNov(false);");
                    db_input('o52_descr_nov', 35, '', true, 'text', 3);    
                ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="<?=@$Trh171_subfuncaoorig?>">
                <?=db_ancora($Lrh171_subfuncaoorig, "js_pesquisaSubFuncaoOrig(true)", $db_opcao_orig);?>
            </td>
            <td> 
                <? 
                    db_input('rh171_subfuncaoorig',8,$Irh171_subfuncaoorig,true,'text',$db_opcao_orig,"onchange=js_pesquisaSubFuncaoOrig(false);");
                    db_input('o53_descr_orig', 35, '', true, 'text', 3);
                ?>
            </td>
            <td nowrap title="<?=@$Trh171_subfuncaonov?>">
                <?=db_ancora($Lrh171_subfuncaonov, "js_pesquisaSubFuncaoNov(true)", 3);?>
            </td>
            <td> 
                <? 
                    db_input('rh171_subfuncaonov',8,$Irh171_subfuncaonov,true,'text',3,"onchange=js_pesquisaSubFuncaoNov(false);");
                    db_input('o53_descr_nov', 35, '', true, 'text', 3);    
                ?>
            </td>
        </tr>
    </table>
</fieldset>
</center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>

let sTagTipoCampo = '';

function js_pesquisa(){
    js_OpenJanelaIframe('top.corpo','db_iframe_rhvinculodotpatronais','func_rhvinculodotpatronais.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
    
    db_iframe_rhvinculodotpatronais.hide();
    <?
    if($db_opcao!=1){
        echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
    }
    ?>

}

function js_pesquisa_coddot(mostra, iTipo){

    sTagTipoCampo = iTipo == 1 ? 'orig' : 'nov';
    
    if(mostra==true){
        js_OpenJanelaIframe('', 
                            'db_iframe_orcdotacao', 
                            'func_orcdotacao.php?funcao_js=parent.js_mostraorcdotacao1|o58_coddot', 
                            'Pesquisar Dotações',true);
    } else {
        js_buscaDotacao(document.getElementById('dotacao_'+sTagTipoCampo).value);
    }
}

function js_mostraorcdotacao1(chave1, iTipo) {

    document.getElementById('dotacao_'+sTagTipoCampo).value = chave1;
    db_iframe_orcdotacao.hide();

    js_buscaDotacao(document.getElementById('dotacao_'+sTagTipoCampo).value);

}

function js_buscaDotacao(iCodDotacao) {

    js_divCarregando('Aguarde, buscando dotação', 'msgbox');
  
    var oParam           = new Object();
    oParam.exec          = "getDotacao";
    oParam.iCodDot       = iCodDotacao;

    var oAjax = new Ajax.Request("orc4_orcdotacao.RPC.php", {
        method:'post',
        parameters:'json='+Object.toJSON(oParam),
        onComplete:js_retornoBuscaDotacao
    });
                              
}

function js_retornoBuscaDotacao(oResponse) {
  
    js_removeObj('msgbox');
    var oRetorno = eval("("+oResponse.responseText+")");
    if (oRetorno.status == 1)  {

        oDotacao = oRetorno.oDotacao;

        document.getElementById('rh171_orgao'+sTagTipoCampo).value      = oDotacao.o58_orgao;
        document.getElementById('o40_descr_'+sTagTipoCampo).value       = oDotacao.o40_descr.urlDecode();
        document.getElementById('rh171_unidade'+sTagTipoCampo).value    = oDotacao.o58_unidade;
        document.getElementById('o41_descr_'+sTagTipoCampo).value       = oDotacao.o41_descr.urlDecode();
        document.getElementById('rh171_projativ'+sTagTipoCampo).value   = oDotacao.o58_projativ;
        document.getElementById('o55_descr_'+sTagTipoCampo).value       = oDotacao.o55_descr.urlDecode();
        document.getElementById('rh171_recurso'+sTagTipoCampo).value    = oDotacao.o58_codigo;
        document.getElementById('o15_descr_'+sTagTipoCampo).value       = oDotacao.o15_descr.urlDecode();        
        document.getElementById('rh171_programa'+sTagTipoCampo).value   = oDotacao.o58_programa;
        document.getElementById('o54_descr_'+sTagTipoCampo).value       = oDotacao.o54_descr.urlDecode();
        document.getElementById('rh171_funcao'+sTagTipoCampo).value     = oDotacao.o58_funcao;
        document.getElementById('o52_descr_'+sTagTipoCampo).value       = oDotacao.o52_descr.urlDecode();
        document.getElementById('rh171_subfuncao'+sTagTipoCampo).value  = oDotacao.o58_subfuncao;
        document.getElementById('o53_descr_'+sTagTipoCampo).value       = oDotacao.o53_descr.urlDecode();            
            
    } else {
        document.getElementById('dotacao_'+sTagTipoCampo).value = ''
        alert(oRetorno.message.urlDecode());
    }
}

function js_pesquisaOrgaoOrig(lMostra) {

    var sUrlOrgao = "func_orcorgao.php?lFiltraInstituicao=true&funcao_js=parent.js_preencheOrgaoOrig1|o40_orgao|o40_descr";

    if (!lMostra) {
        var iCodigoOrgao = document.form1.rh171_orgaoorig.value;
        sUrlOrgao = "func_orcorgao.php?lFiltraInstituicao=true&pesquisa_chave=" + iCodigoOrgao + "&funcao_js=parent.js_preencheOrgaoOrig";
    }

    js_OpenJanelaIframe("", "db_iframe_orcorgao", sUrlOrgao, "Pesquisa Órgão", lMostra);

}

function js_preencheOrgaoOrig1(iOrgao, sDescricao) {

    document.form1.rh171_orgaoorig.value = iOrgao;
    document.form1.o40_descr_orig.value = sDescricao;
    db_iframe_orcorgao.hide();

}

function js_preencheOrgaoOrig(sDescricao, lErro) {

    document.form1.o40_descr_orig.value = sDescricao;

    if (lErro) {
        document.form1.rh171_orgaoorig.value = "";
        document.form1.rh171_orgaoorig.focus();
    }

}

function js_pesquisaOrgaoNov(lMostra) {

    var sUrlOrgao = "func_orcorgao.php?lFiltraInstituicao=true&funcao_js=parent.js_preencheOrgaoNov1|o40_orgao|o40_descr";

    if (!lMostra) {
        var iCodigoOrgao = document.form1.rh171_orgaonov.value;
        sUrlOrgao = "func_orcorgao.php?lFiltraInstituicao=true&pesquisa_chave=" + iCodigoOrgao + "&funcao_js=parent.js_preencheOrgaoNov";
    }

    js_OpenJanelaIframe("", "db_iframe_orcorgao", sUrlOrgao, "Pesquisa Órgão", lMostra);

}

function js_preencheOrgaoNov1(iOrgao, sDescricao) {

    document.form1.rh171_orgaonov.value = iOrgao;
    document.form1.o40_descr_nov.value = sDescricao;
    db_iframe_orcorgao.hide();

}

function js_preencheOrgaoNov(sDescricao, lErro) {

    document.form1.o40_descr_nov.value = sDescricao;
    
    if (lErro) {
        document.form1.rh171_orgaonov.value = "";
        document.form1.rh171_orgaonov.focus();
    }

}

function js_pesquisaUnidadeOrig(lMostra) {

    let iOrgao = document.form1.rh171_orgaoorig.value;

    if (iOrgao == '') {
        alert('Selecione um orgão.');
        return false;
    }

    var sUrlUnidade = "func_orcunidade.php?orgao="+iOrgao+"&funcao_js=parent.js_preencheUnidadeOrig1|o41_unidade|o41_descr";

    if (!lMostra) {
        var iCodigoUnidade = document.form1.rh171_unidadeorig.value;
        sUrlUnidade = "func_orcunidade.php?orgaos="+iOrgao+"&pesquisa_chave=" + iCodigoUnidade + "&funcao_js=parent.js_preencheUnidadeOrig";
    }

    js_OpenJanelaIframe("", "db_iframe_unidade", sUrlUnidade, "Pesquisa Unidade", lMostra);

}

function js_preencheUnidadeOrig1(iOrgao, sDescricao) {

    document.form1.rh171_unidadeorig.value = iOrgao;
    document.form1.o41_descr_orig.value = sDescricao;
    db_iframe_unidade.hide();

}

function js_preencheUnidadeOrig(sDescricao, lErro) {

    document.form1.o41_descr_orig.value = sDescricao;

    if (lErro) {
        document.form1.rh171_unidadeorig.value = "";
        document.form1.rh171_unidadeorig.focus();
    }

}

function js_pesquisaUnidadeNov(lMostra) {

    let iOrgao = document.form1.rh171_orgaonov.value;

    if (iOrgao == '') {
        alert('Selecione um orgão.');
        return false;
    }

    var sUrlUnidade = "func_orcunidade.php?orgao="+iOrgao+"&funcao_js=parent.js_preencheUnidadeNov1|o41_unidade|o41_descr";

    if (!lMostra) {
        var iCodigoUnidade = document.form1.rh171_unidadenov.value;
        sUrlUnidade = "func_orcunidade.php?orgaos="+iOrgao+"&pesquisa_chave=" + iCodigoUnidade + "&funcao_js=parent.js_preencheUnidadeNov";
    }

    js_OpenJanelaIframe("", "db_iframe_unidade", sUrlUnidade, "Pesquisa Unidade", lMostra);

}

function js_preencheUnidadeNov1(iCodigoUnidade, sDescricao) {

    document.form1.rh171_unidadenov.value = iCodigoUnidade;
    document.form1.o41_descr_nov.value = sDescricao;
    db_iframe_unidade.hide();

}

function js_preencheUnidadeNov(sDescricao, lErro) {

    document.form1.o41_descr_nov.value = sDescricao;

    if (lErro) {
        document.form1.rh171_unidadenov.value = "";
        document.form1.rh171_unidadenov.focus();
    }

}

function js_pesquisaProjAtivOrig(lMostra) {

    var sUrlProjAtiv = "func_orcprojativ.php?funcao_js=parent.js_preencheProjAtivOrig1|o55_projativ|o55_descr";

    if (!lMostra) {
        var iProjAtiv = document.form1.rh171_projativorig.value;
        sUrlProjAtiv = "func_orcprojativ.php?pesquisa_chave=" + iProjAtiv + "&funcao_js=parent.js_preencheProjAtivOrig";
    }

    js_OpenJanelaIframe("", "db_iframe_orcprojativ", sUrlProjAtiv, "Pesquisa Projeto/Atividade", lMostra);

}

function js_preencheProjAtivOrig1(iProjAtiv, sDescricao) {

    document.form1.rh171_projativorig.value = iProjAtiv;
    document.form1.o55_descr_orig.value = sDescricao;
    db_iframe_orcprojativ.hide();

}

function js_preencheProjAtivOrig(sDescricao, lErro) {

    document.form1.o55_descr_orig.value = sDescricao;

    if (lErro) {
        document.form1.rh171_projativorig.value = "";
        document.form1.rh171_projativorig.focus();
    }

}

function js_pesquisaProjAtivNov(lMostra) {

    var sUrlProjAtiv = "func_orcprojativ.php?funcao_js=parent.js_preencheProjAtivNov1|o55_projativ|o55_descr";

    if (!lMostra) {
        var iProjAtiv = document.form1.rh171_projativnov.value;
        sUrlProjAtiv = "func_orcprojativ.php?pesquisa_chave=" + iProjAtiv + "&funcao_js=parent.js_preencheProjAtivNov";
    }

    js_OpenJanelaIframe("", "db_iframe_orcprojativ", sUrlProjAtiv, "Pesquisa Projeto/Atividade", lMostra);

}

function js_preencheProjAtivNov1(iProjAtiv, sDescricao) {

    document.form1.rh171_projativnov.value = iProjAtiv;
    document.form1.o55_descr_nov.value = sDescricao;
    db_iframe_orcprojativ.hide();

}

function js_preencheProjAtivNov(sDescricao, lErro) {

    document.form1.o55_descr_nov.value = sDescricao;

    if (lErro) {
        document.form1.rh171_projativnov.value = "";
        document.form1.rh171_projativnov.focus();
    }

}

function js_pesquisaRecursoOrig(lMostra) {

    var sUrlRecurso = "func_orctiporec.php?funcao_js=parent.js_preencheRecursoOrig1|o15_codigo|o15_descr";

    if (!lMostra) {
        var iRecurso = document.form1.rh171_recursoorig.value;
        sUrlRecurso = "func_orctiporec.php?pesquisa_chave=" + iRecurso + "&funcao_js=parent.js_preencheRecursoOrig";
    }

    js_OpenJanelaIframe("", "db_iframe_orcprojativ", sUrlRecurso, "Pesquisa Recurso", lMostra);

}

function js_preencheRecursoOrig1(iRecurso, sDescricao) {

    document.form1.rh171_recursoorig.value = iRecurso;
    document.form1.o15_descr_orig.value = sDescricao;
    db_iframe_orcprojativ.hide();

}

function js_preencheRecursoOrig(sDescricao, lErro) {

    document.form1.o15_descr_orig.value = sDescricao;

    if (lErro) {
        document.form1.rh171_recursoorig.value = "";
        document.form1.rh171_recursoorig.focus();
    }

}

function js_pesquisaRecursoNov(lMostra) {

    var sUrlRecurso = "func_orctiporec.php?funcao_js=parent.js_preencheRecursoNov1|o15_codigo|o15_descr";

    if (!lMostra) {
        var iRecurso = document.form1.rh171_recursonov.value;
        sUrlRecurso = "func_orctiporec.php?pesquisa_chave=" + iRecurso + "&funcao_js=parent.js_preencheRecursoNov";
    }

    js_OpenJanelaIframe("", "db_iframe_orcprojativ", sUrlRecurso, "Pesquisa Recurso", lMostra);

}

function js_preencheRecursoNov1(iRecurso, sDescricao) {

    document.form1.rh171_recursonov.value = iRecurso;
    document.form1.o15_descr_nov.value = sDescricao;
    db_iframe_orcprojativ.hide();

}

function js_preencheRecursoNov(sDescricao, lErro) {

    document.form1.o15_descr_nov.value = sDescricao;

    if (lErro) {
        document.form1.rh171_recursonov.value = "";
        document.form1.rh171_recursonov.focus();
    }

}
function js_pesquisaProgramaOrig(lMostra) {

    var sUrlPrograma = "func_orcprograma.php?funcao_js=parent.js_preencheProgramaNov1|o54_programa|o54_descr";

    if (!lMostra) {
        var iPrograma = document.form1.rh171_programaorig.value;
        sUrlPrograma = "func_orcprograma.php?pesquisa_chave=" + iPrograma + "&funcao_js=parent.js_preencheProgramaNov";
    }

    js_OpenJanelaIframe("", "db_iframe_orcprograma", sUrlPrograma, "Pesquisa Programa", lMostra);

}

function js_preencheProgramaNov1(iPrograma, sDescricao) {

    document.form1.rh171_programaorig.value = iPrograma;
    document.form1.o54_descr_orig.value = sDescricao;
    db_iframe_orcprograma.hide();

}

function js_preencheProgramaNov(sDescricao, lErro) {

    document.form1.o54_descr_orig.value = sDescricao;

    if (lErro) {
        document.form1.rh171_programaorig.value = "";
        document.form1.rh171_programaorig.focus();
    }

}

function js_pesquisaFuncaoOrig(lMostra) {

    var sUrlFuncao = "func_orcfuncao.php?funcao_js=parent.js_preencheFuncaoNov1|o52_funcao|o52_descr";

    if (!lMostra) {
        var iFuncao = document.form1.rh171_funcaoorig.value;
        sUrlFuncao = "func_orcfuncao.php?pesquisa_chave=" + iFuncao + "&funcao_js=parent.js_preencheFuncaoNov";
    }

    js_OpenJanelaIframe("", "db_iframe_orcfuncao", sUrlFuncao, "Pesquisa Função", lMostra);

}

function js_preencheFuncaoNov1(iFuncao, sDescricao) {

    document.form1.rh171_funcaoorig.value = iFuncao;
    document.form1.o52_descr_orig.value = sDescricao;
    db_iframe_orcfuncao.hide();

}

function js_preencheFuncaoNov(sDescricao, lErro) {

    document.form1.o52_descr_orig.value = sDescricao;

    if (lErro) {
        document.form1.rh171_funcaoorig.value = "";
        document.form1.rh171_funcaoorig.focus();
    }

}

function js_pesquisaSubFuncaoOrig(lMostra) {

    var sUrlSubFuncao = "func_orcsubfuncao.php?funcao_js=parent.js_preencheSubFuncaoNov1|o53_subfuncao|o53_descr";

    if (!lMostra) {
        var iSubfuncao = document.form1.rh171_subfuncaoorig.value;
        sUrlSubFuncao = "func_orcsubfuncao.php?pesquisa_chave=" + iSubfuncao + "&funcao_js=parent.js_preencheSubFuncaoNov";
    }

    js_OpenJanelaIframe("", "db_iframe_orcsubfuncao", sUrlSubFuncao, "Pesquisa Subfunção", lMostra);

}

function js_preencheSubFuncaoNov1(iSubfuncao, sDescricao) {

    document.form1.rh171_subfuncaoorig.value = iSubfuncao;
    document.form1.o53_descr_orig.value = sDescricao;
    db_iframe_orcsubfuncao.hide();

}

function js_preencheSubFuncaoNov(sDescricao, lErro) {

    document.form1.o53_descr_orig.value = sDescricao;

    if (lErro) {
        document.form1.rh171_subfuncaoorig.value = "";
        document.form1.rh171_subfuncaoorig.focus();
    }

}
</script>
