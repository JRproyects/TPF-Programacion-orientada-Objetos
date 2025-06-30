<?php
class BaseDatos {
    private static ?PDO $conexion = null;

    public static function getConexion(): PDO {
        if (self::$conexion === null) {
            try {
                self::$conexion = new PDO("mysql:host=localhost;dbname=bdviajes;charset=utf8", "root", "Percy17");
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error al conectar con la base de datos: " . $e->getMessage());
            }
        }
        return self::$conexion;
    }
}
