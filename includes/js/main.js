function clicked(hand) {
				$.post(
					'functions/clicked.php',
					{hand: 'test'},
					function(result) {
						alert('hi');
					}
				);
			}

			function success(data) {
				alert('hi');
			}

			$(document).ready(
				function() {
					$(".rock").click(
						function() {
							clicked("rock");
						}
					);
					$(".paper").click(
						function() {
							clicked("paper");
						}
					);
					$(".scissors").click(
						function() {
							clicked("scissors");
						}
					);
				}
			);