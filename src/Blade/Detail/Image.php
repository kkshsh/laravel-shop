<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2018/1/20
 * Time: 15:43
 */

namespace SimpleShop\Commodity\Blade\Detail;


class Image
{
    /**
     * @param $id
     *
     * @return string
     */
    public static function html($id)
    {
        $html = <<< 'EOT'
          <div class="divfl fl">
    <div class="fin_ban" id="fin_ban" ui-switch={addlit:false,time:999999999}>
        <ul class="ullit">
            <?php $__currentLoopData = $detail->goodsInfo->pics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($key==0): ?>
                    <li>
                        <img src="<?php echo e($pic->path); ?>?x-oss-process=image/resize,m_fixed,h_500,w_500"/>
                    </li>
                <?php else: ?>
                    <li style="display: none;">
                        <img src="<?php echo e($pic->path); ?>?x-oss-process=image/resize,m_fixed,h_500,w_500"/>
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <div class="ulodd">
            <?php $__currentLoopData = $detail->goodsInfo->pics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($key==0): ?>
                    <a class="compng ayes"><img
                                data-original="<?php echo e($pic->path); ?>?x-oss-process=image/resize,m_fixed,h_100,w_100"
                                alt="<?php echo e($pic->desc); ?>"
                                src="<?php echo e($pic->path); ?>?x-oss-process=image/resize,m_fixed,h_100,w_100"
                                style="display: inline;"></a>
                <?php else: ?>
                    <a class="compng "><img
                                data-original="<?php echo e($pic->path); ?>?x-oss-process=image/resize,m_fixed,h_100,w_100"
                                alt="<?php echo e($pic->desc); ?>"
                                src="<?php echo e($pic->path); ?>?x-oss-process=image/resize,m_fixed,h_100,w_100"
                                style="display: inline;"></a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div class="text">
        <a href="javascript:" id="favorite"><i class="iconfont icon-guanzhu"></i>关注</a>
        <a href="javascript:;" ui-share data-type="box"
           data-pic="<?php echo e(isset($detail->pics->first()->path) ? $detail->pics->first()->path : ''); ?>"
           data-title="<?php echo e($detail->name); ?>"
           data-description="<?php echo e($detail->description); ?>"
        ><i class="iconfont icon-fengxiang"></i>分享</a>
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
            \$detail = \$product->find($id); ?>";
    }
}