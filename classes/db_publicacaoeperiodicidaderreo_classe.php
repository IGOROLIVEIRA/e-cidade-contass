<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE publicacaoeperiodicidaderreo
class cl_publicacaoeperiodicidaderreo {
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
   var $c220_dadoscomplementareslrf = 0;
   var $c220_publiclrf = 0;
   var $c220_dtpublicacaorelatoriolrf_dia = null;
   var $c220_dtpublicacaorelatoriolrf_mes = null;
   var $c220_dtpublicacaorelatoriolrf_ano = null;
   var $c220_dtpublicacaorelatoriolrf = null;
   var $c220_localpublicacao = null;
   var $c220_tpbimestre = 0;
   var $c220_exerciciotpbimestre = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 c220_dadoscomplementareslrf = int4 = Sequencial DCLRF
                 c220_publiclrf = int4 = Publicação do RREO da LRF
                 c220_dtpublicacaorelatoriolrf = date = Data da Publicação do RREO
                 c220_localpublicacao = text = Local da Publicação da RREO
                 c220_tpbimestre = int4 = Bimestre a que se refere a publicação do RREO
                 c220_exerciciotpbimestre = int4 = Exercício a que se refere o período
                 ";
   //funcao construtor da classe
   function cl_publicacaoeperiodicidaderreo() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("publicacaoeperiodicidaderreo");
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
       $this->c220_dadoscomplementareslrf = ($this->c220_dadoscomplementareslrf == ""?@$GLOBALS["HTTP_POST_VARS"]["c220_dadoscomplementareslrf"]:$this->c220_dadoscomplementareslrf);
       $this->c220_publiclrf = ($this->c220_publiclrf == ""?@$GLOBALS["HTTP_POST_VARS"]["c220_publiclrf"]:$this->c220_publiclrf);
       if($this->c220_dtpublicacaorelatoriolrf == ""){
         $this->c220_dtpublicacaorelatoriolrf_dia = @$GLOBALS["HTTP_POST_VARS"]["c220_dtpublicacaorelatoriolrf_dia"];
         $this->c220_dtpublicacaorelatoriolrf_mes = @$GLOBALS["HTTP_POST_VARS"]["c220_dtpublicacaorelatoriolrf_mes"];
         $this->c220_dtpublicacaorelatoriolrf_ano = @$GLOBALS["HTTP_POST_VARS"]["c220_dtpublicacaorelatoriolrf_ano"];
         if($this->c220_dtpublicacaorelatoriolrf_dia != ""){
            $this->c220_dtpublicacaorelatoriolrf = $this->c220_dtpublicacaorelatoriolrf_ano."-".$this->c220_dtpublicacaorelatoriolrf_mes."-".$this->c220_dtpublicacaorelatoriolrf_dia;
         }
       }
       $this->c220_localpublicacao = ($this->c220_localpublicacao == ""?@$GLOBALS["HTTP_POST_VARS"]["c220_localpublicacao"]:$this->c220_localpublicacao);
       $this->c220_tpbimestre = ($this->c220_tpbimestre == ""?@$GLOBALS["HTTP_POST_VARS"]["c220_tpbimestre"]:$this->c220_tpbimestre);
       $this->c220_exerciciotpbimestre = ($this->c220_exerciciotpbimestre == ""?@$GLOBALS["HTTP_POST_VARS"]["c220_exerciciotpbimestre"]:$this->c220_exerciciotpbimestre);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){
      $this->atualizacampos();
     if($this->c220_dadoscomplementareslrf == null ){
       $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
       $this->erro_campo = "c220_dadoscomplementareslrf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c220_publiclrf == null ){
       $this->erro_sql = " Campo Publicação do RREO da LRF nao Informado.";
       $this->erro_campo = "c220_publiclrf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->c220_tpbimestre == null ){
       $this->erro_sql = " Campo Bimestre a que se refere a publicação do RREO nao Informado.";
       $this->erro_campo = "c220_tpbimestre";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c220_exerciciotpbimestre == null || $this->c220_exerciciotpbimestre == ""){
      $this->c220_exerciciotpbimestre = 'null';
     }
     $sql = "insert into publicacaoeperiodicidaderreo(
                                       c220_dadoscomplementareslrf
                                      ,c220_publiclrf
                                      ,c220_dtpublicacaorelatoriolrf
                                      ,c220_localpublicacao
                                      ,c220_tpbimestre
                                      ,c220_exerciciotpbimestre
                       )
                values (
                                $this->c220_dadoscomplementareslrf
                               ,$this->c220_publiclrf
                               ,".($this->c220_dtpublicacaorelatoriolrf == "null" || $this->c220_dtpublicacaorelatoriolrf == ""?"null":"'".$this->c220_dtpublicacaorelatoriolrf."'")."
                               ,'$this->c220_localpublicacao'
                               ,$this->c220_tpbimestre
                               ,$this->c220_exerciciotpbimestre
                      )";

     $result = @pg_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Publicação e Periodicidade do RREO da LRF () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Publicação e Periodicidade do RREO da LRF já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Publicação e Periodicidade do RREO da LRF () nao Incluído. Inclusao Abortada.";
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
   function alterar ( $c220_dadoscomplementareslrf=null ) {
      $this->atualizacampos();
     $sql = " update publicacaoeperiodicidaderreo set ";
     $virgula = "";
     if(trim($this->c220_dadoscomplementareslrf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c220_dadoscomplementareslrf"])){
        if(trim($this->c220_dadoscomplementareslrf)=="" && isset($GLOBALS["HTTP_POST_VARS"]["c220_dadoscomplementareslrf"])){
           $this->c220_dadoscomplementareslrf = "0" ;
        }
       $sql  .= $virgula." c220_dadoscomplementareslrf = $this->c220_dadoscomplementareslrf ";
       $virgula = ",";
       if(trim($this->c220_dadoscomplementareslrf) == null ){
         $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
         $this->erro_campo = "c220_dadoscomplementareslrf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c220_publiclrf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c220_publiclrf"])){
        if(trim($this->c220_publiclrf)=="" && isset($GLOBALS["HTTP_POST_VARS"]["c220_publiclrf"])){
           $this->c220_publiclrf = "0" ;
        }
       $sql  .= $virgula." c220_publiclrf = $this->c220_publiclrf ";
       $virgula = ",";
       if(trim($this->c220_publiclrf) == null ){
         $this->erro_sql = " Campo Houve publicação do RREO nao Informado.";
         $this->erro_campo = "c220_publiclrf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c220_dtpublicacaorelatoriolrf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c220_dtpublicacaorelatoriolrf_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["c220_dtpublicacaorelatoriolrf_dia"] !="") ){
       $sql  .= $virgula." c220_dtpublicacaorelatoriolrf = '$this->c220_dtpublicacaorelatoriolrf' ";
       $virgula = ",";
       if(trim($this->c220_dtpublicacaorelatoriolrf) == null ){
         $this->erro_sql = " Campo Data da Publicação do RREO nao Informado.";
         $this->erro_campo = "c220_dtpublicacaorelatoriolrf_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["c220_dtpublicacaorelatoriolrf_dia"])){
         $sql  .= $virgula." c220_dtpublicacaorelatoriolrf = null ";
         $virgula = ",";
         if(trim($this->c220_dtpublicacaorelatoriolrf) == null ){
           $this->erro_sql = " Campo Data da Publicação do RREO nao Informado.";
           $this->erro_campo = "c220_dtpublicacaorelatoriolrf_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->c220_localpublicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c220_localpublicacao"])){
       $sql  .= $virgula." c220_localpublicacao = '$this->c220_localpublicacao' ";
       $virgula = ",";
       if(trim($this->c220_localpublicacao) == null ){
         $this->erro_sql = " Campo Local da Publicação da RREO nao Informado.";
         $this->erro_campo = "c220_localpublicacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c220_tpbimestre)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c220_tpbimestre"])){
        if(trim($this->c220_tpbimestre)=="" && isset($GLOBALS["HTTP_POST_VARS"]["c220_tpbimestre"])){
           $this->c220_tpbimestre = "0" ;
        }
       $sql  .= $virgula." c220_tpbimestre = $this->c220_tpbimestre ";
       $virgula = ",";
       if(trim($this->c220_tpbimestre) == null ){
         $this->erro_sql = " Campo Bimestre a que se refere a publicação do RREO nao Informado.";
         $this->erro_campo = "c220_tpbimestre";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c220_exerciciotpbimestre)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c220_exerciciotpbimestre"])){
        if(trim($this->c220_exerciciotpbimestre)=="" && isset($GLOBALS["HTTP_POST_VARS"]["c220_exerciciotpbimestre"])){
           $this->c220_exerciciotpbimestre = "0" ;
        }
       $sql  .= $virgula." c220_exerciciotpbimestre = $this->c220_exerciciotpbimestre ";
       $virgula = ",";
       if(trim($this->c220_exerciciotpbimestre) == null ){
         $this->erro_sql = " Campo Exercício a que se refere o período nao Informado.";
         $this->erro_campo = "c220_exerciciotpbimestre";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where c220_dadoscomplementareslrf = $c220_dadoscomplementareslrf ";
     $result = @pg_exec($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Publicação e Periodicidade do RREO da LRF nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Publicação e Periodicidade do RREO da LRF nao foi Alterado. Alteracao Executada.\\n";
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
   function excluir ( $c220_dadoscomplementareslrf=null ) {
     $this->atualizacampos(true);
     $sql = " delete from publicacaoeperiodicidaderreo
                    where ";
     $sql2 = "";
     $sql2 = "c220_dadoscomplementareslrf = $c220_dadoscomplementareslrf";
     $result = @pg_exec($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Publicação e Periodicidade do RREO da LRF nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Publicação e Periodicidade do RREO da LRF nao Encontrado. Exclusão não Efetuada.\\n";
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
   function sql_query ( $c220_dadoscomplementareslrf = null,$campos="publicacaoeperiodicidaderreo.c220_dadoscomplementareslrf,*",$ordem=null,$dbwhere=""){
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
     $sql .= " from publicacaoeperiodicidaderreo ";
     $sql2 = "";
     if($dbwhere==""){
       if( $c220_dadoscomplementareslrf != "" && $c220_dadoscomplementareslrf != null){
          $sql2 = " where publicacaoeperiodicidaderreo.c220_dadoscomplementareslrf = $c220_dadoscomplementareslrf";
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
   function sql_query_file ( $c220_dadoscomplementareslrf = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from publicacaoeperiodicidaderreo ";
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
