<?php

function authentication_required(){
    return true;
}

function get_title(){
    return 'ویرایش';
}

function get_content(){ ?>
    <?php global $obj ?>
    <form role="form" method="POST">
        <fieldset>
            <h2>ویرایش <?php echo $_GET['name'] == 'income' ? 'درآمد' : 'خرج' ?></h2>
            <hr class="colorgraph">
            <div class="form-group">
                <input type="text" name="title" id="title" class="form-control input-lg" placeholder="موضوع" value="<?php echo $obj->title ?>">
            </div>
            <div class="form-group">
                <input type="text" name="date" id="date" class="form-control input-lg" placeholder="تاریخ درآمد" value="<?php echo $obj->date ?>">
            </div>
            <div class="form-group">
                <?php $obj->show_combobx() ?>
            </div>
            <div class="form-group">
                <input type="text" name="amount" id="amount" class="form-control input-lg" placeholder="میزان درآمد به تومان" value="<?php echo $obj->amount ?>">
            </div>
            <hr class="colorgraph">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="1">ثبت</button>
                </div>
            </div>
        </fieldset>
    </form>
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
    global $obj;
    if(!isset($_GET['id']) || !$_GET['id'] || !isset($_GET['name']) || !$_GET['name']){
        redirect_to(home_url('404'));
    }

    switch($_GET['name'])
    {
        case 'income':
            if(!Income::row_exists('id', $_GET['id'])){
                redirect_to(home_url('404'));
            }
            $obj = Income::find_by_id($_GET['id']);
            break;
        case 'expense':
            if(!Expense::row_exists('id', $_GET['id'])){
                redirect_to(home_url('404'));
            }
            $obj = Expense::find_by_id($_GET['id']);
            break;
        default:
            redirect_to(home_url('404'));
            break;
    }
    if(isset($_POST['submit'])){

        $obj->title = secure_data($_POST['title']);
        $obj->date = secure_data($_POST['date']);
        $obj->cat_id = secure_data($_POST['category']);
        $obj->amount = secure_data($_POST['amount']);
        $obj->save();
        redirect_to(home_url('dashboard'));
    }
}