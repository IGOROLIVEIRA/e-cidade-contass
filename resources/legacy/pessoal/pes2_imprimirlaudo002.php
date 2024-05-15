<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBseller Servicos de Informatica
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
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("std/db_stdClass.php");

$oGet  = db_utils::postMemory($_GET);

$sArquivoPdf = "tmp/Laudo_Medico.pdf";

db_inicio_transacao();
$lEmitirArquivo = DBLargeObject::leitura( $oGet->oid, $sArquivoPdf );
db_fim_transacao();

if( !$lEmitirArquivo ){
  db_redireciona('db_erros.php?fechar=true&db_erro=Erro ao ler arquivo pdf.');
}

if( !file_exists( $sArquivoPdf ) ){
  db_redireciona('db_erros.php?fechar=true&db_erro=Erro ao gerar arquivo pdf.');
}

Header('Content-Type: application/pdf');
header("Expires: Mon, 06 Jan 2020 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Cache-control: private");
header("Content-Length: ".filesize($sArquivoPdf));
Header('Content-disposition: attachment; filename=Laudo_Medico');
readfile($sArquivoPdf);