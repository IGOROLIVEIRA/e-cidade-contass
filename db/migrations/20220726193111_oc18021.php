<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc18021 extends PostgresMigration
{
    public function up()
    {
        $jsonDados = file_get_contents('db/migrations/20220726193020_oc18021.json');
        $aDados = json_decode($jsonDados);

        $clientInstit = $this->fetchAll("SELECT codigo FROM db_config");

        foreach ($aDados->fontes as $fonte) :

            $fonte2022 = $fonte->FONTE_2022;
            $fonte2023 = $fonte->FONTE_2023;

            foreach ($clientInstit as $instit) {

                $instituicao = $this->getInstituicao($instit);

                $aAbertura = $this->fetchAll("SELECT c91_anousudestino FROM conaberturaexe WHERE c91_instit = {$instituicao} AND c91_anousudestino > 2022");

                foreach ($aAbertura as $exercicio) {

                    $anousudestino = $this->getExercicio($exercicio);

                    if ($fonte2022) {

                        $aReduzidosOrc = $this->fetchAll("SELECT c61_reduz AS reduz_orc FROM conplanoorcamentoanalitica 
                                                          WHERE (c61_anousu, c61_codigo, c61_instit) = ({$anousudestino}, {$fonte2022}, {$instituicao})");

                        $aReduzidosPcasp = $this->fetchAll("SELECT c61_reduz AS reduz_pcasp FROM conplanoreduz
                                                            WHERE (c61_anousu, c61_codigo, c61_instit) = ({$anousudestino}, {$fonte2022}, {$instituicao})");

                        $this->updateFontes($aReduzidosOrc, $fonte2022, $fonte2023, $anousudestino);
                        $this->updateFontes($aReduzidosPcasp, $fonte2022, $fonte2023, $anousudestino);
                    } else {
                        
                        $fonte2023 = 15000000;

                        $this->updateOutrasFontes($fonte2023, $anousudestino);
                    }
                }
            }
        endforeach;
    }

    public function getInstituicao(array $instit)
    {
        foreach ($instit as $instituicao) {
            return $instituicao;
        }
    }

    public function getExercicio(array $exercicio)
    {
        foreach ($exercicio as $anousudestino) {
            return $anousudestino;
        }
    }

    public function updateFontes($reduzidos, $fonte22, $fonte23, $anousu)
    {
        foreach ($reduzidos as $reduz) {

            if (isset($reduz['reduz_orc'])) {

                $this->execute("UPDATE conplanoorcamentoanalitica
                                SET c61_codigo = $fonte23
                                WHERE (c61_reduz, c61_codigo, c61_anousu) = ({$reduz['reduz_orc']}, $fonte22, $anousu)");

            } elseif (isset($reduz['reduz_pcasp'])) {
                
                $this->execute("UPDATE conplanoreduz
                                SET c61_codigo = $fonte23
                                WHERE (c61_reduz, c61_codigo, c61_anousu) = ({$reduz['reduz_pcasp']}, $fonte22, $anousu)");
            }

        }
    }

    public function updateOutrasFontes($fonte23, $anousu)
    {
        $this->execute("UPDATE conplanoorcamentoanalitica
                        SET c61_codigo = $fonte23
                        WHERE c61_anousu = $anousu
                          AND LENGTH(c61_codigo::varchar) < 5");
    
        $this->execute("UPDATE conplanoreduz
                        SET c61_codigo = $fonte23
                        WHERE c61_anousu = $anousu
                          AND LENGTH(c61_codigo::varchar) < 5");
        
    }
    
    public function down()
    {
        $this->execute("UPDATE conplanoorcamentoanalitica t1
                        SET c61_codigo = t2.c61_codigo
                        FROM conplanoorcamentoanalitica t2
                        WHERE t2.c61_anousu = 2022
                          AND t1.c61_anousu > 2022
                          AND t1.c61_reduz = t2.c61_reduz");
    
    $this->execute("UPDATE conplanoreduz t1
                    SET c61_codigo = t2.c61_codigo
                    FROM conplanoreduz t2
                    WHERE t2.c61_anousu = 2022
                      AND t1.c61_anousu > 2022
                      AND t1.c61_reduz = t2.c61_reduz");
    }
}
