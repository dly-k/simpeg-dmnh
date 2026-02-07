<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
public function indexAdmin()
{
    // Data dummy yang sudah dilengkapi sesuai kolom tabel baru
    $submissions = [
        [
            'id' => 1, 
            'nama' => 'Dr. Ahmad Forest', 
            'nip' => '198501012010011001', 
            'usia' => 41,
            'jabatan_terakhir' => 'Lektor (III/d)',
            'target' => 'Lektor Kepala (IV/a)', 
            'nilai_konversi' => 38.5,
            'tgl_pensiun' => '01 Jan 2045',
            'is_eligible' => true, // Untuk status kelayakan nilai
            'progress' => 75, 
            'status' => 'Verifikasi Berkas'
        ],
        [
            'id' => 2, 
            'nama' => 'Siti Rimba, M.Si', 
            'nip' => '199002022015022002', 
            'usia' => 36,
            'jabatan_terakhir' => 'Asisten Ahli (III/b)',
            'target' => 'Lektor (III/c)', 
            'nilai_konversi' => 12.0,
            'tgl_pensiun' => '02 Feb 2050',
            'is_eligible' => false,
            'progress' => 40, 
            'status' => 'Lengkapi Berkas'
        ],
    ];

    return view('pages.monitoring.admin.index', compact('submissions'));
}
public function detailAdmin($id)
{
    // Pastikan data dummy memiliki key yang sesuai dengan view
    $dosen = [
        'nama' => 'Dr. Ahmad Forest', 
        'nip' => '198501012010011001', 
        'jabatan_terakhir' => 'Lektor (III/d)', // Tambahan key
        'target' => 'Lektor Kepala (IV/a)',
        'tgl_pensiun' => '01 Jan 2045' // Tambahan key
    ];

    $currentKUM = 380;
    $targetKUM = 400;

    $requirements = [
        ['name' => 'SK Jabatan Terakhir', 'is_uploaded' => true, 'is_link' => false, 'path' => 'sk_jabatan.pdf', 'status' => 'Valid'],
        ['name' => 'PAK Terakhir', 'is_uploaded' => true, 'is_link' => true, 'path' => 'https://drive.google.com/example', 'status' => 'Valid'],
        ['name' => 'Publikasi Jurnal Sinta 1/2', 'is_uploaded' => false, 'is_link' => false, 'path' => '', 'status' => 'Belum Ada'],
    ];

    return view('pages.monitoring.admin.detail', compact('dosen', 'currentKUM', 'targetKUM', 'requirements'));
}

public function indexDosen()
{
    $data = [
        'nama' => 'Dr. Fadly Akademisi',
        'target_jabatan' => 'Lektor Kepala (IV/a)',
        'current_kum' => 385.5,
        'target_kum' => 400,
        'tgl_pensiun' => '12 Des 2035',
        'requirements' => [
            ['name' => 'SK Jabatan Terakhir', 'status' => 'Valid', 'is_uploaded' => true, 'path' => 'sk.pdf', 'note' => ''],
            ['name' => 'PAK Terakhir', 'status' => 'Perlu Revisi', 'is_uploaded' => true, 'path' => 'pak_lama.pdf', 'note' => 'File tidak terbaca, mohon scan ulang'],
            ['name' => 'Ijazah Pendidikan Terakhir', 'status' => 'Kosong', 'is_uploaded' => false, 'path' => '', 'note' => ''],
        ]
    ];
    return view('pages.monitoring.dosen.index', compact('data'));
}

}