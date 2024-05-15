<?
$campos = "contratos.si172_sequencial,contratos.si172_nrocontrato,contratos.si172_exerciciocontrato,
  contratos.si172_licitacao as dl_Seq_Licitação,
 liclicita.l20_edital,liclicita.l20_anousu,contratos.si172_dataassinatura,contratos.si172_fornecedor,

(select z01_nome from cgm  where z01_numcgm = si172_fornecedor)

,contratos.si172_vlcontrato,contratos.si172_datapublicacao";
?>
