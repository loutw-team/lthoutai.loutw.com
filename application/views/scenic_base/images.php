<?php $this->load->view('layout/header'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3 class="page-title">景区管理<small> 图片管理</small></h3>
            <?php echo breadcrumb(array('景区管理', '景区产品', '景点列表', '图片管理')); ?>
        </div>
    </div>
    <?php echo execute_alert_message() ?>
    <div class="row-fluid">
        <div class="span12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-reorder"></i>图片管理</div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                        <a href="javascript:;" class="remove"></a>
                    </div>
                </div>
                <div class="portlet-body" style="display:block;">
                    <div class="row-fluid">
                        <div class="span4"></div>
                        <div class="span8">
                            <form class="line-form" action="<?php echo base_url('scenic_base/saveImages'); ?>" method="post"  enctype="multipart/form-data">
                                <div class="pull-left">
                                    <input type="hidden" name="sid" value="<?php echo $scenicBase->sid; ?>"/>
                                    <input type="hidden" name="pics" value="<?php echo $scenicBase->pics; ?>"/>
                                    <input type="file" name="pics[]" class="checkPicture required" multiple="multiple"/>
                                    <button class="btn green" type="submit"><i class="icon-plus"></i> 上传</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr class="clearfix"/>
                    <?php if (count($pics) > 0) :?>
                        <?php $i = 1;foreach ($pics as $val):?>
                             <?php if (($i - 1) % 4 == 0) : ?><div class="row-fluid"><?php endif; ?>
                             <div class="span3">
                                <div class="item" style="height:240px">
                                    <a target="_blank" href="<?php echo $this->config->show_image_url('mall', $val); ?>">
                                        <div class="zoom">
                                            <img src="<?php echo $this->config->show_image_url('mall', $val); ?>" width="373" height="240">
                                        </div>
                                    </a>
                                    <?php if( $i!=1 ):?>
                                    <div class="details">
                                        <a href="<?php echo base_url('scenic_base/deleteImage?sid='.$sid.'&image_name='.$val) ?>" class="icon" onclick="return confirm('确定要删除？')">删除</a>
                                        <a href="<?php echo base_url('scenic_base/mainImage?sid='.$sid . '&image_name='.$val) ?>" class="icon" onclick="return confirm('确定要将此图片设置为默认图片？')">设成默认</a>
                                    </div>
                                    <?php endif;?>
                                </div>
                             </div>
                             <?php if (($i) % 4 == 0 || $i==count($pics)) : ?></div><?php endif; ?>
                        <?php $i++;endforeach;?>
                   <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer'); ?>