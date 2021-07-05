<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//MODULO: Compras
//CLASSE DA ENTIDADE historicoitem
class cl_historicoitem {
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
   var $pc96_sequencial = 0;
   var $pc96_codigomaterial = 0;
	 var $pc96_usuario = null;
	 var $pc96_dataalteracao = null;
	 var $pc96_dataservidor = null;
	 var $pc96_horaalteracao = null;
	 var $pc96_descricaoanterior = '';

   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 pc96_codigomaterial = int8 = Código do Material 
                 pc96_usuario = int8 = Código do Usuário
                 pc96_dataalteracao = date = Data da Alteração
                 pc96_dataservidor = data = Data do Servidor
                 pc96_horaalteracao = timestamp = Hora da Alteração
                 pc96_descricaoanterior = varchar(120) = Descrição Anterior

                 ";
   //funcao construtor da classe
   function cl_historicoitem() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("historicoitem");
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
       $this->pc96_codigomaterial = ($this->pc96_codigomaterial == ""?@$GLOBALS["HTTP_POST_VARS"]["pc96_codigomaterial"]:$this->pc96_codigomaterial);
       $this->pc96_usuario = ($this->pc96_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["pc96_usuario"]:$this->pc96_usuario);
       $this->pc96_dataalteracao = ($this->pc96_dataalteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["pc96_dataalteracao"]:$this->pc96_dataalteracao);
       $this->pc96_dataservidor = ($this->pc96_dataservidor == ""?@$GLOBALS["HTTP_POST_VARS"]["pc96_dataservidor"]:$this->pc96_dataservidor);
       $this->pc96_horaalteracao = ($this->pc96_horaalteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["pc96_horaalteracao"]:$this->pc96_horaalteracao);
       $this->pc96_descricaoanterior = ($this->pc96_descricaoanterior == ""?@$GLOBALS["HTTP_POST_VARS"]["pc96_descricaoanterior"]:$this->pc96_descricaoanterior);
     }else{
       $this->pc96_codigomaterial = ($this->pc96_codigomaterial == ""?@$GLOBALS["HTTP_POST_VARS"]["pc96_codigomaterial"]:$this->pc96_codigomaterial);
     }
   }
   // funcao para inclusao
   function incluir ($pc96_codigomaterial){
      $this->atualizacampos();
     if($this->pc96_usuario == null ){
       $this->erro_sql = " Campo Código do Usuário não Informado.";
       $this->erro_campo = "pc96_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->pc96_dataalteracao == null ){
      $this->erro_sql = " Campo Data Alteração não Informado.";
      $this->erro_campo = "pc96_dataalteracao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->pc96_dataservidor == null ){
      $this->erro_sql = " Campo Data Servidor não Informado.";
      $this->erro_campo = "pc96_dataservidor";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->pc96_horaalteracao == null ){
      $this->erro_sql = " Campo Hora Alteração não Informado.";
      $this->erro_campo = "pc96_horaalteracao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->pc96_descricaoanterior == null || !$this->pc96_descricaoanterior){
      $this->erro_sql = " Campo Descrição Anterior não Informado.";
      $this->erro_campo = "pc96_descricaoanterior";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
     if($pc96_sequencial == "" || $pc96_sequencial == null ){
       $result = db_query("select nextval('historicoitem_pc96_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: historicoitem_pc96_sequencial_seq do campo: pc96_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->pc96_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from historicoitem_pc96_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $pc96_sequencial)){
         $this->erro_sql = " Campo pc96_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->pc96_sequencial = $pc96_sequencial;
       }
     }
     if(($this->pc96_codigomaterial == null) || ($this->pc96_codigomaterial == "") ){
       $this->erro_sql = " Campo pc96_codigomaterial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into historicoitem(
                                       pc96_codigomaterial
                                      ,pc96_usuario
                                      ,pc96_dataalteracao
                                      ,pc96_dataservidor
                                      ,pc96_horaalteracao
                                      ,pc96_descricaoanterior
                       )
                values (
                                 $this->pc96_codigomaterial
                                ,$this->pc96_usuario
                                ,'$this->pc96_dataalteracao'
                                ,'$this->pc96_dataservidor'
                                ,to_timestamp($this->pc96_horaalteracao)
                                ,'$this->pc96_descricaoanterior'
                               
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Cadastro de Histórico do bem ($this->pc96_codigomaterial) não Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Cadastro de Materiais já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Cadastro de Histórico do bem ($this->pc96_codigomaterial) não Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusão efetuada com Sucesso\\n";
     $this->erro_sql .= "Valores : ".$this->pc96_codigomaterial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
    //  $resaco = $this->sql_record($this->sql_query_file($this->pc96_codigomaterial));
    //  if(($resaco!=false)||($this->numrows!=0)){
    //    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //    $acount = pg_result($resac,0,0);
    //    $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
    //    $resac = db_query("insert into db_acountkey values($acount,5491,'$this->pc01_codmater','I')");
    //    $resac = db_query("insert into db_acount values($acount,855,5491,'','".AddSlashes(pg_result($resaco,0,'pc01_codmater'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,5492,'','".AddSlashes(pg_result($resaco,0,'pc01_descrmater'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,5493,'','".AddSlashes(pg_result($resaco,0,'pc01_complmater'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,5494,'','".AddSlashes(pg_result($resaco,0,'pc01_codsubgrupo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,6602,'','".AddSlashes(pg_result($resaco,0,'pc01_ativo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,6761,'','".AddSlashes(pg_result($resaco,0,'pc01_conversao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,7425,'','".AddSlashes(pg_result($resaco,0,'pc01_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,8068,'','".AddSlashes(pg_result($resaco,0,'pc01_libaut'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,10556,'','".AddSlashes(pg_result($resaco,0,'pc01_servico'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,11473,'','".AddSlashes(pg_result($resaco,0,'pc01_veiculo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,11708,'','".AddSlashes(pg_result($resaco,0,'pc01_fraciona'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,11727,'','".AddSlashes(pg_result($resaco,0,'pc01_validademinima'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,11728,'','".AddSlashes(pg_result($resaco,0,'pc01_obrigatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    $resac = db_query("insert into db_acount values($acount,855,17390,'','".AddSlashes(pg_result($resaco,0,'pc01_liberaresumo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //  }
     return true;
   }
   // funcao para alteracao
   function alterar ($pc96_codigomaterial = null) {
      $this->atualizacampos();
     $sql = " update historicoitem set ";
     $virgula = "";
     if(trim($this->pc96_codigomaterial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc96_codigomaterial"])){
       $sql  .= $virgula." pc96_codigomaterial = $this->pc96_codigomaterial ";
       $virgula = ",";
       if(trim($this->pc96_codigomaterial) == null ){
         $this->erro_sql = " Campo Código do Material não Informado.";
         $this->erro_campo = "pc96_codigomaterial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->pc96_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc96_usuario"])){
       $sql  .= $virgula." pc96_usuario = '$this->pc96_usuario' ";
       $virgula = ",";
       if(trim($this->pc96_usuario) == null ){
         $this->erro_sql = " Campo Usuário não Informado.";
         $this->erro_campo = "pc96_usuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->pc96_dataalteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc96_dataalteracao"])){
      $sql  .= $virgula." pc96_dataalteracao = '$this->pc96_dataalteracao' ";
      $virgula = ",";
        if(trim($this->pc96_dataalteracao) == null ){
          $this->erro_sql = " Campo Data Alteração não Informado.";
          $this->erro_campo = "pc96_dataalteracao";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
      if(trim($this->pc96_dataservidor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc96_dataservidor"])){
        $sql  .= $virgula." pc96_dataservidor = '$this->pc96_dataservidor' ";
        $virgula = ",";
          if(trim($this->pc96_dataservidor) == null ){
            $this->erro_sql = " Campo Data Servidor não Informado.";
            $this->erro_campo = "pc96_dataservidor";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
          }
      }

      if(trim($this->pc96_horaalteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc96_horaalteracao"])){
        $sql  .= $virgula." pc96_horaalteracao = '$this->pc96_horaalteracao' ";
        $virgula = ",";
        if(trim($this->pc96_horaalteracao) == null ){
          $this->erro_sql = " Campo Hora Alteração não Informado.";
          $this->erro_campo = "pc96_horaalteracao";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }

     if(trim($this->pc96_descricaoanterior)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc96_descricaoanterior"])){
       $sql  .= $virgula." pc96_descricaoanterior = '$this->pc96_descricaoanterior' ";
       $virgula = ",";
     }

     $sql .= " where ";
     if($pc96_codigomaterial != null){
       $sql .= " pc96_codigomaterial = $this->pc96_codigomaterial ";
     }
    //  $resaco = $this->sql_record($this->sql_query_file($this->pc96_codigomaterial));
    //  if($this->numrows>0){
      //  for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
      //    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      //    $acount = pg_result($resac,0,0);
      //    $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
      //    $resac = db_query("insert into db_acountkey values($acount,5491,'$this->pc01_codmater','A')");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_codmater"]) || $this->pc01_codmater != "")
      //      $resac = db_query("insert into db_acount values($acount,855,5491,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_codmater'))."','$this->pc01_codmater',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_descrmater"]) || $this->pc01_descrmater != "")
      //      $resac = db_query("insert into db_acount values($acount,855,5492,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_descrmater'))."','$this->pc01_descrmater',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_complmater"]) || $this->pc01_complmater != "")
      //      $resac = db_query("insert into db_acount values($acount,855,5493,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_complmater'))."','$this->pc01_complmater',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_codsubgrupo"]) || $this->pc01_codsubgrupo != "")
      //      $resac = db_query("insert into db_acount values($acount,855,5494,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_codsubgrupo'))."','$this->pc01_codsubgrupo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_ativo"]) || $this->pc01_ativo != "")
      //      $resac = db_query("insert into db_acount values($acount,855,6602,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_ativo'))."','$this->pc01_ativo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_conversao"]) || $this->pc01_conversao != "")
      //      $resac = db_query("insert into db_acount values($acount,855,6761,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_conversao'))."','$this->pc01_conversao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_id_usuario"]) || $this->pc01_id_usuario != "")
      //      $resac = db_query("insert into db_acount values($acount,855,7425,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_id_usuario'))."','$this->pc01_id_usuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_libaut"]) || $this->pc01_libaut != "")
      //      $resac = db_query("insert into db_acount values($acount,855,8068,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_libaut'))."','$this->pc01_libaut',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_servico"]) || $this->pc01_servico != "")
      //      $resac = db_query("insert into db_acount values($acount,855,10556,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_servico'))."','$this->pc01_servico',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_veiculo"]) || $this->pc01_veiculo != "")
      //      $resac = db_query("insert into db_acount values($acount,855,11473,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_veiculo'))."','$this->pc01_veiculo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_fraciona"]) || $this->pc01_fraciona != "")
      //      $resac = db_query("insert into db_acount values($acount,855,11708,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_fraciona'))."','$this->pc01_fraciona',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_validademinima"]) || $this->pc01_validademinima != "")
      //      $resac = db_query("insert into db_acount values($acount,855,11727,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_validademinima'))."','$this->pc01_validademinima',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_obrigatorio"]) || $this->pc01_obrigatorio != "")
      //      $resac = db_query("insert into db_acount values($acount,855,11728,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_obrigatorio'))."','$this->pc01_obrigatorio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //    if(isset($GLOBALS["HTTP_POST_VARS"]["pc01_liberaresumo"]) || $this->pc01_liberaresumo != "")
      //      $resac = db_query("insert into db_acount values($acount,855,17390,'".AddSlashes(pg_result($resaco,$conresaco,'pc01_liberaresumo'))."','$this->pc01_liberaresumo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      //  }
    //  }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro de Histórico do Item não Alterado. Alteração Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc96_codigomaterial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro de Histórico do Item não foi Alterado. Alteração Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc96_codigomaterial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->pc96_codigomaterial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($pc96_codigomaterial = null, $dbwhere = null) {
    //  if($dbwhere == null || $dbwhere == ""){
    //    $resaco = $this->sql_record($this->sql_query_file($pc01_codmater));
    //  }else{
    //    $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
    //  }
    //  if(($resaco!=false)||($this->numrows!=0)){
    //    for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
    //      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //      $acount = pg_result($resac,0,0);
    //      $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
    //      $resac = db_query("insert into db_acountkey values($acount,5491,'$pc01_codmater','E')");
    //      $resac = db_query("insert into db_acount values($acount,855,5491,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_codmater'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,5492,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_descrmater'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,5493,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_complmater'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,5494,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_codsubgrupo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,6602,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_ativo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,6761,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_conversao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,7425,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,8068,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_libaut'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,10556,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_servico'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,11473,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_veiculo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,11708,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_fraciona'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,11727,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_validademinima'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,11728,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_obrigatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,855,17390,'','".AddSlashes(pg_result($resaco,$iresaco,'pc01_liberaresumo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    }
    //  }
     $sql = " delete from historicoitem
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($pc96_codigomaterial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " pc96_codigomaterial = $pc96_codigomaterial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro do Histórico do Item de Materiais nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$pc96_codigomaterial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro do Histórico do Item não Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$pc96_codigomaterial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$pc96_codigomaterial;
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
        $this->erro_sql   = "Record Vazio na Tabela:historicoitem";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   function sql_query_file ( $pc96_codigomaterial = null, $campos="*", $ordem=null, $dbwhere=""){
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
     $sql .= " from historicoitem ";
     $sql2 = "";
     if($dbwhere == ""){
       if($pc96_codigomaterial != null ){
         $sql2 .= " where historicoitem.pc96_codigomaterial = $pc96_codigomaterial ";
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