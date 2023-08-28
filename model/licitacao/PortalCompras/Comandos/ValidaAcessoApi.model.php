<?php

require_once("model/licitacao/PortalCompras/Comandos/ValidaAcessoApiInterface.model.php");
require_once("model/licitacao/PortalCompras/Comandos/ValidaChaveAcesso.model.php");
require_once("model/licitacao/PortalCompras/Comandos/Pool/ValidaResultadoVazio.model.php");
require_once("model/licitacao/PortalCompras/Comandos/Pool/ValidaSituacao.model.php");

class ValidaAcessoApi implements ValidaAcessoApiInterface
{
    /**
     * @var ValidaAcessoApiInterface[]
     */
    private array $pool = [];

    /**
     * @var ValidadorChaveAcesso
     */
    private ValidaChaveAcesso $validaChaveAcesso;

    public function __construct()
    {
        $this->validaChaveAcesso = new ValidaChaveAcesso();
        $this->pool = [
            new ValidaResultadoVazio(),
            new ValidaSituacao()
        ];
    }

    /**
     * Executa pool de validações
     *
     * @param resource $results
     * @return void
     */
    public function execute($results): void
    {
        try{
            foreach($this->pool as $validador){
                $validador->execute($results);
            }
        } catch(Exception $e) {
            throw new Exception(utf8_encode($e->getMessage()));
        }
    }

    /**
     * Verifica e retorna chave de acesso
     *
     * @return string
     */
    public function getChaveAcesso(): string
    {
        try{
            return $this->validaChaveAcesso->execute();
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
