<?php

use Phinx\Migration\AbstractMigration;

class Oc15929 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO nomearqdessiops VALUES
        ('86_11', 'Desp_Rec_Sus_Federal_Custeio_Administ', '2021'),
        ('86_12', 'Desp_Rec_Sus_Federal_Custeio_Aten_Basica', '2021'),
        ('86_13', 'Desp_Rec_Sus_Federal_Custeio_Assis_Hosp', '2021'),
        ('86_14', 'Desp_Rec_Sus_Federal_Custeio_Supor_Prof', '2021'),
        ('86_15', 'Desp_Rec_Sus_Federal_Custeio_Vigil_Sanit', '2021'),
        ('86_16', 'Desp_Rec_Sus_Federal_Custeio_Vigil_Epid', '2021'),
        ('86_17', 'Desp_Rec_Sus_Federal_Custeio_Alim_Nutr', '2021'),
        ('86_18', 'Desp_Rec_Sus_Federal_Custeio_Inf_Compl', '2021'),
        ('87_11', 'Desp_Rec_Sus_Federal_Custeio_Covid19_Administ', '2021'),
        ('87_12', 'Desp_Rec_Sus_Federal_Custeio_Covid19_Aten_Basica', '2021'),
        ('87_13', 'Desp_Rec_Sus_Federal_Custeio_Covid19_Assis_Hosp', '2021'),
        ('87_14', 'Desp_Rec_Sus_Federal_Custeio_Covid19_Supor_Prof', '2021'),
        ('87_15', 'Desp_Rec_Sus_Federal_Custeio_Covid19_Vigil_Sanit', '2021'),
        ('87_16', 'Desp_Rec_Sus_Federal_Custeio_Covid19_Vigil_Epid', '2021'),
        ('87_17', 'Desp_Rec_Sus_Federal_Custeio_Covid19_Alim_Nutr', '2021'),
        ('87_18', 'Desp_Rec_Sus_Federal_Custeio_Covid19_Inf_Compl', '2021'),
        ('88_11', 'Desp_Rec_Sus_Federal_Invest_Administ', '2021'),
        ('88_12', 'Desp_Rec_Sus_Federal_Invest_Aten_Basica', '2021'),
        ('88_13', 'Desp_Rec_Sus_Federal_Invest_Assis_Hosp', '2021'),
        ('88_14', 'Desp_Rec_Sus_Federal_Invest_Supor_Prof', '2021'),
        ('88_15', 'Desp_Rec_Sus_Federal_Invest_Vigil_Sanit', '2021'),
        ('88_16', 'Desp_Rec_Sus_Federal_Invest_Vigil_Epid', '2021'),
        ('88_17', 'Desp_Rec_Sus_Federal_Invest_Alim_Nutr', '2021'),
        ('88_18', 'Desp_Rec_Sus_Federal_Invest_Inf_Compl', '2021'),
        ('89_11', 'Desp_Rec_Sus_Federal_Invest_Covid19_Administ', '2021'),
        ('89_12', 'Desp_Rec_Sus_Federal_Invest_Covid19_Aten_Basica', '2021'),
        ('89_13', 'Desp_Rec_Sus_Federal_Invest_Covid19_Assis_Hosp', '2021'),
        ('89_14', 'Desp_Rec_Sus_Federal_Invest_Covid19_Supor_Prof', '2021'),
        ('89_15', 'Desp_Rec_Sus_Federal_Invest_Covid19_Vigil_Sanit', '2021'),
        ('89_16', 'Desp_Rec_Sus_Federal_Invest_Covid19_Vigil_Epid', '2021'),
        ('89_17', 'Desp_Rec_Sus_Federal_Invest_Covid19_Alim_Nutr', '2021'),
        ('89_18', 'Desp_Rec_Sus_Federal_Invest_Covid19_Inf_Compl', '2021'),
        ('90_11', 'Desp_Rec_Transf_União_lei 173-2020_Administ', '2021'),
        ('90_12', 'Desp_Rec_Transf_União_lei 173-2020_Aten_Basica', '2021'),
        ('90_13', 'Desp_Rec_Transf_União_lei 173-2020_Assis_Hosp', '2021'),
        ('90_14', 'Desp_Rec_Transf_União_lei 173-2020_Supor_Prof', '2021'),
        ('90_15', 'Desp_Rec_Transf_União_lei 173-2020_Vigil_Sanit', '2021'),
        ('90_16', 'Desp_Rec_Transf_União_lei 173-2020_Vigil_Epid', '2021'),
        ('90_17', 'Desp_Rec_Transf_União_lei 173-2020_Alim_Nutr', '2021'),
        ('90_18', 'Desp_Rec_Transf_União_lei 173-2020_Inf_Compl', '2021');

        COMMIT;

SQL;
        $this->execute($sql);
    }
}
