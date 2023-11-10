<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

//MODULO: patrimonio
$clcfpatriinstituicao->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("nomeinst");

include("conectaAPI.php");//chamando a conexão com a API

?>

<form class="container" name="form1" method="post" action="">
  <fieldset>
    <legend>Depreciação</legend>
    <table class="form-container">
      <tr style="display: none;">
        <td nowrap title="<?=@$Tt59_sequencial?>">
          <?=@$Lt59_sequencial?>
        </td>
        <td>
          <?
            db_input('t59_sequencial',10,$It59_sequencial,true,'text',3,"")
          ?>
        </td>
      </tr>
      <tr style="display: none;">
        <td nowrap title="<?=@$Tt59_instituicao?>">
          <?
            db_ancora(@$Lt59_instituicao,"js_pesquisat59_instituicao(true);",$db_opcao);
          ?>
        </td>
        <td>
          <?
            db_input('t59_instituicao',10,$It59_instituicao,true,'text',$db_opcao," onchange='js_pesquisat59_instituicao(false);'")
          ?>
          <?
            db_input('nomeinst',80,$Inomeinst,true,'text',3,'')
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tt59_dataimplanatacaodepreciacao?>">
          Data da implantação:
        </td>
        <td>
          <?
            db_inputdata('t59_dataimplanatacaodepreciacao',
                         @$t59_dataimplanatacaodepreciacao_dia,
                         @$t59_dataimplanatacaodepreciacao_mes,
                         @$t59_dataimplanatacaodepreciacao_ano,
                         true,
                         'text',
                         $iOpcaoDataDepreciacao,
                         "");
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="">
          Termo de Guarda - Template Padrão:
        </td>
        <td>
        <?
          db_select('t59_termodeguarda', array("f"=>"Não","t"=>"Sim"), true, "", "");
        ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <p>
  
  
  <fieldset>
    <legend>Integração API patrimonial </legend>
    <table class="form-container">
    <tr>
                <td nowrap title="">
                  Login:
                </td>
                <td>
                  <?php
                    db_input('t59_usuarioapi',20,$It59_usuarioapi,true,'text',$db_opcao,"")
                  ?>
                </td>
    </tr>
    <tr>
                <td nowrap title="">
                  Senha:
                </td>
                <td style="font-weight:bold;">
                  <?
                    db_input('t59_senhaapi',20,$It59_senhaapi,true,'password',$db_opcao);
                  ?>
                </td>
    </tr>  
    <tr style="display: none;">
                <td nowrap title="">
                  token:
                </td>
                <td style="font-weight:bold;">
                  <?
                    db_input('t59_tokenapi',20,$It59_tokenapi,true,'password',$db_opcao);
                  ?>
                </td>
    </tr>  
    <tr>
                <td nowrap title="">
                Endereço da API:
                </td>
                <td>
                  <?php
                    db_input('t59_enderecoapi',50,$It59_enderecoapi,true,'text',$db_opcao,"")
                  ?>
                </td>
    </tr>               
      <tr>
              <td nowrap title="">
                Ativação da Integração:
              </td>
              <td>
                    <?php
                     db_select('t59_ativo', array("f"=>"Desativado","t"=>"Ativado"), true, "", "onchange='ativaAPI()'");
                    ?>
                                            
              </td>
      </tr>
      <tr>
          <td nowrap title="">
            Status:
          </td>
          <td>
              <input name="verifica" type="button" onclick='statusAPI()' id="verifica" value="Verificar o Status da Conexão">
          </td>
      </tr>
      </table>
  </fieldset>  
  <p>
  <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> onclick="validarAutenticacao()" >
  <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="botao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Gerar Token":"Excluir"))?>" onclick="validarAutenticacao()" >
  <?php
    if ($db_opcao == 22) {
      db_redireciona("pat1_cfpatriinstituicao002.php?chavepesquisa=".$t59_sequencial);
    }
  ?>
</form>
<script>
function js_pesquisat59_instituicao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_config','func_db_config.php?funcao_js=parent.js_mostradb_config1|codigo|nomeinst','Pesquisa',true);
  }else{
     if(document.form1.t59_instituicao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_config','func_db_config.php?pesquisa_chave='+document.form1.t59_instituicao.value+'&funcao_js=parent.js_mostradb_config','Pesquisa',false);
     }else{
       document.form1.nomeinst.value = '';
     }
  }
}
function js_mostradb_config(chave,erro){
  document.form1.nomeinst.value = chave;
  if(erro==true){
    document.form1.t59_instituicao.focus();
    document.form1.t59_instituicao.value = '';
  }
}
function js_mostradb_config1(chave1,chave2){
  document.form1.t59_instituicao.value = chave1;
  document.form1.nomeinst.value = chave2;
  db_iframe_db_config.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cfpatriinstituicao','func_cfpatriinstituicao.php?funcao_js=parent.js_preenchepesquisa|t59_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_cfpatriinstituicao.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
function ativaAPI(){
     if(document.form1.t59_ativo.value == '0'){
      alert("Escolha se Deseja Ativar ou Desativar a API")
      return
    }
    if(document.form1.t59_ativo.value == 't'){
      var x;
      var r=confirm("Deseja Ativar a API!");
      if (r!=true){
        x="Você Cancelou A Ativação!";
        document.form1.t59_ativo.value = 'f';
        }
    }
    if(document.form1.t59_ativo.value == 'f'){
      var x;
      var r=confirm("Se desativar a API, a sicronização dos dados deixará de acontecer!");
      if (r!=true){
        x="Você Cancelou A Desativação!";
        document.form1.t59_ativo.value = 't';
        } 
      else{
        document.form1.t59_tokenapi.value  = '';
        document.getElementById("botao").disabled = true;
      }  
    }
    if(document.form1.t59_ativo.value == 't'){
    if(document.form1.t59_usuarioapi.value == ''){
      document.form1.t59_ativo.value = 'f';
      alert("Campo Login Necessário para Ativar a Integração")
      return;
    }
    if(document.form1.t59_senhaapi.value == ''){
      document.form1.t59_ativo.value = 'f';
      alert("Campo Senha Necessário para Ativar a Integração")
      return;
    }
    if(document.form1.t59_enderecoapi.value == ''){
      document.form1.t59_ativo.value = 'f';
      alert("Campo Endereço da API Necessário para Ativar a Integração")
      return;
    }
  }
}
function statusAPI(){
  var status = "<?php print $decode['status']; ?>";
  var msg    = "<?php print $decode['msg']; ?>";
  if(status == 'success'){
     alert(msg)
  }
  if(status == 'error'){
     alert(msg)
  }  
  if(msg == ''){
     alert('Api Não Conectada')
     return;
  }  

}
//Validação de campos da API
function validarAutenticacao(){
  if(document.form1.t59_tokenapi.value){
    document.getElementById("botao").disabled = false; 
  }
  if(document.form1.t59_ativo.value == 't'){
    if(document.form1.t59_usuarioapi.value == ''){
      alert("Campo Login Necessário para Ativar a Integração")
      return;
    }
    if(document.form1.t59_senhaapi.value == ''){
      alert("Campo Senha Necessário para Ativar a Integração")
      return;
    }
    if(document.form1.t59_enderecoapi.value == ''){
      alert("Campo Endereço da API Necessário para Ativar a Integração")
      return;
    }
  }
  
}
$('t59_usuarioapi').style.width ='100%';
$('t59_senhaapi').style.width ='100%';
$('t59_enderecoapi').style.width ='100%';
$('t59_ativo').style.width ='100%';
$('verifica').style.width ='100%';
$("t59_dataimplanatacaodepreciacao").style.width ='90%';
$("t59_termodeguarda").style.width ='90%';

if(!document.form1.t59_tokenapi.value){
    document.getElementById("botao").disabled = true; 
  }
</script>
<script>

$("t59_dataimplanatacaodepreciacao").addClassName("field-size2");

</script>
