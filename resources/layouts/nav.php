<div class="header clearfix" style="margin-bottom: 20px;">
    <h3 class="text-muted"><?php echo APP_TITLE ?></h3>
    <br>
    <nav>
        <?php global $module ?>
        <ul class="nav nav-pills pull-left">
            <li role="presentation" class="<?php echo $module == 'home' ? 'active' : null ?>"><a href="<?php APP_URL ?>home">خانه</a></li>
            <li role="presentation" class="<?php echo $module == 'about' ? 'active' : null ?>"><a href="<?php echo APP_URL ?>about">درباره ما</a></li>
            <li role="presentation"><a href="#">تماس با ما</a></li>
        </ul>
        <ul class="nav nav-pills pull-right">
            <?php global $session; ?>
            <?php if($session->is_logged_in()): ?>
                <li role="presentation"><a href="<?php echo APP_URL ?>logout">خروج</a></li>
            <?php else: ?>
                <li role="presentation" class="<?php echo $module == 'login' ? 'active' : null ?>" ><a href="<?php echo APP_URL ?>login">ورود</a></li>
                <li role="presentation" class="<?php echo $module == 'register' ? 'active' : null ?>" ><a href="<?php echo APP_URL ?>register">ثبت نام</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>