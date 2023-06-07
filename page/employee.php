<?php require_once __DIR__ . '/../modules/dbConnect.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Bukuku Store</title>
    <link rel="icon" type="image/x-icon" href="https://i.ibb.co/cJxPxP0/download.png">

</head>
<body style="height: 100%; width: 100%; box-sizing: border-box;">
    <div class="container">
         <h1 class="mt-4 mb-" style="text-align: center;">
            <img src="https://i.ibb.co/cJxPxP0/download.png" alt="bukuku store" style="height:70px; width:70px; display: block; margin: 0 auto;"/>Bukuku Store
        </h1>

        <ul class = "nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link" href="./">Cabang Toko</a>
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
                <a class="nav-link active" aria-current="page" href="./employee.php">Daftar Pegawai</a>
            </li>
        </ul>
        

        <div class ="container-fluid" style="height: 100%;">
            <div class= "row">

                <div class="col" style="height:70vh; overflow:scroll">
                    <table class="table table-hover mt-4">
                        <thead>
                            <th>No.</th>
                            <th>Nama Pegawai</th>
                            <th>Email</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <?php 
                                $storeEmployee = postgreQuery('SELECT * FROM public."employee"');
                                foreach ($storeEmployee as $index => $row):
                            ?>
                            <tr>
                                <th scope="row" id="<?= $row['employee_id'] ?>" ><?= $index + 1 ?></th>
                                <td><?= substr($row['nama'], 2, -2) ?></td>
                                <td><?= substr($row['email'], 1, -1) ?></td>
                                <td><?= substr($row['status'], 1, -1) ?></td>
                                <td>
                                    <a href="?selected_id=<?= $row['employee_id'] ?>"><button type="button" class="btn btn-primary">view detail</button></a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <div class ="col-5">
                    <?php
                        [ $selectedEmployee, $selectedAddress, $selectedBranch ] = [ null, null, null];
                        if (isset($_GET['selected_id'])):
                            $selectedEmployee = postgreQuery('SELECT * FROM public."employee" WHERE employee_id = '.$_GET['selected_id'])[0];
                            // var_dump($selectedBook);
                            $selectedAddress = postgreQuery('SELECT * FROM public."address" WHERE address_id = '.$selectedEmployee['employee_id'])[0];
                            // var_dump($selectedAddress);
                            $selectedBranch = postgreQuery('SELECT * FROM public."branch_office" WHERE branch_id = '.$selectedEmployee['branch_id'])[0];
                    ?>

                    <table class="table mt-3">
                    <tbody>
                        <tr>
                            <th>Nama Pegawai</th>
                            <td><?php echo str_replace(['}', '"', '{'], '', $selectedEmployee["nama"]) ?></td>
                        </tr>
                        <!-- menampilkan status employee menggunakan row dalam tabel -->
                        <tr>
                            <th>Status</th>
                            <td><?php echo str_replace(['}', '"', '{'], '', $selectedEmployee["status"]) ?></td>
                        </tr>
                        <!-- Informasi mengenai cabang tempat pegawai bekerja -->
                        <tr>
                            <th>Cabang bekerja </th>
                            <td><?php echo str_replace(['}', '"', '{'], '', $selectedBranch["nama"]) ?></td>
                        </tr>
                        <!-- menampilkan email employee menggunakan row dalam tabel -->
                        <tr>
                            <th>Email Aktif</th>
                            <td><?php echo str_replace(['}', '"', '{'], '', $selectedEmployee["email"]) ?></td>
                        </tr>
                        <!-- menampilakn alamat dari employee menggunakan FK dalam tabel employee -->
                        <tr>
                            <th>Alamat</th>
                            <td><?php echo str_replace(['}', '"', '{'], '', $selectedAddress["street"]) ?>, <?php echo str_replace(['}', '"', '{'], '', $selectedAddress["city"]) ?>, <?php echo str_replace(['}', '"', '{'], '', $selectedAddress["zip"]) ?></td>
                        </tr>
                        <!-- untuk menampilkan last_update dari sebuah tabel -->
                        <tr>
                            <th>Last Modified</th>
                            <td><?php echo str_replace(['}', '"', '{'], '', $selectedEmployee["last_update"]) ?>, <?php echo str_replace(['}', '"', '{'], '', $selectedAddress["city"]) ?>, <?php echo str_replace(['}', '"', '{'], '', $selectedAddress["zip"]) ?></td>
                        </tr>
                        <!-- tombol untuk edit data employee, routes menuju directory employeeupdate.php -->
                        <tr>
                            <td>
                            <a href="./../controller/employeeupdate.php"><button type="button" class="btn btn-primary">edit</button></a>
                            </td>
                        </tr>

                    </tbody>
                    </table>

                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>

</body>
</html>