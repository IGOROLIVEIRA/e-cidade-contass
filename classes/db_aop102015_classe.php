<?
//MODULO: sicom
//CLASSE DA ENTIDADE aop102015
class cl_aop102015 { 
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
   var $si137_sequencial = 0; 
   var $si137_tiporegistro = 0; 
   var $si137_codreduzido = 0; 
   var $si137_codorgao = null; 
   var $si137_codunidadesub = null; 
   var $si137_nroop = 0; 
   var $si137_dtpagamento_dia = null; 
   var $si137_dtpagamento_mes = null; 
   var $si137_dtpagamento_ano = null; 
   var $si137_dtpagamento = null; 
   var $si137_nroanulacaoop = 0; 
   var $si137_dtanulacaoop_dia = null; 
   var $si137_dtanulacaoop_mes = null; 
   var $si137_dtanulacaoop_ano = null; 
   var $si137_dtanulacaoop = null; 
   var $si137_justificativaanulacao = null; 
   var $si137_vlanulacaoop = 0; 
   var $si137_mes = 0; 
   var $si137_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si137_sequencial = int8 = sequencial 
                 si137_tiporegistro = int8 = Tipo do  registro 
                 si137_codreduzido = int8 = Código identificador da anulação 
                 si137_codorgao = varchar(2) = Código do órgão 
                 si137_codunidadesub = varchar(8) = Código da unidade 
                 si137_nroop = int8 = Número da  Ordem de  Pagamento 
                 si137_dtpagamento = date = Data de  pagamento da  OP 
                 si137_nroanulacaoop = int8 = Número da  anulação da  ordem pagamento 
                 si137_dtanulacaoop = date = Data da anulação  da OP 
                 si137_justificativaanulacao = varchar(500) = Justificativa para a anulação 
                 si137_vlanulacaoop = float8 = Valor da  Anulação da OP 
                 si137_mes = int8 = Mês 
                 si137_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_aop102015() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("aop102015"); 
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
       $this->si137_sequencial = ($this->si137_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_sequencial"]:$this->si137_sequencial);
       $this->si137_tiporegistro = ($this->si137_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_tiporegistro"]:$this->si137_tiporegistro);
       $this->si137_codreduzido = ($this->si137_codreduzido == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_codreduzido"]:$this->si137_codreduzido);
       $this->si137_codorgao = ($this->si137_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_codorgao"]:$this->si137_codorgao);
       $this->si137_codunidadesub = ($this->si137_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_codunidadesub"]:$this->si137_codunidadesub);
       $this->si137_nroop = ($this->si137_nroop == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_nroop"]:$this->si137_nroop);
       if($this->si137_dtpagamento == ""){
         $this->si137_dtpagamento_dia = ($this->si137_dtpagamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_dtpagamento_dia"]:$this->si137_dtpagamento_dia);
         $this->si137_dtpagamento_mes = ($this->si137_dtpagamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_dtpagamento_mes"]:$this->si137_dtpagamento_mes);
         $this->si137_dtpagamento_ano = ($this->si137_dtpagamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_dtpagamento_ano"]:$this->si137_dtpagamento_ano);
         if($this->si137_dtpagamento_dia != ""){
            $this->si137_dtpagamento = $this->si137_dtpagamento_ano."-".$this->si137_dtpagamento_mes."-".$this->si137_dtpagamento_dia;
         }
       }
       $this->si137_nroanulacaoop = ($this->si137_nroanulacaoop == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_nroanulacaoop"]:$this->si137_nroanulacaoop);
       if($this->si137_dtanulacaoop == ""){
         $this->si137_dtanulacaoop_dia = ($this->si137_dtanulacaoop_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_dtanulacaoop_dia"]:$this->si137_dtanulacaoop_dia);
         $this->si137_dtanulacaoop_mes = ($this->si137_dtanulacaoop_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_dtanulacaoop_mes"]:$this->si137_dtanulacaoop_mes);
         $this->si137_dtanulacaoop_ano = ($this->si137_dtanulacaoop_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_dtanulacaoop_ano"]:$this->si137_dtanulacaoop_ano);
         if($this->si137_dtanulacaoop_dia != ""){
            $this->si137_dtanulacaoop = $this->si137_dtanulacaoop_ano."-".$this->si137_dtanulacaoop_mes."-".$this->si137_dtanulacaoop_dia;
         }
       }
       $this->si137_justificativaanulacao = ($this->si137_justificativaanulacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_justificativaanulacao"]:$this->si137_justificativaanulacao);
       $this->si137_vlanulacaoop = ($this->si137_vlanulacaoop == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_vlanulacaoop"]:$this->si137_vlanulacaoop);
       $this->si137_mes = ($this->si137_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_mes"]:$this->si137_mes);
       $this->si137_instit = ($this->si137_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_instit"]:$this->si137_instit);
     }else{
       $this->si137_sequencial = ($this->si137_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si137_sequencial"]:$this->si137_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si137_sequencial){ 
      $this->atualizacampos();
     if($this->si137_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si137_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si137_codreduzido == null ){ 
       $this->si137_codreduzido = "0";
     }
     if($this->si137_nroop == null ){ 
       $this->si137_nroop = "0";
     }
     if($this->si137_dtpagamento == null ){ 
       $this->si137_dtpagamento = "null";
     }
     if($this->si137_nroanulacaoop == null ){ 
       $this->si137_nroanulacaoop = "0";
     }
     if($this->si137_dtanulacaoop == null ){ 
       $this->si137_dtanulacaoop = "null";
     }
     if($this->si137_vlanulacaoop == null ){ 
       $this->si137_vlanulacaoop = "0";
     }
     if($this->si137_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si137_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si137_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si137_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si137_sequencial == "" || $si137_sequencial == null ){
       $result = db_query("select nextval('aop102015_si137_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: aop102015_si137_sequencial_seq do campo: si137_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si137_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from aop102015_si137_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si137_sequencial)){
         $this->erro_sql = " Campo si137_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si137_sequencial = $si137_sequencial; 
       }
     }
     if(($this->si137_sequencial == null) || ($this->si137_sequencial == "") ){ 
       $this->erro_sql = " Campo si137_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into aop102015(
                                       si137_sequencial 
                                      ,si137_tiporegistro 
                                      ,si137_codreduzido 
                                      ,si137_codorgao 
                                      ,si137_codunidadesub 
                                      ,si137_nroop 
                                      ,si137_dtpagamento 
                                      ,si137_nroanulacaoop 
                                      ,si137_dtanulacaoop 
                                      ,si137_justificativaanulacao 
                                      ,si137_vlanulacaoop 
                                      ,si137_mes 
                                      ,si137_instit 
                       )
                values (
                                $this->si137_sequencial 
                               ,$this->si137_tiporegistro 
                               ,$this->si137_codreduzido 
                               ,'$this->si137_codorgao' 
                               ,'$this->si137_codunidadesub' 
                               ,$this->si137_nroop 
                               ,".($this->si137_dtpagamento == "null" || $this->si137_dtpagamento == ""?"null":"'".$this->si137_dtpagamento."'")." 
                               ,$this->si137_nroanulacaoop 
                               ,".($this->si137_dtanulacaoop == "null" || $this->si137_dtanulacaoop == ""?"null":"'".$this->si137_dtanulacaoop."'")." 
                               ,'$this->si137_justificativaanulacao' 
                               ,$this->si137_vlanulacaoop 
                               ,$this->si137_mes 
                               ,$this->si137_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "aop102015 ($this->si137_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "aop102015 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "aop102015 ($this->si137_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si137_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si137_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010982,'$this->si137_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010366,2010982,'','".AddSlashes(pg_result($resaco,0,'si137_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010366,2010983,'','".AddSlashes(pg_result($resaco,0,'si137_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010366,2010984,'','".AddSlashes(pg_result($resaco,0,'si137_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010366,2010985,'','".AddSlashes(pg_result($resaco,0,'si137_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010366,2010986,'','".AddSlashes(pg_result($resaco,0,'si137_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010366,2010987,'','".AddSlashes(pg_result($resaco,0,'si137_nroop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010366,2010988,'','".AddSlashes(pg_result($resaco,0,'si137_dtpagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010366,2010989,'','".AddSlashes(pg_result($resaco,0,'si137_nroanulacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010366,2010990,'','".AddSlashes(pg_result($resaco,0,'si137_dtanulacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010366,2010991,'','".AddSlashes(pg_result($resaco,0,'si137_justificativaanulacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010366,2010992,'','".AddSlashes(pg_result($resaco,0,'si137_vlanulacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010366,2010993,'','".AddSlashes(pg_result($resaco,0,'si137_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010366,2011650,'','".AddSlashes(pg_result($resaco,0,'si137_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si137_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update aop102015 set ";
     $virgula = "";
     if(trim($this->si137_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_sequencial"])){ 
        if(trim($this->si137_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si137_sequencial"])){ 
           $this->si137_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si137_sequencial = $this->si137_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si137_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_tiporegistro"])){ 
       $sql  .= $virgula." si137_tiporegistro = $this->si137_tiporegistro ";
       $virgula = ",";
       if(trim($this->si137_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si137_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si137_codreduzido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_codreduzido"])){ 
        if(trim($this->si137_codreduzido)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si137_codreduzido"])){ 
           $this->si137_codreduzido = "0" ; 
        } 
       $sql  .= $virgula." si137_codreduzido = $this->si137_codreduzido ";
       $virgula = ",";
     }
     if(trim($this->si137_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_codorgao"])){ 
       $sql  .= $virgula." si137_codorgao = '$this->si137_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si137_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_codunidadesub"])){ 
       $sql  .= $virgula." si137_codunidadesub = '$this->si137_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si137_nroop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_nroop"])){ 
        if(trim($this->si137_nroop)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si137_nroop"])){ 
           $this->si137_nroop = "0" ; 
        } 
       $sql  .= $virgula." si137_nroop = $this->si137_nroop ";
       $virgula = ",";
     }
     if(trim($this->si137_dtpagamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_dtpagamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si137_dtpagamento_dia"] !="") ){ 
       $sql  .= $virgula." si137_dtpagamento = '$this->si137_dtpagamento' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si137_dtpagamento_dia"])){ 
         $sql  .= $virgula." si137_dtpagamento = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si137_nroanulacaoop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_nroanulacaoop"])){ 
        if(trim($this->si137_nroanulacaoop)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si137_nroanulacaoop"])){ 
           $this->si137_nroanulacaoop = "0" ; 
        } 
       $sql  .= $virgula." si137_nroanulacaoop = $this->si137_nroanulacaoop ";
       $virgula = ",";
     }
     if(trim($this->si137_dtanulacaoop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_dtanulacaoop_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si137_dtanulacaoop_dia"] !="") ){ 
       $sql  .= $virgula." si137_dtanulacaoop = '$this->si137_dtanulacaoop' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si137_dtanulacaoop_dia"])){ 
         $sql  .= $virgula." si137_dtanulacaoop = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si137_justificativaanulacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_justificativaanulacao"])){ 
       $sql  .= $virgula." si137_justificativaanulacao = '$this->si137_justificativaanulacao' ";
       $virgula = ",";
     }
     if(trim($this->si137_vlanulacaoop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_vlanulacaoop"])){ 
        if(trim($this->si137_vlanulacaoop)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si137_vlanulacaoop"])){ 
           $this->si137_vlanulacaoop = "0" ; 
        } 
       $sql  .= $virgula." si137_vlanulacaoop = $this->si137_vlanulacaoop ";
       $virgula = ",";
     }
     if(trim($this->si137_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_mes"])){ 
       $sql  .= $virgula." si137_mes = $this->si137_mes ";
       $virgula = ",";
       if(trim($this->si137_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si137_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si137_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si137_instit"])){ 
       $sql  .= $virgula." si137_instit = $this->si137_instit ";
       $virgula = ",";
       if(trim($this->si137_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si137_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si137_sequencial!=null){
       $sql .= " si137_sequencial = $this->si137_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si137_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010982,'$this->si137_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_sequencial"]) || $this->si137_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2010982,'".AddSlashes(pg_result($resaco,$conresaco,'si137_sequencial'))."','$this->si137_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_tiporegistro"]) || $this->si137_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2010983,'".AddSlashes(pg_result($resaco,$conresaco,'si137_tiporegistro'))."','$this->si137_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_codreduzido"]) || $this->si137_codreduzido != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2010984,'".AddSlashes(pg_result($resaco,$conresaco,'si137_codreduzido'))."','$this->si137_codreduzido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_codorgao"]) || $this->si137_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2010985,'".AddSlashes(pg_result($resaco,$conresaco,'si137_codorgao'))."','$this->si137_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_codunidadesub"]) || $this->si137_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2010986,'".AddSlashes(pg_result($resaco,$conresaco,'si137_codunidadesub'))."','$this->si137_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_nroop"]) || $this->si137_nroop != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2010987,'".AddSlashes(pg_result($resaco,$conresaco,'si137_nroop'))."','$this->si137_nroop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_dtpagamento"]) || $this->si137_dtpagamento != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2010988,'".AddSlashes(pg_result($resaco,$conresaco,'si137_dtpagamento'))."','$this->si137_dtpagamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_nroanulacaoop"]) || $this->si137_nroanulacaoop != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2010989,'".AddSlashes(pg_result($resaco,$conresaco,'si137_nroanulacaoop'))."','$this->si137_nroanulacaoop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_dtanulacaoop"]) || $this->si137_dtanulacaoop != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2010990,'".AddSlashes(pg_result($resaco,$conresaco,'si137_dtanulacaoop'))."','$this->si137_dtanulacaoop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_justificativaanulacao"]) || $this->si137_justificativaanulacao != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2010991,'".AddSlashes(pg_result($resaco,$conresaco,'si137_justificativaanulacao'))."','$this->si137_justificativaanulacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_vlanulacaoop"]) || $this->si137_vlanulacaoop != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2010992,'".AddSlashes(pg_result($resaco,$conresaco,'si137_vlanulacaoop'))."','$this->si137_vlanulacaoop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_mes"]) || $this->si137_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2010993,'".AddSlashes(pg_result($resaco,$conresaco,'si137_mes'))."','$this->si137_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si137_instit"]) || $this->si137_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010366,2011650,'".AddSlashes(pg_result($resaco,$conresaco,'si137_instit'))."','$this->si137_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aop102015 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si137_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aop102015 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si137_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si137_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si137_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si137_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010982,'$si137_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010366,2010982,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010366,2010983,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010366,2010984,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010366,2010985,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010366,2010986,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010366,2010987,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_nroop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010366,2010988,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_dtpagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010366,2010989,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_nroanulacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010366,2010990,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_dtanulacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010366,2010991,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_justificativaanulacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010366,2010992,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_vlanulacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010366,2010993,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010366,2011650,'','".AddSlashes(pg_result($resaco,$iresaco,'si137_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from aop102015
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si137_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si137_sequencial = $si137_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aop102015 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si137_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aop102015 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si137_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si137_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:aop102015";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si137_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aop102015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si137_sequencial!=null ){
         $sql2 .= " where aop102015.si137_sequencial = $si137_sequencial "; 
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
   function sql_query_file ( $si137_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aop102015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si137_sequencial!=null ){
         $sql2 .= " where aop102015.si137_sequencial = $si137_sequencial "; 
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
