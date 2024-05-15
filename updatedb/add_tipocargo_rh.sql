BEGIN;

select fc_startsession();

ALTER  TABLE tpcontra add COLUMN  h13_tipocargo  int8 null;
ALTER  TABLE tpcontra add COLUMN  h13_tipocargodescr  VARCHAR(150) null;

commit;