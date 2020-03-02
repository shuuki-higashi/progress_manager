<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <title>出力</title>
    
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
        <h1 class="subtitle">出力</h1>
        <div class="tab_wrap">
            <div class="tab_area tabs is-toggle is-fullwidth">
                <ul>
                    <li class="tab1_label <?php if ($formtype != 'yearly') print('is-active') ?>"><a><span>月</span></a></li>
                    <li class="tab2_label <?php if ($formtype == 'yearly') print('is-active') ?>"><a><span>年</span></a></li>
                </ul>
            </div>
            <div class="panel_area">
                <div id="panel1" class="tab_panel <?php if ($formtype != 'yearly') print('active') ?>">
                    <form role="form" method="GET" action="result" autocomplete="off">
                        <input type="hidden" name="formtype" value="monthly">
                        <div class="field">
                            <label class="label">年月</label>
                            <div class="control">
                                <input id="monthPick" class="input" type="text" name="date" placeholder="年月" value="<?= $date ?>">
                            </div>
                            <?php if ($record && $goal && $formtype == 'monthly'): ?>
                                <img src="./test.png" />
                                
                                <label class="label">総客数</label>
                                <div class="control">
                                    <input class="input" type="text" name="total_customers" placeholder="総客数" value="<?= $record['total_customers'] ?>">
                                </div>
                                <label class="label">技術売上</label>
                                <div class="control">
                                    <input class="input in" type="text" name="tech_sales" placeholder="技術売上" value="<?= $record['tech_sales'] ?>">
                                </div>
                                <label class="label">商品売上</label>
                                <div class="control">
                                    <input class="input in" type="text" name="goods_sales" placeholder="商品売上" value="<?= $record['goods_sales'] ?>">
                                </div>
                                <label class="label">他売上</label>
                                <div class="control">
                                    <input class="input in" type="text" name="other_sales" placeholder="他売上" value="<?= $record['other_sales'] ?>">
                                </div>
                                <label class="label">総売上</label>
                                <div class="control">
                                    <input class="input out" type="text" name="total_sales" placeholder="総売上" value="<?= $record['total_sales'] ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="subbutton">
                            <button type="submit" class="button">適用</button>
                        </div>
                    </form>  
                </div>
                <div id="panel2" class="tab_panel <?php if ($formtype == 'yearly') print('active') ?>">
                    <form role="form" method="GET" action="result" autocomplete="off">
                        <input type="hidden" name="formtype" value="yearly">
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
                            <?php if ($record && $goal && $formtype == 'yearly'): ?>
                                <img src="./test.png" />
                                <label class="label">総客数</label>
                                <div class="control">
                                    <input class="input" type="text" name="total_customers" placeholder="総客数" value="<?= $record['total_customers'] ?>">
                                </div>
                                <label class="label">技術売上</label>
                                <div class="control">
                                    <input class="input in" type="text" name="tech_sales" placeholder="技術売上" value="<?= $record['tech_sales'] ?>">
                                </div>
                                <label class="label">商品売上</label>
                                <div class="control">
                                    <input class="input in" type="text" name="goods_sales" placeholder="商品売上" value="<?= $record['goods_sales'] ?>">
                                </div>
                                <label class="label">他売上</label>
                                <div class="control">
                                    <input class="input in" type="text" name="other_sales" placeholder="他売上" value="<?= $record['other_sales'] ?>">
                                </div>
                                <label class="label">総売上</label>
                                <div class="control">
                                    <input class="input out" type="text" name="total_sales" placeholder="総売上" value="<?= $record['total_sales'] ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="subbutton">
                            <button type="submit" class="button">適用</button>
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
});
</script>
</html>