<?
//MODULO: empenho
//CLASSE DA ENTIDADE empdescontonota
class cl_empdescontonota {
   // cria variaveis de erro
   var $rotulo     = null;
   var $query_sql  = null;
   var $numrows    = 0;
   var $erro_status= null;
   var $erro_sql   = null;
   var $erro_banco = null;
   var $erro_msg   = null;
   var $erro_campo = null;
   var $pagina_retorno = null;
   // cria variaveis do arquivo
   var $e999_sequencial = 0;
   var $e999_nota = null;
   var $e999_valor = 0;
   var $e999_empenho = null;
   var $e999_desconto = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 e999_sequencial = int4 = Cód. Seq
                 e999_nota = text = Nota
                 e999_valor = float = Valor
                 e999_empenho = int = empenho
                 e999_desconto = float = Desconto
                 ";
   //funcao construtor da classe
   function cl_empdescontonota() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("empdescontonota");
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
       $this->e999_sequencial = ($this->e999_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["e999_sequencial"]:$this->e999_sequencial);
       $this->e999_nota = ($this->e999_nota == ""?@$GLOBALS["HTTP_POST_VARS"]["e999_nota"]:$this->e999_nota);
       $this->e999_valor = ($this->e999_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["e999_valor"]:$this->e999_valor);
       $this->e999_empenho = ($this->e999_empenho == ""?@$GLOBALS["HTTP_POST_VARS"]["e999_empenho"]:$this->e999_empenho);
       $this->e999_desconto = ($this->e999_desconto == ""?@$GLOBALS["HTTP_POST_VARS"]["e999_desconto"]:$this->e999_desconto);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){
      $this->atualizacampos();

     if($this->e999_nota == null ){
       $this->erro_sql = " Campo Nota nao Informado.";
       $this->erro_campo = "e999_nota";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e999_valor == null ){
       $this->erro_sql = " Campo Valor nao Informado.";
       $this->erro_campo = "e999_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e999_empenho == null ){
       $this->erro_sql = " Campo Empenho nao Informado.";
       $this->erro_campo = "e999_empenho";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e999_desconto == null ){
      $this->e999_desconto = 0;
     }
     if($this->e999_sequencial == "" || $this->e999_sequencial == null ){
       $result = @pg_query("select nextval('empdescontonota_e999_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: empdescontonota_e999_sequencial_seq do campo: e999_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->e999_sequencial = pg_result($result,0,0);
     }else{
       $result = @pg_query("select last_value from empdescontonota_e999_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $e999_sequencial)){
         $this->erro_sql = " Campo e999_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->e999_sequencial = $this->e999_sequencial;
       }
     }
     $sql = "insert into empdescontonota(
                                       e999_sequencial
                                      ,e999_nota
                                      ,e999_valor
                                      ,e999_empenho
                                      ,e999_desconto
                       )
                values (
                                $this->e999_sequencial
                               ,'$this->e999_nota'
                               ,$this->e999_valor
                               ,$this->e999_empenho
                               ,$this->e999_desconto
                      )";
     $result = @pg_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Desconto de Notas () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Desconto de Notas já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Desconto de Notas () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   }
   // funcao para alteracao
   function alterar ( $e999_sequencial=null ) {
      $this->atualizacampos();
     $sql = " update empdescontonota set ";
     $virgula = "";

     if(trim($this->e999_nota)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e999_nota"])){
       $sql  .= $virgula." e999_nota = '$this->e999_nota' ";
       $virgula = ",";
       if(trim($this->e999_nota) == null ){
         $this->erro_sql = " Campo Nota nao Informado.";
         $this->erro_campo = "e999_nota";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e999_valor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e999_valor"])){
        if(trim($this->e999_valor)=="" && isset($GLOBALS["HTTP_POST_VARS"]["e999_valor"])){
           $this->e999_valor = "0" ;
        }
       $sql  .= $virgula." e999_valor = $this->e999_valor ";
       $virgula = ",";
       if(trim($this->e999_valor) == null ){
         $this->erro_sql = " Campo Valor nao Informado.";
         $this->erro_campo = "e999_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->e999_desconto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e999_desconto"])){
        if(trim($this->e999_desconto)=="" && isset($GLOBALS["HTTP_POST_VARS"]["e999_desconto"])){
           $this->e999_desconto = "0" ;
        }
       $sql  .= $virgula." e999_desconto = $this->e999_desconto ";
       $virgula = ",";
       if(trim($this->e999_desconto) == null ){
         $this->erro_sql = " Campo Desconto nao Informado.";
         $this->erro_campo = "e999_desconto";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where e999_sequencial = $e999_sequencial ";
     $result = @pg_exec($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Desconto de Notas nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Desconto de Notas nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ( $e999_sequencial=null ) {
     $this->atualizacampos(true);
     $sql = " delete from empdescontonota
                    where ";
     $sql2 = "";
     $sql2 = "e999_sequencial = $e999_sequencial";
     $result = @pg_exec($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Desconto de Notas nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Desconto de Notas nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }
     }
   }
   // funcao do recordset
   function sql_record($sql) {
     $result = @pg_query($sql);
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
        $this->erro_sql   = "Dados do Grupo nao Encontrado";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $e999_sequencial = null,$campos="empdescontonota.e999_sequencial,*",$ordem=null,$dbwhere=""){
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
     $sql .= " from empdescontonota ";
     $sql .= " INNER JOIN empprestaitem ON e46_numemp = e999_empenho AND empprestaitem.e46_nota = empdescontonota.e999_nota ";
     $sql .= " INNER JOIN emppresta AS a ON a.e45_sequencial = empprestaitem.e46_emppresta ";
     $sql2 = "";
     if($dbwhere==""){
       if( $e999_sequencial != "" && $e999_sequencial != null){
          $sql2 = " where empdescontonota.e999_sequencial = $e999_sequencial";
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
   function sql_query_file ( $e999_sequencial = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from empdescontonota ";
     $sql2 = "";
     if($dbwhere==""){
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
