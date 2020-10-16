<?
//MODULO: Controle Interno
$clprocessoaudit->rotulo->label();
?>
<form name="form1" method="post" action="" onsubmit='js_submit()'>
    <center>
        <fieldset class="fildset-principal">
            <legend>
                <b>Processo de Auditoria</b>
            </legend>
            <table border="0">
                <tr>
                    <td nowrap title="<?=@$Tci03_codproc?>">
                        <input name="ci03_codproc" type="hidden" value="<?=@$ci03_codproc?>">
                        <?=@$Lci03_codproc?>
                    </td>
                    <td> 
                        <? db_input('ci03_codproc',11,$Ici03_codproc,true,'text',3,"") ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tci03_numproc?>">
                        <?=@$Lci03_numproc?>
                    </td>
                    <td> 
                        <? db_input('ci03_numproc',11,$Ici03_numproc,true,'text',$db_opcao,"") ?>
                    </td>
                    <td nowrap title="<?=@$Tci03_dataini?>" align="right">
                        <?=@$Lci03_dataini?>
                    </td>
                    <td align="right"> 
                        <? db_inputdata('ci03_dataini',@$ci03_dataini_dia,@$ci03_dataini_mes,@$ci03_dataini_ano,true,'text',$db_opcao,"") ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tci03_anoproc?>">
                        <?=@$Lci03_anoproc?>
                    </td>
                    <td> 
                        <? db_input('ci03_anoproc',11,$Ici03_anoproc,true,'text',$db_opcao,"") ?>
                    </td>
                    <td nowrap title="<?=@$Tci03_datafim?>" align="right">
                        <?=@$Lci03_datafim?>
                    </td>
                    <td align="right"> 
                        <? db_inputdata('ci03_datafim',@$ci03_datafim_dia,@$ci03_datafim_mes,@$ci03_datafim_ano,true,'text',$db_opcao,"") ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tci03_grupoaudit?>">
                        <?=@$Lci03_grupoaudit?>
                    </td>
                    <td colspan="3"> 
                        <?
                        $aGrupo = array(
                            0 => "Selecione", 
                            1 => "Auditoria de Regularidade",
                            2 => "Auditoria Operacional",
                            3 => "Demanda Extraordinária"
                        );
                        db_select("ci03_grupoaudit", $aGrupo, true, 4, "style='width:445;'");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tci03_objaudit?>">
                    <?=@$Lci03_objaudit?>
                    </td>
                    <td colspan="3"> 
                        <? db_textarea('ci03_objaudit',5,60,$Ici03_objaudit,true,'text',$db_opcao,"","","",500) ?>
                    </td>
                </tr>
                <tr>
                <td colspan="4" align="center">
                    <table>
                        <tr>
                            <td align="center">
                            <?
                            $aux = new cl_arquivo_auxiliar;
                            $aux->Labelancora = "Setor(es):";
                            $aux->codigo = "coddepto";
                            $aux->descr  = "descrdepto";
                            $aux->nomeobjeto = 'depart';
                            $aux->funcao_js = 'js_mostra';
                            $aux->funcao_js_hide = 'js_mostra1';
                            $aux->sql_exec  = "";
                            $aux->func_arquivo = "func_db_depart.php";
                            $aux->nomeiframe = "db_iframe_db_depart";
                            $aux->localjan = "";
                            $aux->db_opcao = $db_opcao;
                            $aux->tipo = 2;
                            $aux->top = 2;
                            $aux->linhas = 4;
                            $aux->vwidth = 380;
                            $aux->mostra_fieldset = false;
                            $aux->funcao_gera_formulario();
                            ?>
                            </td>
                        </tr>
                    </table>
                    </td>
                </tr>
                <input type="hidden" name="departamentos" id="departamentos" value="<?= isset($departamentos) ? $departamentos : '' ?>" />
            </table>
            <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
            <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
        </fieldset>
    </center>

</form>
<script>

function js_pesquisa(){
  js_OpenJanelaIframe('','db_iframe_processoaudit','func_processoaudit.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true,0);
}
function js_preenchepesquisa(chave){
  db_iframe_processoaudit.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_submit() {

    if (document.form1.ci03_anoproc.value.length < 4) {
        
        today = new Date();
        var todayYear = today.getFullYear();
        alert('Formato do ano inválido. Ex.: ' + todayYear);
        document.form1.ci03_anoproc.focus();
        event.preventDefault();
        return false;

    }

    if (document.form1.ci03_grupoaudit.value == 0) {
        alert("Informe o Grupo de Auditoria");
        event.preventDefault();
        return false;

    }
    
    var depart = document.getElementById("depart").options;
    
    if(depart.length > 0){
        departamentos = '';
        virgula = '';
        for(var i = 0;i < depart.length;i++) {
            departamentos += virgula+depart[i].value;
            virgula = ',';
        }
        document.getElementById("departamentos").value = departamentos;

    }else{
        
        alert('Selecione um setor.');
        event.preventDefault();
        
    }
    
}

function js_pesquisaDepts(iCodProc=null) {
    
    if (iCodProc != null) {
    
        try{

            js_divCarregando("Aguarde, buscando departamentos...", "msgBox");

            var oParametro      = new Object();
            oParametro.exec     = 'getDepartamentos';
            oParametro.iCodProc = iCodProc;

            new Ajax.Request('cin4_processoaudit.RPC.php',
                            {
                            method: 'post',
                            parameters: 'json='+Object.toJSON(oParametro),
                            onComplete: js_completaGetDepartamentos
                            });

        } catch (e) {
            alert(e.toString());
        }

    }

}

function js_completaGetDepartamentos(oAjax) {

    js_removeObj('msgBox');
    var oRetorno = eval("("+oAjax.responseText+")");
    
    if (oRetorno.status == 1) {    

        oRetorno.aItens.each(function (oDepto, iLinha) {

            var select = document.getElementById('depart');
            var option = document.createElement('option');
            option.text = oDepto.descrdepto;
            option.value = oDepto.ci04_depto;
            select.add(option);

        });
    }

}

</script>

<? if ($db_opcao != 1 || isset($ci03_codproc)) { ?>
   <script>
        js_pesquisaDepts(<?= $ci03_codproc ?>);
   </script>
<? } ?>