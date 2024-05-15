<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE consvalorestransf
class cl_consvalorestransf {
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
   var $c201_sequencial = 0;
   var $c201_consconsorcios = 0;
   var $c201_mescompetencia = 0;
   var $c201_codfontrecursos = 0;
   var $c201_valortransf = 0;
   var $c201_enviourelatorios = 'f';
   var $c201_codacompanhamento = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 c201_sequencial = int8 = Código Sequencial
                 c201_consconsorcios = int8 = Código Consórcio
                 c201_mescompetencia = int8 = Mês Competência
                 c201_codfontrecursos = int8 = Código da fonte de recursos
                 c201_valortransf = float8 = Valor Transferido
                 c201_enviourelatorios = bool = Enviou Relatórios
                 c201_codacompanhamento = int8 = Código de acompanhamento
                 ";
   //funcao construtor da classe
   function cl_consvalorestransf() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("consvalorestransf");
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
       $this->c201_sequencial = ($this->c201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c201_sequencial"]:$this->c201_sequencial);
       $this->c201_consconsorcios = ($this->c201_consconsorcios == ""?@$GLOBALS["HTTP_POST_VARS"]["c201_consconsorcios"]:$this->c201_consconsorcios);
       $this->c201_mescompetencia = ($this->c201_mescompetencia == ""?@$GLOBALS["HTTP_POST_VARS"]["c201_mescompetencia"]:$this->c201_mescompetencia);
       $this->c201_codfontrecursos = ($this->c201_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["c201_codfontrecursos"]:$this->c201_codfontrecursos);
       $this->c201_valortransf = ($this->c201_valortransf == ""?@$GLOBALS["HTTP_POST_VARS"]["c201_valortransf"]:$this->c201_valortransf);
       $this->c201_enviourelatorios = ($this->c201_enviourelatorios == "f"?@$GLOBALS["HTTP_POST_VARS"]["c201_enviourelatorios"]:$this->c201_enviourelatorios);
       $this->c201_codacompanhamento = ($this->c201_codacompanhamento == "f"?@$GLOBALS["HTTP_POST_VARS"]["c201_codacompanhamento"]:$this->c201_codacompanhamento);
    }else{
       $this->c201_sequencial = ($this->c201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c201_sequencial"]:$this->c201_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($c201_sequencial=null){
      $this->atualizacampos();
     if($this->c201_consconsorcios == null ){
       $this->erro_sql = " Campo Código Consórcio nao Informado.";
       $this->erro_campo = "c201_consconsorcios";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c201_mescompetencia == null ){
       $this->erro_sql = " Campo Mês Competência nao Informado.";
       $this->erro_campo = "c201_mescompetencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c201_codfontrecursos == null ){
       $this->erro_sql = " Campo fonte de recursos nao Informado.";
       $this->erro_campo = "c201_codfontrecursos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(db_getsession("DB_anousu") > 2022) {
      /**
      * adicionado para verificar o tamanho do campo
      */
      if(strlen($this->c201_codfontrecursos) != 7 ){ 
        $this->erro_sql = " Campo fonte de recursos deve conter 7 dígitos.";
        $this->erro_campo = "c201_codfontrecursos";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      if($this->c201_codacompanhamento == null ){ 
        $this->erro_sql = " Campo Código de acompanhamento nao Informado.";
        $this->erro_campo = "c201_codacompanhamento";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
   }else{
     /**
      * adicionado para verificar o tamanho do campo
      */
      if(strlen($this->c201_codfontrecursos) != 3 ){ 
      $this->erro_sql = " Campo fonte de recursos deve conter 3 dígitos.";
      $this->erro_campo = "c201_codfontrecursos";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;

   }
  }
     if($this->c201_valortransf == null ){
       $this->erro_sql = " Campo Valor Transferido nao Informado.";
       $this->erro_campo = "c201_valortransf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c201_enviourelatorios == null ){
       $this->erro_sql = " Campo Enviou Relatórios nao Informado.";
       $this->erro_campo = "c201_enviourelatorios";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($c201_sequencial == "" || $c201_sequencial == null ){
       $result = db_query("select nextval('consvalorestransf_c201_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: consvalorestransf_c201_sequencial_seq do campo: c201_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->c201_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from consvalorestransf_c201_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $c201_sequencial)){
         $this->erro_sql = " Campo c201_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->c201_sequencial = $c201_sequencial;
       }
     }
     if(($this->c201_sequencial == null) || ($this->c201_sequencial == "") ){
       $this->erro_sql = " Campo c201_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into consvalorestransf(
                                       c201_sequencial
                                      ,c201_consconsorcios
                                      ,c201_mescompetencia
                                      ,c201_codfontrecursos
                                      ,c201_valortransf
                                      ,c201_enviourelatorios
                                      ,c201_anousu
                                      ,c201_codacompanhamento
                       )
                values (
                                $this->c201_sequencial
                               ,$this->c201_consconsorcios
                               ,$this->c201_mescompetencia
                               ,$this->c201_codfontrecursos
                               ,$this->c201_valortransf
                               ,'$this->c201_enviourelatorios'
                               ,".db_getsession("DB_anousu")."
                               ,'$this->c201_codacompanhamento'
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Valores Transferidos ($this->c201_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Valores Transferidos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Valores Transferidos ($this->c201_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c201_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->c201_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009412,'$this->c201_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010218,2009412,'','".AddSlashes(pg_result($resaco,0,'c201_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010218,2009413,'','".AddSlashes(pg_result($resaco,0,'c201_consconsorcios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010218,2009414,'','".AddSlashes(pg_result($resaco,0,'c201_mescompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010218,2009415,'','".AddSlashes(pg_result($resaco,0,'c201_valortransf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010218,2009416,'','".AddSlashes(pg_result($resaco,0,'c201_enviourelatorios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010218,2009416,'','".AddSlashes(pg_result($resaco,0,'c201_codacompanhamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      }
     return true;
   }
   // funcao para alteracao
   function alterar ($c201_sequencial=null) {
      $this->atualizacampos();
     $sql = " update consvalorestransf set ";
     $virgula = "";
     if(trim($this->c201_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c201_sequencial"])){
       $sql  .= $virgula." c201_sequencial = $this->c201_sequencial ";
       $virgula = ",";
       if(trim($this->c201_sequencial) == null ){
         $this->erro_sql = " Campo Código Sequencial nao Informado.";
         $this->erro_campo = "c201_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c201_consconsorcios)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c201_consconsorcios"])){
       $sql  .= $virgula." c201_consconsorcios = $this->c201_consconsorcios ";
       $virgula = ",";
       if(trim($this->c201_consconsorcios) == null ){
         $this->erro_sql = " Campo Código Consórcio nao Informado.";
         $this->erro_campo = "c201_consconsorcios";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c201_mescompetencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c201_mescompetencia"])){
       $sql  .= $virgula." c201_mescompetencia = $this->c201_mescompetencia ";
       $virgula = ",";
       if(trim($this->c201_mescompetencia) == null ){
         $this->erro_sql = " Campo Mês Competência nao Informado.";
         $this->erro_campo = "c201_mescompetencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c201_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c201_codfontrecursos"])){
       $sql  .= $virgula." c201_codfontrecursos = $this->c201_codfontrecursos ";
       $virgula = ",";
       if(trim($this->c201_codfontrecursos) == null ){
         $this->erro_sql = " Campo Fonte Recursos nao Informado.";
         $this->erro_campo = "c201_codfontrecursos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       /**
        * adicionado para verificar o tamanho do campo
        */
        if(db_getsession('DB_anousu') > 2022){
          if(strlen($this->c201_codfontrecursos) != 7 ){ 
            $this->erro_sql = " Campo fonte de recursos deve conter 7 dígitos.";
            $this->erro_campo = "c201_codfontrecursos";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
          }
        }else{
          if(strlen($this->c201_codfontrecursos) != 3 ){ 
            $this->erro_sql = " Campo fonte de recursos deve conter 3 dígitos.";
            $this->erro_campo = "c201_codfontrecursos";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
          } 
        } 
       }
       if(db_getsession('DB_anousu') > 2022){
          if(trim($this->c201_codacompanhamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c201_codacompanhamento"])){ 
            $sql  .= $virgula." c201_codacompanhamento = $this->c201_codacompanhamento ";
            $virgula = ",";
            if(trim($this->c201_codacompanhamento) == null ){ 
              $this->erro_sql = " Campo Código da acompanhamento nao Informado.";
              $this->erro_campo = "c201_codacompanhamento";
              $this->erro_banco = "";
              $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
              $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
              $this->erro_status = "0";
              return false;
            }
          }
        }
     if(trim($this->c201_valortransf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c201_valortransf"])){
       $sql  .= $virgula." c201_valortransf = $this->c201_valortransf ";
       $virgula = ",";
       if(trim($this->c201_valortransf) == null ){
         $this->erro_sql = " Campo Valor Transferido nao Informado.";
         $this->erro_campo = "c201_valortransf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c201_enviourelatorios)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c201_enviourelatorios"])){
       $sql  .= $virgula." c201_enviourelatorios = '$this->c201_enviourelatorios' ";
       $virgula = ",";
       if(trim($this->c201_enviourelatorios) == null ){
         $this->erro_sql = " Campo Enviou Relatórios nao Informado.";
         $this->erro_campo = "c201_enviourelatorios";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($c201_sequencial!=null){
       $sql .= " c201_sequencial = $this->c201_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->c201_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009412,'$this->c201_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c201_sequencial"]) || $this->c201_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010218,2009412,'".AddSlashes(pg_result($resaco,$conresaco,'c201_sequencial'))."','$this->c201_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c201_consconsorcios"]) || $this->c201_consconsorcios != "")
           $resac = db_query("insert into db_acount values($acount,2010218,2009413,'".AddSlashes(pg_result($resaco,$conresaco,'c201_consconsorcios'))."','$this->c201_consconsorcios',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c201_mescompetencia"]) || $this->c201_mescompetencia != "")
           $resac = db_query("insert into db_acount values($acount,2010218,2009414,'".AddSlashes(pg_result($resaco,$conresaco,'c201_mescompetencia'))."','$this->c201_mescompetencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c201_valortransf"]) || $this->c201_valortransf != "")
           $resac = db_query("insert into db_acount values($acount,2010218,2009415,'".AddSlashes(pg_result($resaco,$conresaco,'c201_valortransf'))."','$this->c201_valortransf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c201_enviourelatorios"]) || $this->c201_enviourelatorios != "")
           $resac = db_query("insert into db_acount values($acount,2010218,2009416,'".AddSlashes(pg_result($resaco,$conresaco,'c201_enviourelatorios'))."','$this->c201_enviourelatorios',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c201_codacompanhamento"]) || $this->c201_codacompanhamento != "")
           $resac = db_query("insert into db_acount values($acount,2010218,2009416,'".AddSlashes(pg_result($resaco,$conresaco,'c201_codacompanhamento'))."','$this->c201_codacompanhamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Valores Transferidos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c201_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Valores Transferidos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($c201_sequencial=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($c201_sequencial));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009412,'$c201_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010218,2009412,'','".AddSlashes(pg_result($resaco,$iresaco,'c201_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010218,2009413,'','".AddSlashes(pg_result($resaco,$iresaco,'c201_consconsorcios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010218,2009414,'','".AddSlashes(pg_result($resaco,$iresaco,'c201_mescompetencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010218,2009415,'','".AddSlashes(pg_result($resaco,$iresaco,'c201_valortransf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010218,2009416,'','".AddSlashes(pg_result($resaco,$iresaco,'c201_enviourelatorios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010218,2009416,'','".AddSlashes(pg_result($resaco,$iresaco,'c201_codacompanhamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        }
     }
     $sql = " delete from consvalorestransf
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($c201_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " c201_sequencial = $c201_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Valores Transferidos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c201_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Valores Transferidos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c201_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:consvalorestransf";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $c201_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from consvalorestransf ";
     $sql .= "      inner join consconsorcios  on  consconsorcios.c200_sequencial = consvalorestransf.c201_consconsorcios";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = consconsorcios.c200_numcgm";
     $sql2 = "";
     if($dbwhere==""){
       if($c201_sequencial!=null ){
         $sql2 .= " where consvalorestransf.c201_sequencial = $c201_sequencial ";
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
   function sql_query_file ( $c201_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from consvalorestransf ";
     $sql2 = "";
     if($dbwhere==""){
       if($c201_sequencial!=null ){
         $sql2 .= " where consvalorestransf.c201_sequencial = $c201_sequencial ";
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
