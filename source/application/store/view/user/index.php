<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">

            <div class="widget am-cf">
<!--                <form id="my-form" class="am-form tpl-form-line-form"  method="get">-->
<!--                        <div class="am-u-sm-3 am-u-md-3 am-u-lg-3 am-u-sm-offset-9">-->
<!--                            <div class="am-input-group">-->
<!--                                <input type="text" class="am-form-field" name="search" placeholder="可按照昵称，电话查询">-->
<!--                                  <span class="am-input-group-btn">-->
<!--                                    <button class="am-btn am-btn-xs" type="submit button"><span class="am-icon-search"></span></button>-->
<!--                                  </span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                </form>-->
                <div class="am-input-group am-u-sm-3 am-u-md-3 am-u-lg-3 am-u-sm-offset-9">
                    <input type="text" class="am-form-field" placeholder="可按照昵称，电话查询">
                      <span class="am-input-group-btn">
                        <a id='search' href="<?= url('user/index', ['search'=>'']) ?>" class="am-btn am-btn-default" type="button"><span class="am-icon-search"></span></a>
                      </span>
                </div>
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">用户列表</div>
                </div>
                <div class="widget-body am-fr">
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>微信头像</th>
                                <th>微信昵称</th>
                                <th>电话</th>
                                <th>省份</th>
                                <th>城市</th>
                                <th>注册时间</th>
                                <th>用户等级</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle">
                                        <a href="<?= $item['avatarUrl'] ?>" title="点击查看大图" target="_blank">
                                            <img src="<?= $item['avatarUrl'] ?>" width="72" height="72" alt="">
                                        </a>
                                    </td>
                                    <td class="am-text-middle"><?= $item['nickName'] ?></td>
                                    <td class="am-text-middle"><?= $item['phone_number'] ?></td>
                                    <td class="am-text-middle"><?= $item['province'] ?: '--' ?></td>
                                    <td class="am-text-middle"><?= $item['city'] ?: '--' ?></td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle"><?= $item['level']['level'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <a href="<?= url('user/edit',
                                                ['user_id' => $item['user_id']]) ?>">
                                                <i class="am-icon-pencil"></i> 详情
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="8" class="am-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(!strpos($_SERVER['QUERY_STRING'], 'search')): ?>
                        <div class="am-u-lg-12 am-cf">
                            <div class="am-fr"><?= $list->render() ?> </div>
                            <div class="am-fr pagination-total am-margin-right">
                                <div class="am-vertical-align-middle">总记录：<?= $list->total() ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.am-form-field').css('border', '1px solid #c2cad8')
    $(function () {
        $("#search").click(
            function()
            {
                $(this).attr('href', $(this).attr('href') + '/search/' + $('input')[0].value);
            }
        )
    });
</script>

