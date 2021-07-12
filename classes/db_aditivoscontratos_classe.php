<?
//MODULO: sicom
//CLASSE DA ENTIDADE aditivoscontratos
class cl_aditivoscontratos { 
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
   var $si174_sequencial = 0; 
   var $si174_codunidadesub = null; 
   var $si174_nrocontrato = 0; 
   var $si174_dataassinaturacontoriginal_dia = null; 
   var $si174_dataassinaturacontoriginal_mes = null; 
   var $si174_dataassinaturacontoriginal_ano = null; 
   var $si174_dataassinaturacontoriginal = null; 
   var $si174_nroseqtermoaditivo = 0; 
   var $si174_dataassinaturatermoaditivo_dia = null; 
   var $si174_dataassinaturatermoaditivo_mes = null; 
   var $si174_dataassinaturatermoaditivo_ano = null; 
   var $si174_dataassinaturatermoaditivo = null; 
   var $si174_tipoalteracaovalor = 0; 
   var $si174_tipotermoaditivo = null; 
   var $si174_dscalteracao = null; 
   var $si174_novadatatermino_dia = null; 
   var $si174_novadatatermino_mes = null; 
   var $si174_novadatatermino_ano = null; 
   var $si174_novadatatermino = null; 
   var $si174_valoraditivo = 0; 
   var $si174_datapublicacao_dia = null; 
   var $si174_datapublicacao_mes = null; 
   var $si174_datapublicacao_ano = null; 
   var $si174_datapublicacao = null; 
   var $si174_veiculodivulgacao = null; 
   var $si174_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si174_sequencial = int8 = sequencial 
                 si174_codunidadesub = varchar(8) = Código da unidade 
                 si174_nrocontrato = int8 = Número do Contrato Original 
                 si174_dataassinaturacontoriginal = date = Data da assinatura do Contrato 
                 si174_nroseqtermoaditivo = int8 = Nro seq do Termo Aditivo 
                 si174_dataassinaturatermoaditivo = date = Data da assinatura do Termo 
                 si174_tipoalteracaovalor = int8 = Tipo de alteração de valor 
                 si174_tipotermoaditivo = varchar(2) = Tipo de Termo de Aditivo 
                 si174_dscalteracao = text = Descrição da alteração 
                 si174_novadatatermino = date = Nova Data de Término 
                 si174_valoraditivo = float8 = Valor do Termo Aditivo 
                 si174_datapublicacao = date = Data da Publicação do Termo 
                 si174_veiculodivulgacao = varchar(50) = Veículo de divulgação 
                 si174_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_aditivoscontratos() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("aditivoscontratos"); 
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
       $this->si174_sequencial = ($this->si174_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_sequencial"]:$this->si174_sequencial);
       $this->si174_codunidadesub = ($this->si174_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_codunidadesub"]:$this->si174_codunidadesub);
       $this->si174_nrocontrato = ($this->si174_nrocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_nrocontrato"]:$this->si174_nrocontrato);
       if($this->si174_dataassinaturacontoriginal == ""){
         $this->si174_dataassinaturacontoriginal_dia = ($this->si174_dataassinaturacontoriginal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturacontoriginal_dia"]:$this->si174_dataassinaturacontoriginal_dia);
         $this->si174_dataassinaturacontoriginal_mes = ($this->si174_dataassinaturacontoriginal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturacontoriginal_mes"]:$this->si174_dataassinaturacontoriginal_mes);
         $this->si174_dataassinaturacontoriginal_ano = ($this->si174_dataassinaturacontoriginal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturacontoriginal_ano"]:$this->si174_dataassinaturacontoriginal_ano);
         if($this->si174_dataassinaturacontoriginal_dia != ""){
            $this->si174_dataassinaturacontoriginal = $this->si174_dataassinaturacontoriginal_ano."-".$this->si174_dataassinaturacontoriginal_mes."-".$this->si174_dataassinaturacontoriginal_dia;
         }
       }
       $this->si174_nroseqtermoaditivo = ($this->si174_nroseqtermoaditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_nroseqtermoaditivo"]:$this->si174_nroseqtermoaditivo);
       if($this->si174_dataassinaturatermoaditivo == ""){
         $this->si174_dataassinaturatermoaditivo_dia = ($this->si174_dataassinaturatermoaditivo_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturatermoaditivo_dia"]:$this->si174_dataassinaturatermoaditivo_dia);
         $this->si174_dataassinaturatermoaditivo_mes = ($this->si174_dataassinaturatermoaditivo_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturatermoaditivo_mes"]:$this->si174_dataassinaturatermoaditivo_mes);
         $this->si174_dataassinaturatermoaditivo_ano = ($this->si174_dataassinaturatermoaditivo_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturatermoaditivo_ano"]:$this->si174_dataassinaturatermoaditivo_ano);
         if($this->si174_dataassinaturatermoaditivo_dia != ""){
            $this->si174_dataassinaturatermoaditivo = $this->si174_dataassinaturatermoaditivo_ano."-".$this->si174_dataassinaturatermoaditivo_mes."-".$this->si174_dataassinaturatermoaditivo_dia;
         }
       }
       $this->si174_tipoalteracaovalor = ($this->si174_tipoalteracaovalor == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_tipoalteracaovalor"]:$this->si174_tipoalteracaovalor);
       $this->si174_tipotermoaditivo = ($this->si174_tipotermoaditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_tipotermoaditivo"]:$this->si174_tipotermoaditivo);
       $this->si174_dscalteracao = ($this->si174_dscalteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_dscalteracao"]:$this->si174_dscalteracao);
       if($this->si174_novadatatermino == ""){
         $this->si174_novadatatermino_dia = ($this->si174_novadatatermino_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_novadatatermino_dia"]:$this->si174_novadatatermino_dia);
         $this->si174_novadatatermino_mes = ($this->si174_novadatatermino_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_novadatatermino_mes"]:$this->si174_novadatatermino_mes);
         $this->si174_novadatatermino_ano = ($this->si174_novadatatermino_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_novadatatermino_ano"]:$this->si174_novadatatermino_ano);
         if($this->si174_novadatatermino_dia != ""){
            $this->si174_novadatatermino = $this->si174_novadatatermino_ano."-".$this->si174_novadatatermino_mes."-".$this->si174_novadatatermino_dia;
         }
       }
       $this->si174_valoraditivo = ($this->si174_valoraditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_valoraditivo"]:$this->si174_valoraditivo);
       if($this->si174_datapublicacao == ""){
         $this->si174_datapublicacao_dia = ($this->si174_datapublicacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_datapublicacao_dia"]:$this->si174_datapublicacao_dia);
         $this->si174_datapublicacao_mes = ($this->si174_datapublicacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_datapublicacao_mes"]:$this->si174_datapublicacao_mes);
         $this->si174_datapublicacao_ano = ($this->si174_datapublicacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_datapublicacao_ano"]:$this->si174_datapublicacao_ano);
         if($this->si174_datapublicacao_dia != ""){
            $this->si174_datapublicacao = $this->si174_datapublicacao_ano."-".$this->si174_datapublicacao_mes."-".$this->si174_datapublicacao_dia;
         }
       }
       $this->si174_veiculodivulgacao = ($this->si174_veiculodivulgacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_veiculodivulgacao"]:$this->si174_veiculodivulgacao);
       $this->si174_instit = ($this->si174_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_instit"]:$this->si174_instit);
     }else{
       $this->si174_sequencial = ($this->si174_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si174_sequencial"]:$this->si174_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si174_sequencial){ 
      $this->atualizacampos();
     if($this->si174_nrocontrato == null ){
       $this->erro_sql = " Campo Número do Contrato Original nao Informado.";
       $this->erro_campo = "si174_nrocontrato";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si174_dataassinaturacontoriginal == null ){ 
       $this->erro_sql = " Campo Data da assinatura do Contrato nao Informado.";
       $this->erro_campo = "si174_dataassinaturacontoriginal_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si174_dataassinaturacontoriginal_ano >= 2014) {
       $result = db_query("select * from contratos where si172_nrocontrato = {$this->si174_nrocontrato} and si172_dataassinatura = '{$this->si174_dataassinaturacontoriginal}'");
       if(pg_num_rows($result) == 0) {
       	 $this->erro_sql = "Contrato informado não existe";
         $this->erro_campo = "si174_nrocontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if($this->si174_nroseqtermoaditivo == null ){ 
       $this->erro_sql = " Campo Nro seq do Termo Aditivo nao Informado.";
       $this->erro_campo = "si174_nroseqtermoaditivo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si174_dataassinaturatermoaditivo == null ){ 
       $this->erro_sql = " Campo Data da assinatura do Termo nao Informado.";
       $this->erro_campo = "si174_dataassinaturatermoaditivo_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si174_tipoalteracaovalor == null ){ 
       $this->erro_sql = " Campo Tipo de alteração de valor nao Informado.";
       $this->erro_campo = "si174_tipoalteracaovalor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si174_tipotermoaditivo == null ){ 
       $this->erro_sql = " Campo Tipo de Termo de Aditivo nao Informado.";
       $this->erro_campo = "si174_tipotermoaditivo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si174_dscalteracao == null ){ 
       $this->erro_sql = " Campo Descrição da alteração nao Informado.";
       $this->erro_campo = "si174_dscalteracao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si174_novadatatermino == null ){ 
       $this->si174_novadatatermino = "null";
     }
     if($this->si174_valoraditivo == null ){ 
       $this->erro_sql = " Campo Valor do Termo Aditivo nao Informado.";
       $this->erro_campo = "si174_valoraditivo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si174_datapublicacao == null ){ 
       $this->erro_sql = " Campo Data da Publicação do Termo nao Informado.";
       $this->erro_campo = "si174_datapublicacao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si174_veiculodivulgacao == null ){ 
       $this->erro_sql = " Campo Veículo de divulgação nao Informado.";
       $this->erro_campo = "si174_veiculodivulgacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si174_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si174_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       /**
        * verificação para não permitir incluir aditivos repetidos
        */
       $sqlVerifica = " select 1 from aditivoscontratos where si174_nrocontrato = ".$this->si174_nrocontrato." and
       si174_dataassinaturacontoriginal = '".$this->si174_dataassinaturacontoriginal."' and si174_nroseqtermoaditivo = ".$this->si174_nroseqtermoaditivo."
       and si174_codunidadesub = '".$this->si174_codunidadesub."'";
       $result = db_query($sqlVerifica);
       if(pg_num_rows($result) > 0) {
           $this->erro_msg = "Já existe um aditivo para este Contrato com as mesmas informações.";
           $this->erro_status = "0";
           return false;
       }
     if($si174_sequencial == "" || $si174_sequencial == null ){
       $result = db_query("select nextval('aditivoscontratos_si174_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: aditivoscontratos_si174_sequencial_seq do campo: si174_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si174_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from aditivoscontratos_si174_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si174_sequencial)){
         $this->erro_sql = " Campo si174_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si174_sequencial = $si174_sequencial; 
       }
     }
     if(($this->si174_sequencial == null) || ($this->si174_sequencial == "") ){ 
       $this->erro_sql = " Campo si174_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     $sql = "insert into aditivoscontratos(
                                       si174_sequencial 
                                      ,si174_codunidadesub 
                                      ,si174_nrocontrato 
                                      ,si174_dataassinaturacontoriginal 
                                      ,si174_nroseqtermoaditivo 
                                      ,si174_dataassinaturatermoaditivo 
                                      ,si174_tipoalteracaovalor 
                                      ,si174_tipotermoaditivo 
                                      ,si174_dscalteracao 
                                      ,si174_novadatatermino 
                                      ,si174_valoraditivo 
                                      ,si174_datapublicacao 
                                      ,si174_veiculodivulgacao 
                                      ,si174_instit 
                       )
                values (
                                $this->si174_sequencial 
                               ,'$this->si174_codunidadesub' 
                               ,$this->si174_nrocontrato 
                               ,".($this->si174_dataassinaturacontoriginal == "null" || $this->si174_dataassinaturacontoriginal == ""?"null":"'".$this->si174_dataassinaturacontoriginal."'")." 
                               ,$this->si174_nroseqtermoaditivo 
                               ,".($this->si174_dataassinaturatermoaditivo == "null" || $this->si174_dataassinaturatermoaditivo == ""?"null":"'".$this->si174_dataassinaturatermoaditivo."'")." 
                               ,$this->si174_tipoalteracaovalor 
                               ,'$this->si174_tipotermoaditivo' 
                               ,'$this->si174_dscalteracao' 
                               ,".($this->si174_novadatatermino == "null" || $this->si174_novadatatermino == ""?"null":"'".$this->si174_novadatatermino."'")." 
                               ,$this->si174_valoraditivo 
                               ,".($this->si174_datapublicacao == "null" || $this->si174_datapublicacao == ""?"null":"'".$this->si174_datapublicacao."'")." 
                               ,'$this->si174_veiculodivulgacao' 
                               ,$this->si174_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "aditivoscontratos ($this->si174_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "aditivoscontratos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "aditivoscontratos ($this->si174_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si174_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si174_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011493,'$this->si174_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010408,2011493,'','".AddSlashes(pg_result($resaco,0,'si174_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011505,'','".AddSlashes(pg_result($resaco,0,'si174_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011504,'','".AddSlashes(pg_result($resaco,0,'si174_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011503,'','".AddSlashes(pg_result($resaco,0,'si174_dataassinaturacontoriginal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011502,'','".AddSlashes(pg_result($resaco,0,'si174_nroseqtermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011501,'','".AddSlashes(pg_result($resaco,0,'si174_dataassinaturatermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011500,'','".AddSlashes(pg_result($resaco,0,'si174_tipoalteracaovalor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011499,'','".AddSlashes(pg_result($resaco,0,'si174_tipotermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011498,'','".AddSlashes(pg_result($resaco,0,'si174_dscalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011497,'','".AddSlashes(pg_result($resaco,0,'si174_novadatatermino'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011496,'','".AddSlashes(pg_result($resaco,0,'si174_valoraditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011495,'','".AddSlashes(pg_result($resaco,0,'si174_datapublicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011494,'','".AddSlashes(pg_result($resaco,0,'si174_veiculodivulgacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010408,2011507,'','".AddSlashes(pg_result($resaco,0,'si174_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si174_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update aditivoscontratos set ";
     $virgula = "";
     if(trim($this->si174_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_sequencial"])){ 
       $sql  .= $virgula." si174_sequencial = $this->si174_sequencial ";
       $virgula = ",";
       if(trim($this->si174_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "si174_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si174_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_codunidadesub"])){ 
       $sql  .= $virgula." si174_codunidadesub = '$this->si174_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si174_nrocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_nrocontrato"])){ 
       $sql  .= $virgula." si174_nrocontrato = $this->si174_nrocontrato ";
       $virgula = ",";
       if(trim($this->si174_nrocontrato) == null ){
         $this->erro_sql = " Campo Número do Contrato Original nao Informado.";
         $this->erro_campo = "si174_nrocontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si174_dataassinaturacontoriginal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturacontoriginal_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturacontoriginal_dia"] !="") ){ 
       $sql  .= $virgula." si174_dataassinaturacontoriginal = '$this->si174_dataassinaturacontoriginal' ";
       $virgula = ",";
       if(trim($this->si174_dataassinaturacontoriginal) == null ){ 
         $this->erro_sql = " Campo Data da assinatura do Contrato nao Informado.";
         $this->erro_campo = "si174_dataassinaturacontoriginal_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturacontoriginal_dia"])){ 
         $sql  .= $virgula." si174_dataassinaturacontoriginal = null ";
         $virgula = ",";
         if(trim($this->si174_dataassinaturacontoriginal) == null ){ 
           $this->erro_sql = " Campo Data da assinatura do Contrato nao Informado.";
           $this->erro_campo = "si174_dataassinaturacontoriginal_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if ($this->si174_dataassinaturacontoriginal_ano >= 2014) {
       $result = db_query("select * from contratos where si172_nrocontrato = {$this->si174_nrocontrato} and si172_dataassinatura = '{$this->si174_dataassinaturacontoriginal}'");
       if(pg_num_rows($result) == 0) {
       	 $this->erro_sql = "Contrato informado não existe";
         $this->erro_campo = "si174_nrocontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si174_nroseqtermoaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_nroseqtermoaditivo"])){ 
       $sql  .= $virgula." si174_nroseqtermoaditivo = $this->si174_nroseqtermoaditivo ";
       $virgula = ",";
       if(trim($this->si174_nroseqtermoaditivo) == null ){ 
         $this->erro_sql = " Campo Nro seq do Termo Aditivo nao Informado.";
         $this->erro_campo = "si174_nroseqtermoaditivo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si174_dataassinaturatermoaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturatermoaditivo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturatermoaditivo_dia"] !="") ){ 
       $sql  .= $virgula." si174_dataassinaturatermoaditivo = '$this->si174_dataassinaturatermoaditivo' ";
       $virgula = ",";
       if(trim($this->si174_dataassinaturatermoaditivo) == null ){ 
         $this->erro_sql = " Campo Data da assinatura do Termo nao Informado.";
         $this->erro_campo = "si174_dataassinaturatermoaditivo_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturatermoaditivo_dia"])){ 
         $sql  .= $virgula." si174_dataassinaturatermoaditivo = null ";
         $virgula = ",";
         if(trim($this->si174_dataassinaturatermoaditivo) == null ){ 
           $this->erro_sql = " Campo Data da assinatura do Termo nao Informado.";
           $this->erro_campo = "si174_dataassinaturatermoaditivo_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si174_tipoalteracaovalor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_tipoalteracaovalor"])){ 
       $sql  .= $virgula." si174_tipoalteracaovalor = $this->si174_tipoalteracaovalor ";
       $virgula = ",";
       if(trim($this->si174_tipoalteracaovalor) == null ){ 
         $this->erro_sql = " Campo Tipo de alteração de valor nao Informado.";
         $this->erro_campo = "si174_tipoalteracaovalor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si174_tipotermoaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_tipotermoaditivo"])){ 
       $sql  .= $virgula." si174_tipotermoaditivo = '$this->si174_tipotermoaditivo' ";
       $virgula = ",";
       if(trim($this->si174_tipotermoaditivo) == null ){ 
         $this->erro_sql = " Campo Tipo de Termo de Aditivo nao Informado.";
         $this->erro_campo = "si174_tipotermoaditivo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si174_dscalteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_dscalteracao"])){ 
       $sql  .= $virgula." si174_dscalteracao = '$this->si174_dscalteracao' ";
       $virgula = ",";
       if(trim($this->si174_dscalteracao) == null ){ 
         $this->erro_sql = " Campo Descrição da alteração nao Informado.";
         $this->erro_campo = "si174_dscalteracao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si174_novadatatermino)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_novadatatermino_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si174_novadatatermino_dia"] !="") ){ 
       $sql  .= $virgula." si174_novadatatermino = '$this->si174_novadatatermino' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si174_novadatatermino_dia"])){ 
         $sql  .= $virgula." si174_novadatatermino = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si174_valoraditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_valoraditivo"])){ 
       $sql  .= $virgula." si174_valoraditivo = $this->si174_valoraditivo ";
       $virgula = ",";
       if(trim($this->si174_valoraditivo) == null ){ 
         $this->erro_sql = " Campo Valor do Termo Aditivo nao Informado.";
         $this->erro_campo = "si174_valoraditivo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si174_datapublicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_datapublicacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si174_datapublicacao_dia"] !="") ){ 
       $sql  .= $virgula." si174_datapublicacao = '$this->si174_datapublicacao' ";
       $virgula = ",";
       if(trim($this->si174_datapublicacao) == null ){ 
         $this->erro_sql = " Campo Data da Publicação do Termo nao Informado.";
         $this->erro_campo = "si174_datapublicacao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si174_datapublicacao_dia"])){ 
         $sql  .= $virgula." si174_datapublicacao = null ";
         $virgula = ",";
         if(trim($this->si174_datapublicacao) == null ){ 
           $this->erro_sql = " Campo Data da Publicação do Termo nao Informado.";
           $this->erro_campo = "si174_datapublicacao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si174_veiculodivulgacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_veiculodivulgacao"])){ 
       $sql  .= $virgula." si174_veiculodivulgacao = '$this->si174_veiculodivulgacao' ";
       $virgula = ",";
       if(trim($this->si174_veiculodivulgacao) == null ){ 
         $this->erro_sql = " Campo Veículo de divulgação nao Informado.";
         $this->erro_campo = "si174_veiculodivulgacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si174_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si174_instit"])){ 
       $sql  .= $virgula." si174_instit = $this->si174_instit ";
       $virgula = ",";
       if(trim($this->si174_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si174_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
       /**
        * verificação para não permitir incluir aditivos repetidos
        */
       $sqlVerifica = " select 1 from aditivoscontratos where si174_sequencial != $this->si174_sequencial and si174_nrocontrato = ".$this->si174_nrocontrato." and
       si174_dataassinaturacontoriginal = '".$this->si174_dataassinaturacontoriginal."' and si174_nroseqtermoaditivo = ".$this->si174_nroseqtermoaditivo."
       and si174_codunidadesub = '".$this->si174_codunidadesub."'";
       $result = db_query($sqlVerifica);
       if(pg_num_rows($result) > 0) {
           $this->erro_msg = "Já existe um aditivo para este Contrato com as mesmas informações.";
           $this->erro_status = "0";
           return false;
       }
     $sql .= " where ";
     if($si174_sequencial!=null){
       $sql .= " si174_sequencial = $this->si174_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si174_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011493,'$this->si174_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_sequencial"]) || $this->si174_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011493,'".AddSlashes(pg_result($resaco,$conresaco,'si174_sequencial'))."','$this->si174_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_codunidadesub"]) || $this->si174_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011505,'".AddSlashes(pg_result($resaco,$conresaco,'si174_codunidadesub'))."','$this->si174_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_nrocontrato"]) || $this->si174_nrocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011504,'".AddSlashes(pg_result($resaco,$conresaco,'si174_nrocontrato'))."','$this->si174_nrocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturacontoriginal"]) || $this->si174_dataassinaturacontoriginal != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011503,'".AddSlashes(pg_result($resaco,$conresaco,'si174_dataassinaturacontoriginal'))."','$this->si174_dataassinaturacontoriginal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_nroseqtermoaditivo"]) || $this->si174_nroseqtermoaditivo != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011502,'".AddSlashes(pg_result($resaco,$conresaco,'si174_nroseqtermoaditivo'))."','$this->si174_nroseqtermoaditivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_dataassinaturatermoaditivo"]) || $this->si174_dataassinaturatermoaditivo != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011501,'".AddSlashes(pg_result($resaco,$conresaco,'si174_dataassinaturatermoaditivo'))."','$this->si174_dataassinaturatermoaditivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_tipoalteracaovalor"]) || $this->si174_tipoalteracaovalor != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011500,'".AddSlashes(pg_result($resaco,$conresaco,'si174_tipoalteracaovalor'))."','$this->si174_tipoalteracaovalor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_tipotermoaditivo"]) || $this->si174_tipotermoaditivo != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011499,'".AddSlashes(pg_result($resaco,$conresaco,'si174_tipotermoaditivo'))."','$this->si174_tipotermoaditivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_dscalteracao"]) || $this->si174_dscalteracao != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011498,'".AddSlashes(pg_result($resaco,$conresaco,'si174_dscalteracao'))."','$this->si174_dscalteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_novadatatermino"]) || $this->si174_novadatatermino != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011497,'".AddSlashes(pg_result($resaco,$conresaco,'si174_novadatatermino'))."','$this->si174_novadatatermino',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_valoraditivo"]) || $this->si174_valoraditivo != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011496,'".AddSlashes(pg_result($resaco,$conresaco,'si174_valoraditivo'))."','$this->si174_valoraditivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_datapublicacao"]) || $this->si174_datapublicacao != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011495,'".AddSlashes(pg_result($resaco,$conresaco,'si174_datapublicacao'))."','$this->si174_datapublicacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_veiculodivulgacao"]) || $this->si174_veiculodivulgacao != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011494,'".AddSlashes(pg_result($resaco,$conresaco,'si174_veiculodivulgacao'))."','$this->si174_veiculodivulgacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si174_instit"]) || $this->si174_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010408,2011507,'".AddSlashes(pg_result($resaco,$conresaco,'si174_instit'))."','$this->si174_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aditivoscontratos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si174_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aditivoscontratos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si174_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si174_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si174_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si174_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011493,'$si174_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010408,2011493,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011505,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011504,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_nrocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011503,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_dataassinaturacontoriginal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011502,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_nroseqtermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011501,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_dataassinaturatermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011500,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_tipoalteracaovalor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011499,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_tipotermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011498,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_dscalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011497,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_novadatatermino'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011496,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_valoraditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011495,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_datapublicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011494,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_veiculodivulgacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010408,2011507,'','".AddSlashes(pg_result($resaco,$iresaco,'si174_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from aditivoscontratos
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si174_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si174_sequencial = $si174_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     echo pg_last_error();
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aditivoscontratos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si174_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aditivoscontratos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si174_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si174_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:aditivoscontratos";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si174_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aditivoscontratos ";
     $sql .= "      inner join contratos  on  contratos.si172_sequencial = aditivoscontratos.si174_nrocontrato";
     $sql .= "      inner join pcorcamforne  on  pcorcamforne.pc21_orcamforne = contratos.si172_fornecedor";
     $sql .= "      inner join liclicita  on  liclicita.l20_codigo = contratos.si172_licitacao";
     $sql2 = "";
     if($dbwhere==""){
       if($si174_sequencial!=null ){
         $sql2 .= " where aditivoscontratos.si174_sequencial = $si174_sequencial "; 
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
   function sql_query_file ( $si174_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aditivoscontratos ";
     $sql2 = "";
     if($dbwhere==""){
       if($si174_sequencial!=null ){
         $sql2 .= " where aditivoscontratos.si174_sequencial = $si174_sequencial "; 
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
