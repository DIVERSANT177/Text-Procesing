<?php

require_once ('header.php');
require_once ('textLogic.php');
?>

<div class="text-center">
    <form method="POST">
        <p class="">
            <textarea name="text" class="" cols="30" rows="10"><?=$textAnalyze->textBody?></textarea>
        </p>
        <p>
            <input type="submit" class="submitText">
        </p>
    </form>
</div>

<div class="container-fluid">
    <p>Задание 1</p>
    <div>
        <?=$textAnalyze->Task1()?>
    </div>

    <p>Задание 7</p>
    <div>
        <?=$textAnalyze->Task7()?>
    </div>

    <p>Задание 16</p>
    <div>
        <?=$textAnalyze->Task16()?>
    </div>

    <p>Задание 11</p>
    <div>
        <?=$textAnalyze->Task11()?>
    </div>



    <div>
        <?=$textAnalyze->viewText()?>
    </div>
</div>



<?php
require_once ('footer.php');
?>