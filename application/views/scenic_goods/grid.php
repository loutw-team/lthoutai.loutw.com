<?php $this->load->view('layout/header');?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3 class="page-title">景区管理<small> 门票列表</small></h3>
            <?php echo breadcrumb(array('景区管理', '景区产品', '门票列表')); ?>
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
                    <form class="form-horizontal form-search" action="<?php echo base_url('scenic_goods/grid') ?>" method="get">
                        <div class="row-fluid">
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">门票搜索</label>
                                    <div class="controls">
                                        <input type="hidden" name="sid" value="<?php echo $this->input->get('sid') ?>">
                                        <input type="text" name="goods_search" value="<?php echo $this->input->get('goods_search') ?>" class="m-wrap span12" placeholder="请输入门票编号或门票名称">
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">接口来源</label>
                                    <div class="controls">
                                        <select name="source_id" class="m-wrap span12">
                                            <option value="0">全部</option>
                                            <?php foreach ($scenicApiSource as $source_id => $value) : ?>
                                                <option value="<?php echo $source_id;?>" <?php if ($this->input->get('source_id')==$source_id):?>selected="selected"<?php endif;?>><?php echo $value['source_name'] . ' -- ' . ($value['purpose'] == 1 ? '自动对接' : '二次下单')?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">审核状态</label>
                                    <div class="controls">
                                        <select name="staus" class="m-wrap span12">
                                            <option value="0">全部</option>
                                            <?php foreach ($isCheck as $k=>$v):?>
                                                <option value="<?php echo $k ?>" <?php if($k == $this->input->get('is_check')):?>selected="selected"<?php endif;?>><?php echo $v;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">分润方式</label>
                                    <div class="controls">
                                        <select name="rate_id" class="m-wrap span12">
                                            <option value="0">全部</option>
                                            <?php foreach ($scenicProfitRate as $rate_id=>$value) : ?>
                                                <option value="<?php echo $rate_id;?>" <?php if ($this->input->get('rate_id')==$rate_id):?>selected="selected"<?php endif;?>><?php echo $value['name']; ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label">上下架</label>
                                    <div class="controls">
                                        <select name="staus" class="m-wrap span12">
                                            <option value="0">全部</option>
                                            <?php foreach ($isOnSale as $k=>$v):?>
                                                <option value="<?php echo $k ?>" <?php if($k == $this->input->get('is_on_sale')):?>selected="selected"<?php endif;?>><?php echo $v;?></option>
                                            <?php endforeach;?>
                                        </select>
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
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn green">搜索</button>
                            <a href="<?php echo base_url('scenic_goods/grid').'?sid='.$this->input->get('sid') ?>" class="btn">重置条件</a>
                            <button type="submit" name="excel" class="btn blue">导出Excel</button>
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
                        <?php  if ($this->input->get('sid')) : ?>
                            <div class="clearfix">
                                <a href="<?php echo base_url('scenic_goods/add').'?sid='.$this->input->get('sid') ?>" class="add-button-link">
                                    <div class="btn-group">
                                        <button class="btn green"><i class="icon-plus"></i> 添加</button>
                                    </div>
                                </a>
                            </div>
                        <?php endif ?>
                        <?php if ($all_rows > 0) :?>
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead class="flip-content">
                                    <tr>
                                        <th width="2%"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"></th>
                                        <th width="8%">编号</th>
                                        <th width="8%">票种</th>
                                        <th width="15%">门票名称</th>
                                        <th width="6%">起价</th>
                                        <th width="10%">分润方式</th>
                                        <th width="8%">票种来源</th>
                                        <th>状态</th>
                                        <th width="6%">上下架</th>
                                        <th width="12%">添加时间</th>
                                        <th width="12%">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($page_list->result() as $item) : ?>
                                    <tr>
                                        <td><input type="checkbox" class="checkboxes" value="1" ></td>
                                        <td>
                                            <p>景区：<?php echo $item->sid;?></p>
                                            <p>门票：<?php echo $item->goods_id;?></p>
                                        </td>
                                        <td><?php echo $item->cat_id;?></td>
                                        <td><?php echo $item->goods_name;?></td>
                                        <td><?php echo $item->price;?></td>
                                        <td><?php echo $scenicProfitRate[$item->rate_id]['name'];?></td>
                                        <td><?php echo ($item->source_id != 0) ? $scenicApiSource[$item->source_id]['source_name'] : '无';?></td>
                                        <td>
                                            <p><?php echo $isCheck[$item->is_check];?></p>
                                            <?php if ($item->is_check == 1) :?>
                                                <a class="btn mini green is-check-status" href="javascript:;" data-id="<?php echo $item->goods_id?>" data-status="2">通过审核</a>
                                                <a class="btn mini green is-check-status" href="javascript:;" data-id="<?php echo $item->goods_id?>" data-status="3">审核失败</a>
                                            <?php endif;?>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="modify-updown glyphicons no-js <?php if ($item->is_on_sale == 1):?>ok_2<?php else :?>remove_2<?php endif;?>" data-goods-id="<?php echo $item->goods_id;?>" data-flag="<?php echo $item->is_on_sale ?>">
                                                <i></i>
                                            </a>
                                        </td>
                                        <td><?php echo $item->created_at;?></td>
                                        <td>
                                            <p>
                                                <a href="<?php echo base_url('scenic_goods/edit/'.$item->goods_id) ?>" class="btn mini green">编辑</a>
                                                <a href="<?php echo base_url('scenic_goods/copy/'.$item->goods_id);?>" class="btn mini green">复制</a>
                                            </p>
                                            <p><a href="<?php echo base_url('scenic_goods/edit/'.$item->sid) ?>" class="btn mini green">预览</a></p>
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
                    url:hostUrl()+'/scenic_goods/setUpdown',
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

        $('.is-check-status').click(function(){
            var obj = $(this);
            var isCheck = obj.attr('data-status');
            var goodsId = obj.attr('data-id');
            var status = '通过审核';
            if (isCheck == 3) {
                status = '审核失败';
            }
            if (confirm('确定要'+status+'?')) {
                $.ajax({
                    url:hostUrl()+'/scenic_goods/isCheck',
                    type:'POST',
                    dataType:'json',
                    data: {goods_id:goodsId, is_check:isCheck},
                    success: function(data) {
                        if (data.status) {
                            obj.siblings('p').text(status).siblings('a').remove();
                        } else {
                            alert('操作失败');
                        }
                    }
                });
            }
        });
    });
</script>
