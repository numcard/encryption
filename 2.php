<h1>Квадрат полибия</h1>
<form method="get" action="">
    <p>
        <label for="text">Текст
            <textarea name="text" id="text" cols="30" rows="10"><?php if(isset($_GET['text'])) echo $_GET['text']; ?></textarea>
        </label>
    </p>
    <input type="submit">
</form>

<?php
if(empty($_GET)) die();
$alphabet = [' ', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
$matrix = [];

getMatrix($alphabet, $matrix);
$text = $_GET['text'];
encryption($matrix, $text);

function getMatrix($alphabet, &$matrix){
    shuffle($alphabet);
    $n = rand(4, 9);
    $row = 1;
    $column = 1;
    foreach($alphabet as $key => $symbol){
        $matrix[$column][$row] = $symbol;
        if($row == $n){
            $column++;
            $row = 0;
        }
        $row++;
    }
}

function encryption($matrix, $text){
    $newText = "";
    for($i = 0; $i < strlen($text); $i++){
        foreach($matrix as $keyRow => $rows){
            foreach($rows as $keyEl => $el){
                if($el == $text[$i]){
                    $newText .= $keyRow.$keyEl;
                }
            }
        }
    }
    $text = $newText;
    echo "Зашифрованный текст: " . $newText . "<br>";
}