<?php
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

include("classes/db_pcprocitem_classe.php");
include("classes/db_pcproc_classe.php");
include("classes/db_pcparam_classe.php");
include("classes/db_pcorcam_classe.php");
include("classes/db_pcorcamitem_classe.php");
include("classes/db_pcorcamitemproc_classe.php");
include("classes/db_pcorcamforne_classe.php");
include("classes/db_pcorcamval_classe.php");
include("classes/db_pcorcamjulg_classe.php");
include("classes/db_pcorcamtroca_classe.php");
include("classes/db_solicitem_classe.php");
include("classes/db_licitaparam_classe.php");
include("dbforms/db_funcoes.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_sql.php");

db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);
$clsolicita        = new cl_solicita;
// $clpcorcamforne2   = new cl_pcorcamforne;

$clsolicitem       = new cl_solicitem;
$clpcprocitem      = new cl_pcprocitem;
$clpcproc          = new cl_pcproc;
$clpcparam         = new cl_pcparam;
$clpcorcam         = new cl_pcorcam;
$clpcorcamitem     = new cl_pcorcamitem;
$clpcorcamitemproc = new cl_pcorcamitemproc;
$clpcorcamforne    = new cl_pcorcamforne;
$clpcorcamval      = new cl_pcorcamval;
$clpcorcamjulg     = new cl_pcorcamjulg;
$clpcorcamtroca    = new cl_pcorcamtroca;
$clsolicitemele    = new cl_solicitemele;
$clpcdotac         = new cl_pcdotac;

$db_botao          = true;
$db_opcao          = 1;

$erro_msg = "";
$result_pcparam = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "pc30_horas,pc30_dias,pc30_contrandsol"));
db_fieldsmemory($result_pcparam, 0);
if (isset($incluir) || isset($juntar)) {
  $gerouorc = false;
  $sqlerro = false;
  if (isset($valores) && $valores != "") {
    db_inicio_transacao();

    if ($pc80_numdispensa != "") {
      $sql = "select pc80_numdispensa as numerodispensa,pc80_codproc as codigoprocesso from pcproc
                inner join db_depart on coddepto = pc80_depto
              where pc80_numdispensa={$pc80_numdispensa} AND db_depart.instit = ". db_getsession('DB_instit') . " and pc80_numdispensa > 0";
      $rsPccompra = db_query($sql);

      $dispensacadastrada = db_utils::getColectionByRecord($rsPccompra);
      foreach ($dispensacadastrada as $dispensa) {
        $erro_msg = "Já existe uma dispensa cadastrada com mesmo numero codigo do processo: {$dispensa->codigoprocesso}";
        $sqlerro = true;
        break;
      }
    }

    if (isset($incluir)) {
      $rsDataSolicitacao = db_query("select pc10_data from solicita where pc10_numero = $pc10_numero;");
      $dataSolicitacao = db_utils::fieldsMemory($rsDataSolicitacao, 0)->pc10_data;
      $clpcproc->pc80_data = implode("-", array_reverse(explode("/", $pc80_data)));

      if ($clpcproc->pc80_data < $dataSolicitacao) {
        $erro_msg .= "Usuário: a data do processo de compra não pode ser menor que a data da solicitação.";
        $sqlerro  = true;
      }

      $clpcproc->pc80_usuario               = db_getsession("DB_id_usuario");
      $clpcproc->pc80_depto                 = db_getsession("DB_coddepto");
      $clpcproc->pc80_resumo                = $pc10_resumo;
      $clpcproc->pc80_numdispensa           = $pc80_numdispensa;
      $clpcproc->pc80_dispvalor             = $pc80_dispvalor;
      $clpcproc->pc80_orcsigiloso           = $pc80_orcsigiloso;
      $clpcproc->pc80_subcontratacao        = $pc80_subcontratacao;
      $clpcproc->pc80_dadoscomplementares   = $pc80_dadoscomplementares;
      $clpcproc->pc80_amparolegal           = $pc80_amparolegal;
      $clpcproc->pc80_categoriaprocesso     = $pc80_categoriaprocesso;
      $clpcproc->pc80_modalidadecontratacao = $pc80_modalidadecontratacao;
      $clpcproc->pc80_criteriojulgamento    = $pc80_criteriojulgamento;

      /*OC3770*/
      $clpcproc->pc80_criterioadjudicacao   = $pc80_criterioadjudicacao;
      /*FIM - OC3770*/

      $clpcproc->incluir(null);
      if ($clpcproc->erro_status == 0) {
        $erro_msg .= $clpcproc->erro_msg;
        $sqlerro  = true;
      }
      $pc80_codproc = $clpcproc->pc80_codproc;
      /*OC3770*/
      $verifica  = false;
      if (isset($pc80_criterioadjudicacao) && !empty($pc80_criterioadjudicacao) && $pc80_criterioadjudicacao != 3) {
        $sSQL = "
            SELECT pcmater.pc01_tabela, pc01_taxa
                FROM solicitem
                INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
                INNER JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
                LEFT JOIN db_usuarios ON solicita.pc10_login = db_usuarios.id_usuario
                LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
                WHERE pc11_numero = {$pc10_numero}
                    AND pc11_codigo NOT IN
                        (SELECT DISTINCT pc81_solicitem
                         FROM pcprocitem)
                    AND pc11_liberado='t'
                    AND pc10_instit = " . db_getsession('DB_instit') . "
                ORDER BY pc11_codigo
        ";
        $rsResultado = db_query($sSQL);
        $resultados = db_utils::getColectionByRecord($rsResultado);
        if ($pc80_criterioadjudicacao == 1) {
          foreach ($resultados as $resultado) {
            if ($resultado->pc01_tabela == 't') {
              $verifica = true;
            }
            if ($resultado->pc01_taxa == 't') {
              $erro_msg = "Não foi possível salvar registro! O tipo de processo DESCONTO SOBRE TABELA não podem conter itens do tipo MENOR TAXA OU PERCENTUAL!";
              $sqlerro = true;
              break;
            }
          }
          if ($verifica == false) {
            $erro_msg = "Não foi possível salvar registro! Para o tipo de processo DESCONTO SOBRE TABELA\né necessário que exista pelo menos um item do tipo tabela!";
            $sqlerro = true;
          }
        } else {
          foreach ($resultados as $resultado) {
            if ($resultado->pc01_taxa == 't') {
              $verifica = true;
            }
            if ($resultado->pc01_tabela == 't') {
              $erro_msg = "Não foi possível salvar registro! O tipo de processo MENOR TAXA OU PERCENTUAL não podem conter itens do tipo DESCONTO SOBRE TABELA!";
              $sqlerro = true;
              break;
            }
          }
          if ($verifica == false) {
            $erro_msg = "Não foi possível salvar registro! Para o tipo de processo MENOR TAXA OU PERCENTUAL\né necessário que exista pelo menos um item do tipo taxa!";
            $sqlerro = true;
          }
        }
      }
      /*FIM - OC3770*/
    }
    $arr_valores = explode(",", $valores);
    if (isset($juntar)) {
      db_inicio_transacao();

      $clsolicitempcmater = new cl_solicitempcmater;
      $clsolicitemunid = new cl_solicitemunid;
      $pc80_codproc = $juntar;

      //LOCALIZA A SOLICITACAO DO PROCESSO DE COMPRAS
      $oDaoSolicita = $clsolicita->sql_record("select distinct pc11_numero, pc10_resumo, pc10_solicitacaotipo from solicitem inner join solicita on pc10_numero = pc11_numero where pc11_codigo in (select pc81_solicitem from pcprocitem where pc81_codproc = $pc80_codproc)");
      $pc10_solicitacaotipo = db_utils::fieldsMemory($oDaoSolicita, 0)->pc10_solicitacaotipo;
      $pc10_resumo = db_utils::fieldsMemory($oDaoSolicita, 0)->pc10_resumo;
      $novaSolicita = db_utils::fieldsMemory($oDaoSolicita, 0)->pc11_numero;

      //localiza os parametros
      $result_tipo = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "pc30_mincar,pc30_obrigamat,pc30_obrigajust,pc30_seltipo,pc30_sugforn,pc30_permsemdotac,pc30_contrandsol,pc30_tipoprocsol,pc30_gerareserva,pc30_passadepart"));
      if ($clpcparam->numrows > 0) {
        db_fieldsmemory($result_tipo, 0);
      } else {
        $sqlerro = true;
        $msgalert = "Configure os parâmetros para continuar.";
      }
      //cria a nova solicitacao

      //VERIFICA SE A SOLICITACAO É DO TIPO 8 OU NÃO
      if ($pc10_solicitacaotipo != 8) {

        $pc11_numero = db_utils::fieldsMemory($oDaoSolicita, 0)->pc11_numero;

        //LOCALIZA OS ITENS DA SOLICITACAO
        $oDaoSolicitem = $clsolicitem->sql_record("select * from solicitem inner join solicitempcmater on pc16_solicitem = pc11_codigo inner join solicitemunid on pc17_codigo = pc11_codigo inner join solicitemele on pc18_solicitem = pc11_codigo inner join pcdotac on pc13_codigo = pc11_codigo inner join orcdotacao on o58_coddot = pc13_coddot where pc11_numero = $pc11_numero and o58_anousu = " . db_getsession('DB_anousu'));

        //CRIA A NOVA SOLICITACAO DO TIPO 8
        $clsolicita->pc10_correto = "true";
        $clsolicita->pc10_depto           = db_getsession("DB_coddepto");
        $clsolicita->pc10_log             = 0;
        $clsolicita->pc10_instit          = db_getsession("DB_instit");
        $clsolicita->pc10_login           = db_getsession("DB_id_usuario");
        $clsolicita->pc10_data            = date("Y-m-d", db_getsession("DB_datausu"));
        $clsolicita->pc10_resumo          = 'SOLICITAÇÃO UNIFICADA ' . $pc11_numero;
        $clsolicita->pc10_solicitacaotipo = 8;
        $clsolicita->pc10_numero = null;
        $clsolicita->incluir(null);
        $pc10_resumo = $clsolicita->pc10_resumo;
        $novaSolicita = $clsolicita->pc10_numero;
        if ($clsolicita->erro_status == 0) {
          $erro_msg = $clsolicita->erro_msg;
          $sqlerro = true;
        }

        //REMOVE OS ITENS DA SOLICITACAO PARA RECEBER OS NOVOS ITENS DA SOLICITACAO TIPO 8
        $clpcprocitem->sql_record("delete from pcprocitem where pc81_codproc = $pc80_codproc");

        //DESLIBERA OS ITENS DA SOLICITACAO ANTIGA
        for ($x = 0; $x < pg_num_rows($oDaoSolicitem); $x++) {
          $rsSolicitem = db_utils::fieldsMemory($oDaoSolicitem, $x);
          $clsolicitem->pc11_liberado          = 'f';
          $clsolicitem->alterar($rsSolicitem->pc11_codigo);
        }

        //REPLICA OS ITENS DA PRIMEIRA SOLCIITACAO PARA A NOVA SOLICITACAO
        for ($x = 0; $x < pg_num_rows($oDaoSolicitem); $x++) {
          $rsSolicitem = db_utils::fieldsMemory($oDaoSolicitem, $x);
          $clsolicitem->pc11_numero             = $novaSolicita;
          $clsolicitem->pc11_seq                = $rsSolicitem->pc11_seq;
          $clsolicitem->pc11_quant              = $rsSolicitem->pc11_quant;
          $clsolicitem->pc11_vlrun              = $rsSolicitem->pc11_vlrun;
          $clsolicitem->pc11_prazo              = $rsSolicitem->pc11_prazo;
          $clsolicitem->pc11_pgto               = $rsSolicitem->pc11_pgto;
          $clsolicitem->pc11_resum              = $rsSolicitem->pc11_resum;
          $clsolicitem->pc11_just               = $rsSolicitem->pc11_just;
          $clsolicitem->pc11_liberado           = $rsSolicitem->pc11_liberado;
          $clsolicitem->pc11_servicoquantidade  = $rsSolicitem->pc11_servicoquantidade;
          $clsolicitem->pc11_reservado          = $rsSolicitem->pc11_reservado;
          $clsolicitem->pc11_codigo             = null;
          $clsolicitem->incluir(null);

          $clsolicitempcmater->incluir($rsSolicitem->pc16_codmater, $clsolicitem->pc11_codigo);

          $clsolicitemunid->pc17_unid = $rsSolicitem->pc17_unid;
          $clsolicitemunid->pc17_quant =  $rsSolicitem->pc17_quant;
          $clsolicitemunid->pc17_codigo = $clsolicitem->pc11_codigo;
          $clsolicitemunid->incluir($clsolicitem->pc11_codigo);

          $clsolicitemele->incluir($clsolicitem->pc11_codigo, $rsSolicitem->pc18_codele);

          $clpcdotac->pc13_anousu = $rsSolicitem->pc13_anousu;
          $clpcdotac->pc13_coddot = $rsSolicitem->pc13_coddot;
          $clpcdotac->pc13_depto  = $rsSolicitem->pc13_depto;
          $clpcdotac->pc13_quant  = $rsSolicitem->pc13_quant;
          $clpcdotac->pc13_valor  = $rsSolicitem->pc13_valor;
          $clpcdotac->pc13_codele = $rsSolicitem->pc13_codele;
          $clpcdotac->pc13_codigo = $clsolicitem->pc11_codigo;
          $clpcdotac->incluir(null);

          $clpcprocitem->pc81_codproc   = $pc80_codproc;
          $clpcprocitem->pc81_solicitem = $clsolicitem->pc11_codigo;
          $clpcprocitem->pc81_codprocitem = null;
          $clpcprocitem->incluir(null);
          if (!isset($arr_solici[$clsolicitem->pc11_codigo])) {
            $arr_solici[$clsolicitem->pc11_codigo] = $clpcprocitem->pc81_codprocitem;
          }
          if ($clpcprocitem->erro_status == 0) {
            if (empty($erro_msg)) {
              $erro_msg = $clpcprocitem->erro_msg;
            }
            $sqlerro  = true;
            break;
          }
        }
      }

      //SELECIONA OS ITENS REPLICADOS DA NOVA SOLICITACAO
      $oDaoSolicitemnova = $clsolicitem->sql_record("select distinct pc11_codigo, pc16_codmater, pc13_coddot, pc13_sequencial, pc13_quant, pc11_quant, pc13_valor from solicitem inner join solicitempcmater on pc16_solicitem = pc11_codigo inner join pcdotac on pc13_codigo = pc11_codigo where pc11_numero = $novaSolicita");
      $sequencialNovosItens = pg_num_rows($oDaoSolicitemnova);

      $arr_numero = array();
      $arr_solici = array();
      for ($i = 0; $i < sizeof($arr_valores); $i++) {

        $arr_item  = explode("_", $arr_valores[$i]);

        if (in_array($arr_item[1], $arr_numero) == false) {
          array_push($arr_numero, $arr_item[1]);
        }

        $pc11_codigo = $arr_item[2];

        if ($pc30_contrandsol == 't') {
          $sqltran = "select distinct x.p62_codtran

            from ( select distinct p62_codtran,
                             p62_dttran,
                             p63_codproc,
                             descrdepto,
                             p62_hora,
                             login,
                             pc11_numero,
                             pc11_codigo,
                             pc81_codproc,
                             e55_autori,
                             e54_anulad
                  from proctransferproc

                       inner join solicitemprot        on pc49_protprocesso                   = proctransferproc.p63_codproc
                       inner join solicitem            on pc49_solicitem                      = pc11_codigo
                       inner join proctransfer         on p63_codtran                         = p62_codtran
                       inner join
                      }  join empautitem           on empautitem.e55_autori               = empautitempcprocitem.e73_autori
                                                      and empautitem.e55_sequen               = empautitempcprocitem.e73_sequen
                       left join empautoriza           on empautoriza.e54_autori              = empautitem.e55_autori
                      where  p62_coddeptorec = " . db_getsession("DB_coddepto") . "
                    ) as x
                    left join proctransand 	on p64_codtran = x.p62_codtran
                    left join arqproc 	on p68_codproc = x.p63_codproc
                  where p64_codtran is null and p68_codproc is null and x.pc11_codigo = $pc11_codigo";
          $result_tran = db_query($sqltran);
          if (pg_numrows($result_tran) != 0) {
            for ($w = 0; $w < pg_numrows($result_tran); $w++) {
              db_fieldsmemory($result_tran, $w);
              $recebetransf = recprocandsol($p62_codtran);
              if ($recebetransf == true) {
                $sqlerro = true;
                break;
              }
            }
          }
        }

        //SELECIONA OS DADOS DO ITEM PARA INCLUIR NA NOVA SOLICITACAO
        $oDaoSolicitem = $clsolicitem->sql_record("select * from solicitem inner join solicitempcmater on pc16_solicitem = pc11_codigo inner join solicitemunid on pc17_codigo = pc11_codigo inner join solicitemele on pc18_solicitem = pc11_codigo inner join pcdotac on pc13_codigo = pc11_codigo where pc11_codigo = $pc11_codigo");

        $itemCadastrado = false;

        $rsSolicitem = db_utils::fieldsMemory($oDaoSolicitem, 0);

        //REPLICA O ITEM NA NOVA SOLICITACAO
        for ($y = 0; $y < pg_num_rows($oDaoSolicitemnova); $y++) {
          $rsSolicitemnova = db_utils::fieldsMemory($oDaoSolicitemnova, $y);

          //CASO O ITEM JÁ EXISTA NA NOVA SOLICITACAO ALTERA A QUANTIDADE
          if ($rsSolicitemnova->pc16_codmater == $rsSolicitem->pc16_codmater) {
            $clsolicitem->pc11_numero             = '';
            $clsolicitem->pc11_seq                = '';
            $clsolicitem->pc11_vlrun              = '';
            $clsolicitem->pc11_prazo              = '';
            $clsolicitem->pc11_pgto               = '';
            $clsolicitem->pc11_resum              = '';
            $clsolicitem->pc11_just               = '';
            $clsolicitem->pc11_servicoquantidade  = '';
            $clsolicitem->pc11_reservado          = '';
            $clsolicitem->pc11_liberado           = '';
            $clsolicitem->pc11_quant              = $rsSolicitem->pc11_quant + $rsSolicitemnova->pc11_quant;
            $clsolicitem->pc11_codigo             = $rsSolicitemnova->pc11_codigo;
            $clsolicitem->alterar($rsSolicitemnova->pc11_codigo);

            //CASO A DOTACAO SEJA IGUAL ALTERA A QUANTIDADE OU INCLUI A DOTACAO
            if ($rsSolicitemnova->pc13_coddot == $rsSolicitem->pc13_coddot) {

              $clpcdotac->pc13_anousu = '';
              $clpcdotac->pc13_coddot = '';
              $clpcdotac->pc13_depto  = '';
              $clpcdotac->pc13_quant  = $rsSolicitem->pc13_quant + $rsSolicitemnova->pc13_quant;
              $clpcdotac->pc13_valor  = $rsSolicitem->pc13_valor + $rsSolicitemnova->pc13_valor;
              $clpcdotac->pc13_codele = '';
              $clpcdotac->pc13_codigo = '';
              $clpcdotac->pc13_sequencial = $rsSolicitemnova->pc13_sequencial;
              $clpcdotac->alterar($rsSolicitemnova->pc13_sequencial);
            } else {

              $clpcdotac->pc13_anousu = $rsSolicitem->pc13_anousu;
              $clpcdotac->pc13_coddot = $rsSolicitem->pc13_coddot;
              $clpcdotac->pc13_depto  = $rsSolicitem->pc13_depto;
              $clpcdotac->pc13_quant  = $rsSolicitem->pc13_quant;
              $clpcdotac->pc13_valor  = $rsSolicitem->pc13_valor;
              $clpcdotac->pc13_codele = $rsSolicitem->pc13_codele;
              $clpcdotac->pc13_codigo = $rsSolicitemnova->pc11_codigo;
              $clpcdotac->incluir(null);
            }

            $itemCadastrado = true;
          }
        }

        //CASSO O ITEM NÃO EXISTA INCLUI O ITEM NA NOVA SOLICITACAO
        if (!$itemCadastrado) {
          $sequencialNovosItens++;
          $clsolicitem->pc11_numero             = $novaSolicita;
          $clsolicitem->pc11_seq                = $sequencialNovosItens;
          $clsolicitem->pc11_quant              = $rsSolicitem->pc11_quant;
          $clsolicitem->pc11_vlrun              = $rsSolicitem->pc11_vlrun;
          $clsolicitem->pc11_prazo              = $rsSolicitem->pc11_prazo;
          $clsolicitem->pc11_pgto               = $rsSolicitem->pc11_pgto;
          $clsolicitem->pc11_resum              = $rsSolicitem->pc11_resum;
          $clsolicitem->pc11_just               = $rsSolicitem->pc11_just;
          $clsolicitem->pc11_liberado           = $rsSolicitem->pc11_liberado;
          $clsolicitem->pc11_servicoquantidade  = $rsSolicitem->pc11_servicoquantidade;
          $clsolicitem->pc11_reservado          = $rsSolicitem->pc11_reservado;
          $clsolicitem->pc11_codigo             = null;
          $clsolicitem->incluir(null);

          $clsolicitempcmater->incluir($rsSolicitem->pc16_codmater, $clsolicitem->pc11_codigo);

          $clsolicitemunid->pc17_unid = $rsSolicitem->pc17_unid;
          $clsolicitemunid->pc17_quant =  $rsSolicitem->pc17_quant;
          $clsolicitemunid->pc17_codigo = $clsolicitem->pc11_codigo;
          $clsolicitemunid->incluir($clsolicitem->pc11_codigo);

          $clsolicitemele->incluir($clsolicitem->pc11_codigo, $rsSolicitem->pc18_codele);

          $clpcdotac->pc13_anousu = $rsSolicitem->pc13_anousu;
          $clpcdotac->pc13_coddot = $rsSolicitem->pc13_coddot;
          $clpcdotac->pc13_depto  = $rsSolicitem->pc13_depto;
          $clpcdotac->pc13_quant  = $rsSolicitem->pc13_quant;
          $clpcdotac->pc13_valor  = $rsSolicitem->pc13_valor;
          $clpcdotac->pc13_codele = $rsSolicitem->pc13_codele;
          $clpcdotac->pc13_codigo = $clsolicitem->pc11_codigo;
          $clpcdotac->incluir(null);

          $clpcprocitem->pc81_codproc   = $pc80_codproc;
          $clpcprocitem->pc81_solicitem = $clsolicitem->pc11_codigo;
          $clpcprocitem->pc81_codprocitem = null;
          $clpcprocitem->incluir(null);
          if (!isset($arr_solici[$clsolicitem->pc11_codigo])) {
            $arr_solici[$clsolicitem->pc11_codigo] = $clpcprocitem->pc81_codprocitem;
          }
          if ($clpcprocitem->erro_status == 0) {
            if (empty($erro_msg)) {
              $erro_msg = $clpcprocitem->erro_msg;
            }
            $sqlerro  = true;
            break;
          }
        }

        //DESLIBERA O ITEM DA SOLICITACAO ANTIGA
        $clsolicitem->pc11_numero             = '';
        $clsolicitem->pc11_seq                = '';
        $clsolicitem->pc11_quant              = '';
        $clsolicitem->pc11_vlrun              = '';
        $clsolicitem->pc11_prazo              = '';
        $clsolicitem->pc11_pgto               = '';
        $clsolicitem->pc11_resum              = '';
        $clsolicitem->pc11_just               = '';
        $clsolicitem->pc11_servicoquantidade  = '';
        $clsolicitem->pc11_reservado          = '';
        $clsolicitem->pc11_liberado          = 'f';
        $clsolicitem->pc11_codigo          = $rsSolicitem->pc11_codigo;
        $clsolicitem->alterar($rsSolicitem->pc11_codigo);
      }

      //ORDENA OS ITENS DA NOVA SOLICITACAO
      $oDaoSolicitemOrdernado = $clsolicitem->sql_record("select pc11_codigo, pc16_codmater from solicitem inner join solicitempcmater on pc16_solicitem = pc11_codigo inner join pcmater on pc01_codmater = pc16_codmater where pc11_numero = $novaSolicita order by pc01_descrmater ASC");
      for ($y = 0; $y < pg_num_rows($oDaoSolicitemOrdernado); $y++) {
        $rsSolicitemOrdenado = db_utils::fieldsMemory($oDaoSolicitemOrdernado, $y);

        $clsolicitem->pc11_numero             = '';
        $clsolicitem->pc11_seq                = $y + 1;
        $clsolicitem->pc11_vlrun              = '';
        $clsolicitem->pc11_prazo              = '';
        $clsolicitem->pc11_pgto               = '';
        $clsolicitem->pc11_resum              = '';
        $clsolicitem->pc11_just               = '';
        $clsolicitem->pc11_servicoquantidade  = '';
        $clsolicitem->pc11_reservado          = '';
        $clsolicitem->pc11_liberado           = '';
        $clsolicitem->pc11_quant              = '';
        $clsolicitem->pc11_codigo             = $rsSolicitemOrdenado->pc11_codigo;
        $clsolicitem->alterar($rsSolicitemOrdenado->pc11_codigo);
      }

      //ALTERA O RESUMO INCLUINDO O NUMERO DA SOLICITACAO
      $clsolicita->pc10_resumo          = $pc10_resumo . ' ' . $rsSolicitem->pc11_numero;
      $clsolicita->pc10_numero = $novaSolicita;
      $clsolicita->alterar($novaSolicita);



      db_fim_transacao($sqlerro);
    } else {
      $arr_numero = array();
      $arr_solici = array();
      for ($i = 0; $i < sizeof($arr_valores); $i++) {
        $arr_item  = explode("_", $arr_valores[$i]);
        if (in_array($arr_item[1], $arr_numero) == false) {
          array_push($arr_numero, $arr_item[1]);
        }
        $pc11_codigo = $arr_item[2];
        if ($pc30_contrandsol == 't') {
          $sqltran = "select distinct x.p62_codtran

        from ( select distinct p62_codtran,
                            p62_dttran,
                            p63_codproc,
                            descrdepto,
                            p62_hora,
                            login,
                            pc11_numero,
                pc11_codigo,
                            pc81_codproc,
                            e55_autori,
                e54_anulad
                from proctransferproc

                      inner join solicitemprot        on pc49_protprocesso                   = proctransferproc.p63_codproc
                      inner join solicitem            on pc49_solicitem                      = pc11_codigo
                      inner join proctransfer         on p63_codtran                         = p62_codtran
                      inner join db_depart            on coddepto                            = p62_coddepto
                      inner join db_usuarios          on id_usuario                          = p62_id_usuario
                      left  join pcprocitem           on pcprocitem.pc81_solicitem           = solicitem.pc11_codigo
                      left  join empautitempcprocitem on empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem
                      left  join empautitem           on empautitem.e55_autori               = empautitempcprocitem.e73_autori
                                                    and empautitem.e55_sequen               = empautitempcprocitem.e73_sequen
                      left join empautoriza           on empautoriza.e54_autori              = empautitem.e55_autori
                    where  p62_coddeptorec = " . db_getsession("DB_coddepto") . "
                  ) as x
          left join proctransand 	on p64_codtran = x.p62_codtran
          left join arqproc 	on p68_codproc = x.p63_codproc
        where p64_codtran is null and p68_codproc is null and x.pc11_codigo = $pc11_codigo";
          $result_tran = db_query($sqltran);
          if (pg_numrows($result_tran) != 0) {
            for ($w = 0; $w < pg_numrows($result_tran); $w++) {
              db_fieldsmemory($result_tran, $w);
              $recebetransf = recprocandsol($p62_codtran);
              if ($recebetransf == true) {
                $sqlerro = true;
                break;
              }
            }
          }
        }

        $clpcprocitem->pc81_codproc   = $pc80_codproc;
        $clpcprocitem->pc81_solicitem = $pc11_codigo;

        $clpcprocitem->incluir(@$pc81_codprocitem);
        if (!isset($arr_solici[$pc11_codigo])) {
          $arr_solici[$pc11_codigo] = $clpcprocitem->pc81_codprocitem;
        }
        if ($clpcprocitem->erro_status == 0) {
          if (empty($erro_msg)) {
            $erro_msg = $clpcprocitem->erro_msg;
          }
          $sqlerro  = true;
          break;
        }
      }
    }

    $arr_importar = explode(",", $importa);
    $arr_orcam = array();
    $rowssizeof = sizeof($arr_importar);
    $arr_orcamfornexist  = array();


    for ($i = 0; $i < $rowssizeof; $i++) {
      if (trim($arr_importar[$i]) != "") {
        $arr_importaritem = explode("_", $arr_importar[$i]);
        $orcamento = $arr_importaritem[1];
        $item      = $arr_importaritem[2];
        $orcamitem = $arr_importaritem[3];
        if (isset($arr_solici[$item]) && $sqlerro == false) {
          if ($gerouorc == false) {
            $clpcorcam->pc20_dtate = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + $pc30_dias, date("Y")));
            $clpcorcam->pc20_hrate = $pc30_horas;

            if (isset($juntar)) {
              $result_pc22_codorc = $clpcorcamitemproc->sql_record($clpcorcamitemproc->sql_query(null, null, "max(pc20_codorc) as pc20_codorc", "", " pc80_codproc=$pc80_codproc"));
              if ($clpcorcamitemproc->numrows > 0) {
                db_fieldsmemory($result_pc22_codorc, 0);
              } else {
                $clpcorcam->incluir(null);
                $pc20_codorc = $clpcorcam->pc20_codorc;
              }
            } else {
              $clpcorcam->incluir(null);
              $pc20_codorc = $clpcorcam->pc20_codorc;
            }

            if ($clpcorcam->erro_status == "0") {

              $erro_msg .= $clpcorcam->erro_msg;
              $sqlerro = true;
              break;
            } else {
              $erro_msg .= "\\n\\nOBS.: Foi gerado o orçamento número $pc20_codorc para este processo de compras.";
            }
            $gerouorc = true;
          }
          if ($sqlerro == false && isset($pc20_codorc)) {
            $clpcorcamitem->pc22_codorc = $pc20_codorc;

            $clpcorcamitem->incluir(null);
            $pc22_orcamitem = $clpcorcamitem->pc22_orcamitem;
            if ($clpcorcamitem->erro_status == 0) {
              $erro_msg .= $clpcorcamitem->erro_msg;
              $sqlerro = true;
              break;
            }
          }
          if ($sqlerro == false && isset($pc22_orcamitem)) {

            $clpcorcamitemproc->incluir($pc22_orcamitem, $arr_solici[$item]);
            if ($clpcorcamitemproc->erro_status == 0) {
              $erro_msg .= $clpcorcamitemproc->erro_msg;
              $sqlerro = true;
              break;
            }
          }
          if ($sqlerro == false && isset($pc20_codorc)) {
            $result_fornecedores = $clpcorcamforne->sql_record($clpcorcamforne->sql_query_fornec(null, "pc21_numcgm,pc21_orcamforne as selforne", "", " pc22_orcamitem=$orcamitem "));
            $numrows_contafornec = $clpcorcamforne->numrows;
            for ($contaforne = 0; $contaforne < $numrows_contafornec; $contaforne++) {
              db_fieldsmemory($result_fornecedores, $contaforne);
              if (!isset($arr_orcamfornexist[$pc21_numcgm . "_" . $pc20_codorc])) {

                $clpcorcamforne->pc21_numcgm    = $pc21_numcgm;
                $clpcorcamforne->pc21_codorc    = $pc20_codorc;
                $clpcorcamforne->pc21_importado = 'true';
                $clpcorcamforne->incluir(null);
                $pc21_orcamforne = $clpcorcamforne->pc21_orcamforne;
                $arr_orcamfornexist[$pc21_numcgm . "_" . $pc20_codorc] = $pc21_orcamforne;
                //	        db_msgbox($arr_orcamfornexist[$pc21_numcgm."_".$pc20_codorc]);
                if ($clpcorcamforne->erro_status == 0) {
                  $erro_msg .= $clpcorcamforne->erro_msg;
                  $sqlerro = true;
                  break;
                }
              }
              $pc21_orcamforne = $arr_orcamfornexist[$pc21_numcgm . "_" . $pc20_codorc];
              //	      db_msgbox($pc21_orcamforne);
              $result_pcorcamval = $clpcorcamval->sql_record($clpcorcamval->sql_query_file($selforne, $orcamitem, "pc23_valor,pc23_quant,pc23_vlrun,pc23_obs"));
              $numrows_pcorcamval = $clpcorcamval->numrows;
              if ($numrows_pcorcamval > 0) {
                db_fieldsmemory($result_pcorcamval, 0);
                $clpcorcamval->pc23_valor = $pc23_valor;
                $clpcorcamval->pc23_quant = $pc23_quant;
                $clpcorcamval->pc23_vlrun = $pc23_vlrun;
                $clpcorcamval->pc23_obs   = addslashes(stripslashes(chop($pc23_obs)));

                $clpcorcamval->incluir($pc21_orcamforne, $pc22_orcamitem);
                if ($clpcorcamval->erro_status == 0) {
                  $erro_msg .= $clpcorcamval->erro_msg;
                  $sqlerro = true;
                  break;
                }

                if ($sqlerro == false && isset($pc21_orcamforne) && isset($pc22_orcamitem)) {
                  $result_itemjulg = $clpcorcamjulg->sql_record($clpcorcamjulg->sql_query_file($orcamitem, $selforne, "pc24_pontuacao as pontuacao"));
                  $numrows_itemjulg = $clpcorcamjulg->numrows;
                  for ($ii = 0; $ii < $numrows_itemjulg; $ii++) {
                    db_fieldsmemory($result_itemjulg, $ii);
                    $clpcorcamjulg->pc24_pontuacao = $pontuacao;

                    $clpcorcamjulg->incluir($pc22_orcamitem, $pc21_orcamforne);
                    if ($clpcorcamjulg->erro_status == 0) {
                      $erro_msg = $clpcorcamjulg->erro_msg;
                      $sqlerro = true;
                      break;
                    }
                  }
                  if ($sqlerro == true) {
                    break;
                  }
                }
                if ($sqlerro == false && isset($pc22_orcamitem)) {
                  $result_itemtroca = $clpcorcamtroca->sql_record($clpcorcamtroca->sql_query_file(null, "pc25_motivo,pc25_forneant,pc25_forneatu", "", "pc25_orcamitem=$orcamitem"));
                  $numrows_itemtroca = $clpcorcamtroca->numrows;
                  for ($ii = 0; $ii < $numrows_itemtroca; $ii++) {
                    db_fieldsmemory($result_itemtroca, $ii);
                    $clpcorcamtroca->pc25_orcamitem = $pc22_orcamitem;
                    $clpcorcamtroca->pc25_motivo    = addslashes(stripslashes(chop($pc25_motivo)));

                    if (trim(@$pc25_forneant) == "") {
                      $clpcorcamtroca->pc25_forneant = $clpcorcamforne->pc21_orcamforne;
                    } else {
                      $clpcorcamtroca->pc25_forneant = $pc25_forneant;
                    }

                    if (trim(@$pc25_forneatu) == "") {
                      $clpcorcamtroca->pc25_forneatu = $clpcorcamforne->pc21_orcamforne;
                    } else {
                      $clpcorcamtroca->pc25_forneatu = $pc25_forneatu;
                    }

                    $clpcorcamtroca->incluir(null);
                    if ($clpcorcamtroca->erro_status == 0) {
                      $erro_msg = $clpcorcamtroca->erro_msg;
                      $sqlerro = true;
                      break;
                    }
                  }
                }
              }
            }
            if ($sqlerro == true) {
              break;
            }
          }
        }
      }
    }

    if ($sqlerro == false) {
      unset($valores, $importa);
      if (isset($juntar)) {
        db_msgbox("Solicitação $rsSolicitem->pc11_numero vinculada ao processo de compras $juntar!");
      }
    }
    db_fim_transacao($sqlerro);

  } else {
    $sqlerro = true;
    $erro_msg = "Não é possível incluir Processo de Compras sem informar Item(ns).";
  }
}

$oParam = new cl_licitaparam;
$oParam = $oParam->sql_query(null, '*', null, "l12_instit = " . db_getsession('DB_instit'));
$oParam = db_query($oParam);
$oParam = db_utils::fieldsMemory($oParam);
$oParam = $oParam->l12_pncp;
?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/arrays.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body class="body-default">
  <div class="container">
    <?php
    if ($oParam == 't') {
      include("forms/db_frmpcprocPNCP.php");
    } else {
      include("forms/db_frmpcproc.php");
    }
    ?>
  </div>
  <?php
  db_menu(
    db_getsession("DB_id_usuario"),
    db_getsession("DB_modulo"),
    db_getsession("DB_anousu"),
    db_getsession("DB_instit")
  );
  ?>
</body>
<script>
  arr_dados = new Array();
  arr_impor = new Array();
</script>

</html>
<?php
if (isset($incluir)) {

  if (!$sqlerro) {

    echo "<script>
      if (confirm('Processo de Compras {$pc80_codproc} incluído com sucesso. Deseja emitir o documento?')){
        jan = window.open('com2_emiteprocessocompra002.php?pc80_codproc_inicial={$pc80_codproc}&pc80_codproc_final={$pc80_codproc}',
                           '',
                           'width='+(screen.availWidth - 5),
                           'height='+(screen.availHeight-40)+',scrollbars=1, location=0'
                          );
        jan.moveTo(0, 0);
      }
      window.location = \"com1_pcproc001.php\";
      ";

    if ($pc80_tipoprocesso == 2) {
      echo "window.location = \"com4_processocompra001.php?acao=2&iCodigo={$pc80_codproc}\";";
    }

    echo "</script>";
  } else {
    db_msgbox($erro_msg);
  }
  if ($sqlerro == true) {
    if ($clpcproc->erro_campo != "") {
      echo "<script> document.form1." . $clpcproc->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1." . $clpcproc->erro_campo . ".focus();</script>";
    };
  }
}
?>
