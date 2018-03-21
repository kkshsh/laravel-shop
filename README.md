# 商品系统

还没想好扎个做


## 安装

使用
`composer require simple-shop/laravel-shop`

## 配置

### Laravel应用


2. 创建配置和迁移文件
```shell
php artisan vendor:publish
```

3. 可以选择修改根目录下的`config/commodity.php`中对应的修改设置

4. 执行迁移命令,生成数据表
```shell
php artisan migrate
```



## 分类

###添加分类
	$cate['name'] = '222';//分类名称
	$cate['pid'] = 0;//父级ID
	$cate['sort'] = '1';//排序
	$cate = Cate::info()->add($cate);
###修改分类

	Cate::info()->update($cate->id,['name'=>'修改分类名字']);

###删除分类
$ok =  Cate::info()->delete($cate->id);

###查询分类下所有数据
	$data = Cate::search()->all();

###模糊搜索分类
  	$data = Cate::search()
      ->pushCriteria(new Cate\Criteria\CateLikeName('修改'))//模糊搜索分类名称
       ->pushCriteria(new Cate\Criteria\CateOrderBySort())//按照排序字段排序
  	->all();
## 品牌
###添加品牌
    $brand['name'] = 'brand';
    $brand['logo'] = 'http://img.liweijia.com/ced9f06837f10adbd000bc69a8cd03b8';
    $brand['description'] = "描述";
    $brand = Brand::info()->add($brand);
###修改品牌
	$ok = Brand::info()->update($brand->id,['name'=>'修改']);
###删除品牌
	Brand::info()->delete($brand->id);
##属性

###添加属性
	$obj = Attribute::info()->add(['name'=>'颜色1','cate_id'=>1,'sort'=>1,'show'=>1]);

###修改属性
	$ok = Attribute::info()->updateName($obj->id,'颜色2');	

###添加属性值
	Attribute::value()->add(['attr_id'=>$obj->id,'name'=>'黑色1','sort'=>3]);
###修改属性值
	Attribute::value()->updateName($obj->id,'灰色');
###查询分类下属性
	$data = Attribute::info()->getByCate(2);

##销售属性
###添加属性
	Spec::info()->add(['name'=>'颜色2','cate_id'=>1,'sort'=>1,'show'=>1]);

###修改属性
	Spec::info()->updateName($obj->id,'颜色2');
###添加属性值
	Spec::value()->add(['spec_id'=>$obj->id,'name'=>'黑色1','sort'=>3]);
###修改属性值
	Spec::value()->updateName($obj->id,'灰色');
###删除属性值
	Spec::value()->delete($obj->id);

###查询分类下销售属性
	//$data = Spec::info()->getByCate(2);


##商品
###商品添加
	$i=1;
    $data['name'] = '欧美爆款木材' .$i;
    $data['brand_id'] = '1';
    $data['cate_id'] = '1';

    $spec['i_14']  = [
                'spec_value'=>[1,4],
                'price'=>11.22,//价格
                'market_price'=>1,//市场价格
                'cost_price'=>1,//成本价格
                'weight'=>1,//重量
                'limit_purchase'=>0,//重量
                'stock'=>0,//重量
                ];
    $spec['i_24']  = [
        'spec_value'=>[2,4],
        'price'=>11.22,//价格
        'market_price'=>1,//市场价格
        'cost_price'=>1,//成本价格
        'weight'=>1,//重量
        'limit_purchase'=>0,//重量
        'stock'=>0,//重量
    ];
    $attr = [1,5];
    $ok = Commodity::info()->add($data,$attr,$spec);
###商品修改
    //修改基本属性
    $goods_id = 128;
    $ok = Commodity::info()->update($goods_id,['name'=>'修改后的iphone733dd','store_id'=>1,'store_name'=>'木头来了','content'=>'ddd']);
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

	//上架所有商品
	$ok = Commodity::info()->up($goods_id);
	//下架所有商品
	$ok = Commodity::info()->down($goods_id);
	//上架SKU商品
	$ok = Commodity::sku()->up($goods_id);
	//上架SKU商品
	$ok = Commodity::sku()->up($goods_id);
###商品详情（全）
	$goodsInfo = Commodity::search()->findGoods(22);
###商品查询（列表）
	后端查询
	$search['name'] = "ddd";
    $goodsSearch = Commodity::search()->spu()->pushCriteria(new MultiWhereGoods($search))->paginate(5);
    dd($goodsSearch);

###SKU查询
	$goodsSearch = Commodity::search()->sku()->pushCriteria(new ProductGoods())->pushCriteria(new ProductIds(['126',127,128]))->all();
     dd($goodsSearch);

## License

MIT
