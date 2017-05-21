<h1>Метод Цезаря с ключевым словом</h1>
<form method="get" action="">
    <p>
        <label for="shift">Введите сдвиг
            <input id="shift" type="number" name="shift" value="<?php if(isset($_GET['shift'])) echo $_GET['shift'];  ?>">
        </label>
    </p>
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

// Мы имеем два алфавита
$alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
$decodingAlphabet = $alphabet;
$shift = $_GET['shift'];
$secretWord = $_GET['secretWord'];
$text = $_GET['text'];

// Сдвигаем
shift($decodingAlphabet, $shift);

// Вставляем слово
wordInput($decodingAlphabet, $shift, $secretWord); // вставляем ключевое слово

// Шифруем и выводим
encryption($text, $alphabet, $decodingAlphabet);

// Выводим моду (самую часто встреч. букву)
$moda = moda($text);
echo "Самая часто употребляемая буква: ";
foreach($moda as $key => $one)
    echo $key . " - " . $one . " раз(a)";

// Выводим алфавит
function printAlphabet($array){
    echo "<pre>";
    foreach ($array as $item) {
        echo $item . " ";
    }
    echo "</pre>";
}

// Функция сдвига алфавита
function shift(&$alphabet, $shift){
    // Делаем сдвиг
    $temp = [];
    for($i = $shift; $i < count($alphabet); $i++){
        $temp[] = $alphabet[$i];
    }
    for($i = 0; $i < $shift; $i++){
        $temp[] = $alphabet[$i];
    }
    $alphabet = $temp;
}

// Функция добавления слова в алфавит
function wordInput(&$decodingAlphabet, $shift, $keyWord){
    $temp = [];
    // Удаляем повторяющиеся буквы
    for($i = 0; $i < strlen($keyWord); $i++){
        $symbol = $keyWord[$i];
        foreach($decodingAlphabet as $key => $one){
            if($symbol == $one){
                unset($decodingAlphabet[$key]);
                break;
            }
        }
    }
    reset($decodingAlphabet);
    // Собираем зашифрованный алфавит
    for($i = 0; $i < $shift; $i++){
        $temp[] = current($decodingAlphabet);
        next($decodingAlphabet);
    }
    for($i = 0; $i < strlen($keyWord); $i++){
        $temp[] = $keyWord[$i];
    }
    for($i = $shift; $i < count($decodingAlphabet); $i++){
        $temp[] = current($decodingAlphabet);
        next($decodingAlphabet);
    }
    // Записываем
    $decodingAlphabet = $temp;
}

// Функция шифрования с выводом
function encryption($text, $alphabet, $decodingAlphabet){
    echo "Исходный текст: " . $text . "<br>";

    for($i = 0; $i < strlen($text); $i++){
        if($text[$i] == ' ')
            continue;
        else {
            for($j = 0; $j < count($alphabet); $j++){
                if($text[$i] == $alphabet[$j]){
                    //echo "Changed " . $text[$i] . " to " . $decodingAlphabet[$j] . "<br>";
                    $text[$i] = $decodingAlphabet[$j];
                    break;
                }
            }
        }
    }
    echo "Зашифрованный текст: " . $text . "<br>";
}

// Функция вычисления моды $text
function moda($text)
{
    $array = [];
    for ($i = 0; $i < strlen($text); $i++) {
        if ($text[$i] == ' ') continue;
        $array[] = $text[$i];
    }

    $array = array_unique($array);
    $arr = [];
    $key = 0;
    foreach ($array as $item) {
        $key++;
        for ($i = 0; $i < strlen($text); $i++) {
            if($text[$i] == ' ') continue;
            if($item == $text[$i]){
                $arr[$key][$item] += 1;
            }
        }
    }
    $maximum = [];
    foreach($arr as $item){
        if(empty($maximum)){
            $maximum = $item;
            continue;
        }
        if(current($maximum) < current($item))
            $maximum = $item;
    }
    return $maximum;
}