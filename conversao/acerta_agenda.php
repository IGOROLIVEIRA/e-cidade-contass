<?

set_time_limit(0);

include(__DIR__ . "/../libs/db_conn.php");

$conn = pg_connect("dbname=$DB_BASE user=postgres host=$DB_SERVIDOR port=$DB_PORTA") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');

@$isTeste = (strtoupper($argv[1])=="TESTE");

echo "Conectado a base $DB_BASE\n";

// Inicia Transacao
pg_query($conn, "begin");

if ($isTeste == false){
     $sql_w_agenda    = "create table w_agenda    as select * from empage";
     $sql_w_agendamov = "create table w_agendamov as select * from empagemov";

     $res_agenda = @pg_query($conn,$sql_w_agenda);
     if ($res_agenda == false) {
          die("Tabela de backup da Agenda ja criada ou processo ja executado.\n\n");
     }

     $res_agendamov = @pg_query($conn,$sql_w_agendamov);
     if ($res_agendamov == false) {
          die("Tabela de backup de Movimento deAgenda ja criada ou processo ja executado.\n\n");
     }
     
     echo "Backup das tabelas empage e empagemov feito com sucesso.\n\n";
}

$sql  = " select e80_codage, ";
$sql .= "        e80_cancelado, ";
$sql .= "        e80_data, ";
$sql .= "        count(distinct instit) - 1 as qtd ";
$sql .= " from ( ";
$sql .= "   select distinct ";
$sql .= "          e81_codage, ";
$sql .= "          case when empempenho.e60_instit is not null then 'OP' else 'SLIP' end as tipo, ";
$sql .= "          case when empempenho.e60_instit is not null then empempenho.e60_instit else slip.k17_instit end as instit ";
$sql .= "     from empagemov ";
$sql .= "          left join empord on empord.e82_codmov = empagemov.e81_codmov ";
$sql .= "          left join pagordem on pagordem.e50_codord = empord.e82_codord ";
$sql .= "          left join empempenho on empempenho.e60_numemp = pagordem.e50_numemp ";
$sql .= "          left join empageslip on empageslip.e89_codmov = empagemov.e81_codmov ";
$sql .= "          left join slip on slip.k17_codigo = empageslip.e89_codigo ";
$sql .= " ) as x ";
$sql .= " inner join empage on e80_codage = e81_codage ";
$sql .= " group by e80_codage, ";
$sql .= "          e80_cancelado, ";
$sql .= "          e80_data ";
$sql .= " having count(distinct instit) > 1; ";

$resEmpage = pg_query($conn, $sql);
$numrows   = pg_numrows($resEmpage);

echo "Total de registros encontrados: ".$numrows."\n\n";

$erro = true;
if ($numrows > 0) {
  $sql_ins     = "";
  $sql_update  = "";
  $cont_ins    = 0;
  $cont_update = 0;
  $qtdAgendas  = 0;

  for ($i = 0; $i < $numrows; $i++) {
    $e80_codage    = pg_result($resEmpage, $i, "e80_codage");
    $e80_cancelado = pg_result($resEmpage, $i, "e80_cancelado");
    $e80_data      = pg_result($resEmpage, $i, "e80_data");
    $qtdAgendas   += pg_result($resEmpage, $i, "qtd");

    $e80_cancelado = (empty($e80_cancelado)?"null":"'$e80_cancelado'");
    
    $sql  = "   select e81_codage, ";
    $sql .= "          e81_codmov, ";
    $sql .= "          institmov   ";
    $sql .= "     from (select e81_codage,  ";
    $sql .= "                  e81_codmov,  ";
    $sql .= "                  case  ";
    $sql .= "                    when empempenho.e60_instit is not null then  ";
    $sql .= "                      empempenho.e60_instit  ";
    $sql .= "                    else  ";
    $sql .= "                      slip.k17_instit  ";
    $sql .= "                  end as institmov ";
    $sql .= "             from empagemov  ";
    $sql .= "                  left join empord on empord.e82_codmov         = empagemov.e81_codmov  ";
    $sql .= "                  left join pagordem on pagordem.e50_codord     = empord.e82_codord     ";
    $sql .= "                  left join empempenho on empempenho.e60_numemp = pagordem.e50_numemp   ";
    $sql .= "                  left join empageslip on empageslip.e89_codmov = empagemov.e81_codmov  ";
    $sql .= "                  left join slip on slip.k17_codigo             = empageslip.e89_codigo ";
    $sql .= "            where e81_codage = $e80_codage ";
    $sql .= "          ) as x  ";
    $sql .= "          inner join db_config on db_config.codigo = institmov ";
    $sql .= "    where prefeitura is false ";
    $sql .= " order by institmov, e81_codmov ";

    $resEmpageMov     = pg_query($conn, $sql);
    $numrowsEmpageMov = pg_numrows($resEmpageMov);

    $e80_instit  = null;
    for($ii = 0; $ii < $numrowsEmpageMov; $ii++) {
      $e81_codmov = pg_result($resEmpageMov, $ii, "e81_codmov");
      $institmov  = pg_result($resEmpageMov, $ii, "institmov");
    
      if ($e80_instit != $institmov) {
        $res_empage = pg_query("select nextval('empage_e80_codage_seq')") or die("Erro ao buscar sequence empage_e80_codage_seq");
        $novocodage = pg_result($res_empage,0,0) or die("Erro ao buscar novo codigo de agenda");;

        $sql_ins    = "insert into empage (e80_codage, e80_data, e80_cancelado, e80_instit) ";
        $sql_ins   .= "values ($novocodage,'$e80_data',$e80_cancelado,$institmov)";
        $erro       = pg_query($sql_ins) or die("Erro ao inserir nova agenda $novocodage");

        echo "> Nova agenda criada $novocodage (Agenda antiga: $e80_codage)\n";

        if($erro == false) {
            break;
        }       

        $e80_instit = $institmov;
        $cont_ins++;
      }

      $sql_update = "update empagemov set e81_codage = $novocodage where e81_codmov = $e81_codmov";
      $erro       = pg_query($sql_update) or die("Erro ao alterar movimento $e81_codmov para nova agenda $novocodage");

      echo "   * Alterado movimento $e81_codmov (instit $institmov) para nova Agenda $novocodage\n";

      if($erro == false) {
          break;
      }       

      $cont_update++;
    }
    
  }
  

  // Consistencia o nro de agendas geradas
  if($qtdAgendas <> $cont_ins) {
    echo "\n\nERRO: Inconsistencia na geracao das agendas. Deveriam ser geradas $qtdAgendas e foram geradas $cont_ins!!!\n";
    pg_query($conn, "rollback");
    exit;
  }


  echo "\n\n         Total de Novas Agendas Criadas: ".$cont_ins."\n";
  echo "Total de Movimentos de Agenda Alterados: ".$cont_update."\n";
} else {
  echo "\nNão foi encontrada nenhuma agenda com movimentos de mais de uma Instituição!!\n";
}

echo "\n\n****   Acertando agendas sem Instituição definida na tabela empage   ****\n";
$res_empage = pg_query("select count(*) as total from empage where e80_instit is null");
pg_query("update empage set e80_instit = (select codigo from db_config where prefeitura is true limit 1) where e80_instit is null");
$total      = pg_result($res_empage,0,0);

echo "Total de registros alterados: ".$total."\n\n";

if ($erro == false || $isTeste == true) {

  if($isTeste == true) {
    echo "\nExecutando em modo de teste. Executando Rollback!!\n\n";
  }

  pg_query("rollback");
} else {
  pg_query("commit");
}

?>
