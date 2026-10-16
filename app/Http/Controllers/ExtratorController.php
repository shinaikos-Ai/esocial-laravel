<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ExtratorController extends Controller
{
    public function index(): View
    {
        $user   = auth()->user();
        // nr_insc já normalizado (só dígitos) ou null
        $nrInsc = $user->nr_insc_normalized;

        return view('extrator.index', compact('nrInsc'));
    }
}
