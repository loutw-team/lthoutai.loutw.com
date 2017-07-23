<?php
class Scenic_theme extends CS_Controller
{
    private $isShow = array(1 => '显示', 2 => '不显示');

    public function _init()
    {
        $this->load->library('pagination');
        $this->load->model('scenic_theme_model', 'scenic_theme');
    }

    public function grid($pg = 1)
    {
        $getData = $this->input->get();
        $pageNum = 20;
        $num = ($pg - 1) * $pageNum;
        $config['first_url'] = base_url('scenic_theme/grid').$this->pageGetParam($getData);
        $config['suffix'] = $this->pageGetParam($getData);
        $config['base_url'] = base_url('scenic_theme/grid');
        $config['total_rows'] = $this->scenic_theme->total($getData);
        $this->pagination->initialize($config);
        $data['pg_link'] = $this->pagination->create_links();
        $data['page_list'] = $this->scenic_theme->page_list($pageNum, $num, $getData);
        $data['all_rows'] = $config['total_rows'];
        $data['pg_now'] = $pg;
        $data['page_num'] = $pageNum;
        $data['isShow'] = $this->isShow;
        $this->load->view('scenic_theme/grid', $data);
    }

    public function add()
    {
        $this->load->view('scenic_theme/add');
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
        $theme_id = $this->scenic_theme->insert($params);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE && $theme_id) {
            $this->session->set_flashdata('success', '保存成功!');
            $this->jsonMessage('', base_url('scenic_theme/grid'));
        } else {
            $this->jsonMessage('保存失败！');
        }
    }

    /**
     * 编辑
     * @param unknown $theme_id
     */
    public function edit($theme_id)
    {
        $result = $this->scenic_theme->findByThemeId($theme_id);
        if ($result->num_rows() <= 0) {
            $this->error('scenic_theme/grid', '', '找不到产品相关信息！');
        }
        $scenicTheme = $result->row(0);
        $data['scenicTheme'] = $scenicTheme;
        $this->load->view('scenic_theme/edit', $data);
    }

    public function editPost()
    {
        $theme_id = $this->input->post('theme_id');
        $params = $this->input->post();
        $this->db->trans_start();
        $update = $this->scenic_theme->update($params);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->session->set_flashdata('success', '编辑成功!');
            $this->jsonMessage('', base_url('scenic_theme/grid'));
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
        if ($this->validateParam($this->input->post('theme_name'))) {
            $error[] = '主题名称不可为空！';
        }
        if ($this->validateParam($this->input->post('is_show'))) {
            $error[] = '主题状态不可为空';
        }
        return $error;
    }
}