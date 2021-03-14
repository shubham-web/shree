// DOM Elements
const isNumber = value => !isNaN(value)
const showMessage = (color, whatToShow) => {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
	message.style.display = 'inline'
    message.className = "show"
    setTimeout(function(){ message.style.display = 'none'; message.className = ''; }, 3000)
}
const qs = selector => document.querySelector(selector)
const name = qs('#name')
const edu = qs('#edu')
const mobile = qs('#mobile')
const aadhar = qs('#aadhar')
const date = qs('#date')
const salary = qs('#salary')
const addEmployee = qs('#addEmployee')
const heading = qs('#heading')
const inputWrapper = qs('#inputWrapper')
const message = qs('#message')
const backBtn = qs('#backIcon')
const employeeId = qs('#id')

// Event Listeners
backBtn.onclick = () => {
	window.history.back()
}
mobile.oninput = event => {
	let condition = !isNumber(event.data) || mobile.value.length > 10 || event.data == " "
	if (condition) {
		mobile.value = mobile.value.slice(0, length - 1)
		if (!isNumber(event.data) && mobile.value.length < 10) {
			showMessage('red', 'Only Numbers are allowed!')
		}
	}
}
addEmployee.onclick = event => {
	event.preventDefault()
	let employeeName, qualification, contact, aadharNumber, joiningDate, salaryAmount
	employeeName = name.value
	qualification = edu.value
	contact = mobile.value
	aadharNumber = aadhar.value
	joiningDate = date.value
	salaryAmount = salary.value
	// Validations
	if (employeeName == '') {
		showMessage('red', `Enter Employee's Name`)
		name.focus()
	}
	else if(contact != '' && (!isNumber(contact) || contact.length < 10)){
		showMessage('red', 'Invalid Mobile Number')
		mobile.focus()
	}
	else if(aadharNumber != '' && (!isNumber(aadharNumber) || aadharNumber.length < 12)){
		showMessage('red', 'Invalid Aadhar Number')
		aadhar.focus()
	}
	else if(salaryAmount != '' && !isNumber(salaryAmount)){
		showMessage('red', 'Only Numbers are allowed')
		salary.focus()
	}
	else{
		// Ajax Call to Insert Company in Database
		let xhttp = new XMLHttpRequest()
		xhttp.onreadystatechange = function() {
			if (this.readyState == 1) {
				addEmployee.disabled = true
				addEmployee.innerHTML = 'Saving...'
			}
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == 'Success') {
					heading.innerHTML = `${employeeName}'s Details Updated`
					showMessage('green', 'Employee Updated Successfully')
					inputWrapper.innerHTML = 'Details Saved'
					setTimeout(function () {
						history.back()
					}, 3000)
				}
				else if(this.responseText == 'Failure'){
					heading.innerHTML = 'Error'
					showMessage('red', 'Unable To Update Employee Details')
					inputWrapper.innerHTML = 'Having Trouble in Updating Employee Details Try Again!'
				}
			}
		}
		xhttp.open("POST", "../updateEmployee", true)
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xhttp.send(`id=${employeeId.value}&name=${employeeName}&edu=${qualification}&mobile=${contact}&aadhar=${aadharNumber}&date=${joiningDate}&salary=${salaryAmount}`)
	} // else
} /// Closing Event listner Function