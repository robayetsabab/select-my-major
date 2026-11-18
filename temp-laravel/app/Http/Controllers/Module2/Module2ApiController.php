<?php
namespace App\Http\Controllers\Module2;
use App\Http\Controllers\Controller;
use App\Models\CareerStory;
use App\Models\Major;
use Illuminate\Http\Request;
class Module2ApiController extends Controller {
 public function stories(Request $request){return response()->json(CareerStory::with('major')->when($request->filled('major'),fn($q)=>$q->whereHas('major',fn($m)=>$m->where('slug',$request->query('major'))))->when($request->filled('q'),fn($q)=>$q->where('name','like','%'.trim($request->query('q')).'%'))->orderByDesc('is_featured')->orderBy('name')->paginate(12));}
 public function majors(){return response()->json(['data'=>Major::orderBy('sort_order')->get(['id','name','slug','tagline'])]);}
}