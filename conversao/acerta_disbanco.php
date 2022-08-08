<?

set_time_limit(0);

include (__DIR__ . "/../libs/db_stdlib.php");
include (__DIR__ . "/../libs/db_conn.php");

$DB_BASE="bage";
$DB_SERVIDOR="192.168.78.7";

$conn = pg_connect("dbname=$DB_BASE user=postgres host=$DB_SERVIDOR port=$DB_PORTA") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');

echo "Conectado a base $DB_BASE\n";

$instit = 4;

$erro=true;

$data=date("Y-m-d-G:i");

system("> pagando_$data.txt");

sleep(5);

$sql  = " select 
          disbanco.idret,
          k00_numpre,
          k00_numpar,
          vlrpago,
          vlrcalc,
          dtpago,
          k00_conta,
          dtretorno
          from disbanco 
          inner join disarq on disbanco.codret = disarq.codret
          where disarq.dtretorno >= '2009-01-01' and disarq.instit = $instit and disbanco.classi is true and k00_numpar = 0 
--          and idret = 2020960
--          and idret = 2021798
--          and idret = 2021586
          order by idret desc";
$result = pg_query($conn, $sql) or die($sql);
$numrows = pg_numrows($result);

$divold_cancelado         = 0;
$divold_pago              = 0;
$pagando                  = 0;
$quant_erro               = 0;
$pagouincorreto           = 0;
$naodivold_falta_arrepaga = 0;

if ($numrows > 0) {

  pg_query($conn, "begin");

  pg_query($conn, "select fc_startsession()");
  pg_query($conn, "select fc_putsession('DB_instit', $instit)");

  for($x = 0; $x < $numrows; $x++){
    db_fieldsmemory($result, $x);

    echo "processando idret: $idret - erro: $quant_erro - pagando: $pagando - $x/$numrows\n";

    $sqlarrecant = " select sum(k00_valor) as sum_arrecant from arreidret 
                    inner join arrecant on arreidret.k00_numpre = arrecant.k00_numpre and arreidret.k00_numpar = arrecant.k00_numpar
                    where arreidret.idret = $idret";
    $resultarrecant = pg_query($conn, $sqlarrecant) or die($sqlarrecant);
    if (pg_numrows($resultarrecant) > 0) {
      db_fieldsmemory($resultarrecant, 0);
    } else {
      $sum_arrecant = 0;
    }

    $sqlarrepaga = " select sum(k00_valor) as sum_arrepaga from arreidret 
                    inner join arrepaga on arreidret.k00_numpre = arrepaga.k00_numpre and arreidret.k00_numpar = arrepaga.k00_numpar
                    where arreidret.idret = $idret";
    $resultarrepaga = pg_query($conn, $sqlarrepaga) or die($sqlarrepaga);
    if (pg_numrows($resultarrepaga) > 0) {
      db_fieldsmemory($resultarrepaga, 0);
    } else {
      $sum_arrepaga = 0;
    }

    $sqldivold = "
      select  distinct
              recibopaga.k00_numpre as recibopaga_numpre, 
              recibopaga.k00_numpar as recibopaga_numpar, 
              recibopaga.k00_receit as recibopaga_receit,
              recibopaga.k00_numnov,
              coalesce((select count(*) from divold 
                        inner join divida on divold.k10_coddiv = divida.v01_coddiv
                        inner join proced on proced.v03_codigo = divida.v01_proced
                        where divold.k10_numpre = recibopaga.k00_numpre and divold.k10_numpar = recibopaga.k00_numpar and divold.k10_receita = recibopaga.k00_receit 
                        and 
                        (
                        coalesce( (select count(*) from arrecad a where a.k00_numpre = divida.v01_numpre and a.k00_numpar = divida.v01_numpar and a.k00_receit = proced.v03_receit), 0) > 0
                        )
                        ),0) as divold_arrecad,
              coalesce((select count(*) from divold 
                        inner join divida on divold.k10_coddiv = divida.v01_coddiv 
                        inner join proced on proced.v03_codigo = divida.v01_proced
                        where divold.k10_numpre = recibopaga.k00_numpre and divold.k10_numpar = recibopaga.k00_numpar and divold.k10_receita = recibopaga.k00_receit
                        and 
                        coalesce( (select count(*) from arrecant a where a.k00_numpre = divida.v01_numpre and a.k00_numpar = divida.v01_numpar and a.k00_receit = proced.v03_receit), 0) > 0
                        ),0) as divold_arrecant,
              coalesce((select count(*) from divold 
                        inner join divida on divold.k10_coddiv = divida.v01_coddiv 
                        inner join proced on proced.v03_codigo = divida.v01_proced
                        where divold.k10_numpre = recibopaga.k00_numpre and divold.k10_numpar = recibopaga.k00_numpar and divold.k10_receita = recibopaga.k00_receit
                        and 
                        coalesce( (select count(*) from arrepaga a where a.k00_numpre = divida.v01_numpre and a.k00_numpar = divida.v01_numpar and a.k00_receit = proced.v03_receit and a.k00_hist not in (400,401,918)), 0) > 0
                        ),0) as divold_arrepaga

      from disbanco 
      inner join recibopaga on disbanco.k00_numpre = recibopaga.k00_numnov and disbanco.k00_numpar = 0 
      where disbanco.idret = $idret and recibopaga.k00_hist not in (400,401,918)
                ";
    $resultdivold = pg_query($conn, $sqldivold) or die($sqldivold);

    echo "testando: " . pg_numrows($resultdivold) . "\n";

    if (pg_numrows($resultdivold) > 0) {

      for ($y=0; $y < pg_numrows($resultdivold); $y++) {
        db_fieldsmemory($resultdivold, $y);

        echo "   testando - numpre: $recibopaga_numpre - numpar: $recibopaga_numpar - receita: $recibopaga_receit - divoldarrecad: $divold_arrecad - cant: $divold_arrecant - paga: $divold_arrepaga\n";

        if ($divold_arrecad == 0 and $divold_arrecant == 0 and $divold_arrepaga == 0) {

          $sqlarrecantdivold = "select * from arrecant where k00_numpre = $recibopaga_numpre and k00_numpar = $recibopaga_numpar and k00_receit = $recibopaga_receit";
          $resultarrecantdivold = pg_query($conn, $sqlarrecantdivold);

          $sqlarrepagadivold = "select * from arrepaga where k00_numpre = $recibopaga_numpre and k00_numpar = $recibopaga_numpar and k00_receit = $recibopaga_receit";
          $resultarrepagadivold = pg_query($conn, $sqlarrepagadivold);

          if (pg_numrows($resultarrecantdivold) > 0 and pg_numrows($resultarrepagadivold) > 0) {
            echo "      ok\n";
          } else {
            echo "     erro - arrecant: " . pg_numrows($resultarrecantdivold) . " - arrepaga: " . pg_numrows($resultarrepagadivold) . " \n";
            if (pg_numrows($resultarrecantdivold) == 0 and pg_numrows($resultarrepagadivold) == 0) {
              exit;
            } elseif (pg_numrows($resultarrecantdivold) == 0 and pg_numrows($resultarrepagadivold) > 0) {

              $sqltipo = "select distinct k00_tipo from arrecant where k00_numpre = $recibopaga_numpre and k00_numpar = $recibopaga_numpar 
                          union 
                          select distinct k00_tipo from arreold where k00_numpre = $recibopaga_numpre and k00_numpar = $recibopaga_numpar";
              $result_tipo = pg_query($conn, $sqltipo) or die($sqltipo);
              if (pg_numrows($result_tipo) == 0) {
                echo "erro ao procurar tipo\n";
                exit;
              } elseif (pg_numrows($result_tipo) == 1) {
                db_fieldsmemory($result_tipo,0);
              } elseif (pg_numrows($result_tipo) > 1) {
                echo "tipo maior que 1\n";
                for ($aa=0; $aa < pg_numrows($result_tipo); $aa++) {
                  db_fieldsmemory($result_tipo, $aa);
                  echo "$aa - tipo: $k00_tipo\n";
                }
                exit;
              }

              echo "         inserindo arrecant...\n";

              $sqlinsertarrecant = "insert into arrecant 
                                    (
                                     k00_numpre,
                                     k00_numpar,
                                     k00_numcgm,
                                     k00_dtoper,
                                     k00_receit,
                                     k00_hist,
                                     k00_valor,
                                     k00_dtvenc,
                                     k00_numtot,
                                     k00_numdig,
                                     k00_tipo,
                                     k00_tipojm
                                    )
                                     select 
                                     k00_numpre,
                                     k00_numpar,
                                     k00_numcgm,
                                     k00_dtoper,
                                     k00_receit,
                                     k00_hist,
                                     k00_valor,
                                     k00_dtvenc,
                                     k00_numtot,
                                     k00_numdig,
                                     $k00_tipo,
                                     0 
                                     from arrepaga 
                                     where k00_numpre = $recibopaga_numpre and k00_numpar = $recibopaga_numpar and k00_receit = $recibopaga_receit and k00_hist not in (400,401,918)";
              $resultinsertarrecant = pg_query($conn, $sqlinsertarrecant) or die($sqlinsertarrecant);
              $naodivold_falta_arrepaga++;
            } else {
              $quant_erro++;
            }

          }

        } else {

          $sqlarrecantdivold = "select 
                                k10_coddiv,
                                coalesce((select k00_matric from arrematric where k00_numpre = divida.v01_numpre limit 1),0) as k00_matric,
                                (select count(*) from arrecad  a where a.k00_numpre = divida.v01_numpre and a.k00_numpar = divida.v01_numpar and a.k00_receit = proced.v03_receit) as quant_arrecad,
                                (select count(*) from arrecant a where a.k00_numpre = divida.v01_numpre and a.k00_numpar = divida.v01_numpar and a.k00_receit = proced.v03_receit) as quant_arrecant,
                                (select count(*) from arrepaga a where a.k00_numpre = divida.v01_numpre and a.k00_numpar = divida.v01_numpar and a.k00_receit = proced.v03_receit and a.k00_hist not in (400,401,918)) as quant_arrepaga
                                from divold 
                                inner join divida on k10_coddiv = v01_coddiv
                                inner join proced on v01_proced = v03_codigo
                                where k10_numpre = $recibopaga_numpre and k10_numpar = $recibopaga_numpar and k10_receita = $recibopaga_receit";
          $resultarrecantdivold = pg_query($conn, $sqlarrecantdivold);
          for ($z=0; $z < pg_numrows($resultarrecantdivold); $z++) {
            db_fieldsmemory($resultarrecantdivold,$z);

            echo "         coddiv: $k10_coddiv - arrecad: $quant_arrecad - arrecant: $quant_arrecant - arrepaga: $quant_arrepaga\n";

            if ($quant_arrecad > 0) {

              $sqlarrepagadivold = "select * from arrepaga where k00_numpre = $recibopaga_numpre and k00_numpar = $recibopaga_numpar and k00_receit = $recibopaga_receit";
              $resultarrepagadivold = pg_query($conn, $sqlarrepagadivold);

              if (pg_numrows($resultarrepagadivold) > 0) {
                echo "incorreto: \n";
                $pagouincorreto++;
                echo "deletando arrepaga pelo numpre anterior \n";
                $sqldeletearrepaga = "delete from arrepaga where k00_numpre = $recibopaga_numpre and k00_numpar = $recibopaga_numpar and k00_receit = $recibopaga_receit";
                $result_delete_arrepaga = pg_query($conn, $sqldeletearrepaga) or die($sqldeletearrepaga);
              }

              $pagando++;
              system("echo \"codigo da divida: $k10_coddiv - matricula: $k00_matric\" >> pagando_$data.txt");

              echo "inserindo arrecant\n";
              $insertarrecant = "insert into arrecant
                                  (
                                   k00_numpre,
                                   k00_numpar,
                                   k00_numcgm,
                                   k00_dtoper,
                                   k00_receit,
                                   k00_hist,
                                   k00_valor,
                                   k00_dtvenc,
                                   k00_numtot,
                                   k00_numdig,
                                   k00_tipo,
                                   k00_tipojm
                                  )
                                   select 
                                   k00_numpre,
                                   k00_numpar,
                                   k00_numcgm,
                                   k00_dtoper,
                                   k00_receit,
                                   k00_hist,
                                   k00_valor,
                                   k00_dtvenc,
                                   k00_numtot,
                                   k00_numdig,
                                   k00_tipo,
                                   k00_tipojm
                                   from divold
                                   inner join divida on k10_coddiv = v01_coddiv
                                   inner join arrecad a on a.k00_numpre = divida.v01_numpre and a.k00_numpar = divida.v01_numpar
                                   where k10_coddiv = $k10_coddiv";
              $resultinsertarrecant = pg_query($conn, $sqlinsertarrecant) or die($sqlinsertarrecant);

              echo "inserindo arrepaga\n";
              $sqlinsertarrepaga = "insert into arrepaga
                                  (
                                   k00_numpre,
                                   k00_numpar,
                                   k00_numcgm,
                                   k00_dtoper,
                                   k00_receit,
                                   k00_hist,
                                   k00_valor,
                                   k00_dtvenc,
                                   k00_numtot,
                                   k00_numdig,
                                   k00_conta,
                                   k00_dtpaga
                                  )
                                   select 
                                   k00_numpre,
                                   k00_numpar,
                                   k00_numcgm,
                                   k00_dtoper,
                                   k00_receit,
                                   k00_hist,
                                   k00_valor,
                                   k00_dtvenc,
                                   k00_numtot,
                                   k00_numdig,
                                   $k00_conta,
                                   '$dtretorno'
                                   from divold
                                   inner join divida on k10_coddiv = v01_coddiv
                                   inner join arrecad a on a.k00_numpre = divida.v01_numpre and a.k00_numpar = divida.v01_numpar
                                   where k10_coddiv = $k10_coddiv";
              $resultinsertarrepaga = pg_query($conn, $sqlinsertarrepaga) or die($sqlinsertarrepaga);

              echo "deletando arrecad\n";
              $sqldeletearrecad = "  delete from arrecad using divida
                                   where arrecad.k00_numpre = divida.v01_numpre and arrecad.k00_numpar = divida.v01_numpar
                                   and divida.v01_coddiv = $k10_coddiv";
              $resultdeletearrecad = pg_query($conn, $sqldeletearrecad) or die($sqldeletearrecad);

            } elseif ($quant_arrecant > 0 and $quant_arrepaga == 0) {
              $divold_cancelado++;
            } elseif ($quant_arrecant > 0 and $quant_arrepaga > 0) {
              $divold_pago++;
            } else {
              echo "quant_arrecad: $quant_arrecad - quant_arrecant: $quant_arrecant - quant_arrepaga: $quant_arrepaga\n";
              echo "$sqlarrecantdivold \n";
              exit;
            }

          }

        }

      }

    }

  }

  if ($erro == false){
    pg_query($conn, "rollback");
  } else {
    pg_query($conn, "commit");
  }

} else {
  die("Erro nao foi possivel encontrar registros para processar!");
}

echo "\n";
echo "erro: $quant_erro - pagouincorreto: $pagouincorreto - naodivold_falta_arrepaga: $naodivold_falta_arrepaga - pagando: $pagando\n";
echo "divold_cancelado: $divold_cancelado - divold_pago: $divold_pago\n";
echo "\n";
echo "fim\n";
echo "\n";

?>
