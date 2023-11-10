<?php

 class db_stdClass {

   /**
    * Retorna os dados da instituicao. caso nao seje informado a instituição sera
    * retornado a instituicao da sessao
    *
    * @param integer $iInstit Código da instituicao;
    * @return object
    */
   function getDadosInstit($iInstit = null) {

      if (empty($iInstit)) {
        $iInstit = db_getsession("DB_instit");
      }

      $sSqlInstit = "select * from db_config where codigo = {$iInstit}";
      $rsInstit   = db_query($sSqlInstit);
      return db_utils::fieldsMemory($rsInstit, 0);
   }

   /**
    * Retorna os parametros configurados para a tabela de configuracao especificada.
    *
    * @param string $sClassParametro nome da classe de parametro
    * @param array $aKeys  parametros chaves da classe (metodo sql_query_file)
    * @param string $sFields lista de campos
    * @return object db_utils
    */
   function getParametro($sClassParametro, $aKeys = null, $sFields = "*") {

     /*
      * TODO buscar tabelas de parametro da tabela db_sysarquivo
      */
     $aClassesValidas = array (
                               "empparametro",
                               "caiparametro",
                               "numpref",
                               "tarefaparam",
                               "cfiptu",
                               "",
                              );

     if (empty($sFields)) {
       $sFields = "*";
     }
     if (!in_array($sClassParametro, $aClassesValidas)) {
       return false;

     }
     $oRetorno       = false;
     $oClass         = db_utils::getDao($sClassParametro);
     $oReflectMethod = new ReflectionMethod ("cl_{$sClassParametro}::sql_query_file");
     $i = 0;
     foreach ($oReflectMethod->getParameters() as $i => $param) {

       $svar   = $param->getName();
       if (!$param->isOptional() || isset($aKeys[$i])) {
         $aParam[] = $aKeys[$i];
       } else if ($param->getName() == "campos" ){
         $aParam[] = $sFields;
       } else {
         $aParam[] = null;
       }
       $i++;
     }

     $sRetornoSql  = call_user_func_array(array(&$oClass,"sql_query_file"), $aParam);
     $rsRetornoSql = call_user_func_array(array(&$oClass,"sql_record"), array($sRetornoSql));
     $iNumRows     = $oClass->numrows;
     $oRetorno     = db_utils::getColectionByRecord($rsRetornoSql);
     return $oRetorno;
   }
}



?>
