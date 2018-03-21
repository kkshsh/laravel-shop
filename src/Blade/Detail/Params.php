<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2018/1/20
 * Time: 16:36
 */

namespace SimpleShop\Commodity\Blade\Detail;


class Params
{
    /**
     * @param $id
     *
     * @return string
     */
    public static function html($id)
    {
        $html = <<< 'EOT'
          <div class="divfr fr">
    <h1 class="finbt"><div id="choose_sku_name"><?php echo e($detail->name); ?></div><span>
                            <?php echo e($detail->goodsInfo->storeInfo->store_name); ?></span></h1>
    <p class="introduce"><?php echo e($detail->goodsInfo->description); ?></p>
    <ul class="ullit">
        <li class="price">
            <p>
                <span class="textfl">商城价：</span>
                <span class="pfl price price-change">￥<?php echo e($detail->price); ?> </span><span>元/<?php echo e(isset($detail->goodsInfo->units->name) ? $detail->goodsInfo->units->name : '件'); ?></span>
                &nbsp;&nbsp;
                
            </p>
            <div class="ov_h"></div>
        </li>
        <li>
            <span class="textfl2">品牌：<?php echo e(isset($detail->goodsInfo->brandInfo->name) ? $detail->goodsInfo->brandInfo->name : '暂无品牌'); ?></span>
        </li>
        <li>
            <span class="textfl2">起订量：<?php echo e($detail->goodsInfo->begin_num); ?><?php echo e(isset($detail->goodsInfo->units->name) ? $detail->goodsInfo->units->name : '件'); ?> 起</span>
        </li>
    </ul>
    <ul class="attrlit" id="spec_list">
        <input type="hidden" value="<?php echo e($skuList->toJson()); ?>" id="sku_json">
        <input type="hidden" value="<?php echo e($detail['id']); ?>" id="sku_id">
        <input type="hidden" value="<?php echo e($detail['name']); ?>" id="sku_name">
        <input type="hidden" value="<?php echo e($detail['price']); ?>" id="sku_price">
        <input type="hidden" value="<?php echo e($detail['spec']); ?>" id="choose_sku_spec">
        <input type="hidden" value="<?php echo e($detail->goodsInfo->id); ?>" id="spu_id">
        <?php $skuArray = json_decode($detail['spec'], true)?>
        
        <?php $__currentLoopData = $detail->goodsInfo->spec; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <span class="fl textfl"><?php echo e($index); ?>：</span>
                <div class="fl">
                    <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label data-spec-id="<?php echo e($value['spec_value_id']); ?>"
                               <?php if(in_array($value['spec_value_id'], $skuArray)): ?> class="fin_attr_active fin"
                               <?php else: ?> class="fin_attr fin" <?php endif; ?>><?php echo e($value['spec_value_name']); ?><input
                                    type="checkbox"
                                    value="" name=""/><em
                                    class="icon"></em></label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="ov_h"></div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <li>
            <span class="fl textfl">数量：</span>
            <div class="fl">
                <div class="icon_cal" min="<?php echo e(isset($detail->goodsInfo->begin_num) ? $detail->goodsInfo->begin_num : 0); ?>"
                     max="<?php echo e($detail['stock']); ?>" id="num">
                    <a href="javascript:" class="change-num">-</a>
                    <input id="buy_num" type="text" value="1"/>
                    <a href="javascript:" class="change-num">+</a>
                </div>
            </div>
            <div class="ov_h"></div>
        </li>
    </ul>
    <div class="tab_but" id="button_area">
        <?php if($detail['status'] == 0): ?>
            <a href="javascript:" class="btn btn-default btn-max"><i class="iconfont icon-gouwuche"></i>已下架</a>
        <?php elseif($detail['stock'] < $detail->goodsInfo->begin_num): ?>
            <a href="javascript:" class="btn btn-default btn-max"><i class="iconfont icon-gouwuche"></i>已售罄</a>
        <?php else: ?>
            <a href="<?php echo route('web.order.buyNow', ['goods_id' => $detail['id'], 'quantity' => $detail->goodsInfo->begin_num]); ?>"
               class="btn btn-primary btn-max" id="buy_now">立即购买</a>
            <a href="javascript:" class="btn btn-default btn-max" id="add_cart"><i
                        class="iconfont icon-gouwuche"></i>加入购物车</a>
        <?php endif; ?>
    </div>
</div>
EOT;
        return static::data($id)  . PHP_EOL . $html;

    }

    /**
     * @param $id
     *
     * @return string
     */
    public static function data($id)
    {
        return "<?php \$product = app()->make(\SimpleShop\Commodity\Sku::class);
            \$detail = \$product->find($id); \$spec = App::make(\SimpleShop\Commodity\Spec::class);
    \$detail->goodsInfo->spec = \$spec->groupGoodsItem(\$detail->goods_id);
    \$skuList = \$product->getSkuListByGoodsId(\$detail->goods_id);?>";
    }
}