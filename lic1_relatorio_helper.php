<?php

function isCriterioAdjucacaoTipoJulgamentoCabecalhoSemPercentual(string $tipo, string $criterio): bool {
    if ($criterio !== '3') {
        return FALSE;
    }

    $tipos = [
        '1',
        '3'
    ];

    return in_array($tipo, $tipos);
}

function isCriterioAdjucacaoOutrosTipoJulgamentoLote(string $tipo, string $criterio): bool {
    if ($criterio !== '3') {
        return FALSE;
    }

    return $tipo === '3';
}

function isCriterioAdjucacaoTipoJulgamentoCabecalhoComPercentual(string $tipo, string $criterio): bool {
    $criterios = [
        '1',
        '2'
    ];

    if (!in_array($criterio, $criterios)) {
        return FALSE;
    }

    $tipos = [
        '1',
        '3'
    ];

    return in_array($tipo, $tipos);
}

function isCriterioAdjucacaoDescontoMenorTaxaPercTipoJulgamentoLote(string $tipo, string $criterio): bool {
    $criterios = [
        '1',
        '2'
    ];

    if (! in_array($criterio, $criterios)) {
        return FALSE;
    }

    return $tipo === '3';
}

function getCabecalhoTabelaLayout(string $tipo_impressao = 'pdf') {
    if ($tipo_impressao === 'word') {
        echo <<<HTML
        <tr style="background-color: #CDC9C9;">
            <th>Seq.</th>
            <th>Código</th>
            <th>Descrição</th>
            <th>Unidade</th>
            <th>Marca</th>
            <th>Quantidade</th>
            <th>Unitário</th>
            <th>Total</th>
        </tr>
        HTML;
    } else {
        echo <<<HTML
        <div class="tr bg_eb">
            <div class="th col-seq align-center">Seq.</div>
            <div class="th col-item align-center">Código</div>
            <div class="th col-descricao-item-sem-percentual align-center">Descrição</div>
            <div class="th col-valor_un align-center">Unidade</div>
            <div class="th col-valor_un align-center">Marca</div>
            <div class="th col-quant align-center">Quantidade</div>
            <div class="th col-valor_un align-right">Unitário</div>
            <div class="th col-total align-right">Total</div>
        </div>
        HTML;
    }
}

function getCabecalhoTabelaLayoutComPercentual(string $tipo_impressao = 'pdf') {
    if ($tipo_impressao === 'word') {
        echo <<<HTML
        <tr style="background-color: #CDC9C9;">
            <th>Seq.</th>
            <th>Código</th>
            <th>Descrição</th>
            <th>Unidade</th>
            <th>Marca</th>
            <th>Quantidade</th>
            <th>Unitário</th>
            <th>Percentual</th>
            <th>Total</th>
         </tr>
        HTML;
    } else {
        echo <<<HTML
        <div class="tr bg_eb">
            <div class="th col-seq-item-percentual align-center">Seq.</div>
            <div class="th col-seq-item-percentual align-center">Código</div>
            <div class="th col-descricao-item-percentual align-center">Descrição</div>
            <div class="th col-geral-percentual align-center">Unidade</div>
            <div class="th col-geral-percentual align-center">Marca</div>
            <div class="th col-quantidade-percentual align-center">Quantidade</div>
            <div class="th col-geral-percentual align-center">Unitário</div>
            <div class="th col-quantidade-percentual align-center">Percentual</div>
            <div class="th col-total-percentual align-center">Total</div>
        </div>
        HTML;
    }
}

function getDadosTabelaLayout(object $oResult, object $oDadosDaLinha, string $tipo_impressao = 'pdf') {
    if ($tipo_impressao === 'word') {
        echo <<<HTML
        <tr>
            <td>$oResult->ordem</td>
            <td>$oDadosDaLinha->item</td>
            <td>$oDadosDaLinha->descricao</td>
            <td>$oDadosDaLinha->unidadeDeMedida</td>
            <td>$oDadosDaLinha->marca</td>
            <td>$oDadosDaLinha->quantidade</td>
            <td>$oDadosDaLinha->valorUnitario</td>
            <td>$oDadosDaLinha->total</td>
        </tr>
    HTML;
    } else {
        echo <<<HTML
        <div class="tr row">
          <div class="td col-seq align-center">
            {$oResult->ordem}
          </div>
          <div class="td col-item align-center">
            {$oDadosDaLinha->item}
          </div>
          <div class="td col-descricao-item-sem-percentual align-justify">
            {$oDadosDaLinha->descricao}
          </div>
          <div class="td col-valor_un  align-center">
            {$oDadosDaLinha->unidadeDeMedida}
          </div>
          <div class="td col-valor_un  align-center">
            {$oDadosDaLinha->marca}
          </div>
          <div class="td col-quant align-center">
            {$oDadosDaLinha->quantidade}
          </div>
          <div class="td col-valor_un align-right">
            {$oDadosDaLinha->valorUnitario}
          </div>
          <div class="td col-total align-right">
            {$oDadosDaLinha->total}
          </div>
        </div>
    HTML;
    }
}

function getDadosTabelaLayoutComPercentual(object $oResult, object $oDadosDaLinha, string $tipo_impressao = 'pdf') {
    if ($tipo_impressao === 'word') {
        echo <<<HTML
        <tr>
            <td>$oResult->ordem</td>
            <td>$oDadosDaLinha->item</td>
            <td>$oDadosDaLinha->descricao</td>
            <td>$oDadosDaLinha->unidadeDeMedida</td>
            <td>$oDadosDaLinha->marca</td>
            <td>$oDadosDaLinha->quantidade</td>
            <td>$oDadosDaLinha->valorUnitario</td>
            <td>$oDadosDaLinha->percentual</td>
            <td>$oDadosDaLinha->total</td>
        </tr>
    HTML;
    } else {
        echo <<<HTML
        <div class="tr row">
          <div class="td col-seq-item-percentual align-center">
            {$oResult->ordem}
          </div>
          <div class="td col-seq-item-percentual align-center">
            {$oDadosDaLinha->item}
          </div>
          <div class="td col-descricao-item-percentual align-justify">
            {$oDadosDaLinha->descricao}
          </div>
          <div class="td col-geral-percentual  align-center">
            {$oDadosDaLinha->unidadeDeMedida}
          </div>
          <div class="td col-geral-percentual  align-center">
            {$oDadosDaLinha->marca}
          </div>
          <div class="td col-quantidade-percentual align-center">
            {$oDadosDaLinha->quantidade}
          </div>
          <div class="td col-geral-percentual align-center">
            {$oDadosDaLinha->valorUnitario}
          </div>
          <div class="td col-quantidade-percentual align-center">
            {$oDadosDaLinha->percentual}
          </div>
           <div class="td col-total-percentual align-center">
             {$oDadosDaLinha->total}
           </div>
        </div>
    HTML;
    }
}

function getCabecalhoTabelaLayoutAntigo(string $tipo_impressao = 'pdf') {
    if ($tipo_impressao === 'word') {
        echo <<<HTML
        <tr style="background-color: #CDC9C9;">
            <th>Item</th>
            <th>Material/Serviços</th>
            <th>Unidade</th>
            <th>Marca</th>
            <th>Quant</th>
            <th>Uni/Taxa</th>
            <th>Total</th>
        </tr>
    HTML;
    } else {
        echo <<<HTML
        <div class="tr bg_eb">
            <div class="th col-item align-center">Item</div>
            <div class="th col-descricao-item-layout-antigo  align-center">Material/Serviços</div>
            <div class="th col-valor_un align-center">Unidade</div>
            <div class="th col-valor_un align-center">Marca</div>
            <div class="th col-quant align-center">Quant</div>
            <div class="th col-valor_un align-right">Uni/taxa</div>
            <div class="th col-total align-right">Total</div>
        </div>
    HTML;
    }
}

function getCabecalhoTabelaLinhaLote(string $descricao_lote, $colspan, string $tipo_impressao = 'pdf') {
    if ($tipo_impressao === 'word') {
        echo <<<HTML
        <tr>
            <th colspan="$colspan">
                {$descricao_lote}
            </th>
        </tr>
    HTML;

    } else {
        echo <<<HTML
        <div class="tr bg_eb">
            <div class="th col-item left" style="width:600px">
                {$descricao_lote}
            </div>
        </div>
    HTML;
    }
}

function getTabelaLinhaTotalHomologado(float $total_itens, int $colspan, string $tipo_impressao = 'pdf') {
    $soma_itens_formatado = db_formatar("$total_itens", 'f');
    $soma_itens_sem_espaco_branco = str_replace(' ', '', $soma_itens_formatado);
    $width = 670;

    if (getEscalaMonetaria($soma_itens_sem_espaco_branco) === 'K') {
        $width = 645;
    } elseif  (getEscalaMonetaria($soma_itens_sem_espaco_branco) === 'M' ||
        getEscalaMonetaria($soma_itens_sem_espaco_branco) === 'B') {
        $width = 635;
    }

    if ($tipo_impressao === 'word') {
        echo <<<HTML
        <tr>
            <td style="text-align: right;" colspan="$colspan">
                TOTAL HOMOLOGADO R$ $soma_itens_sem_espaco_branco
            </td>
        </tr>
    HTML;
    } else {
        echo <<<HTML
        <div class="tr row total-background">
            <div class="td item-total-color align-right" style="width:{$width}px;">
                TOTAL HOMOLOGADO

            </div>
            <div class="item-menu-color align-center" style="margin-top:2px;">
                R$ {$soma_itens_sem_espaco_branco}
            </div>
        </div>
    HTML;
    }
}

function getTabelaLinhaTotalGeral(float $soma_total_homologados, int $colspan, string $tipo_impressao = 'pdf') {
    $total_formatado = db_formatar("$soma_total_homologados", 'f');
    $total_sem_espaco_branco = str_replace(' ', '', $total_formatado);
    $width = 670;

    if (getEscalaMonetaria($total_sem_espaco_branco) === 'K') {
        $width = 645;
    } elseif  (getEscalaMonetaria($total_sem_espaco_branco) === 'M' ||
        getEscalaMonetaria($total_sem_espaco_branco) === 'B') {
        $width = 635;
    }

    if ($tipo_impressao === 'word') {
        echo <<<HTML
        <tr>
            <td style="text-align: right;" colspan="$colspan">
                TOTAL GERAL R$ {$total_sem_espaco_branco}
            </td>
        </tr>
    HTML;
    } else {
        echo <<<HTML
        <div class="tr row total-background">
            <div class="td item-total-color align-right" style="width:{$width}px;">
                TOTAL GERAL

            </div>
            <div class="item-menu-color align-center" style="margin-top:2px;">
                R$ {$total_sem_espaco_branco}
            </div>
        </div>
    HTML;
    }
}

function getTabelaLinhaSemTotalHomologado(float $valor, float $total_itens, int $colspan, string $tipo_impressao = 'pdf') {
    $valor_formatado = db_formatar("$valor", 'f');
    $total_itens_formatado = db_formatar("$total_itens", 'f');

    if ($tipo_impressao === 'word') {
        echo <<<HTML
        <tr>
            <td >
                VALOR
            </td>
            <td style="text-align: right;" colspan="$colspan">
                R$ {$valor}
            </td>
        </tr>
        <tr>
            <td >
                VALOR TOTAL
            </td>
            <td style="text-align: right;" colspan="$colspan">
                R$ {$total_itens_formatado}
            </td>
        </tr>
    HTML;
    } else {
        echo <<<HTML
            <div class="tr row">
                <div class="td item-total-color" style="width: 650px;">
                    VALOR

                </div>
                <div class="item-menu-color">
                    R$ $valor_formatado
                </div>
            </div>
            <div class="tr row">
                <div class="td item-total-color" style="width: 650px;">
                    VALOR TOTAL

                </div>
                <div class="item-menu-color">
                    R$ $total_itens_formatado
                </div>
            </div>
        HTML;
    }
}

function getDadosTabelaLayoutAntigo(object $oDadosDaLinha, string $tipo_impressao = 'pdf') {
    if ($tipo_impressao === 'word') {
        echo <<<HTML
    <tr>
        <td>$oDadosDaLinha->item</td>
        <td>$oDadosDaLinha->descricao</td>
        <td>$oDadosDaLinha->unidadeDeMedida</td>
        <td>$oDadosDaLinha->marca</td>
        <td>$oDadosDaLinha->quantidade</td>
        <td>$oDadosDaLinha->valorUnitario</td>
        <td>$oDadosDaLinha->total</td>
    </tr>
    HTML;
    } else {
        echo <<<HTML
    <div class="tr row">
      <div class="td col-item align-center">
        {$oDadosDaLinha->item}
      </div>

      <div class="td col-descricao-item-layout-antigo align-justify">
        {$oDadosDaLinha->descricao}
      </div>
      <div class="td col-valor_un  align-center">
        {$oDadosDaLinha->unidadeDeMedida}
      </div>
      <div class="td col-valor_un  align-center">
        {$oDadosDaLinha->marca}
      </div>
      <div class="td col-quant align-center">
        {$oDadosDaLinha->quantidade}
      </div>
      <div class="td col-valor_un align-right">
        {$oDadosDaLinha->valorUnitario}
      </div>


      <div class="td col-total align-right">
        {$oDadosDaLinha->total}
      </div>
    </div>
    HTML;
    }
}

function getColspan(string $tipo, string $criterio) {
    if (isCriterioAdjucacaoTipoJulgamentoCabecalhoComPercentual($tipo, $criterio)) {
        return 9;
    } elseif (isCriterioAdjucacaoTipoJulgamentoCabecalhoSemPercentual($tipo, $criterio)) {
        return 8;
    } else {
        return 7;
    }
}

function getEscalaMonetaria(string $valor) {
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '.', $valor);
    $valor_em_float = floatval($valor);

    if($valor_em_float >= 1000) {
        $units = [
            '',
            'K',
            'M',
            'B',
            'T'
        ];

        $log = floor(log($valor_em_float, 1000));

        return $units[$log];
    } else {
        return $valor_em_float;
    }
}
