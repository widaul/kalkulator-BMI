<?php 
session_start();

if (!isset($_SESSION['results'])) {
    $_SESSION['results'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Hitung BMI</title>
</head>
<body class="p-3 mb-2 bg-info-subtle text-info-emphasis">

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header text-center bg-primary text-white">
                <h1>Aplikasi Penghitung BMI</h1>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <div class="mb-3">
                        <label for="bb" class="form-label">Berat Badan (Kg):</label>
                        <input type="number" class="form-control" name="bb" required>
                    </div>
                    <div class="mb-3">
                        <label for="tb" class="form-label">Tinggi Badan (Cm):</label>
                        <input type="number" class="form-control" name="tb" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" value="Hitung BMI" name="Hitung">Hitung</button>
                    </div>
                </form>
                
                <?php
                function hitungBmi($bb, $tb){
                    $total= ($bb/($tb * $tb)) * 10000;
                    return number_format($total, 2);
                }

                function kategori($total){
                    if($total < 18.50){
                        return "Underweight";
                    }
                    elseif ($total >= 18.50 && $total <= 24.99) {
                        return "Healthy weight";
                    }
                    elseif ($total >= 25.00 && $total <= 29.99){
                        return "Overweight";
                    }
                    else{
                        return "Obese";
                    }
                }

                if($_SERVER["REQUEST_METHOD"]== "POST"){
                    $bb = $_POST["bb"];
                    $tb = $_POST["tb"];

                    $hasil = hitungBmi($bb, $tb);
                    $kategori = kategori($hasil);

                    $_SESSION['results'][] = [
                        'bb' => $bb,
                        'tb' => $tb,
                        'bmi' => $hasil,
                        'kategori' => $kategori
                    ];
                }

                $results = $_SESSION['results'];
                ?>

                <h2 class="mt-4">Hasil Perhitungan</h2>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr class="table-primary">
                            <th scope="col">Berat Badan (Kg)</th>
                            <th scope="col">Tinggi Badan (Cm)</th>
                            <th scope="col">BMI</th>
                            <th scope="col">Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($results)) { ?>
                            <?php foreach ($results as $result) { ?>
                                <tr>
                                    <td><?php echo $result['bb']; ?></td>
                                    <td><?php echo $result['tb']; ?></td>
                                    <td><?php echo $result['bmi']; ?></td>
                                    <td><?php echo $result['kategori']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
