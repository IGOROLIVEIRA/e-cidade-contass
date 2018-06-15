<?
$campos = "dadoscomplementareslrf.c218_sequencial,
           dadoscomplementareslrf.c218_codorgao,
           case
            when dadoscomplementareslrf.c218_mesusu = 1 then 'Janeiro'
            when dadoscomplementareslrf.c218_mesusu = 2 then 'Fevereiro'
            when dadoscomplementareslrf.c218_mesusu = 3 then 'Março'
            when dadoscomplementareslrf.c218_mesusu = 4 then 'Abril'
            when dadoscomplementareslrf.c218_mesusu = 5 then 'Maio'
            when dadoscomplementareslrf.c218_mesusu = 6 then 'Junho'
            when dadoscomplementareslrf.c218_mesusu = 7 then 'Julho'
            when dadoscomplementareslrf.c218_mesusu = 8 then 'Agosto'
            when dadoscomplementareslrf.c218_mesusu = 9 then 'Setembro'
            when dadoscomplementareslrf.c218_mesusu = 10 then 'Outubro'
            when dadoscomplementareslrf.c218_mesusu = 11 then 'Novembro'
            else 'Dezembro' end as Mes
            ,
           dadoscomplementareslrf.c218_anousu";
?>
