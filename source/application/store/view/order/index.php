<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf"><?= $title ?></div>
                </div>
                <div class="widget-body am-fr">
                    <div class="order-list am-scrollable-horizontal am-u-sm-12 am-margin-top-xs">
                        <table width="100%" class="am-table am-table-centered
                        am-text-nowrap am-margin-bottom-xs">
                            <thead>
                            <tr>
                                <th>实付款</th>
                                <th>买家</th>
                                <th>交易状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): ?>
                                <?php foreach ($list as $order): ?>
                                <tr class="order-empty">
                                    <td colspan="6"></td>
                                </tr>
                                <tr>
                                    <td class="am-text-middle am-text-left" colspan="6">
                                        <span class="am-margin-right-lg"> <?= $order['create_time'] ?></span>
                                        <span class="am-margin-right-lg">订单号：<?= $order['order_no'] ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="am-text-middle">
                                        <p>￥<?= $order['pay_price'] ?></p>
                                        <p class="am-link-muted">(含运费：￥<?= $order['express_price'] ?>)</p>
                                    </td>
                                    <td class="am-text-middle">
                                        <p><?= $order['user']['nickName'] ?></p>
                                        <p class="am-link-muted">(用户id：<?= $order['user']['user_id'] ?>)</p>
                                    </td>
                                    <td class="am-text-middle">
                                        <p>付款状态：
                                            <span class="am-badge
                                                <?= $order['pay_status']['value'] == 20 ? 'am-badge-success' : '' ?>">
                                                        <?= $order['pay_status']['text'] ?></span>
                                        </p>
                                        <p>发货状态：
                                            <span class="am-badge
                                                <?= $order['delivery_status']['value'] == 20 ? 'am-badge-success' : '' ?>">
                                                        <?= $order['delivery_status']['text'] ?></span>
                                        </p>
                                        <p>收货状态：
                                            <span class="am-badge
                                                <?= $order['receipt_status']['value'] == 20 ? 'am-badge-success' : '' ?>">
                                                        <?= $order['receipt_status']['text'] ?></span>
                                        </p>
                                    </td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <a class="tpl-table-black-operation-green"
                                               href="<?= url('order/detail', ['order_id' => $order['order_id']]) ?>">
                                                订单详情</a>
                                            <?php if ($order['pay_status']['value'] == 20
                                                && $order['delivery_status']['value'] == 10): ?>
                                                <a class="tpl-table-black-operation"
                                                   href="<?= url('order/detail#delivery',
                                                       ['order_id' => $order['order_id']]) ?>">
                                                    去发货</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="am-text-center">暂无记录</td>
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

