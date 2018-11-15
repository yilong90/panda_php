<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">基本信息</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">用户ID </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input disabled type="text" class="tpl-form-input" name="user[user_id]"
                                           value="<?= $model['user_id'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">用户头像 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <img src="<?= $model['avatarUrl'] ?>" width="72" height="72" alt="">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">用户名称 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input disabled type="text" class="tpl-form-input" name="user[nickName]"
                                           value="<?= $model['nickName'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">性别 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input disabled type="text" class="tpl-form-input" name="user[gender]"
                                           value="<?= $model['gender'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">地区 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input disabled type="text" class="tpl-form-input" name="user[region]"
                                           value="<?= $model['country'].'-'.$model['province'].'-'.$model['city'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">电话号码 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input disabled type="text" class="tpl-form-input" name="user[phone_number]"
                                           value="<?= $model['phone_number'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">注册时间 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input disabled type="text" class="tpl-form-input" name="user[create_time]"
                                           value="<?= $model['create_time'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">上次登陆时间 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input disabled type="text" class="tpl-form-input" name="user[update_time]"
                                           value="<?= $model['update_time'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">邀请人 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input disabled type="text" class="tpl-form-input" name="user[invited_by]"
                                           value="<?= $invited_user ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">等级 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="user[level]"
                                            data-am-selected="{searchBox: 1, btnSize: 'sm'}">
                                        <?php if (isset($levels)): foreach ($levels as $key=>$value): ?>
                                            <option value="<?= $key ?>"
                                                <?= $model['level']['level'] == $value['level'] ? 'selected' : '' ?>>
                                                <?= $value['level'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">地址信息</div>
                            </div>
                            <div class="order-list am-scrollable-horizontal am-u-sm-12 am-margin-top-xs">
                                <table width="100%" class="am-table am-table-centered
                            am-text-nowrap am-margin-bottom-xs">
                                    <thead>
                                    <tr>
                                        <th>收货人</th>
                                        <th>电话</th>
                                        <th>地区</th>
                                        <th>详细地址</th>
                                        <th>是否为默认地址</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($addresses): foreach ($addresses as $add): ?>
                                            <tr>
                                                <td><?= $add['name'] ?></td>
                                                <td><?= $add['phone'] ?></td>
                                                <td><?= $add['region']['province'].'-'.$add['region']['city'].'-'.$add['region']['region'] ?></td>
                                                <td><?= $add['detail'] ?></td>
                                                <td>
                                                    <?php if ($model['address_id'] == $add['address_id']): ?> 是
                                                    <?php else: ?> 否
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>

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

<script>
    $(function () {

    });
</script>
