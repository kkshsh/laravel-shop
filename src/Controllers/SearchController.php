<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/14
 * Time: 下午6:25
 */

namespace  LWJ\Commodity\Controllers;


use App\Exceptions\DatabaseErrorException;
use App\Http\Requests\Admin\Commodity\SearchAddOrUpdateRequest;
use LWJ\Commodity\Search as  CommoditySearch;

class SearchController extends Controller
{
    private $search;
    public function __construct(CommoditySearch $search)
    {
        parent::__construct();
        $this->search;
    }

    public function getSearch($id)
    {
        $data = $this->search->getByCate($id);

        return $this->success($data);
    }

    public function getParentSearch($id)
    {
        $data = $this->search->getParentByCate($id);

        return $this->success($data);
    }

    /**
     * 添加或更新数据
     *
     * @param SearchAddOrUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addOrUpdate(SearchAddOrUpdateRequest $request)
    {
        try {
            $this->search->addOrUpdate($request->all());
        } catch (\Exception $e) {
            $msg = $e->getMessage();

            throw new DatabaseErrorException($msg, $e);
        }

        return $this->success();
    }

    /**
     * 删除
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->search->delete($id);

        return $this->success();
    }
}