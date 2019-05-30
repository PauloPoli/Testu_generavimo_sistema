knowledgeApp.controller('questionEditCtrl', function($scope, dataFactory, $stateParams, $location) {

  var questionID = $stateParams.questionId;
  $scope.questionID = questionID

  $scope.questionTypes = ["Vienas teisingas","Keli teisingi"]

  $scope.checkboxModel = {
    value1 : false,
    value2 : false,
    value3 : false,
    value4 : false 
  };

    $scope.date = new Date();

    $scope.getOneQuestion = function (questionID){
      dataFactory.displayOneQuestion(questionID).then(function (response) {
        $scope.testData = response.data;
        console.log(response.data)
    }, function(response) {
        alert('Klaida ' + response.status +' '+ response.statusText)
    });
    }

$scope.getOneQuestion(questionID);

$scope.backtoeditCategory = function(fk_test){
  $location.path('/editTest/' + fk_test);
}

$scope.toEditQuestion = function(questionId, questionTitle, questionType) {
  var Question = 
  {
    Question_Title:questionTitle,
    Type: questionType
  }
  console.log('Is true:' + questionType)
  dataFactory.editQuestion(questionId, Question).then(function (response) {
      alert(response.data)
      location.reload();
}, function(response) {
    alert('Klaida ' + response.status +' '+ response.statusText)
   });

};

$scope.toEditAnswer = function(answerTitle, answerId, isTrue) {
  var Answer = 
  {
    Answer:answerTitle,
    Is_true: isTrue
  }
  console.log('Is true:' + isTrue)
  dataFactory.editAnswer(answerId, Answer).then(function (response) {
      alert(response.data)
      location.reload();
}, function(response) {
    alert('Klaida ' + response.status +' '+ response.statusText)
   });
};

$scope.toPostAnswer = function (answerTitle, questionId, isTrue){
  var Question = 
    { Test:
          { 
            Available_variants: [{
              Answer: answerTitle, 
              Is_true: isTrue,
            }]
          }
    };
    console.log(questionId)
    console.log(isTrue)
  dataFactory.insertAnswer(questionId, Question).then(function (response) {
      alert(response.data)
      $scope.getOneQuestion(questionID);
}, function(response) {
    alert('Klaida ' + response.status +' '+ response.statusText)
   });
}

$scope.cancelEdit = function(value) {
  console.log('Canceled editing', value);
  alert('Canceled editing of ' + value);
};

});

knowledgeApp.directive('onEsc', function() {
  return function(scope, elm, attr) {
    elm.bind('keydown', function(e) {
      if (e.keyCode === 27) {
        scope.$apply(attr.onEsc);
      }
    });
  };
});

// On enter event
knowledgeApp.directive('onEnter', function() {
  return function(scope, elm, attr) {
    elm.bind('keypress', function(e) {
      if (e.keyCode === 13) {
        scope.$apply(attr.onEnter);
      }
    });
  };
});

// Inline edit directive
knowledgeApp.directive('inlineEdit', function($timeout, dataFactory) {
  return {
    scope: {
      model: '=?inlineEdit',
      handleSave: '&onSave',
      handleCancel: '&onCancel'
    },
    link: function(scope, elm, attr) {
      var previousValue;
      scope.edit = function() {
        scope.editMode = true;
        previousValue = scope.model;
        
        $timeout(function() {
          elm.find('input')[0].focus();
        }, 0, false);
      };
      scope.save = function() {
        scope.editMode = false;
        scope.handleSave({value: scope.model});
      };
      scope.cancel = function() {
        scope.editMode = false;
        scope.model = previousValue;
        scope.handleCancel({value: scope.model});
      };
      scope.toDeleteAnswer = function (id){
        console.log(id)
        dataFactory.deleteAnswer(id).then(function (response) {
            alert(response.data)
            location.reload();
      }, function(response) {
          alert('Klaida ' + response.status +' '+ response.statusText)
         });
      }
    },
    templateUrl: 'inline-edit.html'
  };
});

knowledgeApp.directive('inlineEditQuestion', function($timeout, dataFactory,$location) {
  return {
    scope: {
      model: '=?inlineEditQuestion',
      handleSave: '&onSave',
      handleCancel: '&onCancel'
    },
    link: function(scope, elm, attr) {
      var previousValue;
      scope.edit = function() {
        scope.editMode = true;
        previousValue = scope.model;
        
        $timeout(function() {
          elm.find('input')[0].focus();
        }, 0, false);
      };
      scope.save = function() {
        scope.editMode = false;
        scope.handleSave({value: scope.model});
      };
      scope.cancel = function() {
        scope.editMode = false;
        scope.model = previousValue;
        scope.handleCancel({value: scope.model});
      };
      scope.toDeleteQuestion = function (id, fk_test){
        dataFactory.deleteQuestion(id).then(function (response) {
            alert(response.data)
            $location.path('/editTest/' + fk_test);
      }, function(response) {
          alert('Klaida ' + response.status +' '+ response.statusText)
         });
      }
    },
    templateUrl: 'inline-editQuestion.html'
  };
});

knowledgeApp.directive('inlinePostAnswer', function($timeout, dataFactory) {
  return {
    scope: {
      model: '=?inlinePostAnswer',
      handleSave: '&onSave',
      handleCancel: '&onCancel'
    },
    link: function(scope, elm, attr) {
      var previousValue;
      scope.edit = function() {
        scope.editMode = true;
        previousValue = scope.model;
        
        $timeout(function() {
          elm.find('input')[0].focus();
        }, 0, false);
      };
      scope.save = function() {
        scope.editMode = false;
        scope.handleSave({value: scope.model});
      };
      scope.cancel = function() {
        scope.editMode = false;
        scope.model = previousValue;
        scope.handleCancel({value: scope.model});
      };
    },
    templateUrl: 'inline-postAnswer.html'
  };
});