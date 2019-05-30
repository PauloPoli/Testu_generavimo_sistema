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


class TestFormController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    public function showAllCategories(){
        return response()->json(Test::all());
    }

    public function showAllTests()
    {
        $testobj= new Test();
        $tests=$testobj->select('id','Title')->get();

     $responseArray;
     
        foreach ($tests as $test)
        {
            $questions = $test->questions()->select('id','Type','Question_Title')->get();
        
            foreach ($questions as $question)
            {
               
                $answerArray[$question->id]['info']=$question;
                $answerArray[$question->id]['Answers']=$question->answers()->select('id','Answer','Is_true')->get();
                                    
               
            }
            $responseArray[]=['test_info'=>$test,'questions'=>$answerArray];
            $answerArray=[];   
        
        }
        return response()->json([$responseArray],200);
    }

    private function getinfo($test)
    {
        
        $questions = $test->questions()->select('id','Type','Question_Title')->get();


            foreach ($questions as $question)
            {
                $question['Answers'] = $question->answers()->select('id','Answer','Is_true')->get();;
                $answerArray[]=$question;
                
                                    
            }
            $responseArray=['questions'=>$answerArray];
            return $responseArray;
    }

    private function getOneQuestion($question)
    {
        
        $question['Answers'] = $question->answers()->select('id','Answer','Is_true')->get();

            return $question;
    }


    public function show($id){
        $test = Test::find($id);
		if(!$test){
			return response("The post with {$id} doesn't exist", 404);
        }
       
        return response($this->getinfo($test), 200);
    }

    public function showOneQuestion($id){
        $question = Question::find($id);
		if(!$question){
			return response("The post with {$id} doesn't exist", 404);
        }
       
        return response($this->getOneQuestion($question), 200);
    }

    public function postdata(Request $request)
    {
        $data = $request->Test;
        $error_arr = [];
        $counter =0;
        $answer_counter =0;
       
        $rules = [
            'Title' =>'required|string',
        
        ];
        $validator = Validator::make($data, $rules);
        if (!$validator->passes()) {

            return ($validator->errors()->all());
        } 
        else{ 
            $test = new Test;

            $test->Title = $data['Title'];
    
            $test->save();
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

    public function destroyQuestion($id){
		$question = Question::find($id);
		if(!$question){
			return response("The question with {$id} doesn't exist", 404);
		}
        $question->answers()->delete();
        $question->delete();
		return response("The question with with id {$id} has been deleted along with it's answers", 200);
    }

    public function destroyAnswer($id){
		$answer = Answer::find($id);
		if(!$answer){
			return response("The answer with {$id} doesn't exist", 404);
		}
		$answer->delete();
		return response("The answer with with id {$id} has been deleted ", 200);
    }

    public function destroyTest($id){
        $test= new Test();
		$test = $test->findOrFail($id);
		if(!$test){
			return response("The test with {$id} doesn't exist", 404);
        }
        
        $questions = Question::where('fk_test',$id)->get();
        foreach($questions as $question)
        {
            $question->answers()->delete();
        }
        $test->questions()->delete();
        $test->delete();
		return response("The test with with id {$id} has been deleted ", 200);
    }

    public function updateQuestion(Request $request, $id){
		$question = Question::find($id);
		if(!$question){
			return response("The post with {$id} doesn't exist", 404);
		}
		$this->validateRequestQuestion($request);
		$question->Type 		        = $request->get('Type');
        $question->Question_Title 		= $request->get('Question_Title');
		$question->save();
		return response("The post with with id {$question->id} has been updated", 200);
    }

    public function validateRequestQuestion(Request $request){
		$rules = [
            'Type' => [new TypeRule() ],
            'Question_Title' => 'required|string',
		];
		$this->validate($request, $rules);
    }
    
    public function updateAnswer(Request $request, $id){
		$answer = Answer::find($id);
		if(!$answer){
			return response("The answer with {$id} doesn't exist", 404);
		}
		$this->validateRequestAnswer($request);
		$answer->Answer 		                = $request->get('Answer');
        $answer->Is_true 		                = $request->get('Is_true');
        
		
		$answer->save();
		return response("The answer with with id {$answer->id} has been updated", 200);
    }

    public function validateRequestAnswer(Request $request){
		$rules = [
            'Answer' => 'required',
            'Is_true' => 'required|boolean'
		];
		$this->validate($request, $rules);
    }
    
    public function updateTest(Request $request, $id){
		$test = Test::find($id);
		if(!$test){
			return response("The answer with {$id} doesn't exist", 404);
		}
		$this->validateRequesTest($request);
		$test->Title 		                = $request->get('Title');
		$test->save();
		return response("The test with with id {$test->id} has been updated", 200);
    }
    public function validateRequesTest(Request $request){
		$rules = [
            'Title' =>'required|string',
		];
		$this->validate($request, $rules);
	}

}
