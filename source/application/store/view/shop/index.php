<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title a m-cf">门店列表</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
<!--                        <div class="am-form-group">-->
<!--                            --><?php //if (checkPrivilege('shop/add')): ?>
<!--                                <div class="am-btn-group am-btn-group-xs">-->
<!--                                    <a class="am-btn am-btn-default am-btn-success"-->
<!--                                       href="--><?//= url('shop/add') ?><!--">-->
<!--                                        <span class="am-icon-plus"></span> 新增-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            --><?php //endif; ?>
<!--                        </div>-->
                    </div>
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>门店ID</th>
                                <th>门店名称</th>
                                <th>门店类型</th>
                                <th>门店logo</th>
                                <th>营业执照名字</th>
                                <th>联系人</th>
                                <th>性别</th>
                                <th>年龄</th>
                                <th>职位</th>
                                <th>联系电话</th>
                                <th>门店地址</th>
                                <th>门店状态</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['shop_id'] ?></td>
                                    <td class="am-text-middle"><?= $item['shop_name'] ?></td>
                                    <?php if($item['shop_type'] == 1):?>
                                        <td class="am-text-middle">门店</td>
                                    <?php  endif; ?>
                                    <?php if($item['shop_type'] == 2):?>
                                        <td class="am-text-middle">连锁店</td>
                                    <?php  endif; ?>
                                    <?php if($item['shop_type'] == 3):?>
                                        <td class="am-text-middle">经销商</td>
                                    <?php  endif; ?>
                                    <td class="am-text-middle">
                                        <a href="<?= $item['logo']['file_path'] ?>" title="点击查看大图" target="_blank">
                                            <img src="<?= $item['logo']['file_path'] ?>" width="72" height="72" alt="">
                                        </a>
                                    </td>
                                    <td class="am-text-middle"><?= $item['business_name'] ?></td>
                                    <td class="am-text-middle"><?= $item['linkman'] ?></td>
                                    <?php if($item['sex'] == 0):?>
                                    <td class="am-text-middle">保密</td>
                                    <?php  endif; ?>
                                    <?php if($item['sex'] == 1):?>
                                    <td class="am-text-middle">男</td>
                                    <?php  endif; ?>
                                    <?php if($item['sex'] == 2):?>
                                        <td class="am-text-middle">女</td>
                                    <?php  endif; ?>
                                    <td class="am-text-middle"><?= $item['years'] ?></td>

                                    <?php if($item['leader'] == 1):?>
                                        <td class="am-text-middle">采购</td>
                                    <?php  endif; ?>
                                    <?php if($item['leader'] == 2):?>
                                        <td class="am-text-middle">门店负责人</td>
                                    <?php  endif; ?>
                                    <?php if($item['leader'] == 3):?>
                                        <td class="am-text-middle">老板</td>
                                    <?php  endif; ?>

                                    <td class="am-text-middle"><?= $item['phone'] ?></td>
                                    <td class="am-text-middle">
                                        <?= $item['region']['province'] ?>  <?= $item['region']['city'] ?>  <?= $item['region']['region'] ?>
                                        <?= $item['address'] ?>
                                    </td>
<!--                                    <td class="am-text-middle">-->
<!--                                            <span class="am-badge am-badge---><?//= $item['is_check'] ? 'success' : 'warning' ?><!--">-->
<!--                                               --><?//= $item['is_check'] ? '支持' : '不支持' ?>
<!--                                           </span>-->
<!--                                    </td>-->
                                    <td class="am-text-middle">

                                        <?php if($item['status'] == 0):?>
                                            <span class="am-badge am-badge-warning">
                                              待审核
                                           </span>
                                        <?php  endif; ?>
                                        <?php if($item['status'] == 1):?>
                                        <span class="am-badge am-badge-success">
                                              启用
                                           </span>
                                        <?php  endif; ?>
                                        <?php if($item['status'] == 2):?>
                                        <span class="am-badge am-badge-warning">
                                              禁用
                                           </span>
                                        <?php  endif; ?>

                                    </td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('shop/edit')): ?>
                                                <a href="<?= url('shop/edit', ['shop_id' => $item['shop_id']]) ?>">
                                                    <i class="am-icon-pencil"></i> 编辑
                                                </a>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('shop/delete')): ?>
                                                <a href="javascript:void(0);"
                                                   class="item-delete tpl-table-black-operation-del"
                                                   data-id="<?= $item['shop_id'] ?>">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('shop/agree')): ?>
                                            <?php if ($item['status'] == 0): ?>
                                                <a href="javascript:void(0);"
                                                   class="item-agree tpl-table-black-operation-success"
                                                   data-id="<?= $item['shop_id'] ?>">
                                                    <i class="am-icon-digg"></i> 通过
                                                </a>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('shop/disagree')): ?>
                                                <?php if ($item['status'] == 0): ?>
                                                    <a href="javascript:void(0);"
                                                       class="item-disagree tpl-table-black-operation-del"
                                                       data-id="<?= $item['shop_id'] ?>">
                                                        <i class="am-icon-dashboard"></i> 拒绝
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="9" class="am-text-center">暂无记录</td>
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
        var url = "<?= url('shop/delete') ?>";
        $('.item-delete').delete('shop_id', url, '删除后不可恢复，确定要删除吗？');

        var url = "<?= url('shop/agree') ?>";
        $('.item-agree').delete('shop_id', url, '确定要通过吗？');

        var url = "<?= url('shop/disagree') ?>";
        $('.item-disagree').delete('shop_id', url, '确定要拒绝吗？');

    });
</script>

