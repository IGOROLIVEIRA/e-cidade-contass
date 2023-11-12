<?php


namespace App\Domain\Financeiro\Orcamento\Services;

use App\Domain\Financeiro\Orcamento\Models\Complemento;
use App\Domain\Financeiro\Orcamento\Repositories\ComplementoRepository;
use App\Domain\Financeiro\Orcamento\Requests\Cadastro\ComplementoSalvarRequest;
use Exception;

class ComplementoService
{

    /**
     * @var ComplementoRepository
     */
    private $repository;

    public function __construct(ComplementoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return Complemento::orderBy('o200_sequencial')->get();
    }

    /**
     * @param ComplementoSalvarRequest $request
     * @return Complemento
     * @throws Exception
     */
    public function salvar(ComplementoSalvarRequest $request)
    {
        $complemento = $this->buildByRequest($request);
        return $this->repository->persist($complemento);
    }

    private function buildByRequest(ComplementoSalvarRequest $request)
    {
        $model = new Complemento();
        $model->setSequencial($request->get('codigo'))
            ->setDescricao($request->get('descricao'))
            ->setMsc($request->get('msc'))
            ->setTribunal($request->get('tribunal'));
        return $model;
    }

    /**
     * @param integer $id
     * @throws Exception
     */
    public function excluir($id)
    {
        $model = Complemento::with('recursos')->find($id);

        if ($model->recursos->count()) {
            throw new Exception(
                "Esse complemento n�o pode ser exclu�do pois esta vinculado a um ou mais recursos.",
                406
            );
        }

        $this->repository->excluir(Complemento::find($id));
    }
}
