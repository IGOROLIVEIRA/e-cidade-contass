<?
# DADOS DA ORIGEM:
#
# ID_Aluno                       5       5
# Nome                          50      55
# Sexo                           1      56
# DataNasc (ddmmaaaa)            8      64
# Identidade                    10      74
# Naturalidade                  30     104
# Nacionalidade                 30     134
# Religião                      25     159
# Endereço                      35     194
# Número                         5     199
# Complemento                   15     214
# Bairro                        25     239
# Cidade                        25     264
# UF                             2     266
# Telefone                      15     281
# Nome do Pai                   50     331
# Nome da mãe                   50     381
# Profissão do pai              30     411
# Profissão da mãe              30     441
# Empresa do pai                40     481
# Endereço profis.do pai        35     516
# Empresa da mãe                40     556
# Endereço profis.da mãe        35     591
# Data do cadastro    (ddmmaaaa) 8     599
# Observações                  250     849
#
# Total                        849

set_time_limit(0);
$host="127.0.0.1";
$base="sapiranga";
$user="postgres";
$pass="";
$port="5432";
if(!($conn = pg_connect("host=$host dbname=$base port=$port user=$user password=$pass"))) {
 echo "Erro ao conectar...\n\n";
 exit;
}else{
 echo "conectado...\n\n";
}

function TiraAcento($string){
 set_time_limit(240);
 $acentos = 'áéíóúÁÉÍÓÚàÀÂâÊêôÔüÜïÏöÖñÑãÃõÕçÇªºäÄ\'';
 $letras  = 'AEIOUAEIOUAAAAEEOOUUIIOONNAAOOCCAOAA ';
 $new_string = '';
 for($x=0; $x<strlen($string); $x++){
  $let = substr($string, $x, 1);
  for($y=0; $y<strlen($acentos); $y++){
   if($let==substr($acentos, $y, 1)){
    $let=substr($letras, $y, 1);
    break;
   }
  }
  $new_string = $new_string . $let;
 }
 return $new_string;
}

system("clear");
$ponteiro = fopen("alunos.txt","r");
$x=0;
$erro = false;
pg_exec("begin");
while (!feof($ponteiro)) {
 $linha = fgets($ponteiro,851);
 $x++;
 $ID_Aluno       = substr($linha,0,5);
 $Nome           = str_replace(chr(39),"",substr($linha,5,50));
 $Sexo           = substr($linha,55,1);
 $DataNasc       = substr($linha,56,8);
 $Identidade     = str_replace(chr(39),"",substr($linha,64,10));

 $Naturalidade   = str_replace(chr(39),"",substr($linha,74,30));
 $Nacionalidade  = str_replace(chr(39),"",substr($linha,104,30));
 $Religiao       = str_replace(chr(39),"",substr($linha,134,25));
 $Endereco       = str_replace(chr(39),"",substr($linha,159,35));
 $Numero         = str_replace(chr(39),"",substr($linha,194,5));;
 $Complemento    = str_replace(chr(39),"",substr($linha,199,15));
 $Bairro         = str_replace(chr(39),"",substr($linha,214,25));
 $Cidade         = str_replace(chr(39),"",substr($linha,239,25));
 $UF             = str_replace(chr(39),"",substr($linha,264,2));
 $Telefone       = str_replace(chr(39),"",substr($linha,266,15));
 $NomePai        = str_replace(chr(39),"",substr($linha,281,50));
 $NomeMae        = str_replace(chr(39),"",substr($linha,331,50));
 $ProfissaoPai   = str_replace(chr(39),"",substr($linha,381,30));
 $ProfissaoMae   = str_replace(chr(39),"",substr($linha,411,30));
 $EmpresaPai     = str_replace(chr(39),"",substr($linha,441,40));
 $EnderprofisPai = str_replace(chr(39),"",substr($linha,481,35));
 $EmpresaMae     = str_replace(chr(39),"",substr($linha,516,40));
 $EnderprofisMae = str_replace(chr(39),"",substr($linha,556,35));
 $Datacadastro   = substr($linha,591,8);
 $Observacoes    = str_replace(chr(39),"",substr($linha,599,250));
 if(trim($Datacadastro)==""){
  $Datacadastro = date("Y-m-d");
 }else{
  $Datacadastro = substr($Datacadastro,4,4)."-".substr($Datacadastro,2,2)."-".substr($Datacadastro,0,2);
 }
 if(trim($DataNasc)!=""){
  $DataNasc = substr($DataNasc,4,4)."-".substr($DataNasc,2,2)."-".substr($DataNasc,0,2);
 }
 if(trim($Numero)==""){
  $Numero = "null";
 }else{
  $Numero = (int)$Numero;
 }
 if($ProfissaoPai!="" || $EmpresaPai!="" || $EnderprofisPai!=""){
  $contatopai = "Pai: ".trim($ProfissaoPai)." ".trim($EmpresaPai)." ".trim($EnderprofisPai);
 }else{
  $contatopai = "";
 }
 if($ProfissaoMae!="" || $EmpresaMae!="" || $EnderprofisMae!=""){
  $contatomae = "Mãe: ".trim($ProfissaoMae)." ".trim($EmpresaMae)." ".trim($EnderprofisMae);
 }else{
  $contatomae = "";
 }
 $Contato = ($contatopai!=""?$contatopai."\n":"").($contatomae!=""?$contatomae."\n":"");
 $result_seq = pg_query("select nextval('aluno_ed47_i_codigo_seq') as seq_aluno");
 $codigo_aluno = pg_result($result_seq,0,'seq_aluno');
 $sql4 = "INSERT INTO aluno
                             (ed47_i_codigo
                             ,ed47_v_nome
                             ,ed47_v_ender
                             ,ed47_i_numero
                             ,ed47_v_compl
                             ,ed47_v_bairro
                             ,ed47_v_munic
                             ,ed47_v_uf
                             ,ed47_v_cep
                             ,ed47_v_telef
                             ,ed47_d_cadast
                             ,ed47_v_ident
                             ,ed47_c_naturalidade
                             ,ed47_c_nomeresp
                             ,ed47_c_emailresp
                             ,ed47_c_certidaotipo
                             ,ed47_c_certidaonum
                             ,ed47_c_certidaolivro
                             ,ed47_c_certidaofolha
                             ,ed47_c_certidaocart
                             ,ed47_c_certidaodata
                             ,ed47_c_nis
                             ,ed47_c_bolsafamilia
                             ,ed47_c_passivo
                             ,ed47_d_nasc
                             ,ed47_d_ultalt
                             ,ed47_i_estciv
                             ,ed47_i_nacion
                             ,ed47_v_cpf
                             ,ed47_v_mae
                             ,ed47_v_pai
                             ,ed47_v_sexo
                             ,ed47_c_transporte
                             ,ed47_c_zona
                             ,ed47_t_obs
                             ,ed47_v_contato
                             ,ed47_v_identcompl
                             ,ed47_d_identdtexp
                             ,ed47_v_identuf
                             ,ed47_v_identorgao
                             ,ed47_i_pais
                             ,ed47_c_certidaomunic
                       )values($codigo_aluno
                              ,'".trim(strtoupper(TiraAcento($Nome)))."'
                              ,'".trim(strtoupper(TiraAcento($Endereco)))."'
                              ,".$Numero."
                              ,'".trim(strtoupper(TiraAcento($Complemento)))."'
                              ,'".trim(strtoupper(TiraAcento($Bairro)))."'
                              ,'".trim(strtoupper(TiraAcento($Cidade)))."'
                              ,'".trim(strtoupper(TiraAcento($UF)))."'
                              ,''
                              ,'".trim(substr($Telefone,0,12))."'
                              ,'".$Datacadastro."'
                              ,'".trim($Identidade)."'
                              ,'".trim(strtoupper(TiraAcento($Naturalidade)))."'
                              ,'".trim(strtoupper(TiraAcento($NomeMae)))."'
                              ,''
                              ,'N'
                              ,''
                              ,''
                              ,''
                              ,''
                              ,null
                              ,''
                              ,'N'
                              ,'N'
                              ,".(trim($DataNasc)==""?"null":"'".$DataNasc."'")."
                              ,'".@date("Y-m-d")."'
                              ,1
                              ,1
                              ,''
                              ,'".trim(strtoupper(TiraAcento($NomeMae)))."'
                              ,'".trim(strtoupper(TiraAcento($NomePai)))."'
                              ,'".trim(strtoupper(TiraAcento($Sexo)))."'
                              ,''
                              ,''
                              ,'".trim($Observacoes)."'
                              ,'".trim($Contato)."'
                              ,''
                              ,null
                              ,''
                              ,''
                              ,10
                              ,''
                     )";
 $result4 = pg_query($sql4);
 if($result4==false){
  echo $ID_Aluno." - ".$Nome."\n".pg_errormessage();
  $erro = true;
  break;
 }else{
  $sql5 = "INSERT INTO alunoprimat
            (ed76_i_codigo,ed76_i_aluno,ed76_i_escola,ed76_c_tipo,ed76_d_data)
	   VALUES
	    (nextval('alunoprimat_ed76_i_codigo_seq'),$codigo_aluno,null,'',null)";
  $result5 = pg_query($sql5);
  if($result5==false){
   echo $ID_Aluno." - ".$Nome."\n".pg_errormessage();
   $erro = true;
   break;
  }else{
   echo $ID_Aluno." - ".$Nome."\n";
  }
 }
}
if($erro==true){
 pg_exec("rollback");
 exit;
}else{
 pg_exec("commit");
}
?>
