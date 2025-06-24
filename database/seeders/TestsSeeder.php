<?php

class TestsSeeder {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    private function createTest($testData) {
        $formatoTest = isset($testData['formato_test']) ? json_encode($testData['formato_test'], JSON_UNESCAPED_UNICODE) : null;
        
        $this->db->query(
            "INSERT INTO tests (nombre_test, descripcion, formato_test) VALUES (?, ?, ?)",
            [$testData['nombre_test'], $testData['descripcion'], $formatoTest]
        );
    }
    
    public function run() {
        $tests = [
            [
                'nombre_test' => 'Test de Fuerza de Agarre',
                'descripcion' => "También conocido como test de prensión manual o prueba de fuerza de agarre de mano, evalúa la fuerza isométrica de los músculos de la mano y el antebrazo. Es una prueba sencilla y rápida que se utiliza para evaluar la fuerza muscular, identificar debilidades y evaluar la salud general.",
                'formato_test' => [
                    'tipo' => 'Fuerza',
                    'unidad' => 'kg',
                    'procedimiento' => [
                        'El evaluador ajusta el dinamómetro según el tamaño de la mano del evaluado.',
                        'El participante se sienta con el hombro en aducción, codo flexionado a 90° y muñeca en posición neutra.',
                        'Se realiza el agarre del dinamómetro con la mano dominante.',
                        'A la orden, el participante aprieta el dinamómetro con la máxima fuerza posible durante 3-5 segundos.',
                        'Se registra la medición en kilogramos.',
                        'Se repite el procedimiento 3 veces con cada mano, con 1 minuto de descanso entre intentos.'
                    ],
                    'consideraciones' => [
                        'Asegurar que el dinamómetro esté calibrado correctamente.',
                        'El evaluador debe sostener el dinamómetro para evitar caídas.',
                        'No realizar movimientos bruscos con el brazo durante la medición.',
                        'Realizar un calentamiento previo de la mano y muñeca.'
                    ]
                ]
            ],
            [
                'nombre_test' => 'Test de Salto Vertical',
                'descripcion' => "Evalúa la potencia del tren inferior midiendo la altura máxima que puede alcanzar un atleta en un salto vertical desde posición estática.",
                'formato_test' => [
                    'tipo' => 'Potencia',
                    'unidad' => 'cm',
                    'procedimiento' => [
                        'El atleta se coloca de pie junto a una pared o dispositivo de medición.',
                        'Con los pies separados al ancho de los hombros.',
                        'Se extiende el brazo hacia arriba para marcar la altura de alcance estático.',
                        'Desde la posición en cuclillas, salta verticalmente lo más alto posible.',
                        'Se mide la diferencia entre el alcance estático y el punto más alto alcanzado en el salto.'
                    ],
                    'consideraciones' => [
                        'Realizar un calentamiento previo adecuado.',
                        'Asegurar una superficie antideslizante.',
                        'Permitir al menos dos intentos con un minuto de descanso entre ellos.',
                        'Registrar el mejor de dos intentos válidos.'
                    ]
                ]
            ],
            [
                'nombre_test' => 'Test de Salto con Contramovimiento',
                'descripcion' => "Evalúa la capacidad de utilizar el ciclo de estiramiento-acortamiento para generar fuerza explosiva en el salto vertical.",
                'formato_test' => [
                    'tipo' => 'Potencia Reactiva',
                    'unidad' => 'cm',
                    'procedimiento' => [
                        'El atleta se para derecho con los pies al ancho de los hombros.',
                        'Realiza un contramovimiento rápido (flexión de rodillas a aproximadamente 90°).',
                        'Inmediatamente salta verticalmente lo más alto posible.',
                        'Se mide la altura del salto desde la posición inicial hasta el punto más alto alcanzado.'
                    ],
                    'consideraciones' => [
                        'Evitar balanceo de brazos para aislar el movimiento de piernas.',
                        'Mantener la espalda recta durante el movimiento.',
                        'Realizar 3 intentos con 1-2 minutos de recuperación.',
                        'Registrar el mejor de los intentos válidos.'
                    ]
                ]
            ],
            [
                'nombre_test' => 'Test de Salto de Longitud',
                'descripcion' => "Evalúa la potencia de las extremidades inferiores en un plano horizontal, midiendo la distancia máxima alcanzada en un salto con impulso.",
                'formato_test' => [
                    'tipo' => 'Potencia Horizontal',
                    'unidad' => 'cm',
                    'procedimiento' => [
                        'El atleta se coloca detrás de la línea de despegue con los pies separados al ancho de los hombros.',
                        'Realiza un contramovimiento con flexión de rodillas y balanceo de brazos.',
                        'Impulsa el cuerpo hacia adelante buscando la máxima distancia.',
                        'Aterriza con ambos pies juntos, manteniendo el equilibrio.',
                        'Se mide desde la línea de despegue hasta el punto de contacto más cercano con el suelo.'
                    ],
                    'consideraciones' => [
                        'Realizar en una superficie antideslizante y segura.',
                        'Permitir caída hacia adelante después del aterrizaje para evitar lesiones.',
                        'Realizar 2-3 intentos con recuperación completa entre ellos.',
                        'Registrar la mejor marca de los intentos válidos.'
                    ]
                ]
            ],
            [
                'nombre_test' => 'Test de Preferencia Motriz',
                'descripcion' => "Evalúa la lateralidad motora del individuo en diversas tareas funcionales, identificando su lado dominante para diferentes acciones.",
                'formato_test' => [
                    'tipo' => 'Lateralidad',
                    'unidad' => 'Índice de preferencia',
                    'procedimiento' => [
                        'Escribir o dibujar: Se pide al participante que escriba su nombre o dibuje una figura simple.',
                        'Lanzar una pelota: Se le pide que lance una pelota a un objetivo.',
                        'Cepillarse los dientes: Se simula el movimiento de cepillado dental.',
                        'Recoger un objeto pequeño: Se coloca un objeto pequeño en el suelo para ser recogido.',
                        'Abrir una puerta: Se simula el giro de un picaporte.'
                    ],
                    'consideraciones' => [
                        'Registrar qué mano utiliza espontáneamente para cada tarea.',
                        'No dar instrucciones sobre qué mano utilizar.',
                        'Realizar cada tarea al menos dos veces para verificar consistencia.',
                        'Anotar cualquier observación sobre la destreza mostrada.'
                    ]
                ]
            ],
            [
                'nombre_test' => 'Test de Lateralidad Visual',
                'descripcion' => "Evalúa la dominancia ocular del participante mediante diversas pruebas de enfoque y puntería.",
                'formato_test' => [
                    'tipo' => 'Lateralidad Sensorial',
                    'unidad' => 'Ojo dominante',
                    'procedimiento' => [
                        'El evaluador sostiene un objeto pequeño con ambas manos formando un triángulo.',
                        'El participante debe mirar a través del agujero hacia un objeto distante.',
                        'Sin mover la cabeza, el evaluador tapa alternativamente cada ojo.',
                        'El ojo con el que se mantiene la visión del objeto es el dominante.'
                    ],
                    'consideraciones' => [
                        'Realizar la prueba a una distancia adecuada (2-3 metros).',
                        'Repetir la prueba 2-3 veces para confirmar los resultados.',
                        'Registrar si la dominancia es consistente en todas las repeticiones.',
                        'Tener en cuenta que algunas personas pueden tener dominancia cruzada.'
                    ]
                ]
            ],
            [
                'nombre_test' => 'Test de Lateralidad Podal',
                'descripcion' => "Evalúa la preferencia podal en diversas tareas funcionales y de equilibrio, identificando el pie dominante.",
                'formato_test' => [
                    'tipo' => 'Lateralidad',
                    'unidad' => 'Pie dominante',
                    'procedimiento' => [
                        'Patear un balón: Se pide patear un balón hacia un objetivo.',
                        'Subir un escalón: Se coloca un escalón bajo y se pide subir con un pie.',
                        'Equilibrio en un pie: Se cronometra cuánto tiempo puede mantenerse en equilibrio sobre cada pie.',
                        'Saltos en un pie: Se pide dar pequeños saltos manteniendo el equilibrio.'
                    ],
                    'consideraciones' => [
                        'Realizar cada tarea al menos dos veces para verificar consistencia.',
                        'Registrar qué pie utiliza espontáneamente para cada tarea.',
                        'Observar si hay diferencias significativas en el desempeño entre ambos pies.',
                        'Tener en cuenta posibles lesiones previas que puedan afectar los resultados.'
                    ]
                ]
            ],
            [
                'nombre_test' => 'Test de Wells',
                'descripcion' => "Evalúa la flexibilidad de la cadena muscular posterior, especialmente isquiotibiales y zona lumbar, midiendo la amplitud de movimiento.",
                'formato_test' => [
                    'tipo' => 'Flexibilidad',
                    'unidad' => 'cm',
                    'procedimiento' => [
                        'El participante se sienta en el suelo con las piernas extendidas y juntas.',
                        'Los pies están en flexión dorsal (punta de los pies hacia arriba).',
                        'Se coloca una caja de medición contra los pies del participante.',
                        'Con las rodillas extendidas, el participante se inclina hacia adelante lo máximo posible.',
                        'Se mide la distancia alcanzada más allá de la punta de los pies.'
                    ],
                    'consideraciones' => [
                        'Realizar un calentamiento previo suave.',
                        'No forzar el estiramiento para evitar lesiones.',
                        'Realizar 2-3 intentos con recuperación entre ellos.',
                        'Registrar la mejor marca de los intentos válidos.'
                    ]
                ]
            ],
            [
                'nombre_test' => 'Test de Velocidad 20m',
                'descripcion' => "Evalúa la capacidad de aceleración y velocidad en distancias cortas, midiendo el tiempo que tarda un atleta en recorrer 20 metros.",
                'formato_test' => [
                    'tipo' => 'Velocidad',
                    'unidad' => 'segundos',
                    'procedimiento' => [
                        'Se marcan dos líneas separadas por 20 metros en una superficie plana y antideslizante.',
                        'El atleta se coloca en posición de salida alta detrás de la línea de partida.',
                        'A la señal, el atleta corre los 20 metros a máxima velocidad.',
                        'Se registra el tiempo con cronómetro o sistema electrónico de precisión.',
                        'Se permiten 2-3 intentos con recuperación completa entre ellos.'
                    ],
                    'consideraciones' => [
                        'Realizar un calentamiento previo adecuado.',
                        'Asegurar que la superficie esté seca y en buenas condiciones.',
                        'Utilizar calzado deportivo adecuado.',
                        'Registrar el mejor tiempo de los intentos válidos.'
                    ]
                ]
            ]
        ];
        
        foreach ($tests as $test) {
            $this->createTest($test);
        }
    }
}
