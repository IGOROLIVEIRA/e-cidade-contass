<?
  set_time_limit(0);

  include (__DIR__ . "/../libs/db_conn.php");

  $conn = pg_connect("dbname=$DB_BASE user=postgres host=$DB_SERVIDOR port=$DB_PORTA") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');

  echo "Conectado a base $DB_BASE\n";

  $sql  = "select l21_codigo, l20_tipojulg, pc11_codigo, l20_codigo"; 
  $sql .= " from liclicita ";
  $sql .= "      inner join liclicitem  on liclicitem.l21_codliclicita   = liclicita.l20_codigo";
  $sql .= "      inner join pcprocitem  on  liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem";
  $sql .= "      inner join pcproc  on  pcproc.pc80_codproc = pcprocitem.pc81_codproc";
  $sql .= "      inner join solicitem  on  solicitem.pc11_codigo = pcprocitem.pc81_solicitem";
  $sql .= "      inner join solicita  on  solicita.pc10_numero = solicitem.pc11_numero";
  $sql .= "      inner join db_depart  on  db_depart.coddepto = solicita.pc10_depto";
  $sql .= "      inner join db_usuarios  on  solicita.pc10_login = db_usuarios.id_usuario";
  $sql .= "      left  join solicitemunid  on  solicitemunid.pc17_codigo = solicitem.pc11_codigo";
  $sql .= "      left  join matunid  on  matunid.m61_codmatunid = solicitemunid.pc17_unid";     
  $sql .= "      left  join solicitempcmater  on  solicitempcmater.pc16_solicitem = solicitem.pc11_codigo";
  $sql .= "      left  join pcmater  on  pcmater.pc01_codmater = solicitempcmater.pc16_codmater"; 
  $sql .= "      left  join solicitemele  on  solicitemele.pc18_solicitem = solicitem.pc11_codigo";    

  $res_liclicitem = pg_query($conn,$sql);
  $numrows        = pg_numrows($res_liclicitem);
  
  if ($numrows > 0){
       pg_query("BEGIN");
       $sql_ins  = "";
       $contador = 0;
       for($x = 0; $x < $numrows; $x++){
            $l21_codigo   = pg_result($res_liclicitem,$x,0);
            $l20_tipojulg = pg_result($res_liclicitem,$x,1);
            $pc11_codigo  = pg_result($res_liclicitem,$x,2);
            $l20_codigo   = pg_result($res_liclicitem,$x,3);

            echo "Inserido Item: ".$l21_codigo." => Licitacao: ".$l20_codigo."\n";

            if ($l20_tipojulg == 1) {
                 $l04_descricao = "LOTE_AUTOITEM_".$pc11_codigo;
            }

            if ($l20_tipojulg == 2) {
                 $l04_descricao = "GLOBAL";
            }

            $sql_ins = "insert into liclicitemlote (l04_codigo,l04_liclicitem,l04_descricao) 
                        values (nextval('liclicitemlote_l04_codigo_seq'),$l21_codigo,'$l04_descricao')"; 
            $erro = pg_query($sql_ins);

            if ($erro == false){
                 break;
            }

            $contador++;
       }

       if ($erro == false){
            pg_query("ROLLBACK");
            echo "Erro no registro: Licitacao ".$l20_codigo."  =>  Item ".$l21_codigo."\n";
       } else {
            pg_query("COMMIT");
            echo "Registros inseridos: ".$contador."\n";
       }
  } else {
      die("Erro nao foi possivel encontrar Itens de licitacao.");
  }
?>
