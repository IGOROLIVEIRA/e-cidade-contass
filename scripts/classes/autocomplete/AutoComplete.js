
performsAutoComplete = function(oAjax) 
{
    
    var oRetorno = JSON.parse(oAjax.responseText);
    "use strict"; 
   
    // Obter elementos do DOM com base nas propriedades do objeto oRetorno
    let inputFieldDescription = document.getElementById(oRetorno.inputField);
    let inputFieldCode        = document.getElementById(oRetorno.inputCodigo);
    let ulFieldDiv            = document.getElementById(oRetorno.ulField);
  
    inputFieldDescription.addEventListener('input', changeAutoComplete);
    ulFieldDiv.addEventListener('click', selectItem);
  
    function changeAutoComplete({ target }) {
      let data = target.value;
      var divfechar = ulFieldDiv.style;
      ulFieldDiv.innerHTML = ``;
  
      if (data.length > 2) {
      
        let autoCompleteValues = autoComplete(data);
        autoCompleteValues.forEach(value => { addItem(value); });
        divfechar.display = 'block';
      }
  
      if (data.length == 0) {
        divfechar.display = 'none';
        inputFieldCode.value = '';
      }
    }
    function autoComplete(inputValue) {
      
      inputValue = removerAcentos(inputValue);
     
      let destination = [];
      for (var i = 0; i < oRetorno.oDados.length; i++) {
        if (oRetorno.oDados[i].campo3) {
          destination.push(oRetorno.oDados[i].campo1 + "  -  " + oRetorno.oDados[i].campo2 + "  -  " + oRetorno.oDados[i].campo3);
        } else {
          destination.push(oRetorno.oDados[i].campo1 + "  -  " + oRetorno.oDados[i].campo2);
        }
      }
      return destination.filter(
        (value) => value.toLowerCase().includes(inputValue.toLowerCase())
      );
    }
  
    function addItem(value) {
      ulFieldDiv.innerHTML = ulFieldDiv.innerHTML + `<li>${value}</li>`;
    }
  
    // Função para selecionar um item da ulFieldDiv quando o usuário clica nele
    function selectItem({ target }) {
      if (target.tagName === 'LI') {
        var dados = target.textContent.split("  -  ");
        inputFieldDescription.value = dados[1]; // Atualizar o valor do inputFieldDescription com o segundo campo
        inputFieldCode.value = dados[0]; // Atualizar o valor do inputFieldCode com o primeiro campo
  
        // Limpar a ulFieldDiv e ocultá-la após a seleção do item
        ulFieldDiv.innerHTML = ``;
        var divfechar = ulFieldDiv.style;
        divfechar.display = 'none'; 
      }
      
    }

    function removerAcentos(str) {
      const acentosMap = {
        'á': 'a', 'à': 'a', 'ã': 'a', 'â': 'a', 'ä': 'a', 'é': 'e', 'è': 'e', 'ê': 'e', 'ë': 'e',
        'í': 'i', 'ì': 'i', 'î': 'i', 'ï': 'i', 'ó': 'o', 'ò': 'o', 'õ': 'o', 'ô': 'o', 'ö': 'o',
        'ú': 'u', 'ù': 'u', 'û': 'u', 'ü': 'u', 'ç': 'c', 'Á': 'A', 'À': 'A', 'Ã': 'A', 'Â': 'A',
        'Ä': 'A', 'É': 'E', 'È': 'E', 'Ê': 'E', 'Ë': 'E', 'Í': 'I', 'Ì': 'I', 'Î': 'I', 'Ï': 'I',
        'Ó': 'O', 'Ò': 'O', 'Õ': 'O', 'Ô': 'O', 'Ö': 'O', 'Ú': 'U', 'Ù': 'U', 'Û': 'U', 'Ü': 'U',
        'Ç': 'C'
      };
    
       return str.replace(/[áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÔÖÚÙÛÜÇ]/g, (match) => acentosMap[match]);
    }
     
  };
  