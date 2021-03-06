<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WitelTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('witel')->delete();
        
        \DB::table('witel')->insert(array (
            0 => 
            array (
                'id' => 'AABetmABAAABL+DAAA',
                'witel' => 'GORONTALO',
                'divisi' => 'TIMUR',
                'urut' => '63',
                'witel_txt' => 'GORONTALO',
                'witel_2' => 'GORONTALO',
                'sink_witel' => 'GORONTALO',
                'regional' => '7',
                'bsr' => '10',
                'provinsi' => 'GORONTALO',
                'msn' => '49',
            ),
            1 => 
            array (
                'id' => 'AABetmABAAABL+EAAA',
                'witel' => 'BANDUNGBRT',
                'divisi' => 'BARAT',
                'urut' => '64',
                'witel_txt' => 'BANDUNG BARAT',
                'witel_2' => 'BANDUNGBRT',
                'sink_witel' => 'BANDUNGBRT',
                'regional' => '3',
                'bsr' => '5',
                'provinsi' => 'JAWA BARAT',
                'msn' => '62',
            ),
            2 => 
            array (
                'id' => 'AABetmABAAABL+FAAA',
                'witel' => 'SIDOARJO',
                'divisi' => 'TIMUR',
                'urut' => '39',
            'witel_txt' => 'TELKOM JATIM TENGAH TIMUR (SIDOARJO)',
                'witel_2' => 'SIDOARJO',
                'sink_witel' => 'SIDOARJO',
                'regional' => '5',
                'bsr' => '7',
                'provinsi' => 'JAWA TIMUR',
                'msn' => '37',
            ),
            3 => 
            array (
                'id' => 'AABetmABAAABL+FAAB',
                'witel' => 'RIKEP',
                'divisi' => 'BARAT',
                'urut' => '4',
            'witel_txt' => 'TELKOM RIAU KEPULAUAN (BATAM)',
                'witel_2' => 'BATAM',
                'sink_witel' => 'BATAM',
                'regional' => '1',
                'bsr' => '1',
                'provinsi' => 'RIAU',
                'msn' => '7',
            ),
            4 => 
            array (
                'id' => 'AABetmABAAABL+FAAC',
                'witel' => 'JAKARTA BARAT',
                'divisi' => 'BARAT',
                'urut' => '14',
                'witel_txt' => 'TELKOM JAKARTA BARAT',
                'witel_2' => 'JAKARTA BARAT',
                'sink_witel' => 'JAK. BARAT',
                'regional' => '2',
                'bsr' => '4',
                'provinsi' => 'DKI JAKARTA',
                'msn' => '12',
            ),
            5 => 
            array (
                'id' => 'AABetmABAAABL+FAAD',
                'witel' => 'JAKARTA PUSAT',
                'divisi' => 'BARAT',
                'urut' => '15',
                'witel_txt' => 'TELKOM JAKARTA PUSAT',
                'witel_2' => 'JAKARTA PUSAT',
                'sink_witel' => 'JAK. PUSAT',
                'regional' => '2',
                'bsr' => '4',
                'provinsi' => 'DKI JAKARTA',
                'msn' => '14',
            ),
            6 => 
            array (
                'id' => 'AABetmABAAABL+FAAE',
                'witel' => 'JAKARTA TIMUR',
                'divisi' => 'BARAT',
                'urut' => '17',
                'witel_txt' => 'TELKOM JAKARTA TIMUR',
                'witel_2' => 'JAKARTA TIMUR',
                'sink_witel' => 'JAK. TIMUR',
                'regional' => '2',
                'bsr' => '4',
                'provinsi' => 'DKI JAKARTA',
                'msn' => '16',
            ),
            7 => 
            array (
                'id' => 'AABetmABAAABL+FAAF',
                'witel' => 'PEKALONGAN',
                'divisi' => 'TIMUR',
                'urut' => '26',
            'witel_txt' => 'TELKOM JATENG BARAT UTARA (PEKALONGAN)',
                'witel_2' => 'PEKALONGAN',
                'sink_witel' => 'PEKALONGAN',
                'regional' => '4',
                'bsr' => '6',
                'provinsi' => 'JAWA TENGAH',
                'msn' => '27',
            ),
            8 => 
            array (
                'id' => 'AABetmABAAABL+FAAG',
                'witel' => 'YOGYAKARTA',
                'divisi' => 'TIMUR',
                'urut' => '32',
                'witel_txt' => 'TELKOM DI YOGYAKARTA',
                'witel_2' => 'YOGYAKARTA',
                'sink_witel' => 'YOGYAKARTA',
                'regional' => '4',
                'bsr' => '6',
                'provinsi' => 'YOGYAKARTA',
                'msn' => '33',
            ),
            9 => 
            array (
                'id' => 'AABetmABAAABL+FAAH',
            'witel' => 'JABAR BARAT (BOGOR)',
                'divisi' => 'BARAT',
                'urut' => '21',
            'witel_txt' => 'TELKOM JABAR BARAT (BOGOR)',
                'witel_2' => 'BOGOR',
                'sink_witel' => 'BOGOR',
                'regional' => '2',
                'bsr' => '5',
                'provinsi' => 'JAWA BARAT',
                'msn' => '19',
            ),
            10 => 
            array (
                'id' => 'AABetmABAAABL+FAAI',
                'witel' => 'SURABAYA UTARA',
                'divisi' => 'TIMUR',
                'urut' => '37',
            'witel_txt' => 'TELKOM JATIM UTARA (GRESIK)',
                'witel_2' => 'GRESIK',
                'sink_witel' => 'GRESIK',
                'regional' => '5',
                'bsr' => '7',
                'provinsi' => 'JAWA TIMUR',
                'msn' => '39',
            ),
            11 => 
            array (
                'id' => 'AABetmABAAABL+FAAJ',
                'witel' => 'JAKARTA UTARA',
                'divisi' => 'BARAT',
                'urut' => '16',
                'witel_txt' => 'TELKOM JAKARTA UTARA',
                'witel_2' => 'JAKARTA UTARA',
                'sink_witel' => 'JAK. UTARA',
                'regional' => '2',
                'bsr' => '4',
                'provinsi' => 'DKI JAKARTA',
                'msn' => '15',
            ),
            12 => 
            array (
                'id' => 'AABetmABAAABL+FAAK',
                'witel' => 'PAPUA',
                'divisi' => 'TIMUR',
                'urut' => '61',
            'witel_txt' => 'TELKOM PAPUA (JAYAPURA)',
                'witel_2' => 'JAYAPURA',
                'sink_witel' => 'JAYAPURA',
                'regional' => '7',
                'bsr' => '10',
                'provinsi' => 'PAPUA',
                'msn' => '61',
            ),
            13 => 
            array (
                'id' => 'AABetmABAAABL+FAAM',
                'witel' => 'SULTRA',
                'divisi' => 'TIMUR',
                'urut' => '55',
            'witel_txt' => 'TELKOM SULTRA (KENDARI)',
                'witel_2' => 'KENDARI',
                'sink_witel' => 'KENDARI',
                'regional' => '7',
                'bsr' => '10',
                'provinsi' => 'SULAWESI TENGGARA',
                'msn' => '53',
            ),
            14 => 
            array (
                'id' => 'AABetmABAAABL+FAAN',
                'witel' => 'NTT',
                'divisi' => 'TIMUR',
                'urut' => '51',
            'witel_txt' => 'TELKOM NTT (KUPANG)',
                'witel_2' => 'KUPANG',
                'sink_witel' => 'KUPANG',
                'regional' => '5',
                'bsr' => '9',
                'provinsi' => 'NUSA TENGGARA TIMUR',
                'msn' => '57',
            ),
            15 => 
            array (
                'id' => 'AABetmABAAABL+FAAO',
                'witel' => 'MALANG',
                'divisi' => 'TIMUR',
                'urut' => '36',
            'witel_txt' => 'TELKOM JATIM SELATAN (MALANG)',
                'witel_2' => 'MALANG',
                'sink_witel' => 'MALANG',
                'regional' => '5',
                'bsr' => '7',
                'provinsi' => 'JAWA TIMUR',
                'msn' => '36',
            ),
            16 => 
            array (
                'id' => 'AABetmABAAABL+FAAP',
                'witel' => 'SULTENG',
                'divisi' => 'TIMUR',
                'urut' => '54',
            'witel_txt' => 'TELKOM SULTENG (PALU)',
                'witel_2' => 'PALU',
                'sink_witel' => 'PALU',
                'regional' => '7',
                'bsr' => '10',
                'provinsi' => 'SULAWESI TENGAH',
                'msn' => '50',
            ),
            17 => 
            array (
                'id' => 'AABetmABAAABL+FAAR',
                'witel' => 'SURABAYA SELATAN',
                'divisi' => 'TIMUR',
                'urut' => '38',
            'witel_txt' => 'TELKOM JATIM SURAMADU (SURABAYA)',
                'witel_2' => 'SURABAYA',
                'sink_witel' => 'SURABAYA',
                'regional' => '5',
                'bsr' => '7',
                'provinsi' => 'JAWA TIMUR',
                'msn' => '38',
            ),
            18 => 
            array (
                'id' => 'AABetmABAAABL+FAAS',
                'witel' => 'BENGKULU',
                'divisi' => 'BARAT',
                'urut' => '8',
            'witel_txt' => 'TELKOM BENGKULU (BENGKULU)',
                'witel_2' => 'BENGKULU',
                'sink_witel' => 'BENGKULU',
                'regional' => '1',
                'bsr' => '3',
                'provinsi' => 'BENGKULU',
                'msn' => '8',
            ),
            19 => 
            array (
                'id' => 'AABetmABAAABL+FAAT',
                'witel' => 'DENPASAR',
                'divisi' => 'TIMUR',
                'urut' => '48',
            'witel_txt' => 'TELKOM BALI SELATAN (DENPASAR)',
                'witel_2' => 'BALI SELATAN',
                'sink_witel' => 'BALI SELATAN',
                'regional' => '5',
                'bsr' => '9',
                'provinsi' => 'BALI',
                'msn' => '54',
            ),
            20 => 
            array (
                'id' => 'AABetmABAAABL+FAAU',
                'witel' => 'MEDAN',
                'divisi' => 'BARAT',
                'urut' => '3',
            'witel_txt' => 'TELKOM SUMUT BARAT (MEDAN)',
                'witel_2' => 'MEDAN',
                'sink_witel' => 'MEDAN',
                'regional' => '1',
                'bsr' => '1',
                'provinsi' => 'SUMATERA UTARA',
                'msn' => '2',
            ),
            21 => 
            array (
                'id' => 'AABetmABAAABL+FAAV',
                'witel' => 'CIREBON',
                'divisi' => 'BARAT',
                'urut' => '23',
            'witel_txt' => 'TELKOM JABAR TIMUR (CIREBON)',
                'witel_2' => 'CIREBON',
                'sink_witel' => 'CIREBON',
                'regional' => '3',
                'bsr' => '5',
                'provinsi' => 'JAWA BARAT',
                'msn' => '25',
            ),
            22 => 
            array (
                'id' => 'AABetmABAAABL+FAAW',
                'witel' => 'KALTENG',
                'divisi' => 'TIMUR',
                'urut' => '44',
            'witel_txt' => 'TELKOM KALTENG (PALANGKARAYA)',
                'witel_2' => 'PALANGKARAYA',
                'sink_witel' => 'PALANGKARAYA',
                'regional' => '6',
                'bsr' => '8',
                'provinsi' => 'KALIMANTAN TENGAH',
                'msn' => '43',
            ),
            23 => 
            array (
                'id' => 'AABetmABAAABL+FAAX',
            'witel' => 'BANTEN TIMUR (TANGERANG)',
                'divisi' => 'BARAT',
                'urut' => '13',
            'witel_txt' => 'TELKOM BANTEN TIMUR (TANGERANG)',
                'witel_2' => 'TANGERANG',
                'sink_witel' => 'TANGERANG',
                'regional' => '2',
                'bsr' => '4',
                'provinsi' => 'BANTEN',
                'msn' => '18',
            ),
            24 => 
            array (
                'id' => 'AABetmABAAABL+FAAZ',
                'witel' => 'KUDUS',
                'divisi' => 'TIMUR',
                'urut' => '29',
            'witel_txt' => 'TELKOM JATENG TIMUR UTARA (KUDUS)',
                'witel_2' => 'KUDUS',
                'sink_witel' => 'KUDUS',
                'regional' => '4',
                'bsr' => '6',
                'provinsi' => 'JAWA TENGAH',
                'msn' => '31',
            ),
            25 => 
            array (
                'id' => 'AABetmABAAABL+FAAa',
                'witel' => 'SINGARAJA',
                'divisi' => 'TIMUR',
                'urut' => '49',
            'witel_txt' => 'TELKOM BALI UTARA (SINGARAJA)',
                'witel_2' => 'BALI UTARA',
                'sink_witel' => 'BALI UTARA',
                'regional' => '5',
                'bsr' => '9',
                'provinsi' => 'BALI',
                'msn' => '55',
            ),
            26 => 
            array (
                'id' => 'AABetmABAAABL+FAAb',
                'witel' => 'SUMUT',
                'divisi' => 'BARAT',
                'urut' => '2',
            'witel_txt' => 'TELKOM SUMUT TIMUR (PEMATANG SIANTAR)',
                'witel_2' => 'PEMATANGSIANTAR',
                'sink_witel' => 'P. SIANTAR',
                'regional' => '1',
                'bsr' => '1',
                'provinsi' => 'SUMATERA UTARA',
                'msn' => '3',
            ),
            27 => 
            array (
                'id' => 'AABetmABAAABL+FAAc',
                'witel' => 'MADIUN',
                'divisi' => 'TIMUR',
                'urut' => '34',
            'witel_txt' => 'TELKOM JATIM BARAT (MADIUN)',
                'witel_2' => 'MADIUN',
                'sink_witel' => 'MADIUN',
                'regional' => '5',
                'bsr' => '7',
                'provinsi' => 'JAWA TIMUR',
                'msn' => '34',
            ),
            28 => 
            array (
                'id' => 'AABetmABAAABL+FAAd',
                'witel' => 'KALTARA',
                'divisi' => 'TIMUR',
                'urut' => '46',
            'witel_txt' => 'TELKOM KALTIMUT (TARAKAN)',
                'witel_2' => 'TARAKAN',
                'sink_witel' => 'TARAKAN',
                'regional' => '6',
                'bsr' => '8',
                'provinsi' => 'KALIMANTAN TIMUR',
                'msn' => '47',
            ),
            29 => 
            array (
                'id' => 'AABetmABAAABL+FAAe',
                'witel' => 'BABEL',
                'divisi' => 'BARAT',
                'urut' => '9',
            'witel_txt' => 'TELKOM BANGKA BELITUNG (PANGKAL PINANG)',
                'witel_2' => 'PANGKALPINANG',
                'sink_witel' => 'P. PINANG',
                'regional' => '1',
                'bsr' => '3',
                'provinsi' => 'BANGKA BELITUNG',
                'msn' => '10',
            ),
            30 => 
            array (
                'id' => 'AABetmABAAABL+FAAf',
                'witel' => 'KALBAR',
                'divisi' => 'TIMUR',
                'urut' => '42',
            'witel_txt' => 'TELKOM KALBAR (PONTIANAK)',
                'witel_2' => 'PONTIANAK',
                'sink_witel' => 'PONTIANAK',
                'regional' => '6',
                'bsr' => '8',
                'provinsi' => 'KALIMANTAN BARAT',
                'msn' => '42',
            ),
            31 => 
            array (
                'id' => 'AABetmABAAABL+FAAg',
                'witel' => 'ACEH',
                'divisi' => 'BARAT',
                'urut' => '1',
            'witel_txt' => 'TELKOM NAD (ACEH)',
                'witel_2' => 'NAD',
                'sink_witel' => 'NAD',
                'regional' => '1',
                'bsr' => '1',
                'provinsi' => 'NAD ACEH',
                'msn' => '1',
            ),
            32 => 
            array (
                'id' => 'AABetmABAAABL+FAAh',
                'witel' => 'TASIKMALAYA',
                'divisi' => 'BARAT',
                'urut' => '24',
            'witel_txt' => 'TELKOM JABAR TIMSEL (TASIKMALAYA)',
                'witel_2' => 'TASIKMALAYA',
                'sink_witel' => 'TASIKMALAYA',
                'regional' => '3',
                'bsr' => '5',
                'provinsi' => 'JAWA BARAT',
                'msn' => '24',
            ),
            33 => 
            array (
                'id' => 'AABetmABAAABL+FAAi',
                'witel' => 'SAMARINDA',
                'divisi' => 'TIMUR',
                'urut' => '45',
            'witel_txt' => 'TELKOM KALTIMTENG (SAMARINDA)',
                'witel_2' => 'SAMARINDA',
                'sink_witel' => 'SAMARINDA',
                'regional' => '6',
                'bsr' => '8',
                'provinsi' => 'KALIMANTAN TIMUR',
                'msn' => '46',
            ),
            34 => 
            array (
                'id' => 'AABetmABAAABL+FAAj',
                'witel' => 'SEMARANG',
                'divisi' => 'TIMUR',
                'urut' => '28',
            'witel_txt' => 'TELKOM JATENG UTARA (SEMARANG)',
                'witel_2' => 'SEMARANG',
                'sink_witel' => 'SEMARANG',
                'regional' => '4',
                'bsr' => '6',
                'provinsi' => 'JAWA TENGAH',
                'msn' => '32',
            ),
            35 => 
            array (
                'id' => 'AABetmABAAABL+FAAk',
                'witel' => 'NTB',
                'divisi' => 'TIMUR',
                'urut' => '50',
            'witel_txt' => 'TELKOM NTB (MATARAM)',
                'witel_2' => 'MATARAM',
                'sink_witel' => 'MATARAM',
                'regional' => '5',
                'bsr' => '9',
                'provinsi' => 'NUSA TENGGARA BARAT',
                'msn' => '56',
            ),
            36 => 
            array (
                'id' => 'AABetmABAAABL+FAAl',
                'witel' => 'SULSELBAR',
                'divisi' => 'TIMUR',
                'urut' => '53',
            'witel_txt' => 'TELKOM SULSEL BARAT (PARE-PARE)',
                'witel_2' => 'PARE-PARE',
                'sink_witel' => 'PARE-PARE',
                'regional' => '7',
                'bsr' => '10',
                'provinsi' => 'SULAWESI SELATAN',
                'msn' => '51',
            ),
            37 => 
            array (
                'id' => 'AABetmABAAABL+FAAm',
                'witel' => 'RIDAR',
                'divisi' => 'BARAT',
                'urut' => '5',
            'witel_txt' => 'TELKOM RIAU DARATAN (PEKANBARU)',
                'witel_2' => 'PEKANBARU',
                'sink_witel' => 'PEKANBARU',
                'regional' => '1',
                'bsr' => '2',
                'provinsi' => 'RIAU',
                'msn' => '5',
            ),
            38 => 
            array (
                'id' => 'AABetmABAAABL+FAAn',
                'witel' => 'MALUKU',
                'divisi' => 'TIMUR',
                'urut' => '59',
            'witel_txt' => 'TELKOM MALUKU (AMBON)',
                'witel_2' => 'AMBON',
                'sink_witel' => 'AMBON',
                'regional' => '7',
                'bsr' => '10',
                'provinsi' => 'MALUKU',
                'msn' => '59',
            ),
            39 => 
            array (
                'id' => 'AABetmABAAABL+FAAo',
                'witel' => 'LAMPUNG',
                'divisi' => 'BARAT',
                'urut' => '11',
            'witel_txt' => 'TELKOM LAMPUNG (BANDAR LAMPUNG)',
                'witel_2' => 'LAMPUNG',
                'sink_witel' => 'LAMPUNG',
                'regional' => '1',
                'bsr' => '3',
                'provinsi' => 'LAMPUNG',
                'msn' => '11',
            ),
            40 => 
            array (
                'id' => 'AABetmABAAABL+FAAp',
                'witel' => 'KALSEL',
                'divisi' => 'TIMUR',
                'urut' => '43',
            'witel_txt' => 'TELKOM KALSEL (BANJARMASIN)',
                'witel_2' => 'BANJARMASIN',
                'sink_witel' => 'BANJARMASIN',
                'regional' => '6',
                'bsr' => '8',
                'provinsi' => 'KALIMANTAN SELATAN',
                'msn' => '44',
            ),
            41 => 
            array (
                'id' => 'AABetmABAAABL+FAAq',
            'witel' => 'JABAR BARAT UTARA (BEKASI)',
                'divisi' => 'BARAT',
                'urut' => '19',
            'witel_txt' => 'TELKOM JABAR BARAT UTARA (BEKASI)',
                'witel_2' => 'BEKASI',
                'sink_witel' => 'BEKASI',
                'regional' => '2',
                'bsr' => '4',
                'provinsi' => 'JAWA BARAT',
                'msn' => '20',
            ),
            42 => 
            array (
                'id' => 'AABetmABAAABL+FAAr',
                'witel' => 'SUKABUMI',
                'divisi' => 'BARAT',
                'urut' => '22',
            'witel_txt' => 'TELKOM JABAR SELATAN (SUKABUMI)',
                'witel_2' => 'SUKABUMI',
                'sink_witel' => 'SUKABUMI',
                'regional' => '3',
                'bsr' => '5',
                'provinsi' => 'JAWA BARAT',
                'msn' => '22',
            ),
            43 => 
            array (
                'id' => 'AABetmABAAABL+FAAs',
            'witel' => 'BANTEN (SERANG)',
                'divisi' => 'BARAT',
                'urut' => '12',
            'witel_txt' => 'TELKOM BANTEN BARAT (SERANG)',
                'witel_2' => 'SERANG',
                'sink_witel' => 'SERANG',
                'regional' => '2',
                'bsr' => '4',
                'provinsi' => 'BANTEN',
                'msn' => '17',
            ),
            44 => 
            array (
                'id' => 'AABetmABAAABL+FAAt',
                'witel' => 'MAGELANG',
                'divisi' => 'TIMUR',
                'urut' => '31',
            'witel_txt' => 'TELKOM JATENG SELATAN (MAGELANG)',
                'witel_2' => 'MAGELANG',
                'sink_witel' => 'MAGELANG',
                'regional' => '4',
                'bsr' => '6',
                'provinsi' => 'JAWA TENGAH',
                'msn' => '28',
            ),
            45 => 
            array (
                'id' => 'AABetmABAAABL+FAAv',
                'witel' => 'JAKARTA SELATAN',
                'divisi' => 'BARAT',
                'urut' => '18',
                'witel_txt' => 'TELKOM JAKARTA SELATAN',
                'witel_2' => 'JAKARTA SELATAN',
                'sink_witel' => 'JAK. SELATAN',
                'regional' => '2',
                'bsr' => '4',
                'provinsi' => 'DKI JAKARTA',
                'msn' => '13',
            ),
            46 => 
            array (
                'id' => 'AABetmABAAABL+FAAw',
                'witel' => 'SUMSEL',
                'divisi' => 'BARAT',
                'urut' => '10',
            'witel_txt' => 'TELKOM SUMATERA SELATAN (PALEMBANG)',
                'witel_2' => 'PALEMBANG',
                'sink_witel' => 'PALEMBANG',
                'regional' => '1',
                'bsr' => '3',
                'provinsi' => 'SUMATERA SELATAN',
                'msn' => '9',
            ),
            47 => 
            array (
                'id' => 'AABetmABAAABL+FAAx',
                'witel' => 'PAPUA BARAT',
                'divisi' => 'TIMUR',
                'urut' => '60',
            'witel_txt' => 'TELKOM PAPUA BARAT (SORONG)',
                'witel_2' => 'SORONG',
                'sink_witel' => 'SORONG',
                'regional' => '7',
                'bsr' => '10',
                'provinsi' => 'PAPUA BARAT',
                'msn' => '60',
            ),
            48 => 
            array (
                'id' => 'AABetmABAAABL+FAAy',
                'witel' => 'KARAWANG',
                'divisi' => 'BARAT',
                'urut' => '20',
            'witel_txt' => 'TELKOM JABAR UTARA (KARAWANG)',
                'witel_2' => 'KARAWANG',
                'sink_witel' => 'KARAWANG',
                'regional' => '3',
                'bsr' => '4',
                'provinsi' => 'JAWA BARAT',
                'msn' => '21',
            ),
            49 => 
            array (
                'id' => 'AABetmABAAABL+FAAz',
                'witel' => 'KEDIRI',
                'divisi' => 'TIMUR',
                'urut' => '35',
            'witel_txt' => 'TELKOM JATIM TENGAH (KEDIRI)',
                'witel_2' => 'KEDIRI',
                'sink_witel' => 'KEDIRI',
                'regional' => '5',
                'bsr' => '7',
                'provinsi' => 'JAWA TIMUR',
                'msn' => '35',
            ),
            50 => 
            array (
                'id' => 'AABetmABAAABL+FAA0',
                'witel' => 'SULUT MALUT',
                'divisi' => 'TIMUR',
                'urut' => '57',
                'witel_txt' => 'TELKOM SULUT MALUT',
                'witel_2' => 'MANADO',
                'sink_witel' => 'MANADO',
                'regional' => '7',
                'bsr' => '10',
                'provinsi' => 'SULAWESI UTARA',
                'msn' => '48',
            ),
            51 => 
            array (
                'id' => 'AABetmABAAABL+FAA1',
                'witel' => 'PASURUAN',
                'divisi' => 'TIMUR',
                'urut' => '41',
            'witel_txt' => 'TELKOM JATIM SELATAN TIMUR (PASURUAN)',
                'witel_2' => 'PASURUAN',
                'sink_witel' => 'PASURUAN',
                'regional' => '5',
                'bsr' => '7',
                'provinsi' => 'JAWA TIMUR',
                'msn' => '40',
            ),
            52 => 
            array (
                'id' => 'AABetmABAAABL+FAA2',
                'witel' => 'PURWOKERTO',
                'divisi' => 'TIMUR',
                'urut' => '27',
            'witel_txt' => 'TELKOM JATENG BARAT SELATAN (PURWOKERTO)',
                'witel_2' => 'PURWOKERTO',
                'sink_witel' => 'PURWOKERTO',
                'regional' => '4',
                'bsr' => '6',
                'provinsi' => 'JAWA TENGAH',
                'msn' => '26',
            ),
            53 => 
            array (
                'id' => 'AABetmABAAABL+FAA3',
                'witel' => 'BALIKPAPAN',
                'divisi' => 'TIMUR',
                'urut' => '47',
            'witel_txt' => 'TELKOM KALTIMSEL (BALIKPAPAN)',
                'witel_2' => 'BALIKPAPAN',
                'sink_witel' => 'BALIKPAPAN',
                'regional' => '6',
                'bsr' => '8',
                'provinsi' => 'KALIMANTAN TIMUR',
                'msn' => '45',
            ),
            54 => 
            array (
                'id' => 'AABetmABAAABL+FAA4',
                'witel' => 'BANDUNG',
                'divisi' => 'BARAT',
                'urut' => '25',
            'witel_txt' => 'TELKOM JABAR TENGAH (BANDUNG)',
                'witel_2' => 'BANDUNG',
                'sink_witel' => 'BANDUNG',
                'regional' => '3',
                'bsr' => '5',
                'provinsi' => 'JAWA BARAT',
                'msn' => '23',
            ),
            55 => 
            array (
                'id' => 'AABetmABAAABL+FAA5',
                'witel' => 'SOLO',
                'divisi' => 'TIMUR',
                'urut' => '33',
            'witel_txt' => 'TELKOM JATENG TIMUR SELATAN (SOLO)',
                'witel_2' => 'SOLO',
                'sink_witel' => 'SOLO',
                'regional' => '4',
                'bsr' => '6',
                'provinsi' => 'JAWA TENGAH',
                'msn' => '30',
            ),
            56 => 
            array (
                'id' => 'AABetmABAAABL+FAA6',
                'witel' => 'JAMBI',
                'divisi' => 'BARAT',
                'urut' => '7',
                'witel_txt' => 'TELKOM JAMBI',
                'witel_2' => 'JAMBI',
                'sink_witel' => 'JAMBI',
                'regional' => '1',
                'bsr' => '2',
                'provinsi' => 'JAMBI',
                'msn' => '6',
            ),
            57 => 
            array (
                'id' => 'AABetmABAAABL+FAA7',
                'witel' => 'MAKASAR',
                'divisi' => 'TIMUR',
                'urut' => '52',
            'witel_txt' => 'TELKOM SULSEL (MAKASAR)',
                'witel_2' => 'MAKASSAR',
                'sink_witel' => 'MAKASSAR',
                'regional' => '7',
                'bsr' => '10',
                'provinsi' => 'SULAWESI SELATAN',
                'msn' => '52',
            ),
            58 => 
            array (
                'id' => 'AABetmABAAABL+FAA8',
                'witel' => 'SUMBAR',
                'divisi' => 'BARAT',
                'urut' => '6',
            'witel_txt' => 'TELKOM SUMATERA BARAT (PADANG)',
                'witel_2' => 'PADANG',
                'sink_witel' => 'PADANG',
                'regional' => '1',
                'bsr' => '2',
                'provinsi' => 'SUMATERA BARAT',
                'msn' => '4',
            ),
            59 => 
            array (
                'id' => 'AABetmABAAABL+FAA9',
                'witel' => 'JEMBER',
                'divisi' => 'TIMUR',
                'urut' => '40',
            'witel_txt' => 'TELKOM JATIM TIMUR (JEMBER)',
                'witel_2' => 'JEMBER',
                'sink_witel' => 'JEMBER',
                'regional' => '5',
                'bsr' => '7',
                'provinsi' => 'JAWA TIMUR',
                'msn' => '41',
            ),
            60 => 
            array (
                'id' => 'AABetmABAAABL+HAAA',
                'witel' => 'MADURA',
                'divisi' => 'TIMUR',
                'urut' => '65',
                'witel_txt' => 'MADURA',
                'witel_2' => 'MADURA',
                'sink_witel' => 'MADURA',
                'regional' => '5',
                'bsr' => '7',
                'provinsi' => 'JAWA TIMUR',
                'msn' => '63',
            ),
        ));
        
        
    }
}