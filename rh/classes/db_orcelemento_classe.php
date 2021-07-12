<?
//MODULO: orcamento
//CLASSE DA ENTIDADE orcelemento
class cl_orcelemento {
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
   var $o56_codele = 0; 
   var $o56_elemento = null; 
   var $o56_descr = null; 
   var $o56_finali = null; 
   var $o56_orcado = 'f'; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 o56_codele = int4 = Código Elemento 
                 o56_elemento = varchar(13) = Elemento 
                 o56_descr = varchar(50) = Descrição do Elemento 
                 o56_finali = text = Finalidade 
                 o56_orcado = bool = Orçado 
                 ";
   //funcao construtor da classe 
   function cl_orcelemento() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("orcelemento"); 
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
       $this->o56_codele = ($this->o56_codele == ""?@$GLOBALS["HTTP_POST_VARS"]["o56_codele"]:$this->o56_codele);
       $this->o56_anousu= ($this->o56_anousu== ""?@$GLOBALS["HTTP_POST_VARS"]["o56_anousu"]:$this->o56_anousu);
       $this->o56_elemento = ($this->o56_elemento == ""?@$GLOBALS["HTTP_POST_VARS"]["o56_elemento"]:$this->o56_elemento);
       $this->o56_descr = ($this->o56_descr == ""?@$GLOBALS["HTTP_POST_VARS"]["o56_descr"]:$this->o56_descr);
       $this->o56_finali = ($this->o56_finali == ""?@$GLOBALS["HTTP_POST_VARS"]["o56_finali"]:$this->o56_finali);
       $this->o56_orcado = ($this->o56_orcado == "f"?@$GLOBALS["HTTP_POST_VARS"]["o56_orcado"]:$this->o56_orcado);
     }else{
       $this->o56_codele = ($this->o56_codele == ""?@$GLOBALS["HTTP_POST_VARS"]["o56_codele"]:$this->o56_codele);
       $this->o56_anousu= ($this->o56_anousu== ""?@$GLOBALS["HTTP_POST_VARS"]["o56_anousu"]:$this->o56_anousu);
     }
   }
   // funcao para inclusao
   function incluir ($o56_codele,$o56_anousu){ 
      $this->atualizacampos();
     if($this->o56_elemento == null ){ 
       $this->erro_sql = " Campo Elemento nao Informado.";
       $this->erro_campo = "o56_elemento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o56_descr == null ){ 
       $this->erro_sql = " Campo Descrição do Elemento nao Informado.";
       $this->erro_campo = "o56_descr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o56_orcado == null ){ 
       $this->erro_sql = " Campo Orçado nao Informado.";
       $this->erro_campo = "o56_orcado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->o56_codele = $o56_codele; 
     if(($this->o56_codele == null) || ($this->o56_codele == "") ){ 
       $this->erro_sql = " Campo o56_codele nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->o56_anousu = $o56_anousu; 
     if(($this->o56_anousu== null) || ($this->o56_anousu == "") ){ 
       $this->erro_sql = " Campo o56_anousu nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
     $sql = "insert into orcelemento(
                                       o56_codele 
                                      ,o56_anousu
                                      ,o56_elemento 
                                      ,o56_descr 
                                      ,o56_finali 
                                      ,o56_orcado 
                       )
                values (
                                $this->o56_codele 
							   ,$this->o56_anousu
                               ,'$this->o56_elemento' 
                               ,'$this->o56_descr' 
                               ,'$this->o56_finali' 
                               ,'$this->o56_orcado' 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Elementos da Despesa ($this->o56_codele) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Elementos da Despesa já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Elementos da Despesa ($this->o56_codele) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o56_codele;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->o56_codele));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,5356,'$this->o56_codele','I')");
       $resac = pg_query("insert into db_acount values($acount,753,5356,'','".AddSlashes(pg_result($resaco,0,'o56_codele'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,753,5357,'','".AddSlashes(pg_result($resaco,0,'o56_elemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,753,5358,'','".AddSlashes(pg_result($resaco,0,'o56_descr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,753,5359,'','".AddSlashes(pg_result($resaco,0,'o56_finali'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,753,5360,'','".AddSlashes(pg_result($resaco,0,'o56_orcado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($o56_codele=null,$o56_anousu=null) { 
      $this->atualizacampos();
     $sql = " update orcelemento set ";
     $virgula = "";
     if(trim($this->o56_codele)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o56_codele"])){ 
       $sql  .= $virgula." o56_codele = $this->o56_codele ";
       $virgula = ",";
       if(trim($this->o56_codele) == null ){ 
         $this->erro_sql = " Campo Código Elemento nao Informado.";
         $this->erro_campo = "o56_codele";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o56_elemento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o56_elemento"])){ 
       $sql  .= $virgula." o56_elemento = '$this->o56_elemento' ";
       $virgula = ",";
       if(trim($this->o56_elemento) == null ){ 
         $this->erro_sql = " Campo Elemento nao Informado.";
         $this->erro_campo = "o56_elemento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o56_descr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o56_descr"])){ 
       $sql  .= $virgula." o56_descr = '$this->o56_descr' ";
       $virgula = ",";
       if(trim($this->o56_descr) == null ){ 
         $this->erro_sql = " Campo Descrição do Elemento nao Informado.";
         $this->erro_campo = "o56_descr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o56_finali)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o56_finali"])){ 
       $sql  .= $virgula." o56_finali = '$this->o56_finali' ";
       $virgula = ",";
     }
     if(trim($this->o56_orcado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o56_orcado"])){ 
       $sql  .= $virgula." o56_orcado = '$this->o56_orcado' ";
       $virgula = ",";
       if(trim($this->o56_orcado) == null ){ 
         $this->erro_sql = " Campo Orçado nao Informado.";
         $this->erro_campo = "o56_orcado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($o56_codele!=null){
       $sql .= " o56_codele = $this->o56_codele  and o56_anousu = $this->o56_anousu";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->o56_codele));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5356,'$this->o56_codele','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o56_codele"]))
           $resac = pg_query("insert into db_acount values($acount,753,5356,'".AddSlashes(pg_result($resaco,$conresaco,'o56_codele'))."','$this->o56_codele',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o56_elemento"]))
           $resac = pg_query("insert into db_acount values($acount,753,5357,'".AddSlashes(pg_result($resaco,$conresaco,'o56_elemento'))."','$this->o56_elemento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o56_descr"]))
           $resac = pg_query("insert into db_acount values($acount,753,5358,'".AddSlashes(pg_result($resaco,$conresaco,'o56_descr'))."','$this->o56_descr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o56_finali"]))
           $resac = pg_query("insert into db_acount values($acount,753,5359,'".AddSlashes(pg_result($resaco,$conresaco,'o56_finali'))."','$this->o56_finali',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o56_orcado"]))
           $resac = pg_query("insert into db_acount values($acount,753,5360,'".AddSlashes(pg_result($resaco,$conresaco,'o56_orcado'))."','$this->o56_orcado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Elementos da Despesa nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->o56_codele;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Elementos da Despesa nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->o56_codele;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o56_codele;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($o56_codele=null, $o56_anousu=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($o56_codele,$o56_anousu));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,$o56_anousu,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5356,'$this->o56_codele','E')");
         $resac = pg_query("insert into db_acount values($acount,753,5356,'','".AddSlashes(pg_result($resaco,$iresaco,'o56_codele'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,753,5357,'','".AddSlashes(pg_result($resaco,$iresaco,'o56_elemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,753,5358,'','".AddSlashes(pg_result($resaco,$iresaco,'o56_descr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,753,5359,'','".AddSlashes(pg_result($resaco,$iresaco,'o56_finali'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,753,5360,'','".AddSlashes(pg_result($resaco,$iresaco,'o56_orcado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from orcelemento
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($o56_codele != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " o56_codele = $o56_codele  and  o56_anousu = $o56_anousu";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Elementos da Despesa nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$o56_codele;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Elementos da Despesa nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$o56_codele;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$o56_codele;
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
        $this->erro_sql   = "Record Vazio na Tabela:orcelemento";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query_pcmater ( $o56_codele=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcelemento ";
     $sql .= "    inner join pcmaterele on pc07_codele=o56_codele ";
     $sql .= "    inner join pcmater on pc01_codmater=pc07_codmater ";
     $sql2 = "";
     if($dbwhere==""){
       if($o56_codele!=null ){
         $sql2 .= " where orcelemento.o56_codele = $o56_codele "; 
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
   function sql_query_nov ( $o56_codele=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcelemento ";
     $sql .= "    inner join rhelementoemp on rhelementoemp.rh38_codele = orcelemento.o56_codele ";
     $sql2 = "";
     if($dbwhere==""){
       if($o56_codele!=null ){
         $sql2 .= " where orcelemento.o56_codele = $o56_codele "; 
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
   function sql_query_def ( $o56_codele=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcelemento ";
     $sql .= "    inner join rhrubelementoprinc on rhrubelementoprinc.rh24_codele = orcelemento.o56_codele ";
     $sql2 = "";
     if($dbwhere==""){
       if($o56_codele!=null ){
         $sql2 .= " where orcelemento.o56_codele = $o56_codele "; 
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
   function sql_query ( $o56_codele=null,$o56_anousu=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcelemento ";
     $sql2 = "";
     if($dbwhere==""){
       if($o56_codele!=null ){
           $sql2 .= " where orcelemento.o56_codele = $o56_codele ";
          if($o56_anousu!=null ){
          	 $sql2 .= "  and  orcelemento.o56_anousu= $o56_anousu ";
          }	
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
   function sql_query_file ( $o56_codele=null,$o56_anousu=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcelemento ";
     $sql2 = "";
     if($dbwhere==""){
       if($o56_codele!=null ){
          $sql2 .= " where orcelemento.o56_codele = $o56_codele ";
          if($o56_codele!=null ){
          	 $sql2 .= " and orcelemento.o56_anousu = $o56_anousu ";
          }	
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
   function db_verifica_elemento_exclusao($elemento,$o56_anousu=null){
   	 if ($o56_anousu==null){
   	 	 $o56_anousu= db_getsession("DB_anousu");
   	 }	
     $nivel = db_le_mae($elemento,true);
     $cod_mae = db_le_mae($elemento,false);
     if($nivel==9){
          return true;
     }
     if($nivel==8){
         $codigo = substr($elemento,0,11);
         $where="substr(o56_elemento,1,11)='$codigo' and substr(o56_elemento,12,2)<>'00' ";
    }
    if($nivel==7){
         $codigo = substr($elemento,0,7);
         $where="substr(o56_elemento,1,9)='$codigo' and substr(o56_elemento,10,4)<>'0000' ";
    }
    if($nivel==6){
        $codigo = substr($elemento,0,7);
        $where="substr(o56_elemento,1,7)='$codigo' and substr(o56_elemento,8,6)<>'000000' ";
    }
    if($nivel==5){
        $codigo = substr($elemento,0,5);
        $where="substr(o56_elemento,1,5)='$codigo' and substr(o56_elemento,6,8)<>'00000000' ";
    }
    if($nivel==4){
        $codigo = substr($elemento,0,4);
        $where="substr(o56_elemento,1,4)='$codigo' and substr(o56_elemento,5,9)<>'000000000' ";
    }
    if($nivel==3){
        $codigo = substr($elemento,0,3);
        $where="substr(o56_elemento,1,3)='$codigo' and substr(o56_elemento,4,10)<>'0000000000' ";
    }
    if($nivel==2){
        $codigo = substr($elemento,0,2);
        $where="substr(o56_elemento,1,2)='$codigo' and substr(o56_elemento,3,11)<>'00000000000' ";
     }
     if($nivel==1){
        $codigo = substr($elemento,0,1);
        $where="substr(o56_elemento,1,1)='$codigo' and substr(o56_elemento,2,11)<>'00000000000' ";
     }
     $result= $this->sql_record($this->sql_query_file("",$o56_anousu,"o56_elemento","",$where." and o56_anousu=$o56_anousu "));
     if($this->numrows>0){
        $this->erro_msg = 'Exclusão abortada. Existe uma conta de nível inferior cadastrada!';
        return false;
     }
     $this->erro_msg = 'Elemento com permissão de exclusão!';
      return true;
  }
  
  
   function db_verifica_elemento($elemento,$o56_anousu){
   	if ($o56_anousu==null){
   	 	 $o56_anousu= db_getsession("DB_anousu");
   	 }
    $nivel = db_le_mae($elemento,true);
    if($nivel == 1){
      return true;
    }
    $cod_mae = db_le_mae($elemento,false);
    $this->sql_record($this->sql_query_file("","","o56_elemento","","o56_elemento='$cod_mae' and o56_anousu=$o56_anousu"));
    if($this->numrows<1){
      $this->erro_msg = 'Inclusão abortada. Elemento acima não encontrado!';
      return false;
    }
   if($nivel==9){
      return true;
    }
    if($nivel==8){
      $codigo = substr($elemento,0,9)."00";
      $where="substr(o56_elemento,1,11)='$codigo' and substr(o56_elemento,12,2)<>'00' ";
    }
    if($nivel==7){
      $codigo = substr($elemento,0,7)."00";
      $where="substr(o56_elemento,1,9)='$codigo' and substr(o56_elemento,10,4)<>'0000' ";
    }
    if($nivel==6){
      $codigo = substr($elemento,0,5)."00";
      $where="substr(o56_elemento,1,7)='$codigo' and substr(o56_elemento,8,6)<>'000000' ";
    }
    if($nivel==5){
         $codigo = substr($elemento,0,4)."0";
         $where="substr(o56_elemento,1,5)='$codigo' and substr(o56_elemento,6,8)<>'00000000' ";
    }
    if($nivel==4){
         $codigo = substr($elemento,0,3)."0";
         $where="substr(o56_elemento,1,4)='$codigo' and substr(o56_elemento,5,9)<>'000000000' ";
    }
    if($nivel==3){
         $codigo = substr($elemento,0,2)."0";
         $where="substr(o56_elemento,1,3)='$codigo' and substr(o56_elemento,4,10)<>'0000000000' ";
    }
    if($nivel==2){
         $codigo = substr($elemento,0,1)."0";
         $where="substr(o56_elemento,1,2)='$codigo' and substr(o56_elemento,3,11)<>'00000000000' ";
    }
    $result= $this->sql_record($this->sql_query_file("","","o56_elemento","",$where." and o56_anousu=$o56_anousu  "));
    if($this->numrows>0){
         $this->erro_msg = 'Inclusão abortada. Existe uma conta de nível inferior cadastrada!';
         return false;
    }
    $this->erro_msg = 'Elemento válido!';
    return true;
  }
   //--- usada no relatorio de razao por despesa
 function sql_query_razao($o56_codele=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from conlancamdot ";
     $sql .= "    inner join orcdotacao on o58_coddot=c73_coddot and o58_anousu=c73_anousu ";
     $sql .= "    inner join orcelemento on o56_codele = orcdotacao.o58_codele   and   o56_anousu = orcdotacao.o58_anousu  ";

    // $sql .= " from orcelemento ";
    // $sql .= "   inner join orcdotacao on o56_codele = o58_codele ";
    // $sql .= "   inner join conlancamdot on c73_coddot = o58_coddot and c73_anousu = o58_anousu ";
    // $sql .= "   inner join conlancam on conlancam.c70_codlan = conlancamdot.c73_codlan and conlancam.c70_anousu=conlancam

     $sql2 = "";
     if($dbwhere==""){
       if($o56_codele!=null ){
         $sql2 .= " where orcelemento.o56_codele = $o56_codele ";
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