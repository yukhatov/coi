<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 19.12.16
 * Time: 16:07
 */
$this->title = 'My Yii Application';
?>

<div class="site-index">

    <div class="jumbotron">
        <h1>Hey <?= $user->name . ' ' . $user->surname ?></h1>
        <h3>This is your cabinet</h3>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                        <h2>Username:</h2>
                        <p><?= $user->username  ?></p>
                        <h2>Name:</h2>
                        <p><?= $user->name . ' ' . $user->surname ?></p>
                        <h2>Birthday:</h2>
                        <p><?= $user->birthday ?></p>
                        <p><a class="btn btn-default" href="index.php?r=user/edit">Edit &raquo;</a></p>
                </div>

            </div>
        </div>
    </div>
</div>
</div>