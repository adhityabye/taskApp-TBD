<?php require_once __DIR__ . '/../modules/dbConnect.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Bukuku Store</title>
    <link rel="icon" type="image/x-icon" href="https://i.ibb.co/cJxPxP0/download.png">
    
</head>
<body style= "height: 100%; width: 100%; box-sizing: border-box;">
    
    <div class = "container">
        <h1 class="mt-4 mb-" style="text-align: center;">
            <img src="https://i.ibb.co/cJxPxP0/download.png" alt="bukuku store" style="height:70px; width:70px; display: block; margin: 0 auto;"/>Bukuku Store
        </h1>

        <!-- Ini section buat navigation bar -->
        <ul class = "nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./">Cabang Toko</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./book.php">Daftar Buku</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./publisher.php">Publisher</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./author.php">Daftar Penulis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./employee.php">Daftar Pegawai</a>
            </li>
        </ul>

        <div class="container-fluid" style="height: 100%">
            <div class="row">
                <div class="col">
                    <table class="table table-hover mt-4">
                        <thead>
                            <th>No.</th>
                            <th>Nama Cabang</th>
                            <th>Luas Lahan</th>
                        </thead>
                        <tbody>
                            <?php 
                                $storeBranches = postgreQuery('SELECT * FROM public."branch_office"');
                                foreach ($storeBranches as $index => $row):
                            ?>
                            <tr>
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= substr($row['nama'], 2, 8) ?></td>
                                <td><?= substr($row['land_area'], 1, 6 ) ?>m<sup>2</sup></td>
                                <td>
                                    <a href="?selected_id=<?= $row['branch_id'] ?>"><button type="button" class="btn btn-primary">view detail</button></a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <div class ="col-5">
                    <?php
                        //ketiga variabel ini diinisiasi null dan nantinya akan digunkana untuk menyimpan data dari selected table yang diinginkan.
                        [ $selectedBranch, $selectedAddress, $selectedBooks ] = [ null, null, null ];
                        if (isset($_GET['selected_id'])):
                            $selectedBranch = postgreQuery('SELECT * FROM public."branch_office" WHERE branch_id = '.$_GET['selected_id'])[0];
                            // var_dump($selectedBranch);
                            $selectedAddress = postgreQuery('SELECT * FROM public."address" WHERE address_id = '.$selectedBranch['address_id'])[0];
                            // var_dump($selectedAddress);
                            $selectedBooks = postgreQuery('SELECT * FROM public."book" WHERE branch_id = '.$_GET['selected_id']);
                            // var_dump($selectedBooks);
                    ?>

                    <table class="table mt-3">
                        <tbody>
                            <tr>
                                <th>Nama</th>
                                <td><?php echo substr($selectedBranch['nama'], 2, -2) ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><?php echo substr($selectedAddress['street'], 2, -2) ?>, <?php echo substr($selectedAddress['city'], 1, -1) ?>, <?php echo substr($selectedAddress['zip'], 1, -1) ?></td>
                            </tr>
                            <tr>
                                <th>Buku tersedia dalam cabang</th>
                                <!-- menampilakn buku apa saja yang ada dalam cabang tersebut -->
                                <!-- satu buku terdapat dalam satu cabang dan sebuah cabang hanya memiliki judul buku unik yang tidak dimiliki cabang lain-->
                                <td>
                                    <?php foreach($selectedBooks as $book): ?> 
                                    <p><?php echo str_replace(['}', '"', '{'], '', $book["title"]) ?></p>
                                    <?php endforeach ?>
                                </td>
                            </tr>

                            <tr>
                            <th>Last Modified</th>
                            <td><?php echo str_replace(['}', '"', '{'], '', $selectedBranch["last_update"]) ?></td>
                            </tr>
                            
                        </tbody>
                    </table>

            
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </div>

</body>
</html>