<?
//MODULO: orcamento
//CLASSE DA ENTIDADE ppaleidadocomplementar
class cl_ppaleidadocomplementar { 
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
   var $o142_sequencial = 0; 
   var $o142_ppalei = 0; 
   var $o142_anoinicialppa = 0; 
   var $o142_anofinalppa = 0; 
   var $o142_numeroleippa = null; 
   var $o142_dataleippa_dia = null; 
   var $o142_dataleippa_mes = null; 
   var $o142_dataleippa_ano = null; 
   var $o142_dataleippa = null; 
   var $o142_datapublicacaoppa_dia = null; 
   var $o142_datapublicacaoppa_mes = null; 
   var $o142_datapublicacaoppa_ano = null; 
   var $o142_datapublicacaoppa = null; 
   var $o142_leialteracaoppa = null; 
   var $o142_dataalteracaoppa_dia = null; 
   var $o142_dataalteracaoppa_mes = null; 
   var $o142_dataalteracaoppa_ano = null; 
   var $o142_dataalteracaoppa = null; 
   var $o142_datapubalteracao_dia = null; 
   var $o142_datapubalteracao_mes = null; 
   var $o142_datapubalteracao_ano = null; 
   var $o142_datapubalteracao = null; 
   var $o142_datapublicacaoldo_dia = null; 
   var $o142_datapublicacaoldo_mes = null; 
   var $o142_datapublicacaoldo_ano = null; 
   var $o142_datapublicacaoldo = null; 
   var $o142_dataldo_dia = null; 
   var $o142_dataldo_mes = null; 
   var $o142_dataldo_ano = null; 
   var $o142_dataldo = null; 
   var $o142_numeroloa = null; 
   var $o142_dataloa_dia = null; 
   var $o142_dataloa_mes = null; 
   var $o142_dataloa_ano = null; 
   var $o142_dataloa = null; 
   var $o142_datapubloa_dia = null; 
   var $o142_datapubloa_mes = null; 
   var $o142_datapubloa_ano = null; 
   var $o142_datapubloa = null; 
   var $o142_percsuplementacao = 0; 
   var $o142_percaro = 0; 
   var $o142_percopercredito = 0; 
   var $o142_orcmodalidadeaplic = null;
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 o142_sequencial = int8 = Codigo Sequencial 
                 o142_ppalei = int4 = Código da Lei do PPA 
                 o142_anoinicialppa = int4 = Ano Inicial 
                 o142_anofinalppa = int4 = Ano Final 
                 o142_numeroleippa = varchar(50) = Número da Lei 
                 o142_dataleippa = date = Data da Lei 
                 o142_datapublicacaoppa = date = Data de Publicação 
                 o142_leialteracaoppa = varchar(50) = Número da Lei de Alteração 
                 o142_dataalteracaoppa = date = Data da Lei de Alteração 
                 o142_datapubalteracao = date = Data de Publicação da Lei de Alteração 
                 o142_datapublicacaoldo = date = Data de Publicação LDO 
                 o142_dataldo = date = Data LDO 
                 o142_numeroloa = varchar(50) = Número da LOA 
                 o142_dataloa = date = Data da LOA 
                 o142_datapubloa = date = Data de Publicação da LOA 
                 o142_percsuplementacao = numeric(10) = Percentual de Suplementação 
                 o142_percaro = numeric(10) = Percentual de ARO 
                 o142_percopercredito = numeric(10) = Operação de Crédito Interna 
                 o142_orcmodalidadeaplic = bool = Orçamento por Modalidade de Aplicação
                 ";
   //funcao construtor da classe 
   function cl_ppaleidadocomplementar() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ppaleidadocomplementar"); 
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
       $this->o142_sequencial = ($this->o142_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_sequencial"]:$this->o142_sequencial);
       $this->o142_ppalei = ($this->o142_ppalei == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_ppalei"]:$this->o142_ppalei);
       $this->o142_anoinicialppa = ($this->o142_anoinicialppa == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_anoinicialppa"]:$this->o142_anoinicialppa);
       $this->o142_anofinalppa = ($this->o142_anofinalppa == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_anofinalppa"]:$this->o142_anofinalppa);
       $this->o142_numeroleippa = ($this->o142_numeroleippa == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_numeroleippa"]:$this->o142_numeroleippa);
       if($this->o142_dataleippa == ""){
         $this->o142_dataleippa_dia = ($this->o142_dataleippa_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataleippa_dia"]:$this->o142_dataleippa_dia);
         $this->o142_dataleippa_mes = ($this->o142_dataleippa_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataleippa_mes"]:$this->o142_dataleippa_mes);
         $this->o142_dataleippa_ano = ($this->o142_dataleippa_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataleippa_ano"]:$this->o142_dataleippa_ano);
         if($this->o142_dataleippa_dia != ""){
            $this->o142_dataleippa = $this->o142_dataleippa_ano."-".$this->o142_dataleippa_mes."-".$this->o142_dataleippa_dia;
         }
       }
       if($this->o142_datapublicacaoppa == ""){
         $this->o142_datapublicacaoppa_dia = ($this->o142_datapublicacaoppa_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa_dia"]:$this->o142_datapublicacaoppa_dia);
         $this->o142_datapublicacaoppa_mes = ($this->o142_datapublicacaoppa_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa_mes"]:$this->o142_datapublicacaoppa_mes);
         $this->o142_datapublicacaoppa_ano = ($this->o142_datapublicacaoppa_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa_ano"]:$this->o142_datapublicacaoppa_ano);
         if($this->o142_datapublicacaoppa_dia != ""){
            $this->o142_datapublicacaoppa = $this->o142_datapublicacaoppa_ano."-".$this->o142_datapublicacaoppa_mes."-".$this->o142_datapublicacaoppa_dia;
         }
       }
       $this->o142_leialteracaoppa = ($this->o142_leialteracaoppa == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppa"]:$this->o142_leialteracaoppa);
       if($this->o142_dataalteracaoppa == ""){
         $this->o142_dataalteracaoppa_dia = ($this->o142_dataalteracaoppa_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa_dia"]:$this->o142_dataalteracaoppa_dia);
         $this->o142_dataalteracaoppa_mes = ($this->o142_dataalteracaoppa_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa_mes"]:$this->o142_dataalteracaoppa_mes);
         $this->o142_dataalteracaoppa_ano = ($this->o142_dataalteracaoppa_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa_ano"]:$this->o142_dataalteracaoppa_ano);
         if($this->o142_dataalteracaoppa_dia != ""){
            $this->o142_dataalteracaoppa = $this->o142_dataalteracaoppa_ano."-".$this->o142_dataalteracaoppa_mes."-".$this->o142_dataalteracaoppa_dia;
         }
       }
       if($this->o142_datapubalteracao == ""){
         $this->o142_datapubalteracao_dia = ($this->o142_datapubalteracao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao_dia"]:$this->o142_datapubalteracao_dia);
         $this->o142_datapubalteracao_mes = ($this->o142_datapubalteracao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao_mes"]:$this->o142_datapubalteracao_mes);
         $this->o142_datapubalteracao_ano = ($this->o142_datapubalteracao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao_ano"]:$this->o142_datapubalteracao_ano);
         if($this->o142_datapubalteracao_dia != ""){
            $this->o142_datapubalteracao = $this->o142_datapubalteracao_ano."-".$this->o142_datapubalteracao_mes."-".$this->o142_datapubalteracao_dia;
         }
       }
       if($this->o142_datapublicacaoldo == ""){
         $this->o142_datapublicacaoldo_dia = ($this->o142_datapublicacaoldo_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo_dia"]:$this->o142_datapublicacaoldo_dia);
         $this->o142_datapublicacaoldo_mes = ($this->o142_datapublicacaoldo_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo_mes"]:$this->o142_datapublicacaoldo_mes);
         $this->o142_datapublicacaoldo_ano = ($this->o142_datapublicacaoldo_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo_ano"]:$this->o142_datapublicacaoldo_ano);
         if($this->o142_datapublicacaoldo_dia != ""){
            $this->o142_datapublicacaoldo = $this->o142_datapublicacaoldo_ano."-".$this->o142_datapublicacaoldo_mes."-".$this->o142_datapublicacaoldo_dia;
         }
       }
       if($this->o142_dataldo == ""){
         $this->o142_dataldo_dia = ($this->o142_dataldo_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldo_dia"]:$this->o142_dataldo_dia);
         $this->o142_dataldo_mes = ($this->o142_dataldo_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldo_mes"]:$this->o142_dataldo_mes);
         $this->o142_dataldo_ano = ($this->o142_dataldo_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataldo_ano"]:$this->o142_dataldo_ano);
         if($this->o142_dataldo_dia != ""){
            $this->o142_dataldo = $this->o142_dataldo_ano."-".$this->o142_dataldo_mes."-".$this->o142_dataldo_dia;
         }
       }
       $this->o142_numeroloa = ($this->o142_numeroloa == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_numeroloa"]:$this->o142_numeroloa);
       if($this->o142_dataloa == ""){
         $this->o142_dataloa_dia = ($this->o142_dataloa_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloa_dia"]:$this->o142_dataloa_dia);
         $this->o142_dataloa_mes = ($this->o142_dataloa_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloa_mes"]:$this->o142_dataloa_mes);
         $this->o142_dataloa_ano = ($this->o142_dataloa_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_dataloa_ano"]:$this->o142_dataloa_ano);
         if($this->o142_dataloa_dia != ""){
            $this->o142_dataloa = $this->o142_dataloa_ano."-".$this->o142_dataloa_mes."-".$this->o142_dataloa_dia;
         }
       }
       if($this->o142_datapubloa == ""){
         $this->o142_datapubloa_dia = ($this->o142_datapubloa_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloa_dia"]:$this->o142_datapubloa_dia);
         $this->o142_datapubloa_mes = ($this->o142_datapubloa_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloa_mes"]:$this->o142_datapubloa_mes);
         $this->o142_datapubloa_ano = ($this->o142_datapubloa_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_datapubloa_ano"]:$this->o142_datapubloa_ano);
         if($this->o142_datapubloa_dia != ""){
            $this->o142_datapubloa = $this->o142_datapubloa_ano."-".$this->o142_datapubloa_mes."-".$this->o142_datapubloa_dia;
         }
       }
       $this->o142_percsuplementacao = ($this->o142_percsuplementacao == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacao"]:$this->o142_percsuplementacao);
       $this->o142_percaro = ($this->o142_percaro == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percaro"]:$this->o142_percaro);
       $this->o142_percopercredito = ($this->o142_percopercredito == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_percopercredito"]:$this->o142_percopercredito);
       $this->o142_orcmodalidadeaplic = ($this->o142_orcmodalidadeaplic == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplic"]:$this->o142_orcmodalidadeaplic);
     }else{
       $this->o142_sequencial = ($this->o142_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o142_sequencial"]:$this->o142_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($o142_sequencial){ 
      $this->atualizacampos();
     if($this->o142_ppalei == null ){ 
       $this->erro_sql = " Campo Código da Lei do PPA nao Informado.";
       $this->erro_campo = "o142_ppalei";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o142_anoinicialppa == null ){ 
       $this->o142_anoinicialppa = "0";
     }
     if($this->o142_anofinalppa == null ){ 
       $this->o142_anofinalppa = "0";
     }
     if($this->o142_dataleippa == null ){ 
       $this->o142_dataleippa = "null";
     }
     if($this->o142_datapublicacaoppa == null ){ 
       $this->o142_datapublicacaoppa = "null";
     }
     if($this->o142_dataalteracaoppa == null ){ 
       $this->o142_dataalteracaoppa = "null";
     }
     if($this->o142_datapubalteracao == null ){ 
       $this->o142_datapubalteracao = "null";
     }
     if($this->o142_datapublicacaoldo == null ){ 
       $this->o142_datapublicacaoldo = "null";
     }
     if($this->o142_dataldo == null ){ 
       $this->o142_dataldo = "null";
     }
     if($this->o142_dataloa == null ){ 
       $this->o142_dataloa = "null";
     }
     if($this->o142_datapubloa == null ){ 
       $this->o142_datapubloa = "null";
     }
     if($o142_sequencial == "" || $o142_sequencial == null ){
       $result = db_query("select nextval('ppaleidadocomplementar_o142_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ppaleidadocomplementar_o142_sequencial_seq do campo: o142_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->o142_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ppaleidadocomplementar_o142_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $o142_sequencial)){
         $this->erro_sql = " Campo o142_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->o142_sequencial = $o142_sequencial; 
       }
     }
     if(($this->o142_sequencial == null) || ($this->o142_sequencial == "") ){ 
       $this->erro_sql = " Campo o142_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->o142_orcmodalidadeaplic == null) || ($this->o142_orcmodalidadeaplic == "") ){ 
      $this->erro_sql = " Campo Orçamento por Modalidade de Aplicação nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }     
     $sql = "insert into ppaleidadocomplementar(
                                       o142_sequencial 
                                      ,o142_ppalei 
                                      ,o142_anoinicialppa 
                                      ,o142_anofinalppa 
                                      ,o142_numeroleippa 
                                      ,o142_dataleippa 
                                      ,o142_datapublicacaoppa 
                                      ,o142_leialteracaoppa 
                                      ,o142_dataalteracaoppa 
                                      ,o142_datapubalteracao 
                                      ,o142_datapublicacaoldo 
                                      ,o142_dataldo 
                                      ,o142_numeroloa 
                                      ,o142_dataloa 
                                      ,o142_datapubloa 
                                      ,o142_percsuplementacao 
                                      ,o142_percaro 
                                      ,o142_percopercredito 
                                      ,o142_orcmodalidadeaplic
                       )
                values (
                                $this->o142_sequencial 
                               ,$this->o142_ppalei 
                               ,$this->o142_anoinicialppa 
                               ,$this->o142_anofinalppa 
                               ,'$this->o142_numeroleippa' 
                               ,".($this->o142_dataleippa == "null" || $this->o142_dataleippa == ""?"null":"'".$this->o142_dataleippa."'")." 
                               ,".($this->o142_datapublicacaoppa == "null" || $this->o142_datapublicacaoppa == ""?"null":"'".$this->o142_datapublicacaoppa."'")." 
                               ,'$this->o142_leialteracaoppa' 
                               ,".($this->o142_dataalteracaoppa == "null" || $this->o142_dataalteracaoppa == ""?"null":"'".$this->o142_dataalteracaoppa."'")." 
                               ,".($this->o142_datapubalteracao == "null" || $this->o142_datapubalteracao == ""?"null":"'".$this->o142_datapubalteracao."'")." 
                               ,".($this->o142_datapublicacaoldo == "null" || $this->o142_datapublicacaoldo == ""?"null":"'".$this->o142_datapublicacaoldo."'")." 
                               ,".($this->o142_dataldo == "null" || $this->o142_dataldo == ""?"null":"'".$this->o142_dataldo."'")." 
                               ,'$this->o142_numeroloa' 
                               ,".($this->o142_dataloa == "null" || $this->o142_dataloa == ""?"null":"'".$this->o142_dataloa."'")." 
                               ,".($this->o142_datapubloa == "null" || $this->o142_datapubloa == ""?"null":"'".$this->o142_datapubloa."'")." 
                               ,$this->o142_percsuplementacao 
                               ,$this->o142_percaro 
                               ,$this->o142_percopercredito 
                               ,'$this->o142_orcmodalidadeaplic'
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dados complementares do ppa ($this->o142_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dados complementares do ppa já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dados complementares do ppa ($this->o142_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o142_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->o142_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,18403,'$this->o142_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,3257,18403,'','".AddSlashes(pg_result($resaco,0,'o142_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18404,'','".AddSlashes(pg_result($resaco,0,'o142_ppalei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18405,'','".AddSlashes(pg_result($resaco,0,'o142_anoinicialppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18406,'','".AddSlashes(pg_result($resaco,0,'o142_anofinalppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18407,'','".AddSlashes(pg_result($resaco,0,'o142_numeroleippa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18408,'','".AddSlashes(pg_result($resaco,0,'o142_dataleippa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18409,'','".AddSlashes(pg_result($resaco,0,'o142_datapublicacaoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18410,'','".AddSlashes(pg_result($resaco,0,'o142_leialteracaoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18411,'','".AddSlashes(pg_result($resaco,0,'o142_dataalteracaoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18412,'','".AddSlashes(pg_result($resaco,0,'o142_datapubalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18413,'','".AddSlashes(pg_result($resaco,0,'o142_datapublicacaoldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18414,'','".AddSlashes(pg_result($resaco,0,'o142_dataldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18415,'','".AddSlashes(pg_result($resaco,0,'o142_numeroloa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18416,'','".AddSlashes(pg_result($resaco,0,'o142_dataloa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18417,'','".AddSlashes(pg_result($resaco,0,'o142_datapubloa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18418,'','".AddSlashes(pg_result($resaco,0,'o142_percsuplementacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18419,'','".AddSlashes(pg_result($resaco,0,'o142_percaro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,3257,18420,'','".AddSlashes(pg_result($resaco,0,'o142_percopercredito'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($o142_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ppaleidadocomplementar set ";
     $virgula = "";
     if(trim($this->o142_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_sequencial"])){ 
       $sql  .= $virgula." o142_sequencial = $this->o142_sequencial ";
       $virgula = ",";
       if(trim($this->o142_sequencial) == null ){ 
         $this->erro_sql = " Campo Codigo Sequencial nao Informado.";
         $this->erro_campo = "o142_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o142_ppalei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_ppalei"])){ 
       $sql  .= $virgula." o142_ppalei = $this->o142_ppalei ";
       $virgula = ",";
       if(trim($this->o142_ppalei) == null ){ 
         $this->erro_sql = " Campo Código da Lei do PPA nao Informado.";
         $this->erro_campo = "o142_ppalei";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o142_anoinicialppa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_anoinicialppa"])){ 
        if(trim($this->o142_anoinicialppa)=="" && isset($GLOBALS["HTTP_POST_VARS"]["o142_anoinicialppa"])){ 
           $this->o142_anoinicialppa = "0" ; 
        } 
       $sql  .= $virgula." o142_anoinicialppa = $this->o142_anoinicialppa ";
       $virgula = ",";
     }
     if(trim($this->o142_anofinalppa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_anofinalppa"])){ 
        if(trim($this->o142_anofinalppa)=="" && isset($GLOBALS["HTTP_POST_VARS"]["o142_anofinalppa"])){ 
           $this->o142_anofinalppa = "0" ; 
        } 
       $sql  .= $virgula." o142_anofinalppa = $this->o142_anofinalppa ";
       $virgula = ",";
     }
     if(trim($this->o142_numeroleippa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroleippa"])){ 
       $sql  .= $virgula." o142_numeroleippa = '$this->o142_numeroleippa' ";
       $virgula = ",";
     }
     if(trim($this->o142_dataleippa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataleippa_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataleippa_dia"] !="") ){ 
       $sql  .= $virgula." o142_dataleippa = '$this->o142_dataleippa' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataleippa_dia"])){ 
         $sql  .= $virgula." o142_dataleippa = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_datapublicacaoppa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa_dia"] !="") ){ 
       $sql  .= $virgula." o142_datapublicacaoppa = '$this->o142_datapublicacaoppa' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa_dia"])){ 
         $sql  .= $virgula." o142_datapublicacaoppa = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_leialteracaoppa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppa"])){ 
       $sql  .= $virgula." o142_leialteracaoppa = '$this->o142_leialteracaoppa' ";
       $virgula = ",";
     }
     if(trim($this->o142_dataalteracaoppa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa_dia"] !="") ){ 
       $sql  .= $virgula." o142_dataalteracaoppa = '$this->o142_dataalteracaoppa' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa_dia"])){ 
         $sql  .= $virgula." o142_dataalteracaoppa = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_datapubalteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao_dia"] !="") ){ 
       $sql  .= $virgula." o142_datapubalteracao = '$this->o142_datapubalteracao' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao_dia"])){ 
         $sql  .= $virgula." o142_datapubalteracao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_datapublicacaoldo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo_dia"] !="") ){ 
       $sql  .= $virgula." o142_datapublicacaoldo = '$this->o142_datapublicacaoldo' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo_dia"])){ 
         $sql  .= $virgula." o142_datapublicacaoldo = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_dataldo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataldo_dia"] !="") ){ 
       $sql  .= $virgula." o142_dataldo = '$this->o142_dataldo' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldo_dia"])){ 
         $sql  .= $virgula." o142_dataldo = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_numeroloa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroloa"])){ 
       $sql  .= $virgula." o142_numeroloa = '$this->o142_numeroloa' ";
       $virgula = ",";
     }
     if(trim($this->o142_dataloa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloa_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_dataloa_dia"] !="") ){ 
       $sql  .= $virgula." o142_dataloa = '$this->o142_dataloa' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloa_dia"])){ 
         $sql  .= $virgula." o142_dataloa = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_datapubloa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloa_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["o142_datapubloa_dia"] !="") ){ 
       $sql  .= $virgula." o142_datapubloa = '$this->o142_datapubloa' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloa_dia"])){ 
         $sql  .= $virgula." o142_datapubloa = null ";
         $virgula = ",";
       }
     }
     if(trim($this->o142_percsuplementacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacao"])){ 
       $sql  .= $virgula." o142_percsuplementacao = $this->o142_percsuplementacao ";
       $virgula = ",";
     }
     if(trim($this->o142_percaro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percaro"])){ 
       $sql  .= $virgula." o142_percaro = $this->o142_percaro ";
       $virgula = ",";
     }
     if(trim($this->o142_percopercredito)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_percopercredito"])){ 
       $sql  .= $virgula." o142_percopercredito = $this->o142_percopercredito ";
       $virgula = ",";
     }
     if(trim($this->o142_orcmodalidadeaplic)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o142_orcmodalidadeaplic"])){ 
      $sql  .= $virgula." o142_orcmodalidadeaplic = '$this->o142_orcmodalidadeaplic' ";
      $virgula = ",";
      if(trim($this->o142_orcmodalidadeaplic) == null ){ 
        $this->erro_sql = " Campo Orçamento por Modalidade de Aplicação nao Informado.";
        $this->erro_campo = "o142_orcmodalidadeaplic";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
     $sql .= " where ";
     if($o142_sequencial!=null){
       $sql .= " o142_sequencial = $this->o142_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->o142_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,18403,'$this->o142_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_sequencial"]) || $this->o142_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,3257,18403,'".AddSlashes(pg_result($resaco,$conresaco,'o142_sequencial'))."','$this->o142_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_ppalei"]) || $this->o142_ppalei != "")
           $resac = db_query("insert into db_acount values($acount,3257,18404,'".AddSlashes(pg_result($resaco,$conresaco,'o142_ppalei'))."','$this->o142_ppalei',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_anoinicialppa"]) || $this->o142_anoinicialppa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18405,'".AddSlashes(pg_result($resaco,$conresaco,'o142_anoinicialppa'))."','$this->o142_anoinicialppa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_anofinalppa"]) || $this->o142_anofinalppa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18406,'".AddSlashes(pg_result($resaco,$conresaco,'o142_anofinalppa'))."','$this->o142_anofinalppa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroleippa"]) || $this->o142_numeroleippa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18407,'".AddSlashes(pg_result($resaco,$conresaco,'o142_numeroleippa'))."','$this->o142_numeroleippa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataleippa"]) || $this->o142_dataleippa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18408,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataleippa'))."','$this->o142_dataleippa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoppa"]) || $this->o142_datapublicacaoppa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18409,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapublicacaoppa'))."','$this->o142_datapublicacaoppa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_leialteracaoppa"]) || $this->o142_leialteracaoppa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18410,'".AddSlashes(pg_result($resaco,$conresaco,'o142_leialteracaoppa'))."','$this->o142_leialteracaoppa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataalteracaoppa"]) || $this->o142_dataalteracaoppa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18411,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataalteracaoppa'))."','$this->o142_dataalteracaoppa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubalteracao"]) || $this->o142_datapubalteracao != "")
           $resac = db_query("insert into db_acount values($acount,3257,18412,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubalteracao'))."','$this->o142_datapubalteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapublicacaoldo"]) || $this->o142_datapublicacaoldo != "")
           $resac = db_query("insert into db_acount values($acount,3257,18413,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapublicacaoldo'))."','$this->o142_datapublicacaoldo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataldo"]) || $this->o142_dataldo != "")
           $resac = db_query("insert into db_acount values($acount,3257,18414,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataldo'))."','$this->o142_dataldo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_numeroloa"]) || $this->o142_numeroloa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18415,'".AddSlashes(pg_result($resaco,$conresaco,'o142_numeroloa'))."','$this->o142_numeroloa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_dataloa"]) || $this->o142_dataloa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18416,'".AddSlashes(pg_result($resaco,$conresaco,'o142_dataloa'))."','$this->o142_dataloa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_datapubloa"]) || $this->o142_datapubloa != "")
           $resac = db_query("insert into db_acount values($acount,3257,18417,'".AddSlashes(pg_result($resaco,$conresaco,'o142_datapubloa'))."','$this->o142_datapubloa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percsuplementacao"]) || $this->o142_percsuplementacao != "")
           $resac = db_query("insert into db_acount values($acount,3257,18418,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percsuplementacao'))."','$this->o142_percsuplementacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percaro"]) || $this->o142_percaro != "")
           $resac = db_query("insert into db_acount values($acount,3257,18419,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percaro'))."','$this->o142_percaro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o142_percopercredito"]) || $this->o142_percopercredito != "")
           $resac = db_query("insert into db_acount values($acount,3257,18420,'".AddSlashes(pg_result($resaco,$conresaco,'o142_percopercredito'))."','$this->o142_percopercredito',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dados complementares do ppa nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->o142_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dados complementares do ppa nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->o142_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o142_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($o142_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($o142_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,18403,'$o142_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,3257,18403,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18404,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_ppalei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18405,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_anoinicialppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18406,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_anofinalppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18407,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_numeroleippa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18408,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_dataleippa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18409,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_datapublicacaoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18410,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_leialteracaoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18411,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_dataalteracaoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18412,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_datapubalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18413,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_datapublicacaoldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18414,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_dataldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18415,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_numeroloa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18416,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_dataloa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18417,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_datapubloa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18418,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_percsuplementacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18419,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_percaro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,3257,18420,'','".AddSlashes(pg_result($resaco,$iresaco,'o142_percopercredito'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ppaleidadocomplementar
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($o142_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " o142_sequencial = $o142_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dados complementares do ppa nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$o142_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dados complementares do ppa nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$o142_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$o142_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ppaleidadocomplementar";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $o142_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from ppaleidadocomplementar ";
     $sql .= "      inner join ppalei  on  ppalei.o01_sequencial = ppaleidadocomplementar.o142_ppalei";
     $sql .= "      inner join db_config  on  db_config.codigo = ppalei.o01_instit";
     $sql2 = "";
     if($dbwhere==""){
       if($o142_sequencial!=null ){
         $sql2 .= " where ppaleidadocomplementar.o142_sequencial = $o142_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
   // funcao do sql 
   function sql_query_file ( $o142_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from ppaleidadocomplementar ";
     $sql2 = "";
     if($dbwhere==""){
       if($o142_sequencial!=null ){
         $sql2 .= " where ppaleidadocomplementar.o142_sequencial = $o142_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
}
?>
