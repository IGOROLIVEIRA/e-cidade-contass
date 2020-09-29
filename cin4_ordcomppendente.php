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
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
include("libs/db_sql.php");
include("classes/db_matordem_classe.php");
include("classes/db_empparametro_classe.php");

$clmatordem     = new cl_matordem;
$clempparametro = new cl_empparametro;
$iAnoUsu        = db_getsession("DB_anousu");
$dtDataUsu      = date("Y-m-d", db_getsession("DB_datausu"));
$iInstit        = db_getsession('DB_instit');

$sSqlEmpParam   = $clempparametro->sql_query_file ($iAnoUsu,$campos="e30_prazoentordcompra",null,"");
$rsEmpParam     = $clempparametro->sql_record($sSqlEmpParam);
$iDiasPrazo     = db_utils::fieldsMemory($rsEmpParam, 0)->e30_prazoentordcompra;

$sSqlOrdemPendente = "  SELECT  m51_codordem,
                                fornecedor as dl_fornecedor,
                                empenho as dl_empenho,
                                m51_data,
                                (('{$dtDataUsu}'::date - m51_data::date)||' DIAS')::varchar as dl_entrada_pendente_ha
                        FROM
                            (SELECT m51_codordem,
                                    z01_nome as fornecedor,
                                    empenho,
                                    m51_data,
                                    m51_valortotal,
                                    coalesce((SELECT sum(m71_valor)
                                                FROM matestoqueitemoc
                                                    INNER JOIN matordemitem ON matordemitem.m52_codlanc = matestoqueitemoc.m73_codmatordemitem
                                                    INNER JOIN matestoqueitem ON matestoqueitem.m71_codlanc = matestoqueitemoc.m73_codmatestoqueitem
                                                    INNER JOIN matordem ON matordem.m51_codordem = matordemitem.m52_codordem
                                                    INNER JOIN matestoque AS a ON a.m70_codigo = matestoqueitem.m71_codmatestoque
                                                WHERE m52_codordem = x.m51_codordem
                                                        AND m73_cancelado IS FALSE),0) AS valorlancado
                                FROM 
                                    (SELECT DISTINCT
                                        m51_codordem,
                                        m52_codlanc,
                                        z01_nome,
                                        (e60_codemp||'/'||e60_anousu)::varchar AS empenho,
                                        m51_data,
                                        m51_valortotal
                                    FROM matordem
                                        INNER JOIN matordemitem ON matordemitem.m52_codordem = matordem.m51_codordem
                                        LEFT JOIN empnotaord ON empnotaord.m72_codordem = matordem.m51_codordem
                                        LEFT JOIN empnota ON empnota.e69_codnota = empnotaord.m72_codnota
                                        LEFT JOIN empempenho ON empempenho.e60_numemp = matordemitem.m52_numemp
                                        INNER JOIN cgm ON cgm.z01_numcgm = matordem.m51_numcgm
                                        LEFT JOIN matordemanu ON matordemanu.m53_codordem = matordem.m51_codordem
                                    WHERE e60_anousu = {$iAnoUsu}
                                        AND (m51_obs != 'Ordem de Compra Automatica' OR m51_obs IS NULL)
                                        AND m53_codordem IS NULL
                                        AND e60_instit = {$iInstit}
                                    ) as x
                                GROUP BY 1, 2, 3, 4, 5, 6
                            ) AS xx
                        WHERE m51_valortotal::numeric > valorlancado::numeric 
                            AND (m51_data+{$iDiasPrazo}) < '{$dtDataUsu}'
                        ORDER BY m51_data";

$rsResultOrdemPendente = $clmatordem->sql_record($sSqlOrdemPendente);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
.DBLovrotRegistrosRetornados {
    text-align: center;
}
</style>
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="a=1">
<center>

<?
if ($clmatordem->numrows == 0) {
    echo "<h2>NÃO HÁ ORDENS DE COMPRA PENDENTES DE ENTRADA</h2>";
} else {
    echo "<h2><div style='color: red;'>AVISO DE ORDENS DE COMPRA PENDENTES DE ENTRADA</div></h2>";
    db_lovrot($sSqlOrdemPendente, 10, "", "", "", "", "NoMe", "", false); 
}

?>
</center>
</body>
</html>
<?