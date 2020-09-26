<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">评价列表</div>
                </div>
                <div class="widget-body am-fr">
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>商品名称</th>
                                <th class="am-text-middle">用户</th>
                                <th class="am-text-middle">备注</th>
                                <th class="am-text-middle">状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['id'] ?></td>
                                    <td class="am-text-middle"><?=$item['goods']['goods_name'] ?></td>
                                    <td class="am-text-middle">
                                        <p class=""><?= $item['user']['nickName'] ?></p>
                                        <p class="am-link-muted">(用户id：<?= $item['user']['user_id'] ?>)</p>
                                    </td>
                                    
                                    <td class="am-text-middle">
                                        <p class="item-title"><?= $item['note'] ?></p>
                                    </td>
                                    <td class="am-text-middle">
                                        <?php if ($item['status'] == 1) : ?>
                                            <span class="x-color-green">批准</span>
                                        <?php elseif($item['status'] == 2): ?>
                                            <span class="x-color-green">拒绝</span>
                                        <?php else: ?>
                                            <span class="x-color-red">未审核</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (!$item['status']) : ?>
                                                <a class="j-grade tpl-table-black-operation-default"
                                                   href="javascript:void(0);"
                                                   data-id="<?= $item['id'] ?>"
                                                   title="拒绝">
                                                    <i class="iconfont icon-grade-o"></i>
                                                    拒绝
                                                </a>
                                                <a href="javascript:void(0);"
                                                   class="item-delete tpl-table-black-operation-default"
                                                   data-id="<?= $item['id'] ?>">
                                                    <i class="am-icon-trash"></i> 批准
                                                </a>
                                            <?php endif; ?>
                                           
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="11" class="am-text-center">暂无记录</td>
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

<!-- 模板：拒绝理由 -->
<script id="tpl-grade" type="text/template">
    <div class="am-padding-xs am-padding-top">
        <form class="am-form tpl-form-line-form" method="post" action="">
            <div class="am-tab-panel am-padding-0 am-active">
                <div class="am-form-group">
                    <label class="am-u-sm-3 am-form-label"> 管理员备注 </label>
                    <div class="am-u-sm-8 am-u-end">
                                <textarea rows="2" name="note" placeholder="请输入管理员备注"
                                          class="am-field-valid"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
</script>

<script>
    $(function () {
        // 删除元素
        var url = "<?= url('goods.show/refuse') ?>";
        $('.item-delete').delete('id', url);

        /**
         * 修改会员等级
         */
        $('.j-grade').on('click', function () {
            var data = $(this).data();
            $.showModal({
                title: '修改会员等级'
                , area: '460px'
                , content: template('tpl-grade', data)
                , uCheck: true
                , success: function ($content) {
                }
                , yes: function ($content) {
                    $content.find('form').myAjaxSubmit({
                        url: '<?= url('goods/show/refuse') ?>',
                        data: {id: data.id}
                    });
                    return true;
                }
            });
        });



    });

    
</script>

