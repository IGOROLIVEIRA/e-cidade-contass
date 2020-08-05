<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_pcorcam_classe.php");
include("classes/db_pcorcamitem_classe.php");
include("classes/db_pcorcamforne_classe.php");
include("classes/db_pcorcamval_classe.php");
include("classes/db_pcorcamjulg_classe.php");
include("classes/db_pcorcamdescla_classe.php");
include("classes/db_liclicitemlote_classe.php");
include("classes/db_liclicita_classe.php");
require("classes/db_registroprecovalores_classe.php");
include("classes/db_habilitacaoforn_classe.php");
include("classes/db_cflicita_classe.php");
require("classes/db_credenciamento_classe.php");
require("classes/db_liclicitem_classe.php");

$pc20_codorc = '';
db_postmemory($HTTP_POST_VARS);//echo '<pre>';print_r($HTTP_POST_VARS);die;
db_postmemory($HTTP_GET_VARS);
$clpcorcam                   = new cl_pcorcam;
$clpcorcamitem               = new cl_pcorcamitem;
$clpcorcamforne              = new cl_pcorcamforne;
$clpcorcamval                = new cl_pcorcamval;
$clpcorcamjulg               = new cl_pcorcamjulg;
$clpcorcamdescla             = new cl_pcorcamdescla;
$clliclicitemlote            = new cl_liclicitemlote;
$clliclicita                 = new cl_liclicita;
$oDaoRegistroValor           = new cl_registroprecovalores;
$clhabilitacaoforn = new cl_habilitacaoforn;
$clcflicita = new cl_cflicita();
$lRegistroPreco              = false;
$iFormaControleRegistroPreco = 1;
$pc80_criterioadjudicacao;//OC3770
if (isset($l20_codigo) && $l20_codigo) {

  $sSqlDadosLicitacao = $clliclicita->sql_query_file($l20_codigo);
  $rsDadosLicitacao   = $clliclicita->sql_record($sSqlDadosLicitacao);
  $rsHabilitacao = $clhabilitacaoforn->sql_record($clhabilitacaoforn->sql_query(null,"l206_sequencial,z01_numcgm,z01_nome",null,"l206_licitacao=$l20_codigo"));

  $sWhere     = "1!=1";
   if (isset($pc20_codorc) && !empty($pc20_codorc)) {
    $sWhere = " pc21_codorc=".@$pc20_codorc;
    /*OC3770*/
    $rsResultado = db_query("
      SELECT DISTINCT pc80_criterioadjudicacao
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        WHERE pc20_codorc = {$pc20_codorc}
            AND l21_situacao = 0
    ");
    $pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResultado, 0)->pc80_criterioadjudicacao;
    /*FIM - OC3770*/
   } else {
    $result_orcamento = $clliclicita->sql_record($clliclicita->sql_query_pco($l20_codigo));
    $sWhere = " pc21_codorc=".db_utils::fieldsMemory($result_orcamento, 0)->pc20_codorc;
    /*OC3770*/
      $rsResultado = db_query("
      SELECT DISTINCT pc80_criterioadjudicacao
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        WHERE pc20_codorc = ".db_utils::fieldsMemory($result_orcamento, 0)->pc20_codorc."
            AND l21_situacao = 0
    ");
    $pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResultado, 0)->pc80_criterioadjudicacao;
    /*FIM - OC3770*/
   }
   $rsFornec = $clpcorcamforne->sql_record($clpcorcamforne->sql_query(null,"pc21_numcgm,z01_nome","",$sWhere));

  if ($clliclicita->numrows > 0) {

    $oDadosLicitacao             = db_utils::fieldsMemory($rsDadosLicitacao, 0);
    $rsCflicita = db_query($clcflicita->sql_query_file($oDadosLicitacao->l20_codtipocom));
    $l03_pctipocompratribunal = db_utils::fieldsMemory($rsCflicita, 0)->l03_pctipocompratribunal;

    if ($oDadosLicitacao->l20_descontotab == 1) {
      echo "<script>alert('Licitação por desconto em tabela');</script>";
      echo "<script>document.location.href=\"lic1_lancavallic001.php\"</script>";
    } else if (pg_num_rows($rsHabilitacao) < pg_num_rows($rsFornec) && $l03_pctipocompratribunal != 52) {
      echo "<script>alert('Todos os Fornecedores da licitação devem estar habilitados');</script>";
      echo "<script>document.location.href=\"lic1_fornec001.php?chavepesquisa={$l20_codigo}\"</script>";
    } else {
      $lRegistroPreco = $oDadosLicitacao->l20_usaregistropreco == 't' ? true : false;
    }

    if ($l03_pctipocompratribunal == 102 || $l03_pctipocompratribunal ==103) {

      $clcredenciamento = new cl_credenciamento();
      $result_credenciamento = $clcredenciamento->sql_record($clcredenciamento->sql_query(null,"*",null,"l205_licitacao = $l20_codigo"));

      if (pg_num_rows($result_credenciamento) == 0) {
        echo "<script>alert('Não existe credenciamento cadastrado para esta Dispensa ou Inexigibilidade');</script>";
        echo "<script>document.location.href=\"lic1_fornec001.php?chavepesquisa={$l20_codigo}\"</script>";
      }
    }
    $iFormaControleRegistroPreco = $oDadosLicitacao->l20_formacontroleregistropreco;
  }

}
$db_opcao = 1;
$db_botao = true;

if (isset($alterar) || isset($incluir)) {
    $sqlerro=false;
  if (isset($valores) && trim($valores)!="") {
    $arrval = explode("valor_",$valores);
  } else {

    $sqlerro=true;
    $erro_msg = "Usuário: \\n\\nValores do orçamento não informados. \\nAltere antes de continuar. \\n\\nAdministrador: ";

  }

  if (isset($qtdades) && trim($qtdades)!="") {

    $arrqtd = explode("qtde_",$qtdades);
    $arrqtdorcada = explode("qtdeOrcada_",$qtdadesOrcadas);

  } else {

    $sqlerro=true;
    $erro_msg = "Usuário: \\n\\nQuantidades do orçamento não informadas. \\nAltere antes de continuar. \\n\\nAdministrador: ";

  }
  if (isset($obss) && trim($obss)!="") {
    $arrmrk = explode("obs_",$obss);
  }

  if (isset($valoresun) && trim($valoresun)!="") {
    $arrvalun = explode("vlrun_",$valoresun);
  }

  if (isset($dataval) && trim($dataval)!="") {
    $arrdat = explode("#",$dataval);
  }

  /*OC3770*/
  if(isset($valorperc) && trim($valorperc)!=""){
    $arrvalperc = explode("percdesctaxa_",$valorperc);
  }
  if(isset($lotes) && trim($lotes)!=""){
    $arrvallote = explode("chk_",$lotes);
  }
  /*FIM - OC3770*/

  if (sizeof($arrval) > 0 && $sqlerro == false) {

    if ($sqlerro == false) {

      $validadorc=$pc21_validadorc_ano."-".$pc21_validadorc_mes."-".$pc21_validadorc_dia;
      $prazoent=$pc21_prazoent_ano."-".$pc21_prazoent_mes."-".$pc21_prazoent_dia ;
      if (trim($prazoent)=="--" || trim($prazoent)=='') {
        $prazoent=null;
      }
      if (trim($validadorc)=="--"){
        $validadorc=null;
      }
      $clpcorcamforne->pc21_validadorc = $validadorc;
      $clpcorcamforne->pc21_prazoent   = $prazoent;
      $clpcorcamforne->pc21_orcamforne = $pc21_orcamforne;
      $clpcorcamforne->alterar($pc21_orcamforne);
      if ($clpcorcamforne->erro_status == 0) {

        $sqlerro=true;
        $erro_msg=$clpcorcamforne->erro_msg;

      }
    }
  }

  for ($i = 1; $i < sizeof($arrval); $i++) {
    $codval = explode("_",$arrval[$i]);
    $lotee  = explode("_",$arrvallote[$i]);
    $orcamval = $codval[1];
    $lote     = $lotee[1];
    if ($orcamval == 0) {
      $verifica_lote[] = $lote;
    }
  }

  if (sizeof($arrval) > 0 && $sqlerro == false) {

    //db_inicio_transacao();
    for ($i = 1; $i < sizeof($arrval); $i++) {
      $codvalun = explode("_",$arrvalun[$i]);
      $codval   = explode("_",$arrval[$i]);
      $codqtd   = explode("_",$arrqtd[$i]);
      $desmrk   = explode("_",$arrmrk[$i]);
      $validmin = @$arrdat[$i];
      $quantOrc = explode("_",$arrqtdorcada[$i]);

      /*OC3770*/
      $valpercc  = explode("_",$arrvalperc[$i]);
      $lotee      = explode("_",$arrvallote[$i]);
      /*FIM - OC3770*/

      if ($quantOrc >  $codqtd ) {

        $codfornecedor = "$pc21_orcamforne";
        $item          = $codval[0];
        $mensagem      = "Quantidade do item orçado menor que a quantidade solicitada";
        $clpcorcamdescla->pc32_orcamitem = "$item";
        $clpcorcamdescla->pc32_orcamitem = "$codfornecedor";
        $clpcorcamdescla->pc32_motivo    = "$mensagem";
        $clpcorcamdescla->incluir($item,$codfornecedor);
      }
      if (isset($desmrk[1])) {

        $orcammrk = str_replace("yw00000wy"," ",$desmrk[1]);
      } else {
        $orcammrk = "";
      }
      $orcamitem  = $codval[0];
      $orcamval   = $codval[1];
      $orcamitem2 = $codqtd[0];
      $orcamqtd   = $codqtd[1];
      $valorunit  = $codvalun[1];
      $valperc    = $valpercc[1];
      $lote       = $lotee[1];

      if (strpos(trim($valorunit),',')!="") {

        $valorunit=str_replace('.','',$valorunit);
        $valorunit=str_replace(',','.',$valorunit);
      }

      if (strpos(trim($orcamval),',')!=""){

        $orcamval=str_replace('.','',$orcamval);
        $orcamval=str_replace(',','.',$orcamval);

      }

      if (isset($alterar) && $sqlerro==false) {
        db_inicio_transacao();
        $clpcorcamval->excluir($pc21_orcamforne,$orcamitem);
        db_fim_transacao();
        if ($clpcorcamval->erro_status==0) {
          $erro_msg = $clpcorcamval->erro_msg;
          $sqlerro=true;
          unset($incluir);

        } else {
          $incluir="incluir";
        }
        if ($lRegistroPreco) {
          $oDaoRegistroValor->excluir(null, "pc56_orcamforne = {$pc21_orcamforne} and pc56_orcamitem = {$orcamitem}");
        }
      }

      if (isset($incluir) && $sqlerro == false) {
        if (isset($l04_descricao) && $l04_descricao == 'T') {
            if ($orcamval != 0 && !in_array($lote, $verifica_lote)) {

              if (trim($validmin)!= '' ) {
                $arr_d    = explode("-",$validmin);
                $validmin = $arr_d[2]."-".$arr_d[1]."-".$arr_d[0];
                if (trim($validmin) == "--" || trim($validmin) == '') {
                  $validmin=null;
                }
              } else {
                 $validmin=null;
              }

              $clpcorcamval->pc23_validmin   = $validmin;
              $clpcorcamval->pc23_orcamforne = $pc21_orcamforne;
              $clpcorcamval->pc23_orcamitem  = $orcamitem;
              $clpcorcamval->pc23_valor      = $orcamval;
              $clpcorcamval->pc23_quant      = $orcamqtd;
              $clpcorcamval->pc23_obs        = $orcammrk;
                $clpcorcamval->pc23_vlrun    = $valorunit;
              /*OC3770*/
                if (isset($pc80_criterioadjudicacao) && trim($pc80_criterioadjudicacao) == 1) {
                  $clpcorcamval->pc23_perctaxadesctabela = $valperc;
                }
                else if (isset($pc80_criterioadjudicacao) && trim($pc80_criterioadjudicacao) == 2) {
                  $clpcorcamval->pc23_percentualdesconto = $valperc;

                }
              /*FIM - OC3770*/
              $clpcorcamval->incluir($pc21_orcamforne,$orcamitem);
              $erro_msg = $clpcorcamval->erro_msg;
              if ($clpcorcamval->erro_status==0) {

                $sqlerro=true;
                break;

              }

              if ($sqlerro == false) {
                $clpcorcamjulg->excluir($orcamitem);

                if ($clpcorcamjulg->erro_status==0){
                  $erro_msg = $clpcorcamjulg->erro_msg;
                  $sqlerro=true;
                }
              }
          }
        } else {

            if (trim($validmin)!= '' ) {

              $arr_d    = explode("-",$validmin);
              $validmin = $arr_d[2]."-".$arr_d[1]."-".$arr_d[0];
              if (trim($validmin) == "--" || trim($validmin) == '') {
                $validmin=null;
              }
            } else {
               $validmin=null;
            }
            $clpcorcamval->pc23_validmin   = $validmin;
            $clpcorcamval->pc23_orcamforne = $pc21_orcamforne;
            $clpcorcamval->pc23_orcamitem  = $orcamitem;
            //$clpcorcamval->pc23_valor      = $orcamval;
            if (empty($orcamval)) {
              $clpcorcamval->pc23_valor = "0";
            } else {
                $clpcorcamval->pc23_valor  = $orcamval;
            }
            $clpcorcamval->pc23_quant      = $orcamqtd;
            $clpcorcamval->pc23_obs        = $orcammrk;
            if (empty($valorunit)) {
              $clpcorcamval->pc23_vlrun    = "0";
            } else {
              $clpcorcamval->pc23_vlrun    = $valorunit;
            }
            /*OC3770*/
              if (isset($pc80_criterioadjudicacao) && trim($pc80_criterioadjudicacao) == 1) {
                $clpcorcamval->pc23_perctaxadesctabela = $valperc;
              }
              else if (isset($pc80_criterioadjudicacao) && trim($pc80_criterioadjudicacao) == 2) {
                $clpcorcamval->pc23_percentualdesconto = $valperc;

              }
            /*FIM - OC3770*/
            $clpcorcamval->incluir($pc21_orcamforne,$orcamitem);
            $erro_msg = $clpcorcamval->erro_msg;
            if ($clpcorcamval->erro_status==0) {
              $sqlerro=true;
              break;
            }

            if ($sqlerro == false) {
              db_inicio_transacao();
              $clpcorcamjulg->excluir($orcamitem);
              db_fim_transacao();
              if ($clpcorcamjulg->erro_status==0){
                $erro_msg = $clpcorcamjulg->erro_msg;
                $sqlerro=true;
              }
            }
      }


        /*
         * Caso for registro de preco , devemos incluir os valores do historico do registro de preco
         */
        if ($lRegistroPreco) {

          /**
           * verifica o código do item da solicitacao
           */
          $sSqlDadosRegistroPreco  = "SELECT pc81_solicitem";
          $sSqlDadosRegistroPreco .= "  from pcorcamitem ";
          $sSqlDadosRegistroPreco .= "       inner join pcorcamitemlic on pc26_orcamitem    = pc22_orcamitem ";
          $sSqlDadosRegistroPreco .= "       inner join liclicitem     on l21_codigo        = pc26_liclicitem ";
          $sSqlDadosRegistroPreco .= "       inner join pcprocitem     on l21_codpcprocitem = pc81_codprocitem ";
          $sSqlDadosRegistroPreco .= "       inner join solicitem      on pc11_codigo       = pc81_solicitem   ";
          $sSqlDadosRegistroPreco .= " where pc22_orcamitem  = {$orcamitem} ";

          $rsRegistroPreco = db_query($sSqlDadosRegistroPreco);
          if (pg_num_rows($rsRegistroPreco) != 1) {

            $sqlerro  = true;
            $erro_msg = "Não existem registros de preços para esta solicitação.";
            break;
          }
          $oDadosRegistroPreco = db_utils::fieldsMemory($rsRegistroPreco, 0);
          $oDaoRegistroValor->pc56_ativo          = "true";
          $oDaoRegistroValor->pc56_orcamforne     = $pc21_orcamforne;
          $oDaoRegistroValor->pc56_orcamitem      = $orcamitem;
          if (empty($valorunit)) {
              $oDaoRegistroValor->pc56_valorunitario    = "0";
          } else {
              $oDaoRegistroValor->pc56_valorunitario = $valorunit;
          }

          $oDaoRegistroValor->pc56_solicitem      = $oDadosRegistroPreco->pc81_solicitem;
          $oDaoRegistroValor->incluir(null);
          $erro_msg = $oDaoRegistroValor->erro_msg;
          if ($oDaoRegistroValor->erro_status == 0) {

            $sqlerro=true;
            break;

          }
        }
      }

    $sSQL = "
      SELECT DISTINCT pc22_orcamitem,
       pc01_taxa,
       pc01_tabela
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        WHERE pc22_orcamitem = {$orcamitem}
            AND l21_situacao = 0
    ";
    $verificaItem = db_query($sSQL);
    db_fieldsmemory($verificaItem, 0);

    if ($pc80_criterioadjudicacao == 1) {
      if ($pc01_tabela == "t") {
        $result_itemfornec  = $clpcorcamval->sql_record($clpcorcamval->sql_query_file(null,null,"pc23_orcamforne, pc23_orcamitem, pc23_valor, pc23_quant, pc23_perctaxadesctabela","pc23_perctaxadesctabela DESC"," pc23_valor <> 0 AND trim(pc23_valor::text) <> '' AND pc23_orcamitem=$orcamitem "));
      } else {
          $result_itemfornec  = $clpcorcamval->sql_record($clpcorcamval->sql_query_file(null,null,"pc23_orcamforne, pc23_orcamitem, pc23_valor, pc23_quant, pc23_perctaxadesctabela","pc23_valor"," pc23_valor <> 0 AND trim(pc23_valor::text) <> '' AND pc23_orcamitem=$orcamitem "));
      }
    }
    else if($pc80_criterioadjudicacao == 2) {
      if ($pc01_taxa == "t") {
        $result_itemfornec  = $clpcorcamval->sql_record($clpcorcamval->sql_query_file(null,null,"pc23_orcamforne, pc23_orcamitem, pc23_valor, pc23_quant, pc23_percentualdesconto","pc23_percentualdesconto"," pc23_orcamitem=$orcamitem "));
      } else {
          $result_itemfornec  = $clpcorcamval->sql_record($clpcorcamval->sql_query_file(null,null,"pc23_orcamforne, pc23_orcamitem, pc23_valor, pc23_quant, pc23_percentualdesconto","pc23_valor"," pc23_orcamitem=$orcamitem "));
      }
    } else {
        $result_itemfornec  = $clpcorcamval->sql_record($clpcorcamval->sql_query_file(null,null,"pc23_orcamforne, pc23_orcamitem, pc23_valor, pc23_quant","pc23_valor"," pc23_valor <> 0 AND trim(pc23_valor::text) <> '' AND pc23_orcamitem=$orcamitem "));
    }
    $numrows_itemfornec = $clpcorcamval->numrows;

    $pontuacao = 1;

    for ($ii = 0; $ii < $numrows_itemfornec; $ii++) {
      db_fieldsmemory($result_itemfornec, $ii);
      if ($pc80_criterioadjudicacao == 1) {
          if ($pc01_tabela == 't') {
            if ($pc23_valor != 0  || $pc23_perctaxadesctabela != 0) {
              $clpcorcamjulg->pc24_orcamitem  = $pc23_orcamitem;
              $clpcorcamjulg->pc24_orcamforne = $pc23_orcamforne;
              $clpcorcamjulg->pc24_pontuacao  = $pontuacao;
              db_inicio_transacao();
              $clpcorcamjulg->incluir($pc23_orcamitem,$pc23_orcamforne);
              db_fim_transacao();
              if ($clpcorcamjulg->erro_status == 0) {
                $erro_msg = $clpcorcamjulg->erro_msg;
                $sqlerro=true;
                break;
              }
              $pontuacao++;
            } else {
              $clpcorcamjulg->pc24_orcamitem  = $pc23_orcamitem;
              $clpcorcamjulg->pc24_orcamforne = $pc23_orcamforne;
              $clpcorcamjulg->pc24_pontuacao  = $pontuacao;
              db_inicio_transacao();
              $clpcorcamjulg->incluir($pc23_orcamitem,$pc23_orcamforne);
              db_fim_transacao();
              if ($clpcorcamjulg->erro_status == 0) {
                $erro_msg = $clpcorcamjulg->erro_msg;
                $sqlerro=true;
                break;
              }
              $pontuacao++;
            }
          }
          else if ($pc01_tabela == 'f' && $pc23_valor != 0) {
            $clpcorcamjulg->pc24_orcamitem  = $pc23_orcamitem;
            $clpcorcamjulg->pc24_orcamforne = $pc23_orcamforne;
            $clpcorcamjulg->pc24_pontuacao  = $pontuacao;
            db_inicio_transacao();
            $clpcorcamjulg->incluir($pc23_orcamitem,$pc23_orcamforne);
            db_fim_transacao();
            if ($clpcorcamjulg->erro_status == 0) {
              $erro_msg = $clpcorcamjulg->erro_msg;
              $sqlerro=true;
              break;
            }
            $pontuacao++;
          }
      }

      else if ($pc80_criterioadjudicacao == 2) {
        if ($pc01_taxa == 't') {
          if ($pc23_valor != 0  || $pc23_percentualdesconto != 0) {
            $clpcorcamjulg->pc24_orcamitem  = $pc23_orcamitem;
            $clpcorcamjulg->pc24_orcamforne = $pc23_orcamforne;
            $clpcorcamjulg->pc24_pontuacao  = $pontuacao;
            db_inicio_transacao();
            $clpcorcamjulg->incluir($pc23_orcamitem,$pc23_orcamforne);
            db_fim_transacao();
            if ($clpcorcamjulg->erro_status == 0) {
              $erro_msg = $clpcorcamjulg->erro_msg;
              $sqlerro=true;
              break;
            }
            $pontuacao++;
          } else {
            $clpcorcamjulg->pc24_orcamitem  = $pc23_orcamitem;
            $clpcorcamjulg->pc24_orcamforne = $pc23_orcamforne;
            $clpcorcamjulg->pc24_pontuacao  = $pontuacao;
            db_inicio_transacao();
            $clpcorcamjulg->incluir($pc23_orcamitem,$pc23_orcamforne);
            db_fim_transacao();
            if ($clpcorcamjulg->erro_status == 0) {
              $erro_msg = $clpcorcamjulg->erro_msg;
              $sqlerro=true;
              break;
            }
            $pontuacao++;
          }
        }
        else if ($pc01_taxa == 'f' && $pc23_valor != 0) {
          $clpcorcamjulg->pc24_orcamitem  = $pc23_orcamitem;
          $clpcorcamjulg->pc24_orcamforne = $pc23_orcamforne;
          $clpcorcamjulg->pc24_pontuacao  = $pontuacao;
          db_inicio_transacao();
          $clpcorcamjulg->incluir($pc23_orcamitem,$pc23_orcamforne);
          db_fim_transacao();
          if ($clpcorcamjulg->erro_status == 0) {
            $erro_msg = $clpcorcamjulg->erro_msg;
            $sqlerro=true;
            break;
          }
          $pontuacao++;
        }
      }

      else {
          $clpcorcamjulg->pc24_orcamitem  = $pc23_orcamitem;
          $clpcorcamjulg->pc24_orcamforne = $pc23_orcamforne;
          $clpcorcamjulg->pc24_pontuacao  = $pontuacao;
          db_inicio_transacao();
          $clpcorcamjulg->incluir($pc23_orcamitem,$pc23_orcamforne);
          db_fim_transacao();
          if ($clpcorcamjulg->erro_status == 0) {
            $erro_msg = $clpcorcamjulg->erro_msg;
            $sqlerro=true;
            break;
          }
          $pontuacao++;
      }
    }

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
</head>
  <?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  db_app::load("scripts.js, prototype.js, widgets/windowAux.widget.js,strings.js");
  db_app::load("widgets/dbtextField.widget.js, dbViewCadEndereco.classe.js");
  db_app::load("dbmessageBoard.widget.js, dbautocomplete.widget.js,dbcomboBox.widget.js, datagrid.widget.js");
  db_app::load("estilos.css,grid.style.css");
  ?>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr><td bgcolor="#CCCCCC">&nbsp;</td></tr>
  <tr><td bgcolor="#CCCCCC">&nbsp;</td></tr>
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
  <?php
  if (isset($lic)&&@$lic!=""&&isset($l20_codigo)&&@$l20_codigo!=""){
    $result_info=$clpcorcamitem->sql_record($clpcorcamitem->sql_query_pcmaterlic(null,"distinct pc22_codorc as pc20_codorc",null,"l21_codliclicita=$l20_codigo and l21_situacao = 0 and l08_altera is true"));
    if ($clpcorcamitem->numrows>0){

      db_fieldsmemory($result_info,0);

    }
  }
  if ($iFormaControleRegistroPreco == 2) {

    db_redireciona("lic4_orcamentolicitacaoregistropreco001.php?iLicitacao={$l20_codigo}&pc20_codorc={$pc20_codorc}");
    exit;
  }
  include("forms/db_frmorcamlancvallic.php");
  ?>
    </center>
    </td>
  </tr>
</table>
</body>
</html>
<?
if (isset($achou)&&$achou==true){
     db_msgbox('Licitacao tem itens sem lote.\nFavor definir lote para estes itens.');
     echo "<script>
              document.location.href='lic1_lancavallic001.php';
           </script>";
}

if(isset($incluir) || isset($alterar)){
  if(isset($alterar)){
    $erro_msg = str_replace("Inclusao","Alteracao",$erro_msg);
    $erro_msg = str_replace("EXclusão","Alteracao",$erro_msg);
  }
  if($sqlerro==true){
    $erro_msg = str_replace("\n","\\n",$erro_msg);
    db_msgbox($erro_msg);
  }else{
    echo "
    <script>
      x = document.form1;
      tf= false;
      for(i=0;i<x.length;i++){
  if(x.elements[i].type == 'select-one'){
    numero = new Number(x.elements[i].length);
    for(ii=0;ii<numero;ii++){
      if(x.elements[i].options[ii].selected==true){
        numeroteste = new Number(ii+1);
        if(numeroteste<numero && tf==false){
          x.elements[i].options[ii+1].selected = true;
    js_dalocation(x.elements[i].options[ii+1].value);
    tf = true;
        }else if(tf==false){
          x.elements[i].options[0].selected = true;
    js_dalocation(x.elements[i].options[0].value);
    tf = true;
        }
      }
    }
  }
      }
    </script>
    ";
  }
}
?>
