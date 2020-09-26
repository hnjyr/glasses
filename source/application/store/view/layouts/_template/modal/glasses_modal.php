
<?php

//use think\db;
//use think\Session;

$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
$brand = Db::name('brand')->where('is_delete',0)->where('user_id',$admin_info['user_id'])->select();
?>


<div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">镜片规格选择</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group les-form-group">
                        <label for="recipient-name" class="control-label">镜片品牌:</label>
                        <select onchange="brandChange(1)" id="brand" name="data[brand]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择品牌</option>
                            <?php foreach ($brand as $brand): ?>
                            <option value="<?=$brand['brand_id'] ?>"><?=$brand['brand_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group les-form-group">
                        <label for="recipient-name" class="control-label">镜片类型:</label>
                        <select onchange="typeChange(2)" id="type" name="data[type]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="null">请选择类型</option>
                            <option value="0">球面</option>
                            <option value="1">非球面</option>
                        </select>
                    </div>
                    <div class="form-group les-form-group">
                        <label for="recipient-name" class="control-label">镜片折射率:</label>
                        <select onchange="refractiveChange(3)" id="refractive" name="data[refractive]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择折射率</option>

                        </select>
                    </div>

                    <div class="form-group les-form-group">
                        <label for="recipient-name" class="control-label">镜片型号:</label>
                        <select onchange="modelChange(4)"  id="model" name="data[model]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择型号</option>
                        </select>
                    </div>
                    <div class="form-group les-form-group">
                        <label for="recipient-name" class="control-label">镜片球镜度数:</label>
                       <!-- <select onchange="spherical_lensChange(5)" id="spherical_lens" name="data[spherical_lens]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="">请选择球镜度数</option>
                            <?php for ($i = 0 ;$i <= 1000 ;$i +=25) :?>
                                <option value="<?=$i ?>"><?=$i ?></option>
                            <?php endfor; ?>
                        </select> -->
						<input type="number"class="form-control" id="spherical_lens" placeholder="请输入镜片球镜度数" oninput="if(value.length>5)value=value.slice(0,5)" name="data[spherical_lens]">
                    </div>
                    <div class="form-group les-form-group">
                        <label for="recipient-name" class="control-label">镜片柱镜度数:</label>
                        <!-- <select onchange="cytdnderChange()"  id="cytdnder" name="data[cytdnder]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="">请选择柱镜度数</option>
                            <?php for ($j = 0 ;$j <= 1000 ;$j +=25) :?>
                                <option value="<?=$j ?>"><?=$j ?></option>
                            <?php endfor; ?>
                        </select> -->
						<input type="number"class="form-control" id="cytdnder" placeholder="请输入镜片柱镜度数" oninput="if(value.length>5)value=value.slice(0,5)" name="data[cytdnder]">
                    </div>
                    <!--<div class="form-group">
                        <label class="col-sm-3 control-label">镜片标准库存：</label>
                        <input type="text" class="form-control" id="standard_inventory">
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">镜片现有库存：</label>
                        <input type="text" class="form-control" id="now_inventory">
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">镜片单价：</label>
                        <input type="text" class="form-control" id="price">
                    </div>-->

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button onclick="submit_les()" id="submit_xz" type="button"  class="btn btn-primary ">选定</button>
            </div>
        </div>
    </div>
</div>
<script>

    var brand = $('#brand  option:selected').val();
    var btn = $('#submit_xz');
    var type = $('#type  option:selected').val();
    var refractive = $('#refractive  option:selected').val();
    var selectInfo = $('.les-form-group').find('select');

    $('#brandBtn').click(function () {
        var selectInfo = $('.les-form-group').find('select');
        if (brand==0){
            selectInfo.find('option:selected').attr('selected',false);
            selectInfo.disabled=true;
            for (var i = 1 ; i < selectInfo.length; i ++) {
                btn.attr('disabled',true);
                btn.css({'background-color' : 'gray'});
                selectInfo[i].disabled = true;

            }
        }
    })
    function brandChange(i) {
        var selectInfo = $('.les-form-group').find('select');
        var brand = $('#brand  option:selected').val();
        if (brand != 0){
            selectInfo[i].disabled =false;
        }else {
            selectInfo[i].disabled =true;
        }
    }
    function typeChange(i) {
        var selectInfo = $('.les-form-group').find('select');
        var brand = $('#brand  option:selected').val();
        var type = $('#type  option:selected').val();
        var j = i;
        if (!isNaN(type)){
            $('#type').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.refractive/getrefractive',
                data:{type:type,brand:brand},
                success: function (result) {
                    $("#refractive").empty();
                    $("#refractive").append("<option value='0'>请选择折射率</option>");
                    if (result.data.length != 0 ){
                        for (var i = 0 ;i < result.data.length;i++){
                            $("#refractive").append("<option value='"+result.data[i]['refractive_num']+"'>"+result.data[i]['refractive_num']+"</option>");
                        }
                        selectInfo[j].disabled =false;
                    }else{
                        layer.msg('暂无数据', {time: 1500, anim: 6});
                        selectInfo[j].disabled =true;
                    }

                }
            });


        }else {
            selectInfo[i].disabled =true;
        }
    }
    function refractiveChange(i) {
        var selectInfo = $('.les-form-group').find('select');
        var brand = $('#brand  option:selected').val();
        var type = $('#type  option:selected').val();
        var refractive = $('#refractive  option:selected').val();
        var j = i;
        if (refractive != 0){
            $('#refractive').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.model/getmodel',
                data:{type:type,brand:brand,refractive:refractive},
                success: function (result) {
                    $("#model").empty();
                    $("#model").append("<option value='0'>请选择型号</option>");
                    if (result.data.length != 0 ){

                        for (var i = 0 ;i < result.data.length;i++){

                            $("#model").append("<option value='"+result.data[i]['model']+"'>"+result.data[i]['model']+"</option>");
                        }
                        selectInfo[j].disabled =false;
                    }else{
                        layer.msg('暂无数据', {time: 1500, anim: 6});
                        selectInfo[j].disabled =true;
                    }

                }
            });
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function modelChange(i) {
        var selectInfo = $('.les-form-group').find('select');
        var model = $('#model  option:selected').val();
        if (model != 0){
            selectInfo[i].disabled =false;
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function spherical_lensChange(i) {
        var selectInfo = $('.les-form-group').find('select');
        var brand = $('#brand  option:selected').val();
        var type = $('#type  option:selected').val();
        var refractive = $('#refractive  option:selected').val();
        var model = $('#model  option:selected').val();
        var spherical_lens = $('#spherical_lens  option:selected').val();
        var j = i;
        if (spherical_lens != 0){
            selectInfo[i].disabled =false;
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function cytdnderChange() {
        var cytdnder = $('#cytdnder  option:selected').val();
        var btn = $('#submit_xz');
        if (cytdnder != 0){

            btn.attr('disabled',false);
            btn.css({'background-color' : '#337ab7'});
        }
        else {
            btn.attr('disabled',true);
            btn.css({'background-color' : 'gray'});
        }
    }
    function submit_les(){
        var selectInfo = $('.les-form-group').find('select');
        var btn = $('#submit_xz');
        var brand = $('#brand  option:selected').val();
        var type = $('#type  option:selected').val();
        var l = '';
        if(type == 0){
            l = '球面';
        }else {
            l = '非球面';
        }
        var refractive = $('#refractive  option:selected').val();
        var model = $('#model  option:selected').val();
        var spherical_lens = $('#spherical_lens').val();
        var cytdnder = $('#cytdnder').val();
        btn.attr('disabled',true);
        btn.css({'background-color' : 'gray'});
        $('#submit_xz').ajaxSubmit({
            type: "post",
            dataType: "json",
            url: 'index.php?s=/store/inventory.specification/getrespecification',
            data:{type:type,brand:brand,refractive:refractive,model:model,spherical_lens:spherical_lens,cytdnder:cytdnder},
            success: function (result) {
                // console.log(result);return;
                if (result.data.length != 0 ){
                    for (var i = 0 ;i < result.data.length;i++){
                        var data = [
                            result.data[i].brand_name+'  '+
                            l+'  '+
                            result.data[i].refractive_num+'  '+
                            result.data[i].model+'  '+
                            result.data[i].spherical_lens+'/'+
                            result.data[i].cytdnder

                        ];
                        var ids = result.data[i].specification_id;
                        // console.log(ids);return;
                        console.log(data);
                        $("#brandInfo").val(data);
                        $("#right_specification_id").val(ids);
                        $("#brandInfo").attr('readonly',true);
                        $("#brandInfo").css('display','block');
                        $("#brandBtn").css('float','right');
                        $('#now_inventory_num').attr('max',result.data[i].now_inventory);

                        $('.close').click();
                        console.log(result.data[i]);
						btn.attr('disabled',false);
						btn.css({'background-color' : '#286090'});
                    }
                }else{
                    layer.msg('暂无记录，请先添加！', {time: 1500, anim: 6});
					btn.attr('disabled',false);
					btn.css({'background-color' : '#286090'});
                }

            }
        });
    }


</script>
