<?php

namespace Mitoop\Yzh;

class Config
{
    public static string $payRemark;

    public static string $notifyUrl;

    public static string $projectId;

    public static function payRemarkUsing($remark): void
    {
        static::$payRemark = $remark;
    }

    public static function notifyUrlUsing($url): void
    {
        static::$notifyUrl = $url;
    }

    public static function projectIdUsing($id): void
    {
        static::$projectId = $id;
    }
}
