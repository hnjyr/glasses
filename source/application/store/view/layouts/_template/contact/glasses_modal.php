
<?php


//use think\Session;

$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
$contact_brand = Db::name('contact_brand')->where('is_delete',0)->where('user_id',$admin_info['user_id'])->select();
?>


<div class="modal fade" id="myContactModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">隐形眼镜规格选择</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜品牌:</label>
                        <select onchange="contact_brandChange(1)" id="contact_brand" name="data[contact_brand]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择品牌</option>
                            <?php foreach ($contact_brand as $value): ?>
                                <option value="<?=$value['brand_id'] ?>"><?=$value['brand_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜类型:</label>
                        <select onchange="contact_typeChange(2)" id="contact_type" name="data[contact_type]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="null">请选择类型</option>
                            <option value="0">球面</option>
                            <option value="1">非球面</option>
                        </select>
                    </div>

                    <div class="form-group contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜型号:</label>
                        <select onchange="contact_modelChange(3)"  id="contact_model" name="data[contact_model]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择型号</option>
                        </select>
                    </div>
                    <div class="form-group contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜颜色:</label>
                        <select onchange="contact_colorChange(4)"  id="contact_color" name="data[contact_color]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择颜色</option>
                        </select>
                    </div>
                    <div class="form-group contact-form-group">
                        <label for="recipient-name" class="control-label">隐形眼镜度数:</label>
                        <select onchange="contact_degreeChange()" id="contact_degree" name="data[contact_degree]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="">请选择度数</option>
                            <?php for ($i = 0 ;$i <= 1000 ;$i +=25) :?>
                                <option value="<?=$i ?>"><?=$i ?></option>
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
                <button onclick="submit_contact()" id="contact_submit" type="button"  class="btn btn-primary ">选定</button>
            </div>
        </div>
    </div>
</div>
<script>

    var contact_brand = $('#contact_brand  option:selected').val();
    var contact_btn = $('#contact_submit');
    var contact_type = $('#contact_type  option:selected').val();
    var selectInfo = $('.contact-form-group').find('select');

    $('#contactBtn').click(function () {
        var contact_brand = $('#contact_brand  option:selected').val();
        var selectInfo = $('.contact-form-group').find('select');
        var contact_btn = $('#contact_submit');
        if (contact_brand==0){
            selectInfo.find('option:selected').attr('selected',false);
            selectInfo.disabled=true;
            for (var i = 1 ; i < selectInfo.length; i ++) {
                contact_btn.attr('disabled',true);
                contact_btn.css({'background-color' : 'gray'});
                selectInfo[i].disabled = true;

            }
        }
    })
    function contact_brandChange(i) {
        var selectInfo = $('.contact-form-group').find('select');
        var contact_brand = $('#contact_brand  option:selected').val();
        if (contact_brand != 0){
            selectInfo[i].disabled =false;
        }else {
            selectInfo[i].disabled =true;
        }
    }
    function contact_typeChange(i) {
        var selectInfo = $('.contact-form-group').find('select');
        var contact_brand = $('#contact_brand  option:selected').val();
        var contact_type = $('#contact_type  option:selected').val();
        var j = i;
        if (!isNaN(contact_type)){
            $('#contact_type').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.contact.model/getmodel',
                data:{contact_type:contact_type,contact_brand:contact_brand},
                success: function (result) {
                    // console.log(result);return;
                    $("#contact_model").empty();
                    $("#contact_model").append("<option value='0'>请选择型号</option>");
                    if (result.data.length != 0 ){
                        for (var i = 0 ;i < result.data.length;i++){
                            // console.log(result.data[i]['model_id']);return;
                            $("#contact_model").append("<option value='"+result.data[i]['model_id']+"'>"+result.data[i]['model']+"</option>");
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
    function contact_modelChange(i) {
        var selectInfo = $('.contact-form-group').find('select');
        var contact_brand = $('#contact_brand  option:selected').val();
        var contact_type = $('#contact_type  option:selected').val();
        var contact_model = $('#contact_model  option:selected').val();
        var j = i;
        if (contact_model != 0){
            $('#contact_model').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.contact.color/getcolor',
                data:{contact_type:contact_type,contact_brand:contact_brand,contact_model:contact_model},
                success: function (result) {
                    $("#contact_color").empty();
                    $("#contact_color").append("<option value='0'>请选择颜色</option>");
                    if (result.data.length != 0 ){
                        for (var i = 0 ;i < result.data.length;i++){
                            $("#contact_color").append("<option value='"+result.data[i]['color_id']+"'>"+result.data[i]['color']+"</option>");
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
    function contact_colorChange(i) {
        var selectInfo = $('.contact-form-group').find('select');
        var contact_brand = $('#contact_brand  option:selected').val();
        var contact_type = $('#contact_type  option:selected').val();
        var contact_color = $('#contact_color  option:selected').val();
        if (contact_color != 0){
            selectInfo[i].disabled =false;
        }
        else {
            selectInfo[i].disabled =true;
        }
    }
    function contact_degreeChange() {
        var contact_btn = $('#contact_submit');
        var contact_degree = $('#contact_degree  option:selected').val();
        if (contact_degree != 0){

            contact_btn.attr('disabled',false);
            contact_btn.css({'background-color' : '#337ab7'});
        }
        else {
            contact_btn.attr('disabled',true);
            contact_btn.css({'background-color' : 'gray'});
        }
    }
    function submit_contact(){
        var contact_brand = $('#contact_brand  option:selected').val();
        var contact_btn = $('#contact_submit');
        var contact_type = $('#contact_type  option:selected').val();
        var selectInfo = $('.contact-form-group').find('select');
        var contact_degree = $('#contact_degree  option:selected').val();
        var contact_model = $('#contact_model  option:selected').val();
        var contact_color = $('#contact_color  option:selected').val();

        var l = '';
        if(contact_type == 0){
            l = '球面';
        }else {
            l = '非球面';
        }

        contact_btn.attr('disabled',true);
        contact_btn.css({'background-color' : 'gray'});
        $('#contact_submit').ajaxSubmit({
            type: "post",
            dataType: "json",
            url: 'index.php?s=/store/inventory.contact.specification/getspecification',
            data:{contact_type:contact_type,contact_brand:contact_brand,contact_model:contact_model,contact_degree:contact_degree,contact_color:contact_color},
            success: function (result) {
                if (result.data.length != 0 ){
                    for (var i = 0 ;i < result.data.length;i++){
                        var data = [
                            result.data[i].brand_name+' '+
                            l+' '+
                            result.data[i].model+' '+
                            result.data[i].degree+' '+
                            result.data[i].color

                        ];
                        var ids = result.data[i].specification_id;
                        // console.log(ids);return;
                        console.log(data);
                        $("#right_contact_specification_id").val(ids);
                        $("#contactBrandInfo").val(data);
                        $("#contactBrandInfo").attr('readonly',true);
                        $("#contactBrandInfo").css('display','block');
                        $("#contactBtn").css('float','right');
                        $('#contact_num').attr('max',result.data[i].now_inventory);

                        $('.close').click();
                        console.log(result.data[i]);

                    }
                }else{
                    layer.msg('暂无记录，请先添加！', {time: 1500, anim: 6});
                    contact_btn.attr('disabled',false);
                    contact_btn.css({'background-color' : '#337ab7'});
                }

            }
        });
    }


</script>
