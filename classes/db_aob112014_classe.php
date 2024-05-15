<?
//MODULO: sicom
//CLASSE DA ENTIDADE aob112014
class cl_aob112014 { 
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
   var $si142_sequencial = 0; 
   var $si142_tiporegistro = 0; 
   var $si142_codreduzido = 0; 
   var $si142_codfontrecursos = 0; 
   var $si142_valoranulacaofonte = 0; 
   var $si142_mes = 0; 
   var $si142_reg10 = 0; 
   var $si142_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si142_sequencial = int8 = sequencial 
                 si142_tiporegistro = int8 = Tipo do  registro 
                 si142_codreduzido = int8 = Código Identificador do registro 
                 si142_codfontrecursos = int8 = Código da fonte de  recursos 
                 si142_valoranulacaofonte = float8 = Valor da  Anulação 
                 si142_mes = int8 = Mês 
                 si142_reg10 = int8 = reg10 
                 si142_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_aob112014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("aob112014"); 
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
       $this->si142_sequencial = ($this->si142_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si142_sequencial"]:$this->si142_sequencial);
       $this->si142_tiporegistro = ($this->si142_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si142_tiporegistro"]:$this->si142_tiporegistro);
       $this->si142_codreduzido = ($this->si142_codreduzido == ""?@$GLOBALS["HTTP_POST_VARS"]["si142_codreduzido"]:$this->si142_codreduzido);
       $this->si142_codfontrecursos = ($this->si142_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si142_codfontrecursos"]:$this->si142_codfontrecursos);
       $this->si142_valoranulacaofonte = ($this->si142_valoranulacaofonte == ""?@$GLOBALS["HTTP_POST_VARS"]["si142_valoranulacaofonte"]:$this->si142_valoranulacaofonte);
       $this->si142_mes = ($this->si142_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si142_mes"]:$this->si142_mes);
       $this->si142_reg10 = ($this->si142_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si142_reg10"]:$this->si142_reg10);
       $this->si142_instit = ($this->si142_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si142_instit"]:$this->si142_instit);
     }else{
       $this->si142_sequencial = ($this->si142_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si142_sequencial"]:$this->si142_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si142_sequencial){ 
      $this->atualizacampos();
     if($this->si142_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si142_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si142_codreduzido == null ){ 
       $this->si142_codreduzido = "0";
     }
     if($this->si142_codfontrecursos == null ){ 
       $this->si142_codfontrecursos = "0";
     }
     if($this->si142_valoranulacaofonte == null ){ 
       $this->si142_valoranulacaofonte = "0";
     }
     if($this->si142_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si142_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si142_reg10 == null ){ 
       $this->si142_reg10 = "0";
     }
     if($this->si142_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si142_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si142_sequencial == "" || $si142_sequencial == null ){
       $result = db_query("select nextval('aob112014_si142_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: aob112014_si142_sequencial_seq do campo: si142_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si142_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from aob112014_si142_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si142_sequencial)){
         $this->erro_sql = " Campo si142_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si142_sequencial = $si142_sequencial; 
       }
     }
     if(($this->si142_sequencial == null) || ($this->si142_sequencial == "") ){ 
       $this->erro_sql = " Campo si142_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into aob112014(
                                       si142_sequencial 
                                      ,si142_tiporegistro 
                                      ,si142_codreduzido 
                                      ,si142_codfontrecursos 
                                      ,si142_valoranulacaofonte 
                                      ,si142_mes 
                                      ,si142_reg10 
                                      ,si142_instit 
                       )
                values (
                                $this->si142_sequencial 
                               ,$this->si142_tiporegistro 
                               ,$this->si142_codreduzido 
                               ,$this->si142_codfontrecursos 
                               ,$this->si142_valoranulacaofonte 
                               ,$this->si142_mes 
                               ,$this->si142_reg10 
                               ,$this->si142_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "aob112014 ($this->si142_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "aob112014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "aob112014 ($this->si142_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si142_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si142_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011040,'$this->si142_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010371,2011040,'','".AddSlashes(pg_result($resaco,0,'si142_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010371,2011041,'','".AddSlashes(pg_result($resaco,0,'si142_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010371,2011043,'','".AddSlashes(pg_result($resaco,0,'si142_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010371,2011044,'','".AddSlashes(pg_result($resaco,0,'si142_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010371,2011045,'','".AddSlashes(pg_result($resaco,0,'si142_valoranulacaofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010371,2011046,'','".AddSlashes(pg_result($resaco,0,'si142_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010371,2011047,'','".AddSlashes(pg_result($resaco,0,'si142_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010371,2011655,'','".AddSlashes(pg_result($resaco,0,'si142_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si142_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update aob112014 set ";
     $virgula = "";
     if(trim($this->si142_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si142_sequencial"])){ 
        if(trim($this->si142_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si142_sequencial"])){ 
           $this->si142_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si142_sequencial = $this->si142_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si142_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si142_tiporegistro"])){ 
       $sql  .= $virgula." si142_tiporegistro = $this->si142_tiporegistro ";
       $virgula = ",";
       if(trim($this->si142_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si142_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si142_codreduzido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si142_codreduzido"])){ 
        if(trim($this->si142_codreduzido)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si142_codreduzido"])){ 
           $this->si142_codreduzido = "0" ; 
        } 
       $sql  .= $virgula." si142_codreduzido = $this->si142_codreduzido ";
       $virgula = ",";
     }
     if(trim($this->si142_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si142_codfontrecursos"])){ 
        if(trim($this->si142_codfontrecursos)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si142_codfontrecursos"])){ 
           $this->si142_codfontrecursos = "0" ; 
        } 
       $sql  .= $virgula." si142_codfontrecursos = $this->si142_codfontrecursos ";
       $virgula = ",";
     }
     if(trim($this->si142_valoranulacaofonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si142_valoranulacaofonte"])){ 
        if(trim($this->si142_valoranulacaofonte)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si142_valoranulacaofonte"])){ 
           $this->si142_valoranulacaofonte = "0" ; 
        } 
       $sql  .= $virgula." si142_valoranulacaofonte = $this->si142_valoranulacaofonte ";
       $virgula = ",";
     }
     if(trim($this->si142_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si142_mes"])){ 
       $sql  .= $virgula." si142_mes = $this->si142_mes ";
       $virgula = ",";
       if(trim($this->si142_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si142_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si142_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si142_reg10"])){ 
        if(trim($this->si142_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si142_reg10"])){ 
           $this->si142_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si142_reg10 = $this->si142_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si142_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si142_instit"])){ 
       $sql  .= $virgula." si142_instit = $this->si142_instit ";
       $virgula = ",";
       if(trim($this->si142_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si142_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si142_sequencial!=null){
       $sql .= " si142_sequencial = $this->si142_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si142_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011040,'$this->si142_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si142_sequencial"]) || $this->si142_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010371,2011040,'".AddSlashes(pg_result($resaco,$conresaco,'si142_sequencial'))."','$this->si142_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si142_tiporegistro"]) || $this->si142_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010371,2011041,'".AddSlashes(pg_result($resaco,$conresaco,'si142_tiporegistro'))."','$this->si142_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si142_codreduzido"]) || $this->si142_codreduzido != "")
           $resac = db_query("insert into db_acount values($acount,2010371,2011043,'".AddSlashes(pg_result($resaco,$conresaco,'si142_codreduzido'))."','$this->si142_codreduzido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si142_codfontrecursos"]) || $this->si142_codfontrecursos != "")
           $resac = db_query("insert into db_acount values($acount,2010371,2011044,'".AddSlashes(pg_result($resaco,$conresaco,'si142_codfontrecursos'))."','$this->si142_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si142_valoranulacaofonte"]) || $this->si142_valoranulacaofonte != "")
           $resac = db_query("insert into db_acount values($acount,2010371,2011045,'".AddSlashes(pg_result($resaco,$conresaco,'si142_valoranulacaofonte'))."','$this->si142_valoranulacaofonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si142_mes"]) || $this->si142_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010371,2011046,'".AddSlashes(pg_result($resaco,$conresaco,'si142_mes'))."','$this->si142_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si142_reg10"]) || $this->si142_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010371,2011047,'".AddSlashes(pg_result($resaco,$conresaco,'si142_reg10'))."','$this->si142_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si142_instit"]) || $this->si142_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010371,2011655,'".AddSlashes(pg_result($resaco,$conresaco,'si142_instit'))."','$this->si142_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aob112014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si142_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aob112014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si142_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si142_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si142_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si142_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011040,'$si142_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010371,2011040,'','".AddSlashes(pg_result($resaco,$iresaco,'si142_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010371,2011041,'','".AddSlashes(pg_result($resaco,$iresaco,'si142_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010371,2011043,'','".AddSlashes(pg_result($resaco,$iresaco,'si142_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010371,2011044,'','".AddSlashes(pg_result($resaco,$iresaco,'si142_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010371,2011045,'','".AddSlashes(pg_result($resaco,$iresaco,'si142_valoranulacaofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010371,2011046,'','".AddSlashes(pg_result($resaco,$iresaco,'si142_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010371,2011047,'','".AddSlashes(pg_result($resaco,$iresaco,'si142_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010371,2011655,'','".AddSlashes(pg_result($resaco,$iresaco,'si142_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from aob112014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si142_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si142_sequencial = $si142_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aob112014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si142_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aob112014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si142_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si142_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:aob112014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si142_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aob112014 ";
     $sql .= "      left  join aob102014  on  aob102014.si141_sequencial = aob112014.si142_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si142_sequencial!=null ){
         $sql2 .= " where aob112014.si142_sequencial = $si142_sequencial "; 
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
   function sql_query_file ( $si142_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aob112014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si142_sequencial!=null ){
         $sql2 .= " where aob112014.si142_sequencial = $si142_sequencial "; 
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
