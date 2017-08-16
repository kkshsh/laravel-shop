<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/3
 * Time: 18:55
 */

namespace LWJ\Commodity\Goods\Eloquent;


use Illuminate\Support\Collection;
use LWJ\Commodity\Exceptions\Exception;
use LWJ\Commodity\Models\ShopGoodsProductModel;
use LWJ\Commodity\Repository\Repository;
use LWJ\Commodity\Models\ShopGoodsSpecModel;
use LWJ\Commodity\Models\ShopGoodsAttributeModel;
use DB;

class GoodsRepository extends Repository
{

    public function model()
    {
        return 'LWJ\Commodity\Models\ShopGoodsModel';
    }

    /**
     * 根据商品名称获取内容
     * @param $name
     */
    public function getByName($name)
    {
        return $this->model->select('id')->where("name", $name)->first();
    }

    /**
     * 获取attr的id
     *
     * @param $id
     * @return array
     */
    public function getAttrId($id)
    {
        $result = ShopGoodsAttributeModel::where('goods_id', $id)->get();
        $reData = [];
        foreach ($result as $item) {
            $reData[] = [
                'attr_id' => $item->attr_id,
                'value'   => $item->attr_value_id
            ];
        }

        return $reData;
    }

    /**
     * 获取spec的id
     *
     * @param $id
     * @return array
     */
    public function getSpecId($id)
    {
        $result = ShopGoodsSpecModel::where('goods_id', $id)->get();
        $reData = [];
        foreach ($result as $item) {
            $reData[] = $item->spec_value_id;
        }

        return $reData;
    }

    public function goodsCommend($goods_id, $num)
    {
        return ShopGoodsProductModel::with([
            'goods' => function ($query) {
                $query->select([
                    'id',
                    'cover_path',
                    'cate_id',
                    'store_name',
                    'store_id',
                    'sku_id',
                    'price',
                    'max_price',
                    'name',
                    'tags',
                    'brand_id',
                    'description',
                    'unit',
                    'begin_num',
                    'status',
                    'sort',
                    'hot'
                ]);
            }
        ])->where('status',config('commodity.status.on_sale'))
            ->orderBy(\DB::raw("RAND()"))
            ->take($num)->get();
    }

    /**
     * 获取随机的商品
     *
     * @param int $limit 要查询多少条数据
     * @param $storeIds
     * @param int $status
     * @return Collection
     */
    public function getRandom($limit, $storeIds, $status = 1)
    {
        $sql = /** @lang MySQL */
            <<<SQL
        SELECT `t1`.`id`, `t1`.`store_id`, `t1`.`store_name`, `t1`.`price`, `t1`.`sku_id`, `t1`.`max_price`,
        `t1`.`name`, `t1`.`cover_path`, `t1`.brand_id, `t1`.`tags`, `t1`.`cate_id`, `t1`.`description`, `t1`.`hot`,
        `t1`.`sort`, `t1`.`status`, `t1`.`begin_num`, `t1`.`verify`, `t1`.`created_at`, `t1`.`updated_at` 
FROM `shop_goods` AS t1 JOIN (SELECT ROUND(RAND() * (SELECT MAX(id) FROM `shop_goods`)) AS id) AS t2 
WHERE t1.id >= t2.id 
AND t1.store_id IN (?)
AND t1.status = ?
ORDER BY t1.id ASC LIMIT ?;
SQL;
        // 发送sql语句
        $data = DB::select($sql, [$storeIds, $status, $limit]);

        return collect($data);
    }

    /**
     * 检查cate_id是否已经使用了
     *
     * @param array $cateIds
     * @return Collection
     */
    public function cateIsUsed(array $cateIds)
    {
        // 找到该分类下所有分类的id
        $sql = /** @lang MySQL */
            <<<SQL
        SELECT `id` FROM shop_goods WHERE `cate_id` IN (?)  LIMIT 1 OFFSET 0;
SQL;
        // 发送语句
        $data = DB::select($sql, [implode(',', $cateIds)]);
        return collect($data);
    }
}