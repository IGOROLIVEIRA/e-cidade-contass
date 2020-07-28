<?php

use Phinx\Migration\AbstractMigration;

class Oc11626 extends AbstractMigration
{
   
    public function change()
    {
        $sql = "

        
insert
    into
    orcparamseq( o69_codparamrel , o69_codseq , o69_descr , o69_grupo , o69_grupoexclusao , o69_nivel , o69_libnivel , o69_librec , o69_libsubfunc , o69_libfunc , o69_verificaano , o69_labelrel , o69_manual , o69_totalizador , o69_ordem , o69_nivellinha , o69_observacao , o69_desdobrarlinha , o69_origem )
values ( 166 , 15 , 'TRANSFERÊNCIAS OBRIGATÓRIAS EMENDAS INDIVIDUAIS' , 4 , 1 , 0 , 'f' , 'f' , 'f' , 'f' , 'f' , 'TRANSFERÊNCIAS OBRIGATÓRIAS EMENDAS INDIVIDUAIS' , 't' , 'f' , 15 , 0 , '' , 'f' , 0 );

insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,12 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,13 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,14 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,15 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,16 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,17 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,18 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,19 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,20 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,21 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,22 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,23 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,24 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,25 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,26 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,27 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,15 ,166 ,103 ,1 ,28 ,'' );


insert
    into
    orcparamseq( o69_codparamrel , o69_codseq , o69_descr , o69_grupo , o69_grupoexclusao , o69_nivel , o69_libnivel , o69_librec , o69_libsubfunc , o69_libfunc , o69_verificaano , o69_labelrel , o69_manual , o69_totalizador , o69_ordem , o69_nivellinha , o69_observacao , o69_desdobrarlinha , o69_origem )
values ( 166 , 16 , 'TRANSFERÊNCIAS OBRIGATÓRIAS EMENDAS DE BANCADA' , 4 , 1 , 0 , 'f' , 'f' , 'f' , 'f' , 'f' , 'TRANSFERÊNCIAS OBRIGATÓRIAS EMENDAS DE BANCADA' , 't' , 'f' , 16 , 0 , '' , 'f' , 0 );

insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,12 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,13 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,14 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,15 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,16 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,17 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,18 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,19 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,20 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,21 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,22 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,23 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,24 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,25 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,26 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,27 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna) ,16 ,166 ,103 ,1 ,28 ,'' );

        ";

        $this->execute($sql);
    }
}
