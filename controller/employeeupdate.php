<?php require_once __DIR__ . '/../modules/dbConnect.php' ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'> 

    <title>Bukuku Store</title>
    <link rel="icon" type="image/x-icon" href="https://i.ibb.co/cJxPxP0/download.png">

  </head>
  <body style="height: 100%; width: 100%; box-sizing: border-box;">

  <div class="container">
    <h1 class="mt-4 mb-" style="text-align: center;">
        <img src="https://i.ibb.co/cJxPxP0/download.png" alt="croppedbook" style="height:70px; width:70px; display: block; margin: 0 auto;"/>Bukuku Store
    </h1>
    <?php 
        //Kode di bawah menggunakan fungsi array_map() untuk memanipulasi setiap elemen dalam array hasil query ke database. 
        //Pada setiap elemen array, bagian 'nama' dipotong dengan menggunakan substr() agar karakter pertama dan terakhirnya terhapus,
        //Hasil manipulasi ini kemudian dikembalikan sebagai array baru.
        $employee = array_map(function($e) {
            $e['nama'] = substr($e['nama'], 2, -2);
            $e['status'] = substr($e['status'], 1, -1);
            return $e;
        } , postgreQuery('SELECT * FROM public."employee"'));
    ?>
    <form action="./query.php" method="post" id="editauth" onsubmit="return confirm('Apakah anda yakin kak?');">

    <div id="original-data" style="display:none">
        <?php 
            //Kode di bawah menggunakan fungsi json_encode() untuk mengubah array $employee menjadi format JSON yang dapat digunakan untuk pertukaran data.
            //Kemudian, hasilnya di cetak menggunakan perintah echo.
            echo json_encode($employee)
        ?>
    </div>
    <script>
        const originalData = JSON.parse(document.getElementById("original-data").innerText)
        console.log(originalData)
    </script>

    <div class="d-flex justify-content-between">
        <div>
            <a href="../page/employee.php">
                <button type="button" class="btn btn-danger">Cancel</button>
            </a>
            <input class="btn btn-primary" type="submit" value="Submit">
        </div>
    </div>

    <div class="container-fluid" style="height: 100%;">
        <div class="row">
            <div class="col">
                <table class="table table-hover mt-3">
                    <thead>
                        <th><i class="fa fa-trash"></i></th>
                        <th>Nama</th>
                        <th>status</th>
                    </thead>
                    <tbody>
                        <?php foreach ($employee as $index => $employee): ?>
                        <tr>
                            <td><input type="checkbox" value="<?= $employee['employee_id'] ?>" id="d-<?= $employee['employee_id'] ?>"></td>
                            <td><input type="text" value="<?= $employee['nama'] ?>" id="n-<?= $employee['employee_id'] ?>"></td>
                            <td><input type="text" value="<?= $employee['status'] ?>" id="s-<?= $employee['employee_id'] ?>"></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <div class="col-6 mt-3" id="tes2">
                <input type="hidden" name="redirect-to" value="../page/employee.php">
                <textarea name="query-string" id="query-string" style="display: none" form="editauth"></textarea>
                <textarea readonly id="dummy-query" style="font-family: monospace; font-size: 0.75rem; width:100%; height:100%"></textarea>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <script>
        //membuat objek dataForm yang berisi elemen-elemen input dengan ID yang terkait dengan ID objek dalam array originalData.
        //Event listener ditambahkan untuk mendeteksi perubahan pada elemen-elemen input.
        //Hasilnya, perubahan pada elemen-elemen input akan memicu pemanggilan fungsi detectFormChange.
        const dataForm = originalData.map(row => {
            const id = row.employee_id
            const temp = {
                d: document.getElementById(`d-${id}`),
                n: document.getElementById(`n-${id}`),
                s: document.getElementById(`s-${id}`)
            }
            temp.d.addEventListener('change', detectFormChange)
            temp.n.addEventListener('input', detectFormChange)
            temp.s.addEventListener('input', detectFormChange)
            return temp
        })

        function detectFormChange() {
            const myObj = []
            originalData.forEach((e, i) => {
                // dilakukan pengecekan satu per satu
                if (dataForm[i].d.checked) {
                    // jika checked pada sebelah kanan di centang dan di submit maka akan di delete
                    myObj.push(`DELETE FROM public."employee" WHERE employee_id = ${e.employee_id};`)
                } else if (e.nama == dataForm[i].n.value && e.status == dataForm[i].s.value) {
                    // jika nama dan status sama maka tidak ada yang di update
                } else if (e.status != dataForm[i].s.value && e.nama != dataForm[i].n.value) {
                    // jika yang ada di db dan di datafome beda, makan keduanya akan di udate
                    myObj.push(`UPDATE public."employee" SET nama = '{${dataForm[i].n.value}}', status = '{${dataForm[i].s.value}}' WHERE employee_id = ${e.employee_id};`)
                } else if (e.status != dataForm[i].s.value) {
                    // hanya status yang beda makan status akan di update
                    myObj.push(`UPDATE public."employee" SET status = '{${dataForm[i].s.value}}' WHERE employee_id = ${e.employee_id};`)
                } else {
                    // hanya nama yang beda makan nama akan di update
                    myObj.push(`UPDATE public."employee" SET nama = '{${dataForm[i].n.value}}' WHERE employee_id =${e.employee_id};`)
                }
                
            })
            //Jika myObj tidak kosong, maka nilai dari elemen dengan ID 'dummy-query' akan diatur dengan nilai teks yang berisi 'BEGIN TRANSACTION;',
            //diikuti oleh elemen-elemen dalam myObj yang digabungkan dengan baris baru ('\n\n'), dan diakhiri dengan 'COMMIT;'.
            //Jika myObj kosong, nilai dari elemen dengan ID 'dummy-query' akan diatur menjadi string kosong.
            //Selain itu, nilai dari elemen dengan ID 'query-string' akan diatur dengan JSON.stringify(myObj).
            if (myObj.length !== 0) {
                document.getElementById('dummy-query').value = 'BEGIN TRANSACTION;\n\n'+myObj.join('\n\n')+'\n\nCOMMIT;'
            } else {
                document.getElementById('dummy-query').value = ''
            }
            document.getElementById('query-string').value = JSON.stringify(myObj)
        }

    </script>
    
    </form>
</div>
</body>
</html>