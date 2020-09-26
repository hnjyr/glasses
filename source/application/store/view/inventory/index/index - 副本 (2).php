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
                        <a href="<?= url('store.user/renew') ?>">欢迎你，<span><?= $store['user']['user_name'] ?></span>
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
                                                       href="<?= url('inventory.index/add') ?>">
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
                                               href="<?= url('inventory.refractive/index&&type=0&&brand_id='.$order['brand_id']) ?>" style="width:50%;margin: auto">
                                                球面</a>
                                            <a id="submit2" class="tpl-table-black-operation"
                                               href="<?= url('inventory.refractive/index&&type=1&&brand_id='.$order['brand_id']) ?>" style="width:50%;margin: auto">
                                                非球面</a>
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
            <el-cascader-panel  :options="options" :props="{ value:'brand_id',label:'brand_name'}" @change="handleChange" @expand-change='change1'>
                <template slot-scope="{ node, data }">
                    <p>
                        <span style="width: 100px;display: inline-block;">{{ data.brand_name }}</span>
                        <i class="el-icon-plus" @click="add(node)"></i>
                        <i class="el-icon-edit" @click="edit(node)"></i>
                        <i class="el-icon-close" @click="del(node)"></i>
                    </p>
                    <!-- <span v-if="!node.isLeaf"> ({{ data.children.length }}) </span>             -->
                </template>
            </el-cascader-panel>

            <el-table
            :data="tableData"
            style="width: 100%">
            <el-table-column
                prop="color"
                label="颜色"
                width="180">
            </el-table-column>
            <el-table-column
                prop="standard_inventory"
                label="标准库存"
                width="180">
            </el-table-column>
            <el-table-column
                prop="now_inventory"
                label="现有库存"
                width="180">
            </el-table-column>
            <el-table-column
                prop="inventory"
                label="需补库存">
            </el-table-column>
            <el-table-column
                prop="price"
                label="单价">
            </el-table-column>
            <el-table-column
                prop="specification_id"
                label="库存id">
            </el-table-column>
            <el-table-column
                prop="create_time"
                label="时间">
            </el-table-column>
            <el-table-column
                fixed="right"
                label="操作"
                width="120">
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
        
            <!-- 添加新品牌弹窗 -->
            <el-dialog :title="tit" :visible.sync="dialogVisible" width="30%" :before-close="handleClose">
                <div class="line" v-if='status==1'>
                    <span>品牌名称:</span>
                    <input type="text" placeholder="请输入品牌名称" v-model='name'>
                </div>
                <div class="line" v-if='status==2'>
                    <span>球面类型:</span>
                    <input type="text" placeholder="请输入球面类型" v-model='sphereType'>
                </div>
                <div class="line" v-if='status==3'>
                    <span>折射率:</span>
                    <input type="text" placeholder="请输入折射率" v-model='refractive'>
                </div>
                <div class="line" v-if='status==4'>
                    <span>型号:</span>
                    <input type="text" placeholder="请输入型号" v-model='types'>
                </div>
                <div class="line" v-if='status==5'>
                    <span>库存:</span>
                    <input type="text" placeholder="请输入库存" v-model='inventory'>
                </div>
                <div class="line" v-if='status==5'>
                    <span>价格:</span>
                    <input type="number" placeholder="请输入价格" v-model='price'>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="dialogVisible = false">取 消</el-button>
                    <el-button type="primary" @click="addPP">确 定</el-button>
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
                options:[],
                typelist: [], //选择数组
                dialogVisible: false, //是否显示添加弹框
                name: '', //品牌名称
                sphereType: '', // 球面类型
                refractive: '', //折射率
                types: '', //型号
                inventory: '', //库存
                price: '', //价格
                status: 1 ,//默认添加品牌
                tit:'添加',
                lists:[],
                tableData:[],
                ceList:[]
            }
        },
        created: function () {
            this.getlist()
            
        },
        methods: {
            // 删除库存
            deleteRow(index, rows) {
                // console.log(9999)
                // rows.splice(index, 1);
            },
            // 修改库存
            editRow(index, rows){
                // console.log(7777)
            },
            handleChange(event) {
                // console.log(event)
                this.getinvlist(event[0],event[1],event[2],event[3])
            },
            // 调用接口获取数据
            getlist(){
                const that=this
                $.ajax({
                    type: "GET",
                    url: "index.php?s=/store/inventory.index/getbrandlist",
                    success: function(data){
                        var list=JSON.parse(data)
                        list.forEach((item,index)=>{
                            item.children=[{
                                brand_id:0,
                                brand_name:'球面',
                                fbrand_id:item.brand_id,
                                children:[]
                            },{
                                brand_id:1,
                                brand_name:'非球面',
                                fbrand_id:item.brand_id,
                                children:[]
                            }]
                        })
                        list.forEach((it,idx)=>{
                            it.children.forEach((item,index)=>{
                                that.getrefractive(it.brand_id,idx,item.brand_id,index,list)
                            })
                        })
                        // that.lists = list//"太阳镜" 
                    },
                    error: function (message) {
                    }
                });
            },
            // 获取折射率
            getrefractive(id,idx,type,tid,arrList){
                const that=this;
                that.lists = arrList;
                $.ajax({
                    type: "GET",
                    url: "index.php?s=/store/inventory.index/getrefracitivelist&brand_id="+id+'&type='+type,
                    success: function(data){
                        var list=JSON.parse(data)
                        if(list!=null){
                            list.forEach((it,index)=>{
                                it.fbrand_id=type
                                it.brand_id=it.refractive_id
                                it.brand_name=it.refractive_num
                            })
                            that.lists[idx].children[tid].children=list
                            that.lists.forEach((it1,idx1)=>{
                            it1.children.forEach((it2,idx2)=>{
                                it2.children.forEach((it3,idx3)=>{
                                    that.getgglist(it1.brand_id,idx1,it2.brand_id,idx2,it3.brand_id,idx3)
                                })
                            })
                        }) 
                        }else{
                           list=[]
                           that.lists[idx].children[tid].children=list
                            //    that.lists.forEach((it1,idx1)=>{
                            //     it1.children.forEach((it2,idx2)=>{
                            //         that.getgglist(it1.brand_id,idx1,it2.brand_id,idx2)
                            //     })
                            // }) 
                        }
                    },
                    error: function (message) {}
                });
            },
            // 获取型号方法
            getgglist(it1,idx1,type,tid,it3,idx3){
                const that=this
                $.ajax({
                    type: "GET",
                    url: "index.php?s=/store/inventory.index/getmodellist&brand_id="+it1+'&type='+type+'&refractive_id='+it3,
                    success: function(data){
                        var list=JSON.parse(data)
                        console.log(list)
                        list.forEach((it,index)=>{
                            it.fbrand_id=it3
                            it.brand_id=it.model_id
                            it.brand_name=it.model
                        })
                        that.lists[idx1].children[tid].children[idx3].children=list
                        // console.log('11',that.lists[idx1].children[tid].children[idx3].children)
                        that.lists.forEach((it1,idx1)=>{
                            // 镜面
                            it1.children.forEach((it2,idx2)=>{
                                // 折射率
                                it2.children.forEach((its3,idx3)=>{
                                    // // 型号
                                    //    console.log(its3)
                                   its3.children.forEach((it4,idx4)=>{
                                       that.getinvlist(it1.brand_id,it2.brand_id,it3.brand_id,it4.brand_id)
                                   })
                                })
                            })
                        })
                        // console.log(that.lists)
                        that.options=that.lists
                    },
                    error: function (message) {}
                });
            },
            // 获取库存规格
            getinvlist(fid,id,refractive_id,zid){
                const that=this
                $.ajax({
                    type: "GET",
                    url: "index.php?s=/store/inventory.index/getspeclist&brand_id="+fid+'&type='+id+'&refractive_id='+refractive_id+'&model_id='+zid,
                    success: function(data){
                        var list=JSON.parse(data)
                        // console.log(list)
                        that.tableData=list
                    },
                    error: function (message) {
                        
                    }
                });
            },
            change1(event) {
                this.current = event
            },
            edit(i) {
                this.typelist = i.path
                // this.dialogVisible = true
                this.tit='修改'
                let list = this.options
                this.abc(list, this.typelist, 3,false)
            },
            add(i) {
                this.typelist = i.path
                this.dialogVisible = true
                this.tit='添加'
                let list = this.options
                this.abc(list, this.typelist, 1)
            },
            addPP() {
                let list = this.options
                if(this.tit=='修改'){
                    this.abc(list, this.typelist, 3,true)
                }else{
                    this.abc(list, this.typelist, 1)
                }
            },
            handleClose(done) {
                this.$confirm('确认关闭？')
                    .then(_ => {
                        this.dialogVisible = false
                    })
                    .catch(_ => {});
            },
            del(i) {
                const typelist = i.path
                let list = this.options
                this.abc(list, typelist, 2)
            },
            // type  1 添加   2删除  3修改
            abc(list, typelist, type,status) {
                // console.log(type)
                const that = this
                if (typelist.length == 1) {
                    var idx = null
                    list.some((item, index) => {
                        if (item.value == typelist[0]) {
                            idx = index
                            return false
                        }
                    });
                    switch (type) {
                        case 1:
                            that.status = 2
                            var obj = {
                                children: [],
                                label: that.sphereType,
                                value: that.sphereType
                            }
                            if (that.sphereType != '') {
                                list[idx].children.push(obj)
                                that.dialogVisible = false
                            }
                            break;
                        case 2:
                            list.splice(idx, 1)
                            that.options = list
                            break;
                        default://修改
                            if(!status){
                                this.name= list[idx].label
                                that.dialogVisible = true
                            }else{
                                list[idx].label= this.name
                                that.dialogVisible = false
                            }
                    }
                } else if (typelist.length == 2) {
                    var idx = null //父id
                    var oneidx = null //子id
                    list.some((item, index) => {
                        if (item.value == typelist[0]) {
                            idx = index
                            item.children.some((it, index) => {
                                if (it.value == typelist[1]) {
                                    oneidx = index
                                    return false
                                }
                            });
                        }
                    });
                    switch (type) {
                        case 1:
                            that.status = 3
                            var obj = {
                                children: [],
                                label: that.refractive,
                                value: that.refractive
                            }
                            if (that.refractive != '') {
                                list[idx].children[oneidx].children.push(obj)
                                that.dialogVisible = false
                            }
                            break;
                        case 2:
                            list[idx].children.splice(oneidx, 1)
                            that.options = list
                            break;
                        default://修改
                        if(!status){
                            this.name= list[idx].children[oneidx].label
                            that.dialogVisible = true
                        }else{
                            list[idx].children[oneidx].label= this.name
                            that.dialogVisible = false
                        }
                    }
                } else if (typelist.length == 3) {
                    var idx = null //父id
                    var oneidx = null //一层子id
                    var twoidx = null
                    list.some((item, index) => {
                        if (item.value == typelist[0]) {
                            idx = index
                            item.children.some((it, index) => {
                                if (it.value == typelist[1]) {
                                    oneidx = index
                                    it.children.forEach((it2, idx2) => {
                                        if (it2.value == typelist[2]) {
                                            twoidx = idx2
                                            return false
                                        }
                                    });
                                }
                            });
                        }
                    });
                    switch (type) {
                        case 1:
                            that.status = 4
                            var obj = {
                                children: [],
                                label: that.types,
                                value: that.types
                            }
                            if (that.types != '') {
                                if (list[idx].children[oneidx].children[twoidx].children == undefined) {
                                    list[idx].children[oneidx].children[twoidx].children = []
                                }
                                list[idx].children[oneidx].children[twoidx].children.push(obj)
                                // console.log(list[idx].children[oneidx].children[twoidx])
                                that.dialogVisible = false
                            }
                            break;
                        case 2:
                            list[idx].children[oneidx].children.splice(twoidx, 1)
                            that.options = list
                            break;
                        default://修改
                            if(!status){
                                this.name= list[idx].children[oneidx].children[twoidx].label
                                that.dialogVisible = true
                            }else{
                                list[idx].children[oneidx].children[twoidx].label= this.name
                                that.dialogVisible = false
                            } 
                    }
                } else if (typelist.length == 4) {
                    var idx = null //父id
                    var oneidx = null //一层子id
                    var twoidx = null //二成子id
                    var threeidx = null //二成子id
                    list.some((item, index) => {
                        if (item.value == typelist[0]) {
                            idx = index
                            item.children.some((it, index) => {
                                if (it.value == typelist[1]) {
                                    oneidx = index
                                    it.children.forEach((it2, idx2) => {
                                        if (it2.value == typelist[2]) {
                                            twoidx = idx2
                                            it2.children.forEach((it3, idx3) => {
                                                if (it3.value == typelist[
                                                    3]) {
                                                    threeidx = idx3
                                                    return false
                                                }
                                            })
                                        }
                                    });
                                }
                            });
                        }
                    });
                    switch (type) {
                        case 1:
                            that.status = 5
                            var obj = {
                                children: [],
                                label: that.inventory,
                                value: that.inventory
                            }
                            var obj1 = {
                                children: [],
                                label: that.price,
                                value: that.price
                            }
                            if (that.inventory != '' || that.price != '') {
                                if (list[idx].children[oneidx].children[twoidx].children[threeidx]
                                    .children == undefined) {
                                    list[idx].children[oneidx].children[twoidx].children[threeidx]
                                        .children = []
                                }
                                list[idx].children[oneidx].children[twoidx].children[threeidx].children
                                    .push(obj)
                                if (list[idx].children[oneidx].children[twoidx].children[threeidx].children[
                                        0].children == undefined) {
                                    list[idx].children[oneidx].children[twoidx].children[threeidx].children[
                                        0].children = []
                                }
                                list[idx].children[oneidx].children[twoidx].children[threeidx].children[0]
                                    .children.push(obj1)
                                that.dialogVisible = false
                            }
                            break;
                        case 2:
                            // 后面所有关联数据都删除
                            list[idx].children[oneidx].children[twoidx].children.splice(threeidx, 1)
                            that.options = list
                            break;
                        default://修改
                            if(!status){
                                this.name= list[idx].children[oneidx].children[twoidx].children[threeidx].label
                                that.dialogVisible = true
                            }else{
                                list[idx].children[oneidx].children[twoidx].children[threeidx].label= this.name
                                that.dialogVisible = false
                            }
                    }
                }
            }
        }
    });
</script>



