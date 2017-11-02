<?php

namespace App\Http\Controllers\Users;

use App\Entities\Users\UsersRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\DeleteRequest;
use App\Http\Requests\Users\UpdateRequest;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    private $repo;

    public function __construct(UsersRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $req)
    {
        $users = $this->repo->getUsers($req->get('q'));
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(CreateRequest $req)
    {
        $userData = $req->except(['_token', 'password_confirmation']);
        $user     = $this->repo->create($userData);
        flash()->success(trans('user.created'));
        return redirect()->route('users.index');
    }

    public function show($userId)
    {
        $user = $this->repo->requireById($userId);
        return view('users.show', compact('user'));
    }

    public function edit($userId)
    {
        $user = $this->repo->requireById($userId);

        return view('users.edit', compact('user'));
    }

    public function update(UpdateRequest $req, $userId)
    {
        $userData = $req->except(['_method', '_token', 'password_confirmation']);
        $user     = $this->repo->update($userData, $userId);
        flash()->success(trans('user.updated'));
        return redirect()->route('users.edit', $userId);
    }

    public function delete($userId)
    {
        $user = $this->repo->requireById($userId);
        return view('users.delete', compact('user'));
    }

    public function destroy(DeleteRequest $req, $userId)
    {
        if ($userId == $req->get('user_id')) {
            $this->repo->delete($userId);
            flash()->success(trans('user.deleted'));
        } else {
            flash()->error(trans('user.undeleted'));
        }

        return redirect()->route('users.index');
    }

}
