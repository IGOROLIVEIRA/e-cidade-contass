function js_roundDecimal(x,qtdCasasDecimais) {
    if(qtdCasasDecimais == null || qtdCasasDecimais == undefined){
        console.log("Quantidade de casas decimais não informada! Retornando o valor original.");
        return x;
    }

    x = x.toString().replace(',','.');
    x = parseFloat(x);

    if(Number.isInteger(x)){
        return x;
    }

    var radixPos = String(x).indexOf('.');

    // slice para pegar a porção do número após o ponto (.)
    var value = String(x).slice(radixPos+1);

    var k = Array.from(value.toString()).map(Number);
    var temp = 0;

    for (var i = k.length - 1; i >= 0; i--) {
        k[i] += temp;
        temp = 0;
        if(k[i] >= 5 && i >= qtdCasasDecimais){
            temp = 1;
        }

        if(k[i] > 9){
            if(i <= (qtdCasasDecimais-1)){
                temp = 1;
            }
            k[i] = 0;
        }
    }

    // Renderizar resultado final
    var render = "";
    for(var i = 0; i < qtdCasasDecimais; i++){
        if(k[i] != undefined){
            render += k[i];
        }
    }

    render = String(Math.floor(x)+temp)+"."+render;



    return parseFloat(render);
}
