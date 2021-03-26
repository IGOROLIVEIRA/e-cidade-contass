<?
//MODULO: sicom
$clpublicacaoeperiodicidadergf->rotulo->label();
?>
<form name="form1" method="post" action="">

    <table border="0" align="left" >
        <tr>
            <td>

                <table>

                    <tr>
                        <td nowrap >
                            <b>Houve publicação do RGF:</b>
                        </td>
                        <td>
                            <?
                            $x = array("0"=>"Selecione","1"=>"SIM","2"=>"NÃO");
                            db_select('c221_publicrgf',$x,true,1,"onchange='js_escondeCampos()'");
                            ?>
                        </td>
                    </tr>

                    </tr>
                    <tr <?php if($db_opcao == 1): ?>style="display:none" <?php endif; ?> id="data">
                        <td nowrap >
                            <b>Data da Publicação do RGF:</b>
                        </td>
                        <td>
                            <?
                            db_inputdata('c221_dtpublicacaorelatoriorgf',"","","",true,'text',$db_opcao,"");
                            ?>
                        </td>
                    </tr>

                    <tr <?php if($db_opcao == 1): ?>style="display:none" <?php endif; ?> id="local">
                        <td  >
                            <b>Local da Publicação da RGF:</b>
                        </td>
                        <td>
                            <?
                            db_input('c221_localpublicacaorgf',80,0,true,'text',$db_opcao,"","","","",1000)
                            ?>
                        </td>
                    </tr>
                    <tr <?php if($db_opcao == 1): ?>style="display:none" <?php endif; ?> id="bimestre">
                        <td  >
                            <b>Período a que se refere a publicação do RGF:</b>
                        </td>
                        <td>
                            <?
                            $x = array(
                                "0"=>"Selecione",
                                "1"=>"Primeiro semestre",
                                "2"=>"Segundo semestre",
                                "3"=>"Primeiro quadrimestre",
                                "4"=>"Segundo quadrimestre",
                                "5"=>"Terceiro quadrimestre"
                            );
                            db_select('c221_tpperiodo',$x,true,1,"");
                            ?>
                        </td>
                    </tr>
                    <tr <?php if($db_opcao == 1): ?>style="display:none" <?php endif; ?> id="exercicio">
                        <td  >
                            <b>Exercício a que se refere a publicação do RGF:</b>
                        </td>
                        <td>
                            <?
                            db_input('c221_exerciciotpperiodo',14,$Ic221_exerciciotpperiodo,true,'text',$db_opcao,"", "", "", "",4)
                            ?>
                        </td>
                    </tr>


                </table>
                <center>
                    <br>
                    <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="button" id="db_opcao" value="<?=($db_opcao==1?"Salvar":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> onclick="js_incluirDados();" >

                </center>
            </td>
        </tr>
    </table>
</form>
<script>
    function js_escondeCampos(){
        if(document.form1.c221_publicrgf.value == "1"){
            document.getElementById('data').style.display="";
            document.getElementById('local').style.display="";
            document.getElementById('bimestre').style.display="";
            document.getElementById('exercicio').style.display="";
        }else{
            document.getElementById('data').style.display="none";
            document.getElementById('c221_dtpublicacaorelatoriorgf').value = "";
            document.getElementById('local').style.display="none";
            document.getElementById('c221_localpublicacaorgf').value = "";
            document.getElementById('bimestre').style.display="none";
            document.getElementById('c221_localpublicacaorgf').value = "";
            document.getElementById('exercicio').style.display="none";
            document.getElementById('c221_exerciciotpperiodo').value = "";
            document.getElementById('c221_tpperiodo').value = 0;
        }
    }
    function js_incluirDados(){

        var oParametros = new Object();

        <?php if($db_opcao == 3): ?>
        oParametros.exec = 'excluirDados';
        <?php else: ?>
        oParametros.exec = 'salvarDados';
        <?php if($db_opcao == 1): ?>
        oParametros.inclusao = false;
        <?php else: ?>
        oParametros.alteracao = true;
        <?php endif; ?>
        <?php endif; ?>

        if(document.form1.c221_publicrgf.value == "0"){
            alert('O campo "Houve publicação do RGF" não foi preenchido.');
            return false;
        }else{
            if(document.form1.c221_publicrgf.value == "1"){
                if(document.form1.c221_dtpublicacaorelatoriorgf.value == ""){
                    alert('O campo "Data de publicação do RGF da LRF" não foi preenchido.');
                    return false;
                }
                if(document.form1.c221_localpublicacaorgf.value == ""){
                    alert('O campo "Onde foi dada a publicidade do RGF" não foi preenchido.');
                    return false;
                }
                if(document.form1.c221_tpperiodo.value == "0"){
                    alert('O campo "Período a que se refere a data de publicação do RGF da LRF" não foi preenchido.');
                    return false;
                }
                if(document.form1.c221_exerciciotpperiodo.value == ""){
                    alert('O campo "Exercício a que se refere o período da publicação do RGF da LRF" não foi preenchido.');
                    return false;
                }
            }
        }
        /*VALIDAÇÕES DOS OUTROS FORMS DAS OUTRAS ABAS*/
        if(CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_mesusu.value == "0"){
            alert('O campo "Mês de Referência" não foi preenchido.');
            return false;
        }
        <?php if($tipoInstint == 2): ?>
        if(CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_metarrecada.value == "0" && (CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_mesusu.value % 2) == 0){
            alert('O campo "A meta bimestral de arrecadação foi cumprida" não foi preenchido.');
            return false;
        }    <?php endif; ?>

        <?php if(db_getsession("DB_anousu") > 2018):?>
        let medidas1 = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.metasadotadas;
        let medidasadotadas1 = Array.from(medidas1.options);
        let valida = true;

        if(CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_metarrecada.value == "2" && (CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_mesusu.value % 2) == 0 && medidasadotadas1 == ""){
            alert('Dados Complementares LRF - Nenhuma Medida Selecionada.');
            return false;
        }
        medidasadotadas1.forEach(function (itens, key) {
            if(itens.value == 99 && CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_dscmedidasadotadas.value == ""){
                alert('o Campo "Descrição das Outras Medidas" não foi preenchido.');
                valida = false;
            }
        });
        if(valida == false){
            return;
        }
        <?php endif;?>

        <?php if($tipoInstint == 2): ?>
        // SÓ VALIDA OPERACOES DE CREDITO SE A INSTITUIÇÃO FOR PREFEITURA
        // E O MES DE REFERENCIA FOR DEZEMBRO
        if(CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_mesusu.value == "12"){
            if(CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_contopcredito.value == "0"){
                alert('O campo "Contratação de Operação que não atendeu limites Art. 33 LC 101/2000" não foi preenchido.');
                return false;
            }
            if(CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_realizopcredito.value == "0"){
                alert('O campo "Realização de Operações de crédito vedadas pelo Art. 37 LC 101/2000" não foi preenchido.');
                return false;
            }
            if(CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditocapta.value == "0"){
                alert('O campo "Tipo de realização de operações de crédito vedada (Captação)" não foi preenchido.');
                return false;
            }
            if(CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoreceb.value == "0"){
                alert('O campo "Tipo de realização de operações de crédito vedada (Recebimento)" não foi preenchido.');
                return false;
            }
            if(CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoassundir.value == "0"){
                alert('O campo "Tipo de realização de operações de crédito vedada (Assução direta)" não foi preenchido.');
                return false;
            }
            if(CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoassunobg.value == "0"){
                alert('O campo "Tipo de realização de operações de crédito vedada (Assução de obrigação)" não foi preenchido.');
                return false;
            }
        }
        // VALIDA A ABA PUBLICACAO E PERIODICIDADE RREO
        if(CurrentWindow.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_publiclrf.value == "0"){
            alert('O campo "Houve publicação do RREO" não foi preenchido.');
            return false;
        }else{
            if(CurrentWindow.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_publiclrf.value == "1"){
                if(CurrentWindow.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_dtpublicacaorelatoriolrf.value == ""){
                    alert('O campo "Data de publicação do RREO da LRF" não foi preenchido.');
                    return false;
                }
                if(CurrentWindow.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_localpublicacao.value == ""){
                    alert('O campo "Onde foi dada a publicidade do RREO" não foi preenchido.');
                    return false;
                }
                if(CurrentWindow.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_tpbimestre.value == "0"){
                    alert('O campo "Bimestre a que se refere a data de publicação do RREO da LRF" não foi preenchido.');
                    return false;
                }
                if(CurrentWindow.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_exerciciotpbimestre.value == ""){
                    alert('O campo "Exercício a que se refere o período da publicação do RREO da LRF" não foi preenchido.');
                    return false;
                }
            }
        }

        <?php endif; ?>
        <?php if(db_getsession("DB_anousu") > 2018):?>
        let todasmedidas = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.metasadotadas;
        // console.log(todasmedidas);
        let medidas = Array.from(todasmedidas.options);

        let medidasadotadas = [];
        medidas.forEach(function (itens, key) {

            medidasadotadas[key] = itens.value
        });

        CurrentWindow.corpo.dadoscomplementares.c225_metasadotadas = medidasadotadas;
        <?php endif;?>
        CurrentWindow.corpo.dadoscomplementares.c218_sequencial = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_sequencial.value;
        CurrentWindow.corpo.dadoscomplementares.c218_mesusu = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_mesusu.value;
        CurrentWindow.corpo.dadoscomplementares.c218_passivosreconhecidos = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_passivosreconhecidos.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vlsaldoatualconcgarantiainterna = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vlsaldoatualconcgarantiainterna.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vlsaldoatualconcgarantia = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vlsaldoatualconcgarantia.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vlsaldoatualcontragarantiainterna = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vlsaldoatualcontragarantiainterna.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vlsaldoatualcontragarantiaexterna = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vlsaldoatualcontragarantiaexterna.value;
        CurrentWindow.corpo.dadoscomplementares.c218_medidascorretivas = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_medidascorretivas.value;
        if(CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.medidasCorretivas.value == 2){
            CurrentWindow.corpo.dadoscomplementares.c218_medidascorretivas = "";
        }
        CurrentWindow.corpo.dadoscomplementares.c218_recalieninvpermanente = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_recalieninvpermanente.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vldotatualizadaincentcontrib = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vldotatualizadaincentcontrib.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vlempenhadoicentcontrib = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vlempenhadoicentcontrib.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vldotatualizadaincentinstfinanc = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vldotatualizadaincentinstfinanc.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vlempenhadoincentinstfinanc = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vlempenhadoincentinstfinanc.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vlliqincentcontrib = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vlliqincentcontrib.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vlliqincentinstfinanc = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vlliqincentinstfinanc.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vlirpnpincentcontrib = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vlirpnpincentcontrib.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vlirpnpincentinstfinanc = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vlirpnpincentinstfinanc.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vlrecursosnaoaplicados = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vlrecursosnaoaplicados.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vlapropiacaodepositosjudiciais = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vlapropiacaodepositosjudiciais.value;
        CurrentWindow.corpo.dadoscomplementares.c218_vloutrosajustes = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_vloutrosajustes.value;
        CurrentWindow.corpo.dadoscomplementares.c218_metarrecada = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_metarrecada.value;
        CurrentWindow.corpo.dadoscomplementares.c218_dscmedidasadotadas = CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_dscmedidasadotadas.value;
        if(CurrentWindow.corpo.iframe_dadoscomplementares.document.form1.c218_metarrecada.value == 1){
            CurrentWindow.corpo.dadoscomplementares.c218_dscmedidasadotadas = "";
        }
        CurrentWindow.corpo.operacoesdecredito.c219_contopcredito = CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_contopcredito.value;
        CurrentWindow.corpo.operacoesdecredito.c219_dsccontopcredito = CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_dsccontopcredito.value;
        CurrentWindow.corpo.operacoesdecredito.c219_realizopcredito = CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_realizopcredito.value;
        CurrentWindow.corpo.operacoesdecredito.c219_tiporealizopcreditocapta = CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditocapta.value;
        CurrentWindow.corpo.operacoesdecredito.c219_tiporealizopcreditoreceb = CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoreceb.value;
        CurrentWindow.corpo.operacoesdecredito.c219_tiporealizopcreditoassundir = CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoassundir.value;
        CurrentWindow.corpo.operacoesdecredito.c219_tiporealizopcreditoassunobg = CurrentWindow.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoassunobg.value;

        CurrentWindow.corpo.publicacaoeperiodicidaderreo.c220_publiclrf = CurrentWindow.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_publiclrf.value;
        CurrentWindow.corpo.publicacaoeperiodicidaderreo.c220_dtpublicacaorelatoriolrf = CurrentWindow.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_dtpublicacaorelatoriolrf.value;
        CurrentWindow.corpo.publicacaoeperiodicidaderreo.c220_localpublicacao = CurrentWindow.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_localpublicacao.value;
        CurrentWindow.corpo.publicacaoeperiodicidaderreo.c220_tpbimestre = CurrentWindow.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_tpbimestre.value;
        CurrentWindow.corpo.publicacaoeperiodicidaderreo.c220_exerciciotpbimestre = CurrentWindow.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_exerciciotpbimestre.value;

        CurrentWindow.corpo.publicacaoeperiodicidadergf.c221_publicrgf = document.form1.c221_publicrgf.value;
        CurrentWindow.corpo.publicacaoeperiodicidadergf.c221_dtpublicacaorelatoriorgf = document.form1.c221_dtpublicacaorelatoriorgf.value;
        CurrentWindow.corpo.publicacaoeperiodicidadergf.c221_localpublicacaorgf = document.form1.c221_localpublicacaorgf.value;
        CurrentWindow.corpo.publicacaoeperiodicidadergf.c221_tpperiodo = document.form1.c221_tpperiodo.value;
        CurrentWindow.corpo.publicacaoeperiodicidadergf.c221_exerciciotpperiodo = document.form1.c221_exerciciotpperiodo.value;

        oParametros.dadoscomplementares = CurrentWindow.corpo.dadoscomplementares;
        oParametros.operacoesdecredito = CurrentWindow.corpo.operacoesdecredito;
        oParametros.publicacaoeperiodicidaderreo = CurrentWindow.corpo.publicacaoeperiodicidaderreo;
        oParametros.publicacaoeperiodicidadergf = CurrentWindow.corpo.publicacaoeperiodicidadergf;


        js_divCarregando('Mensagem', 'msgBox');

        var oAjaxLista = new Ajax.Request("sic1_dadoscomplementareslrf.RPC.php",
            {
                method: "post",
                parameters: 'json=' + Object.toJSON(oParametros),
                onComplete: js_validarInclusao
            });

    }
    function js_validarInclusao(oAjax){

        js_removeObj('msgBox');
        //parent.mo_camada('operacoesdecredito');

        var oRetorno = eval("(" + oAjax.responseText + ")");

        alert(oRetorno.msg);

        if(oRetorno.status == "1"){
            <?php if($db_opcao != 3): ?>
            CurrentWindow.corpo.location.href="sic1_dadoscomplementareslrf002.php?chave="+oRetorno.c218_sequencial;
            <?php else: ?>
            CurrentWindow.corpo.location.href="sic1_dadoscomplementareslrf003.php?chave="+oRetorno.c218_sequencial;
            <?php endif; ?>
        }
        return false;
    }
    function js_pesquisa(){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_dadoscomplementareslrf','func_dadoscomplementareslrf.php?funcao_js=parent.js_preenchepesquisa|c218_sequencial','Pesquisa',true);
    }
    function js_preenchepesquisa(chave){
        db_iframe_dadoscomplementareslrf.hide();
        <?
        if($db_opcao!=1){
            echo "location.href = 'sic1_dadoscomplementareslrf002.php?chavepesquisa='+chave";
        }
        ?>
    }
</script>
