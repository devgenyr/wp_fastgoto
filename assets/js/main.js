
var list = ['baconing', 'narwhal', 'a mighty bear canoe'];
var options = { pre: '<b>', post: '</b>' };
var results = fuzzy.filter('bcn', list, options);
console.log(results);
