/**
 * Funcao que gera um nome temporario para a sessao do dbportal no banco de dados
 * 
 *
 * @author Fabrizio Mello
 * @since  13/05/2008
 *
 * $Id: session.sql,v 1.5 2008/05/14 14:13:55 dbfabrizio Exp $
 */
create or replace function fc_sessionname() returns text as
$$
declare
  sNomeSessao text;
begin

  sNomeSessao := 'db_session_'||cast(pg_backend_pid() as text);

  return sNomeSessao;
end;
$$
language 'plpgsql';


/**
 * Funcao que inicializa a sessao do dbportal no banco de dados
 * 
 *
 * @author Fabrizio Mello
 * @since  24/09/2007
 *
 * $Id: session.sql,v 1.5 2008/05/14 14:13:55 dbfabrizio Exp $
 */
create or replace function fc_startsession() returns boolean as
$$
declare
  lRetorno     boolean default true;

  sSql         text;
  sSchemasPath text;
begin

  begin

    sSql := '
      create temporary table 
        '||fc_sessionname()||' (variavel text, conteudo text);';
    execute sSql;

    sSql := 'create index '||fc_sessionname()||'_variavel_in on '||fc_sessionname()||'(variavel);';
    execute sSql;

    set DateStyle to ISO, DMY;

    perform fc_set_pg_search_path();

  exception
    when undefined_table or duplicate_table then
      lRetorno := false;
    when others then
      lRetorno := false;
  end;

  return lRetorno;
end;
$$
language 'plpgsql';




/**
 * Funcao que retorna uma variavel de sessao do sistema
 * 
 * @param sVariavel     text    Nome da Variavel para buscar o valor
 *
 * @author Fabrizio Mello
 * @since  24/09/2007
 *
 * $Id: session.sql,v 1.5 2008/05/14 14:13:55 dbfabrizio Exp $
 */
create or replace function fc_getsession(text) returns text as
$$
declare
  sVariavel  alias for $1;

  sConteudo  text;
  sSql       text;
begin

  begin
    sSql := '
      select conteudo
        from '||fc_sessionname()||'
       where variavel = upper('||quote_literal(sVariavel)||');';

    execute sSql into sConteudo;

  exception
    when undefined_table then
      sConteudo := null;
    when others then
      sConteudo := null;
  end;

  return sConteudo;
end;
$$
language 'plpgsql';


/**
 * Funcao que seta uma variavel de sessao do sistema
 * 
 * @param sVariavel     text    Nome da Variavel para setar o valor
 * @param sConteudo     text    Conteudo da variavel
 *
 * @author Fabrizio Mello
 * @since  24/09/2007
 *
 * $Id: session.sql,v 1.5 2008/05/14 14:13:55 dbfabrizio Exp $
 */
create or replace function fc_putsession(text, text) returns boolean as
$$
declare
  sVariavel  alias for $1;
  sConteudo  alias for $2;

  lRetorno   boolean default true;
  sSql       text; 
  lExiste    boolean;
begin

  begin

    sSql := ' select exists(
      select 1
         from '||fc_sessionname()||'
        where variavel = upper('||quote_literal(sVariavel)||') );';
    execute sSql into lExiste;

    if lExiste is true then
      sSql := '
        update '||fc_sessionname()||'
           set conteudo = '||quote_literal(sConteudo)||'
         where variavel = upper('||quote_literal(sVariavel)||');';
      execute sSql;
    else
      sSql := '
        insert
          into '||fc_sessionname()||' (variavel, conteudo)
        values (upper('||quote_literal(sVariavel)||'), '||quote_literal(sConteudo)||');';
      execute sSql;
    end if;

  exception
    when undefined_table then
      lRetorno := false;
    when others then
      lRetorno := false;
  end;

  return lRetorno;
end;
$$
language 'plpgsql';

/**
 * Funcao que finaliza a sessao do dbportal no banco de dados
 * 
 *
 * @author Fabrizio Mello
 * @since  24/09/2007
 *
 * $Id: session.sql,v 1.5 2008/05/14 14:13:55 dbfabrizio Exp $
 */
create or replace function fc_endsession() returns boolean as
$$
declare
  lRetorno   boolean default true;
  sSql       text;
begin

  begin

    sSql := 'drop table '||fc_sessionname()||';';
    execute sSql;

  exception
    when undefined_table then
      lRetorno := false;
    when others then
      lRetorno := false;
  end;

  return lRetorno;
end;
$$
language 'plpgsql';

/**
 * Funcao que seta o search_path do PostgreSQL de acordo com os módulos 
 * da documentação do DBPortal
 *
 * @author Fabrizio Mello
 * @since  01/11/2008
 *
 * $Id: session.sql,v 1.5 2008/05/14 14:13:55 dbfabrizio Exp $
 */
create or replace function fc_set_pg_search_path() returns boolean as
$$
declare
  lRetorno   boolean default true;
  sSql       text;

  sSchemasPath text;
  rModulos     record;
begin

  begin

    sSchemasPath := fc_getsession('DB_pg_search_path');

    if sSchemasPath is null then

      sSchemasPath := 
        array_to_string(
          array(
            select *
              from ( (select 'public' as nomemod)
                      union all
                     (select distinct
                             regexp_replace(lower(to_ascii(nomemod)), '[^A-Za-z]' , '', 'g') as nomemod
                        from configuracoes.db_sysmodulo
                    order by 1)
            ) as x
            where exists (select 1 from pg_namespace where nspname = nomemod)
          ), ', '
        );

      perform fc_putsession('DB_pg_search_path', sSchemasPath);

    end if;

    sSql := 'set search_path='||sSchemasPath||';';
    execute sSql;

  exception
    when undefined_table then
      lRetorno := false;
    when others then
      lRetorno := false;
  end;

  return lRetorno;
end;
$$
language 'plpgsql';

