<?php

use Phinx\Migration\AbstractMigration;

class Oc22330 extends AbstractMigration
{

    public function up()
    {

        $sqlD = "
            delete from amparocflicita;
        ";
        $this->execute($sqlD);

        $aRowsInstit = $this->getInstit();

        foreach ($aRowsInstit as $aInstit) {

            $aLeilaoEletronico = $this->getLeilaoEletronico($aInstit['codigo']);
            if(!empty($aLeilaoEletronico)) {
                $this->execute("insert into amparocflicita values(4,{$aLeilaoEletronico[0]})");
                $this->execute("insert into amparocflicita values(80,{$aLeilaoEletronico[0]})");
                $this->execute("insert into amparocflicita values(121,{$aLeilaoEletronico[0]})");
            }

            $aLeilao = $this->getLeilao($aInstit['codigo']);
            if(!empty($aLeilao)) {
                $this->execute("insert into amparocflicita values(80,{$aLeilao[0]})");
            }

            $aCodDialogoCompetitivo = $this->getDialogoCompetitivo($aInstit['codigo']);
            if(!empty($aCodDialogoCompetitivo)) {
                $this->execute("insert into amparocflicita values(5,{$aCodDialogoCompetitivo[0]})");
                $this->execute("insert into amparocflicita values(80,{$aCodDialogoCompetitivo[0]})");
                $this->execute("insert into amparocflicita values(128,{$aCodDialogoCompetitivo[0]})");
            }

            $aConcurso = $this->getConcurso($aInstit['codigo']);
            if(!empty($aConcurso)) {
                $this->execute("insert into amparocflicita values(3,{$aConcurso[0]})");
                $this->execute("insert into amparocflicita values(80,{$aConcurso[0]})");
                $this->execute("insert into amparocflicita values(116,{$aConcurso[0]})");
                $this->execute("insert into amparocflicita values(117,{$aConcurso[0]})");
                $this->execute("insert into amparocflicita values(118,{$aConcurso[0]})");
                $this->execute("insert into amparocflicita values(119,{$aConcurso[0]})");
                $this->execute("insert into amparocflicita values(120,{$aConcurso[0]})");
            }

            $aConcorrenciaEletronica = $this->getConcorrenciaEletronica($aInstit['codigo']);
            if(!empty($aConcorrenciaEletronica)) {
                $this->execute("insert into amparocflicita values(2,{$aConcorrenciaEletronica[0]})");
                $this->execute("insert into amparocflicita values(80,{$aConcorrenciaEletronica[0]})");
                $this->execute("insert into amparocflicita values(114,{$aConcorrenciaEletronica[0]})");
                $this->execute("insert into amparocflicita values(115,{$aConcorrenciaEletronica[0]})");
                $this->execute("insert into amparocflicita values(116,{$aConcorrenciaEletronica[0]})");
                $this->execute("insert into amparocflicita values(117,{$aConcorrenciaEletronica[0]})");
                $this->execute("insert into amparocflicita values(118,{$aConcorrenciaEletronica[0]})");
                $this->execute("insert into amparocflicita values(119,{$aConcorrenciaEletronica[0]})");
                $this->execute("insert into amparocflicita values(120,{$aConcorrenciaEletronica[0]})");
                $this->execute("insert into amparocflicita values(123,{$aConcorrenciaEletronica[0]})");
            }

            $aConcorrenciaPresesial = $this->getConcorrenciaPresencial($aInstit['codigo']);
            if(!empty($aConcorrenciaPresesial)) {
                $this->execute("insert into amparocflicita values(2,{$aConcorrenciaPresesial[0]})");
                $this->execute("insert into amparocflicita values(80,{$aConcorrenciaPresesial[0]})");
            }

            $aPregaoEletronico = $this->getPregaoEletronico($aInstit['codigo']);
            if(!empty($aPregaoEletronico)) {
                $this->execute("insert into amparocflicita values(1,{$aPregaoEletronico[0]})");
                $this->execute("insert into amparocflicita values(80,{$aPregaoEletronico[0]})");
                $this->execute("insert into amparocflicita values(113,{$aPregaoEletronico[0]})");
                $this->execute("insert into amparocflicita values(123,{$aPregaoEletronico[0]})");
            }

            $aPregaoPresesial = $this->getPregaoPresencial($aInstit['codigo']);
            if(!empty($aPregaoPresesial)) {
                $this->execute("insert into amparocflicita values(1,{$aPregaoPresesial[0]})");
                $this->execute("insert into amparocflicita values(80,{$aPregaoPresesial[0]})");
            }

            $aDispensa = $this->getDispensa($aInstit['codigo']);
            if(!empty($aDispensa)) {
                $this->execute("insert into amparocflicita values(18,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(19,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(20,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(21,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(22,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(23,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(24,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(25,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(26,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(27,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(28,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(29,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(30,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(31,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(32,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(33,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(34,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(35,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(36,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(37,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(38,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(39,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(40,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(41,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(42,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(43,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(44,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(45,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(46,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(51,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(52,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(53,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(54,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(55,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(56,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(57,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(58,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(59,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(60,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(61,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(62,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(63,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(64,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(65,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(66,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(67,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(68,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(69,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(70,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(71,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(72,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(73,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(74,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(75,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(76,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(77,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(78,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(79,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(84,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(85,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(86,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(87,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(88,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(89,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(90,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(91,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(92,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(93,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(94,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(95,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(96,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(97,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(98,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(99,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(100,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(101,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(126,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(127,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(128,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(129,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(130,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(131,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(132,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(133,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(134,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(135,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(136,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(137,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(138,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(139,{$aDispensa[0]})");
                $this->execute("insert into amparocflicita values(80,{$aDispensa[0]})");
            }

            $aInexigibilidade = $this->getInexigibilidade($aInstit['codigo']);
            if(!empty($aInexigibilidade)){
                $this->execute("insert into amparocflicita values(6,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(7,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(8,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(9,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(10,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(11,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(12,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(13,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(14,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(15,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(16,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(17,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(50,{$aInexigibilidade[0]})");
                $this->execute("insert into amparocflicita values(102,{$aInexigibilidade[0]})");
            }

            $aDispensaporchamadapublica = $this->getDispensaporchamadapublica($aInstit['codigo']);
            if(!empty($aDispensaporchamadapublica)){
                $this->execute("insert into amparocflicita values(103,{$aDispensaporchamadapublica[0]})");
                $this->execute("insert into amparocflicita values(125,{$aDispensaporchamadapublica[0]})");
                $this->execute("insert into amparocflicita values(140,{$aDispensaporchamadapublica[0]})");
                $this->execute("insert into amparocflicita values(141,{$aDispensaporchamadapublica[0]})");
                $this->execute("insert into amparocflicita values(142,{$aDispensaporchamadapublica[0]})");
            }

            $aInexigibilidadeporcredenciamento = $this->getInexigibilidadeporcredenciamento($aInstit['codigo']);
            if(!empty($aInexigibilidadeporcredenciamento)){
                $this->execute("insert into amparocflicita values(103,{$aInexigibilidadeporcredenciamento[0]})");
                $this->execute("insert into amparocflicita values(125,{$aInexigibilidadeporcredenciamento[0]})");
                $this->execute("insert into amparocflicita values(140,{$aInexigibilidadeporcredenciamento[0]})");
                $this->execute("insert into amparocflicita values(141,{$aInexigibilidadeporcredenciamento[0]})");
                $this->execute("insert into amparocflicita values(142,{$aInexigibilidadeporcredenciamento[0]})");
            }
        }

    }

    private function getInstit(): array
    {
        return $this->fetchAll("SELECT codigo FROM db_config");
    }

    private function getLeilaoEletronico($instit): array
    {
        $result = $this->fetchRow("select l03_codigo from cflicita where l03_instit = $instit and l03_pctipocompratribunal=54 and l03_presencial='f' and l03_tipo = 'H'");
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    private function getLeilao($instit): array
    {
        $result = $this->fetchRow("select l03_codigo from cflicita where l03_instit =$instit and l03_pctipocompratribunal=54 and l03_tipo !='H'");
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    private function getDialogoCompetitivo($instit): array
    {
       $result = $this->fetchRow("select l03_codigo from cflicita where l03_instit = $instit and l03_pctipocompratribunal=110");
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    private function getConcurso($instit): array
    {
        $result = $this->fetchRow("select l03_codigo from cflicita where l03_instit = $instit and l03_pctipocompratribunal=51");

        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    private function getConcorrenciaEletronica($instit): array
    {
        $result = $this->fetchRow("select l03_codigo from cflicita where l03_instit = $instit and l03_pctipocompratribunal=50 and l03_presencial='f' and l03_tipo = 'H'");
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }
    private function getConcorrenciaPresencial($instit): array
    {
        $result = $this->fetchRow("select l03_codigo from cflicita where l03_instit = $instit and l03_pctipocompratribunal=50 and l03_tipo !='H'");
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    private function getPregaoEletronico($instit): array
    {
        $result = $this->fetchRow("select l03_codigo from cflicita where l03_instit = $instit and l03_pctipocompratribunal=53");
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    private function getPregaoPresencial($instit): array
    {
        $result = $this->fetchRow("select l03_codigo from cflicita where l03_instit = $instit and l03_pctipocompratribunal=52");
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    private function getDispensa($instit): array
    {
        $result = $this->fetchRow("select l03_codigo from cflicita where l03_instit = $instit and l03_pctipocompratribunal=101");
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    private function getInexigibilidade($instit): array
    {
        $result = $this->fetchRow("select l03_codigo from cflicita where l03_instit = $instit and l03_pctipocompratribunal=100");
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    private function getDispensaporchamadapublica($instit): array
    {
        $result = $this->fetchRow("select l03_codigo from cflicita where l03_instit = $instit and l03_pctipocompratribunal = 102");
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    private function getInexigibilidadeporcredenciamento($instit): array
    {
        $result = $this->fetchRow("select l03_codigo from cflicita where l03_instit = $instit and l03_pctipocompratribunal  = 103");
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

}
