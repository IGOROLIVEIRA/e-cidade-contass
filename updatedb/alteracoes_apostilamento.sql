begin;
select fc_startsession();
alter table apostilamento add column si03_acordoposicao integer;
alter table apostilamento add constraint apostilamento_acordoposicao_fk foreign key (si03_acordoposicao) references acordoposicao(ac26_sequencial);

CREATE UNIQUE INDEX apoostilamento_sequencial_acordoposicao_in
  ON apostilamento
  USING btree
  (si03_sequencial, si03_acordoposicao);

alter table acordoposicao add column ac26_numeroapostilamento varchar(20);

/*adicionar tipos necessarios para apostilamento*/
insert into acordoposicaotipo values (15,'Acréscimo de Valor (Apostilamento)'),(16,'Decréscimo de Valor (Apostilamento)'),(17,'Não houve alteração de Valor (Apostilamento)');

/*retirar menu de alteracao de apostila*/
update db_itensmenu set libcliente = 'f' where funcao = 'sic1_apostilamentonovo002.php';

/*mudar menu de Apostilamento de Cadastro para Procedimentos*/
update db_menu set id_item = 32, menusequencia = 375 where id_item_filho = 4000309;
commit;