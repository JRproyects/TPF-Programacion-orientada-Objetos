<?php
class Logger {
    private pdo $pdo;
    private string $usuario = "SUPERUSUARIO"; // Fijo para ejemplificar

    public function __construct(pdo $pdo) {
        $this->pdo = $pdo;
    }

    public function registrar(string $entidad, int $idReferencia, string $accion, string $detalle): void {
        $sql = "INSERT INTO log_eventos (entidad, id_referencia, accion, usuario, detalle)
                VALUES (:entidad, :idRef, :accion, :usuario, :detalle)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':entidad' => $entidad,
            ':idRef' => $idReferencia,
            ':accion' => $accion,
            ':usuario' => $this->usuario,
            ':detalle' => $detalle
        ]);
    }

    public function mostrarLogs(): void {
        echo "\n Historial de cambios\n------------------------\n";
        $stmt = $this->pdo->query("SELECT * FROM log_eventos ORDER BY fecha_log DESC");
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($logs)) {
            echo "No hay registros aún.\n";
            return;
        }

        foreach ($logs as $log) {
            echo "[{$log['fecha_log']}] {$log['usuario']} hizo {$log['accion']} en {$log['entidad']} (ID: {$log['id_referencia']}):\n";
            echo "  ↳ {$log['detalle']}\n";
            echo "------------------------\n";
        }
    }
}
