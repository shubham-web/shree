// DOM
const $ = selector => document.querySelector(selector)
const showMessage = (color, whatToShow) => {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
    message.className = "show"
    setTimeout(() => { message.className = message.className.replace("show", "") }, 3000)
}
const date = new Date()
dd = date.getDate()
mm = date.getMonth() + 1
if (dd < 10) { dd = `0${dd}`}
if (mm < 10) { mm = `0${mm}`}

let today = `${date.getFullYear()}-${mm}-${dd}`
const invoiceNumber = $('#invoiceNumber')
const purchaseDate = $('#date')
const vendorId = $('#vId')
const vendorIdBadge = $('#companyId')
const amt = $('#amount')
const total = $('#totalAmount')
const tax = $('#taxPercentage')
const description = $('#description')
const submitBtn = $('#saveExpenses')
const heading = $('#formHeading')
const mainContainer = $('#tbody')
const backBtn = $('#backIcon')
// Event Listeners
window.onload = () =>  { purchaseDate.value = today }
backBtn.onclick = () => { window.history.back() }

vendorId.onchange = () => {
	scrollBy(0, 200)
	if (vendorId.value == '') {
		vendorIdBadge.value = '#ID'
	}
	else{
		vendorIdBadge.value = `#${vendorId.value}`
	}
}
tax.addEventListener('input', () => {
	if (isNaN(tax.value)) {
		showMessage('red', 'Enter valid Percentage')
		total.value = ''
	}
	else{
		total.value = eval((amt.value * tax.value) / 100) + eval(amt.value)
	}
})
amt.addEventListener('input', () => {
	if (isNaN(amt.value)) {
		showMessage('red', 'Enter valid Amount')
		total.value = ''
	}
	else if (amt.value == ''){
		total.value = ''
	}
	else{
		total.value = eval((amt.value * tax.value) / 100) + eval(amt.value)
	}
})
submitBtn.addEventListener('click', event => {
	event.preventDefault()
	if (invoiceNumber.value == '') {
		showMessage('red', 'Enter Invoice Number')
		invoiceNumber.focus()
	}
	else if (purchaseDate.value == '') {
		showMessage('red', 'Enter Purchase Date')
		purchaseDate.focus()
	}
	else if (vendorId.value == '') {
		showMessage('red', 'Select Vendor')
		vendorId.focus()
	}
	else if(amt.value == ''){
		showMessage('red', 'Enter Purchase Amount')
		amt.focus()
	}
	else if(isNaN(amt.value) || amt.value <= 0){
		showMessage('red', 'Invalid Amount')
		amt.focus()
	}
	else if(tax.value == ''){
		showMessage('red', 'Enter Tax Percentage')
		tax.focus()
	}
	else if(isNaN(tax.value) || tax.value < 0){
		showMessage('red', 'Invalid Tax Percentage')
		tax.focus()
	}
	else{
		savePurchaseDetails = new XMLHttpRequest ()
		savePurchaseDetails.onreadystatechange = function () {
			if (this.readyState == 1) {
				submitBtn.disabled = true
				submitBtn.innerHTML = 'Saving...'
			}
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == 'Success') {
					showMessage('green', 'Purchase Details Saved')
					heading.innerHTML = 'Success'
					mainContainer.innerHTML = '<p align="center">Purchase Details Saved Successfully</p>'
					heading.parentElement.style.backgroundColor = 'green'
					heading.style.color = 'white'
					setTimeout(() => { history.back() }, 2000)
				}
				else if(this.responseText == 'Failure'){
					showMessage('red', 'Failure')
					heading.innerHTML = 'Failure'
					mainContainer.innerHTML = '<p align="center">Having Trouble While Saving Expenses Details</p>'
					heading.parentElement.style.backgroundColor = 'red'
					heading.style.color = 'white'
					setTimeout(() => { history.back() }, 3000)
				}
				else{
					showMessage('red', this.responseText)
					setTimeout(() => { history.back() }, 4000)
				}
			}
		}
		savePurchaseDetails.open('POST', 'saveExpenses', true)
		savePurchaseDetails.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
		savePurchaseDetails.send(`invoiceNumber=${invoiceNumber.value}&date=${purchaseDate.value}&id=${vendorId.value}&amt=${amt.value}&tax=${tax.value}&description=${description.value}`)
	}
})
