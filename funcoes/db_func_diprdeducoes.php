<?php

$campos  = " c239_sequencial, ";
$campos .= " c239_coddipr, ";
$campos .= " c239_tipoente, ";
$campos .= " c239_datasicom, ";
$campos .= " (ARRAY['Janeiro', 'Fevereiro', 'Marзo', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'])[c239_mescompetencia] AS c239_mescompetencia, ";
$campos .= " c239_exerciciocompetencia, ";
$campos .= " (ARRAY['Fundo em Capitalizaзгo (Plano Previdenciбrio)', 'Fundo em Repartiзгo (Plano Financeiro)', 'Responsabilidade do tesouro municipal'])[c239_tipofundo] as c239_tipofundo, ";
$campos .= " (ARRAY['Patronal', 'Segurado'])[c239_tiporepasse] as c239_tiporepasse, ";
$campos .= " (ARRAY['Servidores', 'Servidores afastados com benefнcios pagos pela Unidade Gestora (auxнlio-doenзa, salбrio maternidade e outros)', 'Aposentados', 'Pensionistas'])[c239_tipocontribuicaopatronal] as c239_tipocontribuicaopatronal, ";
$campos .= " (ARRAY['Servidores', 'Aposentados', 'Pensionistas'])[c239_tipocontribuicaosegurados] as c239_tipocontribuicaosegurados, ";
$campos .= " (ARRAY['Normal', 'Suplementar'])[c239_tipodeducao] as c239_tipodeducao, ";
$campos .= " (ARRAY['Pagamento a maior', 'Outros valores compensados'])[c239_tipodeducao] as c239_tipodeducao, ";
$campos .= " c239_valordeducao ";