<?php

namespace App\Models;

use App\Models\Concerns\IApiPixConfiguration;
use App\Traits\LegacyAccount;
use App\Traits\LegacyLabel;

class ConfiguracaoPixBancoDoBrasil extends LegacyModel implements IApiPixConfiguration
{
    use LegacyAccount;
    use LegacyLabel;

    public const CODIGO = 1;
    public const OPTION_LABEL = 'Banco do Brasil';

    public const ENVIRONMENTS = ['T' => 'Teste','P' => 'Produção'];

    /**
     * @var string
     */
    protected $table = 'arrecadacao.configuracoes_pix_banco_do_brasil';

    /**
     * @var string
     */
    protected $primaryKey = 'k177_sequencial';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'k177_instituicao_financeira',
        'k177_numero_convenio',
        'k177_develop_application_key',
        'k177_url_api',
        'k177_url_oauth',
        'k177_client_id',
        'k177_client_secret',
        'k177_ambiente',
        'k177_chave_pix',
    ];
}