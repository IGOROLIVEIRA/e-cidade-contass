<?
//MODULO: sicom
//CLASSE DA ENTIDADE incpro2014
class cl_incpro2014 { 
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
   var $si159_sequencial = 0; 
   var $si159_codprograma = null; 
   var $si159_nomeprograma = null; 
   var $si159_objetivo = null; 
   var $si159_totrecursos1ano = 0; 
   var $si159_totrecursos2ano = 0; 
   var $si159_totrecursos3ano = 0; 
   var $si159_totrecursos4ano = 0; 
   var $si159_nrolei = null; 
   var $si159_dtlei_dia = null; 
   var $si159_dtlei_mes = null; 
   var $si159_dtlei_ano = null; 
   var $si159_dtlei = null; 
   var $si159_dtpublicacaolei_dia = null; 
   var $si159_dtpublicacaolei_mes = null; 
   var $si159_dtpublicacaolei_ano = null; 
   var $si159_dtpublicacaolei = null; 
   var $si159_mes = 0; 
   var $si159_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si159_sequencial = int8 = sequencial 
                 si159_codprograma = varchar(4) = Código do  programa 
                 si159_nomeprograma = varchar(200) = Nome do  Programa 
                 si159_objetivo = varchar(500) = Objetivo do  Programa 
                 si159_totrecursos1ano = float8 = Totalização dos  recursos do 1º  ano 
                 si159_totrecursos2ano = float8 = Totalização dos  recursos do 2º  ano 
                 si159_totrecursos3ano = float8 = Totalização dos  recursos do 3º  ano 
                 si159_totrecursos4ano = float8 = Totalização dos  recursos do 4º  ano 
                 si159_nrolei = varchar(6) = Número da lei 
                 si159_dtlei = date = Data da lei 
                 si159_dtpublicacaolei = date = Data de  publicação da lei 
                 si159_mes = int8 = Mês 
                 si159_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_incpro2014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("incpro2014"); 
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
       $this->si159_sequencial = ($this->si159_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_sequencial"]:$this->si159_sequencial);
       $this->si159_codprograma = ($this->si159_codprograma == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_codprograma"]:$this->si159_codprograma);
       $this->si159_nomeprograma = ($this->si159_nomeprograma == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_nomeprograma"]:$this->si159_nomeprograma);
       $this->si159_objetivo = ($this->si159_objetivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_objetivo"]:$this->si159_objetivo);
       $this->si159_totrecursos1ano = ($this->si159_totrecursos1ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_totrecursos1ano"]:$this->si159_totrecursos1ano);
       $this->si159_totrecursos2ano = ($this->si159_totrecursos2ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_totrecursos2ano"]:$this->si159_totrecursos2ano);
       $this->si159_totrecursos3ano = ($this->si159_totrecursos3ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_totrecursos3ano"]:$this->si159_totrecursos3ano);
       $this->si159_totrecursos4ano = ($this->si159_totrecursos4ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_totrecursos4ano"]:$this->si159_totrecursos4ano);
       $this->si159_nrolei = ($this->si159_nrolei == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_nrolei"]:$this->si159_nrolei);
       if($this->si159_dtlei == ""){
         $this->si159_dtlei_dia = ($this->si159_dtlei_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_dtlei_dia"]:$this->si159_dtlei_dia);
         $this->si159_dtlei_mes = ($this->si159_dtlei_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_dtlei_mes"]:$this->si159_dtlei_mes);
         $this->si159_dtlei_ano = ($this->si159_dtlei_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_dtlei_ano"]:$this->si159_dtlei_ano);
         if($this->si159_dtlei_dia != ""){
            $this->si159_dtlei = $this->si159_dtlei_ano."-".$this->si159_dtlei_mes."-".$this->si159_dtlei_dia;
         }
       }
       if($this->si159_dtpublicacaolei == ""){
         $this->si159_dtpublicacaolei_dia = ($this->si159_dtpublicacaolei_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_dtpublicacaolei_dia"]:$this->si159_dtpublicacaolei_dia);
         $this->si159_dtpublicacaolei_mes = ($this->si159_dtpublicacaolei_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_dtpublicacaolei_mes"]:$this->si159_dtpublicacaolei_mes);
         $this->si159_dtpublicacaolei_ano = ($this->si159_dtpublicacaolei_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_dtpublicacaolei_ano"]:$this->si159_dtpublicacaolei_ano);
         if($this->si159_dtpublicacaolei_dia != ""){
            $this->si159_dtpublicacaolei = $this->si159_dtpublicacaolei_ano."-".$this->si159_dtpublicacaolei_mes."-".$this->si159_dtpublicacaolei_dia;
         }
       }
       $this->si159_mes = ($this->si159_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_mes"]:$this->si159_mes);
       $this->si159_instit = ($this->si159_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_instit"]:$this->si159_instit);
     }else{
       $this->si159_sequencial = ($this->si159_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si159_sequencial"]:$this->si159_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si159_sequencial){ 
      $this->atualizacampos();
     if($this->si159_totrecursos1ano == null ){ 
       $this->si159_totrecursos1ano = "0";
     }
     if($this->si159_totrecursos2ano == null ){ 
       $this->si159_totrecursos2ano = "0";
     }
     if($this->si159_totrecursos3ano == null ){ 
       $this->si159_totrecursos3ano = "0";
     }
     if($this->si159_totrecursos4ano == null ){ 
       $this->si159_totrecursos4ano = "0";
     }
     if($this->si159_dtlei == null ){ 
       $this->si159_dtlei = "null";
     }
     if($this->si159_dtpublicacaolei == null ){ 
       $this->si159_dtpublicacaolei = "null";
     }
     if($this->si159_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si159_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si159_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si159_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si159_sequencial == "" || $si159_sequencial == null ){
       $result = db_query("select nextval('incpro2014_si159_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: incpro2014_si159_sequencial_seq do campo: si159_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si159_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from incpro2014_si159_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si159_sequencial)){
         $this->erro_sql = " Campo si159_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si159_sequencial = $si159_sequencial; 
       }
     }
     if(($this->si159_sequencial == null) || ($this->si159_sequencial == "") ){ 
       $this->erro_sql = " Campo si159_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into incpro2014(
                                       si159_sequencial 
                                      ,si159_codprograma 
                                      ,si159_nomeprograma 
                                      ,si159_objetivo 
                                      ,si159_totrecursos1ano 
                                      ,si159_totrecursos2ano 
                                      ,si159_totrecursos3ano 
                                      ,si159_totrecursos4ano 
                                      ,si159_nrolei 
                                      ,si159_dtlei 
                                      ,si159_dtpublicacaolei 
                                      ,si159_mes 
                                      ,si159_instit 
                       )
                values (
                                $this->si159_sequencial 
                               ,'$this->si159_codprograma' 
                               ,'$this->si159_nomeprograma' 
                               ,'$this->si159_objetivo' 
                               ,$this->si159_totrecursos1ano 
                               ,$this->si159_totrecursos2ano 
                               ,$this->si159_totrecursos3ano 
                               ,$this->si159_totrecursos4ano 
                               ,'$this->si159_nrolei' 
                               ,".($this->si159_dtlei == "null" || $this->si159_dtlei == ""?"null":"'".$this->si159_dtlei."'")." 
                               ,".($this->si159_dtpublicacaolei == "null" || $this->si159_dtpublicacaolei == ""?"null":"'".$this->si159_dtpublicacaolei."'")." 
                               ,$this->si159_mes 
                               ,$this->si159_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "incpro2014 ($this->si159_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "incpro2014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "incpro2014 ($this->si159_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si159_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si159_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011212,'$this->si159_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010388,2011212,'','".AddSlashes(pg_result($resaco,0,'si159_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010388,2011213,'','".AddSlashes(pg_result($resaco,0,'si159_codprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010388,2011214,'','".AddSlashes(pg_result($resaco,0,'si159_nomeprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010388,2011215,'','".AddSlashes(pg_result($resaco,0,'si159_objetivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010388,2011216,'','".AddSlashes(pg_result($resaco,0,'si159_totrecursos1ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010388,2011217,'','".AddSlashes(pg_result($resaco,0,'si159_totrecursos2ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010388,2011218,'','".AddSlashes(pg_result($resaco,0,'si159_totrecursos3ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010388,2011219,'','".AddSlashes(pg_result($resaco,0,'si159_totrecursos4ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010388,2011220,'','".AddSlashes(pg_result($resaco,0,'si159_nrolei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010388,2011221,'','".AddSlashes(pg_result($resaco,0,'si159_dtlei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010388,2011222,'','".AddSlashes(pg_result($resaco,0,'si159_dtpublicacaolei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010388,2011223,'','".AddSlashes(pg_result($resaco,0,'si159_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010388,2011672,'','".AddSlashes(pg_result($resaco,0,'si159_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si159_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update incpro2014 set ";
     $virgula = "";
     if(trim($this->si159_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_sequencial"])){ 
        if(trim($this->si159_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si159_sequencial"])){ 
           $this->si159_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si159_sequencial = $this->si159_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si159_codprograma)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_codprograma"])){ 
       $sql  .= $virgula." si159_codprograma = '$this->si159_codprograma' ";
       $virgula = ",";
     }
     if(trim($this->si159_nomeprograma)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_nomeprograma"])){ 
       $sql  .= $virgula." si159_nomeprograma = '$this->si159_nomeprograma' ";
       $virgula = ",";
     }
     if(trim($this->si159_objetivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_objetivo"])){ 
       $sql  .= $virgula." si159_objetivo = '$this->si159_objetivo' ";
       $virgula = ",";
     }
     if(trim($this->si159_totrecursos1ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_totrecursos1ano"])){ 
        if(trim($this->si159_totrecursos1ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si159_totrecursos1ano"])){ 
           $this->si159_totrecursos1ano = "0" ; 
        } 
       $sql  .= $virgula." si159_totrecursos1ano = $this->si159_totrecursos1ano ";
       $virgula = ",";
     }
     if(trim($this->si159_totrecursos2ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_totrecursos2ano"])){ 
        if(trim($this->si159_totrecursos2ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si159_totrecursos2ano"])){ 
           $this->si159_totrecursos2ano = "0" ; 
        } 
       $sql  .= $virgula." si159_totrecursos2ano = $this->si159_totrecursos2ano ";
       $virgula = ",";
     }
     if(trim($this->si159_totrecursos3ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_totrecursos3ano"])){ 
        if(trim($this->si159_totrecursos3ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si159_totrecursos3ano"])){ 
           $this->si159_totrecursos3ano = "0" ; 
        } 
       $sql  .= $virgula." si159_totrecursos3ano = $this->si159_totrecursos3ano ";
       $virgula = ",";
     }
     if(trim($this->si159_totrecursos4ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_totrecursos4ano"])){ 
        if(trim($this->si159_totrecursos4ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si159_totrecursos4ano"])){ 
           $this->si159_totrecursos4ano = "0" ; 
        } 
       $sql  .= $virgula." si159_totrecursos4ano = $this->si159_totrecursos4ano ";
       $virgula = ",";
     }
     if(trim($this->si159_nrolei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_nrolei"])){ 
       $sql  .= $virgula." si159_nrolei = '$this->si159_nrolei' ";
       $virgula = ",";
     }
     if(trim($this->si159_dtlei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_dtlei_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si159_dtlei_dia"] !="") ){ 
       $sql  .= $virgula." si159_dtlei = '$this->si159_dtlei' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si159_dtlei_dia"])){ 
         $sql  .= $virgula." si159_dtlei = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si159_dtpublicacaolei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_dtpublicacaolei_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si159_dtpublicacaolei_dia"] !="") ){ 
       $sql  .= $virgula." si159_dtpublicacaolei = '$this->si159_dtpublicacaolei' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si159_dtpublicacaolei_dia"])){ 
         $sql  .= $virgula." si159_dtpublicacaolei = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si159_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_mes"])){ 
       $sql  .= $virgula." si159_mes = $this->si159_mes ";
       $virgula = ",";
       if(trim($this->si159_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si159_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si159_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si159_instit"])){ 
       $sql  .= $virgula." si159_instit = $this->si159_instit ";
       $virgula = ",";
       if(trim($this->si159_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si159_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si159_sequencial!=null){
       $sql .= " si159_sequencial = $this->si159_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si159_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011212,'$this->si159_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_sequencial"]) || $this->si159_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011212,'".AddSlashes(pg_result($resaco,$conresaco,'si159_sequencial'))."','$this->si159_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_codprograma"]) || $this->si159_codprograma != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011213,'".AddSlashes(pg_result($resaco,$conresaco,'si159_codprograma'))."','$this->si159_codprograma',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_nomeprograma"]) || $this->si159_nomeprograma != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011214,'".AddSlashes(pg_result($resaco,$conresaco,'si159_nomeprograma'))."','$this->si159_nomeprograma',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_objetivo"]) || $this->si159_objetivo != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011215,'".AddSlashes(pg_result($resaco,$conresaco,'si159_objetivo'))."','$this->si159_objetivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_totrecursos1ano"]) || $this->si159_totrecursos1ano != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011216,'".AddSlashes(pg_result($resaco,$conresaco,'si159_totrecursos1ano'))."','$this->si159_totrecursos1ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_totrecursos2ano"]) || $this->si159_totrecursos2ano != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011217,'".AddSlashes(pg_result($resaco,$conresaco,'si159_totrecursos2ano'))."','$this->si159_totrecursos2ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_totrecursos3ano"]) || $this->si159_totrecursos3ano != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011218,'".AddSlashes(pg_result($resaco,$conresaco,'si159_totrecursos3ano'))."','$this->si159_totrecursos3ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_totrecursos4ano"]) || $this->si159_totrecursos4ano != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011219,'".AddSlashes(pg_result($resaco,$conresaco,'si159_totrecursos4ano'))."','$this->si159_totrecursos4ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_nrolei"]) || $this->si159_nrolei != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011220,'".AddSlashes(pg_result($resaco,$conresaco,'si159_nrolei'))."','$this->si159_nrolei',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_dtlei"]) || $this->si159_dtlei != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011221,'".AddSlashes(pg_result($resaco,$conresaco,'si159_dtlei'))."','$this->si159_dtlei',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_dtpublicacaolei"]) || $this->si159_dtpublicacaolei != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011222,'".AddSlashes(pg_result($resaco,$conresaco,'si159_dtpublicacaolei'))."','$this->si159_dtpublicacaolei',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_mes"]) || $this->si159_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011223,'".AddSlashes(pg_result($resaco,$conresaco,'si159_mes'))."','$this->si159_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si159_instit"]) || $this->si159_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010388,2011672,'".AddSlashes(pg_result($resaco,$conresaco,'si159_instit'))."','$this->si159_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "incpro2014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si159_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "incpro2014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si159_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si159_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si159_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si159_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011212,'$si159_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010388,2011212,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010388,2011213,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_codprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010388,2011214,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_nomeprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010388,2011215,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_objetivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010388,2011216,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_totrecursos1ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010388,2011217,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_totrecursos2ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010388,2011218,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_totrecursos3ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010388,2011219,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_totrecursos4ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010388,2011220,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_nrolei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010388,2011221,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_dtlei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010388,2011222,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_dtpublicacaolei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010388,2011223,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010388,2011672,'','".AddSlashes(pg_result($resaco,$iresaco,'si159_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from incpro2014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si159_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si159_sequencial = $si159_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "incpro2014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si159_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "incpro2014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si159_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si159_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:incpro2014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si159_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from incpro2014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si159_sequencial!=null ){
         $sql2 .= " where incpro2014.si159_sequencial = $si159_sequencial "; 
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
   function sql_query_file ( $si159_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from incpro2014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si159_sequencial!=null ){
         $sql2 .= " where incpro2014.si159_sequencial = $si159_sequencial "; 
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
