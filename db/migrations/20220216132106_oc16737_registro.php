<?php

use Phinx\Migration\AbstractMigration;

class Oc16737Registro extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
            begin;
            update conplano set c60_nregobrig= 16 where c60_estrut like '1138199%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 25 where c60_estrut like '1211297%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 25 where c60_estrut like '1211299%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 25 where c60_estrut like '1211397%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 25 where c60_estrut like '1211399%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 25 where c60_estrut like '1211497%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 25 where c60_estrut like '1211499%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 25 where c60_estrut like '1211597%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 25 where c60_estrut like '1211599%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 16 where c60_estrut like '2114197%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 16 where c60_estrut like '1149105%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 16 where c60_estrut like '1149106%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 16 where c60_estrut like '1149107%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 16 where c60_estrut like '1149108%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 16 where c60_estrut like '1149109%'	and c60_anousu > 2021;
            update conplano set c60_nregobrig= 31 where c60_estrut like '6219%'	    and c60_anousu > 2021;
            commit;
SQL;
        $this->execute($sql);
    }
}
