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
      db_input('c221_localpublicacaorgf',80,0,true,'text',$db_opcao,"")
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
      document.getElementById('local').style.display="none";
      document.getElementById('bimestre').style.display="none";
      document.getElementById('exercicio').style.display="none";

    }
  }
  function js_incluirDados(){

   var oParametros = new Object();

   <?php if($db_opcao == 3): ?>
     oParametros.exec = 'excluirDados';
     <?php else: ?>
       oParametros.exec = 'salvarDados';
       <?php if($db_opcao == 1): ?>
        oParametros.alteracao = false;
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
      if(top.corpo.dadoscomplementares.c218_mesusu == "0"){
        alert('O campo "Mês de Referência" não foi preenchido.');
        return false;
      }
          <?php if(db_getsession("DB_instit") == 1): ?>
      if(top.corpo.dadoscomplementares.c218_metarrecada == "0" && (top.corpo.dadoscomplementares.c218_mesusu % 2) == 0){
        alert('O campo "A meta bimestral de arrecadação foi cumprida" não foi preenchido.');
        return false;
      }    <?php endif; ?>
      if(top.corpo.dadoscomplementares.c218_metarrecada == "2"){
        if(top.corpo.dadoscomplementares.c218_dscmedidasadotadas == ""){
          alert('O campo "Medidas adotadas e a adotar" não foi preenchido.');
          return false;
        }
      }
      <?php if(db_getsession('DB_instit') == 1): ?>
    // SÓ VALIDA OPERACOES DE CREDITO SE A INSTITUIÇÃO FOR PREFEITURA
    // E O MES DE REFERENCIA FOR DEZEMBRO
    if(top.corpo.dadoscomplementares.c218_mesusu == "12"){
     if(top.corpo.operacoesdecredito.c219_contopcredito == "0"){
      alert('O campo "Contratação de Operação que não atendeu limites Art. 33 LC 101/2000" não foi preenchido.');
      return false;
    }
    if(top.corpo.operacoesdecredito.c219_realizopcredito == "0"){
      alert('O campo "Realização de Operações de crédito vedadas pelo Art. 37 LC 101/2000" não foi preenchido.');
      return false;
    }
    if(top.corpo.operacoesdecredito.c219_tiporealizopcreditocapta == "0"){
      alert('O campo "Tipo de realização de operações de crédito vedada (Captação)" não foi preenchido.');
      return false;
    }
    if(top.corpo.operacoesdecredito.c219_tiporealizopcreditoreceb == "0"){
      alert('O campo "Tipo de realização de operações de crédito vedada (Recebimento)" não foi preenchido.');
      return false;
    }
    if(top.corpo.operacoesdecredito.c219_tiporealizopcreditoassundir == "0"){
      alert('O campo "Tipo de realização de operações de crédito vedada (Assução direta)" não foi preenchido.');
      return false;
    }
    if(top.corpo.operacoesdecredito.c219_tiporealizopcreditoassunobg == "0"){
      alert('O campo "Tipo de realização de operações de crédito vedada (Assução de obrigação)" não foi preenchido.');
      return false;
    }
  }
    // VALIDA A ABA PUBLICACAO E PERIODICIDADE RREO
    if(top.corpo.publicacaoeperiodicidaderreo.c220_publiclrf == "0"){
      alert('O campo "Houve publicação do RREO" não foi preenchido.');
      return false;
    }else{
      if(top.corpo.publicacaoeperiodicidaderreo.c220_publiclrf == "1"){
        if(top.corpo.publicacaoeperiodicidaderreo.c220_dtpublicacaorelatoriolrf == ""){
          alert('O campo "Data de publicação do RREO da LRF" não foi preenchido.');
          return false;
        }
        if(top.corpo.publicacaoeperiodicidaderreo.c220_localpublicacao == ""){
          alert('O campo "Onde foi dada a publicidade do RREO" não foi preenchido.');
          return false;
        }
        if(top.corpo.publicacaoeperiodicidaderreo.c220_tpbimestre == "0"){
          alert('O campo "Bimestre a que se refere a data de publicação do RREO da LRF" não foi preenchido.');
          return false;
        }
        if(top.corpo.publicacaoeperiodicidaderreo.c220_exerciciotpbimestre == ""){
          alert('O campo "Exercício a que se refere o período da publicação do RREO da LRF" não foi preenchido.');
          return false;
        }
      }
    }

  <?php endif; ?>



  top.corpo.dadoscomplementares.c218_mesusu = top.corpo.iframe_dadoscomplementares.document.form1.c218_mesusu.value;
  top.corpo.dadoscomplementares.c218_passivosreconhecidos = top.corpo.iframe_dadoscomplementares.document.form1.c218_passivosreconhecidos.value;
  top.corpo.dadoscomplementares.c218_vlsaldoatualconcgarantiainterna = top.corpo.iframe_dadoscomplementares.document.form1.c218_vlsaldoatualconcgarantiainterna.value;
  top.corpo.dadoscomplementares.c218_vlsaldoatualconcgarantia = top.corpo.iframe_dadoscomplementares.document.form1.c218_vlsaldoatualconcgarantia.value;
  top.corpo.dadoscomplementares.c218_vlsaldoatualcontragarantiainterna = top.corpo.iframe_dadoscomplementares.document.form1.c218_vlsaldoatualcontragarantiainterna.value;
  top.corpo.dadoscomplementares.c218_vlsaldoatualcontragarantiaexterna = top.corpo.iframe_dadoscomplementares.document.form1.c218_vlsaldoatualcontragarantiaexterna.value;
  top.corpo.dadoscomplementares.c218_medidascorretivas = top.corpo.iframe_dadoscomplementares.document.form1.c218_medidascorretivas.value;
  if(top.corpo.iframe_dadoscomplementares.document.form1.medidasCorretivas.value == 2){
    top.corpo.dadoscomplementares.c218_medidascorretivas = "";
  }
  top.corpo.dadoscomplementares.c218_recalieninvpermanente = top.corpo.iframe_dadoscomplementares.document.form1.c218_recalieninvpermanente.value;
  top.corpo.dadoscomplementares.c218_vldotatualizadaincentcontrib = top.corpo.iframe_dadoscomplementares.document.form1.c218_vldotatualizadaincentcontrib.value;
  top.corpo.dadoscomplementares.c218_vlempenhadoicentcontrib = top.corpo.iframe_dadoscomplementares.document.form1.c218_vlempenhadoicentcontrib.value;
  top.corpo.dadoscomplementares.c218_vldotatualizadaincentinstfinanc = top.corpo.iframe_dadoscomplementares.document.form1.c218_vldotatualizadaincentinstfinanc.value;
  top.corpo.dadoscomplementares.c218_vlempenhadoincentinstfinanc = top.corpo.iframe_dadoscomplementares.document.form1.c218_vlempenhadoincentinstfinanc.value;
  top.corpo.dadoscomplementares.c218_vlliqincentcontrib = top.corpo.iframe_dadoscomplementares.document.form1.c218_vlliqincentcontrib.value;
  top.corpo.dadoscomplementares.c218_vlliqincentinstfinanc = top.corpo.iframe_dadoscomplementares.document.form1.c218_vlliqincentinstfinanc.value;
  top.corpo.dadoscomplementares.c218_vlirpnpincentcontrib = top.corpo.iframe_dadoscomplementares.document.form1.c218_vlirpnpincentcontrib.value;
  top.corpo.dadoscomplementares.c218_vlirpnpincentinstfinanc = top.corpo.iframe_dadoscomplementares.document.form1.c218_vlirpnpincentinstfinanc.value;
  top.corpo.dadoscomplementares.c218_vlrecursosnaoaplicados = top.corpo.iframe_dadoscomplementares.document.form1.c218_vlrecursosnaoaplicados.value;
  top.corpo.dadoscomplementares.c218_vlapropiacaodepositosjudiciais = top.corpo.iframe_dadoscomplementares.document.form1.c218_vlapropiacaodepositosjudiciais.value;
  top.corpo.dadoscomplementares.c218_vloutrosajustes = top.corpo.iframe_dadoscomplementares.document.form1.c218_vloutrosajustes.value;
  top.corpo.dadoscomplementares.c218_metarrecada = top.corpo.iframe_dadoscomplementares.document.form1.c218_metarrecada.value;
  top.corpo.dadoscomplementares.c218_dscmedidasadotadas = top.corpo.iframe_dadoscomplementares.document.form1.c218_dscmedidasadotadas.value;
  if(top.corpo.iframe_dadoscomplementares.document.form1.c218_metarrecada.value == 1){
    top.corpo.dadoscomplementares.c218_dscmedidasadotadas = "";
  }
  top.corpo.operacoesdecredito.c219_contopcredito = top.corpo.iframe_operacoesdecredito.document.form1.c219_contopcredito.value;
  top.corpo.operacoesdecredito.c219_dsccontopcredito = top.corpo.iframe_operacoesdecredito.document.form1.c219_dsccontopcredito.value;
  top.corpo.operacoesdecredito.c219_realizopcredito = top.corpo.iframe_operacoesdecredito.document.form1.c219_realizopcredito.value;
  top.corpo.operacoesdecredito.c219_tiporealizopcreditocapta = top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditocapta.value;
  top.corpo.operacoesdecredito.c219_tiporealizopcreditoreceb = top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoreceb.value;
  top.corpo.operacoesdecredito.c219_tiporealizopcreditoassundir = top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoassundir.value;
  top.corpo.operacoesdecredito.c219_tiporealizopcreditoassunobg = top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoassunobg.value;

  top.corpo.publicacaoeperiodicidaderreo.c220_publiclrf = top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_publiclrf.value;
  top.corpo.publicacaoeperiodicidaderreo.c220_dtpublicacaorelatoriolrf = top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_dtpublicacaorelatoriolrf.value;
  top.corpo.publicacaoeperiodicidaderreo.c220_localpublicacao = top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_localpublicacao.value;
  top.corpo.publicacaoeperiodicidaderreo.c220_tpbimestre = top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_tpbimestre.value;
  top.corpo.publicacaoeperiodicidaderreo.c220_exerciciotpbimestre = top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_exerciciotpbimestre.value;

  top.corpo.publicacaoeperiodicidadergf.c221_publicrgf = document.form1.c221_publicrgf.value;
  top.corpo.publicacaoeperiodicidadergf.c221_dtpublicacaorelatoriorgf = document.form1.c221_dtpublicacaorelatoriorgf.value;
  top.corpo.publicacaoeperiodicidadergf.c221_localpublicacaorgf = document.form1.c221_localpublicacaorgf.value;
  top.corpo.publicacaoeperiodicidadergf.c221_tpperiodo = document.form1.c221_tpperiodo.value;
  top.corpo.publicacaoeperiodicidadergf.c221_exerciciotpperiodo = document.form1.c221_exerciciotpperiodo.value;

  oParametros.dadoscomplementares = top.corpo.dadoscomplementares;
  oParametros.operacoesdecredito = top.corpo.operacoesdecredito;
  oParametros.publicacaoeperiodicidaderreo = top.corpo.publicacaoeperiodicidaderreo;
  oParametros.publicacaoeperiodicidadergf = top.corpo.publicacaoeperiodicidadergf;


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
      top.corpo.location.href="sic1_dadoscomplementareslrf002.php?chave="+oRetorno.c218_sequencial;
      <?php else: ?>
        top.corpo.location.href="sic1_dadoscomplementareslrf003.php?chave="+oRetorno.c218_sequencial;
      <?php endif; ?>
    }
    return false;
  }
  function js_pesquisa(){
    js_OpenJanelaIframe('top.corpo','db_iframe_dadoscomplementareslrf','func_dadoscomplementareslrf.php?funcao_js=parent.js_preenchepesquisa|c218_sequencial','Pesquisa',true);
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
