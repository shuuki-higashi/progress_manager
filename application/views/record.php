<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <title>実績入力</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.1.2/css/bulma.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
</head>
<body>
    <div class="content">
        <a href="top"><button type="submit" class="button is-rounded">戻る</button></a>
        <h1 class="subtitle">実績入力</h1>
        <form role="form" method="POST" action="record/add" autocomplete="off">
            <div class="field">
                <label class="label">年月</label>
                <div class="control">
                    <input id="datepicker" class="input" type="text" name="date" placeholder="年月">
                </div>
                <label class="label">総客数</label>
                <div class="control">
                    <input id="total_customers" class="input" type="text" name="total_customers" placeholder="総客数">
                </div>
                <label class="label">技術売上</label>
                <div class="control">
                    <input id="tech_sales" class="input in" type="text" name="tech_sales" placeholder="技術売上">
                </div>
                <label class="label">商品売上</label>
                <div class="control">
                    <input id="goods_sales" class="input in" type="text" name="goods_sales" placeholder="商品売上">
                </div>
                <label class="label">他売上</label>
                <div class="control">
                    <input id="other_sales" class="input in" type="text" name="other_sales" placeholder="他売上">
                </div>
                <label class="label">総売上</label>
                <div class="control">
                    <input id="total_sales" class="input out" type="text" name="total_sales" placeholder="総売上">
                </div>
                <div class="subbutton">
                    <button type="submit" class="button">適用</button>
                </div>
            </div>
        </form>
    </div>
</body>
<style>
.subtitle{text-align:center}
.field{width:500px; margin:80px auto;}

.subbutton{margin:10px; text-align:center;}

.ui-datepicker{background:#FFF;}
.ui-state-default{padding:2px;}
.ui-state-default:hover{background:#1fc8db; color:#FFF}
</style>
<script>
    $('#datepicker').datepicker();

    $(".in").keyup(function(){
        var total = 0;
        $(".in").each(function () {
            var get_textbox_value = $(this).val();
            if ($.isNumeric(get_textbox_value)) {
                total += parseFloat(get_textbox_value);
            }                  
        });
        $(".out").val(total);
    });

    // ajaxで実績取得
    $('#datepicker').on('change', function(){
        var date = $(this).val();

        $.ajax({
            type: 'get',
            url: 'http://localhost:8888/record/ajax_record',
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
</script>
</html>