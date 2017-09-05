<?php

function deny_nav(){}
function deny_footer(){}

function get_title(){
    return 'صفحه مورد نظر یافت نشد';
}

function get_content(){ ?>
    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" align="center">
            <img src="<?php echo APP_URL ?>resources/assets/images/404.png" alt="404" class="img-thumbnail">
            <br>
            <br>
            <h3>متأسفانه صفحه مورد نظر شما یافت نشد.</h3>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
    </div>
    <br><br>
    <footer class="footer" style="direction: ltr !important;">
        <a class="btn btn-link" href="<?php echo APP_URL ?>home">برگشت به خانه</a>
    </footer>
<?php }