<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/register',
        '/login',
        '/sms',
        '/forgot',
        '/user/edit',
        '/user/glory_add',
        '/user/glory_edit',
        '/user/glory_del',
        '/carousel/add',
        '/carousel/del',
        '/type/add',
        '/type/del',
        '/desc/add',
        '/desc/edit',
        '/desc/del',
        '/raider/add',
        '/raider/edit',
        '/raider/del',
        '/team/add',
        '/team/member_add',
        '/team/edit',
        '/team/del',
    ];
}
