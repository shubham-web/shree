const $ = query => document.querySelector(query)
const showMessage = (color, whatToShow) => {
	message.style.display = 'inline'
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
    message.className = "show"
    setTimeout(() => { message.style.display = 'none' }, 3000)
}
const removeComma = id => {
	let withoutComma = ''
	for (var i = 0; i < $(id).innerText.length; i++) {
		if ($(id).innerText[i] != ',') { withoutComma += $(id).innerText[i] }
	}
	return eval(withoutComma)
}
// Dom Elements
const billNumber = $('#billNumber')
const billDate = $('#billDate')
const companyId = $('#companyId')
const gatepassNumber = $('#gatepassNumber')
const notifySound = $('#notifySound')
const backBtn = $('#backIcon')
const rollBody = $('#rollBody')
const rollInfoTable = $('#rollInfoTable')

// To fill Today's Date
const obDate = new Date()
let yyyy = obDate.getFullYear()
let dd = obDate.getDate()
let mm = obDate.getMonth() + 1
if (dd < 10) dd = `0${dd}`
if (mm < 10) mm = `0${mm}`
const today = `${yyyy}-${mm}-${dd}`
billDate.value = today

// Event Listeners 
backBtn.onclick = () => window.history.back()
window.onload = () => { setTimeout(() => { scrollTo(0,0) }, 100) }
notifySound.oncanplay = () => { soundLoaded = true }
notifySound.onerror = () => { soundLoaded = false }
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
		xmlhttp.onreadystatechange = function () {
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
		xmlhttp.open("GET", `fetchGatepasses/${cId}/Pending`, true)
		xmlhttp.send()
	}
}
const incrementBillNumber = lastBillNumber => {
	prefix = lastBillNumber.slice(0,2)
	billSerial = lastBillNumber.slice(2)
	
	for (serial of billSerial) {
		if (serial.indexOf(0) == -1) break
		prefix += serial
	} // For Loop

	newbillSerial = parseInt(billSerial)+1
	if (newbillSerial.toString().length > parseInt(billSerial).toString().length)
		if (prefix.length > 2)
			prefix = prefix.slice(0, prefix.length - 1)
	nextBillNumber = `${prefix}${newbillSerial}`
	return nextBillNumber
}
if ($('#lastBillNumber') !=null) {
	$('#lastBillNumber').ondblclick = e => {
		e.preventDefault()
		billNumber.value = incrementBillNumber($('#lastBillNumber').innerText)
	}
}
gatepassNumber.onchange = () => {
	rollBody.innerHTML = ''
	if (!(gatepassNumber.value == '')) {
		gNumber = gatepassNumber.value
		xmlhttp = new XMLHttpRequest()
		xmlhttp.onreadystatechange = function () {
			if (this.readyState == 1) {
				viewRollsBtn.innerHTML = 'Fetching Rolls Info...'
				viewRollsBtn.disabled = true
			}
			if (this.readyState == 4 && this.status == 200) {
				output = JSON.parse(this.responseText)
				if (output.length == 0) {
					fetchGatepassDetails = new XMLHttpRequest()
					fetchGatepassDetails.onreadystatechange = function () {
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
						row.cells[0].innerHTML = "<input type='checkbox' class='checkBoxes' id='"+i+"' />"

						// Show Description in Second TD
						row.cells[1].innerHTML = rollsInfo[i]['description']

						// Show Quantity in third TD
						row.cells[2].innerHTML = rollsInfo[i]['quantity']

						// Show input to take Delivered Roll in 4th TD
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
							$('#chalanBody').innerHTML = ''
							for (let loop = 0; loop < chalanEntries.length; loop++) {
								$('#chalanBody').innerHTML += `
								<tr>
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
					$('#viewRollsBtn').innerHTML = `Can't Create Bill`
					$('#viewRollsBtn').disabled = true
					setTimeout(() => { window.location.reload() }, 1600)
				}
			} // if Ready State 4 
		} // Function ReadystateChange
		xmlhttp.open("GET", `fetchGatepass/${gNumber}/${cId}`, true)
		xmlhttp.send()
	} // if gatepassnumber == ''
} // Event Listener
$('#viewRollsBtn').onclick = event => {
	event.preventDefault()
	if (billNumber.value == '') {
		showMessage('red', 'Enter Bill Number')
		billNumber.focus()
	}
	else if(billDate.value == ''){
		showMessage('red', 'Enter Bill Date')
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
		checkBillNumber = new XMLHttpRequest()
		checkBillNumber.onreadystatechange = function() {
			if(this.readyState == 1){
				viewRollsBtn.disabled = true
				viewRollsBtn.innerHTML = 'Validating...'	
			}
			if (this.readyState == 4 && this.status == 200) {
				viewRollsBtn.disabled = false
				viewRollsBtn.innerHTML = 'Continue'
				billExists = this.responseText
				if (billExists == 1) {
					showMessage('red', 'Bill Number Already Exists')
					billNumber.focus()
				}
				else{
					$('#chalanInfo').style.display = 'block'
					$('#rollsInfo').style.display = 'block'
					$('#addOn').style.display = 'block'
					$('#chalanInfoWrapper').style.display = 'table-cell'
					$('#addOnWrapper').style.display = 'table-cell'
					setTimeout(() => {
						window.scrollTo(0, 450);
						$('#rollsInfo').style.transform = 'none'
						$('#chalanInfo').style.transform = 'none'
						$('#addOn').style.transform = 'none'
					})
					viewRollsBtn.style.display = 'none'
					viewRollsBtn.disabled = true
					checkBoxes = document.querySelectorAll('.checkBoxes')
					for (let checkbox = 0; checkbox < checkBoxes.length; checkbox++) {
						checkBoxes[checkbox].onclick = event => {
								if (checkBoxes[checkbox].checked) {
									event.target.parentElement.parentElement.className = 'active'
									$(`#deliveredRolls${event.target.id}`).disabled = false
									$(`#price${event.target.id}`).disabled = false
								}
								else{
									event.target.parentElement.parentElement.className = ''
									$(`#deliveredRolls${event.target.id}`).disabled = true
									$(`#price${event.target.id}`).disabled = true
								}
						}
					} // for loop of checkboxes
					if ($('#hsn1').checked){ hsnCode = 8455 }
					else if($('#hsn2').checked){ hsnCode = 8456 }

					$('#tbody').innerHTML = `
					<tr>
						<td>HSN Code</td><td id="hc">${hsnCode}</td>
					</tr>
					<tr>
						<td>Bill Number</td><td id="bn">${billNumber.value}</td>
					</tr>
					<tr>
						<td>Bill Date</td><td id="bd">${billDate.value}</td>
					</tr>
					<tr>
						<td>Company ID</td><td id="ci">${cId}</td>
					</tr>
					<tr>
						<td>Gatepass Number</td><td id="gn">${gNumber}</td>
					</tr>
					<tr>
						<td>Vehicle Number</td><td id="vn">${vehicleNumber.value}</td>
					</tr>`
				}
			} // if Ready State 4 
		} // Function ReadystateChange
		checkBillNumber.open("POST", "checkBillNumber", true)
		checkBillNumber.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		checkBillNumber.send(`billNumber=${billNumber.value}`)	
	} // else
}
$('#calculate').onclick = event => {
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
			deliveredRollsArray.push($('#deliveredRolls'+(activeRows[i].rowIndex - 1)))
			priceArray.push($('#price'+(activeRows[i].rowIndex - 1)))
		}
		deliveredRollsInfo = []
		priceInfo = []
		for (let i = 0; i < activeRows.length; i++) {
			if (deliveredRollsArray[i].value == '') {
				deliveredRollsArray[i].focus()
				allSetToCalculate = false
				break
			}
			else if (priceArray[i].value == '' || priceArray[i].value < 1) {
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
					if ($('#incrementActive') != null) {
						if ($('#descInc').value == '') {
							$('#descInc').focus()
							allSetToCalculate = false
							break
						}
						else if($('#priceInc').value == '' || $('#priceInc').value < 1){
							$('#priceInc').focus()
							allSetToCalculate = false
							break
						}
						else if (isNaN($('#priceInc').value)) {
							$('#priceInc').focus()
							allSetToCalculate = false
							break	
						}
						else{
							deliveredRollsInfo.push(1)
							priceInfo.push(`+${$('#priceInc').value}`)
							allSetToCalculate = true
						}
					}
					if ($('#decrementActive') != null) {
						if ($('#descDec').value == '') {
							$('#descDec').focus()
							allSetToCalculate = false
							break
						}
						else if($('#priceDec').value == '' || $('#priceDec').value < 1){
							$('#priceDec').focus()
							allSetToCalculate = false
							break
						}
						else if (isNaN($('#priceDec').value)) {
							$('#priceDec').focus()
							allSetToCalculate = false
							break
						}
						else{
							deliveredRollsInfo.push(1)
							priceInfo.push(`-${$('#priceDec').value}`)
							allSetToCalculate = true
						}
					}
					if ($('#descriptionActive') != null) {
						if ($('#descriptionOnly').value == '') {
							$('#descriptionOnly').focus()
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
				$('#totalAmount').innerHTML = eval(total).toLocaleString()
				xmlhttp = new XMLHttpRequest()
				xmlhttp.onreadystatechange = function() {
					if(this.readyState == 1){
						$('#calculate').innerHTML = 'Calculating...'
					}
					if (this.readyState == 4 && this.status == 200) {
						setTimeout(function () {
							$('#amountsTable').style.transform = 'scale(1)'
							$('#amountsTable').style.display = 'table'
							$('#createBill').style.display = 'block'
							$('#calculate').style.transform = 'scale(0)'
							window.scrollTo(0, 1200)
						}, 500)

						notDisabled = document.querySelectorAll('input:not([disabled])')
						for (var i = 0; i < notDisabled.length; i++) {
							notDisabled[i].disabled = true
						}
						if (this.responseText == true) {
							$('#cgst').innerHTML = eval(total * 9 / 100).toLocaleString()
							$('#sgst').innerHTML = eval(total * 9 / 100).toLocaleString()
							$('#igst').innerHTML = '0'
							netAmountWithoutRoundOff = total + eval(total * 18 / 100)
							if (netAmountWithoutRoundOff == ~~netAmountWithoutRoundOff) {
								$('#roundOff').innerHTML = 0
							}
							else{
								$('#roundOff').innerHTML = (netAmountWithoutRoundOff - ~~netAmountWithoutRoundOff).toFixed(2)
							}
							$('#netAmount').innerHTML = eval(netAmountWithoutRoundOff - $('#roundOff').innerHTML).toLocaleString()
						}
						else{
							$('#cgst').innerHTML = '0'
							$('#sgst').innerHTML = '0'
							$('#igst').innerHTML = eval(total * 18 / 100).toLocaleString()
							netAmountWithoutRoundOff = total + eval(total * 18 / 100)
							if (netAmountWithoutRoundOff == ~~netAmountWithoutRoundOff) {
								$('#roundOff').innerHTML = 0
							}
							else{
								$('#roundOff').innerHTML = (netAmountWithoutRoundOff - ~~netAmountWithoutRoundOff).toFixed(2)
							}
							$('#netAmount').innerHTML = eval(netAmountWithoutRoundOff - $('#roundOff').innerHTML).toLocaleString()
						}
					} // if Ready State 4 
				} // Function ReadystateChange
				xmlhttp.open("GET", `sameState/${companyId.value}`, true)
				xmlhttp.send()
			}
			else{
				showMessage('red', 'Error')
			}
		}
	}
}
$('a[href="#chalanInfoWrapper"]').onclick = () => {
	setTimeout(() => { $('#chalanInfoWrapper').style.transform = 'scale(1.05)' }, 100)
	setTimeout(() => { $('#chalanInfoWrapper').style.transform = 'none' }, 300)
}
$('#incrementCheck').onclick = event => {
	if ($('#incrementCheck').checked) {
		event.target.parentElement.parentElement.id = 'incrementActive'
		$('#descInc').disabled = false
		$('#priceInc').disabled = false
	}
	else{
		event.target.parentElement.parentElement.id = ''
		$('#descInc').disabled = true
		$('#priceInc').disabled = true
	}
}
$('#decrementCheck').onclick = event => {
	if ($('#decrementCheck').checked) {
		event.target.parentElement.parentElement.id = 'decrementActive'
		$('#descDec').disabled = false
		$('#priceDec').disabled = false
	}
	else{
		event.target.parentElement.parentElement.id = ''
		$('#descDec').disabled = true
		$('#priceDec').disabled = true
	}
}
$('#descriptionCheck').onclick = event => {
	if ($('#descriptionCheck').checked) {
		event.target.parentElement.parentElement.id = 'descriptionActive'
		$('#descriptionOnly').disabled = false
	}
	else{
		event.target.parentElement.parentElement.id = ''
		$('#descriptionOnly').disabled = true
	}
}

$('#createBill').onclick = event => {
	event.preventDefault()
	number = $('#bn').innerText.trim()
	date = $('#bd').innerText.trim()
	cId = $('#ci').innerText.trim()
	gNumber = $('#gn').innerText.trim()
	vehicleNumber = $('#vn').innerText.trim()

	particularInfo = []
	for (var i = 0; i < activeRows.length; i++) {
		desc = activeRows[i].cells[1].innerText
		qty = activeRows[i].cells[3].querySelector('input').value
		price = activeRows[i].cells[4].querySelector('input').value
		total = eval(qty) * eval(price)
		particularInfo.push([desc, qty, price, total])
	}
	if ($('#incrementActive') != null) {
		descInc = $('#descInc').value
		qtyInc = 1
		priceInc = `+${$('#priceInc').value}`
		totalInc = eval(qtyInc) * eval(priceInc)
		particularInfo.push([descInc, qtyInc, priceInc, totalInc])
	}
	if ($('#decrementActive') != null) {
		descDec = $('#descDec').value
		qtyDec = 1
		priceDec = `-${$('#priceDec').value}`
		totalDec = eval(qtyDec) * eval(priceDec)
		particularInfo.push([descDec, qtyDec, priceDec, totalDec])
	}
	if ($('#descriptionActive') != null) {
		particularInfo.push([$('#descriptionOnly').value, 0, 0, 0])
	}
	particularInfo = JSON.stringify(particularInfo)
	totalAmount = removeComma('#totalAmount');
	cgst = removeComma('#cgst')
	sgst = removeComma('#sgst')
	igst = removeComma('#igst')
	roundOff = removeComma('#roundOff')
	netAmount = removeComma('#netAmount')

	xhttp = new XMLHttpRequest()
	xhttp.onreadystatechange = function() {
		if (this.readyState == 1) {
			$('#createBill').innerHTML = 'Validating...'
			$('#createBill').style.cursor = 'no-drop'
			$('#createBill').disabled = true
		}
		if (this.readyState == 2) {
			$('#createBill').innerHTML = 'Saving...'
			if (Notification.permission === 'granted') {
				let notify = new Notification(`Bill Number ${number} Generated`, {
					body: 'Ready To Print',
					silent: true,
					icon: 'img/shree.png'
				})
				if (soundLoaded) notifySound.play()
			}
		}
		if (this.readyState == 3) {
			$('#createBill').innerHTML = 'Generating PDF...'
		}
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == 'Success') {
				$('#createBill').innerHTML = 'Redirecting...'
				$('#createBill').disabled = true
				setTimeout(function () {
					window.location.href = 'bills'
					window.open(`bill/${number}`)
				}, 1200)
			}
			else{
				showMessage('red', this.responseText)
			}
		}
	}
	xhttp.open("POST", "generateBill", true)
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xhttp.send(`hsnCode=${hsnCode}&number=${number}&date=${date}&cId=${cId}&gNumber=${gNumber}&vehicleNumber=${vehicleNumber}&particularInfo=${particularInfo}&totalAmount=${totalAmount}&cgst=${cgst}&sgst=${sgst}&igst=${igst}&roundOff=${roundOff}&netAmount=${netAmount}`)
}