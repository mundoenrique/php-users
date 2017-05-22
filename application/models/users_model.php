<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FUNCION PARA HACER LOGIN
    public function login_user($username, $password)
    {
        $logAcceso = np_hoplite_log('', $username, 'personasWeb', 'login', 'login', 'Login');

        $data = json_encode(array(
            'idOperation' => '1',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'userName' => $username,
            'password' => $password,
            'logAccesoObject' => $logAcceso,
            'token' => ''
        ));

        $dataEncry = np_Hoplite_Encryption($data, 0);
        $data = json_encode(array('data' => $dataEncry, 'pais' => 'Global', 'keyId' => 'CPONLINE'));
        log_message('info', 'Salida encriptada login_user: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 0)));
        $salida = json_encode($desdata);

        log_message('info', 'Salida login usuario' . $salida);

        if(isset($response) && $desdata->rc==0){
            $newdata = array(
                'idUsuario' => $desdata->idUsuario,
                'userName' => $desdata->userName,
                'nombreCompleto' => strtolower(substr($desdata->primerNombre, 0, 18)) . ' ' . strtolower(substr($desdata->primerApellido, 0, 18)),
                'token' => $desdata->token,
                'sessionId' => $desdata->logAccesoObject->sessionId,
                'keyId' => $desdata->keyUpdate,
                'logged_in' => true,
                'pais' => $desdata->codPais,
                'aplicaTransferencia' => $desdata->aplicaTransferencia,
                'passwordOperaciones' => $desdata->passwordOperaciones,
                'cl_addr' => np_Hoplite_Encryption($_SERVER['REMOTE_ADDR'], 0),
                'afiliado' => $desdata->afiliado,
                'aplicaPerfil' => $desdata->aplicaPerfil
            );
            $this->session->set_userdata($newdata);
        }
        $salida = json_encode($desdata);

        log_message('info', 'Salida INICIO DE SESION--->' . $salida);

        return json_encode($desdata);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //RECUPERAR LOGIN
    public function obtener_login($id_ext_per, $email)
    {
        $logAcceso = np_hoplite_log('', '', 'personasWeb', 'obtener login', 'obtener login', 'obtener login');

        $id_ext_per = base64_decode($id_ext_per);
        $email = base64_decode($email);

        $data = json_encode(array(
            'idOperation'  => '24',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'id_ext_per' => $id_ext_per,
            'email' => $email,
            'logAccesoObject' => $logAcceso,
            'token' => ''
        ));

        log_message('info', 'Salida: ' . $data);

        $dataEncry = np_Hoplite_Encryption($data, 0);
        $data = json_encode(array('data' => $dataEncry, 'pais' => 'Global', 'keyId' => 'CPONLINE'));
        log_message('info', 'Salida encriptada obtener_login: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 0)));

        return json_encode($desdata);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //RESETEAR PASSWORD
    public function reset_password($id_ext_per, $email)
    {
        $logAcceso = np_hoplite_log('','','personasWeb','reset password','reset password','reset password');

        $id_ext_per = base64_decode($id_ext_per);
        $email = base64_decode($email);

        $data = json_encode(array(
            'idOperation' => '23',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'id_ext_per' => $id_ext_per,
            'email' => $email,
            'logAccesoObject' => $logAcceso,
            'token' => ''
        ));

        log_message('info', 'Salida : '.$data);

        $dataEncry = np_Hoplite_Encryption($data, 0);
        $data = json_encode(array('data' => $dataEncry, 'pais' => 'Global', 'keyId' => 'CPONLINE'));
        log_message('info', 'Salida encriptada reset_password: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 0)));

        return json_encode($desdata);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //ACTUALIZAR PASSWORD
    public function actualizar_password($passwordOld, $passwordNew)
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'), $this->session->userdata('userName'), 'personasWeb', 'password', 'password', 'actualizar');

        $passwordMobile = strtoupper($passwordNew); // To allow cardholders to sign in through mobile app 'Acceso Móvil'

        $data = json_encode(array(
            'idOperation' => '25',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'userName' => $this->session->userdata('userName'),
            'passwordOld' => md5($passwordOld),
            'password' => md5($passwordNew),
            'passwordOld4' => md5($passwordMobile),
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')
        ));

        log_message('info', 'Salida: ' . $data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada actualizar_password: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));

        log_message('info', 'Response actualizar password:---->>>>>'. json_encode($desdata));

        return json_encode($desdata);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //CREAR PASSWORD DE OPERACIONES
    public function password_operaciones($passwordOperaciones)
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'), $this->session->userdata('userName'), 'personasWeb', 'password op', 'password op', 'crear');

        $data = json_encode(array(
            'idOperation' => '31',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'userName' => $this->session->userdata('userName'),
            'passwordOperaciones' => md5($passwordOperaciones),
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')
        ));

        log_message('info', 'Salida Crear: '.$data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada password_operaciones: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));

        return json_encode($desdata);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //CREAR PASSWORD sms
    public function password_sms_crear($id_ext_per, $claveSMS, $nroMovil)
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'),$this->session->userdata('userName'),'personasWeb','perfil','clave sms','registrar clave');

        $data = json_encode(array(
            'idOperation' => '42',
            'className' => 'com.novo.objects.TOs.TarjetaTO',
            'id_ext_per' => $id_ext_per,
            'claveSMS' => $claveSMS,
            'nroMovil' => $nroMovil,
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')
        ));

        log_message('info', 'Salida Crear SMS: ' . $data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId'=> $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada password_operaciones: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));

        return json_encode($desdata);
    }
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //ACTUALIZAR PASSWORD sms
    public function password_sms_actualizar($id_ext_per, $claveSMS, $nroMovil)
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'),$this->session->userdata('userName'),'personasWeb','perfil','clave sms','actualizar clave');

        $data = json_encode(array(
            'idOperation' => '43',
            'className' => 'com.novo.objects.TOs.TarjetaTO',
            'id_ext_per' => $id_ext_per,
            'claveSMS' => $claveSMS,
            'nroMovil' => $nroMovil,
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')
        ));

        log_message('info', 'Salida Actualizar SMS: ' . $data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada password_operaciones: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));

        return json_encode($desdata);
    }
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //ELIMINAR PASSWORD sms
    public function password_sms_eliminar($id_ext_per, $claveSMS, $nroMovil)
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'),$this->session->userdata('userName'),'personasWeb','perfil','clave sms','eliminar clave');

        $data = json_encode(array(
            'idOperation' => '44',
            'className' => 'com.novo.objects.TOs.TarjetaTO',
            'id_ext_per' => $id_ext_per,
            'claveSMS' => $claveSMS,
            'nroMovil' => $nroMovil,
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')

        ));

        log_message('info', 'Salida ELIMINAR SMS: ' . $data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada password_operaciones: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));

        return json_encode($desdata);
    }
    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //ACTUALIZAR PASSWORD DE OPERACIONES
    public function actualizar_password_operaciones($passwordOperacionesOld, $passwordOperaciones)
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'),$this->session->userdata('userName'),'personasWeb','password operaciones','password operaciones','actualizar');

        $data = json_encode(array(
            'idOperation' => '32',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'userName' => $this->session->userdata('userName'),
            'passwordOperacionesOld' => md5($passwordOperacionesOld),
            'passwordOperaciones' => md5($passwordOperaciones),
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')
        ));

        log_message('info', 'Salida Actualizar: ' . $data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada actualizar_password_operaciones: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));
        $salida = json_encode($desdata);

        log_message('info', 'Salida password_operaciones: ' . $salida);

        return json_encode($desdata);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //FUNCION PARA CERRAR SESION
    public function logout()
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'), $this->session->userdata('userName'), 'personasWeb', 'logout', 'logout', 'logout');

        $data = json_encode(array(
            'idOperation' => 'desconectarUsuario',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'userName' => $this->session->userdata('userName'),
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')
        ));

        log_message('info', 'Logout: '.$data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada logout: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        log_message('info', 'Before Logout:----------->>>>>>>>> '.$response);
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));

        return json_encode($desdata);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------


}	//FIN FUNCION GENERAL
