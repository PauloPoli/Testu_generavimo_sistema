knowledgeApp.controller('generatorCtrl', function($scope, dataFactory) {
  $scope.date = new Date();

  $scope.getCategories = function (){
    dataFactory.displayCategories().then(function (response) {
      $scope.testData = response.data;
      console.log(response.data)
    }, function(response) {
      alert('Klaida ' + response.status +' '+ response.statusText)
    });
  }
  $scope.getCategories();

  

  $scope.passToGenerate = function (id, testTitle, testDescription, Question_hash, Variants_hash, quantity) {
    window.open('http://localhost/testavimo_backendas/public/api/tests/generate/'+ id +'/Title='+ testTitle +'/Description='+ testDescription +'/questionHash/'+Question_hash+'/answerHash/'+Variants_hash+'/quantity/'+ quantity, '_blank');
  }

  });