<?
//MODULO: sicom
$clpublicacaoeperiodicidaderreo->rotulo->label();
?>
<form name="form1" method="post" action="">

  <table border="0" align="left" >
    <tr>
      <td>

        <table>

          <tr>
            <td nowrap >
             <b>Houve publicação do RREO:</b>
           </td>
           <td>
            <?
            $x = array("0"=>"Selecione","1"=>"SIM","2"=>"NÃO");
            db_select('c220_publiclrf',$x,true,1,"onchange='js_escondeCampos()'");
            ?>
          </td>
        </tr>

      </tr>



      <tr <?php if($db_opcao == 1): ?>style="display:none;" <?php endif; ?> id="data">
        <td nowrap >
         <b>Data da Publicação do RREO:</b>
       </td>
       <td>
        <?
        db_inputdata('c220_dtpublicacaorelatoriolrf',"","","",true,'text',$db_opcao,""); ?>
      </td>
    </tr>

    <tr <?php if($db_opcao == 1): ?>style="display:none;" <?php endif; ?> id="local">
      <td nowrap >
       <b>Local da Publicação da RREO:</b>
     </td>
     <td>
      <?
      db_input('c220_localpublicacao',80,'',true,'text',$db_opcao,"","","","",1000)
      ?>
    </td>
  </tr>
  <tr <?php if($db_opcao == 1): ?>style="display:none;" <?php endif; ?> id="bimestre">
    <td nowrap >
      <b>Bimestre a que se refere a publicação do RREO:</b>
    </td>
    <td>
      <?
      $x = array(
        "0"=>"Selecione",
        "1"=>"Primeiro Bimestre",
        "2"=>"Segundo Bimestre",
        "3"=>"Terceiro Bimestre",
        "4"=>"Quarto Bimestre",
        "5"=>"Quinto Bimestre",
        "6"=>"Sexto Bimestre",

        );
      db_select('c220_tpbimestre',$x,true,1,"");
      ?>
    </td>
  </tr>
  <tr <?php if($db_opcao == 1): ?>style="display:none;" <?php endif; ?> id="exercicio">
    <td nowrap >
      <b>Exercício a que se refere a publicação do RREO:</b>
    </td>
    <td>
      <?
      db_input('c220_exerciciotpbimestre',14,$Ic220_exerciciotpbimestre,true,'text',$db_opcao,"", "", "", "",4)
      ?>
    </td>
  </tr>


</table>
<center>
  <br>
  <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="button" id="db_opcao" value="<?=($db_opcao==1?"Próximo":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> onclick="js_incluirDados();" >

</center>
</td>
</tr>
</table>
</form>
<script>

  function js_incluirDados(){
    if(document.form1.c220_publiclrf.value == "0"){
      alert('O campo "Houve publicação do RREO" não foi preenchido.');
      return false;
    }else{
      if(document.form1.c220_publiclrf.value == "1"){
        if(document.form1.c220_dtpublicacaorelatoriolrf.value == ""){
          alert('O campo "Data de publicação do RREO da LRF" não foi preenchido.');
          return false;
        }
        if(document.form1.c220_localpublicacao.value == ""){
          alert('O campo "Onde foi dada a publicidade do RREO" não foi preenchido.');
          return false;
        }
        if(document.form1.c220_tpbimestre.value == "0"){
          alert('O campo "Bimestre a que se refere a data de publicação do RREO da LRF" não foi preenchido.');
          return false;
        }
        if(document.form1.c220_exerciciotpbimestre.value == ""){
          alert('O campo "Exercício a que se refere o período da publicação do RREO da LRF" não foi preenchido.');
          return false;
        }
      }
    }

    CurrentWindow.corpo.publicacaoeperiodicidaderreo.c220_publiclrf = document.form1.c220_publiclrf.value;
    CurrentWindow.corpo.publicacaoeperiodicidaderreo.c220_dtpublicacaorelatoriolrf = document.form1.c220_dtpublicacaorelatoriolrf.value;
    CurrentWindow.corpo.publicacaoeperiodicidaderreo.c220_localpublicacao = document.form1.c220_localpublicacao.value;
    CurrentWindow.corpo.publicacaoeperiodicidaderreo.c220_tpbimestre = document.form1.c220_tpbimestre.value;
    CurrentWindow.corpo.publicacaoeperiodicidaderreo.c220_exerciciotpbimestre = document.form1.c220_exerciciotpbimestre.value;

    parent.mo_camada('publicacaoeperiodicidadergf');

  }

  function js_pesquisa(){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_dadoscomplementareslrf','func_dadoscomplementareslrf.php?funcao_js=parent.js_preenchepesquisa|si170_sequencial','Pesquisa',true);
  }
  function js_preenchepesquisa(chave){
    db_iframe_dadoscomplementareslrf.hide();
    <?
    if($db_opcao!=1){
      echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
    }
    ?>
  }
  function js_escondeCampos(){
    if(document.form1.c220_publiclrf.value == "1"){
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
</script>
