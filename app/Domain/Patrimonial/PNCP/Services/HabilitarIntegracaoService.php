<?php

namespace App\Domain\Patrimonial\PNCP\Services;

use App\Domain\Patrimonial\PNCP\Clients\PNCPClient;
use App\Domain\Patrimonial\PNCP\Exceptions\CompraEditalAvisoExcpetion;
use App\Domain\Patrimonial\PNCP\Models\IntegracaoPNCP;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HabilitarIntegracaoService
{
    private $http;

    public function __construct()
    {
        $this->http = new PNCPClient();
    }

    /**
     * @param $documento
     * @param $instituicao
     * @return string
     */
    public function habilitarIntegracaoPNCP($documento, $instituicao, $usuario)
    {
        if (!$this->verificaEnteAutorizado($documento)) {
            $this->incluirEnteAutorizado($documento);
        }
        $this->incluirIntegracaoPNCP($instituicao, $usuario);
        $mensagem = "Ação processada. Lista de entes autorizados no PNCP atualizada.";

        return $mensagem;
    }

    /**
     * @param $instituicao
     * @return Builder|Model|null
     */
    public function verificaIntegracao($instituicao)
    {
        return IntegracaoPNCP::query()->where('pn01_instit', '=', $instituicao)->first();
    }

    /**
     * @param $documento
     * @return bool
     * @throws \Exception
     */
    public function verificaEnteAutorizado($documento)
    {
        try {
            $response = $this->http->verificaEnteAutorizado(env("PNCP_CLIENTE_ID"));
        } catch (CompraEditalAvisoExcpetion $e) {
            throw new \Exception($e->getErros());
        }

        $entes = $response->entesAutorizados;
        foreach ($entes as $ente) {
            if ($ente->cnpj === $documento) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $documento
     * @return void
     * @throws \Exception
     */
    private function incluirEnteAutorizado($documento)
    {
        $dados = ["entesAutorizados" => ["{$documento}"]];
        $client_id = env("PNCP_CLIENTE_ID");
        try {
            $this->http->incluirEnteAutorizado($client_id, $dados);
        } catch (CompraEditalAvisoExcpetion $e) {
            throw new \Exception($e->getErros());
        }
    }


    /**
     * @param $instituicao
     * @return void
     */
    private function incluirIntegracaoPNCP($instituicao, $usuario)
    {
        IntegracaoPNCP::create([
            'pn01_data' => date('Y-m-d'),
            'pn01_instit' => $instituicao,
            'pn01_habilitado' => true,
            'pn01_usuario' => intval($usuario)
        ]);
    }
}
