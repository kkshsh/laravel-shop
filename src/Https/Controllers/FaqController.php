<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 20/03/2018
 * Time: 11:38
 */

namespace SimpleShop\Commodity\Https\Controllers;


use Illuminate\Http\Request;
use SimpleShop\Commodity\Faq;
use SimpleShop\Commons\Https\Controllers\Controller;
use SimpleShop\Commons\Utils\ReturnJson;

class FaqController extends Controller
{
    public function getDetail($id, Faq $faq)
    {
        $result = $faq->getListByGoodsId($id);
        
        return ReturnJson::success($result);
    }

    public function update(Request $request, Faq $faq)
    {
        $faq->update($request->input('data'));

        return ReturnJson::success();
    }
}