<?php

class Records extends CI_Model
{
    /**
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 実績を取得する
     * @method get_records
     * @param  array $array
     * @return stdClass|boolean
     */
    public function get_record($date)
    {
        if (!empty($date)) {
            $this->db->where('records.date', $date);
        } else {
            return false;
        }
        
        $this->db->select('records.*');
        $query = $this->db->get('records');
        
        if (!empty($query) && $query->num_rows() > 0) {
            return $query->result()[0];
        } else {
            return false;
        }
    }

    /**
     * 実績を新規作成
     * @method set_records
     * @param  array $array
     * @return integer $id|boolean
     */
    public function create_record($array = false)
    {
        $data = [
            'date' => $array['date'],
            'total_customers' => $array['total_customers'],
            'tech_sales' => $array['tech_sales'],
            'goods_sales' => $array['goods_sales'],
            'other_sales' => $array['other_sales'],
            'total_sales' => $array['total_sales']
        ];
        
        try {
            $this->db->trans_start();
            $this->db->insert('records', $data);
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
     * 月の実績を集計
     */
    public function sum_monthly($array = false) {
        $result = [
            'total_customers' => 0,
            'tech_sales' => 0,
            'goods_sales' => 0,
            'other_sales' => 0,
            'total_sales' => 0
        ];
        $days = (int)date('t', strtotime($array['date'].'-01'));
        
        for ($i=1;$i<=$days;$i++) {
            $record = $this->get_record($array['date'].'-'.(string)$i);

            if ($record) {
                $result['total_customers'] += $record->total_customers;
                $result['tech_sales']      += $record->tech_sales;
                $result['goods_sales']     += $record->goods_sales;
                $result['other_sales']     += $record->other_sales;
                $result['total_sales']     += $record->total_sales;
            }
        }

        if ($result['total_sales'] == 0) {
            return false;
        }
        return $result;
    }

    /**
     * 年の実績を集計
     */
    public function sum_yearly($array = false) {
        $result = [
            'total_customers' => 0,
            'tech_sales'      => 0,
            'goods_sales'     => 0,
            'other_sales'     => 0,
            'total_sales'     => 0
        ];
        
        for ($i=0;$i<12;$i++) {
            $record = $this->sum_monthly(['date' => $array['date'].'-'.(string)($i+1)]);

            if ($record) {
                $result['total_customers'] += $record['total_customers'];
                $result['tech_sales']      += $record['tech_sales'];
                $result['goods_sales']     += $record['goods_sales'];
                $result['other_sales']     += $record['other_sales'];
                $result['total_sales']     += $record['total_sales'];
            }
        }

        if ($result['total_sales'] == 0) {
            return false;
        }
        return $result;
    }

    /**
     * 月の総売上
     */
    public function monthly_total_sales($array = false) {
        $result = array();
        $days = (int)date('t', strtotime($array['date'].'-01'));
        
        for ($i=0;$i<$days;$i++) {
            $record = $this->get_record($array['date'].'-'.(string)$i);

            if ($i == 0) {
                if($record) {
                    $result[(string)($i)] = $record->total_sales;
                } else {
                    $result[(string)($i)] = 0;
                }
            } else {
                if($record) {
                    $result[(string)($i)] = $result[(string)($i-1)] + $record->total_sales;
                } else {
                    $result[(string)($i)] = $result[(string)($i-1)];
                }
            }
        }
        return $result;
    }

    /**
     * 年の総売上
     */
    public function yearly_total_sales($array = false) {
        $result = array();
        
        for ($i=0;$i<12;$i++) {
            $record = $this->monthly_total_sales(['date' => $array['date'].'-'.(string)($i+1)]);
            if ($i == 0) {
                if($record) {
                    $result[(string)($i)] = end($record);
                } else {
                    $result[(string)($i)] = 0;
                }
            } else {
                if($record) {
                    $result[(string)($i)] = $result[(string)($i-1)] + end($record);
                } else {
                    $result[(string)($i)] = $result[(string)($i-1)];
                }
            }
        }
        return $result;
    }
}
