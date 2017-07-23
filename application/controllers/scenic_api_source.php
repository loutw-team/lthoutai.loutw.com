<?php
class Scenic_api_source extends CS_Controller
{
    private $purpose = array(1 => '自动对接', 2 => '二次下单');

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('scenic_api_source_model', 'scenic_api_source');
    }

    public function grid($pg = 1)
    {
        $getData = $this->input->get();
        $pageNum = 20;
        $num = ($pg - 1) * $pageNum;
        $config['first_url'] = base_url('scenic_api_source/grid').$this->pageGetParam($getData);
        $config['suffix'] = $this->pageGetParam($getData);
        $config['base_url'] = base_url('scenic_api_source/grid');
        $config['total_rows'] = $this->scenic_api_source->total($getData);
        $this->pagination->initialize($config);
        $data['pg_link'] = $this->pagination->create_links();
        $data['page_list'] = $this->scenic_api_source->page_list($pageNum, $num, $getData);
        $data['all_rows'] = $config['total_rows'];
        $data['pg_now'] = $pg;
        $data['page_num'] = $pageNum;
        $data['purpose'] = $this->purpose;
        $this->load->view('scenic_api_source/grid', $data);
    }

    public function add()
    {
        $this->load->view('scenic_api_source/add');
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
        if ($this->input->post('source_id')) {
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
        $cat_id = $this->scenic_api_source->insert($params);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE && $cat_id) {
            $this->session->set_flashdata('success', '保存成功!');
            $this->jsonMessage('', base_url('scenic_api_source/grid'));
        } else {
            $this->jsonMessage('保存失败！');
        }
    }

    /**
     * 编辑
     * @param unknown $cat_id
     */
    public function edit($source_id)
    {
        $result = $this->scenic_api_source->findBySourceId($source_id);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_api_source/grid', '', '找不到产品相关信息！');
        }
        $scenicApiSource = $result->row(0);
        $data['scenicApiSource'] = $scenicApiSource;
        $this->load->view('scenic_api_source/edit', $data);
    }

    public function editPost()
    {
        $theme_id = $this->input->post('cat_id');
        $params = $this->input->post();
        $this->db->trans_start();
        $update = $this->scenic_api_source->update($params);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->session->set_flashdata('success', '编辑成功!');
            $this->jsonMessage('', base_url('scenic_api_source/grid'));
        } else {
            $this->jsonMessage('编辑失败！');
        }
    }

    /**
     * 验证过程
     * @return multitype:string
     */
    public function validate()
    {
        $error = array();
        if ($this->validateParam($this->input->post('source_name'))) {
            $error[] = '来源名称不可为空！';
        }
        if ($this->validateParam($this->input->post('source_key'))) {
            $error[] = '来源标识不可为空！';
        }
        if ($this->validateParam($this->input->post('purpose'))) {
            $error[] = '对接方式不可为空';
        }
        return $error;
    }
}