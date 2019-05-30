var knowledgeApp = angular.module('testApp', ['ui.router','ngMaterial']);

knowledgeApp.config(function ($httpProvider) {
    $httpProvider.defaults.headers.post['Content-Type'] =  'application/json';
})

knowledgeApp.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider){
    
    $urlRouterProvider.otherwise("/home")
     
    $stateProvider
            .state('home', {
                url: "/home",
                templateUrl: "main_Page.html",
                controller: 'testGetCtrl'
            })
            .state('editTest', {
                url: "/editTest/:id",
                templateUrl: "editquiz.html",
                controller:'testEditCtrl', function($scope, $stateParams) {
                    $scope.id = $stateParams.id;
                 }
            })
            .state('postQuestion', {
                url: "/postquestion/:categoryId",
                templateUrl: "postquestion.html",
                controller:'questionPostCtrl', function($scope, $stateParams) {
                    $scope.categoryId = $stateParams.categoryId;
                 }
            })
            .state('editQuestion', {
                url: "/editQuestion/:questionId",
                templateUrl: "editquestion.html",
                controller:'questionEditCtrl', function($scope, $stateParams) {
                    $scope.questionId = $stateParams.questionId;
                 }
            })
            .state('createTest', {
                url: "/createTest",
                templateUrl: "quiz.html",
                controller: 'testCreationCtrl'
            })
            .state('generateTest', {
                url: "/generateTest",
                templateUrl: "generator.html",
                controller: 'generatorCtrl'
            })

}]);


  