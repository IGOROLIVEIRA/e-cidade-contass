<?php
  set_time_limit(0);
  
//************************************************/
  $dbname  = "auto_gua_20070411";
  $dbhost  = "192.168.0.42";
  $dbport  = "5432";
//***********************************************/

  $conn = pg_connect("dbname=$dbname user=postgres port=$dbport host=$dbhost") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');
	
  pg_query("BEGIN;");

  pg_query($conn, " delete * from corempagemov ");

  $sql = "select corrente.k12_id,
                 corrente.k12_data,
                 corrente.k12_autent,
                 empagemov.e81_codmov
          from corrente 
               inner join coremp    on coremp.k12_id     = corrente.k12_id   and
                                       coremp.k12_data   = corrente.k12_data and 
                                       coremp.k12_autent = corrente.k12_autent
               inner join empord    on empord.e82_codord = coremp.k12_codord
               inner join empagemov on empagemov.e81_codmov = empord.e82_codmov
         where round(corrente.k12_valor, 2) = round(empagemov.e81_valor, 2)";

  $resultado = pg_query($conn,$sql);

  if (!$resultado){
       $erro = true;
  } else {
       $erro = false;
  }

  if ($erro==false){
       for($i=0; $i < pg_numrows($resultado); $i++){
            $sql_insert = "insert into corempagemov (k12_sequencial,
                                                     k12_id, 
                                                     k12_data, 
                                                     k12_autent, 
                                                     k12_codmov) 
                                             values (nextval('corempagemov_k12_sequencial_seq'),".
                                                     pg_result($resultado,$i,"k12_id")    .",'".
                                                     pg_result($resultado,$i,"k12_data")  ."',".
                                                     pg_result($resultado,$i,"k12_autent")."," .
                                                     pg_result($resultado,$i,"e81_codmov").")";
            $res_insert = pg_query($conn,$sql_insert);                                                       

            if (!$res_insert){
                 $erro = true;
                 break;
            } 

            $contador = $i;
            $contador++;

            echo "ID     = ".pg_result($resultado,$i,"k12_id")."\n";
            echo "DATA   = ".pg_result($resultado,$i,"k12_data")."\n";
            echo "AUTENT = ".pg_result($resultado,$i,"k12_autent")."\n";
            echo "CODMOV = ".pg_result($resultado,$i,"e81_codmov")."\n\n";

            echo "Registros inseridos ".$contador."\n\n";
       }
  }

  if ($erro==true){
	     pg_query("ROLLBACK;");
       echo "Processamento Cancelado!!\n";
  }else{
	     pg_query("COMMIT;");
       echo "Processamento Efetuado com Sucesso!!\n";
  }
?>
