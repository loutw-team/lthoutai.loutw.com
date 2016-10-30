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
        $this->load->model('user_model', 'user');
        $this->load->model('region_model', 'region');
    }

    public function grid($pg = 1)
    {
        $page_num = 20;
        $num = ($pg - 1) * $page_num;
        $config['first_url'] = base_url('scenic_base/grid').$this->pageGetParam($this->input->get());
        $config['suffix'] = $this->pageGetParam($this->input->get());
        $config['base_url'] = base_url('scenic_base/grid');
        $config['total_rows'] = $this->scenic_base->total($this->input->get());
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pg_link'] = $this->pagination->create_links();
        $data['page_list'] = $this->scenic_base->page_list($page_num, $num, $this->input->get());
        $data['all_rows'] = $config['total_rows'];
        $data['pg_now'] = $pg;
        $data['page_num'] = $page_num;
        $data['scenicTheme'] = $this->scenic_theme->find(TRUE);
        $data['starLevel'] = $this->starLevel;
        $data['updown'] = $this->updown;
        $this->load->view('scenic_base/grid', $data);
    }

    public function add()
    {
        $data['scenicTheme'] = $this->scenic_theme->find(TRUE);
        $data['starLevel'] = $this->starLevel;
        $data['updown'] = $this->updown;
        $this->load->view('scenic_base/add', $data);
    }

    public function addPost()
    {
        $error = $this->validate();
        if (!empty($error)) {
            $this->error('scenic_base/add', array('sid', $this->input->post('sid')), $error);
        }

        $this->db->trans_start();
        $resultId = $this->scenic_base->insert($this->input->post());
        $this->db->trans_complete();

        if ($resultId) {
            $this->success('scenic_base/grid', array('sid', $this->input->post('sid')), '保存成功！');
        } else {
            $this->error('scenic_base/add', array('sid', $this->input->post('sid')), '保存失败！');
        }
    }

    public function edit($sid)
    {
        $result = $this->scenic_base->findById($sid);
        if($result->num_rows() <= 0) {
            $this->redirect('scenic_base/grid?sid='.$this->input->post('sid'));
        }
        $data['userCouponGet'] = $result->row(0);
        $data['scenicTheme'] = $this->scenic_theme->find(TRUE);
        $data['starLevel'] = $this->starLevel;
        $data['updown'] = $this->updown;
        $this->load->view('scenic_base/edit', $data);
    }

    public function editPost()
    {
        $sid = $this->input->post('coupon_get_id');
        $error = $this->validate();
        if (!empty($error)) {
            $this->error('scenic_base/edit/'.$sid, array('sid', $this->input->post('sid')), $error);
        }

        $this->db->trans_start();
        $resultId = $this->scenic_base->update($this->input->post());
        $this->db->trans_complete();

        if ($resultId) {
            $this->success('scenic_base/grid', array('sid', $this->input->post('sid')), '保存成功！');
        } else {
            $this->error('scenic_base/edit/'.$sid, array('sid', $this->input->post('sid')), '保存失败！');
        }
    }

    public function updown()
    {
        $goods_id = $this->input->post('goods_id');
        $status = $this->input->post('flag');
        switch ($status) {
            case '1': $updown = 2; break;
            case '2': $updown = 1; break;
            default : $updown = 1; break;
        }
        $this->db->trans_start();
        $isUpdate = $this->scenic_base->updateStatus($goods_id, array('updown'=>$updown));
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
}