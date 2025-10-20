<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Pais;
use App\Models\Destino;
use Illuminate\Support\Facades\DB;

class RegionesYPaisesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Migrar destinos actuales a regiones
        $destinosActuales = Destino::all();

        $regionesMap = [];
        foreach ($destinosActuales as $destino) {
            $region = Region::create([
                'nombre' => $destino->nombre,
                'activo' => $destino->activo ?? true,
            ]);
            $regionesMap[$destino->id] = $region->id;
        }

        // 2. Crear países con sus regiones
        $paises = [
            // Sur América (región_id será el de "SUR AMERICA")
            ['codigo' => 'AR', 'nombre' => 'Argentina', 'region' => 'SUR AMERICA'],
            ['codigo' => 'BO', 'nombre' => 'Bolivia', 'region' => 'SUR AMERICA'],
            ['codigo' => 'BR', 'nombre' => 'Brasil', 'region' => 'SUR AMERICA'],
            ['codigo' => 'CL', 'nombre' => 'Chile', 'region' => 'SUR AMERICA'],
            ['codigo' => 'CO', 'nombre' => 'Colombia', 'region' => 'SUR AMERICA'],
            ['codigo' => 'EC', 'nombre' => 'Ecuador', 'region' => 'SUR AMERICA'],
            ['codigo' => 'GY', 'nombre' => 'Guyana', 'region' => 'SUR AMERICA'],
            ['codigo' => 'PY', 'nombre' => 'Paraguay', 'region' => 'SUR AMERICA'],
            ['codigo' => 'PE', 'nombre' => 'Perú', 'region' => 'SUR AMERICA'],
            ['codigo' => 'SR', 'nombre' => 'Surinam', 'region' => 'SUR AMERICA'],
            ['codigo' => 'UY', 'nombre' => 'Uruguay', 'region' => 'SUR AMERICA'],
            ['codigo' => 'VE', 'nombre' => 'Venezuela', 'region' => 'SUR AMERICA'],

            // Norte América
            ['codigo' => 'CA', 'nombre' => 'Canadá', 'region' => 'NORTE AMERICA'],
            ['codigo' => 'US', 'nombre' => 'Estados Unidos', 'region' => 'NORTE AMERICA'],
            ['codigo' => 'MX', 'nombre' => 'México', 'region' => 'NORTE AMERICA'],

            // Centro América y Caribe
            ['codigo' => 'BZ', 'nombre' => 'Belice', 'region' => 'CENTRO AMERICA - CARIBE'],
            ['codigo' => 'CR', 'nombre' => 'Costa Rica', 'region' => 'CENTRO AMERICA - CARIBE'],
            ['codigo' => 'SV', 'nombre' => 'El Salvador', 'region' => 'CENTRO AMERICA - CARIBE'],
            ['codigo' => 'GT', 'nombre' => 'Guatemala', 'region' => 'CENTRO AMERICA - CARIBE'],
            ['codigo' => 'HN', 'nombre' => 'Honduras', 'region' => 'CENTRO AMERICA - CARIBE'],
            ['codigo' => 'NI', 'nombre' => 'Nicaragua', 'region' => 'CENTRO AMERICA - CARIBE'],
            ['codigo' => 'PA', 'nombre' => 'Panamá', 'region' => 'CENTRO AMERICA - CARIBE'],
            ['codigo' => 'CU', 'nombre' => 'Cuba', 'region' => 'CENTRO AMERICA - CARIBE'],
            ['codigo' => 'DO', 'nombre' => 'República Dominicana', 'region' => 'CENTRO AMERICA - CARIBE'],
            ['codigo' => 'HT', 'nombre' => 'Haití', 'region' => 'CENTRO AMERICA - CARIBE'],
            ['codigo' => 'JM', 'nombre' => 'Jamaica', 'region' => 'CENTRO AMERICA - CARIBE'],
            ['codigo' => 'PR', 'nombre' => 'Puerto Rico', 'region' => 'CENTRO AMERICA - CARIBE'],
            ['codigo' => 'TT', 'nombre' => 'Trinidad y Tobago', 'region' => 'CENTRO AMERICA - CARIBE'],

            // Europa y Mediterráneo
            ['codigo' => 'ES', 'nombre' => 'España', 'region' => 'EUROPA MEDITERRANEO - ANTILLAS HOLANDESAS'],
            ['codigo' => 'FR', 'nombre' => 'Francia', 'region' => 'EUROPA MEDITERRANEO - ANTILLAS HOLANDESAS'],
            ['codigo' => 'IT', 'nombre' => 'Italia', 'region' => 'EUROPA MEDITERRANEO - ANTILLAS HOLANDESAS'],
            ['codigo' => 'PT', 'nombre' => 'Portugal', 'region' => 'EUROPA MEDITERRANEO - ANTILLAS HOLANDESAS'],
            ['codigo' => 'GB', 'nombre' => 'Reino Unido', 'region' => 'EUROPA MEDITERRANEO - ANTILLAS HOLANDESAS'],
            ['codigo' => 'DE', 'nombre' => 'Alemania', 'region' => 'EUROPA MEDITERRANEO - ANTILLAS HOLANDESAS'],
            ['codigo' => 'NL', 'nombre' => 'Países Bajos', 'region' => 'EUROPA MEDITERRANEO - ANTILLAS HOLANDESAS'],
            ['codigo' => 'BE', 'nombre' => 'Bélgica', 'region' => 'EUROPA MEDITERRANEO - ANTILLAS HOLANDESAS'],
            ['codigo' => 'CH', 'nombre' => 'Suiza', 'region' => 'EUROPA MEDITERRANEO - ANTILLAS HOLANDESAS'],
            ['codigo' => 'AT', 'nombre' => 'Austria', 'region' => 'EUROPA MEDITERRANEO - ANTILLAS HOLANDESAS'],
            ['codigo' => 'GR', 'nombre' => 'Grecia', 'region' => 'EUROPA MEDITERRANEO - ANTILLAS HOLANDESAS'],

            // Asia, África, Oceanía
            ['codigo' => 'CN', 'nombre' => 'China', 'region' => 'RUSIA, ASIA, AFRICA, OCEANIA, RESTO DEL MUNDO'],
            ['codigo' => 'JP', 'nombre' => 'Japón', 'region' => 'RUSIA, ASIA, AFRICA, OCEANIA, RESTO DEL MUNDO'],
            ['codigo' => 'IN', 'nombre' => 'India', 'region' => 'RUSIA, ASIA, AFRICA, OCEANIA, RESTO DEL MUNDO'],
            ['codigo' => 'AU', 'nombre' => 'Australia', 'region' => 'RUSIA, ASIA, AFRICA, OCEANIA, RESTO DEL MUNDO'],
            ['codigo' => 'NZ', 'nombre' => 'Nueva Zelanda', 'region' => 'RUSIA, ASIA, AFRICA, OCEANIA, RESTO DEL MUNDO'],
            ['codigo' => 'RU', 'nombre' => 'Rusia', 'region' => 'RUSIA, ASIA, AFRICA, OCEANIA, RESTO DEL MUNDO'],
            ['codigo' => 'ZA', 'nombre' => 'Sudáfrica', 'region' => 'RUSIA, ASIA, AFRICA, OCEANIA, RESTO DEL MUNDO'],
        ];

        foreach ($paises as $paisData) {
            $region = Region::where('nombre', $paisData['region'])->first();

            Pais::create([
                'codigo' => $paisData['codigo'],
                'nombre' => $paisData['nombre'],
                'region_id' => $region?->id,
                'activo' => true,
            ]);
        }
    }
}
