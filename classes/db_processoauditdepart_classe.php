<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

//MODULO: Controle Interno
//CLASSE DA ENTIDADE processoauditdepart

class cl_processoauditdepart {
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
  var $ci04_codproc = 0;
  var $ci04_depto = 0;

  // cria propriedade com as variaveis do arquivo
  var $campos = "
                ci04_codproc = int4 = Código do Processo
                ci04_depto = int4 = Código do Departamento
                ";

  //funcao construtor da classe
  function cl_processoauditdepart() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("processoauditdepart");
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
      $this->ci04_codproc = ($this->ci04_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["ci04_codproc"]:$this->ci04_codproc);
      $this->ci04_depto = ($this->ci04_depto == ""?@$GLOBALS["HTTP_POST_VARS"]["ci04_depto"]:$this->ci04_depto);
    }else{
      $this->ci04_codproc = ($this->ci04_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["ci04_codproc"]:$this->ci04_codproc);
    }
  }

  // funcao para inclusao
  function incluir (){
    $this->atualizacampos();
   if($this->ci04_codproc == null ){
     $this->erro_sql = " Campo Código do Processo nao Informado.";
     $this->erro_campo = "ci04_codproc";
     $this->erro_banco = "";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "0";
     return false;
   }
   if($this->ci04_depto == null ){
     $this->erro_sql = " Campo Código do Departamento nao Informado.";
     $this->erro_campo = "ci04_depto";
     $this->erro_banco = "";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "0";
     return false;
   }
   $sql = "insert into processoauditdepart(
                                     ci04_codproc
                                    ,ci04_depto
                     )
              values (
                              $this->ci04_codproc
                             ,$this->ci04_depto
                    )";
   $result = db_query($sql);
   if($result==false){
     $this->erro_banco = str_replace("\n","",@pg_last_error());
     if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
       $this->erro_sql   = "Processo de Auditoria Departamento ($this->ci04_codproc) nao Incluído. Inclusao Abortada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_banco = "Processo de Auditoria Departamento já Cadastrado";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     }else{
       $this->erro_sql   = "Processo de Auditoria Departamento ($this->ci04_codproc) nao Incluído. Inclusao Abortada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     }
     $this->erro_status = "0";
     $this->numrows_incluir= 0;
     return false;
   }
   $this->erro_banco = "";
   $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
       $this->erro_sql .= "Valores : ".$this->ci04_codproc;
   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
   $this->erro_status = "1";
   $this->numrows_incluir= pg_affected_rows($result);

   return true;
 }

 // funcao para alteracao
 function alterar ($ci04_codproc=null) {
  $this->atualizacampos();
 $sql = " update processoauditdepart set ";
 $virgula = "";
 if(trim($this->ci04_codproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci04_codproc"])){
   $sql  .= $virgula." ci04_codproc = $this->ci04_codproc ";
   $virgula = ",";
   if(trim($this->ci04_codproc) == null ){
     $this->erro_sql = " Campo Código do Processo nao Informado.";
     $this->erro_campo = "ci04_codproc";
     $this->erro_banco = "";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "0";
     return false;
   }
 }
 if(trim($this->ci04_depto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci04_depto"])){
   $sql  .= $virgula." ci04_depto = $this->ci04_depto ";
   $virgula = ",";
   if(trim($this->ci04_depto) == null ){
     $this->erro_sql = " Campo Código do Departamento nao Informado.";
     $this->erro_campo = "ci04_depto";
     $this->erro_banco = "";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "0";
     return false;
   }
 }
 $sql .= " where ";
 if($ci04_codproc!=null){
   $sql .= " ci04_codproc = $this->ci04_codproc";
 }
 $result = db_query($sql);
 if($result==false){
   $this->erro_banco = str_replace("\n","",@pg_last_error());
   $this->erro_sql   = "Processo de Auditoria Departamento nao Alterado. Alteracao Abortada.\\n";
     $this->erro_sql .= "Valores : ".$this->ci04_codproc;
   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
   $this->erro_status = "0";
   $this->numrows_alterar = 0;
   return false;
 }else{
   if(pg_affected_rows($result)==0){
     $this->erro_banco = "";
     $this->erro_sql = "Processo de Auditoria Departamento nao foi Alterado. Alteracao Executada.\\n";
     $this->erro_sql .= "Valores : ".$this->ci04_codproc;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_alterar = 0;
     return true;
   }else{
     $this->erro_banco = "";
     $this->erro_sql = "Alteração efetuada com Sucesso\\n";
     $this->erro_sql .= "Valores : ".$this->ci04_codproc;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_alterar = pg_affected_rows($result);
     return true;
   }
 }
}

   // funcao para exclusao
   function excluir ($ci04_codproc=null,$dbwhere=null) {

    $sql = " delete from processoauditdepart
                   where ";
    $sql2 = "";
    if($dbwhere==null || $dbwhere ==""){
       if($ci04_codproc != ""){
         if($sql2!=""){
           $sql2 .= " and ";
         }
         $sql2 .= " ci04_codproc = $ci04_codproc ";
       }
    }else{
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if($result==false){
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "Processo de Auditoria Departamento nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : ".$ci04_codproc;
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "Processo de Auditoria Departamento nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : ".$ci04_codproc;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$ci04_codproc;
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
     if ($result==false) {
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if ($this->numrows==0) {
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:processoauditdepart";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $ci04_codproc = null,$campos="*",$ordem=null,$dbwhere="") { 
     $sql = "select ";
     if ($campos != "*" ) {
       $campos_sql = explode("#", $campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     } else {
       $sql .= $campos;
     }
     $sql .= " from processoauditdepart ";
     $sql .= "    inner join db_depart on ci04_depto = coddepto ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $ci04_codproc != "" && $ci04_codproc != null) {
          $sql2 = " where processoauditdepart.ci04_codproc = '$ci04_codproc'";
       }
     } else if ($dbwhere != "") {
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if ($ordem != null ) {
       $sql .= " order by ";
       $campos_sql = explode("#", $ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
      }
    }
    return $sql;
  }

  // funcao do sql 
  function sql_query_file ( $ci04_codproc = null,$campos="*",$ordem=null,$dbwhere="") { 
     $sql = "select ";
     if ($campos != "*" ) {
       $campos_sql = explode("#", $campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     } else {
       $sql .= $campos;
     }
     $sql .= " from processoauditdepart ";
     $sql2 = "";
     if ($dbwhere=="") {
     } else if ($dbwhere != "") {
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if ($ordem != null ) {
       $sql .= " order by ";
       $campos_sql = explode("#", $ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
      }
    }
    return $sql;
  }
}
?>
