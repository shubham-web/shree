const $ = selector => document.querySelector(selector)
const showMessage = (color, whatToShow) => {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
    message.className = "show"
    setTimeout(() => { message.className = message.className.replace("show", "") }, 3000)
}
// DOM
const date = new Date()
yyyy = date.getFullYear()
dd = date.getDate()
mm = date.getMonth() + 1
if (dd < 10) { dd = `0${dd}` }
if (mm < 10) { mm = `0${mm}` }
const today = `${yyyy}-${mm}-${dd}`
const paymentDate = $('#date')
const companyId = $('#cId')
const companyIdBadge = $('#companyId')
const cash = $('#CASH')
const cheque = $('#CHEQUE')
const rtgs = $('#RTGS')
const amt = $('#amount')
const description = $('#description')
const submitBtn = $('#savePayment')
const heading = $('#formHeading')
const mainContainer = $('#tbody')
const pendingBillsBody = $('#pendingBillsBody')
// Event Listeners
window.onload = () => { paymentDate.value = today }
amt.addEventListener('keydown', event => {
	if (event.code == 'Space' && event.ctrlKey) {
		if (amt.value != '' && isNaN(amt.value)) amt.value =  eval(amt.value)
	}
})

backBtn = document.querySelector('#backIcon')
backBtn.onclick = () => window.history.back()

companyId.onchange = event => {
	if (companyId.value != '') {
		companyIdBadge.value = `#${companyId.value}`
		companyName = $(`[value='${companyId.value}']`).innerHTML
		$('#legend').innerHTML = `Unpaid Bills of ${companyName}`
		let getUnpaidBills = new XMLHttpRequest()
		let unpaidBills = ''
		getUnpaidBills.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				unpaidBills = JSON.parse(this.responseText)
				pendingBillsBody.innerHTML = ''
				if (unpaidBills.length == 0) {
					showMessage('black', `No Unpaid Bills Of ${$(`[value='${companyId.value}']`).innerHTML}`)
					$('#unpaidBillsRow').style.transform = 'scale(0)'
					setTimeout(() => {
						$('#unpaidBillsRow').style.display = 'none'
					}, 100)
				}
				else{
				totalDueAmount = 0;
				for (billInfo of unpaidBills) {
						row = document.createElement('TR')
						row.id = billInfo['billNumber']
						paymentStts = billInfo['paymentStts']
						let isPending = '', isPartial = ''
						if (paymentStts == 0) {	isPending = 'selected' }
						else if (paymentStts == 1) { isPartial = 'selected' }
						for (let j = 0; j < 7; j++) {
							row.insertCell()
						}
						row.cells[0].innerHTML = `<input type='checkbox' class='checkBoxes' id='cb${billInfo['billNumber']}' />`
						row.cells[1].innerHTML = `<label for="cb${billInfo['billNumber']}">${billInfo['billNumber']}</label>`
						row.cells[2].innerHTML = `Rs. ${billInfo['billTotal']}`
						row.cells[3].innerHTML = billInfo['paymentRecieved']

						row.cells[4].id = `due${billInfo['billNumber']}`
						// Due Amount
						row.cells[4].innerHTML = billInfo['billTotal'] - billInfo['paymentRecieved']
						totalDueAmount += eval(row.cells[4].innerHTML)
						row.cells[5].innerHTML = `<input type="text" class="amountInput" autocomplete="off" placeholder="Amount" id="recieved${billInfo['billNumber']}" disabled title="Enter Recieved Amount for Bill Number ${billInfo['billNumber']}"  />`
						row.cells[6].innerHTML = `
									<select name="status" class="selectStatus" disabled id="status${billInfo['billNumber']}">
										<option value="0" ${isPending}>Pending</option>
										<option value="1" ${isPartial}>Partial</option>
										<option value="2">Completed</option>
									</select>`
						pendingBillsBody.appendChild(row)
					} // For Loop
					console.log(`Total Due Amount of ${companyName} is Rs. ${totalDueAmount} `)
					$('#unpaidBillsRow').style.display = 'table-row'
					setTimeout(() => {
						scrollTo(0,210)
						$('#unpaidBillsRow').style.transform = 'none'
						amt.focus()
					}, 100)

					checkBoxes = document.querySelectorAll('.checkBoxes')
					for (let cb = 0; cb < checkBoxes.length; cb++) {
						checkBoxes[cb].onclick = event => {
								if (checkBoxes[cb].checked) {
									event.target.parentElement.parentElement.className = 'active'
									$(`#recieved${event.target.id.slice(2)}`).disabled = false
									$(`#status${event.target.id.slice(2)}`).disabled = false
								}
								else{
									event.target.parentElement.parentElement.className = ''
									$(`#recieved${event.target.id.slice(2)}`).disabled = true
									$(`#status${event.target.id.slice(2)}`).disabled = true
								}
						}
					} // for loop 
					amountInputs = document.querySelectorAll('.amountInput')
					for (let amtInput = 0; amtInput < amountInputs.length; amtInput++) {
						amountInputs[amtInput].oninput = event => {
							if ((isNaN(event.data) || event.data == ' ') && event.data !== null) {
								amountInputs[amtInput].value = amountInputs[amtInput].value.slice(0, amountInputs[amtInput].value.length - 1)
							}
							invoiceNumber = event.target.id.slice(8)
							dueAmount = eval($(`#due${invoiceNumber}`).innerText)
							if (amountInputs[amtInput].value != '' && amountInputs[amtInput].value > 0 && amountInputs[amtInput].value < dueAmount) {
								$(`#status${invoiceNumber} option[value="1"]`).selected = true
							}
							else if(amountInputs[amtInput].value != '' && amountInputs[amtInput].value > 0 && amountInputs[amtInput].value >= dueAmount){
								$(`#status${invoiceNumber} option[value="2"]`).selected = true
							}
							else{
								$(`#status${invoiceNumber} option[value="0"]`).selected = true
							}
						}
					}
				}
			} // When Response is Ready
			
		} // Ready State Function
		getUnpaidBills.open(`GET`, `unpaidBills/${companyId.value}`, true)
		getUnpaidBills.send()
	}
	else{
		companyIdBadge.value = '#ID'
		$('#unpaidBillsRow').style.transform = 'scale(0)'
		setTimeout(() => { $('#unpaidBillsRow').style.display = 'none'  }, 100)
	}
}

submitBtn.onclick = event => {
	event.preventDefault()
	if (paymentDate.value == '') {
		showMessage('red', 'Enter Payment Date')
		paymentDate.focus()
	}
	else if (companyId.value == '') {
		showMessage('red', 'Select Company')
		companyId.focus()
	}
	else if(amt.value == ''){
		showMessage('red', 'Enter Payment Amount')
		amt.focus()
	}
	else if(isNaN(amt.value) || amt.value <= 0){
		showMessage('red', 'Invalid Amount')
		amt.focus()
	}
	else{
		activeRows = document.querySelectorAll('.active')
		if (activeRows.length == 0) {
			showMessage('red', 'Select At least One Bill')
		}
		else{
			isValid = false
			paymentInfo = []
			for (let row = 0; row < activeRows.length; row++) {
				tempBillNumber = activeRows[row].id
				dueAmount = $(`#due${tempBillNumber}`).innerText.trim()
				recievedAmount = $(`#recieved${tempBillNumber}`).value
				if (recievedAmount == '' || recievedAmount < 1) {
					$(`#recieved${tempBillNumber}`).focus()
					showMessage('red', `Enter Amount for "${tempBillNumber}"`)
					isValid = false
					break
				}
				else if (isNaN(recievedAmount)) {
					$(`#recieved${tempBillNumber}`).focus()
					showMessage('red', `Invalid Amount for ${tempBillNumber}`)
					isValid = false
					break
				}
				else if (eval(recievedAmount) > eval(dueAmount)) {
					$(`#recieved${tempBillNumber}`).focus()
					showMessage('red', `Invalid Amount for "${tempBillNumber}"`)
					isValid = false
					break
				}	
				else{
					paymentInfo.push([tempBillNumber, eval(recievedAmount), eval($(`#status${tempBillNumber}`).value)])
					isValid = true
				}
			} // For Loop for payment info
			if (isValid) {
				totalRecievedAmount = 0
				for (let amtRecieved of paymentInfo) {
					totalRecievedAmount += amtRecieved[1]
				}
				if (amt.value != totalRecievedAmount) {
					showMessage('red', 'Amount Mismatched')
					amt.focus()
				}
				else{
					if (cash.checked) { mode = 'CASH' }
					else if (cheque.checked) { mode = 'CHEQUE' }
					else if(rtgs.checked){ mode = 'RTGS' }
					paymentInfo = JSON.stringify(paymentInfo)
					savePaymentDetails = new XMLHttpRequest()
					savePaymentDetails.onreadystatechange = function () {
						if (this.readyState == 1) {
							submitBtn.disabled = true
							submitBtn.innerHTML = 'Saving...'
						}
						if (this.readyState == 4 && this.status == 200) {
							if (this.responseText == 'Success') {
								showMessage('green', 'Payment Details Saved')
								heading.innerHTML = 'Success'
								mainContainer.innerHTML = '<p align="center">Payment Details Saved Successfully</p>'
								heading.parentElement.style.backgroundColor = 'green'
								heading.style.color = 'white'
								setTimeout(() => { history.back() }, 2000)
							}
							else if(this.responseText == 'Failure'){
								showMessage('red', 'Failure')
								heading.innerHTML = 'Failure'
								mainContainer.innerHTML = '<p align="center">Having Trouble while saving Payment Details</p>'
								heading.parentElement.style.backgroundColor = 'red'
								heading.style.color = 'white'
								setTimeout(() => { history.back() }, 3000)
							}
							else{
								showMessage('red', this.responseText)
							}
						}
					}
					savePaymentDetails.open('POST', 'savePayment', true)
					savePaymentDetails.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
					savePaymentDetails.send(`date=${paymentDate.value}&cId=${companyId.value}&mode=${mode}&amount=${amt.value}&paymentInfo=${paymentInfo}&description=${description.value}`)
				}
			}
		}
	}
}