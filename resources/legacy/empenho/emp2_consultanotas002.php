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

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_empnota_classe.php");
require_once("classes/db_empnotaitem_classe.php");
require_once("classes/db_empdiaria_classe.php");
require_once("classes/db_pagordemreinf_classe.php");

$oGet            = db_utils::postMemory($_GET);
$oDaoEmpNota     = new cl_empnota();
$oDaoEmpNotaItem = new cl_empnotaitem();
$clEmpdiaria     = new cl_empdiaria();
$clPagordemreinf = new cl_pagordemreinf();

$clrotulo        = new rotulocampo;
$clrotulo->label("e69_numero");
$clrotulo->label("e69_codnota");
$clrotulo->label("e50_codord");
$clrotulo->label("e60_codemp");
$clrotulo->label("z01_nome");
$clrotulo->label("e70_valor");
$clrotulo->label("e70_vlrliq");
$clrotulo->label("e70_vlranu");
$clrotulo->label("e53_vlrpag");
if (isset($oGet->e69_codnota)) {

  $sSqlNota  = "select e69_codnota,";
  $sSqlNota .= "       cgm.z01_nome,";
  $sSqlNota .= "       cgm.z01_cgccpf,";
  $sSqlNota .= "       e69_dtnota,";
  $sSqlNota .= "       e69_numero,";
  $sSqlNota .= "       e69_chaveacesso,";
  $sSqlNota .= "       e69_nfserie,";
  $sSqlNota .= "       e69_notafiscaleletronica,";
  $sSqlNota .= "       e60_codemp||'/'||e60_anousu as codemp,";
  $sSqlNota .= "       e70_valor,";
  $sSqlNota .= "       e70_vlrliq,";
  $sSqlNota .= "       e70_vlranu,";
  $sSqlNota .= "       e50_codord,";
  $sSqlNota .= "       e50_data,";
  $sSqlNota .= "       e50_dtvencimento,";
  $sSqlNota .= "       e53_vlrpag,";
  $sSqlNota .= "       e50_cattrabalhador,"; 
  $sSqlNota .= "       cattrabalhador.ct01_descricaocategoria,";
  $sSqlNota .= "       e50_empresadesconto,"; 
  $sSqlNota .= "       empresa.z01_nome as nomeempresa,";
  $sSqlNota .= "       e50_valorremuneracao,"; 
  $sSqlNota .= "       e50_valordesconto,"; 
  $sSqlNota .= "       e50_datacompetencia,";
  $sSqlNota .= "       e50_contribuicaoprev,";
  $sSqlNota .= "       catremuneracao.ct01_descricaocategoria as descricaoremuneracao,";
  $sSqlNota .= "       e50_cattrabalhadorremurenacao,";
  $sSqlNota .= "       e50_retencaoir,";
  $sSqlNota .= "       e50_naturezabemservico,";
  $sSqlNota .= "       e101_resumo,";
  $sSqlNota .= "       e03_numeroprocesso,";
  $sSqlNota .= "       e69_cgmemitente,";
  $sSqlNota .= "       m72_codordem";
  $sSqlNota .= "       from empnota ";
  $sSqlNota .= "          inner join empempenho   on e69_numemp  = e60_numemp";
  $sSqlNota .= "          inner join cgm as cgm   on e60_numcgm  = cgm.z01_numcgm";
  $sSqlNota .= "          inner join empnotaele   on e69_codnota = e70_codnota";
  $sSqlNota .= "          left  join pagordemnota on e71_codnota = e69_codnota";
  $sSqlNota .= "                                 and e71_anulado is false";
  $sSqlNota .= "          left  join pagordem    on  e71_codord = e50_codord";
  $sSqlNota .= "          left  join pagordemele  on e53_codord = e50_codord";
  $sSqlNota .= "          left  join cgm as empresa on empresa.z01_numcgm = e50_empresadesconto";
  $sSqlNota .= "          left join categoriatrabalhador as cattrabalhador on cattrabalhador.ct01_codcategoria = e50_cattrabalhador";
  $sSqlNota .= "          left join categoriatrabalhador as catremuneracao on	catremuneracao.ct01_codcategoria = e50_cattrabalhadorremurenacao";
  $sSqlNota .= "          left join naturezabemservico on	e50_naturezabemservico = e101_codnaturezarendimento";
  $sSqlNota .= "          left join pagordemprocesso on	e71_codord = e03_pagordem";
  $sSqlNota .= "          left join empnotaord on	e69_codnota = m72_codnota";
  $sSqlNota .= "  where e69_codnota = {$oGet->e69_codnota}";
  $rsNota    = $oDaoEmpNota->sql_record($sSqlNota);

  if ($oDaoEmpNota->numrows > 0 ) {

    $oNotas      = db_utils::FieldsMemory($rsNota, 0);
    $e69_codnota = $oNotas->e69_codnota;
    $e69_numero  = $oNotas->e69_numero;
    $codemp      = $oNotas->codemp;
    $z01_nome    = $oNotas->z01_nome;
    $e70_valor   = $oNotas->e70_valor;
    $e70_vlrliq  = $oNotas->e70_vlrliq;
    $e70_vlranu  = $oNotas->e70_vlranu;
    $e53_vlrpag  = $oNotas->e53_vlrpag;
    $e50_codord  = $oNotas->e50_codord;
    $e69_dtnota  = date('d/m/Y', strtotime($oNotas->e69_dtnota));
    $e69_nfserie = $oNotas->e69_nfserie;
    $e50_data    = date('d/m/Y', strtotime($oNotas->e50_data));
    $e50_dtvencimento  = $oNotas->e50_dtvencimento == '' ? '' : date('d/m/Y', strtotime($oNotas->e50_dtvencimento));
    $e69_chaveacesso  = $oNotas->e69_chaveacesso == 'null' ? '' : $oNotas->e69_chaveacesso;
    $e50_cattrabalhador = $oNotas->e50_cattrabalhador;
    $ct01_descricaocategoria = $oNotas->ct01_descricaocategoria;
    $e50_empresadesconto = $oNotas->e50_empresadesconto; 
    $e50_cattrabalhadorremurenacao = $oNotas->e50_cattrabalhadorremurenacao;
    $e50_descricaoremurenacao = $oNotas->descricaoremuneracao;
    $e50_valorremuneracao = $oNotas->e50_valorremuneracao;
    $e50_valordesconto = $oNotas->e50_valordesconto;
    $e50_datacompetencia = $oNotas->e50_datacompetencia;
    $nomeempresa = $oNotas->nomeempresa;
    $e50_contribuicaoprev = $oNotas->e50_contribuicaoprev;
    $cpfcnpj =  $oNotas->z01_cgccpf;
    $e50_retencaoir = $oNotas->e50_retencaoir == 't' ? 1 : 0;
    $e101_resumo = $oNotas->e101_resumo;
    $e03_numeroprocesso = $oNotas->e03_numeroprocesso;
    $nfMatrizFilial = $oNotas->e69_cgmemitente > 0 ? 'Sim' : 'Não';
    $m72_codordem = $oNotas->m72_codordem;

    $aNf = array(1 => 'Sim, padrão Estadual ou SINIEF 07/05',2 => 'Sim, chave de acesso municipal ou outra',3 => 'Não',4 => 'Sim, padrão Estadual ou SINIEF 07/05 - Avulsa');
    $e69_notafiscaleletronica  = $aNf[$oNotas->e69_notafiscaleletronica];

    $rsDiaria = $clEmpdiaria->sql_record($clEmpdiaria->sql_query(null,"*",null,"e140_codord = ".$e50_codord));
    if($clEmpdiaria->numrows > 0){
      
      $bDiaria = 1;
      $oDiaria = db_utils::FieldsMemory($rsDiaria, 0);
      $diariaViajante             = $oNotas->z01_nome;
      $e140_matricula             = $oDiaria->e140_matricula;
      $e140_cargo                 = $oDiaria->e140_cargo;
      $e140_dtautorizacao         = date('d/m/Y', strtotime($oDiaria->e140_dtautorizacao));
      $e140_dtinicial             = date('d/m/Y', strtotime($oDiaria->e140_dtinicial));
      $e140_dtfinal               = date('d/m/Y', strtotime($oDiaria->e140_dtfinal));
      $e140_origem                = $oDiaria->e140_origem;
      $e140_destino               = $oDiaria->e140_destino;
      $e140_horainicial           = $oDiaria->e140_horainicial;
      $e140_horafinal             = $oDiaria->e140_horafinal;
      $e140_qtddiarias            = $oDiaria->e140_qtddiarias;
      $e140_vrldiariauni          = $oDiaria->e140_vrldiariauni;
      $diariaVlrTotal             = $e140_qtddiarias * $e140_vrldiariauni;
      $e140_qtddiariaspernoite    = $oDiaria->e140_qtddiariaspernoite;
      $e140_vrldiariaspernoiteuni = $oDiaria->e140_vrldiariaspernoiteuni;
      $diariaPernoiteVlrTotal     = $e140_qtddiariaspernoite * $e140_vrldiariaspernoiteuni;
      $e140_qtdhospedagens        = $oDiaria->e140_qtdhospedagens;
      $e140_vrlhospedagemuni      = $oDiaria->e140_vrlhospedagemuni;
      $hospedagemVlrTotal         = $e140_qtdhospedagens * $e140_vrlhospedagemuni;
      $e140_transporte            = $oDiaria->e140_transporte;
      $e140_vlrtransport          = $oDiaria->e140_vlrtransport;
      $diariaVlrDespesa           = $diariaVlrTotal + $e140_vlrtransport + $hospedagemVlrTotal + $diariaPernoiteVlrTotal;
      $e140_objetivo              = $oDiaria->e140_objetivo;

    }else{
      $bDiaria = 0;
    }

    if($e50_retencaoir){
      $e50_naturezabemservico = $oNotas->e50_naturezabemservico;
      $aEstabelecimento = pg_fetch_all($clPagordemreinf->sql_record($clPagordemreinf->sql_query_nome($e50_codord,null,"pagordemreinf.*, z01_nome")));
      $aEstabelecimento = json_encode($aEstabelecimento);
    }else{
      $aEstabelecimento = null;
    }
  }
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
  <style>
  .cabecTableEstabelecimento {
    font-size: 10;
    color: darkblue;
    background-color: #aacccc;
    border: none;
    width: 90px;
    text-align: center;
  }

  .cabecTableEstabelecimentoNome {
    font-size: 10;
    color: darkblue;
    background-color: #aacccc;
    border: none;
    width: 500px;
    text-align: center;
  }

  .corpoTableEstabelecimento {
    font-size: 10;
    color: black;
    background-color: #ccddcc;
    width: 90px;
    text-align: center;
  }

  .corpoTableEstabelecimentoNome {
    font-size: 10;
    color: black;
    background-color: #ccddcc;
    width: 500px;
    text-align: center;
  }
</style>
</head>
<body bgcolor="#CCCCCC" >
   <fieldset>
     <legend><b>Dados da nota</b></legend>
       <table>
          <tr>
            <td>
              <b><?=$Lz01_nome?></b>
            </td>
            <td>
              <?
              db_input('z01_nome', 50, $Lz01_nome, true, 'text', 3);
              ?>
            </td>
            <td>
              <b><?php echo @$Le60_codemp;?></b>
            </td>
            <td>
              <?db_input('codemp', 13, $Ie60_codemp, true, 'text', 3);?>
            </td>
            <td>
              <b>Código da Nota:</b>
            </td>
            <td>
              <?db_input('e69_codnota', 13, $Ie69_codnota, true, 'text', 3);?>
              <b>Nota de Liquidação:</b>
              <?db_input('e50_codord', 13, $Ie50_codord, true, 'text', 3);?>
            </td>
          </tr>
          <tr>
            <td>
             <b>Número:</b>
            </td>
            <td>
              <?db_input('e69_numero', 13, $Ie69_numero, true, 'text', 3);?>
              <b>Numero de Série:</b>
              <? db_input('e69_nfserie', 13, $Ie53_vlrpag, true, 'text', 3);?>
            </td>
            <td>
              <b>Data da Nota:</b>
            </td>
            <td>
              <? db_input('e69_dtnota', 13, $Ie53_vlrpag, true, 'text', 3);?>
            </td>           
            <td>
              <b>Data de Vencimento:</b>
            </td>
            <td>
              <? db_input('e50_dtvencimento', 13, $Ie53_vlrpag, true, 'text', 3);?>
              <b>Data da Liquidação:</b>
              <? db_input('e50_data', 13, $Ie53_vlrpag, true, 'text', 3);?>
            </td>
          </tr>
          <tr>
            <td>
              <b>Chave de Acesso:</b>
            </td>
            <td>
              <? db_input('e69_chaveacesso', 50, $Ie53_vlrpag, true, 'text', 3);?>
            </td>
            <td>
              <b>NF Matriz/Filial:</b>
            </td>
            <td>
              <? db_input('nfMatrizFilial', 13, $Ie53_vlrpag, true, 'text', 3);?>
            </td>
            <td>
              <b>Nota Fiscal Eletronica:</b>
            </td>
            <td>
            <?db_input('e69_notafiscaleletronica', 34, 0,true,'text',3);?>
            </td>
         </tr>
         <tr>
            <td>
              <b>Valor:</b>
            </td>
            <td>
              <?db_input('e70_valor', 13, $Ie70_valor, true, 'text', 3);?>          
              <b>Valor Liquidado:</b>           
              <?db_input('e70_vlrliq', 13, $Ie70_vlrliq, true, 'text', 3);?>
            </td>
            <td>
              <b>Valor Anulado: </b>
            </td>
            <td>
              <?db_input('e70_vlranu', 13, $Ie70_vlranu, true, 'text', 3);?>
            </td>
            <td>
              <b>Valor Pago:</b>
            </td>
            <td>
              <?db_input('e53_vlrpag', 13, $Ie53_vlrpag, true, 'text', 3);?>
            </td>
          </tr>
          <tr>
          <td>
            <b>Processo Administrativo:</b>
          </td>
          <td>
            <? db_input('e03_numeroprocesso', 50, $Ie53_vlrpag, true, 'text', 3);?>
          </td>
          <td>
            <b>Ordem de Compra:</b>
          </td>
          <td>
            <? db_input('m72_codordem', 13, $Ie53_vlrpag, true, 'text', 3);?>
          </td>
         </tr>
       </table>
   </fieldset>
   <fieldset id='esocial'>
     <legend >
       <b>eSocial</b>
     </legend>
     <table>
     <table>
         <tr>
           <td>
             <b>Categoria do Trabalhador:</b>
           </td>
           <td>
              <?
              db_input('e50_cattrabalhador', 10, $Ie50_cattrabalhador, true, 'text', 3);
              ?>
           </td>
           <td>
              <?
              db_input('ct01_descricaocategoria', 40, $Ict01_descricaocategoria, true, 'text', 3);
              ?>
           </td>
           <td>
             <b>Valor da Remuneração:</b>
           </td>
           <td>
              <?
              db_input('e50_valorremuneracao', 10, $Ie50_valorremuneracao, true, 'text', 3);
              ?>
           </td>
            <td>
             <b>Valor o Desconto:</b>
           </td>
           <td>
              <?
              db_input('e50_valordesconto', 10, $Ie50_valordesconto, true, 'text', 3);
              ?>
           </td>
         </tr>
         <tr>
         <td>
             <b>Empresa que efetuou desconto:</b>
           </td>
           <td>
              <?
              db_input('e50_empresadesconto', 10, $Ie50_empresadesconto, true, 'text', 3);
              ?>
           </td>
           <td>
              <?
              db_input('nomeempresa', 40, $Inomeempresa, true, 'text', 3);
              ?>
           </td>
            <td>
             <b>Competência:</b> 
           </td>
           <td>
              <?
              if($e50_datacompetencia){
                $data = explode("-",$e50_datacompetencia);
                $e50_datacompetencia = $data[2]."-".$data[1]."-".$data[0];
              }
              db_input('e50_datacompetencia', 10, $Ie50_datacompetencia, true, 'text', 3);
              ?>
           </td>
           </tr>
           <tr>
            <td>
             <b>Categoria do trabalhador na qual houve a remuneração:</b>
           </td>
           <td>
              <?
              db_input('e50_cattrabalhadorremurenacao', 10, $Ie50_cattrabalhadorremurenacao, true, 'text', 3);
              ?>
           </td>
           <td>
              <?
              db_input('e50_descricaoremurenacao', 40, $Ie50_descricaoremurenacao, true, 'text', 3);
              ?>
           </td>
            </tr>
           <tr>
           <td colspan="2">
             <b>Indicador de Desconto da Contribuição Previdenciária:</b> 
           </td>
           <td>
              <?
              db_input('e50_contribuicaoprev', 10, $Ie50_contribuicaoprev, true, 'text', 3);
              ?>
           </td>
           
         </tr>
         </tr>
     </table>
     </form>
     <form name='form2' method='post'>
   </fieldset>
   <fieldset id="diariaFieldset">
    <legend><b>&nbsp;Diárias&nbsp;</b></legend>
    <table>
      <tr>
        <td>
          <b>Viajante:</b>
        </td>
        <td>
          <? db_input("diariaViajante", 45, 1, true, 'text', 3) ?>
          <b>&nbsp;Matrícula:</b>
          <? db_input("e140_matricula", 7, 1, true, 'text', 3) ?>
          <b>Cargo:</b>
          <? db_input("e140_cargo", 26, 3, true, 'text', 3) ?>
        </td>
      </tr>
      <tr>
        <td>
          <b>Origem: </b>
        </td>
        <td>
          <?db_input('e140_origem', 45, 2, true, 'text', 3);?>
          <b>Destino: </b>
          <?db_input('e140_destino', 43, 2, true, 'text', 3);?>
        </td>
      <tr>
        <td>
          <b>Data da Autorização:</b>
        </td>
        <td>
          <? db_input("e140_dtautorizacao", 10, 2, true, 'text', 3) ?>
          <b>Data Inicial da Viagem:</b>
          <? db_input("e140_dtinicial", 10, 2, true, 'text', 3) ?>
          <b>Hora:</b>
          <?db_input('e140_horainicial',5,3,1,'text',3)?>
          <b>Data Final da Viagem:</b>
          <? db_input("e140_dtfinal", 10, 2, true, 'text', 3) ?>
          <b>Hora:</b>
          <?db_input('e140_horafinal',5,3,1,'text',3)?>
        </td>
      </tr>
      <tr>
        <td>
          <b>Quantidade de Diárias:</b>
        </td>
        <td>
          <? db_input("e140_qtddiarias", 8, 4, true, 'text', 3) ?>
          <b style='margin-left: 15px'>Valor Unitário da Diária:</b>
          <? db_input("e140_vrldiariauni", 8, 4, true, 'text', 3) ?>
          <b style='margin-left: 45px'>Valor Total das Diárias:</b>
          <? db_input("diariaVlrTotal", 8, 4, true, 'text', 3) ?>
        </td>
      </tr>
      <tr>
        <td>
          <b>Quantidade de Diárias Pernoite:</b>
        </td>
        <td>
          <? db_input("e140_qtddiariaspernoite", 8, 4, true, 'text', 3) ?>
          <b style='margin-left: 15px'>Valor Unitário da Diária Pernoite:</b>
          <? db_input("e140_vrldiariaspernoiteuni", 8, 4, true, 'text', 3) ?>
          <b style='margin-left: 45px'>Valor Total das Diárias Pernoite:</b>
          <? db_input("diariaPernoiteVlrTotal", 8, 4, true, 'text', 3) ?>
        </td>
      </tr>
      <tr>
        <td>
          <b>Quantidade de Hospedagens:</b>
        </td>
        <td>
          <? db_input("e140_qtdhospedagens", 8, 4, true, 'text', 3) ?>
          <b style='margin-left: 15px'>Valor Unitário da Hospedagem:</b>
          <? db_input("e140_vrlhospedagemuni", 8, 4, true, 'text', 3) ?>
          <b style='margin-left: 45px'>Valor Total das Hospedagens:</b>
          <? db_input("hospedagemVlrTotal", 8, 4, true, 'text', 3) ?>
        </td>
      </tr>
      <tr>
        <td>
          <b>Transporte:</b>
        </td>
        <td>
          <? db_input("e140_transporte", 19, 2, true, 'text', 3) ?>
          <b>Valor do Transporte:</b>
          <? db_input("e140_vlrtransport", 8, 4, true, 'text', 3) ?>
          <b style='margin-left: 44.5px'>Valor Total da Despesa:</b>
          <? db_input("diariaVlrDespesa", 8, 4, true, 'text', 3) ?>
        </td>
      </tr>
    </table>
    <b>&nbsp;Objetivo da Viagem:</b></br>
    <? db_textarea("e140_objetivo", 2, 130, 0, true, 'text', 3) ?>
  </fieldset>
  <fieldset id='reinf'>
  <legend><b>Efd-Reinf</b></legend>
  <table>
    <tr>
      <td><b>Incide Retenção do Imposto de Renda:</b></td>
      <td>
        <?
        $aReinfRetencao = array('0' => 'Não', '1' => 'Sim');
        db_select('e50_retencaoir', $aReinfRetencao, true, 3);
        ?>
      </td>
    </tr>
    <tr id='linhaNaturezaRendimento'>
      <td><b>Natureza do Rendimento: </b></td>
      <td><? db_input('e50_naturezabemservico', 7, 1, true, 'text', 3); ?></td>
      <td><? db_input('e101_resumo', 100, 0, true, 'text', 3); ?></td>
    </tr>
    <tr id='linhaRetencaoTerceiro'>
      <td><b>Retenção Realizada por Terceiro:</b></td>
      <td><? db_input('reinfRetencaoEstabelecimento', 7, 1, true, 'text', 3); ?></td>
    </tr>
  </table>
  <fieldset id='fieldsetEstabelecimentos'>
    <legend><b>Estabelecimentos</b></legend>
    <table id="estabelecimentosTable" border="1">
      <thead>
        <tr>
          <th class="cabecTableEstabelecimento">CGM Estabelecimento</th>
          <th class="cabecTableEstabelecimentoNome">Nome/Razão Social</th>
          <th class="cabecTableEstabelecimento">Valor Bruto</th>
          <th class="cabecTableEstabelecimento">Valor Base</th>
          <th class="cabecTableEstabelecimento">Valor IR</th>
        </tr>
      </thead>
      <tbody id="estabelecimentosTableBody">
      </tbody>
    </table>
  </fieldset>
</fieldset>
   <fieldset>
     <legend>
       <b>Itens da Nota</b>
     </legend>
     <table>
     <form1 method='post' name='itens'>
       <?
       if ($oDaoEmpNota->numrows > 0) {

         $sWhere       = "e72_codnota = {$oNotas->e69_codnota}";
         $sCampos      = "e62_sequen, pc01_descrmater, e72_valor, e72_qtd,e72_vlrliq,e72_vlranu";
         $sSqltensNota = $oDaoEmpNotaItem->sql_query(null,$sCampos,"e62_sequen",$sWhere);
         db_lovrot_arredondamento($sSqltensNota, 15,'','',"","","Itens");
       }
       ?>
     </table>
     </form>
     <form name='form2' method='post'>
   </fieldset>
   <?

     if ($oNotas->e50_codord != null) {

      $oDaoRetencao  = db_utils::getDao("retencaoreceitas");
      $sSqlRetencoes = $oDaoRetencao->sql_query_consulta(null,
                                                      "e21_sequencial,
                                                       e21_descricao,
                                                       e23_dtcalculo,
                                                       e23_valor,
                                                       e23_valorbase,
                                                       e23_deducao,
                                                       e23_valorretencao,
                                                       e23_aliquota,
                                                       case when e23_recolhido is true then 'Sim'
                                                       else 'Não' end as
                                                       e23_recolhido,
                                                       k105_data,
                                                       numpre.k12_numpre,
                                                       q32_planilha",
                                                       "e23_sequencial",
                                                       "e20_pagordem  = {$oNotas->e50_codord}
                                                        and e27_principal is true
                                                        and e23_ativo is true"
                                                      );

      $rsRetencoes = $oDaoRetencao->sql_record($sSqlRetencoes);
      $iNumRows    = $oDaoRetencao->numrows;
      if ($iNumRows > 0) {

        $aRetencoes = db_utils::getCollectionByRecord($rsRetencoes, true);

        echo "<fieldset>";
        echo "  <legend><b>Retenções</b></legend>";
        echo "<table style='border: 2px inset white;' cellspacing='0'>";
        echo "  <tr>";
        echo "    <th class='table_header'>Código</th>";
        echo "    <th class='table_header'>Retenção</th>";
        echo "    <th class='table_header'>Data do Cálculo</th>";
        echo "    <th class='table_header'>Base de Calculo</th>";
        echo "    <th class='table_header'>Dedução</th>";
        echo "    <th class='table_header'>Valor</th>";
        echo "    <th class='table_header'>Aliquota</th>";
        echo "    <th class='table_header'>Recolhido</th>";
        echo "    <th class='table_header'>Data Autent.</th>";
        echo "    <th class='table_header'>Cod. Arrec</th>";
        echo "    <th class='table_header'>Planilha</th>";
        echo "    <th class='table_header' width='17px'>&nbsp;</th>";
        echo "  </tr>";
        echo "<tbody style='height:150px;width:100%;overflow:scroll;overflow-x:hidden;background-color:white'>";
        foreach ($aRetencoes as $oRetencao) {

          echo "<tr style='height:1em'>";
          echo "  <td class='linhagrid' style='text-align:right'>{$oRetencao->e21_sequencial}</td>\n";
          echo "  <td class='linhagrid' style='text-align:left'>{$oRetencao->e21_descricao}</td>\n";
          echo "  <td class='linhagrid' style='text-align:center'>{$oRetencao->e23_dtcalculo}</td>\n";
          echo "  <td class='linhagrid' style='text-align:right'>".db_formatar($oRetencao->e23_valorbase,"f")."</td>\n";
          echo "  <td class='linhagrid' style='text-align:right'>".db_formatar($oRetencao->e23_deducao,"f")."</td>\n";
          echo "  <td class='linhagrid' style='text-align:right'>".db_formatar($oRetencao->e23_valorretencao,"f")."</td>\n";
          echo "  <td class='linhagrid' style='text-align:right'>{$oRetencao->e23_aliquota}%</td>\n";
          echo "  <td class='linhagrid' style='text-align:left'>{$oRetencao->e23_recolhido}</td>\n";
          echo "  <td class='linhagrid' style='text-align:center'>{$oRetencao->k105_data}&nbsp;</td>\n";
          echo "  <td class='linhagrid' style='text-align:center'>{$oRetencao->k12_numpre}&nbsp;</td>\n";
          echo "  <td class='linhagrid' style='text-align:center'>{$oRetencao->q32_planilha}&nbsp;</td>\n";
          echo "  <td >&nbsp;</td>\n";
          echo "</tr>";

        }
        echo "<tr style='height:auto'><td>&nbsp;</td></tr>";
        echo "</tbody>";
        echo "</table>";
        echo "</fieldset>";

      }
     }
   ?>
   </form>
</body>
</html>
<script>
    document.getElementById('e140_vrldiariauni').style.marginLeft = '51px';
    document.getElementById('e140_vrlhospedagemuni').style.marginLeft = '9px';
    document.getElementById('e140_vlrtransport').style.marginLeft = '9px';
    document.getElementById('diariaVlrTotal').style.marginLeft = '52px';
    document.getElementById('hospedagemVlrTotal').style.marginLeft = '13px';
    document.getElementById('diariaVlrDespesa').style.marginLeft = '49px';

    var db_opcao = "<?php print $cpfcnpj; ?>";
    var bDiaria = <?echo $bDiaria;?>;
    var bRetencaoir = <?echo $e50_retencaoir;?>;

    if(db_opcao.length == '11'){
      document.getElementById('esocial').style.display = "table-cell";   
    }else{
      document.getElementById('esocial').style.display = "none";
    }

    if(bDiaria){
      document.getElementById('diariaFieldset').style.display = "table-cell";
    }else{
      document.getElementById('diariaFieldset').style.display = "none";
    }

    if(bRetencaoir){
      document.getElementById('linhaNaturezaRendimento').style.display = "table-row";
      document.getElementById('linhaRetencaoTerceiro').style.display = "table-row";
    }else{
      document.getElementById('linhaNaturezaRendimento').style.display = "none";
      document.getElementById('linhaRetencaoTerceiro').style.display = "none";
    }
  
    var aEstabelecimentos = <?echo $aEstabelecimento == null ? 0 : $aEstabelecimento?>;
    if (aEstabelecimentos) {
      document.getElementById('reinfRetencaoEstabelecimento').value = 'Sim';
      document.getElementById('fieldsetEstabelecimentos').style.display = 'table-cell';
      for (i = 0; i < aEstabelecimentos.length; i++) {
          js_adicionarEstabelecimentoTabela(aEstabelecimentos[i]);
      }
    } else {
      document.getElementById('reinfRetencaoEstabelecimento').value = 'Não';
      document.getElementById('fieldsetEstabelecimentos').style.display = 'none';
      document.getElementById('estabelecimentosTableBody').innerHTML = '';
    }

  function js_adicionarEstabelecimentoTabela(item) {
    const table = document.getElementById("estabelecimentosTableBody");
    const novoEstabelecimento = table.insertRow();

    const numCgm = novoEstabelecimento.insertCell(0);
    numCgm.innerHTML = item.e102_numcgm;
    numCgm.className = "corpoTableEstabelecimento";

    const nomeEstabelecimento = novoEstabelecimento.insertCell(1);
    nomeEstabelecimento.innerHTML = item.z01_nome;
    nomeEstabelecimento.className = "corpoTableEstabelecimentoNome";

    const vlrBruto = novoEstabelecimento.insertCell(2);
    vlrBruto.innerHTML = item.e102_vlrbruto;
    vlrBruto.className = "corpoTableEstabelecimento";

    const vlrBase = novoEstabelecimento.insertCell(3);
    vlrBase.innerHTML = item.e102_vlrbase;
    vlrBase.className = "corpoTableEstabelecimento";

    const vlrIr = novoEstabelecimento.insertCell(4);
    vlrIr.innerHTML = item.e102_vlrir;
    vlrIr.className = "corpoTableEstabelecimento";
    
  }
</script>  