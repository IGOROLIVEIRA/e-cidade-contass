
drop function fc_recibo(integer,date,date,integer);
drop   type tp_recibo;

create type tp_recibo as ( rvMensagem varchar(100),
                           rlErro     boolean );
                           
create or replace function fc_recibo(integer,date,date,integer) returns tp_recibo  as 
$$
DECLARE
  NUMPRE  ALIAS FOR $1;
  DTEMITE ALIAS FOR $2;
  DTVENC  ALIAS FOR $3;
  ANOUSU  ALIAS FOR $4;
 
  iFormaCorrecao integer default 2;
  iInstit        integer;
  iExerc         integer;

  UNICA         BOOLEAN := FALSE;
  NUMERO_ERRO   char(200);    
  NUMCGM        INTEGER;
  RECORD_NUMPRE  RECORD;
  RECORD_ALIAS   RECORD;
  RECORD_GRAVA   RECORD;
  RECORD_NUMPREF RECORD;
  RECORD_UNICA   RECORD;

  VALOR_RECEITA     FLOAT8;
  VALOR_RECEITA_ORI FLOAT8;
  DESC_VALOR_RECEITA    FLOAT8 DEFAULT 0;

    VALOR_RECEITAORI FLOAT8;
  
  CORRECAO      FLOAT8 DEFAULT 0;
  DESC_CORRECAO FLOAT8 DEFAULT 0;
    CORRECAOORI     FLOAT8;
  JURO          FLOAT8 DEFAULT 0;
  MULTA         FLOAT8 DEFAULT 0;
  vlrjuroparc   FLOAT8 DEFAULT 0;
  vlrmultapar   FLOAT8 DEFAULT 0;
  DESCONTO      FLOAT8;
  nDescontoCorrigido float8 default 0;

  RECEITA       INTEGER;
  K03_RECMUL    INTEGER;
  K03_RECJUR    INTEGER;
  V_K00_HIST    INTEGER;
  QUAL_OPER     INTEGER;

  DTOPER        DATE;
  DATAVENC      DATE;
  SQLRECIBO     VARCHAR(400);

  VLRJUROS      FLOAT8 default 0;
  VLRMULTA      FLOAT8 default 0;
  VLRDESCONTO   FLOAT8 default 0;

  V_CADTIPOPARC     INTEGER;
  V_CADTIPOPARC_FORMA INTEGER;
  NUMPAR        INTEGER;
  NUMTOT        INTEGER;
  NUMDIG        INTEGER;
  ARRETIPO      INTEGER;
  PROCESSA      BOOLEAN DEFAULT FALSE;
  ISSQNVARIAVEL BOOLEAN;
  CODBCO        INTEGER;
  CODAGE        CHAR(5);
  NUMBCO        VARCHAR(15);
  RECEITA_JUR   INTEGER;
  RECEITA_MUL   INTEGER;
  iTipoVlr      INTEGER;

  PERCDESCJUR   FLOAT8 DEFAULT 0;
  PERCDESCMUL   FLOAT8 DEFAULT 0;
  PERCDESCVLR   FLOAT8 DEFAULT 0;

  nPercArreDesconto FLOAT8 DEFAULT 0;

  v_composicao record;

  nComposCorrecao   numeric(15,2) default 0;
  nComposJuros      numeric(15,2) default 0;
  nComposMulta      numeric(15,2) default 0;

  nCorreComposJuros numeric(15,2) default 0;
  nCorreComposMulta numeric(15,2) default 0;

  rtp_recibo    tp_recibo%ROWTYPE;
  
  TOTPERC       FLOAT8;
  TEM_DESCONTO  INTEGER DEFAULT 0;

    v_raise boolean default false;
    lParcelamento boolean default false;

BEGIN
  
  v_raise := ( case when fc_getsession('DB_debugon') is null then false else true end );
  
  select cast( fc_getsession('DB_instit') as integer ) 
    into iInstit;

  select cast( fc_getsession('DB_anousu') as integer ) 
    into iExerc;
    
  select k03_separajurmulparc
    into iFormaCorrecao
    from numpref
   where k03_instit = iInstit
     and k03_anousu = iExerc;

  FOR RECORD_NUMPREF IN SELECT * FROM NUMPREF WHERE K03_ANOUSU = ANOUSU LOOP
    RECEITA_JUR := RECORD_NUMPREF.K03_RECJUR;
    RECEITA_MUL := RECORD_NUMPREF.K03_RECMUL;
  END LOOP;
  
  SELECT K00_NUMPRE 
  INTO NUMERO_ERRO
  FROM RECIBO 
  WHERE K00_NUMNOV = NUMPRE LIMIT 1;
  IF NUMERO_ERRO IS NULL THEN
    SELECT 1 
    INTO NUMERO_ERRO
    FROM DB_RECIBOWEB 
    WHERE K99_NUMPRE_N = NUMPRE LIMIT 1;
    IF NOT NUMERO_ERRO IS NULL THEN
      FOR RECORD_NUMPRE IN SELECT * 
        FROM DB_RECIBOWEB
        WHERE K99_NUMPRE_N = NUMPRE LOOP
        CODBCO = RECORD_NUMPRE.K99_CODBCO;
        CODAGE = RECORD_NUMPRE.K99_CODAGE;
--        NUMBCO = RECORD_NUMPRE.K99_NUMBCO;

        select fc_numbcoconvenio(NUMBCO::integer) into NUMBCO;
        
        TEM_DESCONTO = RECORD_NUMPRE.K99_DESCONTO;

        if v_raise is true then
          raise info 'TEM_DESCONTO: %', TEM_DESCONTO;
        end if;
        
        FOR RECORD_UNICA IN 
          SELECT DISTINCT 
                 K00_NUMPRE,
                 K00_NUMPAR 
            FROM ARRECAD
           WHERE K00_NUMPRE = RECORD_NUMPRE.K99_NUMPRE 
             AND CASE 
                   WHEN RECORD_NUMPRE.K99_NUMPAR = 0 THEN 
                     TRUE 
                   ELSE 
                     K00_NUMPAR = RECORD_NUMPRE.K99_NUMPAR 
                 END
          
          LOOP
          
          PROCESSA := TRUE;

          IF RECORD_NUMPRE.K99_NUMPAR = 0 THEN
            UNICA := TRUE;
          ELSE
            IF RECORD_NUMPRE.K99_NUMPAR != RECORD_UNICA.K00_NUMPAR THEN
              PROCESSA := FALSE;
            END IF;
          END IF;
          
          NUMPAR := RECORD_UNICA.K00_NUMPAR;

          if v_raise is true then
            raise info 'numpre: % - numpar: % - processa: %', RECORD_NUMPRE.K99_NUMPRE, RECORD_NUMPRE.K99_NUMPAR, PROCESSA;
          end if;

          IF PROCESSA = TRUE THEN
     
            if v_raise is true then
              raise info 'NUMPAR: %', NUMPAR;
            end if;
          
            FOR RECORD_ALIAS IN 
                SELECT K00_RECEIT,
                       k00_HIST,  
                       K00_DTOPER,
                       K00_NUMCGM,
                       fc_calculavenci(k00_numpre,k00_numpar,K00_DTVENC,DTEMITE) AS K00_DTVENC,
                       K00_NUMPRE,
                       K00_NUMPAR,
                       SUM(round(K00_VALOR,2)) AS K00_VALOR,
--                       K00_VALOR,

                       K00_TIPO
                  FROM ARRECAD
                 WHERE K00_NUMPRE = RECORD_NUMPRE.K99_NUMPRE 
                   AND K00_NUMPAR = NUMPAR
                 group by
                       K00_RECEIT,
                       k00_HIST,
                       K00_DTOPER,
                       K00_NUMCGM,
                       fc_calculavenci(k00_numpre,k00_numpar,K00_DTVENC,DTEMITE),
                       K00_NUMPRE,
                       K00_NUMPAR,
                       K00_TIPO 
              ORDER BY K00_NUMPRE,K00_NUMPAR,K00_RECEIT, k00_hist 
            LOOP

              PROCESSA := TRUE;
              RECEITA  := RECORD_ALIAS.K00_RECEIT;
              ARRETIPO := RECORD_ALIAS.K00_TIPO;
              DTOPER   := RECORD_ALIAS.K00_DTOPER;
              NUMCGM   := RECORD_ALIAS.K00_NUMCGM;
              DATAVENC := RECORD_ALIAS.K00_DTVENC;
              VALOR_RECEITA := RECORD_ALIAS.K00_VALOR;
              IF VALOR_RECEITA = 0 THEN
                SELECT Q05_VLRINF
                INTO VALOR_RECEITA
                FROM ISSVAR WHERE Q05_NUMPRE = RECORD_ALIAS.K00_NUMPRE AND
                Q05_NUMPAR = RECORD_ALIAS.K00_NUMPAR;
                IF VALOR_RECEITA IS NULL THEN
                  VALOR_RECEITA := 0;
                ELSE
                  ISSQNVARIAVEL := TRUE;
                END IF;
              END IF;
              QUAL_OPER := 0;
              -- T24879: Se valor da receita nao for 0 (zero) ou 
              -- recibo for proveniente de uma emissao geral de iss variavel
              -- continua geracao da recibopaga
              IF VALOR_RECEITA <> 0 OR RECORD_NUMPRE.K99_TIPO = 6 THEN
                FOR RECORD_GRAVA IN SELECT * FROM ARRECAD 
                  WHERE K00_NUMPRE = RECORD_NUMPRE.K99_NUMPRE AND 
                  K00_NUMPAR = NUMPAR AND 
                  K00_RECEIT = RECEITA LOOP
                  IF QUAL_OPER = 0 THEN
                    V_K00_HIST := RECORD_GRAVA.K00_HIST;
                    NUMTOT := RECORD_GRAVA.K00_NUMTOT;
                    NUMDIG  := RECORD_GRAVA.K00_NUMDIG;
                    QUAL_OPER := 1;
                  END IF;
                END LOOP;
-- CALCULA CORRECAO 
                IF VALOR_RECEITA <> 0 THEN 

                  if iFormaCorrecao = 1 then

                    VALOR_RECEITA_ORI = VALOR_RECEITA;

                    if v_raise is true then
                      raise notice 'VALOR_RECEITA_ORI: %', VALOR_RECEITA_ORI;
                      raise notice 'fc_retornacomposicao(%,%,%,%,%,%,%,%)', record_alias.k00_numpre, record_alias.k00_numpar, record_alias.k00_receit,record_alias.k00_hist, dtoper, dtvenc, anousu, datavenc;
                    end if;

                    select rnCorreComposJuros, rnCorreComposMulta, rnComposCorrecao, rnComposJuros, rnComposMulta
                    into nCorreComposJuros, nCorreComposMulta, nComposCorrecao, nComposJuros, nComposMulta
                    from fc_retornacomposicao(record_alias.k00_numpre, record_alias.k00_numpar, record_alias.k00_receit, record_alias.k00_hist, dtoper, dtvenc, anousu, datavenc);

                    if v_raise is true then
                      raise notice '1=nComposCorrecao: % - VALOR_RECEITA: %', nComposCorrecao, VALOR_RECEITA;
                    end if;
                    valor_receita = valor_receita + nComposCorrecao;
                    if v_raise is true then
                      raise notice '2=nComposCorrecao: % - VALOR_RECEITA: %', nComposCorrecao, VALOR_RECEITA;
                    end if;

                    CORRECAO := ROUND( FC_CORRE(RECEITA,DTOPER,VALOR_RECEITA,DTVENC,ANOUSU,DATAVENC) , 2 );

                    if v_raise is true then
                      raise notice 'CORRECAO 1: %', CORRECAO;
                    end if;

                    CORRECAO := ROUND( CORRECAO - VALOR_RECEITA + nComposCorrecao, 2 );

                    if v_raise is true then
                      raise notice 'CORRECAO 2: % - nCorreComposJuros: % - nCorreComposMulta: %', CORRECAO, nCorreComposJuros, nCorreComposMulta;
                    end if;

                    correcao := correcao + nCorreComposJuros + nCorreComposMulta;

                    if v_raise is true then
                      raise notice 'VALOR_RECEITA: % - CORRECAO 3: %', VALOR_RECEITA, CORRECAO;
                    end if;

                    VALOR_RECEITA = VALOR_RECEITA_ORI;

                  else
                    CORRECAO := ROUND( FC_CORRE(RECEITA,DTOPER,VALOR_RECEITA,DTVENC,ANOUSU,DATAVENC) - VALOR_RECEITA , 2 );
                  end if;

                ELSE
                  CORRECAO := 0;
                END IF;

                --raise notice 'TEM_DESCONTO: %', TEM_DESCONTO;

                IF TEM_DESCONTO > 0 THEN
                  
                  if v_raise is true then
                    raise info 'DTVENC: %', DTVENC;
                  end if;
                  
                  select descjur, descmul, descvlr, k40_codigo, k40_forma, tipovlr 
                    into percdescjur, percdescmul, percdescvlr, v_cadtipoparc, v_cadtipoparc_forma, iTipoVlr
                    from cadtipoparc 
                         inner join tipoparc on tipoparc.cadtipoparc = cadtipoparc.k40_codigo
                  where DTEMITE between k40_dtini and k40_dtfim 
                     and maxparc = 1 
--                    and k40_aplicacao = 1 
                     and k40_codigo = TEM_DESCONTO;

                   --raise notice 'iTipoVlr: %', iTipoVlr;
                  
                END IF;
                
                if v_raise is true then
                  raise info 'CORRECAO %-%-%-%-%-',receita,dtoper,valor_receita,datavenc,dtvenc;
                end if;

                CORRECAOORI      := CORRECAO;
                VALOR_RECEITAORI := VALOR_RECEITA;
--
--
--  Trabalhar neste if para utilizar a mesma logica da recibodesconto
--   alterar o programa de emissao de recibo para selecionar 
--   a regra se o contribuinte for ou nao loteador
--

-- raise notice 'percdescvlr : % ',percdescvlr;
                perform v07_numpre 
                   from termo 
                  where v07_numpre = RECORD_NUMPRE.K99_NUMPRE;
                if found then 
                  lParcelamento := true;
                end if;

--               raise notice 'K99_NUMPRE : %',RECORD_NUMPRE.K99_NUMPRE;
                if not lParcelamento or 1=1 then

                  if percdescvlr is not null and percdescvlr > 0 then
                    
                    if iTipoVlr = 1 then

                      DESC_CORRECAO := ROUND(CORRECAO * percdescvlr / 100,2);
                      if v_raise is true then
                        raise info 'desconto na correcao 2: % (-%) - VALOR_RECEITA: % - PERCENTUAL: %', CORRECAO, DESC_CORRECAO, VALOR_RECEITA, percdescvlr;
                      end if;
                      if DESC_CORRECAO > 0 then
                        --
                        INSERT INTO RECIBOPAGA (k00_numcgm,k00_dtoper,k00_receit,k00_hist,k00_valor,k00_dtvenc,k00_numpre,k00_numpar,k00_numtot,k00_numdig,k00_conta,k00_dtpaga,k00_numnov ) 
                             VALUES (NUMCGM,DTEMITE,RECEITA,918,(DESC_CORRECAO*-1),DATAVENC,RECORD_NUMPRE.K99_NUMPRE,NUMPAR,NUMTOT,NUMDIG,0,DTEMITE,NUMPRE);
                      end if;
                    elsif iTipoVlr = 2 then
                      nDescontoCorrigido := ROUND((VALOR_RECEITA + CORRECAO) * percdescvlr / 100,2);
                      if v_raise is true then
                        raise info 'desconto na correcao 2: % (-%) - VALOR_RECEITA: % - PERCENTUAL: %', CORRECAO, DESC_CORRECAO, VALOR_RECEITA, percdescvlr;
                      end if;
                      if nDescontoCorrigido > 0 then
                        --
                        INSERT INTO RECIBOPAGA (k00_numcgm,k00_dtoper,k00_receit,k00_hist,k00_valor,k00_dtvenc,k00_numpre,k00_numpar,k00_numtot,k00_numdig,k00_conta,k00_dtpaga,k00_numnov ) 
                             VALUES (NUMCGM,DTEMITE,RECEITA,918,(nDescontoCorrigido*-1),DATAVENC,RECORD_NUMPRE.K99_NUMPRE,NUMPAR,NUMTOT,NUMDIG,0,DTEMITE,NUMPRE);
                      end if;
                    end if;

                    -- Se a forma de aplicacao da regra for pra loteamentos (= 3)
                    -- entao aplica desconto no valor da receita (historico)
                    if v_cadtipoparc_forma = 3 then
                      DESC_VALOR_RECEITA := ROUND(VALOR_RECEITA * percdescvlr / 100,2);
                      if DESC_VALOR_RECEITA > 0 then
                        if v_raise is true then
                          raise notice 'desconto (3) - DESC_VALOR_RECEITA: %', DESC_VALOR_RECEITA;
                        end if;
                        --
                        INSERT INTO RECIBOPAGA (k00_numcgm,k00_dtoper,k00_receit,k00_hist,k00_valor,k00_dtvenc,k00_numpre,k00_numpar,k00_numtot,k00_numdig,k00_conta,k00_dtpaga,k00_numnov)
                             VALUES (NUMCGM,DTEMITE,RECEITA,918,(DESC_VALOR_RECEITA*-1),DATAVENC,RECORD_NUMPRE.K99_NUMPRE,NUMPAR,NUMTOT,NUMDIG,0,DTEMITE,NUMPRE);
                      end if;
                    end if;

                    if v_raise is true then
                      raise info 'desconto na correcao 2: % - VALOR_RECEITA: %', CORRECAO, VALOR_RECEITA;
                    end if;
                    
                  end if;

                end if;

/** 
 * final na manutencao
 *
 */
                if v_raise is true then
                  raise info '   1 - juro: % - descjur: % - multa: % - descmul: % - descvlr: % - correcao: % - VALOR_RECEITA: % - cadtipoparc: %', JURO, percdescjur, MULTA, percdescmul, percdescvlr, CORRECAO, VALOR_RECEITA, V_cadtipoparc;
                end if;
                
                -- T24879: Se valor diferente de zero ou tipo recibo for da emissao geral do iss
                -- gera recibopaga normalmente
                IF (VALOR_RECEITA + CORRECAO) <> 0 OR RECORD_NUMPRE.K99_TIPO = 6 THEN
                  INSERT INTO RECIBOPAGA (
                    k00_numcgm, 
                    k00_dtoper, 
                    k00_receit, 
                    k00_hist  , 
                    k00_valor , 
                    k00_dtvenc, 
                    k00_numpre, 
                    k00_numpar, 
                    k00_numtot, 
                    k00_numdig, 
                    k00_conta , 
                    k00_dtpaga, 
                    k00_numnov 
                  ) VALUES (
                    NUMCGM,
                    DTEMITE,
                    RECEITA,
                    V_K00_HIST + 100,
                    ROUND(VALOR_RECEITA+CORRECAO,2),
                    DATAVENC,
                    RECORD_NUMPRE.K99_NUMPRE,
                    NUMPAR,
                    NUMTOT,
                    NUMDIG,
                    0,
                    DTEMITE,
                    NUMPRE
                  );     

-- CALCULA DESCONTO DA ARREDESCONTO 
                 if lParcelamento then

                    -- Verifica desconto
                    nPercArreDesconto := fc_recibodesconto(RECORD_NUMPRE.K99_NUMPRE,
                                                           NUMPAR,
                                                           NUMTOT,
                                                           RECEITA,
                                                           ARRETIPO,
                                                           DTEMITE,
                                                           DATAVENC);
                    if nPercArreDesconto > 0 then

                      if v_raise is true then
                        raise notice 'desconto (4) - nPercArreDesconto: %',nPercArreDesconto;
                      end if;

                      INSERT INTO RECIBOPAGA (
                        k00_numcgm, 
                        k00_dtoper, 
                        k00_receit, 
                        k00_hist  , 
                        k00_valor , 
                        k00_dtvenc, 
                        k00_numpre, 
                        k00_numpar, 
                        k00_numtot, 
                        k00_numdig, 
                        k00_conta , 
                        k00_dtpaga, 
                        k00_numnov 
                      ) VALUES (
                        NUMCGM,
                        DTEMITE,
                        RECEITA,
                        918,
                        -- round( ( ( ( VALOR_RECEITA + CORRECAO * nPercArreDesconto) / 100) * -1 ) + JURO ,2),
                        ROUND(((ROUND(VALOR_RECEITA+CORRECAO,2) * nPercArreDesconto)/100),2) * -1,
                        DATAVENC,
                        RECORD_NUMPRE.K99_NUMPRE,
                        NUMPAR,
                        NUMTOT,
                        NUMDIG,
                        0,
                        DTEMITE,
                        NUMPRE
                      ); 

                    end if;
                  end if;

                END IF;
-- CALCULA JUROS
                IF (VALOR_RECEITAORI + CORRECAOORI) <> 0 THEN

                  -- ALTEREI AQUI
                  if v_raise is true then
                    raise notice 'VALOR_RECEITAORI: %', VALOR_RECEITAORI;
                  end if;
                  if iFormaCorrecao = 1 then
                    JURO  := ROUND(( VALOR_RECEITAORI + CORRECAO ) * FC_JUROS(RECEITA,DATAVENC,DTEMITE,DTOPER,FALSE,ANOUSU),2 );
                  else
                    JURO  := ROUND(( CORRECAOORI+VALOR_RECEITAORI) * FC_JUROS(RECEITA,DATAVENC,DTEMITE,DTOPER,FALSE,ANOUSU),2 );
                  end if;
                  if v_raise is true then
                    raise notice 'JURO: % - nComposJuros: % - valor para calcular juros: 1: % - 2: %', JURO, nComposJuros, CORRECAOORI, VALOR_RECEITAORI;
                  end if;
                  JURO = JURO + nComposJuros;
-- CALCULA MULTA
                  if iFormaCorrecao = 1 then
                    MULTA := round( (VALOR_RECEITAORI + CORRECAO )::numeric(15,2) * FC_MULTA(RECEITA,DATAVENC,DTEMITE,DTOPER,ANOUSU)::numeric(15,5) ,2);
                  else
                    MULTA := ROUND(( CORRECAOORI+VALOR_RECEITAORI)::numeric(15,2) * FC_MULTA(RECEITA,DATAVENC,DTEMITE,DTOPER,ANOUSU)::numeric(15,5),2 );
                  end if;
                  if v_raise is true then
                    raise notice 'MULTA: % - nComposMulta: % - valor para calcular juros: 1: % - 2: %', MULTA, nComposMulta, CORRECAOORI, VALOR_RECEITAORI;
                    raise notice 'CORRECAO: %', CORRECAO;
                  end if;
                  MULTA = MULTA + nComposMulta;
                  
                  SELECT K02_RECMUL, K02_RECJUR
                  INTO K03_RECMUL,K03_RECJUR
                  FROM TABREC 
                  WHERE K02_CODIGO = RECEITA;
                  
                  IF K03_RECMUL IS NULL THEN
                    K03_RECMUL := RECEITA_MUL;
                  END IF;
                  IF K03_RECJUR IS NULL THEN
                    K03_RECJUR := RECEITA_JUR;
                  END IF;
-- INCLUIDO VARIAVEL DESCONTO NO DB_RECIBOWEB
                  
                  if percdescjur is not null and percdescmul is not null and (nPercArreDesconto is null or nPercArreDesconto <= 0) then
                    vlrjuroparc := (ROUND(cast(JURO as FLOAT8) * percdescjur / 100,2));

                    if v_raise is true then
                      raise notice 'desconto (5) - vlrjuroparc: %', vlrjuroparc;
                    end if;

                    if vlrjuroparc > 0 then
                      INSERT INTO RECIBOPAGA (
                      k00_numcgm, 
                      k00_dtoper, 
                      k00_receit, 
                      k00_hist  , 
                      k00_valor , 
                      k00_dtvenc, 
                      k00_numpre, 
                      k00_numpar, 
                      k00_numtot, 
                      k00_numdig, 
                      k00_conta , 
                      k00_dtpaga, 
                      k00_numnov 
                      ) VALUES (
                      NUMCGM,
                      DTEMITE,
                      K03_RECJUR,
                      918,
                      (vlrjuroparc * -1),
                      DATAVENC,
                      RECORD_NUMPRE.K99_NUMPRE,
                      NUMPAR,
                      NUMTOT,
                      NUMDIG,
                      0,
                      DTEMITE,
                      NUMPRE
                      ); 
                    end if;  
                    vlrmultapar := (ROUND(cast(MULTA as FLOAT8) * percdescmul / 100,2));
                    if vlrmultapar > 0  then 
                      if v_raise is true then
                        raise notice 'desconto (6) - vlrmultapar: %', vlrmultapar;
                      end if;
                      INSERT INTO RECIBOPAGA (
                      k00_numcgm, 
                      k00_dtoper, 
                      k00_receit, 
                      k00_hist  , 
                      k00_valor , 
                      k00_dtvenc, 
                      k00_numpre, 
                      k00_numpar, 
                      k00_numtot, 
                      k00_numdig, 
                      k00_conta , 
                      k00_dtpaga, 
                      k00_numnov 
                      ) VALUES (
                      NUMCGM,
                      DTEMITE,
                      K03_RECJUR,
                      918,
                      (vlrmultapar * -1),
                      DATAVENC,
                      RECORD_NUMPRE.K99_NUMPRE,
                      NUMPAR,
                      NUMTOT,
                      NUMDIG,
                      0,
                      DTEMITE,
                      NUMPRE
                      ); 
                     end if;
                  end if;
                  
                  if v_raise is true then
                    raise info '   2 - juro: % - descjur: % - multa: % - descmul: % - correcao: % - VALOR_RECEITA: %', JURO, percdescjur, MULTA, percdescmul, CORRECAO, VALOR_RECEITA;
                  end if;
                  
                  IF K03_RECJUR = 0 OR K03_RECMUL = 0 OR K03_RECJUR = K03_RECMUL THEN
                    IF JURO+MULTA <> 0 THEN
                      VLRJUROS := VLRJUROS + JURO;
                      VLRMULTA := VLRMULTA + MULTA;
                      if v_raise is true then
                        raise notice ' valor total juros + multa (7) - %', JURO+MULTA;
                      end if;
                      INSERT INTO RECIBOPAGA (
                      k00_numcgm, 
                      k00_dtoper, 
                      k00_receit, 
                      k00_hist  , 
                      k00_valor , 
                      k00_dtvenc, 
                      k00_numpre, 
                      k00_numpar, 
                      k00_numtot, 
                      k00_numdig, 
                      k00_conta , 
                      k00_dtpaga, 
                      k00_numnov 
                      ) VALUES (
                      NUMCGM,
                      DTEMITE,
                      K03_RECJUR,
                      400,
                      ROUND(JURO+MULTA,2),
                      DATAVENC,
                      RECORD_NUMPRE.K99_NUMPRE,
                      NUMPAR,
                      NUMTOT,
                      NUMDIG,
                      0,
                      DTEMITE,
                      NUMPRE
                      );     
                    END IF;
                  ELSE
                    IF JURO <> 0 THEN
                      VLRJUROS := VLRJUROS + JURO;
                      INSERT INTO RECIBOPAGA (
                      k00_numcgm, 
                      k00_dtoper, 
                      k00_receit, 
                      k00_hist  , 
                      k00_valor , 
                      k00_dtvenc, 
                      k00_numpre, 
                      k00_numpar, 
                      k00_numtot, 
                      k00_numdig, 
                      k00_conta , 
                      k00_dtpaga, 
                      k00_numnov 
                      ) VALUES (
                      NUMCGM,
                      DTEMITE,
                      K03_RECJUR,
                      400,
                      ROUND(JURO,2),
                      DATAVENC,
                      RECORD_NUMPRE.K99_NUMPRE,
                      NUMPAR,
                      NUMTOT,
                      NUMDIG,
                      0,
                      DTEMITE,
                      NUMPRE
                      );   
                      
                    END IF;
                    IF MULTA <> 0 THEN
                      VLRMULTA := VLRMULTA + MULTA;
                      INSERT INTO RECIBOPAGA (
                      k00_numcgm, 
                      k00_dtoper, 
                      k00_receit, 
                      k00_hist  , 
                      k00_valor , 
                      k00_dtvenc, 
                      k00_numpre, 
                      k00_numpar, 
                      k00_numtot, 
                      k00_numdig, 
                      k00_conta , 
                      k00_dtpaga, 
                      k00_numnov 
                      ) VALUES (
                      NUMCGM,
                      DTEMITE,
                      K03_RECMUL,
                      401,
                      ROUND(MULTA,2),
                      DATAVENC,
                      RECORD_NUMPRE.K99_NUMPRE,
                      NUMPAR,
                      NUMTOT,
                      NUMDIG,
                      0,
                      DTEMITE,
                      NUMPRE
                      );     
                    END IF;
                  END IF;
--CALCULAR DESCONTO
                  IF CORRECAOORI+VALOR_RECEITAORI <> 0 THEN
                    DESCONTO := FC_DESCONTO(RECEITA,DTEMITE,CORRECAOORI+VALOR_RECEITAORI,JURO+MULTA,UNICA,DATAVENC,ANOUSU,RECORD_NUMPRE.K99_NUMPRE);
                    IF DESCONTO <> 0 THEN
                      VLRDESCONTO := VLRDESCONTO + DESCONTO;
                      if v_raise is true then
                        raise notice 'desconto (8) - %', DESCONTO;
                      end if;
                      INSERT INTO RECIBOPAGA (
                      k00_numcgm, 
                      k00_dtoper, 
                      k00_receit, 
                      k00_hist  , 
                      k00_valor , 
                      k00_dtvenc, 
                      k00_numpre, 
                      k00_numpar, 
                      k00_numtot, 
                      k00_numdig, 
                      k00_conta , 
                      k00_dtpaga, 
                      k00_numnov 
                      ) VALUES (
                      NUMCGM,
                      DTEMITE,
                      RECEITA,
                      918,
                      ROUND(DESCONTO*-1,2),
                      DATAVENC,
                      RECORD_NUMPRE.K99_NUMPRE,
                      NUMPAR,
                      NUMTOT,
                      NUMDIG,
                      0,
                      DTEMITE,
                      NUMPRE
                      );     
                    END IF;
                  END IF;
                END IF;  
              ELSE
                rtp_recibo.rvMensagem    := '1 - Erro ao gerar recibo. Contate suporte!';
                rtp_recibo.rlErro        := true;
                RETURN rtp_recibo;
--              RETURN '2 erro 1';     
              END IF; 
            END LOOP;
          END IF;
        END LOOP;
      END LOOP;
    ELSE
        rtp_recibo.rvMensagem    := '2 - Erro ao gerar recibo. Contate suporte!';
        rtp_recibo.rlErro        := true;
        RETURN  rtp_recibo;
--      RETURN '2 erro 2';
    END IF;
    
    IF PROCESSA = TRUE THEN
      
      INSERT INTO ARREBANCO (
      k00_numpre,
      k00_numpar, 
      k00_codbco, 
      k00_codage, 
      k00_numbco
      ) VALUES (
      NUMPRE,
      0,
      CODBCO,
      CODAGE,
      NUMBCO);
      
      perform k00_receit,
              round(sum(k00_valor),2)
          from recibopaga
        where k00_numnov = NUMPRE
        group by k00_receit
       having round(sum(k00_valor),2) < 0;

      if found then
        rtp_recibo.rlErro     := true;
        rtp_recibo.rvMensagem := 'Recibo com registros negativos por receita. Contate suporte!';
      else      
        rtp_recibo.rlErro     := false;
        rtp_recibo.rvMensagem := '';
      end if;

      RETURN rtp_recibo;
--   RETURN '1';
    ELSE
        rtp_recibo.rvMensagem    := '3 - Erro ao gerar recibo. Contate suporte!';
        rtp_recibo.rlErro        := true;
        RETURN  rtp_recibo;
--      RETURN '2 erro 3';
    END IF;
  ELSE
      rtp_recibo.rvMensagem    := '4 - Erro ao gerar recibo. Contate suporte!';
      rtp_recibo.rlErro        := true;
      RETURN  rtp_recibo;
--    RETURN '2 erro 4';
  END IF;
END;
$$ language 'plpgsql';  