<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

test('should return 200 status code for CNH image', function () {

    // my file is in tests/TestImages/cnh_aleatorio_internet.jpg

    $file = UploadedFile::fake()->image('cnh_aleatorio_internet.jpg');
    
});

