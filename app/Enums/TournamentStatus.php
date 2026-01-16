<?php

namespace App\Enums;

class TournamentStatus
{
    public const DRAFT     = 'draft';
    public const OPEN      = 'open';
    public const ONGOING   = 'ongoing';
    public const FINISHED  = 'finished';
    public const SUSPENDED = 'suspended';

    /**
     * Label manusiawi (opsional)
     */
    public static function label(string $status): string
    {
        return match ($status) {
            self::DRAFT     => 'Draft',
            self::OPEN      => 'Open',
            self::ONGOING   => 'Berjalan',
            self::FINISHED  => 'Selesai',
            self::SUSPENDED => 'Disuspend',
            default         => strtoupper($status),
        };
    }
}
