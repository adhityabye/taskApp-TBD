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
                <a class="nav-link active" aria-current="page" href="./book.php">Daftar Buku</a>
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

        <div class="container-fluid" style="height:100%;">
            <div class="row">
                <div class="col" style="height:60vh; overflow:scroll" >
                    <table class="table table-hover mt-4">
                        <thead>
                            <th>No.</th>
                            <th>Judul Buku</th>
                        </thead>
                        <tbody>
                            <?php 
                                $storeBook = executePostgreSQLQuery('SELECT * FROM public."book"');
                                foreach ($storeBook as $index => $row):
                                    $trimmedTitle = substr(trim($row['title'], '",{}'), 0, 30);
                            ?>
                            <tr>
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= $trimmedTitle ?></td>
                                <td>
                                    <a href="?selected_id=<?= $row['book_id'] ?>"><button type="button" class="btn btn-primary">view detail</button></a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <div class ="col-5">

                    <?php
                        [ $selectedBook, $selectedAuthor, $selectedCategory, $selectedBranch ] = [ null, null, null, null ];
                        if (isset($_GET['selected_id'])):
                            $selectedBook = executePostgreSQLQuery('SELECT * FROM public."book" WHERE book_id = '.$_GET['selected_id'])[0];
                            // var_dump($selectedBook);
                            $selectedAuthor = executePostgreSQLQuery('SELECT * FROM public."author" WHERE author_id = '.$selectedBook['author_id'])[0];
                            // var_dump($selectedAddress);
                            $selectedCategory = executePostgreSQLQuery('SELECT * FROM public."category" WHERE category_id = '.$selectedBook['category_id'])[0];
                            // var_dump($selectedBooks);
                            $selectedBranch = executePostgreSQLQuery('SELECT * FROM public."branch_office" WHERE branch_id = '.$selectedBook['book_id'])[0];
                    ?>

                    <table class="table mt-3">
                        <tbody>
                            <!-- Untuk menampilkan judul buku dari row title dalam tabel -->
                            <tr>
                                <th>Judul</th>
                                <td><?php echo str_replace(['}', '"', '{'], '', $selectedBook["title"]) ?></td>
                            </tr>
                            <!-- untuk menampilkan nama penulis menggunakan FK yang ada dalam tabel -->
                            <tr>
                                <th>Penulis</th>
                                <td><?php echo str_replace(['}', '"', '{'], '', $selectedAuthor["nama"]) ?></td>
                            </tr>
                            <!-- untuk menampilkan harga buku dari row dalam tabel -->
                            <tr>
                                <th>Harga</th>
                                <td><?php echo str_replace(['}', '"', '{'], '', $selectedBook["price"]) ?></td>
                            </tr>

                            <tr>
                                <th>Terdapat dalam cabang </th>
                                <td><?php echo str_replace(['}', '"', '{'], '', $selectedBranch["nama"]) ?></td>
                            </tr>

                            <!-- untuk menampilakn jumlah halaman buku dari row yang ada dalam tabel -->
                            <tr>
                                <th>Jumlah Halaman</th>
                                <td><?php echo str_replace(['}', '"', '{'], '', $selectedBook["pages"]) ?></td>
                            </tr>
                            <!-- untuk menampilkan jenis kategori buku menggunakan FK dalam tabel book -->
                            <tr>
                                <th>Category</th>
                                <td><?php echo str_replace(['}', '"', '{'], '', $selectedCategory["category_name"]) ?></td>
                            </tr>
                            <!-- untuk menampilkan last_update dari sebuah tabel -->
                            <tr>
                                <th>Last Modified</th>
                                <td><?php echo str_replace(['}', '"', '{'], '', $selectedBook["last_update"]) ?></td>
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