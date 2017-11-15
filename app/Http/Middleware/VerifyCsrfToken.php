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
        '/carousel/add',
        '/carousel/del',
        '/type/add',
        '/type/del',
        '/desc/add',
        '/desc/edit',
        '/desc/del',
        '/team/add',
        '/team/edit',
        '/team/del',
    ];
}
