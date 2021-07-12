<?
//MODULO: sicom
//CLASSE DA ENTIDADE conv112014
class cl_conv112014 { 
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
   var $si93_sequencial = 0; 
   var $si93_tiporegistro = 0; 
   var $si93_codconvenio = 0; 
   var $si93_tipodocumento = 0; 
   var $si93_nrodocumento = null; 
   var $si93_esferaconcedente = 0; 
   var $si93_valorconcedido = 0; 
   var $si93_mes = 0; 
   var $si93_reg10 = 0; 
   var $si93_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si93_sequencial = int8 = sequencial 
                 si93_tiporegistro = int8 = Tipo do  registro 
                 si93_codconvenio = int8 = Código do  Convênio 
                 si93_tipodocumento = int8 = Tipo de documento 
                 si93_nrodocumento = varchar(14) = Número do  documento 
                 si93_esferaconcedente = int8 = Esfera do  Concedente 
                 si93_valorconcedido = float8 = Valor a ser  concedido 
                 si93_mes = int8 = Mês 
                 si93_reg10 = int8 = reg10 
                 si93_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_conv112014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("conv112014"); 
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
       $this->si93_sequencial = ($this->si93_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si93_sequencial"]:$this->si93_sequencial);
       $this->si93_tiporegistro = ($this->si93_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si93_tiporegistro"]:$this->si93_tiporegistro);
       $this->si93_codconvenio = ($this->si93_codconvenio == ""?@$GLOBALS["HTTP_POST_VARS"]["si93_codconvenio"]:$this->si93_codconvenio);
       $this->si93_tipodocumento = ($this->si93_tipodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si93_tipodocumento"]:$this->si93_tipodocumento);
       $this->si93_nrodocumento = ($this->si93_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si93_nrodocumento"]:$this->si93_nrodocumento);
       $this->si93_esferaconcedente = ($this->si93_esferaconcedente == ""?@$GLOBALS["HTTP_POST_VARS"]["si93_esferaconcedente"]:$this->si93_esferaconcedente);
       $this->si93_valorconcedido = ($this->si93_valorconcedido == ""?@$GLOBALS["HTTP_POST_VARS"]["si93_valorconcedido"]:$this->si93_valorconcedido);
       $this->si93_mes = ($this->si93_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si93_mes"]:$this->si93_mes);
       $this->si93_reg10 = ($this->si93_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si93_reg10"]:$this->si93_reg10);
       $this->si93_instit = ($this->si93_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si93_instit"]:$this->si93_instit);
     }else{
       $this->si93_sequencial = ($this->si93_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si93_sequencial"]:$this->si93_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si93_sequencial){ 
      $this->atualizacampos();
     if($this->si93_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si93_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si93_codconvenio == null ){ 
       $this->si93_codconvenio = "0";
     }
     if($this->si93_tipodocumento == null ){ 
       $this->si93_tipodocumento = "0";
     }
     if($this->si93_esferaconcedente == null ){ 
       $this->si93_esferaconcedente = "0";
     }
     if($this->si93_valorconcedido == null ){ 
       $this->si93_valorconcedido = "0";
     }
     if($this->si93_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si93_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si93_reg10 == null ){ 
       $this->si93_reg10 = "0";
     }
     if($this->si93_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si93_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si93_sequencial == "" || $si93_sequencial == null ){
       $result = db_query("select nextval('conv112014_si93_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: conv112014_si93_sequencial_seq do campo: si93_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si93_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from conv112014_si93_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si93_sequencial)){
         $this->erro_sql = " Campo si93_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si93_sequencial = $si93_sequencial; 
       }
     }
     if(($this->si93_sequencial == null) || ($this->si93_sequencial == "") ){ 
       $this->erro_sql = " Campo si93_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into conv112014(
                                       si93_sequencial 
                                      ,si93_tiporegistro 
                                      ,si93_codconvenio 
                                      ,si93_tipodocumento 
                                      ,si93_nrodocumento 
                                      ,si93_esferaconcedente 
                                      ,si93_valorconcedido 
                                      ,si93_mes 
                                      ,si93_reg10 
                                      ,si93_instit 
                       )
                values (
                                $this->si93_sequencial 
                               ,$this->si93_tiporegistro 
                               ,$this->si93_codconvenio 
                               ,$this->si93_tipodocumento 
                               ,'$this->si93_nrodocumento' 
                               ,$this->si93_esferaconcedente 
                               ,$this->si93_valorconcedido 
                               ,$this->si93_mes 
                               ,$this->si93_reg10 
                               ,$this->si93_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "conv112014 ($this->si93_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "conv112014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "conv112014 ($this->si93_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si93_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si93_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010524,'$this->si93_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010322,2010524,'','".AddSlashes(pg_result($resaco,0,'si93_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010322,2010525,'','".AddSlashes(pg_result($resaco,0,'si93_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010322,2010526,'','".AddSlashes(pg_result($resaco,0,'si93_codconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010322,2010527,'','".AddSlashes(pg_result($resaco,0,'si93_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010322,2010528,'','".AddSlashes(pg_result($resaco,0,'si93_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010322,2010529,'','".AddSlashes(pg_result($resaco,0,'si93_esferaconcedente'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010322,2010530,'','".AddSlashes(pg_result($resaco,0,'si93_valorconcedido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010322,2010531,'','".AddSlashes(pg_result($resaco,0,'si93_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010322,2010532,'','".AddSlashes(pg_result($resaco,0,'si93_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010322,2011605,'','".AddSlashes(pg_result($resaco,0,'si93_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si93_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update conv112014 set ";
     $virgula = "";
     if(trim($this->si93_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si93_sequencial"])){ 
        if(trim($this->si93_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si93_sequencial"])){ 
           $this->si93_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si93_sequencial = $this->si93_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si93_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si93_tiporegistro"])){ 
       $sql  .= $virgula." si93_tiporegistro = $this->si93_tiporegistro ";
       $virgula = ",";
       if(trim($this->si93_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si93_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si93_codconvenio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si93_codconvenio"])){ 
        if(trim($this->si93_codconvenio)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si93_codconvenio"])){ 
           $this->si93_codconvenio = "0" ; 
        } 
       $sql  .= $virgula." si93_codconvenio = $this->si93_codconvenio ";
       $virgula = ",";
     }
     if(trim($this->si93_tipodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si93_tipodocumento"])){ 
        if(trim($this->si93_tipodocumento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si93_tipodocumento"])){ 
           $this->si93_tipodocumento = "0" ; 
        } 
       $sql  .= $virgula." si93_tipodocumento = $this->si93_tipodocumento ";
       $virgula = ",";
     }
     if(trim($this->si93_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si93_nrodocumento"])){ 
       $sql  .= $virgula." si93_nrodocumento = '$this->si93_nrodocumento' ";
       $virgula = ",";
     }
     if(trim($this->si93_esferaconcedente)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si93_esferaconcedente"])){ 
        if(trim($this->si93_esferaconcedente)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si93_esferaconcedente"])){ 
           $this->si93_esferaconcedente = "0" ; 
        } 
       $sql  .= $virgula." si93_esferaconcedente = $this->si93_esferaconcedente ";
       $virgula = ",";
     }
     if(trim($this->si93_valorconcedido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si93_valorconcedido"])){ 
        if(trim($this->si93_valorconcedido)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si93_valorconcedido"])){ 
           $this->si93_valorconcedido = "0" ; 
        } 
       $sql  .= $virgula." si93_valorconcedido = $this->si93_valorconcedido ";
       $virgula = ",";
     }
     if(trim($this->si93_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si93_mes"])){ 
       $sql  .= $virgula." si93_mes = $this->si93_mes ";
       $virgula = ",";
       if(trim($this->si93_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si93_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si93_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si93_reg10"])){ 
        if(trim($this->si93_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si93_reg10"])){ 
           $this->si93_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si93_reg10 = $this->si93_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si93_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si93_instit"])){ 
       $sql  .= $virgula." si93_instit = $this->si93_instit ";
       $virgula = ",";
       if(trim($this->si93_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si93_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si93_sequencial!=null){
       $sql .= " si93_sequencial = $this->si93_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si93_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010524,'$this->si93_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si93_sequencial"]) || $this->si93_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010322,2010524,'".AddSlashes(pg_result($resaco,$conresaco,'si93_sequencial'))."','$this->si93_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si93_tiporegistro"]) || $this->si93_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010322,2010525,'".AddSlashes(pg_result($resaco,$conresaco,'si93_tiporegistro'))."','$this->si93_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si93_codconvenio"]) || $this->si93_codconvenio != "")
           $resac = db_query("insert into db_acount values($acount,2010322,2010526,'".AddSlashes(pg_result($resaco,$conresaco,'si93_codconvenio'))."','$this->si93_codconvenio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si93_tipodocumento"]) || $this->si93_tipodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010322,2010527,'".AddSlashes(pg_result($resaco,$conresaco,'si93_tipodocumento'))."','$this->si93_tipodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si93_nrodocumento"]) || $this->si93_nrodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010322,2010528,'".AddSlashes(pg_result($resaco,$conresaco,'si93_nrodocumento'))."','$this->si93_nrodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si93_esferaconcedente"]) || $this->si93_esferaconcedente != "")
           $resac = db_query("insert into db_acount values($acount,2010322,2010529,'".AddSlashes(pg_result($resaco,$conresaco,'si93_esferaconcedente'))."','$this->si93_esferaconcedente',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si93_valorconcedido"]) || $this->si93_valorconcedido != "")
           $resac = db_query("insert into db_acount values($acount,2010322,2010530,'".AddSlashes(pg_result($resaco,$conresaco,'si93_valorconcedido'))."','$this->si93_valorconcedido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si93_mes"]) || $this->si93_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010322,2010531,'".AddSlashes(pg_result($resaco,$conresaco,'si93_mes'))."','$this->si93_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si93_reg10"]) || $this->si93_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010322,2010532,'".AddSlashes(pg_result($resaco,$conresaco,'si93_reg10'))."','$this->si93_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si93_instit"]) || $this->si93_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010322,2011605,'".AddSlashes(pg_result($resaco,$conresaco,'si93_instit'))."','$this->si93_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "conv112014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si93_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "conv112014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si93_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si93_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si93_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si93_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010524,'$si93_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010322,2010524,'','".AddSlashes(pg_result($resaco,$iresaco,'si93_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010322,2010525,'','".AddSlashes(pg_result($resaco,$iresaco,'si93_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010322,2010526,'','".AddSlashes(pg_result($resaco,$iresaco,'si93_codconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010322,2010527,'','".AddSlashes(pg_result($resaco,$iresaco,'si93_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010322,2010528,'','".AddSlashes(pg_result($resaco,$iresaco,'si93_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010322,2010529,'','".AddSlashes(pg_result($resaco,$iresaco,'si93_esferaconcedente'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010322,2010530,'','".AddSlashes(pg_result($resaco,$iresaco,'si93_valorconcedido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010322,2010531,'','".AddSlashes(pg_result($resaco,$iresaco,'si93_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010322,2010532,'','".AddSlashes(pg_result($resaco,$iresaco,'si93_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010322,2011605,'','".AddSlashes(pg_result($resaco,$iresaco,'si93_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from conv112014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si93_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si93_sequencial = $si93_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "conv112014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si93_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "conv112014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si93_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si93_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:conv112014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si93_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = explode("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from conv112014 ";
     $sql .= "      left  join conv102014  on  conv102014.si92_sequencial = conv112014.si93_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si93_sequencial!=null ){
         $sql2 .= " where conv112014.si93_sequencial = $si93_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = explode("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
   // funcao do sql 
   function sql_query_file ( $si93_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = explode("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from conv112014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si93_sequencial!=null ){
         $sql2 .= " where conv112014.si93_sequencial = $si93_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = explode("#",$ordem);
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
