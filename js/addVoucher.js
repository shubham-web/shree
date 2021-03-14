// DOM Elements
const isNumber = value => !isNaN(value)
const $ = selector => document.querySelector(selector)
const showMessage = (color, whatToShow) => {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
	message.style.display = 'inline'
    message.className = "show"
    setTimeout(() => { message.style.display = 'none'; message.className = ''; }, 3000)
}
const date = $('#date')
const amount = $('#amount')
const receiver = $('#receiver')
const description = $('#description')
const saveVoucher = $('#saveVoucher')
const heading = $('#heading')
const inputWrapper = $('#inputWrapper')
const message = $('#message')
const backBtn = $('#backIcon')

const obDate = new Date()
let yyyy = obDate.getFullYear()
let dd = obDate.getDate()
let mm = obDate.getMonth() + 1
if (dd < 10) dd = `0${dd}`
if (mm < 10) mm = `0${mm}`
const today = `${yyyy}-${mm}-${dd}`
date.value = today

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
				saveVoucher.innerHTML = 'Saving...'
			}
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == 'Success') {
					heading.innerHTML = `Expenditure Details Saved`
					showMessage('green', `Voucher Added Successfully`)
					inputWrapper.innerHTML = 'Details Saved'
					setTimeout(() => history.back(), 1500)
				}
				else if(this.responseText == 'Failure'){
					heading.innerHTML = 'Error'
					showMessage('red', 'Unable To Save Voucher Details')
					inputWrapper.innerHTML = 'Having Trouble in Adding Expenditure Details Try Again!'
				}
				else{
					showMessage('red', this.responseText)
					heading.innerHTML = 'Error'
					inputWrapper.innerHTML = 'Having Trouble in Adding Expenditure Details Try Again!'	
				}
			}
		}
		xhttp.open("POST", "saveVoucher", true)
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		xhttp.send(`date=${date.value}&amount=${amount.value}&receiver=${receiver.value}&description=${description.value}`)
	} // else
} // onreadystatechange