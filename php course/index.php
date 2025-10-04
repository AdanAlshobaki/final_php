<?php
//question 1
echo "Hello,World!<br>";
//question 2
  $name="adan";
  $age=27;
  $city="amman";
 
  echo $name. $age. $city;
   echo"<br>";
    //question 3
 
function swap($x, $y) {
    return [$y, $x]; 
}
$a = 5;
$b = 8;

[$a, $b] = swap($a, $b);

echo "a = $a, b = $b<br>"; 
//question 4
$a = 3;
$b = 5;
$z = $a + $b;

echo "$a + $b = $z <br>";
//question 5
$a=10;
$b=5;
$product=$a*$b;
echo"product is :$product<br>";

//question 6

$a = 17;
$b = 5;

$remainder = $a % $b;

echo "The remainder of $a divided by $b is: $remainder<br>";
//question 7
$a=60;
$b=80;
$c=88;
$Avg=($a+$b+$c)/3;
echo "avarage is :$Avg<br>";
//question 8

$celsius = 25;

$fahrenheit = ($celsius * 9/5) + 32;

echo "$celsius °C = $fahrenheit °F<br>";
//question 9

$hours = 2;

$minutes = $hours * 60;
$seconds = $hours * 3600;

echo "$hours hour(s) = $minutes minutes = $seconds seconds<br>";
//question 10
$num = 5;
$square = $num * $num;
$cube = $num * $num * $num;

echo "Number: $num<br>";
echo "Square: $square<br>";
echo "Cube: $cube<br>";
//question 11
$num = 7;

if ($num % 2 == 0) {
    echo "$num is Even<br>";
} else {
    echo "$num is Odd<br>";
}
//question 12
$num = -5;

if ($num > 0) {
    echo "$num is Positive<br>";
} elseif ($num < 0) {
    echo "$num is Negative<br>";
} else {
    echo "The number is Zero<br>";
}
//question 13

$a = 100;
$b = 250;
$c = 15;

if ($a >= $b && $a >= $c) {
    $largest = $a;
} elseif ($b >= $a && $b >= $c) {
    $largest = $b;
} else {
    $largest = $c;
}

echo "The largest number is: $largest<br>";
//question 14

$year = 2024;

if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
    echo "$year is a Leap Year<br>";
} else {
    echo "$year isn't a Leap Year<br>";
}
//question 15

$age = 27;

if ($age >= 18) {
    echo "You are eligible to vote<br>";
} else {
    echo "You are not eligible to vote<br>";
}
//question 16
$marks = 82;

if ($marks >= 90) {
    $grade = "A";
} elseif ($marks >= 75) {
    $grade = "B";
} elseif ($marks >= 60) {
    $grade = "C";
} else {
    $grade = "F";
}

echo "Marks: $marks, Grade: $grade<br>";
//question 17
$char = 'a';
$charLower = strtolower($char); 

if ($charLower == 'a' || $charLower == 'e' || $charLower == 'i' || $charLower == 'o' || $charLower == 'u') {
    echo "$char is a Vowel<br>";
} else {
    echo "$char is a Consonant<br>";
}
//question 18

$day = 4;

switch ($day) {
    case 1:
        echo "Sunday";
        break;
    case 2:
        echo "Monday";
        break;
    case 3:
        echo "Tuesday";
        break;
    case 4:
        echo "Wednesday";
        break;
    case 5:
        echo "Thursday";
        break;
    case 6:
        echo "Friday";
        break;
    case 7:
        echo "Saturday";
        break;
    default:
        echo "Invalid day number";
}
//question 19
$num = 55;

if ($num % 5 == 0 && $num % 11 == 0) {
    echo "$num is divisible by both 5 and 11<br>";
} else {
    echo "$num is not divisible by both 5 and 11<br>";
}
//question 20
$num = -20;

$absolute = abs($num);

echo "The absolute value  is $absolute<br>";
//question 21
for ($i = 1; $i <= 10; $i++) {
    echo $i."<br>" ;
  
  }
//question 22

for ($i = 1; $i <= 50; $i++) {
    if ($i % 2 == 0) {
        echo $i  ; 
    }
}
//question23


for ($i = 1; $i <= 50; $i++) {
    if ($i % 2 !== 0) {
        echo $i."<br>"  ; }
    }
    //question 24
    
function multiplicatTable($n, $up = 10) {
    for ($i = 1; $i <= $up; $i++) {
        echo $n . " x " . $i . " = " . ($n * $i) . "<br>";
    }
}

multiplicatTable(2);
//question 25

$n = 100;
$sum = ($n * ($n + 1)) / 2;
echo "The sum of first $n natural numbers is: $sum<br>";
//question 26
function factorial($n) {
    $fact = 1;
    for ($i = 1; $i <= $n; $i++) {
        $fact *= $i;
    }
    return $fact;
}
$num = 5;
echo "Factorial $num is: " . factorial($num);
echo"<br>";

//question 27

function fibonacci($n) {
    $num1 = 0;
    $num2 = 1;

    if ($n >= 1) {
        echo $num1 . " ";
    }
    if ($n >= 2) {
        echo $num2 . " ";
    }

    for ($i = 3; $i <= $n; $i++) {
        $next = $num1 + $num2;
        echo $next . " ";
        $num1 = $num2;
        $num2 = $next;
    }
}

$n = 10;
fibonacci($n);
echo"<br>";
//question 28

$number = 6789;
$reversed = strrev((string)$number);
echo "Reverse of $number is: $reversed <br>";

//question 29

$number = 67890;
$count = strlen((string)$number);
echo "Number of digits in $number is: $count<br>";
//question 30
$number = 6789;
$digits = str_split((string)$number);
$sum = array_sum($digits);
echo "Sum of digits of $number is: $sum<br>";
//question 31
$array=[1,2,3,4,5];
var_dump($array);
echo "<br>";
//question 32
$array=[1,2,3,4,5];
$maxium=max($array);
echo "the maxiumem number is: $maxium <br>";
//question 33
$array=[1,2,3,4,5];
$manium=min($array);
echo "the manium number is: $manium <br>";
//question 34

$array=[1,2,3,4,5];
$sum = array_sum($array);

echo "the sum element  is: $sum <br>";
//question 35
$array=[1,2,3,4,5];
$sum = array_sum($array);
$avarege=$sum/count($array);

echo "the avarege array  is: $avarege <br>";

//question 36
$array=[1,2,3,4,5];
$evenNum=0;
$oddNum=0;
foreach($array as $num){
    if($num%2==0){
        $evenNum++;
    }else{
        $oddNum++;
    }

};
echo "Number of even elements: " . $evenNum . "\n";
echo "Number of odd elements: " . $oddNum;
echo"<br>";

//question 37
$array=[3,2,1,4,5];
sort($array);
echo"sort array ascending order :". implode(",",$array);
echo "<br>";
//question 38
$array=[3,2,1,4,5];
rsort($array);
echo"sort array descending order :". implode(",",$array);
echo "<br>";
//question 39

$array = [10, 20, 30, 40, 50];
$search = 30;

if (in_array($search, $array)) {
    echo "$search found in the array.<br>";
} else {
    echo "$search not found in the array.<br>";
}
//question 40

$array = [10, 20, 30, 20, 40, 10, 50];
$uniqueArray = array_unique($array);

echo "Array after removing duplicates: " . implode(", ", $uniqueArray);
echo"<br>";
//question 41
$string="Adan alshobaki";
$len=strlen($string);
echo"lenght string is :$len";
//question42

function countVowels($str) {
    $vowels = ['a', 'e', 'i', 'o', 'u',
               'A', 'E', 'I', 'O', 'U'];
    $count = 0;

    for ($i = 0; $i < strlen($str); $i++) {
        if (in_array($str[$i], $vowels)) {
            $count++;
        }
    }

    return $count;
}
$text = "Adan alshobaki";
echo "Number of vowels in '$text' is: " . countVowels($text);
echo"<br>";

//question 43

function reverseString($str) {
    $reversed = "";
    $length = 0;

    while (isset($str[$length])) {
        $length++;
    }

    for ($i = $length - 1; $i >= 0; $i--) {
        $reversed .= $str[$i];
    }

    return $reversed;
}
$text = "Hello World";
echo "Original string: $text\n";
echo "Reversed string: " . reverseString($text);
echo"<br>";
//question 44

function isPalindrome($str) {
    $length = strlen($str);

    for ($i = 0; $i < $length / 2; $i++) {
        if ($str[$i] !== $str[$length - $i - 1]) {
            return false;
        }
    }
    return true;
}
$text1 = "madam";
echo $text1 . (isPalindrome($text1) ? " is a palindrome\n" : " is not a palindrome\n");
echo"<br>";
//question 45

$str = "Hello World!";
$upper = strtoupper($str);
$lower = strtolower($str);


echo "Original String: " . $str . "\n";
echo "Uppercase: " . $upper . "\n";
echo "Lowercase: " . $lower . "\n";
//question 46
$str = "Hello World PHP String";

$newStr = str_replace(" ", "_", $str);

echo $newStr;
echo"<br>";
//question 47
$str = "Hello World PHP String";
 $lenght=strlen($str);
echo"count number in word is :$lenght <br>";
//question 48

$str = "I love PHP and PHP is powerful ";
$word = "PHP";


$pos = strpos($str, $word);

if ($pos !== false) {
    echo "The first occurrence of '$word' is at position: $pos <br>";
} else {
    echo "Word not found in the string.<br>";
}
//question 49

$str1 = "Adan";
$str2 = " Alshobaki";

$result = $str1 . $str2;

echo $result."<br>"; 
//question 50
$str = "I love PHP programming.";
$word = "PHP";

if (strpos($str, $word) !== false) {
    echo "The string contains '$word'";
} else {
    echo "The string does not contain '$word'";
}











?>