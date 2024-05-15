<?
//MODULO: sicom
//CLASSE DA ENTIDADE rsp202015
class cl_rsp202015 { 
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
   var $si115_sequencial = 0; 
   var $si115_tiporegistro = 0; 
   var $si115_codreduzidomov = 0; 
   var $si115_codorgao = null; 
   var $si115_codunidadesub = null; 
   var $si115_nroempenho = 0; 
   var $si115_exercicioempenho = 0; 
   var $si115_dtempenho_dia = null; 
   var $si115_dtempenho_mes = null; 
   var $si115_dtempenho_ano = null; 
   var $si115_dtempenho = null; 
   var $si115_tiporestospagar = 0; 
   var $si115_tipomovimento = 0; 
   var $si115_dtmovimentacao_dia = null; 
   var $si115_dtmovimentacao_mes = null; 
   var $si115_dtmovimentacao_ano = null; 
   var $si115_dtmovimentacao = null; 
   var $si115_dotorig = null; 
   var $si115_vlmovimentacao = 0; 
   var $si115_codorgaoencampatribuic = null; 
   var $si115_codunidadesubencampatribuic = null; 
   var $si115_justificativa = null; 
   var $si115_atocancelamento = null; 
   var $si115_dataatocancelamento_dia = null; 
   var $si115_dataatocancelamento_mes = null; 
   var $si115_dataatocancelamento_ano = null; 
   var $si115_dataatocancelamento = null; 
   var $si115_mes = 0; 
   var $si115_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si115_sequencial = int8 = sequencial 
                 si115_tiporegistro = int8 = Tipo do  registro 
                 si115_codreduzidomov = int8 = Código Identificador da Movimentação 
                 si115_codorgao = varchar(2) = Código do órgão 
                 si115_codunidadesub = varchar(8) = Código da unidade 
                 si115_nroempenho = int8 = Número do  empenho 
                 si115_exercicioempenho = int8 = Exercício do  empenho 
                 si115_dtempenho = date = Data do empenho 
                 si115_tiporestospagar = int8 = Tipo de Restos a  Pagar 
                 si115_tipomovimento = int8 = Tipo de Movimentação dos Restos a Pagar 
                 si115_dtmovimentacao = date = Data da  Movimentação 
                 si115_dotorig = varchar(21) = Despesa inscrita  em Restos a  Pagar 
                 si115_vlmovimentacao = float8 = Valor da  Movimentação 
                 si115_codorgaoencampatribuic = varchar(2) = Código do órgão responsável restos 
                 si115_codunidadesubencampatribuic = varchar(8) = Código da  unidade 
                 si115_justificativa = varchar(500) = justificativa para o  Cancelamento 
                 si115_atocancelamento = varchar(20) = Ato que autorizou  o cancelamento 
                 si115_dataatocancelamento = date = Data do ato que autorizou o cancelamento 
                 si115_mes = int8 = Mês 
                 si115_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_rsp202015() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("rsp202015"); 
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
       $this->si115_sequencial = ($this->si115_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_sequencial"]:$this->si115_sequencial);
       $this->si115_tiporegistro = ($this->si115_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_tiporegistro"]:$this->si115_tiporegistro);
       $this->si115_codreduzidomov = ($this->si115_codreduzidomov == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_codreduzidomov"]:$this->si115_codreduzidomov);
       $this->si115_codorgao = ($this->si115_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_codorgao"]:$this->si115_codorgao);
       $this->si115_codunidadesub = ($this->si115_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_codunidadesub"]:$this->si115_codunidadesub);
       $this->si115_nroempenho = ($this->si115_nroempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_nroempenho"]:$this->si115_nroempenho);
       $this->si115_exercicioempenho = ($this->si115_exercicioempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_exercicioempenho"]:$this->si115_exercicioempenho);
       if($this->si115_dtempenho == ""){
         $this->si115_dtempenho_dia = ($this->si115_dtempenho_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_dtempenho_dia"]:$this->si115_dtempenho_dia);
         $this->si115_dtempenho_mes = ($this->si115_dtempenho_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_dtempenho_mes"]:$this->si115_dtempenho_mes);
         $this->si115_dtempenho_ano = ($this->si115_dtempenho_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_dtempenho_ano"]:$this->si115_dtempenho_ano);
         if($this->si115_dtempenho_dia != ""){
            $this->si115_dtempenho = $this->si115_dtempenho_ano."-".$this->si115_dtempenho_mes."-".$this->si115_dtempenho_dia;
         }
       }
       $this->si115_tiporestospagar = ($this->si115_tiporestospagar == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_tiporestospagar"]:$this->si115_tiporestospagar);
       $this->si115_tipomovimento = ($this->si115_tipomovimento == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_tipomovimento"]:$this->si115_tipomovimento);
       if($this->si115_dtmovimentacao == ""){
         $this->si115_dtmovimentacao_dia = ($this->si115_dtmovimentacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_dtmovimentacao_dia"]:$this->si115_dtmovimentacao_dia);
         $this->si115_dtmovimentacao_mes = ($this->si115_dtmovimentacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_dtmovimentacao_mes"]:$this->si115_dtmovimentacao_mes);
         $this->si115_dtmovimentacao_ano = ($this->si115_dtmovimentacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_dtmovimentacao_ano"]:$this->si115_dtmovimentacao_ano);
         if($this->si115_dtmovimentacao_dia != ""){
            $this->si115_dtmovimentacao = $this->si115_dtmovimentacao_ano."-".$this->si115_dtmovimentacao_mes."-".$this->si115_dtmovimentacao_dia;
         }
       }
       $this->si115_dotorig = ($this->si115_dotorig == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_dotorig"]:$this->si115_dotorig);
       $this->si115_vlmovimentacao = ($this->si115_vlmovimentacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_vlmovimentacao"]:$this->si115_vlmovimentacao);
       $this->si115_codorgaoencampatribuic = ($this->si115_codorgaoencampatribuic == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_codorgaoencampatribuic"]:$this->si115_codorgaoencampatribuic);
       $this->si115_codunidadesubencampatribuic = ($this->si115_codunidadesubencampatribuic == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_codunidadesubencampatribuic"]:$this->si115_codunidadesubencampatribuic);
       $this->si115_justificativa = ($this->si115_justificativa == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_justificativa"]:$this->si115_justificativa);
       $this->si115_atocancelamento = ($this->si115_atocancelamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_atocancelamento"]:$this->si115_atocancelamento);
       if($this->si115_dataatocancelamento == ""){
         $this->si115_dataatocancelamento_dia = ($this->si115_dataatocancelamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_dataatocancelamento_dia"]:$this->si115_dataatocancelamento_dia);
         $this->si115_dataatocancelamento_mes = ($this->si115_dataatocancelamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_dataatocancelamento_mes"]:$this->si115_dataatocancelamento_mes);
         $this->si115_dataatocancelamento_ano = ($this->si115_dataatocancelamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_dataatocancelamento_ano"]:$this->si115_dataatocancelamento_ano);
         if($this->si115_dataatocancelamento_dia != ""){
            $this->si115_dataatocancelamento = $this->si115_dataatocancelamento_ano."-".$this->si115_dataatocancelamento_mes."-".$this->si115_dataatocancelamento_dia;
         }
       }
       $this->si115_mes = ($this->si115_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_mes"]:$this->si115_mes);
       $this->si115_instit = ($this->si115_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_instit"]:$this->si115_instit);
     }else{
       $this->si115_sequencial = ($this->si115_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si115_sequencial"]:$this->si115_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si115_sequencial){ 
      $this->atualizacampos();
     if($this->si115_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si115_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si115_codreduzidomov == null ){ 
       $this->si115_codreduzidomov = "0";
     }
     if($this->si115_nroempenho == null ){ 
       $this->si115_nroempenho = "0";
     }
     if($this->si115_exercicioempenho == null ){ 
       $this->si115_exercicioempenho = "0";
     }
     if($this->si115_dtempenho == null ){ 
       $this->si115_dtempenho = "null";
     }
     if($this->si115_tiporestospagar == null ){ 
       $this->si115_tiporestospagar = "0";
     }
     if($this->si115_tipomovimento == null ){ 
       $this->si115_tipomovimento = "0";
     }
     if($this->si115_dtmovimentacao == null ){ 
       $this->si115_dtmovimentacao = "null";
     }
     if($this->si115_vlmovimentacao == null ){ 
       $this->si115_vlmovimentacao = "0";
     }
     if($this->si115_dataatocancelamento == null ){ 
       $this->si115_dataatocancelamento = "null";
     }
     if($this->si115_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si115_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si115_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si115_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si115_sequencial == "" || $si115_sequencial == null ){
       $result = db_query("select nextval('rsp202015_si115_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rsp202015_si115_sequencial_seq do campo: si115_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si115_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from rsp202015_si115_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si115_sequencial)){
         $this->erro_sql = " Campo si115_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si115_sequencial = $si115_sequencial; 
       }
     }
     if(($this->si115_sequencial == null) || ($this->si115_sequencial == "") ){ 
       $this->erro_sql = " Campo si115_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rsp202015(
                                       si115_sequencial 
                                      ,si115_tiporegistro 
                                      ,si115_codreduzidomov 
                                      ,si115_codorgao 
                                      ,si115_codunidadesub 
                                      ,si115_nroempenho 
                                      ,si115_exercicioempenho 
                                      ,si115_dtempenho 
                                      ,si115_tiporestospagar 
                                      ,si115_tipomovimento 
                                      ,si115_dtmovimentacao 
                                      ,si115_dotorig 
                                      ,si115_vlmovimentacao 
                                      ,si115_codorgaoencampatribuic 
                                      ,si115_codunidadesubencampatribuic 
                                      ,si115_justificativa 
                                      ,si115_atocancelamento 
                                      ,si115_dataatocancelamento 
                                      ,si115_mes 
                                      ,si115_instit 
                       )
                values (
                                $this->si115_sequencial 
                               ,$this->si115_tiporegistro 
                               ,$this->si115_codreduzidomov 
                               ,'$this->si115_codorgao' 
                               ,'$this->si115_codunidadesub' 
                               ,$this->si115_nroempenho 
                               ,$this->si115_exercicioempenho 
                               ,".($this->si115_dtempenho == "null" || $this->si115_dtempenho == ""?"null":"'".$this->si115_dtempenho."'")." 
                               ,$this->si115_tiporestospagar 
                               ,$this->si115_tipomovimento 
                               ,".($this->si115_dtmovimentacao == "null" || $this->si115_dtmovimentacao == ""?"null":"'".$this->si115_dtmovimentacao."'")." 
                               ,'$this->si115_dotorig' 
                               ,$this->si115_vlmovimentacao 
                               ,'$this->si115_codorgaoencampatribuic' 
                               ,'$this->si115_codunidadesubencampatribuic' 
                               ,'$this->si115_justificativa' 
                               ,'$this->si115_atocancelamento' 
                               ,".($this->si115_dataatocancelamento == "null" || $this->si115_dataatocancelamento == ""?"null":"'".$this->si115_dataatocancelamento."'")." 
                               ,$this->si115_mes 
                               ,$this->si115_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "rsp202015 ($this->si115_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "rsp202015 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "rsp202015 ($this->si115_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si115_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si115_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010751,'$this->si115_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010344,2010751,'','".AddSlashes(pg_result($resaco,0,'si115_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010752,'','".AddSlashes(pg_result($resaco,0,'si115_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010753,'','".AddSlashes(pg_result($resaco,0,'si115_codreduzidomov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010754,'','".AddSlashes(pg_result($resaco,0,'si115_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010755,'','".AddSlashes(pg_result($resaco,0,'si115_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010756,'','".AddSlashes(pg_result($resaco,0,'si115_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2011331,'','".AddSlashes(pg_result($resaco,0,'si115_exercicioempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010757,'','".AddSlashes(pg_result($resaco,0,'si115_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010758,'','".AddSlashes(pg_result($resaco,0,'si115_tiporestospagar'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010759,'','".AddSlashes(pg_result($resaco,0,'si115_tipomovimento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010760,'','".AddSlashes(pg_result($resaco,0,'si115_dtmovimentacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010761,'','".AddSlashes(pg_result($resaco,0,'si115_dotorig'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010762,'','".AddSlashes(pg_result($resaco,0,'si115_vlmovimentacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010764,'','".AddSlashes(pg_result($resaco,0,'si115_codorgaoencampatribuic'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010766,'','".AddSlashes(pg_result($resaco,0,'si115_codunidadesubencampatribuic'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010767,'','".AddSlashes(pg_result($resaco,0,'si115_justificativa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010768,'','".AddSlashes(pg_result($resaco,0,'si115_atocancelamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010769,'','".AddSlashes(pg_result($resaco,0,'si115_dataatocancelamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2010770,'','".AddSlashes(pg_result($resaco,0,'si115_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010344,2011628,'','".AddSlashes(pg_result($resaco,0,'si115_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si115_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update rsp202015 set ";
     $virgula = "";
     if(trim($this->si115_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_sequencial"])){ 
        if(trim($this->si115_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si115_sequencial"])){ 
           $this->si115_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si115_sequencial = $this->si115_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si115_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_tiporegistro"])){ 
       $sql  .= $virgula." si115_tiporegistro = $this->si115_tiporegistro ";
       $virgula = ",";
       if(trim($this->si115_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si115_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si115_codreduzidomov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_codreduzidomov"])){ 
        if(trim($this->si115_codreduzidomov)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si115_codreduzidomov"])){ 
           $this->si115_codreduzidomov = "0" ; 
        } 
       $sql  .= $virgula." si115_codreduzidomov = $this->si115_codreduzidomov ";
       $virgula = ",";
     }
     if(trim($this->si115_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_codorgao"])){ 
       $sql  .= $virgula." si115_codorgao = '$this->si115_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si115_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_codunidadesub"])){ 
       $sql  .= $virgula." si115_codunidadesub = '$this->si115_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si115_nroempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_nroempenho"])){ 
        if(trim($this->si115_nroempenho)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si115_nroempenho"])){ 
           $this->si115_nroempenho = "0" ; 
        } 
       $sql  .= $virgula." si115_nroempenho = $this->si115_nroempenho ";
       $virgula = ",";
     }
     if(trim($this->si115_exercicioempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_exercicioempenho"])){ 
        if(trim($this->si115_exercicioempenho)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si115_exercicioempenho"])){ 
           $this->si115_exercicioempenho = "0" ; 
        } 
       $sql  .= $virgula." si115_exercicioempenho = $this->si115_exercicioempenho ";
       $virgula = ",";
     }
     if(trim($this->si115_dtempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_dtempenho_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si115_dtempenho_dia"] !="") ){ 
       $sql  .= $virgula." si115_dtempenho = '$this->si115_dtempenho' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si115_dtempenho_dia"])){ 
         $sql  .= $virgula." si115_dtempenho = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si115_tiporestospagar)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_tiporestospagar"])){ 
        if(trim($this->si115_tiporestospagar)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si115_tiporestospagar"])){ 
           $this->si115_tiporestospagar = "0" ; 
        } 
       $sql  .= $virgula." si115_tiporestospagar = $this->si115_tiporestospagar ";
       $virgula = ",";
     }
     if(trim($this->si115_tipomovimento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_tipomovimento"])){ 
        if(trim($this->si115_tipomovimento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si115_tipomovimento"])){ 
           $this->si115_tipomovimento = "0" ; 
        } 
       $sql  .= $virgula." si115_tipomovimento = $this->si115_tipomovimento ";
       $virgula = ",";
     }
     if(trim($this->si115_dtmovimentacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_dtmovimentacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si115_dtmovimentacao_dia"] !="") ){ 
       $sql  .= $virgula." si115_dtmovimentacao = '$this->si115_dtmovimentacao' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si115_dtmovimentacao_dia"])){ 
         $sql  .= $virgula." si115_dtmovimentacao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si115_dotorig)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_dotorig"])){ 
       $sql  .= $virgula." si115_dotorig = '$this->si115_dotorig' ";
       $virgula = ",";
     }
     if(trim($this->si115_vlmovimentacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_vlmovimentacao"])){ 
        if(trim($this->si115_vlmovimentacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si115_vlmovimentacao"])){ 
           $this->si115_vlmovimentacao = "0" ; 
        } 
       $sql  .= $virgula." si115_vlmovimentacao = $this->si115_vlmovimentacao ";
       $virgula = ",";
     }
     if(trim($this->si115_codorgaoencampatribuic)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_codorgaoencampatribuic"])){ 
       $sql  .= $virgula." si115_codorgaoencampatribuic = '$this->si115_codorgaoencampatribuic' ";
       $virgula = ",";
     }
     if(trim($this->si115_codunidadesubencampatribuic)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_codunidadesubencampatribuic"])){ 
       $sql  .= $virgula." si115_codunidadesubencampatribuic = '$this->si115_codunidadesubencampatribuic' ";
       $virgula = ",";
     }
     if(trim($this->si115_justificativa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_justificativa"])){ 
       $sql  .= $virgula." si115_justificativa = '$this->si115_justificativa' ";
       $virgula = ",";
     }
     if(trim($this->si115_atocancelamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_atocancelamento"])){ 
       $sql  .= $virgula." si115_atocancelamento = '$this->si115_atocancelamento' ";
       $virgula = ",";
     }
     if(trim($this->si115_dataatocancelamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_dataatocancelamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si115_dataatocancelamento_dia"] !="") ){ 
       $sql  .= $virgula." si115_dataatocancelamento = '$this->si115_dataatocancelamento' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si115_dataatocancelamento_dia"])){ 
         $sql  .= $virgula." si115_dataatocancelamento = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si115_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_mes"])){ 
       $sql  .= $virgula." si115_mes = $this->si115_mes ";
       $virgula = ",";
       if(trim($this->si115_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si115_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si115_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si115_instit"])){ 
       $sql  .= $virgula." si115_instit = $this->si115_instit ";
       $virgula = ",";
       if(trim($this->si115_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si115_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si115_sequencial!=null){
       $sql .= " si115_sequencial = $this->si115_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si115_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010751,'$this->si115_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_sequencial"]) || $this->si115_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010751,'".AddSlashes(pg_result($resaco,$conresaco,'si115_sequencial'))."','$this->si115_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_tiporegistro"]) || $this->si115_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010752,'".AddSlashes(pg_result($resaco,$conresaco,'si115_tiporegistro'))."','$this->si115_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_codreduzidomov"]) || $this->si115_codreduzidomov != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010753,'".AddSlashes(pg_result($resaco,$conresaco,'si115_codreduzidomov'))."','$this->si115_codreduzidomov',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_codorgao"]) || $this->si115_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010754,'".AddSlashes(pg_result($resaco,$conresaco,'si115_codorgao'))."','$this->si115_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_codunidadesub"]) || $this->si115_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010755,'".AddSlashes(pg_result($resaco,$conresaco,'si115_codunidadesub'))."','$this->si115_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_nroempenho"]) || $this->si115_nroempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010756,'".AddSlashes(pg_result($resaco,$conresaco,'si115_nroempenho'))."','$this->si115_nroempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_exercicioempenho"]) || $this->si115_exercicioempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2011331,'".AddSlashes(pg_result($resaco,$conresaco,'si115_exercicioempenho'))."','$this->si115_exercicioempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_dtempenho"]) || $this->si115_dtempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010757,'".AddSlashes(pg_result($resaco,$conresaco,'si115_dtempenho'))."','$this->si115_dtempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_tiporestospagar"]) || $this->si115_tiporestospagar != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010758,'".AddSlashes(pg_result($resaco,$conresaco,'si115_tiporestospagar'))."','$this->si115_tiporestospagar',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_tipomovimento"]) || $this->si115_tipomovimento != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010759,'".AddSlashes(pg_result($resaco,$conresaco,'si115_tipomovimento'))."','$this->si115_tipomovimento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_dtmovimentacao"]) || $this->si115_dtmovimentacao != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010760,'".AddSlashes(pg_result($resaco,$conresaco,'si115_dtmovimentacao'))."','$this->si115_dtmovimentacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_dotorig"]) || $this->si115_dotorig != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010761,'".AddSlashes(pg_result($resaco,$conresaco,'si115_dotorig'))."','$this->si115_dotorig',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_vlmovimentacao"]) || $this->si115_vlmovimentacao != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010762,'".AddSlashes(pg_result($resaco,$conresaco,'si115_vlmovimentacao'))."','$this->si115_vlmovimentacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_codorgaoencampatribuic"]) || $this->si115_codorgaoencampatribuic != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010764,'".AddSlashes(pg_result($resaco,$conresaco,'si115_codorgaoencampatribuic'))."','$this->si115_codorgaoencampatribuic',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_codunidadesubencampatribuic"]) || $this->si115_codunidadesubencampatribuic != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010766,'".AddSlashes(pg_result($resaco,$conresaco,'si115_codunidadesubencampatribuic'))."','$this->si115_codunidadesubencampatribuic',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_justificativa"]) || $this->si115_justificativa != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010767,'".AddSlashes(pg_result($resaco,$conresaco,'si115_justificativa'))."','$this->si115_justificativa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_atocancelamento"]) || $this->si115_atocancelamento != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010768,'".AddSlashes(pg_result($resaco,$conresaco,'si115_atocancelamento'))."','$this->si115_atocancelamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_dataatocancelamento"]) || $this->si115_dataatocancelamento != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010769,'".AddSlashes(pg_result($resaco,$conresaco,'si115_dataatocancelamento'))."','$this->si115_dataatocancelamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_mes"]) || $this->si115_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2010770,'".AddSlashes(pg_result($resaco,$conresaco,'si115_mes'))."','$this->si115_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si115_instit"]) || $this->si115_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010344,2011628,'".AddSlashes(pg_result($resaco,$conresaco,'si115_instit'))."','$this->si115_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rsp202015 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si115_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "rsp202015 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si115_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si115_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si115_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si115_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010751,'$si115_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010344,2010751,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010752,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010753,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_codreduzidomov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010754,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010755,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010756,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2011331,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_exercicioempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010757,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010758,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_tiporestospagar'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010759,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_tipomovimento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010760,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_dtmovimentacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010761,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_dotorig'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010762,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_vlmovimentacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010764,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_codorgaoencampatribuic'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010766,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_codunidadesubencampatribuic'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010767,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_justificativa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010768,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_atocancelamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010769,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_dataatocancelamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2010770,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010344,2011628,'','".AddSlashes(pg_result($resaco,$iresaco,'si115_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from rsp202015
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si115_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si115_sequencial = $si115_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rsp202015 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si115_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "rsp202015 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si115_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si115_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:rsp202015";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si115_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rsp202015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si115_sequencial!=null ){
         $sql2 .= " where rsp202015.si115_sequencial = $si115_sequencial "; 
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
   function sql_query_file ( $si115_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rsp202015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si115_sequencial!=null ){
         $sql2 .= " where rsp202015.si115_sequencial = $si115_sequencial "; 
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
