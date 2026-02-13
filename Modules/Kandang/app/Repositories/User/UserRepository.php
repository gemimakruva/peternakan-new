<?php

namespace Modules\Kandang\Repositories\User;

use App\Models\User;
use Modules\Kandang\Repositories\EloquentRepository;

class UserRepository extends EloquentRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
