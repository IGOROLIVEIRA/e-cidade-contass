<?
//MODULO: material
//CLASSE DA ENTIDADE inventariomaterial
class cl_inventariomaterial {
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
   var $i77_sequencial = 0;
   var $i77_inventario = 0;
   var $i77_estoque = 0;
   var $i77_db_depart = 0;
   var $i77_estoqueinicial = 0;
   var $i77_contagem = 0;
   var $i77_valorinicial = 0;
   var $i77_valormedio = 0;
   var $i77_vinculoinventario = 'f';
   var $i77_datainclusao_dia = null;
   var $i77_datainclusao_mes = null;
   var $i77_datainclusao_ano = null;
   var $i77_datainclusao = null;
   var $i77_dataprocessamento_dia = null;
   var $i77_dataprocessamento_mes = null;
   var $i77_dataprocessamento_ano = null;
   var $i77_dataprocessamento = null;
   var $i77_ultimolancamento = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 i77_sequencial = int4 = Sequencia inventario material
                 i77_inventario = int4 = Inventario
                 i77_estoque = int4 = CÃ³digo Estoque
                 i77_db_depart = int4 = Departamento do material
                 i77_estoqueinicial = numeric(10) = Estoque inicial
                 i77_contagem = numeric(10) = Contagem
                 i77_valorinicial = numeric(10) = Valor na tabela estoque
                 i77_valormedio = numeric(10) = Valor no inventario
                 i77_vinculoinventario = bool = Status vinculo
                 i77_datainclusao = date = Data inclusao no inventario
                 i77_dataprocessamento = date = Data processamento inventario
                 i77_ultimolancamento = int4 = Sequencia ultimo
                 ";
   //funcao construtor da classe
   function cl_inventariomaterial() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("inventariomaterial");
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
       $this->i77_sequencial = ($this->i77_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["i77_sequencial"]:$this->i77_sequencial);
       $this->i77_inventario = ($this->i77_inventario == ""?@$GLOBALS["HTTP_POST_VARS"]["i77_inventario"]:$this->i77_inventario);
       $this->i77_estoque = ($this->i77_estoque == ""?@$GLOBALS["HTTP_POST_VARS"]["i77_estoque"]:$this->i77_estoque);
       $this->i77_db_depart = ($this->i77_db_depart == ""?@$GLOBALS["HTTP_POST_VARS"]["i77_db_depart"]:$this->i77_db_depart);
       $this->i77_estoqueinicial = ($this->i77_estoqueinicial == ""?@$GLOBALS["HTTP_POST_VARS"]["i77_estoqueinicial"]:$this->i77_estoqueinicial);
       $this->i77_contagem = ($this->i77_contagem == ""?@$GLOBALS["HTTP_POST_VARS"]["i77_contagem"]:$this->i77_contagem);
       $this->i77_valorinicial = ($this->i77_valorinicial == ""?@$GLOBALS["HTTP_POST_VARS"]["i77_valorinicial"]:$this->i77_valorinicial);
       $this->i77_valormedio = ($this->i77_valormedio == ""?@$GLOBALS["HTTP_POST_VARS"]["i77_valormedio"]:$this->i77_valormedio);
       $this->i77_vinculoinventario = ($this->i77_vinculoinventario == "f"?@$GLOBALS["HTTP_POST_VARS"]["i77_vinculoinventario"]:$this->i77_vinculoinventario);
       if($this->i77_datainclusao == ""){
         $this->i77_datainclusao_dia = @$GLOBALS["HTTP_POST_VARS"]["i77_datainclusao_dia"];
         $this->i77_datainclusao_mes = @$GLOBALS["HTTP_POST_VARS"]["i77_datainclusao_mes"];
         $this->i77_datainclusao_ano = @$GLOBALS["HTTP_POST_VARS"]["i77_datainclusao_ano"];
         if($this->i77_datainclusao_dia != ""){
            $this->i77_datainclusao = $this->i77_datainclusao_ano."-".$this->i77_datainclusao_mes."-".$this->i77_datainclusao_dia;
         }
       }
       if($this->i77_dataprocessamento == ""){
         $this->i77_dataprocessamento_dia = @$GLOBALS["HTTP_POST_VARS"]["i77_dataprocessamento_dia"];
         $this->i77_dataprocessamento_mes = @$GLOBALS["HTTP_POST_VARS"]["i77_dataprocessamento_mes"];
         $this->i77_dataprocessamento_ano = @$GLOBALS["HTTP_POST_VARS"]["i77_dataprocessamento_ano"];
         if($this->i77_dataprocessamento_dia != ""){
            $this->i77_dataprocessamento = $this->i77_dataprocessamento_ano."-".$this->i77_dataprocessamento_mes."-".$this->i77_dataprocessamento_dia;
         }
       }
       $this->i77_ultimolancamento = ($this->i77_ultimolancamento == ""?@$GLOBALS["HTTP_POST_VARS"]["i77_ultimolancamento"]:$this->i77_ultimolancamento);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){
      $this->atualizacampos();

     if($this->i77_inventario == null ){
       $this->erro_sql = " Campo Inventario nao Informado.";
       $this->erro_campo = "i77_inventario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->i77_estoque == null ){
       $this->erro_sql = " Campo CÃ³digo Estoque nao Informado.";
       $this->erro_campo = "i77_estoque";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($i77_sequencial == "" || $i77_sequencial == null ){
       $result = @pg_query("select nextval('inventariomaterial_i77_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: inventariomaterial_i77_sequencial_seq do campo: i77_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->i77_sequencial = pg_result($result,0,0);
     }

     if(empty($this->i77_valorinicial)) {
       $this->i77_valorinicial = "null";
     }

     $sql = "insert into inventariomaterial(
                                       i77_sequencial
                                      ,i77_inventario
                                      ,i77_estoque
                                      ,i77_db_depart
                                      ,i77_estoqueinicial
                                      ,i77_contagem
                                      ,i77_valorinicial
                                      ,i77_valormedio
                                      ,i77_vinculoinventario
                                      ,i77_datainclusao
                                      ,i77_dataprocessamento
                                      ,i77_ultimolancamento
                       )
                values (
                                $this->i77_sequencial
                               ,$this->i77_inventario
                               ,$this->i77_estoque
                               ,$this->i77_db_depart
                               ,$this->i77_estoqueinicial
                               ,$this->i77_contagem
                               ,$this->i77_valorinicial
                               ,$this->i77_valormedio
                               ,'$this->i77_vinculoinventario'
                               ,".($this->i77_datainclusao == "null" || $this->i77_datainclusao == ""?"null":"'".$this->i77_datainclusao."'")."
                               ,".($this->i77_dataprocessamento == "null" || $this->i77_dataprocessamento == ""?"null":"'".$this->i77_dataprocessamento."'")."
                               ,".($this->i77_ultimolancamento == "null" || $this->i77_ultimolancamento == ""?"null":"'".$this->i77_ultimolancamento."'")."
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Inventarios e materiais () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Inventarios e materiais já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Inventarios e materiais () nao Incluído. Inclusao Abortada.";
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
   function alterar ( $i77_sequencial=null ) {
      $this->atualizacampos();
     $sql = " update inventariomaterial set ";
     $virgula = "";
     if(trim($this->i77_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["i77_sequencial"])){
        if(trim($this->i77_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["i77_sequencial"])){
           $this->i77_sequencial = "0" ;
        }
       $sql  .= $virgula." i77_sequencial = $this->i77_sequencial ";
       $virgula = ",";
       if(trim($this->i77_sequencial) == null ){
         $this->erro_sql = " Campo Sequencia inventario material nao Informado.";
         $this->erro_campo = "i77_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->i77_inventario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["i77_inventario"])){
        if(trim($this->i77_inventario)=="" && isset($GLOBALS["HTTP_POST_VARS"]["i77_inventario"])){
           $this->i77_inventario = "0" ;
        }
       $sql  .= $virgula." i77_inventario = $this->i77_inventario ";
       $virgula = ",";
       if(trim($this->i77_inventario) == null ){
         $this->erro_sql = " Campo Inventario nao Informado.";
         $this->erro_campo = "i77_inventario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->i77_estoque)!="" || isset($GLOBALS["HTTP_POST_VARS"]["i77_estoque"])){
        if(trim($this->i77_estoque)=="" && isset($GLOBALS["HTTP_POST_VARS"]["i77_estoque"])){
           $this->i77_estoque = "0" ;
        }
       $sql  .= $virgula." i77_estoque = $this->i77_estoque ";
       $virgula = ",";
       if(trim($this->i77_estoque) == null ){
         $this->erro_sql = " Campo CÃ³digo Estoque nao Informado.";
         $this->erro_campo = "i77_estoque";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->i77_db_depart)!="" || isset($GLOBALS["HTTP_POST_VARS"]["i77_db_depart"])){
        if(trim($this->i77_db_depart)=="" && isset($GLOBALS["HTTP_POST_VARS"]["i77_db_depart"])){
           $this->i77_db_depart = "0" ;
        }
       $sql  .= $virgula." i77_db_depart = $this->i77_db_depart ";
       $virgula = ",";
     }
     if(trim($this->i77_estoqueinicial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["i77_estoqueinicial"])){
       $sql  .= $virgula." i77_estoqueinicial = $this->i77_estoqueinicial ";
       $virgula = ",";
     }
     if(trim($this->i77_contagem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["i77_contagem"])){
       $sql  .= $virgula." i77_contagem = $this->i77_contagem ";
       $virgula = ",";
     }
     if(trim($this->i77_valorinicial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["i77_valorinicial"])){
       $sql  .= $virgula." i77_valorinicial = $this->i77_valorinicial ";
       $virgula = ",";
     }
     if(trim($this->i77_valormedio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["i77_valormedio"])){
       $sql  .= $virgula." i77_valormedio = $this->i77_valormedio ";
       $virgula = ",";
     }
     if(trim($this->i77_vinculoinventario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["i77_vinculoinventario"])){
       $sql  .= $virgula." i77_vinculoinventario = '$this->i77_vinculoinventario' ";
       $virgula = ",";
     }
     if(trim($this->i77_datainclusao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["i77_datainclusao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["i77_datainclusao_dia"] !="") ){
       $sql  .= $virgula." i77_datainclusao = '$this->i77_datainclusao' ";
       $virgula = ",";
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["i77_datainclusao_dia"])){
         $sql  .= $virgula." i77_datainclusao = null ";
         $virgula = ",";
       }
     }
     if($this->i77_dataprocessamento == null){
       $sql  .= $virgula." i77_dataprocessamento = null ";
       $virgula = ",";
     }else{
       $sql  .= $virgula." i77_dataprocessamento = '$this->i77_dataprocessamento' ";
       $virgula = ",";
     }
     if(trim($this->i77_ultimolancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["i77_ultimolancamento"])){
        if(trim($this->i77_ultimolancamento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["i77_ultimolancamento"])){
           $this->i77_ultimolancamento = "0" ;
        }
       $sql  .= $virgula." i77_ultimolancamento = $this->i77_ultimolancamento ";
       $virgula = ",";
     }
     $sql .= " where i77_sequencial = $i77_sequencial ";
     // echo $sql;
     $result = @pg_exec($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Inventarios e materiais nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Inventarios e materiais nao foi Alterado. Alteracao Executada.\\n";
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
   function excluir ( $i77_sequencial=null ) {
     $this->atualizacampos(true);
     $sql = " delete from inventariomaterial
                    where ";
     $sql2 = "";
     $sql2 = "i77_sequencial = $i77_sequencial";
     $result = @pg_exec($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Inventarios e materiais nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Inventarios e materiais nao Encontrado. Exclusão não Efetuada.\\n";
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
   function sql_query ( $i77_sequencial = null,$campos="inventariomaterial.i77_sequencial,*",$ordem=null,$dbwhere=""){
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
     $sql .= " from inventariomaterial ";
     $sql .= "      INNER JOIN db_depart ON db_depart.coddepto = inventariomaterial.i77_db_depart
INNER JOIN matestoque ON matestoque.m70_codigo = inventariomaterial.i77_estoque
INNER JOIN inventario ON inventario.t75_sequencial = inventariomaterial.i77_inventario
INNER JOIN db_config ON db_config.codigo = db_depart.instit
INNER JOIN db_depart AS a ON a.coddepto = matestoque.m70_coddepto
INNER JOIN matmater ON matmater.m60_codmater = matestoque.m70_codmatmater
INNER JOIN db_depart AS c ON c.coddepto = inventario.t75_db_depart
";
     $sql2 = "";
     if($dbwhere==""){
       if( $i77_sequencial != "" && $i77_sequencial != null){
          $sql2 = " where inventariomaterial.i77_sequencial = $i77_sequencial";
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
   function sql_query_file ( $i77_sequencial = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from inventariomaterial ";
     $sql2 = "";
     if($dbwhere==""){
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
