<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2018/1/18
 * Time: 10:46
 */

namespace SimpleShop\Commodity\Blade\Detail;


class Crumb
{
    /**
     * @param $id
     *
     * @return string
     */
    public static function html($id)
    {
        $html = <<< 'EOT'
          <div class="fl">
                <i></i>
                <a href="<?php echo route('web.index') ?>">首页</a><span>&gt;</span>
                <a href="<?php echo route('web.commodity.goods.index') ?>">商品</a><span>&gt;</span>
                <a href="<?php echo route('web.commodity.goods.index', ['cate_id' => $detail->goodsInfo->cateInfo->id]) ?>"
                   class="detail"><?php echo $detail->goodsInfo->cateInfo->name ?></a>
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