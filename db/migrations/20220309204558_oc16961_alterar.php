<?php

use Classes\PostgresMigration;

class Oc16961Alterar extends PostgresMigration
{

    public function up()
    {
        $sql = "
            begin;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333190920200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333190940200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333191130400000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333191130500000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333191920100000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333191920200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333191920300000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333191940100000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333191940200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333191940300000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333195920100000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333195920200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333195920300000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333195940100000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333195940200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333195940300000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333196920100000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333196920200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333196920300000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333196940100000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333196940200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '333196940300000'  and c60_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331909202000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331909402000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331911304000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331911305000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331919201000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331919202000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331919203000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331919401000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331919402000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331919403000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331959201000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331959202000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331959203000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331959401000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331959402000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331959403000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331969201000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331969202000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331969203000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331969401000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331969402000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3331969403000'  and o56_anousu > 2021;
            update conplanoorcamento set c60_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where c60_estrut = '333190920100000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Pensões do RPPS e do Militar'                       where c60_estrut = '333190920300000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Ind Demis Serv Empreg Indeniz Restit Trab Ativ Civ' where c60_estrut = '333190940100000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Indenizações e Restituições Trab. Inat. Civil'      where c60_estrut = '333190940300000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Outras Obrigações Patronais'                        where c60_estrut = '333191139900000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where c60_estrut = '333190010000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Pensões'                                            where c60_estrut = '333190030000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where c60_estrut = '333320010000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Pensões'                                            where c60_estrut = '333320030000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Pensões Especiais'                                  where c60_estrut = '333390590000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Despesas do Orçamento de Investimento'              where c60_estrut = '333390980000000' and c60_anousu >2021;
            update orcelemento set o56_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where o56_elemento = '3331909201000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Pensões do RPPS e do Militar'                       where o56_elemento = '3331909203000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Ind Demis Serv Empreg Indeniz Restit Trab Ativ Civ' where o56_elemento = '3331909401000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Indenizações e Restituições Trab. Inat. Civil'      where o56_elemento = '3331909403000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Outras Obrigações Patronais'                        where o56_elemento = '3331911399000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where o56_elemento = '3331900100000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Pensões'                                            where o56_elemento = '3331900300000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where o56_elemento = '3333200100000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Pensões'                                            where o56_elemento = '3333200300000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Pensões Especiais'                                  where o56_elemento = '3333905900000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Despesas do Orçamento de Investimento'              where o56_elemento = '3333909800000' and o56_anousu >2021;
            delete from conplanoconplanoorcamento where c72_anousu > 2021
            and c72_conplanoorcamento in (select c60_codcon from conplanoorcamento where c60_anousu > 2021 and c60_estrut in ('333190920200000','333190940200000','333191130400000','333191130500000','333191920100000',
            '333191920200000','333191920300000','333191940100000','333191940200000','333191940300000','333195920100000'
            ,'333195920200000','333195920300000','333195940100000','333195940200000','333195940300000','333196920100000'
            ,'333196920200000','333196920300000','333196940100000','333196940200000','333196940300000'));
            commit;
        ";

        $this->execute($sql);
    }
}
