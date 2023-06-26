<?php

interface ValidaAcessoApiInterface
{
    /**
     * Executa pool de validações
     *
     * @param resource $results
     * @return void
     */
    public function execute($results): void;
}
