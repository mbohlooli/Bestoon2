<?php

function get_title(){
    return 'ثبت درآمد';
}

function authentication_required(){
    return true;
}

function get_content(){ ?>
    <div class="container">
        <div class="row" style="margin-top:20px">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <form role="form" method="POST">
                    <fieldset>
                        <h2>ثبت درآمد</h2>
                        <hr class="colorgraph">
                        <div class="form-group">
                            <input type="text" name="title" id="title" class="form-control input-lg" placeholder="موضوع">
                        </div>
                        <div class="form-group">
                            <input type="text" name="date" id="date" class="form-control input-lg" placeholder="تاریخ درآمد">
                        </div>
                        <div class="form-group">
                            <?php Income_category::show_combobx() ?>
                        </div>
                        <div class="form-group">
                            <input type="text" name="amount" id="amount" class="form-control input-lg" placeholder="میزان درآمد به تومان">
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
    <script>
        kamaDatepicker('date', {
            nextButtonIcon: "<?php echo APP_URL ?>resources/assets/images/timeir_next.png"
            , previousButtonIcon: "<?php echo APP_URL ?>resources/assets/images/timeir_prev.png"
            , forceFarsiDigits: true
            , markToday: true
            , markHolidays: true
            , highlightSelectedDay: true
            , sync: true
            , gotoToday: true
        });
    </script>
<?php }

function process_inputs(){
    if(isset($_POST['submit'])){
        if(!isset($_POST['title']) || !$_POST['title']){
            add_message('لطفا موضوعی برای درآمد خود پیدا کنید.');
            return;
        }
        if(!isset($_POST['date']) || !$_POST['date']){
            add_message('لطفا تاریخ را وارد کنید.');
            return;
        }
        if(!isset($_POST['category']) || !$_POST['category']){
            add_message('لطفا دسته مورد نظر خود را انتخاب کنید.');
            return;
        }
        if(!isset($_POST['amount']) || !$_POST['amount']){
            add_message('لطفا مقداری برای درآمد خود وارد کنید.');
            return;
        }
        if(!is_numeric($_POST['amount'])){
            add_message('میزان درآمد باید یک عدد باشد.');
            return;
        }
        $income = new Income();
        $income->title = $_POST['title'];
        $income->amount = $_POST['amount'];
        $income->date = str_replace("/", "-", $_POST['date']);
        $income->cat_id = $_POST['category'];
        $income->save();
        redirect_to(home_url('dashboard'));
    }
}