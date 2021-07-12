<?
// select k00_numpre,k00_numpar,k00_receit from arrecad where k00_numpre = 11111454;

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_sql.php");
$mat_numpre = explode("#",base64_decode(@$HTTP_SERVER_VARS['QUERY_STRING']));
//echo $mat_numpre[0]."-";
//echo $mat_numpre[1]."-";  
//echo $mat_numpre[2];  
$tipo   = $mat_numpre[0];
$numpre = $mat_numpre[1];
$numpar = $mat_numpre[2];
$lista = true;
$gera = true;

$sql = "select k03_tipo 
        from arretipo
        where k00_tipo = $tipo";
$result = pg_exec($sql);
db_fieldsmemory($result,0);
if($k03_tipo==1 ){
  // iptu
  $sql = "select * 
          from arrematric
          where k00_numpre = $numpre";
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
     echo "Código de Arrecadacao nao cadastrado no arrematric."; 
     exit;
  }else{
     db_fieldsmemory($result,0,'1');
  }
  $sql = "select proprietario.* 
          from proprietario
          where j01_matric = $k00_matric";
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
     echo "Matrícula nao cadastrada em proprietario."; 
     exit;
  }else{
     db_fieldsmemory($result,0,'1');
  }
}else if($k03_tipo==7 ){
  // diversos
  $sql = "select diversos.*, z01_nome, k00_inscr,k00_matric , dv09_descr
          from diversos
	       left outer join arrematric on arrematric.k00_numpre = diversos.dv05_numpre
	       left outer join arreinscr  on arreinscr.k00_numpre = diversos.dv05_numpre
	       inner join procdiver       on procdiver.dv09_procdiver = diversos.dv05_procdiver
               inner join cgm on dv05_numcgm = z01_numcgm
          where diversos.dv05_numpre = $numpre";
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
     echo "Código de Arrecadacao nao cadastrado no diversos."; 
     exit;
  }else{
     db_fieldsmemory($result,0,'1');
  }
}else if($k03_tipo == 16 and 1==2){
  // parcelamento diversos
  $sql = "select parcdiver.* 
          from parcdiver
		       inner join cgm on numcgm = z01_numcgm
          where k00_numpre = $numpre";
	  echo $sql;
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
    echo "Parcelamento nao cadastrada no diversos."; 
    exit;
  }else{
    db_fieldsmemory($result,0,'1');
  }
}else if($k03_tipo==9 ||$k03_tipo==2 || $k03_tipo==3) {
  if($k03_tipo==3){
    // variavel
    $sql = "select * 
          from arreinscr
		       inner join arrecad on arrecad.k00_numpre = arreinscr.k00_numpre
			   inner join issvar on arrecad.k00_numpre = issvar.q05_numpre and arrecad.k00_numpar = issvar.q05_numpar
          where arreinscr.k00_numpre = $numpre";
  }else{
    $sql = "select * 
          from arreinscr
		       inner join arrecad on arrecad.k00_numpre = arreinscr.k00_numpre
			   inner join isscalc on arrecad.k00_numpre = isscalc.q01_numpre 
          where arreinscr.k00_numpre = $numpre";
  }

  $sql .= ($numpar>0?" and arrecad.k00_numpar=$numpar":"");
  
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
     echo "Código de Arrecadacao nao cadastrado no arreinscr."; 
     exit;
  }else{
     db_fieldsmemory($result,0,'1');
  }
  $sql = "select empresa.* 
          from empresa
          where q02_inscr = $k00_inscr";
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
     echo "Empresa nao cadastrada no issbase."; 
     exit;
  }else{
     db_fieldsmemory($result,0,'1');
  }


}else if($k03_tipo==4){

  $sql = "select * 
          from arrematric
          where k00_numpre = $numpre";
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
     echo "Código de Arrecadacao nao cadastrado no arrematric."; 
     exit;
  }else{
     db_fieldsmemory($result,0,'1');
  }
  $sql = "select proprietario.* 
          from proprietario
          where j01_matric = $k00_matric";
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
     echo "Matrícula nao cadastrada em proprietario."; 
     exit;
  }else{
     db_fieldsmemory($result,0,'1');
  }
  $sql  = " select edital.d01_numero,contrib.d07_data,contrib.d07_contri,contrib.d07_valor,contr.j14_nome";
  $sql .= " from arrematric";
  $sql .= "      left join contricalc on d09_numpre = k00_numpre \n";   
  $sql .= "      left join contrib on d07_contri = d09_contri and d07_matric = d09_matric \n";   
  $sql .= "      left join editalrua on d07_contri = d02_contri \n";   
  $sql .= "      left join ruas  contr on d02_codigo = contr.j14_codigo \n";   
  $sql .= "      left join edital on d02_codedi = d01_codedi \n";   
  $sql .= " where k00_numpre = $numpre";
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
     echo "Código de Arrecadacao nao cadastrado Na Constribuição.  "; 
     exit;
  }else{
     db_fieldsmemory($result,0,'1');
  }
    
}else if($k03_tipo==5){
   $sql = "select  d.*,p.*,c.z01_nome, m.k00_matric as v01_matric, i.k00_inscr as v01_inscr
           from divida d
		        left outer join cgm       c on c.z01_numcgm = d.v01_numcgm
				left outer join proced    p on d.v01_proced = p.v03_codigo
				left outer join arrematric m on m.k00_numpre = d.v01_numpre
				left outer join arreinscr  i on i.k00_numpre = d.v01_numpre
		   where d.v01_numpre = $numpre";
  if($numpar!=0)
     $sql .= " and d.v01_numpar = $numpar ";
  
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
     echo "Código de Arrecadacao nao cadastrado."; 
     exit;
  }else{
     db_fieldsmemory($result,0,'1');
  }
}else if($k03_tipo==6 or $k03_tipo==17 or $k03_tipo==13 or $k03_tipo==30 or $k03_tipo == 16){
  $v01_proced="&nbsp;" ;
  $k00_matric="&nbsp;" ;
  $k00_inscr="&nbsp;" ;
  $v01_exerc="&nbsp;" ;
  $v03_descr="&nbsp;" ;
  $certid   ="&nbsp;" ;
  // parcelamento divida ativa
  $sql  = "select t.*,c.z01_nome as nome_resp, c.z01_nome
           from termo t
		        left outer join cgm c on c.z01_numcgm = t.v07_numcgm
		   where t.v07_numpre = $numpre";
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
     echo "Código de Arrecadacao nao cadastrado."; 
     exit;
  }else{
     db_fieldsmemory($result,0,true);
     $sql = "select distinct d.v01_proced,d.v01_exerc,k00_matric,k00_inscr, z01_nome, v03_descr
             from termodiv t
			      inner join divida d on d.v01_coddiv = t.coddiv
			      left outer join proced     p on p.v03_codigo = d.v01_proced
			      left outer join cgm        c on d.v01_numcgm = c.z01_numcgm
                  left outer join arrematric a on d.v01_numpre = a.k00_numpre
	              left outer join arreinscr  i on d.v01_numpre = i.k00_numpre
		     where t.parcel = $v07_parcel";
     if($numpar!=0)
        $sql .= " and d.v01_numpar = $numpar ";
        $result = pg_exec($sql);
	 if(pg_numrows($result)>0){
           db_fieldsmemory($result,0,true);
	 }else{

//	     $z01_nome = "Não existe dados de referencia no termodiv.";

  	   $sql = "select * from termoini where parcel = $v07_parcel";
           $result = pg_exec($sql);
	   if(pg_numrows($result)>0){
	     $v07_hist = "Inicia" . (pg_numrows($result) == 1?"l":"is") . ":";
	     for ($termoini=0; $termoini < pg_numrows($result); $termoini++) {
	       db_fieldsmemory($result, $termoini);
	       $v07_hist .= $inicial . ($termoini == pg_numrows($result) - 1?"":",");
	     }
	   } else {

	     $sql  = "select k00_matric as j01_matric, k00_inscr as q02_inscr from termo
				left outer join arrematric on v07_numpre = arrematric.k00_numpre
				  left outer join arreinscr  on v07_numpre = arreinscr.k00_numpre
			     where v07_numpre = $numpre";
	     $result = pg_exec($sql);
	     if(pg_numrows($result)>0){
	       db_fieldsmemory($result,0,true);
	     } else {
	       $v01_proced="&nbsp;" ;
	       $k00_matric="&nbsp;" ;
	       $k00_inscr="&nbsp;" ;
	       $v01_exerc="&nbsp;" ;
	       $v03_descr="&nbsp;" ;
	     }
	   }
	 }
  }
}else if($k03_tipo==19){
  // certidao foro
  $sql  = "select ce.*,d.v01_obs
           from divida d
		        inner join certdiv c on c.v14_coddiv = d.v01_coddiv
		        inner join certid ce on ce.v13_certid = c.v14_certid
		   where d.v01_numpre = $numpre limit 1";
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
     echo "Código de Arrecadacao nao cadastrado."; 
     exit;
  }else{
     db_fieldsmemory($result,0,true);
  }
}else if($k03_tipo==13){
// inicial
   $sql  = "select k00_matric as j01_matric, k00_inscr as q02_inscr from termo
			left outer join arrematric on v07_numpre = arrematric.k00_numpre
			left outer join arreinscr  on v07_numpre = arreinscr.k00_numpre
		   where v07_numpre = $numpre";
   $result = pg_exec($sql);
   if(pg_numrows($result)>0){
     db_fieldsmemory($result,0,true);
   } else {
     $v01_proced="&nbsp;" ;
     $k00_matric="&nbsp;" ;
     $k00_inscr="&nbsp;" ;
     $v01_exerc="&nbsp;" ;
     $v03_descr="&nbsp;" ;
   }
  $sql  = "select t.*,c.z01_nome as nome_resp
           from termo t
		        left outer join cgm c on c.z01_numcgm = t.v07_numcgm
		   where t.v07_numpre = $numpre";
  $result = pg_exec($sql);
  db_fieldsmemory($result,0,true);
}
?>
<html>
<head>
<title>Documento sem t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
<!--
td {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 12px;
}
-->
</style>
<script>
  function js_AbreJanelaRelatorio() { 
    window.open('div2_termoparc_002.php?parcel='+document.form1.v07_parcel.value,'','width=790,height=530,scrollbars=1,location=0');
   }
</script>
</head>
<!--body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onBlur="window.focus()"-->
<body bgcolor=#CCCCCC bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<center>
<?
if($k03_tipo==1){
?>
  <table width="103%" height="201">
    <tr> 
      <td height="36" align="center" bgcolor="#CCCCCC"><strong>IPTU - 
        <?=$j01_tipoimp?>
        </strong></td>
    </tr>
    <tr> 
      <td bgcolor="#CCCCCC"> <table width="97%" border="1" cellspacing="0" bgcolor="#999999">
          <tr> 
            <td width="35%" align="right">Matr&iacute;cula:</td>
            <td width="65%">&nbsp; 
              <?=$j01_matric?>
            </td>
          </tr>
          <tr> 
            <td align="right">Propriet&aacute;rio/Promitente:</td>
            <td>&nbsp; 
              <?=substr($z01_nome,0,35)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Endere&ccedil;o:</td>
            <td> &nbsp; 
              <?=substr($z01_ender,0,35)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Munic&iacute;pio:</td>
            <td> &nbsp; 
              <?=substr($z01_munic,0,35)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Propriet&aacute;rio:</td>
            <td>&nbsp; 
              <?=substr($proprietario,0,35)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Setor/Quadra/Lote:</td>
            <td>&nbsp; 
              <?=($j34_setor."/".$j34_quadra."/".$j34_lote)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Logradouro:</td>
            <td>&nbsp; 
              <?=substr($nomepri,0,35)?>
            </td>
          </tr>
          <tr> 
            <td align="right">N&uacute;mero:</td>
            <td>&nbsp; 
              <?=$j39_numero?>
            </td>
          </tr>
          <tr> 
            <td align="right">Complemeto:</td>
            <td> &nbsp; 
              <?=$j39_compl?>
            </td>
          </tr>
          <tr> 
            <td align="right">Bairro:</td>
            <td> &nbsp; 
              <?=$j13_descr?>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
<?
}else if($k03_tipo==4){
?>
  <table width="103%" height="201">
    <tr> 
      <td height="36" align="center" bgcolor="#CCCCCC"><strong><?=($k03_tipo==4?"":"Parcelamento de ")?> Contribui&ccedil;&atilde;o Melhoria</strong></td>
    </tr>
    <tr> 
      <td bgcolor="#CCCCCC"> <table width="97%" border="1" cellspacing="0" bgcolor="#999999">
          <tr> 
            <td width="35%" align="right">Matr&iacute;cula:</td>
            <td width="65%">&nbsp; 
              <?=$j01_matric?>
            </td>
          </tr>
          <tr> 
            <td align="right">Propriet&aacute;rio/Promitente:</td>
            <td>&nbsp; 
              <?=substr($z01_nome,0,35)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Endere&ccedil;o:</td>
            <td> &nbsp; 
              <?=substr($z01_ender,0,35)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Munic&iacute;pio:</td>
            <td> &nbsp; 
              <?=substr($z01_munic,0,35)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Propriet&aacute;rio:</td>
            <td>&nbsp; 
              <?=substr($proprietario,0,35)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Setor/Quadra/Lote:</td>
            <td>&nbsp; 
              <?=($j34_setor."/".$j34_quadra."/".$j34_lote)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Logradouro:</td>
            <td>&nbsp; 
              <?=substr($nomepri,0,35)?>
            </td>
          </tr>
          <tr> 
            <td align="right">N&uacute;mero:</td>
            <td>&nbsp; 
              <?=$j39_numero?>
            </td>
          </tr>
          <tr> 
            <td align="right">Complemeto:</td>
            <td> &nbsp; 
              <?=$j39_compl?>
            </td>
          </tr>
          <tr> 
            <td align="right">Bairro:</td>
            <td> &nbsp; 
              <?=$j13_descr?>
            </td>
          </tr>
          <tr> 
            <td align="right">Contribui&ccedil;&atilde;o:</td>
            <td>&nbsp; 
              <?=$d07_contri?>&nbsp;Edital:
              <?=$d01_numero?>
            </td>
          </tr>
          <tr>
            <td align="right">Rua/Avenida:</td>
            <td> &nbsp; 
              <?=substr($j14_nome,0,35)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Data Lan&ccedil;amento:</td>
            <td>&nbsp; 
              <?=$d07_data?>
            </td>
          </tr>
          <tr> 
            <td align="right">Valor Lan&ccedil;ado:</td>
            <td>&nbsp; 
              <?=$d07_valor?>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
<?
}else if($k03_tipo==5){
?>
  <table width="103%" height="294">
    <tr> 
      <td height="18" align="center" bgcolor="#CCCCCC"><strong style="font-size:14px">Divida 
        Ativa</strong></td>
    </tr>
    <tr> 
      <td bgcolor="#CCCCCC"> <table width="97%" border="1" cellspacing="0" bgcolor="#999999">
          <tr> 
            <td width="35%" align="right">Codigo D&iacute;vida:</td>
            <td width="65%">&nbsp; 
              <?=$v01_coddiv?>
            </td>
          </tr>
          <tr> 
            <td align="right">Nome:</td>
            <td>&nbsp; 
              <?=substr($z01_nome,0,35)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Data inscri&ccedil;&atilde;o:</td>
            <td>&nbsp; 
              <?=$v01_dtinsc?>
            </td>
          </tr>
          <tr> 
            <td align="right">Exerc&iacute;cio:</td>
            <td>&nbsp; 
              <?=$v01_exerc?>
            </td>
          </tr>
          <tr>
            <td align="right">Proced&ecirc;ncia:</td>
            <td>
              <?=$v01_proced."-".$v03_descr?>
            </td>
          </tr>
          <tr> 
            <td align="right" nowrap>Matr&iacute;cula Im&oacute;vel:</td>
            <td> 
              <?
			if(pg_numrows($result)!=0){
			  for($i=0;$i<pg_numrows($result);$i++){
			    db_fieldsmemory($result,$i,'1');
			    if($v01_matric!=""){
				   echo $v01_matric." - ";
				}
			  }
			}
			?>
            </td>
          </tr>
          <tr> 
            <td align="right">Inscri&ccedil;&atilde;o Alvar&aacute;:</td>
            <td> &nbsp; 
              <?
			if(pg_numrows($result)!=0){
			  for($i=0;$i<pg_numrows($result);$i++){
			    db_fieldsmemory($result,$i,'1');
			    if($v01_inscr!=""){
				   echo $v01_inscr."<br>";
				}
			  }
			}
			?>
            </td>
          </tr>
          <tr> 
            <td align="right">Livro/Folha:</td>
            <td>&nbsp; 
              <?=$v01_livro."/".$v01_folha?>
            </td>
          </tr>
          <tr> 
            <td align="right">Valor Hist&oacute;rico:</td>
            <td>&nbsp; 
              <?=$v01_vlrhis?>
            </td>
          </tr>
          <tr> 
            <td align="right">Data Vencimento:</td>
            <td>&nbsp; 
              <?=$v01_dtvenc?>
            </td>
          </tr>
          <tr> 
            <td align="right">Data Valor:</td>
            <td>&nbsp; 
              <?=$v01_dtoper?>
            </td>
          </tr>
          <tr> 
            <td align="right" valign="top">Observa&ccedil;&atilde;o:</td>
            <td valign="top"> &nbsp; 
              <?
			  echo substr($v01_obs,0,50)."<br>";
			  echo substr($v01_obs,50,50)."<br>";
			  echo substr($v01_obs,100,17);
			  ?>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
  <?
}else if($k03_tipo==7 ){
?>
  <table width="100%">
    <tr> 
      <td align="center"><strong style="font-size:14px">Módulo Diversos</strong></td>
    </tr>
    <tr> 
      <td>
	     <table width="100%" border="1" cellspacing="0" bgcolor="#999999">
          <tr> 
            <td width="42%" align="right">C&oacute;digo Diverso:</td>
            <td width="58%">&nbsp; 
              <?=$dv05_coddiver?>
            </td>
          </tr>
          <tr> 
            <td align="right">Data Inclus&atilde;o:</td>
            <td>&nbsp; 
              <?=$dv05_dtinsc?>
            </td>
          </tr>
          <tr> 
            <td align="right">Vencimento:</td>
            <td>&nbsp; 
              <?=$dv05_privenc?>
            </td>
          </tr>
          <tr> 
            <td align="right">Valor Lan&ccedil;ado:</td>
            <td>&nbsp; 
              <?=$dv05_vlrhis?>
            </td>
          </tr>
          <tr> 
            <td align="right">Proced&ecirc;ncia:</td>
            <td>&nbsp; 
              <?=$dv05_procdiver.'-'.$dv09_descr?>
            </td>
          </tr>
          <tr> 
            <td align="right">Contribu&iacute;nte:</td>
            <td>&nbsp; 
              <?=$z01_nome?>
            </td>
          </tr>
          <tr> 
            <td align="right">C&oacute;digo Arrecada&ccedil;&atilde;o:</td>
            <td> &nbsp; 
              <?=$dv05_numpre?>
            </td>
          </tr>
          <tr> 
            <td align="right">Hist&oacute;rico:</td>
            <td> &nbsp; 
              <?=$dv05_obs?>
            </td>
          </tr>
          <tr> 
            <td align="right">Matr&iacute;cula Im&oacute;vel:</td>
            <td> &nbsp;
              <?
	      if($k00_matric!=""){
	        echo $k00_matric;
	      }
	      ?>
            </td>
          </tr>
          <tr> 
            <td align="right">Inscri&ccedil;&atilde;o Alvar&aacute;:</td>
            <td> &nbsp; 
              <?
	      if($k00_inscr!=""){
	        echo $k00_inscr;
	      }
	      ?>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
  <?
}else if($k03_tipo == 16){
  $sql = "select * 
          from termodiver
		       inner join termo on v07_parcel = dv10_parcel
		       inner join cgm on v07_numcgm = z01_numcgm
		       inner join arrecad on k00_numpre = v07_numpre
                       left outer join arrematric a on v07_numpre = a.k00_numpre
	               left outer join arreinscr  i on v07_numpre = i.k00_numpre
          where v07_numpre = $numpre";
  $result = pg_exec($sql);
  if(pg_numrows($result)==0){
    echo "Parcelamento não cadastrado no diversos."; 
    exit;
  }else{
    db_fieldsmemory($result,0,'1');
  }
?>
  <table width="100%">
    <tr> 
      <td align="center"><strong style="font-size:14px">Parcelamento Módulo Diversos</strong></td>
    </tr>
    <tr> 
      <td>
	     <table width="100%" border="1" cellspacing="0" bgcolor="#999999">
          <tr> 
            <td width="42%" align="right">C&oacute;digo do Parcelamento:</td>
            <td width="58%">&nbsp; 
              <?=$dv10_parcel?>
            </td>
          </tr>
          <tr> 
            <td align="right">Data Parcelamento:</td>
            <td>&nbsp; 
              <?=$v07_dtlanc?>
            </td>
          </tr>
          <tr> 
            <td align="right">Total Parcelas:</td>
            <td>&nbsp; 
              <?=$v07_totpar?>
            </td>
          </tr>
          <tr> 
            <td align="right">Valor Total Parcelado:</td>
            <td>&nbsp; 
              <?=($k00_valor * $v07_totpar)?>
            </td>
          </tr>
          <tr> 
            <td align="right">Valor Entrada:</td>
            <td>&nbsp; 
              <?=$v07_vlrent?>
            </td>
          </tr>
          <tr> 
            <td align="right">Data Primeira parcela:</td>
            <td>&nbsp; 
              <?=$v07_datpri?>
            </td>
          </tr>
          <tr> 
<script>
  function js_AbreJanelaRelatorio() { 
    window.open('div2_termoparc_002.php?parcel='+document.form1.v07_parcel.value,'','width=790,height=530,scrollbars=1,location=0');
   }
</script>
            <td align="right">Termo:</td>
			<form name="form1" method="post">
            <td> 
			<input type="button" name="Submit3" value="Visualizar o Termo" onclick="js_AbreJanelaRelatorio();"> 
			<input type="hidden" name="v07_parcel" value="<?=$v07_parcel?>"> 
            </td>
			</form>
          </tr>
          <tr> 
            <td align="right">Contribu&iacute;nte:</td>
            <td>&nbsp; 
              <?=$z01_nome?>
            </td>
          </tr>
          <tr> 
            <td align="right">Nome Respons&aacute;vel:</td>
            <td>&nbsp; 
              <?=$z01_nome?>
            </td>
          </tr>
          <tr> 
            <td align="right">C&oacute;digo Arrecada&ccedil;&atilde;o:</td>
            <td> &nbsp; 
              <?=$k00_numpre?>
            </td>
          </tr>
          <tr> 
            <td align="right">Matr&iacute;cula Im&oacute;vel:</td>
            <td> &nbsp; 
              <?
			    if(@$k00_matric!=""){
				   echo $k00_matric;
				}
			?>
            </td>
          </tr>
          <tr> 
            <td align="right">Inscri&ccedil;&atilde;o Alvar&aacute;:</td>
            <td> &nbsp; 
              <?
			    if(@$k00_inscr!=""){
				   echo $k00_inscr;
				}
			?>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
  <?
}else if($k03_tipo==6 or $k03_tipo == 17 or $k03_tipo == 13 or $k03_tipo == 30){
?>
  <table width="100%">
    <tr> 
      <td align="center"><strong style="font-size:14px">Parcelamento</strong></td>
    </tr>
    <tr> 
      <td><table width="100%" border="1" cellspacing="0" bgcolor="#999999">
          <tr> 
            <td width="42%" align="right">C&oacute;digo do Parcelamento:</td>
            <td width="58%">&nbsp; 
              <?=$v07_parcel?>
            </td>
          </tr>
          <tr> 
            <td align="right">Data Parcelamento:</td>
            <td>&nbsp; 
              <?=$v07_dtlanc?>
            </td>
          </tr>
          <tr> 
            <td align="right">Total Parcelas:</td>
            <td>&nbsp; 
              <?=$v07_totpar?>
            </td>
          </tr>
          <tr> 
            <td align="right">Valor Total Parcelado:</td>
            <td>&nbsp; 
              <?=$v07_valor?>
            </td>
          </tr>
          <tr> 
            <td align="right">Valor Entrada:</td>
            <td>&nbsp; 
              <?=$v07_vlrent?>
            </td>
          </tr>
          <tr> 
            <td align="right">Data Primeira parcela:</td>
            <td>&nbsp; 
              <?=$v07_datpri?>
            </td>
          </tr>
          <tr> 
            <td align="right">Contribu&iacute;nte:</td>
            <td>&nbsp; 
              <?=$z01_nome?>
            </td>
          </tr>
          <tr> 
            <td align="right">Nome Respons&aacute;vel:</td>
            <td>&nbsp; 
              <?=$nome_resp?>
            </td>
          </tr>
          <tr> 
            <td align="right">Termo:</td>
			<form name="form1" method="post">
            <td> 
			<input type="button" name="Submit3" value="Visualizar o Termo" onclick="js_AbreJanelaRelatorio();"> 
			<input type="hidden" name="v07_parcel" value="<?=$v07_parcel?>"> 
            </td>
			</form>
          </tr>
          <tr> 
            <td align="right">C&oacute;digo Arrecada&ccedil;&atilde;o:</td>
            <td> &nbsp; 
              <?=$v07_numpre?>
            </td>
          </tr>
          <tr> 
            <td align="right">Hist&oacute;rico:</td>
            <td> &nbsp; 
              <?=$v07_hist?>
            </td>
          </tr>
          <tr> 
            <td align="right">Matr&iacute;cula Im&oacute;vel:</td>
            <td> 
              <?
			if(pg_numrows($result)!=0){
			  for($i=0;$i<pg_numrows($result);$i++){
			    db_fieldsmemory($result,$i,'1');
			    if ($k03_tipo == 13) {
			       echo $certid."<br>";
			    } else {
			      if($k00_matric!=""){
				     echo $k00_matric." - ".$v01_exerc." - ".$v01_proced." - ".$v03_descr."<br>";
			      }
			    }
			  }
			}
			?>
            </td>
          </tr>
          <tr> 
            <td align="right">Inscri&ccedil;&atilde;o Alvar&aacute;:</td>
            <td> &nbsp; 
              <?
			if(pg_numrows($result)!=0){
			  for($i=0;$i<pg_numrows($result);$i++){
			    db_fieldsmemory($result,$i,'1');
			    if($k00_inscr!=""){
				   echo $k00_inscr."-".$v01_exerc."-".$v01_proced."<br>";
				}
			  }
			}
			?>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
  <?
}else if($k03_tipo==2 || $k03_tipo==9){
?>
  <table width="100%">
    <tr> 
      <td><table width="100%" border="1" cellspacing="0" bgcolor="#999999">
          <tr> 
            <td bgcolor="" colspan="2" align="center"><strong><?=($tipo==2?"Issqn Fixo":"Alvará")?></strong></td>
          </tr>
          <tr> 
            <td width="40%" align="right">Inscri&ccedil;&atilde;o:</td>
            <td width="60%"> &nbsp; 
              <?=$k00_inscr?>
            </td>
          </tr>
          <tr> 
            <td align="right">Data In&iacute;cio:</td>
            <td> &nbsp; 
              <?=$q02_dtinic?>
            </td>
          </tr>
          <tr> 
            <td align="right">Nome/Empresa:</td>
            <td>&nbsp; 
              <?=$z01_nome?>
            </td>
          </tr>
          <tr> 
            <td align="right">C&oacute;digo Arrecada&ccedil;&atilde;o:</td>
            <td> &nbsp; 
              <?=$k00_numpre?>
            </td>
          </tr>
          <tr> 
            <td align="right" valign="top">Valor Lan&ccedil;ado:</td>
            <td>&nbsp; 
              <?=$q01_valor?>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
  <?
}else if($k03_tipo==3){
?>
  <table width="100%">
    <tr> 
      <td><table width="100%" border="1" cellspacing="0" bgcolor="#999999">
          <tr> 
            <td bgcolor="" colspan="2" align="center"><strong>Issqn Vari&aacute;vel</strong></td>
          </tr>
          <tr> 
            <td width="40%" align="right">Inscri&ccedil;&atilde;o:</td>
            <td width="60%"> &nbsp; 
              <?=$k00_inscr?>
            </td>
          </tr>
          <tr> 
            <td align="right">Data In&iacute;cio:</td>
            <td> &nbsp; 
              <?=$q02_dtinic?>
            </td>
          </tr>
          <tr> 
            <td align="right">Nome/Empresa:</td>
            <td>&nbsp; 
              <?=$z01_nome?>
            </td>
          </tr>
          <tr> 
            <td align="right">C&oacute;digo Arrecada&ccedil;&atilde;o:</td>
            <td> &nbsp; 
              <?=$k00_numpre?>
            </td>
          </tr>
          <tr> 
            <td align="right" valign="top">Al&iacute;quota:</td>
            <td>&nbsp; 
              <?=$q05_aliq?>%
            </td>
          </tr>
          <tr> 
            <td align="right" valign="top">Compet&ecirc;ncia:</td>
            <td>&nbsp; 
              <?=$q05_ano." - ".$q05_mes?>
            </td>
          </tr>
          <tr> 
            <td align="right" valign="top">Observa&ccedil;&atilde;o:</td>
            <td>&nbsp; 
              <?=$q05_histor?>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
<?
}else if($k03_tipo==15){
  // certidao do foro
?>
  <table width="100%">
    <tr> 
      <td><table width="100%" border="1" cellspacing="0" bgcolor="#999999">
          <tr> 
            <td width="40%" align="right">C&oacute;digo da Certid&atilde;o:</td>
            <td width="60%"> &nbsp; 
              <?=$v13_certid?>
            </td>
          </tr>
          <tr> 
            <td align="right">Data Emiss&atilde;o:</td>
            <td> &nbsp; 
              <?=$v13_dtemis?>
            </td>
          </tr>
          <tr> 
            <td align="right">Certid&atilde;o:</td>
            <td> <input type="submit" name="Submit3" value="Visualizar a Certid&atilde;o"> 
            </td>
          </tr>
          <tr> 
            <td align="right">C&oacute;digo Arrecada&ccedil;&atilde;o:</td>
            <td> &nbsp; 
              <?=$numpre?>
            </td>
          </tr>
          <tr> 
            <td align="right" valign="top">Observa&ccedil;&atilde;o:</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
<?
}

if($numpar>0){
  
  include('classes/db_arrevenc_classe.php');
  $clarrevenc = new cl_arrevenc;
  $result = $clarrevenc->sql_record($clarrevenc->sql_query("","k00_dtini,k00_dtfim,((case when k00_dtfim is null then current_date else k00_dtfim end )+1)-k00_dtini as dia","k00_dtini"," k00_numpre = $numpre and k00_numpar = $numpar"));
  if($result!=false && $clarrevenc->numrows > 0 ){
    ?>
    <table width="100%" border="1" cellspacing="0" bgcolor="#999999">
    <tr>
    <td bgcolor="#CCCCCC" align="center" colspan="3" style="font-size:14px"><strong> Prorrogações de Vencimentos Efetuadas</strong></td>
    </tr>
    <tr>
    <td> Data Inicial</td>
    <td> Data Final</td>
    <td> Dias</td>
    </tr>
    <?
    for($i=0;$i<$clarrevenc->numrows;$i++){
      db_fieldsmemory($result,$i,true);
      echo "<tr>";
      echo "<td>$k00_dtini</td>";
      echo "<td>".($k00_dtfim==""?"Hoje":$k00_dtfim)."</td>";
      echo "<td>$dia</td>";
      echo "<tr>";
    }
    ?>
    </table>
    <?
  }
}

include('classes/db_arrehist_classe.php');
$clarrehist = new cl_arrehist;
$result = $clarrehist->sql_record($clarrehist->sql_query(null,"*","k00_dtoper"," k00_numpre = $numpre ".($numpar>0?"and k00_numpar = $numpar":"")));
if($result!=false && $clarrehist->numrows > 0 ){
  ?>
  <table width="100%" border="1" cellspacing="0" bgcolor="#999999">
  <tr>
  <td bgcolor="#CCCCCC" align="center" colspan="5" style="font-size:14px"><strong> Lançamentos Descontos/Isenções</strong></td>
  </tr>
  <tr>
  <td> Histórico</td>
  <td> Data Lançamento</td>
  <td> Usuário</td>
  <td> Hora</td>
  <td> Histórico</td>
  </tr>
  <?
  for($i=0;$i<$clarrevenc->numrows;$i++){
    db_fieldsmemory($result,$i,true);
    echo "<tr>";
    echo "<td>$k01_descr</td>";
    echo "<td>$k00_dtoper</td>";
    echo "<td>$k00_hora</td>";
    echo "<td>$nome</td>";
    echo "<td>$k00_histtxt</td>";
    echo "<tr>";
  }
  ?>
  </table>
  <?
}


?>
<table width="100%" border="1" cellspacing="0" bgcolor="#999999">
<tr>
<td bgcolor="#CCCCCC" align="center" colspan="3" style="font-size:14px"><strong> Lançamentos Efetuados</strong></td>
</tr>
</table> 
<iframe width=590 src="cai3_gerfinanc555.php?numpre=<?=$numpre?>&numpar=<?=$numpar?>"></iframe>
</center>
</body>
</html>
