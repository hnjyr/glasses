<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title a m-cf">业务员计划列表</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        <div class="am-form-group">
                            <?php if (checkPrivilege('salesman.plan/add')): ?>
                                <div class="am-btn-group am-btn-group-xs">
                                    <a class="am-btn am-btn-default am-btn-success"
                                       href="<?= url('salesman.plan/add') ?>">
                                        <span class="am-icon-plus"></span> 新增
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>业务员ID</th>
                                <th>业务员姓名</th>
                                <th>月份</th>
                                <th>本月任务</th>
                                <th>常规品任务</th>
                                <th>新品任务</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['salesman_id'] ?></td>
                                    <td class="am-text-middle"><?= $item['real_name'] ?></td>
                                    <td class="am-text-middle"><?= $item['month'] ?></td>
                                    <td class="am-text-middle"><?= $item['basis'] ?></td>
                                    <td class="am-text-middle"><?= $item['con_goods'] ?></td>
                                    <td class="am-text-middle"><?= $item['new_goods'] ?></td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">

                                                    <a href="<?= url('salesman.plan/edit', ['user_id' => $item['salesman_id']]) ?>">
                                                        <i class="am-icon-pencil"></i> 编辑
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                       class="item-delete tpl-table-black-operation-del"
                                                       data-id="<?= $item['salesman_id'] ?>">
                                                        <i class="am-icon-trash"></i> 删除
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="5" class="am-text-center">暂无记录</td>
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
    </div>
</div>
<script>
    $(function () {

        // 删除元素
        var url = "<?= url('salesman.plan/delete') ?>";
        $('.item-delete').delete('user_id', url, '删除后不可恢复，确定要删除吗？');

    });
</script>

