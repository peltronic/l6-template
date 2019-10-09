<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest; // %PSG ???

use App\Models\Account;
use App\Http\Resources\Account as AccountResource;
use App\Http\Resources\AccountCollection;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $accounts = Account::paginate();
        if ( $request->ajax() ) {
            //return AccountResource::collection($accounts);
            return new AccountCollection($accounts);
        } else {
            return view('accounts.index', compact('accounts'));
        }
    }

    public function show(Account $account)
    {
        return view('accounts.show', compact('account'));
    }

    public function create(Account $account)
    {
        return view('accounts.create_and_edit', compact('account'));
    }

    public function store(AccountRequest $request)
    {
        $account = Account::create($request->all());
        return redirect()->route('accounts.show', $account->id)->with('message', 'Created successfully.');
    }

    public function edit(Account $account)
    {
        $this->authorize('update', $account);
        return view('accounts.create_and_edit', compact('account'));
    }

    public function update(AccountRequest $request, Account $account)
    {
        $this->authorize('update', $account);
        $account->update($request->all());

        return redirect()->route('accounts.show', $account->id)->with('message', 'Updated successfully.');
    }

    public function destroy(Account $account)
    {
        $this->authorize('destroy', $account);
        $account->delete();

        return redirect()->route('accounts.index')->with('message', 'Deleted successfully.');
    }
}
