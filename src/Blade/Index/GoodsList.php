<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2018/2/1
 * Time: 10:17
 */

namespace SimpleShop\Commodity\Blade\Index;


class GoodsList
{
    public static function html()
    {
        $html = <<<'EOT'
        <ul class="icon_imglist">
            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <div class="cent">
                        <a href="<?php echo e(route('web.commodity.goods.detail', ['id' => $item->sku_id])); ?>" class="img"><img src="<?php echo e($item->cover_path); ?>?x-oss-process=image/resize,m_fixed,h_250,w_250" alt="<?php echo e($item->description); ?>"></a>
                        <a href="<?php echo e(route('web.commodity.goods.detail', ['id' => $item->sku_id])); ?>" class="bt"><?php echo e($item->name); ?></a>
                        <p class="money"><span>¥</span><?php if (! is_null($item->price)) echo e($item->price); else echo "暂无" ; ?></p>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="ov_h"></div>
        </ul>
EOT;

        return static::data() . PHP_EOL . $html;
    }

    /**
     * @return string
     */
    public static function data()
    {
        return <<<'EOT'
        <?php
        $search = request()->all();
        if (isset($search['cate_id'])) {
            $cate = App::make('SimpleShop\Cate\CateImpl');
            $search['cate_id'] = $cate->getChildIds($search['cate_id'])->all();
        }
        
        if (isset($search['attr_ids']) && $search['attr_ids'] == "") {
            unset($search['attr_ids']);
        }
        
        if (empty($search['min_price']) && empty($search['max_price'])) {
            unset($search['min_price']);
            unset($search['max_price']);
        }
        $spuSearch = App::make('SimpleShop\Search\SpuSearch');
        $list = $spuSearch->search($search, ['id' => 'desc'], 20, ['*'], request()->input('page', 1));
    ?>
EOT;
    }
}