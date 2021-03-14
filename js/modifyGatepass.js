// Form Values
const name = document.querySelector('#name')
const gatepassNumber = document.querySelector('#gatepassNumber')
const gatepassId = document.querySelector('#gatepassId')
const date = document.querySelector('#date')
const message = document.querySelector('#message')
const mainContainer = document.querySelector('#tbody')
const heading = document.querySelector('#formHeading')
quantity = document.querySelectorAll('.quantity')
description = document.querySelectorAll('.description')

let addRowBtn = document.querySelector('#addRowBtn')
let removeBtn = document.querySelectorAll('.removeBtn')
let submitButton = document.querySelector('button[type="submit"]')
let rollBody = document.querySelector('#rollBody')
qty = []
des = []
rollsInfo = []
name.addEventListener('change', function () {
	if (name.value == '')
		document.querySelector('#companyId').value = "#ID"
	else
		document.querySelector('#companyId').value = "#"+name.value
	scrollBy(0, 200)
})
refreshValues = function () {
	rollsInfo = []
	quantity = document.querySelectorAll('.quantity')
	description = document.querySelectorAll('.description')
}
removeRow = function (event) {
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
		showMessage('grey', 'Can\'t Remove all Rows')
	}
}
for (let i = 0; i < removeBtn.length; i++){
	removeBtn[i].removeEventListener('click', removeRow)
	removeBtn[i].addEventListener('click', removeRow)
}
reArrangeSerial = function () {
	serialNumber = document.querySelectorAll('.serialNumber')
	for (let i = 0; i < serialNumber.length; i++) {
		serialNumber[i].innerHTML = i+1
	}
}
manageRemoveID = function () {
	removeBtn = document.querySelectorAll('.removeBtn')
	removeBtn[removeBtn.length - 1].id = removeBtn.length
}
manageRemoveID()
reArrangeSerial()
// Event Listeners 
addRowBtn.addEventListener('click', function (event) {
	event.preventDefault()

	// Copy Last Row
	rowToCopy  = document.querySelectorAll('.rowToCopy')
	row = rowToCopy[rowToCopy.length - 1].cloneNode(true)
	rollBody.appendChild(row) // Copy Row at last of tbody
	// Increase Serial Number
	reArrangeSerial()

	// Add IDs in Remove button
	manageRemoveID()

	for (let i = 0; i < removeBtn.length; i++){
		removeBtn[i].removeEventListener('click', removeRow)
		removeBtn[i].addEventListener('click', removeRow)
	}	
	scrollBy(0, 200)
})

document.addEventListener('keydown', function (event) {
	if (event.key == '+' && !event.ctrlKey) {
		addRowBtn.click()
	}
})
submitButton.addEventListener('click', function (event) {
	event.preventDefault()
	if (name.value == '') {
		showMessage('red', 'Select Company')
		name.focus()
	}
	else if(gatepassNumber.value == ''){
		showMessage('red', 'Gatepass Number is Required')
		gatepassNumber.focus()
	}
	else if(date.value == ''){
		showMessage('red', 'Enter Gatepass date')
		date.focus()
	}
	else{
		refreshValues()
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
				gpStatus = 'Pending'
				if (document.querySelector('#Pending').checked) {
					gpStatus = 'Pending'
				}
				if (document.querySelector('#Delivered').checked) {
					gpStatus = 'Delivered'
				}
				let saveGatepass = new XMLHttpRequest()
				saveGatepass.onreadystatechange = function() {
					if (saveGatepass.readyState == 1) {
						submitButton.disabled = true
						submitButton.innerHTML = 'Saving...'
					}
					if (saveGatepass.readyState == 4 && saveGatepass.status == 200) {
						if (saveGatepass.responseText == 'Success') {
							showMessage('green', 'Gatepass number '+ finalGatePassNumber +' Updated Successfully')
							heading.innerHTML = 'Success'
							mainContainer.innerHTML = '<p align="center">Gatepass number <b>'+finalGatePassNumber+'</b> Updated Successfully</p>'
							heading.parentElement.style.backgroundColor = 'green'
							heading.style.color = 'white'
							setTimeout(function () {
								history.back()
							}, 3000)
						}
						else if(saveGatepass.responseText == 'Failure'){
							showMessage('red', 'Failure')
							heading.innerHTML = 'Failure'
							mainContainer.innerHTML = '<p align="center">Having Trouble while Updating gatepass number <b>'+finalGatePassNumber+'</b></p>'
							heading.parentElement.style.backgroundColor = 'red'
							heading.style.color = 'white'
							setTimeout(function () {
								history.back()
							}, 4000)
						}
					}
				}
				saveGatepass.open("POST", "../updateGatepass", true)
				saveGatepass.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
				saveGatepass.send(`gatepassId=${gatepassId.value}&id=${finalCompanyID}&number=${finalGatePassNumber}&date=${finalDate}&rollsInfo=${finalRollsInfo}&status=${gpStatus}`)
			}// if no duplicate entry of particulars
		} // if valid
	}// else
})

function showMessage(color, whatToShow) {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
	message.style.display = 'inline'
    message.className = "show"
    setTimeout(function(){ message.style.display = 'none'; message.className = ''; }, 3000)
}
backBtn = document.querySelector('#backIcon')
backBtn.addEventListener('click', function () {
	window.history.back()
})