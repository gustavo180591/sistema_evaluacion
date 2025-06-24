<?php

class TestsSeeder {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function run() {
        $tests = [
            [
                'nombre_test' => 'Test de Fuerza de Agarre',
                'descripcion' => "También conocido como test de prensión manual o prueba de fuerza de agarre de mano, evalúa la fuerza isométrica de los músculos de la mano y el antebrazo. Es una prueba sencilla y rápida que se utiliza para evaluar la fuerza muscular, identificar debilidades y evaluar la salud general.\n\nCÓMO SE REALIZA LA PRUEBA:\n- Posición: Sentado con el hombro en aducción, el codo flexionado a 90 grados y el antebrazo y la muñeca en posición neutra.\n- Dinamómetro: Se coloca el dinamómetro en la mano, sujetando suavemente la base.\n- Apretón: Se aprieta el dinamómetro con la máxima fuerza posible.\n- Mediciones: Se realizan tres apretones con cada mano y se registra la lectura máxima.\n- Cálculo: Se calcula un promedio de las mediciones de ambas manos."
            ],
            [
                'nombre_test' => 'Test de Salto Vertical',
                'descripcion' => "Se utiliza para medir la altura que un atleta puede saltar desde una posición estática.\n\nPROCEDIMIENTO:\n1. El atleta se coloca de pie junto a una pared o dispositivo de medición.\n2. Con los pies separados al ancho de los hombros.\n3. Se extiende el brazo hacia arriba para marcar la altura de alcance estático.\n4. Desde la posición en cuclillas, salta verticalmente lo más alto posible.\n5. Se mide la diferencia entre el alcance estático y el salto."
            ],
            [
                'nombre_test' => 'Test de Salto con Contramovimiento',
                'descripcion' => "Una prueba que evalúa la capacidad de un atleta para absorber y luego reutilizar la energía del aterrizaje para generar un salto vertical.\n\nPROCEDIMIENTO:\n1. El atleta se para derecho con los pies al ancho de los hombros.\n2. Realiza un contramovimiento rápido (flexión de rodillas).\n3. Inmediatamente salta verticalmente lo más alto posible.\n4. Se mide la altura del salto."
            ],
            [
                'nombre_test' => 'Test de Salto de Longitud',
                'descripcion' => "Los atletas deben saltar la mayor distancia posible desde una línea de despegue.\n\nPROCEDIMIENTO:\n1. El atleta se coloca detrás de la línea de despegue.\n2. Realiza un salto hacia adelante con impulso.\n3. Aterriza con ambos pies juntos.\n4. Se mide desde la línea de despegue hasta el punto de aterrizaje más cercano."
            ],
            [
                'nombre_test' => 'Test de Preferencia Motriz',
                'descripcion' => "Evaluación que busca determinar cuál es la mano o el lado del cuerpo que una persona tiende a usar con mayor facilidad y precisión en diferentes tareas motoras.\n\nPRUEBAS INCLUIDAS:\n1. Escribir o dibujar\n2. Lanzar una pelota\n3. Cepillarse los dientes\n4. Recoger un objeto pequeño\n5. Abrir una puerta"
            ],
            [
                'nombre_test' => 'Test de Lateralidad Visual',
                'descripcion' => "Evalúan la preferencia por un ojo (izquierdo o derecho) para realizar tareas que requieren coordinación visomotora.\n\nPROCEDIMIENTO:\n1. El evaluador sostiene un objeto pequeño con ambas manos.\n2. El participante debe mirar a través de un agujero formado por las manos del evaluador.\n3. Se registra qué ojo se usa espontáneamente para mirar a través del agujero."
            ],
            [
                'nombre_test' => 'Test de Lateralidad Podal',
                'descripcion' => "Evalúan la preferencia por un pie (derecho o izquierdo) para realizar tareas que requieren equilibrio y control motor.\n\nPRUEBAS INCLUIDAS:\n1. Patear un balón\n2. Subir un escalón\n3. Mantener el equilibrio en un pie\n4. Dar pequeños saltos en un pie"
            ],
            [
                'nombre_test' => 'Test de Wells',
                'descripcion' => "Evaluación de la flexibilidad, especialmente de los isquiotibiales y la zona baja de la espalda. Se utiliza para medir la amplitud de movimiento de las articulaciones de la cadera y la columna lumbar.\n\nPROCEDIMIENTO:\n1. El participante se sienta con las piernas extendidas y los pies juntos.\n2. Se inclina hacia adelante, intentando alcanzar la mayor distancia posible con las manos, sin doblar las rodillas.\n3. Se mide la distancia alcanzada desde los pies en centímetros."
            ],
            [
                'nombre_test' => 'Test de Velocidad 20m',
                'descripcion' => "Mide la velocidad de un individuo en una distancia de 20 metros.\n\nPROCEDIMIENTO:\n1. El atleta se coloca en la línea de salida en posición de arranque.\n2. A la señal, corre a máxima velocidad los 20 metros.\n3. Se registra el tiempo con un cronómetro o sistema de tiempo electrónico.\n\nVARIACIONES:\n- Salida parado\n- Salida en movimiento\n- Con y sin calentamiento previo"
            ]
        ];
        
        foreach ($tests as $test) {
            $this->db->query(
                "INSERT INTO tests (nombre_test, descripcion) VALUES (?, ?)",
                [$test['nombre_test'], $test['descripcion']]
            );
        }
    }
}
