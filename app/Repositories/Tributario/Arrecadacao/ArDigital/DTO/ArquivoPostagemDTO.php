<?php

namespace App\Repositories\Tributario\Arrecadacao\ArDigital\DTO;

class ArquivoPostagemDTO
{
    public string $codigoGrafica = '04';

    public string $dataColeta;

    public string $numeroContrato = '9912458442';

    public string $codigoAdministrativo = '19069090';

    public string $cepDestino = '00000000';

    public string $codigoServico = '11401';

    public string $codigoPais = '10';

    public string $codServicoAdicional1 = '00';

    public string $codServicoAdicional2 = '00';

    public string $codServicoAdicional3 = '00';

    public string $valorDeclarado = '00000,00';

    public string $numeroEtiqueta = '000000000';

    public string $peso = '00000';

    public string $numeroLogradouro = '000000';

    public string $numeroCartaoPostagem = '00074681443';

    public string $numeroNotaFiscal = '0000000';

    public string $siglaServico = 'BH';

    public string $comprimentoObjeto = '00000';

    public string $larguraObjeto = '00000';

    public string $alturaObjeto = '00000';

    public string $valorACobrarDestinatario = '00000,00';

    public string $nomeDestinatario = '';

    public string $codigoTipoObjeto = '001';

    public string $diametroObjeto = '00000';

    public string $numeroCelularDestinatario = '';

    public string $nomeLogradouroDestinatario = '';

    public string $complementoEnderecoDestinatario = '';

    public string $bairroDestinatario = '';

    public string $cidadeDestinatario = '';

    public string $estadoDestinatario = '';

    public function __construct($data = null)
    {
        if (empty($data)) {
            return;
        }
        $this->fill($data);
    }

    /**
     * Business logic to fill the payload
     * @param array $data
     * @return void
     */
    public function fill(array $data): void
    {
        foreach ($data as $attribute => $value) {

            if (!property_exists((new self()), $attribute)) {
                continue;
            }

            $this->$attribute = $value;
        }
    }
}