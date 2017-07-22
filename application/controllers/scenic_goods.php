<?php
class Scenic_goods extends CS_Controller
{
    private $isCheck = array(1 => '待审核', 2 => '通过', 3 => '未通过');
    private $isOnSale = array(1 => '上架', 2 => '下架');

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
        $data['isCheck'] = $this->isCheck;
        $data['isOnSale'] = $this->isOnSale;
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
            $this->jsonMessage('', base_url('scenic_goods/grid'));
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
        $result = $this->scenic_goods->findByGoodsId($sid);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_goods/grid', '', '找不到产品相关信息！');
        }
        $scenicGoods = $result->row(0);
        $data['scenicGoods'] = $scenicGoods;
        $data['isCheck']     = $this->isCheck;
        $data['isOnSale']    = $this->isOnSale;
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
            $this->jsonMessage('', base_url('scenic_goods/grid'));
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
        $result = $this->scenic_goods->findByGoodsId($sid);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_goods/grid', '', '找不到产品相关信息！');
        }
        $scenicGoods = $result->row(0);
        $data['scenicGoods'] = $scenicGoods;
        $data['isCheck']     = $this->isCheck;
        $data['isOnSale']    = $this->isOnSale;
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
        if ($this->validateParam($this->input->post('is_on_sale'))) {
            $error[] = '上下架状态必选.';
        }
        return $error;
    }

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
        $isUpdate = $this->scenic_goods->updateBySid($goods_id, array('is_on_sale' => $isOnSale));
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
        $this->excel->generateXML(date('Ymd').'景点列表');
    }

    /**
     * 获取
     * @param number $pg
     */
    public function ajaxScenicGoods($pg = 1)
    {
        $pageNum = 10;
        $num = ($pg-1)*$pageNum;
        $config['per_page'] = $pageNum;
        $config['first_url'] = base_url('scenic_goods/ajaxGetGoods').$this->pageGetParam($this->input->get());
        $config['suffix'] = $this->pageGetParam($this->input->get());
        $config['base_url'] = base_url('scenic_goods/ajaxGetGoods');
        $config['total_rows'] = $this->scenic_goods->total($this->input->get());
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pg_link']   = $this->pagination->create_links();
        $data['page_list'] = $this->scenic_goods->page_list($pageNum, $num, $this->input->get());
        $data['all_rows']  = $config['total_rows'];
        $data['pg_now']    = $pg;
        $data['page_num']  = $pageNum;
        echo json_encode(array(
            'status'=> true,
            'html'  => $this->load->view('scenic_goods/ajaxScenicGoods/ajaxData', $data, true)
        ));exit;
    }
}