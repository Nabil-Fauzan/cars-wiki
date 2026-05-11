<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarAiController extends Controller
{
    public function generate(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'editor'])) {
            abort(403, 'Unauthorized AI access.');
        }

        $model = $request->input('model', 'Vehicle');
        $field = $request->input('field', 'history');

        // Mock AI logic based on model name
        $responses = [
            'history' => "The {$model} represents a pinnacle of automotive engineering, merging performance with a legacy of innovation. Since its inception, it has redefined the standards of its class, featuring a chassis optimized for both agility and stability.",
            'pros' => "[\"Exceptional power-to-weight ratio\", \"Precision-tuned suspension\", \"Iconic design heritage\"]",
            'cons' => "[\"High acquisition cost\", \"Intensive maintenance schedule\", \"Limited daily practicality\"]",
        ];

        return response()->json([
            'content' => $responses[$field] ?? "Generated content for {$model}",
        ]);
    }
}
