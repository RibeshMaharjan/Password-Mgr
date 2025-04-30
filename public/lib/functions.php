<?php
if (!isset($_SESSION)) {
    session_start();
}
require __DIR__.'/../php/dbh.php';
// require __DIR__.'/../php/AES/aes.php';

// $aes = new AES();

function getUserInfo()
{
    global $dbh;
    global $aes;
    $user_id = $_SESSION["userid"];
    $stmt = $dbh->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $decrypted_pwd = $aes->decrypt($result['users_pwd'], $_SESSION["password"]);

    $user = [
      'user_id' => $result['user_id'],
      'users_name' => $result['users_name'],
      'users_email' => $result['users_email'],
      'pwd' => $decrypted_pwd
    ];

    return $user;
}

// function aes_Encrypt($data, $key_str)
// {
//     $aes = new AES();

// //    $key_str = "MySecretKey12345"; // Must be 16 chars for AES-128
//     $key = array_map('ord', str_split($key_str)); // Convert to byte array

//     $input_text = "Hello world"; // Example input
//     $input_bytes = array_map('ord', str_split($data));

//     // Pad with null bytes (0x00) to make 16 bytes if needed
//     while (count($input_bytes) < 16) {
//       $input_bytes[] = 0x00;
//     }

//     // Display original string
//     echo "Original Text: " . $input_text . "<br>";

//     // Encrypt
//     $cipher = $aes->encrypt($input_bytes, $key);

//     echo "Encrypted Bytes (Hex): ";
//     foreach ($cipher as $byte) {
//       printf("%02x ", $byte);
//     }
//     echo "<br>";

//     // Decrypt
//     $decipher = $aes->decrypt($cipher, $key);

//     // Convert back to string and remove padding
//     $decrypted_str = rtrim(implode('', array_map('chr', $decipher)), "\0");

//     echo "Decrypted Text: " . $decrypted_str . "<br>";
// }