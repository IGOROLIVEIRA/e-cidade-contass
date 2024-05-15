/** 
 * @fileoverview Define campo do tipo input
 *
 * @author Iuri Guntchnigg iuri@dbseller.com.br
 * @version  $Revision: 1.13 $
 */

/**
 * Cria um input tipo text 
 * @class dbTextInput
 * @constructor
 * @param {string} sName  id do Objeto 
 * @param {string} sNameInstance nome da instancia do objeto, usado para referencia interna  
 * @param {string} sValue valor Default do Objeto  
 * @param {string} sSize tamanho  
 */
DBTextField = function (sName, sNameInstance, sValue, sSize) {

   if ( sSize == undefined ) {
     sSize = 25;    
   }
   if ( sValue == undefined ) {
     sValue = '';    
   }
   this.hasTextArea     = false;
   this.makeTextArea    = false;
   this.sName           = sName;
   this.sValue          = sValue;
   this.sSize           = sSize;
   this.sNameInstance   = sNameInstance;
   this.lReadOnly       = false;
   this.sStringConteudo  = "";
   this.iMaxLength       = "";  
   this.sStringTextarea  = ""; 
   this.onBlur          = "";   
   this.onChange        = "";   
   this.onFocus         = "";   
   this.onKeyPress      = "";   
   this.onKeyUp         = "";   
   this.onKeyDown       = "";   
   this.sStyle          = "";
   this.lExpansible     = false;
   var me               = this;   
   /**
    * Renderiza o input 
    */  
   this.makeInput = function () {
     
     
     this.sStringConteudo  = "<input type    = 'text' ";
     this.sStringConteudo += "        name    = '"+this.sName+"'"; 
     this.sStringConteudo += "        id      = '"+this.sName+"' ";
     this.sStringConteudo += "        value   = '"+this.sValue+"'";
     this.sStringConteudo += "        size    = '"+this.sSize+"'";
     this.sStringConteudo += "        autocomplete = 'off'";
     this.sStringConteudo += "        maxlength    = '"+this.iMaxLength+"'";
     this.sStringConteudo += "        onBlur     = '"+this.onBlur+"'"; 
     this.sStringConteudo += "        onFocus    = '"+this.onFocus+"'"; 
     this.sStringConteudo += "        onKeyPress = '"+this.onKeyPress+"'"; 
     this.sStringConteudo += "        onKeyUp    = '"+this.onKeyUp+"'"; 
     this.sStringConteudo += "        onKeyDown  = '"+this.onKeyDown+"'"; 
     this.sStringConteudo += "        onChange   = '"+this.onChange+"'"; 
     if (this.lReadOnly) {
     
       this.sStringConteudo += " disabled ";
       this.sStyle += " ;background-color:rgb(222, 184, 135);color:black";
     }
     this.sStringConteudo += "        style  = '"+this.sStyle+"'";
     this.sStringConteudo += " > ";
     this.sStringConteudo += this.sStringTextarea; 
    
    }
   /**
    * renderiza o widget no no especificado 
    * @return void
    */
   this.show = function ( oNo ){
      
     this.makeInput(); 
     oNo.innerHTML =  this.sStringConteudo;
     if (this.lReadOnly) {
       this.setReadOnly(this.lReadOnly);
     }
   }
  
   /**
    * retorna o objeto em formato html 
    * @return string
    */
   this.toInnerHtml = function(){
     
     this.makeInput(); 
     return this.sStringConteudo;  
   }
   
   /**
    * deixa o onput com  sua altura extentida no momento que o objeto receber o foco
    * @param bool lExplansible habilita a altura extentida
    * @param integer iHeight altura do texto
    * @param integer iWidth  largura do texto
    */
   this.setExpansible = function (lExplansible, iHeight, iWidth) {
     
     if (iHeight == null) {
       iHeight = 100;
     }
     
     if (iWidth == null) {
       iWidth = 200;
     }
     
     if (!this.makeTextArea) {
     
       this.sStringTextarea  = "<div id='cntTextArea"+this.sName+"' style='position:absolute; ";
       this.sStringTextarea += "     display:none;padding:1px; border:1px solid #999999; background-color: #efefef'>";
       this.sStringTextarea += "   <textarea   id='textarea"+this.sName+"' style='width:"+iWidth+"px; height:"+iHeight+"px' ";
       this.sStringTextarea += "   onblur='"+this.sNameInstance+".hidetextArea()'>";
       this.sStringTextarea +=  this.sValue;
       this.sStringTextarea += "</textarea>";
       this.sStringTextarea += "</div>"; 
       
     }
     if (lExplansible) {
 
       me.lExplansible = true;
       this.addEvent("onFocus",this.sNameInstance+".displayTextArea()");
     }
   } 
   
   /**
    *mostra a text area
    *@private
    */
   this.displayTextArea = function () {
     
     this.positionDiv(); 
     $('cntTextArea'+this.sName).style.display = '';
     $('textarea'+this.sName).focus();
     
   }
   
   /**
    *esconde a textaera
    *@private
    */
   this.hidetextArea = function () {
     
     $(this.sName).value  = $('textarea'+this.sName).value;
     $('cntTextArea'+this.sName).style.display = 'none';
     this.sValue = $('textarea'+this.sName).value;
     
   }
   
   /**
    *Adiciona um evento a funcao
    *@param string sEvent nome do evento
    *@param sFunction string com a funcao a ser executada
    *@example dbTextField.addEvent('onclick', 'alert("ola")'); 
    */
   this.addEvent = function(sEvent, sFunction) {
     
       eval("this."+sEvent+" += sFunction"); 
   }
   
   me.addEvent("onChange", me.sNameInstance+".setValue($F(\""+me.sName+"\"))");
   this.getValue = function () {
     
     var sValor = $F(me.sName);
     if (me.lExplansible) {
       sValor = $("textarea"+me.sName).value;
     }
     return sValor;  
   }
   
   this.setValue = function (sValor) {
   
     me.sValue         = sValor;
     $(me.sName).value = sValor;
     if ($("textarea"+me.sName)) {
       $("textarea"+me.sName).value = sValor;
     }     
   }
   /**
    *Posiciona a div do texto
    *@private
    */
   this.positionDiv = function() {
   
     var el = $(this.sName);
     var me = $(this.sName);
     var x = 0;
     var y = new Number(el.offsetHeight);

     //Walk up the DOM and add up all of the offset positions.
     while (el.offsetParent && el.tagName.toUpperCase() != 'BODY') {
    
       if (el.className != "windowAux12") { 
      
         x += el.offsetLeft;
         y += new Number(el.offsetTop);
        
       }
       el = el.offsetParent;
     }
     
     x += el.offsetLeft ;
     y += new Number(el.offsetTop) -window.scrollTop;
     $('cntTextArea'+this.sName).style.top  = (y-me.offsetHeight-window.scrollTop) + 'px';
     $('cntTextArea'+this.sName).style.left = x + 'px';
    
   };
   
   /**
    *Adiciona uma propriedade css ao input
    * @param string sPropertie nome da propriedade css
    * @param string sValor Valor da proprieade
    */
   this.addStyle = function (sPropertie, sValor) {
     this.sStyle += sPropertie+":"+sValor+";";
   }
   
   /**
    * Define o tamanho maximo de caracteres do campo.
    * @param integer iMaxLength numero maximo de caracteres
    * return void
    */
   this.setMaxLength = function(iMaxLength) {
     
     me.iMaxLength = iMaxLength;
     if ($(me.sName)) {
       $(me.sName).maxLength = iMaxLength;
     }
     return true;
   }
   
   /**
    * Define o campo como somente leitura.
    * @param bollean lReadOnly true somente leitura
    * return void
    */
   this.setReadOnly = function(lReadOnly) {

     me.lReadOnly = lReadOnly;
     if ($(me.sName)) {
	     
	     $(me.sName).readOnly = lReadOnly;
	     if (lReadOnly == false) {
	       $(me.sName).disabled = false;
	     }
	     if (lReadOnly) {
	        
	       $(me.sName).style.backgroundColor= 'rgb(222, 184, 135)';
	     } else {
	       $(me.sName).style.backgroundColor= 'white';
	     }
     }
   }
 }


/**
 * Retorna o Elemento Input do Componente
 * @returns
 */
DBTextField.prototype.getElement = function() {
  
  if ( !$(this.sName) ) {
    throw "Para Chamar este método, primeiro o componente deve ser renderizado via DBTextField.show();";
  }
  return $(this.sName);
};
