@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acta Administrativa de {{ $trabajador }} - {{ $fechaIncidente }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #000;
            line-height: 1.35;
            margin: 0;
            padding: 20px 24px;
            background: #fff;
        }

        .documento {
            width: 100%;
        }

        .titulo {
            text-align: center;
            font-weight: bold;
            font-size: 15px;
            margin: 0 0 16px 0;
            letter-spacing: 0.5px;
        }

        p {
            margin: 0 0 10px 0;
        }

        .justify {
            text-align: justify;
        }

        .separador {
            border: 0;
            border-top: 1px dashed #000;
            margin: 10px 0 12px 0;
        }

        .page-break {
            page-break-before: always;
        }

        .firmas-titulo {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin: 0 0 60px 0;
        }

        .firma {
            text-align: center;
            margin: 0 0 90px 0;
        }

        .linea-firma {
            width: 270px;
            border-top: 1px solid #000;
            margin: 0 auto 6px auto;
        }

        .firma-nombre {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .firma-cargo {
            font-weight: bold;
        }

        .firmas-dobles {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .firmas-dobles td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 8px;
        }
    </style>
</head>
<body>
    <div class="documento">
        <div class="titulo">ACTA ADMINISTRATIVA</div>

        <p class="justify">
            En {{ $incidencia->empleado->sucursal_empresa->estado }}, siendo las {{ $hora }}, del día {{ $fecha }} reunidos en las oficinas administrativas de la fuente de trabajo, actuando en su calidad de Representante Legal
            <strong>{{ strtoupper($incidencia->empleado->sucursal_empresa->representante_legal) }}</strong> de la fuente de trabajo de la que resulta patrón
            <strong>{{ strtoupper($incidencia->empleado->sucursal_empresa->nombre_sucursal) }}</strong>, se hace constar que esta acta se elabora en la oficina de operaciones, ubicada dentro del centro de trabajo ubicado con el número
            <strong>{{ $incidencia->empleado->sucursal_empresa->numero }}</strong> en la calle <strong>{{ strtoupper($incidencia->empleado->sucursal_empresa->calle) }}</strong> en la Colonia
            <strong>{{ strtoupper($incidencia->empleado->sucursal_empresa->colonia) }}</strong> en <strong>{{ strtoupper($incidencia->empleado->sucursal_empresa->municipio) }}</strong>, con código postal <strong>{{ strtoupper($incidencia->empleado->sucursal_empresa->cp) }}</strong> y ante el testigo <strong>{{ $supervisor }}</strong> que hace el señalamiento de los hechos y se hace constar la presencia de dos testigos de asistencia para convalidar este acto, mismos que se encuentran presentes, señalando sus nombres al final del acta, plasmando sus firman al calce y margen de la presente acta.
        </p>

        <hr class="separador">

        <p class="justify">
            Acto seguido, se hace constar la comparecencia del trabajador de nombre
            <strong>{{ $trabajador }}</strong>, quien se identifica con Credencial de Elector con número
            <strong>{{ $incidencia->empleado->clave_elector }}</strong> quien manifiesta que tiene su actual domicilio particular en la casa marcada con el número
            <strong>{{ $incidencia->empleado->numero }}</strong> en la calle <strong>{{ strtoupper($incidencia->empleado->calle) }}</strong> en la Colonia <strong>{{ strtoupper($incidencia->empleado->colonia) }}</strong> en
            <strong>{{ strtoupper($incidencia->empleado->municipio) }}</strong>, con rango de {{ $incidencia->empleado->rango->nombre }}, quien previamente fue debidamente citado por <strong>{{ $supervisor }}</strong> para la celebración de este acto, sirva lo anterior para los efectos legales a que haya lugar.
        </p>

        <hr class="separador">

        <p class="justify">
            Acto seguido se presenta el primer testigo <strong>{{ $supervisor }}</strong> quien se desempeña en el cargo de <strong>{{ $incidencia->supervisor->cargo }}</strong> de la fuente de trabajo y menciona ser el Jefe Directo del empleado aquí presente, quien previamente fue citado en este lugar por él de manera personal, en virtud de esto, se le exhorta a conducirse con verdad y se le hace saber de las sanciones en que incurren los falsos señalamientos y declaraciones, por lo que a continuación se le concede el uso de la voz, y libremente manifiesta: Que el día <strong>{{ $fechaIncidente }}</strong>, el trabajador que se desempeña con el cargo de {{ $incidencia->empleado->cargo }}, de nombre <strong>{{ $trabajador }},</strong> incurrió en la siguiente conducta: {{ $incidencia->motivo_acta->motivo }}; <strong>({{ strtoupper($incidencia->dice_supervisor) }})</strong>.
            Siendo todo lo que tiene que manifestar.
        </p>

        <hr class="separador">

        <p class="justify">
            Acto seguido, se le concede el uso de la voz al trabajador, quien bajo protesta de decir verdad, reconoce que fue debidamente citado por su superior para presentarse en estas oficinas este día y a esta hora para la celebración de este acto, así mismo, señalo que son ciertas mis generales, al igual que las condiciones de trabajo antes descritos, en razón de ello, el trabajador citado manifiesta: acepto que el día <strong>{{ $fechaIncidente }}</strong>, incurrí en la siguiente conducta: {{ $incidencia->motivo_acta->motivo }};
            <strong>({{ strtoupper($incidencia->dice_empleado) }})</strong>.
            Siendo todo lo que tiene que manifestar.
        </p>

        <hr class="separador">

        <p class="justify">
            Presentes el primer testigo de asistencia <strong>{{ $testigo1 }}</strong> el segundo testigo de asistencia <strong>{{ $testigo2 }}</strong>, quienes han oído y presenciado lo declarado por los comparecientes conforme se asentó en esta acta firmando al calce para constancia, y no teniendo más que agregar se levanta la presente acta administrativa para los efectos legales consecuentes, firmando de conformidad en ella los que intervinieron y quisieron hacerlo.
        </p>

        <div class="page-break"></div>

        <div class="firmas-titulo">FIRMAS</div>

        <div class="firma">
            <div class="linea-firma"></div>
            <div class="firma-nombre">{{ strtoupper($incidencia->empleado->sucursal_empresa->representante_legal) }}</div>
            <div class="firma-cargo">POR EL PATRON</div>
        </div>

        <div class="firma">
            <div class="linea-firma"></div>
            <div class="firma-nombre">{{ $trabajador }}</div>
            <div class="firma-cargo">TRABAJADOR</div>
        </div>

        <div class="firma">
            <div class="linea-firma"></div>
            <div class="firma-nombre">{{ $supervisor }}</div>
            <div class="firma-cargo">SUPERVISOR</div>
        </div>

        <table class="firmas-dobles">
            <tr>
                <td>
                    <div class="linea-firma" style="width: 220px;"></div>
                    <div class="firma-nombre">{{ $testigo1 }}</div>
                    <div class="firma-cargo">TESTIGO DE ASISTENCIA</div>
                </td>
                <td>
                    <div class="linea-firma" style="width: 220px;"></div>
                    <div class="firma-nombre">{{ $testigo2 }}</div>
                    <div class="firma-cargo">TESTIGO DE ASISTENCIA</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
