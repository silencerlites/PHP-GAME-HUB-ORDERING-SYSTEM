<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment('Play. Order. Enjoy.');
})->purpose('Display a short message');
