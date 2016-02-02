BEGIN;

  DO $$
	declare
     lRetorno boolean default true;
     begin
       EXECUTE ('CREATE SCHEMA cms');
       EXECUTE ('insert into cms.visitantes values (1,1)');
     exception
       when others then
         raise info 'Error Code: % - %', SQLSTATE, SQLERRM;
         lRetorno := false;
     END$$;

CREATE TABLE if not exists cms.configuracoes
(
  id serial NOT NULL,
  contador_visitas boolean DEFAULT true,
  CONSTRAINT configuracoes_id_pk PRIMARY KEY (id)
);

CREATE TABLE if not exists cms.menus
(
  id serial NOT NULL,
  name character varying(100),
  ajax boolean DEFAULT true,
  static boolean DEFAULT true,
  plugin character varying(100),
  controller character varying(100),
  action character varying(100),
  params character varying(150),
  upload boolean DEFAULT false,
  file character varying(200),
  content text,
  lft integer,
  rght integer,
  parent_id integer,
  visible boolean DEFAULT true,
  CONSTRAINT menus_id_pk PRIMARY KEY (id)
);

CREATE TABLE  if not exists cms.users
(
  id serial NOT NULL,
  name character varying(150),
  login character varying(100),
  password character varying(256),
  user_id integer,
  CONSTRAINT users_id_pk PRIMARY KEY (id)
);

CREATE TABLE  if not exists cms.visitantes
(
  id serial NOT NULL,
  quantidade integer NOT NULL DEFAULT 0,
  CONSTRAINT visitantes_id_pk PRIMARY KEY (id)
);

commit;
