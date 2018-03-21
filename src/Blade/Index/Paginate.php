<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2018/2/1
 * Time: 10:48
 */

namespace SimpleShop\Commodity\Blade\Index;


class Paginate
{
    /**
     * @return string
     */
    public static function html()
    {
        $html = <<<'EOT'
        <?php $search = request()->all();
            if(isset($search)): ?>
                <?php echo $list->appends($search)->links('vendor.pagination.goods_list'); ?>

            <?php else: ?>
                <?php echo $list->links('vendor.pagination.goods_list'); ?>

            <?php endif; ?>
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
        $spuSearch = App::make('SimpleShop\Search\SpuSearch');
        $list = $spuSearch->search($search, ['id' => 'desc'], 20, ['*'], request()->input('page', 1));
    ?>
EOT;

    }
}