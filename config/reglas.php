<?php

return array(
    /*USER INFORMATION*/
    'id_usuario'            =>      'integer|exists:usuarios,id',
    'nombre'                =>      'min:2',
    'apellido'              =>      'min:2',
    'nombre_completo'       =>      '|min:3',
    'usuario'             	=>      'min:2',
    'correo'                =>      'email',
    'contrasena'            =>      'min:4',
    'textogenerico'         =>      'min:2',
    'textogenerico_min'     =>      'min:1',


);
