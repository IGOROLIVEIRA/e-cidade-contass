<?
//MODULO: sicom
//CLASSE DA ENTIDADE aex102014
class cl_aex102014 { 
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
   var $si129_sequencial = 0; 
   var $si129_tiporegistro = 0; 
   var $si129_codreduzidoaex = 0; 
   var $si129_codorgao = null; 
   var $si129_codext = 0; 
   var $si129_codfontrecursos = 0; 
   var $si129_categoria = 0; 
   var $si129_dtlancamento_dia = null; 
   var $si129_dtlancamento_mes = null; 
   var $si129_dtlancamento_ano = null; 
   var $si129_dtlancamento = null; 
   var $si129_dtanulacaoextra_dia = null; 
   var $si129_dtanulacaoextra_mes = null; 
   var $si129_dtanulacaoextra_ano = null; 
   var $si129_dtanulacaoextra = null; 
   var $si129_justificativaanulacao = null; 
   var $si129_vlanulacao = 0; 
   var $si129_mes = 0; 
   var $si129_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si129_sequencial = int8 = sequencial 
                 si129_tiporegistro = int8 = Tipo do  registro 
                 si129_codreduzidoaex = int8 = Código identificador da anulação 
                 si129_codorgao = varchar(2) = Código do órgão 
                 si129_codext = int8 = Código identificador 
                 si129_codfontrecursos = int8 = Código da fonte de recursos 
                 si129_categoria = int8 = Categoria que está sendo informada 
                 si129_dtlancamento = date = Data do  Lançamento Original 
                 si129_dtanulacaoextra = date = Data da Anulação  da ExtraOrçamentária 
                 si129_justificativaanulacao = varchar(500) = Justificativa para  a anulação 
                 si129_vlanulacao = float8 = Valor da  Anulação 
                 si129_mes = int8 = Mês 
                 si129_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_aex102014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("aex102014"); 
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
       $this->si129_sequencial = ($this->si129_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_sequencial"]:$this->si129_sequencial);
       $this->si129_tiporegistro = ($this->si129_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_tiporegistro"]:$this->si129_tiporegistro);
       $this->si129_codreduzidoaex = ($this->si129_codreduzidoaex == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_codreduzidoaex"]:$this->si129_codreduzidoaex);
       $this->si129_codorgao = ($this->si129_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_codorgao"]:$this->si129_codorgao);
       $this->si129_codext = ($this->si129_codext == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_codext"]:$this->si129_codext);
       $this->si129_codfontrecursos = ($this->si129_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_codfontrecursos"]:$this->si129_codfontrecursos);
       $this->si129_categoria = ($this->si129_categoria == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_categoria"]:$this->si129_categoria);
       if($this->si129_dtlancamento == ""){
         $this->si129_dtlancamento_dia = ($this->si129_dtlancamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_dtlancamento_dia"]:$this->si129_dtlancamento_dia);
         $this->si129_dtlancamento_mes = ($this->si129_dtlancamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_dtlancamento_mes"]:$this->si129_dtlancamento_mes);
         $this->si129_dtlancamento_ano = ($this->si129_dtlancamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_dtlancamento_ano"]:$this->si129_dtlancamento_ano);
         if($this->si129_dtlancamento_dia != ""){
            $this->si129_dtlancamento = $this->si129_dtlancamento_ano."-".$this->si129_dtlancamento_mes."-".$this->si129_dtlancamento_dia;
         }
       }
       if($this->si129_dtanulacaoextra == ""){
         $this->si129_dtanulacaoextra_dia = ($this->si129_dtanulacaoextra_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_dtanulacaoextra_dia"]:$this->si129_dtanulacaoextra_dia);
         $this->si129_dtanulacaoextra_mes = ($this->si129_dtanulacaoextra_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_dtanulacaoextra_mes"]:$this->si129_dtanulacaoextra_mes);
         $this->si129_dtanulacaoextra_ano = ($this->si129_dtanulacaoextra_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_dtanulacaoextra_ano"]:$this->si129_dtanulacaoextra_ano);
         if($this->si129_dtanulacaoextra_dia != ""){
            $this->si129_dtanulacaoextra = $this->si129_dtanulacaoextra_ano."-".$this->si129_dtanulacaoextra_mes."-".$this->si129_dtanulacaoextra_dia;
         }
       }
       $this->si129_justificativaanulacao = ($this->si129_justificativaanulacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_justificativaanulacao"]:$this->si129_justificativaanulacao);
       $this->si129_vlanulacao = ($this->si129_vlanulacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_vlanulacao"]:$this->si129_vlanulacao);
       $this->si129_mes = ($this->si129_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_mes"]:$this->si129_mes);
       $this->si129_instit = ($this->si129_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_instit"]:$this->si129_instit);
     }else{
       $this->si129_sequencial = ($this->si129_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si129_sequencial"]:$this->si129_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si129_sequencial){ 
      $this->atualizacampos();
     if($this->si129_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si129_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si129_codreduzidoaex == null ){ 
       $this->si129_codreduzidoaex = "0";
     }
     if($this->si129_codext == null ){ 
       $this->si129_codext = "0";
     }
     if($this->si129_codfontrecursos == null ){ 
       $this->si129_codfontrecursos = "0";
     }
     if($this->si129_categoria == null ){ 
       $this->si129_categoria = "0";
     }
     if($this->si129_dtlancamento == null ){ 
       $this->si129_dtlancamento = "null";
     }
     if($this->si129_dtanulacaoextra == null ){ 
       $this->si129_dtanulacaoextra = "null";
     }
     if($this->si129_vlanulacao == null ){ 
       $this->si129_vlanulacao = "0";
     }
     if($this->si129_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si129_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si129_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si129_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si129_sequencial == "" || $si129_sequencial == null ){
       $result = db_query("select nextval('aex102014_si129_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: aex102014_si129_sequencial_seq do campo: si129_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si129_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from aex102014_si129_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si129_sequencial)){
         $this->erro_sql = " Campo si129_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si129_sequencial = $si129_sequencial; 
       }
     }
     if(($this->si129_sequencial == null) || ($this->si129_sequencial == "") ){ 
       $this->erro_sql = " Campo si129_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into aex102014(
                                       si129_sequencial 
                                      ,si129_tiporegistro 
                                      ,si129_codreduzidoaex 
                                      ,si129_codorgao 
                                      ,si129_codext 
                                      ,si129_codfontrecursos 
                                      ,si129_categoria 
                                      ,si129_dtlancamento 
                                      ,si129_dtanulacaoextra 
                                      ,si129_justificativaanulacao 
                                      ,si129_vlanulacao 
                                      ,si129_mes 
                                      ,si129_instit 
                       )
                values (
                                $this->si129_sequencial 
                               ,$this->si129_tiporegistro 
                               ,$this->si129_codreduzidoaex 
                               ,'$this->si129_codorgao' 
                               ,$this->si129_codext 
                               ,$this->si129_codfontrecursos 
                               ,$this->si129_categoria 
                               ,".($this->si129_dtlancamento == "null" || $this->si129_dtlancamento == ""?"null":"'".$this->si129_dtlancamento."'")." 
                               ,".($this->si129_dtanulacaoextra == "null" || $this->si129_dtanulacaoextra == ""?"null":"'".$this->si129_dtanulacaoextra."'")." 
                               ,'$this->si129_justificativaanulacao' 
                               ,$this->si129_vlanulacao 
                               ,$this->si129_mes 
                               ,$this->si129_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "aex102014 ($this->si129_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "aex102014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "aex102014 ($this->si129_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si129_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si129_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010896,'$this->si129_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010358,2010896,'','".AddSlashes(pg_result($resaco,0,'si129_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010358,2010897,'','".AddSlashes(pg_result($resaco,0,'si129_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010358,2010898,'','".AddSlashes(pg_result($resaco,0,'si129_codreduzidoaex'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010358,2010899,'','".AddSlashes(pg_result($resaco,0,'si129_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010358,2011301,'','".AddSlashes(pg_result($resaco,0,'si129_codext'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010358,2011302,'','".AddSlashes(pg_result($resaco,0,'si129_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010358,2010901,'','".AddSlashes(pg_result($resaco,0,'si129_categoria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010358,2010905,'','".AddSlashes(pg_result($resaco,0,'si129_dtlancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010358,2010906,'','".AddSlashes(pg_result($resaco,0,'si129_dtanulacaoextra'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010358,2010907,'','".AddSlashes(pg_result($resaco,0,'si129_justificativaanulacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010358,2010908,'','".AddSlashes(pg_result($resaco,0,'si129_vlanulacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010358,2010909,'','".AddSlashes(pg_result($resaco,0,'si129_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010358,2011642,'','".AddSlashes(pg_result($resaco,0,'si129_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si129_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update aex102014 set ";
     $virgula = "";
     if(trim($this->si129_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_sequencial"])){ 
        if(trim($this->si129_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si129_sequencial"])){ 
           $this->si129_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si129_sequencial = $this->si129_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si129_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_tiporegistro"])){ 
       $sql  .= $virgula." si129_tiporegistro = $this->si129_tiporegistro ";
       $virgula = ",";
       if(trim($this->si129_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si129_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si129_codreduzidoaex)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_codreduzidoaex"])){ 
        if(trim($this->si129_codreduzidoaex)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si129_codreduzidoaex"])){ 
           $this->si129_codreduzidoaex = "0" ; 
        } 
       $sql  .= $virgula." si129_codreduzidoaex = $this->si129_codreduzidoaex ";
       $virgula = ",";
     }
     if(trim($this->si129_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_codorgao"])){ 
       $sql  .= $virgula." si129_codorgao = '$this->si129_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si129_codext)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_codext"])){ 
        if(trim($this->si129_codext)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si129_codext"])){ 
           $this->si129_codext = "0" ; 
        } 
       $sql  .= $virgula." si129_codext = $this->si129_codext ";
       $virgula = ",";
     }
     if(trim($this->si129_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_codfontrecursos"])){ 
        if(trim($this->si129_codfontrecursos)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si129_codfontrecursos"])){ 
           $this->si129_codfontrecursos = "0" ; 
        } 
       $sql  .= $virgula." si129_codfontrecursos = $this->si129_codfontrecursos ";
       $virgula = ",";
     }
     if(trim($this->si129_categoria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_categoria"])){ 
        if(trim($this->si129_categoria)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si129_categoria"])){ 
           $this->si129_categoria = "0" ; 
        } 
       $sql  .= $virgula." si129_categoria = $this->si129_categoria ";
       $virgula = ",";
     }
     if(trim($this->si129_dtlancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si129_dtlancamento_dia"] !="") ){ 
       $sql  .= $virgula." si129_dtlancamento = '$this->si129_dtlancamento' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si129_dtlancamento_dia"])){ 
         $sql  .= $virgula." si129_dtlancamento = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si129_dtanulacaoextra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_dtanulacaoextra_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si129_dtanulacaoextra_dia"] !="") ){ 
       $sql  .= $virgula." si129_dtanulacaoextra = '$this->si129_dtanulacaoextra' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si129_dtanulacaoextra_dia"])){ 
         $sql  .= $virgula." si129_dtanulacaoextra = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si129_justificativaanulacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_justificativaanulacao"])){ 
       $sql  .= $virgula." si129_justificativaanulacao = '$this->si129_justificativaanulacao' ";
       $virgula = ",";
     }
     if(trim($this->si129_vlanulacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_vlanulacao"])){ 
        if(trim($this->si129_vlanulacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si129_vlanulacao"])){ 
           $this->si129_vlanulacao = "0" ; 
        } 
       $sql  .= $virgula." si129_vlanulacao = $this->si129_vlanulacao ";
       $virgula = ",";
     }
     if(trim($this->si129_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_mes"])){ 
       $sql  .= $virgula." si129_mes = $this->si129_mes ";
       $virgula = ",";
       if(trim($this->si129_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si129_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si129_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si129_instit"])){ 
       $sql  .= $virgula." si129_instit = $this->si129_instit ";
       $virgula = ",";
       if(trim($this->si129_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si129_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si129_sequencial!=null){
       $sql .= " si129_sequencial = $this->si129_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si129_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010896,'$this->si129_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_sequencial"]) || $this->si129_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2010896,'".AddSlashes(pg_result($resaco,$conresaco,'si129_sequencial'))."','$this->si129_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_tiporegistro"]) || $this->si129_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2010897,'".AddSlashes(pg_result($resaco,$conresaco,'si129_tiporegistro'))."','$this->si129_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_codreduzidoaex"]) || $this->si129_codreduzidoaex != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2010898,'".AddSlashes(pg_result($resaco,$conresaco,'si129_codreduzidoaex'))."','$this->si129_codreduzidoaex',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_codorgao"]) || $this->si129_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2010899,'".AddSlashes(pg_result($resaco,$conresaco,'si129_codorgao'))."','$this->si129_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_codext"]) || $this->si129_codext != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2011301,'".AddSlashes(pg_result($resaco,$conresaco,'si129_codext'))."','$this->si129_codext',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_codfontrecursos"]) || $this->si129_codfontrecursos != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2011302,'".AddSlashes(pg_result($resaco,$conresaco,'si129_codfontrecursos'))."','$this->si129_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_categoria"]) || $this->si129_categoria != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2010901,'".AddSlashes(pg_result($resaco,$conresaco,'si129_categoria'))."','$this->si129_categoria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_dtlancamento"]) || $this->si129_dtlancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2010905,'".AddSlashes(pg_result($resaco,$conresaco,'si129_dtlancamento'))."','$this->si129_dtlancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_dtanulacaoextra"]) || $this->si129_dtanulacaoextra != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2010906,'".AddSlashes(pg_result($resaco,$conresaco,'si129_dtanulacaoextra'))."','$this->si129_dtanulacaoextra',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_justificativaanulacao"]) || $this->si129_justificativaanulacao != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2010907,'".AddSlashes(pg_result($resaco,$conresaco,'si129_justificativaanulacao'))."','$this->si129_justificativaanulacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_vlanulacao"]) || $this->si129_vlanulacao != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2010908,'".AddSlashes(pg_result($resaco,$conresaco,'si129_vlanulacao'))."','$this->si129_vlanulacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_mes"]) || $this->si129_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2010909,'".AddSlashes(pg_result($resaco,$conresaco,'si129_mes'))."','$this->si129_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si129_instit"]) || $this->si129_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010358,2011642,'".AddSlashes(pg_result($resaco,$conresaco,'si129_instit'))."','$this->si129_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aex102014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si129_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aex102014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si129_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si129_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si129_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si129_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010896,'$si129_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010358,2010896,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010358,2010897,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010358,2010898,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_codreduzidoaex'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010358,2010899,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010358,2011301,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_codext'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010358,2011302,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010358,2010901,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_categoria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010358,2010905,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_dtlancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010358,2010906,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_dtanulacaoextra'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010358,2010907,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_justificativaanulacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010358,2010908,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_vlanulacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010358,2010909,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010358,2011642,'','".AddSlashes(pg_result($resaco,$iresaco,'si129_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from aex102014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si129_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si129_sequencial = $si129_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aex102014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si129_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aex102014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si129_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si129_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:aex102014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si129_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aex102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si129_sequencial!=null ){
         $sql2 .= " where aex102014.si129_sequencial = $si129_sequencial "; 
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
   function sql_query_file ( $si129_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aex102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si129_sequencial!=null ){
         $sql2 .= " where aex102014.si129_sequencial = $si129_sequencial "; 
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
