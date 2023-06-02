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
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_liborcamento.php");
require_once("fpdf151/assinatura.php");
include("classes/db_db_userinst_classe.php");

$cl_db_userinst = new cl_db_userinst;

try {

  $oGet = db_utils::postMemory($_GET);
  $iCodRelatorio = 173;

  $oAnexoI = new PrevExecReceitasOrcamentarias(
    db_getsession('DB_anousu'),
    $iCodRelatorio,
    $oGet->iBimestre
  );

  $db_selinstit = '';

  // o bloco de código imediatamente abaixo garante que o relatório abrangerá somente as instituições autorizadas ao usuario
  $resit  = $cl_db_userinst->sql_record($cl_db_userinst->sql_query_file(null, null,"id_instit",'id_instit',"id_usuario=".db_getsession("DB_id_usuario")));
  if ($cl_db_userinst->numrows > 0) {
    for($x=0;$x<$cl_db_userinst->numrows;$x++){
      db_fieldsmemory($resit,$x);
      $db_selinstit .= $id_instit;
      if($x !== $cl_db_userinst->numrows-1){
        $db_selinstit .= ',';
      }
    }
  }

  $oAnexoI->setInstituicoes($db_selinstit);

  if((int)$iFormato === 1){
    $oAnexoI->emitir();
    exit();

  }
  $oAnexoI->emitirCsv();

} catch (Exception $e) {
  db_redireciona("db_erros.php?db_erro=".$e->getMessage());
}
