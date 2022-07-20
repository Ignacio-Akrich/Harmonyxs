<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnuncioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ads')->insert([
            [
                'title' => 'Banda de Heavy Metal busca guitarra solista',
                'description' => 'Buscamos a un guitarrista solista que esté dispuesto a darlo todo musicalmente. Debe haber buen rollo, pero también seriedad y compromiso. Aspiramos a salir a dar bolos y luego componer temas propios.

                Ahora mismo estamos tocando en un casal de joves de Palma que tiene un local con mesa de mezclas. El local es totalmente gratuito, pero al ser un casal de joves, deberías tener entre 16 y 30 años para poder utilizarlo.

                HORARIO DISPONIBLE DEL LOCAL: Todos los sábados de 17:30 a 20:30.

                Bandas que solemos tocar: AC/DC, Judas Priest, Scorpions, Metallica, Airbourne, etc.',
                'image' => '/images/home/guitar.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'music_genre' => 'Heavy metal',
                'user_id' => 1
            ],
            [
                'title' => 'Cantante busca banda de Blues',
                'description' => 'Soy vocalista aficionada y busco músicos que quieran formar una banda con buen gusto como hobby en Palma de Mallorca. Además, toco el ukelele y la guitarra. Mi objetivo es crecer, aprender de buenos músicos y si congeniamos, formar una pequeña familia musical que nos aporte algo a todos.',
                'image' => '/images/home/discos.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'music_genre' => 'Blues',
                'user_id' => 1
            ],
            [
                'title' => 'Se busca gente para formar banda desde 0',
                'description' => 'Muy buenas, me llamo David y busco gente que quiera formar algo desde 0.
                Principalmente Rock. Toco la guitarra, asi que me interesaria encontrar bajo, bateria, cantante, etc...
                Mis gustos son principalmente heroes del silencio, Muse, pearl jam, RHCP, OASIS, etc...
                La intencion es pasarlo bien y luego ya ver que pasa.
                Dime cosas!',
                'image' => '/images/home/discoazul.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'music_genre' => 'Rock',
                'user_id' => 1
            ]
        ]);
    }
}
