<?php
class Persona
{
    private int    $idPersona;
    private string $pnombre;
    private string $papellido;
    protected array $idViajesColeccion;

    public function __construct($idPersona, $pnombre, $papellido, array $idViajes = [])
    {
        $this->idPersona = $idPersona;
        $this->pnombre = $pnombre;
        $this->papellido = $papellido;
        $this->idViajesColeccion = $idViajes;
    }

    // Getters
    public function getNombre(): string
    {
        return $this->pnombre;
    }

    public function getApellido(): string
    {
        return $this->papellido;
    }

    public function getIdViajesColeccion(): array
    {
        return $this->idViajesColeccion;
    }
    public function getIdPersona()
    {
        return $this->idPersona;
    }

    // Setters
    public function setNombre(string $pnombre): void
    {
        $this->pnombre = $pnombre;
    }

    public function setApellido(string $papellido): void
    {
        $this->papellido = $papellido;
    }

    public function setIdViajesColeccion(array $ids): bool
    {
        $this->idViajesColeccion = $ids;
        return true;
    }
    public function setIdPersona($idUnica)
    {
        $this->idPersona = $idUnica;
    }

    // Metodo para agregar un ID al array de viajes
    public function sumarIdViaje($nuevaIdViaje): bool
    {
        $idsViajesTemp = $this->getIdViajesColeccion();
        $idsViajesTemp[] = $nuevaIdViaje;
        $this->setIdViajesColeccion($idsViajesTemp);
        return true;
    }

    // Metodo para eliminar un ID si existe
    public function restarIdViaje($idViajeAborrar): bool
    {
        $sePudio = false;
        $idsViajesTemp = $this->getIdViajesColeccion();
        $cantIdsViajesTemp = count($idsViajesTemp);
        $i = 0;
        $encontrado = null;

        while ($i < $cantIdsViajesTemp && $encontrado === null) {
            if ($idsViajesTemp[$i] == $idViajeAborrar) {
                $sePudio = true;
                unset($idsViajesTemp[$i]);
                $idsViajesTemp = array_values($idsViajesTemp);
                $this->setIdViajesColeccion($idsViajesTemp);
            }
            $i++;
        }
        return $sePudio;
    }

    // Metodo para mostrar los viajes registrados
    public function verViajes(): string
    {
        $respuesta = "";
        $coleccionViajes = $this->getIdViajesColeccion();
        if (empty($coleccionViajes)) {
            $respuesta = "No tiene viajes registrados.\n";
        } else {
            $respuesta = "Las IDs de viaje son: " . implode(", ", $coleccionViajes) . "\n";
        }
        return $respuesta;
    }

    // Método __toString()
    public function __toString(): string
    {
        $idsViajes = $this->getIdViajesColeccion();
        $idsString = empty($idsViajes) ? "Ninguno" : implode(", ", $idsViajes);
        return "Nombre: {$this->getNombre()} {$this->getApellido()}\n" .
            "Numero Identificador: {$this->getIdPersona()} \n" .
            "ID de viajes: {$idsString}\n";
    }
}
?>