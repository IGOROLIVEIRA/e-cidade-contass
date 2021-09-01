<?
require ("conn.php");
require (__DIR__ . "/../../../libs/db_utils.php");
require ("libs/dataManager.php");

system("clear");
echo "selecionando registros...\n";

pg_query($DB_BASE,"begin") or die("erro begin origem");

//Objeto COPY
$objAluno            = new tableDataManager ( $DB_BASE, 'escola.aluno', null, true, 1);
$objAlunonecessidade = new tableDataManager ( $DB_BASE, 'escola.alunonecessidade', 'ed214_i_codigo', true, 1);

$result_seq   = pg_query("select nextval('aluno_ed47_i_codigo_seq') as seq_aluno");
$codigo_aluno = pg_result($result_seq,0,'seq_aluno')-1;


$dir = "censoescolamunicipal/";

// Abre um diretorio conhecido, e faz a leitura de seu conteudo
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while ( (($file = readdir($dh)) !== false)  ) {
           $extension = explode( ".", $file );
           if($file != "." && $file != ".." && $extension[1] == "TXT" ){
              $filename=$dir.$file;
              echo "$filename \n";
              insere_aluno( $filename );
           }
        }
        closedir($dh);
    }
}else{
   echo "\n\n  DiretÃ³rio invÃ¡lido \n\n ";
   exit;
}

//Persist
try {
   $objAluno->persist();
   $objAlunonecessidade->persist();
   echo "\n\n FIM \n\n ";
} catch(Exception $e) {
   echo("\n\n\n erro geral - " . $e->getMessage()."\n\n\n");
   exit;
}

$strSQL    = " select setval('aluno_ed47_i_codigo_seq', (select max(ed47_i_codigo) from aluno ) );"; 
$strSQL    = " select setval('alunonecessidade_ed214_i_codigo_seq', (select max(ed214_i_codigo) from alunonecessidade ) );"; 
pg_query( $DB_BASE, $strSQL ) or die ( "\n ERRO: $strSQL \n\n ".pg_errormessage() );
pg_query($DB_BASE, "commit");
 


function insere_aluno( $filename ){
   global $codigo_aluno, $objAluno, $objAlunonecessidade;

   $ponteiro     = fopen($filename,"r");
   $x=0;
   $intRegAnt = 0;
   while (!feof($ponteiro)){
      $linha = fgets($ponteiro,448);
      $x++;
     
      $tiporegistro=(trim(substr($linha,0,2)));

      //Registro 60
      if($tiporegistro==60){

	 $intRegAnt = $tiporegistro;
	 $codigo_aluno++;   	  

	 $ed47_c_codigoinep   = trim(substr($linha,20,12)); 
	 $ed47_v_nome         = trim(substr($linha,52,70)); 
	 $ed47_c_nis          = trim(substr($linha,152,11)); 
	 $ed47_d_nasc         = trim(substr($linha,163,8)); 
	 $ed47_d_nasc         = substr($ed47_d_nasc,4,4)."/".substr($ed47_d_nasc,2,2)."/".substr($ed47_d_nasc,0,2);
	 $ed47_v_sexo         = trim(substr($linha,171,1)); 
	 if($ed47_v_sexo==1){
	 	$ed47_v_sexo='M';
	 }else{
	 	$ed47_v_sexo='F';
	 }
	 $ed47_c_raca         = trim(substr($linha,172,1)); 
	 if($ed47_c_raca==0){
	 	$ed47_c_raca='NÃO DECLARADA';
	 }elseif($ed47_c_raca==1){
	 	$ed47_c_raca='BRANCA';
	 }elseif($ed47_c_raca==2){
	 	$ed47_c_raca='PRETA';
	 }elseif($ed47_c_raca==3){
	 	$ed47_c_raca='PARDA';
	 }elseif($ed47_c_raca==4){
	 	$ed47_c_raca='AMARELA';
	 }else{
	 	$ed47_c_raca='INDÍGENA';
	 }
	 $ed47_i_filiacao     = trim(substr($linha,173,1)); 
	 $ed47_v_mae          = trim(substr($linha,174,100)); 
	 $ed47_v_pai          = trim(substr($linha,274,100)); 
	 $ed47_i_nacion       = trim(substr($linha,374,1)); 
	 $ed47_i_pais         = trim(substr($linha,375,3)); 
	 $ed47_i_censoufnat   = trim(substr($linha,378,2)); 
	 $ed47_i_censomunicnat= trim(substr($linha,380,7)); 

	 $objAluno->ed47_i_codigo       = $codigo_aluno;
	 $objAluno->ed47_c_codigoinep   = $ed47_c_codigoinep    != ""?$ed47_c_codigoinep:"\N";
	 $objAluno->ed47_v_nome         = $ed47_v_nome          != ""?$ed47_v_nome:"\N";
	 $objAluno->ed47_c_raca         = $ed47_c_raca          != ""?$ed47_c_raca:"\N";
	 $objAluno->ed47_c_nis          = $ed47_c_nis           != ""?$ed47_c_nis:"\N"; 
	 $objAluno->ed47_d_nasc         = $ed47_d_nasc          != ""?$ed47_d_nasc:"\N";
	 $objAluno->ed47_i_nacion       = $ed47_i_nacion        != ""?$ed47_i_nacion:"\N";
	 $objAluno->ed47_v_mae          = $ed47_v_mae           != ""?$ed47_v_mae:"\N";
	 $objAluno->ed47_v_pai          = $ed47_v_pai           != ""?$ed47_v_pai:"\N";
	 $objAluno->ed47_v_sexo         = $ed47_v_sexo          != ""?$ed47_v_sexo:"\N";
	 $objAluno->ed47_i_pais         = $ed47_i_pais          != ""?$ed47_i_pais:"\N";
	 $objAluno->ed47_i_filiacao     = $ed47_i_filiacao      != ""?$ed47_i_filiacao:"\N";
	 $objAluno->ed47_i_censoufnat   = $ed47_i_censoufnat    != ""?$ed47_i_censoufnat:"\N";  
	 $objAluno->ed47_i_censomunicnat= $ed47_i_censomunicnat !=""?$ed47_i_censomunicnat:"\N"; 
      }

      //Registro 70
      if($tiporegistro==70){
	 $ed47_v_ident           =trim(substr($linha,52,20)); 
	 $ed47_v_identcompl      =trim(substr($linha,72,4)); 
	 $ed47_i_censoorgemissrg =trim(substr($linha,76,2)); 
	 $ed47_d_identdtexp      =trim(substr($linha,80,8));
	 if($ed47_d_identdtexp!=""){ 
	    $ed47_d_identdtexp      =substr($ed47_d_identdtexp,4,4)."/".substr($ed47_d_identdtexp,2,2)."/".substr($ed47_d_identdtexp,0,2);
	 }else{
	    $ed47_d_identdtexp="\N";
	 }

	 $ed47_c_certidaotipo    =trim(substr($linha,88,1));
	 if($ed47_c_certidaotipo==1){
	 	$ed47_c_certidaotipo='N';
	 }else{
	 	$ed47_c_certidaotipo='C';
	 }
	 $ed47_c_certidaonum     =trim(substr($linha,89,7)); 
	 $ed47_c_certidaofolha   =trim(substr($linha,97,4)); 
	 $ed47_c_certidaolivro   =trim(substr($linha,101,8));
	 $ed47_c_certidaodata    =trim(substr($linha,109,8)); 
	 if($ed47_c_certidaodata!=""){ 
	    $ed47_c_certidaodata    =substr($ed47_c_certidaodata,4,4)."/".substr($ed47_c_certidaodata,2,2)."/".substr($ed47_c_certidaodata,0,2);
	 }else{
	    $ed47_c_certidaodata="\N";
	 }
	 $ed47_c_certidaocart    =trim(substr($linha,117,100)); 
	 $ed47_i_censoufcert     =trim(substr($linha,217,2)); 
	 $ed47_v_cpf             =trim(substr($linha,219,11)); 
	 $ed47_c_passaporte      =trim(substr($linha,230,20)); 
	 $ed47_v_cep             =trim(substr($linha,250,8)); 
	 $ed47_v_ender           =trim(substr($linha,258,100)); 
	 $ed47_c_numero          =trim(substr($linha,358,10)); 
	 $ed47_v_compl           =trim(substr($linha,368,20)); 
	 $ed47_v_bairro          =trim(substr($linha,388,50)); 
	 $ed47_i_censoufend      =trim(substr($linha,438,2)); 
	 $ed47_i_censomunicend   =trim(substr($linha,440,7)); 

	 $objAluno->ed47_v_ident=           $ed47_v_ident              != ""?$ed47_v_ident:"\N"; 
	 $objAluno->ed47_v_identcompl=      $ed47_v_identcompl         != ""?$ed47_v_identcompl:"\N";  
	 $objAluno->ed47_i_censoorgemissrg= $ed47_i_censoorgemissrg    != ""?$ed47_i_censoorgemissrg:"\N";
	 $objAluno->ed47_d_identdtexp=      $ed47_d_identdtexp ; ///  != ""?$ed47_d_identdtexp:"\N";  
	 $objAluno->ed47_c_certidaotipo=    $ed47_c_certidaotipo       != ""?$ed47_c_certidaotipo:"\N";  
	 $objAluno->ed47_c_certidaonum=     $ed47_c_certidaonum        != ""?$ed47_c_certidaonum:"\N";  
	 $objAluno->ed47_c_certidaofolha=   $ed47_c_certidaofolha      != ""?$ed47_c_certidaofolha:"\N";  
	 $objAluno->ed47_c_certidaolivro=   $ed47_c_certidaolivro      != ""?$ed47_c_certidaolivro:"\N";    
	 $objAluno->ed47_c_certidaodata=    $ed47_c_certidaodata ;      //!= ""?$ed47_c_certidaodata:"\N";    
	 $objAluno->ed47_c_certidaocart=    $ed47_c_certidaocart       != ""?$ed47_c_certidaocart:"\N";  
	 $objAluno->ed47_i_censoufcert=     $ed47_i_censoufcert        != ""?$ed47_i_censoufcert:"\N";  
	 $objAluno->ed47_v_cpf=             $ed47_v_cpf                != ""?$ed47_v_cpf:"\N";  
	 $objAluno->ed47_c_passaporte=      $ed47_c_passaporte         != ""?$ed47_c_passaporte:"\N";  
	 $objAluno->ed47_v_cep=             $ed47_v_cep                != ""?$ed47_v_cep:"\N";  
	 $objAluno->ed47_v_ender=           $ed47_v_ender              != ""?$ed47_v_ender:"\N";  
	 $objAluno->ed47_c_numero=          $ed47_c_numero             != ""?$ed47_c_numero:"\N";  
	 $objAluno->ed47_v_compl=           $ed47_v_compl              != ""?$ed47_v_compl:"\N";  
	 $objAluno->ed47_v_bairro=          $ed47_v_bairro             != ""?$ed47_v_bairro:"\N"; 
	 $objAluno->ed47_i_censoufend=      $ed47_i_censoufend         != ""?$ed47_i_censoufend:"\N"; 
	 $objAluno->ed47_i_censomunicend=   $ed47_i_censomunicend      != ""?$ed47_i_censomunicend:"\N"; 
      }
      if($tiporegistro==80){
	 $ed47_c_atenddifer   =trim(substr($linha,85,1)); 
	 $ed47_i_transpublico =trim(substr($linha,86,1)); 
	 $ed47_c_transporte   =trim(substr($linha,87,1)); 
	 $ed47_c_zona         =trim(substr($linha,88,1)); 
	 $ed47_i_atendespec   =trim(substr($linha,89,1)); 
	 
	 $objAluno->ed47_c_atenddifer   = $ed47_c_atenddifer   != ""?$ed47_c_atenddifer:"\N";  
	 $objAluno->ed47_i_transpublico = $ed47_i_transpublico != ""?$ed47_i_transpublico:"\N"; 
	 $objAluno->ed47_c_transporte   = $ed47_c_transporte   != ""?$ed47_c_transporte:"\N"; 
	 $objAluno->ed47_c_zona         = $ed47_c_zona         != ""?$ed47_c_zona:"\N";  
	 $objAluno->ed47_i_atendespec   = $ed47_i_atendespec   != ""?$ed47_i_atendespec:"\N";

	 if( $intRegAnt == 60 ){
	     try {
		$objAluno->insertValue ();
	    }catch ( Exception $e ) {
		die($e->getMessage () . "\n\n");
	    }
	    $intRegAnt = 0;
	 }

       
	 if($ed47_i_atendespec==1){
	   $ed214_i_necessidade[] = trim(substr($linha,90,1))==1?101:0;
	   $ed214_i_necessidade[] = trim(substr($linha,91,1))==1?102:0;
	   $ed214_i_necessidade[] = trim(substr($linha,92,1))==1?103:0;
	   $ed214_i_necessidade[] = trim(substr($linha,93,1))==1?104:0;
	   $ed214_i_necessidade[] = trim(substr($linha,94,1))==1?105:0;
	   $ed214_i_necessidade[] = trim(substr($linha,95,1))==1?106:0;
	   $ed214_i_necessidade[] = trim(substr($linha,96,1))==1?107:0;
	   $ed214_i_necessidade[] = trim(substr($linha,97,1))==1?108:0;
	   $ed214_i_necessidade[] = trim(substr($linha,98,1))==1?109:0;
	   $ed214_i_necessidade[] = trim(substr($linha,99,1))==1?110:0;
	   $ed214_i_necessidade[] = trim(substr($linha,100,1))==1?111:0;
	   $ed214_i_necessidade[] = trim(substr($linha,101,1))==1?112:0;
	   $ed214_i_necessidade[] = trim(substr($linha,102,1))==1?113:0;

	  for($w=0;$w<13;$w++){

	    if( $ed214_i_necessidade[$w] > 0 ){ 
		 $objAlunonecessidade->ed214_i_codigo      = "\N";
		 $objAlunonecessidade->ed214_i_aluno       = $codigo_aluno;
		 $objAlunonecessidade->ed214_i_necessidade = $ed214_i_necessidade[$w];
		 $objAlunonecessidade->ed214_c_principal   = "NÃO";
		 $objAlunonecessidade->ed214_i_apoio       = 1;
		 $objAlunonecessidade->ed214_d_data        = "\N";
		 $objAlunonecessidade->ed214_i_tipo        = 1;
		 $objAlunonecessidade->ed214_i_escola      = "\N";
		 try {
		    $objAlunonecessidade->insertValue ();
		 }catch ( Exception $e ) {
		    die($e->getMessage () . "\n\n");    
		 }  
	    }
	  }  
	 }
	 unset($ed214_i_necessidade);           
    }
    
   }   
}

?>
