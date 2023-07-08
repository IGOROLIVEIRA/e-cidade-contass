<?php

require_once("libs/db_sessoes.php");
require_once("libs/db_stdlib.php");


//MODULO: diversos
$cldiversos->rotulo->label();

$clrotulo = new rotulocampo;

$clrotulo->label("z01_nome");
$clrotulo->label("dv09_descr");
$clrotulo->label("i02_codigo");
$clrotulo->label("dv05_procdiver");

$dia=date('d',db_getsession("DB_datausu"));
$mes=date('m',db_getsession("DB_datausu"));
$ano=date('Y',db_getsession("DB_datausu"));

//consulta tipo debito
$Idv09_tipo_sql = db_query("select dv09_tipo from procdiver where dv09_procdiver = $dv05_procdiver;");
$Idv09_tipo = db_utils::fieldsMemory($Idv09_tipo_sql, 0)->dv09_tipo;

?>

<script>

// Cria novo diverso
function js_novoDiverso(){
 
  location.href = "dvr3_diversos004.php&iInstitId=1&iAreaId=1&iModuloId=1444";

}

function js_trocatotal() {

  valor   = new Number(document.form1.dv05_valor.value);
  numtot  = new Number(document.form1.dv05_numtot.value);
  xx      = new Number(valor*numtot);

  if( isNaN(xx) ) {

    document.form1.dv05_valor.focus();
    document.getElementById("total").innerHTML=" 0,00";

  }else{
    document.getElementById("total").innerHTML="Valor total:R$ "+xx.toFixed(2);
  }

}

function js_verifica() {

  obj = document.form1;

  if ( obj.dv05_dtinsc_dia.value == "" || obj.dv05_dtinsc_mes.value == "" || obj.dv05_dtinsc_ano.value == "" ) {

    alert(_M("tributario.diversos.db_frmdiversosalt.verifique_data_inscricao"));
    return false;

  }

  if ( obj.dv05_exerc.value == "" || obj.dv05_exerc.value == 0 ) {

   alert(_M("tributario.diversos.db_frmdiversosalt.verifique_ano_origem"));
   return false;

  }

  if ( obj.dv05_procdiver.value == "" ) {

    alert(_M("tributario.diversos.db_frmdiversosalt.verifique_procedencia"));
    return false;

  }

  if ( obj.dv05_privenc_dia.value == "" || obj.dv05_privenc_mes.value == "" || obj.dv05_privenc_ano.value == "") {

    alert(_M("tributario.diversos.db_frmdiversosalt.verifique_data_primeiro_vencimento"));
    return false;
  }

  if ( obj.dv05_vlrhis.value == "" ) {
    alert(_M("tributario.diversos.db_frmdiversosalt.verifique_valor_historico"));
    return false;
  }

  if ( obj.dv05_oper_dia.value == "" || obj.dv05_oper_mes.value == "" || obj.dv05_oper_ano.value == "" ) {

    alert(_M("tributario.diversos.db_frmdiversosalt.verifique_data_operacao"));
    return false;
  }

  if ( obj.dv05_valor.value == "" ) {

    alert(_M("tributario.diversos.db_frmdiversosalt.verifique_valor_total"));
    return false;
  }

  if ( obj.dv05_numtot.value == "" ) {

    alert(_M("tributario.diversos.db_frmdiversosalt.verifique_numero_parcelas"));
    return false;
  }

  if ( obj.dv05_numtot.value>1 ) {

    if ( obj.dv05_provenc_dia.value == "" || obj.dv05_provenc_mes.value == "" || obj.dv05_provenc_ano.value == "" ) {

      alert(_M("tributario.diversos.db_frmdiversosalt.verifique_data_proximo_vencimento"));
      return false;
    }

    if ( obj.dv05_diaprox.value == "" ) {

      alert(_M("tributario.diversos.db_frmdiversosalt.verifique_dia_proximos_vencimentos"));
      return false;
    }

  }

  return true;
}

function js_sub(obj) {

  if ( obj.value != 0 ) {

    var dia    = new Number(document.form1.dv05_privenc_dia.value);
    var mes    = new Number(document.form1.dv05_privenc_mes.value);
    var ano    = new Number(document.form1.dv05_privenc_ano.value);
    var vlrhis = document.form1.dv05_vlrhis.value;

    if ( dia == "" || mes == "" || ano == "" ) {
      alert(_M("tributario.diversos.db_frmdiversosalt.preencha_data_primeiro_vencimento"));
    } else {

      if ( document.form1.dv05_procdiver == "" ) {
        alert(_M("tributario.diversos.db_frmdiversosalt.selecione_procedencia"));
      } else {

	      if ( vlrhis == "" && obj.name == "calcula" ) {
	       alert(_M("tributario.diversos.db_frmdiversosalt.preencha_valor_historico"));
	      } else {

      	  if ( vlrhis != "" ) {

            document.form1.subtes.value = "ok";
            document.form1.submit();
      	  }
      	}
      }
    }
  } else {

     document.form1.i02_codigo.value = "";
     document.form1.dv05_valor.value = "";
  }
}

function js_trocatot(obj) {

  var tot = new Number(obj.value);
  var dia = new Number(document.form1.dv05_privenc_dia.value);
  var mes = new Number(document.form1.dv05_privenc_mes.value);
  var ano = new Number(document.form1.dv05_privenc_ano.value);

  if ( !isNaN(tot) && tot > 1 ) {

    document.getElementById("provenc").style.display = '';
    document.getElementById("diaprox").style.display = '';

  	mes--;

  	if ( mes == 11 ) {

  	  ano++;
  	  mes="0";

    } else {
  	  mes++;
  	}

    if(dia!="" && mes!="" && ano!=""){

      x                                     = js_retornadata(dia,mes,ano);
  	  document.form1.dv05_provenc_dia.value = x.getDate();
  	  document.form1.dv05_provenc_mes.value = x.getMonth()+1;
  	  document.form1.dv05_provenc_ano.value = x.getFullYear();
  	  document.form1.dv05_diaprox.value     = x.getDate();
  	}

  } else {

    document.form1.dv05_diaprox.value                   = dia;
    document.form1.dv05_provenc_dia.value               = dia;
    document.form1.dv05_provenc_mes.value               = mes;
    document.form1.dv05_provenc_ano.value               = ano;
    document.getElementById("provenc").style.display    = '';
    document.getElementById("diaprox").style.display    = '';
  }

  js_trocatotal();

}

function js_di(){

  document.form1.dv05_numtot.value='1';
  document.getElementById("provenc").style.display = 'none';
  document.getElementById("diaprox").style.display = 'none';
}

</script>
<?
if ( $db_opcao == 1 ) {
  $p = 5;
} elseif ( $db_opcao == 2 || $db_opcao == 22 ) {
  $p = 6;
}else{
  $p = 7;
}
?>
<form class="container" name="form1" method="post" action="dvr3_diversos00<?=$p?>.php">

  <input type="hidden" name="tipo" value="<?=@$tipo?>">
  <input type="hidden" name="valor" value="<?=@$valor?>">
  <input type="hidden" name="dv05_numpre" value="<?=@$dv05_numpre?>">

  <fieldset>
    <legend>Cadastro de diversos</legend>
    <table class="form-container">
      <tr>
        <td nowrap title="<?=@$Tdv05_coddiver?>">
          <?db_input('subtes',10,2,true,'hidden',1)?>
          <?=@$Ldv05_coddiver?>
        </td>
        <td>
         <?
          db_input('dv05_coddiver', 10, $Idv05_coddiver, true, 'text', 3, "", "")
         ?>
        </td>
      </tr>

      <tr>
        <td nowrap title="<?=@$Tdv05_numcgm?>">
          <?
           db_ancora(@$Ldv05_numcgm,"",3);
          ?>
        </td>
        <td nowrap>
          <?
           db_input('dv05_numcgm', 10,$Idv05_numcgm, true, 'text', 3, " onchange='js_pesquisadv05_numcgm(false);'");
           db_input('z01_nome', 40,$Iz01_nome, true, 'text', 3, '')
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tdv05_dtinsc?>">
          <?=@$Ldv05_dtinsc?>
        </td>
        <td>
        <?
          if( !isset($dv05_dtinsc_dia) && $db_opcao == 1 ) {

            $dv05_dtinsc_dia = $dia;
            $dv05_dtinsc_mes = $mes;
            $dv05_dtinsc_ano = $ano;
          }

          db_inputdata('dv05_dtinsc', @$dv05_dtinsc_dia, @$dv05_dtinsc_mes, @$dv05_dtinsc_ano, true, 'text', $db_opcao)
        ?>
      </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tdv05_exerc?>">
           <?=@$Ldv05_exerc?>
        </td>
        <td>
           <?
           if (!isset($dv05_exerc) && $db_opcao==1) {
             $dv05_exerc = db_getsession("DB_anousu");
           }
           db_input('dv05_exerc',10,$Idv05_exerc,true,'text',"");
           ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <fieldset class="separator">
            <Legend>Cálculo do valor total</Legend>
            <table class="form-container">
              <tr>
                <td nowrap title="<?=@$Tdv05_procdiver?>">
                  <? db_ancora($Ldv05_procdiver,"js_pesquisaProcedencia(true)",$db_opcao); ?>
                </td>
                <td nowrap>
                  <?
                    db_input('dv05_procdiver',10,$Idv05_vlrhis,true,'text',$db_opcao,"onChange = \"js_pesquisaProcedencia(false);\"");
                    db_input('dv09_descr',44,$Idv05_vlrhis,true,'text',3);
                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?=@$Tdv05_privenc?>">
                  <?=@$Ldv05_privenc?>
                </td>
                <td>
                  <?
                  if  ( !isset($dv05_privenc_dia) && $db_opcao == 1 ) {
                    $dv05_privenc_dia = $dia;
                    $dv05_privenc_mes = $mes;
                    $dv05_privenc_ano = $ano;
                  }
                  db_inputdata('dv05_privenc', @$dv05_privenc_dia, @$dv05_privenc_mes, @$dv05_privenc_ano, true, 'text', $db_opcao, "");
                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?=@$Tdv05_vlrhis?>">
                  <?=@$Ldv05_vlrhis?>
                </td>
                <td>
                  <?
                    db_input('dv05_vlrhis',10,$Idv05_vlrhis,true,'text',$db_opcao);
                  ?>
                  <input type="button" name="calcula" onclick="js_sub(this)" value="Calcular"<?=($db_opcao==22 || $db_opcao==33 || $db_opcao==3?"disabled":"")?>>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?=@$Ti02_codigo?>">
                  <?=@$Li02_codigo?>
                </td>
                <td>
                  <?
                  if ( isset($subtes) && $subtes == "ok" && !isset($chavepesquisa) ) {

                    $oper        = $dv05_oper_ano."-".$dv05_oper_mes."-".$dv05_oper_dia;
                    $venc        = $dv05_privenc_ano."-".$dv05_privenc_mes."-".$dv05_privenc_dia;
                    $result03    = db_query("select tabrecjm.k02_corr,
                                                    procdiver.dv09_receit
                                               from procdiver
                                                    inner join tabrec   on tabrec.k02_codigo  = procdiver.dv09_receit
                                                    inner join tabrecjm on tabrecjm.k02_codjm = tabrec.k02_codjm
                                              where procdiver.dv09_procdiver = $dv05_procdiver");

                    db_fieldsmemory($result03, 0);

                    $i02_codigo  = $k02_corr;
                    $result08    = db_query("select fc_corre($dv09_receit, '$oper', $dv05_vlrhis, '".date('Y-m-d',db_getsession("DB_datausu"))."', ".db_getsession("DB_anousu").", '$venc')");
                    db_fieldsmemory($result08, 0);

                    if ( $fc_corre=="-1" ) {
                      $xxx="ok";
                    } else {
                      $dv05_valor = $fc_corre;
                    }
                  }
                  db_input('i02_codigo',10,$Ii02_codigo,true,'text',3)
                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?=@$Tdv05_oper?>">
                 <?=@$Ldv05_oper?>
                </td>
                <td>
                  <?
                    if(empty($dv05_oper_dia) && $db_opcao==1){
                      $dv05_oper_dia=$dia;
                      $dv05_oper_mes=$mes;
                      $dv05_oper_ano=$ano;
                    }
                    db_inputdata('dv05_oper',@$dv05_oper_dia,@$dv05_oper_mes,@$dv05_oper_ano,true,'text',$db_opcao,"")
                  ?>
                </td>
              </tr>

              <tr>
                <td nowrap title="<?=@$Tdv05_valor?>">
                  <?=@$Ldv05_valor?>
                </td>
                <td>
                  <?
                    db_input('dv05_valor',10,$Idv05_valor,true,'text',$db_opcao,"onchange='js_trocatotal();'")
                  ?>
                  <b id="total">&nbsp;</b>
                </td>
              </tr>
            </table>
          </fieldset>
        </td>
      </tr>

      <tr>
        <td nowrap title="<?=@$Tdv05_numtot?>">
           <?=@$Ldv05_numtot?>
        </td>
        <td>
          <?
            db_input('dv05_numtot', 10, $Idv05_numtot, true, 'text', $db_opcao, "onchange = 'js_trocatot(this);'");
          ?>
        </td>
      </tr>

      <tr id="provenc">
        <td nowrap title="<?=@$Tdv05_provenc?>">
          <?=@$Ldv05_provenc?>
        </td>
        <td>
           <? db_inputdata('dv05_provenc',@$dv05_provenc_dia,@$dv05_provenc_mes,@$dv05_provenc_ano,true,'text',$db_opcao) ?>
        </td>
      </tr>

      <tr id="diaprox">
        <td nowrap title="<?=@$Tdv05_diaprox?>">
          <?=@$Ldv05_diaprox?>
        </td>
        <td >
          <? db_input('dv05_diaprox', 10, $Idv05_diaprox, true, 'text', $db_opcao) ?>
        </td>
      </tr>

      <tr>
        <td colspan="2" title="<?=@$Tdv05_obs?>">
          <fieldset class="separator">
            <legend><?=@$Ldv05_obs?></legend>
            <? db_textarea('dv05_obs', 10, 73, $Idv05_obs, true, 'text', $db_opcao, "") ?>
          </fieldset>
        </td>
      </tr>

    </table>
    </fieldset>
  <input name="db_opcao"  type="submit" id="db_opcao"  value="<?=($db_opcao==1?"Incluir":($db_opcao==2 || $db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>  <?=($db_opcao!=3?"onclick='return js_verifica();'":"")?> >
  <input name="enviar" type="<?=($db_opcao==1?"hidden":"button")?>" id="emite-recibo-diverso-button" value="Recibo"    onclick="js_emiteRecibo();" >
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar"    onclick="js_pesquisa();" >
  <input name="novo-diverso" type="<?=($db_opcao==1?"hidden":"button")?>" id="novo-diverso" value="Novo" onclick="js_novoDiverso();">
  <input name="voltar"    type="button" id="voltar"    value="Voltar"       onclick="js_volta();" >

</form>

<script>

  function js_emiteRecibo() {

    form = document.form1;

    //montando objeto oParam para requisição post cai3_emitecarne.RPC.php
    oParam = new Object();
    
    oParam.exec = "validaRecibo";
    oParam.lNovoRecibo = true;

    oParam.oDadosForm  = document.form1.serialize(true);

    oParam.oDadosForm["H_ANOUSU"] = "<?=db_getsession("DB_anousu")?>";

    oParam.oDadosForm["H_DATAUSU"] = "<?=db_getsession("DB_datausu")?>";

    oParam.oDadosForm["datausu"] = "<?=date("Y-m-d",db_getsession("DB_datausu"))?>";

    // forcar vencimento
    oParam.oDadosForm.forcarvencimento = 'false';

    // data da operação d/m/Y
    oParam.oDadosForm.k00_dtoper = form.dv05_oper.value;

    oParam.oDadosForm.k00_formemissao = 2;

    //numpre
    oParam.oDadosForm.k00_numpre = form.dv05_numpre.value;
    
    oParam.oDadosForm.k03_parcelamento = "f";

    oParam.oDadosForm.k03_permparc = "t";

    //diverso é sempre grupo 7
    oParam.oDadosForm.k03_tipo = 7;

    //tipo_debito é uma coluna dv09_tipo da tabela procdiver que é relacionada com a coluna dv05_procdiver da tabela diversos
     
    oParam.oDadosForm.tipo_debito = "<?=$Idv09_tipo?>";
    oParam.oDadosForm.tipo= "<?=$Idv09_tipo?>"; 

    // processar desconto recibo
    oParam.oDadosForm.processarDescontoRecibo ='false';

    //verifica numcgm
    oParam.oDadosForm.ver_numcgm = form.dv05_numcgm.value;

    //cai3_emitecarne.RPC.php só aceita formulário de checkboxes
    oParam.oDadosForm["CHECK0"] = "N"+form.dv05_numpre.value+"P1R0";

    oParam.oDadosForm["_VALORES0"] = form.dv05_valor.value;

    var oAjax2 = new Ajax.Request("cai3_emitecarne.RPC.php",
      {
        method: 'post',
        parameters: 'json=' + Object.toJSON(oParam),
        onComplete:
          function (oAjax2) {

            var oRetorno = eval("(" + oAjax2.responseText + ")");
            oParam.oDadosForm.k00_numpre = oRetorno.aNumpresForm[0];
            var sMsg = oRetorno.message.urlDecode().replace("/\\n/g", "\n");
            if (oRetorno.status == 2) {
              alert(sMsg);
            } else {      
              js_emiteReciboCarne(oParam, true);
              
            }
          }
      });

    function js_emiteReciboCarne(oParam, lNovoRecibo, lForcajanela) {
      js_divCarregando('Processando...', 'msgBox');
      oParam.exec = "geraRecibo_Carne";
      oParam.lNovoRecibo = lNovoRecibo;
      var oAjax = new Ajax.Request("cai3_emitecarne.RPC.php",
          {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete:
              function (oAjax) {
                js_removeObj('msgBox');
                var oRetorno = eval("(" + oAjax.responseText + ")");
                if (oRetorno.status == 2) {

                  alert(oRetorno.message.urlDecode().replace("/\\n/gm", "\n"));

                } else {
                  var lMostra = true;
                  
                  var sUrl = 'cai3_emiterecibo.php?json=' + Object.toJSON(oRetorno);

                  if ((oRetorno.recibos_emitidos.length == 1 && oRetorno.aSessoesCarne.length == '0') && !lForcajanela) {
                    sUrl = 'cai3_gerfinanc003.php';
                    sUrl += '?numcgm=' + oParam.oDadosForm.ver_numcgm;
                    sUrl += '&tipo=' + oParam.oDadosForm.tipo_debito;
                    sUrl += '&emrec=t&agnum=t&agpar=f&certidao=&k03_tipo='+oParam.oDadosForm.k03_tipo;
                    sUrl += '&perfil_procuradoria=1';
                    sUrl += '&k00_tipo=' + oParam.oDadosForm.tipo_debito;
                    sUrl += '&db_datausu=' + oParam.oDadosForm["datausu"];
                    sUrl += '&sessao=' + oRetorno.aSessoesRecibo[0];
                    sUrl += '&reemite_recibo=true';
                    sUrl += '&forcarvencimento=' + oParam.oDadosForm.forcarvencimento;
                    sUrl += '&k03_numpre=' + oRetorno.recibos_emitidos[0];
                    sUrl += '&k03_numnov=' + oRetorno.recibos_emitidos[0];
                  
                    oJanela = window.open(sUrl, 'reciboweb2', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
                    
                    oJanela.moveTo(0, 0);
                  
                  } else if (((oRetorno.recibos_emitidos.length == 0 || oRetorno.aSessoesRecibo.length == 0) && oRetorno.aSessoesCarne.length == 1) && !lForcajanela) {
                  
                    sUrl = 'cai3_gerfinanc033.php' + debitos.location.search + '&sessao=' + oRetorno.aSessoesCarne[0];
                    oJanela = window.open(sUrl, 'reciboweb2', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
                    oJanela.moveTo(0, 0);

                  } else if (((oRetorno.recibos_emitidos.length == 0 || oRetorno.aSessoesRecibo.length == 0) && oRetorno.aSessoesCarne.length == 0)) {
                    //TO-DO: Para refactor: este else if está completamente vazio(??)
                  } else {
                    /**
                     * Cria Janela
                     */
                    var windowEmissao = new windowAux('janelaRecibo', 'Emissão de Recibos / Carnês', screen.availWidth - 40, 550);
                    windowEmissao.setContent("<div id='messageRecibo'></div><div id='conteudoRecibo'></div>");
                    windowEmissao.setShutDownFunction(function () {
                      document.body.removeChild(document.getElementById('janelaRecibo'));
                    });
                    windowEmissao.show(25, 10);

                    var oMessageBoard = new DBMessageBoard('msgboard1', 'Impressão de Recibos/ Carnês', 'Clique no botão emitir no carnê ou recibo selecionado. ', $('messageRecibo'));
                    oMessageBoard.show();
                    var oIframeConteudo = document.createElement("iframe");
                    oIframeConteudo.src = sUrl;
                    oIframeConteudo.frameBorder = 0;
                    oIframeConteudo.id = 'db_iframe_recibos';
                    oIframeConteudo.name = 'db_iframe_recibos';
                    oIframeConteudo.scrolling = 'auto';
                    oIframeConteudo.width = (screen.availWidth - 50) + 'px';
                    var Altura = $('janelaRecibo').clientHeight - $('msgboard1').clientHeight - 35;
                    oIframeConteudo.height = Altura + 'px';

                    $('conteudoRecibo').appendChild(oIframeConteudo);
                  }
                }
              }
          }
        );
        if ((elem = debitos.document.getElementById("geracarne"))) {
          elem.parentNode.removeChild(elem);
        }
      }

  }

  function js_pesquisaProcedencia(lMostra){

    if (lMostra) {

      js_OpenJanelaIframe('',
                          'db_iframe_procedencia',
                          'func_procdiver.php?funcao_js=parent.js_mostraProcedencia1|dv09_procdiver|dv09_descr',
                          'Pesquisar CGM',
                          true);
    } else {

      if($('dv05_procdiver').value != ''){
        js_OpenJanelaIframe('',
                            'db_iframe_procedencia',
                            'func_procdiver.php?pesquisa_chave=' + document.getElementById("dv05_procdiver").value +
                            '&funcao_js=parent.js_mostraProcedencia',
                            'Pesquisa',
                            false);
      } else {
        $("dv05_procdiver").value = '';
      }
    }
  }

  function js_mostraProcedencia(chave, erro){
    if (erro == true) {

      $('dv05_procdiver').focus();
      $("dv05_procdiver").value = '';
      $('dv09_descr')    .value = chave;

    } else {
      $('dv09_descr').value = chave;
    }
  }

  function js_mostraProcedencia1(iCodigoProcedencia, sDescricaoProcedencia) {

    $('dv05_procdiver').value   = iCodigoProcedencia;
    $('dv09_descr').value       = sDescricaoProcedencia;
    db_iframe_procedencia.hide();
  }


  function js_volta() {
    location.href = "dvr3_diversos00<?=($db_opcao == 2 ? 6 : 4) ?>.php";
  }
  <?
  echo "js_trocatotal();";

  if( isset($xxx) && $xxx == "ok" && !isset($HTTP_POST_VARS["db_opcao"])) {
    $sMsg = _M('tributario.diversos.db_frmdiversosalt.informe_valor_corrigido_total');
    echo "
      function js_xxx(){
          document.form1.dv05_valor.value='';
          document.form1.dv05_valor.focus();
            alert({$sMsg});
    }
    js_xxx();
    ";
  }
  ?>
  function js_pesquisa(){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe','func_diversos.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
  }
  function js_preenchepesquisa(chave) {

    db_iframe.hide();
    <? if ( $db_opcao !=1 ){ ?>
      location.href = '<?= basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>'+"?chavepesquisa=" + chave;
    <? }  ?>
  }

</script>

<?
  if ( (!isset($dv05_numtot) || $dv05_numtot < 2 ) && $db_opcao != 22 && $db_opcao != 33 ){
    echo "<script>js_di();</script>";
  }
?>
<script>

$("dv05_coddiver").addClassName("field-size2");
$("dv05_numcgm").addClassName("field-size2");
$("z01_nome").addClassName("field-size7");
$("dv05_dtinsc").addClassName("field-size2");
$("dv05_exerc").addClassName("field-size2");
$("dv05_procdiver").addClassName("field-size2");
$("dv09_descr").addClassName("field-size7");
$("dv05_privenc").addClassName("field-size2");
$("dv05_vlrhis").addClassName("field-size2");
$("i02_codigo").addClassName("field-size2");
$("dv05_oper").addClassName("field-size2");
$("dv05_valor").addClassName("field-size2");
$("dv05_numtot").addClassName("field-size2");
$("dv05_provenc").addClassName("field-size2");
$("dv05_diaprox").addClassName("field-size2");
</script>
