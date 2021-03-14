// DOM Elements
const id = document.querySelector('#id')
const name = document.querySelector('#name')
const gstin = document.querySelector('#gstin')
const address = document.querySelector('#address')
const description = document.querySelector('#description')
const updateVendor = document.querySelector('#updateVendor')

const heading = document.querySelector('#heading')
const inputWrapper = document.querySelector('#inputWrapper')
let message = document.querySelector('#message')

// Form Values
// Event Listeners

updateVendor.addEventListener('click', function (event) {
	event.preventDefault()
	event.preventDefault()
	let vendorName, vendorAddress, gstinNumber, vDescription
	vendorName = name.value
	vendorAddress = address.value
	gstinNumber = gstin.value
	vDescription = description.value
	vId = id.value
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
		// Ajax Call to Update Vendor Profile in Database
		let xhttp = new XMLHttpRequest()
		xhttp.onreadystatechange = function() {
			if (this.readyState == 1) {
				updateVendor.disabled = true
				updateVendor.innerHTML = 'Updating...'
			}
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == 'Success') {
					heading.innerHTML = vendorName+ ' Updated'
					showMessage('green', 'Vendor Profile Updated Successfully')
					inputWrapper.innerHTML = 'Details Updated'
					setTimeout(function () {
						history.back()
					}, 3000)
				}
				else if(this.responseText == 'Failure'){
					heading.innerHTML = 'Error'
					showMessage('red', 'Unable To Update Vendor Details')
					inputWrapper.innerHTML = 'Having Trouble in Updating Vendor Details Try Again'
				}
			}
		}
		xhttp.open("POST", "api/updateVendor.php", true)
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xhttp.send(`id=${vId}&name=${vendorName}&address=${vendorAddress}&gstin=${gstinNumber}&description=${vDescription}`)
	} // else
}) /// Closing Event listner Function


function showMessage(color, whatToShow) {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
	message.style.display = 'inline'
    message.className = "show"
    setTimeout(function(){ message.style.display = 'none'; message.className = ''; }, 3000)
}