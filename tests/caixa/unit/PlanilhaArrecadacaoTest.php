<?php

require_once 'std/label/rotulo.php';
require_once 'std/label/RotuloDB.php';
require_once 'classes/db_placaixa_classe.php';
require_once 'model/caixa/PlanilhaArrecadacao.model.php';
// require_once 'e-cidadeonline/libs/db_stdlib.php';

use PHPUnit\Framework\TestCase;

class PlanilhaArrecadacaoTest extends TestCase
{
    public function testConstruct()
    {
        $spreadsheet = new PlanilhaArrecadacao();
        $this->assertEquals(new PlanilhaArrecadacao(), 
            $spreadsheet, 
            "Atual valor não é igual");
    }
}