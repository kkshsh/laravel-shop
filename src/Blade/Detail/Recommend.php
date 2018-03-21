<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 07/03/2018
 * Time: 10:37
 */

namespace SimpleShop\Commodity\Blade\Detail;


class Recommend
{
    public static function data($perPage)
    {
        return <<< EOT
            <?php
                \$commodity = app(\SimpleShop\Commodity\Commodity::class);
                \$recommend = \$commodity->getRecommendHotList(1, $perPage);
            ?>
EOT;
    }

    public static function html($perPage)
    {
        $html = <<< 'EOT'
            <div class="stock_l_cent stock_l_div02">
                <p class="stock_bt"><i class="fl"></i>相关推荐</p>
                <ul class="ullit">
                    <?php $__currentLoopData = $recommend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(route('web.commodity.goods.detail', ['id' => $item->sku_id])); ?>" class="img"><img src="<?php echo e($item->cover_path); ?>?x-oss-process=image/resize,m_fixed,h_100,w_100" alt="<?php echo e($item->description); ?>"></a>
                            <div class="text">
                                <div><a href="<?php echo e(route('web.commodity.goods.detail', ['id' => $item->sku_id])); ?>"><?php echo e(str_limit($item->name, 30)); ?></a></div>
                                <p><span class="col-main">￥<?php echo e($item->price); ?></span></p>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
EOT;

        return static::data($perPage) . PHP_EOL . $html;
    }
}