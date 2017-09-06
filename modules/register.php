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
						<input type="email" name="email" id="email" class="form-control input-lg" placeholder="ایمیل">
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
	$("#see_pass").mouseenter(function(){		
		$("#password").attr("type", "text");
	});
	$("#see_pass").mouseleave(function(){		
		$("#password").attr("type", "password");
	});
</script>
<?php }

function process_inputs(){
	if(isset($_POST['submit'])){
		print_var($_POST);
	}
}