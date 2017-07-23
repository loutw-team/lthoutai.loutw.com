<?php
class Scenic_goods extends CS_Controller
{
    private $isCheck = array(1 => '待审核', 2 => '通过审核', 3 => '审核失败');
    private $isOnSale = array(1 => '上架', 2 => '下架');
    private $bookingLimit = array(0 => '无', 1 => '1天', 2 => '1周', 3 => '1月', 4 => '1年');

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('scenic_goods_model', 'scenic_goods');
        $this->load->model('scenic_cat_model', 'scenic_cat');
        $this->load->model('scenic_api_source_model', 'scenic_api_source');
        $this->load->model('scenic_profit_rate_model', 'scenic_profit_rate');
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
            $config['first_url'] = base_url('scenic_goods/grid').$this->pageGetParam($getData);
            $config['suffix'] = $this->pageGetParam($getData);
            $config['base_url'] = base_url('scenic_goods/grid');
            $config['total_rows'] = $this->scenic_goods->total($getData);
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config);
            $data['pg_link'] = $this->pagination->create_links();
            $data['page_list'] = $this->scenic_goods->page_list($pageNum, $num, $getData);
            $data['all_rows'] = $config['total_rows'];
            $data['pg_now'] = $pg;
            $data['page_num'] = $pageNum;
            $data['isCheck'] = $this->isCheck;
            $data['isOnSale'] = $this->isOnSale;
            $data['scenicApiSource'] = $this->scenic_api_source->find(true);
            $data['scenicCat'] = $this->scenic_cat->find(true);
            $data['scenicProfitRate'] = $this->scenic_profit_rate->find(true);
            $this->load->view('scenic_goods/grid', $data);
        }
    }

    public function add()
    {
        $data['sid']  = $this->input->get('sid');
        $data['isCheck'] = $this->isCheck;
        $data['isOnSale'] = $this->isOnSale;
        $data['bookingLimit'] = $this->bookingLimit;
        $data['scenicApiSource'] = $this->scenic_api_source->find(true);
        $data['scenicCat'] = $this->scenic_cat->find(true);
        $data['scenicProfitRate'] = $this->scenic_profit_rate->find(true);
        $this->load->view('scenic_goods/add', $data);
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
        if ($this->input->post('goods_id')) {
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
        $goods_id = $this->scenic_goods->insert($params);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->session->set_flashdata('success', '保存成功!');
            $this->jsonMessage('', base_url('scenic_goods/grid').'?sid='.$this->input->post('sid'));
        } else {
            $this->jsonMessage('保存失败！');
        }
    }

    /**
     * 编辑
     * @param unknown $goods_id
     */
    public function edit($goods_id)
    {
        $result = $this->scenic_goods->findByGoodsId($goods_id);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_goods/grid', '', '找不到产品相关信息！');
        }
        $scenicGoods = $result->row(0);
        $data['scenicGoods'] = $scenicGoods;
        $data['isCheck']     = $this->isCheck;
        $data['isOnSale']    = $this->isOnSale;
        $data['bookingLimit'] = $this->bookingLimit;
        $data['scenicApiSource'] = $this->scenic_api_source->find(true);
        $data['scenicCat'] = $this->scenic_cat->find(true);
        $data['scenicProfitRate'] = $this->scenic_profit_rate->find(true);
        $this->load->view('scenic_goods/edit', $data);
    }

    public function editPost()
    {
        $sid = $this->input->post('goods_id');
        $params = $this->input->post();
        $this->db->trans_start();
        $update = $this->scenic_goods->update($params);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->session->set_flashdata('success', '编辑成功!');
            $this->jsonMessage('', base_url('scenic_goods/grid').'?sid='.$this->input->post('sid'));
        } else {
            $this->jsonMessage('编辑失败！');
        }
    }

    /**
     * 复制
     * @param unknown $goods_id
     */
    public function copy($goods_id)
    {
        $result = $this->scenic_goods->findByGoodsId($goods_id);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_goods/grid', '', '找不到产品相关信息！');
        }
        $scenicGoods = $result->row(0);
        $data['scenicGoods'] = $scenicGoods;
        $data['isCheck']     = $this->isCheck;
        $data['isOnSale']    = $this->isOnSale;
        $data['bookingLimit'] = $this->bookingLimit;
        $data['scenicApiSource'] = $this->scenic_api_source->find(true);
        $data['scenicCat'] = $this->scenic_cat->find(true);
        $data['scenicProfitRate'] = $this->scenic_profit_rate->find(true);
        $this->load->view('scenic_goods/copy', $data);
    }

    /**
     * 验证过程
     * @return multitype:string
     */
    public function validate()
    {
        $error = array();
        if ($this->validateParam($this->input->post('goods_name'))) {
            $error[] = '门票名称不可为空！';
        }
        if ($this->validateParam($this->input->post('cat_id'))) {
            $error[] = '票种不可为空！';
        }
        if ($this->validateParam($this->input->post('include'))) {
            $error[] = '费用包含不可为空！';
        }
        if ($this->validateParam($this->input->post('exclude'))) {
            $error[] = '费用不含不可为空！';
        }
        if ($this->validateParam($this->input->post('refund_info'))) {
            $error[] = '退款说明不可为空！';
        }
        if ($this->validateParam($this->input->post('park_way'))) {
            $error[] = '入园方式不可为空！';
        }
        if ($this->validateParam($this->input->post('park_address'))) {
            $error[] = '取票地址不可为空！';
        }
        if ($this->validateParam($this->input->post('rate_id'))) {
            $error[] = '分润方式不可为空！';
        }
        return $error;
    }

    public function isCheck()
    {
        $goods_id = $this->input->post('goods_id');
        $is_check = $this->input->post('is_check');
        switch ($is_check) {
            case '1': $isCheck = '1'; break;
            case '2': $isCheck = '2'; break;
            case '3': $isCheck = '3'; break;
            default : $isCheck = '1'; break;
        }
        $this->db->trans_start();
        $isUpdate = $this->scenic_goods->updateByGoodsId($goods_id, array('is_check' => $isCheck));
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE && $isUpdate) {
            echo json_encode(array(
                'status' => $is_check,
            ));
        } else {
            echo json_encode(array(
                'status' => 3,
            ));
        }
        exit;
    }

    /**
     * 上下架
     */
    public function setUpdown()
    {
        $goods_id = $this->input->post('goods_id');
        $status = $this->input->post('flag');
        switch ($status) {
            case '1': $isOnSale = '2'; break;
            case '2': $isOnSale = '1'; break;
            default : $isOnSale = '1'; break;
        }
        $this->db->trans_start();
        $isUpdate = $this->scenic_goods->updateByGoodsId($goods_id, array('is_on_sale' => $isOnSale));
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE && $isUpdate) {
            echo json_encode(array(
                'flag' => $isOnSale,
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
        $result = $this->scenic_goods->excelExport($getData);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_goods/grid', null, '这个时间段没有记录');
        }
        if($result->num_rows() > 10000){
            $this->error('scenic_goods/grid', null, '由于导出的数据太多，请选择一个时间范围');
        }
        $arrayResult = $result->result_array();
        array_unshift($arrayResult, array('景点编号', '景点名称', '景点特色', '景点星级', '主题', '开放时间', '供应商编号', '地址', '地图类型', '经度', '纬度', '状态1-上架2-下架', '添加时间', '更新时间'));
        $this->load->library('excel');
        $this->excel->addArray($arrayResult);
        $this->excel->generateXML(date('Ymd').'门票列表');
    }
}