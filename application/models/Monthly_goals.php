<?php

class Monthly_Goals extends CI_Model
{
    /**
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 目標を取得する
     * @method get_monthly_goal
     * @param  array $array
     * @return stdClass|boolean
     */
    public function get_monthly_goal($array = false)
    {
        if (!empty($array['date'])) {
            $this->db->where('monthly_goals.date', $array['date']);
            $this->db->order_by('monthly_goals.created_at', 'DESC');
        } else {
            return false;
        }
        
        $this->db->select('monthly_goals.*');
        $query = $this->db->get('monthly_goals');
        
        if (!empty($query) && $query->num_rows() > 0) {
            return $query->result()[0];
        } else {
            return false;
        }
    }

    /**
     * 目標を新規作成
     * @method set_monthly_goal
     * @param  array $array
     * @return integer $id|boolean
     */
    public function create_monthly_goal($array = false)
    {
        $data = [
            'date' => $array['date'].'-01',
            'total_customers' => $array['total_customers'],
            'tech_sales' => $array['tech_sales'],
            'goods_sales' => $array['goods_sales'],
            'other_sales' => $array['other_sales'],
            'total_sales' => $array['total_sales']
        ];
        
        try {
            $this->db->trans_start();
            $this->db->insert('monthly_goals', $data);
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                return false;
            } else {
                $id = $this->db->insert_id();
                $this->db->trans_commit();
                return $id;
            }
        } catch (Exception $e) {
            log_message('error: ', $e->getMessage());
            return false;
        }
    }

    /**
     * 目標を取得する
     * @method get_plot
     * @param  array $array
     * @return stdClass|boolean
     */
    public function get_plot($array = false)
    {
        $result = array();
        $record = $this->get_monthly_goal($array);
        
        if (!empty($record)) {
            $total_sales = $record->total_sales;
            $days        = (int)date('t', strtotime($array['date'].'-01'));

            for ($i=0;$i<$days;$i++) {
                if ($i + 1 == $days) {
                    array_push($result, $total_sales);
                } else {
                    if ($i == 0) {
                        array_push($result, 0);
                    } else {
                        array_push($result, '-');
                    }
                }
            }
            return $result;
        }
        return false;
    }
}
