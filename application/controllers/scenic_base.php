<?php
class Scenic_base extends CS_Controller
{
    private $starLevel = array(1 => '1A', 2 => '2A', 3 => '3A', 4 => '4A', 5 => '5A');
    private $updown    = array(1 => '上架', 2 => '下架');

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('scenic_base_model', 'scenic_base');
        $this->load->model('scenic_theme_model', 'scenic_theme');
        $this->load->model('supplier_model', 'supplier');
        $this->load->model('region_model', 'region');
    }

    public function grid($pg = 1)
    {
        $getData = $this->input->get();
        if (isset($getData['excel']) && $getData['excel']== 'excel') {
            $this->excelExport($getData);
        } else {
            $pageNum = 20;
            $num = ($pg - 1) * $pageNum;
            $config['first_url'] = base_url('scenic_base/grid').$this->pageGetParam($getData);
            $config['suffix'] = $this->pageGetParam($getData);
            $config['base_url'] = base_url('scenic_base/grid');
            $config['total_rows'] = $this->scenic_base->total($getData);
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config);
            $data['pg_link'] = $this->pagination->create_links();
            $data['page_list'] = $this->scenic_base->page_list($pageNum, $num, $getData);
            $data['all_rows'] = $config['total_rows'];
            $data['pg_now'] = $pg;
            $data['page_num'] = $pageNum;
            $data['starLevel'] = $this->starLevel;
            $data['updown'] = $this->updown;
            $this->load->view('scenic_base/grid', $data);
        }
    }

    public function add()
    {
        $data['scenicTheme'] = $this->scenic_theme->find(TRUE);
        $data['starLevel'] = $this->starLevel;
        $data['updown'] = $this->updown;
        $this->load->view('scenic_base/add', $data);
    }

    /**
     * ajax的添加
     */
    public function ajaxValidate()
    {
        $error = $this->validate();
        if (!empty($error)) {
            $this->jsonMessage($error);
        }
        if ($this->input->post('sid')) {
            $this->editPost();
        } else {
            $this->addPost();
        }
    }

    /**
     * 添加
     */
    public function addPost()
    {
        $params = $this->input->post();
        $this->db->trans_start();
        $goods_id = $this->scenic_base->insert($params);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE && $goods_id) {
            $this->session->set_flashdata('success', '保存成功!');
            $this->jsonMessage('', base_url('scenic_base/grid'));
        } else {
            $this->jsonMessage('保存失败！');
        }
    }

    /**
     * 编辑
     * @param unknown $goods_id
     */
    public function edit($sid)
    {
        $result = $this->scenic_base->findBySid($sid);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_base/grid', '', '找不到产品相关信息！');
        }
        $scenicBase = $result->row(0);
        $data['scenicBase']    = $scenicBase;
        $data['scenicTheme']   = $this->scenic_theme->find(TRUE);
        $data['starLevel']     = $this->starLevel;
        $data['updown']        = $this->updown;
        $data['province_id']   = $scenicBase->province_id;
        $data['city_id']       = $scenicBase->city_id;
        $data['district_id']   = $scenicBase->district_id;
        $this->load->view('scenic_base/edit', $data);
    }

    public function editPost()
    {
        $sid = $this->input->post('sid');
        $params = $this->input->post();
        $this->db->trans_start();
        $update = $this->scenic_base->update($params);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->session->set_flashdata('success', '编辑成功!');
            $this->jsonMessage('', base_url('scenic_base/grid'));
        } else {
            $this->jsonMessage('编辑失败！');
        }
    }

    /**
     * 编辑
     * @param unknown $goods_id
     */
    public function copy($sid)
    {
        $result = $this->scenic_base->findBySid($sid);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_base/grid', '', '找不到产品相关信息！');
        }
        $scenicBase = $result->row(0);
        $data['scenicBase']    = $scenicBase;
        $data['scenicTheme']   = $this->scenic_theme->find(TRUE);
        $data['starLevel']     = $this->starLevel;
        $data['updown']        = $this->updown;
        $data['province_id']   = $scenicBase->province_id;
        $data['city_id']       = $scenicBase->city_id;
        $data['district_id']   = $scenicBase->district_id;
        $this->load->view('scenic_base/copy', $data);
    }

    /**
     * 商品多图显示
     * author laona
     **/
    public function images($sid)
    {
        $result = $this->scenic_base->findBySid($sid);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_base/grid', '', '找不到产品相关信息！');
        }
        $scenicBase = $result->row(0);
        $data['scenicBase'] = $scenicBase;
        if (!empty($scenicBase->pics)) {
            $pics = array_filter(explode('|', $scenicBase->pics));
        } else {
            $pics = array();
        }
        $data['pics'] = $pics;
        $data['sid'] = $sid;
        $this->load->view('scenic_base/images', $data);
    }

    /**
     * 商品多图保存
     * author laona
     */
    public function saveImages()
    {
        if (!$this->input->post('sid')) {
            $this->error('scenic_base/grid', '', '内部错误！');
        }
        $sid = (int)$this->input->post('sid');
        if (empty($_FILES['goods_img']['name'])) {
            $this->error('scenic_base/images', $sid, '请选择图片上传！');
        }
        $imageData = $this->dealWithMoreImages('pics', '', 'scenic');
        if ($imageData == false) {
            $this->error('scenic_base/images', $sid, '请选择图片上传！');
        }
        $this->db->trans_start();
        $this->scenic_base->updateBySid($sid, $imageData);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->error('scenic_base/images', $sid, '数据保存失败！');
        }
        $this->success('scenic_base/images', $sid, '数据保存成功！');
    }

    public function deleteImage()
    {
        $sid = $this->input->get('sid');
        $imageName = $this->input->get('image_name');
        if (empty($goods_id)) {
            $this->error('scenic_base/grid', '', '内部错误！');
        }
        $result = $this->scenic_base->findBySid($sid);

        if ($result->num_rows() <= 0) {
            $this->error('scenic_base/grid', '', '找不到产品相关信息！');
        }
        $scenicBase = $result->row();
        $scenicImg = str_replace($imageName.'|', '', $scenicBase->pics);
        $resultId = $this->scenic_base->updateBySid($sid, array('pic'=>$scenicImg));
        $this->deleteOldfileName($imageName, 'scenic');
        if (!$resultId) {
            $this->error('scenic_base/images', $sid, '删除失败');
        }
        $this->success('scenic_base/images', $sid, '删除成功！');
    }

    /**
     * 设为主图
     * @param unknown $siid
     */
    public function mainImage()
    {
        $sid = $this->input->get('sid');
        $result = $this->scenic_base->findByGoodsId($sid);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_base/grid', '', '找不到产品相关信息！');
        }
        $mall_goods = $result->row();
        $image_name = $this->input->get('image_name');
        $pics = str_replace($image_name.'|', '', $mall_goods->goods_img);
        $params['goods_img'] = $image_name.'|'.$pics;
        $params['goods_id'] = $sid;
        $resultId = $this->scenic_base->updateBySid($params);
        if (!$resultId) {
            $this->error('scenic_base/images', $sid, '删除失败');
        }
        $this->success('scenic_base/images', $sid, '删除成功！');
    }

    /**
     * 验证过程
     * @return multitype:string
     */
    public function validate()
    {
        $error = array();
        if ($this->validateParam($this->input->post('scenic_name'))) {
            $error[] = '景点名称不可为空！';
        }
        $supplier_id = $this->input->post('supplier_id');
        if (!empty($supplier_id)) {//为零时不判断，默认自营产品
            $userQuery = $this->supplier->findByUid($supplier_id);
            if ($userQuery->num_rows() <= 0) {
                $error[] = '请填写正确的供应商UID';
            }
        }
        if ($this->validateParam($this->input->post('special'))) {
            $error[] = '景点特色不可为空！';
        }
        if ($this->validateParam($this->input->post('open_time'))) {
            $error[] = '开放时间不可为空！';
        }
        if ($this->validateParam($this->input->post('info'))) {
            $error[] = '景点简介不可为空！';
        }
        if ($this->validateParam($this->input->post('locType'))) {
            $error[] = '地图类型必选';
        }
        if ($this->validateParam($this->input->post('longitude'))) {
            $error[] = '经度不可为空';
        }
        if ($this->validateParam($this->input->post('latitude'))) {
            $error[] = '纬度不可为空';
        }
        if ($this->validateParam($this->input->post('updown'))) {
            $error[] = '上下架状态必选.';
        }
        //地区
        $regionids = array($this->input->post('province_id'), $this->input->post('city_id'), $this->input->post('district_id'));
        $region = $this->region->getByRegionIds($regionids);
        if ($region->num_rows() < 3) {
            $error[] = '城市地区请填写完整。';
        }
        $regionNames = array();
        foreach ($region->result() as $item) {
            $regionNames[] = $item->region_name;
        }
        $_POST['address'] = $regionNames[0] .' '.$regionNames[1].' '.$regionNames[2].' '.($this->input->post('address') ? $this->input->post('address') : ' ');
        return $error;
    }

    public function setUpdown()
    {
        $sid = $this->input->post('goods_id');
        $status = $this->input->post('flag');
        switch ($status) {
            case '1': $updown = '2'; break;
            case '2': $updown = '1'; break;
            default : $updown = '1'; break;
        }
        $this->db->trans_start();
        $isUpdate = $this->scenic_base->updateBySid($sid, array('updown'=>$updown));
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE && $isUpdate) {
            echo json_encode(array(
                'flag' => $updown,
            ));
        } else {
            echo json_encode(array(
                'flag' => 3,
            ));
        }
        exit;
    }

    public function excelExport($getData)
    {
        $result = $this->scenic_base->excelExport($getData);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_base/grid', null, '这个时间段没有记录');
        }
        if ($result->num_rows() > 10000){
            $this->error('scenic_base/grid', null, '由于导出的数据太多，请选择一个时间范围');
        }
        $arrayResult = $result->result_array();
        array_unshift($arrayResult, array('景点编号', '景点名称', '景点特色', '景点星级', '主题', '开放时间', '供应商编号', '地址', '地图类型', '经度', '纬度', '状态1-上架2-下架', '添加时间', '更新时间'));
        $this->load->library('excel');
        $this->excel->addArray($arrayResult);
        $this->excel->generateXML(date('Ymd').'景点列表');
    }

    /**
     * 获取
     * @param number $pg
     */
    public function ajaxGoodsBase($pg=1)
    {
        $pageNum = 10;
        $num = ($pg-1)*$pageNum;
        $config['per_page'] = $pageNum;
        $config['first_url'] = base_url('scenic_base/ajaxGetScenic').$this->pageGetParam($this->input->get());
        $config['suffix'] = $this->pageGetParam($this->input->get());
        $config['base_url'] = base_url('scenic_base/ajaxGetScenic');
        $config['total_rows'] = $this->scenic_base->total($this->input->get());
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pg_link']   = $this->pagination->create_links();
        $data['page_list'] = $this->scenic_base->page_list($pageNum, $num, $this->input->get());
        $data['all_rows']  = $config['total_rows'];
        $data['pg_now']    = $pg;
        $data['page_num']  = $pageNum;
        echo json_encode(array(
            'status'=> true,
            'html'  => $this->load->view('scenic_base/ajaxScenicBase/ajaxData', $data, true)
        ));exit;
    }
}