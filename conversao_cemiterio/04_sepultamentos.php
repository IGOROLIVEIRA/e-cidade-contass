<?
set_time_limit(0);
require("db_conn.php");
echo "Conectando...\n";
if(!($dbportal = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE       port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) ){
 echo "erro ao conectar...\n";
 exit;
}
if(!($sam30 = pg_connect("host=$DB_SERVIDOR_SAM30 dbname=$DB_BASE_SAM30 port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) ){
 echo "erro ao conectar...\n";
 exit;
}
pg_query( $dbportal, "drop sequence retiradas_cm08_i_codigo_seq");
pg_query( $dbportal, "create sequence retiradas_cm08_i_codigo_seq start 1;" );

pg_query( $dbportal, "drop sequence renovacoes_cm07_i_codigo_seq");
pg_query( $dbportal, "create sequence renovacoes_cm07_i_codigo_seq start 1;" );

pg_query( $dbportal, "truncate retiradas" );
pg_query( $dbportal, "truncate renovacoes" );
pg_query( $dbportal, "truncate sepultamentos" );
//pg_query( $dbportal, "begin;" );

$arq1 = "txt/cem_sepultamento_erro.txt";
$arq2 = "txt/cem_renovacoes_erro.txt";
$arq3 = "txt/cem_retiradas_erro.txt";
system( "clear" );
system("> $arq1");
system("> $arq2");
system("> $arq3");

/*
 AVISO:
 
  Se houver sepultamentos sem Funeraria, rodar o seguinte SQL:
   para inserir o cgm de uma funeraria para importa√ßao 
   insert into cgm (z01_numcgm, z01_nome) values(nextval('cgm_z01_numcgm_seq'),'FUNERARIA MIGRACAO');
   insert into funerarias values(nextval('cgm_z01_numcgm_seq')-1);

  Ap√≥s rodar esses 2 sql's, consultar a tabela funerarias para saber o ultimo registro que foi inserido e alterar a linha 125 colocando o numero da funeraria cadastrada.
*/

$query_index = @pg_query("DROP INDEX sepultamentos_i_registro_in");

$sql = "select *
          from sepultamentos";
$query = pg_query($sam30,$sql);
$rows  = pg_num_rows($query);
echo "Total de Linhas: $rows \n";

for($x=0;$x<$rows;$x++){

    $array = pg_fetch_array($query);
    
    $array["sepultamento_c_nome"]           = str_replace( "'", "", trim($array["sepultamento_c_nome"]));
    $array["sepultamento_c_grauparentesco"] = str_replace( "'", "", trim($array["sepultamento_c_grauparentesco"]));
    $array["sepultamento_c_conjuge"]        = str_replace( "'", "", trim($array["sepultamento_c_conjuge"]));

    if(empty($array["sepultamento_c_nome"])){
     $str_erro = "Nome do sepultamento invalido. sepultamento: $array[sepultamento_i_codigo]\n";
     system("echo \"$str_erro\" >> $arq1");
     continue;
    }
    
    $sql_cgm = "select z01_numcgm
                  from cgm
                 where trim(z01_nome) = '".trim($array["sepultamento_c_nome"])."'";
    $query_cgm = pg_query($dbportal,$sql_cgm);
    if(pg_num_rows($query_cgm) == 0){
      $cgm = pg_result(pg_query($dbportal,"select nextval('cgm_z01_numcgm_seq')"),0,0);
      $insert_cgm = "INSERT INTO cgm (z01_numcgm,z01_nome)
                           VALUES ($cgm,'".trim($array[sepultamento_c_nome])."')";
      $query_cgm1 = pg_query($dbportal,$insert_cgm);
    }else{
      $cgm = pg_result($query_cgm,0,0);
    }

    //medico
    if( trim($array['sepultamento_i_crmcro']) == "" || trim($array['sepultamento_i_crmcro'] == 0)){
     $medico = 1;
    }else{
     $sql_med = "select cm32_i_codigo
                   from legista
                  where trim(cm32_i_crm) = ".trim($array['sepultamento_i_crmcro']);
     $medico = @pg_result(pg_query($dbportal,$sql_med),0,0);
     if(empty($medico)){
        $medico = 1;
     }
    }

    //login
    $sql_usu = "select id_usuario
                  from db_usuarios
                 where trim(nome)  = '".trim($array[funcionario_c_login])."'
                    or trim(login) = '".trim($array[funcionario_c_login])."' limit 1";
    $usuario = @pg_result(pg_query($dbportal,$sql_usu),0,0);
    if($usuario == ""){
     $usuario = 1;
    }

    //renovante->declarante
     if(trim($array['sepultamento_c_renovante']) != ""){
     $sql_ren = "select z01_numcgm
                   from cgm
                  where trim(z01_nome) = '".trim($array['sepultamento_c_renovante'])."' limit 1";
     $renovante = @pg_result(pg_query($dbportal,$sql_ren),0,0);
     if($renovante == ""){
      $nextval    = pg_result(pg_query($dbportal,"select nextval('cgm_z01_numcgm_seq')"),0,0);
      $insert_ren = "INSERT INTO cgm (z01_numcgm,z01_nome)
                              VALUES ($nextval,'".trim($array['sepultamento_c_renovante'])."')";
      pg_query($dbportal,$insert_ren);
      $renovante = $nextval;
     }
    }

    //retirante
    if(trim($array['sepultamento_c_retirante']) != ""){
     $sql_ret = "select z01_numcgm
                   from cgm
                  where trim(z01_nome) = '".trim($array['sepultamento_c_retirante'])."' limit 1";
     $retirante = @pg_result(pg_query($dbportal,$sql_ret),0,0);
     if($retirante == "" and trim($array['sepultamento_c_retirante']) != ""){
      $nextval    = pg_result(pg_query($dbportal,"select nextval('cgm_z01_numcgm_seq')"),0,0);
      $insert_ret = "INSERT INTO cgm (z01_numcgm,z01_nome)
                              VALUES ($nextval,'".trim($array['sepultamento_c_retirante'])."')";
      pg_query($dbportal,$insert_ret);
      $retirante = $nextval;
     }
    }

    //funeraria
    $nome_funeraria = pg_result(pg_query($sam30,"select funeraria_c_nome from funerarias where funeraria_i_codigo = $array[funeraria_i_codigo]"),0,0);
    $funeraria      = pg_result(pg_query($dbportal,"select z01_numcgm from cgm inner join funerarias on z01_numcgm = cm17_i_funeraria where trim(z01_nome) = '".trim($nome_funeraria)."'"),0,0);
    if(empty($funeraria)){
     $funeraria = 83014;
    }

    //hospital
    $nome_hospital = pg_result(pg_query($sam30,"select hospital_c_nome from hospitais where hospital_i_codigo = $array[hospital_i_codigo]"),0,0);
    $hospital      = pg_result(pg_query($dbportal,"select z01_numcgm from cgm where trim(z01_nome) = '".trim($nome_hospital)."'"),0,0);

    //causa
    $sql_cau   = "select cm04_i_codigo from causa
                   where trim(cm04_c_descr) = '".trim(str_replace("'","",$array['sepultamento_c_causafalecimento']))."'";
    $causa = @pg_result(pg_query($dbportal,$sql_cau),0,0);
          $sql1 = "INSERT INTO sepultamentos(cm01_i_codigo,
                                             cm01_i_medico,
                                             cm01_i_hospital,
                                             cm01_i_funeraria,
                                             cm01_i_causa,
                                             cm01_i_funcionario,
                                             cm01_i_cemiterio,
                                             cm01_i_declarante,
                                             cm01_c_conjuge,
                                             cm01_c_cor,
                                             cm01_d_falecimento,
                                             cm01_c_local,
                                             cm01_c_cartorio,
                                             cm01_c_livro,
                                             cm01_i_folha,
                                             cm01_i_registro,
                                             cm01_d_cadastro)
                                     VALUES ($cgm,
                                             $medico,
                                             $hospital,
                                             $funeraria,
                                             $causa,
                                             $usuario,
                                             $array[cemiterio_i_codigo],";
                                          if($renovante == ""){
                                             $sql1 .= " null,";
                                          }else{
                                             $sql1 .= $renovante.",";
                                          }
                                             $sql1 .= "'".trim($array['sepultamento_c_conjuge'])."',
                                             '$array[sepultamento_c_cor]', ";
                                            if(trim($array['sepultamento_d_falecimento'])==""){
                                              $sql1 .= " null,";
                                            }else{
                                             $sql1.= "'$array[sepultamento_d_falecimento]',";
					          }
                                            $sql1.="'".trim($array['sepultamento_c_localfalecimento'])."',
                                             '".trim($array['sepultamento_c_cartorio'])."',
                                             '".trim($array['sepultamento_c_livro'])."',
                                             $array[sepultamento_i_folha],
                                             $array[sepultamento_i_registro],";
                                            if(trim($array['sepultamento_d_cadastro'])==""){
                                              $sql1 .= " null";
                                            }else{
                                             $sql1.= '$array[sepultamento_d_cadastro]';
					          }
                                            $sql1 .= ")";
     $query1 = pg_query($dbportal,$sql1);
     if($query1){
      echo "\n".$x."Sepultamentos: Incluido\n";
      $inc++;
     }else{
      echo "\n".$x."Sepultamentos: NÔøΩo Incluido\n";
      $ninc++;
      $str_erro = "\nERRO:".pg_errormessage()."\nSQL:".$sql1."\n\n";
      system("echo \"$str_erro\" >> $arq1");
     }

    //###############################################################
    //RENOVACOES
    if($renovante!=""){
     $sql2 = "insert into renovacoes(cm07_i_codigo,
                                     cm07_i_sepultamento,
                                     cm07_i_renovante,
                                     cm07_c_motivo,
                                     cm07_d_ultima,
                                     cm07_d_vencimento)
                              VALUES(nextval('renovacoes_cm07_i_codigo_seq'),
                                     $cgm,
                                     $renovante,
                                     '',";
                                  if(trim($array['sepultamento_d_ultimarenovacao'])==""){
                                   $sql2 .= " null, ";
                                  }else{
                                   $sql2.= "'$array[sepultamento_d_ultimarenovacao]', ";
                                  }
                                     
                                  if(trim($array['sepultamento_d_vencimento'])==""){
                                   $sql2 .= " null";
                                  }else{
                                   $sql2.= "'$array[sepultamento_d_vencimento]'";
                                  }
                                  $sql2.= ")";

     $query2 = @pg_query($dbportal,$sql2);
     if($query2){
      $inc1++;
      echo $x."Renovacoes: Incluido\n";
     }else{
      $ninc1++;
      echo $x."Renovacoes: NÔøΩo Incluido\n";
      $str_erro = "\nERRO:".pg_errormessage()."\nSQL:".$sql2."\n\n";
      system("echo \"$str_erro\" >> $arq2");
     }
     $renovante = "";
    }

    //###############################################################
    //RETIRADAS
    if( $retirante != ""){
     $sql3 = "insert into retiradas(cm08_i_codigo,
                                    cm08_i_sepultamento,
                                    cm08_i_retirante,
                                    cm08_c_parentesco,
                                    cm08_c_causa,
                                    cm08_c_destino,
                                    cm08_d_retirada
                                   )
                             values(nextval('retiradas_cm08_i_codigo_seq'),
                                    $cgm,
                                    $retirante,
                                    '".trim($array['sepultamento_c_grauparentesco'])."',
                                    '".trim($array['sepultamento_c_causaretirada'])."',
                                    '".trim($array['sepultamento_c_destinoretirada'])."',";
				  if(trim($array['sepultamento_d_retirada'])==""){
                                   $sql3 .= " null";
                                  }else{
                                   $sql3.= "'$array[sepultamento_d_retirada]'";
                                  }
                                  $sql3.=")";
     $query3 = @pg_query($dbportal,$sql3);
     if($query3){
      $inc2++;
      echo $x."Retiradas: Incluido\n";
     }else{
      $ninc2++;
      echo $x."Retiradas: N„o Incluido\n";
      $str_erro = "\nERRO:".pg_errormessage()."\nSQL:".$sql3."\n\n";
      system("echo \"$str_erro\" >> $arq3");
     }
     $retirante = "";
    }
}
 echo "\n --------------------\n";
 echo "Sepultamento:\n";
 echo "Incluidos: $inc\n";
 echo "N„o Incluidos: $ninc\n";
 echo "\n --------------------\n";
 echo "Renovacoes:\n";
 echo "Incluidos: $inc1\n";
 echo "N„o Incluidos: $ninc1\n";
 echo "\n --------------------\n";
 echo "Retiradas:\n";
 echo "Incluidos: $inc2\n";
 echo "N„o Incluidos: $ninc2\n";
 //pg_query( $dbportal, "commit;" );
?>