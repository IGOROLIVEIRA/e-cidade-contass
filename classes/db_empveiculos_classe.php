<?
//MODULO: sicom
//CLASSE DA ENTIDADE empveiculos
class cl_empveiculos { 
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
   var $si05_sequencial = 0; 
   var $si05_numemp = 0; 
   var $si05_atestado = 'f'; 
   var $si05_codabast = 0;
   var $si05_item_empenho = null;
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si05_sequencial = int8 = Sequencial 
                 si05_numemp = int8 = N. Empenho 
                 si05_atestado = bool = Atestado 
                 si05_codabast = int8 = Codigo Abastecimento
                 si05_item_empenho = bool = Preencher item empenho 
                 ";
   //funcao construtor da classe 
   function cl_empveiculos() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("empveiculos"); 
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
       $this->si05_sequencial = ($this->si05_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si05_sequencial"]:$this->si05_sequencial);
       $this->si05_numemp = ($this->si05_numemp == ""?@$GLOBALS["HTTP_POST_VARS"]["si05_numemp"]:$this->si05_numemp);
       $this->si05_atestado = ($this->si05_atestado == "f"?@$GLOBALS["HTTP_POST_VARS"]["si05_atestado"]:$this->si05_atestado);
       $this->si05_codabast = ($this->si05_codabast == ""?@$GLOBALS["HTTP_POST_VARS"]["si05_codabast"]:$this->si05_codabast);
       $this->si05_item_empenho = ($this->si05_item_empenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si05_item_empenho"]:$this->si05_item_empenho);
     }else{
       $this->si05_sequencial = ($this->si05_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si05_sequencial"]:$this->si05_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si05_sequencial){ 
      $this->atualizacampos();
     if($this->si05_numemp == null ){ 
       $this->erro_sql = " Campo N. Empenho nao Informado.";
       $this->erro_campo = "si05_numemp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si05_atestado == null ){ 
       $this->erro_sql = " Campo Atestado nao Informado.";
       $this->erro_campo = "si05_atestado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si05_codabast == null ){ 
       $this->erro_sql = " Campo Codigo Abastecimento nao Informado.";
       $this->erro_campo = "si05_codabast";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si05_item_empenho == null ){ 
      $this->erro_sql = " Campo do item empenho nao Informado.";
      $this->erro_campo = "si05_item_empenho";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
     
     
   if($si05_sequencial == "" || $si05_sequencial == null ){
       $result = db_query("select nextval('sic_empveiculos_si05_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: sic_empveiculos_si05_sequencial_seq do campo: si05_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si05_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from sic_empveiculos_si05_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si05_sequencial)){
         $this->erro_sql = " Campo si05_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si05_sequencial = $si05_sequencial; 
       }
     }
     if(($this->si05_sequencial == null) || ($this->si05_sequencial == "") ){ 
       $this->erro_sql = " Campo si05_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
     
     $sql = "insert into empveiculos(
                                       si05_sequencial 
                                      ,si05_numemp 
                                      ,si05_atestado 
                                      ,si05_codabast
                                      ,si05_item_empenho 
                       )
                values (
                                $this->si05_sequencial 
                               ,$this->si05_numemp 
                               ,'$this->si05_atestado' 
                               ,$this->si05_codabast
                               ,'$this->si05_item_empenho'  
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Empenhos por abastecimento ($this->si05_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Empenhos por abastecimento já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Empenhos por abastecimento ($this->si05_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si05_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si05_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009279,'$this->si05_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010203,2009279,'','".AddSlashes(pg_result($resaco,0,'si05_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010203,2009280,'','".AddSlashes(pg_result($resaco,0,'si05_numemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010203,2009281,'','".AddSlashes(pg_result($resaco,0,'si05_atestado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010203,2009282,'','".AddSlashes(pg_result($resaco,0,'si05_codabast'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si05_sequencial=null,$si05_codabast=null) { 
      $this->atualizacampos();
     $sql = " update empveiculos set ";
     $virgula = "";
     if(trim($this->si05_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si05_sequencial"])){ 
       $sql  .= $virgula." si05_sequencial = $this->si05_sequencial ";
       $virgula = ",";
       if(trim($this->si05_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial nao Informado.";
         $this->erro_campo = "si05_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si05_numemp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si05_numemp"])){ 
       $sql  .= $virgula." si05_numemp = $this->si05_numemp ";
       $virgula = ",";
       if(trim($this->si05_numemp) == null ){ 
         $this->erro_sql = " Campo N. Empenho nao Informado.";
         $this->erro_campo = "si05_numemp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si05_atestado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si05_atestado"])){ 
       $sql  .= $virgula." si05_atestado = '$this->si05_atestado' ";
       $virgula = ",";
       if(trim($this->si05_atestado) == null ){ 
         $this->erro_sql = " Campo Atestado nao Informado.";
         $this->erro_campo = "si05_atestado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si05_codabast)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si05_codabast"])){ 
       $sql  .= $virgula." si05_codabast = $this->si05_codabast ";
       $virgula = ",";
       if(trim($this->si05_codabast) == null ){ 
         $this->erro_sql = " Campo Codigo Abastecimento nao Informado.";
         $this->erro_campo = "si05_codabast";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si05_item_empenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si05_item_empenho"])){ 
      $sql  .= $virgula." si05_item_empenho = '$this->si05_item_empenho' ";
      $virgula = ",";
      if(trim($this->si05_item_empenho) == null ){ 
        $this->erro_sql = " Campo item empenho nao Informado.";
        $this->erro_campo = "si05_item_empenho";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
     $sql .= " where ";
     if($si05_sequencial!=null){
       $sql .= " si05_sequencial = $this->si05_sequencial";
     }
   	 if($si05_codabast!=null){
       $sql .= " si05_codabast = $si05_codabast";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si05_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009279,'$this->si05_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si05_sequencial"]) || $this->si05_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010203,2009279,'".AddSlashes(pg_result($resaco,$conresaco,'si05_sequencial'))."','$this->si05_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si05_numemp"]) || $this->si05_numemp != "")
           $resac = db_query("insert into db_acount values($acount,2010203,2009280,'".AddSlashes(pg_result($resaco,$conresaco,'si05_numemp'))."','$this->si05_numemp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si05_atestado"]) || $this->si05_atestado != "")
           $resac = db_query("insert into db_acount values($acount,2010203,2009281,'".AddSlashes(pg_result($resaco,$conresaco,'si05_atestado'))."','$this->si05_atestado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si05_codabast"]) || $this->si05_codabast != "")
           $resac = db_query("insert into db_acount values($acount,2010203,2009282,'".AddSlashes(pg_result($resaco,$conresaco,'si05_codabast'))."','$this->si05_codabast',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Empenhos por abastecimento nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si05_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Empenhos por abastecimento nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si05_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si05_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si05_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si05_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009279,'$si05_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010203,2009279,'','".AddSlashes(pg_result($resaco,$iresaco,'si05_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010203,2009280,'','".AddSlashes(pg_result($resaco,$iresaco,'si05_numemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010203,2009281,'','".AddSlashes(pg_result($resaco,$iresaco,'si05_atestado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010203,2009282,'','".AddSlashes(pg_result($resaco,$iresaco,'si05_codabast'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from empveiculos
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si05_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si05_sequencial = $si05_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Empenhos por abastecimento nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si05_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Empenhos por abastecimento nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si05_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si05_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:empveiculos";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si05_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from empveiculos ";
     $sql .= "      inner join veicabast  on  veicabast.ve70_codigo = empveiculos.si05_codabast";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = veicabast.ve70_usuario";
     $sql .= "      inner join veiccadcomb  on  veiccadcomb.ve26_codigo = veicabast.ve70_veiculoscomb";
     $sql .= "      inner join veiculos  on  veiculos.ve01_codigo = veicabast.ve70_veiculos";
     $sql2 = "";
     if($dbwhere==""){
       if($si05_sequencial!=null ){
         $sql2 .= " where empveiculos.si05_sequencial = $si05_sequencial "; 
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
   function sql_query_file ( $si05_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from empveiculos ";
     $sql2 = "";
     if($dbwhere==""){
       if($si05_sequencial!=null ){
         $sql2 .= " where empveiculos.si05_sequencial = $si05_sequencial "; 
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
