--drop function fc_cornump_inc();
create or replace function fc_arrecad_before_inc() returns trigger as 
$$
declare 

  sOperacao           varchar;

  iDeclaracaoQuitacao integer;
  iExercicio          integer;

begin

  -- Operacao da Trigger
  sOperacao   := upper(TG_OP);

  -- Gera valor com 2 digitos

  new.k00_valor := round(new.k00_valor,2);
  --raise notice 'valor_depois%',new.k00_valor;


  -- Exercicio do debito
  iExercicio := extract( year from new.k00_dtvenc );

  -- Verifica se existe alguma declaracao de debito ativa para o CGM e exercicio do debito 
  select ar30_sequencial
    into iDeclaracaoQuitacao
    from declaracaoquitacao
         inner join declaracaoquitacaocgm on declaracaoquitacaocgm.ar34_declaracaoquitacao = declaracaoquitacao.ar30_sequencial
   where declaracaoquitacao.ar30_exercicio    = iExercicio
     and declaracaoquitacao.ar30_situacao     = 1
     and declaracaoquitacaocgm.ar34_numcgm    = new.k00_numcgm;

  -- Caso exista algum registro, entao e cancelada a declaracao de debito
  if iDeclaracaoQuitacao is not null then

    update declaracaoquitacao
       set ar30_situacao = 3
     where ar30_sequencial = iDeclaracaoQuitacao;
 
    insert into declaracaoquitacaocancelamento ( ar32_sequencial, 
                                                 ar32_declaracaoquitacao,
                                                 ar32_id_usuario, 
                                                 ar32_datacancelamento, 
                                                 ar32_hora,
                                                 ar32_obs,
                                                 ar32_automatico 
                                               ) values (
                                                 nextval('declaracaoquitacaocancelamento_ar32_sequencial_seq'),
                                                 iDeclaracaoQuitacao,
                                                 cast(fc_getsession('DB_id_usuario') as integer),
                                                 cast(fc_getsession('DB_datausu') as date ),
                                                 cast( extract( hour from current_time)||':'||extract ( minute from current_time ) as char(5) ),
                                                 'Cancelamento automatico efetuado devido a inclusao do debito Numpre/Parcela: '||new.k00_numpre||'/'||new.k00_numpar||' no exercicio : '||iExercicio,
                                                 true
                                               );
  end if;

  return new;
     
end;
$$ 
language 'plpgsql';

drop TRIGGER "tg_arrecad_before_inc" on caixa.arrecad;
drop TRIGGER "tg_arrecad_before_alt" on caixa.arrecad;
CREATE TRIGGER "tg_arrecad_before_inc" BEFORE INSERT ON caixa.arrecad FOR EACH ROW EXECUTE PROCEDURE "fc_arrecad_before_inc" () ;
CREATE TRIGGER "tg_arrecad_before_alt" BEFORE UPDATE ON caixa.arrecad FOR EACH ROW EXECUTE PROCEDURE "fc_arrecad_before_inc" () ;
