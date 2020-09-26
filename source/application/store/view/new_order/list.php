<link rel="stylesheet" href="assets/layui/css/layui.css" type="text/css">
<style>
    h2>span{
        margin-left: 40px;
        font-size: 16px;
    }

    .layui-form{
        margin-left: 20px;
    }
</style>
<div class="layui-form">
    <h2>
        <span>配镜</span>
        <!--<span>治疗</span>-->
        <span>保健</span>
        <span>护眼</span>
        <span>一体化</span>
        <span>关注公众号</span>
        <span>查询配镜信息</span>
    </h2>
    <table border="1" lay-size="sm" >
        <tbody>
        <tr class="layui-table-cell">
            <td >客户全名</td>
            <td ><?= $list['user_name'] ?></td>
            <td >性别</td>
            <?php if($list['sex'] == 1) :?>
                <td>
                    男
                </td>
            <?php endif;?>
            <?php if($list['sex'] == 2) :?>
                <td>
                    女
                </td>
            <?php endif;?>
            <td >年龄</td>
            <td ><?= $list['years'] ?></td>
            <td ">手机</td>
            <td ><?= $list['mobile'] ?></td>
            <td >日期</td>
            <td colspan="3"><?= date('Y-m-d',$list['create_time']) ?></td>
        </tr>
        <tbody>
        <tr class="layui-table-cell">
            <td>生日</td>
            <td><?= $list['birthday'] ?></td>
            <td width="30">订单号</td>
            <td><?= $list['order_num'] ?></td>
            <td>瞳距</td>
            <td><?= $list['distance'] ?></td>
            <td>验光师</td>
            <td><?= $list['optometry'] ?></td>
            <td>加工师</td>
            <td ><?= $list['working'] ?></td>
            <td >收银员</td>
            <td ><?= $list['cash'] ?></td>
        </tr>
        <tr class="layui-table-cell">
            <td>经手人</td>
            <td><?= $list['handle'] ?></td>
            <td colspan="3">执行标准:<?= $list['standard'] ?></td>
            <?php if($list['test'] == 0) :?>
                <td colspan="2">检验:合格</td>
            <?php endif;?>
            <?php if($list['test'] == 1) :?>
                <td colspan="2">检验:不合格</td>
            <?php endif;?>
            <td>检验员</td>
            <td colspan="4"><?= $list['inspectors'] ?></td>

        </tr>
        <tr class="layui-table-cell">
            <td colspan="2">说明</td>
            <td colspan="10"><?= $list['notes'] ?></td>

        </tr>
        <tr class="layui-table-cell">
            <td>型号</td>
            <td colspan="6">商品全名</td>
            <td>单位</td>
            <td colspan="2">数量</td>
            <td colspan="2">价格</td>

        </tr>
        <tr class="layui-table-cell">
            <td>1</td>
            <td colspan="6"><?= $list['frame'] ?></td>
            <td>个</td>
            <td colspan="2"><?= $list['frame_num'] ?></td>
            <td colspan="2"><?= $list['frame_price'] ?></td>
        </tr>
        <tr class="layui-table-cell">
            <td>2</td>
            <td colspan="6"><?= $list['lens'] ?></td>
            <td>片</td>
            <td colspan="2"><?= $list['lens_num'] ?></td>
            <td colspan="2"><?= $list['lens_price'] ?></td>
        </tr>
        <tr class="layui-table-cell">
            <td>3</td>
            <td colspan="6">眼镜盒</td>
            <td>个</td>
            <td colspan="2"><?= $list['glasses_case_num'] ?></td>
            <td colspan="2"><?= $list['glasses_case_price'] ?></td>
        </tr>
        <tr class="layui-table-cell">
            <td>4</td>
            <td colspan="6">眼镜布</td>
            <td>片</td>
            <td colspan="2"><?= $list['glasses_cloth_num'] ?></td>
            <td colspan="2"><?= $list['glasses_cloth_price'] ?></td>
        </tr>
        <tr class="layui-table-cell">
            <td>5</td>
            <td colspan="6"><?= $list['contact_lens'] ?></td>
            <td>副</td>
            <td colspan="2"><?= $list['contact_lens_num'] ?></td>
            <td colspan="2"><?= $list['contact_lens_price'] ?></td>
        </tr>
        <tr class="layui-table-cell">
            <td>合计数量</td>
            <td colspan="2"><?= $list['frame_num'] +  $list['lens_num'] + $list['glasses_case_num'] + $list['glasses_cloth_num']+ $list['contact_lens_num']?></td>
            <td>合计金额</td>
            <td colspan="2"><?= $list['total'] ?></td>
            <td>折扣金额</td>
            <td colspan="2"><?= $list['discount'] ?></td>
            <td>实收金额</td>
            <td colspan="2"><?= $list['pay_total'] ?></td>
        </tr>
        </tbody>
    </table>



    <table border="0" lay-size="sm" >
        <tbody>
        <tr class="layui-table-cell" >
                <td colspan="1" width='65px'>销量:</td>
                <td colspan="2" width='130px'></td>
                <td colspan="1" width='65px'>验光:</td>
                <td colspan="2" width='130px'></td>
                <td colspan="1" width='65px'>加工:</td>
                <td colspan="2" width='130px'></td>
                <td colspan="1" width='65px'>收银:</td>
                <td colspan="2" width='130px'></td>
            </tr>
            <tr class="layui-table-cell" >
                <td colspan="6.5"  width='65px'>详细地址：<?= $list['addr'] ?></td>
                <td colspan="2.5"  width='65px'>联系电话:</td>
                <td colspan="2.5"  width='65px'>日期:</td>
                <td><img src="assets/admin/img/test.png" alt="" height="100px"></td>
            </tr> 
        </tbody>
    </table>



    <!-- <table border="1" lay-size="sm">
        <tbody>
            <tr class="layui-table-cell" >
                <td colspan="1">销量:</td>
                <td colspan="2"></td>
                <td colspan="1">验光:</td>
                <td colspan="2"></td>
                <td colspan="1">加工:</td>
                <td colspan="2"></td>
                <td colspan="1">收银:</td>
                <td colspan="2"></td>
            </tr>
            <tr class="layui-table-cell" >
                <td colspan="11">详细地址：<?= $list['addr'] ?></td>
                <td><img src="assets/admin/img/test.png" alt="" height="100px"></td>

            </tr>
        </tbody>
    </table> -->
    <!--<div>
        <img src="assets/admin/img/test.png" alt="" height="100px">
    </div>-->
</div>
<script>

    $(function () {
        /**
         * 订单导出
         */
        $('.j-export').click(function () {
            var data = {};
            var formData = $('#form-search').serializeArray();
            $.each(formData, function () {
                this.name !== 's' && (data[this.name] = this.value);
            });
            window.location = "<?= url('new_order/export') ?>" + '&' + $.urlEncode(data);
        });

    });

</script>

