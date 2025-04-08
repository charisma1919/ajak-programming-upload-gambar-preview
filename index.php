<!-- membuat file index.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Gambar Otomatis dengan AJAX</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        /* Styling untuk preview gambar setelah upload */
        #preview {
            margin-top: 20px;
        }
        /* Membatasi ukuran gambar agar tidak terlalu besar di halaman */
        #imgPreview {
            max-width: 100%;
            max-height: 300px;
        }
    </style>
</head>
<body>

    <h2>Upload Gambar Otomatis</h2>
    <!-- Form untuk meng-upload gambar -->
    <form id="uploadForm" enctype="multipart/form-data">
        <!-- Input file untuk memilih gambar -->
        <input type="file" name="gambar" id="gambar" required>
    </form>

    <!-- Div untuk menampilkan preview gambar setelah di-upload -->
    <div id="preview"></div>

    <script>
        // Menunggu sampai halaman selesai dimuat
        $(document).ready(function() {
            // Mengatur event listener ketika file dipilih (change event)
            $("#gambar").change(function(e) {
                // Mencegah form submit secara default
                e.preventDefault();
                
                // Membuat FormData baru dan menambahkan file yang dipilih
                var formData = new FormData();
                formData.append('gambar', this.files[0]);

                // Melakukan request AJAX ke server untuk proses upload
                $.ajax({
                    url: 'upload.php', // URL ke file PHP untuk menangani upload
                    type: 'POST', // Metode HTTP yang digunakan
                    data: formData, // Data yang akan dikirim ke server (file gambar)
                    contentType: false, // Tidak mengatur header Content-Type secara otomatis
                    processData: false, // Tidak mengubah data menjadi query string
                    success: function(response) {
                        // Menangani respons dari server (file berhasil di-upload)
                        var res = JSON.parse(response); // Mengubah respons menjadi format JSON
                        if(res.status == 'success') {
                            // Menampilkan preview gambar setelah upload berhasil
                            $('#preview').html('<img id="imgPreview" src="' + res.filepath + '" alt="Preview">');
                            // Menampilkan informasi nama file dan direktori tempat file di-upload
                            $('#preview').append('<p>Nama Gambar: ' + res.filename + ' berhasil di-upload di ' + res.directory + '</p>');
                        } else {
                            // Menampilkan pesan error jika upload gagal
                            alert('Upload gagal: ' + res.message);
                        }
                    }
                });
            });
        });
    </script>

</body>
</html>
