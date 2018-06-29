<?
//MODULO: sicom
//CLASSE DA ENTIDADE dclrf302018
class cl_dclrf302018 {
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
   var $si192_reg10 = 0;
   var $si192_publiclrf = 0;
   var $si192_dtpublicacaorelatoriolrf_dia = null;
   var $si192_dtpublicacaorelatoriolrf_mes = null;
   var $si192_dtpublicacaorelatoriolrf_ano = null;
   var $si192_dtpublicacaorelatoriolrf = null;
   var $si192_localpublicacao = null;
   var $si192_tpbimestre = 0;
   var $si192_exerciciotpbimestre = 0;
   var $si192_tiporegistro = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si192_reg10 = int4 = Sequencial DCLRF
                 si192_publiclrf = int4 = Publicação do RREO da LRF
                 si192_dtpublicacaorelatoriolrf = date = Data de publicação do RREO da LRF
                 si192_localpublicacao = text = Onde foi dada a publicidade do RREO
                 si192_tpbimestre = int4 = Bimestre a que se refere a data de publi
                 si192_exerciciotpbimestre = int4 = Exercício a que se refere o período
                 si192_tiporegistro = int4 = Tipo registro
                 ";
   //funcao construtor da classe
   function cl_dclrf302018() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dclrf302018");
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
       $this->si192_reg10 = ($this->si192_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si192_reg10"]:$this->si192_reg10);
       $this->si192_publiclrf = ($this->si192_publiclrf == ""?@$GLOBALS["HTTP_POST_VARS"]["si192_publiclrf"]:$this->si192_publiclrf);
       if($this->si192_dtpublicacaorelatoriolrf == ""){
         $this->si192_dtpublicacaorelatoriolrf_dia = @$GLOBALS["HTTP_POST_VARS"]["si192_dtpublicacaorelatoriolrf_dia"];
         $this->si192_dtpublicacaorelatoriolrf_mes = @$GLOBALS["HTTP_POST_VARS"]["si192_dtpublicacaorelatoriolrf_mes"];
         $this->si192_dtpublicacaorelatoriolrf_ano = @$GLOBALS["HTTP_POST_VARS"]["si192_dtpublicacaorelatoriolrf_ano"];
         if($this->si192_dtpublicacaorelatoriolrf_dia != ""){
            $this->si192_dtpublicacaorelatoriolrf = $this->si192_dtpublicacaorelatoriolrf_ano."-".$this->si192_dtpublicacaorelatoriolrf_mes."-".$this->si192_dtpublicacaorelatoriolrf_dia;
         }
       }
       $this->si192_localpublicacao = ($this->si192_localpublicacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si192_localpublicacao"]:$this->si192_localpublicacao);
       $this->si192_tpbimestre = ($this->si192_tpbimestre == ""?@$GLOBALS["HTTP_POST_VARS"]["si192_tpbimestre"]:$this->si192_tpbimestre);
       $this->si192_exerciciotpbimestre = ($this->si192_exerciciotpbimestre == ""?@$GLOBALS["HTTP_POST_VARS"]["si192_exerciciotpbimestre"]:$this->si192_exerciciotpbimestre);
       $this->si192_tiporegistro = ($this->si192_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si192_tiporegistro"]:$this->si192_tiporegistro);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){
      $this->atualizacampos();
     if($this->si192_reg10 == null ){
       $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
       $this->erro_campo = "si192_reg10";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si192_publiclrf == null ){
       $this->erro_sql = " Campo Publicação do RREO da LRF nao Informado.";
       $this->erro_campo = "si192_publiclrf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     /*if($this->si192_dtpublicacaorelatoriolrf == null ){
       $this->erro_sql = " Campo Data de publicação do RREO da LRF nao Informado.";
       $this->erro_campo = "si192_dtpublicacaorelatoriolrf_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
     }
     if($this->si192_localpublicacao == null ){
       $this->erro_sql = " Campo Onde foi dada a publicidade do RREO nao Informado.";
       $this->erro_campo = "si192_localpublicacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si192_tpbimestre == null ){
       $this->erro_sql = " Campo Bimestre a que se refere a data de publi nao Informado.";
       $this->erro_campo = "si192_tpbimestre";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si192_exerciciotpbimestre == null ){
       $this->erro_sql = " Campo Exercício a que se refere o período nao Informado.";
       $this->erro_campo = "si192_exerciciotpbimestre";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }*/
     if($this->si192_tiporegistro == null ){
       $this->erro_sql = " Campo Tipo registro nao Informado.";
       $this->erro_campo = "si192_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into dclrf302018(
                                       si192_reg10
                                      ,si192_publiclrf
                                      ,si192_dtpublicacaorelatoriolrf
                                      ,si192_localpublicacao
                                      ,si192_tpbimestre
                                      ,si192_exerciciotpbimestre
                                      ,si192_tiporegistro
                       )
                values (
                                $this->si192_reg10
                               ,$this->si192_publiclrf
                               ,".($this->si192_dtpublicacaorelatoriolrf == "null" || $this->si192_dtpublicacaorelatoriolrf == "" ? "null" : "'".$this->si192_dtpublicacaorelatoriolrf."'")."
                               ,".($this->si192_localpublicacao == "null" || $this->si192_localpublicacao == "" ? "null" : "'".$this->si192_localpublicacao."'")."
                               ,".($this->si192_tpbimestre == "null" || $this->si192_tpbimestre == "" ? "null" : $this->si192_tpbimestre)."
                               ,".($this->si192_exerciciotpbimestre == "null" || $this->si192_exerciciotpbimestre == "" ? "null" : $this->si192_exerciciotpbimestre)."
                               ,$this->si192_tiporegistro
                      )");
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
   function alterar ( $si192_reg10=null ) {
      $this->atualizacampos();
     $sql = " update dclrf302018 set ";
     $virgula = "";
     if(trim($this->si192_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si192_reg10"])){
        if(trim($this->si192_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si192_reg10"])){
           $this->si192_reg10 = "0" ;
        }
       $sql  .= $virgula." si192_reg10 = $this->si192_reg10 ";
       $virgula = ",";
       if(trim($this->si192_reg10) == null ){
         $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
         $this->erro_campo = "si192_reg10";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si192_publiclrf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si192_publiclrf"])){
        if(trim($this->si192_publiclrf)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si192_publiclrf"])){
           $this->si192_publiclrf = "0" ;
        }
       $sql  .= $virgula." si192_publiclrf = $this->si192_publiclrf ";
       $virgula = ",";
       if(trim($this->si192_publiclrf) == null ){
         $this->erro_sql = " Campo Publicação do RREO da LRF nao Informado.";
         $this->erro_campo = "si192_publiclrf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si192_dtpublicacaorelatoriolrf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si192_dtpublicacaorelatoriolrf_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si192_dtpublicacaorelatoriolrf_dia"] !="") ){
       $sql  .= $virgula." si192_dtpublicacaorelatoriolrf = '$this->si192_dtpublicacaorelatoriolrf' ";
       $virgula = ",";
       if(trim($this->si192_dtpublicacaorelatoriolrf) == null ){
         $this->erro_sql = " Campo Data de publicação do RREO da LRF nao Informado.";
         $this->erro_campo = "si192_dtpublicacaorelatoriolrf_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["si192_dtpublicacaorelatoriolrf_dia"])){
         $sql  .= $virgula." si192_dtpublicacaorelatoriolrf = null ";
         $virgula = ",";
         if(trim($this->si192_dtpublicacaorelatoriolrf) == null ){
           $this->erro_sql = " Campo Data de publicação do RREO da LRF nao Informado.";
           $this->erro_campo = "si192_dtpublicacaorelatoriolrf_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si192_localpublicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si192_localpublicacao"])){
       $sql  .= $virgula." si192_localpublicacao = '$this->si192_localpublicacao' ";
       $virgula = ",";
       if(trim($this->si192_localpublicacao) == null ){
         $this->erro_sql = " Campo Onde foi dada a publicidade do RREO nao Informado.";
         $this->erro_campo = "si192_localpublicacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si192_tpbimestre)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si192_tpbimestre"])){
        if(trim($this->si192_tpbimestre)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si192_tpbimestre"])){
           $this->si192_tpbimestre = "0" ;
        }
       $sql  .= $virgula." si192_tpbimestre = $this->si192_tpbimestre ";
       $virgula = ",";
       if(trim($this->si192_tpbimestre) == null ){
         $this->erro_sql = " Campo Bimestre a que se refere a data de publi nao Informado.";
         $this->erro_campo = "si192_tpbimestre";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si192_exerciciotpbimestre)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si192_exerciciotpbimestre"])){
        if(trim($this->si192_exerciciotpbimestre)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si192_exerciciotpbimestre"])){
           $this->si192_exerciciotpbimestre = "0" ;
        }
       $sql  .= $virgula." si192_exerciciotpbimestre = $this->si192_exerciciotpbimestre ";
       $virgula = ",";
       if(trim($this->si192_exerciciotpbimestre) == null ){
         $this->erro_sql = " Campo Exercício a que se refere o período nao Informado.";
         $this->erro_campo = "si192_exerciciotpbimestre";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si192_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si192_tiporegistro"])){
        if(trim($this->si192_tiporegistro)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si192_tiporegistro"])){
           $this->si192_tiporegistro = "0" ;
        }
       $sql  .= $virgula." si192_tiporegistro = $this->si192_tiporegistro ";
       $virgula = ",";
       if(trim($this->si192_tiporegistro) == null ){
         $this->erro_sql = " Campo Tipo registro nao Informado.";
         $this->erro_campo = "si192_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where si192_reg10 = $si192_reg10 ";
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
   function excluir ( $si192_reg10=null ) {
     $this->atualizacampos(true);
     $sql = " delete from dclrf302018
                    where ";
     $sql2 = "";
     $sql2 = "si192_reg10 = $si192_reg10";
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
   function sql_query ( $si192_reg10 = null,$campos="dclrf302018.si192_reg10,*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf302018 ";
     $sql2 = "";
     if($dbwhere==""){
       if( $si192_reg10 != "" && $si192_reg10 != null){
          $sql2 = " where dclrf302018.si192_reg10 = $si192_reg10";
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
   function sql_query_file ( $si192_reg10 = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf302018 ";
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
