<?php
/**
 *------------------------------------------------------
 * Search.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @version   V1.0
 *
 */

namespace SimpleShop\Commodity\Repositories\CriteriaProduct;

use SimpleShop\Repositories\Contracts\RepositoryInterface as Repository;
use SimpleShop\Repositories\Criteria\Criteria;

class Search extends Criteria
{
    /**
     * @var array
     */
    private $search;

    /**
     * Search constructor.
     *
     * @param array $search
     */
    public function __construct(array $search)
    {
        $this->search = $search;
    }

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        if ( isset($this->search['cate_id']) ) {
            $model = $model->where('cate_id', $this->search['cate_id']);
        }

        if ( isset($this->search['tag']) ) {
            $model = $model->where('tag', $this->search['tag']);
        }

        if (isset($this->search['name'])) {
            $model = $model->where('shop_goods_product.name', 'like', "%{$this->search['name']}%");
        }

        return $model;
    }
}