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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_pcorcam_classe.php");
require_once("classes/db_pcorcamitem_classe.php");
require_once("classes/db_pcorcamitemlic_classe.php");
require_once("classes/db_pcorcamforne_classe.php");
require_once("classes/db_pcorcamfornelic_classe.php");
require_once("classes/db_pcorcamval_classe.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_liclicitatipoempresa_classe.php");
require_once("classes/db_pcorcamjulgamentologitem_classe.php");
require_once("classes/db_credenciamento_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");
require_once("libs/db_utils.php");
require_once("model/licitacao.model.php");
require_once("classes/db_habilitacaoforn_classe.php");
require_once("classes/db_registroprecovalores_classe.php");
require_once("classes/db_pcparam_classe.php");


db_postmemory($HTTP_POST_VARS);
if (isset($_GET['chavepesquisa']) && $_GET['chavepesquisa'] != '') {
  $chavepesquisa = $_GET['chavepesquisa'];
}

echo "<script>parent.document.formaba.db_cred.disabled=true;</script>";
// Same as error_reporting(E_ALL);
//ini_set('error_reporting', E_ALL);

$clpcorcamforne               = new cl_pcorcamforne;
$clpcorcamfornelic            = new cl_pcorcamfornelic;
$clpcorcam                    = new cl_pcorcam;
$clpcorcamitem                = new cl_pcorcamitem;
$clpcorcamitemlic             = new cl_pcorcamitemlic;
$clliclicita                  = new cl_liclicita;
$clliclicitem                 = new cl_liclicitem;
$clpcorcamval                 = new cl_pcorcamval;
$oDaoTipoEmpresa              = new cl_liclicitatipoempresa;
$oDaoPcorcamjulgamentologitem = new cl_pcorcamjulgamentologitem;
$clpcorcamjulg                = new cl_pcorcamjulg;
$clsituacaoitemlic            = new cl_situacaoitemlic;
$clsituacaoitemcompra         = new cl_situacaoitemcompra;
$clpcparam                   = new cl_pcparam;

$result_tipo = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "*"));
if ($clpcparam->numrows > 0) {
  db_fieldsmemory($result_tipo, 0);
} else {
  $erro = true;
}

$db_opcao = 2;
$db_botao = true;
$op       = 11;

if (isset($alterar) || isset($excluir) || isset($incluir) || isset($verificado)) {
  $sqlerro = false;
  $clpcorcamforne->pc21_orcamforne = $pc21_orcamforne;
  $clpcorcamforne->pc21_codorc = $pc20_codorc;
  $clpcorcamforne->pc21_numcgm = $pc21_numcgm;
  $clpcorcamforne->pc21_importado = '0';

  //VERIFICA SE O FORNECEDOR ESTÃ BLOQUEADO
  $oForne = db_utils::getDao("pcforne");
  $oForne = $oForne->sql_record($oForne->sql_query($pc21_numcgm));
  $oForne = db_utils::fieldsMemory($oForne);
  if (isset($incluir)) {
    if (!empty($oForne->pc60_databloqueio_ini) && !empty($oForne->pc60_databloqueio_fim)) {

      if (
        strtotime(date("Y-m-d", db_getsession("DB_datausu"))) >= strtotime($oForne->pc60_databloqueio_ini) &&
        strtotime(date("Y-m-d", db_getsession("DB_datausu"))) <= strtotime($oForne->pc60_databloqueio_fim)
      ) {
        $erro_msg  = "\\n\\n Fornecedor " . $oForne->z01_nome . " está bloqueado para participar de licitaçÃµes !\\n\\n\\n\\n";
        $sqlerro = true;
      }
    }
  }

  if (isset($incluir)) {
    $result_cgmzerado = db_query("select z01_cgccpf from cgm where z01_numcgm = {$pc21_numcgm}");
    db_fieldsmemory($result_cgmzerado, 0)->z01_cgccpf;

    if (strlen($z01_cgccpf) == 14) {
      if ($z01_cgccpf == '00000000000000') {
        $sqlerro = true;
        $erro_msg = "ERRO: Número do CNPJ está zerado. Corrija o CGM do fornecedor e tente novamente";
      }
    }

    if (strlen($z01_cgccpf) == 11) {
      if ($z01_cgccpf == '00000000000') {
        $sqlerro = true;
        $erro_msg = "ERRO: Número do CPF está zerado. Corrija o CGM do fornecedor e tente novamente";
      }
    }

    $rsCgmforn = db_query("select z01_cgccpf from cgm where z01_numcgm = $pc21_numcgm");
    $sCnpjFornecedor  = db_utils::fieldsMemory($rsCgmforn, 0)->z01_cgccpf;
    $rsPcfornereprlegal = db_query("select * from pcfornereprlegal inner join cgm on z01_numcgm = pc81_cgmresp where pc81_cgmforn = $pc21_numcgm and z01_cgccpf = '$sCnpjFornecedor'");
    if (strlen($sCnpjFornecedor) == 14 && pg_num_rows($rsPcfornereprlegal) > 0) {
      $sqlerro = true;
      $erro_msg = "Usuário: No cadastro do fornecedor selecionado, o CGM do Representante está o mesmo CNPJ do CGM do Fornecedor. Corrija o cadastro e selecione novamente o fornecedor.";
    }
  }
  //FIM OC 7037

  if ($sqlerro == false) {

    $result_dtcadcgm = db_query("select z09_datacadastro from historicocgm where z09_numcgm = {$pc21_numcgm} and z09_tipo = 1");
    db_fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;
    $dtsession   = date("Y-m-d", db_getsession("DB_datausu"));

    if ($dtsession < $z09_datacadastro) {
      db_msgbox("Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!");
      $sqlerro = true;
    }

  }
}

$sSql = "SELECT z01_cgccpf
FROM cgm
WHERE z01_numcgm = $pc21_numcgm";

$result  = db_query($sSql);
$tipocgm = db_utils::fieldsMemory($result, 0)->z01_cgccpf;

$sSql = "SELECT pc81_sequencia,
       pc81_datini,
       pc81_datfin,
       pc81_obs,
       b.z01_nome AS pc81_cgmresp,
       pc81_tipopart
FROM pcfornereprlegal
INNER JOIN cgm a ON a.z01_numcgm = pcfornereprlegal.pc81_cgmforn
INNER JOIN cgm b ON b.z01_numcgm = pcfornereprlegal.pc81_cgmresp
WHERE pc81_cgmforn = $pc21_numcgm
ORDER BY b.z01_nome";

$result = db_query($sSql);

for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

  $dados = db_utils::fieldsMemory($result, $iCont);

  if ($dados->pc81_tipopart == 1) {
    $tipopart1 = $dados->pc81_tipopart;
  } elseif ($dados->pc81_tipopart == 2) {
    $tipopart2 = $dados->pc81_tipopart;
  } elseif ($dados->pc81_tipopart == 3) {
    $tipopart3 = $dados->pc81_tipopart;
  }
}

if (isset($incluir)) {
  if ($pc30_permsemdotac == "t") {
    $itens_processos = db_query("select distinct pc81_codproc from pcprocitem inner join solicitem on pc81_solicitem = pc11_codigo
    where pc81_codprocitem in (select l21_codpcprocitem from liclicitem where l21_codliclicita = $l20_codigo) 
    order by pc81_codproc ;");

    $aCodProcessos = array();
    for ($i = 0; $i < pg_numrows($itens_processos); $i++) {
      $item = db_utils::fieldsMemory($itens_processos, $i);
      $oItem = new stdClass();
      $oItem->codproc = $item->pc81_codproc;
      $aCodProcessos[] = $oItem;
    }

    for ($i = 0; $i < count($aCodProcessos); $i++) {

      $codigo = $aCodProcessos[$i]->codproc;
      $itens = db_query("select * from solicitem where pc11_codigo in (select pc11_codigo from pcprocitem inner join solicitem on pc81_solicitem = pc11_codigo
    where pc81_codprocitem in (select l21_codpcprocitem from liclicitem where l21_codliclicita = $l20_codigo and pc81_codproc = $codigo) 
    order by pc81_codproc);");
      $quantidade_itens = pg_numrows($itens);
    }
    $result_natureza = db_query("select l20_tipnaturezaproced from liclicita where l20_codigo=$l20_codigo");
    $tiponaturezaproced = db_utils::fieldsMemory($result_natureza, 0);

    if ($tiponaturezaproced->l20_tipnaturezaproced == 1) {

      for ($i = 0; $i < $quantidade_itens; $i++) {
        $item = db_utils::fieldsMemory($itens, $i);
        $codigo_item =  $item->pc11_codigo;
        $result = db_query("select * from pcdotac where pc13_codigo = $codigo_item;");
        if (pg_numrows($result) == 0) {
          echo "<script>
            alert('Usuário: Item $codigo_item sem dotação vinculada.');
            CurrentWindow.corpo.location.href='lic1_fornec001.php?chavepesquisa=$l20_codigo';
          </script>";

          exit;
        }
      }
    }
  }



  //BUSCO PARAMETRO PNCP
  $sSqlLicParametro = "select l12_pncp from licitaparam where l12_instit = " . db_getsession('DB_instit');
  $rslicparam = db_query($sSqlLicParametro);
  $dlicparam = db_utils::fieldsMemory($rslicparam, 0);
  //BUSCO A LEI
  $sqllei = "select l20_leidalicitacao from liclicita where l20_codigo = $l20_codigo";
  $rslei = db_query($sqllei);
  $dleis = db_utils::fieldsMemory($rslei, 0);

  if ($dleis->l20_leidalicitacao == "1") {
    //BUSCO OS ANEXOS AQUI
    $sqlvinculo = "select * from licanexopncpdocumento
    inner join licanexopncp on
      licanexopncp.l215_sequencial  = licanexopncpdocumento.l216_licanexospncp
    where
      l215_liclicita = $l20_codigo";
    $rsvinculo = db_query($sqlvinculo);
    $dvinculo = db_utils::fieldsMemory($rsvinculo, 0);
    $rsAnexos = pg_num_rows($rsvinculo);

    if ($dlicparam->l12_pncp == 't') {
      if ($rsAnexos == 0) {
        $erro_msg = "A Licitação selecionada é decorrente da Lei número 14133/2021, sendo assim, é necessário anexar no mí­nimo um documento na rotina Anexos Envio PNCP!!";
        $sqlerro = true;
      }
    }
  }

  if (strlen($tipocgm) == 14) {

    if ((isset($tipopart1) && isset($tipopart2)) || isset($tipopart3)) {

      db_inicio_transacao();

      $licita = db_query("select l20_dtpublic,l31_codigo from liclicita inner join liccomissaocgm on l31_licitacao = l20_codigo where l20_codigo = $l20_codigo and l31_tipo = '8';");
      $licita = db_utils::fieldsMemory($licita, 0);
      $sSql = $clliclicita->buscartribunal($l20_codigo);
      $result = db_query("select l03_pctipocompratribunal from liclicita inner join cflicita on l20_codtipocom  = l03_codigo where l20_codigo = $l20_codigo;");
      $tribunal = db_utils::fieldsMemory($result, 0);


      if ($tribunal->l03_pctipocompratribunal == "100" || $tribunal->l03_pctipocompratribunal == "101" || $tribunal->l03_pctipocompratribunal == "102" || $tribunal->l03_pctipocompratribunal == "103") {
      } else {
        if ($licita->l20_dtpublic == "" && $licita->l31_codigo == "") {
          $erro_msg = "Não permitido a inserção de fornecedor na licitação se os campos Data Publicação DO e Resp. pela Publicação não estiverem preenchidos.";
          $sqlerro = true;
        }
      }


      $result = $clliclicita->sql_record($clliclicita->sql_query_pco($l20_codigo));

      if ($clliclicita->numrows == 0) {
        $result_dt = $clliclicita->sql_record($clliclicita->sql_query_file($l20_codigo));
        db_fieldsmemory($result_dt, 0);

        $clpcorcam->pc20_dtate = $l20_dataaber;
        $clpcorcam->pc20_hrate = $l20_horaaber;
        $clpcorcam->incluir(null);
        $pc20_codorc = $clpcorcam->pc20_codorc;
        if ($clpcorcam->erro_status == 0) {
          $sqlerro = true;
          $erro_msg = $clpcorcam->erro_msg;
        }
        if ($sqlerro == false) {
          $result_itens = $clliclicitem->sql_record($clliclicitem->sql_query_file(null, "l21_codigo", null, "l21_codliclicita=$l20_codigo and l21_situacao=0"));
          if ($clliclicitem->numrows == 0) {
            $erro_msg = "Impossivel incluir fornecedores, Licitação sem itens cadastrados!";
            $sqlerro = true;
          }

          for ($w = 0; $w < $clliclicitem->numrows; $w++) {
            db_fieldsmemory($result_itens, $w);
            if ($sqlerro == false) {
              $clpcorcamitem->pc22_codorc = $pc20_codorc;
              $clpcorcamitem->incluir(null);
              $pc22_orcamitem = $clpcorcamitem->pc22_orcamitem;
              if ($clpcorcamitem->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clpcorcamitem->erro_msg;
              }
              $clsituacaoitemcompra->l218_codigo = null;
              $clsituacaoitemcompra->l218_pcorcamitemlic = $pc22_orcamitem;
              $clsituacaoitemcompra->l218_codigolicitacao = $l20_codigo;
              $clsituacaoitemcompra->l218_liclicitem = $l21_codigo;
              $result_pcmater = $clsituacaoitemcompra->sql_record('select pc16_codmater
              from solicitempcmater
              inner join pcprocitem on
              pcprocitem.pc81_solicitem = solicitempcmater.pc16_solicitem
              inner join pcorcamitemproc on
              pcorcamitemproc.pc31_pcprocitem = pcprocitem.pc81_codprocitem
              where
              pcorcamitemproc.pc31_orcamitem = ' . $pc22_orcamitem . '');
              db_fieldsmemory($result_pcmater, 0);
              $clsituacaoitemcompra->l218_pcmater = 0;
              $clsituacaoitemcompra->incluir();
              if ($clsituacaoitemcompra->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clsituacaoitemcompra->erro_msg;
              }
              $clsituacaoitemlic->l219_codigo = $clsituacaoitemcompra->l218_codigo;
              $clsituacaoitemlic->l219_situacao = 1;
              $clsituacaoitemlic->l219_hora = db_hora();
              $clsituacaoitemlic->l219_data = date('Y-m-d', db_getsession('DB_datausu'));
              $clsituacaoitemlic->l219_id_usuario = db_getsession('DB_id_usuario');
              $clsituacaoitemlic->incluir();
              if ($clsituacaoitemlic->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clsituacaoitemlic->erro_msg;
              }
            }
            if ($sqlerro == false) {
              $clpcorcamitemlic->pc26_orcamitem = $pc22_orcamitem;
              $clpcorcamitemlic->pc26_liclicitem = $l21_codigo;
              $clpcorcamitemlic->incluir();
              if ($clpcorcamitemlic->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clpcorcamitemlic->erro_msg;
              }
            }
          }
        }
      }
      $result_igualcgm = $clpcorcamforne->sql_record($clpcorcamforne->sql_query_file(null, "pc21_codorc", "", " pc21_numcgm=$pc21_numcgm and pc21_codorc=$pc20_codorc"));
      if ($clpcorcamforne->numrows > 0) {
        $sqlerro = true;
        $erro_msg = "ERRO: Número de CGM já cadastrado. ";
      }

      if ($sqlerro == false) {
        $clpcorcamforne->pc21_codorc = $pc20_codorc;
        $clpcorcamforne->incluir($pc21_orcamforne);
        $pc21_orcamforne = $clpcorcamforne->pc21_orcamforne;
        if ($clpcorcamforne->erro_status == 0) {
          $erro_msg = $clpcorcamforne->erro_msg;
          $sqlerro = true;
        }
      }
      if ($sqlerro == false) {
        $clpcorcamfornelic->pc31_liclicita = $l20_codigo;
        $clpcorcamfornelic->incluir($pc21_orcamforne);
        if ($clpcorcamfornelic->erro_status == 0) {
          $sqlerro = true;
          $erro_msg = $clpcorcamfornelic->erro_msg;
        }
      }
      db_fim_transacao();
      $op = 1;
    } else {
      echo "<script>alert('É necessário cadastrar pelo menos um representante legal e demais membros para o fornecedor.')</script>";
      $op = 1;
    }
  } else {
    db_inicio_transacao();

    $result = $clliclicita->sql_record($clliclicita->sql_query_pco($l20_codigo));

    if ($clliclicita->numrows == 0) {
      $result_dt = $clliclicita->sql_record($clliclicita->sql_query_file($l20_codigo));
      db_fieldsmemory($result_dt, 0);

      $clpcorcam->pc20_dtate = $l20_dataaber;
      $clpcorcam->pc20_hrate = $l20_horaaber;
      $clpcorcam->incluir(null);
      $pc20_codorc = $clpcorcam->pc20_codorc;
      if ($clpcorcam->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clpcorcam->erro_msg;
      }
      if ($sqlerro == false) {
        $result_itens = $clliclicitem->sql_record($clliclicitem->sql_query_file(null, "l21_codigo", null, "l21_codliclicita=$l20_codigo and l21_situacao=0"));
        if ($clliclicitem->numrows == 0) {
          $erro_msg = "Impossivel incluir fornecedores, Licitação sem itens cadastrados!";
          $sqlerro = true;
        }

        for ($w = 0; $w < $clliclicitem->numrows; $w++) {
          db_fieldsmemory($result_itens, $w);
          if ($sqlerro == false) {
            $clpcorcamitem->pc22_codorc = $pc20_codorc;
            $clpcorcamitem->incluir(null);
            $pc22_orcamitem = $clpcorcamitem->pc22_orcamitem;
            if ($clpcorcamitem->erro_status == 0) {
              $sqlerro = true;
              $erro_msg = $clpcorcamitem->erro_msg;
            }
            $clsituacaoitemcompra->l218_codigo = null;
            $clsituacaoitemcompra->l218_pcorcamitemlic = $pc22_orcamitem;
            $clsituacaoitemcompra->l218_codigolicitacao = $l20_codigo;
            $clsituacaoitemcompra->l218_liclicitem = $l21_codigo;
            $result_pcmater = $clsituacaoitemcompra->sql_record('select pc16_codmater
              from solicitempcmater
              inner join pcprocitem on
              pcprocitem.pc81_solicitem = solicitempcmater.pc16_solicitem
              inner join pcorcamitemproc on
              pcorcamitemproc.pc31_pcprocitem = pcprocitem.pc81_codprocitem
              where
              pcorcamitemproc.pc31_orcamitem = ' . $pc22_orcamitem . '');
            db_fieldsmemory($result_pcmater, 0);
            $clsituacaoitemcompra->l218_pcmater = 0;
            $clsituacaoitemcompra->incluir();
            if ($clsituacaoitemcompra->erro_status == 0) {
              $sqlerro = true;
              $erro_msg = $clsituacaoitemcompra->erro_msg;
            }
            $clsituacaoitemlic->l219_codigo = $clsituacaoitemcompra->l218_codigo;
            $clsituacaoitemlic->l219_situacao = 1;
            $clsituacaoitemlic->l219_hora = db_hora();
            $clsituacaoitemlic->l219_data = date('Y-m-d', db_getsession('DB_datausu'));
            $clsituacaoitemlic->l219_id_usuario = db_getsession('DB_id_usuario');
            $clsituacaoitemlic->incluir();
            if ($clsituacaoitemlic->erro_status == 0) {
              $sqlerro = true;
              $erro_msg = $clsituacaoitemlic->erro_msg;
            }
          }
          if ($sqlerro == false) {
            $clpcorcamitemlic->pc26_orcamitem = $pc22_orcamitem;
            $clpcorcamitemlic->pc26_liclicitem = $l21_codigo;
            $clpcorcamitemlic->incluir();
            if ($clpcorcamitemlic->erro_status == 0) {
              $sqlerro = true;
              $erro_msg = $clpcorcamitemlic->erro_msg;
            }
          }
        }
      }
    }
    $result_igualcgm = $clpcorcamforne->sql_record($clpcorcamforne->sql_query_file(null, "pc21_codorc", "", " pc21_numcgm=$pc21_numcgm and pc21_codorc=$pc20_codorc"));
    if ($clpcorcamforne->numrows > 0) {
      $sqlerro = true;
      $erro_msg = "ERRO: Número de CGM já cadastrado.";
    }

    if ($sqlerro == false) {
      $clpcorcamforne->pc21_codorc = $pc20_codorc;
      $clpcorcamforne->incluir($pc21_orcamforne);
      $pc21_orcamforne = $clpcorcamforne->pc21_orcamforne;
      if ($clpcorcamforne->erro_status == 0) {
        $erro_msg = $clpcorcamforne->erro_msg;
        $sqlerro = true;
      }
    }
    if ($sqlerro == false) {
      $clpcorcamfornelic->pc31_liclicita = $l20_codigo;
      $clpcorcamfornelic->incluir($pc21_orcamforne);
      if ($clpcorcamfornelic->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clpcorcamfornelic->erro_msg;
      }
    }
    db_fim_transacao($sqlerro);
    $op = 1;
  }
} else if (isset($excluir)) {
  $resultValores = $clpcorcamval->sql_record($clpcorcamval->sql_query_file($pc21_orcamforne, null, "sum(pc23_vlrun) as valor", null, ""));
  db_fieldsmemory($resultValores, 0)->valor;
  if ($valor > 0) {
    $sqlerro = true;
    $erro_msg = "Fornecedor com valores lançados";
  } else {
    if (!$sqlerro) {
      $clpcorcamjulg->excluir(null, $pc21_orcamforne, null);
      if ($clpcorcamjulg->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clpcorcamjulg->erro_msg;
      }
    }

    if (!$sqlerro) {
      $clpcorcamval->excluir($pc21_orcamforne);
      if ($clpcorcamval->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clpcorcamval->erro_msg;
      }
    }

    db_inicio_transacao();
    if ($sqlerro == false) {
      $clpcorcamfornelic->excluir($pc21_orcamforne);
      if ($clpcorcamfornelic->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clpcorcamfornelic->erro_msg;
      }
    }

    /**
     * Exclui da pcorcamjulgamentologitem
     */
    if (!$sqlerro) {
      $result = $oDaoPcorcamjulgamentologitem->sql_record($oDaoPcorcamjulgamentologitem->sql_query_file(null, "*", null, "pc93_pcorcamforne = $pc21_orcamforne"));
      if ($oDaoPcorcamjulgamentologitem->numrows > 0) {
        $sWhere = "pc93_pcorcamforne = {$pc21_orcamforne}";
        $oDaoPcorcamjulgamentologitem->excluir(null, $sWhere);

        $erro_msg = $oDaoPcorcamjulgamentologitem->erro_msg;
        if ($oDaoPcorcamjulgamentologitem->erro_status == 0) {
          $sqlerro = true;
        }
      }
    }
    // ini_set('display_errors', 'On');
    // error_reporting(E_ALL);
    if ($sqlerro == false) {
      $clregistroprecovalores = new cl_registroprecovalores;

      $clregistroprecovalores->excluir(null, "pc56_orcamforne = $pc21_orcamforne");

      if ($clregistroprecovalores->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clregistroprecovalores->erro_msg;
      }
    }

    /**
     * excluir habilitacao do fornecedor
     */
    if ($sqlerro == false) {
      $clhabilitacaoforn = new cl_habilitacaoforn;
      $clhabilitacaoforn->excluir(null, "l206_licitacao = {$l20_codigo} and l206_fornecedor = ( select pc21_numcgm from pcorcamforne where pc21_orcamforne={$pc21_orcamforne} limit 1)");

      if ($clhabilitacaoforn->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clhabilitacaoforn->erro_msg;
      }
    }

    if ($sqlerro == false) {
      $clpcorcamforne->excluir($pc21_orcamforne);
      //$erro_msg = $clpcorcamforne->erro_msg;
      if ($clpcorcamforne->erro_status == 0) {
        $sqlerro = true;
      }
    }

    if ($sqlerro == false) {

      $result_forne = $clpcorcamfornelic->sql_record($clpcorcamfornelic->sql_query(null, "*", null, "pc20_codorc=$pc20_codorc"));

      if ($clpcorcamfornelic->numrows == 0) {

        if ($sqlerro == false) {

          $sWhere = "pc26_orcamitem in                                         ";
          $sWhere .= "(select pcorcamitem.pc22_orcamitem                        ";
          $sWhere .= " from pcorcamitem                                         ";
          $sWhere .= "   inner join pcorcam                                     ";
          $sWhere .= "     on    pcorcam.pc20_codorc = pcorcamitem.pc22_codorc  ";
          $sWhere .= "     where pcorcam.pc20_codorc ={$pc20_codorc})           ";
          $sWhere .= "                                                          ";
          $clpcorcamitemlic->excluir(null, $sWhere);

          if ($clpcorcamitemlic->erro_status == 0) {

            $sqlerro = true;
            $erro_msg = $clpcorcamitemlic->erro_msg;
          }
        }

        if ($sqlerro == false) {


          $sWhere = "l219_codigo in (select l218_codigo from situacaoitemcompra where l218_codigolicitacao = {$l20_codigo})";
          $clsituacaoitemlic->excluir(null, $sWhere);

          if ($clsituacaoitemlic->erro_status == 0) {
            $sqlerro = true;
            $erro_msg = $clsituacaoitemlic->erro_msg;
          }

          $sWhere = "l218_codigolicitacao = {$l20_codigo}";
          $clsituacaoitemcompra->excluir(null, $sWhere);
          if ($clsituacaoitemcompra->erro_status == 0) {
            $sqlerro = true;
            $erro_msg = $clsituacaoitemcompra->erro_msg;
          }

          $sWhere = " pcorcamitem.pc22_codorc in (                          ";
          $sWhere .= " select pc20_codorc                                    ";
          $sWhere .= " from pcorcam                                          ";
          $sWhere .= " where                                                 ";
          $sWhere .= "         pcorcam.pc20_codorc = pcorcamitem.pc22_codorc ";
          $sWhere .= "   and   pcorcam.pc20_codorc = {$pc20_codorc})         ";
          $clpcorcamitem->excluir(null, $sWhere);

          $pc22_orcamitem = $clpcorcamitem->pc22_orcamitem;

          if ($clpcorcamitem->erro_status == 0) {

            $sqlerro = true;
            $erro_msg = $clpcorcamitem->erro_msg;
          }
        }

        if ($sqlerro == false) {

          $clpcorcam->excluir($pc20_codorc);
          if ($clpcorcam->erro_status == 0) {

            $sqlerro = true;
            $erro_msg = $clpcorcam->erro_msg;
          }
        }
        if ($sqlerro == false) {
          $exc_tudo = true;
        }
      }
    }
    $op = 1;
    db_fim_transacao($sqlerro);
  }
} else if (isset($opcao) || (isset($chavepesquisa) && $chavepesquisa != "")) {
  $l20_codigo = $chavepesquisa;
  $result = $clliclicita->sql_record($clliclicita->sql_query_pco($chavepesquisa));
  if ($result != false && $clliclicita->numrows > 0) {
    db_fieldsmemory($result, 0);
  }
  $db_botao = true;
  $op = 1;
}
$l20_codigo = $chavepesquisa;
$result = $clliclicita->sql_record($clliclicita->sql_query_pco($chavepesquisa));
if ($result != false && $clliclicita->numrows > 0) {
  db_fieldsmemory($result, 0);
}

if ($l03_pctipocompratribunal == "102" || $l03_pctipocompratribunal == "103") {
  echo "<script>
     parent.document.formaba.db_cred.disabled=false;
    </script>";
  $clcredenciamento = new cl_credenciamento();
  $result_credenciamento = $clcredenciamento->sql_record($clcredenciamento->sql_query(null, "*", null, "l205_licitacao = $l20_codigo"));

  if (pg_num_rows($result_credenciamento) == 0) {
    $db_botao = false;
  }
}

?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td width="360" height="18">&nbsp;</td>
      <td width="263">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>
  <table width="790" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
        <center>

          <?
          include("forms/db_frmforneclic.php");
          ?>

        </center>
      </td>
    </tr>
  </table>
</body>

</html>
<?


if (isset($alterar) || isset($excluir) || isset($incluir) || isset($verificado)) {

  if (isset($excluir) && isset($exc_tudo) && $exc_tudo == true) {
    if ($sqlerro == true) {
      db_msgbox($erro_msg);
    }
    //echo "<script>location.href='lic1_fornec001.php';</script>";
  } else {
    if ($sqlerro == true) {
      db_msgbox($erro_msg);
      if ($clpcorcamforne->erro_campo != "") {
        echo "<script> document.form1." . $clpcorcamforne->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1." . $clpcorcamforne->erro_campo . ".focus();</script>";
      }
    } else {
      if (isset($tipopart1) && isset($tipopart2)) {
        if ($sqlerro == true) {
          db_msgbox($erro_msg);
        }
      }
      //echo "<script>location.href='lic1_fornec001.php?chavepesquisa=$l20_codigo';</script>";
    }
  }
}

$sWhere = "1!=1";
if (isset($pc21_codorc) && !empty($pc21_codorc)) {
  $sWhere = "pc21_codorc=" . @$pc21_codorc;
}

$result_libera = $clpcorcamforne->sql_record($clpcorcamforne->sql_query_file(null, "pc21_codorc", "", $sWhere));
$tranca        = "true";

if ($clpcorcamforne->numrows > 0) {
  $tranca = "false";
}
if ($op == 11) {
  echo "<script>document.form1.pesquisar.click();</script>";
}

$sWhere = "pc21_codorc=" . @$pc20_codorc;
$result_fornaba = $clpcorcamforne->sql_record($clpcorcamforne->sql_query(null, "pc21_orcamforne,pc21_codorc,pc21_numcgm,z01_nome", "", $sWhere));
$iNumCgmForn  = db_utils::fieldsMemory($result_fornaba, 0)->pc21_numcgm;
?>

<input type="hidden" id="cgmaba" value="<? echo $iNumCgmForn ?>" />

<script>
  //parent.document.formaba.db_cred.disabled=true;
  //parent.document.formaba.db_hab.disabled=true;

  if (parent.document.formaba.db_cred.onclick != '') {

    var param1 = $('pc20_codorc').value;
    var param2 = $('l20_codigo').value;
    var param3 = $('cgmaba').value;

    CurrentWindow.corpo.iframe_db_cred.location.href = 'lic1_credenciamento001.php?pc20_codorc=' + param1 + '&l20_codigo=' + param2 + '&l205_fornecedor=' + param3;
    //parent.document.formaba.db_cred.disabled=false;
    //parent.document.formaba.db_hab.disabled=false;

  }

  if (parent.document.formaba.db_habi.onclick != '') {

    var param1 = $('pc20_codorc').value;
    var param2 = $('l20_codigo').value;

    CurrentWindow.corpo.iframe_db_habi.location.href = 'lic1_habilitacaoforn001.php?l20_codigo=' + param2 + '&pc20_codorc=' + param1;
    //parent.document.formaba.db_cred.disabled=false;
    //parent.document.formaba.db_hab.disabled=false;

  }
</script>