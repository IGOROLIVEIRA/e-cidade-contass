<?
//MODULO: sicom
//CLASSE DA ENTIDADE aberlic152016
class cl_aberlic152016 { 
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
   var $si51_sequencial = 0; 
   var $si51_tiporegistro = 0; 
   var $si51_codorgaoresp = null; 
   var $si51_codunidadesubresp = null; 
   var $si51_exerciciolicitacao = 0; 
   var $si51_nroprocessolicitatorio = null; 
   var $si51_nrolote = 0; 
   var $si51_coditem = 0; 
   var $si51_vlitem = 0; 
   var $si51_mes = 0; 
   var $si51_reg10 = 0; 
   var $si51_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si51_sequencial = int8 = sequencial 
                 si51_tiporegistro = int8 = Tipo do  registro 
                 si51_codorgaoresp = varchar(2) = Código do órgão responsável 
                 si51_codunidadesubresp = varchar(8) = Código da unidade 
                 si51_exerciciolicitacao = int8 = Exercício em que   foi instaurado 
                 si51_nroprocessolicitatorio = varchar(12) = Número sequencial   do processo 
                 si51_nrolote = int8 = Número do Lote 
                 si51_coditem = int8 = Código do Item 
                 si51_vlitem = float8 = Valor do Item 
                 si51_mes = int8 = Mês 
                 si51_reg10 = int8 = reg10 
                 si51_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_aberlic152016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("aberlic152016"); 
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
       $this->si51_sequencial = ($this->si51_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_sequencial"]:$this->si51_sequencial);
       $this->si51_tiporegistro = ($this->si51_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_tiporegistro"]:$this->si51_tiporegistro);
       $this->si51_codorgaoresp = ($this->si51_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_codorgaoresp"]:$this->si51_codorgaoresp);
       $this->si51_codunidadesubresp = ($this->si51_codunidadesubresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_codunidadesubresp"]:$this->si51_codunidadesubresp);
       $this->si51_exerciciolicitacao = ($this->si51_exerciciolicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_exerciciolicitacao"]:$this->si51_exerciciolicitacao);
       $this->si51_nroprocessolicitatorio = ($this->si51_nroprocessolicitatorio == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_nroprocessolicitatorio"]:$this->si51_nroprocessolicitatorio);
       $this->si51_nrolote = ($this->si51_nrolote == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_nrolote"]:$this->si51_nrolote);
       $this->si51_coditem = ($this->si51_coditem == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_coditem"]:$this->si51_coditem);
       $this->si51_vlitem = ($this->si51_vlitem == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_vlitem"]:$this->si51_vlitem);
       $this->si51_mes = ($this->si51_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_mes"]:$this->si51_mes);
       $this->si51_reg10 = ($this->si51_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_reg10"]:$this->si51_reg10);
       $this->si51_instit = ($this->si51_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_instit"]:$this->si51_instit);
     }else{
       $this->si51_sequencial = ($this->si51_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si51_sequencial"]:$this->si51_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si51_sequencial){ 
      $this->atualizacampos();
     if($this->si51_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si51_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si51_exerciciolicitacao == null ){ 
       $this->si51_exerciciolicitacao = "0";
     }
     if($this->si51_nrolote == null ){ 
       $this->si51_nrolote = "0";
     }
     if($this->si51_coditem == null ){ 
       $this->si51_coditem = "0";
     }
     if($this->si51_vlitem == null ){ 
       $this->si51_vlitem = "0";
     }
     if($this->si51_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si51_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si51_reg10 == null ){ 
       $this->si51_reg10 = "0";
     }
     if($this->si51_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si51_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si51_sequencial == "" || $si51_sequencial == null ){
       $result = db_query("select nextval('aberlic152016_si51_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: aberlic152016_si51_sequencial_seq do campo: si51_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si51_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from aberlic152016_si51_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si51_sequencial)){
         $this->erro_sql = " Campo si51_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si51_sequencial = $si51_sequencial; 
       }
     }
     if(($this->si51_sequencial == null) || ($this->si51_sequencial == "") ){ 
       $this->erro_sql = " Campo si51_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into aberlic152016(
                                       si51_sequencial 
                                      ,si51_tiporegistro 
                                      ,si51_codorgaoresp 
                                      ,si51_codunidadesubresp 
                                      ,si51_exerciciolicitacao 
                                      ,si51_nroprocessolicitatorio 
                                      ,si51_nrolote 
                                      ,si51_coditem 
                                      ,si51_vlitem 
                                      ,si51_mes 
                                      ,si51_reg10 
                                      ,si51_instit 
                       )
                values (
                                $this->si51_sequencial 
                               ,$this->si51_tiporegistro 
                               ,'$this->si51_codorgaoresp' 
                               ,'$this->si51_codunidadesubresp' 
                               ,$this->si51_exerciciolicitacao 
                               ,'$this->si51_nroprocessolicitatorio' 
                               ,$this->si51_nrolote 
                               ,$this->si51_coditem 
                               ,$this->si51_vlitem 
                               ,$this->si51_mes 
                               ,$this->si51_reg10 
                               ,$this->si51_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "aberlic152016 ($this->si51_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "aberlic152016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "aberlic152016 ($this->si51_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si51_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si51_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009944,'$this->si51_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010280,2009944,'','".AddSlashes(pg_result($resaco,0,'si51_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010280,2009945,'','".AddSlashes(pg_result($resaco,0,'si51_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010280,2009946,'','".AddSlashes(pg_result($resaco,0,'si51_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010280,2009947,'','".AddSlashes(pg_result($resaco,0,'si51_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010280,2009948,'','".AddSlashes(pg_result($resaco,0,'si51_exerciciolicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010280,2009949,'','".AddSlashes(pg_result($resaco,0,'si51_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010280,2009950,'','".AddSlashes(pg_result($resaco,0,'si51_nrolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010280,2009951,'','".AddSlashes(pg_result($resaco,0,'si51_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010280,2009952,'','".AddSlashes(pg_result($resaco,0,'si51_vlitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010280,2009953,'','".AddSlashes(pg_result($resaco,0,'si51_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010280,2009954,'','".AddSlashes(pg_result($resaco,0,'si51_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010280,2011565,'','".AddSlashes(pg_result($resaco,0,'si51_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si51_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update aberlic152016 set ";
     $virgula = "";
     if(trim($this->si51_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si51_sequencial"])){ 
        if(trim($this->si51_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si51_sequencial"])){ 
           $this->si51_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si51_sequencial = $this->si51_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si51_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si51_tiporegistro"])){ 
       $sql  .= $virgula." si51_tiporegistro = $this->si51_tiporegistro ";
       $virgula = ",";
       if(trim($this->si51_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si51_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si51_codorgaoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si51_codorgaoresp"])){ 
       $sql  .= $virgula." si51_codorgaoresp = '$this->si51_codorgaoresp' ";
       $virgula = ",";
     }
     if(trim($this->si51_codunidadesubresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si51_codunidadesubresp"])){ 
       $sql  .= $virgula." si51_codunidadesubresp = '$this->si51_codunidadesubresp' ";
       $virgula = ",";
     }
     if(trim($this->si51_exerciciolicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si51_exerciciolicitacao"])){ 
        if(trim($this->si51_exerciciolicitacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si51_exerciciolicitacao"])){ 
           $this->si51_exerciciolicitacao = "0" ; 
        } 
       $sql  .= $virgula." si51_exerciciolicitacao = $this->si51_exerciciolicitacao ";
       $virgula = ",";
     }
     if(trim($this->si51_nroprocessolicitatorio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si51_nroprocessolicitatorio"])){ 
       $sql  .= $virgula." si51_nroprocessolicitatorio = '$this->si51_nroprocessolicitatorio' ";
       $virgula = ",";
     }
     if(trim($this->si51_nrolote)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si51_nrolote"])){ 
        if(trim($this->si51_nrolote)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si51_nrolote"])){ 
           $this->si51_nrolote = "0" ; 
        } 
       $sql  .= $virgula." si51_nrolote = $this->si51_nrolote ";
       $virgula = ",";
     }
     if(trim($this->si51_coditem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si51_coditem"])){ 
        if(trim($this->si51_coditem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si51_coditem"])){ 
           $this->si51_coditem = "0" ; 
        } 
       $sql  .= $virgula." si51_coditem = $this->si51_coditem ";
       $virgula = ",";
     }
     if(trim($this->si51_vlitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si51_vlitem"])){ 
        if(trim($this->si51_vlitem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si51_vlitem"])){ 
           $this->si51_vlitem = "0" ; 
        } 
       $sql  .= $virgula." si51_vlitem = $this->si51_vlitem ";
       $virgula = ",";
     }
     if(trim($this->si51_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si51_mes"])){ 
       $sql  .= $virgula." si51_mes = $this->si51_mes ";
       $virgula = ",";
       if(trim($this->si51_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si51_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si51_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si51_reg10"])){ 
        if(trim($this->si51_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si51_reg10"])){ 
           $this->si51_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si51_reg10 = $this->si51_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si51_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si51_instit"])){ 
       $sql  .= $virgula." si51_instit = $this->si51_instit ";
       $virgula = ",";
       if(trim($this->si51_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si51_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si51_sequencial!=null){
       $sql .= " si51_sequencial = $this->si51_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si51_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009944,'$this->si51_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si51_sequencial"]) || $this->si51_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010280,2009944,'".AddSlashes(pg_result($resaco,$conresaco,'si51_sequencial'))."','$this->si51_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si51_tiporegistro"]) || $this->si51_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010280,2009945,'".AddSlashes(pg_result($resaco,$conresaco,'si51_tiporegistro'))."','$this->si51_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si51_codorgaoresp"]) || $this->si51_codorgaoresp != "")
           $resac = db_query("insert into db_acount values($acount,2010280,2009946,'".AddSlashes(pg_result($resaco,$conresaco,'si51_codorgaoresp'))."','$this->si51_codorgaoresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si51_codunidadesubresp"]) || $this->si51_codunidadesubresp != "")
           $resac = db_query("insert into db_acount values($acount,2010280,2009947,'".AddSlashes(pg_result($resaco,$conresaco,'si51_codunidadesubresp'))."','$this->si51_codunidadesubresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si51_exerciciolicitacao"]) || $this->si51_exerciciolicitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010280,2009948,'".AddSlashes(pg_result($resaco,$conresaco,'si51_exerciciolicitacao'))."','$this->si51_exerciciolicitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si51_nroprocessolicitatorio"]) || $this->si51_nroprocessolicitatorio != "")
           $resac = db_query("insert into db_acount values($acount,2010280,2009949,'".AddSlashes(pg_result($resaco,$conresaco,'si51_nroprocessolicitatorio'))."','$this->si51_nroprocessolicitatorio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si51_nrolote"]) || $this->si51_nrolote != "")
           $resac = db_query("insert into db_acount values($acount,2010280,2009950,'".AddSlashes(pg_result($resaco,$conresaco,'si51_nrolote'))."','$this->si51_nrolote',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si51_coditem"]) || $this->si51_coditem != "")
           $resac = db_query("insert into db_acount values($acount,2010280,2009951,'".AddSlashes(pg_result($resaco,$conresaco,'si51_coditem'))."','$this->si51_coditem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si51_vlitem"]) || $this->si51_vlitem != "")
           $resac = db_query("insert into db_acount values($acount,2010280,2009952,'".AddSlashes(pg_result($resaco,$conresaco,'si51_vlitem'))."','$this->si51_vlitem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si51_mes"]) || $this->si51_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010280,2009953,'".AddSlashes(pg_result($resaco,$conresaco,'si51_mes'))."','$this->si51_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si51_reg10"]) || $this->si51_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010280,2009954,'".AddSlashes(pg_result($resaco,$conresaco,'si51_reg10'))."','$this->si51_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si51_instit"]) || $this->si51_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010280,2011565,'".AddSlashes(pg_result($resaco,$conresaco,'si51_instit'))."','$this->si51_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aberlic152016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si51_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aberlic152016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si51_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si51_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si51_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si51_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009944,'$si51_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010280,2009944,'','".AddSlashes(pg_result($resaco,$iresaco,'si51_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010280,2009945,'','".AddSlashes(pg_result($resaco,$iresaco,'si51_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010280,2009946,'','".AddSlashes(pg_result($resaco,$iresaco,'si51_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010280,2009947,'','".AddSlashes(pg_result($resaco,$iresaco,'si51_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010280,2009948,'','".AddSlashes(pg_result($resaco,$iresaco,'si51_exerciciolicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010280,2009949,'','".AddSlashes(pg_result($resaco,$iresaco,'si51_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010280,2009950,'','".AddSlashes(pg_result($resaco,$iresaco,'si51_nrolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010280,2009951,'','".AddSlashes(pg_result($resaco,$iresaco,'si51_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010280,2009952,'','".AddSlashes(pg_result($resaco,$iresaco,'si51_vlitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010280,2009953,'','".AddSlashes(pg_result($resaco,$iresaco,'si51_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010280,2009954,'','".AddSlashes(pg_result($resaco,$iresaco,'si51_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010280,2011565,'','".AddSlashes(pg_result($resaco,$iresaco,'si51_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from aberlic152016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si51_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si51_sequencial = $si51_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aberlic152016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si51_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aberlic152016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si51_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si51_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:aberlic152016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si51_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aberlic152016 ";
     $sql .= "      left  join aberlic102016  on  aberlic102016.si46_sequencial = aberlic152016.si51_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si51_sequencial!=null ){
         $sql2 .= " where aberlic152016.si51_sequencial = $si51_sequencial "; 
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
   function sql_query_file ( $si51_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aberlic152016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si51_sequencial!=null ){
         $sql2 .= " where aberlic152016.si51_sequencial = $si51_sequencial "; 
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
