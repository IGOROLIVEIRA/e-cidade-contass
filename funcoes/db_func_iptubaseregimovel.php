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

$campos = "iptubaseregimovel.j04_sequencial,case when j39_numero is null
                          then 'Terr'
                          else 'Pred'
                        end as Tipo,
                        case when ruase.j14_codigo is null
                          then ruas.j14_nome
                          else ruase.j14_nome
                        end as j14_nome,
                        case when j39_numero is null
                          then 0
                          else j39_numero
                        end as j39_numero,j13_descr,
                        j39_compl, iptubaseregimovel.j04_setorregimovel,iptubaseregimovel.j04_matric,iptubaseregimovel.j04_matricregimo,iptubaseregimovel.j04_quadraregimo,iptubaseregimovel.j04_loteregimo";
?>