<?
//MODULO: compras
//CLASSE DA ENTIDADE pcmaterele
class cl_pcmaterele { 
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
   var $pc07_codmater = 0; 
   var $pc07_codele = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 pc07_codmater = int4 = C�digo do Material 
                 pc07_codele = int4 = C�digo Elemento 
                 ";
   //funcao construtor da classe 
   function cl_pcmaterele() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("pcmaterele"); 
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
       $this->pc07_codmater = ($this->pc07_codmater == ""?@$GLOBALS["HTTP_POST_VARS"]["pc07_codmater"]:$this->pc07_codmater);
       $this->pc07_codele = ($this->pc07_codele == ""?@$GLOBALS["HTTP_POST_VARS"]["pc07_codele"]:$this->pc07_codele);
     }else{
       $this->pc07_codmater = ($this->pc07_codmater == ""?@$GLOBALS["HTTP_POST_VARS"]["pc07_codmater"]:$this->pc07_codmater);
       $this->pc07_codele = ($this->pc07_codele == ""?@$GLOBALS["HTTP_POST_VARS"]["pc07_codele"]:$this->pc07_codele);
     }
   }
   // funcao para inclusao
   function incluir ($pc07_codmater,$pc07_codele){ 
      $this->atualizacampos();
       $this->pc07_codmater = $pc07_codmater; 
       $this->pc07_codele = $pc07_codele; 
     if(($this->pc07_codmater == null) || ($this->pc07_codmater == "") ){ 
       $this->erro_sql = " Campo pc07_codmater nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->pc07_codele == null) || ($this->pc07_codele == "") ){ 
       $this->erro_sql = " Campo pc07_codele nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into pcmaterele(
                                       pc07_codmater 
                                      ,pc07_codele 
                       )
                values (
                                $this->pc07_codmater 
                               ,$this->pc07_codele 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Materiais com seus elementos ($this->pc07_codmater."-".$this->pc07_codele) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Materiais com seus elementos j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Materiais com seus elementos ($this->pc07_codmater."-".$this->pc07_codele) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->pc07_codmater."-".$this->pc07_codele;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->pc07_codmater,$this->pc07_codele));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,6162,'$this->pc07_codmater','I')");
       $resac = pg_query("insert into db_acountkey values($acount,6163,'$this->pc07_codele','I')");
       $resac = pg_query("insert into db_acount values($acount,993,6162,'','".AddSlashes(pg_result($resaco,0,'pc07_codmater'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,993,6163,'','".AddSlashes(pg_result($resaco,0,'pc07_codele'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($pc07_codmater=null,$pc07_codele=null) { 
      $this->atualizacampos();
     $sql = " update pcmaterele set ";
     $virgula = "";
     if(trim($this->pc07_codmater)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc07_codmater"])){ 
       $sql  .= $virgula." pc07_codmater = $this->pc07_codmater ";
       $virgula = ",";
       if(trim($this->pc07_codmater) == null ){ 
         $this->erro_sql = " Campo C�digo do Material nao Informado.";
         $this->erro_campo = "pc07_codmater";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->pc07_codele)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc07_codele"])){ 
       $sql  .= $virgula." pc07_codele = $this->pc07_codele ";
       $virgula = ",";
       if(trim($this->pc07_codele) == null ){ 
         $this->erro_sql = " Campo C�digo Elemento nao Informado.";
         $this->erro_campo = "pc07_codele";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($pc07_codmater!=null){
       $sql .= " pc07_codmater = $this->pc07_codmater";
     }
     if($pc07_codele!=null){
       $sql .= " and  pc07_codele = $this->pc07_codele";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->pc07_codmater,$this->pc07_codele));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,6162,'$this->pc07_codmater','A')");
         $resac = pg_query("insert into db_acountkey values($acount,6163,'$this->pc07_codele','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["pc07_codmater"]))
           $resac = pg_query("insert into db_acount values($acount,993,6162,'".AddSlashes(pg_result($resaco,$conresaco,'pc07_codmater'))."','$this->pc07_codmater',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["pc07_codele"]))
           $resac = pg_query("insert into db_acount values($acount,993,6163,'".AddSlashes(pg_result($resaco,$conresaco,'pc07_codele'))."','$this->pc07_codele',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Materiais com seus elementos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc07_codmater."-".$this->pc07_codele;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Materiais com seus elementos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc07_codmater."-".$this->pc07_codele;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->pc07_codmater."-".$this->pc07_codele;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($pc07_codmater=null,$pc07_codele=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($pc07_codmater,$pc07_codele));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,6162,'$this->pc07_codmater','E')");
         $resac = pg_query("insert into db_acountkey values($acount,6163,'$this->pc07_codele','E')");
         $resac = pg_query("insert into db_acount values($acount,993,6162,'','".AddSlashes(pg_result($resaco,$iresaco,'pc07_codmater'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,993,6163,'','".AddSlashes(pg_result($resaco,$iresaco,'pc07_codele'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from pcmaterele
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($pc07_codmater != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " pc07_codmater = $pc07_codmater ";
        }
        if($pc07_codele != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " pc07_codele = $pc07_codele ";
        }
     }else{
       $sql2 = $dbwhere;
     }
//     die($sql.$sql2);
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Materiais com seus elementos nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$pc07_codmater."-".$pc07_codele;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Materiais com seus elementos nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$pc07_codmater."-".$pc07_codele;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$pc07_codmater."-".$pc07_codele;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
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
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:pcmaterele";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $pc07_codmater=null,$pc07_codele=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from pcmaterele ";
     $sql .= "      inner join orcelemento  on  orcelemento.o56_codele = pcmaterele.pc07_codele";
     $sql .= "      inner join pcmater  on  pcmater.pc01_codmater = pcmaterele.pc07_codmater and pc01_ativo is false and pc01_conversao is false ";
     $sql .= "      inner join pcsubgrupo  on  pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo";
     $sql2 = "";
     if($dbwhere==""){
       if($pc07_codmater!=null ){
         $sql2 .= " where pcmaterele.pc07_codmater = $pc07_codmater "; 
       } 
       if($pc07_codele!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " pcmaterele.pc07_codele = $pc07_codele "; 
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
   function sql_query_file ( $pc07_codmater=null,$pc07_codele=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from pcmaterele ";
     $sql2 = "";
     if($dbwhere==""){
       if($pc07_codmater!=null ){
         $sql2 .= " where pcmaterele.pc07_codmater = $pc07_codmater "; 
       } 
       if($pc07_codele!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " pcmaterele.pc07_codele = $pc07_codele "; 
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
