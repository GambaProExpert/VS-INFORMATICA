<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');

// Solo el formulario de contacto toca la base de datos, pero refrescarla en
// todo Feature cuesta poco (SQLite en memoria) y evita sorpresas.
uses(RefreshDatabase::class)->in('Feature');
