<?php
class Scenic_goods_model extends CI_Model
{
    private $table = 'scenic_goods';

    public function findByGoodsId($goods_id)
    {
        $this->db->where('goods_id', $goods_id);
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
        $this->db->order_by('goods_id', 'DESC');
        $this->db->limit($pageNum, $num);
        return $this->db->get($this->table);
    }

    public function excelExport($params = array())
    {
        $this->db->select('goods_id, scenic_name, special, star_level, theme_id, open_time, supplier_id, address, locType, longitude, latitude, updown, created_at, updated_at');
        $this->checkWhereParam($params);
        $this->db->order_by('goods_id', 'DESC');
        return $this->db->get($this->table);
    }

    private function checkWhereParam($params = array())
    {
        if (!empty($params['sid'])) {
            $this->db->where('sid', $params['sid']);
        }
        if (!empty($params['cat_id'])) {
            $this->db->where('cat_id', $params['cat_id']);
        }
        if (!empty($params['scenic_goods'])) {
            $this->db->where('scenic_goods', $params['scenic_goods']);
        }
        if (!empty($param['goods_search'])) {
            $this->db->where("((`goods_name` LIKE '%{$param['goods_search']}%') OR (`goods_id`='{$param['goods_search']}'))");
        }
        if (!empty($params['is_check'])) {
            $this->db->where('is_check', $params['is_check']);
        }
        if (!empty($params['is_on_sale'])) {
            $this->db->where('is_on_sale', $params['is_on_sale']);
        }
        if (!empty($params['rate_id'])) {
            $this->db->where('rate_id', $params['rate_id']);
        }
        if (!empty($params['source_id'])) {
            $this->db->where('source_id', $params['source_id']);
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
            'sid'                => $params['sid'],
            'goods_name'        => $params['goods_name'],
            'cat_id'             => $params['cat_id'],
            'include'            => $params['include'],
            'exclude'            => $params['exclude'],
            'refund_info'       => $params['refund_info'],
            'park_way'           => $params['park_way'],
            'park_address'      => $params['park_address'],
            'in_time'            => !empty($params['in_time']) ? $params['in_time'] : '',
            'out_time'           => !empty($params['out_time']) ? $params['out_time'] : '',
            'advance_date'      => !empty($params['advance_date']) ? $params['advance_date'] : 0,
            'advance_time'      => !empty($params['advance_time']) ? $params['advance_time'] : '',
            'use_delay'          => !empty($params['use_delay']) ? $params['use_delay'] : 0,
            'validity_days'     => !empty($params['validity_days']) ? $params['validity_days'] : 0,
            'price'              => $params['price'],
            'is_edit'            => $params['is_edit'],
            'edit_day'           => !empty($params['edit_day']) ? $params['edit_day'] : 0,
            'edit_time'          => !empty($params['edit_time']) ? $params['edit_time'] : '',
            'is_refund'          => $params['is_refund'],
            'refund_day'         => !empty($params['refund_day']) ? $params['refund_day'] : 0,
            'refund_time'        => !empty($params['refund_time']) ? $params['refund_time'] : '',
            'is_partly_refund'  => $params['is_partly_refund'],
            'buyers'              => !empty($params['buyers']) ? $params['buyers'] : '',
            'unbuyers'            => !empty($params['unbuyers']) ? $params['unbuyers'] : '',
            'sfz_limit_days'     => $params['sfz_limit_days'],
            'sfz_limit_count'    => !empty($params['sfz_limit_count']) ? $params['sfz_limit_count'] : 0,
            'phone_limit_days'   => $params['phone_limit_days'],
            'phone_limit_count' => !empty($params['phone_limit_count']) ? $params['phone_limit_count'] : 0,
            'min_buy_count'      => !empty($params['min_buy_count']) ? $params['min_buy_count'] : 1,
            'max_buy_count'      => !empty($params['max_buy_count']) ? $params['max_buy_count'] : 999999,
            'rate_id'             => $params['rate_id'],
            'source_id'           => $params['source_id'],
            'api_sid'             => !empty($params['api_sid']) ? $params['api_sid'] : 0,
            'api_goods_id'       => !empty($params['api_goods_id']) ? $params['api_goods_id'] : '',
            'is_check'            => $params['is_check'],
            'is_on_sale'          => $params['is_on_sale'],
            'order_cancel'        => !empty($params['order_cancel']) ? $params['order_cancel'] : 0,
            'created_at'          => date('Y-m-d H:i:s'),
            'updated_at'          => date('Y-m-d H:i:s'),
        );
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($params=array())
    {
        $data = array(
            'sid'                => $params['sid'],
            'goods_name'        => $params['goods_name'],
            'cat_id'             => $params['cat_id'],
            'include'            => $params['include'],
            'exclude'            => $params['exclude'],
            'refund_info'       => $params['refund_info'],
            'park_way'           => $params['park_way'],
            'park_address'      => $params['park_address'],
            'in_time'            => !empty($params['in_time']) ? $params['in_time'] : '',
            'out_time'           => !empty($params['out_time']) ? $params['out_time'] : '',
            'advance_date'      => !empty($params['advance_date']) ? $params['advance_date'] : 0,
            'advance_time'      => !empty($params['advance_time']) ? $params['advance_time'] : '',
            'use_delay'          => !empty($params['use_delay']) ? $params['use_delay'] : 0,
            'validity_days'     => !empty($params['validity_days']) ? $params['validity_days'] : 0,
            'price'              => $params['price'],
            'is_edit'            => $params['is_edit'],
            'edit_day'           => !empty($params['edit_day']) ? $params['edit_day'] : 0,
            'edit_time'          => !empty($params['edit_time']) ? $params['edit_time'] : '',
            'is_refund'          => $params['is_refund'],
            'refund_day'         => !empty($params['refund_day']) ? $params['refund_day'] : 0,
            'refund_time'        => !empty($params['refund_time']) ? $params['refund_time'] : '',
            'is_partly_refund'  => $params['is_partly_refund'],
            'buyers'              => !empty($params['buyers']) ? $params['buyers'] : '',
            'unbuyers'            => !empty($params['unbuyers']) ? $params['unbuyers'] : '',
            'sfz_limit_days'     => $params['sfz_limit_days'],
            'sfz_limit_count'    => !empty($params['sfz_limit_count']) ? $params['sfz_limit_count'] : 0,
            'phone_limit_days'   => $params['phone_limit_days'],
            'phone_limit_count' => !empty($params['phone_limit_count']) ? $params['phone_limit_count'] : 0,
            'min_buy_count'      => !empty($params['min_buy_count']) ? $params['min_buy_count'] : 1,
            'max_buy_count'      => !empty($params['max_buy_count']) ? $params['max_buy_count'] : 999999,
            'rate_id'             => $params['rate_id'],
            'source_id'           => $params['source_id'],
            'api_sid'             => !empty($params['api_sid']) ? $params['api_sid'] : 0,
            'api_goods_id'       => !empty($params['api_goods_id']) ? $params['api_goods_id'] : '',
            'is_check'            => $params['is_check'],
            'is_on_sale'          => $params['is_on_sale'],
            'order_cancel'        => !empty($params['order_cancel']) ? $params['order_cancel'] : 0,
            'updated_at'          => date('Y-m-d H:i:s'),
        );
        $this->db->where('goods_id', $params['goods_id']);
        return $this->db->update($this->table, $data);
    }

    public function updateByGoodsId($goods_id, $params = array())
    {
        $data = array();
        if (!empty($params['is_check'])) {
            $data['is_check'] = $params['is_check'];
        }
        if (!empty($params['is_on_sale'])) {
            $data['is_on_sale'] = $params['is_on_sale'];
        }
        $this->db->where('goods_id', $goods_id);
        return $this->db->update($this->table, $data);
    }
}