<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modulo;

class ModuloSeeder extends Seeder
{
    public function run(): void
    {
        Modulo::create(['nombre' => 'roles']);
        Modulo::create(['nombre' => 'usuarios']);
        Modulo::create(['nombre' => 'modulos']);
        Modulo::create(['nombre' => 'perfil']);
        Modulo::create(['nombre' => 'guardias']);
        Modulo::create(['nombre' => 'sucursales-empresa']);
        Modulo::create(['nombre' => 'blacklist']);
        Modulo::create(['nombre' => 'incapacidades']);
        Modulo::create(['nombre' => 'vacaciones']);
        Modulo::create(['nombre' => 'tiempo-extra']);
        Modulo::create(['nombre' => 'faltas']);
        Modulo::create(['nombre' => 'descuentos']);
        Modulo::create(['nombre' => 'prestamos']);
        Modulo::create(['nombre' => 'modulo-prestamos']);
        Modulo::create(['nombre' => 'modulo-descuentos']);
        Modulo::create(['nombre' => 'abonos-prestamo']);
        Modulo::create(['nombre' => 'bancos']);
        Modulo::create(['nombre' => 'movimientos-bancarios']);
        Modulo::create(['nombre' => 'cotizaciones']);
        Modulo::create(['nombre' => 'clientes']);
        Modulo::create(['nombre' => 'sucursales']);
        Modulo::create(['nombre' => 'proveedores']);
        Modulo::create(['nombre' => 'articulos']);
        Modulo::create(['nombre' => 'vehiculos']);
        Modulo::create(['nombre' => 'boletas-gasolina']);
        Modulo::create(['nombre' => 'ordenes-compra']);
        Modulo::create(['nombre' => 'compras']);
        Modulo::create(['nombre' => 'gastos']);
        Modulo::create(['nombre' => 'ventas']);
        Modulo::create(['nombre' => 'ventas-historial']);
        Modulo::create(['nombre' => 'almacen']);
        Modulo::create(['nombre' => 'almacen-entradas']);
        Modulo::create(['nombre' => 'almacen-salidas']);
        Modulo::create(['nombre' => 'equipo']);
        Modulo::create(['nombre' => 'orden-servicio']);
        Modulo::create(['nombre' => 'cartera-vencida']);
        Modulo::create(['nombre' => 'logs']);
        Modulo::create(['nombre' => 'generar-qr']);

        // Módulos que son externos a los que vienen:
        Modulo::create(['nombre' => 'estadocuenta-guardias']);
        Modulo::create(['nombre' => 'reportes-guardias']);
        Modulo::create(['nombre' => 'estadocuenta-clientes']);
        Modulo::create(['nombre' => 'estadocuenta-proveedores']);
        Modulo::create(['nombre' => 'recorridos-guardia']);
        Modulo::create(['nombre' => 'estadocuenta-bancos']);
        Modulo::create(['nombre' => 'generador-reportes']);

        // Módulos de firebase
        Modulo::create(['nombre' => 'guardias-check']);
        Modulo::create(['nombre' => 'bitacoras-guardia']);
        Modulo::create(['nombre' => 'reporte-incidentes']);
        Modulo::create(['nombre' => 'reporte-guardias']);
        Modulo::create(['nombre' => 'reporte-supervisores']);
    }
}
