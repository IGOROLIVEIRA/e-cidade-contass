<?php

namespace App\Repositories\Tributario\Arrecadacao\ArDigital\DTO;

class ArquivoPrevisaoPostagemDetalheDTO
{
    public const OPERACAO_INCLUSAO = '1101';
    public const TIPO_POSTAL = 'YA';
    public const PAIS_ORIGEM = 'BR';

    public string $codigoDoCliente = '8443';
    public string $identificadorDoCliente = 'MHF';
    public string $siglaDoObjeto = self::TIPO_POSTAL;
    public string $numeroDoObjeto = '000000000';
    public string $paisDeOrigem = self::PAIS_ORIGEM;
    public string $codigoDaOperacao = self::OPERACAO_INCLUSAO;
    public string $conteudo = '';
    public string $nomeDestinatario = '';
    public string $enderecoDestinatario = '';
    public string $cidade = '';
    public string $uf = '';
    public string $cep = '';
    public int $numeroSequencialArquivo = 1;
    /**
     * Seqüencial de registro, a partir de 0000002
     * @var int
     */
    public int $numeroSequencialRegistro = 0;
}
