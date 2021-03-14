// DOM Elements
const $ = selector => document.querySelector(selector)
const showMessage = (color, whatToShow) => {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
	message.style.display = 'inline'
    message.className = "show"
    setTimeout(() => { message.style.display = 'none'; message.className = ''; }, 3000)
}
const name = $('#name')
const gstin = $('#gstin')
const address = $('#address')
const desc = $('#desc')
const addVendor = $('#addVendor')

const heading = $('#heading')
const inputWrapper = $('#inputWrapper')
const message = $('#message')
const backBtn = $('#backIcon')

// Form Values
// Event Listeners

backBtn.onclick = () => { window.history.back() }

addVendor.onclick = event => {
	event.preventDefault()
	let vendorName, vendorAddress, gstinNumber, description
	vendorName = name.value
	vendorAddress = address.value
	gstinNumber = gstin.value
	description = desc.value
	// Validations
	if (vendorName == '') {
		showMessage('red', 'Enter Vendor Name')
		name.focus()
	}
	else if(gstinNumber == ''){
		showMessage('red', 'GSTIN is Required')
		gstin.focus()
	}
	else if(gstinNumber.length < 15){
		showMessage('red', 'Invalid GSTIN number')
		gstin.focus()
	}
	else if(vendorAddress == ''){
		showMessage('red', 'Vendor Address is Required')
		address.focus()
	}
	else{
		let xhttp = new XMLHttpRequest()
		xhttp.onreadystatechange = function () {
			if (this.readyState == 1) {
				addVendor.disabled = true
				addVendor.innerHTML = 'Saving...'
			}
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == 'Success') {
					heading.innerHTML = `${vendorName} Added`
					showMessage('green', 'Vendor Profile Added Successfully')
					inputWrapper.innerHTML = 'Details Saved'
					setTimeout(() => { history.back() }, 3000)
				}
				else if(this.responseText == 'Failure'){
					heading.innerHTML = 'Error'
					showMessage('red', 'Unable To Add Vendor Details')
					inputWrapper.innerHTML = 'Having Trouble in Adding Vendor Details Try Again'
				}
			}
		}
		xhttp.open("POST", "api/insertVendor.php", true)
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xhttp.send(`name=${vendorName}&address=${vendorAddress}&description=${description}&gstin=${gstinNumber}`)
	} // else
} /// Closing Event listner Function