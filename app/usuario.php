<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

class usuario extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    //Atributos de la clase
    private $roles = null; //Empezamos la variable de roles en nulo. Cuando alguna función tenga que obtener los roles, de una vez los introducimos acá, así si se tienen que obtener de nuevo solamente devolvemos esta variable y no volvemos a llamar a la base de datos para obtenerlos.
    private $permisos = null;  //Empezamos la variable de permisos en nulo. Cuando alguna función tenga que obtener los permisos, de una vez los introducimos acá, así si se tienen que obtener de nuevo solamente devolvemos esta variable y no volvemos a llamar a la base de datos para obtenerlos.

    protected $fillable = ['nombre', 'correo', 'password'];
    protected $hidden = ['password', 'remember_token'];


    //Las siguientes dos funciones están hechas para indicarle al sistema de no usar los campos por defecto
    public function getAuthPassword() {
        return $this->password;
    }
    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }


    /*
     * Esta función nos indica si el usuario que está siendo usado actualmente tiene permisos de administrador o no.
     * Para saber esto, existe un campo en la base de datos (columna) que es 1 si el usuario es super administrador y 0 si no lo es.
     * A como está hecha esta función, cualquier número distinto de 0 debería devolver que es super administrador.
     * */

    public function esAdministrador(){
        return (bool) $this -> super_administrador;
    }


    /**
     * Esta función pretende devolver un bool si el usuario tiene el permiso que se especifica. Si es super administrador simplemente devuelve siempre
     * true, sino, entonces tiene que verificar los permisos del usuario
     * @param $t Array
     * @return bool
     */
    public function puede($t){
        if($this -> esAdministrador()){
            return true;
        }

        //Primero vemos si el $t es un array. Si lo es, entonces tenemos que verificar por cada uno (se convierte en una cláusula "Y" (&&)
        if(is_array($t)){
            $contador = 0;
            foreach($t AS $p){
                if(in_array($p,$this -> permisos)){
                    $contador++;
                }
            }
            //Revisamos si encontró tantos como se pidieron
            if(count($t) == $contador){
                return true;
            }else{
                return false;
            }

        }else{
            //Es uno simple, así que tenemos que verificar solamente uno.
            return in_array($t,$this -> permisos);
        }
    }

    /**
     * Devuelve los roles actuales del usuario. Puede que devuelva null si ninguna otra función ha requerido los roles por el momento.
     * @return roles
     */
    public function verRoles(){
        $this -> llenarRoles();
        return $this -> roles;
    }

    /**
     * Devuelve los permisos actuales del usuario. Puede que devuelva null si ninguna otra función ha requerido los roles por el momento.
     * @return permisos
     */
    public function verPermisos(){
        $this -> llenarRoles();
        return $this -> permisos;
    }


    /**
     * Esta función se dedica a revisar los roles del usuario, si son nulos entonces los llena, y si tienen contenido simplemente no hace nada.
     * El objetivo de esto es que esta función solo se va a llamar cuando se necesita y no va a llamar a la base de datos innecesariamente.
     */
    public function llenarRoles(){

        if($this -> roles != null){
            //Si ya no es null, no volvemos a llamar a la base de datos
            return;
        }

        //Traemos los roles del usuario
        $q = DB::table("usuarios_roles");
        $q -> select("roles.*");
        $q -> join('roles', 'usuarios_roles.id_rol', '=', 'roles.id');
        $q -> where("id_usuario", $this ->id);

        $res = $q -> get();
        if($res != null){ //Hay roles que usar
            foreach($res AS $r){
                $this -> roles[] = $r -> nombre;
                $permisos = explode(",",$r -> permisos); //Ahora vamos por los permisos
                foreach($permisos AS $p){
                    if($p != null && $p != "") $this -> permisos[] = $p;
                }
            }
            //Vamos a eliminar los roles y permisos duplicados si fuera el caso de que existieran.
            $this -> roles = array_unique($this -> roles);
            $this -> permisos = array_unique($this -> permisos);

        }else{
            //Si no hay roles que usar, entonces llenamos la variable de roles como vacía, al igual que la de permisos
            $this -> roles = [];
            $this -> permisos = [];
            //De esta manera quedan vacíos pero no se vuelven a llamar a la base de datos innecesariamente
        }
        return;
    }

}
