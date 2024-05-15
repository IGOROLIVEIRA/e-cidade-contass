<?php

$campos  = " c238_sequencial, ";
$campos .= " c238_coddipr, ";
$campos .= " c238_tipoente, ";
$campos .= " c238_datasicom, ";
$campos .= " (ARRAY['Janeiro', 'Fevereiro', 'Marзo', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'])[c238_mescompetencia] AS c238_mescompetencia, ";
$campos .= " c238_exerciciocompetencia, ";
$campos .= " (ARRAY['Fundo em Capitalizaзгo (Plano Previdenciбrio)', 'Fundo em Repartiзгo (Plano Financeiro)', 'Responsabilidade do tesouro municipal'])[c238_tipofundo] as c238_tipofundo, ";
$campos .= " (ARRAY['Patronal', 'Segurado'])[c238_tiporepasse] as c238_tiporepasse, ";
$campos .= " (ARRAY['Servidores', 'Servidores afastados com benefнcios pagos pela Unidade Gestora (auxнlio-doenзa, salбrio maternidade e outros)', 'Aposentados', 'Pensionistas'])[c238_tipocontribuicaopatronal] as c238_tipocontribuicaopatronal, ";
$campos .= " (ARRAY['Servidores', 'Aposentados', 'Pensionistas'])[c238_tipocontribuicaosegurados] as c238_tipocontribuicaosegurados, ";
$campos .= " (ARRAY['Normal', 'Suplementar'])[c238_tipocontribuicao] as c238_tipocontribuicao, ";
$campos .= " c238_datarepasse, ";
$campos .= " c238_datavencimentorepasse, ";
$campos .= " c238_valororiginal, ";
$campos .= " c238_valororiginalrepassado ";