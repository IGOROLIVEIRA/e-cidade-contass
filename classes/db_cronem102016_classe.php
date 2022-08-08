<?
//MODULO: sicom
//CLASSE DA ENTIDADE cronem102016
class cl_cronem102016 {
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
    var $si170_sequencial = 0;
    var $si170_tiporegistro = 0;
    var $si170_codorgao = 0;
    var $si170_codunidadesub = null;
    var $si170_grupodespesa = 0;
    var $si170_vldotmensal = 0;
    var $si170_mes = 0;
    var $si170_instit = 0;
    // cria propriedade com as variaveis do arquivo 
    var $campos = "
                 si170_sequencial = int8 = sequencial
                 si170_tiporegistro = int8 = Tipo do registro
                 si170_codorgao = varchar(2) = código do órgão
                 si170_codunidadesub = varchar(8) = código da unidade ou subunidade orçamentária
                 si170_grupodespesa = int8 = grupo da despesa
                 si170_vldotmensal = float8 = valor referente a dotação mensal da despesa
                 si170_mes = int8 = Mês
                 si170_instit = int8 = Instituição
                 ";
    //funcao construtor da classe 
    function cl_cronem102016() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("cronem102016");
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
            $this->si170_sequencial = ($this->si170_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_sequencial"]:$this->si170_sequencial);
            $this->si170_tiporegistro = ($this->si170_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_tiporegistro"]:$this->si170_tiporegistro);
            $this->si170_codorgao = ($this->si170_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_codorgao"]:$this->si170_codorgao);
            $this->si170_codunidadesub = ($this->si170_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_codunidadesub"]:$this->si170_codunidadesub);
            $this->si170_grupodespesa = ($this->si170_grupodespesa == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_grupodespesa"]:$this->si170_grupodespesa);
            $this->si170_vldotmensal = ($this->si170_vldotmensal == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vldotmensal"]:$this->si170_vldotmensal);
            $this->si170_mes = ($this->si170_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_mes"]:$this->si170_mes);
            $this->si170_instit = ($this->si170_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_instit"]:$this->si170_instit);
        }else{
            $this->si170_sequencial = ($this->si170_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_sequencial"]:$this->si170_sequencial);
        }
    }
    // funcao para inclusao
    function incluir ($si170_sequencial){
        $this->atualizacampos();
        if($this->si170_tiporegistro == null ){
            $this->erro_sql = " Campo Tipo do registro nao Informado.";
            $this->erro_campo = "si170_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si170_codorgao == null ){
            $this->si170_codorgao = "0";
        }
        if($this->si170_grupodespesa == null ){
            $this->si170_grupodespesa = "0";
        }
        if($this->si170_vldotmensal == null ){
            $this->si170_vldotmensal = "0";
        }
        if($this->si170_mes == null ){
            $this->erro_sql = " Campo Mês nao Informado.";
            $this->erro_campo = "si170_mes";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->si170_instit == null ){
            $this->erro_sql = " Campo Instituição nao Informado.";
            $this->erro_campo = "si170_instit";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($si170_sequencial == "" || $si170_sequencial == null ){
            $result = db_query("select nextval('cronem102016_si170_sequencial_seq')");
            if($result==false){
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: cronem102016_si170_sequencial_seq do campo: si170_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->si170_sequencial = pg_result($result,0,0);
        }else{
            $result = db_query("select last_value from cronem102016_si170_sequencial_seq");
            if(($result != false) && (pg_result($result,0,0) < $si170_sequencial)){
                $this->erro_sql = " Campo si170_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }else{
                $this->si170_sequencial = $si170_sequencial;
            }
        }
        if(($this->si170_sequencial == null) || ($this->si170_sequencial == "") ){
            $this->erro_sql = " Campo si170_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into cronem102016(
                                       si170_sequencial 
                                      ,si170_tiporegistro 
                                      ,si170_codorgao
                                      ,si170_codunidadesub
                                      ,si170_grupodespesa
                                      ,si170_vldotmensal
                                      ,si170_mes 
                                      ,si170_instit 
                       )
                values (
                                $this->si170_sequencial 
                               ,$this->si170_tiporegistro 
                               ,$this->si170_codorgao
                               ,$this->si170_codunidadesub
                               ,$this->si170_grupodespesa
                               ,$this->si170_vldotmensal
                               ,$this->si170_mes 
                               ,$this->si170_instit 
                      )";
        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
                $this->erro_sql   = "cronem102016 ($this->si170_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "cronem102016 já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }else{
                $this->erro_sql   = "cronem102016 ($this->si170_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->si170_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $resaco = $this->sql_record($this->sql_query_file($this->si170_sequencial));
        if(($resaco!=false)||($this->numrows!=0)){
            $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
            $acount = pg_result($resac,0,0);
            $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
            $resac = db_query("insert into db_acountkey values($acount,2011199,'$this->si170_sequencial','I')");
            $resac = db_query("insert into db_acount values($acount,2010386,2011199,'','".AddSlashes(pg_result($resaco,0,'si170_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010386,2011375,'','".AddSlashes(pg_result($resaco,0,'si170_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010386,2011200,'','".AddSlashes(pg_result($resaco,0,'si170_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010386,2011201,'','".AddSlashes(pg_result($resaco,0,'si170_grupodespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010386,2011202,'','".AddSlashes(pg_result($resaco,0,'si170_tiporealizopcreditoassunobg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010386,2011207,'','".AddSlashes(pg_result($resaco,0,'si170_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            $resac = db_query("insert into db_acount values($acount,2010386,2011670,'','".AddSlashes(pg_result($resaco,0,'si170_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        }
        return true;
    }
    // funcao para alteracao
    function alterar ($si170_sequencial=null) {
        $this->atualizacampos();
        $sql = " update cronem102016 set ";
        $virgula = "";
        if(trim($this->si170_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_sequencial"])){
            if(trim($this->si170_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si170_sequencial"])){
                $this->si170_sequencial = "0" ;
            }
            $sql  .= $virgula." si170_sequencial = $this->si170_sequencial ";
            $virgula = ",";
        }
        if(trim($this->si170_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_tiporegistro"])){
            $sql  .= $virgula." si170_tiporegistro = $this->si170_tiporegistro ";
            $virgula = ",";
            if(trim($this->si170_tiporegistro) == null ){
                $this->erro_sql = " Campo Tipo do registro nao Informado.";
                $this->erro_campo = "si170_tiporegistro";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si170_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_codorgao"])){
            if(trim($this->si170_codorgao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si170_codorgao"])){
                $this->si170_codorgao = "0" ;
            }
            $sql  .= $virgula." si170_codorgao = $this->si170_codorgao ";
            $virgula = ",";
        }
        if(trim($this->si170_grupodespesa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_grupodespesa"])){
            if(trim($this->si170_grupodespesa)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si170_grupodespesa"])){
                $this->si170_grupodespesa = "0" ;
            }
            $sql  .= $virgula." si170_grupodespesa = $this->si170_grupodespesa ";
            $virgula = ",";
        }
        if(trim($this->si170_tiporealizopcreditoassunobg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_tiporealizopcreditoassunobg"])){
            if(trim($this->si170_tiporealizopcreditoassunobg)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si170_tiporealizopcreditoassunobg"])){
                $this->si170_tiporealizopcreditoassunobg = "0" ;
            }
            $sql  .= $virgula." si170_tiporealizopcreditoassunobg = $this->si170_tiporealizopcreditoassunobg ";
            $virgula = ",";
        }
        if(trim($this->si170_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_mes"])){
            $sql  .= $virgula." si170_mes = $this->si170_mes ";
            $virgula = ",";
            if(trim($this->si170_mes) == null ){
                $this->erro_sql = " Campo Mês nao Informado.";
                $this->erro_campo = "si170_mes";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->si170_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_instit"])){
            $sql  .= $virgula." si170_instit = $this->si170_instit ";
            $virgula = ",";
            if(trim($this->si170_instit) == null ){
                $this->erro_sql = " Campo Instituição nao Informado.";
                $this->erro_campo = "si170_instit";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        if($si170_sequencial!=null){
            $sql .= " si170_sequencial = $this->si170_sequencial";
        }
        $resaco = $this->sql_record($this->sql_query_file($this->si170_sequencial));
        if($this->numrows>0){
            for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,2011199,'$this->si170_sequencial','A')");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_sequencial"]) || $this->si170_sequencial != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011199,'".AddSlashes(pg_result($resaco,$conresaco,'si170_sequencial'))."','$this->si170_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_tiporegistro"]) || $this->si170_tiporegistro != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011375,'".AddSlashes(pg_result($resaco,$conresaco,'si170_tiporegistro'))."','$this->si170_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_codorgao"]) || $this->si170_codorgao != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011200,'".AddSlashes(pg_result($resaco,$conresaco,'si170_codorgao'))."','$this->si170_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_grupodespesa"]) || $this->si170_grupodespesa != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011201,'".AddSlashes(pg_result($resaco,$conresaco,'si170_grupodespesa'))."','$this->si170_grupodespesa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_tiporealizopcreditoassunobg"]) || $this->si170_tiporealizopcreditoassunobg != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011202,'".AddSlashes(pg_result($resaco,$conresaco,'si170_tiporealizopcreditoassunobg'))."','$this->si170_tiporealizopcreditoassunobg',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentcontrib"]) || $this->si170_vlliqincentcontrib != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011203,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlliqincentcontrib'))."','$this->si170_vlliqincentcontrib',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentinstfinanc"]) || $this->si170_vlliqincentinstfinanc != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011204,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlliqincentinstfinanc'))."','$this->si170_vlliqincentinstfinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlirpnpincentcontrib"]) || $this->si170_vlirpnpincentcontrib != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011205,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlirpnpincentcontrib'))."','$this->si170_vlirpnpincentcontrib',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlirpnpincentinstfinanc"]) || $this->si170_vlirpnpincentinstfinanc != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011206,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlirpnpincentinstfinanc'))."','$this->si170_vlirpnpincentinstfinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlcompromissado"]) || $this->si170_vlcompromissado != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011376,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlcompromissado'))."','$this->si170_vlcompromissado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlrecursosnaoaplicados"]) || $this->si170_vlrecursosnaoaplicados != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011377,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlrecursosnaoaplicados'))."','$this->si170_vlrecursosnaoaplicados',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_mes"]) || $this->si170_mes != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011207,'".AddSlashes(pg_result($resaco,$conresaco,'si170_mes'))."','$this->si170_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                if(isset($GLOBALS["HTTP_POST_VARS"]["si170_instit"]) || $this->si170_instit != "")
                    $resac = db_query("insert into db_acount values($acount,2010386,2011670,'".AddSlashes(pg_result($resaco,$conresaco,'si170_instit'))."','$this->si170_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            }
        }
        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "cronem102016 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ".$this->si170_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "cronem102016 nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ".$this->si170_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$this->si170_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }
    // funcao para exclusao 
    function excluir ($si170_sequencial=null,$dbwhere=null) {
        if($dbwhere==null || $dbwhere==""){
            $resaco = $this->sql_record($this->sql_query_file($si170_sequencial));
        }else{
            $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
        }
        if(($resaco!=false)||($this->numrows!=0)){
            for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,2011199,'$si170_sequencial','E')");
                $resac = db_query("insert into db_acount values($acount,2010386,2011199,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011375,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011200,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011201,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_grupodespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011202,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_tiporealizopcreditoassunobg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011203,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlliqincentcontrib'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011204,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlliqincentinstfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011205,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlirpnpincentcontrib'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011206,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlirpnpincentinstfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011376,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlcompromissado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011377,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlrecursosnaoaplicados'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011207,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,2010386,2011670,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
            }
        }
        $sql = " delete from cronem102016
                    where ";
        $sql2 = "";
        if($dbwhere==null || $dbwhere ==""){
            if($si170_sequencial != ""){
                if($sql2!=""){
                    $sql2 .= " and ";
                }
                $sql2 .= " si170_sequencial = $si170_sequencial ";
            }
        }else{
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "cronem102016 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ".$si170_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "cronem102016 nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ".$si170_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ".$si170_sequencial;
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
            $this->erro_sql   = "Record Vazio na Tabela:cronem102016";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    // funcao do sql 
    function sql_query ( $si170_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from cronem102016 ";
        $sql2 = "";
        if($dbwhere==""){
            if($si170_sequencial!=null ){
                $sql2 .= " where cronem102016.si170_sequencial = $si170_sequencial ";
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
    function sql_query_file ( $si170_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from cronem102016 ";
        $sql2 = "";
        if($dbwhere==""){
            if($si170_sequencial!=null ){
                $sql2 .= " where cronem102016.si170_sequencial = $si170_sequencial ";
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
