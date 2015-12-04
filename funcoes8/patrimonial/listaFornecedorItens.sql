drop   function fc_listafornecedoritens(integer);
drop   type tp_lista_fornecedor_itens;

create type tp_lista_fornecedor_itens as ( riCodItem	     integer, 
										   rvDescrItemFornec varchar,
										   rnQtdItem         float,
										   rnVlrUnit         float,
										   rnVlrTotal        float,
                                           rnResumItem       varchar,
                                           rnUnidItem        varchar,
                                           rnOrdItem         integer,
                                           rnQntMin          float,
                                           rnQntMax          float );


create or replace function fc_listafornecedoritens(integer) returns setof tp_lista_fornecedor_itens  as
$$
declare

	iCodLicitacao	  alias for  $1;
		
    sSqlItens         text;	
    sSqlFornecedores  text;	
	
	rtp_lista         tp_lista_fornecedor_itens%ROWTYPE;
 
    rItens            record;
    rFornecedores     record;

begin


  sSqlItens :=  'select pc26_orcamitem  as cod_orcamitem,
                        pc01_codmater   as cod_item,
                        pc01_descrmater as descr_item,
                        pc11_quant      as qtd_orcada,
                        pc11_resum      as resumo_item,
                        m61_descr       as unidade_item,
                        l21_ordem       as ordem_item,
                        pc57_quantmin   as quantidade_minima,
                        pc57_quantmax   as quantidade_maxima
                   from liclicitem
                        inner join pcorcamitemlic         on pcorcamitemlic.pc26_liclicitem        = liclicitem.l21_codigo
                        inner join pcprocitem             on pcprocitem.pc81_codprocitem           = liclicitem.l21_codpcprocitem
                        inner join solicitem              on solicitem.pc11_codigo                 = pcprocitem.pc81_solicitem
                        inner join solicitempcmater       on solicitempcmater.pc16_solicitem       = solicitem.pc11_codigo
                        inner join pcmater                on pcmater.pc01_codmater                 = solicitempcmater.pc16_codmater
                        left  join solicitemunid          on solicitemunid.pc17_codigo             = solicitem.pc11_codigo
                        left  join matunid                on matunid.m61_codmatunid                = solicitemunid.pc17_unid
                        left  join solicitemregistropreco on solicitemregistropreco.pc57_solicitem = solicitem.pc11_codigo
                  where l21_codliclicita ='||iCodLicitacao||'
               order by l21_ordem asc'; 


  for rItens in execute sSqlItens loop

    sSqlFornecedores := 'select z01_numcgm      as cgm_fornecedor,
                                z01_nome        as nome_fornecedor,
                                pc23_vlrun      as vlr_unitario,
                                pc23_valor      as vlr_total
                           from liclicitem        
                                inner join pcorcamitemlic on pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo         
                                inner join pcorcamitem    on pcorcamitem.pc22_orcamitem     = pcorcamitemlic.pc26_orcamitem        
                                inner join pcorcamforne   on pcorcamforne.pc21_codorc       = pcorcamitem.pc22_codorc        
                                inner join cgm            on cgm.z01_numcgm                 = pcorcamforne.pc21_numcgm 
                                inner join pcorcamval     on pcorcamval.pc23_orcamitem      = pcorcamitem.pc22_orcamitem
                                                         and pcorcamval.pc23_orcamforne     = pcorcamforne.pc21_orcamforne     
                           where l21_codliclicita ='||iCodLicitacao||'
                             and pcorcamitem.pc22_orcamitem ='||rItens.cod_orcamitem||'
                        order by pc23_valor asc';
    

    rtp_lista.riCodItem         := rItens.cod_item;
    rtp_lista.rvDescrItemFornec := rItens.descr_item;
    rtp_lista.rnQtdItem         := rItens.qtd_orcada;

    rtp_lista.rnResumItem       := rItens.resumo_item;
    rtp_lista.rnUnidItem        := rItens.unidade_item;
    rtp_lista.rnOrdItem         := rItens.ordem_item;
    rtp_lista.rnQntMin          := rItens.quantidade_minima;
    rtp_lista.rnQntMax          := rItens.quantidade_maxima;

    rtp_lista.rnVlrUnit         := null;
    rtp_lista.rnVlrTotal        := null;

	return  next rtp_lista;

    for rFornecedores in execute sSqlFornecedores loop

      rtp_lista.riCodItem         := null;
      rtp_lista.rvDescrItemFornec := rFornecedores.nome_fornecedor;
      rtp_lista.rnQtdItem         := null;
      rtp_lista.rnVlrUnit         := rFornecedores.vlr_unitario;
      rtp_lista.rnVlrTotal        := rFornecedores.vlr_total;

      return next rtp_lista;

    end loop;

    rtp_lista.riCodItem         := null;
    rtp_lista.rvDescrItemFornec := null;
    rtp_lista.rnQtdItem         := null;
    rtp_lista.rnVlrUnit         := null;
    rtp_lista.rnVlrTotal        := null;
    rtp_lista.rnResumItem       := null;
    rtp_lista.rnUnidItem        := null;
    rtp_lista.rnOrdItem         := null;
    rtp_lista.rnQntMin          := null;
    rtp_lista.rnQntMax          := null;

    return next rtp_lista;

  end loop;

  return;

end;

$$ language 'plpgsql';
