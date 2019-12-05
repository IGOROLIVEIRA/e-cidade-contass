function validaCaracteres(valor, preenche=null){
  let erro = '';
  let valorFinal = '';
  valor = valor.toString();
  let aValor = valor.split('.');
  let decimais = '';

  if(valor.includes('.')){
    if(aValor[1].length > 4){
      decimais = aValor[1];
      aValor[1] = decimais.substr(0, 4);
      erro = 'É permitida a inserção de até 4 casas decimais';
    }
  }

  if(preenche){
    let decimais = aValor.length == 2 ? aValor[1] : '0';
    while(decimais.length < 4){
      decimais+='0';
    }
    aValor[1] = decimais;
    erro = '';
  }
  valorFinal = aValor.join('.');
  return [erro, valorFinal];
}
