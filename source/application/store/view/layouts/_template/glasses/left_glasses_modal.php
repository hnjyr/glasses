<!-- Modal -->
<!--<script src="https://cdn.bootcss.com/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>-->
<?php
/*use think\db;
use think\Session;*/

$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
$glasses_brand = Db::name('glasses_brand')->where('is_delete',0)->where('user_id',$admin_info['user_id'])->select();
?>


<div class="modal fade" id="myLeftGlassesModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">镜框规格选择</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group left_glasses_form">
                        <label for="recipient-name" class="control-label">镜框品牌:</label>
                        <select onchange="left_glassesBrandChange(1)" id="left_glasses_brand" name="data[glasses_brand]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择品牌</option>
                            <?php foreach ($glasses_brand as $value): ?>
                            <option value="<?=$value['brand_id'] ?>"><?=$value['brand_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>



                    <div class="form-group left_glasses_form">
                        <label for="recipient-name" class="control-label">镜框型号:</label>
                        <select onchange="left_glassesModelChange(2)"  id="left_glasses_model" name="data[glasses_model]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择型号</option>
                        </select>
                    </div>
                    <div class="form-group left_glasses_form">
                        <label for="recipient-name" class="control-label">镜框颜色:</label>
                        <select onchange="left_glassesColorChange()"  id="left_glasses_color" name="data[glasses_color]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择颜色</option>
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
                <button onclick="left_submit()" id="left_glasses_submit" type="button"  class="btn btn-primary ">选定</button>
            </div>
        </div>
    </div>
</div>
<script>

    var glasses_brand = $('#left_glasses_brand  option:selected').val();
    var glasses_btn = $('#left_glasses_submit');
    var selectInfo = $('.left_glasses_form').find('select');
    $('#left_glassesBtn').click(function () {
        var selectInfo = $('.left_glasses_form').find('select');
        if (glasses_brand==0){
            selectInfo.find('option:selected').attr('selected',false);
            selectInfo.disabled=true;
            for (var i = 1 ; i < selectInfo.length; i ++) {
                glasses_btn.attr('disabled',true);
                glasses_btn.css({'background-color' : 'gray'});
                selectInfo[i].disabled = true;

            }
        }
    })
    function left_glassesBrandChange(i) {
        var selectInfo = $('.left_glasses_form').find('select');
        var glasses_brand = $('#left_glasses_brand  option:selected').val();
        var j = i;
        if (glasses_brand != 0){
            $('#left_glasses_brand').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.glasses.model/getmodel',
                data:{glasses_brand:glasses_brand},
                success: function (result) {
                    $("#left_glasses_model").empty();
                    $("#left_glasses_model").append("<option value='0'>请选择型号</option>");
                    if (result.data.length != 0 ){

                        for (var i = 0 ;i < result.data.length;i++){

                            $("#left_glasses_model").append("<option value='"+result.data[i]['model']+"'>"+result.data[i]['model']+"</option>");
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

    function left_glassesModelChange(i) {
        var selectInfo = $('.left_glasses_form').find('select');
        var glasses_model = $('#left_glasses_model  option:selected').val();
        var glasses_brand = $('#left_glasses_brand  option:selected').val();
        var j = i;
        if (glasses_model != 0){
            $('#left_glasses_model').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.glasses.specification/getcolor',
                data:{glasses_brand:glasses_brand,glasses_model:glasses_model},
                success: function (result) {
                    $("#left_glasses_color").empty();
                    $("#left_glasses_color").append("<option value='0'>请选择颜色</option>");
                    if (result.data.length != 0 ){

                        for (var i = 0 ;i < result.data.length;i++){

                            $("#left_glasses_color").append("<option value='"+result.data[i]['color']+"'>"+result.data[i]['color']+"</option>");
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
    function left_glassesColorChange() {
        var selectInfo = $('.left_glasses_form').find('select');
        var glasses_color = $('#left_glasses_color  option:selected').val();
        var glasses_btn = $('#left_glasses_submit');
        if (glasses_color != 0){
            glasses_btn.attr('disabled',false);
            glasses_btn.css({'background-color' : '#337ab7'});
        }
        else {
            glasses_btn.attr('disabled',true);
            glasses_btn.css({'background-color' : 'gray'});
        }
    }
    function left_submit(){
        var glasses_btn = $('#left_glasses_submit');
        var selectInfo = $('.left_glasses_form').find('select');
        var glasses_brand = $('#left_glasses_brand  option:selected').val();
        var glasses_model = $('#left_glasses_model  option:selected').val();
        var glasses_color = $('#left_glasses_color  option:selected').val();
        glasses_btn.attr('disabled',true);
        glasses_btn.css({'background-color' : 'gray'});
        $('#left_glasses_submit').ajaxSubmit({
            type: "post",
            dataType: "json",
            url: 'index.php?s=/store/inventory.glasses.specification/getspecification',
            data:{glasses_brand:glasses_brand,glasses_model:glasses_model,glasses_color:glasses_color},
            success: function (result) {
                // console.log(result);return;
                if (result.data.length != 0 ){
                    for (var i = 0 ;i < result.data.length;i++){
                        var data = [
                            result.data[i].brand_name+'  '+
                            result.data[i].model+'  '+
                            result.data[i].color

                        ];
                        var ids = result.data[i].specification_id;
                        // console.log(ids);return;
                        console.log(data);
                        $("#left_glassesInfo").val(data);
                        $("#left_glassesInfo").attr('readonly',true);
                        $("#left_glassesInfo").css('display','block');
                        $("#left_glassesBtn").css('float','right');
                        $('#left_glasses_num').attr('max',result.data[i].now_inventory);

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
