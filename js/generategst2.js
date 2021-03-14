// DOM
yearDropdown = qs('#year')
monthDropdown = qs('#month')
generateBtn = qs('#generate')
message = qs('#message')
container = qs('#container')
window.addEventListener('load', function () {
	let forYear = new XMLHttpRequest();
	forYear.onreadystatechange = function() {
	   if (this.readyState == 4 && this.status == 200) {
	   		yearDropdown.innerHTML = '<option value="">---Year---</option>'
	   		yearDropdown.innerHTML += this.responseText
	   }
	}
	forYear.open("GET",`fetchYears/bills/billDate`, true)
	forYear.send()
})
yearDropdown.addEventListener('change', function () {
	year = yearDropdown.value
	if (year == '') {
		monthDropdown.disabled = true
		monthDropdown.innerHTML = '<option value="">Select Year First</option>'
	}
	else{
		let forMonth = new XMLHttpRequest()
		forMonth.onreadystatechange = function() {
			if (this.readyState == 1) {
				monthDropdown.disabled = true
				monthDropdown.innerHTML = '<option value="">Loading...</option>'
			}
			if (this.readyState == 4 && this.status == 200) {
				monthDropdown.disabled = false
				monthDropdown.innerHTML = '<option value="">---Month---</option>'
				monthDropdown.innerHTML += this.responseText
			}
		}
		forMonth.open("GET",`fetchMonths/${year}/bills/billDate`, true)
		forMonth.send()
	}
})

generateBtn.addEventListener('click', function () {
	year = yearDropdown.value
	month = monthDropdown.value
	monthArr = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	if (year == '') {
		yearDropdown.focus()
		showMessage('black', 'Select Year')
	}
	else if (month == ''){
		monthDropdown.focus()
		showMessage('black', 'Select month')
	}
	else{
		yearDropdown.disabled = true
		monthDropdown.disabled = true
		generateBtn.disabled = true
		generateBtn.innerHTML = 'Wait...'
		let forMonth = new XMLHttpRequest()
		forMonth.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				generateBtn.style.transform = 'scale(0)'
				container.innerHTML = this.responseText
				container.style.display = 'block'
				setTimeout(function () {
					generateBtn.style.display = 'none'
					container.style.transform = 'none'
				}, 500)
			}
		}
		forMonth.open("GET",`gstr2Report/${year}/${month}`, true)
		forMonth.send()
	}
})

qs('#backIcon').addEventListener('click', function () {
	if (window.parent.document.title.indexOf('Dashboard') == 0) {
		window.parent.location.reload()
	}
	else{
		window.history.back()
	}
})
function qs(selector) {
	return document.querySelector(selector)
}
function showMessage(color, whatToShow) {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
    message.className = "show";
    setTimeout(function(){ message.className = message.className.replace("show", ""); }, 3000);
}