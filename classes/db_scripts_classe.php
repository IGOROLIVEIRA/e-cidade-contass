<?

class cl_scripts {

  var $erro_msg   = null;
  var $erro       = false;

  function cl_scripts() {
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }

   // funcões
  function alteraDocumento ($lancamento,$proximodoc, $anteriordoc){

  if(in_array($anteriordoc, array('200','208','210','212','214'))){
    if(!in_array($proximodoc, array('200','208','210','212','214'))){
        $this->erro_msg = "Se o lançamento contábil for do documento $anteriordoc, o sistema permitirá alterar para os documentos 200, 208, 210, 212, 214";
        $this->erro = true;
        return false;
    }
  }
  if(in_array($anteriordoc, array('201','209','211','213','215'))){
    if(!in_array($proximodoc, array('201','209','211','213','215'))){
        $this->erro_msg = "Se o lançamento contábil for do documento $anteriordoc, o sistema permitirá alterar para os documentos 209, 211, 213 e 215";
        $this->erro = true;
        return false;
    }
  }

  if(in_array($anteriordoc, array('39','3','23','202','204','206','33'))){
    if(!in_array($proximodoc, array('39','3','23','202','204','206','33'))){
        $this->erro_msg = "Se o lançamento contábil for do documento $anteriordoc, o sistema permitirá alterar para os documentos 39, 3, 23, 202, 204, 206, 33";
        $this->erro = true;
        return false;
    }
  }

    if(in_array($anteriordoc, array('40','4','24','203','205','207','34'))){
    if(!in_array($proximodoc, array('40','4','24','203','205','207','34'))){
        $this->erro_msg = "Se o lançamento contábil for do documento $anteriordoc, o sistema permitirá alterar para os documentos 40, 4, 24, 203, 205, 207, 34";
        $this->erro = true;
        return false;
    }
  }


  if(in_array($anteriordoc, array('160','150','130'))){
    if(!in_array($proximodoc, array('160','150','130'))){
        $this->erro_msg = "Se o lançamento contábil for do documento $anteriordoc, o sistema permitirá alterar para os documentos 160, 150 e 130";
        $this->erro = true;
        return false;
    }
  }

  if(in_array($anteriordoc, array('161','151','120'))){
    if(!in_array($proximodoc, array('161','151','120'))){
        $this->erro_msg = "Se o lançamento contábil for do documento $anteriordoc, o sistema permitirá alterar para os documentos 161, 151 e 120";
        $this->erro = true;
        return false;
    }
  }

  if(in_array($anteriordoc, array('162','152','131'))){
    if(!in_array($proximodoc, array('162','152','131'))){
        $this->erro_msg = "Se o lançamento contábil for do documento $anteriordoc, o sistema permitirá alterar para os documentos 152 e 131";
        $this->erro = true;
        return false;
    }
  }

  if(in_array($anteriordoc, array('163','153','121'))){
    if(!in_array($proximodoc, array('163','153','121'))){
        $this->erro_msg = "Se o lançamento contábil for do documento $anteriordoc, o sistema permitirá alterar para os documentos 163, 153 e 121";
        $this->erro = true;
        return false;
    }
  }

  if(in_array($anteriordoc, array('100','101','115','116','122','123','124','125','126','127','418','419'))){
    if(!in_array($proximodoc, array('100','101','115','116','122','123','124','125','126','127','418','419'))){
        $this->erro_msg = "Se o lançamento contábil for do documento $anteriordoc, o sistema permitirá alterar para os documentos 100,101,115,116,122,123,124,125,126,127,418 e 419";
        $this->erro = true;
        return false;
    }
  }

    $result = db_query("update conlancamdoc set c71_coddoc=$proximodoc where c71_codlan = '$lancamento'");

    if($result===false){
       $this->erro_msg = @pg_last_error();
       $this->erro = true;
       return false;
    }

     $this->erro_msg = "";
     $this->erro_msg = "Alteração efetuada com Sucesso\\n Aviso: é necessário realizar o reprocessamento do lançamento no Módulo Contabilidade - Procedimentos - Utilitários da Contabilidade - Processa Lançamentos";

     $resmanut = db_query("select nextval('db_manut_log_manut_sequencial_seq') as seq");
     $seq   = pg_result($resmanut,0,0);
     $result = db_query("insert into db_manut_log values($seq,'Alt Documento: ".$anteriordoc." para ".$proximodoc." no lançamento ". $lancamento ."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");

     return true;
  }

  function excluiEmpenho ($seq_emp){

    $ano    = db_getsession('DB_anousu');
    $instit = db_getsession('DB_instit');
    $anousu = $ano."-01-01";

    $result = db_query("

      CREATE TEMP TABLE data_final ON COMMIT DROP AS
      SELECT * FROM condataconf
      WHERE c99_anousu = $ano
        AND c99_instit = $instit;

      UPDATE condataconf
      SET c99_data = '$anousu'
      WHERE c99_anousu = $ano
        AND c99_instit = $instit;


      CREATE TEMP TABLE reduzidos_lanc ON COMMIT DROP AS
    SELECT * FROM conplanoexesaldo
    WHERE c68_anousu = $ano
        AND c68_mes IN
            (SELECT EXTRACT (MONTH FROM c69_data) AS c69_mes
             FROM conlancamval
             INNER JOIN conlancamemp ON c69_codlan = c75_codlan
             AND c75_numemp = $seq_emp)
        AND c68_reduz IN
            (SELECT c69_credito FROM conlancamval
             INNER JOIN conlancamemp ON c69_codlan = c75_codlan
             AND c75_numemp = $seq_emp
             UNION ALL
             SELECT c69_debito FROM conlancamval
             INNER JOIN conlancamemp ON c69_codlan = c75_codlan
             AND c75_numemp = $seq_emp);

    CREATE TEMP TABLE anula_emp ON COMMIT DROP AS
    SELECT * FROM empempenho
    WHERE e60_numemp = $seq_emp ;

    CREATE TEMP TABLE empenhos ON COMMIT DROP AS
    SELECT * FROM empempenho
    WHERE e60_anousu = $ano
      AND e60_numemp = $seq_emp;

    CREATE TEMP TABLE autoriza ON COMMIT DROP AS
         (SELECT * FROM empempaut
          WHERE e61_numemp IN
           (SELECT e60_numemp FROM empenhos));




    CREATE TEMPORARY TABLE w_matordem ON COMMIT DROP AS
    SELECT m52_codordem AS m51_codordem
    FROM matordemitem
    WHERE m52_numemp = $seq_emp;

    DELETE FROM matordemanu
    WHERE m53_codordem IN
        (SELECT m51_codordem
         FROM w_matordem);

    DELETE FROM matordemitemanu
    WHERE m36_matordemitem IN
        (SELECT m52_codlanc
         FROM matordemitem
         WHERE m52_codordem IN
             (SELECT m51_codordem
              FROM w_matordem));

    DELETE FROM matestoqueitemoc
    WHERE m73_codmatordemitem IN
        (SELECT m52_codlanc
         FROM matordemitem
         WHERE m52_codordem IN
             (SELECT m51_codordem
              FROM w_matordem));

    DELETE FROM matordemitem
    WHERE m52_codordem IN
        (SELECT m51_codordem
         FROM w_matordem);

    DELETE FROM empnotaord
    WHERE m72_codordem IN
        (SELECT m51_codordem
         FROM w_matordem);

    DELETE FROM protmatordem
    WHERE p104_codordem IN
            (SELECT m51_codordem
             FROM w_matordem);

    DELETE FROM matordem
    WHERE m51_codordem IN
        (SELECT m51_codordem
         FROM w_matordem);



    CREATE TEMPORARY TABLE w_lancamentos ON COMMIT DROP AS
    SELECT c70_codlan AS lancam
    FROM conlancam
    WHERE c70_codlan IN
        (SELECT c75_codlan FROM conlancamemp
         WHERE c75_numemp = $seq_emp);

    DELETE FROM conlancamcgm
    WHERE c76_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancamemp
    WHERE c75_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancamdot
    WHERE c73_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancamcompl
    WHERE c72_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancamdoc
    WHERE c71_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM contacorrentedetalheconlancamval
    WHERE c28_conlancamval IN
        (SELECT c69_sequen
         FROM conlancamval
          WHERE c69_codlan IN
            (SELECT lancam
             FROM w_lancamentos));

    DELETE FROM conlancamval
    WHERE c69_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancamele
    WHERE c67_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancamnota
    WHERE c66_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancampag
    WHERE c82_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancamord
    WHERE c80_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancamcorgrupocorrente
    WHERE c23_conlancam IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM pagordemdescontolanc
    WHERE e33_conlancam IN
        (SELECT lancam
         FROM w_lancamentos);


    DELETE FROM conlancamsup
    WHERE c79_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancamconcarpeculiar
    WHERE c08_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancaminstit
    WHERE c02_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancamordem
    WHERE c03_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancamacordo
    WHERE c87_codlan IN
        (SELECT lancam
         FROM w_lancamentos);

    DELETE FROM conlancam
    WHERE c70_codlan IN
        (SELECT lancam
         FROM w_lancamentos);



    CREATE TEMP TABLE w_notas ON COMMIT DROP AS
    SELECT * FROM empnota
    WHERE e69_numemp = $seq_emp;

    DELETE FROM empnotaele
    WHERE e70_codnota IN
        (SELECT e69_codnota
         FROM w_notas);

    DELETE
    FROM empnotaitembenspendente
    WHERE e137_empnotaitem IN
        (SELECT e72_sequencial
         FROM empnotaitem
         WHERE e72_codnota IN
            (SELECT e69_codnota
             FROM w_notas));

    DELETE FROM empnotaitem
    WHERE e72_codnota IN
        (SELECT e69_codnota
         FROM w_notas);

    DELETE FROM empnotaord
    WHERE m72_codnota IN
        (SELECT e69_codnota
         FROM w_notas);

    DELETE FROM matestoqueitemnota
    WHERE m74_codempnota IN
        (SELECT e69_codnota
         FROM w_notas);



    CREATE TEMP TABLE w_empenhos ON COMMIT DROP AS
    SELECT * FROM empempenho
    WHERE e60_numemp = $seq_emp;

    DELETE FROM empelemento
    WHERE e64_numemp IN
        (SELECT e60_numemp
         FROM w_empenhos);

    DELETE FROM empempaut
    WHERE e61_numemp IN
        (SELECT e60_numemp
         FROM w_empenhos);

    DELETE FROM empempenhonl
    WHERE e68_numemp IN
        (SELECT e60_numemp
         FROM w_empenhos);

    DELETE FROM empemphist
    WHERE e63_numemp IN
        (SELECT e60_numemp
         FROM w_empenhos);

    DELETE FROM empanuladoitem
    WHERE e37_empanulado IN
        (SELECT e94_codanu
         FROM empanulado
         WHERE e94_numemp IN
             (SELECT e60_numemp
              FROM w_empenhos));

    DELETE FROM empempitem
    WHERE e62_numemp IN
        (SELECT e60_numemp
         FROM w_empenhos);

    DELETE FROM empanuladoele
    WHERE e95_codanu IN
        (SELECT e94_codanu
         FROM empanulado
         WHERE e94_numemp IN
             (SELECT e60_numemp
              FROM w_empenhos));

    DELETE FROM empanulado
    WHERE e94_numemp IN
        (SELECT e60_numemp
         FROM w_empenhos);

    DELETE FROM empord
    WHERE e82_codord IN
        (SELECT e50_codord
         FROM pagordem
         WHERE e50_numemp IN
             (SELECT e60_numemp
              FROM w_empenhos));

    DELETE FROM pagordemnota
    WHERE e71_codord IN
        (SELECT e50_codord
         FROM pagordem
         WHERE e50_numemp IN
             (SELECT e60_numemp
              FROM w_empenhos));

    DELETE FROM pagordemele
    WHERE e53_codord IN
        (SELECT e50_codord
         FROM pagordem
         WHERE e50_numemp IN
             (SELECT e60_numemp
              FROM w_empenhos));

    DELETE FROM cairetordem
    WHERE k32_ordpag IN
        (SELECT e50_codord
         FROM pagordem
         WHERE e50_numemp IN
             (SELECT e60_numemp
              FROM w_empenhos));

    DELETE FROM issplanitop
    WHERE q96_pagordem IN
        (SELECT e50_codord
         FROM pagordem
         WHERE e50_numemp IN
             (SELECT e60_numemp
              FROM w_empenhos));

    DELETE FROM retencaocorgrupocorrente where e47_retencaoreceita in (SELECT e23_sequencial FROM retencaoreceitas
    WHERE e23_retencaopagordem IN
        (SELECT e20_sequencial
         FROM retencaopagordem
         WHERE e20_pagordem IN
             (SELECT e50_codord
              FROM pagordem
              WHERE e50_numemp IN
                  (SELECT e60_numemp
                   FROM w_empenhos))));

    DELETE FROM retencaoempagemov
    WHERE e27_retencaoreceitas IN
        (SELECT e23_sequencial
         FROM retencaoreceitas
         WHERE e23_retencaopagordem IN
             (SELECT e20_sequencial
              FROM retencaopagordem
              WHERE e20_pagordem IN
                  (SELECT e50_codord
                   FROM pagordem
                   WHERE e50_numemp IN
                       (SELECT e60_numemp
                        FROM w_empenhos))));

    DELETE FROM retencaoreceitas
    WHERE e23_retencaopagordem IN
        (SELECT e20_sequencial
         FROM retencaopagordem
         WHERE e20_pagordem IN
             (SELECT e50_codord
              FROM pagordem
              WHERE e50_numemp IN
                  (SELECT e60_numemp
                   FROM w_empenhos)));

    DELETE FROM retencaopagordem
    WHERE e20_pagordem IN
        (SELECT e50_codord
         FROM pagordem
         WHERE e50_numemp IN
             (SELECT e60_numemp
              FROM w_empenhos));

    DELETE FROM pagordemdesconto
    WHERE e34_codord IN
            (SELECT e50_codord
             FROM pagordem
             WHERE e50_numemp IN
                     (SELECT e60_numemp
                      FROM w_empenhos));

    DELETE FROM protpagordem
    WHERE p105_codord IN
            (SELECT e50_codord
             FROM pagordem
             WHERE e50_numemp IN
                     (SELECT e60_numemp
                      FROM w_empenhos));

    DELETE FROM autprotpagordem
    WHERE p107_codord IN
        (SELECT e50_codord
         FROM pagordem
         WHERE e50_numemp IN
             (SELECT e60_numemp
              FROM w_empenhos));

    DELETE FROM pagordemconta
    WHERE e49_codord IN
        (SELECT e50_codord
         FROM pagordem
         WHERE e50_numemp IN
            (SELECT e60_numemp
            FROM w_empenhos));                 

    DELETE FROM pagordem
    WHERE e50_codord IN
        (SELECT e50_codord
         FROM pagordem
         WHERE e50_numemp IN
             (SELECT e60_numemp
              FROM w_empenhos));

    DELETE FROM contacorrentesaldo
        WHERE c29_contacorrentedetalhe IN
            (SELECT c19_sequencial
              FROM contacorrentedetalhe
              WHERE c19_numemp IN
                (SELECT e60_numemp
                    FROM w_empenhos));

    DELETE FROM contacorrentedetalhe
        WHERE c19_numemp IN
              (SELECT e60_numemp
                FROM w_empenhos);

    DELETE FROM rhempenhofolhaempenho
        WHERE rh76_numemp IN
              (SELECT e60_numemp
                FROM w_empenhos);

    DELETE FROM empempenhofinalidadepagamentofundeb
    WHERE e152_numemp IN
            (SELECT e60_numemp
             FROM w_empenhos);

    DELETE FROM empnota
    WHERE e69_numemp = $seq_emp;

    DELETE FROM empempenhocontrato
    WHERE e100_numemp IN
        (SELECT e60_numemp
         FROM w_empenhos);

    DELETE FROM coremp
    WHERE k12_empen IN
            (SELECT e60_numemp
             FROM w_empenhos);

    DELETE FROM protempenhos
    WHERE p103_numemp IN
            (SELECT e60_numemp
             FROM w_empenhos);

    DELETE FROM empempenho
    WHERE e60_numemp IN
        (SELECT e60_numemp
         FROM w_empenhos);

    DELETE FROM empprestarecibo
    WHERE e170_emppresta IN
            (SELECT e45_sequencial FROM emppresta
             WHERE e45_numemp IN
                     (SELECT e60_numemp FROM w_empenhos));

    DELETE FROM empprestaitem
    WHERE e46_emppresta IN
            (SELECT e45_sequencial FROM emppresta
             WHERE e45_numemp IN
                     (SELECT e60_numemp FROM w_empenhos));

    DELETE FROM emppresta
    WHERE e45_numemp IN
            (SELECT e60_numemp FROM w_empenhos);



    DELETE FROM empautidot
    WHERE e56_autori IN
         (SELECT e61_autori
          FROM autoriza);

    DELETE FROM empautitempcprocitem
    WHERE e73_autori IN
         (SELECT e61_autori
          FROM autoriza);

    DELETE FROM acordoitemexecutadoempautitem
    WHERE ac19_autori IN
         (SELECT e61_autori
          FROM autoriza);

    DELETE FROM empautitem
    WHERE e55_autori IN
             (SELECT e61_autori
                FROM autoriza);

    DELETE FROM empempaut
    WHERE e61_autori IN
         (SELECT e61_autori
          FROM autoriza);

    DELETE FROM empauthist
    WHERE e57_autori IN
         (SELECT e61_autori
          FROM autoriza);

    DELETE FROM acordoempautoriza
    WHERE ac45_empautoriza IN
         (SELECT e61_autori
          FROM autoriza);

    DELETE FROM protempautoriza
    WHERE p102_autorizacao IN
            (SELECT e61_autori
             FROM autoriza);

    DELETE FROM empautorizaprocesso
    WHERE e150_empautoriza IN
            (SELECT e61_autori
             FROM autoriza);

    DELETE FROM empautoriza
    WHERE e54_autori IN
             (SELECT e61_autori
                FROM autoriza);



    DELETE FROM conplanoexesaldo
    USING reduzidos_lanc
    WHERE (reduzidos_lanc.c68_reduz, reduzidos_lanc.c68_anousu, reduzidos_lanc.c68_mes) = (conplanoexesaldo.c68_reduz, conplanoexesaldo.c68_anousu, conplanoexesaldo.c68_mes);

    CREATE TEMP TABLE landeb ON COMMIT DROP AS
    SELECT c69_anousu,
           c69_debito,
           to_char(c69_data,'MM')::integer,
           sum(round(c69_valor,2)),0::float8
    FROM conlancamval
    JOIN reduzidos_lanc ON (c69_debito, c69_anousu, EXTRACT (MONTH FROM c69_data)) = (c68_reduz, c68_anousu, c68_mes)
    GROUP BY c69_anousu, c69_debito, to_char(c69_data,'MM')::integer;

    CREATE TEMP TABLE lancre ON COMMIT DROP AS
    SELECT c69_anousu,
           c69_credito,
           to_char(c69_data,'MM')::integer,
           0::float8,
           sum(round(c69_valor,2))
    FROM conlancamval
    JOIN reduzidos_lanc ON (c69_credito, c69_anousu, EXTRACT (MONTH FROM c69_data)) = (c68_reduz, c68_anousu, c68_mes)
    GROUP BY c69_anousu, c69_credito, to_char(c69_data,'MM')::integer;

    INSERT INTO conplanoexesaldo
    SELECT * FROM landeb;

    UPDATE conplanoexesaldo
    SET c68_credito = lancre.sum
    FROM lancre
    WHERE c68_anousu = lancre.c69_anousu
        AND c68_reduz = lancre.c69_credito
        AND c68_mes = lancre.to_char
        AND c68_anousu = $ano;

    DELETE FROM lancre
    USING conplanoexesaldo
    WHERE lancre.c69_anousu = conplanoexesaldo.c68_anousu
        AND conplanoexesaldo.c68_reduz = lancre.c69_credito
        AND conplanoexesaldo.c68_mes = lancre.to_char
        AND c68_anousu = $ano;

    INSERT INTO conplanoexesaldo
    SELECT * FROM lancre
    WHERE c69_anousu = $ano;

    UPDATE condataconf
    SET c99_data = (SELECT data_final.c99_data FROM data_final)
    WHERE c99_anousu = $ano
      AND c99_instit = $instit;

    ");


     if($result===false){
       echo @pg_last_error();exit;
     }

     $this->erro_msg = "";
     $this->erro_msg = "Exclusão efetuada com Sucesso\\n";

     $resmanut = db_query("select nextval('db_manut_log_manut_sequencial_seq') as seq");
     $seq   = pg_result($resmanut,0,0);
     $result = db_query("insert into db_manut_log values($seq,'Empenho: ".$seq_emp."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");

     return true;

    }

}
?>
