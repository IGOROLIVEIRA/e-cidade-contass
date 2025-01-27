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


define('DB_LIBS',    '../../');
define('DB_MODEL',   '../../');
define('DB_CLASSES', '../../');
define('DB_DBFORMS', '../../');
define('DB_LOGDIR',  '../../');

if (file_exists('libs/config.ini')) {
	$aConfiguracoes = parse_ini_file('config.ini');
	define('EXERCICIO_BASE', $aConfiguracoes['exercicioBase']);
	define('INTEGRACOES_TRANSPARENCIA',  $aConfiguracoes['integracoes']);
	define('ANO_ESPECIFICO_FOLHA', $aConfiguracoes['anoEspecificoFolha']);
	define('INSTIT_ESPECIFICO_FOLHA', $aConfiguracoes['institEspecificoFolha']);
	define('FILTRO_INSTITUICAO', $aConfiguracoes['filtroInstituicao']);
} else {
	define('EXERCICIO_BASE', 2005);
	define('INTEGRACOES_TRANSPARENCIA',  'IntegracaoLicitacao');
	define('ANO_ESPECIFICO_FOLHA', NULL);
	define('INSTIT_ESPECIFICO_FOLHA', NULL);
	define('FILTRO_INSTITUICAO', NULL);
}
