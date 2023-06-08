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
include("libs/db_sql.php");
include("classes/db_matmaterestoque_classe.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$clmatmaterestoque = new cl_matmaterestoque;

$dbwhere = " where 1 = 1 ";
if (isset($coddepto) && trim(@$coddepto) != ""){
     $dbwhere .= " and m91_codigo in ($coddepto)";
}
if($ponto == 'p'){
  $dbwhere .= " and (coalesce(m70_quant,0) - coalesce(m64_pontopedido,0)) <= 0 ";
} else {
  if($ponto == 'e'){
    $dbwhere .= " and (coalesce(m70_quant,0) - coalesce(m64_estoqueminimo,0)) <= 0 ";
  }

}

$sql_estoqponto = "select m64_matmater, 
                          m60_descr, 
                          coalesce(m70_quant, 0) as m70_quant,
                          m64_pontopedido, 
                          case when (coalesce(m70_quant,0) - coalesce(m64_pontopedido,0)) > 0
                          then ('FALTAM '||(coalesce(m70_quant,0) - coalesce(m64_pontopedido,0)))::VARCHAR
                          else 'ATINGIU P. PEDIDO'::VARCHAR end as dif_ponto_pedido
                   from matmaterestoque
                        inner join matmater   on matmater.m60_codmater      = matmaterestoque.m64_matmater
                        inner join db_almox   on db_almox.m91_codigo        = matmaterestoque.m64_almox
                        inner join db_depart  on db_depart.coddepto         = db_almox.m91_depto
                        inner join matestoque on matestoque.m70_codmatmater = matmater.m60_codmater and
                                                 matestoque.m70_coddepto    = db_almox.m91_depto ";
if (strlen(trim(@$dbwhere)) > 0){
     $sql_estoqponto .= $dbwhere; 
}

if($ordem == 'a'){
  $sql_estoqponto .= " order by m91_codigo, trim(m60_descr) " ;
}else{
  $sql_estoqponto .= " order by m91_codigo, m64_matmater ";
}
$resultado = $clmatmaterestoque->sql_record($sql_estoqponto);
$numrows   = $clmatmaterestoque->numrows;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="a=1">
<center>
<?
if ($numrows == 0){
     echo "<h2>Não existem itens em ponto de pedido.</h2>";
} else {
 //echo $sql_estoqponto;
 //db_criatabela($resultado); exit;
 echo "<h2><div style='color: red;'>Aviso de itens em Ponto de Pedido/Estoque Mínimo.</div></h2>";
 db_lovrot($sql_estoqponto, 30, "", "", "", "", "NoMe", "", false); 
 
}
/*db_fieldsmemory($resultado, 0);
echo  "<b>Deposito: $coddepto - $descrdepto<b>";
$total_registros       = 0;

$total_geral_estoque   = 0;
$total_geral_pedido    = 0;
$total_geral_diferenca_pedido = 0;
$total_geral_minimo    = 0;
$total_geral_diferenca_minimo = 0;

$total_estoque         = 0;
$total_pedido          = 0;
$total_diferenca_pedido       = 0;
$total_minimo          = 0;
$total_diferenca_minimo       = 0;

$codigo_ant = 0;
$sTable = "<table border=1 cellspacing=0 cellpadding=2 bordercolor='666633' bgcolor='#FFFAFA'>";
  $sTable  .= "<tr><th>COD. MATERIAL</th>";
  $sTable .= "<th>DESCRIÇÃO DO MATERIAL</th>";
  $sTable .= "<th>ESTOQUE ATUAL</th>";
  $sTable .= "<th>PONTO DE PEDIDO</th>";
  $sTable .= "<th>DIF PONTO DE PEDIDO</th>";
  $sTable .= "<th>ESTOQUE MÍNIMO</th>";
  $sTable .= "<th>DIF ESTOQUE MÍNIMO</th></tr>"; 
for($i = 0; $i < $numrows; $i++){
  db_fieldsmemory($resultado, $i);
  
  $sTable .= "<tr><td>$m64_matmater</td>";
  $sTable .= "<td>$m60_descr</td>";
  $sTable .= "<td>".db_formatar($m70_quant,"f")."</td>";
  $sTable .= "<td>".db_formatar($m64_pontopedido,"f")."</td>";
  $sTable .= "<td>".db_formatar($diferenca_ponto,"f")."</td>";$coddepto
  $sTable .= "<td>".db_formatar($m64_estoqueminimo,"f")."</td>";
  $sTable .= "<td>".db_formatar($diferenca_estoquemin,"f")."</td></tr>";

     $total_geral_estoque   += $m70_quant;
     $total_geral_pedido    += $m64_pontopedido;
     $total_geral_diferenca_pedido += $diferenca_ponto;
     $total_geral_minimo    += $m64_estoqueminimo;
     $total_geral_diferenca_minimo += $diferenca_estoquemin;
     
     $total_registros++;
}

$sTable .= "<tr><th colspan='2'>TOTAL GERAL:</th>";
$sTable .= "<th>".db_formatar($total_geral_estoque,"f")."</th>";
$sTable .= "<th>".db_formatar($total_geral_pedido,"f")."</th>";
$sTable .= "<th>".db_formatar($total_geral_diferenca_pedido,"f")."</th>";
$sTable .= "<th>".db_formatar($total_geral_minimo,"f")."</th>";
$sTable .= "<th>".db_formatar($total_geral_diferenca_minimo,"f")."</th></tr></table>";

$sTable .= "<tr><td></td></tr>";
$sTable .= "<tr><td><b>TOTAL DE REGISTROS: $total_registros</b></td></tr>";

echo $sTable;*/
?>
</center>
</body>
</html>
<?