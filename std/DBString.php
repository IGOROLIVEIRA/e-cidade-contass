<?php
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

/**
 * Classe de manipula��o de String
 * @package std
 * @author Rafael Serpa Nery <rafael.nery@dbseller.com.br>
 * @author Renan Melo <renan@dbseller.com.br>
 */
abstract class DBString {

  /**
   * Verica se o tamanho total do nome � no minimo de 2 caracteres
   */
  const NOME_REGRA_1 = 1;
  /**
   * Verifica se a string de nome � composta por nome e sobrenome e cada um deles tem no minimo 2 caracteres
   */
  const NOME_REGRA_2 = 2;
  /**
   * Verifica se a string nome � composta por nome e sobrenome
   * @var unknown_type
   */
  const NOME_REGRA_3 = 3;
  /**
   * Verifica se a string nome contem quatro letras repetidas em sequencia
   */
  const NOME_REGRA_4 = 4;
  /**
   * Verifica se nome esta ascentuado, possui n�meros ou caract�res especiais
   */
  const NOME_REGRA_5 = 5;

  /**
   * Quebra uma string passando por par�metro o n�mero m�ximo de caracteres retornando um array
   *
   * @param string  $sString
   * @param integer $iNroMaxCaract
   * @param string  $sValorCompl
   * @return array
   */
  public static function quebrarLinha( $sString, $iNroMaxCaract, $sValorCompl=' ') {

    $aPalavras      = explode(' ',$sString);
    $iTamanhoTotal  = 0;
    $iIndLinha      = 0;
    $aRetornoString = array();

    foreach ( $aPalavras as $iInd => $sPalavra ) {

      $iTamanhoPalavra = strlen($sPalavra);

      if ( isset($aRetornoString[$iIndLinha]) ) {
        $iTamanhoPalavra += 1;
      }

      $iTamanhoTotal  += $iTamanhoPalavra;

      if ( $iTamanhoTotal <= $iNroMaxCaract  ) {
        if ( isset($aRetornoString[$iIndLinha]) ) {
          $aRetornoString[$iIndLinha].= ' '.$sPalavra;
        } else {
          $aRetornoString[$iIndLinha] = $sPalavra;
        }
      } else {
        $aRetornoString[$iIndLinha]   .= str_repeat($sValorCompl,$iNroMaxCaract-(strlen($aRetornoString[$iIndLinha])));
        $aRetornoString[++$iIndLinha]  = $sPalavra;
        $iTamanhoTotal                 = ($iTamanhoPalavra-1);
      }

    }

    $aRetornoString[$iIndLinha] .= str_repeat($sValorCompl,$iNroMaxCaract-(strlen($aRetornoString[$iIndLinha])));

    return $aRetornoString;
  }

  /**
   * Recebe a String e valida seu tamanho com o tamanho informado
   * @param string $sString
   * @param integer $iTamanho
   * @return boolean
   */
  public static function validarTamanho($sString, $iTamanho) {
    return (strlen($sString) == $iTamanho);
  }

  /**
   * Recebe um PIS e v�lido.
   *
   * @example DBString::isPIS("20097809998");
   * @param   String  $sPis
   * @return  boolean
   */
  public static function isPIS($sPIS) {

    /**
     * Valida se foi informado o PIS
     */

    if (empty($sPIS)){
      return false;
    }

    /**
     * Valida se o pis possui 11 Digitos
     */
    if ( !DBString::validarTamanho( $sPIS, 11 ) ) {
      return false;
    }

    /**
     * Verifica se o pis possui valores v�lidos
     */
    if ($sPIS == "00000000000"){
      return false;
    }

    /**
     * Verifica se o valor informado � inteiro
     */
    if(!(DBNumber::isInteger($sPIS))){
      return false;
    }

    /**
     * Multiplica os 10 primeiros algarismos do PIS pelos respectivos pesos [3,2,9,8,7,6,5,4,3,2],
     * somando o produto obtido a partir da multiplica��o na variavel $iSoma.
     */
    $iSoma  = $sPIS[0] * 3;
    $iSoma += $sPIS[1] * 2;
    $iSoma += $sPIS[2] * 9;
    $iSoma += $sPIS[3] * 8;
    $iSoma += $sPIS[4] * 7;
    $iSoma += $sPIS[5] * 6;
    $iSoma += $sPIS[6] * 5;
    $iSoma += $sPIS[7] * 4;
    $iSoma += $sPIS[8] * 3;
    $iSoma += $sPIS[9] * 2;

    /**
     * Verifica o resto da divis�o da Soma a cima por 11.
     * Subtrai o Total do respo da divis�o.
     */
    $iResto = $iSoma % 11;
    $iTotal = 11 - $iResto;


    /**
     * Se $iTotal for igual a 10 ou 11 o digito verificador ser� 11,
     * caso contratio o digito verificador ser� o valor de $iTotal
     */
    if ($iTotal == 10 || $iTotal == 11){
      $iDigito = 0;
    } else {
      $iDigito = $iTotal;
    }

    /**
     * Verifica se o digito verificador � v�lido.
     */
    if ($sPIS[10] == $iDigito) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Valida se a String passada � v�lida como CPF
   * @param String $sCpf
   * @return Boolean
   */
  public static function isCPF($sCpf) {

    $aBlackList = array(str_repeat("0",11),
        str_repeat("1",11),
        str_repeat("2",11),
        str_repeat("3",11),
        str_repeat("4",11),
        str_repeat("5",11),
        str_repeat("6",11),
        str_repeat("7",11),
        str_repeat("8",11),
        str_repeat("9",11));
    /**
     * Validamos se a String tem o tamanho correto
     */
    if ( !DBString::validarTamanho( $sCpf, 11 ) ) {
      return false;
    }

    /**
     * validamos se o $sCpf esta na BlackList
     */
    if ( in_array($sCpf, $aBlackList) ) {
      return false;
    }

    $sCPFBase            = substr($sCpf, 0, 9);
    $iPosicaoCPFBase     = 0;
    $nTotalCalculoDigito1= 0;

    for ( $iPosicaoCalculada = strlen($sCPFBase)+1; $iPosicaoCalculada > 1; $iPosicaoCalculada-- ) {

      $nTotalCalculoDigito1 += $iPosicaoCalculada * $sCPFBase[$iPosicaoCPFBase];
      $iPosicaoCPFBase++;
    }

    /**
     * A Base para O primeiro digito do CPF � formado pelo resto da divisao soma efetuada a cima
     * Se o resto for maior que 2 o digito sera 0, caso contrario o digito ser� 11 menos o resto
     */
    $iResto1   = $nTotalCalculoDigito1 % 11;
    $iDigito1 = ($iResto1 < 2) ? 0 : (11 - $iResto1);

    /**
     * Concatenamos o digito encontrado ao fim do CPF
     */
    $sCPFBase           .= $iDigito1;
    $iPosicaoCPFBase     = 0;
    $nTotalCalculoDigito2= 0;

    for ( $iPosicaoCalculada = strlen($sCPFBase)+1; $iPosicaoCalculada > 1; $iPosicaoCalculada-- ) {

      $nTotalCalculoDigito2 += $iPosicaoCalculada * $sCPFBase[$iPosicaoCPFBase];
      $iPosicaoCPFBase++;
    }

    /**
     * A base para o segundo digito do cpf � formado pelo resto da divisao da soma efetuada a cima
     * se o resto for maior que2 o digito ser� 0, caso contrario o digito sera 11 menos o resto
     *
     */
    $iResto2  = $nTotalCalculoDigito2 % 11;
    $iDigito2 = ($iResto2 < 2) ? 0 : (11 - $iResto2);
    $sCPFBase.= $iDigito2;

    return ($sCPFBase == $sCpf);
  }

  /**
   * VErifica se a String passada � vallida como CNPJ
   * @param string $sCNPJ
   * @return boolean
   */
  public static function isCNPJ( $sCNPJ ) {

    $aBlackList = array(
      str_repeat("0",14),
      str_repeat("1",14),
      str_repeat("2",14),
      str_repeat("3",14),
      str_repeat("4",14),
      str_repeat("5",14),
      str_repeat("6",14),
      str_repeat("7",14),
      str_repeat("8",14),
      str_repeat("9",14)
    );
    /**
     * Validamos se a String tem o tamanho correto
     */
    if ( !DBString::validarTamanho($sCNPJ, 14) ) {
      return false;
    }

    /**
     * validamos se o $sCpf esta na BlackList
     */
    if ( in_array($sCNPJ, $aBlackList) ) {
      return false;
    }

    $sBaseCalculo1 = "543298765432";
    $sBaseCalculo2 = "6543298765432";
    $sBaseCNPJ     = substr($sCNPJ, 0, 12);
    $nTotalBase1   = 0;

    for ( $iPosicaoCNPJ = 0; $iPosicaoCNPJ < strlen($sBaseCNPJ); $iPosicaoCNPJ++ ) {
      $nTotalBase1 +=  $sBaseCalculo1[$iPosicaoCNPJ] * $sBaseCNPJ[$iPosicaoCNPJ];
    }

    /**
     * A Base para O primeiro digito do CNPJ � formado pelo resto da divisao soma efetuada a cima
     * Se o resto for maior que 2 o digito sera 0, caso contrario o digito ser� 11 menos o resto
     */
    $iResto1  = $nTotalBase1 % 11;
    $iDigito1 = ($iResto1 < 2) ? 0 : (11 - $iResto1);

    /**
     * Concatenamos o digito encontrado ao fim do CNPJ
     */
    $sBaseCNPJ  .= $iDigito1;
    $nTotalBase2 = 0;

    for ( $iPosicaoCNPJ = 0; $iPosicaoCNPJ < strlen($sBaseCNPJ); $iPosicaoCNPJ++ ) {
      $nTotalBase2 +=  $sBaseCalculo2[$iPosicaoCNPJ] * $sBaseCNPJ[$iPosicaoCNPJ];
    }

    /**
     * A Base para o segundo digito do CNPJ � formado pelo resto da divisao soma efetuada a cima
     * Se o resto for maior que 2 o digito sera 0, caso contrario o digito ser� 11 menos o resto
     */
    $iResto2  = $nTotalBase2 % 11;
    $iDigito2 = ($iResto2 < 2) ? 0 : (11 - $iResto2);

    /**
     * Concatenamos o digito encontrado ao fim do CNPJ
     */
    $sBaseCNPJ .= $iDigito2;

    return ($sBaseCNPJ == $sCNPJ);
  }

  /**
   * Verifica se a string � v�lida como email
   * @param boolean $sEmail
   */
  public static function isEmail($sEmail){

    /**
     * verifica se possui cacteres validos para um email
     */
    $sEmail = strtolower($sEmail);
    $sRegex = '/^([0-9a-z\.\-_])+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    return preg_match($sRegex, $sEmail) ? true : false;
  }

  public static function isNomeValido($sNome, $iRegra){

      $aComposicaoNome = explode(' ', $sNome);

      switch ( $iRegra ) {
        /**
         * Verifica se o nome tem no minimo 2 caracteres
         */
        case DBString::NOME_REGRA_1:
          return DBString::validarTamanhoMinimo($sNome, 2);
        break;

        /**
         *  Verifica se o nome � composto pelo menos por 1 espaco, ou seja, nome e sobrenome
         */
        case DBString::NOME_REGRA_2:

          if ( !DBString::isNomeValido($sNome, DBString::NOME_REGRA_3) ) {
            return false;
          }
          if ( strlen($aComposicaoNome[0]) < 2 || strlen($aComposicaoNome[1]) < 2 ) {
            return false;
          }

        break;

        /**
         *  Verifica se o nome � composto(nome e sobrenome)
         */
        case DBString::NOME_REGRA_3:

          $aComposicaoNome = explode(' ', $sNome);

          if ( count($aComposicaoNome) < 2 ) {
            return false;
          }

        break;

        /**
         *  Verifica se o nome possui mais de 4 letras repetidas em sequencia
         */
        case DBString::NOME_REGRA_4:

          $sExpressao = '/([a-zA-Z�-�\s])\1{3}/';
          return preg_match( $sExpressao, $sNome ) ? false : true;

        break;

        /**
         *  Verifica se nome esta ascentuado, possui n�meros ou caract�res especiais
         */
        case DBString::NOME_REGRA_5:

          // $sExpressao = '/^([a-zA-Z\s]+)$/';
          $sExpressao = '/[�-�0-9.]/';
          return preg_match($sExpressao, $sNome) ? false : true;

        break;

        /**
         * Verifica nome e sobrenome, se possui ao menos 2 caract�res em cada nome, se possui quatro letras repetidas
         * em sequencia e se possui caract�res especiais
         */
        case DBString::NOME_REGRA_6:


        break;

        default:
          throw new Exception("Regra Inv�lida");
        break;
      }

      return true;
  }

  /**
   * Verifica se a String informada possui o tamanho minimo solicitado
   * @param stringnknown_type $sSting
   * @param integer $iTamanhoMinimo
   * @return boolean
   */
  public static function validarTamanhoMinimo($sString, $iTamanhoMinimo) {

    return (strlen($sString) >= $iTamanhoMinimo);
  }

  /**
   * Verifica se a string n�o ultrapassa o tamanho m�ximo solicitado.
   *
   * @access public
   * @param String $sString
   * @param Integer $iTamanhoMaximo
   * @return Boolean
   */
  public static function validarTamanhoMaximo($sString, $iTamanhoMaximo) {

    return (strlen($sString) <= $iTamanhoMaximo);
  }

  /**
   * Verifica se a string possui somente n�meros.
   *
   * @access public
   * @param String $sPalavra
   * @return Boolean
   */
  public static function isSomenteNumero($sPalavra) {

    $sRegex = '/^[0-9]+$/';
    return preg_match($sRegex, $sPalavra) ? true : false;
  }

  public static function isSomenteLetras($sPalavra, $lLetrasAcentuadas = false) {

    $sRegex = '/^[a-zA-Z\s]+$/';
    if ($lLetrasAcentuadas ) {
      $sRegex = '/^[a-zA-Z�-�\s]+$/';
    }
    return preg_match($sRegex, $sPalavra) ? true : false;
  }

  /**
   * Valida se a string � somente alfanumerica
   * @param string $sPalavra
   * @param boolean $lAceitaBarra
   * @param boolean $lAceitaHifen
   * @param boolean $lAceitaPonto
   * @return boolean
   */
  public static function isSomenteAlfanumerico($sPalavra, $lAceitaBarra=true, $lAceitaHifen=false, $lAceitaPonto=false) {

   $sBarra = '';
   if($lAceitaBarra){
      $sBarra = '\/';
   }

   $sHifen = '';
   if($lAceitaHifen){
      $sHifen = '\-';
   }

   $sPonto = '';
   if($lAceitaPonto){
      $sPonto = '\.';
   }

   $sRegex = "/^[a-zA-Z0-9$sPonto$sHifen$sBarra\s]+$/";

   return preg_match($sRegex, $sPalavra) ? true : false;
  }

  /**
   * Remove acentua��o na string passada
   *
   * @param String $sString - String acentuada
   * @static
   * @access public
   * @return String - String com os acentos removidos
   */
  public static function removerAcentuacao($sString) {

    $sString = preg_replace("/[����]/", "A", $sString);
    $sString = preg_replace("/[����]/","a", $sString);

    $sString = preg_replace("/[���]/",  "E", $sString);
    $sString = preg_replace("/[���]/",  "e", $sString);

    $sString = preg_replace("/[����]/", "O", $sString);
    $sString = preg_replace("/[�����]/","o", $sString);

    $sString = preg_replace("/[���]/",  "U", $sString);
    $sString = preg_replace("/[���]/",  "u", $sString);

    $sString = preg_replace("/�/", "C", $sString);
    $sString = preg_replace("/�/", "c", $sString);

    return $sString;
  }

  /**
   * Remove os caracteres especiais da String
   *
   * @param String $sString
   * @static
   * @access public
   * @return String - Retorna a string sem caracteres especiais
   */
  public static function removerCaracteresEspeciais($sString) {
    preg_match_all("/[a-zA-Z�-�0-9\s]/i", $sString, $aOcorrencias);
    return implode("", $aOcorrencias[0]);
  }

  /**
   * Recebe uma string e se ela for maior que o limite informado, corta o final
   * e substitui pelo sufixo informado
   * Se o limite for 0 ou menor que 0, retorna vazio
   * @param  string  $sString
   * @param  integer $iLimite
   * @param  string  $sSufixo
   * @return string
   */
  public static function retornaStringLimitada($sString, $iLimite = 0, $sSufixo = '...') {
    return ( $iLimite > 0 ? mb_strimwidth($sString, 0, $iLimite, $sSufixo) : '' );
  }

  /**
   * Retorna o Primeiro e Ultimo nome
   * Verifica se o ultimo nome possui prefixo da, de, dos, etc.
   * @param  string $sString
   * @param  string $sDelimitador
   * @return string
   */
  public static function retornaNomeReduzido($sString, $sDelimitador = ' ') {

    $aString        = array_values( explode($sDelimitador,$sString) );
    $sPrimeiroNome  = $aString[0];
    $sPref          = "";

    if ( $aString[count($aString)-2] != $sPrimeiroNome &&
           (strlen($aString[count($aString)-2]) == 2 ||
              strlen($aString[count($aString)-2]) == 3 )) {

      $sPref = $aString[count($aString)-2];
    }

    $sUltimoNome    = array_pop($aString);
    return "{$sPrimeiroNome} {$sPref} {$sUltimoNome}";
  }
}
