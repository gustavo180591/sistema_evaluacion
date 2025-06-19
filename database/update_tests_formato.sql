-- ACTUALIZAR FORMATO JSON PARA TODOS LOS TESTS
USE sistema_evaluacion;

-- Test de Fuerza de Agarre
UPDATE tests SET formato_test = JSON_OBJECT(
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
) WHERE nombre_test = 'Test de Fuerza de Agarre';

-- Salto Vertical
UPDATE tests SET formato_test = JSON_OBJECT(
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
) WHERE nombre_test = 'Salto Vertical';

-- Salto con Contramovimiento
UPDATE tests SET formato_test = JSON_OBJECT(
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
) WHERE nombre_test = 'Salto con Contramovimiento';

-- Salto de Longitud
UPDATE tests SET formato_test = JSON_OBJECT(
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
) WHERE nombre_test = 'Salto de Longitud';

-- Test de Lateralidad Visual
UPDATE tests SET formato_test = JSON_OBJECT(
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
) WHERE nombre_test = 'Test de Lateralidad Visual';

-- Test de Lateralidad Podal
UPDATE tests SET formato_test = JSON_OBJECT(
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
) WHERE nombre_test = 'Test de Lateralidad Podal';

-- Test de Lateralidad Manual
UPDATE tests SET formato_test = JSON_OBJECT(
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
) WHERE nombre_test = 'Test de Lateralidad Manual';

-- Test de Wells (Flexibilidad)
UPDATE tests SET formato_test = JSON_OBJECT(
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
) WHERE nombre_test = 'Test de Wells (Flexibilidad)';

-- Test de Velocidad 20 metros
UPDATE tests SET formato_test = JSON_OBJECT(
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
) WHERE nombre_test = 'Test de Velocidad 20 metros';

-- Verificar que se actualizaron correctamente
SELECT 'FORMATOS DE TESTS ACTUALIZADOS EXITOSAMENTE' as status;
SELECT id, nombre_test, JSON_EXTRACT(formato_test, '$.tipo') as tipo_test FROM tests; 