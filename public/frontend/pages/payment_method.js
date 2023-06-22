// "use strict";
//
// var style = {
// 	base: {
// 		color: '#495057',
// 		fontSmoothing: 'antialiased',
// 		'::placeholder': {
// 			color: '#495057'
// 		}
// 	},
//     invalid: {
//         color: '#fa755a',
//         iconColor: '#fa755a'
//     }
//
// };
//
// const stripe = Stripe(stripe_key, { locale: 'en' });
// const elements = stripe.elements();
//
// const cardElement = elements.create('card', { style: style });
// // const cardElement = elements.create('card');
// cardElement.mount('#card-element');
//
// // Handle real-time validation errors from the card Element.
// cardElement.addEventListener('change', function(event) {
// 	if(event.complete){
// 		validCardNumer = 1;
// 	}else{
// 		validCardNumer = 0;
// 	}
// 	var displayError = document.getElementById('card-errors');
// 	if (event.error) {
// 		displayError.textContent = event.error.message;
// 	} else {
// 		displayError.textContent = '';
// 	}
// });
//
// function onConfirmPayment(clientSecret, msg) {
// 	stripe.handleCardPayment(clientSecret, cardElement, {
// 		payment_method_data: {
// 			billing_details: {
// 				name: $("#name").val(),
// 				email: $("#email").val(),
// 				phone: $("#phone").val(),
// 				address: {
// 					state: $("#state").val(),
// 					city: $("#city").val(),
// 					line1: $("#address").val()
// 				}
// 			}
// 		}
// 	})
// 	.then(function(result) {
// 		if (result.error) {
// 			var errorElement = document.getElementById('card-errors');
// 			errorElement.textContent = result.error.message;
// 		} else {
//             // result.token.card.last4
// 			// cardElement.clear();
// 			// window.location.href = base_url + '/thank';
// 		}
// 	});
//
//
//
//
//
//     // stripe.createToken(cardElement)
//     //     .then(function(result) {
//     //         if (result.error) {
//     //             // Inform the user if there was an error
//     //             var errorElement = document.getElementById('card-errors');
//     //             errorElement.textContent = result.error.message;
//     //         } else {
//     //
//     //             // Send the token to your server
//     //             // stripeTokenHandler(result.token);
//     //         }
//     // });
//
// }
//
//
