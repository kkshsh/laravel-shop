<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2018/2/24
 * Time: 15:09
 */

namespace SimpleShop\Commodity\Https\Controllers\Web;


use SimpleShop\Commons\Https\Controllers\Controller;

class CommodityController extends Controller
{
    public function show($id)
    {
        return view('template.default.pc.commodity.detail', ['id' => $id]);
    }

    public function index()
    {
        return view('template.default.pc.commodity.index');
    }

    public function search()
    {
        return view('template.default.pc.commodity.search');
    }
}