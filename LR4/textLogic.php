<?php
error_reporting(0);
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);

$preset1 = "https://ru.wikipedia.org/wiki/%D0%9A%D0%B8%D0%BD%D0%BE%D1%80%D0%B8%D0%BD%D1%85%D0%B8";
$preset2 = "https://echo.msk.ru/programs/sorokina/2917870-echo/";
$preset3 = "https://mishka-knizhka.ru/skazki-dlay-detey/zarubezhnye-skazochniki/skazki-alana-milna/vinni-puh-i-vse-vse-vse/#glava-pervaya-v-kotoroj-my-znakomimsya-s-vinni-puhom-i-neskolkimi-pchy";

if ($_GET["preset"]) {
    if ($_GET["preset"] == "1") {
        $text = file_get_contents($preset1, false, stream_context_create($arrContextOptions));
    }
    elseif ($_GET["preset"] == "2") {
        $text = file_get_contents($preset2, false, stream_context_create($arrContextOptions));
    }
    elseif ($_GET["preset"] == "3") {
        $text = file_get_contents($preset3, false, stream_context_create($arrContextOptions));
    }
    else {
        $text = $_POST["text"];
    }
    $textAnalyze = new TextAnalyze($text);
}
else {
    if ($_POST["text"]) {
        $text = $_POST["text"];
    }
    $textAnalyze = new TextAnalyze($text);
}
if ($_POST["text"])
{
    $textAnalyze = new TextAnalyze($text);
}

class TextAnalyze{
    public $textBody;

    public function __construct($text){
        $this->textBody = $text;
    }

    public function viewText(){
        echo $this->textBody;
    }

    public function Task1(){
        $i = 0;
        $numlist = '<ol class = "ollist">';
        $checktext = preg_match_all('#\s?<h[12][^>]*>(.*?)</h[12][^>]*>\s?#', $this->textBody,$matches,PREG_SET_ORDER);
        if ($checktext) {
            $checkerh2 = false;
            if(strpos($matches[0][0], "h2")){
                $checkerh2 = true;
            }
            while($matches[$i][0]){
                if (strpos($matches[$i][0], "h1") && $matches[$i + 1][0]) {
                    $numlist = $numlist . '<li class = "lilist">';
                    if (!strpos($matches[$i + 1][0], "h1")) {
                        $numlist = $numlist . $matches[$i][1] . '<ol class="ollist">';
                    } else {
                        $numlist = $numlist . $matches[$i][1] . '</li>';
                    }
                } elseif (strpos($matches[$i][0], "h2") && $matches[$i + 1][0]) {
                    $numlist = $numlist . '<li class = "lilist">';
                    if (!strpos($matches[$i + 1][0], "h2")&&$checkerh2==false) {
                        $numlist = $numlist . $matches[$i][1] . '</li></ol></li>';
                    }elseif(!strpos($matches[$i + 1][0], "h2")&&$checkerh2==true){
                        $numlist = $numlist . $matches[$i][1] . '</li></ol><ol class = "ollist">';
                        $checkerh2 == false;
                    }
                    else {
                        $numlist = $numlist . $matches[$i][1] . '</li>';
                    }
                }
                elseif(!$matches[1][0]){
                    $numlist = $numlist . '<li class = "lilist">'. $matches[0][1].'</li></ol>';}
                elseif(strpos($matches[$i][0], "h2") && !$matches[$i + 1][0] && $checkerh2 == false){
                    $numlist = $numlist .'<li class = "lilist">'.$matches[$i][1].'</li></ol></li></ol>';
                }
                elseif(strpos($matches[$i][0], "h2") && !$matches[$i + 1][0] && $checkerh2 == true){
                    $numlist = $numlist .'<li class = "lilist">'.$matches[$i][1].'</li></ol>';
                }
                elseif(strpos($matches[$i][0], "h1") && !$matches[$i + 1][0]){
                    $numlist = $numlist .'<li class = "lilist">'.$matches[$i][1].'</li></ol>';
                }
                $i++;
            }
            return $numlist;
        } else {
            return 0;
        }
    }

    public function Task7(){
        $this->textBody = preg_replace("/\!{4,}/", "!!!", $this->textBody);
        $this->textBody = preg_replace("/\?{4,}/", "???", $this->textBody);
        $this->textBody = preg_replace("/\.{4,}/", "...", $this->textBody);
    }

    public function  Task11(){
        $dom = new DOMDocument();
        $page = $dom->loadHTML($this->textBody);
        $headers1 = $dom->getElementsByTagName('h1');
        $headers2 = $dom->getElementsByTagName('h2');
        $headers3 = $dom->getElementsByTagName('h3');
        $a=0;$b=0;$c=0;

        $pattern = '#\s?<h[123][^>]*>(.*?)</h[123][^>]*>\s?#';
        preg_match_all($pattern, $this->textBody, $matches);
        $pattern1 = '#\s?<h[1][^>]*>(.*?)</h[1][^>]*>\s?#';
        $pattern2 = '#\s?<h[2][^>]*>(.*?)</h[2][^>]*>\s?#';
        $pattern3 = '#\s?<h[3][^>]*>(.*?)</h[3][^>]*>\s?#';
        echo "<ul>";
        foreach($matches as $item){
            for($i=0;$i<count($item);$i++){
                if(preg_match($pattern1, $item[$i])){
                    echo "<li><a href='#ref-". $i ."'>" . $item[$i] . "</a></li>";
                    $headers1[$a]->removeAttribute('id');
                    $headers1[$a]->setAttribute('id', "ref-$i");
                    $a++;
                } else if(preg_match($pattern2, $item[$i])){
                    echo "<ul><li><a href='#ref-". $i ."'>" . $item[$i] . "</a></li></ul>";
                    $headers2[$b]->removeAttribute('id');
                    $headers2[$b]->setAttribute('id', "ref-$i");
                    $b++;
                } else if(preg_match($pattern3, $item[$i])) {
                    echo "<ul><ul><li><a href='#ref-". $i ."'>" . $item[$i] . "</a></li></ul></ul>";
                    $headers3[$c]->removeAttribute('id');
                    $headers3[$c]->setAttribute('id', "ref-$i");
                    $c++;
                }
            }
        }
        echo "</ul>";
        $this->textBody = $dom->saveHTML();
    }

    public function Task16(){
        $this->textBody = " " . $this->textBody;
        $this->textBody = preg_replace("/\s[п][у][х]/u", " ###", $this->textBody);
        $this->textBody = preg_replace("/\s[р][о][т]/ui", " ###", $this->textBody);
        $this->textBody = preg_replace("/\s[д][е][л][а][т][ь]/ui", " ######", $this->textBody);
        $this->textBody = preg_replace("/\s[е][х][а][т][ь]/ui", " #####", $this->textBody);
        $this->textBody = preg_replace("/\s[о][к][о][л][о]/ui", " #####", $this->textBody);
        $this->textBody = preg_replace("/\s[д][л][я]/ui", " ###", $this->textBody);

    }
}