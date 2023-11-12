<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

namespace App\Domain\Financeiro\Orcamento\Controllers;

use App\Http\Controllers\Controller;
use ECidade\Financeiro\Orcamento\Service\EspecificacaoService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class EspecificacaoRecursoController
 * @package App\Domain\Financeiro\Orcamento\Controllers
 */
class EspecificacaoRecursoController extends Controller
{

    private $service;

    public function __construct()
    {
        $this->service = new EspecificacaoService();
    }

    public function salvar(Request $request)
    {
        $this->service->salvar((object) $request->all());
        return response()->json(
            [
                'erro'=> false,
                "message"=> utf8_encode("Especifica��o do Recurso salva com sucesso.")
            ]
        );
    }

    public function excluir(Request $request)
    {
        $this->service->excluir((object) $request->all());
        return response()->json(
            [
                'erro' => false,
                "message" => utf8_encode("Especifica��o do Recurso exclu�da com sucesso.")
            ]
        );
    }
}
