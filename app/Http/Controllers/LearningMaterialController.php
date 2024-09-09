<?php
namespace App\Http\Controllers;

use App\Models\Course;

use App\Models\learning_materials;
use Illuminate\Http\Request;

class LearningMaterialController extends Controller
{
    public function index($id)
    {
        $course = Course::findOrFail($id);
        $materials = learning_materials::where('course_id', $id)->get();
        return view('materials.index', compact('course', 'materials'));
    }
}
