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

//MODULO: Configuracoes
//CLASSE DA ENTIDADE obrasdadoscomplementares
class cl_obrasdadoscomplementares
{
	// cria variaveis de erro
	var $rotulo = null;
	var $query_sql = null;
	var $numrows = 0;
	var $numrows_incluir = 0;
	var $numrows_alterar = 0;
	var $numrows_excluir = 0;
	var $erro_status = null;
	var $erro_sql = null;
	var $erro_banco = null;
	var $erro_msg = null;
	var $erro_campo = null;
	var $pagina_retorno = null;
	// cria variaveis do arquivo
	var $db150_sequencial = 0;
	var $db150_codobra = 0;
	var $db150_pais = 0;
	var $db150_estado = 0;
	var $db150_municipio = 0;
	var $db150_distrito = '';
	var $db150_bairro = '';
	var $db150_numero = 0;
	var $db150_logradouro = '';
	var $db150_grauslatitude = 0;
	var $db150_minutolatitude = 0;
	var $db150_segundolatitude = 0;
	var $db150_grauslongitude = 0;
	var $db150_minutolongitude = 0;
	var $db150_segundolongitude = 0;
	var $db150_classeobjeto = 0;
	var $db150_grupobempublico = 0;
	var $db150_subgrupobempublico = 0;
	var $db150_atividadeobra = 0;
	var $db150_atividadeservico = 0;
	var $db150_descratividadeservico = '';
	var $db150_atividadeservicoesp = 0;
	var $db150_descratividadeservicoesp = '';
	var $db150_bdi = 0;
	var $db150_cep = 0;

	// cria propriedade com as variaveis do arquivo
	var $campos = "
                    db150_sequencial = int4 = Código do Endereço
                    db150_codobra = int4 = Código da Obra
                    db150_pais = int4 = Código do País
                    db150_estado = int4 = Código do Estado
                    db150_municipio = int4 = Código do Município
                    db150_distrito = varchar(150) = Distrito
                    db150_bairro = varchar(100) = Bairro
                    db150_numero = int4 = Número do local da obra
                    db150_logradouro = varchar(150) = Logradouro
                    db150_grauslatitude = int4 = Graus da Latitude
                    db150_minutolatitude = int4 = Minuto da Latitude 
                    db150_segundolatitude = numeric = Segundo da Latitude
                    db150_grauslongitude = int4 = Graus da Longitude
                    db150_minutolongitude = int4 = Minuto da Longitude
                    db150_segundolongitude = numeric = Segundo da Latitude
                    db150_classeobjeto =  int4 = Classe do objeto
                    db150_grupobempublico = int4 = Grupo Bem Público
                    db150_subgrupobempublico = int4 = Subgrupo Bem Público
                    db150_atividadeobra = int4 = Atividade da Obra
                    db150_atividadeservico = int4 = Atividade do Serviço
                    db150_descratividadeservico = varchar(150) = Descrição da Atividade do Serviço
                    db150_atividadeservicoesp = int4 = Atividade do Serviço Especializado
                    db150_descratividadeservicoesp = varchar(150) = Descrição da Atividade do Serviço Especializado
                    db150_bdi = numeric = BDI
                    db150_cep = char(8) = CEP
                  ";

	//funcao construtor da classe
	function cl_obrasdadoscomplementares()
	{
		//classes dos rotulos dos campos
		$this->rotulo = new rotulo("obrasdadoscomplementares");
		$this->pagina_retorno = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
	}

	//funcao erro
	function erro($mostra, $retorna)
	{
		if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
			echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
			if ($retorna == true) {
				echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
			}
		}
	}

	// funcao para atualizar campos
	function atualizacampos($exclusao = false)
	{
		if ($exclusao == false) {
			$this->db150_sequencial = ($this->db150_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_sequencial"] : $this->db150_sequencial);
			$this->db150_codobra = ($this->db150_codobra == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_codobra"] : $this->db150_codobra);
			$this->db150_pais = ($this->db150_pais == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_pais"] : $this->db150_pais);
			$this->db150_estado = ($this->db150_estado == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_estado"] : $this->db150_estado);
			$this->db150_municipio = ($this->db150_municipio == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_municipio"] : $this->db150_municipio);
			$this->db150_distrito = ($this->db150_distrito == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_distrito"] : $this->db150_distrito);
			$this->db150_bairro = ($this->db150_bairro == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_bairro"] : $this->db150_bairro);
			$this->db150_numero = ($this->db150_numero == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_numero"] : $this->db150_numero);
			$this->db150_logradouro = ($this->db150_logradouro == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_logradouro"] : $this->db150_logradouro);
			$this->db150_grauslatitude = ($this->db150_grauslatitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_grauslatitude"] : $this->db150_grauslatitude);
			$this->db150_minutolatitude = ($this->db150_minutolatitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_minutolatitude"] : $this->db150_minutolatitude);
			$this->db150_segundolatitude = ($this->db150_segundolatitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_segundolatitude"] : $this->db150_segundolatitude);
			$this->db150_grauslongitude = ($this->db150_grauslongitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_grauslongitude"] : $this->db150_grauslongitude);
			$this->db150_minutolongitude = ($this->db150_minutolongitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_minutolongitude"] : $this->db150_minutolongitude);
			$this->db150_segundolongitude = ($this->db150_segundolongitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_segundolongitude"] : $this->db150_segundolongitude);
			$this->db150_classeobjeto = ($this->db150_classeobjeto == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_classeobjeto"] : $this->db150_classeobjeto);
			$this->db150_atividadeobra = ($this->db150_atividadeobra == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_atividadeobra"] : $this->db150_atividadeobra);
			$this->db150_atividadeservico = ($this->db150_atividadeservico == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_atividadeservico"] : $this->db150_atividadeservico);
			$this->db150_descratividadeservico = ($this->db150_descratividadeservico == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_descratividadeservico"] : $this->db150_descratividadeservico);
			$this->db150_atividadeservicoesp = ($this->db150_atividadeservicoesp == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_atividadeservicoesp"] : $this->db150_atividadeservicoesp);
			$this->db150_descratividadeservicoesp = ($this->db150_descratividadeservicoesp == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_descratividadeservicoesp"] : $this->db150_descratividadeservicoesp);
			$this->db150_grupobempublico = ($this->db150_grupobempublico == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_grupobempublico"] : $this->db150_grupobempublico);
			$this->db150_subgrupobempublico = ($this->db150_subgrupobempublico == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_subgrupobempublico"] : $this->db150_subgrupobempublico);
			$this->db150_bdi = ($this->db150_bdi == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_bdi"] : $this->db150_bdi);
			$this->db150_cep = ($this->db150_cep == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->db150_cep"] : $this->db150_cep);

		} else {
			$this->db150_sequencial = ($this->db150_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_sequencial"] : $this->db150_sequencial);
		}
	}

	// funcao para inclusao
	function incluir($db150_sequencial)
	{
		$this->atualizacampos();

		if ($this->db150_codobra == null) {
			$this->erro_sql = " Campo Código Obra nao Informado.";
			$this->erro_campo = "db150_codobra";
			$this->erro_banco = "";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}
		if ($db150_sequencial == "" || $db150_sequencial == null) {
			$result = db_query("select nextval('obrasdadoscomplementares_db150_sequencial_seq')");
			if ($result == false) {
				$this->erro_banco = str_replace("\n", "", @pg_last_error());
				$this->erro_sql = "Verifique o cadastro da sequencia: obrasdadoscomplementares_db150_sequencial_seq do campo: db150_sequencial";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			}
			$this->db150_sequencial = pg_result($result, 0, 0);
		} else {
			$result = db_query("select last_value from obrasdadoscomplementares_db150_sequencial_seq");
			if (($result != false) && (pg_result($result, 0, 0) < $db150_sequencial)) {
				$this->erro_sql = " Campo db150_sequencial maior que último número da sequencia.";
				$this->erro_banco = "Sequencia menor que este número.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			} else {
				$this->db150_sequencial = $db150_sequencial;
			}
		}
		if (($this->db150_sequencial == null) || ($this->db150_sequencial == "")) {
			$this->erro_sql = " Campo db150_sequencial nao declarado.";
			$this->erro_banco = "Chave Primaria zerada.";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}
		if ($this->db150_classeobjeto == null) {
			$this->db150_classeobjeto = 0;
		}
		if ($this->db150_atividadeobra == null) {
			$this->db150_atividadeobra = 0;
		}
		if ($this->db150_atividadeservico == null) {
			$this->db150_atividadeservico = 0;
		}
		if ($this->db150_atividadeservicoesp == null) {
			$this->db150_atividadeservicoesp = 0;
		}
		if ($this->db150_grupobempublico == null) {
			$this->erro_sql = " Campo Grupo Bem Público nao declarado.";
			$this->erro_banco = "Campo db150_grupobempublico nao declarado.";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}
		if ($this->db150_subgrupobempublico == null) {
			$this->erro_sql = " Campo Sub Grupo Bem Público nao declarado.";
			$this->erro_banco = "Campo db150_subgrupobempublico nao declarado.";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}

		if ($this->db150_descratividadeservico == null) {
			$this->db150_descratividadeservico = '';
		}
		if ($this->db150_descratividadeservicoesp == null) {
			$this->db150_descratividadeservicoesp = '';
		}
//		if ($this->db150_bairro == null || $this->db150_bairro == "") {
//			$this->erro_sql = " Campo Bairro nao declarado.";
//			$this->erro_banco = "Campo db150_bairro nao declarado.";
//			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
//			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
//			$this->erro_status = "0";
//			return false;
//		}
		if ($this->db150_cep == null || $this->db150_cep == "") {
			$this->erro_sql = " Campo CEP nao declarado.";
			$this->erro_banco = "Campo db150_cep nao declarado.";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}
		if(!$this->db150_numero){
			$this->db150_numero = 'null';
		}
		$sql = "insert into obrasdadoscomplementares(
                                        db150_sequencial
                                        ,db150_codobra
                                        ,db150_pais
                                        ,db150_estado
                                        ,db150_municipio
                                        ,db150_distrito
                                        ,db150_logradouro
                                        ,db150_bairro
                                        ,db150_numero
                                        ,db150_grauslatitude
                                        ,db150_minutolatitude
                                        ,db150_segundolatitude
                                        ,db150_grauslongitude
                                        ,db150_minutolongitude
                                        ,db150_segundolongitude
                                        ,db150_classeobjeto
                                        ,db150_atividadeobra
                                        ,db150_atividadeservico
                                        ,db150_descratividadeservico
                                        ,db150_atividadeservicoesp
                                        ,db150_descratividadeservicoesp
                                        ,db150_grupobempublico
                                        ,db150_subgrupobempublico
                                        ,db150_bdi
                                        ,db150_cep
                        )
                values (
                                $this->db150_sequencial
                               ,$this->db150_codobra
                               ,$this->db150_pais
                               ,$this->db150_estado
                               ,$this->db150_municipio
                               ,'$this->db150_distrito'
                               ,'$this->db150_logradouro'
                               ,'$this->db150_bairro'
                               ,$this->db150_numero
                               ,'$this->db150_grauslatitude'
                               ,'$this->db150_minutolatitude'
                               ,'$this->db150_segundolatitude'
                               ,'$this->db150_grauslongitude'
                               ,'$this->db150_minutolongitude'
                               ,'$this->db150_segundolongitude'
                               ,$this->db150_classeobjeto
                               ,$this->db150_atividadeobra
                               ,$this->db150_atividadeservico
                               ,'$this->db150_descratividadeservico'
                               ,$this->db150_atividadeservicoesp
                               ,'$this->db150_descratividadeservicoesp'
                               ,$this->db150_grupobempublico
                               ,$this->db150_subgrupobempublico
                               ,$this->db150_bdi
                               ,'$this->db150_cep'
                      )";
		$result = db_query($sql);

		if ($result == false) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
				$this->erro_sql = "Cadastro de Endereço da Obra nao Incluído. Inclusao Abortada.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_banco = "Cadastro de Endereços da Obra já Cadastrado";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			} else {
				$this->erro_sql = "Cadastro de Endereços da Obra ($this->db150_sequencial) nao Incluído. Inclusao Abortada.";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			}
			$this->erro_status = "0";
			$this->numrows_incluir = 0;
			return false;
		}
		$this->erro_banco = "";
		$this->erro_sql = "Inclusao efetuada com Sucesso\\n";
		$this->erro_sql .= "Valores : " . $this->db150_sequencial;
		$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
		$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
		$this->erro_status = "1";
		$this->numrows_incluir = pg_affected_rows($result);
		return true;
	}

	// funcao para alteracao
	function alterar($db150_sequencial = null)
	{
		$this->atualizacampos();
		$sql = " update obrasdadoscomplementares set ";
		$virgula = "";
		if (trim($this->db150_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_sequencial"])) {
			$sql .= $virgula . " db150_sequencial = $this->db150_sequencial ";
			$virgula = ",";
			if (trim($this->db150_sequencial) == null) {
				$this->erro_sql = " Campo Código do Endereço da Obra não Informado.";
				$this->erro_campo = "db150_sequencial";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			}
		}
		if (trim($this->db150_codobra) != "" || isset($GLOBALS["HTTP_POST_VARS"]["$this->db150_codobra"])) {
			$sql .= $virgula . " db150_codobra = $this->db150_codobra ";
			$virgula = ",";
			if (trim($this->db150_codobra) == null) {
				$this->erro_sql = " Campo Código da Obra não Informado.";
				$this->erro_campo = "db150_codobra";
				$this->erro_banco = "";
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "0";
				return false;
			}
		}
		if (trim($this->db150_pais) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_pais"])) {
			$sql .= $virgula . " db150_pais = $this->db150_pais ";
			$virgula = ",";
		}
		if (trim($this->db150_estado) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_estado"])) {
			$sql .= $virgula . " db150_estado = $this->db150_estado ";
			$virgula = ",";
		}
		if (trim($this->db150_municipio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_municipio"])) {
			$sql .= $virgula . " db150_municipio = $this->db150_municipio ";
			$virgula = ",";
		}
		if (trim($this->db150_distrito) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_distrito"])) {
			$sql .= $virgula . " db150_distrito = '$this->db150_distrito' ";
			$virgula = ",";
		}
		if (trim($this->db150_bairro) != null || isset($GLOBALS["HTTP_POST_VARS"]["db150_bairro"])) {
			$sql .= $virgula . " db150_bairro = '$this->db150_bairro' ";
			$virgula = ",";
		}
//		if (trim($this->db150_numero) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_numero"])) {
		$sql .= $virgula . " db150_numero = ".(!$this->db150_numero ? 'null' : $this->db150_numero);
		$virgula = ",";
//		}
		if (trim($this->db150_logradouro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_logradouro"])) {
			$sql .= $virgula . " db150_logradouro = '$this->db150_logradouro' ";
			$virgula = ",";
		}
		if (trim($this->db150_grauslatitude) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_grauslatitude"])) {
			$sql .= $virgula . " db150_grauslatitude = '$this->db150_grauslatitude' ";
			$virgula = ",";
		}
		if (trim($this->db150_minutolatitude) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_minutolatitude"])) {
			$sql .= $virgula . " db150_minutolatitude = '$this->db150_minutolatitude' ";
			$virgula = ",";
		}
		if (trim($this->db150_segundolatitude) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_segundolatitude"])) {
			$sql .= $virgula . " db150_segundolatitude = '$this->db150_segundolatitude' ";
			$virgula = ",";
		}
		if (trim($this->db150_grauslongitude) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_grauslongitude"])) {
			$sql .= $virgula . " db150_grauslongitude = '$this->db150_grauslongitude' ";
			$virgula = ",";
		}
		if (trim($this->db150_minutolongitude) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_minutolongitude"])) {
			$sql .= $virgula . " db150_minutolongitude = '$this->db150_minutolongitude' ";
			$virgula = ",";
		}
		if (trim($this->db150_segundolongitude) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_segundolongitude"])) {
			$sql .= $virgula . " db150_segundolongitude = '$this->db150_segundolongitude' ";
			$virgula = ",";
		}
		if (trim($this->db150_classeobjeto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["$this->db150_classeobjeto"])) {
			$sql .= $virgula . " db150_classeobjeto = $this->db150_classeobjeto ";
			$virgula = ",";
		}
		if (trim($this->db150_atividadeobra) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_atividadeobra"])) {
			$sql .= $virgula . " db150_atividadeobra = $this->db150_atividadeobra ";
			$virgula = ",";
		}
		if (trim($this->db150_atividadeservico) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_atividadeservico"])) {
			$sql .= $virgula . " db150_atividadeservico = $this->db150_atividadeservico ";
			$virgula = ",";
		}
		if (trim($this->db150_atividadeservicoesp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_atividadeservicoesp"])) {
			$sql .= $virgula . " db150_atividadeservicoesp = $this->db150_atividadeservicoesp ";
			$virgula = ",";
		}

		if ($this->db150_grupobempublico != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_grupobempublico"])) {
			$sql .= $virgula . " db150_grupobempublico = $this->db150_grupobempublico ";
			$virgula = ",";
		}
		if (trim($this->db150_subgrupobempublico) != "" || isset($GLOBALS["HTTP_POST_VARS"]["$this->db150_subgrupobempublico"])) {
			$sql .= $virgula . " db150_subgrupobempublico = $this->db150_subgrupobempublico ";
			$virgula = ",";
		}
		if (trim($this->db150_bdi) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_bdi"])) {
			$sql .= $virgula . " db150_bdi = $this->db150_bdi ";
		}else{
			$sql .= $virgula . " db150_bdi = null ";
		}
		if (trim($this->db150_cep) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_cep"])) {
			$sql .= $virgula . " db150_cep = $this->db150_cep ";
		}
		$sql .= " where ";
		if ($db150_sequencial != null) {
			$sql .= " db150_sequencial = $db150_sequencial";
		}
		$result = db_query($sql);
		if ($result == false) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "Cadastro de Endereços da Obra nao Alterado. Alteracao Abortada.\\n";
			$this->erro_sql .= "Valores : " . $this->db150_sequencial;
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			$this->numrows_alterar = 0;
			return false;
		} else {
			if (pg_affected_rows($result) == 0) {
				$this->erro_banco = "";
				$this->erro_sql = "Cadastro de Endereços da Obra nao foi Alterado. Alteracao Executada.\\n";
				$this->erro_sql .= "Valores : " . $this->db150_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "1";
				$this->numrows_alterar = 0;
				return true;
			} else {
				$this->erro_banco = "";
				$this->erro_sql = "Alteração efetuada com Sucesso\\n";
				$this->erro_sql .= "Valores : " . $this->db150_sequencial;
				$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
				$this->erro_status = "1";
				$this->numrows_alterar = pg_affected_rows($result);
				return true;
			}
		}
	}

	// funcao para exclusao
	function excluir($db150_sequencial = null, $dbwhere = null)
	{
		$sql = " delete from obrasdadoscomplementares
                        where ";
		$sql2 = "";
		if ($dbwhere == null || $dbwhere == "") {
			if ($db150_sequencial != "") {
				if ($sql2 != "") {
					$sql2 .= " and ";
				}
				$sql2 .= " db150_sequencial = $db150_sequencial ";
			}
		} else {
			$sql2 = $dbwhere;
		}

		$result = db_query($sql . $sql2);
		if ($result == false) {
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "Cadastro de Endereços da Obra nao Excluído. Exclusão Abortada.\\n";
			$this->erro_sql .= "Valores : " . $db150_sequencial;
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			$this->numrows_excluir = 0;
			return false;
		} else {
			if (pg_affected_rows($result) == 0) {
				$this->erro_banco = "";
				$this->erro_sql = "Cadastro de Endereços da Obra nao Encontrado. Exclusão não Efetuada.\\n";
				$this->erro_sql .= "Valores : " . $db150_sequencial;
				$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "1";
				$this->numrows_excluir = 0;
				return true;
			} else {
				$this->erro_banco = "";
				$this->erro_sql = "Exclusão efetuada com Sucesso\n";
				//$this->erro_sql .= "Valores : ".$db150_sequencial;
				$this->erro_msg = "Usuário: \n " . $this->erro_sql . " \n";
				$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
				$this->erro_status = "1";
				$this->numrows_excluir = pg_affected_rows($result);
				return true;
			}
		}
	}

	// funcao do recordset
	function sql_record($sql)
	{
		$result = db_query($sql);
		if ($result == false) {
			$this->numrows = 0;
			$this->erro_banco = str_replace("\n", "", @pg_last_error());
			$this->erro_sql = "Erro ao selecionar os registros.";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}
		$this->numrows = pg_numrows($result);
		if ($this->numrows == 0) {
			$this->erro_banco = "";
			$this->erro_sql = "Record Vazio na Tabela:obrasdadoscomplementares";
			$this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
			$this->erro_status = "0";
			return false;
		}
		return $result;
	}

	// funcao do sql
	function sql_query($db150_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
	{
		$sql = "select ";
		if ($campos != "*") {
			$campos_sql = split("#", $campos);
			$virgula = "";
			for ($i = 0; $i < sizeof($campos_sql); $i++) {
				$sql .= $virgula . $campos_sql[$i];
				$virgula = ",";
			}
		} else {
			$sql .= $campos;
		}
		$sql .= " from obrasdadoscomplementares ";
		$sql .= " join obrascodigos on db151_codigoobra = db150_codobra ";
		$sql2 = "";
		if ($dbwhere == "") {
			if ($db150_sequencial != null) {
				$sql2 .= " where db150_sequencial = $db150_sequencial ";
			}
		} else if ($dbwhere != "") {
			$sql2 = " where $dbwhere";
		}
		$sql .= $sql2;
		if ($ordem != null) {
			$sql .= " order by ";
			$campos_sql = split("#", $ordem);
			$virgula = "";
			for ($i = 0; $i < sizeof($campos_sql); $i++) {
				$sql .= $virgula . $campos_sql[$i];
				$virgula = ",";
			}
		}
		return $sql;
	}

	function sql_query_completo($db150_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
	{
		$sql = "select ";
		if ($campos != "*") {
			$campos_sql = split("#", $campos);
			$virgula = "";
			for ($i = 0; $i < sizeof($campos_sql); $i++) {
				$sql .= $virgula . $campos_sql[$i];
				$virgula = ",";
			}
		} else {
			$sql .= $campos;
		}
		$sql .= " from obrasdadoscomplementares ";
		$sql .= " JOIN obrascodigos on db151_codigoobra = db150_codobra ";
		$sql .= " JOIN liclicita on l20_codigo = db151_liclicita ";
		$sql .= " INNER JOIN cadendermunicipio on db72_sequencial = db150_municipio ";
		$sql2 = "";
		if ($dbwhere == "") {
			if ($db150_sequencial != null) {
				$sql2 .= " where db150_sequencial = $db150_sequencial ";
			}
		} else if ($dbwhere != "") {
			$sql2 = " where $dbwhere";
		}
		$sql .= $sql2;
		if ($ordem != null) {
			$sql .= " order by ";
			$campos_sql = split("#", $ordem);
			$virgula = "";
			for ($i = 0; $i < sizeof($campos_sql); $i++) {
				$sql .= $virgula . $campos_sql[$i];
				$virgula = ",";
			}
		}
		return $sql;
	}

	// funcao do sql
	function sql_query_file($db150_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
	{
		$sql = "select ";
		if ($campos != "*") {
			$campos_sql = split("#", $campos);
			$virgula = "";
			for ($i = 0; $i < sizeof($campos_sql); $i++) {
				$sql .= $virgula . $campos_sql[$i];
				$virgula = ",";
			}
		} else {
			$sql .= $campos;
		}
		$sql .= " from obrasdadoscomplementares ";
		$sql2 = "";
		if ($dbwhere == "") {
			if ($db150_sequencial != null) {
				$sql2 .= " where obrasdadoscomplementares.db150_sequencial = $db150_sequencial ";
			}
		} else if ($dbwhere != "") {
			$sql2 = " where $dbwhere";
		}
		$sql .= $sql2;
		if ($ordem != null) {
			$sql .= " order by ";
			$campos_sql = split("#", $ordem);
			$virgula = "";
			for ($i = 0; $i < sizeof($campos_sql); $i++) {
				$sql .= $virgula . $campos_sql[$i];
				$virgula = ",";
			}
		}
		return $sql;
	}
}

?>
