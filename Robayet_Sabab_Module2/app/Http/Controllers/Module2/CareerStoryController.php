<?php
namespace App\Http\Controllers\Module2;
use App\Http\Controllers\Controller;
use App\Models\CareerStory;
use App\Models\Major;
use Illuminate\Http\Request;
class CareerStoryController extends Controller {
 public function index(Request $request) {
  $stories=CareerStory::with('major')
   ->when($request->filled('q'),function($q) use($request){$term=trim($request->string('q')->toString());$q->where(fn($b)=>$b->where('name','like',"%{$term}%")->orWhere('role_title','like',"%{$term}%")->orWhere('organization','like',"%{$term}%")->orWhere('short_bio','like',"%{$term}%")->orWhere('country','like',"%{$term}%"));})
   ->when($request->filled('major'),fn($q)=>$q->whereHas('major',fn($m)=>$m->where('slug',$request->string('major')->toString())))
   ->when($request->filled('country'),fn($q)=>$q->where('country',$request->string('country')->toString()))
   ->when($request->filled('skill'),fn($q)=>$q->whereJsonContains('skills',$request->string('skill')->toString()))
   ->orderByDesc('is_featured')->orderBy('name')->paginate(12)->withQueryString();
  $majors=Major::orderBy('sort_order')->get();
  $countries=CareerStory::whereNotNull('country')->distinct()->orderBy('country')->pluck('country');
  $skills=CareerStory::all()->pluck('skills')->flatten()->filter()->unique()->sort()->values();
  return view('module2.careers.index',compact('stories','majors','countries','skills'));
 }
 public function show(CareerStory $story) {
  $story->load('major'); $related=CareerStory::with('major')->where('major_id',$story->major_id)->where('id','!=',$story->id)->orderByDesc('is_featured')->limit(3)->get();
  return view('module2.careers.show',compact('story','related'));
 }
}