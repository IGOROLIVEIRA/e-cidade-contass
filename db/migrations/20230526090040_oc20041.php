<?php

use App\Support\Database\AsFunction;
use App\Support\Database\Instituition;
use ECidade\Suporte\Phinx\PostgresMigration;

class Oc20041 extends PostgresMigration
{
    use AsFunction;
    use Instituition;

    public const PMMONTALVANIA = '17097791000112';

    public function up()
    {
        if (empty($this->checkInstituicaoExists(self::PMMONTALVANIA))) {
            return;
        }
        $this->createFunction('public.fc_iptu_calculavvc_montalvania_2023', '2023-05-26');
    }

    public function down()
    {
        if (empty($this->checkInstituicaoExists(self::PMMONTALVANIA))) {
            return;
        }
        $this->createFunction('public.fc_iptu_calculavvc_montalvania_2023', '2023-01-01');
    }
}
