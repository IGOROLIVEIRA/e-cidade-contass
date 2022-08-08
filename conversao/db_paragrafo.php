<?
    $str_arquivo = $_SERVER['PHP_SELF'];
    set_time_limit(0);

    require(__DIR__ . "/../libs/db_stdlib.php");
    //require (__DIR__ . "/../libs/db_conn.php");
    echo "Conectando...\n";
    
    /*
    $DB_USUARIO = "postgres";
    $DB_SERVIDOR = "192.168.0.2";
    $DB_BASE = "auto_sap_20080221";
    
    $DB_USUARIO = "postgres";
    $DB_SERVIDOR = "192.168.0.52";
    $DB_BASE = "auto_sap_20080212";
    */
   
   
    if(!($conn1 = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE user=$DB_USUARIO "))) {
      echo "erro ao conectar...\n";
      exit;
    }
    $ordem = 1;
   system( "clear" );
    $erro = false;
    pg_exec( $conn1, "begin;");
    $sqlintit = "select codigo from db_config where prefeitura is true";
    $resultintit = pg_query($sqlintit);
    db_fieldsmemory($resultintit,0);
    $instit = $codigo;
        
    $sqltexto ="select * from db_textos 
                where id_instit = $instit 
                      and ( descrtexto like 'termo%' ) 
                      and conteudotexto is not null 
                      and  conteudotexto <> '' 
                order by descrtexto ";
    $resulttexto = pg_query($sqltexto);
    $linhastexto = pg_num_rows($resulttexto); 
    if($linhastexto >0){
       $sqlcoddoc = " select nextval('db_documento_db03_docum_seq') as coddoc";
       $resultcoddoc = pg_query($sqlcoddoc);
       db_fieldsmemory($resultcoddoc,0);
    
       $insertdoc = "insert into db_documento values($coddoc,'TERMO DE PARCELAMENTO', 1700,(select codigo from db_config where prefeitura is true))";
       pg_query($insertdoc);
        echo "\n documento =". $coddoc;
        // incluir o titulo do parcelamento
        $sqlcodparag = "select nextval('db_paragrafo_db02_idparag_seq') as codparag";
        $resultcodparag = pg_query($sqlcodparag);
        db_fieldsmemory($resultcodparag,0);
        $insertparag = "insert into db_paragrafo (db02_idparag,db02_descr,db02_texto,db02_alinha,db02_inicia,db02_espaca) 
                       values ($codparag,'titulo_parcelamento','TERMO DE CONFISSÃO DE DIVIDA E COMPROMISSO DE PAGAMENTO: #\$parcel#',1,1,1)";
        pg_query($insertparag);
        echo "\n paragrafo = ". $codparag;
        $insertdocparag = "insert into db_docparag (db04_docum , db04_idparag ,db04_ordem ) values ($coddoc,$codparag,$ordem)";
        pg_query($insertdocparag);
        $ordem ++;
       // importar os paragrafos
       for($i=0;$i<$linhastexto;$i++){
          db_fieldsmemory($resulttexto,$i);
          
          if($descrtexto=="termo_p2"){
            // inclui a tabela antes
            // tabela valores
            $sqlcodparag = "select nextval('db_paragrafo_db02_idparag_seq') as codparag";
            $resultcodparag = pg_query($sqlcodparag);
            db_fieldsmemory($resultcodparag,0);
          
            $insertparag = "insert into db_paragrafo (db02_idparag,db02_descr,db02_texto,db02_alinha,db02_inicia,db02_espaca) 
                                            values ($codparag,'tabela_valores','tabela_valores',1,1,1)";
            pg_query($insertparag);
            echo "\n paragrafo = ". $codparag;
            $insertdocparag = "insert into db_docparag (db04_docum , db04_idparag ,db04_ordem ) values ($coddoc,$codparag,$ordem)";
            pg_query($insertdocparag);
            $ordem ++;
            
            //tabela_total
            $sqlcodparag = "select nextval('db_paragrafo_db02_idparag_seq') as codparag";
            $resultcodparag = pg_query($sqlcodparag);
            db_fieldsmemory($resultcodparag,0);
          
            $insertparag = "insert into db_paragrafo (db02_idparag,db02_descr,db02_texto,db02_alinha,db02_inicia,db02_espaca) 
                                            values ($codparag,'tabela_total','tabela_total',1,1,1)";
            pg_query($insertparag);
            echo "\n paragrafo = ". $codparag;
            $insertdocparag = "insert into db_docparag (db04_docum , db04_idparag ,db04_ordem ) values ($coddoc,$codparag,$ordem)";
            pg_query($insertdocparag);
            $ordem ++;
            
            //tabela_parcela
            $sqlcodparag = "select nextval('db_paragrafo_db02_idparag_seq') as codparag";
            $resultcodparag = pg_query($sqlcodparag);
            db_fieldsmemory($resultcodparag,0);
          
            $insertparag = "insert into db_paragrafo (db02_idparag,db02_descr,db02_texto,db02_alinha,db02_inicia,db02_espaca) 
                                            values ($codparag,'tabela_parcela','tabela_parcela',1,1,1)";
            pg_query($insertparag);
            echo "\n paragrafo = ". $codparag;
            $insertdocparag = "insert into db_docparag (db04_docum , db04_idparag ,db04_ordem ) values ($coddoc,$codparag,$ordem)";
            pg_query($insertdocparag);
            $ordem ++;
            
          }
          
          if($descrtexto=="termo_p5"){
            // inclui a data
            $sqlcodparag = "select nextval('db_paragrafo_db02_idparag_seq') as codparag";
            $resultcodparag = pg_query($sqlcodparag);
            db_fieldsmemory($resultcodparag,0);
          
            $insertparag = "insert into db_paragrafo (db02_idparag,db02_descr,db02_texto,db02_alinha,db02_inicia,db02_espaca) 
                                            values ($codparag,'termo_p5','#\$nomeinst#,#\$diaTermo# de #\$mesTermo# de #\$anoTermo#.',3,1,1)";
            pg_query($insertparag);
            echo "\n paragrafo = ". $codparag;
            $insertdocparag = "insert into db_docparag (db04_docum , db04_idparag ,db04_ordem ) values ($coddoc,$codparag,$ordem)";
            pg_query($insertdocparag);
            $ordem ++;
            
            //inclui a assinatura.
            $sqlcodparag = "select nextval('db_paragrafo_db02_idparag_seq') as codparag";
            $resultcodparag = pg_query($sqlcodparag);
            db_fieldsmemory($resultcodparag,0);
          
            $insertparag = "insert into db_paragrafo (db02_idparag,db02_descr,db02_texto,db02_alinha,db02_inicia,db02_espaca) 
                                            values ($codparag,'termo_p6','#\$responsavel# \n Contribuinte ou representante legal ',2,1,1)";
            pg_query($insertparag);
            echo "\n paragrafo = ". $codparag;
            $insertdocparag = "insert into db_docparag (db04_docum , db04_idparag ,db04_ordem ) values ($coddoc,$codparag,$ordem)";
            pg_query($insertdocparag);
            $ordem ++;
            $descrtexto = "termo_p7";
          }
          $sqlcodparag = "select nextval('db_paragrafo_db02_idparag_seq') as codparag";
          $resultcodparag = pg_query($sqlcodparag);
          db_fieldsmemory($resultcodparag,0);
          
          $insertparag = "insert into db_paragrafo (db02_idparag,db02_descr,db02_texto,db02_alinha,db02_inicia,db02_espaca) 
                                            values ($codparag,'$descrtexto','$conteudotexto',1,1,1)";
          pg_query($insertparag);
          echo "\n paragrafo = ". $codparag;
          $insertdocparag = "insert into db_docparag (db04_docum , db04_idparag ,db04_ordem ) values ($coddoc,$codparag,$ordem)";
          pg_query($insertdocparag);
          $ordem ++;    
          
          
       }
    }
    
    $sqlaltera = "update db_paragrafo set db02_texto =replace(db02_texto,'#\$valor#','#\$valorparc#') where db02_descr = 'termo_p1'";
    pg_query($sqlaltera);
    
    pg_exec( $conn1, "commit;");  
?>
