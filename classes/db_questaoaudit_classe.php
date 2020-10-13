<?
//MODULO: Controle Interno
//CLASSE DA ENTIDADE questaoaudit
class cl_questaoaudit { 
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
   var $ci02_codquestao = 0; 
   var $ci02_codtipo = 0; 
   var $ci02_numquestao = 0; 
   var $ci02_questao = null; 
   var $ci02_inforeq = null; 
   var $ci02_fonteinfo = null; 
   var $ci02_procdetal = null; 
   var $ci02_objeto = null; 
   var $ci02_possivachadneg = null; 
   var $ci02_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 ci02_codquestao = int4 = Código 
                 ci02_codtipo = int4 = Tipo da Auditoria 
                 ci02_numquestao = int4 = Número da Questão 
                 ci02_questao = varchar(500) = Questão da Auditoria 
                 ci02_inforeq = varchar(500) = Informações Requeridas 
                 ci02_fonteinfo = varchar(500) = Fonte das Informações 
                 ci02_procdetal = varchar(500) = Procedimento Detalhado 
                 ci02_objeto = varchar(500) = Objetos 
                 ci02_possivachadneg = varchar(500) = Possíveis Achados Negativos 
                 ci02_instit = int4 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_questaoaudit() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("questaoaudit"); 
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
       $this->ci02_codquestao = ($this->ci02_codquestao == ""?@$GLOBALS["HTTP_POST_VARS"]["ci02_codquestao"]:$this->ci02_codquestao);
       $this->ci02_codtipo = ($this->ci02_codtipo == ""?@$GLOBALS["HTTP_POST_VARS"]["ci02_codtipo"]:$this->ci02_codtipo);
       $this->ci02_numquestao = ($this->ci02_numquestao == ""?@$GLOBALS["HTTP_POST_VARS"]["ci02_numquestao"]:$this->ci02_numquestao);
       $this->ci02_questao = ($this->ci02_questao == ""?@$GLOBALS["HTTP_POST_VARS"]["ci02_questao"]:$this->ci02_questao);
       $this->ci02_inforeq = ($this->ci02_inforeq == ""?@$GLOBALS["HTTP_POST_VARS"]["ci02_inforeq"]:$this->ci02_inforeq);
       $this->ci02_fonteinfo = ($this->ci02_fonteinfo == ""?@$GLOBALS["HTTP_POST_VARS"]["ci02_fonteinfo"]:$this->ci02_fonteinfo);
       $this->ci02_procdetal = ($this->ci02_procdetal == ""?@$GLOBALS["HTTP_POST_VARS"]["ci02_procdetal"]:$this->ci02_procdetal);
       $this->ci02_objeto = ($this->ci02_objeto == ""?@$GLOBALS["HTTP_POST_VARS"]["ci02_objeto"]:$this->ci02_objeto);
       $this->ci02_possivachadneg = ($this->ci02_possivachadneg == ""?@$GLOBALS["HTTP_POST_VARS"]["ci02_possivachadneg"]:$this->ci02_possivachadneg);
       $this->ci02_instit = ($this->ci02_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["ci02_instit"]:$this->ci02_instit);
     }else{
     }
   }
   // funcao para inclusao
   function incluir ($ci02_codquestao=null){ 
      $this->atualizacampos();
     if($ci02_codquestao == null || $ci02_codquestao == ""){ 
      $result = db_query("select nextval('contint_ci02_codquestao_seq')");
      if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Verifique o cadastro da sequencia: contint_ci02_codquestao_seq do campo: ci02_codquestao"; 
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false; 
     }
     $this->ci02_codquestao = pg_result($result,0,0); 
    }else{
     $result = db_query("select last_value from contint_ci02_codquestao_seq");
     if(($result != false) && (pg_result($result,0,0) < $ci02_codquestao)){
       $this->erro_sql = " Campo ci02_codquestao maior que último número da sequencia.";
       $this->erro_banco = "Sequencia menor que este número.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       $this->ci02_codquestao = $ci02_codquestao; 
     }
   }
     if($this->ci02_codtipo == null ){ 
       $this->erro_sql = " Campo Tipo da Auditoria nao Informado.";
       $this->erro_campo = "ci02_codtipo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ci02_numquestao == null ){ 
       $this->erro_sql = " Campo Número da Questão nao Informado.";
       $this->erro_campo = "ci02_numquestao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ci02_questao == null ){ 
       $this->erro_sql = " Campo Questão da Auditoria nao Informado.";
       $this->erro_campo = "ci02_questao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ci02_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "ci02_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into questaoaudit(
                                       ci02_codquestao 
                                      ,ci02_codtipo 
                                      ,ci02_numquestao 
                                      ,ci02_questao 
                                      ,ci02_inforeq 
                                      ,ci02_fonteinfo 
                                      ,ci02_procdetal 
                                      ,ci02_objeto 
                                      ,ci02_possivachadneg 
                                      ,ci02_instit 
                       )
                values (
                                $this->ci02_codquestao 
                               ,$this->ci02_codtipo 
                               ,$this->ci02_numquestao 
                               ,'$this->ci02_questao' 
                               ,'$this->ci02_inforeq' 
                               ,'$this->ci02_fonteinfo' 
                               ,'$this->ci02_procdetal' 
                               ,'$this->ci02_objeto' 
                               ,'$this->ci02_possivachadneg' 
                               ,$this->ci02_instit 
                      )";
                      
    $result = @pg_query($sql);                      
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Questão de Auditoria () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Questão de Auditoria já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Questão de Auditoria () nao Incluído. Inclusao Abortada.";
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
   function alterar ( $ci02_codquestao=null ) { 
      $this->atualizacampos();
     $sql = " update questaoaudit set ";
     $virgula = "";
     if(trim($this->ci02_codquestao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci02_codquestao"])){ 
        if(trim($this->ci02_codquestao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["ci02_codquestao"])){ 
           $this->ci02_codquestao = "0" ; 
        } 
       $sql  .= $virgula." ci02_codquestao = $this->ci02_codquestao ";
       $virgula = ",";
       if(trim($this->ci02_codquestao) == null ){ 
         $this->erro_sql = " Campo Código nao Informado.";
         $this->erro_campo = "ci02_codquestao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ci02_codtipo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci02_codtipo"])){ 
        if(trim($this->ci02_codtipo)=="" && isset($GLOBALS["HTTP_POST_VARS"]["ci02_codtipo"])){ 
           $this->ci02_codtipo = "0" ; 
        } 
       $sql  .= $virgula." ci02_codtipo = $this->ci02_codtipo ";
       $virgula = ",";
       if(trim($this->ci02_codtipo) == null ){ 
         $this->erro_sql = " Campo Tipo da Auditoria nao Informado.";
         $this->erro_campo = "ci02_codtipo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ci02_numquestao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci02_numquestao"])){ 

       $sql  .= $virgula." ci02_numquestao = $this->ci02_numquestao ";
       $virgula = ",";
       if(trim($this->ci02_numquestao) == null ){ 
         $this->erro_sql = " Campo Número da Questão nao Informado.";
         $this->erro_campo = "ci02_numquestao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ci02_questao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci02_questao"])){ 
       $sql  .= $virgula." ci02_questao = '$this->ci02_questao' ";
       $virgula = ",";
       if(trim($this->ci02_questao) == null ){ 
         $this->erro_sql = " Campo Questão da Auditoria nao Informado.";
         $this->erro_campo = "ci02_questao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ci02_inforeq)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci02_inforeq"])){ 
       $sql  .= $virgula." ci02_inforeq = '$this->ci02_inforeq' ";
       $virgula = ",";
     }
     if(trim($this->ci02_fonteinfo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci02_fonteinfo"])){ 
       $sql  .= $virgula." ci02_fonteinfo = '$this->ci02_fonteinfo' ";
       $virgula = ",";
     }
     if(trim($this->ci02_procdetal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci02_procdetal"])){ 
       $sql  .= $virgula." ci02_procdetal = '$this->ci02_procdetal' ";
       $virgula = ",";
     }
     if(trim($this->ci02_objeto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci02_objeto"])){ 
       $sql  .= $virgula." ci02_objeto = '$this->ci02_objeto' ";
       $virgula = ",";
     }
     if(trim($this->ci02_possivachadneg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci02_possivachadneg"])){ 
       $sql  .= $virgula." ci02_possivachadneg = '$this->ci02_possivachadneg' ";
       $virgula = ",";
     }
     if(trim($this->ci02_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci02_instit"])){ 
        if(trim($this->ci02_instit)=="" && isset($GLOBALS["HTTP_POST_VARS"]["ci02_instit"])){ 
           $this->ci02_instit = "0" ; 
        } 
       $sql  .= $virgula." ci02_instit = $this->ci02_instit ";
       $virgula = ",";
       if(trim($this->ci02_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "ci02_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ci02_codquestao = $ci02_codquestao ";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Questão de Auditoria nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Questão de Auditoria nao foi Alterado. Alteracao Executada.\\n";
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
   function excluir ( $ci02_codquestao=null, $dbwhere=null ) { 
     $this->atualizacampos(true);
     $sql = " delete from questaoaudit
                    where ";
     $sql2 = "";

     if($dbwhere==null || $dbwhere ==""){
       if($ci02_codquestao != ""){
         if($sql2!=""){
           $sql2 .= " and ";
          }
         $sql2 .= " ci02_codquestao = $ci02_codquestao ";
       }
     }else{
      $sql2 = $dbwhere;
     }
     
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Questão de Auditoria nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Questão de Auditoria nao Encontrado. Exclusão não Efetuada.\\n";
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
   function sql_query ( $ci02_codquestao = null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from questaoaudit ";
     $sql .= "    inner join tipoquestaoaudit on ci01_codtipo = ci02_codtipo ";
     $sql2 = "";
     if($dbwhere==""){
       if( $ci02_codquestao != "" && $ci02_codquestao != null){
          $sql2 = " where questaoaudit.ci02_codquestao = $ci02_codquestao";
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
   function sql_query_file ( $ci02_codquestao = null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from questaoaudit ";
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
