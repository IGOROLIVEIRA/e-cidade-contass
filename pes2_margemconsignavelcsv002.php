<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$ponto = 's';

if($ponto == 's'){
  $arquivo = 'gerfsal';
  $sigla   = 'r14_';
}elseif($ponto == 'c'){
  $arquivo = 'gerfcom';
  $sigla   = 'r48_';
}elseif($ponto == 'a'){
  $arquivo = 'gerfadi';
  $sigla   = 'r22_';
}elseif($ponto == 'r'){
  $arquivo = 'gerfres';
  $sigla   = 'r20_';
}elseif($ponto == 'd'){
  $arquivo = 'gerfs13';
  $sigla   = 'r35_';
}

$wherepes = '';

if(isset($select) && $select != ''){
  $result_sel = db_query("select r44_where , r44_descr from selecao where r44_selec = {$select} and r44_instit = ". db_getsession("DB_instit"));
  if(pg_numrows($result_sel) > 0){
    db_fieldsmemory($result_sel, 0, 1);
    $wherepes .= " and ".$r44_where;
  }
}

// echo "<br><br><br>  selecao --> $select <br><br>";

$where_margem = '';

if($tipo_margem == 's'){
  $where_margem =  ' and (remuneracao - desc_obrigatorios) - comprometido <= 0  ' ;
}elseif($tipo_margem == 'c'){
  $where_margem =  ' and (remuneracao - desc_obrigatorios) - comprometido > 0  ' ;
}

if ( trim ( $aMatriculas ) != "" ) {
    $where_margem .= "  and regist in ({$aMatriculas}) \n";
}

if($ordem ==  'n'){
  $xordem = ' order by regist '; 
}else{
  $xordem = ' order by z01_nome '; 
}


$sql = "
        select * 
        from
        ( 
        select 
               ".$sigla."regist as regist,
       	       z01_nome,z01_cgccpf,
               round(sum(case when ".$sigla."rubric in (select r09_rubric 
	                                      from basesr 
					      where r09_base = '$base1' 
					        and r09_anousu = ".db_anofolha()."
						and r09_mesusu = ".db_mesfolha()."
					      ) then ".$sigla."valor else 0 end),2) as remuneracao,
               round(sum(case when ".$sigla."rubric in (select r09_rubric 
	                                      from basesr 
					      where r09_base = '$base2' 
					        and r09_anousu = ".db_anofolha()."
						and r09_mesusu = ".db_mesfolha()."
					      ) then ".$sigla."valor else 0 end),2) as desc_obrigatorios,
               round(sum(case when ".$sigla."rubric in (select r09_rubric 
	                                      from basesr 
					      where r09_base = '$base3' 
					        and r09_anousu = ".db_anofolha()."
						and r09_mesusu = ".db_mesfolha()."
					      ) then ".$sigla."valor else 0 end),2) as comprometido
      	from ".$arquivo." 
             inner join rhpessoalmov on ".$sigla."regist = rh02_regist 
                                    and rh02_anousu = ".$sigla."anousu 
                     		    and rh02_mesusu = ".$sigla."mesusu
				    and rh02_instit = ".$sigla."instit
            left join rhpesbanco on rh02_seqpes = rh44_seqpes
	     inner join rhpessoal   on  rh01_regist = rh02_regist											
             inner join cgm on z01_numcgm = rh01_numcgm 
       	where ".$sigla."anousu = $ano 
       	  and ".$sigla."mesusu = $mes
          $wherepes
  	  and ".$sigla."instit = ".db_getsession("DB_instit")."
	group by ".$sigla."regist, z01_nome, z01_cgccpf
        $xordem 
        ) as x
        where 1 = 1 $where_margem
       ";
 // echo $sql ; exit;

$result = db_query($sql);
//db_criatabela($result);exit;
$xxnum = pg_numrows($result);
if ($xxnum == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=Não existem Cálculo no período de '.$mes.' / '.$ano);
}

header("Content-type: text/plain");
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");

echo "MATRIC;NOME;CPF;REMUNERAÇÃO;DESC.OBRIG.;DISPONÍVEL;COMPROMETIDO;MARGEM;\n";
for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   $z01_cgccpf = db_formatar($z01_cgccpf,'cpf');
   $disponivel = ($remuneracao - $desc_obrigatorios)/100*$perc;
   $margem = db_formatar($disponivel - $comprometido,'f');
   $remuneracao = db_formatar($remuneracao,'f');
   $desc_obrigatorios = db_formatar($desc_obrigatorios,'f');
   $comprometido = db_formatar($comprometido,'f');
   $disponivel = db_formatar($disponivel,'f');
   echo "$regist;$z01_nome;$z01_cgccpf;$remuneracao;$desc_obrigatorios;$disponivel;$comprometido;$margem\n";
   $total   += 1;
}
echo "TOTAL DE FUNCIONÁRIOS;$total\n";

?>
