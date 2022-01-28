<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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

include("fpdf151/pdf.php");
include("libs/db_sql.php");



parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;



$head2 = "PAGAMENTO DA FOLHA EM CONTA CORRENTE";
$head4 = "DATA :  ".db_formatar(date('Y-m-d',db_getsession("DB_datausu")),'d');
//$lotacao = 's';

if($lotacao == 's'){
 $ordem = " r70_estrut , r38_banco, r38_agenc, r38_nome ";
}else{
 $ordem = " r38_banco, r38_agenc, r38_nome ";
}
$where = '';

if($matricula != 0){
  $where = " where r38_regist in ($matricula)";
}
$sql = "
         select r38_banco,
				        db90_descr,
				        r38_agenc,
								r70_estrut,
								r70_descr,
								r38_regist,
								r38_numcgm,
								r38_conta,
								r38_nome,
								r38_liq,
                z01_cgccpf 
				 from folha
              inner join cgm on r38_numcgm = z01_numcgm
				      inner join rhlota on to_number(r38_lotac,'9999') = r70_codigo
							                 and r70_instit = ".db_getsession("DB_instit")."
							left  join db_bancos on r38_banco = db90_codban 
				 $where
				 order by $ordem
";
$result = pg_exec($sql);
$xxnum = pg_numrows($result);
if($xxnum == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum registro encontrado no periodo de '.$mes.' / '.$ano);
}

header("Content-type: text/plain");
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");

echo "MATRIC;CGM;CPF;NOME;LIQUIDO;BANCO;AGENCIA;CONTA;\n";

for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   echo "$r38_regist;$r38_numcgm;".db_formatar($z01_cgccpf,'cpf').";$r38_nome;$r38_liq;$r38_banco;$r38_agenc;$r38_conta;\n";

   $tot_banco += $r38_liq;
   $tot_age   += $r38_liq;
   $tot_lota  += $r38_liq;
   $tot_func  += 1;
}

echo "TOTAL DO BANCO;TOTAL DE FUNC;";
echo "$tot_age;$tot_func;\n";

?>