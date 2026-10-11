
<?php

// 1. array_push()
$a = array("A");

echo "Array awal: (";
foreach ($a as $data) {
    echo '"' . $data . '"';
}
echo ")<br>";

array_push($a, "B");

echo "Hasil array_push: ";
foreach ($a as $data) {
    echo $data . " ";
}
echo "<br><br>";

// 2. array_merge()
$a = array("A", "B");
$b = array("C");

echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';

$hasil = array_merge($a, $b);

echo "Hasil array_merge: ";
foreach ($hasil as $data) {
    echo $data . " ";
}
echo "<br><br>";

// 3. array_values()
$a = array("x" => 1, "y" => 2);

echo 'Array awal: ("x" => 1, "y" => 2)<br>';

$hasil = array_values($a);

echo "Hasil array_values: ";
foreach ($hasil as $data) {
    echo $data . " ";
}
echo "<br><br>";

// 4. array_search()
$a = array("A", "B", "C");

echo 'Mencari "B" pada array: ("A", "B", "C")<br>';

$hasil = array_search("B", $a);

echo "Hasil array_search: " . $hasil . "<br><br>";

// 5. array_filter()
$a = array(0, 1, false, 2, "", 3, "array");

echo "Array awal: (0, 1, false, 2, '', 3, 'array')<br>";

$hasil = array_filter($a);

echo "Hasil array_filter: ";
foreach ($hasil as $data) {
    echo $data . " ";
}
echo "<br><br>";

// 6. sort() dan rsort()
$a = array(3, 1, 2);

echo "Array awal: (3, 1, 2)<br>";

$hasil = $a;
sort($hasil);

echo "Hasil sort: ";
foreach ($hasil as $data) {
    echo $data . " ";
}
echo "<br>";

$hasil = $a;
rsort($hasil);

echo "Hasil rsort: ";
foreach ($hasil as $data) {
    echo $data . " ";
}
echo "<br><br>";

// 7. asort(), ksort(), arsort(), dan krsort()
$a = array("Peter" => 35, "Ben" => 37, "Joe" => 43);

echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$hasil = $a;
asort($hasil);

echo "Hasil asort: ";
foreach ($hasil as $nama => $umur) {
    echo $nama . "=> " . $umur . ", ";
}
echo "<br>";

$hasil = $a;
ksort($hasil);

echo "Hasil ksort: ";
foreach ($hasil as $nama => $umur) {
    echo $nama . "=> " . $umur . ", ";
}
echo "<br>";

$hasil = $a;
arsort($hasil);

echo "Hasil arsort: ";
foreach ($hasil as $nama => $umur) {
    echo $nama . "=> " . $umur . ", ";
}
echo "<br>";

$hasil = $a;
krsort($hasil);

echo "Hasil krsort: ";
foreach ($hasil as $nama => $umur) {
    echo $nama . "=> " . $umur . ", ";
}
echo "<br>";

?>