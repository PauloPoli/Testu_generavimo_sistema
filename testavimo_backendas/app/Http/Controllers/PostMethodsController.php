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

class PostMethodsController extends Controller
{

    public function postQuestion(Request $request, $selectedID)
    {
        $data = $request->Test;

        $error_arr = [];
        $counter =0;
        $answer_counter =0;


        $test = Test::find($selectedID); 

            foreach( $data['Questions'] as $question )
            {
                $counter=0;
                $answer_counter=0;
                
                $rules = [
                    'Type' => ['required', new TypeRule() ],
                    'Question_Title' => '',

                ];
               
if($question['Type'] === 'Vienas teisingas' || $question['Type'] === 'Keli teisingi')
{
   $count= Count($question['Available_variants']);
   $answer_counter = $answer_counter +$count;

}
else
{
    $answer_counter=3;
}
         

             

                $validator = Validator::make($question, $rules);
        if (!$validator->passes()) {
         
            $error_arr[]=($validator->errors()->toArray());
            
        }
        else{
            
            $quest = new Question;

        $quest->Type = $question['Type'];
        $quest->fk_test = $test->id;
        
        $quest->Question_Title = $question['Question_Title'];

        $quest->save();
        foreach( $question['Available_variants'] as $variants)
        {
            $rules = [
                'Answer' => 'required',
                'Is_true' => 'boolean'
            ];

            
            if($variants['Is_true'] == true )
            {
                $counter++;
            }

            
            
            

            $validator = Validator::make($variants, $rules);
            if (!$validator->passes()) {
              
                $error_arr[]=($validator->errors()->toArray());
                
            }

            $answer = new Answer ;

            $answer->Answer = $variants['Answer'];
            $answer->Is_true = $variants['Is_true'];
            $answer->fk_question = $quest->id;
            $answer->save();

            

        }

        if($counter == 0)
        {
            return response('turi buti bent vienas teisingas', 406);;
        
        }

        if($answer_counter < 2)
        {
            return response('turi buti 2 ar daugiau variantu', 406);;
           
        }

    } 

        }
       
        if(count($error_arr) > 0)
        {
            return $error_arr;
        }  
        else
    {
        
        return response('Created', 200);;
    }
        
    }

    public function postAnswer(Request $request, $selectedID)
    {
        $data = $request->Test;
        $error_arr = [];
        $counter =0;
        $answer_counter =0;
 
        $quest = Question::find($selectedID); 

        foreach( $data['Available_variants'] as $variants)
        {
            $rules = [
                'Answer' => 'required',
                'Is_true' => 'boolean'
            ];

            
            if($variants['Is_true'] == true )
            {
                $counter++;
            }

            
            
            

            $validator = Validator::make($variants, $rules);
            if (!$validator->passes()) {

                $error_arr[]=($validator->errors()->toArray());
                
            }

            $answer = new Answer ;

            $answer->Answer = $variants['Answer'];
            $answer->Is_true = $variants['Is_true'];
            $answer->fk_question = $quest->id;
            $answer->save();
        }
       
        if(count($error_arr) > 0)
        {
            return $error_arr;
        }  
        else
        {
            return response('Created', 200);
        }
    }
        
}