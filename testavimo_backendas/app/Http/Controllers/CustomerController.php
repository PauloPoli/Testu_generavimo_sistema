<?php
// Our Controller 
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
// use App\rules\AnswerRule;
use App\Test;
use App\Question;
use App\Answer;
use PDF;
  
class CustomerController extends Controller
{
    public function printPDF()
    {
      $data = DB::table("questions")->get();
    	view()->share('data',$data);
        
        $pdf = PDF::loadView('pdf_view', compact('data'));
        // if($request->has('download'))
        // {
        // 	// Set more option
        // 	PDF::setOptions(['defaultFont' => 'sans-serif','dpi' => 100]);

        // 	// pass view file
        //     $pdf = PDF::loadView('pdf_view');

        //     // download pdf file
        //     return $pdf->download('phperrorcode.pdf');
        // }

        return view('pdf_view');
    }
}