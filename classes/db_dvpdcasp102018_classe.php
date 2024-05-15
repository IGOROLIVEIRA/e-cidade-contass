<?
//MODULO: sicom
//CLASSE DA ENTIDADE dvpdcasp102018
class cl_dvpdcasp102018 { 
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
   var $si216_sequencial = 0; 
   var $si216_tiporegistro = 0; 
   var $si216_vlimpostos = 0; 
   var $si216_vlcontribuicoes = 0; 
   var $si216_vlexploracovendasdireitos = 0; 
   var $si216_vlvariacoesaumentativasfinanceiras = 0; 
   var $si216_vltransfdelegacoesrecebidas = 0; 
   var $si216_vlvalorizacaoativodesincorpassivo = 0; 
   var $si216_vloutrasvariacoespatriaumentativas = 0; 
   var $si216_vltotalvpaumentativas = 0; 
   var $si216_ano = 0;
   var $si216_periodo = 0;
   var $si216_institu = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si216_sequencial = int4 = si216_sequencial 
                 si216_tiporegistro = int4 = si216_tiporegistro 
                 si216_vlimpostos = float4 = si216_vlimpostos 
                 si216_vlcontribuicoes = float4 = si216_vlcontribuicoes 
                 si216_vlexploracovendasdireitos = float4 = si216_vlexploracovendasdireitos 
                 si216_vlvariacoesaumentativasfinanceiras = float4 = si216_vlvariacoesaumentativasfinanceiras 
                 si216_vltransfdelegacoesrecebidas = float4 = si216_vltransfdelegacoesrecebidas 
                 si216_vlvalorizacaoativodesincorpassivo = float4 = si216_vlvalorizacaoativodesincorpassivo 
                 si216_vloutrasvariacoespatriaumentativas = float4 = si216_vloutrasvariacoespatriaumentativas 
                 si216_vltotalvpaumentativas = float4 = si216_vltotalvpaumentativas 
                 ";
   //funcao construtor da classe 
   function cl_dvpdcasp102018() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dvpdcasp102018"); 
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
       $this->si216_sequencial = ($this->si216_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_sequencial"]:$this->si216_sequencial);
       $this->si216_tiporegistro = ($this->si216_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_tiporegistro"]:$this->si216_tiporegistro);
       $this->si216_vlimpostos = ($this->si216_vlimpostos == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_vlimpostos"]:$this->si216_vlimpostos);
       $this->si216_vlcontribuicoes = ($this->si216_vlcontribuicoes == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_vlcontribuicoes"]:$this->si216_vlcontribuicoes);
       $this->si216_vlexploracovendasdireitos = ($this->si216_vlexploracovendasdireitos == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_vlexploracovendasdireitos"]:$this->si216_vlexploracovendasdireitos);
       $this->si216_vlvariacoesaumentativasfinanceiras = ($this->si216_vlvariacoesaumentativasfinanceiras == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_vlvariacoesaumentativasfinanceiras"]:$this->si216_vlvariacoesaumentativasfinanceiras);
       $this->si216_vltransfdelegacoesrecebidas = ($this->si216_vltransfdelegacoesrecebidas == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_vltransfdelegacoesrecebidas"]:$this->si216_vltransfdelegacoesrecebidas);
       $this->si216_vlvalorizacaoativodesincorpassivo = ($this->si216_vlvalorizacaoativodesincorpassivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_vlvalorizacaoativodesincorpassivo"]:$this->si216_vlvalorizacaoativodesincorpassivo);
       $this->si216_vloutrasvariacoespatriaumentativas = ($this->si216_vloutrasvariacoespatriaumentativas == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_vloutrasvariacoespatriaumentativas"]:$this->si216_vloutrasvariacoespatriaumentativas);
       $this->si216_vltotalvpaumentativas = ($this->si216_vltotalvpaumentativas == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_vltotalvpaumentativas"]:$this->si216_vltotalvpaumentativas);
       $this->si216_ano = ($this->si216_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_ano"]:$this->si216_ano);
       $this->si216_periodo = ($this->si216_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_periodo"]:$this->si216_periodo);
       $this->si216_institu = ($this->si216_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_institu"]:$this->si216_institu);
     }else{
       $this->si216_sequencial = ($this->si216_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si216_sequencial"]:$this->si216_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si216_sequencial){ 
      $this->atualizacampos();
     if($this->si216_tiporegistro == null ){ 
       $this->erro_sql = " Campo si216_tiporegistro não informado.";
       $this->erro_campo = "si216_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si216_vlimpostos == null ){
       $this->si216_vlimpostos = 0;
     }
     if($this->si216_vlcontribuicoes == null ){
       $this->si216_vlcontribuicoes = 0;
     }
     if($this->si216_vlexploracovendasdireitos == null ){
       $this->si216_vlexploracovendasdireitos = 0;
     }
     if($this->si216_vlvariacoesaumentativasfinanceiras == null ){
       $this->si216_vlvariacoesaumentativasfinanceiras = 0;
     }
     if($this->si216_vltransfdelegacoesrecebidas == null ){
       $this->si216_vltransfdelegacoesrecebidas = 0;
     }
     if($this->si216_vlvalorizacaoativodesincorpassivo == null ){
       $this->si216_vlvalorizacaoativodesincorpassivo = 0;
     }
     if($this->si216_vloutrasvariacoespatriaumentativas == null ){
       $this->si216_vloutrasvariacoespatriaumentativas = 0;
     }
     if($this->si216_vltotalvpaumentativas == null ){
       $this->si216_vltotalvpaumentativas = 0;
     }

     $sql = "insert into dvpdcasp102018(
                                       si216_sequencial 
                                      ,si216_tiporegistro 
                                      ,si216_vlimpostos 
                                      ,si216_vlcontribuicoes 
                                      ,si216_vlexploracovendasdireitos 
                                      ,si216_vlvariacoesaumentativasfinanceiras 
                                      ,si216_vltransfdelegacoesrecebidas 
                                      ,si216_vlvalorizacaoativodesincorpassivo 
                                      ,si216_vloutrasvariacoespatriaumentativas 
                                      ,si216_vltotalvpaumentativas 
                                      ,si216_ano
                                      ,si216_periodo
                                      ,si216_institu
                       )
                values (
                                (select nextval('dvpdcasp102018_si216_sequencial_seq'))
                               ,$this->si216_tiporegistro 
                               ,$this->si216_vlimpostos 
                               ,$this->si216_vlcontribuicoes 
                               ,$this->si216_vlexploracovendasdireitos 
                               ,$this->si216_vlvariacoesaumentativasfinanceiras 
                               ,$this->si216_vltransfdelegacoesrecebidas 
                               ,$this->si216_vlvalorizacaoativodesincorpassivo 
                               ,$this->si216_vloutrasvariacoespatriaumentativas 
                               ,$this->si216_vltotalvpaumentativas 
                               ,$this->si216_ano
                               ,$this->si216_periodo
                               ,$this->si216_institu
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dvpdcasp102018 ($this->si216_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "dvpdcasp102018 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "dvpdcasp102018 ($this->si216_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si216_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   } 
   // funcao para alteracao
   function alterar ($si216_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dvpdcasp102018 set ";
     $virgula = "";
     if(trim($this->si216_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si216_sequencial"])){ 
       $sql  .= $virgula." si216_sequencial = $this->si216_sequencial ";
       $virgula = ",";
       if(trim($this->si216_sequencial) == null ){ 
         $this->erro_sql = " Campo si216_sequencial não informado.";
         $this->erro_campo = "si216_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si216_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si216_tiporegistro"])){ 
       $sql  .= $virgula." si216_tiporegistro = $this->si216_tiporegistro ";
       $virgula = ",";
       if(trim($this->si216_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si216_tiporegistro não informado.";
         $this->erro_campo = "si216_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si216_vlimpostos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si216_vlimpostos"])){ 
       $sql  .= $virgula." si216_vlimpostos = $this->si216_vlimpostos ";
       $virgula = ",";
       if(trim($this->si216_vlimpostos) == null ){ 
         $this->erro_sql = " Campo si216_vlimpostos não informado.";
         $this->erro_campo = "si216_vlimpostos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si216_vlcontribuicoes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si216_vlcontribuicoes"])){ 
       $sql  .= $virgula." si216_vlcontribuicoes = $this->si216_vlcontribuicoes ";
       $virgula = ",";
       if(trim($this->si216_vlcontribuicoes) == null ){ 
         $this->erro_sql = " Campo si216_vlcontribuicoes não informado.";
         $this->erro_campo = "si216_vlcontribuicoes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si216_vlexploracovendasdireitos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si216_vlexploracovendasdireitos"])){ 
       $sql  .= $virgula." si216_vlexploracovendasdireitos = $this->si216_vlexploracovendasdireitos ";
       $virgula = ",";
       if(trim($this->si216_vlexploracovendasdireitos) == null ){ 
         $this->erro_sql = " Campo si216_vlexploracovendasdireitos não informado.";
         $this->erro_campo = "si216_vlexploracovendasdireitos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si216_vlvariacoesaumentativasfinanceiras)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si216_vlvariacoesaumentativasfinanceiras"])){ 
       $sql  .= $virgula." si216_vlvariacoesaumentativasfinanceiras = $this->si216_vlvariacoesaumentativasfinanceiras ";
       $virgula = ",";
       if(trim($this->si216_vlvariacoesaumentativasfinanceiras) == null ){ 
         $this->erro_sql = " Campo si216_vlvariacoesaumentativasfinanceiras não informado.";
         $this->erro_campo = "si216_vlvariacoesaumentativasfinanceiras";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si216_vltransfdelegacoesrecebidas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si216_vltransfdelegacoesrecebidas"])){ 
       $sql  .= $virgula." si216_vltransfdelegacoesrecebidas = $this->si216_vltransfdelegacoesrecebidas ";
       $virgula = ",";
       if(trim($this->si216_vltransfdelegacoesrecebidas) == null ){ 
         $this->erro_sql = " Campo si216_vltransfdelegacoesrecebidas não informado.";
         $this->erro_campo = "si216_vltransfdelegacoesrecebidas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si216_vlvalorizacaoativodesincorpassivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si216_vlvalorizacaoativodesincorpassivo"])){ 
       $sql  .= $virgula." si216_vlvalorizacaoativodesincorpassivo = $this->si216_vlvalorizacaoativodesincorpassivo ";
       $virgula = ",";
       if(trim($this->si216_vlvalorizacaoativodesincorpassivo) == null ){ 
         $this->erro_sql = " Campo si216_vlvalorizacaoativodesincorpassivo não informado.";
         $this->erro_campo = "si216_vlvalorizacaoativodesincorpassivo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si216_vloutrasvariacoespatriaumentativas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si216_vloutrasvariacoespatriaumentativas"])){ 
       $sql  .= $virgula." si216_vloutrasvariacoespatriaumentativas = $this->si216_vloutrasvariacoespatriaumentativas ";
       $virgula = ",";
       if(trim($this->si216_vloutrasvariacoespatriaumentativas) == null ){ 
         $this->erro_sql = " Campo si216_vloutrasvariacoespatriaumentativas não informado.";
         $this->erro_campo = "si216_vloutrasvariacoespatriaumentativas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si216_vltotalvpaumentativas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si216_vltotalvpaumentativas"])){ 
       $sql  .= $virgula." si216_vltotalvpaumentativas = $this->si216_vltotalvpaumentativas ";
       $virgula = ",";
       if(trim($this->si216_vltotalvpaumentativas) == null ){ 
         $this->erro_sql = " Campo si216_vltotalvpaumentativas não informado.";
         $this->erro_campo = "si216_vltotalvpaumentativas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si216_sequencial!=null){
       $sql .= " si216_sequencial = $this->si216_sequencial";
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dvpdcasp102018 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si216_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dvpdcasp102018 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si216_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si216_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si216_sequencial=null,$dbwhere=null) {
     $sql = " delete from dvpdcasp102018
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si216_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si216_sequencial = $si216_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dvpdcasp102018 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si216_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dvpdcasp102018 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si216_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si216_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dvpdcasp102018";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si216_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dvpdcasp102018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si216_sequencial!=null ){
         $sql2 .= " where dvpdcasp102018.si216_sequencial = $si216_sequencial "; 
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
   function sql_query_file ( $si216_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dvpdcasp102018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si216_sequencial!=null ){
         $sql2 .= " where dvpdcasp102018.si216_sequencial = $si216_sequencial "; 
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
