<?
//MODULO: sicom
//CLASSE DA ENTIDADE aberlic122016
class cl_aberlic122016 { 
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
   var $si48_sequencial = 0; 
   var $si48_tiporegistro = 0; 
   var $si48_codorgaoresp = null; 
   var $si48_codunidadesubresp = null; 
   var $si48_exerciciolicitacao = 0; 
   var $si48_nroprocessolicitatorio = null; 
   var $si48_coditem = 0; 
   var $si48_nroitem = 0; 
   var $si48_mes = 0; 
   var $si48_reg10 = 0; 
   var $si48_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si48_sequencial = int8 = sequencial 
                 si48_tiporegistro = int8 = Tipo do  registro 
                 si48_codorgaoresp = varchar(2) = Código do órgão 
                 si48_codunidadesubresp = varchar(8) = Código da unidade 
                 si48_exerciciolicitacao = int8 = Exercício 
                 si48_nroprocessolicitatorio = varchar(12) = Número sequencial do processo 
                 si48_coditem = int8 = Código do Item 
                 si48_nroitem = int8 = Número do Item 
                 si48_mes = int8 = Mês 
                 si48_reg10 = int8 = reg10 
                 si48_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_aberlic122016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("aberlic122016"); 
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
       $this->si48_sequencial = ($this->si48_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si48_sequencial"]:$this->si48_sequencial);
       $this->si48_tiporegistro = ($this->si48_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si48_tiporegistro"]:$this->si48_tiporegistro);
       $this->si48_codorgaoresp = ($this->si48_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si48_codorgaoresp"]:$this->si48_codorgaoresp);
       $this->si48_codunidadesubresp = ($this->si48_codunidadesubresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si48_codunidadesubresp"]:$this->si48_codunidadesubresp);
       $this->si48_exerciciolicitacao = ($this->si48_exerciciolicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si48_exerciciolicitacao"]:$this->si48_exerciciolicitacao);
       $this->si48_nroprocessolicitatorio = ($this->si48_nroprocessolicitatorio == ""?@$GLOBALS["HTTP_POST_VARS"]["si48_nroprocessolicitatorio"]:$this->si48_nroprocessolicitatorio);
       $this->si48_coditem = ($this->si48_coditem == ""?@$GLOBALS["HTTP_POST_VARS"]["si48_coditem"]:$this->si48_coditem);
       $this->si48_nroitem = ($this->si48_nroitem == ""?@$GLOBALS["HTTP_POST_VARS"]["si48_nroitem"]:$this->si48_nroitem);
       $this->si48_mes = ($this->si48_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si48_mes"]:$this->si48_mes);
       $this->si48_reg10 = ($this->si48_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si48_reg10"]:$this->si48_reg10);
       $this->si48_instit = ($this->si48_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si48_instit"]:$this->si48_instit);
     }else{
       $this->si48_sequencial = ($this->si48_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si48_sequencial"]:$this->si48_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si48_sequencial){ 
      $this->atualizacampos();
     if($this->si48_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si48_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si48_exerciciolicitacao == null ){ 
       $this->si48_exerciciolicitacao = "0";
     }
     if($this->si48_coditem == null ){ 
       $this->si48_coditem = "0";
     }
     if($this->si48_nroitem == null ){ 
       $this->si48_nroitem = "0";
     }
     if($this->si48_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si48_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si48_reg10 == null ){ 
       $this->si48_reg10 = "0";
     }
     if($this->si48_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si48_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si48_sequencial == "" || $si48_sequencial == null ){
       $result = db_query("select nextval('aberlic122016_si48_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: aberlic122016_si48_sequencial_seq do campo: si48_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si48_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from aberlic122016_si48_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si48_sequencial)){
         $this->erro_sql = " Campo si48_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si48_sequencial = $si48_sequencial; 
       }
     }
     if(($this->si48_sequencial == null) || ($this->si48_sequencial == "") ){ 
       $this->erro_sql = " Campo si48_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into aberlic122016(
                                       si48_sequencial 
                                      ,si48_tiporegistro 
                                      ,si48_codorgaoresp 
                                      ,si48_codunidadesubresp 
                                      ,si48_exerciciolicitacao 
                                      ,si48_nroprocessolicitatorio 
                                      ,si48_coditem 
                                      ,si48_nroitem 
                                      ,si48_mes 
                                      ,si48_reg10 
                                      ,si48_instit 
                       )
                values (
                                $this->si48_sequencial 
                               ,$this->si48_tiporegistro 
                               ,'$this->si48_codorgaoresp' 
                               ,'$this->si48_codunidadesubresp' 
                               ,$this->si48_exerciciolicitacao 
                               ,'$this->si48_nroprocessolicitatorio' 
                               ,$this->si48_coditem 
                               ,$this->si48_nroitem 
                               ,$this->si48_mes 
                               ,$this->si48_reg10 
                               ,$this->si48_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "aberlic122016 ($this->si48_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "aberlic122016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "aberlic122016 ($this->si48_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si48_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si48_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009909,'$this->si48_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010277,2009909,'','".AddSlashes(pg_result($resaco,0,'si48_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010277,2009910,'','".AddSlashes(pg_result($resaco,0,'si48_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010277,2009911,'','".AddSlashes(pg_result($resaco,0,'si48_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010277,2009912,'','".AddSlashes(pg_result($resaco,0,'si48_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010277,2009913,'','".AddSlashes(pg_result($resaco,0,'si48_exerciciolicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010277,2009914,'','".AddSlashes(pg_result($resaco,0,'si48_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010277,2009915,'','".AddSlashes(pg_result($resaco,0,'si48_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010277,2009916,'','".AddSlashes(pg_result($resaco,0,'si48_nroitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010277,2009917,'','".AddSlashes(pg_result($resaco,0,'si48_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010277,2009918,'','".AddSlashes(pg_result($resaco,0,'si48_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010277,2011562,'','".AddSlashes(pg_result($resaco,0,'si48_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si48_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update aberlic122016 set ";
     $virgula = "";
     if(trim($this->si48_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si48_sequencial"])){ 
        if(trim($this->si48_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si48_sequencial"])){ 
           $this->si48_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si48_sequencial = $this->si48_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si48_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si48_tiporegistro"])){ 
       $sql  .= $virgula." si48_tiporegistro = $this->si48_tiporegistro ";
       $virgula = ",";
       if(trim($this->si48_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si48_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si48_codorgaoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si48_codorgaoresp"])){ 
       $sql  .= $virgula." si48_codorgaoresp = '$this->si48_codorgaoresp' ";
       $virgula = ",";
     }
     if(trim($this->si48_codunidadesubresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si48_codunidadesubresp"])){ 
       $sql  .= $virgula." si48_codunidadesubresp = '$this->si48_codunidadesubresp' ";
       $virgula = ",";
     }
     if(trim($this->si48_exerciciolicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si48_exerciciolicitacao"])){ 
        if(trim($this->si48_exerciciolicitacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si48_exerciciolicitacao"])){ 
           $this->si48_exerciciolicitacao = "0" ; 
        } 
       $sql  .= $virgula." si48_exerciciolicitacao = $this->si48_exerciciolicitacao ";
       $virgula = ",";
     }
     if(trim($this->si48_nroprocessolicitatorio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si48_nroprocessolicitatorio"])){ 
       $sql  .= $virgula." si48_nroprocessolicitatorio = '$this->si48_nroprocessolicitatorio' ";
       $virgula = ",";
     }
     if(trim($this->si48_coditem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si48_coditem"])){ 
        if(trim($this->si48_coditem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si48_coditem"])){ 
           $this->si48_coditem = "0" ; 
        } 
       $sql  .= $virgula." si48_coditem = $this->si48_coditem ";
       $virgula = ",";
     }
     if(trim($this->si48_nroitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si48_nroitem"])){ 
        if(trim($this->si48_nroitem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si48_nroitem"])){ 
           $this->si48_nroitem = "0" ; 
        } 
       $sql  .= $virgula." si48_nroitem = $this->si48_nroitem ";
       $virgula = ",";
     }
     if(trim($this->si48_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si48_mes"])){ 
       $sql  .= $virgula." si48_mes = $this->si48_mes ";
       $virgula = ",";
       if(trim($this->si48_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si48_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si48_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si48_reg10"])){ 
        if(trim($this->si48_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si48_reg10"])){ 
           $this->si48_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si48_reg10 = $this->si48_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si48_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si48_instit"])){ 
       $sql  .= $virgula." si48_instit = $this->si48_instit ";
       $virgula = ",";
       if(trim($this->si48_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si48_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si48_sequencial!=null){
       $sql .= " si48_sequencial = $this->si48_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si48_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009909,'$this->si48_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si48_sequencial"]) || $this->si48_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010277,2009909,'".AddSlashes(pg_result($resaco,$conresaco,'si48_sequencial'))."','$this->si48_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si48_tiporegistro"]) || $this->si48_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010277,2009910,'".AddSlashes(pg_result($resaco,$conresaco,'si48_tiporegistro'))."','$this->si48_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si48_codorgaoresp"]) || $this->si48_codorgaoresp != "")
           $resac = db_query("insert into db_acount values($acount,2010277,2009911,'".AddSlashes(pg_result($resaco,$conresaco,'si48_codorgaoresp'))."','$this->si48_codorgaoresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si48_codunidadesubresp"]) || $this->si48_codunidadesubresp != "")
           $resac = db_query("insert into db_acount values($acount,2010277,2009912,'".AddSlashes(pg_result($resaco,$conresaco,'si48_codunidadesubresp'))."','$this->si48_codunidadesubresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si48_exerciciolicitacao"]) || $this->si48_exerciciolicitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010277,2009913,'".AddSlashes(pg_result($resaco,$conresaco,'si48_exerciciolicitacao'))."','$this->si48_exerciciolicitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si48_nroprocessolicitatorio"]) || $this->si48_nroprocessolicitatorio != "")
           $resac = db_query("insert into db_acount values($acount,2010277,2009914,'".AddSlashes(pg_result($resaco,$conresaco,'si48_nroprocessolicitatorio'))."','$this->si48_nroprocessolicitatorio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si48_coditem"]) || $this->si48_coditem != "")
           $resac = db_query("insert into db_acount values($acount,2010277,2009915,'".AddSlashes(pg_result($resaco,$conresaco,'si48_coditem'))."','$this->si48_coditem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si48_nroitem"]) || $this->si48_nroitem != "")
           $resac = db_query("insert into db_acount values($acount,2010277,2009916,'".AddSlashes(pg_result($resaco,$conresaco,'si48_nroitem'))."','$this->si48_nroitem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si48_mes"]) || $this->si48_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010277,2009917,'".AddSlashes(pg_result($resaco,$conresaco,'si48_mes'))."','$this->si48_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si48_reg10"]) || $this->si48_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010277,2009918,'".AddSlashes(pg_result($resaco,$conresaco,'si48_reg10'))."','$this->si48_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si48_instit"]) || $this->si48_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010277,2011562,'".AddSlashes(pg_result($resaco,$conresaco,'si48_instit'))."','$this->si48_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aberlic122016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si48_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aberlic122016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si48_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si48_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si48_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si48_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009909,'$si48_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010277,2009909,'','".AddSlashes(pg_result($resaco,$iresaco,'si48_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010277,2009910,'','".AddSlashes(pg_result($resaco,$iresaco,'si48_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010277,2009911,'','".AddSlashes(pg_result($resaco,$iresaco,'si48_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010277,2009912,'','".AddSlashes(pg_result($resaco,$iresaco,'si48_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010277,2009913,'','".AddSlashes(pg_result($resaco,$iresaco,'si48_exerciciolicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010277,2009914,'','".AddSlashes(pg_result($resaco,$iresaco,'si48_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010277,2009915,'','".AddSlashes(pg_result($resaco,$iresaco,'si48_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010277,2009916,'','".AddSlashes(pg_result($resaco,$iresaco,'si48_nroitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010277,2009917,'','".AddSlashes(pg_result($resaco,$iresaco,'si48_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010277,2009918,'','".AddSlashes(pg_result($resaco,$iresaco,'si48_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010277,2011562,'','".AddSlashes(pg_result($resaco,$iresaco,'si48_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from aberlic122016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si48_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si48_sequencial = $si48_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aberlic122016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si48_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aberlic122016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si48_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si48_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:aberlic122016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si48_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aberlic122016 ";
     $sql .= "      left  join aberlic102016  on  aberlic102016.si46_sequencial = aberlic122016.si48_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si48_sequencial!=null ){
         $sql2 .= " where aberlic122016.si48_sequencial = $si48_sequencial "; 
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
   function sql_query_file ( $si48_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aberlic122016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si48_sequencial!=null ){
         $sql2 .= " where aberlic122016.si48_sequencial = $si48_sequencial "; 
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
