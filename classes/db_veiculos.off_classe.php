<?
//MODULO: agenda
//CLASSE DA ENTIDADE veiculos.off
class cl_veiculos.off { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $numrows_incluir = 0; 
   var $numrows_alterar = 0; 
   var $numrows_excluir = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $erro_campo = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $u01_codvei = 0; 
   var $u01_placa = null; 
   var $u01_patri = null; 
   var $u01_tipo = 0; 
   var $u01_marca = null; 
   var $u01_modelo = null; 
   var $u01_cor = null; 
   var $u01_chassi = null; 
   var $u01_certif = 0; 
   var $u01_capaci = null; 
   var $u01_kmini = 0; 
   var $u01_dtqui_dia = null; 
   var $u01_dtqui_mes = null; 
   var $u01_dtqui_ano = null; 
   var $u01_dtqui = null; 
   var $u01_combus = null; 
   var $u01_categ = null; 
   var $u01_segcom = null; 
   var $u01_segapo = null; 
   var $u01_segven_dia = null; 
   var $u01_segven_mes = null; 
   var $u01_segven_ano = null; 
   var $u01_segven = null; 
   var $u01_ano = 0; 
   var $u01_numcgm = 0; 
   var $u01_dtbaix_dia = null; 
   var $u01_dtbaix_mes = null; 
   var $u01_dtbaix_ano = null; 
   var $u01_dtbaix = null; 
   var $u01_motivo = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 u01_codvei = int4 = Codigo do Veiculo 
                 u01_placa = char(     7) = Placa do Veiculo 
                 u01_patri = char(    13) = Codigo de classificacao patrim 
                 u01_tipo = int4 = Codigo do Tipo do Veiculo 
                 u01_marca = char(    20) = Marca do Veiculo 
                 u01_modelo = char(    20) = Modelo do Veiculo 
                 u01_cor = char(    20) = Cor do Veiculo 
                 u01_chassi = char(    30) = Numero do Chassi 
                 u01_certif = int4 = Numero do Certificado 
                 u01_capaci = char(    20) = Capacidade de carga 
                 u01_kmini = float8 = Km inicial 
                 u01_dtqui = date = Data de Aquisicao 
                 u01_combus = char(     1) = Tipo de combustivel 
                 u01_categ = char(     3) = Categoria exigida para habilit 
                 u01_segcom = char(    30) = Nome da Cia de Seguros 
                 u01_segapo = char(    15) = Numero da apolice de seguro 
                 u01_segven = date = Data de Vencimento do Seguro 
                 u01_ano = int4 = Ano de Fabricacao 
                 u01_numcgm = int4 = Numero CGM 
                 u01_dtbaix = date = Data da baixa 
                 u01_motivo = char(    40) = Motivo da Baixa do veiculo 
                 ";
   //funcao construtor da classe 
   function cl_veiculos.off() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("veiculos.off"); 
     $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
   }
   //funcao erro 
   function erro($mostra,$retorna) { 
     if(($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )){
        echo "<script>alert(\"".$this->erro_msg."\");</script>";
        if($retorna==true){
           echo "<script>location.href='".$this->pagina_retorno."'</script>";
        }
     }
   }
   // funcao para atualizar campos
   function atualizacampos($exclusao=false) {
     if($exclusao==false){
       $this->u01_codvei = ($this->u01_codvei == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_codvei"]:$this->u01_codvei);
       $this->u01_placa = ($this->u01_placa == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_placa"]:$this->u01_placa);
       $this->u01_patri = ($this->u01_patri == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_patri"]:$this->u01_patri);
       $this->u01_tipo = ($this->u01_tipo == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_tipo"]:$this->u01_tipo);
       $this->u01_marca = ($this->u01_marca == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_marca"]:$this->u01_marca);
       $this->u01_modelo = ($this->u01_modelo == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_modelo"]:$this->u01_modelo);
       $this->u01_cor = ($this->u01_cor == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_cor"]:$this->u01_cor);
       $this->u01_chassi = ($this->u01_chassi == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_chassi"]:$this->u01_chassi);
       $this->u01_certif = ($this->u01_certif == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_certif"]:$this->u01_certif);
       $this->u01_capaci = ($this->u01_capaci == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_capaci"]:$this->u01_capaci);
       $this->u01_kmini = ($this->u01_kmini == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_kmini"]:$this->u01_kmini);
       if($this->u01_dtqui == ""){
         $this->u01_dtqui_dia = ($this->u01_dtqui_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_dtqui_dia"]:$this->u01_dtqui_dia);
         $this->u01_dtqui_mes = ($this->u01_dtqui_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_dtqui_mes"]:$this->u01_dtqui_mes);
         $this->u01_dtqui_ano = ($this->u01_dtqui_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_dtqui_ano"]:$this->u01_dtqui_ano);
         if($this->u01_dtqui_dia != ""){
            $this->u01_dtqui = $this->u01_dtqui_ano."-".$this->u01_dtqui_mes."-".$this->u01_dtqui_dia;
         }
       }
       $this->u01_combus = ($this->u01_combus == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_combus"]:$this->u01_combus);
       $this->u01_categ = ($this->u01_categ == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_categ"]:$this->u01_categ);
       $this->u01_segcom = ($this->u01_segcom == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_segcom"]:$this->u01_segcom);
       $this->u01_segapo = ($this->u01_segapo == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_segapo"]:$this->u01_segapo);
       if($this->u01_segven == ""){
         $this->u01_segven_dia = ($this->u01_segven_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_segven_dia"]:$this->u01_segven_dia);
         $this->u01_segven_mes = ($this->u01_segven_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_segven_mes"]:$this->u01_segven_mes);
         $this->u01_segven_ano = ($this->u01_segven_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_segven_ano"]:$this->u01_segven_ano);
         if($this->u01_segven_dia != ""){
            $this->u01_segven = $this->u01_segven_ano."-".$this->u01_segven_mes."-".$this->u01_segven_dia;
         }
       }
       $this->u01_ano = ($this->u01_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_ano"]:$this->u01_ano);
       $this->u01_numcgm = ($this->u01_numcgm == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_numcgm"]:$this->u01_numcgm);
       if($this->u01_dtbaix == ""){
         $this->u01_dtbaix_dia = ($this->u01_dtbaix_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_dtbaix_dia"]:$this->u01_dtbaix_dia);
         $this->u01_dtbaix_mes = ($this->u01_dtbaix_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_dtbaix_mes"]:$this->u01_dtbaix_mes);
         $this->u01_dtbaix_ano = ($this->u01_dtbaix_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_dtbaix_ano"]:$this->u01_dtbaix_ano);
         if($this->u01_dtbaix_dia != ""){
            $this->u01_dtbaix = $this->u01_dtbaix_ano."-".$this->u01_dtbaix_mes."-".$this->u01_dtbaix_dia;
         }
       }
       $this->u01_motivo = ($this->u01_motivo == ""?@$GLOBALS["HTTP_POST_VARS"]["u01_motivo"]:$this->u01_motivo);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){ 
      $this->atualizacampos();
     if($this->u01_codvei == null ){ 
       $this->erro_sql = " Campo Codigo do Veiculo nao Informado.";
       $this->erro_campo = "u01_codvei";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_placa == null ){ 
       $this->erro_sql = " Campo Placa do Veiculo nao Informado.";
       $this->erro_campo = "u01_placa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_patri == null ){ 
       $this->erro_sql = " Campo Codigo de classificacao patrim nao Informado.";
       $this->erro_campo = "u01_patri";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_tipo == null ){ 
       $this->erro_sql = " Campo Codigo do Tipo do Veiculo nao Informado.";
       $this->erro_campo = "u01_tipo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_marca == null ){ 
       $this->erro_sql = " Campo Marca do Veiculo nao Informado.";
       $this->erro_campo = "u01_marca";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_modelo == null ){ 
       $this->erro_sql = " Campo Modelo do Veiculo nao Informado.";
       $this->erro_campo = "u01_modelo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_cor == null ){ 
       $this->erro_sql = " Campo Cor do Veiculo nao Informado.";
       $this->erro_campo = "u01_cor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_chassi == null ){ 
       $this->erro_sql = " Campo Numero do Chassi nao Informado.";
       $this->erro_campo = "u01_chassi";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_certif == null ){ 
       $this->erro_sql = " Campo Numero do Certificado nao Informado.";
       $this->erro_campo = "u01_certif";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_capaci == null ){ 
       $this->erro_sql = " Campo Capacidade de carga nao Informado.";
       $this->erro_campo = "u01_capaci";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_kmini == null ){ 
       $this->erro_sql = " Campo Km inicial nao Informado.";
       $this->erro_campo = "u01_kmini";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_dtqui == null ){ 
       $this->erro_sql = " Campo Data de Aquisicao nao Informado.";
       $this->erro_campo = "u01_dtqui_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_combus == null ){ 
       $this->erro_sql = " Campo Tipo de combustivel nao Informado.";
       $this->erro_campo = "u01_combus";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_categ == null ){ 
       $this->erro_sql = " Campo Categoria exigida para habilit nao Informado.";
       $this->erro_campo = "u01_categ";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_segcom == null ){ 
       $this->erro_sql = " Campo Nome da Cia de Seguros nao Informado.";
       $this->erro_campo = "u01_segcom";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_segapo == null ){ 
       $this->erro_sql = " Campo Numero da apolice de seguro nao Informado.";
       $this->erro_campo = "u01_segapo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_segven == null ){ 
       $this->erro_sql = " Campo Data de Vencimento do Seguro nao Informado.";
       $this->erro_campo = "u01_segven_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_ano == null ){ 
       $this->erro_sql = " Campo Ano de Fabricacao nao Informado.";
       $this->erro_campo = "u01_ano";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_numcgm == null ){ 
       $this->erro_sql = " Campo Numero CGM nao Informado.";
       $this->erro_campo = "u01_numcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_dtbaix == null ){ 
       $this->erro_sql = " Campo Data da baixa nao Informado.";
       $this->erro_campo = "u01_dtbaix_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->u01_motivo == null ){ 
       $this->erro_sql = " Campo Motivo da Baixa do veiculo nao Informado.";
       $this->erro_campo = "u01_motivo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into veiculos.off(
                                       u01_codvei 
                                      ,u01_placa 
                                      ,u01_patri 
                                      ,u01_tipo 
                                      ,u01_marca 
                                      ,u01_modelo 
                                      ,u01_cor 
                                      ,u01_chassi 
                                      ,u01_certif 
                                      ,u01_capaci 
                                      ,u01_kmini 
                                      ,u01_dtqui 
                                      ,u01_combus 
                                      ,u01_categ 
                                      ,u01_segcom 
                                      ,u01_segapo 
                                      ,u01_segven 
                                      ,u01_ano 
                                      ,u01_numcgm 
                                      ,u01_dtbaix 
                                      ,u01_motivo 
                       )
                values (
                                $this->u01_codvei 
                               ,'$this->u01_placa' 
                               ,'$this->u01_patri' 
                               ,$this->u01_tipo 
                               ,'$this->u01_marca' 
                               ,'$this->u01_modelo' 
                               ,'$this->u01_cor' 
                               ,'$this->u01_chassi' 
                               ,$this->u01_certif 
                               ,'$this->u01_capaci' 
                               ,$this->u01_kmini 
                               ,".($this->u01_dtqui == "null" || $this->u01_dtqui == ""?"null":"'".$this->u01_dtqui."'")." 
                               ,'$this->u01_combus' 
                               ,'$this->u01_categ' 
                               ,'$this->u01_segcom' 
                               ,'$this->u01_segapo' 
                               ,".($this->u01_segven == "null" || $this->u01_segven == ""?"null":"'".$this->u01_segven."'")." 
                               ,$this->u01_ano 
                               ,$this->u01_numcgm 
                               ,".($this->u01_dtbaix == "null" || $this->u01_dtbaix == ""?"null":"'".$this->u01_dtbaix."'")." 
                               ,'$this->u01_motivo' 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Contem o cadastro de todos os veiculos e maquinas () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Contem o cadastro de todos os veiculos e maquinas já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Contem o cadastro de todos os veiculos e maquinas () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   } 
   // funcao para alteracao
   function alterar ( $oid=null ) { 
      $this->atualizacampos();
     $sql = " update veiculos.off set ";
     $virgula = "";
     if(trim($this->u01_codvei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_codvei"])){ 
       $sql  .= $virgula." u01_codvei = $this->u01_codvei ";
       $virgula = ",";
       if(trim($this->u01_codvei) == null ){ 
         $this->erro_sql = " Campo Codigo do Veiculo nao Informado.";
         $this->erro_campo = "u01_codvei";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_placa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_placa"])){ 
       $sql  .= $virgula." u01_placa = '$this->u01_placa' ";
       $virgula = ",";
       if(trim($this->u01_placa) == null ){ 
         $this->erro_sql = " Campo Placa do Veiculo nao Informado.";
         $this->erro_campo = "u01_placa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_patri)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_patri"])){ 
       $sql  .= $virgula." u01_patri = '$this->u01_patri' ";
       $virgula = ",";
       if(trim($this->u01_patri) == null ){ 
         $this->erro_sql = " Campo Codigo de classificacao patrim nao Informado.";
         $this->erro_campo = "u01_patri";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_tipo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_tipo"])){ 
       $sql  .= $virgula." u01_tipo = $this->u01_tipo ";
       $virgula = ",";
       if(trim($this->u01_tipo) == null ){ 
         $this->erro_sql = " Campo Codigo do Tipo do Veiculo nao Informado.";
         $this->erro_campo = "u01_tipo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_marca)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_marca"])){ 
       $sql  .= $virgula." u01_marca = '$this->u01_marca' ";
       $virgula = ",";
       if(trim($this->u01_marca) == null ){ 
         $this->erro_sql = " Campo Marca do Veiculo nao Informado.";
         $this->erro_campo = "u01_marca";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_modelo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_modelo"])){ 
       $sql  .= $virgula." u01_modelo = '$this->u01_modelo' ";
       $virgula = ",";
       if(trim($this->u01_modelo) == null ){ 
         $this->erro_sql = " Campo Modelo do Veiculo nao Informado.";
         $this->erro_campo = "u01_modelo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_cor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_cor"])){ 
       $sql  .= $virgula." u01_cor = '$this->u01_cor' ";
       $virgula = ",";
       if(trim($this->u01_cor) == null ){ 
         $this->erro_sql = " Campo Cor do Veiculo nao Informado.";
         $this->erro_campo = "u01_cor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_chassi)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_chassi"])){ 
       $sql  .= $virgula." u01_chassi = '$this->u01_chassi' ";
       $virgula = ",";
       if(trim($this->u01_chassi) == null ){ 
         $this->erro_sql = " Campo Numero do Chassi nao Informado.";
         $this->erro_campo = "u01_chassi";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_certif)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_certif"])){ 
       $sql  .= $virgula." u01_certif = $this->u01_certif ";
       $virgula = ",";
       if(trim($this->u01_certif) == null ){ 
         $this->erro_sql = " Campo Numero do Certificado nao Informado.";
         $this->erro_campo = "u01_certif";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_capaci)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_capaci"])){ 
       $sql  .= $virgula." u01_capaci = '$this->u01_capaci' ";
       $virgula = ",";
       if(trim($this->u01_capaci) == null ){ 
         $this->erro_sql = " Campo Capacidade de carga nao Informado.";
         $this->erro_campo = "u01_capaci";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_kmini)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_kmini"])){ 
       $sql  .= $virgula." u01_kmini = $this->u01_kmini ";
       $virgula = ",";
       if(trim($this->u01_kmini) == null ){ 
         $this->erro_sql = " Campo Km inicial nao Informado.";
         $this->erro_campo = "u01_kmini";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_dtqui)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_dtqui_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["u01_dtqui_dia"] !="") ){ 
       $sql  .= $virgula." u01_dtqui = '$this->u01_dtqui' ";
       $virgula = ",";
       if(trim($this->u01_dtqui) == null ){ 
         $this->erro_sql = " Campo Data de Aquisicao nao Informado.";
         $this->erro_campo = "u01_dtqui_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["u01_dtqui_dia"])){ 
         $sql  .= $virgula." u01_dtqui = null ";
         $virgula = ",";
         if(trim($this->u01_dtqui) == null ){ 
           $this->erro_sql = " Campo Data de Aquisicao nao Informado.";
           $this->erro_campo = "u01_dtqui_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->u01_combus)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_combus"])){ 
       $sql  .= $virgula." u01_combus = '$this->u01_combus' ";
       $virgula = ",";
       if(trim($this->u01_combus) == null ){ 
         $this->erro_sql = " Campo Tipo de combustivel nao Informado.";
         $this->erro_campo = "u01_combus";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_categ)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_categ"])){ 
       $sql  .= $virgula." u01_categ = '$this->u01_categ' ";
       $virgula = ",";
       if(trim($this->u01_categ) == null ){ 
         $this->erro_sql = " Campo Categoria exigida para habilit nao Informado.";
         $this->erro_campo = "u01_categ";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_segcom)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_segcom"])){ 
       $sql  .= $virgula." u01_segcom = '$this->u01_segcom' ";
       $virgula = ",";
       if(trim($this->u01_segcom) == null ){ 
         $this->erro_sql = " Campo Nome da Cia de Seguros nao Informado.";
         $this->erro_campo = "u01_segcom";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_segapo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_segapo"])){ 
       $sql  .= $virgula." u01_segapo = '$this->u01_segapo' ";
       $virgula = ",";
       if(trim($this->u01_segapo) == null ){ 
         $this->erro_sql = " Campo Numero da apolice de seguro nao Informado.";
         $this->erro_campo = "u01_segapo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_segven)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_segven_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["u01_segven_dia"] !="") ){ 
       $sql  .= $virgula." u01_segven = '$this->u01_segven' ";
       $virgula = ",";
       if(trim($this->u01_segven) == null ){ 
         $this->erro_sql = " Campo Data de Vencimento do Seguro nao Informado.";
         $this->erro_campo = "u01_segven_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["u01_segven_dia"])){ 
         $sql  .= $virgula." u01_segven = null ";
         $virgula = ",";
         if(trim($this->u01_segven) == null ){ 
           $this->erro_sql = " Campo Data de Vencimento do Seguro nao Informado.";
           $this->erro_campo = "u01_segven_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->u01_ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_ano"])){ 
       $sql  .= $virgula." u01_ano = $this->u01_ano ";
       $virgula = ",";
       if(trim($this->u01_ano) == null ){ 
         $this->erro_sql = " Campo Ano de Fabricacao nao Informado.";
         $this->erro_campo = "u01_ano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_numcgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_numcgm"])){ 
       $sql  .= $virgula." u01_numcgm = $this->u01_numcgm ";
       $virgula = ",";
       if(trim($this->u01_numcgm) == null ){ 
         $this->erro_sql = " Campo Numero CGM nao Informado.";
         $this->erro_campo = "u01_numcgm";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->u01_dtbaix)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_dtbaix_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["u01_dtbaix_dia"] !="") ){ 
       $sql  .= $virgula." u01_dtbaix = '$this->u01_dtbaix' ";
       $virgula = ",";
       if(trim($this->u01_dtbaix) == null ){ 
         $this->erro_sql = " Campo Data da baixa nao Informado.";
         $this->erro_campo = "u01_dtbaix_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["u01_dtbaix_dia"])){ 
         $sql  .= $virgula." u01_dtbaix = null ";
         $virgula = ",";
         if(trim($this->u01_dtbaix) == null ){ 
           $this->erro_sql = " Campo Data da baixa nao Informado.";
           $this->erro_campo = "u01_dtbaix_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->u01_motivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["u01_motivo"])){ 
       $sql  .= $virgula." u01_motivo = '$this->u01_motivo' ";
       $virgula = ",";
       if(trim($this->u01_motivo) == null ){ 
         $this->erro_sql = " Campo Motivo da Baixa do veiculo nao Informado.";
         $this->erro_campo = "u01_motivo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
$sql .= "oid = '$oid'";     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Contem o cadastro de todos os veiculos e maquinas nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Contem o cadastro de todos os veiculos e maquinas nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ( $oid=null ,$dbwhere=null) { 
     $sql = " delete from veiculos.off
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
       $sql2 = "oid = '$oid'";
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Contem o cadastro de todos os veiculos e maquinas nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Contem o cadastro de todos os veiculos e maquinas nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   function sql_record($sql) { 
     $result = db_query($sql);
     if($result==false){
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:veiculos.off";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
}
?>
