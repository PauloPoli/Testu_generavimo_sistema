knowledgeApp.controller('testEditCtrl', function($scope, dataFactory, $stateParams) {

  var testID = $stateParams.id;
  $scope.testID = testID

    $scope.date = new Date();

    $scope.getOneTest = function (testID){
      dataFactory.displayOneTest(testID).then(function (response) {
        $scope.testData = response.data;
        console.log(response.data)
    }, function(response) {
        alert('Klaida ' + response.status +' '+ response.statusText)
    });
}

$scope.getOneTest(testID);


});