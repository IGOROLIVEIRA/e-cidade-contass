<?php

use Phinx\Migration\AbstractMigration;

class Oc15808 extends AbstractMigration
{
    public function up()
    {
        $this->execute("DELETE FROM conplanoorcamentoanalitica 
                        WHERE c61_anousu >2021
                          AND c61_codcon IN
                          (SELECT c60_codcon FROM conplanoorcamento
                           WHERE c60_estrut LIKE '333900800%'
                             AND c60_anousu = c61_anousu)");

        $despesas = array(
                        array(
                            'estrut' => '333900801000000',
                            'descr' => 'Auxilio-Funeral'
                        ),
                        array(
                            'estrut' => '333900805000000',
                            'descr' => 'Auxilio Natalidade'
                        ),
                        array(
                            'estrut' => '333900809000000',
                            'descr' => 'Auxilio Creche'
                        ),
                        array(
                            'estrut' => '333900811000000',
                            'descr' => 'Auxilio-Saude'
                        ),
                        array(
                            'estrut' => '333900814000000',
                            'descr' => 'Auxilio Deficiente'
                        ),
                        array(
                            'estrut' => '333900815000000',
                            'descr' => 'Auxilio Escola'
                        ),
                        array(
                            'estrut' => '333900846000000',
                            'descr' => 'Auxilio Odontologico'
                        ),
                        array(
                            'estrut' => '333900847000000',
                            'descr' => 'Auxilio Oftalmologico'
                        ),
                        array(
                            'estrut' => '333900848000000',
                            'descr' => 'Auxilio Medicamento'
                        ),
                        array(
                            'estrut' => '333900853000000',
                            'descr' => 'Auxilio-Reclusao'
                        ),
                        array(
                            'estrut' => '333900856000000',
                            'descr' => 'Salario Familia'
                        ),
                        array(
                            'estrut' => '333900899000000',
                            'descr' => 'Outros Beneficios Assistenciais'
                        ),
                        array(
                            'estrut' => '331969498000000',
                            'descr' => 'Indenizacoes por Demissao e com PIDV - Trab. Ativo'
                        ),
                        array(
                            'estrut' => '331969499000000',
                            'descr' => 'Outras Indenizacoes e Restituicoes Trabalhistas'
                        ),
                        array(
                            'estrut' => '333508500000000',
                            'descr' => 'Contrato de Gestao'
                        )
        );

        foreach ($despesas as $dados) {

            $this->insertCtaSintetica($dados['estrut'], $dados['descr']);
        }
    }

    private function insertCtaSintetica($estrutural, $descr)
    {

        $sqlTempTable = "SELECT * FROM pg_catalog.pg_tables 
                         WHERE tablename = 'anousu'";

        $tempTable = $this->fetchAll($sqlTempTable);

        if (empty($tempTable)) {
            
            $sqlAno = "CREATE TEMP TABLE anousu ON COMMIT DROP AS 
                       SELECT DISTINCT c91_anousudestino FROM conaberturaexe 
                       WHERE c91_anousuorigem = 2021
                         AND c91_instit IN (SELECT codigo FROM db_config ORDER BY 1)";
            $this->execute($sqlAno);
        }

        $sqlVerify = "SELECT 1 FROM conplanoorcamento WHERE c60_estrut = '{$estrutural}' AND c60_anousu >= 2022";
        $verificaConta = $this->fetchAll($sqlVerify);

        if (substr($estrutural, 0, 4) == '3335') {

            $sqlPcasp = "SELECT c60_codcon FROM conplano
                         JOIN conplanoreduz ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
                         WHERE c60_anousu = 2022
                           AND c61_instit IN (SELECT codigo FROM db_config ORDER BY 1)
                           AND substr(c60_estrut,1,7) = '3531199'";

            $existPcasp = $this->fetchAll($sqlPcasp);

            if (empty($existPcasp)) {

                $this->insertPcasp();
            }
        }

        if (empty($verificaConta)) {

            $sqlInsert = " CREATE TEMP TABLE newconta ON COMMIT DROP AS
                           SELECT nextval('conplanoorcamento_c60_codcon_seq') AS c60_codcon,
                                  2022 AS c60_anousu,
                                  '{$estrutural}'::varchar AS c60_estrut,
                                  '{$descr}'::varchar AS c60_descr,
                                  '{$descr}'::text AS c60_finali,
                                  1 AS c60_codsis,
                                  1 AS c60_codcla,
                                  0 AS c60_consistemaconta,
                                  'N'::varchar AS c60_identificadorfinanceiro,
                                  2 AS c60_naturezasaldo;
                            
                           INSERT INTO conplanoorcamento
                           SELECT * FROM newconta
                           WHERE c60_estrut NOT IN (SELECT c60_estrut FROM conplanoorcamento WHERE c60_anousu = 2022);
                           
                           DROP TABLE newconta";

            $this->execute($sqlInsert);

            $sqlInsertExercicios = "INSERT INTO conplanoorcamento
                                    SELECT c60_codcon,
                                           c91_anousudestino AS c60_anousu,
                                           c60_estrut,
                                           c60_descr,
                                           c60_finali,
                                           c60_codsis,
                                           c60_codcla,
                                           c60_consistemaconta,
                                           c60_identificadorfinanceiro,
                                           c60_naturezasaldo
                                    FROM conplanoorcamento
                                    JOIN anousu ON c91_anousudestino > 2022
                                    WHERE c60_anousu = 2022
                                      AND c60_estrut = '{$estrutural}'
                                      AND c60_estrut NOT IN (SELECT c60_estrut FROM conplanoorcamento WHERE c60_anousu = c91_anousudestino);
                                      
                                    DROP TABLE anousu;";

            $this->execute($sqlInsertExercicios);
        }
        
        $sqlVerifyCta = "SELECT 1 FROM conplanoorcamento 
                         JOIN conplanoorcamentoanalitica ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
                         WHERE c60_estrut = '{$estrutural}'
                           AND c61_instit IN (SELECT codigo FROM db_config ORDER BY 1)
                           AND c60_anousu >= 2022";
        $verificaCtaAnalitica = $this->fetchAll($sqlVerifyCta);

        if (empty($verificaCtaAnalitica)) {


            $sqlInsertAnalitica = " INSERT INTO conplanoorcamentoanalitica
                                    SELECT c60_codcon,
                                            c60_anousu,
                                            nextval('conplanoorcamentoanalitica_c61_reduz_seq'), 
                                            db_config.codigo,
                                            100,
                                            0
                                    FROM conplanoorcamento
                                    JOIN db_config ON 1 = 1
                                    WHERE c60_estrut = '{$estrutural}'
                                      AND c60_anousu = 2022
                                      AND c60_codcon NOT IN (SELECT c61_codcon FROM conplanoorcamentoanalitica WHERE c61_anousu = c60_anousu)
                                    ORDER BY db_config.codigo";

            $this->execute($sqlInsertAnalitica);

            $sqlInsertAnaliticaAnousu = "INSERT INTO conplanoorcamentoanalitica
                                         SELECT c61_codcon,
                                             c60_anousu AS c61_anousu,
                                             c61_reduz,
                                             c61_instit,
                                             c61_codigo
                                         FROM conplanoorcamento
                                         JOIN conplanoorcamentoanalitica ON c60_codcon = c61_codcon
                                         WHERE c60_estrut = '{$estrutural}'
                                           AND c60_anousu > 2022
                                           AND c60_codcon NOT IN (SELECT c61_codcon FROM conplanoorcamentoanalitica WHERE c61_anousu = c60_anousu)";

            $this->execute($sqlInsertAnaliticaAnousu);
        }

        $sqlVinculo = "INSERT INTO conplanoconplanoorcamento
                       SELECT nextval('conplanoconplanoorcamento_c72_sequencial_seq'),
                           CASE
                               WHEN substr(c60_estrut,1,7) = '3335085' THEN (SELECT c60_codcon FROM conplano
                                                                             WHERE c60_anousu = t1.c60_anousu
                                                                               AND c60_estrut = '353119900000000'
                                                                             LIMIT 1)
                               WHEN substr(c60_estrut,1,7) = '3319694' THEN (SELECT c60_codcon FROM conplano
                                                                             WHERE c60_anousu = t1.c60_anousu
                                                                               AND substr(c60_estrut,1,9) = '311210299'
                                                                             LIMIT 1)
                               WHEN substr(c60_estrut,1,7) = '3339008' THEN (SELECT c60_codcon FROM conplano
                                                                             WHERE c60_anousu = t1.c60_anousu
                                                                               AND substr(c60_estrut,1,5) = '32391'
                                                                             LIMIT 1)
                               ELSE NULL
                           END AS c60_codcon,
                           c60_codcon,
                           c60_anousu
                       FROM conplanoorcamento t1
                       WHERE c60_anousu >= 2022
                         AND substr(c60_estrut,1,7) IN ('3335085', '3319694', '3339008')
                         AND c60_codcon NOT IN (SELECT c72_conplanoorcamento FROM conplanoconplanoorcamento WHERE c72_anousu = c60_anousu)";

        $this->execute($sqlVinculo);
    }



    private function insertPcasp()
    {
        $sqlVerificaSintetica = "SELECT c60_codcon FROM conplano
                                 WHERE c60_anousu >= 2022
                                   AND substr(c60_estrut,1,7) = '3531199'";

        $existSintetica = $this->fetchAll($sqlVerificaSintetica);

        if (empty($existSintetica)) {

            $sqlInsertPcasp = "CREATE TEMP TABLE newpcasp ON COMMIT DROP AS
                               SELECT nextval('conplano_c60_codcon_seq'),
                                      2022,
                                      '353119900000000'::varchar AS c60_estrut,
                                      'OUTRAS TRANSFERENCIAS A INSTITUICOES PRIVADAS SEM'::varchar AS c60_descr,
                                      'Registra o valor utilizado para transferencias a instituicoes privadas sem fins lucrativos, nao classificadas em itens anteriores.'::text AS c60_finali,
                                      2 AS c60_codsis,
                                      1 AS c60_codcla,
                                      2 AS c60_consistemaconta,
                                      'F'::varchar AS c60_identificadorfinanceiro,
                                      1 AS c60_naturezasaldo,
                                      1 AS c60_infcompmsc;
                                      
                               INSERT INTO conplano
                               SELECT * FROM newpcasp
                               WHERE c60_estrut NOT IN (SELECT c60_estrut FROM conplano WHERE c60_anousu = 2022)";

            $this->execute($sqlInsertPcasp);

            $this->execute("INSERT INTO conplano
                            SELECT c60_codcon,
                                   c91_anousudestino AS c60_anousu,
                                   c60_estrut,
                                   c60_descr,
                                   c60_finali,
                                   c60_codsis,
                                   c60_codcla,
                                   c60_consistemaconta,
                                   c60_identificadorfinanceiro,
                                   c60_naturezasaldo,
                                   c60_infcompmsc
                            FROM conplano
                            JOIN anousu ON c91_anousudestino > 2022
                            WHERE c60_estrut = '353119900000000'
                              AND c60_anousu = 2022
                              AND c60_estrut NOT IN (SELECT c60_estrut FROM conplano WHERE c60_anousu = c91_anousudestino)");
        } else {

            $sqlVerificaAnalitica = "SELECT c60_codcon FROM conplano
                                     JOIN conplanoreduz ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
                                     WHERE c60_anousu >= 2022
                                       AND c61_instit IN (SELECT codigo FROM db_config)
                                       AND substr(c60_estrut,1,7) = '3531199'";
            $existAnalitica = $this->fetchAll($sqlVerificaAnalitica);

            if (empty($existAnalitica)) {

                $sqlInsert = "INSERT INTO conplanoreduz
                              SELECT c60_codcon,
                                     c60_anousu,
                                     nextval('conplanoreduz_c61_reduz_seq')::integer, 
                                     db_config.codigo::integer,
                                     100::integer,
                                     0::integer
                              FROM conplano
                              JOIN db_config ON 1 = 1
                              WHERE c60_estrut = '353119900000000'
                                AND c60_anousu = 2022";

                $this->execute($sqlInsert);

                $this->execute("INSERT INTO conplanoreduz
                                 SELECT c60_codcon AS c61_codcon,
                                        c60_anousu AS c61_anousu,
                                        c61_reduz,
                                        c61_instit,
                                        c61_codigo
                                 FROM conplano
                                 JOIN conplanoreduz ON c60_codcon = c61_codcon
                                 WHERE c60_estrut = '353119900000000'
                                   AND c60_anousu > 2022");
            }
        }
    }
}