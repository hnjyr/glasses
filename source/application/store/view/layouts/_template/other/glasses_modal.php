<!-- Modal -->
<!--<script src="https://cdn.bootcss.com/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>-->
<?php

$admin_info = Db::name('store_user')->where(['store_user_id'=>Session::get('yoshop_store')['user']['store_user_id']])->find();
$other_brand = Db::name('other_brand')->where('is_delete',0)->where('user_id',$admin_info['user_id'])->select();
?>


<div class="modal fade" id="myOtherModal"  role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">其他规格选择</h4>
            </div>
            <div class="modal-body">

                <form>
                    <div class="form-group other_form">
                        <label for="recipient-name" class="control-label">其他品牌:</label>
                        <select onchange="otherBrandChange(1)" id="other_brand" name="data[other_brand]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择品牌</option>
                            <?php foreach ($other_brand as $value): ?>
                            <option value="<?=$value['brand_id'] ?>"><?=$value['brand_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>



                    <div class="form-group other_form">
                        <label for="recipient-name" class="control-label">其他型号:</label>
                        <select onchange="otherModelChange()"  id="other_model" name="data[other_model]" class="selectpicker show-tick form-control"  data-live-search="false">
                            <option value="0">请选择型号</option>
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
                <button onclick="submit_other()" id="other_submit" type="button"  class="btn btn-primary ">选定</button>
            </div>
        </div>
    </div>
</div>
<script>

    var other_brand = $('#other_brand  option:selected').val();
    var other_model = $('#other_model  option:selected').val();
    var other_submit = $('#other_submit');
    var selectInfo = $('.other_form').find('select');
    $('#otherBtn').click(function () {
        var selectInfo = $('.other_form').find('select');
        var other_submit = $('#other_submit');
        var other_brand = $('#other_brand  option:selected').val();
        if (other_brand==0){
            selectInfo.find('option:selected').attr('selected',false);
            selectInfo.disabled=true;
            for (var i = 1 ; i < selectInfo.length; i ++) {
                other_submit.attr('disabled',true);
                other_submit.css({'background-color' : 'gray'});
                selectInfo[i].disabled = true;

            }
        }
    })
    function otherBrandChange(i) {
        var selectInfo = $('.other_form').find('select');
        var other_brand = $('#other_brand  option:selected').val();
        var j = i;
        if (other_brand != 0){
            $('#other_brand').ajaxSubmit({
                type: "post",
                dataType: "json",
                url: 'index.php?s=/store/inventory.other.model/getmodel',
                data:{other_brand:other_brand},
                success: function (result) {
                    $("#other_model").empty();
                    $("#other_model").append("<option value='0'>请选择型号</option>");
                    if (result.data.length != 0 ){

                        for (var i = 0 ;i < result.data.length;i++){

                            $("#other_model").append("<option value='"+result.data[i]['model']+"'>"+result.data[i]['model']+"</option>");
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

    function otherModelChange() {
        var selectInfo = $('.other_form').find('select');
        var other_submit = $('#other_submit');
        var other_model = $('#other_model  option:selected').val();
        var other_brand = $('#other_brand  option:selected').val();
        if (other_model != 0){
            other_submit.attr('disabled',false);
            other_submit.css({'background-color' : '#337ab7'});
        }
        else {
            other_submit.attr('disabled',true);
            other_submit.css({'background-color' : 'gray'});
        }
    }
    function submit_other(){
        var selectInfo = $('.other_form').find('select');
        var other_submit = $('#other_submit');
        var other_model = $('#other_model  option:selected').val();
        var other_brand = $('#other_brand  option:selected').val();
        other_submit.attr('disabled',true);
        other_submit.css({'background-color' : 'gray'});
        $('#other_submit').ajaxSubmit({
            type: "post",
            dataType: "json",
            url: 'index.php?s=/store/inventory.other.specification/getspecification',
            data:{other_brand:other_brand,other_model:other_model},
            success: function (result) {
                // console.log(result);return;
                if (result.data.length != 0 ){
                    for (var i = 0 ;i < result.data.length;i++){
                        var data = [
                            result.data[i].brand_name+'—'+
                            result.data[i].model

                        ];
                        console.log(data);
                        var ids = result.data[i].specification_id;
                        $("#other_specification_id").val(ids);
                        $("#otherInfo").val(data);
                        $("#otherInfo").attr('readonly',true);
                        $("#otherInfo").css('display','block');
                        $("#otherBtn").css('float','right');
                        $('#other_num').attr('max',result.data[i].now_inventory);

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
