<?php $this->load->view('layout/header');?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3 class="page-title">景区管理<small> 景区列表</small></h3>
            <?php echo breadcrumb(array('景区管理', '景区产品', '景区列表')); ?>
        </div>
    </div>
    <?php echo execute_alert_message() ?>
    <div class="row-fluid">
        <div class="span12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-search"></i>搜索</div>
                    <div class="tools">
                        <a class="collapse" href="javascript:;"></a>
                        <a class="remove" href="javascript:;"></a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form class="form-horizontal form-search" action="<?php echo base_url('scenic_base/grid') ?>" method="get">
                        <div class="row-fluid">
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">景区搜索</label>
                                    <div class="controls">
                                        <input type="text" name="scenic_search" value="<?php echo $this->input->get('scenic_search') ?>" class="m-wrap span12" placeholder="请输入景区编号或景区名称">
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">景区星级</label>
                                    <div class="controls">
                                        <select name="star_level" class="m-wrap span12">
                                            <option value="0">全部</option>
                                            <?php foreach ($starLevel as $key=>$value):?>
                                                <option value="<?php echo $key?>" <?php if($key == $this->input->get('star_level')):?>selected="selected"<?php endif;?>><?php echo $value;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">景区状态</label>
                                    <div class="controls">
                                        <select name="staus" class="m-wrap span12">
                                            <option value="0">全部</option>
                                            <?php foreach ($updown as $k=>$v):?>
                                                <option value="<?php echo $k ?>" <?php if($k == $this->input->get('updown')):?>selected="selected"<?php endif;?>><?php echo $v;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">供 应 商</label>
                                    <div class="controls">
                                        <input type="text" name="uid" value="<?php echo $this->input->get('uid') ?>" class="m-wrap span12" placeholder="请输入供应商编号">
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">添加时间</label>
                                    <div class="controls form-search-time">
                                        <div class="input-append date date-picker">
                                            <input type="text" name="start_date" size="16" value="<?php echo $this->input->get('start_date') ?>" class="m-wrap m-ctrl-medium date-picker date">
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                        <div class="input-append date date-picker">
                                            <input type="text" name="end_date" size="16" value="<?php echo $this->input->get('end_date') ?>" class="m-wrap m-ctrl-medium date-picker date">
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">省/市/区</label>
                                    <div class="controls">
                                        <?php $this->load->view('commonhtml/districtSelect');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn green" type="submit">搜索</button>
                            <button class="btn reset_button_search" type="button">重置条件</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-reorder"></i>列表</div>
                    <div class="tools">
                        <a class="collapse" href="javascript:;"></a>
                        <a class="remove" href="javascript:;"></a>
                    </div>
                </div>
                <div class="portlet-body flip-scroll">
                    <div class="dataTables_wrapper form-inline">
                        <div class="clearfix">
                            <a href="<?php echo base_url('scenic_base/add').'?sid='.$this->input->get('sid') ?>" class="add-button-link">
                                <div class="btn-group">
                                    <button class="btn green"><i class="icon-plus"></i> 添加</button>
                                </div>
                            </a>
                        </div>
                        <?php if ($all_rows > 0) :?>
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead class="flip-content">
                                    <tr>
                                        <th><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"></th>
                                        <th>编号</th>
                                        <th>景区名称</th>
                                        <th>景区主题</th>
                                        <th>景区星级</th>
                                        <th>景区地址</th>
                                        <th>开放时间</th>
                                        <th>供应商</th>
                                        <th>状态</th>
                                        <th>添加时间</th>
                                        <th width="100">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($page_list->result() as $item) : ?>
                                    <tr>
                                        <td><input type="checkbox" class="checkboxes" value="1" ></td>
                                        <td><?php echo $item->sid;?></td>
                                        <td><?php echo $item->scenic_name;?></td>
                                        <td><?php echo $scenicTheme[$item->theme_id];?></td>
                                        <td><?php echo $starLevel[$item->star_level];?></td>
                                        <td><?php echo $item->address;?></td>
                                        <td><?php echo $item->open_time;?></td>
                                        <td><?php echo $item->uid;?></td>
                                        <td>
                                            <?php echo $updown[$item->updown];?>
                                            <a class="modify-updown glyphicons no-js <?php if($item->updown == 1):?>ok_2<?php else :?>remove_2<?php endif;?>" data-goods-id="<?php echo $item->goods_id;?>" data-flag="<?php echo $item->updown ?>" href="javascript:;">
                                                <i></i>
                                            </a>
                                        </td>
                                        <td><?php echo $item->created_at;?></td>
                                        <td>
                                            <a href="<?php echo base_url('scenic_base/edit/'.$item->sid).'?sid='.$this->input->get('sid') ?>" class="btn mini green">编辑</a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                            <?php $this->load->view('layout/pagination');?>
                        <?php else: ?>
                            <div class="alert"><p>未找到数据。<p></div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
$(function(){
    $('.modify-updown').click(function(){
        var status = '下架';
        if ($(this).hasClass('remove_2')) {
            status = '上架';
        }
        if (confirm('确定要'+status+'?')) {
            var obj = $(this);
            var goods_id = $(this).attr('data-goods-id');
            var flag = $(this).attr('data-flag');
            $.ajax({
                url:hostUrl()+'/scenic_base/updown',
                type:'POST',
                dataType:'json',
                data: {goods_id:goods_id,flag:flag},
                success: function(data) {
                    if (data.flag == 2) {
                        obj.attr('data-flag', data.flag).addClass('remove_2').removeClass('ok_2');
                    } else if(data.flag == 1) {
                        obj.attr('data-flag', data.flag).addClass('ok_2').removeClass('remove_2');
                    } else {
                        alert('操作失败');
                    }
                }
            });
        }
    });
</script>
