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
require_once("classes/db_liclicitem_classe.php");
require_once("dbforms/db_funcoes.php");
require_once('libs/db_utils.php');
require_once("classes/licitacao.model.php");
$clliclicitem = new cl_liclicitem;
$clrotulo     = new rotulocampo;
$clrotulo->label("l20_codigo");

db_postmemory($HTTP_GET_VARS);

$oGet         = db_utils::postMemory($_GET);

$iLicitacao   = $oGet->l20_codigo;

if ($oGet->extensao == 1) {
    $extensao = 'txt';
} else if ($oGet->extensao == 2) {
    $extensao = 'csv';
} else if ($oGet->extensao == 3) {
    $extensao = 'imp';
}

//====================  instanciamos a classe da solicitação selecionada para retornar os itens

$oLicitacao = new licitacao($iLicitacao);
try {
    $aEditalLicitacao   = $oLicitacao->getEditalExport();
    $aItensLicitacao    = $oLicitacao->getItensExport();
    $aEditalLicitacao    = $oLicitacao->getLoteExport();
} catch (Exception $oErro) {
    db_redireciona('db_erros.php?fechar=true&db_erro=' . $oErro->getMessage());
}

//========================  escrevemos o arquivos com os itens encontrados para a solicitação

$clabre_arquivo = new cl_abre_arquivo("/tmp/Licitacao_$iLicitacao.$extensao");

if ($clabre_arquivo->arquivo != false) {

    $vir = $separador;
    $del = $delimitador;

    fputs($clabre_arquivo->arquivo, "\n");

    foreach ($aItensLicitacao as $iItens => $oItens) {

        $iTipoRegistro                   = '1';
        $iCodigoOrgao                    = '01';
        $iTipoOrgao                      = '01';
        $iCnpj                           = $oItens->cnpj;
        $sNomeOrgao                      = $oItens->nomeorgao;
        $iProcessoLicitatorio            = $oItens->processolicitatorio;
        $iExercicio                      = $oItens->anoprocessolicitatorio;
        $iNroEdital                      = $oItens->processolicitatorio;
        $iExercicioEdital                = $oItens->anoprocessolicitatorio;
        $sProcessoObjeto                 = '';
        $iNaturezaObjeto                 = '';
        $iRegistroPreco                  = '';

        fputs($clabre_arquivo->arquivo, formatarCampo($iTipoRegistro, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCodigoOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iTipoOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iNroEdital, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCnpj, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($sNomeOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iProcessoLicitatorio, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iExercício, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iNroEdital, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iExercicioEdital, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($sProcessoObjeto, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iNaturezaObjeto, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iRegistroPreco, $vir, $del));
        fputs($clabre_arquivo->arquivo, "\n");
    }

    fclose($clabre_arquivo->arquivo);

    echo "<script>";
    echo "  jan = window.open('db_download.php?arquivo=" . $clabre_arquivo->nomearq . "','','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');";
    echo "  jan.moveTo(0,0);";
    echo "</script>";
}

// Funcao para formatar um campo
function formatarCampo($valor, $separador, $delimitador)
{

    $del = "";
    if ($delimitador == "1") {
        $del = "|";
    } else if ($delimitador == "2") {
        $del = ";";
    } else if ($delimitador == "3") {
        $del = ",";
    }

    $valor = str_replace("\n", " ", $valor);
    $valor = str_replace("\r", " ", $valor);

    return "{$del}{$valor}{$del}{$separador}";
}
