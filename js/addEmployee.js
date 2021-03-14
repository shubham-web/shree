// DOM Elements
const $ = s => document.querySelector(s)
const isNumber = value => !isNaN(value)
const showMessage = (color, whatToShow) => {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
	message.style.display = 'inline'
    message.className = "show"
    setTimeout(() => { message.style.display = 'none'; message.className = ''; }, 3000)
}
const name = $('#name')
const edu = $('#edu')
const mobile = $('#mobile')
const aadhar = $('#aadhar')
const date = $('#date')
const salary = $('#salary')
const addEmployee = $('#addEmployee')
const heading = $('#heading')
const inputWrapper = $('#inputWrapper')
const message = $('#message')
const backBtn = $('#backIcon')

// Event Listeners
backBtn.onclick = () => window.history.back()
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
	else if (salaryAmount == '') {
		showMessage('red', `Enter Salary of ${employeeName}`)
		salary.focus()
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
					heading.innerHTML = `${employeeName}'s Details Saved`
					showMessage('green', 'Employee Added Successfully')
					inputWrapper.innerHTML = 'Details Saved'
					setTimeout(() => history.back(), 3000)
				}
				else if(this.responseText == 'Failure'){
					heading.innerHTML = 'Error'
					showMessage('red', 'Unable To Add Employee Details')
					inputWrapper.innerHTML = 'Having Trouble in Adding Employee Details Try Again!'
				}
				else{
					showMessage('red', this.responseText)
					console.log(this.responseText)
				}
			}
		}
		xhttp.open("POST", "saveEmployee", true)
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xhttp.send(`name=${employeeName}&edu=${qualification}&mobile=${contact}&aadhar=${aadharNumber}&date=${joiningDate}&salary=${salaryAmount}`)
	} // else
} // onreadystatechange