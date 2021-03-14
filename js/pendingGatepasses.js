// DOM
const qs = selector => document.querySelector(selector)
const backIcon = qs('#backIcon')
const html = qs('html')
const searchBox = qs('#searchInput')
const companyName = document.querySelectorAll('.cName')
const gatepassNumber = document.querySelectorAll('.gatepassNumber')

// Event Listeners
qs('#searchIcon').addEventListener('click', () => searchInput.focus())
backIcon.addEventListener('click', () => { window.history.back() })
html.addEventListener('keydown', event => {
	if (event.key == 's' && event.altKey) searchBox.focus()
	if (event.key == 'n' && event.altKey) addNewBtn.click()
})

const viewPayment = eId => { expensesDetails(eId) }
searchBox.addEventListener('input', () => {
	let query = searchBox.value.toLowerCase()
	for (var i = 0; i < companyName.length; i++) {
		if ((companyName[i].innerText.toLowerCase().indexOf(query) == -1)) {
				companyName[i].parentElement.style.display = 'none'
				if (gatepassNumber[i].innerText.toLowerCase().indexOf(query) == -1) {
					gatepassNumber[i].parentElement.style.display = 'none'
				}
				else{
					gatepassNumber[i].parentElement.style.display = 'table-row'
				}
		}
		else{
			companyName[i].parentElement.style.display = 'table-row'
		}
	}
})

const viewRolls = (gatepassNumber, cId) => {
	viewPopup.click()
	qs('#rollsInfo').innerHTML = '<section id="logoSection"><img src="logo" id="logoImg" /><img src="gear" id="gearImg" /></section>'
	fetch(`fetchGatepass/${gatepassNumber}/${cId}`)
	.then(r => r.json())
	.then(fetchedRollsInfo =>{
		if (fetchedRollsInfo.length == 0) {
			document.querySelector('#rollsInfo').innerHTML = `<h3>No Remaining Rolls</h3>Gatepass will be pending until bill is generated.`
		}
		else{
			rollsQuantity = fetchedRollsInfo.length
			document.querySelector('#rollsInfo').innerHTML = '<tr><td>Quantity</td><td>Description</td></tr>'
			for (var i = 0; i < rollsQuantity; i++) {
				document.querySelector('#rollsInfo').innerHTML += `<tr><td>${fetchedRollsInfo[i]['quantity']}</td><td>${fetchedRollsInfo[i]['description']}</td></tr>`
			}
		}
	})
}

const dismissBtn = qs('#dismiss')
const viewPopup = qs('#view')
const popupBox = qs('#popupBox')
const content = qs('#content')
viewPopup.addEventListener('click', () => {
	popupBox.style.display = 'inline-block'
	setTimeout(() => { popupBox.style.opacity = 1; }, 200)
	setTimeout(() => { content.style.transform = 'translate(-50%,-50%) scale(1)' }, 300)
})
dismissBtn.addEventListener('click', () => {
	content.style.transform = 'translate(-50%,-50%) scale(0)'
	setTimeout(() => {
		popupBox.style.opacity = 0
		popupBox.style.display = 'none'
	}, 200)
})
window.addEventListener('click', event => {
	if (event.target == popupBox) dismissBtn.click()
})
window.addEventListener('keydown', event => {
	if (event.key == 'Escape')	dismissBtn.click()
})