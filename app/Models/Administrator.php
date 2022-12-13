<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;

class Administrator extends \Esatic\ActiveUser\Models\Administrator
{

    use  HasApiTokens;
}
