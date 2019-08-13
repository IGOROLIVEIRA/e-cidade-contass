<?php

use Phinx\Migration\AbstractMigration;

class Oc10284 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();
        
        CREATE TEMP TABLE ementario_rec_2020
        (
        estrut varchar,
        fonte integer,
        descricao varchar,
        finalidade text
        );
        
        
        CREATE TEMP TABLE novas_receitas_2020 ON COMMIT DROP AS 
        SELECT * FROM conplanoorcamento
        JOIN orcfontes ON (o57_fonte, o57_anousu) = (c60_estrut, 2020)
        LEFT JOIN taborc ON (k02_estorc, k02_anousu) = (c60_estrut, c60_anousu)
        WHERE (substr(c60_estrut,1,1), c60_anousu) = ('4', 2020);
        
        
        INSERT INTO ementario_rec_2020 VALUES
        ('42418052',
        NULL,
        'Prog N Reest Aq Eq Rede Esc Publ Educ Inf-Proinfan',
        'Programa Nacional de Reestruturacao e Aquisicao de Equipamentos para a Rede Escolar Publica de Educacao Infantil - Proinfancia'),
        ('424180521',
        NULL,
        'Prog N Reest Aq Eq Rede Esc Publ Educ Inf-Proinfan',
        'Programa Nacional de Reestruturacao e Aquisicao de Equipamentos para a Rede Escolar Publica de Educacao Infantil - Proinfancia - Principal'),
        ('42418052101',
        146,
        'P.N.Reest Aq Eq.Rede Esc Publ Educ Inf-Proinf-F146',
        'Programa Nacional de Reestruturacao e Aquisicao de Equipamentos para a Rede Escolar Publica de Educacao Infantil - Proinfancia - Principal - Fonte 146'),
        ('42418059',
        NULL,
        'Outras transferencias destinadas a Progr. Educacao',
        'Outras transferencias destinadas a Programas de Educacao'),
        ('424180591',
        NULL,
        'Out transferencias dest. a Prog.Educacao-Principal',
        'Outras transferencias destinadas a Programas de Educacao - Principal'),
        ('42418059101',
        146,
        'Out transferencias dest. Prog.Educacao-Princ-F:146',
        'Outras transferencias destinadas a Programas de Educacao - Principal - Fonte 146'),
        ('42448019',
        NULL,
        'Outras Transferencias de Convenios Instit.Privadas',
        'Outras Transferencias de Convenios de Instituicoes Privadas'),
        ('424480191',
        NULL,
        'Outras Transf.de Convenios Inst.Privadas-Principal',
        'Outras Transferencias de Convenios de Instituicoes Privadas - Principal'),
        ('42448019101',
        124,
        'Out.Transf.Convenios Inst.Privadas-Principal-F:124',
        'Outras Transferencias de Convenios de Instituicoes Privadas - Principal - Fonte 124'),
        ('42448019102',
        142,
        'Out.Transf.Convenios Inst.Privadas-Principal-F:142',
        'Outras Transferencias de Convenios de Instituicoes Privadas - Principal - Fonte 142'),
        ('4112802',
        NULL,
        'Taxas de Inspecao, Controle e Fiscalizacao',
        'Taxas de Inspecao, Controle e Fiscalizacao'),
        ('41128023',
        NULL,
        'Taxa de Estudo de Impacto de Vizinhanca (EIV)',
        'Taxa de Estudo de Impacto de Vizinhanca (EIV)'),
        ('411280231',
        NULL,
        'Taxa de Estudo de Imp. Vizinhanca (EIV)- Principal',
        'Taxa de Estudo de Impacto de Vizinhanca (EIV)- Principal'),
        ('41128023101',
        100,
        'Taxa de Est.Impac.Vizinhanca (EIV)-Principal-F:100',
        'Taxa de Estudo de Impacto de Vizinhanca (EIV)- Principal - Fonte 100'),
        ('41128029',
        NULL,
        'Taxas pela Prestacao de Servicos - Outras',
        'Taxas pela Prestacao de Servicos - Outras'),
        ('411280291',
        NULL,
        'Taxas pela Prestacao de Servicos-Outras-Principal',
        'Taxas pela Prestacao de Servicos - Outras - Principal'),
        ('41128029101',
        100,
        'Taxas pela Prestac.Servicos-Outras-Principal-F:100',
        'Taxas pela Prestacao de Servicos - Outras - Principal - Fonte 100'),
        ('41718055',
        NULL,
        'Programa Nac.Inclusao de Jovens - Projovem Urbano',
        'Programa Nacional de Inclusao de Jovens - Projovem Urbano'),
        ('417180551',
        NULL,
        'Prog. Nac.Inclus.Jovens-Projovem Urbano-Principal',
        'Programa Nacional de Inclusao de Jovens - Projovem Urbano - Principal'),
        ('41718055101',
        146,
        'Prog. Nac.Inclus.Jovens-Projovem Urbano-Prin-F:146',
        'Programa Nacional de Inclusao de Jovens - Projovem Urbano - Principal - FONTE 146'),
        ('41718056',
        NULL,
        'Programa Nac de Inclusao de Jovens-Projovem Campo',
        'Programa Nacional de Inclusao de Jovens - Projovem Campo'),
        ('417180561',
        NULL,
        'Prog.Nac Inclusao Jovens-Projovem Campo-Principal',
        'Programa Nacional de Inclusao de Jovens - Projovem Campo - Principal'),
        ('41718056101',
        146,
        'Prog.Nac Inc Jovens-Projovem Campo-Principal-F:146',
        'Programa Nacional de Inclusao de Jovens - Projovem Campo - Principal - FONTE 146'),
        ('41718057',
        NULL,
        'Programa Brasil Alfabetizado - PBA',
        'Programa Brasil Alfabetizado - PBA'),
        ('417180571',
        NULL,
        'Programa Brasil Alfabetizado - PBA - Principal',
        'Programa Brasil Alfabetizado - PBA - Principal'),
        ('41718057101',
        146,
        'Programa Brasil Alfabetizado -PBA -Principal-F:146',
        'Programa Brasil Alfabetizado - PBA - Principal - Fonte 146'),
        ('41718058',
        NULL,
        'Prog.Apoio Sist.Ens.Atend.a Educ.Jov.Adultos-PEJA',
        'Programa de Apoio aos Sistemas de Ensino para Atendimento a Educacao de Jovens e Adultos - PEJA'),
        ('417180581',
        NULL,
        'Prog.Ap Sist.Ens.Atend Educ.Jov.Adultos-PEJA-Princ',
        'Programa de Apoio aos Sistemas de Ensino para Atendimento a Educacao de Jovens e Adultos - PEJA - Principal'),
        ('41718058101',
        146,
        'Prog.Ap Sist.Ens.Atend Educ.Jov.Adulto-PEJA- F:146',
        'Programa de Apoio aos Sistemas de Ensino para Atendimento a Educacao de Jovens e Adultos - PEJA - Principal - Fonte 146'),
        ('4171813',
        NULL,
        'Trans Decor.Decisao Judicial(precatorio)Rel.FUNDEF',
        'Transferencias Decorrentes de Decisao Judicial (precatorios) Relativas ao Fundo de Manutencao e Desenvolvimento do Ensino Fundamental e de Valorizacao do Magisterio - FUNDEF'),
        ('41718131',
        NULL,
        'Trans Decor.Decisao Judicial(precatorio)Rel.FUNDEF',
        'Transferencias Decorrentes de Decisao Judicial (precatorios) Relativas ao Fundo de Manutencao e Desenvolvimento do Ensino Fundamental e de Valorizacao do Magisterio - FUNDEF'),
        ('417181311',
        NULL,
        'Trans Dec.Dec Jud(precatorios)Rel.FUNDEF Principal',
        'Transferencias Decorrentes de Decisao Judicial (precatorios) Relativas ao Fundo de Manutencao e Desenvolvimento do Ensino Fundamental e de Valorizacao do Magisterio - FUNDEF - Principal'),
        ('41718131101',
        107,
        'Trans Dec.Dec Judicial(precatorio)Rel.FUNDEF-F:107',
        'Transferencias Decorrentes de Decisao Judicial (precatorios) Relativas ao Fundo de Manutencao e Desenvolvimento do Ensino Fundamental e de Valorizacao do Magisterio - FUNDEF - Principal - Fonte 107'),
        ('41748012',
        NULL,
        'Transf Convenios de Instit.Privadas Prog.Educacao',
        'Transferencias de Convenios de Instituicoes Privadas para Programas de Educacao'),
        ('417480121',
        NULL,
        'Transf Conv Instit.Privadas Prog.Educacao-Principal',
        'Transferencias de Convenios de Instituicoes Privadas para Programas de Educacao - Principal'),
        ('41748012101',
        122,
        'Transf Conve Inst.Priv.Prog.Educacao-Princip-F:122',
        'Transferencias de Convenios de Instituicoes Privadas para Programas de Educacao - Principal - Fonte 122'),
        ('41748019',
        NULL,
        'Outras Transf de Convenios Instituicoes Privadas',
        'Outras Transferencias de Convenios de Instituicoes Privadas'),
        ('417480191',
        NULL,
        'Out Transf de Convenios Instit.Privadas-Principal',
        'Outras Transferencias de Convenios de Instituicoes Privadas - Principal'),
        ('41748019101',
        124,
        'Out Transf de Convenios Instit.Privadas-Prin-F:124',
        'Outras Transferencias de Convenios de Instituicoes Privadas - Principal - Fonte 124'),
        ('41748019102',
        142,
        'Out Transf de Convenios Instit.Privadas-Prin-F:142',
        'Outras Transferencias de Convenios de Instituicoes Privadas - Principal - Fonte 142'),
        ('41768012',
        NULL,
        'Transf de Convenios do Exterior - Prog.de Educacao',
        'Transferencias de Convenios do Exterior - Programas de Educacao'),
        ('417680121',
        NULL,
        'Transf de Conv.Exterior-Prog.Educacao - Principal',
        'Transferencias de Convenios do Exterior - Programas de Educacao - Principal'),
        ('41768012101',
        122,
        'Transf Conv.Exterior-Prog.Educacao-Principal-F:122',
        'Transferencias de Convenios do Exterior - Programas de Educacao - Principal'),
        ('41778012',
        NULL,
        'Transf  Pessoas Fisicas-Espec.E/DF/M-Prog.Educacao',
        'Transferencias de Pessoas Fisicas - Específicas de E/DF/M - Programas de Educacao'),
        ('417780121',
        NULL,
        'Transf  Pess.Fisicas-Esp.E/DF/M-Prog.Educ-Principal',
        'Transferencias de Pessoas Fisicas - Específicas de E/DF/M - Programas de Educacao - Principal'),
        ('41778012101',
        100,
        'Transf  Pess.Fisicas-Espec.E/DF/M-Prog.Educ-F:100',
        'Transferencias de Pessoas Fisicas - Específicas de E/DF/M - Programas de Educacao - Principal - Fonte 100'),
        ('42448012',
        NULL,
        'Transf de Conv Instit Privada Dest a Prog Educacao',
        'Transferencias de Convenios de Instituicoes Privadas Destinados a Programas de Educacao'),
        ('424480121',
        NULL,
        'Transf de Conv Instit Priv Dest Prog Educ-Principal',
        'Transferencias de Convenios de Instituicoes Privadas Destinados a Programas de Educacao - Principal'),
        ('42448012101',
        122,
        'Transf de Conv Instit Priv Dest Prog Educaca- F:122',
        'Transferencias de Convenios de Instituicoes Privadas Destinados a Programas de Educacao - Principal - Fonte 122'),
        ('42468012',
        NULL,
        'Transferencias do Exterior p Programas de Educacao',
        'Transferencias do Exterior para Programas de Educacao'),
        ('424680121',
        NULL,
        'Transf do Exterior Programas de Educacao-Principal',
        'Transferencias do Exterior para Programas de Educacao - Principal'),
        ('42468012101',
        100,
        'Transf do Exterior Prog Educacao-Principal - F:100',
        'Transferencias do Exterior para Programas de Educacao - Principal - Fonte 100'),
        ('42478012',
        NULL,
        'Transferencias de Pessoas Fisicas p/ Prog Educacao',
        'Transferencias de Pessoas Fisicas para Programas de Educacao'),
        ('424780121',
        NULL,
        'Transf de Pessoas Fisicas Prog Educacao-Principal',
        'Transferencias de Pessoas Fisicas para Programas de Educacao - Principal'),
        ('42478012101',
        100,
        'Transf Pess. Fisicas Prog Educacao-Principal F:100',
        'Transferencias de Pessoas Fisicas para Programas de Educacao - Principal - Fonte 100'),
        ('42428991102',
        106,
        'Outras Transferencias dos Estados-Principal- F:106',
        'Outras Transferencias dos Estados - Principal - Fonte 106');
        
        
        INSERT INTO conplanoorcamentoanalitica
        SELECT c61_codcon,
               2020 AS c61_anousu,
               c61_reduz,
               c61_instit,
               c61_codigo
        FROM conplanoorcamentoanalitica
        WHERE c61_anousu = 2019
          AND c61_codcon IN
            (SELECT c60_codcon FROM conplanoorcamento
             WHERE c60_anousu = 2020)
          AND c61_codcon NOT IN
            (SELECT c61_codcon FROM conplanoorcamentoanalitica
             WHERE c61_anousu = 2020)
          AND c61_codcon NOT IN 
          (SELECT c60_codcon FROM conplanoorcamento
           WHERE (substr(c60_estrut,1,7) IN ('4171808', '4241808')
               OR 
               c60_estrut IN ('417681000000000', '417681011010000', '417781000000000', '424481011020000', '424481011030000', '424481011040000', '424180511020000', '417481011020000', 
                      '417481011030000', '417481011040000', '419280211030000', '419280211040000', '419280211050000', '424180511020000', '424481011020000', '424481011030000'))
           AND c60_anousu>= 2020);
        
        
        INSERT INTO conplanoorcamento
        SELECT nextval('conplanoorcamento_c60_codcon_seq') c60_codcon,
               2020 c60_anousu,
               substr(rpad(estrut, 15, '0'),1,15),
               substr(descricao,1,50),
               finalidade,
               1 c60_codsis,
               1 c60_codcla,
               0 c60_consistemaconta,
               'N' c60_identificadorfinanceiro,
               0 c60_naturezasaldo
        FROM ementario_rec_2020
        WHERE substr(rpad(estrut, 15, '0'),1,15) NOT IN 
         (SELECT c60_estrut FROM conplanoorcamento
           WHERE c60_anousu = 2020);
        
        
        INSERT INTO conplanoorcamentoanalitica
        SELECT c60_codcon,
               c60_anousu,
               nextval('conplanoorcamentoanalitica_c61_reduz_seq') c61_reduz,
              (SELECT codigo FROM db_config
               WHERE prefeitura = 't') c61_instit,
               fonte c61_codigo
        FROM ementario_rec_2020
        JOIN conplanoorcamento ON substr(rpad(estrut, 15, '0'),1,15) = c60_estrut
        WHERE fonte IS NOT NULL
          AND c60_codcon NOT IN 
          (SELECT c61_codcon FROM conplanoorcamentoanalitica
           WHERE c61_anousu = 2020);
        
        
        UPDATE conplanoorcamento
        SET c60_descr = (CASE
                             WHEN substr(c60_estrut,1,11) = '42418051000' THEN substr('Prog Apo Transp Escolar Educ Basica-CAMINHO ESCOLA',1,50)
                             WHEN substr(c60_estrut,1,11) = '42418051100' THEN substr('Prog Ap Transp Escolar Edu Basica-CAM.ESCOLA-Princ',1,50)
                             WHEN substr(c60_estrut,1,11) = '42418051101' THEN substr('Prog Ap Transp Escolar Edu Basica-CAM.ESCOLA-F:146',1,50)
                             WHEN substr(c60_estrut,1,11) = '42448100000' THEN substr('Outras Transferencias de Instituicoes Privadas',1,50)
                             WHEN substr(c60_estrut,1,11) = '42448101000' THEN substr('Outras Transferencias de Instituicoes Privadas',1,50)
                             WHEN substr(c60_estrut,1,11) = '42448101100' THEN substr('Outras Transferencias de Inst.Privadas - Principal',1,50)
                             WHEN substr(c60_estrut,1,11) = '42448101101' THEN substr('Outras Transf de Instit.Privadas -Principal- F:100',1,50)
                         END),
            c60_finali = (CASE
                              WHEN substr(c60_estrut,1,11) = '42418051000' THEN 'Programa de Apoio ao Transporte Escolar para Educacao Basica - CAMINHO DA ESCOLA'
                              WHEN substr(c60_estrut,1,11) = '42418051100' THEN 'Programa de Apoio ao Transporte Escolar para Educacao Basica - CAMINHO DA ESCOLA - Principal'
                              WHEN substr(c60_estrut,1,11) = '42418051101' THEN 'Programa de Apoio ao Transporte Escolar para Educacao Basica - CAMINHO DA ESCOLA - Principal - Fonte 146'
                              WHEN substr(c60_estrut,1,11) = '42448100000' THEN 'Outras Transferencias de Instituicoes Privadas'
                              WHEN substr(c60_estrut,1,11) = '42448101000' THEN 'Outras Transferencias de Instituicoes Privadas'
                              WHEN substr(c60_estrut,1,11) = '42448101100' THEN 'Outras Transferencias de Instituicoes Privadas - PRINCIPAL'
                              WHEN substr(c60_estrut,1,11) = '42448101101' THEN 'Outras Transferencias de Instituicoes Privadas - PRINCIPAL - FONTE 100'
                          END)
        WHERE substr(c60_estrut,1,11) IN ('42418051000', '42418051100', '42418051101', '42448100000', '42448101000', '42448101100', '42448101101')
          AND c60_anousu = 2020;
        
        
        UPDATE conplanoorcamentoanalitica
        SET c61_codigo = (CASE
                             WHEN substr(c60_estrut,1,11) = '42418051101' THEN 146
                             WHEN substr(c60_estrut,1,11) = '42448101101' THEN 100
                           ELSE t1.c61_codigo
                         END)
        FROM conplanoorcamentoanalitica t1
        JOIN conplanoorcamento ON (c60_codcon, c60_anousu) = (t1.c61_codcon, t1.c61_anousu)
        WHERE substr(c60_estrut,1,11) IN ('42418051000', '42418051100', '42418051101', '42448100000', '42448101000', '42448101100', '42448101101')
          AND c60_anousu = 2020
          AND (c60_codcon, c60_anousu) = (conplanoorcamentoanalitica.c61_codcon, conplanoorcamentoanalitica.c61_anousu);
        
        
        UPDATE conplanoorcamento
        SET c60_estrut = (CASE
                              WHEN substr(c60_estrut,1,11) = '41768101000' THEN '417680190000000'
                              WHEN substr(c60_estrut,1,11) = '41768101100' THEN '417680191000000'
                              WHEN substr(c60_estrut,1,11) = '41768101102' THEN '417680191010000'
                              WHEN substr(c60_estrut,1,11) = '41768101103' THEN '417680191020000'
                              WHEN substr(c60_estrut,1,11) = '41778101000' THEN '417780190000000'
                              WHEN substr(c60_estrut,1,11) = '41778101100' THEN '417780191000000'
                              WHEN substr(c60_estrut,1,11) = '41778101101' THEN '417780191010000'
                              WHEN substr(c60_estrut,1,11) = '42468101000' THEN '424680190000000'
                              WHEN substr(c60_estrut,1,11) = '42468101100' THEN '424680191000000'
                              WHEN substr(c60_estrut,1,11) = '42468101101' THEN '424680191010000'
                          END)
        WHERE substr(c60_estrut,1,11) IN ('41768101000', '41768101100', '41768101102', '41768101103', '41778101000', '41778101100', '41778101101', '42468101000', '42468101100', '42468101101')
          AND c60_anousu = 2020;
        
        
        UPDATE conplanoorcamentoanalitica
        SET c61_codigo = (CASE
                             WHEN c60_estrut = '417680191010000' THEN 124
                             WHEN c60_estrut = '417680191020000' THEN 142
                             WHEN c60_estrut = '417780191010000' THEN 100
                             WHEN c60_estrut = '424680191010000' THEN 100
                           ELSE t1.c61_codigo
                         END)
        FROM conplanoorcamentoanalitica t1
        JOIN conplanoorcamento ON (c60_codcon, c60_anousu) = (t1.c61_codcon, t1.c61_anousu)
        WHERE c60_estrut IN ('417680191010000', '417680191020000', '417780191010000', '424680191010000')
          AND c60_anousu = 2020
          AND (c60_codcon, c60_anousu) = (conplanoorcamentoanalitica.c61_codcon, conplanoorcamentoanalitica.c61_anousu);
        
        
        UPDATE conplanoorcamentoanalitica
        SET c61_codigo = (CASE
                             WHEN c60_estrut LIKE '41218%' AND t1.c61_codigo = 100 THEN 105
                             WHEN c60_estrut LIKE '47218%' AND t1.c61_codigo = 100 THEN 105
                             WHEN c60_estrut LIKE '413210041%' AND t1.c61_codigo = 100 THEN 105
                             WHEN c60_estrut LIKE '419900311%' AND t1.c61_codigo = 100 THEN 105
                             WHEN substr(c60_estrut,1,9) = '417289911' AND t1.c61_codigo = 156 THEN 106
                             WHEN substr(c60_estrut,1,11) = '41718022101' AND t1.c61_codigo = 100 THEN 108
                             WHEN substr(c60_estrut,1,11) = '41718031101' AND t1.c61_codigo = 148 THEN 159
                             WHEN substr(c60_estrut,1,11) = '41718032101' AND t1.c61_codigo = 149 THEN 159
                             WHEN substr(c60_estrut,1,11) = '41718033101' AND t1.c61_codigo = 150 THEN 159
                             WHEN substr(c60_estrut,1,11) = '41718034101' AND t1.c61_codigo = 151 THEN 159
                             WHEN substr(c60_estrut,1,11) = '41718035101' AND t1.c61_codigo = 152 THEN 159
                             WHEN substr(c60_estrut,1,11) = '41728022101' AND t1.c61_codigo = 100 THEN 108
                             WHEN substr(c60_estrut,1,11) = '41922031101' AND t1.c61_codigo = 100 THEN 105
                             WHEN substr(c60_estrut,1,11) = '41928021101' AND t1.c61_codigo = 148 THEN 153
                             WHEN substr(c60_estrut,1,11) = '41928021102' AND t1.c61_codigo = 149 THEN 159
                             WHEN substr(c60_estrut,1,11) = '41990011101' AND t1.c61_codigo = 100 THEN 105
                             WHEN substr(c60_estrut,1,11) = '42418031101' AND t1.c61_codigo = 148 THEN 159
                             WHEN substr(c60_estrut,1,11) = '42418032101' AND t1.c61_codigo = 149 THEN 159
                             WHEN substr(c60_estrut,1,11) = '42418033101' AND t1.c61_codigo = 150 THEN 159
                             WHEN substr(c60_estrut,1,11) = '42418034101' AND t1.c61_codigo = 151 THEN 159
                             WHEN substr(c60_estrut,1,11) = '42418035101' AND t1.c61_codigo = 152 THEN 159
                             WHEN substr(c60_estrut,1,11) = '42448101101' AND t1.c61_codigo = 122 THEN 100
                           ELSE t1.c61_codigo
                         END)
        FROM conplanoorcamentoanalitica t1
        JOIN conplanoorcamento ON (c60_codcon, c60_anousu) = (t1.c61_codcon, t1.c61_anousu)
        WHERE c60_anousu = 2020
          AND (c60_codcon, c60_anousu) = (conplanoorcamentoanalitica.c61_codcon, conplanoorcamentoanalitica.c61_anousu)
          AND (substr(c60_estrut,1,11) IN
              ('41718022101', '41718031101', '41718032101', '41718033101', '41718034101', '41718035101', '41728022101', '41728991101', '41922031101', 
               '41928021101', '41928021102', '41990011101', '42418031101', '42418032101', '42418033101', '42418034101', '42418035101', '42448101101')
               OR 
               substr(c60_estrut,1,9) IN ('413210041', '419900311')
               OR
               substr(c60_estrut,1,5) IN ('41218', '47218'));
        
        
        UPDATE conplanoorcamento
        SET c60_descr = (CASE
                              WHEN t1.c60_estrut LIKE '41218%' 
                                   AND c61_codigo = 100 
                                   AND t1.c60_descr ILIKE '%recursos ordinarios%' 
                                 THEN replace(t1.c60_descr,'Recursos Ordinarios', 'Taxa de Admin. RPPS')
                              WHEN t1.c60_estrut LIKE '47218%' 
                                   AND c61_codigo = 100 
                                   AND t1.c60_descr ILIKE '%recursos ordinarios%' 
                                 THEN replace(t1.c60_descr,'Recursos Ordinarios', 'Taxa de Admin. RPPS')
                              ELSE t1.c60_descr
                          END),
            c60_finali = (CASE
                              WHEN t1.c60_estrut LIKE '41218%' 
                                   AND c61_codigo = 100 
                                   AND t1.c60_finali ILIKE '%recursos ordinarios%' 
                                 THEN replace(t1.c60_finali,'Recursos Ordinarios', 'Taxa de Admin. RPPS')
                              WHEN t1.c60_estrut LIKE '47218%' 
                                   AND c61_codigo = 100 
                                   AND t1.c60_finali ILIKE '%recursos ordinarios%' 
                                 THEN replace(t1.c60_finali,'Recursos Ordinarios', 'Taxa de Admin. RPPS')
                              ELSE t1.c60_finali
                          END)
        FROM conplanoorcamento t1
        JOIN conplanoorcamentoanalitica ON (t1.c60_codcon, t1.c60_anousu) = (c61_codcon, c61_anousu)
        WHERE (conplanoorcamento.c60_codcon, conplanoorcamento.c60_anousu) = (c61_codcon, c61_anousu)
          AND conplanoorcamento.c60_anousu = 2020
          AND (substr(t1.c60_estrut,1,9) IN ('413210041', '419900311')
               OR
               substr(t1.c60_estrut,1,5) IN ('41218', '47218'));
        
        
        UPDATE taborc
        SET k02_estorc = conplanoorcamento.c60_estrut
        FROM taborc t1
        JOIN novas_receitas_2020 ON (novas_receitas_2020.k02_codigo, 2021, novas_receitas_2020.k02_estorc) = (t1.k02_codigo, t1.k02_anousu, t1.k02_estorc)
        JOIN conplanoorcamento ON (conplanoorcamento.c60_codcon, conplanoorcamento.c60_anousu) = (novas_receitas_2020.c60_codcon, novas_receitas_2020.c60_anousu)
        WHERE conplanoorcamento.c60_estrut != taborc.k02_estorc
          AND taborc.k02_anousu >= 2020;
        
        
        UPDATE orcfontes
        SET o57_fonte = conplanoorcamento.c60_estrut
        FROM orcfontes t1 
        JOIN novas_receitas_2020 ON (novas_receitas_2020.o57_codfon, 2021, novas_receitas_2020.o57_fonte) = (t1.o57_codfon, t1.o57_anousu, t1.o57_fonte)
        JOIN conplanoorcamento ON (conplanoorcamento.c60_codcon, conplanoorcamento.c60_anousu) = (novas_receitas_2020.c60_codcon, novas_receitas_2020.c60_anousu)
        WHERE conplanoorcamento.c60_estrut != orcfontes.o57_fonte
          AND orcfontes.o57_anousu = 2020;
        
        
        UPDATE conplanoorcamento
        SET c60_estrut = (CASE
                              WHEN t2.c60_estrut != t1.c60_estrut
                               AND t2.c60_codcon = t1.c60_codcon THEN t1.c60_estrut
                              ELSE t2.c60_estrut
                          END )
        FROM conplanoorcamento t1
        JOIN conplanoorcamento t2 ON (t1.c60_codcon, 2021) = (t2.c60_codcon, t2.c60_anousu)
        WHERE t1.c60_anousu = 2020
          AND conplanoorcamento.c60_codcon = t2.c60_codcon
          AND conplanoorcamento.c60_anousu = 2021
          AND conplanoorcamento.c60_estrut != t1.c60_estrut;
        
        
        UPDATE conplanoorcamentoanalitica
        SET c61_codigo = (CASE
                              WHEN t2.c61_codcon = t1.c61_codcon AND t2.c61_reduz = t1.c61_reduz
                               THEN t1.c61_codigo
                              ELSE t2.c61_codigo
                          END )
        FROM conplanoorcamentoanalitica t1
        JOIN conplanoorcamentoanalitica t2 ON (t1.c61_codcon, t1.c61_reduz, 2021) = (t2.c61_codcon, t2.c61_reduz, t2.c61_anousu)
        WHERE t1.c61_anousu = 2020
          AND (conplanoorcamentoanalitica.c61_codcon, conplanoorcamentoanalitica.c61_reduz) = (t2.c61_codcon, t2.c61_reduz)
          AND conplanoorcamentoanalitica.c61_anousu = 2021
          AND conplanoorcamentoanalitica.c61_codigo != t1.c61_codigo;
        
        
        INSERT INTO conplanoorcamentoanalitica
        SELECT c60_codcon,
               c60_anousu,
               nextval('conplanoorcamentoanalitica_c61_reduz_seq') c61_reduz,
               (SELECT codigo FROM db_config
                WHERE prefeitura = 't') c61_instit,
               CASE
                   WHEN substr(c60_estrut,1,11) = '41768019101' THEN 124
                   WHEN substr(c60_estrut,1,11) = '41768019102' THEN 142
                   WHEN substr(c60_estrut,1,11) = '41778019101' THEN 100
                   WHEN substr(c60_estrut,1,11) = '42468019101' THEN 100
                   ELSE NULL
               END c61_codigo
        FROM conplanoorcamento
        WHERE substr(c60_estrut, 1, 11) IN ('41768019101', '41768019102', '41778019101', '42468019101')
          AND c60_anousu = 2020
          AND (c60_codcon, c60_anousu) NOT IN 
          (SELECT c61_codcon, c61_anousu FROM conplanoorcamentoanalitica
           JOIN conplanoorcamento ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
           WHERE substr(c60_estrut, 1, 11) IN ('41768019101', '41768019102', '41778019101', '42468019101')
             AND c60_anousu = 2020);
        
        
        INSERT INTO conplanoorcamento
        SELECT c60_codcon,
               2021 c60_anousu,
               c60_estrut,
               c60_descr,
               c60_finali,
               c60_codsis,
               c60_codcla,
               c60_consistemaconta,
               c60_identificadorfinanceiro,
               c60_naturezasaldo,
               c60_funcao
        FROM conplanoorcamento
        WHERE (c60_estrut, c60_codcon) NOT IN
          (SELECT c60_estrut, c60_codcon FROM conplanoorcamento
           WHERE c60_anousu = 2021)
          AND c60_anousu = 2020;
        
        
        INSERT INTO conplanoorcamentoanalitica
        SELECT c61_codcon,
               2021 c61_anousu,
               c61_reduz,
               c61_instit,
               c61_codigo,
               c61_contrapartida
        FROM conplanoorcamentoanalitica
        JOIN conplanoorcamento ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
        WHERE (c61_codcon, c61_reduz) NOT IN 
        (SELECT c61_codcon, c61_reduz FROM conplanoorcamentoanalitica
         WHERE c61_anousu = 2021)
          AND c60_estrut IN (SELECT c60_estrut FROM conplanoorcamento WHERE c60_anousu = 2021)
          AND c61_anousu = 2020;
        
        
        DELETE FROM conplanoorcamentoanalitica
        USING conplanoorcamento
        WHERE substr(c60_estrut,1,7) IN ('4171808', '4241808')
        AND (c61_codcon, c61_anousu) = (c60_codcon, c60_anousu)
        AND c61_anousu >= 2020;
        
        
        DELETE FROM conplanoorcamentoanalitica
        USING conplanoorcamento
        WHERE c60_estrut IN ('417681000000000', '417681011010000', '417781000000000', '424481011020000', '424481011030000', '424481011040000', '424180511020000', '417481011020000', 
                             '417481011030000', '417481011040000', '419280211030000', '419280211040000', '419280211050000', '424180511020000', '424481011020000', '424481011030000')
        AND (c61_codcon, c61_anousu) = (c60_codcon, c60_anousu)
        AND c61_anousu >= 2020;
        
        
        UPDATE conplanoorcamento
        SET c60_descr = 'DESATIVADA 2020',
            c60_finali = 'DESATIVADA 2020',
            c60_codsis = 0,
            c60_codcla = 4
        WHERE (substr(c60_estrut,1,7) IN ('4171808', '4241808')
               OR 
               c60_estrut IN ('417681000000000', '417681011010000', '417781000000000', '424481011020000', '424481011030000', '424481011040000', '424180511020000', '417481011020000', 
                              '417481011030000', '417481011040000', '419280211030000', '419280211040000', '419280211050000', '424180511020000', '424481011020000', '424481011030000'))
        AND c60_anousu>= 2020;
        
        
        DELETE FROM conplanoconplanoorcamento
        USING conplanoorcamento
        WHERE (substr(c60_estrut,1,7) IN ('4171808', '4241808')
               OR 
               c60_estrut IN ('417681000000000', '417681011010000', '417781000000000', '424481011020000', '424481011030000', '424481011040000', '424180511020000', '417481011020000', 
                              '417481011030000', '417481011040000', '419280211030000', '419280211040000', '419280211050000', '424180511020000', '424481011020000', '424481011030000'))
        AND (c72_conplanoorcamento, c72_anousu) = (c60_codcon, c60_anousu)
        AND c72_anousu >= 2020;
        
        
        INSERT INTO orcfontes
        SELECT c60_codcon o57_codfon,
               c60_anousu o57_anousu,
               c60_estrut o57_fonte,
               c60_descr o57_descr,
               c60_finali o57_finali
        FROM conplanoorcamento
        JOIN ementario_rec_2020 ON substr(rpad(estrut, 15, '0'),1,15) = c60_estrut
        WHERE c60_anousu = 2020
        AND (c60_codcon, c60_estrut) NOT IN 
        (SELECT o57_codfon, o57_fonte FROM orcfontes
         WHERE o57_anousu = 2020);
        
        
        INSERT INTO orcfontes
        SELECT c60_codcon o57_codfon,
               2021 o57_anousu,
               c60_estrut o57_fonte,
               c60_descr o57_descr,
               c60_finali o57_finali
        FROM conplanoorcamento
        JOIN ementario_rec_2020 ON substr(rpad(estrut, 15, '0'),1,15) = c60_estrut
        WHERE c60_anousu = 2020
        AND (c60_codcon, c60_estrut) NOT IN 
        (SELECT o57_codfon, o57_fonte FROM orcfontes
         WHERE o57_anousu = 2021);
        
        
        DROP TABLE ementario_rec_2020;
        
        
        COMMIT;  

SQL;

        $this->execute($sql);

    }
}
