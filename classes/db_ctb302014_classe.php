<?
//MODULO: sicom
//CLASSE DA ENTIDADE ctb302014
class cl_ctb302014 { 
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
   var $si99_sequencial = 0; 
   var $si99_tiporegistro = 0; 
   var $si99_codorgao = null; 
   var $si99_codagentearrecadador = 0; 
   var $si99_dscagentearrecadador = null; 
   var $si99_vlsaldoinicial = 0; 
   var $si99_vlsaldofinal = 0; 
   var $si99_mes = 0; 
   var $si99_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si99_sequencial = int8 = sequencial 
                 si99_tiporegistro = int8 = Tipo do registro 
                 si99_codorgao = varchar(2) = Código do órgão 
                 si99_codagentearrecadador = int8 = Código do agente  arrecadador 
                 si99_dscagentearrecadador = varchar(50) = Descrição do  agente  arrecadador 
                 si99_vlsaldoinicial = float8 = Valor do saldo no  início do mês 
                 si99_vlsaldofinal = float8 = Valor do saldo no  final do mês 
                 si99_mes = int8 = Mês 
                 si99_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ctb302014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ctb302014"); 
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
       $this->si99_sequencial = ($this->si99_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si99_sequencial"]:$this->si99_sequencial);
       $this->si99_tiporegistro = ($this->si99_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si99_tiporegistro"]:$this->si99_tiporegistro);
       $this->si99_codorgao = ($this->si99_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si99_codorgao"]:$this->si99_codorgao);
       $this->si99_codagentearrecadador = ($this->si99_codagentearrecadador == ""?@$GLOBALS["HTTP_POST_VARS"]["si99_codagentearrecadador"]:$this->si99_codagentearrecadador);
       $this->si99_dscagentearrecadador = ($this->si99_dscagentearrecadador == ""?@$GLOBALS["HTTP_POST_VARS"]["si99_dscagentearrecadador"]:$this->si99_dscagentearrecadador);
       $this->si99_vlsaldoinicial = ($this->si99_vlsaldoinicial == ""?@$GLOBALS["HTTP_POST_VARS"]["si99_vlsaldoinicial"]:$this->si99_vlsaldoinicial);
       $this->si99_vlsaldofinal = ($this->si99_vlsaldofinal == ""?@$GLOBALS["HTTP_POST_VARS"]["si99_vlsaldofinal"]:$this->si99_vlsaldofinal);
       $this->si99_mes = ($this->si99_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si99_mes"]:$this->si99_mes);
       $this->si99_instit = ($this->si99_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si99_instit"]:$this->si99_instit);
     }else{
       $this->si99_sequencial = ($this->si99_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si99_sequencial"]:$this->si99_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si99_sequencial){ 
      $this->atualizacampos();
     if($this->si99_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do registro nao Informado.";
       $this->erro_campo = "si99_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si99_codorgao == null ){ 
       $this->erro_sql = " Campo Código do órgão nao Informado.";
       $this->erro_campo = "si99_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si99_codagentearrecadador == null ){ 
       $this->erro_sql = " Campo Código do agente  arrecadador nao Informado.";
       $this->erro_campo = "si99_codagentearrecadador";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si99_dscagentearrecadador == null ){ 
       $this->erro_sql = " Campo Descrição do  agente  arrecadador nao Informado.";
       $this->erro_campo = "si99_dscagentearrecadador";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si99_vlsaldoinicial == null ){ 
       $this->erro_sql = " Campo Valor do saldo no  início do mês nao Informado.";
       $this->erro_campo = "si99_vlsaldoinicial";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si99_vlsaldofinal == null ){ 
       $this->erro_sql = " Campo Valor do saldo no  final do mês nao Informado.";
       $this->erro_campo = "si99_vlsaldofinal";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si99_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si99_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si99_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si99_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si99_sequencial == "" || $si99_sequencial == null ){
       $result = db_query("select nextval('ctb302014_si99_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ctb302014_si99_sequencial_seq do campo: si99_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si99_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ctb302014_si99_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si99_sequencial)){
         $this->erro_sql = " Campo si99_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si99_sequencial = $si99_sequencial; 
       }
     }
     if(($this->si99_sequencial == null) || ($this->si99_sequencial == "") ){ 
       $this->erro_sql = " Campo si99_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ctb302014(
                                       si99_sequencial 
                                      ,si99_tiporegistro 
                                      ,si99_codorgao 
                                      ,si99_codagentearrecadador 
                                      ,si99_dscagentearrecadador 
                                      ,si99_vlsaldoinicial 
                                      ,si99_vlsaldofinal 
                                      ,si99_mes 
                                      ,si99_instit 
                       )
                values (
                                $this->si99_sequencial 
                               ,$this->si99_tiporegistro 
                               ,'$this->si99_codorgao' 
                               ,$this->si99_codagentearrecadador 
                               ,'$this->si99_dscagentearrecadador' 
                               ,$this->si99_vlsaldoinicial 
                               ,$this->si99_vlsaldofinal 
                               ,$this->si99_mes 
                               ,$this->si99_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ctb302014 ($this->si99_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ctb302014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ctb302014 ($this->si99_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si99_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si99_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010588,'$this->si99_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010328,2010588,'','".AddSlashes(pg_result($resaco,0,'si99_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010328,2010589,'','".AddSlashes(pg_result($resaco,0,'si99_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010328,2010590,'','".AddSlashes(pg_result($resaco,0,'si99_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010328,2010591,'','".AddSlashes(pg_result($resaco,0,'si99_codagentearrecadador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010328,2010592,'','".AddSlashes(pg_result($resaco,0,'si99_dscagentearrecadador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010328,2010593,'','".AddSlashes(pg_result($resaco,0,'si99_vlsaldoinicial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010328,2010596,'','".AddSlashes(pg_result($resaco,0,'si99_vlsaldofinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010328,2010597,'','".AddSlashes(pg_result($resaco,0,'si99_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010328,2011611,'','".AddSlashes(pg_result($resaco,0,'si99_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si99_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ctb302014 set ";
     $virgula = "";
     if(trim($this->si99_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si99_sequencial"])){ 
       $sql  .= $virgula." si99_sequencial = $this->si99_sequencial ";
       $virgula = ",";
       if(trim($this->si99_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "si99_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si99_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si99_tiporegistro"])){ 
       $sql  .= $virgula." si99_tiporegistro = $this->si99_tiporegistro ";
       $virgula = ",";
       if(trim($this->si99_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do registro nao Informado.";
         $this->erro_campo = "si99_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si99_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si99_codorgao"])){ 
       $sql  .= $virgula." si99_codorgao = '$this->si99_codorgao' ";
       $virgula = ",";
       if(trim($this->si99_codorgao) == null ){ 
         $this->erro_sql = " Campo Código do órgão nao Informado.";
         $this->erro_campo = "si99_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si99_codagentearrecadador)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si99_codagentearrecadador"])){ 
       $sql  .= $virgula." si99_codagentearrecadador = $this->si99_codagentearrecadador ";
       $virgula = ",";
       if(trim($this->si99_codagentearrecadador) == null ){ 
         $this->erro_sql = " Campo Código do agente  arrecadador nao Informado.";
         $this->erro_campo = "si99_codagentearrecadador";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si99_dscagentearrecadador)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si99_dscagentearrecadador"])){ 
       $sql  .= $virgula." si99_dscagentearrecadador = '$this->si99_dscagentearrecadador' ";
       $virgula = ",";
       if(trim($this->si99_dscagentearrecadador) == null ){ 
         $this->erro_sql = " Campo Descrição do  agente  arrecadador nao Informado.";
         $this->erro_campo = "si99_dscagentearrecadador";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si99_vlsaldoinicial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si99_vlsaldoinicial"])){ 
       $sql  .= $virgula." si99_vlsaldoinicial = $this->si99_vlsaldoinicial ";
       $virgula = ",";
       if(trim($this->si99_vlsaldoinicial) == null ){ 
         $this->erro_sql = " Campo Valor do saldo no  início do mês nao Informado.";
         $this->erro_campo = "si99_vlsaldoinicial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si99_vlsaldofinal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si99_vlsaldofinal"])){ 
       $sql  .= $virgula." si99_vlsaldofinal = $this->si99_vlsaldofinal ";
       $virgula = ",";
       if(trim($this->si99_vlsaldofinal) == null ){ 
         $this->erro_sql = " Campo Valor do saldo no  final do mês nao Informado.";
         $this->erro_campo = "si99_vlsaldofinal";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si99_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si99_mes"])){ 
       $sql  .= $virgula." si99_mes = $this->si99_mes ";
       $virgula = ",";
       if(trim($this->si99_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si99_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si99_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si99_instit"])){ 
       $sql  .= $virgula." si99_instit = $this->si99_instit ";
       $virgula = ",";
       if(trim($this->si99_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si99_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si99_sequencial!=null){
       $sql .= " si99_sequencial = $this->si99_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si99_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010588,'$this->si99_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si99_sequencial"]) || $this->si99_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010328,2010588,'".AddSlashes(pg_result($resaco,$conresaco,'si99_sequencial'))."','$this->si99_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si99_tiporegistro"]) || $this->si99_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010328,2010589,'".AddSlashes(pg_result($resaco,$conresaco,'si99_tiporegistro'))."','$this->si99_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si99_codorgao"]) || $this->si99_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010328,2010590,'".AddSlashes(pg_result($resaco,$conresaco,'si99_codorgao'))."','$this->si99_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si99_codagentearrecadador"]) || $this->si99_codagentearrecadador != "")
           $resac = db_query("insert into db_acount values($acount,2010328,2010591,'".AddSlashes(pg_result($resaco,$conresaco,'si99_codagentearrecadador'))."','$this->si99_codagentearrecadador',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si99_dscagentearrecadador"]) || $this->si99_dscagentearrecadador != "")
           $resac = db_query("insert into db_acount values($acount,2010328,2010592,'".AddSlashes(pg_result($resaco,$conresaco,'si99_dscagentearrecadador'))."','$this->si99_dscagentearrecadador',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si99_vlsaldoinicial"]) || $this->si99_vlsaldoinicial != "")
           $resac = db_query("insert into db_acount values($acount,2010328,2010593,'".AddSlashes(pg_result($resaco,$conresaco,'si99_vlsaldoinicial'))."','$this->si99_vlsaldoinicial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si99_vlsaldofinal"]) || $this->si99_vlsaldofinal != "")
           $resac = db_query("insert into db_acount values($acount,2010328,2010596,'".AddSlashes(pg_result($resaco,$conresaco,'si99_vlsaldofinal'))."','$this->si99_vlsaldofinal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si99_mes"]) || $this->si99_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010328,2010597,'".AddSlashes(pg_result($resaco,$conresaco,'si99_mes'))."','$this->si99_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si99_instit"]) || $this->si99_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010328,2011611,'".AddSlashes(pg_result($resaco,$conresaco,'si99_instit'))."','$this->si99_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ctb302014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si99_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ctb302014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si99_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si99_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si99_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si99_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010588,'$si99_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010328,2010588,'','".AddSlashes(pg_result($resaco,$iresaco,'si99_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010328,2010589,'','".AddSlashes(pg_result($resaco,$iresaco,'si99_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010328,2010590,'','".AddSlashes(pg_result($resaco,$iresaco,'si99_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010328,2010591,'','".AddSlashes(pg_result($resaco,$iresaco,'si99_codagentearrecadador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010328,2010592,'','".AddSlashes(pg_result($resaco,$iresaco,'si99_dscagentearrecadador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010328,2010593,'','".AddSlashes(pg_result($resaco,$iresaco,'si99_vlsaldoinicial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010328,2010596,'','".AddSlashes(pg_result($resaco,$iresaco,'si99_vlsaldofinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010328,2010597,'','".AddSlashes(pg_result($resaco,$iresaco,'si99_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010328,2011611,'','".AddSlashes(pg_result($resaco,$iresaco,'si99_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ctb302014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si99_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si99_sequencial = $si99_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ctb302014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si99_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ctb302014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si99_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si99_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ctb302014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si99_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ctb302014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si99_sequencial!=null ){
         $sql2 .= " where ctb302014.si99_sequencial = $si99_sequencial "; 
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
   function sql_query_file ( $si99_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ctb302014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si99_sequencial!=null ){
         $sql2 .= " where ctb302014.si99_sequencial = $si99_sequencial "; 
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
