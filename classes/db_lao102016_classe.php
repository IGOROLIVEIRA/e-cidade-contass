<?
//MODULO: sicom
//CLASSE DA ENTIDADE lao102016
class cl_lao102016 { 
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
   var $si34_sequencial = 0; 
   var $si34_tiporegistro = 0; 
   var $si34_codorgao = null; 
   var $si34_nroleialteracao = null; 
   var $si34_dataleialteracao_dia = null; 
   var $si34_dataleialteracao_mes = null; 
   var $si34_dataleialteracao_ano = null; 
   var $si34_dataleialteracao = null; 
   var $si34_mes = 0; 
   var $si34_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si34_sequencial = int8 = sequencial 
                 si34_tiporegistro = int8 = Tipo do  registro 
                 si34_codorgao = varchar(2) = Código do órgão 
                 si34_nroleialteracao = varchar(6) = Número da Lei 
                 si34_dataleialteracao = date = Data da Lei 
                 si34_mes = int8 = Mês 
                 si34_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_lao102016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("lao102016"); 
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
       $this->si34_sequencial = ($this->si34_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si34_sequencial"]:$this->si34_sequencial);
       $this->si34_tiporegistro = ($this->si34_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si34_tiporegistro"]:$this->si34_tiporegistro);
       $this->si34_codorgao = ($this->si34_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si34_codorgao"]:$this->si34_codorgao);
       $this->si34_nroleialteracao = ($this->si34_nroleialteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["si34_nroleialteracao"]:$this->si34_nroleialteracao);
       if($this->si34_dataleialteracao == ""){
         $this->si34_dataleialteracao_dia = ($this->si34_dataleialteracao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si34_dataleialteracao_dia"]:$this->si34_dataleialteracao_dia);
         $this->si34_dataleialteracao_mes = ($this->si34_dataleialteracao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si34_dataleialteracao_mes"]:$this->si34_dataleialteracao_mes);
         $this->si34_dataleialteracao_ano = ($this->si34_dataleialteracao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si34_dataleialteracao_ano"]:$this->si34_dataleialteracao_ano);
         if($this->si34_dataleialteracao_dia != ""){
            $this->si34_dataleialteracao = $this->si34_dataleialteracao_ano."-".$this->si34_dataleialteracao_mes."-".$this->si34_dataleialteracao_dia;
         }
       }
       $this->si34_mes = ($this->si34_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si34_mes"]:$this->si34_mes);
       $this->si34_instit = ($this->si34_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si34_instit"]:$this->si34_instit);
     }else{
       $this->si34_sequencial = ($this->si34_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si34_sequencial"]:$this->si34_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si34_sequencial){ 
      $this->atualizacampos();
     if($this->si34_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si34_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si34_dataleialteracao == null ){ 
       $this->si34_dataleialteracao = "null";
     }
     if($this->si34_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si34_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si34_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si34_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si34_sequencial == "" || $si34_sequencial == null ){
       $result = db_query("select nextval('lao102016_si34_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: lao102016_si34_sequencial_seq do campo: si34_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si34_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from lao102016_si34_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si34_sequencial)){
         $this->erro_sql = " Campo si34_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si34_sequencial = $si34_sequencial; 
       }
     }
     if(($this->si34_sequencial == null) || ($this->si34_sequencial == "") ){ 
       $this->erro_sql = " Campo si34_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into lao102016(
                                       si34_sequencial 
                                      ,si34_tiporegistro 
                                      ,si34_codorgao 
                                      ,si34_nroleialteracao 
                                      ,si34_dataleialteracao 
                                      ,si34_mes 
                                      ,si34_instit 
                       )
                values (
                                $this->si34_sequencial 
                               ,$this->si34_tiporegistro 
                               ,'$this->si34_codorgao' 
                               ,'$this->si34_nroleialteracao' 
                               ,".($this->si34_dataleialteracao == "null" || $this->si34_dataleialteracao == ""?"null":"'".$this->si34_dataleialteracao."'")." 
                               ,$this->si34_mes 
                               ,$this->si34_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "lao102016 ($this->si34_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "lao102016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "lao102016 ($this->si34_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si34_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si34_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009749,'$this->si34_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010262,2009749,'','".AddSlashes(pg_result($resaco,0,'si34_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010262,2009750,'','".AddSlashes(pg_result($resaco,0,'si34_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010262,2009751,'','".AddSlashes(pg_result($resaco,0,'si34_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010262,2009752,'','".AddSlashes(pg_result($resaco,0,'si34_nroleialteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010262,2009753,'','".AddSlashes(pg_result($resaco,0,'si34_dataleialteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010262,2009754,'','".AddSlashes(pg_result($resaco,0,'si34_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010262,2011548,'','".AddSlashes(pg_result($resaco,0,'si34_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si34_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update lao102016 set ";
     $virgula = "";
     if(trim($this->si34_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si34_sequencial"])){ 
        if(trim($this->si34_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si34_sequencial"])){ 
           $this->si34_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si34_sequencial = $this->si34_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si34_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si34_tiporegistro"])){ 
       $sql  .= $virgula." si34_tiporegistro = $this->si34_tiporegistro ";
       $virgula = ",";
       if(trim($this->si34_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si34_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si34_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si34_codorgao"])){ 
       $sql  .= $virgula." si34_codorgao = '$this->si34_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si34_nroleialteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si34_nroleialteracao"])){ 
       $sql  .= $virgula." si34_nroleialteracao = '$this->si34_nroleialteracao' ";
       $virgula = ",";
     }
     if(trim($this->si34_dataleialteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si34_dataleialteracao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si34_dataleialteracao_dia"] !="") ){ 
       $sql  .= $virgula." si34_dataleialteracao = '$this->si34_dataleialteracao' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si34_dataleialteracao_dia"])){ 
         $sql  .= $virgula." si34_dataleialteracao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si34_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si34_mes"])){ 
       $sql  .= $virgula." si34_mes = $this->si34_mes ";
       $virgula = ",";
       if(trim($this->si34_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si34_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si34_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si34_instit"])){ 
       $sql  .= $virgula." si34_instit = $this->si34_instit ";
       $virgula = ",";
       if(trim($this->si34_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si34_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si34_sequencial!=null){
       $sql .= " si34_sequencial = $this->si34_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si34_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009749,'$this->si34_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si34_sequencial"]) || $this->si34_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010262,2009749,'".AddSlashes(pg_result($resaco,$conresaco,'si34_sequencial'))."','$this->si34_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si34_tiporegistro"]) || $this->si34_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010262,2009750,'".AddSlashes(pg_result($resaco,$conresaco,'si34_tiporegistro'))."','$this->si34_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si34_codorgao"]) || $this->si34_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010262,2009751,'".AddSlashes(pg_result($resaco,$conresaco,'si34_codorgao'))."','$this->si34_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si34_nroleialteracao"]) || $this->si34_nroleialteracao != "")
           $resac = db_query("insert into db_acount values($acount,2010262,2009752,'".AddSlashes(pg_result($resaco,$conresaco,'si34_nroleialteracao'))."','$this->si34_nroleialteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si34_dataleialteracao"]) || $this->si34_dataleialteracao != "")
           $resac = db_query("insert into db_acount values($acount,2010262,2009753,'".AddSlashes(pg_result($resaco,$conresaco,'si34_dataleialteracao'))."','$this->si34_dataleialteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si34_mes"]) || $this->si34_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010262,2009754,'".AddSlashes(pg_result($resaco,$conresaco,'si34_mes'))."','$this->si34_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si34_instit"]) || $this->si34_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010262,2011548,'".AddSlashes(pg_result($resaco,$conresaco,'si34_instit'))."','$this->si34_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "lao102016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si34_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "lao102016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si34_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si34_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si34_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si34_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009749,'$si34_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010262,2009749,'','".AddSlashes(pg_result($resaco,$iresaco,'si34_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010262,2009750,'','".AddSlashes(pg_result($resaco,$iresaco,'si34_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010262,2009751,'','".AddSlashes(pg_result($resaco,$iresaco,'si34_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010262,2009752,'','".AddSlashes(pg_result($resaco,$iresaco,'si34_nroleialteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010262,2009753,'','".AddSlashes(pg_result($resaco,$iresaco,'si34_dataleialteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010262,2009754,'','".AddSlashes(pg_result($resaco,$iresaco,'si34_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010262,2011548,'','".AddSlashes(pg_result($resaco,$iresaco,'si34_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from lao102016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si34_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si34_sequencial = $si34_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "lao102016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si34_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "lao102016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si34_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si34_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:lao102016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si34_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from lao102016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si34_sequencial!=null ){
         $sql2 .= " where lao102016.si34_sequencial = $si34_sequencial "; 
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
   function sql_query_file ( $si34_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from lao102016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si34_sequencial!=null ){
         $sql2 .= " where lao102016.si34_sequencial = $si34_sequencial "; 
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
