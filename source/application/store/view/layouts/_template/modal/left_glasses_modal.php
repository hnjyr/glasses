
<?php


$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
$brand = Db::name('brand')->where('is_delete',0)->where('user_id',$admin_info['user_id'])->select();
?>


<div class="modal fade" id="myLeftModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">镜片规格选择</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group left_les-form-group">
                        <label for="recipient-name" class="control-label">镜片品牌:</label>
                        <select onchange="left_brandChange(1)" id="left_brand" name="data[brand]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择品牌</option>
                            <?php foreach ($brand as $brand): ?>
                            <option value="<?=$brand['brand_id'] ?>"><?=$brand['brand_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group left_les-form-group">
                        <label for="recipient-name" class="control-label">镜片类型:</label>
                        <select onchange="left_typeChange(2)" id="left_type" name="data[type]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="null">请选择类型</option>
                            <option value="0">球面</option>
                            <option value="1">非球面</option>
                        </select>
                    </div>
                    <div class="form-group left_les-form-group">
                        <label for="recipient-name" class="control-label">镜片折射率:</label>
                        <select onchange="left_refractiveChange(3)" id="left_refractive" name="data[refractive]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择折射率</option>

                        </select>
                    </div>

                    <div class="form-group left_les-form-group">
                        <label for="recipient-name" class="control-label">镜片型号:</label>
                        <select onchange="left_modelChange(4)"  id="left_model" name="data[model]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择型号</option>
                        </select>
                    </div>
                    <div class="form-group left_les-form-group">
                        <label for="recipient-name" class="control-label">镜片球镜度数:</label>
                        <select onchange="left_spherical_lensChange(5)" id="left_spherical_lens" name="data[spherical_lens]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="">请选择球镜度数</option>
                            <?php for ($i = 0 ;$i <= 1000 ;$i +=25) :?>
                                <option value="<?=$i ?>"><?=$i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group left_les-form-group">
                        <label for="recipient-name" class="control-label">镜片柱镜度数:</label>
                        <select onchange="left_cytdnderChange()"  id="left_cytdnder" name="data[cytdnder]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="">请选择柱镜度数</option>
                            <?php for ($j = 0 ;$j <= 1000 ;$j +=25) :?>
                                <option value="<?=$j ?>"><?=$j ?></option>
                            <?php endfor; ?>
                        </select>
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
                <button onclick="left_submit_les()" id="left_submit_xz" type="button"  class="btn btn-primary ">选定</button>
            </div>
        </div>
    </div>
</div>
<script>

    var brand = $('#left_brand  option:selected').val();
    var btn = $('#left_submit_xz');
    var type = $('#left_type  option:selected').val();
    var refractive = $('#left_refractive  option:selected').val();
    var selectInfo = $('.left_les-form-group').find('select');

    $('#left_brandBtn').click(function () {
        var selectInfo = $('.left_les-form-group').find('select');
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
    function left_brandChange(i) {
        var selectInfo = $('.left_les-form-group').find('select');
        var brand = $('#left_brand  option:selected').val();
        if (brand != 0){
            selectInfo[i].disabled =false;
        }else {
            selectInfo[i].disabled =true;
        }
    }
    function left_typeChange(i) {
        var selectInfo = $('.left_les-form-group').find('select');
        var brand = $('#left_brand  option:selected').val();
        var type = $('#left_type  option:selected').val();
        var j = i;
        if (!isNaN(type)){
            $('#left_type').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.refractive/getrefractive',
                data:{type:type,brand:brand},
                success: function (result) {
                    $("#left_refractive").empty();
                    $("#left_refractive").append("<option value='0'>请选择折射率</option>");
                    if (result.data.length != 0 ){
                        for (var i = 0 ;i < result.data.length;i++){
                            $("#left_refractive").append("<option value='"+result.data[i]['refractive_num']+"'>"+result.data[i]['refractive_num']+"</option>");
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
    function left_refractiveChange(i) {
        var selectInfo = $('.left_les-form-group').find('select');
        var brand = $('#left_brand  option:selected').val();
        var type = $('#left_type  option:selected').val();
        var refractive = $('#left_refractive  option:selected').val();
        var j = i;
        if (refractive != 0){
            $('#left_refractive').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.model/getmodel',
                data:{type:type,brand:brand,refractive:refractive},
                success: function (result) {
                    $("#left_model").empty();
                    $("#left_model").append("<option value='0'>请选择型号</option>");
                    if (result.data.length != 0 ){

                        for (var i = 0 ;i < result.data.length;i++){

                            $("#left_model").append("<option value='"+result.data[i]['model']+"'>"+result.data[i]['model']+"</option>");
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
    function left_modelChange(i) {
        var selectInfo = $('.left_les-form-group').find('select');
        var model = $('#left_model  option:selected').val();
        if (model != 0){
            selectInfo[i].disabled =false;
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function left_spherical_lensChange(i) {
        var selectInfo = $('.left_les-form-group').find('select');
        var brand = $('#left_brand  option:selected').val();
        var type = $('#left_type  option:selected').val();
        var refractive = $('#left_refractive  option:selected').val();
        var model = $('#left_model  option:selected').val();
        var spherical_lens = $('#left_spherical_lens  option:selected').val();
        var j = i;
        if (spherical_lens != 0){
            selectInfo[i].disabled =false;
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function left_cytdnderChange() {
        var cytdnder = $('#left_cytdnder  option:selected').val();
        var btn = $('#left_submit_xz');
        if (cytdnder != 0){

            btn.attr('disabled',false);
            btn.css({'background-color' : '#337ab7'});
        }
        else {
            btn.attr('disabled',true);
            btn.css({'background-color' : 'gray'});
        }
    }
    function left_submit_les(){
        var selectInfo = $('.left_les-form-group').find('select');
        var btn = $('#left_submit_xz');
        var brand = $('#left_brand  option:selected').val();
        var type = $('#left_type  option:selected').val();
        var l = '';
        if(type == 0){
            l = '球面';
        }else {
            l = '非球面';
        }
        var refractive = $('#left_refractive  option:selected').val();
        var model = $('#left_model  option:selected').val();
        var spherical_lens = $('#left_spherical_lens  option:selected').val();
        var cytdnder = $('#left_cytdnder  option:selected').val();
        btn.attr('disabled',true);
        btn.css({'background-color' : 'gray'});
        $('#left_submit_xz').ajaxSubmit({
            type: "post",
            dataType: "json",
            url: 'index.php?s=/store/inventory.specification/getrespecification',
            data:{type:type,brand:brand,refractive:refractive,model:model,spherical_lens:spherical_lens,cytdnder:cytdnder},
            success: function (result) {
                // console.log(result);return;
                if (result.data.length != 0 ){
                    for (var i = 0 ;i < result.data.length;i++){
                        var data = [
                            result.data[i].brand_name+'—'+
                            l+'—'+
                            result.data[i].refractive_num+'—'+
                            result.data[i].model+'—'+
                            result.data[i].spherical_lens+'—'+
                            result.data[i].cytdnder

                        ];
                        var ids = result.data[i].specification_id;
                        // console.log(ids);return;
                        console.log(data);
                        $("#left_specification_id").val(ids);
                        $("#left_brandInfo").val(data);
                        $("#left_brandInfo").attr('readonly',true);
                        $("#left_brandInfo").css('display','block');
                        $("#left_brandBtn").css('float','right');
                        $('#now_left_inventory_num').attr('max',result.data[i].now_inventory);

                        $('.close').click();
                        console.log(result.data[i]);

                    }
                }else{
                    layer.msg('暂无记录，请先添加！', {time: 1500, anim: 6});
                }

            }
        });
    }


</script>
