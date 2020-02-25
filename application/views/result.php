<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <title>出力</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <script type="text/javascript" src="monthpicker.js"></script>
</head>
<body>
<a href="top"><button>戻る</button></a>
<div class="tab_wrap">
	<div class="tab_area">
		<label class="tab1_label" for="tab1">月</label>
		<label class="tab2_label" for="tab2">年</label>
	</div>
	<div class="panel_area">
		<div id="panel1" class="tab_panel <?php if ($formtype != 'yearly') print('active') ?>">
        <form id="login_form" role="form" method="GET" action="result">
            <input type="hidden" name="formtype" value="monthly">
            <div class="form-group">
                <label>年月</label>
                <input id="monthPick" placeholder="年月" name="date" type="text" value="<?= $date ?>">
            </div>
            <button type="submit" class="btn">決定</button>
        </form>
        <?php if ($record && $formtype == 'monthly'): ?>
            <img src="./test.png" />
            <div class="form-group">
                総客数
                <input value="<?= $record['total_customers'] ?>" type="text">
            </div>
            <div class="form-group">
                技術売上
                <input value="<?= $record['tech_sales'] ?>" type="text">
            </div>
            <div class="form-group">
                商品売上
                <input value="<?= $record['goods_sales'] ?>" type="text">
            </div>
            <div class="form-group">
                他売上
                <input value="<?= $record['other_sales'] ?>" type="text">
            </div>
            <div class="form-group">
                総売上
                <input value="<?= $record['total_sales'] ?>" type="text">
            </div>
        <?php endif; ?>
		</div>
		<div id="panel2" class="tab_panel <?php if ($formtype == 'yearly') print('active') ?>">
            <form id="login_form" role="form" method="GET" action="result">
                <input type="hidden" name="formtype" value="yearly">
                <div class="form-group">
                    <label>年</label>
                    <input placeholder="年" name="date" type="text" value="<?= $date ?>">
                </div>
                <button type="submit" class="btn">決定</button>
            </form>
            <?php if ($record && $formtype == 'yearly'): ?>
                <img src="./test.png" />
                <div class="form-group">
                    総客数
                    <input value="<?= $record['total_customers'] ?>" type="text">
                </div>
                <div class="form-group">
                    技術売上
                    <input value="<?= $record['tech_sales'] ?>" type="text">
                </div>
                <div class="form-group">
                    商品売上
                    <input value="<?= $record['goods_sales'] ?>" type="text">
                </div>
                <div class="form-group">
                    他売上
                    <input value="<?= $record['other_sales'] ?>" type="text">
                </div>
                <div class="form-group">
                    総売上
                    <input value="<?= $record['total_sales'] ?>" type="text">
                </div>
            <?php endif; ?>
		</div>
	</div>
</div>


</div>
</body>

<style>
    .tab_wrap{width:500px; margin:80px auto;}
    .tab_area{font-size:0; margin:0 10px;}
    .tab_area label{width:230px; margin:0 5px; display:inline-block; padding:12px 0; color:#999; background:#ddd; text-align:center; font-size:13px; cursor:pointer; transition:ease 0.2s opacity;}
    .tab_area label:hover{opacity:0.5;}
    .panel_area{background:#fff;}
    .tab_panel{width:100%; padding:80px 0; display:none;}
    .tab_panel p{font-size:14px; letter-spacing:1px; text-align:center;}
    
    .tab_area label.active{background:#aaa; color:#000;}
    .tab_panel.active{display:block;}
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

    $(".tab1_label").on("click",function(){
        var $th = $(this).index();
        $(".tab2_label").removeClass("active");
        $(".tab_panel").removeClass("active");
        $(this).addClass("active");
        $(".tab_panel").eq($th).addClass("active");
    });
    $(".tab2_label").on("click",function(){
        var $th = $(this).index();
        $(".tab1_label").removeClass("active");
        $(".tab_panel").removeClass("active");
        $(this).addClass("active");
        $(".tab_panel").eq($th).addClass("active");
    });
});
</script>
</html>