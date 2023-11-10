<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBSeller Servicos de Informatica
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

namespace App\Domain\Patrimonial\Contratos\Models;

use App\Domain\Patrimonial\PNCP\Models\ContratoPNCP;
use App\Domain\Patrimonial\Protocolo\Model\Cgm;
use Illuminate\Database\Eloquent\Model;

class Acordo extends Model
{
    protected $primaryKey = 'ac16_sequencial';
    protected $table = 'acordo';
    protected $fillable = [];
    public $timestamps = false;

    public function contratado()
    {
        return $this->hasOne(Cgm::class, 'z01_numcgm', 'ac16_contratado');
    }

    public function contratoPncp()
    {
        return $this->hasOne(ContratoPNCP::class, 'pn04_acordo', 'ac16_sequencial');
    }
}
