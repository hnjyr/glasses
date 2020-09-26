<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title><?= $setting['store']['values']['name'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/common/i/favicon.ico"/>
    <meta name="apple-mobile-web-app-title" content="<?= $setting['store']['values']['name'] ?>"/>
    <link rel="stylesheet" href="assets/common/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/store/css/app.css?v=<?= $version ?>"/>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_783249_m68ye1gfnza.css">
    <script src="assets/common/js/jquery.min.js"></script>
    <script src="//at.alicdn.com/t/font_783249_e5yrsf08rap.js"></script>
    <link rel="stylesheet" href="assets/layui/css/layui.css"/>
    <script src="assets/layui/layui.all.js"></script>
    <script src="assets/common/plugins/laydate/laydate.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        BASE_URL = '<?= isset($base_url) ? $base_url : '' ?>';
        STORE_URL = '<?= isset($store_url) ? $store_url : '' ?>';
    </script>

     <!-- import Vue before Element -->
     <script src="https://unpkg.com/vue/dist/vue.js"></script>
</head>

<body data-type="">
<div class="am-g tpl-g">
    <!-- 头部 -->
    <header class="tpl-header">
        <!-- 右侧内容 -->
        <div class="tpl-header-fluid">
            <!-- 侧边切换 -->
            <link rel="stylesheet" href="//at.alicdn.com/t/font_2031663_yvv9n6lkwt.css">
            <script src="//at.alicdn.com/t/font_2031663_yvv9n6lkwt.js"></script>
            <div class="am-fl tpl-header-button">
                <a href="javascript:history.go(-1)"><i class="iconfont icon-jiantouarrowhead7"></i></a>
            </div>
            <div class="am-fl tpl-header-button switch-button">
                <i class="iconfont icon-menufold"></i>
            </div>
            <!-- 刷新页面 -->
            <div class="am-fl tpl-header-button refresh-button">
                <i class="iconfont icon-refresh"></i>
            </div>
            <!-- 其它功能-->
            <div class="am-fr tpl-header-navbar">
                <ul>
                    <!-- 欢迎语 -->
                    <li class="am-text-sm tpl-header-navbar-welcome">
                        <a href="<?= url('store.user/renew') ?>">欢迎你，<span><?= $store['user']['user_name'] ?>，<?= $store['user']['user_name']=='admin'?'超级管理员':$store['user']['shop_name']?></span>
                        </a>
                    </li>
                    <!-- 退出 -->
                    <li class="am-text-sm">
                        <a href="<?= url('passport/logout') ?>">
                            <i class="iconfont icon-tuichu"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- 侧边导航栏 -->
    <div class="left-sidebar dis-flex">
        <?php $menus = $menus ?: []; ?>
        <?php $group = $group ?: 0; ?>
        <!-- 一级菜单 -->
        <ul class="sidebar-nav">
            <li class="sidebar-nav-heading"><?= $setting['store']['values']['name'] ?></li>
            <?php foreach ($menus as $key => $item): ?>
                <li class="sidebar-nav-link">
                    <a href="<?= isset($item['index']) ? url($item['index']) : 'javascript:void(0);' ?>"
                       class="<?= $item['active'] ? 'active' : '' ?>">
                        <?php if (isset($item['is_svg']) && $item['is_svg'] == true): ?>
                            <svg class="icon sidebar-nav-link-logo" aria-hidden="true">
                                <use xlink:href="#<?= $item['icon'] ?>"></use>
                            </svg>
                        <?php else: ?>
                            <i class="iconfont sidebar-nav-link-logo <?= $item['icon'] ?>"
                               style="<?= isset($item['color']) ? "color:{$item['color']};" : '' ?>"></i>
                        <?php endif; ?>
                        <?= $item['name'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <!-- 子级菜单-->
        <?php  $second = isset($menus[$group]['submenu']) ? $menus[$group]['submenu'] : []; ?>
        <?php if (!empty($second)) : ?>
            <ul class="left-sidebar-second">
                <li class="sidebar-second-title"><?= $menus[$group]['name'] ?></li>
                <li class="sidebar-second-item">
                    <?php foreach ($second as $item) : ?>
                        <?php if (!isset($item['submenu'])): ?>
                            <!-- 二级菜单-->
                            <a href="<?= url($item['index']) ?>"
                               class="<?= (isset($item['active']) && $item['active']) ? 'active' : '' ?>">
                                <?= $item['name']; ?>
                            </a>
                        <?php else: ?>
                            <!-- 三级菜单-->
                            <div class="sidebar-third-item">
                                <a href="javascript:void(0);"
                                   class="sidebar-nav-sub-title <?= $item['active'] ? 'active' : '' ?>">
                                    <i class="iconfont icon-caret"></i>
                                    <?= $item['name']; ?>
                                </a>
                                <ul class="sidebar-third-nav-sub">
                                    <?php foreach ($item['submenu'] as $third) : ?>
                                        <li>
                                            <a class="<?= $third['active'] ? 'active' : '' ?>"
                                               href="<?= url($third['index']) ?>">
                                                <?= $third['name']; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </li>
            </ul>
        <?php endif; ?>
    </div>

    <!-- 内容区域 start -->
    <div class="tpl-content-wrapper <?= empty($second) ? 'no-sidebar-second' : '' ?>">
        <link rel="stylesheet" href="assets/common/plugins/umeditor/themes/default/css/umeditor.css">
        <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget am-cf">
                        <form  onsubmit="return false;" id="my-form" class="am-form tpl-form-line-form" method="post">
                            <div class="widget-body">
                                <fieldset>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">客户信息</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_left">姓名 </label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input   type="text" class="tpl-form-input" name="user_name"
                                                     value="" required>
                                        </div>
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_right" >性别 </label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <label class="am-radio-inline">
                                                <input type="radio" name="sex" value="1" data-am-ucheck checked>
                                                男
                                            </label>
                                            <label class="am-radio-inline" style="float: right">
                                                <input type="radio" name="sex" value="2" data-am-ucheck
                                                >
                                                女
                                            </label>
                                        </div>
                                    </div>
                                    <!--<div class="am-form-group">

                                    </div>-->
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_left">年龄</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input   type="text" class="tpl-form-input" name="years"
                                                     value="" required>
                                        </div>

                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_right">生日</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input type="text" id="test1" class="am-form-field tpl-form-input" name="birthday"
                                                   value=""  placeholder="请选择日期，如2020-01-01">
                                        </div>
                                    </div>
                                    <!--<div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">电话</label>
                                        <div class="am-u-sm-9 am-u-end">
                                            <input type="text" class="tpl-form-input" name="mobile"
                                                   value="" required>
                                        </div>
                                    </div>-->

                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_left">电话</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <input id='phone' type="text" class="tpl-form-input" name="mobile"
                                                   value="" required>
                                        </div>

                                    </div>





                                    <!-- 商品信息 -->
                                    <div id='app'>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">商品信息</div>
                                    </div>
                                    <div class="am-scrollable-horizontal goodsinfo" >
                                        <table class="regional-table am-table am-table-bordered am-table-centered
                            am-text-nowrap am-margin-bottom-xs" style="table-layout: fixed">
                                            <tbody class="info">
                                            <tr>
                                                <th>商品名称</th>
                                                <th colspan="6" style="width: 35%">品牌</th>
<<<<<<< Updated upstream
                                                <!-- <th>到期时间</th> -->
=======
<!--                                                <th>到期时间</th>-->
>>>>>>> Stashed changes
                                                <th>数量</th>
                                                <th>价格</th>
                                            </tr>

                                            <tr>
                                                <td rowspan="2"><div class="am-u-sm-9 am-u-end">隐形眼镜</div></td>
                                                <td>
                                                    右眼：
                                                </td>
                                                <td colspan="5" width="35%"><div class="am-u-sm-9 am-u-end">
                                                        <!--<input type="text" style="float: left;width: 70%" class="tpl-form-input" name="frame"
                                                               value="" required>-->
                                                        <input id="contactBrandInfo" style="float: left;width: 70%;display: none" readonly type="text" class="tpl-form-input" name="contact"
                                                               value="">
                                                        <input id="right_contact_specification_id" name="right_contact_specification_id" type="text" style="display: none">
                                                        <button id="contactBtn"  type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myContactModal">选规格</button>
                                                    </div></td>

                                                <!--<td width="15%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" id="contact_end_time" class="tpl-form-input" name="contact_end_time"
                                                               value="">
                                                    </div></td>-->
                                                <td width="15%"><div class="am-u-sm-9 am-u-end">
                                                        <input  id="contact_num" min="0" type="number" class="tpl-form-input" name="contact_num"
                                                                value="" @change='change' v-model='contact_num'>
                                                    </div></td>
                                                <td><div class="am-u-sm-9 am-u-end">
                                                        <input id="contactPriceMax" type="number" min="0" class="tpl-form-input" name="contact_price"
                                                               value="" v-model='contactPriceMax' @change='change'>
                                                    </div></td>


                                            </tr>
                                            <tr>
                                                <td>
                                                    左眼：
                                                </td>
                                                <td colspan="5" width="35%"><div class="am-u-sm-9 am-u-end">
                                                        <!--<input type="text" style="float: left;width: 70%" class="tpl-form-input" name="frame"
                                                               value="" required>-->
                                                        <input id="left_contactBrandInfo" style="float: left;width: 70%;display: none" readonly type="text" class="tpl-form-input" name="left_contact"
                                                               value="">
                                                        <input id="left_contact_specification_id" name="left_contact_specification_id" type="text" style="display: none">
                                                        <button id="left_contactBtn"  type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myLeftContactModal">选规格</button>
                                                    </div></td>

                                                <!--<td width="15%"><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" id="left_contact_end_time" class="tpl-form-input" name="left_contact_end_time"
                                                               value="">
                                                    </div></td>-->
                                                <td width="15%"><div class="am-u-sm-9 am-u-end">
                                                        <input  id="left_contact_num" min="0" type="number" class="tpl-form-input" name="left_contact_num"
                                                                value="" v-model='left_contact_num' @change='change'>
                                                    </div></td>
                                                <td><div class="am-u-sm-9 am-u-end">
                                                        <input id="left_contactPriceMax" type="number" min="0" class="tpl-form-input" name="left_contact_price"
                                                               value="" v-model='left_contactPriceMax' @change='change'>
                                                    </div></td>


                                            </tr>
                                            <tr>
                                                <td>护理液</td>
                                                <td colspan="6"><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" class="tpl-form-input" name="contact_solution"
                                                               value="">
                                                    </div></td>

                                                <td ><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" id="solution_end_time" class="tpl-form-input" name="solution_end_time"
                                                               value="">
                                                    </div></td>

                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input   min="0" type="number" class="tpl-form-input" name="solution_num"
                                                                value="" v-model='num' @change='change'>
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input  type="number" min="0" class="tpl-form-input" name="solution_price"
                                                               value="" v-model='jiage' @change='change'>
                                                    </div></td>


                                            </tr>

                                            <tr>
                                                <td width="25%">隐形镜盒</td>
                                                <td colspan="6"><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" class="tpl-form-input" name="contact_les"
                                                               value="">
                                                    </div></td>

                                                <td ><div class="am-u-sm-9 am-u-end">
                                                        <input type="text" id="contact_les_end_time" class="tpl-form-input" name="contact_les_end_time"
                                                               value="">
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input   min="0" type="number" class="tpl-form-input" name="contact_les_num"
                                                                value="" v-model='num2' @change='change'>
                                                    </div></td>
                                                <td width="25%"><div class="am-u-sm-9 am-u-end">
                                                        <input  type="number" min="0" class="tpl-form-input" name="contact_les_price"
                                                               value="" v-model='jiage2' @change='change'>
                                                    </div></td>


                                            </tr>

                                            <tr>
                                                <td>合计</td>
                                                <td colspan="9">
                                                    <div class="am-u-sm-9 am-u-end">
                                                        <input readonly type="text" class="tpl-form-input"
                                                               value="" v-model='add'>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    </div>


                                    <?php
                                    use app\store\model\setting\SalesModel as SalesListModel;
                                    use think\Session;
                                    use think\db;
                                    $salesModel = new SalesListModel;
                                    $admin_info = Session::get('yoshop_store')['user'];
                                    $user_info = Db::name('store_user')->where(['store_user_id'=>$admin_info['store_user_id']])->find();
                                    $salesList = $salesModel->getListByType($user_info['user_id'],0);
                                    //                                                    dump($salesList);die();
                                    $optometryList = $salesModel->getListByType($user_info['user_id'],1);
                                    $workingList = $salesModel->getListByType($user_info['user_id'],2);
                                    $cashList = $salesModel->getListByType($user_info['user_id'],3);

                                    ?>
                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">服务人员</div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_left">销售员</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <select  name="sales" class="selectpicker1 show-tick form-control"  data-live-search="false">
                                                <?php
                                                if (!$salesList->isEmpty()): foreach ($salesList as $order):
                                                    ?>

                                                    <option value="<?=$order['sales_name'] ?>"><?=$order['sales_name'] ?></option>


                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>



                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_right">验光师</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <select  name="optometry" class="selectpicker1 show-tick form-control"  data-live-search="false">
                                                <?php
                                                if (!$optometryList->isEmpty()): foreach ($optometryList as $order):
                                                    ?>

                                                    <option value="<?=$order['sales_name'] ?>"><?=$order['sales_name'] ?></option>


                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_left">加工师</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <select  name="working" class="selectpicker1 show-tick form-control"  data-live-search="false">
                                                <?php
                                                if (!$workingList->isEmpty()): foreach ($workingList as $order):
                                                    ?>

                                                    <option value="<?=$order['sales_name'] ?>"><?=$order['sales_name'] ?></option>


                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <label class="am-u-sm-3 am-u-lg-1 am-form-label form-require new_add_right">收银员</label>
                                        <div class="am-u-sm-3 am-u-end">
                                            <select  name="cash" class="selectpicker1 show-tick form-control"  data-live-search="false">
                                                <?php
                                                if (!$cashList->isEmpty()): foreach ($cashList as $order):
                                                    ?>

                                                    <option value="<?=$order['sales_name'] ?>"><?=$order['sales_name'] ?></option>


                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>




                                    <div class="widget-head am-cf">
                                        <div class="widget-title am-fl">备注</div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-8 am-u-end">
                                            <textarea style="width: 101%;text-align: unset;"   class="tpl-form-input" name="notes"></textarea>
                                        </div>
                                    </div>
                                    <!-- 表单提交按钮 -->
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                            <button type="submit" class="j-submit am-btn am-btn-secondary" id="btn-submit">提交
                                            </button>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 图片文件列表模板 -->
        {{include file="layouts/_template/tpl_file_item" /}}

        <!-- 文件库弹窗 -->
        {{include file="layouts/_template/file_library" /}}
        <script src="assets/common/js/jquery.min.js"></script>
        <script src="assets/common/plugins/layer/layer.js?v=<?= $version ?>"></script>
        <script src="assets/common/js/jquery.form.min.js"></script>
        <script src="assets/common/js/vue.min.js"></script>
        <script src="assets/common/js/ddsort.js"></script>
        <script>

            // $(function () {
            //     /**
            //      * 表单验证提交
            //      * @type {*}
            //      */
            //     $('#my-form').superForm();
            //
            // });
            
            const that=this
            function isPhone(str) {
                let reg = /^((0\d{2,3}-\d{7,8})|(1[3456789]\d{9}))$/;
                return reg.test(str);
            }
            $('#btn-submit').click(function() {
                var value=$("#phone").val()
                var flag=that.isPhone(value)
                if(flag&&value!=''){
                    var $form = $('#my-form');
                    $form.submit(function () {
                        var $btn_submit = $('#btn-submit');
                        $btn_submit.attr("disabled", true);
                        $form.ajaxSubmit({
                            type: "post",
                            dataType: "json",
                            // url: '',
                            success: function (result) {
                                $btn_submit.attr('disabled', false);
                                if (result.code === 1) {
                                    layer.msg(result.msg, {time: 1500, anim: 1}, function () {
                                        window.location = result.url;
                                    });
                                    return true;
                                }
                                layer.msg(result.msg, {time: 1500, anim: 6});
                            }
                        });
                        return false;
                    });
                }else if(value!=''){
                    layer.msg('您输入的手机号格式不符合要求！', {time: 1500, anim: 6});
                }
            })
        </script>
    </div>
</div>
{{include file="layouts/_template/contact/glasses_modal" /}}
{{include file="layouts/_template/contact/left_glasses_modal" /}}
<!-- 内容区域 end -->
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        //常规用法contact_end_time
        laydate.render({
            elem: '#test1',
            trigger:'click'
        });
        laydate.render({
            elem: '#contact_end_time',
            trigger:'click'
        });
        laydate.render({
            elem: '#left_contact_end_time',
            trigger:'click'
        });
        laydate.render({
            elem: '#solution_end_time',
            trigger:'click'
        });
        laydate.render({
            elem: '#contact_les_end_time',
            trigger:'click'
        });



    });
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js" ></script>
<script>
    $(function () {
        $('.selectpicker').select2({
            allowClear: true,
            dropdownAutoWidth : true,
            width: '568'
        });
    })
</script>

<script src="assets/common/plugins/layer/layer.js"></script>
<script src="assets/common/js/jquery.form.min.js"></script>
<script src="assets/common/js/amazeui.min.js"></script>
<script src="assets/common/js/webuploader.html5only.js"></script>
<script src="assets/common/js/art-template.js"></script>
<script src="assets/store/js/app.js?v=<?= $version ?>"></script>
<script src="assets/store/js/file.library.js?v=<?= $version ?>"></script>
</body>

</html>

<script>
    new Vue({
        el: '#app',
        data: function () {
            return {
                contact_num:'',
                contactPriceMax:'',
                left_contact_num:'',
                left_contactPriceMax:'',
                num:'',
                jiage:'',
                num2:'',
                jiage2:'',
                add:''

            }
        },
        methods:{
            change(){
                this.add=Number(this.contact_num)*Number(this.contactPriceMax)+Number(this.left_contact_num)*Number(this.left_contactPriceMax)+Number(this.num)*Number(this.jiage)+Number(this.num2)*Number(this.jiage2)
                console.log(this.add)
            }
        }
    });
</script>

