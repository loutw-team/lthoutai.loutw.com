<?php $this->load->view('layout/header');?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3 class="page-title">景区管理<small> 门票列表编辑</small></h3>
            <?php echo breadcrumb(array('景区管理', '景点产品', '门票列表编辑')); ?>
        </div>
    </div>
    <div class="alert alert-error" style="display:none;">
        <button data-dismiss="alert" class="close"></button>
        <a href="javascript:;" class="glyphicons no-js remove_2"><i></i><p></p></a>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-plus-sign"></i>编辑</div>
                    <div class="tools">
                        <a class="collapse" href="javascript:;"></a>
                        <a class="remove" href="javascript:;"></a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form class="form-horizontal scenic-goods-form" enctype="multipart/form-data">
                        <div class="alert alert-success">基本信息</div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>门票名称</label>
                                    <div class="controls">
                                        <input type="hidden" name="goods_id" value="<?php echo $scenicGoods->goods_id ?>">
                                        <input type="hidden" name="sid" value="<?php echo $scenicGoods->sid ?>">
                                        <input type="text" name="goods_name" value="<?php echo $scenicGoods->goods_name ?>" class="m-wrap span12 required">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>票种</label>
                                    <div class="controls">
                                        <select name="cat_id" class="m-wrap span12 required">
                                            <?php foreach ($scenicCat as $key => $value) : ?>
                                                <option value="<?php echo $key;?>" <?php if ($scenicGoods->cat_id == $key):?>selected="selected"<?php endif;?>><?php echo $value['cat_name']; ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>费用包含</label>
                                    <div class="controls">
                                        <textarea name="include" rows="2" class="m-wrap span12 required"><?php echo $scenicGoods->include ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>费用不含</label>
                                    <div class="controls">
                                        <textarea name="exclude" rows="2" class="m-wrap span12 required"><?php echo $scenicGoods->exclude ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>退款说明</label>
                                    <div class="controls">
                                        <textarea name="refund_info" rows="2" class="m-wrap span12 required"><?php echo $scenicGoods->refund_info ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>入园方式</label>
                                    <div class="controls">
                                        <textarea name="park_way" rows="2" class="m-wrap span12 required"><?php echo $scenicGoods->park_way ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>取票地址</label>
                                    <div class="controls">
                                        <textarea name="park_address" rows="2" class="m-wrap span12 required"><?php echo $scenicGoods->park_address ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">入园时间</label>
                                    <div class="controls">
                                        <div class="input-append bootstrap-timepicker-component">
                                            <input type="text" name="in_time" value="<?php echo $scenicGoods->in_time ?>" class="m-wrap small timepicker-hhii">
                                            <span class="add-on"><i class="icon-time"></i></span>
                                        </div>
                                        <div class="input-append bootstrap-timepicker-component">
                                            <input type="text" name="out_time" value="<?php echo $scenicGoods->out_time ?>" class="m-wrap small timepicker-hhii">
                                            <span class="add-on"><i class="icon-time"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>审核状态</label>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="is_check" value="1" <?php if ($scenicGoods->is_check==1):?>checked="checked"<?php endif;?>> 待审核
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="is_check" value="2" <?php if ($scenicGoods->is_check==2):?>checked="checked"<?php endif;?>> 通过
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="is_check" value="3" <?php if ($scenicGoods->is_check==3):?>checked="checked"<?php endif;?>> 未通过
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>上下架</label>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="is_on_sale" value="1" <?php if ($scenicGoods->is_on_sale==1):?>checked="checked"<?php endif;?>> 上架
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="is_on_sale" value="2" <?php if ($scenicGoods->is_on_sale==2):?>checked="checked"<?php endif;?>> 下架
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-success">门票购买规则</div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">提前预订时间</label>
                                    <div class="controls">
                                        <input type="text" name="advance_date" value="<?php echo $scenicGoods->advance_date ?>" class="m-wrap span3 number popovers" data-placement="bottom" data-trigger="hover" data-original-title="解释说明" data-content="例：1天20:00。那么出游日期前1天的20:00前可预订，默认为0天，表示无预订时间限制"> 天
                                        <div class="input-append bootstrap-timepicker-component">
                                            <input type="text" name="advance_time" value="<?php echo $scenicGoods->advance_time ?>" class="m-wrap span5 timepicker-hhii">
                                            <span class="add-on"><i class="icon-time"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">预订延后（小时）</label>
                                    <div class="controls">
                                        <input type="text" name="use_delay" value="<?php echo $scenicGoods->use_delay ?>" class="m-wrap span10 number popovers" data-placement="bottom" data-trigger="hover" data-original-title="解释说明" data-content="例：延后一天，即今日预订，明日开始才能检票使用，不填默认为0，默认当天可检票" placeholder="预订延后多少小时，不填默认为0，默认当天 ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">使用有效期（天）</label>
                                    <div class="controls">
                                        <input type="text" name="validity_days" value="<?php echo $scenicGoods->validity_days ?>" class="m-wrap span10 number popovers" data-placement="bottom" data-trigger="hover" data-original-title="解释说明" data-content="例：今日购买，2天后失效，则2日后不可检票，不填默认为0,默认全年可检 " placeholder="使用有效期多少天,不填默认为0,默认全年">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>起售价格</label>
                                    <div class="controls">
                                        <input type="text" name="price" value="<?php echo $scenicGoods->price ?>" class="m-wrap span10 required">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>退票规则</label>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" id="is_refund_1" name="is_refund" value="1" <?php if ($scenicGoods->is_refund==1):?>checked="checked"<?php endif;?>> 是
                                        </label>
                                        <label class="radio">
                                            <input type="radio" id="is_refund_2" name="is_refund" value="2" <?php if ($scenicGoods->is_refund==2):?>checked="checked"<?php endif;?>> 否
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>改票规则</label>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" id="is_edit_1" name="is_edit" value="1" <?php if ($scenicGoods->is_edit==1):?>checked="checked"<?php endif;?>> 是
                                        </label>
                                        <label class="radio">
                                            <input type="radio" id="is_edit_2" name="is_edit" value="2" <?php if ($scenicGoods->is_edit==2):?>checked="checked"<?php endif;?>> 否
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group" id="refund_rule" <?php if($scenicGoods->is_refund == 2):?>style="display:none;"<?php endif;?>>
                                    <label class="control-label">可申请退票时间</label>
                                    <div class="controls">
                                        <input type="text" name="refund_day" value="<?php echo $scenicGoods->refund_day ?>" class="m-wrap span3 number popovers" data-placement="bottom" data-trigger="hover" data-original-title="解释说明" data-content="例：1天15:00表示游玩日期后1天的15:00前申请退票;0天15:00表示游玩日期当天的15:00前申请退票;-1天15:00表示游玩日期前1日的15:00前申请退票.默认为0,表示随时可退"> 天
                                        <div class="input-append bootstrap-timepicker-component">
                                            <input type="text" name="refund_time" value="<?php echo $scenicGoods->refund_time ?>" class="m-wrap span5 timepicker-hhii">
                                            <span class="add-on"><i class="icon-time"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group" id="edit_rule" <?php if($scenicGoods->is_edit == 2):?>style="display:none;"<?php endif;?>>
                                    <label class="control-label">可改期时间</label>
                                    <div class="controls">
                                        <input type="text" name="edit_day" value="<?php echo $scenicGoods->edit_day ?>" class="m-wrap span3 number popovers" data-placement="bottom" data-trigger="hover" data-original-title="解释说明" data-content="例：1天15:00表示游玩日期后1天的15:00前可以改期;0天15:00表示游玩日期当天的15:00前可以改期;-1天15:00表示游玩日期前1日的15:00前可以改期.默认为0,表示随时可改"> 天
                                        <div class="input-append bootstrap-timepicker-component">
                                            <input type="text" name="edit_time" value="<?php echo $scenicGoods->edit_time ?>" class="m-wrap span5 timepicker-hhii">
                                            <span class="add-on"><i class="icon-time"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>部分可退</label>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="is_partly_refund" value="1" <?php if ($scenicGoods->is_partly_refund==1):?>checked="checked"<?php endif;?>> 是
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="is_partly_refund" value="2" <?php if ($scenicGoods->is_partly_refund==2):?>checked="checked"<?php endif;?>> 否
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>分润方式</label>
                                    <div class="controls">
                                        <select name="rate_id" class="m-wrap span10 required">
                                            <?php foreach ($scenicProfitRate as $rate_id=>$value) : ?>
                                                <option value="<?php echo $rate_id;?>" <?php if ($scenicGoods->rate_id==$rate_id):?>selected="selected"<?php endif;?>><?php echo $value['name']; ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">指定购买者UID</label>
                                    <div class="controls">
                                        <input type="text" name="buyers" value="<?php echo $scenicGoods->buyers ?>" class="m-wrap span10" placeholder="请填写可购买者的用户UID，用|隔开">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">指定非购买者UID</label>
                                    <div class="controls">
                                        <input type="text" name="unbuyers" value="<?php echo $scenicGoods->unbuyers ?>" class="m-wrap span10" placeholder="请填写不可购买者的用户UID，用|隔开">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">身份证预订频次</label>
                                    <div class="controls">
                                        <?php foreach ($bookingLimit as $k => $v) : ?>
                                            <label class="radio">
                                                <input type="radio" name="sfz_limit_days" value="<?php echo $k;?>" <?php if ($scenicGoods->sfz_limit_days == $k):?>checked="checked"<?php endif ?>><?php echo $v; ?>
                                            </label>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">最多购买数量</label>
                                    <div class="controls">
                                        <input type="text" name="sfz_limit_count" value="<?php echo $scenicGoods->sfz_limit_count ?>" class="m-wrap span10 number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">手机号预订频次</label>
                                    <div class="controls">
                                        <?php foreach ($bookingLimit as $k => $v) : ?>
                                            <label class="radio">
                                                <input type="radio" name="phone_limit_days" value="<?php echo $k;?>" <?php if ($scenicGoods->phone_limit_days == $k):?>checked="checked"<?php endif ?>><?php echo $v; ?>
                                            </label>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">最多购买数量</label>
                                    <div class="controls">
                                        <input type="text" name="phone_limit_count" value="<?php echo $scenicGoods->phone_limit_count ?>" class="m-wrap span10 number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label"><em>* </em>最小购买数量</label>
                                    <div class="controls">
                                        <input type="text" name="min_buy_count" value="<?php echo $scenicGoods->min_buy_count ?>" class="m-wrap span10 number required">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">最大购买数量</label>
                                    <div class="controls">
                                        <input type="text" name="max_buy_count" value="<?php echo $scenicGoods->max_buy_count ?>" class="m-wrap span10 number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-success">接口信息</div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">接口来源</label>
                                    <div class="controls">
                                        <select name="source_id" class="m-wrap span10">
                                            <option value="0">无</option>
                                            <?php foreach ($scenicApiSource as $source_id => $value) : ?>
                                                <option value="<?php echo $source_id;?>" <?php if ($scenicGoods->source_id==$source_id):?>selected="selected"<?php endif;?>><?php echo $value['source_name'] . ' -- ' . ($value['purpose'] == 1 ? '自动对接' : '二次下单')?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">接口景区编号</label>
                                    <div class="controls">
                                        <input type="text" name="api_sid" value="<?php echo $scenicGoods->api_sid ?>" class="m-wrap span10 number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">接口门票编号</label>
                                    <div class="controls">
                                        <input type="text" name="api_goods_id" value="<?php echo $scenicGoods->api_goods_id ?>" class="m-wrap span10 number">
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group">
                                    <label class="control-label">订单关闭时间</label>
                                    <div class="controls">
                                        <input type="text" name="order_cancel" value="<?php echo $scenicGoods->order_cancel ?>" class="m-wrap span10 number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn green"><i class="icon-ok"></i> 保存</button>
                            <a href="<?php echo base_url('scenic_goods/grid').'?sid='.$this->input->get('sid')  ?>">
                                <button class="btn" type="button">返回</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer');?>
<?php $this->load->view('supplier/ajaxSupplier/ajaxGet');?>
<script type="text/javascript">
    $(document).ready(function(){
        // 提交验证
        $('form.scenic-goods-form').submit(function () {
            return false;
        }).validate({
            ignore: '',
            submitHandler: function (f) {
                $.ajax({
                    type: 'post',
                    async: true,
                    dataType: 'json',
                    url: hostUrl() + '/scenic_goods/ajaxValidate',
                    data: $('form.scenic-goods-form').serialize(),
                    beforeSend: function () {
                        $('.form-actions [type=submit]').text('加载中');
                    },
                    success: function (data) {
                        if (data.status) {
                            $('.alert-error').hide();
                            window.location.href = data.messages;
                        } else {
                            $('.alert-error').show();
                            $('.alert-error .remove_2 p').html(data.messages);
                            $('.footer .go-top').trigger('click');
                        }
                    }
                });
            }
        });

        $('#is_refund_1').click(function(){
            $('#refund_rule').show();
        });
        $('#is_refund_2').click(function(){
            $('#refund_rule').hide();
        });
        $('#is_edit_1').click(function(){
            $('#edit_rule').show();
        });
        $('#is_edit_2').click(function(){
            $('#edit_rule').hide();
        });
    });
</script>