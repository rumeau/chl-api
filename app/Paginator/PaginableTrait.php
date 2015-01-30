<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 021 21/01/2015
 * Time: 13:13
 */

namespace App\Paginator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

/**
 * Class PaginableTrait
 * @package App\Paginator
 *
 * @method static LengthAwarePaginator paginable(Request $request)
 */
trait PaginableTrait
{
    /**
     * @param Builder|QueryBuilder $query
     * @param Request $request
     * @return Builder
     */
    public function scopePaginable(Builder $query, Request $request)
    {
        if ($request->has('q')) {
            $token = $request->query('q', '');
            if (isset($this->queryFields) && count($this->queryFields)) {
                $queryFields = $this->queryFields;
                $query->where(function ($q) use ($token, $queryFields) {
                    /**
                     * @var \Illuminate\Database\Query\Builder $q
                     */
                    foreach ($queryFields as $field) {
                        $q->orWhere($field, 'LIKE', "%{$token}%");
                    }
                });
            }
        }

        if ($request->has('by')) {
            $order = $request->query('order', isset($this->order) ? $this->order : 'ASC');
            $by    = $request->query('by', isset($this->by) ? $this->by : 'id');

            if (strstr($by, '.')) {
                $from = $query->getQuery()->from;
                $query->select("$from.*"); // Main table columns only
                $parts = explode('.', $by); // Parts to join
                $query->join($parts[0] . ' AS ot', 'ot.id', '=', "$from.{$parts[1]}");
                $query->orderBy('ot.' . $parts[2], $order);
                $query->groupBy("$from.id");
            } else {
                $query->orderBy($by, $order);
            }
        }

        return $query;
    }
}