<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBselller Servicos de Informatica             
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

$campos  = "acordo.ac16_sequencial, ";
$campos .= "(acordo.ac16_numero || '/' || acordo.ac16_anousu)::varchar as ac16_numero, ";
$campos .= "acordo.ac16_dataassinatura, ";
$campos .= "acordo.ac16_contratado, cgm.z01_nome,";
$campos .= "acordo.ac16_valor,";
$campos .= "acordo.ac16_datapublicacao,";
$campos .= "acordo.ac16_datainicio, ";
$campos .= "acordo.ac16_datafim ";
/*$campos .= "acordo.ac16_acordosituacao,acordo.ac16_coddepto, ";
$campos .= "descrdepto,codigo, ";
$campos .= "nomeinst, ";
$campos .= "acordo.ac16_resumoobjeto::text, ";
$campos .= "acordo.ac16_origem,acordo.ac16_formafornecimento,acordo.ac16_formapagamento,acordo.ac16_cpfsignatariocontratante, acordo.ac16_datapublicacao,acordo.ac16_veiculodivulgacao ";*/
