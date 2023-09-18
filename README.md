## e-Cidade v3
## Eloquent
O Eloquent é um ORM utilizado nativamente pelo Laravel. Aqui no e-cidade usamos com o mesmo propósito, ou seja, de ser uma camada de acesso ao banco de dados.
### Como usar?

Para utilizar, basta criar uma classe em `app/Models` que `extends` de `LegacyModel` e pronto. De resto, basta seguir as convenções do ORM que são descritas na [doc do Eloquent](https://laravel.com/docs/5.8/eloquent):

```php
<?php

namespace App\Models;

class Flight extends LegacyModel
{
    //
}

```

### Account de Dados do E-cidade
Mas e como fica os logs do e-cidade? Para solucionar essa dor, foi criada uma `Trait` chamada `LegacyAccount`. Fazendo o uso dessa `trait` o model irá realizar os logs de accout legacy do e-cidade de forma automática para os eventos de `save`, `update` e `delete`:

```php

<?php

namespace App\Models;

class Flight extends LegacyModel
{
    use LegacyAccount;
}
```

### Legacy Labels
Para tornar o eloquent compatível com a geracao de HTML nativa do e-cidade, utilize a trait `LegacyLabel`.

1. Incula a trait `LegacyLabel` no model:

```php
<?php
class ConfiguracaoPixBancoDoBrasil extends LegacyModel
{
    use LegacyLabel;
}
```
2. Dessa forma voce será capaz de utilizar o método `label()` normalmente:

```php
<?php
// Forma legada
$clissbase->rotulo->label();
db_input('q02_inscr',4,$Iq02_inscr,true,'text',$db_opcao,"")

// Com eloquent
use App\Models\ConfiguracaoPixBancoDoBrasil;

$configuracaoPixBb = new ConfiguracaoPixBancoDoBrasil();
$configuracaoPixBb->legacyLabel->label();

db_input(
    'k177_url_api',
    '',
    $Ik177_url_api,
    true,
    'text',
    $db_opcao,
    " style='width: 100%'",
    '',
    '',
    '',
    ''
);
```

### Observacoes
- O Eloquent nao coloca em desuso as classes DAO (classes/db_tabela_classe.php) nativas do e-cidade, apenas dá uma possibilidade a mais para o desenvolvedor de utilizar os Models do Eloquent no lugar das classes DAO legadas.
- A versão atual do Eloquent é 9, no entanto estamos usando a 5.8 devido a outras dependências atuais do e-cidade.


## Usando docker na v3
Para usar o docker primeiro edit o env com a porta para o apache
```bash
    $cp .env-exemplo .env
```

Depois execute o comando para subir o docker do apache
```bash
    $docker-compose up -d 
```

Acesse no navegador com o portal informada no .env: http://localhost:8888

Obs.: Nesse momento não temos um docker do banco de dados;

### Para debugar no PHPSTORM

...

### Para Debugar no VSCode

...

