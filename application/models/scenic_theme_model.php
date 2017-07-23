<?php
class Scenic_theme_model extends CI_Model
{
    private $table = 'scenic_theme';

    public function find($isArray=false)
    {
        $result = $this->db->get($this->table);
        if ($isArray) {
            $rows = array();
            foreach ($result->result_array() as $row) {
                $rows[$row['theme_id']] = $row;
            }
            return $rows;
        }
        return $result;
    }

    public function findByThemeId($theme_id)
    {
        $this->db->where('theme_id', $theme_id);
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
        $this->db->order_by('theme_id', 'DESC');
        $this->db->limit($page_num, $num);
        return $this->db->get($this->table);
    }

    private function checkWhereParam($params = array())
    {
        if (!empty($params['theme_id'])) {
            $this->db->where('theme_id', $params['theme_id']);
        }
        if (!empty($params['theme_name'])) {
            $this->db->like('theme_name', $params['theme_name']);
        }
        if (!empty($params['is_show'])) {
            $this->db->where('is_show', $params['is_show']);
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
            'theme_name'  => $params['theme_name'],
            'is_show'     => $params['is_show'],
            'created_at'  => date('Y-m-d H:i:s'),
        );
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($params=array())
    {
        $data = array(
            'theme_name'  => $params['theme_name'],
            'is_show'     => $params['is_show'],
            'created_at'  => date('Y-m-d H:i:s'),
        );
        $this->db->where('theme_id', $params['theme_id']);
        return $this->db->update($this->table, $data);
    }
}