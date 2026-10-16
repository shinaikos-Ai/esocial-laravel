<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($s = $request->get('search')) {
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('nr_insc', 'like', "%{$s}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        // normaliza nr_insc: remove não-dígitos
        if (!empty($data['nr_insc'])) {
            $data['nr_insc'] = preg_replace('/\D/', '', $data['nr_insc']);
        }

        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        if (!empty($data['nr_insc'])) {
            $data['nr_insc'] = preg_replace('/\D/', '', $data['nr_insc']);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Você não pode excluir sua própria conta.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuário removido com sucesso!');
    }
}
