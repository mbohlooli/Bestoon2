<div class="header clearfix">
    <h3 class="text-muted"><?php echo APP_TITLE ?></h3>
    <br>
    <nav>
        <?php global $module ?>
        <ul class="nav nav-pills pull-left">
            <li role="presentation" class="<?php echo $module == 'home' ? 'active' : null ?>"><a href="<?php APP_URL ?>home">خانه</a></li>
            <li role="presentation"><a href="#">درباره</a></li>
            <li role="presentation"><a href="#">تماس</a></li>
        </ul>
        <ul class="nav nav-pills pull-right">
            <li role="presentation" class="<?php echo $module == 'login' ? 'active' : null ?>" ><a href="<?php echo APP_URL ?>login">ورود</a></li>
            <li role="presentation" class="<?php echo $module == 'register' ? 'active' : null ?>" ><a href="<?php echo APP_URL ?>register">ثبت نام</a></li>
        </ul>
    </nav>
</div>