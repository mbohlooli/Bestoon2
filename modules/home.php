<?php

function get_title(){
    return 'خانه';
}

function get_content(){ ?>

    <div class="jumbotron">
        <h2>اخبار</h2>
        <br>
        <p class="lead">پروژه بستون یک برنامه ساده است که برای داشتن دخل و خرج شخصی درست شده است.<br>نسخه اوّلیه این پروژه در ماه رمضان 1396 به پایان رسید و در حال حاضر نسخه تکمیلی آن در حال بازنویسی است.</p>
        <br>
        <p class="lead">نسخه اوّلیه پروژه بستون در حال حاضر در گیت هاب: </p>
        <p><a class="btn btn-lg btn-success" href="http://github.com/mbohlooli/bestoon"><i class="fa fa-github" style="font-size: 30px;"></i>&nbsp;&nbsp;گیت هاب</a></p>
    </div>

    <div class="row marketing">
        <?php Post::show_all() ?>
    </div>


<?php }