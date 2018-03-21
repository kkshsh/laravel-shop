<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/9/7
 * Time: 10:05
 */
namespace SimpleShop\Commodity\Contracts;


use Illuminate\Database\Eloquent\Model;

interface CommodityContract
{

    /**
     * @param array $data
     *
     * @return Model|\stdClass
     */
    public function create(array $data): Model;

    /**
     * @param  int|string $id
     * @param array       $data
     *
     * @return bool
     */
    public function update($id, array $data): bool;

    /**
     * @param int|string $id
     *
     * @return mixed
     */
    public function destroy($id) :bool;
}