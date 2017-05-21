<h1>Метод Виженера</h1>
<form method="get" action="">
    <p>
        <label for="secretWord">Секретное слово
            <input id="secretWord" type="text" name="secretWord" value="<?php if(isset($_GET['secretWord'])) echo $_GET['secretWord'];  ?>">
        </label>
    </p>
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

function helpMe($position, $alphabet){
    $arr = [];
    for($i = $position; $i < count($alphabet); $i++){
        $arr[] = $alphabet[$i];
    }
    for($i = 0; $i < $position; $i++){
        $arr[] = $alphabet[$i];
    }
    return $arr;
}

foreach($alphabet as $key => $symbol){
    $matrix[$symbol] = helpMe($key, $alphabet);
}

$secretWord = $_GET['secretWord'];
$text = $_GET['text'];
$newSecretWord = '';

for($i = 0; $i < strlen($text); $i++){
    $key = $i % strlen($secretWord);
    $newSecretWord .= $secretWord[$key];
    $symbol = $newSecretWord[$i];
    foreach($alphabet as $key => $one){
        if($text[$i] == $one){
            $text[$i] = $matrix[$symbol][$key];
            break;
        }
    }
}

echo "Зашифрованный текст: " . $text . "<br>";