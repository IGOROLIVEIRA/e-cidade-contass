<?php

$campos  = " c240_sequencial, ";
$campos .= " c240_coddipr, ";
$campos .= " c240_tipoente, ";
$campos .= " c240_datasicom, ";
$campos .= " (ARRAY['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'])[c240_mescompetencia] AS c240_mescompetencia, ";
$campos .= " c240_exerciciocompetencia, ";
$campos .= " (ARRAY['Fundo em Capitalização (Plano Previdenciário)', 'Fundo em Repartição (Plano Financeiro)', 'Responsabilidade do tesouro municipal'])[c240_tipofundo] as c240_tipofundo, ";
$campos .= " (ARRAY['Aporte para amortização déficit atuarial', 'Transferência para cobertura insuficiência financeiro', 'Transferência de recursos para pagamento de despesas administrativas', 'Transferência para pagamento de beneficios de responsabilidade do tesouro', 'Outros aportes ou transferências'])[c240_tipoaporte] as c240_tipoaporte, ";
$campos .= " c240_descricao, ";
$campos .= " c240_atonormativo, ";
$campos .= " c240_exercicioatonormativo, ";
$campos .= " c240_valoraporte ";