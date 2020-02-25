<?php

class Yearly_Goals extends CI_Model
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
     * @method get_yearly_goal
     * @param  array $array
     * @return stdClass|boolean
     */
    public function get_yearly_goal($array = false)
    {
        if (!empty($array['date'])) {
            $this->db->where('yearly_goals.date', $array['date']);
        } else {
            return false;
        }
        
        $this->db->select('yearly_goals.*');
        $query = $this->db->get('yearly_goals');
        
        if (!empty($query) && $query->num_rows() > 0) {
            return $query->result()[0];
        } else {
            return false;
        }
    }

    /**
     * 目標を新規作成
     * @method set_yearly_goal
     * @param  array $array
     * @return integer $id|boolean
     */
    public function create_yearly_goal($array = false)
    {
        $data = [
            'date' => $array['date'].'-01-01',
            'total_customers' => $array['total_customers'],
            'tech_sales' => $array['tech_sales'],
            'goods_sales' => $array['goods_sales'],
            'other_sales' => $array['other_sales'],
            'total_sales' => $array['total_sales']
        ];
        
        try {
            $this->db->trans_start();
            $this->db->insert('yearly_goals', $data);
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
        $record = $this->get_yearly_goal($array);
        
        if (!empty($record)) {
            $total_sales = $record->total_sales;

            for ($i=0;$i<12;$i++) {
                if ($i + 1 == 12) {
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
