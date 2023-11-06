<?php

namespace App\Services\Patrimonial\Aditamento;

use App\Domain\Patrimonial\Aditamento\Aditamento;
use DateTime;
use ReflectionClass;

class AditamentoSerializeService
{
    private Aditamento $aditamento;

    /**
     *
     * @param Aditamento $aditamento
     */
    public function __construct(Aditamento $aditamento)
    {
        $this->aditamento = $aditamento;
    }

    /**
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $reflection = new ReflectionClass($this->aditamento);
        $lista = [];

        $atributos = $reflection->getProperties();

        foreach($atributos as $atributo) {
            $prop = $reflection->getProperty($atributo->getName());
            $prop->setAccessible(true);

            $value = $prop->getValue($this->aditamento);
            $value = is_a($value, DateTime::class)
                    ? $value->format('d/m/Y')
                    : $value;

            if ($atributo->getName() === 'itens') {
                $lista['itens'] = $this->serializeItem($value);
            } else {
                $lista[$atributo->getName()] = $value;
            }

            $prop->setAccessible(false);
        }
        return $lista;
    }

    /**
     * @param array $itens
     * @return array
     */
    private function serializeItem(array $itens): array
    {
        $listaItens = [];

        foreach ($itens as $key => $item) {
            $reflection = new ReflectionClass($item);
            $atributos = $reflection->getProperties();

            foreach($atributos as $atributo) {
                $prop = $reflection->getProperty($atributo->getName());
                $prop->setAccessible(true);

                $value = $prop->getValue($item);
                $value = is_a($value, DateTime::class)
                        ? $value->format('Y-m-d')
                        : $value;

                $listaItens[$key][$atributo->getName()] = $value;
                $prop->setAccessible(false);
            }
        }
        return $listaItens;
    }
}
