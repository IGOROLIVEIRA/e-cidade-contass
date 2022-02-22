<?php

$campos  = " c237_sequencial, ";
$campos .= " c237_coddipr, ";
$campos .= " c237_tipoente, ";
$campos .= " c237_datasicom, ";
$campos .= " (ARRAY['Patronal', 'Segurado'])[c237_basecalculocontribuinte] as c237_basecalculocontribuinte, ";
$campos .= " (ARRAY['Janeiro', 'Fevereiro', 'Marзo', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'])[c237_mescompetencia] AS c237_mescompetencia, ";
$campos .= " c237_exerciciocompetencia, ";
$campos .= " (ARRAY['Fundo em Capitalizaзгo (Plano Previdenciбrio)', 'Fundo em Repartiзгo (Plano Financeiro)', 'Responsabilidade do tesouro municipal'])[c237_tipofundo] as c237_tipofundo, ";
$campos .= " c237_remuneracao, ";
$campos .= " (ARRAY['Servidores', 'Servidores afastados com benefнcios pagos pela Unidade Gestora (auxнlio-doenзa, salбrio maternidade e outros)', 'Aposentados', 'Pensionistas'])[c237_basecalculoorgao] as c237_basecalculoorgao, ";
$campos .= " (ARRAY['Servidores', 'Aposentados', 'Pensionistas'])[c237_basecalculosegurados] as c237_basecalculosegurados, ";
$campos .= " c237_valorbasecalculo, ";
$campos .= " (ARRAY['Normal', 'Suplementar'])[c237_tipocontribuinte] as c237_tipocontribuinte, ";
$campos .= " c237_aliquota, ";
$campos .= " c237_valorcontribuicao ";