<?php

namespace App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts;

interface IPixPayload
{
    public function fill(array $data): void;
    public function toJson();
}