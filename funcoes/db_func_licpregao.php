<?
$campos = "licpregao.l45_sequencial,
           case when licpregao.l45_tipo::varchar = '1' then 'Permanente'
                when licpregao.l45_tipo::varchar = '2' then 'Especial'
           end as l45_tipo
,licpregao.l45_data,licpregao.l45_validade,
		   l45_numatonomeacao as dl_Nº_ato_nomeação,
		   case when licpregao.l45_descrnomeacao::varchar = '1' then 'Portaria'
		        when licpregao.l45_descrnomeacao::varchar = '2' then 'Decreto'
		   end as l45_descrnomeacao
			";
?>
