<?php
class Empresa
{
    private int $idEmpresa;
    private string $enombre;
    private string $eDireccion;
    private array $viajesColeccion = [];
    private array $pasajerosColeccion = [];
    private array $empleadosColeccion = [];

    // Constructor
    public function __construct(int $idEmpresa, string $enombre, string $eDireccion, array $viajes, array $pasajeros, array $empleados)
    {
        $this->idEmpresa = $idEmpresa;
        $this->enombre = $enombre;
        $this->eDireccion = $eDireccion;
        $this->viajesColeccion = $viajes;
        $this->pasajerosColeccion = $pasajeros;
        $this->empleadosColeccion = $empleados;
    }

    // Getterss
    public function getIdEmpresa(): int
    {
        return $this->idEmpresa;
    }

    public function getEnombre(): string
    {
        return $this->enombre;
    }

    public function getEDireccion(): string
    {
        return $this->eDireccion;
    }
    public function getViajesColeccion(): array
    {
        return $this->viajesColeccion;
    }
    public function getPasajerosColeccion()
    {
        return $this->pasajerosColeccion;
    }
    public function getEmpleadosColeccion()
    {
        return $this->empleadosColeccion;
    }

    // Setters
    public function setIdEmpresa(int $idEmpresa): void
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function setEnombre(string $enombre): void
    {
        $this->enombre = $enombre;
    }

    public function setEDireccion(string $eDireccion): void
    {
        $this->eDireccion = $eDireccion;
    }

    public function setViajesColeccion(array $viajes)
    {
        $this->viajesColeccion = $viajes;
    }

    public function setPasajerosColeccion(array $pasajeros)
    {
        $this->pasajerosColeccion = $pasajeros;
    }
    public function setEmpleadosColeccion($empleados)
    {
        $this->empleadosColeccion = $empleados;
    }
    public function __toString()
    {
        return "Empresa ID: {$this->idEmpresa}\n" .
            "Nombre: {$this->enombre}\n" .
            "Dirección: {$this->eDireccion}\n" .
            "Viajes: " . count($this->viajesColeccion) . "\n" .
            "Pasajeros: " . count($this->pasajerosColeccion) . "\n" .
            "Empleados: " . count($this->empleadosColeccion) . "\n";
    }



    //Otra funcion para poder agregar un viaje en la empresa

    public function agregarViajes(Viaje $viaje)
    {
        $viajesTemp = $this->getViajesColeccion();
        $viajesTemp[] = $viaje;
        $this->setViajesColeccion($viajesTemp);
        return true;
    }
    // funcion para agregar a la Empresa, pensado para agregar el pasajero a la vez que se agrega en el viaje
    public function agregarPasajero($pasajero)
    {
        $pasajerosTemp = $this->getPasajerosColeccion();
        $pasajerosTemp[] = $pasajero;
        $this->setPasajerosColeccion($pasajerosTemp);
        return true;
    }

    public function crearAgregarPasajero($id, $nombre, $apellido, $doc, $tel)
    {
        $objPasajero = new Pasajero($id, $nombre, $apellido, $doc, $tel, []);
        $this->agregarPasajero($objPasajero);
        return $objPasajero;
    }

    //para agregar un pasajero a un viaje, primero ver si esta en la base de pasajeros de la empresa.


    //Metodo para encontrar viaje por id. Esta en Empresa porque en esta es que esta el array de los viajes.
    public function getViajeByID(int $id)
    {

        $viajesTemp = $this->getViajesColeccion();
        $i = 0;
        $cantViajes = count($viajesTemp);
        $encontradoViaje = null;

        while ($i < $cantViajes && $encontradoViaje == null) {
            if ($viajesTemp[$i]->getIdViaje() === $id) {
                $encontradoViaje = $viajesTemp[$i];
            }
            $i++;
        }
        return $encontradoViaje;
    }

    public function getResponsableByLicencia($licenciaResponsable)
    {
        $empleadosColeccionTemp = $this->getEmpleadosColeccion();
        $i = 0;
        $cantEmpleadosTemp = count($empleadosColeccionTemp);
        $encontradoEmpleado = null;
        while ($i < $cantEmpleadosTemp && $encontradoEmpleado == null) {
            if ($empleadosColeccionTemp[$i]->getRnumeroLicencia() == $licenciaResponsable) {
                $encontradoEmpleado = $empleadosColeccionTemp[$i];
            }
            $i++;
        }
        return $encontradoEmpleado;
    }
    //Metodo para Mostrar los viajes, te muestra todos los arrays para que tomes nota 
    public function mostrarViajes(): string
    {
        $viajesTemp = $this->getViajesColeccion();
        $viajesTempString = empty($viajesTemp) ? "Ninguno" : implode(", ", $viajesTemp);
        return $viajesTempString;
    }


    //Esto de tomar el array completo para volver a setearlo puede funcionar a pequeña escala pero tiene que haber una mejor manera. 
    //Metodo para crear un viaje nuevo desde la empresa asignado cosas de manera automatica.
    public function crearAgregarViaje($destino, $maxPasajero, $responsable, $importe): bool
    {
        $idV = count($this->getViajesColeccion()) + 1; //Si, mas corto porque si. //encontramos la nueva id para el viaje:   
        $idE = $this->getIdEmpresa();
        $objViaje = new Viaje($idV, $destino, $maxPasajero, $idE, $responsable, $importe, []);
        $this->agregarViajes($objViaje);
        return true;
    }

    //Metodo para solo agregar un responsable. 

    public function agregarResponsable(ResponsableV $empleadoNuevo)
    {
        $empleadosTemp = $this->getEmpleadosColeccion();
        $empleadosTemp[] = $empleadoNuevo;
        $this->setEmpleadosColeccion($empleadosTemp);
        return true;
    }


    public function eliminarEmpleado(ResponsableV $empleado)
    {
        $empleadosTemp = $this->getEmpleadosColeccion();
        $sePudio = false;
        $cantEmpleados = count($empleadosTemp);
        $i = 0;
        $encontrado = null;
        while ($i < $cantEmpleados && $encontrado == null) {
            if ($empleadosTemp[$i] == $empleado) {
                $sePudio = true;
                unset($empleadosTemp[$i]);
                $empleadosTemp = array_values($empleadosTemp);
                $this->setPasajerosColeccion($empleadosTemp);
            }
            $i++;
        }
        return $sePudio;
    }

    public function eliminarPasajero(Pasajero $pasajero)
    {
        $pasajerosTemp = $this->getPasajerosColeccion();
        $sePudo = false;
        $cantPasajeros = count($pasajerosTemp);
        $i = 0;
        $encontrado = null;

        while ($i < $cantPasajeros && $encontrado == null) {
            if ($pasajerosTemp[$i] == $pasajero) {
                $sePudo = true;
                unset($pasajerosTemp[$i]);
                $pasajerosTemp = array_values($pasajerosTemp); // Reindexar
                $this->setPasajerosColeccion($pasajerosTemp);
                $encontrado = true; // Detener el bucle
            }
            $i++;
        }

        return $sePudo;
    }


    public function eliminarViaje(Viaje $objViaje) //Esto elimina los viajes del array viajes.. 
    {
        $coleccionViajesTemp = $this->getViajesColeccion();
        $sePudio = false;
        $cantViajes = count($coleccionViajesTemp);
        $i = 0;
        $encontrado = null;
        while ($i < $cantViajes && $encontrado == null) {
            if ($coleccionViajesTemp[$i] == $objViaje) {
                $sePudio = true;
                unset($coleccionViajesTemp[$i]);
                $coleccionViajesTemp = array_values($coleccionViajesTemp);
                $this->setPasajerosColeccion($coleccionViajesTemp);
            }
            $i++;
        }
        return $sePudio;
    }
    // TODO: revisar esta función. ¿Está restando correctamente el viaje de cada persona?
    public function eliminarViajeDePersonas(array $personas, $idViaje)
    {
        foreach ($personas as $objPersona) {
            $objPersona->restarIdViaje($idViaje);
        }
    }




    public function separaPorViaje(array $personas, $idViaje)
    {
        $personasConEseViaje = [];
        foreach ($personas as $objPersona) {
            $viajesDePersonaTemp = $objPersona->getIdViajesColeccion();
            $cantViajes = count($viajesDePersonaTemp);
            $i = 0;
            $e = null;
            while ($i < $cantViajes && $e == null) {
                if ($viajesDePersonaTemp[$i] == $idViaje) {
                    $personasConEseViaje[] = $objPersona;
                    $e = true;
                }
                $i++;
            }
        }
        return $personasConEseViaje;
    }



    //Tambien crear responsable desde empresa. 

    public function crearAgregarResponsable($id, $nombre, $apellido, $matricula): ResponsableV
    {
        $idE = $this->getIdEmpresa();
        $numEmpleado = count($this->getEmpleadosColeccion()) + 1;

        $objEmpleado = new ResponsableV($id, $nombre, $apellido, $numEmpleado, $matricula, [], $idE);
        $this->agregarResponsable($objEmpleado);
        return $objEmpleado;
    }

    public function mostrarResponsables()
    {
        $responsables = $this->getEmpleadosColeccion();
        $texto = "Listado de Responsables:\n";

        foreach ($responsables as $index => $responsable) {
            $texto .= "Responsable " . ($index + 1) . ":\n";
            $texto .= $responsable . "\n";
            $texto .= str_repeat("-", 30) . "\n"; // separador
            return $texto;
        }
    }
    public function nukeViaje($idViaje)
    {
        $coleccionPasajerosTemp = $this->getPasajerosColeccion();
        $coleccionResponsablesTemp = $this->getEmpleadosColeccion();
        $objViajeTemp = $this->getViajeByID($idViaje);
        $coleccionEmpleadosViaje = $this->separaPorViaje($coleccionResponsablesTemp, $idViaje);
        $coleccionPasajerosViaje = $this->separaPorViaje($coleccionPasajerosTemp, $idViaje);
        $this->eliminarViajeDePersonas($coleccionPasajerosViaje, $idViaje);
        $this->eliminarViajeDePersonas($coleccionEmpleadosViaje, $idViaje);
        $this->eliminarViaje($objViajeTemp);
        return true;
    }

    public function getPasajeroByDoc($doc)
    {
        $coleccionPasajerosTemp = $this->getPasajerosColeccion();
        $i = 0;
        $e = null;
        $cantPasajeros = count($coleccionPasajerosTemp);
        while ($i < $cantPasajeros && $e == null) {
            if (($coleccionPasajerosTemp[$i]->getPdocumento()) == $doc) {
                $e = $coleccionPasajerosTemp[$i];
            }
        }
        return $e;
    }
    /* Que hace este metodo: 
    Tiene que encontrar todos los viajes que posean un determinado pasajero 
    ¿Que regresa? Un array de viajes 
    ¿Como lo hace? 
    Tien que recorrer todos los voajes para saber si en cada uno esta el pasajero 
    Cuando toma cada coleccion de pasajero de cada viaje, la recorre hasta encontrar el pasajero o pasar al siguiente viaje
    Si lo encuentra en ese viaje, se agrega al array de retorno*/
    public function encontrarViajesConPasajero($pasajero)
    {
        $viajesColeccionTemp = $this->getViajesColeccion();
        $viajesRetorno = [];
        foreach ($viajesColeccionTemp as $objViaje) {
            $pasajerosTemp = $objViaje->getPasajerosColeccion();
            $i = 0;
            $e = null;
            while ($i < count($pasajerosTemp) && $e == null) {
                if ($pasajerosTemp[$i] == $pasajero) {
                    $e = $pasajerosTemp[$i];
                    $viajesRetorno[] = $objViaje;
                }
                $i++;
            }
        }
        return $viajesRetorno;
    }

    public function nukePasajero($doc)
    { //se elimina el pasajero en el array de la empresa y en todos los viajes. 
        $pasajeroAEliminar = $this->getPasajeroByDoc($doc);
        $viajesConPAsajero = $this->encontrarViajesConPasajero($pasajeroAEliminar);
        $viajesTemp = $this->getViajesColeccion();
        $idViajesABorrar = [];
        $viajesSinPasajero = [];

        foreach ($viajesConPAsajero as $viajeTempDelete) {
            $viajeTempDelete->restarPasajero($pasajeroAEliminar);
            $idViajesABorrar[] = $viajeTempDelete->getIdEmpresa();
            $viajesSinPasajero[] = $viajeTempDelete;
        }

        foreach ($idViajesABorrar as $viajeABorrar) {
            $viajeABorrarTemp = $this->getViajeByID($viajeABorrar);
            $this->eliminarViaje($viajeABorrarTemp);
        }
        $viajesTemp = $this->getViajesColeccion();
        $viajesTemp[] = array_merge($viajesTemp, $viajesSinPasajero);
        $this->setViajesColeccion($viajesTemp);
        $this->eliminarPasajero($pasajeroAEliminar);
        return true;
    }
}
