// DOM
const invoiceNumber = qs('#invoiceNumber')
const purchaseDate = qs('#date')
const purchaseId = qs('#purchaseId')
const vendorId = qs('#vId')
const vendorIdBadge = qs('#companyId')
const amt = qs('#amount')
const total = qs('#totalAmount')
const tax = qs('#taxPercentage')
const description = qs('#description')
const submitBtn = qs('#saveExpenses')
const heading = qs('#formHeading')
const mainContainer = qs('#tbody')
// Event Listeners
backBtn = document.querySelector('#backIcon')
backBtn.addEventListener('click', function () {
	window.history.back()
})

vendorId.addEventListener('change', function () {
	scrollBy(0, 200)
	if (vendorId.value == '') {
		vendorIdBadge.value = '#ID'
	}
	else{
		vendorIdBadge.value = '#'+vendorId.value
	}
})
tax.addEventListener('input', function () {
	if (isNaN(tax.value)) {
		showMessage('red', 'Enter valid Percentage')
		total.value = ''
	}
	else{
		total.value = eval((amt.value * tax.value) / 100) + eval(amt.value)
	}
})
amt.addEventListener('input', function () {
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
submitBtn.addEventListener('click', function (event) {
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
		savePurchaseDetails = new XMLHttpRequest()
		savePurchaseDetails.onreadystatechange = function () {
			if (this.readyState == 1) {
				submitBtn.disabled = true
				submitBtn.innerHTML = 'Updating...'
			}
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == 'Success') {
					showMessage('green', 'Purchase Details Updated')
					heading.innerHTML = 'Success'
					mainContainer.innerHTML = '<p align="center">Purchase Details Updated Successfully</p>'
					heading.parentElement.style.backgroundColor = 'green'
					heading.style.color = 'white'
					setTimeout(function () {
						history.back()
					}, 3000)
				}
				else if(this.responseText == 'Failure'){
					showMessage('red', 'Failure')
					heading.innerHTML = 'Failure'
					mainContainer.innerHTML = '<p align="center">Having Trouble While Updating Expenses Details</p>'
					heading.parentElement.style.backgroundColor = 'red'
					heading.style.color = 'white'
					setTimeout(function () {
						history.back()
					}, 4000)
				}
			}
		}
		savePurchaseDetails.open('POST', '../updateExpenses', true)
		savePurchaseDetails.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
		savePurchaseDetails.send(`purchaseId=${purchaseId.value}&invoiceNumber=${invoiceNumber.value}&date=${purchaseDate.value}&id=${vendorId.value}&amt=${amt.value}&tax=${tax.value}&description=${description.value}`)
	}
})

function qs(selector) {
	return document.querySelector(selector)
}
function showMessage(color, whatToShow) {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
    message.className = "show";
    setTimeout(function(){ message.className = message.className.replace("show", ""); }, 3000);
}