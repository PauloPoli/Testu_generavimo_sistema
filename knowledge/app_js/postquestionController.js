knowledgeApp.controller('questionPostCtrl', function($scope, dataFactory, $stateParams, $location) {

    var categoryId = $stateParams.categoryId;
    $scope.categoryId = categoryId
   

    $scope.date = new Date();

    $scope.postOneQuestion = function (categoryId, Question){
      console.log(categoryId)
        dataFactory.insertQuestion(categoryId, Question).then(function (response) {
          console.log(response)
          alert(response.data)
          $location.path('/editTest/' + categoryId);
      }, function(response) {
        alert('Klaida ' + response.status +' '+ response.statusText);
      });
    }

    $scope.questionTypes = ["Vienas teisingas","Keli teisingi"]

    var Question = 
    { Test:
          { 
            Questions: [        
            {
                Type: "", 
                Question_Title: '',
                Available_variants: []
            }
            ]
          }
    };
    $scope.Question = Question;

    $scope.checkboxModel = {
      value1 : false,
      value2 : false,
      value3 : false,
      value4 : false 
    };

    $scope.index = $scope.Question.Test.Questions.length;

    $scope.addSubItem = function(item) {
      console.log(item)
      item.Available_variants.push({
        Answer: (item.Available_variants.length+1),
        Is_true: false
      });
    };
    
    $scope.removeSubItem = function(item, index) {
      item.splice( index, 1 )
    }; 

    $scope.questionTypeChange = function(item){
      console.log(item)
      if (item == 'Open'){
        console.log('true')
        $scope.displayAnswer = false
      }
      else{
        $scope.displayAnswer = true
      }
    }
  
  });