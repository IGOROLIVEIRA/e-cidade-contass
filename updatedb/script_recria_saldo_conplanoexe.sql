select fc_startsession();

begin;

delete from conplanoexesaldo;

create table landeb as select c69_anousu,
                              c69_debito,to_char(c69_data,'MM')::integer,
                              sum(round(c69_valor,2)),0::float8
                         from conlancamval
                        group by c69_anousu,c69_debito,to_char(c69_data,'MM')::integer;

create table lancre as select c69_anousu,
                              c69_credito,to_char(c69_data,'MM')::integer,
                              0::float8,
                              sum(round(c69_valor,2))
                         from conlancamval
                        group by c69_anousu,c69_credito,to_char(c69_data,'MM')::integer;

insert into conplanoexesaldo select * from landeb;

update conplanoexesaldo set c68_credito = lancre.sum
  from lancre
 where c68_anousu = lancre.c69_anousu
   and c68_reduz  = lancre.c69_credito
   and c68_mes    = lancre.to_char;

delete from lancre
      using conplanoexesaldo
      where lancre.c69_anousu          = conplanoexesaldo.c68_anousu
        and conplanoexesaldo.c68_reduz = lancre.c69_credito
        and conplanoexesaldo.c68_mes   = lancre.to_char;

insert into conplanoexesaldo select * from lancre;

drop table landeb;
drop table lancre;

commit;
