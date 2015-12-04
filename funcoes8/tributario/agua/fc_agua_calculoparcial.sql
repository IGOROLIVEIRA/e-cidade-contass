--
-- Funcao que efetua calculo/re-calculo de uma matricula especifica
--
-- Parametros: 1 - Ano de Referencia
--             2 - Mes de Referencia
--             3 - Matricula
--             4 - Troca Numpre? (Qdo houver recalculo)
--             5 - Gera Financeiro? (arrecad, arrematric, arrenumcgm, arreold)
--
SET check_function_bodies TO off;
drop function if exists fc_agua_calculoparcial(integer, integer, integer, bool, bool);
create or replace function fc_agua_calculoparcial(integer, integer, integer, bool, bool) returns bool as 
$$
declare
  ---------------------- Parametros
  iAno             alias for $1;
  iMes             alias for $2;
  iMatric          alias for $3;
  lTrocaNumpre     alias for $4;
  lGeraFinanceiro  alias for $5;
  ----------------------- Variaveis
  txtMemoria       text   := ''; -- Campo que contera a memoria de Calculo da Matricula
  nConsumo         float8 := 0;
  nExcesso         float8 := 0;
  lTaxaBasica      bool   := false;
  rCalculo         record;  
  rAguaBase        record;
  rCondominio      record;
  iEconomias       integer;
  iConsumo         integer;
  iNumpre          integer;
  iNumpreOld       integer;
  iCodCalc         integer;
  iCondominio      integer;
  iApto            integer;
  iTipoImovel      integer;
  nValorTemp       float8 := 0;
  nPercentualIsencao   float4 := 0;
  lAguaLigada      bool := false;
  lSemAgua         bool := false;
  lEsgotoLigado    bool := false;
  lSemEsgoto       bool := false;
  lRecalculo       bool := false;
  lGeraArrecad     bool := true;
  lRaise           bool := false;
  nAreaConstr      float4 := 0;
begin
  -- 1) Verifica se Existe Hidrometro Instalado
  if fc_agua_hidrometroinstalado(iMatric) = false then
    lTaxaBasica := true;
  else
    -- 1.1) Verifica Consumo e Excesso
    nConsumo := fc_agua_consumo(iAno, iMes, iMatric);
    nExcesso := fc_agua_excesso(iAno, iMes, iMatric);

    if (nConsumo + nExcesso) = 0 then 
      -- E R R O !!!!
      lTaxaBasica := true;
    end if;
    
  end if;
  
  -- Busca dados da Matricula
  select * 
    into rAguaBase
    from aguabase
   where x01_matric = iMatric;

  -- 2) Verifica dados para Calculo
  lGeraArrecad  := lGeraFinanceiro;
  iEconomias    := rAguaBase.x01_qtdeconomia;
  iConsumo      := fc_agua_consumocodigo(iAno, iMatric, rAguaBase.x01_zona);
  lAguaLigada   := fc_agua_agualigada(iAno, iMatric);
  lEsgotoLigado := fc_agua_esgotoligado(iAno, iMatric);
  lSemAgua      := fc_agua_semagua(iAno, iMatric);
  lSemEsgoto    := fc_agua_semesgoto(iAno, iMatric);
  nAreaConstr   := fc_agua_areaconstr(iMatric);  
  --iNumpre       := fc_agua_numpre();
  iCodCalc      := fc_agua_calculocodigo(iAno, iMes, iMatric);

  if iCodCalc is not null then
    lRecalculo := true;
  end if;
  
  -- 3) Verifica se eh matricula de condominio e apto
  iCondominio := fc_agua_condominiocodigo(iMatric);
  iApto       := fc_agua_condominioapto(iMatric);
  
 if lRaise = true then
    raise notice 'lGeraArrecad (%) lAguaLigada (%) iApto (%) nConsumo (%) nExcesso (%)', lGeraArrecad, lAguaLigada, iApto, nConsumo, nExcesso;
  end if;

  -- 4) Gera AguaCalc
  --    . Verifica se eh um Novo Calculo 
  if lRecalculo = false then
    iNumpre    := fc_agua_numpre();
    iNumpreOld := iNumpre;
    iCodCalc   := nextval('aguacalc_x22_codcalc_seq');
  
    insert into aguacalc(
      x22_codcalc,
      x22_codconsumo,
      x22_exerc,
      x22_mes,
      x22_matric,
      x22_area,
      x22_numpre
    ) values (
      iCodCalc,
      iConsumo,
      iAno,
      iMes,
      iMatric,
      nAreaConstr,
      iNumpre
    );
  else
    --if lTrocaNumpre = false then
      iNumpreOld := fc_agua_calculonumpre(iAno, iMes, iMatric);
      iNumpre    := iNumpreOld;
    --end if;
    
    update aguacalc 
       set x22_codconsumo = iConsumo,
           x22_area       = nAreaConstr,
           x22_numpre     = iNumpre
     where x22_codcalc    = iCodCalc;

    delete 
      from aguacalcval 
     where x23_codcalc = iCodCalc;

  end if;

  -- Se for um Apto de um Condominio e tiver agua desligada,
  -- força nao gerar financeiro
  if (lAguaLigada = false) and (iApto is not null) then
    lGeraArrecad := false;

    perform fc_agua_calculogeraarreold(
      iAno,
      iMes,
      iNumpreOld);
  end if;

  -- Elimina Registros do Arrecad
  if lGeraArrecad = true then
    perform fc_agua_calculogeraarreold(
      iAno,
      iMes,
      iNumpreOld);
  end if;

  -- Busca Registros para Cálculo
  for rCalculo in 
    select aguaconsumo.*,
           aguaconsumorec.*,
           aguaconsumotipo.*,
           0::float8 as x99_valor
      from aguaconsumo
           inner join aguaconsumorec  on x19_codconsumo = x20_codconsumo
           inner join aguaconsumotipo on x20_codconsumotipo = x25_codconsumotipo
     where x19_codconsumo = iConsumo
  loop
    --
    -- Verifica se Esta Calculando Consumo de Agua
    --
    if  (rCalculo.x25_codconsumotipo = fc_agua_confconsumoagua()) and
      (lSemAgua = false) then
      --
      -- ATENCAO!! Multiplica pelo retorno da funcao que verifica
      --           a qtd de economias levando em conta o multiplicador
      --
      nValorTemp := rCalculo.x20_valor * fc_agua_qtdeconomias(iMatric);
    --
    -- .. ou Esgoto
    --
    elsif (rCalculo.x25_codconsumotipo = fc_agua_confconsumoesgoto()) and
          (lSemEsgoto = false) then
      nValorTemp := rCalculo.x20_valor * fc_agua_qtdeconomias(iMatric);
    --
    -- .. ou Excesso
    --
    elsif (rCalculo.x25_codconsumotipo = fc_agua_confconsumoexcesso()) then
      if   ((iCondominio is not null) and (lAguaLigada = false)) or
        (lSemAgua = false) then
        nValorTemp := rCalculo.x20_valor * nExcesso;
      else
        nValorTemp := 0;
      end if;
    else
      nValorTemp := 0;
    end if;
    
    -- Verifica Isencao
    nPercentualIsencao := fc_agua_percentualisencao(iAno, iMes, iMatric, rCalculo.x25_codconsumotipo);
    
    if nPercentualIsencao = 0 then
      rCalculo.x99_valor := nValorTemp;
    else
      rCalculo.x99_valor := round(nValorTemp - (nValorTemp * (nPercentualIsencao / 100)), 2);
    end if;

    if lRaise = true then
      raise notice 'Matricula=(%) Isencao=(%) Padrao=(%) Taxa=(%) Valor Calculado=(%) Tipo Consumo=(%)', 
        iMatric,
        nPercentualIsencao,
        rCalculo.x20_valor,
        rCalculo.x25_descr,
        rCalculo.x99_valor,
        rCalculo.x25_codconsumotipo;
    end if;

    if rCalculo.x99_valor > 0 then
      insert into aguacalcval (
        x23_codcalc,
        x23_codconsumotipo,
        x23_valor
      ) values (
        iCodCalc,
        rCalculo.x25_codconsumotipo,
        rCalculo.x99_valor
      );
    end if;

    if lGeraArrecad = true then
      perform fc_agua_calculogerafinanceiro(
        iAno,
        iMes,
        iMatric,
        iNumpreOld,
        iNumpre,
        coalesce(rAguaBase.x01_numcgm, 0),
        rCalculo.x25_receit,
        rCalculo.x25_codhist,
        rCalculo.x99_valor);
    end if;
  end loop;

  if lRaise = true then
    raise notice 'Economias=(%) Agua Ligada=(%) Esgoto Ligado (%) Recalculo=(%) CodCalc=(%) Numpre=(%)',
      iEconomias,
      lAguaLigada,
      lEsgotoLigado,
      lRecalculo,
      iCodCalc,
      iNumpre;
  end if;

  return true;
end;
$$ language 'plpgsql';
