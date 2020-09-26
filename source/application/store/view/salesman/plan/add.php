<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">添加业务员计划</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">业务员 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="plan[salesman_id]">
                                        <option value="">请选择</option>
                                        <?php if (!$roleList->isEmpty()): foreach ($roleList as $item): ?>
                                        <option value="<?=$item['salesman_id']?>"><?=$item['real_name']?></option>
                                        <?php endforeach; else: ?>
                                            <option value="">暂无业务员</option><tr>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">月份 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="plan[month]">
                                            <option value="">请选择</option>
                                            <option value="1">一月</option>
                                            <option value="2">二月</option>
                                            <option value="3">三月</option>
                                            <option value="4">四月</option>
                                            <option value="5">五月</option>
                                            <option value="6">六月</option>
                                            <option value="7">七月</option>
                                            <option value="8">八月</option>
                                            <option value="9">九月</option>
                                            <option value="10">十月</option>
                                            <option value="11">十一月</option>
                                            <option value="12">十二月</option>
                                    </select>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">本月任务(元) </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="plan[basis]"
                                           value="" placeholder="请输入本月任务" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">常规品任务(元) </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="plan[con_goods]"
                                           value="" placeholder="请输入常规品任务" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">新品任务(元) </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="plan[new_goods]"
                                           value="" placeholder="请输入新品任务" required>
                                </div>
                            </div>
                            <div class="am-form-group" style="display: none">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">新签门店目标数 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="plan[shop_num]"
                                           value="" placeholder="请输入新签门店目标数" required>
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
