<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2018/1/20
 * Time: 16:56
 */

namespace SimpleShop\Commodity\Blade\Detail;


class Attr
{
    public static function html($id)
    {
        $html = <<< 'EOT'
          <div class="stock_bt">
    <a href="" class="active">商品参数</a>
</div>
<dl class="dllit">
    <dt>产品参数：</dt>
    <?php $valueName = '';?>
    <?php $__currentLoopData = $detail->goodsInfo->attr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $valueName .= $value['attr_value_name'];
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <dd><?php echo e($key); ?>: <?php echo e($valueName); ?></dd>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="ov_h"></div>
</dl>
EOT;
        return static::data($id)  . PHP_EOL . $html;
    }

    public static function data($id)
    {
        return "<?php \$product = app()->make(\SimpleShop\Commodity\Sku::class);
            \$detail = \$product->find($id); \$attr = App::make(\SimpleShop\Commodity\Attr::class);
    \$detail->goodsInfo->attr = \$attr->groupGoodsItem(\$detail->goods_id)?>";
    }
}