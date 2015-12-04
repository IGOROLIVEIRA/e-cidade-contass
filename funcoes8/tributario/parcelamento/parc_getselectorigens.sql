create or replace function fc_parc_getselectorigens(integer,integer) returns varchar as
$$
declare
  
  iParcelamento   alias   for $1;
  iTipo           alias   for $2;
 
  iAnoUsu         integer default 0;
  iInstit         integer default 0;
  iValorAnulacao  integer default 0;

  sSqlRetorno     varchar default '';

begin
  
  iAnoUsu := cast( (select fc_getsession('DB_anousu')) as integer);
  if iAnoUsu is null then
    raise exception 'ERRO : Variavel de sessao [DB_anousu] nao encontrada.';
  end if;

  iInstit   := cast( (select fc_getsession('DB_instit')) as integer);
  if iInstit is null or iInstit = 0 then
    raise exception 'ERRO : Variavel de sessao [DB_instit] nao encontrada.';
  end if;

  select k03_tipoanuparc
    into iValorAnulacao
    from numpref
   where k03_anousu = iAnoUsu
     and k03_instit = iInstit;

  if iValorAnulacao in (1,2) then
    sSqlRetorno := fc_parc_getselectorigens_atjuros(iParcelamento,iTipo,iValorAnulacao);
  elsif iValorAnulacao = 3 then
    sSqlRetorno := fc_parc_getselectorigens_jurori(iParcelamento,iTipo,iValorAnulacao);
  else
    raise exception 'Verifique a configuracao dos parametros do modulo arrecadacao para o exercicio atual';
  end if;

  
  return sSqlRetorno;
  
end;
$$  language 'plpgsql';
