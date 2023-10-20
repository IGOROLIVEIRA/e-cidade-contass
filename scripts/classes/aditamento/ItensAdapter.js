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

    this.#aditamento.itens.forEach(item => {
      const itemAdaptado = {};
      itemAdaptado.codigo = codigo;
      itemAdaptado.codigoItem = item.itemSequencial;
      itemAdaptado.controlaquantidade = item.servicoQuantidade == true ? 't' : 'f';
      itemAdaptado.tipocontrole = item.tipoControle == true ? 't' : 'f';

      itemAdaptado.descricaoitem = item.descricaoItem;

      //Dotações
      itemAdaptado.dotacoes = [{ dotacao: "46", quantidade: 12, valor: 20400, valororiginal: "17000" }];
      itemAdaptado.dotacoesoriginal = [{ dotacao: "46", quantidade: 12, valor: 20400, valororiginal: "17000" }];
      itemAdaptado.elemento = 3339036;
      ///

      itemAdaptado.periodoini = vigenciaInicio;
      itemAdaptado.periodofim = vigenciaFim;
      itemAdaptado.qtdeanterior = item.quantidade;
      itemAdaptado.qtdeaditada = 0;
      itemAdaptado.quantidade = item.quantidade;
      itemAdaptado.valoraditado = 0;
      itemAdaptado.valor = item.valorTotal;
      itemAdaptado.valorunitario = item.valorUnitario;
      itemAdaptado.vlunitanterior = item.valorUnitario;
      itensAdaptados.push(itemAdaptado);
    });

    return itensAdaptados;
  }

}
