<?php

function get_title(){
    return 'ورود به برنامه';
}

function get_content(){ ?>

<div class="container">
	<div class="row" style="margin-top:20px">
	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="POST">
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
	                        <button type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="1">ورود</button>
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

function process_inputs(){
	global $db;
	global $session;
	if(isset($_POST['submit'])){
		if(!$_POST['username']){
			add_message('نام کاربری نمی تواند خالی باشد.');
			return ;
		} elseif(!$_POST['password']){
			add_message('رمز عبور نمی توان خالی باشد');
			return;
		}

		if(!User::row_exists('username', $db->escape_value_both($_POST['username']))){
			add_message('این کاربر در سیستم موجود نمی باشد.');
			return;
		}
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$found_user = User::authenticate($username, $password);
		if($found_user) {
			$user_object = User::find_by_sql("SELECT * FROM users WHERE username = '{$username}' LIMIT 1;", false);
			/*
			if($user_object[0]->privilege == 'disable'){
				add_message('این کاربر مسدود شده است.', 'warning');
				return;
			}
			*/
			$session->login($user_object);
			return;
		} else {
			add_message('رمز عبور وارد شده صحیح نمی باشد.');
		}
	}
}