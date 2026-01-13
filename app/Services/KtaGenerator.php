<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class KtaGenerator
{
    public static function generate($player)
    {
        $club = $player->club;

        // Generate nomor KTA jika belum ada
        if (!$player->kta_number) {
            $code = $club->short_name ?: strtoupper(substr(preg_replace('/[^A-Z]/i','',$club->name),0,6));
            $num = $club->players()->whereNotNull('kta_number')->count() + 1;
            $player->kta_number = 'KEB-'.$code.'-'.str_pad($num,4,'0',STR_PAD_LEFT);
            $player->save();
        }

        // Folder KTA
        $dir = "kta/{$club->id}";
        Storage::disk('public')->makeDirectory($dir);

        $file = "{$dir}/{$player->id}.png";
        $fullPath = storage_path("app/public/".$file);

        // Render PDF dari Blade
        $pdf = Pdf::loadView('club.players.kta', compact('player'))
            ->setPaper([0, 0, 298, 420]); // A6 portrait

        $pdfPath = storage_path("app/temp_{$player->id}.pdf");
        file_put_contents($pdfPath, $pdf->output());

        // Convert PDF → PNG (Intervention v3 + Imagick)
        $manager = new ImageManager(new Driver());
        $image = $manager->read($pdfPath);
        $image->save($fullPath);

        // Hapus PDF sementara
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }

        // Simpan path KTA
        $player->kta_path = $file;
        $player->save();
    }
}
