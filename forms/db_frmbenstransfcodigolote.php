<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */
?>
<form name="form1" method="post" action="">
<center>
  <table>
    <tr>
      <td>
        <fieldset>
          <legend>Filtro</legend>
           <label><b>Placa:<b/></label>
           <input type="text" id="placa">
        </fieldset>
      </td>
    </tr>
    <tr>
      <td>
        <fieldset>
		      <legend align="center">
		        <b>Bens:</b>
		      </legend>
		      <table cellspacing="0" style="border:2px inset white;" >
		        <tr>
		          <th class="table_header" width="15px"><a href='#' onClick='js_marcaTodos();'>M</a></th>
		          <th class="table_header" width="150px"><b>Cód. Bem       </b></th>
		          <th class="table_header" width="100px"><b>Classificação </b></th>
		          <th class="table_header" width="150px"><b>Descrição      </b></th>
		          <th class="table_header" width="85px"><b>Observação     </b></th>
		          <th class="table_header" width="85px"><b>Placa          </b></th>
		          <th class="table_header" width="85px"><b>Data Aquisição </b></th>
		          <th class="table_header" width="12px"><b>&nbsp;</b></th>
		        </tr>
		        <tbody id="listaBens" style=" overflow:scroll; overflow-x:hidden; background-color:white"  ></tbody>
		      </table>
        </fieldset>
      </td>
    </tr>
    <tr align="center">
      <td>
        <input name="transf" type="submit"  value="Transferência em Lote" onClick="return js_valida();"    >
        <input name="rel"    type="button"  value="Relatório"             onClick="js_imprime();" disabled >
        <input name="con"    type="button"  value="Confirmar"             onClick="js_conTrasfLote();" disabled >
        <?
          db_input("t95_codtran",10,"",true,"hidden");
          db_input("lista"      ,10,"",true,"hidden");
        ?>
      </td>
    </tr>
  </table>
</center>
</form>

<script>


  ///*
  //  Array para recuperar todos os itens marcados quando fizer o uso do filtro da placa e a lista for atualizada.
  //*/
  //var itens = [];
  //
  //let ordenacao = '';
  //document.getElementById('placa').style.width = '100px';
  //document.getElementById('placa').addEventListener("keyup", () => {
  //  let valor = document.form1.placa.value;
  //  filtraBens(valor);
  //});
  //
  //let headers = document.getElementsByTagName('th');
  //
  //for(let cont=0; cont < headers.length - 1; cont++){
  //  headers[cont].style.textDecoration = "underline";
  //  headers[cont].addEventListener('click', () => {
  //    extraiItens(headers[cont].innerText);
  //  });
  //}


function js_pesquisaBens(){


  js_divCarregando(_M('patrimonial.patrimonio.db_frmbenstransfcodigolote.aguarde'),'msgBox');

  var url          = "pat4_consultaBensDeptoRPC.php";
  var sQuery       = "iCodTransf="+document.form1.t95_codtran.value;
  var oAjax        = new Ajax.Request( url, {
                                              method: 'post',
                                              parameters: sQuery,
                                              onComplete: js_retornoBens
                                            }
                                      );

}

function js_retornoBens(oAjax){

  js_removeObj("msgBox");
  objListaBens = eval("("+oAjax.responseText+")");


  if ( objListaBens.lErro && objListaBens.lErro == true ){
    alert(objListaBens.sMensagem.urlDecode());
    return false ;
  }

  preencheLista(objListaBens);
  js_removeObj("msgBox");

}

function js_valida(){

  var aObjChk    = js_getElementbyClass(document.form1,"chk");
  var iLinhas    = aObjChk.length;
  aListaBens = new Array();
  var iIndice    = 0;
  document.form1.lista.value = "";

  for ( var iInd=0; iInd < iLinhas; iInd++ ) {
    if ( aObjChk[iInd].checked == true  ) {
       aListaBens[iIndice] = aObjChk[iInd].id;
       iIndice++;
    }
  }


  if ( aListaBens.length > 0 ) {
    document.form1.lista.value = aListaBens.toString();
  } else {
    alert(_M('patrimonial.patrimonio.db_frmbenstransfcodigolote.selecione_bem'));
    return false;
  }


}


function js_imprime(){

  jan = window.open('pat2_relbenstransf002.php?t96_codtran='+document.form1.t95_codtran.value+'&texto_info=true','','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);

}


function js_marcaTodos(){

  var aObjChk = js_getElementbyClass(document.form1,"chk");
  var iLinhas = aObjChk.length;

  for ( var iInd=0; iInd < iLinhas; iInd++ ) {
    if ( aObjChk[iInd].checked == true  ) {
      aObjChk[iInd].checked = false;
    } else {
      aObjChk[iInd].checked = true;
    }
  }

}

/* Função utilizada para filtrar os registros pela placa */
function filtraBens(placa){
  let novaListaBens = [];
  objListaBens.forEach((bem) => {
    let quantidade = placa.length;
    let stringFinal = '';

    for(let cont=0;cont < quantidade; cont++){
      stringFinal += bem.t52_ident[cont];

      if(stringFinal.includes(placa)){
        novaListaBens.push(bem);
      }
    }
  });

  preencheLista(novaListaBens);

}

function preencheLista(aBens){
  if(!aBens.length){
    preencheLista(objListaBens);
    return;
  }

  var iLinhasBens = aBens.length;
  var sLinha      =  "";

  $('listaBens').innerHTML = '';
  for ( var iInd = 0; iInd < iLinhasBens; iInd++ ) {

    with (aBens[iInd]) {

      var sChecked = "";

      if ( transf == "t" ) {

        sChecked = "checked";
        document.form1.rel.disabled = false;
        document.form1.con.disabled = false;
        document.form1.transf.value = "Alterar";
      }

      sCheck = "<input class='chk' type='checkbox' id='"+t52_bem+"|"+situacao+"' "+sChecked+">";
      let dataFormatada = t52_dtaqu.includes('/') ? t52_dtaqu : js_formatar(t52_dtaqu,"d");

      sLinha +=  "<tr>";
      sLinha +=  "  <td class='linhagrid marcador'>"+sCheck+"                                      </td>";
      sLinha +=  "  <td class='linhagrid'> "+t52_bem.urlDecode()+"&nbsp;                   </td>";
      sLinha +=  "  <td class='linhagrid'> "+t64_descr.urlDecode()+"&nbsp;                 </td>";
      sLinha +=  "  <td class='linhagrid'> "+t52_descr.urlDecode()+"&nbsp;                 </td>";
      sLinha +=  "  <td class='linhagrid'> "+t52_obs.urlDecode()+"&nbsp;                   </td>";
      sLinha +=  "  <td class='linhagrid'> "+t52_ident.urlDecode()+"&nbsp;                 </td>";
      sLinha +=  "  <td class='linhagrid'>"+dataFormatada+"&nbsp;</td>";
      sLinha +=  "  <td class='linhagrid' style='display:none;'>"+transf+"&nbsp;</td>";
      sLinha +=  "  <td class='linhagrid' style='display:none;'>"+situacao+"&nbsp;</td>";
      sLinha +=  "</tr>";

    }
  }
  $('listaBens').innerHTML = sLinha;

  let linhas = document.getElementsByClassName('marcador');

  for(let i in linhas){
    if(linhas[i].children){
      linhas[i].children[0].addEventListener('click', (e)=>{
        if(!itens.includes(e.target.id)){
          itens.push(e.target.id);
        }else{
          itens = itens.filter((element) => {
            return element != e.target.id;
          });
        }
      });
    }
  }

  if(itens.length){
    itens.forEach(elemento => {
      for(let pos in linhas){
        if(linhas[pos].firstChild){
          if(linhas[pos].firstChild.id == elemento){
            linhas[pos].firstChild.setAttribute("checked", "checked");
            break;
          }
        }
      }
    });
  }

}

function extraiItens(campo){

  let childrens = $('listaBens').childNodes;
  let listaBens = [];

  for(let cont=0; cont < childrens.length; cont++){
    let elementsChildrens = childrens[cont].childNodes;
    let contentObject = [];
    for(let cont=0; cont < elementsChildrens.length; cont++){
      if(elementsChildrens[cont].innerText){
        contentObject.push(elementsChildrens[cont].innerText);
      }
    }

    let objeto = new Object({
      't52_bem': contentObject[0].trim(),
      't64_descr': contentObject[1].trim(),
      't52_descr': contentObject[2].trim(),
      't52_obs': contentObject[3].trim(),
      't52_ident': contentObject[4].trim(),
      't52_dtaqu': contentObject[5].trim(),
      'transf': contentObject[6].trim(),
      'situacao': contentObject[7].trim()
    });

    listaBens.push(objeto);

  }

  if(!ordenacao || ordenacao == 'asc'){
    ordenacao = 'desc';
  }else{
    ordenacao = 'asc';
  }

  let aRegistros = [];
  let campoReferencia = '';
  switch(campo){

    case 'Cód. Bem':
    case 'Placa': {

      campoReferencia = campo == 'Placa' ? 't52_ident' : 't52_bem';
      listaBens.forEach(e => {
        aRegistros.push(e[campoReferencia]);
      });

      break;
    }
    case 'Classificação':
    case 'Observação':
    case 'Descrição':{
      campoReferencia = campo == 'Classificação' ? 't64_descr' : campo == 'Descrição' ? 't52_descr' : 't52_obs';
      listaBens.forEach(e => {
        aRegistros.push({
          'valor': e[campoReferencia],
          'chave': e.t52_bem});
      });
      break;
    }

    case 'Data Aquisição':{
      campoReferencia = 't52_dtaqu';

      listaBens.sort(function(a, b){
        return new Date(a.t52_dtaqu.split('/').reverse().join('-')) - new Date(b.t52_dtaqu.split('/').reverse().join('-'))})
      .forEach(item => {
        aRegistros.push(item);
      });

      break;
    }
  }

  ordenaLista(listaBens, aRegistros, campoReferencia);
}


function ordenaLista(listaGeral, listaReferencia, campo)
{
  let listaOrdenada = [];

  switch(ordenacao){
    case 'asc':{

      if(campo == 't52_bem' || campo == 't52_ident'){
        listaReferencia.sort((a, b) => {return a-b})
        .forEach(item => {
          listaGeral.forEach(bem => {
            if(bem[campo] == item){
              listaOrdenada.push(bem);
            }
          })
        })
      }

      if(campo == 't64_descr' || campo == 't52_descr' || campo == 't52_obs'){
        listaReferencia.sort((a, b) => {
          if(a.valor == b.valor){
            return Number(a.chave)-Number(b.chave);
          }
          return a.valor > b.valor;
        }).forEach(item => {
            listaGeral.forEach( bem => {
            if(bem.t52_bem == item.chave){
              listaOrdenada.push(bem);
            }
          })
        })
      }

      if(campo == 't52_dtaqu'){
        listaGeral.sort((a, b) => {
          let dtA = new Date(a.t52_dtaqu.split('/').reverse().join('-'));
          let dtB = new Date(b.t52_dtaqu.split('/').reverse().join('-'));
          if(dtB == dtA){
            return Number(a.t52_bem) - Number(b.t52_bem);
          }
          return dtA - dtB
        }).forEach(item => {
          listaOrdenada.push(item);
        });
      }
      break;
    }


    case 'desc':{

      if(campo == 't52_bem' || campo == 't52_ident'){
        listaReferencia.sort(function(a, b){return b-a})
        .forEach(item => {
          listaGeral.forEach(bem => {
            if(bem[campo] == item){
              listaOrdenada.push(bem);
            }
          })
        });
      }

      if(campo == 't64_descr' || campo == 't52_descr' || campo == 't52_obs'){
        listaReferencia.sort((a, b) => {
          if(a.valor == b.valor){
            return Number(b.chave)-Number(a.chave);
          }
          return b.valor > a.valor;
        }).forEach(item => {
          listaGeral.forEach( bem => {
            if(bem.t52_bem == item.chave){
              listaOrdenada.push(bem);
            }
          })
        })
      }

      if(campo == 't52_dtaqu'){
        listaGeral.sort(function(a, b){
          let dtA = new Date(a.t52_dtaqu.split('/').reverse().join('-'));
          let dtB = new Date(b.t52_dtaqu.split('/').reverse().join('-'));
          if(dtB == dtA){
            return Number(b.t52_bem) - Number(a.t52_bem);
          }
          return dtB - dtA;
        }).forEach(item => {
          listaOrdenada.push(item);
        });
      }

      break;
    }
  }

  preencheLista(listaOrdenada);
}

function js_conTrasfLote() {
    let t96_codtran = document.form1.t95_codtran.value;

    try {
        realizaTransfLote({
            exec: 'Transferir',
            t96_codtran: t96_codtran,
        }, oRetTransfLote);
    } catch(e) {
        alert(e.toString());
    }
    return false;
}

function realizaTransfLote(params, onComplete) {
    js_divCarregando('Aguarde Realizando Transferencia', 'div_aguarde');
    var request = new Ajax.Request('pat1_benstransfdireta.RPC.php', {
        method:'post',
        parameters:'json=' + JSON.stringify(params),
        onComplete: function(oRetornotransf) {
            // js_removeObj('div_aguarde');
            onComplete(oRetornotransf);
        }
    });
}

function oRetTransfLote(res) {
    var response = JSON.parse(res.responseText);
    js_removeObj('div_aguarde');
    if (response.status != 1) {
        alert(response.erro);

    } else if (response.erro == false) {

        alert('Transferencia Realizada com Sucesso !');

        if(confirm('Deseja imprimir relatorio?')) {

            jan = window.open('pat2_relbenstransf002.php?t96_codtran='+document.getElementById('t95_codtran').value+'&texto_info=true','','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
            document.form1.t96_codtran.style.backgroundColor='';
            jan.moveTo(0,0);
        }
    }
}


</script>
