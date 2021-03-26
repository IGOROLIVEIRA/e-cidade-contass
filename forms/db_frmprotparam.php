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

//MODULO: protocolo
$clprotparam->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("k06_descr");
$clrotulo->label("db82_descricao");
$clrotulo->label("p90_db_documentotemplate");
?>
<style type="text/css">
  #departamentosprot { width: 377px; }
</style>
<form name="form1" method="post" action="">
<center>
<table style="margin-top: 20px;"><tr><td>
  <fieldset><legend><b>Configuração de Parâmetros</b></legend>
  	<table border="0">
		  <tr>
		    <td nowrap align="right" title="<?=@$Tp90_emiterecib?>">
		    <input name="oid" type="hidden" value="<?=@$oid?>">
		       <?=@$Lp90_emiterecib?>
		    </td>
		    <td>
					<?
					$x = array('f'=>'Não','t'=>'Sim');
					db_select('p90_emiterecib',$x,true,$db_opcao,"");
					?>
		    </td>
		  </tr>
		  <tr>
		    <td nowrap align="right" title="<?=@$Tp90_alteracgmprot?>">
		       <?=@$Lp90_alteracgmprot?>
		    </td>
		    <td>
					<?
					$x = array('f'=>'Não','t'=>'Sim');
					db_select('p90_alteracgmprot',$x,true,$db_opcao,"");
					?>
		    </td>
		  </tr>
		  <tr>
		    <td nowrap align="right" title="<?=@$Tp90_valcpfcnpj?>">
		       <?=@$Lp90_valcpfcnpj?>
		    </td>
		    <td>
					<?
					$x = array('f'=>'Não','t'=>'Sim');
					db_select('p90_valcpfcnpj',$x,true,$db_opcao,"");
					?>
		    </td>
		  </tr>
		  <tr>
		    <td nowrap align="right" title="<?=@$Tp90_impusuproc?>">
		       <?=@$Lp90_impusuproc?>
		    </td>
		    <td>
					<?
					$x = array('f'=>'Não','t'=>'Sim');
					db_select('p90_impusuproc',$x,true,$db_opcao,"");
					?>
		    </td>
		  </tr>
		  <tr>
		    <td nowrap align="right" title="<?=@$Tp90_debiaber?>">
		       <?=@$Lp90_debiaber?>
		    </td>
		    <td>
					<?
					$x = array('f'=>'Não','t'=>'Sim');
					db_select('p90_debiaber',$x,true,$db_opcao,"");
					?>
		    </td>
		  </tr>
		  <tr>
		    <td nowrap  align="right" title="<?=@$Tp90_taxagrupo?>">
		       <?
		       db_ancora(@$Lp90_taxagrupo,"js_pesquisap90_taxagrupo(true);",$db_opcao);
		       ?>
		    </td>
		    <td>
					<?
					db_input('p90_taxagrupo',6,$Ip90_taxagrupo,true,'text',$db_opcao," onchange='js_pesquisap90_taxagrupo(false);'")
					?>
		      <?
		      db_input('k06_descr',50,$Ik06_descr,true,'text',3,'')
		      ?>
		    </td>
		  </tr>
		  <tr>
		    <td nowrap align="right" title="<?=@$Tp90_histpadcert?>">
		       <?=@$Lp90_histpadcert?>
		    </td>
		    <td>
				<?
				db_textarea('p90_histpadcert',0,56,$Ip90_histpadcert,true,'text',$db_opcao,"")
				?>
		    </td>
		  </tr>
		  <tr>
		    <td nowrap align="right" title="<?=@$Tp90_despachoob?>">
		       <?=@$Lp90_despachoob?>
		    </td>
		    <td>
				<?
				$x = array('t'=>'Sim','f'=>'Não');
				db_select('p90_despachoob',$x,true,$db_opcao);
				?>
		    </td>
		  </tr>
		  <tr>
		    <td nowrap align="right" title="<?=@$Tp90_minchardesp?>">
		    <?=@$Lp90_minchardesp?>
		    </td>
		    <td>
				<?
				db_input('p90_minchardesp',6,@$Ip90_minchardesp,true,'text',$db_opcao,"")
				?>
		    </td>
		  </tr>
		    <tr>
		    <td nowrap align="right" title="<?=@$Tp90_andatual?>">
		       <?=@$Lp90_andatual?>
		    </td>
		    <td>
				<?
				$x = array('f'=>'Não','t'=>'Sim');
				db_select('p90_andatual',$x,true,$db_opcao,"");
				?>
		    </td>
		  </tr>
		    <tr>
		    <td nowrap align="right" title="<?=@$Tp90_traminic?>">
		      <b>Tramite/transferencia: </b>
		    </td>
		    <td>
		     <?
		     $tra = array('1'=>'Permitir escolher departamentos diferentes',
		                  '2'=>'Não permitir escolher departamentos diferentes',
		                  '3'=>'Permitir escolher departamentos diferentes, mas avisar o usuário');
		     db_select('p90_traminic',$tra,true,$db_opcao,"");
		     ?>
		    </td>
		  </tr>
		 <tr>
		    <td nowrap align="right" title="<?=@$Tp90_modelcapaprocl?>">
		       <?=@$Lp90_modelcapaproc?>
		    </td>
		    <td>
				<?
				$x = array('0'=>'Modelo Padrão',
									 '1'=>'Modelo 1',
									 '2'=>'Modelo 2',
				           '3'=>'Documento Template');
				db_select('p90_modelcapaproc',$x,true,$db_opcao,"onchange='js_liberaDocumentoTemplate(this.value)'");
				?>
		    </td>
		  </tr>
   <tr id='documentoTemplate' style="display: <?=$templateOculta?>; text-align: right">

      <td nowrap="nowrap" title="<?=@$Tp90_db_documentotemplate?>">
        <?
          db_ancora(@$Lp90_db_documentotemplate,"js_pesquisaDocumento(true);",$db_opcao);
        ?>
      </td>
      <td nowrap="nowrap">
        <?
          db_input('p90_db_documentotemplate',10,$Ip90_db_documentotemplate,true,'text',$db_opcao,"onchange='js_pesquisaDocumento(false);'");
          db_input('db82_descricao',50,$Idb82_descricao,true,'text',3,'');
        ?>
      </td>
    </tr>
   <tr>
	   <td nowrap align="right" title="<?=@$Tp90_imprimevar?>">
		       <?=@$Lp90_imprimevar?>
		    </td>
		    <td>
				<?
				$x = array('f'=>'Não','t'=>'Sim');
				db_select('p90_imprimevar',$x,true,$db_opcao,"");
				?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tp90_impdepto?>" align="right">
      <?=@$Lp90_impdepto?>
    </td>
    <td>
    <?
    $x = array("f"=>"Não","t"=>"Sim");
    db_select('p90_impdepto',$x,true,$db_opcao,"");
    ?>
    </td>
  </tr>
  <!--OC6672-->
  <tr>
    <td nowrap title="<?=@$Tp90_autprotocolo?>" align="right">
      <?=@$Lp90_autprotocolo?>
    </td>
    <td>
    <?
    $x = array("f"=>"Não","t"=>"Sim");
    db_select('p90_autprotocolo',$x,true,$db_opcao,"onchange='mostraDepartamentos(this.value)'");
    ?>
    </td>
  </tr>
    <tr class="departProtocolos" style="display: none;">
      <td align="right"><strong>Origem:&nbsp;</strong></td>
      <td>
        <select style="width: 377px;" name="p109_coddeptoorigem" id="p109_coddeptoorigem">
          <option value="">SELECIONE...</option>
            <?php foreach ($aDepartamentos as $aDepartamento) : ?>
              <option value="<?= $aDepartamento->coddepto ?>">
                <?= $aDepartamento->coddepto." - ".$aDepartamento->descrdepto ?>
              </option>
            <?php endforeach; ?>
        </select>
      </td>
    </tr>
    <tr class="departProtocolos" style="display: none;">
      <td align="right"><strong class="formatstrong">Destino:&nbsp;</strong></td>
      <td>
        <select style="width: 377px;" name="p109_coddeptodestino" id="p109_coddeptodestino">
            <option value="" selected>SELECIONE...</option>
            <?php foreach ($aDepartamentos as $aDepartamento) : ?>
                <option value="<?= $aDepartamento->coddepto ?>">
                  <?= $aDepartamento->coddepto." - ".$aDepartamento->descrdepto ?>
                </option>
              <?php endforeach; ?>
        </select>
       </td>
    </tr>
    <tr class="departProtocolos" style="display: none;">
      <td align="right"><strong style="margin-left:-175px; position: absolute; margin-top:-55px;">Departamentos Configurados:&nbsp;</strong></td>
      <td>
          <select name="departamentosprot[]" class="departamentosprot" id="departamentosprot" size="6" multiple>
          </select>
      </td>
    </tr>
  </table>
</fieldset>
</td></tr>
</table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>

var departamentosprot = document.getElementById("departamentosprot");

function mostraDepartamentos(valor) {
  var departProtocolos = document.getElementsByClassName("departProtocolos");
  if (valor == "t") {
    for (i = 0; i < departProtocolos.length; i++) {
      departProtocolos[i].style.display = "";
    }
    var params = {
      exec: 'buscaDepartamentosConfig',
      instit: <?php echo db_getsession("DB_instit"); ?>
    };
    novoAjax(params, function(e) {

      var departamentos = JSON.parse(e.responseText).departamentos;
      departamentos.forEach(function(departamento, i) {
        var option = document.createElement('option');
        option.style.backgroundColor = (i % 2 == 0) ? '#dfe2ff' : '';
        option.value = departamento.p109_sequencial;
        option.innerHTML = "<span style='font-size=8px;'>"+departamento.origem + "  <strong>--></strong>  " + departamento.destino+"</span>";
        departamentosprot.appendChild(option);

      });
    });
  } else {
      for (i = 0; i < departProtocolos.length; i++) {
        departProtocolos[i].style.display = "none";
      }
  }
}

function novoAjax(params, onComplete) {

  var request = new Ajax.Request('pro4_protocolos.RPC.php', {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: onComplete
  });

}

departamentosprot.addEventListener('dblclick', function excluirConfigDepart(e) {
  var params = {
    exec: 'excluiDepartConfig',
    p109_sequencial: e.target.value
  };
  novoAjax(params, function(r) {
    var oRetorno = JSON.parse(r.responseText);
      if (oRetorno.status == 1) {
        departamentosprot.removeChild(e.target);
      } else {
          alert(oRetorno.erro);
        return;
      }
  });

});


function js_pesquisap90_taxagrupo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_taxagrupo','func_taxagrupo.php?funcao_js=parent.js_mostrataxagrupo1|k06_taxagrupo|k06_descr','Pesquisa',true);
  }else{
     if(document.form1.p90_taxagrupo.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_taxagrupo','func_taxagrupo.php?pesquisa_chave='+document.form1.p90_taxagrupo.value+'&funcao_js=parent.js_mostrataxagrupo','Pesquisa',false);
     }else{
       document.form1.k06_descr.value = '';
     }
  }
}
function js_mostrataxagrupo(chave,erro){
  document.form1.k06_descr.value = chave;
  if(erro==true){
    document.form1.p90_taxagrupo.focus();
    document.form1.p90_taxagrupo.value = '';
  }
}
function js_mostrataxagrupo1(chave1,chave2){
  document.form1.p90_taxagrupo.value = chave1;
  document.form1.k06_descr.value = chave2;
  db_iframe_taxagrupo.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_protparam','func_protparam.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_protparam.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_liberaDocumentoTemplate(modeloDoc) {

  if (modeloDoc == 3) {
    $('documentoTemplate').style.display = "table-row";
  } else {
    $('documentoTemplate').style.display = "none";
    $('p90_db_documentotemplate').value  = "";
  }

}

function js_pesquisaDocumento(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_documentotemplate','func_db_documentotemplate.php?funcao_js=parent.js_mostratemplatealvara1|db82_sequencial|db82_descricao&tipo=13','Pesquisa',true);
  }else{
     if(document.form1.q60_templatealvara.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_db_documentotemplate','func_db_documentotemplate.php?pesquisa_chave='+document.form1.q60_templatealvara.value+'&funcao_js=parent.js_mostratemplatealvara&tipo=6','Pesquisa',false);
     }else{
       document.form1.db82_descricao.value = '';
     }
  }
}
function js_mostratemplatealvara(chave,erro){
  document.form1.db82_descricao.value = chave;
  if(erro==true){
    document.form1.p90_db_documentotemplate.focus();
    document.form1.p90_db_documentotemplate.value = '';
  }
}
function js_mostratemplatealvara1(chave1,chave2){
  document.form1.p90_db_documentotemplate.value = chave1;
  document.form1.db82_descricao.value = chave2;
  db_iframe_db_documentotemplate.hide();
}
</script>
