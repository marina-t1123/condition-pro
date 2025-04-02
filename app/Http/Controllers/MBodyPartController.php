<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\MBodyPart;
use Inertia\Inertia;

class MBodyPartController extends Controller
{
    /**
     *  部位マスタ一覧ページ表示
     *
     * @return 
     */
    public function index () {
        $mBodyParts = mBodyPart::all();

        return Inertia::render('MBodyPart/Index', [
            'm_body_parts' => $mBodyParts
        ]);
    }

}
