<?php 
include_once "Persona.php";
include_once "Empresa.php";
include_once "Viaje.php";
class ResponsableV extends Persona {
    private int $rnumeroempleado;
    private int $rnumerolicencia;
    private int $idEmpresa;

public function __construct(
    int $idPersona, 
    string $pnombre, 
    string $papellido, 
    int $rnumeroempleado, 
    int $rnumerolicencia, 
    int $idEmpresa, 
    array $idViajes = []
) {
    parent::__construct($idPersona, $pnombre, $papellido, $idViajes);
    $this->rnumeroempleado = $rnumeroempleado;
    $this->rnumerolicencia = $rnumerolicencia;
    $this->idEmpresa = $idEmpresa;
}

    public function getRnumeroempleado(): int {
        return $this->rnumeroempleado;
    }

    public function setRnumeroempleado(int $rnumeroempleado): void {
        $this->rnumeroempleado = $rnumeroempleado;
    }

    public function getRnumerolicencia(): int {
        return $this->rnumerolicencia;
    }

    public function setRnumerolicencia(int $rnumerolicencia): void {
        $this->rnumerolicencia = $rnumerolicencia;
    }

    public function getIdEmpresaEmpleado(): int {
        return $this->idEmpresa;
    }

    public function setIdEmpresa(int $idEmpresa): void {
        $this->idEmpresa = $idEmpresa;
    }

    public function __toString(): string {
        return parent::__toString() .
               "Empleado N°: {$this->getRnumeroempleado()}\n" .
               "Licencia N°: {$this->getRnumerolicencia()}\n" .
               "ID empresa contratante: {$this->getIdEmpresaEmpleado()}\n";
    }
}
