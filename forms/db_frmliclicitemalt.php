<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

//MODULO: licitação
$clliclicita->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc50_descr");
$clrotulo->label("nome");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr colspan=2>
    <td align="center"><iframe name="procs" id="procs" src="lic1_licprocs001.php?licitacao=<?=@$licitacao?>" width="1000" height="130" marginwidth="0" marginheight="0" frameborder="0">
	</iframe></td>
  </tr>
  <tr colspan=2 >
    <td align="center">
    <?
    if (isset($licitacao)&&$licitacao!=""){
      $result_cods=$clliclicitem->sql_record($clliclicitem->sql_query_file(null,"*",null,"l21_codliclicita=$licitacao"));
      if ($clliclicitem->numrows>0){
      	if (!isset($_SESSION['cods'])){
      		$_SESSION['cods'] = array();
      	}
    	  $vir="";
    	  for ($w=0;$w<$clliclicitem->numrows;$w++){
          db_fieldsmemory($result_cods,$w);

          if (is_array($_SESSION['cods'])) {

            $_SESSION['cods'][] = $vir.$l21_codpcprocitem;
            $vir=",";
          }
    	  }
      }
    }
     ?>

        <input name='incluir' type='button' value='Incluir' onclick='js_inclui();' >
        <input name='excluir' type='button' value='Excluir' onclick='js_excluir();' disabled>
        <?php
            $rsSql = db_query('SELECT l03_pctipocompratribunal
                                FROM liclicita
                                JOIN cflicita ON l20_codtipocom = l03_codigo
                                WHERE l20_codigo = ' . $licitacao);
            $iTribunal = db_utils::fieldsMemory($rsSql, 0)->l03_pctipocompratribunal;
        ?>
        <?php if($iTribunal == 53) :?>
            <input name='exportarcsv' type='button' value='Exportar CSV' onclick='js_exportarcsv();'>
        <?php endif;?>
      </td>
    </tr>
    <tr colspan="2">
        <td>
        <iframe name="itens" id="itens" src="lic1_licitensifra.php?licitacao=<?=@$licitacao?>&tipojulg=<?=$tipojulg?>&redireciona=<?=$redireciona_edital?> " width="1000" height="230" marginwidth="0" marginheight="0" frameborder="0">
        </iframe>
        </td>
    </tr>
  <tr>
   <?
      db_input('cods',10,'',true,'hidden',3);
      db_input('licitacao',10,'',true,'hidden',3);
      db_input("tipojulg",1,"",true,"hidden",3);
      db_input('codprocesso' ,10, '', true, 'hidden', 3);
   ?>

  </tr>
</table>
</center>
</form>
<script>
function js_inclui(){
	itens.js_submit_form();
	itens.document.form1.incluir.value='incluir';
	itens.document.form1.submit();
	procs.document.form1.submit();

}

function js_excluir(){
    if(!document.form1.codprocesso.value){
        alert('Selecione ao menos um Processo de Compra vinculado!');
        return;
    }

    document.form1.submit();
}

function js_exportarcsv(){
    let licitacao = <?=$licitacao;?>;
    jan = window.open('lic2_relitenhtml002.php?l20_codigo='+licitacao+'&separador=;&delimitador=1&layout=1&ocultaCabecalho=true',
        '','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);

}

</script>
