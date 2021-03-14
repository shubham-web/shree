// Form Values
const $ = selector => document.querySelector(selector)
const showMessage = (color, whatToShow) => {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
	message.style.display = 'inline'
    message.className = "show"
    setTimeout(() => { message.style.display = 'none'; message.className = ''; }, 3000)
}
const commonDescription = `ROLL SIZE () REGRINDING AND GROOVING WORK`
const name = $('#name')
const gatepassNumber = $('#gatepassNumber')
const date = $('#date')
const message = $('#message')
const mainContainer = $('#tbody')
const heading = $('#formHeading')
const backBtn = $('#backIcon')
	quantity = document.querySelectorAll('.quantity')
	description = document.querySelectorAll('.description')

let addRowBtn = $('#addRowBtn')
let removeBtn = document.querySelectorAll('.removeBtn')
let submitButton = $('button[type="submit"]')
let rollBody = $('#rollBody')

qty = []
des = []
rollsInfo = []

name.addEventListener('change', () => {
	if (name.value == '')
		$('#companyId').value = "#ID"
	else
		$('#companyId').value = `#${name.value}`
	scrollBy(0, 200)
})

backBtn.addEventListener('click', () => window.history.back() )

const refreshValues = () => {
	rollsInfo = []
	quantity = document.querySelectorAll('.quantity')
	description = document.querySelectorAll('.description')
}

const removeRow = event => {
	event.preventDefault()
	if (!(event.target == removeBtn[0] && removeBtn.length == 1)) {
		for (let i = 0; i < removeBtn.length; i++) {
			if (event.target == removeBtn[i]) {
				rollBody.deleteRow(i)
			}
			removeBtn = document.querySelectorAll('.removeBtn')
			reArrangeSerial()
		}
	}
	else{
		showMessage('orangered', 'Can\'t Remove all Rows')
	}
}

for (button of removeBtn){
	button.removeEventListener('click', removeRow)
	button.addEventListener('click', removeRow)
}

const reArrangeSerial = () => {
	serialNumber = document.querySelectorAll('.serialNumber')
	for (let i = 0; i < serialNumber.length; i++) {
		serialNumber[i].innerHTML = i+1
	}
}
const manageRemoveID = () => {
	removeBtn = document.querySelectorAll('.removeBtn')
	removeBtn[removeBtn.length - 1].id = removeBtn.length
}
const expandDescription = () =>{
	let descriptions = document.querySelectorAll('.description')
	for (let box of descriptions){
		box.onfocus = event => {
			box.rows = 3
		}
		box.onblur = event => {
			box.rows = 1
		}
		box.onkeydown = event => {
			if (event.ctrlKey && event.key == 'v') {
				event.preventDefault()
				box.value += commonDescription
			}
		}
	}
}
manageRemoveID()
reArrangeSerial()

// Event Listeners 
addRowBtn.addEventListener('click', event => {
	event.preventDefault()
	// Copy Last Row
	rowToCopy  = document.querySelectorAll('.rowToCopy')
	row = rowToCopy[rowToCopy.length - 1].cloneNode(true)
	rollBody.appendChild(row) // Copy Row at last of tbody

	// Increase Serial Number
	reArrangeSerial()
	// Add IDs in Remove button
	manageRemoveID()

	for (button of removeBtn){
		button.removeEventListener('click', removeRow)
		button.addEventListener('click', removeRow)
	}
	expandDescription()
	scrollBy(0, 200)
})

window.addEventListener('load', () => {
	const dateOb = new Date()
	const yyyy =dateOb.getFullYear()
	let dd = dateOb.getDate()
	let mm = dateOb.getMonth() + 1
	if (dd < 10) { dd = `0${dd}` }
	if (mm < 10) { mm = `0${mm}` }
	let today = `${yyyy}-${mm}-${dd}`
	date.value = today

	expandDescription()
})
document.addEventListener('keydown', event => {
	if (event.key == '+' && !event.ctrlKey) {
		addRowBtn.click()
	}
})
submitButton.addEventListener('click', event => {
	event.preventDefault()
	if (name.value == '') {
		showMessage('red', 'Select Company')
		name.focus()
	}
	else if(gatepassNumber.value == ''){
		showMessage('red', 'Enter Gatepass Number')
		gatepassNumber.focus()
	}
	else if(date.value == ''){
		showMessage('red', 'Enter Gatepass date')
		date.focus()
	}
	else{
		refreshValues()
		checkGatepass = new XMLHttpRequest()
		checkGatepass.onreadystatechange = function () {
			if(checkGatepass.readyState == 1){
				submitButton.disabled = true
				submitButton.innerHTML = 'Validating...'
			}
			if (checkGatepass.readyState == 4 && checkGatepass.status == 200) {
				gatepassExists = checkGatepass.responseText
				if (gatepassExists == 'exists') {
					submitButton.disabled = false
					submitButton.innerHTML = 'Save'
					showMessage('red', 'Gatepass Number Already Exists With This Company')
					gatepassNumber.focus()
					valid = false
				}
				else{
					submitButton.disabled = false
					submitButton.innerHTML = 'Save'
					for (let i = 0; i < quantity.length; i++) {
						if (quantity[i].value == '' || quantity[i].value < 1) {
							quantity[i].focus()
							valid = false
							break
						}
						else{
							valid = true
						}
						if (description[i].value == '') {
							description[i].focus()
							valid = false
							break
						}
						else{
							valid = true
						}
					}
					if (valid) {
						refreshValues()
						for (let i = 0; i < quantity.length; i++) {
							qty[i] = quantity[i].value
							des[i] = description[i].value.trim()
							rollsInfo[i] = {quantity: qty[i], description: des[i] }
						}
						finalCompanyID = name.value
						finalGatePassNumber = gatepassNumber.value
						finalDate = date.value
						finalRollsInfo = JSON.stringify(rollsInfo)
						duplicate = false
						for (var i = 0; i < rollsInfo.length; i++) {
							for (var j = 0; j < rollsInfo.length; j++) {
								if (i != j && rollsInfo[i]['description'] == rollsInfo[j]['description']) {
									duplicate = true
									break
								}
							}
							if (duplicate) {
								showMessage('red', 'Found Duplicate Entry of Particulars')
								break
							}
						}
						if (!duplicate) {
							// Ajax Call to Insert Gatepass Details in Database
							let saveGatepass = new XMLHttpRequest()
							saveGatepass.onreadystatechange = function() {
								if (saveGatepass.readyState == 1) {
									submitButton.disabled = true
									submitButton.innerHTML = 'Saving...'
								}
								if (saveGatepass.readyState == 4 && saveGatepass.status == 200) {
									if (saveGatepass.responseText == 'Success') {
										showMessage('green', 'Gatepass number '+ finalGatePassNumber +' Added Successfully')
										heading.innerHTML = 'Success'
										mainContainer.innerHTML = '<p align="center">Gatepass number <b>'+finalGatePassNumber+'</b> Added Successfully</p>'
										heading.parentElement.style.backgroundColor = 'green'
										heading.style.color = 'white'
										setTimeout(() => { window.history.back() }, 1500)
									}
									else if(saveGatepass.responseText == 'Failure'){
										showMessage('red', 'Failure')
										heading.innerHTML = 'Failure'
										mainContainer.innerHTML = '<p align="center">Having Trouble while saving gatepass number <b>'+finalGatePassNumber+'</b></p>'
										heading.parentElement.style.backgroundColor = 'red'
										heading.style.color = 'white'
										setTimeout(() => history.back(), 4000)
									}
								}
							}
							saveGatepass.open("POST", "saveGatepass", true)
							saveGatepass.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
							saveGatepass.send(`id=${finalCompanyID}&number=${finalGatePassNumber}&date=${finalDate}&rollsInfo=${finalRollsInfo}`)
						}// if no duplicate entry of particulars
					} // if valid
				} // else of gatepass number exists
			} // if Ready State 4 
		} // Function ReadystateChange
		checkGatepass.open("POST", "checkGatepass", true)
		checkGatepass.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		checkGatepass.send(`gatepassNumber=${gatepassNumber.value}&companyId=${name.value}`)
	}// else
})
