<?php
$campos  = "agrupamentorescisao.rh113_sequencial,                      ";
$campos .= "agrupamentorescisao.rh113_descricao,                       ";
$campos .= "case                                                       ";
$campos .= "  when agrupamentorescisao.rh113_tipo = 1 then 'PROVENTO'  ";
$campos .= "  when agrupamentorescisao.rh113_tipo = 2 then 'DESCONTO'  ";
$campos .= "  else ''                                                  ";
$campos .= "end as rh113_tipo                                          ";
?>
