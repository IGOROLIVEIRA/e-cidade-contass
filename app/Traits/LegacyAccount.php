<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;
use LogicException;

trait LegacyAccount
{
    public string $tableName;
    public string $schemaName = 'public';

    public function save(array $options = [])
    {
        $this->persistLegacyAccount($this, $this->exists ? 'A' : 'I');
        parent::save($options);
    }

    public function persistLegacyAccount(Model $model, string $action = 'I')
    {
        $sequence = $this->getAccountNextVal();

        if (empty($model->fillable)) {
            throw new LogicException('Para salvar os dados do log do account do e-cidade,
             utilizando o eloquent, configure a propriedade $fillable dentro do model.');
        }

        if (empty($model->primaryKey)) {
            throw new LogicException('Para salvar os dados do log do account do e-cidade,
             utilizando o eloquent, configure a propriedade $primaryKey dentro do model.');
        }

        if (empty($model->table)) {
            throw new LogicException('Para salvar os dados do log do account do e-cidade,
             utilizando o eloquent, configure a propriedade $table dentro do model.');
        }

        $this->setTableNameAndSchemaName();

        $this->insertAcountAcesso($sequence);
        $this->insertAcountKey($sequence, $action);
        $codArq = $this->getCodarqByTableName($this->tableName);

        foreach ($model->fillable as $field) {
            $oldValue = empty($model->getOriginal($field)) ? '' : $model->getOriginal($field);
            $newValue = empty($model->getAttributeValue($field)) ? '' : $model->getAttributeValue($field);
            $codCam = $this->getCodcamByName($field);
            $this->insertAcount($sequence, $codArq, $codCam, $newValue, $oldValue);
        }
    }

    protected function getAccountNextVal(): int
    {
        ['acount' => $sequence] = (array)DB::connection()
            ->selectOne("select nextval('db_acount_id_acount_seq') as acount");
        return $sequence;
    }

    protected function setTableNameAndSchemaName(): void
    {
        $tableNameParts = explode('.', $this->table);
        if (count($tableNameParts) === 1) {
            $this->tableName = $tableNameParts[0];
            return;
        }
        $this->schemaName = $tableNameParts[0];
        $this->tableName = $tableNameParts[1];
    }

    protected function insertAcountAcesso($sequence)
    {
        DB::connection()
            ->unprepared("insert into db_acountacesso values($sequence," . db_getsession("DB_acessado") . ")");
    }

    protected function insertAcountKey(int $sequence, string $action)
    {
        foreach (explode(',', $this->getKeyName()) as $primaryKey) {
            $codCam = $this->getCodcamByName($primaryKey);
            DB::connection()
                ->unprepared("insert into db_acountkey values($sequence,$codCam,'$primaryKey','$action')");
        }
    }

    protected function getCodcamByName(string $name): int
    {
        $sql = "select db_syscampo.codcam
                from db_syscampo
                inner join db_sysarqcamp on db_syscampo.codcam = db_sysarqcamp.codcam
                inner join db_sysarquivo on db_sysarquivo.codarq = db_sysarqcamp.codarq
                where db_sysarquivo.nomearq = '{$this->tableName}'
                and db_syscampo.nomecam = '{$name}'";
        ['codcam' => $codCam] = (array)DB::connection()->selectOne($sql);
        return $codCam;
    }

    protected function getCodarqByTableName(string $tableName): int
    {
        ['codarq' => $codarq] = (array)DB::connection()
            ->selectOne("select codarq from db_sysarquivo where nomearq = '{$tableName}'");
        return $codarq;
    }

    protected function insertAcount(int $sequence, int $codarq, int $codcam, string $newValue, string $oldValue = '')
    {
        DB::connection()
            ->unprepared("insert into db_acount
                        values(
                               $sequence,
                               $codarq,
                               $codcam,
                               '{$oldValue}',
                               '{$newValue}',
                               " . db_getsession('DB_datausu') . ",
                               " . db_getsession('DB_id_usuario') . ")"
            );
    }

    public function update(array $attributes = [], array $options = [])
    {
        $this->persistLegacyAccount($this, 'A');
        parent::update($attributes, $options);
    }

    public function delete()
    {
        $this->persistLegacyAccount($this, 'D');
        parent::delete();
    }
}
