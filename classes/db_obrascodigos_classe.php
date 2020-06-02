<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

//MODULO: licitação
//CLASSE DA ENTIDADE obrascodigos
class cl_obrascodigos {
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
	var $db151_codigoobra = null;
	var $db151_liclicita = null;
	// cria propriedade com as variaveis do arquivo
	var $campos = "
                 db151_codigoobra = int = Código da Obra 
                 db151_liclicita = int = Código da licitação 
                 ";
	//funcao construtor da classe
	function cl_obrascodigos() {
		//classes dos rotulos dos campos
		$this->rotulo = new rotulo("obrascodigos");
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
			$this->db151_codigoobra = ($this->db151_codigoobra == ""?@$GLOBALS["HTTP_POST_VARS"]["db151_codigoobra"]:$this->db151_codigoobra);
			$this->db151_liclicita = ($this->db151_liclicita == ""?@$GLOBALS["HTTP_POST_VARS"]["db151_liclicita"]:$this->db151_liclicita);
		}else{
			$this->db151_codigoobra = ($this->db151_codigoobra == ""?@$GLOBALS["HTTP_POST_VARS"]["db151_codigoobra"]:$this->db151_codigoobra);
		}
	}
	// funcao para inclusao
	function incluir ($db151_codigoobra){
		$this->atualizacampos();
		if($this->db151_liclicita == null ){
			$this->erro_sql = " Campo Licitação não Informado.";
			$this->erro_campo = "db151_liclicita";
			$this->erro_banco = "";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
		}

		if($db151_sequencial == "" || $db151_sequencial == null ){
			$result = db_query("select nextval('obrascodigos_db151_sequencial_seq')");
			if($result==false){
				$this->erro_banco = str_replace("\n","",@pg_last_error());
				$this->erro_sql   = "Verifique o cadastro da sequencia: obrascodigos_db151_sequencial_seq do campo: db151_sequencial";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}
			$this->db151_sequencial = pg_result($result,0,0);
		}else{
			$result = db_query("select last_value from obrascodigos_db151_sequencial_seq");
			if(($result != false) && (pg_result($result,0,0) < $db151_sequencial)){
				$this->erro_sql = " Campo db151_sequencial maior que último número da sequencia.";
				$this->erro_banco = "Sequencia menor que este número.";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}else{
				$this->db151_sequencial = $db151_sequencial;
			}
		}
		if(($this->db151_codigoobra == null) || ($this->db151_codigoobra == "") ){
			$this->erro_sql = " Campo db151_codigoobra nao declarado.";
			$this->erro_banco = "Chave Primaria zerada.";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
		}
		$sql = "insert into obrascodigos(
                                       db151_codigoobra 
                                      ,db151_liclicita 
                       )
                values (
                                $this->db151_codigoobra 
                               ,$this->db151_liclicita 
                      )";

		$result = db_query($sql);
		if($result==false){
			$this->erro_banco = str_replace("\n","",@pg_last_error());
			if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
				$this->erro_sql   = "Situações da Licitação ($this->db151_codigoobra) nao Incluído. Inclusao Abortada.";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_banco = "Situações da Licitação já Cadastrado";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			}else{
				$this->erro_sql   = "Situações da Licitação ($this->db151_codigoobra) nao Incluído. Inclusao Abortada.";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			}
			$this->erro_status = "0";
			$this->numrows_incluir= 0;
			return false;
		}
		$this->erro_banco = "";
		$this->erro_sql = "Inclusao efetuada com Sucesso\\n";
		$this->erro_sql .= "Valores : ".$this->db151_codigoobra;
		$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
		$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
		$this->erro_status = "1";
		$this->numrows_incluir= pg_affected_rows($result);
		return true;
	}
	// funcao para alteracao
	function alterar ($db151_codigoobra=null, $sWhere='') {
		$this->atualizacampos();
		$sql = " update obrascodigos set ";
		$virgula = "";
		if(trim($this->db151_codigoobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["db151_codigoobra"])){
			$sql  .= $virgula." db151_codigoobra = $this->db151_codigoobra ";
			$virgula = ",";
			if(trim($this->db151_codigoobra) == null ){
				$this->erro_sql = " Campo Código da Obra não Informado.";
				$this->erro_campo = "db151_codigoobra";
				$this->erro_banco = "";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}
		}
		if(trim($this->db151_liclicita)!="" || isset($GLOBALS["HTTP_POST_VARS"]["db151_liclicita"])){
			$sql  .= $virgula." db151_liclicita = '$this->db151_liclicita' ";
			$virgula = ",";
			if(trim($this->db151_liclicita) == null ){
				$this->erro_sql = " Campo Licitação não Informado.";
				$this->erro_campo = "db151_liclicita";
				$this->erro_banco = "";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}
		}
		$sql .= " where ";

		if($sWhere != null){
			$sql .= ' AND '.$sWhere;
		}else{
			if($this->db151_codigoobra!=null){
				$sql .= " db151_codigoobra = $this->db151_codigoobra";
			}
		}

		$result = db_query($sql);
		if($result==false){
			$this->erro_banco = str_replace("\n","",@pg_last_error());
			$this->erro_sql   = "Obras Código não Alterado. Alteracao Abortada.\\n";
			$this->erro_sql .= "Valores : ".$this->db151_codigoobra;
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			$this->numrows_alterar = 0;
			return false;
		}else{
			if(pg_affected_rows($result)==0){
				$this->erro_banco = "";
				$this->erro_sql = "Obras Código não foi Alterado. Alteracao Executada.\\n";
				$this->erro_sql .= "Valores : ".$this->db151_codigoobra;
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "1";
				$this->numrows_alterar = 0;
				return true;
			}else{
				$this->erro_banco = "";
				$this->erro_sql = "Alteração efetuada com Sucesso\\n";
				$this->erro_sql .= "Valores : ".$this->db151_codigoobra;
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "1";
				$this->numrows_alterar = pg_affected_rows($result);
				return true;
			}
		}
	}
	// funcao para exclusao
	function excluir ($db151_codigoobra=null,$dbwhere=null) {
		$sql = " delete from obrascodigos
                    where ";
		$sql2 = "";
		if($dbwhere==null || $dbwhere ==""){
			if($db151_codigoobra != ""){
				if($sql2!=""){
					$sql2 .= " and ";
				}
				$sql2 .= " db151_codigoobra = $db151_codigoobra ";
			}
		}else{
			$sql2 = $dbwhere;
		}

		$result = db_query($sql.$sql2);
		if($result==false){
			$this->erro_banco = str_replace("\n","",@pg_last_error());
			$this->erro_sql   = "Código da Obra nao Excluído. Exclusão Abortada.\\n";
			$this->erro_sql .= "Valores : ".$db151_codigoobra;
			$this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
			$this->erro_status = "0";
			$this->numrows_excluir = 0;
			return false;
		}else{
			if(pg_affected_rows($result)==0){
				$this->erro_banco = "";
				$this->erro_sql = "Código da Obra nao Encontrado. Exclusão não Efetuada.\n";
				$this->erro_sql .= "Valores : ".$db151_codigoobra;
				$this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
				$this->erro_status = "1";
				$this->numrows_excluir = 0;
				return true;
			}else{
				$this->erro_banco = "";
				$this->erro_sql = "Exclusão efetuada com Sucesso\n";
				$this->erro_sql .= "Valores : ".$db151_codigoobra;
				$this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
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
			$this->erro_sql   = "Record Vazio na Tabela:obrascodigos";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
		}
		return $result;
	}
	function sql_query ( $db151_codigoobra=null,$campos="*",$ordem=null,$dbwhere=""){
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
		$sql .= " from obrascodigos ";
		$sql2 = "";
		if($dbwhere==""){
			if($db151_codigoobra!=null ){
				$sql2 .= " where obrascodigos.db151_codigoobra = $db151_codigoobra ";
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
	function sql_query_file ( $db151_codigoobra=null,$campos="*",$ordem=null,$dbwhere=""){
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
		$sql .= " from obrascodigos ";
		$sql2 = "";
		if($dbwhere==""){
			if($db151_codigoobra!=null ){
				$sql2 .= " where obrascodigos.db151_codigoobra = $db151_codigoobra ";
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

	function sql_query_completo ( $db151_codigoobra=null,$campos="*",$ordem=null,$dbwhere=""){
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
		$sql .= " from obrascodigos ";
		$sql .= " join obrasdadoscomplementares on db151_codigoobra = db150_codobra";
		$sql2 = "";
		if($dbwhere==""){
			if($db151_codigoobra!=null ){
				$sql2 .= " where obrascodigos.db151_codigoobra = $db151_codigoobra ";
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