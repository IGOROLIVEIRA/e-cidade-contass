<?
//MODULO: pessoal
//CLASSE DA ENTIDADE baserubricasesocial
class cl_baserubricasesocial {
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
   var $e991_sequencial = 0;
   var $e991_rubricasesocial = 0;
   var $e991_rubricas = 0;
   var $e991_instit = null;
   // cria propriedade com as variaveis do arquivo
   var $campos = "

                 e991_rubricasesocial = int4 = Sequencial do rubricasesocial
                 e991_rubricas = int4 = Sequencial do rubricas
                 e991_instit = text = Instituicao
                 ";
   //funcao construtor da classe
   function cl_baserubricasesocial() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("baserubricasesocial");
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
       $this->e991_rubricasesocial = ($this->e991_rubricasesocial == ""?@$GLOBALS["HTTP_POST_VARS"]["e991_rubricasesocial"]:$this->e991_rubricasesocial);
       $this->e991_rubricas = ($this->e991_rubricas == ""?@$GLOBALS["HTTP_POST_VARS"]["e991_rubricas"]:$this->e991_rubricas);
       $this->e991_instit = ($this->e991_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["e991_instit"]:$this->e991_instit);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){
      $this->atualizacampos();

     if($this->e991_rubricasesocial == null ){
       $this->erro_sql = " Campo Sequencial do rubricasesocial nao Informado.";
       $this->erro_campo = "e991_rubricasesocial";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e991_rubricas == null ){
       $this->erro_sql = " Campo Sequencial do rubricas nao Informado.";
       $this->erro_campo = "e991_rubricas";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->e991_instit == null ){
       $this->erro_sql = " Campo Instituicao nao Informado.";
       $this->erro_campo = "e991_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     $result = @pg_query("insert into baserubricasesocial(
                                      e991_rubricasesocial
                                      ,e991_rubricas
                                      ,e991_instit
                       )
                values (       '$this->e991_rubricasesocial'
                               ,'$this->e991_rubricas'
                               ,'$this->e991_instit'
                      )");
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Bases das rúbricas do E-Social () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Bases das rúbricas do E-Social já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Bases das rúbricas do E-Social () nao Incluído. Inclusao Abortada.";
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
   // funcao para exclusao
   function excluir($e991_rubricas=null, $e991_rubricasesocial=null, $e991_instit=null, $basesManter=null) {
     $this->atualizacampos(true);
     $sql = " delete from baserubricasesocial
                    where ";
     $sql2 = "";
     $sql2 = "e991_rubricas = '$e991_rubricas'";
     if($e991_rubricasesocial!=null){
      if($e991_rubricas!=null){
        $sql2 .= " and e991_rubricasesocial = '$e991_rubricasesocial'";
      }else{
        $sql2 = "e991_rubricasesocial = '$e991_rubricasesocial'";
      }
     }
     if($e991_instit!=null){
        $sql2 .= " and e991_instit = '$e991_instit'";
     }
     if($basesManter!=null){
        $sql2 .= " and e991_rubricasesocial not in (".implode(",",$basesManter).")";
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Bases das rúbricas do E-Social nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Bases das rúbricas do E-Social nao Encontrado. Exclusão não Efetuada.\\n";
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

    // funcao para exclusao
    function excluir_novo($e991_rubricas=null, $e991_rubricasesocial=null, $e991_instit=null) {
        $this->atualizacampos(true);
        $sql = " delete from baserubricasesocial
                    where ";
        $sql2 = "";
        $sql2 = "e991_rubricas = '$e991_rubricas'";
        if($e991_rubricasesocial!=null){
            if($e991_rubricas!=null){
                $sql2 .= " and e991_rubricasesocial <> '$e991_rubricasesocial'";
            }else{
                $sql2 = "e991_rubricasesocial <> '$e991_rubricasesocial'";
            }
        }
        if($e991_instit!=null){
            $sql2 .= " and e991_instit = '$e991_instit'";
        }
        $result = @pg_exec($sql.$sql2);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Bases das rúbricas do E-Social nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Bases das rúbricas do E-Social nao Encontrado. Exclusão não Efetuada.\\n";
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
   function sql_query ( $e991_sequencial = null,$campos="baserubricasesocial.e991_sequencial,*",$ordem=null,$dbwhere=""){
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
     $sql .= " from baserubricasesocial ";
     $sql .= "      inner join rhrubricas  on  rhrubricas.rh27_rubric = baserubricasesocial.e991_rubricas";
     $sql .= "      inner join rubricasesocial  on  rubricasesocial.e990_sequencial = baserubricasesocial.e991_rubricasesocial";
     $sql .= "      inner join db_config  on  db_config.codigo = rhrubricas.rh27_instit";
     $sql2 = "";
     if($dbwhere==""){
       if( $this->e991_sequencial != "" && $this->e991_sequencial != null){
          $sql2 = " where baserubricasesocial.e991_sequencial = $this->e991_sequencial";
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
   function sql_query_file ( $e991_sequencial = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from baserubricasesocial ";
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
