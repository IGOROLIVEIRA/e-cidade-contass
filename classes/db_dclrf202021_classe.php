<?
//MODULO: sicom
//CLASSE DA ENTIDADE dclrf202021
class cl_dclrf202021 {
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
	var $si191_sequencial = 0;
	var $si191_tiporegistro = 0;
	var $si191_contopcredito = 0;
	var $si191_dsccontopcredito = null;
	var $si191_realizopcredito = 0;
	var $si191_tiporealizopcreditocapta = 0;
	var $si191_tiporealizopcreditoreceb = 0;
	var $si191_tiporealizopcreditoassundir = 0;
	var $si191_tiporealizopcreditoassunobg = 0;
	var $si191_mes = 0;
	var $si191_instit = 0;
	var $si191_reg10 = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
   				 si191_sequencial = int8 = Sequencial
   				 si191_tiporegistro = int2 = Tipo registro
                 si191_contopcredito = int4 = Contratação de operação de crédito
                 si191_dsccontopcredito = text = Descrição da ocorrência
                 si191_realizopcredito = int4 = operações de crédito vedadas
                 si191_tiporealizopcreditocapta = int4 = Tipo da realização de operações de créd
                 si191_tiporealizopcreditoreceb = int4 = Tipo da realização de operações de créd
                 si191_tiporealizopcreditoassundir = int4 = Tipo da realização de operações de créd
                 si191_tiporealizopcreditoassunobg = int4 = Tipo da realização de operações de créd
                 si191_mes = int2 = Mês de referência
                 si191_instit = int8 = Instituição
                 si191_reg10 = int4 = Sequencial DCLRF
                 ";
   //funcao construtor da classe
   function cl_dclrf202021() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dclrf202021");
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
	    $this->si191_sequencial = ($this->si191_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_sequencial"]:$this->si191_sequencial);
		$this->si191_tiporegistro = ($this->si191_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_tiporegistro"]:$this->si191_tiporegistro);
		$this->si191_contopcredito = ($this->si191_contopcredito == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_contopcredito"]:$this->si191_contopcredito);
		$this->si191_dsccontopcredito = ($this->si191_dsccontopcredito == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_dsccontopcredito"]:$this->si191_dsccontopcredito);
		$this->si191_realizopcredito = ($this->si191_realizopcredito == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_realizopcredito"]:$this->si191_realizopcredito);
		$this->si191_tiporealizopcreditocapta = ($this->si191_tiporealizopcreditocapta == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_tiporealizopcreditocapta"]:$this->si191_tiporealizopcreditocapta);
		$this->si191_tiporealizopcreditoreceb = ($this->si191_tiporealizopcreditoreceb == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_tiporealizopcreditoreceb"]:$this->si191_tiporealizopcreditoreceb);
		$this->si191_tiporealizopcreditoassundir = ($this->si191_tiporealizopcreditoassundir == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_tiporealizopcreditoassundir"]:$this->si191_tiporealizopcreditoassundir);
		$this->si191_tiporealizopcreditoassunobg = ($this->si191_tiporealizopcreditoassunobg == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_tiporealizopcreditoassunobg"]:$this->si191_tiporealizopcreditoassunobg);
		$this->si191_reg10 = ($this->si191_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_reg10"]:$this->si191_reg10);
		$this->si191_mes = ($this->si191_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_mes"]:$this->si191_mes);
		$this->si191_instit = ($this->si191_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_instit"]:$this->si191_instit);
	 }else{
		$this->si191_sequencial = ($this->si191_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si191_sequencial"]:$this->si191_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si191_sequencial){
     $this->atualizacampos();
     if($this->si191_reg10 == null ){
       $this->erro_sql = " Campo Sequencial DCLRF nao Informado.";
       $this->erro_campo = "si191_reg10";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si191_contopcredito == null ){
       $this->erro_sql = " Campo Contratação de operação de crédito nao Informado.";
       $this->erro_campo = "si191_contopcredito";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
//     if($this->si191_dsccontopcredito == null ){
//       $this->erro_sql = " Campo Descrição da ocorrência nao Informado.";
//       $this->erro_campo = "si191_dsccontopcredito";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
     if($this->si191_realizopcredito == null ){
       $this->erro_sql = " Campo operações de crédito vedadas nao Informado.";
       $this->erro_campo = "si191_realizopcredito";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si191_tiporealizopcreditocapta == null ){
       $this->erro_sql = " Campo Tipo da realização de operações de créd nao Informado.";
       $this->erro_campo = "si191_tiporealizopcreditocapta";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si191_tiporealizopcreditoreceb == null ){
       $this->erro_sql = " Campo Tipo da realização de operações de créd nao Informado.";
       $this->erro_campo = "si191_tiporealizopcreditoreceb";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si191_tiporealizopcreditoassundir == null ){
       $this->erro_sql = " Campo Tipo da realização de operações de créd nao Informado.";
       $this->erro_campo = "si191_tiporealizopcreditoassundir";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si191_tiporealizopcreditoassunobg == null ){
       $this->erro_sql = " Campo Tipo da realização de operações de créd nao Informado.";
       $this->erro_campo = "si191_tiporealizopcreditoassunobg";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si191_tiporegistro == null ){
       $this->erro_sql = " Campo Tipo registro nao Informado.";
       $this->erro_campo = "si191_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
	 if($this->si191_mes == null ){
	 	$this->erro_sql = " Campo Mês de Referência não Informado.";
		$this->erro_campo = "si191_mes";
		$this->erro_banco = "";
		$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
		$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
		$this->erro_status = "0";
		return false;
	 }
	   if($si191_sequencial == "" || $si191_sequencial == null ){
		   $result = @pg_query("select nextval('dclrf202021_si191_sequencial_seq')");
		   if($result==false){
			   $this->erro_banco = str_replace("\n","",@pg_last_error());
			   $this->erro_sql   = "Verifique o cadastro da sequencia: dclrf202021_si191_sequencial_seq do campo: si191_sequencial";
			   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			   $this->erro_status = "0";
			   return false;
		   }
		   $this->si191_sequencial = pg_result($result,0,0);
	   }else{
		   $result = @pg_query("select last_value from dclrf202021_si191_sequencial_seq");
		   if(($result != false) && (pg_result($result,0,0) < $si191_sequencial)){
			   $this->erro_sql = " Campo si191_sequencial maior que último número da sequencia.";
			   $this->erro_banco = "Sequencia menor que este número.";
			   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			   $this->erro_status = "0";
			   return false;
		   }else{
			   $this->si191_sequencial = $si191_sequencial;
		   }
	   }

     $sql ="insert into dclrf202021(
                                       si191_sequencial
                                      ,si191_tiporegistro
                                      ,si191_contopcredito
                                      ,si191_dsccontopcredito
                                      ,si191_realizopcredito
                                      ,si191_tiporealizopcreditocapta
                                      ,si191_tiporealizopcreditoreceb
                                      ,si191_tiporealizopcreditoassundir
                                      ,si191_tiporealizopcreditoassunobg
                                      ,si191_mes
                                      ,si191_instit
                                      ,si191_reg10
                       )
                values (
                				$this->si191_sequencial
                               ,$this->si191_tiporegistro
                               ,$this->si191_contopcredito
                               ,'$this->si191_dsccontopcredito'
                               ,$this->si191_realizopcredito
                               ,$this->si191_tiporealizopcreditocapta
                               ,$this->si191_tiporealizopcreditoreceb
                               ,$this->si191_tiporealizopcreditoassunobg
                               ,$this->si191_tiporealizopcreditoassundir
                               ,$this->si191_mes
                               ,$this->si191_instit
                               ,$this->si191_reg10
                      )";
       $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
		   $this->erro_sql   = "dclrf202021 ($this->si191_sequencial) nao Incluído. Inclusao Abortada.";
		   $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
		   $this->erro_banco = "dclrf202021 já Cadastrado";
		   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
	   }else{
		   $this->erro_sql   = "dclrf202021 ($this->si191_sequencial) nao Incluído. Inclusao Abortada.";
		   $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
		   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
	   }
		 $this->erro_status = "0";
		 $this->numrows_incluir= 0;
		 return false;
	 }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
	 $this->erro_sql .= "Valores : ".$this->si191_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   }
   // funcao para alteracao
   function alterar ($si191_sequencial=null ) {
     $this->atualizacampos();
     $sql = " update dclrf202021 set ";
     $virgula = "";
     if(trim($this->si191_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si191_sequencial"])){
        if(trim($this->si191_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si191_sequencial"])){
           $this->si191_sequencial = "0" ;
        }
       $sql  .= $virgula." si191_sequencial = $this->si191_sequencial ";
       $virgula = ",";
     }
	 if(trim($this->si191_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si191_tiporegistro"])){
		$sql  .= $virgula." si191_tiporegistro = $this->si191_tiporegistro ";
	 	$virgula = ",";
	    if(trim($this->si191_tiporegistro) == null ){
			$this->erro_sql = " Campo Tipo registro nao Informado.";
			$this->erro_campo = "si191_tiporegistro";
			$this->erro_banco = "";
			$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
			$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
			$this->erro_status = "0";
			return false;
	   }
	 }
	 if(trim($this->si191_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si191_reg10"])){
	 	if(trim($this->si191_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si191_reg10"])){
			$this->si191_reg10 = "0" ;
		}
		$sql  .= $virgula." si191_reg10 = $this->si191_reg10 ";
		$virgula = ",";
	 }

     if(trim($this->si191_contopcredito)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si191_contopcredito"])){
        if(trim($this->si191_contopcredito)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si191_contopcredito"])){
           $this->si191_contopcredito = "0" ;
        }
       $sql  .= $virgula." si191_contopcredito = $this->si191_contopcredito ";
       $virgula = ",";
       if(trim($this->si191_contopcredito) == null ){
         $this->erro_sql = " Campo Contratação de operação de crédito nao Informado.";
         $this->erro_campo = "si191_contopcredito";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si191_dsccontopcredito)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si191_dsccontopcredito"])){
       $sql  .= $virgula." si191_dsccontopcredito = '$this->si191_dsccontopcredito' ";
       $virgula = ",";
       if(trim($this->si191_dsccontopcredito) == null ){
         $this->erro_sql = " Campo Descrição da ocorrência nao Informado.";
         $this->erro_campo = "si191_dsccontopcredito";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si191_realizopcredito)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si191_realizopcredito"])){
        if(trim($this->si191_realizopcredito)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si191_realizopcredito"])){
           $this->si191_realizopcredito = "0" ;
        }
       $sql  .= $virgula." si191_realizopcredito = $this->si191_realizopcredito ";
       $virgula = ",";
       if(trim($this->si191_realizopcredito) == null ){
         $this->erro_sql = " Campo operações de crédito vedadas nao Informado.";
         $this->erro_campo = "si191_realizopcredito";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si191_tiporealizopcreditocapta)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si191_tiporealizopcreditocapta"])){
        if(trim($this->si191_tiporealizopcreditocapta)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si191_tiporealizopcreditocapta"])){
           $this->si191_tiporealizopcreditocapta = "0" ;
        }
       $sql  .= $virgula." si191_tiporealizopcreditocapta = $this->si191_tiporealizopcreditocapta ";
       $virgula = ",";
       if(trim($this->si191_tiporealizopcreditocapta) == null ){
         $this->erro_sql = " Campo Tipo da realização de operações de créd nao Informado.";
         $this->erro_campo = "si191_tiporealizopcreditocapta";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si191_tiporealizopcreditoreceb)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si191_tiporealizopcreditoreceb"])){
        if(trim($this->si191_tiporealizopcreditoreceb)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si191_tiporealizopcreditoreceb"])){
           $this->si191_tiporealizopcreditoreceb = "0" ;
        }
       $sql  .= $virgula." si191_tiporealizopcreditoreceb = $this->si191_tiporealizopcreditoreceb ";
       $virgula = ",";
       if(trim($this->si191_tiporealizopcreditoreceb) == null ){
         $this->erro_sql = " Campo Tipo da realização de operações de créd nao Informado.";
         $this->erro_campo = "si191_tiporealizopcreditoreceb";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si191_tiporealizopcreditoassundir)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si191_tiporealizopcreditoassundir"])){
        if(trim($this->si191_tiporealizopcreditoassundir)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si191_tiporealizopcreditoassundir"])){
           $this->si191_tiporealizopcreditoassundir = "0" ;
        }
       $sql  .= $virgula." si191_tiporealizopcreditoassundir = $this->si191_tiporealizopcreditoassundir ";
       $virgula = ",";
       if(trim($this->si191_tiporealizopcreditoassundir) == null ){
         $this->erro_sql = " Campo Tipo da realização de operações de créd nao Informado.";
         $this->erro_campo = "si191_tiporealizopcreditoassundir";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si191_tiporealizopcreditoassunobg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si191_tiporealizopcreditoassunobg"])){
        if(trim($this->si191_tiporealizopcreditoassunobg)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si191_tiporealizopcreditoassunobg"])){
           $this->si191_tiporealizopcreditoassunobg = "0" ;
        }
       $sql  .= $virgula." si191_tiporealizopcreditoassunobg = $this->si191_tiporealizopcreditoassunobg ";
       $virgula = ",";
       if(trim($this->si191_tiporealizopcreditoassunobg) == null ){
         $this->erro_sql = " Campo Tipo da realização de operações de créd nao Informado.";
         $this->erro_campo = "si191_tiporealizopcreditoassunobg";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si191_sequencial!=null){
		 $sql .= " si191_sequencial = $this->si191_sequencial";
	 }
     $result = @pg_exec($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Informações Sobre Operações de Crédito nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
	   $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Informações Sobre Operações de Crédito nao foi Alterado. Alteracao Executada.\\n";
		 $this->erro_sql .= "Valores : ".$this->si191_sequencial;
		 $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
		 $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
		 $this->erro_sql .= "Valores : ".$this->si191_sequencial;
		 $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
		 $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si191_sequencial=null,$dbwhere=null) {
     $sql = " delete from dclrf202021
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere == ""){
     	if($si191_sequencial != ''){
     		if($sql2!=''){
     			$sql2 .= " and ";
			}
			$sql2 .= " si191_sequencial = $si191_sequencial ";
		}
	 }else{
     	$sql2 = $dbwhere;
	 }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Informações Sobre Operações de Crédito nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Informações Sobre Operações de Crédito nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Dados do Grupo nao Encontrado";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si191_sequencial = null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf202021 ";
	 $sql .= " 		left join dclrf102020 on dclrf102020.si157_sequencial = dclrf202021.si191_reg10 ";
     $sql2 = "";
     if($dbwhere==""){
       if( $si191_sequencial != null){
          $sql2 .= " where dclrf202021.si191_sequencial = $si191_sequencial";
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
   function sql_query_file ( $si191_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf202021 ";
     $sql2 = "";
     if($dbwhere==""){
	 	if($si191_sequencial!=null) {
			$sql2 .= " where dclrf202021.si191_sequencial = $si191_sequencial ";
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
