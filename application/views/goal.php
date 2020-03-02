<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <title>目標設定</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.1.2/css/bulma.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <script type="text/javascript" src="monthpicker.js"></script>
</head>

<body>
    <div class="content">
        <a href="top"><button type="submit" class="button is-rounded">戻る</button></a>
        <h1 class="subtitle">目標設定</h1>
        <div class="tab_wrap">
            <div class="tab_area tabs is-toggle is-fullwidth">
                <ul>
                    <li class="is-active tab1_label"><a><span>月</span></a></li>
                    <li class="tab2_label"><a><span>年</span></a></li>
                </ul>
            </div>
            <div class="panel_area">
                <div id="panel1" class="tab_panel active">
                    <form role="form" method="POST" action="goal/monthly" autocomplete="off">
                        <div class="field">
                            <label class="label">年月</label>
                            <div class="control">
                                <input id="monthPick" class="input" type="text" name="date" placeholder="年月">
                            </div>
                            <label class="label">総客数</label>
                            <div class="control">
                                <input id="total_customers" class="input" type="text" name="total_customers" placeholder="総客数">
                            </div>
                            <label class="label">技術売上</label>
                            <div class="control">
                                <input id="tech_sales" class="input monthly_input" type="text" name="tech_sales" placeholder="技術売上">
                            </div>
                            <label class="label">商品売上</label>
                            <div class="control">
                                <input id="goods_sales" class="input monthly_input" type="text" name="goods_sales" placeholder="商品売上">
                            </div>
                            <label class="label">他売上</label>
                            <div class="control">
                                <input id="other_sales" class="input monthly_input" type="text" name="other_sales" placeholder="他売上">
                            </div>
                            <label class="label">総売上</label>
                            <div class="control">
                                <input id="total_sales" class="input monthly_output" type="text" name="total_sales" placeholder="総売上">
                            </div>
                            <div class="subbutton">
                                <button type="submit" class="button">適用</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="panel2" class="tab_panel">
                    <form role="form" method="POST" action="goal/yearly" autocomplete="off">
                        <div class="field">
                            <label class="label">年</label>
                            <div class="control">
                                <div class="select">
                                <select id="date" type="text" name="date">
                                    <option value="">選択してください</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                </select>
                                </div>
                            </div>
                            <label class="label">総客数</label>
                            <div class="control">
                                <input id="ytotal_customers" class="input" type="text" name="total_customers" placeholder="総客数">
                            </div>
                            <label class="label">技術売上</label>
                            <div class="control">
                                <input id="ytech_sales" class="input yearly_input" type="text" name="tech_sales" placeholder="技術売上">
                            </div>
                            <label class="label">商品売上</label>
                            <div class="control">
                                <input id="ygoods_sales" class="input yearly_input" type="text" name="goods_sales" placeholder="商品売上">
                            </div>
                            <label class="label">他売上</label>
                            <div class="control">
                                <input id="yother_sales" class="input yearly_input" type="text" name="other_sales" placeholder="他売上">
                            </div>
                            <label class="label">総売上</label>
                            <div class="control">
                                <input id="ytotal_sales" class="input yearly_output" type="text" name="total_sales" placeholder="総売上">
                            </div>
                            <div class="subbutton">
                                <button type="submit" class="button">適用</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<style>
    .subtitle{text-align:center}

    .tab2_label{position: relative; top:-2px;}
    .tab_wrap{width:500px; margin:80px auto;}
    .tab_panel{width:100%; padding:40px 0; display:none;}
    .tab_panel.active{display:block;}
    .panel_area{margin:0 40px 30px; }
    .subbutton{margin:10px; text-align:center;}

    .mtz-monthpicker{background:#FFF;}
    .mtz-monthpicker-month{margin:20px; text-align:center;}
    .mtz-monthpicker-month:hover{background:#1fc8db; color:#FFF;}
    .ui-widget-header{background:#1fc8db;}
</style>
<script>
$(function() {
    // monthPick
    var currentTime = new Date();
    var year = currentTime.getFullYear();
    var year2 = parseInt(year)+10;
    var op = {
            pattern: 'yyyy-mm',
            selectedYear: year,
            startYear: year,
            finalYear: year2,
            monthNames: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月']
        };
    $("#monthPick").monthpicker(op);
    
    // tab
    $(".tab1_label").on("click",function(){
        var $th = $(this).index();
        $(".tab2_label").removeClass("is-active");
        $(".tab_panel").removeClass("active");
        $(this).addClass("active");
        $(".tab1_label").addClass("is-active");
        $(".tab_panel").eq($th).addClass("active");
    });
    $(".tab2_label").on("click",function(){
        var $th = $(this).index();
        $(".tab1_label").removeClass("is-active");
        $(".tab_panel").removeClass("active");
        $(this).addClass("active");
        $(".tab2_label").addClass("is-active");
        $(".tab_panel").eq($th).addClass("active");
    });

    // tolal_sales
    $(".monthly_input").keyup(function(){
        var total = 0;
        $(".monthly_input").each(function () {
            var get_textbox_value = $(this).val();
            if ($.isNumeric(get_textbox_value)) {
                total += parseFloat(get_textbox_value);
            }                  
        });
        $(".monthly_output").val(total);
    });

    // tolal_sales
    $(".yearly_input").keyup(function(){
        var total = 0;
        $(".yearly_input").each(function () {
            var get_textbox_value = $(this).val();
            if ($.isNumeric(get_textbox_value)) {
                total += parseFloat(get_textbox_value);
            }                  
        });
        $(".yearly_output").val(total);
    });

    // ajaxで月目標取得
    $('#monthPick').on('change', function(){
        var date = $(this).val();

        $.ajax({
            type: 'get',
            url: 'http://localhost:8888/goal/ajax_monthly',
            data: {'date': date},
            dataType: 'json'
        })
        .then(
            // 通信成功時のコールバック
            function (data) {
                $('#total_customers').val(data.total_customers);
                $('#tech_sales').val(data.tech_sales);
                $('#goods_sales').val(data.goods_sales);
                $('#other_sales').val(data.other_sales);
                $('#total_sales').val(data.total_sales);
            },
            // 通信失敗時のコールバック
            function () {
                $('#total_customers').val(null);
                $('#tech_sales').val(null);
                $('#goods_sales').val(null);
                $('#other_sales').val(null);
                $('#total_sales').val(null);
        });
    });

    // ajaxで年目標取得
    $('#date').on('change', function(){
        var date = $(this).val();

        $.ajax({
            type: 'get',
            url: 'http://localhost:8888/goal/ajax_yearly',
            data: {'date': date},
            dataType: 'json'
        })
        .then(
            // 通信成功時のコールバック
            function (data) {
                $('#ytotal_customers').val(data.total_customers);
                $('#ytech_sales').val(data.tech_sales);
                $('#ygoods_sales').val(data.goods_sales);
                $('#yother_sales').val(data.other_sales);
                $('#ytotal_sales').val(data.total_sales);
            },
            // 通信失敗時のコールバック
            function () {
                $('#ytotal_customers').val(null);
                $('#ytech_sales').val(null);
                $('#ygoods_sales').val(null);
                $('#yother_sales').val(null);
                $('#ytotal_sales').val(null);
        });
    });
});
</script>
</html>