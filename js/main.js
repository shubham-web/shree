// DOM Elements
const qs = selector => document.querySelector(selector)
const showMessage = (color, whatToShow) => {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
    message.className = "show";
    setTimeout(() =>{message.className = message.className.replace("show", "")}, 3000)
}
const forgotPwd = qs('#frgtPWD')
const labelrememberMe = qs('label[for="remember"]')
const rememberMe = qs('#remember')
const showPwd = qs('#show')
const labelFrgtPwd = qs('label[for="frgtPWD"]')
const heading = qs('#heading')
const message = qs('#message')
const password = qs('input[type="password"]')
const submitButton = qs('input[type="submit"]')
const emailBox = qs('input[type="email"]')
const pwdBox = qs('input[type="password"]')

//  Event Listeners
forgotPwd.onclick = () => {
	heading.innerHTML = 'Forgot Password'
	heading.style.textTransform = 'capitalize'
	password.style.display = 'none'
	labelrememberMe.style.display = 'none'
	labelFrgtPwd.style.display = 'none'
	showPwd.style.display = 'none'
	forgotPwd.style.display = 'none'
	submitButton.value = 'Proceed'
	submitButton.disabled = false
}
showPwd.draggable = false
qs('#gearImg').draggable = false
qs('#logoImg').draggable = false
showPwd.onclick = () => { 
	if (password.type === 'password') {
		password.type = 'text'
		showPwd.style.backgroundColor = 'dodgerblue'
	}
	else{
		password.type = 'password'
		showPwd.style.backgroundColor = '#ccc'
	}
}
window.onload = () => {
	if (localStorage.rememberMe === 'true' && localStorage.DoxsG0tsqU !== undefined &&	localStorage.smtWZ86pA2 !== undefined) {
		clearInterval(checkStatus)
		redirect = new XMLHttpRequest()
		redirect.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText === 'Success') {
					window.location.href = 'dashboard'
				}
				else{
					localStorage.clear()	
					showMessage('red','Unable to Identify You | Login Again')
				}
			}
		}
		redirect.open("POST", "redirect", true)
		redirect.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		redirect.send(`email=${localStorage.DoxsG0tsqU}&password=${localStorage.smtWZ86pA2}`)
	}
	document.body.style.display = 'block'
}
// When Either Login of Proceed Button is clicked
submitButton.addEventListener('click', event => {
	event.preventDefault()
	// Validations For login form
	if (submitButton.value == 'Login') {
		if (emailBox.value == '' && pwdBox.value == '') {
			showMessage('red', 'Enter Credentials')
			emailBox.focus()
		}
		else if (emailBox.value == '' && pwdBox.value != '') {
			showMessage('red', 'Enter Email')
			emailBox.focus()
		}
		else if (emailBox.value != '' && pwdBox.value == '') {
			showMessage('red', 'Enter Password')
			pwdBox.focus()
		}
		else if (emailBox.value != '' && pwdBox.value != '') {
			if (!emailBox.checkValidity()) {
				emailBox.focus()
				showMessage('red', 'Invalid Email')
			}
			else{
				let enteredEmail = emailBox.value.toLowerCase()
				let enteredPwd = pwdBox.value
				let xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function () {
				   if (this.readyState == 1) {
						submitButton.disabled = true
				   		submitButton.value = 'Validating...'
				   		emailBox.disabled = true
				   		pwdBox.disabled = true
				   }
				   if (this.readyState == 4 && this.status == 200) {
				   		if (this.responseText == 'Success') {
						    submitButton.value = 'Redirecting...'
							submitButton.disabled = true
				   			let getHashedEmail = new XMLHttpRequest()
							getHashedEmail.onreadystatechange = function() {
							   if (this.readyState == 4 && this.status == 200) {
							   		localStorage.DoxsG0tsqU = this.responseText
							   		let getHashedPwd = new XMLHttpRequest()
									getHashedPwd.onreadystatechange = function() {
									   if (this.readyState == 4 && this.status == 200) {
									   		localStorage.smtWZ86pA2 = this.responseText
									   		localStorage.WARNING = `DON'T EDIT THESE VALUES`
								   			localStorage.rememberMe = rememberMe.checked
									   }
									}
									getHashedPwd.open("POST", "hash", true)
									getHashedPwd.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
									getHashedPwd.send(`string=${enteredPwd}`)

								    setTimeout(() => { window.location.replace("dashboard") }, 100)
							   }
							}
							getHashedEmail.open("POST", "hash", true)
							getHashedEmail.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
							getHashedEmail.send(`string=${enteredEmail}`)
				   		}
				   	 	else{
				   	 		showMessage('red', this.responseText)
					   		submitButton.value = 'Login'
							submitButton.disabled = false
							emailBox.disabled = false
					   		pwdBox.disabled = false
				   	 		pwdBox.focus()
				   	 	}
				   }
				}
				xhttp.open("POST", "auth", true)
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
				xhttp.send(`email=${enteredEmail}&password=${enteredPwd}`)
			}
		}
	}

	// Validations for Forgot Password Form
	else if(submitButton.value == 'Proceed'){
		if (emailBox.value == '') showMessage('red', 'Enter Email')
		if (emailBox.value != '') {
			if (!emailBox.checkValidity()) {
				emailBox.focus()
				showMessage('red', 'Invalid Email')
			}
			else{
				submitButton.disabled = true
				showMessage('green', 'Password reset link sent to your Email')
				setTimeout(() => { window.location.reload()	}, 2000)
			}
		}
	}
}) // Submit Button clicked

// To check login Status in every 0.5s
let checkStatus = setInterval(() => {
	if (localStorage.DoxsG0tsqU !== undefined && localStorage.smtWZ86pA2 !== undefined) {
		window.location.href = 'dashboard'
		clearInterval(checkStatus)
	}
}, 500)
// To Disable Right Click
document.oncontextmenu = event => event.preventDefault()