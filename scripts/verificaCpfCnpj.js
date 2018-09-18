// Verifica CPF e CNPJ zerados

function js_checaCpfCnpj(valorCpf){
    var retorno = true;
    if(valorCpf == '00000000000'){
        alert('O CGM selecionado não possui CPF, corrija o cadastro e em seguida tente novamente.');
        retorno = false;
    }else if(valorCpf == '00000000000000'){
        alert('O CGM selecionado não possui CNPJ, corrija o cadastro e em seguida tente novamente.');
        retorno = false;
    }else if(valorCpf == 0 || valorCpf == ''){
        alert('O CGM selecionado não possui CPF/CNPJ, corrija o cadastro e em seguida tente novamente.');
        retorno = false;
    }

    return retorno;
}
