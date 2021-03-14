const $ = query => document.querySelector(query)
const showMessage = (color, whatToShow) => {
	message.style.display = 'inline'
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
    message.className = "show"
    setTimeout(() => { message.style.display = 'none' }, 3000)
}
// Dom Element Variables
const dateObject = new Date()
const chalanDate = $('#chalanDate')
const companyId = $('#companyId')
const gatepassNumber = $('#gatepassNumber')
const backBtn = $('#backIcon')
const rollBody = $('#rollBody')
const rollInfoTable = $('#rollInfoTable')

let dd = dateObject.getDate()
let mm = dateObject.getMonth() + 1
let yyyy = dateObject.getFullYear()
if (dd < 10) { dd = `0${dd}` }
if (mm < 10) { mm = `0${mm}`}
let today = `${yyyy}-${mm}-${dd}`

chalanDate.value = today


// Event Listeners 
backBtn.onclick = () => window.history.back()
companyId.onchange = () => {
	rollBody.innerHTML = ''
	cId = companyId.value
	if (cId == '') {
		$('#cid').value = '#ID'
		gatepassNumber.innerHTML = `<option value="">---Select Company First---</option>`
		gatepassNumber.disabled = true
	}
	else{
		$('#cid').value = `#${cId}`
		xmlhttp = new XMLHttpRequest()
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 1) {
				gatepassNumber.innerHTML = `<option value="">Loading...</option>`
				gatepassNumber.disabled = true
			}
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == 'Not Found') {
					gatepassNumber.innerHTML = `<option value="false">No Pending Gatepasses Found</option>`
					gatepassNumber.disabled = true
				}
				else{
					gatepassNumber.innerHTML = this.responseText
					gatepassNumber.disabled = false
				}
			}
		}
		xmlhttp.open("GET", `fetchGatepasses/${cId}/Pending`, true)
		xmlhttp.send()
	}
}

gatepassNumber.onchange = () => {
	rollBody.innerHTML = ''
	if (!(gatepassNumber.value == '')) {
		gNumber = gatepassNumber.value
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function () {
			if (this.readyState == 1) {
				viewRollsBtn.innerHTML = 'Fetching Rolls Info...'
				viewRollsBtn.disabled = true
			}
			if (this.readyState == 4 && this.status == 200) {
				viewRollsBtn.innerHTML = 'View Rolls Info'
				viewRollsBtn.disabled = false
				output = JSON.parse(this.responseText)
				rollsInfo = output
				if (rollsInfo.length == 0) {
					viewRollsBtn.innerHTML ='Create Bill'
					viewRollsBtn.id = 'generateBill'
					showMessage('black', 'No Rolls Found')
					setTimeout(() => { window.location.reload()	}, 2000)
					$('#generateBill').onclick = () => { window.location.href = 'addBill.php' }
				}
				else{
					rollBody.innerHTML = ''
					for (let i = 0; i <= rollsInfo.length; i++) {
						row = document.createElement('TR')
						if (i == rollsInfo.length) {
							row.id = 'customEntry'
							for (let j = 0; j < 3; j++) {
								row.insertCell() // Just to insert 5 Empty TDs
							}
							// Add Checkbox inside First TD
							row.cells[0].innerHTML = `<input type="checkbox" class="checkBoxes" id="${i}" />`

							// Show Description in Second TD
							row.cells[1].innerHTML = `<input type="description" class='customParticular' disabled id='customDescription' placeholder="Description" />`

							// Show Quantity in third TD
							row.cells[2].colSpan = 2
							row.cells[2].style.textAlign = 'center'
							row.cells[2].innerHTML = `<input type="number" class='customParticular' id='deliveredRolls${i}' disabled placeholder='Quantity' min='1' />`
						}
						else{
							for (let j = 0; j < 4; j++) {
								row.insertCell() // Just to insert 5 Empty TDs
							}
							// Add Checkbox inside First TD
							row.cells[0].innerHTML = `<input type='checkbox' class='checkBoxes' id='${i}' />`

							// Show Description in Second TD
							row.cells[1].innerHTML = rollsInfo[i]['description']

							// Show Quantity in third TD
							row.cells[2].innerHTML = rollsInfo[i]['quantity']

							// Show input to take Deliver Roll in 4th TD
							row.cells[3].innerHTML = `<input type='number' id='deliveredRolls${i}' disabled title='Delivered Rolls' min='1' max='${rollsInfo[i]['quantity']}' size='5' />`
						} // Else Closed
						rollBody.appendChild(row)
					} // For Loop
				} // if rollsInfo != 0
			} // if Ready State 4 
		} // Function ReadystateChange
		xmlhttp.open("GET", `fetchGatepass/${gNumber}/${companyId.value}`)
		xmlhttp.send()
	} // if gatepassnumber == ''
} // Event Listener
$('#viewRollsBtn').onclick = event => {
	event.preventDefault()
	if(chalanDate.value == ''){
		showMessage('red', 'Enter Chalan Date')
		chalanDate.focus()
	}
	else if(companyId.value == ''){
		showMessage('red', 'Choose Company')
		companyId.focus()
	}
	else if(gatepassNumber.value == 'false'){
		showMessage('red', 'No Pending Gatepasses found with this Company')
		companyId.focus()
	}
	else if(gatepassNumber.value == ''){
		showMessage('red', 'Choose Gatepass Number')
		gatepassNumber.focus()
	}
	else{
		$('#rollsInfo').style.display = 'block'
		setTimeout(() => {
			$('#rollsInfo').style.transform = 'none'
			window.scrollBy(0, 1000)
		})
		$('#viewRollsBtn').style.display = 'none'
		chalanDate.disabled = true
		companyId.disabled = true
		gatepassNumber.disabled = true
		checkBoxes = document.querySelectorAll('.checkBoxes')
		for (let i = 0; i < checkBoxes.length; i++) {
			checkBoxes[i].addEventListener('click', function (event) {
				if (i == checkBoxes.length - 1) {
					if (this.checked) {
						event.target.parentElement.parentElement.className = 'active'
						$('#deliveredRolls'+event.target.id).disabled = false
						$('#customDescription').disabled = false
					}
					else{
						event.target.parentElement.parentElement.className = ''
						$('#deliveredRolls'+event.target.id).disabled = true
						$('#customDescription').disabled = true
					}
				}
				else{
					if (this.checked) {
						event.target.parentElement.parentElement.className = 'active'
						$('#deliveredRolls'+event.target.id).disabled = false
					}
					else{
						event.target.parentElement.parentElement.className = ''
						$('#deliveredRolls'+event.target.id).disabled = true
					}
				} // else
			})
		}
	}
}

$('#createChalan').onclick = event => {
	event.preventDefault()
	$('#createChalan').disabled = true
	allSetToGo = false
	activeRows = document.querySelectorAll('.active')
	if (activeRows.length == 0) {
		showMessage('red', 'Select At least one Row to Continue')
		$('#createChalan').disabled = false
	}
	else{
		deliveredRollsArray = []
		for (let i = 0; i < activeRows.length; i++) {
			deliveredRollsArray.push($(`#deliveredRolls${activeRows[i].rowIndex - 1}`))
		}
		deliveredRollsInfo = []
		for (let i = 0; i < activeRows.length; i++) {
			if (deliveredRollsArray[i].value == '') {
				deliveredRollsArray[i].focus()
				$('#createChalan').disabled = false
				break
			}
			else if (!deliveredRollsArray[i].checkValidity()){
				deliveredRollsArray[i].focus()
				showMessage('red',`Delivered Rolls Must be < Quantity > 0`)
				$('#createChalan').disabled = false
				break
			}
			else{
				deliveredRollsInfo.push(deliveredRollsArray[i].value)
			}
			if (i == activeRows.length-1) {
				if ($('#customDescription').disabled) {
					allSetToGo = true
				}
				else{
					if ($('#customDescription').value == '') {
						allSetToGo = false
						$('#customDescription').focus()
						$('#createChalan').disabled = false
					}
					else{
						allSetToGo = true
					}
				}
			}
		} // For Loop for validations
		if (allSetToGo) {
			date = chalanDate.value
			cId = companyId.value
			gNumber = gatepassNumber.value
			vehicleNumber = $('#vehicleNumber').value
			particularInfo = []
			for (var i = 0; i < activeRows.length; i++) {
				if (activeRows[i].id == 'customEntry') {
					desc = $('#customDescription').value
					qty = activeRows[i].cells[2].querySelector('input').value
				}
				else{
					desc = activeRows[i].cells[1].innerText
					qty = activeRows[i].cells[3].querySelector('input').value
				}
				particularInfo.push([qty, desc])
			} // For loop
			particularInfo = JSON.stringify(particularInfo)
			xhttp = new XMLHttpRequest()
			xhttp.onreadystatechange = function() {
				if (this.readyState == 1) {
					$('#createChalan').disabled = true
					$('#createChalan').innerHTML = 'Creating...'
				}
				if (this.readyState == 4 && this.status == 200) {
					if (this.responseText == 'Error') {
						alert('Error Saving Chalan')
						$('#createChalan').disabled = true
						$('#createChalan').innerHTML = 'Refresh & Try Again'
						showMessage('red', this.responseText)
					}
					else{
						let lastChalanNumber = this.responseText
						$('#createChalan').innerHTML = 'Redirecting...'
						setTimeout(() => {
							window.open(`chalan/${lastChalanNumber}`)
							window.history.back()
						}, 1200)
					}
				}
			}
			xhttp.open("POST", "api/saveChalan.php", true)
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
			xhttp.send(`date=${date}&companyId=${cId}&gNumber=${gNumber}&vehicleNumber=${vehicleNumber}&rollsInfo=${particularInfo}`)
		}// if allSet to Go
	} // Else
}