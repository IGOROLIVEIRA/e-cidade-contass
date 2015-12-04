<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_aguabase_classe.php");
include("classes/db_aguahidromatric_classe.php");
include("classes/db_aguahidrotroca_classe.php");
include("classes/db_agualeitura_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$claguabase = new cl_aguabase;
$claguahidromatric = new cl_aguahidromatric;
$claguahidrotroca = new cl_aguahidrotroca;
$clagualeitura = new cl_agualeitura;

$semhidro = false;

$result_hidrometro = $claguahidromatric->sql_record($claguahidromatric->sql_query_diametromarca(null,"x04_codhidrometro,x04_nrohidro,x04_qtddigito,x03_nomemarca,x15_diametro","","x04_matric = $matric"));
if($claguahidromatric->numrows == 0){
  $semhidro = true;
}else{
  db_fieldsmemory($result_hidrometro, 0);
  $result_troca = $claguahidrotroca->sql_record($claguahidrotroca->sql_query_file($x04_codhidrometro));
  if($claguahidrotroca->numrows > 0){
    $semhidro = true;
  }else{
    echo "
	  <script>
	    parent.document.form1.x21_codhidrometro.value  = '$x04_codhidrometro';
	    parent.document.form1.x04_nrohidro.value  = '$x04_nrohidro';
	    parent.document.form1.x04_qtddigito.value = '$x04_qtddigito';
      parent.document.getElementById('x21_leitura').setAttribute('maxlength', $x04_qtddigito);
	    parent.document.form1.x03_nomemarca.value = '$x03_nomemarca';
	    parent.document.form1.x15_diametro.value  = '$x15_diametro';
	  </script>
	 ";
    $result_leituraant = $clagualeitura->sql_record(
    $clagualeitura->sql_query_sitecgm(null,"x21_situacao,x17_descr,x21_numcgm,z01_nome,x21_dtleitura,x21_leitura,x21_consumo,x21_excesso,x21_exerc,x21_mes","x21_exerc desc, x21_mes desc, x21_codleitura desc limit 1","x21_codhidrometro=$x04_codhidrometro 
    and cast(x21_exerc::varchar||'-'||x21_mes::varchar||'-01' as date) 
     <= cast('{$exerc}-{$mes}-01' as date)"));
  
    if($clagualeitura->numrows > 0){
      db_fieldsmemory($result_leituraant,0);
      echo "
	    <script>
	      parent.document.form1.x21_situacant.value = '$x21_situacao';
	      parent.document.form1.x17_descrant.value  = '$x17_descr';
	      parent.document.form1.x21_numcgmant.value = '$x21_numcgm';
	      parent.document.form1.z01_nomeant.value   = '$z01_nome';

	      parent.document.form1.x21_dtleituraant_dia.value = '$x21_dtleitura_dia';
	      parent.document.form1.x21_dtleituraant_mes.value = '$x21_dtleitura_mes';
	      parent.document.form1.x21_dtleituraant_ano.value = '$x21_dtleitura_ano';
	      parent.document.form1.x21_dtleituraant.value = '$x21_dtleitura_dia'+'/'+'$x21_dtleitura_mes'+'/'+'$x21_dtleitura_ano';

	      parent.document.form1.x21_leituraant.value = '$x21_leitura';
	      parent.document.form1.x21_consumoant.value = '$x21_consumo';
	      parent.document.form1.x21_excessoant.value = '$x21_excesso';
              parent.document.form1.x21_exercant.value = '$x21_exerc';
              parent.document.form1.x21_mesant.value = '$x21_mes';
	    </script>
	   ";
    }
  }
}

if($semhidro == true){
  echo "
        <script>
	  alert('Matrícula sem hidrômetro cadastrado.');
	  parent.document.form1.x04_matric.value = '';
	  parent.js_pesquisax04_matric(false);
	  parent.document.form1.x04_matric.focus();
	</script>
       ";
}
?>
