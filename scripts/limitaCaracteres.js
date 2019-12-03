function validaCaracteres(valor, campo){
    let valorFinal = '';
    let erro = '';
    if(valor.includes('.')){
      let aValor = valor.split('.');
      if(aValor[1].length > 4){
        let decimais = aValor[1];
        aValor[1] = decimais.substr(0, 4);
        valorFinal = aValor.join('.');
        // alert('� permitida a inser��o de at� 4 casas decimais');
        erro = '� permitida a inser��o de at� 4 casas decimais';
        return [erro, valorFinal];
      }
    }
    return [erro, valor];
}
