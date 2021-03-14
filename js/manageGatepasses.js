// DOM Elements
const qs = selector => document.querySelector(selector)
const addGatepassBtn = qs('#addNewBtn') 
const reportBtn = qs('#reportBtn')
const companyName = document.querySelectorAll('.companyName')
const gatepassNumber = document.querySelectorAll('.gatepassNumber')
const gatepassDate = document.querySelectorAll('.gatepassDate')
const searchBox = qs('#searchInput')
const html = qs('html')

// Event Listeners
qs('#searchIcon').addEventListener('click', () => searchInput.focus())
addGatepassBtn.addEventListener('click', () => {
	window.location.href = 'newGatepass'
})
reportBtn.addEventListener('click', () => {
	window.location.href = 'pendingGatepasses'
})
searchBox.addEventListener('input', () => {
	let query = searchBox.value.toLowerCase().trim()
	for (var i = 0; i < companyName.length; i++) {
		if ((companyName[i].innerText.toLowerCase().indexOf(query) == -1)) {
				companyName[i].parentElement.style.display = 'none'
				if (gatepassNumber[i].innerText.toLowerCase().indexOf(query) == -1) {
					gatepassNumber[i].parentElement.style.display = 'none'
					if (gatepassDate[i].innerText.toLowerCase().indexOf(query) == -1) {
						gatepassDate[i].parentElement.style.display = 'none'
					}
					else{
						gatepassDate[i].parentElement.style.display = 'table-row'
					}
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

html.addEventListener('keydown', event => {
	if (event.key == 's' && event.altKey) {
		searchBox.focus()
	}
	else if (event.key == 'n' && event.altKey) {
		addNewBtn.click()
	}
})
const editGatepass = gpId => {
	window.location.href = `modifyGatepass/${gpId}`
}

const dismissBtn = qs('#dismiss')
const viewPopup = qs('#view')
const popupBox = qs('#popupBox')
const content = qs('#content')
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
	if (event.key == 'Escape') dismissBtn.click() 
})
const viewGatepass = gpId =>{
	viewPopup.click()
	qs('#body').innerHTML = `<section id="logoSection"><img src="logo" id="logoImg" /><img src="gear" id="gearImg" /></section>`
	fetch(`gatepassDetails/byId${gpId}`)
	.then(r =>r.text())
	.then(notation => {
		if (notation == 'Error') {
			qs('#body').innerHTML = `<h3 style="color:red;">Error While Fetching Gatepass Details</h3>`
		}
		else{
			const rollsDetails = JSON.parse(JSON.parse(notation))
			let rollData = ''
			for (let roll of rollsDetails) {
				rollData +=
				`<tr>
					<td>${roll['quantity']}</td>
					<td>${roll['description']}</td>
				</tr>`
			}
			qs('#body').innerHTML = 
			`<table>
				<thead>
					<th>Quantity</th><th>Description</th>
				</thead>
				<tbody>
					${rollData}
				</tbody>
			</table>
			`
		}
	})
}