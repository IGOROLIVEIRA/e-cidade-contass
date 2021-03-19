<?php
	/**
	 * Created by PhpStorm.
	 * User: contass
	 * Date: 24/01/19
	 * Time: 16:06
	 */

//MODULO: sicom
//CLASSE DA ENTIDADE dclrf112021
class cl_dclrf112021 {
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
 	var $si205_sequencial = 0;
	var $si205_tiporegistro = 0;
	var $si205_medidasadotadas = 0;
	var $si205_dscmedidasadotadas = null;
	var $si205_reg10 = 0;
	var $si205_mes = 0;
	var $si205_instit = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si205_sequencial = int4 = Sequencial DCLRF
                 si205_tiporegistro = int4 = Tipo registro
                 si205_medidasadotadas = double = Valores dos passivos  reconhecidos
                 si205_dscmedidasadotadas = text = Medidas adotadas e a adotar
                 si205_reg10 = int8 = reg10
                 si205_mes = int2 = Mes de Referencia
                 si205_instit = int8 = Instituição
                 ";
   //funcao construtor da classe
   function cl_dclrf112021() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dclrf112021");
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
       $this->si205_sequencial = ($this->si205_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_sequencial"]:$this->si205_sequencial);
       $this->si205_medidasadotadas = ($this->si205_medidasadotadas == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_medidasadotadas"]:$this->si205_medidasadotadas);
       $this->si205_dscmedidasadotadas = ($this->si205_dscmedidasadotadas == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_dscmedidasadotadas"]:$this->si205_dscmedidasadotadas);
       $this->si205_tiporegistro = ($this->si205_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_tiporegistro"]:$this->si205_tiporegistro);
       $this->si205_reg10 = ($this->si205_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_reg10"]:$this->si205_reg10);
       $this->si205_mes = ($this->si205_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_mes"]:$this->si205_mes);
	   $this->si205_instit = ($this->si205_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_instit"]:$this->si205_instit);
     }else{
     }
   }
   // funcao para inclusao
   function incluir ($si205_sequencial){
      $this->atualizacampos();

	   if($this->si205_tiporegistro == null ){
		   $this->erro_sql = " Campo Tipo registro nao Informado.";
		   $this->erro_campo = "si205_tiporegistro";
		   $this->erro_banco = "";
		   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
		   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
		   $this->erro_status = "0";
		   return false;
	   }
	   if($this->si205_medidasadotadas == null ){
		 $this->erro_sql = " Campo Valores dos passivos  reconhecidos nao Informado.";
		 $this->erro_campo = "si205_medidasadotadas";
		 $this->erro_banco = "";
		 $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
		 $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
		 $this->erro_status = "0";
		 return false;
	   }

     	if($this->si205_mes == null ){
		   $this->erro_sql = " Campo Mes de Referencia nao Informado.";
		   $this->erro_campo = "si205_mes";
		   $this->erro_banco = "";
		   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
		   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
		   $this->erro_status = "0";
		   return false;
     	}
		if($this->si205_instit == null ){
			$this->erro_sql = " Campo Instituição nao Informado.";
		    $this->erro_campo = "si205_instit";
		    $this->erro_banco = "";
		    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
		    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
		    $this->erro_status = "0";
			return false;
		}
	     if($si205_sequencial == "" || $si205_sequencial == null ){
		   $result = @pg_query("select nextval('dclrf112021_si205_sequencial_seq')");
		   if($result==false){
			 $this->erro_banco = str_replace("\n","",@pg_last_error());
			 $this->erro_sql   = "Verifique o cadastro da sequencia: dclrf112021_si205_sequencial_seq do campo: si205_sequencial";
			 $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			 $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			 $this->erro_status = "0";
			 return false;
		   }
		   $this->si205_sequencial = pg_result($result,0,0);
		 }else{
		   $result = @pg_query("select last_value from dclrf112021_si205_sequencial_seq");
		   if(($result != false) && (pg_result($result,0,0) < $si205_sequencial)){
			 $this->erro_sql = " Campo si205_sequencial maior que último número da sequencia.";
			 $this->erro_banco = "Sequencia menor que este número.";
			 $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			 $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			 $this->erro_status = "0";
			 return false;
		   }else{
			 $this->si205_sequencial = $si205_sequencial;
		   }
		 }
     	$sql = "insert into dclrf112021(
                                       si205_sequencial
                                      ,si205_tiporegistro
                                      ,si205_medidasadotadas
                                      ,si205_dscmedidasadotadas
                                      ,si205_reg10
                                      ,si205_mes
                                      ,si205_instit
                       )
                values (
                                $this->si205_sequencial
                               ,$this->si205_tiporegistro
                               ,$this->si205_medidasadotadas
                               ,'$this->si205_dscmedidasadotadas'
                               ,$this->si205_reg10
                               ,$this->si205_mes
                               ,$this->si205_instit
                      )";
//	     die($sql);
       $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Dados Complementares à LRF () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Dados Complementares à LRF já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Dados Complementares à LRF () nao Incluído. Inclusao Abortada.";
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
   function alterar ( $si205_sequencial=null ) {
      $this->atualizacampos();
     $sql = " update dclrf112021 set ";
     $virgula = "";
     if(trim($this->si205_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_sequencial"])){
        if(trim($this->si205_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si205_sequencial"])){
           $this->si205_sequencial = "0" ;
        }
       $sql  .= $virgula." si205_sequencial = $this->si205_sequencial ";
       $virgula = ",";
       if(trim($this->si205_sequencial) == null ){
         $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
         $this->erro_campo = "si205_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
	 if(trim($this->si205_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_tiporegistro"])){
	 	if(trim($this->si205_tiporegistro)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si205_tiporegistro"])){
			$this->si205_tiporegistro = "0" ;
		}
		$sql  .= $virgula." si205_tiporegistro = $this->si205_tiporegistro ";
		$virgula = ",";
		if(trim($this->si205_tiporegistro) == null ){
			$this->erro_sql = " Campo Tipo registro nao Informado.";
			$this->erro_campo = "si205_tiporegistro";
			$this->erro_banco = "";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
		}
	 }
     if(trim($this->si205_medidasadotadas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_medidasadotadas"])){
       $sql  .= $virgula." si205_medidasadotadas = $this->si205_medidasadotadas ";
       $virgula = ",";
       if(trim($this->si205_medidasadotadas) == null ){
         $this->erro_sql = " Campo Valores dos passivos  reconhecidos nao Informado.";
         $this->erro_campo = "si205_medidasadotadas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si205_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_mes"])){
        if(trim($this->si205_mes)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si205_mes"])){
           $this->si205_mes = "0" ;
        }
       $sql  .= $virgula." si205_mes = $this->si205_mes ";
       $virgula = ",";
       if(trim($this->si205_mes) == null ){
         $this->erro_sql = " Campo Mes de Referencia nao Informado.";
         $this->erro_campo = "si205_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si205_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_instit"])){
        if(trim($this->si205_instit)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si205_instit"])){
           $this->si205_instit = "0" ;
        }
       $sql  .= $virgula." si205_instit = $this->si205_instit ";
       $virgula = ",";
       if(trim($this->si205_instit) == null ){
         $this->erro_sql = " Campo Mes de Referencia nao Informado.";
         $this->erro_campo = "si205_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
	   if (trim($this->si205_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si205_reg10"])) {
		   if (trim($this->si205_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si205_reg10"])) {
			   $this->si205_reg10 = "0";
		   }
		   $sql .= $virgula . " si205_reg10 = $this->si205_reg10 ";
		   $virgula = ",";
	   }
     $sql .= " where si205_sequencial = $si205_sequencial ";
     $result = @pg_exec($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Dados Complementares à LRF nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Dados Complementares à LRF nao foi Alterado. Alteracao Executada.\\n";
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
   function excluir ( $si205_mes=null, $si205_instit=null ) {
     $this->atualizacampos(true);
     $sql = " delete from dclrf112021
                    where ";
     $sql2 = "";
     $sql2 = "si205_mes = $si205_mes AND si205_instit = '$si205_instit' ";
//     echo $sql.$sql2;exit;
     $result = @pg_exec($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Dados Complementares à LRF nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Dados Complementares à LRF nao Encontrado. Exclusão não Efetuada.\\n";
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
   function sql_query ( $si205_sequencial = null,$campos="dclrf112021.si205_sequencial,*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf112021 ";
	 $sql .= " 		left join dclrf102020 on dclrf102020.si157_sequencial = dclrf112021.si205_reg10 ";
	 $sql2 = "";
     if($dbwhere==""){
       if( $si205_sequencial != "" && $si205_sequencial != null){
          $sql2 = " where dclrf112021.si205_sequencial = $si205_sequencial";
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
   function sql_query_file ( $si205_sequencial = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf112021 ";
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
