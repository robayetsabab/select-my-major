<?php
namespace App\Http\Controllers\Module2;
use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
class QuizController extends Controller {
 public function index(){return view('module2.quiz.index');}
 public function submit(Request $request): JsonResponse {
  $data=$request->validate(['answers'=>['required','array','size:8'],'answers.*.question_id'=>['required','integer','between:1,8'],'answers.*.answer'=>['required','in:protect,build,analyze,quality']]);
  $scores=['cyber-security'=>0,'robotics'=>0,'data-science'=>0,'software-testing'=>0]; $map=[];
  foreach($data['answers'] as $item){$id=(int)$item['question_id'];$key=$item['answer'];$slug=match($key){'protect'=>'cyber-security','build'=>'robotics','analyze'=>'data-science','quality'=>'software-testing'};$scores[$slug]++;$map[$id]=$key;}
  if(count($map)!==8 || count(array_unique(array_keys($map)))!==8) throw ValidationException::withMessages(['answers'=>'Please answer all eight questions.']);
  $max=max($scores);$winners=array_keys(array_filter($scores,fn($v)=>$v===$max));sort($winners);$recommended=$winners[0];
  $major=Major::where('slug',$recommended)->first();
  if(!$major)return response()->json(['message'=>'Major catalogue is unavailable. Run the Module 1 seeders first.'],503);
  $attempt=QuizAttempt::create(['user_id'=>$request->user()?->id,'session_key'=>$request->session()->getId(),'answers'=>$map,'scores'=>$scores,'recommended_major'=>$recommended,'answered_count'=>8]);
  return response()->json(['message'=>'Quiz result saved.','attempt_id'=>$attempt->id,'recommended_major'=>['name'=>$major->name,'slug'=>$major->slug,'tagline'=>$major->tagline,'url'=>route('majors.show',$major)],'scores'=>$scores,'answered_count'=>8,'tie'=>count($winners)>1],201);
 }
 public function history(Request $request): JsonResponse {
  return response()->json(['data'=>QuizAttempt::where('session_key',$request->session()->getId())->latest()->limit(10)->get(['id','recommended_major','scores','answered_count','created_at'])]);
 }
}