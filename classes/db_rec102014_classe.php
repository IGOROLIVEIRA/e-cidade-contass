<?
//MODULO: sicom
//CLASSE DA ENTIDADE rec102014
class cl_rec102014 { 
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
   var $si25_sequencial = 0; 
   var $si25_tiporegistro = 0; 
   var $si25_codreceita = 0; 
   var $si25_codorgao = null; 
   var $si25_ededucaodereceita = 0; 
   var $si25_identificadordeducao = 0; 
   var $si25_naturezareceita = 0; 
   var $si25_especificacao = null; 
   var $si25_vlarrecadado = 0; 
   var $si25_mes = 0; 
   var $si25_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si25_sequencial = int8 = sequencial 
                 si25_tiporegistro = int8 = Tipo do  registro 
                 si25_codreceita = int8 = Código  Identificador 
                 si25_codorgao = varchar(2) = Código do órgão 
                 si25_ededucaodereceita = int8 = Identifica 
                 si25_identificadordeducao = int8 = Identificador da  dedução 
                 si25_naturezareceita = int8 = Natureza da receita 
                 si25_especificacao = varchar(100) = Especificação da  receita 
                 si25_vlarrecadado = float8 = Valor arrecadado 
                 si25_mes = int8 = Mês 
                 si25_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_rec102014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("rec102014"); 
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
       $this->si25_sequencial = ($this->si25_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si25_sequencial"]:$this->si25_sequencial);
       $this->si25_tiporegistro = ($this->si25_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si25_tiporegistro"]:$this->si25_tiporegistro);
       $this->si25_codreceita = ($this->si25_codreceita == ""?@$GLOBALS["HTTP_POST_VARS"]["si25_codreceita"]:$this->si25_codreceita);
       $this->si25_codorgao = ($this->si25_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si25_codorgao"]:$this->si25_codorgao);
       $this->si25_ededucaodereceita = ($this->si25_ededucaodereceita == ""?@$GLOBALS["HTTP_POST_VARS"]["si25_ededucaodereceita"]:$this->si25_ededucaodereceita);
       $this->si25_identificadordeducao = ($this->si25_identificadordeducao == ""?@$GLOBALS["HTTP_POST_VARS"]["si25_identificadordeducao"]:$this->si25_identificadordeducao);
       $this->si25_naturezareceita = ($this->si25_naturezareceita == ""?@$GLOBALS["HTTP_POST_VARS"]["si25_naturezareceita"]:$this->si25_naturezareceita);
       $this->si25_especificacao = ($this->si25_especificacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si25_especificacao"]:$this->si25_especificacao);
       $this->si25_vlarrecadado = ($this->si25_vlarrecadado == ""?@$GLOBALS["HTTP_POST_VARS"]["si25_vlarrecadado"]:$this->si25_vlarrecadado);
       $this->si25_mes = ($this->si25_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si25_mes"]:$this->si25_mes);
       $this->si25_instit = ($this->si25_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si25_instit"]:$this->si25_instit);
     }else{
       $this->si25_sequencial = ($this->si25_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si25_sequencial"]:$this->si25_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si25_sequencial){ 
      $this->atualizacampos();
     if($this->si25_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si25_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si25_codreceita == null ){ 
       $this->si25_codreceita = "0";
     }
     if($this->si25_ededucaodereceita == null ){ 
       $this->si25_ededucaodereceita = "0";
     }
     if($this->si25_identificadordeducao == null ){ 
       $this->si25_identificadordeducao = "0";
     }
     if($this->si25_naturezareceita == null ){ 
       $this->si25_naturezareceita = "0";
     }
     if($this->si25_vlarrecadado == null ){ 
       $this->si25_vlarrecadado = "0";
     }
     if($this->si25_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si25_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si25_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si25_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si25_sequencial == "" || $si25_sequencial == null ){
       $result = db_query("select nextval('rec102014_si25_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rec102014_si25_sequencial_seq do campo: si25_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si25_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from rec102014_si25_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si25_sequencial)){
         $this->erro_sql = " Campo si25_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si25_sequencial = $si25_sequencial; 
       }
     }
     if(($this->si25_sequencial == null) || ($this->si25_sequencial == "") ){ 
       $this->erro_sql = " Campo si25_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rec102014(
                                       si25_sequencial 
                                      ,si25_tiporegistro 
                                      ,si25_codreceita 
                                      ,si25_codorgao 
                                      ,si25_ededucaodereceita 
                                      ,si25_identificadordeducao 
                                      ,si25_naturezareceita 
                                      ,si25_especificacao 
                                      ,si25_vlarrecadado 
                                      ,si25_mes 
                                      ,si25_instit 
                       )
                values (
                                $this->si25_sequencial 
                               ,$this->si25_tiporegistro 
                               ,$this->si25_codreceita 
                               ,'$this->si25_codorgao' 
                               ,$this->si25_ededucaodereceita 
                               ,$this->si25_identificadordeducao 
                               ,$this->si25_naturezareceita 
                               ,'$this->si25_especificacao' 
                               ,$this->si25_vlarrecadado 
                               ,$this->si25_mes 
                               ,$this->si25_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "rec102014 ($this->si25_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "rec102014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "rec102014 ($this->si25_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si25_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si25_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009673,'$this->si25_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010253,2009673,'','".AddSlashes(pg_result($resaco,0,'si25_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010253,2009674,'','".AddSlashes(pg_result($resaco,0,'si25_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010253,2009675,'','".AddSlashes(pg_result($resaco,0,'si25_codreceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010253,2009676,'','".AddSlashes(pg_result($resaco,0,'si25_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010253,2009677,'','".AddSlashes(pg_result($resaco,0,'si25_ededucaodereceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010253,2009678,'','".AddSlashes(pg_result($resaco,0,'si25_identificadordeducao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010253,2009679,'','".AddSlashes(pg_result($resaco,0,'si25_naturezareceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010253,2009680,'','".AddSlashes(pg_result($resaco,0,'si25_especificacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010253,2009681,'','".AddSlashes(pg_result($resaco,0,'si25_vlarrecadado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010253,2009743,'','".AddSlashes(pg_result($resaco,0,'si25_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010253,2011541,'','".AddSlashes(pg_result($resaco,0,'si25_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si25_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update rec102014 set ";
     $virgula = "";
     if(trim($this->si25_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si25_sequencial"])){ 
        if(trim($this->si25_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si25_sequencial"])){ 
           $this->si25_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si25_sequencial = $this->si25_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si25_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si25_tiporegistro"])){ 
       $sql  .= $virgula." si25_tiporegistro = $this->si25_tiporegistro ";
       $virgula = ",";
       if(trim($this->si25_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si25_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si25_codreceita)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si25_codreceita"])){ 
        if(trim($this->si25_codreceita)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si25_codreceita"])){ 
           $this->si25_codreceita = "0" ; 
        } 
       $sql  .= $virgula." si25_codreceita = $this->si25_codreceita ";
       $virgula = ",";
     }
     if(trim($this->si25_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si25_codorgao"])){ 
       $sql  .= $virgula." si25_codorgao = '$this->si25_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si25_ededucaodereceita)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si25_ededucaodereceita"])){ 
        if(trim($this->si25_ededucaodereceita)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si25_ededucaodereceita"])){ 
           $this->si25_ededucaodereceita = "0" ; 
        } 
       $sql  .= $virgula." si25_ededucaodereceita = $this->si25_ededucaodereceita ";
       $virgula = ",";
     }
     if(trim($this->si25_identificadordeducao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si25_identificadordeducao"])){ 
        if(trim($this->si25_identificadordeducao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si25_identificadordeducao"])){ 
           $this->si25_identificadordeducao = "0" ; 
        } 
       $sql  .= $virgula." si25_identificadordeducao = $this->si25_identificadordeducao ";
       $virgula = ",";
     }
     if(trim($this->si25_naturezareceita)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si25_naturezareceita"])){ 
        if(trim($this->si25_naturezareceita)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si25_naturezareceita"])){ 
           $this->si25_naturezareceita = "0" ; 
        } 
       $sql  .= $virgula." si25_naturezareceita = $this->si25_naturezareceita ";
       $virgula = ",";
     }
     if(trim($this->si25_especificacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si25_especificacao"])){ 
       $sql  .= $virgula." si25_especificacao = '$this->si25_especificacao' ";
       $virgula = ",";
     }
     if(trim($this->si25_vlarrecadado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si25_vlarrecadado"])){ 
        if(trim($this->si25_vlarrecadado)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si25_vlarrecadado"])){ 
           $this->si25_vlarrecadado = "0" ; 
        } 
       $sql  .= $virgula." si25_vlarrecadado = $this->si25_vlarrecadado ";
       $virgula = ",";
     }
     if(trim($this->si25_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si25_mes"])){ 
       $sql  .= $virgula." si25_mes = $this->si25_mes ";
       $virgula = ",";
       if(trim($this->si25_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si25_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si25_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si25_instit"])){ 
       $sql  .= $virgula." si25_instit = $this->si25_instit ";
       $virgula = ",";
       if(trim($this->si25_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si25_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si25_sequencial!=null){
       $sql .= " si25_sequencial = $this->si25_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si25_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009673,'$this->si25_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si25_sequencial"]) || $this->si25_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010253,2009673,'".AddSlashes(pg_result($resaco,$conresaco,'si25_sequencial'))."','$this->si25_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si25_tiporegistro"]) || $this->si25_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010253,2009674,'".AddSlashes(pg_result($resaco,$conresaco,'si25_tiporegistro'))."','$this->si25_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si25_codreceita"]) || $this->si25_codreceita != "")
           $resac = db_query("insert into db_acount values($acount,2010253,2009675,'".AddSlashes(pg_result($resaco,$conresaco,'si25_codreceita'))."','$this->si25_codreceita',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si25_codorgao"]) || $this->si25_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010253,2009676,'".AddSlashes(pg_result($resaco,$conresaco,'si25_codorgao'))."','$this->si25_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si25_ededucaodereceita"]) || $this->si25_ededucaodereceita != "")
           $resac = db_query("insert into db_acount values($acount,2010253,2009677,'".AddSlashes(pg_result($resaco,$conresaco,'si25_ededucaodereceita'))."','$this->si25_ededucaodereceita',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si25_identificadordeducao"]) || $this->si25_identificadordeducao != "")
           $resac = db_query("insert into db_acount values($acount,2010253,2009678,'".AddSlashes(pg_result($resaco,$conresaco,'si25_identificadordeducao'))."','$this->si25_identificadordeducao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si25_naturezareceita"]) || $this->si25_naturezareceita != "")
           $resac = db_query("insert into db_acount values($acount,2010253,2009679,'".AddSlashes(pg_result($resaco,$conresaco,'si25_naturezareceita'))."','$this->si25_naturezareceita',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si25_especificacao"]) || $this->si25_especificacao != "")
           $resac = db_query("insert into db_acount values($acount,2010253,2009680,'".AddSlashes(pg_result($resaco,$conresaco,'si25_especificacao'))."','$this->si25_especificacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si25_vlarrecadado"]) || $this->si25_vlarrecadado != "")
           $resac = db_query("insert into db_acount values($acount,2010253,2009681,'".AddSlashes(pg_result($resaco,$conresaco,'si25_vlarrecadado'))."','$this->si25_vlarrecadado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si25_mes"]) || $this->si25_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010253,2009743,'".AddSlashes(pg_result($resaco,$conresaco,'si25_mes'))."','$this->si25_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si25_instit"]) || $this->si25_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010253,2011541,'".AddSlashes(pg_result($resaco,$conresaco,'si25_instit'))."','$this->si25_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rec102014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si25_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "rec102014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si25_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si25_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si25_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si25_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009673,'$si25_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010253,2009673,'','".AddSlashes(pg_result($resaco,$iresaco,'si25_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010253,2009674,'','".AddSlashes(pg_result($resaco,$iresaco,'si25_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010253,2009675,'','".AddSlashes(pg_result($resaco,$iresaco,'si25_codreceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010253,2009676,'','".AddSlashes(pg_result($resaco,$iresaco,'si25_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010253,2009677,'','".AddSlashes(pg_result($resaco,$iresaco,'si25_ededucaodereceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010253,2009678,'','".AddSlashes(pg_result($resaco,$iresaco,'si25_identificadordeducao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010253,2009679,'','".AddSlashes(pg_result($resaco,$iresaco,'si25_naturezareceita'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010253,2009680,'','".AddSlashes(pg_result($resaco,$iresaco,'si25_especificacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010253,2009681,'','".AddSlashes(pg_result($resaco,$iresaco,'si25_vlarrecadado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010253,2009743,'','".AddSlashes(pg_result($resaco,$iresaco,'si25_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010253,2011541,'','".AddSlashes(pg_result($resaco,$iresaco,'si25_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from rec102014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si25_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si25_sequencial = $si25_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rec102014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si25_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "rec102014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si25_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si25_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:rec102014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si25_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rec102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si25_sequencial!=null ){
         $sql2 .= " where rec102014.si25_sequencial = $si25_sequencial "; 
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
   function sql_query_file ( $si25_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rec102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si25_sequencial!=null ){
         $sql2 .= " where rec102014.si25_sequencial = $si25_sequencial "; 
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
