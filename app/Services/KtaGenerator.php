<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\KtaBackground;

class KtaGenerator
{
    public static function generate($player)
    {
        $club = $player->club;

        // ==============================
        // 1️⃣ Generate Nomor KTA
        // ==============================
        if (!$player->kta_number) {
            $code = $club->short_name ?: strtoupper(substr(preg_replace('/[^A-Z]/i','',$club->name),0,6));
            $num = $club->players()->whereNotNull('kta_number')->count() + 1;
            $player->kta_number = 'KEB-'.$code.'-'.str_pad($num,4,'0',STR_PAD_LEFT);
            $player->save();
        }

        // ==============================
        // 2️⃣ Ambil Background Aktif
        // ==============================
        $bg = KtaBackground::where('owner_type','club')
            ->where('owner_id',$club->id)
            ->where('is_active',1)
            ->first();

        if (!$bg) {
            $bg = KtaBackground::where('owner_type','assbi')
                ->where('is_active',1)
                ->first();
        }

        if (!$bg) {
            throw new \Exception("Background KTA belum tersedia");
        }

        $bgPath = storage_path('app/public/'.$bg->image_path);

        // ==============================
        // 3️⃣ Load Background (PNG / JPG)
        // ==============================
        $bgExt = strtolower(pathinfo($bgPath, PATHINFO_EXTENSION));
        if ($bgExt === 'png') {
            $canvas = imagecreatefrompng($bgPath);
        } else {
            $canvas = imagecreatefromjpeg($bgPath);
        }

        $w = imagesx($canvas);
        $h = imagesy($canvas);

        if ($w > 620 || $h > 874) {
            $resized = imagecreatetruecolor(620, 874);
            imagecopyresampled($resized, $canvas, 0,0,0,0, 620,874, $w,$h);
            imagedestroy($canvas);
            $canvas = $resized;
        }


        imagealphablending($canvas, true);
        imagesavealpha($canvas, true);

        // ==============================
        // 4️⃣ Foto Pemain
        // ==============================
        if ($player->photo) {
            $photoPath = storage_path('app/public/'.$player->photo);
            $photoExt = strtolower(pathinfo($photoPath, PATHINFO_EXTENSION));

            if ($photoExt === 'png') {
                $photo = imagecreatefrompng($photoPath);
            } else {
                $photo = imagecreatefromjpeg($photoPath);
            }

            $photoResized = imagecreatetruecolor(200, 260);
            imagecopyresampled(
                $photoResized, $photo,
                0, 0, 0, 0,
                200, 260,
                imagesx($photo), imagesy($photo)
            );

            imagecopy($canvas, $photoResized, 40, 120, 0, 0, 200, 260);
        }

        $black = imagecolorallocate($canvas, 20, 20, 20);

        // Warna
        $black = imagecolorallocate($canvas, 20, 20, 20);

        // Nama (bold palsu)
        imagestring($canvas, 5, 270, 140, $player->name, $black);

        // TTL
        imagestring($canvas, 3, 270, 180,
            $player->birth_place.', '.date('d-m-Y', strtotime($player->birth_date)),
            $black
        );

        // Club
        imagestring($canvas, 3, 270, 210, $club->name, $black);

        // No KTA
        imagestring($canvas, 3, 270, 240, $player->kta_number, $black);

        // ==============================
        // 7️⃣ Simpan PNG
        // ==============================
        $dir = "kta/{$club->id}";
        Storage::disk('public')->makeDirectory($dir);

        $file = "{$dir}/{$player->id}.png";
        imagepng($canvas, storage_path('app/public/'.$file), 9);

        // ==============================
        // 8️⃣ Bersihkan RAM
        // ==============================
        if (isset($photo)) imagedestroy($photo);
        if (isset($photoResized)) imagedestroy($photoResized);
        imagedestroy($canvas);
        gc_collect_cycles();

        // ==============================
        // 9️⃣ Simpan Path ke Player
        // ==============================
        $player->kta_path = $file;
        $player->save();


    }
}
