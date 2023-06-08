<?php

namespace App\Support\View;

trait LegacyPath
{
    protected string $resources_path = 'resources';
    protected string $resources_legacy_path = 'legacy';
    protected string $resources_func_path = 'func_files';

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
            'cal' => 'calendario',
            'cin' => 'controle_interno',
            'com' => 'compras',
            'con' => 'contabilidade',
            'conf' => 'configuracao',
            'contr' => 'contribuinte',
            'cus' => 'custos',
            'div' => 'divida_ativa',
            'dv' => 'diversos',
            'dvr' => 'diversos',
            'edu' => 'educacao',
            'esc' => 'educacao',
            'eso' => 'educacao',
            'emp' => 'empenho',
            'far' => 'farmacia',
            'fis' => 'fiscal',
            'ges' => 'gestor_bi',
            'hab' => 'habitacao',
            'inf' => 'inflatores',
            'ipa' => 'ipasem',
            'iss' => 'issqn',
            'itb' => 'itbi',
            'itbi' => 'itbi',
            'jur' => 'juridico',
            'lab' => 'laboratorio',
            'lic' => 'licitacao',
            'mar' => 'marcas',
            'mat' => 'materiais',
            'mer' => 'merenda',
            'not' => 'notificacoes',
            'amb' => 'meioambiente'
        ];
    }

    public function getNewPath(string $file): string
    {
        if(!strpos($file, '_')) {
            return $file;
        }

        if ($this->isFuncFile($file)) {
            return $this->resources_path. DS . $this->resources_legacy_path . DS . $this->resources_func_path . DS . $file;
        }

        $prefix = $this->getPrefix($file);
        $map = $this->pathMap();
        if(!array_key_exists($prefix, $map)) {
            return $file;
        }
        return $this->resources_path. DS . $this->resources_legacy_path . DS . $map[$prefix] . DS . $file;
    }

    private function getPrefix(string $fileName): string
    {
        $prefix = '';

        for ($i = 0; $i < strlen($fileName); $i++){
            $caracter = $fileName[$i];
            if (is_numeric($caracter)) {
               break;
            }
            $prefix .= $caracter;
        }

        return $prefix;
    }

    private function isFuncFile(string $fileName): bool
    {
        if (substr($fileName, 0, 4) === 'func') {
            return true;
        }

        if (substr($fileName, 0, 7) === 'db_func') {
            return true;
        }
        return false;
    }
}