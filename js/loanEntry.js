// DOM
const $ = s => document.querySelector(s)
const showMessage = (color, whatToShow) => {
	message.style.display = 'inline'
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
	message.className = "show"
	setTimeout(() => { message.style.display = 'none' }, 3000)
}
const backIcon = $('#backIcon')
const eIdBadge = $('#employeeId')
const message = $('#message')
const saveBtn = $('#saveBtn')
const heading = $('#formHeading')
const mainContainer = $('#tbody')
// Form Inputs
const date = $('#date')
const name = $('#name')
const totalDue = $('#totalDue')
const taken = $('#taken')
const returned = $('#returned')
const totalDueAfterToday = $('#totalDueAfterToday')
// EventListeners
backIcon.addEventListener('click', () => {
	window.history.back()
})
window.addEventListener('load', () => {
// To Autofill Today's Date in Loan Date Field
	const dateObject = new Date()
	let yyyy = dateObject.getFullYear()
	let dd = dateObject.getDate()
	let mm = dateObject.getMonth() + 1
	if (dd < 10) dd = `0${dd}`
	if (mm < 10) mm = `0${mm}`
	const today = `${yyyy}-${mm}-${dd}`
	date.value = today

	taken.disabled = returned.disabled = true
})
name.addEventListener('change', () =>{
	eIdBadge.value = (name.value == '') ? '#ID': `#${name.value}`
	if (name.value == '') {
		totalDue.value = 0
		taken.disabled = returned.disabled = true
	}
	else{
		totalDue.value = 'Fetching...'
		fetch(`getTotalDue/${name.value}`).then(r => r.text())
		.then(txt => {
			totalDue.value = `Rs. ${txt}`
			totalDueAfterToday.value = `Rs. ${txt}`
			taken.disabled = returned.disabled = false
			taken.value = returned.value = 0
			taken.focus()
		})
	}
})
const isNumber = val => !isNaN(val)
const preventChar = (event, object) => {
	let condition = !isNumber(event.data) || object.value.length > 10 || event.data == " "
	if (condition) {
		object.value = object.value.slice(0, length - 1)
		if (!isNumber(event.data) && object.value.length < 10) {
			if (isNaN(object.value) || object.value.includes('-')) {
				object.value = '0'
				showMessage('red', 'Enter Valid Amount!')
			}
		}
	}
}
taken.addEventListener('input', event => { preventChar(event, taken) })
returned.addEventListener('input', event => { preventChar(event, returned) })

taken.addEventListener('focus', () => { if (taken.value == '0') taken.value = '' })
returned.addEventListener('focus', () => { if (returned.value == '0') returned.value = '' })

taken.addEventListener('blur', () => { if (taken.value == '') taken.value = 0 })
returned.addEventListener('blur', () => { if (returned.value == '') returned.value = 0 })

const calculateDueAmt = () => {
	const takenAmt = (taken.value == '' || eval(taken.value) == '0') ? 0 : taken.value
	const returnedAmt = (returned.value == '' || eval(returned.value) == '0') ? 0 : returned.value
	totalDueAfterToday.value = `Rs. ${eval(totalDue.value.slice(4)) + eval(takenAmt) - eval(returnedAmt)}`
}

taken.addEventListener('input', calculateDueAmt)
returned.addEventListener('input', calculateDueAmt)

saveBtn.addEventListener('click', ev => {
	ev.preventDefault()
	let validationsDone = false
	if (date.value == '') {
		showMessage('red', 'Enter Loan Date')
		date.focus()
		validationsDone = false
	}
	else if (name.value == '') {
		showMessage('red', 'Select Employee Name')
		name.focus()
		validationsDone = false
	}
	else if ((taken.value == 0 || taken.value == '') && (returned.value == 0 || returned.value == '')) {
		showMessage('red', 'Enter Transaction Amount (Dr. or Cr.)')
		taken.focus()
		validationsDone = false
	}
	else if (isNaN(taken.value) || taken.value < 0) {
		showMessage('red', 'Enter Valid Amount')
		taken.focus()
		validationsDone = false
	}
	else if (isNaN(returned.value) || returned.value < 0) {
		showMessage('red', 'Enter Valid Amount')
		returned.focus()
		validationsDone = false
	}
	else if (totalDue.value.slice(4) - returned.value < 0) {
		showMessage('red', 'Returned Amount Should Be less Than Due')
		returned.focus()
		validationsDone = false
	}
	else{
		validationsDone = true
	}

	if (validationsDone) {
		const employeeName = $(`[value="${name.value}"]`).innerText
		const saveLoan = new XMLHttpRequest()
		saveBtn.disabled = true
		saveBtn.innerHTML = 'Saving...'
		saveLoan.onreadystatechange = function () {
			if (saveLoan.readyState == 4 && saveLoan.status == 200) {
				if (saveLoan.responseText == 'Success') {
					showMessage('green', `Loan Entry of ${employeeName} Saved Successfully`)
					heading.innerHTML = 'Success'
					mainContainer.innerHTML = `<p align="center">Loan Transaction of <b>${employeeName}</b> Saved Successfully</p>`
					heading.parentElement.style.backgroundColor = 'green'
					heading.style.color = 'white'
					setTimeout(() => { window.history.back() }, 1500)
				}
				else if(saveLoan.responseText == 'Failure'){
					showMessage('red', 'Failure')
					heading.innerHTML = 'Failure'
					mainContainer.innerHTML = `<p align="center">Having Trouble while saving Loan Transaction of <b>${employeeName}</b></p>`
					heading.parentElement.style.backgroundColor = 'red'
					heading.style.color = 'white'
					setTimeout(() => window.history.back(), 4000)
				}
				else{
					showMessage('red', 'Failure')
					heading.innerHTML = 'Failure'
					mainContainer.innerHTML = `<p align="center">${saveLoan.responseText}</p>`
					heading.parentElement.style.backgroundColor = 'red'
					heading.style.color = 'white'
				}
			}
		}
		saveLoan.open("POST", "saveLoan", true)
		saveLoan.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		saveLoan.send(`eId=${name.value}&date=${date.value}&taken=${taken.value}&returned=${returned.value}`)
	}
})