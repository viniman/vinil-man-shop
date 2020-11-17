<?php

namespace App\Controllers;
use app\core\App;

class UserController{

    public function index()
    {
        $users = App::get('database')->selectAll('users');

        return view('admin/usuario', compact('users'));
    }

    public function create()
    {
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $parameters = ([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $hash
        ]);

        App::get('database')->insert('users',$parameters);

        header('Location: /admin/usuario');
    }

    public function delete()
    {
        $id = $_POST['id'];

        App::get('database')->delete('users', $id);

        header('Location: /admin/usuario');
    }

}

?>