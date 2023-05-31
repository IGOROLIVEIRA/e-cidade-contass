<?php

interface ValidadorAcessoApiInterface
{
    /**
     * Executa pool de validações
     *
     * @param resource|null $results
     * @return void
     */
    public function execute($results = null): void;
}