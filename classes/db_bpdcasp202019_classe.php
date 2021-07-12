<?
//MODULO: sicom
//CLASSE DA ENTIDADE bpdcasp202019
class cl_bpdcasp202019 { 
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
   var $si209_sequencial = 0; 
   var $si209_tiporegistro = 0; 
   var $si209_vlpassivcircultrabprevicurtoprazo = 0; 
   var $si209_vlpassivcirculemprefinancurtoprazo = 0; 
   var $si209_vlpassivocirculafornecedcurtoprazo = 0; 
   var $si209_vlpassicircuobrigfiscacurtoprazo = 0; 
   var $si209_vlpassivocirculaobrigacoutrosentes = 0; 
   var $si209_vlpassivocirculaprovisoecurtoprazo = 0; 
   var $si209_vlpassicircudemaiobrigcurtoprazo = 0; 
   var $si209_vlpassinaocircutrabprevilongoprazo = 0; 
   var $si209_vlpassnaocircemprfinalongpraz = 0; 
   var $si209_vlpassivnaocirculforneclongoprazo = 0; 
   var $si209_vlpassnaocircobrifisclongpraz = 0; 
   var $si209_vlpassivnaocirculprovislongoprazo = 0; 
   var $si209_vlpassnaocircdemaobrilongpraz = 0; 
   var $si209_vlpassivonaocircularesuldiferido = 0; 
   var $si209_vlpatriliquidocapitalsocial = 0; 
   var $si209_vlpatriliquidoadianfuturocapital = 0; 
   var $si209_vlpatriliquidoreservacapital = 0; 
   var $si209_vlpatriliquidoajustavaliacao = 0; 
   var $si209_vlpatriliquidoreservalucros = 0; 
   var $si209_vlpatriliquidodemaisreservas = 0; 
   var $si209_vlpatriliquidoresultexercicio = 0; 
   var $si209_vlpatriliquidresultacumexeranteri = 0; 
   var $si209_vlpatriliquidoacoescotas = 0; 
   var $si209_vltotalpassivo = 0; 
   var $si209_ano = 0;
   var $si209_periodo = 0;
   var $si209_institu = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si209_sequencial = int4 = si209_sequencial 
                 si209_tiporegistro = int4 = si209_tiporegistro 
                 si209_vlpassivcircultrabprevicurtoprazo = float4 = si209_vlpassivcircultrabprevicurtoprazo 
                 si209_vlpassivcirculemprefinancurtoprazo = float4 = si209_vlpassivcirculemprefinancurtoprazo 
                 si209_vlpassivocirculafornecedcurtoprazo = float4 = si209_vlpassivocirculafornecedcurtoprazo 
                 si209_vlpassicircuobrigfiscacurtoprazo = float4 = si209_vlpassicircuobrigfiscacurtoprazo 
                 si209_vlpassivocirculaobrigacoutrosentes = float4 = si209_vlpassivocirculaobrigacoutrosentes 
                 si209_vlpassivocirculaprovisoecurtoprazo = float4 = si209_vlpassivocirculaprovisoecurtoprazo 
                 si209_vlpassicircudemaiobrigcurtoprazo = float4 = si209_vlpassicircudemaiobrigcurtoprazo 
                 si209_vlpassinaocircutrabprevilongoprazo = float4 = si209_vlpassinaocircutrabprevilongoprazo 
                 si209_vlpassnaocircemprfinalongpraz = float4 = si209_vlpassnaocircemprfinalongpraz 
                 si209_vlpassivnaocirculforneclongoprazo = float4 = si209_vlpassivnaocirculforneclongoprazo 
                 si209_vlpassnaocircobrifisclongpraz = float4 = si209_vlpassnaocircobrifisclongpraz 
                 si209_vlpassivnaocirculprovislongoprazo = float4 = si209_vlpassivnaocirculprovislongoprazo 
                 si209_vlpassnaocircdemaobrilongpraz = float4 = si209_vlpassnaocircdemaobrilongpraz 
                 si209_vlpassivonaocircularesuldiferido = float4 = si209_vlpassivonaocircularesuldiferido 
                 si209_vlpatriliquidocapitalsocial = float4 = si209_vlpatriliquidocapitalsocial 
                 si209_vlpatriliquidoadianfuturocapital = float4 = si209_vlpatriliquidoadianfuturocapital 
                 si209_vlpatriliquidoreservacapital = float4 = si209_vlpatriliquidoreservacapital 
                 si209_vlpatriliquidoajustavaliacao = float4 = si209_vlpatriliquidoajustavaliacao 
                 si209_vlpatriliquidoreservalucros = float4 = si209_vlpatriliquidoreservalucros 
                 si209_vlpatriliquidodemaisreservas = float4 = si209_vlpatriliquidodemaisreservas 
                 si209_vlpatriliquidoresultexercicio = float4 = si209_vlpatriliquidoresultexercicio 
                 si209_vlpatriliquidresultacumexeranteri = float4 = si209_vlpatriliquidresultacumexeranteri 
                 si209_vlpatriliquidoacoescotas = float4 = si209_vlpatriliquidoacoescotas 
                 si209_vltotalpassivo = float4 = si209_vltotalpassivo 
                 ";
   //funcao construtor da classe 
   function cl_bpdcasp202019() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bpdcasp202019"); 
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
       $this->si209_sequencial = ($this->si209_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_sequencial"]:$this->si209_sequencial);
       $this->si209_tiporegistro = ($this->si209_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_tiporegistro"]:$this->si209_tiporegistro);
       $this->si209_vlpassivcircultrabprevicurtoprazo = ($this->si209_vlpassivcircultrabprevicurtoprazo == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassivcircultrabprevicurtoprazo"]:$this->si209_vlpassivcircultrabprevicurtoprazo);
       $this->si209_vlpassivcirculemprefinancurtoprazo = ($this->si209_vlpassivcirculemprefinancurtoprazo == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassivcirculemprefinancurtoprazo"]:$this->si209_vlpassivcirculemprefinancurtoprazo);
       $this->si209_vlpassivocirculafornecedcurtoprazo = ($this->si209_vlpassivocirculafornecedcurtoprazo == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassivocirculafornecedcurtoprazo"]:$this->si209_vlpassivocirculafornecedcurtoprazo);
       $this->si209_vlpassicircuobrigfiscacurtoprazo = ($this->si209_vlpassicircuobrigfiscacurtoprazo == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassicircuobrigfiscacurtoprazo"]:$this->si209_vlpassicircuobrigfiscacurtoprazo);
       $this->si209_vlpassivocirculaobrigacoutrosentes = ($this->si209_vlpassivocirculaobrigacoutrosentes == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassivocirculaobrigacoutrosentes"]:$this->si209_vlpassivocirculaobrigacoutrosentes);
       $this->si209_vlpassivocirculaprovisoecurtoprazo = ($this->si209_vlpassivocirculaprovisoecurtoprazo == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassivocirculaprovisoecurtoprazo"]:$this->si209_vlpassivocirculaprovisoecurtoprazo);
       $this->si209_vlpassicircudemaiobrigcurtoprazo = ($this->si209_vlpassicircudemaiobrigcurtoprazo == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassicircudemaiobrigcurtoprazo"]:$this->si209_vlpassicircudemaiobrigcurtoprazo);
       $this->si209_vlpassinaocircutrabprevilongoprazo = ($this->si209_vlpassinaocircutrabprevilongoprazo == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassinaocircutrabprevilongoprazo"]:$this->si209_vlpassinaocircutrabprevilongoprazo);
       $this->si209_vlpassnaocircemprfinalongpraz = ($this->si209_vlpassnaocircemprfinalongpraz == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassnaocircemprfinalongpraz"]:$this->si209_vlpassnaocircemprfinalongpraz);
       $this->si209_vlpassivnaocirculforneclongoprazo = ($this->si209_vlpassivnaocirculforneclongoprazo == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassivnaocirculforneclongoprazo"]:$this->si209_vlpassivnaocirculforneclongoprazo);
       $this->si209_vlpassnaocircobrifisclongpraz = ($this->si209_vlpassnaocircobrifisclongpraz == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassnaocircobrifisclongpraz"]:$this->si209_vlpassnaocircobrifisclongpraz);
       $this->si209_vlpassivnaocirculprovislongoprazo = ($this->si209_vlpassivnaocirculprovislongoprazo == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassivnaocirculprovislongoprazo"]:$this->si209_vlpassivnaocirculprovislongoprazo);
       $this->si209_vlpassnaocircdemaobrilongpraz = ($this->si209_vlpassnaocircdemaobrilongpraz == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassnaocircdemaobrilongpraz"]:$this->si209_vlpassnaocircdemaobrilongpraz);
       $this->si209_vlpassivonaocircularesuldiferido = ($this->si209_vlpassivonaocircularesuldiferido == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpassivonaocircularesuldiferido"]:$this->si209_vlpassivonaocircularesuldiferido);
       $this->si209_vlpatriliquidocapitalsocial = ($this->si209_vlpatriliquidocapitalsocial == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidocapitalsocial"]:$this->si209_vlpatriliquidocapitalsocial);
       $this->si209_vlpatriliquidoadianfuturocapital = ($this->si209_vlpatriliquidoadianfuturocapital == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoadianfuturocapital"]:$this->si209_vlpatriliquidoadianfuturocapital);
       $this->si209_vlpatriliquidoreservacapital = ($this->si209_vlpatriliquidoreservacapital == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoreservacapital"]:$this->si209_vlpatriliquidoreservacapital);
       $this->si209_vlpatriliquidoajustavaliacao = ($this->si209_vlpatriliquidoajustavaliacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoajustavaliacao"]:$this->si209_vlpatriliquidoajustavaliacao);
       $this->si209_vlpatriliquidoreservalucros = ($this->si209_vlpatriliquidoreservalucros == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoreservalucros"]:$this->si209_vlpatriliquidoreservalucros);
       $this->si209_vlpatriliquidodemaisreservas = ($this->si209_vlpatriliquidodemaisreservas == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidodemaisreservas"]:$this->si209_vlpatriliquidodemaisreservas);
       $this->si209_vlpatriliquidoresultexercicio = ($this->si209_vlpatriliquidoresultexercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoresultexercicio"]:$this->si209_vlpatriliquidoresultexercicio);
       $this->si209_vlpatriliquidresultacumexeranteri = ($this->si209_vlpatriliquidresultacumexeranteri == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidresultacumexeranteri"]:$this->si209_vlpatriliquidresultacumexeranteri);
       $this->si209_vlpatriliquidoacoescotas = ($this->si209_vlpatriliquidoacoescotas == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoacoescotas"]:$this->si209_vlpatriliquidoacoescotas);
       $this->si209_vltotalpassivo = ($this->si209_vltotalpassivo == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_vltotalpassivo"]:$this->si209_vltotalpassivo);
       $this->si209_ano = ($this->si209_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_ano"]:$this->si209_ano);
       $this->si209_periodo = ($this->si209_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_periodo"]:$this->si209_periodo);
       $this->si209_institu = ($this->si209_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_institu"]:$this->si209_institu);
     }else{
       $this->si209_sequencial = ($this->si209_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si209_sequencial"]:$this->si209_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si209_sequencial){ 
      $this->atualizacampos();
     if($this->si209_tiporegistro == null ){
       $this->erro_sql = " Campo si209_tiporegistro não informado.";
       $this->erro_campo = "si209_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si209_vlpassivcircultrabprevicurtoprazo == null ){
         $this->si209_vlpassivcircultrabprevicurtoprazo = 0;
     }
     if($this->si209_vlpassivcirculemprefinancurtoprazo == null ){
         $this->si209_vlpassivcirculemprefinancurtoprazo = 0;
     }
     if($this->si209_vlpassivocirculafornecedcurtoprazo == null ){
         $this->si209_vlpassivocirculafornecedcurtoprazo = 0;
     }
     if($this->si209_vlpassicircuobrigfiscacurtoprazo == null ){
         $this->si209_vlpassicircuobrigfiscacurtoprazo = 0;
     }
     if($this->si209_vlpassivocirculaobrigacoutrosentes == null ){
         $this->si209_vlpassivocirculaobrigacoutrosentes = 0;
     }
     if($this->si209_vlpassivocirculaprovisoecurtoprazo == null ){
         $this->si209_vlpassivocirculaprovisoecurtoprazo = 0;
     }
     if($this->si209_vlpassicircudemaiobrigcurtoprazo == null ){
         $this->si209_vlpassicircudemaiobrigcurtoprazo = 0;
     }
     if($this->si209_vlpassinaocircutrabprevilongoprazo == null ){
         $this->si209_vlpassinaocircutrabprevilongoprazo = 0;
     }
     if($this->si209_vlpassnaocircemprfinalongpraz == null ){
         $this->si209_vlpassnaocircemprfinalongpraz = 0;
     }
     if($this->si209_vlpassivnaocirculforneclongoprazo == null ){
         $this->si209_vlpassivnaocirculforneclongoprazo = 0;
     }
     if($this->si209_vlpassnaocircobrifisclongpraz == null ){
         $this->si209_vlpassnaocircobrifisclongpraz = 0;
     }
     if($this->si209_vlpassivnaocirculprovislongoprazo == null ){
         $this->si209_vlpassivnaocirculprovislongoprazo = 0;
     }
     if($this->si209_vlpassnaocircdemaobrilongpraz == null ){
         $this->si209_vlpassnaocircdemaobrilongpraz = 0;
     }
     if($this->si209_vlpassivonaocircularesuldiferido == null ){
         $this->si209_vlpassivonaocircularesuldiferido = 0;
     }
     if($this->si209_vlpatriliquidocapitalsocial == null ){
         $this->si209_vlpatriliquidocapitalsocial = 0;
     }
     if($this->si209_vlpatriliquidoadianfuturocapital == null ){
         $this->si209_vlpatriliquidoadianfuturocapital = 0;
     }
     if($this->si209_vlpatriliquidoreservacapital == null ){
         $this->si209_vlpatriliquidoreservacapital = 0;
     }
     if($this->si209_vlpatriliquidoajustavaliacao == null ){
         $this->si209_vlpatriliquidoajustavaliacao = 0;
     }
     if($this->si209_vlpatriliquidoreservalucros == null ){
         $this->si209_vlpatriliquidoreservalucros = 0;
     }
     if($this->si209_vlpatriliquidodemaisreservas == null ){
         $this->si209_vlpatriliquidodemaisreservas = 0;
     }
     if($this->si209_vlpatriliquidoresultexercicio == null ){
         $this->si209_vlpatriliquidoresultexercicio = 0;
     }
     if($this->si209_vlpatriliquidresultacumexeranteri == null ){
         $this->si209_vlpatriliquidresultacumexeranteri = 0;
     }
     if($this->si209_vlpatriliquidoacoescotas == null ){
         $this->si209_vlpatriliquidoacoescotas = 0;
     }
     if($this->si209_vltotalpassivo == null ){
         $this->si209_vltotalpassivo = 0;
     }

     $sql = "insert into bpdcasp202019(
                                       si209_sequencial 
                                      ,si209_tiporegistro 
                                      ,si209_vlpassivcircultrabprevicurtoprazo 
                                      ,si209_vlpassivcirculemprefinancurtoprazo 
                                      ,si209_vlpassivocirculafornecedcurtoprazo 
                                      ,si209_vlpassicircuobrigfiscacurtoprazo 
                                      ,si209_vlpassivocirculaobrigacoutrosentes 
                                      ,si209_vlpassivocirculaprovisoecurtoprazo 
                                      ,si209_vlpassicircudemaiobrigcurtoprazo 
                                      ,si209_vlpassinaocircutrabprevilongoprazo 
                                      ,si209_vlpassnaocircemprfinalongpraz 
                                      ,si209_vlpassivnaocirculforneclongoprazo 
                                      ,si209_vlpassnaocircobrifisclongpraz 
                                      ,si209_vlpassivnaocirculprovislongoprazo 
                                      ,si209_vlpassnaocircdemaobrilongpraz 
                                      ,si209_vlpassivonaocircularesuldiferido 
                                      ,si209_vlpatriliquidocapitalsocial 
                                      ,si209_vlpatriliquidoadianfuturocapital 
                                      ,si209_vlpatriliquidoreservacapital 
                                      ,si209_vlpatriliquidoajustavaliacao 
                                      ,si209_vlpatriliquidoreservalucros 
                                      ,si209_vlpatriliquidodemaisreservas 
                                      ,si209_vlpatriliquidoresultexercicio 
                                      ,si209_vlpatriliquidresultacumexeranteri 
                                      ,si209_vlpatriliquidoacoescotas 
                                      ,si209_vltotalpassivo 
                                      ,si209_ano
                                      ,si209_periodo
                                      ,si209_institu
                       )
                values (
                                (select nextval('bpdcasp202019_si209_sequencial_seq'))
                               ,$this->si209_tiporegistro 
                               ,$this->si209_vlpassivcircultrabprevicurtoprazo 
                               ,$this->si209_vlpassivcirculemprefinancurtoprazo 
                               ,$this->si209_vlpassivocirculafornecedcurtoprazo 
                               ,$this->si209_vlpassicircuobrigfiscacurtoprazo 
                               ,$this->si209_vlpassivocirculaobrigacoutrosentes 
                               ,$this->si209_vlpassivocirculaprovisoecurtoprazo 
                               ,$this->si209_vlpassicircudemaiobrigcurtoprazo 
                               ,$this->si209_vlpassinaocircutrabprevilongoprazo 
                               ,$this->si209_vlpassnaocircemprfinalongpraz 
                               ,$this->si209_vlpassivnaocirculforneclongoprazo 
                               ,$this->si209_vlpassnaocircobrifisclongpraz 
                               ,$this->si209_vlpassivnaocirculprovislongoprazo 
                               ,$this->si209_vlpassnaocircdemaobrilongpraz 
                               ,$this->si209_vlpassivonaocircularesuldiferido 
                               ,$this->si209_vlpatriliquidocapitalsocial 
                               ,$this->si209_vlpatriliquidoadianfuturocapital 
                               ,$this->si209_vlpatriliquidoreservacapital 
                               ,$this->si209_vlpatriliquidoajustavaliacao 
                               ,$this->si209_vlpatriliquidoreservalucros 
                               ,$this->si209_vlpatriliquidodemaisreservas 
                               ,$this->si209_vlpatriliquidoresultexercicio 
                               ,$this->si209_vlpatriliquidresultacumexeranteri 
                               ,$this->si209_vlpatriliquidoacoescotas 
                               ,$this->si209_vltotalpassivo 
                               ,$this->si209_ano
                               ,$this->si209_periodo
                               ,$this->si209_institu
                      )";
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bpdcasp202019 ($this->si209_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "bpdcasp202019 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "bpdcasp202019 ($this->si209_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si209_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   } 
   // funcao para alteracao
   function alterar ($si209_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update bpdcasp202019 set ";
     $virgula = "";
     if(trim($this->si209_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_sequencial"])){ 
       $sql  .= $virgula." si209_sequencial = $this->si209_sequencial ";
       $virgula = ",";
       if(trim($this->si209_sequencial) == null ){ 
         $this->erro_sql = " Campo si209_sequencial não informado.";
         $this->erro_campo = "si209_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_tiporegistro"])){ 
       $sql  .= $virgula." si209_tiporegistro = $this->si209_tiporegistro ";
       $virgula = ",";
       if(trim($this->si209_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si209_tiporegistro não informado.";
         $this->erro_campo = "si209_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassivcircultrabprevicurtoprazo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivcircultrabprevicurtoprazo"])){ 
       $sql  .= $virgula." si209_vlpassivcircultrabprevicurtoprazo = $this->si209_vlpassivcircultrabprevicurtoprazo ";
       $virgula = ",";
       if(trim($this->si209_vlpassivcircultrabprevicurtoprazo) == null ){ 
         $this->erro_sql = " Campo si209_vlpassivcircultrabprevicurtoprazo não informado.";
         $this->erro_campo = "si209_vlpassivcircultrabprevicurtoprazo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassivcirculemprefinancurtoprazo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivcirculemprefinancurtoprazo"])){ 
       $sql  .= $virgula." si209_vlpassivcirculemprefinancurtoprazo = $this->si209_vlpassivcirculemprefinancurtoprazo ";
       $virgula = ",";
       if(trim($this->si209_vlpassivcirculemprefinancurtoprazo) == null ){ 
         $this->erro_sql = " Campo si209_vlpassivcirculemprefinancurtoprazo não informado.";
         $this->erro_campo = "si209_vlpassivcirculemprefinancurtoprazo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassivocirculafornecedcurtoprazo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivocirculafornecedcurtoprazo"])){ 
       $sql  .= $virgula." si209_vlpassivocirculafornecedcurtoprazo = $this->si209_vlpassivocirculafornecedcurtoprazo ";
       $virgula = ",";
       if(trim($this->si209_vlpassivocirculafornecedcurtoprazo) == null ){ 
         $this->erro_sql = " Campo si209_vlpassivocirculafornecedcurtoprazo não informado.";
         $this->erro_campo = "si209_vlpassivocirculafornecedcurtoprazo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassicircuobrigfiscacurtoprazo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassicircuobrigfiscacurtoprazo"])){ 
       $sql  .= $virgula." si209_vlpassicircuobrigfiscacurtoprazo = $this->si209_vlpassicircuobrigfiscacurtoprazo ";
       $virgula = ",";
       if(trim($this->si209_vlpassicircuobrigfiscacurtoprazo) == null ){ 
         $this->erro_sql = " Campo si209_vlpassicircuobrigfiscacurtoprazo não informado.";
         $this->erro_campo = "si209_vlpassicircuobrigfiscacurtoprazo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassivocirculaobrigacoutrosentes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivocirculaobrigacoutrosentes"])){ 
       $sql  .= $virgula." si209_vlpassivocirculaobrigacoutrosentes = $this->si209_vlpassivocirculaobrigacoutrosentes ";
       $virgula = ",";
       if(trim($this->si209_vlpassivocirculaobrigacoutrosentes) == null ){ 
         $this->erro_sql = " Campo si209_vlpassivocirculaobrigacoutrosentes não informado.";
         $this->erro_campo = "si209_vlpassivocirculaobrigacoutrosentes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassivocirculaprovisoecurtoprazo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivocirculaprovisoecurtoprazo"])){ 
       $sql  .= $virgula." si209_vlpassivocirculaprovisoecurtoprazo = $this->si209_vlpassivocirculaprovisoecurtoprazo ";
       $virgula = ",";
       if(trim($this->si209_vlpassivocirculaprovisoecurtoprazo) == null ){ 
         $this->erro_sql = " Campo si209_vlpassivocirculaprovisoecurtoprazo não informado.";
         $this->erro_campo = "si209_vlpassivocirculaprovisoecurtoprazo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassicircudemaiobrigcurtoprazo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassicircudemaiobrigcurtoprazo"])){ 
       $sql  .= $virgula." si209_vlpassicircudemaiobrigcurtoprazo = $this->si209_vlpassicircudemaiobrigcurtoprazo ";
       $virgula = ",";
       if(trim($this->si209_vlpassicircudemaiobrigcurtoprazo) == null ){ 
         $this->erro_sql = " Campo si209_vlpassicircudemaiobrigcurtoprazo não informado.";
         $this->erro_campo = "si209_vlpassicircudemaiobrigcurtoprazo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassinaocircutrabprevilongoprazo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassinaocircutrabprevilongoprazo"])){ 
       $sql  .= $virgula." si209_vlpassinaocircutrabprevilongoprazo = $this->si209_vlpassinaocircutrabprevilongoprazo ";
       $virgula = ",";
       if(trim($this->si209_vlpassinaocircutrabprevilongoprazo) == null ){ 
         $this->erro_sql = " Campo si209_vlpassinaocircutrabprevilongoprazo não informado.";
         $this->erro_campo = "si209_vlpassinaocircutrabprevilongoprazo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassnaocircemprfinalongpraz)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassnaocircemprfinalongpraz"])){ 
       $sql  .= $virgula." si209_vlpassnaocircemprfinalongpraz = $this->si209_vlpassnaocircemprfinalongpraz ";
       $virgula = ",";
       if(trim($this->si209_vlpassnaocircemprfinalongpraz) == null ){ 
         $this->erro_sql = " Campo si209_vlpassnaocircemprfinalongpraz não informado.";
         $this->erro_campo = "si209_vlpassnaocircemprfinalongpraz";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassivnaocirculforneclongoprazo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivnaocirculforneclongoprazo"])){ 
       $sql  .= $virgula." si209_vlpassivnaocirculforneclongoprazo = $this->si209_vlpassivnaocirculforneclongoprazo ";
       $virgula = ",";
       if(trim($this->si209_vlpassivnaocirculforneclongoprazo) == null ){ 
         $this->erro_sql = " Campo si209_vlpassivnaocirculforneclongoprazo não informado.";
         $this->erro_campo = "si209_vlpassivnaocirculforneclongoprazo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassnaocircobrifisclongpraz)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassnaocircobrifisclongpraz"])){ 
       $sql  .= $virgula." si209_vlpassnaocircobrifisclongpraz = $this->si209_vlpassnaocircobrifisclongpraz ";
       $virgula = ",";
       if(trim($this->si209_vlpassnaocircobrifisclongpraz) == null ){ 
         $this->erro_sql = " Campo si209_vlpassnaocircobrifisclongpraz não informado.";
         $this->erro_campo = "si209_vlpassnaocircobrifisclongpraz";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassivnaocirculprovislongoprazo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivnaocirculprovislongoprazo"])){ 
       $sql  .= $virgula." si209_vlpassivnaocirculprovislongoprazo = $this->si209_vlpassivnaocirculprovislongoprazo ";
       $virgula = ",";
       if(trim($this->si209_vlpassivnaocirculprovislongoprazo) == null ){ 
         $this->erro_sql = " Campo si209_vlpassivnaocirculprovislongoprazo não informado.";
         $this->erro_campo = "si209_vlpassivnaocirculprovislongoprazo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassnaocircdemaobrilongpraz)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassnaocircdemaobrilongpraz"])){ 
       $sql  .= $virgula." si209_vlpassnaocircdemaobrilongpraz = $this->si209_vlpassnaocircdemaobrilongpraz ";
       $virgula = ",";
       if(trim($this->si209_vlpassnaocircdemaobrilongpraz) == null ){ 
         $this->erro_sql = " Campo si209_vlpassnaocircdemaobrilongpraz não informado.";
         $this->erro_campo = "si209_vlpassnaocircdemaobrilongpraz";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpassivonaocircularesuldiferido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivonaocircularesuldiferido"])){ 
       $sql  .= $virgula." si209_vlpassivonaocircularesuldiferido = $this->si209_vlpassivonaocircularesuldiferido ";
       $virgula = ",";
       if(trim($this->si209_vlpassivonaocircularesuldiferido) == null ){ 
         $this->erro_sql = " Campo si209_vlpassivonaocircularesuldiferido não informado.";
         $this->erro_campo = "si209_vlpassivonaocircularesuldiferido";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpatriliquidocapitalsocial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidocapitalsocial"])){ 
       $sql  .= $virgula." si209_vlpatriliquidocapitalsocial = $this->si209_vlpatriliquidocapitalsocial ";
       $virgula = ",";
       if(trim($this->si209_vlpatriliquidocapitalsocial) == null ){ 
         $this->erro_sql = " Campo si209_vlpatriliquidocapitalsocial não informado.";
         $this->erro_campo = "si209_vlpatriliquidocapitalsocial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpatriliquidoadianfuturocapital)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoadianfuturocapital"])){ 
       $sql  .= $virgula." si209_vlpatriliquidoadianfuturocapital = $this->si209_vlpatriliquidoadianfuturocapital ";
       $virgula = ",";
       if(trim($this->si209_vlpatriliquidoadianfuturocapital) == null ){ 
         $this->erro_sql = " Campo si209_vlpatriliquidoadianfuturocapital não informado.";
         $this->erro_campo = "si209_vlpatriliquidoadianfuturocapital";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpatriliquidoreservacapital)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoreservacapital"])){ 
       $sql  .= $virgula." si209_vlpatriliquidoreservacapital = $this->si209_vlpatriliquidoreservacapital ";
       $virgula = ",";
       if(trim($this->si209_vlpatriliquidoreservacapital) == null ){ 
         $this->erro_sql = " Campo si209_vlpatriliquidoreservacapital não informado.";
         $this->erro_campo = "si209_vlpatriliquidoreservacapital";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpatriliquidoajustavaliacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoajustavaliacao"])){ 
       $sql  .= $virgula." si209_vlpatriliquidoajustavaliacao = $this->si209_vlpatriliquidoajustavaliacao ";
       $virgula = ",";
       if(trim($this->si209_vlpatriliquidoajustavaliacao) == null ){ 
         $this->erro_sql = " Campo si209_vlpatriliquidoajustavaliacao não informado.";
         $this->erro_campo = "si209_vlpatriliquidoajustavaliacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpatriliquidoreservalucros)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoreservalucros"])){ 
       $sql  .= $virgula." si209_vlpatriliquidoreservalucros = $this->si209_vlpatriliquidoreservalucros ";
       $virgula = ",";
       if(trim($this->si209_vlpatriliquidoreservalucros) == null ){ 
         $this->erro_sql = " Campo si209_vlpatriliquidoreservalucros não informado.";
         $this->erro_campo = "si209_vlpatriliquidoreservalucros";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpatriliquidodemaisreservas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidodemaisreservas"])){ 
       $sql  .= $virgula." si209_vlpatriliquidodemaisreservas = $this->si209_vlpatriliquidodemaisreservas ";
       $virgula = ",";
       if(trim($this->si209_vlpatriliquidodemaisreservas) == null ){ 
         $this->erro_sql = " Campo si209_vlpatriliquidodemaisreservas não informado.";
         $this->erro_campo = "si209_vlpatriliquidodemaisreservas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpatriliquidoresultexercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoresultexercicio"])){ 
       $sql  .= $virgula." si209_vlpatriliquidoresultexercicio = $this->si209_vlpatriliquidoresultexercicio ";
       $virgula = ",";
       if(trim($this->si209_vlpatriliquidoresultexercicio) == null ){ 
         $this->erro_sql = " Campo si209_vlpatriliquidoresultexercicio não informado.";
         $this->erro_campo = "si209_vlpatriliquidoresultexercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpatriliquidresultacumexeranteri)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidresultacumexeranteri"])){ 
       $sql  .= $virgula." si209_vlpatriliquidresultacumexeranteri = $this->si209_vlpatriliquidresultacumexeranteri ";
       $virgula = ",";
       if(trim($this->si209_vlpatriliquidresultacumexeranteri) == null ){ 
         $this->erro_sql = " Campo si209_vlpatriliquidresultacumexeranteri não informado.";
         $this->erro_campo = "si209_vlpatriliquidresultacumexeranteri";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vlpatriliquidoacoescotas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoacoescotas"])){ 
       $sql  .= $virgula." si209_vlpatriliquidoacoescotas = $this->si209_vlpatriliquidoacoescotas ";
       $virgula = ",";
       if(trim($this->si209_vlpatriliquidoacoescotas) == null ){ 
         $this->erro_sql = " Campo si209_vlpatriliquidoacoescotas não informado.";
         $this->erro_campo = "si209_vlpatriliquidoacoescotas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si209_vltotalpassivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si209_vltotalpassivo"])){ 
       $sql  .= $virgula." si209_vltotalpassivo = $this->si209_vltotalpassivo ";
       $virgula = ",";
       if(trim($this->si209_vltotalpassivo) == null ){ 
         $this->erro_sql = " Campo si209_vltotalpassivo não informado.";
         $this->erro_campo = "si209_vltotalpassivo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si209_sequencial!=null){
       $sql .= " si209_sequencial = $this->si209_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si209_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009386,'$this->si209_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_sequencial"]) || $this->si209_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009386,'".AddSlashes(pg_result($resaco,$conresaco,'si209_sequencial'))."','$this->si209_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_tiporegistro"]) || $this->si209_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009388,'".AddSlashes(pg_result($resaco,$conresaco,'si209_tiporegistro'))."','$this->si209_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivcircultrabprevicurtoprazo"]) || $this->si209_vlpassivcircultrabprevicurtoprazo != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009390,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassivcircultrabprevicurtoprazo'))."','$this->si209_vlpassivcircultrabprevicurtoprazo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivcirculemprefinancurtoprazo"]) || $this->si209_vlpassivcirculemprefinancurtoprazo != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009391,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassivcirculemprefinancurtoprazo'))."','$this->si209_vlpassivcirculemprefinancurtoprazo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivocirculafornecedcurtoprazo"]) || $this->si209_vlpassivocirculafornecedcurtoprazo != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009392,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassivocirculafornecedcurtoprazo'))."','$this->si209_vlpassivocirculafornecedcurtoprazo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassicircuobrigfiscacurtoprazo"]) || $this->si209_vlpassicircuobrigfiscacurtoprazo != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009393,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassicircuobrigfiscacurtoprazo'))."','$this->si209_vlpassicircuobrigfiscacurtoprazo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivocirculaobrigacoutrosentes"]) || $this->si209_vlpassivocirculaobrigacoutrosentes != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009394,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassivocirculaobrigacoutrosentes'))."','$this->si209_vlpassivocirculaobrigacoutrosentes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivocirculaprovisoecurtoprazo"]) || $this->si209_vlpassivocirculaprovisoecurtoprazo != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009395,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassivocirculaprovisoecurtoprazo'))."','$this->si209_vlpassivocirculaprovisoecurtoprazo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassicircudemaiobrigcurtoprazo"]) || $this->si209_vlpassicircudemaiobrigcurtoprazo != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009396,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassicircudemaiobrigcurtoprazo'))."','$this->si209_vlpassicircudemaiobrigcurtoprazo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassinaocircutrabprevilongoprazo"]) || $this->si209_vlpassinaocircutrabprevilongoprazo != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009397,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassinaocircutrabprevilongoprazo'))."','$this->si209_vlpassinaocircutrabprevilongoprazo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassnaocircemprfinalongpraz"]) || $this->si209_vlpassnaocircemprfinalongpraz != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009398,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassnaocircemprfinalongpraz'))."','$this->si209_vlpassnaocircemprfinalongpraz',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivnaocirculforneclongoprazo"]) || $this->si209_vlpassivnaocirculforneclongoprazo != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009399,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassivnaocirculforneclongoprazo'))."','$this->si209_vlpassivnaocirculforneclongoprazo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassnaocircobrifisclongpraz"]) || $this->si209_vlpassnaocircobrifisclongpraz != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009400,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassnaocircobrifisclongpraz'))."','$this->si209_vlpassnaocircobrifisclongpraz',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivnaocirculprovislongoprazo"]) || $this->si209_vlpassivnaocirculprovislongoprazo != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009401,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassivnaocirculprovislongoprazo'))."','$this->si209_vlpassivnaocirculprovislongoprazo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassnaocircdemaobrilongpraz"]) || $this->si209_vlpassnaocircdemaobrilongpraz != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009402,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassnaocircdemaobrilongpraz'))."','$this->si209_vlpassnaocircdemaobrilongpraz',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpassivonaocircularesuldiferido"]) || $this->si209_vlpassivonaocircularesuldiferido != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009403,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpassivonaocircularesuldiferido'))."','$this->si209_vlpassivonaocircularesuldiferido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidocapitalsocial"]) || $this->si209_vlpatriliquidocapitalsocial != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009404,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpatriliquidocapitalsocial'))."','$this->si209_vlpatriliquidocapitalsocial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoadianfuturocapital"]) || $this->si209_vlpatriliquidoadianfuturocapital != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009405,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpatriliquidoadianfuturocapital'))."','$this->si209_vlpatriliquidoadianfuturocapital',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoreservacapital"]) || $this->si209_vlpatriliquidoreservacapital != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009406,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpatriliquidoreservacapital'))."','$this->si209_vlpatriliquidoreservacapital',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoajustavaliacao"]) || $this->si209_vlpatriliquidoajustavaliacao != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009407,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpatriliquidoajustavaliacao'))."','$this->si209_vlpatriliquidoajustavaliacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoreservalucros"]) || $this->si209_vlpatriliquidoreservalucros != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009408,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpatriliquidoreservalucros'))."','$this->si209_vlpatriliquidoreservalucros',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidodemaisreservas"]) || $this->si209_vlpatriliquidodemaisreservas != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009409,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpatriliquidodemaisreservas'))."','$this->si209_vlpatriliquidodemaisreservas',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoresultexercicio"]) || $this->si209_vlpatriliquidoresultexercicio != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009410,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpatriliquidoresultexercicio'))."','$this->si209_vlpatriliquidoresultexercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidresultacumexeranteri"]) || $this->si209_vlpatriliquidresultacumexeranteri != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009411,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpatriliquidresultacumexeranteri'))."','$this->si209_vlpatriliquidresultacumexeranteri',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vlpatriliquidoacoescotas"]) || $this->si209_vlpatriliquidoacoescotas != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009412,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vlpatriliquidoacoescotas'))."','$this->si209_vlpatriliquidoacoescotas',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si209_vltotalpassivo"]) || $this->si209_vltotalpassivo != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009413,'".AddSlashes(pg_result($resaco,$conresaco,'si209_vltotalpassivo'))."','$this->si209_vltotalpassivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bpdcasp202019 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si209_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp202019 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si209_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si209_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si209_sequencial=null,$dbwhere=null) { 

     $sql = " delete from bpdcasp202019
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si209_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si209_sequencial = $si209_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bpdcasp202019 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si209_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp202019 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si209_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si209_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:bpdcasp202019";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si209_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp202019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si209_sequencial!=null ){
         $sql2 .= " where bpdcasp202019.si209_sequencial = $si209_sequencial "; 
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
   function sql_query_file ( $si209_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp202019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si209_sequencial!=null ){
         $sql2 .= " where bpdcasp202019.si209_sequencial = $si209_sequencial "; 
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
  function sql_query_vlpatriliquidresultacumexeranteri($iInstit = "", $nAnoUsu=""){

   $nExercicio = db_getsession('DB_anousu');
   if($nAnoUsu != ""){
      $nExercicio =$nAnoUsu;
   }
   if($iInstit == ""){
      $iInstit = db_getsession('DB_instit');
   }

   $sSql = "select saldoanterior+debito-credito as resultacumexeranteri from 
            (select (select sum(case when c62_vlrcre != 0 then c62_vlrcre*-1 else c62_vlrdeb end) saldoanterior 
              from conplanoexe 
               where c62_reduz in (select c61_reduz 
              from conplano 
            inner join conplanoreduz on c61_anousu=c60_anousu and c61_codcon=c60_codcon 
            where c60_anousu={$nExercicio} and substr(c60_estrut,1,4) = '2371' and substr(c60_estrut,6,2) = '02' and c61_instit in ({$iInstit})) and c62_anousu={$nExercicio}) as saldoanterior,
            ( coalesce((select sum(c69_valor) debito 
              from conlancamval 
               where c69_anousu={$nExercicio} and c69_debito in (select c61_reduz 
              from conplano 
            inner join conplanoreduz on c61_anousu=c60_anousu and c61_codcon=c60_codcon 
            where c60_anousu={$nExercicio} and substr(c60_estrut,1,4) = '2371' and substr(c60_estrut,6,2) = '02' and c61_instit in ({$iInstit}))),0)) as debito,
            ( coalesce((select sum(c69_valor) credito 
              from conlancamval 
              where c69_anousu={$nExercicio} and c69_credito in (select c61_reduz 
              from conplano 
            inner join conplanoreduz on c61_anousu=c60_anousu and c61_codcon=c60_codcon 
            where c60_anousu={$nExercicio} and substr(c60_estrut,1,4) = '2371' and substr(c60_estrut,6,2) = '02' and c61_instit in ({$iInstit}))),0 )) as credito) as movimento;
            ";
   return $sSql;
  }

  function sql_query_vlpatriliquidresultacumexer($iInstit = "", $nAnoUsu=""){

   $nExercicio = db_getsession('DB_anousu');
   if($nAnoUsu != ""){
      $nExercicio =$nAnoUsu;
   }
   if($iInstit == ""){
      $iInstit = db_getsession('DB_instit');
   }

   $sSql = "select saldoanterior+debito-credito as resultacumexeranteri from 
            (select (select sum(case when c62_vlrcre != 0 then c62_vlrcre*-1 else c62_vlrdeb end) saldoanterior 
              from conplanoexe 
               where c62_reduz in (select c61_reduz 
              from conplano 
            inner join conplanoreduz on c61_anousu=c60_anousu and c61_codcon=c60_codcon 
            where c60_anousu={$nExercicio} and substr(c60_estrut,1,4) = '2371' and substr(c60_estrut,6,2) = '01' and c61_instit in ({$iInstit})) and c62_anousu={$nExercicio}) as saldoanterior,
            ( coalesce((select sum(c69_valor) debito 
              from conlancamval 
               where c69_anousu={$nExercicio} and c69_debito in (select c61_reduz 
              from conplano 
            inner join conplanoreduz on c61_anousu=c60_anousu and c61_codcon=c60_codcon 
            where c60_anousu={$nExercicio} and substr(c60_estrut,1,4) = '2371' and substr(c60_estrut,6,2) = '01' and c61_instit in ({$iInstit}))),0)) as debito,
            ( coalesce((select sum(c69_valor) credito 
              from conlancamval 
              where c69_anousu={$nExercicio} and c69_credito in (select c61_reduz 
              from conplano 
            inner join conplanoreduz on c61_anousu=c60_anousu and c61_codcon=c60_codcon 
            where c60_anousu={$nExercicio} and substr(c60_estrut,1,4) = '2371' and substr(c60_estrut,6,2) = '01' and c61_instit in ({$iInstit}))),0 )) as credito) as movimento;
            ";
   return $sSql;
  }
}
?>
