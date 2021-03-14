// DOM 
const qs = selector => document.querySelector(selector)
const html = qs('html')
const addNewBtn = qs('#addNewBtn')
const reportBtn = qs('#reportBtn')
const searchBox = qs('#searchInput')
const vendorName = document.querySelectorAll('.vName')
const invoiceNumber = document.querySelectorAll('.invoiceNumber')
const date = document.querySelectorAll('.date')
// Event Listeners

addNewBtn.addEventListener('click', () => {
	window.location.href = 'addExpenses'
})
reportBtn.addEventListener('click', () => {
	window.location.href = 'purchaseReport'
})
html.addEventListener('keydown', event => {
	if (event.key == 's' && event.altKey) {
		searchBox.focus()
	}
	if (event.key == 'n' && event.altKey) {
		addNewBtn.click()
	}
})

const viewPayment = eId => { expensesDetails(eId) }
const update = eId => { window.location.href = `updateExpenses/${eId}` }

searchBox.addEventListener('input', () => {
	let query = searchBox.value.toLowerCase().trim()
	for (var i = 0; i < vendorName.length; i++) {
		if ((vendorName[i].innerText.toLowerCase().indexOf(query) == -1)) {
				vendorName[i].parentElement.style.display = 'none'
				if (date[i].innerText.toLowerCase().indexOf(query) == -1) {
						date[i].parentElement.style.display = 'none'
						if (invoiceNumber[i].innerText.toLowerCase().indexOf(query) == -1) {
								invoiceNumber[i].parentElement.style.display = 'none'
						}
						else{
							invoiceNumber[i].parentElement.style.display = 'table-row'
						}
				}
				else{
					date[i].parentElement.style.display = 'table-row'
				}
		}
		else{
			vendorName[i].parentElement.style.display = 'table-row'
		}
	}
})

const expensesDetails = eId => {
	viewPopup.click()
	qs('#expensesDetails').innerHTML = '<section id="logoSection"><img src="logo" id="logoImg" /><img src="gear" id="gearImg" /></section>'
	fetch(`fetchExpenses/${eId}`)
	.then(r => r.text())
	.then(txt =>{ qs('#expensesDetails').innerHTML = txt })
}

let dismissBtn = qs('#dismiss')
let viewPopup = qs('#view')
let popupBox = qs('#popupBox')
let content = qs('#content')
viewPopup.addEventListener('click', () => {
	popupBox.style.display = 'inline-block'
	setTimeout(() => { popupBox.style.opacity = 1 }, 200)
	setTimeout(() => { content.style.transform = 'translate(-50%,-50%) scale(1)' }, 300)
})
dismissBtn.addEventListener('click', () => {
	content.style.transform = 'translate(-50%,-50%) scale(0)'
	setTimeout(() => {
		popupBox.style.opacity = 0;
		popupBox.style.display = 'none'
	}, 200)
})
window.addEventListener('click', event => {
	if (event.target == popupBox) dismissBtn.click()
})
window.addEventListener('keydown', event => {
	if (event.key == 'Escape')  dismissBtn.click()
})