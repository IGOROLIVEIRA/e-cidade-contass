<?php

use Classes\PostgresMigration;

class Oc16961Alterar extends PostgresMigration
{

    public function up()
    {
        $sql = "
            begin;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33190920200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33190940200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33191130400000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33191130500000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33191920100000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33191920200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33191920300000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33191940100000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33191940200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33191940300000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33195920100000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33195920200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33195920300000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33195940100000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33195940200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33195940300000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33196920100000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33196920200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33196920300000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33196940100000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33196940200000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '33196940300000'  and c60_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331909202000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331909402000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331911304000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331911305000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331919201000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331919202000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331919203000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331919401000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331919402000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331919403000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331959201000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331959202000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331959203000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331959401000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331959402000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331959403000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331969201000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331969202000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331969203000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331969401000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331969402000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '331969403000'  and o56_anousu > 2021;
            update conplanoorcamento set c60_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where c60_estrut = '33190920100000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Pensões do RPPS e do Militar'                       where c60_estrut = '33190920300000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Ind Demis Serv Empreg Indeniz Restit Trab Ativ Civ' where c60_estrut = '33190940100000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Indenizações e Restituições Trab. Inat. Civil'      where c60_estrut = '33190940300000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Outras Obrigações Patronais'                        where c60_estrut = '33191139900000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where c60_estrut = '33190010000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Pensões'                                            where c60_estrut = '33190030000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where c60_estrut = '33320010000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Pensões'                                            where c60_estrut = '33320030000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Pensões Especiais'                                  where c60_estrut = '33390590000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Despesas do Orçamento de Investimento'              where c60_estrut = '33390980000000' and c60_anousu >2021;
            update orcelemento set o56_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where o56_elemento = '331909201000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Pensões do RPPS e do Militar'                       where o56_elemento = '331909203000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Ind Demis Serv Empreg Indeniz Restit Trab Ativ Civ' where o56_elemento = '331909401000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Indenizações e Restituições Trab. Inat. Civil'      where o56_elemento = '331909403000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Outras Obrigações Patronais'                        where o56_elemento = '331911399000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where o56_elemento = '331900100000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Pensões'                                            where o56_elemento = '331900300000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where o56_elemento = '333200100000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Pensões'                                            where o56_elemento = '333200300000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Pensões Especiais'                                  where o56_elemento = '333905900000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Despesas do Orçamento de Investimento'              where o56_elemento = '333909800000' and o56_anousu >2021;
            delete from conplanoconplanoorcamento where c72_anousu > 2021
            and c72_conplanoorcamento in (select c60_codcon from conplanoorcamento where c60_anousu > 2021 and c60_estrut in ('33190920200000','33190940200000','33191130400000','33191130500000','33191920100000',
            '33191920200000','33191920300000','33191940100000','33191940200000','33191940300000','33195920100000'
            ,'33195920200000','33195920300000','33195940100000','33195940200000','33195940300000','33196920100000'
            ,'33196920200000','33196920300000','33196940100000','33196940200000','33196940300000'));
            commit;
        ";

        $this->execute($sql);
    }
}
