<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

class usuario extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    public function getAuthPassword() {
        return $this->contrasena;
    }

}
