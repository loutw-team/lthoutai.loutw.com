<?php $this->load->view('layout/header');?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3 class="page-title">景点管理<small> 接口来源添加</small></h3>
            <?php echo breadcrumb(array('景区管理', '景区产品', '接口来源', '接口来源添加')); ?>
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
                    <div class="caption"><i class="icon-plus-sign"></i>添加</div>
                    <div class="tools">
                        <a class="collapse" href="javascript:;"></a>
                        <a class="remove" href="javascript:;"></a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form class="form-horizontal scenic-api-form" enctype="multipart/form-data">
                        <div class="control-group">
                            <label class="control-label"><em>* </em>来源名称</label>
                            <div class="controls">
                                <input type="text" name="source_name" class="m-wrap span8 required">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><em>* </em>来源标识</label>
                            <div class="controls">
                                <input type="text" name="source_key" class="m-wrap span8 required">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">来源URL</label>
                            <div class="controls">
                                <input type="text" name="source_url" class="m-wrap span8 url">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><em>* </em>对接方式</label>
                            <div class="controls">
                                <label class="radio">
                                    <input type="radio" name="purpose" value="1" checked="checked"> 自动对接
                                </label>
                                <label class="radio">
                                    <input type="radio" name="purpose" value="2"> 二次下单
                                </label>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn green"><i class="icon-ok"></i> 保存</button>
                            <a href="<?php echo base_url('scenic_api_source/grid') ?>">
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
        $('form.scenic-api-form').submit(function () {
            return false;
        }).validate({
            submitHandler: function (f) {
                $.ajax({
                    type: 'post',
                    async: true,
                    dataType: 'json',
                    url: hostUrl() + '/scenic_api_source/ajaxValidate',
                    data: $('form.scenic-api-form').serialize(),
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