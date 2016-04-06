    CREATE OR REPLACE FUNCTION fc_iptu_calculavvt_ibiracatu_2012(IN integer, IN integer, IN integer, IN numeric, IN numeric, IN boolean, IN boolean, OUT rnvvt numeric, OUT rnareatotalc numeric, OUT rnarea numeric, OUT rntestada numeric, OUT rtdemo text, OUT rtmsgerro text, OUT rberro boolean, OUT ricoderro integer, OUT rterro text)
      RETURNS record AS
    $BODY$
    declare

        iIdbql                 alias for $1;
        iMatricula             alias for $2;
        iAnousu                alias for $3;
        nFracao                alias for $4;
        nArea                  alias for $5;
        bMostrademo            alias for $6;
        bRaise                 alias for $7;

        rnAreaTotLote          numeric;
        rnArealote             numeric;
        iZonaFiscal            integer;

        nFatorSituacaoImovel   numeric default 0;
        nFatorTopografia       numeric default 0;
        nFatorZonaFiscal       numeric default 0;
        nFatorImovelTopografia numeric default 0;
        nValor                 numeric default 0;
        nVlrInflator           numeric default 0;
        nVlrM2Terreno          numeric default 0;
        bPredial               boolean;

    begin

      rnVvt        := 0;
      rnAreaTotalC := 0;
      rnArea       := 0;
      rnTestada    := 0;
      rtDemo       := '';
      rtMsgerro    := '';
      rbErro       := 'f';
      riCoderro    := 0;
      rtErro       := '';

      if bRaise then

        raise notice 'INICIANDO CALCULO DO VALOR VENAL TERRITORIAL...';
      end if;

      select predial
        into bPredial
        from tmpdadosiptu;

      if bRaise then

        raise notice 'Tipo (Predial/Territorial).: %', bPredial;
      end if;


      -- pegamos o valor do inflator para descobrir o valor do terreno
      select i02_valor
        into nVlrInflator
        from infla
       where i02_codigo = 'UFEMG'
         and extract(year from i02_data) = iAnousu
       order by i02_data desc limit 1;

      --
      -- Verificamos as caracteristicas corretivas do terreno por cargrup e Caracteristica
      --
      -- Grupo de Caracteristica: 56 - Situação (fs)
      --
      select carfator.j74_fator
        into nFatorSituacaoImovel
        from carlote
             inner join caracter on j31_codigo          = j35_caract
             inner join cargrup  on j31_grupo           = j32_grupo
             inner join carfator on carfator.j74_caract = caracter.j31_codigo
       where j35_idbql = iIdbql
         and j32_grupo = 56;

      if not found then

        nFatorSituacaoImovel := 0;
      end if;

      --
      -- Grupo de Caracteristica: 57 - Topografia (ft)
      --
      select carfator.j74_fator
        into nFatorTopografia
        from carlote
             inner join caracter on j31_codigo          = j35_caract
             inner join cargrup  on j31_grupo           = j32_grupo
             inner join carfator on carfator.j74_caract = caracter.j31_codigo
       where j35_idbql = iIdbql
         and j32_grupo = 57;

      if not found then

        nFatorTopografia := 0;
      end if;

      --
      -- Aliquota da Zona Fiscal (ZF)
      --

      select case when bPredial is true
               THEN j51_valorm2c
               ELSE j51_valorm2t
             end
        into nFatorZonaFiscal
        from lote
             inner join zonasvalor on zonasvalor.j51_zona = lote.j34_zona
       where j34_idbql = iIdbql
       and j51_anousu = iAnousu;

      if not found then

        nFatorZonaFiscal := 0;
      end if;

      if bRaise then

        raise notice '   ';
        raise notice '   Area do terreno: %', nArea;
        raise notice '   Valor do Inflator: %', nVlrInflator;
        raise notice '   ';
        raise notice '   Fator de Situação do Imóvel(fs): %', nFatorSituacaoImovel;
        raise notice '   Fator de topografia(ft): %'        , nFatorTopografia;
        raise notice '   Aliquota da Zona Fiscal(ZF): %'    , nFatorZonaFiscal;
        raise notice '   ';

      end if;

      -- C = fs x ft (C = Caract. Situação * Caract. Topografia)
      nFatorImovelTopografia  := nFatorSituacaoImovel * nFatorTopografia;

      if bRaise then

        raise notice '';
        raise notice ' nFatorImovelTopografia: %', nFatorImovelTopografia;
        raise notice '';
      end if;

      nVlrM2Terreno := nArea * nVlrInflator;

      if bRaise then

        raise notice '';
        raise notice ' nVlrM2Terreno: %', nVlrM2Terreno;
        raise notice '';
      end if;

      -- Vvt = C x S x ZF (Vvt = C * Área do terreno * Aliquota da Zona Fiscal)
      nValor := nFatorImovelTopografia * nArea * nFatorZonaFiscal;

      if bRaise then

        raise notice '';
        raise notice ' nValor: %', nValor;
        raise notice '';
      end if;

      rnArea    := nArea;
      rnVvt     := nValor;
      rtDemo    := '';
      rtMsgerro := '';
      rbErro    := 'f';

      update tmpdadosiptu set vvt = nValor, vm2t=nVlrM2Terreno, areat=nArea;

      return;

    end;
    $BODY$
      LANGUAGE plpgsql VOLATILE
      COST 100;
    ALTER FUNCTION fc_iptu_calculavvt_ibiracatu_2012(integer, integer, integer, numeric, numeric, boolean, boolean)
      OWNER TO dbportal;