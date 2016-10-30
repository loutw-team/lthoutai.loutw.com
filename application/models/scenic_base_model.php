<?php
class Scenic_base_model extends CI_Model
{
    private $table = 'scenic_base';

    public function findById($sid)
    {
        $this->db->where('sid', $sid);
        return $this->db->get($this->table);
    }

    public function total($params=array()) 
    {
        $this->checkWhereParam($params);
        return $this->db->count_all_results($this->table);
    }   

    public function page_list($page_num, $num, $params=array())
    {
        $this->checkWhereParam($params);
        $this->db->order_by('sid', 'DESC');
        $this->db->limit($page_num, $num);
        return $this->db->get($this->table);
    }

    private function checkWhereParam($params = array())
    {
        if (!empty($params['sid'])) {
            $this->db->where('sid', $params['sid']);
        }
        if (!empty($params['scenic_name'])) {
            $this->db->like('scenic_name', $params['scenic_name']);
        }
        if (!empty($param['scenic_search'])) {
            $this->db->where("((`scenic_name` LIKE '%{$param['goods_search']}%') OR (`sid`='{$param['goods_search']}'))");
        }
        if (!empty($params['uid'])) {
            $this->db->where('uid', $params['uid']);
        }
        if (!empty($params['star_level'])) {
            $this->db->where('star_level', $params['star_level']);
        }
        if (!empty($params['updown'])) {
            $this->db->where('updown', $params['updown']);
        }
        if (!empty($param['province_id'])) {
            $this->db->where('mall_goods_base.province_id', $param['province_id']);
        }
        if (!empty($param['city_id'])) {
            $this->db->where('mall_goods_base.city_id', $param['city_id']);
        }
        if (!empty($param['district_id'])) {
            $this->db->where('mall_goods_base.district_id', $param['district_id']);
        }
        if (!empty($params['start_time'])) {
            $this->db->where('created_at >=', $params['start_time'].' 00:00:00');
        }
        if (!empty($params['end_time'])) {
            $this->db->where('created_at <=', $params['end_time'].' 23:59:59');
        }
    }

    public function insert($postData=array())
    {
        $data = array(
            'scenic_name' => $postData['scenic_name'],
            'special'     => $postData['special'],
            'star_level'  => $postData['star_level'],
            'theme_id'    => $postData['theme_id'],
            'open_time'   => $postData['open_time'],
            'notice'      => $postData['notice'],
            'info'        => $postData['info'],
            'traffic'     => $postData['traffic'],
            'attention'   => $postData['attention'],
            'uid'         => $postData['uid'],
            'province_id' => $postData['province_id'],
            'city_id'     => $postData['city_id'],
            'district_id' => $postData['district_id'],
            'address'     => $postData['address'],
            'locType'     => $postData['locType'],
            'longitude'   => !empty($postData['longitude']) ? $postData['longitude'] : '',
            'latitude'    => !empty($postData['latitude']) ? $postData['latitude'] : '',
            'updown'      => $postData['updown'],
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        );
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($postData=array())
    {
        $data = array(
            'scenic_name' => $postData['scenic_name'],
            'special'     => $postData['special'],
            'star_level'  => $postData['star_level'],
            'theme_id'    => $postData['theme_id'],
            'open_time'   => $postData['open_time'],
            'notice'      => $postData['notice'],
            'info'        => $postData['info'],
            'traffic'     => $postData['traffic'],
            'attention'   => $postData['attention'],
            'uid'         => $postData['uid'],
            'province_id' => $postData['province_id'],
            'city_id'     => $postData['city_id'],
            'district_id' => $postData['district_id'],
            'address'     => $postData['address'],
            'locType'     => $postData['locType'],
            'longitude'   => !empty($postData['longitude']) ? $postData['longitude'] : '',
            'latitude'    => !empty($postData['latitude']) ? $postData['latitude'] : '',
            'updown'      => $postData['updown'],
            'updated_at'  => date('Y-m-d H:i:s'),
        );
        $this->db->where('sid', $postData['sid']);
        return $this->db->update($this->table, $data);
    }

    public function updateStatus($goods_id, $params = array())
    {
        $data = array(
            'updown' => $params['updown'],
        );
        $this->db->where('goods_id', $goods_id);
        return $this->db->update($this->table, $data);
    }
}