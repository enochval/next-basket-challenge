<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Mguinea\Criteria\Criteria;
use Mguinea\Criteria\Filter;
use Mguinea\Criteria\FilterOperator;

final class EloquentCriteriaTransformer
{
    public function __construct(
        private readonly Criteria $criteria,
        private readonly Model $model
    ) {
    }

    /**
     * @throws \Exception
     */
    public function builder(): Builder
    {
        $query = $this->model->newModelQuery();

        /** @var Filter $filter */
        foreach ($this->criteria->filters as $filter) {
            switch ($filter->operator) {
                case FilterOperator::EQUAL:
                    return $query->where($filter->field, '=', $filter->value);
                case FilterOperator::NOT_EQUAL:
                    return $query->where($filter->field, '!=', $filter->value);
                case FilterOperator::GTE:
                case FilterOperator::LT:
                case FilterOperator::LTE:
                case FilterOperator::CONTAINS:
                case FilterOperator::GT:
                    throw new \Exception('To be implemented');
                case FilterOperator::NOT_CONTAINS:
                    throw new \Exception('To be implemented');
            }
        }

        return $query;
    }
}
