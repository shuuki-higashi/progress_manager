<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// グラフ描画に必要なライブラリ
require_once 'application/libraries/jpgraph-4.2.11/src/jpgraph.php';
require_once 'application/libraries/jpgraph-4.2.11/src/jpgraph_line.php';
require_once 'application/libraries/jpgraph-4.2.11/src/jpgraph_bar.php';

class Result extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('records');
        $this->load->model('monthly_goals');
        $this->load->model('yearly_goals');
	}
	
	public function index()
	{
        $date       = '';
        $formtype   = '';
        $record     = '';
        $graph      = new Graph(600, 200);

        if (!empty($this->input->get()['date'])) {
            $date       = $this->input->get()['date'];
            $formtype   = $this->input->get()['formtype'];

            if ($this->input->get()['formtype'] == 'monthly') {
                $record      = $this->records->sum_monthly(['date' => $date]);
                $goal        = $this->monthly_goals->get_monthly_goal(['date' => $date.'-01']);
                $goal_data   = $this->monthly_goals->get_plot(['date' => $date.'-01']);
                $record_data = $this->records->monthly_total_sales(['date' => $date]);
            } else {   
                $record      = $this->records->sum_yearly(['date' => $date]);
                $goal        = $this->yearly_goals->get_yearly_goal(['date' => $date]);
                $goal_data   = $this->yearly_goals->get_plot(['date' => $date.'-01-01']);
                $record_data = $this->records->yearly_total_sales(['date' => $date]);
            }
            
            // グラフ描画
            if ($record) {
                $graph->setScale('textlin');            // 目盛り
                $graph->title->set('total_sales');      // タイトル
                $graph->Add(new BarPlot($record_data)); // 実績
                $graph->Add(new LinePlot($goal_data));  // 目標
                $graph->Stroke('./test.png');
            }
        }

        $this->load->view('result', [
            'date'      => $date,
            'formtype'  => $formtype,
            'record'    => $record,
            'graph'     => $graph
        ]);
	}
}
