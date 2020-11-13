<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

//MODULO: compras
//CLASSE DA ENTIDADE pcforne
class cl_pcforne {
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
 var $pc60_numcgm = 0;
 var $pc60_dtlanc_dia = null;
 var $pc60_dtlanc_mes = null;
 var $pc60_dtlanc_ano = null;
 var $pc60_dtlanc = null;
 var $pc60_obs = null;
 var $pc60_bloqueado = 'f';
 var $pc60_hora = null;
 var $pc60_usuario = 0;
 var $fisica_juridica = null;
 var $pc60_objsocial = null;
 var $pc60_orgaoreg = 0;
 var $pc60_dtreg_dia = null;
 var $pc60_dtreg_mes = null;
 var $pc60_dtreg_ano = null;
 var $pc60_dtreg = null;
 var $pc60_cnpjcpf = 0;
 var $pc60_dtreg_cvm_dia = null;
 var $pc60_dtreg_cvm_mes = null;
 var $pc60_dtreg_cvm_ano = null;
 var $pc60_dtreg_cvm = null;
   //OC5700
 var $pc60_databloqueio_ini_dia = null;
 var $pc60_databloqueio_ini_mes = null;
 var $pc60_databloqueio_ini_ano = null;
 var $pc60_databloqueio_ini = null;
   //
 var $pc60_databloqueio_fim_dia = null;
 var $pc60_databloqueio_fim_mes = null;
 var $pc60_databloqueio_fim_ano = null;
 var $pc60_databloqueio_fim = null;
   //
 var $pc60_motivobloqueio = null;
   //FIM OC5700
 var $pc60_numerocvm = null;
 var $pc60_inscriestadual = null;
 var $pc60_uf = null;
 var $pc60_numeroregistro = null;

   // cria propriedade com as variaveis do arquivo
 var $campos = "
 pc60_numcgm = int4 = Fornecedor
 pc60_dtlanc = date = Data Lançamento
 pc60_obs = text = Observação
 pc60_bloqueado = bool = Bloqueado
 pc60_hora = char(5) = Hora
 pc60_usuario = int4 = Cod. Usuário
 pc60_objsocial = varchar(100) = Objeto Social
 pc60_orgaoreg = int8 = Órgão Registro
 pc60_dtreg = date = Data do Registro
 pc60_cnpjcpf = int8 = CNPJ/CPF
 pc60_dtreg_cvm = date = Data do Registro
 pc60_numerocvm = varchar(20) = Número CVM
 pc60_inscriestadual = varchar(50) = Inscrição Estadual
 pc60_uf = varchar(2) = UF
 pc60_numeroregistro = varchar(20) = Número Registro
 pc60_databloqueio_ini = date = Período inicial de bloqueio
 pc60_databloqueio_fim = date = Período final de bloqueio
 pc60_motivobloqueio = Motivo do bloqueio
 ";
   //funcao construtor da classe
 function cl_pcforne() {
     //classes dos rotulos dos campos
   $this->rotulo = new rotulo("pcforne");
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
   $this->pc60_numcgm = ($this->pc60_numcgm == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_numcgm"]:$this->pc60_numcgm);

   if($this->pc60_dtlanc == ""){
     $this->pc60_dtlanc_dia = ($this->pc60_dtlanc_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_dtlanc_dia"]:$this->pc60_dtlanc_dia);
     $this->pc60_dtlanc_mes = ($this->pc60_dtlanc_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_dtlanc_mes"]:$this->pc60_dtlanc_mes);
     $this->pc60_dtlanc_ano = ($this->pc60_dtlanc_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_dtlanc_ano"]:$this->pc60_dtlanc_ano);
     if($this->pc60_dtlanc_dia != ""){
      $this->pc60_dtlanc = $this->pc60_dtlanc_ano."-".$this->pc60_dtlanc_mes."-".$this->pc60_dtlanc_dia;
    }
  }

  if($this->pc60_databloqueio_ini == ""){
   $this->pc60_databloqueio_ini_dia = ($this->pc60_databloqueio_ini_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_databloqueio_ini_dia"]:$this->pc60_databloqueio_ini_dia);
   $this->pc60_databloqueio_ini_mes = ($this->pc60_databloqueio_ini_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_databloqueio_ini_mes"]:$this->pc60_databloqueio_ini_mes);
   $this->pc60_databloqueio_ini_ano = ($this->pc60_databloqueio_ini_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_databloqueio_ini_ano"]:$this->pc60_databloqueio_ini_ano);
   if($this->pc60_databloqueio_ini_dia != ""){
    $this->pc60_databloqueio_ini = $this->pc60_databloqueio_ini_ano."-".$this->pc60_databloqueio_ini_mes."-".$this->pc60_databloqueio_ini_dia;
  }
}

if($this->pc60_databloqueio_fim == ""){
 $this->pc60_databloqueio_fim_dia = ($this->pc60_databloqueio_fim_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_databloqueio_fim_dia"]:$this->pc60_databloqueio_fim_dia);
 $this->pc60_databloqueio_fim_mes = ($this->pc60_databloqueio_fim_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_databloqueio_fim_mes"]:$this->pc60_databloqueio_fim_mes);
 $this->pc60_databloqueio_fim_ano = ($this->pc60_databloqueio_fim_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_databloqueio_fim_ano"]:$this->pc60_databloqueio_fim_ano);
 if($this->pc60_databloqueio_fim_dia != ""){
  $this->pc60_databloqueio_fim = $this->pc60_databloqueio_fim_ano."-".$this->pc60_databloqueio_fim_mes."-".$this->pc60_databloqueio_fim_dia;
}
}

$this->pc60_motivobloqueio = ($this->pc60_motivobloqueio == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_motivobloqueio"]:$this->pc60_motivobloqueio);
$this->pc60_obs = ($this->pc60_obs == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_obs"]:$this->pc60_obs);
$this->pc60_bloqueado = ($this->pc60_bloqueado == "f"?@$GLOBALS["HTTP_POST_VARS"]["pc60_bloqueado"]:$this->pc60_bloqueado);
$this->pc60_hora = ($this->pc60_hora == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_hora"]:$this->pc60_hora);
$this->pc60_usuario = ($this->pc60_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_usuario"]:$this->pc60_usuario);
$this->pc60_objsocial = ($this->pc60_objsocial == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_objsocial"]:$this->pc60_objsocial);
$this->pc60_orgaoreg = ($this->pc60_orgaoreg == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_orgaoreg"]:$this->pc60_orgaoreg);
if($this->pc60_dtreg == ""){
  $this->pc60_dtreg_dia = ($this->pc60_dtreg_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_dtreg_dia"]:$this->pc60_dtreg_dia);
  $this->pc60_dtreg_mes = ($this->pc60_dtreg_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_dtreg_mes"]:$this->pc60_dtreg_mes);
  $this->pc60_dtreg_ano = ($this->pc60_dtreg_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_dtreg_ano"]:$this->pc60_dtreg_ano);
  if($this->pc60_dtreg_dia != ""){
   $this->pc60_dtreg = $this->pc60_dtreg_ano."-".$this->pc60_dtreg_mes."-".$this->pc60_dtreg_dia;
 }
}
$this->pc60_cnpjcpf = ($this->pc60_cnpjcpf == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_cnpjcpf"]:$this->pc60_cnpjcpf);
if($this->pc60_dtreg_cvm == ""){
  $this->pc60_dtreg_cvm_dia = ($this->pc60_dtreg_cvm_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_dtreg_cvm_dia"]:$this->pc60_dtreg_cvm_dia);
  $this->pc60_dtreg_cvm_mes = ($this->pc60_dtreg_cvm_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_dtreg_cvm_mes"]:$this->pc60_dtreg_cvm_mes);
  $this->pc60_dtreg_cvm_ano = ($this->pc60_dtreg_cvm_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_dtreg_cvm_ano"]:$this->pc60_dtreg_cvm_ano);
  if($this->pc60_dtreg_cvm_dia != ""){
   $this->pc60_dtreg_cvm = $this->pc60_dtreg_cvm_ano."-".$this->pc60_dtreg_cvm_mes."-".$this->pc60_dtreg_cvm_dia;
 }
}
$this->pc60_numerocvm = ($this->pc60_numerocvm == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_numerocvm"]:$this->pc60_numerocvm);
$this->pc60_inscriestadual = ($this->pc60_inscriestadual == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_inscriestadual"]:$this->pc60_inscriestadual);
$this->pc60_uf = ($this->pc60_uf == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_uf"]:$this->pc60_uf);
$this->pc60_numeroregistro = ($this->pc60_numeroregistro == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_numeroregistro"]:$this->pc60_numeroregistro);
}else{
 $this->pc60_numcgm = ($this->pc60_numcgm == ""?@$GLOBALS["HTTP_POST_VARS"]["pc60_numcgm"]:$this->pc60_numcgm);
}
}
   // funcao para inclusao
function incluir ($pc60_numcgm){
  $this->atualizacampos();
  $this->verifica_fisica_juridica($pc60_numcgm);
  if($this->pc60_dtlanc == null ){
   $this->erro_sql = " Campo Data Lançamento nao Informado.";
   $this->erro_campo = "pc60_dtlanc_dia";
   $this->erro_banco = "";
   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
   $this->erro_status = "0";
   return false;
 }
 if($this->pc60_bloqueado == null ){
   $this->erro_sql = " Campo Bloqueado nao Informado.";
   $this->erro_campo = "pc60_bloqueado";
   $this->erro_banco = "";
   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
   $this->erro_status = "0";
   return false;
 }
 if($this->pc60_hora == null ){
   $this->erro_sql = " Campo Hora nao Informado.";
   $this->erro_campo = "pc60_hora";
   $this->erro_banco = "";
   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
   $this->erro_status = "0";
   return false;
 }
 if($this->pc60_usuario == null ){
   $this->erro_sql = " Campo Cod. Usuário nao Informado.";
   $this->erro_campo = "pc60_usuario";
   $this->erro_banco = "";
   $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
   $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
   $this->erro_status = "0";
   return false;
 }
 if($this->pc60_obs == null && $this->fisica_juridica == 'j'){
  $this->erro_sql = " Campo Objeto Social nao Informado.";
  $this->erro_campo = "pc60_obs";
  $this->erro_banco = "";
  $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
  $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
  $this->erro_status = "0";
  return false;
}elseif((strlen($this->pc60_obs) < 10 || strlen($this->pc60_obs) > 2000) && $this->fisica_juridica == 'j') {
 $this->erro_sql = " Campo Objeto Social deve ter mais que 10 caracteres e menos que 2000 caracteres ";
 $this->erro_campo = "pc60_obs";
 $this->erro_banco = "";
 $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
 $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
 $this->erro_status = "0";
 return false;
}
if($this->pc60_orgaoreg == null && $this->fisica_juridica == 'j'){
 $this->erro_sql = " Campo Órgão Registro nao Informado.";
 $this->erro_campo = "pc60_orgaoreg";
 $this->erro_banco = "";
 $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
 $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
 $this->erro_status = "0";
 return false;
}
if($this->pc60_dtreg == null && $this->fisica_juridica == 'j'){
  $this->erro_sql = " Campo Data do Registro nao Informado.";
  $this->erro_campo = "pc60_dtreg";
  $this->erro_banco = "";
  $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
  $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
  $this->erro_status = "0";
  return false;
}
if($this->pc60_cnpjcpf == null && $this->fisica_juridica == 'j'){
  $this->erro_sql = " Campo CNPJ/CPF nao Informado.";
  $this->erro_campo = "pc60_cnpjcpf";
  $this->erro_banco = "";
  $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
  $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
  $this->erro_status = "0";
  return false;
}

if($this->pc60_cnpjcpf == '00000000000000' || $this->pc60_cnpjcpf == '00000000000'){
    $this->erro_sql = "ERRO: Número do CPF/CNPJ está zerado. Corrija o CGM do fornecedor e tente novamente";
    $this->erro_campo = "pc60_cnpjcpf";
    $this->erro_banco = "";
    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
    $this->erro_status = "0";
    return false;
}
       /**
        * Validação da data de registro do CVM e o seu numero não são obrigatórias conforme solicitado pela ocorrencia 1236
        * @author: Rodrigo@contass
        */
      /*if($this->pc60_dtreg_cvm == null && $this->fisica_juridica == 'j'){
        $this->erro_sql = " Campo Data do Registro CVM nao Informado.";
        $this->erro_campo = "pc60_dtreg_cvm";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      if($this->pc60_numerocvm == null && $this->fisica_juridica == 'j'){
        $this->erro_sql = " Campo Número CVM nao Informado.";
        $this->erro_campo = "pc60_numerocvm";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }*/
      /*if($this->pc60_inscriestadual == null && $this->fisica_juridica == 'j'){
        $this->erro_sql = " Campo Inscrição Estadual nao Informado.";
        $this->erro_campo = "pc60_inscriestadual";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }*/
      if($this->pc60_uf == null && $this->fisica_juridica == 'j'){
        $this->erro_sql = " Campo UF nao Informado.";
        $this->erro_campo = "pc60_uf";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      if((trim($this->pc60_numeroregistro) == null || $this->pc60_numeroregistro == 0) && $this->fisica_juridica == 'j' && $this->pc60_orgaoreg != 4){
        $this->erro_sql = " Campo Numero Registro nao Informado.";
        $this->erro_campo = "pc60_numeroregistro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }

      $this->pc60_numcgm = $pc60_numcgm;
      if(($this->pc60_numcgm == null) || ($this->pc60_numcgm == "") ){
       $this->erro_sql = " Campo pc60_numcgm nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into pcforne(
     pc60_numcgm
     ,pc60_dtlanc
     ,pc60_obs
     ,pc60_bloqueado
     ,pc60_hora
     ,pc60_usuario
     ,pc60_objsocial
     ,pc60_orgaoreg
     ,pc60_dtreg
     ,pc60_cnpjcpf
     ,pc60_dtreg_cvm
     ,pc60_numerocvm
     ,pc60_inscriestadual
     ,pc60_uf
     ,pc60_numeroregistro
     ,pc60_databloqueio_ini
     ,pc60_databloqueio_fim
     ,pc60_motivobloqueio
     )
     values (
     $this->pc60_numcgm
     ,".($this->pc60_dtlanc == "null" || $this->pc60_dtlanc == ""?"null":"'".$this->pc60_dtlanc."'")."
     ,'$this->pc60_obs'
     ,'$this->pc60_bloqueado'
     ,'$this->pc60_hora'
     ,$this->pc60_usuario
     ,'$this->pc60_objsocial'
     ,$this->pc60_orgaoreg
     ,".($this->pc60_dtreg == "null" || $this->pc60_dtreg == ""?"null":"'".$this->pc60_dtreg."'")."
     ,$this->pc60_cnpjcpf
     ,".($this->pc60_dtreg_cvm == "null" || $this->pc60_dtreg_cvm == ""?"null":"'".$this->pc60_dtreg_cvm."'")."
     ,'$this->pc60_numerocvm'
     ,'$this->pc60_inscriestadual'
     ,'$this->pc60_uf'
     ,'$this->pc60_numeroregistro'
     ,".($this->pc60_databloqueio_ini == "null" || $this->pc60_databloqueio_ini == ""?"null":"'".$this->pc60_databloqueio_ini."'")."
     ,".($this->pc60_databloqueio_fim == "null" || $this->pc60_databloqueio_fim == ""?"null":"'".$this->pc60_databloqueio_fim."'")."
     ,'$this->pc60_motivobloqueio'
     )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Fornecedores ($this->pc60_numcgm) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Fornecedores já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Fornecedores ($this->pc60_numcgm) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_sql .= "Valores : ".$this->pc60_numcgm;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->pc60_numcgm));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,5986,'$this->pc60_numcgm','I')");
       $resac = db_query("insert into db_acount values($acount,959,5986,'','".AddSlashes(pg_result($resaco,0,'pc60_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,959,5987,'','".AddSlashes(pg_result($resaco,0,'pc60_dtlanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,959,5988,'','".AddSlashes(pg_result($resaco,0,'pc60_obs'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,959,5989,'','".AddSlashes(pg_result($resaco,0,'pc60_bloqueado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,959,7812,'','".AddSlashes(pg_result($resaco,0,'pc60_hora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,959,7811,'','".AddSlashes(pg_result($resaco,0,'pc60_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($pc60_numcgm=null) {
    $this->atualizacampos();
    $this->verifica_fisica_juridica($pc60_numcgm);
    $sql = " update pcforne set ";
    $virgula = "";
    if(trim($this->pc60_numcgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_numcgm"])){
     $sql  .= $virgula." pc60_numcgm = $this->pc60_numcgm ";
     $virgula = ",";
     if(trim($this->pc60_numcgm) == null ){
       $this->erro_sql = " Campo Fornecedor nao Informado.";
       $this->erro_campo = "pc60_numcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
   }
   if(trim($this->pc60_dtlanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_dtlanc_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["pc60_dtlanc_dia"] !="") ){
     $sql  .= $virgula." pc60_dtlanc = '$this->pc60_dtlanc' ";
     $virgula = ",";
     if(trim($this->pc60_dtlanc) == null ){
       $this->erro_sql = " Campo Data Lançamento nao Informado.";
       $this->erro_campo = "pc60_dtlanc_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
   }     else{
     if(isset($GLOBALS["HTTP_POST_VARS"]["pc60_dtlanc_dia"])){
       $sql  .= $virgula." pc60_dtlanc = null ";
       $virgula = ",";
       if(trim($this->pc60_dtlanc) == null ){
         $this->erro_sql = " Campo Data Lançamento nao Informado.";
         $this->erro_campo = "pc60_dtlanc_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
   }
   if(trim($this->pc60_obs)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_obs"])) {
     $sql .= $virgula . " pc60_obs = '$this->pc60_obs' ";
     $virgula = ",";
       if($this->fisica_juridica == 'j'){
           if (strlen($this->pc60_obs) < 10 || strlen($this->pc60_obs) > 2000) {
               $this->erro_sql = " Campo Objeto Social deve ter mais que 10 caracteres e menos que 2000 caracteres ";
               $this->erro_campo = "pc60_obs";
               $this->erro_banco = "";
               $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
               $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
               $this->erro_status = "0";
               return false;
           }
       }
   }
   if(trim($this->pc60_bloqueado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_bloqueado"])){
     $sql  .= $virgula." pc60_bloqueado = '$this->pc60_bloqueado' ";
     $virgula = ",";
     if(trim($this->pc60_bloqueado) == null ){
       $this->erro_sql = " Campo Bloqueado nao Informado.";
       $this->erro_campo = "pc60_bloqueado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
   }
   if(trim($this->pc60_hora)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_hora"])){
     $sql  .= $virgula." pc60_hora = '$this->pc60_hora' ";
     $virgula = ",";
     if(trim($this->pc60_hora) == null ){
       $this->erro_sql = " Campo Hora nao Informado.";
       $this->erro_campo = "pc60_hora";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
   }
   if(trim($this->pc60_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_usuario"])){
     $sql  .= $virgula." pc60_usuario = $this->pc60_usuario ";
     $virgula = ",";
     if(trim($this->pc60_usuario) == null ){
       $this->erro_sql = " Campo Cod. Usuário nao Informado.";
       $this->erro_campo = "pc60_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
   }
   if(trim($this->pc60_objsocial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_objsocial"])){
    $sql  .= $virgula." pc60_objsocial = '$this->pc60_objsocial' ";
    $virgula = ",";
    if(trim($this->pc60_objsocial) == null && $this->fisica_juridica == 'j'){
      $this->erro_sql = " Campo Objeto Social nao Informado.";
      $this->erro_campo = "pc60_objsocial";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
  }
  if(trim($this->pc60_orgaoreg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_orgaoreg"])){
    $sql  .= $virgula." pc60_orgaoreg = $this->pc60_orgaoreg ";
    $virgula = ",";
    if(trim($this->pc60_orgaoreg) == null && $this->fisica_juridica == 'j'){
      $this->erro_sql = " Campo Órgão Registro nao Informado.";
      $this->erro_campo = "pc60_orgaoreg";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
  }

  if(trim($this->pc60_dtreg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_dtreg_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["pc60_dtreg_dia"] !="") ){
    $sql  .= $virgula." pc60_dtreg = '$this->pc60_dtreg' ";
    $virgula = ",";
    if(trim($this->pc60_dtreg) == null && $this->fisica_juridica == 'j'){
      $this->erro_sql = " Campo Data do Registro nao Informado.";
      $this->erro_campo = "pc60_dtreg_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
  }     else{
    if(isset($GLOBALS["HTTP_POST_VARS"]["pc60_dtreg_dia"])){
      $sql  .= $virgula." pc60_dtreg = null ";
      $virgula = ",";
      if(trim($this->pc60_dtreg) == null && $this->fisica_juridica == 'j'){
        $this->erro_sql = " Campo Data do Registro nao Informado.";
        $this->erro_campo = "pc60_dtreg_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
  }

  if(trim($this->pc60_databloqueio_ini)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_databloqueio_ini"]) &&  ($GLOBALS["HTTP_POST_VARS"]["pc60_databloqueio_ini"] !="") ){
    $sql  .= $virgula." pc60_databloqueio_ini = '$this->pc60_databloqueio_ini' ";
    $virgula = ",";
  }
  if(trim($this->pc60_databloqueio_fim)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_databloqueio_fim"]) &&  ($GLOBALS["HTTP_POST_VARS"]["pc60_databloqueio_fim"] !="") ){
    $sql  .= $virgula." pc60_databloqueio_fim = '$this->pc60_databloqueio_fim' ";
    $virgula = ",";
  }

  if($this->pc60_databloqueio_ini == "" || $this->pc60_databloqueio_ini == null){
    $sql  .= $virgula." pc60_databloqueio_ini = null ";
    $virgula = ",";
  }
  if($this->pc60_databloqueio_fim == "" || $this->pc60_databloqueio_fim == null){
    $sql  .= $virgula." pc60_databloqueio_fim = null ";
    $virgula = ",";
  }

  if(trim($this->pc60_motivobloqueio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_motivobloqueio"]) &&  ($GLOBALS["HTTP_POST_VARS"]["pc60_motivobloqueio"] !="") ){
    $sql  .= $virgula." pc60_motivobloqueio = '$this->pc60_motivobloqueio' ";
    $virgula = ",";
  }

  if(trim($this->pc60_cnpjcpf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_cnpjcpf"])){
    $sql  .= $virgula." pc60_cnpjcpf = $this->pc60_cnpjcpf ";
    $virgula = ",";
    if(trim($this->pc60_cnpjcpf) == null && $this->fisica_juridica == 'j'){
      $this->erro_sql = " Campo CNPJ/CPF nao Informado.";
      $this->erro_campo = "pc60_cnpjcpf";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
  }

  if(trim($this->pc60_dtreg_cvm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_dtreg_cvm_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["pc60_dtreg_cvm_dia"] !="") ){
    $sql  .= $virgula." pc60_dtreg_cvm = '$this->pc60_dtreg_cvm' ";
    $virgula = ",";

  }else{
    $sql  .= $virgula." pc60_dtreg_cvm = null ";
    $virgula = ",";

  }

  if(trim($this->pc60_numerocvm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_numerocvm"])){
    $sql  .= $virgula." pc60_numerocvm = '$this->pc60_numerocvm' ";
    $virgula = ",";

  }else{
    $sql  .= $virgula." pc60_numerocvm = null ";
    $virgula = ",";
  }
  if(trim($this->pc60_inscriestadual)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_inscriestadual"])){
    $sql  .= $virgula." pc60_inscriestadual = '$this->pc60_inscriestadual' ";
    $virgula = ",";
        /*if(trim($this->pc60_inscriestadual) == null && $this->fisica_juridica == 'j'){
          $this->erro_sql = " Campo Inscrição Estadual nao Informado.";
          $this->erro_campo = "pc60_inscriestadual";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }*/
      }
      if(trim($this->pc60_uf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_uf"])){
        $sql  .= $virgula." pc60_uf = '$this->pc60_uf' ";
        $virgula = ",";
        if(trim($this->pc60_uf) == null && $this->fisica_juridica == 'j'){
          $this->erro_sql = " Campo UF nao Informado.";
          $this->erro_campo = "pc60_uf";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }

      if(trim($this->pc60_numeroregistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc60_numeroregistro"])){
        $sql  .= $virgula." pc60_numeroregistro = '$this->pc60_numeroregistro' ";
        $virgula = ",";
        if((trim($this->pc60_numeroregistro) == null || $this->pc60_numeroregistro == 0) && $this->fisica_juridica == 'j' && $this->pc60_orgaoreg != 4){
          $this->erro_sql = " Campo Número Registro nao Informado.";
          $this->erro_campo = "pc60_numeroregistro";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
      $sql .= " where ";
      if($pc60_numcgm!=null){
       $sql .= " pc60_numcgm = $this->pc60_numcgm";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->pc60_numcgm));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,5986,'$this->pc60_numcgm','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["pc60_numcgm"]))
           $resac = db_query("insert into db_acount values($acount,959,5986,'".AddSlashes(pg_result($resaco,$conresaco,'pc60_numcgm'))."','$this->pc60_numcgm',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["pc60_dtlanc"]))
           $resac = db_query("insert into db_acount values($acount,959,5987,'".AddSlashes(pg_result($resaco,$conresaco,'pc60_dtlanc'))."','$this->pc60_dtlanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["pc60_obs"]))
           $resac = db_query("insert into db_acount values($acount,959,5988,'".AddSlashes(pg_result($resaco,$conresaco,'pc60_obs'))."','$this->pc60_obs',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["pc60_bloqueado"]))
           $resac = db_query("insert into db_acount values($acount,959,5989,'".AddSlashes(pg_result($resaco,$conresaco,'pc60_bloqueado'))."','$this->pc60_bloqueado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["pc60_hora"]))
           $resac = db_query("insert into db_acount values($acount,959,7812,'".AddSlashes(pg_result($resaco,$conresaco,'pc60_hora'))."','$this->pc60_hora',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["pc60_usuario"]))
           $resac = db_query("insert into db_acount values($acount,959,7811,'".AddSlashes(pg_result($resaco,$conresaco,'pc60_usuario'))."','$this->pc60_usuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Fornecedores nao Alterado. Alteracao Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->pc60_numcgm;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Fornecedores nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc60_numcgm;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->pc60_numcgm;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($pc60_numcgm=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($pc60_numcgm));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,5986,'$pc60_numcgm','E')");
         $resac = db_query("insert into db_acount values($acount,959,5986,'','".AddSlashes(pg_result($resaco,$iresaco,'pc60_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,959,5987,'','".AddSlashes(pg_result($resaco,$iresaco,'pc60_dtlanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,959,5988,'','".AddSlashes(pg_result($resaco,$iresaco,'pc60_obs'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,959,5989,'','".AddSlashes(pg_result($resaco,$iresaco,'pc60_bloqueado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,959,7812,'','".AddSlashes(pg_result($resaco,$iresaco,'pc60_hora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,959,7811,'','".AddSlashes(pg_result($resaco,$iresaco,'pc60_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from pcforne
     where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
      if($pc60_numcgm != ""){
        if($sql2!=""){
          $sql2 .= " and ";
        }
        $sql2 .= " pc60_numcgm = $pc60_numcgm ";
      }
    }else{
     $sql2 = $dbwhere;
   }
   $result = db_query($sql.$sql2);
   if($result==false){
     $this->erro_banco = str_replace("\n","",@pg_last_error());
     $this->erro_sql   = "Fornecedores nao Excluído. Exclusão Abortada.\\n";
     $this->erro_sql .= "Valores : ".$pc60_numcgm;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "0";
     $this->numrows_excluir = 0;
     return false;
   }else{
     if(pg_affected_rows($result)==0){
       $this->erro_banco = "";
       $this->erro_sql = "Fornecedores nao Encontrado. Exclusão não Efetuada.\\n";
       $this->erro_sql .= "Valores : ".$pc60_numcgm;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "1";
       $this->numrows_excluir = 0;
       return true;
     }else{
       $this->erro_banco = "";
       $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
       $this->erro_sql .= "Valores : ".$pc60_numcgm;
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
    $this->erro_sql   = "Record Vazio na Tabela:pcforne";
    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
    $this->erro_status = "0";
    return false;
  }
  return $result;
}
function sql_query ( $pc60_numcgm=null,$campos="*",$ordem=null,$dbwhere="", $lRepresentanteLegal = false){
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
 $sql .= " from pcforne ";
 $sql .= "      inner join cgm  on  cgm.z01_numcgm = pcforne.pc60_numcgm";
 $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = pcforne.pc60_usuario";
 if ($lRepresentanteLegal) {
  $sql .= "      inner join pcfornereprlegal on pcfornereprlegal.pc81_cgmforn = cgm.z01_numcgm";
}
$sql2 = "";
if($dbwhere==""){
 if($pc60_numcgm!=null ){
   $sql2 .= " where pcforne.pc60_numcgm = $pc60_numcgm ";
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
function sql_query_conta ( $pc60_numcgm=null,$campos="*",$ordem=null,$dbwhere=""){
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
 $sql .= " from pcforne ";
 $sql .= "      inner join cgm on  cgm.z01_numcgm = pcforne.pc60_numcgm";
 $sql .= "      left join pcfornecon on  pc63_numcgm = pcforne.pc60_numcgm";
 $sql2 = "";
 if($dbwhere==""){
   if($pc60_numcgm!=null ){
     $sql2 .= " where pcforne.pc60_numcgm = $pc60_numcgm ";
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
function sql_query_file ( $pc60_numcgm=null,$campos="*",$ordem=null,$dbwhere=""){
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
 $sql .= " from pcforne ";
 $sql2 = "";
 if($dbwhere==""){
   if($pc60_numcgm!=null ){
     $sql2 .= " where pcforne.pc60_numcgm = $pc60_numcgm ";
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

function verifica_fisica_juridica($numcgm) {
 $result = db_query("select z01_cgccpf from cgm where z01_numcgm = $this->pc60_numcgm");
 if (strlen(pg_result($result,0,0)) == 11) {
   $this->fisica_juridica = 'f';
 } else {
   $this->fisica_juridica = 'j';
 }
}
}
?>
