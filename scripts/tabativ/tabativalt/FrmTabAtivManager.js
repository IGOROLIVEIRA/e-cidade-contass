var FrmTabAtivManager = (function (){

    var formTabAtiv = document.form1;

    var mostraCamposDadosExtras =  function(inputId) {
        inputId.checked = true;
        mostraCampos(inputId.value);
    };

    var escondeCamposDadosExtras = function() {
        var aCampos = Array.prototype.slice.call(document.getElementsByClassName('camposIsencao'));
        _escondeCampos(aCampos);
    };

    var _limpaCamposIsencao = function() {
        console.log("a");
       formTabAtiv.q07_dataini_isen.value = "";
       formTabAtiv.q07_datafim_isen.value = "";
       formTabAtiv.q07_aliquota_incentivo.value = "";
       formTabAtiv.q07_justificaisencao.value = "";
    };

    var _escondeCampos = function(arrCampos) {
        arrCampos.forEach(function (item) {
            item.style.display = "none";
        });
        _limpaCamposIsencao();
    };

    var _mostraCampos = function (arrCampos) {
        arrCampos.forEach(function (item) {
            item.style.display = "";
        });
    };

    var mostraCampos = function (className) {
        var aCamposIsencao = document.getElementsByClassName(className);
        var aCampos = Array.prototype.slice.call(aCamposIsencao);
        _mostraCampos(aCampos);
    };

    var _getAliquotasSimples = function (start, end) {
        var arr = [];

        while (start < end) {
            arr.push((Number(start).toFixed(2)).replace('.',','));
            start+=0.01;
        }

        return arr;
    };

    return {
        mostraCamposDadosExtras: mostraCamposDadosExtras,
        escondeCamposDadosExtras: escondeCamposDadosExtras
    }
})();