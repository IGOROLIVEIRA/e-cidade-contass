<?
//MODULO: sicom
//CLASSE DA ENTIDADE contratos122018
class cl_contratos122018 { 
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
   var $si85_sequencial = 0; 
   var $si85_tiporegistro = 0; 
   var $si85_codcontrato = 0; 
   var $si85_codorgao = null; 
   var $si85_codunidadesub = null; 
   var $si85_codfuncao = null; 
   var $si85_codsubfuncao = null; 
   var $si85_codprograma = null; 
   var $si85_idacao = null; 
   var $si85_idsubacao = null; 
   var $si85_naturezadespesa = 0; 
   var $si85_codfontrecursos = 0; 
   var $si85_vlrecurso = 0; 
   var $si85_mes = 0; 
   var $si85_reg10 = 0; 
   var $si85_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si85_sequencial = int8 = sequencial 
                 si85_tiporegistro = int8 = Tipo do registro 
                 si85_codcontrato = int8 = Código do contrato 
                 si85_codorgao = varchar(2) = Código do órgão 
                 si85_codunidadesub = varchar(8) = Código da unidade 
                 si85_codfuncao = varchar(2) = Código da função 
                 si85_codsubfuncao = varchar(3) = Código da  Subfunção 
                 si85_codprograma = varchar(4) = Código do  programa 
                 si85_idacao = varchar(4) = Código que identifica a Ação 
                 si85_idsubacao = varchar(4) = Código que  identifica a SubAção 
                 si85_naturezadespesa = int8 = Código da   natureza da   despesa 
                 si85_codfontrecursos = int8 = Código da fonte de  recursos 
                 si85_vlrecurso = float8 = Valor do recurso  orçamentário 
                 si85_mes = int8 = Mês 
                 si85_reg10 = int8 = reg10 
                 si85_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_contratos122018() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("contratos122018"); 
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
       $this->si85_sequencial = ($this->si85_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_sequencial"]:$this->si85_sequencial);
       $this->si85_tiporegistro = ($this->si85_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_tiporegistro"]:$this->si85_tiporegistro);
       $this->si85_codcontrato = ($this->si85_codcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_codcontrato"]:$this->si85_codcontrato);
       $this->si85_codorgao = ($this->si85_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_codorgao"]:$this->si85_codorgao);
       $this->si85_codunidadesub = ($this->si85_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_codunidadesub"]:$this->si85_codunidadesub);
       $this->si85_codfuncao = ($this->si85_codfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_codfuncao"]:$this->si85_codfuncao);
       $this->si85_codsubfuncao = ($this->si85_codsubfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_codsubfuncao"]:$this->si85_codsubfuncao);
       $this->si85_codprograma = ($this->si85_codprograma == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_codprograma"]:$this->si85_codprograma);
       $this->si85_idacao = ($this->si85_idacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_idacao"]:$this->si85_idacao);
       $this->si85_idsubacao = ($this->si85_idsubacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_idsubacao"]:$this->si85_idsubacao);
       $this->si85_naturezadespesa = ($this->si85_naturezadespesa == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_naturezadespesa"]:$this->si85_naturezadespesa);
       $this->si85_codfontrecursos = ($this->si85_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_codfontrecursos"]:$this->si85_codfontrecursos);
       $this->si85_vlrecurso = ($this->si85_vlrecurso == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_vlrecurso"]:$this->si85_vlrecurso);
       $this->si85_mes = ($this->si85_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_mes"]:$this->si85_mes);
       $this->si85_reg10 = ($this->si85_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_reg10"]:$this->si85_reg10);
       $this->si85_instit = ($this->si85_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_instit"]:$this->si85_instit);
     }else{
       $this->si85_sequencial = ($this->si85_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si85_sequencial"]:$this->si85_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si85_sequencial){ 
      $this->atualizacampos();
     if($this->si85_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do registro nao Informado.";
       $this->erro_campo = "si85_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si85_codcontrato == null ){ 
       $this->si85_codcontrato = "0";
     }
     if($this->si85_naturezadespesa == null ){ 
       $this->si85_naturezadespesa = "0";
     }
     if($this->si85_codfontrecursos == null ){ 
       $this->si85_codfontrecursos = "0";
     }
     if($this->si85_vlrecurso == null ){ 
       $this->si85_vlrecurso = "0";
     }
     if($this->si85_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si85_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si85_reg10 == null ){ 
       $this->si85_reg10 = "0";
     }
     if($this->si85_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si85_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($si85_sequencial == "" || $si85_sequencial == null ){
       $result = db_query("select nextval('contratos122018_si85_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: contratos122018_si85_sequencial_seq do campo: si85_sequencial"; 
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si85_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from contratos122018_si85_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si85_sequencial)){
         $this->erro_sql = " Campo si85_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si85_sequencial = $si85_sequencial; 
       }
     }
     if(($this->si85_sequencial == null) || ($this->si85_sequencial == "") ){ 
       $this->erro_sql = " Campo si85_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into contratos122018(
                                       si85_sequencial 
                                      ,si85_tiporegistro 
                                      ,si85_codcontrato 
                                      ,si85_codorgao 
                                      ,si85_codunidadesub 
                                      ,si85_codfuncao 
                                      ,si85_codsubfuncao 
                                      ,si85_codprograma 
                                      ,si85_idacao 
                                      ,si85_idsubacao 
                                      ,si85_naturezadespesa 
                                      ,si85_codfontrecursos 
                                      ,si85_vlrecurso 
                                      ,si85_mes 
                                      ,si85_reg10 
                                      ,si85_instit 
                       )
                values (
                                $this->si85_sequencial 
                               ,$this->si85_tiporegistro 
                               ,$this->si85_codcontrato 
                               ,'$this->si85_codorgao' 
                               ,'$this->si85_codunidadesub' 
                               ,'$this->si85_codfuncao' 
                               ,'$this->si85_codsubfuncao' 
                               ,'$this->si85_codprograma' 
                               ,'$this->si85_idacao' 
                               ,'$this->si85_idsubacao' 
                               ,$this->si85_naturezadespesa 
                               ,$this->si85_codfontrecursos 
                               ,$this->si85_vlrecurso 
                               ,$this->si85_mes 
                               ,$this->si85_reg10 
                               ,$this->si85_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "contratos122018 ($this->si85_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "contratos122018 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "contratos122018 ($this->si85_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si85_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si85_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010435,'$this->si85_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010314,2010435,'','".AddSlashes(pg_result($resaco,0,'si85_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010436,'','".AddSlashes(pg_result($resaco,0,'si85_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010437,'','".AddSlashes(pg_result($resaco,0,'si85_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010438,'','".AddSlashes(pg_result($resaco,0,'si85_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010439,'','".AddSlashes(pg_result($resaco,0,'si85_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010440,'','".AddSlashes(pg_result($resaco,0,'si85_codfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010441,'','".AddSlashes(pg_result($resaco,0,'si85_codsubfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010442,'','".AddSlashes(pg_result($resaco,0,'si85_codprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010443,'','".AddSlashes(pg_result($resaco,0,'si85_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010444,'','".AddSlashes(pg_result($resaco,0,'si85_idsubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010445,'','".AddSlashes(pg_result($resaco,0,'si85_naturezadespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010446,'','".AddSlashes(pg_result($resaco,0,'si85_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010447,'','".AddSlashes(pg_result($resaco,0,'si85_vlrecurso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010448,'','".AddSlashes(pg_result($resaco,0,'si85_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2010449,'','".AddSlashes(pg_result($resaco,0,'si85_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010314,2011598,'','".AddSlashes(pg_result($resaco,0,'si85_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si85_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update contratos122018 set ";
     $virgula = "";
     if(trim($this->si85_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_sequencial"])){ 
        if(trim($this->si85_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si85_sequencial"])){ 
           $this->si85_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si85_sequencial = $this->si85_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si85_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_tiporegistro"])){ 
       $sql  .= $virgula." si85_tiporegistro = $this->si85_tiporegistro ";
       $virgula = ",";
       if(trim($this->si85_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do registro nao Informado.";
         $this->erro_campo = "si85_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si85_codcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_codcontrato"])){ 
        if(trim($this->si85_codcontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si85_codcontrato"])){ 
           $this->si85_codcontrato = "0" ; 
        } 
       $sql  .= $virgula." si85_codcontrato = $this->si85_codcontrato ";
       $virgula = ",";
     }
     if(trim($this->si85_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_codorgao"])){ 
       $sql  .= $virgula." si85_codorgao = '$this->si85_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si85_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_codunidadesub"])){ 
       $sql  .= $virgula." si85_codunidadesub = '$this->si85_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si85_codfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_codfuncao"])){ 
       $sql  .= $virgula." si85_codfuncao = '$this->si85_codfuncao' ";
       $virgula = ",";
     }
     if(trim($this->si85_codsubfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_codsubfuncao"])){ 
       $sql  .= $virgula." si85_codsubfuncao = '$this->si85_codsubfuncao' ";
       $virgula = ",";
     }
     if(trim($this->si85_codprograma)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_codprograma"])){ 
       $sql  .= $virgula." si85_codprograma = '$this->si85_codprograma' ";
       $virgula = ",";
     }
     if(trim($this->si85_idacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_idacao"])){ 
       $sql  .= $virgula." si85_idacao = '$this->si85_idacao' ";
       $virgula = ",";
     }
     if(trim($this->si85_idsubacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_idsubacao"])){ 
       $sql  .= $virgula." si85_idsubacao = '$this->si85_idsubacao' ";
       $virgula = ",";
     }
     if(trim($this->si85_naturezadespesa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_naturezadespesa"])){ 
        if(trim($this->si85_naturezadespesa)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si85_naturezadespesa"])){ 
           $this->si85_naturezadespesa = "0" ; 
        } 
       $sql  .= $virgula." si85_naturezadespesa = $this->si85_naturezadespesa ";
       $virgula = ",";
     }
     if(trim($this->si85_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_codfontrecursos"])){ 
        if(trim($this->si85_codfontrecursos)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si85_codfontrecursos"])){ 
           $this->si85_codfontrecursos = "0" ; 
        } 
       $sql  .= $virgula." si85_codfontrecursos = $this->si85_codfontrecursos ";
       $virgula = ",";
     }
     if(trim($this->si85_vlrecurso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_vlrecurso"])){ 
        if(trim($this->si85_vlrecurso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si85_vlrecurso"])){ 
           $this->si85_vlrecurso = "0" ; 
        } 
       $sql  .= $virgula." si85_vlrecurso = $this->si85_vlrecurso ";
       $virgula = ",";
     }
     if(trim($this->si85_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_mes"])){ 
       $sql  .= $virgula." si85_mes = $this->si85_mes ";
       $virgula = ",";
       if(trim($this->si85_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si85_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si85_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_reg10"])){ 
        if(trim($this->si85_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si85_reg10"])){ 
           $this->si85_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si85_reg10 = $this->si85_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si85_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si85_instit"])){ 
       $sql  .= $virgula." si85_instit = $this->si85_instit ";
       $virgula = ",";
       if(trim($this->si85_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si85_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si85_sequencial!=null){
       $sql .= " si85_sequencial = $this->si85_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si85_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010435,'$this->si85_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_sequencial"]) || $this->si85_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010435,'".AddSlashes(pg_result($resaco,$conresaco,'si85_sequencial'))."','$this->si85_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_tiporegistro"]) || $this->si85_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010436,'".AddSlashes(pg_result($resaco,$conresaco,'si85_tiporegistro'))."','$this->si85_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_codcontrato"]) || $this->si85_codcontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010437,'".AddSlashes(pg_result($resaco,$conresaco,'si85_codcontrato'))."','$this->si85_codcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_codorgao"]) || $this->si85_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010438,'".AddSlashes(pg_result($resaco,$conresaco,'si85_codorgao'))."','$this->si85_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_codunidadesub"]) || $this->si85_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010439,'".AddSlashes(pg_result($resaco,$conresaco,'si85_codunidadesub'))."','$this->si85_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_codfuncao"]) || $this->si85_codfuncao != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010440,'".AddSlashes(pg_result($resaco,$conresaco,'si85_codfuncao'))."','$this->si85_codfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_codsubfuncao"]) || $this->si85_codsubfuncao != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010441,'".AddSlashes(pg_result($resaco,$conresaco,'si85_codsubfuncao'))."','$this->si85_codsubfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_codprograma"]) || $this->si85_codprograma != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010442,'".AddSlashes(pg_result($resaco,$conresaco,'si85_codprograma'))."','$this->si85_codprograma',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_idacao"]) || $this->si85_idacao != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010443,'".AddSlashes(pg_result($resaco,$conresaco,'si85_idacao'))."','$this->si85_idacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_idsubacao"]) || $this->si85_idsubacao != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010444,'".AddSlashes(pg_result($resaco,$conresaco,'si85_idsubacao'))."','$this->si85_idsubacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_naturezadespesa"]) || $this->si85_naturezadespesa != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010445,'".AddSlashes(pg_result($resaco,$conresaco,'si85_naturezadespesa'))."','$this->si85_naturezadespesa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_codfontrecursos"]) || $this->si85_codfontrecursos != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010446,'".AddSlashes(pg_result($resaco,$conresaco,'si85_codfontrecursos'))."','$this->si85_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_vlrecurso"]) || $this->si85_vlrecurso != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010447,'".AddSlashes(pg_result($resaco,$conresaco,'si85_vlrecurso'))."','$this->si85_vlrecurso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_mes"]) || $this->si85_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010448,'".AddSlashes(pg_result($resaco,$conresaco,'si85_mes'))."','$this->si85_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_reg10"]) || $this->si85_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2010449,'".AddSlashes(pg_result($resaco,$conresaco,'si85_reg10'))."','$this->si85_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si85_instit"]) || $this->si85_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010314,2011598,'".AddSlashes(pg_result($resaco,$conresaco,'si85_instit'))."','$this->si85_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "contratos122018 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si85_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos122018 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si85_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si85_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si85_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si85_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010435,'$si85_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010314,2010435,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010436,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010437,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010438,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010439,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010440,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_codfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010441,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_codsubfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010442,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_codprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010443,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010444,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_idsubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010445,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_naturezadespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010446,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010447,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_vlrecurso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010448,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2010449,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010314,2011598,'','".AddSlashes(pg_result($resaco,$iresaco,'si85_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from contratos122018
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si85_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si85_sequencial = $si85_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "contratos122018 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si85_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos122018 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si85_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si85_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
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
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:contratos122018";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si85_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos122018 ";
     $sql .= "      left  join contratos102018  on  contratos102018.si83_sequencial = contratos122018.si85_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si85_sequencial!=null ){
         $sql2 .= " where contratos122018.si85_sequencial = $si85_sequencial "; 
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
   function sql_query_file ( $si85_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from contratos122018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si85_sequencial!=null ){
         $sql2 .= " where contratos122018.si85_sequencial = $si85_sequencial "; 
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
