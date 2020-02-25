<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <title>実績入力</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
</head>
<body>
<a href="top"><button>戻る</button></a>
<form id="login_form" role="form" method="POST" action="record/add" autocomplete="off">
    <div class="form-group">
        <label>年月日</label>
        <input id="datepicker" placeholder="年月日" name="date" type="text">
    </div>
    <div class="form-group">
        <label>総客数</label>
        <input placeholder="総客数" name="total_customers" type="text">
    </div>
    <div class="form-group">
        <label>技術売上</label>
        <input placeholder="技術売上" name="tech_sales" type="text" class="in">
    </div>
    <div class="form-group">
        <label>商品売上</label>
        <input placeholder="商品売上" name="goods_sales" type="text" class="in">
    </div>
    <div class="form-group">
        <label>他売上</label>
        <input placeholder="他売上" name="other_sales" type="text" class="in">
    </div>
    <div class="form-group">
        <label>総売上</label>
        <input placeholder="総売上" name="total_sales" type="text" class="out">
    </div>
    <button type="submit" class="btn">適用</button>
</form>
</body>
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
        console.log(total)
        $(".out").val(total);
    });
</script>
</html>