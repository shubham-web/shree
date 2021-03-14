// DOM
const qs = selector => document.querySelector(selector)
const showMessage = (color, whatToShow) => {
	message.style.display = 'inline'
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
    message.className = "show"
    setTimeout(() => { message.style.display = 'none' }, 3000)
}

const backIcon = qs('#backIcon')
const createSalaryBtn = qs('#addNewBtn')
const message = qs('#message')
const salaryDate = qs('#salaryDate')
const workingDayInputs = document.querySelectorAll('.workingDays')

// Event Listeners
backIcon.addEventListener('click', () => { window.history.back() })

window.addEventListener('load', () => {
	const obDate = new Date()
	let yyyy = obDate.getFullYear()
	let dd = obDate.getDate()
	let mm = obDate.getMonth() + 1
	if (dd < 10) dd = `0${dd}`
	if (mm < 10) mm = `0${mm}`
	const today = `${yyyy}-${mm}-${dd}`
	salaryDate.value = today
})

for (let input of workingDayInputs) {
	input.addEventListener('blur', event => {
		const workingDays = event.target.value
		const employeeId = event.target.id.slice(5)
		if (workingDays != '' && !isNaN(workingDays)) {
			const salary = event.target.attributes['data-salary'].value
			const salaryBox = qs(`#slr_${employeeId}`).innerText = `Rs. ${workingDays * salary}`

			if (workingDays >= 0 && workingDays <= 31) {
				input.style.borderColor = 'green'
			}
			else{
				input.style.borderColor = 'red'
			}
		}
		else if (workingDays == '') {
			const salaryBox = qs(`#slr_${employeeId}`).innerText = ``
			input.style.borderColor = 'red'
		}
	})
}

createSalaryBtn.addEventListener('click', () => {
	let canContinue = false
	for (let input of workingDayInputs) {
		if (salaryDate.value == '') {
			salaryDate.focus()
			canContinue = false
			showMessage('red', 'Enter Date')
			break
		}
		else if (input.value == '') {
			input.focus()
			canContinue = false
			break
		}
		else if (input.value > 31 || input.value < 0 || isNaN(input.value)) {
			showMessage('red', 'Invalid Working Days')
			input.focus()
			canContinue = false
			break
		}
		else{
			canContinue = true
		}
	}
	if (canContinue) {
		createSalaryBtn.disabled = true
		createSalaryBtn.innerText = "Validating..."
		const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
		const sDateObject = new Date(salaryDate.value)
		let previousEntries
		fetch(`getSalaryMonths/${sDateObject.getMonth() + 1}/${sDateObject.getFullYear()}`)
		.then(response => response.text())
		.then(textReponse => {
			previousEntries = textReponse
			let canCreateSalary = false

			if (eval(previousEntries) > 0) {
				canCreateSalary = confirm(`${months[sDateObject.getMonth()]}'s Salary already created for ${previousEntries} Employees\nWant to Add more`)
			}
			else{
				canCreateSalary = true
			}
			if (canCreateSalary) {
				let attendance = []
				for (let input of workingDayInputs) {
					attendance.push({'id': input.id.slice(5), 'days': eval(input.value)})
				}
				const attendanceAsString = JSON.stringify(attendance)
				const createSalary = new XMLHttpRequest()
				createSalary.onreadystatechange = function () {
					if (createSalary.readyState == 1) {
						createSalaryBtn.disabled = true
						createSalaryBtn.innerText = "Wait..."
						for (let inputBox of workingDayInputs) inputBox.disabled = true
					}
					if (createSalary.readyState == 4 && createSalary.status == 200) {
						if (createSalary.responseText == '1') {
							createSalaryBtn.disabled = false
							createSalaryBtn.innerText = "Saved"
							showMessage('green', `Salary Created of all ${attendance.length} Employees`)
							setTimeout(() => {
								window.open(`salary/${salaryDate.value}`)
								window.history.back()
							}, 2000)
						}
						else if (createSalary.responseText == '0') {
							createSalaryBtn.innerText = "Unable To Save"	
							showMessage('red', `Error While Creating Salary | Check Your Inputs`)
							setTimeout(() => { window.location.reload() }, 2000)
						}
						else{
							showMessage('red', createSalary.responseText)
							createSalaryBtn.innerText = "Error"
						}

					}
				}
				createSalary.open("POST", "saveSalaryDetails", true)
				createSalary.setRequestHeader('Content-type', "application/x-www-form-urlencoded")
				createSalary.send(`date=${salaryDate.value}&attendance=${attendanceAsString}`)
			} // if (canCreateSalary)
			else{
				window.location.reload()
			}
		})
		.catch(error => console.error('Error:', error))
	} // if (canContinue)
})