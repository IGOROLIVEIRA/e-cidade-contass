var formTabAtiv = document.form1;
var mostraCamposDadosExtras = formTabAtiv.mostraCamposDadosExtras;
var escondeCamposDadosExtras = formTabAtiv.escondeCamposDadosExtras;

mostraCamposDadosExtras.addEventListener("click", function(){
   FrmTabAtivManager.mostraCamposDadosExtras(this);
});

escondeCamposDadosExtras.addEventListener("click", function(){
   FrmTabAtivManager.escondeCamposDadosExtras();
});

if(bHasIsencao){
   FrmTabAtivManager.mostraCamposDadosExtras(mostraCamposDadosExtras);
}