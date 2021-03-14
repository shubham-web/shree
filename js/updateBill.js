const qs = selector => document.querySelector(selector)
const showMessage = (color, whatToShow) => {
	message.style.display = 'inline'
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
    message.className = "show"
    setTimeout(() => { message.style.display = 'none' }, 3000)
}
const removeComma = id => {
	withoutComma = ''
	for (var i = 0; i < qs(id).innerText.length; i++) {
		if (qs(id).innerText[i] != ',') {
			withoutComma += qs(id).innerText[i]
		}
	}
	return eval(withoutComma)
}
setTimeout(() => scrollTo(0,0) , 100)
// Dom Elements
const billNumber = qs('#billNumber')
const billDate = qs('#billDate')
const companyId = qs('#companyId')
const oldCID = qs('#oldCID')
const oldGPN = qs('#oldGPN')
const gatepassNumber = qs('#gatepassNumber')
const notifySound = qs('#notifySound')

window.addEventListener('load', () => {
	const obDate = new Date()
	let yyyy = obDate.getFullYear()
	let dd = obDate.getDate()
	let mm = obDate.getMonth() + 1
	if (dd < 10) dd = `0${dd}`
	if (mm < 10) mm = `0${mm}`
	const today = `${yyyy}-${mm}-${dd}`
	billDate.value = today

})
notifySound.addEventListener('canplay', () => { soundLoaded = true })
notifySound.addEventListener('error', () => { soundLoaded = false })

backBtn = document.querySelector('#backIcon')
backBtn.addEventListener('click', () => { window.history.back() })

rollBody = qs('#rollBody')
rollInfoTable = qs('#rollInfoTable')
// Event Listeners 
companyId.addEventListener('change', () => {
	rollBody.innerHTML = ''
	cId = companyId.value
	if (cId == '') {
		qs('#cid').value = '#ID'
		gatepassNumber.innerHTML = `<option value="">---Select Company First---</option>`
		gatepassNumber.disabled = true
	}
	else{
		qs('#cid').value = `#${cId}`
		xmlhttp = new XMLHttpRequest()
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 1) {
				scrollTo(0, 100)
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
		xmlhttp.open("GET", `fetchGatepasses/${cId}/Both`, true)
		xmlhttp.send()
	}
})

gatepassNumber.addEventListener('change', () => {
	rollBody.innerHTML = ''
	if (!(gatepassNumber.value == '')) {
		gNumber = gatepassNumber.value
		xmlhttp = new XMLHttpRequest()
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 1) {
				viewRollsBtn.innerHTML = 'Fetching Rolls Info...'
				viewRollsBtn.disabled = true
			}
			if (this.readyState == 4 && this.status == 200) {
				output = JSON.parse(this.responseText)
				if (output.length == 0) {
					fetchGatepassDetails = new XMLHttpRequest()
					fetchGatepassDetails.onreadystatechange = function() {
						if (fetchGatepassDetails.readyState == 4 && fetchGatepassDetails.status == 200) {
							rollsInfo = JSON.parse(this.responseText)
							rollsInfo = JSON.parse(rollsInfo)
					rollBody.innerHTML = ''
					for (let i = 0; i < rollsInfo.length; i++) {
						row = document.createElement('TR')
						for (let j = 0; j < 5; j++) {
							row.insertCell() // Just to insert 5 Empty TDs
						}
						// Add Checkbox inside First TD
						row.cells[0].innerHTML = `<input type='checkbox' class='checkBoxes' id='${i}' />`

						// Show Description in Second TD
						row.cells[1].innerHTML = rollsInfo[i]['description']

						// Show Quantity in third TD
						row.cells[2].innerHTML = rollsInfo[i]['quantity']

						// Show input to take Deliver Roll in 4th TD
						row.cells[3].innerHTML = "<input type='number' id='deliveredRolls"+i+"' disabled title='Delivered Rolls' min='1' max='"+rollsInfo[i]['quantity']+"' size='5' />"

						// Show input box in for price in fifth TD
						row.cells[4].innerHTML = "<input type='text' id='price"+i+"' disabled placeholder='Price'  />"
						rollBody.appendChild(row)
					} // For Loop

					 // For Fetching Chalan Details
					xhttp = new XMLHttpRequest()
					xhttp.onreadystatechange = function () {
						if (this.readyState == 4 && this.status == 200) {
							setTimeout(() => {
								viewRollsBtn.innerHTML = 'Continue'
								viewRollsBtn.disabled = false
							}, 200)
							chalanEntries = JSON.parse(this.responseText)
							qs('#chalanBody').innerHTML = ''
							for (let loop = 0; loop < chalanEntries.length; loop++) {
								qs('#chalanBody').innerHTML += `<tr>
								<td>${chalanEntries[loop]['rolls'][1]}</td>
								<td>${chalanEntries[loop]['rolls'][0]}</td>
								<td>${chalanEntries[loop]['date']}</td>
								<td>${chalanEntries[loop]['number']}</td>
								</tr>`
							}
						}
					}
					xhttp.open("POST", "api/fetchChalan.php", true)
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
					xhttp.send(`cId=${companyId.value}&gNumber=${gatepassNumber.value}`)
					} // if readystate == 4
				} // on ready state change function
				fetchGatepassDetails.open("GET", `gatepassDetails/${gNumber}`, true)
				fetchGatepassDetails.send()
				} // if output.length == 0
				else{
					showMessage('red', 'Some Chalans are remaining of this Gatepass Number')
					qs('#viewRollsBtn').innerHTML = 'Can\'t Create Bill'
					qs('#viewRollsBtn').disabled = true
					setTimeout(() => { window.location.reload() }, 1600)
				}
			} // if Ready State 4 
		} // Function ReadystateChange
		xmlhttp.open("GET", `fetchGatepass/${gNumber}/${cId}`, true)
		xmlhttp.send()
	} // if gatepassnumber == ''
}) // Event Listener
qs('#viewRollsBtn').addEventListener('click', event => {
	event.preventDefault()
	if (billDate.value == '') {
		showMessage('red', 'Enter Date')
		billDate.focus()
	}
	else if(companyId.value == ''){
		showMessage('red', 'Choose Company')
		companyId.focus()
	}
	else if(gatepassNumber.value == 'false'){
		showMessage('red', 'No Pending Gatepasses found')
		companyId.focus()
	}
	else if(gatepassNumber.value == ''){
		showMessage('red', 'Choose Gatepass Number')
		gatepassNumber.focus()
	}
	else{
		qs('#chalanInfo').style.display = 'block';
		qs('#rollsInfo').style.display = 'block';
		qs('#addOn').style.display = 'block';
		qs('#chalanInfoWrapper').style.display = 'table-cell';
		qs('#addOnWrapper').style.display = 'table-cell';
		setTimeout(() => {
			window.scrollTo(0, 450);
			qs('#rollsInfo').style.transform = 'none';
			qs('#chalanInfo').style.transform = 'none';
			qs('#addOn').style.transform = 'none';
		})
		viewRollsBtn.style.display = 'none'
		viewRollsBtn.disabled = true
		checkBoxes = document.querySelectorAll('.checkBoxes')
		for (let i = 0; i < checkBoxes.length; i++) {
			checkBoxes[i].addEventListener('click', function (event) {
					if (this.checked) {
						event.target.parentElement.parentElement.className = 'active'
						qs('#deliveredRolls'+event.target.id).disabled = false
						qs('#price'+event.target.id).disabled = false
					}
					else{
						event.target.parentElement.parentElement.className = ''
						qs('#deliveredRolls'+event.target.id).disabled = true
						qs('#price'+event.target.id).disabled = true
					}
			})
		} // for
		if (qs('#hsn1').checked){
			hsnCode = 8455
		}
		else if(qs('#hsn2').checked){
			hsnCode = 8456
		}
		qs('#tbody').innerHTML = `<tr>
		<td>HSN Code</td><td id="hc">${hsnCode}</td></tr><tr>
		<td>Bill Number</td><td id="bn">${billNumber.innerText}</td></tr>
		<tr><td>Bill Date</td><td id="bd">${billDate.value}</td></tr><tr>
		<td>Company ID</td><td id="ci">${cId}</td></tr>
		<tr><td>Gatepass Number</td><td id="gn">${gNumber}</td></tr>
		<tr><td>Vehicle Number</td><td id="vn">${vehicleNumber.value}</td>
		</tr>`
	} // else
})
qs('#calculate').addEventListener('click', event => {
	event.preventDefault()
	allSetToCalculate = false
	activeRows = document.querySelectorAll('.active')
	if (activeRows.length <= 0) {
		showMessage('red', 'Fill Particulars Info')
	}
	else{
		allSetToCalculate = false
		deliveredRollsArray = []
		priceArray = []
		for (let i = 0; i < activeRows.length; i++) {
			deliveredRollsArray.push(qs('#deliveredRolls'+(activeRows[i].rowIndex - 1)))
			priceArray.push(qs('#price'+(activeRows[i].rowIndex - 1)))
		}
		deliveredRollsInfo = []
		priceInfo = []
		for (let i = 0; i < activeRows.length; i++) {
			if (deliveredRollsArray[i].value == '') {
				deliveredRollsArray[i].focus()
				allSetToCalculate = false
				break
			}
			else if (priceArray[i].value == '') {
				priceArray[i].focus()
				allSetToCalculate = false
				break
			}
			else if (isNaN(priceArray[i].value)) {
				priceArray[i].focus()
				allSetToCalculate = false
				break			
			}
			else if (!deliveredRollsArray[i].checkValidity()){
				deliveredRollsArray[i].focus()
				showMessage('red','Invalid Quantity')
				allSetToCalculate = false
				break
			}
			else{
				deliveredRollsInfo.push(deliveredRollsArray[i].value)
				priceInfo.push(priceArray[i].value)
				allSetToCalculate = true
				if (i == activeRows.length-1) {
					if (qs('#incrementActive') != null) {
						if (qs('#descInc').value == '') {
							qs('#descInc').focus()
							allSetToCalculate = false
							break
						}
						else if(qs('#priceInc').value == ''){
							qs('#priceInc').focus()
							allSetToCalculate = false
							break
						}
						else if (isNaN(qs('#priceInc').value)) {
							qs('#priceInc').focus()
							allSetToCalculate = false
							break	
						}
						else{
							deliveredRollsInfo.push(1)
							priceInfo.push(`+${qs('#priceInc').value}`)
							allSetToCalculate = true
						}
					}
					if (qs('#decrementActive') != null) {
						if (qs('#descDec').value == '') {
							qs('#descDec').focus()
							allSetToCalculate = false
							break
						}
						else if(qs('#priceDec').value == ''){
							qs('#priceDec').focus()
							allSetToCalculate = false
							break
						}
						else if (isNaN(qs('#priceDec').value)) {
							qs('#priceDec').focus()
							allSetToCalculate = false
							break
						}
						else{
							deliveredRollsInfo.push(1)
							priceInfo.push(`-${qs('#priceDec').value}`)
							allSetToCalculate = true
						}
					}
					if (qs('#descriptionActive') != null) {
						if (qs('#descriptionOnly').value == '') {
							qs('#descriptionOnly').focus()
							allSetToCalculate = false
							break
						}
						else{
							deliveredRollsInfo.push(null)
							priceInfo.push(null)
							allSetToCalculate = true
						}
					}
				}
			}
		} // For Loop

		if (allSetToCalculate) {
			if (deliveredRollsInfo.length == priceInfo.length) {
				total = 0
				for (let i = 0; i < deliveredRollsInfo.length; i++) {
					total += eval(deliveredRollsInfo[i]) * eval(priceInfo[i])
				}	
				qs('#totalAmount').innerHTML = eval(total).toLocaleString()
				xmlhttp = new XMLHttpRequest()
				xmlhttp.onreadystatechange = function () {
					if(this.readyState == 1){
						qs('#calculate').innerHTML = 'Calculating...'
					}
					if (this.readyState == 4 && this.status == 200) {
						setTimeout(() => {
							qs('#amountsTable').style.transform = 'scale(1)'
							qs('#amountsTable').style.display = 'table'
							qs('#createBill').style.display = 'block'
							qs('#calculate').style.transform = 'scale(0)'
							window.scrollTo(0, 1200)
						}, 500)

						notDisabled = document.querySelectorAll('input:not([disabled])')
						for (var i = 0; i < notDisabled.length; i++) {
							notDisabled[i].disabled = true
						}
						if (this.responseText == true) {
							qs('#cgst').innerHTML = eval(total * 9 / 100).toLocaleString()
							qs('#sgst').innerHTML = eval(total * 9 / 100).toLocaleString()
							qs('#igst').innerHTML = '0'
							netAmountWithoutRoundOff = total + eval(total * 18 / 100)
							if (netAmountWithoutRoundOff == ~~netAmountWithoutRoundOff) {
								qs('#roundOff').innerHTML = 0
							}
							else{
								qs('#roundOff').innerHTML = (netAmountWithoutRoundOff - ~~netAmountWithoutRoundOff).toFixed(2)
							}
							qs('#netAmount').innerHTML = eval(netAmountWithoutRoundOff - qs('#roundOff').innerHTML).toLocaleString()
						}
						else{
							qs('#cgst').innerHTML = '0'
							qs('#sgst').innerHTML = '0'
							qs('#igst').innerHTML = eval(total * 18 / 100).toLocaleString()
							netAmountWithoutRoundOff = total + eval(total * 18 / 100)
							if (netAmountWithoutRoundOff == ~~netAmountWithoutRoundOff) {
								qs('#roundOff').innerHTML = 0
							}
							else{
								qs('#roundOff').innerHTML = (netAmountWithoutRoundOff - ~~netAmountWithoutRoundOff).toFixed(2)
							}
							qs('#netAmount').innerHTML = eval(netAmountWithoutRoundOff - qs('#roundOff').innerHTML).toLocaleString()
						}
					} // if Ready State 4 
				} // Function ReadystateChange
				xmlhttp.open("GET", `api/fetchGstin.php?companyId=${companyId.value}`, true)
				xmlhttp.send()
			}
			else{
				showMessage('red', 'Error')
			}
		}
	}
})
qs('#chalanLink').addEventListener('click', () => {
	setTimeout(() => { qs('#chalanInfoWrapper').style.transform = 'scale(1.05)' }, 100)
	setTimeout(() => { qs('#chalanInfoWrapper').style.transform = 'none' }, 300)
})
qs('#incrementCheck').addEventListener('click', function (event) {
	if (this.checked) {
		event.target.parentElement.parentElement.id = 'incrementActive'
		qs('#descInc').disabled = false
		qs('#priceInc').disabled = false
	}
	else{
		event.target.parentElement.parentElement.id = ''
		qs('#descInc').disabled = true
		qs('#priceInc').disabled = true
	}
})
qs('#decrementCheck').addEventListener('click', function (event) {
	if (this.checked) {
		event.target.parentElement.parentElement.id = 'decrementActive'
		qs('#descDec').disabled = false
		qs('#priceDec').disabled = false
	}
	else{
		event.target.parentElement.parentElement.id = ''
		qs('#descDec').disabled = true
		qs('#priceDec').disabled = true
	}
})
qs('#descriptionCheck').addEventListener('click', function (event) {
	if (this.checked) {
		event.target.parentElement.parentElement.id = 'descriptionActive'
		qs('#descriptionOnly').disabled = false
	}
	else{
		event.target.parentElement.parentElement.id = ''
		qs('#descriptionOnly').disabled = true
	}
})

qs('#createBill').addEventListener('click', function (event) {
	event.preventDefault()
	number = qs('#bn').innerText
	number = number.trim()

	date = qs('#bd').innerText
	date = date.trim()

	cId = qs('#ci').innerText
	cId = cId.trim()
	
	gNumber = qs('#gn').innerText
	gNumber = gNumber.trim()

	vehicleNumber = qs('#vn').innerText
	vehicleNumber = vehicleNumber.trim()

	particularInfo = []
	for (var i = 0; i < activeRows.length; i++) {
		desc = activeRows[i].cells[1].innerText
		qty = activeRows[i].cells[3].querySelector('input').value
		price = activeRows[i].cells[4].querySelector('input').value
		total = eval(qty) * eval(price)
		particularInfo.push([desc, qty, price, total])
	}
	if (qs('#incrementActive') != null) {
		descInc = qs('#descInc').value
		qtyInc = 1
		priceInc = '+'+qs('#priceInc').value
		totalInc = eval(qtyInc) * eval(priceInc)
		particularInfo.push([descInc, qtyInc, priceInc, totalInc])
	}
	if (qs('#decrementActive') != null) {
		descDec = qs('#descDec').value
		qtyDec = 1
		priceDec = '-'+qs('#priceDec').value
		totalDec = eval(qtyDec) * eval(priceDec)
		particularInfo.push([descDec, qtyDec, priceDec, totalDec])
	}
	if (qs('#descriptionActive') != null) {
		particularInfo.push([qs('#descriptionOnly').value, 0, 0, 0])
	}
	particularInfo = JSON.stringify(particularInfo)
	totalAmount = removeComma('#totalAmount');
	cgst = removeComma('#cgst')
	sgst = removeComma('#sgst')
	igst = removeComma('#igst')
	roundOff = removeComma('#roundOff')
	netAmount = removeComma('#netAmount')


	xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 1) {
				qs('#createBill').innerHTML = 'Validating...'
				qs('#createBill').style.cursor = 'no-drop'
				qs('#createBill').disabled = true
			}
			if (this.readyState == 2) {
				qs('#createBill').innerHTML = 'Updating...'
				if (Notification.permission === 'granted') {
					let notify = new Notification(`Bill Number ${number} Updated`, {
						body: 'Ready To Print',
						silent: true,
						icon: 'img/shree.png'
					})
					if (soundLoaded) notifySound.play()
				}
			}
			if (this.readyState == 3) {
				qs('#createBill').innerHTML = 'Generating PDF...'
			}
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == 'Success') {
					qs('#createBill').innerHTML = 'Redirecting...'
					qs('#createBill').disabled = true
					setTimeout(() => {
						window.location.href = 'bills'
						window.open(`bill/${number}`)
					}, 1200)
				}
				else{
					showMessage('red', this.responseText)
				}
			}
		}
		xhttp.open("POST", "updateBill", true)
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xhttp.send(`hsnCode=${hsnCode}&number=${number}&date=${date}&cId=${cId}&gNumber=${gNumber}&vehicleNumber=${vehicleNumber}&particularInfo=${particularInfo}&totalAmount=${totalAmount}&cgst=${cgst}&sgst=${sgst}&igst=${igst}&roundOff=${roundOff}&netAmount=${netAmount}&oldCID=${oldCID.value}&oldGPN=${oldGPN.value}`)
})