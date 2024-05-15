<?
//MODULO: sicom
//CLASSE DA ENTIDADE alq112016
class cl_alq112016 { 
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
   var $si122_sequencial = 0; 
   var $si122_tiporegistro = 0; 
   var $si122_codreduzido = 0; 
   var $si122_codfontrecursos = 0; 
   var $si122_valoranuladofonte = 0; 
   var $si122_mes = 0; 
   var $si122_reg10 = 0; 
   var $si122_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si122_sequencial = int8 = sequencial 
                 si122_tiporegistro = int8 = Tipo do  registro 
                 si122_codreduzido = int8 = Código Identificador do registro 
                 si122_codfontrecursos = int8 = Código da fonte  de recursos 
                 si122_valoranuladofonte = float8 = Valor anulado da  liquidação 
                 si122_mes = int8 = Mês 
                 si122_reg10 = int8 = reg10 
                 si122_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_alq112016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("alq112016"); 
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
       $this->si122_sequencial = ($this->si122_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si122_sequencial"]:$this->si122_sequencial);
       $this->si122_tiporegistro = ($this->si122_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si122_tiporegistro"]:$this->si122_tiporegistro);
       $this->si122_codreduzido = ($this->si122_codreduzido == ""?@$GLOBALS["HTTP_POST_VARS"]["si122_codreduzido"]:$this->si122_codreduzido);
       $this->si122_codfontrecursos = ($this->si122_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si122_codfontrecursos"]:$this->si122_codfontrecursos);
       $this->si122_valoranuladofonte = ($this->si122_valoranuladofonte == ""?@$GLOBALS["HTTP_POST_VARS"]["si122_valoranuladofonte"]:$this->si122_valoranuladofonte);
       $this->si122_mes = ($this->si122_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si122_mes"]:$this->si122_mes);
       $this->si122_reg10 = ($this->si122_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si122_reg10"]:$this->si122_reg10);
       $this->si122_instit = ($this->si122_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si122_instit"]:$this->si122_instit);
     }else{
       $this->si122_sequencial = ($this->si122_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si122_sequencial"]:$this->si122_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si122_sequencial){ 
      $this->atualizacampos();
     if($this->si122_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si122_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si122_codreduzido == null ){ 
       $this->si122_codreduzido = "0";
     }
     if($this->si122_codfontrecursos == null ){ 
       $this->si122_codfontrecursos = "0";
     }
     if($this->si122_valoranuladofonte == null ){ 
       $this->si122_valoranuladofonte = "0";
     }
     if($this->si122_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si122_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si122_reg10 == null ){ 
       $this->si122_reg10 = "0";
     }
     if($this->si122_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si122_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si122_sequencial == "" || $si122_sequencial == null ){
       $result = db_query("select nextval('alq112016_si122_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: alq112016_si122_sequencial_seq do campo: si122_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si122_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from alq112016_si122_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si122_sequencial)){
         $this->erro_sql = " Campo si122_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si122_sequencial = $si122_sequencial; 
       }
     }
     if(($this->si122_sequencial == null) || ($this->si122_sequencial == "") ){ 
       $this->erro_sql = " Campo si122_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into alq112016(
                                       si122_sequencial 
                                      ,si122_tiporegistro 
                                      ,si122_codreduzido 
                                      ,si122_codfontrecursos 
                                      ,si122_valoranuladofonte 
                                      ,si122_mes 
                                      ,si122_reg10 
                                      ,si122_instit 
                       )
                values (
                                $this->si122_sequencial 
                               ,$this->si122_tiporegistro 
                               ,$this->si122_codreduzido 
                               ,$this->si122_codfontrecursos 
                               ,$this->si122_valoranuladofonte 
                               ,$this->si122_mes 
                               ,$this->si122_reg10 
                               ,$this->si122_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "alq112016 ($this->si122_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "alq112016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "alq112016 ($this->si122_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si122_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si122_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010830,'$this->si122_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010351,2010830,'','".AddSlashes(pg_result($resaco,0,'si122_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010351,2010831,'','".AddSlashes(pg_result($resaco,0,'si122_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010351,2010832,'','".AddSlashes(pg_result($resaco,0,'si122_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010351,2010833,'','".AddSlashes(pg_result($resaco,0,'si122_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010351,2010834,'','".AddSlashes(pg_result($resaco,0,'si122_valoranuladofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010351,2010835,'','".AddSlashes(pg_result($resaco,0,'si122_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010351,2010836,'','".AddSlashes(pg_result($resaco,0,'si122_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010351,2011635,'','".AddSlashes(pg_result($resaco,0,'si122_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si122_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update alq112016 set ";
     $virgula = "";
     if(trim($this->si122_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si122_sequencial"])){ 
        if(trim($this->si122_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si122_sequencial"])){ 
           $this->si122_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si122_sequencial = $this->si122_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si122_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si122_tiporegistro"])){ 
       $sql  .= $virgula." si122_tiporegistro = $this->si122_tiporegistro ";
       $virgula = ",";
       if(trim($this->si122_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si122_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si122_codreduzido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si122_codreduzido"])){ 
        if(trim($this->si122_codreduzido)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si122_codreduzido"])){ 
           $this->si122_codreduzido = "0" ; 
        } 
       $sql  .= $virgula." si122_codreduzido = $this->si122_codreduzido ";
       $virgula = ",";
     }
     if(trim($this->si122_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si122_codfontrecursos"])){ 
        if(trim($this->si122_codfontrecursos)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si122_codfontrecursos"])){ 
           $this->si122_codfontrecursos = "0" ; 
        } 
       $sql  .= $virgula." si122_codfontrecursos = $this->si122_codfontrecursos ";
       $virgula = ",";
     }
     if(trim($this->si122_valoranuladofonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si122_valoranuladofonte"])){ 
        if(trim($this->si122_valoranuladofonte)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si122_valoranuladofonte"])){ 
           $this->si122_valoranuladofonte = "0" ; 
        } 
       $sql  .= $virgula." si122_valoranuladofonte = $this->si122_valoranuladofonte ";
       $virgula = ",";
     }
     if(trim($this->si122_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si122_mes"])){ 
       $sql  .= $virgula." si122_mes = $this->si122_mes ";
       $virgula = ",";
       if(trim($this->si122_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si122_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si122_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si122_reg10"])){ 
        if(trim($this->si122_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si122_reg10"])){ 
           $this->si122_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si122_reg10 = $this->si122_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si122_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si122_instit"])){ 
       $sql  .= $virgula." si122_instit = $this->si122_instit ";
       $virgula = ",";
       if(trim($this->si122_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si122_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si122_sequencial!=null){
       $sql .= " si122_sequencial = $this->si122_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si122_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010830,'$this->si122_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si122_sequencial"]) || $this->si122_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010351,2010830,'".AddSlashes(pg_result($resaco,$conresaco,'si122_sequencial'))."','$this->si122_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si122_tiporegistro"]) || $this->si122_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010351,2010831,'".AddSlashes(pg_result($resaco,$conresaco,'si122_tiporegistro'))."','$this->si122_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si122_codreduzido"]) || $this->si122_codreduzido != "")
           $resac = db_query("insert into db_acount values($acount,2010351,2010832,'".AddSlashes(pg_result($resaco,$conresaco,'si122_codreduzido'))."','$this->si122_codreduzido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si122_codfontrecursos"]) || $this->si122_codfontrecursos != "")
           $resac = db_query("insert into db_acount values($acount,2010351,2010833,'".AddSlashes(pg_result($resaco,$conresaco,'si122_codfontrecursos'))."','$this->si122_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si122_valoranuladofonte"]) || $this->si122_valoranuladofonte != "")
           $resac = db_query("insert into db_acount values($acount,2010351,2010834,'".AddSlashes(pg_result($resaco,$conresaco,'si122_valoranuladofonte'))."','$this->si122_valoranuladofonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si122_mes"]) || $this->si122_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010351,2010835,'".AddSlashes(pg_result($resaco,$conresaco,'si122_mes'))."','$this->si122_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si122_reg10"]) || $this->si122_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010351,2010836,'".AddSlashes(pg_result($resaco,$conresaco,'si122_reg10'))."','$this->si122_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si122_instit"]) || $this->si122_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010351,2011635,'".AddSlashes(pg_result($resaco,$conresaco,'si122_instit'))."','$this->si122_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "alq112016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si122_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "alq112016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si122_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si122_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si122_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si122_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010830,'$si122_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010351,2010830,'','".AddSlashes(pg_result($resaco,$iresaco,'si122_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010351,2010831,'','".AddSlashes(pg_result($resaco,$iresaco,'si122_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010351,2010832,'','".AddSlashes(pg_result($resaco,$iresaco,'si122_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010351,2010833,'','".AddSlashes(pg_result($resaco,$iresaco,'si122_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010351,2010834,'','".AddSlashes(pg_result($resaco,$iresaco,'si122_valoranuladofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010351,2010835,'','".AddSlashes(pg_result($resaco,$iresaco,'si122_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010351,2010836,'','".AddSlashes(pg_result($resaco,$iresaco,'si122_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010351,2011635,'','".AddSlashes(pg_result($resaco,$iresaco,'si122_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from alq112016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si122_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si122_sequencial = $si122_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "alq112016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si122_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "alq112016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si122_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si122_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:alq112016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si122_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from alq112016 ";
     $sql .= "      left  join alq102016  on  alq102016.si121_sequencial = alq112016.si122_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si122_sequencial!=null ){
         $sql2 .= " where alq112016.si122_sequencial = $si122_sequencial "; 
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
   function sql_query_file ( $si122_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from alq112016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si122_sequencial!=null ){
         $sql2 .= " where alq112016.si122_sequencial = $si122_sequencial "; 
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
