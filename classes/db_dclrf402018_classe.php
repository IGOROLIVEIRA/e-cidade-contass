<?
//MODULO: sicom
//CLASSE DA ENTIDADE dclrf402018
class cl_dclrf402018 {
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
   var $si193_reg10 = 0;
   var $si193_publicrgf = 0;
   var $si193_dtpublicacaorelatoriorgf_dia = null;
   var $si193_dtpublicacaorelatoriorgf_mes = null;
   var $si193_dtpublicacaorelatoriorgf_ano = null;
   var $si193_dtpublicacaorelatoriorgf = null;
   var $si193_localpublicacaorgf = 0;
   var $si193_tpperiodo = 0;
   var $si193_exerciciotpperiodo = 0;
   var $si193_tiporegistro = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si193_reg10 = int4 = Sequencial DCLRF
                 si193_publicrgf = int4 = Publicação do RGF da LRF
                 si193_dtpublicacaorelatoriorgf = date = Data de publicação do RGF da LRF
                 si193_localpublicacaorgf = int4 = Onde foi dada a publicidade do RGF
                 si193_tpperiodo = int4 = Periodo a que se refere a data de public
                 si193_exerciciotpperiodo = int4 = Exercício a que se refere o período
                 si193_tiporegistro = int4 = Tipo Registro
                 ";
   //funcao construtor da classe
   function cl_dclrf402018() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dclrf402018");
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
       $this->si193_reg10 = ($this->si193_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_reg10"]:$this->si193_reg10);
       $this->si193_publicrgf = ($this->si193_publicrgf == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_publicrgf"]:$this->si193_publicrgf);
       if($this->si193_dtpublicacaorelatoriorgf == ""){
         $this->si193_dtpublicacaorelatoriorgf_dia = @$GLOBALS["HTTP_POST_VARS"]["si193_dtpublicacaorelatoriorgf_dia"];
         $this->si193_dtpublicacaorelatoriorgf_mes = @$GLOBALS["HTTP_POST_VARS"]["si193_dtpublicacaorelatoriorgf_mes"];
         $this->si193_dtpublicacaorelatoriorgf_ano = @$GLOBALS["HTTP_POST_VARS"]["si193_dtpublicacaorelatoriorgf_ano"];
         if($this->si193_dtpublicacaorelatoriorgf_dia != ""){
            $this->si193_dtpublicacaorelatoriorgf = $this->si193_dtpublicacaorelatoriorgf_ano."-".$this->si193_dtpublicacaorelatoriorgf_mes."-".$this->si193_dtpublicacaorelatoriorgf_dia;
         }
       }
       $this->si193_localpublicacaorgf = ($this->si193_localpublicacaorgf == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_localpublicacaorgf"]:$this->si193_localpublicacaorgf);
       $this->si193_tpperiodo = ($this->si193_tpperiodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_tpperiodo"]:$this->si193_tpperiodo);
       $this->si193_exerciciotpperiodo = ($this->si193_exerciciotpperiodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_exerciciotpperiodo"]:$this->si193_exerciciotpperiodo);
       $this->si193_tiporegistro = ($this->si193_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_tiporegistro"]:$this->si193_tiporegistro);
     }else{
     }
   }
   // funcao para inclusao
   function incluir (){
      $this->atualizacampos();
     if($this->si193_reg10 == null ){
       $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
       $this->erro_campo = "si193_reg10";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si193_publicrgf == null ){
       $this->erro_sql = " Campo Publicação do RGF da LRF nao Informado.";
       $this->erro_campo = "si193_publicrgf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     /*if($this->si193_dtpublicacaorelatoriorgf == null ){
       $this->erro_sql = " Campo Data de publicação do RGF da LRF nao Informado.";
       $this->erro_campo = "si193_dtpublicacaorelatoriorgf_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si193_localpublicacaorgf == null ){
       $this->erro_sql = " Campo Onde foi dada a publicidade do RGF nao Informado.";
       $this->erro_campo = "si193_localpublicacaorgf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si193_tpperiodo == null ){
       $this->erro_sql = " Campo Periodo a que se refere a data de public nao Informado.";
       $this->erro_campo = "si193_tpperiodo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si193_exerciciotpperiodo == null ){
       $this->erro_sql = " Campo Exercício a que se refere o período nao Informado.";
       $this->erro_campo = "si193_exerciciotpperiodo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }*/
     if($this->si193_tiporegistro == null ){
       $this->erro_sql = " Campo Tipo Registro nao Informado.";
       $this->erro_campo = "si193_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into dclrf402018(
                                       si193_reg10
                                      ,si193_publicrgf
                                      ,si193_dtpublicacaorelatoriorgf
                                      ,si193_localpublicacaorgf
                                      ,si193_tpperiodo
                                      ,si193_exerciciotpperiodo
                                      ,si193_tiporegistro
                       )
                values (
                                $this->si193_reg10
                               ,$this->si193_publicrgf
                               ,".($this->si193_dtpublicacaorelatoriorgf == "null" || $this->si193_dtpublicacaorelatoriorgf == "" ? "null" : "'".$this->si193_dtpublicacaorelatoriorgf."'")."
                               ,".($this->si193_localpublicacaorgf == "null" || $this->si193_localpublicacaorgf == "" ? "null" : "'".$this->si193_localpublicacaorgf."'")."
                               ,".($this->si193_tpperiodo == "null" || $this->si193_tpperiodo == "" ? "null" : $this->si193_tpperiodo)."
                               ,".($this->si193_exerciciotpperiodo == "null" || $this->si193_exerciciotpperiodo == "" ? "null" : $this->si193_exerciciotpperiodo)."
                               ,$this->si193_tiporegistro
                      )");
     /*die("insert into dclrf402018(
                                       si193_reg10
                                      ,si193_publicrgf
                                      ,si193_dtpublicacaorelatoriorgf
                                      ,si193_localpublicacaorgf
                                      ,si193_tpperiodo
                                      ,si193_exerciciotpperiodo
                                      ,si193_tiporegistro
                       )
                values (
                                $this->si193_reg10
                               ,$this->si193_publicrgf
                               ,".($this->si193_dtpublicacaorelatoriorgf == "null" || $this->si193_dtpublicacaorelatoriorgf == "" ? "null" : "'".$this->si193_dtpublicacaorelatoriorgf."'")."
                               ,".($this->si193_localpublicacaorgf == "null" || $this->si193_localpublicacaorgf == "" ? "null" : "'".$this->si193_localpublicacaorgf."'")."
                               ,".($this->si193_tpperiodo == "null" || $this->si193_tpperiodo == "" ? "null" : $this->si193_tpperiodo)."
                               ,".($this->si193_exerciciotpperiodo == "null" || $this->si193_exerciciotpperiodo == "" ? "null" : $this->si193_exerciciotpperiodo)."
                               ,$this->si193_tiporegistro
                      )");*/
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Publicação e Periodicidade do RGF da LRF () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Publicação e Periodicidade do RGF da LRF já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Publicação e Periodicidade do RGF da LRF () nao Incluído. Inclusao Abortada.";
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
   function alterar ( $si193_reg10=null ) {
      $this->atualizacampos();
     $sql = " update dclrf402018 set ";
     $virgula = "";
     if(trim($this->si193_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_reg10"])){
        if(trim($this->si193_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si193_reg10"])){
           $this->si193_reg10 = "0" ;
        }
       $sql  .= $virgula." si193_reg10 = $this->si193_reg10 ";
       $virgula = ",";
       if(trim($this->si193_reg10) == null ){
         $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
         $this->erro_campo = "si193_reg10";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si193_publicrgf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_publicrgf"])){
        if(trim($this->si193_publicrgf)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si193_publicrgf"])){
           $this->si193_publicrgf = "0" ;
        }
       $sql  .= $virgula." si193_publicrgf = $this->si193_publicrgf ";
       $virgula = ",";
       if(trim($this->si193_publicrgf) == null ){
         $this->erro_sql = " Campo Publicação do RGF da LRF nao Informado.";
         $this->erro_campo = "si193_publicrgf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si193_dtpublicacaorelatoriorgf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_dtpublicacaorelatoriorgf_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si193_dtpublicacaorelatoriorgf_dia"] !="") ){
       $sql  .= $virgula." si193_dtpublicacaorelatoriorgf = '$this->si193_dtpublicacaorelatoriorgf' ";
       $virgula = ",";
       if(trim($this->si193_dtpublicacaorelatoriorgf) == null ){
         $this->erro_sql = " Campo Data de publicação do RGF da LRF nao Informado.";
         $this->erro_campo = "si193_dtpublicacaorelatoriorgf_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["si193_dtpublicacaorelatoriorgf_dia"])){
         $sql  .= $virgula." si193_dtpublicacaorelatoriorgf = null ";
         $virgula = ",";
         if(trim($this->si193_dtpublicacaorelatoriorgf) == null ){
           $this->erro_sql = " Campo Data de publicação do RGF da LRF nao Informado.";
           $this->erro_campo = "si193_dtpublicacaorelatoriorgf_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si193_localpublicacaorgf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_localpublicacaorgf"])){
        if(trim($this->si193_localpublicacaorgf)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si193_localpublicacaorgf"])){
           $this->si193_localpublicacaorgf = "0" ;
        }
       $sql  .= $virgula." si193_localpublicacaorgf = $this->si193_localpublicacaorgf ";
       $virgula = ",";
       if(trim($this->si193_localpublicacaorgf) == null ){
         $this->erro_sql = " Campo Onde foi dada a publicidade do RGF nao Informado.";
         $this->erro_campo = "si193_localpublicacaorgf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si193_tpperiodo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_tpperiodo"])){
        if(trim($this->si193_tpperiodo)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si193_tpperiodo"])){
           $this->si193_tpperiodo = "0" ;
        }
       $sql  .= $virgula." si193_tpperiodo = $this->si193_tpperiodo ";
       $virgula = ",";
       if(trim($this->si193_tpperiodo) == null ){
         $this->erro_sql = " Campo Periodo a que se refere a data de public nao Informado.";
         $this->erro_campo = "si193_tpperiodo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si193_exerciciotpperiodo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_exerciciotpperiodo"])){
        if(trim($this->si193_exerciciotpperiodo)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si193_exerciciotpperiodo"])){
           $this->si193_exerciciotpperiodo = "0" ;
        }
       $sql  .= $virgula." si193_exerciciotpperiodo = $this->si193_exerciciotpperiodo ";
       $virgula = ",";
       if(trim($this->si193_exerciciotpperiodo) == null ){
         $this->erro_sql = " Campo Exercício a que se refere o período nao Informado.";
         $this->erro_campo = "si193_exerciciotpperiodo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si193_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_tiporegistro"])){
        if(trim($this->si193_tiporegistro)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si193_tiporegistro"])){
           $this->si193_tiporegistro = "0" ;
        }
       $sql  .= $virgula." si193_tiporegistro = $this->si193_tiporegistro ";
       $virgula = ",";
       if(trim($this->si193_tiporegistro) == null ){
         $this->erro_sql = " Campo Tipo Registro nao Informado.";
         $this->erro_campo = "si193_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where si193_reg10 = $si193_reg10 ";
     $result = @pg_exec($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Publicação e Periodicidade do RGF da LRF nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Publicação e Periodicidade do RGF da LRF nao foi Alterado. Alteracao Executada.\\n";
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
   function excluir ( $si193_reg10=null ) {
     $this->atualizacampos(true);
     $sql = " delete from dclrf402018
                    where ";
     $sql2 = "";
     $sql2 = "si193_reg10 = $si193_reg10";
     $result = @pg_exec($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Publicação e Periodicidade do RGF da LRF nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Publicação e Periodicidade do RGF da LRF nao Encontrado. Exclusão não Efetuada.\\n";
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
   function sql_query ( $si193_reg10 = null,$campos="dclrf402018.si193_reg10,*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf402018 ";
     $sql .= "      inner join   on  . = dclrf402018.si191_reg10 and  . = dclrf402018.si192_reg10 and  . = dclrf402018.si193_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if( $si193_reg10 != "" && $si193_reg10 != null){
          $sql2 = " where dclrf402018.si193_reg10 = $si193_reg10";
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
   function sql_query_file ( $si193_reg10 = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf402018 ";
     $sql2 = "";
     if($dbwhere==""){
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
