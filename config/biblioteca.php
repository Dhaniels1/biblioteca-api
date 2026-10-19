<?php

return [
    // Por padrão, cadastro público é permitido apenas em desenvolvimento/testes.
    // Em produção, crie usuários de confiança por uma operação administrativa.
    'public_registration' => (bool) env(
        'API_ALLOW_PUBLIC_REGISTRATION',
        env('APP_ENV', 'production') !== 'production'
    ),
];
