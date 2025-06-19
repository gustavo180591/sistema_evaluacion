-- SEEDER PARA SISTEMA DE EVALUACIÓN FÍSICA
USE sistema_evaluacion;

-- Limpiar datos existentes (en orden correcto para evitar errores de foreign key)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE resultados_tests;
TRUNCATE TABLE evaluaciones;
TRUNCATE TABLE tests;
TRUNCATE TABLE atletas;
TRUNCATE TABLE evaluadores;
TRUNCATE TABLE usuarios;
TRUNCATE TABLE lugares;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. INSERTAR LUGARES (COLEGIOS) - estructura real: id, nombre, zona, direccion
INSERT INTO lugares (nombre, zona, direccion) VALUES
('Colegio San Patricio', 'Santiago Centro', 'Av. Principal 123, Santiago'),
('Instituto Nacional', 'Santiago Centro', 'Calle Libertad 456, Santiago'),
('Colegio Sagrados Corazones', 'Providencia', 'Av. Los Leones 789, Providencia'),
('Liceo Industrial', 'Maipú', 'Calle Industrial 321, Maipú'),
('Colegio Villa María', 'Las Condes', 'Pasaje Las Flores 654, Las Condes');

-- 2. INSERTAR EVALUADORES PRIMERO - estructura real: id, nombre, apellido, email, password, fecha_alta
INSERT INTO evaluadores (nombre, apellido, email, password) VALUES
('Carlos', 'Martínez López', 'carlos.martinez@sanpatricio.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('María', 'Rodríguez Herrera', 'maria.rodriguez@nacional.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Pedro', 'González Moreno', 'pedro.gonzalez@sagrados.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Ana', 'Silva Muñoz', 'ana.silva@industrial.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Luis', 'Castro Pérez', 'luis.castro@villamaria.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Sofía', 'Morales Vega', 'sofia.morales@sanpatricio.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- 3. INSERTAR USUARIOS - estructura real: id, rol, referencia_id, email, password, activo
INSERT INTO usuarios (rol, referencia_id, email, password, activo) VALUES
-- Administrador (sin referencia_id)
('administrador', NULL, 'admin@colegio.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
-- Evaluadores (referencia_id apunta al ID del evaluador)
('evaluador', 1, 'carlos.martinez@sanpatricio.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
('evaluador', 2, 'maria.rodriguez@nacional.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
('evaluador', 3, 'pedro.gonzalez@sagrados.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
('evaluador', 4, 'ana.silva@industrial.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
('evaluador', 5, 'luis.castro@villamaria.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
('evaluador', 6, 'sofia.morales@sanpatricio.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- 4. INSERTAR ATLETAS (ALUMNOS) 
-- Estructura real: evaluador_id, nombre, apellido, dni, sexo, fecha_nacimiento, altura_cm, peso_kg, envergadura_cm, altura_sentado_cm, lateralidad_visual, lateralidad_podal, lugar_id
INSERT INTO atletas (evaluador_id, nombre, apellido, dni, sexo, fecha_nacimiento, altura_cm, peso_kg, envergadura_cm, altura_sentado_cm, lateralidad_visual, lateralidad_podal, lugar_id) VALUES
-- Colegio San Patricio (lugar_id = 1, evaluador_id = 1)
(1, 'Matías', 'Sánchez Rivera', '25123456-7', 'M', '2008-03-15', 172.0, 65.5, 175.0, 90.0, 'Derecho', 'Derecho', 1),
(1, 'Valentina', 'Torres Díaz', '25234567-8', 'F', '2008-07-22', 158.0, 52.3, 160.0, 82.0, 'Derecho', 'Derecho', 1),
(1, 'Sebastián', 'Rojas Muñoz', '24345678-9', 'M', '2007-11-08', 178.0, 71.2, 182.0, 93.0, 'Derecho', 'Derecho', 1),
(1, 'Camila', 'Fernández Soto', '25456789-0', 'F', '2008-01-30', 165.0, 58.7, 167.0, 85.0, 'Izquierdo', 'Derecho', 1),
(1, 'Diego', 'Vargas Morales', '24567890-1', 'M', '2007-09-12', 175.0, 68.9, 178.0, 91.0, 'Derecho', 'Derecho', 1),

-- Instituto Nacional (lugar_id = 2, evaluador_id = 2)
(2, 'Andrés', 'López García', '25678901-2', 'M', '2008-05-18', 170.0, 63.1, 173.0, 88.0, 'Derecho', 'Derecho', 2),
(2, 'Isidora', 'Muñoz Pérez', '25789012-3', 'F', '2008-08-25', 162.0, 55.4, 164.0, 84.0, 'Derecho', 'Izquierdo', 2),
(2, 'Joaquín', 'Herrera Silva', '24890123-4', 'M', '2007-12-03', 180.0, 73.5, 185.0, 94.0, 'Izquierdo', 'Derecho', 2),
(2, 'Florencia', 'Castillo Ramos', '25901234-5', 'F', '2008-02-14', 167.0, 60.2, 169.0, 86.0, 'Derecho', 'Derecho', 2),
(2, 'Nicolás', 'Mendoza Torres', '24012345-6', 'M', '2007-10-27', 173.0, 66.8, 176.0, 89.0, 'Derecho', 'Derecho', 2),

-- Colegio Sagrados Corazones (lugar_id = 3, evaluador_id = 3)
(3, 'Antonia', 'Guerrero Vega', '25123457-8', 'F', '2008-04-09', 160.0, 53.9, 162.0, 83.0, 'Derecho', 'Derecho', 3),
(3, 'Catalina', 'Ruiz Flores', '25234568-9', 'F', '2008-06-16', 164.0, 57.3, 166.0, 85.0, 'Izquierdo', 'Derecho', 3),
(3, 'Martina', 'Soto Jiménez', '24345679-0', 'F', '2007-11-21', 168.0, 61.5, 170.0, 87.0, 'Derecho', 'Derecho', 3),
(3, 'Esperanza', 'Moreno Castro', '25456780-1', 'F', '2008-03-07', 159.0, 54.8, 161.0, 82.0, 'Derecho', 'Izquierdo', 3),
(3, 'Ignacia', 'Pinto Herrera', '24567891-2', 'F', '2007-09-19', 166.0, 59.1, 168.0, 86.0, 'Derecho', 'Derecho', 3),

-- Liceo Industrial (lugar_id = 4, evaluador_id = 4)
(4, 'Cristóbal', 'Ramírez Ortega', '25678902-3', 'M', '2008-01-11', 176.0, 69.7, 179.0, 92.0, 'Derecho', 'Derecho', 4),
(4, 'Maximiliano', 'Cortés Bravo', '24789013-4', 'M', '2007-08-28', 181.0, 72.4, 186.0, 95.0, 'Derecho', 'Derecho', 4),
(4, 'Benjamín', 'Navarro Reyes', '25890124-5', 'M', '2008-05-05', 171.0, 64.3, 174.0, 89.0, 'Izquierdo', 'Derecho', 4),
(4, 'Tomás', 'Espinoza Luna', '24901235-6', 'M', '2007-12-17', 177.0, 70.8, 180.0, 92.0, 'Derecho', 'Derecho', 4),
(4, 'Gabriel', 'Medina Campos', '25012346-7', 'M', '2008-02-23', 174.0, 67.2, 177.0, 90.0, 'Derecho', 'Izquierdo', 4),

-- Colegio Villa María (lugar_id = 5, evaluador_id = 5)
(5, 'Emilia', 'Contreras Vidal', '25123468-9', 'F', '2008-06-12', 163.0, 56.6, 165.0, 84.0, 'Derecho', 'Derecho', 5),
(5, 'Rosario', 'Figueroa Peña', '24234579-0', 'F', '2007-10-04', 169.0, 62.1, 171.0, 87.0, 'Izquierdo', 'Derecho', 5),
(5, 'Agustina', 'Morales Díaz', '25345680-1', 'F', '2008-03-28', 157.0, 51.7, 159.0, 81.0, 'Derecho', 'Derecho', 5),
(5, 'Javiera', 'Campos Rojas', '24456791-2', 'F', '2007-11-15', 165.0, 58.9, 167.0, 85.0, 'Derecho', 'Derecho', 5),
(5, 'Trinidad', 'Herrera Soto', '25567802-3', 'F', '2008-04-21', 161.0, 55.2, 163.0, 83.0, 'Derecho', 'Izquierdo', 5);

-- 5. INSERTAR TESTS DE EVALUACIÓN CON FORMATO JSON
INSERT INTO tests (nombre_test, descripcion, formato_test) VALUES
-- Test de Fuerza de Agarre
('Test de Fuerza de Agarre', 
'Evalúa la fuerza isométrica de los músculos de la mano y el antebrazo. Se realiza sentado con el hombro en aducción, el codo flexionado a 90 grados y el antebrazo y la muñeca en posición neutra. Se realizan tres apretones con cada mano y se registra la lectura máxima, calculando un promedio de las mediciones de ambas manos.',
JSON_OBJECT(
    'tipo', 'numerico',
    'campos', JSON_ARRAY(
        JSON_OBJECT('nombre', 'fuerza_mano_derecha', 'tipo', 'decimal', 'unidad', 'kg', 'requerido', true, 'descripcion', 'Fuerza máxima mano derecha'),
        JSON_OBJECT('nombre', 'fuerza_mano_izquierda', 'tipo', 'decimal', 'unidad', 'kg', 'requerido', true, 'descripcion', 'Fuerza máxima mano izquierda'),
        JSON_OBJECT('nombre', 'promedio', 'tipo', 'decimal', 'unidad', 'kg', 'requerido', true, 'descripcion', 'Promedio de ambas manos'),
        JSON_OBJECT('nombre', 'intentos_derecha', 'tipo', 'entero', 'unidad', 'cantidad', 'requerido', false, 'descripcion', 'Número de intentos mano derecha'),
        JSON_OBJECT('nombre', 'intentos_izquierda', 'tipo', 'entero', 'unidad', 'cantidad', 'requerido', false, 'descripcion', 'Número de intentos mano izquierda'),
        JSON_OBJECT('nombre', 'observaciones', 'tipo', 'texto', 'unidad', '', 'requerido', false, 'descripcion', 'Observaciones del evaluador')
    ),
    'instrucciones', JSON_ARRAY(
        'Sentarse con el hombro en aducción',
        'Flexionar el codo a 90 grados',
        'Mantener antebrazo y muñeca en posición neutra',
        'Realizar 3 apretones máximos con cada mano',
        'Registrar la lectura máxima de cada mano',
        'Calcular promedio de ambas manos'
    )
)),

-- Salto Vertical
('Salto Vertical', 
'Mide la altura que un atleta puede saltar desde una posición estática. Se utiliza para evaluar la potencia muscular de las extremidades inferiores.',
JSON_OBJECT(
    'tipo', 'numerico',
    'campos', JSON_ARRAY(
        JSON_OBJECT('nombre', 'altura_salto', 'tipo', 'decimal', 'unidad', 'cm', 'requerido', true, 'descripcion', 'Altura máxima del salto'),
        JSON_OBJECT('nombre', 'intentos', 'tipo', 'entero', 'unidad', 'cantidad', 'requerido', false, 'descripcion', 'Número de intentos realizados'),
        JSON_OBJECT('nombre', 'tecnica', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Excelente', 'Buena', 'Regular', 'Deficiente'), 'requerido', false, 'descripcion', 'Evaluación de la técnica'),
        JSON_OBJECT('nombre', 'observaciones', 'tipo', 'texto', 'unidad', '', 'requerido', false, 'descripcion', 'Observaciones del evaluador')
    ),
    'instrucciones', JSON_ARRAY(
        'Posicionarse de pie junto a la pared o equipo de medición',
        'Saltar verticalmente con máxima fuerza',
        'Usar solo el impulso de las piernas',
        'Medir la altura máxima alcanzada',
        'Realizar 3 intentos y registrar el mejor'
    )
)),

-- Salto con Contramovimiento
('Salto con Contramovimiento', 
'Evalúa la capacidad de un atleta para absorber y luego reutilizar la energía del aterrizaje para generar un salto vertical. Mide la potencia reactiva.',
JSON_OBJECT(
    'tipo', 'numerico',
    'campos', JSON_ARRAY(
        JSON_OBJECT('nombre', 'altura_salto', 'tipo', 'decimal', 'unidad', 'cm', 'requerido', true, 'descripcion', 'Altura máxima del salto con contramovimiento'),
        JSON_OBJECT('nombre', 'tiempo_contacto', 'tipo', 'decimal', 'unidad', 'ms', 'requerido', false, 'descripcion', 'Tiempo de contacto con el suelo'),
        JSON_OBJECT('nombre', 'fuerza_reactiva', 'tipo', 'decimal', 'unidad', 'índice', 'requerido', false, 'descripcion', 'Índice de fuerza reactiva'),
        JSON_OBJECT('nombre', 'intentos', 'tipo', 'entero', 'unidad', 'cantidad', 'requerido', false, 'descripcion', 'Número de intentos realizados'),
        JSON_OBJECT('nombre', 'observaciones', 'tipo', 'texto', 'unidad', '', 'requerido', false, 'descripcion', 'Observaciones del evaluador')
    ),
    'instrucciones', JSON_ARRAY(
        'Realizar un movimiento de contramovimiento (flexión seguida de extensión)',
        'Saltar inmediatamente después del aterrizaje',
        'Minimizar el tiempo de contacto con el suelo',
        'Medir la altura máxima alcanzada',
        'Evaluar la capacidad de absorber y reutilizar energía'
    )
)),

-- Salto de Longitud
('Salto de Longitud', 
'Los atletas deben saltar la mayor distancia posible desde una línea de despegue. Evalúa la potencia horizontal y la coordinación.',
JSON_OBJECT(
    'tipo', 'numerico',
    'campos', JSON_ARRAY(
        JSON_OBJECT('nombre', 'distancia', 'tipo', 'decimal', 'unidad', 'cm', 'requerido', true, 'descripcion', 'Distancia máxima del salto'),
        JSON_OBJECT('nombre', 'intentos', 'tipo', 'entero', 'unidad', 'cantidad', 'requerido', false, 'descripcion', 'Número de intentos realizados'),
        JSON_OBJECT('nombre', 'tecnica_despegue', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Excelente', 'Buena', 'Regular', 'Deficiente'), 'requerido', false, 'descripcion', 'Técnica de despegue'),
        JSON_OBJECT('nombre', 'tecnica_aterrizaje', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Excelente', 'Buena', 'Regular', 'Deficiente'), 'requerido', false, 'descripcion', 'Técnica de aterrizaje'),
        JSON_OBJECT('nombre', 'observaciones', 'tipo', 'texto', 'unidad', '', 'requerido', false, 'descripcion', 'Observaciones del evaluador')
    ),
    'instrucciones', JSON_ARRAY(
        'Posicionarse detrás de la línea de despegue',
        'Tomar impulso con carrera corta',
        'Saltar horizontalmente con máxima fuerza',
        'Aterrizar con ambos pies juntos',
        'Medir desde la línea de despegue hasta la marca más cercana del aterrizaje'
    )
)),

-- Test de Lateralidad Visual
('Test de Lateralidad Visual', 
'Evalúa la preferencia por un ojo (izquierdo o derecho) para realizar tareas que requieren coordinación visomotora.',
JSON_OBJECT(
    'tipo', 'cualitativo',
    'campos', JSON_ARRAY(
        JSON_OBJECT('nombre', 'ojo_dominante', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecho', 'Izquierdo', 'Ambidiestro'), 'requerido', true, 'descripcion', 'Ojo dominante identificado'),
        JSON_OBJECT('nombre', 'test_tubo', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecho', 'Izquierdo'), 'requerido', false, 'descripcion', 'Resultado test del tubo'),
        JSON_OBJECT('nombre', 'test_carta', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecho', 'Izquierdo'), 'requerido', false, 'descripcion', 'Resultado test de la carta'),
        JSON_OBJECT('nombre', 'test_apuntado', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecho', 'Izquierdo'), 'requerido', false, 'descripcion', 'Resultado test de apuntado'),
        JSON_OBJECT('nombre', 'observaciones', 'tipo', 'texto', 'unidad', '', 'requerido', false, 'descripcion', 'Observaciones del evaluador')
    ),
    'instrucciones', JSON_ARRAY(
        'Realizar test del tubo: mirar a través de un tubo',
        'Realizar test de la carta: mirar a través de un agujero en una carta',
        'Realizar test de apuntado: apuntar a un objeto distante',
        'Observar cuál ojo cierra naturalmente',
        'Determinar el ojo dominante basado en las pruebas'
    )
)),

-- Test de Lateralidad Podal
('Test de Lateralidad Podal', 
'Evalúa la preferencia por un pie (derecho o izquierdo) para realizar tareas que requieren equilibrio y control motor.',
JSON_OBJECT(
    'tipo', 'cualitativo',
    'campos', JSON_ARRAY(
        JSON_OBJECT('nombre', 'pie_dominante', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecho', 'Izquierdo', 'Ambidiestro'), 'requerido', true, 'descripcion', 'Pie dominante identificado'),
        JSON_OBJECT('nombre', 'test_patear', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecho', 'Izquierdo'), 'requerido', false, 'descripcion', 'Pie usado para patear'),
        JSON_OBJECT('nombre', 'test_equilibrio', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecho', 'Izquierdo'), 'requerido', false, 'descripcion', 'Pie de apoyo en equilibrio'),
        JSON_OBJECT('nombre', 'test_subir_escalon', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecho', 'Izquierdo'), 'requerido', false, 'descripcion', 'Primer pie al subir escalón'),
        JSON_OBJECT('nombre', 'observaciones', 'tipo', 'texto', 'unidad', '', 'requerido', false, 'descripcion', 'Observaciones del evaluador')
    ),
    'instrucciones', JSON_ARRAY(
        'Test de patear: solicitar patear un balón',
        'Test de equilibrio: mantenerse en un pie',
        'Test de subir escalón: observar cuál pie inicia',
        'Test de escribir con el pie: simular escribir en el suelo',
        'Determinar el pie dominante basado en las pruebas'
    )
)),

-- Test de Lateralidad Manual
('Test de Lateralidad Manual', 
'Determina cuál es la mano que una persona tiende a usar con mayor facilidad y precisión en diferentes tareas motoras.',
JSON_OBJECT(
    'tipo', 'cualitativo',
    'campos', JSON_ARRAY(
        JSON_OBJECT('nombre', 'mano_dominante', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecha', 'Izquierda', 'Ambidiestro'), 'requerido', true, 'descripcion', 'Mano dominante identificada'),
        JSON_OBJECT('nombre', 'test_escribir', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecha', 'Izquierda'), 'requerido', false, 'descripcion', 'Mano para escribir'),
        JSON_OBJECT('nombre', 'test_lanzar', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecha', 'Izquierda'), 'requerido', false, 'descripcion', 'Mano para lanzar'),
        JSON_OBJECT('nombre', 'test_cepillar', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecha', 'Izquierda'), 'requerido', false, 'descripcion', 'Mano para cepillarse los dientes'),
        JSON_OBJECT('nombre', 'test_cortar', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Derecha', 'Izquierda'), 'requerido', false, 'descripcion', 'Mano para usar tijeras'),
        JSON_OBJECT('nombre', 'observaciones', 'tipo', 'texto', 'unidad', '', 'requerido', false, 'descripcion', 'Observaciones del evaluador')
    ),
    'instrucciones', JSON_ARRAY(
        'Test de escritura: solicitar escribir su nombre',
        'Test de lanzamiento: lanzar una pelota',
        'Test de cepillado: simular cepillarse los dientes',
        'Test de corte: simular usar tijeras',
        'Test de peinado: simular peinarse',
        'Determinar la mano dominante basado en las pruebas'
    )
)),

-- Test de Wells (Flexibilidad)
('Test de Wells (Flexibilidad)', 
'Evaluación de la flexibilidad, especialmente de los isquiotibiales y la zona baja de la espalda. El participante se sienta con las piernas extendidas y los pies juntos, se inclina hacia adelante intentando alcanzar la mayor distancia posible con las manos, sin doblar las rodillas.',
JSON_OBJECT(
    'tipo', 'numerico',
    'campos', JSON_ARRAY(
        JSON_OBJECT('nombre', 'distancia_alcanzada', 'tipo', 'decimal', 'unidad', 'cm', 'requerido', true, 'descripcion', 'Distancia alcanzada desde los pies'),
        JSON_OBJECT('nombre', 'intentos', 'tipo', 'entero', 'unidad', 'cantidad', 'requerido', false, 'descripcion', 'Número de intentos realizados'),
        JSON_OBJECT('nombre', 'flexibilidad_isquiotibiales', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Excelente', 'Buena', 'Regular', 'Limitada'), 'requerido', false, 'descripcion', 'Evaluación flexibilidad isquiotibiales'),
        JSON_OBJECT('nombre', 'flexibilidad_lumbar', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Excelente', 'Buena', 'Regular', 'Limitada'), 'requerido', false, 'descripcion', 'Evaluación flexibilidad lumbar'),
        JSON_OBJECT('nombre', 'observaciones', 'tipo', 'texto', 'unidad', '', 'requerido', false, 'descripcion', 'Observaciones del evaluador')
    ),
    'instrucciones', JSON_ARRAY(
        'Sentarse con las piernas extendidas y pies juntos',
        'Mantener las rodillas completamente extendidas',
        'Inclinar el tronco hacia adelante lentamente',
        'Alcanzar la máxima distancia posible con las manos',
        'Medir la distancia desde los pies en centímetros',
        'Mantener la posición durante 2 segundos'
    )
)),

-- Test de Velocidad 20 metros
('Test de Velocidad 20 metros', 
'Mide la velocidad de un individuo corriendo a máxima velocidad una distancia de 20 metros. Evalúa la capacidad de aceleración y velocidad máxima.',
JSON_OBJECT(
    'tipo', 'numerico',
    'campos', JSON_ARRAY(
        JSON_OBJECT('nombre', 'tiempo', 'tipo', 'decimal', 'unidad', 'segundos', 'requerido', true, 'descripcion', 'Tiempo en completar 20 metros'),
        JSON_OBJECT('nombre', 'intentos', 'tipo', 'entero', 'unidad', 'cantidad', 'requerido', false, 'descripcion', 'Número de intentos realizados'),
        JSON_OBJECT('nombre', 'velocidad_maxima', 'tipo', 'decimal', 'unidad', 'm/s', 'requerido', false, 'descripcion', 'Velocidad máxima calculada'),
        JSON_OBJECT('nombre', 'tiempo_reaccion', 'tipo', 'decimal', 'unidad', 'segundos', 'requerido', false, 'descripcion', 'Tiempo de reacción al estímulo'),
        JSON_OBJECT('nombre', 'tecnica_carrera', 'tipo', 'seleccion', 'opciones', JSON_ARRAY('Excelente', 'Buena', 'Regular', 'Deficiente'), 'requerido', false, 'descripcion', 'Evaluación de la técnica de carrera'),
        JSON_OBJECT('nombre', 'observaciones', 'tipo', 'texto', 'unidad', '', 'requerido', false, 'descripcion', 'Observaciones del evaluador')
    ),
    'instrucciones', JSON_ARRAY(
        'Posicionarse en la línea de salida',
        'Esperar la señal de inicio',
        'Correr a máxima velocidad durante 20 metros',
        'Mantener la velocidad hasta cruzar la línea de meta',
        'Registrar el tiempo con cronómetro',
        'Realizar 2-3 intentos y tomar el mejor tiempo'
    )
));

-- 6. INSERTAR ALGUNAS EVALUACIONES DE EJEMPLO
INSERT INTO evaluaciones (atleta_id, evaluador_id, lugar_id, fecha_evaluacion, hora_inicio, estado, observaciones, clima, temperatura_ambiente) VALUES
(1, 1, 1, '2024-01-15', '09:00:00', 'completada', 'Evaluación inicial muy satisfactoria. Estudiante muestra buena predisposición.', 'Soleado', 22.5),
(2, 1, 1, '2024-01-15', '09:30:00', 'completada', 'Buen rendimiento general. Recomendar trabajo de fuerza.', 'Soleado', 22.5),
(6, 2, 2, '2024-01-16', '10:00:00', 'completada', 'Excelente coordinación y velocidad. Potencial para atletismo.', 'Nublado', 19.0),
(11, 3, 3, '2024-01-17', '08:30:00', 'en_progreso', 'Evaluación en curso.', 'Parcialmente nublado', 20.8),
(16, 4, 4, '2024-01-18', '14:00:00', 'iniciada', 'Estudiante presenta buena actitud.', 'Soleado', 25.2);

-- 7. INSERTAR RESULTADOS DE TESTS CON FORMATO ACTUALIZADO
-- Estructura real: atleta_id, evaluador_id, test_id, lugar_id, fecha_test, resultado_json
INSERT INTO resultados_tests (atleta_id, evaluador_id, test_id, lugar_id, fecha_test, resultado_json) VALUES

-- Test de Fuerza de Agarre para Matías Sánchez (atleta_id = 1, test_id = 1)
(1, 1, 1, 1, '2024-01-15', JSON_OBJECT(
    'fuerza_mano_derecha', 37.5,
    'fuerza_mano_izquierda', 32.9,
    'promedio', 35.2,
    'intentos_derecha', 3,
    'intentos_izquierda', 3,
    'observaciones', 'Fuerza de agarre dentro del rango normal para su edad. Mano derecha dominante evidente.'
)),

-- Salto Vertical para Matías Sánchez (atleta_id = 1, test_id = 2)
(1, 1, 2, 1, '2024-01-15', JSON_OBJECT(
    'altura_salto', 42.0,
    'intentos', 3,
    'tecnica', 'Buena',
    'observaciones', 'Buena técnica de salto, potencia muscular adecuada para su edad.'
)),

-- Salto con Contramovimiento para Matías Sánchez (atleta_id = 1, test_id = 3)
(1, 1, 3, 1, '2024-01-15', JSON_OBJECT(
    'altura_salto', 45.5,
    'tiempo_contacto', 185.2,
    'fuerza_reactiva', 1.23,
    'intentos', 3,
    'observaciones', 'Excelente aprovechamiento del ciclo estiramiento-acortamiento.'
)),

-- Test de Wells para Matías Sánchez (atleta_id = 1, test_id = 8)
(1, 1, 8, 1, '2024-01-15', JSON_OBJECT(
    'distancia_alcanzada', 15.3,
    'intentos', 2,
    'flexibilidad_isquiotibiales', 'Regular',
    'flexibilidad_lumbar', 'Buena',
    'observaciones', 'Flexibilidad dentro del rango normal, puede mejorar con estiramientos específicos.'
)),

-- Test de Velocidad para Matías Sánchez (atleta_id = 1, test_id = 9)
(1, 1, 9, 1, '2024-01-15', JSON_OBJECT(
    'tiempo', 3.1,
    'intentos', 2,
    'velocidad_maxima', 6.45,
    'tiempo_reaccion', 0.18,
    'tecnica_carrera', 'Buena',
    'observaciones', 'Tiempo competitivo para su categoría. Técnica de carrera sólida.'
)),

-- Test de Lateralidad Visual para Valentina Torres (atleta_id = 2, test_id = 5)
(2, 1, 5, 1, '2024-01-15', JSON_OBJECT(
    'ojo_dominante', 'Derecho',
    'test_tubo', 'Derecho',
    'test_carta', 'Derecho',
    'test_apuntado', 'Derecho',
    'observaciones', 'Dominancia ocular derecha claramente establecida en todas las pruebas.'
)),

-- Test de Lateralidad Podal para Valentina Torres (atleta_id = 2, test_id = 6)
(2, 1, 6, 1, '2024-01-15', JSON_OBJECT(
    'pie_dominante', 'Derecho',
    'test_patear', 'Derecho',
    'test_equilibrio', 'Derecho',
    'test_subir_escalon', 'Derecho',
    'observaciones', 'Lateralidad podal derecha consistente en todos los tests.'
)),

-- Test de Lateralidad Manual para Valentina Torres (atleta_id = 2, test_id = 7)
(2, 1, 7, 1, '2024-01-15', JSON_OBJECT(
    'mano_dominante', 'Derecha',
    'test_escribir', 'Derecha',
    'test_lanzar', 'Derecha',
    'test_cepillar', 'Derecha',
    'test_cortar', 'Derecha',
    'observaciones', 'Diestra confirmada en todas las actividades evaluadas.'
)),

-- Salto de Longitud para Andrés López (atleta_id = 6, test_id = 4)
(6, 2, 4, 2, '2024-01-16', JSON_OBJECT(
    'distancia', 185.0,
    'intentos', 3,
    'tecnica_despegue', 'Excelente',
    'tecnica_aterrizaje', 'Buena',
    'observaciones', 'Distancia destacada para su categoría. Técnica de despegue muy sólida.'
)),

-- Test de Velocidad para Andrés López (atleta_id = 6, test_id = 9)
(6, 2, 9, 2, '2024-01-16', JSON_OBJECT(
    'tiempo', 2.8,
    'intentos', 3,
    'velocidad_maxima', 7.14,
    'tiempo_reaccion', 0.15,
    'tecnica_carrera', 'Excelente',
    'observaciones', 'Tiempo excepcional. Potencial para deportes que requieran velocidad.'
)),

-- Test de Fuerza de Agarre para Andrés López (atleta_id = 6, test_id = 1)
(6, 2, 1, 2, '2024-01-16', JSON_OBJECT(
    'fuerza_mano_derecha', 43.2,
    'fuerza_mano_izquierda', 40.4,
    'promedio', 41.8,
    'intentos_derecha', 3,
    'intentos_izquierda', 3,
    'observaciones', 'Fuerza de agarre por encima del promedio para su edad y sexo.'
)),

-- Test de Wells para Antonia Guerrero (atleta_id = 11, test_id = 8)
(11, 3, 8, 3, '2024-01-17', JSON_OBJECT(
    'distancia_alcanzada', 22.1,
    'intentos', 2,
    'flexibilidad_isquiotibiales', 'Excelente',
    'flexibilidad_lumbar', 'Excelente',
    'observaciones', 'Flexibilidad superior. Ideal para deportes que requieran amplitud de movimiento.'
)),

-- Salto Vertical para Cristóbal Ramírez (atleta_id = 16, test_id = 2)
(16, 4, 2, 4, '2024-01-18', JSON_OBJECT(
    'altura_salto', 48.7,
    'intentos', 3,
    'tecnica', 'Excelente',
    'observaciones', 'Salto vertical destacado. Excelente potencia en extremidades inferiores.'
));

-- Mostrar resumen de datos insertados
SELECT 'SEEDER CON FORMATO JSON COMPLETADO EXITOSAMENTE' as status;
SELECT 'Datos insertados:' as resumen;
SELECT COUNT(*) as lugares FROM lugares;
SELECT COUNT(*) as usuarios FROM usuarios;
SELECT COUNT(*) as evaluadores FROM evaluadores;
SELECT COUNT(*) as atletas FROM atletas;
SELECT COUNT(*) as tests FROM tests;
SELECT COUNT(*) as evaluaciones FROM evaluaciones;
SELECT COUNT(*) as resultados FROM resultados_tests; 