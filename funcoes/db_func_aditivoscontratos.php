<?
$campos = "aditivoscontratos.si174_sequencial,aditivoscontratos.si174_nrocontrato,aditivoscontratos.si174_nroseqtermoaditivo,
aditivoscontratos.si174_dataassinaturatermoaditivo,aditivoscontratos.si174_dscalteracao,aditivoscontratos.si174_valoraditivo,
(select z01_nome from cgm join contratos on z01_numcgm = si172_fornecedor 
where si172_nrocontrato = aditivoscontratos.si174_nrocontrato and EXTRACT(year FROM si174_dataassinaturacontoriginal) = EXTRACT(year FROM si172_dataassinatura)
 limit 1) as z01_nome";
?>
