// DOM Elements
const isNumber = value => !isNaN(value)
const qs = selector => document.querySelector(selector)
const showMessage = (color, whatToShow) => {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
	message.style.display = 'inline'
    message.className = "show"
    setTimeout(() => { message.style.display = 'none'; message.className = ''; }, 3000)
}
const id = qs('#id')
const date = qs('#date')
const amount = qs('#amount')
const receiver = qs('#receiver')
const description = qs('#description')
const saveVoucher = qs('#saveVoucher')
const heading = qs('#heading')
const inputWrapper = qs('#inputWrapper')
const message = qs('#message')
const backBtn = qs('#backIcon')

// Event Listeners
backBtn.onclick = () => window.history.back()

saveVoucher.onclick = event => {
	event.preventDefault()
	// Validations
	if (date.value == '') {
		showMessage('red', `Enter Date`)
		date.focus()
	}
	else if(amount.value == ''){
		showMessage('red', 'Enter Amount')
		amount.focus()
	}
	else if (!isNumber(amount.value)) {
		showMessage('red', 'Invalid Amount')
		amount.focus()	
	}
	else{
		let xhttp = new XMLHttpRequest()
		xhttp.onreadystatechange = function() {
			if (this.readyState == 1) {
				saveVoucher.disabled = true
				saveVoucher.innerHTML = 'Updating...'
			}
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == 'Success') {
					heading.innerHTML = `Expenditure Details Updated`
					showMessage('green', `Voucher Updated Successfully`)
					inputWrapper.innerHTML = 'Details Saved'
					setTimeout(() => history.back(), 1500)
				}
				else if(this.responseText == 'Failure'){
					heading.innerHTML = 'Error'
					showMessage('red', 'Unable To Edit Voucher Details')
					inputWrapper.innerHTML = 'Having Trouble in Updating Expenditure Details Try Again!'
				}
				else{
					showMessage('red', this.responseText)
					heading.innerHTML = 'Error'
					inputWrapper.innerHTML = 'Having Trouble in Updating Expenditure Details Try Again!'
				}
			}
		}
		xhttp.open("POST", "../updateVoucher", true)
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xhttp.send(`id=${id.value}&date=${date.value}&amount=${amount.value}&receiver=${receiver.value}&description=${description.value}`)
	} // else
} // onreadystatechange