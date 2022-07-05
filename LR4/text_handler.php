<?php

$html = $_POST['text'];

$dom = new \DOMDocument();                                                 // task 1
$dom->loadHTML('<div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

$task_1_1 = $dom->getElementsByTagName('h1');
$task_1_2 = $dom->getElementsByTagName('h2');
foreach ($$task_1_1 as $h1) {
    echo $h1->nodeValue, PHP_EOL;
    foreach ($$task_1_2 as $h2) {
        echo $h2->nodeValue, PHP_EOL;
    }
}

$task_7 = preg_replace('/!{4,}/u','!!!', $html);        // task 7
$task_7 = preg_replace('/.{4,}/u','…', $html);
$task_7 = preg_replace('/\?{4,}/u','???', $html);


$task_11 = stripslashes($html);                                         // task 11
preg_match_all("/<h1.*?>(.*?)<\/h1>/i", $task_11, $h1);
preg_match_all("/<h2.*?>(.*?)<\/h2>/i", $task_11, $h2);
preg_match_all("/<h3.*?>(.*?)<\/h3>/i", $task_11, $h3);

if (!empty($h1[1])) {
    ?>
    <div class="texts-list">
        <h3>Содержание</h3>
        <ol>
            <?php
            foreach ($h1[1] as $i => $row) {
                echo '<li><a href="#tag-' . ++$i . '">' . $row . '</a></li>';

                if (!empty($h2[1])) {
                    foreach ($h2[1] as $i => $row) {
                        echo '<li><a href="#tag-' . ++$i . '">' . $row . '</a></li>';

                        if (!empty($h3[1])) {
                            foreach ($h3[1] as $i => $row) {
                                echo '<li><a href="#tag-' . ++$i . '">' . $row . '</a></li>';
                            }
                    }
                }
            }


            ?>
        </ol>
    </div>
    <?php
}

if (!empty($h1[0])) {
    foreach ($h1[0] as $i => $row) {
        $task_11 = str_replace($row, '<a name="tag-' . ++$i . '"></a>' . $row, $task_11);
    }
}
if (!empty($h2[0])) {
    foreach ($h2[0] as $i => $row) {
        $task_11 = str_replace($row, '<a name="tag-' . ++$i . '"></a>' . $row, $task_11);
    }
}
if (!empty($h2[0])) {
    foreach ($h2[0] as $i => $row) {
        $task_11 = str_replace($row, '<a name="tag-' . ++$i . '"></a>' . $row, $task_11);
    }
}
echo $task_11;
    ?>


<div class="container">
    <form class="m-5" action="text_handler.php" method="POST">
        <label class="form-label">Введите текст</label>
        <textarea class="form-control" type="text" name="text"></textarea>
        <button class="btn btn-primary mt-2">Отправить</button>
    </form>
</div>


    <?php
$array = array('пух', 'рот', 'делать', 'ехать', 'около', 'для');        // task 16
$task_16 = strtolower($html);
for($i = 0; $i < count($array); $i++)
{
    $res = @substr_count($task_16 , $array[$i]);
    if($res == true){
        $task_16 = str_replace($array[$i],'###', $html);
        $task_16 = preg_replace('/[^\s](?!)*$array[^\s]*/u','!!!', $html);
    }
}
}

