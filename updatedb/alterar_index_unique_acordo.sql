begin;
select fc_startsession();
DROP INDEX acordos.acordo_numeroacordo_anousu_instit_in;

CREATE UNIQUE INDEX acordo_numeroacordo_anousu_instit_in
  ON acordos.acordo
  USING btree
  (ac16_numeroacordo, ac16_anousu, ac16_instit, ac16_acordocategoria);
 
 commit;