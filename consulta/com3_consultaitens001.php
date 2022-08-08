<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_solicita_classe.php");
include("classes/db_solicitatipo_classe.php");
include("classes/db_solicitem_classe.php");
include("classes/db_solicitempcmater_classe.php");
include("classes/db_solicitemunid_classe.php");
include("classes/db_pcorcam_classe.php");
include("classes/db_pcorcamitem_classe.php");
include("classes/db_pcorcamitemsol_classe.php");
include("classes/db_pcorcamitemproc_classe.php");
include("classes/db_pcorcamval_classe.php");
include("classes/db_pcorcamjulg_classe.php");
include("classes/db_pcdotac_classe.php");
include("classes/db_pcproc_classe.php");
include("classes/db_pcprocitem_classe.php");

$clsolicita         = new cl_solicita;
$clsolicitatipo     = new cl_solicitatipo;
$clsolicitem        = new cl_solicitem;
$clsolicitempcmater = new cl_solicitempcmater;
$clsolicitemunid    = new cl_solicitemunid;
$clpcorcam          = new cl_pcorcam;
$clpcorcamitem      = new cl_pcorcamitem;
$clpcorcamitemsol   = new cl_pcorcamitemsol;
$clpcorcamitemproc  = new cl_pcorcamitemproc;
$clpcorcamval       = new cl_pcorcamval;
$clpcorcamjulg      = new cl_pcorcamjulg;
$clpcdotac          = new cl_pcdotac;
$clpcproc           = new cl_pcproc;
$clpcprocitem       = new cl_pcprocitem;
$clrotulo = new rotulocampo;
$clsolicita->rotulo->label();
$clsolicitatipo->rotulo->label();
$clsolicitem->rotulo->label();
$clsolicitempcmater->rotulo->label();
$clsolicitemunid->rotulo->label();

db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc" onload="">
<center>
<form name="form1" method="post" action="com3_conssolic002.php">
<?
  if(isset($solicitacao)){
    if($solicitacao=="1"){
      $result_itensdotac = $clsolicitem->sql_record(
      $clsolicitem->sql_query_rel(null,"pc11_codigo,
                                        pc11_seq,
                                        pc11_quant,
                                        pc11_vlrun,
                                        pc11_prazo,
                                        pc11_resum,
                                        pc11_just,
                                        pc11_liberado,
                                        pc17_codigo,
                                        pc17_quant,
					m61_descr,
					m61_usaquant,
					pc01_codmater,
					pc01_descrmater,
					pc05_servico,
					o56_elemento,
					o56_descr",
                                       "pc11_codigo,
                                        pc01_descrmater",
                                       "pc11_numero=$numero")
                                       );
      $numrows_itensdotac = $clsolicitem->numrows;
      echo "<table border='0'>\n";
      echo "  <tr>\n";
      echo "    <td align='left' colspan='4'><h3><strong>Itens/dotações</strong></h3></td>\n";
      echo "  </tr>\n";
      for($i=0;$i<$numrows_itensdotac;$i++){
        db_fieldsmemory($result_itensdotac,$i);
	echo "  <tr>\n";
        echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Código do item:</td>\n";
        echo "    <td colspan='1' width='25%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc11_codigo</strong></font></td>\n";
        echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Sequencial:</td>\n";
        echo "    <td colspan='1' width='25%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc11_seq</strong></font></td>\n";
	echo "  </tr>\n";
	echo "  <tr>\n";
        echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Quantidade:</td>\n";
        echo "    <td colspan='1' width='25%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc11_quant</strong></font></td>\n";
        echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Valor Unitário:</td>\n";
        echo "    <td colspan='1' width='25%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>".db_formatar($pc11_vlrun,"v")."</strong></font></td>\n";
	echo "  </tr>\n";
        if(isset($pc01_codmater) && trim($pc01_codmater)!=""){
	  echo "  <tr>\n";
	  echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Código material:</td>\n";
	  echo "    <td colspan='1' width='25%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc01_codmater</strong></font></td>\n";
	  echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Descrição:</td>\n";
	  echo "    <td colspan='1' width='25%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc01_descrmater</strong></font></td>\n";
	  echo "  </tr>\n";
	  echo "  <tr>\n";
	  echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Sub. Elemento:</td>\n";
	  echo "    <td colspan='3' width='75%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>".db_formatar($o56_elemento,"elemento")."</strong></font></td>\n";
	  echo "  </tr>\n";
	  echo "  <tr>\n";
	  echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Descrição:</td>\n";
	  echo "    <td colspan='3' width='25%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$o56_descr</strong></font></td>\n";
	  echo "  </tr>\n";
	  if(isset($pc17_codigo) && trim($pc17_codigo)!=""){
	    if($m61_usaquant=='t'){
	      $m61_descr .= " ($pc17_quant UNIDADES)";
	    }
	    echo "  <tr>\n";
	    echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Referência:</td>\n";
	    echo "    <td colspan='3' width='75%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$m61_descr</strong></font></td>\n";
	    echo "  </tr>\n";
	  }else if($pc05_servico=='t'){
	    echo "  <tr>\n";
	    echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Referência:</td>\n";
	    echo "    <td colspan='3' width='75%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>SERVIÇO</strong></font></td>\n";
	    echo "  </tr>\n";
	  }
        }
        if(isset($pc11_resum) && trim($pc11_resum)!=""){
	  echo "  <tr>\n";
	  echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Resumo:</td>\n";
	  echo "    <td colspan='3' width='75%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc11_resum</strong></font></td>\n";
	  echo "  </tr>\n";
        }
        if(isset($pc11_prazo) && trim($pc11_prazo)!=""){
	  echo "  <tr>\n";
	  echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Prazo entrega:</td>\n";
	  echo "    <td colspan='3' width='75%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc11_prazo</strong></font></td>\n";
	  echo "  </tr>\n";
        }
        if(isset($pc11_just) && trim($pc11_just)!=""){
	  echo "  <tr>\n";
	  echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Justificativa:</td>\n";
	  echo "    <td colspan='3' width='75%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc11_just</strong></font></td>\n";
	  echo "  </tr>\n";
        }
        if(isset($pc11_pgto) && trim($pc11_pgto)!=""){
	  echo "  <tr>\n";
	  echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Cond. Pagamento:</td>\n";
	  echo "    <td colspan='3' width='75%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc11_pgto</strong></font></td>\n";
	  echo "  </tr>\n";
        }
        $result_dotacoes = $clpcdotac->sql_record($clpcdotac->sql_query_file($pc11_codigo,db_getsession("DB_anousu"),null,"pc13_coddot"));
        if($clpcdotac->numrows>0){
	  echo "  <tr>\n";
	  echo "    <td colspan='4' width='75%' align='center'  bgcolor='#CCCCCC'>";db_ancora("Clique aqui para ver dotações do item $pc11_codigo","js_verdotac($pc11_codigo,$pc01_codmater,$numero)",1);echo"</td>\n";
	  echo "  </tr>\n";
        }
        if(($i+1)!=$numrows_itensdotac){
	  echo "  <tr>\n";
	  echo "    <td colspan='4' width='75%' align='left'  bgcolor='#CCCCCC'>&nbsp;</td>\n";
	  echo "  </tr>\n";
	  echo "  <tr>\n";
	  echo "    <td colspan='4' width='75%' align='left'  bgcolor='#CCCCCC'>&nbsp;</td>\n";
	  echo "  </tr>\n";
        }
      }
      echo "</table>\n";
    }else if($solicitacao=="2" || $solicitacao=="4"){
      if($solicitacao=="2"){
        $result_orcamsol = $clpcorcam->sql_record($clpcorcam->sql_query_gercons(null,"pcorcam.pc20_codorc,pcorcam.pc20_dtate,pcorcam.pc20_hrate,pc22_orcamitem,z01_numcgm,z01_nome,pc23_valor,pc23_quant,pc01_descrmater,pc24_pontuacao,pc17_quant,pc17_codigo,m61_descr,m61_usaquant,pc05_servico","pc20_codorc,pc21_orcamforne,pc22_orcamitem","pc11_numero=$numero"));
      }else if($solicitacao=="4"){
        $result_orcamsol = $clpcorcam->sql_record($clpcorcam->sql_query_gerconspc(null,"pcorcam.pc20_codorc,pcorcam.pc20_dtate,pcorcam.pc20_hrate,pc22_orcamitem,z01_numcgm,z01_nome,pc23_valor,pc23_quant,pc01_descrmater,pc24_pontuacao,pc17_quant,pc17_codigo,m61_descr,m61_usaquant,pc05_servico","pc20_codorc,pc21_orcamforne,pc22_orcamitem","pc11_numero=$numero"));
      }
      $numrows_orcamsol= $clpcorcam->numrows;
      if($numrows_orcamsol>0){
	echo "<table border='0'>\n";
	echo "  <tr>\n";
	echo "    <td align='left' colspan='4'><h3><strong>Orçamento da solicitação</strong></h3></td>\n";
	echo "  </tr>\n";
	$antigorcam = "";
	$antigoforn = "";
	$julgar     = false;
	for($i=0;$i<$numrows_orcamsol;$i++){
	  db_fieldsmemory($result_orcamsol,$i);
	    if($antigorcam!=$pc20_codorc){
	      if(($i+1)!=$numrows_orcamsol && $i!=0){
		echo "  <tr>\n";
		echo "    <td colspan='4' width='75%' align='left'  bgcolor='#CCCCCC'>&nbsp;</td>\n";
		echo "  </tr>\n";
		echo "  <tr>\n";
		echo "    <td colspan='4' width='75%' align='left'  bgcolor='#CCCCCC'>&nbsp;</td>\n";
		echo "  </tr>\n";
	      }
	      echo "  <tr>\n";
	      echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Orçamento:</td>\n";
	      echo "    <td colspan='1' width='25%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc20_codorc</strong></font></td>\n";
	      echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Data/Hora entrega:</td>\n";
	      echo "    <td colspan='1' width='25%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>".db_formatar($pc20_dtate,"d")." - $pc20_hrate</strong></font></td>\n";
	      echo "  </tr>\n";
	      echo "  <tr>\n";
	      echo "    <td colspan='4' width='75%' align='left'  bgcolor='#CCCCCC'>&nbsp;</td>\n";
	      echo "  </tr>\n";
	      echo "  <tr>\n";
	      echo "    <td align='left' colspan='4'><h4><strong>Fornecedores do orçamento</strong></h4></td>\n";
	      echo "  </tr>\n";
	      $antigorcam = $pc20_codorc;
	    }
	    if($z01_numcgm!=$antigoforn){
	      if($i==0){
	      echo "  <tr>\n";
	      echo "    <td colspan='1' width='25%' align='left' bgcolor='#CCCCCC'><strong>CGM</strong></td>\n";
	      echo "    <td colspan='3' width='75%' align='left' bgcolor='#CCCCCC'><strong>Fornecedor</strong></td>\n";
	      echo "  </tr>\n";
	      }
	      echo "  <tr>\n";
	      echo "    <td colspan='1' width='25%' align='left' bgcolor='#FFFFFF'><font color='#333333'><strong>$z01_numcgm</strong></font></td>\n";
	      echo "    <td colspan='3' width='75%' align='left' bgcolor='#FFFFFF'><font color='#333333'><strong>$z01_nome</strong></font></td>\n";
	      echo "  </tr>\n";
	      $antigoforn = $z01_numcgm;
	    }
	    if($julgar==false && trim($pc24_pontuacao)!=""){
	      $julgar = true;
	    }
	}
	if($julgar==true){
	  echo "  <tr>\n";
	  echo "    <td align='left' colspan='4'>&nbsp;</td>\n";
	  echo "  </tr>\n";
	  echo "  <tr>\n";
	  echo "    <td align='left' colspan='4'><h4><strong>Julgar orçamento</strong></h4></td>\n";
	  echo "  </tr>\n";
	  for($i=0;$i<$numrows_orcamsol;$i++){
	    db_fieldsmemory($result_orcamsol,$i);
	    if($pc24_pontuacao==1){
	      echo "  <tr>\n";
	      echo "    <td colspan='4' width='100%' align='left' bgcolor='#DEB887'>Item no orçamento:<font color='#333333'><strong>$pc22_orcamitem - $pc01_descrmater</strong></font></td>\n";
	      echo "  </tr>\n";
	      if(trim($pc17_codigo)!=""){
		echo "  <tr>\n";
		echo "    <td colspan='4' width='100%' align='left' bgcolor='#DEB887'>
		            Referência:
		            <font color='#333333'>
			      <strong>
			        $m61_descr";
		if($m61_usaquant=="t"){
		  echo "        ($pc17_quant UNIDADES)";
		}
		echo "
			      </strong>
			    </font>
			  </td>\n";
		echo "  </tr>\n";
	      }else if(isset($pc05_servico)){
		echo "  <tr>\n";
		echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Referência:</td>\n";
		echo "    <td colspan='3' width='75%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>SERVIÇO</strong></font></td>\n";
		echo "  </tr>\n";
	      }
	      echo "  <tr>\n";
	      echo "    <td colspan='4' width='100%' align='left' bgcolor='#CCCCCC'>Fornecedor: <font color='#333333'><strong>$z01_numcgm - $z01_nome</strong></font></td>\n";
	      echo "  </tr>\n";
	      echo "  <tr>\n";
	      echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Qtd. Lançada:</td>\n";
	      echo "    <td colspan='1' width='25%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc23_quant</strong></font></td>\n";
	      echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Vlr. Lançado:</td>\n";
	      echo "    <td colspan='1' width='25%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>".db_formatar($pc23_valor,"v")."</strong></font></td>\n";
	      echo "  </tr>\n";
	      echo "  <tr>\n";
	      echo "    <td colspan='4' width='100%' align='left' bgcolor='#CCCCCC'>&nbsp;</td>\n";
	      echo "  </tr>\n";
	    }
	  }
	}else{
	  echo "  <tr>\n";
	  echo "    <td align='center' colspan='4' bgcolor='#CCCCCC'><BR><font color='#333333'><strong>Nenhum item lançado no 'Lançar valores'.</strong></font></td>\n";
	  echo "  </tr>\n";
	}
	echo "</table>\n";
      }else{
	echo "<table border='0'>\n";
	echo "  <tr>\n";
        if($solicitacao=="2"){
	  echo "    <td align='center'><h3><strong>Não existe orçamento para esta solicitação.</strong></h3></td>\n";
	}else if($solicitacao=="4"){
	  echo "    <td align='center'><h3><strong>Não existe orçamento para processo de compras desta solicitação.</strong></h3></td>\n";
	}
	echo "  </tr>\n";
	echo "</table>\n";
      }
    }else if($solicitacao=="3" || $solicitacao=="5"){
      $result_processos = $clpcprocitem->sql_record($clpcprocitem->sql_query_pcmater(null,"pc80_codproc,pc80_data,id_usuario,nome,pc80_resumo,pc11_codigo,pc11_seq,pc81_codprocitem,pc01_codmater,pc01_descrmater,o56_elemento,o56_descr,pc11_resum,pc17_quant,pc17_codigo,m61_descr,m61_usaquant,pc05_servico,e54_autori,e60_numemp,e60_anousu,e60_codemp,e54_anulad","pc80_codproc,pc11_codigo","pc10_numero=$numero"));
      $numrows_processos = $clpcprocitem->numrows;
      if($solicitacao=="3"){
	if($numrows_processos>0){
	  echo "<table border='0'>\n";
	  echo "  <tr>\n";
	  echo "    <td align='left' colspan='4'><h3><strong>Processos de compras</strong></h3></td>\n";
	  echo "  </tr>\n";
	  $pc80_codproc_ant = "";
	  for($i=0;$i<$numrows_processos;$i++){
	    db_fieldsmemory($result_processos,$i);
	    if($pc80_codproc!=$pc80_codproc_ant){
	      echo "  <tr>\n";
	      echo "    <td colspan='1' width='15%' align='right' bgcolor='#CCCCCC'>Número PC:</td>\n";
	      echo "    <td colspan='1' width='15%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc80_codproc</strong></font></td>\n";
	      echo "    <td colspan='1' width='15%' align='right' bgcolor='#CCCCCC'>Data:</td>\n";
	      echo "    <td colspan='1' width='55%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>".db_formatar($pc80_data,"d")."</strong></font></td>\n";
	      echo "  </tr>\n";
	      echo "  <tr>\n";
	      echo "    <td colspan='1' width='15%' align='right' bgcolor='#CCCCCC'>Usuário:</td>\n";
	      echo "    <td colspan='1' width='15%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$id_usuario</strong></font></td>\n";
	      echo "    <td colspan='1' width='15%' align='right' bgcolor='#CCCCCC'>Nome:</td>\n";
	      echo "    <td colspan='1' width='55%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$nome</strong></font></td>\n";
	      echo "  </tr>\n";
	      echo "  <tr>\n";
	      echo "    <td colspan='1' width='15%' align='right' bgcolor='#CCCCCC'>Resumo:</td>\n";
	      echo "    <td colspan='3' width='85%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc80_resumo</strong></font></td>\n";
	      echo "  </tr>\n";
	      echo "  <tr>\n";
	      echo "    <td align='left' colspan='4'>&nbsp;</td>\n";
	      echo "  </tr>\n";
	      echo "  <tr>\n";
	      echo "    <td align='left' colspan='4'><h3><strong>Itens do processo de compras N&ordm; $pc80_codproc</strong></h3></td>\n";
	      echo "  </tr>\n";
	      $pc80_codproc_ant = $pc80_codproc;
	    }
	    echo "  <tr>\n";
	    echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Item sol.:</td>\n";
	    echo "    <td colspan='1' width='25%' align='left'  bgcolor='#DEB887'><font color='#333333'><strong>$pc11_codigo</strong></font></td>\n";
	    echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Sequencial sol.:</td>\n";
	    echo "    <td colspan='1' width='25%' align='left'  bgcolor='#DEB887'><font color='#333333'><strong>$pc11_seq</strong></font></td>\n";
	    echo "  </tr>\n";
	    echo "  <tr>\n";
	    echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Item proc.:</td>\n";
	    echo "    <td colspan='1' width='25%' align='left'  bgcolor='#DEB887'><font color='#333333'><strong>$pc81_codprocitem</strong></font></td>\n";
	    echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Autorização:</td>\n";
	    if(trim($e54_autori)!="" && trim($e54_anulad)==""){
	      echo "    <td colspan='1' width='25%' align='left'  bgcolor='#DEB887'><font color='#333333'><strong>$e54_autori</strong></font></td>\n";
	    }else{
	      echo "    <td colspan='1' width='25%' align='left'  bgcolor='#DEB887'><font color='#333333'><strong>Não gerada</strong></font></td>\n";
	    }
	    echo "  </tr>\n";
	    echo "  <tr>\n";
	    echo "    <td colspan='1' width='15%' align='right' bgcolor='#CCCCCC'>Material:</td>\n";
	    echo "    <td colspan='1' width='15%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc01_codmater</strong></font></td>\n";
	    echo "    <td colspan='1' width='15%' align='right' bgcolor='#CCCCCC'>Descrição:</td>\n";
	    echo "    <td colspan='1' width='55%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$pc01_descrmater</strong></font></td>\n";
	    echo "  </tr>\n";
	    echo "  <tr>\n";
	    echo "    <td colspan='1' width='15%' align='left' bgcolor='#CCCCCC'>Sub-elemento:</td>";
	    echo "    <td colspan='3' width='85%' align='left'  bgcolor='#FFFFFF'>
			<font color='#333333'><strong>".db_formatar($o56_elemento,"elemento")." -
			<font color='#333333'><strong>$o56_descr</strong></font>
		      </td>\n";
	    echo "  </tr>\n";
	    if(trim($pc17_codigo)!=""){
	      echo "  <tr>\n";
	      echo "    <td colspan='1' width='15%' align='right' bgcolor='#CCCCCC'>Referência:</td>";
	      echo "    <td colspan='3' width='85%' align='left'  bgcolor='#FFFFFF'>";
	      echo "      <font color='#333333'>
			    <strong>
			      $m61_descr";
	      if($m61_usaquant=="t"){
		echo "        ($pc17_quant UNIDADES)";
	      }
	      echo "
			    </strong>
			  </font>
			</td>\n";
	      echo "  </tr>\n";
	    }else if(isset($pc05_servico)){
	      echo "  <tr>\n";
	      echo "    <td colspan='1' width='25%' align='right' bgcolor='#CCCCCC'>Referência:</td>\n";
	      echo "    <td colspan='3' width='75%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>SERVIÇO</strong></font></td>\n";
	      echo "  </tr>\n";
	    }
	    echo "  <tr>\n";
	    echo "    <td colspan='1' width='15%' align='right' bgcolor='#CCCCCC'>Usuário:</td>\n";
	    echo "    <td colspan='1' width='15%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$id_usuario</strong></font></td>\n";
	    echo "    <td colspan='1' width='15%' align='right' bgcolor='#CCCCCC'>Nome:</td>\n";
	    echo "    <td colspan='1' width='55%' align='left'  bgcolor='#FFFFFF'><font color='#333333'><strong>$nome</strong></font></td>\n";
	    echo "  </tr>\n";
	    if(($i+1)!=$numrows_processos){
	      echo "  <tr>\n";
	      echo "    <td colspan='4' width='100%' align='right' bgcolor='#CCCCCC'>&nbsp;</td>\n";
	      echo "  </tr>\n";
	    }
	  }
	  echo "</table>\n";
	}else{
	  echo "<table border='0' >\n";
	  echo "  <tr>\n";
	  echo "    <td align='center'><h3><strong>Não existe processo de compras para esta solicitação.</strong></h3></td>\n";
	  echo "  </tr>\n";
	  echo "</table>\n";
	}
      }else if($solicitacao=="5"){
	$countaut = 0;
	$arr_aut  = Array();
	if($numrows_processos>0){
	  echo "<table border='0' >\n";
	  for($i=0;$i<$numrows_processos;$i++){
	    db_fieldsmemory($result_processos,$i);
	    if(trim($e54_autori)!=""){
	      $countaut++;
	      if($countaut==1){
		echo "  <tr>\n";
		echo "    <td align='left' colspan='4'><h3><strong>Autorizações de empenho</strong></h3></td>\n";
		echo "  </tr>\n";
		echo "  <tr>\n";
		echo "  <tr>\n";
		echo "    <td colspan='2' width='50%' align='center' bgcolor='#DEB887'><strong>Autorizações</strong></td>\n";
		echo "    <td colspan='2' width='50%' align='center' bgcolor='#DEB887'><strong>Empenhadas</strong></td>\n";
		echo "  </tr>\n";
	      }
	      if(!in_array($e54_autori."_".$e60_numemp,$arr_aut)){
		$arr_aut[$e54_autori."_".$e60_numemp] = $e54_autori."_".$e60_numemp;
		echo "  <tr>\n";
		if(trim($e54_anulad)==""){
		  echo "    <td colspan='2' width='50%' align='center' bgcolor='#FFFFFF'><font color='#333333'><strong>";db_ancora("$e54_autori","js_pesquisaaut($e54_autori);",1);echo"</strong></font></td>\n";
		}else{
		  echo "    <td colspan='2' width='50%' align='center' bgcolor='#FFFFFF'><font color='#333333'><strong>$e54_autori (anulada)</strong></font></td>\n";
		}
		if(trim($e60_numemp)!=""){
		  echo "    <td colspan='2' width='50%' align='center' bgcolor='#FFFFFF'><font color='#333333'><strong>";db_ancora("$e60_codemp/$e60_anousu","js_pesquisaemp($e60_numemp);",1);echo"</strong></font></td>\n";
		}else{
		  echo "    <td colspan='2' width='50%' align='center' bgcolor='#FFFFFF'><font color='#333333'><strong>Não empenhada</strong></font></td>\n";
		}
		echo "  </tr>\n";
	      }
	    }
	  }
	  if($countaut==0){
	    echo "  <tr>\n";
	    echo "    <td align='center'><h3><strong>Não existe autorização de empenho para processos de compras desta solicitação.</strong></h3></td>\n";
	    echo "  </tr>\n";
	  }
	  echo "</table>\n";
	}else{
	  echo "<table border='0' >\n";
	  echo "  <tr>\n";
	  echo "    <td align='center'><h3><strong>Não existe autorização de empenho para processos de compras desta solicitação.</strong></h3></td>\n";
	  echo "  </tr>\n";
	  echo "</table>\n";
	}
      }
    }
  }
?>
</form>
</center>
<script>
function js_verdotac(codigo,mater,numero){
  qry  = "";
  qry += "pc13_codigo="+codigo;
  qry += "&pc16_codmater="+mater;
  qry += "&numero="+numero;
  qry += "&consulta=consulta";
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_dotac','com1_seldotac001.php?'+qry,'Dotações do item '+codigo,true);
}
function js_pesquisaaut(autorizacao){
  js_JanelaAutomatica('empautoriza',autorizacao);
}
function js_pesquisaemp(empenho){
  js_OpenJanelaIframe('CurrentWindow.corpo','iframeautoriza','func_empempenho001.php?e60_numemp='+empenho,'Empenho '+empenho,true);
}
</script>
</body>
</html>
