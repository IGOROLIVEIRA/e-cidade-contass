<?
//MODULO: sicom
//CLASSE DA ENTIDADE dclrf202017
class cl_dclrf202017 {
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
    var $si169_sequencial = 0;
    var $si169_tiporegistro = 0;
    var $si169_contopcredito = 0;
    var $si169_dsccontopcredito = null;
    var $si169_realizopcredito = 0;
    var $si169_tiporealizopcreditocapta = 0;
    var $si169_tiporealizopcreditoassundir = 0;
    var $si169_tiporealizopcreditoassunobg = 0;
    var $si169_mes = 0;
    var $si169_instit = 0;
    // cria propriedade com as variaveis do arquivo 
    var $campos = "
                 si169_sequencial = int8 = sequencial
                 si169_tiporegistro = int8 = Tipo do registro
                 si169_contopcredito = int8 = contratação de operação de crédito
                 si169_dsccontopcredito = varchar(1000) = descrição da ocorrência em função da operação de crédito
                 si169_realizopcredito = int8 = realização de operações de crédito vedadas
                 si169_tiporealizopcreditocapta = int8 = tipo da realização de operações de crédito vedada
                 si169_tiporealizopcreditoreceb = int8 = tipo da realização de operações de crédito vedada
                 si169_tiporealizopcreditoassundir = int8 = tipo da realização de operações de crédito vedada
                 si169_tiporealizopcreditoassunobg = int8 = tipo da realização de operações de crédito vedada
                 si169_mes = int8 = Mês
                 si169_instit = int8 = Instituição
                 ";
    //funcao construtor da classe 
    function cl_dclrf202017() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("dclrf202017");
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
            $this->si169_sequencial = ($this->si169_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_sequencial"]:$this->si169_sequencial);
            $this->si169_tiporegistro = ($this->si169_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_tiporegistro"]:$this->si169_tiporegistro);
            $this->si169_contopcredito = ($this->si169_contopcredito == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_contopcredito"]:$this->si169_contopcredito);
            $this->si169_dsccontopcredito = ($this->si169_dsccontopcredito == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_dsccontopcredito"]:$this->si169_dsccontopcredito);
            $this->si169_realizopcredito = ($this->si169_realizopcredito == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_realizopcredito"]:$this->si169_realizopcredito);
            $this->si169_tiporealizopcreditocapta = ($this->si169_tiporealizopcreditocapta == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_tiporealizopcreditocapta"]:$this->si169_tiporealizopcreditocapta);
            $this->si169_tiporealizopcreditoreceb = ($this->si169_tiporealizopcreditoreceb == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_tiporealizopcreditoreceb"]:$this->si169_tiporealizopcreditoreceb);
            $this->si169_tiporealizopcreditoassundir = ($this->si169_tiporealizopcreditoassundir == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_tiporealizopcreditoassundir"]:$this->si169_tiporealizopcreditoassundir);
            $this->si169_tiporealizopcreditoassunobg = ($this->si169_tiporealizopcreditoassunobg == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_tiporealizopcreditoassunobg"]:$this->si169_tiporealizopcreditoassunobg);
            $this->si169_mes = ($this->si169_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_mes"]:$this->si169_mes);
            $this->si169_instit = ($this->si169_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_instit"]:$this->si169_instit);
        }else{
            $this->si169_sequencial = ($this->si169_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_sequencial"]:$this->si169_sequencial);
        }
    }
    // funcao para inclusao
    function incluir ($si169_sequencial){
        $this->atualizacampos();
        if($this->si169_tiporegistro == null ){
            $this->erro_sql = " Campo Tipo do registro nao Informado.";
            $this->erro_campo = "si169_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si169_contopcredito == null ){
            $this->si169_contopcredito = "0";
        }
        if($this->si169_dsccontopcredito == null ){
            $this->si169_dsccontopcredito = "0";
        }
        if($this->si169_realizopcredito == null ){
            $this->si169_realizopcredito = "0";
        }
        if($this->si169_tiporealizopcreditocapta == null ){
            $this->si169_tiporealizopcreditocapta = "0";
        }
        if($this->si169_tiporealizopcreditoreceb == null ){
            $this->si169_tiporealizopcreditoreceb = "0";
        }
        if($this->si169_tiporealizopcreditoassundir == null ){
            $this->si169_tiporealizopcreditoassundir = "0";
        }
        if($this->si169_tiporealizopcreditoassunobg == null ){
            $this->si169_tiporealizopcreditoassunobg = "0";
        }
        if($this->si169_mes == null ){
            $this->erro_sql = " Campo Mês nao Informado.";
            $this->erro_campo = "si169_mes";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si169_instit == null ){
            $this->erro_sql = " Campo Instituição nao Informado.";
            $this->erro_campo = "si169_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($si169_sequencial == "" || $si169_sequencial == null ){
            $result = db_query("select nextval('dclrf202017_si169_sequencial_seq')");
            if($result==false){
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: dclrf202017_si169_sequencial_seq do campo: si169_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->si169_sequencial = pg_result($result,0,0);
        }else{
            $result = db_query("select last_value from dclrf202017_si169_sequencial_seq");
            if(($result != false) && (pg_result($result,0,0) < $si169_sequencial)){
                $this->erro_sql = " Campo si169_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }else{
                $this->si169_sequencial = $si169_sequencial;
            }
        }
        if(($this->si169_sequencial == null) || ($this->si169_sequencial == "") ){
            $this->erro_sql = " Campo si169_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into dclrf202017(
                                       si169_sequencial 
                                      ,si169_tiporegistro 
                                      ,si169_contopcredito
                                      ,si169_dsccontopcredito
                                      ,si169_realizopcredito
                                      ,si169_tiporealizopcreditocapta
                                      ,si169_tiporealizopcreditoreceb
                                      ,si169_tiporealizopcreditoassundir
                                      ,si169_tiporealizopcreditoassunobg
                                      ,si169_mes 
                                      ,si169_instit 
                       )
                values (
                                $this->si169_sequencial 
                               ,$this->si169_tiporegistro 
                               ,$this->si169_contopcredito
                               ,$this->si169_dsccontopcredito
                               ,$this->si169_realizopcredito
                               ,$this->si169_tiporealizopcreditocapta
                               ,$this->si169_tiporealizopcreditoreceb
                               ,$this->si169_tiporealizopcreditoassundir
                               ,$this->si169_tiporealizopcreditoassunobg
                               ,$this->si169_mes 
                               ,$this->si169_instit 
                      )";
        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
                $this->erro_sql   = "dclrf202017 ($this->si169_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "dclrf202017 já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }else{
                $this->erro_sql   = "dclrf202017 ($this->si169_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->si169_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $resaco = $this->sql_record($this->sql_query_file($this->si169_sequencial));
        if(($resaco!=false)||($this->numrows!=0)){
            $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
            $acount = pg_result($resac,0,0);
            $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
            $resac = db_query("insert into db_acountkey values($acount,2011199,'$this->si169_sequencial','I')");
            $resac = db_query("insert into db_acount values($acount,2010386,2011199,'','".AddSlashes(pg_result($resaco,0,'si169_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010386,2011375,'','".AddSlashes(pg_result($resaco,0,'si169_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010386,2011200,'','".AddSlashes(pg_result($resaco,0,'si169_contopcredito'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010386,2011201,'','".AddSlashes(pg_result($resaco,0,'si169_realizopcredito'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010386,2011202,'','".AddSlashes(pg_result($resaco,0,'si169_tiporealizopcreditoassunobg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010386,2011207,'','".AddSlashes(pg_result($resaco,0,'si169_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010386,2011670,'','".AddSlashes(pg_result($resaco,0,'si169_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        }
        return true;
    }
    // funcao para alteracao
    function alterar ($si169_sequencial=null) {
        $this->atualizacampos();
        $sql = " update dclrf202017 set ";
        $virgula = "";
        if(trim($this->si169_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_sequencial"])){
            if(trim($this->si169_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si169_sequencial"])){
                $this->si169_sequencial = "0" ;
            }
            $sql  .= $virgula." si169_sequencial = $this->si169_sequencial ";
            $virgula = ",";
        }
        if(trim($this->si169_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_tiporegistro"])){
            $sql  .= $virgula." si169_tiporegistro = $this->si169_tiporegistro ";
            $virgula = ",";
            if(trim($this->si169_tiporegistro) == null ){
                $this->erro_sql = " Campo Tipo do registro nao Informado.";
                $this->erro_campo = "si169_tiporegistro";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si169_contopcredito)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_contopcredito"])){
            if(trim($this->si169_contopcredito)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si169_contopcredito"])){
                $this->si169_contopcredito = "0" ;
            }
            $sql  .= $virgula." si169_contopcredito = $this->si169_contopcredito ";
            $virgula = ",";
        }
        if(trim($this->si169_realizopcredito)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_realizopcredito"])){
            if(trim($this->si169_realizopcredito)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si169_realizopcredito"])){
                $this->si169_realizopcredito = "0" ;
            }
            $sql  .= $virgula." si169_realizopcredito = $this->si169_realizopcredito ";
            $virgula = ",";
        }
        if(trim($this->si169_tiporealizopcreditoassunobg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_tiporealizopcreditoassunobg"])){
            if(trim($this->si169_tiporealizopcreditoassunobg)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si169_tiporealizopcreditoassunobg"])){
                $this->si169_tiporealizopcreditoassunobg = "0" ;
            }
            $sql  .= $virgula." si169_tiporealizopcreditoassunobg = $this->si169_tiporealizopcreditoassunobg ";
            $virgula = ",";
        }
        if(trim($this->si169_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_mes"])){
            $sql  .= $virgula." si169_mes = $this->si169_mes ";
            $virgula = ",";
            if(trim($this->si169_mes) == null ){
                $this->erro_sql = " Campo Mês nao Informado.";
                $this->erro_campo = "si169_mes";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si169_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_instit"])){
            $sql  .= $virgula." si169_instit = $this->si169_instit ";
            $virgula = ",";
            if(trim($this->si169_instit) == null ){
                $this->erro_sql = " Campo Instituição nao Informado.";
                $this->erro_campo = "si169_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        if($si169_sequencial!=null){
            $sql .= " si169_sequencial = $this->si169_sequencial";
        }
        $resaco = $this->sql_record($this->sql_query_file($this->si169_sequencial));
        if($this->numrows>0){
            for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,2011199,'$this->si169_sequencial','A')");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_sequencial"]) || $this->si169_sequencial != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011199,'".AddSlashes(pg_result($resaco,$conresaco,'si169_sequencial'))."','$this->si169_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_tiporegistro"]) || $this->si169_tiporegistro != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011375,'".AddSlashes(pg_result($resaco,$conresaco,'si169_tiporegistro'))."','$this->si169_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_contopcredito"]) || $this->si169_contopcredito != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011200,'".AddSlashes(pg_result($resaco,$conresaco,'si169_contopcredito'))."','$this->si169_contopcredito',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_realizopcredito"]) || $this->si169_realizopcredito != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011201,'".AddSlashes(pg_result($resaco,$conresaco,'si169_realizopcredito'))."','$this->si169_realizopcredito',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_tiporealizopcreditoassunobg"]) || $this->si169_tiporealizopcreditoassunobg != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011202,'".AddSlashes(pg_result($resaco,$conresaco,'si169_tiporealizopcreditoassunobg'))."','$this->si169_tiporealizopcreditoassunobg',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_vlliqincentcontrib"]) || $this->si169_vlliqincentcontrib != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011203,'".AddSlashes(pg_result($resaco,$conresaco,'si169_vlliqincentcontrib'))."','$this->si169_vlliqincentcontrib',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_vlliqincentinstfinanc"]) || $this->si169_vlliqincentinstfinanc != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011204,'".AddSlashes(pg_result($resaco,$conresaco,'si169_vlliqincentinstfinanc'))."','$this->si169_vlliqincentinstfinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_vlirpnpincentcontrib"]) || $this->si169_vlirpnpincentcontrib != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011205,'".AddSlashes(pg_result($resaco,$conresaco,'si169_vlirpnpincentcontrib'))."','$this->si169_vlirpnpincentcontrib',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_vlirpnpincentinstfinanc"]) || $this->si169_vlirpnpincentinstfinanc != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011206,'".AddSlashes(pg_result($resaco,$conresaco,'si169_vlirpnpincentinstfinanc'))."','$this->si169_vlirpnpincentinstfinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_vlcompromissado"]) || $this->si169_vlcompromissado != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011376,'".AddSlashes(pg_result($resaco,$conresaco,'si169_vlcompromissado'))."','$this->si169_vlcompromissado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_vlrecursosnaoaplicados"]) || $this->si169_vlrecursosnaoaplicados != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011377,'".AddSlashes(pg_result($resaco,$conresaco,'si169_vlrecursosnaoaplicados'))."','$this->si169_vlrecursosnaoaplicados',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_mes"]) || $this->si169_mes != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011207,'".AddSlashes(pg_result($resaco,$conresaco,'si169_mes'))."','$this->si169_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si169_instit"]) || $this->si169_instit != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011670,'".AddSlashes(pg_result($resaco,$conresaco,'si169_instit'))."','$this->si169_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            }
        }
        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "dclrf202017 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->si169_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "dclrf202017 nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->si169_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->si169_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }
    // funcao para exclusao 
    function excluir ($si169_sequencial=null,$dbwhere=null) {
        if($dbwhere==null || $dbwhere==""){
            $resaco = $this->sql_record($this->sql_query_file($si169_sequencial));
        }else{
            $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
        }
        if(($resaco!=false)||($this->numrows!=0)){
            for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,2011199,'$si169_sequencial','E')");
                $resac = db_query("insert into db_acount values($acount,2010386,2011199,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011375,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011200,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_contopcredito'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011201,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_realizopcredito'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011202,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_tiporealizopcreditoassunobg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011203,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_vlliqincentcontrib'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011204,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_vlliqincentinstfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011205,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_vlirpnpincentcontrib'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011206,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_vlirpnpincentinstfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011376,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_vlcompromissado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011377,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_vlrecursosnaoaplicados'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011207,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011670,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            }
        }
        $sql = " delete from dclrf202017
                    where ";
        $sql2 = "";
        if($dbwhere==null || $dbwhere ==""){
            if($si169_sequencial != ""){
                if($sql2!=""){
                    $sql2 .= " and ";
                }
                $sql2 .= " si169_sequencial = $si169_sequencial ";
            }
        }else{
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "dclrf202017 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$si169_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "dclrf202017 nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$si169_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$si169_sequencial;
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
            $this->erro_sql   = "Record Vazio na Tabela:dclrf202017";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    // funcao do sql 
    function sql_query ( $si169_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from dclrf202017 ";
        $sql2 = "";
        if($dbwhere==""){
            if($si169_sequencial!=null ){
                $sql2 .= " where dclrf202017.si169_sequencial = $si169_sequencial ";
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
    function sql_query_file ( $si169_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from dclrf202017 ";
        $sql2 = "";
        if($dbwhere==""){
            if($si169_sequencial!=null ){
                $sql2 .= " where dclrf202017.si169_sequencial = $si169_sequencial ";
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
