<?php

namespace App\Services\Tributario\Contabilidade;

use AutenticacaoBaixaBanco;
use DateTime;
use Exception;
use Illuminate\Database\Capsule\Manager as DB;

class WriteOfAuthenticateBankService
{
    public int $classificationCode;
    public DateTime $authenticationDate;
    public int $userId;
    public string $ipTerminal;
    public int $institId;
    private AutenticacaoBaixaBanco $autenticacaoBaixaBanco;

    /**
     * @throws Exception
     */
    public function execute(int $classificationCode,
                            DateTime $authenticationDate,
                            int $userId,
                            string $ipTerminal,
                            int $institId
    ) {
        $this->classificationCode = $classificationCode;
        $this->authenticationDate = $authenticationDate;
        $this->userId = $userId;
        $this->ipTerminal = $ipTerminal;
        $this->institId = $institId;
        $this->autenticacaoBaixaBanco = new AutenticacaoBaixaBanco($classificationCode);

        $this->executeProcedure();
        $this->executeCountingRegisters();
    }

    /**
     * @throws Exception
     */
    private function executeProcedure(): void
    {
        $sql  = " select fc_autenclass({$this->classificationCode}, '{$this->authenticationDate->format('Y-m-d')}', ";
        $sql .= "                     '{$this->authenticationDate->format('Y-m-d')}', {$this->authenticationDate->format('Y')},";
        $sql .= "                     '{$this->ipTerminal}', {$this->institId}) as fc_autenticabaixa";

        $return = DB::connection()->unprepared($sql);

        if (!$return) {
            throw new Exception('Falha ao executar autenticacao de baixa bancária.');
        }
    }

    /**
     * @throws Exception
     */
    private function executeCountingRegisters()
    {
        $lReceitaOrcamentaria = $this->autenticacaoBaixaBanco->executarLancamentoContabeis(false);
        $lPrestacaoContas     = $this->autenticacaoBaixaBanco->processaLancamentoPrestacaoContas();
        if ($lReceitaOrcamentaria) {
            $this->autenticacaoBaixaBanco->executarLancamentoContabeis(true, true);
            $this->autenticacaoBaixaBanco->executarLancamentoContabeis(true);
        }

        $lReceitaExtra = $this->autenticacaoBaixaBanco->processaArrecadacaoReceitaExtraOrcamentaria();
        $lReceitaExtraPrestacaoConta = $this->autenticacaoBaixaBanco->processaArrecadacaoReceitaExtraOrcamentariaPrestacaoContas();

        if (!$lReceitaOrcamentaria && !$lReceitaExtra && !$lPrestacaoContas && !$lReceitaExtraPrestacaoConta) {
            throw new Exception("Não foram localizadas receitas para arrecadação.");
        }
    }
}