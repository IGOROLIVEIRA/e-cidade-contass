-- Function: fc_numerocertidao(integer, integer, character, boolean)

-- DROP FUNCTION fc_numerocertidao(integer, integer, character, boolean);

CREATE OR REPLACE FUNCTION fc_numerocertidao(iinstit integer, itipocodigo integer, stipocertidao character, lcertidaoweb boolean)
  RETURNS integer AS
$BODY$
declare

  lEmissaoWeb             boolean default false;
  iNumero                 integer default 0;
  iTipoCertidaoECidade    integer default 0;
  iTipoCertidaoWeb        integer default 0;
  sNomeSequence           text    default null;
begin

  lEmissaoWeb := lCertidaoWeb;

  IF lCertidaoWeb is NULL then
   lEmissaoWeb := false;
  end if;

  iTipoCertidaoECidade := iTipoCodigo;

  if lEmissaoWeb is true then

    select w13_tipocodigocertidao
      into iTipoCertidaoWeb
      from configdbpref
     where w13_instit = fc_getsession('DB_instit')::int;


    if not found then
      raise exception 'Erro ao Buscar Configuracoes.';
    end if;

    if    iTipoCertidaoWeb = 0 then
      return iNumero;
    elsif iTipoCertidaoWeb = 1 then
      sNomeSequence := 'certidao_web_geral_seq';
    elsif iTipoCertidaoWeb = 2 then
      sNomeSequence := 'certidao_web_tipo_' || sTipoCertidao || '_seq';
    elsif iTipoCertidaoWeb = 3 then
      lEmissaoWeb :=false;
    end if;

    select k03_tipocodcert
      into iTipoCertidaoECidade
      from numpref
     where k03_anousu = fc_getsession('DB_anousu')::int
       and k03_instit = fc_getsession('DB_instit')::int;

  end if;


  if lEmissaoWeb is false then

    if iTipoCertidaoECidade    = 1 then
      sNomeSequence := 'certidao_geral_seq';
    elsif iTipoCertidaoECidade = 2 then
      sNomeSequence := 'certidao_instit_' || cast(iInstit as text) || '_seq';
    elsif iTipoCertidaoECidade = 3 then
      sNomeSequence := 'certidao_tipo_'   || sTipoCertidao || '_seq';
    elsif iTipoCertidaoECidade = 4 then
      sNomeSequence := 'certidao_tipo_'   || sTipoCertidao || '_instit_'||cast(iInstit as text) || '_seq';
    else
      return iNumero;
    end if;

  end if;

  if not exists(select 1 from information_schema.sequences where sequence_name = sNomeSequence) then
    execute 'CREATE SEQUENCE '||sNomeSequence;
  end if;
  iNumero := nextval(sNomeSequence);

  return iNumero;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION fc_numerocertidao(integer, integer, character, boolean)
  OWNER TO ecidade;
