knowledgeApp.controller('testGetCtrl', ['$scope','dataFactory', function($scope, dataFactory) {

    $scope.date = new Date();

    $scope.getTest = function (){
          dataFactory.displayTest().then(function (response) {
            $scope.testData = response.data;
            console.log(response.data)
        }, function(response) {
            alert('Klaida ' + response.status +' '+ response.statusText)
        });
    }
    $scope.getTest();



    $scope.editTitle = function(testId, testTitle) {
var testTitle = {Title:testTitle}
console.log(testId)
console.log(testTitle)
      dataFactory.editTest(testId, testTitle).then(function (response) {
          alert(response.data)
          location.reload();
    }, function(response) {
        alert('Klaida ' + response.status +' '+ response.statusText)
       });
    
    };
    
    $scope.cancelEdit = function(value) {
      console.log('Canceled editing', value);
      alert('Canceled editing of ' + value);
    };

}]);

knowledgeApp.directive('onEsc', function() {
  return function(scope, elm, attr) {
    elm.bind('keydown', function(e) {
      if (e.keyCode === 27) {
        scope.$apply(attr.onEsc);
      }
    });
  };
});


knowledgeApp.directive('onEnter', function() {
  return function(scope, elm, attr) {
    elm.bind('keypress', function(e) {
      if (e.keyCode === 13) {
        scope.$apply(attr.onEnter);
      }
    });
  };
});


knowledgeApp.directive('inlineEditTest', function($timeout, dataFactory) {
  return {
    scope: {
      model: '=?inlineEditTest',
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
      scope.toDeleteTest = function (id){
        console.log(id)
        dataFactory.deleteTest(id).then(function (response) {
            alert(response.data)
            location.reload();
      }, function(response) {
          alert('Klaida ' + response.status +' '+ response.statusText)
         });
      }
    },
    templateUrl: 'inline-editTest.html'
  };
});

