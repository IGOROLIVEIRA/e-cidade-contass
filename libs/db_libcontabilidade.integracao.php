<?php
function db_inicio_transacao() {
  //#00#//db_inicio_transacao
  //#10#//função para abrir uma transação
  //#15#//db_inicio_transacao();
  //#99#//Uma transação é um conjunto de execuções no banco de dados que deverão ser gravadas somente
  //#99#//se todas as execuções tiverem sucesso, caso contrário, nenhuma das execuções deverá ser
  //#99#//confirmada
  db_query('BEGIN');
  return;
}
function db_fim_transacao($erro = false) {
    //#00#//db_fim_transacao
    //#10#//função para finalizar uma transação
    //#20#//false : Finaliza transação com sucesso (commit)
    //#20#//true  : Transação com erro, desfaz os procedimentos executados (rollback)
  if ($erro == true) {
    db_query('ROLLBACK');
  } else {
    db_query('COMMIT');
  }
  return;
}
function db_planocontassaldo_matriz($anousu, $dataini, $datafim, $retsql = false, $where = '', $estrut_inicial = '',
  $acumula_reduzido = 'true', $encerramento = 'false', $join = '', $aOrcParametro = array()) {

      //echo "<pre>";
      //print_r($aOrcParametro);
      //echo "</pre>";

  if ($anousu == null)
    $anousu = db_getsession("DB_anousu");
  if ($dataini == null)
    $dataini = date('Y-m-d', db_getsession('DB_datausu'));
  if ($datafim == null)
    $datafim = date('Y-m-d', db_getsession('DB_datausu'));
  if ($where != '') {
    $condicao = " and " . $where;
  } else {
    $condicao = "";
  }

  $pesq_estrut = "";
  if ($estrut_inicial != "") {
        // oberve a concatenação da variável
    $condicao .= "  and p.c60_estrut like '$estrut_inicial%' ";
  }

  if ($encerramento == '')
    $encerramento = false;

  $sql = "
  select
  estrut_mae,
  estrut,
  c61_reduz,
  c61_codcon,
  c61_codigo,
  c60_descr,
  c60_finali,
  c61_instit,
  round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 as saldo_anterior,
  round(substr(fc_planosaldonovo,17,14)::float8,2)::float8 as saldo_anterior_debito,
  round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 as saldo_anterior_credito,
  round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 as saldo_final,
  substr(fc_planosaldonovo,59,1)::varchar(1) as sinal_anterior,
  substr(fc_planosaldonovo,60,1)::varchar(1) as sinal_final,
  c60_identificadorfinanceiro,
  c60_consistemaconta
  from
  --(select case when substr(p.c60_estrut,1,2) = '33' then '511100000000000'
  --             when substr(p.c60_estrut,1,2) = '34' then '511200000000000'
  --             when substr(p.c60_estrut,1,2) = '41' then '611100000000000'
  --             when substr(p.c60_estrut,1,2) = '49' then '611100000000000'
  --         when substr(p.c60_estrut,1,2) = '42' then '611200000000000'
  --          else p.c60_estrut end as estrut_mae,
  --                case when substr(p.c60_estrut,1,2) = '33' then '511100000000000'
  --                     when substr(p.c60_estrut,1,2) = '34' then '511200000000000'
  --                     when substr(p.c60_estrut,1,2) = '41' then '611100000000000'
  --                     when substr(p.c60_estrut,1,2) = '49' then '611100000000000'
  --         when substr(p.c60_estrut,1,2) = '42' then '611200000000000'
  --          else p.c60_estrut end as estrut,

  (select p.c60_estrut as estrut_mae,
  p.c60_estrut as estrut,
  c61_reduz,
  c61_codcon,
  c61_codigo,
  p.c60_descr,
  p.c60_finali,
  r.c61_instit,
  /* fc_planosaldonovo($anousu,c61_reduz,'$dataini','$datafim') */
  fc_planosaldonovo($anousu,c61_reduz,'$dataini','$datafim',$encerramento),
  p.c60_identificadorfinanceiro,
  c60_consistemaconta
  from conplanoexe e
  inner join conplanoreduz r on   r.c61_anousu = c62_anousu  and  r.c61_reduz = c62_reduz
  inner join conplano p on r.c61_codcon = c60_codcon and r.c61_anousu = c60_anousu
  left outer join consistema on c60_codsis = c52_codsis
  $join
  $pesq_estrut
  where c62_anousu = $anousu $condicao) as x
  ";
      #echo "<pre>$sql</pre>";
      // db_criatabela(db_query($sql));exit;

  db_query(
    "create temporary table work_pl (
    estrut_mae varchar(15),
    estrut varchar(15),
    c61_reduz integer,
    c61_codcon integer,
    c61_codigo integer,
    c60_descr varchar(50),
    c60_finali text,
    c61_instit integer,
    saldo_anterior float8,
    saldo_anterior_debito float8,
    saldo_anterior_credito float8,
    saldo_final float8,
    sinal_anterior varchar(1),
    sinal_final varchar(1),
    c60_identificadorfinanceiro character(1),
    c60_consistemaconta integer)");
      //   db_query("create temporary table work_plano as $sql");
  db_query("create index work_pl_estrut on work_pl(estrut)");
  db_query("create index work_pl_estrutmae on work_pl(estrut_mae)");

  $result = db_query($sql);
      //db_criatabela($result);exit;
  $tot_anterior = 0;
  $tot_anterior_debito = 0;
  $tot_anterior_credito = 0;
  $tot_saldo_final = 0;
  GLOBAL $seq;
  GLOBAL $estrut_mae;
  GLOBAL $estrut;
  GLOBAL $c61_reduz;
  GLOBAL $c61_codcon;
  GLOBAL $c61_codigo;
  GLOBAL $c60_codcon;
  GLOBAL $c60_descr;
  GLOBAL $c60_finali;
  GLOBAL $c61_instit;
  GLOBAL $saldo_anterior;
  GLOBAL $saldo_anterior_debito;
  GLOBAL $saldo_anterior_credito;
  GLOBAL $saldo_final;
  GLOBAL $result_estrut;
  GLOBAL $sinal_anterior;
  GLOBAL $sinal_final;
  GLOBAL $c60_identificadorfinanceiro;
  GLOBAL $c60_consistemaconta;
  GLOBAL $sis;

  $work_planomae = array();
  $work_planoestrut = array();
  $work_plano = array();
  $seq = 0;

  for ($i = 0; $i < pg_numrows($result); $i++) {
        //  for($i = 0;$i < 20;$i++){
    db_fieldsmemory($result, $i);
    if ($sinal_anterior == "C")
      $saldo_anterior *= -1;
    if ($sinal_final == "C")
      $saldo_final *= -1;
    $tot_anterior         = dbround_php_52($saldo_anterior,2);
    $tot_anterior_debito  = dbround_php_52($saldo_anterior_debito,2);
    $tot_anterior_credito = dbround_php_52($saldo_anterior_credito,2);
    $tot_saldo_final      = dbround_php_52($saldo_final,2);

    if ($acumula_reduzido == true) {
      $key = array_search("$estrut_mae", $work_planomae);
    } else {
      $key = false;
    }
        if ($key === false) { // não achou
          $work_planomae[$seq] = $estrut_mae;
          $work_planoestrut[$seq] = $estrut;
          $work_plano[$seq] = array(0 => "$c61_reduz", 1 => "$c61_codcon", 2 => "$c61_codigo", 3 => "$c60_descr",
            4 => "$c60_finali", 5 => "$c61_instit", 6 => "$saldo_anterior", 7 => "$saldo_anterior_debito",
            8 => "$saldo_anterior_credito", 9 => "$saldo_final", 10 => "$sinal_anterior", 11 => "$sinal_final",
            12 => "$c60_identificadorfinanceiro", 13 => "$c60_consistemaconta");
          $seq = $seq + 1;
        } else {
          $work_plano[$key][6] = dbround_php_52($work_plano[$key][6],2) + dbround_php_52($tot_anterior,2);
          $work_plano[$key][7] = dbround_php_52($work_plano[$key][7],2) + dbround_php_52($tot_anterior_debito,2);
          $work_plano[$key][8] = dbround_php_52($work_plano[$key][8],2) + dbround_php_52($tot_anterior_credito,2);
          $work_plano[$key][9] = dbround_php_52($work_plano[$key][9],2) + dbround_php_52($tot_saldo_final,2);
        }
        $estrutural = $estrut;

        for ($ii = 1; $ii < 10; $ii++) {
          $estrutural = db_le_mae_conplano($estrutural);
          $nivel = db_le_mae_conplano($estrutural, true);

          $key = array_search("$estrutural", $work_planomae);
          if ($key === false) { // não achou
          // busca no banco e inclui
            $res = db_query(
              "select c60_descr,c60_finali,c60_codcon, c60_identificadorfinanceiro
              from conplano
              where c60_anousu=" . $anousu . " and c60_estrut = '$estrutural'");
            if ($res == false || pg_numrows($res) == 0) {

              $sMensagemErro = "Está faltando cadastrar esse estrutural na contabilidade. Nível : {$nivel}  Estrutural : {$estrutural} - ano: {$anousu}";

              if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
                throw new Exception($sMensagemErro);
              }

              db_redireciona("db_erros.php?fechar=true&db_erro={$sMensagemErro}");
              exit;
            }
            db_fieldsmemory($res, 0);

            $work_planomae[$seq] = $estrutural;
            $work_planoestrut[$seq] = '';
            /// Validar Parametros do Orcamento para Acumular as Sinteticas (Estrutura e Instituicao)
            $work_plano[$seq] = (array(0 => 0, 1 => 0, 2 => $c60_codcon, 3 => $c60_descr, 4 => $c60_finali, 5 => 0,
              6 => $saldo_anterior, 7 => $saldo_anterior_debito, 8 => $saldo_anterior_credito, 9 => $saldo_final,
              10 => $sinal_anterior, 11 => $sinal_final, 12 => $c60_identificadorfinanceiro, 13 => $c60_consistemaconta));
            if (count($aOrcParametro) > 0) { // Se foram passados parametros...
              if (!in_array(array($estrutural, $c61_instit), $aOrcParametro)) {
                $work_plano[$seq] = (array(0 => 0, 1 => 0, 2 => $c60_codcon, 3 => $c60_descr, 4 => $c60_finali, 5 => 0,
                  6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => '', 11 => '', 12 => '', 13 => 0));
              }
            }

            $seq++;
          } else {

            /// Validar Parametros do Orcamento para Acumular as Sinteticas (Estrutura e Instituicao)
            if (count($aOrcParametro) > 0) { // Se foram passados parametros...
              if (!in_array(array($estrutural, $c61_instit), $aOrcParametro)) {

                continue;
              }
              //echo "<pre>";
              //print_r(array($estrutural, $c61_instit));
              //echo "</pre>";

              $work_plano[$key][6] = dbround_php_52($work_plano[$key][6],2) + dbround_php_52($tot_anterior,2);
              $work_plano[$key][7] = dbround_php_52($work_plano[$key][7],2) + dbround_php_52($tot_anterior_debito,2);
              $work_plano[$key][8] = dbround_php_52($work_plano[$key][8],2) + dbround_php_52($tot_anterior_credito,2);
              $work_plano[$key][9] = dbround_php_52($work_plano[$key][9],2) + dbround_php_52($tot_saldo_final,2);

            } else {
              $work_plano[$key][6] = dbround_php_52($work_plano[$key][6],2) + dbround_php_52($tot_anterior,2);
              $work_plano[$key][7] = dbround_php_52($work_plano[$key][7],2) + dbround_php_52($tot_anterior_debito,2);
              $work_plano[$key][8] = dbround_php_52($work_plano[$key][8],2) + dbround_php_52($tot_anterior_credito,2);
              $work_plano[$key][9] = dbround_php_52($work_plano[$key][9],2) + dbround_php_52($tot_saldo_final,2);
            }
          }
          if ($nivel == 1)
            break;
        }
      }
      for ($i = 0; $i < sizeof($work_planomae); $i++) {
        $mae = $work_planomae[$i];
        $estrut = $work_planoestrut[$i];
        $c61_reduz = $work_plano[$i][0];
        $c61_codcon = $work_plano[$i][1];
        $c61_codigo = $work_plano[$i][2];
        $c60_descr = $work_plano[$i][3];
        $c60_finali = $work_plano[$i][4];
        $c61_instit = $work_plano[$i][5];
        $saldo_anterior = $work_plano[$i][6];
        $saldo_anterior_debito = $work_plano[$i][7];
        $saldo_anterior_credito = $work_plano[$i][8];
        $saldo_final = $work_plano[$i][9];
        $sinal_anterior = $work_plano[$i][10];
        $sinal_final = $work_plano[$i][11];
        $c60_identificadorfinanceiro = $work_plano[$i][12];
        $c60_consistemaconta = $work_plano[$i][13];

        $sql = "insert into work_pl
        values ('$mae',
        '$estrut',
        $c61_reduz,
        $c61_codcon,
        $c61_codigo,
        '".pg_escape_string($c60_descr)."',
        '".pg_escape_string($c60_finali)."',
        $c61_instit,
        $saldo_anterior,
        $saldo_anterior_debito,
        $saldo_anterior_credito,
        $saldo_final,
        '$sinal_anterior',
        '$sinal_final',
        '$c60_identificadorfinanceiro',
        $c60_consistemaconta)";
        db_query($sql);
      }

      $sql = "select
      case when c61_reduz = 0 then
      estrut_mae
      else
      estrut
      end as estrutural,
      c61_reduz,
      c61_codcon,
      c61_codigo,
      c60_descr,
      c60_finali,
      c61_instit,
      abs(saldo_anterior) as saldo_anterior,
      abs(saldo_anterior_debito) as saldo_anterior_debito,
      abs(saldo_anterior_credito) as saldo_anterior_credito,
      abs(saldo_final) as saldo_final,
      case when saldo_anterior < 0 then  'C'
      when saldo_anterior > 0 then 'D'
      else ' '
      end as  sinal_anterior,
      case when saldo_final < 0 then 'C'
      when saldo_final > 0 then 'D'
      else ' '
      end as  sinal_final,
      case when c60_identificadorfinanceiro = 'N' then ''
      else c60_identificadorfinanceiro
      end as isf,
      case when c60_consistemaconta = 0 then ''
      when c60_consistemaconta = 1 then 'O'
      when c60_consistemaconta = 2 then 'P'
      else 'C'
      end as sis
      from work_pl
      order by estrut_mae,estrut";

      if ($retsql == false) {
        $result_final = db_query($sql);
        //db_criatabela($result_final); exit;
        return $result_final;
      } else {
        return $sql;
      }
    }
    function db_le_mae_conplano($codigo, $nivel = false) {

      $retorno = "";

      if ($retorno == "" && substr($codigo, 13, 2) != '00') {
        if ($nivel == true) {
          $retorno = 10;
        } else {
          $retorno = substr($codigo, 0, 13) . '00';
        }
      }
      if ($retorno == "" && substr($codigo, 11, 2) != '00') {
        if ($nivel == true) {
          $retorno = 9;
        } else {
          $retorno = substr($codigo, 0, 11) . '0000';
        }
      }
      if ($retorno == "" && substr($codigo, 9, 6) != '000000') {
        if ($nivel == true) {
          $retorno = 8;
        } else {
          $retorno = substr($codigo, 0, 9) . '000000';
        }
      }
      if ($retorno == "" && substr($codigo, 7, 8) != '00000000') {
        if ($nivel == true) {
          $retorno = 7;
        } else {
          $retorno = substr($codigo, 0, 7) . '00000000';
        }
      }
      if ($retorno == "" && substr($codigo, 5, 10) != '0000000000') {
        if ($nivel == true) {
          $retorno = 6;
        } else {
          $retorno = substr($codigo, 0, 5) . '0000000000';
        }
      }
      if ($retorno == "" && substr($codigo, 4, 11) != '00000000000') {
        if ($nivel == true) {
          $retorno = 5;
        } else {
          $retorno = substr($codigo, 0, 4) . '00000000000';
        }
      }
      if ($retorno == "" && substr($codigo, 3, 12) != '000000000000') {
        if ($nivel == true) {
          $retorno = 4;
        } else {
          $retorno = substr($codigo, 0, 3) . '000000000000';
        }
      }
      if ($retorno == "" && substr($codigo, 2, 13) != '0000000000000') {
        if ($nivel == true) {
          $retorno = 3;
        } else {
          $retorno = substr($codigo, 0, 2) . '0000000000000';
        }
      }
      if ($retorno == "" && substr($codigo, 1, 14) != '00000000000000') {
        if ($nivel == true) {
          $retorno = 2;
        } else {
          $retorno = substr($codigo, 0, 1) . '00000000000000';
        }
      }
      if ($retorno == "") {
        if ($nivel == true) {
          $retorno = 1;
        } else {
          $retorno = $codigo;
        }
      }
      return $retorno;
    }
