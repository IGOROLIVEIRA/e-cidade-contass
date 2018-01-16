begin;
alter table parissqn add COLUMN q60_aliq_reduzida integer DEFAULT 0;
alter table issconfiguracaogruposervico add COLUMN q136_valor_reduzido double precision NOT NULL DEFAULT 0;
commit;