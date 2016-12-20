<?php
/**
 * Created by PhpStorm.
 * User: artur
 * Date: 19.12.16
 * Time: 15:46
 */
$this->title = 'My Yii Application';
?>

<div class="site-index">

    <div class="jumbotron">
        <h1>Hey <?= $user->name . ' ' . $user->surname ?></h1>
        <p><a class="btn btn-default" href="index.php?r=user/cabinet">Cabinet &raquo;</a></p>
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
                            </theader>';

                            foreach ($users as $user)
                            {
                                echo'<tr>';
                                echo'<td>' . $user->username . '</td>';
                                echo'<td>' . $user->name . ' ' . $user->surname . '</td>';
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