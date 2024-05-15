<?php

use App\Console\Kernel as ConsoleKernel;

$app = require 'bootstrap/app.php';
$app->make(ConsoleKernel::class)->bootstrap();
