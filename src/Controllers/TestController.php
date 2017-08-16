<?php
/**
 *------------------------------------------------------
 * 活动管理
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @date      2016/5/26 11:17
 * @version   V1.0
 *
 */


use SimpleShop\Commodity\Attribute;
use SimpleShop\Commodity\Brand;
use SimpleShop\Commodity\Cate;
use SimpleShop\Commodity\Commodity;
use SimpleShop\Commodity\Goods\Criteria\MultiWhereGoods;
use SimpleShop\Commodity\Goods\Criteria\ProductGoods;
use SimpleShop\Commodity\Goods\Criteria\ProductIds;
use SimpleShop\Commodity\Spec;

use Cart;
use LWJ\Services\Pay\LwjPay;

class TestController extends Controller
{
    /**
     * 初始化Service
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
//        $this->futures();

//        $this->cart();
//        $this->attr();
//        $this->spec();
//        $this->cate();
//        $this->brand();
//        $this->order();
        $this->goods();
        $this->updateGoods();
//        $this->goodsSearch();
    }

    public function order() {
        $add_pay ['subject'] = '在线充值：' . 1111;//支付标题
        $add_pay ['body'] = '在线充值：' . 111; //支付内容
        $add_pay ['order_system'] = 'sales_store_recharge';//支付系统
        $add_pay ['order_id'] = 1;//支付系统标识
        $add_pay ['allow_pay_types'] = '';//允许的支付方式
        $add_pay ['amount'] = 111;//1分钱金额
        $add_pay ['show_url'] = 'http://'.config('sys.sys_admin_domain').'/Finance/Store/Index/index'; //支付成功后需要跳转的页面，用户PC
        $add_pay ['pay_user_name'] = 111;//支付用户名称
        $add_pay ['pay_user_id'] = 11111;//支付用户ID
        $add_pay ['notify_url'] = url('api/pay/callback/lwjpay/mutoulaile_order');//
        LwjPay::setAppId('aojia');
        $rePay = LwjPay::chargeCreate($add_pay,config('sys.pay_rsa_public_key'));

        dd($rePay);
        if($rePay['status']==SUCESS_CODE) {
            $rePay = $rePay['data'];
            $this->_objModel->where("id",$res->id)->update(['pay_id'=>$rePay['pay_id']]);
        }else{
            \DB::rollback();
            $this->setMsg('创建支付信息失败' . $rePay['msg']);
            return false;
        }
    }

    public function lwjpay($orderSystem) {
        $data = LwjPay::getNoticeData(config('sys.pay_rsa_public_key'));
        /*
           $data = ($this->_service->find('201612191905137497'));
           if(!$data) {
               return response('successful',200);
           }*/

        $re = '';
        switch($orderSystem) {
            case "sales_store_recharge":
                $obj = new Recharge();
                $re = $obj->setPay($data);
                if(!$re) {
                    return response($obj->getMessage(),400);
                }
                break;
        }
        return response('successful',200);
    }


    public function cart() {
        //登录用户
        auth()->loginUsingId('0022366c96f321b9bec0d0dea263cf01');

        $row = Cart::add(1, '商品1', 1, 101.01);
        $row = Cart::add(2, '商品2', 3, 101.01);
        $row = Cart::add(3, '商品3', 12, 101.01);
        $row = Cart::add(4, '商品4', 6, 101.01);
        $row = Cart::add(5, '商品5', 2, 101.01);
        $row = Cart::add(6, '商品6', 8, 101.01);
        $row = Cart::add(7, '商品7', 2, 101.01);
        $row = Cart::add(8, '商品8', 5, 101.01);
        $row = Cart::add(9, '商品9', 2, 101.01);
        $row = Cart::add(10, '商品10', 3, 101.01);
        $row = Cart::add(11, '商品11', 2, 101.01);
        $row = Cart::add(12, '商品12', 20, 101.01);

        exit('ok');
        //$row = Cart::update(6, 5);//修改商品数量
        //print_r($row);exit;

        //$row = Cart::add(5, '商品3', 3, 101.01);
        //print_r($row->id);exit;
        //$row = Cart::update(5, 50);//修改商品数量
        $row = Cart::remove(11);
        dd($row);
        $data = Cart::all();
        dd($data);



        //测试购物车
        $row = Cart::add(1, '商品1', 1, 101.01);
        $row = Cart::add(1, '商品1', 2, 101.01);

        $row = Cart::update($row->id, ['name'=>'修改后的商品名称']);
        $row = Cart::add(2, '商品2', 2, 101.01);
        $data = Cart::all();
        foreach($data as $item) {
            echo "<BR>RawID:" . $item->id;
            echo "<BR>商品ID:" .$item->goods_id ;
            echo "<BR>商品名称:" .$item->name ;
            echo "<BR>商品价格:" .$item->price ;
            echo "<BR>商品数量:" .$item->quantity ;
            echo "<BR>商品总金额:" .$item->total ;
        }


        $user = auth()->user();

//        $ok = Cart::clean();
        $row = Cart::add(37, 'Item name', 5, 100.00);
//        $row = Cart::add(37, 'Item name', 5, 100.00);
//        $row =  Cart::search(['name'=>'Item name']);
        dd($row->id);exit;
    }

    public function futures() {
        $obj = new GoodsFutures();
        $obj->create(['cate_id'=>1,'name'=>'ddd']);
        $obj->update(1,['cate_id'=>2,'name'=>'修改后的']);
        $obj->up(1);//上架
        $obj->down(1);//下架

        $data  = $obj->getDataByCate(1);
        dd($data);
    }

    public function attr() {





        $obj = Spec::info()->add(['name'=>'尺寸AAA','cate_id'=>1,'sort'=>1,'show'=>1]);
        //修改属性
        $ok = Spec::info()->updateName($obj->id,'尺寸');
        //添加
        $obj = Spec::value()->updates($obj->id,[['name'=>'11M'],['name'=>'12M'],['name'=>"13M"]]);
        dd($obj);




        //添加属性

        $obj = Attribute::info()->add(['name'=>'尺寸AAA','cate_id'=>1,'sort'=>1,'show'=>1]);
        //修改属性
        $ok = Attribute::info()->updateName($obj->id,'尺寸');
        //添加
        $obj = Attribute::value()->updates($obj->id,[['name'=>'11M'],['name'=>'12M'],['name'=>"13M"]]);

        $obj = Attribute::value()->updates(30,[['name'=>'11M'],['name'=>'12M'],['name'=>"13M"],['name'=>'43M']]);

        dd($obj);



        //修改属性
       // $ok = Attribute::info()->updateName($obj->id,'颜色3');

        //删除属性

//        $ok = Attribute::info()->delete($obj->id);
//        var_dump($ok);exit;
        //添加属性值
        //$obj = Attribute::value()->add(['attr_id'=>$obj->id,'name'=>'黑色1','sort'=>3]);
        $obj = Attribute::value()->addNames($obj->id,['白色','黑色']);
        exit('dd');
        //修改属性值
//        $ok = Attribute::value()->updateName($obj->id,'灰色');
        //删除属性值
//        $ok = Attribute::value()->delete($obj->id);


    }

    public function spec() {
        //添加属性
        $obj = Spec::info()->add(['name'=>'颜色2','cate_id'=>1,'sort'=>1,'show'=>1]);
        var_dump($obj);
        //修改属性
        $ok = Spec::info()->updateName($obj->id,'颜色2');
        var_dump($ok);
        //删除属性

//        $ok = Attribute::info()->delete($obj->id);
//        var_dump($ok);
        //添加属性值
        $obj = Spec::value()->add(['spec_id'=>$obj->id,'name'=>'黑色1','sort'=>3]);
        //修改属性值
        var_dump($obj);
        $ok = Spec::value()->updateName($obj->id,'灰色');
        var_dump($ok);
        //删除属性值
        $ok = Spec::value()->delete($obj->id);
        var_dump($ok);

    }



    function cate()
    {
        $cate = Cate::search()->find(1);
        dd($cate);exit;
        //添加分类
//        $cate['name'] = '222';
//        $cate['pid'] = 0;
//        $cate['sort'] = '1';
//        $cate = Cate::info()->add($cate);
//        echo "<hr>添加分类：";
//        var_dump($cate);
//        $ok = Cate::info()->update($cate->id,['name'=>'修改1']);
//        echo "<hr>修改分类：";
//        var_dump($ok);
//        $ok =  Cate::info()->delete($cate->id);
//        echo "<hr>删除分类：";
//        exit;
        //添加分类下的品牌

//        $data = Cate::search()->all();
//
//        //模糊搜索分类
//        $data = Cate::search()
//                ->pushCriteria(new Cate\Criteria\CateLikeName('修改'))//模糊搜索分类名称
//                ->pushCriteria(new Cate\Criteria\CateOrderBySort())//按照排序字段排序
//            ->all();
//        dd($data);
//        $obj = Cate::brand()->add(1,1);
//        var_dump($obj);
        //删除分类下品牌
//        $obj = Cate::brand()->delete(1,1);
        var_dump($obj);

        exit;
    }


    public function brand() {


        //查询品牌
        $data =  Brand::search()->all();
        dd($data);


        ###添加品牌
        $brand['name'] = 'brand';
        $brand['logo'] = 'http://img.liweijia.com/ced9f06837f10adbd000bc69a8cd03b8';
        $brand['description'] = "描述";
        $brand = Brand::info()->add($brand);
        echo "<hr>添加品牌：";
        var_dump($brand->id);
        $ok = Brand::info()->update($brand->id,['name'=>'修改']);
        echo "<hr>修改品牌：";
        var_dump($ok);
        $ok =  Brand::info()->delete($brand->id);
        echo "<hr>删除品牌：";
        var_dump($ok);
    }

    public function goods(){
//        $skuId = 7;
//        $goodsNum = 2;
//        $ok = Commodity::deductStock($skuId,$goodsNum);
//        var_dump($ok);exit;
//        $data = Commodity::search()->goodsCommend(131,2);
//        var_dump($data);exit;
//
//        $data = Commodity::getSku(131,[1,4]);
//        $skuId = 222;


       // $ok = Commodity::sku()->up($skuId);
//        $ok = Commodity::sku()->down($skuId);


//        dd($ok);
        //基本属性
//        $data = Attribute::info()->getByCate(2);
//        dd($data);
        //销售属性
//        $data = Spec::info()->getByCate(2);
//        dd($data);

//        $data = Commodity::search()->findGoods(131);
//        dd($data);
//        dd($data);exit;

        $i=1;
        $data['name'] = '床' .$i;
        $data['brand_id'] = '1';
        $data['cate_id'] = '1';
        $data['imgs'] = [
                        ['path'=>'aaa.jpg','desc'=>'哈哈'],
                        ['path'=>'aaa1.jpg','desc'=>'哈哈1'],
                        ['path'=>'aaa2.jpg','desc'=>'哈哈2'],
                        ];
        $spec['i_14']  = [
                    'spec_value'=>[10,13,16],
                    'price'=>11.22,//价格
                    'market_price'=>1,//市场价格
                    'cost_price'=>1,//成本价格
                    'weight'=>1,//重量
                    'limit_purchase'=>0,//重量
                    'stock'=>0,//重量
                    ];
        $spec['i_15']  = [
            'spec_value'=>[10,13,17],
            'price'=>11.22,//价格
            'market_price'=>1,//市场价格
            'cost_price'=>1,//成本价格
            'weight'=>1,//重量
            'limit_purchase'=>0,//重量
            'stock'=>0,//重量
        ];

        $attr = [55,58];
        $ok = Commodity::info()->add($data,$attr,$spec);
        dd($ok);
        $ok = Commodity::info()->updateImages(129,$data['imgs']);
        exit($ok);exit;

//        $ok = Commodity::info()->update($ok->id,['name'=>'修改后的iphone733dd']);

//        $ok = Commodity::info()->delete($ok->id);
        var_dump($ok);
        exit;

    }

    public function updateGoods() {
        //修改基本属性
        $goods_id = 128;
        $ok = Commodity::info()->update($goods_id,['name'=>'修改后的iphone733dd','store_id'=>1,'store_name'=>'木头来了','content'=>'ddd']);
        //修改属性
        $ok = Commodity::info()->updateAttr($goods_id,[1,13]);
        //修改销售属性

        $spec['i_24']  = [
            'spec_value'=>[2,4],
            'price'=>111111.22,//价格
            'market_price'=>1,//市场价格
            'cost_price'=>1,//成本价格
            'weight'=>1,//重量
            'limit_purchase'=>0,//重量
            'stock'=>0,//重量
        ];
        $ok = Commodity::info()->updateSpec($goods_id,$spec);

        dd($ok);exit;
        exit;
    }

    public function goodsSearch() {

        //查询分类下属性
//        $data = Attribute::info()->getByCate(2);
        //查询分类下销售属性
//        $data = Spec::info()->getByCate(2);

//        $goodsInfo = Commodity::search()->findGoods(22);

        //后端查询
        $search['name'] = "ddd";
        $goodsSearch = Commodity::search()->spu()->pushCriteria(new MultiWhereGoods($search))->paginate(5);
        dd($goodsSearch);


        //后端查询
//        $skuSearch['id'] = '';
        $skuSearch['goods_id'] = '80';
//        $skuSearch['name'] = '了了';//模糊

        $goodsSearch = Commodity::search()->sku()->pushCriteria(new ProductGoods())->pushCriteria(new ProductIds(['126',127,128]))->all();
        dd($goodsSearch);
    }
    




}
