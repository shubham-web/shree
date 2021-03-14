// DOM Elements
const $ = query => document.querySelector(query)
const isNumber = value => !isNaN(value)
const showMessage = (color, whatToShow) => {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
	message.style.display = 'inline'
    message.className = "show"
    setTimeout(() => { message.style.display = 'none'; message.className = '' }, 3000)
}
const cName = $('#cName')
const cAddress = $('#cAddress')
const cgstin = $('#cGSTIN')
const cPerson1 = $('#cPerson1')
const cNumber1 = $('#cNumber1')
const cPerson2 = $('#cPerson2')
const cNumber2 = $('#cNumber2')
const addCompany = $('#addCompany')

const heading = $('#heading')
const inputWrapper = $('#inputWrapper')
const message = $('#message')
const backBtn = $('#backIcon')

// Event Listeners
cNumber1.oninput = event => {
	let condition = !isNumber(event.data) || cNumber1.value.length > 10 || event.data == " "
	if (condition) {
		cNumber1.value = cNumber1.value.slice(0, length - 1)
		if (!isNumber(event.data) && cNumber1.value.length < 10) {
			showMessage('red', 'Only Numbers are allowed!')
		}
	}
}
backBtn.onclick = () => { window.history.back() }

cNumber2.oninput =  event => {
	let condition = !isNumber(event.data) || cNumber2.value.length > 10 || event.data == " "
	if (condition) {
		cNumber2.value = cNumber2.value.slice(0, length - 1)
		if (!isNumber(event.data) && cNumber2.value.length < 10) {
			showMessage('red', 'Only Numbers are allowed!')
		}
	}
}

addCompany.onclick = event => {
	event.preventDefault()
	let companyName, companyAddress, gstinNumber, contactPersonI, contactPersonII, contactNumberI, contactNumberII
	companyName = cName.value
	companyAddress = cAddress.value
	gstinNumber = cgstin.value
	contactPersonI = cPerson1.value
	if (contactPersonII == '')
		contactPersonII = null
	else
		contactPersonII = cPerson2.value
	contactNumberI = cNumber1.value
	contactNumberII = cNumber2.value
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
		xhttp.onreadystatechange = function () {
			if (this.readyState == 1) {
				addCompany.disabled = true
				addCompany.innerHTML = 'Saving...'
			}
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == 'Success') {
					heading.innerHTML = `${companyName} Added`
					showMessage('green', 'Company Profile Added Successfully')
					inputWrapper.innerHTML = 'Details Saved'
					setTimeout(() => history.back() , 3000)
				}
				else if(this.responseText == 'Failure'){
					heading.innerHTML = 'Error'
					showMessage('red', 'Unable To Add Company Details')
					inputWrapper.innerHTML = 'Having Trouble in Adding Company Details Try Again'
				}
			}
		}
		xhttp.open("POST", "saveCompany", true)
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xhttp.send(`name=${companyName}&address=${companyAddress}&gstin=${gstinNumber}&cp1=${contactPersonI}&cn1=${contactNumberI}&cp2=${contactPersonII}&cn2=${contactNumberII}`)
	} // else
} // Closing Event listner Function

cPerson1.oninput = () => {
	let personName = cPerson1.value
	if (!(personName == '')) { cNumber1.placeholder = `Contact number of ${personName}` }
	else{ cNumber1.placeholder = `Optional` }
}

cPerson2.oninput = () => {
	let personName = cPerson2.value
	if (!(personName == '')) { cNumber2.placeholder = `Contact number of ${personName}` }
	else{ cNumber2.placeholder = `Optional` }
}
