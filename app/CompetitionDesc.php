<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/10/25
 * Time: 16:48
 */

namespace App;


class CompetitionDesc
{
    protected $fillable = [
        'username', 'phone', 'password',
    ];
    protected $table = 'competition_desc';
}