<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2018/2/25
 * Time: 10:13
 */

namespace SimpleShop\Commodity\Blade\Search;


class Total
{
    public static function html()
    {
        $html = <<< 'EOT'
            <dd>搜索结果：<span class="col-main">"<?php echo request()->input('keyword', '')?>"</span> 相关商品共<span class="col-main"><?php echo $data->total()?></span>个</dd>
EOT;

        return static::data() . PHP_EOL . $html;
    }

    /**
     * 获取搜索的数据
     *
     * @return string
     */
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