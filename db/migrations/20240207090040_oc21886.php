<?php

use App\Support\Database\AsFunction;
use ECidade\Suporte\Phinx\PostgresMigration;

class Oc21886 extends PostgresMigration
{
    use AsFunction;

    public function up()
    {
        $this->createFunction('public.fc_iptu_demonstrativo', '2024-02-07');
    }

    public function down()
    {
        $this->createFunction('public.fc_iptu_demonstrativo', '2024-01-01');
    }
}
