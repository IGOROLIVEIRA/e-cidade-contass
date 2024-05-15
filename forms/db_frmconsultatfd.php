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

//MODULO: TFD
$oDaotfd_situacaopedidotfd->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("tf01_i_codigo");
$clrotulo->label("tf28_i_situacao");
$clrotulo->label("tf01_i_cgsund");
$clrotulo->label("z01_v_nome");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Ttf28_i_pedidotfd?>">
      <?
      db_ancora(@$Ltf28_i_pedidotfd,"js_pesquisatf28_i_pedidotfd(true);",$db_opcao);
      ?>
    </td>
    <td>
      <?
      db_input('tf28_i_pedidotfd',10,$Itf28_i_pedidotfd,true,'text',$db_opcao,
               ' onchange=js_pesquisatf28_i_pedidotfd(false);');
      db_input('operacao',1,'',true,'hidden',3,'');
      ?>
    </td>
  </tr>
  <tr>
    <td>
      <input name="alterar" type="submit" id="db_opcao" value="Alterar">
    </td>
  </tr>
</table>
</form>

<script>

function js_pesquisatf28_i_pedidotfd(mostra) {

  sChave = 'chave_desistencia='+document.form1.operacao.value;
  if(mostra==true) {

    js_OpenJanelaIframe('','db_iframe_tfd_pedidotfd','func_tfd_pedidotfdconsulta.php?'+sChave+
                        '&funcao_js=parent.js_mostratfd_pedidotfd|tf01_i_codigo|z01_v_nome|tf01_i_cgsund',
                        'Pesquisa',true);

  } else {

    if(document.form1.tf28_i_pedidotfd.value != '') {

      js_OpenJanelaIframe('','db_iframe_tfd_pedidotfd','func_tfd_pedidotfd.php?'+sChave+'&chave_tf01_i_codigo='+
                          document.form1.tf28_i_pedidotfd.value+'&funcao_js=parent.js_mostratfd_pedidotfd|'+
                          'tf01_i_codigo|z01_v_nome|tf01_i_cgsund&nao_mostra=true','Pesquisa',false);

    } else {

       document.form1.tf01_i_cgsund.value = '';
       document.form1.z01_v_nome.value = '';

    }

  }

}
function js_mostratfd_pedidotfd(chave1, chave2, chave3) {

  if(chave1 == '') {
    chave3 = '';
  }
  document.form1.tf28_i_pedidotfd.value = chave1;
  db_iframe_tfd_pedidotfd.hide();

}

function js_alterarPedido( iPedido )  {

  sChave                              = 'chavepesquisa='+iPedido;
  parent.document.formaba.a2.disabled = false;
  CurrentWindow.corpo.iframe_a2.location.href   = 'tfd4_tfd_pedidotfd002.php?'+sChave;
  parent.mo_camada('a2');
}

</script>
