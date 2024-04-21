<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc16961Alterar extends PostgresMigration
{

    public function up()
    {
        $sql = "
            begin;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331909202000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331909402000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331911304000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331911305000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331919201000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331919202000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331919203000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331919401000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331919402000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331919403000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331959201000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331959202000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331959203000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331959401000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331959402000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331959403000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331969201000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331969202000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331969203000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331969401000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331969402000000'  and c60_anousu > 2021;
            update conplanoorcamento set c60_descr = 'DESATIVADA 2022' where c60_estrut = '331969403000000'  and c60_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319092020000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319094020000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319113040000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319113050000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319192010000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319192020000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319192030000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319194010000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319194020000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319194030000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319592010000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319592020000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319592030000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319594010000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319594020000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319594030000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319692010000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319692020000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319692030000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319694010000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319694020000'  and o56_anousu > 2021;
            update orcelemento set o56_descr = 'DESATIVADA 2022' where o56_elemento = '3319694030000'  and o56_anousu > 2021;
            update conplanoorcamento set c60_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where c60_estrut = '331909201000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Pensões do RPPS e do Militar'                       where c60_estrut = '331909203000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Indenizações por Dem. e Prog. de Inc. à Dem. Vol.' where c60_estrut = '331909401000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Indenizações e Restituições Trab. Inat. Civil'      where c60_estrut = '331909403000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Outras Obrigações Patronais'                        where c60_estrut = '331911399000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where c60_estrut = '331900100000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Pensões'                                            where c60_estrut = '331900300000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where c60_estrut = '333200100000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Pensões'                                            where c60_estrut = '333200300000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Pensões Especiais'                                  where c60_estrut = '333905900000000' and c60_anousu >2021;
            update conplanoorcamento set c60_descr = 'Despesas do Orçamento de Investimento'              where c60_estrut = '333909800000000' and c60_anousu >2021;
            update orcelemento set o56_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where o56_elemento = '3319092010000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Pensões do RPPS e do Militar'                       where o56_elemento = '3319092030000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Indenizações por Dem. e Prog. de Inc. à Dem. Vol.' where o56_elemento = '3319094010000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Indenizações e Restituições Trab. Inat. Civil'      where o56_elemento = '3319094030000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Outras Obrigações Patronais'                        where o56_elemento = '3319113990000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where o56_elemento = '3319001000000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Pensões'                                            where o56_elemento = '3319003000000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Aposentadorias, Reserva Remunerada e Reformas'      where o56_elemento = '3332001000000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Pensões'                                            where o56_elemento = '3332003000000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Pensões Especiais'                                  where o56_elemento = '3339059000000' and o56_anousu >2021;
            update orcelemento set o56_descr = 'Despesas do Orçamento de Investimento'              where o56_elemento = '3339098000000' and o56_anousu >2021;
            delete from conplanoconplanoorcamento where c72_anousu > 2021
            and c72_conplanoorcamento in (select c60_codcon from conplanoorcamento where c60_anousu > 2021 and c60_estrut in ('331909202000000','331909402000000','331911304000000','331911305000000','331919201000000',
            '331919202000000','331919203000000','331919401000000','331919402000000','331919403000000','331959201000000'
            ,'331959202000000','331959203000000','331959401000000','331959402000000','331959403000000','331969201000000'
            ,'331969202000000','331969203000000','331969401000000','331969402000000','331969403000000'));
            commit;
        ";

        $this->execute($sql);
    }
}
