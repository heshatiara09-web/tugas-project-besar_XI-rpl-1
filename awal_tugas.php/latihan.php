<?php 

//$hari = "";

// switch ($hari) {
//     case 'senin':
//         echo "hari " . $hari . "<br>";
//         echo " seragam : putih abu";
//         break;
//     case 'selasa' || 'kamis':
//         echo "hari " . $hari. "<br>";
//         echo " seragam : seragam jurusan";
//         break;
//     case 'rabu':
//         echo "hari " . $hari. "<br>";
//         echo " seragam : almet";
//         break;
//     case 'jumat':
//         echo "hari " . $hari. "<br>";
//         echo " seragam : pramuka";
//         break;
//     default:
//         echo "hari " . $hari . "<br>";
//         echo " seragam : bebas atau hari libur";
//         break;
// }

$nilai = 101;

switch (true) {
    case ($nilai >= 91 && $nilai <= 100):
        echo "Nilai A";
        break;

    case ($nilai >= 81 && $nilai <= 90):
        echo "Nilai B";
        break;

    case ($nilai >= 71 && $nilai <= 80):
        echo "Nilai C";
        break;

    case ($nilai >= 61 && $nilai <= 70):
        echo "Nilai D";
        break;

    case ($nilai <= 60):
        echo "Nilai E";
        break;
default;
}
?>
