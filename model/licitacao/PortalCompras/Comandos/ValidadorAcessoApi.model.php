<?php

require_once("model/licitacao/PortalCompras/Comandos/ValidadorAcessoApiInterface.model.php");
require_once("model/licitacao/PortalCompras/Comandos/ValidadorChaveAcesso.model.php");
require_once("model/licitacao/PortalCompras/Comandos/Pool/ValidadorResultadoVazio.model.php");
require_once("model/licitacao/PortalCompras/Comandos/Pool/ValidadorSituacao.model.php");

class ValidadorAcessoApi implements ValidadorAcessoApiInterface
{
    /**
     * @var ValidadorAcessoApiInterface[]
     */
    private array $pool = [];

    /**
     * @var ValidadorChaveAcesso
     */
    private ValidadorChaveAcesso $validadorChaveAcesso;

    public function __construct()
    {
        $this->validadorChaveAcesso = new ValidadorChaveAcesso();
        $this->pool = [
            new ValidadorResultadoVazio(),
            new ValidadorSituacao()
        ];
    }

    /**
     * Executa pool de validações
     *
     * @param resource|null $results
     * @return void
     */
    public function execute($results = null): void
    {
        try{
            foreach($this->pool as $validador){
                $validador->execute($results);
            }
        } catch(Exception $e){
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
            return $this->validadorChaveAcesso->execute();
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}