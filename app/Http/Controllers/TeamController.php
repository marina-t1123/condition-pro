<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Unertia\Response;

class TeamController extends Controller
{
    // 選手一覧ページ表示
    public function index()
    {
        // dd('表示のアクションに入っている');
        return Inertia::render('Team/Index');
    }
}
