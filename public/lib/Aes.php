<?php

class AES
{
  private $Nb = 4; // block size in 32-bit words
  private $Nk = 4; // key length (4 words for AES-128)
  private $Nr = 10; // number of rounds

  private $sbox = [];
  private $inv_sbox = [];
  private $Rcon = [];
  private $w = [];

  public function __construct()
  {
    $this->initSbox();
    $this->initInvSbox();
    $this->initRcon();
  }

  // Initialize S-box
  private function initSbox()
  {
    $this->sbox = [
  99,124,119,123,242,107,111,197,48,1,103,43,254,215,171,118,
  202,130,201,125,250,89,71,240,173,212,162,175,156,164,114,192,
  183,253,147,38,54,63,247,204,52,165,229,241,113,216,49,21,
  4,199,35,195,24,150,5,154,7,18,128,226,235,39,178,117,
  9,131,44,26,27,110,90,160,82,59,214,179,41,227,47,132,
  83,209,0,237,32,252,177,91,106,203,190,57,74,76,88,207,
  208,239,170,251,67,77,51,133,69,249,2,127,80,60,159,168,
  81,163,64,143,146,157,56,245,188,182,218,33,16,255,243,210,
  205,12,19,236,95,151,68,23,196,167,126,61,100,93,25,115,
  96,129,79,220,34,42,144,136,70,238,184,20,222,94,11,219,
  224,50,58,10,73,6,36,92,194,211,172,98,145,149,228,121,
  231,200,55,109,141,213,78,169,108,86,244,234,101,122,174,8,
  186,120,37,46,28,166,180,198,232,221,116,31,75,189,139,138,
  112,62,181,102,72,3,246,14,97,53,87,185,134,193,29,158,
  225,248,152,17,105,217,142,148,155,30,135,233,206,85,40,223,
  140,161,137,13,191,230,66,104,65,153,45,15,176,84,187,22
]
;
  }

  // Initialize inverse S-box
  private function initInvSbox()
  {
    $this->inv_sbox = [
      82,9,106,213,48,54,165,56,191,64,163,158,129,243,215,251,
      124,227,57,130,155,47,255,135,52,142,67,68,196,222,233,203,
      84,123,148,50,166,194,35,61,238,76,149,11,66,250,195,78,
      8,46,161,102,40,217,36,178,118,91,162,73,109,139,209,37,
      114,248,246,100,134,104,152,22,212,164,92,204,93,101,182,146,
      108,112,72,80,253,237,185,218,94,21,70,87,167,141,157,132,
      144,216,171,0,140,188,211,10,247,228,88,5,184,179,69,6,
      208,44,30,143,202,63,15,2,193,175,189,3,1,19,138,107,
      58,145,17,65,79,103,220,234,151,242,207,206,240,180,230,115,
      150,172,116,34,231,173,53,133,226,249,55,232,28,117,223,110,
      71,241,26,113,29,41,197,137,111,183,98,14,170,24,190,27,
      252,86,62,75,198,210,121,32,154,219,192,254,120,205,90,244,
      31,221,168,51,136,7,199,49,177,18,16,89,39,128,236,95,
      96,81,127,169,25,181,74,13,45,229,122,159,147,201,156,239,
      160,224,59,77,174,42,245,176,200,235,187,60,131,83,153,97,
      23,43,4,126,186,119,214,38,225,105,20,99,85,33,12,125
    ]
    ;
  }

  // Initialize Rcon
  private function initRcon()
  {
    $this->Rcon = [
      [0x01, 0x00, 0x00, 0x00],
      [0x02, 0x00, 0x00, 0x00],
      [0x04, 0x00, 0x00, 0x00],
      [0x08, 0x00, 0x00, 0x00],
      [0x10, 0x00, 0x00, 0x00],
      [0x20, 0x00, 0x00, 0x00],
      [0x40, 0x00, 0x00, 0x00],
      [0x80, 0x00, 0x00, 0x00],
      [0x1B, 0x00, 0x00, 0x00],
      [0x36, 0x00, 0x00, 0x00]
    ];
  }

  // Key expansion
  private function keyExpansion($key)
  {
    $w = [];
    for ($i = 0; $i < $this->Nk; $i++) {
      $w[$i] = array_slice($key, 4 * $i, 4);
    }

    for ($i = $this->Nk; $i < $this->Nb * ($this->Nr + 1); $i++) {
      $temp = $w[$i - 1];
      if ($i % $this->Nk == 0) {
        $temp = $this->subWord($this->rotWord($temp));
        $temp = $this->xorWords($temp, $this->Rcon[$i / $this->Nk - 1]);
      }
      $w[$i] = $this->xorWords($w[$i - $this->Nk], $temp);
    }

    return $w;
  }

  private function subWord($word)
  {
    foreach ($word as &$b) {
      $b = $this->sbox[$b];
    }
    return $word;
  }

  private function rotWord($word)
  {
    return array_merge(array_slice($word, 1), array_slice($word, 0, 1));
  }

  private function xorWords($a, $b)
  {
    return array_map(fn($x, $y) => $x ^ $y, $a, $b);
  }

  // AddRoundKey
  private function addRoundKey(&$state, $round)
  {
    for ($r = 0; $r < 4; $r++) {
      for ($c = 0; $c < 4; $c++) {
        $state[$r][$c] ^= $this->w[($round * 4) + $c][$r];
      }
    }
  }

  // SubBytes
  private function subBytes(&$state)
  {
    for ($r = 0; $r < 4; $r++) {
      for ($c = 0; $c < 4; $c++) {
        $state[$r][$c] = $this->sbox[$state[$r][$c]];
      }
    }
  }

  private function invSubBytes(&$state)
  {
    for ($r = 0; $r < 4; $r++) {
      for ($c = 0; $c < 4; $c++) {
        $state[$r][$c] = $this->inv_sbox[$state[$r][$c]];
      }
    }
  }

  // ShiftRows
  private function shiftRows(&$state)
  {
    for ($r = 1; $r < 4; $r++) {
      $state[$r] = array_merge(array_slice($state[$r], $r), array_slice($state[$r], 0, $r));
    }
  }

  private function invShiftRows(&$state)
  {
    for ($r = 1; $r < 4; $r++) {
      $state[$r] = array_merge(array_slice($state[$r], 4 - $r), array_slice($state[$r], 0, 4 - $r));
    }
  }

  // MixColumns
  private function mixColumns(&$state)
  {
    for ($c = 0; $c < 4; $c++) {
      $a = [];
      for ($r = 0; $r < 4; $r++) {
        $a[$r] = $state[$r][$c];
      }

      $state[0][$c] = $this->gmul($a[0], 2) ^
        $this->gmul($a[1], 3) ^
        $a[2] ^
        $a[3];
      $state[1][$c] = $a[0] ^
        $this->gmul($a[1], 2) ^
        $this->gmul($a[2], 3) ^
        $a[3];
      $state[2][$c] = $a[0] ^
        $a[1] ^
        $this->gmul($a[2], 2) ^
        $this->gmul($a[3], 3);
      $state[3][$c] = $this->gmul($a[0], 3) ^
        $a[1] ^
        $a[2] ^
        $this->gmul($a[3], 2);
    }
  }

  private function invMixColumns(&$state)
  {
    for ($c = 0; $c < 4; $c++) {
      $a = [];
      for ($r = 0; $r < 4; $r++) {
        $a[$r] = $state[$r][$c];
      }

      $state[0][$c] = $this->gmul($a[0], 14) ^
        $this->gmul($a[1], 11) ^
        $this->gmul($a[2], 13) ^
        $this->gmul($a[3], 9);
      $state[1][$c] = $this->gmul($a[0], 9) ^
        $this->gmul($a[1], 14) ^
        $this->gmul($a[2], 11) ^
        $this->gmul($a[3], 13);
      $state[2][$c] = $this->gmul($a[0], 13) ^
        $this->gmul($a[1], 9) ^
        $this->gmul($a[2], 14) ^
        $this->gmul($a[3], 11);
      $state[3][$c] = $this->gmul($a[0], 11) ^
        $this->gmul($a[1], 13) ^
        $this->gmul($a[2], 9) ^
        $this->gmul($a[3], 14);
    }
  }

  private function gmul($a, $b)
  {
    $p = 0;
    for ($i = 0; $i < 8; $i++) {
      if ($b & 1) {
        $p ^= $a;
      }
      $hi_bit_set = $a & 0x80;
      $a = ($a << 1) & 0xFF;
      if ($hi_bit_set) {
        $a ^= 0x1B;
      }
      $b >>= 1;
    }
    return $p;
  }

  public function generateSalt($str) {
    $salt = openssl_random_pseudo_bytes(16);
    $iterations = 10000;
    $keyLength = 16;
    $key_str = hash_pbkdf2("sha256", $str, $salt, $iterations, $keyLength, true);
    $key = array_map('ord', str_split($key_str)); // Convert to byte array
    return $key;
  }

  public function encrypt($input, $key_str)
  {
    $key = array_map('ord', str_split($key_str));
    $input_bytes = array_map('ord', str_split($input));

    // Pad with null bytes (0x00) to make 16 bytes if needed
    while (count($input_bytes) < 16) {
      $input_bytes[] = 0x00;
    }

    $this->w = $this->keyExpansion($key);
    $state = array_chunk($input_bytes, 4);

    $this->addRoundKey($state, 0);

    for ($round = 1; $round < $this->Nr; $round++) {
      $this->subBytes($state);
      $this->shiftRows($state);
      $this->mixColumns($state);
      $this->addRoundKey($state, $round);
    }

    $this->subBytes($state);
    $this->shiftRows($state);
    $this->addRoundKey($state, $this->Nr);

    $output = [];
    foreach ($state as $row) {
      $output = array_merge($output, $row);
    }

    $hexValues = array();
    foreach ($output as $decimal) {
        // Convert each decimal number to its hexadecimal representation
        $hex = dechex($decimal);

        // Ensure each hex value is two digits long by padding with a leading zero if necessary
        if (strlen($hex) === 1) {
            $hex = '0' . $hex;
        }
        $hexValues[] = $hex;
    }

    // Combine the hexadecimal values into a single string
    $hexString = implode('', $hexValues);

    return $hexString;
  }

  public function decrypt($input, $key_str)
  {
    $key = array_map('ord', str_split($key_str));

    $byteArray = [];
    for ($i = 0; $i < strlen($input); $i += 2) {
        $byteHex = substr($input, $i, 2);
        $byteArray[] = hexdec($byteHex);
    }

    $this->w = $this->keyExpansion($key);
    $state = array_chunk($byteArray, 4);

    $this->addRoundKey($state, $this->Nr);

    for ($round = $this->Nr - 1; $round > 0; $round--) {
      $this->invShiftRows($state);
      $this->invSubBytes($state);
      $this->addRoundKey($state, $round);
      $this->invMixColumns($state);
    }

    $this->invShiftRows($state);
    $this->invSubBytes($state);
    $this->addRoundKey($state, 0);

    $output = [];
    foreach ($state as $row) {
      $output = array_merge($output, $row);
    }
    
    $decrypted_str = rtrim(implode('', array_map('chr', $output)), "\0");

    return $decrypted_str;
  }
}
