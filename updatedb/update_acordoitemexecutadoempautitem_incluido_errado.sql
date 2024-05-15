begin;
select fc_startsession();
update acordoitemexecutadoempautitem set ac19_sequen = (select e55_sequen from empautitem where e55_autori=ac19_autori and e55_item = (select ac20_pcmater from acordoitem join acordoitemexecutado ON  ac20_sequencial = ac29_acordoitem where ac29_sequencial = ac19_acordoitemexecutado));
commit;
