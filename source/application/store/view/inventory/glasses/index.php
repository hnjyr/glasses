<!DOCTYPE html>
<html lang="en">
<?php //dump($list);die(); ?>
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
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/bootstrap-select/1.12.4/css/bootstrap-select.min.css" rel="stylesheet">

    <script src="https://cdn.bootcss.com/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

        <!-- 引入样式 -->
        <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <!-- import Vue before Element -->
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <!-- 引入组件库 -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>

    <style>
        #step1{
            display:block;
        }
        #step2,#step3,#step4,#step5,#step6,#step7,#step8{
            display: none;
        }
        #step1,#step2,#step3{
            position: absolute;
            width: 100%;
            height: 40%;
            left: 2%;
            top:10%;
        }
        .line{
            margin:20px 0;
        }
        .el-table--fit{
            width:1192px!important;
        }
        p{
            margin:0!important;
        }
    </style>
    <script>
        BASE_URL = '<?= isset($base_url) ? $base_url : '' ?>';
        STORE_URL = '<?= isset($store_url) ? $store_url : '' ?>';
    </script>

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
        <?php $second = isset($menus[$group]['submenu']) ? $menus[$group]['submenu'] : []; ?>
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
        <!-- <div class="row-content am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-cf"><?= $title ?></div>
                    </div>
                    <div class="widget-body am-fr">
                        <div class="page_toolbar am-margin-bottom-xs am-cf">
                            <form id="form-search" class="toolbar-form" action="">
                                <div class="am-u-sm-12 am-u-md-3">
                                    <div class="am-form-group">
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                    <a class="j-export am-btn am-btn-danger am-radius"
                                                       href="<?= url('inventory.glasses/add') ?>">
                                                        <i class="iconfont icon-add am-margin-right-xs"></i>新增品牌
                                                    </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="order-list am-scrollable-horizontal am-u-sm-12 am-margin-top-xs" >
                        <table width="100%" class="am-table am-table-centered
                        am-text-nowrap am-margin-bottom-xs">
                            <thead>
                            <tr>
                                <th><input id="checkAll" type="checkbox"></th>
                                <th>品牌名称</th>
                                <th>店铺名称</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $colspan = 5; ?>
                            <?php if (!$list->isEmpty()): foreach ($list as $order): ?>
                        <?php //dump($order); ?>
                                <tr>
                                    <td class="am-text-middle" >
                                        <input type="checkbox" name="checkitem" >
                                    </td>

                                    <td class="am-text-middle" >
                                        <span class="am-margin-right-lg"><?= $order['brand_name'] ?></span>
                                    </td>
                                    <td class="am-text-middle" >
                                        <span > <?= $order['shop_name'] ?></span>
                                    </td>
                                    <td class="am-text-middle" >
                                        <span > <?= $order['create_time'] ?></span>
                                    </td>


                                    <td class="am-text-middle" >
                                        <div class="tpl-table-black-operation">
                                            <a id="submit1"  class="tpl-table-black-operation"
                                               href="<?= url('inventory.glasses.model/index&&brand_id='.$order['brand_id']) ?>" style="width:50%;margin: auto">
                                                型号</a>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                                <tr>
                                    <td colspan="<?= $colspan+1 ?>" class="am-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                        <div class="am-u-lg-12 am-cf">
                        <div class="am-fr"><?= $list->render() ?> </div>
                        <div class="am-fr pagination-total am-margin-right">
                            <div class="am-vertical-align-middle">总记录：<?= $list->total() ?></div>
                        </div>
                    </div>

                </div>
                </div>
            </div>
        </div> -->

        <div id='app'>

             <el-button type="primary" style='margin:20px 0;' @click='addpinpai'>
                 <i class="el-icon-plus"></i>
                品牌添加
            </el-button>
            
            <div style='width:570px;display: flex;align-items:center;justify-content:space-between;padding:10px 0;font-weight:500;font-size:18px;'>
                <div style='text-align: center;flex:1;'>品牌</div>
                <!-- <div style='text-align: center; flex:1;'>球面类型</div>
                <div style='text-align: center; flex:1;'>折射率</div> -->
                <div style='text-align: center; flex:1;'>型号</div>
            </div>

            <el-cascader-panel v-model="partyOrganId" :props="prop" :show-all-levels="false" @change="handleChange" @expand-change='change1'>
                <template slot-scope="{ node, data }">
                    <p>
                        <span style="width: 100px;display: inline-block;">{{ data.label }}</span>
                        <i class="el-icon-plus" @click="add(node)" style='margin:0 10px;'></i>
                        <i class="el-icon-edit" @click="edit(node)" style='margin:0 10px;'></i>
                        <i class="el-icon-close" @click="del(node)" style='margin:0 10px;'></i>
                    </p>
                    <!-- <span v-if="!node.isLeaf"> ({{ data.children.length }}) </span>             -->
                </template>
            </el-cascader-panel>

            <div style="width:1192px;">
                <el-table
                        :data="tableData">
                    <el-table-column
                            prop="color"
                            label="色号">
                    </el-table-column>
                    <el-table-column
                            prop="price"
                            label="单价">
                    </el-table-column>
                    <el-table-column
                            prop="standard_inventory"
                            label="标准库存">
                    </el-table-column>
                    <el-table-column
                            prop="now_inventory"
                            label="现有库存">
                    </el-table-column>
                    <el-table-column
                            prop="inventory"
                            label="需补库存">
                    </el-table-column>
                    <el-table-column
                            style='display:inline-block;'
                            v-if='show'
                            prop="specification_id"
                            label="库存id">
                    </el-table-column>
                    <el-table-column
                            fixed="right"
                            label="操作">
                        <template slot-scope="scope">
                            <el-button
                                    @click.native.prevent="editRow(scope.$index, tableData)"
                                    type="text"
                                    size="small">
                                修改
                            </el-button>
                            <el-button
                                    @click.native.prevent="deleteRow(scope.$index, tableData)"
                                    type="text"
                                    size="small">
                                移除
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>

             <!-- 添加新品牌弹窗 -->
             <el-dialog :title="tit" :visible.sync="dialogVisiblepp" width="30%" :before-close="handleClosepinpai">
                <div class="line">
                    <span>品牌名称:</span>
                    <input type="text" placeholder="请输入品牌名称" v-model='name'>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="dialogVisiblepp = false">取 消</el-button>
                    <el-button type="primary" @click="addPP">确 定</el-button>
                </span>
            </el-dialog>
        
            <!-- 添加新品牌弹窗 -->
            <el-dialog :title="tit" :visible.sync="dialogVisible" width="30%" :before-close="handleClose">
                <div class="line" v-if='status==2'>
                    <span>型&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号:</span>
                    <input type="text" placeholder="请输入型号" v-model='types'>
                </div>
                <div class="line" v-if='status==5'>
                    <span>标准库存:</span>
                    <input type="number" placeholder="请输入库存" v-model='bzkucun'>
                </div>
                <div class="line" v-if='status==6'>
                    <span>现有库存:</span>
                    <input type="text" placeholder="请输入库存" v-model='inventory'>
                </div>
                <div class="line" v-if='status==5||status==6'>
                    <span>价&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;格:</span>
                    <input type="number" placeholder="请输入价格" v-model='price'>
                </div>
                <div class="line" v-if='status==5||status==6'>
                    <span>颜&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;色:</span>
                    <input type="text" placeholder="请输入颜色" v-model='color'>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="dialogVisible = false">取 消</el-button>
                    <el-button type="primary" @click="confirm">确 定</el-button>
                </span>
            </el-dialog>
        </div>
    </div>
    <!-- 内容区域 end -->

</div>
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
						show:false,
						options:[],
						partyOrganId:[],
						typelist: [], //选择数组
						dialogVisible: false, //是否显示添加弹框
						dialogVisiblepp:false,//品牌添加修改
						name: '', //品牌名称
						sphereType: '', // 球面类型
						refractive: '', //折射率
						types: '', //型号
						bzkucun:'',//标准库存
						inventory: '', //库存
						price: '', //价格
						color:'',//颜色
						status: 1 ,//默认添加品牌
						tit:'添加',
						lists:[],
						tableData:[],
						db_type:2,
						nums:-1,
						id:null,
						current:null,
						dataNode:'',
						level:'',
						editType:'',
						kcInfo:[],
						prop:{ 
								lazy: true,
								lazyLoad(node, resolve) {
										setTimeout(() => {
											switch (node.level) {
												case 0:
													$.ajax({
														type: "GET",
														url: "index.php?s=/store/inventory.glasses/getbrandlist",
														success: function(data){
															var list=JSON.parse(data) || [];
																// that.lists=list
																// that.options=that.lists
																let cities = list.map((v, i) => ({
																	value: v.brand_id,
																	label: v.brand_name,
																	leaf: node.level >= 1
																}))
																resolve(cities);
														},
														error: function (message) {
														}
													});
												break;
												case 1:
													$.ajax({
														type: "GET",
														url: "index.php?s=/store/inventory.glasses/getmodellist&brand_id="+node.data.value,
														success: function(data){
																var list=JSON.parse(data) || [];
																let cities = list.map((v, i) => ({
																	value: v.model_id,
																	label: v.model,
																	fb_id: node.data.value,
																	leaf: node.level >= 1
																}))
																resolve(cities);
														},
														error: function (message) {}
													});
													break;
												case 2:

											}
												
										}, 1000);
								}
						}
				}
		},
		created: function () {
				// this.getlist()
		},
		methods: {
				handleClosepinpai(){
						this.dialogVisiblepp = false
				},
				handleClose(){
						this.dialogVisible = false
				},
				// 添加新品牌弹窗
				addpinpai(){
						this.dialogVisiblepp = true
						this.tit='添加'
				},
				// 添加品牌
				addPP(){
						const that=this;
						let level = this.level,
						data = this.dataNode;
						if(that.tit=='添加'){
								if(that.name.trim()!=''){
								$.ajax({
										type: "POST",
										url:'index.php?s=/store/inventory.index/add_brand',
										data:{
												brand:that.name,
												dbtype:that.db_type
										},
										success: function(data){
												var res=JSON.parse(data)
												if(res.code==1){
														that.$message({
																message: '添加成功！',
																type: 'success'
														});
														that.dialogVisiblepp = false
														location.reload();
												}else{
														that.$message({
																message: res.msg,
																type: 'warning'
														});
												} 
												},
												error: function (message) {
												}
										});
								}else{
										that.$message({
												message: '内容不能为空',
												type: 'warning'
										});
								}
						}else{
								// 修改品牌
								this.editCont()
						}
				},
				// 删除库存
				deleteRow(index, rows) {
						console.log(rows)
						var id=rows[index].specification_id
						const that=this
						$.ajax({
								type: "POST",
								url: "index.php?s=/store/inventory.index/del_spec",
								data:{
										specification_id:id,
										dbtype:that.db_type
								},
								success: function(data){
										var res=JSON.parse(data)
										if(res.code==1){
												that.tableData.splice(index,1)
										}else{
												that.$message({
														message: res.msg,
														type: 'warning'
												});
										}
								},
								error: function (message) {
								}
						});
				},
				// 修改库存
				editRow(index, rows){
						const that=this
						that.status=6
						that.tit='修改';
						that.editType = 'edit';
						that.bzkucun=rows[index].standard_inventory
						that.price=rows[index].price
						that.inventory=rows[index].now_inventory
						that.color=rows[index].color
						that.dialogVisible=true
						that.id=rows[index].specification_id
				},
				handleChange(event) {
						this.current=event;
						var list=this.options;
						// that.kcInfo = event;
						if(event.length==1){//点击品牌
								list.forEach((it,index)=>{
										if(it.brand_id==event[0]){
												this.getgglist(event[0],index)
										}
								})
						}else if(event.length==2){//点击类型
								this.getinvlist(event[0],event[1])
						}
				},
				// 获取库存规格
				getinvlist(fid,id){
						const that=this
						$.ajax({
								type: "GET",
								url: "index.php?s=/store/inventory.glasses/getspeclist&brand_id="+fid+'&model_id='+id,
								success: function(data){
										var list=JSON.parse(data)
										that.tableData=list
								},
								error: function (message) {
								}
						});
				},
				change1(event) {
						this.current = event
				},
				edit(node) {
					if(node.level === 1) {
						this.dialogVisiblepp = true;
						this.name = node.label;
						this.status = 1;
					}else {
						this.status = 2;
						this.dialogVisible = true;
						this.types = node.label;
					}
					this.dataNode = node.data;
					this.level = node.level;
					this.editType = 'edit';
					this.tit='修改';
				},
				add(node) {
					//  = node.level === 1? 2:5;
					switch(node.level) {
						case 1:
							this.types=''
							this.status=2
							break;
						default:
							this.bzkucun=''
							this.price=''
							this.color=''
							this.status=5
					} 
					this.dataNode = node.data;
					this.level = node.level;
					this.editType = 'add';
					this.tit='添加';
					this.dialogVisible = true;
				},
				confirm(){
					let level = this.level,
					node = this.dataNode,
					editType = this.editType,
					that = this;
					if(editType == 'add') {
						this.abc();
					}else {
						this.editCont()
					}
				},
				del(node) {
					this.level = node.level;
					this.dataNode = node.data;
					this.$confirm('此操作将永久删除, 是否继续?', '提示', {
						confirmButtonText: '确定',
						cancelButtonText: '取消',
						type: 'warning'
					}).then(() => {
						this.delCont();
					}).catch(() => {
											
					});
				},
				// type  1 添加   2删除  3修改
				abc() {
					let that = this,
					level = this.level,
					data = this.dataNode;
					// level 层级
					if(level == 1) {
						// 添加型号
						if (that.types != '') {
							$.ajax({
								type: "POST",
								url:'index.php?s=/store/inventory.index/add_model',
								data:{
										brand_id:data.value,
										model:that.types,
										dbtype:that.db_type
								},
								success: function(data){
										var res=JSON.parse(data)
										console.log(res)
										if(res.code==1){
												that.$message({
														message: '添加成功！',
														type: 'success'
												});
												that.dialogVisible = false
												location.reload()
										}else{
												that.$message({
														message: res.msg,
														type: 'warning'
												});
										} 
								},
								error: function (message) {
								}
							});
						}else{
								that.$message({
										message: '内容不能为空',
										type: 'warning'
								});
						}
					}else if(level == 2) {
						// 添加库存
						if (that.bzkucun!= ''&&that.price!='') {//添加
							$.ajax({
								type: "POST",
								url:'index.php?s=/store/inventory.index/add_spec',
								data:{
										brand_id:data.fb_id,
										model_id:data.value,
										now_inventory:that.bzkucun,
										color:that.color,
										price:that.price,
										dbtype:that.db_type
								},
								success: function(res){
										var res=JSON.parse(res)
										console.log(res)
										if(res.code==1){
												that.$message({
														message: '添加成功！',
														type: 'success'
												});
												that.getinvlist(data.fb_id,data.value)
												that.price=''
												that.color=''
												that.bzkucun=''
												that.dialogVisible = false
										}else{
												that.$message({
														message: res.msg,
														type: 'warning'
												});
										} 
								},
								error: function (message) {
								}
							});
						}else{
							that.$message({
									message: '内容不能为空',
									type: 'warning'
							});
						}
					}
				},
				// 编辑
				editCont() {
					let that = this,
					level = this.level,
					data = this.dataNode;
					// 品牌
					if(this.status == 1) {
						$.ajax({
							type: "POST",
							url:'index.php?s=/store/inventory.index/update_brand',
							data:{
									brand_id:data.value,
									brand_name:that.name,
									dbtype:that.db_type
							},
							success: function(res){
									var res=JSON.parse(res)
									if(res.code==1){
											that.$message({
													message: '修改成功！',
													type: 'success'
											});
											
											that.dialogVisiblepp = false;
											location.reload()
									}else{
											that.$message({
													message: '修改失败！',
													type: 'warning'
											});
									} 
							},
							error: function (message) {
							}
						});
					}else if(this.status == 2) {
						$.ajax({
							type: "POST",
							url:'index.php?s=/store/inventory.index/update_model',
							data:{
									model_id:data.value,
									model:that.types,
									dbtype:that.db_type
							},
							success: function(res){
									var res=JSON.parse(res)
									if(res.code==1){
											that.$message({
													message: '修改成功！',
													type: 'success'
											});
											that.dialogVisible = false;
											location.reload()
									}else{
											that.$message({
													message: res.msg,
													type: 'warning'
											});
									} 
							},
							error: function (message) {
							}
						});
					}else if(this.status == 6) {
						if(that.price!=''&&that.inventory!=''){
							$.ajax({
								type: "POST",
								url: "index.php?s=/store/inventory.index/update_spec",
								data:{
										specification_id:that.id,
										price:that.price,
										color:that.color,
										now_inventory:that.inventory,
										dbtype:that.db_type
								},
								success: function(data){
										var res=JSON.parse(data)
										if(res.code==1){
												that.getinvlist(that.current[0],that.current[1])
										}else{
												that.$message({
														message: res.msg,
														type: 'warning'
												});
										}
										that.color=''
										that.price=''
										that.inventory=''
										that.dialogVisible=false
								},
								error: function (message) {
								}
							});
						}else{
								that.$message({
										message: '不能有空项！',
										type: 'warning'
								});
						}
					}
				},
				// 删除
				delCont() {
					let that = this,
					level = this.level,
					data = this.dataNode;
					if(level == 1) {
						// 品牌
						$.ajax({
							type: "POST",
							url:'index.php?s=/store/inventory.index/del_brand',
							data:{
									brand_id:data.value,
									dbtype:that.db_type
							},
							success: function(res){
									var res=JSON.parse(res)
									if(res.code==1){
											that.$message({
													message: '删除成功！',
													type: 'success'
											});
											that.dialogVisiblepp = false;
											location.reload();
									}else{
											that.$message({
													message: res.msg,
													type: 'warning'
											});
									} 
							},
							error: function (message) {
							}
						});
					}else {
						$.ajax({
							type: "POST",
							url:'index.php?s=/store/inventory.index/del_model',
							data:{
									brand_id:data.fb_id,
									model_id:data.value,
									dbtype:that.db_type
							},
							success: function(res){
									var res=JSON.parse(res)
									if(res.code==1){
											that.$message({
													message: '删除成功！',
													type: 'success'
											});
											that.dialogVisiblepp = false;
											location.reload();
									}else{
											that.$message({
													message: res.msg,
													type: 'warning'
											});
									} 
							},
							error: function (message) {
							}
					});
					}
				}
		}
});
</script>



