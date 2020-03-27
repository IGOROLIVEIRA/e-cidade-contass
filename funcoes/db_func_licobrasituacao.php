<?
$campos = "obr02_sequencial,obr01_numeroobra,l20_edital,l03_descr, l20_numero,l20_objeto,CASE obr02_situacao
    WHEN 1 THEN 'Não Iniciada'
    WHEN 2 THEN 'Iniciada'
    WHEN 3 THEN 'Paralizada por rescisão contratual'
    WHEN 4 THEN 'Paralizada'
    WHEN 5 THEN 'Concluida e não recebida'
    WHEN 6 THEN 'Concluída e recebida provisoriamente'
    WHEN 7 THEN 'Concluída e recebida definitivamente'
    WHEN 8 THEN 'Reiniciada'
END AS obr02_situacao";
?>
