select fc_startsession();
begin;

CREATE SEQUENCE balancete102016_si177_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete102016_si177_sequencial_seq
  OWNER TO dbportal;

CREATE SEQUENCE balancete112016_si178_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete112016_si178_sequencial_seq
  OWNER TO dbportal;

CREATE SEQUENCE balancete122016_si179_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete122016_si179_sequencial_seq
  OWNER TO dbportal;

CREATE SEQUENCE balancete132016_si180_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete132016_si180_sequencial_seq
  OWNER TO dbportal;

  CREATE SEQUENCE balancete142016_si181_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete142016_si181_sequencial_seq
  OWNER TO dbportal;

  CREATE SEQUENCE balancete152016_si182_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete152016_si182_sequencial_seq
  OWNER TO dbportal;

CREATE SEQUENCE balancete162016_si183_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete162016_si183_sequencial_seq
  OWNER TO dbportal;

CREATE SEQUENCE balancete172016_si184_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete172016_si184_sequencial_seq
  OWNER TO dbportal;

CREATE SEQUENCE balancete182016_si185_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete182016_si185_sequencial_seq
  OWNER TO dbportal;

CREATE SEQUENCE balancete192016_si186_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete192016_si186_sequencial_seq
  OWNER TO dbportal;

CREATE SEQUENCE balancete202016_si187_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete202016_si187_sequencial_seq
  OWNER TO dbportal;

CREATE SEQUENCE balancete212016_si188_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete212016_si188_sequencial_seq
  OWNER TO dbportal;

CREATE SEQUENCE balancete222016_si189_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete222016_si189_sequencial_seq
  OWNER TO dbportal;
  
CREATE SEQUENCE balancete232016_si190_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete232016_si190_sequencial_seq
  OWNER TO dbportal;

CREATE SEQUENCE balancete242016_si191_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE balancete242016_si191_sequencial_seq
  OWNER TO dbportal;


alter table balancete112016 add column si178_reg10 int8 not null;
alter table balancete122016 add column si179_reg10 int8 not null;
alter table balancete132016 add column si180_reg10 int8 not null;
alter table balancete142016 add column si181_reg10 int8 not null;
alter table balancete152016 add column si182_reg10 int8 not null;
alter table balancete162016 add column si183_reg10 int8 not null;
alter table balancete172016 add column si184_reg10 int8 not null;
alter table balancete182016 add column si185_reg10 int8 not null;
alter table balancete192016 add column si186_reg10 int8 not null;
alter table balancete202016 add column si187_reg10 int8 not null;
alter table balancete212016 add column si188_reg10 int8 not null;
alter table balancete222016 add column si189_reg10 int8 not null;
alter table balancete232016 add column si190_reg10 int8 not null;
alter table balancete242016 add column si191_reg10 int8 not null;

alter table balancete112016 add constraint fk_balancete102016_si77_sequencial foreign key (si178_reg10) references balancete102016 (si177_sequencial);
alter table balancete122016 add constraint fk_balancete102016_si77_sequencial foreign key (si179_reg10) references balancete102016 (si177_sequencial);
alter table balancete132016 add constraint fk_balancete102016_si77_sequencial foreign key (si180_reg10) references balancete102016 (si177_sequencial);
alter table balancete142016 add constraint fk_balancete102016_si77_sequencial foreign key (si181_reg10) references balancete102016 (si177_sequencial);
alter table balancete152016 add constraint fk_balancete102016_si77_sequencial foreign key (si182_reg10) references balancete102016 (si177_sequencial);
alter table balancete162016 add constraint fk_balancete102016_si77_sequencial foreign key (si183_reg10) references balancete102016 (si177_sequencial);
alter table balancete172016 add constraint fk_balancete102016_si77_sequencial foreign key (si184_reg10) references balancete102016 (si177_sequencial);
alter table balancete182016 add constraint fk_balancete102016_si77_sequencial foreign key (si185_reg10) references balancete102016 (si177_sequencial);
alter table balancete202016 add constraint fk_balancete102016_si77_sequencial foreign key (si187_reg10) references balancete102016 (si177_sequencial);
alter table balancete212016 add constraint fk_balancete102016_si77_sequencial foreign key (si188_reg10) references balancete102016 (si177_sequencial);
alter table balancete222016 add constraint fk_balancete102016_si77_sequencial foreign key (si189_reg10) references balancete102016 (si177_sequencial);
alter table balancete232016 add constraint fk_balancete102016_si77_sequencial foreign key (si190_reg10) references balancete102016 (si177_sequencial);
alter table balancete242016 add constraint fk_balancete102016_si77_sequencial foreign key (si191_reg10) references balancete102016 (si177_sequencial);
commit;