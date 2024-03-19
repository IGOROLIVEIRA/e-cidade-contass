<?php

use Phinx\Migration\AbstractMigration;

class Oc22007 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_11', 'Desp_Rec_Agentes_Administ', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_12', 'Desp_Rec_Agentes_Aten_Basica', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_13', 'Desp_Rec_Agentes_Assis_Hosp', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_14', 'Desp_Rec_Agentes_Supor_Prof', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_15', 'Desp_Rec_Agentes_Vigil_Sanit', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_16', 'Desp_Rec_Agentes_Vigil_Epid', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_17', 'Desp_Rec_Agentes_Aliment', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_18', 'Desp_Rec_Agentes_Inf_Compl', 2023);

        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_11', 'Desp_Rec_Enferm_Administ', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_12', 'Desp_Rec_Enferm_Aten_Basica', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_13', 'Desp_Rec_Enferm_Assis_Hosp', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_14', 'Desp_Rec_Enferm_Supor_Prof', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_15', 'Desp_Rec_Enferm_Vigil_Sanit', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_16', 'Desp_Rec_Enferm_Vigil_Epid', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_17', 'Desp_Rec_Enferm_Aliment', 2023);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_18', 'Desp_Rec_Enferm_Inf_Compl', 2023);

        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_11', 'Desp_Rec_Agentes_Administ', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_12', 'Desp_Rec_Agentes_Aten_Basica', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_13', 'Desp_Rec_Agentes_Assis_Hosp', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_14', 'Desp_Rec_Agentes_Supor_Prof', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_15', 'Desp_Rec_Agentes_Vigil_Sanit', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_16', 'Desp_Rec_Agentes_Vigil_Epid', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_17', 'Desp_Rec_Agentes_Aliment', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('94_18', 'Desp_Rec_Agentes_Inf_Compl', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_11', 'Desp_Rec_Enferm_Administ', 2024);

        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_12', 'Desp_Rec_Enferm_Aten_Basica', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_13', 'Desp_Rec_Enferm_Assis_Hosp', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_14', 'Desp_Rec_Enferm_Supor_Prof', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_15', 'Desp_Rec_Enferm_Vigil_Sanit', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_16', 'Desp_Rec_Enferm_Vigil_Epid', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_17', 'Desp_Rec_Enferm_Aliment', 2024);
        INSERT INTO public.nomearqdessiops
        (c228_codplanilha, c228_nomearquivo, c228_anousu)
        VALUES('95_18', 'Desp_Rec_Enferm_Inf_Compl', 2024);
        
        COMMIT;

SQL;
        $this->execute($sql);
    }
}