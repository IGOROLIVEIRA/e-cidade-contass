<?
//MODULO: sicom
//CLASSE DA ENTIDADE empcontratos
class cl_empcontratos { 
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
   var $si173_sequencial = 0; 
   var $si173_codcontrato = 0; 
   var $si173_empenho = 0; 
   var $si173_anoempenho = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si173_sequencial = int8 = sequencial 
                 si173_codcontrato = int8 = Código do Contrato 
                 si173_empenho = int8 = Número do  empenho 
                 si173_anoempenho = int8 = Ano Empenho 
                 ";
   //funcao construtor da classe 
   function cl_empcontratos() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("empcontratos"); 
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
       $this->si173_sequencial = ($this->si173_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si173_sequencial"]:$this->si173_sequencial);
       $this->si173_codcontrato = ($this->si173_codcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si173_codcontrato"]:$this->si173_codcontrato);
       $this->si173_empenho = ($this->si173_empenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si173_empenho"]:$this->si173_empenho);
       $this->si173_anoempenho = ($this->si173_anoempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si173_anoempenho"]:$this->si173_anoempenho);
     }else{
       $this->si173_sequencial = ($this->si173_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si173_sequencial"]:$this->si173_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si173_sequencial){ 
      $this->atualizacampos();
     if($this->si173_codcontrato == null ){ 
       $this->erro_sql = " Campo Código do Contrato nao Informado.";
       $this->erro_campo = "si173_codcontrato";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si173_empenho == null ){ 
       $this->erro_sql = " Campo Número do  empenho nao Informado.";
       $this->erro_campo = "si173_empenho";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si173_anoempenho == null ){ 
       $this->erro_sql = " Campo Ano Empenho nao Informado.";
       $this->erro_campo = "si173_anoempenho";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si173_sequencial == "" || $si173_sequencial == null ){
       $result = db_query("select nextval('empcontratos_si173_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: empcontratos_si173_sequencial_seq do campo: si173_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si173_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from empcontratos_si173_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si173_sequencial)){
         $this->erro_sql = " Campo si173_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si173_sequencial = $si173_sequencial; 
       }
     }
     if(($this->si173_sequencial == null) || ($this->si173_sequencial == "") ){ 
       $this->erro_sql = " Campo si173_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into empcontratos(
                                       si173_sequencial 
                                      ,si173_codcontrato 
                                      ,si173_empenho 
                                      ,si173_anoempenho 
                       )
                values (
                                $this->si173_sequencial 
                               ,$this->si173_codcontrato 
                               ,$this->si173_empenho 
                               ,$this->si173_anoempenho 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "empcontratos ($this->si173_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "empcontratos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "empcontratos ($this->si173_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si173_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si173_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011489,'$this->si173_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010407,2011489,'','".AddSlashes(pg_result($resaco,0,'si173_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010407,2011490,'','".AddSlashes(pg_result($resaco,0,'si173_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010407,2011491,'','".AddSlashes(pg_result($resaco,0,'si173_empenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010407,2011492,'','".AddSlashes(pg_result($resaco,0,'si173_anoempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si173_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update empcontratos set ";
     $virgula = "";
     if(trim($this->si173_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si173_sequencial"])){ 
       $sql  .= $virgula." si173_sequencial = $this->si173_sequencial ";
       $virgula = ",";
       if(trim($this->si173_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "si173_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si173_codcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si173_codcontrato"])){ 
       $sql  .= $virgula." si173_codcontrato = $this->si173_codcontrato ";
       $virgula = ",";
       if(trim($this->si173_codcontrato) == null ){ 
         $this->erro_sql = " Campo Código do Contrato nao Informado.";
         $this->erro_campo = "si173_codcontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si173_empenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si173_empenho"])){ 
       $sql  .= $virgula." si173_empenho = $this->si173_empenho ";
       $virgula = ",";
       if(trim($this->si173_empenho) == null ){ 
         $this->erro_sql = " Campo Número do  empenho nao Informado.";
         $this->erro_campo = "si173_empenho";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si173_anoempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si173_anoempenho"])){ 
       $sql  .= $virgula." si173_anoempenho = $this->si173_anoempenho ";
       $virgula = ",";
       if(trim($this->si173_anoempenho) == null ){ 
         $this->erro_sql = " Campo Ano Empenho nao Informado.";
         $this->erro_campo = "si173_anoempenho";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si173_sequencial!=null){
       $sql .= " si173_sequencial = $this->si173_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si173_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011489,'$this->si173_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si173_sequencial"]) || $this->si173_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010407,2011489,'".AddSlashes(pg_result($resaco,$conresaco,'si173_sequencial'))."','$this->si173_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si173_codcontrato"]) || $this->si173_codcontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010407,2011490,'".AddSlashes(pg_result($resaco,$conresaco,'si173_codcontrato'))."','$this->si173_codcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si173_empenho"]) || $this->si173_empenho != "")
           $resac = db_query("insert into db_acount values($acount,2010407,2011491,'".AddSlashes(pg_result($resaco,$conresaco,'si173_empenho'))."','$this->si173_empenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si173_anoempenho"]) || $this->si173_anoempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010407,2011492,'".AddSlashes(pg_result($resaco,$conresaco,'si173_anoempenho'))."','$this->si173_anoempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "empcontratos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si173_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "empcontratos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si173_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si173_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si173_sequencial=null,$dbwhere=null) { 

     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si173_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011489,'$si173_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010407,2011489,'','".AddSlashes(pg_result($resaco,$iresaco,'si173_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010407,2011490,'','".AddSlashes(pg_result($resaco,$iresaco,'si173_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010407,2011491,'','".AddSlashes(pg_result($resaco,$iresaco,'si173_empenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010407,2011492,'','".AddSlashes(pg_result($resaco,$iresaco,'si173_anoempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from empcontratos
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si173_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si173_sequencial = $si173_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "empcontratos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si173_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "empcontratos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si173_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si173_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:empcontratos";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si173_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from empcontratos ";
     $sql .= "      inner join contratos  on  contratos.si172_sequencial = empcontratos.si173_codcontrato";
     $sql .= "      inner join pcorcamforne  on  pcorcamforne.pc21_orcamforne = contratos.si172_fornecedor";
     $sql .= "      inner join liclicita  on  liclicita.l20_codigo = contratos.si172_licitacao";
     $sql2 = "";
     if($dbwhere==""){
       if($si173_sequencial!=null ){
         $sql2 .= " where empcontratos.si173_sequencial = $si173_sequencial "; 
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
   function sql_query_file ( $si173_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from empcontratos ";
     $sql2 = "";
     if($dbwhere==""){
       if($si173_sequencial!=null ){
         $sql2 .= " where empcontratos.si173_sequencial = $si173_sequencial "; 
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
