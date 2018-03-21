<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2018/1/20
 * Time: 17:06
 */

namespace SimpleShop\Commodity\Blade\Detail;


class Content
{
    public static function html($id)
    {
        $html = <<< 'EOT'
          <div class="imglist">
    <?php echo $detail->goodsInfo->content; ?>
</div>
EOT;
        return static::data($id)  . PHP_EOL . $html;
    }

    public static function data($id)
    {
        return "<?php \$product = app()->make(\SimpleShop\Commodity\Sku::class);
            \$detail = \$product->find($id); ?>";
    }
}