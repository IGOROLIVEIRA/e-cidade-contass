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
$campos .= "CASE WHEN ac16_semvigencia='t' THEN ('-')::varchar ELSE (ac16_numeroacordo || '/' || ac16_anousu)::varchar END dl_NК_Acordo, ";
$campos .= "acordosituacao.ac17_descricao as dl_Situaчуo, ";
$campos .= "acordo.ac16_contratado, ";
$campos .= "cgm.z01_nome,";
$campos .= "acordo.ac16_resumoobjeto::text, ";
$campos .= "acordo.ac16_valor,";
$campos .= "acordo.ac16_dataassinatura, ";
$campos .= "CASE WHEN ac16_semvigencia='t' THEN null ELSE ac16_datainicio END ac16_datainicio, ";
$campos .= "CASE WHEN ac16_semvigencia='t' THEN null ELSE ac16_datafim END ac16_datafim, ";
$campos .= "CASE 
       	   		WHEN acordo.ac16_origem = 1 THEN 'Processo de Compras'
       	   		WHEN acordo.ac16_origem = 2 THEN 'Licitaчуo'
       	   			ELSE 'Manual'
       		END ac16_origem,";
$campos .= "db_depart.descrdepto as dl_Dpto_de_Inclusao,";
$campos .= "responsavel.descrdepto as dl_Dpto_Responsavel";
/*$campos .= "acordo.ac16_acordosituacao,acordo.ac16_coddepto, ";
$campos .= "acordo.ac16_datapublicacao,";
$campos .= "descrdepto,codigo, ";
$campos .= "nomeinst, ";
$campos .= "acordo.ac16_resumoobjeto::text, ";
$campos .= "acordo.ac16_origem,acordo.ac16_formafornecimento,acordo.ac16_formapagamento,acordo.ac16_cpfsignatariocontratante, acordo.ac16_datapublicacao,acordo.ac16_veiculodivulgacao ";*/
