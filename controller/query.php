<?php 

//Jika variabel $_POST['query-string'] dan $_POST['redirect-to'] ada dan $_POST['query-string'] tidak kosong,
//maka kode di dalam if statement akan dieksekusi. Kode tersebut memanggil file dbConnect.php,
//menguraikan nilai dari $_POST['query-string'] sebagai JSON,
//menggabungkan nilai-nilai dalam array hasil penguraian JSON menjadi satu string multipleQueryString,
//dan melakukan query ke database menggunakan fungsi postgreQueryTCL().
if (
    isset($_POST['query-string']) &&
    isset($_POST['redirect-to']) &&
    $_POST['query-string'] != ''
    ) {

    require __DIR__ . '/../modules/dbConnect.php';
    $temp = json_decode($_POST['query-string']);
    $multipleQueryString = implode('', $temp);
    $isSuccess = postgreQueryTCL($multipleQueryString);
    // var_dump($isSuccess, $multipleQueryString);

}
?>

<!-- Kode di atas merupakan bagian dari form yang mengarahkan action ke nilai dari $_POST['redirect-to'] yang ditentukan sebelumnya. -->
<!-- Terdapat juga input dengan tipe "hidden" yang memiliki nilai dari variabel $isSuccess dan akan dikirimkan dalam form dengan nama "is-success". -->
<!-- Setelah itu, kode JavaScript dijalankan untuk melakukan submit form dengan ID "next". -->
<form action="<?php echo $_POST['redirect-to'] ?>" id="next" method="post">
    <input type="hidden" value="<?= $isSuccess ?>" name="is-success" form="next">
</form>

<script type="text/javascript">
    document.getElementById('next').submit();
</script>

