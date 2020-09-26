<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">编辑管理员</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">业务员 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="plan[salesman_id]">
                                        <option value="">请选择</option>
                                        <?php if (!$roleList->isEmpty()): foreach ($roleList as $item): ?>
                                            <option value="<?=$item['salesman_id']?>" <?= $item['salesman_id'] ==$model['salesman_id'] ? 'selected' : '' ?> ><?=$item['real_name']?></option>
                                        <?php endforeach; else: ?>
                                        <option value="">暂无业务员</option><tr>
                                            <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?=$model['id']?>">
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">月份 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="plan[month]">
                                        <option value="" >请选择</option>
                                        <option value="1" <?= $model['month'] ==1 ? 'selected' : '' ?> >一月</option>
                                        <option value="2" <?= $model['month'] ==2 ? 'selected' : '' ?> >二月</option>
                                        <option value="3" <?= $model['month'] ==3 ? 'selected' : '' ?> >三月</option>
                                        <option value="4" <?= $model['month'] ==4 ? 'selected' : '' ?> >四月</option>
                                        <option value="5" <?= $model['month'] ==5 ? 'selected' : '' ?> >五月</option>
                                        <option value="6" <?= $model['month'] ==6 ? 'selected' : '' ?> >六月</option>
                                        <option value="7" <?= $model['month'] ==7 ? 'selected' : '' ?> >七月</option>
                                        <option value="8" <?= $model['month'] ==8 ? 'selected' : '' ?> >八月</option>
                                        <option value="9" <?= $model['month'] ==9 ? 'selected' : '' ?> >九月</option>
                                        <option value="10" <?= $model['month'] ==10 ? 'selected' : '' ?> >十月</option>
                                        <option value="11" <?= $model['month'] ==11 ? 'selected' : '' ?> >十一月</option>
                                        <option value="12" <?= $model['month'] ==12 ? 'selected' : '' ?> >十二月</option>
                                    </select>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">本月任务(元) </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="plan[basis]"
                                           value="<?= $model['basis'] ?>" placeholder="请输入基础目标" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">常规品任务(元) </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="plan[con_goods]"
                                           value="<?= $model['con_goods'] ?>" placeholder="请输入常规品任务" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">新品任务(元) </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="plan[new_goods]"
                                           value="<?= $model['new_goods'] ?>" placeholder="请输入新品任务" required>
                                </div>
                            </div>


                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交
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
<script src="assets/store/js/select.region.js?v=1.2"></script>

<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
