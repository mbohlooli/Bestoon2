<?php

function authentication_required(){
    return true;
}

function get_title(){
    return 'ثبت پست';
}

function get_content(){ ?>
    <div class="container">
        <div class="row" style="margin-top:20px">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <form role="form" method="POST">
                    <fieldset>
                        <h2>ثبت پست</h2>
                        <hr class="colorgraph">
                        <div class="form-group">
                            <input type="text" name="title" id="title" class="form-control input-lg" placeholder="عنوان">
                        </div>
                        <div class="form-group">
                            <textarea name="content" id="content" class="form-control" cols="30" rows="10" placeholder="محتوا"></textarea>
                        </div>
                        <hr class="colorgraph">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="1">ثبت</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
<?php }

function process_inputs(){
    if(isset($_POST['submit'])){
        if(!isset($_POST['title']) || !$_POST['title']){
            add_message('لطفا موضوعی برای پست خود وارد کنید.');
            return;
        }
        if(!isset($_POST['content']) || !$_POST['content']){
            add_message('لطفا محتوایی برای پست خود وارد کنید.');
            return;
        }
        $post = new Post();
        $post->title = secure_data($_POST['title']);
        $post->content = secure_data($_POST['content']);
        $post->save();
        redirect_to(home_url());
    }
}