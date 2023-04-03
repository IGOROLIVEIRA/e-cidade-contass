<?
require ("conn.php");
require (__DIR__ . "/../../../libs/db_utils.php");
require ("libs/dataManager.php");

echo "selecionando registros...\n";

//pg_query($connOrigem,"begin") or die("erro begin origem");

//Objeto COPY
$x=0;
$objAluno            = new tableDataManager ( $connOrigem, 'escola.aluno', null, true, 1);
$objAlunonecessidade = new tableDataManager ( $connOrigem, 'escola.alunonecessidade', null, true, 1);

$objAluno->ed47_v_nome = "xxxx3x";

$objAluno->insertValue();
$objAluno->persist();

die( $objAluno->ed47_v_nome );

$ponteiro = fopen("censoescolamunicipal/950576_43_4304408_43035620.TXT","r");

while (!feof($ponteiro)) {
   $linha = fgets($ponteiro,448);
   $x++;
   $tiporegistro=(trim(substr($linha,0,2)));

   if($tiporegistro==60){
      if(trim(substr($linha,20,12))!=""){
	 $objAluno->ed47_c_codigoinep = "xxxxxxxx"; //trim(substr($linha,20,12));
	 die( $objAluno->ed47_c_codigoinep.">>>".trim(substr($linha,20,12)) );
      }
   }
}
echo "\n";
?>
