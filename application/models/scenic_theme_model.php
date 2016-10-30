<?php
class Scenic_theme_model extends CI_Model
{
    private $table = 'scenic_theme';

    public function findById($theme_id)
    {
        $this->db->where('theme_id', $theme_id);
        return $this->db->get($this->table);
    }

    public function find($isArray=false, $where = '*')
    {
        $this->db->select($where);
        $this->db->from($this->table);
        $this->db->where('is_show', 1);
        $result = $this->db->get();
        if ($isArray) {
            $rows = array();
            foreach ($result->result_array() as $row) {
                $rows[$row['theme_id']] = $row;
            }
            return $rows;
        }
        return $result;
    }

    public function total($params=array()) 
    {
        $this->db->from($this->table);
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
        return $this->db->count_all_results();
    }   

    public function page_list($page_num, $num, $params=array())
    {
        $this->db->from($this->table);
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
        $this->db->order_by('theme_id', 'DESC');
        $this->db->limit($page_num, $num);
        return $this->db->get();
    }

    public function insert($postData=array())
    {
        $data = array(
            'theme_name' => $postData['theme_name'],
            'is_show'    => $postData['is_show'],
            'created_at' => date('Y-m-d H:i:s'),
        );
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($postData=array())
    {
        $data = array(
            'theme_name' => $postData['theme_name'],
            'is_show'    => $postData['is_show'],
        );
        $this->db->where('theme_id', $postData['theme_id']);
        return $this->db->update($this->table, $data);
    }
}