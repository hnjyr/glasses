<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/admin/css/common.css" type="text/css">
    <script src="assets/admin/js/flexible.js"></script>
    <style>
        body {
            background-color: #F8F8F8;
        }

        .item {
            background: #fff;
            border-radius: .1875rem;
            margin: .4rem;
            margin-top: .625rem;
        }

        .content {
            margin: 0rpx .46875rem;
        }

        .top {
            border-bottom: 1px solid #E2E2E2;
            padding: .390625rem .46875rem .28125rem .46875rem;
        }

        .three {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: PingFangSC-Regular, PingFang SC;
            font-weight: 400;
            line-height: .4375rem;
        }

        .three_left {
            font-size: .375rem;
            color: #999999;
        }

        .three_right {
            font-size: .4375rem;
            color: #333;
            line-height: .4375rem;
            width: 3.125rem;
            text-align: right;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

        }

        .two_box {
            margin-bottom: .2rem;
        }

        .two {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: .26875rem;
            vertical-align: top;
        }

        .one {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .one_left {
            font-size: .4375rem;
            font-family: PingFangSC-Semibold, PingFang SC;
            font-weight: 600;
            color: #333;
            line-height: .4375rem;
        }

        .one_right {
            font-size: .375rem;
            font-family: PingFangSC-Regular, PingFang SC;
            font-weight: 500;
            color: #05885A;
            line-height: .375rem;
        }

        .two_left {
            font-size: .375rem;
            font-family: PingFangSC-Regular,PingFang SC;
            font-weight: 400;
            color: #999999;
            line-height: .375rem;
        }

        .two_left .it {
            margin-bottom: .3125rem;
        }

        .two_left text:nth-child(1) {
            display: inline-block;
            font-size: .4375rem;
            color: #333;
            line-height: .4375rem;
            margin-right: .15625rem;
            font-weight: 500;
            width: 2.65625rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .two_right {
            font-size: .3125rem;
        }

        .bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 500;
            font-size: .4rem;
            color: #333;
            line-height: .4375rem;
            padding: .4375rem .34375rem .40625rem .34375rem;
        }
        .me{
            color: #fff;
            background-color: #0DA56F;
            font-size: .5rem;
            height: 1.25rem;
            line-height: 1.25rem;
            text-align: center;
        }
    </style>
</head>

<body>
<div class="me">我的订单</div>
<?php if (!$list->isEmpty()): foreach ($list as $item): ?>
<div class="item" >
    <div class="top">
        <div class="one">
            <div class="one_left">
                <image src="assets/admin/img/shop.png" style="width: .46875rem;height: .4375rem;margin-bottom: -.0625rem;margin-right: .2125rem; display: inline-block;" mode=""></image>
                <span><?= $item['shop_name'] ?></span>
            </div>
            <div class="one_right"><a href="<?= url('wxapp.index/indexList',['order_id' => $item['id']]) ?>">查看详情</a></div>
        </div>
        <!-- 循环是根据索引以及状态判断是否是关闭状态和索引为0的才显示，当状态为展开时都显示 -->
        <div class="two_box">
            <div class="two">
                <div class="two_left">
                    <div class="it">
                        <span>镜框型号:<?= $item['frame'] ?></span>
                        <span>x <?= $item['frame_num'] ?></span>
                    </div>
                    <div >
                        <div class="it">
                            <span>镜片型号:<?= $item['lens'] ?></span>
                            <span>x <?= $item['lens_num'] ?></span>
                        </div>
                        <?php if($item['glasses_case_num']):?>
                            <div class="it">
                                <span>眼镜盒:<?= $item['glasses_case_price'] ?> x <?= $item['glasses_case_num'] ?></span>
                            </div>
                        <?php endif;?>
                        <?php if($item['glasses_case_num']):?>
                            <div class="it">
                                <span>眼镜盒:<?= $item['glasses_cloth_price'] ?> x <?= $item['glasses_cloth_num'] ?></span>
                            </div>
                        <?php endif;?>
                        <?php if($item['contact_lens']):?>
                        <div class="it">
                            <span><?= $item['contact_lens'] ?></span>
                            <span>x <?= $item['contact_lens_num'] ?></span>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="three">
            <div class="three_left"><?= date('Y-m-d H:i:s',$item['create_time']) ?></div>
            <div class="three_right"><?= $item['pay_total'] ?></div>
        </div>
    </div>
    <div class="bottom">
        <div class="userName">
            客户姓名：<?= $item['user_name'] ?>
        </div>
        <div class="money">
            共<?= $item['goods_count'] ?>件  订单总额:￥<?= $item['pay_total'] ?>
        </div>
    </div>
</div>
<?php endforeach; else: ?>
    <tr>
        <td colspan="9" class="am-text-center">暂无记录</td>
    </tr>
<?php endif; ?>
</body>
<script src="assets/admin/js/jQuery.min.js"></script>


</html>