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

//MODULO: empenho
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("o56_elemento");
$clrotulo->label("e69_numero");

$clorctiporec->rotulo->label();
$clempempenho->rotulo->label();
$clorcdotacao->rotulo->label();
$clpagordemele->rotulo->label();
$clpagordemnota->rotulo->label();
$clempnota->rotulo->label();
$clempnotaele->rotulo->label();
$cltabrec->rotulo->label();

if ($tela_estorno){

   $operacao  = 2;//operacao a ser realizada:1 = liquidacao, 2 estorno
   $labelVal  = "SALDO A ESTORNAR";
   $metodo    = "estornarLiquidacaoAJAX";
   $sCredor   = "none";

}else{

   $operacao  = 1;//operacao a ser realizada:1 = liquidacao, 2 estorno
   $labelVal  = "SALDO A LIQUIDAR";
   $metodo    = "liquidarAjax";
   $sCredor   = "normal";
}
$db_opcao_inf=1;
?>
<style>
.tr_tab{
  background-color:white;
  font-size: 8px;
  height : 8px;
}
</style>
<form name=form1 action="" method="POST">
 <input type=hidden name=retencoes value ="">
 <input type=hidden name=e69_codnota value="<?=@$e69_codnota ?>">
 <center>
<table>
 <tr>
 <td valign="top">
 <fieldset><legend><b>Empenho</b></legend>
    <table >
          <tr>
            <td nowrap><?=db_ancora($Le60_codemp,"js_JanelaAutomatica('empempenho',\$F('e60_numemp'))",$db_opcao_inf)?></td>
            <td nowrap><? db_input('e60_codemp', 13, $Ie60_codemp, true, 'text', 3)?> </td>
            <td nowrap><?=db_ancora($Le60_numemp,"js_JanelaAutomatica('empempenho',\$F('e60_numemp'))",$db_opcao_inf)?></td>
            <td><? db_input('e60_numemp', 13, $Ie60_numemp, true, 'text', 3)?> </td>
          </tr>
          <tr>
            <td><?=db_ancora($Le60_numcgm,"js_JanelaAutomatica('cgm',\$F('e60_numcgm'))",$db_opcao_inf)?></td>
            <td><? db_input('e60_numcgm', 13, $Ie60_numcgm, true, 'text', 3); ?> </td>
            <td colspan=2><? db_input('z01_nome', 50, $Iz01_nome, true, 'text', 3, '');?></td>
          </tr>
          <tr style='display:<?=$sCredor?>'>
            <td><?=db_ancora('<b>Credor:</b>',"js_pesquisae49_numcgm(true)",1)?></td>
            <td><? db_input('e49_numcgm', 13, $Ie60_numcgm, true, 'text', 1,"onchange='js_pesquisae49_numcgm(false)'"); ?> </td>
            <td colspan=2><? db_input('z01_credor', 50, $Iz01_nome, true, 'text', 3, '');?></td>
          </tr>
          <tr>
            <td><?=db_ancora($Le60_coddot,"js_JanelaAutomatica('orcdotacao',\$F('e60_coddot'),'".@$e60_anousu."')",$db_opcao_inf)?></td>
            <td><? db_input('e60_coddot', 13, $Ie60_coddot, true, 'text', 3); ?></td>
            <td width="20"><?=db_ancora($Lo15_codigo,"",3)?></td>
            <td><? db_input('o15_codigo', 5, $Io15_codigo, true, 'text', 3); db_input('o15_descr', 29, $Io15_descr, true, 'text', 3)?></td>
          </tr>
          <tr>
            <td><?db_ancora("<b>Conta Pagadora:</b>","js_pesquisa_contapagadora(true);",1);?></td>
            <td>
                <?
                    db_input("e83_conta",13,1,true,"text",4,"onchange='js_pesquisa_contapagadora(false);'");
                    db_input("e83_codtipo",5,1,true,"hidden");
                ?>
            </td>
            <td colspan='3'><? db_input("e83_descr",50,"",true,"text",3); ?></td>
          </tr>
          <tr>
            <td>
              <strong>Processo Administrativo:</strong>
            </td>
            <td colspan="2">
              <?php db_input('e03_numeroprocesso', 13, '', true, 'text', $db_opcao_inf, null, null, null, null, 15)?>
            </td>
          </tr>
           <!-- OC 12746 -->
           <tr>
               <td nowrap id="competDespLabel" style="display: none"><b>Competência da Despesa: </b></td>
               <td style="display: none" id="competDespInput">
                  <?db_inputData('e50_compdesp', '', '', '', true, 'text', 1); ?>
                  <input type="hidden" name="sEstrutElemento" id="sEstrutElemento"/>
               </td>
           </tr>

          <!--[Extensao OrdenadorDespesa] inclusao_ordenador-->

     <?
      echo " <tr> ";
      echo "    <td>&nbsp;</td> ";
      echo "    <td colspan='3'> ";
       if ($operacao == 1 ) {

         echo "       <input type='checkbox' checked id='emitedocumento'> ";
         echo "       <label for='emitedocumento'>Emitir Ordem de Pagamento</label> ";

       }
        echo "   &nbsp; </td> ";
        echo " </tr> ";
        echo " <tr> ";
        echo "    <td>&nbsp;</td> </tr>";
        if ($operacao == 2 ) {

          echo " <tr> ";
          echo "    <td>&nbsp;</td> </tr>";
        }
      ?>
        </table>
        </fieldset>
  </td>
  <td rowspan="1" valign="top" style='height:100%;'>
 <fieldset><legend><b>Valores do Empenho</b></legend>
    <table >
          <tr><td nowrap><?=@$Le60_vlremp?></td><td align=right><? db_input('e60_vlremp', 12, $Ie60_vlremp, true, 'text', 3, '','','','text-align:right')?></td></tr>
          <tr><td nowrap><?=@$Le60_vlranu?></td><td align=right><? db_input('e60_vlranu', 12, $Ie60_vlranu, true, 'text', 3, '','','','text-align:right')?></td></tr>
          <tr><td nowrap><?=@$Le60_vlrliq?></td><td align=right><? db_input('e60_vlrliq', 12, $Ie60_vlrliq, true, 'text', 3, '','','','text-align:right')?></td></tr>
          <tr><td nowrap><?=@$Le60_vlrpag?></td><td align=right><? db_input('e60_vlrpag', 12, $Ie60_vlrpag, true, 'text', 3, '','','','text-align:right')?></td></tr>
          <tr><td colspan=2 align=center class=table_header><?=$labelVal?></td></tr>
          <!-- Extensão CotaMensalLiquidacao - pt 1 -->
          <tr>
            <td><b> SALDO </b></td>
            <td align=right>
              <?
              if($db_opcao==3){
                @$saldo_disp = db_formatar(($e53_valor-$e53_vlranu-$e53_vlrpag),'p');
              }else{
                @$saldo_disp = db_formatar(($e60_vlremp-$e60_vlranu-$e60_vlrliq),'p');
              }
              db_input('saldo_disp', 12, $Ie60_vlrpag, true, 'text', 3, '','','','text-align:right');
              ?>
            </td>
          </tr>
      </table>
     </fieldset>
  </td>
  </tr>
  <tr>
  <td colspan="2"> 
 <fieldset id='esocial'><legend><b>eSocial</b></legend>
 <table >
 <tr>
                <td>
                <strong>Incide Contribuição Previdenciária:</strong>
                <td colspan="4">
                <?
                  $aIncide = array('1'=>'Sim', '2'=>'Não');
                  db_select('aIncide', $aIncide, true, 1, "onchange='mensagemesocial()'"); 
                ?>
                </td>
        </tr>     
        <tr>
                  <td id='cattrab'><?=db_ancora('<b>Categoria do Trabalhador:</b>',"js_pesquisaCatTrabalhador(true)",1)?></td>
                  <td id='cattrab1'><? db_input('ct01_codcategoria', 15, $Ict01_codcategoria, true, 'text', 1,"onchange='js_pesquisaCatTrabalhador(false)'"); ?> </td>
                  <td id='cattrab2'><? db_input('ct01_descricaocategoria', 50, $Ict01_descricaocategoria, true, 'text', 3, '');?></td>
        </tr>
        <tr>
                <td id='idcontri'>
                <strong>Indicador de Desconto da Contribuição Previdenciária:</strong>
                <td colspan="4">
                <?
                  $aContribuicao = array(''=>'Selecione', '1'=>'1 - O percentual da alíquota será obtido considerando a remuneração total do trabalhador',
                  '2'=>'2 - O declarante aplica a alíquota de desconto do segurado sobre a diferença entre o limite máximo do salário de contribuição e a remuneração de outra empresa para as quais o trabalhador informou que houve o desconto',
                  '3'=>'3 - O declarante não realiza desconto do segurado, uma vez que houve desconto sobre o limite máximo de salário de contribuição em outra empresa',
                  );
                  db_select('contribuicaoPrev', $aContribuicao, true, 1, "onchange='validarcamposEsocial()'"); 
                ?>
                </td>
        </tr>
        <tr >
                  <td id='empresa'><?=db_ancora('<b>Empresa que efetuou desconto:</b>',"js_pesquisaEmpresa(true)",1)?></td>
                  <td id='empresa1'><? db_input('numempresa', 15, $Inumempresa, true, 'text', 1,"onchange='js_pesquisaEmpresa(false)'"); ?> </td>
                  <td id='empresa2'><? db_input('nomeempresa', 50, $Inomeempresa, true, 'text', 3, '');?></td>
        </tr>
        <tr>
                  <td id='catremuneracao'><?=db_ancora('<b>Categoria do trabalhador na qual houve a remuneração:</b>',"js_pesquisaCatTrabalhadorremuneracao(true)",1)?></td>
                  <td id='catremuneracao1'><? db_input('ct01_codcategoriaremuneracao', 15, $Ict01_codcategoriaremuneracao, true, 'text', 1,"onchange='js_pesquisaCatTrabalhadorremuneracao(false)'"); ?> </td>
                  <td id='catremuneracao2'><? db_input('ct01_descricaocategoriaremuneracao', 50, $Ict01_descricaocategoriaremuneracao, true, 'text', 3, '');?></td>
        </tr>
        <tr>
                  <td id='vlrremuneracao'><strong>Valor da Remuneração:</strong></td>
                  <td id='vlrremuneracao1'>
                    <?
                    db_input('valorremuneracao', 15, $Ivalorremuneracao, true, 'text', 1, '','','','text-align:right');
                    ?>
                  </td>
        </tr>
        <tr>
                  <td id='vlrdesconto'><strong>Valor do Desconto:</strong></td>
                  <td id='vlrdesconto1'>
                    <?
                    db_input('valordesconto', 15, $Ivalordesconto, true, 'text', 1, '','','','text-align:right');
                    ?>
                  </td>
                </tr>
        <tr >
                  <td id='idcompetencia'>
                    <b>Competência:</b>
                  </td>
                  <td id='idcompetencia2'>
                    <?
                      db_inputdata('competencia',@$ac10_datamovimento_dia, 
                                                        @$ac10_datamovimento_mes, 
                                                        @$ac10_datamovimento_ano, true, 'text', $db_opcao, 'style="width: 99px"');
                    ?>
                  </td>
                  <td>&nbsp;</td>
        </tr>                
  </table>      
 </fieldset>
 </td>
 </tr>
  <tr>
  <td colspan="2">
 <fieldset><legend><b>Notas</b></legend>
       <div style='border:2px inset white'>
        <table  cellspacing=0 cellpadding=0 width='100%'>
          <tr>
            <th class='table_header'>
	          <input type='checkbox'  style='display:none' id='mtodos' onclick='js_marca()'>
           	<a onclick='js_marca()' style='cursor:pointer'>M</a></b></th>
            <th class='table_header'>OP</th>
            <th class='table_header'>Seq. Nota</th>
            <th class='table_header'>Nota Fiscal</th>
            <th class='table_header'>Data</th>
            <th class='table_header'>Valor</th>
            <th class='table_header'>Anulado</th>
            <th class='table_header'>Liquidado</th>
            <th class='table_header'>Pago</th>
            <th class='table_header'>Retido</th>
          </tr>
          <tbody id='dados' style='height:150;width:95%;overflow:scroll;overflow-x:hidden;background-color:white'>
          </tbody>
        </table>
        </div>
        </fieldset>
  </td>
  </tr>
  <tr>
  <td colspan="2px">
 <fieldset><legend><b>Histórico</b></legend>
   <table width="100%">
        <tr>
          <td id='opcredito' style='display:none'>
          <?        
          db_textarea('informacaoop',4,110,0,true,'text',1,"");       
          ?>
          </td>
          <tr >
          <td id='ophisotrico' style='display:none'>
          <?
          db_textarea('historico',4,110,0,true,'',1,"" );         
          ?>
          </td>
        </tr>
    </table>
    </fieldset>
    </td>
  </tr>
</table>
 <input name="confirmar" type="button" id="confirmar" value="Confirmar" onclick="return js_liquidar('<?=$metodo?>')" >
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa('');" >
</center>
  <? db_input("receitas_valores",30,"",true,'hidden',1,'readonly','','','text-align:right')?>
  <? db_input("valor_liquidar",30,"",true,'hidden',1,'readonly','','','text-align:right')?>
</form>
<script>
iOperacao     = <?=$operacao;?>;
lPesquisaFunc = false;
function js_emitir(codordem){
  jan = window.open('emp2_emitenotaliq002.php?codordem='+codordem,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
  jan.moveTo(0,0);
}
function js_pesquisa(iNumEmp) {
  if (iNumEmp == '') {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_empempenho', 'func_empempenho.php?funcao_js=parent.js_preenchepesquisa|e60_numemp', 'Pesquisa', true);
  } else {
    js_consultaEmpenho(iNumEmp,<?=$operacao?>);
  }
}
function js_preenchepesquisa(chave){
  db_iframe_empempenho.hide();
  js_consultaEmpenho(chave,<?=$operacao?>);
  lPesquisaFunc = true; //mostramos as mensagens se o usuário clicou na func.
}
function mensagemesocial(){
  if(document.form1.aIncide.value == '2'){
    var r=confirm("Tem certeza de que não há incidência de contribuição previdenciária para este prestador? ");
    if (r==true)
      {
      document.getElementById('idcontri').style.display = "none";
      document.getElementById('cattrab').style.display = "none";
      document.getElementById('cattrab1').style.display = "none";
      document.getElementById('cattrab2').style.display = "none";
      document.getElementById('ct01_codcategoria').style.display = "none";
      document.getElementById('ct01_descricaocategoria').style.display = "none";
      document.getElementById('contribuicaoPrev').style.display = "none";
      document.getElementById('idcompetencia').style.display = "none";
      document.getElementById('idcompetencia2').style.display = "none";
      document.getElementById('empresa').style.display = "none";
      document.getElementById('empresa1').style.display = "none";
      document.getElementById('empresa2').style.display = "none";
      document.getElementById('catremuneracao').style.display = "none";
      document.getElementById('catremuneracao1').style.display = "none";
      document.getElementById('catremuneracao2').style.display = "none";
      document.getElementById('vlrremuneracao').style.display = "none";
      document.getElementById('vlrremuneracao1').style.display = "none";
      document.getElementById('vlrdesconto').style.display = "none";
      document.getElementById('vlrdesconto1').style.display = "none";
      document.form1.numempresa.value = '';
      document.form1.nomeempresa.value = '';
      document.form1.ct01_codcategoriaremuneracao.value = '';
      document.form1.ct01_descricaocategoriaremuneracao.value = '';
      document.form1.valorremuneracao.value = '';
      document.form1.valordesconto.value = '';
      document.form1.competencia.value= '';
      }
    else
      {
      document.form1.aIncide.value = '1';
      return false;
      }
  }else{
      document.getElementById('idcontri').style.display = "table-cell";
      document.getElementById('cattrab').style.display = "table-cell";
      document.getElementById('cattrab1').style.display = "table-cell";
      document.getElementById('cattrab2').style.display = "table-cell";
      document.getElementById('ct01_codcategoria').style.display = "table-cell";
      document.getElementById('ct01_descricaocategoria').style.display = "table-cell";
      document.getElementById('contribuicaoPrev').style.display = "table-cell";
      document.form1.contribuicaoPrev.value = '';
      document.form1.numempresa.value = '';
      document.form1.nomeempresa.value = '';
      document.form1.ct01_codcategoriaremuneracao.value = '';
      document.form1.ct01_descricaocategoriaremuneracao.value = '';
      document.form1.ct01_codcategoria.value = '';
      document.form1.ct01_descricaocategoria.value = '';
      document.form1.valorremuneracao.value = '';
      document.form1.valordesconto.value = '';
      document.form1.competencia.value= '';
  }
}

      document.getElementById('idcompetencia').style.display = "none";
      document.getElementById('idcompetencia2').style.display = "none";
      document.getElementById('empresa').style.display = "none";
      document.getElementById('empresa1').style.display = "none";
      document.getElementById('empresa2').style.display = "none";
      document.getElementById('catremuneracao').style.display = "none";
      document.getElementById('catremuneracao1').style.display = "none";
      document.getElementById('catremuneracao2').style.display = "none";
      document.getElementById('vlrremuneracao').style.display = "none";
      document.getElementById('vlrremuneracao1').style.display = "none";
      document.getElementById('vlrdesconto').style.display = "none";
      document.getElementById('vlrdesconto1').style.display = "none";
      
function validarcamposEsocial(){
    if($('contribuicaoPrev').value == 1 || $('contribuicaoPrev').value == ''){
      document.getElementById('idcompetencia').style.display = "none";
      document.getElementById('idcompetencia2').style.display = "none";
      document.getElementById('empresa').style.display = "none";
      document.getElementById('empresa1').style.display = "none";
      document.getElementById('empresa2').style.display = "none";
      document.getElementById('catremuneracao').style.display = "none";
      document.getElementById('catremuneracao1').style.display = "none";
      document.getElementById('catremuneracao2').style.display = "none";
      document.getElementById('vlrremuneracao').style.display = "none";
      document.getElementById('vlrremuneracao1').style.display = "none";
      document.getElementById('vlrdesconto').style.display = "none";
      document.getElementById('vlrdesconto1').style.display = "none";
      document.form1.numempresa.value = '';
      document.form1.nomeempresa.value = '';
      document.form1.ct01_codcategoriaremuneracao.value = '';
      document.form1.ct01_descricaocategoriaremuneracao.value = '';
      document.form1.valorremuneracao.value = '';
      document.form1.valordesconto.value = '';
      document.form1.competencia.value= '';
    }else{
      document.getElementById('idcompetencia').style.display = "table-cell";
      document.getElementById('idcompetencia2').style.display = "table-cell";
      document.getElementById('empresa').style.display = "table-cell";
      document.getElementById('empresa1').style.display = "table-cell";
      document.getElementById('empresa2').style.display = "table-cell";
      document.getElementById('catremuneracao').style.display = "table-cell";
      document.getElementById('catremuneracao1').style.display = "table-cell";
      document.getElementById('catremuneracao2').style.display = "table-cell";
      document.getElementById('vlrremuneracao1').style.display = "table-cell";
      document.getElementById('vlrremuneracao').style.display = "table-cell";
      document.getElementById('vlrdesconto').style.display = "table-cell";
      document.getElementById('vlrdesconto1').style.display = "table-cell";
    }
}
   
function js_marca(){

	 obj = document.getElementById('mtodos');
	 if (obj.checked){
		 obj.checked = false;
	}else{
		 obj.checked = true;
	}
   itens = js_getElementbyClass(form1,'chkmarca');
	 for (i = 0;i < itens.length;i++){
     if (itens[i].disabled == false){
        if (obj.checked == true){
					itens[i].checked=true;
          js_marcaLinha(itens[i]);
       }else{
					itens[i].checked=false;
          js_marcaLinha(itens[i]);
			 }
     }
	 }
}

/**
 * Função que busca os dados do empenho
 */
function js_consultaEmpenho(iEmpenho,operacao){

   js_divCarregando("Aguarde, efetuando pesquisa","msgBox");
   strJson = '{"method":"getEmpenhos","pars":"'+iEmpenho+'","operacao":"'+operacao+'","iEmpenho":"'+iEmpenho+'"}';
   $('dados').innerHTML    = '';
   //$('pesquisar').disabled = true;
   url     = 'emp4_liquidacao004.php';
   oAjax   = new Ajax.Request(
                            url,
                              {
                               method: 'post',
                               parameters: 'json='+strJson,
                               onComplete: js_saida
                              }
                             );

}

/* Extensão CotaMensalLiquidacao - pt 3 */

 /**
  * Preenche o formulário com os dados do empenho   
  */
function js_saida(oAjax){
  
   js_removeObj("msgBox"); 
    var iNumEmpOld = $F('e60_numemp');
    obj  = eval("("+oAjax.responseText+")");
    $('e60_codemp').value = obj.e60_codemp;
    $('e60_numemp').value = obj.e60_numemp;
    $('e60_numcgm').value = js_decodeUrl(obj.e60_numcgm);
    $('z01_nome').value   = js_decodeUrl(obj.z01_nome);
    $('e49_numcgm').value = '';
    $('z01_credor').value = '';
    $('e60_coddot').value = js_decodeUrl(obj.e60_coddot);
    $('o15_codigo').value = obj.o58_codigo;
    $('o15_descr').value  = js_decodeUrl(obj.o15_descr);
    $('e60_vlremp').value = obj.e60_vlremp;
    $('e60_vlranu').value = obj.e60_vlranu;
    $('e60_vlrpag').value = obj.e60_vlrpag;
    $('e60_vlrliq').value = obj.e60_vlrliq;
    $('informacaoop').value  = obj.e60_informacaoop.urlDecode(); 
       
    if(obj.e60_informacaoop){
      $('historico').value  = obj.e60_informacaoop.urlDecode();}
    else{
      $('historico').value  = obj.e60_resumo.urlDecode();   
    }
    $('saldo_disp').value = obj.saldo_dis;
    $('sEstrutElemento').value = obj.sEstrutural;
    saida                 = '';
    iTotNotas             = 0;
    $('dados').innerHTML  = '';
    estrutural            = obj.sEstrutural;
    desdobramento         = obj.sDesdobramento;
    $('e50_compdesp').value = ''; 
    $('e83_conta').value    = '';
    $('e83_descr').value    = '';
    $('e83_codtipo').value  = '';

    if(obj.e60_informacaoop!=''){
      document.getElementById('opcredito').style.display = "table-cell";
      document.getElementById('ophisotrico').style.display = "none";
    } else {
      document.getElementById('opcredito').style.display = "none";
      document.getElementById('ophisotrico').style.display = "table-cell";
    }
    var db_opcao = "<?php print $op; ?>";
   
    if(db_opcao != '3' && obj.Tipofornec == 'cpf'  &&  (  desdobramento == '333903604' || desdobramento == '333903606' || desdobramento == '333903610'
                                    || desdobramento == '333903611' || desdobramento == '333903612' || desdobramento == '333903613'
                                    || desdobramento == '333903615' || desdobramento == '333903616' || desdobramento == '333903617'
                                    || desdobramento == '333903618' || desdobramento == '333903619' || desdobramento == '333903620'
                                    || desdobramento == '333903621' || desdobramento == '333903622' || desdobramento == '333903623'
                                    || desdobramento == '333903624' || desdobramento == '333903625' || desdobramento == '333903626'
                                    || desdobramento == '333903627' || desdobramento == '333903628' || desdobramento == '333903629'
                                    || desdobramento == '333903630' || desdobramento == '333903631' || desdobramento == '333903632'
                                    || desdobramento == '333903633' || desdobramento == '333903634' || desdobramento == '333903642'
                                    || desdobramento == '333903643' || desdobramento == '333903644' || desdobramento == '333903645'
                                    || desdobramento == '333903699' || desdobramento == '333903501' || desdobramento == '333903502'
                                    || desdobramento == '333903503' || desdobramento == '333903504' || desdobramento == '333903505'
                                    || desdobramento == '333903506' || desdobramento == '333903599')
                                    ){
      tipodesdobramento = 1;  
      opcao = 1;                                 
      document.getElementById('esocial').style.display = "table-cell";   
    }else{
      document.getElementById('esocial').style.display = "none";
      tipodesdobramento = 0;
      opcao = 3;
    }
    
    if (obj.aItensPendentesPatrimonio.length > 0) {

      oDBViewNotasPendentes = new DBViewNotasPendentes('oDBViewNotasPendentes');
      oDBViewNotasPendentes.setCodigoNota(obj.aItensPendentesPatrimonio);
  	  oDBViewNotasPendentes.show();  
    }
 
    if (obj.numnotas > 0) {

      for (var i = 0; i < obj.data.length; i++) {

        sClassName = 'normal';
        if (obj.data[i].libera == 'disabled') {
          sClassName = ' disabled ';
        }
 
        if (in_array(obj.data[i].e69_codnota, obj.aItensPendentesPatrimonio)) {
          sClassName = ' disabled ';
        }

        if (iOperacao == 1) { //liquidacao

          var nSaldoNota = (js_strToFloat(obj.data[i].e70_valor)-js_strToFloat(obj.data[i].e70_vlrliq) -
		                        js_strToFloat(obj.data[i].e70_vlranu)-js_strToFloat(obj.data[i].e53_vlrpag)).toFixed(2);

          aMatrizEntrada = ['3319092', '3319192', '3319592', '3319692'];

            if (aMatrizEntrada.indexOf(estrutural) !== -1) {
               document.getElementById('competDespLabel').style.display = "table-cell";
               document.getElementById('competDespInput').style.display = "table-cell";
            } else {
                document.getElementById('competDespLabel').style.display = "none";
                document.getElementById('competDespInput').style.display = "none";
            }

        } else if (iOperacao == 2) { //estorno
          if (js_strToFloat(obj.data[i].e53_vlrpag) > 0) {
            var nSaldoNota = 0;
          } else {
            var nSaldoNota = (js_strToFloat(obj.data[i].e70_vlrliq)-js_strToFloat(obj.data[i].e70_vlranu)).toFixed(2);
          }
        }

        if (nSaldoNota > 0) {

          iTotNotas++;
          nValorRetencao = obj.data[i].vlrretencao;
          numnota        = js_decodeUrl(obj.data[i].e69_numero);
          iCodOrd        = obj.data[i].e50_codord;
          saida += "<tr class='" + sClassName + "' id='trchk" + obj.data[i].e69_codnota + "' style='height:1em'>";
          saida += "<td class='linhagrid' style='text-align:center'>";
          saida += "<input type='hidden' id='sInfoAgenda"+obj.data[i].e69_codnota+"' value='"+js_decodeUrl(obj.data[i].sInfoAgenda)+"'>";
          /* Extensão CotaMensalLiquidacao - pt 4 */
          saida += "<input type='checkbox' " + obj.data[i].libera + " onclick='js_marcaLinha(this)'";
          saida += " class='chkmarca' name='chk" + obj.data[i].e69_codnota + "'";
          saida += " id='chk" + obj.data[i].e69_codnota + "' value='" + obj.data[i].e69_codnota + "' "+sClassName+"></td>";
          saida += "<td class='linhagrid' style='text-align:center'>" + iCodOrd + "</td>";
          saida += "<td class='linhagrid' style='text-align:center'><b>"
          saida += "<a href='' onclick='js_consultaNota("+obj.data[i].e69_codnota+");return false'>";
          saida += obj.data[i].e69_codnota + "</a></b></td>";
          saida += "<td class='linhagrid' style='text-align:center' id='numero"+obj.data[i].e69_codnota+"' >" + numnota + "</td>";
          saida += "<td class='linhagrid' style='text-align:center'>" + obj.data[i].e69_dtnota + "</td>";
          saida += "<td class='linhagrid' style='text-align:center'>" + obj.data[i].e70_valor + "</td>";
          saida += "<td class='linhagrid' style='text-align:right;width:10%'>" + obj.data[i].e70_vlranu + "</td>";
          saida += "<td class='linhagrid' style='text-align:right;width:10%'>" + obj.data[i].e70_vlrliq + "</td>";
          saida += "<td class='linhagrid' style='text-align:right;width:10%'>" + obj.data[i].e53_vlrpag + "</td>";
          saida += "<td class='linhagrid' style='text-align:right;width:10%'>";
          if (iOperacao == 1) {

            saida += "<a href='' id='retencao"+obj.data[i].e69_codnota+"' ";
            saida += "   onclick='js_lancarRetencao("+obj.data[i].e69_codnota+",\""+iCodOrd+"\",\""+obj.data[i].e70_valor+"\");";
            saida += "return false;'>"+nValorRetencao+"</a>";
          } else {
            saida += nValorRetencao; 
          }
          saida += "</td></tr>";

        }
      }

        if(obj.Zerado == true){
            alert('"ERRO: Número do CPF/CNPJ está zerado. Corrija o CGM do fornecedor e tente novamente"');
            location.href = 'emp1_empliquida001.php';
        }

      obj.data.each(function (oCodigoNota, iLinha) {

        if (in_array(oCodigoNota.e69_codnota, obj.aItensPendentesPatrimonio)) {
					alert("Os bens vínculados a esta nota estão pendentes de tombamento ou dispensa de tombamento no módulo patrimonial! ");
        }
      });

      $('confirmar').disabled = false;
    } else {

      alert("Empenho sem notas lançadas ou pendentes de inclusão no Módulo Patrimônio!");
      $('confirmar').disabled = true;
    }
    if (obj.validaContrato == 'f') {
      var respContrato = confirm("Empenho sem contrato vinculado. Deseja continuar mesmo assim?");
      if (respContrato == false) {
        location.href = 'emp1_empliquida001.php';
      }
    }
    saida += "<tr style='height:auto'><td colspan='10'>&nbsp;</td></tr>";
    $('dados').innerHTML  = saida;
    if (iTotNotas  == 0) {
      if (iOperacao == 1 ) {
        var sAcao = "liquidar";
      }else if (iOperacao == 2) {
        var sAcao = "estornar";
      }
      $('confirmar').disabled = true;
    }
    if (js_strToFloat(obj.saldo_dis) == 0) {

      if (lPesquisaFunc) {
        alert("Empenho sem <?= strtolower($labelVal);?>");
      }
      $('confirmar').disabled = true;
    }
    $('pesquisar').disabled = false;
   /* Extensão CotaMensalLiquidacao - pt 6 */
}
function js_marcaLinha(obj){

  if (obj.checked){

    $('tr'+obj.id).className='marcado';
  }else{

   $('tr'+obj.id).className='normal';

  }

}

function js_liquidar(metodo){

   if (metodo == "liquidarAjax") {

       aMatrizEntrada = ['3319092', '3319192', '3319592', '3319692'];

       if (aMatrizEntrada.indexOf($F('sEstrutElemento')) !== -1) {

           if ($F('e50_compdesp') == ''){
               alert('Campo Competência da Despesa deve ser informado.');
               $('e50_compdesp').focus();
               $('pesquisar').disabled = false;
               $('confirmar').disabled = false;
               return false;
           }
       }
   }
   if(document.form1.aIncide.value == 1){
    if(opcao != '3' && !document.form1.ct01_codcategoria.value &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
        alert("Campo Categoria do Trabalhador Obrigatorio")
        return false;
    }
    if(opcao != '3' && !document.form1.contribuicaoPrev.value &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
        alert("Campo Indicador de Desconto da Contribuição Previdenciária Obrigatorio")
        return false;
    }
    if(!document.form1.numempresa.value &&  opcao != '3' && (document.form1.contribuicaoPrev.value == '2' || document.form1.contribuicaoPrev.value == '3') &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
        alert("Campo Empresa que efetuou desconto Obrigatorio")
        return false;
    }
    if(!document.form1.ct01_codcategoriaremuneracao.value &&  opcao != '3' && (document.form1.contribuicaoPrev.value == '2' || document.form1.contribuicaoPrev.value == '3') &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
        alert("Campo Categoria do trabalhador na qual houve a remuneração Obrigatorio")
        return false;
    }
    
    if(!document.form1.valorremuneracao.value &&  opcao != '3' && (document.form1.contribuicaoPrev.value == '2' || document.form1.contribuicaoPrev.value == '3') &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
        alert("Campo Valor da Remuneração Obrigatorio")
        return false;
    }
    if(!document.form1.valordesconto.value &&  opcao != '3' && (document.form1.contribuicaoPrev.value == '2' || document.form1.contribuicaoPrev.value == '3') &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
        alert("Campo Valor do Desconto Obrigatorio")
        return false;
    }
    if(!document.form1.competencia.value &&  opcao != '3' && (document.form1.contribuicaoPrev.value == '2' || document.form1.contribuicaoPrev.value == '3') &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
        alert("Campo Competência Obrigatorio")
        return false;
    }
  }

   itens = js_getElementbyClass(form1,'chkmarca');
   notas = '';
   sV    = '';
   $('pesquisar').disabled = true;
   $('confirmar').disabled = true;
   var aNotas = new Array();
   for (i = 0;i < itens.length;i++){
     if (itens[i].checked == true){
        aNotas.push(itens[i].value);
      }
   }

   if (aNotas.length != 0){

     if (metodo == "estornarLiquidacaoAJAX") {

       var sMensagem = "Aguarde, estornando liquidacao das notas";
       if (!confirm("Confirma o estorno da liquidação?")) {

         $('pesquisar').disabled = false;
         $('confirmar').disabled = false;
         return false;
       }

     } else {
       var sMensagem = "Aguarde, Liquidando notas";

       /* Extensão CotaMensalLiquidacao - pt 5 */
     }
     js_divCarregando(sMensagem, "msgLiq");
    
     var oParam        = new Object();
     oParam.method     = metodo;
     oParam.iEmpenho   = $F('e60_numemp');
     oParam.notas      = aNotas;
     oParam.informacaoop  = encodeURIComponent($F('informacaoop'));
          
     if(obj.e60_informacaoop){
        oParam.historico  = encodeURIComponent($F('informacaoop'));
     }
     else{   
        oParam.historico  = encodeURIComponent($F('historico'));
     }

     oParam.e03_numeroprocesso = encodeURIComponent(tagString($F("e03_numeroprocesso")));

     oParam.pars       = $F('e60_numemp');
     oParam.z01_credor = $F('e49_numcgm');

     oParam.e50_compdesp = $F('e50_compdesp');
     oParam.e83_codtipo  = $F('e83_codtipo');
     oParam.cattrabalhador = encodeURIComponent($F('ct01_codcategoria'));
     oParam.numempresa = encodeURIComponent($F('numempresa'));
     oParam.contribuicaoPrev = $F('contribuicaoPrev');
     oParam.cattrabalhadorremuneracao = $F('ct01_codcategoriaremuneracao');
     oParam.valorremuneracao = encodeURIComponent($F('valorremuneracao'));
     oParam.valordesconto = encodeURIComponent($F('valordesconto'));
     oParam.competencia = $F('competencia');

  
     url      = 'emp4_liquidacao004.php';
     oAjax    = new Ajax.Request(
                            url,
                              {
                               method: 'post',
                               parameters: 'json='+Object.toJSON(oParam),
                               onComplete: js_saidaLiquidacao
                              }
                             );
   } else{

     alert('Selecione ao menos 1 (uma) nota para liquidar');
     $('pesquisar').disabled = false;
     $('confirmar').disabled = false;

   }
}

function js_saidaLiquidacao(oAjax){

  js_removeObj("msgLiq");

    $('pesquisar').disabled = false;
    $('confirmar').disabled = false;
    obj      = eval("("+oAjax.responseText+")");


    if (obj.lErro == true) {
      alert(obj.sMensagem.urlDecode()); return false;
    }

    mensagem = obj.mensagem.replace(/\+/g," ");
    mensagem = unescape(mensagem);
    if (obj.erro == 2){
       alert(mensagem);
    }
    if (obj.erro == 1){
       if (document.getElementById('emitedocumento') && $('emitedocumento').checked) {
         js_emitir(obj.sOrdensGeradas);
       }
       lPesquisaFunc = false;
       js_consultaEmpenho($F('e60_numemp'),<?=$operacao?>);

        document.form1.ct01_codcategoria.value = '';
        document.form1.ct01_descricaocategoria.value = ''; 
        document.form1.contribuicaoPrev.value = '';
        document.form1.ct01_codcategoriaremuneracao.value = '';
        document.form1.ct01_descricaocategoriaremuneracao.value = '';
        document.form1.numempresa.value = '';
        document.form1.nomeempresa.value = '';
        document.form1.valorremuneracao.value = '';
        document.form1.valordesconto.value = '';
        document.form1.competencia.value = '';
    }
 


}
function js_decodeUrl(sTexto){

   texto = sTexto.replace(/\+/g," ");
   texto = unescape(texto);
   return texto;

}
function js_pesquisaCatTrabalhador(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_categoriatrabalhador.php?funcao_js=parent.js_mostraCatTrabalhador1|ct01_codcategoria|ct01_descricaocategoria','Pesquisa',true);
  }else{
     if(document.form1.ct01_codcategoria.value != ''){
        js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_categoriatrabalhador.php?pesquisa_chave='+document.form1.ct01_codcategoria.value+'&funcao_js=parent.js_mostraCatTrabalhador','Pesquisa',false);
     }else{
       document.form1.ct01_codcategoria.value = '';
       document.form1.ct01_descricaocategoria.value = '';
     }
  }
}
function js_pesquisaCatTrabalhadorremuneracao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_categoriatrabalhador.php?funcao_js=parent.js_mostraCatTrabalhadorremuneracao1|ct01_codcategoria|ct01_descricaocategoria','Pesquisa',true);
  }else{
     if(document.form1.ct01_codcategoriaremuneracao.value != ''){
        js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_categoriatrabalhador.php?pesquisa_chave='+document.form1.ct01_codcategoriaremuneracao.value+'&funcao_js=parent.js_mostraCatTrabalhadorremuneracao','Pesquisa',false);
     }else{
       document.form1.ct01_codcategoriaremuneracao.value = '';
       document.form1.ct01_descricaocategoriaremuneracao.value = '';
     }
  }
}
function js_pesquisae49_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.e49_numcgm.value != ''){
        js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_nome.php?pesquisa_chave='+document.form1.e49_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
     }else{
       document.form1.z01_credor.value = '';
     }
  }
}
function js_pesquisaEmpresa(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_nome.php?funcao_js=parent.js_mostraEmpresa1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.numempresa.value != ''){
        js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_nome.php?pesquisa_chave='+document.form1.numempresa.value+'&funcao_js=parent.js_mostraEmpresa','Pesquisa',false);
     }else{
       document.form1.nomeempresa.value = '';
     }
  }
}

function js_mostraCatTrabalhador(erro,chave){
  document.form1.ct01_descricaocategoria.value = chave;
  if(erro==true){
    document.form1.ct01_codcategoria.focus();
    document.form1.ct01_codcategoria.value = '';
  }
}
function js_mostraCatTrabalhador1(chave1,chave2){
  document.form1.ct01_codcategoria.value = chave1;
  document.form1.ct01_descricaocategoria.value = chave2;
  db_iframe_cgm.hide();
}
function js_mostraCatTrabalhadorremuneracao(erro,chave){
  document.form1.ct01_descricaocategoriaremuneracao.value = chave;
  if(erro==true){
    document.form1.ct01_codcategoriaremuneracao.focus();
    document.form1.ct01_codcategoriaremuneracao.value = '';
  }
}
function js_mostraCatTrabalhadorremuneracao1(chave1,chave2){
  document.form1.ct01_codcategoriaremuneracao.value = chave1;
  document.form1.ct01_descricaocategoriaremuneracao.value = chave2;
  db_iframe_cgm.hide();
}
function js_mostraEmpresa(erro,chave){
  document.form1.nomeempresa.value = chave;
  if(erro==true){
    document.form1.numempresa.focus();
    document.form1.numempresa.value = '';
  }
}
function js_mostraEmpresa1(chave1,chave2){
  document.form1.numempresa.value = chave1;
  document.form1.nomeempresa.value = chave2;
  db_iframe_cgm.hide();
}
function js_mostracgm(erro,chave){
  document.form1.z01_credor.value = chave;
  if(erro==true){
    document.form1.e49_numcgm.focus();
    document.form1.e49_numcgm.value = '';
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.e49_numcgm.value = chave1;
  document.form1.z01_credor.value = chave2;
  db_iframe_cgm.hide();
}

function removerObj(id) {

   obj = $(id);
   parent
   parent = obj.parentNode;
   parent.removeChild(obj);
}

function js_consultaNota(iCodNota) {
  js_OpenJanelaIframe('top.corpo', 'db_iframe_nota', 'emp2_consultanotas002.php?e69_codnota='+iCodNota, 'Pesquisa Dados da Nota', true);
}

function js_emitir(codordem){

  jan = window.open('emp2_emitenotaliq002.php?codordem='+codordem,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
  jan.moveTo(0,0);
}

function js_lancarRetencao(iCodNota, iCodOrd, nValor){

   var iNumEmp  = $F('e60_numemp');
   var lSession = <?=$operacao==2?"false":"true"?>;
   var iNumCgm  = $F('e49_numcgm');
   $('e49_numcgm').disabled = true;
   js_OpenJanelaIframe('top.corpo', 'db_iframe_retencao',
                       'emp4_lancaretencoes.php?iNumNota='+iCodNota+'&iNumEmp='+iNumEmp+'&iCodOrd='+iCodOrd+
                       '&iNumCgm='+iNumCgm+
                       "&lSession="+lSession+"&nValorBase="+js_strToFloat(nValor)+"&iCodMov=&callback=true",
                       'Lancar Retenções', true);

}

function js_atualizaValorRetencao(iCodMov, nValor, iNota, iCodOrdem) {

   if (nValor > 0) {
     $('e49_numcgm').disabled      = true;
   } else {
     $('e49_numcgm').disabled      = false;
   }
   $('retencao'+iNota).innerHTML = js_formatar(nValor,'f');
   db_iframe_retencao.hide();

}

/**
 * Função que simula o in_array do PHP
 */
function in_array(valor,vetor){

  for (var i in vetor) {

    if (valor == vetor[i]) {
      return true;
    }
  }
  return false;
};

function js_pesquisa_contapagadora(mostra) {

    if (mostra==true) {
        js_OpenJanelaIframe('top.corpo','db_iframe_empagetipo','func_empagetipo.php?e60_numemp='+$('e60_numemp').value+'&funcao_js=parent.js_mostracontapagadora1|e83_codtipo|e83_conta|e83_descr','Pesquisa',true);
    } else {

        if ($('e83_conta').value != '') {
            js_OpenJanelaIframe('top.corpo','db_iframe_empagetipo','func_empagetipo.php?pesquisa_chave='+$('e83_conta').value+'&e60_numemp='+$('e60_numemp').value+'&e83_conta='+$('e83_conta').value+'&funcao_js=parent.js_mostracontapagadora','Pesquisa',false);
        } else {
            $('e83_descr').value    = '';
            $('e83_codtipo').value  = '';
        }
    }

}

function js_mostracontapagadora(chave1,chave2,erro) {

    $('e83_descr').value    = chave1;
    $('e83_codtipo').value  = chave2;
    if (erro == true) {

        $('e83_codtipo').value = '';
        $('e83_conta').value    = '';
        $('e83_codtipo').focus();

    }

}

function js_mostracontapagadora1(chave1,chave2,chave3) {

    $('e83_codtipo').value  = chave1;
    $('e83_conta').value    = chave2;
    $('e83_descr').value    = chave3;
    db_iframe_empagetipo.hide();

}
$('informacaoop').style.width ='100%';
$('historico').style.width ='100%';
$('contribuicaoPrev').style.width =' 489px';
$('aIncide').style.width =' 120px';



$("o15_descr").style.width = "222px";
</script>
