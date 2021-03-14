// DOM Elements

const cName = document.querySelector('#cName')
const cAddress = document.querySelector('#cAddress')
const cgstin = document.querySelector('#cGSTIN')
const cPerson1 = document.querySelector('#cPerson1')
const cNumber1 = document.querySelector('#cNumber1')
const cPerson2 = document.querySelector('#cPerson2')
const cNumber2 = document.querySelector('#cNumber2')
const addCompany = document.querySelector('#addCompany')


const heading = document.querySelector('#heading')
const inputWrapper = document.querySelector('#inputWrapper')
let message = document.querySelector('#message')

// Form Values
// Event Listeners
cNumber1.addEventListener('input', function (event) {
	var condition = !isNumber(event.data) || cNumber1.value.length > 10 || event.data == " "
	if (condition) {
		cNumber1.value = cNumber1.value.slice(0, length - 1)
		if (!isNumber(event.data) && cNumber1.value.length < 10) {
			showMessage('red', 'Only Numbers are allowed!')
		}
	}
})

cNumber2.addEventListener('input', function (event) {
	var condition = !isNumber(event.data) || cNumber2.value.length > 10 || event.data == " "
	if (condition) {
		cNumber2.value = cNumber2.value.slice(0, length - 1)
		if (!isNumber(event.data) && cNumber2.value.length < 10) {
			showMessage('red', 'Only Numbers are allowed!')
		}
	}
})

addCompany.addEventListener('click', function (event) {
	event.preventDefault()
	let companyName, companyAddress, gstinNumber, contactPersonI, contactPersonII, contactNumberI, contactNumberII
	companyName = cName.value
	companyAddress = cAddress.value
	gstinNumber = cgstin.value
	contactPersonI = cPerson1.value
	contactPersonII = cPerson2.value
	contactNumberI = cNumber1.value
	contactNumberII = cNumber2.value
	cId = document.querySelector('#cId')
	// Validations
	if (companyName == '') {
		showMessage('red', 'Enter Company Name')
		cName.focus()
	}
	else if(gstinNumber == ''){
		showMessage('red', 'GSTIN is Required')
		cgstin.focus()
	}
	else if(gstinNumber.length < 15){
		showMessage('red', 'Invalid GSTIN number')
		cgstin.focus()
	}
	else if(contactPersonI == ''){
		showMessage('red', 'Enter Contact Person')
		cPerson1.focus()
	}
	else if(contactNumberI == ''){
		showMessage('red', 'Mobile Number is Required')
		cNumber1.focus()
	}
	else if(contactNumberI.length < 10){
		showMessage('red', 'Invalid Mobile Number')
		cNumber1.focus()
	}
	else if(companyAddress == ''){
		showMessage('red', 'Enter Comapany Address')
		cAddress.focus()
	}
	else{
		// Ajax Call to Insert Company in Database
		let xhttp = new XMLHttpRequest()
		xhttp.onreadystatechange = function() {
			if (this.readyState == 1) {
				addCompany.disabled = true
				addCompany.innerHTML = 'Updating...'
			}
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == 'Success') {
					heading.innerHTML = companyName+ ' Updated'
					showMessage('green', 'Company Profile Updated Successfully')
					inputWrapper.innerHTML = 'Details Updated'
					setTimeout(function () {
						history.back()
					}, 3000)
				}
				else if(this.responseText == 'Failure'){
					heading.innerHTML = 'Error'
					showMessage('red', 'Unable To Update Company Details')
					inputWrapper.innerHTML = 'Having Trouble in Updating Company Details Try Again'
				}
			}
		}
		xhttp.open("POST", "../api/updateCompany.php", true)
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xhttp.send(`id=${cId.value}&name=${companyName}&address=${companyAddress}&gstin=${gstinNumber}&cp1=${contactPersonI}&cn1=${contactNumberI}&cp2=${contactPersonII}&cn2=${contactNumberII}`)
	} // else
}) /// Closing Event listner Function

cPerson1.addEventListener('input', function () {
	let personName = cPerson1.value
	if (!(personName == '')) {
		cNumber1.placeholder = 'Contact number of '+personName
	}
})

cPerson2.addEventListener('input', function () {
	let personName = cPerson2.value
	if (!(personName == '')) {
		cNumber2.placeholder = 'Contact number of '+personName
	}	
})

function showMessage(color, whatToShow) {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
	message.style.display = 'inline'
    message.className = "show"
    setTimeout(function(){ message.style.display = 'none'; message.className = ''; }, 3000)
}

function isNumber(value) {
	if (isNaN(value)) {
		return false
	}
	else{
		return true
	}
}