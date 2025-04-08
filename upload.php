<?php
// Menentukan direktori untuk menyimpan gambar yang di-upload
$targetDir = "uploads/";

// Mengecek apakah folder upload ada, jika belum maka dibuat
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true); // Membuat folder upload dengan izin akses penuh
}

// Mengecek apakah ada file yang di-upload melalui form
if (isset($_FILES['gambar'])) {
    $file = $_FILES['gambar']; // Mengambil informasi file yang di-upload
    $targetFile = $targetDir . basename($file['name']); // Menentukan lokasi penyimpanan file
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION)); // Mengambil ekstensi file dan mengubahnya ke lowercase

    // Validasi ekstensi file (hanya menerima file gambar dengan ekstensi tertentu)
    $validFileTypes = ['jpg', 'jpeg', 'png'];
    if (in_array($fileType, $validFileTypes)) {
        // Menyimpan file ke direktori tujuan
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Jika upload berhasil, mengirimkan respons sukses berupa nama file, path file, dan direktori
            $response = [
                'status' => 'success',
                'filename' => basename($file['name']), // Nama file
                'filepath' => $targetFile, // Path lengkap file
                'directory' => realpath($targetDir) // Direktori tempat file disimpan
            ];
            echo json_encode($response); // Mengirimkan respons dalam format JSON
        } else {
            // Jika terjadi kesalahan saat upload, kirimkan pesan error
            $response = [
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat meng-upload gambar.'
            ];
            echo json_encode($response); // Mengirimkan respons error dalam format JSON
        }
    } else {
        // Jika file bukan gambar yang valid, kirimkan pesan error
        $response = [
            'status' => 'error',
            'message' => 'Hanya file gambar dengan ekstensi JPG, JPEG, dan PNG yang diperbolehkan.'
        ];
        echo json_encode($response); // Mengirimkan respons error dalam format JSON
    }
} else {
    // Jika tidak ada file yang di-upload, kirimkan pesan error
    $response = [
        'status' => 'error',
        'message' => 'Tidak ada file yang di-upload.'
    ];
    echo json_encode($response); // Mengirimkan respons error dalam format JSON
}
?>
