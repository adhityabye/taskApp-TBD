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
<body style="height: 100%; width: 100%; box-sizing: border-box;">
    
    <div class="container">
        <h1 class="mt-4 mb-" style="text-align: center;">
        <img src="https://i.ibb.co/cJxPxP0/download.png" alt="bukuku store" style="height:70px; width:70px; display: block; margin: 0 auto;"/>Bukuku Store
        </h1>

        <ul class = "nav justify-content-center">

            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Cabang Toko</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./book.php">Daftar Buku</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./author.php">Daftar Penulis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./employee.php">Daftar Pegawai</a>
            </li>

        </ul>

        <div class="container-fluid" style="height: 100%;">
            <div class="row">

                <div class="col" style="height:70vh; overflow:scroll">
                    <table class="table table-hover mt-4">
                        <thead>
                            <th>No.</th>
                            <th>Nama Penulis</th>
                        </thead>
                        <tbody>
                            <?php 
                                $authors = postgreQuery('SELECT * FROM public."author"');
                                foreach ($authors as $index => $row):
                            ?>
                            <tr>
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= substr($row['nama'], 2, -2) ?></td>
                                <td>
                                    <a href="?selected_id=<?= $row['author_id'] ?>"><button type="button" class="btn btn-primary">view detail</button></a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <div class ="col-5">
                <?php
                //Kode ini mengambil data penulis dan alamat dari database berdasarkan author_id yang diberikan melaluiparameter URL.
                //Data penulis disimpan dalam variabel $selectedAuthor dan data alamat disimpan dalam variabel $selectedAddress.
                //alamat diakses dengan menyamakan id penulis dengan id alamat dalam database.
                    [ $selectedAuthor, $selectedAddress ] = [ null, null];
                    if (isset($_GET['selected_id'])):
                        $selectedAuthor = postgreQuery('SELECT * FROM public."author" WHERE author_id = '.$_GET['selected_id'])[0];
                        // var_dump($selectedBook);
                        $selectedAddress = postgreQuery('SELECT * FROM public."address" WHERE address_id = '.$selectedAuthor['author_id'])[0];
                        // var_dump($selectedAddress);
                ?>

                <table class="table mt-3">
                <tbody>
                    <!-- menampilkan nama dari penulis buku dari specified row yang ada dalam tabel -->
                    <tr>
                        <th>Nama</th>
                        <td><?php echo str_replace(['}', '"', '{'], '', $selectedAuthor["nama"]) ?></td>
                    </tr>
                    <!-- menampilakn tanggal lahir penulis dari row dalam tabel -->
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td><?php echo str_replace(['}', '"', '{'], '', $selectedAuthor["birth_date"]) ?></td>
                    </tr>
                    <!-- menampilakn nomor telpon dari penulis dari row dalam tabel -->
                    <tr>
                        <th>Nomor Telepon</th>
                        <td><?php echo str_replace(['}', '"', '{'], '', $selectedAuthor["phone_number"]) ?></td>
                    </tr>
                    <!-- menampilkan alamat dari penulis dengan menggunakan FK addres dalam tabel author  -->
                    <tr>
                        <th>Alamat</th>
                        <td><?php echo str_replace(['}', '"', '{'], '', $selectedAddress["street"]) ?>, <?php echo str_replace(['}', '"', '{'], '', $selectedAddress["city"]) ?>, <?php echo str_replace(['}', '"', '{'], '', $selectedAddress["zip"]) ?></td>
                    </tr>
                    <!-- untuk menampilkan last_update dari sebuah tabel -->
                    <tr>
                        <th>Last Modified</th>
                        <td><?php echo str_replace(['}', '"', '{'], '', $selectedAuthor["last_update"]) ?></td>
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