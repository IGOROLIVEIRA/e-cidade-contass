<?
//MODULO: sicom
//CLASSE DA ENTIDADE infocomplementaresinstit
class cl_infocomplementaresinstit {
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
   var $si09_sequencial = 0;
   var $si09_tipoinstit = 0;
   var $si09_codorgaotce = 0;
   var $si09_codunidadesubunidade = 0;
   var $si09_opcaosemestralidade = 0;
   var $si09_gestor = 0;
   var $si09_cnpjprefeitura = 0;
   var $si09_instit = 0;
   var $si09_assessoriacontabil = 0;
   var $si09_cgmassessoriacontabil = 0;
   var $si09_nroleicute = null;
   var $si09_dataleicute_dia = null;
   var $si09_dataleicute_mes = null;
   var $si09_dataleicute_ano = null;
   var $si09_dataleicute = null;
   var $si09_contaunicatesoumunicipal = null;
   var $si09_instsiconfi = null;
   var $si09_codfundotcemg = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si09_sequencial = int8 = Código Sequencial
                 si09_tipoinstit = int8 = Tipo de Instituição
                 si09_codorgaotce = int8 = Código do Orgão no TCE/MG
                 si09_codunidadesubunidade = int8 = Codigo da unidade ou Subunidade
                 si09_opcaosemestralidade = int8 = Opção Semestralidade
                 si09_gestor = int8 = CGM do Gestor
                 si09_cnpjprefeitura = int8 = Cnpj da Prefeitura
                 si09_instit = float8 = Intituição
                 si09_assessoriacontabil = int8 = Assessoria Contabil
                 si09_cgmassessoriacontabil = int8 = Cgm Assessoria Contabil
                 si09_nroleicute = int8 = Número da Lei CUTE
                 si09_dataleicute = date = Data da Lei CUTE
                 si09_contaunicatesoumunicipal = int8 = Conta Única do Tesouro Municipal
                 si09_instsiconfi = varchar(25) = Código da instituição SICONFI
                 si09_codfundotcemg = int8 = Código do Fundo TCE/MG
                 ";
   //funcao construtor da classe
   function cl_infocomplementaresinstit() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("infocomplementaresinstit");
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
       $this->si09_sequencial = ($this->si09_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_sequencial"]:$this->si09_sequencial);
       $this->si09_tipoinstit = ($this->si09_tipoinstit == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_tipoinstit"]:$this->si09_tipoinstit);
       $this->si09_codorgaotce = ($this->si09_codorgaotce == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_codorgaotce"]:$this->si09_codorgaotce);
       $this->si09_codunidadesubunidade = ($this->si09_codunidadesubunidade == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_codunidadesubunidade"]:$this->si09_codunidadesubunidade);
       $this->si09_opcaosemestralidade = ($this->si09_opcaosemestralidade == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_opcaosemestralidade"]:$this->si09_opcaosemestralidade);
       $this->si09_gestor = ($this->si09_gestor == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_gestor"]:$this->si09_gestor);
       $this->si09_cnpjprefeitura = ($this->si09_cnpjprefeitura == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_cnpjprefeitura"]:$this->si09_cnpjprefeitura);
       $this->si09_instit = ($this->si09_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_instit"]:$this->si09_instit);
       $this->si09_assessoriacontabil = ($this->si09_assessoriacontabil == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_assessoriacontabil"]:$this->si09_assessoriacontabil);
       $this->si09_instsiconfi = ($this->si09_instsiconfi == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_instsiconfi"]:$this->si09_instsiconfi);
       $this->si09_cgmassessoriacontabil = ($this->si09_cgmassessoriacontabil == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_cgmassessoriacontabil"]:$this->si09_cgmassessoriacontabil);
	   $this->si09_nroleicute = ($this->si09_nroleicute == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_nroleicute"]:$this->si09_nroleicute);
	   $this->si09_contaunicatesoumunicipal = ($this->si09_contaunicatesoumunicipal == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_contaunicatesoumunicipal"]:$this->si09_contaunicatesoumunicipal);
	   $this->si09_codfundotcemg = ($this->si09_codfundotcemg == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_codfundotcemg"]:$this->si09_codfundotcemg);
	   if($this->si09_dataleicute == ""){
		 $this->si09_dataleicute_dia = ($this->si09_dataleicute_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si09_dataleicute_dia"] : $this->si09_dataleicute_dia);
		 $this->si09_dataleicute_mes = ($this->si09_dataleicute_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si09_dataleicute_mes"] : $this->si09_dataleicute_mes);
		 $this->si09_dataleicute_ano = ($this->si09_dataleicute_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si09_dataleicute_ano"] : $this->si09_dataleicute_ano);
		 if ($this->si09_dataleicute_dia != "") {
			 $this->si09_dataleicute = $this->si09_dataleicute_ano . "-" . $this->si09_dataleicute_mes . "-" . $this->si09_dataleicute_dia;
		 }
	   }
     }else{
       $this->si09_sequencial = ($this->si09_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si09_sequencial"]:$this->si09_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si09_sequencial){
      $this->atualizacampos();
     if($this->si09_tipoinstit == null ){
       $this->erro_sql = " Campo Tipo de Instituição nao Informado.";
       $this->erro_campo = "si09_tipoinstit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si09_codorgaotce == null ){
       $this->erro_sql = " Campo Código do Orgão no TCE/MG nao Informado.";
       $this->erro_campo = "si09_codorgaotce";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si09_codunidadesubunidade == null){
         $this->erro_sql = "Campo Cod. Unidade ou Subunidade? não informado.";
         $this->erro_campo = "si09_codunidadedesubunidade";
         $this->erro_banco = "";
         $this->erro_msg = "Usuário: \\n\\n".$this->erro_sql."\\n\\";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
     }
     if($this->si09_opcaosemestralidade == null ){
       $this->erro_sql = " Campo Opção Semestralidade nao Informado.";
       $this->erro_campo = "si09_opcaosemestralidade";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si09_gestor == null ){
       $this->erro_sql = " Campo CGM do Gestor nao Informado.";
       $this->erro_campo = "si09_gestor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->si09_cnpjprefeitura == null || $this->si09_cnpjprefeitura == "0") && $this->si09_tipoinstit != 2){
       $this->erro_sql = " Campo Cnpj da prefeitura nao Informado.";
       $this->erro_campo = "si09_cnpjprefeitura";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     } else {
     	if ($this->si09_tipoinstit == 2) {
     	  $this->si09_cnpjprefeitura = "0";
     	}
     }
     if($this->si09_instit == null ){
       $this->erro_sql = " Campo Intituição nao Informado.";
       $this->erro_campo = "si09_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si09_assessoriacontabil == 1 && empty($this->si09_cgmassessoriacontabil)){
       $this->erro_sql = " Campo Cgm Assessoria Contabil nao Informado.";
       $this->erro_campo = "si09_cgmassessoriacontabil";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
	 if($this->si09_contaunicatesoumunicipal == 1 && empty($this->si09_contaunicatesoumunicipal)){
	   $this->erro_sql = " Campo Conta Unica do Tesouro Municipal nao Informado.";
	   $this->erro_campo = "si09_contaunicatesoumunicipal";
	   $this->erro_banco = "";
	   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
	   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
	   $this->erro_status = "0";
	   return false;
	 }
     if($si09_sequencial == "" || $si09_sequencial == null ){
       $result = db_query("select nextval('infocomplementaresinstit_si09_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: infocomplementaresinstit_si09_sequencial_seq do campo: si09_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si09_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from infocomplementaresinstit_si09_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si09_sequencial)){
         $this->erro_sql = " Campo si09_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si09_sequencial = $si09_sequencial;
       }
     }
     if(($this->si09_sequencial == null) || ($this->si09_sequencial == "") ){
       $this->erro_sql = " Campo si09_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into infocomplementaresinstit(
                                       si09_sequencial
                                      ,si09_tipoinstit
                                      ,si09_codorgaotce
                                      ,si09_opcaosemestralidade
                                      ,si09_gestor
                                      ,si09_cnpjprefeitura
                                      ,si09_instit
                                      ,si09_assessoriacontabil
                                      ,si09_cgmassessoriacontabil
                                      ,si09_codunidadesubunidade
                                      ,si09_nroleicute
                                      ,si09_dataleicute
                                      ,si09_contaunicatesoumunicipal
                                      ,si09_instsiconfi
                                      ,si09_codfundotcemg
                       )
                values (
                                $this->si09_sequencial
                               ,$this->si09_tipoinstit
                               ,$this->si09_codorgaotce
                               ,$this->si09_opcaosemestralidade
                               ,$this->si09_gestor
                               ,$this->si09_cnpjprefeitura
                               ,$this->si09_instit
                               ,$this->si09_assessoriacontabil
                               ,".($this->si09_cgmassessoriacontabil == '' ? 'null' : $this->si09_cgmassessoriacontabil)."
                               ,".($this->si09_codunidadesubunidade == '' ? 0 : $this->si09_codunidadesubunidade)."
                               ,".($this->si09_nroleicute == '' ? 'null' : $this->si09_nroleicute)."
                               ,". ($this->si09_dataleicute == "null" || $this->si09_dataleicute == "" ? "null" : "'" . $this->si09_dataleicute . "'") . "
                               ,".($this->contaunicatesoumunicipal == '' ? 'null' : $this->contaunicatesoumunicipal)."
                               ,".($this->si09_instsiconfi == '' ? 'null' : "'" . $this->si09_instsiconfi . "'")."
                               ,".($this->si09_codfundotcemg == '' ? 0 : $this->si09_codfundotcemg)."
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Informações complementares tce/mg ($this->si09_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Informações complementares tce/mg já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Informações complementares tce/mg ($this->si09_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si09_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si09_sequencial));
//     if(($resaco!=false)||($this->numrows!=0)){
//       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//       $acount = pg_result($resac,0,0);
//       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
//       $resac = db_query("insert into db_acountkey values($acount,2009466,'$this->si09_sequencial','I')");
//       $resac = db_query("insert into db_acount values($acount,2010228,2009466,'','".AddSlashes(pg_result($resaco,0,'si09_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//       $resac = db_query("insert into db_acount values($acount,2010228,2009468,'','".AddSlashes(pg_result($resaco,0,'si09_tipoinstit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//       $resac = db_query("insert into db_acount values($acount,2010228,2009469,'','".AddSlashes(pg_result($resaco,0,'si09_codorgaotce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//       $resac = db_query("insert into db_acount values($acount,2010228,2009470,'','".AddSlashes(pg_result($resaco,0,'si09_opcaosemestralidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//       $resac = db_query("insert into db_acount values($acount,2010228,2009471,'','".AddSlashes(pg_result($resaco,0,'si09_gestor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//       $resac = db_query("insert into db_acount values($acount,2010228,2009472,'','".AddSlashes(pg_result($resaco,0,'si09_cnpjprefeitura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//       $resac = db_query("insert into db_acount values($acount,2010228,2009473,'','".AddSlashes(pg_result($resaco,0,'si09_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//     }
     return true;
   }
   // funcao para alteracao
   function alterar ($si09_sequencial=null) {
      $this->atualizacampos();
     $sql = " update infocomplementaresinstit set ";
     $virgula = "";
     if(trim($this->si09_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_sequencial"])){
       $sql  .= $virgula." si09_sequencial = $this->si09_sequencial ";
       $virgula = ",";
       if(trim($this->si09_sequencial) == null ){
         $this->erro_sql = " Campo Código Sequencial nao Informado.";
         $this->erro_campo = "si09_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si09_tipoinstit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_tipoinstit"])){
       $sql  .= $virgula." si09_tipoinstit = $this->si09_tipoinstit ";
       $virgula = ",";
       if(trim($this->si09_tipoinstit) == null ){
         $this->erro_sql = " Campo Tipo de Instituição nao Informado.";
         $this->erro_campo = "si09_tipoinstit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si09_codorgaotce)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_codorgaotce"])){
       $sql  .= $virgula." si09_codorgaotce = $this->si09_codorgaotce ";
       $virgula = ",";
       if(trim($this->si09_codorgaotce) == null ){
         $this->erro_sql = " Campo Código do Orgão no TCE/MG nao Informado.";
         $this->erro_campo = "si09_codorgaotce";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si09_codunidadesubunidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_codunidadesubunidade"])){
       $sql  .= $virgula." si09_codunidadesubunidade = '$this->si09_codunidadesubunidade' ";
       $virgula = ",";
       if(trim($this->si09_codunidadesubunidade) == null ){
         $this->erro_sql = " Campo Código do Orgão no TCE/MG nao Informado.";
         $this->erro_campo = "si09_codunidadesubunidade";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si09_opcaosemestralidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_opcaosemestralidade"])){
       $sql  .= $virgula." si09_opcaosemestralidade = $this->si09_opcaosemestralidade ";
       $virgula = ",";
       if(trim($this->si09_opcaosemestralidade) == null ){
         $this->erro_sql = " Campo Opção Semestralidade nao Informado.";
         $this->erro_campo = "si09_opcaosemestralidade";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si09_gestor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_gestor"])){
       $sql  .= $virgula." si09_gestor = $this->si09_gestor ";
       $virgula = ",";
       if(trim($this->si09_gestor) == null ){
         $this->erro_sql = " Campo CGM do Gestor nao Informado.";
         $this->erro_campo = "si09_gestor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si09_cnpjprefeitura)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_cnpjprefeitura"])){
        if(trim($this->si09_cnpjprefeitura)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si09_cnpjprefeitura"])){
           $this->si09_cnpjprefeitura = "0" ;
        }
       if(($this->si09_cnpjprefeitura == null || $this->si09_cnpjprefeitura == "0") && $this->si09_tipoinstit != 2){
         $this->erro_sql = " Campo Cnpj da prefeitura nao Informado.";
         $this->erro_campo = "si09_cnpjprefeitura";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         if ($this->si09_tipoinstit == 2) {
     	    $this->si09_cnpjprefeitura = "0";
     	   }
       }
       $sql  .= $virgula." si09_cnpjprefeitura = $this->si09_cnpjprefeitura ";
       $virgula = ",";
     }
     if(trim($this->si09_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_instit"])){
       $sql  .= $virgula." si09_instit = $this->si09_instit ";
       $virgula = ",";
       if(trim($this->si09_instit) == null ){
         $this->erro_sql = " Campo Intituição nao Informado.";
         $this->erro_campo = "si09_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si09_assessoriacontabil)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_assessoriacontabil"])){
       $sql  .= $virgula." si09_assessoriacontabil = $this->si09_assessoriacontabil ";
       $virgula = ",";
     }
    if(trim($this->si09_cgmassessoriacontabil)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_cgmassessoriacontabil"])){
       $sql  .= $virgula." si09_cgmassessoriacontabil = ".($this->si09_cgmassessoriacontabil == '' ? 'null' : $this->si09_cgmassessoriacontabil);
       $virgula = ",";
       if($this->si09_assessoriacontabil == 1 && empty($this->si09_cgmassessoriacontabil)){
         $this->erro_sql = " Campo Cgm Assessoria Contabil nao Informado.";
         $this->erro_campo = "si09_cgmassessoriacontabil";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
    }

	if(trim($this->si09_nroleicute)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_nroleicute"])){
		$sql  .= $virgula." si09_nroleicute = ".($this->si09_nroleicute == '' ? 'null' : $this->si09_nroleicute);
		$virgula = ",";
		if($this->si09_nroleicute == 1 && empty($this->si09_nroleicute)){
			$this->erro_sql = " Campo Número da Lei não Informado.";
			$this->erro_campo = "si09_nroleicute";
			$this->erro_banco = "";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
		}
	}
  if(trim($this->si09_instsiconfi)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_instsiconfi"])){
    $sql  .= $virgula." si09_instsiconfi = ".($this->si09_instsiconfi == '' ? 'null' : "'$this->si09_instsiconfi'");
    $virgula = ",";
    if($this->si09_instsiconfi == 1 && empty($this->si09_instsiconfi)){
      $this->erro_sql = " Campo instituição SICONFI não Informado.";
      $this->erro_campo = "si09_instsiconfi";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
  }
	if (trim($this->si09_dataleicute) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si09_dataleicute"]) && ($GLOBALS["HTTP_POST_VARS"]["si09_dataleicute_dia"] != "")) {
		$sql .= $virgula . " si09_dataleicute = '$this->si09_dataleicute' ";
	}else {
		if (isset($GLOBALS["HTTP_POST_VARS"]["si09_dataleicute_dia"])) {
			$sql .= $virgula . " si09_dataleicute = null ";
		}
	}

   if(trim($this->si09_contaunicatesoumunicipal!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_contaunicatesoumunicipal"]))){
	   $sql  .= $virgula." si09_contaunicatesoumunicipal = ".($this->si09_contaunicatesoumunicipal == '' ? 'null' : $this->si09_contaunicatesoumunicipal);
	   $virgula = ",";
	   if($this->si09_contaunicatesoumunicipal == 1 && empty($this->si09_contaunicatesoumunicipal)){
		   $this->erro_sql = " Campo Número da Lei não Informado.";
		   $this->erro_campo = "si09_contaunicatesoumunicipal";
		   $this->erro_banco = "";
		   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
		   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
		   $this->erro_status = "0";
		   return false;
	   }
   }

     if(trim($this->si09_codfundotcemg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si09_codfundotcemg"])){
       $sql  .= $virgula." si09_codfundotcemg = '$this->si09_codfundotcemg' ";
       $virgula = ",";
     }

	  $sql .= " where ";
     if($si09_sequencial!=null){
       $sql .= " si09_sequencial = $this->si09_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si09_sequencial));
     if($this->numrows>0){
//       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
//         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//         $acount = pg_result($resac,0,0);
//         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
//         $resac = db_query("insert into db_acountkey values($acount,2009466,'$this->si09_sequencial','A')");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si09_sequencial"]) || $this->si09_sequencial != "")
//           $resac = db_query("insert into db_acount values($acount,2010228,2009466,'".AddSlashes(pg_result($resaco,$conresaco,'si09_sequencial'))."','$this->si09_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si09_tipoinstit"]) || $this->si09_tipoinstit != "")
//           $resac = db_query("insert into db_acount values($acount,2010228,2009468,'".AddSlashes(pg_result($resaco,$conresaco,'si09_tipoinstit'))."','$this->si09_tipoinstit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si09_codorgaotce"]) || $this->si09_codorgaotce != "")
//           $resac = db_query("insert into db_acount values($acount,2010228,2009469,'".AddSlashes(pg_result($resaco,$conresaco,'si09_codorgaotce'))."','$this->si09_codorgaotce',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si09_opcaosemestralidade"]) || $this->si09_opcaosemestralidade != "")
//           $resac = db_query("insert into db_acount values($acount,2010228,2009470,'".AddSlashes(pg_result($resaco,$conresaco,'si09_opcaosemestralidade'))."','$this->si09_opcaosemestralidade',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si09_gestor"]) || $this->si09_gestor != "")
//           $resac = db_query("insert into db_acount values($acount,2010228,2009471,'".AddSlashes(pg_result($resaco,$conresaco,'si09_gestor'))."','$this->si09_gestor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si09_cnpjprefeitura"]) || $this->si09_cnpjprefeitura != "")
//           $resac = db_query("insert into db_acount values($acount,2010228,2009472,'".AddSlashes(pg_result($resaco,$conresaco,'si09_cnpjprefeitura'))."','$this->si09_cnpjprefeitura',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si09_instit"]) || $this->si09_instit != "")
//           $resac = db_query("insert into db_acount values($acount,2010228,2009473,'".AddSlashes(pg_result($resaco,$conresaco,'si09_instit'))."','$this->si09_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//       }
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Informações complementares tce/mg nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si09_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Informações complementares tce/mg nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si09_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si09_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si09_sequencial=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si09_sequencial));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009466,'$si09_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010228,2009466,'','".AddSlashes(pg_result($resaco,$iresaco,'si09_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010228,2009468,'','".AddSlashes(pg_result($resaco,$iresaco,'si09_tipoinstit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010228,2009469,'','".AddSlashes(pg_result($resaco,$iresaco,'si09_codorgaotce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010228,2009470,'','".AddSlashes(pg_result($resaco,$iresaco,'si09_opcaosemestralidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010228,2009471,'','".AddSlashes(pg_result($resaco,$iresaco,'si09_gestor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010228,2009472,'','".AddSlashes(pg_result($resaco,$iresaco,'si09_cnpjprefeitura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010228,2009473,'','".AddSlashes(pg_result($resaco,$iresaco,'si09_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010228,2009473,'','".AddSlashes(pg_result($resaco,$iresaco,'si09_instsiconfi'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from infocomplementaresinstit
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si09_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si09_sequencial = $si09_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Informações complementares tce/mg nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si09_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Informações complementares tce/mg nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si09_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si09_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:infocomplementaresinstit";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si09_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from infocomplementaresinstit ";
     $sql .= "      inner join cgm as cgmgestor  on  cgmgestor.z01_numcgm = infocomplementaresinstit.si09_gestor";
     $sql .= "      left join cgm as cgmassessoria  on  cgmassessoria.z01_numcgm = infocomplementaresinstit.si09_cgmassessoriacontabil";
     $sql2 = "";
     if($dbwhere==""){
       if($si09_sequencial!=null ){
         $sql2 .= " where infocomplementaresinstit.si09_sequencial = $si09_sequencial ";
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
   function sql_query_file ( $si09_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from infocomplementaresinstit ";
     $sql2 = "";
     if($dbwhere==""){
       if($si09_sequencial!=null ){
         $sql2 .= " where infocomplementaresinstit.si09_sequencial = $si09_sequencial ";
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
