<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 19.12.16
 * Time: 15:46
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';
?>

<div class="site-index">

    <div class="jumbotron">
        <h1>Hey Admin <?= $user->name . ' ' . $user->surname ?></h1>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-6">
                <?php
                echo'<div class="panel panel-default">
                        <div class="panel-heading">Users:</div>
                        <table class="table table-bordered table-hover">
                            <theader class="center">
                                <th>Username</th>
                                <th>Name</th>
                                <th>Action</th>
                            </theader>';

                foreach ($users as $user)
                {
                    echo'<tr>';
                    echo'<td>' . $user->username . '</td>';
                    echo'<td>' . $user->name . ' ' . $user->surname . '</td>';
                    echo'<td><a class="btn btn-info col-lg-12" href="index.php?r=admin/edituser&id=' . $user->getId() . '">Edit</a></td>';
                    echo'</tr>';
                }
                echo '</table>
                </div>';
                ?>
            </div>
        </div>
    </div>
</div>
</div>