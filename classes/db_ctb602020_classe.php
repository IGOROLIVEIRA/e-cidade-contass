<?
//MODULO: sicom
//CLASSE DA ENTIDADE ctb602020
class cl_ctb602020 { 
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
   var $si102_sequencial = 0; 
   var $si102_tiporegistro = 0; 
   var $si102_codctb = 0; 
   var $si102_dataencerramento_dia = null; 
   var $si102_dataencerramento_mes = null; 
   var $si102_dataencerramento_ano = null; 
   var $si102_dataencerramento = null; 
   var $si102_mes = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si102_sequencial = int8 = sequencial 
                 si102_tiporegistro = int8 = Tipo do registro 
                 si102_codctb = int8 = Código Identificador da Conta Bancária 
                 si102_dataencerramento = date = Data do encerramento 
                 si102_mes = int8 = Mês 
                 ";
   //funcao construtor da classe 
   function cl_ctb602020() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ctb602020"); 
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
       $this->si102_sequencial = ($this->si102_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si102_sequencial"]:$this->si102_sequencial);
       $this->si102_tiporegistro = ($this->si102_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si102_tiporegistro"]:$this->si102_tiporegistro);
       $this->si102_codctb = ($this->si102_codctb == ""?@$GLOBALS["HTTP_POST_VARS"]["si102_codctb"]:$this->si102_codctb);
       if($this->si102_dataencerramento == ""){
         $this->si102_dataencerramento_dia = ($this->si102_dataencerramento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si102_dataencerramento_dia"]:$this->si102_dataencerramento_dia);
         $this->si102_dataencerramento_mes = ($this->si102_dataencerramento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si102_dataencerramento_mes"]:$this->si102_dataencerramento_mes);
         $this->si102_dataencerramento_ano = ($this->si102_dataencerramento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si102_dataencerramento_ano"]:$this->si102_dataencerramento_ano);
         if($this->si102_dataencerramento_dia != ""){
            $this->si102_dataencerramento = $this->si102_dataencerramento_ano."-".$this->si102_dataencerramento_mes."-".$this->si102_dataencerramento_dia;
         }
       }
       $this->si102_mes = ($this->si102_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si102_mes"]:$this->si102_mes);
     }else{
       $this->si102_sequencial = ($this->si102_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si102_sequencial"]:$this->si102_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si102_sequencial){ 
      $this->atualizacampos();
     if($this->si102_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do registro nao Informado.";
       $this->erro_campo = "si102_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si102_codctb == null ){ 
       $this->erro_sql = " Campo Código Identificador da Conta Bancária nao Informado.";
       $this->erro_campo = "si102_codctb";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si102_dataencerramento == null ){ 
       $this->erro_sql = " Campo Data do encerramento nao Informado.";
       $this->erro_campo = "si102_dataencerramento_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si102_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si102_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($si102_sequencial == "" || $si102_sequencial == null ){
       $result = db_query("select nextval('ctb602020_si102_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ctb602020_si102_sequencial_seq do campo: si102_sequencial"; 
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si102_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ctb602020_si102_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si102_sequencial)){
         $this->erro_sql = " Campo si102_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si102_sequencial = $si102_sequencial; 
       }
     }
     if(($this->si102_sequencial == null) || ($this->si102_sequencial == "") ){ 
       $this->erro_sql = " Campo si102_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ctb602020(
                                       si102_sequencial 
                                      ,si102_tiporegistro 
                                      ,si102_codctb 
                                      ,si102_dataencerramento 
                                      ,si102_mes 
                       )
                values (
                                $this->si102_sequencial 
                               ,$this->si102_tiporegistro 
                               ,$this->si102_codctb 
                               ,".($this->si102_dataencerramento == "null" || $this->si102_dataencerramento == ""?"null":"'".$this->si102_dataencerramento."'")." 
                               ,$this->si102_mes 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ctb602020 ($this->si102_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "ctb602020 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "ctb602020 ($this->si102_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si102_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si102_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010611,'$this->si102_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010331,2010611,'','".AddSlashes(pg_result($resaco,0,'si102_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010331,2010612,'','".AddSlashes(pg_result($resaco,0,'si102_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010331,2010613,'','".AddSlashes(pg_result($resaco,0,'si102_codctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010331,2010614,'','".AddSlashes(pg_result($resaco,0,'si102_dataencerramento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010331,2010615,'','".AddSlashes(pg_result($resaco,0,'si102_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si102_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ctb602020 set ";
     $virgula = "";
     if(trim($this->si102_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si102_sequencial"])){ 
       $sql  .= $virgula." si102_sequencial = $this->si102_sequencial ";
       $virgula = ",";
       if(trim($this->si102_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "si102_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si102_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si102_tiporegistro"])){ 
       $sql  .= $virgula." si102_tiporegistro = $this->si102_tiporegistro ";
       $virgula = ",";
       if(trim($this->si102_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do registro nao Informado.";
         $this->erro_campo = "si102_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si102_codctb)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si102_codctb"])){ 
       $sql  .= $virgula." si102_codctb = $this->si102_codctb ";
       $virgula = ",";
       if(trim($this->si102_codctb) == null ){ 
         $this->erro_sql = " Campo Código Identificador da Conta Bancária nao Informado.";
         $this->erro_campo = "si102_codctb";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si102_dataencerramento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si102_dataencerramento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si102_dataencerramento_dia"] !="") ){ 
       $sql  .= $virgula." si102_dataencerramento = '$this->si102_dataencerramento' ";
       $virgula = ",";
       if(trim($this->si102_dataencerramento) == null ){ 
         $this->erro_sql = " Campo Data do encerramento nao Informado.";
         $this->erro_campo = "si102_dataencerramento_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si102_dataencerramento_dia"])){ 
         $sql  .= $virgula." si102_dataencerramento = null ";
         $virgula = ",";
         if(trim($this->si102_dataencerramento) == null ){ 
           $this->erro_sql = " Campo Data do encerramento nao Informado.";
           $this->erro_campo = "si102_dataencerramento_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si102_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si102_mes"])){ 
       $sql  .= $virgula." si102_mes = $this->si102_mes ";
       $virgula = ",";
       if(trim($this->si102_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si102_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si102_sequencial!=null){
       $sql .= " si102_sequencial = $this->si102_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si102_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010611,'$this->si102_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si102_sequencial"]) || $this->si102_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010331,2010611,'".AddSlashes(pg_result($resaco,$conresaco,'si102_sequencial'))."','$this->si102_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si102_tiporegistro"]) || $this->si102_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010331,2010612,'".AddSlashes(pg_result($resaco,$conresaco,'si102_tiporegistro'))."','$this->si102_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si102_codctb"]) || $this->si102_codctb != "")
           $resac = db_query("insert into db_acount values($acount,2010331,2010613,'".AddSlashes(pg_result($resaco,$conresaco,'si102_codctb'))."','$this->si102_codctb',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si102_dataencerramento"]) || $this->si102_dataencerramento != "")
           $resac = db_query("insert into db_acount values($acount,2010331,2010614,'".AddSlashes(pg_result($resaco,$conresaco,'si102_dataencerramento'))."','$this->si102_dataencerramento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si102_mes"]) || $this->si102_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010331,2010615,'".AddSlashes(pg_result($resaco,$conresaco,'si102_mes'))."','$this->si102_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "ctb602020 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si102_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ctb602020 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si102_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si102_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si102_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si102_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010611,'$si102_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010331,2010611,'','".AddSlashes(pg_result($resaco,$iresaco,'si102_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010331,2010612,'','".AddSlashes(pg_result($resaco,$iresaco,'si102_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010331,2010613,'','".AddSlashes(pg_result($resaco,$iresaco,'si102_codctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010331,2010614,'','".AddSlashes(pg_result($resaco,$iresaco,'si102_dataencerramento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010331,2010615,'','".AddSlashes(pg_result($resaco,$iresaco,'si102_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ctb602020
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si102_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si102_sequencial = $si102_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "ctb602020 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si102_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ctb602020 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si102_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si102_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ctb602020";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si102_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ctb602020 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si102_sequencial!=null ){
         $sql2 .= " where ctb602020.si102_sequencial = $si102_sequencial "; 
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
   function sql_query_file ( $si102_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ctb602020 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si102_sequencial!=null ){
         $sql2 .= " where ctb602020.si102_sequencial = $si102_sequencial "; 
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
