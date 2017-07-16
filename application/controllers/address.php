<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Address extends CS_Controller
{
    public function _init()
    {
        $this->load->library('pagination');
        $this->load->helper('validation');
        $this->load->model('address_model','address');
        $this->load->model('region_model', 'region');
    }

    public function grid($uid = 0)
    {
        $res = $this->address->findByUid($uid);
        $data['uid'] = $uid;
        $data['res'] = $res->result();
        $this->load->view('address/grid', $data);
    }
    
    public function add($uid)
    {
        $data['uid'] = $uid;
        $this->load->view('address/add', $data);
    }
    
    public function addPost()
    {
        $error = $this->validate();
        $regionAddress = $this->getRegionAddress();
        if (!$regionAddress) {
            $error[] = '城市地区请填写完整。';
        }
        if (!empty($error)) {
            $this->error('address/add', $this->input->post('uid'), $error);
        }
        $postData = $this->input->post();
        $postData['detailed'] = $regionAddress;

        $this->db->trans_start();
        if ($postData['is_default'] == 2) { //如果改为默认，需将此用户其他默认地址改为非默认
            $this->address->setNoDefault($this->input->post('uid'));
        }
        $res = $this->address->insert($postData);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE && $res) {
            $this->success('address/grid', $postData['uid'], '新增成功！');
        } else {
            $this->error('address/add', $postData['uid'], '新增失败！');
        }
    }
    
    public function edit($address_id)
    {
        $res = $this->address->findByAddressId($address_id);
        if ($res->num_rows() > 0) {
            $res = $res->row();
            $data['res'] = $res;
            $data['province_id'] = $res->province_id;
            $data['city_id'] = $res->city_id;
            $data['district_id'] = $res->district_id;
            $data['uid'] = $this->input->get('uid');
            $this->load->view('address/edit', $data);
        } else {
            $this->redirect('user/grid');
        }
    }
    
    public function editPost()
    {
        $error = $this->validate();
        $regionAddress = $this->getRegionAddress();
        if (!$regionAddress) {
            $error[] = '城市地区请填写完整。';
        }
        if (!empty($error)) {
            $this->error('address/edit', $this->input->post('address_id'), $error);
        }
        $postData = $this->input->post();
        $this->db->trans_start();
        if ($postData['is_default'] == 2) { //如果改为默认，需将此用户其他默认地址改为非默认
            $this->address->setNoDefault($this->input->post('uid'));
        }
        $res = $this->address->update($postData);
        $this->db->trans_complete(); 
        if ($this->db->trans_status() === TRUE && $res) {
            $this->success('address/grid', $this->input->post('uid'), '修改成功！');
        } else {
            $this->error('address/edit', $this->input->post('address_id'), '修改失败！');
        }
    }
    
    public function delete($address_id)
    { 
        $is_delete = $this->address->delete(array('address_id'=>$address_id));
        if ($is_delete) {
            $this->success('address/grid', $this->input->get('uid'), '删除成功！');
        } else {
            $this->error('address/grid', $this->input->get('uid'), '删除失败！');
        }
    }
    
    public function validate()
    {
        $error = array();
        if ($this->validateParam($this->input->post('province_id')) || $this->validateParam($this->input->post('city_id')) || $this->validateParam($this->input->post('district_id'))) {
            $error[] = '地区不能为空';
        }
        if ($this->validateParam($this->input->post('detailed'))) {
            $error[] = '详细地址不能为空';
        }
        if ($this->validateParam($this->input->post('code'))) {
            $error[] = '邮编不能为空';
        }
        if ($this->validateParam($this->input->post('receiver_name'))) {
            $error[] = '收货人不能为空';
        }
        if (!valid_mobile($this->input->post('tel'))) {
            $error[] = '联系电话不能为空';
        }
        if ($this->validateParam($this->input->post('is_default'))) {
            $error[] = '是否设置为默认不能为空';
        }
        return $error;
    }

    private function getRegionAddress()
    {
        $regionids = array($this->input->post('province_id'), $this->input->post('city_id'), $this->input->post('district_id'));
        $region = $this->region->getByRegionIds($regionids);
        if ($region->num_rows() < 3) {
            return false;
        }
        $regionNames = array();
        foreach ($region->result() as $item) {
            $regionNames[] = $item->region_name;
        }
        return $regionNames[0] .' '.$regionNames[1].' '.$regionNames[2].' '.($this->input->post('detailed') ? $this->input->post('detailed') : '　');
    }
}