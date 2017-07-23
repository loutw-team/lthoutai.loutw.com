<?php $this->load->view('layout/header');?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3 class="page-title">景区管理<small> 接口来源</small></h3>
            <?php echo breadcrumb(array('景区管理', '景区产品', '接口来源')); ?>
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
                    <form class="form-horizontal form-search" action="<?php echo base_url('scenic_api_source/grid') ?>" method="get">
                        <div class="row-fluid">
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">来源名称</label>
                                    <div class="controls">
                                        <input type="text" name="source_name" value="<?php echo $this->input->get('source_name') ?>" class="m-wrap span12">
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">来源标识</label>
                                    <div class="controls">
                                        <input type="text" name="source_key" value="<?php echo $this->input->get('source_key') ?>" class="m-wrap span12">
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">对接方式</label>
                                    <div class="controls">
                                        <select name="purpose" class="m-wrap span12">
                                            <option value="0">全部</option>
                                            <?php foreach ($purpose as $k=>$v):?>
                                                <option value="<?php echo $k ?>" <?php if($k == $this->input->get('purpose')):?>selected="selected"<?php endif;?>><?php echo $v;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn green">搜索</button>
                            <button type="button" class="btn reset_button_search">重置条件</button>
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
                            <a href="<?php echo base_url('scenic_api_source/add') ?>" class="add-button-link">
                                <div class="btn-group">
                                    <button class="btn green"><i class="icon-plus"></i> 添加</button>
                                </div>
                            </a>
                        </div>
                        <?php if ($all_rows > 0) :?>
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead class="flip-content">
                                    <tr>
                                        <th width="2%"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"></th>
                                        <th width="5%">编号</th>
                                        <th width="15%">来源名称</th>
                                        <th width="15%">来源标识</th>
                                        <th width="20%">来源URL</th>
                                        <th width="8%">对接方式</th>
                                        <th width="12%">添加时间</th>
                                        <th width="8%">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($page_list->result() as $item) : ?>
                                    <tr>
                                        <td><input type="checkbox" class="checkboxes" value="<?php echo $item->source_id ?>" ></td>
                                        <td><?php echo $item->source_id;?></td>
                                        <td><?php echo $item->source_name;?></td>
                                        <td><?php echo $item->source_key;?></td>
                                        <td><?php echo $item->source_url;?></td>
                                        <td><?php echo $purpose[$item->purpose];?></td>
                                        <td><?php echo $item->created_at;?></td>
                                        <td>
                                            <a href="<?php echo base_url('scenic_api_source/edit/'.$item->source_id) ?>" class="btn mini green">编辑</a>
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
