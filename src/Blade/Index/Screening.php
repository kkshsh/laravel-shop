<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2018/1/24
 * Time: 18:34
 */

namespace SimpleShop\Commodity\Blade\Index;


class Screening
{
    public static function html($id = null)
    {
        $html = <<< 'EOT'
            <div class="stock_tabList w_1200">
    <?php
        unset($search['page']);
        $copySearch = $search;
    ?>
    <?php if(isset($cates)): ?>
        <?php $__currentLoopData = $cates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('web.commodity.goods.index', ['cate_id' => $cate->id])); ?>"
               <?php if($chooseCate->root_id === $cate->id): ?> class="active" <?php endif; ?>><?php echo e($cate->name); ?>

                <em><i class="i0"></i><i class="i1"></i><i class="i2"></i><i class="i3"></i><i class="i4"></i><i
                            class="i5"></i><i class="i6"></i></em>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<div class="stock_tabCent w_1200">
    <dl class="dltab">
        <dt>
            类别：
        </dt>
        <dd class="active">
            <?php
                $copySearch['cate_id'] = $chooseCate->root_id;
            ?>
            <a href="<?php echo e(route('web.commodity.goods.index', ['cate_id' => $chooseCate->root_id])); ?>"
               <?php if($chooseCate->deep === 0): ?> class="active" <?php endif; ?>>不限</a>
            <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secondCate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $copySearch['cate_id'] = $secondCate->id;
                ?>
                <a href="<?php echo e(route('web.commodity.goods.index', ['cate_id' => $secondCate->id])); ?>"
                   <?php if($chooseCate->id == $secondCate->id): ?> class="active" <?php endif; ?>><?php echo e($secondCate->name); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <a class="more" style="display: none">更多<i class="iconfont icon-xia"></i></a>
        </dd>
        <div class="ov_h"></div>
    </dl>
    <?php if(isset($cateBrand) && $cateBrand->isNotEmpty()): ?>
        <?php
            $copySearch = $search;
        ?>
        <dl class="dltab">
            <dt>
                品牌：
            </dt>
            <dd class="active">
                <?php
                    unset($copySearch['brand_id']);
                ?>
                <a href="<?php echo e(route('web.commodity.goods.index', $copySearch)); ?>"
                   <?php if(empty($search['brand_id'])): ?> class="active" <?php endif; ?>>不限</a>
                <?php $__currentLoopData = $cateBrand; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $copySearch['brand_id'] = $brand->brand_id;
                    ?>
                    <a href="<?php echo e(route('web.commodity.goods.index', $copySearch)); ?>"
                       <?php if(! empty($search['brand_id']) && $search['brand_id'] == $brand->brand_id): ?> class="active" <?php endif; ?>><?php echo e($brand->brand_name); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <a class="more" style="display: none">更多<i class="iconfont icon-xia"></i></a>
            </dd>
            <div class="ov_h"></div>
        </dl>
    <?php endif; ?>

    <?php if(isset($attrs) && $attrs->isNotEmpty()): ?>
        <?php $__currentLoopData = $attrs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <dl class="dltab">
                <dt>
                    <?php echo e($key); ?>：
                </dt>
                <dd class="active">
                    <?php
                        $copySearch = $search;
                        $noLimit = true;
                        // 去掉对应的值
                        if (! empty($copySearch['attr_ids'])) {
                            $copySearch['attr_ids'] = explode('|', $copySearch['attr_ids']);
                            foreach ($value as $item) {
                                if (false !== $needle = array_search($item->attr_id, $copySearch['attr_ids'])) {
                                    array_splice($copySearch['attr_ids'], $needle, 1);
                                    $noLimit = false;
                                }
                            }
                            $copySearch['attr_ids'] = implode('|', $copySearch['attr_ids']);
                        }
                    ?>
                    <a href="<?php echo e(route('web.commodity.goods.index', $copySearch)); ?>"
                       <?php if($noLimit): ?> class="active" <?php endif; ?>>不限</a>
                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $tempSearch = $search;
                            if (empty($tempSearch['attr_ids'])) {
                                $tempSearch['attr_ids'] = [];
                            } else {
                                $tempSearch['attr_ids'] = explode('|', $tempSearch['attr_ids']);
                            }

                            if (false !== $needle = array_search($item->attr_id, $tempSearch['attr_ids'])) {
                                $isOk = true;
                            } else {
                                $isOk = false;
                                $delete = array_values(array_intersect($tempSearch['attr_ids'], $value->pluck('attr_id')->all()));

                                if (count($delete) > 0) {
                                    $delete = $delete[0];
                                    if (false !== $needle = array_search($delete, $tempSearch['attr_ids'])) {
                                        array_splice($tempSearch['attr_ids'], $needle, 1);
                                    }

                                }
                                $tempSearch['attr_ids'][] = $item->attr_id;
                            }

                            $tempSearch['attr_ids'] = implode('|', $tempSearch['attr_ids']);

                        ?>
                        <a href="<?php echo e(route('web.commodity.goods.index', $tempSearch)); ?>"
                           <?php if($isOk): ?> class="active" <?php endif; ?>><?php echo e($item->attr_value); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <a class="more" style="display: none">更多<i class="iconfont  icon-xia"></i></a>
                    <div class="ov_h"></div>
                </dd>
            </dl>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <dl class="dltab num">
        <dt>价格：</dt>
        <dd>
            <form action="<?php echo e(request()->fullUrl()); ?>" method="post">
                <input type="text" name="min_price" value="<?php echo e(isset($search['min_price']) ? $search['min_price'] : 0); ?>"/><span>—</span><input
                        type="text" name="max_price" value="<?php echo e(isset($search['max_price']) ? $search['max_price'] : 0); ?>"/>
                        <?php echo csrf_field()?>
                <input type="submit" class="btn btn-primary" value="提交">
            </form>
        </dd>
        <div class="ov_h"></div>
    </dl>
</div>
<?php $__env->startSection('footer'); ?>
    ##parent-placeholder-d7eb6b340a11a367a1bec55e4a421d949214759f##
    <script type="text/javascript">
        !(function (w) {
            function goodsTab() {
                this.tabThis = ".stock_tabCent .dltab";
                this.init();
            };
            goodsTab.prototype.isSearch = function ($this) {
                var isWidth = 0,
                    islength = $this.find("a").length;
                $.each($this.find("a"), function (index, val) {
                    if (islength >= index) {
                        isWidth = isWidth + $(this).width() + 30;
                    }
                });
                if (isWidth >= $this.width()) {
                    return true;
                } else {
                    return false;
                }
            };
            goodsTab.prototype.init = function () {
                var $this = this;
                $.each($(this.tabThis), function (index, val) {
                    if ($this.isSearch($(this).find("dd"))) {
                        $(this).find("dd .more").show().unbind('click').click(function (event) {
                            /* Act on the event */
                            if ($(this).text() == "更多") {
                                $(this).html('收起<i class="iconfont  icon-shang"></i>');
                                $(this).parents("dd").removeClass('active');
                            } else {
                                $(this).html('更多<i class="iconfont  icon-xia"></i>');
                                $(this).parents("dd").addClass('active');
                            }

                        });
                        ;
                    }

                });
            };
            goodsTab.prototype.list = function () {
                // body...
            };
            new goodsTab();
        })(window);
    </script>
<?php $__env->stopSection(); ?>
EOT;


        return static::data($id) . PHP_EOL . $html;
    }

    public static function data($id = null)
    {
        return "<?php
    \$search = request()->all();
    \$cate = App::make(\SimpleShop\Cate\Contracts\Cate::class);
    \$cates = \$cate->getTops();
    
    if (empty(\$search['cate_id'])) {
        \$search['cate_id'] = \$cates->first()->id;
    }
    \$cate = App::make(\SimpleShop\Cate\Contracts\Cate::class);
    \$chooseCate = \$cate->show(\$search['cate_id']);
    \$cate = App::make(\SimpleShop\Cate\Contracts\Cate::class);
    \$leaves = \$cate->getLeaves(\$chooseCate->root_id);
    
    // 获取分类对应的品牌
    \$brand = App::make(\SimpleShop\CateBrand\CateBrandImpl::class);
    if (\$chooseCate->deep > 0) {
        \$cateBrand = \$brand->index(['cateId' => \$chooseCate->id]);
    } else {
        \$cateBrand = \$brand->index(['cateIds' => \$leaves->pluck('id')->all()], 10000);
    }
    \$cateBrand = \$cateBrand->unique('brand_id');

    // 获取分类对应的搜索项
    \$cateAttr = App::make(\SimpleShop\Search\AttrParam::class);
    if (\$chooseCate->deep > 0) {
        \$attrs = \$cateAttr->lists(['cate_id' => [\$chooseCate->id]]);
    } else {
        \$attrs = \$cateAttr->lists(['cate_id' => \$leaves->pluck('id')->all()]);
    }
    // 把attr分类处理
    \$attrs = \$attrs->groupBy('tag');
?>";
    }
}