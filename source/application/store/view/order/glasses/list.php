<link rel="stylesheet" href="assets/layui/css/layui.css" type="text/css">
<style>
    h2>span{
        margin-left: 40px;
        font-size: 16px;
    }

    .layui-form{
        margin-left: 20px;
    }
		.table td {
			min-width: 70px;
			padding: 8px 0;
			text-align: center;
		}
		.h2 {
			position: relative;
			top: 30px;
			margin-top: 20px;
			}
		}
</style>
<div class="layui-form">
    <h2 class="h2">
        <span>配镜</span>
        <!--<span>治疗</span>-->
        <span>保健</span>
        <span>护眼</span>
        <span>一体化</span>
        <span>关注公众号</span>
        <span>查询配镜信息</span>
    </h2>
    <table border="1" lay-size="sm" class="table">
			<caption align="top" style="position:relative;top:-35px;font-weight: 600;font-size: 30px;">我是表格标题</caption>
        <tbody>
        <tr class="layui-table-cell">
            <td >姓名</td>
            <td colspan="2"><?= $list['user_name'] ?></td>
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
            <td colspan="2"><?= $list['years'] ?></td>
            <td >电话</td>
            <td colspan="3"><?= $list['mobile'] ?></td>
            <!-- <td >日期</td>
            <td colspan="3"><?= date('Y-m-d',$list['create_time']) ?></td> -->
        </tr>
        <tbody>
        <!-- <tr class="layui-table-cell">
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
        </tr> -->
				<tr class="layui-table-cell">
					<td rowspan="3">配镜<br/>光度</td>
					<td colspan="2">球镜</td>
					<td>柱镜</td>
					<td>轴位</td>
					<td>ADD</td>
					<td>瞳高</td>
					<td>棱镜</td>
					<td>矫正视力</td>
					<td colspan="2">瞳距</td>
					<td>备注</td>
					
				</tr>
				<tr class="layui-table-cell">
					<td>左</td>
					<td>柱镜</td>
					<td>柱镜</td>
					<td>轴位</td>
					<td>ADD</td>
					<td>瞳高</td>
					<td>棱镜</td>
					<td>矫正视力</td>
					<td colspan="2" rowspan="2">瞳距</td>
					<td colspan="2" rowspan="2">备注</td>
				</tr>
				<tr class="layui-table-cell">
					<td>右</td>
					<td>柱镜</td>
					<td>柱镜</td>
					<td>轴位</td>
					<td>ADD</td>
					<td>瞳高</td>
					<td>棱镜</td>
					<td>矫正视力</td>
					
				</tr>
        <!-- <tr class="layui-table-cell">
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

        </tr>-->
        <tr class="layui-table-cell">
            <td>序号</td>
            <td>类别</td>
            <td colspan="5">商品全名</td>
            <td>单位</td>
            <td>数量</td>
            <td>价格</td>
            <td>金额</td>
            <td>积分</td>

        </tr> 
        <tr class="layui-table-cell">
            <td>1</td>
            <td>右眼</td>
            <td colspan="5"><?= $list['right_frame'] ?></td>
            <td>片</td>
            <td><?= $list['right_frame_num'] ?></td>
            <td><?= $list['right_frame_price'] ?></td>
            <td><?= $list['right_frame_price'] ?></td>
            <td><?= $list['right_frame_price'] ?></td>
        </tr>
        <tr class="layui-table-cell">
            <td>2</td>
            <td>左眼</td>
            <td colspan="5"><?= $list['left_frame'] ?></td>
            <td>片</td>
            <td><?= $list['left_frame_num'] ?></td>
            <td><?= $list['left_frame_price'] ?></td>
            <td><?= $list['left_frame_price'] ?></td>
            <td><?= $list['left_frame_price'] ?></td>
        </tr>
        <!-- <tr class="layui-table-cell">
            <td>3</td>
            <td colspan="6">眼镜盒</td>
            <td>个</td>
            <td colspan="2"><?= $list['glasses_les_num'] ?></td>
            <td colspan="2"><?= $list['glasses_les_price'] ?></td>
        </tr>
        <tr class="layui-table-cell">
            <td>4</td>
            <td colspan="6">眼镜布</td>
            <td>片</td>
            <td colspan="2"><?= $list['glasses_case_num'] ?></td>
            <td colspan="2"><?= $list['glasses_case_price'] ?></td>
        </tr>
        <tr class="layui-table-cell">
            <td>5</td>
            <td colspan="6">镜框：<?= $list['right_glasses'] ?></td>
            <td>副</td>
            <td colspan="2"><?= $list['right_glasses_cloth_num'] ?></td>
            <td colspan="2"><?= $list['right_glasses_cloth_price'] ?></td>
        </tr>
        <tr class="layui-table-cell">
            <td>6</td>
            <td colspan="6">其他：<?= $list['other'] ?></td>
            <td>副</td>
            <td colspan="2"><?= $list['glasses_other_num'] ?></td>
            <td colspan="2"><?= $list['glasses_other_price'] ?></td>
        </tr> -->
        <tr class="layui-table-cell">
            <td>合计</td>
            <td colspan="6"><?= $list['pay_total'] ?></td>
            <td><?= $list['right_frame_num'] +  $list['left_frame_num'] + $list['glasses_case_num'] + $list['right_glasses_cloth_num']+ $list['glasses_les_num']+ $list['glasses_other_num']?></td>
            <td><?= $list['total'] ?></td>
            <td><?= $list['discount'] ?></td>
            <td></td>
            <td colspan="2"></td>
        </tr>
        </tbody>
    </table>



    <table border="0" lay-size="sm" style='margin-top:20px;'>
        <tbody>
        <tr class="layui-table-cell">
            <td colspan="1" width='65px'>销量:</td>
            <td colspan="1" width='100px'></td>
            <td colspan="1" width='65px'>验光:</td>
            <td colspan="1" width='100px'><?= $list['optometry'] ?></td>
            <td colspan="1" width='65px'>加工:</td>
            <td colspan="1" width='100px'><?= $list['working'] ?></td>
            <td colspan="1" width='65px'>收银:</td>
            <td colspan="1" width='100px'><?= $list['cash'] ?></td>
        </tr>
        <tr class="layui-table-cell" >
            <td colspan="4"  width='65px'>详细地址：<?= $list['addr'] ?></td>
            <td colspan="3"  width='65px'>联系电话:<?= $list['mobile'] ?></td>
            <td colspan="2"  width='65px'>日期:<?= date("Y-m-d",$list['create_time']) ?></td>
            <td><img src="assets/admin/img/test.png" alt="" height="100px" style='position: relative; top: -43px;left:75px;'></td>
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

