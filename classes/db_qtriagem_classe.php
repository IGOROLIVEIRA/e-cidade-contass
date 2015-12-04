<?
//MODULO: farmacia
//CLASSE DA ENTIDADE qtriagem
class cl_qtriagem { 
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
   var $qt_codigo = 0; 
   var $qt_paciente = 0; 
   var $qt_stgravida = 'f'; 
   var $qt_sthipertenso = 'f'; 
   var $qt_stdiabetico = 'f'; 
   var $qt_sttuberculose = 'f'; 
   var $qt_sthanseniase = 'f'; 
   var $qt_stfuma = 'f'; 
   var $qt_tpinstrucaoresponsavel = 0; 
   var $qt_vlpeso = 0; 
   var $qt_vlaltura = 0; 
   var $qt_stpossuifilhos = 'f'; 
   var $qt_stutilizabebida = 'f'; 
   var $qt_stsofreuqueda = 'f'; 
   var $qt_stconseguelocomover = 'f'; 
   var $qt_stdoencagravidez = 'f'; 
   var $qt_stcolesterolalto = 'f'; 
   var $qt_stdoencacoracaofamilia = 'f'; 
   var $qt_tpdiabetes = 0; 
   var $qt_sttratamentotuberculose = 'f'; 
   var $qt_stterminotratamento = 'f'; 
   var $qt_sttratamentohanseniase = 'f'; 
   var $qt_stsintomashanseniase = 'f'; 
   var $qt_dataenviosigaf_dia = null; 
   var $qt_dataenviosigaf_mes = null; 
   var $qt_dataenviosigaf_ano = null; 
   var $qt_dataenviosigaf = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 qt_codigo = int8 = Código 
                 qt_paciente = int8 = Paciente 
                 qt_stgravida = bool = Está grávida 
                 qt_sthipertenso = bool = É hipertenso 
                 qt_stdiabetico = bool = É diabético? 
                 qt_sttuberculose = bool = Possui tuberculose 
                 qt_sthanseniase = bool = Possui hanseníase? 
                 qt_stfuma = bool = Fuma ou reside com fumante 
                 qt_tpinstrucaoresponsavel = int4 = Qual seu grau de instrução 
                 qt_vlpeso = float8 = Peso da Criança 
                 qt_vlaltura = float8 = Altura da Criança 
                 qt_stpossuifilhos = bool = Tem filho(s) ou já esteve grávida 
                 qt_stutilizabebida = bool = Faz uso de bebida alcoólica 
                 qt_stsofreuqueda = bool = Sofreu queda no último ano 
                 qt_stconseguelocomover = bool = Consegue ir aos lugares sozinho 
                 qt_stdoencagravidez = bool = Tem, infecção urinária, toxoplasmose, HIV, sífilis 
                 qt_stcolesterolalto = bool = Colesterol alto 
                 qt_stdoencacoracaofamilia = bool = hipertensão na família 
                 qt_tpdiabetes = int4 = Classificação Diabetes 
                 qt_sttratamentotuberculose = bool = Tratou mais de uma vez (Tuberculose) 
                 qt_stterminotratamento = bool = Completou tratamento conforme esperado 
                 qt_sttratamentohanseniase = bool = Tratou mais de uma vez (Hanseniase) 
                 qt_stsintomashanseniase = bool = febre, malestar, feridas, ínguas 
                 qt_dataenviosigaf = date = Data de envio para o sigaf 
                 ";
   //funcao construtor da classe 
   function cl_qtriagem() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("qtriagem"); 
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
       $this->qt_codigo = ($this->qt_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["qt_codigo"]:$this->qt_codigo);
       $this->qt_paciente = ($this->qt_paciente == ""?@$GLOBALS["HTTP_POST_VARS"]["qt_paciente"]:$this->qt_paciente);
       $this->qt_stgravida = ($this->qt_stgravida == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_stgravida"]:$this->qt_stgravida);
       $this->qt_sthipertenso = ($this->qt_sthipertenso == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_sthipertenso"]:$this->qt_sthipertenso);
       $this->qt_stdiabetico = ($this->qt_stdiabetico == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_stdiabetico"]:$this->qt_stdiabetico);
       $this->qt_sttuberculose = ($this->qt_sttuberculose == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_sttuberculose"]:$this->qt_sttuberculose);
       $this->qt_sthanseniase = ($this->qt_sthanseniase == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_sthanseniase"]:$this->qt_sthanseniase);
       $this->qt_stfuma = ($this->qt_stfuma == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_stfuma"]:$this->qt_stfuma);
       $this->qt_tpinstrucaoresponsavel = ($this->qt_tpinstrucaoresponsavel == ""?@$GLOBALS["HTTP_POST_VARS"]["qt_tpinstrucaoresponsavel"]:$this->qt_tpinstrucaoresponsavel);
       $this->qt_vlpeso = ($this->qt_vlpeso == ""?@$GLOBALS["HTTP_POST_VARS"]["qt_vlpeso"]:$this->qt_vlpeso);
       $this->qt_vlaltura = ($this->qt_vlaltura == ""?@$GLOBALS["HTTP_POST_VARS"]["qt_vlaltura"]:$this->qt_vlaltura);
       $this->qt_stpossuifilhos = ($this->qt_stpossuifilhos == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_stpossuifilhos"]:$this->qt_stpossuifilhos);
       $this->qt_stutilizabebida = ($this->qt_stutilizabebida == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_stutilizabebida"]:$this->qt_stutilizabebida);
       $this->qt_stsofreuqueda = ($this->qt_stsofreuqueda == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_stsofreuqueda"]:$this->qt_stsofreuqueda);
       $this->qt_stconseguelocomover = ($this->qt_stconseguelocomover == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_stconseguelocomover"]:$this->qt_stconseguelocomover);
       $this->qt_stdoencagravidez = ($this->qt_stdoencagravidez == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_stdoencagravidez"]:$this->qt_stdoencagravidez);
       $this->qt_stcolesterolalto = ($this->qt_stcolesterolalto == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_stcolesterolalto"]:$this->qt_stcolesterolalto);
       $this->qt_stdoencacoracaofamilia = ($this->qt_stdoencacoracaofamilia == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_stdoencacoracaofamilia"]:$this->qt_stdoencacoracaofamilia);
       $this->qt_tpdiabetes = ($this->qt_tpdiabetes == ""?@$GLOBALS["HTTP_POST_VARS"]["qt_tpdiabetes"]:$this->qt_tpdiabetes);
       $this->qt_sttratamentotuberculose = ($this->qt_sttratamentotuberculose == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_sttratamentotuberculose"]:$this->qt_sttratamentotuberculose);
       $this->qt_stterminotratamento = ($this->qt_stterminotratamento == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_stterminotratamento"]:$this->qt_stterminotratamento);
       $this->qt_sttratamentohanseniase = ($this->qt_sttratamentohanseniase == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_sttratamentohanseniase"]:$this->qt_sttratamentohanseniase);
       $this->qt_stsintomashanseniase = ($this->qt_stsintomashanseniase == "f"?@$GLOBALS["HTTP_POST_VARS"]["qt_stsintomashanseniase"]:$this->qt_stsintomashanseniase);
       if($this->qt_dataenviosigaf == ""){
         $this->qt_dataenviosigaf_dia = ($this->qt_dataenviosigaf_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["qt_dataenviosigaf_dia"]:$this->qt_dataenviosigaf_dia);
         $this->qt_dataenviosigaf_mes = ($this->qt_dataenviosigaf_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["qt_dataenviosigaf_mes"]:$this->qt_dataenviosigaf_mes);
         $this->qt_dataenviosigaf_ano = ($this->qt_dataenviosigaf_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["qt_dataenviosigaf_ano"]:$this->qt_dataenviosigaf_ano);
         if($this->qt_dataenviosigaf_dia != ""){
            $this->qt_dataenviosigaf = $this->qt_dataenviosigaf_ano."-".$this->qt_dataenviosigaf_mes."-".$this->qt_dataenviosigaf_dia;
         }
       }
     }else{
       $this->qt_codigo = ($this->qt_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["qt_codigo"]:$this->qt_codigo);
     }
   }
   // funcao para inclusao
   function incluir ($qt_codigo){ 
      $this->atualizacampos();
     if($this->qt_paciente == null ){ 
       $this->erro_sql = " Campo Paciente não informado.";
       $this->erro_campo = "qt_paciente";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->qt_stgravida == null ){ 
       $this->erro_sql = " Campo Está grávida não informado.";
       $this->erro_campo = "qt_stgravida";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->qt_sthipertenso == null ){ 
       $this->erro_sql = " Campo É hipertenso não informado.";
       $this->erro_campo = "qt_sthipertenso";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->qt_stdiabetico == null ){ 
       $this->erro_sql = " Campo É diabético? não informado.";
       $this->erro_campo = "qt_stdiabetico";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->qt_sttuberculose == null ){ 
       $this->erro_sql = " Campo Possui tuberculose não informado.";
       $this->erro_campo = "qt_sttuberculose";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->qt_sthanseniase == null ){ 
       $this->erro_sql = " Campo Possui hanseníase? não informado.";
       $this->erro_campo = "qt_sthanseniase";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->qt_stfuma == null ){ 
       $this->erro_sql = " Campo Fuma ou reside com fumante não informado.";
       $this->erro_campo = "qt_stfuma";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     /*if($this->qt_tpinstrucaoresponsavel == null ){ 
       $this->erro_sql = " Campo Qual seu grau de instrução não informado.";
       $this->erro_campo = "qt_tpinstrucaoresponsavel";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }*/

     if($this->qt_tpinstrucaoresponsavel == null ){ 
       $this->qt_tpinstrucaoresponsavel = "0";
     }
     if($this->qt_vlpeso == null ){ 
       $this->qt_vlpeso = "0";
     }
     if($this->qt_vlaltura == null ){ 
       $this->qt_vlaltura = "0";
     }
     if($this->qt_stpossuifilhos == null ){ 
       $this->qt_stpossuifilhos = "f";
     }
     if($this->qt_stutilizabebida == null ){ 
       $this->qt_stutilizabebida = "f";
     }
     if($this->qt_stsofreuqueda == null ){ 
       $this->qt_stsofreuqueda = "f";
     }
     if($this->qt_stconseguelocomover == null ){ 
       $this->qt_stconseguelocomover = "f";
     }
     if($this->qt_stdoencagravidez == null ){ 
       $this->qt_stdoencagravidez = "f";
     }
     if($this->qt_stcolesterolalto == null ){ 
       $this->qt_stcolesterolalto = "f";
     }
     if($this->qt_stdoencacoracaofamilia == null ){ 
       $this->qt_stdoencacoracaofamilia = "f";
     }
     if($this->qt_tpdiabetes == null ){ 
       $this->qt_tpdiabetes = "0";
     }
     if($this->qt_sttratamentotuberculose == null ){ 
       $this->qt_sttratamentotuberculose = "f";
     }
     if($this->qt_stterminotratamento == null ){ 
       $this->qt_stterminotratamento = "f";
     }
     if($this->qt_sttratamentohanseniase == null ){ 
       $this->qt_sttratamentohanseniase = "f";
     }
     if($this->qt_stsintomashanseniase == null ){ 
       $this->qt_stsintomashanseniase = "f";
     }
     if($this->qt_dataenviosigaf == null ){ 
       $this->qt_dataenviosigaf = "null";
     }
      if($qt_codigo == "" || $qt_codigo == null ){
       $result = db_query("select nextval('qtriagem_qt_codigo_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: qtriagem_qt_codigo_seq do campo: qt_codigo"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->qt_codigo = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from qtriagem_qt_codigo_seq");
       if(($result != false) && (pg_result($result,0,0) < $qt_codigo)){
         $this->erro_sql = " Campo qt_codigo maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->qt_codigo = $qt_codigo; 
       }
     }
     if(($this->qt_codigo == null) || ($this->qt_codigo == "") ){ 
       $this->erro_sql = " Campo qt_codigo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into qtriagem(
                                       qt_codigo 
                                      ,qt_paciente 
                                      ,qt_stgravida 
                                      ,qt_sthipertenso 
                                      ,qt_stdiabetico 
                                      ,qt_sttuberculose 
                                      ,qt_sthanseniase 
                                      ,qt_stfuma 
                                      ,qt_tpinstrucaoresponsavel 
                                      ,qt_vlpeso 
                                      ,qt_vlaltura 
                                      ,qt_stpossuifilhos 
                                      ,qt_stutilizabebida 
                                      ,qt_stsofreuqueda 
                                      ,qt_stconseguelocomover 
                                      ,qt_stdoencagravidez 
                                      ,qt_stcolesterolalto 
                                      ,qt_stdoencacoracaofamilia 
                                      ,qt_tpdiabetes 
                                      ,qt_sttratamentotuberculose 
                                      ,qt_stterminotratamento 
                                      ,qt_sttratamentohanseniase 
                                      ,qt_stsintomashanseniase 
                                      ,qt_dataenviosigaf 
                       )
                values (
                                $this->qt_codigo 
                               ,$this->qt_paciente 
                               ,'$this->qt_stgravida' 
                               ,'$this->qt_sthipertenso' 
                               ,'$this->qt_stdiabetico' 
                               ,'$this->qt_sttuberculose' 
                               ,'$this->qt_sthanseniase' 
                               ,'$this->qt_stfuma' 
                               ,$this->qt_tpinstrucaoresponsavel 
                               ,$this->qt_vlpeso 
                               ,$this->qt_vlaltura 
                               ,'$this->qt_stpossuifilhos' 
                               ,'$this->qt_stutilizabebida' 
                               ,'$this->qt_stsofreuqueda' 
                               ,'$this->qt_stconseguelocomover' 
                               ,'$this->qt_stdoencagravidez' 
                               ,'$this->qt_stcolesterolalto' 
                               ,'$this->qt_stdoencacoracaofamilia' 
                               ,$this->qt_tpdiabetes 
                               ,'$this->qt_sttratamentotuberculose' 
                               ,'$this->qt_stterminotratamento' 
                               ,'$this->qt_sttratamentohanseniase' 
                               ,'$this->qt_stsintomashanseniase' 
                               ,".($this->qt_dataenviosigaf == "null" || $this->qt_dataenviosigaf == ""?"null":"'".$this->qt_dataenviosigaf."'")." 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Questionário de Triagem ($this->qt_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Questionário de Triagem já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Questionário de Triagem ($this->qt_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->qt_codigo;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->qt_codigo  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->qt_codigo','I')");
         $resac = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,0,'qt_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009247,'','".AddSlashes(pg_result($resaco,0,'qt_paciente'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009248,'','".AddSlashes(pg_result($resaco,0,'qt_stgravida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009250,'','".AddSlashes(pg_result($resaco,0,'qt_sthipertenso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,0,'qt_stdiabetico'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009253,'','".AddSlashes(pg_result($resaco,0,'qt_sttuberculose'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009254,'','".AddSlashes(pg_result($resaco,0,'qt_sthanseniase'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009255,'','".AddSlashes(pg_result($resaco,0,'qt_stfuma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009256,'','".AddSlashes(pg_result($resaco,0,'qt_tpinstrucaoresponsavel'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009257,'','".AddSlashes(pg_result($resaco,0,'qt_vlpeso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009258,'','".AddSlashes(pg_result($resaco,0,'qt_vlaltura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009259,'','".AddSlashes(pg_result($resaco,0,'qt_stpossuifilhos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009264,'','".AddSlashes(pg_result($resaco,0,'qt_stutilizabebida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009265,'','".AddSlashes(pg_result($resaco,0,'qt_stsofreuqueda'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009266,'','".AddSlashes(pg_result($resaco,0,'qt_stconseguelocomover'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009267,'','".AddSlashes(pg_result($resaco,0,'qt_stdoencagravidez'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009268,'','".AddSlashes(pg_result($resaco,0,'qt_stcolesterolalto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009269,'','".AddSlashes(pg_result($resaco,0,'qt_stdoencacoracaofamilia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009270,'','".AddSlashes(pg_result($resaco,0,'qt_tpdiabetes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009271,'','".AddSlashes(pg_result($resaco,0,'qt_sttratamentotuberculose'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009272,'','".AddSlashes(pg_result($resaco,0,'qt_stterminotratamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009273,'','".AddSlashes(pg_result($resaco,0,'qt_sttratamentohanseniase'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009274,'','".AddSlashes(pg_result($resaco,0,'qt_stsintomashanseniase'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009275,'','".AddSlashes(pg_result($resaco,0,'qt_dataenviosigaf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($qt_codigo=null) { 
      $this->atualizacampos();
     $sql = " update qtriagem set ";
     $virgula = "";
     if(trim($this->qt_codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_codigo"])){ 
       $sql  .= $virgula." qt_codigo = $this->qt_codigo ";
       $virgula = ",";
       if(trim($this->qt_codigo) == null ){ 
         $this->erro_sql = " Campo Código não informado.";
         $this->erro_campo = "qt_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->qt_paciente)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_paciente"])){ 
       $sql  .= $virgula." qt_paciente = $this->qt_paciente ";
       $virgula = ",";
       if(trim($this->qt_paciente) == null ){ 
         $this->erro_sql = " Campo Paciente não informado.";
         $this->erro_campo = "qt_paciente";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->qt_stgravida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_stgravida"])){ 
       $sql  .= $virgula." qt_stgravida = '$this->qt_stgravida' ";
       $virgula = ",";
       if(trim($this->qt_stgravida) == null ){ 
         $this->erro_sql = " Campo Está grávida não informado.";
         $this->erro_campo = "qt_stgravida";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->qt_sthipertenso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_sthipertenso"])){ 
       $sql  .= $virgula." qt_sthipertenso = '$this->qt_sthipertenso' ";
       $virgula = ",";
       if(trim($this->qt_sthipertenso) == null ){ 
         $this->erro_sql = " Campo É hipertenso não informado.";
         $this->erro_campo = "qt_sthipertenso";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->qt_stdiabetico)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_stdiabetico"])){ 
       $sql  .= $virgula." qt_stdiabetico = '$this->qt_stdiabetico' ";
       $virgula = ",";
       if(trim($this->qt_stdiabetico) == null ){ 
         $this->erro_sql = " Campo É diabético? não informado.";
         $this->erro_campo = "qt_stdiabetico";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->qt_sttuberculose)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_sttuberculose"])){ 
       $sql  .= $virgula." qt_sttuberculose = '$this->qt_sttuberculose' ";
       $virgula = ",";
       if(trim($this->qt_sttuberculose) == null ){ 
         $this->erro_sql = " Campo Possui tuberculose não informado.";
         $this->erro_campo = "qt_sttuberculose";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->qt_sthanseniase)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_sthanseniase"])){ 
       $sql  .= $virgula." qt_sthanseniase = '$this->qt_sthanseniase' ";
       $virgula = ",";
       if(trim($this->qt_sthanseniase) == null ){ 
         $this->erro_sql = " Campo Possui hanseníase? não informado.";
         $this->erro_campo = "qt_sthanseniase";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->qt_stfuma)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_stfuma"])){ 
       $sql  .= $virgula." qt_stfuma = '$this->qt_stfuma' ";
       $virgula = ",";
       if(trim($this->qt_stfuma) == null ){ 
         $this->erro_sql = " Campo Fuma ou reside com fumante não informado.";
         $this->erro_campo = "qt_stfuma";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->qt_tpinstrucaoresponsavel)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_tpinstrucaoresponsavel"])){ 
       $sql  .= $virgula." qt_tpinstrucaoresponsavel = $this->qt_tpinstrucaoresponsavel ";
       $virgula = ",";
       if(trim($this->qt_tpinstrucaoresponsavel) == null ){ 
         $this->erro_sql = " Campo Qual seu grau de instrução não informado.";
         $this->erro_campo = "qt_tpinstrucaoresponsavel";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->qt_vlpeso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_vlpeso"])){ 
        if(trim($this->qt_vlpeso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["qt_vlpeso"])){ 
           $this->qt_vlpeso = "0" ; 
        } 
       $sql  .= $virgula." qt_vlpeso = $this->qt_vlpeso ";
       $virgula = ",";
     }
     if(trim($this->qt_vlaltura)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_vlaltura"])){ 
        if(trim($this->qt_vlaltura)=="" && isset($GLOBALS["HTTP_POST_VARS"]["qt_vlaltura"])){ 
           $this->qt_vlaltura = "0" ; 
        } 
       $sql  .= $virgula." qt_vlaltura = $this->qt_vlaltura ";
       $virgula = ",";
     }
     if(trim($this->qt_stpossuifilhos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_stpossuifilhos"])){ 
       $sql  .= $virgula." qt_stpossuifilhos = '$this->qt_stpossuifilhos' ";
       $virgula = ",";
     }
     if(trim($this->qt_stutilizabebida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_stutilizabebida"])){ 
       $sql  .= $virgula." qt_stutilizabebida = '$this->qt_stutilizabebida' ";
       $virgula = ",";
     }
     if(trim($this->qt_stsofreuqueda)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_stsofreuqueda"])){ 
       $sql  .= $virgula." qt_stsofreuqueda = '$this->qt_stsofreuqueda' ";
       $virgula = ",";
     }
     if(trim($this->qt_stconseguelocomover)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_stconseguelocomover"])){ 
       $sql  .= $virgula." qt_stconseguelocomover = '$this->qt_stconseguelocomover' ";
       $virgula = ",";
     }
     if(trim($this->qt_stdoencagravidez)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_stdoencagravidez"])){ 
       $sql  .= $virgula." qt_stdoencagravidez = '$this->qt_stdoencagravidez' ";
       $virgula = ",";
     }
     if(trim($this->qt_stcolesterolalto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_stcolesterolalto"])){ 
       $sql  .= $virgula." qt_stcolesterolalto = '$this->qt_stcolesterolalto' ";
       $virgula = ",";
     }
     if(trim($this->qt_stdoencacoracaofamilia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_stdoencacoracaofamilia"])){ 
       $sql  .= $virgula." qt_stdoencacoracaofamilia = '$this->qt_stdoencacoracaofamilia' ";
       $virgula = ",";
     }
     if(trim($this->qt_tpdiabetes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_tpdiabetes"])){ 
        if(trim($this->qt_tpdiabetes)=="" && isset($GLOBALS["HTTP_POST_VARS"]["qt_tpdiabetes"])){ 
           $this->qt_tpdiabetes = "0" ; 
        } 
       $sql  .= $virgula." qt_tpdiabetes = $this->qt_tpdiabetes ";
       $virgula = ",";
     }
     if(trim($this->qt_sttratamentotuberculose)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_sttratamentotuberculose"])){ 
       $sql  .= $virgula." qt_sttratamentotuberculose = '$this->qt_sttratamentotuberculose' ";
       $virgula = ",";
     }
     if(trim($this->qt_stterminotratamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_stterminotratamento"])){ 
       $sql  .= $virgula." qt_stterminotratamento = '$this->qt_stterminotratamento' ";
       $virgula = ",";
     }
     if(trim($this->qt_sttratamentohanseniase)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_sttratamentohanseniase"])){ 
       $sql  .= $virgula." qt_sttratamentohanseniase = '$this->qt_sttratamentohanseniase' ";
       $virgula = ",";
     }
     if(trim($this->qt_stsintomashanseniase)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_stsintomashanseniase"])){ 
       $sql  .= $virgula." qt_stsintomashanseniase = '$this->qt_stsintomashanseniase' ";
       $virgula = ",";
     }
     if(trim($this->qt_dataenviosigaf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["qt_dataenviosigaf_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["qt_dataenviosigaf_dia"] !="") ){ 
       $sql  .= $virgula." qt_dataenviosigaf = '$this->qt_dataenviosigaf' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["qt_dataenviosigaf_dia"])){ 
         $sql  .= $virgula." qt_dataenviosigaf = null ";
         $virgula = ",";
       }
     }
     $sql .= " where ";
     if($qt_codigo!=null){
       $sql .= " qt_codigo = $this->qt_codigo";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->qt_codigo));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->qt_codigo','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_codigo"]) || $this->qt_codigo != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009244,'".AddSlashes(pg_result($resaco,$conresaco,'qt_codigo'))."','$this->qt_codigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_paciente"]) || $this->qt_paciente != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009247,'".AddSlashes(pg_result($resaco,$conresaco,'qt_paciente'))."','$this->qt_paciente',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_stgravida"]) || $this->qt_stgravida != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009248,'".AddSlashes(pg_result($resaco,$conresaco,'qt_stgravida'))."','$this->qt_stgravida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_sthipertenso"]) || $this->qt_sthipertenso != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009250,'".AddSlashes(pg_result($resaco,$conresaco,'qt_sthipertenso'))."','$this->qt_sthipertenso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_stdiabetico"]) || $this->qt_stdiabetico != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'qt_stdiabetico'))."','$this->qt_stdiabetico',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_sttuberculose"]) || $this->qt_sttuberculose != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009253,'".AddSlashes(pg_result($resaco,$conresaco,'qt_sttuberculose'))."','$this->qt_sttuberculose',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_sthanseniase"]) || $this->qt_sthanseniase != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009254,'".AddSlashes(pg_result($resaco,$conresaco,'qt_sthanseniase'))."','$this->qt_sthanseniase',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_stfuma"]) || $this->qt_stfuma != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009255,'".AddSlashes(pg_result($resaco,$conresaco,'qt_stfuma'))."','$this->qt_stfuma',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_tpinstrucaoresponsavel"]) || $this->qt_tpinstrucaoresponsavel != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009256,'".AddSlashes(pg_result($resaco,$conresaco,'qt_tpinstrucaoresponsavel'))."','$this->qt_tpinstrucaoresponsavel',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_vlpeso"]) || $this->qt_vlpeso != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009257,'".AddSlashes(pg_result($resaco,$conresaco,'qt_vlpeso'))."','$this->qt_vlpeso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_vlaltura"]) || $this->qt_vlaltura != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009258,'".AddSlashes(pg_result($resaco,$conresaco,'qt_vlaltura'))."','$this->qt_vlaltura',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_stpossuifilhos"]) || $this->qt_stpossuifilhos != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009259,'".AddSlashes(pg_result($resaco,$conresaco,'qt_stpossuifilhos'))."','$this->qt_stpossuifilhos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_stutilizabebida"]) || $this->qt_stutilizabebida != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009264,'".AddSlashes(pg_result($resaco,$conresaco,'qt_stutilizabebida'))."','$this->qt_stutilizabebida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_stsofreuqueda"]) || $this->qt_stsofreuqueda != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009265,'".AddSlashes(pg_result($resaco,$conresaco,'qt_stsofreuqueda'))."','$this->qt_stsofreuqueda',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_stconseguelocomover"]) || $this->qt_stconseguelocomover != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009266,'".AddSlashes(pg_result($resaco,$conresaco,'qt_stconseguelocomover'))."','$this->qt_stconseguelocomover',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_stdoencagravidez"]) || $this->qt_stdoencagravidez != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009267,'".AddSlashes(pg_result($resaco,$conresaco,'qt_stdoencagravidez'))."','$this->qt_stdoencagravidez',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_stcolesterolalto"]) || $this->qt_stcolesterolalto != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009268,'".AddSlashes(pg_result($resaco,$conresaco,'qt_stcolesterolalto'))."','$this->qt_stcolesterolalto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_stdoencacoracaofamilia"]) || $this->qt_stdoencacoracaofamilia != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009269,'".AddSlashes(pg_result($resaco,$conresaco,'qt_stdoencacoracaofamilia'))."','$this->qt_stdoencacoracaofamilia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_tpdiabetes"]) || $this->qt_tpdiabetes != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009270,'".AddSlashes(pg_result($resaco,$conresaco,'qt_tpdiabetes'))."','$this->qt_tpdiabetes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_sttratamentotuberculose"]) || $this->qt_sttratamentotuberculose != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009271,'".AddSlashes(pg_result($resaco,$conresaco,'qt_sttratamentotuberculose'))."','$this->qt_sttratamentotuberculose',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_stterminotratamento"]) || $this->qt_stterminotratamento != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009272,'".AddSlashes(pg_result($resaco,$conresaco,'qt_stterminotratamento'))."','$this->qt_stterminotratamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_sttratamentohanseniase"]) || $this->qt_sttratamentohanseniase != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009273,'".AddSlashes(pg_result($resaco,$conresaco,'qt_sttratamentohanseniase'))."','$this->qt_sttratamentohanseniase',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_stsintomashanseniase"]) || $this->qt_stsintomashanseniase != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009274,'".AddSlashes(pg_result($resaco,$conresaco,'qt_stsintomashanseniase'))."','$this->qt_stsintomashanseniase',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["qt_dataenviosigaf"]) || $this->qt_dataenviosigaf != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009275,'".AddSlashes(pg_result($resaco,$conresaco,'qt_dataenviosigaf'))."','$this->qt_dataenviosigaf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Questionário de Triagem nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->qt_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Questionário de Triagem nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->qt_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->qt_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($qt_codigo=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($qt_codigo));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009244,'$qt_codigo','E')");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009247,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_paciente'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009248,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_stgravida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009250,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_sthipertenso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_stdiabetico'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009253,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_sttuberculose'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009254,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_sthanseniase'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009255,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_stfuma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009256,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_tpinstrucaoresponsavel'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009257,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_vlpeso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009258,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_vlaltura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009259,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_stpossuifilhos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009264,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_stutilizabebida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009265,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_stsofreuqueda'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009266,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_stconseguelocomover'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009267,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_stdoencagravidez'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009268,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_stcolesterolalto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009269,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_stdoencacoracaofamilia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009270,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_tpdiabetes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009271,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_sttratamentotuberculose'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009272,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_stterminotratamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009273,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_sttratamentohanseniase'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009274,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_stsintomashanseniase'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009275,'','".AddSlashes(pg_result($resaco,$iresaco,'qt_dataenviosigaf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from qtriagem
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($qt_codigo != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " qt_codigo = $qt_codigo ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Questionário de Triagem nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$qt_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Questionário de Triagem nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$qt_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$qt_codigo;
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
        $this->erro_sql   = "Record Vazio na Tabela:qtriagem";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $qt_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from qtriagem ";
     $sql2 = "";
     if($dbwhere==""){
       if($qt_codigo!=null ){
         $sql2 .= " where qtriagem.qt_codigo = $qt_codigo "; 
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
   function sql_query_file ( $qt_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from qtriagem ";
     $sql2 = "";
     if($dbwhere==""){
       if($qt_codigo!=null ){
         $sql2 .= " where qtriagem.qt_codigo = $qt_codigo "; 
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
