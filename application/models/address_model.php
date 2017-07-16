<?php
class Address_model extends CI_Model
{
	private $table = 'address';

	public function findByAddressId($address_id)
	{
	    return $this->db->get_where($this->table, array('address_id' => $address_id));
	}
	
	public function findByUid($uid)
	{
	    return $this->db->get_where($this->table, array('uid' => $uid));
	}
	
	public function insert($postData)
	{
	    $data = array(
	        'uid'               => $postData['uid'],
	        'province_id'      => $postData['province_id'],
	        'city_id'          => $postData['city_id'],
	        'district_id'      => $postData['district_id'],
	        'detailed'         => $postData['detailed'],
	        'code'             => $postData['code'],
	        'receiver_name'    => $postData['receiver_name'],
	        'tel'              => $postData['tel'],
	        'code'             => $postData['code'],
	        'is_default'       => $postData['is_default'],
	    );
	    $this->db->insert($this->table, $data);
	    return $this->db->insert_id();
	}
	
	/**
	 * 更新为非默认
	 * */
	public function setNoDefault($uid)
	{
	    $this->db->update($this->table, array('is_default'=>1), array('uid'=>$uid));
	    return $this->db->affected_rows();
	}
	
	public function update($postData)
	{
	    $data = array(
	        'province_id'      => $postData['province_id'],
	        'city_id'          => $postData['city_id'],
	        'district_id'      => $postData['district_id'],
	        'detailed'         => $postData['detailed'],
	        'code'             => $postData['code'],
	        'receiver_name'    => $postData['receiver_name'],
	        'tel'              => $postData['tel'],
	        'code'             => $postData['code'],
	        'is_default'       => $postData['is_default'],
	    );
	    $this->db->update($this->table, $data, array('address_id'=>$postData['address_id']));
	    return $this->db->affected_rows();
	}
	
	public function delete($where)  
	{
	    $this->db->delete($this->table, $where);
	    return $this->db->affected_rows();
	}
}