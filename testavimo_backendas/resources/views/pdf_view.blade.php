<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <style>
.page-break {
  page-break-inside: avoid;
}
.ul {
  list-style-type: circle;
}
li{
  font-weight: normal;
    font-size: 13px;
}
.element-style {
    font-size: 30px;
}
li span {
    font-weight: normal;
    font-size: 13px;
}
@page { margin-left:95px;margin-top:48px;margin-bottom:20px; margin-right:57px }

</style>
  </head>
  <body>
      <div class="container">
      @foreach ($data['collection1'] as $key => $title)
      <h4>{{ $title }}</h4>
      @endforeach
      @foreach ($data['collection2'] as $key => $description)
      <h4> {{ $description }}</h4>
      @endforeach
      <ol>   
@foreach ($data['answerArray'] as $key => $question)
<li class="page-break"><span>{{ $question->Question_Title }}</span>
    @foreach ($question->Answers as $answer)
     
     <ul><li class="element-style"><span>{{ $answer->Answer }}</span></li></ul>
     
   @endforeach
   <br>
      
      </li>
@endforeach
</ol> 




      </div>
  </body>
</html>