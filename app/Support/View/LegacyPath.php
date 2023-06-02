<?php

namespace App\Support\View;

trait LegacyPath
{
    protected string $resources_path = 'resources';
    protected string $resources_legacy_path = 'legacy';

    private function pathMap(): array
    {
        return [
            'aco' => 'acordo',
            'age' => 'agenda',
            'agu' => 'agua',
            'arr' => 'arrecadacao',
            'ate' => 'atendimento',
            'bib' => 'biblioteca',
            'cad' => 'cadastro',
            'cai' => 'caixa',
            'amb' => 'meioambiente'
        ];
    }
    public function getNewPath(string $file): string
    {
        if(!strpos($file, '_')) {
            return $file;
        }
        $prefix = substr($file, 0 ,3);
        $map = $this->pathMap();
        if(!array_key_exists($prefix, $map)) {
            return $file;
        }
        return $this->resources_path. DS . $this->resources_legacy_path . DS . $map[$prefix] . DS . $file;
    }
}