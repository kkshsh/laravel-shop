<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 21/03/2018
 * Time: 18:28
 */

namespace SimpleShop\Commodity\Blade\Detail;


class Faq
{
    public static function data($id)
    {
        $data = <<< 'EOT'
        <?php
            /** @var \SimpleShop\Commodity\Faq $faqService */
        $faqService = App::make(\SimpleShop\Commodity\Faq::class);
        $faqs = $faqService->getListByGoodsId($id);
        ?>
EOT;

        return $data;
    }

    public static function html($id)
    {
        $html = <<< 'EOT'
            <div class="askAnswer">
                        <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="askAnswer-item" data-questionid="5821204" data-answercount="30" data-currpage="0">
                                <div class="ask">
                                    <i class="icon-ask">问</i>
                                    <div class="item-con">
                                        <p><?php echo $faq->question; ?></p>
                                    </div>
                                </div>
                                <div class="answer">
                                    <i class="icon-answer">答</i>
                                    <div class="item-con">
                                        <p><?php echo $faq->answer; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
EOT;

        return static::data($id) . PHP_EOL . $html;
    }
}