<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Record extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('records');
	}
	
	public function index()
	{
		$this->load->view('record');
	}

	/**
     * 実績を新規追加する
     * @method add
     */
    public function add()
    {
        if (!empty($this->input->post()) && form_validation()) {
            $arrayPost = $this->input->post();
            
            if (empty($error)) {
                $record = $this->records->create_record($arrayPost);
            }
            
            if (!empty($record)) {
                // alert用のメッセージ
                $this->session->set_flashdata('success_message', [
                    '実績を登録しました'
                ]);
                
                redirect('/top');
            } else {
                // alert用のメッセージ
                $this->session->set_flashdata('error_message', [
                    '実績の登録に失敗しました'
                ]);
            }
        }
    }
}
