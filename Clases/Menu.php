<?php
include_once "Empresa.php";
include_once "Viaje.php";
include_once "Pasajero.php";
include_once "ResponsableV.php";
include_once "Persona.php";
include_once "img.php";
include_once("BaseDatos.php");
include_once "Logger.php";
$pdo = BaseDatos::getConexion();
$logger = new Logger($pdo);

// Crear empresa base (puede estar vacía o cargada desde DB más adelante)
$objEmpresa = new Empresa(007, "QuieroAprobarPorFavorINC.", "Av. Siempre Viva 123", [], [], []);

// Instancia base
//funciones-
function agregarEmpresa($objEmpresa)
{
    echo "ingrese los datos para nuevo viaje:\n";
    echo "Destino: ";
    $destino = trim(fgets(STDIN));
    echo "Cantidad máx pasajeros: ";
    $cant = trim(fgets(STDIN));
    echo "Precio: ";
    $precio = trim(fgets(STDIN));
    echo "Licencia de Responsable\n";
    echo "Ingresar numero licencia o \n";
    echo "si desea puede ver el listado de Responsables ingresando !responsables\n";
    $responsable = trim(fgets(STDIN));
    if ($responsable == "!responsables") {
        print_r($objEmpresa->getColeccionResponsables());
        echo "Ingrese la licencia del responsable elegido";
        $responsable = trim(fgets(STDIN));
    }
    $responsable = $objEmpresa->getResponsableByLicencia($responsable);
    $objEmpresa->crearAgregarViaje($destino, $cant, $responsable, $precio);
    echo "Viaje agregado\n";
    return;
}


// Inicio del programa

function menuPrincipal($objEmpresa, $logger)
{
    $terminar = true;
    do {
        echo "\n====== Menú Principal ======\n";
        echo "1. Ingresar a Menu Administrativo\n";
        echo "2. Ingresar a Menu Cliente\n";
        echo "3. Historial de cambios para auditorias.\n"; //Esto llama el chages log 
        echo "4. Salir e Imagen random\n";
        echo "Seleccione una opción: ";
        $opcion = trim(fgets(STDIN));

        switch ($opcion) {
            case "1":
                menuAdministrativo($objEmpresa, $logger);
                break;
            case "2":
                menuCliente();
                break;
            case "3":
                $logger->mostrarLogs();
                break;
            case "4":
                $img = new Img();
                echo $img;
                $terminar = false;
                break;
            default:
                echo "Opción inválida. Intente de nuevo.\n";
        }
    } while ($terminar);
}

function menuAdministrativo($objEmpresa, $logger)
{
    $salir1 = true;
    do {
        echo "--------Menu Administrativo--------\n";
        echo "1. Ver Empresa\n";
        echo "2. Ver Viajes Agendados\n";   //donde
        echo "3. Ver listado de Pasajeros\n";
        echo "4. Ver listado de Responsables\n";
        echo "5. Realizar Modificaciones\n";
        echo "6. Regresar Menu Principal\n";
        echo "Seleccione una opción: ";
        $salida1 = 0;
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case "1":
                echo $objEmpresa . "\n";
                echo "¿Desea realizar cambios? (si/no): ";
                $respuesta = trim(fgets(STDIN));
                if ($respuesta == "si") {
                    modificarEmpresa($objEmpresa);
                } else {
                    return;
                }
                break;
            case "2":
                print_r($objEmpresa->getViajesColeccion());
                break;
            case "3":
                print_r($objEmpresa->getPasajerosColeccion());
                break;
            case "4":
                print_r($objEmpresa->getEmpleadosColeccion());
                break;
            case "5":
                modificarEmpresa($objEmpresa);
                break;
            case "6":
                menuPrincipal($objEmpresa, $logger);
                break;
            default:
                echo "Opción inválida.\n";
                return;
        }
    } while ($salida1);
}

function menuCliente()
{
    do {
        echo "\n------------ Menú Cliente -----------\n";
        echo "1. Ver Viajes\n";
        echo "2. Volver al Menú Principal\n";
        echo "Seleccione una opción: ";
        $opcion = trim(fgets(STDIN));

        switch ($opcion) {
            case "1":
                echo "(Lista de viajes aquí)\n";
                break;
            case "2":
                return;
            default:
                echo "Opción inválida.\n";
        }
    } while (true);
}

function paraAtrasOInicio($objEmpresa, $logger)
{
    echo "¿Qué decea hacer?\n";
    echo "1. Regrasar Menu inicial\n";
    echo "2. Regrasar Menu previo\n";
    $respuesta = trim(fgets(STDIN));
    if ($respuesta == "1") {
        menuPrincipal($objEmpresa, $logger);
    } else {
        return;
    }
}

function modificarEmpresa($objEmpresa)
{
    $salir = true;
    do {
        echo "¿Qué dato quiere modificar?\n";
        echo "1. Dirección\n";
        echo "2. Nombre\n";
        echo "3. Colección de viajes\n";
        echo "4. Colección de clientes (no implementado)\n";
        echo "Seleccione una opción: \n";

        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case "1":
                echo "Nueva dirección: ";
                $nueva = trim(fgets(STDIN));
                $objEmpresa->setEDireccion($nueva);
                echo "Dirección actualizada.\n";
                $salir = false;
                break;
            case "2":
                echo "Nuevo nombre: ";
                $nuevo = trim(fgets(STDIN));
                $objEmpresa->setEnombre($nuevo);
                echo "Nombre actualizado.\n";
                $salir = false;
                break;
            case "3":
                modificarViajes($objEmpresa);
                break;
            case "4":
                echo "Función aún no implementada.\n";
                break;
            default:
                echo "Opción inválida.\n";
        }
    } while ($salir);
}

function modificarViajes($objEmpresa)
{
    echo "¿Qué desea hacer?";
    echo "1. Agregar un viaje\n"; //done
    echo "2. Eliminar un viaje\n"; //done
    echo "3. Ingresar Responsable\n"; //done
    echo "4. Eliminar Responsable\n";
    echo "5. Ingresar Pasajero\n"; //done
    echo "6. Eliminar Pasajero\n";
    echo "7. Regresar Menu anterior\n";
    echo "Seleccione una opción: ";
    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case "1":
            agregarEmpresa($objEmpresa);
            break;
        case "2":
            echo "Ingrese la Id del viaje a eliminar\n"; //Esta es la parte que se complica mas, porque hay que eliminar en la empresa y en las personas. 
            $idViajeAEliminar = trim(fgets(STDIN));
            $objEmpresa->nukeViaje($idViajeAEliminar);
            echo "Ese Viaje ha sido exterminado\n";
            return;
        case "3":
            echo "Ingrese los datos del nuevo Responsable";
            echo "ID \n";
            $idResponsable = trim(fgets(STDIN));
            echo "Nombre\n";
            $nombre = trim(fgets(STDIN));
            echo "Apellido\n";
            $apellido = trim(fgets(STDIN));
            echo "Matricula\n";
            $matricula = trim(fgets(STDIN));
            $objEmpresa->onsable($idResponsable, $nombre, $apellido, $matricula);
            echo "Nuevo responsable agregado\n";
            return;
            break;
        case "4":
            break;
        case "5":
            echo "Ingrese los datos del nuevo Pasajero\n";
            echo "ID\n";
            $idPasajero = trim(fgets(STDIN));
            echo "Nombre\n";
            $nombre = trim(fgets(STDIN));
            echo "Apellido\n";
            $apellido = trim(fgets(STDIN));
            echo "Documento\n";
            $doc = trim(fgets(STDIN));
            echo "Telefono\n";
            $tel = trim(fgets(STDIN));
            $objEmpresa->crearAgregarPasajero($idPasajero, $nombre, $apellido, $doc, $tel,);
            echo "Cliente ajendado\n";
            return;
            break;
        case "6":
            echo "ingrese el Numero de Documento del Pasajero a eliminar\n";
            $doc = trim(fgets(STDIN));

        default:
            echo "Opción inválida.\n";
    }
}

menuPrincipal($objEmpresa, $logger);
