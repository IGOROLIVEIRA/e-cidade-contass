begin;

select fc_startsession();

create temp table temp_estoque as (select m70_codigo,m70_codmatmater,m70_coddepto, (select 
(select sum(quantidade) as estoque from (select coalesce(round(m82_quant, 2),0) as quantidade, round(m89_precomedio, 4) as preco_medio, round(m89_valorunitario, 4) as valorunitario, m81_tipo, m80_codigo, m80_codtipo from matestoqueini inner join matestoquetipo on m80_codtipo = m81_codtipo inner join matestoqueinimei on m82_matestoqueini = m80_codigo inner join matestoqueinimeipm on m82_codigo = m89_matestoqueinimei inner join matestoqueitem on m82_matestoqueitem = m71_codlanc inner join matestoque on m71_codmatestoque = m70_codigo 
where m82_matestoqueitem in (select m71_codlanc from (select distinct dpartestoque.coddepto as codigo_departamento, dpartestoque.descrdepto as descricao_departamento, m71_codmatestoque, m71_codlanc, m71_quant, m60_codmater, m60_descr, dpartini.coddepto as codigo_almoxarifado, m77_lote, dpartini.descrdepto as descrisao_almoxarifado, m71_valor, m77_dtvalidade, m76_nome as fabricante, m71_data as data_movimeto from matestoqueinimei inner join matestoqueini on matestoqueini.m80_codigo = matestoqueinimei.m82_matestoqueini inner join matestoquetipo on m80_codtipo = m81_codtipo inner join matestoqueinimeipm on m82_codigo = m89_matestoqueinimei inner join db_usuarios on m80_login = id_usuario inner join db_depart as dpartini on m80_coddepto = dpartini. coddepto inner join matestoqueitem on m82_matestoqueitem = m71_codlanc inner join matestoque on m71_codmatestoque = m70_codigo inner join db_depart as dpartestoque on m70_coddepto = dpartestoque.coddepto inner join matmater on m60_codmater = m70_codmatmater left join matestoqueitemlote on m77_matestoqueitem = m71_codlanc left join matestoqueitemfabric on m78_matestoqueitem = m71_codlanc left join matfabricante on m76_sequencial = m78_matfabricante where m70_coddepto in (m.m70_coddepto) and m70_codmatmater in (m.m70_codmatmater) and dpartini.instit in (1) and m60_ativo = 't' and m71_servico is false order by m60_descr) as x) 
and m81_tipo in (1) order by m80_data,m80_hora, m80_codigo ) as estoque) -
(select sum(quantidade) as atendido from (select coalesce(round(m82_quant, 2),0) as quantidade, round(m89_precomedio, 4) as preco_medio, round(m89_valorunitario, 4) as valorunitario, m81_tipo, m80_codigo, m80_codtipo from matestoqueini inner join matestoquetipo on m80_codtipo = m81_codtipo inner join matestoqueinimei on m82_matestoqueini = m80_codigo inner join matestoqueinimeipm on m82_codigo = m89_matestoqueinimei inner join matestoqueitem on m82_matestoqueitem = m71_codlanc inner join matestoque on m71_codmatestoque = m70_codigo 
where m82_matestoqueitem in (select m71_codlanc from (select distinct dpartestoque.coddepto as codigo_departamento, dpartestoque.descrdepto as descricao_departamento, m71_codmatestoque, m71_codlanc, m71_quant, m60_codmater, m60_descr, dpartini.coddepto as codigo_almoxarifado, m77_lote, dpartini.descrdepto as descrisao_almoxarifado, m71_valor, m77_dtvalidade, m76_nome as fabricante, m71_data as data_movimeto from matestoqueinimei inner join matestoqueini on matestoqueini.m80_codigo = matestoqueinimei.m82_matestoqueini inner join matestoquetipo on m80_codtipo = m81_codtipo inner join matestoqueinimeipm on m82_codigo = m89_matestoqueinimei inner join db_usuarios on m80_login = id_usuario inner join db_depart as dpartini on m80_coddepto = dpartini. coddepto inner join matestoqueitem on m82_matestoqueitem = m71_codlanc inner join matestoque on m71_codmatestoque = m70_codigo inner join db_depart as dpartestoque on m70_coddepto = dpartestoque.coddepto inner join matmater on m60_codmater = m70_codmatmater left join matestoqueitemlote on m77_matestoqueitem = m71_codlanc left join matestoqueitemfabric on m78_matestoqueitem = m71_codlanc left join matfabricante on m76_sequencial = m78_matfabricante where m70_coddepto in (m.m70_coddepto) and m70_codmatmater in (m.m70_codmatmater) and dpartini.instit in (1) and m60_ativo = 't' and m71_servico is false order by m60_descr) as x) 
and m81_tipo in (2) order by m80_data,m80_hora, m80_codigo ) as atendido) as saldo) as estoque,
(select m89_precomedio from 
matestoqueinimeipm
join matestoqueinimei on m82_codigo = matestoqueinimeipm.m89_matestoqueinimei
join matestoqueitem on m82_matestoqueitem = matestoqueitem.m71_codlanc
join matestoque on m71_codmatestoque = matestoque.m70_codigo
where m70_coddepto in (m.m70_coddepto) and m70_codmatmater in (m.m70_codmatmater) order by m89_sequencial desc limit 1) as preco_medio
 from matestoque as m where m70_quant is null);

update temp_estoque set preco_medio = round(round(preco_medio,2)*estoque,2);

alter table matestoque disable trigger all ;

 update matestoque set m70_quant=(select estoque::double precision from temp_estoque where matestoque.m70_codmatmater = temp_estoque.m70_codmatmater and matestoque.m70_coddepto = temp_estoque.m70_coddepto), 
m70_valor=(select preco_medio::double precision from temp_estoque where matestoque.m70_codmatmater = temp_estoque.m70_codmatmater and matestoque.m70_coddepto = temp_estoque.m70_coddepto) where m70_quant is null;

alter table matestoque enable trigger all ;

commit;

/*select estoque from temp_estoque where m70_codmatmater=44 and m70_coddepto=45;

select * from matestoque where m70_codmatmater=44 and m70_coddepto=45;
select * from matestoque where m70_quant is null*/





