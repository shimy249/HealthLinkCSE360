			function showHide(target, self){
				
				var content = document.getElementById(target);
				
				if (content.style.display == 'none'){
					content.style.display = 'block';
					self.innerHTML = 'x';
				}
				else{
					content.style.display = 'none';
					self.innerHTML = '+';
				}
			}
