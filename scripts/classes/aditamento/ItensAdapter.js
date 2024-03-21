class ItensAdapter {
  #aditamento;

  constructor(aditamento) {
    this.#aditamento = aditamento;
  }

  criarItens() {
    const itensAdaptados = [];

    const codigo = this.#aditamento.acordoPosicaoSequencial;


    const vigenciaInicio = this.#aditamento.vigenciaInicio;
    const vigenciaFim = this.#aditamento.vigenciaFim;
    const relacaoItemPcmater = {};

    this.#aditamento.itens.forEach(item => {
      const itemAdaptado = {};

      itemAdaptado.codigo = codigo;
      itemAdaptado.codigoitem = item.codigoPcMater;
      itemAdaptado.acordoitemsequencial = item.itemSequencial;

      let index = '_'+ item.codigoPcMater;
      relacaoItemPcmater[index] = item.itemSequencial


      itemAdaptado.controlaquantidade = item.servicoQuantidade == true ? 't' : 'f';
      itemAdaptado.servico = item.tipoControle;

      itemAdaptado.descricaoitem = item.descricaoItem;

      //mock dotações para manter compatibilidade com função preencherItens
      itemAdaptado.dotacoes = [];
      itemAdaptado.dotacoesoriginal = [];
      itemAdaptado.elemento = 0;

      console.log(item.fimExecucao, vigenciaFim);

      itemAdaptado.periodoini = item.inicioExecucao ?? vigenciaInicio;
      itemAdaptado.periodofim = item.fimExecucao ?? vigenciaFim;
      itemAdaptado.qtdePosicaoanterior = item.quantidadeAnterior > 0 ? item.quantidadeAnterior : item.quantidade;
      itemAdaptado.qtdeanterior = item.quantidade
      itemAdaptado.qtdeaditada = 0;
      itemAdaptado.quantidade = item.quantidade;
      itemAdaptado.valoraditado = 0;
      itemAdaptado.valor = item.valorTotal;
      itemAdaptado.valorunitario = item.valorUnitario;
      itemAdaptado.vlunitPosicaoanterior = item.valorAnteriorUnitario > 0 ? item.valorAnteriorUnitario : item.valorUnitario;
      itemAdaptado.vlunitanterior =  item.valorUnitario;
      itemAdaptado.eExecutado = item.eExecutado;

      itensAdaptados.push(itemAdaptado);
    });

    return { itensAdaptados, relacaoItemPcmater };
  }

}
