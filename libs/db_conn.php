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

require_once ECIDADE_PATH . 'vendor/autoload.php';

$DB_COR_FUNDO = "#00CCFF";
$DB_FILES     = "/dbportal2/imagens/files";
$DB_DIRPCB    = "/home/sistema";
$DB_EXEC      = "/usr/bin/dbs";
$DB_NETSTAT   = "netstat";

// Variaveis de Configuracao estão no arquivo .env
$DB_USUARIO   = config('database.connections.pgsql.username');
$DB_SENHA     = config('database.connections.pgsql.password');;
$DB_SERVIDOR  = config('database.connections.pgsql.host');;
$DB_PORTA     = config('database.connections.pgsql.port');;
$DB_BASE      = resolveTenantDatabase();
$DB_PORTA_ALT = ""; // Porta para conexao direta com PostgreSQL quando tivermos um pool de conexao
$DB_SELLER    = "";
$DB_VALIDA_REQUISITOS = false; // Vari?vel para validar configura??es de instala??o do sistema.
$lUtilizaCaptcha = false; // Vari?vel para habilitar a utiliza??o de captcha
$lVeriricaIpPrivado = false; // Vari?vel para habilitar utiliza??o de captcha somente para IPs p?blicos (externos)
?>
