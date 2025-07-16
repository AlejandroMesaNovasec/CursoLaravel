<?php

use App\Business\Services\EncryptService;

test('Prueba de encryptador , que encripte y sea distinto', function () {
    $key = 'unaclavesecreta';
    $encryptor = new EncryptService($key);

    $originalString = 'Una cadena de texto';

    $encryptedString = $encryptor->encrypt($originalString);

    expect($encryptedString)->not->toBe($originalString);

    $decryptedString = $encryptor->decrypt($encryptedString);

    expect($decryptedString)->toBe($originalString);
});


test('lanza una excepción cuando la clave es distinta para desencriptar', function () {

    $key1 = 'unaclavesecreta';
    $key2 = 'unaclaveMAL';

    $encryptor1 = new EncryptService($key1);
    $encryptor2 = new EncryptService($key2);


    $encryptedString = $encryptor1->encrypt('Prueba');


    $this->expectException(Exception::class);
    
    $encryptor2->decrypt($encryptedString);
});