const _ 	= require('lodash');
const foo = [1,2,3,4,5,6,7,8,9,10];

console.log("#####################################");
_.each( foo, (item) => {
	console.log(item);
});
console.log("#####################################");
