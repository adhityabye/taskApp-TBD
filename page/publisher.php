<?php require_once __DIR__ . '/../modules/dbConnect.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="https://i.ibb.co/cJxPxP0/download.png">
    <title>Bukuku Store</title>
</head>
<body>

    <div class="container">
        <h1 class="mt-4 mb-" style="text-align: center;">
            <img src="https://i.ibb.co/cJxPxP0/download.png" alt="bukuku store" style="height:70px; width:70px; display: block; margin: 0 auto;"/>Bukuku Store
        </h1>

        <ul class = "nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link" href="./">Cabang Toko</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="./book.php">Daftar Buku</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./publisher.php">Publisher</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"   href="./author.php">Daftar Penulis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./employee.php">Daftar Pegawai</a>
            </li>
        </ul>

        <div class="container-fluid" style="height: 100%">
            <div class="row">
                <div class="col" style="height:60vh; overflow:scroll">
                    <table class="table table-hover mt-4">
                        <thead>
                            <th>No.</th>
                            <th>Nama Publisher</th>
                        </thead>
                        <tbody>
                            <?php 
                                $bookPublisher = executePostgreSQLQuery('SELECT * FROM public."publisher"');
                                foreach ($bookPublisher as $index => $row):
                            ?>
                            <tr>
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= substr($row['nama'], 2, -2) ?></td>
                                <td>
                                    <a href="?selected_id=<?= $row['publisher_id'] ?>"><button type="button" class="btn btn-primary">view detail</button></a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <div class ="col-5">
                    <?php
                        //ketiga variabel ini diinisiasi null dan nantinya akan digunkana untuk menyimpan data dari selected table yang diinginkan.
                        [ $selectedPublisher, $selectedAddress ] = [ null, null];
                        if (isset($_GET['selected_id'])):
                            $selectedPublisher = executePostgreSQLQuery('SELECT * FROM public."publisher" WHERE publisher_id = '.$_GET['selected_id'])[0];
                            // var_dump($selectedBranch);
                            $selectedAddress = executePostgreSQLQuery('SELECT * FROM public."address" WHERE address_id = '.$selectedPublisher['publisher_id'])[0];
                            // var_dump($selectedAddress);
                    ?>

                    <table class="table mt-3">
                        <tbody>
                            <tr>
                                <th>Nama Publisher</th>
                                <td><?php echo substr($selectedPublisher['nama'], 2, -2) ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo substr($selectedPublisher['email'], 2, -2) ?></td>
                            </tr>
                            <tr>
                                <th>Fax</th>
                                <td><?php echo substr($selectedPublisher['fax'], 2, -2) ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><?php echo substr($selectedAddress['street'], 2, -2) ?>, <?php echo substr($selectedAddress['city'], 1, -1) ?>, <?php echo substr($selectedAddress['zip'], 1, -1) ?></td>
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