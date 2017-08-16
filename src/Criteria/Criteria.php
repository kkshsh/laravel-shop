<?php
namespace Commodity\Criteria;

use Commodity\Contracts\RepositoryInterface as Repository;
use Illuminate\Support\Collection;

abstract class Criteria {

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public abstract function apply($model, Repository $repository);

    /**
     * @param int $id
     * @param array|Collection $input
     * @return array
     */
    protected function getLastCateId(int $id, $input)
    {
        $cateId = [];

        foreach ($input as $item) {
            $tree = explode(',', $item['tree']);

            if (count($tree) == 3 && in_array($id, $tree) !== false) {
                $cateId[] = $item['id'];
            }
        }

        return $cateId;
    }
}
