<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/admin/css/common.css" type="text/css">
    <script src="assets/admin/js/flexible.js"></script>
    <style>
        .content {
            padding: 0 .3rem;
        }

        .img {
            width: .1rem;
            height: .5rem;
            margin-bottom: -0.09375rem;
            margin-right: .1875rem;
        }

        .one_top {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            font-size: .46875rem;
            font-weight: 550;
            color: rgba(51, 51, 51, 1);
            line-height: .625rem;
            margin: .2rem 0;
        }

        .one_bottom {
            margin: .375rem 0 .625rem 0;
            padding: .375rem .5rem;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0px 0px .4375rem 0px rgba(160, 160, 160, 0.15);
            border-radius: .1875rem;
            font-size: .5rem;
            font-weight: 400;
            color: rgba(102, 102, 102, 1);
            line-height: .625rem;
        }

        .one_bottom span {
            display: inline-block;
            width: 4.6875rem;
            margin-bottom: .5rem;
            font-size:.5rem;
            font-weight: 400;
            color: rgba(51, 51, 51, 1);
            line-height: .625rem;
        }

        .hang {
            margin-bottom: .21875rem;
        }

        .hang:nth-child(4) {
            margin-bottom: 0rem;
        }

        .pd {
            box-shadow: 0px 0px .421875rem  0px rgba(160, 160, 160, 0.15);
            padding: .484375rem 0px .484375rem 1rem;
        }

        .pd span {
            font-size: .46875rem;
            font-weight: 400;
            color: #333;
            line-height: .65625rem;
        }

        .pd span:nth-child(1) {
            margin-right: 1.125rem;
        }

        .left_eye {
            box-shadow: 0px 0px .421875rem 0px rgba(160, 160, 160, 0.15);
            border-radius: .15625rem;
            margin-bottom: .375rem;
            margin-top: .375rem;
        }

        .left_eye_bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: .46875rem;
            font-family: PingFangSC-Regular, PingFang SC;
            font-weight: 400;
            color: rgba(51, 51, 51, 1);
            line-height: .65625rem;
        }

        .left_eye_bottom>div {
            width: 25%;
            text-align: center;
            border-right: 1px solid #E2E2E2;
            padding: .453125rem 0;
        }
        .left_eye_bottom>div:last-child {
            border-right: 0px;
        }

        .left_eye_top {
            padding: .515625rem 0 .515625rem  .9375rem;
            font-size: .46875rem;
            font-weight: 400;
            color: #333;
            line-height: .65625rem;
            border-bottom: 1px solid #E2E2E2;
        }
    </style>
</head>

<body>
<div class="content">
    <div class="one">
        <div class="one_top">
            <image src="assets/admin/img/boix.png" mode="" class="img"></image>
            <span>下单信息</span>
        </div>
        <div class="one_bottom">
            <div class="hang">下单时间：<?= date('Y-m-d H:i:s',$list['create_time']) ?></div>
            <div class="hang">订单金额：<?= $list['total'] ?></div>
            <div class="hang">折扣金额：<?= $list['discount'] ?></div>
            <div class="hang">实付金额：<?= $list['pay_total'] ?></div>
        </div>
    </div>
    <div class="one">
        <div class="one_top">
            <image src="assets/admin/img/boix.png" mode="" class="img"></image>
            <text>视力度数</text>
        </div>
        <div class="ad-box_one">
            <div class="left_eye">
                <div class="left_eye_top">左眼</div>
                <div class="left_eye_bottom">
                    <div class="">
                        <div>球镜</div>
                        <span><?= $list['left_ball_mirror'] ?></span>
                    </div>
                    <div class="">
                        <div>柱镜</div>
                        <span><?= $list['left_cylinder'] ?></span>
                    </div>
                    <div class="">
                        <div>轴线</div>
                        <span><?= $list['left_axis'] ?></span>
                    </div>
                    <div class="">
                        <div>ADD</div>
                        <span><?= $list['left_add'] ?></span>
                    </div>
                </div>
            </div>
            <div class="left_eye">
                <div class="left_eye_top">右眼</div>
                <div class="left_eye_bottom">
                    <div class="">
                        <div>球镜</div>
                        <span><?= $list['right_ball_mirror'] ?></span>
                    </div>
                    <div class="">
                        <div>柱镜</div>
                        <span><?= $list['right_cylinder'] ?></span>
                    </div>
                    <div class="">
                        <div>轴线</div>
                        <span><?= $list['right_axis'] ?></span>
                    </div>
                    <div class="">
                        <div>ADD</div>
                        <span><?= $list['right_add'] ?></span>
                    </div>
                </div>
            </div>
            <div class="pd">
                <span>瞳距</span>
                <span><?= $list['distance'] ?></span>
            </div>
        </div>
    </div>
    <div class="one">
        <div class="one_top" style="margin-top: .78125rem;">
            <image src="assets/admin/img/boix.png" mode="" class="img"></image>
            <span>服务人员信息</span>
        </div>
        <div class="one_bottom" style="padding: .515625rem .5rem;">
            <span>销售员：<?= $list['sales'] ?></span>
            <span>验光师：<?= $list['optometry'] ?></span>
            <span>加工师：<?= $list['working'] ?></span>
            <span>收银员：<?= $list['cash'] ?></span>
            <span style="margin-bottom: 0;">经手人：<?= $list['handle'] ?></span>
        </div>
    </div>
</div>
</body>

</html>