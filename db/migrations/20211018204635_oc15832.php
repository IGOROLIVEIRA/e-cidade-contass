<?php

use Phinx\Migration\AbstractMigration;

class Oc15832 extends AbstractMigration
{
    public function up()
    {
        $estrut = array('conta1'=> [
                                'estrut' => '417390000000000',
                                'descr' => 'OUTRAS TRANSFERENCIAS DOS MUNICIPIOS'
                            ],
                        'conta2'=> [
                                'estrut' => '417395000000000',
                                'descr' => 'TRANSFERENCIAS DE MUNICIPIOS A CONSORCIOS PUBLICOS'
                            ],
                        'conta3'=> [
                                'estrut' => '417395001000000',
                                'descr' => 'TRANSFERENCIAS DE MUNICIPIOS A CONSORCIOS PUBLICOS'
                            ]
        );

        foreach ($estrut as $conta => $dados){

            $this->insertOrcamento($dados['estrut'], $dados['descr']);
        }
    }

    private function insertOrcamento($estrutural, $descr)
    {
        $anos = array(2022, 2023, 2024, 2025);

        foreach ($anos as $exercicio){

            $sqlVerify = "SELECT 1 FROM conplanoorcamento WHERE (c60_anousu, c60_estrut) = ({$exercicio}, '{$estrutural}')";

            $result1 = $this->fetchAll($sqlVerify);

            if (empty($result1)) {

                $sqlInsert = " INSERT INTO conplanoorcamento
                               SELECT nextval('conplanoorcamento_c60_codcon_seq') AS c60_codcon,
                                      {$exercicio} AS c60_anousu,
                                      '{$estrutural}' AS c60_estrut,
                                      '{$descr}' AS c60_descr,
                                      '{$descr}' AS c60_finali,
                                      1 AS c60_codsis,
                                      1 AS c60_codcla,
                                      0 AS c60_consistemaconta,
                                      'N' AS c60_identificadorfinanceiro,
                                      2 AS c60_naturezasaldo";

                $this->execute($sqlInsert);
            }
        }
        $this->updateFonte();
    }

    private function updateFonte()
    {
        $sqlUpdate = " UPDATE conplanoorcamentoanalitica t1
                       SET c61_codigo = t2.c61_codigo
                       FROM conplanoorcamento
                       JOIN conplanoorcamentoanalitica t2 ON t2.c61_anousu = 2021
                       WHERE t1.c61_anousu = 2022
                         AND (c60_codcon, c60_anousu) = (t1.c61_codcon, t1.c61_anousu)
                         AND (t1.c61_codcon, t1.c61_reduz) = (t2.c61_codcon, t2.c61_reduz)
                         AND t1.c61_codigo != t2.c61_codigo
                         AND c60_estrut LIKE '417395001%'";

        $this->execute($sqlUpdate);
    }
}
