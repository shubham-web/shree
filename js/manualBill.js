const qs = query => document.querySelector(query)
setTimeout(() => { scrollTo(0,0) }, 100)
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
// Dom Elements
const billNumber = qs(`#billNumber`)
const billDate = qs(`#billDate`)
const companyId = qs(`#companyId`)
const gatepassNumber = qs(`#gatepassNumber`)
const notifySound = qs(`#notifySound`)
const backBtn = qs(`#backIcon`)

let removeBtn = document.querySelectorAll('.removeBtn')
let particularBody = qs('#particularBody')
let addRowBtn = qs('#addRowBtn')
rs = []
qty = []
des = []
particularArray = []

let date = new Date()
dd = date.getDate()
mm = date.getMonth() + 1
yyyy = date.getFullYear()
if (dd < 10) { dd = `0${dd}` }
if (mm < 10) { mm = `0${mm}` }
let today = `${yyyy}-${mm}-${dd}`
billDate.value = today

backBtn.addEventListener('click', () => {
	window.history.back()
})

notifySound.addEventListener('canplay', () => {
	soundLoaded = true
})
notifySound.addEventListener('error', () => {
	soundLoaded = false
})

rollBody = qs('#rollBody')
rollInfoTable = qs('#rollInfoTable')
// Event Listeners 
companyId.addEventListener('change', () => {
	cId = companyId.value
	if (cId == '') {
		qs('#cid').value = '#ID'
		gatepassNumber.innerHTML = '<option value=\'\'>---Select Company First---</option>'
		gatepassNumber.disabled = true
	}
	else{
		qs('#cid').value = '#'+cId
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 1) {
				scrollTo(0, 100)
				gatepassNumber.innerHTML = '<option value=\'\'>Loading...</option>'
				gatepassNumber.disabled = true
			}
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == 'Not Found') {
					gatepassNumber.innerHTML = '<option value="">No Gatepasses Found</option>'
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
const incrementBillNumber = lastBillNumber => {
	prefix = lastBillNumber.slice(0,2)
	billSerial = lastBillNumber.slice(2)
	for (let i = 0; i < billSerial.length; i++) {
		if (billSerial[i].indexOf(0) == -1)	break
		prefix += billSerial[i]
	} // For Loop
	newbillSerial = parseInt(billSerial)+1
	if (newbillSerial.toString().length > parseInt(billSerial).toString().length)
		if (prefix.length > 2)
			prefix = prefix.slice(0, prefix.length - 1)
	nextBillNumber = `${prefix}${newbillSerial}`
	return nextBillNumber
}
qs('#lastBillNumber').addEventListener('dblclick', e => {
	e.preventDefault()
	billNumber.value = incrementBillNumber(qs('#lastBillNumber').innerText)
})

qs('#viewRollsBtn').addEventListener('click',  event => {
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
					viewRollsBtn.style.display = 'none'
					qs('#step2').style.display = 'table-cell'
					qs('#addOn').style.display = 'block'
					qs('#addOnWrapper').style.display = 'table-cell'
					setTimeout(() => {
						qs('#step2').style.transform = 'scale(1)'
						qs('#addOn').style.transform = 'none'
						window.scrollTo(0, 1200)
					}, 500)
					qs('#calculate').disabled = false
					if (qs('#hsn1').checked){
						hsnCode = 8455
					}
					else if(qs('#hsn2').checked){
						hsnCode = 8456
					}
					qs('#tbody').innerHTML = `<tr>
					<td>HSN Code</td><td id="hc">${hsnCode}</td></tr><tr>
					<td>Bill Number</td><td id="bn">${billNumber.value}</td></tr>
					<tr><td>Bill Date</td><td id="bd">${billDate.value}</td></tr><tr>
					<td>Company ID</td><td id="ci">${cId}</td></tr>
					<tr><td>Gatepass Number</td><td id="gn">${gatepassNumber.value}</td></tr>
					<tr><td>Vehicle Number</td><td id="vn">${vehicleNumber.value}</td>
					</tr>`
				}
			} // if Ready State 4 
		} // Function ReadystateChange
		checkBillNumber.open("POST", "checkBillNumber", true)
		checkBillNumber.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		checkBillNumber.send(`billNumber=${billNumber.value}`)
	} // else
})

const refreshValues = () => {
	quantity = document.querySelectorAll('.quantity')
	description = document.querySelectorAll('.description')
	price = document.querySelectorAll('.price')
} 
const removeRow = event => {
	event.preventDefault()
	if (!(event.target == removeBtn[0] && removeBtn.length == 1)) {
		for (let i = 0; i < removeBtn.length; i++) {
			if (event.target == removeBtn[i]) {
				particularBody.deleteRow(i)
			}
			removeBtn = document.querySelectorAll('.removeBtn')
			reArrangeSerial()
		}
	}
	else{
		showMessage('grey', `Can't Remove all Rows`)
	}
}
for (let i = 0; i < removeBtn.length; i++){
	removeBtn[i].removeEventListener('click', removeRow)
	removeBtn[i].addEventListener('click', removeRow)
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
manageRemoveID()
reArrangeSerial()
// Event Listeners 
addRowBtn.addEventListener('click', event => {
	event.preventDefault()

	// Copy Last Row
	rowToCopy  = document.querySelectorAll('.rowToCopy')
	row = rowToCopy[rowToCopy.length - 1].cloneNode(true)
	particularBody.appendChild(row) // Copy Row at last of tbody
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
qs('#calculate').addEventListener('click', event => {
	event.preventDefault()
	refreshValues()
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
		if (price[i].value == '' || price[i].value < 1) {
			price[i].focus()
			valid = false
			break
		}
		else if (isNaN(price[i].value)){
			price[i].focus()
			valid = false
			break	
		}
		else{
			valid = true
		}
		addOnInfo = []
		if (i == quantity.length - 1) {
			if (qs('#incrementActive') != null) {
				if (qs('#descInc').value == '') {
					qs('#descInc').focus()
					valid = false
					break
				}
				else if(qs('#priceInc').value == '' || qs('#priceInc').value < 1){
					qs('#priceInc').focus()
					valid = false
					break
				}
				else if (isNaN(qs('#priceInc').value)) {
					qs('#priceInc').focus()
					valid = false
					break
				}
				else{
					addOnInfo.push({quantity:1, description: qs('#descInc').value, price:`+${qs('#priceInc').value}`})
					valid = true
				}
			}
			if (qs('#decrementActive') != null) {
				if (qs('#descDec').value == '') {
					qs('#descDec').focus()
					valid = false
					break
				}
				else if(qs('#priceDec').value == '' || qs('#priceDec').value < 1){
					qs('#priceDec').focus()
					valid = false
					break
				}
				else if (isNaN(qs('#priceDec').value)) {
					qs('#priceDec').focus()
					valid = false
					break
				}
				else{
					addOnInfo.push({quantity:1, description: qs('#descDec').value, price:`-${qs('#priceDec').value}`})
					valid = true
				}
			}
			if (qs('#descriptionActive') != null) {
				if (qs('#descriptionOnly').value == '') {
					qs('#descriptionOnly').focus()
					valid = false
					break
				}
				else{
					addOnInfo.push({quantity: 0, description: qs('#descriptionOnly').value, price:0})
					valid = true
				}
			}
		}
	}
	if (valid) {
		refreshValues()
		particularArray = []
		for (let i = 0; i < quantity.length; i++) {
			qty[i] = quantity[i].value
			des[i] = description[i].value.trim()
			rs[i] = price[i].value.trim()
			particularArray[i] = {quantity: qty[i], description: des[i], price: rs[i]}
		}
		particularArray = particularArray.concat(addOnInfo)
		finalRollsInfo = particularArray
		duplicate = false
		for (var i = 0; i < particularArray.length; i++) {
			for (var j = 0; j < particularArray.length; j++) {
				if (i != j && particularArray[i]['description'] == particularArray[j]['description']) {
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
			total = 0
			for (let i = 0; i < finalRollsInfo.length; i++) {
				total += eval(finalRollsInfo[i]['quantity']) * eval(finalRollsInfo[i]['price'])
			}
			qs('#totalAmount').innerHTML = eval(total).toLocaleString()
			xmlhttp = new XMLHttpRequest()
			xmlhttp.onreadystatechange = function() {
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
					for (let i = 0; i < removeBtn.length; i++) {
						removeBtn[i].disabled = true
						removeBtn[i].style.display = 'none'
					}
					addRowBtn.disabled = true
					addRowBtn.style.display = 'none'
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
			xmlhttp.open("GET", `api/fetchGstin.php?companyId=${qs('#ci').innerText}`, true)
			xmlhttp.send()
		}// if no duplicate entry of particulars
	} // if valid
})
qs('#incrementCheck').addEventListener('click', function (event) {
	if (qs('#incrementCheck').checked) {
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
qs('#decrementCheck').addEventListener('click', event => {
	if (qs('#decrementCheck').checked) {
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
qs('#descriptionCheck').addEventListener('click', event => {
	if (qs('#descriptionCheck').checked) {
		event.target.parentElement.parentElement.id = 'descriptionActive'
		qs('#descriptionOnly').disabled = false
	}
	else{
		event.target.parentElement.parentElement.id = ''
		qs('#descriptionOnly').disabled = true
	}
})

qs('#createBill').addEventListener('click', event => {
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
	for (var i = 0; i < finalRollsInfo.length; i++) {
		desc = finalRollsInfo[i]['description']
		qty = finalRollsInfo[i]['quantity']
		price = finalRollsInfo[i]['price']
		total = eval(qty) * eval(price)
		particularInfo.push([desc, qty, price, total])
	}
	particularInfo = JSON.stringify(particularInfo)
	totalAmount = removeComma('#totalAmount')
	cgst = removeComma('#cgst')
	sgst = removeComma('#sgst')
	igst = removeComma('#igst')
	roundOff = removeComma('#roundOff')
	netAmount = removeComma('#netAmount')

	xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState == 1) {
				qs('#createBill').innerHTML = 'Validating...'
				qs('#createBill').style.cursor = 'no-drop'
				qs('#createBill').disabled = true
			}
			if (this.readyState == 2) {
				qs('#createBill').innerHTML = 'Saving...'
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
		xhttp.open("POST", "generateBill", true)
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xhttp.send(`hsnCode=${hsnCode}&number=${number}&date=${date}&cId=${cId}&gNumber=${gNumber}&vehicleNumber=${vehicleNumber}&particularInfo=${particularInfo}&totalAmount=${totalAmount}&cgst=${cgst}&sgst=${sgst}&igst=${igst}&roundOff=${roundOff}&netAmount=${netAmount}`)
})