<?
//MODULO: sicom
//CLASSE DA ENTIDADE contratos202021
class cl_contratos202021 {
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
   var $si87_sequencial = 0;
   var $si87_tiporegistro = 0;
   var $si87_codaditivo = 0;
   var $si87_codorgao = null;
   var $si87_codunidadesub = null;
   var $si87_nrocontrato = 0;
   var $si87_dtassinaturacontoriginal_dia = null;
   var $si87_dtassinaturacontoriginal_mes = null;
   var $si87_dtassinaturacontoriginal_ano = null;
   var $si87_dtassinaturacontoriginal = null;
   var $si87_nroseqtermoaditivo = null;
   var $si87_dtassinaturatermoaditivo_dia = null;
   var $si87_dtassinaturatermoaditivo_mes = null;
   var $si87_dtassinaturatermoaditivo_ano = null;
   var $si87_dtassinaturatermoaditivo = null;
   var $si87_tipoalteracaovalor = 0;
   var $si87_tipotermoaditivo = null;
   var $si87_dscalteracao = null;
   var $si87_novadatatermino_dia = null;
   var $si87_novadatatermino_mes = null;
   var $si87_novadatatermino_ano = null;
   var $si87_novadatatermino = null;
   var $si87_valoraditivo = 0;
   var $si87_datapublicacao_dia = null;
   var $si87_datapublicacao_mes = null;
   var $si87_datapublicacao_ano = null;
   var $si87_datapublicacao = null;
   var $si87_veiculodivulgacao = null;
   var $si87_mes = 0;
   var $si87_instit = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si87_sequencial = int8 = sequencial
                 si87_tiporegistro = int8 = Tipo do registro
                 si87_codaditivo = int8 = Código do Termo  Aditivo
                 si87_codorgao = varchar(2) = Código do órgão
                 si87_codunidadesub = varchar(8) = Código da unidade
                 si87_nrocontrato = int8 = Número do  Contrato Original
                 si87_dtassinaturacontoriginal = date = Data da assinatura  do Contrato
                 si87_nroseqtermoaditivo = varchar(2) = Número sequencial do Termo Aditivo
                 si87_dtassinaturatermoaditivo = date = Data da assinatura  do Termo Aditivo
                 si87_tipoalteracaovalor = int8 = Tipo de alteração  de valor
                 si87_tipotermoaditivo = varchar(2) = Tipo de Termo de  Aditivo
                 si87_dscalteracao = varchar(250) = Descrição da  alteração
                 si87_novadatatermino = date = Nova Data de  Término
                 si87_valoraditivo = float8 = Valor do Termo  Aditivo
                 si87_datapublicacao = date = Data da Publicação
                 si87_veiculodivulgacao = varchar(50) = Veículo de  Divulgação
                 si87_mes = int8 = Mês
                 si87_instit = int8 = Instituição
                 ";
   //funcao construtor da classe
   function cl_contratos202021() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("contratos202021");
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
       $this->si87_sequencial = ($this->si87_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_sequencial"]:$this->si87_sequencial);
       $this->si87_tiporegistro = ($this->si87_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_tiporegistro"]:$this->si87_tiporegistro);
       $this->si87_codaditivo = ($this->si87_codaditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_codaditivo"]:$this->si87_codaditivo);
       $this->si87_codorgao = ($this->si87_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_codorgao"]:$this->si87_codorgao);
       $this->si87_codunidadesub = ($this->si87_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_codunidadesub"]:$this->si87_codunidadesub);
       $this->si87_nrocontrato = ($this->si87_nrocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_nrocontrato"]:$this->si87_nrocontrato);
       if($this->si87_dtassinaturacontoriginal == ""){
         $this->si87_dtassinaturacontoriginal_dia = ($this->si87_dtassinaturacontoriginal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturacontoriginal_dia"]:$this->si87_dtassinaturacontoriginal_dia);
         $this->si87_dtassinaturacontoriginal_mes = ($this->si87_dtassinaturacontoriginal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturacontoriginal_mes"]:$this->si87_dtassinaturacontoriginal_mes);
         $this->si87_dtassinaturacontoriginal_ano = ($this->si87_dtassinaturacontoriginal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturacontoriginal_ano"]:$this->si87_dtassinaturacontoriginal_ano);
         if($this->si87_dtassinaturacontoriginal_dia != ""){
            $this->si87_dtassinaturacontoriginal = $this->si87_dtassinaturacontoriginal_ano."-".$this->si87_dtassinaturacontoriginal_mes."-".$this->si87_dtassinaturacontoriginal_dia;
         }
       }
       $this->si87_nroseqtermoaditivo = ($this->si87_nroseqtermoaditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_nroseqtermoaditivo"]:$this->si87_nroseqtermoaditivo);
       if($this->si87_dtassinaturatermoaditivo == ""){
         $this->si87_dtassinaturatermoaditivo_dia = ($this->si87_dtassinaturatermoaditivo_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturatermoaditivo_dia"]:$this->si87_dtassinaturatermoaditivo_dia);
         $this->si87_dtassinaturatermoaditivo_mes = ($this->si87_dtassinaturatermoaditivo_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturatermoaditivo_mes"]:$this->si87_dtassinaturatermoaditivo_mes);
         $this->si87_dtassinaturatermoaditivo_ano = ($this->si87_dtassinaturatermoaditivo_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturatermoaditivo_ano"]:$this->si87_dtassinaturatermoaditivo_ano);
         if($this->si87_dtassinaturatermoaditivo_dia != ""){
            $this->si87_dtassinaturatermoaditivo = $this->si87_dtassinaturatermoaditivo_ano."-".$this->si87_dtassinaturatermoaditivo_mes."-".$this->si87_dtassinaturatermoaditivo_dia;
         }
       }
       $this->si87_tipoalteracaovalor = ($this->si87_tipoalteracaovalor == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_tipoalteracaovalor"]:$this->si87_tipoalteracaovalor);
       $this->si87_tipotermoaditivo = ($this->si87_tipotermoaditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_tipotermoaditivo"]:$this->si87_tipotermoaditivo);
       $this->si87_dscalteracao = ($this->si87_dscalteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_dscalteracao"]:$this->si87_dscalteracao);
       if($this->si87_novadatatermino == ""){
         $this->si87_novadatatermino_dia = ($this->si87_novadatatermino_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_novadatatermino_dia"]:$this->si87_novadatatermino_dia);
         $this->si87_novadatatermino_mes = ($this->si87_novadatatermino_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_novadatatermino_mes"]:$this->si87_novadatatermino_mes);
         $this->si87_novadatatermino_ano = ($this->si87_novadatatermino_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_novadatatermino_ano"]:$this->si87_novadatatermino_ano);
         if($this->si87_novadatatermino_dia != ""){
            $this->si87_novadatatermino = $this->si87_novadatatermino_ano."-".$this->si87_novadatatermino_mes."-".$this->si87_novadatatermino_dia;
         }
       }
       $this->si87_valoraditivo = ($this->si87_valoraditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_valoraditivo"]:$this->si87_valoraditivo);
       if($this->si87_datapublicacao == ""){
         $this->si87_datapublicacao_dia = ($this->si87_datapublicacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_datapublicacao_dia"]:$this->si87_datapublicacao_dia);
         $this->si87_datapublicacao_mes = ($this->si87_datapublicacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_datapublicacao_mes"]:$this->si87_datapublicacao_mes);
         $this->si87_datapublicacao_ano = ($this->si87_datapublicacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_datapublicacao_ano"]:$this->si87_datapublicacao_ano);
         if($this->si87_datapublicacao_dia != ""){
            $this->si87_datapublicacao = $this->si87_datapublicacao_ano."-".$this->si87_datapublicacao_mes."-".$this->si87_datapublicacao_dia;
         }
       }
       $this->si87_veiculodivulgacao = ($this->si87_veiculodivulgacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_veiculodivulgacao"]:$this->si87_veiculodivulgacao);
       $this->si87_mes = ($this->si87_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_mes"]:$this->si87_mes);
       $this->si87_instit = ($this->si87_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_instit"]:$this->si87_instit);
     }else{
       $this->si87_sequencial = ($this->si87_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si87_sequencial"]:$this->si87_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si87_sequencial){
      $this->atualizacampos();
     if($this->si87_tiporegistro == null ){
       $this->erro_sql = " Campo Tipo do registro nao Informado.";
       $this->erro_campo = "si87_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si87_codaditivo == null ){
       $this->si87_codaditivo = "0";
     }
     if($this->si87_nrocontrato == null ){
       $this->si87_nrocontrato = "0";
     }
     if($this->si87_dtassinaturacontoriginal == null ){
       $this->si87_dtassinaturacontoriginal = "null";
     }
     if($this->si87_dtassinaturatermoaditivo == null ){
       $this->si87_dtassinaturatermoaditivo = "null";
     }
     if($this->si87_tipoalteracaovalor == null ){
       $this->si87_tipoalteracaovalor = "0";
     }
     if($this->si87_novadatatermino == null ){
       $this->si87_novadatatermino = "null";
     }
     if($this->si87_valoraditivo == null ){
       $this->si87_valoraditivo = "0";
     }
     if($this->si87_datapublicacao == null ){
       $this->si87_datapublicacao = "null";
     }
     if($this->si87_mes == null ){
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si87_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si87_instit == null ){
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si87_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($si87_sequencial == "" || $si87_sequencial == null ){
       $result = db_query("select nextval('sicom2021.contratos202021_si87_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: contratos202021_si87_sequencial_seq do campo: si87_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si87_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from sicom2021.contratos202021_si87_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si87_sequencial)){
         $this->erro_sql = " Campo si87_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si87_sequencial = $si87_sequencial;
       }
     }
     if(($this->si87_sequencial == null) || ($this->si87_sequencial == "") ){
       $this->erro_sql = " Campo si87_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into sicom2021.contratos202021(
                                       si87_sequencial
                                      ,si87_tiporegistro
                                      ,si87_codaditivo
                                      ,si87_codorgao
                                      ,si87_codunidadesub
                                      ,si87_nrocontrato
                                      ,si87_dtassinaturacontoriginal
                                      ,si87_nroseqtermoaditivo
                                      ,si87_dtassinaturatermoaditivo
                                      ,si87_tipoalteracaovalor
                                      ,si87_tipotermoaditivo
                                      ,si87_dscalteracao
                                      ,si87_novadatatermino
                                      ,si87_valoraditivo
                                      ,si87_datapublicacao
                                      ,si87_veiculodivulgacao
                                      ,si87_mes
                                      ,si87_instit
                       )
                values (
                                $this->si87_sequencial
                               ,$this->si87_tiporegistro
                               ,$this->si87_codaditivo
                               ,'$this->si87_codorgao'
                               ,'$this->si87_codunidadesub'
                               ,$this->si87_nrocontrato
                               ,".($this->si87_dtassinaturacontoriginal == "null" || $this->si87_dtassinaturacontoriginal == ""?"null":"'".$this->si87_dtassinaturacontoriginal."'")."
                               ,'$this->si87_nroseqtermoaditivo'
                               ,".($this->si87_dtassinaturatermoaditivo == "null" || $this->si87_dtassinaturatermoaditivo == ""?"null":"'".$this->si87_dtassinaturatermoaditivo."'")."
                               ,$this->si87_tipoalteracaovalor
                               ,'$this->si87_tipotermoaditivo'
                               ,'$this->si87_dscalteracao'
                               ,".($this->si87_novadatatermino == "null" || $this->si87_novadatatermino == ""?"null":"'".$this->si87_novadatatermino."'")."
                               ,$this->si87_valoraditivo
                               ,".($this->si87_datapublicacao == "null" || $this->si87_datapublicacao == ""?"null":"'".$this->si87_datapublicacao."'")."
                               ,'$this->si87_veiculodivulgacao'
                               ,$this->si87_mes
                               ,$this->si87_instit
                      )";
     $result = db_query($sql);
     // print_r($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "contratos202021 ($this->si87_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "contratos202021 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "contratos202021 ($this->si87_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si87_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si87_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010458,'$this->si87_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010316,2010458,'','".AddSlashes(pg_result($resaco,0,'si87_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010459,'','".AddSlashes(pg_result($resaco,0,'si87_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010460,'','".AddSlashes(pg_result($resaco,0,'si87_codaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010461,'','".AddSlashes(pg_result($resaco,0,'si87_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010462,'','".AddSlashes(pg_result($resaco,0,'si87_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010463,'','".AddSlashes(pg_result($resaco,0,'si87_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010464,'','".AddSlashes(pg_result($resaco,0,'si87_dtassinaturacontoriginal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010465,'','".AddSlashes(pg_result($resaco,0,'si87_nroseqtermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010466,'','".AddSlashes(pg_result($resaco,0,'si87_dtassinaturatermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010467,'','".AddSlashes(pg_result($resaco,0,'si87_tipoalteracaovalor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010468,'','".AddSlashes(pg_result($resaco,0,'si87_tipotermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010469,'','".AddSlashes(pg_result($resaco,0,'si87_dscalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010470,'','".AddSlashes(pg_result($resaco,0,'si87_novadatatermino'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010471,'','".AddSlashes(pg_result($resaco,0,'si87_valoraditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010472,'','".AddSlashes(pg_result($resaco,0,'si87_datapublicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010473,'','".AddSlashes(pg_result($resaco,0,'si87_veiculodivulgacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2010474,'','".AddSlashes(pg_result($resaco,0,'si87_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010316,2011600,'','".AddSlashes(pg_result($resaco,0,'si87_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($si87_sequencial=null) {
      $this->atualizacampos();
     $sql = " update sicom2021.contratos202021 set ";
     $virgula = "";
     if(trim($this->si87_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_sequencial"])){
        if(trim($this->si87_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si87_sequencial"])){
           $this->si87_sequencial = "0" ;
        }
       $sql  .= $virgula." si87_sequencial = $this->si87_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si87_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_tiporegistro"])){
       $sql  .= $virgula." si87_tiporegistro = $this->si87_tiporegistro ";
       $virgula = ",";
       if(trim($this->si87_tiporegistro) == null ){
         $this->erro_sql = " Campo Tipo do registro nao Informado.";
         $this->erro_campo = "si87_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si87_codaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_codaditivo"])){
        if(trim($this->si87_codaditivo)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si87_codaditivo"])){
           $this->si87_codaditivo = "0" ;
        }
       $sql  .= $virgula." si87_codaditivo = $this->si87_codaditivo ";
       $virgula = ",";
     }
     if(trim($this->si87_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_codorgao"])){
       $sql  .= $virgula." si87_codorgao = '$this->si87_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si87_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_codunidadesub"])){
       $sql  .= $virgula." si87_codunidadesub = '$this->si87_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si87_nrocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_nrocontrato"])){
        if(trim($this->si87_nrocontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si87_nrocontrato"])){
           $this->si87_nrocontrato = "0" ;
        }
       $sql  .= $virgula." si87_nrocontrato = $this->si87_nrocontrato ";
       $virgula = ",";
     }
     if(trim($this->si87_dtassinaturacontoriginal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturacontoriginal_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturacontoriginal_dia"] !="") ){
       $sql  .= $virgula." si87_dtassinaturacontoriginal = '$this->si87_dtassinaturacontoriginal' ";
       $virgula = ",";
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturacontoriginal_dia"])){
         $sql  .= $virgula." si87_dtassinaturacontoriginal = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si87_nroseqtermoaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_nroseqtermoaditivo"])){
       $sql  .= $virgula." si87_nroseqtermoaditivo = '$this->si87_nroseqtermoaditivo' ";
       $virgula = ",";
     }
     if(trim($this->si87_dtassinaturatermoaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturatermoaditivo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturatermoaditivo_dia"] !="") ){
       $sql  .= $virgula." si87_dtassinaturatermoaditivo = '$this->si87_dtassinaturatermoaditivo' ";
       $virgula = ",";
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturatermoaditivo_dia"])){
         $sql  .= $virgula." si87_dtassinaturatermoaditivo = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si87_tipoalteracaovalor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_tipoalteracaovalor"])){
        if(trim($this->si87_tipoalteracaovalor)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si87_tipoalteracaovalor"])){
           $this->si87_tipoalteracaovalor = "0" ;
        }
       $sql  .= $virgula." si87_tipoalteracaovalor = $this->si87_tipoalteracaovalor ";
       $virgula = ",";
     }
     if(trim($this->si87_tipotermoaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_tipotermoaditivo"])){
       $sql  .= $virgula." si87_tipotermoaditivo = '$this->si87_tipotermoaditivo' ";
       $virgula = ",";
     }
     if(trim($this->si87_dscalteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_dscalteracao"])){
       $sql  .= $virgula." si87_dscalteracao = '$this->si87_dscalteracao' ";
       $virgula = ",";
     }
     if(trim($this->si87_novadatatermino)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_novadatatermino_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si87_novadatatermino_dia"] !="") ){
       $sql  .= $virgula." si87_novadatatermino = '$this->si87_novadatatermino' ";
       $virgula = ",";
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["si87_novadatatermino_dia"])){
         $sql  .= $virgula." si87_novadatatermino = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si87_valoraditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_valoraditivo"])){
        if(trim($this->si87_valoraditivo)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si87_valoraditivo"])){
           $this->si87_valoraditivo = "0" ;
        }
       $sql  .= $virgula." si87_valoraditivo = $this->si87_valoraditivo ";
       $virgula = ",";
     }
     if(trim($this->si87_datapublicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_datapublicacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si87_datapublicacao_dia"] !="") ){
       $sql  .= $virgula." si87_datapublicacao = '$this->si87_datapublicacao' ";
       $virgula = ",";
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["si87_datapublicacao_dia"])){
         $sql  .= $virgula." si87_datapublicacao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si87_veiculodivulgacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_veiculodivulgacao"])){
       $sql  .= $virgula." si87_veiculodivulgacao = '$this->si87_veiculodivulgacao' ";
       $virgula = ",";
     }
     if(trim($this->si87_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_mes"])){
       $sql  .= $virgula." si87_mes = $this->si87_mes ";
       $virgula = ",";
       if(trim($this->si87_mes) == null ){
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si87_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si87_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si87_instit"])){
       $sql  .= $virgula." si87_instit = $this->si87_instit ";
       $virgula = ",";
       if(trim($this->si87_instit) == null ){
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si87_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si87_sequencial!=null){
       $sql .= " si87_sequencial = $this->si87_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si87_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010458,'$this->si87_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_sequencial"]) || $this->si87_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010458,'".AddSlashes(pg_result($resaco,$conresaco,'si87_sequencial'))."','$this->si87_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_tiporegistro"]) || $this->si87_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010459,'".AddSlashes(pg_result($resaco,$conresaco,'si87_tiporegistro'))."','$this->si87_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_codaditivo"]) || $this->si87_codaditivo != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010460,'".AddSlashes(pg_result($resaco,$conresaco,'si87_codaditivo'))."','$this->si87_codaditivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_codorgao"]) || $this->si87_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010461,'".AddSlashes(pg_result($resaco,$conresaco,'si87_codorgao'))."','$this->si87_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_codunidadesub"]) || $this->si87_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010462,'".AddSlashes(pg_result($resaco,$conresaco,'si87_codunidadesub'))."','$this->si87_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_nrocontrato"]) || $this->si87_nrocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010463,'".AddSlashes(pg_result($resaco,$conresaco,'si87_nrocontrato'))."','$this->si87_nrocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturacontoriginal"]) || $this->si87_dtassinaturacontoriginal != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010464,'".AddSlashes(pg_result($resaco,$conresaco,'si87_dtassinaturacontoriginal'))."','$this->si87_dtassinaturacontoriginal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_nroseqtermoaditivo"]) || $this->si87_nroseqtermoaditivo != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010465,'".AddSlashes(pg_result($resaco,$conresaco,'si87_nroseqtermoaditivo'))."','$this->si87_nroseqtermoaditivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_dtassinaturatermoaditivo"]) || $this->si87_dtassinaturatermoaditivo != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010466,'".AddSlashes(pg_result($resaco,$conresaco,'si87_dtassinaturatermoaditivo'))."','$this->si87_dtassinaturatermoaditivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_tipoalteracaovalor"]) || $this->si87_tipoalteracaovalor != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010467,'".AddSlashes(pg_result($resaco,$conresaco,'si87_tipoalteracaovalor'))."','$this->si87_tipoalteracaovalor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_tipotermoaditivo"]) || $this->si87_tipotermoaditivo != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010468,'".AddSlashes(pg_result($resaco,$conresaco,'si87_tipotermoaditivo'))."','$this->si87_tipotermoaditivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_dscalteracao"]) || $this->si87_dscalteracao != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010469,'".AddSlashes(pg_result($resaco,$conresaco,'si87_dscalteracao'))."','$this->si87_dscalteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_novadatatermino"]) || $this->si87_novadatatermino != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010470,'".AddSlashes(pg_result($resaco,$conresaco,'si87_novadatatermino'))."','$this->si87_novadatatermino',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_valoraditivo"]) || $this->si87_valoraditivo != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010471,'".AddSlashes(pg_result($resaco,$conresaco,'si87_valoraditivo'))."','$this->si87_valoraditivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_datapublicacao"]) || $this->si87_datapublicacao != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010472,'".AddSlashes(pg_result($resaco,$conresaco,'si87_datapublicacao'))."','$this->si87_datapublicacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_veiculodivulgacao"]) || $this->si87_veiculodivulgacao != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010473,'".AddSlashes(pg_result($resaco,$conresaco,'si87_veiculodivulgacao'))."','$this->si87_veiculodivulgacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_mes"]) || $this->si87_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2010474,'".AddSlashes(pg_result($resaco,$conresaco,'si87_mes'))."','$this->si87_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si87_instit"]) || $this->si87_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010316,2011600,'".AddSlashes(pg_result($resaco,$conresaco,'si87_instit'))."','$this->si87_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "contratos202021 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si87_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos202021 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si87_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si87_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si87_sequencial=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si87_sequencial));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010458,'$si87_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010316,2010458,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010459,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010460,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_codaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010461,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010462,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010463,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010464,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_dtassinaturacontoriginal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010465,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_nroseqtermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010466,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_dtassinaturatermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010467,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_tipoalteracaovalor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010468,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_tipotermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010469,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_dscalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010470,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_novadatatermino'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010471,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_valoraditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010472,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_datapublicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010473,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_veiculodivulgacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2010474,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010316,2011600,'','".AddSlashes(pg_result($resaco,$iresaco,'si87_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from sicom2021.contratos202021
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si87_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si87_sequencial = $si87_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "contratos202021 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si87_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos202021 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si87_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si87_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:contratos202021";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si87_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from sicom2021.contratos202021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si87_sequencial!=null ){
         $sql2 .= " where si87_sequencial = $si87_sequencial ";
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
   function sql_query_file ( $si87_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from sicom2021.contratos202021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si87_sequencial!=null ){
         $sql2 .= " where si87_sequencial = $si87_sequencial ";
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
