<?php

namespace interfaces\caixa\relatorios;

interface IReceitaPeriodoTesourariaRepository
{
    public function pegarDados();
    public function pegarFormatoPagina();
}