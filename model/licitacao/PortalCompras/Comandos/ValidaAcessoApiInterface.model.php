<?php

interface ValidaAcessoApiInterface
{
    /**
     * Executa pool de valida��es
     *
     * @param resource|null $results
     * @return void
     */
    public function execute($results = null): void;
}