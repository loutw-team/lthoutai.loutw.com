<?php
class Scenic_cat extends CS_Controller
{
    private $isShow = array(1 => '显示', 2 => '不显示');

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('scenic_cat_model', 'scenic_cat');
    }

    public function grid($pg = 1)
    {
        $getData = $this->input->get();
        $pageNum = 20;
        $num = ($pg - 1) * $pageNum;
        $config['first_url'] = base_url('scenic_cat/grid').$this->pageGetParam($getData);
        $config['suffix'] = $this->pageGetParam($getData);
        $config['base_url'] = base_url('scenic_cat/grid');
        $config['total_rows'] = $this->scenic_cat->total($getData);
        $this->pagination->initialize($config);
        $data['pg_link'] = $this->pagination->create_links();
        $data['page_list'] = $this->scenic_cat->page_list($pageNum, $num, $getData);
        $data['all_rows'] = $config['total_rows'];
        $data['pg_now'] = $pg;
        $data['page_num'] = $pageNum;
        $data['isShow'] = $this->isShow;
        $this->load->view('scenic_cat/grid', $data);
    }

    public function add()
    {
        $this->load->view('scenic_cat/add');
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
        if ($this->input->post('theme_id')) {
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
        $cat_id = $this->scenic_cat->insert($params);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE && $cat_id) {
            $this->session->set_flashdata('success', '保存成功!');
            $this->jsonMessage('', base_url('scenic_cat/grid'));
        } else {
            $this->jsonMessage('保存失败！');
        }
    }

    /**
     * 编辑
     * @param unknown $cat_id
     */
    public function edit($cat_id)
    {
        $result = $this->scenic_cat->findByCatId($cat_id);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_cat/grid', '', '找不到产品相关信息！');
        }
        $scenicCat = $result->row(0);
        $data['scenicCat'] = $scenicCat;
        $this->load->view('scenic_cat/edit', $data);
    }

    public function editPost()
    {
        $theme_id = $this->input->post('cat_id');
        $params = $this->input->post();
        $this->db->trans_start();
        $update = $this->scenic_cat->update($params);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->session->set_flashdata('success', '编辑成功!');
            $this->jsonMessage('', base_url('scenic_cat/grid'));
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
        if ($this->validateParam($this->input->post('cat_name'))) {
            $error[] = '票种名称不可为空！';
        }
        if ($this->validateParam($this->input->post('is_show'))) {
            $error[] = '票种状态不可为空';
        }
        return $error;
    }
}