<?php
class Scenic_base_model extends CI_Model
{
    private $table = 'scenic_base';

    public function findBySid($sid)
    {
        $this->db->where('sid', $sid);
        return $this->db->get($this->table);
    }

    public function total($params=array()) 
    {
        $this->checkWhereParam($params);
        return $this->db->count_all_results($this->table);
    }

    public function page_list($pageNum, $num, $params=array())
    {
        $this->checkWhereParam($params);
        $this->db->order_by('sid', 'DESC');
        $this->db->limit($pageNum, $num);
        return $this->db->get($this->table);
    }

    public function excelExport($params = array())
    {
        $this->db->select('sid, scenic_name, special, star_level, theme_id, open_time, supplier_id, address, locType, longitude, latitude, updown, created_at, updated_at');
        $this->checkWhereParam($params);
        $this->db->order_by('sid', 'DESC');
        return $this->db->get($this->table);
    }

    private function checkWhereParam($params = array())
    {
        if (!empty($params['sid'])) {
            $this->db->where('sid', $params['sid']);
        }
        if (!empty($params['scenic_name'])) {
            $this->db->where('scenic_name', $params['scenic_name']);
        }
        if (!empty($params['scenic_search'])) {
            $this->db->where("((`scenic_name` LIKE '%{$params['scenic_search']}%') OR (`sid`='{$params['scenic_search']}'))");
        }
        if (!empty($params['uid'])) {
            $this->db->where('uid', $params['uid']);
        }
        if (!empty($params['star_level'])) {
            $this->db->where('star_level', $params['star_level']);
        }
        if (!empty($params['scope'])) {
            $this->db->where('scope', $params['scope']);
        }
        if (!empty($params['status'])) {
            $this->db->where('status', $params['status']);
        }
        if (!empty($params['province_id'])) {
            $this->db->where('province_id', $params['province_id']);
        }
        if (!empty($params['city_id'])) {
            $this->db->where('city_id', $params['city_id']);
        }
        if (!empty($params['district_id'])) {
            $this->db->where('district_id', $params['district_id']);
        }
        if (!empty($params['start_time'])) {
            $this->db->where('created_at >=', $params['start_time'].' 00:00:00');
        }
        if (!empty($params['end_time'])) {
            $this->db->where('created_at <=', $params['end_time'].' 23:59:59');
        }
    }

    public function insert($params=array())
    {
        $data = array(
            'scenic_name'   => $params['scenic_name'],
            'special'       => $params['special'],
            'star_level'    => $params['star_level'],
            'theme_id'      => $params['theme_id'],
            'open_time'     => $params['open_time'],
            'notice'        => $params['notice'],
            'info'          => $params['info'],
            'traffic'       => !empty($params['traffic']) ? $params['traffic'] : '',
            'attention'     => !empty($params['attention']) ? $params['attention'] : '',
            'pics'          => '',
            'uid'            => $params['uid'],
            'province_id'   => $params['province_id'],
            'city_id'       => $params['city_id'],
            'district_id'   => $params['district_id'],
            'address'       => $params['address'],
            'locType'       => $params['locType'],
            'longitude'     => $params['longitude'],
            'latitude'      => $params['latitude'],
            'updown'        => $params['updown'],
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        );
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($params=array())
    {
        $data = array(
            'scenic_name'   => $params['scenic_name'],
            'special'       => $params['special'],
            'star_level'    => $params['star_level'],
            'theme_id'      => $params['theme_id'],
            'open_time'     => $params['open_time'],
            'notice'        => $params['notice'],
            'info'          => $params['info'],
            'traffic'       => !empty($params['traffic']) ? $params['traffic'] : '',
            'attention'     => !empty($params['attention']) ? $params['attention'] : '',
            'uid'            => $params['uid'],
            'province_id'   => $params['province_id'],
            'city_id'       => $params['city_id'],
            'district_id'   => $params['district_id'],
            'address'       => $params['address'],
            'locType'       => $params['locType'],
            'longitude'     => $params['longitude'],
            'latitude'      => $params['latitude'],
            'updown'        => $params['updown'],
            'updated_at'    => date('Y-m-d H:i:s'),
        );
        $this->db->where('sid', $params['sid']);
        return $this->db->update($this->table, $data);
    }

    public function updateBySid($sid, $params = array())
    {
        $data = array();
        if (!empty($params)) {
            $data['updown'] = $params['updown'];
        }
        $this->db->where('sid', $sid);
        return $this->db->update($this->table, $data);
    }
}