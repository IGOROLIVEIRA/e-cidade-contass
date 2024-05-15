<?
//MODULO: sicom
//CLASSE DA ENTIDADE ctb212023
class cl_ctb212023 { 
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
   var $si97_sequencial = 0; 
   var $si97_tiporegistro = 0; 
   var $si97_codctb = 0; 
   var $si97_codfontrecursos = 0; 
   var $si97_codreduzidomov = 0; 
   var $si97_tipomovimentacao = 0; 
   var $si97_tipoentrsaida = null; 
   var $si97_valorentrsaida = 0;
   var $si97_dscoutrasmov = null;
   var $si97_saldocec = 0;
   var $si97_codctbtransf = 0; 
   var $si97_codfontectbtransf = 0; 
   var $si97_saldocectransf = 0;
   var $si97_codidentificafr = null;
   var $si97_mes = 0; 
   var $si97_reg20 = 0; 
   var $si97_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si97_sequencial = int8 = sequencial 
                 si97_tiporegistro = int8 = Tipo do  registro 
                 si97_codctb = int8 = Código Identificador da Conta Bancária 
                 si97_codfontrecursos = int8 = Código da fonte de  recursos 
                 si97_codreduzidomov = int8 = Código Identificador da Movimentação 
                 si97_tipomovimentacao = int8 = Tipo de  movimentação 
                 si97_tipoentrsaida = varchar(2) = Tipo de entrada ou  saída 
                 si97_valorentrsaida = float8 = Valor correspondente à entrada/saída
                 si97_dscoutrasmov = varchar(50) = Descrição de outras movimentações 
                 si97_saldocec = int8 = Saldo compõe ou não compõe Caixa e Equivalentes de Caixa
                 si97_codctbtransf = int8 = Código Identificador da Conta Bancária 
                 si97_codfontectbtransf = int8 = Código da fonte de recursos ctb 
                 si97_saldocectransf = int8 = A conta de onde saiu ou entrou recurso compõe ou não compõe Caixa e Equivalentes de Caixa
                 si97_codidentificafr = int8 = Código identificador da movimentação de reclassificação de entrada e saída
                 si97_mes = int8 = Mês 
                 si97_reg20 = int8 = reg20 
                 si97_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ctb212023() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ctb212023"); 
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
       $this->si97_sequencial = ($this->si97_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_sequencial"]:$this->si97_sequencial);
       $this->si97_tiporegistro = ($this->si97_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_tiporegistro"]:$this->si97_tiporegistro);
       $this->si97_codctb = ($this->si97_codctb == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_codctb"]:$this->si97_codctb);
       $this->si97_codfontrecursos = ($this->si97_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_codfontrecursos"]:$this->si97_codfontrecursos);
       $this->si97_codreduzidomov = ($this->si97_codreduzidomov == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_codreduzidomov"]:$this->si97_codreduzidomov);
       $this->si97_tipomovimentacao = ($this->si97_tipomovimentacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_tipomovimentacao"]:$this->si97_tipomovimentacao);
       $this->si97_tipoentrsaida = ($this->si97_tipoentrsaida == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_tipoentrsaida"]:$this->si97_tipoentrsaida);
       $this->si97_dscoutrasmov = ($this->si97_dscoutrasmov == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_dscoutrasmov"]:$this->si97_dscoutrasmov);
       $this->si97_saldocec = ($this->si97_saldocec == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_saldocec"]:$this->si97_saldocec);
       $this->si97_valorentrsaida = ($this->si97_valorentrsaida == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_valorentrsaida"]:$this->si97_valorentrsaida);
       $this->si97_codctbtransf = ($this->si97_codctbtransf == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_codctbtransf"]:$this->si97_codctbtransf);
       $this->si97_codfontectbtransf = ($this->si97_codfontectbtransf == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_codfontectbtransf"]:$this->si97_codfontectbtransf);
       $this->si97_saldocectransf = ($this->si97_saldocectransf == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_saldocectransf"]:$this->si97_saldocectransf);
       $this->si97_codidentificafr = ($this->si97_codidentificafr == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_codidentificafr"]:$this->si97_codidentificafr);
       $this->si97_mes = ($this->si97_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_mes"]:$this->si97_mes);
       $this->si97_reg20 = ($this->si97_reg20 == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_reg20"]:$this->si97_reg20);
       $this->si97_instit = ($this->si97_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_instit"]:$this->si97_instit);
     }else{
       $this->si97_sequencial = ($this->si97_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_sequencial"]:$this->si97_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si97_sequencial){ 
      $this->atualizacampos();
     if($this->si97_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si97_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si97_codctb == null ){ 
       $this->si97_codctb = "0";
     }
     if($this->si97_codfontrecursos == null ){ 
       $this->si97_codfontrecursos = "0";
     }
     if($this->si97_codreduzidomov == null ){ 
       $this->si97_codreduzidomov = "0";
     }
     if($this->si97_tipomovimentacao == null ){ 
       $this->si97_tipomovimentacao = "0";
     }
     if($this->si97_valorentrsaida == null ){ 
       $this->si97_valorentrsaida = "0";
	 }
	 if($this->si97_saldocec == null ){ 
		$this->si97_saldocec = "0";
	 }
     if($this->si97_codctbtransf == null ){ 
       $this->si97_codctbtransf = "0";
     }
     if($this->si97_codfontectbtransf == null ){ 
       $this->si97_codfontectbtransf = "0";
	 }
	 if($this->si97_saldocectransf == null ){ 
		$this->si97_saldocectransf = "0";
	 }
	 if($this->si97_codidentificafr == null ){ 
		$this->si97_codidentificafr = null;
	 }
     if($this->si97_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si97_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si97_reg20 == null ){ 
       $this->si97_reg20 = "0";
     }
     if($this->si97_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si97_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($si97_sequencial == "" || $si97_sequencial == null ){
       $result = db_query("select nextval('ctb212023_si97_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ctb212023_si97_sequencial_seq do campo: si97_sequencial"; 
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si97_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ctb212023_si97_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si97_sequencial)){
         $this->erro_sql = " Campo si97_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si97_sequencial = $si97_sequencial; 
       }
     }
     if(($this->si97_sequencial == null) || ($this->si97_sequencial == "") ){ 
       $this->erro_sql = " Campo si97_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ctb212023(
                                       si97_sequencial 
                                      ,si97_tiporegistro 
                                      ,si97_codctb 
                                      ,si97_codfontrecursos 
                                      ,si97_codreduzidomov 
                                      ,si97_tipomovimentacao 
                                      ,si97_tipoentrsaida 
									                    ,si97_dscoutrasmov
									                    ,si97_saldocec
                                      ,si97_valorentrsaida 
                                      ,si97_codctbtransf 
									                    ,si97_codfontectbtransf 
									                    ,si97_saldocectransf
									                    ,si97_codidentificafr
                                      ,si97_mes 
                                      ,si97_reg20 
                                      ,si97_instit 
                       )
                values (
                                $this->si97_sequencial 
                               ,$this->si97_tiporegistro 
                               ,$this->si97_codctb 
                               ,$this->si97_codfontrecursos 
                               ,$this->si97_codreduzidomov 
                               ,$this->si97_tipomovimentacao 
                               ,'$this->si97_tipoentrsaida' 
							                 ,'$this->si97_dscoutrasmov'
							                 ,$this->si97_saldocec
                               ,$this->si97_valorentrsaida 
                               ,$this->si97_codctbtransf 
							                 ,$this->si97_codfontectbtransf 
							                 ,$this->si97_saldocectransf
							                 ,$this->si97_codidentificafr
                               ,$this->si97_mes 
                               ,$this->si97_reg20 
                               ,$this->si97_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ctb212023 ($this->si97_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "ctb212023 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "ctb212023 ($this->si97_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
     $this->erro_sql .= "Valores : ".$this->si97_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     /*$resaco = $this->sql_record($this->sql_query_file($this->si97_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010569,'$this->si97_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010326,2010569,'','".AddSlashes(pg_result($resaco,0,'si97_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010570,'','".AddSlashes(pg_result($resaco,0,'si97_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010571,'','".AddSlashes(pg_result($resaco,0,'si97_codctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2011320,'','".AddSlashes(pg_result($resaco,0,'si97_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010572,'','".AddSlashes(pg_result($resaco,0,'si97_codreduzidomov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010573,'','".AddSlashes(pg_result($resaco,0,'si97_tipomovimentacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010574,'','".AddSlashes(pg_result($resaco,0,'si97_tipoentrsaida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010576,'','".AddSlashes(pg_result($resaco,0,'si97_valorentrsaida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010577,'','".AddSlashes(pg_result($resaco,0,'si97_codctbtransf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2011321,'','".AddSlashes(pg_result($resaco,0,'si97_codfontectbtransf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010578,'','".AddSlashes(pg_result($resaco,0,'si97_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2011322,'','".AddSlashes(pg_result($resaco,0,'si97_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2011609,'','".AddSlashes(pg_result($resaco,0,'si97_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }*/
     return true;
   } 
   // funcao para alteracao
   function alterar ($si97_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ctb212023 set ";
     $virgula = "";
     if(trim($this->si97_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_sequencial"])){ 
        if(trim($this->si97_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_sequencial"])){ 
           $this->si97_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si97_sequencial = $this->si97_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si97_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_tiporegistro"])){ 
       $sql  .= $virgula." si97_tiporegistro = $this->si97_tiporegistro ";
       $virgula = ",";
       if(trim($this->si97_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si97_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si97_codctb)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_codctb"])){ 
        if(trim($this->si97_codctb)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_codctb"])){ 
           $this->si97_codctb = "0" ; 
        } 
       $sql  .= $virgula." si97_codctb = $this->si97_codctb ";
       $virgula = ",";
     }
     if(trim($this->si97_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_codfontrecursos"])){ 
        if(trim($this->si97_codfontrecursos)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_codfontrecursos"])){ 
           $this->si97_codfontrecursos = "0" ; 
        } 
       $sql  .= $virgula." si97_codfontrecursos = $this->si97_codfontrecursos ";
       $virgula = ",";
     }
     if(trim($this->si97_codreduzidomov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_codreduzidomov"])){ 
        if(trim($this->si97_codreduzidomov)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_codreduzidomov"])){ 
           $this->si97_codreduzidomov = "0" ; 
        } 
       $sql  .= $virgula." si97_codreduzidomov = $this->si97_codreduzidomov ";
       $virgula = ",";
     }
     if(trim($this->si97_tipomovimentacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_tipomovimentacao"])){ 
        if(trim($this->si97_tipomovimentacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_tipomovimentacao"])){ 
           $this->si97_tipomovimentacao = "0" ; 
        } 
       $sql  .= $virgula." si97_tipomovimentacao = $this->si97_tipomovimentacao ";
       $virgula = ",";
     }
     if(trim($this->si97_tipoentrsaida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_tipoentrsaida"])){ 
       $sql  .= $virgula." si97_tipoentrsaida = '$this->si97_tipoentrsaida' ";
       $virgula = ",";
     }
     if(trim($this->si97_dscoutrasmov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_dscoutrasmov"])){
       $sql  .= $virgula." si97_dscoutrasmov = '$this->si97_dscoutrasmov' ";
       $virgula = ",";
	 }
	 if(trim($this->si97_saldocec)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_saldocec"])){
		$sql  .= $virgula." si97_saldocec = '$this->si97_saldocec' ";
		$virgula = ",";
	 }
     if(trim($this->si97_valorentrsaida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_valorentrsaida"])){ 
        if(trim($this->si97_valorentrsaida)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_valorentrsaida"])){ 
           $this->si97_valorentrsaida = "0" ; 
        } 
       $sql  .= $virgula." si97_valorentrsaida = $this->si97_valorentrsaida ";
       $virgula = ",";
     }
     if(trim($this->si97_codctbtransf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_codctbtransf"])){ 
        if(trim($this->si97_codctbtransf)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_codctbtransf"])){ 
           $this->si97_codctbtransf = "0" ; 
        } 
       $sql  .= $virgula." si97_codctbtransf = $this->si97_codctbtransf ";
       $virgula = ",";
     }
     if(trim($this->si97_codfontectbtransf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_codfontectbtransf"])){ 
        if(trim($this->si97_codfontectbtransf)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_codfontectbtransf"])){ 
           $this->si97_codfontectbtransf = "0" ; 
        } 
       $sql  .= $virgula." si97_codfontectbtransf = $this->si97_codfontectbtransf ";
       $virgula = ",";
	 }
	 if(trim($this->si97_saldocectransf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_saldocectransf"])){
		$sql  .= $virgula." si97_saldocectransf = '$this->si97_saldocectransf' ";
		$virgula = ",";
	 }
	 if(trim($this->si97_codidentificafr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_codidentificafr"])){
		$sql  .= $virgula." si97_codidentificafr = '$this->si97_codidentificafr' ";
		$virgula = ",";
	 }
     if(trim($this->si97_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_mes"])){ 
       $sql  .= $virgula." si97_mes = $this->si97_mes ";
       $virgula = ",";
       if(trim($this->si97_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si97_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si97_reg20)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_reg20"])){ 
        if(trim($this->si97_reg20)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_reg20"])){ 
           $this->si97_reg20 = "0" ; 
        } 
       $sql  .= $virgula." si97_reg20 = $this->si97_reg20 ";
       $virgula = ",";
     }
     if(trim($this->si97_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_instit"])){ 
       $sql  .= $virgula." si97_instit = $this->si97_instit ";
       $virgula = ",";
       if(trim($this->si97_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si97_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si97_sequencial!=null){
       $sql .= " si97_sequencial = $si97_sequencial";
     }
     /*$resaco = $this->sql_record($this->sql_query_file($this->si97_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010569,'$this->si97_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_sequencial"]) || $this->si97_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010569,'".AddSlashes(pg_result($resaco,$conresaco,'si97_sequencial'))."','$this->si97_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_tiporegistro"]) || $this->si97_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010570,'".AddSlashes(pg_result($resaco,$conresaco,'si97_tiporegistro'))."','$this->si97_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_codctb"]) || $this->si97_codctb != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010571,'".AddSlashes(pg_result($resaco,$conresaco,'si97_codctb'))."','$this->si97_codctb',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_codfontrecursos"]) || $this->si97_codfontrecursos != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2011320,'".AddSlashes(pg_result($resaco,$conresaco,'si97_codfontrecursos'))."','$this->si97_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_codreduzidomov"]) || $this->si97_codreduzidomov != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010572,'".AddSlashes(pg_result($resaco,$conresaco,'si97_codreduzidomov'))."','$this->si97_codreduzidomov',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_tipomovimentacao"]) || $this->si97_tipomovimentacao != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010573,'".AddSlashes(pg_result($resaco,$conresaco,'si97_tipomovimentacao'))."','$this->si97_tipomovimentacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_tipoentrsaida"]) || $this->si97_tipoentrsaida != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010574,'".AddSlashes(pg_result($resaco,$conresaco,'si97_tipoentrsaida'))."','$this->si97_tipoentrsaida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_valorentrsaida"]) || $this->si97_valorentrsaida != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010576,'".AddSlashes(pg_result($resaco,$conresaco,'si97_valorentrsaida'))."','$this->si97_valorentrsaida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_codctbtransf"]) || $this->si97_codctbtransf != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010577,'".AddSlashes(pg_result($resaco,$conresaco,'si97_codctbtransf'))."','$this->si97_codctbtransf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_codfontectbtransf"]) || $this->si97_codfontectbtransf != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2011321,'".AddSlashes(pg_result($resaco,$conresaco,'si97_codfontectbtransf'))."','$this->si97_codfontectbtransf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_mes"]) || $this->si97_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010578,'".AddSlashes(pg_result($resaco,$conresaco,'si97_mes'))."','$this->si97_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_reg20"]) || $this->si97_reg20 != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2011322,'".AddSlashes(pg_result($resaco,$conresaco,'si97_reg20'))."','$this->si97_reg20',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_instit"]) || $this->si97_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2011609,'".AddSlashes(pg_result($resaco,$conresaco,'si97_instit'))."','$this->si97_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }*/
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "ctb212023 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si97_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ctb212023 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si97_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si97_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si97_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si97_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     /*if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010569,'$si97_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010326,2010569,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010570,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010571,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_codctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2011320,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010572,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_codreduzidomov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010573,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_tipomovimentacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010574,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_tipoentrsaida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010576,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_valorentrsaida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010577,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_codctbtransf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2011321,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_codfontectbtransf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010578,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2011322,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2011609,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }*/
     $sql = " delete from ctb212023
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si97_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si97_sequencial = $si97_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "ctb212023 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si97_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ctb212023 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si97_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si97_sequencial;
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
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:ctb212023";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si97_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ctb212023 ";
     $sql .= "      left  join ctb202020  on  ctb202020.si96_sequencial = ctb212023.si97_reg20";
     $sql2 = "";
     if($dbwhere==""){
       if($si97_sequencial!=null ){
         $sql2 .= " where ctb212023.si97_sequencial = $si97_sequencial "; 
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
   function sql_query_file ( $si97_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ctb212023 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si97_sequencial!=null ){
         $sql2 .= " where ctb212023.si97_sequencial = $si97_sequencial "; 
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

  /**
   * Consulta principal para geracao do Registro 21
   *
   * @param string $dataFinal
   * @param integer $ano
   * @param integer $mes
   * @param integer $codctb
   * @param integer $fonte
   * @return $sSqlReg21
   */
  public function sql_Reg21($dataFinal, $ano, $mes, $codctb, $fonte)
  {
    $sSqlReg21 = "SELECT * FROM
                      (SELECT '21' AS tiporegistro,
                              c71_codlan AS codreduzido,
                              contacredito.c61_reduz AS codctb,
                              conplanodebito.c60_codsis AS codsisctb,
                              contacreditofonte.o15_codtri AS codfontrecurso,
                              2 AS tipomovimentacao,
                              (bancodebito.c63_conta||bancodebito.c63_dvconta)AS bancodebito_c63_conta,
                              bancodebito.c63_tipoconta AS bancodebito_c63_tipoconta,
                              (bancocredito.c63_conta||bancocredito.c63_dvconta) AS bancocredito_c63_conta,
                              bancocredito.c63_tipoconta AS bancocredito_c63_tipoconta,
                              CASE
                                  WHEN c71_coddoc IN (101, 116) AND substr(o57_fonte,0,3) = '49' THEN 2
                                  WHEN c71_coddoc = 101 THEN 3
                                  WHEN c71_coddoc IN (35, 37)
                                      AND
                                          (SELECT sum(CASE
                                                          WHEN c53_tipo = 31 THEN -1 * c70_valor
                                                          ELSE c70_valor
                                                      END) AS valor
                                            FROM conlancamdoc
                                            JOIN conhistdoc ON c53_coddoc = c71_coddoc
                                            JOIN conlancamord ON c71_codlan = c80_codlan
                                            JOIN conlancam ON c70_codlan = c71_codlan
                                            WHERE c53_tipo IN (31, 30)
                                              AND c70_data <= '{$dataFinal}'
                                              AND c80_codord =
                                                    (SELECT c80_codord FROM conlancamord
                                                      WHERE c80_codlan=c69_codlan
                                                      LIMIT 1)) >= 0
                                      OR c71_coddoc = 5
                                      AND
                                          (SELECT sum(CASE
                                                          WHEN c53_tipo = 31 THEN -1 * c70_valor
                                                          ELSE c70_valor
                                                      END) AS valor
                                            FROM conlancamdoc
                                            JOIN conhistdoc ON c53_coddoc = c71_coddoc
                                            JOIN conlancamord ON c71_codlan = c80_codlan
                                            JOIN conlancam ON c70_codlan = c71_codlan
                                            WHERE c53_tipo IN (31, 30)
                                              AND c70_data <= '{$dataFinal}'
                                              AND c80_codord =
                                                    (SELECT c80_codord FROM conlancamord
                                                    WHERE c80_codlan=c69_codlan
                                                    LIMIT 1)) >= 0 THEN 8
                                  WHEN c71_coddoc IN (151, 161, 163)
                                      AND
                                          (SELECT k17_situacao FROM slip
                                            JOIN conlancamslip ON k17_codigo = c84_slip
                                            JOIN conlancamdoc ON c71_codlan = c84_conlancam
                                            WHERE c71_codlan=c69_codlan
                                                AND c71_coddoc IN (151, 161, 163)
                                            LIMIT 1) IN (2, 4) THEN 8
                                  WHEN c71_coddoc IN (131, 152, 162) THEN 10
                                  WHEN c71_coddoc IN (120)
                                      AND
                                          (SELECT k17_situacao FROM slip
                                            JOIN conlancamslip ON k17_codigo = c84_slip
                                            JOIN conlancamdoc ON c71_codlan = c84_conlancam
                                            WHERE c71_codlan=c69_codlan
                                              AND c71_coddoc IN (120)
                                            LIMIT 1) = 2 THEN 13
                                  WHEN c71_coddoc IN (141, 140) AND k131_concarpeculiar = '095' THEN 95
                                  WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta = 1 AND bancocredito.c63_tipoconta IN (2, 3) THEN 7
                                  WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta IN (2, 3) AND bancocredito.c63_tipoconta = 1 THEN 9
                                  WHEN c71_coddoc IN (141, 140) THEN 6
                                  ELSE 99
                              END AS tipoentrsaida,
                              substr(o57_fonte,0,3) AS rubrica,
                              conlancamval.c69_valor AS valorentrsaida,
                              CASE
                                  WHEN substr(conplanocredito.c60_estrut, 1, 3) = '111'
                                      AND substr(conplanocredito.c60_estrut, 1, 7) != '1111101'
                                      AND substr(conplanocredito.c60_estrut, 1, 7) != '1111102'
                                      AND substr(conplanocredito.c60_estrut, 1, 6) != '111113'
                                      AND substr(conplanocredito.c60_estrut, 1, 7) != '1112101' THEN 1
                                  ELSE 2
                              END AS saldocec,
                              CASE
                                  WHEN c71_coddoc IN (140, 141) THEN contadebito.c61_reduz
                                  ELSE 0
                              END AS codctbtransf,
                              CASE
                                  WHEN c71_coddoc IN (140, 141) THEN contacreditofonte.o15_codtri
                                  ELSE '0'
                              END AS codfontectbtransf,
                              CASE
                                  WHEN c71_coddoc IN (140, 141) THEN CASE
                                                                        WHEN substr(conplanodebito.c60_estrut, 1, 3) = '111'
                                                                              AND substr(conplanodebito.c60_estrut, 1, 7) != '1111101'
                                                                              AND substr(conplanodebito.c60_estrut, 1, 7) != '1111102'
                                                                              AND substr(conplanodebito.c60_estrut, 1, 6) != '111113'
                                                                              AND substr(conplanodebito.c60_estrut, 1, 7) != '1112101' THEN 1
                                                                        ELSE 2
                                                                    END
                                  ELSE 0
                              END AS saldocectransf,
                              c71_coddoc,
                              c71_codlan,
                              CASE
                                  WHEN c71_coddoc IN (5, 35, 37, 6, 36, 38) THEN fontempenho.o15_codtri
                                  WHEN c71_coddoc IN (100, 101, 115, 116) THEN fontereceita.o15_codtri
                                  ELSE contacreditofonte.o15_codtri
                              END AS fontemovimento,
                              CASE
                                  WHEN c72_complem ILIKE 'Referente%'
                                      AND c71_coddoc IN (5, 35, 37, 6, 36, 38) THEN 1
                                  ELSE 0
                              END AS retencao,
                              k131_concarpeculiar
                      FROM conlancamdoc
                      INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
                      INNER JOIN conplanoreduz contadebito ON contadebito.c61_reduz = conlancamval.c69_debito AND contadebito.c61_anousu = conlancamval.c69_anousu
                      LEFT JOIN conplanoconta bancodebito ON (bancodebito.c63_codcon, bancodebito.c63_anousu) = (contadebito.c61_codcon, contadebito.c61_anousu)
                            AND contadebito.c61_reduz = conlancamval.c69_debito
                      INNER JOIN conplanoreduz contacredito ON contacredito.c61_reduz = conlancamval.c69_credito AND contacredito.c61_anousu = conlancamval.c69_anousu
                      INNER JOIN conplano conplanocredito ON contacredito.c61_codcon = conplanocredito.c60_codcon AND contacredito.c61_anousu = conplanocredito.c60_anousu
                      INNER JOIN conplano conplanodebito ON contacredito.c61_codcon = conplanodebito.c60_codcon AND contacredito.c61_anousu = conplanodebito.c60_anousu
                      LEFT JOIN conplanoconta bancocredito ON (bancocredito.c63_codcon, bancocredito.c63_anousu) = (contacredito.c61_codcon, contacredito.c61_anousu)
                            AND contacredito.c61_reduz = conlancamval.c69_credito
                      LEFT JOIN conlancamemp ON conlancamemp.c75_codlan = conlancamdoc.c71_codlan
                      LEFT JOIN empempenho ON empempenho.e60_numemp = conlancamemp.c75_numemp
                      LEFT JOIN orcdotacao ON orcdotacao.o58_anousu = empempenho.e60_anousu AND orcdotacao.o58_coddot = empempenho.e60_coddot
                      LEFT JOIN orctiporec fontempenho ON fontempenho.o15_codigo = orcdotacao.o58_codigo
                      LEFT JOIN orctiporec contacreditofonte ON contacreditofonte.o15_codigo = contacredito.c61_codigo
                      LEFT JOIN orctiporec contadebitofonte ON contadebitofonte.o15_codigo = contadebito.c61_codigo
                      LEFT JOIN conlancamrec ON conlancamrec.c74_codlan = conlancamdoc.c71_codlan
                      LEFT JOIN orcreceita ON orcreceita.o70_codrec = conlancamrec.c74_codrec AND orcreceita.o70_anousu = conlancamrec.c74_anousu
                      LEFT JOIN orcfontes receita ON receita.o57_codfon = orcreceita.o70_codfon AND receita.o57_anousu = orcreceita.o70_anousu
                      LEFT JOIN orctiporec fontereceita ON fontereceita.o15_codigo = orcreceita.o70_codigo
                      LEFT JOIN conlancamcompl ON c72_codlan = c71_codlan
                      LEFT JOIN conlancamslip ON c71_codlan=c84_conlancam
                      LEFT JOIN slipconcarpeculiar ON k131_slip=c84_slip AND k131_tipo=2
                      WHERE DATE_PART('YEAR',conlancamdoc.c71_data) = {$ano}
                          AND DATE_PART('MONTH',conlancamdoc.c71_data) = '{$mes}'
                          AND conlancamval.c69_credito = {$codctb}
                      UNION ALL
                      SELECT '21' AS tiporegistro,
                              c71_codlan AS codreduzido,
                              contadebito.c61_reduz AS codctb,
                              conplanodebito.c60_codsis AS codsisctb,
                              contadebitofonte.o15_codtri AS codfontrecurso,
                              1 AS tipomovimentacao,
                              (bancodebito.c63_conta||bancodebito.c63_dvconta) AS bancodebito_c63_conta,
                              bancodebito.c63_tipoconta AS bancodebito_c63_tipoconta,
                              (bancocredito.c63_conta||bancocredito.c63_dvconta) AS bancocredito_c63_conta,
                              bancocredito.c63_tipoconta AS bancocredito_c63_tipoconta,
                              CASE
                                  WHEN c71_coddoc IN (100, 115) AND substr(o57_fonte,0,3) = '49' THEN 16
                                  WHEN c71_coddoc = 100 AND substr(o57_fonte,2,4) = '1321' AND bancodebito.c63_tipoconta IN (2, 3) THEN 4
                                  WHEN c71_coddoc = 100 THEN 1
                                  WHEN c71_coddoc IN (6, 36, 38, 121, 153, 163) THEN 17
                                  WHEN c71_coddoc IN (131, 152, 162) THEN 10
                                  WHEN c71_coddoc IN (130) THEN 12
                                  WHEN c71_coddoc IN (141, 140) AND k131_concarpeculiar = '096' THEN 96
                                  WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta = 1 AND bancocredito.c63_tipoconta IN (2, 3) THEN 7
                                  WHEN c71_coddoc IN (141, 140) AND bancodebito.c63_tipoconta IN (2, 3) AND bancocredito.c63_tipoconta = 1 THEN 9
                                  WHEN c71_coddoc IN (141, 140) THEN 5
                                  ELSE 99
                              END AS tipoentrsaida,
                              substr(o57_fonte,0,3) AS rubrica,
                              conlancamval.c69_valor AS valorentrsaida,
                              CASE
                                  WHEN substr(conplanocredito.c60_estrut, 1, 3) = '111'
                                      AND substr(conplanocredito.c60_estrut, 1, 7) != '1111101'
                                      AND substr(conplanocredito.c60_estrut, 1, 7) != '1111102'
                                      AND substr(conplanocredito.c60_estrut, 1, 6) != '111113'
                                      AND substr(conplanocredito.c60_estrut, 1, 7) != '1112101' THEN 1
                                  ELSE 2
                              END AS saldocec,
                              CASE
                                  WHEN c71_coddoc IN (140, 141) THEN contacredito.c61_reduz
                                  ELSE 0
                              END AS codctbtransf,
                              CASE
                                  WHEN c71_coddoc IN (140, 141) THEN contacreditofonte.o15_codtri
                                  ELSE '0'
                              END AS codfontectbtransf,
                              CASE
                                  WHEN c71_coddoc IN (140, 141) THEN CASE
                                                                        WHEN substr(conplanodebito.c60_estrut, 1, 3) = '111'
                                                                              AND substr(conplanodebito.c60_estrut, 1, 7) != '1111101'
                                                                              AND substr(conplanodebito.c60_estrut, 1, 7) != '1111102'
                                                                              AND substr(conplanodebito.c60_estrut, 1, 6) != '111113'
                                                                              AND substr(conplanodebito.c60_estrut, 1, 7) != '1112101' THEN 1
                                                                        ELSE 2
                                                                    END
                                  ELSE 0
                              END AS saldocectransf,
                              c71_coddoc,
                              c71_codlan,
                              CASE
                                  WHEN c71_coddoc IN (5, 35, 37, 6, 36, 38) THEN fontempenho.o15_codtri
                                  WHEN c71_coddoc IN (100, 101, 115, 116) THEN fontereceita.o15_codtri
                                  WHEN c71_coddoc IN (140, 141) THEN contacreditofonte.o15_codtri
                                  ELSE contadebitofonte.o15_codtri
                              END AS fontemovimento,
                              CASE
                                  WHEN c72_complem ILIKE 'Referente%'
                                      AND c71_coddoc IN (5, 35, 37, 6, 36, 38) THEN 1
                                  ELSE 0
                              END AS retencao,
                              k131_concarpeculiar
                      FROM conlancamdoc
                      INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
                      INNER JOIN conplanoreduz contadebito ON contadebito.c61_reduz = conlancamval.c69_debito AND contadebito.c61_anousu = conlancamval.c69_anousu
                      INNER JOIN conplano conplanocredito ON contadebito.c61_codcon = conplanocredito.c60_codcon AND contadebito.c61_anousu = conplanocredito.c60_anousu
                      INNER JOIN conplano conplanodebito ON contadebito.c61_codcon = conplanodebito.c60_codcon AND contadebito.c61_anousu = conplanodebito.c60_anousu
                      LEFT JOIN conplanoconta bancodebito ON (bancodebito.c63_codcon, bancodebito.c63_anousu) = (contadebito.c61_codcon, contadebito.c61_anousu)
                            AND contadebito.c61_reduz = conlancamval.c69_debito
                      INNER JOIN conplanoreduz contacredito ON contacredito.c61_reduz = conlancamval.c69_credito AND contacredito.c61_anousu = conlancamval.c69_anousu
                      LEFT JOIN conplanoconta bancocredito ON (bancocredito.c63_codcon,  bancocredito.c63_anousu) = (contacredito.c61_codcon, contacredito.c61_anousu)
                            AND contacredito.c61_reduz = conlancamval.c69_credito
                      LEFT JOIN conlancamemp ON conlancamemp.c75_codlan = conlancamdoc.c71_codlan
                      LEFT JOIN empempenho ON empempenho.e60_numemp = conlancamemp.c75_numemp
                      LEFT JOIN orcdotacao ON orcdotacao.o58_anousu = empempenho.e60_anousu AND orcdotacao.o58_coddot = empempenho.e60_coddot
                      LEFT JOIN orctiporec fontempenho ON fontempenho.o15_codigo = orcdotacao.o58_codigo
                      LEFT JOIN orctiporec contacreditofonte ON contacreditofonte.o15_codigo = contacredito.c61_codigo
                      LEFT JOIN orctiporec contadebitofonte ON contadebitofonte.o15_codigo = contadebito.c61_codigo
                      LEFT JOIN conlancamrec ON conlancamrec.c74_codlan = conlancamdoc.c71_codlan
                      LEFT JOIN orcreceita ON orcreceita.o70_codrec = conlancamrec.c74_codrec AND orcreceita.o70_anousu = conlancamrec.c74_anousu
                      LEFT JOIN orcfontes receita ON receita.o57_codfon = orcreceita.o70_codfon AND receita.o57_anousu = orcreceita.o70_anousu
                      LEFT JOIN orctiporec fontereceita ON fontereceita.o15_codigo = orcreceita.o70_codigo
                      LEFT JOIN conlancamslip ON c71_codlan=c84_conlancam
                      LEFT JOIN slipconcarpeculiar ON k131_slip=c84_slip AND k131_tipo=1
                      LEFT JOIN conlancamcompl ON c72_codlan = c71_codlan WHERE DATE_PART('YEAR',conlancamdoc.c71_data) = {$ano}
                            AND DATE_PART('MONTH',conlancamdoc.c71_data) = '{$mes}'
                            AND conlancamval.c69_debito = {$codctb} ) AS xx
                  WHERE fontemovimento::integer = {$fonte}";

    return $sSqlReg21;
  }

  /**
   * Dados da conta utilizada na transferencia
   *
   * @param integer $instituicao
   * @param integer $ano
   * @param integer $codctbtransf
   * @return $sqlcontatransf
   */
  public function contaTransf($instituicao, $ano, $codctbtransf)
  {
    $sqlcontatransf = "SELECT si09_codorgaotce||(c63_banco::integer)::varchar
                                          ||(c63_agencia::integer)::varchar
                                          ||c63_dvagencia
                                          ||(c63_conta::integer)::varchar
                                          ||c63_dvconta
                                          ||CASE
                                                WHEN db83_tipoconta IN (2, 3) THEN 2
                                                ELSE 1
                                            END AS contadebito,
                                          c61_reduz,
                                          CASE
                                               WHEN db83_tipoconta IN (2, 3) THEN 2
                                               ELSE 1
                                           END AS tipo,
                                           CASE
                                                WHEN (SELECT si09_tipoinstit FROM infocomplementaresinstit
                                                      WHERE si09_instit = $instituicao) = 5 AND db83_tipoconta IN (2, 3)
                                                  THEN db83_tipoaplicacao::varchar
                                                ELSE ''
                                            END AS tipoaplicacao,
                                            CASE
                                                WHEN (SELECT si09_tipoinstit FROM infocomplementaresinstit
                                                      WHERE si09_instit = $instituicao) = 5 AND db83_tipoconta IN (2, 3)
                                                  THEN db83_nroseqaplicacao::varchar
                                                ELSE ''
                                            END AS nroseqaplicacao,
                                          o15_codtri
                                    FROM saltes
                                    JOIN conplanoreduz ON k13_reduz = c61_reduz AND c61_anousu = $ano
                                    JOIN conplanoconta ON c63_codcon = c61_codcon AND c63_anousu = c61_anousu
                                    JOIN orctiporec ON c61_codigo = o15_codigo
                                    LEFT JOIN conplanocontabancaria ON c56_codcon = c61_codcon AND c56_anousu = c61_anousu
                                    LEFT JOIN contabancaria ON c56_contabancaria = db83_sequencial
                                    LEFT JOIN infocomplementaresinstit ON si09_instit = c61_instit
                                    WHERE k13_reduz = {$codctbtransf}";

    return $sqlcontatransf;
  }

  public function sql_codSisReg21($ano, $codctbtransf)
  {
    $sSql = "SELECT c60_codsis FROM saltes
             JOIN conplanoreduz ON k13_reduz = c61_reduz AND c61_anousu = {$ano}
             JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = c61_anousu
             WHERE k13_reduz = {$codctbtransf}";

    return $sSql;
  }
}
?>
