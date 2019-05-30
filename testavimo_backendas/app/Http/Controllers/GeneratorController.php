<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Validator;
use Illuminate\Database\Eloquent\Collection;


use App\rules\Typerule;
use App\rules\TypeRuleNotEmty;
use App\rules\Available_variantsRule;
use App\rules\TrueRule;
use App\Test;
use App\Question;
use App\Answer;
use PDF;

class GeneratorController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */

    public function generatePDF($id,$title,$description,$questionHash,$answerHash, $quantity)
    {
        $test = Test::find($id);

        $questions = $test->questions()->select('id','Type','Question_Title')->get();


            foreach ($questions as $question)
            {
                if($answerHash == 1){
                    $question['Answers'] = $question->answers()->select('id','Answer','Is_true')->inRandomOrder()->get();
                }
                else{
                    $question['Answers'] = $question->answers()->select('id','Answer','Is_true')->get();
                }    
                
                $answerArray[]=$question; 
                if($questionHash == 1){
                    $suffleQuestions = shuffle($answerArray);
                }
            
            }
            $collection = collect($answerArray);
            $collection1 = collect($title);
            $collection2 = collect($description);
            $answerArray = $collection->slice(0, $quantity);
            $data = compact('answerArray', 'collection1', 'collection2');
            view()->share('data',$data);

            $pdf = PDF::loadView('pdf_view', $data);
            return $pdf->stream();

    }

}
