<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE conlancaminscrestosapagaremliquidacao
class cl_conlancaminscrestosapagaremliquidacao { 
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
   var $c210_sequencial = 0; 
   var $c210_codlan = 0; 
   var $c210_inscricaorestosapagaremliquidacao = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 c210_sequencial = int8 = Código 
                 c210_codlan = int8 = Código Lançamento 
                 c210_inscricaorestosapagaremliquidacao = int8 = Inscrição de Rp Em Liquidação 
                 ";
   //funcao construtor da classe 
   function cl_conlancaminscrestosapagaremliquidacao() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("conlancaminscrestosapagaremliquidacao"); 
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
       $this->c210_sequencial = ($this->c210_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c210_sequencial"]:$this->c210_sequencial);
       $this->c210_codlan = ($this->c210_codlan == ""?@$GLOBALS["HTTP_POST_VARS"]["c210_codlan"]:$this->c210_codlan);
       $this->c210_inscricaorestosapagaremliquidacao = ($this->c210_inscricaorestosapagaremliquidacao == ""?@$GLOBALS["HTTP_POST_VARS"]["c210_inscricaorestosapagaremliquidacao"]:$this->c210_inscricaorestosapagaremliquidacao);
     }else{
       $this->c210_sequencial = ($this->c210_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c210_sequencial"]:$this->c210_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($c210_sequencial){ 
      $this->atualizacampos();
     if($this->c210_codlan == null ){ 
       $this->erro_sql = " Campo Código Lançamento não informado.";
       $this->erro_campo = "c210_codlan";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c210_inscricaorestosapagaremliquidacao == null ){ 
       $this->erro_sql = " Campo Inscrição de Rp Em Liquidação não informado.";
       $this->erro_campo = "c210_inscricaorestosapagaremliquidacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
      if($c210_sequencial == "" || $c210_sequencial == null ){
       $result = db_query("select nextval('conlancaminscricaorestosapagaremliquidacao_c210_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: conlancaminscricaorestosapagaremliquidacao_c210_sequencial_seq do campo: c210_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->c210_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from conlancaminscricaorestosapagaremliquidacao_c210_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $c210_sequencial)){
         $this->erro_sql = " Campo c210_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->c210_sequencial = $c210_sequencial; 
       }
     }
     if(($this->c210_sequencial == null) || ($this->c210_sequencial == "") ){ 
       $this->erro_sql = " Campo c210_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into conlancaminscrestosapagaremliquidacao(
                                       c210_sequencial 
                                      ,c210_codlan 
                                      ,c210_inscricaorestosapagaremliquidacao 
                       )
                values (
                                $this->c210_sequencial 
                               ,$this->c210_codlan 
                               ,$this->c210_inscricaorestosapagaremliquidacao 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = " ($this->c210_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = " já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = " ($this->c210_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c210_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     // $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     // if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
     //   && ($lSessaoDesativarAccount === false))) {

     //   $resaco = $this->sql_record($this->sql_query_file($this->c210_sequencial  ));
     //   if(($resaco!=false)||($this->numrows!=0)){

     //     $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
     //     $acount = pg_result($resac,0,0);
     //     $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
     //     $resac = db_query("insert into db_acountkey values($acount,1009549,'$this->c210_sequencial','I')");
     //     $resac = db_query("insert into db_acount values($acount,1010228,1009549,'','".AddSlashes(pg_result($resaco,0,'c210_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     //     $resac = db_query("insert into db_acount values($acount,1010228,1009550,'','".AddSlashes(pg_result($resaco,0,'c210_codlan'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     //     $resac = db_query("insert into db_acount values($acount,1010228,1009552,'','".AddSlashes(pg_result($resaco,0,'c210_inscricaorestosapagaremliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     //   }
     // }
     return true;
   } 
   // funcao para alteracao
   function alterar ($c210_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update conlancaminscrestosapagaremliquidacao set ";
     $virgula = "";
     if(trim($this->c210_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c210_sequencial"])){ 
       $sql  .= $virgula." c210_sequencial = $this->c210_sequencial ";
       $virgula = ",";
       if(trim($this->c210_sequencial) == null ){ 
         $this->erro_sql = " Campo Código não informado.";
         $this->erro_campo = "c210_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c210_codlan)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c210_codlan"])){ 
       $sql  .= $virgula." c210_codlan = $this->c210_codlan ";
       $virgula = ",";
       if(trim($this->c210_codlan) == null ){ 
         $this->erro_sql = " Campo Código Lançamento não informado.";
         $this->erro_campo = "c210_codlan";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c210_inscricaorestosapagaremliquidacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c210_inscricaorestosapagaremliquidacao"])){ 
       $sql  .= $virgula." c210_inscricaorestosapagaremliquidacao = $this->c210_inscricaorestosapagaremliquidacao ";
       $virgula = ",";
       if(trim($this->c210_inscricaorestosapagaremliquidacao) == null ){ 
         $this->erro_sql = " Campo Inscrição de Rp Em Liquidação não informado.";
         $this->erro_campo = "c210_inscricaorestosapagaremliquidacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($c210_sequencial!=null){
       $sql .= " c210_sequencial = $this->c210_sequencial";
     }
     // $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     // if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
     //   && ($lSessaoDesativarAccount === false))) {

     //   $resaco = $this->sql_record($this->sql_query_file($this->c210_sequencial));
     //   if($this->numrows>0){

     //     for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

     //       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
     //       $acount = pg_result($resac,0,0);
     //       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
     //       $resac = db_query("insert into db_acountkey values($acount,1009549,'$this->c210_sequencial','A')");
     //       if(isset($GLOBALS["HTTP_POST_VARS"]["c210_sequencial"]) || $this->c210_sequencial != "")
     //         $resac = db_query("insert into db_acount values($acount,1010228,1009549,'".AddSlashes(pg_result($resaco,$conresaco,'c210_sequencial'))."','$this->c210_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     //       if(isset($GLOBALS["HTTP_POST_VARS"]["c210_codlan"]) || $this->c210_codlan != "")
     //         $resac = db_query("insert into db_acount values($acount,1010228,1009550,'".AddSlashes(pg_result($resaco,$conresaco,'c210_codlan'))."','$this->c210_codlan',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     //       if(isset($GLOBALS["HTTP_POST_VARS"]["c210_inscricaorestosapagaremliquidacao"]) || $this->c210_inscricaorestosapagaremliquidacao != "")
     //         $resac = db_query("insert into db_acount values($acount,1010228,1009552,'".AddSlashes(pg_result($resaco,$conresaco,'c210_inscricaorestosapagaremliquidacao'))."','$this->c210_inscricaorestosapagaremliquidacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     //     }
     //   }
     // }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c210_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c210_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c210_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($c210_sequencial=null,$dbwhere=null) { 

     // $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     // if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
     //   && ($lSessaoDesativarAccount === false))) {

     //   if ($dbwhere==null || $dbwhere=="") {

     //     $resaco = $this->sql_record($this->sql_query_file($c210_sequencial));
     //   } else { 
     //     $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     //   }
     //   if (($resaco != false) || ($this->numrows!=0)) {

     //     for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

     //       $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
     //       $acount = pg_result($resac,0,0);
     //       $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
     //       $resac  = db_query("insert into db_acountkey values($acount,1009549,'$c210_sequencial','E')");
     //       $resac  = db_query("insert into db_acount values($acount,1010228,1009549,'','".AddSlashes(pg_result($resaco,$iresaco,'c210_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     //       $resac  = db_query("insert into db_acount values($acount,1010228,1009550,'','".AddSlashes(pg_result($resaco,$iresaco,'c210_codlan'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     //       $resac  = db_query("insert into db_acount values($acount,1010228,1009552,'','".AddSlashes(pg_result($resaco,$iresaco,'c210_inscricaorestosapagaremliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     //     }
     //   }
     // }
     $sql = " delete from conlancaminscrestosapagaremliquidacao
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($c210_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " c210_sequencial = $c210_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c210_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c210_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c210_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:conlancaminscrestosapagaremliquidacao";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $c210_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from conlancaminscrestosapagaremliquidacao ";
     $sql .= "      inner join conlancam  on  conlancam.c70_codlan = conlancaminscrestosapagaremliquidacao.c210_codlan";
     $sql .= "      inner join inscricaorestosapagaremliquidacao  on  inscricaorestosapagaremliquidacao.c107_sequencial = conlancaminscrestosapagaremliquidacao.c210_inscricaorestosapagaremliquidacao";
     $sql .= "      inner join db_config  on  db_config.codigo = inscricaorestosapagaremliquidacao.c107_instit";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = inscricaorestosapagaremliquidacao.c107_usuario";
     $sql2 = "";
     if($dbwhere==""){
       if($c210_sequencial!=null ){
         $sql2 .= " where conlancaminscrestosapagaremliquidacao.c210_sequencial = $c210_sequencial "; 
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
   function sql_query_file ( $c210_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from conlancaminscrestosapagaremliquidacao ";
     $sql2 = "";
     if($dbwhere==""){
       if($c210_sequencial!=null ){
         $sql2 .= " where conlancaminscrestosapagaremliquidacao.c210_sequencial = $c210_sequencial "; 
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
