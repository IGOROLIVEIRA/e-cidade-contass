<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (c) 2014  DBSeller Servicos de Informatica
 *                      www.dbseller.com.br
 *                   e-cidade@dbseller.com.br
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

class cl_jornada extends DAOBasica {

  function __construct() {
    parent::__construct("recursoshumanos.jornada");
  }

  function sqlQueryHorario($iMatricula) {
	  	$sql = "SELECT jornada.rh188_sequencial,
       gradeshorariosjornada.rh191_ordemhorario,
       gradeshorarios.rh190_database,
       gradeshorarios.rh190_database+gradeshorariosjornada.rh191_ordemhorario-1 AS diatrabalho
FROM jornada
JOIN gradeshorariosjornada ON gradeshorariosjornada.rh191_jornada = jornada.rh188_sequencial
JOIN gradeshorarios ON gradeshorariosjornada.rh191_gradehorarios = gradeshorarios.rh190_sequencial
JOIN escalaservidor ON gradeshorarios.rh190_sequencial = escalaservidor.rh192_gradeshorarios AND escalaservidor.rh192_regist = {$iMatricula}
WHERE
        (SELECT count(*)
         FROM jornadahoras
         WHERE jornadahoras.rh189_jornada = jornada.rh188_sequencial) >= 2
ORDER BY jornada.rh188_sequencial,
         gradeshorariosjornada.rh191_ordemhorario";

         return $sql;
  }
}