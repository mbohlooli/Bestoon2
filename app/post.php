<?php


class Post extends Database_object
{
    protected static $table_name = 'posts';
    protected static $db_fields = array('id', 'title', 'content', 'user_id');
    public $id, $title, $content, $user_id;

    public function __construct()
    {
        global $current_user;
        global $session;
        $this->id = $this->insert_id()+1;
        if($session->is_logged_in())
        {
            $this->user_id = $current_user->id;
        }
    }

    public static function show_all()
    {
        global $session;
        global $current_user;
        $posts = self::find_all();

        if(empty($posts)){
            echo "
                <div class='alert bg-warning'>
                    هنوز پستی ثبت نشده است.
                </div>
            ";
            return;
        }

        $n = count($posts);

        for($i = $n-1 ; $i>=0; $i--) { ?>

                <?php if($i == 0 && $n%2 != 0): ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div align="center">
                            <h2><?= $posts[$i]['title'] ?></h2>
                            <p><?= $posts[$i]['content'] ?></p>
                            <?php if($session->is_logged_in()): ?>
                                <a class="btn btn-outline-primary" style="margin-left: 10px;">ویرایش</a>
                                <a class="btn btn-outline-danger">حذف</a>
                            <?php endif ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h2><?= $posts[$i]['title'] ?></h2>
                        <p><?= $posts[$i]['content'] ?></p>
                        <?php if($session->is_logged_in() && $current_user->has_privilege(2)): ?>
                            <a class="btn btn-outline-primary" style="margin-left: 10px;">ویرایش</a>
                            <a class="btn btn-outline-danger">حذف</a>
                        <?php endif ?>
                    </div>
                <?php endif ?>
        <?php
        }
    }
}