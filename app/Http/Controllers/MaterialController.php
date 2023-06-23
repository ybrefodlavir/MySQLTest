<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialQuestions;
use App\Models\Question;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all()->sortBy("order");
        return view('material', ['materials' => $materials]);
    }

    public function details($material_id)
    {
        $material = Material::find($material_id);
        if ($material) {
            $questions = Question::whereIn('id', MaterialQuestions::where('material_id', $material->id)->pluck('question_id')->toArray())
                ->where('is_active', true)->get();
            if ($material->is_exam) {
                return view('material_exam', ['material' => $material, 'questions' => $questions]);
            }
            return view('material_detail', ['material' => $material, 'questions' => $questions]);
        }

        return redirect()->route('home');
    }
}
