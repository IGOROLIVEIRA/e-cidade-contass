<?php

require_once 'model/caixa/AutenticacaoPlanilha.model.php';
require_once 'libs/exceptions/ParameterException.php';

use PHPUnit\Framework\TestCase;

class AutenticacaoPlanilhaTest extends TestCase
{
    public function testConstruct()
    {
        try {
            $spreadsheetAuth = new AutenticacaoPlanilha();
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), "N�o � um objeto do tipo PlanilhaArrecadacao.");
        }
    }
}
