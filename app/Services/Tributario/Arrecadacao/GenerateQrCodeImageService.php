<?php

namespace App\Services\Tributario\Arrecadacao;

use Endroid\QrCode\Builder\BuilderInterface;

class GenerateQrCodeImageService
{
    private const PATH = 'tmp/';
    private BuilderInterface $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function execute(string $data): string
    {
        $this->validate($data);
        $fileName = $this->buildFilePath();
        $this->builder
            ->data($data)
            ->build()
            ->saveToFile($fileName);
        return $fileName;
    }

    private function validate($data)
    {
        if (empty($data)) {
            throw new \BusinessException('Dados não informados para geração da imagem do QRCode.');
        }
    }

    private function  buildFilePath(): string {
        return self::PATH.'qrcode-'.time().'.png';
    }

}