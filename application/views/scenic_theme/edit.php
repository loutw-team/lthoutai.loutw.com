<?php $this->load->view('layout/header');?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3 class="page-title">景点管理<small> 景点产品编辑</small></h3>
            <?php echo breadcrumb(array('景区管理', '景区产品', '景点列表', '景点产品编辑')); ?>
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
                    <form class="form-horizontal scenic-theme-form" enctype="multipart/form-data">
                        <div class="control-group">
                            <label class="control-label"><em>* </em>主题名称</label>
                            <div class="controls">
                                <input type="hidden" name="theme_id" value="<?php echo $scenicTheme->theme_id ?>">
                                <input type="text" name="theme_name" value="<?php echo $scenicTheme->theme_name ?>" class="m-wrap span8 required">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><em>* </em>主题状态</label>
                            <div class="controls">
                                <label class="radio">
                                    <input type="radio" name="is_show" value="1" <?php if ($scenicTheme->is_show==1):?>checked="checked"<?php endif;?>> 显示
                                </label>
                                <label class="radio">
                                    <input type="radio" name="is_show" value="2" <?php if ($scenicTheme->is_show==2):?>checked="checked"<?php endif;?>> 不显示
                                </label>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn green"><i class="icon-ok"></i> 保存</button>
                            <a href="<?php echo base_url('scenic_theme/grid') ?>">
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
<script type="text/javascript">
$(document).ready(function(){
    // 提交验证
    $('form.scenic-theme-form').submit(function () {
        return false;
    }).validate({
        submitHandler: function (f) {
            $.ajax({
                type: 'post',
                async: true,
                dataType: 'json',
                url: hostUrl() + '/scenic_theme/ajaxValidate',
                data: $('form.scenic-theme-form').serialize(),
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
});
</script>