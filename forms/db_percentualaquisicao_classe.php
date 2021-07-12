<?
//MODULO: sicom
//CLASSE DA ENTIDADE percentualaquisicao
class cl_percentualaquisicao { 
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
   var $si90_sequencial = 0; 
   var $si90_contemplaperc = 0; 
   var $si90_percentualestabelecido = 0; 
   var $si90_anoreferencia = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si90_sequencial = int8 = Código Sequencial 
                 si90_contemplaperc = int8 = Contempla Percentual 
                 si90_percentualestabelecido = int8 = Percentual estabelecido 
                 si90_anoreferencia = int8 = Ano de Referência 
                 ";
   //funcao construtor da classe 
   function cl_percentualaquisicao() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("percentualaquisicao"); 
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
       $this->si90_sequencial = ($this->si90_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si90_sequencial"]:$this->si90_sequencial);
       $this->si90_contemplaperc = ($this->si90_contemplaperc == ""?@$GLOBALS["HTTP_POST_VARS"]["si90_contemplaperc"]:$this->si90_contemplaperc);
       $this->si90_percentualestabelecido = ($this->si90_percentualestabelecido == ""?@$GLOBALS["HTTP_POST_VARS"]["si90_percentualestabelecido"]:$this->si90_percentualestabelecido);
       $this->si90_anoreferencia = ($this->si90_anoreferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si90_anoreferencia"]:$this->si90_anoreferencia);
     }else{
       $this->si90_sequencial = ($this->si90_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si90_sequencial"]:$this->si90_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si90_sequencial){ 
      $this->atualizacampos();
     if($this->si90_contemplaperc == null ){ 
       $this->erro_sql = " Campo Contempla Percentual nao Informado.";
       $this->erro_campo = "si90_contemplaperc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si90_percentualestabelecido == null ){ 
       $this->erro_sql = " Campo Percentual estabelecido nao Informado.";
       $this->erro_campo = "si90_percentualestabelecido";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si90_anoreferencia == null ){ 
       $this->erro_sql = " Campo Ano de Referência nao Informado.";
       $this->erro_campo = "si90_anoreferencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si90_sequencial == "" || $si90_sequencial == null ){
       $result = db_query("select nextval('percentualaquisicao_si90_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: percentualaquisicao_si90_sequencial_seq do campo: si90_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si90_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from percentualaquisicao_si90_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si90_sequencial)){
         $this->erro_sql = " Campo si90_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si90_sequencial = $si90_sequencial; 
       }
     }
     if(($this->si90_sequencial == null) || ($this->si90_sequencial == "") ){ 
       $this->erro_sql = " Campo si90_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into percentualaquisicao(
                                       si90_sequencial 
                                      ,si90_contemplaperc 
                                      ,si90_percentualestabelecido 
                                      ,si90_anoreferencia 
                       )
                values (
                                $this->si90_sequencial 
                               ,$this->si90_contemplaperc 
                               ,$this->si90_percentualestabelecido 
                               ,$this->si90_anoreferencia 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Percentual Aquisicao bens e servicos ($this->si90_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Percentual Aquisicao bens e servicos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Percentual Aquisicao bens e servicos ($this->si90_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si90_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si90_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010505,'$this->si90_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010321,2010505,'','".AddSlashes(pg_result($resaco,0,'si90_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010321,2010508,'','".AddSlashes(pg_result($resaco,0,'si90_contemplaperc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010321,2010510,'','".AddSlashes(pg_result($resaco,0,'si90_percentualestabelecido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010321,2010511,'','".AddSlashes(pg_result($resaco,0,'si90_anoreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si90_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update percentualaquisicao set ";
     $virgula = "";
     if(trim($this->si90_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si90_sequencial"])){ 
       $sql  .= $virgula." si90_sequencial = $this->si90_sequencial ";
       $virgula = ",";
       if(trim($this->si90_sequencial) == null ){ 
         $this->erro_sql = " Campo Código Sequencial nao Informado.";
         $this->erro_campo = "si90_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si90_contemplaperc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si90_contemplaperc"])){ 
       $sql  .= $virgula." si90_contemplaperc = $this->si90_contemplaperc ";
       $virgula = ",";
       if(trim($this->si90_contemplaperc) == null ){ 
         $this->erro_sql = " Campo Contempla Percentual nao Informado.";
         $this->erro_campo = "si90_contemplaperc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si90_percentualestabelecido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si90_percentualestabelecido"])){ 
       $sql  .= $virgula." si90_percentualestabelecido = $this->si90_percentualestabelecido ";
       $virgula = ",";
       if(trim($this->si90_percentualestabelecido) == null ){ 
         $this->erro_sql = " Campo Percentual estabelecido nao Informado.";
         $this->erro_campo = "si90_percentualestabelecido";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si90_anoreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si90_anoreferencia"])){ 
       $sql  .= $virgula." si90_anoreferencia = $this->si90_anoreferencia ";
       $virgula = ",";
       if(trim($this->si90_anoreferencia) == null ){ 
         $this->erro_sql = " Campo Ano de Referência nao Informado.";
         $this->erro_campo = "si90_anoreferencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si90_sequencial!=null){
       $sql .= " si90_sequencial = $this->si90_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si90_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010505,'$this->si90_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si90_sequencial"]) || $this->si90_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010321,2010505,'".AddSlashes(pg_result($resaco,$conresaco,'si90_sequencial'))."','$this->si90_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si90_contemplaperc"]) || $this->si90_contemplaperc != "")
           $resac = db_query("insert into db_acount values($acount,2010321,2010508,'".AddSlashes(pg_result($resaco,$conresaco,'si90_contemplaperc'))."','$this->si90_contemplaperc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si90_percentualestabelecido"]) || $this->si90_percentualestabelecido != "")
           $resac = db_query("insert into db_acount values($acount,2010321,2010510,'".AddSlashes(pg_result($resaco,$conresaco,'si90_percentualestabelecido'))."','$this->si90_percentualestabelecido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si90_anoreferencia"]) || $this->si90_anoreferencia != "")
           $resac = db_query("insert into db_acount values($acount,2010321,2010511,'".AddSlashes(pg_result($resaco,$conresaco,'si90_anoreferencia'))."','$this->si90_anoreferencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Percentual Aquisicao bens e servicos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si90_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Percentual Aquisicao bens e servicos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si90_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si90_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si90_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si90_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010505,'$si90_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010321,2010505,'','".AddSlashes(pg_result($resaco,$iresaco,'si90_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010321,2010508,'','".AddSlashes(pg_result($resaco,$iresaco,'si90_contemplaperc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010321,2010510,'','".AddSlashes(pg_result($resaco,$iresaco,'si90_percentualestabelecido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010321,2010511,'','".AddSlashes(pg_result($resaco,$iresaco,'si90_anoreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from percentualaquisicao
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si90_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si90_sequencial = $si90_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Percentual Aquisicao bens e servicos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si90_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Percentual Aquisicao bens e servicos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si90_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si90_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:percentualaquisicao";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si90_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from percentualaquisicao ";
     $sql2 = "";
     if($dbwhere==""){
       if($si90_sequencial!=null ){
         $sql2 .= " where percentualaquisicao.si90_sequencial = $si90_sequencial "; 
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
   function sql_query_file ( $si90_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from percentualaquisicao ";
     $sql2 = "";
     if($dbwhere==""){
       if($si90_sequencial!=null ){
         $sql2 .= " where percentualaquisicao.si90_sequencial = $si90_sequencial "; 
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
