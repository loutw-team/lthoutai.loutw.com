<?php $this->load->view('layout/header');?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3 class="page-title">景区管理<small> 票种类型</small></h3>
            <?php echo breadcrumb(array('景区管理', '景区产品', '票种类型')); ?>
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
                    <form class="form-horizontal form-search" action="<?php echo base_url('scenic_theme/grid') ?>" method="get">
                        <div class="row-fluid">
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">票种名称</label>
                                    <div class="controls">
                                        <input type="text" name="cat_name" value="<?php echo $this->input->get('cat_name') ?>" class="m-wrap span12" placeholder="请输入景区编号或景区名称">
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">票种状态</label>
                                    <div class="controls">
                                        <select name="is_show" class="m-wrap span12">
                                            <option value="0">全部</option>
                                            <?php foreach ($isShow as $k=>$v):?>
                                                <option value="<?php echo $k ?>" <?php if($k == $this->input->get('is_show')):?>selected="selected"<?php endif;?>><?php echo $v;?></option>
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
                            <a href="<?php echo base_url('scenic_cat/add') ?>" class="add-button-link">
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
                                        <th width="15%">票种名称</th>
                                        <th width="8%">票种状态</th>
                                        <th width="8%">排序</th>
                                        <th width="12%">添加时间</th>
                                        <th width="15%">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($page_list->result() as $item) : ?>
                                    <tr>
                                        <td><input type="checkbox" class="checkboxes" value="<?php echo $item->cat_id ?>" ></td>
                                        <td><?php echo $item->cat_id;?></td>
                                        <td><?php echo $item->cat_name;?></td>
                                        <td><?php echo $isShow[$item->is_show];?></td>
                                        <td><?php echo $item->sort;?></td>
                                        <td><?php echo $item->created_at;?></td>
                                        <td>
                                            <a href="<?php echo base_url('scenic_cat/edit/'.$item->cat_id) ?>" class="btn mini green">编辑</a>
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
