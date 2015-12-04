-- quando reparcelar um parcelamento que e de 3 matriculas, tem que gerar 3 arrematric do novo numpre
-- revisar bem parcelamento de diversos e melhorias
-- considera-se que nao pode se parcelar inicial com outro tipo de debito, mesmo que seja outro parcelamento de inicial,
-- mas podemos parcelar mais de uma inicial no mesmo parcelamento, por isso que existe a tabela termoini

-- tipos de testes
-- parcelar um diversos
-- reparcelar um diversos
-- parcelar 2 diversos, um de cada procedencia
-- parcelar 1 diversos e um parcelamento de diversos

drop function fc_parcelamento(integer,date,date,integer,integer,float8,integer,integer,integer,integer,float8,float8);

set check_function_bodies to on;
create or replace function fc_parcelamento(integer,date,date,integer,integer,float8,integer,integer,integer,integer,float8,float8,text,integer)
returns varchar(100)
as $$
declare
  
  v_cgmresp                 alias for $1;  -- cgm do responsavel pelo parcelamento
  v_privenc                 alias for $2;  -- vencimento da entrada
  v_segvenc                 alias for $3;  -- vencimento da parcela 2
  v_diaprox                 alias for $4;  -- dia de vencimento da parcela 3 em diante
  v_totparc                 alias for $5;  -- total de parcelas
  v_entrada                 alias for $6;  -- valor da entrada
  v_login                   alias for $7;  -- login de quem fez o parcelamento
  v_cadtipo                 alias for $8;  -- tipo de debito dos registros selecionados
  v_desconto                alias for $9;  -- regra de parcelamento utilizada
  v_temdesconto             alias for $10; -- se tem desconto (nao utilizada)
  v_valorparcela            alias for $11; -- valor de cada parcela
  v_valultimaparcela        alias for $12; -- valor da ultima parcela

  sObservacao               alias for $13; -- observacao do parcelamento
  iProcesso                 alias for $14; -- codigo do processo (protprocesso)
  
  v_ultparc                 integer default 2;
  v_matric                  integer default 0;
  v_inscr                   integer default 0;

  iUltMatric                integer;
  iUltNumpre                integer;
  iUltNumpar                integer;
  iUltReceit                integer;

  iSeqArrecKey              integer;
  iSeqArrecadcompos         integer;

  v_anousu                  integer;
  v_totpar                  integer;
  v_recnew                  integer;
  v_numpreold               integer;
  v_contanumpre             integer;
  v_cgmpri                  integer;
  v_somar1                  integer;
  v_somar2                  integer;
  v_numpre                  integer;
  v_numpar                  integer;
  v_receita                 integer;
  v_proced                  integer;
  v_procura                 integer;
  v_termo                   integer;
  v_termo_ori               integer;
  v_tottipo                 integer;
  v_tipo                    integer;
  v_tiponovo                integer;
  v_quantparcel             integer;
  v_quantachou              integer;
  v_var                     integer;
  v_inicialmov              integer;
  v_totparcdestarec         integer;
  v_contador                integer;
  v_cadtipoparcdeb          integer;
  v_cadtipoparc             integer;
  v_recdestino              integer;
  v_dia                     integer;
  v_ultdiafev               integer;
  v_maxrec                  integer;
  v_anovenc                 integer;
  v_mesvenc                 integer;
  v_totalparcelas           integer;
  v_anovencprox             integer;
  v_mesvencprox             integer;
  v_recjurosultima          integer;
  v_recmultaultima          integer;
  v_histjuro                integer;
  v_proxmessegvenc          integer;
  v_proxmessegvencreal      integer;
  v_proxanovenc             integer;
  iInstit                   integer;
  iAnousu                   integer;

  v_totaldivida             float8 default 0;
  v_somar                   float8 default 0;
  v_totalliquido            float8 default 0;
  v_total_liquido           float8 default 0;
  v_totalzao                float8 default 0; 
  v_total_receita           numeric(15,2);
  v_diferenca_receita       numeric(15,2);

  v_calcula_valprop         numeric(15,10);
  v_calcula_valor           float8 default 0;
  v_calcula_his             numeric(15,2);
  v_calcula_cor             numeric(15,2);
  v_calcula_jur             numeric(15,2);
  v_calcula_mul             numeric(15,2);
  v_calcula_desccor         numeric(15,2);
  v_calcula_descjur         numeric(15,2);
  v_calcula_descmul         numeric(15,2);

  v_valor_parcela_teste     float8 default 0;

  v_descontocor             float8 default 0;
  v_tipodescontocor         integer default 0;
  v_descontojur             float8 default 0;
  v_descontomul             float8 default 0;
  v_total                   float8;
  v_totalcomjuro            float8;
  v_valparc                 float8;

  nValorParcela             float8;

  v_diferencanaultima       float8;
  v_diferenca_historico     numeric(15,2);
  v_diferenca_correcao      numeric(15,2);
  v_diferenca_juros         numeric(15,2);
  v_diferenca_multa         numeric(15,2);

  v_valorinserir            float8;
  v_ent_prop                float8;
  v_vlrateagora             float8;
  v_totateagora             float8;
  v_resto                   float8 default 0;
  v_teste                   float8;
  v_perc                    float8;
  v_saldo                   float8;
  v_calcular                float8;
  v_valorparcelanew         float8;
  v_valultimaparcelanew     float8;

  v_valdesccor              float8;
  v_valdescjur              float8;
  v_valdescmul              float8;

  nValorTotalOrigem         float8;
  nPercCalc                 float8;
  nSomaPercMatric           float8;
  nSomaPercInscr            float8;
  nTotArreMatric            float8;
  nTotArreInscr             float8;

  nVlrHis                   float8 default 0;
  nVlrCor                   float8 default 0;
  nVlrJur                   float8 default 0;
  nVlrMul                   float8 default 0;
  nVlrDes                   float8 default 0;
  nPercMatric               float8 default 0;
  nPercInscr                float8 default 0;
  nPercCGM                  float8 default 0;
  nValUpdateProp            float8 default 0;
  lIncluiEmParcelas         boolean default false;

  v_total_historico         float8 default 0;
  v_total_correcao          float8 default 0;
  v_total_juros             float8 default 0;
  v_total_multa             float8 default 0;

  v_historico_compos        float8 default 0;
  v_correcao_compos         float8 default 0;
  v_juros_compos            float8 default 0;
  v_multa_compos            float8 default 0;

  v_ultdiafev_d             date;
  v_vcto                    date;
  dDataUsu                  date;
  
  sArreoldJuncao            varchar default '';
  v_proxmessegvenc_c        varchar(2);
  v_ultdiafev_c             varchar(10);
  sStringUpdate             varchar;

  v_comando                 text;
  v_comando_cria            text;
  
  v_iniciais                record;
  v_record_perc             record;
  v_record_numpres          record;
  v_record_numpar           record;
  v_record_receitas         record;
  v_record_recpar           record;
  v_record_origem           record;
  v_record_desconto         record;
  rPercOrigem               record;
  rSeparaJurMul             record;
  
  v_parcnormal              boolean default false; -- se tem divida ativa selecionada
  v_parcinicial             boolean default false; -- se tem inicial selecionada
  lParcDiversos             boolean default false; -- se tem diversos selecionado
  lParcContrib              boolean default false; -- se tem contribuicao de melhoria selecionado
  lParcParc                 boolean default false; -- se tem parcelamento selecionado (caso esteja efetuando um reparcelamento)
  v_juronaultima            boolean default false;
  v_descontar               boolean default false;
  v_reparc                  boolean default false;
  lSeparaJuroMulta          integer default 2;
  lGravaArrecad             boolean default true;
  lParcelaZerada            boolean default false;
  
  lRaise                    boolean default false;
  
  begin

-- valores retornados:
-- 1 = ok
-- 2 = tentando parcelar mais de um tipo (k03_tipo) de debito
-- 3 = tipo de debito nao configurado para parcelamento
-- 4 = parcelamento nao encontrado pelo numpre
-- 5 = tentando reparcelar mais de um parcelamento
-- 6 = tentando parcelar mais de um numpre (debito)

    lRaise  := ( case when fc_getsession('DB_debugon') is null then false else true end );

    v_totalparcelas       = v_totparc;
    v_valorparcelanew     = v_valorparcela;
    v_valultimaparcelanew = v_valultimaparcela;
    
    iInstit := cast(fc_getsession('DB_instit') as integer);
    if iInstit is null then
       raise exception 'Variavel de sessão [DB_instit] não encontrada.';
    end if;

    iAnousu := cast(fc_getsession('DB_anousu') as integer);
    if iAnousu is null then
       raise exception 'Variavel de sessão [DB_anousu] não encontrada.';
    end if;

    dDataUsu := cast(fc_getsession('DB_datausu') as date);
    if dDataUsu is null then
       raise exception 'Variavel de sessão [DB_datausu] não encontrada.';
    end if;

    select k03_separajurmulparc
      into lSeparaJuroMulta
      from numpref
     where k03_instit = iInstit
       and k03_anousu = iAnousu;

    --lSeparaJuroMulta = false;

        -- testa se existe algum tipo de parcelamento configurado
    select count(*) 
        from tipoparc 
     where instit = iInstit
        into v_contador;
    
    if v_contador is null then
      return '3 - sem configuracao na tabela tipoparc para instituicao %', iInstit;
    end if;
    
    if lRaise is true then
      raise notice 'verificando se tem mais de um tipo de debito...';
    end if;

    -- existe uma tabela temporaria chamada totalportipo, criada antes de chamar a funcao de parcelamento
        -- que contem os valores a parcelar agrupada por tipo de debito
        -- nessa tabela existe a informacao se o tipo de debito tem direito a desconto ou nao
        
        -- a tabela numpres_parc contem os registros marcados na CGF pelo usuario
        -- cria indice na tabela utilizada durante os parcelamentos
    create index numpres_parc_in on numpres_parc using btree (k00_numpre, k00_numpar);

    -- for buscando as origens de cada debito selecionado para parcelar(numpres_parc)
    for v_record_origem in 
      select arretipo.k03_tipo, arrecad.k00_numpre, count(*)
      from numpres_parc
      inner join arrecad on arrecad.k00_numpre = numpres_parc.k00_numpre 
      inner join arretipo on arretipo.k00_tipo = arrecad.k00_tipo
      group by arretipo.k03_tipo, arrecad.k00_numpre
    loop

            -- se origem(k03_tipo) for 
      if v_record_origem.k03_tipo = 5 then
              -- 5 divida ativa
        v_parcnormal = true;
      elsif v_record_origem.k03_tipo = 18 then
            -- inicial do foro
        v_parcinicial = true;
      elsif v_record_origem.k03_tipo = 4 then
              -- contribuicao de melhoria  
        lParcContrib = true;
      elsif v_record_origem.k03_tipo = 7 then
              -- diversos
        lParcDiversos = true;
            elsif v_record_origem.k03_tipo in (6,13,16,17) then
              -- reparcelamentos
                -- 6   parcelamento de divida 
                -- 13  parcelamento de inicial de divida
                -- 16  parcelamento de diveros
                -- 17  parcelamento de contribuicao de melhoria
              lParcParc = true; 
      end if;

      if lRaise is true then
        raise notice 'k00_tipo: % - k00_numpre: %', v_record_origem.k03_tipo, v_record_origem.k00_numpre;
      end if;
    end loop;
    
    if v_parcnormal is true and v_parcinicial is true then
      return 'voce nao pode parcelar divida normal com ajuizada!';
    end if;
    
    if lRaise is true then
      raise notice 'guardando o tipo de debito...';
    end if;
    
    v_tipo = v_cadtipo;
    
    if lRaise is true then
      raise notice 'tipo de debito achado: %', v_tipo;
    end if;
    
        -- select na termoconfigo para descobrir qual o tipo de debito 
        -- que vai ser gerado com o debito do novo parcelamento
        -- tabela termotipoconfig tem o tipo de debito dos grupos de debitos 
        -- que e possivel parcelar

    if lRaise is true then
      raise notice 'instit -- %',iInstit; 
    end if;

    select k42_tiponovo 
          into v_tiponovo
        from termotipoconfig 
         where k42_cadtipo = v_tipo
       and k42_instit  = iInstit;
        if not found then 
      return 'este tipo de debito nao esta configurado para parcelamento'; -- 3
        end if;

    if lRaise is true then
      raise notice 'tipo novo: %', v_tiponovo;
    end if;

        -- cria tabela temporarias para utilizacao durante o calculo
    execute 'create temporary table vcto ( "data"   date );';

    execute 'create temporary table parcelas (
                                               "parcela"    integer,
                                               "receit"     integer,
                                               "receitaori" integer,
                                               "hist"   integer,
                                               "valor"       numeric(15,2),
                                               "valprop"       numeric(15,10),
                                               "valhis"        numeric(15,2),
                                               "valcor"        numeric(15,2),
                                               "valjur"        numeric(15,2),
                                               "valmul"        numeric(15,2),
                                               "descor"        numeric(15,2),
                                               "descjur"     numeric(15,2),
                                               "descmul"     numeric(15,2)
    );';
    
    execute 'create temporary table totrec (
    "receit"    integer,
    "parcela" integer,
    "valor"     float8
    );';
    
    execute 'create temporary table arrecad_parc_rec (
    "numpre"            integer,
    "numpar"            integer,
    "receit"            integer,
    "tipo"              integer,
    "vlrhis"            float8 default 0,
    "vlrcor"            float8 default 0,
    "vlrjur"            float8 default 0,
    "vlrmul"            float8 default 0,
    "vlrdes"            float8 default 0,
    "valor"             float8 default 0,
    "matric"            integer,
    "inscr"             integer,
    "vlrdesccor"  float8 default 0,
    "vlrdescjur"  float8 default 0,
    "vlrdescmul"  float8 default 0,
    "juro"              boolean, 
    "percmatric"    float8 default 0, 
    "percinscr"     float8 default 0 
        );';
    
    execute ' create index arrecad_parc_rec_npr_receit_in on arrecad_parc_rec using btree (numpre, numpar, receit) ';

    execute 'create temporary table arrecad_parc_rec_perc (
    "numpre"            integer,
    "numpar"            integer,
    "receit"            integer,
    "matric"            integer,
    "percmatric"    float8, 
    "inscr"             integer,
    "percinscr"     float8, 
    "perccgm"       float8, 
    "tipo"        integer 
        );';

    -- funcao que corrige o arrecad no caso de encontrar registros duplicados(numpre,numpar,receit) 
    perform fc_corrigeparcelamento();

    --return '';

    if lRaise is true then
      raise notice 'v_reparc: %', v_reparc;
    end if;
    
        -- testa se todas as parcelas do parcelamento foram marcadas, 
        -- senao nao permite parcelar apenas algumas parcelas do parcelamento
        -- ou seja, ou parcela todas as parcelas do parcelamento, ou nada
    for v_record_origem in 
      select distinct   
      termo.v07_parcel  
      from numpres_parc 
      inner join termo on termo.v07_numpre = numpres_parc.k00_numpre
      where k03_tipodebito <> 18
      loop
      
            -- soma a quantidade de parcelas do parcelamento
      select count(distinct arrecad.k00_numpar)
      into v_somar1
      from arrecad 
      inner join termo on termo.v07_parcel = v_record_origem.v07_parcel
      where arrecad.k00_numpre = termo.v07_numpre;
      
      if lRaise is true then
        raise notice 'v_record_origem.v07_parcel: %', v_record_origem.v07_parcel;
      end if;
      
            -- testa a quantidade de parcelas marcadas
      select count(distinct numpres_parc.k00_numpar)
      into v_somar2
      from numpres_parc
      inner join termo on termo.v07_parcel = v_record_origem.v07_parcel
      where numpres_parc.k00_numpre = termo.v07_numpre;
      
      if lRaise is true or 1=1 then
        raise notice 'v_somar1: % - v_somar2: %', v_somar1, v_somar2;
      end if;
      
            -- compara
      if v_somar1 <> v_somar2 then
        --raise notice 'A T I V A R   N O V A M E N T E ! ! !';
        return '2 - todas as parcelas do parcelamento ' || v_record_origem.v07_parcel || ' devem ser marcadas!';
      end if;
      
    end loop;
    
    if lRaise is true then
      raise notice 'entrada: %', v_entrada;
      raise notice 'valor das parcelas: %', v_valorparcelanew;
      raise notice 'valor da ultima parcela: %', v_valultimaparcelanew;
      raise notice 'pegando cgm do(s) numpre(s) com arrecad...';
    end if;
    
        -- busca cgm principal para gravar no arrecad posteriormente
    if v_parcinicial is true then
      select k00_numcgm from arrecad 
            into v_cgmpri
      inner join numpres_parc on arrecad.k00_numpre = numpres_parc.k00_numpre limit 1;
    else
      select k00_numcgm from arrecad 
            into v_cgmpri
      inner join numpres_parc on arrecad.k00_numpre = numpres_parc.k00_numpre and
      arrecad.k00_numpar = numpres_parc.k00_numpar limit 1;
    end if;
    
    if lRaise is true then
      raise notice 'pegando cgm de acordo com matricula ou inscricao...';
    end if;
    
    v_anousu := iAnousu;
    
        -- se for parcelamento de inicial
    if v_parcinicial is true then
      
      if lRaise is true then
        raise notice 't i p o: 18';
      end if;
      
            -- procura cgm principal por matricula ou inscricao
      for v_record_origem in 
                select distinct 
                arrematric.k00_matric,
        arreinscr.k00_inscr
        from numpres_parc
        left join arrematric on arrematric.k00_numpre = numpres_parc.k00_numpre
        left join arreinscr  on arreinscr.k00_numpre  = numpres_parc.k00_numpre
        inner join arrecad on arrecad.k00_numpre = numpres_parc.k00_numpre loop

        if lRaise is true then
          raise notice 'processando... matricula: % inscricao: %',v_record_origem.k00_matric,v_record_origem.k00_inscr;
        end if;
                
        if v_record_origem.k00_matric is not null then
          select j01_numcgm from iptubase 
                    into v_cgmpri
                    where j01_matric = v_record_origem.k00_matric;
        end if;
        
        if v_record_origem.k00_inscr is not null then
          select q02_numcgm from issbase 
                    into v_cgmpri 
                    where q02_inscr = v_record_origem.k00_inscr;
        end if;
        
      end loop;
      
        -- senao for inicial do foro
    else
      
      if lRaise is true then
        raise notice '   antes do select...';
      end if;
            
            -- procura cgm principal por matricula ou inscricao
      for v_record_origem in select distinct arrematric.k00_matric,
        arreinscr.k00_inscr
        from numpres_parc 
        left join arrematric on arrematric.k00_numpre = numpres_parc.k00_numpre
        left join arreinscr  on arreinscr.k00_numpre  = numpres_parc.k00_numpre
        inner join arrecad   on arrecad.k00_numpre = numpres_parc.k00_numpre 
        and arrecad.k00_numpar = numpres_parc.k00_numpar loop
                
        if lRaise is true then
          raise notice '      processando... matricula: % inscricao: %',v_record_origem.k00_matric,v_record_origem.k00_inscr;
        end if;
                
        if v_record_origem.k00_matric is not null then
          select j01_numcgm from iptubase into v_cgmpri where j01_matric = v_record_origem.k00_matric;
        end if;
        
        if v_record_origem.k00_inscr is not null then
          select q02_numcgm from issbase into v_cgmpri where q02_inscr = v_record_origem.k00_inscr;
        end if;
        
      end loop;
            
      if lRaise is true then
        raise notice '   depois do select...';
      end if;
      
    end if;
    
    if lRaise is true  then
      raise notice 'agora vai processar correcao e tal...';
    end if;
    
        -- se for inicial, traz apenas os numpres envolvidos, ja que no caso de parcelamento de inicial
        -- o usuario nao tem opcao de marcar as parcelas, tendo que parcelar toda a inicial
        -- se nao for inicial, traz os numpres com suas respectivas parcelas marcadas
    if v_parcinicial is true then
      v_comando = 'select distinct k00_numpre from numpres_parc';
    else
      v_comando = 'select distinct k00_numpre, k00_numpar from numpres_parc';
    end if;
    
        -- varre a lista de numpres/parcelas marcados pelo usuario
    for v_record_numpres in  execute v_comando 
    loop
      
      if lRaise is true then
        if v_parcinicial is false then
          raise notice '      numpre % - numpar: %',v_record_numpres.k00_numpre, v_record_numpres.k00_numpar;
        else
          raise notice '      numpre % - numpar: 0',v_record_numpres.k00_numpre;
        end if;
      end if;

            v_matric = 0;
            v_inscr  = 0;
      
            -- busca a matricula do numpre que esta sendo processado
      select k00_matric 
        into v_var
        from arrematric 
       where k00_numpre = v_record_numpres.k00_numpre;
      
      if v_var is not null then
        v_matric = v_var;
        if lRaise is true then
          raise notice ' origem: matricula %',v_matric;
        end if;
      end if;
      
            -- busca a inscricao do numpre que esta sendo processado
      select k00_inscr
        into v_var
        from arreinscr 
       where k00_numpre = v_record_numpres.k00_numpre;
      
      if v_var is not null then
        v_inscr = v_var;
        if lRaise is true then
          raise notice ' origem: inscricao %',v_inscr;
        end if;
      end if;
      
            -- processa cada registro acumulando por numpre, parcela, receita e tipo de debito
            -- armazenando as informacoes de valor historico, corrigido, juros e multa
            -- na tabela arrecad_parc_rec para utilizacao em processamento futuro
            -- independente se for inicial ou nao
        
            -- se for inicial
      if v_parcinicial is true then
        
        if lRaise is true  then
          raise notice '      entrando tipo 18...';
        end if;
        
        for v_record_numpar in
          select k00_numpre,
                 k00_numpar,
                 k00_receit,
                 k03_tipo,
                 substr(fc_calcula,2,13)::float8  as vlrhis,
                 substr(fc_calcula,15,13)::float8 as vlrcor,
                 substr(fc_calcula,28,13)::float8 as vlrjuros,
                 substr(fc_calcula,41,13)::float8 as vlrmulta,
                 substr(fc_calcula,54,13)::float8 as vlrdesc,
                 (substr(fc_calcula,15,13)::float8+substr(fc_calcula,28,13)::float8+substr(fc_calcula,41,13)::float8-substr(fc_calcula,54,13)::float8) as total
            from ( select k00_numpre,
                          k00_numpar,
                          k00_receit,
                          k03_tipo,
                          fc_calcula(k00_numpre,k00_numpar,k00_receit,dDataUsu,dDataUsu,v_anousu) as fc_calcula
                     from ( select distinct
                                   arrecad.k00_numpre,
                                   arrecad.k00_numpar,
                                   arrecad.k00_receit,
                                   arretipo.k03_tipo
                              from arrecad
                                   inner join arretipo on arrecad.k00_tipo = arretipo.k00_tipo
                             where arrecad.k00_numpre = v_record_numpres.k00_numpre
                                                     ) as x
                                    ) as y
          loop
          
          select receit
            from arrecad_parc_rec
            into v_receita
           where numpre = v_record_numpar.k00_numpre 
                       and numpar = v_record_numpar.k00_numpar 
                         and receit = v_record_numpar.k00_receit;

                    /*--------------------------------------------------------------------------------------*/
          
          if lRaise is true then
            raise notice '1 - numpre: %, numpar: %, receit: %, v_receita: %',v_record_numpar.k00_numpre,v_record_numpar.k00_numpar,v_record_numpar.k00_receit,v_receita;
          end if;
          
                    -- se nao existe registro insere
          if v_receita is null then
            --raise notice 'NAO EXISTE';
            execute 'insert into arrecad_parc_rec values (' ||
            v_record_numpar.k00_numpre || ',' ||
            v_record_numpar.k00_numpar || ',' ||
            v_record_numpar.k00_receit || ',' ||
            v_record_numpar.k03_tipo   || ',' ||
            v_record_numpar.vlrhis     || ',' ||
            v_record_numpar.vlrcor     || ',' ||
            v_record_numpar.vlrjuros   || ',' ||
            v_record_numpar.vlrmulta   || ',' ||
            v_record_numpar.vlrdesc    || ',' ||
            v_record_numpar.total      || ',' ||
            v_matric                       || ',' ||
            v_inscr                      || ',' ||
            0                          || ',' ||
            0                          || ',' ||
            0                          || ',' ||
            'false'                  || ');';
                    -- se ja existe, soma
          else
            --raise notice 'EXISTE';
            execute 'update arrecad_parc_rec set valor = valor + ' || v_record_numpar.total
            || ',vlrhis = vlrhis + ' || v_record_numpar.vlrhis
            || ',vlrcor = vlrcor + ' || v_record_numpar.vlrcor
            || ',vlrjur = vlrjur + ' || v_record_numpar.vlrjuros
            || ',vlrmul = vlrmul + ' || v_record_numpar.vlrmulta
            || ',vlrdes = vlrdes + ' || v_record_numpar.vlrdesc
            || ' where numpre = '    || v_record_numpar.k00_numpre || ' and '
            || '       numpar = '    || v_record_numpar.k00_numpar || ' and '
            || '       receit = '    || v_record_numpar.k00_receit ||
            ';';
          end if;
          
        end loop;
        
        if lRaise is true then
          raise notice '      saindo do tipo 18...';
        end if;
        
      else -- se nao for inicial foro
        
        if lRaise is true then
          raise notice ' tipo diferente de 18 ';
        end if;
        
        if lRaise is true then
          raise notice 'numpre: % - numpar: %', v_record_numpres.k00_numpre, v_record_numpres.k00_numpar;
        end if;
        
        for v_record_numpar in select k00_numpre,
                                      k00_numpar,
                                      k00_receit,
                                      k03_tipo,
                                      substr(fc_calcula,2, 13)::float8 as vlrhis,
                                      substr(fc_calcula,15,13)::float8 as vlrcor,
                                      substr(fc_calcula,28,13)::float8 as vlrjuros,
                                      substr(fc_calcula,41,13)::float8 as vlrmulta,
                                      substr(fc_calcula,54,13)::float8 as vlrdesc,
                                      (substr(fc_calcula,15,13)::float8+
                                      substr(fc_calcula,28,13)::float8+
                                      substr(fc_calcula,41,13)::float8-
                                      substr(fc_calcula,54,13)::float8) as total
                                 from ( select distinct
                                               k00_numpre,
                                               k00_numpar,
                                               k00_receit,
                                               k03_tipo,
                                               fc_calcula(k00_numpre,k00_numpar,k00_receit,dDataUsu,dDataUsu,v_anousu) as fc_calcula
                                          from ( select distinct
                                                        arrecad.k00_numpre,
                                                        arrecad.k00_numpar,
                                                        arrecad.k00_receit,
                                                        arretipo.k03_tipo
                                                   from arrecad
                                                        inner join arretipo on arrecad.k00_tipo = arretipo.k00_tipo
                                                  where arrecad.k00_numpre = v_record_numpres.k00_numpre 
                                                    and arrecad.k00_numpar = v_record_numpres.k00_numpar
                                                                                             ) as x 
                                                                            ) as y
          loop
          
          if lRaise is true then
            raise notice '         dentro do for...';
          end if;

                    /*--------------------------------------------------------------------------------------*/
          
          select receit
            from arrecad_parc_rec
            into v_receita
           where numpre  = v_record_numpar.k00_numpre 
                       and numpar  = v_record_numpar.k00_numpar 
                         and receit  = v_record_numpar.k00_receit;
          
          if lRaise is true then
            raise notice '2 - numpre: %, numpar: %, receit: %, v_receita: % - valor: %',v_record_numpar.k00_numpre,v_record_numpar.k00_numpar,v_record_numpar.k00_receit,v_receita, v_record_numpar.total;
          end if;
          
                    -- se nao existe registro insere
          if v_receita is null then
            --raise notice 'NAO EXISTE (2)...';
            if lRaise is true then
              raise notice '   inserindo no arrecad_parc_rec... numpre: %', v_record_numpar.k00_numpre;
            end if;
            execute 'insert into arrecad_parc_rec values (' ||
            v_record_numpar.k00_numpre || ',' ||
            v_record_numpar.k00_numpar || ',' ||
            v_record_numpar.k00_receit || ',' ||
            v_record_numpar.k03_tipo   || ',' ||
            v_record_numpar.vlrhis     || ',' ||
            v_record_numpar.vlrcor     || ',' ||
            v_record_numpar.vlrjuros   || ',' ||
            v_record_numpar.vlrmulta   || ',' ||
            v_record_numpar.vlrdesc    || ',' ||
            v_record_numpar.total      || ',' ||
            v_matric                       || ',' ||
            v_inscr                      ||
            ');';
                    -- se existe soma
          else
            raise notice 'EXISTE (2)...';
            execute 'update arrecad_parc_rec set valor = valor + ' || v_record_numpar.total
            || ',vlrhis = vlrhis + ' || v_record_numpar.vlrhis
            || ',vlrcor = vlrcor + ' || v_record_numpar.vlrcor
            || ',vlrjur = vlrjur + ' || v_record_numpar.vlrjuros
            || ',vlrmul = vlrmul + ' || v_record_numpar.vlrmulta
            || ',vlrdes = vlrdes + ' || v_record_numpar.vlrdesc
            || ' where numpre = '    || v_record_numpar.k00_numpre || ' and '
            || '       numpar = '    || v_record_numpar.k00_numpar || ' and '
            || '       receit = '    || v_record_numpar.k00_receit ||
            ';';
          end if;
          
          if lRaise is true then
            raise notice ' fim do for...';
          end if;
          
        end loop;
        
      end if;
      
    end loop;
    
    if lRaise is true then
      raise notice 'gravando na tabela parcelas... tipo: %', v_tipo;
      raise notice 'v_temdesconto: %', v_temdesconto;
    end if;
    
        -- busca regra de parcelamento
    select cadtipoparc.k40_codigo 
      into v_cadtipoparc
      from tipoparc 
           inner join cadtipoparc on cadtipoparc = k40_codigo 
     where maxparc > 1 
       and dDataUsu >= k40_dtini 
       and dDataUsu <= k40_dtfim 
       and k40_codigo = v_desconto
       and k40_aplicacao = 1 -- Aplicar Antes do Lancamento
    order by maxparc  limit 1;
    
    if lRaise is true then
      raise notice 'v_cadtipoparc: %', v_cadtipoparc;
    end if;
    
        -- varre as regras de parcelamento para descobrir o percentual de desconto nos juros e multa de acordo com 
        -- a quantidade de parcelas selecionadas pelo usuario
    for v_record_desconto in
      select * from tipoparc where maxparc > 1 and cadtipoparc = v_cadtipoparc and cadtipoparc = v_desconto order by maxparc loop
      
      if v_totalparcelas >= v_ultparc and v_totalparcelas <= v_record_desconto.maxparc then
        v_tipodescontocor = v_record_desconto.tipovlr;
        v_descontocor = v_record_desconto.descvlr;
        v_descontomul = v_record_desconto.descmul;
        v_descontojur = v_record_desconto.descjur;
        exit;
      end if;
      
    end loop;
    
    if lRaise is true then
      raise notice 'total do desconto na multa : %', v_descontomul;
      raise notice 'total do desconto nos juros: %', v_descontojur;
      raise notice 'antes do for do arrecad_parc_rec...';
    end if;
    
        -- soma o valor corrigido + juros + multa antes de efetuar o desconto
        -- valor apenas para conferencia em possivel debug
    select round(sum(valor),2), round(sum(vlrcor+vlrjur+vlrmul-vlrdesccor-vlrdescjur-vlrdescmul),2) 
    into v_somar, v_totalliquido
    from arrecad_parc_rec;

    if lRaise is true then
      raise notice 'v_somar: % - v_totalliquido: %', v_somar, v_totalliquido;
    end if;

        -- varre tabela dos registros a parcelar para aplicar desconto nos juros e multa
    for v_record_recpar in select * from arrecad_parc_rec loop
      
            -- testa se o tipo de debito desse registro tem direito a desconto
      select case when k00_cadtipoparc > 0 then true else false end
      into v_descontar 
      from totalportipo 
      where k03_tipodebito = v_record_recpar.tipo;
      
      if lRaise is true then
        raise notice 'tipo: % - descontar: %', v_record_recpar.tipo, v_descontar;
      end if;

            -- se tem direito a desconto, aplica o desconto e da update nos valores do registro atual da arrecad_parc_rec
      if v_descontar is true then

        v_valdesccor = 0;
        if v_tipodescontocor = 1 then
          if lRaise is true then
            raise notice 'vlrcor: % - vlrhis: % - v_descontocor: %', v_record_recpar.vlrcor, v_record_recpar.vlrhis, v_descontocor;
          end if;
          v_valdesccor = round((v_record_recpar.vlrcor - v_record_recpar.vlrhis) * v_descontocor / 100,2);
        elsif v_tipodescontocor = 2 then
          v_valdesccor = round(v_record_recpar.vlrcor * v_descontocor / 100,2);
        end if;
        
        if lRaise is true then
          raise notice 'v_valdesccor: %', v_valdesccor;
        end if;

        v_valdescjur = round(v_record_recpar.vlrjur * v_descontojur / 100,2);
        if lRaise is true then
          raise notice 'v_valdescjur: % - v_descontojur: %', v_valdescjur, v_descontojur;
        end if;
        v_valdescmul = round(v_record_recpar.vlrmul * v_descontomul / 100,2);
        if lRaise is true then
          raise notice 'v_valdescmul: % - v_descontomul: %', v_valdescmul, v_descontomul;
        end if;
        
        execute 'update arrecad_parc_rec 
        set vlrjur        = ' || v_record_recpar.vlrjur
        || ', vlrmul      = ' || v_record_recpar.vlrmul
        || ', valor       = valor - ' || v_valdescjur || ' - ' || v_valdescmul || ' - ' || v_valdesccor
        || ', vlrdesccor  = ' || round(v_valdesccor,2)
        || ', vlrdescjur  = ' || round(v_record_recpar.vlrjur * v_descontojur / 100,2)
        || ', vlrdescmul  = ' || round(v_record_recpar.vlrmul * v_descontomul / 100,2)
        || ' where numpre = '    || v_record_recpar.numpre || ' and '
        || '       numpar = '    || v_record_recpar.numpar || ' and '
        || '       receit = '    || v_record_recpar.receit ||   ';';
        
      end if;
      
      if lRaise is true then
        raise notice '   numpre: % - numpar: % - receita: %', v_record_recpar.numpre, v_record_recpar.numpar, v_record_recpar.receit ;
      end if;
      
    end loop;

        -- passa o conteudo do campo juro para false em todos os registros
    execute 'update arrecad_parc_rec set juro = false';
    
    if lRaise is true then
      raise notice 'v_desconto: %', v_desconto;
    end if;
    
        -- se a forma na regra de parcelamento for 2 (juros na ultima)
    select  case when k40_forma = 2 then true else false end
    into v_juronaultima
    from cadtipoparc 
    where k40_codigo = v_desconto;
    
    if v_juronaultima is null then
      v_juronaultima = false;
    end if;
    
    if lRaise is true then
      raise notice 'desconto na ultima: %', v_juronaultima;
    end if;
    
    for v_record_recpar in
      select * from arrecad_parc_rec loop
      
            -- se for para colocar juros na ultima
            -- insere mais dois registros: um para juros e outro para multa
            -- e update no campo valor deixando apenas o valor corrigido
      if v_juronaultima is true then
        
        select  k02_recjur,             
                k02_recmul 
        from tabrec
        into    v_recjurosultima, 
                v_recmultaultima
        where k02_codigo = v_record_recpar.receit;
        
        if lRaise is true then
          raise notice 'jur: % - mul: %', v_recjurosultima, v_recmultaultima;
          
          -- inserindo juros
          
          raise notice 'numpre: % - numpar: % - jurosnaultima: %', v_record_recpar.numpre, v_record_recpar.numpar, v_recjurosultima;
          raise notice 'tipo: % - juros: % - matric: % - inscr: % - descjur: % - descmul: %', v_record_recpar.tipo, v_record_recpar.vlrjur, v_record_recpar.matric, v_record_recpar.inscr, v_record_recpar.vlrdescjur, v_record_recpar.vlrdescmul;
        end if;
        
        execute 'insert into arrecad_parc_rec values (' ||
        v_record_recpar.numpre          || ',' ||
        v_record_recpar.numpar          || ',' ||
        v_recjurosultima                        || ',' ||
        v_record_recpar.tipo                || ',' ||
        v_record_recpar.vlrjur          || ',' ||
        v_record_recpar.vlrjur          || ',' ||
        0                                                       || ',' ||
        0                                                       || ',' ||
        0                                                       || ',' ||
        v_record_recpar.vlrjur          || ',' ||
        v_record_recpar.matric          || ',' ||
        v_record_recpar.inscr               || ',' ||
        v_record_recpar.vlrdescjur  || ',' ||
        v_record_recpar.vlrdescmul  || ',' ||
        'true'                    ||
        ');';
        
        if lRaise is true then
          raise notice '1';
        end if;
        
-- inserindo multa
        execute 'insert into arrecad_parc_rec values (' ||
        v_record_recpar.numpre          || ',' ||
        v_record_recpar.numpar          || ',' ||
        v_recmultaultima                        || ',' ||
        v_record_recpar.tipo                || ',' ||
        v_record_recpar.vlrmul          || ',' ||
        v_record_recpar.vlrmul          || ',' ||
        0                                                       || ',' ||
        0                                                       || ',' ||
        0                                                       || ',' ||
        v_record_recpar.vlrmul          || ',' ||
        v_record_recpar.matric          || ',' ||
        v_record_recpar.inscr               || ',' ||
        v_record_recpar.vlrdescjur  || ',' ||
        v_record_recpar.vlrdescmul  || ',' ||
        'true'                    ||
        ');';
        
        if lRaise is true then
          raise notice '2'; 
        end if;
        
        execute 'update arrecad_parc_rec set valor = ' || v_record_recpar.vlrcor
        || ' where numpre = '    || v_record_recpar.numpre || ' and '
        || '       numpar = '    || v_record_recpar.numpar || ' and '
        || '       receit = '    || v_record_recpar.receit ||
        ';';
        
        if lRaise is true then
          raise notice '3';
        end if;
        
      end if;
      
    end loop;
    
    if lRaise is true then
      raise notice ' ';
      raise notice ' ';
      raise notice ' ';
      raise notice ' ';
      raise notice ' ';
      raise notice ' ';
    end if;

        -- apenas mostra os registros atuais para possivel conferencia
    for v_record_recpar in
      select * from arrecad_parc_rec loop
      
      if lRaise is true then
        raise notice 'numpre: % - par: % - rec: % - cor: % - jur: % - tot: % - juro: %', v_record_recpar.numpre, v_record_recpar.numpar, v_record_recpar.receit, v_record_recpar.vlrcor, v_record_recpar.vlrjur,v_record_recpar.valor, v_record_recpar.juro;
      end if;
      
    end loop;

    if lRaise is true then
      raise notice ' ';
      raise notice ' ';
      raise notice ' ';
      raise notice ' ';
      raise notice ' ';
      raise notice ' ';
    end if;
    
--    return 'xxx';

    if lRaise is true then
      raise notice 'depois do for do arrecad_parc_rec...';
    end if;
    
        -- calcula valor total com juro
    select round(sum(valor),2)
    from arrecad_parc_rec
    into v_totalcomjuro;
    
        -- se for juros na ultima, o campo valor ja esta sem juros e multa
        -- entao a variavel v_total recebe sem juros e a regra for de colocar os juros na ultima parcela
        -- note que o campo juro da tabela recebe false apenas nos registros que nao sao dos juros para incluir na ultima
    if v_juronaultima is false then
      select round(sum(valor),2)
      from arrecad_parc_rec
      into v_total;
    else
      select round(sum(valor),2)
      from arrecad_parc_rec
      where juro is false
      into v_total;
    end if;
    
        -- diferente entre variavel com e sem juros
        -- utilizada na regra de juros na ultima
    v_diferencanaultima = v_totalcomjuro - v_total;
    
    if lRaise is true then
      raise notice ' ';
      raise notice 'total (primeira versao do script): % - v_totalparcelas: %', v_total, v_totalparcelas;
      raise notice ' ';
      raise notice 'v_tipo: %', v_tipo;
    end if;
    
        v_somar = 0;
        
        if lRaise is true then
            raise notice 'antes do tipo 5...';
        end if;
        
        -- cria variavel para select agrupando os valores por
        -- tipo de origem, receita nova e receita original
        -- note que o sistema tem 3 niveis de origem
        -- 1 = de divida ativa
        -- 2 = parcelamento de divida, parcelamento de inicial, parcelamento de contribuicao, inicial do foro e contribuicao
        -- 3 = diversos

    v_comando =              '  select tipo_origem,  ';
    v_comando = v_comando || '         receita,      ';
    v_comando = v_comando || '         receitaori,   '; 
    v_comando = v_comando || '         min(k00_hist) as k00_hist,   ';
    v_comando = v_comando || '         round(sum(valor),2) as valor, ';
    v_comando = v_comando || '         round(sum(total_his),2) as total_his, ';
    v_comando = v_comando || '         round(sum(total_cor),2) as total_cor, ';
    v_comando = v_comando || '         round(sum(total_jur),2) as total_jur, ';
    v_comando = v_comando || '         round(sum(total_mul),2) as total_mul, ';
    v_comando = v_comando || '         round(sum(total_desccor),2) as total_desccor, ';
    v_comando = v_comando || '         round(sum(total_descjur),2) as total_descjur, ';
    v_comando = v_comando || '         round(sum(total_descmul),2) as total_descmul ';
    v_comando = v_comando || '    from ( select 1 as tipo_origem,   ';
    v_comando = v_comando || '                  receit as receita,  ';
    v_comando = v_comando || '                  receitaori,         ';
    v_comando = v_comando || '                  min(k00_hist) as k00_hist, ';
    v_comando = v_comando || '                  sum(valor) as valor, ';
    v_comando = v_comando || '                  sum(total_his) as total_his,';
    v_comando = v_comando || '                  sum(total_cor) as total_cor,';
    v_comando = v_comando || '                  sum(total_jur) as total_jur,';
    v_comando = v_comando || '                  sum(total_mul) as total_mul,';
    v_comando = v_comando || '                  sum(total_desccor) as total_desccor,';
    v_comando = v_comando || '                  sum(total_descjur) as total_descjur,';
    v_comando = v_comando || '                  sum(total_descmul) as total_descmul';
    v_comando = v_comando || '               from ( select a.numpre,  ';
    v_comando = v_comando || '                           a.numpar,  ';
    v_comando = v_comando || '                             a.receita as receit,         ';
    v_comando = v_comando || '                               a.receitaori as receitaori,  ';
    v_comando = v_comando || '                                                   min(k00_hist) as k00_hist,        ';
    v_comando = v_comando || '                                                   sum(a.valor) as valor, ';
    v_comando = v_comando || '                                                   sum(total_his) as total_his, ';
    v_comando = v_comando || '                                                   sum(total_cor) as total_cor, ';
    v_comando = v_comando || '                                                   sum(total_jur) as total_jur, ';
    v_comando = v_comando || '                                                   sum(total_mul) as total_mul, ';
    v_comando = v_comando || '                                                   sum(total_desccor) as total_desccor, ';
    v_comando = v_comando || '                                                   sum(total_descjur) as total_descjur, ';
    v_comando = v_comando || '                                                   sum(total_descmul) as total_descmul ';
    v_comando = v_comando || '                      from ( select arrecad_parc_rec.numpre, ';
    v_comando = v_comando || '                                                    arrecad_parc_rec.numpar, ';
    v_comando = v_comando || '                                                    arrecad_parc_rec.receit as receitaori, ';
    v_comando = v_comando || '                                                    recparproc.receita as receita, ';
    v_comando = v_comando || '                                                    min(proced.k00_hist) as k00_hist, ';
    v_comando = v_comando || '                                                    round(sum(arrecad_parc_rec.valor),2) as valor, ';
    v_comando = v_comando || '                                                    round(sum(vlrhis),2) as total_his, ';
    v_comando = v_comando || '                                                    round(sum(vlrcor),2) as total_cor, ';
    v_comando = v_comando || '                                                    round(sum(vlrjur),2) as total_jur, ';
    v_comando = v_comando || '                                                    round(sum(vlrmul),2) as total_mul, ';
    v_comando = v_comando || '                                                    round(sum(vlrdesccor),2) as total_desccor, ';
    v_comando = v_comando || '                                                    round(sum(vlrdescjur),2) as total_descjur, ';
    v_comando = v_comando || '                                                    round(sum(vlrdescmul),2) as total_descmul ';
    v_comando = v_comando || '                             from arrecad_parc_rec ';
    v_comando = v_comando || '                                           inner join arrecad     on arrecad.k00_numpre = arrecad_parc_rec.numpre  '; 
    v_comando = v_comando || '                                                                and arrecad.k00_numpar = arrecad_parc_rec.numpar  ';
    v_comando = v_comando || '                                                        and arrecad.k00_receit = arrecad_parc_rec.receit   ';
    v_comando = v_comando || '                                                  and arrecad.k00_valor > 0                         ';
    v_comando = v_comando || '                                           inner join arretipo on arretipo.k00_tipo = arrecad.k00_tipo          ';
    v_comando = v_comando || '                                           left  join divida   on divida.v01_numpre = arrecad.k00_numpre        ';
    v_comando = v_comando || '                                                         and divida.v01_numpar = arrecad.k00_numpar        ';
    v_comando = v_comando || '                                           left  join recparproc  on recparproc.v03_codigo = divida.v01_proced ';
    v_comando = v_comando || '                                           inner join proced      on proced.v03_codigo = divida.v01_proced     ';
    v_comando = v_comando || '                                           where k03_tipo = 5  ';
        if v_juronaultima is true then
            v_comando = v_comando || '                           and juro is false ';
        end if;
        v_comando = v_comando || '                                                      group by arrecad_parc_rec.numpre, ';
        v_comando = v_comando || '                                     arrecad_parc_rec.numpar, ';
        v_comando = v_comando || '                                     arrecad_parc_rec.receit, ';
        v_comando = v_comando || '                                     recparproc.receita ';
        v_comando = v_comando || '                           ) as a ';
        v_comando = v_comando || '                          group by a.numpre, ';
        v_comando = v_comando || '                                   a.numpar, ';
        v_comando = v_comando || '                                   a.receita, ';
        v_comando = v_comando || '                                   a.receitaori ';
        v_comando = v_comando || '                    ) as x ';
        v_comando = v_comando || '               group by receit, ';
        v_comando = v_comando || '                        receitaori ';

        v_comando = v_comando || '      union ';
        
        v_comando = v_comando || '             select 2 as tipo_origem, ';
        v_comando = v_comando || '                    arrecad_parc_rec.receit, ';
        v_comando = v_comando || '                          arrecad_parc_rec.receit as receitaori, ';
        v_comando = v_comando || '                              min(k00_hist) as k00_hist, ';
        v_comando = v_comando || '                              round(sum(arrecad_parc_rec.valor),2) as valor, ';
        v_comando = v_comando || '                              round(sum(vlrhis),2) as total_his, ';
        v_comando = v_comando || '                              round(sum(vlrcor),2) as total_cor, ';
        v_comando = v_comando || '                              round(sum(vlrjur),2) as total_jur, ';
        v_comando = v_comando || '                              round(sum(vlrmul),2) as total_mul, ';
        v_comando = v_comando || '                              round(sum(vlrdesccor),2) as total_desccor, ';
        v_comando = v_comando || '                              round(sum(vlrdescjur),2) as total_descjur, ';
        v_comando = v_comando || '                              round(sum(vlrdescmul),2) as total_descmul ';
        v_comando = v_comando || '                       from arrecad_parc_rec ';
        v_comando = v_comando || '                              inner join arrecad  on arrecad.k00_numpre = arrecad_parc_rec.numpre ';
        v_comando = v_comando || '                                               and arrecad.k00_numpar = arrecad_parc_rec.numpar ';
        v_comando = v_comando || '                                     and arrecad.k00_receit = arrecad_parc_rec.receit ';
        v_comando = v_comando || '                                     and arrecad.k00_valor > 0                        ';
        v_comando = v_comando || '                              inner join arretipo on  arretipo.k00_tipo = arrecad.k00_tipo ';
        v_comando = v_comando || '              where k03_tipo in (6, 13, 18, 17, 4) ';
        v_comando = v_comando || '                 or (    k03_tipo in (7,16) ';
        v_comando = v_comando || '                     and exists (select 1 ';
        v_comando = v_comando || '                                    from termo ';
        v_comando = v_comando || '                                         inner join termoreparc on termoreparc.v08_parcel = termo.v07_parcel ';
        v_comando = v_comando || '                                   where v07_numpre = arrecad_parc_rec.numpre) ) ';
        if v_juronaultima is true then
            v_comando = v_comando || '            and juro is false ';
        end if;
        v_comando = v_comando || '              group by arrecad_parc_rec.receit, ';
        v_comando = v_comando || '                     arrecad_parc_rec.receit ';
        
        v_comando = v_comando || '    union ';

        v_comando = v_comando || '             select 3 as tipo_origem, ';
        v_comando = v_comando || '                                  recparprocdiver.receita, ';
        v_comando = v_comando || '                                  recparprocdiver.receita as receitaori,';
        v_comando = v_comando || '                                  procdiver.dv09_hist, ';
        v_comando = v_comando || '                                  round(sum(valor),2) as valor, ';
        v_comando = v_comando || '                                  round(sum(vlrhis),2) as total_his, ';
        v_comando = v_comando || '                                  round(sum(vlrcor),2) as total_cor, ';
        v_comando = v_comando || '                                  round(sum(vlrjur),2) as total_jur, ';
        v_comando = v_comando || '                                  round(sum(vlrmul),2) as total_mul, ';
        v_comando = v_comando || '                                  round(sum(vlrdesccor),2) as total_desccor, ';
        v_comando = v_comando || '                                  round(sum(vlrdescjur),2) as total_descjur, ';
        v_comando = v_comando || '                                  round(sum(vlrdescmul),2) as total_descmul ';
        v_comando = v_comando || '                     from diversos';
        v_comando = v_comando || '                  left join (select termodiver.* from termodiver inner join termo on dv10_parcel = v07_parcel and v07_situacao = 1) as termodiver on dv05_coddiver = dv10_coddiver';
        v_comando = v_comando || '                                  left join recparprocdiver on recparprocdiver.procdiver = diversos.dv05_procdiver';
        v_comando = v_comando || '                                  inner join procdiver  on procdiver.dv09_procdiver = diversos.dv05_procdiver';
        v_comando = v_comando || '                                  inner join arrecad_parc_rec on  diversos.dv05_numpre = arrecad_parc_rec.numpre';
        v_comando = v_comando || '            where dv10_coddiver is null';
    v_comando = v_comando || '                                  group by recparprocdiver.receita, ';
        v_comando = v_comando || '                           procdiver.dv09_hist ';

        v_comando = v_comando || '    union ';

        v_comando = v_comando || '           select tipo_origem, ';
        v_comando = v_comando || '                  receita, ';
        v_comando = v_comando || '                  receitaori, ';
        v_comando = v_comando || '                  dv09_hist, ';
        v_comando = v_comando || '                  round(sum(valor),2) as valor, ';
        v_comando = v_comando || '                  round(sum(vlrhis),2) as total_his, ';
        v_comando = v_comando || '                  round(sum(vlrcor),2) as total_cor, ';
        v_comando = v_comando || '                  round(sum(vlrjur),2) as total_jur, ';
        v_comando = v_comando || '                  round(sum(vlrmul),2) as total_mul, ';
        v_comando = v_comando || '                  round(sum(vlrdesccor),2) as total_desccor, ';
        v_comando = v_comando || '                  round(sum(vlrdescjur),2) as total_descjur, ';
        v_comando = v_comando || '                  round(sum(vlrdescmul),2) as total_descmul ';
        v_comando = v_comando || '       from ( select 4 as tipo_origem,';
        v_comando = v_comando || '                     (select min(recparprocdiver.receita)';
        v_comando = v_comando || '                        from termodiver';
        v_comando = v_comando || '                             inner join diversos         on termodiver.dv10_coddiver  = dv05_coddiver';
        v_comando = v_comando || '                             inner join recparprocdiver  on recparprocdiver.procdiver = diversos.dv05_procdiver';
        v_comando = v_comando || '                             inner join procdiver        on procdiver.dv09_procdiver  = diversos.dv05_procdiver';
        v_comando = v_comando || '                       where termodiver.dv10_parcel = v07_parcel ) as receita,';
        v_comando = v_comando || '                     (select min(recparprocdiver.receita)';
        v_comando = v_comando || '                        from termodiver';
        v_comando = v_comando || '                             inner join diversos         on termodiver.dv10_coddiver  = dv05_coddiver';
        v_comando = v_comando || '                             inner join recparprocdiver  on recparprocdiver.procdiver = diversos.dv05_procdiver';
        v_comando = v_comando || '                             inner join procdiver        on procdiver.dv09_procdiver  = diversos.dv05_procdiver';
        v_comando = v_comando || '                       where termodiver.dv10_parcel = v07_parcel ) as receitaori,';
        v_comando = v_comando || '                     (select min(procdiver.dv09_hist)';
        v_comando = v_comando || '                        from termodiver';
        v_comando = v_comando || '                             inner join diversos         on termodiver.dv10_coddiver  = dv05_coddiver';
        v_comando = v_comando || '                             inner join recparprocdiver  on recparprocdiver.procdiver = diversos.dv05_procdiver';
        v_comando = v_comando || '                             inner join procdiver        on procdiver.dv09_procdiver  = diversos.dv05_procdiver';
        v_comando = v_comando || '                       where termodiver.dv10_parcel = v07_parcel ) as dv09_hist,';
        v_comando = v_comando || '                     valor, ';
        v_comando = v_comando || '                     vlrhis, ';
        v_comando = v_comando || '                     vlrcor, ';
        v_comando = v_comando || '                     vlrjur, ';
        v_comando = v_comando || '                     vlrmul, ';
        v_comando = v_comando || '                     vlrdesccor, ';
        v_comando = v_comando || '                     vlrdescjur, ';
        v_comando = v_comando || '                     vlrdescmul';
        v_comando = v_comando || '                from arrecad_parc_rec';
        v_comando = v_comando || '                     inner join termo                                              on v07_numpre             = arrecad_parc_rec.numpre';
        v_comando = v_comando || '                       inner join ( select distinct dv10_parcel from termodiver ) as parcdiver on parcdiver.dv10_parcel = termo.v07_parcel';
        v_comando = v_comando || '            ) as diver';
        v_comando = v_comando || '       group by tipo_origem,';
        v_comando = v_comando || '                receita,receitaori,';
        v_comando = v_comando || '                dv09_hist  ';
        v_comando = v_comando || '         ) as xxx ';
        v_comando = v_comando || '      group by tipo_origem, ';
        v_comando = v_comando || '             receita, ';
        v_comando = v_comando || '             receitaori';

        if lRaise then
      raise notice 'sql : % ',v_comando;        
        end if;

    if lRaise then
      raise notice 'v_total: %', v_total;
    end if;

    v_comando_cria = 'create temp table w_testando as ' || v_comando;
    execute v_comando_cria;

    -- tipo 3 = parcelamento de diversos
        -- tipo 4 = reparcelamento de diversos

        -- se regra for de juros na ultima, diminui o total de parcelas em 1
        if v_juronaultima is true then
            v_totalparcelas = v_totalparcelas - 1;
            if lRaise is true then
                raise notice 'mudando - v_total: %', v_total;
            end if;
        end if;

        -- processa receita por receita para gerar os registros na tabela parcelas
        -- que sera utilizada posteriormente para gerar os registros na tabela arrecad
        for v_record_recpar in execute v_comando
        loop
      
      if v_record_recpar.tipo_origem is null then 
         return '12 - Nao encontrado registros na tabela Divida para um dos debitos que esta sendo parcelado.';
      end if;

      if v_record_recpar.receita is null then
        return '11 - Receita de parcelamento nao configurada para a procedencia';
      end if;

            -- se origem for divida ativa, soma na variavel v_totaldivida
            if v_record_recpar.tipo_origem = 1 then
                v_totaldivida = v_totaldivida + v_record_recpar.valor;
            end if;
            
            if lRaise is true then
                raise notice 'tipo_origem: % - receita: % - receitaoriginal: % - hist: % - valor: % - total_cor: %', v_record_recpar.tipo_origem, v_record_recpar.receita, v_record_recpar.receitaori, v_record_recpar.k00_hist, v_record_recpar.valor, v_record_recpar.total_cor;
            end if;
            
            -- calcula entrada proporcional ao valor desta receita
            -- regra de tres normal em relacao percentual da entrada do registro atual em relacao ao total do parcelamento
            -- se for o caso de ter apenas uma receita em processamento, essa variavel vai ser igual ao valor da entrada
            v_ent_prop = v_record_recpar.valor * (v_entrada / v_total);
            v_total_liquido = v_record_recpar.total_cor + v_record_recpar.total_jur + v_record_recpar.total_mul - v_record_recpar.total_desccor - v_record_recpar.total_descjur - v_record_recpar.total_descmul;

            if lRaise is true then
              raise notice 'xxxxxxxxxxxxx: receita: % - valor: % - entrada proporcional: % - valor: % - total: %', v_record_recpar.receita, v_record_recpar.valor, v_ent_prop, v_record_recpar.valor, v_total_liquido;
              raise notice ' ';
              raise notice '========== receita: %', v_record_recpar.receita;
              raise notice ' ';
            end if;

            -- processa parcela por parcela
            for v_parcela in 1..v_totalparcelas loop
                
        -- variavel do valor da parcela recebe o valor da receita deste registro / valor total do parcelamento
                -- que na pratica seria a proporcionalidade deste registro em relacao ao total do parcelamento
                v_valparc = v_record_recpar.valor / v_total;
                
                if lRaise is true then
                    raise notice '   v_valparc: % - v_total: % - valor: % - receit: % - entrada: %', v_valparc, v_total, v_record_recpar.valor, v_record_recpar.receita, v_entrada;
                end if;
                
                if v_parcela = 1 then
                    -- se parcela igual a 1, entao valor parcela e igual ao valor da entrada * valor da proporcionalidade 
                    -- deste registro em relacao ao total do parcelamento
                    v_valparc = v_entrada * v_valparc;
                else
                    -- se nao for a parcela 1 entao
                    -- valor da parcela recebe o valor da parcela definido pelo usuario na CGF * valor da proporcionalidade 
                    -- deste registro em relacao ao total do parcelamento
                    v_valparc = v_valorparcelanew * v_valparc;
                end if;

        --v_valparc = round(v_valparc,2);
                
                if lRaise is true then
                    raise notice '   000 = parcela: % - receita: % - valor: % - v_valorparcelanew: % - receitaori: %', v_parcela, v_record_recpar.receita, v_valparc, v_valorparcelanew, v_record_recpar.receitaori;
                end if;

        v_calcula_valprop = v_record_recpar.valor / v_total;
        v_teste           = round(v_record_recpar.valor / v_total,2);

        if v_teste <= 0 then
                  if lRaise is true then
            raise notice 'valor: % - v_total: % - v_teste: % - parcela: % - receita: % - v_calcula_valprop: %', v_record_recpar.valor, v_total, v_teste, v_parcela, v_record_recpar.receita, v_calcula_valprop;
          end if;
        end if;

                if lRaise is true then
          raise notice 'v_valparc: % - valor: % - total_his: % - total: %', v_valparc, v_record_recpar.valor, v_record_recpar.total_his, v_total;
        end if;

        v_calcula_valor   = v_record_recpar.valor;
        v_calcula_his     = round( v_valparc / v_record_recpar.valor * v_record_recpar.total_his ,2);
        v_calcula_cor     = round( v_valparc / v_record_recpar.valor * v_record_recpar.total_cor ,2);
        v_calcula_jur     = round( v_valparc / v_record_recpar.valor * v_record_recpar.total_jur ,2);
        v_calcula_mul     = round( v_valparc / v_record_recpar.valor * v_record_recpar.total_mul ,2);
        v_calcula_desccor = round( v_valparc / v_calcula_valor * v_record_recpar.total_desccor ,2);
        v_calcula_descjur = round( v_valparc / v_calcula_valor * v_record_recpar.total_descjur ,2);
        v_calcula_descmul = round( v_valparc / v_calcula_valor * v_record_recpar.total_descmul ,2);

            if lRaise then
          raise notice 'v_calcula_his: % - v_valparc: % - v_calcula_valor: % - total_desccor: %', v_calcula_his, v_valparc, v_calcula_valor, v_record_recpar.total_desccor;
        end if;

        if v_valparc > 0 then

          if round(v_valparc,2) > 0 then

            lIncluiEmParcelas = true;

          else

            perform * from parcelas where receit = v_record_recpar.receita;

            if found then
              lIncluiEmParcelas = false;
            else
              lIncluiEmParcelas = true;
            end if;

          end if;

          if lIncluiEmParcelas is true then

            -- insere valores calculados na tabela parcelas
            execute 'insert into parcelas values ('   ||
            v_parcela                                 || ',' ||
            v_record_recpar.receita                       || ',' ||
            v_record_recpar.receitaori                || ',' ||
            v_record_recpar.k00_hist                      || ',' ||
            v_valparc                                                     || ',' ||
            v_calcula_valprop                         || ',' ||
            v_calcula_his                             || ',' ||
            v_calcula_cor                             || ',' ||
            v_calcula_jur                             || ',' ||
            v_calcula_mul                             || ',' ||
            v_calcula_desccor                         || ',' ||
            v_calcula_descjur                         || ',' ||
            v_calcula_descmul                         ||
            ');';

          else

            execute 'update parcelas set '   ||
                    '  valor   = valor   + ' || v_valparc         ||
                    ', valprop = valprop + ' || v_calcula_valprop ||
                    ', valhis  = valhis  + ' || v_calcula_his     ||
                    ', valcor  = valcor  + ' || v_calcula_cor     ||
                    ', valjur  = valjur  + ' || v_calcula_jur     ||
                    ', valmul  = valmul  + ' || v_calcula_mul     ||
                    ', descor  = descor  + ' || v_calcula_desccor ||
                    ', descjur = descjur + ' || v_calcula_descjur ||
                    ', descmul = descmul + ' || v_calcula_descmul ||
                    ' where receit = ' || v_record_recpar.receita;

          end if;

        end if;
                
            end loop;

        end loop;

        if lRaise then
--      raise notice 'SQL PRINCIPAL - % ',v_comando;
    end if;

        -- se regra for de juros na ultima
        if v_juronaultima is true then
            
            if lRaise is true then
                raise notice 'processando ultima... diferenca: %', v_totalcomjuro - v_total;
            end if;
            
            -- soma 1 na variavel do total de parcelas
            v_totalparcelas = v_totalparcelas + 1;
            
            -- gera comando para agrupar receita por receita somando o valor
            v_comando =              ' select arrecad_parc_rec. ';
            v_comando = v_comando || '        receit as receita, ';
            v_comando = v_comando || '            sum(arrecad_parc_rec.valor) as valor ';
            v_comando = v_comando || '   from arrecad_parc_rec ';
            v_comando = v_comando || '  where juro is true ';
            v_comando = v_comando || '  group by arrecad_parc_rec.receit ';
            
            select v04_histjuros from pardiv into v_histjuro;
            if v_histjuro is null then
                v_histjuro = 1;
            end if;
            
            for v_record_recpar in
                execute v_comando
                loop
                
                v_valorinserir = round(v_record_recpar.valor,2);
                
                if lRaise is true then
                    raise notice '111 = inserindo diferenca: % - receita: % - valor: %', v_valorinserir, v_record_recpar.receita, v_record_recpar.valor;
                end if;
                
                execute 'insert into parcelas values (' ||
                v_totalparcelas || ',' ||
                v_record_recpar.receita  || ',' ||
                v_record_recpar.receita  || ',' ||
                v_histjuro || ',' ||
                v_valorinserir || ',' ||
                (v_valorinserir) / v_totalcomjuro ||
                ');';
                
            end loop;
            
            v_total = v_totalcomjuro;
            
        end if;

        if lRaise is true then
            raise notice 'saindo do tipo 5...';
        end if;
      
    if lRaise is true then
      raise notice ' ';
      raise notice '-';
      raise notice ' ';
      raise notice 'terminou de gravar na tabela parcelas...';
    end if;

    update parcelas set valor = w_testando.valor, 
                        valhis = w_testando.total_his, 
                        valcor = w_testando.total_cor, 
                        valjur = w_testando.total_jur, 
                        valmul = w_testando.total_mul, 
                        descor = w_testando.total_desccor, 
                        descjur = w_testando.total_descjur, 
                        descmul = w_testando.total_descmul
    from w_testando 
    where receit = w_testando.receita and parcelas.valor = 0;

        -- calcula a maior parcela e a soma do valor dos registros da tabela parcelas
    select max(parcela), 
                     sum(valor) 
    from parcelas 
    into v_totpar, v_somar;
    
    if lRaise is true then
      raise notice 'total de parcelas: % - v_somar: %', v_totpar, v_somar;
    end if;

        -- testa se ocorreu alguma inconsistencia
    if v_totpar = 0 or v_totpar is null then
      return 'erro ao gerar parcelas... provavelmente falta recparproc...';
    end if;

    select round(sum(valor),2)
    into v_totalliquido
    from parcelas;

    if lRaise is true or 1=1 then
      raise notice 'v_totalliquido: %', v_totalliquido;
    end if;

    --raise notice 'trocando total (%) por total_liquido (%)', v_total, v_totalliquido;
    --v_total = v_totalliquido;

        -- se for 
        -- 6  = parcelamento de divida
        -- 16 = parcelamento de inicial
        -- 17 = parcelamento de melhorias
        -- 13 = inicial do foro
    if v_tipo in (6,16,17,13) then
            -- conta a quantidade de parcelamentos
      select count(v07_parcel) 
        into v_quantparcel
            from (select distinct 
                             v07_parcel 
                        from termo
                     inner join numpres_parc on termo.v07_numpre = numpres_parc.k00_numpre) as x;

      if v_quantparcel is null then
        return 'parcelamento nao encontrado pelo numpre';
      end if;

            -- registra o codigo do parcelamento
      select v07_parcel 
            into v_termo_ori
              from termo 
             inner join numpres_parc on termo.v07_numpre = numpres_parc.k00_numpre
      limit 1;

    end if;
        -- recebe o codigo do novo parcelamento
        select nextval('termo_v07_parcel_seq') into v_termo;
    
        -- recebe o numpre do novo parcelamento
    select nextval('numpref_k03_numpre_seq') into v_numpre;
    
    if lRaise is true then
      raise notice 'termo %',v_termo;
      raise notice 'numpre %',v_numpre;
    end if;
    
        -- se for reparelamento pega todos os parcelamentos atuais e troca a situacao para 3(inativo)
    if lParcParc then
      for v_record_origem in 
        select distinct v07_parcel 
                from termo
               inner join numpres_parc on termo.v07_numpre = numpres_parc.k00_numpre
      loop
                -- inativa o parcelamento
        update termo set v07_situacao = 3 where v07_parcel = v_record_origem.v07_parcel;
      end loop;
    end if;

    --if lSeparaJuroMulta and 1=2 then  
      /**
       *  Funcao fc_SeparaJuroMulta() 
       *
       *    Esta funcao separa o valor do juros e da multa 
       *    em registros separados, lancando valor na receita de juro e multa 
       *    configurada na tabrec.
       */
      --select * from fc_SeparaJuroMulta() into rSeparaJurMul;

    --end if;
   
        -- registra o ano do vencimento da segunda parcela
    select extract (year from v_segvenc) into v_anovenc;
        -- registra o mes do vencimento da segunda parcela
    select extract (month from v_segvenc) into v_mesvenc;
    
    if lRaise is true then
      raise notice 'v_anovenc: % - v_mesvenc: %', v_anovenc, v_mesvenc;
    end if;
    
-- return 'xxx';

    v_somar = 0;
        -- soma o valor total da tabela parcelas, apenas para conferencia
    for v_record_recpar in select parcela, receit, valor from parcelas 
        loop
      v_somar = v_somar + v_record_recpar.valor;
      if lRaise is true then
        raise notice 'parcela: % - receita: % - valor: %',v_record_recpar.parcela, v_record_recpar.receit, v_record_recpar.valor;
      end if;
    end loop;
    
    if lRaise is true then
      raise notice 'v_somar: %', v_somar;
    end if;
    
        -- exibe os valores da tabela parcelas agrupado por receita, apenas para conferencia
    for v_record_recpar in select receit, round(sum(valor),2) as valor, round(sum(valhis+valcor+valjur+valmul-descor-descjur-descmul),2) as sum 
                                  from parcelas 
                                  group by receit loop
      if lRaise is true then
        raise notice 'valor da receita: % - liquido: % - valor: %', v_record_recpar.receit, v_record_recpar.sum, v_record_recpar.valor;
      end if;
    end loop;

        -- varre a tabela parcelas por receita para gravar os registros no arrecad
        -- existe uma tabela chamada totrec que recebe os valores ja processados e armazena por receita

--  return '9 - teste';

    -- verifica se tem registro na tabela de configuracao da receita forcada como receita de destino
    
    for v_record_recpar in select distinct receitaori from parcelas loop

      select  case when coalesce( (select count(*) from recreparcori a inner join recreparcarretipo on k72_codigo = a.k70_codigo where a.k70_recori = recreparcori.k70_recori ),0) = 0
                then k71_recdest
              else
                case when coalesce( ( select count(*) from recreparcarretipo where k72_codigo = recreparcori.k70_codigo and k72_arretipo = v_tiponovo ),0) = 0 then null else k71_recdest end
              end as destino
        into v_recdestino
        from recreparcori 
             inner join recreparcdest on k70_codigo = k71_codigo 
       where k70_recori = v_record_recpar.receitaori
         and v_totparc >= k70_vezesini 
         and v_totparc <= k70_vezesfim
         and 
         (
         ( (select count(*) from recreparcori a inner join recreparcarretipo on k72_codigo = a.k70_codigo where a.k70_recori = recreparcori.k70_recori) = 0 and (select count(*) from recreparcarretipo where k72_codigo = recreparcori.k70_codigo and k72_arretipo = v_tiponovo) = 0 ) 
         or 
         (select count(*) from recreparcori a inner join recreparcarretipo on k72_codigo = a.k70_codigo where a.k70_recori = recreparcori.k70_recori) > 0 and (select count(*) from recreparcarretipo where k72_codigo = recreparcori.k70_codigo and k72_arretipo = v_tiponovo) > 0
         );

      
       if lRaise is true or 1=1 then
         raise notice 'v_recdestino: % - receitaori: % - v_totparc: % - v_tiponovo: %', v_recdestino, v_record_recpar.receitaori, v_totparc, v_tiponovo;
       end if;

       if v_recdestino is not null or v_recdestino <> 0 then
         execute ' update parcelas set receit = ' || v_recdestino || ' where ' ||
                 ' receitaori = ' || v_record_recpar.receitaori || ';';
       end if;
       
    end loop;

    create temp table w_base_parcelas as 
      select parcela, 
             receit, 
             min(hist)                as hist, 
             round(sum(valor),2)      as valor, 
             sum(valprop)             as valprop,
             round(sum(valhis),2)     as valhis, 
             round(sum(valcor),2)     as valcor,
             round(sum(valjur),2)     as valjur,
             round(sum(valmul),2)     as valmul,
             round(sum(descor),2)     as descor,
             round(sum(descjur),2)    as descjur,
             round(sum(descmul),2)    as descmul
       from parcelas 
       group by parcela, receit
       order by receit, parcela;

    if lRaise is true then
      raise notice 'total de parcelas: % - v_somar: %', v_totpar, v_somar;
    end if;

    if lRaise is true then
        raise notice ' ';
        raise notice ' ';
        raise notice ' ';
        raise notice ' ';
        raise notice ' ';
    end if;

    for v_record_recpar in 
      select * from w_base_parcelas
--      where valor > 0
      order by parcela, receit
    loop
      
      if lRaise is true then
        raise notice '   inicio do loop... parcela: % - receita: % - v_totalparcelas: % - valor: % - valprop: %', v_record_recpar.parcela, v_record_recpar.receit, v_totalparcelas, v_record_recpar.valor, v_record_recpar.valprop;
      end if;

      lParcelaZerada=false;

            -- conta o total de parcelas desta receita
      select max(parcela) 
      into v_totparcdestarec 
      from parcelas
      where receit = v_record_recpar.receit;

            -- soma o que ja foi inserido na tabela totrec da receita do registro atual
      select coalesce(sum(valor),0) into v_totateagora from totrec where receit = v_record_recpar.receit;
            -- soma o total do valor da tabela parcelas da receita do registro atual
      -- V E R I F I C A R
      select round(sum(valor+valcor+valjur+valmul),2) into v_calcular from parcelas where receit = v_record_recpar.receit;

      if lRaise is true then
        raise notice 'v_calcular: %', v_calcular;
      end if;
      
      if lRaise is true then
        raise notice ' ';
        raise notice 'total desta receita: % - ate agora: %', v_record_recpar.receit, v_totateagora;
        raise notice ' ';
      end if;
      
            -- registra o valor da receita do registro atual
      v_valparc = round(v_record_recpar.valor,2);
        
      -- se for a ultima parcela
      if v_record_recpar.parcela = v_totalparcelas then
        
                -- se for juros na ultima
        if v_juronaultima is true then
                    -- valor da parcela recebe exatamente o valor registrado na receita do registro atual
          v_valparc = v_valparc;
        else
          
          if lRaise is true then
            raise notice 'U L T I M A... - RECEITA: %', v_record_recpar.receit;
            raise notice 'v_totalparcelas: % - v_valparc: % - v_entrada: % - v_total: % - valprop: %', v_totalparcelas, v_valparc, v_entrada, v_total, v_record_recpar.valprop;
          end if;
          
          if lRaise is true then
            raise notice 'total desta receita: % - ate agora: %', v_record_recpar.receit, v_totateagora;
          end if;
          
                    -- saldo e calculado com
                    -- (o total de parcelas - 2) * valor registrado na receita do registro atual
          --v_saldo = round((v_totalparcelas - 2) * ( v_valparc + v_record_recpar.valcor + v_record_recpar.valjur + v_record_recpar.valmul),2);
          v_saldo = round((v_totalparcelas - 2) * ( v_valparc ),2);

          if lRaise is true then
            raise notice 'Saldo Atual: %', v_saldo;
          end if;
          
                    -- saldo eh calculado com
                    -- saldo calculado + ( entrada * valor proporcional dessa receita em relacao ao total do parcelamento )
          v_saldo = round(v_saldo + ( v_entrada * v_record_recpar.valprop ),2);
          
          if lRaise is true then
            raise notice '111 - v_saldo: % - v_totateagora: % - v_calcular: %', v_saldo, v_totateagora, v_calcular;
          end if;
          
          if lRaise is true then
            raise notice 'totateagora: % - total: % - valprop: % - saldo: % - rec: % - parc: % - hist: %', v_totateagora, v_total, v_record_recpar.valprop, v_saldo, v_record_recpar.receit, v_record_recpar.parcela, v_record_recpar.hist;
          end if;
          
                    -- se total ate agora for maior ou igual ao total do parcelamento * valor proporcional dessa receita em relacao ao total do parcelamento
          if round(v_totateagora,2) >= round(v_total * v_record_recpar.valprop,2) then
            if lRaise is true then
              raise notice 'v_totateagora: % - v_total: % - valprop: %', v_totateagora, v_total, v_record_recpar.valprop;
              raise notice 'passou na ultima...';
            end if;
                        -- valor da parcela recebe zero
            v_valparc = 0;
            lParcelaZerada=true;
            continue;

                    -- se total ate agora for menor ao total do parcelamento * valor proporcional dessa receita em relacao ao total do parcelamento
          else
                        
            if lRaise is true then
              raise notice 'nao passou na ultima... v_total: % - v_saldo: % - prop: %', v_total, v_saldo, v_record_recpar.valprop;
            end if;

                        -- valor da parcela recebe: (total do parcelamento * valor proporcional dessa receita em relacao ao total do parcelamento) - saldo calculado
            v_valparc = round(round((v_total * v_record_recpar.valprop),2) - v_saldo,2);

            if lRaise is true then
              raise notice 'v_valparc: %', v_valparc;
            end if;

                        -- se valor da parcela for menor que zero
            if v_valparc < 0 then
                            -- valor da parcela recebe
                            -- (total do parcelamento * valor proporcional dessa receita em relacao ao total do parcelamento) - saldo - valor da parcela
              v_valparc = round((v_total * v_record_recpar.valprop) - v_saldo,2)::float8 - round(v_valparc,2)::float8;
              if lRaise is true then
                raise notice ' ';
                raise notice 't e s t e: %', v_valparc;
                raise notice ' ';
              end if;
            end if;

            --v_valparc := ( v_valparc - ( v_record_recpar.valcor + v_record_recpar.valjur + v_record_recpar.valmul ) );
            
          end if;

          if lRaise is true then
            raise notice 'Valor ultima parcela : % ', v_valparc;
          end if;
          
                    -- resto recebe valor da parcela + total ate agora
          v_resto = v_valparc + v_totateagora;
          
          if lRaise is true then
            raise notice '222 - v_saldo: % - totateagora: % - v_valparc: % - v_calcular: %', v_saldo, v_resto, v_valparc, v_calcular;
          end if;
          
        end if;
       
            -- se nao for a ultima parcela
      else
        
        if lRaise is true then
          raise notice ' ';
          raise notice ' n a o   e   a   u l t i m a ';
          raise notice ' ';
        end if;
        
                -- se for juros na ultima
        if v_juronaultima is true then
         
                  -- se eh a penultima parcela
          if v_record_recpar.parcela = (v_totalparcelas - 1) then
            
            if lRaise is true then
              raise notice 'nessa';
            end if;
            
          end if;
          
        end if;
        
        if lRaise is true then
          raise notice 'v_totalparcelas: % - v_valparc: % - v_entrada: % - valprop: % - v_total: %', v_totalparcelas, v_valparc, v_entrada, v_record_recpar.valprop, v_total;
        end if;
        
                -- saldo recebe (total de parcelas - 2) * valor da parcela
        -- V E R I F I C A R
        v_saldo = round((v_totalparcelas - 2) * ( v_valparc + v_record_recpar.valcor + v_record_recpar.valjur + v_record_recpar.valmul ),2);
        
                -- saldo recebe: saldo + (entrada * valor proporcional dessa receita em relacao ao total do parcelamento) - saldo - valor da parcela)
        v_saldo = round(v_saldo + (v_entrada * v_record_recpar.valprop),2);

        if lRaise is true then
          raise notice 'v_valparc: %', v_valparc;
          raise notice 'parcela: % - v_valparc: % - saldo: % - resto: %', v_record_recpar.parcela, v_valparc, v_saldo, v_resto;
        end if;
        
                -- se total ate agora for maior que total da receita do registro atual
        if round(v_totateagora,2) > round(v_calcular,2) then
                    
          -- (desativado) v_valparc = round(v_saldo - round((v_record_recpar.parcela - 1) * v_valparc,2)::float8,2);
                    -- valor da parcela recebe zero
          v_valparc = 0;
          if lRaise is true then
            raise notice 'Valor da parcela recebendo ZERO valparc : %', v_valparc;
            raise notice '111111111111111111111';
          end if;
         
                -- se total ate agora for menor ou igual que total da receita do registro atual
        else
          
                    -- valor ate agora recebe: parcela * valor da parcela
          -- V E R I F I C A R
          v_vlrateagora = round(v_record_recpar.parcela * ( v_valparc + v_record_recpar.valcor + v_record_recpar.valjur + v_record_recpar.valmul ),2);
          
          if lRaise is true then
            raise notice 'v_vlrateagora: % - v_valparc: % ', v_vlrateagora, v_valparc;
          end if;
          
                    -- resto recebe: (valor total do parcelamento * valor proporcional dessa receita em relacao ao total do parcelamento) - saldo
          v_resto = round(round(v_total * v_record_recpar.valprop,2) - round(v_saldo,2),2);
          
          if lRaise is true then
            raise notice 'parcela: % - v_valparc: % - saldo: % - resto: %', v_record_recpar.parcela, v_valparc, v_saldo, v_resto;
          end if;
          
          if lRaise is true then
            raise notice 'v_totateagora: % - v_valparc: % - v_calcular: %', v_totateagora, v_valparc, v_calcular;
          end if;
          
                    -- se (total ate agora + valor da parcela) for maior que total da receita do registro atual
          if round(round(v_totateagora,2) + round(v_valparc,2),2) > round(v_calcular,2) then
                        -- valor da parcela recebe: total da receita do registro atual - total ate agora
            v_valparc = round( round(v_calcular,2) - round(v_totateagora,2),2 );
            if lRaise is true then
              raise notice '22222222222';
            end if;
          end if;
          
        end if;
        
      end if;
      
      if lRaise is true then
        raise notice '   ...';
      end if;

      -- se parcela = 1
      if v_record_recpar.parcela = 1 then
                -- vencimento igual ao vencimento da entrada especificada na CGF
        v_vcto = v_privenc;
                -- valor da parcela = entrada * proporcionalidade
        if lRaise is true then
          raise notice 'v_entrada: % - valprop: % - valcor: % - valju: % - valmul: %', v_entrada, v_record_recpar.valprop, v_record_recpar.valcor, v_record_recpar.valjur, v_record_recpar.valmul;
        end if;

        if lRaise is true then
          raise notice '   1 === v_valparc: % - v_entrada: % - valprop: %', v_valparc, v_entrada, v_record_recpar.valprop;
        end if;
        v_valparc = round( ( v_entrada ) * v_record_recpar.valprop,2);
        if lRaise is true then
          raise notice '   2 === v_valparc: %', v_valparc;
        end if;

      elsif v_record_recpar.parcela = 2 then
              -- vencimento = vencimento da segunda parcela especificada na CGF
        v_vcto = v_segvenc;
      else
        
                -- soma meses para calcular vencimento baseado na data de vencimento da parcela 2
        execute 'truncate vcto';
        v_comando = 'insert into vcto select ' || '''' || to_char(v_segvenc,'yyyy') || '-' || trim(to_char(v_segvenc, 'mm')) || '-' || trim(to_char(v_segvenc, 'dd')) || '''' || '::date' || '+' || '''' || v_record_recpar.parcela - 3 || ' months' || '''' || '::interval';
        execute v_comando;
        
        select extract (month from data),
               extract (year from data)
        from vcto 
        into v_mesvenc, 
        v_anovenc;
        
        if lRaise is true then
          raise notice '\n';
          raise notice 'v_mesvenc: % - parcela: %', v_mesvenc, v_record_recpar.parcela;
          raise notice '\n';
        end if;
        
                -- se mes for 12 (dezembro)
        if to_number(to_char(v_segvenc,'mm'), '999') = 12 then
                    -- proximo mes = 1 (janeiro)
          v_proxmessegvenc = 1;
        else
                    -- soma mes
          v_proxmessegvenc = to_number(to_char(v_segvenc,'mm'), '999') + 1;
        end if;
        
                -- faz o mes ficar sempre com 2 digitos
        if v_proxmessegvenc < 10 then
          v_proxmessegvenc_c = '0' || trim(to_char(v_proxmessegvenc, '99'));
        else
          v_proxmessegvenc_c = trim(to_char(v_proxmessegvenc, '999'));
        end if;
        
                -- registra o dia do proximo vencimento especifidada na CGF
        v_dia = v_diaprox;
        
                -- soma 1 no mes de vencimento
        v_mesvenc = v_mesvenc + 1;
        if lRaise is true then
          raise notice '   executando vcto... v_segvenc: % - v_diaprox: % - v_dia: % - v_mesvenc: % - parc: %', v_segvenc, v_diaprox, v_dia, v_mesvenc, v_record_recpar.parcela;
        end if;
        
                -- se ultrapassar dezembro, passa para janeiro do ano seguinte
        if v_mesvenc = 13 then
          v_mesvenc = 1;
          v_anovenc = v_anovenc + 1;
        end if;
        
        v_mesvencprox = v_mesvenc + 1;
        v_anovencprox = v_anovenc;
        
                -- se ultrapassar dezembro, passa para janeiro do ano seguinte
        if v_mesvencprox = 13 then
          v_mesvencprox = 1;
          v_anovencprox = v_anovencprox + 1;
        end if;
        
        if lRaise is true then
          raise notice 'quase... v_mesvencprox: % - v_anovencprox: %', v_mesvencprox, v_anovencprox;
        end if;
                -- calcula ultimo dia de fevereiro
        v_ultdiafev_c   = trim(to_char(v_anovencprox,'99999')) || '-' || trim(to_char(v_mesvencprox, '999')) || '-01';
        if lRaise is true then
          raise notice '   1 - v_ultdiafev_c: %', v_ultdiafev_c;
        end if;
                -- calcula ultimo dia de fevereiro
        v_ultdiafev_d   = trim(v_ultdiafev_c)::date - 1;
                
        if lRaise is true then
          raise notice '   2 - v_ultdiafev_d: %', v_ultdiafev_d;
        end if;
                -- calcula ultimo dia de fevereiro
        v_ultdiafev = to_number(to_char(v_ultdiafev_d, 'dd'), '999');
        
                -- testa se dia e valido nos meses
        if v_dia = 31 and v_mesvenc in (4, 6, 9, 11) then
          v_dia = 30;
          if lRaise is true then
            raise notice 'mudando 1';
          end if;
        elsif v_dia >= 30 and v_mesvenc in (2) then
          v_dia = 28;
          if lRaise is true then
            raise notice 'mudando 2';
          end if;
        end if;
        
        if lRaise is true then
          raise notice 'mesvenc: % - dia: %', v_mesvenc, v_dia;
        end if;
        
                -- calcula se vencimento e correto
        if v_mesvenc = 2 and v_dia >= 28 then
          if lRaise is true then
            raise notice 'fevereiro...';
          end if;
          v_dia = v_ultdiafev;
        end if;
        
                -- calcula vencimento
        execute 'truncate vcto';
        v_comando = 'insert into vcto select ' || '''' || to_char(v_anovenc,'99999') || '-' || trim(trim(to_char(v_mesvenc, '999'))) || '-' || trim(to_char(v_dia, '999')) || '''' || '::date';
        execute v_comando;
        select data from vcto into v_vcto;
        if lRaise is true then
          raise notice '   fim vcto... %', v_vcto;
        end if;
        
      end if;
      
      if lRaise is true then
        raise notice '          inserindo em totrec a parcela % no valor de %', v_record_recpar.parcela, v_valparc;
      end if;
      
            -- insere na tabela totrec o registro atual com o valor da parcela
      execute 'insert into totrec values (' || v_record_recpar.receit || ', ' || v_record_recpar.parcela || ', ' || v_valparc || ')';
      
      if lRaise is true then
        raise notice '1 - parcela: % - valor: % ',v_record_recpar.parcela,v_valparc;
      end if;
      
      if lRaise is true then
        raise notice 'k00_numcgm: % - k00_receit: % - k00_hist: % - k00_valor: % - k00_dtvenc: % - k00_numpre: % - k00_numpar: % - k000_numtot: % - k00_tipo: %',v_cgmpri,v_record_recpar.receit,v_record_recpar.hist,v_valparc,v_vcto,v_numpre,v_record_recpar.parcela,v_totalparcelas,v_tiponovo;
      end if;

      v_recdestino = v_record_recpar.receit;

     -- verifica se tem registro na tabela de configuracao da receita forcada como receita de destino
---- comentado em 16/08/2010 por evandro devido ao fato de isso estar sendo processado antes desse for principal
---- buscando na recreparcori se existe receita destino
----      select k71_recdest    
----      into v_recdestino 
----      from recreparcori 
----           inner join recreparcdest on k70_codigo = k71_codigo 
----      where k70_recori = v_record_recpar.receitaori 
----        and v_totparc >= k70_vezesini 
----        and v_totparc <= k70_vezesfim;
      
----      if v_recdestino is null then
----        v_recdestino = v_record_recpar.receit;
----        if lRaise is true then
----          raise notice 'nao achou em recreparcori... receita: %', v_record_recpar.receit;
----        end if;
----      else
----        if lRaise is true then
----          raise notice 'achou em recreparcori... receita: %', v_record_recpar.receit;
----        end if;
----      end if;

      if lRaise is true then
        raise notice '   no arrecad... val: % - recdest: % - vcto: % - parcela: %', v_valparc, v_recdestino, v_vcto, v_record_recpar.parcela;
      end if;

      if v_valparc < 0 then
        return '3 - valor da parcela ' || v_record_recpar.parcela || ' menor que zero: ' || v_valparc;
      elsif v_valparc = 0 then
        return '3 - valor da parcela ' || v_record_recpar.parcela || ' zerada: ' || v_valparc;
      end if;
      
            -- se valor da parcela maior que zero
            -- insere no arrecad

      if lRaise is true then
        raise notice 'k00_numpre : % k00_numpar : % k00_receit : % k00_valor : % ',v_numpre,
                                                                                 v_record_recpar.parcela,
                                                                                 v_recdestino,
                                                                                 v_valparc;
      end if;

-- raise notice 'gerando arrecad -- valor : % vlrcor : % vlrjur : % vlrmul : %',v_valparc,v_record_recpar.valcor,v_record_recpar.valjur,v_record_recpar.valmul;
      lGravaArrecad = true;

      if v_valparc > 0 then

        if lSeparaJuroMulta = 1 then
          --and ( v_record_recpar.valjur > 0 or v_record_recpar.valmul > 0 or v_record_recpar.valcor > 0 )

          iSeqArrecKey := nextval('arreckey_k00_sequencial_seq');
          insert into arreckey ( k00_sequencial,
                                 k00_numpre,    
                                 k00_numpar,    
                                 k00_receit,    
                                 k00_hist )
                        values ( iSeqArrecKey,
                                 v_numpre,
                                 v_record_recpar.parcela,
                                 v_recdestino,
                                 v_record_recpar.hist );
           
          select round(sum(valhis),2)               into v_total_historico from w_base_parcelas where receit = v_record_recpar.receit;
          select round(sum(valcor-descor-valhis),2) into v_total_correcao  from w_base_parcelas where receit = v_record_recpar.receit;
          select round(sum(valjur-descjur),2)       into v_total_juros     from w_base_parcelas where receit = v_record_recpar.receit;
          select round(sum(valmul-descmul),2)       into v_total_multa     from w_base_parcelas where receit = v_record_recpar.receit;

          if lRaise is true then
            raise notice 'v_recdestino: % - v_record_recpar.receit: %', v_recdestino, v_record_recpar.receit;
            raise notice 'parcela: % - receita: % - v_valparc: % - v_total_historico: % - v_somar: %', v_record_recpar.parcela, v_record_recpar.receit, v_valparc, v_total_historico, v_somar;
          end if;

          if lRaise is true then
            raise notice 'ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ';
            raise notice '   valhis: % - valcor: % - valjur: % - valmul: %', v_record_recpar.valhis, v_record_recpar.valcor, v_record_recpar.valjur, v_record_recpar.valmul;
            raise notice 'v_valparc: % - valhis: % - valor: % - total: % - total_historico: %', v_valparc, v_record_recpar.valhis, v_record_recpar.valor, v_total, v_total_historico;
          end if;

          v_historico_compos = v_record_recpar.valhis;
          v_correcao_compos  = ( v_record_recpar.valcor - v_record_recpar.descor - v_record_recpar.valhis );
          v_juros_compos     = ( v_record_recpar.valjur - v_record_recpar.descjur );
          v_multa_compos     = ( v_record_recpar.valmul - v_record_recpar.descmul );

          if lRaise is true then
            raise notice '      v_historico_compos: %', v_historico_compos;
            raise notice '      v_correcao_compos.: %', v_correcao_compos;
            raise notice '      v_juros_compos ...: %', v_juros_compos;
            raise notice '      v_multa_compos ...: %', v_multa_compos;
            raise notice '   v_total_historico: % - v_total_correcao: % - v_total_juros: % - v_total_multa: %', v_total_historico, v_total_correcao, v_total_juros, v_total_multa;
          end if;

          if lRaise is true then
            raise notice 'parcela: % - v_totparcdestarec: %', v_record_recpar.parcela, v_totparcdestarec;
          end if;

          if v_record_recpar.parcela = v_totparcdestarec then
            -- historico
            v_diferenca_historico = 0;

            select coalesce(sum(k00_vlrhist),0)
            into v_diferenca_historico + v_historico_compos
            from arreckey 
            inner join arrecadcompos on arreckey.k00_sequencial = arrecadcompos.k00_arreckey
            where k00_numpre = v_numpre and k00_receit = v_recdestino;
            if lRaise is true then
              raise notice 'v_diferenca_historico: % - v_total_historico: %', v_diferenca_historico, v_total_historico;
            end if;
            if v_diferenca_historico > v_total_historico then
              v_teste = round(v_total_historico - v_diferenca_historico,2);
              if lRaise is true then
                raise notice 'v_teste: %', v_teste;
              end if;
              --v_historico_compos = v_historico_compos + round(v_total_historico - v_diferenca_historico,2);
            end if;
            if lRaise is true then
              raise notice 'v_historico_compos: %', v_historico_compos;
            end if;

            -- correcao
            v_diferenca_correcao = 0;
            select coalesce(sum(k00_correcao),0)
            into v_diferenca_correcao + v_correcao_compos
            from arreckey 
            inner join arrecadcompos on arreckey.k00_sequencial = arrecadcompos.k00_arreckey
            where k00_numpre = v_numpre and k00_receit = v_recdestino;
            if lRaise is true then
              raise notice 'v_diferenca_correcao: % - v_total_correcao: %', v_diferenca_correcao, v_total_correcao;
            end if;
            if v_diferenca_correcao > v_total_correcao then
              v_teste = round(v_total_correcao - v_diferenca_correcao,2);
              if lRaise is true then
                raise notice 'v_teste: %', v_teste;
              end if;
              --v_correcao_compos = v_correcao_compos + round(v_total_correcao - v_diferenca_correcao,2);
            end if;
            if lRaise is true then
              raise notice 'v_correcao_compos: %', v_correcao_compos;
            end if;

            -- juros
            v_diferenca_juros = 0;
            select coalesce(sum(k00_juros),0)
            into v_diferenca_juros + v_juros_compos
            from arreckey 
            inner join arrecadcompos on arreckey.k00_sequencial = arrecadcompos.k00_arreckey
            where k00_numpre = v_numpre and k00_receit = v_recdestino;
            if lRaise is true then
              raise notice 'v_diferenca_juros: % - v_total_juros: %', v_diferenca_juros, v_total_juros;
            end if;
            if v_diferenca_juros > v_total_juros then
              v_teste = round(v_total_juros - v_diferenca_juros,2);
              if lRaise is true then
                raise notice 'v_teste: %', v_teste;
              end if;
              --v_juros_compos = v_juros_compos + round(v_total_juros - v_diferenca_juros,2);
            end if;
            if lRaise is true then
              raise notice 'v_juros_compos: %', v_juros_compos;
            end if;

            -- multa
            v_diferenca_multa = 0;
            select coalesce(sum(k00_multa),0)
            into v_diferenca_multa + v_multa_compos
            from arreckey 
            inner join arrecadcompos on arreckey.k00_sequencial = arrecadcompos.k00_arreckey
            where k00_numpre = v_numpre and k00_receit = v_recdestino;
            if lRaise is true then
              raise notice 'v_diferenca_multa: % - v_total_multa: %', v_diferenca_multa, v_total_multa;
            end if;
            if v_diferenca_multa > v_total_multa then
              v_teste = round(v_total_multa - v_diferenca_multa,2);
              if lRaise is true then
                raise notice 'v_teste: %', v_teste;
              end if;
              --v_multa_compos = v_multa_compos + round(v_total_multa - v_diferenca_multa,2);
            end if;
            if lRaise is true then
              raise notice 'v_multa_compos: %', v_multa_compos;
            end if;

          end if;

          if v_historico_compos <= 0 then
--            lGravaArrecad = false;
            if lRaise is true then
              raise notice 'xxx: % - yyy: %', v_record_recpar.valhis, v_record_recpar.valor;
            end if;
          end if;

          if v_record_recpar.valhis = 0 and v_record_recpar.valor > 0 and 1=2 then
            --return 'valhis maior que valor';
            v_historico_compos  = round(v_record_recpar.valor,2);
            v_correcao_compos   = 0;
            v_juros_compos      = 0;
            v_multa_compos      = 0;
          end if;

          iSeqArrecadcompos := nextval('arrecadcompos_k00_sequencial_seq');
          insert into arrecadcompos ( k00_sequencial,
                                      k00_arreckey,  
                                      k00_vlrhist, 
                                      k00_correcao,  
                                      k00_juros,     
                                      k00_multa )
                             values ( iSeqArrecadcompos,
                                      iSeqArrecKey,
                                      v_historico_compos,
                                      v_correcao_compos,
                                      v_juros_compos,
                                      v_multa_compos );

          v_valor_parcela_teste = v_historico_compos + v_correcao_compos + v_juros_compos + v_multa_compos;

          if lRaise is true then
            raise notice 'parc: % - rec: % - v_hist_compos: % - v_cor_compos: % - v_jur_compos: % - v_mul_compos: % - totparc: %', v_record_recpar.parcela, v_recdestino, v_historico_compos, v_correcao_compos, v_juros_compos, v_multa_compos, v_valor_parcela_teste;
          end if;

          if v_historico_compos = 0 and v_correcao_compos = 0 and v_juros_compos = 0 and v_multa_compos = 0 then
            v_valparc = 0;
            lGravaArrecad = false;
          else
            v_valparc = round(v_historico_compos,2);
          end if;
   
        end if;

        if lRaise is true then
          raise notice '   ============= (2) numpar: % - receit: % - v_valparc: %', v_record_recpar.parcela, v_recdestino, v_valparc;
        end if;

        if lSeparaJuroMulta = 2 then
          if (round(v_valparc,2) <= 0 or v_valparc is null) then
            return '14 - valor da parcela ' || trim(to_char(v_record_recpar.parcela, '999')) || ' zerada ou em branco! Contate suporte';
          end if;
        end if;

        if lGravaArrecad is true then

          insert into arrecad (k00_numcgm,k00_dtoper,k00_receit,k00_hist,k00_valor,k00_dtvenc,k00_numpre,k00_numpar,k00_numtot,k00_numdig,k00_tipo,k00_tipojm)
                      values (v_cgmpri,dDataUsu,v_recdestino,v_record_recpar.hist,round(v_valparc,2),v_vcto,v_numpre,v_record_recpar.parcela,v_totalparcelas,0,v_tiponovo,0);

          select k00_valor into v_teste from arrecad where k00_numpre = v_numpre and k00_numpar = v_record_recpar.parcela and k00_receit = v_recdestino;

          if lRaise is true then
            raise notice '          gravando valor: % - round: % - teste: %', v_valparc, round(v_valparc,2), v_teste;
          end if;

        end if;

        if lRaise is true then
          raise notice ' ';
          raise notice ' ';
          raise notice ' ';
          raise notice ' ';
          raise notice ' ';
        end if;
  
      else
        raise notice 'valparc menor ou igual a zero: %', v_valparc;
      end if;
      
      if lRaise is true then
        raise notice 'origem: % - destino: %', v_record_recpar.receit, v_recdestino;
      end if;

      if lRaise is true then
        raise notice 'receita: % - totparc: %', v_record_recpar.receit, v_totparcdestarec;
      end if;
      
            -- conta o total de parcelas desta receita
      select count(*) 
      into v_totparcdestarec 
      from parcelas
      where receit = v_record_recpar.receit;

      if lRaise is true then
        raise notice 'receita: % - totparc: %', v_record_recpar.receit, v_totparcdestarec;
      end if;

            -- se parcela atual for igual a ultima parcela desta receita
      if v_record_recpar.parcela = v_totparcdestarec then
                -- reinicia as variaveis com os dados especificados na CGF para o vencimento da parcela 2
        select extract (year from v_segvenc) into v_anovenc;
        select extract (month from v_segvenc) into v_mesvenc;
      end if;
      
    end loop;

    if lRaise is true then
        raise notice ' ';
        raise notice ' ';
        raise notice ' ';
        raise notice ' ';
        raise notice ' ';
    end if;

    if lRaise is true then

      -- mostra os valores por parcela do arrecad, apenas para conferencia
      for v_record_recpar in
        select  k00_numpar, sum(k00_valor) 
        from arrecad
        where k00_numpre = v_numpre
        group by k00_numpar
      loop
        
        if lRaise is true then
          raise notice '2 - parcela: % - valor: %', v_record_recpar.k00_numpar, v_record_recpar.sum;
        end if;
        
      end loop;
            
    end if;

        -- sum do campo valor
        select sum(valor) 
          into nValorTotalOrigem
        from w_base_parcelas;

        for rPercOrigem in select numpre, numpar, receit, sum(valor) as valor from arrecad_parc_rec group by numpre, numpar, receit
    loop

--      raise notice 'valor: % - nValorTotalOrigem: %', rPercOrigem.valor, nValorTotalOrigem;

            nPercCalc := ( ( rPercOrigem.valor / nValorTotalOrigem ) * 100 );

      perform sum(k00_perc) 
        from ( select k00_matric as k00_origem,
                      coalesce(k00_perc, 100) as k00_perc,
                      1 as tipo
                 from arrematric
                where k00_numpre = rPercOrigem.numpre
               union
               select k00_inscr as k00_origem,
                      coalesce(k00_perc, 100) as k00_perc,
                      2 as tipo
                 from arreinscr
                where k00_numpre = rPercOrigem.numpre
               union
               select 0   as k00_origem,
                      100 as k00_perc,
                      3   as tipo
                 from arrenumcgm
                      left join arrematric on arrematric.k00_numpre = arrenumcgm.k00_numpre
                      left join arreinscr  on arreinscr.k00_numpre  = arrenumcgm.k00_numpre
                where arrematric.k00_numpre is null
                  and arreinscr.k00_numpre  is null
                  and arrenumcgm.k00_numpre = rPercOrigem.numpre
             ) as x
      having cast(sum(k00_perc) as numeric) <> cast(100 as numeric);
--      having cast(sum(k00_perc) as float8) <> cast(100 as float8);

      if found then
	        return '10 - Inconsistencia no percentual da origem - numpre: ' || rPercOrigem.numpre;
      end if;

      for v_record_perc in
                select k00_matric as k00_origem, 
                       coalesce(k00_perc, 100) as k00_perc, 
                             1 as tipo 
                from arrematric 
                 where k00_numpre = rPercOrigem.numpre
            union
                select k00_inscr as k00_origem, 
                       coalesce(k00_perc, 100) as k00_perc, 
                             2 as tipo
                  from arreinscr
                 where k00_numpre = rPercOrigem.numpre
            union
                select 0   as k00_origem, 
                       100 as k00_perc, 
                             3   as tipo
                  from arrenumcgm
               left join arrematric on arrematric.k00_numpre = arrenumcgm.k00_numpre
               left join arreinscr  on arreinscr.k00_numpre  = arrenumcgm.k00_numpre
                 where arrematric.k00_numpre is null 
           and arreinscr.k00_numpre  is null 
           and arrenumcgm.k00_numpre = rPercOrigem.numpre
            loop

        if lRaise then  
          raise notice '---------------------------------------------------------------';
          raise notice 'numpre: % - perc: % - tipo: % - percentual por registro: % ',rPercOrigem.numpre, v_record_perc.k00_perc, v_record_perc.tipo,nPercCalc;
          raise notice '---------------------------------------------------------------';
                end if;

                if v_record_perc.tipo = 1 then
            execute 'insert into arrecad_parc_rec_perc values (' ||
            rPercOrigem.numpre                                              || ',' ||
            rPercOrigem.numpar                                              || ',' ||
            rPercOrigem.receit                                              || ',' ||
            v_record_perc.k00_origem                                    || ',' ||
            nPercCalc * v_record_perc.k00_perc / 100  || ',' ||
            0                                                                                   || ',' ||
            0                                                                                   || ',' ||
            0                                                                                   || ',' ||
            v_record_perc.tipo                              || ');';
              elsif v_record_perc.tipo = 2 then
            execute 'insert into arrecad_parc_rec_perc values (' ||
            rPercOrigem.numpre                                              || ',' ||
            rPercOrigem.numpar                                              || ',' ||
            rPercOrigem.receit                                              || ',' ||
            0                                                                                   || ',' ||
            0                                                                                   || ',' ||
            v_record_perc.k00_origem                                    || ',' ||
            nPercCalc * v_record_perc.k00_perc / 100  || ',' ||
            0                                                                                   || ',' ||
            v_record_perc.tipo                              || ');';
              elsif v_record_perc.tipo = 3 then
            execute 'insert into arrecad_parc_rec_perc values (' ||
            rPercOrigem.numpre                                              || ',' ||
            rPercOrigem.numpar                                              || ',' ||
            rPercOrigem.receit                                              || ',' ||
            0                                                                                   || ',' ||
            0                                                                                   || ',' ||
            0                                                       || ',' ||
            0                                                                                   || ',' ||
            nPercCalc * v_record_perc.k00_perc / 100  || ',' ||
            v_record_perc.tipo                              || ');';
              end if;

            end loop;

        end loop;

-- return 'final';

  select (select sum(percmatric) from arrecad_parc_rec_perc) as percmatric,
         (select sum(percinscr)  from arrecad_parc_rec_perc) as percinscr,
         (select sum(perccgm)    from arrecad_parc_rec_perc) as perccgm,
         matric,
         numpre,
         numpar,
         receit 
    into nPercMatric,
         nPercInscr,
         nPercCGM,
         iUltMatric,
         iUltNumpre,
         iUltNumpar,
         iUltReceit
   from arrecad_parc_rec_perc 
   order by matric,
            numpre,
            numpar,
            receit 
       desc limit 1;

    sStringUpdate = '';

    if nPercMatric > 0.00 and nPercInscr = 0 and nPercCGM = 0 then
      sStringUpdate := 'percmatric = ( percmatric + (cast(100 as float8) - (select sum(percmatric) from arrecad_parc_rec_perc) ) )';
    elsif nPercInscr > 0.00 and nPercMatric = 0 and nPercCGM = 0 then
      sStringUpdate := 'percinscr = ( percinscr + (cast(100 as float8) - (select sum(percinscr) from arrecad_parc_rec_perc) ) )';
    elsif nPercCGM > 0.00 and nPercMatric = 0 and nPercInscr = 0 then
      sStringUpdate := 'perccgm = ( perccgm + (cast(100 as float8) - (select sum(perccgm) from arrecad_parc_rec_perc) ) )';
    end if;

    if sStringUpdate <> '' then

      execute ' update arrecad_parc_rec_perc 
                   set '||sStringUpdate||' 
                 where numpre = '||iUltNumpre||' 
                   and numpar = '||iUltNumpar||'
                   and receit = '||iUltReceit ;
   
    end if;

    nSomaPercMatric = 0;
    nTotArreMatric  = 0;

      select sum(percmatric)
      into nTotArreMatric 
      from arrecad_parc_rec_perc;   

    for rPercOrigem in select matric,sum(percmatric) as k00_perc,tipo
                         from arrecad_parc_rec_perc
                        where matric > 0
                        group by matric,tipo
    loop

      if lRaise then  
        raise notice '---------------------------------------------------------------';
              raise notice 'matric: % - perc: % numpre : %', rPercOrigem.matric, rPercOrigem.k00_perc, v_numpre ;
        raise notice '---------------------------------------------------------------';
            end if;
      -- tipo = 3 quer dizer que nao tem origem de matricula ou inscricao
      -- (o numpre origem esta somente na arrenumcgm ou seja nao precisa gravar percentual na arrematric ou arreinscr)
      if rPercOrigem.tipo <> 3 then
              insert into arrematric (k00_matric,k00_numpre,k00_perc)
                              values (rPercOrigem.matric,v_numpre,round(rPercOrigem.k00_perc,2));
      end if;

       v_totalzao       := (v_totalzao + rPercOrigem.k00_perc);
       nSomaPercMatric  := nSomaPercMatric + round(rPercOrigem.k00_perc, 2);

    end loop;

    if lRaise then  
      raise notice 'v_totalzao (1): %', v_totalzao;
    end if;

    if (nTotArreMatric-nSomaPercMatric) <> 0 and (nTotArreMatric-nSomaPercMatric) < 0.05 then
       
       if lRaise then 
         raise notice 'Encontrada Diferenca de Percentual. Total da Arrematric: % SomaPerc: % Diferenca: %',nTotArreMatric, nSomaPercMatric, nTotArreMatric-nSomaPercMatric; 
       end if;  

       update arrematric set k00_perc = round(k00_perc +  ( nTotArreMatric - nSomaPercMatric  ),2) 
        where k00_numpre = v_numpre 
          and k00_matric = (select matric 
                              from arrecad_parc_rec_perc 
                             where matric > 0
                             group by matric 
                             order by round(sum(percmatric),2) desc limit 1);
    end if;  

    nSomaPercInscr = 0;
    nTotArreInscr  = 0;

    select sum(percinscr)
      into nTotArreInscr
      from arrecad_parc_rec_perc;

    for rPercOrigem in select inscr,sum(percinscr) as k00_perc,tipo
                         from arrecad_parc_rec_perc
                        where inscr > 0
                        group by inscr,tipo
    loop

      if lRaise then
        raise notice '---------------------------------------------------------------';
              raise notice 'inscr: % - perc: % numpre : %', rPercOrigem.inscr, rPercOrigem.k00_perc, v_numpre ;
        raise notice '---------------------------------------------------------------';
            end if;
      -- tipo = 3 quer dizer que nao tem origem de matricula ou inscricao
      -- (o numpre origem esta somente na arrenumcgm ou seja nao precisa gravar percentual na arrematric ou arreinscr)
      if rPercOrigem.tipo <> 3 then
            insert into arreinscr (k00_inscr,k00_numpre,k00_perc)
                          values(rPercOrigem.inscr,v_numpre,round(rPercOrigem.k00_perc,2));
      end if;

      v_totalzao := (v_totalzao + rPercOrigem.k00_perc);
      nSomaPercInscr  := nSomaPercInscr + round(rPercOrigem.k00_perc, 2);

    end loop;

    if lRaise then
      raise notice 'v_totalzao (2): %', v_totalzao;
    end if;

    if (nTotArreInscr-nSomaPercInscr) <> 0 and (nTotArreInscr-nSomaPercInscr) < 0.05 then

       if lRaise then
         raise notice 'Encontrada Diferenca de Percentual. Total da ArreInscr: % SomaPerc: % Diferenca: %',nTotArreInscr, nSomaPercInscr, nTotArreInscr-nSomaPercInscr;
       end if;

       update arreinscr set k00_perc = round( k00_perc +  ( nTotArreInscr - nSomaPercInscr),2)
        where k00_numpre = v_numpre
          and k00_inscr = (select inscr
                              from arrecad_parc_rec_perc
                             where inscr > 0
                             group by inscr
                             order by round(sum(percinscr),2) desc limit 1);
    end if;

    if lRaise then
      raise notice 'v_totalzao (3): %', v_totalzao;
    end if;

    for rPercOrigem in select numpre, sum(perccgm) as k00_perc
                         from arrecad_parc_rec_perc
                        where tipo = 3
                        group by numpre 
    loop

      if lRaise then  
         raise notice '---------------------------------------------------------------';
         raise notice ' por cgm -- numpre -- % percentual -- %', rPercOrigem.k00_perc,rPercOrigem.numpre ;
         raise notice '---------------------------------------------------------------';
      end if;

      v_totalzao := (v_totalzao + rPercOrigem.k00_perc);

    end loop;

        
    
    -- Corrige arredondamentos
    nPercCalc = 100-round(v_totalzao,2); 
    if nPercCalc < 0.5 then 
       
       -- caso o percentual da inscrição for menor que o percentual da matricula jogamos a diferença no percentual da inscrição
       -- caso o percentual da inscrição for maior que o percentual da matricula jogamos a diferença no percentual da matricula
      if nSomaPercInscr < nSomaPercMatric then

         if lRaise then
            raise notice 'Jogando a diferença de arredondamento para a inscrição';
         end if;

          update arreinscr set k00_perc = k00_perc + nPercCalc
           where k00_numpre = v_numpre
             and k00_inscr = (select inscr
                              from arrecad_parc_rec_perc
                              where inscr > 0
                             group by inscr
                             order by round(sum(percinscr),2) asc limit 1);

      elseif nSomaPercInscr > nSomaPercMatric then

         if lRaise then
            raise notice 'Jogando a diferença de arredondamento para a matricula';
         end if;

          update arrematric set k00_perc = k00_perc + nPercCalc
           where k00_numpre = v_numpre
             and k00_matric = (select matric
                                 from arrecad_parc_rec_perc
                                where matric > 0 
                                group by matric
                                order by round(sum(percmatric),2) asc limit 1);

      end if;
       
       v_totalzao := v_totalzao+nPercCalc;
       if lRaise then
          raise notice 'v_totalzao (4): %',v_totalzao;
       end if;

    end if;
    -- soma os percentuais da arrematric e arreinscr... nao esquecendo de que pode nao ter registros em nenhuma das duas tabelas
    
    if lRaise is true then
      raise notice 'total utilizado na comparacao final: %',v_total;
      raise notice 'totalzao ..........................: %',v_totalzao;
    end if;
    
    if round(v_totalzao,2)::numeric <> 100::numeric and round(v_totalzao,2)::numeric <> 0::numeric then
      return '10 - Erro calculando percentual entre as origens devedoras';
    end if;

    if lRaise is true then
      raise notice '\n';
    end if;
    
        -- insere registros na arreparc
        -- agrupados por receita
    for v_record_receitas in
      select    receit,
      sum(vlrhis) as vlrhis,
      sum(vlrcor) as vlrcor,
      sum(vlrjur) as vlrjur,
      sum(vlrmul) as vlrmul,
      sum(vlrdes) as vlrdes,
      sum(valor)  as valor
      from arrecad_parc_rec
      group by receit 
    loop
      
      if lRaise is true then
        raise notice 'receita: % - valor: %', v_record_receitas.receit, v_record_receitas.valor;
      end if;   

      insert into arreparc values (v_numpre,v_record_receitas.receit,v_record_receitas.valor / v_total * 100);
            
      nVlrHis := nVlrHis + v_record_receitas.vlrhis;
      nVlrCor := nVlrCor + v_record_receitas.vlrcor;
      nVlrJur := nVlrJur + v_record_receitas.vlrjur;
      nVlrMul := nVlrMul + v_record_receitas.vlrmul;
      nVlrDes := nVlrDes + v_record_receitas.vlrdes;

    end loop;
    
    if lRaise is true then
      raise notice '\n';
    end if;

        -- insere na termo
    insert into termo (
      v07_parcel,
      v07_dtlanc,
      v07_valor,
      v07_numpre,
      v07_totpar,
      v07_vlrpar,
      v07_dtvenc,
      v07_vlrent,
      v07_datpri,
      v07_vlrmul,
      v07_vlrjur,
      v07_perjur,
      v07_permul,
      v07_login,
      v07_numcgm,
      v07_hist,
      v07_ultpar,
      v07_desconto,
      v07_desccor,
      v07_descjur,
      v07_descmul,
      v07_situacao,
      v07_instit,
      v07_vlrhis,
      v07_vlrcor,
      v07_vlrdes
    ) values (
      v_termo,
      dDataUsu,
      v_total,
      v_numpre,
      v_totalparcelas,
      v_valorparcelanew,
      v_segvenc,
      v_entrada,
      v_privenc,
      nVlrMul,
      nVlrJur,
      0,
      0,
      v_login,
      v_cgmresp,
      sObservacao,
      v_valultimaparcelanew,
      v_desconto,
      v_descontocor,
      v_descontojur,
      v_descontomul,
      1, -- Situacao Ativo
      iInstit,
      nVlrHis,
      nVlrCor,
      nVlrDes
    );

    -- se foi informado codigo do processo entao insere na termoprotprocesso 
    if iProcesso is not null and iProcesso != 0  then 
      if lRaise is true then
        raise notice ' Insere na protprocesso  Processo : %',iProcesso;
      end if;
      insert into termoprotprocesso (v27_sequencial,v27_termo,v27_protprocesso)
                             values (nextval('termoprotprocesso_v27_sequencial_seq'),v_termo,iProcesso);
    end if;

        -- se origem tiver parcelamento
        -- insere na termoreparc
    if lParcParc then
      if lRaise is true then
        raise notice 'v08_parcel: % - v08_parcelorigem: %', v_termo, v_termo_ori;
      end if;

      for v_record_origem in
                select  distinct v07_parcel from termo
                inner join numpres_parc on termo.v07_numpre = numpres_parc.k00_numpre
      loop
        if lRaise is true then
          raise notice 'into termoreparc...';
        end if;
        insert into termoreparc (v08_sequencial, v08_parcel, v08_parcelorigem)
                         values (nextval('termoreparc_v08_sequencial_seq'), v_termo, v_record_origem.v07_parcel);
                                                 
      end loop;
    end if;
    
--    raise notice 'v_tipo: %', v_tipo;

    if lRaise is true then
      raise notice 'v_totaldivida: %', v_totaldivida;
    end if;
    
        -- insere na termodiv (obs o select da arrecad_parc_rec da um inner join com a divida so para inserir na termodiv quando a origem for divida)
    insert into termodiv (parcel,coddiv,valor,vlrcor,juros,multa,desconto,total,vlrdesccor,vlrdescjur,vlrdescmul,numpreant,v77_perc)
    select x.*, x.valor / v_totaldivida * 100 
     from ( select v_termo,
                   v01_coddiv,
                   round(sum(vlrhis),2)::float8 as vlrhis,
                   round(sum(vlrcor),2)::float8 as vlrcor,
                   round(sum(vlrjur),2)::float8 as vlrjur,
                   round(sum(vlrmul),2)::float8 as vlrmul,
                   round(sum(vlrdes),2)::float8 as vlrdes,
                   round(sum(valor),2)::float8  as valor,
                   round(sum(vlrdesccor),2)::float8 as vlrdesccor,
                   round(sum(vlrdescjur),2)::float8 as vlrdescjur,
                   round(sum(vlrdescmul),2)::float8 as vlrdescmul,
                   divida.v01_numpre
              from arrecad_parc_rec
                   inner join divida on divida.v01_numpre = arrecad_parc_rec.numpre 
                                    and divida.v01_numpar = arrecad_parc_rec.numpar
             where tipo = 5
             group by v01_coddiv, v01_numpre ) as x;
    
        -- mostra os valores com origem de divida ativa
    if lRaise is true then
      for v_record_numpres in 
        select * from termodiv where parcel = v_termo 
            loop
              if lRaise then    
          raise notice 'coddiv: % - vlcor: % - total: % - juro: % - multa: %', v_record_numpres.coddiv, v_record_numpres.vlrcor, v_record_numpres.total, v_record_numpres.juros, v_record_numpres.multa;
                end if;
      end loop;
    end if;
    
        -- SE ORIGEM FOR DIVERSOS
    if lParcDiversos then
      if lRaise is true then
        raise notice 'inserindo em termodiver...';
      end if;
          -- insere na termodiver
      insert into termodiver (dv10_parcel,dv10_coddiver,dv10_valor,dv10_vlrcor,dv10_juros,dv10_multa,dv10_desconto,dv10_total,dv10_numpreant,dv10_vlrdescjur,dv10_vlrdescmul,dv10_perc)
            select x.
                   *,x.valor/v_total
          from ( select v_termo,
                      dv05_coddiver,
                      round(sum(vlrhis),2)::float8 as vlrhis,
                      round(sum(vlrcor),2)::float8 as vlrcor,
                      round(sum(vlrjur),2)::float8 as vlrjur,
                      round(sum(vlrmul),2)::float8 as vlrmul,
                      round(sum(vlrdes),2)::float8 as vlrdes,
                      round(sum(valor),2)::float8 as valor,
                      diversos.dv05_numpre,
                      round(sum(vlrdescjur),2)::float8 as vlrdescjur,
                      round(sum(vlrdescmul),2)::float8 as vlrdescmul
                 from arrecad_parc_rec
                      inner join diversos on diversos.dv05_numpre = arrecad_parc_rec.numpre
                group by dv05_coddiver, dv05_numpre) as x;
    end if;
        
        -- SE ORIGEM FOR CONTRIBUICAO DE MELHORIAS
    if lParcContrib then
      if lRaise is true then
        raise notice 'inserindo em termodiver...';
      end if;
          -- insere na termodiver
      insert into termocontrib (parcel,contricalc,valor,vlrcor,juros,multa,desconto,total,numpreant,vlrdescjur,vlrdescmul,perc)
            select x.
                   *,x.valor/v_total
          from ( select v_termo,
                      d09_sequencial,
                      round(sum(vlrhis),2)::float8 as vlrhis,
                      round(sum(vlrcor),2)::float8 as vlrcor,
                      round(sum(vlrjur),2)::float8 as vlrjur,
                      round(sum(vlrmul),2)::float8 as vlrmul,
                      round(sum(vlrdes),2)::float8 as vlrdes,
                      round(sum(valor),2)::float8 as valor,
                      contricalc.d09_numpre,
                      round(sum(vlrdescjur),2)::float8 as vlrdescjur,
                      round(sum(vlrdescmul),2)::float8 as vlrdescmul
                 from arrecad_parc_rec
                      inner join contricalc on contricalc.d09_numpre = arrecad_parc_rec.numpre
                group by d09_sequencial,d09_numpre 
                         ) as x;
    end if;
    
    if lRaise is true then
      raise notice 'v_parcinicial: %', v_parcinicial;
    end if;
    
        -- SE ORIGEM FOR INICIAL DO FORO
    if v_parcinicial is true then
      
            if lRaise is true then
        raise notice 'inserindo em termoini...';
      end if;
      
            -- insere na termoini
      insert into termoini(parcel,inicial,valor,vlrcor,juros,multa,desconto,total,vlrdesccor,vlrdescjur,vlrdescmul,v61_perc)
            select x.*,x.valor/v_total
              from ( select v_termo,
                      inicialnumpre.v59_inicial,
                      round(sum(vlrhis),2)::float8 as vlrhis,
                      round(sum(vlrcor),2)::float8 as vlrcor,
                      round(sum(vlrjur),2)::float8 as vlrjur,
                      round(sum(vlrmul),2)::float8 as vlrmul,
                      round(sum(vlrdes),2)::float8 as vlrdes,
                      round(sum(valor),2)::float8 as valor,
                      round(sum(vlrdesccor),2)::float8 as vlrdesccor,
                      round(sum(vlrdescjur),2)::float8 as vlrdescjur,
                      round(sum(vlrdescmul),2)::float8 as vlrdescmul
                 from arrecad_parc_rec
                      inner join inicialnumpre on inicialnumpre.v59_numpre = arrecad_parc_rec.numpre
                group by inicialnumpre.v59_inicial ) as x;
      
      for v_iniciais in select distinct v59_inicial 
                                  from arrecad_parc_rec
                               inner join inicialnumpre on inicialnumpre.v59_numpre = arrecad_parc_rec.numpre 
                               inner join inicial             on inicial.v50_inicial            = inicialnumpre.v59_inicial
                                                                                                             and inicial.v50_situacao         = 1
            loop
        
        select nextval('inicialmov_v56_codmov_seq') into v_inicialmov;
        
        insert into inicialmov values (v_inicialmov,v_iniciais.v59_inicial,4,'',dDataUsu,v_login);
        update inicial set v50_codmov = v_inicialmov where v50_inicial = v_iniciais.v59_inicial;
        
      end loop;
    end if;

   -- Deletando os registros do arreold que estao incorretamente devido a bug 
   -- da versao antiga da funcao fc_excluiparcelamento

    delete from arreold 
     using arrecad_parc_rec
     where arreold.k00_numpre = arrecad_parc_rec.numpre 
       and arreold.k00_numpar = arrecad_parc_rec.numpar 
       and arreold.k00_receit = arrecad_parc_rec.receit;

        -- insere no arreold
    
    insert into arreold(k00_numcgm,k00_dtoper,k00_receit,k00_hist,k00_valor,k00_dtvenc,k00_numpre,k00_numpar,k00_numtot,k00_numdig,k00_tipo,k00_tipojm)
        select arrecad.k00_numcgm,arrecad.k00_dtoper,arrecad.k00_receit,arrecad.k00_hist,arrecad.k00_valor,arrecad.k00_dtvenc,arrecad.k00_numpre,arrecad.k00_numpar,arrecad.k00_numtot,arrecad.k00_numdig,arrecad.k00_tipo,arrecad.k00_tipojm
      from arrecad
           inner join arrecad_parc_rec on arrecad.k00_numpre = arrecad_parc_rec.numpre 
                                                and arrecad.k00_numpar = arrecad_parc_rec.numpar 
                                                                            and arrecad.k00_receit = arrecad_parc_rec.receit
           left join arreold           on   arreold.k00_numpre = arrecad_parc_rec.numpre 
                                                  and arreold.k00_numpar = arrecad_parc_rec.numpar 
                                                                            and arreold.k00_receit = arrecad_parc_rec.receit
     where arreold.k00_numpre is null and arrecad.k00_valor > 0;
    
    delete from arrecad 
     using arrecad_parc_rec
     where arrecad.k00_numpre = arrecad_parc_rec.numpre 
       and arrecad.k00_numpar = arrecad_parc_rec.numpar 
         and arrecad.k00_receit = arrecad_parc_rec.receit;
    
        -- conta a quantidade de registros do arrecad
    select count(*) from arrecad into v_contador where k00_numpre = v_numpre;
    
    if lRaise is true then
      raise notice 'total final de registros no arrecad: %', v_contador;
    end if;
    
    if lSeparaJuroMulta = 2 then
      -- soma o valor gravado no arrecad
      select round(sum(k00_valor),2) 
        into v_resto 
        from arrecad 
       where k00_numpre = v_numpre;
    else
      select round(sum(arrecad.k00_valor)+coalesce(sum(arrecadcompos.k00_correcao),0) + coalesce(sum(arrecadcompos.k00_juros),0) + coalesce(sum(arrecadcompos.k00_multa),0) ,2) 
        into v_resto 
        from arrecad 
             left  join arreckey      on arreckey.k00_numpre = arrecad.k00_numpre
                                     and arreckey.k00_numpar = arrecad.k00_numpar
                                     and arreckey.k00_receit = arrecad.k00_receit
                                     and arreckey.k00_hist   = arrecad.k00_hist
             left  join arrecadcompos on arrecadcompos.k00_arreckey = arreckey.k00_sequencial
       where arrecad.k00_numpre = v_numpre;
    end if;

    if lRaise is true then
      raise notice 'Total do arrecad (v_resto): % - v_total: %', v_resto, v_total;
    end if;
    
        -- registra a diferenca do valor gravado no arrecad e do total do parcelamento calculado durante o processamento
    v_teste = round(v_total,2) - round(v_resto,2);
    
    if lRaise is true then
      raise notice 'v_teste: %', v_teste;
    
      raise notice ' ';
      raise notice ' ';
      raise notice ' ';
      raise notice 'ACERTAR DIFERENCA';
      raise notice ' ';
      raise notice ' ';
      raise notice ' ';

    end if;
    
    if abs(v_teste) between 0.01 and 2.50 then
      if lRaise is true then
        raise notice 'entrou no 0.01 - diferenca: %', v_teste;
      end if;

      select k00_receit
        into v_maxrec
        from arrecad 
      where  k00_numpre = v_numpre 
               and k00_numpar = v_totalparcelas
      order by k00_valor desc limit 1;
      
      update arrecad 
         set k00_valor  = k00_valor + v_teste
       where k00_numpre = v_numpre 
               and k00_numpar = v_totalparcelas 
                 and k00_receit = v_maxrec;
      
    end if;
    
        -- se juros na ultima
    if v_juronaultima is true then
      
      select k00_receit 
              into v_receita 
        from arrecad 
      where k00_numpre = v_numpre 
              and k00_numpar = v_totalparcelas - 1 limit 1;
      
      if round(v_total,2) <> round(v_resto,2) then
        
        if lRaise is true then
          raise notice 'update: %', round(v_total,2) - round(v_resto,2);
        end if;
        
                -- altera o valor da penultima parcela com a diferenca
        update arrecad set k00_valor = k00_valor + round(round(v_total,2) - round(v_resto,2),2)
        where k00_numpre = v_numpre 
                  and k00_numpar = v_totalparcelas - 1 
                    and k00_receit = v_receita;
        
      end if;
      
    end if;

-- funcao que corrige o arrecad no caso de encontrar registros duplicados(numpre,numpar,receit) 
--    perform fc_corrigeparcelamento();
 
    if lSeparaJuroMulta = 2 then
      select round(sum(k00_valor),2) 
        into v_resto 
        from arrecad 
       where k00_numpre = v_numpre;
    else
      select round(sum(arrecad.k00_valor)+coalesce(sum(arrecadcompos.k00_correcao),0) + coalesce(sum(arrecadcompos.k00_juros),0) + coalesce(sum(arrecadcompos.k00_multa),0) ,2) 
        into v_resto 
        from arrecad 
             left  join arreckey      on arreckey.k00_numpre = arrecad.k00_numpre
                                     and arreckey.k00_numpar = arrecad.k00_numpar
                                     and arreckey.k00_receit = arrecad.k00_receit
                                     and arreckey.k00_hist   = arrecad.k00_hist
             left  join arrecadcompos on arrecadcompos.k00_arreckey = arreckey.k00_sequencial
       where arrecad.k00_numpre = v_numpre;
    end if;
    
    if lRaise is true then
      raise notice 'total do arrecad (v_resto): % - v_total: % - totparc: %', v_resto, v_total, v_totparc;
    end if;
    
    for v_record_recpar in select k00_receit, sum(k00_valor) from arrecad where k00_numpre = v_numpre group by k00_receit loop
      if lRaise is true then
        raise notice 'receita: % - valor: %', v_record_recpar.k00_receit, v_record_recpar.sum;
      end if;
    end loop;
    
        -- se total do arrecad for diferenca do total calculado durante o processamento
        -- mostra mensagem de erro

    if lRaise or 1=1 then
        raise notice 'Parcelamento : % Numpre : % Total: % - Resto: % Diferenca: %', v_termo, v_numpre, v_total, v_resto, (round(v_total,2) - round(v_resto,2));    
    end if;

    if round(v_total,2) <> round(v_resto,2) then
      return '9 - total gerado da soma das parcelas inconsistente!';
    end if;
    
    return '1 - parcelamento efetuado com sucesso - termo gerado: '|| v_termo;
    
  end;

$$ language 'plpgsql';
