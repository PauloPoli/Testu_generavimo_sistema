

knowledgeApp.controller('testCreationCtrl', ['$scope','dataFactory', function($scope, dataFactory) {

    $scope.date = new Date();

    


    $scope.postTest = function (Testukas){
      console.log(Testukas.Test.Questions)
        dataFactory.insertTest(Testukas).then(function (response) {
          console.log(response)
          alert(response.data)
          location.reload();
      }, function(response) {
        alert('Klaida ' + response.status +' '+ response.statusText);
      });
  }

  $scope.questionTypes = ["Vienas teisingas","Keli teisingi"]

  var Testukas = 
  { Test:
        { Title: "",
          Questions: [        
          {
              Type: "", 
              Question_Title: '',
              Available_variants: []
          }
          ]
        }
  };
  $scope.Testukas = Testukas;

  $scope.checkboxModel = {
    value1 : false,
    value2 : false,
    value3 : false,
    value4 : false 
  };

  $scope.index = $scope.Testukas.Test.Questions.length;

  $scope.removeItem = function(item, index) {
    item.splice( index, 1 );
  };

  $scope.addItem = function() {
    $scope.Testukas.Test.Questions.push({
      Type: "Open", 
      Question_Title: '',
      Available_variants: []
    });
  };

  $scope.addSubItem = function(item) {
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

  }]);
