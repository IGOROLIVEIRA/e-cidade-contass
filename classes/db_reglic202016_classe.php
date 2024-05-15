<?
//MODULO: sicom
//CLASSE DA ENTIDADE reglic202016
class cl_reglic202016 { 
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
   var $si45_sequencial = 0; 
   var $si45_tiporegistro = 0; 
   var $si45_codorgao = null; 
   var $si45_regulamentart47 = 0; 
   var $si45_nronormareg = null; 
   var $si45_datanormareg_dia = null; 
   var $si45_datanormareg_mes = null; 
   var $si45_datanormareg_ano = null; 
   var $si45_datanormareg = null; 
   var $si45_datapubnormareg_dia = null; 
   var $si45_datapubnormareg_mes = null; 
   var $si45_datapubnormareg_ano = null; 
   var $si45_datapubnormareg = null; 
   var $si45_regexclusiva = 0; 
   var $si45_artigoregexclusiva = null; 
   var $si45_valorlimiteregexclusiva = 0; 
   var $si45_procsubcontratacao = 0; 
   var $si45_artigoprocsubcontratacao = null; 
   var $si45_percentualsubcontratacao = 0; 
   var $si45_criteriosempenhopagamento = 0; 
   var $si45_artigoempenhopagamento = null; 
   var $si45_estabeleceuperccontratacao = 0; 
   var $si45_artigoperccontratacao = null; 
   var $si45_percentualcontratacao = 0; 
   var $si45_mes = 0; 
   var $si45_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si45_sequencial = int8 = sequencial 
                 si45_tiporegistro = int8 = Tipo de registro 
                 si45_codorgao = varchar(2) = Código do órgão 
                 si45_regulamentart47 = int8 = Identifica 
                 si45_nronormareg = varchar(6) = Número da norma 
                 si45_datanormareg = date = Data da norma 
                 si45_datapubnormareg = date = Data de publicação 
                 si45_regexclusiva = int8 = Identifica 
                 si45_artigoregexclusiva = varchar(6) = Artigo da regulamentação exclusiva 
                 si45_valorlimiteregexclusiva = float8 = Valor Limite 
                 si45_procsubcontratacao = int8 = Identifica 
                 si45_artigoprocsubcontratacao = varchar(6) = Artigo do percentual contratação 
                 si45_percentualsubcontratacao = float8 = Percentual estabelecido 
                 si45_criteriosempenhopagamento = int8 = critérios ? 
                 si45_artigoempenhopagamento = varchar(6) = Artigo relativo 
                 si45_estabeleceuperccontratacao = int8 = estabeleceu ? 
                 si45_artigoperccontratacao = varchar(6) = Artigo do percentual contratação 
                 si45_percentualcontratacao = float8 = Percentual estabelecido 
                 si45_mes = int8 = Mês 
                 si45_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_reglic202016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("reglic202016"); 
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
       $this->si45_sequencial = ($this->si45_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_sequencial"]:$this->si45_sequencial);
       $this->si45_tiporegistro = ($this->si45_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_tiporegistro"]:$this->si45_tiporegistro);
       $this->si45_codorgao = ($this->si45_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_codorgao"]:$this->si45_codorgao);
       $this->si45_regulamentart47 = ($this->si45_regulamentart47 == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_regulamentart47"]:$this->si45_regulamentart47);
       $this->si45_nronormareg = ($this->si45_nronormareg == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_nronormareg"]:$this->si45_nronormareg);
       if($this->si45_datanormareg == ""){
         $this->si45_datanormareg_dia = ($this->si45_datanormareg_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_datanormareg_dia"]:$this->si45_datanormareg_dia);
         $this->si45_datanormareg_mes = ($this->si45_datanormareg_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_datanormareg_mes"]:$this->si45_datanormareg_mes);
         $this->si45_datanormareg_ano = ($this->si45_datanormareg_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_datanormareg_ano"]:$this->si45_datanormareg_ano);
         if($this->si45_datanormareg_dia != ""){
            $this->si45_datanormareg = $this->si45_datanormareg_ano."-".$this->si45_datanormareg_mes."-".$this->si45_datanormareg_dia;
         }
       }
       if($this->si45_datapubnormareg == ""){
         $this->si45_datapubnormareg_dia = ($this->si45_datapubnormareg_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_datapubnormareg_dia"]:$this->si45_datapubnormareg_dia);
         $this->si45_datapubnormareg_mes = ($this->si45_datapubnormareg_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_datapubnormareg_mes"]:$this->si45_datapubnormareg_mes);
         $this->si45_datapubnormareg_ano = ($this->si45_datapubnormareg_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_datapubnormareg_ano"]:$this->si45_datapubnormareg_ano);
         if($this->si45_datapubnormareg_dia != ""){
            $this->si45_datapubnormareg = $this->si45_datapubnormareg_ano."-".$this->si45_datapubnormareg_mes."-".$this->si45_datapubnormareg_dia;
         }
       }
       $this->si45_regexclusiva = ($this->si45_regexclusiva == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_regexclusiva"]:$this->si45_regexclusiva);
       $this->si45_artigoregexclusiva = ($this->si45_artigoregexclusiva == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_artigoregexclusiva"]:$this->si45_artigoregexclusiva);
       $this->si45_valorlimiteregexclusiva = ($this->si45_valorlimiteregexclusiva == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_valorlimiteregexclusiva"]:$this->si45_valorlimiteregexclusiva);
       $this->si45_procsubcontratacao = ($this->si45_procsubcontratacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_procsubcontratacao"]:$this->si45_procsubcontratacao);
       $this->si45_artigoprocsubcontratacao = ($this->si45_artigoprocsubcontratacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_artigoprocsubcontratacao"]:$this->si45_artigoprocsubcontratacao);
       $this->si45_percentualsubcontratacao = ($this->si45_percentualsubcontratacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_percentualsubcontratacao"]:$this->si45_percentualsubcontratacao);
       $this->si45_criteriosempenhopagamento = ($this->si45_criteriosempenhopagamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_criteriosempenhopagamento"]:$this->si45_criteriosempenhopagamento);
       $this->si45_artigoempenhopagamento = ($this->si45_artigoempenhopagamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_artigoempenhopagamento"]:$this->si45_artigoempenhopagamento);
       $this->si45_estabeleceuperccontratacao = ($this->si45_estabeleceuperccontratacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_estabeleceuperccontratacao"]:$this->si45_estabeleceuperccontratacao);
       $this->si45_artigoperccontratacao = ($this->si45_artigoperccontratacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_artigoperccontratacao"]:$this->si45_artigoperccontratacao);
       $this->si45_percentualcontratacao = ($this->si45_percentualcontratacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_percentualcontratacao"]:$this->si45_percentualcontratacao);
       $this->si45_mes = ($this->si45_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_mes"]:$this->si45_mes);
       $this->si45_instit = ($this->si45_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_instit"]:$this->si45_instit);
     }else{
       $this->si45_sequencial = ($this->si45_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si45_sequencial"]:$this->si45_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si45_sequencial){ 
      $this->atualizacampos();
     if($this->si45_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo de registro nao Informado.";
       $this->erro_campo = "si45_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si45_regulamentart47 == null ){ 
       $this->si45_regulamentart47 = "0";
     }
     if($this->si45_datanormareg == null ){ 
       $this->si45_datanormareg = "null";
     }
     if($this->si45_datapubnormareg == null ){ 
       $this->si45_datapubnormareg = "null";
     }
     if($this->si45_regexclusiva == null ){ 
       $this->si45_regexclusiva = "0";
     }
     if($this->si45_valorlimiteregexclusiva == null ){ 
       $this->si45_valorlimiteregexclusiva = "0";
     }
     if($this->si45_procsubcontratacao == null ){ 
       $this->si45_procsubcontratacao = "0";
     }
     if($this->si45_percentualsubcontratacao == null ){ 
       $this->si45_percentualsubcontratacao = "0";
     }
     if($this->si45_criteriosempenhopagamento == null ){ 
       $this->si45_criteriosempenhopagamento = "0";
     }
     if($this->si45_estabeleceuperccontratacao == null ){ 
       $this->si45_estabeleceuperccontratacao = "0";
     }
     if($this->si45_percentualcontratacao == null ){ 
       $this->si45_percentualcontratacao = "0";
     }
     if($this->si45_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si45_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si45_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si45_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si45_sequencial == "" || $si45_sequencial == null ){
       $result = db_query("select nextval('reglic202016_si45_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: reglic202016_si45_sequencial_seq do campo: si45_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si45_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from reglic202016_si45_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si45_sequencial)){
         $this->erro_sql = " Campo si45_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si45_sequencial = $si45_sequencial; 
       }
     }
     if(($this->si45_sequencial == null) || ($this->si45_sequencial == "") ){ 
       $this->erro_sql = " Campo si45_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into reglic202016(
                                       si45_sequencial 
                                      ,si45_tiporegistro 
                                      ,si45_codorgao 
                                      ,si45_regulamentart47 
                                      ,si45_nronormareg 
                                      ,si45_datanormareg 
                                      ,si45_datapubnormareg 
                                      ,si45_regexclusiva 
                                      ,si45_artigoregexclusiva 
                                      ,si45_valorlimiteregexclusiva 
                                      ,si45_procsubcontratacao 
                                      ,si45_artigoprocsubcontratacao 
                                      ,si45_percentualsubcontratacao 
                                      ,si45_criteriosempenhopagamento 
                                      ,si45_artigoempenhopagamento 
                                      ,si45_estabeleceuperccontratacao 
                                      ,si45_artigoperccontratacao 
                                      ,si45_percentualcontratacao 
                                      ,si45_mes 
                                      ,si45_instit 
                       )
                values (
                                $this->si45_sequencial 
                               ,$this->si45_tiporegistro 
                               ,'$this->si45_codorgao' 
                               ,$this->si45_regulamentart47 
                               ,'$this->si45_nronormareg' 
                               ,".($this->si45_datanormareg == "null" || $this->si45_datanormareg == ""?"null":"'".$this->si45_datanormareg."'")." 
                               ,".($this->si45_datapubnormareg == "null" || $this->si45_datapubnormareg == ""?"null":"'".$this->si45_datapubnormareg."'")." 
                               ,$this->si45_regexclusiva 
                               ,'$this->si45_artigoregexclusiva' 
                               ,$this->si45_valorlimiteregexclusiva 
                               ,$this->si45_procsubcontratacao 
                               ,'$this->si45_artigoprocsubcontratacao' 
                               ,$this->si45_percentualsubcontratacao 
                               ,$this->si45_criteriosempenhopagamento 
                               ,'$this->si45_artigoempenhopagamento' 
                               ,$this->si45_estabeleceuperccontratacao 
                               ,'$this->si45_artigoperccontratacao' 
                               ,$this->si45_percentualcontratacao 
                               ,$this->si45_mes 
                               ,$this->si45_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "reglic202016 ($this->si45_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "reglic202016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "reglic202016 ($this->si45_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si45_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si45_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009840,'$this->si45_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010274,2009840,'','".AddSlashes(pg_result($resaco,0,'si45_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009841,'','".AddSlashes(pg_result($resaco,0,'si45_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009842,'','".AddSlashes(pg_result($resaco,0,'si45_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009843,'','".AddSlashes(pg_result($resaco,0,'si45_regulamentart47'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009844,'','".AddSlashes(pg_result($resaco,0,'si45_nronormareg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009845,'','".AddSlashes(pg_result($resaco,0,'si45_datanormareg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009846,'','".AddSlashes(pg_result($resaco,0,'si45_datapubnormareg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009847,'','".AddSlashes(pg_result($resaco,0,'si45_regexclusiva'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009848,'','".AddSlashes(pg_result($resaco,0,'si45_artigoregexclusiva'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009849,'','".AddSlashes(pg_result($resaco,0,'si45_valorlimiteregexclusiva'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009850,'','".AddSlashes(pg_result($resaco,0,'si45_procsubcontratacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009851,'','".AddSlashes(pg_result($resaco,0,'si45_artigoprocsubcontratacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009857,'','".AddSlashes(pg_result($resaco,0,'si45_percentualsubcontratacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009858,'','".AddSlashes(pg_result($resaco,0,'si45_criteriosempenhopagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009859,'','".AddSlashes(pg_result($resaco,0,'si45_artigoempenhopagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009860,'','".AddSlashes(pg_result($resaco,0,'si45_estabeleceuperccontratacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009861,'','".AddSlashes(pg_result($resaco,0,'si45_artigoperccontratacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009853,'','".AddSlashes(pg_result($resaco,0,'si45_percentualcontratacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2009854,'','".AddSlashes(pg_result($resaco,0,'si45_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010274,2011559,'','".AddSlashes(pg_result($resaco,0,'si45_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si45_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update reglic202016 set ";
     $virgula = "";
     if(trim($this->si45_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_sequencial"])){ 
        if(trim($this->si45_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si45_sequencial"])){ 
           $this->si45_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si45_sequencial = $this->si45_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si45_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_tiporegistro"])){ 
       $sql  .= $virgula." si45_tiporegistro = $this->si45_tiporegistro ";
       $virgula = ",";
       if(trim($this->si45_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo de registro nao Informado.";
         $this->erro_campo = "si45_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si45_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_codorgao"])){ 
       $sql  .= $virgula." si45_codorgao = '$this->si45_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si45_regulamentart47)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_regulamentart47"])){ 
        if(trim($this->si45_regulamentart47)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si45_regulamentart47"])){ 
           $this->si45_regulamentart47 = "0" ; 
        } 
       $sql  .= $virgula." si45_regulamentart47 = $this->si45_regulamentart47 ";
       $virgula = ",";
     }
     if(trim($this->si45_nronormareg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_nronormareg"])){ 
       $sql  .= $virgula." si45_nronormareg = '$this->si45_nronormareg' ";
       $virgula = ",";
     }
     if(trim($this->si45_datanormareg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_datanormareg_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si45_datanormareg_dia"] !="") ){ 
       $sql  .= $virgula." si45_datanormareg = '$this->si45_datanormareg' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si45_datanormareg_dia"])){ 
         $sql  .= $virgula." si45_datanormareg = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si45_datapubnormareg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_datapubnormareg_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si45_datapubnormareg_dia"] !="") ){ 
       $sql  .= $virgula." si45_datapubnormareg = '$this->si45_datapubnormareg' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si45_datapubnormareg_dia"])){ 
         $sql  .= $virgula." si45_datapubnormareg = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si45_regexclusiva)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_regexclusiva"])){ 
        if(trim($this->si45_regexclusiva)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si45_regexclusiva"])){ 
           $this->si45_regexclusiva = "0" ; 
        } 
       $sql  .= $virgula." si45_regexclusiva = $this->si45_regexclusiva ";
       $virgula = ",";
     }
     if(trim($this->si45_artigoregexclusiva)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_artigoregexclusiva"])){ 
       $sql  .= $virgula." si45_artigoregexclusiva = '$this->si45_artigoregexclusiva' ";
       $virgula = ",";
     }
     if(trim($this->si45_valorlimiteregexclusiva)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_valorlimiteregexclusiva"])){ 
        if(trim($this->si45_valorlimiteregexclusiva)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si45_valorlimiteregexclusiva"])){ 
           $this->si45_valorlimiteregexclusiva = "0" ; 
        } 
       $sql  .= $virgula." si45_valorlimiteregexclusiva = $this->si45_valorlimiteregexclusiva ";
       $virgula = ",";
     }
     if(trim($this->si45_procsubcontratacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_procsubcontratacao"])){ 
        if(trim($this->si45_procsubcontratacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si45_procsubcontratacao"])){ 
           $this->si45_procsubcontratacao = "0" ; 
        } 
       $sql  .= $virgula." si45_procsubcontratacao = $this->si45_procsubcontratacao ";
       $virgula = ",";
     }
     if(trim($this->si45_artigoprocsubcontratacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_artigoprocsubcontratacao"])){ 
       $sql  .= $virgula." si45_artigoprocsubcontratacao = '$this->si45_artigoprocsubcontratacao' ";
       $virgula = ",";
     }
     if(trim($this->si45_percentualsubcontratacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_percentualsubcontratacao"])){ 
        if(trim($this->si45_percentualsubcontratacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si45_percentualsubcontratacao"])){ 
           $this->si45_percentualsubcontratacao = "0" ; 
        } 
       $sql  .= $virgula." si45_percentualsubcontratacao = $this->si45_percentualsubcontratacao ";
       $virgula = ",";
     }
     if(trim($this->si45_criteriosempenhopagamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_criteriosempenhopagamento"])){ 
        if(trim($this->si45_criteriosempenhopagamento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si45_criteriosempenhopagamento"])){ 
           $this->si45_criteriosempenhopagamento = "0" ; 
        } 
       $sql  .= $virgula." si45_criteriosempenhopagamento = $this->si45_criteriosempenhopagamento ";
       $virgula = ",";
     }
     if(trim($this->si45_artigoempenhopagamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_artigoempenhopagamento"])){ 
       $sql  .= $virgula." si45_artigoempenhopagamento = '$this->si45_artigoempenhopagamento' ";
       $virgula = ",";
     }
     if(trim($this->si45_estabeleceuperccontratacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_estabeleceuperccontratacao"])){ 
        if(trim($this->si45_estabeleceuperccontratacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si45_estabeleceuperccontratacao"])){ 
           $this->si45_estabeleceuperccontratacao = "0" ; 
        } 
       $sql  .= $virgula." si45_estabeleceuperccontratacao = $this->si45_estabeleceuperccontratacao ";
       $virgula = ",";
     }
     if(trim($this->si45_artigoperccontratacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_artigoperccontratacao"])){ 
       $sql  .= $virgula." si45_artigoperccontratacao = '$this->si45_artigoperccontratacao' ";
       $virgula = ",";
     }
     if(trim($this->si45_percentualcontratacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_percentualcontratacao"])){ 
        if(trim($this->si45_percentualcontratacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si45_percentualcontratacao"])){ 
           $this->si45_percentualcontratacao = "0" ; 
        } 
       $sql  .= $virgula." si45_percentualcontratacao = $this->si45_percentualcontratacao ";
       $virgula = ",";
     }
     if(trim($this->si45_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_mes"])){ 
       $sql  .= $virgula." si45_mes = $this->si45_mes ";
       $virgula = ",";
       if(trim($this->si45_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si45_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si45_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si45_instit"])){ 
       $sql  .= $virgula." si45_instit = $this->si45_instit ";
       $virgula = ",";
       if(trim($this->si45_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si45_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si45_sequencial!=null){
       $sql .= " si45_sequencial = $this->si45_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si45_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009840,'$this->si45_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_sequencial"]) || $this->si45_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009840,'".AddSlashes(pg_result($resaco,$conresaco,'si45_sequencial'))."','$this->si45_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_tiporegistro"]) || $this->si45_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009841,'".AddSlashes(pg_result($resaco,$conresaco,'si45_tiporegistro'))."','$this->si45_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_codorgao"]) || $this->si45_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009842,'".AddSlashes(pg_result($resaco,$conresaco,'si45_codorgao'))."','$this->si45_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_regulamentart47"]) || $this->si45_regulamentart47 != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009843,'".AddSlashes(pg_result($resaco,$conresaco,'si45_regulamentart47'))."','$this->si45_regulamentart47',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_nronormareg"]) || $this->si45_nronormareg != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009844,'".AddSlashes(pg_result($resaco,$conresaco,'si45_nronormareg'))."','$this->si45_nronormareg',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_datanormareg"]) || $this->si45_datanormareg != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009845,'".AddSlashes(pg_result($resaco,$conresaco,'si45_datanormareg'))."','$this->si45_datanormareg',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_datapubnormareg"]) || $this->si45_datapubnormareg != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009846,'".AddSlashes(pg_result($resaco,$conresaco,'si45_datapubnormareg'))."','$this->si45_datapubnormareg',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_regexclusiva"]) || $this->si45_regexclusiva != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009847,'".AddSlashes(pg_result($resaco,$conresaco,'si45_regexclusiva'))."','$this->si45_regexclusiva',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_artigoregexclusiva"]) || $this->si45_artigoregexclusiva != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009848,'".AddSlashes(pg_result($resaco,$conresaco,'si45_artigoregexclusiva'))."','$this->si45_artigoregexclusiva',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_valorlimiteregexclusiva"]) || $this->si45_valorlimiteregexclusiva != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009849,'".AddSlashes(pg_result($resaco,$conresaco,'si45_valorlimiteregexclusiva'))."','$this->si45_valorlimiteregexclusiva',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_procsubcontratacao"]) || $this->si45_procsubcontratacao != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009850,'".AddSlashes(pg_result($resaco,$conresaco,'si45_procsubcontratacao'))."','$this->si45_procsubcontratacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_artigoprocsubcontratacao"]) || $this->si45_artigoprocsubcontratacao != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009851,'".AddSlashes(pg_result($resaco,$conresaco,'si45_artigoprocsubcontratacao'))."','$this->si45_artigoprocsubcontratacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_percentualsubcontratacao"]) || $this->si45_percentualsubcontratacao != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009857,'".AddSlashes(pg_result($resaco,$conresaco,'si45_percentualsubcontratacao'))."','$this->si45_percentualsubcontratacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_criteriosempenhopagamento"]) || $this->si45_criteriosempenhopagamento != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009858,'".AddSlashes(pg_result($resaco,$conresaco,'si45_criteriosempenhopagamento'))."','$this->si45_criteriosempenhopagamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_artigoempenhopagamento"]) || $this->si45_artigoempenhopagamento != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009859,'".AddSlashes(pg_result($resaco,$conresaco,'si45_artigoempenhopagamento'))."','$this->si45_artigoempenhopagamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_estabeleceuperccontratacao"]) || $this->si45_estabeleceuperccontratacao != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009860,'".AddSlashes(pg_result($resaco,$conresaco,'si45_estabeleceuperccontratacao'))."','$this->si45_estabeleceuperccontratacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_artigoperccontratacao"]) || $this->si45_artigoperccontratacao != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009861,'".AddSlashes(pg_result($resaco,$conresaco,'si45_artigoperccontratacao'))."','$this->si45_artigoperccontratacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_percentualcontratacao"]) || $this->si45_percentualcontratacao != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009853,'".AddSlashes(pg_result($resaco,$conresaco,'si45_percentualcontratacao'))."','$this->si45_percentualcontratacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_mes"]) || $this->si45_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2009854,'".AddSlashes(pg_result($resaco,$conresaco,'si45_mes'))."','$this->si45_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si45_instit"]) || $this->si45_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010274,2011559,'".AddSlashes(pg_result($resaco,$conresaco,'si45_instit'))."','$this->si45_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "reglic202016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si45_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "reglic202016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si45_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si45_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si45_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si45_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009840,'$si45_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010274,2009840,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009841,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009842,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009843,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_regulamentart47'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009844,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_nronormareg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009845,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_datanormareg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009846,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_datapubnormareg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009847,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_regexclusiva'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009848,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_artigoregexclusiva'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009849,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_valorlimiteregexclusiva'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009850,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_procsubcontratacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009851,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_artigoprocsubcontratacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009857,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_percentualsubcontratacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009858,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_criteriosempenhopagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009859,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_artigoempenhopagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009860,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_estabeleceuperccontratacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009861,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_artigoperccontratacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009853,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_percentualcontratacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2009854,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010274,2011559,'','".AddSlashes(pg_result($resaco,$iresaco,'si45_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from reglic202016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si45_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si45_sequencial = $si45_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "reglic202016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si45_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "reglic202016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si45_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si45_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:reglic202016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si45_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from reglic202016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si45_sequencial!=null ){
         $sql2 .= " where reglic202016.si45_sequencial = $si45_sequencial "; 
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
   function sql_query_file ( $si45_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from reglic202016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si45_sequencial!=null ){
         $sql2 .= " where reglic202016.si45_sequencial = $si45_sequencial "; 
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
