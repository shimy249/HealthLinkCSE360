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
			function hideNotifications(){
				var notification = document.getElementById('notifications');
				notification.style.display = 'none';
			}
			function addSymptom(){
				var list = document.getElementById('SymptomList');
				var item = document.getElementById('ChosenSymptom');
				var sItem = item.value.replace(/(\r\n|\n|\r)/gm,"");
				var sList = list.value.replace(/(\r\n|\n|\r)/gm,"");
				if (list.value){
					if (sList.indexOf(sItem) == -1){
						list.value = item.value + ", " + list.value;
						list.value= list.value.replace(/(\r\n|\n|\r)/gm,"");
					}
				}
				else{
					list.value = item.value;
				}
			}
			function clearSymptoms(){
				var list = document.getElementById('SymptomList');
				list.value = '';
			}
