<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2018/2/25
 * Time: 10:51
 */

namespace SimpleShop\Commodity\Blade\Search;


class Image
{
    public static function html()
    {
        $html = <<< 'EOT'
        <?php if ($data->total() > 0): ?>
            <ul class="icon_imglist">
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <div class="cent">
                <a href="<?php echo route('web.commodity.goods.detail', ['id' => $item->sku_id])?>" class="img"><img src="<?php echo $item->cover_path?>?x-oss-process=image/resize,m_fixed,h_250,w_250" alt="<?php echo $item->description?>"></a>
                <a href="<?php echo route('web.commodity.goods.detail', ['id' => $item->sku_id])?>" class="bt"><?php echo $item->name?></a>
                <p class="money"><span>¥</span>{{ $item->price }}</p>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="stock_def">
            <div class="search">
                <div class="img">
                    <p class="bt">抱歉，没有找到与“<span class="col-main"><?php echo e(request()->input('keyword', "")); ?></span>”相关的产品</p>
                    <dl>
                        <dt>建议您：</dt>
                        <dd>1.查看输入文字是否有误</dd>
                        <dd>2.调整关键字。如将“克诺斯邦板高级刨花板”改为“克诺斯邦板 板材”。</dd>
                    </dl>
                </div>
                <div class="form" style="left: 70px;">
                <span class="fl text">
                    重新搜索
                </span>
                    <form action="/search" method="get">
                        <input type="text" name="keyword" class="text" value="" placeholder="">
                        <input type="submit" class="button" value="搜索">
                    </form>
                </div>
            </div>
        </div>
    <?php endif;?>
    <div class="ov_h"></div>
</ul>
EOT;

        return static::data() . PHP_EOL . $html;
    }

    public static function data()
    {
        return <<< 'EOT'
        <?php
            $keyword = request()->input('keyword', '');
            /** @var \SimpleShop\Search\SpuSearch $spuSearch */
            $spuSearch = App::make(\SimpleShop\Search\SpuSearch::class);
            $data = $spuSearch->search(['keyword' => $keyword]);
        ?>
EOT;

    }
}