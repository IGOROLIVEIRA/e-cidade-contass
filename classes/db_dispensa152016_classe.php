<?
//MODULO: sicom
//CLASSE DA ENTIDADE dispensa152016
class cl_dispensa152016 { 
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
   var $si79_sequencial = 0; 
   var $si79_tiporegistro = 0; 
   var $si79_codorgaoresp = null; 
   var $si79_codunidadesubresp = null; 
   var $si79_exercicioprocesso = 0; 
   var $si79_nroprocesso = null; 
   var $si79_tipoprocesso = 0; 
   var $si79_nrolote = 0; 
   var $si79_coditem = 0; 
   var $si79_vlcotprecosunitario = 0; 
   var $si79_quantidade = 0; 
   var $si79_mes = 0; 
   var $si79_reg10 = 0; 
   var $si79_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si79_sequencial = int8 = sequencial 
                 si79_tiporegistro = int8 = Tipo do  registro 
                 si79_codorgaoresp = varchar(2) = Código do órgão responsável 
                 si79_codunidadesubresp = varchar(8) = Código da unidade 
                 si79_exercicioprocesso = int8 = Exercício em que   foi instaurado 
                 si79_nroprocesso = varchar(12) = Número sequencial do processo 
                 si79_tipoprocesso = int8 = Tipo de processo 
                 si79_nrolote = int8 = Número do Lote 
                 si79_coditem = int8 = Código do Item 
                 si79_vlcotprecosunitario = float8 = Valor de referência 
                 si79_quantidade = float8 = Quantidade do item 
                 si79_mes = int8 = Mês 
                 si79_reg10 = int8 = reg10 
                 si79_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_dispensa152016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dispensa152016"); 
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
       $this->si79_sequencial = ($this->si79_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_sequencial"]:$this->si79_sequencial);
       $this->si79_tiporegistro = ($this->si79_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_tiporegistro"]:$this->si79_tiporegistro);
       $this->si79_codorgaoresp = ($this->si79_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_codorgaoresp"]:$this->si79_codorgaoresp);
       $this->si79_codunidadesubresp = ($this->si79_codunidadesubresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_codunidadesubresp"]:$this->si79_codunidadesubresp);
       $this->si79_exercicioprocesso = ($this->si79_exercicioprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_exercicioprocesso"]:$this->si79_exercicioprocesso);
       $this->si79_nroprocesso = ($this->si79_nroprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_nroprocesso"]:$this->si79_nroprocesso);
       $this->si79_tipoprocesso = ($this->si79_tipoprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_tipoprocesso"]:$this->si79_tipoprocesso);
       $this->si79_nrolote = ($this->si79_nrolote == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_nrolote"]:$this->si79_nrolote);
       $this->si79_coditem = ($this->si79_coditem == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_coditem"]:$this->si79_coditem);
       $this->si79_vlcotprecosunitario = ($this->si79_vlcotprecosunitario == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_vlcotprecosunitario"]:$this->si79_vlcotprecosunitario);
       $this->si79_quantidade = ($this->si79_quantidade == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_quantidade"]:$this->si79_quantidade);
       $this->si79_mes = ($this->si79_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_mes"]:$this->si79_mes);
       $this->si79_reg10 = ($this->si79_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_reg10"]:$this->si79_reg10);
       $this->si79_instit = ($this->si79_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_instit"]:$this->si79_instit);
     }else{
       $this->si79_sequencial = ($this->si79_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si79_sequencial"]:$this->si79_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si79_sequencial){ 
      $this->atualizacampos();
     if($this->si79_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si79_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si79_exercicioprocesso == null ){ 
       $this->si79_exercicioprocesso = "0";
     }
     if($this->si79_tipoprocesso == null ){ 
       $this->si79_tipoprocesso = "0";
     }
     if($this->si79_nrolote == null ){ 
       $this->si79_nrolote = "0";
     }
     if($this->si79_coditem == null ){ 
       $this->si79_coditem = "0";
     }
     if($this->si79_vlcotprecosunitario == null ){ 
       $this->si79_vlcotprecosunitario = "0";
     }
     if($this->si79_quantidade == null ){ 
       $this->si79_quantidade = "0";
     }
     if($this->si79_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si79_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si79_reg10 == null ){ 
       $this->si79_reg10 = "0";
     }
     if($this->si79_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si79_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si79_sequencial == "" || $si79_sequencial == null ){
       $result = db_query("select nextval('dispensa152016_si79_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dispensa152016_si79_sequencial_seq do campo: si79_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si79_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from dispensa152016_si79_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si79_sequencial)){
         $this->erro_sql = " Campo si79_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si79_sequencial = $si79_sequencial; 
       }
     }
     if(($this->si79_sequencial == null) || ($this->si79_sequencial == "") ){ 
       $this->erro_sql = " Campo si79_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dispensa152016(
                                       si79_sequencial 
                                      ,si79_tiporegistro 
                                      ,si79_codorgaoresp 
                                      ,si79_codunidadesubresp 
                                      ,si79_exercicioprocesso 
                                      ,si79_nroprocesso 
                                      ,si79_tipoprocesso 
                                      ,si79_nrolote 
                                      ,si79_coditem 
                                      ,si79_vlcotprecosunitario 
                                      ,si79_quantidade 
                                      ,si79_mes 
                                      ,si79_reg10 
                                      ,si79_instit 
                       )
                values (
                                $this->si79_sequencial 
                               ,$this->si79_tiporegistro 
                               ,'$this->si79_codorgaoresp' 
                               ,'$this->si79_codunidadesubresp' 
                               ,$this->si79_exercicioprocesso 
                               ,'$this->si79_nroprocesso' 
                               ,$this->si79_tipoprocesso 
                               ,$this->si79_nrolote 
                               ,$this->si79_coditem 
                               ,$this->si79_vlcotprecosunitario 
                               ,$this->si79_quantidade 
                               ,$this->si79_mes 
                               ,$this->si79_reg10 
                               ,$this->si79_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dispensa152016 ($this->si79_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dispensa152016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dispensa152016 ($this->si79_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si79_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si79_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010315,'$this->si79_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010308,2010315,'','".AddSlashes(pg_result($resaco,0,'si79_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2010316,'','".AddSlashes(pg_result($resaco,0,'si79_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2010317,'','".AddSlashes(pg_result($resaco,0,'si79_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2010318,'','".AddSlashes(pg_result($resaco,0,'si79_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2010319,'','".AddSlashes(pg_result($resaco,0,'si79_exercicioprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2010320,'','".AddSlashes(pg_result($resaco,0,'si79_nroprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2010321,'','".AddSlashes(pg_result($resaco,0,'si79_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2010322,'','".AddSlashes(pg_result($resaco,0,'si79_nrolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2010323,'','".AddSlashes(pg_result($resaco,0,'si79_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2010324,'','".AddSlashes(pg_result($resaco,0,'si79_vlcotprecosunitario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2010325,'','".AddSlashes(pg_result($resaco,0,'si79_quantidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2010326,'','".AddSlashes(pg_result($resaco,0,'si79_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2010327,'','".AddSlashes(pg_result($resaco,0,'si79_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010308,2011592,'','".AddSlashes(pg_result($resaco,0,'si79_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si79_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dispensa152016 set ";
     $virgula = "";
     if(trim($this->si79_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_sequencial"])){ 
        if(trim($this->si79_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si79_sequencial"])){ 
           $this->si79_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si79_sequencial = $this->si79_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si79_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_tiporegistro"])){ 
       $sql  .= $virgula." si79_tiporegistro = $this->si79_tiporegistro ";
       $virgula = ",";
       if(trim($this->si79_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si79_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si79_codorgaoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_codorgaoresp"])){ 
       $sql  .= $virgula." si79_codorgaoresp = '$this->si79_codorgaoresp' ";
       $virgula = ",";
     }
     if(trim($this->si79_codunidadesubresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_codunidadesubresp"])){ 
       $sql  .= $virgula." si79_codunidadesubresp = '$this->si79_codunidadesubresp' ";
       $virgula = ",";
     }
     if(trim($this->si79_exercicioprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_exercicioprocesso"])){ 
        if(trim($this->si79_exercicioprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si79_exercicioprocesso"])){ 
           $this->si79_exercicioprocesso = "0" ; 
        } 
       $sql  .= $virgula." si79_exercicioprocesso = $this->si79_exercicioprocesso ";
       $virgula = ",";
     }
     if(trim($this->si79_nroprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_nroprocesso"])){ 
       $sql  .= $virgula." si79_nroprocesso = '$this->si79_nroprocesso' ";
       $virgula = ",";
     }
     if(trim($this->si79_tipoprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_tipoprocesso"])){ 
        if(trim($this->si79_tipoprocesso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si79_tipoprocesso"])){ 
           $this->si79_tipoprocesso = "0" ; 
        } 
       $sql  .= $virgula." si79_tipoprocesso = $this->si79_tipoprocesso ";
       $virgula = ",";
     }
     if(trim($this->si79_nrolote)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_nrolote"])){ 
        if(trim($this->si79_nrolote)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si79_nrolote"])){ 
           $this->si79_nrolote = "0" ; 
        } 
       $sql  .= $virgula." si79_nrolote = $this->si79_nrolote ";
       $virgula = ",";
     }
     if(trim($this->si79_coditem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_coditem"])){ 
        if(trim($this->si79_coditem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si79_coditem"])){ 
           $this->si79_coditem = "0" ; 
        } 
       $sql  .= $virgula." si79_coditem = $this->si79_coditem ";
       $virgula = ",";
     }
     if(trim($this->si79_vlcotprecosunitario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_vlcotprecosunitario"])){ 
        if(trim($this->si79_vlcotprecosunitario)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si79_vlcotprecosunitario"])){ 
           $this->si79_vlcotprecosunitario = "0" ; 
        } 
       $sql  .= $virgula." si79_vlcotprecosunitario = $this->si79_vlcotprecosunitario ";
       $virgula = ",";
     }
     if(trim($this->si79_quantidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_quantidade"])){ 
        if(trim($this->si79_quantidade)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si79_quantidade"])){ 
           $this->si79_quantidade = "0" ; 
        } 
       $sql  .= $virgula." si79_quantidade = $this->si79_quantidade ";
       $virgula = ",";
     }
     if(trim($this->si79_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_mes"])){ 
       $sql  .= $virgula." si79_mes = $this->si79_mes ";
       $virgula = ",";
       if(trim($this->si79_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si79_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si79_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_reg10"])){ 
        if(trim($this->si79_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si79_reg10"])){ 
           $this->si79_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si79_reg10 = $this->si79_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si79_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si79_instit"])){ 
       $sql  .= $virgula." si79_instit = $this->si79_instit ";
       $virgula = ",";
       if(trim($this->si79_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si79_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si79_sequencial!=null){
       $sql .= " si79_sequencial = $this->si79_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si79_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010315,'$this->si79_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_sequencial"]) || $this->si79_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010315,'".AddSlashes(pg_result($resaco,$conresaco,'si79_sequencial'))."','$this->si79_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_tiporegistro"]) || $this->si79_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010316,'".AddSlashes(pg_result($resaco,$conresaco,'si79_tiporegistro'))."','$this->si79_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_codorgaoresp"]) || $this->si79_codorgaoresp != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010317,'".AddSlashes(pg_result($resaco,$conresaco,'si79_codorgaoresp'))."','$this->si79_codorgaoresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_codunidadesubresp"]) || $this->si79_codunidadesubresp != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010318,'".AddSlashes(pg_result($resaco,$conresaco,'si79_codunidadesubresp'))."','$this->si79_codunidadesubresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_exercicioprocesso"]) || $this->si79_exercicioprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010319,'".AddSlashes(pg_result($resaco,$conresaco,'si79_exercicioprocesso'))."','$this->si79_exercicioprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_nroprocesso"]) || $this->si79_nroprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010320,'".AddSlashes(pg_result($resaco,$conresaco,'si79_nroprocesso'))."','$this->si79_nroprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_tipoprocesso"]) || $this->si79_tipoprocesso != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010321,'".AddSlashes(pg_result($resaco,$conresaco,'si79_tipoprocesso'))."','$this->si79_tipoprocesso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_nrolote"]) || $this->si79_nrolote != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010322,'".AddSlashes(pg_result($resaco,$conresaco,'si79_nrolote'))."','$this->si79_nrolote',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_coditem"]) || $this->si79_coditem != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010323,'".AddSlashes(pg_result($resaco,$conresaco,'si79_coditem'))."','$this->si79_coditem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_vlcotprecosunitario"]) || $this->si79_vlcotprecosunitario != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010324,'".AddSlashes(pg_result($resaco,$conresaco,'si79_vlcotprecosunitario'))."','$this->si79_vlcotprecosunitario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_quantidade"]) || $this->si79_quantidade != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010325,'".AddSlashes(pg_result($resaco,$conresaco,'si79_quantidade'))."','$this->si79_quantidade',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_mes"]) || $this->si79_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010326,'".AddSlashes(pg_result($resaco,$conresaco,'si79_mes'))."','$this->si79_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_reg10"]) || $this->si79_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2010327,'".AddSlashes(pg_result($resaco,$conresaco,'si79_reg10'))."','$this->si79_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si79_instit"]) || $this->si79_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010308,2011592,'".AddSlashes(pg_result($resaco,$conresaco,'si79_instit'))."','$this->si79_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dispensa152016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si79_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dispensa152016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si79_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si79_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si79_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si79_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010315,'$si79_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010308,2010315,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2010316,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2010317,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2010318,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2010319,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_exercicioprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2010320,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_nroprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2010321,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_tipoprocesso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2010322,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_nrolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2010323,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2010324,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_vlcotprecosunitario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2010325,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_quantidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2010326,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2010327,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010308,2011592,'','".AddSlashes(pg_result($resaco,$iresaco,'si79_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from dispensa152016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si79_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si79_sequencial = $si79_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dispensa152016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si79_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dispensa152016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si79_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si79_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dispensa152016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si79_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dispensa152016 ";
     $sql .= "      left  join dispensa102016  on  dispensa102016.si74_sequencial = dispensa152016.si79_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si79_sequencial!=null ){
         $sql2 .= " where dispensa152016.si79_sequencial = $si79_sequencial "; 
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
   function sql_query_file ( $si79_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dispensa152016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si79_sequencial!=null ){
         $sql2 .= " where dispensa152016.si79_sequencial = $si79_sequencial "; 
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
