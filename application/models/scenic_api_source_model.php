<?php
class Scenic_api_source_model extends CI_Model
{
    private $table = 'scenic_api_source';

    public function find($isArray = false)
    {
        $result = $this->db->get($this->table);
        if ($isArray) {
            $rows = array();
            foreach ($result->result_array() as $row) {
                $rows[$row['source_id']] = $row;
            }
            return $rows;
        }
        return $result;
    }

    public function findBySourceId($source_id)
    {
        $this->db->where('source_id', $source_id);
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
        $this->db->order_by('source_id', 'DESC');
        $this->db->limit($page_num, $num);
        return $this->db->get($this->table);
    }

    private function checkWhereParam($params = array())
    {
        if (!empty($params['source_name'])) {
            $this->db->where('source_name', $params['source_name']);
        }
        if (!empty($params['purpose'])) {
            $this->db->where('purpose', $params['purpose']);
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
            'source_name'  => $params['scenic_name'],
            'source_key'   => $params['source_key'],
            'source_url'   => $params['source_url'],
            'purpose'       => $params['purpose'],
            'created_at'   => date('Y-m-d H:i:s'),
        );
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($params=array())
    {
        $data = array(
            'source_name'  => $params['scenic_name'],
            'source_key'   => $params['source_key'],
            'source_url'   => $params['source_url'],
            'purpose'       => $params['purpose'],
        );
        $this->db->where('source_id', $params['source_id']);
        return $this->db->update($this->table, $data);
    }
}