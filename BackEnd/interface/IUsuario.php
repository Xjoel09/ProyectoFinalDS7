<?php
interface IUsuario {
    public function login($usuario, $password);
    public function logout();
    public function cambiarPassword($newPassword);
    public function eliminarCuenta();
}