<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goal extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('monthly_goals');
        $this->load->model('yearly_goals');
	}
	
	public function index()
	{
		$this->load->view('goal');
	}

	/**
     * 月目標を新規追加する
     * @method monthly
     */
    public function monthly()
    {
        if (!empty($this->input->post()) && form_validation()) {
            $arrayPost = $this->input->post();
            
            if (empty($error)) {
                $goal = $this->monthly_goals->create_monthly_goal($arrayPost);
            }
            
            if (!empty($goal)) {
                // alert用のメッセージ
                $this->session->set_flashdata('success_message', [
                    '目標を登録しました'
                ]);
                
                redirect($config['base_url'] . '/top', 'location');
            } else {
                // alert用のメッセージ
                $this->session->set_flashdata('error_message', [
                    '目標の登録に失敗しました'
                ]);
            }
        }
    }

    /**
     * 年目標を新規追加する
     * @method yearly
     */
    public function yearly()
    {
        if (!empty($this->input->post()) && form_validation()) {
            $arrayPost = $this->input->post();
            
            if (empty($error)) {
                $goal = $this->yearly_goals->create_yearly_goal($arrayPost);
            }
            
            if (!empty($goal)) {
                // alert用のメッセージ
                $this->session->set_flashdata('success_message', [
                    '目標を登録しました'
                ]);
                
                redirect($config['base_url'] . '/top', 'location');
            } else {
                // alert用のメッセージ
                $this->session->set_flashdata('error_message', [
                    '目標の登録に失敗しました'
                ]);
            }
        }
    }

    /**
     * 月目標を取得する（ajax用）
     * @method record
     */
    public function ajax_monthly()
    {
        if (!empty($this->input->get())) {
            $date   = $this->input->get()['date'];
            $record = $this->monthly_goals->get_monthly_goal(['date' => $date.'-01']);

            if (!empty($record)) {
                $this->output
                     ->set_content_type('application/json')
                     ->set_output(json_encode($record));
            } 
            return false;
        }
    }

    /**
     * 年目標を取得する（ajax用）
     * @method record
     */
    public function ajax_yearly()
    {
        if (!empty($this->input->get())) {
            $date   = $this->input->get()['date'];
            $record = $this->yearly_goals->get_yearly_goal(['date' => $date.'-01-01']);

            if (!empty($record)) {
                $this->output
                     ->set_content_type('application/json')
                     ->set_output(json_encode($record));
            } 
            return false;
        }
    }
}
