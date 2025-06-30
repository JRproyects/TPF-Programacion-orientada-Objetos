<?php
include_once "Persona.php";
class Pasajero extends Persona {
    private string $pdocumento;
    private string $ptelefono;

    public function __construct(
        int $idPersona,
        string $pnombre,
        string $papellido,
        string $pdocumento,
        string $ptelefono,
        array $idViajes = []
    ) {
        parent::__construct($idPersona, $pnombre, $papellido, $idViajes);
        $this->pdocumento = $pdocumento;
        $this->ptelefono = $ptelefono;
    }

    public function getPdocumento(): string {
        return $this->pdocumento;
    }

    public function getPtelefono(): string {
        return $this->ptelefono;
    }

    public function setPdocumento(string $pdocumento): bool {
        $this->pdocumento = $pdocumento;
        return true;
    }

    public function setPtelefono(string $ptelefono): bool {
        $this->ptelefono = $ptelefono;
        return true;
    }

    public function __toString(): string {
        return parent::__toString() .
               "Documento: {$this->getPdocumento()}\n" .
               "Teléfono: {$this->getPtelefono()}\n";
    }
}
