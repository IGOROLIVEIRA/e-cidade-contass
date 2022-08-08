<?
//MODULO: sicom
//CLASSE DA ENTIDADE dclrf402020
class cl_dclrf402020 {
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
	var $si193_sequencial = 0;
	var $si193_tiporegistro = 0;
	var $si193_publicrgf = 0;
	var $si193_dtpublicacaorgf_dia = null;
	var $si193_dtpublicacaorgf_mes = null;
	var $si193_dtpublicacaorgf_ano = null;
	var $si193_dtpublicacaorgf = null;
	var $si193_localpublicacaorgf = 0;
	var $si193_tpperiodo = 0;
	var $si193_exerciciotpperiodo = 0;
	var $si193_mes = 0;
	var $si193_instit = 0;
	var $si193_reg10 = 0;
	// cria propriedade com as variaveis do arquivo
   var $campos = "
   				 si193_sequencial = int8 = sequencial
                 si193_tiporegistro = int4 = Tipo Registro
                 si193_publicrgf = int4 = Publicação do RGF da LRF
                 si193_dtpublicacaorgf = date = Data de publicação do RGF da LRF
                 si193_localpublicacaorgf = int4 = Onde foi dada a publicidade do RGF
                 si193_tpperiodo = int4 = Periodo a que se refere a data de public
                 si193_exerciciotpperiodo = int4 = Exercício a que se refere o período
                 si193_mes = int2 = Mês de referência
                 si193_instit = int8 = Instituição
                 si193_reg10 = int4 = Sequencial DCLRF
                 ";
   //funcao construtor da classe
   function cl_dclrf402020() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dclrf402020");
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
		 $this->si193_sequencial = ($this->si193_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_sequencial"]:$this->si193_sequencial);
		 $this->si193_tiporegistro = ($this->si193_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_tiporegistro"]:$this->si193_tiporegistro);
		 $this->si193_publicrgf = ($this->si193_publicrgf == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_publicrgf"]:$this->si193_publicrgf);
		 if($this->si193_dtpublicacaorgf == ""){
			 $this->si193_dtpublicacaorgf_dia = @$GLOBALS["HTTP_POST_VARS"]["si193_dtpublicacaorgf_dia"];
			 $this->si193_dtpublicacaorgf_mes = @$GLOBALS["HTTP_POST_VARS"]["si193_dtpublicacaorgf_mes"];
			 $this->si193_dtpublicacaorgf_ano = @$GLOBALS["HTTP_POST_VARS"]["si193_dtpublicacaorgf_ano"];
			 if($this->si193_dtpublicacaorgf_dia != ""){
				 $this->si193_dtpublicacaorgf = $this->si193_dtpublicacaorgf_ano."-".$this->si193_dtpublicacaorgf_mes."-".$this->si193_dtpublicacaorgf_dia;
			 }
		 }
		 $this->si193_localpublicacaorgf = ($this->si193_localpublicacaorgf == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_localpublicacaorgf"]:$this->si193_localpublicacaorgf);
		 $this->si193_tpperiodo = ($this->si193_tpperiodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_tpperiodo"]:$this->si193_tpperiodo);
		 $this->si193_exerciciotpperiodo = ($this->si193_exerciciotpperiodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_exerciciotpperiodo"]:$this->si193_exerciciotpperiodo);
		 $this->si193_mes = ($this->si193_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_mes"]:$this->si193_mes);
		 $this->si193_instit = ($this->si193_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_instit"]:$this->si193_instit);
		 $this->si193_reg10 = ($this->si193_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_reg10"]:$this->si193_reg10);
     }else{
     }
   }
   // funcao para inclusao
   function incluir ($si193_sequencial){
      $this->atualizacampos();
	   if($si193_sequencial == "" || $si193_sequencial == null ){
		   $result = @pg_query("select nextval('dclrf402020_si193_sequencial_seq')");
		   if($result==false){
			   $this->erro_banco = str_replace("\n","",@pg_last_error());
			   $this->erro_sql   = "Verifique o cadastro da sequencia: dclrf402020_si192_sequencial_seq do campo: si193_sequencial";
			   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			   $this->erro_status = "0";
			   return false;
		   }
		   $this->si193_sequencial = pg_result($result,0,0);
	   }else{
		   $result = @pg_query("select last_value from dclrf402020_si193_sequencial_seq");
		   if(($result != false) && (pg_result($result,0,0) < $si193_sequencial)){
			   $this->erro_sql = " Campo si192_sequencial maior que último número da sequencia.";
			   $this->erro_banco = "Sequencia menor que este número.";
			   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			   $this->erro_status = "0";
			   return false;
		   }else{
			   $this->si193_sequencial = $si193_sequencial;
		   }
	   }
	   if($this->si193_tiporegistro == null ){
		   $this->erro_sql = " Campo Tipo Registro nao Informado.";
		   $this->erro_campo = "si193_tiporegistro";
		   $this->erro_banco = "";
		   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
		   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
		   $this->erro_status = "0";
		   return false;
	   }
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
	   if($this->si193_mes == null ){
		   $this->erro_sql = " Campo Mês não Informado.";
		   $this->erro_campo = "si193_mes";
		   $this->erro_banco = "";
		   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
		   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
		   $this->erro_status = "0";
		   return false;
       }
	   if($this->si193_instit == null ){
		   $this->erro_sql = " Campo Instituição não Informado.";
		   $this->erro_campo = "si193_instit";
		   $this->erro_banco = "";
		   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
		   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
		   $this->erro_status = "0";
		   return false;
       }
	 $sql = "insert into dclrf402020(
                                	   si193_sequencial
                                      ,si193_tiporegistro
                                      ,si193_publicrgf
                                      ,si193_dtpublicacaorgf
                                      ,si193_localpublicacaorgf
                                      ,si193_tpperiodo
                                      ,si193_exerciciotpperiodo
                                      ,si193_mes
                                      ,si193_instit
                                      ,si193_reg10
                       )
                values (
                                $this->si193_sequencial
                               ,$this->si193_tiporegistro
                               ,$this->si193_publicrgf
                               ,".($this->si193_dtpublicacaorgf == "null" || $this->si193_dtpublicacaorgf == "" ? "null" : "'".$this->si193_dtpublicacaorgf."'")."
                               ,'$this->si193_localpublicacaorgf'
                               ,$this->si193_tpperiodo
                               ,".($this->si193_exerciciotpperiodo == "null" || $this->si193_exerciciotpperiodo == "" ? 0 : $this->si193_exerciciotpperiodo)."
                               ,$this->si193_mes
                               ,$this->si193_instit
                               ,$this->si193_reg10
                      )";
//	   die($sql);
       $result = db_query($sql);
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
   function alterar ($si193_sequencial=null ) {
      $this->atualizacampos();
     $sql = " update dclrf402020 set ";
     $virgula = "";
     if(trim($this->si193_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_sequencial"])){
        if(trim($this->si193_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si193_sequencial"])){
           $this->si193_sequencial = "0" ;
        }
        $sql  .= $virgula." si193_sequencial = $this->si193_sequencial ";
        $virgula = ",";
        if(trim($this->si193_sequencial) == null ){
        	$this->erro_sql = " Campo Sequencial não Informado.";
			$this->erro_campo = "si193_sequencial";
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
     if(trim($this->si193_dtpublicacaorgf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_dtpublicacaorgf_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si193_dtpublicacaorgf_dia"] !="") ){
       $sql  .= $virgula." si193_dtpublicacaorgf = '$this->si193_dtpublicacaorgf' ";
       $virgula = ",";
       if(trim($this->si193_dtpublicacaorgf) == null ){
         $this->erro_sql = " Campo Data de publicação do RGF da LRF nao Informado.";
         $this->erro_campo = "si193_dtpublicacaorgf_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["si193_dtpublicacaorgf_dia"])){
         $sql  .= $virgula." si193_dtpublicacaorgf = null ";
         $virgula = ",";
         if(trim($this->si193_dtpublicacaorgf) == null ){
           $this->erro_sql = " Campo Data de publicação do RGF da LRF nao Informado.";
           $this->erro_campo = "si193_dtpublicacaorgf_dia";
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
     $sql .= " where ";
     $sql .= " si193_sequencial = $si193_sequencial ";
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
   function excluir ($si193_sequencial = null, $dbwhere = null) {
    // $this->atualizacampos(true);
     $sql = " delete from dclrf402020
                    where ";
     $sql2 = "";
     if($dbwhere == null || $dbwhere == ''){
     	if($si193_sequencial != ""){
        if($sql2!='')
     		 $sql2 .= " and ";
		    }
		    $sql2 .= " si193_sequencial = $si193_sequencial ";
	 }else{
     	$sql2 = $dbwhere;
	 }
//     $sql2 = "si193_reg10 = $si193_reg10";
     $result = @pg_exec($sql.$sql2);
     // print_r($sql2);die();
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dclrf402020 não Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dclrf402020 nao Encontrado. Exclusão não Efetuada.\\n";
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
   function sql_query ( $si193_sequencial = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= "      inner join  dclrf102020 on  dclrf102020.si157_sequencial = dclrf402020.si193_reg10 ";
     // $sql .= "      inner join   on  . = dclrf402020.si191_reg10 and  . = dclrf402020.si192_reg10 and  . = dclrf402020.si193_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if( $si193_sequencial != "" && $si193_sequencial != null){
          $sql2 = " where dclrf402020.si193_sequencial = $si193_sequencial";
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
     $sql .= " from dclrf402020 ";
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
