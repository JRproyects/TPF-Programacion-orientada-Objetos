<?php
class Viaje
{

    //Para hacer esto tendria que meter un contador para que me de un id unico sin problema ¿No? Si, pero desde empresa creo
    // un viaje puede tener un solo ID. 
    private int $idviaje;
    private string $vdestino;
    private int $vcantmaxpasajeros;
    private int $idEmpresa; //Esto esta mal, esta metiendo toda una empresa, no puede ser.
    private ResponsableV $rnumeroEmpleado;
    private float $vimporte;
    private array $pasajerosColeccion = [];

    // Constructor
    public function __construct(int $idviaje, string $vdestino, int $vcantmaxpasajeros, int $idEmpresa, ResponsableV $rnumeroEmpleado, float $vimporte, array $pasajeros = [])
    {
        $this->idviaje = $idviaje;
        $this->vdestino = $vdestino;
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
        $this->idEmpresa = $idEmpresa;
        $this->rnumeroEmpleado = $rnumeroEmpleado;
        $this->vimporte = $vimporte;
        $this->pasajerosColeccion = $pasajeros;
    }

    // Getters
    public function getIdViaje(): int
    {
        return $this->idviaje;
    }

    public function getDestino(): string
    {
        return $this->vdestino;
    }
    public function getCantMaxPasajeros(): int
    {
        return $this->vcantmaxpasajeros;
    }

    public function getIdEmpresa(): int
    {
        return $this->idEmpresa;
    }

    public function getNumeroEmpleado(): ResponsableV
    {
        return $this->rnumeroEmpleado;
    }

    public function getImporte(): float
    {
        return $this->vimporte;
    }

    public function getPasajerosColeccion(): array
    {
        return $this->pasajerosColeccion;
    }

    // Setters
    public function setIdViaje(int $idviaje): void
    {
        $this->idviaje = $idviaje;
    }

    public function setDestino(string $vdestino): void
    {
        $this->vdestino = $vdestino;
    }

    public function setCantMaxPasajeros(int $vcantmaxpasajeros): void
    {
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
    }

    public function setIdEmpresa(int $idEmpresa): void
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function setNumeroEmpleado(ResponsableV $rnumeroEmpleado): void
    {
        $this->rnumeroEmpleado = $rnumeroEmpleado;
    }

    public function setImporte(float $vimporte): void
    {
        $this->vimporte = $vimporte;
    }

    public function setPasajerosColeccion(array $pasajeros): void
    {
        $this->pasajerosColeccion = $pasajeros;
    }

    // funcion agregar un pasajero

    public function agregarPasajero(Pasajero $pasajero)
    { //me falta el poner 
        $posible = false;
        $pasajerosTemp = $this->getPasajerosColeccion();
        if (count($pasajerosTemp) < $this->getCantMaxPasajeros()) {
            $pasajerosTemp[] = $pasajero;
            $this->setPasajerosColeccion($pasajerosTemp);
            $posible = true;
        }
        return $posible;
    }
    // Metodo para eliminar un pasajero. 
    public function restarPasajero(Pasajero $pasajero): bool
    {
        $sePudio = false;
        $pasajerosTemp = $this->getPasajerosColeccion();
        $cantPasajerosTemp = count($pasajerosTemp);
        $i = 0;
        $encontrado = null;

        while ($i < $cantPasajerosTemp && $encontrado === null) {
            if ($pasajerosTemp[$i] == $pasajero) {
                $sePudio = true;
                unset($pasajerosTemp[$i]);
                $pasajerosTemp = array_values($pasajerosTemp);
                $this->setPasajerosColeccion($pasajerosTemp);
            }
            $i++;
        }
        return $sePudio;
    }

    // Método toString
    public function __toString(): string
    {
        $info = "ID Viaje: {$this->getIdViaje()}\n";
        $info .= "Destino: {$this->getDestino()}\n";
        $info .= "Cantidad Máxima de Pasajeros: {$this->getCantMaxPasajeros()}\n";
        $info .= "Importe: {$this->getImporte()}\n";
        $info .= "Empresa: {$this->getIdEmpresa()}\n";
        $info .= "Responsable: {$this->getNumeroEmpleado()}\n";
        $info .= "Pasajeros:\n";

        $pasajeros = $this->getPasajerosColeccion();
            if (empty($pasajeros)) {
            $info .= "No hay pasajeros registrados.\n";
            } else {
            foreach ($pasajeros as $index => $pasajero) {
            $info .= ($index + 1) . ". " . $pasajero . "\n"; // Asume que Pasajero tiene __toString()
                }
        }

        return $info;
    }

    public function hayEspacioDisponible(): bool
    {
        return count($this->getPasajerosColeccion()) < $this->getCantMaxPasajeros();
    }

    public function buscarPasajeroPorDoc($doc): Pasajero
    {
        $pasajeros = $this->getPasajerosColeccion();
        $cantPasajeros = count($pasajeros);
        $i = 0;
        $encontrado = null;

        while ($i < $cantPasajeros && $encontrado === null) {
            if ($pasajeros[$i]->getPdocumento() === $doc) {
                $encontrado = $pasajeros[$i];
            }
            $i++;
        }

        return $encontrado;
    }
}
