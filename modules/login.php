<?php

function get_title(){
    return 'ورود به برنامه';
}

function get_content(){ ?>

<div class="container">
	<div class="row" style="margin-top:20px">
	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form">
				<fieldset>
					<h2>لطفاً وارد شوید</h2>
					<hr class="colorgraph">
					<div class="form-group">
	                    <input type="text" name="username" id="username" class="form-control input-lg" placeholder="نام کاربری">
					</div>
					<div class="form-group">
	                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="رمز عبور">
					</div>
					<span class="button-checkbox">
	                    <label class="btn btn-warning">
    						<input type="checkbox" autocomplete="off" name="remember_me" id="remember_me">&nbsp;&nbsp; مرا به خاطر بسپار
  						</label>
						<a href="" class="btn btn-link pull-right">رمز عبور خود را فراموش کرده اید؟</a>
					</span>
					<hr class="colorgraph">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
	                        <input type="submit" class="btn btn-lg btn-success btn-block" value="ورود">
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6">
							<a href="<?php echo APP_URL ?>register" class="btn btn-lg btn-primary btn-block">ثبت نام</a>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<?php }