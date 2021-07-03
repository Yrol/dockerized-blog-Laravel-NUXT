<?php

namespace App\Exceptions;

use Exception;

/*
* Custom exception throwing when the model is not defined in /Repositories/Eloquent/BaseRepository.php
*/
class ModelNotDefined extends Exception
{
}
