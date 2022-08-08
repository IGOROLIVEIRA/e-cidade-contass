<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_arretipo_classe.php");
include("classes/db_arrecad_classe.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
db_postmemory($HTTP_POST_VARS);
$cliframe_seleciona = new cl_iframe_seleciona;
$clarretipo = new cl_arretipo;
$clarrecad = new cl_arrecad;
$clarrecad->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("k00_tipo");
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script>


function js_habilita(){
  if(document.form1.tipor.value==0 || document.form1.tipdes.value==0){
    document.form1.pesquisa.disabled=true;
  }else{
    document.form1.pesquisa.disabled=false;
  }
}
function js_passainfo(valor){
  document.form1.controle.value=valor;
  document.form1.submit();
}
/*
function js_abre(){
  if(document.form1.tipor.value==0 || document.form1.tipdes.value==0){
    alert("Informe corretamente o tipo origem e o tipo destino.");
  }else{
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe','div4_importadivida033.php?k00_tipo_or='+document.form1.tipor.value+'&k00_tipo_des='+document.form1.tipdes.value+'&txt_where='+document.form1.where.value+'&txt_inner='+document.form1.inner.value,'Pesquisa',true);
    jan.moveTo(0,0);
  }
}
*/
function js_submit_form(){
  js_gera_chaves();
  document.form1.submit();
}
</script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
      <td width="360" height="18">&nbsp;</td>
      <td width="263">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>
<center>
<form name="form1" method="post">

<table border='0'>
<tr height="20px">
<td ></td>
<td ></td>
</tr>
  <tr>
    <td  align="left" nowrap title="<?=$Tk00_tipo?>"><b>Tipo de origem:</b></td>
    <td align="left" nowrap>
      <select name="tipor" id="tipor" onchange='js_habilita();js_passainfo(this.value);' >

      <?
         $inner_arrecad = "";
         $inner_tipo = "";
         $inner = "";
         $where = "";
	 $tab = " arretipo ";
         if (isset($z01_numcgm)&&$z01_numcgm!=""){
	   $inner_arrecad = " inner join arrecad on arrecad.k00_numpre = arrenumcgm.k00_numpre";
	   $inner_tipo = " inner join arretipo on arretipo.k00_tipo = arrecad.k00_tipo ";
	   $inner = " inner join arrenumcgm on arrenumcgm.k00_numpre = arrecad.k00_numpre ";
	   $where = " and arrenumcgm.k00_numcgm = $z01_numcgm ";
	   $tab = " arrenumcgm  ";
	 }else if (isset($j01_matric)&&$j01_matric!=""){
	   $inner_arrecad = " inner join arrecad on arrecad.k00_numpre = arrematric.k00_numpre";
	   $inner_tipo = " inner join arretipo on arretipo.k00_tipo = arrecad.k00_tipo ";
           $inner = " inner join arrematric on arrematric.k00_numpre = arrecad.k00_numpre ";
	   $where = " and arrematric.k00_matric = $j01_matric ";
	   $tab = " arrematric  ";
	 }else if (isset($q02_inscr)&&$q02_inscr!=""){
	   $inner_arrecad = " inner join arrecad on arrecad.k00_numpre = arreinscr.k00_numpre";
	   $inner_tipo = " inner join arretipo on arretipo.k00_tipo = arrecad.k00_tipo ";
           $inner = " inner join arreinscr on arreinscr.k00_numpre = arrecad.k00_numpre ";
	   $where = " and arreinscr.k00_inscr = $q02_inscr ";
	   $tab = " arreinscr  ";
	 }
	 $campos = " distinct arretipo.k00_tipo,k00_descr ";
         $sql = "select $campos
	         from $tab
			$inner_arrecad
			$inner_tipo
                        inner join cadtipo on cadtipo.k03_tipo = arretipo.k03_tipo
                 where cadtipo.k03_parcano is true $where
		 order by arretipo.k00_tipo";
         $result = $clarretipo->sql_record($sql);
         $numrows=$clarretipo->numrows;
         if ($numrows==0){
            db_msgbox('Não existem debitos a serem importados');
            echo "<script>location.href='div4_importadivida011.php'</script>";
         }
         $entra=false;
	 if ($numrows>1){
           echo "<option value=\"0\" >Escolha origem</option>\n";
	 }else{
	   $entra=true;
	 }
	 for($i=0;$i<$numrows;$i++){
	   db_fieldsmemory($result,$i,true);
	   if ($entra==true){
	     $controle=$k00_tipo;
	   }
	   //for para colocar os selects
	     echo "<option value=\"$k00_tipo\" >$k00_descr</option>\n";
	 }
      ?>
      </select>
    </td>
  </tr>
<?
if (isset($tipor)&&$tipor!=""){
echo "<script>document.form1.tipor.value=$tipor;</script>";
}
?>
  <tr>
    <td  align="left" nowrap title="Tipo de destino para novos dados que serao gerados"><b>Tipo de destino:</b></td>
    <td align="left" nowrap>
      <select name="tipdes" id="tipdes" onchange='js_habilita();' >
        <option value="0" >Escolha destino</option>
      <?
         $sql1 = "select distinct arretipo.k00_tipo,
	                 k00_descr
	          from arretipo
	          where k03_tipo = 5";
         $result1 = $clarretipo->sql_record($sql1);
         $numrows1=$clarretipo->numrows;
	 for($i=0;$i<$numrows1;$i++){
	   db_fieldsmemory($result1,$i,true);
	   //for para colocar os selects
	     echo "
	             <option value=\"$k00_tipo\" >$k00_descr</option>";
	 }

      ?>
      </select>
    </td>
  </tr>
      <?
      db_input('controle',10,'',true,'hidden',3);
      ?>
  <tr>
    <td colspan=2>
    <?
    if (isset($where)&&$where!=""&&isset($controle)&&$controle!=""){
         $campos = " distinct arrecad.k00_numpre,arrecad.k00_numpar,arrecad.k00_receit,k02_descr,arrecad.k00_dtvenc ";
         $sql_numpres = "select $campos
	         from $tab
			$inner_arrecad
			$inner_tipo
                        inner join cadtipo on cadtipo.k03_tipo = arretipo.k03_tipo
			inner join tabrec on tabrec.k02_codigo = arrecad.k00_receit
                 where cadtipo.k03_parcano is true and arrecad.k00_tipo=$controle $where
		 order by arrecad.k00_numpre,arrecad.k00_numpar";
           $cliframe_seleciona->campos  = "k00_numpre,k00_numpar,k00_receit,k02_descr,k00_dtvenc";
           $cliframe_seleciona->legenda="Numpre's";
           $cliframe_seleciona->sql=$sql_numpres;
          // $cliframe_seleciona->sql_marca=$sql_marca;
           $cliframe_seleciona->iframe_height ="300";
           $cliframe_seleciona->iframe_width ="500";
           $cliframe_seleciona->iframe_nome ="numpres";
           $cliframe_seleciona->chaves = "k00_numpre,k00_numpar,k00_receit";
           $cliframe_seleciona->iframe_seleciona(1);
    }

    ?>
    </td>
  </tr>
  <tr height="20px">
  <td ></td>
  <td ></td>
  </tr>
  <tr>
  <td colspan="2" align="center">
    <!--<input name="pesquisa" type="button" onclick='js_abre();' disabled  value="Pesquisa">-->
    <input name="pesquisa" type="button"  disabled  value="Pesquisa" onclick="js_submit_form();">
  </td>
  </tr>
  </table>
  <?
         db_input('z01_numcgm',10,'',true,'hidden',3);
         db_input('j01_matric',10,'',true,'hidden',3);
         db_input('q02_inscr',10,'',true,'hidden',3);
         db_input('inner',10,'',true,'hidden',3);
         db_input('where',10,'',true,'hidden',3);
  ?>
  </form>
</center>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>

//js_OpenJanelaIframe('CurrentWindow.corpo','db_iframevar','div4_importadivida055.php','Pesquisa',false);

function js_mandadados(tipor,tipdes,inner){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe','div4_importadivida033.php?k00_tipo_or='+tipor+'&k00_tipo_des='+tipdes+'&txt_inner='+inner,'Pesquisa',true);
    //js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe','div4_importadivida033.php?k00_tipo_or='+tipor+'&k00_tipo_des='+tipdes+'&txt_where='+where+'&txt_inner='+inner,'Pesquisa',true);
    jan.moveTo(0,0);
}

function js_criaobj(val){
    document.form1.where.value = val;
}

</script>
<?
if (isset($tipor)&&isset($tipdes)&&isset($inner)&&isset($where)&&isset($chaves)){
  $numpre = "";
  $numpar = "";
  $receita = "";
  $or = "and";
  $info=split('#',$chaves);
  for($w=0;$w<count($info);$w++){
    $dados=split('-',$info[$w]);
    $numpre = $dados[0];
    $numpar = $dados[1];
    $receita = $dados[2];
    $where .= " $or (arrecad.k00_numpre=$numpre and arrecad.k00_numpar=$numpar and arrecad.k00_receit=$receita)";
  //  echo "<script>js_criaobj(\"or_$w\",\"$where\",false);</script>";
    $or = "or";
  }
  echo "<script>js_criaobj(\"$where\");</script>";
  echo "<script>js_mandadados($tipor,$tipdes,\"$inner\");</script>";
}
?>
