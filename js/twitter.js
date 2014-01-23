angular.module('Twitter', ['ngResourse']);

function TwitterCtrl($scope, $resource) {
	$scope.twitter = $resource('https://stream.twitter.com/:action', 
	{action:'search.json', q:'nfl'},
		{get:{method:'JSONP'}});
	$scope.twitter.get();
	}