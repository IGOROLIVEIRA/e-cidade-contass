-- FUNCTION: public.fc_iptu_demonstrativo(integer, integer, integer, boolean)

-- DROP FUNCTION IF EXISTS public.fc_iptu_demonstrativo(integer, integer, integer, boolean);

CREATE OR REPLACE FUNCTION public.fc_iptu_demonstrativo(
  integer,
  integer,
  integer,
  boolean)
    RETURNS text
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
declare

iMatricula      alias for $1;
   iAnousu         alias for $2;
   iIdql           alias for $3;
   lRaise          alias for $4;

   tDemonstrativo  text          default '\n';
   tSqlConstr      text          default '';
   nTotal          numeric(15,2) default 0;

   iTotalPontos    integer       default 0;
   iNumpreVerifica integer       default 0;

   rValores        record;
   rDadosIptu      record;
   rProprietario   record;
   rEndereco       record;
   rConstr         record;
   rCaract         record;
   rLoteCaract     record;

   lAbatimento     boolean default false;

begin

   lRaise  := (case when fc_getsession('DB_debugon') is null then false else true end);

   perform fc_debug(' <iptu_demonstrativo> Gerando Desmontrativo de Calculo', lRaise);

   /**
    * Verifica se existe Pagamento Parcial para o débito informado
    */
select j20_numpre
into iNumpreVerifica
from iptunump
where j20_matric = iMatricula
  and j20_anousu = iAnousu
    limit 1;

if found then

select fc_verifica_abatimento( 1, ( select j20_numpre
                                    from iptunump
                                    where j20_matric = iMatricula
                                      and j20_anousu = iAnousu
    limit 1 ))::boolean into lAbatimento;

if lAbatimento then
        raise exception '<erro>Operação Cancelada, Débito com Pagamento Parcial!</erro>';
end if;

end if;

    /**
     * Dados do Proprietario
     */
select cgm.z01_cgccpf,
       cgm.z01_ident,
       cgm.z01_ender,
       cgm.z01_numero,
       cgm.z01_bairro,
       cgm.z01_cep,
       cgm.z01_munic,
       cgm.z01_uf,
       cgm.z01_telef,
       cgm.z01_cadast
into rProprietario
from cgm
         inner join iptubase on iptubase.j01_numcgm = cgm.z01_numcgm
where j01_matric = iMatricula;

tDemonstrativo := tDemonstrativo || LPAD('[ PROPRIETÁRIO ]--',90,'-') || '\n';
   tDemonstrativo := tDemonstrativo || '\n';
   tDemonstrativo := tDemonstrativo || RPAD(' CGC/CPF '             ,55,'.') || ': ' || trim(coalesce(rProprietario.z01_cgccpf,''))               ||' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' IDENTIDADE/INSC.EST ' ,55,'.') || ': ' || trim(coalesce(rProprietario.z01_ident,''))                ||' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' ENDERECO '            ,55,'.') || ': ' || trim(coalesce(rProprietario.z01_ender,''))                ||' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' NUMERO '              ,55,'.') || ': ' || trim(coalesce(rProprietario.z01_numero,0)::varchar)       ||' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' BAIRRO '              ,55,'.') || ': ' || trim(coalesce(rProprietario.z01_bairro,''))               ||' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' CEP '                 ,55,'.') || ': ' || trim(coalesce(rProprietario.z01_cep,''))                  ||' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' MUNICIPIO '           ,55,'.') || ': ' || trim(coalesce(rProprietario.z01_munic,''))                ||' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' UF '                  ,55,'.') || ': ' || trim(coalesce(rProprietario.z01_uf,''))                   ||' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' TELEFONE '            ,55,'.') || ': ' || trim(coalesce(rProprietario.z01_telef,''))                ||' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' DATA DO CADASTRO '    ,55,'.') || ': ' || trim(coalesce(cast(rProprietario.z01_cadast as text),'')) ||' \n';
   tDemonstrativo := tDemonstrativo || '\n';

   /**
    * Endereco do imovel
    */
select distinct
    iptuconstr.j39_numero,
    iptuconstr.j39_compl,
    ruas.j14_nome,
    bairro.j13_descr,
    lote.j34_setor,
    lote.j34_quadra,
    lote.j34_lote,
    lote.j34_area
into rEndereco
from iptubase
         left  join iptuconstr on j01_matric = j39_matric
         inner join lote       on j34_idbql  = j01_idbql
         inner join bairro     on j34_bairro = j13_codi
         inner join testpri    on j01_idbql  = j49_idbql
         inner join ruas       on j49_codigo = j14_codigo
where iptuconstr.j39_dtdemo is null
  and j01_matric = iMatricula;

tDemonstrativo := tDemonstrativo || LPAD('[ ENDERECO DO IMÓVEL ]--',90,'-') || '\n';
   tDemonstrativo := tDemonstrativo || '\n';
   tDemonstrativo := tDemonstrativo || RPAD(' LOGRADOURO '            ,55,'.') || ': ' || trim(coalesce(rEndereco.j14_nome,''))            ||' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' NUMERO '                ,55,'.') || ': ' || trim(coalesce(rEndereco.j39_numero::varchar,'')) ||' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' COMPLEMENTO '           ,55,'.') || ': ' || trim(coalesce(rEndereco.j39_compl,''))           ||' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' BAIRRO '                ,55,'.') || ': ' || trim(coalesce(rEndereco.j13_descr,''))           ||' \n';
   tDemonstrativo := tDemonstrativo || '\n';

   /**
    * Dados do lote
    */
   tDemonstrativo := tDemonstrativo || LPAD('[ DADOS DO LOTE ]--' ,90,'-') || '\n';
   tDemonstrativo := tDemonstrativo || '\n';
   tDemonstrativo := tDemonstrativo || RPAD(' SETOR/QUADRA/LOTE ' ,55,'.') || ': ' || trim(coalesce(rEndereco.j34_setor,'') || '/' || coalesce(rEndereco.j34_quadra,'') || '/' || coalesce(rEndereco.j34_lote,'')) || ' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' AREA '              ,55,'.') || ': ' || trim(coalesce(rEndereco.j34_area::varchar,'')) || ' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' TESTADA PRINCIPAL ' ,55,'.') || ': ' || trim(coalesce(rEndereco.j14_nome,''))          || ' \n';
   tDemonstrativo := tDemonstrativo || ' CARACTERISTICAS DO LOTE : \n';

for rLoteCaract in select j31_codigo, j31_descr, j31_grupo
                   from carlote
                            inner join caracter on j35_caract = j31_codigo
                   where j35_idbql = iIdql
                       loop
     tDemonstrativo := tDemonstrativo || LPAD( ' ' || coalesce(rLoteCaract.j31_codigo::varchar, ''), 40, '.') || ' - ' || coalesce(rLoteCaract.j31_descr, '') || ' - GRUPO : ' || rLoteCaract.j31_grupo || '\n';
end loop;

   tDemonstrativo := tDemonstrativo||'\n';

   /**
    * Dados das construcoes
    */
   tDemonstrativo := tDemonstrativo||LPAD('[ DADOS DAS CONSTRUÇÕES ]--' ,90,'-')||'\n';
   tDemonstrativo := tDemonstrativo||'\n';

   tSqlConstr     :=               'select distinct j39_idcons, j39_area, j39_ano, valor,   ';
   tSqlConstr     := tSqlConstr || '                j39_matric, coalesce(pontos,0) as pontos';
   tSqlConstr     := tSqlConstr || '  from iptuconstr                                       ';
   tSqlConstr     := tSqlConstr || '       inner join tmpiptucale on matric = j39_matric    ';
   tSqlConstr     := tSqlConstr || '                             and idcons = j39_idcons    ';
   tSqlConstr     := tSqlConstr || ' where j39_matric = ' || iMatricula;

for rConstr in execute tSqlConstr
   loop
      tDemonstrativo := tDemonstrativo || '\n';
      tDemonstrativo := tDemonstrativo || RPAD(' CONSTRUÇÃO '           , 55, '.') || ': ' || coalesce(rConstr.j39_idcons::varchar,'')          || ' \n';
      tDemonstrativo := tDemonstrativo || RPAD(' PONTUAÇÃO '            , 55, '.') || ': ' || coalesce(rConstr.pontos::varchar,'')              || ' \n';
      tDemonstrativo := tDemonstrativo || RPAD(' AREA '                 , 55, '.') || ': ' || coalesce(round(rConstr.j39_area,2)::varchar,'')   || ' \n';
      tDemonstrativo := tDemonstrativo || RPAD(' ANO DA CONSTRUÇÃO '    , 55, '.') || ': ' || coalesce(rConstr.j39_ano::varchar,'')             || ' \n';
      tDemonstrativo := tDemonstrativo || RPAD(' VLR VENAL CONSTRUÇÃO ' , 55, '.') || ': ' || coalesce(round(rConstr.valor,2)::varchar,'')      || ' \n';

      tDemonstrativo := tDemonstrativo||' CARACTERISTICAS DA CONSTRUÇÃO : \n';
for rCaract in select *
               from carconstr
                        inner join caracter on j48_caract = j31_codigo
               where j48_matric = rConstr.j39_matric
                 and j48_idcons = rConstr.j39_idcons
                   loop
        tDemonstrativo := tDemonstrativo || LPAD(' ' || rCaract.j31_codigo, 40, '.') || ' - ' || coalesce(rCaract.j31_descr, '') || ' - GRUPO : ' || rCaract.j31_grupo || '\n';
end loop;

end loop;

   tDemonstrativo := tDemonstrativo||'\n';

   /**
    * Dados do financeiro
    */
select * from tmpdadosiptu into rDadosIptu;

select sum(coalesce(pontos,0))
into iTotalPontos
from tmpiptucale;

tDemonstrativo := tDemonstrativo || LPAD('[ CALCULO ' || coalesce(IAnousu::varchar, '') || ' ]--', 90, '-') || '\n';
   tDemonstrativo := tDemonstrativo || '\n';
   tDemonstrativo := tDemonstrativo || RPAD(' PONTUAÇÃO '            , 55, '.') || ': ' || coalesce(iTotalPontos::varchar, '') ||'  \n';
   tDemonstrativo := tDemonstrativo || RPAD(' AREA P/ CALCULO '      , 55, '.') || ': ' || coalesce(round( (rDadosIptu.areat*rDadosIptu.fracao)/100 ,2)::varchar,'') || ' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' FRACAO '               , 55, '.') || ': ' || coalesce(round( rDadosIptu.fracao, 2)::varchar, '') || '% \n';
   tDemonstrativo := tDemonstrativo || RPAD(' ALIQUOTA '             , 55, '.') || ': ' || coalesce(round( rDadosIptu.aliq, 2)::varchar, '')   || '% \n';
   tDemonstrativo := tDemonstrativo || RPAD(' VALOR VENAL TERRENO '  , 55, '.') || ': ' || coalesce(round( rDadosIptu.vvt, 2)::varchar, '')    || ' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' VALOR VENAL EDIFIC '   , 55, '.') || ': ' || coalesce(round( rDadosIptu.vvc, 2)::varchar, '')    || ' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' AREA EDIFICADA '       , 55, '.') || ': ' || coalesce(round( rDadosIptu.areat, 2)::varchar,'')   || ' \n';
   tDemonstrativo := tDemonstrativo || RPAD(' VALOR M2 DO TERRENO '  , 55, '.') || ': ' || coalesce(round( rDadosIptu.vm2t, 2)::varchar, '')   || ' \n';

for rValores in select *
                from tmprecval
                         inner join tabrec on receita = k02_codigo
                    loop
   tDemonstrativo := tDemonstrativo || RPAD(' VALOR ' || coalesce(rValores.k02_descr::varchar, ''), 55, '.') || ': ' || coalesce( round(rValores.valor, 2)::varchar, '') || '\n';
nTotal         := nTotal + rValores.valor;
end loop;

 tDemonstrativo := tDemonstrativo || RPAD(' TOTAL A PAGAR ', 55, '.') || ': ' || coalesce(nTotal, 0) || '  \n';

return tDemonstrativo;

end;
$BODY$;

ALTER FUNCTION public.fc_iptu_demonstrativo(integer, integer, integer, boolean)
    OWNER TO dbportal;
