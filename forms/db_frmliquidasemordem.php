<?php
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
$clrotulo->label("e11_cfop");
$clrotulo->label("e10_cfop");
$clrotulo->label("e11_seriefiscal");
$clrotulo->label("e11_inscricaosubstitutofiscal");
$clrotulo->label("e11_valoricmssubstitutotrib");
$clrotulo->label("e11_basecalculoicmssubstitutotrib");
$clrotulo->label("e11_basecalculoicms");
$clrotulo->label("e11_valoricms");
$clrotulo->label("e12_descricao");
$clrotulo->label("e10_descricao");
$db_opcao = 1;
$clorctiporec->rotulo->label();
$clempempenho->rotulo->label();
$clorcdotacao->rotulo->label();
$clpagordemele->rotulo->label();
$clpagordemnota->rotulo->label();
$clempnota->rotulo->label();
$clempnotaele->rotulo->label();
$cltabrec->rotulo->label();
if ($tela_estorno){

  $operacao  = 2;//operacao a ser realizada:1 = liquidacao, 2 estorno/
  $labelVal  = "SALDO A ESTORNAR";
  $metodo    = "estornarLiquidacaoAJAX";

}else{

  $operacao  = 1;//operacao a ser realizada:1 = liquidacao, 2 estorno
  $labelVal  = "SALDO A LIQUIDAR";
  $metodo    = "liquidarAjax";
}
$db_opcao_inf = 1;
$aParamKeys   = array(
  "cc09_anousu" => db_getsession("DB_anousu"),
  "cc09_instit" => db_getsession("DB_instit"),
);
$aParametrosCustos   = db_stdClass::getParametro("parcustos",$aParamKeys);
$iTipoControleCustos = 0;
$iControlaPit        = 0;

if (count($aParametrosCustos) > 0) {
  $iTipoControleCustos = $aParametrosCustos[0]->cc09_tipocontrole;
}

$aParamKeys = array(
  db_getsession("DB_instit")
);
$aParametrosPit   = db_stdClass::getParametro("matparaminstit",$aParamKeys);
if (count($aParametrosPit) > 0) {
  $iControlaPit = $aParametrosPit[0]->m10_controlapit;
}

$lUsaPCASP = "false";
if (USE_PCASP) {
  $lUsaPCASP = "true";
}

?>
<!-- <center> -->
<script language="JavaScript" type="text/javascript" src="scripts/widgets/DBToogle.widget.js"></script>
  <form name=form1 action="" method="POST">
    <center>
      <table >
      <tr>
        <td valign="top">
          <fieldset ><legend><b>&nbsp;Empenho&nbsp;</b></legend>
            <table>
              <tr>
                <td><?=db_ancora($Le60_codemp,"js_JanelaAutomatica('empempenho',\$F('e60_numemp'))",$db_opcao_inf)?></td>
                <td><? db_input('e60_codemp', 13, $Ie60_codemp, true, 'text', 3)?> </td>
                <!-- <td nowrap="nowrap"><?=db_ancora($Le60_numemp,"js_JanelaAutomatica('empempenho',\$F('e60_numemp'))",$db_opcao_inf)?></td> -->
                <td style="display: none"><? db_input('e60_numemp', 13, $Ie60_numemp, true, 'text', 3)?> </td>
              </tr>
              <tr>
                <td><?=db_ancora($Le60_coddot,"js_JanelaAutomatica('orcdotacao',\$F('e60_coddot'),'".@$e60_anousu."')",$db_opcao_inf)?></td>
                <td nowrap ><? db_input('e60_coddot', 13, $Ie60_coddot, true, 'text', 3); ?></td>
                <!-- <td width="20"><?=db_ancora($Lo15_codigo,"",3)?></td> -->
                <!-- <td></td> -->
                <td nowrap><? 
                            db_input('o15_codigo', 5, $Io15_codigo, true, 'hidden', 3); 
                            db_input('o15_descr', 5, $Io15_descr, true, 'hidden', 3);
                            db_input('estruturalDotacao', 55, 3, true, 'text', 3);?></td>
              </tr>
              <tr>
                <td><?=db_ancora($Le60_numcgm,"js_JanelaAutomatica('cgm',\$F('e60_numcgm'))",$db_opcao_inf)?></td>
                <td><? db_input('e60_numcgm', 13, $Ie60_numcgm, true, 'text', 3); ?> </td>
                <!-- <td></td> -->
                <td colspan=2><? db_input('z01_nome', 55, $Iz01_nome, true, 'text', 3, '');?></td>
              </tr>
              <tr>
                <!-- Oc17910 -->
                <td>
                    <div class='cgm_emitente'><?php db_ancora("<strong><u>CGM Emitente:&nbsp;</u></strong>", "js_pesquisaz01_numcgm(true);", 1); ?></div>
                    <div class="credor" hidden='true'><?=db_ancora('<b>Credor:</b>',"js_pesquisae49_numcgm(true)",1)?></div>
                </td>
                <td>
                    <div class='cgm_emitente'>
                        <?php db_input('z01_numcgm', 13, "", true, 'text', 1, " onchange='js_pesquisaz01_numcgm(false);'", "", "", ""); ?>
                    </div>
                    <div class="credor" hidden='true'>
                        <? db_input('e49_numcgm', 13, $Ie60_numcgm, true, 'text', 1,"onchange='js_pesquisae49_numcgm(false)'"); ?> 
                    </div>
                </td>
                <!-- <td></td> -->
                <td colspan=2>
                    <div class="cgm_emitente"><? db_input('descricao_emitente', 55, "", true, 'text', 3, 'style="background-color: rgb(222, 184, 135);"');?> </div>    
                    <div class="credor" hidden='true'><? db_input('z01_credor', 55, $Iz01_nome, true, 'text', 3, '');?> </div>
                </td>
              </tr>
              <tr>
                <td><?db_ancora("<b>Conta Pagadora:</b>","js_pesquisa_contapagadora(true);",1);?></td>
                <td>
                    <? 
                    db_input("e83_conta",13,1,true,"text",4,"onchange='js_pesquisa_contapagadora(false);'"); 
                    ?>
                </td>
                <td>
                    <?    
                    db_input("e83_codtipo",5,1,true,"hidden");
                    ?>
                <? db_input("e83_descr",55,"",true,"text",3); ?></td>
              </tr>
                <tr>
                    <!-- Oc17910 -->
                    <td><b>NF Matriz/Filial: </b></td>
                    <td colspan="3">
                        <select name="nf_matriz_filial" id="nf_matriz_filial" style='width:99.5%'>
                            <option value='s'>Sim</option>
                            <option value='n' selected>Não</option>
                        </select>
                    </td>
                    <!-- end Oc1790 -->
                </tr>
              <tr>
              <td nowrap ><b>Nota Fiscal Eletronica: </b></td>
                <td colspan='2'>
                
                  <?
                  /**
                   * Acrescentado por causa do sicom
                   */
                  $aNfEletronica = array(1 => 'Sim, padrão Estadual ou SINIEF 07/05',2 => 'Sim, chave de acesso municipal ou outra',3 => 'Não',4 => 'Sim, padrão Estadual ou SINIEF 07/05 - Avulsa');
                  db_select('e69_notafiscaleletronica', $aNfEletronica, true, 1, "onchange='js_tipoChave(this.value);'");
                  ?>
                </td>  
              <tr id='controlepit' style='display: <?=$iControlaPit==1?"":"none"?>'>
                <td><b>Tipo da Entrada: </b></td>
                <td colspan="4">
                  <?
                  $oDaoDocumentoFiscais = db_utils::getDao("tipodocumentosfiscal");
                  $rsDocs = $oDaoDocumentoFiscais->sql_record($oDaoDocumentoFiscais->sql_query(null, "*", "e12_sequencial"));
                  $aItens[0] = "selecione";
                  for($i = 0; $i < $oDaoDocumentoFiscais->numrows; $i ++) {

                    $oItens = db_utils::fieldsMemory($rsDocs, $i);
                    $aItens [$oItens->e12_sequencial] = $oItens->e12_descricao;

                  }
                  db_select('e69_tipodocumentofiscal', $aItens, true, 1, "onchange=js_abreNotaExtra()");
                  ?>
                  <a href='#' onclick='js_abreNotaExtra()' style='display: none'
                     id='dadosnotacomplementar'>Outros Dados</a>
                </td>
              </tr>
              <input type="hidden" value="true" name="permitido_Liquidacao" id="permitido_Liquidacao"/>
              <tr>
                <td nowrap><b>Número da Nota:</b></td>
                <td colspan='2'><?db_input('e69_numnota', 19, '', true, 'text', 1,"","","","",20); ?>            
                <!-- OC 12746 -->
                <b>Número de série: </b>
                <?
                db_input('e69_nfserie', 80, 0, true, 'text', 3, "","","","",8);
                ?>
                <b>Data da Nota:</b><?db_inputData('e69_dtnota', '', '','', true, 'text', 1); ?></td>
              </tr>
              <!-- <tr>
              <td nowrap>
                </td>
                <td>
                  <?
                  /**
                   * Acrescentado por causa do sicom
                   */
                  
                  ?>
                </td>
                </tr>     -->
              <tr>      
                <td nowrap><b>Chave Acesso: </b></td>
                <td colspan='2'>
                  <?
                  /**
                   * Acrescentado por causa do sicom
                   */
                  db_input('e69_chaveacesso', 70, 0, true, 'text', 1, "onchange='js_verificaChaveAcesso(this.value);'","","","",44);
                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap>
                    <b>Data da Liquidação:</b>
                    </td>
                    <td colspan='2'>
                      <?db_inputdata('dataLiquidacao','','','',true,'text',1)?>
                      <b>Data de Vencimento:</b>
                      <?db_inputdata('dataVencimento','','','',true,'text',1)?>
                </td>
              </tr>
              <tr>    
                <td>
                  <strong>Processo Administrativo:</strong>
                </td>
                <td colspan='2'>
                  <?php db_input('e03_numeroprocesso', 70, '', true, 'text', $db_opcao, null, null, null, null, 15); ?>
                </td>

              </tr>
              <tr>
              <td nowrap id="competDespLabel" style="display: none"><b>Competência da Despesa: </b></td>
                <td style="display: none" id="competDespInput">
                  <?db_inputData('e50_compdesp', '', '', '', true, 'text', 1); ?>
                  <input type="hidden" name="sEstrutElemento" id="sEstrutElemento"/>
                </td>
            </tr>  

              <!--[Extensao OrdenadorDespesa] inclusao_ordenador-->

            </table>
          </fieldset>
        </td>
        <td rowspan="1" valign="top" style='height:100%;'>
          <fieldset ><legend><b>&nbsp;&nbsp;&nbsp;&nbsp;Valores do Empenho&nbsp;</b></legend>
            <table >
              <tr><td nowrap><?=@$Le60_vlremp?></td><td align=right><? db_input('e60_vlremp', 12, $Ie60_vlremp, true, 'text', 3, '','','','text-align:right')?></td></tr>
              <tr><td nowrap><?=@$Le60_vlranu?></td><td align=right><? db_input('e60_vlranu', 12, $Ie60_vlranu, true, 'text', 3, '','','','text-align:right')?></td></tr>
              <tr><td nowrap><?=@$Le60_vlrliq?></td><td align=right><? db_input('e60_vlrliq', 12, $Ie60_vlrliq, true, 'text', 3, '','','','text-align:right')?></td></tr>
              <tr><td nowrap><?=@$Le60_vlrpag?></td><td align=right><? db_input('e60_vlrpag', 12, $Ie60_vlrpag, true, 'text', 3, '','','','text-align:right')?></td></tr>
              <!-- Extensao [CotaMensalLiquidacao] - Parte 1 -->
              <tr><td nowrap><b>Saldo</b></td><td align=right><? db_input('saldodis', 12, 0, true, 'text', 3, '','','','text-align:right')?></td></tr>
            </table>
          </fieldset>
        </td>
      </tr>
      <td colspan="2"> 
 <fieldset id='esocial'><legend><b>eSocial</b></legend>
 <table ><tr>
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
                  <td id='cattrab2'><? db_input('ct01_descricaocategoria', 48, $Ict01_descricaocategoria, true, 'text', 3, '');?></td>
        </tr>
        <tr>
                <td id="idvinculos">
                <strong>O trabalhador possui outro vínculo/atividade com desconto previdenciário: </strong>
                <td colspan="4">
                <?
                  $multiplosvinculos = array(''=>'Selecione','1'=>'Sim', '2'=>'Não');
                  db_select('multiplosvinculos', $multiplosvinculos, true, 1, "onchange='validarVinculos()'"); 
                ?>
                </td>
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
                  db_select('contribuicaoPrev', $aContribuicao, true, 1, ""); 
                ?>
                </td>
        </tr>
        <tr >
                  <td id='empresa'><?=db_ancora('<b>Empresa que efetuou desconto:</b>',"js_pesquisaEmpresa(true)",1)?></td>
                  <td id='empresa1'><? db_input('numempresa', 15, $Inumempresa, true, 'text', 1,"onchange='js_pesquisaEmpresa(false)'"); ?> </td>
                  <td id='empresa2'><? db_input('nomeempresa', 48, $Inomeempresa, true, 'text', 3, '');?></td>
        </tr>
        <tr>
                  <td id='catremuneracao'><?=db_ancora('<b>Categoria do trabalhador na qual houve a remuneração:</b>',"js_pesquisaCatTrabalhadorremuneracao(true)",1)?></td>
                  <td id='catremuneracao1'><? db_input('ct01_codcategoriaremuneracao', 15, $Ict01_codcategoriaremuneracao, true, 'text', 1,"onchange='js_pesquisaCatTrabalhadorremuneracao(false)'"); ?> </td>
                  <td id='catremuneracao2'><? db_input('ct01_descricaocategoriaremuneracao', 48, $Ict01_descricaocategoriaremuneracao, true, 'text', 3, '');?></td>
        </tr>
        

        <tr>
                  <td id='vlrremuneracao'><strong>Valor da Remuneração:</strong></td>
                  <td id='vlrremuneracao1'>
                    <?
                    db_input('valorremuneracao', 15, '4', true, 'text', 1, "onchange='casasdecimais(1)'",'','','text-align:right');
                    ?>
                  </td>
        </tr>
        <tr>
                  <td id='vlrdesconto'><strong>Valor do Desconto:</strong></td>
                  <td id='vlrdesconto1'>
                    <?
                    db_input('valordesconto', 15, '4', true, 'text', 1, "onchange='casasdecimais(2)'",'','','text-align:right');
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
  <tr>
    <td colspan='2'>
      <?include("forms/db_frmliquidaboxreinf.php");?>
    </td>
  </tr>
  <tr>
    <td colspan='2'>
      <?include("forms/db_frmliquidaboxdiarias.php");?> 
    </td>
  </tr>
    <tr>
      <td colspan="2">
        <fieldset><legend><b>&nbsp;Itens&nbsp;</b></legend>  
            <div style='border:2px inset white'>
              <table  cellspacing=0 cellpadding=0 width='100%' >
                <tr>
                  <th class='table_header' >
                    <input type='checkbox'  style='display:none' id='mtodos' onclick='js_marca()'>
                    <a onclick='js_marca()' style='cursor:pointer'>M</a></b></th>
                  <th class='table_header' width='48%'>Item</th>
                  <!-- <th class='table_header' width='10%'>Sequência</th> -->
                  <th class='table_header' width='10%'>Valor Unitário</th>
                  <th class='table_header' width='10%'>Quantidade</th>
                  <th class='table_header' width='10%'>Valor Total</th>
                  <th class='table_header' width='10%'>Quantidade <br>Entregue</th>
                  <th class='table_header' width='10%'>Valor <br>Entregue</th>
                  <?
                  if ($iTipoControleCustos > 0) {
                    echo "<th class='table_header'>Centro de Custo</th>";
                  }

                  ?>
                  <!-- <th class='table_header' style='width:18px'>&nbsp;</th> -->
                </tr>
                <tbody id='dados' style='height:150px;width:95%;overflow:scroll;overflow-x:hidden;background-color:white'>
                </tbody>
                <tfoot>
                <tr>
                  <th colspan='6' style='text-align:right' class='table_footer'>Valor Total:</th>
                  <th class='table_footer' id='valorTotalItens'>&nbsp;</th>
                  <?
                  if ($iTipoControleCustos > 1) {
                    echo "<th class='table_footer' >&nbsp;</th>";
                  }

                  ?>
                  <!-- <th class='table_footer' style='width:18px'>&nbsp;</th> -->
                </tr>
                </tfoot>
              </table></div>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td colspan='2' >
          <fieldset ><legend><b>&nbsp;Histórico&nbsp;</b></legend>  
            <table>
            <tr>
                <td id='opcredito' style="display: none">
                  <?
                  db_textarea('informacaoop',5,128,0,true,'text',1,"");
                  ?>
                </td>
              </tr>
            <tr>
                <td id='ophisotrico' style="display: none">
                  <?
                  db_textarea('historico',5,128,0,true,'text',1,"");
                  ?>
                </td>
              </tr>
            </table>
          </fieldset>
      <tr>
        <td colspan=2>
          <div style="display:flex; justify-content:center; gap:1%">
            <input name="confirmar"  type="button" id="confirmar"  value="Confirmar" onclick="return js_liquidar('<?=$metodo?>')" disabled>
            <input name="pesquisar"  type="button" id="pesquisar"  value="Pesquisar" onclick="js_pesquisa();" >
            <input name="zeraritens" type="button" id="zeraritens" value="Zerar Itens" onclick="js_zeraItens();" >
            <input name="preenche"   type="button" id="preenche"   value="Preencher Itens" onclick="js_preencheItens();" >
            <input name="retencoes"  type="button" id="retencoes"  disabled value="Retenções" onclick="js_lancarRetencao();" >
            <input name="iCodMov"    type="hidden" id="e81_codmov" value=""  >
            <input name="iCodOrd"    type="hidden" id="e50_codord" value=""  >
            <input name="iCodNota"   type="hidden" id="e69_codnota" value=""  >
          </div>
        </td>
      </tr>
    </form>
    <tr id='divDadosNotaAux' style='display:none; text-align: center;' >
      <td colspan='2'>
        <fieldset id='dadosComplementaresFieldset'>
          <legend>
            <b>Dados Complementares</b>
          </legend>
          <table align="left">
            <tr>
              <td nowrap title="<?=@$Te11_cfop?>">
                <?
                db_ancora("<b>CPOF</b>","js_pesquisae11_cfop(true);",$db_opcao);
                ?>
              </td>
              <td nowrap>
                <?
                db_input('e11_cfop',10,$Ie11_cfop,true,'hidden',3," onchange='js_pesquisae11_cfop(false);'");
                db_input('e10_cfop',10,$Ie10_cfop,true,'text',$db_opcao," onchange='js_pesquisae11_cfop(false);'");
                db_input('e10_descricao',40,$Ie10_descricao,true,'text',3,'')
                ?>
              </td>
            </tr>
            <tr>
              <td  nowrap>
                <b>Série:</b>
              </td>
              <td  nowrap>
                <?
                db_input('e11_seriefiscal',10,$Ie11_seriefiscal,true,'text',1,'');
                ?>
              </td>
            </tr>
            <tr>
              <td  nowrap>
                <b>Inscrição Subst.Fiscal:</b>
              </td>
              <td  nowrap>
                <?
                db_input('e11_inscricaosubstitutofiscal',10,$Ie11_inscricaosubstitutofiscal,true,'text',1,'');
                ?>
              </td>
            </tr>
            <tr>
              <td  nowrap>
                <b>Base Calculo ICMS:</b>
              </td>
              <td  nowrap>
                <?
                db_input('e11_basecalculoicms',10,@$Ie11_basecalculoicms,true,'text',1,'');
                ?>
              </td>
            </tr>
            <tr>
              <td  nowrap>
                <b>Valor ICMS:</b>
              </td>
              <td  nowrap>
                <?
                db_input('e11_valoricms',10,$Ie11_valoricms,true,'text',1,'');
                ?>
              </td>
            </tr>
            <tr>
              <td  nowrap>
                <b>Base Calculo ICMS Substituto:</b>
              </td>
              <td  nowrap>
                <?
                db_input('e11_basecalculosubstitutotrib',10,@$Ie11_basecalculosubstitutotrib,true,'text',1,'');
                ?>
              </td>
            </tr>
            <tr>
              <td  nowrap>
                <b>Valor ICMS Substituto:</b> 
              </td>
              <td  nowrap>
                <?
                db_input('e11_valoricmssubstitutotrib',10,$Ie11_valoricmssubstitutotrib,true,'text',1,'');
                ?>
              </td>
            </tr>
            <tr>
              <td colspan="4" style='text-align: center'>
              </td>
            </tr>
          </table>
        </fieldset>
        <input type='button' value='Salvar Informações' onclick='windowAuxiliarNota.hide()'>
      </td>
    </tr>
  </table>
</center>
<script>
  var oDBToogleDiarias = new DBToogle('diariaFieldset', false);
  document.getElementById("e69_notafiscaleletronica").style.width="99.5%"; 
  document.getElementById("e69_dtnota").style.width="80px";
  document.getElementById("e69_nfserie").style.width="85px";
  
  iTipoControle = <?=$iTipoControleCustos;?>;
  iControlaPit  = <?=$iControlaPit?>;
  function dataFormatada(date){
    function pad(s) { return (s < 10) ? '0' + s : s; }
    var d = new Date(date);
    return [pad(d.getDate()+1), pad(d.getMonth()+1), d.getFullYear()].join('/');
  }
  var lUsaPCASP = <?php echo $lUsaPCASP;?>;


  function js_emitir(codordem){
    jan = window.open('emp2_emitenotaliq002.php?codordem='+codordem,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
    jan.moveTo(0,0);
  }
  function js_pesquisa(){    
    document.form1.reset();
    js_OpenJanelaIframe('top.corpo','db_iframe_empempenho','func_empempenho.php?funcao_js=parent.js_preenchepesquisa|e60_numemp|si172_nrocontrato|si172_datafinalvigencia|si174_novadatatermino','Pesquisa',true);
  }
  function js_preenchepesquisa(chave,chave2,chave3,chave4){
    r = true;
    if(chave3 != "") {
      data1 = new Date(chave3);
      data2 = new Date(chave4);
      dataAtual = new Date();
      if(chave4 != ""){
        if(data2 < dataAtual){
          var r = confirm("Atenção! Empenho com o contrato "+chave2+" vencido em "+dataFormatada(data2)+". Deseja continuar?");
        }
      }else{
        if(data1 < dataAtual){
          var r = confirm("Atenção! Empenho com o contrato "+chave2+" vencido em "+dataFormatada(data1)+". Deseja continuar?");
        }
      }
    }

    if(r == true) {
      db_iframe_empempenho.hide();
      js_consultaEmpenho(chave, <?=$operacao?>);
    }
  }
  function casasdecimais(escolha){
         var valorremuneracao = (document.form1.valorremuneracao.value).indexOf('.');
         var valordesconto = (document.form1.valordesconto.value).indexOf('.');
         if(escolha == '1' && valorremuneracao > 0 ){
          var virgula = document.form1.valorremuneracao.value.substring(valorremuneracao + 0);
          document.form1.valorremuneracao.value = document.form1.valorremuneracao.value.substring(0, valorremuneracao)+virgula.substring(0,3);
         }if(escolha == '2' && valordesconto > 0){
          var virgula = document.form1.valordesconto.value.substring(valordesconto + 0);
          document.form1.valordesconto.value = document.form1.valordesconto.value.substring(0, valordesconto)+virgula.substring(0,3);              
         }                     
}
function validarVinculos(){ 
  if(document.form1.multiplosvinculos.value == '1'){
      document.getElementById('idcontri').style.display = "table-cell";
      document.getElementById('contribuicaoPrev').style.display = "table-cell";
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
  if(document.form1.multiplosvinculos.value == '2'){
      document.getElementById('idcontri').style.display = "none";
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
      document.form1.contribuicaoPrev.value= '';
  }
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
      document.getElementById('multiplosvinculos').style.display = "none";
      document.getElementById('idvinculos').style.display = "none";
      document.form1.numempresa.value = '';
      document.form1.nomeempresa.value = '';
      document.form1.ct01_codcategoriaremuneracao.value = '';
      document.form1.ct01_descricaocategoriaremuneracao.value = '';
      document.form1.valorremuneracao.value = '';
      document.form1.valordesconto.value = '';
      document.form1.competencia.value= '';
      document.form1.multiplosvinculos.value= '';
      }
    else
      {
      document.form1.aIncide.value = '1';
      return false;
      }
  }else{
      document.getElementById('cattrab').style.display = "table-cell";
      document.getElementById('cattrab1').style.display = "table-cell";
      document.getElementById('cattrab2').style.display = "table-cell";
      document.getElementById('ct01_codcategoria').style.display = "table-cell";
      document.getElementById('ct01_descricaocategoria').style.display = "table-cell";
      document.getElementById('multiplosvinculos').style.display = "table-cell";
      document.getElementById('idvinculos').style.display = "table-cell";
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
      document.getElementById('idcontri').style.display = "none";
      document.getElementById('contribuicaoPrev').style.display = "none";
   
  function js_marca(){

    obj = document.getElementById('mtodos');
    if (obj.checked){
      obj.checked = false;
    }else{
      obj.checked = true;
    }
    itens = js_getElementbyClass(form1,'chkmarca');
    for (var i = 0;i < itens.length;i++){
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

  function js_pesquisae11_cfop(mostra){
    if(mostra==true){
      js_OpenJanelaIframe('CurrentWindow.corpo',
        'db_iframe_cfop',
        'func_cfop.php?funcao_js=parent.js_mostracfop1|e10_sequencial|e10_descricao|e10_cfop',
        'Pesquisa CFOP',true);
    }else{
      if($('e10_cfop').value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo',
          'db_iframe_cfop',
          'func_cfop.php?pesquisa_chave='+$('e10_cfop').value+'&funcao_js=parent.js_mostracfop',
          'Pesquisa CFOP',false);
      }else{
        $('e10_descricao').value = '';
      }
    }
  }
  function js_mostracfop(chave,chave2, erro){

    $('e10_descricao').value = chave;
    $('e11_cfop').value      = chave2;
    if(erro==true){
      $('e10_cfop').focus();
      $('e10_cfop').value = '';
    }
  }
  function js_mostracfop1(chave1,chave2, chave3){

    $('e11_cfop').value = chave1;
    $('e10_descricao').value = chave2;
    $('e10_cfop').value = chave3;
    db_iframe_cfop.hide();

  }

  function js_consultaEmpenho(iNumeroEmpenho, operacao) {

    js_divCarregando("Aguarde, efetuando pesquisa","msgBox");
    strJson = '{"method":"getEmpenhos","pars":"'+iNumeroEmpenho+'","operacao":"1","itens":"1","iEmpenho":"' + iNumeroEmpenho + '"}';
    $('dados').innerHTML    = '';
    $('e69_tipodocumentofiscal').value       = 0;
    $('e11_valoricms').value                 = "";
    $('e11_valoricmssubstitutotrib').value   = "";
    $('e11_basecalculosubstitutotrib').value = "";
    $('e11_basecalculoicms').value           = "";
    $('e11_inscricaosubstitutofiscal').value = "";
    $('e11_cfop').value                      = "";
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

  /**
   * valida exibicao do aviso dos grupos de itens de consumo imediato
   */
  var iEmpenho = null;
  var lLiberaItemLiquidacao  = true;

  /* Extensao [CotaMensalLiquidacao] - Parte 2 */

  var opcaoReinf = 0;
  function js_saida(oAjax) {
    document.form1.reset();
    js_removeObj("msgBox");
    obj  = eval("("+oAjax.responseText+")");
    var sMensagemGrupoDesdobramento = null;

    if (obj.e60_numemp != iEmpenho) {
      lLiberaItemLiquidacao  = true;
    }

    /**
     * Exibe aviso dos grupos 7,8,9 e 10 de desdobramentos de consumo imediato 
     */
    if (obj.e60_numemp != iEmpenho && (lUsaPCASP == true || lUsaPCASP == 'true')) {

      /**
       * Para nao exibir mais de uma vez 
       */
      if (obj.oGrupoElemento.iGrupo != "") {

        var sGrupo = obj.oGrupoElemento.sGrupo.urlDecode();

        switch (obj.oGrupoElemento.iGrupo) {

          case "9":

            sMensagemGrupoDesdobramento  = "O desdobramento deste empenho está no grupo " + sGrupo;
            sMensagemGrupoDesdobramento += "\nPara desdobramentos deste grupo não é possivel liquidar através desta rotina.";
            lLiberaItemLiquidacao  = false;

            break;

          case "7":
          case "8":
          case "10":
            sMensagemGrupoDesdobramento = _M('financeiro.empenho.emp4_empempenho004.liquidacao_item_consumo_imediato', {sGrupo : sGrupo});
            break;
        }
      }
    }

    $('e60_codemp').value  = obj.e60_codemp.urlDecode()+"/"+obj.e60_anousu.urlDecode();
    $('e60_numemp').value  = obj.e60_numemp.urlDecode();
    $('e60_numcgm').value  = obj.e60_numcgm.urlDecode();
    $('z01_nome').value    = obj.z01_nome.urlDecode();
    $('e49_numcgm').value  = '';
    $('z01_credor').value  = '';
    $('e60_coddot').value  = obj.e60_coddot.urlDecode();
    $('estruturalDotacao').value  = obj.estruturalDotacao.urlDecode();
    $('o15_codigo').value  = obj.o58_codigo;
    $('o15_descr').value   = obj.o15_descr.urlDecode();
    $('e60_vlremp').value  = obj.e60_vlremp;
    $('e60_vlranu').value  = obj.e60_vlranu;
    $('e60_vlrpag').value  = obj.e60_vlrpag;
    $('e60_vlrliq').value  = obj.e60_vlrliq;
 
    if(obj.e60_informacaoop != null || obj.e60_informacaoop !=""){
      $('informacaoop').value   = obj.e60_informacaoop.urlDecode();
      if (!obj.e60_resumo){
        $('historico').value   = obj.e60_informacaoop.urlDecode();
      }else{
        $('historico').value   = obj.e60_resumo.urlDecode();
      }       
    }
    else{
      $('informacaoop').value   = obj.e60_resumo.urlDecode();
      $('historico').value   = obj.e60_resumo.urlDecode();
    }
  
    $('saldodis').value    = obj.saldo_dis;
    $('e69_numnota').value = '';
    $('sEstrutElemento').value = obj.sEstrutural;
    saida = '';
    $('dados').innerHTML   = '';
    iTotItens = 0;
    estrutural             = obj.sEstrutural;
    desdobramento         = obj.sDesdobramento;
    obrigaDiaria          = obj.obrigaDiaria == 't' ? true : false;
    $('e50_compdesp').value = '';

    $('reinfRetencao').value = 0;
    $('naturezaCod').value   = '';
    $('naturezaDesc').value  = '';
    $('reinfRetencaoEstabelecimento').value = 0;
    js_validarEstabelecimentos();

    oDBToogleDiarias.show(obrigaDiaria);

    var lBloquearItens = false;
    if (obj.e60_vlremp == obj.e60_vlrpag) {
      lBloquearItens = true;
    }

    if(obj.e60_informacaoop){ 
      document.getElementById('opcredito').style.display = "table-cell";
      document.getElementById('ophisotrico').style.display = "none";
    } else {
      document.getElementById('opcredito').style.display = "none";
      document.getElementById('ophisotrico').style.display = "table-cell";
    }

    var db_opcao = "<?php print $op; ?>";
   
    if(db_opcao != '3' && obj.Tipofornec == 'cpf'  &&  !(desdobramento.substr(0, 3) == '331' || desdobramento.substr(0, 3) == '345' 
                                                      || desdobramento.substr(0, 3) == '346' || desdobramento.substr(0, 7) == '3339018' 
                                                      || desdobramento.substr(0, 7) == '3339019' || desdobramento.substr(0, 7) == '3339014' 
                                                      || desdobramento.substr(0, 7) == '3339008' || desdobramento.substr(0, 7) == '3339059' 
                                                      || desdobramento.substr(0, 7) == '3339046' || desdobramento.substr(0, 7) == '3339048'
                                                      || desdobramento.substr(0, 7) == '3339049' || desdobramento == '333903602' 
                                                      || desdobramento == '333903603' || desdobramento == '333903607' || desdobramento == '333903608' 
                                                      || desdobramento == '333903609' || desdobramento == '333903614' || desdobramento == '333903640' 
                                                      || desdobramento == '333903641')){
     tipodesdobramento = 1;  
     opcao = 1;                                 
     document.getElementById('esocial').style.display = "table-cell";
   }else{
     document.getElementById('esocial').style.display = "none";
     tipodesdobramento = 0;
     opcao = 3;
   }
     if(db_opcao != '3' && (obj.Tipofornec == 'cnpj' && !(desdobramento.substr(0, 3) == '331' || desdobramento.substr(0, 3) == '345' || desdobramento.substr(0, 3) == '346'
                                  || desdobramento.substr(0, 3) == '332' || desdobramento.substr(0, 7) == '3335041' || desdobramento.substr(0, 7) == '3333041'
                                  || desdobramento.substr(0, 7) == '3337041' || desdobramento.substr(0, 7) == '3339008' || desdobramento.substr(0, 7) == '3339041' 
                                  || desdobramento.substr(0, 7) == '3339043' || desdobramento.substr(0, 7) == '3339045' || desdobramento.substr(0, 7) == '3339046' 
                                  || desdobramento.substr(0, 7) == '3339047' || desdobramento.substr(0, 7) == '3339048' || desdobramento.substr(0, 7) == '3339049' 
                                  || desdobramento.substr(0, 7) == '3339059' || desdobramento.substr(0, 7) == '3339086' || desdobramento.substr(0, 5) == '33371' 
                                  || desdobramento.substr(0, 5) == '34471' || desdobramento.substr(0, 7) == '3335043')) 
                                  || (obj.Tipofornec == 'cpf' && desdobramento == '333903614')){
      $('reinf').style.display = "table-cell";
      js_validarEstabelecimentos(true);
      if(obj.Tipofornec == 'cpf' && desdobramento == '333903614'){
        $('naturezaCod').value = '13002';
        $('naturezaDesc').value = 'Rendimentos de Aluguéis, Locação ou Sublocação';
        $('reinfRetencao').value = 'sim';
      } 
      opcaoReinf = 1;
    }else{
      $('reinf').style.display = "none";
      opcaoReinf = 3;
    }

    let desdobramentoDiaria = desdobramento.substr(5, 2);
    if((desdobramentoDiaria == '14' || desdobramentoDiaria == '33') && obrigaDiaria == true){
      $('diariaFieldset').style.display = "table-cell";
      $('diariaViajante').value = obj.z01_nome.urlDecode();
      let oParam        = new Object();
      oParam.exec     = 'consultaMatricula';
      oParam.iNumCgm    = obj.e60_numcgm;
      oAjax    = new Ajax.Request(
                              'pes1_rhpessoal.RPC.php',
                                {
                                method: 'post',
                                parameters: 'json='+Object.toJSON(oParam),
                                onComplete: function(oAjax){
                                  oRetorno = eval("("+oAjax.responseText+")");
                                  if(oRetorno.iStatus === 1){
                                    $('e140_matricula').value = oRetorno.rh01_regist;
                                    $('e140_cargo').value = oRetorno.rh37_descr;
                                  }
                                }
                                }
                              );
    }else{
      $('diariaFieldset').style.display = "none";
    }

    aMatrizEntrada = ['3319092', '3319192', '3319592', '3319692'];

    if (aMatrizEntrada.indexOf(estrutural) !== -1) {
      document.getElementById('competDespLabel').style.display = "table-cell";
      document.getElementById('competDespInput').style.display = "table-cell";
    } else {
      document.getElementById('competDespLabel').style.display = "none";
      document.getElementById('competDespInput').style.display = "none";
    }

    if (obj.numnotas > 0){

      for (i = 0; i < obj.data.length;i++){

        var sDisabilitaQuantidade  = '';
        var sDesabilitaValor       = '';
        descrmater = obj.data[i].pc01_descrmater.replace(/\+/g," ");
        descrmater = unescape(descrmater);
        sClassName = 'normal';
        if (obj.data[i].libera.trim() == "disabled" || !lLiberaItemLiquidacao) {
          sClassName = 'disabled';
        } else {
          iTotItens++;
        }
        if (obj.data[i].pc01_fraciona == 'f') {
          var lFraciona = false;
        }else{
          var lFraciona = true;
        }
        sDisabilitaValor  = '';
        if(obj.data[i].pc01_servico == 't'){
          var servico = true;
        }else{
          var servico = false;
        }
        if (obj.data[i].pc01_servico == 't' && obj.data[i].servicoquantidade == "f") {
          sDisabilitaQuantidade  = "style= 'text-align:right;background-color:DEB887' disabled";
        }
        if (obj.data[i].pc01_servico == 't'  && obj.data[i].servicoquantidade == "t") {
          sDesabilitaValor  = "style= 'text-align:right;background-color:DEB887' disabled";
        }
        if (obj.data[i].pc01_servico == 'f'  && obj.data[i].servicoquantidade == "f") {
          sDesabilitaValor  = "style= 'text-align:right;background-color:DEB887' disabled";
        }
        if (servico == false && lFraciona == false) {
          sDesabilitaValor  = "style= 'text-align:right;background-color:DEB887' disabled";
        }

        if (lBloquearItens || !lLiberaItemLiquidacao) {
          obj.data[i].libera = "style= 'text-align:right;background-color:DEB887' disabled";
        }

        saida += "<tr class='"+sClassName+"' id='trchk"+obj.data[i].e62_sequen+"' style='height:1em'>";
        saida += "  <td class='linhagrid' style='text-align:center'>";
        saida += "<input id='e70_valor"+obj.data[i].e69_codnota+"' type='text' style='display: none' value='" + obj.data[i].e70_valor+"'>";
        saida += "    <input type='checkbox' "+obj.data[i].libera+" onclick='js_marcaLinha(this)'";
        saida += "           class='chkmarca' name='chk"+obj.data[i].e62_sequen+"'";
        saida += "           id='chk"+obj.data[i].e62_sequen+"' value='"+obj.data[i].e62_sequen+"'>";
        saida += "  </td>";
        saida += "  <td class='linhagrid' id='descr"+obj.data[i].e62_sequen+"' style='text-align:left'>";
        saida +=     descrmater;
        saida += "  </td>";
        // saida += "  <td class='linhagrid' style='text-align:right'>";
        // saida +=      obj.data[i].e62_sequen;
        // saida += "  </td>";
        saida += "  <td class='linhagrid' id='vlruni"+obj.data[i].e62_sequen+"' style='text-align:right'>";
        saida +=     obj.data[i].e62_vlrun;
        saida += "  </td>";
        saida += "  <td class='linhagrid' id='saldo"+obj.data[i].e62_sequen+"' style='text-align:right'>";
        saida +=     obj.data[i].saldo;
        saida += "  </td>";
        saida += "  <td class='linhagrid' id='saldovlr"+obj.data[i].e62_sequen+"' style='text-align:right'>"
        saida +=      obj.data[i].e62_vlrtot;
        saida += "  </td>";
        saida += "  <td class='linhagrid' style='text-align:center;width:10%'>";
        saida += "    <input type='text' name='qtdesol"+obj.data[i].e62_sequen+"'";
        saida += "           id='qtdesol"+obj.data[i].e62_sequen+"' "+sDisabilitaQuantidade;
        saida += "           value='"+obj.data[i].saldo+"' ";
        saida += "           size='5' onkeypress='return js_validaFracionamento(event,"+lFraciona+",this)'";
        saida += "           onblur='js_calculaValor("+obj.data[i].e62_sequen+",1,"+lFraciona+","+servico+")' "+obj.data[i].libera+">";
        saida += "  </td>";
        saida += "  <td class='linhagrid' style='text-align:center;width:10%'>";
        saida += "    <input type='text' name='vlrtot"+obj.data[i].e62_sequen+"'";
        saida += "           id='vlrtot"+obj.data[i].e62_sequen+"'  value='"+obj.data[i].e62_vlrtot+"' "+sDesabilitaValor;
        saida += "           size='5' class='valores' onkeypress='return js_teclas(event)'";
        saida += "          onblur='js_calculaValor("+obj.data[i].e62_sequen+",2,"+lFraciona+","+servico+")' "+obj.data[i].libera+">"
        saida += "  </td>";
        if (iTipoControle > 0) {

          saida += "  <td class='linhagrid' id='custo"+obj.data[i].e62_sequen+"'>";
          saida += "  <span id='cc08_sequencial"+obj.data[i].e62_sequen+"'></span>";
          saida += "  <a id='cc08_descricao"+obj.data[i].e62_sequen+"' href='#' ";
          saida += "     onclick='js_adicionaCentroCusto("+obj.data[i].e62_sequen+","+obj.data[i].e62_sequencial+");";
          saida += " return false'>Escolher</a>";
          saida += "  </td>";

        }
        saida += "</tr>";
      }
    }
    if(obj.liberadolic == true){
      alert('"Usuário: Empenho não liberado para liquidação"');
      location.href = 'emp4_liquidarsemordem001.php';
    }

    if(obj.Zerado == true){
      alert('"ERRO: Número do CPF/CNPJ está zerado. Corrija o CGM do fornecedor e tente novamente"');
      location.href = 'emp4_liquidarsemordem001.php';
    }

    saida += "<tr style='height:auto'><td>&nbsp;</td></tr>";
    $('dados').innerHTML          = saida;

    $('pesquisar').disabled = false;
    if (iTotItens == 0 && lLiberaItemLiquidacao) {

      alert("Todos os Itens já foram liquidados, ou estão em ordem de compra.");
      $('confirmar').disabled = true;

    } else {

      if (!empty(sMensagemGrupoDesdobramento)) {
        alert(sMensagemGrupoDesdobramento);
      }

      $('confirmar').disabled = false;
      js_setValorTotal();
    }

    if (obj.validaContrato == 'f') {
      var respContrato = confirm("Empenho sem contrato vinculado. Deseja continuar mesmo assim?");
      if (respContrato == false) {
        location.href = 'emp4_liquidarsemordem001.php';
      }
    }

    /**
     * Obj nao possui propriedade empenho, cria com valor da proprieade e60_numemp
     */
    if (!obj.hasOwnProperty('empenho') && obj.hasOwnProperty('e60_numemp')) {
      obj.empenho = obj.e60_numemp;
    }

    if (iEmpenho != obj.empenho) {

      $('retencoes').disabled = true;
      $('e81_codmov').value   = "";
      $('e69_codnota').value  = "";
      $('e50_codord').value   = "";
    }

    iEmpenho = obj.e60_numemp;

    /* Extensao [CotaMensalLiquidacao] - Parte 3 */

  }

  function js_marcaLinha(obj){

    if (obj.checked){
      $('tr'+obj.id).className='marcado';
    }else{
      $('tr'+obj.id).className='normal';
    }
    js_setValorTotal();
  }

  function js_liquidar(metodo) {
    itens = js_getElementbyClass(form1,'chkmarca');
    notas = '';
    sV    = '';

    // Condição de período



    if ($F('e69_numnota') == ''){

      alert('Preencha o número da nota.');
      $('e69_numnota').focus();
      return false;
    }

    if ($F('e69_dtnota') == ''){

      alert('Preencha a data da nota.');
      $('e69_dtnota').focus();
      return false;
    }

    if ($F('e69_chaveacesso') == '' && ($F('e69_notafiscaleletronica') == 1 || $F('e69_notafiscaleletronica') == 2 || $F('e69_notafiscaleletronica') == 4) ) {

      alert('A Chave de Acesso deve ser preenchida!');
      $('e69_chaveacesso').focus();
      return false;

    }

    if($F('dataLiquidacao') == ''){
      alert('Campo Data da Liquidação obrigatório!');
      $('dataLiquidacao').focus();
      return false;
    }

  if(document.form1.aIncide.value == 1){ 
   if(opcao != '3' && !document.form1.ct01_codcategoria.value &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
      alert("Campo Categoria do Trabalhador Obrigatorio")
      return false;
   }
   if(opcao != '3' && !document.form1.multiplosvinculos.value &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
        alert("Campo Possui múltiplos vínculos Obrigatorio")
        return false;
    }
    if(document.form1.multiplosvinculos.value == 1 && opcao != '3' && !document.form1.contribuicaoPrev.value &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
      alert("Campo Indicador de Desconto da Contribuição Previdenciária Obrigatorio")
      return false;
   }
   if(!document.form1.numempresa.value &&  opcao != '3' && (document.form1.contribuicaoPrev.value == '1' || document.form1.contribuicaoPrev.value == '2' || document.form1.contribuicaoPrev.value == '3') &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
      alert("Campo Empresa que efetuou desconto Obrigatorio")
      return false;
   }
   if(!document.form1.ct01_codcategoriaremuneracao.value &&  opcao != '3' && (document.form1.contribuicaoPrev.value == '1' || document.form1.contribuicaoPrev.value == '2' || document.form1.contribuicaoPrev.value == '3') &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
      alert("Campo Categoria do trabalhador na qual houve a remuneração Obrigatorio")
      return false;
   }
   if(!document.form1.valorremuneracao.value &&  opcao != '3' && (document.form1.contribuicaoPrev.value == '1' || document.form1.contribuicaoPrev.value == '2' || document.form1.contribuicaoPrev.value == '3') &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
      alert("Campo Valor da Remuneração Obrigatorio")
      return false;
   }
   if(!document.form1.valordesconto.value &&  opcao != '3' && (document.form1.contribuicaoPrev.value == '2' || document.form1.contribuicaoPrev.value == '3') &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
      alert("Campo Valor do Desconto Obrigatorio")
      return false;
   }
   if(!document.form1.competencia.value &&  opcao != '3' && (document.form1.contribuicaoPrev.value == '1' || document.form1.contribuicaoPrev.value == '2' || document.form1.contribuicaoPrev.value == '3') &&  obj.Tipofornec =='cpf' && tipodesdobramento == '1' ){
      alert("Campo Competência Obrigatorio")
      return false;
   }
  }

  if(opcaoReinf != '3'){
    if($('reinfRetencao').value != 0){
      if($('reinfRetencao').value == 'sim' && ($('naturezaCod').value == '' || $('naturezaDesc').value == '')){
        alert("Campo 'Natureza de Bem ou Serviço' Obrigatorio")
        return false;
      }
    }else{
      alert("Campo 'Incide Retenção do Imposto de Renda' Obrigatorio")
      return false;
    }
  }

  if($('reinfRetencaoEstabelecimento').value != 0 && opcaoReinf != '3'){
    if(aEstabelecimentos.length == 0){
      alert("Informe um estabelecimento");
    return false;
    }
  }

  const aNAturezasCpf = ['15','17','18','19','20'];
  if(obj.Tipofornec =='cpf' && (aNAturezasCpf.includes(($('naturezaCod').value).substr(0,2))) &&  opcaoReinf != '3'){
    alert("A natureza do rendimento é incompatível com o tipo de credor CPF")
    return false;
  }

  const aNaturezasCnpj = ['10','19'];
  if(obj.Tipofornec =='cnpj' && (aNaturezasCnpj.includes(($('naturezaCod').value).substr(0,2))) &&  opcaoReinf != '3'){  
    alert("A natureza do rendimento é incompatível com o tipo de credor CNPJ")
    return false;
  }

  const desdobramentoDiaria = desdobramento.substr(5, 2);
  if((desdobramentoDiaria == '14' || desdobramentoDiaria == '33') && obrigaDiaria == true){
    if($F('e140_matricula') == '' || $F('e140_matricula') == null){
      alert('Campo Matricula Obrigatório.');
      return false;
    }
    if($F('e140_cargo') == '' || $F('e140_cargo') == null){
      alert('Campo Cargo Obrigatório.');
      return false;
    }
    if($F('diariaOrigemMunicipio') == '' || $F('diariaOrigemMunicipio') == null
      || $F('diariaOrigemUf') == '' || $F('diariaOrigemUf') == null){
      alert('Campo Origem Obrigatório.');
      return false;
    }
    if($F('diariaDestinoMunicipio') == '' || $F('diariaDestinoMunicipio') == null
      || $F('diariaDestinoUf') == '' || $F('diariaDestinoUf') == null){
      alert('Campo Destino Obrigatório.');
      return false;
    }
    if($F('e140_dtautorizacao') == '' || $F('e140_dtautorizacao') == null){
      alert('Campo Data da Autorização Obrigatório.');
      return false;
    }
    if($F('e140_dtinicial') == '' || $F('e140_dtinicial') == null){
      alert('Campo Data Inicial da Viagem Obrigatório.');
      return false;
    }
    if($F('e140_horainicial') == '' || $F('e140_horainicial') == null){
        alert('Campo Hora Inicial Obrigatório.');
        return false;
    }
    if($F('e140_dtfinal') == '' || $F('e140_dtfinal') == null){
      alert('Campo Data Final da Viagem Obrigatório.');
      return false;
    }
    if($F('e140_horafinal') == '' || $F('e140_horafinal') == null){
      alert('Campo Hora Final Obrigatório.');
      return false;
    }
    if($F('e140_objetivo') == '' || $F('e140_objetivo') == null){
      alert('Campo Objetivo da Viagem Obrigatório.');
      return false;
    }
  }

  if($F('dataLiquidacao') == ''){
    alert('Campo Data da Liquidação obrigatório!');
    $('dataLiquidacao').focus();
    return false;
  }

    $('pesquisar').disabled = true;
    $('confirmar').disabled = true;
    valorTotal = 0;
    var aNotas = new Array();
    for (var i = 0;i < itens.length;i++){
      if (itens[i].checked == true){

        if (js_strToFloat($("saldovlr"+itens[i].value).innerHTML) < $F('vlrtot'+itens[i].value)) {

          sMsgErro  = 'Item '+itens[i].value+'('+$("descr"+itens[i].value).innerHTML.trim()+')';
          sMsgErro += 'com valor total maior que o saldo disponivel.\nVerifique';
          alert(sMsgErro);
          $('pesquisar').disabled = false;
          $('confirmar').disabled = false;
          return false;
        }



        if (js_strToFloat($("saldo"+itens[i].value).innerHTML) < $F('qtdesol'+itens[i].value)) {

          sMsgErro  = 'Item '+itens[i].value+'('+$("descr"+itens[i].value).innerHTML.trim()+')';
          sMsgErro += 'com valor total maior que o saldo.\nVerifique';
          alert(sMsgErro);
          $('pesquisar').disabled = false;
          $('confirmar').disabled = false;
          return false;
        }

        if ($F('qtdesol'+itens[i].value) <= 0  || $F('vlrtot'+itens[i].value) <=0 ) {

          alert("Valor do item "+itens[i].value+"("+$('descr'+itens[i].value).innerHTML.trim()+") inválido.");
          $('pesquisar').disabled = false;
          $('confirmar').disabled = false;
          return false;

        }
        var iCodigoCriterioCusto = "";
        /*
         * controlamos se deve ser solicitado o centro de custo para o item.
         * iTipoControle = 2 Uso Obrigatorio.
         *                 1 uso nao obrigatorio 
         *                  0 Nao usa  
         */  
        if (iTipoControle  == 2  ) {

          if ($('cc08_sequencial'+itens[i].value).innerHTML.trim() == "") {

            alert("Item "+itens[i].value+"("+$('descr'+itens[i].value).innerHTML.trim()+") sem centro de custo Informado");
            $('pesquisar').disabled = false;
            $('confirmar').disabled = false;
            return false;

          }
          iCodigoCriterioCusto = $('cc08_sequencial'+itens[i].value).innerHTML.trim();
        } else if (iTipoControle == 1) {
          iCodigoCriterioCusto = $('cc08_sequencial'+itens[i].value).innerHTML.trim();
        }

        /*
 
        JSON escrito manualmente. Alterado para objeto Javascript e então passado para o RPC com o Object.toJSON()

        notas += sV+'{"sequen":"'+itens[i].value+'","quantidade":"'+$F('qtdesol'+itens[i].value)+'","vlrtot":"';
        notas += $F('vlrtot'+itens[i].value)+'","vlruni":"'+$('vlruni'+itens[i].value).innerHTML+'",';
        notas += '"iCodigoCriterioCusto":'+iCodigoCriterioCusto+'}';
        */

        var oDadosNota        = new Object();
        oDadosNota.sequen     = itens[i].value;
        oDadosNota.quantidade = $F('qtdesol'+itens[i].value);
        oDadosNota.vlrtot     = $F('vlrtot'+itens[i].value);
        oDadosNota.vlruni     = $('vlruni'+itens[i].value).innerHTML;
        oDadosNota.iCodigoCriterioCusto = iCodigoCriterioCusto;
        aNotas.push(oDadosNota);

        sV         = ",";
        valorTotal += new Number($F('vlrtot'+itens[i].value));
        valorTotal = valorTotal.toFixed(2);
      }
    }

    if((desdobramentoDiaria == '14' || desdobramentoDiaria == '33') && obrigaDiaria == true){
      let totalDespesa = $F('diariaVlrDespesa') == '' ? 0 : parseFloat($F('diariaVlrDespesa'))
      if(valorTotal != totalDespesa){
        alert('Valor da Liquidação precisa ser igual ao Valor Total da Despesa');
        $('pesquisar').disabled = false;
        $('confirmar').disabled = false;
        return false;
      }
    }

    if (aNotas.length != 0){


      if (valorTotal > js_strToFloat($F('saldodis'))) {

        var sErroMsg  = "Você está tentando liquidar um valor superior ao saldo disponível.\n";
        sErroMsg += "Verifique os dados constantes em cada item da nota fiscal do credor,\n";
        sErroMsg += "pois podem haver diferenças em quantidades ou mesmo arredondamento no cálculo do valor total.";
        alert(sErroMsg);
        $('pesquisar').disabled = false;
        $('confirmar').disabled = false;
        return false;

      }
      var iTipoDocumentoFiscal = $F('e69_tipodocumentofiscal');
      var iCfop                = $F('e11_cfop');
      var iInscrSubstituto     = $F('e11_inscricaosubstitutofiscal');
      var nBaseCalculoICMS     = $F('e11_basecalculoicms');
      var nValorICMS           = $F('e11_valoricms');
      var nBaseCalculoSubst    = $F('e11_basecalculosubstitutotrib');
      var nValorICMSSubst      = $F('e11_valoricmssubstitutotrib');
      var sSerieFiscal         = $F('e11_seriefiscal');

      if (iTipoDocumentoFiscal == 0 && iControlaPit == 1) {

        alert('Informe o Tipo da Nota Fiscal');
        $('pesquisar').disabled = false;
        $('confirmar').disabled = false;
        return false;

      }

      if (iControlaPit == 1) {
        /**
         * Caso o documento fiscal for do tipo 50, devemos obrigar o usuário
         * a selecionar uma cfop
         */
        if (iTipoDocumentoFiscal == '50') {

          if (iCfop == "") {

            alert('Campo cfop Deve ser preenchido!');
            js_abreNotaExtra();
            $('pesquisar').disabled = false;
            $('confirmar').disabled = false;
            return false;

          }
        }
      } else {

        /**
         * senao é controlado o pit, tipo do documento fiscal = 4 - Outros
         */
        iTipoDocumentoFiscal = 4;
      }

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
    
    if ($F('permitido_Liquidacao') == 'false') {
        alert("Não é permitido liquidar com data anterior ao último lançamento de liquidação.");
        $('confirmar').disabled = true;
        return false;
    }

      /* Extensao [CotaMensalLiquidacao] - Parte 4 */

      js_divCarregando("Aguarde, Liquidando Empenho ","msgLiq");


      /*

      JSON escrito manualmente. Alterado para objeto Javascript e então passado para o RPC com o Object.toJSON()

      strJson  = '{"method":"geraOC","e69_nota":"'+$F('e69_numnota');
      strJson += '","e69_dtnota":"'+$F('e69_dtnota')+'","valorTotal":"'+valorTotal+'" ,"iEmpenho":"';
      strJson += $F('e60_numemp')+'","notas":['+notas+'],"historico":"'+encodeURIComponent($F('historico'))+'",';
      strJson += '"oInfoNota":{"iCfop":"'+iCfop+'","iTipoDocumentoFiscal":"'+iTipoDocumentoFiscal+'","iInscrSubstituto":"'+iInscrSubstituto+'",';
      strJson += '"nBaseCalculoICMS":"'+nBaseCalculoICMS+'","nValorICMS":"'+nValorICMS+'","nBaseCalculoSubst":"'+nBaseCalculoSubst+'",';
      strJson += '"nValorICMSSubst":"'+nValorICMSSubst+'","sSerieFiscal":"'+sSerieFiscal+'"},';
      strJson += '"pars":"'+$F('e60_numemp')+'","z01_credor":"'+$F('e49_numcgm')+'"}';//
      */

      var oParam            = new Object();
      oParam.method     = "geraOC";
      oParam.e69_nota   = $F('e69_numnota');
      oParam.e69_dtnota = $F('e69_dtnota');
      oParam.e69_notafiscaleletronica = $F('e69_notafiscaleletronica');
      oParam.e69_chaveacesso = $F('e69_chaveacesso');
      oParam.e69_nfserie = $F('e69_nfserie');
      oParam.valorTotal = valorTotal;
      oParam.iEmpenho   = $F('e60_numemp');
      oParam.iCgmEmitente = $F('z01_numcgm');
      oParam.notas      = aNotas;
     
      if(encodeURIComponent(tagString($F("informacaoop"))) != '' || encodeURIComponent(tagString($F("informacaoop"))) != null){
        if(encodeURIComponent(tagString($F("informacaoop"))) != ''){
          oParam.historico  = encodeURIComponent(tagString($F("informacaoop")));;//encodeURIComponent($F('historico')); 
          oParam.informacaoop  = encodeURIComponent(tagString($F("informacaoop")));;//encodeURIComponent($F('informacaoop'));
        }else{
          oParam.historico  = encodeURIComponent(tagString($F("historico")));;//encodeURIComponent($F('historico')); 
          oParam.informacaoop  = encodeURIComponent(tagString($F("historico")));;//encodeURIComponent($F('informacaoop'));
      }}else{
        oParam.historico  = encodeURIComponent(tagString($F("historico")));;//encodeURIComponent($F('historico')); 
        oParam.informacaoop  = encodeURIComponent(tagString($F("historico")));;//encodeURIComponent($F('informacaoop'));
      }
           
      oParam.pars       = $F('e60_numemp');
      oParam.z01_credor = $F('e49_numcgm');
      oParam.cgm = $F('e60_numcgm');
      oParam.e03_numeroprocesso = encodeURIComponent($F('e03_numeroprocesso'));
      oParam.verificaChave = 1;
      oParam.e50_compdesp = $F('e50_compdesp');
      oParam.e83_codtipo  = $F('e83_codtipo'); 
      oParam.cattrabalhador = encodeURIComponent($F('ct01_codcategoria'));
      oParam.numempresa = encodeURIComponent($F('numempresa'));
      oParam.contribuicaoPrev = $F('contribuicaoPrev');
      oParam.cattrabalhadorremuneracao = $F('ct01_codcategoriaremuneracao');
      oParam.valorremuneracao = encodeURIComponent($F('valorremuneracao'));
      oParam.valordesconto = encodeURIComponent($F('valordesconto'));
      oParam.competencia = $F('competencia');
      oParam.e50_retencaoir = $F('reinfRetencao');
      oParam.e50_naturezabemservico = $F('naturezaCod');
      oParam.dDataLiquidacao = $F('dataLiquidacao');
      oParam.dDataVencimento = $F('dataVencimento');
 
      var oInfoNota                      = new Object();
      oInfoNota.iCfop                = iCfop;
      oInfoNota.iTipoDocumentoFiscal = iTipoDocumentoFiscal;
      oInfoNota.iInscrSubstituto     = iInscrSubstituto;
      oInfoNota.nBaseCalculoICMS     = nBaseCalculoICMS;
      oInfoNota.nValorICMS           = nValorICMS;
      oInfoNota.nBaseCalculoSubst    = nBaseCalculoSubst;
      oInfoNota.nValorICMSSubst      = nValorICMSSubst;
      oInfoNota.sSerieFiscal         = sSerieFiscal;
      // oInfoNota.cattrabalhador = encodeURIComponent($F('ct01_codcategoria'));
      // oInfoNota.numempresa = encodeURIComponent($F('numempresa'));
      // oInfoNota.contribuicaoPrev = $F('contribuicaoPrev');
      // oInfoNota.valorremuneracao = encodeURIComponent($F('valorremuneracao'));
      // oInfoNota.valordesconto = encodeURIComponent($F('valordesconto'));
      // oInfoNota.competencia = $F('competencia');

      oParam.oInfoNota = oInfoNota;
      url      = 'emp4_liquidacao004.php';
      oAjax    = new Ajax.Request(
        url,
        {
          method: 'post',
          parameters: 'json='+js_objectToJson(oParam),
          onComplete: js_saidaLiquidacao
        }
      );
    }else{

      alert('Selecione ao menos 1 (uma) nota para liquidar');
      $('pesquisar').disabled = false;
      $('confirmar').disabled = false;

    }
  }
  function js_saidaLiquidacao(oAjax){

    obj      = eval("("+oAjax.responseText+")");
    if(aEstabelecimentos.length > 0){
      var oParam = new Object();
      oParam.method = "incluiRetencaoImposto"
      oParam.iCodOrdem = obj.e50_codord
      oParam.aEstabelecimentos = aEstabelecimentos;
      url      = 'emp4_pagordemreinf.RPC.php';
      oAjax    = new Ajax.Request(
        url,
        {
          method: 'post',
          parameters: 'json='+js_objectToJson(oParam)
        }
      );
    }
    js_validarEstabelecimentos(true);

    //Inclui Diaria
    const desdobramentoDiaria = desdobramento.substr(5, 2);
    if((desdobramentoDiaria == '14' || desdobramentoDiaria == '33') && obrigaDiaria == true){
      var oParam = new Object();
      oParam.exec = 'incluiDiaria';
      oParam.e140_codord                = obj.e50_codord;
      oParam.e140_dtautorizacao         = $F('e140_dtautorizacao');
      oParam.e140_matricula             = $F('e140_matricula');
      oParam.e140_cargo                 = $F('e140_cargo');
      oParam.e140_dtinicial             = $F('e140_dtinicial');
      oParam.e140_dtfinal               = $F('e140_dtfinal');
      oParam.e140_horainicial           = $F('e140_horainicial');
      oParam.e140_horafinal             = $F('e140_horafinal');
      oParam.e140_origem                = $F('diariaOrigemMunicipio') + " - " + $F('diariaOrigemUf');
      oParam.e140_destino               = $F('diariaDestinoMunicipio') + " - " + $F('diariaDestinoUf');
      oParam.e140_transporte            = $F('e140_transporte');
      oParam.e140_objetivo              = $F('e140_objetivo');
      oParam.e140_qtddiarias            = $F('e140_qtddiarias') === '' ? 0 : $F('e140_qtddiarias');
      oParam.e140_qtdhospedagens        = $F('e140_qtdhospedagens') == '' ? 0 : $F('e140_qtdhospedagens');
      oParam.e140_vrlhospedagemuni      = $F('e140_vrlhospedagemuni') == '' ? 0 : $F('e140_vrlhospedagemuni');
      oParam.e140_vrldiariauni          = $F('e140_vrldiariauni') === '' ? 0 : $F('e140_vrldiariauni');
      oParam.e140_vlrtransport          = $F('e140_vlrtransport') === '' ? 0 : $F('e140_vlrtransport');
      oParam.e140_qtddiariaspernoite    = $F('e140_qtddiariaspernoite') == '' ? 0 : $F('e140_qtddiariaspernoite');
      oParam.e140_vrldiariaspernoiteuni = $F('e140_vrldiariaspernoiteuni') == '' ? 0 : $F('e140_vrldiariaspernoiteuni');
      url      = 'emp4_empdiaria.RPC.php';
      oAjax    = new Ajax.Request(
        url,
        {
          method: 'post',
          parameters: 'json='+js_objectToJson(oParam)
        }
        );
      }

    js_removeObj("msgLiq");
    $('pesquisar').disabled = false;
    $('confirmar').disabled = false;
    mensagem = obj.mensagem.replace(/\+/g," ");
    mensagem = unescape(mensagem);
    if (obj.erro == 2){
      alert(mensagem);
    }
    if (obj.erro ==1){

      if (confirm("A Ordem de Pagamento "+obj.e50_codord+" foi gerada.\nDeseja Visualiza-la?")){
        js_emitir(obj.e50_codord);
        iCodigoOrdemPagamento = obj.e50_codord;
      }

      js_consultaEmpenho($F('e60_numemp'),<?=$operacao?>);
      $('retencoes').disabled = false;
      $('e81_codmov').value   = obj.iCodMov;
      $('e50_codord').value   = obj.e50_codord;
      $('e69_codnota').value  = obj.iCodNota;

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

  function js_calculaValor(id,tipo,fraciona,servico){
    nVlrUni   = new Number($('vlruni'+id).innerHTML);
    nQtde     = new Number($F('qtdesol'+id));
    nVlrTotal = new Number($F('vlrtot'+id));
    iSaldo    = new Number($('saldo'+id).innerHTML);
    iSaldovlr = new Number($('saldovlr'+id).innerHTML);
    if (tipo == 1){
      nTotal = (nVlrUni*nQtde);
      nTotal = new Number(nTotal);
      if(fraciona == true && servico == false) {
        $('vlrtot'+id).value    = nTotal.toFixed(2);
      }

      // if(fraciona == false && servico == false) {
      //   $('qtdesol' + id).value = 1;
      // }
      if ((nQtde <= iSaldo)){
        if (nTotal > 0){
          $('vlrtot'+id).value    = nTotal.toFixed(2);
          $('confirmar').disabled = false;
          if ($('chk'+id).checked == false ){
            $('chk'+id).click();
          } else {
            js_setValorTotal();
          }
        }
      }else{

        alert("Valor total maior que o saldo restante.");
        $('confirmar').disabled = true;

      }
    }else if(tipo == 2){
      $('pesquisar').disabled = false;
      $('confirmar').disabled = false;
      if (iSaldo != 0){
        nTotal = new Number(nVlrTotal/nVlrUni);
        if ((nVlrTotal <= iSaldovlr)) {
          if (nVlrTotal > 0){

            if(servico == true) {
              if(fraciona == true) {
                $('qtdesol' + id).value = 1;
              }else{
                $('qtdesol' + id).value = 1;
              }
            }else{
              if(fraciona == false){
                $('qtdesol' + id).value = 1;
              }else{
                $('qtdesol' + id).value    = nTotal.toFixed(2);
              }
            }

            $('confirmar').disabled = false;
            if ($('chk'+id).checked == false ){
              $('chk'+id).click();
            } else {
              js_setValorTotal();
            }
          } else {

            alert("Valor total deve ser maior que zero.");
            $('confirmar').disabled = true;
          }
        }else{

          alert("Valor total maior que o saldo restante.");
          $('confirmar').disabled = true;

        }
      }
    }
  }

  //zera os itens (valor, e quantidade )do empenho
  function js_zeraItens() {

    sMsg  = 'Esta rotina ira zerar os valores lançados.';
    sMsg += '\nTodas a alterações serão perdidas.';
    if (confirm(sMsg)) {

      itens = js_getElementbyClass(form1,'chkmarca');
      for (var iInd = 0; iInd < itens.length; iInd++) {

        if (!itens[iInd].disabled) {

          $('vlrtot' + itens[iInd].value).value = 0;
          $('qtdesol' + itens[iInd].value).value = 0;

        }
      }
      js_setValorTotal();
    }
  }

  //preenche os itens (valor, e quantidade )do empenho com o saldo Atual
  function js_preencheItens() {

    sMsg  = 'Esta rotina ira preencher os valores dos itens com seus saldos atuais.';
    sMsg += '\nTodas a alterações serão perdidas.';
    if (confirm(sMsg)) {

      itens = js_getElementbyClass(form1,'chkmarca');
      for (iInd = 0; iInd < itens.length; iInd++) {
        if (!itens[iInd].disabled) {

          $('vlrtot' + itens[iInd].value).value = $('saldovlr' + itens[iInd].value).innerHTML.trim();
          $('qtdesol' + itens[iInd].value).value = $('saldo' + itens[iInd].value).innerHTML.trim();

        }
      }
      js_setValorTotal();
    }
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
  function js_pesquisae49_numcgm(mostra){
    
    if(mostra==true){
      js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome',
        'Consulta CGM',true);
    }else{
      if(document.form1.e49_numcgm.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm',
          'func_nome.php?pesquisa_chave='+document.form1.e49_numcgm.value
          +'&funcao_js=parent.js_mostracgm','Pesquisa',false);
      }else{
        document.form1.z01_credor.value = '';
      }
    }
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

  function js_setValorTotal() {

    var aItens   = js_getElementbyClass(form1,'chkmarca',"checked==true");
    var nTotal = new Number;
    for (var iInd  = 0; iInd < aItens.length; iInd++) {

      if (!aItens[iInd].disabled) {
        nTotal += new Number($('vlrtot' + aItens[iInd].value).value);
      }
    }
    if (nTotal > js_strToFloat($F('saldodis'))) {
      $('valorTotalItens').style.color="#FF0000";
    } else {
      $('valorTotalItens').style.color="#000000";
    }
    $('valorTotalItens').innerHTML = js_formatar(nTotal,'f');
  }

  function js_lancarRetencao(){

    var lSession = "false";
    var iCodOrd  = $F('e50_codord');
    var iCodMov  = $F('e81_codmov');
    var iCodNota = $F('e69_codnota');
    var iNumEmp  = $F('e60_numemp');
    js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_retencao',
      'emp4_lancaretencoes.php?iNumNota='+iCodNota+
      '&iNumEmp='+iNumEmp+'&iCodOrd='+iCodOrd+"&lSession="+lSession
      +'&iCodMov='+iCodMov+'&callback=true',
      'Lancar Retenções', true);

  }


  function js_atualizaValorRetencao(iCodMov, nValor, iNota, iCodOrdem) {

    db_iframe_retencao.hide();
    if (nValor > 0) {
      if (confirm("As retenções lançadas alteraram o valor líquido da OP "+iCodOrdem+". Deseja reimprimir?")){
        js_emitir(iCodOrdem);
      }
    }

  }

  function js_adicionaCentroCusto(iLinha, iCodItem) {

    var iOrigem  = 1;
    var iEmpenho = $F('e60_numemp');
    var sUrl     = 'iOrigem='+iOrigem+'&iNumEmp='+iEmpenho+'&iCodItem='+iCodItem+'&iCodigoDaLinha='+iLinha;
    js_OpenJanelaIframe('',
      'db_iframe_centroCusto',
      'cus4_escolhercentroCusto.php?'+sUrl,
      'Centro de Custos',
      true,
      '25',
      '1',
      (document.body.scrollWidth-10),
      (document.body.scrollHeight-100)
    );


  }

  function js_completaCustos(iCodigo, iCriterio, iDescr) {

    $('cc08_sequencial'+iCodigo).innerHTML = iCriterio;
    $('cc08_descricao'+iCodigo).innerHTML  = iDescr;
    db_iframe_centroCusto.hide();

  }

  function js_abreNotaExtra() {

    if ($F('e69_tipodocumentofiscal') == 50) {

      if (!$('wnddadosnota')) {
        js_createJanelaDadosComplentar();
      }

      windowAuxiliarNota.show(100,300);
      $('dadosnotacomplementar').style.display='';
      $('e10_cfop').focus();
    } else {

      $('dadosnotacomplementar').style.display='none';

      if($('wnddadosnota')){
        $('dadosnotacomplementar').style.display='none';
        windowAuxiliarNota.hide();
      }

      /*
      if (windowAuxiliarNota) {
        windowAuxiliarNota.hide();
      }
      */
    }

    if($F('e69_tipodocumentofiscal') == 0){
      $('e69_numnota').readOnly         = true;
      $('e69_numnota').style.background = "#DEB887";
      $('e69_numnota').value            = "";
    }else{
      $('e69_numnota').readOnly           = false;
      $('e69_numnota').style.background   = "#FFFFFF";
    }
    js_validarNumeroNota()

  }

  function js_createJanelaDadosComplentar() {

    windowAuxiliarNota = new windowAux('wnddadosnota', 'DadosComplementares', 600, 500);
    windowAuxiliarNota.setObjectForContent($('divDadosNotaAux'));
    $('dadosnotacomplementar').style.display='';

  }
  function js_validarNumeroNota() {
    if ($F('e69_tipodocumentofiscal') == 50) {
      $('e69_numnota').value = '';
      $('e69_numnota').observe("keypress", function (event) {
        var lValidar = js_mask(event,"0-9");
        if (!lValidar) {
          event.stopPropagation();
          event.preventDefault();
          return false;
        } else {
          return true;
        }
      });
    } else {
      $('e69_numnota').stopObserving("keypress");
    }
  }


  // Função para liberar o campo e69_chaveacesso caso seja Nota Fiscal Eletrônica
  // Acrescentado por causa do sicom
  function js_tipoChave(iTipoNfe) {

    // codições para a chave de acesso
    if (iTipoNfe == 1 || iTipoNfe == 2 || iTipoNfe == 4) {
      $('e69_chaveacesso').readOnly           = false;
      $('e69_chaveacesso').style.background   = "#FFFFFF";
      iTipoNfe == 2 ? document.getElementById("e69_chaveacesso").maxLength = 60 : document.getElementById("e69_chaveacesso").maxLength = 44;
      $('e69_chaveacesso').disabled           = false;
    }else{
      $('e69_chaveacesso').readOnly          = true;
      $('e69_chaveacesso').style.background  = "#DEB887";
      $('e69_numnota').value = "S/N";
      $('e69_nfserie').value = "S/N";
      $('e69_chaveacesso').disabled           = true;
    }

    // codições para a Nf serie
    if (iTipoNfe == 2 || iTipoNfe == 3) {
      $('e69_nfserie').readOnly           = false;
      $('e69_nfserie').style.background   = "#FFFFFF";
      $('e69_nfserie').disabled            = false;
      if (iTipoNfe == 3) {
        $('e69_numnota').value = "S/N";
        $('e69_nfserie').value = "S/N";
      } else {
        $('e69_numnota').value = "";
        $('e69_nfserie').value = "S/N";//
      }
    }else{
      $('e69_nfserie').readOnly          = true;
      $('e69_nfserie').style.background  = "#DEB887";
      $('e69_nfserie').value = "";
      $('e69_numnota').value = "";
      $('e69_nfserie').disabled           = true;
    }

    $('e69_chaveacesso').value         = "";

  }

  function novoAjax(params, onComplete) {

    var request = new Ajax.Request('emp4_chaveacessonfe004.RPC.php', {
      method:'post',
      parameters:'json='+Object.toJSON(params),
      onComplete: onComplete
    });

  }

  function verificaChave(matriz) {

    if ($('e69_notafiscaleletronica').value != 2 && $('e69_notafiscaleletronica').value != 3) {
        if (matriz == true) {
            var cgm_emitente =  $('e60_numcgm').value;
        } else {
            var cgm_emitente =  $('z01_numcgm').value;
        }
      var params = {
        exec: 'validachave',
        cgm: cgm_emitente,
        chave: $('e69_chaveacesso').value,
        data: $('e69_dtnota').value,
        tipo: $('e69_notafiscaleletronica').value,
        nfe: $('e69_numnota').value
      };

      novoAjax(params, function(e) {//31181004930131000129550010000123431322590654 12343
        var oRetorno = JSON.parse(e.responseText);
        if (oRetorno.status == 0) {
          alert(oRetorno.erro);
          $('e69_chaveacesso').value = '';
        }
      });
    }
  }


  //  Função para verificar a chave de acesso Nota Fiscal Eletrônica
  // Acrescentado por causa do sicom
  function js_verificaChaveAcesso(iChaveAcesso) {

    if ($('e69_notafiscaleletronica').value == 3) {
      return true;
    };
    if ($('e69_notafiscaleletronica').value == 2) {
      return true;
    };
    var aChave = iChaveAcesso.split("");
    var multiplicadores = [2, 3, 4, 5, 6, 7, 8, 9];
    var soma_ponderada = 0;
    var i = 42;
    while (i >= 0) {
      for (m = 0; m < multiplicadores.length && i >= 0; m++) {
        soma_ponderada += aChave[i] * multiplicadores[m];
        i--;
      }
    }

    var resto = soma_ponderada % 11;//
    if ( (aChave[43] == (11 - resto)) || ((resto == 0 || resto == 1) && (aChave[43] == 0)) ) {
        var matriz = true;
        var nf_matriz_filial = document.getElementById('nf_matriz_filial');
        if (nf_matriz_filial.options[nf_matriz_filial.selectedIndex].value == 's') {
            matriz = false;
        }
        return verificaChave(matriz);
    } else {
      alert("Chave de Acesso inválida");
      $('e69_chaveacesso').value = '';
      return false;
    }

  }

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
            
            $('e83_codtipo').value  = ''; 
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

    // Oc17910
    var nf_matriz_filial = document.getElementById('nf_matriz_filial');
    mostrar_cgm_emitente("n");

    nf_matriz_filial.addEventListener('change', function() {
        var selected_option_value = nf_matriz_filial.options[nf_matriz_filial.selectedIndex].value;
        mostrar_cgm_emitente(selected_option_value);
    });

    function mostrar_cgm_emitente(condicao) {
        var cgm_emitente = document.getElementsByClassName('cgm_emitente');
        var credor = document.getElementsByClassName('credor');

        if (condicao == "s") {
            cgm_emitente[0].hidden = false;
            cgm_emitente[1].hidden = false;
            cgm_emitente[2].hidden = false;
            return;
        }
        cgm_emitente[0].hidden = true;
        cgm_emitente[1].hidden = true;
        cgm_emitente[2].hidden = true;
        return;
    }

    function js_pesquisaz01_numcgm(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('',
                'func_nome',
                'func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome',
                'Pesquisar CGM',
                true,
                22,
                0,
                document.body.getWidth() - 12,
                document.body.scrollHeight - 30);
        }else{
            if(document.form1.z01_numcgm.value != ''){

                js_OpenJanelaIframe('',
                    'func_nome',
                    'func_nome.php?pesquisa_chave='+document.form1.z01_numcgm.value+
                    '&funcao_js=parent.js_mostracgm',
                    'Pesquisar CGM',
                    false,
                    22,
                    0,
                    document.width-12,
                    document.body.scrollHeight-30);
            }else{
                document.form1.descricao_emitente.value = '';
            }
        }
    }
    function js_mostracgm(erro,chave){
        document.form1.descricao_emitente.value = chave;
        if(erro==true){
            document.form1.z01_numcgm.focus();
            document.form1.z01_numcgm.value = '';
        }
    }

    function js_mostracgm1(chave1,chave2){
        document.form1.z01_numcgm.value = chave1;
        document.form1.descricao_emitente.value = chave2;
        func_nome.hide();
    }
    $('contribuicaoPrev').style.width =' 495px';
    $('aIncide').style.width =' 120px';
    $('multiplosvinculos').style.width =' 120px';

    $('e60_codemp').disabled = true;
    $('e60_coddot').disabled = true;
    $('estruturalDotacao').disabled = true;
    $('e60_numcgm').disabled = true;
    $('z01_nome').disabled = true;
    $('descricao_emitente').disabled = true;
    $('e83_descr').disabled = true;
    $('e60_vlremp').disabled = true;
    $('e60_vlranu').disabled = true;
    $('e60_vlrliq').disabled = true;
    $('e60_vlrpag').disabled = true;
    $('saldodis').disabled = true;
    $('ct01_descricaocategoria').disabled = true;
    $('nomeempresa').disabled = true;
    $('ct01_descricaocategoriaremuneracao').disabled = true;
    $('e69_nfserie').disabled           = true;

    document.addEventListener("DOMContentLoaded", function() {
    var elementosNoSelect = document.querySelectorAll('input:disabled');
    elementosNoSelect.forEach(function (elemento) {
        elemento.style.color = 'black'
    });
  });

</script>
