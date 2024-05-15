<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE inscricaorestosapagaremliquidacao
class cl_inscricaorestosapagaremliquidacao { 
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
   var $c107_sequencial = 0; 
   var $c107_ano = 0; 
   var $c107_processado = 'f'; 
   var $c107_usuario = 0; 
   var $c107_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 c107_sequencial = int4 = Sequencial 
                 c107_ano = int4 = Ano 
                 c107_processado = bool = Processado 
                 c107_usuario = int4 = Cod. Usuário 
                 c107_instit = int4 = Cod. Instituição 
                 ";
   //funcao construtor da classe 
   function cl_inscricaorestosapagaremliquidacao() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("inscricaorestosapagaremliquidacao"); 
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
       $this->c107_sequencial = ($this->c107_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c107_sequencial"]:$this->c107_sequencial);
       $this->c107_ano = ($this->c107_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["c107_ano"]:$this->c107_ano);
       $this->c107_processado = ($this->c107_processado == "f"?@$GLOBALS["HTTP_POST_VARS"]["c107_processado"]:$this->c107_processado);
       $this->c107_usuario = ($this->c107_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["c107_usuario"]:$this->c107_usuario);
       $this->c107_instit = ($this->c107_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["c107_instit"]:$this->c107_instit);
     }else{
       $this->c107_sequencial = ($this->c107_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c107_sequencial"]:$this->c107_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($c107_sequencial){ 
      $this->atualizacampos();
     if($this->c107_ano == null ){ 
       $this->erro_sql = " Campo Ano não informado.";
       $this->erro_campo = "c107_ano";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c107_processado == null ){ 
       $this->erro_sql = " Campo Processado não informado.";
       $this->erro_campo = "c107_processado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c107_usuario == null ){ 
       $this->erro_sql = " Campo Cod. Usuário não informado.";
       $this->erro_campo = "c107_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c107_instit == null ){ 
       $this->erro_sql = " Campo Cod. Instituição não informado.";
       $this->erro_campo = "c107_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($c107_sequencial == "" || $c107_sequencial == null ){
       $result = db_query("select nextval('inscricaorestosapagaremliquidacao_c107_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: inscricaorestosapagaremliquidacao_c107_sequencial_seq do campo: c107_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->c107_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from inscricaorestosapagaremliquidacao_c107_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $c107_sequencial)){
         $this->erro_sql = " Campo c107_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->c107_sequencial = $c107_sequencial; 
       }
     }
     if(($this->c107_sequencial == null) || ($this->c107_sequencial == "") ){ 
       $this->erro_sql = " Campo c107_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into inscricaorestosapagaremliquidacao(
                                       c107_sequencial 
                                      ,c107_ano 
                                      ,c107_processado 
                                      ,c107_usuario 
                                      ,c107_instit 
                       )
                values (
                                $this->c107_sequencial 
                               ,$this->c107_ano 
                               ,'$this->c107_processado' 
                               ,$this->c107_usuario 
                               ,$this->c107_instit 
                      )";
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Inscrição de Restos a Pagar Em Liquidação ($this->c107_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Inscrição de Restos a Pagar Em Liquidação já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Inscrição de Restos a Pagar Em Liquidação ($this->c107_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c107_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->c107_sequencial  ));
       /*if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,19500,'$this->c107_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010227,19500,'','".AddSlashes(pg_result($resaco,0,'c107_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010227,19501,'','".AddSlashes(pg_result($resaco,0,'c107_ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010227,19502,'','".AddSlashes(pg_result($resaco,0,'c107_processado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010227,19503,'','".AddSlashes(pg_result($resaco,0,'c107_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010227,19504,'','".AddSlashes(pg_result($resaco,0,'c107_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }*/
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($c107_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update inscricaorestosapagaremliquidacao set ";
     $virgula = "";
     if(trim($this->c107_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c107_sequencial"])){ 
       $sql  .= $virgula." c107_sequencial = $this->c107_sequencial ";
       $virgula = ",";
       if(trim($this->c107_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "c107_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c107_ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c107_ano"])){ 
       $sql  .= $virgula." c107_ano = $this->c107_ano ";
       $virgula = ",";
       if(trim($this->c107_ano) == null ){ 
         $this->erro_sql = " Campo Ano não informado.";
         $this->erro_campo = "c107_ano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c107_processado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c107_processado"])){ 
       $sql  .= $virgula." c107_processado = '$this->c107_processado' ";
       $virgula = ",";
       if(trim($this->c107_processado) == null ){ 
         $this->erro_sql = " Campo Processado não informado.";
         $this->erro_campo = "c107_processado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c107_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c107_usuario"])){ 
       $sql  .= $virgula." c107_usuario = $this->c107_usuario ";
       $virgula = ",";
       if(trim($this->c107_usuario) == null ){ 
         $this->erro_sql = " Campo Cod. Usuário não informado.";
         $this->erro_campo = "c107_usuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c107_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c107_instit"])){ 
       $sql  .= $virgula." c107_instit = $this->c107_instit ";
       $virgula = ",";
       if(trim($this->c107_instit) == null ){ 
         $this->erro_sql = " Campo Cod. Instituição não informado.";
         $this->erro_campo = "c107_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($c107_sequencial!=null){
       $sql .= " c107_sequencial = $this->c107_sequencial";
     }
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->c107_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,19500,'$this->c107_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["c107_sequencial"]) || $this->c107_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010227,19500,'".AddSlashes(pg_result($resaco,$conresaco,'c107_sequencial'))."','$this->c107_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["c107_ano"]) || $this->c107_ano != "")
             $resac = db_query("insert into db_acount values($acount,1010227,19501,'".AddSlashes(pg_result($resaco,$conresaco,'c107_ano'))."','$this->c107_ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["c107_processado"]) || $this->c107_processado != "")
             $resac = db_query("insert into db_acount values($acount,1010227,19502,'".AddSlashes(pg_result($resaco,$conresaco,'c107_processado'))."','$this->c107_processado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["c107_usuario"]) || $this->c107_usuario != "")
             $resac = db_query("insert into db_acount values($acount,1010227,19503,'".AddSlashes(pg_result($resaco,$conresaco,'c107_usuario'))."','$this->c107_usuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["c107_instit"]) || $this->c107_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010227,19504,'".AddSlashes(pg_result($resaco,$conresaco,'c107_instit'))."','$this->c107_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Inscrição de Restos a Pagar Em Liquidação nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c107_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Inscrição de Restos a Pagar Em Liquidação nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c107_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c107_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($c107_sequencial=null,$dbwhere=null) { 

     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($c107_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,19500,'$c107_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010227,19500,'','".AddSlashes(pg_result($resaco,$iresaco,'c107_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010227,19501,'','".AddSlashes(pg_result($resaco,$iresaco,'c107_ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010227,19502,'','".AddSlashes(pg_result($resaco,$iresaco,'c107_processado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010227,19503,'','".AddSlashes(pg_result($resaco,$iresaco,'c107_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010227,19504,'','".AddSlashes(pg_result($resaco,$iresaco,'c107_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from inscricaorestosapagaremliquidacao
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($c107_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " c107_sequencial = $c107_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Inscrição de Restos a Pagar Em Liquidação nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c107_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Inscrição de Restos a Pagar Em Liquidação nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c107_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c107_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:inscricaorestosapagaremliquidacao";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $c107_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from inscricaorestosapagaremliquidacao ";
     $sql .= "      inner join db_config  on  db_config.codigo = inscricaorestosapagaremliquidacao.c107_instit";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = inscricaorestosapagaremliquidacao.c107_usuario";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = db_config.numcgm";
     $sql .= "      inner join db_tipoinstit  on  db_tipoinstit.db21_codtipo = db_config.db21_tipoinstit";
     $sql2 = "";
     if($dbwhere==""){
       if($c107_sequencial!=null ){
         $sql2 .= " where inscricaorestosapagaremliquidacao.c107_sequencial = $c107_sequencial "; 
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
   function sql_query_file ( $c107_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from inscricaorestosapagaremliquidacao ";
     $sql2 = "";
     if($dbwhere==""){
       if($c107_sequencial!=null ){
         $sql2 .= " where inscricaorestosapagaremliquidacao.c107_sequencial = $c107_sequencial "; 
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
