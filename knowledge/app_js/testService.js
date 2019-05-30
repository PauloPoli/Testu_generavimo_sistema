
    knowledgeApp.factory('dataFactory', ['$http',  function($http) {

    var urlBase = 'http://localhost/testavimo_backendas/public/api/test';
    var urlbase = 'http://localhost/testavimo_backendas/public/api/tests';
    var dataFactory = {};

    dataFactory.insertTest = function (Testukas) {
        return $http.post(urlBase, Testukas)
    };
    dataFactory.insertQuestion = function (categoryId, Question) {
        return $http.post(urlBase +'/question/'+ categoryId, Question)
    };
    dataFactory.insertAnswer = function (questionId, Question) {
        return $http.post(urlBase +'/answer/'+ questionId, Question)
    };
    dataFactory.displayTest = function () {
        return $http.get(urlbase)
    };
    dataFactory.passParams = function (data) {
        return $http.get(urlbase + '/generate/', data)
    };
    dataFactory.displayCategories = function () {
        return $http.get(urlbase +'/categories')
    };
    dataFactory.displayOneTest = function (id) {
        return $http.get(urlbase +'/'+ id)
    };
    dataFactory.displayOneQuestion = function (questionID) {
        return $http.get(urlbase +'/showquestion/'+ questionID)
    };
    dataFactory.deleteTest = function (id) {
        return $http.delete(urlbase+'/deletetest/' + id )
    };
    dataFactory.deleteQuestion = function (id) {
        return $http.delete(urlbase + '/deletequestion/' + id)
    };
    dataFactory.deleteAnswer = function (id) {
        return $http.delete(urlbase + '/deleteanswer/' + id)
    };
    dataFactory.editTest = function (id, categoryTitle) {
        return $http.put(urlbase+'/updatetest/' + id, categoryTitle)
    };
    dataFactory.editQuestion = function (questionId, Question) {
        return $http.put(urlbase+'/updatequestion/' + questionId, Question)
    };
    dataFactory.editAnswer = function (answerId, Answer) {
        return $http.put(urlbase+'/updateanswer/' + answerId, Answer)
    };

    return dataFactory;
}]);    
