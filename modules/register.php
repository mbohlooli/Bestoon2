<?php

function get_title(){
    return 'ثبت نام';
}

function get_content(){ ?>
    <div class="container">
	<div class="row" style="margin-top:20px">
	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="POST">
				<fieldset>
					<h2>ثبت نام</h2>
					<hr class="colorgraph">
					<div class="form-group">
	                    <input type="text" name="username" id="username" class="form-control input-lg" placeholder="نام کاربری">
					</div>
                        <div class="form-group">
                            <input type="text" name="first_name" id="first_name" class="form-control input-lg" placeholder="نام">
                        </div>
                        <div class="form-group">
                            <input type="text" name="last_name" id="last_name" class="form-control input-lg" placeholder="نام خانوادگی">
                        </div>
					<div class="form-group">
						<input type="text" name="email" id="email" class="form-control input-lg" placeholder="ایمیل">
					</div>
					<div class="form-group">
					    <div class="input-group">
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="رمز عبور">
							<div class="input-group-addon" id="see_pass" style="cursor: pointer;" title="مشاهده رمز"><span class="glyphicon glyphicon-eye-open"></span></div>      	
						   </div>
					</div>
					<div class="form-group">
						<input type="password" name="re-password" id="re-password" class="form-control input-lg" placeholder="رمز عبور تکرار">
					</div>
					<hr class="colorgraph">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<button type="submit" class="btn btn-lg btn-primary btn-block" name="submit" value="1">ثبت</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<script src="<?php echo APP_URL ?>resources/assets/jQuery/jquery.min.js"></script>
<script>
	$('#see_pass').mouseenter(function(){
		$('#password').attr("type", "text");
	});
	$('#see_pass').mouseleave(function(){
		$('#password').attr("type", "password");
	});
</script>
<?php }

function process_inputs(){
	if(isset($_POST['submit']))
    {
		// Checking if the variables are entered
		if(!isset($_POST['username']) || !$_POST['username'])
		{
			add_message('لطفا نام کاربری خود را وارد کنید.');
			return;
		}
		elseif (!isset($_POST['first_name']) || !$_POST['first_name'])
        {
            add_message('لطفا نام خود را وارد کنید');
            return;
        }
        elseif (!isset($_POST['last_name']) || !$_POST['last_name'])
        {
            add_message('لطفا نام خانودگی خود را وارد کنید.');
            return;
        }
		elseif(!isset($_POST['email']) || !$_POST['email'])
		{
			add_message('لطفا ایمیل خود را وارد کنید.');
			return ;
		}
		elseif(!isset($_POST['password']) || !$_POST['password'])
		{
			add_message('لطفا رمز عبور خود را وارد کنید.');
			return;
		}
		elseif(!isset($_POST['re-password']) || !$_POST['re-password'])
		{
			add_message('لطفا تکرار رمز عبور را وارد کنید');
			return;
		}

		// Checks if some variables are correctly entered
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
		    add_message('لطفا بک ایمیل صحیح وارد کنید.');
            return;
        }
        elseif ($_POST['password'] != $_POST['re-password'])
        {
            add_message('تکرار رمز عبور با رمز اصلی مطابقت ندارد.');
            return;
        }
        
        global $db;
        
		$new_user = new User();
		$new_user->username = $db->escape_value_both($_POST['username']);
        $new_user->first_name = $db->escape_value_both($_POST['first_name']);
        $new_user->last_name = $db->escape_value_both($_POST['last_name']);
        $new_user->password = generate_hash($_POST['password']);
        $new_user->email = $db->escape_value_both($_POST['email']);
        $new_user->last_access = date("Y-m-d H:i:s");
        $new_user->created_at = date("Y-m-d H:i:s");
        $new_user->updated_at = "00-00-00 00:00:00";

        $new_user->save();

        redirect_to(home_url('home'));
	}
}