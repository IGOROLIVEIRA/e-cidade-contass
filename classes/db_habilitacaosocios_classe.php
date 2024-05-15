<?
//MODULO: licitacao
//CLASSE DA ENTIDADE habilitacaosocios
class cl_habilitacaosocios { 
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
   var $l207_sequencial = 0; 
   var $l207_socio = 0; 
   var $l207_tipopart = 0; 
   var $l207_habilitacao = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 l207_sequencial = int4 = Sequencial 
                 l207_socio = int4 = Sócio 
                 l207_tipopart = int8 = Tipo participação 
                 l207_habilitacao = int8 = Habilitação 
                 ";
   //funcao construtor da classe 
   function cl_habilitacaosocios() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("habilitacaosocios"); 
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
       $this->l207_sequencial = ($this->l207_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l207_sequencial"]:$this->l207_sequencial);
       $this->l207_socio = ($this->l207_socio == ""?@$GLOBALS["HTTP_POST_VARS"]["l207_socio"]:$this->l207_socio);
       $this->l207_tipopart = ($this->l207_tipopart == ""?@$GLOBALS["HTTP_POST_VARS"]["l207_tipopart"]:$this->l207_tipopart);
       $this->l207_habilitacao = ($this->l207_habilitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l207_habilitacao"]:$this->l207_habilitacao);
     }else{
       $this->l207_sequencial = ($this->l207_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l207_sequencial"]:$this->l207_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($l207_sequencial){ 
      $this->atualizacampos();
     if($this->l207_socio == null ){ 
       $this->erro_sql = " Campo Sócio nao Informado.";
       $this->erro_campo = "l207_socio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l207_tipopart == null ){ 
       $this->erro_sql = " Campo Tipo participação nao Informado.";
       $this->erro_campo = "l207_tipopart";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l207_habilitacao == null ){ 
       $this->erro_sql = " Campo Habilitação nao Informado.";
       $this->erro_campo = "l207_habilitacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($l207_sequencial == "" || $l207_sequencial == null ){
       $result = db_query("select nextval('habilitacaosocios_l207_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: habilitacaosocios_l207_sequencial_seq do campo: l207_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->l207_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from habilitacaosocios_l207_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $l207_sequencial)){
         $this->erro_sql = " Campo l207_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->l207_sequencial = $l207_sequencial; 
       }
     }
     if(($this->l207_sequencial == null) || ($this->l207_sequencial == "") ){ 
       $this->erro_sql = " Campo l207_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into habilitacaosocios(
                                       l207_sequencial 
                                      ,l207_socio 
                                      ,l207_tipopart 
                                      ,l207_habilitacao 
                       )
                values (
                                $this->l207_sequencial 
                               ,$this->l207_socio 
                               ,$this->l207_tipopart 
                               ,$this->l207_habilitacao 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Socios ($this->l207_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Socios já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Socios ($this->l207_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l207_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->l207_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009496,'$this->l207_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010233,2009496,'','".AddSlashes(pg_result($resaco,0,'l207_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010233,2009494,'','".AddSlashes(pg_result($resaco,0,'l207_socio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010233,2009495,'','".AddSlashes(pg_result($resaco,0,'l207_tipopart'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010233,2009497,'','".AddSlashes(pg_result($resaco,0,'l207_habilitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($l207_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update habilitacaosocios set ";
     $virgula = "";
     if(trim($this->l207_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l207_sequencial"])){ 
       $sql  .= $virgula." l207_sequencial = $this->l207_sequencial ";
       $virgula = ",";
       if(trim($this->l207_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial nao Informado.";
         $this->erro_campo = "l207_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l207_socio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l207_socio"])){ 
       $sql  .= $virgula." l207_socio = $this->l207_socio ";
       $virgula = ",";
       if(trim($this->l207_socio) == null ){ 
         $this->erro_sql = " Campo Sócio nao Informado.";
         $this->erro_campo = "l207_socio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l207_tipopart)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l207_tipopart"])){ 
       $sql  .= $virgula." l207_tipopart = $this->l207_tipopart ";
       $virgula = ",";
       if(trim($this->l207_tipopart) == null ){ 
         $this->erro_sql = " Campo Tipo participação nao Informado.";
         $this->erro_campo = "l207_tipopart";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l207_habilitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l207_habilitacao"])){ 
       $sql  .= $virgula." l207_habilitacao = $this->l207_habilitacao ";
       $virgula = ",";
       if(trim($this->l207_habilitacao) == null ){ 
         $this->erro_sql = " Campo Habilitação nao Informado.";
         $this->erro_campo = "l207_habilitacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($l207_sequencial!=null){
       $sql .= " l207_sequencial = $this->l207_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->l207_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009496,'$this->l207_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l207_sequencial"]) || $this->l207_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010233,2009496,'".AddSlashes(pg_result($resaco,$conresaco,'l207_sequencial'))."','$this->l207_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l207_socio"]) || $this->l207_socio != "")
           $resac = db_query("insert into db_acount values($acount,2010233,2009494,'".AddSlashes(pg_result($resaco,$conresaco,'l207_socio'))."','$this->l207_socio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l207_tipopart"]) || $this->l207_tipopart != "")
           $resac = db_query("insert into db_acount values($acount,2010233,2009495,'".AddSlashes(pg_result($resaco,$conresaco,'l207_tipopart'))."','$this->l207_tipopart',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l207_habilitacao"]) || $this->l207_habilitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010233,2009497,'".AddSlashes(pg_result($resaco,$conresaco,'l207_habilitacao'))."','$this->l207_habilitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Socios nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->l207_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Socios nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->l207_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l207_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($l207_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($l207_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009496,'$l207_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010233,2009496,'','".AddSlashes(pg_result($resaco,$iresaco,'l207_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010233,2009494,'','".AddSlashes(pg_result($resaco,$iresaco,'l207_socio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010233,2009495,'','".AddSlashes(pg_result($resaco,$iresaco,'l207_tipopart'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010233,2009497,'','".AddSlashes(pg_result($resaco,$iresaco,'l207_habilitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from habilitacaosocios
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($l207_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " l207_sequencial = $l207_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Socios nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$l207_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Socios nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$l207_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$l207_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:habilitacaosocios";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $l207_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from habilitacaosocios ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = habilitacaosocios.l207_socio";
     $sql .= "      inner join habilitacaoforn  on  habilitacaoforn.l206_sequencial = habilitacaosocios.l207_habilitacao";
     $sql .= "      inner join pcforne  on  pcforne.pc60_numcgm = habilitacaoforn.l206_fornecedor";
     $sql2 = "";
     if($dbwhere==""){
       if($l207_sequencial!=null ){
         $sql2 .= " where habilitacaosocios.l207_sequencial = $l207_sequencial "; 
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
   function sql_query_file ( $l207_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from habilitacaosocios ";
     $sql .= "inner join cgm on habilitacaosocios.l207_socio = cgm.z01_numcgm";
     $sql2 = "";
     if($dbwhere==""){
       if($l207_sequencial!=null ){
         $sql2 .= " where habilitacaosocios.l207_sequencial = $l207_sequencial "; 
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
