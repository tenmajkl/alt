<?php

use Lemon\Env;

return [
    'storage' => Env::file('DATA_STORAGE', '', ''),
];
