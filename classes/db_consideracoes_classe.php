<?
//MODULO: sicom
//CLASSE DA ENTIDADE consideracoes
class cl_consideracoes {
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
   var $si171_sequencial = 0;
   var $si171_codarquivo = null;
   var $si171_consideracoes = null;
   var $si171_mesreferencia = 0;
   var $si171_anousu = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si171_sequencial = int8 = sequencial
                 si171_codarquivo = varchar(2) = Código do arquivo
                 si171_consideracoes = text = Informações complementares
                 si171_mesreferencia = int8 = Mês de referência
                 si171_anousu = int4 = Ano de referência
                 ";
   //funcao construtor da classe
   function cl_consideracoes() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("consideracoes");
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
       $this->si171_sequencial = ($this->si171_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si171_sequencial"]:$this->si171_sequencial);
       $this->si171_codarquivo = ($this->si171_codarquivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si171_codarquivo"]:$this->si171_codarquivo);
       $this->si171_consideracoes = ($this->si171_consideracoes == ""?@$GLOBALS["HTTP_POST_VARS"]["si171_consideracoes"]:$this->si171_consideracoes);
       $this->si171_mesreferencia = ($this->si171_mesreferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si171_mesreferencia"]:$this->si171_mesreferencia);
       $this->si171_anousu = ($this->si171_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["si171_anousu"]:$this->si171_anousu);
     }else{
       $this->si171_sequencial = ($this->si171_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si171_sequencial"]:$this->si171_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si171_sequencial){
      $this->atualizacampos();
     if($this->si171_codarquivo == null ){
       $this->erro_sql = " Campo Código do arquivo nao Informado.";
       $this->erro_campo = "si171_codarquivo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si171_consideracoes == null ){
       $this->erro_sql = " Campo Informações complementares nao Informado.";
       $this->erro_campo = "si171_consideracoes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si171_mesreferencia == null ){
       $this->erro_sql = " Campo Mês de referência nao Informado.";
       $this->erro_campo = "si171_mesreferencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si171_anousu == null ){
       $this->erro_sql = " Campo Ano de referência nao Informado.";
       $this->erro_campo = "si171_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si171_sequencial == "" || $si171_sequencial == null ){
       $result = db_query("select nextval('consideracoes_si171_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: consideracoes_si171_sequencial_seq do campo: si171_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si171_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from consideracoes_si171_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si171_sequencial)){
         $this->erro_sql = " Campo si171_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si171_sequencial = $si171_sequencial;
       }
     }
     if(($this->si171_sequencial == null) || ($this->si171_sequencial == "") ){
       $this->erro_sql = " Campo si171_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into consideracoes(
                                       si171_sequencial
                                      ,si171_codarquivo
                                      ,si171_consideracoes
                                      ,si171_mesreferencia
                                      ,si171_anousu
                       )
                values (
                                $this->si171_sequencial
                               ,'$this->si171_codarquivo'
                               ,'$this->si171_consideracoes'
                               ,$this->si171_mesreferencia
                               ,$this->si171_anousu
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "consideracoes ($this->si171_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "consideracoes já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "consideracoes ($this->si171_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si171_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si171_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011457,'$this->si171_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010405,2011457,'','".AddSlashes(pg_result($resaco,0,'si171_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010405,2011458,'','".AddSlashes(pg_result($resaco,0,'si171_codarquivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010405,2011459,'','".AddSlashes(pg_result($resaco,0,'si171_consideracoes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010405,2011460,'','".AddSlashes(pg_result($resaco,0,'si171_mesreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($si171_sequencial=null) {
    $this->atualizacampos();
     $sql = " update consideracoes set ";
     $virgula = "";
     if(trim($this->si171_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si171_sequencial"])){
       $sql  .= $virgula." si171_sequencial = $this->si171_sequencial ";
       $virgula = ",";
       if(trim($this->si171_sequencial) == null ){
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "si171_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si171_codarquivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si171_codarquivo"])){
       $sql  .= $virgula." si171_codarquivo = '$this->si171_codarquivo' ";
       $virgula = ",";
       if(trim($this->si171_codarquivo) == null ){
         $this->erro_sql = " Campo Código do arquivo nao Informado.";
         $this->erro_campo = "si171_codarquivo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si171_consideracoes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si171_consideracoes"])){
       $sql  .= $virgula." si171_consideracoes = '$this->si171_consideracoes' ";
       $virgula = ",";
       if(trim($this->si171_consideracoes) == null ){
         $this->erro_sql = " Campo Informações complementares nao Informado.";
         $this->erro_campo = "si171_consideracoes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si171_mesreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si171_mesreferencia"])){
       $sql  .= $virgula." si171_mesreferencia = $this->si171_mesreferencia ";
       $virgula = ",";
       if(trim($this->si171_mesreferencia) == null ){
         $this->erro_sql = " Campo Mês de referência nao Informado.";
         $this->erro_campo = "si171_mesreferencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si171_sequencial!=null){
       $sql .= " si171_sequencial = $this->si171_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si171_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011457,'$this->si171_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si171_sequencial"]) || $this->si171_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010405,2011457,'".AddSlashes(pg_result($resaco,$conresaco,'si171_sequencial'))."','$this->si171_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si171_codarquivo"]) || $this->si171_codarquivo != "")
           $resac = db_query("insert into db_acount values($acount,2010405,2011458,'".AddSlashes(pg_result($resaco,$conresaco,'si171_codarquivo'))."','$this->si171_codarquivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si171_consideracoes"]) || $this->si171_consideracoes != "")
           $resac = db_query("insert into db_acount values($acount,2010405,2011459,'".AddSlashes(pg_result($resaco,$conresaco,'si171_consideracoes'))."','$this->si171_consideracoes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si171_mesreferencia"]) || $this->si171_mesreferencia != "")
           $resac = db_query("insert into db_acount values($acount,2010405,2011460,'".AddSlashes(pg_result($resaco,$conresaco,'si171_mesreferencia'))."','$this->si171_mesreferencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "consideracoes nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si171_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "consideracoes nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si171_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si171_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si171_sequencial=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si171_sequencial));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011457,'$si171_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010405,2011457,'','".AddSlashes(pg_result($resaco,$iresaco,'si171_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010405,2011458,'','".AddSlashes(pg_result($resaco,$iresaco,'si171_codarquivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010405,2011459,'','".AddSlashes(pg_result($resaco,$iresaco,'si171_consideracoes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010405,2011460,'','".AddSlashes(pg_result($resaco,$iresaco,'si171_mesreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from consideracoes
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si171_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si171_sequencial = $si171_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "consideracoes nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si171_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "consideracoes nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si171_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si171_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:consideracoes";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si171_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from consideracoes ";
     $sql2 = "";
     if($dbwhere==""){
       if($si171_sequencial!=null ){
         $sql2 .= " where consideracoes.si171_sequencial = $si171_sequencial ";
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
   function sql_query_file ( $si171_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from consideracoes ";
     $sql2 = "";
     if($dbwhere==""){
       if($si171_sequencial!=null ){
         $sql2 .= " where consideracoes.si171_sequencial = $si171_sequencial ";
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
