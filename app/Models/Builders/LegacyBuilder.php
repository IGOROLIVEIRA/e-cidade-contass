<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LegacyBuilder extends Builder
{
    /**
     * Colunas adicionadas no recurso, mas n�o na query
     *
     * @var array
     */
    private array $additional = [];

    /**
     * Colunas em query, mas n�o no recurso
     *
     * @var array
     */
    private array $except = [];

    /**
     * Filtros
     *
     * @var array
     */
    private array $filters = [];

    /**
     * Filtra por parametros
     *
     * @param array $data
     *
     * @return $this
     */
    public function filter(array $data = []): LegacyBuilder
    {
        $this->setFilters($data);
        $this->executeFilters();

        return $this;
    }

    /**
     * Retorna um recurso collection
     *
     * @param array $columns
     * @param array $additional
     *
     * @return Collection
     */
    public function resource(array $columns = ['*'], array $additional = []): Collection
    {
        $this->setAdditional($additional);
        $columnsNotExcept = $columns;
        $columns = array_merge($columns, $this->except);
        $columns = $this->replaceAttribute($columns);
        //original do laravel
        $resource = $this->get($columns);

        return $this->mapResource($resource, $columnsNotExcept);
    }

    /**
     * Transforma o recurso com os novos parametros
     *
     * @param Collection $resource
     * @param array      $columnsNotExcept
     *
     * @return Collection
     */
    private function mapResource(Collection $resource, array $columnsNotExcept): Collection
    {
        return $resource->map(function (Model $item) use ($columnsNotExcept) {
            $resource = [];
            //Trata colunas com alias do banco de dados
            foreach ($columnsNotExcept as $key) {
                if (Str::contains($key, ' as ')) {
                    [, $alias] = explode(' as ', $key);
                    $resource[$alias] = $item->{$alias};
                } else {
                    $resource[$key] = $item->{$key};
                }
            }
            //Trata colunas com alias adicionais
            foreach ($this->additional as $key) {
                if (Str::contains($key, ' as ')) {
                    [$key, $alias] = explode(' as ', $key);
                    $resource[$alias] = $item->{$key};
                } else {
                    $resource[$key] = $item->{$key};
                }
            }

            return $resource;
        });
    }

    /**
     * Colunas adicionais que n�o est�o na query, mas � adicionado no recurso
     *
     * @param array $additional
     *
     * @return LegacyBuilder
     */
    private function setAdditional(array $additional): LegacyBuilder
    {
        $this->additional = $additional;

        return $this;
    }

    /**
     * Colunas a serem adicionadas na query, mas n�o retorna no recurso
     *
     * @param array $except
     *
     * @return LegacyBuilder
     */
    public function setExcept(array $except): LegacyBuilder
    {
        $this->except = $except;

        return $this;
    }

    /**
     * Executa os filtros
     *
     * @return void
     */
    private function executeFilters(): void
    {
        foreach ($this->filters as $filter => $parameter) {
            $method = 'where' . $filter;
            if (is_array($parameter)) {
                $this->{$method}(...$parameter);

                continue;
            }
            $this->{$method}($parameter);
        }
    }

    /**
     * Substitui os atributos legados
     */
    private function replaceAttribute(array $columns): array
    {
        //parametro definido no model
        if (!property_exists($this->getModel(), 'legacy')) {
            return $columns;
        }
        $legacy = $this->getModel()->legacy;
        if (!is_array($legacy) || empty($legacy)) {
            return $columns;
        }
        $data = [];
        foreach ($columns as $key) {
            if (Str::contains($key, ' as ')) {
                [$key, $alias] = explode(' as ', $key);
                $legacyKey = $legacy[$key] ?? $key;
                $data[] = $legacyKey . ' as ' . $alias;
            } else {
                $data[] = $legacy[$key] ?? $key;
            }
        }
        if (!empty($data)) {
            $columns = $data;
        }

        return $columns;
    }

    /**
     * Insere os filtros personalizados ou do request
     *
     * @param array $filters
     *
     * @return void
     */
    private function setFilters(array $filters): void
    {
        $data = [];
        foreach ($filters as $key => $value) {
            $filter = $this->getFilterName($key);
            if ($this->checkWhereParameters($value, $filter)) {
                $data[$filter] = $value;
            }
            $this->filters = $data;
        }
    }

    public function checkWhereParameters($value, $filter)
    {
        return ((!is_array($value) && $value !== null && $value !== '') ||
                (is_array($value) && count(array_filter($value)) > 0)) &&
            method_exists($this, 'where' . $filter);
    }

    /**
     * Transforma o nome do parametro para o nome de filtro
     *
     * @param $name
     *
     * @return string
     */
    private function getFilterName($name): string
    {
        return Str::camel($name);
    }

    /**
     * Filtro Padr�o a todos os Builders
     *
     * @param int|null $limit
     *
     * @return $this
     */
    public function whereLimit(int $limit = null): self
    {
        return $this->when($limit, fn ($q) => $q->limit($limit));
    }

    /**
     * Filtra por nome e id do pa�s
     *
     * @param string $search
     *
     * @return $this
     */
    public function whereSearch(string $search): self
    {
        return $this->where(function ($q) use ($search) {
            if (is_numeric($search) || str_contains($search, ',')) {
                $q->whereIn($this->model->getKeyName(), explode(',', $search));
            } else {
                $q->whereName($search);
            }
        });
    }

    public function whereFilter(string $filters): self
    {
        $filters = array_filter(explode('|', $filters));
        $groupRelations = new Collection();
        foreach ($filters as $filter) {
            //relacionamentos
            if (str_contains($filter, '.')) {
                $relation = substr($filter, 0, strrpos($filter, '.'));
                $column = substr($filter, (strrpos($filter, '.') + 1));
                $groupRelations->push([$relation, $column]);

                continue;
            }

            //filtros
            $data = array_filter(explode(',', $filter));
            $method = 'where' . $this->getFilterName($data[0]);
            if (method_exists($this, $method)) {
                $parameter = $data[1] ?? null;
                if ($parameter !== null) {
                    $this->{$method}($data[1]);
                }
            } else {
                //normal
                $this->where(...$data);
            }
        }

        //execu��o agrupada dos relacionamentos
        foreach ($groupRelations->groupBy(0) as $groupRelation => $groupRows) {
            $this->whereHas($groupRelation, static function ($q) use ($groupRows) {
                foreach ($groupRows as $groupRow) {
                    $q->where(...array_filter(explode(',', $groupRow[1])));
                }
            });
        }

        return $this;
    }

    /**
     * Obtem o valor de um filtro
     *
     * @param string          $name
     * @param int|string|null $default
     *
     * @return mixed
     */
    public function getFilter(string $name, mixed $default = null): mixed
    {
        return Arr::get($this->filters, $this->getFilterName($name), $default);
    }

    public function get($columns = ['*'])
    {
        $columns = is_array($columns) ? $columns : func_get_args();

        foreach ($columns as $key => $column) {
            $columns[$key] = $this->getLegacyColumn($column);
        }

        return parent::get($columns);
    }

    public function first($columns = ['*'])
    {
        $columns = is_array($columns) ? $columns : func_get_args();

        foreach ($columns as $key => $column) {
            $columns[$key] = $this->getLegacyColumn($column);
        }

        return parent::first($columns);
    }

    public function select($columns = ['*'])
    {
        $columns = is_array($columns) ? $columns : func_get_args();

        foreach ($columns as $key => $column) {
            $columns[$key] = $this->getLegacyColumn($column);
        }

        return parent::select($columns);
    }

    public function orderBy($column, $direction = 'asc')
    {
        if (is_string($column)) {
            return parent::orderBy($this->getLegacyColumn($column), $direction);
        }

        return parent::orderBy($column, $direction);
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        if (is_string($column)) {
            return parent::where($this->getLegacyColumn($column), $operator, $value, $boolean);
        }

        return parent::where($column, $operator, $value, $boolean);
    }

    public function whereIn($column, $values, $boolean = 'and', $not = false)
    {
        if (is_string($column)) {
            return parent::whereIn($this->getLegacyColumn($column), $values, $boolean, $not);
        }

        return parent::whereIn($column, $values, $boolean, $not);
    }

    public function whereNot($column, $operator = null, $value = null, $boolean = 'and')
    {
        if (is_string($column)) {
            return parent::whereNot($this->getLegacyColumn($column), $operator, $value, $boolean);
        }

        return parent::whereNot($column, $operator, $value, $boolean);
    }

    public function whereNotIn($column, $values, $boolean = 'and')
    {
        if (is_string($column)) {
            return parent::whereNotIn($this->getLegacyColumn($column), $values, $boolean);
        }

        return parent::whereNotIn($column, $values, $boolean);
    }

    public function orWhere($column, $operator = null, $value = null)
    {
        if (is_string($column)) {
            return parent::orWhere($this->getLegacyColumn($column), $operator, $value);
        }

        return parent::orWhere($column, $operator, $value);
    }

    public function find($id, $columns = ['*'])
    {
        foreach ($columns as $key => $column) {
            $columns[$key] = $this->getLegacyColumn($column);
        }

        if (is_string($id)) {
            $id = $this->getLegacyColumn($id);
        }

        return parent::find($id, $columns);
    }

    public function findOrFail($id, $columns = ['*'])
    {
        foreach ($columns as $key => $column) {
            $columns[$key] = $this->getLegacyColumn($column);
        }

        return parent::findOrFail($this->getLegacyColumn($id), $columns);
    }

    public function groupBy(...$groups)
    {
        foreach ($groups as $key => $value) {
            $groups[$key] = $this->getLegacyColumn($value);
        }

        return parent::groupBy($groups);
    }

    private function getLegacyColumn($column)
    {
        if (method_exists($this->getModel(), 'getLegacyColumn')) {
            return $this->getModel()->getLegacyColumn($column);
        }

        return $column;
    }
}